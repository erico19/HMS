<?php
include("adheader.php");

check_admin();

if(isset($_GET['delid']))
{
	$sql ="DELETE FROM slip_registration WHERE slipid='{$_GET['delid']}' AND db='{$_SESSION['userdb']}'";
	$qsql=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		//echo "<script>alert('patient record deleted successfully..');</script>";
	}
}
if(isset($_POST['fileupload'])){
	
	//$filename = rand(). $_FILES['uploads']['name'];
	$filename = $_POST['fileid'];
	move_uploaded_file($_FILES['uploads']['tmp_name'],"slipfiles/".$filename);
}
?>
<div class="container-fluid">
  <div class="block-header">
    <h2>View Slip records</h2>

  </div>

<div class="card">

  <section class="container">
    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">

      <thead>
        <tr>
          <th width="" height="30"><div align="center">Patient Name</div></th>
          <th width=""><div align="center">Doctor Name</div></th>
          <th width=""><div align="center">Date</div></th>    
          <th width=""><div align="center">Slip No</div></th>
		  <th width="10%"><div align="center">File</div></th>
          <th width=""><div align="center">Action</div></th>
        </tr>
      </thead>
      <tbody>
       <?php
	   
       $sql ="SELECT * FROM slip_registration WHERE db='{$_SESSION['userdb']}'";
       $qsql = mysqli_query($con,$sql);
       while($rs = mysqli_fetch_array($qsql))
       {
			$sqlpatient ="SELECT * FROM patient WHERE patientid ='{$rs['patientid']}' AND db='{$_SESSION['userdb']}'";
			$qsqlpatient = mysqli_query($con,$sqlpatient);
			$rspatient = mysqli_fetch_array($qsqlpatient);
			
			$sqldoctor= "SELECT * FROM doctor INNER JOIN department ON department.departmentid=doctor.departmentid WHERE doctorid='{$rs['doctorid']}' AND doctor.db='{$_SESSION['userdb']}'";
            $qsqldoctor = mysqli_query($con,$sqldoctor);
            $rsdoctor = mysqli_fetch_array($qsqldoctor);
        echo "<tr>
        <td>{$rspatient['patientname']}</td>
		<td>{$rsdoctor['doctorname']} - {$rsdoctor['departmentname']}</td>
		<td>{$rs['registration_date']}</td>
		<td>{$rs['slip_no']}</td>
        <td>";
		?>
		<form method="post" enctype="multipart/form-data">
			<input type="text" name="fileid" class="form-control" value="<?php echo $rs['slipid'] ?>" hidden="">
			<input type="file" name="uploads">
			<input type="submit" name="fileupload" value="Upload" class="btn btn-sm btn-raised">
		</form>
		<?php 
		echo"{$rs['slipid']} - <a href='slipfiles/{$rs['slipid']}'>Download</a></td>";
		if(isset($_SESSION['adminid']))
        {
		echo "<td>
		    <a href='treatmentrecord?slipid={$rs['slipid']}' class='btn btn-sm g-bg-cyan'>Add treatment</a>
		    <a href='addslip?editid={$rs['slipid']}' class='btn btn-sm  '><i class='zmdi zmdi-edit'></i></a>
			<a href='printslip?id={$rs['slipid']}' class='btn btn-sm '><i class='zmdi zmdi-print' ></i></a>
			<!---<a href='' onclick=\"confirmDelete(event, 'viewslip?delid={$rs['slipid']}') \" class='btn btn-sm btn-raised g-bg-blush2'>Delete</a> <hr>---->
          <!--<a href='patientreport?orgid={$rs['slipid']}' class='btn btn-sm btn-raised'>View Report</a>-->";
        }
        echo "</td></tr>";
      }
      ?>
    </tbody>
  </table>
</section>

</div>
</div>
<script>
        function confirmDelete(event, url) {
            event.preventDefault(); // Prevent the default action
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = url; // Redirect to the delete URL
            }
        }
    </script>
<?php
include("adformfooter.php");
?>