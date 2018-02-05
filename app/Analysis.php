<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Analysis extends Model
{

    protected static $text_class;


    /**
     * 事物发展进度指数
     * @param string $str
     * @return mixed|string
     */
    public  static function getScore($str=''){

    }

    /**
     * 断语
     * @param $text_class
     * @return mixed
     */
    public static function getDuanyu($ty_key,$text_class){
        self::$text_class = $text_class;
        $ty_class = DB::table('ty_class')->where('ty_key',$ty_key)->first();
        $duanyu = DB::table('ty_duanyu')->where('ty_class_id',$ty_class->id)->where('text_class',$text_class)->first();

        $res = ['name'=>'','type'=>'','text'=>''];
        if($duanyu){
            $res['name'] = $ty_class->ty_key;
            $res['type'] = $ty_class->ty_type;
            $res['score'] = $ty_class->ty_score;
            $res['text'] = $duanyu->text;
        }else{
            $res['name'] = $ty_class->ty_key;
            $res['type'] = $ty_class->ty_type;
            $res['score'] = $ty_class->ty_score;
            $res['text'] = $ty_class->ty_text;
        }
        return $res;

    }

    /**
     * 断应期
     * @param $ty_key
     * @param $result
     * @return int
     */
    public static function yingqi($ty_key,$result){
        $ty_class = DB::table('ty_class')->where('ty_key',$ty_key)->first();

        $s_gua_num = $result['s_gua']->up_id + $result['s_gua']->down_id;
        $h_gua_num = $result['h_gua']->up_id + $result['h_gua']->down_id;
        $b_gua_num = $result['b_gua']->up_id + $result['b_gua']->down_id;
        $gua_num = $s_gua_num + $h_gua_num + $b_gua_num;
        return $gua_num;


    }

    /**
     * 文本分类
     * @param $cate_key
     * @return array|mixed
     */
    public  static function getTextClass($cate_key){
        $cates_res = DB::table('text_class')->get();
        $cates = [];
        foreach ($cates_res as $k =>$v){
            $cates[$v->cate_key] = $v->cate_name;
        }
        if(isset($cates[$cate_key])){
            return $cates[$cate_key];
        }
        return $cates;
    }
}
