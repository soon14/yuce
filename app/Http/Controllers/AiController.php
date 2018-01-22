<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Classification\NaiveBayes;

class AiController extends Controller
{
    //

    public function train(Request $request){
        $save = $request->get('save');
        if($save == 'yes'){
            $data = $request->get('data');

            $add_data = [];
            foreach ($data['text'] as $k=> $v){
                if(empty($v)){
                    continue;
                }
                $add_data[$k]['text'] = trim($v);
                $add_data[$k]['words'] = $this->get_words($v);
                $add_data[$k]['cate_key'] = $data['cate'][$k];
            }
            if(!empty($add_data)){
                DB::table('text_set')->insert($add_data);
            }
        }
        $list = DB::table('text_set')->orderBy('id','desc')->paginate(20);
        $cates = DB::table('text_class')->get();
       /* $cates = [];
        foreach ($cates_res as $k =>$v){
            $cates[$v->cate_key] = $v->cate_name;
        }*/
        /*foreach ($list['data'] as $k =>$v){
            $list['data'][$k]['cate_name'] = $cates[$v['cate_key']];
        }*/

        return view('ai.list',['list'=>$list,'cates'=>$cates]);
    }
    public function learn(){
        $classifier = new NaiveBayes();
        return  $classifier->predict([3, 1,1]);
    }
    public function test(){
        $cate_list = ['chuxing'=>'出行','gongzuo'=>'工作',
            'touzi'=>'投资','shiye'=>'事业','aiqing'=>'爱情',
            'hunyin'=>'婚姻','jiankang'=>'健康',
            'xunwu'=>'寻物','xunren'=>'寻人','other'=>'杂事'];

        foreach ($cate_list as $cate_key => $cate_name){
            DB::table('text_class')->insert(['cate_name'=>$cate_name,'cate_key'=>$cate_key]);
        }
    }
    public function get_words($text){
        $so = \scws_new();
        $so->set_charset('utf8');
        // 这里没有调用 set_dict 和 set_rule 系统会自动试调用 ini 中指定路径下的词典和规则文件
        $so->set_ignore(true);
        $so->send_text($text);
        $tmp = $so->get_result();
        $so->close();
        $words = [];
        $words_str = '';
        if($tmp){
            foreach ($tmp as $v){
                $words[] = $v['word'];
            }
            $words_str = implode(',',$words);
        }
        return $words_str;
    }
}
