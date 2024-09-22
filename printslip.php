<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .container1 {
        width: 210mm;
        height: 297mm;
        padding: 10mm 10mm; /* Adjust left and right padding here */
        margin: 0;
    }
    .header {
        text-align: center;
        margin-bottom: 20px;
    }
    .header img {
        max-width: 100px;
    }
    .header h1 {
        margin: 0;
        font-size: 24px;
    }
    .header p {
        margin: 5px 0;
    }
    .content {
        margin-top: 20px;
    }
    .content h2 {
        font-size: 20px;
        margin-bottom: 10px;
    }
    .content p {
        margin: 5px 0;
    }
    .footer {
        position: absolute;
        bottom: 5mm;
        width: calc(100% - 20mm);
        text-align: center;
        font-size: 12px;
    }
    
    @media print{
        .noprint{
            display:none;
        }
    }
    
#watermark {
    
    position: absolute;
    top: 60%; /* Vertically centered */
    left: 10%; /* Horizontally centered */
    transform: translate(50%, 50%) rotate(-60deg); /* Rotate 45 degrees */
    font-size: 50px; /* Adjust font size */
    color: rgba(0, 0, 0, 0.2); /* Adjust color and opacity */
}
</style>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    
    
<style>
    .my-button {
            position: absolute;
            top: 10px;
            left: 10px;
            /* Other styles... */
        }

        /* Hide the button when printing */
        @media print {
            .my-button {
                display: none;
            }
        }
        
        @media print{
        .noprint{
            display:none;
        }
    }
</style>
<?php
//require_once("adheaderonly.php");
require_once("include/dbconnection.php");

if(isset($_GET['id']))
{
	$sql="SELECT * FROM slip_registration WHERE slipid='{$_GET['id']}' ";
	$qsql = mysqli_query($con,$sql);
	$rs = mysqli_fetch_array($qsql);
	
	$sql="SELECT * FROM db WHERE dbid='{$rs['db']}' ";
	$qsql = mysqli_query($con,$sql);
	$dbrs = mysqli_fetch_array($qsql);
	
	$sqlpatient ="SELECT * FROM patient WHERE patientid ='{$rs['patientid']}'";
	$qsqlpatient = mysqli_query($con,$sqlpatient);
	$rspatient = mysqli_fetch_array($qsqlpatient);
			
	$sqldoctor= "SELECT doctor.*, department.departmentname FROM doctor INNER JOIN department ON department.departmentid=doctor.departmentid WHERE doctorid='{$rs['doctorid']}'";
    $qsqldoctor = mysqli_query($con,$sqldoctor);
    $rsdoctor = mysqli_fetch_array($qsqldoctor);
	
	$dob = $rspatient['dob']; // Example DOB
    $age = date('Y') - date('Y', strtotime($dob));


$userInput = $rsdoctor['education']; // Example multiline input

// Convert newlines to HTML line breaks
$formattedInput = nl2br($userInput);




}
?>

    
<a href="viewslip" class="btn btn-info noprint">Go Back</a>
    <div class="container1">
        <div class="header">
            <img src="media/dblogo/<?php echo $rs['db'].'.jpg' ?>" alt="<?php echo $rs['dbshorttitle'] ?> Logo">
            <h2><?php echo $dbrs['dbtitle'] ?></h2>
            <p><?php echo $dbrs['address'] ?></p>
            <p>Phone: <?php echo $dbrs['phoneno'] ?> | Email: <?php echo $dbrs['email'] ?></p>
        </div>
        <hr>
    
        <div class="content">
            <div class="row">
                <div class="col col-sm-6">
                    <h3><?php echo $rsdoctor['doctorname'] ?></h3>
                    <p><?php echo $formattedInput; ?></p>
                    <p><strong>Departmet: </strong><?php echo $rsdoctor['departmentname']; ?></p>
                </div>
                <div class="col col-sm-6">
                    <p><strong>Slip #: </strong> <?php echo $rs['slip_no']; ?>
                    <strong>Date & Time:</strong> <?php echo $rs['registration_date']; ?></p>
                    
                    
                    <p><strong>MR #</strong> <?php echo $rspatient['pcn']; ?></p>
                    <p><strong>Patient Name </strong> <?php echo $rspatient['patientname']; ?></p>
                    <p><strong>Age:</strong> <?php echo $age." Y"; ?></p>
                    <p><strong>Gender:</strong> <?php echo $rspatient['gender']; ?></p>
                </div>
			</div>
			<hr>
			
			<div class="content">
			    
			    <div class="grid">
			    <div class="itemA  h-100" style="border-right:1px solid">
			        <u>VITALS</u><br>
			        BP<br>
			        Temp<br>
			        HR<br>
			        SPO<sub>2</sub><br><br><br><br>
			        LMP<br><br><br>
			        G.P<br>
			        <b><u>COMORBIDITY</u></b><br>
			        Pregnancy<br>
			        DM<br>
			        HTN<br>
			        HCV<br>
			        Allergy<br>
			        EDEMA<br>
			        Surgery<br><br>
			        <b><u>EXAMINATION</u></b><br>
			    </div>
			    <div class="itemB ">
			        <p>&nbsp;&nbsp; <h3>Rx</h3>
			        </p>
			        <div id="watermark">Not valid for Court</div>
			        
			        
			    </div>
			    </div>
			</div>
			
			
        </div>

        <div class="footer">
            <p>Attock Medical Centre - System Generated Slip </p>
        </div>
    </div>

<style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.grid {
  
  display: grid;
  grid-template-columns: auto 1fr auto;
  grid-gap: 10px;
  padding: 10px;
  padding-top:0px;
}



.itemA {
  grid-column-start: 1;
  grid-row: 1 / 1;
  width: 150px;
  height: 500px;
}

.itemB {
  grid-column-start: 2;
  grid-row: 1 / 1;
  width: 500px;
  height: 650px;
}

</style>
<script>
        function confirmDelete(event, url) {
            event.preventDefault(); // Prevent the default action
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = url; // Redirect to the delete URL
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.2/js/bootstrap.min.js"></script>
<?php
include("adformfooter.php");
?>

