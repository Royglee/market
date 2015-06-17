@extends('app')

@section('content')
<div class="container">
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
        });
    </script>

@endsection