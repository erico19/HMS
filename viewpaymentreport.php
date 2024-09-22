<?php
require_once("adheader.php");

if(isset($_GET['delid']))
{
	$sql ="DELETE FROM billing_records WHERE billingid='{$_GET['delid']}'";
	$qsql=mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('billing record deleted successfully..');</script>";
	}
}

?>
 <section class="container">
<?php
$sqlbilling_records ="SELECT * FROM billing WHERE billingid='{$_GET['billingid']}'";
$qsqlbilling_records = mysqli_query($con,$sqlbilling_records);
$rsbilling_records = mysqli_fetch_array($qsqlbilling_records);
?>
 	<table class="table table-bordered table-striped">
      <tbody>
        <tr>
          <th scope="col"><div align="right">Bill number &nbsp; </div></th>
          <td><?php echo $rsbilling_records['billingid']; ?></td>
          
        </tr>
        <tr>
          <th width="442" scope="col"><div align="right">Billing Date &nbsp; </div></th>
          <td width="413"><?php echo $rsbilling_records['billingdate']; ?></td>
        </tr>
         
		<tr>
          <th scope="col"><div align="right"></div></th>
          <td></td>
          <th scope="col"><div align="right">Bill Amount &nbsp; </div></th>
          <td><?php
		$sql ="SELECT * FROM billing_records where billingid='{$rsbilling_records['billingid']}'";
		$qsql = mysqli_query($con,$sql);
		$billamt= 0;
		while($rs = mysqli_fetch_array($qsql))
		{
			$billamt = $billamt +  $rs['bill_amount'];
		}
?>
  &nbsp;Rs. <?php echo $billamt; ?></td>
        </tr>
       
         
		<tr>
		  <th width="442" scope="col"><div align="right">Disount reason</div></th>
		  <td width="413" rowspan="4" valign="top"><?php echo $rsbilling_records['discountreason']; ?></td>
		  <th width="442" scope="col"><div align="right">Discount &nbsp; </div></th>
		  <td width="413">&nbsp;Rs. <?php echo $rsbilling_records['discount']; ?></td>
	    </tr>
        
		<tr>
		  <th rowspan="3" scope="col">&nbsp;</th>
		  <th scope="col"><div align="right">Grand Total &nbsp; </div></th>
		  <td>&nbsp; Rs. <?php echo $grandtotal = $billamt   - $rsbilling_records['discount'] ; ?></td>
	    </tr>
		<tr>
		  <th scope="col"><div align="right">Paid Amount </div></th>
		  <td> Rs. <?php
		  	$sqlpayment ="SELECT sum(paidamount) FROM payment where billingid='{$_GET['billingid']}'";
			$qsqlpayment = mysqli_query($con,$sqlpayment);
			$rspayment = mysqli_fetch_array($qsqlpayment);
			echo $rspayment[0];		  
		   ?></td>
	    </tr>
		<tr>
		  <th scope="col"><div align="right">Balance Amount</div></th>
		  <td>Rs. <?php echo $balanceamt = $grandtotal - $rspayment[0]  ; ?></td>
	    </tr>
      </tbody>
    </table>
   <p><strong>Payment report:</strong></p>
<?php
$sqlpayment = "SELECT * FROM payment where billingid='{$_GET['billingid']}'";
$qsqlpayment = mysqli_query($con,$sqlpayment);
if(mysqli_num_rows($qsqlpayment) == 0)
{
	echo "<strong>No transaction details found..</strong>";
}
else
{
?>
   <table class="table table-bordered table-striped">
     <tbody>
       <tr>
         <th scope="col">Paid Date</th>
         <th scope="col">Paid time</th>
         <th scope="col">Paid amount</th>
       </tr>
<?php       
		while($rspayment = mysqli_fetch_array($qsqlpayment))
		{
		?>
			   <tr>
				 <td>&nbsp;<?php echo $rspayment['paiddate']; ?></td>
				 <td>&nbsp;<?php echo $rspayment['paidtime']; ?></td>
				 <td>&nbsp;Rs. <?php echo $rspayment['paidamount']; ?></td>
			   </tr>
		<?php
		}
?>

     </tbody>
   </table>
<?php
}
?>   
 
		<a class="btn btn-raised" href="billpayment?billingid=<?php echo $_GET['billingid']; ?>">Make Payment</a>

   <p><strong></strong></p>
</section>

<?php
if (!defined('FOOTER_INCLUDED')) {
            define('FOOTER_INCLUDED', true);
            include 'adfooter.php';
        }
        
?>