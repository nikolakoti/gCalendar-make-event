$(document).ready(function () {

    var time = $('#datetimepicker1');

    var date = $('#datetimepicker2');

    time.datetimepicker({
        datepicker: false,
        format: 'H:i'
    });

    date.datetimepicker({
        timepicker: false,
        format: 'd/M/y'
    });

    //client-side form validation 

    $("#event-form").validate({

        rules: {
            name: {
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
            }

        },
        messages: {

            name: {

                required: "Name field is required.",
                rangelength: "Please enter a name between 2 and 20 chars long."

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
            }


        },
        errorElement: 'p',
        errorPlacement: function (error, element) {
            error.appendTo($(element).closest('.form-group').find('.error'));
        }
    });
});


