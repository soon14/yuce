<?php

namespace App\Http\Controllers;

use App\Libs\Sizhu;
use Illuminate\Http\Request;
use App\Libs\Common;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index(){
        $Sizhu = new Sizhu();
        $sizhu = $Sizhu->getSizhu();
        $types = $this->get_problem_type();
        return view('meihua.index',['date'=>date('Y-m-d H:i:s'),'data'=>$types,'sizhu'=>$sizhu]);
    }

    // 测算提交
    public function do_result(Request $request) {
        $data ['t1_len'] = rand(1,9999);
        $data ['t2_len'] = rand(1,9999);

        //起卦核心算法
        $data ['down_gua'] = $data ['t1_len'] % 8;
        $data ['up_gua'] = $data ['t2_len'] % 8;
        $data ['down_gua'] = $data ['down_gua'] == 0 ? 8 : $data ['down_gua'];
        $data ['up_gua'] = $data ['up_gua'] == 0 ? 8 : $data ['up_gua'];
        $data ['shichen'] =  Common::shichen();
        $data ['dongyao'] = ($data ['up_gua'] + $data ['down_gua']+$data['shichen']) % 6;
        $data ['dongyao'] = $data ['dongyao'] == 0 ? 6 : $data ['dongyao'];
        $data ['problem_text'] = $request->get('problem_text');
        $data ['problem_type'] = $request->get('problem_type');
        $data ['ip'] = $request->getClientIp();
        $data ['client_type'] = Common::getBrowser();
        $uid = md5($data ['ip'].$data ['client_type']);
        $data ['uid'] = $uid;

        //记录用户提交
        $fid = DB::table('cz_user_post')->insertGetId($data);

        $sn = $this->get_ce_sn($fid);
        DB::table('cz_user_post')->where('fid',$fid)->update(['ce_sn'=>$sn]);
        //所得原卦
        $s_gua = DB::table('cz_s_gua')->where('up_id',$data['up_gua'])->where('down_id',$data['down_gua'])->first();
        //$h_gua = DB::table('cz_s_gua')->select(['id','name','fullname'])->where('id',$s_gua->h_gua_id)->first();
        $dongyao = DB::table('cz_dongyao')->where('s_gua_id',$s_gua->id)->where('position',$data['dongyao'])->first();
        $b_gua = DB::table('cz_s_gua')->select(['id','name','fullname'])->where('id',$dongyao->b_gua_id)->first();

        if (!$dongyao || !$b_gua) {
            return response()->json(['msg'=>'error']);
        }
        //输出结果
        $user_data['shichen'] = Common::shichen_name($data['shichen']);
        //$user_data['birthday'] = date('Y年m月d日',$data ['birthday']);
        $user_data['cesuan_time'] = date('Y年m月d日 H:i:s');
        //$user_data['word'] = $data ['t1'] ." ".$data ['t2'];
        $user_data['problem_text'] = $data ['problem_text'];
        $user_data['problem_type'] = $data['problem_type'];
        $user_data['ce_sn'] = $sn;
        $result = ['s_gua'=>$s_gua,'b_gua'=>$b_gua,'dongyao'=>$dongyao,'user_data'=>$user_data];
        //记录日志
        $logs['fid'] = $fid;
        $logs['uid'] = $uid;
        $logs['result'] = json_encode($result);
        DB::table('cz_result')->insert($logs);

        return redirect("/get_result?csn=$sn");
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

        if(Common::isMobile()){
            $act_name='qr_result';
        }else{
            $act_name='result';
        }
        return view('meihua.'.$act_name,['result'=>$result]);
    }
    private   function get_problem_type(){
        $type=['出行','工作','投资','事业','爱情','婚姻','健康','寻物','寻人','杂事'];
        return $type;
    }
    //生成测算单号号
    private function get_ce_sn($id) {
        $pre = sprintf('%02d', $id / 14000000);        // 每1400万的前缀
        $tempcode = sprintf('%09d', sin(($id % 14000000 + 1) / 10000000.0) * 123456789);    // 这里乘以 123456789 一是一看就知道是9位长度，二则是产生的数字比较乱便于隐蔽
        $seq = '371482506';        // 这里定义 0-8 九个数字用于打乱得到的code
        $code = '';
        for ($i = 0; $i < 9; $i++) $code .= $tempcode[ $seq[$i] ];
        return $pre.$code;
    }


}
