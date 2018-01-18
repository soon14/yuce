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
        $result  = $result + $this->tiyong($result);

        //记录日志
        $logs['fid'] = $fid;
        $logs['uid'] = $uid;
        $logs['result'] = json_encode($result);
        DB::table('cz_result')->insert($logs);

        return redirect("/get_result?csn=$sn");
    }
    private function tiyong($result=[]){
        $s_gua = $result['s_gua'];
        $b_gua = $result['b_gua'];
        $dongyao = $result['dongyao'];
        $table_e_gua = 'cz_e_gua';
        $res = [];
        if($dongyao->position>3){
            //体卦为下卦
            $t_gua = DB::table($table_e_gua)->where('id',$s_gua->down_id)->first();
            $t_gua->tiyong = '体';
            //用卦
            $y_gua = DB::table($table_e_gua)->where('id',$s_gua->up_id)->first();
            $y_gua->tiyong = '用';
        }else{
            //体卦为上卦
            $t_gua = DB::table($table_e_gua)->where('id',$s_gua->up_id)->first();
            $t_gua->tiyong = '体';
            //用卦
            $y_gua = DB::table($table_e_gua)->where('id',$s_gua->down_id)->first();
            $y_gua->tiyong = '用';
        }
        //断生克比和
        $wuxing = $this->wuxing($t_gua,$y_gua);
        $ty_str = $wuxing['zhu']->tiyong.$wuxing['guanxi'].$wuxing['bing']->tiyong;
        $res['tiyong'] = $wuxing;
        $res['duanyan'] = $this->duanyan($ty_str);
        return $res;
    }
    private function duanyan($str=''){
        $list = [
            '体比和用'=>['type'=>'小吉','text'=>'吉，所求事情终会如愿，一切顺利'],
            '体生用'=>['type'=>'小凶','text'=>'所测事情困难重重，很难成功'],
            '体克用'=>['type'=>'小吉','text'=>'所测之事能够成功，只是需要一点时间'],
            '用克体'=>['type'=>'大凶','text'=>'所测之事非但不能成功，还对自己有所损失或者伤害'],
            '用生体'=>['type'=>'大吉','text'=>'所测之事必然成功，很特别顺心如意'],
        ];
         if(isset($list[$str])){
             return $list[$str];
         }
    }

    private function wuxing($a,$b){

        $wuxing = [22=>'金',13=>'木',36=>'水',33=>'火',7=>'土'];

        $a_index = array_search($a->attribute,$wuxing);
        $b_index = array_search($b->attribute,$wuxing);

        $res = ['zhu'=>'','guanxi'=>'','bing'=>''];

        if($a_index == $b_index){
            $res = ['zhu'=>$a,'guanxi'=>'比和','bing'=>$b];
            return $res;
        }
        $ab_index_sum = $a_index+$b_index;

        $sheng = [
            58=>['zhu'=>'金','guanxi'=>'生','bing'=>'水'],
            49=>['zhu'=>'水','guanxi'=>'生','bing'=>'木'],
            46=>['zhu'=>'木','guanxi'=>'生','bing'=>'火'],
            40=>['zhu'=>'火','guanxi'=>'生','bing'=>'土'],
            29=>['zhu'=>'土','guanxi'=>'生','bing'=>'金'],
            35=>['zhu'=>'金','guanxi'=>'克','bing'=>'木'],
            20=>['zhu'=>'木','guanxi'=>'克','bing'=>'土'],
            43=>['zhu'=>'土','guanxi'=>'克','bing'=>'水'],
            69=>['zhu'=>'水','guanxi'=>'克','bing'=>'火'],
            55=>['zhu'=>'火','guanxi'=>'克','bing'=>'金']
        ];
        if(isset($sheng[$ab_index_sum])){
            $gx = $sheng[$ab_index_sum];
            if($gx['zhu'] == $a->attribute){
                $res['zhu'] = $a;
                $res['guanxi'] = $gx['guanxi'];
                $res['bing'] = $b;
            }elseif ($gx['zhu'] == $b->attribute){
                $res['zhu'] = $b;
                $res['guanxi'] = $gx['guanxi'];
                $res['bing'] = $a;
            }
        }
        return $res;

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
