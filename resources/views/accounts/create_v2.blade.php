@extends('app')
<style>[v-cloak] { display:none }</style>
@section('content')
<div id="create-page" class="container">
    <div class="row form-group">
        <div class="col-xs-12">
            <ul class="nav nav-pills nav-justified thumbnail setup-panel" >
                <li v-repeat="step: steps | orderBy step"
                    v-class="active: step.active, disabled: step.disabled"
                    v-on="click: showStep(step, $event)">

                    <a href="#step-@{{ step.number }}">
                        <h4 class="list-group-item-heading">Step @{{ step.number }}</h4>
                        <p class="list-group-item-text">@{{ step.desc}}</p>
                    </a>

                </li>
            </ul>
        </div>
    </div>
    {!! Form::open(['url' => action('AccountsController@store'), 'method' => 'post', 'role'=>'form']) !!}
    @include('accounts/partials/_step1')
    @include('accounts/partials/_step2')
    @include('accounts/partials/_step3')
    {!! Form::close() !!}
</div>

@endsection

@section('scripts')
    <script src="{{asset('js/vue.js')}}"></script>
    <script src="{{asset('js/create_steps.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/default/wbbtheme.css')}}" />
    <script src="{{asset('js/jquery.wysibb.js')}}"></script>

@endsection