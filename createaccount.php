<?php
session_start();

error_reporting(1);
include("include/dbconnection.php");

?>
<!-- header section -->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>HMS - Admin Login</title>
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- Custom Css -->
<link href="assets/css/main.css" rel="stylesheet">
<link href="assets/css/login.css" rel="stylesheet">

<!-- Swift Themes. You can choose a theme from css/themes instead of get all themes -->
<link href="assets/css/themes/all-themes.css" rel="stylesheet" />
</head>
<body class="theme-cyan login-page authentication">
<!-- header section -->
<style>
    .card {
    position: relative;
    background: #ffffff;
    border-radius: 5px;
    padding: 30px 0 10px 0;
    }
</style>
<?php
if(isset($_SESSION['adminid']))
{
	echo "<script>window.location='dashboard';</script>";
}
$err='';


if(isset($_POST['register'])){
    $err= 1;
    $query = "SELECT * FROM admin WHERE email='{$_POST['email']}'";
    $stmt = mysqli_query($con,$query);
    $row = mysqli_fetch_array($stmt);
    
    if(empty($row['email'])){
    
   
    $query = "INSERT into db (status, edate) VALUES ('Active','$current_timestamp')";
    if(mysqli_query($con,$query)){
        $err = "<div class='alert alert-success'>
		<strong>Hurrah !</strong> DB Successfully created
	    </div>";
	    $dbid = mysqli_insert_id($con);
    }else{
        $err = "<div class='alert alert-danger'>
		<strong>Hurrah !</strong>  DB error
	    </div>";
    }
   
    $pwd=base64_encode($_POST['password']);
    $stmt = mysqli_query($con,"INSERT into admin (email, password,status,db) VALUES ('{$_POST['email']}','$pwd','Active','$dbid')");
    if($stmt){
        $err = "<div class='alert alert-success'>
		<strong>Hurrah !</strong> Successfully created
	    </div>";
    }else{
        echo mysqli_error($con);
        $err = "<div class='alert alert-success'>
		<strong>Hurrah !</strong> Successfully created error
	    </div>";
    }
    $stmt = mysqli_query($con,"INSERT INTO pcn_sequence (current_pcn,db) VALUES (1,'$dbid')");
    mysqli_query($con,$stmt);
//<!-------------------Email------>

require_once("phpmailer/Exception.php");                    
require_once("phpmailer/SMTP.php");                     
require_once("phpmailer/PHPMailer.php");                    

//---------------EMAIL VARIABLES--------------//
$adminusername='soluxion';
$adminpassword='9*Cy!VX0enuZ88';
$hostname='sv93.ifastnet.com';
$setfrom='info@soluxionz.com';
$emailsubject='Proshop (POS) - Software as a Service';
$port='290';


$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = $hostname;
$mail->Port = $port; // or 587
$mail->IsHTML(true);
$mail->Username = $adminusername;
$mail->Password = $adminpassword;
$mail->SetFrom($setfrom);
$mail->Subject = $emailsubject;
$mail->Body = "Congratulations - Your Account has been Created.</br> Login Detail: </br> Username: '{$_POST['email']}' </br> Password: '{$_POST['password']}'";
$mail->AddAddress("{$_POST['email']}");

if($mail->send()){
    //echo "email Send!!";
}else{
    echo "not send.".$mail->ErrorInfo;
}


}else{
        $err = "<div class='alert alert-danger'>
		<strong>Oh !</strong> Email already exists
	    </div>";
      
        //goto ten;
    }
 
//<!-------------------Email------!>
//<!-------------------Email------!>

            } ;

ten:
?> 

<div class="container">
	<div id = "err"><?php echo $err;
	
?></div>
    <div class="card-top"></div>
    <div class="card">
        <h2 class="title"><span>Hospital Management System</span>Account Registration <span class="msg">Provide information to create your account</span></h2>
        <div class="col-md-12">

    <form method="post" action="" name="frmregister" id="sign_in" onSubmit="return validateform()">
    <div class="input-group"> <span class="input-group-addon"> <i class="zmdi zmdi-account"></i> </span>
                    <div class="form-line">
					<input type="text" name="email" id="email" class="form-control" placeholder="Email" /></div>
                </div>
                <div class="input-group"> <span class="input-group-addon"> <i class="zmdi zmdi-lock"></i> </span>
                    <div class="form-line">
					<input type="password" name="password" id="password" class="form-control"  placeholder="Password" /> </div>
                </div>
                <div class="input-group"> <span class="input-group-addon"> <i class="zmdi zmdi-lock"></i> </span>
                    <div class="form-line">
					<input type="password" name="confirmpassword" id="confirmpassword" class="form-control"  placeholder="Confirm Password" /> </div>
                </div>
                <div>
                    
                    <div class="text-center">
					<input type="submit" name="register" id="register" value="Register" class="btn btn-raised waves-effect g-bg-cyan" /></div>
                    
                    <div class="text-left"> 
                        <a class="btn btn-sm btn-info btn-raised waves-effect float-left " href="forgot-password.html">Demo </a>
                        <a class="btn btn-sm btn-info btn-raised waves-effect float-right" href="login">Login</a>
                    </div>
                </div>
            </form>
        </div>
        
    </div>    
    
</div>

 <div class="clear"></div>
 <div class="theme-bg"></div>
  </div>
</div>
<!-- Jquery Core Js --> 
<script src="assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->

<script src="assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
</body>
</html>
<script type="application/javascript">
var alphaExp = /^[a-zA-Z]+$/; //Variable to validate only alphabets
var alphaspaceExp = /^[a-zA-Z\s]+$/; //Variable to validate only alphabets and space
var numericExpression = /^[0-9]+$/; //Variable to validate only numbers
var alphanumericExp = /^[0-9a-zA-Z]+$/; //Variable to validate numbers and alphabets
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/; //Variable to validate Email ID 

function validateform()
{
	if(document.frmregister.email.value == "")
	{
		document.getElementById("err").innerHTML ="<div class='alert alert-info'><strong>Heads up!</strong> Please enter Email</div>";
		document.frmregister.email.focus();
		return false;
	}
	else if(!document.frmregister.email.value.match(emailExp))
	{
		document.getElementById("err").innerHTML ="<div class='alert alert-info'><strong>Alert!</strong> Please enter valid email</div>";
		document.frmregister.email.focus();
		return false;
	}
	
	else if(document.frmregister.password.value == "")
	{
		document.getElementById("err").innerHTML ="<div class='alert alert-info'><strong>Heads up!</strong> Should not be empty</div>";
		document.frmregister.password.focus();
		return false;
	}
	else if(document.frmregister.password.value.length < 8)
	{
		document.getElementById("err").innerHTML ="<div class='alert alert-info'><strong>Heads up!</strong> Length should be 8</div>";
		document.frmregister.password.focus();
		return false;
	}
	else if(document.frmregister.confirmpassword.value == "")
	{
		document.getElementById("err").innerHTML ="<div class='alert alert-info'><strong>Heads up!</strong> Should not be empty</div>";
		document.frmregister.confirmpassword.focus();
		return false;
	}
	else if(document.frmregister.confirmpassword.value != document.frmregister.password.value)
	{
		document.getElementById("err").innerHTML ="<div class='alert alert-info'><strong>Heads up!</strong> Password not matched</div>";
		document.frmregister.confirmpassword.focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>