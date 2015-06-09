<?php
include ('../sistem/konfigs.php');
include ('../sistem/function.php');
session_start();
if(isset($_POST['addleads'])){
$address=getaddress($_POST['lat'],$_POST['lng']);
$today=date('Y/m/d');
$time=date('H:i:s');
$todayleads=mysql_num_rows(mysql_query("select * from leads where open='$today'"));
$todayid=date('dm');
$idnow=$todayleads+1;
$front=substr($_POST['fname'], 0, 1);
$back=substr($_POST['lname'], 0, 1);
$id="$front$back$todayid$idnow";
$sm=mysql_fetch_array(mysql_query("select * from user where userid='$_SESSION[userid]'"));
if(!empty($_POST['sources'])){
	mysql_query("insert into leads (id,source,open,nama,lname,sales,sm,type,progress) values ('$id','$_POST[sources]','$today','$_POST[fname]','$_POST[lname]','$_SESSION[userid]','$sm[sm]','personal','10')");}
	else{
	mysql_query("insert into leads (id,source,open,nama,lname,sales,sm,type,progress) values ('$id','$_POST[source]','$today','$_POST[fname]','$_POST[lname]','$_SESSION[userid]','$sm[sm]','personal','10')");}
mysql_query("insert into history(id,userid,history_action,lokasi,lat,lng,date,time) values ('$id','$_SESSION[userid]','Leads Created','$address','$_POST[lat]','$_POST[lng]','$today','$time')"); 
header('location:../?hal=leads');
}
?>	