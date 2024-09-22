<?php
require_once("adheader.php");

check_admin();

if(isset($_POST['submit']))
{
	
			$sql ="UPDATE db SET dbname='{$_POST['dbname']}',dbtitle='{$_POST['dbtitle']}',dbshorttitle='{$_POST['dbshorttitle']}',address='{$_POST['address']}',phoneno='{$_POST['phoneno']}',email='{$_POST['email']}' WHERE dbid='{$_SESSION['userdb']}'";
			
        	//$filename = rand(). $_FILES['uploads']['name'];
        	$filename = $_SESSION['userdb'].".jpg";
        	move_uploaded_file($_FILES['uploads']['tmp_name'],"media/dblogo/".$filename);
		if($qsql = mysqli_query($con,$sql))
		
		{
			echo "<script>alert('record updated successfully...');</script>";
		}
		else
		{
			echo mysqli_error($con);
		}	

}
if(isset($_SESSION['userdb']))
{
    $_GET['editid'] = $_SESSION['userdb'];
	$sql="SELECT * FROM db WHERE dbid='{$_SESSION['userdb']}' ";
	$qsql = mysqli_query($con,$sql);
	$rsedit = mysqli_fetch_array($qsql);
	
}
?>


<div class="container-fluid">
	<div class="block-header">
            <h2>Hospital Profile </h2>
            
        </div>
  <div class="card">

    <form method="post" action="" name="frmdept" enctype="multipart/form-data" onSubmit="return validateform()">
    <table class="table table-hover">
      <tbody>
        <tr>
          <td width="34%">Hospital Name</td>
          <td width="66%"><input placeholder=" Enter Here " class="form-control" type="text" name="dbname" id="dbname" value="<?php if(isset($_GET['editid'])){echo $rsedit['dbname'];} ?>" /></td>
        </tr>
        <tr>
          <td width="34%">Hospital Name for Billing</td>
          <td width="66%"><input placeholder=" Enter Here " class="form-control" type="text" name="dbtitle" id="dbtitle" value="<?php if(isset($_GET['editid'])){echo $rsedit['dbtitle'];} ?>" /></td>
        </tr>
        <tr>
          <td>Hospital Short Name</td>
          <td><textarea placeholder=" Enter Here " class="form-control no-resize" name="dbshorttitle" id="dbshorttitle" cols="45" rows="5"><?php if(isset($_GET['editid'])){echo $rsedit['dbshorttitle'] ;} ?></textarea></td>
        </tr>
        <tr>
          <td>Hospital Address</td>
          <td><textarea placeholder=" Enter Here " class="form-control no-resize" name="address" id="address" cols="45" rows="5"><?php if(isset($_GET['editid'])){echo $rsedit['address'] ;} ?></textarea></td>
        </tr>
        <tr>
          <td>Hospital Phone Nos</td>
          <td><textarea placeholder=" Enter Here " class="form-control no-resize" name="phoneno" id="phoneno" cols="45" rows="5"><?php if(isset($_GET['editid'])){echo $rsedit['phoneno'] ;} ?></textarea></td>
        </tr>
        <tr>
          <td>Hospital Email</td>
          <td><textarea placeholder=" Enter Here " class="form-control no-resize" name="email" id="email" cols="45" rows="5"><?php if(isset($_GET['editid'])){echo $rsedit['email'] ;} ?></textarea></td>
        </tr>
        <tr>
          <td>Hospital Logo</td>
          <td> 
            <input type="file" name="uploads">
            <img src='media/dblogo/<?php echo $_SESSION['userdb'].".jpg"?>'></img>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center"><input class="btn btn-default" type="submit" name="submit" id="submit" value="Submit" /></td>
        </tr>
      </tbody>
    </table>
    </form>
    <p>&nbsp;</p>
  </div>
</div>
</div>
 <div class="clear"></div>
  </div>
</div>
<?php
include("adfooter.php");
?>
<script type="application/javascript">
var alphaExp = /^['a-zA-Z']+$/; //Variable to validate only alphabets
var alphaspaceExp = /^['a-zA-Z\s']+$/; //Variable to validate only alphabets and space
var numericExpression = /^['0-9']+$/; //Variable to validate only numbers
var alphanumericExp = /^['0-9a-zA-Z']+$/; //Variable to validate numbers and alphabets
var emailExp = /^['\w\-\.\+']+\@['a-zA-Z0-9\.\-']+\.['a-zA-z0-9']{2,4}$/; //Variable to validate Email ID 

function validateform()
{
	if(document.frmdept.departmentname.value == "")
	{
		alert("Department name should not be empty..");
		document.frmdept.departmentname.focus();
		return false;
	}
	else if(!document.frmdept.departmentname.value.match(alphaExp))
	{
		alert("Department name not valid..");
		document.frmdept.departmentname.focus();
		return false;
	}
	else if(document.frmdept.select.value == "" )
	{
		alert("Kindly select the status..");
		document.frmdept.select.focus();
		return false;
	}
	
	else
	{
		return true;
	}
}
</script>