<div class="row setup-content" id="step-2" v-show="steps.step2.active">
    <div class="col-xs-12">
        <div class="col-sm-12 well">
            <h1> STEP 3</h1>
            <label for="editor">Write something about your account...</label>
            <textarea style=""  id="editor" name="body" >{{ old('body') }}</textarea>
        </div>
    </div>
    <div class="col-xs-12">
        <input type="submit" value="Submit">
    </div>
</div>