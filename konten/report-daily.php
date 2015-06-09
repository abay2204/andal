<section role="main" class="content-body">
          <header class="page-header">
          <?php $keyakses="Sales Activity";?>
            <h2><?php echo"$keyakses";?></h2>
          
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
<?php
if($_SESSION['level']=="0"){
  $sm=mysql_query("select * from admin where level='1'");
}
elseif($_SESSION['level']=="1"){
  $sm=mysql_query("select * from admin where userid='$_SESSION[userid]'");
}
$i="0";
while($pecahsm=mysql_fetch_array($sm)){
  $sales=mysql_query("select * from user where sm='$pecahsm[userid]'");
         echo' <div class="col-md-12 col-xl-12 col-md-offset-">
            <div class="toggle" data-plugin-toggle>
              <section class="toggle">
              <label>'.$pecahsm['nama'].'</label>
                <div class="toggle-content panel-body">
                  <div class="col-md-12"><div class="panel-group" id="accordion">
                
                 ';
  while($pecahsales=mysql_fetch_array($sales)){
    $date="2015/05/11";
    $activity=mysql_query("select * from history where userid='$pecahsales[userid]' and date='$date'");
    $hitungactivity=mysql_num_rows($activity);
          echo' <div class="panel panel-accordion">
                <div class="panel-heading">
                    <h4 class="panel-title">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#'.$i.'">
                       '.$pecahsales['nama'].''.$hitungactivity.'
                      </a>
                    </h4>
                  <div id="'.$i.'" class="accordion-body collapse">';
if($hitungactivity>0){
  while($pecahactivity=mysql_fetch_array($activity)){
    $leads=mysql_fetch_array(mysql_query("select * from leads where id='$pecahactivity[id]'"));
    if($hitungactivity=="0"){
      $aktifitas="User not active";
      echo'
                    <div class="panel-body" data-toggle="tooltip" title="'.$pecahactivity['lokasi'].'" data-placement="top"">
                      <b>'.$pecahactivity['date'].' '.$pecahactivity['time'].'<br/></b>
                      '.$pecahactivity['history_action'].' '.$leads['nama'].'<br/>
                      '.$aktifitas.'
        </div>';
    }
    else{
      $aktifitas=$pecahactivity['keterangan'];
    }
          echo'
                    <div class="panel-body" data-toggle="tooltip" title="'.$pecahactivity['lokasi'].'" data-placement="top"">
                      <b>'.$pecahactivity['date'].' '.$pecahactivity['time'].'<br/></b>
                      '.$pecahactivity['history_action'].' '.$leads['nama'].'<br/>
                      '.$aktifitas.'
        </div>
                 ';
  }}
else{
  echo "ga ngapa-ngapain";
}
  echo"</div>";
  $i++;
  echo'</div></div>';
}
                echo'
            </div>
                </div>
              </section>
              </div>
            </div>';
              
          }
           
if($_SESSION[$keyakses]!=md5($keyakses)){
  header('location:login.php');
}
?>
                              </div>
                            </div>
                            <div class="summary-footer">
                              <a class="text-uppercase" data-open="sidebar-right">(view all)</a>

                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                  </div>
<div class="row">
<div class="col-xs-12">
<section class="panel">

    


      </div>
      </div><!-- .entry-content -->

          <!-- end page -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<link rel='stylesheet' id='style-css'  href='style.css' type='text/css' media='all' />
<script type='text/javascript' src='assets/jquery.js'></script>
<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/slidereveal.js"></script>
<script type='text/javascript' src='assets/jquery-migrate.js'></script>
<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
<script type='text/javascript' src='assets/gmaps.js'></script>
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<body style="background:#EEE">


    </article>
    <script src="assets/javascripts/ui-elements/examples.treeview.js"></script>
    <script src="assets/vendor/jstree/jstree.js"></script>
    <link rel="stylesheet" href="assets/vendor/jstree/themes/default/style.css" />
</body>
</html>