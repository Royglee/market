@extends('app')
<style>[v-cloak] { display:none }</style>
@section('content')
<div id="create-page" class="container">
    <div class="row form-group">
        <div class="col-xs-12">
            <ul class="nav nav-pills nav-justified thumbnail setup-panel" >
                <li v-repeat="step: steps | orderBy steps"
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
    <div class="row setup-content" id="step-1" v-show="steps.step1.active">
        <div class="col-xs-12">
            <div class="col-sm-12 well">
                  <h1> STEP 1</h1>
               <div class="account_row row"  v-cloak>
                    <div class="col-md-4 col-sm-6 account_list_item_wrapper ">
                        <a class="account_list_item @{{steps.step1.league}}">

                            <div class="account_list_item_top" style="min-height:160px;background-image: url('/img/@{{ image }}')">
                                <div class="price" v-if="steps.step1.price > 0">
                                    $@{{steps.step1.price | splitLong 6}}
                                </div>
                                <ul class="specs">
                                    <li>Server: @{{ steps.step1.server }}</li>
                                    <li>Division:  @{{ leagueDiv }}</li>
                                    <li v-if="steps.step1.champions > 0">Champions: @{{ steps.step1.champions | splitLong 3}}</li>
                                    <li v-if="steps.step1.skins > 0">Skins: @{{ steps.step1.skins | splitLong 3}}</li>
                                </ul>
                            </div>
                            <div class="title">
                                @{{ steps.step1.title }}
                            </div>
                            <div class="seller_info">
                                <b>- {{Auth::user()->name}}</b>
                            </div>

                        </a>
                    </div>
                   <div class="Account_list_info col-md-8 col-sm-6">
                       {!! Form::open(['url' => 'accounts.store', 'method' => 'post', 'role'=>'form', 'class'=>'col-sm-12']) !!}
                       <div class="row">
                           <div class="form-group col-md-12">
                               {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
                               {!! Form::text('title', null, ['class' => 'form-control' , 'v-model' =>'steps.step1.title']) !!}
                           </div>
                       </div>

                       <div class="row">
                           <div class="form-group col-md-3">
                               {!! Form::label('server', 'Server:', ['class' => 'control-label']) !!}
                               {!! Form::select('server', ['NA'=>'NA', 'EUNE'=>'EUNE', 'EUW'=>'EUW', 'OCE'=>'OCE', 'BR'=>'BR', 'LA'=>'LA', 'RU'=>'RU', 'TR'=>'TR', 'KR'=>'KR'] , null , ['class' => 'form-control', 'v-model' =>'steps.step1.server']) !!}
                           </div>
                           <div class="form-group col-md-6">
                               {!! Form::label('league', 'League:', ['class' => 'control-label']) !!}
                               {!! Form::select('league', [ 'Unranked'=>'Unranked', 'Bronze'=>'Bronze', 'Silver'=>'Silver', 'Gold'=>'Gold', 'Platinum'=>'Platinum', 'Diamond'=>'Diamond', 'Master'=>'Master', 'Challenger'=>'Challenger'] , null , ['class' => 'form-control', 'v-model' =>'steps.step1.league']) !!}
                           </div>
                           <div class="form-group col-md-3" v-class="hidden: !hasDivision()">
                               {!! Form::label('division', 'Division:', ['class' => 'control-label']) !!}
                               {!! Form::select('division', [1=>1,2=>2,3=>3,4=>4,5=>5] , null , ['class' => 'form-control', 'v-model' =>'steps.step1.division']) !!}
                           </div>
                       </div>
                       <div class="row">
                           <div class="form-group col-md-5">
                               {!! Form::label('champions', 'Number of Champions:', ['class' => 'control-label']) !!}
                               <input type="number" name="champions" min="0" class="form-control" v-model="steps.step1.champions | splitLong 3"/>
                           </div>
                           <div class="form-group col-md-4">
                                   {!! Form::label('skins', 'Number of Skins:', ['class' => 'control-label']) !!}
                                   <input type="number" name="skins" min="0" class="form-control" v-model="steps.step1.skins | splitLong 3"/>
                           </div>
                           <div class="form-group col-md-3">
                               {!! Form::label('price', 'Price:', ['class' => 'control-label']) !!}

                               <div class="input-group">
                                   <span class="input-group-addon">$</span>
                                   <input type="number" min="0" name="price" class="form-control" v-model="steps.step1.price | splitLong 6"/>
                               </div>
                           </div>
                       </div>
                       {!! Form::close() !!}
                   </div>
               </div>
            </div>
        </div>
        <div class="col-xs-12">
            <button nextpage="2" class="btn btn-primary btn-lg" v-on="click: nextStep">
                Next Step
            </button>
        </div>
    </div>
    <div class="row setup-content" id="step-2" v-show="steps.step2.active">
        <div class="col-xs-12">
            <div class="col-sm-12 well">
                <h1> STEP 2</h1>
                <label for="editor">Write something about your account...</label>
                <textarea style="min-height: 300px"  id="editor" name="body"></textarea>
            </div>
        </div>
        <div class="col-xs-12">
            <button nextpage="3" class="btn btn-primary btn-lg" v-on="click: nextStep">
                Next Step
            </button>
        </div>
    </div>
    <div class="row setup-content" id="step-3" v-show="steps.step3.active">
        <div class="col-xs-12">
            <div class="col-sm-12 well">
                <h1> STEP 3</h1>
                <div class="form-group">
                    <label for="countq" class="control-label">Choose one...</label>
                    <select name="countq" id="countq" class="form-control" v-model="steps.step3.isMore">
                        <option value="0">I want to sell only one account</option>
                        <option value="1">I have more similar account to sell</option>
                    </select>
                </div>
                <div  class="form-group" v-if="steps.step3.isMore >0">
                    <label for="count" class="control-label">How many accounts do you want to sell?</label>
                    <input name="count" id="count" type="number" class="form-control" v-model="steps.step3.count"/>
                </div>

                <div class="form-group">
                    <label for="first_owner" class="control-label">Are you the original and only owner of this account?</label>
                    <div class="input-group">
                        <div class="btn-group check">
                            <a class="btn btn-primary btn-md notActive" data-toggle="first_owner" data-title="1">YES</a>
                            <a class="btn btn-primary btn-md notActive" data-toggle="first_owner" data-title="0">NO</a>
                        </div>
                        <input type="hidden" name="first_owner" id="first_owner" v-model="steps.step3.firstOwner" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="has_email" class="control-label">Do you have access to the account's registered email address?</label>
                    <div class="input-group">
                        <div class="btn-group check">
                            <a class="btn btn-primary btn-md notActive" data-toggle="has_email" data-title="1">YES</a>
                            <a class="btn btn-primary btn-md notActive" data-toggle="has_email" data-title="0">NO</a>
                        </div>
                        <input type="hidden" name="has_email" id="has_email" v-model="steps.step3.hasEmail" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="duration" class="control-label">How long would you like your offer to be available on our site?</label>
                    <div class="input-group">
                        <div class="btn-group check">
                            <a class="btn btn-primary btn-md notActive" data-toggle="duration" data-title="7">7 Days</a>
                            <a class="btn btn-primary btn-md notActive" data-toggle="duration" data-title="14">14 Days</a>
                            <a class="btn btn-primary btn-md notActive" data-toggle="duration" data-title="30">30 Days</a>
                        </div>
                        <input type="hidden" name="duration" id="duration" v-model="steps.step3.duration">
                    </div>
                </div>
                <div class="form-group">
                    <label for="delivery" class="control-label">How quickly can you guarantee delivery to a buyer after we notify you that an order has been successfully placed and verified?</label>
                    <div class="input-group">
                        <div class="btn-group check" id="deliveryselect">
                            <a class="btn btn-primary btn-md notActive" data-toggle="delivery" data-title="0.33">20 Minutes</a>
                            <a class="btn btn-primary btn-md notActive" data-toggle="delivery" data-title="2">2 Hours</a>
                            <a class="btn btn-primary btn-md notActive" data-toggle="delivery" data-title="24">24 Hours</a>
                            <a class="btn btn-primary btn-md notActive" data-toggle="delivery" data-title="48">48 Hours</a>
                            <a class="btn btn-primary btn-md notActive" data-type="custom" data-toggle="delivery" data-title="">Custom</a>
                            <div class="input-group hidden" id="deliverygroup">
                                <input type="number" name="delivery" id="delivery" aria-describedby="deliveryaddon" class="form-control" v-model="steps.step3.delivery">
                                <span class="input-group-addon" id="deliveryaddon">Hours</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-xs-12">
            <button nextpage="4" class="btn btn-primary btn-lg" v-on="click: nextStep">
                Next Step
            </button>
        </div>
    </div>
    <div class="row setup-content" id="step-4" v-show="steps.step4.active">
        <div class="col-xs-12">
            <div class="col-sm-12 well text-center">
                <h1> STEP 4</h1>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{asset('js/vue.js')}}"></script>
    <script src="{{asset('js/create_steps.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/default/wbbtheme.css')}}" />
    <script src="{{asset('js/jquery.wysibb.js')}}"></script>

    <style type="text/css">
        .check .notActive{
            color: #3276b1;
            background-color: #fff;
        }
    </style>
    <script type="text/javascript">
        $('.check a').on('click', function(){
            var sel = $(this).data('title');
            var tog = $(this).data('toggle');
            $('#'+tog).prop('value', sel);

            $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
            $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
        })
        $(' #deliveryselect ').on('click',function(){
            var custom = $("a[data-type='custom']").hasClass('active');
            var delivery = $('#deliverygroup');
            if (custom){delivery.removeClass('hidden')}
                else{delivery.addClass('hidden')}
        });
    </script>
@endsection