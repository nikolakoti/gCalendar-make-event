<!doctype html>
<html lang="{{app()->getLocale()}}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link href="{{url('/skins/front/css/bootstrap.css')}}" rel="stylesheet" type="text/css"/>
        <!-- custom CSS -->
        <link href="{{url('/skins/front/css/style.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('/skins/front/js/jqplugins/datetimepicker-master/build/jquery.datetimepicker.min.css')}}" rel="stylesheet" type="text/css"/>

        <!--FONTS CSS-->
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> 

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <title>Form Meeting Scheduler</title>

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-7 col-lg-6 col-xl-7 m-auto pt-5">
                    <div class="card">
                        <div class="card-header text-capitalize text-center text-info">
                            <h5>create event with reminder</h5>
                        </div>
                        <div class="card-body">
                            <div id="success-message" class="alert alert-success text-center" role="alert" style="display: none;"></div>
                            <div id="error-message" class="alert alert-warning text-center" role="alert" style="display: none;"></div>
                            <form id="event-form" method="POST" action="">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Name<span>*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter first name">
                                        <div class="error pt-1"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Surname<span>*</span></label>
                                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Enter last name">
                                        <div class="error pt-1"></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Phone<span>*</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone">
                                        <div class="error pt-1"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>E-mail<span>*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your e-mail address">
                                        <div class="error pt-1"></div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Event date<span>*</span></label>
                                        <input type="text" class="form-control" id="datetimepicker1" name="date" placeholder="Enter event date">
                                        <div class="error pt-1"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Event time<span>*</span></label>
                                        <input type="text" class="form-control" id="datetimepicker2" name="time" placeholder="Enter event time">
                                        <div class="error pt-1"></div>
                                    </div>
                                </div>
                                <div class="form-row pt-3">
                                    <div class="form-group col-md-6 text-center">
                                        @captcha
                                    </div>
                                    <div class="form-group col-md-6 pt-2">
                                        <input type="text" class="form-control" id="captcha" name="captcha" placeholder="Enter captcha">
                                        <div class="error pt-1"></div>
                                    </div>
                                </div>
                               
                                <button type="submit" class="col-12 btn btn-primary mt-2 text-center" data-action="submit">Send</button>
                            </form>
                        </div>
                        <div class="card-footer text-center text-muted">
                            <p><small>Required fields are marked with <span>*</span></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{url('/skins/front/js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/skins/front/js/poper.js')}}" type="text/javascript"></script>
    <script src="{{url('/skins/front/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <!-- jqplugins scripts  -->
    <script src="{{url('/skins/front/js/jqplugins/jquery.validate.min.js')}}" type="text/javascript"></script>
    <script src="{{url('/skins/front/js/jqplugins/datetimepicker-master/build/jquery.datetimepicker.full.min.js')}}" type="text/javascript"></script>

    <!-- custom JS scripts  -->

    <script>
var ajaxRoute = "{{route('create.event')}}";
var loaderPath = "{{url('/skins/front/img/ajax-loader.gif')}}"
    </script>

    <script src="{{url('/skins/front/js/custom.js')}}" type="text/javascript"></script>
</body>
</html>
