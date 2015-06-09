<?php
ob_start();
	session_start();
	if(!isset($_SESSION['nama'])) {
		header("location: login.php");
		exit("Redirecting to <a href='login.php'>login.php</a>.");
	}
	if(isset($_GET['log'])){
		if ($_GET['log']=="out"){
  			unset($_SESSION['nama']);
  			$_SESSION['pesan']="You have been Logout";
  			header('location:login.php');
			}
		else{
		header('location:index.php');
		}
	}
?> 
<!doctype html>
<?php 
if(isset($_SESSION['collapse'])){
	if($_SESSION['collapse']=="in"){
		echo '<html class="fixed sidebar-left-collapsed">';
	}
	else{
		echo'<html class="fixed">';
	}
}
else{
	echo'<html class="fixed">';
}
?>
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
		<link rel="stylesheet" href="assets/vendor/jquery.datetimepicker.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />


		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="assets/vendor/morris/morris.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>

		<!-- Morris JS -->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
  		<script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>

  		<!-- guide -->
  		<link rel="stylesheet" type="text/css" href="assets/vendor/intro/intro.css" />
		<script type="text/javascript" src="assets/vendor/intro/intro.js"></script>

	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="/crm" class="logo">
						<img src="assets/images/logo.png" height="35" alt="NusaNet CRM" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
				
				<!--
					<ul class="notifications">
						<li>
							<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
								<i class="fa fa-bell"></i>
								<span class="badge">3</span>
							</a>
			
							<div class="dropdown-menu notification-menu">
								<div class="notification-title">
									<span class="pull-right label label-default">3</span>
									Alerts
								</div>
			
								<div class="content">
									<ul>
										<li>
										<a href="#" class="clearfix">
										<div class="image">
										<i class="fa fa-thumbs-down bg-danger"></i>
										</div>
										<span class="title">Server is Down!</span>
										<span class="message">Just now</span>
										</a>
										</li>
										<li>
										<a href="#" class="clearfix">
										<div class="image">
										<i class="fa fa-lock bg-warning"></i>
										</div>
										<span class="title">User Locked</span>
										<span class="message">15 minutes ago</span>
										</a>
										</li>
										<li>
										<a href="#" class="clearfix">
										<div class="image">
										<i class="fa fa-signal bg-success"></i>
										</div>
										<span class="title">Connection Restaured</span>
										<span class="message">10/10/2014</span>
										</a>
										</li>
									</ul>
	
									<hr />
			
									<div class="text-right">
										<a href="#" class="view-more">View All</a>
									</div>
								</div>
							</div>
						</li>
					</ul>
					-->

					<span style="visibility: hidden;" class="separator"></span>

			
					<div data-step="1" data-intro="Jika Anda membutuhkan bantuan klik disini lalu pilih menu HELP" data-position="bottom" id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
							<?php
			if($_SESSION['level']=="1337" or $_SESSION['level']=="0" or $_SESSION['level']=="1"){
							$pp=mysql_fetch_array(mysql_query("select * from admin where userid='$_SESSION[userid]'"));
						}
						else{
							$pp=mysql_fetch_array(mysql_query("select * from user where userid='$_SESSION[userid]'"));
 						}?>
								<img src="<?php if($pp['img_pp']!=""){echo"$pp[img_pp]";}else{echo"assets/images/!logged-user.jpg";}?>" class="img-circle" data-lock-picture="<?php if($pp['img_pp']!=""){echo"$pp[img_pp]";}else{echo"assets/images/!logged-user.jpg";}?>" />
							</figure>
							<div class="profile-info">
								<span class="name"><?php echo"$_SESSION[nama]";?></span>
								<?php $level="";
								if($_SESSION['level']=="1337"){
									$level="Super Admin";
								}
								elseif($_SESSION['level']=="0"){
									$level="Admin";
								}
								elseif($_SESSION['level']=="1"){
									$level="Sales Manager";
								}
								elseif($_SESSION['level']=="2"){
									$level="Sales";
								}?>
								<span class="role"><?php echo $level?></span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul id="step1" class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="?hal=profile"><i class="fa fa-user"></i> My Profile</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="?hal=report"><i class="fa fa-bug"></i> Report Bug</a>
								</li>
								<li>
									<a data-step="2" data-intro="click here" role="menuitem" tabindex="-1" href="help/"><i class="fa fa-question"></i> Help</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="?hal=change-log"><i class="fa fa-rss"></i> Change Log</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="?log=out"><i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!--<script type="text/javascript">
			    $(window).load(function(){
			        $('#modalBootstrap').modal('show');
			    });
			</script>
				<div class="modal fade" id="modalBootstrap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="panel-info">
								<header class="panel-heading">
								<h2 class="panel-title">Pemberitahuan</h2>
								</header>
								<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-icon">
												<i class="fa fa-warning"></i>
											</div>
											<div class="modal-text">
												<h4>Good news!!!</h4>
												<p>Kami memiliki fitur baru pada Andal crm. Untuk lebih jelasnya silahkan kunjungi <a href="http://goo.gl/JxzBRs">halaman ini.</a></p>
											</div>
										</div>
									</div>
							</div>
							<div class="modal-footer">
								<div class="pull-left"><input class="pull-left" type="checkbox" name="pemberitahuan" value="1"> Ok, saya mengerti</div>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			<!-- end: header -->
