@extends('app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-4" style="background-color: rgba(255, 0, 0, 0.16);">
                a
            </div>

            <div class="col-sm-8 trade-status-wrapper">
                   <div class="trade-status">
                        <div class="row">
                            <div class="trade trade-status-title col-sm-12">
                                <h3>Trade status</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="trade trade-done col-sm-12">
                                <h3>Step 1</h3>
                                <p>You succesfully ordered an account</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="trade trade-pending col-sm-12">
                                <h3>Step 2</h3>
                                <p>It's a pending step</p>
                            </div>
                        </div>

                       <div class="row">
                           <div class="trade trade-inactive col-sm-12">
                               <h3>Step 3</h3>
                               <p>It's an inactive step</p>
                           </div>
                       </div>

                       <div class="row">
                           <div class="trade trade-inactive col-sm-12">
                               <h3>Step 4</h3>
                               <p>It's an inactive step</p>
                           </div>
                       </div>

                       <div class="row">
                           <div class="trade trade-inactive col-sm-12">
                               <h3>Step 5</h3>
                               <p>It's an inactive step</p>
                           </div>
                       </div>

                   </div>
            </div>
        </div>
        <div class="row" style="padding:10px">
            {{var_dump($order->toArray())}}
        </div>
    </div>

@endsection