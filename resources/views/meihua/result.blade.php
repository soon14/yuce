@extends('layouts.main')
@section('style')
	<style>
	.col-sm-4 {
		margin-bottom: 10px;
	}
	</style>
@endsection
@section('content')
	<div class="jumbotron">
		<h2 class="text-center">测算结果</h2>
		<hr>
		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<p class="col-sm-2"><strong>测算号</strong></p>
					<div class="col-sm-10">
						<p>{{$result->user_data->ce_sn}}</p>
					</div>
				</div>
				<div class="row">
					<p  class="col-sm-2"><strong>测算日期</strong></p>
					<div class="col-sm-10">
						<p>{{$result->user_data->cesuan_time}} {{$result->user_data->shichen}} 时</p>
					</div>
				</div>
				<div class="row">
					<p class="col-sm-2"><strong>测算四柱</strong></p>
					<div class="col-sm-10">
						<p>{{$result->user_data->sizhu['nianzhu']}} {{$result->user_data->sizhu['yuezhu']}} {{$result->user_data->sizhu['rizhu']}} {{$result->user_data->sizhu['shizhu']}}</p>
					</div>
				</div>
				<div class="row">
					<p  class="col-sm-2"><strong>所问事项</strong></p>
					<div class="col-sm-10">
						<p>{{$result->user_data->problem_type}}</p>
					</div>
				</div>
				<div class="row">
					<p  class="col-sm-2"><strong>事情简述</strong></p>
					<div class="col-sm-10">
						<p>{{$result->user_data->problem_text}}</p>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12">
				<div class="result">
					<h4>卦象</h4>
					<div class="col-sm-12">
						<div class="col-sm-4">本卦：<strong>{{$result->s_gua->fullname}}</strong><img src="/data/thumb/{{$result->s_gua->name}}.png" class="img-thumbnail"></div>
						<div class="col-sm-4">互卦：<strong>{{$result->h_gua->fullname}}</strong><img src="/data/thumb/{{$result->h_gua->name}}.png" class="img-thumbnail"></div>
						<div class="col-sm-4">变卦：<strong>{{$result->b_gua->fullname}}</strong><img src="/data/thumb/{{$result->b_gua->name}}.png" class="img-thumbnail"></div>
					</div>
					<hr>
					<h4>爻辞</h4>
					<p>{{$result->dongyao->yaoci}}</p>
					@if(isset($result->dongyao->yaoci_jieshi))
					<h4>爻辞解释</h4>
					<p>{{$result->dongyao->yaoci_jieshi}}</p>
					@endif
					<h4>象辞</h4>
					<p>{{$result->dongyao->xiangci}}</p>
					@if(isset($result->dongyao->xiangci_jieshi))
					<h4>象辞解释</h4>
					<p>{{$result->dongyao->xiangci_jieshi}}</p>
					@endif
					<h4>邵康节解卦</h4>
					<p>{{$result->dongyao->shaoci}}</p>
					<h4>智能断卦</h4>
					<p>{{$result->tiyong->zhu->name}} 为 {{$result->tiyong->zhu->tiyong}} , {{$result->tiyong->bing->name}} 为 {{$result->tiyong->bing->tiyong}}</p>
					<p>{{$result->tiyong->zhu->name}} {{$result->tiyong->zhu->attribute}} <span class="text-success">{{$result->tiyong->guanxi}}</span> {{$result->tiyong->bing->name}} {{$result->tiyong->bing->attribute}}</p>
					@php
					$text_style = '';
						if($result->duanyan->type == '大吉') {
						 	$text_style = 'text-success';
						 }elseif($result->duanyan->type == '小吉') {
						  	$text_style = 'text-primary';
						 }elseif($result->duanyan->type == '小凶'){
						  	$text_style = 'text-warning';
						 }elseif($result->duanyan->type == '大凶')  {
						 	$text_style = 'text-danger';
						 }
					@endphp
					<p> <strong class="{{$text_style}}">{{$result->duanyan->type}}</strong> {{$result->duanyan->name}}:<span>{{$result->duanyan->text}}</span></p>
					@if(isset($result->score))
					<p>事物发展指数： <strong class="{{$text_style}}">{{$result->score}}%</strong> </p>
					@endif
					<div class="alert alert-warning" role="alert"><strong>温馨提示!</strong> 本次预测结果没有人为干预，仅供参考！</div>
				</div>
			</div>
		</div>
	</div>
@endsection
