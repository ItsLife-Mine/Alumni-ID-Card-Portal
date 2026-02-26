<?php
ob_start();
require __DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "config.php";
// HTML
require PATH_LIB . "page-top.php"; 
error_reporting(0);
$Token = base64_decode($_GET['in']);
$tokenAuth=$_GET['authToken'];

?>
  <script type="text/javascript">//<![CDATA[
    window.onload=function(){  
    }

  //]]></script>
    <script >
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Admin Dashboard
        <!--<small>Control panel</small> -->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Admin Dashboard</li>
      </ol>
    </section>
<?php 	
	  
	  $result = $DB_con->prepare("SELECT * FROM educationalqualification e, personalinformation p,finalsubmit f  where 
	  p.studentID = e.studentID
	  and e.status='ACTIVE'
	  and p.status='ACTIVE'
	  and f.studentID = p.studentID
	  and e.studentID =f.studentID
	  and p.studentID='$Token'
	  and e.studentID='$Token'");
                $result->execute();
                $rows = $result->fetch();
?>
    <!-- Main content -->
     <!-- Main content -->
    <section class="content" style="padding-left: 0px;  padding-right: 0px;">

      <!-- Default box -->
      <div class="box">

        <div class="box-body">
			<div class="col-sm-2">
			 <div class="box-header">
              <h3 class="box-title">
				 <button class="btn btn-primary hidden-print" onclick="printDiv('printableArea')"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
				</h3>
            </div>
			</div>
			<div class="col-sm-8">
           
            <div class="box-body" id="printableArea">
              
				<table class="table table-bordered">
					<tr>
                  <td colspan="2" style="text-align: center;"><img src="dist/img/logo.png" style="width: 335px;"></td>
                </tr>
              <tr>
                  <td><strong>Transaction ID</strong></td>
                  <td><?php echo $rows['transactionID']; ?></td>
                </tr>
                <tr>
                  <td><strong>Student Name</strong></td>
                  <td><?php echo $rows['studentName']; ?></td>
                </tr>
				  
				   <tr>
                  <td><strong>Mobile Number</strong></td>
                  <td><?php echo $rows['countryCode']; ?>- <?php echo $row['mobileNumber']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Alternate Contact</strong></td>
                  <td><?php echo $rows['altCountryCode']; ?>- <?php echo $row['alternateContact']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Current Address</strong></td>
                  <td><?php echo $rows['currentAddress']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Country</strong></td>
                  <td><?php echo $rows['country']; ?></td>
                </tr>
				   <tr>
                  <td><strong>State</strong></td>
                  <td><?php echo $rows['state']; ?></td>
                </tr>
				   <tr>
                  <td><strong>City</strong></td>
                  <td><?php echo $rows['district']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Postal Code</strong></td>
                  <td><?php echo $rows['postalCode']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Gender</strong></td>
                  <td><?php echo $rows['gender']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Date of birth</strong></td>
                  <td><?php echo $rows['dob']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Country of birth</strong></td>
                  <td><?php echo $rows['birthCountry']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Citizenship</strong></td>
                  <td><?php echo $rows['citizenship']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Email Id</strong></td>
                  <td><?php echo $rows['emailID']; ?></td>
                </tr>
				   <tr>
                  <td colspan="2"><h4><strong>Family Details Parent-I (Father/Mother)</strong></h4></td>
                </tr>
				   <tr>
                  <td><strong>Parent Name</strong></td>
                  <td><?php echo $rows['parentName1']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Mobile Number</strong></td>
                  <td><?php echo $rows['PcountryCode1']; ?>- <?php echo $rows['PmobileNumber1']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Current Address</strong></td>
                  <td><?php echo $rows['pcurrentAddress']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Country</strong></td>
                  <td><?php echo $rows['pCountry1']; ?></td>
                </tr>
				   <tr>
                  <td><strong>State</strong></td>
                  <td><?php echo $rows['pState1']; ?></td>
                </tr>
				   <tr>
                  <td><strong>City</strong></td>
                  <td><?php echo $rows['pdistrict1']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Postal Code</strong></td>
                  <td><?php echo $rows['ppostalCode1']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Citizenship</strong></td>
                  <td><?php echo $rows['pCitizenship1']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Email Id</strong></td>
                  <td><?php echo $rows['pEmailID']; ?></td>
                </tr>
				  <?php   if($rows['parentName2']<>'')
	  {?>
          
				   <tr>
                  <td colspan="2"><h4><strong>Family Details Parent-II (Father/Mother)</strong></h4></td>
                </tr>
				   <tr>
                  <td><strong>Parent Name</strong></td>
                  <td><?php echo $rows['parentName2']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Mobile Number</strong></td>
                  <td><?php echo $rows['pcountrycode2']; ?>- <?php echo $rows['pmobileNumber2']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Current Address</strong></td>
                  <td><?php echo $rows['pCurrentAddress2']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Country</strong></td>
                  <td><?php echo $rows['pCountry2']; ?></td>
                </tr>
				   <tr>
                  <td><strong>State</strong></td>
                  <td><?php echo $rows['pState2']; ?></td>
                </tr>
				   <tr>
                  <td><strong>City</strong></td>
                  <td><?php echo $rows['pdistrict2']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Postal Code</strong></td>
                  <td><?php echo $rows['ppostalCode2']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Citizenship</strong></td>
                  <td><?php echo $rows['pCitizenship2']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Email Id</strong></td>
                  <td><?php echo $rows['pEmailId2']; ?></td>
                </tr>
               <?php } ?>
            
              <tr>
                  <td><strong>College Name</strong></td>
                  <td><?php echo $rows['collegeName']; ?></td>
                </tr>
                <tr>
                  <td><strong>College Address</strong></td>
                  <td><?php echo $rows['collegeAddress']; ?></td>
                </tr>
				  
				   <tr>
                  <td><strong>Country</strong></td>
                  <td><?php echo $rows['ecountry']; ?></td>
                </tr>
				   <tr>
                  <td><strong>State</strong></td>
                  <td><?php echo $rows['estate']; ?></td>
                </tr>
				   <tr>
                  <td><strong>City</strong></td>
                  <td><?php echo $rows['edistrict']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Postal Code</strong></td>
                  <td><?php echo $rows['epostalCode']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Name of Degree</strong></td>
                  <td><?php echo $rows['nameofdegree']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Discipline</strong></td>
                  <td><?php echo $rows['discipline']; ?></td>
                </tr>
				   <tr>
                  <td><strong>% of Marks or CGPA</strong></td>
                  <td><?php echo $rows['aggregatePercentage']; ?></td>
                </tr>
                  <td colspan="2"><h4><strong>PG Informations</strong></h4></td>
                </tr>
				   <tr>
                  <td><strong>College Name</strong></td>
                  <td><?php echo $rows['pgcollegeName']; ?></td>
                </tr>
				   <tr>
                  <td><strong>College Address</strong></td>
                  <td><?php echo $rows['pgcollegeAddress']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Country</strong></td>
                  <td><?php echo $rows['pgCountry']; ?></td>
                </tr>
				   <tr>
                  <td><strong>State</strong></td>
                  <td><?php echo $rows['pgState']; ?></td>
                </tr>
				   <tr>
                  <td><strong>City</strong></td>
                  <td><?php echo $rows['pgDistrict']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Postal Code</strong></td>
                  <td><?php echo $rows['pgPostalCode']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Name of Degree</strong></td>
                  <td><?php echo $rows['pgNameofDegree']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Discipline</strong></td>
                  <td><?php echo $rows['pgDiscipline']; ?></td>
                </tr>
				   <tr>
                  <td><strong>% of Marks or CGPA</strong></td>
                  <td><?php echo $rows['pgAggregatePercentage']; ?></td>
                </tr>
				  <?php   if($rows['nOrganisation']<>'')
	  {?>
          
				   <tr>
                  <td colspan="2"><h4><strong>Professional Experience( if any)</strong></h4></td>
                </tr>
				 <tr>
                  <td colspan="2"><strong>Organisation Details Part-A</strong></td>
                </tr>
				   <tr>
                  <td><strong>Name of Organisation</strong></td>
                  <td><?php echo $rows['nOrganisation']; ?></td>
                </tr>
				   <tr>
                  <td colspan="2"><strong>Period</strong></td>
                </tr>
				   <tr>
                  <td><strong>From</strong></td>
                  <td><?php echo $rows['pFrom']; ?></td>
                </tr>
				   <tr>
                  <td><strong>To</strong></td>
                  <td><?php echo $rows['pTo']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Designation</strong></td>
                  <td><?php echo $rows['designation']; ?></td>
                </tr>
				   
               <?php } ?>
				  <?php   if($rows['nOrganisationB']<>'')
	  {?>
				 <tr>
                  <td colspan="2"><strong>Organisation Details Part-B</strong></td>
                </tr>
				   <tr>
                  <td><strong>Name of Organisation</strong></td>
                  <td><?php echo $rows['nOrganisationB']; ?></td>
                </tr>
				   <tr>
                  <td colspan="2"><strong>Period</strong></td>
                </tr>
				   <tr>
                  <td><strong>From</strong></td>
                  <td><?php echo $rows['pFromB']; ?></td>
                </tr>
				   <tr>
                  <td><strong>To</strong></td>
                  <td><?php echo $rows['pToB']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Designation</strong></td>
                  <td><?php echo $rows['designationB']; ?></td>
                </tr>
				   
               <?php } ?>
				 <?php   if($rows['awards']<>'')
	  {?>
				 <tr>
                  <td colspan="2"><strong>Awards Details</strong></td>
                </tr>
				<tr>
                  <td><strong>Awards</strong></td>
                  <td><?php echo $rows['awards']; ?></td>
                </tr>
				 <?php } ?>
             
						 <?php   if($rows['status']=='ACTIVE')
	  {?>
						<tr>
                  <td colspan="2"><strong>Declaration</strong></td>
                </tr>
              <tr>
                  <td><strong>Full Name</strong></td>
                  <td><?php echo $rows['FullName']; ?></td>
                </tr>
                <tr>
                  <td><strong>Place</strong></td>
                  <td><?php echo $rows['place']; ?></td>
                </tr>
				  
				   <tr>
                  <td><strong>Date</strong></td>
                  <td><?php echo $rows['date']; ?></td>
                </tr>
				   <tr>
                  <td><strong>Declaration</strong></td>
                  <td><?php echo $rows['declaration']; ?>,  Lorem Ipsum is simply dummy text of the printing and typesetting industry. </td>
                </tr>
				 <?php } ?>
				 </table>
				
            </div>
            <!-- /.box-body -->
          </div>
			<div class="col-sm-2">
		  </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->

	  
  </div>
  <!-- /.content-wrapper -->


   <?php  ob_end_flush(); require PATH_LIB . "page-bottom.php"; ?>

<script src="jquery.tableToExcel.js"></script>
