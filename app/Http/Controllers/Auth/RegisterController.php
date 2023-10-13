<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Person;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\ActivationTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LaravelLiberu\Roles\Models\Role;
use LaravelLiberu\UserGroups\Models\UserGroup;

class RegisterController extends Controller
{
    use RegistersUsers;
    use ActivationTrait;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);
    }

    /**
     * @LRDparam first_name required|string|max:255
     * @LRDparam last_name required|string|max:255
     * @LRDparam email required|string|email|max:255|unique:users
     * @LRDparam password required|string|min:5|confirmed
     *
     * @LRDparam responses 200,422
     */
    public function create(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return $validator->errors();
        }

        $person = new Person();
        $name = $request['first_name'] . ' ' . $request['last_name'];
        $person->name = $name;
        $person->email = $request['email'];
        $person->save();

        $user_group = UserGroup::where('name', 'Administrators')->first();
        if ($user_group === null) {
            $user_group = UserGroup::create(['name' => 'Administrators', 'description' => 'Administrator users group']);
        }

        $role = Role::where('name', 'free')->first();
        if ($role === null) {
            $role = Role::create(['menu_id' => 1, 'name' => 'free', 'display_name' => 'Supervisor', 'description' => 'Supervisor role.']);
        }

        $user = User::create([
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'person_id' => $person->id,
            'group_id' => $user_group->id,
            'role_id' => $role->id,
            'is_active' => 1,
        ]);

        $company = Company::create([
            'name' => $request['email'],
            'email' => $request['email'],
            'is_tenant' => 1,
            'status' => 1,
        ]);

        $person->companies()->attach($company->id, ['person_id' => $person->id, 'is_main' => 1, 'is_mandatary' => 1, 'company_id' => $company->id]);

        if ($request->selected_plan === '' || $request->selected_plan === $user->role_id) {
            $user->plan_id = '';
        } else {
            $user->plan_id = $request->selected_plan;
        }

        return $user;
    }
}
