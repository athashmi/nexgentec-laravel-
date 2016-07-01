<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Client ID
    |--------------------------------------------------------------------------
    |
    | The Client ID can be found in the OAuth Credentials under Service Account
    |
    */
    'client_id' => '103776567733546219685',

    /*
    |--------------------------------------------------------------------------
    | Service account name
    |--------------------------------------------------------------------------
    |
    | The Service account name is the Email Address that can be found in the
    | OAuth Credentials under Service Account
    |
    */
    'service_account_name' => 'google-calander@neural-land-116013.iam.gserviceaccount.com',

    /*
    |--------------------------------------------------------------------------
    | Calendar ID
    |--------------------------------------------------------------------------
    |
    | This is the Calender ID which is shared with all employees.
    |
    */
    'calendar_id' => 'adnan.nexgentec@gmail.com',

    /*
    |--------------------------------------------------------------------------
    | Key file location
    |--------------------------------------------------------------------------
    |
    | This is the location of the .p12 file from the Laravel root directory
    |
    */
    'key_file_location' => '/resources/assets/google-calander.p12',



     /*
    |--------------------------------------------------------------------------
    | gmail configuration
    |--------------------------------------------------------------------------
    |
    | 
    |
    */
    'email_address'      => 'adnan.nexgentec@gmail.com',
    'application_name'   => 'nexgentec',
    'credentials_path'   => '/resources/assets/gmail-php-quickstart.json',
    'client_secret_path' => '/resources/assets/client_secret.json',
];