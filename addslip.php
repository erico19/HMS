<?php
include("adheader.php");

check_admin();

if(isset($_POST['submit']))
{
	if(isset($_GET['editid']))
	{
	$sql ="UPDATE slip_registration SET patientname='{$_POST['patientname']}',organizationid='{$_POST['organizationid']}',address='{$_POST['address']}',mobileno='{$_POST['mobilenumber']}',city='{$_POST['city']}',pincode='{$_POST['pincode']}',loginid='{$_POST['loginid']}',password='{$_POST['password']}',bloodgroup='{$_POST['select2']}',gender='{$_POST['select3']}',dob='{$_POST['dateofbirth']}',status='{$_POST['status']}' WHERE patientid='{$_GET['editid']}'";
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
	$sql ="INSERT INTO slip_registration (patientid,doctorid,registration_date,slip_no,db) values('{$_POST['patientid']}','{$_POST['doctorid']}','{$_POST['registration_date']}','{$_POST['slip_no']}','{$_SESSION['userdb']}')";
		if($qsql = mysqli_query($con,$sql))
		{
		    $slipid = mysqli_insert_id($con);
		    $sql = "SELECT * FROM doctor WHERE doctorid='{$_POST['doctorid']}' && db='{$_SESSION['userdb']}'";
		    $qsql = mysqli_query($con,$sql);
		    $doctor = mysqli_fetch_array($qsql);
		    $servicetype = 'Consultancy Charge';
		    
		    $sql = "INSERT INTO billing (patientid,slipid,billingdate,billamount,edate,eby,db) VALUES ('{$_POST['patientid']}','$slipid','{$_POST['registration_date']}','{$doctor['consultancy_charge']}', '$current_timestamp','{$_SESSION['adminid']}','{$_SESSION['userdb']}') ";
            if($stmt=mysqli_query($con,$sql)){
                echo mysqli_error($con);
            }else{
                echo mysqli_error($con);
            }
            $billingid = mysqli_insert_id($con);
            $sql = "INSERT INTO billing_records ( billingid, bill_type_id, bill_type,bill_amount,bill_date,status,db)VALUES ('$billingid','{$doctor['doctorid']}','$servicetype','{$doctor['consultancy_charge']}','$current_date','Active','{$_SESSION['userdb']}')";
            if($billinsert = mysqli_query($con,$sql)){
                echo mysqli_error($con);
            }else{
                echo mysqli_error($con);
            }
            
			echo "<div class='alert alert-success'>
			patients record inserted successfully...
			</div>";
			//echo "<script>alert('patients record inserted successfully...');</script>";
			$insid= mysqli_insert_id($con);
			if(isset($_SESSION['adminid']))
			{
				//echo "<script>window.location='appointment.php?patid=$insid';</script>";	
			}
			else
			{
				//echo "<script>window.location='patientlogin.php';</script>";	
			}		
		}
		else
		{
			echo mysqli_error($con);
		}
	}
}
if(isset($_GET['editid']))
{
	$sql="SELECT * FROM slip_registration WHERE slipid='{$_GET['editid']}' && db='{$_SESSION['userdb']}' ";
	$qsql = mysqli_query($con,$sql);
	$rsedit = mysqli_fetch_array($qsql);
	
}

// Step 1: Retrieve the current date

// Step 2: Count today's registrations
$sql = "SELECT COUNT(*) AS daily_count FROM slip_registration WHERE DATE(registration_date) = '$current_date' && db='{$_SESSION['userdb']}'";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$daily_count = $row['daily_count'];

// Step 3: Generate slip number
$new_slip_no = $daily_count + 1;

?>


<div class="container-fluid">
    <div class="block-header">
        <h2>Slip Registration</h2>

    </div>
    <div class="card">

        <form method="post" action="" name="frmpatient" onSubmit="return validateform()" style="padding: 10px">


			<div class="col-sm-6 col-xs-12">
				<div class="form-group"><label>Select Patient</label> 
					<div class="form-line">
						<select  name="patientid" id="patientid" class="form-control show-tick">
							<option value="">Select Patient</option>
							<?php
							$sqlpatient= "SELECT * FROM patient WHERE status='Active' && db='{$_SESSION['userdb']}'";
							$qsqlpatient = mysqli_query($con,$sqlpatient);
							while($rspatient=mysqli_fetch_array($qsqlpatient))
							{
								if($rspatient['patientid'] == $rsedit['patientid'])
								{
									echo "<option value='{$rspatient['patientid']}' selected>{$rspatient['pcn']} - {$rspatient['patientname']}</option>";
								}
								else
								{
									echo "<option value='{$rspatient['patientid']}'>{$rspatient['pcn']} - {$rspatient['patientname']}</option>";
								}

							}
							?>
						</select>
					</div>
				</div>
			</div>
							<div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select name="doctorid" id="doctorid" class=" form-control show-tick">
                                            <option value="">Select Doctor</option>
                                            <?php
                                $sqldoctor= "SELECT * FROM doctor INNER JOIN department ON department.departmentid=doctor.departmentid WHERE doctor.status='Active' && doctor.db='{$_SESSION['userdb']}'";
                                $qsqldoctor = mysqli_query($con,$sqldoctor);
                                while($rsdoctor = mysqli_fetch_array($qsqldoctor))
                                {
                                   if($rsdoctor['doctorid'] == $rsedit['doctorid'])
                                   {
                                    echo "<option value='{$rsdoctor['doctorid']}' selected>{$rsdoctor['doctorname']} ( {$rsdoctor['departmentname']} ) </option>";
                                }
                                else
                                {
                                    echo "<option value='{$rsdoctor['doctorid']}'>{$rsdoctor['doctorname']} ( {$rsdoctor['departmentname']} )</option>";				
                                }
                            }
                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

            <div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Registration Data</label>
					<div class="form-line">
						<input class="form-control " type="datetime" name="registration_date" id="registration_date" value="<?php if(isset($_GET['editid'])){echo $rsedit['registration_date'];}else{echo $current_timestamp; } ?>">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="form-group">
					<label>Slip No</label>
					<div class="form-line">
						<input class="form-control " name="slip_no" id="slip_no" value="<?php if(isset($_GET['editid'])){echo $rsedit['slip_no'];}else{echo $new_slip_no; } ?>">
					</div>
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
    if (document.frmpatient.patientid.value == "") {
        alert("Patient name should not be empty..");
        document.frmpatient.patientid.focus();
        return false;
    }if (document.frmpatient.doctorid.value == "") {
        alert("Doctor name should not be empty..");
        document.frmpatient.doctorid.focus();
        return false;
    } else if (!document.frmpatient.patientid.value.match(numericExpression)) {
        alert("Patient name not valid..");
        document.frmpatient.patientid.focus();
        return false;
    }  else if (document.frmpatient.slip_no.value == "") {
        alert("Slip No should not be empty..");
        document.frmpatient.slip_no.focus();
        return false;
    }  else {
        return true;
    }
}
</script>