<?php
include("adheader.php");
//include("adformheader.php");

check_admin();		
if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
	$sql ="UPDATE patient SET patientname='{$_POST['patientname']}',organizationid='{$_POST['organizationid']}',address='{$_POST['address']}',mobileno='{$_POST['mobilenumber']}',city='{$_POST['city']}',bloodgroup='{$_POST['select2']}',gender='{$_POST['select3']}',dob='{$_POST['dateofbirth']}',status='{$_POST['status']}' WHERE patientid='{$_GET['editid']}' && db='{$_SESSION['userdb']}'";
		if($qsql = mysqli_query($con,$sql))
		{
			echo "<div class='alert alert-success'>
			patient record updated successfully...
			</div>";
			//echo "<script>alert('patient record updated successfully...');</script>";
		}
		else
		{
			echo mysqli_error($con);
		}	
	}
	else
	{
		
	$sql ="INSERT INTO patient(patientname,pcn, organizationid,address,mobileno,city,bloodgroup,gender,dob,status,familyid,relation,db) values('{$_POST['patientname']}','{$_POST['pcn']}','{$_POST['organizationid']}','{$_POST['address']}','{$_POST['mobilenumber']}','{$_POST['city']}','{$_POST['select2']}','{$_POST['select3']}','{$_POST['dateofbirth']}','Active','{$_POST['familyid']}','{$_POST['relation']}','{$_SESSION['userdb']}')";
		if($qsql = mysqli_query($con,$sql))
		{
			echo "<div class='alert alert-success'>
			patients record inserted successfully...
			</div>";
			//echo "<script>alert('patients record inserted successfully...');</script>";
			// after successful insert new row PCN will be incremented
			
			if(empty($_POST['familyid'])){
				$familyid= mysqli_insert_id($con);
				$sql = "UPDATE patient set familyid='$familyid' WHERE patientid='$familyid'";
				$qsql = mysqli_query($con,$sql);
			
			}
			$sql = "UPDATE pcn_sequence SET current_pcn = current_pcn + 1;";
			mysqli_query($con,$sql);
			
				
		}
		else
		{
			echo mysqli_error($con);
		}
	}
}

if(isset($_GET['editid']))
{
	$sql="SELECT * FROM patient WHERE patientid='{$_GET['editid']}' && db='{$_SESSION['userdb']}'";
	$qsql = mysqli_query($con,$sql);
	$rsedit = mysqli_fetch_array($qsql);
	
}
		// fetch PCN from PCN sequence table
		$sql = "SELECT current_pcn FROM pcn_sequence WHERE db='{$_SESSION['userdb']}'";
		$qsql = mysqli_query($con,$sql);
		$row = mysqli_fetch_array($qsql);
		$new_pcn = $row['current_pcn'];
?>


<div class="container-fluid">
    <div class="block-header">
        <h2>Patient Registration Panel</h2>

    </div>
    <div class="card">

        <form method="post" action="" name="frmpatient" onSubmit="return validateform()" style="padding: 10px">


            <div class="form-group"><label>Patient Control Number</label>
                <div class="form-line">
                    <input class="form-control" type="text" readonly name="pcn" id="pcn"
                        value="<?php if(isset($_GET['editid'])){echo $rsedit['pcn'];}else{echo $new_pcn;} ?>" />
                </div>
            </div>
			<div class="form-group"><label>Patient Name</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="patientname" id="patientname"
                        value="<?php if(isset($_GET['editid'])){echo $rsedit['patientname'];} ?>" />
                </div>
            </div>
			<div class="form-group"><label>Date Of Birth</label>
                <div class="form-line">
                    <input class="form-control" type="date" name="dateofbirth" max="<?php echo date("Y-m-d"); ?>"
                        id="dateofbirth" value="<?php echo $rsedit['dob']; ?>" />
                </div>
            </div>
			<div class="form-group"><label>Gender</label>
                <div class="form-line"><select class="form-control show-tick" name="select3" id="select3">
                        <option value="">Select</option>
                        <?php
				$arr = array("MALE","FEMALE");
				foreach($arr as $val)
				{
					if($val == $rsedit['gender'])
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
			<div class="form-group"><label>Mobile Number</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="mobilenumber" id="mobilenumber"
                        value="<?php if(isset($_GET['editid'])){echo $rsedit['mobileno'];} ?>" />
                </div>
            </div>
			<div class="form-group"><label>City</label>
                <div class="form-line">
                    <input class="form-control" type="text" name="city" id="city"
                        value="<?php if(isset($_GET['editid'])){echo $rsedit['city'];} ?>" />
                </div>
            </div>
			<div class="form-group">
                <label>Address</label>
                <div class="form-line">
                    <input class="form-control " name="address" id="tinymce" value="<?php if(isset($_GET['editid'])){echo $rsedit['address'];} ?>">
                </div>
            </div>
			
			<div class="form-group"><label>Panel Organization</label> 
				<div class="form-line">
					<select  name="organizationid" id="organizationid" class="form-control show-tick">
						<option value="">Select</option>
						<?php
						$sqldepartment= "SELECT * FROM organization WHERE status='Active' && db='{$_SESSION['userdb']}'";
						$qsqldepartment = mysqli_query($con,$sqldepartment);
						while($rsdepartment=mysqli_fetch_array($qsqldepartment))
						{
							if($rsdepartment['organizationid'] == $rsedit['organizationid'])
							{
								echo "<option value='{$rsdepartment['organizationid']}' selected>{$rsdepartment['org_short_name']}</option>";
							}
							else
							{
								echo "<option value='{$rsdepartment['organizationid']}'>{$rsdepartment['org_short_name']}</option>";
							}

						}
						?>
					</select>
				</div>
			</div>
			
			<div class="form-group"><label>Blood Group</label>
                <div class="form-line"><select class="form-control show-tick" name="select2" id="select2">
                        <option value="">Select</option>
                        <?php
					$arr = array("A+","A-","B+","B-","O+","O-","AB+","AB-");
					foreach($arr as $val)
					{
						if($val == $rsedit['bloodgroup'])
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
			
			<div class="form-group"><label>Family ID</label>
                <div class="form-line">
					<select  name="familyid" id="familyid" class="form-control show-tick">
						<option value="">Select</option>
						<?php
						$sqlfamily= "SELECT * FROM patient WHERE patientid=familyid && db='{$_SESSION['userdb']}'";
						$qsqlfamily = mysqli_query($con,$sqlfamily);
						while($rsfamily=mysqli_fetch_array($qsqlfamily))
						{
							if($rsfamily['familyid'] == $rsedit['familyid'])
							{
								echo "<option value='{$rsfamily['familyid']}' selected>{$rsfamily['pcn']} - {$rsfamily['patientname']}</option>";
							}
							else
							{
								echo "<option value='{$rsfamily['familyid']}'>{$rsfamily['pcn']} - {$rsfamily['patientname']}</option>";
							}

						}
						?>
					</select>
                </div>
            </div>
			
			<div class="form-group"><label>Relation</label>
                <div class="form-line">
					<select class="form-control show-tick" name="relation" id="relation">
                        <option value="">Select</option>
                        <?php
					$arr = array("Self","Spouse","Children","Parent");
					foreach($arr as $val)
					{
						if($val == $rsedit['relation'])
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


			
			<div class="form-group"><label>Status</label>
                <div class="form-line"><select class="form-control show-tick" name="status" id="status">
                        <option value="">Select</option>
                        <?php
				$arr = array("Active","Passive");
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
    } /* else if (document.frmpatient.address.value == "") {
        alert("Address should not be empty..");
        document.frmpatient.address.focus();
        return false;
    } 
    else if (document.frmpatient.mobilenumber.value == "") {
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
    } */
	
	/*else if (document.frmpatient.pincode.value == "") {
       /* alert("Pincode should not be empty..");
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
		
    }*/ 
	else if (document.frmpatient.select3.value == "") {
        alert("Gender should not be empty..");
        document.frmpatient.select3.focus();
        return false;
    } /*else if (document.frmpatient.dateofbirth.value == "") {
        alert("Date Of Birth should not be empty..");
        document.frmpatient.dateofbirth.focus();
        return false;
    }*/ 
    else if (document.frmpatient.relation.value == "") {
        alert("Kindly select the relation..");
        document.frmpatient.relation.focus();
        return false;
    } else {
        return true;
    }
}
</script>