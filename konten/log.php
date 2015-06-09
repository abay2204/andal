<section role="main" class="content-body">
          <header class="page-header">
          <?php $keyakses="Activity log";?>
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
<div class="row">
					<div class="col-md-12">
						<div class="panel-group" id="accordion2">
							<div class="panel panel-accordion panel-accordion-primary">
								<div class="panel-heading">
										<?php
										$log=mysql_query("Select * from log_activity where userid='$_SESSION[userid]' group by date");
										while($pecahlog=mysql_fetch_array($log)){
											$pecahkanlog=explode("/",$pecahlog['date']);
											$year=$pecahkanlog['0'];
											$month=$pecahkanlog['1'];
											$sortbymonth=mysql_query("Select * from log_activity where userid='$_SESSION[userid]' and date like '$year/$month%' group by date");
											echo'<h4 class="panel-title">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2One">
											<i class="fa fa-time"></i> '.$year.'/'.$month.'
										</a>
									</h4></div>';
										while($pecahsortbym=mysql_fetch_array($sortbymonth)){
										echo'<div id="collapse2One" class="accordion-body collapse in">
										<div class="panel-body">
										<table class="table mb-none">
											<thead>
												<tr>
													<th>'.$pecahsortbym['date'].'</th>
												</tr>
											</thead>
											<tbody>';
											$sortbydate=mysql_query("select * from log_activity where userid='$_SESSION[userid]' and date='$pecahsortbym[date]' group by date");
									while($sortbydates=mysql_fetch_array($sortbydate)){
												echo'<tr>
													<td style="width: 10%">'.$sortbydates['time'].'</td>
													<td>'.$sortbydates['action'].'</td>
												</tr></tbody>';}}}?>
											
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>