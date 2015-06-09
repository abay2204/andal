<section role="main" class="content-body">
          <header class="page-header">
          <?php $hal="Real Time"?>
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
</head>
    
    
<body style="background:#EEE">
<?php
$keyakses="Real Time";
$hal=$keyakses;
if($_SESSION[$keyakses]!=md5($keyakses)){
  header('location:login.php');
}
else{
?>
<div class="row">
<div class="col-xs-12">
<section class="panel">
      
        <?php
        
        ?>
        <div class="google-map-wrap" itemscope itemprop="hasMap" itemtype="http://schema.org/Map">
          <div id="google-map" class="google-map" style="height: 500px; width: 100%;">
          </div><!-- #google-map -->
        </div>
        <?php
        /**$cekdate=mysql_fetch_array("select max(date) from history group by userid");
        $cektime=mysql_fetch_array("select max(time) from history group by userid");**/
        $lokasi=mysql_query("select * from history group by userid");
        $locations = array();
        while($pecah=mysql_fetch_array($lokasi)){
        $cekdate=mysql_fetch_array(mysql_query("select max(date) as date from history where userid='$pecah[userid]'"));
        $cektime=mysql_fetch_array(mysql_query("select max(time) as time from history where userid='$pecah[userid]' and date='$cekdate[date]'"));
        $realtime=mysql_fetch_array(mysql_query("select * from history where userid='$pecah[userid]' and date='$cekdate[date]' and time='$cektime[time]'"));
        $lat=$realtime['lat'];
        $lng=$realtime['lng'];
        $nama=mysql_fetch_array(mysql_query("select * from user where userid='$pecah[userid]'"));
        $address= getaddress($lat,$lng);
        $pecahkan=explode(",",$address);
        //$namajalan="$pecahkan[0],$pecahkan[1]";
        //$kota=str_replace(" Kota ","",$pecahkan['2']);
        $locations[] = array(
          'google_map' => array(
            'lat' => $lat,
            'lng' => $lng,
          ),
          'location_address' => $address,
          'location_name'    => $nama['nama'],
          'location_seen'    => "$realtime[date] $realtime[time]"
        );
        }
        /* Set Default Map Area Using First Location */
        $map_area_lat = isset( $locations[0]['google_map']['lat'] ) ? $locations[0]['google_map']['lat'] : '';
        $map_area_lng = isset( $locations[0]['google_map']['lng'] ) ? $locations[0]['google_map']['lng'] : '';
        ?>
        <script>
        jQuery( document ).ready( function($) {

          /* Do not drag on mobile. */
          var is_touch_device = 'ontouchstart' in document.documentElement;

          var map = new GMaps({
            el: '#google-map',
            lat: '<?php echo $map_area_lat; ?>',
            lng: '<?php echo $map_area_lng; ?>',
            scrollwheel: true,
            draggable: ! is_touch_device
          });

          /* Map Bound */
          var bounds = [];

          <?php /* For Each Location Create a Marker. */
          foreach( $locations as $location ){
            $name = $location['location_name'];
            $addr = $location['location_address'];
            $seen = $location['location_seen'];
            $icon = $location['icon'];
            $map_lat = $location['google_map']['lat'];
            $map_lng = $location['google_map']['lng'];
            if($map_lat!="0"){
            ?>

            /* Set Bound Marker */
            var latlng = new google.maps.LatLng(<?php echo $map_lat; ?>, <?php echo $map_lng; ?>);
            bounds.push(latlng);
            /* Add Marker */
            map.addMarker({
              lat: <?php echo $map_lat; ?>,
              lng: <?php echo $map_lng; ?>,
              title: '<?php echo $name; ?>',
              icon : '<?php echo $icon; ?>',
              infoWindow: {
                content: '<p><?php echo "<b>$name</b><br/>last seen:<b>$seen</b>"; ?></p><?php echo $addr; ?>'
              }
              
            });
          <?php }} //end foreach locations ?>

          /* Fit All Marker to map */
          map.fitLatLngBounds(bounds);

          /* Make Map Responsive */
          var $window = $(window);
       
          mapWidth();
          $(window).resize(mapWidth);

        });
        </script>
<?php }?>

      </div><!-- .entry-content -->

    </article>
</body>
</html>

