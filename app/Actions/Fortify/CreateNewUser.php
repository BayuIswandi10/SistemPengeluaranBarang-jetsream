<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'nrp_karyawan' => ['required', 'string', 'max:255', 'unique:users,nrp_karyawan'], // Validasi NRP
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'seksi' => ['required', 'string', 'max:255'],
            'departemen' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
        
        return User::create([
            'nrp_karyawan' => $input['nrp_karyawan'], // Simpan NRP
            'name' => $input['name'],
            'email' => $input['email'],
            'seksi' => $input['seksi'],
            'departemen' => $input['departemen'],
            'level' => $input['level'],
            'password' => Hash::make($input['password']),
        ]);
        
    }
}
