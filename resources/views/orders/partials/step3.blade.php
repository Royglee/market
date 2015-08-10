{{--Step 3 inactive,both--}}
<div class="row">
    <div class="trade trade-inactive col-sm-12">
        <h3>Step 3</h3>
        <p>Buyer checks the account. </p>
    </div>
</div>

{{--Step 3 pending, buyer--}}
<div class="row pending-row">
    <div class="trade trade-pending col-sm-8">
        <h3>Step 3</h3>
        <p>Buyer checks the account. If everything is correct, and the account is verified to
            the buyer's e-mail adress, then the buyer verifies it, else he call an admin. </p>
    </div>
    <div class="trade trade-opt-check trade-pending col-sm-2">
        <p>Everything is correct. The account is verified to my e-mail adress.</p>
    </div>
    <div class="trade trade-opt-close trade-pending col-sm-2">
        <p>Something is not okay. I need an admin.</p>
    </div>
</div>

{{--Step 3 pending,seller--}}
<div class="row pending-row">
    <div class="trade trade-pending col-sm-12">
        <h3>Step 3</h3>
        <p>Waiting for the buyer to check the account. </p>
    </div>
</div>

{{--Step 3 done,both--}}
<div class="row">
    <div class="trade trade-done col-sm-12">
        <h3>Step 3</h3>
        <p>Buyer checked the account, and everything was okay.</p>
    </div>
</div>

{{--Step 3 error,both--}}
<div class="row">
    <div class="trade trade-error col-sm-12">
        <h3>Step 3</h3>
        <p>Buyer checked the account, and something wasn't okay.
            Waiting for the admin...
        </p>
    </div>
</div>