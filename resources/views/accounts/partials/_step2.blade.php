<div class="row setup-content" id="step-1" v-show="steps.step1.active">
    <div class="col-xs-12">
        <div class="col-sm-12 well">
            <h1> STEP 2</h1>
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
                    <div class="col-sm-12">
                    <div class="row">
                        <div class="form-group col-md-12">
                            {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
                            {!! Form::text('title', null, ['class' => 'form-control' , 'v-model' =>'steps.step1.title', 'value' => old('title')]) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            {!! Form::label('server', 'Server:', ['class' => 'control-label']) !!}
                            {!! Form::select('server', ['NA'=>'NA', 'EUNE'=>'EUNE', 'EUW'=>'EUW', 'OCE'=>'OCE', 'BR'=>'BR', 'LA'=>'LA', 'RU'=>'RU', 'TR'=>'TR', 'KR'=>'KR'] , null , ['class' => 'form-control', 'v-model' =>'steps.step1.server', 'value' => old('server')]) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('league', 'League:', ['class' => 'control-label']) !!}
                            {!! Form::select('league', [ 'Unranked'=>'Unranked', 'Bronze'=>'Bronze', 'Silver'=>'Silver', 'Gold'=>'Gold', 'Platinum'=>'Platinum', 'Diamond'=>'Diamond', 'Master'=>'Master', 'Challenger'=>'Challenger'] , null , ['class' => 'form-control', 'v-model' =>'steps.step1.league', 'value' => old('league')]) !!}
                        </div>
                        <div class="form-group col-md-3" v-class="hidden: !hasDivision()">
                            {!! Form::label('division', 'Division:', ['class' => 'control-label']) !!}
                            {!! Form::select('division', [1=>1,2=>2,3=>3,4=>4,5=>5] , null , ['class' => 'form-control', 'v-model' =>'steps.step1.division', 'value' => old('division')]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-5">
                            {!! Form::label('champions', 'Number of Champions:', ['class' => 'control-label']) !!}
                            <input type="number" name="champions" min="0" class="form-control" value="{{ old('champions') }}" v-model="steps.step1.champions | splitLong 3"/>
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('skins', 'Number of Skins:', ['class' => 'control-label']) !!}
                            <input type="number" name="skins" min="0" class="form-control" value="{{ old('skins') }}" v-model="steps.step1.skins | splitLong 3"/>
                        </div>
                        <div class="form-group col-md-3">
                            {!! Form::label('price', 'Price:', ['class' => 'control-label']) !!}

                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" min="0" step="any" name="price" value="{{ old('price') }}" class="form-control" v-model="steps.step1.price | splitLong 6"/>
                            </div>
                        </div>
                    </div>
                   </div>
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