@extends('layouts.main')
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
				{{--<dl class="dl-horizontal">
                    <dt>测算号</dt>
                    <dd>{{$result->user_data->ce_sn}}</dd>
                    <dt>测算日期</dt>
                    <dd>{{$result->user_data->cesuan_time}} {{$result->user_data->shichen}} 时</dd>
                    <dt>测算四柱</dt>
                    <dd>{{$result->user_data->sizhu['nianzhu']}} {{$result->user_data->sizhu['yuezhu']}} {{$result->user_data->sizhu['rizhu']}} {{$result->user_data->sizhu['shizhu']}}</dd>
                    <dt>所问事项</dt>
                    <dd>{{$result->user_data->problem_type}}</dd>
                    <dt>事情简述</dt>
                    <dd>{{$result->user_data->problem_text}}</dd>
                </dl>
                <hr>--}}
				<div class="result">
					<h4>卦象</h4>

					<div class="col-sm-12">
						<div class="col-sm-6">本卦：<strong>{{$result->s_gua->fullname}}</strong><img src="/data/thumb/{{$result->s_gua->name}}.png" class="img-thumbnail"></div>
						{{--
                                    <div class="gua_xiang">互卦：<strong>{$result.h_gua.fullname}</strong><img src="/data/thumb/{$result.h_gua.name}.png" class="img-thumbnail"></div>
                        --}}
						<div class="col-sm-6">变卦：<strong>{{$result->b_gua->fullname}}</strong><img src="/data/thumb/{{$result->b_gua->name}}.png" class="img-thumbnail"></div>
					</div>
					<hr>
					<h4>动爻</h4>
					<p>{{$result->dongyao->name}}</p>
					<h4>爻辞</h4>
					<p>{{$result->dongyao->yaoci}}</p>
					{{--<p>{{$result->dongyao->xiangci}} </p>--}}
					{{--<h4>白话文解释</h4>
                    <p>{{$result->dongyao->yaoci_jieshi}}</p>
                    <p>{{$result->dongyao->xiangci_jieshi}}</p>--}}
					<h4>邵康节解卦</h4>
					<p>{{$result->dongyao->shaoci}}</p>
					<hr>
					<h4>智能断卦</h4>
					<p>{{$result->tiyong->zhu->name}} 为 {{$result->tiyong->zhu->tiyong}} , {{$result->tiyong->bing->name}} 为 {{$result->tiyong->bing->tiyong}}</p>
					<p>{{$result->tiyong->zhu->name}} {{$result->tiyong->zhu->attribute}} <span class="text-success">{{$result->tiyong->guanxi}}</span> {{$result->tiyong->bing->name}} {{$result->tiyong->bing->attribute}}</p>
					<p> <strong
								class="@if($result->duanyan->type = '吉') text-success
						   @elseif($result->duanyan->type = '小吉') text-primary
						   @elseif($result->duanyan->type = '小凶') text-warning
                           @elseif($result->duanyan->type = '大凶') @else text-danger @endif"
						>{{$result->duanyan->type}}</strong> <span>{{$result->duanyan->text}}</span></p>
				</div>
			</div>
		</div>
	</div>
@endsection
