<?php

namespace App;

use App\Libs\Bihua;
use App\Libs\Common;
use App\Libs\Sizhu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Meihua extends Model
{

    protected $score = 100;


    /**
     * 随机起卦
     * @param $param
     * @return string
     */
    public function qiGuaByRand($param) {
        $find_res = DB::table('cz_user_post')
            ->where('uid',$param['uid'])
            ->where('problem_text',$param['problem_text'])
            ->whereRaw("date_format(ctime,'%Y-%m-%d')",date('Y-m-d'))
            ->first();
        if($find_res){
            //同一用户的同一次预测直接返回之前的结果，防止用户测很多次
            $url = asset('/get_result?csn='. $find_res->ce_sn);
            return $url;
        }
        $text = new Bihua();
        $user_str = $param['problem_text'];
        $user_words = $text->mb_str_split($user_str);
        $user_word_num = 0;
        foreach ($user_words as $word){
            $word_num = $text->find($word);
            $user_word_num += (int)$word_num;
        }
        $time_num = date('Y')+date('m')+date('d');
        $data ['t1_len'] = $time_num+rand(0,9999);
        $data ['t2_len'] = $user_word_num;
        //起卦核心算法
        $data ['down_gua'] = $data ['t1_len'] % 8;
        $data ['up_gua'] = $data ['t2_len'] % 8;
        $data ['down_gua'] = $data ['down_gua'] == 0 ? 8 : $data ['down_gua'];
        $data ['up_gua'] = $data ['up_gua'] == 0 ? 8 : $data ['up_gua'];
        $data ['shichen'] =  Common::shichen();
        $data ['dongyao'] = ($data ['up_gua'] + $data ['down_gua']+$data['shichen']) % 6;
        $data ['dongyao'] = $data ['dongyao'] == 0 ? 6 : $data ['dongyao'];
        $data ['problem_text'] = $param['problem_text'];
        $data ['problem_type'] = $param['problem_type'];
        $data ['ip'] = $param['ip'];
        $data ['client_type'] = $param['client_type'];
        $data ['uid'] = $param['uid'];
        $data ['ctime'] = date('Y-m-d H:i:s');
        $sn =  $this->qigua($data);
        $url = asset('/get_result?csn='.$sn);
        return $url;
    }

    /**
     * 起卦核心
     * @param $data
     * @return \Illuminate\Http\JsonResponse|string
     */
    protected function qigua($data){
        //记录用户提交
        $fid = DB::table('cz_user_post')->insertGetId($data);

        $sn = $this->get_ce_sn($fid);
        DB::table('cz_user_post')->where('fid',$fid)->update(['ce_sn'=>$sn]);
        //所得原卦
        $s_gua = DB::table('cz_s_gua')->where('up_id',$data['up_gua'])->where('down_id',$data['down_gua'])->first();
        $h_gua = DB::table('cz_s_gua')->where('id',$s_gua->h_gua_id)->first();
        $dongyao = DB::table('cz_dongyao')->where('s_gua_id',$s_gua->id)->where('position',$data['dongyao'])->first();
        $b_gua = DB::table('cz_s_gua')->where('id',$dongyao->b_gua_id)->first();

        if (!$dongyao || !$b_gua) {
            return response()->json(['msg'=>'error']);
        }
        //输出结果
        $user_data['shichen'] = Common::shichen_name($data['shichen']);
        //$user_data['birthday'] = date('Y年m月d日',$data ['birthday']);
        $user_data['cesuan_time'] = date('Y-m-d H:i:s');
        //$user_data['word'] = $data ['t1'] ." ".$data ['t2'];
        $user_data['problem_text'] = $data ['problem_text'];
        $user_data['problem_type'] = $data['problem_type'];
        $user_data['ce_sn'] = $sn;

        $result = ['s_gua'=>$s_gua,'h_gua'=>$h_gua,'b_gua'=>$b_gua,'dongyao'=>$dongyao,'user_data'=>$user_data];
        $tiyong  =  $this->tiyong($result);
        $tiyong  =  $this->tiyong($result);
        $result = array_merge($result,$tiyong);

        //记录日志
        $logs['fid'] = $fid;
        $logs['uid'] =  $data ['uid'];
        $logs['result'] = json_encode($result,JSON_UNESCAPED_UNICODE);
        DB::table('cz_result')->insert($logs);
        return $sn;
    }

    /**
     * 定体用生克关系
     * @param array $result
     * @return array
     */
    public function tiyong($result=[]){
        $s_gua = $result['s_gua'];
        $b_gua = $result['b_gua'];
        $dongyao = $result['dongyao'];
        $user_data = $result['user_data'];

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
        //$res['duanyan'] = $this->duanyan($ty_str,$user_data['problem_type']);
        $bgua_str =  $this->biangua($t_gua,$b_gua);
        $ty_key = $ty_str.'|'.$bgua_str;
        //$res['score'] = $this->getScore($score_str);
        $res['duanyan'] = $this->duanyan($ty_key,$user_data['problem_type']);
        $res['yingqi'] = $this->yingqi($ty_key,$result);
        return $res;
    }

    /**
     * 体用生克结果断言
     * @param string $str
     * @param $problem_type
     * @return mixed
     */
    public function duanyan($str='',$problem_type){
        return Analysis::getDuanyu($str,$problem_type);
    }
    public function yingqi($ty_key,$result){
        return Analysis::yingqi($ty_key,$result);
    }

    /**
     * 变卦体卦关系
     * @param $t_gua
     * @param $b_gua
     * @return string
     */
    public function biangua($t_gua,$b_gua){
        if($b_gua->up_id == $t_gua->id){
            $b_y = DB::table('cz_e_gua')->where('id',$b_gua->down_id)->first();;
        }else{
            $b_y = DB::table('cz_e_gua')->where('id',$b_gua->up_id)->first();
        }
        $b_y->tiyong = '变';
        $wuxing = $this->wuxing($t_gua,$b_y);
        //断变卦生克
        $ty_str = $wuxing['zhu']->tiyong.$wuxing['guanxi'].$wuxing['bing']->tiyong;
        return $ty_str;
    }

    /**
     * 五行生克关系
     * @param $a
     * @param $b
     * @return array
     */
    public function wuxing($a,$b){

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
    public function getResult($sn,$type='html'){

        $map['ce_sn'] = $sn;
        $res = DB::table('cz_user_post')->select('fid')->where($map)->first();
        $map=array();
        $map['fid'] = $res->fid;
        $result = DB::table('cz_result')->select('result')->where($map)->first();
        $result = json_decode($result->result);
        $Sizhu = new Sizhu();
        $result->user_data->sizhu = $Sizhu->getSizhu($result->user_data->cesuan_time);
        if($type == 'html'){
            $act_name='result';
            $content = view('meihua.'.$act_name,['result'=>$result]);
        }elseif($type == 'jpg'){
            $content = $result;
        }else{
            $content = $result;
        }
        return $content;
    }
    public   static function get_problem_type($key=''){
        $cates_res = DB::table('text_class')->get();
        $cates = [];
        foreach ($cates_res as $k =>$v){
            $cates[$v->cate_key] = $v->cate_name;
        }
        if(isset($cates[$key])){
            return $cates[$key];
        }
        return $cates;
    }
    //生成测算单号号
    public function get_ce_sn($id) {
        $str =  date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        $str = hashid_encode($str);
        return $str;
    }
}
