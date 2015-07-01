<?php
return [

    'Sandbox' => env('PAYPAL_SANDBOX'),
    'DeveloperAccountEmail' => env('PAYPAL_DEV_ACCOUNT_EMAIL'),
    'ApplicationID' => env('PAYPAL_APPLICATIONID'), //Paypal Sandbox AppId: APP-80W284485P519543T
    'DeviceID' => '',
    'IPAddress' => '',
    'APIUsername' => env('PAYPAL_APIUSERNAME'),
    'APIPassword' => env('PAYPAL_APIPASSWORD'),
    'APISignature' => env('PAYPAL_APISIGNATURE'),
    'PrintHeaders' => false,
    'LogResults' => false,
];