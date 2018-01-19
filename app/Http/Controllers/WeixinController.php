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
        $url = env('APP_URL');
        $short_url = $app->url->shorten($url);

        $app->server->push(function ($message) use ($short_url) {
            return "您好！欢迎关注易学古今,我还会算卦哦,戳此链接：".$short_url['short_url'];
        });
        $response = $app->server->serve();
        // 将响应输出
        $response->send();

    }
}
