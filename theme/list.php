<html>
    <script src="jquery-datatables/js/jquery.dataTables.js"></script>
    <script src="jquery-datatables-bs3/js/datatables.js"></script>
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
   <tr class="gradeX">
                           <td data-title="Name"><a href=?hal=detail-leads&detail='.$kolomlist['id'].'>'.$kolomlist['nama'].' '.$kolomlist['lname'].'</a></td>
                           <td data-title="Date" value="'.$timeagos.'">'.$timeago.'</td>
                            <td data-title="Phone"><a href="tel:'.$kolomlist['phone'].'">'.$kolomlist['phone'].'</a></td>
                            <td data-title="email"><a href="mailto:'.$kolomlist['email'].'">'.$kolomlist['email'].'</a></td>
                            <td data-title="Sales">'.$sales['nama'].'</td>
                            <td data-title="Action"><a href="?hal=edit-leads&edit='.$kolomlist['id'].'"><i class="fa fa-edit"></i> Edit</a>
                           <span class=\"pull-right\"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>