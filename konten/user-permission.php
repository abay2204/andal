<?php
if(isset($_POST['simpan_perm'])){
	session_start();
	include('../sistem/konfigs.php');
if(isset($_POST['modul_admin'])){
    $cekeksis=mysql_num_rows(mysql_query("select * from default_perm where level='0'"));
    $hak_akses="";
	foreach ($_POST['modul_admin'] as $key => $value) {
	$hak_akses.="$value,";
    } 
    if($cekeksis == "0"){
		$sukses=mysql_query("INSERT INTO default_perm VALUES ('0', '$hak_akses')");
		if($sukses){
			$_SESSION['sukses']="sukses";
		}
		else{
			$_SESSION['error']="cannot update data";
		}
	}
	else{
		$sukses=mysql_query("update default_perm set hak_akses='$hak_akses' where level='0'");
		if($sukses){
			mysql_query("update admin set akses='$hak_akses' where level='0'");
			$_SESSION['sukses']="sukses";
		}
		else{
			$_SESSION['error']="cannot update data";
		}
	}
header('location:../?hal=user-permission');		
}
if(isset($_POST['modul_spv'])){
    $cekspv=mysql_num_rows(mysql_query("select * from default_perm where level='1'"));
    $hak_akses_spv="";
	foreach ($_POST['modul_spv'] as $keys => $spv) {
	$hak_akses_spv.="$spv,";
    } 
    if($cekspv == "0"){
		$sukses=mysql_query("insert into default_perm (level,hak_akses) VALUES ('1', '$hak_akses_spv')");
		if($sukses){
			$_SESSION['sukses']="sukses";
		}
		else{
			$_SESSION['error']="cannot update data";
		}
	}
	else{
		$sukses=mysql_query("update default_perm set hak_akses='$hak_akses_spv' where level='1'");
		if($sukses){
			mysql_query("update admin set akses='$hak_akses_spv' where level='1'");
			$_SESSION['sukses']="sukses";
		}
		else{
			$_SESSION['error']="cannot update data";
		}
	}
header('location:../?hal=user-permission');		
}
if(isset($_POST['modul_sales'])){
    $cekeksis=mysql_num_rows(mysql_query("select * from default_perm where level='2'"));
    $hak_akses="";
	foreach ($_POST['modul_sales'] as $key => $value) {
	$hak_akses.="$value,";
    } 
    if($cekeksis == "0"){
		$sukses=mysql_query("INSERT INTO default_perm VALUES ('2', '$hak_akses')");
		if($sukses){
			$_SESSION['sukses']="sukses";
		}
		else{
			$_SESSION['error']="cannot update data";
		}
	}
	else{
		$sukses=mysql_query("update default_perm set hak_akses='$hak_akses' where level='2'");
		if($sukses){
			mysql_query("update user set akses='$hak_akses'");
			$_SESSION['sukses']="sukses";
		}
		else{
			$_SESSION['error']="cannot update data";
		}
	}
		
}
header('location:../?hal=user-permission');
}
?>
<?php
if($_SESSION['level']=="1337"){
if(isset($_GET['hal'])){?><section role="main" class="content-body">
          <header class="page-header">
          <?php $keyakses="User Permission";?>
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
<?php if(isset($_POST['ganti_perm'])){
	$perm_baru="";
	foreach ($_POST['perm'] as $key => $value) {
	$perm_baru.="$value,";
}
if($_SESSION['email_akses']=="user"){
mysql_query("update user set akses='$perm_baru' where email='$_POST[email]'");
unset($_SESSION['email_akses']);
}
elseif($_SESSION['email_akses']=="admin"){
mysql_query("update admin set akses='$perm_baru' where email='$_POST[email]'");
unset($_SESSION['email_akses']);
}
}?>
					<div class="col-md-7">
						<section class="panel panel-primary">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
									<a href="#" class="fa fa-times"></a>
								</div>

								<h2 class="panel-title">User Permission</h2>
								<p class="panel-subtitle">Change user permission</p>
							</header>
							<div class="panel-body">
								<form action="?hal=user-permission" method="post" class="form-horizontal form-bordered form-bordered">
 							<?php if(isset($_POST['change_perm'])){
 									$email=mysql_escape_string($_POST['email']);
 									$cekemail=mysql_num_rows(mysql_query("select * from user where email='$email'"));
 									if($cekemail > "0"){
 										$akses="true";
 										$_SESSION['email_akses']="user";
 									}
 									else{
 										$cekemail=mysql_num_rows(mysql_query("select * from admin where email='$email'"));
 										if($cekemail > "0"){
 											$akses="true";
 											$_SESSION['email_akses']="admin";
 										}
 										else{
 											$akses="false";
 										}
 									}
 							if($akses=="true"){
 							echo'<div class="form-group">
										<div class="col-sm-8">
 										<b class="control-label">'.$email.'</b>
 										<input name="email" type="hidden" value="'.$email.'">
										</div>
									</div>
								<div class="form-group">
											<label class="col-sm-3 control-label">permission<span class="required">*</span></label>
											<div class="col-sm-9">';
									$changeperm=mysql_query("select * from modul");
									 while($pecahperm=mysql_fetch_array($changeperm)){
 										$filter=mysql_query("select * from user where email='$email'");
 										$cekfilter=mysql_num_rows($filter);
 										if($cekfilter == "0"){
 											$filter=mysql_query("select * from admin where email='$email'");
 										}
										$pecahfilter=mysql_fetch_array($filter);
 										$cobacek=$pecahfilter['akses'];
						if (preg_match("/\b$pecahperm[nama]\b/", $cobacek, $match)){
								echo'<div class="checkbox-custom chekbox-primary"><input id="'.$pecahperm['nama'].'" value="'.$pecahperm['nama'].'" type="checkbox" name="perm[]" checked />
								<label for="'.$pecahperm['nama'].'">'.$pecahperm['nama'].'</label></div>';
							}
							else{


												echo'<div class="checkbox-custom chekbox-primary"><input id="'.$pecahperm['nama'].'" value="'.$pecahperm['nama'].'" type="checkbox" name="perm[]" />
													<label for="'.$pecahperm['nama'].'">'.$pecahperm['nama'].'</label></div>';
													}
											}
												echo'
											</div>
										</div><div class="form-group">
										<div class="col-sm-11">
											<button name="ganti_perm" type="submit" class="btn btn-primary pull-right">Save</button>
										</div>
									</div>
								</form>';
								}
								elseif($akses=="false"){
									echo "Email not found";
								}
								}
								else{ 
									echo'<div class="form-group">
										<label class="col-sm-3 control-label">Email</label>
										<div class="col-sm-8">
											<input type="email" name="email" placeholder="Email User" class="form-control" required>
										</div>
									</div><div class="form-group">
										<div class="col-sm-11">
											<button name="change_perm" type="submit" class="btn btn-primary pull-right">Save</button>
										</div>
									</div>
								</form>';}?>
									
							</div>
						</section>
					</div>
					<div class="col-md-5">
						<section class="panel panel-featured panel-featured-primary">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
									<a href="#" class="fa fa-times"></a>
								</div>

								<h2 class="panel-title">Set Default Perm</h2>
							</header>
							<div class="panel-body">
							<form action="konten/user-permission.php" method="post" >
								<div class="form-group">
								<label class="control-label col-sm-3">Admin</label>
									<div class="col-sm-8">
										<select name="modul_admin[]" class="form-control" multiple="multiple" data-plugin-multiselect id="perm_admin">

											<?php $moduladmin=mysql_query("select * from modul");
											while($pecahmodul=mysql_fetch_array($moduladmin)){
 										$filter=mysql_query("select * from default_perm where level='0'");
										$pecahfilter=mysql_fetch_array($filter);
 										$cobacek=$pecahfilter['hak_akses'];
						if (preg_match("/\b$pecahmodul[nama]\b/", $cobacek, $match)){
								echo"<option value='$pecahmodul[nama] checked'>$pecahmodul[nama]</option>";
							}
							else{


												echo"<option value='$pecahmodul[nama]'>$pecahmodul[nama]</option>";
											}
										}
													
													}?>
										</select>
									</div>
								<label class="control-label col-sm-3">Supervisor</label>
									<div class="col-sm-8">
										<select name="modul_spv[]" class="form-control" multiple="multiple" data-plugin-multiselect id="perm_supervisor">
									<?php $modulsuper=mysql_query("select * from modul");
									 while($pecahmodul=mysql_fetch_array($modulsuper)){
													echo"<option value='$pecahmodul[nama]'>$pecahmodul[nama]</option>";
													}?>
										</select>
									</div>
								<label class="control-label col-sm-3">Sales</label>
									<div class="col-sm-8">
										<select name="modul_sales[]" class="form-control" multiple="multiple" data-plugin-multiselect id="perm_sales">
											<?php $modulsales=mysql_query("select * from modul");
											while($pecahmodul=mysql_fetch_array($modulsales)){
													echo"<option value='$pecahmodul[nama]'>$pecahmodul[nama]</option>";
													}?>
										</select>
									</div>					
								</div>
								<div class="form-group">
									<div class="col-sm-11">
										<button name="simpan_perm" type="submit" class="btn btn-primary pull-right">Save</button>
									</div>
								</div>
							</form>	
							</div>
						</section>
					</div>
				</div>
				<?php }
				else{
					$_SESSION['error']="forbidden";
					header('location:index.php');}?>