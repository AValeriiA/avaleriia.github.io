<?php
    require_once "../../app/kernel.php";
    if (!Admin::isLogged()) {
        header("location: login.php");
        exit;
    }

    $sql = "SELECT * FROM citations LIMIT 3";
    $res = $global['pdo']->query($sql);
    while ($row = $res->fetch_assoc()) {
        $citations[] = $row;
    }

    $sql = "SELECT * FROM emails WHERE is_greeting = 1 ORDER BY created DESC LIMIT 1";
    $res = $global['pdo']->query($sql);
    $currentGreeting = $res->fetch_assoc();

    $sql = "SELECT count(id) as delivered FROM subscribes WHERE notice_delivered = 1 GROUP BY notice_delivered";
    $res = $global['pdo']->query($sql);
    $noticeDelivered = $res->fetch_assoc();
    $noticeDelivered = $noticeDelivered ? $noticeDelivered['delivered'] : 0;

    $sql = "SELECT count(id) as undelivered FROM subscribes WHERE notice_delivered = 0 GROUP BY notice_delivered";
    $res = $global['pdo']->query($sql);
    $noticeUnDelivered = $res->fetch_assoc();
    $noticeUnDelivered = $noticeUnDelivered ? $noticeUnDelivered['undelivered'] : 0;

    if ($noticeDelivered + $noticeUnDelivered) {
        $percent = ($noticeDelivered / ($noticeDelivered + $noticeUnDelivered)) * 100;
    } else {
        $percent = 0;
    }

    $sql = "SELECT * FROM images WHERE thumbnail = 2";
    $res = $global['pdo']->query($sql);
    while ($row = $res->fetch_assoc()) {
        $imagesForEmails[] = $row;
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
                    <input type="file" class="form-control" name="img[]" multiple required>
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
                    <input type="file" class="form-control" name="img[]" multiple required>
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
        <div class="col-12">
            <div class="form-group row justify-content-center">
                <button id="edit_msg_tab" class="btn btn-primary">Edit subscription message</button>
                <button id="new_msg_tab" class="btn btn-secondary" style="margin-left: 10px">Create new email for subscribers</button>
            </div>
        </div>
        <div class="col-12 form-group">
            <div id="div_edit_email_text">
                <textarea class="form-control" rows="12" id="edit_email_text" name="edit_email_text"><?php echo $currentGreeting['body']; ?></textarea>
            </div>
            <div id="div_new_email_text">
                <textarea class="form-control" rows="12" id="new_email_text" name="new_email_text"></textarea>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group row justify-content-center">
                <button type="button" class="btn btn-primary" id="send_email">Send</button>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group row justify-content-center">
                Email delivered to <?php echo (int)$percent ?>% of subscribers
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <div class="form-group row justify-content-center" style="margin-top: 70px;">
                <button id="edit_support_email" class="btn btn-primary">Support email</button>
                <button id="edit_send_email" class="btn btn-secondary" style="margin-left: 10px">Send email</button>
            </div>
        </div>
        <div class="col-12">
            <form action="<?php echo $global['website_root'] ?>api/saveSupportEmail.php" method="post" id="form_support_email">
                <input type="hidden" name="mode" value="support">
                <div class="form-group row justify-content-center">
                    <div class="col-12 col-sm-4 col-md-3 col-lg-2 align-self-center justify-self-end">Login:</div>
                    <div class="col-9 col-sm-6 col-lg-4"><input type="email" name="email" class="form-control" value="<?php echo $global['support_email'] ?>" required></div>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-12 col-sm-4 col-md-3 col-lg-2 align-self-center justify-self-end">Pass:</div>
                    <div class="col-9 col-sm-6 col-lg-4"><input type="password" name="pass" class="form-control" value="<?php echo $global['support_pass'] ?>" required></div>
                </div>
                <div class="form-group row justify-content-center">
                    <button type="submit" id="support-email-save" class="btn btn-primary">Save</button>
                </div>
            </form>
            <form action="<?php echo $global['website_root'] ?>api/saveSupportEmail.php" method="post" id="form_send_email" style="display: none;">
                <input type="hidden" name="mode" value="send">
                <div class="form-group row justify-content-center">
                    <div class="col-12 col-sm-4 col-md-3 col-lg-2 align-self-center justify-self-end">Login:</div>
                    <div class="col-9 col-sm-6 col-lg-4"><input type="email" name="email" class="form-control" value="<?php echo $global['send_email'] ?>" required></div>
                </div>
                <div class="form-group row justify-content-center">
                    <div class="col-12 col-sm-4 col-md-3 col-lg-2 align-self-center justify-self-end">Pass:</div>
                    <div class="col-9 col-sm-6 col-lg-4"><input type="password" name="pass" class="form-control" value="<?php echo $global['send_pass'] ?>" required></div>
                </div>
                <div class="form-group row justify-content-center">
                    <button type="submit" id="support-email-save" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12" style="margin-top: 50px; margin-bottom: 50px;">
            <form action="<?php echo $global['website_root'] ?>api/uploadImagesForEmails.php" enctype="multipart/form-data" method="post">
                <div class="form-group row justify-content-center">
                    <div class="col-12 col-sm-5 col-md-4 col-lg-3 align-self-center justify-self-end">Upload images for emails:</div>
                    <div class="col-9 col-sm-6 col-lg-4">
                        <input type="file" class="form-control" name="img[]" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
            <div>Already exists images:</div>
            <div>
                <select class="form-control" multiple size="10" onchange="copy(this.options[this.selectedIndex].innerHTML)">
                    <?php foreach ($imagesForEmails as $img) {
                        echo "<option>".$global['website_root'].'assets/images/forEmail/'.$img['filename']."</option>";
                    } ?>
                </select>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script>
    <?php
    if (!empty($_GET['msg'])) {
        echo "alert('".$_GET['msg']."');";
    } ?>

    function copy (string) {
        function handler (event){
            event.clipboardData.setData('text/plain', string);
            event.preventDefault();
            document.removeEventListener('copy', handler, true);
        }

        document.addEventListener('copy', handler, true);
        document.execCommand('copy');
    }

    $(document).ready(function () {
        $("#send_email").on("click", function () {
            $("#send_email").prop("disabled", true);
            var mode = $("#new_msg_tab").hasClass("btn-primary") ? "new" : "edit",
                body = $("#new_msg_tab").hasClass("btn-primary") ? CKEDITOR.instances.new_email_text.getData() : CKEDITOR.instances.edit_email_text.getData();

            $.ajax({
                url: "<?php echo $global['website_root'].'api/sendToSubscribers.php'?>",
                data: {
                    "mode": mode,
                    "email": body
                },
                type: 'post',
                success: function (response) {
                    if (!response.error) {
                        alert(mode == "new" ? "Email has been successfully put in the send queue!" : "Confirmation email is saved!");
                        $("#send_email").prop("disabled", false);
                    } else {
                        alert("ERROR: " + response.error);
                    }
                },
                error: function () {
                    alert("Server error!");
                }
            });
        });

        $("#new_msg_tab").on("click", function () {
            $("#div_edit_email_text").hide();
            $("#div_new_email_text").show();
            $("#new_msg_tab").removeClass("btn-secondary").addClass("btn-primary");
            $("#edit_msg_tab").removeClass("btn-primary").addClass("btn-secondary");
        });

        $("#edit_msg_tab").on("click", function () {
            $("#div_new_email_text").hide();
            $("#div_edit_email_text").show();
            $("#edit_msg_tab").removeClass("btn-secondary").addClass("btn-primary");
            $("#new_msg_tab").removeClass("btn-primary").addClass("btn-secondary");
        });


        $("#edit_support_email").on("click", function () {
            $("#form_send_email").hide();
            $("#form_support_email").show();
            $("#edit_support_email").removeClass("btn-secondary").addClass("btn-primary");
            $("#edit_send_email").removeClass("btn-primary").addClass("btn-secondary");
        });

        $("#edit_send_email").on("click", function () {
            $("#form_support_email").hide();
            $("#form_send_email").show();
            $("#edit_send_email").removeClass("btn-secondary").addClass("btn-primary");
            $("#edit_support_email").removeClass("btn-primary").addClass("btn-secondary");
        });


        CKEDITOR.replace('edit_email_text', {
            allowedContent: true
        });
        CKEDITOR.replace('new_email_text', {
            allowedContent: true
        });
        $("#div_new_email_text").hide();
    });
</script>
</body>
</html>
