<?php
session_start();
$Employee_ID="000001";
include '../../config.php';
include '../../generate_id.php';
//$FilePath=$_FILES["theFile"]["tmp_name"];

?>
<?php
date_default_timezone_set('UTC');
require('XLSXReader.php');
$xlsx = new XLSXReader('IIII.xlsx');
//$xlsx = new XLSXReader('sample.xlsx');
$sheetNames = $xlsx->getSheetNames();

$data = $xlsx->getSheetData($sheetNames[1]);
$row=0;
$error_count=0;
$saved_count=0;
$countloop=0;
foreach($data as $d){
	
	if($row>0){
		$countloop++;
	//echo $d[0]." ".$d[1]." ".$d[2]." ".$d[3]." ".$d[4]." ".$d[5]." ".$d[6]." ".$d[7]."<br>";
		
			if($d[10]=="Asset Tag"){
				if($d[0]!="" && $d[1]!="" && $d[2]!="" && $d[3]!="" && $d[6]!="" && $d[7]!=""  && $d[10]!=""){
					if($d[4]!="" ){
						
						//sub not null
						if($d[5]!=""){
							
							//with sub code ---valid---
							$setup_desc=$d[0];
							$setup_desc_code=$d[1];
							$setup_category=$d[2];
							$setup_category_code=$d[3];
							$SubCategorySetup=$d[4];
							$SubCategorySetup_code=$d[5];
							$serial_number=$d[6];
							$pn=$d[7];
							if($pn=='-1'){
								$pn='0';
							}
							/* if($pn=='1'){ */
							/* 	$pn=='1';
							} */
							$CheckSetup = mysqli_query($conn,"SELECT * FROM asset_setup WHERE asset_setup_description='$setup_desc' 
							AND asset_setup_category='$setup_category' AND asset_setup_sub_cat='$SubCategorySetup' 
							AND asset_setup_id>=12");
							$duplicate_count=mysqli_num_rows($CheckSetup);
							if($duplicate_count>0){
								
								//duplicated dont save
								$error_count++;
							}else{
								
								//save
								$getSetup = mysqli_query($conn,"SELECT * FROM asset_setup");
								$set = mysqli_num_rows($getSetup);
								$savesetup="INSERT INTO asset_setup
									(asset_setup_id,
									asset_setup_tag, 
									asset_setup_description,
									asset_setup_category, 
									asset_setup_sub_cat,
									asset_setup_ad,
									asset_setup_ac,
									asset_setup_sc,
									asset_setup_status,
									uom,
									asset_setup_sku
									) 
								VALUES 
									('$set',
									'Asset Tag',
									'$setup_desc',
									'$setup_category',
									'$SubCategorySetup',
									'$setup_desc_code',
									'$setup_category_code',
									'$SubCategorySetup_code',
									'3',
									'$serial_number',
									'$pn'
									)";
								if(mysqli_query($conn,$savesetup)){
									
									$primary=generate_alpha_digit_id();
									date_default_timezone_set("Asia/Manila");
									$date = new DateTime();
									$result = $date->format('Y-m-d H:i:s');
									$DAY=$date->format('Y-m-d');
									$TIME=$date->format('H:i:s');
									$log_id=$primary;
									$Action="Asset Setup";
									$tag="Asset Tag";
									$ID=$Employee_ID;
									$getname= mysqli_query($conn,"SELECT * FROM employee_info WHERE employee_id = '$ID'");
									$w = mysqli_fetch_array($getname);
									$Requestor=$w['fname']." ".$w['mname']." ".$w['lname'];
									$savelog="INSERT INTO asset_transaction_log(asset_transaction_log_id,asset_tag,log_date,log_time,log_action,transaction_action,deny_reason,log_action_requestor,audit_action_date,log_action_requestor_id,transaction_ticket_no) 
									VALUES ('$log_id','$tag','$DAY','$TIME','$Action','Queued on AM','','$Requestor','$DAY','$ID','$set')";
									mysqli_query($conn,$savelog);
									
									$getNOtifSquad= mysqli_query($conn,"SELECT * FROM employee_job_detail JOIN employee_info ON employee_info.employee_id=employee_job_detail.emp_id WHERE position='Asset Management Officer' AND lock_user='0'");
									$notif_text="Ticket No. ".$log_id;
									$dx=0;
									while($NotifSquad=mysqli_fetch_array($getNOtifSquad)){
									$dx++;
									$notif_id=$result.$ID.$dx;
										$Notif_Emp_ID=$NotifSquad['emp_id'];
										$savelog="INSERT INTO notification(notif_id,notif_subject,notif_text,notif_target,notif_status,notif_date)
												VALUES('$notif_id','Pending Request','$notif_text','$Notif_Emp_ID','1','$result')";
										if(mysqli_query($conn,$savelog)){
											
											
										}else{
											
											
										}
									}
									
									$getassetscount= mysqli_query($conn,"SELECT * FROM employee_job_detail JOIN employee_email_address ON employee_email_address.emp_id=employee_job_detail.emp_id WHERE position='Asset Management Officer'");
									$to="";
									while($rows=mysqli_fetch_array($getassetscount)){
										if($to==""){
											$to=$rows['email'];
										}else{
										   $to.=", ".$rows['email']; 
											
										}
										
									
									}
									
									$subject="Pending Request";
									$txt="Pending New Asset Setup Request \n "."Ticket No. ".$primary;
									
									$headers .= "Reply-To: kkccdc <kkccdc.com>\r\n"; 
									$headers .= "Return-Path: kkccdc <kkccdc.com>\r\n"; 
									$headers .= "From: kkccdc <kkccdc.com>\r\n"; 
									$headers .= "Organization: Website System\r\n";
									$headers .= "MIME-Version: 1.0\r\n";
									$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
									$headers .= "X-Priority: 3\r\n";
									$headers .= "X-Mailer: PHP/". phpversion() ."\r\n";
									if(!mail($to,$subject,$txt,$headers)){
										echo "<script>console.log('".$to."');</script>";
									}
									$saved_count++;
								}else{
									$error_count++;
								}
								
							}
						}
						else{
							// no sub code
							//invalid
							$error_count++;
						}
						
					}else{
						//sub  null
						$setup_desc=$d[0];
							$setup_desc_code=$d[1];
							$setup_category=$d[2];
							$setup_category_code=$d[3];
							$serial_number=$d[6];
							$pn=$d[7];
							if($pn=='-1'){
								$pn='0';
							}
						$CheckSetup = mysqli_query($conn,"SELECT * FROM asset_setup WHERE asset_setup_description='$setup_desc' 
						AND asset_setup_category='$setup_category'  
						AND asset_setup_id>=12");
						$duplicate_count=mysqli_num_rows($CheckSetup);
						if($duplicate_count>0){
							//duplicated dont save
							$error_count++;
						}else{
							//save
							
							$getSetup = mysqli_query($conn,"SELECT * FROM asset_setup");
								$set = mysqli_num_rows($getSetup);
								$savesetup="INSERT INTO asset_setup
									(asset_setup_id,
									asset_setup_tag, 
									asset_setup_description,
									asset_setup_category,
									asset_setup_sub_cat,
									asset_setup_ad,
									asset_setup_ac,
									'asset_setup_sc',
									asset_setup_status,
									uom,
									asset_setup_sku
									) 
								VALUES 
									('$set',
									'Asset Tag',
									'$setup_desc',
									'$setup_category',
									,''
									'$setup_desc_code',
									'$setup_category_code',
									'',
									'3',
									'$serial_number',
									'$pn'
									)";
								if(mysqli_query($conn,$savesetup)){
									$primary=generate_alpha_digit_id();
									date_default_timezone_set("Asia/Manila");
									$date = new DateTime();
									$result = $date->format('Y-m-d H:i:s');
									$DAY=$date->format('Y-m-d');
									$TIME=$date->format('H:i:s');
									$log_id=$primary;
									$Action="Asset Setup";
									$tag="Asset Tag";
									$ID=$Employee_ID;
									$getname= mysqli_query($conn,"SELECT * FROM employee_info WHERE employee_id = '$ID'");
									$w = mysqli_fetch_array($getname);
									$Requestor=$w['fname']." ".$w['mname']." ".$w['lname'];
									$savelog="INSERT INTO asset_transaction_log(asset_transaction_log_id,asset_tag,log_date,log_time,log_action,transaction_action,deny_reason,log_action_requestor,audit_action_date,log_action_requestor_id,transaction_ticket_no) 
									VALUES ('$log_id','$tag','$DAY','$TIME','$Action','Queued on AM','','$Requestor','$DAY','$ID','$set')";
									mysqli_query($conn,$savelog);
									
									$getNOtifSquad= mysqli_query($conn,"SELECT * FROM employee_job_detail JOIN employee_info ON employee_info.employee_id=employee_job_detail.emp_id WHERE position='Asset Management Officer' AND lock_user='0'");
									$notif_text="Ticket No. ".$log_id;
									$dx=0;
									while($NotifSquad=mysqli_fetch_array($getNOtifSquad)){
									$dx++;
									$notif_id=$result.$ID.$dx;
										$Notif_Emp_ID=$NotifSquad['emp_id'];
										$savelog="INSERT INTO notification(notif_id,notif_subject,notif_text,notif_target,notif_status,notif_date)
												VALUES('$notif_id','Pending Request','$notif_text','$Notif_Emp_ID','1','$result')";
										if(mysqli_query($conn,$savelog)){
											
											
										}else{
											
											
										}
									}
									
									$getassetscount= mysqli_query($conn,"SELECT * FROM employee_job_detail JOIN employee_email_address ON employee_email_address.emp_id=employee_job_detail.emp_id WHERE position='Asset Management Officer'");
									$to="";
									while($rows=mysqli_fetch_array($getassetscount)){
										if($to==""){
											$to=$rows['email'];
										}else{
										   $to.=", ".$rows['email']; 
											
										}
										
									
									}
									
									$subject="Pending Request";
									$txt="Pending New Asset Setup Request \n "."Ticket No. ".$primary;
									
									$headers .= "Reply-To: kkccdc <kkccdc.com>\r\n"; 
									$headers .= "Return-Path: kkccdc <kkccdc.com>\r\n"; 
									$headers .= "From: kkccdc <kkccdc.com>\r\n"; 
									$headers .= "Organization: Website System\r\n";
									$headers .= "MIME-Version: 1.0\r\n";
									$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
									$headers .= "X-Priority: 3\r\n";
									$headers .= "X-Mailer: PHP/". phpversion() ."\r\n";
									if(!mail($to,$subject,$txt,$headers)){
										echo "<script>console.log('".$to."');</script>";
									}
									$saved_count++;
								}else{
									$error_count++;
									
								}
						}
					}
				}
			}
			if($d[10]=="Site And Location"){
				
				if($d[8]!="" && $d[9]!=""){
					
					$location=$d[8];
					$site=$d[9];
					
					
					$CheckSetup = mysqli_query($conn,"SELECT * FROM asset_setup WHERE asset_setup_site='$site' AND asset_setup_location='$location' 
					AND asset_setup_id>=12");
					$duplicate_count=mysqli_num_rows($CheckSetup);
					if($duplicate_count>0){
						//duplicated dont save
						$error_count++;
						
					}else{
						
						//save
						$getSetup = mysqli_query($conn,"SELECT * FROM asset_setup");
						$set = mysqli_num_rows($getSetup);
						$savesetup="INSERT INTO asset_setup
								(asset_setup_id,
								asset_setup_tag, 
								asset_setup_site,
								asset_setup_location,
								asset_setup_status
								) 
							VALUES 
								('$set',
								'Site And Location',
								'$site',
								'$location',
								'3'
								)";
						if(mysqli_query($conn,$savesetup)){
							$primary=generate_alpha_digit_id();
							date_default_timezone_set("Asia/Manila");
							$date = new DateTime();
							$result = $date->format('Y-m-d H:i:s');
							$DAY=$date->format('Y-m-d');
							$TIME=$date->format('H:i:s');
							$log_id=$primary;
							$Action="Asset Setup";
							$tag="Site And Location";
							$ID=$Employee_ID;
							$getname= mysqli_query($conn,"SELECT * FROM employee_info WHERE employee_id = '$ID'");
							$w = mysqli_fetch_array($getname);
							$Requestor=$w['fname']." ".$w['mname']." ".$w['lname'];
							$savelog="INSERT INTO asset_transaction_log(asset_transaction_log_id,asset_tag,log_date,log_time,log_action,transaction_action,deny_reason,log_action_requestor,audit_action_date,log_action_requestor_id,transaction_ticket_no) 
							VALUES ('$log_id','$tag','$DAY','$TIME','$Action','Queued on AM','','$Requestor','$DAY','$ID','$set')";
							mysqli_query($conn,$savelog);
							
							$getNOtifSquad= mysqli_query($conn,"SELECT * FROM employee_job_detail JOIN employee_info ON employee_info.employee_id=employee_job_detail.emp_id WHERE position='Asset Management Officer' AND lock_user='0'");
							$notif_text="Ticket No. ".$log_id;
							$dx=0;
							while($NotifSquad=mysqli_fetch_array($getNOtifSquad)){
								$dx++;
							$notif_id=$result.$ID."".$dx;
								$Notif_Emp_ID=$NotifSquad['emp_id'];
								$savelog="INSERT INTO notification(notif_id,notif_subject,notif_text,notif_target,notif_status,notif_date)
											VALUES('$notif_id','Pending Request','$notif_text','$Notif_Emp_ID','1','$result')";
								mysqli_query($conn,$savelog);
							}
							
							$getassetscount= mysqli_query($conn,"SELECT * FROM employee_job_detail JOIN employee_email_address ON employee_email_address.emp_id=employee_job_detail.emp_id WHERE position='Asset Management Officer'");
						    $to="";
                        	while($rows=mysqli_fetch_array($getassetscount)){
								if($to==""){
								    $to=$rows['email'];
								}else{
								   $to.=", ".$rows['email']; 
								    
								}
								
                        	
                        	}
                        	$subject="Pending Request";
							$txt="Pending New Asset Setup Request \n "."Ticket No. ".$primary;
                        	
                        	$headers .= "Reply-To: kkccdc <kkccdc.com>\r\n"; 
                        	$headers .= "Return-Path: kkccdc <kkccdc.com>\r\n"; 
                        	$headers .= "From: kkccdc <kkccdc.com>\r\n"; 
                        	$headers .= "Organization: Website System\r\n";
                        	$headers .= "MIME-Version: 1.0\r\n";
                        	$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
                        	$headers .= "X-Priority: 3\r\n";
                        	$headers .= "X-Mailer: PHP/". phpversion() ."\r\n";
                        	if(!mail($to,$subject,$txt,$headers)){
                        		echo "<script>console.log('".$to."');</script>";
                        	}
							$saved_count++;
						}else{
							
							$error_count++;
							
						}
						
					}
					
				}else{
					//lack of info site and location
					$error_count++;
				}
			}
		
	}else{
		$row++;
	}
	//sleep(1);
}

echo "Saved : ".$saved_count;
echo "Skipped : ".$error_count;
echo "Total : ".$countloop;
/* $data = array(
   'Success' => $saved_count,
   'Total' => $countloop,
   'Skiped'  => $error_count
);
echo json_encode($data); */
?>