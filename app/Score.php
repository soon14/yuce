<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Score extends Model
{

    protected static $text_class;


    /**
     * 事物发展进度指数
     * @param string $str
     * @return mixed|string
     */
    public  static function getScore($str=''){

        $list = [
            '用生体变生体' => 100,
            '用生体体比和变' => 96,
            '用生体体克变' => 92,
            '用生体体生变' => 88,
            '用生体变克体' => 84,

            '体比和用变生体' => 80,
            '体比和用体比和变' => 76,
            '体比和用体克变' => 72,
            '体比和用体生变' => 68,
            '体比和用变克体' => 64,

            '体克用变生体' => 60,
            '体克用体比和变' => 56,
            '体克用体克变' => 52,
            '体克用体生变' => 48,
            '体克用变克体' => 44,

            '体生用变生体' => 40,
            '体生用体比和变' => 38,
            '体生用体克变' => 34,
            '体生用体生变' => 30,
            '体生用变克体' => 26,

            '用克体变生体' => 22,
            '用克体体比和变' => 18,
            '用克体体克变' => 8,
            '用克体体生变' => 4,
            '用克体变克体' => 0
        ];
        if(isset($list[$str])){
            return $list[$str];
        }
        return '';
    }

    /**
     * @param $text_class
     */
    public static function getDuanyu($text_class){
        self::$text_class = $text_class;


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
