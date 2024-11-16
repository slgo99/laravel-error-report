<?php

return [
    /**
     * Enable or disable the error report
     */
    'enabled' => env('ERROR_REPORT_ENABLED', false),

    /**
     * The emails to send the error report
     */
    'emails' => env('ERROR_REPORT_EMAILS', ''),
];
