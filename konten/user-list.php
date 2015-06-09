<?php
if(isset($_POST['edituser'])){
  $nama=mysql_escape_string($_POST['nama']);
  $email=mysql_escape_string($_POST['email']);
  $kueri=mysql_query("update user set nama='$nama',email='$email' where userid='$_POST[userid]'");
  if($kueri){
    $_SESSION['sukses']="success update user";
  }
  else{
    $_SESSION['error']="cannot update user";
  }
}?>
<?php
if(isset($_POST['deleteuser'])){
  $nama=mysql_escape_string($_POST['usernama']);
  $userid=mysql_escape_string($_POST['userid']);
  $kueri=mysql_query("delete from user where userid='$userid'");
  if($kueri){
    $_SESSION['sukses']="success delete user";
  }
  else{
    $_SESSION['error']="cannot delete user";
  }
}?>
<section role="main" class="content-body">
          <header class="page-header">
          <?php $keyakses="User List";?>
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
  <?php
$hal=$keyakses;
if($_SESSION[$keyakses]!=md5($keyakses)){
  header('location:login.php');
}
else{
?>        
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
            unset($_SESSION['error']);}
            if($_SESSION['level']=="0"){
              $userlist=mysql_query("select * from user");
            }
            elseif($_SESSION['level']=="1"){
              $userlist=mysql_query("select * from user where sm='$_SESSION[userid]'");
            }?>
              <section class="panel">
            <div class="panel-body">
                <table id="datatable-default" class="table table-no-more table-bordered table-striped mb-none">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php while ($pecahuserlist = mysql_fetch_assoc($userlist)) {
                        echo' <tr class="gradeX">
                           <td data-title="Customer">'.$pecahuserlist['nama'].'</td>
                            <td data-title="email"><a href="mailto:'.$pecahuserlist['email'].'">'.$pecahuserlist['email'].'</a></td>
                            <td data-title="Action"><a class="modal-basic" href="#edituser'.$pecahuserlist['userid'].'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a> |
                             <a class="modal-basic" href="#deleteuser'.$pecahuserlist['userid'].'" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> delete</a>
                           <span class=\"pull-right\"></td>
                        </tr>
                        <div id="edituser'.$pecahuserlist['userid'].'" class="zoom-anim-dialog modal-block modal-header-color modal-block-primary mfp-hide">
      <section class="panel">
        <header class="panel-heading">
          <h2 class="panel-title">Edit User</h2>
        </header>
        <div class="panel-body">
        <form id="form" method="POST" class="form-horizontal">
                    <div class="form-group">
            <label class="col-sm-3 control-label">Nama :<span class="required">*</span></label>
            <div class="col-sm-9">
            <input type="text" name="nama" class="form-control" value="'.$pecahuserlist['nama'].'" required/>
            <input type="hidden" name="userid" class="form-control" value="'.$pecahuserlist['userid'].'"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Email :<span class="required">*</span></label>
            <div class="col-sm-9">
            <input type="text" name="email" class="form-control" value="'.$pecahuserlist['email'].'" required/>
            </div>
          </div><br/>
        <footer class="panel-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <input type="submit" name="edituser" class="btn btn-primary">
                            <button type="reset" class="btn btn-default modal-dismiss">Cancel</button>
                        </div>
                    </div>
                </footer>
                </form>
        </div>
      </section>
    </div>
  </div>
  <div id="deleteuser'.$pecahuserlist['userid'].'" class="modal-block modal-block-warning modal-header-color mfp-hide">
<form id="form" method="post" class="form-horizontal">
                    <section class="panel">
                      <header class="panel-heading">
                        <h2 class="panel-title">Are you sure?</h2>
                      </header>
                      <div class="panel-body">
                        <div class="modal-wrapper">
                          <div class="modal-icon">
                            <i class="fa fa-question-circle"></i>
                          </div>
                          <div class="modal-text">
                            <h4>Delete '.$pecahuserlist['nama'].'</h4>
                            <p>Are you sure want to delete user '.$pecahuserlist['nama'].'?</p>
                          </div>
                        </div>
                      </div>
                      <footer class="panel-footer">
                        <div class="row">
                          <div class="col-md-12 text-right">
                          <div class="lokasi"></div>
                          <input name="usernama" type="hidden" value="'.$pecahuserlist['nama'].'">
                          <input name="userid" type="hidden" value="'.$pecahuserlist['userid'].'">
                            <button name="deleteuser" type="submit" class="btn btn-warning">Yes</button>
                            <button class="btn btn-default modal-dismiss">No</button>
                          </form>
                          </div>
                        </div>
                      </footer>
                    </section>
                  </div>';
                            }}?>
                    </tbody>
                </table>
            </div>
        </section>