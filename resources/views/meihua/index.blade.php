@extends('layouts.main')
@section('content')
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
@endsection