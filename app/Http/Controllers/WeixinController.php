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
                'file'  => storage_path('logs/wx.log'),
            ],
            // ...
        ];
    }


    //发送消息
    public function send()
    {
        $app = Factory::officialAccount($this->config);

        $app->server->push(function ($message)  {
            $url = env('APP_URL');
            if(preg_match('/^我要/',$message)){
                return $message;
            }
            return "您好！欢迎关注易学古今,我还会算卦哦,戳此链接：".$url;
        });
        $response = $app->server->serve();
        // 将响应输出
        $response->send();

    }
    private function qigua(){

    }
}
