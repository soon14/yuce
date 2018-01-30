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
    public static function getDuanyu($text,$text_class,$t_gua,$y_gua,$b_gua){
        self::$text_class = $text_class;
        switch ($text_class){
            case $text_class == '婚姻':
                /**
                 * 一、若问能否结婚成功
                 * 1、体克用：可以但是比较晚实现或者比较花钱或者比较耗费精力周折
                 * 2、体用比和：你们的婚姻能够成功，良配无疑，一切顺利，好好珍惜
                 * 3、用生体：你们很恩爱，婚姻会大吉大利，结婚当然是自然而然的事
                 * 4、用克体：你们的婚姻终究难成，徒劳无功，即时勉强成婚也对己方不利
                 * 5、体生用：婚姻难成，勉强不来
                 * 二、若问何时成婚
                 * 体互变卦数之和（最小 6，最大48）
                 *单位如何取？统一以天为单位（1-3000）* 1，（3000-6000）*2，（>6000）
                 */


                break;


        }

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
