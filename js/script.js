$(function(){
    $('.reply-comment').on('click', function(e){
        e.preventDefault();
        $(this).next('.reply-form').toggle(700);
    });
});