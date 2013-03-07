$(function(){

    // Get the SoundCloud Player
    var iframeElement = document.querySelector('iframe');
    var SC_player     = SC.Widget(iframeElement);

    // Repeat the sound in loop
    SC_player.bind(SC.Widget.Events.FINISH, function() {
        SC_player.seekTo(0);
        SC_player.play();
    });

    // Bind the mute button
    $('footer > a').bind('click', function(){
        $(this).hasClass('muted') ? SC_player.setVolume(100) : SC_player.setVolume(0);
        $(this).toggleClass('muted');
        if ($('footer > a i').hasClass('icon-volume-up')){
            $('footer > a i').removeClass('icon-volume-up');
            $('footer > a i').addClass('icon-volume-off');
        } else {
            $('footer > a i').removeClass('icon-volume-off');
            $('footer > a i').addClass('icon-volume-up');
        }
        return false;
    });

    // Toggle on the disabled password input
    $('#yes').bind('click',function(){
        $('#password_disabled').attr('disabled',false);
    });
    $('#no').bind('click',function(){
        $('#password_disabled').attr('disabled',true);
    });
    
    // Affichage panneau organ
    $('#a_perso').click(function(){
        $('#organ_resume').hide();
        $('#organ_perso').slideDown();
    });

    $('#a_resume').click(function(){
        $('#organ_perso').hide();
        $('#organ_resume').slideDown();
    });
    $('#organ_resume').hide();

    // Personalization & Effect On Price
    $('.range').change(function(){
        var total = 0;
        $(this).prevAll('.characteristic_value').text($(this).context.value);
        $(this).nextAll('.atr_price').find('.charac_price').text($(this).context.value*6);
        // Calculate the organ price
        $('.charac_price').each(function(){
            total += parseInt($(this).text());
        });
        // Retrieve the organ price
        $('.total').text(parseInt($('.initial_price').html())+total+'$');
    });

    //HOME
    $('#scrolling_text').scroll(function(){
        $("#scrolldown").animate({
            opacity: 0
          }, 1000 );
    });

    $('#scrolldown').click(function(){
        $("#scrolling_text").animate({
            scrollTop: 200
          }, 1000 );
    });

    $('.submit_organ').click(function(){
        var price = $('.atr_price.total').html();
        $.post(window.location.href,price,function(data) {
            console.log('ok');
        });
    });


});