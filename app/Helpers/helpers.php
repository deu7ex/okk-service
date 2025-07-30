<?php

use App\Services\FakerService;

if (!function_exists('faker')) {
    function faker(): \Faker\Generator
    {
        return FakerService::get();
    }
}
