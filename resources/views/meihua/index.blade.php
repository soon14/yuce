@extends('layouts.main')
@section('style')
	<link rel="stylesheet" href="{{ asset('js/icheck/skins/all.css')}}">
@endsection
@section('content')
<div class="jumbotron">
	<div class="row">
		<div class="col-xs-12">
			<h2>梅花易数</h2>
			<div class="col-xs-12">
				<h4>占卜说明</h4>
				<p>心里先想好要问的事情,有事则占，无事不占，多占无益.</p>
				<p><span class="text-success">{{$date}}</span></p>
				<p>
					<span class="label label-success">{{$sizhu['nianzhu']}}</span>
					<span class="label label-info">{{$sizhu['yuezhu']}}</span>
					<span class="label label-warning">{{$sizhu['rizhu']}}</span>
					<span class="label label-danger">{{$sizhu['shizhu']}}</span>
				</p>
			</div>
		</div>
	</div>
	<div class="row">
		<form action="/do_result" method="post" class="col-xs-12">
			{{csrf_field()}}
			<div class="form-group col-xs-12">
				<h4>请选择测事类型</h4>
				<ul class="list-inline">
					@foreach($data as $k =>$type)
						<li><input type="radio" @if($k==0) checked @endif name="problem_type" class="radio-check" value="{{$type}}"> {{$type}}</li>
					@endforeach
				</ul>
			</div>
			{{--<div class="form-group col-xs-12">

				<select class="form-control " name="problem_type">
					@foreach($data as $k =>$type)
						<option value="{{$type}}">{{$type}}</option>
					@endforeach
				</select>

			</div>--}}
			<div class="form-group col-xs-12">
				<h4>简述你要测的事情</h4>
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
@section('script')
	<script src="/js/icheck/icheck.js"></script>
	<script>
        $(document).ready(function(){
            $('.radio-check').iCheck({
                checkboxClass: 'icheckbox_square',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
	</script>
@endsection