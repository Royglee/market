@foreach($accounts->chunk(6)->all() as $row)
    <div class="row  account_row">
        @foreach($row as $account)
            <div class="col-md-4 col-sm-6 account_list_item_wrapper">
                <div data-href="{{asset('accounts/'.$account->id)}}" class="account_list_item {{$account->league}}" >

                    <div class="account_list_item_top" @include('accounts/partials/_background_badge',['account',$account])>
                        <div class="price">
                            ${{$account->price}}
                        </div>
                        <ul class="specs">
                            <li>Server: {{$account->server}}</li>
                            <li>Division: {{$account->league}} {{$account->division}}</li>
                            <li>Champions: {{$account->champions}}</li>
                            <li>Skins: {{$account->skins}}</li>
                        </ul>
                    </div>
                    <div class="title">
                        {{$account->title}}
                        @if($account->count)<span class="count {{$account->league}}_font">x{{$account->count}}</span>@endif
                    </div>
                    <div class="seller_info">
                        @if(!$profile_page) <a class="user pull-right" href="{{action('UserProfileController@show',$account->user)}}">- {{$account->user->name}}</a>@endif
                        @if($profile_page && Auth::id() == $user->id)
                            <div class="pull-right"><a class="btn btn-warning" href="{{action('AccountsController@edit',$account)}}">Edit</a>
                            {!! Form::open(['action' => ['AccountsController@destroy',$account], 'method'=>'DELETE']) !!}
                            <input type="submit" class="btn btn-danger" value="Delete"/>
                            {!! Form::close() !!}</div>
                        @endif
                        <div class="clearfix"></div>
                    </div>

                </div>

            </div>
        @endforeach
    </div>
@endforeach