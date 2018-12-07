<?php

namespace Starrysea\Curl\Tests;

use Starrysea\Curl\Curl;

class CurlGatherTest
{
    public static function get_curl()
    {
        return Curl::get_curl('https://github.com/caixingyue/laravel-starrysea-curl'); // get request

//        return Curl::get_curl('https://github.com/caixingyue/laravel-starrysea-curl', [
//            'title' => '你好, Laravel'
//        ]); // post request

//        return Curl::get_curl('https://github.com/caixingyue/laravel-starrysea-curl', [
//            'title' => '你好, Laravel'
//        ],[
//            'headers' => '星月来啦'
//        ]); // post and header request
    }

    public static function first()
    {
        return Curl::first()->get('https://github.com/caixingyue/laravel-starrysea-curl', [
            'title' => '你好, Laravel'
        ])->request(); // get request

//        return Curl::first()->post('https://github.com/caixingyue/laravel-starrysea-curl', [
//            'title' => '你好, Laravel'
//        ])->request(); // post request

//        return Curl::first()->get('https://github.com/caixingyue/laravel-starrysea-curl')->headers([
//            'title' => '你好, Laravel'
//        ])->request(); // get and header request
    }
}