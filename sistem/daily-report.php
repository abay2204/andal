<?php
include('konfigs.php');
$leader=mysql_query("select * from admin where level='1'");
while ($pecahleader=mysql_fetch_array($leader)) {
	$message="Tim $pecahleader[nama]<br/>
	<table border='1'>";
	$under=mysql_query("select * from user where sm='$pecahleader[userid]'");
	while ($pecahunder=mysql_fetch_array($under)){
		$message.="<tr><td>$pecahunder[nama]</td><td>";
		$date="2015/05/11";
		$aktifitas=mysql_query("select * from history where userid='$pecahunder[userid]' and history_action='Canvasing' and date='$date'");
		$hitungact=mysql_num_rows($aktifitas);
		if($hitungact>0){
		while($pecahaktifitas=mysql_fetch_array($aktifitas)){
			$company=mysql_query("select *,company_name as nama from customer_company where id='$pecahaktifitas[id]'");
			$hitungcompany=mysql_num_rows($company);
			if($hitungcompany>'0'){
				$nama=mysql_fetch_array($company);
			}
			else{
				$lead=mysql_query("select * from leads where id='$pecahaktifitas[id]'");
				$hitungleads=mysql_num_rows($lead);
				if($hitungleads=='0'){
					$nama=mysql_fetch_array(mysql_query("select * from account where id='$pecahaktifitas[id]'"));
				}
				else{
					$nama=mysql_fetch_array(mysql_query("select * from account where id='$pecahaktifitas[id]'"));
 				}
			}
			$message.="$nama[nama]";
			if(isset($nama['lname'])){
				$message.=" $nama[lname]";
			}
			$message.="<br/>";
		}
	}
	else{
		$message.="Tidak ada aktifitas";
	}
		$message.="</td></tr>";
	}
	$message.="</table>";
	$under=mysql_query("select * from user where sm='$pecahleader[userid]'");
	while($kirimemail=mysql_fetch_array($under)){
		echo"sukses kirim email ke $kirimemail[nama] ";
			echo"$message";
	}
}?>