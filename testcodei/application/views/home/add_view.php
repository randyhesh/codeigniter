<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CodeI</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    </head>
    <body>

        <div class="jumbotron text-center">
            <h1>Add New</h1>            
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-5">
                    <form id="add_form">
                        <div class="form-group">
                            <label for="email">Email address:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" id="pwd" name="pwd">
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox"> Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form> 
                </div>
            </div>
        </div>

    </body>
</html>

<script type="text/javascript">

    $(document).ready(function () {

        $("#add_form").validate({
            rules: {
                pwd: "required",
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                name: "Please specify your name",
                email: {
                    required: "We need your email address to contact you",
                    email: "Your email address must be in the format of name@domain.com"
                }
            },
            submitHandler: function (form) {

                $.ajax({
                    type: "post",
                    //dataType: "json",
                    url: "<?php echo site_url(); ?>/home_controller/add_data",
                    data: $("#add_form").serialize(),
                    success: function (data) {

                        alert("success");
                        window.location = "<?php echo site_url(); ?>/home_controller/";
                    },
                    error: function (data) {
                        alert("Error");
                    },
                });
            }
        });

    });

</script>