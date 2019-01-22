$(document).ready(function () {

    console.log(ajaxRoute);
    console.log(loaderPath);

    function popUpTime(element) {

        element.datetimepicker({
            datepicker: false,
            format: 'H:i:s'
        });
    }

    function popUpDate(element) {
        element.datetimepicker({
            timepicker: false,
            format: 'Y-m-d'
        });
    }

    function resetForm(element) {

        return element[0].reset();
    }
    var form = $('#event-form');

    var date = $('#datetimepicker1');
    var time = $('#datetimepicker2');


    popUpTime(time);

    popUpDate(date);

    //client-side form validation 

    form.validate({

        rules: {
            name: {
                required: true,
                rangelength: [2, 20]
            },

            surname: {
                required: true,
                rangelength: [2, 20]
            },

            phone: {
                required: true,
                digits: true
            },

            email: {
                required: true,
                email: true

            },

            time: {
                required: true

            },

            date: {

                required: true,
                date: true
            },

            captcha: {
                required: true
            }

        },
        messages: {

            name: {

                required: "Name field is required.",
                rangelength: "Please enter a name between 2 and 20 chars long."

            },

            surname: {

                required: "Surname field is required.",
                rangelength: "Please enter a surname between 2 and 20 chars long."

            },

            phone: {
                required: "Phone field is required.",
                digits: "Please enter only digits."

            },

            email: {
                required: "Email field is required.",
                email: "Enter valid email adress."
            },

            time: {

                required: "Time field is required."
            },

            date: {
                required: "Date field is required.",
                date: "Please enter a valid date."
            },

            captcha: {
                required: "Captcha field is required!"
            }


        },
        errorElement: 'p',
        errorPlacement: function (error, element) {
            error.appendTo($(element).closest('.form-group').find('.error'));
        }
    });

    var button = $('#event-form button');

    //sending form data to create event 

    form.on('submit', function (e) {

        e.preventDefault();

        var name = $('[name="name"]').val();
        var surname = $('[name="surname"]').val();
        var phone = $('[name="phone"]').val();
        var email = $('[name="email"]').val();
        var time = $('[name="time"]').val();
        var date = $('[name="date"]').val();
        var captcha = $('[name="captcha"]').val();
        var csrf_token = $('[name="_token"]').val();


        $.ajax({

            'type': "POST",
            'url': ajaxRoute,
            'data': {
                'name': name,
                'surname': surname,
                'phone': phone,
                'email': email,
                'time': time,
                'date': date,
                'captcha': captcha,
                '_token': csrf_token
            },

            'beforeSend': function () {

                if (name !== '' && email !== '' && surname !== '' && phone !== '' && time !== '' && date !== '' && captcha !== '') {

                    var loaderGif = '<img id="loader" class="text-center" src="' + loaderPath + '" alt=""/>';

                    button.html(loaderGif);

                }


            },
            'complete': function () {

                button.html("<p>Send</p>");

            }


        }).done(function (response) {

            //alert(response);

            if (response.state == 'success') {

                $('html,body').animate({
                    scrollTop: $("#success-message").offset().top},
                        'slow');

                var success = $('#success-message');

                success.fadeIn('slow');

                success.text(response.message);

                resetForm(form);

                setTimeout(function () {
                    $('#success-message').fadeOut('slow');
                }, 5000);

            }

        }).fail(function (response) {

            var string = JSON.stringify(response);

            var parsed = JSON.parse(string);

            var captcha = parsed.responseJSON.errors.captcha;

            //getting captcha validate response
            if (Array.isArray(captcha) && captcha[0] == 'Invalid code from the image.') {

                $('html,body').animate({
                    scrollTop: $("#error-message").offset().top},
                        'slow');

                var error = $('#error-message');

                error.fadeIn('slow');

                error.text(captcha[0]);

                setTimeout(function () {
                    $('#error-message').fadeOut('slow');
                }, 5000);
            }

            if (response.state == 'error') {

                $('html,body').animate({
                    scrollTop: $("#error-message").offset().top},
                        'slow');

                var error = $('#error-message');

                error.fadeIn('slow');

                error.text(response.message);

                setTimeout(function () {
                    $('#error-message').fadeOut('slow');
                }, 5000);
            }

        });
    });
});


