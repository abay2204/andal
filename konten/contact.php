<?php
if(isset($_POST['add_contact'])){
	$data=$_POST['contact_data'];
	$address=getaddress($_POST['lat'],$_POST['lng']);
	foreach ($_POST['contact_type'] as $type => $value){
		$kueri=mysql_query("insert into customer_contact(contact_id,contact_name,contact_type,contact_data,sales,sm) value ('$_POST[contact_id]','$_POST[contact_name]','$value','$data[$type]','$_SESSION[userid]','$_SESSION[sm]')");
	}
	if($kueri){
		$_SESSION['sukses']="success";
		mysql_query("insert into history (id,history_action,keterangan,date,time,lokasi,lat,lng,userid) value ('$_POST[contact_id]','Add Contact','Add contact $_POST[contact_name] <br/>by $_SESSION[nama]','$date','$time','$address','$_POST[lat]','$_POST[lng]','$_SESSION[userid]')");
	}
	else{
		$_SESSION['error']="error";
	}
}
if(isset($_POST['delete_contact'])){
	$kontak=$_POST['kontak'];
	$address=getaddress($_POST['lat'],$_POST['lng']);
	$kueri=mysql_query("delete from customer_contact where contact_name='$kontak'");
	if($kueri){
		$_SESSION['sukses']="success";
		mysql_query("insert into history (id,history_action,keterangan,date,time,lokasi,lat,lng,userid) value ('$_POST[kontakid]','Delete Contact','Delete contact $_POST[kontak] <br/>by $_SESSION[nama]','$date','$time','$address','$_POST[lat]','$_POST[lng]','$_SESSION[userid]')");
	}
	else{
		$_SESSION['error']="error";
	}
}
if(isset($_POST['edit_contact'])){
	$idkontak=$_POST['kontak_id'];
	$kontakbaru=$_POST['kontak_baru'];
	$namabaru=mysql_escape_string($_POST['contact_name']);
	$address=getaddress($_POST['lat'],$_POST['lng']);
	$namakontaks=mysql_fetch_array(mysql_query("select * from customer_contact where contact_id='$_POST[id_nya]'"));
	echo"$namakontaks[contact_name]";
	if($namakontaks['contact_name']!="$namabaru"){
		mysql_query("update customer_contact set contact_name='$namabaru' where contact_id='$_POST[id_nya]'");
	}
	foreach ($_POST['kontak_id'] as $type => $value){
		$kueri=mysql_query("update customer_contact set contact_data='$kontakbaru[$type]' where id='$value'");
	}
	if($kueri){
		$_SESSION['sukses']="success";
		mysql_query("insert into history (id,history_action,keterangan,date,time,lokasi,lat,lng,userid) value ('$_POST[id_nya]','Edit Contact','Edit contact $_POST[contact_name] <br/>by $_SESSION[nama]','$date','$time','$address','$_POST[lat]','$_POST[lng]','$_SESSION[userid]')");
	}
	else{
		$_SESSION['error']="error";
	}
}
	
?>
<section role="main" class="content-body">
          <header class="page-header">
          <?php $keyakses="Contact";?>
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
<?php 
if($_SESSION['level']=="0"){
		$kueris=mysql_query("select * from customer_contact group by contact_id,contact_name");
	}
elseif($_SESSION['level']=="1"){
		$kueris=mysql_query("select * from customer_contact where sm='$_SESSION[userid]' group by contact_name,contact_id");
 	}
elseif($_SESSION['level']=="2"){
		$kueris=mysql_query("select * from customer_contact where sales='$_SESSION[userid]' group by contact_name,contact_id");
		echo'<div style="padding-left:15px;"><a class="col-md-2 mb-xs mt-xs mr-xs modal-basic btn btn-default" href="#AddContact"><i class="fa fa-edit"></i> Add</a></div>';
	}	?>

			<div class="col-lg-12">
            	<input type="search" class="col-md-9 form-control" id="input-search" placeholder="Cari berdasarkan nama sales, nama institusi, nama customer, dsb ...." >
 			</div>
		</div>	
<script type="text/javascript">
        $(function() {

        $('#input-search').on('keyup', function() {

          var rex = new RegExp($(this).val(), 'i');

            $('.searchable-container .items').hide();

            $('.searchable-container .items').filter(function() {

                return rex.test($(this).text());

            }).show();

        });

    });
</script>
<?php
 	echo '<div class="searchable-container">';
$i="0";
while($pecahkontak=mysql_fetch_assoc($kueris)){
$phones=mysql_fetch_array(mysql_query("select * from customer_contact where contact_type='Mobile Phone' and contact_name='$pecahkontak[contact_name]' and contact_id='$pecahkontak[contact_id]'"));
				$email=mysql_fetch_array(mysql_query("select * from customer_contact where contact_type='email' and contact_name='$pecahkontak[contact_name]' and contact_id='$pecahkontak[contact_id]'"));
				$work=mysql_fetch_array(mysql_query("select * from customer_contact where contact_type='Office Phone' and contact_name='$pecahkontak[contact_name]' and contact_id='$pecahkontak[contact_id]'"));

						echo' <div class="items col-md-6"><section class="panel panel-featured-left panel-featured-primary">
						<div class="panel-body">
					<div class="widget-summary">';
					$leadss=mysql_num_rows(mysql_query("select * from leads where id='$pecahkontak[contact_id]'"));
					$acountss=mysql_num_rows(mysql_query("select * from account where id='$pecahkontak[contact_id]'"));
					if($leadss>"0"){
						echo'<a style="color: white;" href="?hal=detail-leads&detail='.$pecahkontak['contact_id'].'">';
					}
					else{
						echo'<a style="color: white;" href="?hal=detail-account&detail='.$pecahkontak['contact_id'].'">';
					}
							echo'<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-primary">
									<i class="fa2 fa-user"></i>
								</div>
							</div>
							</a>
							<div class="widget-summary-col">
								<div class="summary">
									<h4 class="title"><a class="modal-basic" href="#DetailContact'.$i.'">'.$pecahkontak['contact_name'].' </a><a class="modal-basic" href="#EditContact'.$i.'" title="Edit Contact"><i class="fa fa-external-link pull-right"></i></a><a class="modal-basic" href="#deletecontact'.$i.'" title="Edit Contact"><i class="fa fa-trash-o pull-right"></i></a></h4>
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
						</div></div></section> </div>
';
//delete contact start here//
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
						<div class="form-group">
							<div class="col-md-1"></div>
								<div class="col-md-10">
									<div class="input-group input-group-icon">
										<span class="input-group-addon">
											<span class="icon"><i class="fa fa-user"></i></span>
										</span>
										<input type="text" name="contact_name" class="form-control" value="'.$pecahkontak['contact_name'].'">
 									</div>
								</div>
							</div>
						<input type="hidden" name="id_nya" value="'.$pecahkontak['contact_id'].'">';
						$phone=mysql_query("select * from customer_contact where  contact_type='Mobile Phone' and contact_name='$pecahkontak[contact_name]' and contact_id='$pecahkontak[contact_id]'");
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
						$office=mysql_query("select * from customer_contact where  contact_type='Office Phone' and contact_name='$pecahkontak[contact_name]' and contact_id='$pecahkontak[contact_id]'");
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
						$emails=mysql_query("select * from customer_contact where  contact_type='email' and contact_name='$pecahkontak[contact_name]' and contact_id='$pecahkontak[contact_id]'");
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
						$web=mysql_query("select * from customer_contact where contact_type='Website' and contact_name='$pecahkontak[contact_name]' and contact_id='$pecahkontak[contact_id]'");
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
//detail contact start here//
			echo'<div id="DetailContact'.$i.'" class="zoom-anim-dialog modal-block modal-header-color modal-block-primary mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Detail Contact <a class="pull-right btn btn-primary modal-dismiss"><i style="color: white;" class="fa fa-times"></i></a></h2>
				</header>
				<div class="panel-body">
				<form id="form" action="#" class="form-horizontal">
					<div class="tab-content">
						<div class="tab-pane active">';
						$phone=mysql_query("select * from customer_contact where  contact_type='Mobile Phone' and contact_name='$pecahkontak[contact_name]' and contact_id='$pecahkontak[contact_id]'");
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
						$office=mysql_query("select * from customer_contact where  contact_type='Office Phone' and contact_name='$pecahkontak[contact_name]' and contact_id='$pecahkontak[contact_id]'");
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
						$emails=mysql_query("select * from customer_contact where  contact_type='email' and contact_name='$pecahkontak[contact_name]' and contact_id='$pecahkontak[contact_id]'");
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
						$web=mysql_query("select * from customer_contact where  contact_type='Website' and contact_name='$pecahkontak[contact_name]' and contact_id='$pecahkontak[contact_id]'");
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
$i++;
					}?>
        </div>
        <!-- start modal -->
        <div id="AddContact" class="zoom-anim-dialog modal-block modal-header-color modal-block-primary mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Add Contact <a class="pull-right btn btn-primary modal-dismiss"><i style="color: white;" class="fa fa-times"></i></a></h2>
				</header>
				<?php 
								$account=mysql_query("select * from account where sales='$_SESSION[userid]'");
								$leads=mysql_query("select * from leads where sales='$_SESSION[userid]'");
								$hitungleads=mysql_num_rows($leads);
								$hitungaccount=mysql_num_rows($account);
				if($hitungleads=="0" and $hitungaccount=="0"){
					echo'<div class="panel-body">
						you must have leads or account before';
				}
				else{
					echo'
				<div class="panel-body">
				<form id="form" method="post" class="form-horizontal">
					<div class="tab-content">
						<div id="phone" class="tab-pane active">
							<div class="form-group">
								<div class="col-sm-3">
									<label class="control-label">Contact Name </label>
								</div>
								<div class="col-sm-8">
									<input type="text" name="contact_name" placeholder="" class="form-control">
								</div>
							</div>	
							<div class="form-group">
								<div class="col-sm-3">
 								<label class="control-label">Account</label>
								</div>
								<div class="col-sm-8">
									<select name="contact_id" class="form-control" data-plugin-multiselect id="mode">';
										while($pecahcontact=mysql_fetch_array($account)){
										echo"<option value='$pecahcontact[id]'>$pecahcontact[nama] $pecahcontact[lname]</option>";
										while($pecahleads=mysql_fetch_array($leads)){
										echo"<option value='$pecahleads[id]'>$pecahleads[nama] $pecahleads[lname]</option>";
									}
									}
									echo'</select>
								</div>
							</div>	
							<div id="lokasi"></div>
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
				
				</form>';}?>
			</section>
		</div>
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

 $('.umpt').hide();

function tampil() {
    if($('.umpt').is(':hidden')){
    	$('.umpt').show();
    }
    else{
    	$('.umpt').hide();
    }
}
</script>