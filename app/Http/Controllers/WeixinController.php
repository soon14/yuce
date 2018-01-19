<?php

namespace App\Http\Controllers;

use EasyWeChat\Factory;
use Illuminate\Http\Request;

class WeixinController extends Controller
{

    protected $config;


    public function __construct()
    {
        $this->config = [
            'app_id'    => env('wx_app_id'),
            'secret'    => env('wx_secret'),
            'token'     => env('wx_token'),
            'log' => [
                'level' => 'debug',
                'file'  => storage_path('wx.log'),
            ],
            // ...
        ];
    }


    //验证消息
    public function send()
    {
        $app = Factory::officialAccount($this->config);

        $app->server->push(function ($message) {
            return "您好！欢迎使用 EasyWeChat!";
        });
        $response = $app->server->serve();
        // 将响应输出
        $response->send();

    }
    //检查签名
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = "weixin";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            return true;

        }else{
            return false;
        }
    }
    //响应消息
}
