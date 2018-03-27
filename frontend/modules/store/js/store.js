$(document).ready(function(){
    $(".store_pjax_item").on("pjax:end", function() {
        $.pjax.reload({
            container:"#basket"
        });
    });
});