<?php
    require_once "../app/kernel.php";


    $sql = "SELECT * FROM citations LIMIT 3";
    $res = $global['pdo']->prepare($sql);
    $res->execute($params);
    $citations = $res->fetchAll(PDO::FETCH_ASSOC);


    $sql = "SELECT * FROM images WHERE thumbnail = 0";
    $res = $global['pdo']->prepare($sql);
    $res->execute();
    $screenshots = $res->fetchAll(PDO::FETCH_ASSOC);


    $sql = "SELECT * FROM images WHERE thumbnail = 1 LIMIT 4";
    $res = $global['pdo']->prepare($sql);
    $res->execute($params);
    $thumbnails = $res->fetchAll(PDO::FETCH_ASSOC);
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
  <link rel="stylesheet" href="./assets/css/style.css">
  <title>Summer catchers</title>

  <!-- Chrome, Firefox OS and Opera -->
  <meta name="theme-color" content="#5b7dff">
  <!-- Windows Phone -->
  <meta name="msapplication-navbutton-color" content="#5b7dff">
  <!-- iOS Safari -->
  <meta name="apple-mobile-web-app-status-bar-style" content="#5b7dff">
</head>
<body>

  <div class="main-wrapper">
    <header class="header" id="mainHeader">
      <div class="video-wrapper" id="videoWrapper">
        <div class="logo-layout">
          <ul class="award-logo-list">
            <li>
              <img src="./assets/images/awards-logo-1.png" alt="">
            </li>
            <li>
              <img src="./assets/images/awards-logo-2.png" alt="">
            </li>
          </ul>

          <h1 class="main-logo">
            <a href="#">
              <img src="./assets/images/logo-name.png" alt="">
            </a>
          </h1>
        </div>
        <div id="headerVideo">
          <video class="header-video" poster="./assets/images/header-poster.png" autoplay muted="muted" volume="0" preload="auto" loop>
            <source src="./assets/source/SC_header_nologo.mp4" type="video/mp4">
            <source src="./assets/source/SC_header_nologo.webm" type="video/webm">
          </video>
        </div>
        <div class="video-bottom" id="videoBottom">
          <div class="top">
            <div class="row no-gutters justify-content-between align-items-center">
              <div class="col-xl-3 col-lg-3">
                <ul class="logo-list">
                  <li><a href="http://steamcommunity.com/sharedfiles/filedetails/?id=651254178">
                    <img src="./assets/images/store-img-1.png" alt="">
                  </a></li>
                  <li style="display: none"><a href="#">
                    <img src="./assets/images/store-img-2.png" alt="">
                  </a></li>
                  <li style="display: none"><a href="#">
                    <img src="./assets/images/store-img-3.png" alt="">
                  </a></li>
                </ul>
              </div>
              <div class="col-xl-6 col-lg-6">
                <form class="newsletter-form">
                  <div class="d-flex flex-xs-column flex-wrap justify-content-center align-items-center">
                    <div class="f-item">
                      <input type="email" class="form-control" id="newsletter_email" name="email" placeholder="Email Address">
                    </div>
                    <div class="f-item">
                      <button type="button" class="newsletter-btn" id="newsletter-form-btn">
                        <img src="./assets/images/newsletter-btn.png" alt="">
                      </button>
                      <!-- <button type="submit" class="btn btn-dash-pink">NEWSLETTER SIGN UP <br><span>PARTICIPATE IN ALPHA TESTING</span></button> -->
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-xl-3 col-lg-3 logo-list__company">
                <ul class="logo-list justify-content-end">
                  <li><a href="http://faceit-team.com/">
                    <img src="./assets/images/logos-img-1.png" alt="">
                  </a></li>
                  <li><a href="http://www.noodlecake.com/">
                    <img src="./assets/images/logos-img-2.png" alt="">
                  </a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="triangle-down"><div></div></div>
        </div>
      </div>
    </header>
    <section class="video-wrap">
      <div class="video-top-block">
        <div class="row hidden-sm-down">
            <?php foreach ($citations as $citate) {?>
                <div class="col-md-4">
                    <p><?php echo $citate['text']; ?></p>
                </div>
            <?php } ?>
        </div>
        <div class="row hidden-sm-down">
            <?php foreach ($citations as $citate) {?>
                <div class="col-md-4">
                    <p class="sub-text"><?php echo $citate['who']; ?></p>
                </div>
            <?php } ?>
        </div>
        <div class="hidden-sm-up">
            <div id="carouselCitations" class="carousel slide" data-ride="carousel" data-interval="10000">
                <div class="carousel-inner" role="listbox">
                    <?php
                        $first = 1;
                        foreach ($citations as $citate) {
                    ?>
                        <div class="carousel-item <?php echo ($first ? "active" : ""); ?>">
                            <div>
                                <p><?php echo $citate['text']; ?></p>
                                <p class="sub-text"><?php echo $citate['who']; ?></p>
                            </div>
                        </div>
                    <?php
                            $first = 0;
                        }
                    ?>
                </div>
            </div>
        </div>
      </div>
      <div class="video-main-layer">
        <div class="row">
          <div class="col-lg-7">
            <div class="video-block">
              <iframe width="560" height="315" src="https://www.youtube.com/embed/5yZC4RuBX3M" frameborder="0" gesture="media" allowfullscreen></iframe>
            </div>
          </div>
          <div class="col-lg-5 text-center">
            <ul class="img-list">
                <?php foreach ($thumbnails as $thumb) {?>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#modalSlider">
                            <img src="./assets/images/thumbnails/<?php echo $thumb['filename']; ?>" alt="">
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <div class="bottom-text">
              <p>Summer Catchers is an arcade video game with adventure elements about a northern girl and her epic journey to the South an summer warm.</p>
              <div class="line-block"></div>
              <p class="smooth-txt">
                  Created by <a href="http://faceit-team.com/">FaceIT development</a> team
              </p>
              <p class="smooth-txt">
                Published by <a href="http://www.noodlecake.com/">Noodlecake studios</a><br> OST by <a href="http://geekpilot.ru/">Geek Pilot</a>
              </p>
              <a href="./Summer_Catchers_media.zip" class="btn btn-dash-pink">
                <img src="./assets/images/mediazip-btn.png" alt="">
              </a>
              <ul class="social-list">
                <li>
                  <a href="https://twitter.com/SummerCatchers?lang=ru">
                    <i class="fa fa-twitter"></i>
                  </a>
                </li>
                <li>
                  <a href="https://summercatchers.tumblr.com/">
                    <i class="fa fa-tumblr"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="contact-wrap">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10 text-center">
          <h3 class="contact-title">Contact</h3>
          <div class="line-block"></div>
          <form class="contact-form">
            <div class="form-group row">
              <div class="col-md-6">
                <input class="form-control" type="text" name="name" placeholder="Name" id="contact_name">
              </div>
              <div class="col-md-6">
                <input class="form-control" type="email" name="email" placeholder="Email Address" id="contact_email">
              </div>
            </div>
            <div class="form-group">
              <textarea placeholder="Message" class="form-control" name="message" rows="3" id="contact_message"></textarea>
            </div>
            <button type="button" class="btn btn-dash-pink" id="contact-form-btn">
              <img src="./assets/images/send-btn.png" alt="">
            </button>
          </form>
          <div class="line-block"></div>
          <p class="copyright text-center">&copy; Copyright FaceIT, 2009-2017</p>
        </div>
      </div>
    </section>
  </div>

  <!-- Modals -->
  <div class="modal fade" id="modalSlider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <img src="./assets/images/close-icon.png" alt="" class="close-icon">
        </button>
        <div class="modal-body">

          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <?php
                $first = 1;
                foreach ($screenshots as $screen) {
                    ?>
                    <div class="carousel-item <?php echo ($first ? "active" : ""); ?>">
                        <img class="img-fluid" src="./assets/images/screenshots/<?php echo $screen['filename']; ?>" alt="">
                    </div>
                    <?php
                    $first = 0;
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
              <img src="./assets/images/arrow-left.png" alt="">
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
              <img src="./assets/images/arrow-right.png" alt="">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.min.js"></script>
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>-->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jarallax/1.9.0/jarallax-video.min.js"></script> -->
  <script src="./assets/js/script.js"></script>
</body>
</html>
