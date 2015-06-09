<?php
if(isset($_POST['change_profile'])){
	$dir = "assets/images/user/";
	$upload="1";
	$cover="cover".uniqid();
	$pp="pp".uniqid();
	$covers=$dir.$cover.".jpeg";
	$pps=$dir.$pp.".jpeg";
	$status = mysql_escape_string($_POST['status']);
	$status = htmlspecialchars($status);
	if (isset( $_FILES["img_pp"] ) && isset( $_FILES["img_cp"]) && !empty( $_FILES["img_pp"]["name"] ) && !empty( $_FILES["img_cp"]["name"] )) {
 		$kueri=move_uploaded_file($_FILES['img_cp']['tmp_name'], $covers);
    	if($kueri){
    		move_uploaded_file($_FILES['img_pp']['tmp_name'], $pps);
    		if($_SESSION['level']=="1337" or $_SESSION['level']=="0" or $_SESSION['level']=="1"){
    			$hapus=mysql_fetch_array(mysql_query("select * from admin where userid='$_SESSION[userid]'"));
    			unlink($hapus['img_pp']);
    			unlink($hapus['img_cover']);
    			mysql_query("update admin set img_cover='$covers',quote='$status',img_pp='$pps' where userid='$_SESSION[userid]'");
    		}
    		else{
    			$hapus=mysql_fetch_array(mysql_query("select * from user where userid='$_SESSION[userid]'"));
    			unlink($hapus['img_pp']);
    			unlink($hapus['img_cover']);
    			mysql_query("update user set img_cover='$covers',quote='$status',img_pp='$pps' where userid='$_SESSION[userid]'");
    		}
    		$_SESSION['sukses']="sukses"; 
    	}
    	else{
    		$_SESSION['error']="error";
    	}
	}
	elseif (isset( $_FILES["img_cp"] ) && !empty( $_FILES["img_cp"]["name"] )) {
    	$kueri=move_uploaded_file($_FILES['img_cp']['tmp_name'], $covers);
    	if($kueri){
    		if($_SESSION['level']=="1337" or $_SESSION['level']=="0" or $_SESSION['level']=="1"){
    			$hapus=mysql_fetch_array(mysql_query("select * from admin where userid='$_SESSION[userid]'"));
    			unlink($hapus['img_cover']);
    			mysql_query("update admin set img_cover='$covers',quote='$status' where userid='$_SESSION[userid]'");
    		}
    		else{
    			$hapus=mysql_fetch_array(mysql_query("select * from user where userid='$_SESSION[userid]'"));
    			unlink($hapus['img_cover']);
    			mysql_query("update user set img_cover='$covers',quote='$status' where userid='$_SESSION[userid]'");
    		}
    		$_SESSION['sukses']="sukses";
    	}
    	else{
    		$_SESSION['error']="error";
    	}
	}
	elseif (isset( $_FILES["img_pp"] ) && !empty( $_FILES["img_pp"]["name"] )) {
    	$kueri=move_uploaded_file ($_FILES['img_pp']['tmp_name'], $pps);
    	if($kueri){
    		if($_SESSION['level']=="1337" or $_SESSION['level']=="0" or $_SESSION['level']=="1"){
    			$hapus=mysql_fetch_array(mysql_query("select * from admin where userid='$_SESSION[userid]'"));
    			unlink($hapus['img_pp']);
    			mysql_query("update admin set img_pp='$pps',quote='$status' where userid='$_SESSION[userid]'");
    		}
    		else{
    			$hapus=mysql_fetch_array(mysql_query("select * from user where userid='$_SESSION[userid]'"));
    			unlink($hapus['img_pp']);
    			mysql_query("update user set img_pp='$pps',quote='$status' where userid='$_SESSION[userid]'");
    		}
    		$_SESSION['sukses']="sukses";
    	}
    	else{
    		$_SESSION['error']="error";
    	}
	}
	else{
		if($_SESSION['level']=="1337" or $_SESSION['level']=="0" or $_SESSION['level']=="1"){
			$kueri=mysql_query("update admin set quote='$status' where userid='$_SESSION[userid]'");
		}
		else{
			$kueri=mysql_query("update user set quote='$status' where userid='$_SESSION[userid]'");
		}
	if($kueri){
    	$_SESSION['sukses']="sukses";
    }
    else{
    	$_SESSION['error']="error";
	}
}
print_r($_FILES['img_pp']['name']);
}
if(isset($_POST['change_password'])){
	if($_SESSION['level']=="2"){
		$cekpasslama=mysql_fetch_array(mysql_query("Select * from user where email='$_SESSION[email]'"));
	}
	elseif($_SESSION['level']=="1" or $_SESSION['level']=="0"){
		$cekpasslama=mysql_fetch_array(mysql_query("Select * from admin where email='$_SESSION[email]'"));
	}
	$passlama=md5($_POST['old_pass']);
	if($cekpasslama['password']=="$passlama"){
		if($_POST['new_pass_1']=="$_POST[new_pass_2]"){
			$passbaru=md5($_POST['new_pass_1']);
			if($_SESSION['level']=="2"){
				mysql_query("update user set password='$passbaru' where email='$_SESSION[email]'");
			}
			elseif($_SESSION['level']=="1" or $_SESSION['level']=="0"){
				mysql_query("update admin set password='$passbaru' where email='$_SESSION[email]'");
			}
			$_SESSION['sukses']="Success change password";
 		}
		else{
			$_SESSION['error']="Password not same";
		}
	}
	else{
			$_SESSION['error']="recent password invalid";
	}
}
?>
<section role="main" class="content-body">
          <header class="page-header">
          <?php $keyakses="Profile";?>
            <h2><?php echo"$keyakses";?></h2>
          
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
          <?php if(isset($_SESSION['sukses'])){
			echo'<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<strong>Well done!</strong> <br/>';
				if($_SESSION['sukses']=="sukses")
					echo'Saving data success without error';
				else
					echo"$_SESSION[sukses]";
			echo'</div>';
			unset($_SESSION['sukses']);
			}?>
			<?php if(isset($_SESSION['error'])){
			echo'<div class="alert alert-warning">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<strong>Upsss!</strong> Something wrong. <br>';
				if($_SESSION['error']=="error")
					echo'cannot update data';
				else
					echo"$_SESSION[error]";
			echo'</div>';
			unset($_SESSION['error']);
			}?>
<title><?php echo"$keyakses";
if($_SESSION['level']=="1337" or $_SESSION['level']=="0" or $_SESSION['level']=="1"){
$detail=mysql_fetch_array(mysql_query("select * from admin where userid='$_SESSION[userid]'"));
}
else{
	$detail=mysql_fetch_array(mysql_query("select * from user where userid='$_SESSION[userid]'"));
	}?>  | CRM Nusanet</title>
<div class="row">
<div class="col-md-1"></div>
	<div class="col-md-10 col-lg-10">
		<section class="panel-group mb-xlg">
			<div class="widget-twitter-profile">
				<div class="top-image">
					<img height="310px" src='<?php echo"$detail[img_cover]"?>' alt="">
				</div>
				<div class="image-upload profile-info">
					<div class="profile-picture">
						<label for="file-input">
					        <img src='<?php echo"$detail[img_pp]"?>'/>
					    </label>

    					<!--<input style="display: none;" id="file-input" type="file"/>-->
					</div>
					<div class="profile-account">
						<h3 class="name text-semibold"><?php echo"$_SESSION[nama]";?></h3>
						<a href="#" class="account">@<?php echo"$_SESSION[nama]";?></a>
					</div>
					
				</div>
				<div class="profile-quote">
					<blockquote>
						<p>
						<?php echo"$detail[quote]"?>
						</p>
					</blockquote>
					<div class="quote-footer">
						<a class="modal-basic" href="#passwd"><i class="fa fa-cogs"></i> Change Password</a> | 
						<a class="modal-basic" href="#prfl"><i class="fa fa-edit"></i> Edit Info</a>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<!-- modal password -->
<div id="passwd" class="modal-block modal-block-primary mfp-hide">
	<section class="panel panel-primary">
	<form method="post" >
		<header class="panel-heading">
			<h2 class="panel-title">Change Password</h2>
		</header>
		<div class="panel-body">
			<div class="form-group">
				<div class="col-md-4">
					<label class="control-label">Current Password</label>
				</div>
				<div class="col-md-8">
					<input name="old_pass" type="password" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-4">
					<label class="control-label">New Password</label>
				</div>
				<div class="col-md-8">
					<input name="new_pass_1" type="password" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-4">
					<label class="control-label">Retype</label>
				</div>
				<div class="col-md-8">
					<input name="new_pass_2" type="password" class="form-control">
				</div>
				
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button name="change_password" class="btn btn-primary">Confirm</button>
					<button class="btn btn-default modal-dismiss">Cancel</button>
				</div>
			</div>
			</form>
		</footer>
	</section>
</div>

<!-- modal edit profile -->
<div id="prfl" class="modal-block modal-block-primary mfp-hide">
	<section class="panel panel-primary">
	<form method="post" enctype="multipart/form-data">
		<header class="panel-heading">
			<h2 class="panel-title">Edit Profile</h2>
		</header>
		<div class="panel-body">
			<div class="form-group">
				<div class="col-md-4">
					<label class="control-label">Change Profile Picture</label>
				</div>
				<div class="col-md-8">
					<input name="img_pp" type="file">
					<label class="control-label required">*only format .jpeg .jpg .png allowed</label>	
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-4">
					<label class="control-label">Change Cover Picture</label>
				</div>
				<div class="col-md-8">
					<input name="img_cp" type="file">
					<label class="control-label required">*only format .jpeg .jpg .png allowed</label>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-4">
					<label class="control-label">Change Status</label>
				</div>
				<div class="col-md-8">
					<input name="status" type="text" class="form-control" value="<?php echo"$detail[quote]"?>">
				</div>
				
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button name="change_profile" class="btn btn-primary">Confirm</button>
					<button class="btn btn-default modal-dismiss">Cancel</button>
				</div>
			</div>
			</form>
		</footer>
	</section>
</div>
<script type="text/javascript">

    function rollover(my_image)
    {

        my_image.src = 'assets/images/camera-icon.png';

    }

    function mouseaway(my_image)
    {

        my_image.src = <?php echo"$detail[img_pp]"?>;

    }
     $(document).on('change', '.image', function(){
				var dataUrl = canvas.toDataURL();
				$.ajax({
				  type: "POST",
				  url: "camsave.php",
				  data: { 
					 imgBase64: dataUrl
				  }
				}).done(function(msg) {
				  console.log('saved');
				 // Do Any thing you want
				});
			});

</script>
<style type="text/css">
	.image-upload > input
{
    display: none;
}
</style>	