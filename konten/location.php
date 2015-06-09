<?php
include('../sistem/function.php');
session_start();
include('../sistem/konfigs.php');
if(isset($_POST['lat'])){
  $id=mysql_escape_string($_GET['id']);
  $address=getaddress($_POST['lat'],$_POST['lng']);
  $pecah=explode(',', $address);
  $address1=$pecah['0'];
  $address2=$pecah['1'];
  $city=$pecah['2'];
  $cityzip=$pecah['3'];
  $lastSpacePosition = strrpos($cityzip, ' ');
  $state = substr($cityzip, 0, $lastSpacePosition);
  $last_word_start = strrpos ( $cityzip , " ") + 1;
  $last_word_end = strlen($cityzip) - 1;
  $zip = substr($cityzip, $last_word_start, $last_word_end);
  $exist=mysql_num_rows(mysql_query("select * from customer_address where id='$id'"));
  if($exist=="0"){
  mysql_query("insert into customer_address (id,lat,lng,address1,address2,city,postalcode,state,country) value ('$id','$_POST[lat]','$_POST[lng]','$address1','$address2','$city','$zip','$state','Indonesia')");
  }
  else{
    mysql_query("update customer_address set lat='$_POST[lat]',lng='$_POST[lng]',address1='$address1',address2='$address2',city='$city',postalcode='$zip',state='$state' where id='$_GET[id]'");
  }
  /**echo "<script>alert('jalan : $street1 $street2');</script>";
  echo "<script>alert('state : $state');</script>";
  echo "<script>alert('city : $city');</script>";
  echo "<script>alert('zip : $zip');</script>";**/
  echo "<script>window.close();</script>";
}
if(isset($_GET['id'])){
  if(isset($_GET['lat'])){
    if($_GET['lat']=="0"){
      $lat="$_SESSION[lat]";
      $nowlat=number_format($lat,2);
      $lng="$_SESSION[lng]";
    }
    else{
    $lat=$_GET['lat'];
    $pecahin=number_format($lat,2);
    $lng=$_GET['lng'];}}
  else{
    $lat="$_SESSION[lat]";
    $pecahin=number_format($lat,2);
    $lng="$_SESSION[lng]";}?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<script type="text/javascript" src="../assets/vendor/gmaps-picker/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="../assets/vendor/gmaps-picker/js/jquery-gmaps-latlon-picker.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&language=in-IN&hl=id"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<form method="post">
<div class="row">
<title>Set location</title>
	<div class="col-xl-12 col-md-12 col-sm-12">
	<fieldset class="gllpLatlonPicker">
	<input type="text" class="gllpSearchField">
	<input type="button" class="gllpSearchButton" value="search">
	<br/>
	<div class="gllpMap">Google Maps</div>
	<input type="hidden" class="gllpLocationName" size="55" name="lokasi" /><input type="hidden" class="gllpLatitude" value="<?php echo "$lat";?>" name="lat" /> <input type="hidden" class="gllpLongitude" value="<?php echo "$lng";?>" name="lng" /><input type="text" class="gllpZoom" value="10" /> <a data-toggle="modal" data-target="#myModal" class="btn btn-primary gllpUpdateButton" href="#">Save Location</a>
	</fieldset> 
	</div>
</div>
<div id="map-canvas"></div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">konfirmasi</h4>
      </div>
      <div class="modal-body">
      <p class="alamat">Pick some location first</p>
      <p class="koordinat">drag the marker or double click the location.</p>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
</form>
<style>

.gllpLatlonPicker	{ margin: 0px; }
.gllpMap	{ position: absolute;
     top: 0;
     left: 0;
     width: 100% !important;
     height: 700px !important;}
body{
	min-height: 100%;
    height: 100% !important;
	width: 100% !important;
	margin-top: -20px;
	overflow: hidden;
}
input.gllpSearchField {
	z-index: 2;
    position: fixed;
    top: 10px;
    right: 25px;
    margin-right: 40px;
}
input.gllpSearchButton {
	z-index: 2;
    position: fixed;
    top: 10px;
    right: 5px;
}
input.gllpLocationName {
	z-index: 2;
    position: fixed;
    bottom: 10px;
    left: 5px;
    width: 20%;
}
input.gllpLatitude {
	z-index: 2;
    position: fixed;
    margin-left: 20%;
    bottom: 10px;
    left: 5px;
    width: 15%;
}
input.gllpLongitude {
	z-index: 2;
    position: fixed;
    margin-left: 35%;
    bottom: 10px;
    left: 5px;
    width: 15%;
}

a.gllpUpdateButton {
	z-index: 2;
    position: fixed;
    bottom: 10px;
    right: 5px;
    width: 20%;
}
</style>
<?php } ?>
<script>
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
</script>