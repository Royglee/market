@extends('app')

@section('content')
<div class="container">
    <div class="row filterbox">
        <div class="col-xs-12" >
            <div style="margin: 15px">
                {!! Form::open(['action' => 'AccountsController@filter', 'method' => 'post']) !!}
                <select id="server-select" name="server[]" multiple="multiple">
                    @foreach($servers as $server)
                    <option value='{{$server}}' @if(isset($input['server']) && in_array($server,$input['server'])) selected @endif>{{$server}}</option>
                    @endforeach
                </select>
                <select id="league-select" name="league[]" multiple="multiple">
                    @foreach($leagues as $league)
                        <option value='{{$league}}' @if(isset($input['league']) && in_array($league,$input['league'])) selected @endif>{{$league}}</option>
                    @endforeach
                </select>
                <input type="submit"/>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @include('accounts/partials/_accountlist', ['accounts' => $accounts, 'profile_page'=>false])
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $( ".account_list_item" ).click(function() {
                $(location).attr('href',$(this).data('href'));
            });
            $('#server-select').multiselect({
                includeSelectAllOption: true,
                nonSelectedText: 'Select server(s)!'
            });
            $('#league-select').multiselect({
                includeSelectAllOption: true,
                nonSelectedText: 'Select division(s)!'
            });
        });
    </script>

    <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>

@endsection