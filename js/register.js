$(document).ready(function() {
    //Check for email availability if the email input loses focus
    $('.email').blur(function() {
        var email = $(this).val();

        $.ajax({
            url: 'emailAvailability.php',
            method: "POST",
            data: { emailAvailability: email },
            success: function(data) {
                //Display a message depending on if the email already exists or not
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