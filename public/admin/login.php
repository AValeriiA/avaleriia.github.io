<?php
    require_once "../../app/kernel.php";
    if (Admin::isLogged()) {
        header("location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <title>Summer catchers</title>

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#5b7dff">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#5b7dff">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#5b7dff">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 offset-sm-2 col-sm-8 offset-md-3 col-md-6 offset-lg-4 col-lg-4">
            <div class="form-group row justify-content-center" style="margin-top: 50px">
                <h1>Please Login</h1>
            </div>
            <div class="form-group row">
                <label for="login_name" class="col-sm-2 col-form-label">Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="login_name" name="user">
                </div>
            </div>
            <div class="form-group row">
                <label for="login_pass" class="col-sm-2 col-form-label">Pass:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="login_pass" name="pass">
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <button type="button" class="btn btn-primary" id="login_btn">Login</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<script>
    //admin functions
    $(document).ready(function () {
        $("#login_btn").on("click", function () {
            $.ajax({
                url: "<?php echo $global['website_root'].'api/login.php'?>",
                data: {
                    "user": $('#login_name').val(),
                    "pass": $('#login_pass').val()
                },
                type: 'post',
                success: function (response) {
                    if (!response.error) {
                        location = "index.php";
                    } else {
                        alert("ERROR: " + response.error);
                    }
                },
                error: function () {
                    alert("Server error!");
                }
            });
        });
    });
</script>
</body>
</html>
