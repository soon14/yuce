<?php
namespace App\Libs;

/**
 * Created by PhpStorm.
 * User: luohuanjun
 * Date: 2018/1/17
 * Time: 下午2:49
 */
class Common
{

    public static function is_hanzi($chinese)     {
        $regex = '/([\x81-\xfe][\x40-\xfe])/';
        $matches = array();
        return preg_match($regex, $chinese);
    }
    // 当前时辰
    public static function shichen() {
        $now = intval ( date ( 'H' ) );
        $shichen_num = '';
        switch ($now) {
            case $now == 23 || $now == 0 || $now == 24 :
                $shichen_num = 1;
                break;
            case $now == 1 || $now == 2 :
                $shichen_num = 2;
                break;
            case $now == 3 || $now == 4 :
                $shichen_num = 3;
                break;
            case $now == 5 || $now == 6 :
                $shichen_num = 4;
                break;
            case $now == 7 || $now == 8 :
                $shichen_num = 5;
                break;
            case $now == 9 || $now == 10 :
                $shichen_num = 6;
                break;
            case $now == 11 || $now == 12 :
                $shichen_num = 7;
                break;
            case $now == 13 || $now == 14 :
                $shichen_num = 8;
                break;
            case $now == 15 || $now == 16 :
                $shichen_num = 9;
                break;
            case $now == 17 || $now == 18 :
                $shichen_num = 10;
                break;
            case $now == 19 || $now == 20 :
                $shichen_num = 11;
                break;
            case $now == 21 || $now == 22 :
                $shichen_num = 12;
                break;
            default :
                $shichen_num = 1;
                break;
        }
        return $shichen_num;
    }
    public static function shichen_name($num){
        $shichen=array(
            1=>'子',
            2=>'丑',
            3=>'寅',
            4=>'卯',
            5=>'辰',
            6=>'巳',
            7=>'午',
            8=>'未',
            9=>'申',
            10=>'酉',
            11=>'戌',
            12=>'亥'
        );
        return $shichen[$num];
    }

    /**
     * 检查是否是以手机浏览器进入(IN_MOBILE)
     */
    public static function isMobile() {
        $mobile = array ();
        static $mobilebrowser_list = 'Mobile|iPhone|Android|WAP|NetFront|JAVA|OperasMini|UCWEB|WindowssCE|Symbian|Series|webOS|SonyEricsson|Sony|BlackBerry|Cellphone|dopod|Nokia|samsung|PalmSource|Xphone|Xda|Smartphone|PIEPlus|MEIZU|MIDP|CLDC';
        // note 获取手机浏览器
        if (preg_match ( "/$mobilebrowser_list/i", $_SERVER ['HTTP_USER_AGENT'], $mobile )) {
            return true;
        } else {
            if (preg_match ( '/(mozilla|chrome|safari|opera|m3gate|winwap|openwave)/i', $_SERVER ['HTTP_USER_AGENT'] )) {
                return false;
            } else {
                if ($_GET ['mobile'] === 'yes') {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    /**
     * 获取用户浏览器型号。新加浏览器，修改代码，增加特征字符串.把IE加到12.0 可以使用5-10年了.
     */
    public static function getBrowser() {
        if (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'Maxthon' )) {
            $browser = 'Maxthon';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MSIE 12.0' )) {
            $browser = 'IE12.0';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MSIE 11.0' )) {
            $browser = 'IE11.0';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MSIE 10.0' )) {
            $browser = 'IE10.0';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MSIE 9.0' )) {
            $browser = 'IE9.0';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MSIE 8.0' )) {
            $browser = 'IE8.0';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MSIE 7.0' )) {
            $browser = 'IE7.0';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MSIE 6.0' )) {
            $browser = 'IE6.0';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'NetCaptor' )) {
            $browser = 'NetCaptor';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'Netscape' )) {
            $browser = 'Netscape';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'Lynx' )) {
            $browser = 'Lynx';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'Opera' )) {
            $browser = 'Opera';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'Chrome' )) {
            $browser = 'Google';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'Firefox' )) {
            $browser = 'Firefox';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'Safari' )) {
            $browser = 'Safari';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'iphone' ) || strpos ( $_SERVER ['HTTP_USER_AGENT'], 'ipod' )) {
            $browser = 'iphone';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'ipad' )) {
            $browser = 'iphone';
        } elseif (strpos ( $_SERVER ['HTTP_USER_AGENT'], 'android' )) {
            $browser = 'android';
        } else {
            $browser = 'other';
        }
        return $browser;
    }

    static function strFilter($str){
        $str = str_replace('`', '', $str);
        $str = str_replace('·', '', $str);
        $str = str_replace('~', '', $str);
        $str = str_replace('!', '', $str);
        $str = str_replace('！', '', $str);
        $str = str_replace('@', '', $str);
        $str = str_replace('#', '', $str);
        $str = str_replace('$', '', $str);
        $str = str_replace('￥', '', $str);
        $str = str_replace('%', '', $str);
        $str = str_replace('^', '', $str);
        $str = str_replace('……', '', $str);
        $str = str_replace('&', '', $str);
        $str = str_replace('*', '', $str);
        $str = str_replace('(', '', $str);
        $str = str_replace(')', '', $str);
        $str = str_replace('（', '', $str);
        $str = str_replace('）', '', $str);
        $str = str_replace('-', '', $str);
        $str = str_replace('_', '', $str);
        $str = str_replace('——', '', $str);
        $str = str_replace('+', '', $str);
        $str = str_replace('=', '', $str);
        $str = str_replace('|', '', $str);
        $str = str_replace('\\', '', $str);
        $str = str_replace('[', '', $str);
        $str = str_replace(']', '', $str);
        $str = str_replace('【', '', $str);
        $str = str_replace('】', '', $str);
        $str = str_replace('{', '', $str);
        $str = str_replace('}', '', $str);
        $str = str_replace(';', '', $str);
        $str = str_replace('；', '', $str);
        $str = str_replace(':', '', $str);
        $str = str_replace('：', '', $str);
        $str = str_replace('\'', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('“', '', $str);
        $str = str_replace('”', '', $str);
        $str = str_replace(',', '', $str);
        $str = str_replace('，', '', $str);
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
        $str = str_replace('《', '', $str);
        $str = str_replace('》', '', $str);
        $str = str_replace('.', '', $str);
        $str = str_replace('。', '', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace('、', '', $str);
        $str = str_replace('?', '', $str);
        $str = str_replace('？', '', $str);
        return trim($str);
    }

}