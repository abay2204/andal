<?php
$date=date('Y/m/d');
$time=date('H:i:s');
$ip=$_SERVER['REMOTE_ADDR'];
$ua=$_SERVER['HTTP_USER_AGENT'];
session_start();
include('sistem/konfigs.php');
if(isset($_POST['login'])){
	$email=mysql_escape_string($_POST['email']);
	$password=mysql_escape_string($_POST['password']);
	$pass=md5($_POST['password']);
	$kueri=mysql_query("select * from user where email='$email'");
	$kueris=mysql_query("select * from admin where email='$email'");
	$pecah=mysql_fetch_array($kueri);
	$pecahs=mysql_fetch_array($kueris);
	if($pecahs['password']==$pass){
		$_SESSION['email']=$email;
		$_SESSION['userid']=$pecahs['userid'];
		$_SESSION['nama']=$pecahs['nama'];
		$_SESSION['level']=$pecahs['level'];
		$_SESSION['lat']="$_POST[lat]";
		$_SESSION['lng']="$_POST[lng]";
		mysql_query("insert into log_activity (userid,date,time,action,detail) values ('$_SESSION[userid]','$date','$time','Login','success login from $ip and using $ua')");
		header('location:main.php');
	}
	else{
		if($pecah['password'] == $pass){
			$_SESSION['email']=$email;
			$_SESSION['userid']=$pecah['userid'];
			$_SESSION['nama']=$pecah['nama'];
			$_SESSION['level']="2";
			$_SESSION['sm']=$pecah['sm'];
			$_SESSION['lat']="$_POST[lat]";
			$_SESSION['lng']="$_POST[lng]";
			mysql_query("insert into log_activity (userid,date,time,action,detail) values ('$_SESSION[userid]','$date','$time','Login','success login from $ip and using $ua')");
			header('location:main.php');
		}
		else{
			$_SESSION['pesan']="Username or password invalid";
			header('location:login.php');
		}
	}
}
header('location:login.php');
?>