<?php

return [
    'authMaxAttempt' => env('AUTH_MAX_ATTEMPT', 3),
    'authThrottleTimeMin' => env('AUTH_THROTTLE_TIME_MIN', 1),
    'token' => env('AccessToken','Personal Access Token'),
    'personal_token_expires_in' => env('PERSONALTOKENEXPIRESIN',2),
    'remember_token_expires_in' => env('REMEMBERTOKENEXPIRESIN',1)
];