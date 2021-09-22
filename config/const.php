<?php

return [
    'authMaxAttempt' => env('AUTH_MAX_ATTEMPT', 3),
    'authThrottleTimeMin' => env('AUTH_THROTTLE_TIME_MIN', 1),
    'token' => env('AccessToken','Personal Access Token'),
];