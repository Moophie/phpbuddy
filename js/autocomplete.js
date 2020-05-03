// AJAX call for autocomplete 
$(document).ready(function() {
    $(".search").keyup(function() {
        $.ajax({
            type: "POST",
            url: "searchClass.php",
            data: 'keyword=' + $(this).val(),
            success: function(data) {
                $(".suggestions").show();
                $(".suggestions").html(data);
                $(".search-box").css("background", "#FFF");
            }
        });
    });
});

//To select class name
function selectClass(val) {
    $(".search").val(val);
    $(".suggestions").hide();
}