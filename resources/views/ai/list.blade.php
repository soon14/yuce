@extends('layouts.main')
@section('style')
	<link rel="stylesheet" href="{{ asset('js/icheck/skins/all.css')}}">
@endsection
@section('content')
<div class="jumbotron">
	<div class="row">
		<form class="form-horizontal" action="/ai/save" method="post">
			{{csrf_field()}}
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">分类</label>
				<div class="col-sm-10">
					<select class="form-control " name="data[cate]">
						@foreach($cates as $k =>$cate)
							<option value="{{$cate->cate_key}}">{{$cate->cate_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">文本1</label>
				<div class="col-sm-10">
					<input type="text" name="data[text][]" class="form-control" id="inputEmail3" placeholder="文本">
				</div>
			</div>

			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">文本2</label>
				<div class="col-sm-10">
					<input type="text" name="data[text][]" class="form-control" id="inputEmail3" placeholder="文本">
				</div>
			</div>

			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">文本3</label>
				<div class="col-sm-10">
					<input type="text" name="data[text][]" class="form-control" id="inputEmail3" placeholder="文本">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">文本4</label>
				<div class="col-sm-10">
					<input type="text" name="data[text][]" class="form-control" id="inputEmail3" placeholder="文本">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">文本5</label>
				<div class="col-sm-10">
					<input type="text" name="data[text][]" class="form-control" id="inputEmail3" placeholder="文本">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">文本6</label>
				<div class="col-sm-10">
					<input type="text" name="data[text][]" class="form-control" id="inputEmail3" placeholder="文本">
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
	<div class="row">
		<div class="col-xs-12">
			<h2>已分类文本</h2>
			<div class="col-xs-12">
				<table class="table table-striped">
					<thead>
					<tr>
						<th>id</th>
						<th>文本</th>
						<th>分词</th>
						<th>分类</th>
					</tr>
					</thead>
					<tbody>
					@foreach($list as $item)
					<tr>
						<th scope="row">{{$item->id}}</th>
						<td>{{$item->text}}</td>
						<td>{{$item->words}}</td>
						<td>{{$item->cate_key}}</td>
					</tr>
					@endforeach
					</tbody>
				</table>
				{{ $list->links() }}
			</div>
		</div>
	</div>
	</div>
</div>
@endsection