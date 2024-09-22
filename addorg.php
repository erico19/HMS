<?php
require_once("adheader.php");

check_admin();

if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
	$sql ="UPDATE organization SET org_short_name='{$_POST['org_short_name']}',org_full_name='{$_POST['org_full_name']}',contact='{$_POST['contact']}',address='{$_POST['address']}',focal_person='{$_POST['focal_person']}',focal_person_contact='{$_POST['focal_person_contact']}',status='{$_POST['status']}',remarks='{$_POST['remarks']}' WHERE orgid='{$_GET['editid']}'";
		if($qsql = mysqli_query($con,$sql))
		{
			echo "<div class='alert alert-success'>
			Organization record updated successfully...
			</div>";
			//echo "<script>alert('Organization record updated successfully...');</script>";
		}
		else
		{
			echo mysqli_error($con);
		}	
	}
	else
	{
	$sql ="INSERT INTO organization(org_short_name,org_full_name,contact,address,focal_person,focal_person_contact,status,remarks,db) values('{$_POST['org_short_name']}','{$_POST['org_full_name']}','{$_POST['contact']}','{$_POST['address']}','{$_POST['focal_person']}','{$_POST['focal_person_contact']}','{$_POST['status']}','{$_POST['remarks']}','{$_SESSION['userdb']}')";
		if($qsql = mysqli_query($con,$sql))
		{
			echo "<div class='alert alert-success'>
			Organization record inserted successfully...
			</div>";
			//echo "<script>alert('');</script>";
			$insid= mysqli_insert_id($con);
		}
		else
		{
			echo mysqli_error($con);
		}
	}
}
if(isset($_GET['editid']))
{
	$sql="SELECT * FROM organization WHERE organizationid='{$_GET['editid']}' AND db='{$_SESSION['userdb']}' ";
	$qsql = mysqli_query($con,$sql);
	$rsedit = mysqli_fetch_array($qsql);
	
}
?>


<div class="container-fluid">
    <div class="block-header">
        <h2>Panel Organization Registration</h2>
    </div>
    <div class="card">

        <form method="post" action="" name="frmorganization" onSubmit="return validateform()" style="padding: 10px">



            <div class="form-group"><label>Organization Short Name</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="org_short_name" id="org_short_name"
                        value="<?php if(isset($_GET['editid'])){echo $rsedit['org_short_name'];} ?>" />
                </div>
            </div>
			<div class="form-group"><label>Organization Full Name</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="org_full_name" id="org_full_name"
                        value="<?php if(isset($_GET['editid'])){echo $rsedit['org_full_name'];} ?>" />
                </div>
            </div>
			<div class="form-group"><label>Contact Number</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="contact" id="contact"
                        value="<?php if(isset($_GET['editid'])){echo $rsedit['contact'];} ?>" />
                </div>
            </div>
			<div class="form-group"><label>Address</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="address" id="address"
                        value="<?php if(isset($_GET['editid'])){echo $rsedit['address'];} ?>" />
                </div>
            </div>
			<div class="form-group"><label>Focal Person</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="focal_person" id="focal_person"
                        value="<?php if(isset($_GET['editid'])){echo $rsedit['focal_person'];} ?>" />
                </div>
            </div>
			<div class="form-group"><label>Focal Person Contact#</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="focal_person_contact" id="focal_person_contact"
                        value="<?php if(isset($_GET['editid'])){echo $rsedit['focal_person_contact'];} ?>" />
                </div>
            </div>
			
            <div class="form-group"><label>Panel Status</label>
                <div class="form-line"><select class="form-control show-tick" name="status" id="status">
                        <option value="">Select</option>
                        <?php
					$arr = array("Active","Passive","On-Hold","Under Process");
					foreach($arr as $val)
					{
						if($val == $rsedit['status'])
						{
							echo "<option value='$val' selected>$val</option>";
						}
						else
						{
							echo "<option value='$val'>$val</option>";			  
						}
					}
					?>
                    </select>
                </div>
            </div>
			<div class="form-group"><label>Remarks</label>
                <div class="form-line">
					<textarea rows="4" class="form-control no-resize" name="remarks"
                                id="remarks"><?php if(isset($_GET['editid'])){echo $rsedit['remarks'];} ?></textarea>
                </div>
            </div>

            <input class="btn btn-default" type="submit" name="submit" id="submit" value="Submit" />




        </form>
        <p>&nbsp;</p>
    </div>
</div>
</div>
<div class="clear"></div>
</div>
</div>
<?php
include("adformfooter.php");
?>
<script type="application/javascript">
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphanumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 

function validateform() {
    if (document.frmpatient.patientname.value == "") {
        alert("Patient name should not be empty..");
        document.frmpatient.patientname.focus();
        return false;
    } else if (!document.frmpatient.patientname.value.match(alphaspaceExp)) {
        alert("Patient name not valid..");
        document.frmpatient.patientname.focus();
        return false;
    } else if (document.frmpatient.admissiondate.value == "") {
        alert("Admission date should not be empty..");
        document.frmpatient.admissiondate.focus();
        return false;
    } else if (document.frmpatient.admissiontme.value == "") {
        alert("Admission time should not be empty..");
        document.frmpatient.admissiontme.focus();
        return false;
    } else if (document.frmpatient.address.value == "") {
        alert("Address should not be empty..");
        document.frmpatient.address.focus();
        return false;
    } else if (document.frmpatient.mobilenumber.value == "") {
        alert("Mobile number should not be empty..");
        document.frmpatient.mobilenumber.focus();
        return false;
    } else if (!document.frmpatient.mobilenumber.value.match(numericExpression)) {
        alert("Mobile number not valid..");
        document.frmpatient.mobilenumber.focus();
        return false;
    } else if (document.frmpatient.city.value == "") {
        alert("City should not be empty..");
        document.frmpatient.city.focus();
        return false;
    } else if (!document.frmpatient.city.value.match(alphaspaceExp)) {
        alert("City not valid..");
        document.frmpatient.city.focus();
        return false;
    } else if (document.frmpatient.pincode.value == "") {
        alert("Pincode should not be empty..");
        document.frmpatient.pincode.focus();
        return false;
    } else if (!document.frmpatient.pincode.value.match(numericExpression)) {
        alert("Pincode not valid..");
        document.frmpatient.pincode.focus();
        return false;
    } else if (document.frmpatient.loginid.value == "") {
        alert("Login ID should not be empty..");
        document.frmpatient.loginid.focus();
        return false;
    } else if (!document.frmpatient.loginid.value.match(alphanumericExp)) {
        alert("Login ID not valid..");
        document.frmpatient.loginid.focus();
        return false;
    } else if (document.frmpatient.password.value == "") {
        alert("Password should not be empty..");
        document.frmpatient.password.focus();
        return false;
    } else if (document.frmpatient.password.value.length < 8) {
        alert("Password length should be more than 8 characters...");
        document.frmpatient.password.focus();
        return false;
    } else if (document.frmpatient.password.value != document.frmpatient.confirmpassword.value) {
        alert("Password and confirm password should be equal..");
        document.frmpatient.confirmpassword.focus();
        return false;
    } else if (document.frmpatient.select2.value == "") {
        alert("Blood Group should not be empty..");
        document.frmpatient.select2.focus();
        return false;
    } else if (document.frmpatient.select3.value == "") {
        alert("Gender should not be empty..");
        document.frmpatient.select3.focus();
        return false;
    } else if (document.frmpatient.dateofbirth.value == "") {
        alert("Date Of Birth should not be empty..");
        document.frmpatient.dateofbirth.focus();
        return false;
    } else if (document.frmpatient.select.value == "") {
        alert("Kindly select the status..");
        document.frmpatient.select.focus();
        return false;
    } else {
        return true;
    }
}
</script>