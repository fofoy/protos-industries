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
    $('footer a').bind('click', function(){
        $(this).hasClass('muted') ? SC_player.setVolume(100) : SC_player.setVolume(0);
        $(this).toggleClass('muted');
        return false;
    });

    // Toggle on the disabled password input
    $('#yes').bind('click',function(){
        $(this).next().attr('disabled',false);
    });
    $('#no').bind('click',function(){
        $('#password_disabled').attr('disabled',true);
    });
    
});