@if ($errors->any())
    <div class="hidden" id="errors" data-error="{{$errors->any()}}">@foreach (array_keys($errors->toArray()) as $error){{$error}} @endforeach</div>
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif