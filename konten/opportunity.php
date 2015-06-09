<section role="main" class="content-body">
          <header class="page-header">
          <?php $keyakses="Oppurtunity";?>
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
<title><?php navbar($_GET['hal']);?> | CRM Nusanet</title>
<div class="row">
<div class="row">			
			
            	<?php
if($_SESSION['level']=="2"){
	$cekakun=mysql_query("select * from account where sales='$_SESSION[userid]'");
	$cekoppor=mysql_query("select * from customer_opportunity where sales='$_SESSION[userid]'");
	echo'<div style=padding-left:15px><a class="col-md-2 mb-xs mt-xs mr-xs modal-basic btn btn-default" href="#ModalAdd"><i class="fa fa-edit"></i> Add</a></div>';
}
if($_SESSION['level']=="1"){
	$cekakun=mysql_query("select * from account where sm='$_SESSION[userid]'");
	$cekoppor=mysql_query("select * from customer_opportunity where sm='$_SESSION[userid]'");
}
if($_SESSION['level']=="0"){
	$cekakun=mysql_query("select * from account");
	$cekoppor=mysql_query("select * from customer_opportunity");
}?>
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
        <div class="searchable-container">
        <?php while($pecahoppor=mysql_fetch_array($cekoppor)){
        	$namaaccount=mysql_fetch_array(mysql_query("select * from account where id='$pecahoppor[userid]'"));
            echo'<div class="items col-md-6">
        		<section class="panel panel-featured-left panel-featured-primary">
					<div class="panel-body">
						<div class="widget-summary">
							<div class="widget-summary-col widget-summary-col-icon">
								<div class="summary-icon bg-primary">
									<i class="fa2 fa-dollar"></i>
								</div>
							</div>
							<div class="widget-summary-col">
								<div class="summary">
									<h4 class="title"><a href="?hal=detail-account&detail='.$namaaccount['id'].'"><b>'.$namaaccount['nama'].''.$namaaccount['lname'].'</b> - '.$pecahoppor['package'].'</a></h4>
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
					</div>
				</section>
            </div>';
        }?>
        </div>
        <?php if(isset($_POST['add_oppor'])){
        	$userid=mysql_escape_string($_POST['account']);
        	$package=mysql_escape_string($_POST['package']);
        	$close=mysql_escape_string($_POST['prediction']);
 			mysql_query("insert into customer_opportunity (userid,package,stages,value,sm,sales,close_prediction) value ('$userid','$package','$_POST[stages]','$_POST[value]','$_SESSION[sm]','$_SESSION[userid]','$close')");
        }?>
        <!-- start modal -->
      	<?php
		$jumlahakun=mysql_num_rows($cekakun);?>  					

        <div id="ModalAdd" class="zoom-anim-dialog modal-block modal-header-color modal-block-primary mfp-hide">
			<section class="panel">
			<?php if($jumlahakun > "0"){
				echo'<header class="panel-heading">
					<h2 class="panel-title">Add Oppurtunity</h2>
				</header>
				<div class="panel-body">
				<form id="form" method="post" class="form-horizontal">
				<div class="form-group">
								<label class="col-sm-3 control-label">Stages </label>
								<div class="col-md-9">
									<select name="stages" class="form-control">
										<option>Show interest</option>
										<option>Waiting for response</option>
										<option>Qualified</option>
										<option>Initial engagement</option>
										<option>Advanced engagement</option>
									</select>
								</div>
							</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Account </label>
						<div class="col-sm-9">
						<select name="account" class="form-control" data-plugin-multiselect>';
							while($pecahakun=mysql_fetch_array($cekakun)){
							echo"<option value=$pecahakun[id]>$pecahakun[nama] $pecahakun[lname]</option>";
						}
						echo'</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Package</label>
						<div class="col-sm-9">
						<input name="package" type="text"class="form-control" required/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Value</label>
						<div class="col-sm-9">
						<div class="input-group mb-md">
						<span class="input-group-addon btn-default">Rp.</span>
										<input name="value" type="textbox" class="form-control currency" ></div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Close</label>
						<div class="col-sm-9">
						<input name="prediction" type="text" class="form-control" placeholder="'.$date.'" required/>
						</div>
					</div>

				</div><footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button name="add_oppor" type="submit" class="btn btn-primary">Submit</button>
							<button type="reset" class="btn btn-default modal-dismiss">Cancel</button>
						</div>
					</div>
				</footer>
				</form>';}
				else{
				echo'<footer class="panel-footer">
					<div class="row">
					<center><h2>for add opportunity you must have one account</h2></center>
						<div class="col-md-12 text-right">
							<button type="reset" class="btn btn-primary modal-dismiss">OK</button>
						</div>
					</div>
				</footer>';
				}?>

			</section>
		</div>
	</div>
	<!-- end modal -->
					<!-- end page -->
</div>	
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