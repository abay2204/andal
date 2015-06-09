<section role="main" class="content-body">
          <header class="page-header">
          <?php $keyakses="Detail unqualified";?>
            <h2><?php echo"$keyakses";?></h2>
            <title><?php echo"$keyakses | CRM Nusanet";?></title>
            <div class="right-wrapper pull-right">
              <ol class="breadcrumbs">
                <li>
                  <a href="index.php">
                    <i class="fa fa-home"></i>
                  </a>
                  </li>
                <li><span><?php echo"unqualified";?></span></li>
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
	<div class="col-md-6">
	<?php
if(isset($_POST['add_contact'])){
	$data=$_POST['contact_data'];
	$address=getaddress($_POST['lat'],$_POST['lng']);
	foreach ($_POST['contact_type'] as $type => $value){
		$add_kontak=mysql_query("insert into customer_contact(contact_id,contact_name,contact_type,contact_data,sales,sm) value ('$_GET[detail]','$_POST[contact_name]','$value','$data[$type]','$_SESSION[userid]','$_SESSION[sm]')");
	}
 			if($add_kontak){
 			mysql_query("insert into history (id,history_action,keterangan,date,time,lokasi,lat,lng,userid) value ('$_GET[detail]','Add Contact','Add contact $_POST[contact_name]','$date','$time','$address','$_POST[lat]','$_POST[lng]','$_SESSION[userid]')");
 			$_SESSION['sukses']="Success add contact";
 			header("location:?hal=detail-unqualified&detail=$_GET[detail]");
 		}
 		else{
 			$_SESSION['error']="Something wrong";
 			header("location:?hal=detail-unqualified&detail=$_GET[detail]");

 		}
}
if(isset($_POST['edit_status'])){
	$reason=mysql_escape_string($_POST['unreason']);
	if($_POST['unreason']!=null){
		$edit_status=mysql_query("insert into unqualified select * from unqualified where id='$_GET[detail]'");
		if($edit_status){
			mysql_query("update unqualified set status='Unqualified' where id='$_GET[detail]'");
			mysql_query("delete from unqualified where id='$_GET[detail]'");
			mysql_query("insert into history (id,history_action,keterangan,date,time,lokasi,lat,lng,userid) value('$_GET[detail]','Unqualified','$reason <br/> posted by $_SESSION[nama]','$date','$time','$address','$_POST[lat]','$_POST[lng]','$_SESSION[userid]'");
			$_SESSION['sukses']="Success";
 			header("location:?hal=unqualified");
		}
		else{
 			$_SESSION['error']="Something wrong";
 			header("location:?hal=detail-unqualified&detail=$_GET[detail]");

 		}
 	}
	else{
		$edit_status=mysql_query("update unqualified set status='Working' where id='$_GET[detail]'");
		if($edit_status){
			$_SESSION['sukses']="Success";
 			header("location:?hal=detail-unqualified&detail=$_GET[detail]");
 		}
 		else{
 			$_SESSION['error']="Something wrong";
 			header("location:?hal=detail-unqualified&detail=$_GET[detail]");

 		}
	}
}
if(isset($_POST['edit_contact'])){
	$idkontak=$_POST['kontak_id'];
	$kontakbaru=$_POST['kontak_baru'];
	$address=getaddress($_POST['lat'],$_POST['lng']);
	foreach ($_POST['kontak_id'] as $type => $value){
		$kueri=mysql_query("update customer_contact set contact_data='$kontakbaru[$type]' where id='$value'");
	}
	if($kueri){
		$_SESSION['sukses']="success";
		mysql_query("insert into history (id,history_action,keterangan,date,time,lokasi,lat,lng,userid) value ('$_POST[id_nya]','Edit Contact','Edit contact $_POST[contact_name]','$date','$time','$address','$_POST[lat]','$_POST[lng]','$_SESSION[userid]')");
	}
	else{
		$_SESSION['error']="error";
	}
	header("location:?hal=detail-unqualified&detail=$_GET[detail]");
}
if(isset($_POST['delete_contact'])){
	$kontak=$_POST['kontak'];
	$address=getaddress($_POST['lat'],$_POST['lng']);
	$kueri=mysql_query("delete from customer_contact where contact_name='$kontak'");
	if($kueri){
		$_SESSION['sukses']="success";
		mysql_query("insert into history (id,history_action,keterangan,date,time,lokasi,lat,lng,userid) value ('$_POST[kontakid]','Delete Contact','Delete contact $_POST[kontak]','$date','$time','$address','$_POST[lat]','$_POST[lng]','$_SESSION[userid]')");
	}
	else{
		$_SESSION['error']="error";
	}
	header("location:?hal=detail-unqualified&detail=$_GET[detail]");
}?>
		<?php
		if(isset($_GET['detail'])){
			if($_SESSION['level']=="0"){
				$cek=mysql_num_rows(mysql_query("select * from unqualified"));
			}
			elseif($_SESSION['level']=="1"){
				$cek=mysql_num_rows(mysql_query("select * from unqualified where id='$_GET[detail]' and sm='$_SESSION[userid]'"));
			}
			elseif($_SESSION['level']=="2"){
				$cek=mysql_num_rows(mysql_query("select * from unqualified where id='$_GET[detail]' and sales='$_SESSION[userid]'"));
			}
		if($cek == "0"){
			$_SESSION['error']="Forbidden";
			header('location:?hal=unqualified');
		}
		$idakun=mysql_escape_string($_GET['detail']);
		$kueri=mysql_query("select * from unqualified where id='$idakun'");
		$company=mysql_fetch_array(mysql_query("select * from customer_company where id='$idakun'"));
		$address=mysql_fetch_assoc(mysql_query("select * from customer_address where id='$idakun'"));
		$pecah=mysql_fetch_array($kueri);?>
										<section class="panel panel-group">
											<header class="panel-heading bg-primary">
						
												<div class="widget-profile-info">
													<div class="profile-picture">
														<img src="assets/images/!logged-user.jpg">
													</div>
													<div class="profile-info">
														<h4 class="name text-semibold"><?php echo"$pecah[nama] $pecah[lname]</h4>";?>
														<?php if($pecah['type']=="corporate"){
														echo"<h5 class=role>$company[company_name]</h5>";}
														$salesid=$pecah['sales'];
														$namasales=mysql_fetch_array(mysql_query("select * from user where userid='$salesid'")); ?>
														<div class="profile-footer">
															(<?php echo"$namasales[nama]";?>)
														</div>
													</div>
												</div>
						
											</header>
											<div id="accordion">
												<div class="panel panel-accordion panel-accordion-first">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a data-toggle="collapse" data-parent="#accordion" href="#collapse1One">
																<i class="fa fa-user"></i> Basic Info
															</a>
														</h4>
													</div>
													<div id="collapse1One" class="accordion-body collapse in">
														<div class="panel-body">
															<div class="widget-todo-list">
																<div class="table-responsive">
																	<table class="table mb-none">
																		<tbody>
																			<tr>
																				<td>Customer</td>
																				<td><?php echo"$pecah[nama] $pecah[lname]</h4>";?></td>
																			</tr>
																			<tr>
																				<td>Type</td>
																				<td><?php echo"$pecah[type]";?></td>
																			</tr>
																			<tr>
																				<td>Phone</td>
																				<td><?php echo"$pecah[phone]";?></td>
																			</tr>
																			<tr>
																				<td>Email</td>
																				<td><?php echo"$pecah[email]";?></td>
																			</tr>
																		</tbody>
																	</table>
																</div>
														</div>
													</div>
												</div>
											<div class="panel panel-accordion">
	<div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#address">
				 <i class="fa fa-map-marker"></i> Address
			</a>
		</h4>
	</div>
	<div id="EditStatus" class="zoom-anim-dialog modal-block modal-header-color modal-block-primary mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Edit Status<button class="btn btn-primary pull-right modal-dismiss"><b>X</b></button></h2>
				</header>
				<div class="panel-body">
                    <form id="form" method="POST" class="form-horizontal pers">
                     <div class="form-group">
                        <label class="col-sm-3 control-label">Status<span class="required">*</span></label>
                        <div class="col-sm-9">
                        <select id="status" name="status">
                        <option value="Working">Working</option>
                        <option value="Unqualified">Unqualified</option>
                        </select>
                        </div>
                    </div>
                     <div style="display:none" class="form-group unreason">
                        <label class="col-sm-3 control-label">Reason<span class="required">*</span></label>
                        <div class="col-sm-9">
                        <textarea name="unreason" placeholder="harus di isi"></textarea>
                    </div>
                    </div>  
                     <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="submit" name="edit_status" class="btn btn-primary">Edit status</button>
                        </div>
                    </div>
                </form>
                </div>
			</section>
		</div>
	</div>
	<div id="address" class="accordion-body collapse">
		<div class="panel-body">
			<div class="widget-todo-list">
				<div class="table-responsive">
					<table class="table mb-none">
						<tbody>
							<tr>
								<td>Street</td>
							<td><?php echo"$address[address1]";?></td>
							</tr>
							<tr>
								<td>Street2</td>
							<td><?php echo"$address[address2]";?></td>
							</tr>
							<tr>
								<td>City</td>
								<td><?php echo"$address[city]";?></td>
							</tr>
							<tr>
								<td>ZIP Code</td>
								<td><?php echo"$address[postalcode]";?></td>
							</tr>
							<tr>
								<td>State</td>
								<td><?php echo"$address[state]";?></td>
							</tr>
							<tr>
								<td>Country</td>
								<td><?php echo"$address[country]";?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
												<?php if($pecah['type']=="corporate"){
	$corporate=mysql_fetch_array(mysql_query("select * from customer_company where id='$_GET[detail]'"))?>
	<div class="panel panel-accordion">
	<div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#business">
				 <i class="fa fa-building"></i> Bussiness
			</a>
		</h4>
	</div>
	<div id="business" class="accordion-body collapse">
		<div class="panel-body">
			<div class="widget-todo-list">
				<div class="table-responsive">
					<table class="table mb-none">
						<tbody>
							<tr>
								<td>Type</td>
								<td><?php echo"Corporate";?></td>
							</tr>
							<tr>
								<td>Company Name</td>
								<td><?php echo"$corporate[company_name]";?></td>
							</tr>
							<tr>
								<td>Industry</td>
								<td><?php echo"$corporate[industry]";?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php }?>
											<div class="panel panel-accordion">
	<div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#other">
				 <i class="fa fa-bars"></i> Other
			</a>
		</h4>
	</div>
	<div id="other" class="accordion-body collapse">
	<div class="panel-body">
			<div class="widget-todo-list">
				<div class="table-responsive">
					<table class="table mb-none">
						<tbody>
							<tr>
								<td>Status</td>
								<td><?php echo"$pecah[status]";?></td>
								<td> <a class="mb-xs mt-xs mr-xs modal-basic" href="#EditStatus"><i class="fa fa-edit"></i></a></td>
							</tr>
							<tr>
								<td>Source</td>
								<td><?php echo"$pecah[source]";?></td>
							</tr><!--
							<tr>
								<td>Competitor</td>
								<td>Speedy</td>
							</tr>
							<tr>
								<td>Tags</td>
								<td><span class="highlight">system</span> <span class="highlight">integrator</span></td>
							</tr>
							-->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</section>
</div>

									<div class="col-md-6">
						<div class="toggle" data-plugin-toggle>
							<section class="toggle">
							 <?php if(isset($_POST['edit_oppor'])){
        	$userid=mysql_escape_string($_GET['detail']);
        	$package=mysql_escape_string($_POST['package']);
        	$close=mysql_escape_string($_POST['prediction']);
        	$address=getaddress($_POST['lat'],$_POST['lng']);
 			$edit_opportunity=mysql_query("update customer_opportunity set stages='$_POST[stages]',package='$package',terms='$_POST[terms]',value='$_POST[value]',sm='$_SESSION[sm]',sales='$_SESSION[userid]',close_prediction='$close' where id='$_POST[id]'");
 			if($edit_opportunity){
 			mysql_query("insert into history (id,history_action,keterangan,date,time,lokasi,lat,lng,userid) value ('$_GET[detail]','Edit Oppurtunity','edit opportunity $package','$date','$time','$address','$_POST[lat]','$_POST[lng]','$_SESSION[userid]')");
 			$_SESSION['sukses']="Success edit opportunity";
 			header("location:?hal=detail-unqualified&detail=$_GET[detail]");
 		}
 		else{
 			$_SESSION['error']="Something wrong";
 			header("location:?hal=detail-unqualified&detail=$_GET[detail]");

 		}
        }?>
								<label>Oppurtunity</label>
								<div class="toggle-content panel-body">
								<div style="padding: 10px;" class="row"><a href="" class="survei btn btn-default pull-right" >Request Survei</a> 
								<?php if($_SESSION['level']=="2"){
								echo'<a href="#AddOpportunity" class="btn btn-default pull-right modal-basic">Add Opportunity</a></div>';}
									$oppor=mysql_query("select * from customer_opportunity where userid='$_GET[detail]'");
									while($pecahoppor=mysql_fetch_array($oppor)){
									echo'<section  style="padding: 10px;" class="panel panel-featured-left panel-featured-primary">
										
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-primary">
														<i class="fa fa-dollar"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">'.$pecahoppor['package'].'<a class="modal-basic" title="update opportunity" href="#EditOpportunity'.$pecahoppor['id'].'"><i class="fa fa-external-link pull-right"></i></a></h4>
														<div class="info">
															<strong class="amount">'.$pecahoppor['value'].'</strong><br />
															<span class="text-primary">Close Prediction: '.$pecahoppor['close_prediction'].'</span>
														</div>
													</div>
													<div class="summary-footer">
														<a href="" class="text-muted text-uppercase">'.$pecahoppor['stages'].'</a>
													</div>
												</div>
											</div>
									</section>
									 <div id="EditOpportunity'.$pecahoppor['id'].'" class="zoom-anim-dialog modal-block modal-header-color modal-block-primary mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Edit Opportunity <a class="pull-right btn btn-primary modal-dismiss"><i style="color: white;" class="fa fa-times"></i></a></h2>
				</header>
				<div class="panel-body">
				<form id="form" method="post" class="form-horizontal">
					<div class="tab-content">
						<div class="tab-pane active">
							<div class="form-group">
								<div class="col-md-3">
								<div class=lokasi></div>
									<label class="control-label">Stages</label>
									<input name="id" type="hidden" value="'.$pecahoppor['id'].'">
									
								</div>
								<div class="col-md-9">
									<select name="stages" id="stages" class="form-control">
										<option>Show interest</option>
										<option>Waiting for response</option>
										<option>Qualified</option>
										<option>Initial engagement</option>
										<option>Advanced engagement</option>
										<option>Close: Win</option>
										<option value="Close: Lose">Close: Lose</option>
									</select>
								</div>
							</div>
							<div class="reason form-group">
								<div class="col-md-3">
									<label class="control-label">Reason</label>
								</div>
								<div class="col-md-9">
									<textarea name="reason" class="form-control"></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">Package</label>
								</div>
								<div class="col-md-9">
									<input name="package" type="text" class="form-control" value="'.$pecahoppor['package'].'">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">Value</label>
								</div>
								<div class="col-md-9">
									<div class="input-group mb-md">
										<span class="input-group-addon btn-default">Rp.</span>
										<input name="value" type="textbox" class="form-control currency" value="'.$pecahoppor['value'].'">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">Term</label>
								</div>
								<div class="col-md-9">
									<select name="terms" class="form-control">
										<option>Month</option>
										<option>Semi</option>
										<option>Year</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">Close Prediction</label>
								</div>
								<div class="col-md-9">
									<input name="prediction" type="text" class="form-control" value="'.$pecahoppor['close_prediction'].'">
								</div>
							</div>
							<div class="form-group">
							<div class="col-md-3"></div>
								<div class="col-md-9">
									<button name="edit_oppor" class="btn btn-primary col-md-12" type="submit">Save</button>
								</div>
							</div>
						</div>
					</div>	
				</form>
			</section>
		</div>';
								}?>
								</div>
							</section>
							<section class="toggle">
								<label>Contact Person</label>
								<div class="toggle-content panel-body">
								<div class="row">
									<a href="#AddContact" class="btn btn-default pull-right modal-basic"> Add Contact</a>
								</div>
								
									
													<?php
					$kuerikontak=mysql_query("select * from customer_contact where contact_id='$_GET[detail]' group by contact_name");
 						$jumlahkontak=mysql_num_rows($kuerikontak);
 						$i="0";
							while($pecahkontak=mysql_fetch_array($kuerikontak)){
								$phones=mysql_fetch_array(mysql_query("select * from customer_contact where contact_id='$_GET[detail]' and contact_type='Mobile Phone' and contact_name='$pecahkontak[contact_name]'"));
								$email=mysql_fetch_array(mysql_query("select * from customer_contact where contact_id='$_GET[detail]' and contact_type='email' and contact_name='$pecahkontak[contact_name]'"));
								$work=mysql_fetch_array(mysql_query("select * from customer_contact where contact_id='$_GET[detail]' and contact_type='Office Phone' and contact_name='$pecahkontak[contact_name]'"));
 									echo'	<section class="panel panel-featured-left panel-featured-primary">
 									<div class="panel-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-primary">
														<i class="fa fa-user"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">	<h4 class="title"><a class="modal-basic" href="#DetailContact'.$i.'">'.$pecahkontak['contact_name'].' </a><a class="modal-basic" href="#EditContact'.$i.'" title="Edit Contact"><i class="fa fa-external-link pull-right"></i></a><a class="modal-basic" href="#deletecontact'.$i.'" title="Edit Contact"><i class="fa fa-trash-o pull-right"></i></a></h4>
														<div class="info">
															<div class="info">
																<table style="100%">
																	<tr>
																		<td width="18%"><i class="fa fa-phone"></i></td>
																		<td>';
								if(empty($phones['contact_data']))echo "not available";
								else echo "<a href='tel:$phones[contact_data]'>$phones[contact_data]</a>";
									echo'</td>
																	</tr>
																	<tr>
																		<td width="18%"><i class="fa fa-mobile"></i></td>
																		<td>';
								if(empty($work['contact_data']))echo "not available";
								else echo "<a href='tel:$work[contact_data]'>$work[contact_data]</a>";
									echo'</td>
																	</tr>
																	<tr>
																		<td width="18%"><i class="fa fa-envelope"></i></td>
																		<td>';
								if(empty($email['contact_data']))echo "not available";
								else echo "<a href='mailto:$email[contact_data]'>$email[contact_data]</a>";
									echo'</td>
																	</tr>
																</table>
															</div>
														</div>
													</div>
 												</div>
											</div>
										</div>
									</section>';
								$phonedetail=mysql_query("select * from customer_contact where contact_id='$_GET[detail]' and contact_type='Mobile Phone' and contact_name='$pecahkontak[contact_name]'");

//Edit contact start here//
 echo'<div id="EditContact'.$i.'" class="zoom-anim-dialog modal-block modal-header-color modal-block-primary mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Edit Contact <a class="pull-right btn btn-primary modal-dismiss"><i style="color: white;" class="fa fa-times"></i></a></h2>
				</header>
				<div class="panel-body">
				<form id="form" method="post" class="form-horizontal">
					<div class="tab-content">
						<div class="tab-pane active">
						<input type="hidden" name="contact_name" value="'.$pecahkontak['contact_name'].'">
						<input type="hidden" name="id_nya" value="'.$pecahkontak['contact_id'].'">';
						$phone=mysql_query("select * from customer_contact where  contact_type='Mobile Phone' and contact_name='$pecahkontak[contact_name]'");
						while($pecahphones=mysql_fetch_array($phone)){
							echo'<div class="form-group">
							<div class="col-md-1"></div>
								<div class="col-md-10">
									<div class="input-group input-group-icon">
										<span class="input-group-addon">
											<span class="icon"><i class="fa fa-phone"></i></span>
 										</span>
										<input name="kontak_baru[]" type="text" class="form-control" value="'.$pecahphones['contact_data'].'">
										<input name="kontak_id[]" type="hidden" value="'.$pecahphones['id'].'">
 									</div>
								</div>
							</div>';
						}
						$office=mysql_query("select * from customer_contact where  contact_type='Office Phone' and contact_name='$pecahkontak[contact_name]'");
						while($pecahoffice=mysql_fetch_array($office)){
							echo'<div class="form-group">
							<div class="col-md-1"></div>
								<div class="col-md-10">
									<div class="input-group input-group-icon">
										<span class="input-group-addon">
											<span class="icon"><i class="fa fa-mobile"></i></span>
										</span>
										<input name="kontak_baru[]" type="text" class="form-control" value="'.$pecahoffice['contact_data'].'">
										<input name="kontak_id[]" type="hidden" value="'.$pecahoffice['id'].'">
 									</div>
								</div>
							</div>';
						}
						$emails=mysql_query("select * from customer_contact where  contact_type='email' and contact_name='$pecahkontak[contact_name]'");
						while($pecahemail=mysql_fetch_array($emails)){
							echo'<div class="form-group">
							<div class="col-md-1"></div>
								<div class="col-md-10">
									<div class="input-group input-group-icon">
										<span class="input-group-addon">
											<span class="icon"><i class="fa fa-envelope"></i></span>
										</span>
										<input name="kontak_baru[]" type="text" class="form-control" value="'.$pecahemail['contact_data'].'">
										<input name="kontak_id[]" type="hidden" value="'.$pecahemail['id'].'">
									</div>
								</div>
							</div>';
						}
						$web=mysql_query("select * from customer_contact where contact_type='Website' and contact_name='$pecahkontak[contact_name]'");
						while($pecahweb=mysql_fetch_array($web)){
							echo'<div class="form-group">
							<div class="col-md-1"></div>
								<div class="col-md-10">
									<div class="input-group input-group-icon">
										<span class="input-group-addon">
											<span class="icon"><i class="fa fa-globe"></i></span>
										</span>
										<input name="kontak_baru[]" type="text" class="form-control" value="'.$pecahweb['contact_data'].'">
										<input name="kontak_id[]" type="hidden" value="'.$pecahweb['id'].'">
									</div>
								</div>
							</div>';
							}
							echo'<div class="form-group">
							<div class="lokasi"></div>
							<div class="col-md-1"></div>
								<div class="col-md-10">
									<button name="edit_contact" class="btn btn-primary col-md-12" type="submit">Save</button>
								</div>
							</div>
						</div>
					</div>	
				</form>
			</section></div>';
//end here//
//delete contact//
			echo'<div id="deletecontact'.$i.'" class="modal-block modal-block-warning modal-header-color mfp-hide">
<form id="form" method="post" class="form-horizontal">
										<section class="panel">
											<header class="panel-heading">
												<h2 class="panel-title">Are you sure?</h2>
											</header>
											<div class="panel-body">
												<div class="modal-wrapper">
													<div class="modal-icon">
														<i class="fa fa-question-circle"></i>
													</div>
													<div class="modal-text">
														<h4>Delete '.$pecahkontak['contact_name'].'</h4>
														<p>Are you sure want to delete contact '.$pecahkontak['contact_name'].'?</p>
													</div>
												</div>
											</div>
											<footer class="panel-footer">
												<div class="row">
													<div class="col-md-12 text-right">
													<div class="lokasi"></div>
													<input name="kontak" type="hidden" value="'.$pecahkontak['contact_name'].'">
													<input name="kontakid" type="hidden" value="'.$pecahkontak['contact_id'].'">
														<button name="delete_contact" type="submit" class="btn btn-warning">Yes</button>
														<button class="btn btn-default modal-dismiss">No</button>
													</form>
													</div>
												</div>
											</footer>
										</section>
									</div>';
//end here//
//detail contact start here//
			echo'<div id="DetailContact'.$i.'" class="zoom-anim-dialog modal-block modal-header-color modal-block-primary mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Edit Contact <a class="pull-right btn btn-primary modal-dismiss"><i style="color: white;" class="fa fa-times"></i></a></h2>
				</header>
				<div class="panel-body">
				<form id="form" action="#" class="form-horizontal">
					<div class="tab-content">
						<div class="tab-pane active">';
						$phone=mysql_query("select * from customer_contact where contact_id='$_GET[detail]' and contact_type='Mobile Phone' and contact_name='$pecahkontak[contact_name]'");
						while($pecahphones=mysql_fetch_array($phone)){
							echo'<div class="form-group">
							<div class="col-md-1"></div>
								<div class="col-md-10">
									<div class="input-group input-group-icon">
										<span class="icon"><i class="fa fa-phone"></i></span>
										<a href="tel:'.$pecahphones['contact_data'].'"> '.$pecahphones['contact_data'].'</a>
									</div>
								</div>
							</div>';
						}
						$office=mysql_query("select * from customer_contact where contact_id='$_GET[detail]' and contact_type='Office Phone' and contact_name='$pecahkontak[contact_name]'");
						while($pecahoffice=mysql_fetch_array($office)){
							echo'<div class="form-group">
							<div class="col-md-1"></div>
								<div class="col-md-10">
									<div class="input-group input-group-icon">
 										<span class="icon"><i class="fa fa-mobile"></i></span>
 										<a href="tel:'.$pecahoffice['contact_data'].'"> '.$pecahoffice['contact_data'].'</a>
									</div>
								</div>
							</div>';
						}
						$emails=mysql_query("select * from customer_contact where contact_id='$_GET[detail]' and contact_type='email' and contact_name='$pecahkontak[contact_name]'");
						while($pecahemail=mysql_fetch_array($emails)){
							echo'<div class="form-group">
							<div class="col-md-1"></div>
								<div class="col-md-10">
									<div class="input-group input-group-icon">
										<span class="icon"><i class="fa fa-envelope"></i></span> 
										<a href="mailto:'.$pecahemail['contact_data'].'"> '.$pecahemail['contact_data'].'</a>
									</div>
								</div>
							</div>';
						}
						$web=mysql_query("select * from customer_contact where contact_id='$_GET[detail]' and contact_type='Website' and contact_name='$pecahkontak[contact_name]'");
						while($pecahweb=mysql_fetch_array($web)){
							echo'<div class="form-group">
							<div class="col-md-1"></div>
								<div class="col-md-10">
									<div class="input-group input-group-icon">
										<span class="icon"><i class="fa fa-globe"></i></span>
										<a href="http://'.$pecahweb['contact_data'].'"> '.$pecahweb['contact_data'].'</a>
									</div>
								</div>
							</div>';
							}
							echo'<div class="form-group">
							<div class="col-md-1"></div>
								<div class="col-md-10">
									<button class="btn btn-primary col-md-12 modal-dismiss" type="submit">Close</button>
								</div>
							</div>
						</div>
					</div>	
				</form>
			</section></div>';
//end here//			
			$i++;
														}}?>
 								
							</section>
							<!--<section class="toggle">
								<label>Update Progress</label>
								<div class="toggle-content panel-body">
									 <form method="post">
						                <input name="id" type="hidden" value="nn13041">
						                    <div class="form-group">
						                        <label class="control-label">Status</label>
						                    </div>
						                    <div class="form-group">
						                        <select class="form-control">
						                        	<option>Working</option>
						                        	<option>Qualified</option>
						                        	<option>Unqualified</option>
						                        </select>
						                    </div>
						                    <div class="form-group">
						                        <label class="control-label">Action</label>
						                    </div>
						                    <div class="form-group">
						                        <select name="history_action" id="action" class="form-control">
						                                <option value="Call" selected>Call</option><option value="start_meeting">Meeting</option><option value="Follow Up">Follow Up</option>
						                                <option value="Canvasing">Canvasing</option>
						                            </select>
						                    </div>
						                    <div style="display: none;" class="meeting">
						                        <div id="start">
						                        <div class="form-group"><button name="meeting" class="btn btn-primary col-md-12" value="Start Meeting">Start</button>
						                            <div id='meeting'><div id='lokasi'></div></div>
						                            </div>
						                        </div>
						                    </div>
						                    <div class="notmeeting">
						                        <div class="form-group">
						                            <label class="control-label">Description</label>
						                        </div>
						                        <div class="form-group">
						                                <textarea name="deskripsi" class="col-sm-12"></textarea>
						                        </div>
						                        <div class="form-group text-right">
						                            <button class="btn btn-default modal-dismiss">Cancel</button>
						                            <button type="submit" class="btn btn-primary">Save Progress</button>
						                        </div>
					                    </div>
					                </form>    
								</div>
							</section>	-->
							<section class="toggle">
								<label>Progress History</label>
								<div class="toggle-content panel-body">
 								<div class="timeline timeline-simple mt-xlg mb-md">
											<div class="tm-body">
											<?php
$datehistory=mysql_query("select * from history where id='$pecah[id]' group by date order by date desc");
while($pecahdate=mysql_fetch_array($datehistory)){
echo'<div class="tm-title">
	<h3 class="h5 text-uppercase">'.$pecahdate['date'].'</h3>
</div>
<ol class="tm-items">';
$historynya=mysql_query("select * from history where id='$pecah[id]' and date='$pecahdate[date]' order by time desc ");
while($pecahhistory=mysql_fetch_array($historynya)){
	echo'<li>
		<div class="tm-box" data-toggle="tooltip" title="'.$pecahhistory['lokasi'].'" data-placement="top">
			<p class="text-muted mb-none">'.$pecahhistory['time'].'</p>
			<p>
			<b>'.$pecahhistory['history_action'].'</b>
			<p>
				'.$pecahhistory['keterangan'].'
			</p>
		</div>
	</li>';}}?>
											</ol>
											</div>
										</div>
								</div>
							</section>
						</div>
								</div>
							</section>
						</div>
						</div>
				<!-- start modal -->
				<div id="AddContact" class="zoom-anim-dialog modal-block modal-header-color modal-block-primary mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Add Contact <a class="pull-right btn btn-primary modal-dismiss"><i style="color: white;" class="fa fa-times"></i></a></h2>
				</header>
				<div class="panel-body">
				<form id="form" method="post" class="form-horizontal">
					<div class="tab-content">
						<div id="phone" class="tab-pane active">
							<div class="form-group">
								<div class="col-sm-3">
									<label class="control-label">Contact Name </label>
									<input type="hidden" value="<?php echo "$_GET[detail]";?>">
									<div class="lokasi"></div>
								</div>
								<div class="col-sm-8">
									<input type="text" name="contact_name" placeholder="" class="form-control">
								</div>
							</div>	
							<div id="items">
								<div class="form-group">
									<div class="col-sm-3">
										<select name="contact_type[]" class="form-control" data-plugin-multiselect id="mode">
											<option value="Mobile Phone">Mobile Phone</option>
											<option value="Office Phone">Office Phone</option>
											<option value="Website">Website</option>
											<option value="Email">Email</option>
											<option value="Facebook">Facebook</option>
											<option value="Twitter">Twitter</option>
											<option value="Linkedin">Linkedin</option>
										</select>
									</div>
									<div class="col-sm-8">
										<input type="text" name="contact_data[]" placeholder="" class="form-control">
									</div>
								</div>	
							</div>
							<div class="form-group">
								<div class="col-md-11">
									<a class="pull-right btn btn-default" id="add"><i class="fa fa-plus"></i> Add Field</a>
								</div>
 							</div>
 						</div>
					</div>
 					<input type="submit" name="add_contact" class="btn btn-primary pull-right" value="Add Contact">
 				</div>
				
				</form>
			</section>
		</div>
	</div>
	 <?php if(isset($_POST['add_oppor'])){
        	$userid=mysql_escape_string($_GET['detail']);
        	$package=mysql_escape_string($_POST['package']);
        	$close=mysql_escape_string($_POST['prediction']);
        	$address=getaddress($_POST['lat'],$_POST['lng']);
 			$add_opportunity=mysql_query("insert into customer_opportunity (userid,package,stages,terms,value,sm,sales,close_prediction) value ('$userid','$package','$_POST[stages]','$_POST[terms]','$_POST[value]','$_SESSION[sm]','$_SESSION[userid]','$close')");
 			if($add_opportunity){
 			mysql_query("insert into history (id,history_action,keterangan,date,time,lokasi,lat,lng,userid) value ('$_GET[detail]','Add Oppurtunity','add opportunity $package','$date','$time','$address','$_POST[lat]','$_POST[lng]','$_SESSION[userid]')");
 			$_SESSION['sukses']="Success add opportunity";
 			header("location:?hal=detail-unqualified&detail=$_GET[detail]");
 		}
 		else{
 			$_SESSION['error']="Something wrong";
 			header("location:?hal=detail-unqualified&detail=$_GET[detail]");

 		}

        }?>
       
		</div>
		 <div id="AddOpportunity" class="zoom-anim-dialog modal-block modal-header-color modal-block-primary mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Add Opportunity <a class="pull-right btn btn-primary modal-dismiss"><i style="color: white;" class="fa fa-times"></i></a></h2>
				</header>
				<div class="panel-body">
				<form id="form" method="post" class="form-horizontal">
					<div class="tab-content">
						<div class="tab-pane active">
							<div class="form-group">
								<div class="col-md-3">
								<div id="lokasi"></div>
									<label class="control-label">Stages</label>
								</div>
								<div class="col-md-9">
									<select name="stages" class="form-control">
										<option>Show interest</option>
										<option>Waiting for response</option>
										<option>Qualified</option>
										<option>Initial engagement</option>
										<option>Advanced engagement</option>
										<option>Close: Win</option>
										<option>Close: Lose</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">Package</label>
								</div>
								<div class="col-md-9">
									<input name="package" type="text" class="form-control" placeholder="SOHO 1">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">Value</label>
								</div>
								<div class="col-md-9">
									<div class="input-group mb-md">
										<span class="input-group-addon btn-default">Rp.</span>
										<input name="value" type="text" class="form-control currency" >
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">Term</label>
								</div>
								<div class="col-md-9">
									<select name="terms" class="form-control">
										<option>Month</option>
										<option>Semi</option>
										<option>Year</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label">Close Prediction</label>
								</div>
								<div class="col-md-9">
									<input name="prediction" type="text" class="form-control" placeholder="2015/01/01">
									<span class="help-block">Date format YYYY/MM/DD</span>
								</div>
							</div>
							<div class="form-group">
							<div class="col-md-3"></div>
								<div class="col-md-9">
									<button name="add_oppor" class="btn btn-primary col-md-12" type="submit">Save</button>
								</div>
							</div>
						</div>
					</div>	
				</form>
			</section>
		</div>
	<!-- end modal -->

<script>

$("#add").click(function (e) {
  //Append a new row of code to the "#items" div
    $("#items").append('<div class="form-group"><div class="col-sm-3"><select name="contact_type[]" class="form-control" data-plugin-multiselect id="mode"> <option value="Mobile Phone">Mobile Phone</option> <option value="Office Phone">Office Phone</option> <option value="Website">Website</option> <option value="Email">Email</option> <option value="Facebook">Facebook</option> <option value="Twitter">Twitter</option> <option value="Linkedin">Linkedin</option> </select> </div> <div class="col-sm-8"> <input type="text" name="contact_data[]" placeholder="" class="form-control"></div><a class="btn btn-default" onclick="$(this).parent().slideUp(function(){ $(this).remove() }); return false"><i class="fa fa-minus"></i></a></div>');
  });
$(document).live("click", "remove", function() {
    $(this).parent().remove();
});
</script>
<script type="text/javascript">
	$(document).ready(function() {

    $('.survei').hide();
	$('.reason').hide();

    //$if ($('#status').text() == "Initial engagement"){
    //       $('.survei').show();
        
    //}); 
    
});
			
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('reason').hide();

	$('#stages').change(function () {
        if ($('#stages option:selected').text() == "Close: Lose"){
            $('.reason').show();
        }
          else if ($('#stages option:selected').text() != "Close: Lose"){
			            $('.reason').hide();
		}
        
    });
})
	$('#status').change(function () {
        if ($('#status option:selected').text() !== "Unqualified"){
            $('.unreason').hide();
        }
        else if ($('#status option:selected').text() == "Unqualified"){
            $('.unreason').show();
        }
    }); ;        
</script>
<script type="text/javascript">
	var format = function(num){
	var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
	if(str.indexOf(".") > 0) {
		parts = str.split(".");
		str = parts[0];
	}
	str = str.split("").reverse();
	for(var j = 0, len = str.length; j < len; j++) {
		if(str[j] != ",") {
			output.push(str[j]);
			if(i%3 == 0 && j < (len - 1)) {
				output.push(",");
			}
			i++;
		}
	}
	formatted = output.reverse().join("");
	return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
};
$(function(){
    $(".currency").keyup(function(e){
        $(this).val(format($(this).val()));
    });
    
});
</script>
<script type="text/javascript">
    $(document).ready(function() {

    $('.meeting').hide();

    $('#action').change(function () {
        if ($('#action option:selected').text() == "Meeting"){
            $('.meeting').show();
            $('.notmeeting').hide();
        }
        else {
            $('.meeting').hide();
            $('.notmeeting').show()
        }
    }); 
});
</script>    