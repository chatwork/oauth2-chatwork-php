<?php

require 'vendor/autoload.php';
require 'vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

if (!function_exists('assertArrayNotHasKey')) {
    function assertArrayNotHasKey() {
        call_user_func_array('\PHPUnit\Framework\assertArrayNotHasKey', func_get_args());
    }
}
if (!function_exists('assertEquals')) {
    function assertEquals() {
        call_user_func_array('\PHPUnit\Framework\assertEquals', func_get_args());
    }
}

