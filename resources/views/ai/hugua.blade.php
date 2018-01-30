@extends('layouts.main')
@section('style')
	<link rel="stylesheet" href="{{ asset('js/icheck/skins/all.css')}}">
@endsection
@section('content')
<div class="jumbotron">
	<div class="row">
		<form class="form-horizontal" action="/ai/hugua" method="post">
			{{csrf_field()}}
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">本卦</label>
				<div class="col-sm-10">
					<select class="form-control " name="id">
						@foreach($list as $k =>$v)
							<option value="{{$v->id}}">{{$v->fullname}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">互卦</label>
				<div class="col-sm-10">
					<select class="form-control " name="hu_id">
						@foreach($list as $k =>$v)
							<option value="{{$v->id}}">{{$v->fullname}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="hidden" name="save" value="yes">
					<button type="submit" class="btn btn-default">提交</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection