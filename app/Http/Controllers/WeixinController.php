<?php

namespace App\Http\Controllers;

use App\Meihua;
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
        $message['Content'] = '预测微微';
        preg_match('/^预测(.+?)/',$message['Content'],$input);
        var_dump($input);
        exit;
        $app = Factory::officialAccount($this->config);

        $app->server->push(function ($message)  {
            $url = env('APP_URL');
            $input = [];
            if($message['MsgType'] == 'text'){
                if(preg_match('/^预测(.+?)/',$message['Content'],$input)){
                    if(empty($input[1])){
                        return "回复：预测+你要测的事情简述，比如'预测我今天能否面试成功'，即可起卦，或者直接戳此链接：".$url;
                    }
                    $data['uid'] = $message['FromUserName'];
                    $data['problem_type'] = '杂事';
                    $data['problem_text'] = $message['Content'];
                    $data['ip'] = $message['FromUserName'];
                    $data['client_type'] = 'weixin';
                    $url = $this->qigua($data);
                    return "查看结果，戳此链接：$url";
                }
            }
            return "您好！欢迎关注易学古今,我还会算卦哦,回复：预测+你要测的事情简述，即可起卦，或者直接戳此链接：".$url;
        });
        $response = $app->server->serve();
        // 将响应输出
        $response->send();

    }
    public function qigua($data=[]){
        $meihua = new Meihua;
        $url = $meihua->qiGuaByRand($data);
        return $url;
    }
}
