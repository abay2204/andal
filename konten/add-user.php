<?php
	$password=password(7);
	$pass=md5($password);
	if(isset($_POST['admin_add'])){
	$nama=substr($_POST['admin_name'], 0, 2);
	$monthid=date('dm');
	$dates=mysql_query("select * from admin where join_date='$date'");
	$idnow=mysql_num_rows($dates);
	$usernow=mysql_num_rows(mysql_query("select * from user where join_date='$date'"));
	$countid=$idnow+$usernow+1;
	$userid="$nama$monthid$countid"; 
	$admin_name=mysql_escape_string($_POST['admin_name']);
	$company_name=mysql_escape_string($_POST['company_name']);
	$admin_email=mysql_escape_string($_POST['admin_email']);
	$akses=mysql_fetch_array(mysql_query("select hak_akses from default_perm where level='0'"));
	$kueri=mysql_query("insert into admin (nama,userid,password,level,akses,email,join_date) values ('$admin_name','$userid','$pass','0','$akses[hak_akses]','$admin_email','$date')");
 	if($kueri){
		$_SESSION['sukses']="success add user";
  $to=$admin_email;
  $subject = "Detail Account CRM Nusanet";
  $message = "This your detail Account in CRM Nusanet<br/>Username : $admin_email <br/>Password : $password<br/><br/><br/>--Regards";
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "From: <no-reply@jkt.nusa.net.id>" . "\r\n";
  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	@mail("$to","$subject","$message","$headers");
	}
	else{
		$_SESSION['error']="Email already exist";
	}
 }
if(isset($_POST['sm_add'])){
	$nama=substr($_POST['sm_name'], 0, 2);
	$monthid=date('dm');
	$idnow=mysql_num_rows(mysql_query("select * from admin where join_date='$date'"));
	$usernow=mysql_num_rows(mysql_query("select * from user where join_date='$date'"));
	$countid=$idnow+$usernow+1;
	$userid="$nama$monthid$countid";
	$admin_name=mysql_escape_string($_POST['sm_name']);
	$admin_email=mysql_escape_string($_POST['sm_email']);
	$akses=mysql_fetch_array(mysql_query("select hak_akses from default_perm where level='1'"));
	$kueri=mysql_query("insert into admin (nama,userid,password,level,akses,email,join_date) values ('$admin_name','$userid','$pass','1','$akses[hak_akses]','$admin_email','$date')");
	if($kueri){
		$_SESSION['sukses']="success add user";
	$to=$admin_email;
  $subject = "Detail Account CRM Nusanet";
  $message = "This your detail Account in CRM Nusanet<br/>Username : $admin_email <br/>Password : $password<br/><br/><br/>--Regards";
  $headers = "From: <no-reply@jkt.nusa.net.id>" . "\r\n";
  $headers .= "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	@mail("$to","$subject","$message","$headers");
	}
	else{
		$_SESSION['error']="Email already exist";
	}
 }
if(isset($_POST['sales_add'])){
	$nama=substr($_POST['sales_name'], 0, 2);
	$monthid=date('dm');
	$idnow=mysql_num_rows(mysql_query("select * from admin where join_date='$date'"));
	$usernow=mysql_num_rows(mysql_query("select * from user where join_date='$date'"));
	$countid=$idnow+$usernow+1;
	$userid="$nama$monthid$countid";
	$admin_name=mysql_escape_string($_POST['sales_name']);
	$admin_email=mysql_escape_string($_POST['sales_email']);
	$akses=mysql_fetch_array(mysql_query("select hak_akses from default_perm where level='2'"));
	$kueri=mysql_query("insert into user (nama,password,akses,sm,email,userid,join_date) values ('$admin_name','$pass','$akses[hak_akses]','$_SESSION[userid]','$admin_email','$userid','$date')");
	if($kueri){
		$_SESSION['sukses']="success add user";
	$to=$admin_email;
  $subject = "Detail Account CRM Nusanet";
  $message = "This your detail Account in CRM Nusanet<br/>Username : $admin_email <br/>Password : $password<br/><br/><br/>--Regards";
  $headers = "From: <no-reply@jkt.nusa.net.id>" . "\r\n";
  $headers .= "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	@mail("$to","$subject","$message","$headers");
	}
	else{
		$_SESSION['error']="Email already exist";
	}
 }?>
<?php if(isset($_GET['hal'])){?>
<section role="main" class="content-body">
          <header class="page-header">
          <?php $keyakses="Add User";?>
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
<div class="row">
				<div class="col-md-2"></div>
					<div class="col-md-7">
						<section class="panel panel-primary">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
									<a href="#" class="fa fa-times"></a>
								</div>
<?php if ($_SESSION['level']=="1337"){
echo'
								<h2 class="panel-title">Add New Admin</h2>
								<p class="panel-subtitle">Add Admin or Owner</p>
							</header>
							<div class="panel-body">
								<form method="post" class="form-horizontal form-bordered form-bordered">
									<div class="form-group">
										<label class="col-sm-3 control-label">Admin Name</label>
										<div class="col-sm-8">
											<input type="text" name="admin_name" placeholder="Admin Name" class="form-control" required>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Company Name</label>
										<div class="col-sm-8">
											<input type="text" name="company_name" placeholder="Company Name" class="form-control" required>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Email</label>
										<div class="col-sm-8">
											<input type="email" name="admin_email" placeholder="Email" class="form-control" required>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-11">
											<button type="submit" name="admin_add" class="btn btn-primary pull-right">Add Admin</button>
										</div>
									</div>
								</form>
							</div>
					';}
					?>
<?php if ($_SESSION['level']=="0"){
					echo'
								<h2 class="panel-title">Add New Supervisor</h2>
								<p class="panel-subtitle">Add Sales Manager or Management</p>
							</header>
							<div class="panel-body">
								<form method="post" class="form-horizontal form-bordered form-bordered">
									<div class="form-group">
										<label class="col-sm-3 control-label">User Name</label>
										<div class="col-sm-8">
											<input type="text" name="sm_name" placeholder="User Name" class="form-control" required>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Email</label>
										<div class="col-sm-8">
											<input type="email" name="sm_email" placeholder="Email" class="form-control" required>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-11">
											<button name="sm_add" type="submit" class="btn btn-primary pull-right">Add Supervisor</button>
										</div>
									</div>
								</form>
							</div>
						';}?>
<?php if($_SESSION['level']=="1"){

								echo'<h2 class="panel-title">Add New Sales</h2>
								<p class="panel-subtitle">Add Sales or user</p>
							</header>
							<div class="panel-body">
								<form method="post" class="form-horizontal form-bordered form-bordered">
									<div class="form-group">
										<label class="col-sm-3 control-label">User Name</label>
										<div class="col-sm-8">
											<input type="text" name="sales_name" placeholder="User Name" class="form-control" required>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Email</label>
										<div class="col-sm-8">
											<input type="email" name="sales_email" placeholder="Email" class="form-control" required>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-11">
											<button name="sales_add" type="submit" class="btn btn-primary pull-right">Add sales</button>
										</div>
									</div>
								</form>
							</div>
						';}?>
							</section>
					</div>
					<?php }?>