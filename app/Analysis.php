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
     * @return mixed
     */
    public static function getDuanyu($text_class,$ty_key){
        self::$text_class = $text_class;

        switch ($text_class){
            case $text_class == '婚姻':
                $list = [
                    '体比和用'=>['name'=>'体用比和','type'=>'小吉','text'=>'你们的婚姻能够成功，良配无疑，一切顺利，好好珍惜'],
                    '体生用'=>['name'=>'体生用','type'=>'小凶','text'=>'婚姻难成，勉强不来'],
                    '体克用'=>['name'=>'体克用','type'=>'小吉','text'=>'可以但是比较晚实现或者比较花钱或者比较耗费精力周折'],
                    '用克体'=>['name'=>'用克体','type'=>'大凶','text'=>'你们的婚姻终究难成，徒劳无功，即时勉强成婚也对己方不利'],
                    '用生体'=>['name'=>'用生体','type'=>'大吉','text'=>'你们很恩爱，对方很爱你，婚姻会大吉大利，结婚当然是自然而然的事'],
                ];
                break;
            default:
                $list = [
                    '体比和用'=>['name'=>'体用比和','type'=>'小吉','text'=>'所测之事终会如愿，一切顺利'],
                    '体生用'=>['name'=>'体生用','type'=>'小凶','text'=>'所测之情耗体之象，很难成功'],
                    '体克用'=>['name'=>'体克用','type'=>'小吉','text'=>'所测之事能够成功，但有迟成之像，或耗时或耗力或耗财'],
                    '用克体'=>['name'=>'用克体','type'=>'大凶','text'=>'所测之事非但不能成功，还对自己有所损失或者伤害'],
                    '用生体'=>['name'=>'用生体','type'=>'大吉','text'=>'所测之事必然成功，很特别顺心如意'],
                ];
        }
        if(isset($list[$ty_key])){
            return $list[$ty_key];
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
