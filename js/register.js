$(document).ready(function() {
    $('.email').blur(function() {

        var email = $(this).val();

        $.ajax({
            url: 'emailAvailability.php',
            method: "POST",
            data: { emailAvailability: email },
            success: function(data) {
                if (data != '0') {
                    $('#availability').html('<span class="text-danger">Email niet beschikbaar</span>');
                    $('#submit').attr("disabled", true);
                } else {
                    $('#availability').html('<span class="text-success">Email beschikbaar</span>');
                    $('#submit').attr("disabled", false);
                }
            }
        })

    });
});