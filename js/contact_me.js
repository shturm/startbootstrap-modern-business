/*
  Jquery Validation using jqBootstrapValidation
   example is taken from jqBootstrapValidation docs 
  */
$(function () {

    $("#contactForm").submit(function (event) {

        var name = $("input#name").val();
        var phoneOrEmail = $("input#phoneOrEmail").val();
        var message = $("textarea#message").val();
        // Check for white space in name for Success/Fail message

        $.ajax({
            url: "./bin/contact_me.php",
            type: "POST",
            data: {
                name: name,
                phoneOrEmail: phoneOrEmail,
                message: message,
                "g-recaptcha-response": grecaptcha.getResponse()
            },
            cache: false,
            success: function () {
                // Success message
                $('#success').html("<div class='alert alert-success'>");
                $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                    .append("</button>");
                $('#success > .alert-success')
                    .append("<strong>Съобщението ви е изпратено. Съвсем скоро ще се свържем с вас.</strong>");
                $('#success > .alert-success')
                    .append('</div>');

                //clear all fields
                $('#contactForm').trigger("reset");
            },
            error: function () {
                // Fail message
                $('#success').html("<div class='alert alert-danger'>");
                $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                    .append("</button>");
                $('#success > .alert-danger').append("<strong>За съжаление имаше пробле при изпращането.</strong> Моля изпратете имейл директно до hello@smetko.bg. Извинете за неудобството !");
                $('#success > .alert-danger').append('</div>');
                //clear all fields
                $('#contactForm').trigger("reset");
            },
        })
    });

    // $("a[data-toggle=\"tab\"]").click(function (e) {
    //     e.preventDefault();
    //     $(this).tab("show");
    // });
});


/*When clicking on Full hide fail/success boxes */
$('#name').focus(function () {
    $('#success').html('');
});
