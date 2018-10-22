<?php

namespace App\Http\Controllers;

use App\Libs\Sizhu;
use App\Meihua;
use Illuminate\Http\Request;
use App\Libs\Common;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index(){
        //$Sizhu = new Sizhu();
        //$sizhu = $Sizhu->getSizhu();
        $sizhu = date('Y-m-d H:i:s');
        $types = Meihua::get_problem_type();
        return view('meihua.index',['date'=>date('Y-m-d H:i:s'),'data'=>$types,'sizhu'=>$sizhu]);
    }

    // 测算提交
    public function do_result(Request $request) {
        //起卦核心算法
        $data ['problem_text'] = $request->get('problem_text');
        $data ['problem_type'] = $request->get('problem_type');
        $data ['ip'] = $request->getClientIp();
        $data ['client_type'] = Common::getBrowser();
        $uid = md5($data ['ip'].$data ['client_type']);
        $data ['uid'] = $uid;
        $data ['ctime'] = date('Y-m-d H:i:s');
        $Meihua = new Meihua();
        $url = $Meihua->qiGuaByRand($data);
        return redirect($url);
    }
    public function get_result(Request $request){
        $sn = $request->get('csn');
        if(empty($sn)){
            $this->error('error');
        }
        $map['ce_sn'] = $sn;
        $res = DB::table('cz_user_post')->select('fid')->where($map)->first();
        if(empty($res->fid)){
            $this->error('error');
        }
        $map=array();
        $map['fid'] = $res->fid;
        $result = DB::table('cz_result')->select('result')->where($map)->first();
        if(empty($result)){
            $this->error('error');
        }
        $result = json_decode($result->result);
        $Sizhu = new Sizhu();
        $result->user_data->sizhu = $Sizhu->getSizhu($result->user_data->cesuan_time);

        $act_name='result';
        return view('meihua.'.$act_name,['result'=>$result]);
    }
    private   function get_problem_type(){
        $type=['出行','工作','投资','事业','爱情','婚姻','健康','寻物','寻人','杂事'];
        return $type;
    }

    public function getList(Request $request){
        $show = $request->get('show','no');
        if($show == 'no'){
            return redirect('/');
        }
        $list = DB::table('cz_user_post')->orderBy('fid','desc')->paginate();

        $params['show'] = $show;
        return view('meihua.list',['list'=>$list,'params'=>$params]);
    }


}
