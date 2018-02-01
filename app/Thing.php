<?php
/**
 * Created by PhpStorm.
 * User: luohuanjun
 * Date: 2018/1/30
 * Time: 上午11:52
 */

namespace App;


class Thing
{
    protected $text_class;
    protected $t_gua;
    protected $y_gua;
    protected $b_gua;


    public function __construct()
    {

    }


    public function yingqi($result){

        $s_gua_num = $result['s_gua']->up_id + $result['s_gua']->down_id;
        $h_gua_num = $result['h_gua']->up_id + $result['h_gua']->down_id;
        $b_gua_num = $result['b_gua']->up_id + $result['b_gua']->down_id;

        $num = $s_gua_num + $h_gua_num + $b_gua_num;

        return $num;
    }
    public function fangwei(){

    }

}