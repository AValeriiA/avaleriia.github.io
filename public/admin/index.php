<?php
    require_once "../../vendor/autoload.php";
    require_once "../../app/models/SMTPMailer.php";

    require_once "../../app/kernel.php";
    if (!Admin::isLogged()) {
        header("location: login.php");
        exit;
    }

    $sql = "SELECT * FROM citations LIMIT 3";
    $res = $global['pdo']->prepare($sql);
    $res->execute($params);
    $citations = $res->fetchAll(PDO::FETCH_ASSOC);
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

<div class="container">
    <div class="row">
        <form action="<?php echo $global['website_root']; ?>api/saveCitations.php" method="post" enctype="multipart/form-data" class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="form-group row justify-content-center" style="margin-top: 50px">
                        <h1>Citations</h1>
                    </div>
                </div>
                <?php foreach ($citations as $citate) {?>
                    <div class="col-12 col-sm-6 col-md-4 form-group">
                        <textarea class="form-control" rows="5" name="cit[<?php echo $citate['id']; ?>][text]"><?php echo $citate['text']; ?></textarea>
                        <input type="text" class="form-control" name="cit[<?php echo $citate['id']; ?>][who]" value="<?php echo $citate['who']; ?>">
                    </div>
                <?php } ?>
                <div class="col-12">
                    <div class="form-group row justify-content-center">
                        <button type="submit" class="btn btn-primary" id="citations_btn">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <form action="<?php echo $global['website_root']; ?>api/uploadImages.php" method="post" enctype="multipart/form-data" class="col-12">
            <input type="hidden" name="type" value="screenshots/">
            <div class="row">
                <div class="col-12">
                    <div class="form-group row justify-content-center" style="margin-top: 50px">
                        <h1>Upload screenshots</h1>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group row justify-content-center">
                        <p>Old screenshots will be deleted</p>
                    </div>
                </div>
                <div class="col-12 form-group">
                    <input type="file" class="form-control" name="img[]" multiple>
                </div>
                <div class="col-12">
                    <div class="form-group row justify-content-center">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <form action="<?php echo $global['website_root']; ?>api/uploadImages.php" method="post" enctype="multipart/form-data" class="col-12">
            <input type="hidden" name="type" value="thumbnails/">
            <div class="row">
                <div class="col-12">
                    <div class="form-group row justify-content-center" style="margin-top: 50px">
                        <h1>Upload thumbnails</h1>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group row justify-content-center">
                        <p>Old thumbnails will be deleted</p>
                    </div>
                </div>
                <div class="col-12 form-group">
                    <input type="file" class="form-control" name="img[]" multiple>
                </div>
                <div class="col-12">
                    <div class="form-group row justify-content-center">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group row justify-content-center" style="margin-top: 50px">
                <h1>Write an email for subscribers</h1>
            </div>
        </div>
        <div class="col-12 form-group">
            <textarea class="form-control" rows="12" id="email_text"></textarea>
        </div>
        <div class="col-12">
            <div class="form-group row justify-content-center">
                <button type="button" class="btn btn-primary" id="send_email">Send</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<script>
    <?php
    if (!empty($_GET['msg'])) {
        echo "alert('".$_GET['msg']."');";
    } ?>

    $(document).ready(function () {
        $("#send_email").on("click", function () {
            $("#send_email").prop("disabled", true);
            $.ajax({
                url: "<?php echo $global['website_root'].'api/sendToSubscribers.php'?>",
                data: {
                    "email": $('#email_text').val()
                },
                type: 'post',
                success: function (response) {
                    if (!response.error) {
                        alert("Email has been successfully put in the send queue!");
                        $("#send_email").prop("disabled", false);
                    } else {
                        alert("ERROR: " + response.error);
                    }
                },
                error: function () {
                    alert("Server error!");
                }
            });
        })
    });
</script>
</body>
</html>
