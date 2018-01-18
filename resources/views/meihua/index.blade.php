@extends('layouts.main')
@section('content')
<div class="jumbotron">
	<h2>梅花易数</h2>
	<div class="row">
		<div class="col-xs-12">
			<hr>
			<h4>占卜说明</h4>
			<div class="col-xs-6">
				<p>心里先想好要问的事情，然后随机想出两个字来，本站仅限两个字，不用多思考;
					有事则占，无事不占，多占无益.</p>
				<p><span class="text-success">{{$date}}</span></p>
				<p><span class="text-danger">{{$sizhu['nianzhu']}},{{$sizhu['yuezhu']}},{{$sizhu['rizhu']}},{{$sizhu['shizhu']}}</span></p>
			</div>
			<hr>
		</div>
	</div>
	<div class="row">
		<form action="/do_result" method="post" class="col-xs-12">
			{{csrf_field()}}
			<div class="form-group col-xs-12">
				<h4>请选择测事类型</h4>
			</div>
			<div class="form-group col-xs-12">

				<select class="form-control " name="problem_type">
					@foreach($data as $k =>$type)
						<option value="{{$type}}">{{$type}}</option>
					@endforeach
				</select>

			</div>
			<div class="form-group col-xs-12">
				<h4 for="problem_text">简述你要测的事情</h4>
			</div>
			<div class="form-group col-xs-12">

					<textarea class="form-control" rows="3" name="problem_text" id="problem_text" placeholder="简述你要测的事情"></textarea>

			</div>
			<div class="form-group col-xs-12">
				<button class="btn btn-lg btn-primary" href="/do_result" role="button" type="submit">随机起卦</button>
			</div>
		</form>
	</div>
</div>
@endsection