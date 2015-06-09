<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<header class="page-header">
<?php $hal="Dashboard"?>
  <h2><?php echo"$hal";?></h2>

  <div class="right-wrapper pull-right">
    <ol class="breadcrumbs">
      <li>
        <a href="index.php"> 
          <i class="fa fa-home"></i>
        </a>
      </li>
      <li><span><?php echo"$hal";?></span></li>
    </ol>

    <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
  </div>
</header>
 <?php if(isset($_SESSION['sukses'])){
			echo'<section role="main" class="content-body"><div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<strong>Well done!</strong> <br/>';
				if($_SESSION['sukses']=="sukses")
					echo'Saving data success without error';
				else
					echo"$_SESSION[sukses]";
			echo'</div></section>';
			unset($_SESSION['sukses']);
			}?>
			<?php if(isset($_SESSION['error'])){
			echo'<section role="main" class="content-body"><div class="alert alert-warning">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<strong>Upsss!</strong> Something wrong. <br>';
				if($_SESSION['error']=="error")
					echo'cannot update data';
				else
					echo"$_SESSION[error]";
			echo'</div></section>';
			unset($_SESSION['error']);
			}?>
<title><?php navbar("home");?> | CRM Nusanet</title>

<div roll="main" class="content-body tabs tabs-primary">
  <ul class="nav nav-tabs nav-justified">
    <li class="active">
      <a href="#dash" data-toggle="tab" class="text-center"><i class="fa fa-dashboard"></i> Dashboard</a>
    </li>
    <li>
      <a href="#feed" data-toggle="tab" class="text-center"><i class="fa fa-rss"></i> Feed</a>
    </li>
  </ul>
  <div class="tab-content">
    <div id="dash" class="tab-pane active">

    <div class="row">
    <div class="col-md-12">
              <section>
                <div class="">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="chart-data-selector" id="salesSelectorWrapper">
                        <h2>
                          Stat:
                          <strong>
                            <select class="form-control" id="salesSelector">
                              <option value="Leads Total">Leads Total</option>
                              <?php
                              $tampil="<option value='Prospect Total' >SM Leads Total</option>";
                              level0($tampil);?>
                            </select>
                          </strong>
                        </h2>

                        <div id="salesSelectorItems" class="chart-data-selector-items mt-sm">
                          
                          <div class="chart chart-sm" data-sales-rel="Leads Total" id="flotDashSales1" class="chart-active" style="height: 250px;"></div>
                          <script>

                            var flotDashSales1Data = [{
                                data: [
                                <?php
                                for ($i =1 ; $i<= 12; $i++) {
                                $date=date('Y');
                                $value = str_pad($i,2,"0",STR_PAD_LEFT);
                                $totalleads=mysql_query("select count(*) as total from leads where open like '$date/$value%';");
                                $totalaccount=mysql_query("select count(*) as total from account where open like '$date/$value%';");
                                switch ($value) {
                                  case '01':
                                    $month="Jan";
                                    break;
                                  case '02':
                                    $month="Feb";
                                    break;
                                  case '03':
                                    $month="Mar";
                                    break;
                                  case '04':
                                    $month="Apr";
                                    break;
                                  case '05':
                                    $month="May";
                                    break;
                                  case '06':
                                    $month="Jun";
                                    break;
                                  case '07':
                                    $month="Jul";
                                    break;
                                  case '08':
                                    $month="Aug";
                                    break;
                                  case '09':
                                    $month="Sep";
                                    break;
                                  case '10':
                                    $month="Oct";
                                    break;
                                  case '11':
                                    $month="Nov";
                                    break;
                                  case '12':
                                    $month="Dec";
                                    break;
                                  default:
                                    $month="";
                                    break;
                                }
                                $leadstotal=mysql_fetch_array($totalleads);
                                $accounttotal=mysql_fetch_array($totalaccount);
                                $total=$leadstotal['total'] + $accounttotal['total'];
                                  echo "[\"$month\",\"$total\"],";
                                }
                                ?>
                                ],
                                color: "#0088cc"
                            }];

                            
                          </script>

                          
                          <div class="chart chart-sm" data-sales-rel="Prospect Total" id="flotDashSales2" class="chart-hidden" style="height: 250px;"></div>
                          <script>

                            var flotDashSales2Data = [{
                                data: [
                              <?php
                              $smleads=mysql_query("select * from admin where level='1'");
                              while($pecahsmleads=mysql_fetch_array($smleads)){
                                $hitungleads=mysql_fetch_array(mysql_query("select count(*) as total from leads where sm='$pecahsmleads[userid]'"));
                                $hitungaccount=mysql_fetch_array(mysql_query("select count(*) as total from account where sm='$pecahsmleads[userid]'"));
                                $hitung=$hitungleads['total'] + $hitungaccount['total'];
                                echo"[\"$pecahsmleads[nama]\",\"$hitung\"],";
                              }?>
                                   
                                ],
                                color: "#2baab1"
                            }];

                            

                          </script>

                        </div>

                      </div>
                    </div>
                </div>
              </section>
    </div>

      <div class="row">
        <div class="text-center col-md-6">
        <h2 class="panel-title mt-md">Revenue Goal</h2>
            <div class="circular-bar">
              <div class="circular-bar-chart" data-percent="0" data-plugin-options='{ "barColor": "#0088CC", "delay": 300 }'>
                <label><span class="percent">0</span>%</label>
              </div>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <h2 class="panel-title mt-md">Lead Source</h2>
            <div id="donut-example" style="height: 250px;"></div>
              <script type="text/javascript">
                 Morris.Donut({
                      element: 'donut-example',
                      data: [
                      <?php
                      $aktifitas=mysql_query("select source,count(source) as jumlah from leads group by source");      
                  while($pecah=mysql_fetch_array($aktifitas)){
                    echo "{label: \"$pecah[source]\", value: $pecah[jumlah]},";}  ?>
                      ]
                    });
              </script>

          </div>
                  
      </div>

      
      <div class="row">      
        <div class="col-md-6">
        <section class="panel panel-featured-left panel-featured-tertiary">
          <div class="panel-body">
            <div class="widget-summary">
              <div class="widget-summary-col widget-summary-col-icon ">
                <div class="summary-icon bg-tertiary text-center">
                  <i style="line-height: 2;" class="fa fa-copy"></i>
                </div>
              </div>
              <div class="widget-summary-col">
                <div class="summary">
                  <h4 class="title">Today's Leads</h4>
                  <div class="info">
                  <?php
                  $today=date('Y/m/d');
                  $todayleads=mysql_num_rows(mysql_query("select * from leads where open='$today'"));
                  $todayaccount=mysql_num_rows(mysql_query("select * from leads where open='$today'"));
                  $jumlahleads=$todayleads+$todayaccount;?>
                    <strong class="amount"><?php echo"$jumlahleads";?></strong>
                  </div>
                </div>
                <div class="summary-footer">
                </div>
              </div>
            </div>
          </div>
        </section>
        </div>
        <div class="col-md-6">
          <section class="panel panel-featured-left panel-featured-quartenary">
            <div class="panel-body">
              <div class="widget-summary">
                <div class="widget-summary-col widget-summary-col-icon">
                  <div class="summary-icon bg-quartenary">
                    <i style="line-height: 2;" class="fa fa-copy"></i>
                  </div>
                </div>

                <div class="widget-summary-col">
                  <div class="summary">
                    <h4 class="title">Yesterday Leads</h4>
                    <div class="info">
                      <?php
                  $dates=date('d');
                  $datesss=$dates-1;
                  $datess=sprintf("%02d",$datesss);
                  $yesterday=date('Y/m');
                  $yesterdayleads=mysql_num_rows(mysql_query("select * from leads where open='$yesterday/$datess'"));
                  $yesterdayaccount=mysql_num_rows(mysql_query("select * from leads where open='$yesterday/$datess'"));
                  $jumlahyesterdayleads=$yesterdayleads+$yesterdayaccount;?>
                    <strong class="amount"><?php echo"$jumlahyesterdayleads";?></strong>
                    </div>
                  </div>

                  <div class="summary-footer">
                    
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
      <div class="row">      
        <div class="col-md-6">
        <section class="panel panel-featured-left panel-featured-tertiary">
          <div class="panel-body">
            <div class="widget-summary">
              <div class="widget-summary-col widget-summary-col-icon ">
                <div class="summary-icon bg-tertiary text-center">
                  <i style="line-height: 2;" class="fa fa-copy"></i>
                </div>
              </div>
              <?php
              if($_SESSION['level']=="1337" or $_SESSION['level']=="0"){
                $datemax=mysql_fetch_array(mysql_query("select max(date) as date from history where history_action='Leads Created'"));
                $date=$datemax['date'];
                $timemax=mysql_fetch_array(mysql_query("select max(time) as time from history where history_action='Leads Created' and date='$date'"));
                $lastleads=mysql_query("select * from history where history_action='Leads Created' and date='$date' and time='$timemax[time]'");
              }
              elseif($_SESSION['level']=="1"){
                $tampilsales=mysql_query("select * from user where sm='$_SESSION[userid]'");
                $tmp="0";
                while($carisalesleads=mysql_fetch_assoc($tampilsales)){
                  $leadss=mysql_query("select * from history where userid='$carisalesleads[userid]' and history_action='Leads Created' group by date desc");
                  $carilastleads=mysql_fetch_array($leadss);
                if($carilastleads['date']>$tmp){
                  $tmp=$carilastleads['date'];
                  $time=$carilastleads['time'];
                  $sales=$carilastleads['userid'];
                }
                elseif($carilastleads['date']==$tmp){
                  $tmp=$carilastleads['date'];
                  if($time > $carilastleads['time']){
                    $sales=$carilastleads['userid'];
                    $time=$carilastleads['time'];
                  }
                }
              }
                $lastleads=mysql_query("select * from history where history_action='Leads Created' and date='$tmp' and time='$time' and userid='$sales' group by date desc");
              }

              elseif($_SESSION['level']=="2"){
                $datemax=mysql_fetch_array(mysql_query("select max(date) as date from history where userid='$_SESSION[userid]' and history_action='Leads Created'"));
                $date=$datemax['date'];
                $timemax=mysql_fetch_array(mysql_query("select max(time) as time from history where userid='$_SESSION[userid]' and history_action='Leads Created' and date='$date'"));
                $lastleads=mysql_query("select * from history where userid='$_SESSION[userid]' and history_action='Leads Created' and date='$date' and time='$timemax[time]'");
              }
              $pecahll=mysql_fetch_array($lastleads);
              $namasales=mysql_fetch_array(mysql_query("select * from user where userid='$pecahll[userid]'"));
              $namaleads1=mysql_num_rows(mysql_query("select * from leads where id='$pecahll[id]'"));
              if($namaleads1>"0"){
                $namaleads=mysql_fetch_array(mysql_query("select * from leads where id='$pecahll[id]'"));
              }
              else{
                $namaleads=mysql_fetch_array(mysql_query("select * from account where id='$pecahll[id]'"));
              }?>
              <div class="widget-summary-col">
                <div class="summary">
                  <h4 class="title">Last Leads</h4>
                  <div class="info">
                    <strong class="amount"><?php echo "$namaleads[nama] $namaleads[lname]";?></strong>
                  </div>
                </div>
                <div class="summary-footer">
                  <a class="text-muted text-uppercase"><?php echo "$namasales[nama]";?></a>
                </div>
              </div>
            </div>
          </div>
        </section>
        </div>
        </div>
</div>
    </div>

    <div class='tab-pane' id='feed'>

    <?php include ('feed.php'); ?> 
    </div><!-- end of tab -->
