<?php
//session_start();
//$Employee_ID=$_SESSION['Employee_ID'];
include '../../config.php';
//include '../../generate_id.php';
$FilePath=$_FILES["theFile"]["tmp_name"];
$Payroll=$_POST['Payroll'];
?>
<?php
date_default_timezone_set('UTC');
require('XLSXReader.php');
$xlsx = new XLSXReader($FilePath);
//$xlsx = new XLSXReader('1549779508884716.xls');
$sheetNames = $xlsx->getSheetNames();

$data = $xlsx->getSheetData($sheetNames[1]);
$row=0;
$error_count=0;
$saved_count=0;
$countloop=0;
$Log="";
$IDRow= array();
//Get Row Number of Valid Data
foreach($data as $d){
	$rowplus=$row;
	
		
	if($row>1){
		
			$IDRow[]=$rowplus-1;	
		
			
		$row++;
	}else{
		$row++;
	}
	
}
/* foreach($IDRow as $ds){
		$Log.=$ds."\n";
		} */
for($c=0;$c<count($IDRow);$c++){
	$countloop++;
	$SystemID=$data[$IDRow[$c]][0];
	$Name=$data[$IDRow[$c]][1];
	$AdjustmentName=$data[$IDRow[$c]][2];
	$AdjustmentType=$data[$IDRow[$c]][3];
	$AdjustmentCode=$data[$IDRow[$c]][4];
	$Amount=$data[$IDRow[$c]][5];
	$AppliedBefore=$data[$IDRow[$c]][6];
	$Taxable=$data[$IDRow[$c]][7];
	if($Taxable=="YES"){
		$Taxable="1";
	}else{
		$Taxable="0";
	}
	if($SystemID!=""){
		
		if(is_numeric($Amount)){
			//$Log.=$SystemID." ";
			$getSalsal=mysqli_query($conn,"SELECT * FROM employee_salary WHERE payroll_id='$Payroll' AND emp_id='$SystemID'");
			while($r=mysqli_fetch_array($getSalsal)){
				$EMPID=$SystemID;
				$EmpAdjSalaryID=$e['salary_id'];
				$EmpAdjName=$AdjustmentName;
				$EmpAdjCode=$AdjustmentCode;
				$EmpAdjAmount=$Amount;
				$EmpAdjAdjType=$AdjustmentType;
				$EmpAdjAppliedBefore=$AppliedBefore;
				$EmpAdjTaxable=$Taxable;
				$datenow=date('Y-m-d');
				$t=time();
				$primary=$t.$datenow.$IDRow[$c];
				$EmpAdjRemarks="";
				$saveSalary="INSERT INTO employee_adjustment(employee_adjustment_id,employee_adjustment_type,employee_adjustment_name,employee_adjustment_code,employee_adjustment_amount,employee_adjustment_apply_before,
				employee_adjustment_taxable,employee_adjustment_remarks,employee_adjustment_payroll_id,employee_adjustment_emp_id,employee_adjustment_active) 
				VALUES ('$primary','$EmpAdjAdjType','$EmpAdjName','$EmpAdjCode','$EmpAdjAmount','$EmpAdjAppliedBefore','$EmpAdjTaxable','$EmpAdjRemarks',
				'$EmpAdjSalaryID','$EMPID','1')";
				if(mysqli_query($conn,$saveSalary)){
					$saved_count++;
				}else{
					$error_count++;
					$roo=$IDRow[$c]+1;
					$Log.="Failed to save data on row $roo from file.\n";	
				}
			}
			
		}else{
		
		$error_count++;
		$roo=$IDRow[$c]+1;
		$Log.="Invalid Amount on row $roo from file.\n";		
			
		}
	}else{
		$error_count++;
		$roo=$IDRow[$c]+1;
		$Log.="No System ID on row $roo from file.\n";	
	}
}
//echo $Log;

$data = array(
   'Success' => $saved_count,
   'Total' => $countloop,
   'Skiped'  => $error_count,
   'Error_Log' =>$Log
);
echo json_encode($data);
?>