<?php
require_once("adheader.php");

//session_start();

check_admin();

?>


<div class="container-fluid">
    <div class="block-header">
        <h2>Dashboard</h2>
        <small class="text-muted">Welcome to Admin Panel</small>
    </div>


    <div class="row clearfix">
        
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <a href="viewpatient"><div class="icon"> <i class="zmdi zmdi-account col-blue"></i> </div></a>
                <div class="content">
                    <div class="text">Total Patient</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM patient WHERE status='Active' && db='{$_SESSION['userdb']}'";
                        $qsql = mysqli_query($con,$sql);
                        echo mysqli_num_rows($qsql);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <a href="viewdoctor"><div class="icon"> <i class="zmdi zmdi-account col-green"></i> </div></a>
                <div class="content">
                    <div class="text">Total Doctor </div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM doctor WHERE status='Active' && db='{$_SESSION['userdb']}'";
                        $qsql = mysqli_query($con,$sql);
                        echo mysqli_num_rows($qsql);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <a href="viewadmin"><div class="icon"> <i class="zmdi zmdi-bug col-blush"></i> </div></a>
                <div class="content">
                    <div class="text">Performing Admin</div>
                    <div class="number">
                        <?php
                        $sql = "SELECT * FROM admin WHERE status='Active' && db='{$_SESSION['userdb']}'";
                        $qsql = mysqli_query($con,$sql);
                        echo mysqli_num_rows($qsql);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-money col-cyan"></i> </div>
                <div class="content">
                    <div class="text">Pending Bills</div>
                    <div class="number">PKR 
                        <?php 
                            $sql = "SELECT sum(billamount) as total  FROM `billing` && db='{$_SESSION['userdb']}' ";
                            $qsql = mysqli_query($con,$sql);
                            while (@$row = mysqli_fetch_assoc($qsql))
                            { 
                                echo $row['total'];
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-balance col-cyan"></i> </div>
                <div class="content">
                    <div class="text">Panel Organizations</div>
                    <div class="number"> 
                        <?php
                        $sql = "SELECT * FROM organization WHERE db='{$_SESSION['userdb']}' ";
                        $qsql = mysqli_query($con,$sql);
                        echo mysqli_num_rows($qsql);
                        $sql = "SELECT * FROM organization WHERE status='Active' && db='{$_SESSION['userdb']}'";
                        $qsql = mysqli_query($con,$sql);
                        echo " / ".mysqli_num_rows($qsql);
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6">
            <div class="info-box-4 hover-zoom-effect">
                <div class="icon"> <i class="zmdi zmdi-receipt col-cyan"></i> </div>
                <div class="content">
                    <div class="text">Slip Registration</div>
                    <div class="number"> 
                        <?php
                        $sql = "SELECT * FROM slip_registration WHERE db='{$_SESSION['userdb']}'";
                        $qsql = mysqli_query($con,$sql);
                        echo mysqli_num_rows($qsql);
                        // Step 2: Count today's registrations
                        $sql = "SELECT COUNT(*) AS daily_count FROM slip_registration WHERE DATE(registration_date) = '$current_date'";
                        $result = $con->query($sql);
                        $row = $result->fetch_assoc();
                        $daily_count = $row['daily_count'];
                        echo " / ".$daily_count;
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


   

    <div class="clear"></div>
</div>
</div>
<?php
include("adfooter.php");
?>
