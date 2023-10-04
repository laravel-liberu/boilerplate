<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSocial;
use Illuminate\Http\Request;
use LaravelEnso\Core\Traits\Login;
use LaravelEnso\Core\Traits\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    //
    public $maxAttempts;

    use AuthenticatesUsers, Logout, Login {
        Logout::logout insteadof AuthenticatesUsers;
        Login::login insteadof AuthenticatesUsers;
    }

    private ?User $user = null;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->maxAttempts = config('enso.auth.maxLoginAttempts');
    }

    // public function redirect($servive)
    // {
    //     return Socialite::driver($service)->redirect();
    // }

    //validate if the the provider is expected (facebook, google, github) 
    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['facebook', 'google', 'github'])) {
            return response()->json(['error' => 'Please login using facebook or google or github'], 422);
        }
    }

    //check if the user has socila linked
    public function needsToCreateSocial(User $user, $service)
    {
        return !$user->hasSocialLinked($service);
    }


    public function redirectToProvider($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function providerCallback($provider)
    {

        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (Exception) {
            return redirect(config('settings.clientBaseUrl') . '/social-callback?token=&status=false&message=Invalid credentials provided!');
        }

        $curUser = User::where('email', $user->getEmail())->first();

        try {
            if ($this->needsToCreateSocial($curUser, $provider)) {
                UserSocial::create([
                    'user_id' => $curUser->id,
                    'social_id' => $user->getId(),
                    'service' => $provider,
                ]);
            }
        } catch (Exception) {
            return redirect(config('settings.clientBaseUrl') . '/social-callback?token=&status=false&message=Something went wrong!');
        }

        //if the user exists then login:

        try {
            if ($this->needsToCreateSocial($curUser, $provider)) {
                UserSocial::create([
                    'user_id' => $curUser->id,
                    'social_id' => $user->getId(),
                    'service' => $provider,
                ]);
            }
        } catch (Exception) {
            return redirect(config('settings.clientBaseUrl') . '/social-callback?token=&status=false&message=Something went wrong!');
        }

        //check if the user is not blocked or something
        if ($this->loggableSocialUser($curUser)) {
            Auth::guard('web')->login($curUser, true);

            return redirect(config('settings.clientBaseUrl') . '/social-callback?token=' . csrf_token() . '&status=success&message=success');
        }

        return redirect(config('settings.clientBaseUrl') . '/social-callback?token=&status=false&message=Something went wrong while we processing the login. Please try again!');

    }

    private function loggableUser(Request $request)
    {
        $user = User::whereEmail($request->input('email'))->first();

        if (!optional($user)->currentPasswordIs($request->input('password'))) {
            return;
        }

        if (!$user->email) {
            throw ValidationException::withMessages([
                'email' => 'Email does not exist.',
            ]);
        }

        if ($user->passwordExpired()) {
            throw ValidationException::withMessages([
                'email' => 'Password expired. Please set a new one.',
            ]);
        }
        if ($user->isInactive()) {
            throw ValidationException::withMessages([
                'email' => 'Account disabled. Please contact the administrator.',
            ]);
        }

        if (!App::runningUnitTests()) {
            $company = $user->person->company();
            //            \Log::debug('Login----------------------'.$company);
            $tenant = false;
            if ($company) {
                $tenant = true;
            }
            // set company id as default
            $main_company = $user->person->company();
            if ($main_company !== null && !$user->isAdmin()) {
                $c_id = $main_company->id;
            }
            if (!$user->isAdmin()) {
                $tenants = Tenant::find($main_company->id);
            }
            if ($user->isAdmin()) {
                $tenants = null;
            }
            if ($main_company === null && !$user->isAdmin()) {
                //   if (($main_company == null||$tenants=='') && ! $user->isAdmin()) {
                //   if ($main_company == null) {
                $this->create_company($user);
            } elseif ($tenants && !$user->isAdmin()) {
                //                    $c = DB::connection('tenantdb',$tenants->tenancy_db_name)->table('users')->count();
                $company = \App\Models\Company::find($main_company->id);
                //                    \Log::debug('Database----------------------'.$main_company->id);
                tenancy()->initialize($tenants);
                $tenants->run(function () use ($company, $user) {
                    //  $company->save();
                    $c = User::count();
                    if ($c === 0) {
                        //  \Log::debug('Run Migration----------------------');
                        return Migration::dispatch($company, $user->name, $user->email, $user->password);
                    }
                    // \Log::debug($company->id.-'users----------------------'.$c);
                });
                tenancy()->end();
                return $user;
            }
        }

        return $user;
    }
}
