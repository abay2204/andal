<?php
if(isset($_GET['hal'])){
	sidebar($_GET['hal']);
}
else{
	sidebar("home");
}
?>