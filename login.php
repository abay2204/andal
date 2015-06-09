<?php
session_start();
if(isset($_SESSION['nama'])){
  header('location:index.php');
}
?>
<!doctype html>
<html class="fixed">
  <head>
<title>Login CRM</title>
    <!-- Basic -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

    <!-- Head Libs -->
    <script src="assets/vendor/modernizr/modernizr.js"></script>

  </head>
  <body>
    <!-- start: page -->
    <div class="fullscreen background" style="background-image:url('assets/images/background.jpg');" data-img-width="1600" data-img-height="1064">
    <div class="content-a">
        <div class="content-b">
    <section class="body-sign">
      <div class="center-sign">
        <a href="/crm" class="logo pull-left">
          <img src="assets/images/logo.png" height="54" alt="Porto Admin" />
        </a>

        <div class="panel panel-sign">
          <div class="panel-title-sign mt-xl text-right">
            <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In</h2>
          </div>
          <div class="panel-body">
          <?php if(isset($_SESSION['pesan'])) { 
                          echo '<div id="error" class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>'.$_SESSION['pesan'].'</strong>
                  </div>';
                          unset($_SESSION['pesan']);
                          } ?>
             <form class="form-signin" action="proses.php" method="post" role="form">
              <div class="form-group mb-lg">
              <div class="clearfix">
                <label class="pull-left">Username</label>
              </div>
                <div class="input-group input-group-icon">
                  <input name="email" type="text" class="form-control input-lg" autofocus required/>
                  <span class="input-group-addon">
                    <span class="icon icon-lg">
                      <i class="fa fa-user"></i>
                    </span>
                  </span>
                </div>
              </div>

              <div class="form-group mb-lg">
                <div class="clearfix">
                  <label class="pull-left">Password</label>
                </div>
                <div class="input-group input-group-icon">
                  <input name="password" type="password" class="form-control input-lg" required />
                  <div id="lokasi"></div>
                  <a href="forgot.php" class="pull-right">Lost Password?</a>
                  <span class="input-group-addon">
                    <span class="icon icon-lg">
                      <i class="fa fa-lock"></i>
                    </span>
                  </span>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-8">
                </div>
                <div class="col-sm-4 text-right">
                  <button type="submit" class="btn btn-primary hidden-xs" name="login">Sign In</button>
                  <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg" name="login">Sign In</button>
                </div>
              </div>
              <p></p>
            </form>
          </div>
        </div>

        <p class="text-center text-muted mt-md mb-md">&copy; Copyright <?php echo date('Y');?>. All Rights Reserved.</p>
      </div>
    </section>
    </div>
  </div>
</div>    
    <!-- end: page -->

    <!-- Vendor -->
    <script src="assets/vendor/jquery/jquery.js"></script>
    <script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
    
    <!-- Theme Base, Components and Settings -->
    <script src="assets/javascripts/theme.js"></script>
    
    <!-- Theme Custom -->
    <script src="assets/javascripts/theme.custom.js"></script>
    
    <!-- Theme Initialization Files -->
    <script src="assets/javascripts/theme.init.js"></script>
    <script src="js/anc.js"></script>


  <script type="text/javascript">
$(document).ready(function() {
   getLocation();
            });
 function showLocation(position) {
  var latitude = position.coords.latitude;
  var longitude = position.coords.longitude;
  document.getElementById("lokasi").innerHTML = "<input name=lat value="+ latitude +" type=hidden><input name=lng value="+ longitude +" type=hidden>";
}

function errorHandler(err) {
  if(err.code == 1) {
    alert("Error: You must allow geolocation or you cannot login this website");
  }else if( err.code == 2) {
    alert("Error: Position is unavailable!");
  }
}
function getLocation(){

   if(navigator.geolocation){
      // timeout at 60000 milliseconds (60 seconds)
      var options = {timeout:60000};
      navigator.geolocation.getCurrentPosition(showLocation, 
                                               errorHandler,
                                               options);
   }else{      alert("Sorry, browser does not support geolocation!");
   }
}

</script>
<script>
/* fix vertical when not overflow
call fullscreenFix() if .fullscreen content changes */
function fullscreenFix(){
    var h = $('body').height();
    // set .fullscreen height
    $(".content-b").each(function(i){
        if($(this).innerHeight() <= h){
            $(this).closest(".fullscreen").addClass("not-overflow");
        }
    });
}
$(window).resize(fullscreenFix);
fullscreenFix();

/* resize background images */
function backgroundResize(){
    var windowH = $(window).height();
    $(".background").each(function(i){
        var path = $(this);
        // variables
        var contW = path.width();
        var contH = path.height();
        var imgW = path.attr("data-img-width");
        var imgH = path.attr("data-img-height");
        var ratio = imgW / imgH;
        // overflowing difference
        var diff = parseFloat(path.attr("data-diff"));
        diff = diff ? diff : 0;
        // remaining height to have fullscreen image only on parallax
        var remainingH = 0;
        if(path.hasClass("parallax")){
            var maxH = contH > windowH ? contH : windowH;
            remainingH = windowH - contH;
        }
        // set img values depending on cont
        imgH = contH + remainingH + diff;
        imgW = imgH * ratio;
        // fix when too large
        if(contW > imgW){
            imgW = contW;
            imgH = imgW / ratio;
        }
        //
        path.data("resized-imgW", imgW);
        path.data("resized-imgH", imgH);
        path.css("background-size", imgW + "px " + imgH + "px");
    });
}
$(window).resize(backgroundResize);
$(window).focus(backgroundResize);
backgroundResize();
</script>
<style type="text/css">
  /* background setup */
.background {
    background-repeat:no-repeat;
    /* custom background-position */
    background-position:50% 50%;
    /* ie8- graceful degradation */
    background-position:50% 50%\9 !important;
}

/* fullscreen setup */
html, body {
    /* give this to all tags from html to .fullscreen */
    height:100%;
}
.fullscreen,
.content-a {
    width:100%;
    min-height:100%;
}
.not-fullscreen,
.not-fullscreen .content-a,
.fullscreen.not-overflow,
.fullscreen.not-overflow .content-a {
    height:100%;
    overflow:hidden;
}

/* content centering styles */
.content-a {
  display:table;
}
.content-b {
  display:table-cell;
    position:relative;
  vertical-align:middle;
  text-align:center;
}

</style>
  </body>
</html>