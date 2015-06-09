@if($account->division !== null)
    {{$div = "_".$account->division}}
@else
    {{$div=""}}
@endif

style="background-image: url('{{asset('img/'.$account->league.$div.'.png')}}')"