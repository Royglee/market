@extends('app')

@section('content')
<div class="container">
    <div class="row filterbox">
        <div class="col-xs-12" >
            <div style="margin: 15px">
                {!! Form::open(['action' => 'AccountsController@index', 'method' => 'get', 'class'=>'text-center']) !!}
                <div id="filter-accounts" class="btn-group hidden" role="group" aria-label="filter">
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        Filter
                    </button>
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
                {{--<label for="champion-select control-label">Champions:</label>--}}
                <select name="champion" id="champion-select">
                    <option value="0" @if(!isset($input['champion']))selected @endif>champions > 0</option>
                    <option value="40" @if(isset($input['champion'])&& $input['champion']=='40')selected @endif>champions > 40</option>
                    <option value="80" @if(isset($input['champion'])&& $input['champion']=='80')selected @endif>champions > 80</option>
                    <option value="100" @if(isset($input['champion'])&& $input['champion']=='100')selected @endif>champions > 100</option>
                </select>
                {{--<label for="skin-select control-label">Skins:</label>--}}
                <select name="skin" id="skin-select">
                    <option value="0" @if(!isset($input['skin']))selected @endif>skins > 0</option>
                    <option value="40" @if(isset($input['skin'])&& $input['skin']=='40')selected @endif>skins > 40</option>
                    <option value="80" @if(isset($input['skin'])&& $input['skin']=='80')selected @endif>skins > 80</option>
                    <option value="100" @if(isset($input['skin'])&& $input['skin']=='100')selected @endif>skins > 100</option>
                </select>
                {{--<label for="order-select control-label">Sort:</label>--}}
                <select id="order-select" name="order">
                    <option value="created_at" @if(isset($input['order'])&& $input['order']=='created_at')selected @endif>Newest first</option>
                    <option value="view_count" @if(isset($input['order'])&& $input['order']=='view_count')selected @endif>Most viewed first</option>
                    <option value="league" @if(isset($input['order'])&& $input['order']=='league')selected @endif>Division: highest first</option>
                    <option value="league_asc" @if(isset($input['order'])&& $input['order']=='league_asc')selected @endif>Division: lowest first</option>
                    <option value="champions" @if(isset($input['order'])&& $input['order']=='champions')selected @endif>Champions: most first</option>
                    <option value="skins" @if(isset($input['order'])&& $input['order']=='skins')selected @endif>Skins: most first</option>
                    <option value="price" @if(isset($input['order'])&& $input['order']=='price')selected @endif>Price: highest first</option>
                    <option value="price_asc" @if(isset($input['order'])&& $input['order']=='price_asc')selected @endif>Price: lowest first</option>
                </select>
                    </div>
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

            //Filter Init
            $('#server-select').multiselect({
                includeSelectAllOption: true,
                buttonText: function(options, select) {
                    if (options.length === 0) {
                        return 'Select server(s)!';
                    }
                    else if (options.length > 3) {
                        return options.length + ' servers selected';
                    }
                    else {
                        var labels = [];
                        options.each(function() {
                            if ($(this).attr('label') !== undefined) {
                                labels.push($(this).attr('label'));
                            }
                            else {
                                labels.push($(this).html());
                            }
                        });
                        return labels.join(', ') + '';
                    }
                }
            });
            $('#league-select').multiselect({
                includeSelectAllOption: true,
                buttonText: function(options, select) {
                    if (options.length === 0) {
                        return 'Select division(s)!';
                    }
                    else if (options.length > 3) {
                        return options.length + ' divisions selected';
                    }
                    else {
                        var labels = [];
                        options.each(function() {
                            if ($(this).attr('label') !== undefined) {
                                labels.push($(this).attr('label'));
                            }
                            else {
                                labels.push($(this).html());
                            }
                        });
                        return labels.join(', ') + '';
                    }
                }
            });
            $('#order-select').multiselect();
            $('#champion-select').multiselect();
            $('#skin-select').multiselect();
            $("#filter-accounts").removeClass('hidden');
        });
    </script>

    <script type="text/javascript" src="../js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="../css/bootstrap-multiselect.css" type="text/css"/>

@endsection