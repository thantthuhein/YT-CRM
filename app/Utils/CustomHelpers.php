<?php

if (! function_exists('order')) {
    function order($page = 1, $count_per_page){
        return (($page - 1) * $count_per_page) + 1;
    }
}

if (! function_exists('get_sale_engineers')) {
    function get_sale_engineers() {
        return \App\User::whereHas('roles', function ($query) {
            $query->where('title', config('roles.enquiryInCharge'));
        })
        ->pluck('name', 'id')
        ->prepend(trans('global.pleaseSelect'), '');
    }
}