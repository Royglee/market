<div class="row setup-content" id="step-3" v-show="steps.step3.active">
    <div class="col-xs-12">
        <div class="col-sm-12 well">
            <h1> STEP 1</h1>
            <div class="col-md-push-2 col-md-7"><div class="form-group">
                    <label for="countq" class="control-label">Choose one...</label>
                    <select name="countq" id="countq" class="form-control" value="{{ old('countq') }}" v-model="steps.step3.isMore">
                        <option value="1">I want to sell only one account</option>
                        <option value="2">I have more similar account to sell</option>
                    </select>
                </div>
                <div  class="form-group" v-if="steps.step3.isMore >1">
                    <label for="count" class="control-label">How many accounts do you want to sell?</label>
                    <input name="count" id="count" type="number" class="form-control" value="{{ old('count') }}" v-model="steps.step3.count | splitLong 3"/>
                </div>

                <div class="form-group">
                    <label for="first_owner" class="control-label">Are you the original and only owner of this account?</label>
                    <div class="input-group">
                        <div class="btn-group check">
                            <a class="btn btn-primary btn-md notActive" data-toggle="first_owner" data-title="1">YES</a>
                            <a class="btn btn-primary btn-md notActive" data-toggle="first_owner" data-title="-1">NO</a>
                        </div>
                        <input type="hidden" name="first_owner" id="first_owner" value="{{ old('first_owner') }}" v-model="steps.step3.firstOwner" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="has_email" class="control-label">Do you have access to the account's registered email address?</label>
                    <div class="input-group">
                        <div class="btn-group check">
                            <a class="btn btn-primary btn-md notActive" data-toggle="has_email" data-title="1">YES</a>
                            <a class="btn btn-primary btn-md notActive" data-toggle="has_email" data-title="-1">NO</a>
                        </div>
                        <input type="hidden" name="has_email" id="has_email" value="{{ old('has_email') }}" v-model="steps.step3.hasEmail" />
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
                        <input type="hidden" name="duration" id="duration" value="{{ old('duration') }}" v-model="steps.step3.duration">
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
                            <a class="btn btn-primary btn-md notActive" data-type="custom" data-toggle="delivery" data-title="-1">Custom</a>
                            <div class="input-group hidden"   id="deliverygroup">
                                <input type="number"
                                       step="any"
                                       name="delivery"
                                       id="delivery"
                                       value="{{ old('delivery') }}"
                                       aria-describedby="deliveryaddon"
                                       class="form-control"
                                       v-model="steps.step3.delivery | splitLong 3">
                                <span class="input-group-addon" id="deliveryaddon">Hours</span>
                            </div>
                        </div>
                    </div>
                </div></div>

        </div>
    </div>
    <div class="col-xs-12">
        <button nextpage="1" class="btn btn-primary btn-lg" v-on="click: nextStep">
            Next Step
        </button>
    </div>
</div>