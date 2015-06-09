<?php
session_start();
$date=date('Y/m/d');
$time=date('H:i:s');
function navbar($hal){
	if(!empty($hal)){
		switch ($hal) {
			case 'home':
				echo "Home";
				break;
			case 'real-time':
				echo "Real Time";
				break;
			case 'activity':
				echo "Activity";
				break;
			case 'leads':
				echo "Leads";
				break;
			case 'prospect':
				echo "Prospect";
				break;
			case 'best-sales':
				echo "Best Sales";
				break;
			case '404':
				echo "Not Found";
				break;
			default:
				echo "";
				break;
		}
	}
	else{
		echo"Home";
	}
}
function sidebar($modul){
if(!empty($modul)){
		switch ($modul) {
			
			default:
				echo '<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a style="background: #1D2127;" href="#" class="mobile-close visible-xs">
							Collapse <i class="fa fa-chevron-right"></i>
						</a>
			
						<div class="sidebar-right-wrapper">

							<h6><a class="modal-basic tutup-kanan" href="#modalTask"><i class="fa fa-plus"></i> add task</a></h6><br>
							<div class="sidebar-widget widget-calendar">
			
								<ul>';
								$kueritask=mysql_query("select * from task where user_id='$_SESSION[userid]'");
								while($pecahtask=mysql_fetch_array($kueritask)){
									echo'<ul><li><time datetime="'.$pecahtask['task_date'].'">'.$pecahtask['task_date'].' '.$pecahtask['task_time'].'</time>
										<span>'.$pecahtask['task_title'].'</span></li></ul>';}
									echo'
								</ul>
							</div>
						</div>
					</div>
				</div>
			</aside>
		</section>

		<div id="modalTask" class="modal-block modal-header-color modal-block-primary mfp-hide">
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title">Add Task</h2>
		</header>
		<div class="panel-body">
			
			
			<div class="form-group">
				<label class="control-label">Title</label>
			</div>
			<div class="form-group">
				<input name="task_title" type="text" class="form-control" placeholder="Anything to remember">
			</div>
			<div class="form-group">
				<label class="control-label">Due Date</label>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</span>
					<input name="task_date" type="text" placeholder="e.g. '.date('Y/m/d').'" id="datepicker" class="form-control">
				</div>
					<span class="help-block">Date format: YYYY/MM/DD</span>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-clock-o"></i>
					</span>
					<input name="task_time" type="text" id="timepicker" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label">Location/Place</label>
			</div>
			<div class="form-group">
				<input name="task_location" type="text" class="form-control" placeholder="e.g. Resto Abcd, Kemang">
			</div>
			<div class="form-group">
				<label class="control-label">Description</label>
			</div>
			<div class="form-group">	
				<textarea name="task_desc" class="col-sm-12" placeholder="Add something to remember you. Anything! e.g. Meeting with CEO"></textarea>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button name="task_save" type="submit" class="btn btn-primary modal-confirm">Save Task</button>
					<button class="btn btn-default modal-dismiss">Cancel</button>
				</div>
			</div>
		</footer>
	</section>
</div>';
				break;
		}
	}
	else{
		echo"Home";
	}
}
function level0($tampil){
	if($_SESSION['level']=="0"){
		echo"$tampil";
	}
}
function getaddress($lat,$lng)
        {
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
        $json = @file_get_contents($url);
        $data=json_decode($json);
        $status = $data->status;
        if($status=="OK")
        return $data->results[0]->formatted_address;
        else
        return false;
        }
function password($length) {
    $kunci = '';
    $acak = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $kunci .= $acak[array_rand($acak)];
    }

    return $kunci;
}
function time_ago( $date )
{
    if( empty( $date ) )
    {
        return "No date provided";
    }

    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

    $lengths = array("60","60","24","7","4.35","12","10");

    $now = time();

    $unix_date = strtotime( $date );

    // check validity of date

    if( empty( $unix_date ) )
    {
        return "Bad date";
    }

    // is it future date or past date

    if( $now > $unix_date )
    {
        $difference = $now - $unix_date;
        $tense = "ago";
    }
    else
    {
        $difference = $unix_date - $now;
        $tense = "from now";
    }

    for( $j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++ )
    {
        $difference /= $lengths[$j];
    }

    $difference = round( $difference );

    if( $difference != 1 )
    {
        $periods[$j].= "s";
    }

    return "$difference $periods[$j] {$tense}";

}
?>
<script type="text/javascript">
    $(function () {
        $('#timepicker').timepicker({showMeridian: false});
        $('#datepicker').datepicker({format: "yyyy/mm/dd"});
    });
     
</script>
        <!--<script type="text/javascript">
	    var clicks = 0;
	    function onClick() {
	    	if(clicks=="0"){
	        clickers = clicks+1;
	        document.
	       	<?php /**$_SESSION['collapse'] = "<script>document.write(clickers);</script>"; ?> ;
	    	}
	    	else{
	    	clickers = clicks-1;	
	    	<?php $_SESSION['collapse'] = "<script>document.write(clickers);</script>"; **/?> ;
	    	}
			
	    };
	    </script>-->
	   
	    <?php session_write_close();?>
