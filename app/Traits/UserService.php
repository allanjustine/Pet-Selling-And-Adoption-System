<?php 

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Str;
use App\Mail\AccountCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService {

    /**
     * create a login account for the newly created user
     *
     * @param Model $model
     * @param [type] $email
     * @return void
     */
    public function create_account(Model $model, $email, $role)
    {
        $password = Str::random(10); // the random password;

        $user = $model->user()->create([
            'email' => $email, 
            'password' => Hash::make($password), 
            'role_id' => $role, 
            'is_activated' => true 
        ]);   // create an account 

        Mail::to($user)->send( new AccountCreated($user, $password));  // notify user that the account has successfully created

        return;
    }

}