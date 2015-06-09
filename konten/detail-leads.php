<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
	$device="Mobile";
}
else{
	$device="Desktop";
}
if(isset($_POST['add_contact'])){
	$data=$_POST['contact_data'];
	$address=getaddress($_POST['lat'],$_POST['lng']);
	foreach ($_POST['contact_type'] as $type => $value){
		$add_kontak=mysql_query("insert into customer_contact(contact_id,contact_name,contact_type,contact_data,sales,sm) value ('$_GET[detail]','$_POST[contact_name]','$value','$data[$type]','$_SESSION[userid]','$_SESSION[sm]')");
	}
 			if($add_kontak){
 			mysql_query("insert into history (id,history_action,keterangan,date,time,lokasi,lat,lng,userid) value ('$_GET[detail]','Add Contact','Add contact $_POST[contact_name]','$date','$time','$address','$_POST[lat]','$_POST[lng]','$_SESSION[userid]')");
 			$_SESSION['sukses']="Success add contact";
 			header("location:?hal=detail-leads&detail=$_GET[detail]");
 		}
 		else{
 			$_SESSION['error']="Something wrong";
 			header("location:?hal=detail-leads&detail=$_GET[detail]");

 		}
}
if(isset($_POST['history_action'])){
     if(isset($_POST['lat'])){
                $address=getaddress($_POST['lat'],$_POST['lng']);
            }
        if(isset($_POST['meeting'])){
        $action=mysql_query("insert into history(id,history_action,keterangan,lokasi,date,time,userid,lat,lng) values ('$_POST[id]','$_POST[meeting]','$_POST[hasil_meeting]<br/>posted by $_SESSION[nama]','$address','$date','$time','$_SESSION[userid]','$_POST[lat]','$_POST[lng]')");
            if($action){
                $_SESSION['sukses']="sukses";
            }
            else{
                $_SESSION['error']="cannot update history";
            }
        }
        else{
        	 if($device=="Desktop"){
    			$date=$_POST['date'];
    			$time=$_POST['time'];
   			 }
        $aksi=mysql_query("insert into history(id,history_action,keterangan,lokasi,date,time,userid,lat,lng) values ('$_POST[id]','$_POST[history_action]','$_POST[deskripsi]<br/>posted by $_SESSION[nama]','$address','$date','$time','$_SESSION[userid]','$_POST[lat]','$_POST[lng]')");
        if($aksi){
            $_SESSION['sukses']="sukses";
        }
        else{
            $_SESSION['error']="cannot update histories<br/>insert into history(id,history_action,keterangan,lokasi,date,time,userid,lat,lng) values ('$_POST[id]','$_POST[history_action]','$_POST[deskripsi]<br/>posted by $_SESSION[nama]','$address','$date','$time','$_SESSION[userid]','$_POST[lat]','$_POST[lng]')";
        }
    }
}
?>
<?php if(isset($_GET['detail'])){
	$id=mysql_escape_string($_GET['detail']);
	if($_SESSION['level']=="2"){
		$kueri=mysql_query("select * from leads where sales='$_SESSION[userid]' and id='$id'");
	}
	if($_SESSION['level']=="1"){
		$kueri=mysql_query("select * from leads where sm='$_SESSION[userid]' and id='$id'");
	}
	if($_SESSION['level']=="0"){
		$kueri=mysql_query("select * from leads where id='$id'");
	}
	$jumlahkueri=mysql_num_rows($kueri);
	$address=mysql_fetch_assoc(mysql_query("select * from customer_address where id='$id'"));
	$addrlat=number_format($address['lat'],2);
	$addrlng=number_format($address['lng'],2);
	$nowlat=number_format($_SESSION['lat'],2);
	$nowlng=number_format($_SESSION['lng'],2);
	?>
	<?php if($jumlahkueri=="0"){
		$_SESSION['error']="forbidden";
		header('location:?hal=leads');
	}
else{
	 $pecah=mysql_fetch_array($kueri);?>
	<section role="main" class="content-body">
          <header class="page-header">
          <?php $hal="Detail Leads"?>

          <title><?php echo"Detail Leads - $pecah[nama]";?></title>
            <h2><?php echo"$hal";?></h2>
          
            <div class="right-wrapper pull-right">
              <ol class="breadcrumbs">
                <li>
                  <a href="index.php">
                    <i class="fa fa-home"></i>
                  </a>
                </li>
                <li><span><?php echo"Leads";?></span></li>
                <li><span><?php echo"$hal";?></span></li>
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
			<section class="panel panel-group">
				<header class="panel-heading bg-primary">
						<div class="widget-profile-info">
							<div class="profile-picture">
								<img src="assets/images/!logged-user.jpg">
							</div>
							<div class="profile-info">
		<h4 class="name text-semibold"><?php echo"$pecah[nama] $pecah[lname]";?></h4>
		<?php if($pecah['type']=="corporate"){
		echo"<h5 class='role'>$pecah[type]</h5>";
		}?>
		<div class="profile-footer">
			<?php $salesid=$pecah['sales'];
				  $namasales=mysql_fetch_array(mysql_query("select * from user where userid='$salesid'")); ?>
			<p class="pull-left">(<?php echo "$namasales[nama]" ; ?>)</p> <a style="color:white" href="?hal=edit-leads&edit=<?php echo"$pecah[id]";?>">Edit Leads <i class="fa fa-edit"></i></a>
		</div>
	</div>
</div>
						
											</header>
											<div id="accordion">
<div class="panel panel-accordion panel-accordion-first">
	<div class="panel-heading">
		<h4 class="panel-title">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#basicinfo">
				<i class="fa fa-user"></i> Basic Info
			</a>
		</h4>
	</div>
	<div id="basicinfo" class="accordion-body collapse in">
		<div class="panel-body">
			<div class="widget-todo-list">
				<div class="table-responsive">
					<table class="table mb-none">
						<tbody>
							<tr>
								<td>Name</td>
								<td><?php echo"$pecah[nama] $pecah[lname]";?></td>
							</tr>
							<tr>
								<td>Type</td>
								<td><?php echo"$pecah[type]";?></td>
							</tr>
							<tr>
								<td>Phone</td>
								<td><?php if($pecah['phone']=="0"){echo"not available";}else{echo"$pecah[phone]";}?></td>
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
								<td>Lead Status</td>
								<td>working</td>
							</tr>
							<tr>
								<td>Lead Source</td>
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
			<!--	<form>-->
			<form method="post">
					<div class="toggle" data-plugin-toggle>
						<section class="toggle active">
							<label>Update Progress</label>
							<div class="toggle-content panel-body">
						<input name="id" type="hidden" value="<?php echo"$pecah[id]";?>">
							<div class="form-group">
								<label class="control-label">Action</label>
							</div>
							<div class="form-group">
								<select name="history_action" id="action" class="form-control">
										<option value="Call" selected>Call</option>
										<?php
										$cekmeeting=mysql_num_rows(mysql_query("select * from history where id='$pecah[id]' and history_action='Start Meeting'"));
                                        $endmeeting=mysql_num_rows(mysql_query("select * from history where id='$pecah[id]' and history_action='Stop Meeting'"));
                                        if($cekmeeting == "$endmeeting"){
                                        	echo'<option>Meeting</option>';
                                        }
                                        elseif($endmeeting != "$cekmeeting"){
                                            echo'<option>Meeting</option>';
                                        }?>
										<option value="Follow Up">Follow Up</option>
										<?php //<option value="Canvasing">Canvasing</option>//?>
									</select>
							</div>
							<!-- hide -->
							<div style="display: none;" class="meeting">
								<div id="start">
									<div class="form-group">
								  <?php
								 if($cekmeeting == "$endmeeting"){
								 	if($addrlat==$nowlat){
                                    echo'<input type="hidden" name="hasil_meeting"></input><button name="meeting" class="btn btn-primary col-md-12" value="Start Meeting">Start</button>
                                    <div id=meeting><div id=lokasi></div></div>
                                    ';
                                	}
                                	else{
                                		echo"<strong>cannot start meeting,coordinat not same with customer address</strong>";
                                	}
                                }
                                elseif($endmeeting != "$cekmeeting"){
                                	
                                    echo'<textarea name="hasil_meeting" placeholder="Result" class="form-control"></textarea></div><div class="form-group">
                                    <div id=meeting><div id=lokasi></div></div>';
                                    /**if($device=="Desktop"){
							echo'<div class="form-group">
								<div class="col-md-6">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<input name="date" type="text"id="datepicker" class="form-control">
									</div>
								</div>
								<div class="col-md-6">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-clock-o"></i>
										</span>
										<input name="time" type="text" id="timepicker" class="form-control">

									</div>
								</div>
							</div><br/>';}**/
                                    echo'<button name="meeting" class="btn btn-primary col-md-12" value="Stop Meeting">Stop</button>';
                                }?>
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
							<?php if($device=="Desktop"){
							echo'<div class="form-group">
								<div class="col-md-6">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</span>
										<input name="date" type="text" id="datepicker" class="form-control" value="'.$date.'">
									</div>
								</div>
								<div class="col-md-6">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-clock-o"></i>
										</span>
										<input name="time" type="text" id="timepicker" class="form-control">

									</div>
								</div>
							</div>';}?>
							<div class="form-group">
							<button type="submit" class="btn btn-primary">Save Progress</button>
							</div>
							</div>
							<div style="display: none;" class="canvasing">
								<div class="form-group">
									<a href="#shot" class="modal-basic btn btn-primary col-sm-12">Take Photo</a>
								</div>
								<div class="form-group">
									<label class="control-label">Result</label>
								</div>
								<div class="form-group">
									<textarea class="form-control"></textarea>
								</div>
								<div class="form-group">
									<button class="pull-right btn btn-primary" type="submit">Save</button>
								</div>
							</div>
							<!-- end hide -->

						</div>
					</section>
					</div>
				</form>
			</div>

			<!-- modal -->
			<div id="shot" class="modal-block modal-full-color modal-block-primary mfp-hide">
				<section class="panel">
					<div class="panel-body">
					Preview Photo Here
					</div>
					<footer class="panel-footer">
						<div class="row">
							<div class="col-md-12 text-right">
								<button class="btn btn-default modal-dismiss">Cancel</button>
								<button class="btn btn-success"><i class="fa fa-camera"></i> Take</button>
							</div>
						</div>
					</footer>
				</section>
			</div>
					<div class="col-md-6">
						<div class="toggle" data-plugin-toggle>
							<section class="toggle">
							<label>Progress History</label>
								<div class="toggle-content panel-body">
									<div class="timeline timeline-simple mt-xlg mb-md" >
											<div class="tm-body" >
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
	</li>';}}}?>
</ol>
											</div>
										</div>
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
														}?>
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
							</section>
							</div>
						</div>
						<?php }?>
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
						function showLocation(position) {
  var latitude = position.coords.latitude;
  var longitude = position.coords.longitude;
  document.getElementById("meeting").innerHTML = "<input name=lat value="+ latitude +" type=hidden><input name=lng value="+ longitude +" type=hidden>";
}

function errorHandler(err) {
  if(err.code == 1) {
    alert("Error: Access is denied!");
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
			<script type="text/javascript">
            $(function () {
                $('#timepicker').timepicker({showMeridian: false});
                $('#datepicker').datepicker({format: "yyyy/mm/dd"});
            });
             
        </script>
			<script type="text/javascript">
			function funcMeeting() {
    document.getElementById("start").innerHTML = "<div class='form-group'><button class='btn btn-primary col-md-5' disabled>Start</button><button onclick='funcMeeting2()' class='pull-right btn btn-primary col-md-5'>Stop</button></div>";
								}
			function funcMeeting2() {
				document.getElementById('start').innerHTML = "<div class='form-group'><button class='btn btn-primary col-md-5' disabled>Start</button><button class='pull-right btn btn-primary col-md-5' disabled>Stop</button></div><div class='form-group'><textarea placeholder='Result' class='form-control'></textarea></div><div class='form-group'><button class='btn btn-primary' type='submit'>Save</button></div>"
			}					
</script>
<script type="text/javascript">
				$(document).ready(function() {

			    $('.meeting').hide();

			    $('#action').change(function () {
			        if ($('#action option:selected').text() == "Meeting"){
			            $('.meeting').show();
			            $('.notmeeting').hide();
			            $('.canvasing').hide();
			        }
			        
			        else {
			            $('.meeting').hide();
			            $('.notmeeting').show();
			            $('.canvasing').hide();
			        }
			    }); 
            });
</script>
