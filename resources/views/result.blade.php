<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Laravel</title>
	<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
	<!-- Static navbar -->
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">梅花易数随机起卦</a>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">首页</a></li>
					<li><a href="#">我的历史记录</a></li>
					<li><a href="#">联系站长</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div><!--/.container-fluid -->
	</nav>
      <div class="jumbotron">
       <form id="form1" class="form-horizontal" action="" method="post">
	   <h2>测算结果</h2>
		<div class="shuoming">
		<hr>
		<dl class="dl-horizontal">
		  <dt>测算号</dt>
		  <dd>{{$result->user_data->ce_sn}}</dd>
		  <dt>测算人性别</dt>
		  <dt>测算日期</dt>
		  <dd>{{$result->user_data->cesuan_time}} {{$result->user_data->shichen}} 时</dd>
		  <dt>所问事项</dt>
		  <dd>{{$result->user_data->problem_type}}</dd>
		  <dt>事情简述</dt>
		  <dd>{{$result->user_data->problem_text}}</dd>
		</dl>
		<hr>
		<div class="result">
		<h4>卦象</h4>
		<div class="col-xs-12">
			<div class="col-xs-6">本卦：<strong>{{$result->s_gua->fullname}}</strong><img src="/data/thumb/{{$result->s_gua->name}}.png" class="img-thumbnail"></div>
{{--
			<div class="gua_xiang">互卦：<strong>{$result.h_gua.fullname}</strong><img src="/data/thumb/{$result.h_gua.name}.png" class="img-thumbnail"></div>
--}}
			<div class="col-xs-6">变卦：<strong>{{$result->b_gua->fullname}}</strong><img src="/data/thumb/{{$result->b_gua->name}}.png" class="img-thumbnail"></div>
		</div>
		<h4>动爻</h4>
		  <p>{{$result->dongyao->name}}</p>
		<h4>爻辞</h4>
		<p>{{$result->dongyao->yaoci}}</p>
		{{--<p>{{$result->dongyao->xiangci}} </p>--}}
		{{--<h4>白话文解释</h4>
		<p>{{$result->dongyao->yaoci_jieshi}}</p>
		<p>{{$result->dongyao->xiangci_jieshi}}</p>--}}
		<h4>邵康节解卦</h4>
		<p>{{$result->dongyao->shaoci}}</p>
		<hr>
		<div class="alert alert-danger">
		   <strong>善意提醒：</strong>如果您不懂周易，切忌不要按卦辞、爻辞的字面意思理解。
		</div>
		</div>
		</div>
      </form>
	  </div>
 </div>
</div>
</body>
</html>