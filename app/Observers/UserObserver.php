<?php

namespace App\Observers;

use App\Helpers\File;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Facades\Hash;

class UserObserver
{


    public function creating(User $user)
    {
        //create file names
        if ($user->file){
            $user->file = File::save($user->file, $user->email);
        }
        if ($user->photo){
            $user->photo = File::save($user->photo, $user->phone);
        }

        $user->phone = str_replace(['-','(',')',' '],'',$user->phone);
    }


    /**
     * Handle the models user "created" event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {

    }

    /**
     * Handle the models user "updated" event.
     *
     * @param  User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the models user "deleted" event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }
}
