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

	<!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron">
		<h1>梅花易数</h1>
		<hr>
		<h5>占卜说明：</h5>
		<ul>
			<li>心里先想好要问的事情，然后随机想出两个字来，本站仅限两个字，不用多思考</li>
			<li>有事则占，无事不占，多占无益</li>
		</ul>
		<hr>
		<div class="row">
			<form action="/do_result" method="post" class="col-xs-12">
				{{csrf_field()}}

				<div class="form-group col-xs-12">
					<label for="problem_text">请选择测事类型</label>
				</div>
				<div class="form-group col-xs-12">
					<div class="radio-inline col-xs-12">
						@foreach($data as $k =>$type)
							<label class="radio-inline">
								<input @if($k==0) checked @endif type="radio" name="problem_type" id="inlineRadio{{$k}}" value="{{$type}}"> {{$type}}
							</label>
						@endforeach
					</div>
				</div>

				<div class="form-group col-xs-6">
					<label for="problem_text">简述你要测的事情</label>
					<input type="text" class="form-control" id="problem_text" placeholder="简述所测之事">
				</div>
				<div class="form-group col-xs-12">
					<button class="btn btn-lg btn-primary" href="/do_result" role="button" type="submit">随机起卦</button>
				</div>
			</form>
		</div>

	</div>

</div>
</body>
</html>
