$(document).ready(function(){
    $('.previous-tab').click(function(e){
        if($('#armory_character_menu > li a.active').parent().index() == 0){
            $('#armory_character_menu > li:nth-last-child(3)').find('a').trigger('click');
        }else{
            console.log('prev', $('#armory_character_menu > .active'));
            $('#armory_character_menu > li a.active').parent().prev('li').find('a').trigger('click')
        }
        e.preventDefault();
    });
    $('.next-tab').click(function(e){
        if($('#armory_character_menu > li a.active').parent().next('li').hasClass('previous-tab')){
            $('#armory_character_menu > li').first('li').find('a').trigger('click')
        }else{
            $('#armory_character_menu > li a.active').parent().next('li').find('a').trigger('click')
        }
        e.preventDefault();
    });
});
$('#armory-form').submit(function() {
    if($('#server').val() && $('#query').val().length >= 2) {
        window.location = $(this).attr("action") + '/' + $('#server').val() + '/' + $('#query').val();
    }
    return false;
});