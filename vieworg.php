<?php
require_once("adheader.php");

check_admin();
if(isset($_GET['delid']))
{
	$sql ="DELETE FROM organization WHERE organizationid='{$_GET['delid']}' AND db='{$_SESSION['userdb']}'";
	$qsql=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		//echo "<script>alert('patient record deleted successfully..');</script>";
	}
}
?>
<div class="container-fluid">
  <div class="block-header">
    <h2>View Organization records</h2>

  </div>

<div class="card">

  <section class="container">
    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">

      <thead>
        <tr>
          <th width="15%" height="30"><div align="center">Organization Name</div></th>
          <th width="20%"><div align="center">Contact</div></th>
          <th width="28%"><div align="center">Focal Person</div></th>    
          <th width="20%"><div align="center">Staus</div></th>
          <th width="17%"><div align="center">Action</div></th>
        </tr>
      </thead>
      <tbody>
       <?php
       $sql ="SELECT * FROM organization WHERE db='{$_SESSION['userdb']}'";
       $qsql = mysqli_query($con,$sql);
       while($rs = mysqli_fetch_array($qsql))
       {
			$sqlorg ="SELECT count(patientid) total FROM patient WHERE organizationid ='{$rs['organizationid']}' && db='{$_SESSION['userdb']}'";
			$qsqlorg = mysqli_query($con,$sqlorg);
			while($rsorg = mysqli_fetch_array($qsqlorg))
        echo "<tr>
        <td>{$rs['org_short_name']}<br>
        <strong>Full Name :</strong> {$rs['org_full_name']} </td>
        <td>
        <strong>Contact</strong>: &nbsp;{$rs['contact']}<br>
	   <strong>Address</strong>: &nbsp;{$rs['address']}</td>
        <td>$rs[focal_person]<br> Contact  &nbsp;{$rs['focal_person_contact']}</td>
        <td><strong>Employees</strong> - {$rsorg['total']}<br>
	   <strong>Pending Dues</strong> - &nbsp;{$rs['status']}</td>
	   <td align='center'>Status - {$rs['status']} <br>";
        if(isset($_SESSION['adminid']))
        {
		echo "<a href='addorg?editid={$rs['organizationid']}' class='btn btn-sm btn-raised g-bg-cyan'>Edit</a><a href='' onclick=\"confirmDelete(event, 'vieworg?delid={$rs['organizationid']}') \" class='btn btn-sm btn-raised g-bg-blush2'>Delete</a> <hr>
          <!--<a href='patientreport.php?orgid={$rs['organizationid']}' class='btn btn-sm btn-raised'>View Report</a>-->";
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