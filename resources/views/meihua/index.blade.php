@extends('layouts.main')
@section('content')
<div class="jumbotron">
	<h2>梅花易数</h2>
	<hr>
	<h4>占卜说明</h4>
	<div class="col-xs-12">
		<div class="col-xs-6">
			<p>心里先想好要问的事情，然后随机想出两个字来，本站仅限两个字，不用多思考;
				有事则占，无事不占，多占无益.</p>
		</div>
	</div>
	<h4>占卜时间</h4>
	<ul>
		<li><strong class="text-success">{{$date}}</strong></li>
		<li><strong class="text-danger">{{$sizhu['nianzhu']}},{{$sizhu['yuezhu']}},{{$sizhu['rizhu']}},{{$sizhu['shizhu']}}</strong></li>
	</ul>
	<hr>
	<div class="row">
		<form action="/do_result" method="post" class="col-xs-12">
			{{csrf_field()}}
			<div class="form-group col-xs-12">
				<label for="problem_text">请选择测事类型</label>
			</div>
			<div class="form-group col-xs-12">
				<div class="col-xs-6">
				<select class="form-control " name="problem_type">
					@foreach($data as $k =>$type)
						<option value="{{$type}}">{{$type}}</option>
					@endforeach
				</select>
				</div>
			</div>
			<div class="form-group col-xs-12">
				<label for="problem_text">简述你要测的事情</label>
			</div>
			<div class="form-group col-xs-12">
				<div class="col-xs-6">
					<input type="text" class="form-control" name="problem_text" id="problem_text" placeholder="简述你要测的事情">
				</div>
			</div>
			<div class="form-group col-xs-12">
				<button class="btn btn-lg btn-primary" href="/do_result" role="button" type="submit">随机起卦</button>
			</div>
		</form>
	</div>
</div>
@endsection