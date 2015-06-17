@extends('app')
@section('content')
    <div class="container">
        <h1>{{$user->name}}'s Accounts</h1>
        @include('accounts/partials/_accountlist', ['accounts' => $accounts, 'profile_page'=>true, 'user'=>$user])
    </div>
    @endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $( ".account_list_item" ).click(function() {
                $(location).attr('href',$(this).data('href'));
            });
            $('div.view').css({
                'position' : 'absolute',
                'top' : '50%',
                'margin-top' : -$('div.view').height()/2
            });
        });
    </script>

@endsection