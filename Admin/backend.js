$(document).ready(function(){

    'use strict';


    $('.toggel-info').click(function () {
        $(this).toggleClass('selected').parent().next('.panel-body').slideToggle(600);

        if($(this).hasClass('selected')){

            $(this).html('<i class="fa fa-plus fa-lg"></i>');
        }else{
            $(this).html('<i class="fa fa-minus fa-lg"></i>');
        }
    });

    $('input').each(function(){
        if($(this).attr('required') === 'required'){
            $(this).after('<span class="asterick">*</span>');
        }
    });

    var passFiled = $('.password')
    $('.show-pass').hover(function(){

        passFiled.attr('type' , 'text');

    },function(){

        passFiled.attr('type' , 'password');

    });

    $('.confirm').click(function(){
        return confirm('Are You sure ?');
    });



    $('.cat h3').click(function(){

        $(this).next('.full-view').slideToggle(600);
        
    });


    $('.option span').click(function (){

        $(this).addClass('active').siblings('span').removeClass('active');

        if($(this).data('view') === 'full'){
            $('.cat .full-view').slideDown(200);
        }else{

            $('.cat .full-view').slideUp(200);

        }

    });



});