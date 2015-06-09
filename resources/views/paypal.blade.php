<html>
<head>
    <script type="text/javascript" src="https://www.paypalobjects.com/js/external/dg.js"></script>
</head>

<body>
<form id="paypalform" action="https://www.sandbox.paypal.com/webapps/adaptivepayment/flow/pay" target="PPDGFrame" class="standard">
    <input id="type" type="hidden" name="expType" value="light">
    <input id="paykey" type="hidden" name="paykey" value="{{$paykey}}">
</form>
$('#paypalform').trigger('click').submit();
<button onclick="$('#paypalform').trigger('click').submit();">
    CLICK
</button>
<style>
    .standard{
        display: none;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">

    var embeddedPPFlow1 = new PAYPAL.apps.DGFlow( {trigger : 'paypalform'});
</script>

</body>

</html>