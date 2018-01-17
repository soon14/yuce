<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    /**
    +----------------------------------------------------------
     * Ajax方式返回数据到客户端
    +----------------------------------------------------------
     * @access protected
    +----------------------------------------------------------
     * @param mixed $data 要返回的数据
     * @param String $info 提示信息
     * @param boolean $status 返回状态
     * @param String $status ajax返回类型 JSON XML
    +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     */
    public  function ajaxReturn($data=array(),$info='',$status=1,$code=200) {
        $result  =  array();
        $result['status']  =  $status;
        $result['msg'] =  $info;
        $result['data'] = $data;

        // 返回JSON数据格式到客户端 包含状态信息
        return (response()->json($result,$code));
    }
    /**
    +----------------------------------------------------------
     * 操作错误跳转的快捷方法
    +----------------------------------------------------------
     * @access public
    +----------------------------------------------------------
     * @param string $message 错误信息
    +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     */
    public  function error($message='error',$data=array(),$code=200) {
        return $this->ajaxReturn($data,$message,'-1',$code);
    }

    /**
    +----------------------------------------------------------
     * 操作成功跳转的快捷方法
    +----------------------------------------------------------
     * @access public
    +----------------------------------------------------------
     * @param string $message 提示信息
    +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     */
    public  function success($data=[],$message='ok') {
        return $this->ajaxReturn($data,$message,'1');
    }
}


