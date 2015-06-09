<?php
if(isset($_POST['collapse'])){
	if(isset($_SESSION['collapse'])){
		if($_SESSION['collapse']=="in"){
			$_SESSION['collapse']="out";
		}
		else{
			$_SESSION['collapse']="in";
		}
	} 
	else{
		$_SESSION['collapse']="out";
	}
}
	?>
	<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
						</div>
						<div id="onClick" class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
								<?php $menu=mysql_query("select * from modul order by id asc");
								while($menupecah=mysql_fetch_array($menu)){
					//filter hak akses menu
									if($_SESSION['level']=="1" or $_SESSION['level']=="0" or $_SESSION['level']=="1337"){
										$filter=mysql_query("select * from admin where email='$_SESSION[email]'");
										$pecahfilter=mysql_fetch_array($filter);
									}
									else{
										$filter=mysql_query("select * from user where email='$_SESSION[email]'");
										$pecahfilter=mysql_fetch_array($filter);
									}
									$cobacek=$pecahfilter['akses'];
						if (preg_match("/\b$menupecah[nama]\b/", $cobacek, $match)){
									if(isset($_GET['hal'])){
										$_SESSION[$menupecah['nama']]=md5($menupecah['nama']);
										if("?hal=$_GET[hal]"=="$menupecah[link]"){
										echo"<li class='nav-active'>";
										}
										else{
										echo"<li>";
										}
									}
									else{
										if("index.php"=="$menupecah[link]"){
											echo"<li class='nav-active'>";
										}
										else{
											echo"<li>";
										}
									}
									if($menupecah['parent'] == "None"){
										$cekparent=mysql_num_rows(mysql_query("select * from modul where parent='$menupecah[nama]'"));
										if($cekparent>"0"){
										echo'<li  class="nav-parent">
										<a href='.$menupecah['link'].'>
											<i class="fa '.$menupecah['icon'].'" aria-hidden="true"></i>
											<span>'.$menupecah['nama'].'</span>
										</a>
										<ul class="nav nav-children">';
										$parents=mysql_query("select * from modul where parent='$menupecah[nama]'");
											while($pecahparent=mysql_fetch_array($parents)){
												if (preg_match("/\b$pecahparent[nama]\b/", $cobacek, $match)){
											echo'<li>
												<a href='.$pecahparent['link'].'>
													'.$pecahparent['nama'].'
												</a>
											</li>';
											}
										}
										echo'</ul></li>';
										}
										else{echo'<a href='.$menupecah['link'].'>
											<i class="fa '.$menupecah['icon'].'" aria-hidden="true"></i>
											<span>'.$menupecah['nama'].'</span>
										</a>
									</li>';}
									}
								}else{$_SESSION[$menupecah['nama']]="denied";}}?>
								</ul>
							</nav>
						</div>
					</div>
				</aside>
				<!-- end: sidebar -->
 
			
<script>
$(document).ready(function(){
    $("#onClick").click(function(){
        $.post("",
        {
          collapse: "in",
        });
    });
});
</script>