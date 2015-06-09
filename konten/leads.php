<?php 
if(isset($_POST['addleads'])){
    $address=getaddress($_POST['lat'],$_POST['lng']);
    $today=date('Y/m/d');
    $time=date('H:i:s');
    $todayleads=mysql_num_rows(mysql_query("select * from leads where open='$today'"));
    $todayaccount=mysql_num_rows(mysql_query("select * from account where open='$today'"));
    $todayid=date('dm');
    $idnow=$todayaccount+$todayleads+1;
    $front=substr($_POST['fname'], 0, 2);
    $back=substr($_POST['lname'], 0, 1);
    $fname=mysql_escape_string($_POST['fname']);
    $fname=htmlspecialchars($fname);
    $lname=mysql_escape_string($_POST['lname']);
    $lname=htmlspecialchars($lname);
    $id="$front$back$todayid$idnow";
    if($_POST['source']=="select-one"){
        $_SESSION['error']="you must choose select one sources";
    }
    else{
       if(isset($_POST['institution'])){
        $type="corporate";
        mysql_query("insert into customer_company (id,company_name,industry) values ('$id','$_POST[institution]','Other')");
        }
        else{
        $type="personal";
        }
    if(isset($_POST['sales'])){
        $sm=mysql_fetch_array(mysql_query("select * from user where userid='$_POST[sales]'"));
        if(!empty($_POST['sources'])){
            $ekse=mysql_query("insert into leads (id,source,open,nama,lname,sales,sm,type,progress,status) values ('$id','$_POST[sources]','$today','$fname','$lname','$_POST[sales]','$sm[sm]','$type','10','New')");}
        else{
            $ekse=mysql_query("insert into leads (id,source,open,nama,lname,sales,sm,type,progress,status) values ('$id','$_POST[source]','$today','$fname','$lname','$_POST[sales]','$sm[sm]','$type','10','New')");}
            mysql_query("insert into history(id,userid,history_action,keterangan,lokasi,lat,lng,date,time) values ('$id','$_SESSION[userid]','Leads Created','by $_SESSION[nama]','$address','$_POST[lat]','$_POST[lng]','$today','$time')");     
    }
    else{
        $sm=mysql_fetch_array(mysql_query("select * from user where userid='$_SESSION[userid]'"));
        if(!empty($_POST['sources'])){
            $ekse=mysql_query("insert into leads (id,source,open,nama,lname,sales,sm,type,progress) values ('$id','$_POST[sources]','$today','$fname','$lname','$_SESSION[userid]','$sm[sm]','$type','10')");}
        else{
            $ekse=mysql_query("insert into leads (id,source,open,nama,lname,sales,sm,type,progress) values ('$id','$_POST[source]','$today','$fname','$lname','$_SESSION[userid]','$sm[sm]','$type','10')");}
            mysql_query("insert into history(id,userid,history_action,lokasi,lat,lng,date,time) values ('$id','$_SESSION[userid]','Leads Created','$address','$_POST[lat]','$_POST[lng]','$today','$time')");     
    }
    if($ekse){
        $_SESSION['sukses']="Leads created";
    }
    else{
        $_SESSION['error']="Cannot create leads";
    }
        }
}
if(isset($_GET['convert'])){
    $convert=mysql_escape_string($_GET['convert']);
    $cek1=mysql_fetch_array(mysql_query("select * from leads where id='$convert'"));
    $cekaddress=mysql_fetch_array(mysql_query("select * from customer_address where id='$convert'"));

    if(!empty($cek1['nama'] and $cek1['type'] and $cekaddress['address1'] and $cek1['phone'] and $cek1['email'] and $cek1['sales'])){
        $cek2=mysql_num_rows(mysql_query("select * from history where id='$convert' and history_action='Stop Meeting'"));
        if($cek2 > "0"){
         $ekse=mysql_query("insert into account select * from leads where id='$convert'");
         if($ekse){
            $_SESSION['sukses']="Success Convert Account";
            mysql_query("delete from leads where id='$convert'");
            mysql_query("insert into history (id,history_action,keterangan,date,time) values ('$convert','Convert','$_SESSION[nama] convert from Leads to Account','$date','$time')");
         }
         else{
            $_SESSION['error']="error";
         }
        }
        else{
            $_SESSION['error']="Cannot Convert";
        
        }
    }
    else{
         $_SESSION['error']="to Convert from Leads to Account you must complete all field";
        }
}?>
<section role="main" class="content-body">
          <header class="page-header">
          <?php $keyakses="Leads";?>
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
<div style="padding-bottom: 5px; padding-left: 30px; padding-right: 40px;" class="row">
<div classs="col-md-12">          
                <a data-step="2" data-intro="Untuk menambahkan leads silahkan menekan tombol ini. Selengkapnya silahkan baca di jkt.nusa.net.id/crm/help" data-position='right' class="mb-xs mt-xs mr-xs modal-basic btn btn-default" href="#LeadsAdd"><i class="fa fa-edit"></i> Add Leads</a>
    <a data-step="3" data-intro="Fungsi sorting untuk memudahkan Anda untuk mencari leads." data-position='right'>
    <!--<select class="form-control" data-plugin-multiselect id="mode">-->
    <select data-plugin-multiselect id="mode">
        <option value="card" selected>Card View</option>
        <option value="list">List View</option>
    </select>
    </a>
    <a class="btn btn-default btn-danger pull-right" href="javascript:void(0);" onclick="javascript:introJs().start();"><i class="fa fa-bell-o"></i> Guide</a>
</div>
</div>
<?php
  if ($_SESSION['level']=="1"){
                        $kueri=mysql_query("select * from leads where sm='$_SESSION[userid]'");
                        $jumlahkueri=mysql_num_rows($kueri);
                    }
                    elseif($_SESSION['level']=="2"){
                        $kueri=mysql_query("select * from leads where sales='$_SESSION[userid]'");
                        $jumlahkueri=mysql_num_rows($kueri);
                    }
                    elseif($_SESSION['level']=="0"){
                        $kueri=mysql_query("select * from leads");
                        $jumlahkueri=mysql_num_rows($kueri);
                    }?>

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
                            <th>Date</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Sales</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php while ($kolomlist = mysql_fetch_assoc($kueri)) {
                        $address=mysql_fetch_assoc(mysql_query("select * from customer_address where id='$kolomlist[id]'"));
                        $sales=mysql_fetch_array(mysql_query("Select * from user where userid='$kolomlist[sales]'"));
                        $dateactivity=mysql_fetch_array(mysql_query("select max(date) as date from history where id='$kolomlist[id]'"));
                        $timeactivity=mysql_fetch_array(mysql_query("select max(time) as time from history where id='$kolomlist[id]' and date='$dateactivity[date]'"));
                        $times="$dateactivity[date] $timeactivity[time]";
                        $timeago=time_ago($times);
                        $timeagos=strtotime($times);
                        echo' <tr class="gradeX">
                           <td data-title="Name"><a href=?hal=detail-leads&detail='.$kolomlist['id'].'>'.$kolomlist['nama'].' '.$kolomlist['lname'].'</a></td>
                           <td data-title="Date" value="'.$timeagos.'">'.$timeago.'</td>
                            <td data-title="Phone"><a href="tel:'.$kolomlist['phone'].'">'.$kolomlist['phone'].'</a></td>
                            <td data-title="email"><a href="mailto:'.$kolomlist['email'].'">'.$kolomlist['email'].'</a></td>
                            <td data-title="Sales">'.$sales['nama'].'</td>
                            <td data-title="Action"><a href="?hal=edit-leads&edit='.$kolomlist['id'].'"><i class="fa fa-edit"></i> Edit</a>
                           <span class=\"pull-right\">';
                            if(!empty($kolomlist['nama'] and $kolomlist['type'] and $address['address1'] and $kolomlist['phone'] and $kolomlist['email'] and $kolomlist['sales'])){
                                $filter=mysql_query("select * from history where id='$kolomlist[id]' and history_action='Stop Meeting'");
                                $cekfilter=mysql_num_rows($filter);
                                if($cekfilter > "0"){
                                echo" | <a href=?hal=leads&convert=$kolomlist[id]><i class=\"fa fa-reply\"></i> Convert</a>";
                            }
                            }
                            echo'</td>
                        </tr>';}?>
                    </tbody>
                </table>
            </div>
        </section>
        </div>
            <div class='card'>
            <input data-step="4" data-intro="Fungsi search untuk memudahkan Anda untuk mencari leads." data-position='top' type="search" class="form-control" id="input-search" placeholder="Cari berdasarkan nama leads, nama institusi, nama customer, dsb ...." >

        

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
         <div data-step="5" data-intro="Ini merupakan leads. baca selengkapnya tentang leads di jkt.nusa.net.id/crm/help" data-position='top'  class="searchable-container">
         
            <?php
if($_SESSION[$keyakses]!=md5($keyakses)){
  header('location:login.php');
}      
     //khusus untuk level user
    //$sql = mysql_query ("SELECT nama, kegiatan FROM last WHERE nama='$nama_sales atau id'");
            if ($_SESSION['level']=="1"){
                        $kueri=mysql_query("select * from leads where sm='$_SESSION[userid]'");
                    }
                    elseif($_SESSION['level']=="2"){
                        $kueri=mysql_query("select * from leads where sales='$_SESSION[userid]'");
                    }
                    elseif($_SESSION['level']=="0"){
                        $kueri=mysql_query("select * from leads");    
                        }  
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
                            <a href=?hal=detail-leads&detail=$kolom[id]>".substr($kolom["nama"]." ".$kolom['lname'],0,17). " </a>
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
                            if(!empty($kolom['nama'] and $kolom['type'] and $address['address1'] and $kolom['phone'] and $kolom['email'] and $kolom['sales'])){
                                $filter=mysql_query("select * from history where id='$kolom[id]' and history_action='Stop Meeting'");
                                $cekfilter=mysql_num_rows($filter);
                                if($cekfilter > "0"){
                                echo"<a href=?hal=leads&convert=$kolom[id] class=\"btn btn-success\"><i class=\"fa fa-reply\"></i> Convert</a>";
                            }
                             
                            }
                           
                            
                            
                               echo" <a href=\"?hal=edit-leads&edit=".$kolom["id"]."\" class=\"btn btn-primary\"><i class=\"fa fa-edit\"></i> Edit</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>";}
    ?>
<?php }
else{
echo "<center><h1>You don't have any Leads<br/>You can create one or more</h1></center>";}?>
        </div>
    </div>
</div>
</footer>
                
                </div>
            </section>
        </div>
        
    <!-- start updateprogress -->
       
        

        <div id="LeadsAdd" class="zoom-anim-dialog modal-block modal-header-color modal-block-primary mfp-hide">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Add Leads <button class="btn btn-primary pull-right modal-dismiss"><b>X</b></button></h2>
                </header>
                <div class="panel-body">
                <div class="tipe">
                    <div class="row col-md-offset-4 col-md-12"><label class="control-label">Please choose type of leads</label></div>
                    <div class="col-md-6">
                        <button id="personal" class="btn btn-default col-md-12">Personal</button>
                    </div>
                     <div class="col-md-6">
                        <button id="corporate" class="btn btn-default col-md-12">Business</button>
                    </div>
                </div>    
                    <form id="form" method="POST" class="form-horizontal pers">
                     <div class="form-group">
                        <label class="col-sm-3 control-label">Source <span class="required">*</span></label>
                        <div class="col-sm-9">
                        <select id="source" name="source">
                        <option value="select-one">----------</option>
                        <option value="Canvasing">Canvasing</option>
                        <option value="Reseller">Reseller</option>
                        <option value="Customer Existing">Customer Existing</option>
                        <option value="Web">Web</option>
                        <option value="CRO">CRO</option>
                        <option value="Other">Other</option>
                        </select>
                        </div>
                    </div> 
                    <div id="lokasi"></div>
                    <div style="display: none;" class="oth form-group">
                        <label class="col-sm-3 control-label"></span></label>
                        <div class="col-sm-9">
                        <input type="text" name="sources" class="form-control" placeholder="source"/>
                        </div>
                    </div>
                    <?php if($_SESSION['level']=="0" or $_SESSION['level']=="1"){
                        echo'<div class="form-group">
                        <label class="col-sm-3 control-label">Sales Name <span class="required">*</span></label>
                        <div class="col-sm-9">
                        <select name="sales">';
                        if($_SESSION['level']=="0"){
                            $tampiluser=mysql_query("select * from user");
                        }
                        elseif($_SESSION['level']=="1"){
                            $tampiluser=mysql_query("select * from user where sm='$_SESSION[userid]'");
                        }
                        while($pecahtu=mysql_fetch_array($tampiluser)){
                            echo'<option value="'.$pecahtu['userid'].'">'.$pecahtu['nama'].'</option>';
                        }
                        
                        echo'</select></div></div>';
                    }?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">First Name <span class="required">*</span></label>
                        <div class="col-sm-9">
                        <input type="text" name="fname" class="form-control" placeholder="eg. Nusa" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Last Name <span class="required">*</span></label>
                        <div class="col-sm-9">
                        <input type="text" name="lname" class="form-control" placeholder="eg. Net" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-default back">Back</button>
                            <button type="submit" name="addleads" class="btn btn-primary">Add Leads</button>
                        </div>
                    </div>
                </form>

                <form id="form" method="post" class="form-horizontal corp">
                     <div class="form-group">
                        <label class="col-sm-3 control-label">Source <span class="required">*</span></label>
                        <div class="col-sm-9">
                        <select id="source" name="source">
                        <option value="select-one">----------</option>
                        <option value="Canvasing">Canvasing</option>
                        <option value="Reseller">Reseller</option>
                        <option value="Customer Existing">Customer Existing</option>
                        <option value="Web">Web</option>
                        <option value="CRO">CRO</option>
                        <option value="Other">Other</option>
                        </select>
                        </div>
                    </div> 
                    <div class="lokasi"></div>
                    <div style="display: none;" class="oth form-group">
                        <label class="col-sm-3 control-label"></span></label>
                        <div class="col-sm-9">
                        <input type="text" name="sources" class="form-control" placeholder="source"/>
                        </div>
                    </div>
                    <?php if($_SESSION['level']=="0" or $_SESSION['level']=="1"){
                        echo'<div class="form-group">
                        <label class="col-sm-3 control-label">Sales Name <span class="required">*</span></label>
                        <div class="col-sm-9">
                        <select name="sales">';
                        if($_SESSION['level']=="0"){
                            $tampiluser=mysql_query("select * from user");
                        }
                        elseif($_SESSION['level']=="1"){
                            $tampiluser=mysql_query("select * from user where sm='$_SESSION[userid]'");
                        }
                        while($pecahtu=mysql_fetch_array($tampiluser)){
                            echo'<option value="'.$pecahtu['userid'].'">'.$pecahtu['nama'].'</option>';
                        }
                        
                        echo'</select></div></div>';
                    }?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">First Name <span class="required">*</span></label>
                        <div class="col-sm-9">
                        <input type="text" name="fname" class="form-control" placeholder="eg. Nusa" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Last Name <span class="required">*</span></label>
                        <div class="col-sm-9">
                        <input type="text" name="lname" class="form-control" placeholder="eg. Net" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Bussiness/Institution Name<span class="required">*</span></label>
                        <div class="col-sm-9">
                        <input type="text" name="institution" class="form-control" placeholder="eg. Nusanet" required/>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-default back">Back</button>
                            <button type="submit" name="addleads" class="btn btn-primary">Add Leads</button>
                        </div>
                    </div>
                </form>
                </div>
            </section>
        </div>
    </div>

</script>

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
<script>
$(document).ready(function(){
    $(".pers").hide();
    $(".corp").hide();
    $(".tipe").show();

    $("#personal").click(function(){
        $(".pers").show();
        $(".corp").hide();
        $(".tipe").hide();
    });
    $("#corporate").click(function(){
        $(".pers").hide();
        $(".corp").show();
        $(".tipe").hide();
    });
    $(".back").click(function(){
        $(".pers").hide();
        $(".corp").hide();
        $(".tipe").show();
    });
   
});
</script>
<!-- show intro -- >
<link rel="stylesheet" type="text/css" href="assets/vendor/intro/intro.css" />
<script type="text/javascript" src="assets/vendor/intro/intro.js"></script>
    <script type="text/javascript">
      function startIntro(){
        var intro = introJs();
          intro.setOptions({
            steps: [
              {
                element: document.querySelector('#step1'),
                intro: "This is a tooltip."
              }
            ]
          });
           intro.start(); 
      }
      window.onload = startIntro;
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