<?php

namespace App\Traits;

use App\Logic\Activation\ActivationRepository;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

trait ActivationTrait
{
    public function initiateEmailActivation(User $user)
    {
        // if (!config('settings.activation') || !$this->validateEmail($user)) {
        //     return true;
        // }

        $activationRepostory = new ActivationRepository();
        $activationRepostory->createTokenAndSendEmail($user);
    }

    public function initiateEmailActivationApi(User $user)
    {
        if (! config('settings.activation') || ! $this->validateEmail($user)) {
            return true;
        }

        $activationRepostory = new ActivationRepository();
        $activationRepostory->createTokenAndSendEmailApi($user);
    }

    protected function validateEmail(User $user)
    {
        $validator = Validator::make(['email' => $user->email], ['email' => 'required|email']);
        return !$validator->fails();
    }
}
