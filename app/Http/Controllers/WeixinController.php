<?php

namespace App\Http\Controllers;

use App\Libs\Common;
use App\Meihua;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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
            $input = [];
            if($message['MsgType'] == 'text'){
                if(preg_match('/^预测([\s\S]+)/',$message['Content'],$input)){
                    $word = $this->filter($input[1]);
                    if(strlen($word)<6 || strlen($word)>60){
                        return "回复：预测+你要测的事情简述，比如'预测我今天能否面试成功'，即可起卦，或者直接戳此链接：".$url;
                    }
                    $data['uid'] = $message['FromUserName'];
                    $data['problem_type'] = $this->identifyTextCategory($word);
                    $data['problem_text'] = $this->filter($message['Content']);
                    $data['ip'] = $message['FromUserName'];
                    $data['client_type'] = 'weixin';
                    $url = $this->qigua($data);
                    return "查看结果，戳此链接：$url";
                }
            }
            return "回复：预测+你要测的事情简述，比如'预测我今天能否面试成功',即可起卦，或者直接戳此链接：".$url;
        });
        $response = $app->server->serve();
        // 将响应输出
        $response->send();

    }
    private function filter($str =''){
        $str = trim($str);
        $str = Common::strFilter($str);
        $str = addslashes($str);
        return $str;
    }
    public function qigua($data=[]){
        $meihua = new Meihua;
        $url = $meihua->qiGuaByRand($data);
        return $url;
    }
    public function identifyTextCategory($text){
        //$text = $request->get('text');
        $api = 'http://127.0.0.1:8000/nlp?text='.$text;
        try{
            $res = file_get_contents($api);
        }catch (\Exception $e){
            return '';
        }
        if(!empty($res)){
            $res = json_decode($res,true);
            return $res['data'];
        }
        return '';
    }

}
