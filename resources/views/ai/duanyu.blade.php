@extends('layouts.main')
@section('style')
	<link rel="stylesheet" href="{{ asset('js/icheck/skins/all.css')}}">
@endsection
@section('content')
<div class="jumbotron">
	<div class="row">
		<form class="form-horizontal" action="/ai/duanyu" method="post">
			{{csrf_field()}}
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">体用类别</label>
				<div class="col-sm-10">
					<select class="form-control " name="ty_class_id">
						@foreach($ty_class as $k =>$v)
							<option value="{{$v->id}}">{{$v->ty_key}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">文本类别</label>
				<div class="col-sm-10">
					<select class="form-control " name="text_class">
						@foreach($text_class as $k =>$v)
							<option value="{{$v->cate_name}}">{{$v->cate_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">断语言</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="3" name="duanyu"></textarea>
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