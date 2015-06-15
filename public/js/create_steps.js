/**
 * Created by Marcell on 2015.06.04..
 */

create = new Vue({
    el:'#create-page',

    filters: {
        splitLong: {
            read:function(val,oldval, max){
                if (val.length > max || val < 0){
                    return oldval;
                }
                return val;
            },
            write:function(val, oldval, max){
                if (val.length > max || val < 0){
                    return oldval;
                }
                return val;
            }
        }
    },
    methods:{
        showStep:function(step, e){
            e.preventDefault();
            if(step.disabled != true) {
                for (var otherStep in this.steps) {
                    this.steps[otherStep].active = false;
                }
                step.active = true;
            }
        },
        nextStep: function(e){
            var next = this.steps['step'+e.target.getAttribute('nextpage')];
            next.disabled = false;
            this.showStep(next,e);
        },
        hasDivision: function(){
            var league = this.steps.step1.league;
            if (league != "Master" && league != "Challenger" && league != "Unranked"){
                return true;
            }
            else return false;
        }

    },
    data:{
        steps:{
            step3:{
                disabled:false,
                active:true,
                number:1,
                desc:'First step description',
                isMore:($('#countq').attr('value'))? $('#countq').attr('value') : '',
                count:'',
                firstOwner:'',
                hasEmail:'',
                duration:'',
                delivery:''


            },
            step1:{
                disabled: ($('#errors').data('error') > 0)? false : true,
                active:false,
                number:2,
                desc:'Second step description',
                title:($('#title').attr('value'))? $('#title').attr('value') :  '',
                server:($('#server').attr('value'))? $('#server').attr('value') :  '',
                league:($('#league').attr('value'))? $('#league').attr('value') : 'Unranked',
                division:($('#division').attr('value'))?$('#division').attr('value') : '1',
                champions:'',
                skins:'',
                price:''
            },
            step2:{
                disabled:($('#errors').data('error') > 0)? false : true,
                active:false,
                number:3,
                desc:'Third step description'

            }
        }
    },
    computed:{
        leagueDiv: function(){
            var league = this.steps.step1.league;
            var division = this.steps.step1.division;
            if (league != "Master" && league != "Challenger" && league != "Unranked"){
                return league+' '+division;
            }
            else {
                return league;
            }
        },
        image: function(){
            var league = this.steps.step1.league;
            var division = this.steps.step1.division;
            if (this.hasDivision()){
                return league+'_'+division+'.png';
            }
            else {
                return league+'.png';
            }
        }
    },
    ready:function(){
        var step1 =['countq', 'count', 'first_owner', 'has_email', 'duration', 'delivery'];
        var step2 = ['title','price','server','league','division','champions','skins'];
        var errorlist = $(' #errors ').text().split(' ');
        var isError = ($('#errors').data('error') > 0)? true : false;
        var firstError = "";
        if (isError) {
           if (firstError == "") {
               $.each(step1, function (index, value) {
                   if ($.inArray(value, errorlist) != -1) {
                       firstError="#step-1";
                   }
               });
           }
            if (firstError == "") {
                $.each(step2, function (index, value) {
                    if ($.inArray(value, errorlist) != -1) {
                        firstError="#step-2";
                    }
                });
            }
            if (firstError == "") {
                firstError="#step-3";
            }


            $(' ul.setup-panel a[href="'+firstError+'"] ').closest('li').click();
        }

        var intRegex =  /^[/.]accounts[/.][0-9]+[/.]edit+$/g;
        var pathname = $(location).attr('pathname');
        if (intRegex.test(pathname)){
            this.steps.step1.disabled = false;
            this.steps.step1.active = true;
            this.steps.step2.disabled = false;
            this.steps.step2.active = true;
            this.steps.step3.disabled = false;
            this.steps.step3.active = true;
            $(' button[nextpage] ').hide();
        }
    }
});


$(document).ready(function() {
    $("#editor").wysibb({
        minheight:200
    });
    $('.check a').on('click', function(){
        var sel = $(this).data('title');
        var tog = $(this).data('toggle');
        if($(this).data('type') != 'custom'){
        $('#'+tog).prop('value', sel);}

        $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
        $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
    })
    $(' #deliveryselect ').on('click',function(){
        var custom = $("a[data-type='custom']").hasClass('active');
        var delivery = $('#deliverygroup');
        if (custom){
            delivery.removeClass('hidden');
            $('#delivery').focus();
        }
        else{delivery.addClass('hidden');}
    });

    $('.check a').each(function( index ) {
        var tog = $(this).data('toggle');
        var sel = $(this).data('title');
        var value = $('#'+tog).attr('value');

        if(value == sel && value != ""){
            $(this).removeClass('notActive').addClass('active');
        }
        if($(this).data('type') == 'custom' && jQuery.inArray(value, ['0.33','2','24','48','0,33']) == -1 && value){
            $(this).removeClass('notActive').addClass('active');
            $('#deliverygroup').removeClass('hidden');
        }
    });
});