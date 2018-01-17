<?php
/**
 * Created by PhpStorm.
 * User: luohuanjun
 * Date: 2017/5/16
 * Time: 下午3:12
 */
?>
<?php
$route=Route::currentRouteName();
if($pos=strpos($route,'/')){
    $model=substr($route,0,$pos);
    $action=substr($route,$pos+1);
}else{
    $model=$route;
    $action='index';
}
$menu=\App\Menu::getMenuList();
$user = Auth::user();
$console_routes = ['home'=>'系统列表','user/set'=>'我的信息','user/password'=>'修改密码'];
$console_view = '';
if(array_key_exists($route,$console_routes)){
    $console_view = 'active';
}
?>
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
    <li class="header">主菜单</li>
    <li class="treeview {{$console_view}}">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span>控制台</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @foreach($console_routes as $menu_route =>$menu_name)
            <li class="@if($menu_route == $route) active @endif"><a href="{{route($menu_route)}}"><i class="fa fa-circle-o"></i> {{$menu_name}}</a></li>
            @endforeach
        </ul>
    </li>
    @ifHasRole('department|admin')
    <?php
    foreach($menu as $k =>$v){
    if($model==$v->module){
        $active='active';
    }else{
        $active='';
    }
    if($console_view == 'active'){
        $active = '';
    }
    $display = '';
    if($user->hasRole('department')){
        $display = ' style=display:none ';
        if($v->module == 'user'){
            $display = '';
        }
    }
    ?>

    <li  class="<?=$active?> treeview" {{$display}}>
        <a href="#">
            <i class="fa <?=$v->icon?>"></i>
            <span><?= $v->name?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <?php foreach($v->sub as $sub) {
            if($action==$sub->action){
                $active='active';
            }else{
                $active='';
            }

            if($user->hasRole('department') && $v->module=='user' && $sub->action=='create'){
                $sub_display = ' style=display:none ';
            }else{
                $sub_display = '';
            }
            ?>
            <li class="<?=$active?>" {{$sub_display}}>
                <a href="<?=url($sub->url)?>">
                    <i class="fa fa-circle-o"></i>
                    <?=$sub->name?>
                    <b class="arrow"></b>
                </a>
            </li>
            <?php }?>
        </ul>
    </li>
    <?php }?>

    <li class="header">系统相关</li>
    <li {{$display}}><a href="{{url('log/syslog')}}"><i class="fa fa-circle-o text-green"></i> <span>系统日志</span></a></li>
    <li {{$display}}><a href="{{url('log')}}"><i class="fa fa-circle-o text-danger"></i> <span>登录日志</span></a></li>
    @endIfHasRole
    <li><a href="{{url('file')}}"><i class="fa fa-circle-o text-bold"></i> <span>公司文件</span></a></li>
    <li><a href="{{url('gift')}}"><i class="fa fa-gift text-bold"></i> <span>礼品选择</span></a></li>
</ul>
</section>
<!-- /.sidebar -->
