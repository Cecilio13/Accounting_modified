<?php
//session_start();
//$Employee_ID=$_SESSION['Employee_ID'];
include '../../config.php';
//include '../../generate_id.php';
$FilePath=$_FILES["theFile"]["tmp_name"];

?>
<?php
date_default_timezone_set('UTC');
require('XLSXReader.php');
$xlsx = new XLSXReader($FilePath);
//$xlsx = new XLSXReader('HR_Employees_Data_Update.xlsx');
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
	
	$ID=$data[$IDRow[$c]][0];
	$getcount= mysqli_query($conn,"SELECT * FROM employee_info");
	$counts=mysqli_num_rows($getcount);
	$counts++;
	$ID="KKCCDC-".$counts;
	
	$FNAME=$data[$IDRow[$c]][1];
	$MNAME=$data[$IDRow[$c]][2];
	$LNAME=$data[$IDRow[$c]][3];
	//$position=$data[$IDRow[$c]][4];
	$Username=$data[$IDRow[$c]][4];
	$Password=$data[$IDRow[$c]][5];
	if($Username=="" || $Password==""){
		if($Username==""){
			$Username=$ID;
		}
		if($Password==""){
			$Password=$ID;
		}
		
	}
	$email=$data[$IDRow[$c]][6];//email
	$SecondEmail=$data[$IDRow[$c]][7];
	$BiometricsID=$data[$IDRow[$c]][8];
	$Gender=$data[$IDRow[$c]][9];
	if($Gender=="F"){
		$Gender="Female";
	}else{
		$Gender="Male";
	}
	$CivilStatus=$data[$IDRow[$c]][10];
	$DateofBirth2=$data[$IDRow[$c]][11];
	$sec = strtotime($DateofBirth2);
	$DateofBirth = date("Y-m-d", $sec);
	
	$Address=$data[$IDRow[$c]][12];
	//Emergency COntact Number
	//ECN #1
	$PhoneNumber1=$data[$IDRow[$c]][14];
	$COntactPerson1=$data[$IDRow[$c]][15];
	$Relationship1=$data[$IDRow[$c]][16];
	$ContactAddress1=$data[$IDRow[$c]][17];
	//ENC #2
	$PhoneNumber2=$data[$IDRow[$c]+1][14];
  $COntactPerson2=$data[$IDRow[$c]+1][15];
   $Relationship2=$data[$IDRow[$c]+1][16];
 $ContactAddress2=$data[$IDRow[$c]+1][17];
	//Alternate Contact Number
	//ACN #1
	$AltContactNumber1=$data[$IDRow[$c]][19];
	$AltContactPerson1=$data[$IDRow[$c]][20];
	//ACN #2
	$AltContactNumber2=$data[$IDRow[$c]+1][19];
	$AltContactPerson2=$data[$IDRow[$c]+1][20];
	//Salary And Advances
	$OTComputationTable=$data[$IDRow[$c]][21];
	$MinimumWage=$data[$IDRow[$c]][22];
	$ECOLA=$data[$IDRow[$c]][23];
	$WorkDayPerYear=$data[$IDRow[$c]][24];
	$BasicSalary=$data[$IDRow[$c]][25];
	$DeminimisTotal=$data[$IDRow[$c]][26];
	$PagIbigCont=$data[$IDRow[$c]][27];
	$SSSCont=$data[$IDRow[$c]][28];
	$PhilHealthCont=$data[$IDRow[$c]][29];
	$AddPagIbigCont=$data[$IDRow[$c]][30];
	//Job Detail
	$Position=$data[$IDRow[$c]][31];
	$DailyHour=$data[$IDRow[$c]][32];
	$Employee_Type=$data[$IDRow[$c]][33];
	$StartDate=$data[$IDRow[$c]][34];
	$EmploymentStatus=$data[$IDRow[$c]][35];
	$StatusEffectiveDate=$data[$IDRow[$c]][36];
	$Department=$data[$IDRow[$c]][37];
	$ROHQ=$data[$IDRow[$c]][38];
	$CostCenter=$data[$IDRow[$c]][39];
	$Consultant=$data[$IDRow[$c]][40];
	//Leave Management
	$MaternityLeave=$data[$IDRow[$c]][41];
	$SickLeave=$data[$IDRow[$c]][42];
	$LeaveCredit=$data[$IDRow[$c]][43];
	$VacationLeave=$data[$IDRow[$c]][44];
	//Government Information
	$TIN=$data[$IDRow[$c]][45];
	$Phil=$data[$IDRow[$c]][46];
	$SSS=$data[$IDRow[$c]][47];
	$HDMF=$data[$IDRow[$c]][48];
	$PRCLicense=$data[$IDRow[$c]][49];
	$Passport=$data[$IDRow[$c]][50];
	//$ScheduleType=$data[$IDRow[$c]][41];
	/* //Schedule Detail
	//Sunday
	$ShiftFrom1=$data[$IDRow[$c]][43];
	  $ShiftTo1=$data[$IDRow[$c]][44];
   $BreakStart1=$data[$IDRow[$c]][45];
	 $BreakEnd1=$data[$IDRow[$c]][46];
	$IsRestDay1=$data[$IDRow[$c]][47];
	//Monday
	$ShiftFrom2=$data[$IDRow[$c]+1][43];
	  $ShiftTo2=$data[$IDRow[$c]+1][44];
   $BreakStart2=$data[$IDRow[$c]+1][45];
	 $BreakEnd2=$data[$IDRow[$c]+1][46];
	$IsRestDay2=$data[$IDRow[$c]+1][47];
	//Tuesday                   
	$ShiftFrom2=$data[$IDRow[$c]+2][43];
	  $ShiftTo2=$data[$IDRow[$c]+2][44];
   $BreakStart2=$data[$IDRow[$c]+2][45];
	 $BreakEnd2=$data[$IDRow[$c]+2][46];
	$IsRestDay2=$data[$IDRow[$c]+2][47];
	//Wednesday                 
	$ShiftFrom3=$data[$IDRow[$c]+3][43];
	  $ShiftTo3=$data[$IDRow[$c]+3][44];
   $BreakStart3=$data[$IDRow[$c]+3][45];
	 $BreakEnd3=$data[$IDRow[$c]+3][46];
	$IsRestDay3=$data[$IDRow[$c]+3][47];
	//Thursday                  
	$ShiftFrom4=$data[$IDRow[$c]+4][43];
	  $ShiftTo4=$data[$IDRow[$c]+4][44];
   $BreakStart4=$data[$IDRow[$c]+4][45];
	 $BreakEnd4=$data[$IDRow[$c]+4][46];
	$IsRestDay4=$data[$IDRow[$c]+4][47];
	//Friday                    
	$ShiftFrom5=$data[$IDRow[$c]+5][43];
	  $ShiftTo5=$data[$IDRow[$c]+5][44];
   $BreakStart5=$data[$IDRow[$c]+5][45];
	 $BreakEnd5=$data[$IDRow[$c]+5][46];
	$IsRestDay5=$data[$IDRow[$c]+5][47];
	//Saturday                  
	$ShiftFrom6=$data[$IDRow[$c]+6][43];
	  $ShiftTo6=$data[$IDRow[$c]+6][44];
   $BreakStart6=$data[$IDRow[$c]+6][45];
	 $BreakEnd6=$data[$IDRow[$c]+6][46];
	$IsRestDay6=$data[$IDRow[$c]+6][47]; */
	
	
		$CheckEmployee= mysqli_query($conn,"SELECT * FROM employee_info WHERE employee_id='$ID'");
		$count=mysqli_num_rows($CheckEmployee);
		if($count<1){
			if($data[$IDRow[$c]][1]!="" && $data[$IDRow[$c]][3]!=""){
				if($Username!="" && $Password!=""){
					$CheckUsername= mysqli_query($conn,"SELECT * FROM employee_info WHERE username='$Username'");
					$countUs=mysqli_num_rows($CheckUsername);
					if($countUs<1){
						//save
						
						$savetemplate="INSERT INTO employee_info(employee_id,bio_id,fname, mname, lname,gender,civil_status,date_of_birth,address,username,password,lock_user) 
									VALUES ('$ID','$BiometricsID','$FNAME','$MNAME','$LNAME','$Gender','$CivilStatus','$DateofBirth','$Address','$Username','$Password','0')";
							if(mysqli_query($conn,$savetemplate)){
								
								$datenow=date('Y-m-d H:i:s');
								$t=time();
								$primary=$ID.$t.$datenow."1";
								$savetemplate2="INSERT INTO employee_emergency_contact(emergency_contact_id,emp_id, phone_number, contact_person, relationship,address)
								VALUES ('$primary','$ID','$PhoneNumber1','$COntactPerson1','$Relationship1','$ContactAddress1')";
								if(mysqli_query($conn,$savetemplate2)){
									
								}else{
									
								}
								/* $datenow=date('Y-m-d H:i:s');
								$t=time();
								$primary=$t.$datenow."2";
								$savetemplate3="INSERT INTO employee_emergency_contact(emergency_contact_id,emp_id, phone_number, contact_person, relationship,address)
								VALUES ('$primary','$ID','$PhoneNumber2','$COntactPerson2','$Relationship2','$ContactAddress2')";
								if(mysqli_query($conn,$savetemplate3)){
									
								} */
								
								$datenow=date('Y-m-d H:i:s');
								$t=time();
								$primary=$ID.$t.$datenow."1";
								$savetemplate3="INSERT INTO employee_alternate_contact(alternate_contact_id,emp_id, phone_number, contact_person, type)
								VALUES ('$primary','$ID','$AltContactNumber1','$AltContactPerson1','Primary')";
								if(mysqli_query($conn,$savetemplate3)){
									
								}
								/* $datenow=date('Y-m-d H:i:s');
								$t=time();
								$primary=$t.$datenow."2";
								$savetemplate4="INSERT INTO employee_alternate_contact(alternate_contact_id,emp_id, phone_number, contact_person, type)
								VALUES ('$primary','$ID','$AltContactNumber2','$AltContactPerson2','Secondary')";
								if(mysqli_query($conn,$savetemplate4)){
									
								} */
								
								$email=$data[$IDRow[$c]][6];//email
								$SecondEmail=$data[$IDRow[$c]][7];
								$datenow=date('Y-m-d H:i:s');
									$t=time();
									$primary=$ID.$t.$datenow."1";
								$savetemplate5="INSERT INTO employee_email_address(email_address_id,emp_id, email, type)
								VALUES ('$primary','$ID','$email','Primary')";
								if(mysqli_query($conn,$savetemplate5)){
									
								}
								$datenow=date('Y-m-d H:i:s');
									$t=time();
									$primary=$ID.$t.$datenow."2";
								$savetemplate6="INSERT INTO employee_email_address(email_address_id,emp_id, email, type)
								VALUES ('$primary','$ID','$SecondEmail','Secondary')";
								if(mysqli_query($conn,$savetemplate6)){
									
								}
								
								
								$datenow=date('Y-m-d H:i:s');
								$t=time();
								$primary=$ID.$t.$datenow;
								$savetemplate10="INSERT INTO employee_salary_detail(salary_detail_id,emp_id, workdayperyear, ot_com_table, pagibigcont, minwage, 
								basic_salary, sss_contribution, add_pagibig_cont, ecola, deminimis_total, philhealth_contribution)
								VALUES ('$primary','$ID','$WorkDayPerYear','$OTComputationTable','$PagIbigCont','$MinimumWage','$BasicSalary','$SSSCont'
								,'$AddPagIbigCont','$ECOLA','$DeminimisTotal','$PhilHealthCont')";
								if(mysqli_query($conn,$savetemplate10)){
									
								}
								
								$datenow=date('Y-m-d H:i:s');
								$t=time();
								$primary=$ID.$t.$datenow;
								$savetemplate15="INSERT INTO employee_job_detail(job_detail_id,emp_id, position, department,cost_center,start_date,employment_status,
								status_effectve_date,daily_hour,employee_type,rohq,consultant,tin_number,philhealth_number,sss_number,hdmf_number,sl,vl,leave_credit,schedule_type,no_of_hours_to_work,prc_license,passport)
								VALUES ('$primary','$ID','$Position','$Department','$CostCenter','$StartDate','$EmploymentStatus','$StatusEffectiveDate','$DailyHour',
								'$Employee_Type','$ROHQ','$Consultant','$TIN','$Phil','$SSS','$HDMF','$SickLeave','$VacationLeave','$LeaveCredit','$ScheduleType','$DailyHour','$PRCLicense','$Passport')";
								if(mysqli_query($conn,$savetemplate15)){
									
								}
								
								
								$savetemplate16="INSERT INTO employee_schedule_detail(emp_id, day_id, core_from,core_to,break_start,break_end,is_rest_day)
								VALUES ('$ID','1','$ShiftFrom1','$ShiftTo1','$BreakStart1','$BreakEnd1','$IsRestDay1')";
								if(mysqli_query($conn,$savetemplate16)){
									
								}
								$savetemplate17="INSERT INTO employee_schedule_detail(emp_id, day_id, core_from,core_to,break_start,break_end,is_rest_day)
								VALUES ('$ID','2','$ShiftFrom2','$ShiftTo2','$BreakStart2','$BreakEnd2','$IsRestDay2')";
								if(mysqli_query($conn,$savetemplate17)){
									
								}
								$savetemplate18="INSERT INTO employee_schedule_detail(emp_id, day_id, core_from,core_to,break_start,break_end,is_rest_day)
								VALUES ('$ID','3','$ShiftFrom3','$ShiftTo3','$BreakStart3','$BreakEnd3','$IsRestDay3')";
								if(mysqli_query($conn,$savetemplate18)){
									
								}
								$savetemplate19="INSERT INTO employee_schedule_detail(emp_id, day_id, core_from,core_to,break_start,break_end,is_rest_day)
								VALUES ('$ID','4','$ShiftFrom4','$ShiftTo4','$BreakStart4','$BreakEnd4','$IsRestDay4')";
								if(mysqli_query($conn,$savetemplate19)){
									
								}
								$savetemplate20="INSERT INTO employee_schedule_detail(emp_id, day_id, core_from,core_to,break_start,break_end,is_rest_day)
								VALUES ('$ID','5','$ShiftFrom5','$ShiftTo5','$BreakStart5','$BreakEnd5','$IsRestDay5')";
								if(mysqli_query($conn,$savetemplate20)){
									
								}
								$savetemplate21="INSERT INTO employee_schedule_detail(emp_id, day_id, core_from,core_to,break_start,break_end,is_rest_day)
								VALUES ('$ID','6','$ShiftFrom6','$ShiftTo6','$BreakStart6','$BreakEnd6','$IsRestDay6')";
								if(mysqli_query($conn,$savetemplate21)){
									
								}
								$savetemplate21="INSERT INTO employee_schedule_detail(emp_id, day_id, core_from,core_to,break_start,break_end,is_rest_day)
								VALUES ('$ID','7','$ShiftFrom7','$ShiftTo7','$BreakStart7','$BreakEnd7','$IsRestDay7')";
								if(mysqli_query($conn,$savetemplate21)){
									
								}
								
								$datenow=date('Y-m-d H:i:s');
								$t=time();
								$primary=$ID.$t.$datenow;
								$savetemplate22="INSERT INTO employee_leavemanagement(employee_leavemanagement_id,emp_id, pat_mat_credit, sick_credit,leave_credit,pat_mat_rem,sick_credit_rem,leave_credit_rem,vacation_credit_rem)
								VALUES ('$primary','$ID','$MaternityLeave','$SickLeave','$LeaveCredit','$MaternityLeave','$SickLeave','$LeaveCredit','$VacationLeave')";
								if(mysqli_query($conn,$savetemplate22)){
									
								}
								
								//Access Control
								if($Position=="CEO" ){
									$savetemplate23="INSERT INTO employee_access_control(emp_id,ceo_bulletin,company_setup,employee_dashboard)
									VALUES ('$ID','1','1','1')";
									if(mysqli_query($conn,$savetemplate23)){
										
									}
								}
								if($Position=="Asset Management Officer" || $Position=="Data Entry Officer Officer" || $Position=="Fixed Asset Officer"){
									$savetemplate23="INSERT INTO employee_access_control(emp_id,inventory_management_system,employee_dashboard)
									VALUES ('$ID','1','1')";
									if(mysqli_query($conn,$savetemplate23)){
										
									}
								}
								if($Position=="HR" ){
									$savetemplate23="INSERT INTO employee_access_control(emp_id,hr_bulletin,employee_dashboard)
									VALUES ('$ID','1','1')";
									if(mysqli_query($conn,$savetemplate23)){
										
									}
								}
								if($Position=="Payroll Officer" ){
									$savetemplate23="INSERT INTO employee_access_control(emp_id,payroll_bulletin,employee_dashboard)
									VALUES ('$ID','1','1')";
									if(mysqli_query($conn,$savetemplate23)){
										
									}
								}
								if($Position=="Accounting Officer" ){
									$savetemplate23="INSERT INTO employee_access_control(emp_id,accounting_bulletin,employee_dashboard)
									VALUES ('$ID','1','1')";
									if(mysqli_query($conn,$savetemplate23)){
										
									}
								}
								if($Position=="Project Management Officer" ){
									$savetemplate23="INSERT INTO employee_access_control(emp_id,project_management_dashboard,project_site_dashboard,employee_dashboard)
									VALUES ('$ID','1','1','1')";
									if(mysqli_query($conn,$savetemplate23)){
										
									}
								}
								
								$getDepartments = mysqli_query($conn,"SELECT * FROM company_department WHERE department_name='$Department'");
								$icount = mysqli_num_rows($getDepartments);
								if($icount>0){
									$info = mysqli_fetch_array($getDepartments);
									$DeptID=$info['department_id'];
									$savetemplate27="INSERT INTO employee_access_control_department(emp_id,department_id) VALUES ('$ID','$DeptID')";
									mysqli_query($conn,$savetemplate27);
								}
								$saved_count++;
							}else{
								// Error
								$error_count++;
								$Log.="Failed saving data on row $IDRow[$c] from file.\n";
								
							}
					}else{
						//Duplicate Username
						$error_count++;
						$Log.="Duplicate Username on row $IDRow[$c] from file.\n";
					}
				}else{
					// Username or password null
					$error_count++;
					if($data[$IDRow[$c]][4]==""){
						$Log.="Incomplete data on row $IDRow[$c] from file. Username is missing.\n";
					}
					if($data[$IDRow[$c]][5]==""){
						$Log.="Incomplete data on row $IDRow[$c] from file. Password is missing.\n";
					}
				}
				
			}else{
				//No Name
				$error_count++;
				
				if($data[$IDRow[$c]][1]==""){
					$Log.="Incomplete data on row $IDRow[$c] from file. First Name is missing.\n";
				}
				if($data[$IDRow[$c]][3]==""){
					$Log.="Incomplete data on row $IDRow[$c] from file. Last Name is missing.\n";
				}
				
			}
		}else{
			//duplicate ID
			$error_count++;
			$Log.="Duplicate ID on row $IDRow[$c] from file.\n";
			
		}
}
//echo $Log;
/* echo $saved_count." c:".$countloop." e:".$error_count;
echo "<br>".$Log; */
$data = array(
   'Success' => $saved_count,
   'Total' => $countloop,
   'Skiped'  => $error_count,
   'Error_Log' =>$Log
);
echo json_encode($data);
?>