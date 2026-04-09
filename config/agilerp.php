<?php

use App\Models\User;

return [

    /*
    |--------------------------------------------------------------------------
    | Model Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the model classes used throughout the application. Packages
    | and modules should use these config values for relationships.
    |
    */

    'models' => [
        'user' => User::class,
    ],

];
