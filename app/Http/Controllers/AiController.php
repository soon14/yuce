<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AiController extends Controller
{
    //
    public function text(Request $request){
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
                $add_data[$k]['cate_key'] = $data['cate'];
            }
            if(!empty($add_data)){
                foreach ($add_data as $k => $v){
                    $find_num = DB::table('text_set')->where('text',$v['text'])->count();
                    if($find_num > 0){
                        unset($add_data[$k]);
                    }
                }
                DB::table('text_set')->insert($add_data);
            }
            return redirect('/ai/train');
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

    public function train(Request $request){

        $cates_res = DB::table('text_class')->get();
        $cates = [];
        foreach ($cates_res as $k =>$v){
             $cates[$v->cate_key] = $v->cate_name;
        }

        $texts = [];
        $text_res = DB::table('text_set')->get();
        foreach ($text_res as $v ){
            if(empty($v->words)){
                continue;
            }
            $texts[$v->cate_key][] = $v->words_id;
        }
        $texts_dt = [];
        foreach ($texts as $k=>$v){
            $texts[$k] = implode(',',$v);
            $texts[$k]  = explode(',',$texts[$k] );
        }
        $labels = [];
        foreach (array_keys($texts) as $v){
            $labels[$v] =  $cates[$v];
        }
        $samples = array_values($texts);
        $labels = array_values($labels);
        $samples = [[5, 1, 1], [1, 5, 1], [1, 1, 5]];
        $labels = ['a', 'b', 'c'];

    }
    public function predict(Request $request){
        $word = $request->get('word');
        $words_id = $this->getTextId($word);
    }
    private function getTextId($text){
        $words = $this->get_words($text);
        $words = explode(',',$words);
        $word_ids = [];
        foreach ($words as $word){
            $find_res = DB::table('text_word')->where('word',$word)->first();
            if($find_res){
                $word_ids[] = $find_res->id;
            }else{
                $word_ids[] = DB::table('text_word')->insertGetId(['word'=>$word]);
            }
        }
        return $word_ids;
    }
    public function test(){
        $list = DB::table('text_set')->get();
        foreach ($list as $v){
            if(empty($v->words)){
                continue;
            }
            $words = explode(',',$v->words);
            $word_ids = [];
            foreach ($words as $word){
                $find_res = DB::table('text_word')->where('word',$word)->first();
                if($find_res){
                    $word_ids[] = $find_res->id;
                }else{
                    $word_ids[] = DB::table('text_word')->insertGetId(['word'=>$word]);
                }
            }
            $words_id_str = implode(',',$word_ids);
            DB::table('text_set')->where('id',$v->id)->update(['words_id'=>$words_id_str]);
        }
        exit;
        $cate_list = ['chuxing'=>'出行','gongzuo'=>'工作',
            'touzi'=>'投资','shiye'=>'事业','aiqing'=>'爱情',
            'hunyin'=>'婚姻','jiankang'=>'健康',
            'xunwu'=>'寻物','xunren'=>'寻人','other'=>'杂事'];

        foreach ($cate_list as $cate_key => $cate_name){
            DB::table('text_class')->insert(['cate_name'=>$cate_name,'cate_key'=>$cate_key]);
        }
    }
    public function get_words($text){
        $api = 'http://127.0.0.1:8000/nlp?cut_word=1&text='.$text;
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
