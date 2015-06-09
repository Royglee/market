@extends('app')

@section('content')
    <div class="container">
        {!! Form::open(['url' => 'accounts.store', 'method' => 'post', 'role'=>'form', 'class'=>'col-md-push-1 col-md-9']) !!}
      <div class="row">
          <div class="form-group col-sm-8">
                {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
          </div>
          <div class="form-group col-sm-2">
                {!! Form::label('price', 'Price:', ['class' => 'control-label']) !!}
                {!! Form::text('price', null, ['class' => 'form-control']) !!}
          </div>
          <div class="form-group col-sm-2">
              {!! Form::label('server', 'Server:', ['class' => 'control-label']) !!}
              {!! Form::select('server', ['NA', 'EUNE', 'EUW', 'OCE', 'BR', 'LA', 'RU', 'TR', 'KR'] , null , ['class' => 'form-control']) !!}
          </div>
      </div>

       <div class="row">
            <div class="form-group col-sm-6">
                <div class="row">
                    <div class="col-sm-12">{!! Form::label('league', 'League & Division:', ['class' => 'control-label']) !!}</div>
                    <div class="col-sm-7">
                        {!! Form::select('league', ['Unranked','Bronze','Silver','Gold','Platinum','Diamond','Master','Challenger'] , null , ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-5">
                        {!! Form::select('division', [1,2,3,4,5] , null , ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-3">
                {!! Form::label('champions', 'Number of Champions:', ['class' => 'control-label']) !!}
                {!! Form::text('champions', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-sm-3">
                {!! Form::label('skins', 'Number of Skins:', ['class' => 'control-label']) !!}
                {!! Form::text('skins', null, ['class' => 'form-control']) !!}
            </div>
       </div>

        <div class="form-group">
            {!! Form::label('body', 'Body:', ['class' => 'control-label']) !!}
            <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
        </div>
        {!! Form::close() !!}


    </div>
@endsection