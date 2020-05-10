// AJAX call for autocomplete 
$(document).ready(function() {
    // AJAX call for autocomplete 
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

    $(".button-reject").click(function() {
        var reason = prompt("Press ok to tell the person the reason for the rejection, cancel if you don't want to.", "Write reason here");

        $(".reject-reason").val(reason);
    });
});

//To select class name
function selectClass(val) {
    $(".search").val(val);
    $(".suggestions").hide();
}