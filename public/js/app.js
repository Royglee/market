(function ($) {
// VERTICALLY ALIGN FUNCTION
    $.fn.vAlign = function() {
        return this.each(function(i){
            var ah = $(this).height();
            var ph = $(this).parent().height();
            var mh = Math.ceil((ph-ah) / 2);
           // $(this).parent().css('padding-top', mh);
            $(this).css('margin-top', mh);
        });
    };
})(jQuery);

$(document).ready(function(){
    $(' h1.dp_acc_title ').vAlign();
    $(' .acc_meta ').vAlign();
    $( window ).resize(function() {
        $(' h1.dp_acc_title ').vAlign();
    });
    $('[data-toggle="tooltip"]').tooltip();

   //Paypal Buy button
    $('#buynow_button').click(function(e){
        e.preventDefault();
        var url = $(this).data('href');
        var paypalForm = $('#paypalform');
        var payKey = $('#paykey');
        var Loading = $(this).find('#loading')
        Loading.removeClass('hidden');
        $.get( url, function( data ) {
            payKey.val(data);
            paypalForm.trigger('click').submit();
            Loading.addClass('hidden');
        });
    });
});