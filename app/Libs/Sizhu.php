<?php
/**
 * Created by PhpStorm.
 * User: luohuanjun
 * Date: 2018/1/17
 * Time: 下午8:16
 */

namespace App\Libs;


class Sizhu
{

    public   $niangan;
    public   $nianzhi;
    public   $yuegan;
    public   $rigan;



    public function getSizhu($date=''){
        if(empty($date)){
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            $hour = date('H');
        }else{
            $date = strtotime($date);
            $year = date('Y',$date);
            $month = date('m',$date);
            $day = date('d',$date);
            $hour = date('H',$date);
        }
        $result['nianzhu'] = $this->nianzhu($year);
        $result['yuezhu'] = $this->yuezhu($month);
        $result['rizhu'] = $this->rizhu($year,$month,$day);
        $result['shizhu'] = $this->shizhu($hour);

        return $result;
    }
    function nianzhu($year)
    {
        $a = array('甲','乙','丙','丁','戊','己','庚','辛','壬','癸');
        $b = array('子','丑','寅','卯','辰','巳','午','未','申','酉','戌','亥');
        $last = $year % 10;
        if($last <= 3)
        {
            $last += 10;
        }
        $this->niangan = $last - 3;
        $tiangan = $a[$this->niangan - 1];
        $last = $year % 100;
        if($year >= 1800 && $year <= 1899)
        {
            $nianzhi = $last + 9;
        }
        else if($year >= 1900 && $year <= 1999)
        {
            $nianzhi = $last + 1;
        }
        else if($year >= 2000 && $year <= 2099)
        {
            $nianzhi = $last + 5;
        }
        if($nianzhi > 12)
        {
            $nianzhi %= 12;
        }
        $this->nianzhi = $nianzhi;
        $dizhi = $b[$nianzhi - 1];
        return $tiangan . $dizhi;
    }
    function yuezhu($month)
    {
        $month = intval($month);

        $a = array('甲','乙','丙','丁','戊','己','庚','辛','壬','癸');
        $b = array('丑','寅','卯','辰','巳','午','未','申','酉','戌','亥','子');

        $this->yuegan = $this->niangan * 2 + $month;

        if($this->yuegan > 10)
        {
            $this->yuegan %= 10;
        }

        return $a[$this->yuegan-1] . $b[$month -1];
    }
    function rizhu($year,$month,$day)
    {
        $a = array('甲','乙','丙','丁','戊','己','庚','辛','壬','癸');
        $b = array('子','丑','寅','卯','辰','巳','午','未','申','酉','戌','亥');
        $today = strtotime("{$year}-{$month}-{$day}");
        $year_start = strtotime("{$year}-01-01");
        $days = ( $today - $year_start )/86400 + 1;
        $n = (int)(($year - 1900) * 5 + ($year - 1900 + 3) / 4 + 9 + $days);
        $n = $n % 60;
        $this->rigan = $n % 10;
        if($this->rigan == 0)
        {
            $this->rigan = 10;
        }
        $dizhi = $n % 12;
        if($dizhi == 0)
        {
            $dizhi = 12;
        }
        return $a[$this->rigan - 1] . $b[$dizhi - 1];
    }
    function shizhu($hour)
    {

        $a = array('甲','乙','丙','丁','戊','己','庚','辛','壬','癸');
        $b = array('子','丑','寅','卯','辰','巳','午','未','申','酉','戌','亥');
        if($hour >= 23 || $hour < 1)
        {
            $shizhi = 1;
        }
        else if($hour >= 1 && $hour < 3)
        {
            $shizhi = 2;
        }
        else if($hour >= 3 && $hour < 5)
        {
            $shizhi = 3;
        }
        else if($hour >= 5 && $hour < 7)
        {
            $shizhi = 4;
        }
        else if($hour >= 7 && $hour < 9)
        {
            $shizhi = 5;
        }
        else if($hour >= 9 && $hour < 11)
        {
            $shizhi = 6;
        }
        else if($hour >= 11 && $hour < 13)
        {
            $shizhi = 7;
        }
        else if($hour >= 13 && $hour < 15)
        {
            $shizhi = 8;
        }
        else if($hour >= 15 && $hour < 17)
        {
            $shizhi = 9;
        }
        else if($hour >= 17 && $hour < 19)
        {
            $shizhi = 10;
        }
        else if($hour >= 19 && $hour < 21)
        {
            $shizhi = 11;
        }
        else if($hour >= 21 && $hour < 23)
        {
            $shizhi = 12;
        }
        $n = $this->rigan * 2 + $shizhi - 2;
        if($n > 10)
        {
            $n %= 10;
            if($n == 0){
                $n = 10;
            }
        }
        return $a[$n-1] . $b[$shizhi-1];
    }
}