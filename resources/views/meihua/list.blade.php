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
				<table class="table table-striped">
					<thead>
					<tr>
						<th>fid</th>
						<th>测算串号</th>
						<th>用户ID</th>
						<th>测事时间</th>
						<th>测事类型</th>
						<th>测事简述</th>
						<th>用户ip</th>
						<th>用户client</th>
					</tr>
					</thead>
					<tbody>
					@foreach($list as $item)
					<tr>
						<th scope="row">{{$item->fid}}</th>
						<td><a href="/get_result/?csn={{$item->ce_sn}}">{{$item->ce_sn}}</a></td>
						<td>{{$item->uid}}</td>
						<td>{{$item->ctime}}</td>
						<td>{{$item->problem_type}}</td>
						<td>{{$item->problem_text}}</td>
						<td>{{$item->ip}}</td>
						<td>{{$item->client_type}}</td>
					</tr>
					@endforeach
					</tbody>
				</table>
				{{ $list->appends($params)->links() }}
			</div>
		</div>
	</div>
	</div>
</div>
@endsection