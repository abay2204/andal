<link rel="stylesheet" href="assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
<?php
if (isset($_POST['fname'])){ //mulai param fname
	include('../sistem/konfigs.php');
	session_start();
	$action=mysql_query("update leads set nama='$_POST[fname]',lname='$_POST[lname]',type='$_POST[tipe]',email='$_POST[email]',phone='$_POST[phone]' where id='$_POST[id]'");
	if ($_POST['tipe']=="corporate"){ //mulai param corporate
	$cek=mysql_num_rows(mysql_query("select * from customer_company where id='$_POST[id]'"));
		if($cek>"0"){ //cek perusahaan sudah ada belum
		mysql_query("update customer_company set company_name='$_POST[company]',industry='$_POST[industry]' where id='$_POST[id]' ");
 		} // end cek
		else{ //pengecualian
		mysql_query("insert into customer_company (id,company_name,industry) values ('$_POST[id]','$_POST[company]','$_POST[industry]')");
		mysql_query("insert into history(id,history_action,keterangan,date,time,lokasi) values ('$_POST[detail]','Update','$_SESSION[name] Changed type leads from personal to corporate','$date','$time','tes'");
		} // end pengecualian
	}//end param corporate
	if(isset($_POST['address1'])){ //start param address
	$cek=mysql_num_rows(mysql_query("select * from customer_address where id='$_POST[id]'"));
		if($cek>"0"){ // start cek
		mysql_query("update customer_address set address1='$_POST[address1]' where id='$_POST[id]'");
		} // end cek
		else{ // start pengecualian
		mysql_query("insert into customer_address (id,address1,address2,city,state,postalcode,country) values ('$_POST[id]','$_POST[address1]','$_POST[address2]','$_POST[city]','$_POST[state]','$_POST[postalcode]','$_POST[country]')");
		} // end pengecualian
	} //end param address
	if($action){ // jika berhasil eksekusi
	$_SESSION['sukses']="sukses";
	}//end berhasil eksekusi
	else{ //jika tidak berhasil
		$_SESSION['error']="cannot update";
	}//end tidak berhasil
	header('location:../index.php?hal=detail-leads&detail='.$_POST['id'].'');
}//end param fname**/
?>

	<?php
	 if(isset($_GET['edit'])){ //start param edit
	 		$id=mysql_escape_string($_GET['edit']);
	if($_SESSION['level']=="2"){ // cek level 2
		$kueri=mysql_query("select * from leads where sales='$_SESSION[userid]' and id='$id'");
	} // end level 2
	if($_SESSION['level']=="1"){ //cek level 1
		$kueri=mysql_query("select * from leads where sm='$_SESSION[userid]' and id='$id'");
	} //end level 1
	if($_SESSION['level']=="0"){ //cek level 0
		$kueri=mysql_query("select * from leads where id='$id'");
	}//end leve0
	$cekueri=mysql_num_rows($kueri);
	if($cekueri=="0"){
		header('location:index.php');
	}
	$pecah=mysql_fetch_array($kueri);
	$pecahaddress=mysql_fetch_array(mysql_query("select * from customer_address where id='$id'"));
	$pecahcompany=mysql_fetch_array(mysql_query("select * from customer_company where id='$id'"));?>
<link rel="stylesheet" href="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
	<script type="text/javascript">
			$(document).ready(function() {

		    $('.corp').hide();

		    $('#select').change(function () {
		        if ($('#select option:selected').text() == "personal"){
		            $('.corp').hide();
		        }
		        else if ($('#select option:selected').text() == "corporate"){
		            $('.corp').show();
		        	}
		    });
		});
		</script>
			
		<section role="main" class="content-body">
			
          <header class="page-header">
          <?php $hal="Edit Leads"?>
            <h2><?php echo"$hal";?></h2>
          <title><?php echo"$hal $pecah[nama]";?></title>
            <div class="right-wrapper pull-right">
              <ol class="breadcrumbs">
                <li>
                  <a href="index.php">
                    <i class="fa fa-home"></i>
                  </a>
                </li>
                <li><span><?php echo"Leads / $hal";?></span></li>
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
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<section class="panel panel-group">
					<header class="panel-heading bg-primary">

						<div class="widget-profile-info">
							<div class="profile-picture">
								<img src="assets/images/!logged-user.jpg">
							</div>
							<div class="profile-info">
								<h4 class="name text-semibold"><a style="color:white" href="?hal=detail-leads&detail=<?php echo"$pecah[id]";?>"><?php echo"$pecah[nama] $pecah[lname]";?></a></h4>
								<?php if(!empty($pecahcompany['company_name'])){echo"<h5 class='roll'>$pecahcompany[company_name]</h5>";}?>
								<div class="profile-footer">

								<form action="konten/edit-leads.php" method="post">
									<a href="?hal=detail-leads&detail=<?php echo"$pecah[id]";?>" style="color:white" class="pull-left">Preview <i class="fa fa-eye"></i></a> <button type="submit" class="btn btn-default" value="save_data">Save Data</button>
								</div>
							</div>
						</div>
					</header>
				
							<div class="panel panel-accordion panel-accordion-first">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1One">
											<i class="fa fa-user"></i> Basic Info
										</a>
									</h4>
								</div>
								<div id="collapse1One" class="accordion-body collapse in">
									<div class="panel-body">
									<div class="form-group">
										<div class="col-sm-4">
											<input value="<?php echo"$pecah[id]";?>" type="hidden" name="id">
										</div>
									</div>
										<div class="widget-todo-list">
											<div class="form-group">
												<label class="col-sm-3 control-label">Type</label>
												<div class="col-sm-8">
													<select name="tipe" id="select" class="form-control">
													<?php if($pecah['type']=="personal"){
														echo'<option value="personal" selected>personal</option>
														<option value="corporate">corporate</option>';
														}
														else{
														echo'<option value="corporate" selected>corporate</option>
														<option value="personal">personal</option>';
													
														}?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Customer Name</label>
												<div class="col-sm-4">
													<input type="text" name="fname" placeholder="First Name" class="form-control" value="<?php echo"$pecah[nama]";?>">
												</div>
												<div class="col-sm-4">
													<input type="text" name="lname" placeholder="Last Name" class="form-control" value="<?php echo"$pecah[lname]";?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Email</label>
												<div class="col-sm-8">
													<input type="email" name="email" placeholder="Email" class="form-control" value="<?php echo"$pecah[email]";?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Phone</label>
												<div class="col-sm-8">
													<input type="text" name="phone" placeholder="Phone" class="form-control" value="<?php echo"$pecah[phone]";?>">
												</div>
											</div>
											<!-- hide -->
											
											<?php if($pecah['type']=="corporate"){
												echo'<div class="corp">';
											}
											else{
												echo'<div style="display: none;" class="corp">';
											}?>
											<div class="form-group">
												<label class="col-sm-3 control-label">Company</label>
												<div class="col-sm-8">
													<input type="text" name="company" placeholder="Company Name" class="form-control" value=<?php echo"$pecahcompany[company_name]";?>>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Industry</label>
												<div class="col-sm-8">
												<select name="industry"> class="form-control mb-md">
												<?php if(!empty($pecahcompany['industry'])){
													echo"<option>$pecahcompany[industry]</option>";}?>
													<option >- Select One -</option>
												      <option>Accountant / Tax Firm</option>
												      <option>Design Services</option>
												      <option>Law Firm</option>
												      <option>Software Company</option>
												      <option>Travel and Leisure</option>
												      <option>Startup</option>
												      <option>Real Estate</option>
												      <option>Energy / Cleantech</option>
												      <option>Agency (Marketing, Web, Advertising, Video)</option>
												      <option>Financial or Credit Services</option>
												      <option>Manufacturing</option>
												      <option>Consultant (IT, Marketing, Sales)</option>
												     <option>Event Planning</option>
												     <option>Other</option>
												}
												</select>
												</div>
											</div>
											</div>
										</div>
									</div>
								</div>
							<div class="panel panel-accordion panel-accordion-first">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1Two">
											 <i class="fa fa-map-marker"></i> Address
										</a>
									</h4>
								</div>
								<div id="collapse1Two" class="accordion-body collapse">
									<div class="panel-body">
										<div class="widget-todo-list">
											<?php
											if(!empty($pecahaddress['address1'])){?>
											<div class="form-group">
												<label class="col-sm-3 control-label">Street</label>
												<div class="col-sm-8">
													<div class="input-group">
													<input type="text" name="address1" placeholder="Address" class="form-control" value="<?php echo"$pecahaddress[address1]";?>">
														<span class="input-group-addon">
															<a onclick="getlokasi()" href="#"><i class="fa fa-crosshairs"></i></a>
														</span>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label"></label>
												<div class="col-sm-8">
													<input type="text" name="address2" placeholder="Address" class="form-control" value="<?php echo"$pecahaddress[address2]";?>" disabled>					</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">City & Zip</label>
												<div class="col-sm-6">
													<input type="text" name="city" placeholder="City" class="form-control" value="<?php echo"$pecahaddress[city]";?>" disabled>
												</div>
												<div class="col-sm-2">
													<input type="text" name="postalcode" placeholder="ZIP/Postal Code" class="form-control" value="<?php echo"$pecahaddress[postalcode]";?>" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">State/Region</label>
												<div class="col-sm-8">
													<input type="text" name="state" placeholder="State/Region" class="form-control" value="<?php echo"$pecahaddress[state]";?>" disabled>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Country</label>
												<div class="col-sm-8">
													<select class="form-control mb-md" name="country" disabled>
														<option>Select Country</option>
														<option selected>Indonesia</option>
														<option>United State</option>
													</select>
												</div>
											</div>
										<?php }else{echo'<a href="#" class="btn btn-primary" onclick="picklokasi()">Set location</a>';}?></div>
									</div>
								</div>
							
							<div class="panel panel-accordion">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1Four">
											 <i class="fa fa-bars"></i> Other
										</a>
									</h4>
								</div>
								<div id="collapse1Four" class="accordion-body collapse">
								<div class="panel-body">
										<div class="widget-todo-list">
											<div class="form-group">
												<label class="col-sm-3 control-label">Competitor</label>
												<div class="col-sm-8">
													<select class="form-control" id="competitor">
														<option value="Speedy">Speedy</option>
														<option value="Frist Media">First Media</option>
														<option value="BizNet">BizNet</option>
														<option value="Other">Other</option>
													</select>
												</div>
											</div>
											<div style="display: none;" class="oth">
											<div class="form-group">
												<label class="col-sm-3 control-label"></label>
												<div class="col-sm-8">
													<textarea placeholder="Description" class="col-md-12 form-control"></textarea>
												</div>
											</div>
											</div>
											<div class="form-group">
												<label class="col-sm-3 control-label">Lead Status</label>
												<div class="col-sm-8">
													<select class="form-control">
														<option>New</option>
														<option>Working</option>
														<option>Unqualified</option>
													</select>
												</div>
											</div><!--
											<div class="form-group">
												<label class="col-sm-3 control-label">Lead Source</label>
												<div class="col-sm-8">
													<select class="form-control">
														<option>Canvasing</option>
														<option>Recomend</option>
														<option>Internet</option>
													</select>
												</div>
											</div>
											<div class="form-group">
											<label class="col-sm-3 control-label">Tags</label>
												<div class="col-sm-8">
												<input type="text" data-role="tagsinput" name="tags" placeholder="" class="form-control">
											</div>
-->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>	
				</section>
			</div>
			<script type="text/javascript">
				function picklokasi(){
			    	window.open("konten/location.php?id=<?php echo"$pecah[id]";?>", "_blank", "toolbar=no, scrollbars=no, resizable=yes, top=100, left=100, width=800, height=700");
			    }
			    function getlokasi(){
			    	window.open("konten/location.php?id=<?php echo"$pecah[id]";?>&lat=<?php echo"$pecahaddress[lat]";?>&lng=<?php echo"$pecahaddress[lng]";?>", "_blank", "toolbar=no, scrollbars=no, resizable=yes, top=100, left=100, width=800, height=700");
			    }
			</script>
			<script type="text/javascript">
			
			    $('.oth').hide();

			    $('#competitor').change(function () {
			        if ($('#competitor option:selected').text() != "Other"){
			            $('.oth').hide();
			        }
			        else if ($('#competitor option:selected').text() == "Other"){
			            $('.oth').show();
			        }
			    }); 
			});
			</script>
			
			<?php }?>
			