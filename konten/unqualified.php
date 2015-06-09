<section role="main" class="content-body">
          <header class="page-header">
          <?php $keyakses="Unqualified";?>
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
<div style="padding-bottom: 5px; padding-left: 30px;" class="row">
<div classs="col-md-8">          
        <select class="form-control" data-plugin-multiselect id="mode">
        <option value="card" selected>Card View</option>
        <option value="list">List View</option>
    </select>
</div>    
</div>
<?php
    $kueri=mysql_query("select * from unqualified");
    $jumlahkueri=mysql_num_rows($kueri);
?>

<?php
if($jumlahkueri > "0"){
if($_SESSION['level']=="0" or $_SESSION['level']=="1"){echo'<div class="col-lg-12" style="padding-bottom: 20px;">';}else{echo'<div class="col-lg-12" style="padding-bottom: 20px;">';}?>
         <div style="display: none;" class="list col-md-12">
        <section class="panel">
            <div class="panel-body">
                <table id="datatable-default" class="table table-no-more table-bordered table-striped mb-none">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php while ($kolomlist = mysql_fetch_assoc($kueri)) {
                        $address=mysql_fetch_assoc(mysql_query("select * from customer_address where id='$kolomlist[id]'"));
                        $sales=mysql_fetch_array(mysql_query("Select * from user where userid='$kolomlist[sales]'"));
                        echo' <tr class="gradeX">
                           <td data-title="Name"><a href=?hal=detail-unqualified&detail='.$kolomlist['id'].'>'.$kolomlist['nama'].' '.$kolomlist['lname'].'</a></td>
                            <td data-title="Phone"><a href="tel:'.$kolomlist['phone'].'">'.$kolomlist['phone'].'</a></td>
                            <td data-title="Email"><a href="mailto:'.$kolomlist['email'].'">'.$kolomlist['email'].'</a></td>
                            <td data-title="Sales">'.$sales['nama'].'</td>';
                           
                            echo'</td>
                        </tr>';}?>
                    </tbody>
                </table>
            </div>
        </section>
        </div>
            <div class='card'>
            <input type="search" class="form-control" id="input-search" placeholder="Cari berdasarkan nama unqualified, nama institusi, nama customer, dsb ...." >

        

<script type="text/javascript">
        $(function() {

        $('#input-search').on('keyup', function() {

          var rex = new RegExp($(this).val(), 'i');

            $('.searchable-container .items').hide();

            $('.searchable-container .items').filter(function() {

                return rex.test($(this).text());

            }).show();

        });

    });
</script>
         <div class="searchable-container">
         
            <?php
if($_SESSION[$keyakses]!=md5($keyakses)){
  header('location:login.php');
}      
     //khusus untuk level user
    //$sql = mysql_query ("SELECT nama, kegiatan FROM last WHERE nama='$nama_sales atau id'");
            $kueri=mysql_query("select * from unqualified");
                    while ($kolom = mysql_fetch_assoc($kueri)) {
        $address=mysql_fetch_assoc(mysql_query("select * from customer_address where id='$kolom[id]'"));
        $inisial=substr($kolom['nama'], 0, 1);
        $sales=mysql_fetch_array(mysql_query("select * from user where userid='$kolom[sales]'"));
        $dateactivity=mysql_fetch_array(mysql_query("select max(date) as date from history where id='$kolom[id]'"));
        $timeactivity=mysql_fetch_array(mysql_query("select max(time) as time from history where id='$kolom[id]' and date='$dateactivity[date]'"));
        $times="$dateactivity[date] $timeactivity[time]";
        $timeago=time_ago($times);
        if($kolom['phone']==null){
            $kolom['phone']="not available";
        }
        if($kolom['email']==null){
            $kolom['email']="not available";
        }
    echo "<div class=\"items col-md-6\">
            <div class=\"well well-sm\">
                <div class=\"row\">
                    <div class=\"col-xs-3 col-md-3 text-center\">
                        <h1 style='background:#31B0D5 ;color:white'>".ucfirst($inisial)."</h1>
                        <p>$timeago</p>
                    </div>
                    <div class=\"col-xs-9 col-md-9 section-box\">
                        <h2><font color=\"#31B0D5\">
                            <a href=?hal=detail-unqualified&detail=$kolom[id]>".substr($kolom["nama"]." ".$kolom['lname'],0,17). " </a>
                            </span>
                        </h2></font>
                        <table style=\"100%\">
                        <tr>
                        <td width=\"7%\"><i class=\"fa fa-user\"></i></td>
                        <td>Name</td>
                        <td>: " .substr($kolom["nama"]." ".$kolom['lname'],0,17). "</td>
                        </tr>
                        <tr>
                        <td width=\"7%\"><i class=\"fa fa-building\"></i></td>
                        <td>Institusi</td>
                        <td>: " .$kolom["type"]. "</td>
                        </tr>
                        <tr>
                        <td width=\"7%\"><i class=\"fa fa-map-marker\"></i></td>
                        <td>Address</td>
                        <td>: " .substr($address["address1"],0,17). "</td>
                        </tr>
                        <tr><td/><td/><td>: " .substr($address["address2"],0,17). "</td></tr>
                        
                        <tr>
                        <td width=\"7%\"><i class=\"fa fa-mobile\"></i></td>
                        <td>Phone</td>
                        <td>: <a href='tel:$kolom[phone]'>" .$kolom["phone"]. "</a<</td>
                        </tr>
                        <tr>
                        <td width=\"7%\"><i class=\"fa fa-envelope\"></i></td>
                        <td>Email</td>
                        <td>: <a href='mailto:$kolom[email]'>" .substr($kolom["email"],0,17). "</a></td>
                        </tr>
                        <tr>
                        <td width=\"7%\"><i class=\"fa fa-group\"></i></td>
                        <td>Sales</td>
                        <td>: " .$sales['nama']. "</td>
                        </tr>
                        </table>
                        <hr />
                        <div class=\"row rating-desc\">
                            <div class=\"col-md-12\">
                            <span class=\"pull-right\">";
                   
                   echo"             </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>";}
    ?>
<?php }
else{
echo "<center><h1>You don't have any unqualified</center>";}?>
        </div>
    </div>
</div>
</footer>
                
                </div>
            </section>
        </div>
        
 
<script type="text/javascript">
    $(document).ready(function() {

    $('.oth').hide();

    $('#source').change(function () {
        if ($('#source option:selected').text() !== "Other"){
            $('.oth').hide();
        }
        else if ($('#source option:selected').text() == "Other"){
            $('.oth').show();
        }
    }); 
});
</script>
<script type="text/javascript">
    $(document).ready(function() {

    $('.list').hide();    

    $('#mode').change(function () {
        if ($('#mode option:selected').text() == "Card View"){
            $('.card').show();
            $('.list').hide();
        }
        else if ($('#mode option:selected').text() == "List View"){
            $('.card').hide();
            $('.list').show();
        }
    }); 
});
</script>
<script src="assets/vendor/select2/select2.js"></script>
<script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="assets/javascripts/tables/examples.datatables.default.js"></script>
<script src="assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
<script src="assets/javascripts/tables/examples.datatables.tabletools.js"></script>
<link rel="stylesheet" href="assets/vendor/select2/select2.css" />
        <link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />