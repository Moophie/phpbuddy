$(document).ready(function() {
    // AJAX call for autocomplete 
    $(".search").keyup(function() {
        $.ajax({
            type: "POST",
            url: "searchClass.php",
            data: 'keyword=' + $(this).val(),
            success: function(data) {
                $(".suggestions").show();
                //Put the returned data in the suggestion box
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

//Put the selected classroom in the input field and hide the suggestion box when someone clicks on a suggestion
function selectClass(val) {
    $(".search").val(val);
    $(".suggestions").hide();
}