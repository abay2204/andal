	<section role="main" class="content-body">
			
          <header class="page-header">
          <?php $hal="Update Account"?>
            <h2><?php echo"$hal";?></h2>
          <title><?php echo"$hal | CRM Nusanet";?></title>
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
<div class="col-md-7">

<?php
		if(isset($_GET['update'])){
			if($_SESSION['level']=="0"){
				$cek=mysql_num_rows(mysql_query("select * from account"));
			}
			elseif($_SESSION['level']=="1"){
				$cek=mysql_num_rows(mysql_query("select * from account where id='$_GET[update]' and sm='$_SESSION[userid]'"));
			}
			elseif($_SESSION['level']=="2"){
				$cek=mysql_num_rows(mysql_query("select * from account where id='$_GET[update]' and sales='$_SESSION[userid]'"));
			}
		if($cek == "0"){
			$_SESSION['error']="Forbidden";
			header('location:?hal=account');
		}			
			$idakun=mysql_escape_string($_GET['update']);
			$kueri=mysql_query("select * from account where id='$idakun'");
			$pecahkueri=mysql_fetch_array($kueri);
				echo'	
				<form method="post">
					<section class="panel panel-primary">
						<header class="panel-heading">
							<div class="panel-actions">
								<a href="#" class="fa fa-caret-down"></a>
								<a href="#" class="fa fa-times"></a>
							</div>
							<h2 class="panel-title">Update Progress</h2>
						</header>
						<div class="panel-body">
						<input name="id" type="hidden" value="'.$pecahkueri['id'].'">
							<div class="form-group">
								<label class="control-label">Action</label>
							</div>
							<div class="form-group">
								<select name="history_action" id="action" class="form-control">
										<option value="Call" selected>Call</option>';
										
										$cekmeeting=mysql_num_rows(mysql_query("select * from history where id='$pecahkueri[id]' and history_action='Start Meeting'"));
                                        $endmeeting=mysql_num_rows(mysql_query("select * from history where id='$pecahkueri[id]' and history_action='Stop Meeting'"));
                                        if($cekmeeting == "$endmeeting"){
                                            echo'<option value="start_meeting">Meeting</option>';
                                        }
                                        elseif($endmeeting != "$cekmeeting"){
                                            echo'<option value="stop_meeting">Meeting</option>';
                                        }
									echo'<option value="Follow Up">Follow Up</option>
										<option value="Canvasing">Canvasing</option>
									</select>
							</div>
							
							<div style="display: none;" class="meeting">
								<div id="start">
									<div class="form-group">';
							
								 if($cekmeeting == "$endmeeting"){
                                    echo'<button name="meeting" class="btn btn-primary col-md-12" value="Start Meeting">Start</button>
                                    <div id=meeting><div id=lokasi></div></div>
                                    ';
                                }
                                elseif($endmeeting != "$cekmeeting"){
                                    echo'<textarea name="hasil_meeting" placeholder="Result" class="form-control" required></textarea></div><div class="form-group">
                                    <div id=meeting><div id=lokasi></div></div>
                                    <button name="meeting" class="btn btn-primary col-md-12" value="Stop Meeting">Stop</button>';
                                }
								echo'</div>
								</div>
							</div>
							<div class="notmeeting">
							<div class="form-group">
								<label class="control-label">Description</label>
							</div>
							<div class="form-group">
									<textarea name="deskripsi" class="col-sm-12"></textarea>
							</div>
							<div class="form-group">
							<button type="submit" class="btn btn-primary">Save Progress</button>
							</div>
							</div>
						</div>
					</section>
				</form>
';}?>
			</div>
			
<script>
 $("#add").click(function (e) {
  //Append a new row of code to the "#items" div
    $("#items").append('<div class="form-group"><div class="col-sm-3"><select class="form-control" data-plugin-multiselect id="mode"><option value="Mobile Phone">Mobile Phone</option><option value="Office Phone">Office Phone</option><option value="Website">Website</option><option value="Facebook">Facebook</option><option value="Twitter">Twitter</option><option value="Linkedin">Linkedin</option></select></div><div class="col-sm-7"><input type="text" name="" placeholder="" class="form-control"></div><a class="btn btn-default" onclick="$(this).parent().slideUp(function(){ $(this).remove() }); return false"><i class="fa fa-minus"></i></a></div>');
  });
$(document).live("click", "remove", function() {
    $(this).parent().remove();
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