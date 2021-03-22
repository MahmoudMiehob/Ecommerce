$(document).ready(function(){

    'use strict';


    $('.login-page h1 span').click(function(){
        $(this).addClass('selected').siblings().removeClass('selected');


        $('.login-page form').hide();

        $('.' + $(this).data('class')).show(100);

    });

 

    $('input').each(function(){
        if($(this).attr('required') === 'required'){
            $(this).after('<span class="asterick">*</span>');
        }
    });

 

    $('.confirm').click(function(){
        return confirm('Are You sure ?');
    });


    $('.live-name').keyup(function(){
        $('.live-preview .caption h3').text($(this).val());
     });

     $('.live-desc').keyup(function(){
        $('.live-preview .caption p').text($(this).val());
     });

     $('.live-price').keyup(function(){
        $('.live-preview .price').text('$' + $(this).val());
     });

});