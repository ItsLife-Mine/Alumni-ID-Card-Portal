<?php
ob_start();
require __DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "config.php";
// HTML
require PATH_LIB . "page-top.php";
$tokenAuth = $row[ 'authtokenid' ];

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Admin Dashboard 
      <!--<small>Control panel</small> --> 
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Admin Dashboard</li>
    </ol>
  </section>
  <?php

  $staff = $DB_con->prepare( "SELECT * FROM personalinformation " );
  $staff->execute();
  $staffrow = $staff->fetch();
  $staffrow[ 'status' ];
  
  $af = $DB_con->prepare( "SELECT * FROM applicationfees " );
  $af->execute();
  $afrow = $af->fetch();
  $afrow[ 'paymentStatus' ];

  ?>
  <!-- /.content -->
  
  <section class="content">
    <div class="row">
      <div class="col-xs-12" style="padding-left: 0px;  padding-right: 0px;">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">
              <center>
                <strong>Submitted Applications List</strong>
              </center>
            </h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped" style="overflow:scroll;">
              <thead>
                <tr>
                  <th>Student Name</th>
                  <th>Email ID</th>
                  <th>Mobile Number</th>
                  <th>Institution Name</th>
                  <th>Department</th>
					<th>Your Title</th>
                  <th>Institution Type</th>
					<th>First Choice</th>
					<th>How Many Times</th>
					<th>Second Choice</th>
					<th>How Many Times</th>
					<th>Fee Cover by</th>
					<th>Approver Email</th>
					<th>Approver Title</th>
					<!--<th>Approver Other Title</th> -->
                  <!--<th>Application Status</th>
                  <th>Action</th> -->
				  <!--<th>Fee Status</th> -->
                </tr>
              </thead>
              <tbody>
                <?php

               // $resultaf = $DB_con->prepare( "SELECT * FROM applicationfees" );
               // $resultaf->execute();
               // for ( $i = 0; $rowaf = $resultaf->fetch(); $i++ ) {


                  ?>
				  
				  <?php

                $result = $DB_con->prepare( "SELECT * FROM personalinformation " );
                $result->execute();
                for ( $i = 0; $row = $result->fetch(); $i++ ) {

                  ?>
                
				  
				  <?php ?>
                <tr class="delete_mem<?php echo $row['PID']; ?>">
                  <td><?php echo $row ['studentName']; ?></td>
                  <td><?php echo $row ['emailID']; ?></td>
                  <td><?php echo $row ['countryCode']; ?> <?php echo $row ['mobileNumber']; ?></td>
                  <td><?php echo $row ['institutionName']; ?></td>
                  <td><?php echo $row ['department']; ?></td>
                  <td><?php echo $row ['yourTitle']; ?></td>
                  <td><?php echo $row ['institutionType']; ?></td>
                  <td><?php echo $row ['firstChoice']; ?></td>
                  <td><?php echo $row ['howManyTimes']; ?></td>
                  <td><?php echo $row ['secondChoice']; ?></td>
                  <td><?php echo $row ['howManyTimes2']; ?></td>
                  <td><?php echo $row ['feecover']; ?></td>
				  <td><?php echo $row ['approverEmail']; ?></td>
                  <td><?php echo $row ['approverTitle']; echo $row ['approverOtherTitle']; ?></td>
                  <!--<td><?php echo $row ['approverOtherTitle']; ?></td> -->
                  <!--<td><?php echo $row ['applicationStatus']; ?></td>
                  <td><a href="#" id="<?php echo $row['PID']; ?>" class="trash">Approve</a> | <a href="#" id="<?php echo $row['PID']; ?>" class="trashD">Disapprove</a></td> -->
				  <!--<td><?php echo $afrow[ 'paymentStatus' ]; ?></td> -->
                </tr>
                <?php  } ?>
                </tfoot>
                
            </table>
            <div class="form-group"> 
              <form class="form-horizontal" action="exportcseduApplicatonDetails.php" method="post" name="upload_excel"   
                      enctype="multipart/form-data">
                  <div class="form-group">
                          <input type="submit" name="Export" onclick="Export()"  style="margin-left: 20px;" class="btn btn-success" value="Export to Excel"/>
                           
                   </div>                    
            </form>  
            </div>
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
  </section>
</div>
<script  src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script type="text/javascript">
	$(function(){
    $(document).on('click','.trash',function(){
        var del_id= $(this).attr('id');
        var $ele = $(this).parent().parent();
		if(confirm("Are you sure want to Approve this record?")){
        $.ajax({
            type:'POST',
            url:'delete_member.php',
            data:{'del_id':del_id},
            success:function(html){
		//$(".delete_mem" + del_id).fadeOut('slow');
			window.location.reload()
             }

            });
		}else{
		return false;	
		}
        });
});
$(function(){
    $(document).on('click','.trashD',function(){
        var del_idD= $(this).attr('id');
        var $eleD = $(this).parent().parent();
		if(confirm("Are you sure want to Disapprove this record?")){
        $.ajax({
            type:'POST',
            url:'delete_memberD.php',
            data:{'del_idD':del_idD},
            success:function(html){
		//$(".delete_mem" + del_idD).fadeOut('slow');
			window.location.reload()
             }

            });
		}else{
		return false;	
		}
        });
});
</script>
<?php ob_end_flush(); require PATH_LIB . "page-bottom.php"; ?>
