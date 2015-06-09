<html>
<head>
	<title>maybe?</title>
    <style type="text/css">
body {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
}

a {
	color: white;
	text-decoration: none;
}

.alert {
	color: white;
    background: #349e92;
	border-bottom: 1px #1e1e1e solid;
}

.login {
    width: 340px;
    height: 340px;
    background: #1e1e1e;
    border-radius: 6px;
    margin: 50px auto;
}

.login .title {
    height: 40px;
    padding: 15px;
    text-align: center;
    font-weight: bold;
    background: #121212;
    border: #2d2d2d solid 1px;
    margin-bottom: 30px;
    border-top-right-radius: 6px;
    border-top-left-radius: 6px;
}

.login form {
    width: 240px;
    height: auto;
    overflow: hidden;
    margin-left: auto;
    margin-right: auto;
}

.login form input[type=text] {
    width: 240px;
	outline: 0;
    padding-top: 14px;
    padding-bottom: 14px;
    padding-left: 40px;
    border: none;
    color: #bfbfbf;
    background: #141414;
	margin-bottom: 5px;
    border-radius: 6px;
}

.login form input[type=submit] {
	margin-top: 20px;
    width: 240px;
    display: block;
    padding-top: 8px;
    padding-bottom: 8px;
    border-radius: 6px;
    border: none;
    background: #349e92;
    text-align: center;
    font-weight: bold;
	color: white;
}
    </style>
</head>
<body>

<?php
if(isset($_POST['kirim'])){
	$nomorhp=mysql_escape_string($_POST['nomorhp']);
	$nama=mysql_escape_string($_POST['nama']);
	mysql_query("insert into db (nama,nomorhp) values ('$nama','$nomorhp')");
	echo'<section class="login">
        <div class="title">
                <font color="white">Selamat</font>
        </div>
 <font color="white">Silakan tunggu 1x24 jam untuk hadiahnya :D</font>
        
</section>';
}
elseif(isset($_GET['password'])) {
	if (is_numeric($_GET['password'])){
		if (strlen($_GET['password']) < 4){
			if ($_GET['password'] > 999)
				echo'<section class="login">
        <div class="title">
                <font color="white">Sukses</font>
        </div>
 
        <form method="post">
        		<input type="text" name="nama" placeholder="nama"/>
                <input type="text" required name="nomorhp" placeholder="nomor hp" /><br/>
                <input name="kirim" type="submit"/>
        </form>
</section>';
			else
				print '<p class="alert">Terlalu pendek</p>';
		} else
				print '<p class="alert">Terlalu panjang</p>';
	} else
		print '<p class="alert">password bukan numerik</p>';
}
else{
	echo'<section class="login">
        <div class="title">
                <font color="white">Password:<br/>kurang dari 4 karakter dan lebih besar dari 999</font>
        </div>
 
        <form method="get">
                <input type="text" required name="password" placeholder="Password" /><br/>
                <input type="submit"/>
        </form>
</section>';
}
?>
 

</body>
</html>