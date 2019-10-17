<?php
//session_start();
//$Employee_ID=$_SESSION['Employee_ID'];
//include '../../config.php';
//include '../../generate_id.php';
//$FilePath=$_FILES["theFile"]["tmp_name"];

?>
<?php
date_default_timezone_set('UTC');
require('XLSXReader.php');
//$xlsx = new XLSXReader($FilePath);
$xlsx = new XLSXReader('1549779508884716.xls');
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
	$rowplus=$row+1;
	if($row>1){
		
			$IDRow[]=$rowplus-1;	
		
			
		$row++;
	}else{
		$row++;
	}
	
}
for($c=0;$c<count($IDRow);$c++){
	$countloop++;
	
	
	
		
}
//echo $Log;
echo $saved_count." c:".$countloop." e:".$error_count;
echo "<br>".$Log;
$data = array(
   'Success' => $saved_count,
   'Total' => $countloop,
   'Skiped'  => $error_count,
   'Error_Log' =>$Log
);
echo json_encode($data);
?>