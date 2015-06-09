<section role="main" class="content-body">
          <header class="page-header">
          <?php $keyakses="Report Bug";?>
            <h2><?php echo"$keyakses";?></h2>
            <title><?php echo"$keyakses | CRM Nusanet";?></title>
            <div class="right-wrapper pull-right">
              <ol class="breadcrumbs">
                <li>
                  <a href="index.php">
                    <i class="fa fa-home"></i>
                  </a>
                </li>
                <li><span><?php echo"$keyakses";?></span></li>
              </ol>
          
              <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
            </div>
          </header>
<div class="row">
  <div class="col-md-12">
    <div class="alert alert-info fade in nomargin">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
      <h4>Announcement!</h4>
      <p>If something's not working on CRM Nusanet, please follow the instructions below to let us know more. </p>
    </div>
    <section class="panel form-wizard" id="w1">
          <header class="panel-heading">
            <div class="panel-actions">
            </div>
    
            <h2 class="panel-title">Report Problem</h2>
          </header>
          <div class="panel-body panel-body-nopadding">
            <div class="wizard-tabs">
              <ul class="wizard-steps">
                <li class="active">
                  <a href="#w1-account" data-toggle="tab" class="text-center">
                    <span class="badge hidden-xs">1</span>
                    Something Isn't Working
                  </a>
                </li>
                <li>
                  <a href="#w1-profile" data-toggle="tab" class="text-center">
                    <span class="badge hidden-xs">2</span>
                    General Feedback
                  </a>
                </li>
                <li>
                  <a href="#w1-confirm" data-toggle="tab" class="text-center">
                    <span class="badge hidden-xs">3</span>
                    Let us know 
                  </a>
                </li>
              </ul>
            </div>
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal" novalidate="novalidate">
              <div class="tab-content">
                <div id="w1-account" class="tab-pane active">
                 <p>Let us know about a broken feature, briefly explain what happens and we will fix it as soon as possible.</p>
                </div>
                <div id="w1-profile" class="tab-pane">
                 <p>You can also tell us about your experience using CRM Nusatet.</p>
                </div>
                <div id="w1-confirm" class="tab-pane">
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Your Name</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control input-sm" name="nama" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-8">
                      <input type="email" class="form-control input-sm" name="email" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Massage</label>
                    <div class="col-sm-8">
                      <textarea type="text" class="form-control" name="pesan" required>
                      </textarea>
                    </div>
                  </div>
                  <div class="form-group">
                  <div class="col-sm-4"></div>
                    <button class="btn btn-primary col-sm-2 pull-right" type="submit" name="submit_pesan">Submit Message</button>
                  </div>
                </div>
              </div>
            </form>

  </div>
</div>
<?php
if (isset($_POST['submit_pesan']))
{
  $nama=$_POST["nama"];
  $email=$_POST["email"];
  $pesan=$_POST["pesan"];

  $to="anc@jkt.nusa.net.id";
  $subject = "Feedback from CRM Nusanet";
  $message = "Dear all, \n\nBerikut feedback yang diberikan oleh $nama ($email) :\n $pesan \n\n--\nRegards";
  $header = "From: <no-reply@jkt.nusa.net.id>";

  $kirim=mail("$to","$subject","$message","$header");
  if ($kirim==true) {
    echo "<strong>Thank you, your feedback has been sent.</strong> Enjoy your day :)";
  }
  else {
    echo "Sorry something worng, try again later";
  }
}

?>