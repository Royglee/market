@extends('app')
@section('content')

    <div id="create-page" class="container">
        <div class="row"> <div class="col-xs-12">
                @include('accounts/partials/_errors')
            </div></div>
        {!! Form::model($account, ['action' =>['AccountsController@update', $account['id']], 'method' => 'PATCH', 'role'=>'form']) !!}
        @include('accounts/partials/_step1',['input'=>$account])
        @include('accounts/partials/_step2',['input'=>$account])
        @include('accounts/partials/_step3',['input'=>$account])
        {!! Form::close() !!}
    </div>

    @endsection

@section('scripts')
    <script src="{{asset('js/vue.js')}}"></script>
    <script src="{{asset('js/create_steps.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/default/wbbtheme.css')}}" />
    <script src="{{asset('js/jquery.wysibb.js')}}"></script>

@endsection