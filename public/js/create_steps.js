/**
 * Created by Marcell on 2015.06.04..
 */

new Vue({
    el:'#create-page',
    filters: {
        splitLong: {
            read:function(val,oldval, max){
                if (val.length > max){
                    return oldval;
                }
                return val;
            },
            write:function(val, oldval, max){
                if (val.length > max){
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
            step1:{
                disabled:false,
                active:false,
                number:1,
                desc:'First step description',
                title:'',
                server:'',
                league:'Unranked',
                division:'1',
                champions:'',
                skins:'',
                price:''
            },
            step2:{
                disabled:true,
                active:false,
                number:2,
                desc:'Second step description'

            },
            step3:{
                disabled:false,
                active:true,
                number:3,
                desc:'Third step description',
                isMore:'',
                count:'',
                firstOwner:'',
                hasEmail:'',
                duration:'',
                delivery:''


            },
            step4:{
                disabled:true,
                active:false,
                number:4,
                desc:'Fourth step description'
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
    }
});


$(document).ready(function() {
    $("#editor").wysibb({
        minheight:200
    });
})