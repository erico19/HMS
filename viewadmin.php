<?php
require_once("adheader.php");

check_admin();

if(isset($_GET['delid']))
{
	$sql ="DELETE FROM admin WHERE adminid='{$_GET['delid']}' AND db='{$_SESSION['userdb']}'";
	$qsql=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<div class='alert alert-danger'>
		admin record deleted successfully..
		</div>";
	}
}
?>

<div class="container-fluid">
  <div class="block-header">
    View Adminstrator Record
  </div>
</div>
<div class="card">
  <section class="container">
   <table class="table table-bordered table-striped table-hover js-basic-example dataTable">


    <thead>
      <tr>
        <td width="12%" height="40">Admin Name</td>
        <td width="11%">Email</td>
        <td width="12%">Status</td>
        <td width="10%">Action</td>
      </tr>
    </thead>
    <tbody>
     <?php
     echo $_SESSION['userdb'];
     
     $sql ="SELECT * FROM admin WHERE db='{$_SESSION['userdb']}'";
     $qsql = mysqli_query($con,$sql);
     while($rs = mysqli_fetch_array($qsql))
     {
      echo "<tr>
      <td>{$rs['adminname']}</td>
      <td>{$rs['email']}</td>
      <td>{$rs['status']}</td>
      <td>
      <a href='admin?editid={$rs['adminid']}' class='btn btn-raised g-bg-cyan'>Edit</a> <a onclick=\"confirmDelete(event, 'viewadmin?delid={$rs['adminid']}')\" href='' class='btn btn-raised g-bg-blush2'>Delete</a> </td>
      </tr>";
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