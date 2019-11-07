<?php

namespace App\Http\Controllers;
use App\Clients;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Budgets;
class SyncController extends Controller
{
    public function __construct()
    {
        // $client=Clients::first();
        // $dbName='accounting_modified_'.$client->clnt_db_name;
            
        // DB::disconnect('mysql');//here connection name, I used mysql for example
        // Config::set('database.connections.mysql.database', $dbName);//new database name, you want to connect to.

    }
    public function sample_sync(Request $request){
        $journal_entries= DB::connection('mysql')->select("SELECT * FROM journal_entries");
            $journal_entries2= DB::connection('mysql3')->select("SELECT * FROM journal_entries");
            foreach($journal_entries as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($journal_entries2 as $ccl2){
                    if($ccl2->je_no==$ccl->je_no && $ccl2->je_id==$ccl->je_id && $ccl2->other_no==$ccl->other_no && $ccl2->create_point==$ccl->create_point && $ccl2->je_invoice_location_and_type==$ccl->je_invoice_location_and_type){
                        $dup=1;
                        $uid=$ccl2->je_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    echo $ccl->je_no." -- ".$ccl->je_no." >>> ".$ccl->created_at." insert<br>";
                    // DB::connection('mysql3')
                    // ->statement(
                    //     DB::raw('insert into journal_entries (`je_id`, `je_no`, `je_account`, `je_debit`, `je_credit`, `je_desc`, `je_name`, `je_memo`, `je_attachment`, `je_transaction_type`, `other_no`, `remark`, `cancellation_date`, `cancellation_reason`, `je_cost_center`,`je_invoice_location_and_type`, `created_at`, `updated_at`,`create_point`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                    //     array($ccl->je_id,$ccl->je_no,$ccl->je_account,$ccl->je_debit,$ccl->je_credit,$ccl->je_desc,$ccl->je_name,$ccl->je_memo,$ccl->je_attachment,$ccl->je_transaction_type,$ccl->other_no,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->je_cost_center,$ccl->je_invoice_location_and_type,$ccl->created_at,$ccl->updated_at,$ccl->create_point)
                    // );
                   // echo $ccl->je_no." Journal Entry insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        echo $ccl->je_no." -- ".$ccl->je_no." >>> ".$ccl->created_at." updated<br>";
                        // DB::connection('mysql3')
                        // ->statement(
                        //     DB::raw('UPDATE journal_entries SET `je_id`=?, `je_no`=?, `je_account`=?, `je_debit`=?, `je_credit`=?, `je_desc`=?, `je_name`=?, `je_memo`=?, `je_attachment`=?, `je_transaction_type`=?, `other_no`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `je_cost_center`=?,`je_invoice_location_and_type`=?, `created_at`=?, `updated_at`=?,`create_point`=? WHERE create_point=? AND je_id=? AND je_no=? AND other_no=? AND je_invoice_location_and_type=?'),
                        //     array($ccl->je_id,$ccl->je_no,$ccl->je_account,$ccl->je_debit,$ccl->je_credit,$ccl->je_desc,$ccl->je_name,$ccl->je_memo,$ccl->je_attachment,$ccl->je_transaction_type,$ccl->other_no,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->je_cost_center,$ccl->je_invoice_location_and_type,$ccl->created_at,$ccl->updated_at,$ccl->create_point,$ccl->create_point,$ccl->je_id,$ccl->je_no,$ccl->other_no,$ccl->je_invoice_location_and_type)
                        // );
                        //echo  "Journal Entry : ".$updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
    }
    public function sync_data_v_two(Request $request){
      
        
		echo "Part 2";
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
        $db = DB::select($query, ['accounting']);
        if(empty($db)){

        }else{
            $auditlog= DB::connection('mysql3')->select("SELECT * FROM audit_logs");
            $auditlog2= DB::connection('mysql')->select("SELECT * FROM audit_logs");
            foreach($auditlog as $al){
                $dup=0;
                foreach($auditlog2 as $al2){
                    if($al->log_id==$al2->log_id){
                        $dup=1;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    $audi= DB::connection('mysql')->select("SELECT * FROM audit_logs");
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into audit_logs (log_id,log_user_id,log_name,log_event,log_transaction_date,log_amount,created_at,updated_at) values (?,?,?,?,?,?,?,?)'),
                        array(count($audi)+1,$al->log_user_id,$al->log_name,$al->log_event,$al->log_transaction_date,$al->log_amount,$al->created_at,$al->updated_at)
                    );
                    // $AuditLog= new AuditLog;
                    // $AuditLogcount=$al->log_id;
                    // $userid = $al->log_user_id;
                    // $username = $al->log_name;
                    // $AuditLog->log_id=$AuditLogcount;
                    // $AuditLog->log_user_id=$userid;
                    // $AuditLog->log_event=$al->log_event;
                    // $AuditLog->log_name=$username;
                    // $AuditLog->log_transaction_date=$al->log_transaction_date;
                    // $AuditLog->log_amount=$al->log_amount;
                    // $AuditLog->created_at=$al->created_at;
                    // $AuditLog->updated_at=$al->updated_at;
                    // $AuditLog->save();
                    echo $al->log_id." ";
                } 
            }
            $bank= DB::connection('mysql3')->select("SELECT * FROM bank");
            $bank2= DB::connection('mysql')->select("SELECT * FROM bank");
            foreach($bank as $b){
                $uid="";
                $updated_at="";
                $dup=0;
                foreach($bank2 as $b2){
                    if($b->bank_no==$b2->bank_no ){
                        $dup=1;
                        $uid=$b2->bank_no;
                        $updated_at=$b2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into bank (bank_no,bank_name,bank_branch,bank_code,bank_account_no,bank_remark,bank_status,created_at,updated_at) values (?,?,?,?,?,?,?,?,?)'),
                        array($b->bank_no,$b->bank_name,$b->bank_branch,$b->bank_code,$b->bank_account_no,$b->bank_remark,$b->bank_status,$b->created_at,$b->updated_at)
                    );
                    echo $b->bank_no." bank_id insert ";
                }
                else if($dup==1){
                    if(strtotime($updated_at)<strtotime($b->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE bank SET bank_no=?,bank_name=?,bank_branch=?,bank_code=?,bank_account_no=?,bank_remark=?,bank_status=?,created_at=?,updated_at=? WHERE bank_no=?'),
                            array($b->bank_no,$b->bank_name,$b->bank_branch,$b->bank_code,$b->bank_account_no,$b->bank_remark,$b->bank_status,$b->created_at,$b->updated_at,$uid)
                        );
                        echo  $updated_at." < ". $b->updated_at." ";
                    }
                    

                }
            }
            $bank= DB::connection('mysql3')->select("SELECT * FROM bank_edit");
            $bank2= DB::connection('mysql')->select("SELECT * FROM bank_edit");
            foreach($bank as $b){
                $uid="";
                $updated_at="";
                $dup=0;
                foreach($bank2 as $b2){
                    if($b->bank_no==$b2->bank_no){
                        $dup=1;
                        $uid=$b2->bank_no;
                        $updated_at=$b2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into bank_edit (bank_no,bank_name,bank_branch,bank_code,bank_account_no,bank_remark,bank_status,edit_status,created_at,updated_at) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($b->bank_no,$b->bank_name,$b->bank_branch,$b->bank_code,$b->bank_account_no,$b->bank_remark,$b->bank_status,$b->edit_status,$b->created_at,$b->updated_at)
                    );
                    echo $b->bank_no." bank_id insert ";
                }
                else if($dup==1){
                    if(strtotime($updated_at)<strtotime($b->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE bank_edit SET bank_no=?,bank_name=?,bank_branch=?,bank_code=?,bank_account_no=?,bank_remark=?,bank_status=?,edit_status=?,created_at=?,updated_at=? WHERE bank_no=?'),
                            array($b->bank_no,$b->bank_name,$b->bank_branch,$b->bank_code,$b->bank_account_no,$b->bank_remark,$b->bank_status,$b->edit_status,$b->created_at,$b->updated_at,$uid)
                        );
                        echo  $updated_at." < ". $b->updated_at." ";
                    }
                    

                }
            }
            $budget= DB::connection('mysql3')->select("SELECT * FROM budget");
            $budget2= DB::connection('mysql')->select("SELECT * FROM budget");
            foreach($budget as $bud){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($budget2 as $bud2){
                    if($bud->budget_year==$bud2->budget_year && $bud->budget_cost_center==$bud2->budget_cost_center && $bud->budget_chart_of_accounts==$bud2->budget_chart_of_accounts && $bud->budget_type==$bud2->budget_type){
                        $dup=1;
                        $uid=$bud2->budget_no;
                        $updated_at=$bud2->updated_at;
                        break;

                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    $busssssd= DB::connection('mysql')->select("SELECT * FROM budget");
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into budget (budget_no,budget_year,budget_cost_center,budget_chart_of_accounts,m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12,created_at,updated_at,budget_month,budget_type) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array(count($busssssd)+1,$bud->budget_year,$bud->budget_cost_center,$bud->budget_chart_of_accounts,$bud->m1,$bud->m2,$bud->m3,$bud->m4,$bud->m5,$bud->m6,$bud->m7,$bud->m8,$bud->m9,$bud->m10,$bud->m11,$bud->m12,$bud->created_at,$bud->updated_at,$bud->budget_month,$bud->budget_type)
                    );
                    echo $bud->budget_no." budget_id insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($bud->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE budget SET budget_no=?,budget_year=?,budget_cost_center=?,budget_chart_of_accounts=?,m1=?,m2=?,m3=?,m4=?,m5=?,m6=?,m7=?,m8=?,m9=?,m10=?,m11=?,m12=?,created_at=?,updated_at=?,budget_month=?,budget_type=? WHERE budget_no=?'),
                            array($bud->budget_no,$bud->budget_year,$bud->budget_cost_center,$bud->budget_chart_of_accounts,$bud->m1,$bud->m2,$bud->m3,$bud->m4,$bud->m5,$bud->m6,$bud->m7,$bud->m8,$bud->m9,$bud->m10,$bud->m11,$bud->m12,$bud->created_at,$bud->budget_month,$bud->budget_type,$bud->updated_at,$uid)
                        );
                        echo  $updated_at." < ". $bud->updated_at." ";
                    }
                }
            }
            $budget= DB::connection('mysql3')->select("SELECT * FROM budget_edits");
            $budget2= DB::connection('mysql')->select("SELECT * FROM budget_edits");
            foreach($budget as $bud){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($budget2 as $bud2){
                    if($bud->budget_year==$bud2->budget_year && $bud->budget_cost_center==$bud2->budget_cost_center && $bud->budget_chart_of_accounts==$bud2->budget_chart_of_accounts && $bud->budget_type==$bud2->budget_type){
                        $dup=1;
                        $uid=$bud2->budget_no;
                        $updated_at=$bud2->updated_at;
                        break;

                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    $busssssd= DB::connection('mysql')->select("SELECT * FROM budget_edits");
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into budget_edits (budget_no,budget_year,budget_cost_center,budget_chart_of_accounts,m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12,created_at,updated_at,budget_month,budget_type,edit_status) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array(count($busssssd)+1,$bud->budget_year,$bud->budget_cost_center,$bud->budget_chart_of_accounts,$bud->m1,$bud->m2,$bud->m3,$bud->m4,$bud->m5,$bud->m6,$bud->m7,$bud->m8,$bud->m9,$bud->m10,$bud->m11,$bud->m12,$bud->created_at,$bud->updated_at,$bud->budget_month,$bud->budget_type,$bud->edit_status)
                    );
                    echo $bud->budget_no." budget_edits insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($bud->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE budget_edits SET budget_no=?,budget_year=?,budget_cost_center=?,budget_chart_of_accounts=?,m1=?,m2=?,m3=?,m4=?,m5=?,m6=?,m7=?,m8=?,m9=?,m10=?,m11=?,m12=?,created_at=?,updated_at=?,budget_month=?,budget_type=?,edit_status=? WHERE budget_no=?'),
                            array($bud->budget_no,$bud->budget_year,$bud->budget_cost_center,$bud->budget_chart_of_accounts,$bud->m1,$bud->m2,$bud->m3,$bud->m4,$bud->m5,$bud->m6,$bud->m7,$bud->m8,$bud->m9,$bud->m10,$bud->m11,$bud->m12,$bud->created_at,$bud->updated_at,$bud->budget_month,$bud->budget_type,$bud->edit_status,$uid)
                        );
                        echo  $updated_at." < ". $bud->updated_at." ";
                    }
                }
            }
            ///
            $chartofaccounts= DB::connection('mysql3')->select("SELECT * FROM chart_of_accounts");
            $chartofaccounts2= DB::connection('mysql')->select("SELECT * FROM chart_of_accounts");

            foreach($chartofaccounts as $coa){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($chartofaccounts2 as $coa2){
                    
                    if($coa->id==$coa2->id && $coa->coa_account_type==$coa2->coa_account_type && $coa->coa_detail_type==$coa2->coa_detail_type && $coa->coa_name==$coa2->coa_name ){
                        
                        $dup=1;
                        $uid=$coa2->id;
                        $updated_at=$coa2->updated_at;
                        break;
                    }else{
                        
                        $dup=0;
                    }
                }
                if($dup==0){
                   
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into chart_of_accounts (`id`, `coa_account_type`, `coa_detail_type`, `coa_name`, `coa_description`, `coa_is_sub_acc`, `coa_parent_account`, `coa_balance`, `coa_as_of_date`, `coa_active`, `coa_code`, `normal_balance`, `coa_title`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($coa->id,$coa->coa_account_type,$coa->coa_detail_type,$coa->coa_name,$coa->coa_description,$coa->coa_is_sub_acc,$coa->coa_parent_account,$coa->coa_balance,$coa->coa_as_of_date,$coa->coa_active,$coa->coa_code,$coa->normal_balance,$coa->coa_title,$coa->created_at,$coa->updated_at)
                    );
                    echo $coa->id." coa insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($coa->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE chart_of_accounts SET `id`=?, `coa_account_type`=?, `coa_detail_type`=?, `coa_name`=?, `coa_description`=?, `coa_is_sub_acc`=?, `coa_parent_account`=?, `coa_balance`=?, `coa_as_of_date`=?, `coa_active`=?, `coa_code`=?, `normal_balance`=?, `coa_title`=?, `created_at`=?, `updated_at`=? WHERE id=?'),
                            array($coa->id,$coa->coa_account_type,$coa->coa_detail_type,$coa->coa_name,$coa->coa_description,$coa->coa_is_sub_acc,$coa->coa_parent_account,$coa->coa_balance,$coa->coa_as_of_date,$coa->coa_active,$coa->coa_code,$coa->normal_balance,$coa->coa_title,$coa->created_at,$coa->updated_at,$coa->id)
                        );
                        echo  $updated_at." < ". $coa->updated_at." ";
                    }
                }
            }
            $chartofaccounts= DB::connection('mysql3')->select("SELECT * FROM chart_of_accounts_edit");
            $chartofaccounts2= DB::connection('mysql')->select("SELECT * FROM chart_of_accounts_edit");

            foreach($chartofaccounts as $coa){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($chartofaccounts2 as $coa2){
                    
                    if($coa->coa_code==$coa2->coa_code){
                        
                        $dup=1;
                        $uid=$coa2->id;
                        $updated_at=$coa2->updated_at;
                        break;
                    }else{
                        
                        $dup=0;
                    }
                }
                if($dup==0){
                   
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into chart_of_accounts_edit (`id`, `coa_account_type`, `coa_detail_type`, `coa_name`, `coa_description`, `coa_is_sub_acc`, `coa_parent_account`, `coa_balance`, `coa_as_of_date`, `coa_active`, `coa_code`, `normal_balance`, `coa_title`,`edit_status`, `created_at`, `updated_at`,`coa_sub_account`,`coa_beginning_balance`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($coa->id,$coa->coa_account_type,$coa->coa_detail_type,$coa->coa_name,$coa->coa_description,$coa->coa_is_sub_acc,$coa->coa_parent_account,$coa->coa_balance,$coa->coa_as_of_date,$coa->coa_active,$coa->coa_code,$coa->normal_balance,$coa->coa_title,$coa->edit_status,$coa->created_at,$coa->updated_at,$coa->coa_sub_account,$coa->coa_beginning_balance)
                    );
                    echo $coa->id." coa insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($coa->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE chart_of_accounts_edit SET `id`=?, `coa_account_type`=?, `coa_detail_type`=?, `coa_name`=?, `coa_description`=?, `coa_is_sub_acc`=?, `coa_parent_account`=?, `coa_balance`=?, `coa_as_of_date`=?, `coa_active`=?, `coa_code`=?, `normal_balance`=?, `coa_title`=?,`edit_status`=?, `created_at`=?, `updated_at`=?,`coa_sub_account`=?,`coa_beginning_balance`=? WHERE id=?'),
                            array($coa->id,$coa->coa_account_type,$coa->coa_detail_type,$coa->coa_name,$coa->coa_description,$coa->coa_is_sub_acc,$coa->coa_parent_account,$coa->coa_balance,$coa->coa_as_of_date,$coa->coa_active,$coa->coa_code,$coa->normal_balance,$coa->coa_title,$coa->edit_status,$coa->created_at,$coa->updated_at,$coa->coa_sub_account,$coa->coa_beginning_balance,$coa->id)
                        );
                        echo  $updated_at." < ". $coa->updated_at." ";
                    }
                }
            }

            $cost_center= DB::connection('mysql3')->select("SELECT * FROM cost_center");
            $cost_center2= DB::connection('mysql')->select("SELECT * FROM cost_center");
            foreach($cost_center as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($cost_center2 as $ccl2){
                    if($ccl->cc_name_code==$ccl2->cc_name_code ){
                        $dup=1;
                        $uid=$ccl2->cc_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into cost_center (`cc_no`, `cc_type_code`, `cc_type`, `cc_name_code`, `cc_name`, `cc_status`,`cc_use_quotation`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?)'),
                        array($ccl->cc_no,$ccl->cc_type_code,$ccl->cc_type,$ccl->cc_name_code,$ccl->cc_name,$ccl->cc_status,$ccl->cc_use_quotation,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->cc_no." cost center insert ";
                }
                else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE cost_center SET `cc_no`=?, `cc_type_code`=?, `cc_type`=?, `cc_name_code`=?, `cc_name`=?, `cc_status`=?,`cc_use_quotation`=?, `created_at`=?, `updated_at`=? WHERE cc_no=?'),
                            array($ccl->cc_no,$ccl->cc_type_code,$ccl->cc_type,$ccl->cc_name_code,$ccl->cc_name,$ccl->cc_status,$ccl->cc_use_quotation,$ccl->created_at,$ccl->updated_at,$ccl->cc_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $cost_center= DB::connection('mysql3')->select("SELECT * FROM cost_center_edits");
            $cost_center2= DB::connection('mysql')->select("SELECT * FROM cost_center_edits");
            foreach($cost_center as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($cost_center2 as $ccl2){
                    if($ccl->cc_name_code==$ccl2->cc_name_code ){
                        $dup=1;
                        $uid=$ccl2->cc_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into cost_center_edits (`cc_no`, `cc_type_code`, `cc_type`, `cc_name_code`, `cc_name`, `cc_status`,`cc_use_quotation`,`edit_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->cc_no,$ccl->cc_type_code,$ccl->cc_type,$ccl->cc_name_code,$ccl->cc_name,$ccl->cc_status,$ccl->cc_use_quotation,$ccl->edit_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->cc_no." cost center insert ";
                }
                else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE cost_center_edits SET `cc_no`=?, `cc_type_code`=?, `cc_type`=?, `cc_name_code`=?, `cc_name`=?, `cc_status`=?,`cc_use_quotation`=?,`edit_status`=?, `created_at`=?, `updated_at`=? WHERE cc_no=?'),
                            array($ccl->cc_no,$ccl->cc_type_code,$ccl->cc_type,$ccl->cc_name_code,$ccl->cc_name,$ccl->cc_status,$ccl->cc_use_quotation,$ccl->created_at,$ccl->edit_status,$ccl->updated_at,$ccl->cc_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $customers= DB::connection('mysql3')->select("SELECT * FROM customers");
            $customers2= DB::connection('mysql')->select("SELECT * FROM customers");
            foreach($customers as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($customers2 as $ccl2){
                    if($ccl2->customer_id==$ccl->customer_id){
                        $dup=1;
                        $uid=$ccl2->customer_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into customers (`customer_id`, `f_name`, `l_name`, `email`, `company`, `phone`, `mobile`, `fax`, `display_name`, `other`, `website`, `street`, `city`, `state`, `postal_code`, `country`, `payment_method`, `terms`, `opening_balance`, `as_of_date`, `account_no`, `business_id_no`, `notes`, `tin_no`, `attachment`, `withhold_tax`, `business_style`, `tax_type`, `vat_value`, `account_type`, `supplier_active`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->customer_id,$ccl->f_name,$ccl->l_name,$ccl->email,$ccl->company,$ccl->phone,$ccl->mobile,$ccl->fax,$ccl->display_name,$ccl->other,$ccl->website,$ccl->street,$ccl->city,$ccl->state,$ccl->postal_code,$ccl->country,$ccl->payment_method,$ccl->terms,$ccl->opening_balance,$ccl->as_of_date,$ccl->account_no,$ccl->business_id_no,$ccl->notes,$ccl->tin_no,$ccl->attachment,$ccl->withhold_tax,$ccl->business_style,$ccl->tax_type,$ccl->vat_value,$ccl->account_type,$ccl->supplier_active,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->customer_id." customer insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE customers SET `customer_id`=?, `f_name`=?, `l_name`=?, `email`=?, `company`=?, `phone`=?, `mobile`=?, `fax`=?, `display_name`=?, `other`=?, `website`=?, `street`=?, `city`=?, `state`=?, `postal_code`=?, `country`=?, `payment_method`=?, `terms`=?, `opening_balance`=?, `as_of_date`=?, `account_no`=?, `business_id_no`=?, `notes`=?, `tin_no`=?, `attachment`=?, `withhold_tax`=?, `business_style`=?, `tax_type`=?, `vat_value`=?, `account_type`=?, `supplier_active`=?, `created_at`=?, `updated_at`=? WHERE customer_id=?'),
                            array($ccl->customer_id,$ccl->f_name,$ccl->l_name,$ccl->email,$ccl->company,$ccl->phone,$ccl->mobile,$ccl->fax,$ccl->display_name,$ccl->other,$ccl->website,$ccl->street,$ccl->city,$ccl->state,$ccl->postal_code,$ccl->country,$ccl->payment_method,$ccl->terms,$ccl->opening_balance,$ccl->as_of_date,$ccl->account_no,$ccl->business_id_no,$ccl->notes,$ccl->tin_no,$ccl->attachment,$ccl->withhold_tax,$ccl->business_style,$ccl->tax_type,$ccl->vat_value,$ccl->account_type,$ccl->supplier_active,$ccl->created_at,$ccl->updated_at,$ccl->customer_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $customers= DB::connection('mysql3')->select("SELECT * FROM customers_edits");
            $customers2= DB::connection('mysql')->select("SELECT * FROM customers_edits");
            foreach($customers as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($customers2 as $ccl2){
                    if($ccl2->customer_id==$ccl->customer_id){
                        $dup=1;
                        $uid=$ccl2->customer_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into customers_edits (`customer_id`, `f_name`, `l_name`, `email`, `company`, `phone`, `mobile`, `fax`, `display_name`, `other`, `website`, `street`, `city`, `state`, `postal_code`, `country`, `payment_method`, `terms`, `opening_balance`, `as_of_date`, `account_no`, `business_id_no`, `notes`, `tin_no`, `attachment`, `withhold_tax`, `business_style`, `tax_type`, `vat_value`, `account_type`, `supplier_active`, `edit_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->customer_id,$ccl->f_name,$ccl->l_name,$ccl->email,$ccl->company,$ccl->phone,$ccl->mobile,$ccl->fax,$ccl->display_name,$ccl->other,$ccl->website,$ccl->street,$ccl->city,$ccl->state,$ccl->postal_code,$ccl->country,$ccl->payment_method,$ccl->terms,$ccl->opening_balance,$ccl->as_of_date,$ccl->account_no,$ccl->business_id_no,$ccl->notes,$ccl->tin_no,$ccl->attachment,$ccl->withhold_tax,$ccl->business_style,$ccl->tax_type,$ccl->vat_value,$ccl->account_type,$ccl->supplier_active,$ccl->edit_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->customer_id." customer insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE customers_edits SET `customer_id`=?, `f_name`=?, `l_name`=?, `email`=?, `company`=?, `phone`=?, `mobile`=?, `fax`=?, `display_name`=?, `other`=?, `website`=?, `street`=?, `city`=?, `state`=?, `postal_code`=?, `country`=?, `payment_method`=?, `terms`=?, `opening_balance`=?, `as_of_date`=?, `account_no`=?, `business_id_no`=?, `notes`=?, `tin_no`=?, `attachment`=?, `withhold_tax`=?, `business_style`=?, `tax_type`=?, `vat_value`=?, `account_type`=?, `supplier_active`=?,`edit_status`=?, `created_at`=?, `updated_at`=? WHERE customer_id=?'),
                            array($ccl->customer_id,$ccl->f_name,$ccl->l_name,$ccl->email,$ccl->company,$ccl->phone,$ccl->mobile,$ccl->fax,$ccl->display_name,$ccl->other,$ccl->website,$ccl->street,$ccl->city,$ccl->state,$ccl->postal_code,$ccl->country,$ccl->payment_method,$ccl->terms,$ccl->opening_balance,$ccl->as_of_date,$ccl->account_no,$ccl->business_id_no,$ccl->notes,$ccl->tin_no,$ccl->attachment,$ccl->withhold_tax,$ccl->business_style,$ccl->tax_type,$ccl->vat_value,$ccl->account_type,$ccl->supplier_active,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->customer_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $custom_form_style= DB::connection('mysql3')->select("SELECT * FROM custom_form_style");
            $custom_form_style2= DB::connection('mysql')->select("SELECT * FROM custom_form_style");
            foreach($custom_form_style as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($custom_form_style2 as $ccl2){
                    if($ccl2->cfs_id==$ccl->cfs_id){
                        $dup=1;
                        $uid=$ccl2->cfs_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into custom_form_style (`cfs_id`, `cfs_name`, `cfs_design_template`, `cfs_logo_name`, `cfs_logo_show`, `cfs_logo_size`, `cfs_logo_alignment`, `cfs_theme_color`, `cfs_font_family`, `cfs_font_size`, `cfs_margin`, `cfs_company_name_check`, `cfs_company_name_value`, `cfs_phone_check`, `cfs_phone_value`, `cfs_email_check`, `cfs_email_value`, `cfs_crn_check`, `cfs_crn_value`, `cfs_business_address_check`, `cfs_website_check`, `cfs_website_value`, `cfs_form_name_check`, `cfs_form_name_value`, `cfs_form_number_check`, `cfs_shipping_check`, `cfs_terms_check`, `cfs_duedate_check`, `cfs_table_date_check`, `cfs_table_product_check`, `cfs_table_desc_check`, `cfs_table_qty_check`, `cfs_table_rate_check`, `cfs_table_amount_check`, `cfs_footer_message_value`, `cfs_footer_message_font_size`, `cfs_footer_text_value`, `cfs_footer_text_font_size`, `cfs_footer_text_position`, `cfs_email_subject`, `cfs_email_use_greeting`, `cfs_email_greeting_pronoun`, `cfs_email_greeting_word`, `cfs_email_message`, `cfs_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->cfs_id,
                            $ccl->cfs_name,
                            $ccl->cfs_design_template,
                            $ccl->cfs_logo_name,
                            $ccl->cfs_logo_show,
                            $ccl->cfs_logo_size,
                            $ccl->cfs_logo_alignment,
                            $ccl->cfs_theme_color,
                            $ccl->cfs_font_family,
                            $ccl->cfs_font_size,
                            $ccl->cfs_margin,
                            $ccl->cfs_company_name_check,
                            $ccl->cfs_company_name_value,
                            $ccl->cfs_phone_check,
                            $ccl->cfs_phone_value,
                            $ccl->cfs_email_check,
                            $ccl->cfs_email_value,
                            $ccl->cfs_crn_check,
                            $ccl->cfs_crn_value,
                            $ccl->cfs_business_address_check,
                            $ccl->cfs_website_check,
                            $ccl->cfs_website_value,
                            $ccl->cfs_form_name_check,
                            $ccl->cfs_form_name_value,
                            $ccl->cfs_form_number_check,
                            $ccl->cfs_shipping_check,
                            $ccl->cfs_terms_check,
                            $ccl->cfs_duedate_check,
                            $ccl->cfs_table_date_check,
                            $ccl->cfs_table_product_check,
                            $ccl->cfs_table_desc_check,
                            $ccl->cfs_table_qty_check,
                            $ccl->cfs_table_rate_check,
                            $ccl->cfs_table_amount_check,
                            $ccl->cfs_footer_message_value,
                            $ccl->cfs_footer_message_font_size,
                            $ccl->cfs_footer_text_value,
                            $ccl->cfs_footer_text_font_size,
                            $ccl->cfs_footer_text_position,
                            $ccl->cfs_email_subject,
                            $ccl->cfs_email_use_greeting,
                            $ccl->cfs_email_greeting_pronoun,
                            $ccl->cfs_email_greeting_word,
                            $ccl->cfs_email_message,
                            $ccl->cfs_status,
                            $ccl->created_at,
                            $ccl->updated_at)
                    );
                    echo $ccl->cfs_id." custom form style insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE custom_form_style SET `cfs_id`=?, `cfs_name`=?, `cfs_design_template`=?, `cfs_logo_name`=?, `cfs_logo_show`=?, `cfs_logo_size`=?, `cfs_logo_alignment`=?, `cfs_theme_color`=?, `cfs_font_family`=?, `cfs_font_size`=?, `cfs_margin`=?, `cfs_company_name_check`=?, `cfs_company_name_value`=?, `cfs_phone_check`=?, `cfs_phone_value`=?, `cfs_email_check`=?, `cfs_email_value`=?, `cfs_crn_check`=?, `cfs_crn_value`=?, `cfs_business_address_check`=?, `cfs_website_check`=?, `cfs_website_value`=?, `cfs_form_name_check`=?, `cfs_form_name_value`=?, `cfs_form_number_check`=?, `cfs_shipping_check`=?, `cfs_terms_check`=?, `cfs_duedate_check`=?, `cfs_table_date_check`=?, `cfs_table_product_check`=?, `cfs_table_desc_check`=?, `cfs_table_qty_check`=?, `cfs_table_rate_check`=?, `cfs_table_amount_check`=?, `cfs_footer_message_value`=?, `cfs_footer_message_font_size`=?, `cfs_footer_text_value`=?, `cfs_footer_text_font_size`=?, `cfs_footer_text_position`=?, `cfs_email_subject`=?, `cfs_email_use_greeting`=?, `cfs_email_greeting_pronoun`=?, `cfs_email_greeting_word`=?, `cfs_email_message`=?, `cfs_status`=?, `created_at`=?, `updated_at`=? WHERE cfs_id=?'),
                            array($ccl->cfs_id,
                            $ccl->cfs_name,
                            $ccl->cfs_design_template,
                            $ccl->cfs_logo_name,
                            $ccl->cfs_logo_show,
                            $ccl->cfs_logo_size,
                            $ccl->cfs_logo_alignment,
                            $ccl->cfs_theme_color,
                            $ccl->cfs_font_family,
                            $ccl->cfs_font_size,
                            $ccl->cfs_margin,
                            $ccl->cfs_company_name_check,
                            $ccl->cfs_company_name_value,
                            $ccl->cfs_phone_check,
                            $ccl->cfs_phone_value,
                            $ccl->cfs_email_check,
                            $ccl->cfs_email_value,
                            $ccl->cfs_crn_check,
                            $ccl->cfs_crn_value,
                            $ccl->cfs_business_address_check,
                            $ccl->cfs_website_check,
                            $ccl->cfs_website_value,
                            $ccl->cfs_form_name_check,
                            $ccl->cfs_form_name_value,
                            $ccl->cfs_form_number_check,
                            $ccl->cfs_shipping_check,
                            $ccl->cfs_terms_check,
                            $ccl->cfs_duedate_check,
                            $ccl->cfs_table_date_check,
                            $ccl->cfs_table_product_check,
                            $ccl->cfs_table_desc_check,
                            $ccl->cfs_table_qty_check,
                            $ccl->cfs_table_rate_check,
                            $ccl->cfs_table_amount_check,
                            $ccl->cfs_footer_message_value,
                            $ccl->cfs_footer_message_font_size,
                            $ccl->cfs_footer_text_value,
                            $ccl->cfs_footer_text_font_size,
                            $ccl->cfs_footer_text_position,
                            $ccl->cfs_email_subject,
                            $ccl->cfs_email_use_greeting,
                            $ccl->cfs_email_greeting_pronoun,
                            $ccl->cfs_email_greeting_word,
                            $ccl->cfs_email_message,
                            $ccl->cfs_status,
                            $ccl->created_at,
                            $ccl->updated_at,
                            $ccl->cfs_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

            $deposit_record= DB::connection('mysql3')->select("SELECT * FROM deposit_record");
            $deposit_record2= DB::connection('mysql')->select("SELECT * FROM deposit_record");
            foreach($deposit_record as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($deposit_record2 as $ccl2){
                    if($ccl2->deposit_record_no==$ccl->deposit_record_no){
                        $dup=1;
                        $uid=$ccl2->deposit_record_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into deposit_record (`deposit_record_no`, `deposit_to`, `bank_account`, `deposit_record_date`, `deposit_record_memo`, `deposit_record_transaction_no`, `deposit_record_group_no`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?)'),
                        array($ccl->deposit_record_no,$ccl->deposit_to,$ccl->bank_account,$ccl->deposit_record_date,$ccl->deposit_record_memo,$ccl->deposit_record_transaction_no,$ccl->deposit_record_group_no,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->deposit_record_no." deposit_record insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE deposit_record SET `deposit_record_no`=?, `deposit_to`=?, `bank_account`=?, `deposit_record_date`=?, `deposit_record_memo`=?, `deposit_record_transaction_no`=?, `deposit_record_group_no`=?, `created_at`=?, `updated_at`=? WHERE deposit_record_no=?'),
                            array($ccl->deposit_record_no,$ccl->deposit_to,$ccl->bank_account,$ccl->deposit_record_date,$ccl->deposit_record_memo,$ccl->deposit_record_transaction_no,$ccl->deposit_record_group_no,$ccl->created_at,$ccl->updated_at,$ccl->deposit_record_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";

                    }
                }
            }
            $expense_transactions= DB::connection('mysql3')->select("SELECT * FROM expense_transactions");
            $expense_transactions2= DB::connection('mysql')->select("SELECT * FROM expense_transactions");
            foreach($expense_transactions as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($expense_transactions2 as $ccl2){
                    if($ccl2->et_no==$ccl->et_no && $ccl->et_type==$ccl2->et_type){
                        $dup=1;
                        $uid=$ccl2->et_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into expense_transactions (`et_no`, `et_customer`, `et_email`, `et_billing_address`, `et_account`, `et_payment_method`, `et_terms`, `et_date`, `et_due_date`, `et_bill_no`, `et_message`, `et_memo`, `et_attachment`, `et_reference_no`, `et_shipping_address`, `et_shipping_to`, `et_shipping_via`, `et_type`, `remark`, `cancellation_date`, `cancellation_reason`, `et_bil_status`, `created_at`, `updated_at`,`et_credit_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->created_at,$ccl->updated_at,$ccl->et_credit_account)
                    );
                    echo $ccl->et_no." expense transaction insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE expense_transactions SET `et_no`=?, `et_customer`=?, `et_email`=?, `et_billing_address`=?, `et_account`=?, `et_payment_method`=?, `et_terms`=?, `et_date`=?, `et_due_date`=?, `et_bill_no`=?, `et_message`=?, `et_memo`=?, `et_attachment`=?, `et_reference_no`=?, `et_shipping_address`=?, `et_shipping_to`=?, `et_shipping_via`=?, `et_type`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `et_bil_status`=?, `created_at`=?, `updated_at`=?,`et_credit_account`=? WHERE et_no=?'),
                            array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->created_at,$ccl->updated_at,$ccl->et_credit_account,$ccl->et_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $expense_transactions= DB::connection('mysql3')->select("SELECT * FROM expense_transactions_edits");
            $expense_transactions2= DB::connection('mysql')->select("SELECT * FROM expense_transactions_edits");
            foreach($expense_transactions as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($expense_transactions2 as $ccl2){
                    if($ccl2->et_no==$ccl->et_no && $ccl->et_type==$ccl2->et_type){
                        $dup=1;
                        $uid=$ccl2->et_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into expense_transactions_edits (`et_no`, `et_customer`, `et_email`, `et_billing_address`, `et_account`, `et_payment_method`, `et_terms`, `et_date`, `et_due_date`, `et_bill_no`, `et_message`, `et_memo`, `et_attachment`, `et_reference_no`, `et_shipping_address`, `et_shipping_to`, `et_shipping_via`, `et_type`, `remark`, `cancellation_date`, `cancellation_reason`, `et_bil_status`,`edit_status`, `created_at`, `updated_at`,`et_credit_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->et_credit_account)
                    );
                    echo $ccl->et_no." expense transaction edits insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE expense_transactions_edits SET `et_no`=?, `et_customer`=?, `et_email`=?, `et_billing_address`=?, `et_account`=?, `et_payment_method`=?, `et_terms`=?, `et_date`=?, `et_due_date`=?, `et_bill_no`=?, `et_message`=?, `et_memo`=?, `et_attachment`=?, `et_reference_no`=?, `et_shipping_address`=?, `et_shipping_to`=?, `et_shipping_via`=?, `et_type`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `et_bil_status`=?,`edit_status`=?, `created_at`=?, `updated_at`=?, `et_credit_account`=? WHERE et_no=?'),
                            array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->et_credit_account,$ccl->et_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $expense_transactions= DB::connection('mysql3')->select("SELECT * FROM expense_transactions_new");
            $expense_transactions2= DB::connection('mysql')->select("SELECT * FROM expense_transactions_new");
            foreach($expense_transactions as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($expense_transactions2 as $ccl2){
                    if($ccl2->et_no==$ccl->et_no && $ccl->et_type==$ccl2->et_type){
                        $dup=1;
                        $uid=$ccl2->et_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into expense_transactions_new (`et_no`, `et_customer`, `et_email`, `et_billing_address`, `et_account`, `et_payment_method`, `et_terms`, `et_date`, `et_due_date`, `et_bill_no`, `et_message`, `et_memo`, `et_attachment`, `et_reference_no`, `et_shipping_address`, `et_shipping_to`, `et_shipping_via`, `et_type`, `remark`, `cancellation_date`, `cancellation_reason`, `et_bil_status`,`et_debit_account`,`et_credit_account`, `created_at`, `updated_at`,`bill_balance`,`et_status`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->et_debit_account,$ccl->et_credit_account,$ccl->created_at,$ccl->updated_at,$ccl->bill_balance,$ccl->et_status)
                    );
                    echo $ccl->et_no." expense transaction new insert from original to cloud"; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE expense_transactions_new SET `et_no`=?, `et_customer`=?, `et_email`=?, `et_billing_address`=?, `et_account`=?, `et_payment_method`=?, `et_terms`=?, `et_date`=?, `et_due_date`=?, `et_bill_no`=?, `et_message`=?, `et_memo`=?, `et_attachment`=?, `et_reference_no`=?, `et_shipping_address`=?, `et_shipping_to`=?, `et_shipping_via`=?, `et_type`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `et_bil_status`=?,`et_debit_account`=?,`et_credit_account`=?, `created_at`=?, `updated_at`=?,`bill_balance`=?, `et_status`=? WHERE et_no=?'),
                            array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->et_debit_account,$ccl->et_credit_account,$ccl->created_at,$ccl->updated_at,$ccl->bill_balance,$ccl->et_status,$ccl->et_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $et_account_details= DB::connection('mysql3')->select("SELECT * FROM et_account_details");
            $et_account_details2= DB::connection('mysql')->select("SELECT * FROM et_account_details");
            foreach($et_account_details as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($et_account_details2 as $ccl2){
                    if( $ccl2->et_ad_qty==$ccl->et_ad_qty && $ccl2->et_ad_rate==$ccl->et_ad_rate && $ccl2->et_ad_type==$ccl->et_ad_type && $ccl2->created_at==$ccl->created_at){
                        $dup=1;
                        $uid=$ccl2->et_ad_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into et_account_details ( `et_ad_no`, `et_ad_product`, `et_ad_desc`, `et_ad_qty`, `et_ad_rate`, `et_ad_total`,`et_ad_type`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->et_ad_id." et_account details insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<=strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE et_account_details SET `et_ad_id`=?, `et_ad_no`=?, `et_ad_product`=?, `et_ad_desc`=?, `et_ad_qty`=?, `et_ad_rate`=?, `et_ad_total`=?,`et_ad_type`=?, `created_at`=?, `updated_at`=? WHERE created_at=? AND et_ad_qty=? AND et_ad_rate=? AND et_ad_type=?'),
                            array($ccl->et_ad_id,$ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->created_at,$ccl->updated_at,$ccl->created_at,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_type)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." et account detail";
                    }
                }
            }
            $et_account_details= DB::connection('mysql3')->select("SELECT * FROM et_account_details_edits");
            $et_account_details2= DB::connection('mysql')->select("SELECT * FROM et_account_details_edits");
            foreach($et_account_details as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($et_account_details2 as $ccl2){
                    if($ccl2->et_ad_qty==$ccl->et_ad_qty && $ccl2->et_ad_rate==$ccl->et_ad_rate && $ccl2->created_at==$ccl->created_at && $ccl2->et_ad_type==$ccl->et_ad_type){
                        $dup=1;
                        $uid=$ccl2->et_ad_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into et_account_details_edits ( `et_ad_no`, `et_ad_product`, `et_ad_desc`, `et_ad_qty`, `et_ad_rate`, `et_ad_total`,`et_ad_type`,`edit_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->edit_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->et_ad_id." et_account details insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<=strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE et_account_details_edits SET `et_ad_id`=?, `et_ad_no`=?, `et_ad_product`=?, `et_ad_desc`=?, `et_ad_qty`=?, `et_ad_rate`=?, `et_ad_total`=?,`et_ad_type`=?,`edit_status`=?, `created_at`=?, `updated_at`=? WHERE created_at=? AND et_ad_qty=? AND et_ad_rate=? AND et_ad_type=?'),
                            array($ccl->et_ad_id,$ccl->et_ad_no,$ccl->et_ad_product,$ccl->created_at,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->created_at,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_type)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." et account detail edit";
                    }
                }
            }
            $et_account_details= DB::connection('mysql3')->select("SELECT * FROM et_account_details_new");
            $et_account_details2= DB::connection('mysql')->select("SELECT * FROM et_account_details_new");
            foreach($et_account_details as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($et_account_details2 as $ccl2){
                    if($ccl2->et_ad_qty==$ccl->et_ad_qty  && $ccl2->et_ad_no==$ccl->et_ad_no && $ccl2->et_ad_rate==$ccl->et_ad_rate && $ccl2->et_ad_type==$ccl->et_ad_type){
                        $dup=1;
                        $uid=$ccl2->et_ad_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into et_account_details_new (`et_ad_id`, `et_ad_no`, `et_ad_product`, `et_ad_desc`, `et_ad_qty`, `et_ad_rate`, `et_ad_total`,`et_ad_type`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_ad_id,$ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->et_ad_id." et_account details new insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE et_account_details_new SET `et_ad_id`=?, `et_ad_no`=?, `et_ad_product`=?, `et_ad_desc`=?, `et_ad_qty`=?, `et_ad_rate`=?, `et_ad_total`=?,`et_ad_type`=?, `created_at`=?, `updated_at`=? WHERE et_ad_id=?'),
                            array($ccl->et_ad_id,$ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->created_at,$ccl->updated_at,$ccl->et_ad_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $favorite_report= DB::connection('mysql3')->select("SELECT * FROM favorite_report");
            $favorite_report2= DB::connection('mysql')->select("SELECT * FROM favorite_report");
            //as is

            $journal_entries= DB::connection('mysql3')->select("SELECT * FROM journal_entries");
            $journal_entries2= DB::connection('mysql')->select("SELECT * FROM journal_entries");
            foreach($journal_entries as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($journal_entries2 as $ccl2){
                    if($ccl2->je_no==$ccl->je_no && $ccl2->je_id==$ccl->je_id && $ccl2->other_no==$ccl->other_no && $ccl2->create_point==$ccl->create_point && $ccl2->je_invoice_location_and_type==$ccl->je_invoice_location_and_type){
                        $dup=1;
                        $uid=$ccl2->je_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into journal_entries (`je_id`, `je_no`, `je_account`, `je_debit`, `je_credit`, `je_desc`, `je_name`, `je_memo`, `je_attachment`, `je_transaction_type`, `other_no`, `remark`, `cancellation_date`, `cancellation_reason`, `je_cost_center`,`je_invoice_location_and_type`, `created_at`, `updated_at`,`create_point`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->je_id,$ccl->je_no,$ccl->je_account,$ccl->je_debit,$ccl->je_credit,$ccl->je_desc,$ccl->je_name,$ccl->je_memo,$ccl->je_attachment,$ccl->je_transaction_type,$ccl->other_no,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->je_cost_center,$ccl->je_invoice_location_and_type,$ccl->created_at,$ccl->updated_at,$ccl->create_point)
                    );
                    echo $ccl->je_no." Journal Entry insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<=strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE journal_entries SET `je_id`=?, `je_no`=?, `je_account`=?, `je_debit`=?, `je_credit`=?, `je_desc`=?, `je_name`=?, `je_memo`=?, `je_attachment`=?, `je_transaction_type`=?, `other_no`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `je_cost_center`=?,`je_invoice_location_and_type`=?, `created_at`=?, `updated_at`=?,`create_point`=? WHERE create_point=? AND je_id=? AND je_no=? AND other_no=? AND je_invoice_location_and_type=?'),
                            array($ccl->je_id,$ccl->je_no,$ccl->je_account,$ccl->je_debit,$ccl->je_credit,$ccl->je_desc,$ccl->je_name,$ccl->je_memo,$ccl->je_attachment,$ccl->je_transaction_type,$ccl->other_no,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->je_cost_center,$ccl->je_invoice_location_and_type,$ccl->created_at,$ccl->updated_at,$ccl->create_point,$ccl->create_point,$ccl->je_id,$ccl->je_no,$ccl->other_no,$ccl->je_invoice_location_and_type)
                        );
                        echo  "Journal Entry : ".$updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

            $numbering_system= DB::connection('mysql3')->select("SELECT * FROM numbering_system");
            $numbering_system2= DB::connection('mysql')->select("SELECT * FROM numbering_system");
            foreach($numbering_system as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($numbering_system2 as $ccl2){
                    if($ccl2->numbering_no==$ccl->numbering_no){
                        $dup=1;
                        $uid=$ccl2->numbering_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into numbering_system (`numbering_no`, `cash_voucher_start_no`, `sales_exp_start_no`, `cheque_voucher_start_no`, `use_cost_center`, `created_at`, `updated_at`, `numbering_bill_invoice_main` ,`numbering_sales_invoice_branch` ,`numbering_bill_invoice_branch` ,`credit_note_start_no`,`sales_receipt_start_no`,`bill_start_no`,`suppliers_credit_start_no`,`estimate_start_no`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->numbering_no,$ccl->cash_voucher_start_no,$ccl->sales_exp_start_no,$ccl->cheque_voucher_start_no,$ccl->use_cost_center,$ccl->created_at,$ccl->updated_at,$ccl->numbering_bill_invoice_main,$ccl->numbering_sales_invoice_branch,$ccl->numbering_bill_invoice_branch,$ccl->credit_note_start_no,$ccl->sales_receipt_start_no,$ccl->bill_start_no,$ccl->suppliers_credit_start_no,$ccl->estimate_start_no)
                    );
                    echo $ccl->numbering_no." numbering_system insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE numbering_system SET `numbering_no`=?, `cash_voucher_start_no`=?, `sales_exp_start_no`=?, `cheque_voucher_start_no`=?, `use_cost_center`=?, `created_at`=?, `updated_at`=? , `numbering_bill_invoice_main`=? ,`numbering_sales_invoice_branch`=? ,`numbering_bill_invoice_branch`=? ,`credit_note_start_no`=?,`sales_receipt_start_no`=?,`bill_start_no`=?,`suppliers_credit_start_no`=?,`estimate_start_no`=? WHERE numbering_no=? '),
                            array($ccl->numbering_no,$ccl->cash_voucher_start_no,$ccl->sales_exp_start_no,$ccl->cheque_voucher_start_no,$ccl->use_cost_center,$ccl->created_at,$ccl->updated_at,$ccl->numbering_bill_invoice_main,$ccl->numbering_sales_invoice_branch,$ccl->numbering_bill_invoice_branch,$ccl->credit_note_start_no,$ccl->sales_receipt_start_no,$ccl->bill_start_no,$ccl->suppliers_credit_start_no,$ccl->estimate_start_no,$ccl->numbering_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $password_resets= DB::connection('mysql3')->select("SELECT * FROM password_resets");
            $password_resets2= DB::connection('mysql')->select("SELECT * FROM password_resets");
            foreach($password_resets as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($password_resets2 as $ccl2){
                    if($ccl2->email==$ccl->email){
                        $dup=1;
                        $uid=$ccl2->numbering_no;
                        $updated_at=$ccl2->created_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into password_resets (email,token,created_at) values (?,?,?)'),
                        array($ccl->email,$ccl->token,$ccl->created_at)
                    );
                    echo $ccl->email." numbering_system insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->created_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE numbering_system SET email=?,token=?,created_at=? WHERE email=? '),
                            array($ccl->email,$ccl->token,$ccl->created_at,$ccl->email)
                        );
                        echo  $updated_at." < ". $ccl->created_at." ";
                    }
                }
            }

            $pay_bill= DB::connection('mysql3')->select("SELECT * FROM pay_bill");
            $pay_bill2= DB::connection('mysql')->select("SELECT * FROM pay_bill");
            foreach($pay_bill as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($pay_bill2 as $ccl2){
                    if($ccl2->pay_bill_no==$ccl->pay_bill_no){
                        $dup=1;
                        $uid=$ccl2->pay_bill_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into pay_bill (`pay_bill_no`, `payment_account`, `payment_date`, `payment_bank_account`, `pay_bill_group_no`, `bill_no`,`bill_payment_amount`,`payment_remark`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->pay_bill_no,$ccl->payment_account,$ccl->payment_date,$ccl->payment_bank_account,$ccl->pay_bill_group_no,$ccl->bill_no,$ccl->bill_payment_amount,$ccl->payment_remark,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->pay_bill_no." pay_bill insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE pay_bill SET `pay_bill_no`=?, `payment_account`=?, `payment_date`=?, `payment_bank_account`=?, `pay_bill_group_no`=?, `bill_no`=?,`bill_payment_amount`=?,`payment_remark`=?, `created_at`=?, `updated_at`=? WHERE pay_bill_no=? '),
                            array($ccl->pay_bill_no,$ccl->payment_account,$ccl->payment_date,$ccl->payment_bank_account,$ccl->pay_bill_group_no,$ccl->bill_no,$ccl->bill_payment_amount,$ccl->payment_remark,$ccl->created_at,$ccl->updated_at,$ccl->pay_bill_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $products_and_services= DB::connection('mysql3')->select("SELECT * FROM products_and_services");
            $products_and_services2= DB::connection('mysql')->select("SELECT * FROM products_and_services");
            foreach($products_and_services as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($products_and_services2 as $ccl2){
                    if($ccl2->product_id==$ccl->product_id){
                        $dup=1;
                        $uid=$ccl2->product_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into products_and_services (`product_id`, `product_name`, `product_sku`, `product_type`, `product_sales_description`, `product_sales_price`, `product_cost`, `product_qty`, `product_reorder_point`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->product_id,$ccl->product_name,$ccl->product_sku,$ccl->product_type,$ccl->product_sales_description,$ccl->product_sales_price,$ccl->product_cost,$ccl->product_qty,$ccl->product_reorder_point,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->product_id." product and services insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE products_and_services SET `product_id`=?, `product_name`=?, `product_sku`=?, `product_type`=?, `product_sales_description`=?, `product_sales_price`=?, `product_cost`=?, `product_qty`=?, `product_reorder_point`=?, `created_at`=?, `updated_at`=? WHERE product_id=? '),
                            array($ccl->product_id,$ccl->product_name,$ccl->product_sku,$ccl->product_type,$ccl->product_sales_description,$ccl->product_sales_price,$ccl->product_cost,$ccl->product_qty,$ccl->product_reorder_point,$ccl->created_at,$ccl->updated_at,$ccl->product_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $products_and_services= DB::connection('mysql3')->select("SELECT * FROM products_and_services_edit");
            $products_and_services2= DB::connection('mysql')->select("SELECT * FROM products_and_services_edit");
            foreach($products_and_services as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($products_and_services2 as $ccl2){
                    if($ccl2->product_id==$ccl->product_id){
                        $dup=1;
                        $uid=$ccl2->product_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into products_and_services_edit (`product_id`, `product_name`, `product_sku`, `product_type`, `product_sales_description`, `product_sales_price`, `product_cost`, `product_qty`, `product_reorder_point`,`edit_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->product_id,$ccl->product_name,$ccl->product_sku,$ccl->product_type,$ccl->product_sales_description,$ccl->product_sales_price,$ccl->product_cost,$ccl->product_qty,$ccl->product_reorder_point,$ccl->edit_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->product_id." product and services insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE products_and_services_edit SET `product_id`=?, `product_name`=?, `product_sku`=?, `product_type`=?, `product_sales_description`=?, `product_sales_price`=?, `product_cost`=?, `product_qty`=?, `product_reorder_point`=?,`edit_status`=?, `created_at`=?, `updated_at`=? WHERE product_id=? '),
                            array($ccl->product_id,$ccl->product_name,$ccl->product_sku,$ccl->product_type,$ccl->product_sales_description,$ccl->product_sales_price,$ccl->product_cost,$ccl->product_qty,$ccl->product_reorder_point,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->product_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM purchase_orders");
            $table2= DB::connection('mysql')->select("SELECT * FROM purchase_orders");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->po_no==$ccl->po_no){
                        $dup=1;
                        $uid=$ccl2->po_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into purchase_orders (`po_no`, `po_customer`, `po_requestor`, `po_cost_center`, `po_date`, `po_status`, `po_delivery_date`, `po_note`, `po_total`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->po_no,$ccl->po_customer,$ccl->po_requestor,$ccl->po_cost_center,$ccl->po_date,$ccl->po_status,$ccl->po_delivery_date,$ccl->po_note,$ccl->po_total,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->po_no." purchase_orders insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE purchase_orders SET `po_no`=?, `po_customer`=?, `po_requestor`=?, `po_cost_center`=?, `po_date`=?, `po_status`=?, `po_delivery_date`=?, `po_note`=?, `po_total`=?, `created_at`=?, `updated_at`=? WHERE po_no=? '),
                            array($ccl->po_no,$ccl->po_customer,$ccl->po_requestor,$ccl->po_cost_center,$ccl->po_date,$ccl->po_status,$ccl->po_delivery_date,$ccl->po_note,$ccl->po_total,$ccl->created_at,$ccl->updated_at,$ccl->po_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM po_item_details");
            $table2= DB::connection('mysql')->select("SELECT * FROM po_item_details");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->po_id_id==$ccl->po_id_id && $ccl2->po_id_no==$ccl->po_id_no){
                        $dup=1;
                        $uid=$ccl2->po_id_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into po_item_details (`po_id_id`, `po_id_no`, `po_product_id`, `po_product_desc`, `po_qty`, `po_product_rate`, `po_product_total`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?)'),
                        array($ccl->po_id_id,$ccl->po_id_no,$ccl->po_product_id,$ccl->po_product_desc,$ccl->po_qty,$ccl->po_product_rate,$ccl->po_product_total,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->po_id_id." po_item_details insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE po_item_details SET `po_id_id`=?, `po_id_no`=?, `po_product_id`=?, `po_product_desc`=?, `po_qty`=?, `po_product_rate`=?, `po_product_total`=?, `created_at`=?, `updated_at`=? WHERE po_id_id=? AND po_id_no=? '),
                            array($ccl->po_id_id,$ccl->po_id_no,$ccl->po_product_id,$ccl->po_product_desc,$ccl->po_qty,$ccl->po_product_rate,$ccl->po_product_total,$ccl->created_at,$ccl->updated_at,$ccl->po_id_id,$ccl->po_id_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM reports");
            $table2= DB::connection('mysql')->select("SELECT * FROM reports");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->report_id==$ccl->report_id){
                        $dup=1;
                        $uid=$ccl2->report_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into reports (`report_id`, `report_name`, `report_header`, `report_title`, `report_type`, `report_show_note`, `report_note`, `report_sort_by`, `report_sort_order`, `report_table_column`, `report_content_from`, `report_content_to`, `report_content_filter`, `report_content_cost_center_filter`, `report_url`, `report_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->report_id,$ccl->report_name,$ccl->report_header,$ccl->report_title,$ccl->report_type,$ccl->report_show_note,$ccl->report_note,$ccl->report_sort_by,$ccl->report_sort_order,$ccl->report_table_column,$ccl->report_content_from,$ccl->report_content_to,$ccl->report_content_filter,$ccl->report_content_cost_center_filter,$ccl->report_url,$ccl->report_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->report_id." report insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE reports SET `report_id`=?, `report_name`=?, `report_header`=?, `report_title`=?, `report_type`=?, `report_show_note`=?, `report_note`=?, `report_sort_by`=?, `report_sort_order`=?, `report_table_column`=?, `report_content_from`=?, `report_content_to`=?, `report_content_filter`=?, `report_content_cost_center_filter`=?, `report_url`=?, `report_status`=?, `created_at`=?, `updated_at`=? WHERE report_id=? '),
                            array($ccl->report_id,$ccl->report_name,$ccl->report_header,$ccl->report_title,$ccl->report_type,$ccl->report_show_note,$ccl->report_note,$ccl->report_sort_by,$ccl->report_sort_order,$ccl->report_table_column,$ccl->report_content_from,$ccl->report_content_to,$ccl->report_content_filter,$ccl->report_content_cost_center_filter,$ccl->report_url,$ccl->report_status,$ccl->created_at,$ccl->updated_at,$ccl->report_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM sales_transaction");
            $table2= DB::connection('mysql')->select("SELECT * FROM sales_transaction");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_no==$ccl->st_no && $ccl2->st_type==$ccl->st_type  && $ccl2->st_location==$ccl->st_location && $ccl2->st_invoice_type==$ccl->st_invoice_type ){
                        $dup=1;
                        $uid=$ccl2->st_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into sales_transaction (`st_no`, `st_date`, `st_type`, `st_term`, `st_customer_id`, `st_due_date`, `st_status`, `st_action`, `st_email`, `st_send_later`, `st_bill_address`, `st_note`, `st_memo`, `st_i_attachment`, `st_balance`, `st_amount_paid`, `st_payment_for`, `remark`, `cancellation_date`, `cancellation_reason`, `created_at`, `updated_at`,`st_location`,`st_invoice_type`,`st_invoice_job_order`,`st_invoice_work_no`,`st_debit_account`,`st_credit_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_no,$ccl->st_date,$ccl->st_type,$ccl->st_term,$ccl->st_customer_id,$ccl->st_due_date,$ccl->st_status,$ccl->st_action,$ccl->st_email,$ccl->st_send_later,$ccl->st_bill_address,$ccl->st_note,$ccl->st_memo,$ccl->st_i_attachment,$ccl->st_balance,$ccl->st_amount_paid,$ccl->st_payment_for,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->st_location,$ccl->st_invoice_type,$ccl->st_invoice_job_order,$ccl->st_invoice_work_no,$ccl->st_debit_account,$ccl->st_credit_account)
                    );
                    echo $ccl->st_no." sales transactrion insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE sales_transaction SET `st_no`=?, `st_date`=?, `st_type`=?, `st_term`=?, `st_customer_id`=?, `st_due_date`=?, `st_status`=?, `st_action`=?, `st_email`=?, `st_send_later`=?, `st_bill_address`=?, `st_note`=?, `st_memo`=?, `st_i_attachment`=?, `st_balance`=?, `st_amount_paid`=?, `st_payment_for`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `created_at`=?, `updated_at`=?,`st_location`=?,`st_invoice_type`=?,`st_invoice_job_order`=?,`st_invoice_work_no`=?,`st_debit_account`=?,`st_credit_account`=? WHERE st_no=? AND st_type=? AND st_location=? AND st_invoice_type=?'),
                            array($ccl->st_no,$ccl->st_date,$ccl->st_type,$ccl->st_term,$ccl->st_customer_id,$ccl->st_due_date,$ccl->st_status,$ccl->st_action,$ccl->st_email,$ccl->st_send_later,$ccl->st_bill_address,$ccl->st_note,$ccl->st_memo,$ccl->st_i_attachment,$ccl->st_balance,$ccl->st_amount_paid,$ccl->st_payment_for,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->st_location,$ccl->st_invoice_type,$ccl->st_invoice_job_order,$ccl->st_invoice_work_no,$ccl->st_debit_account,$ccl->st_credit_account,$ccl->st_no,$ccl->st_type,$ccl->st_location,$ccl->st_invoice_type)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." sales receipt";
                    }
                }

            }
            $table= DB::connection('mysql3')->select("SELECT * FROM sales_transaction_edits");
            $table2= DB::connection('mysql')->select("SELECT * FROM sales_transaction_edits");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_no==$ccl->st_no  && $ccl2->st_type==$ccl->st_type  && $ccl2->st_location==$ccl->st_location && $ccl2->st_invoice_type==$ccl->st_invoice_type){
                        $dup=1;
                        $uid=$ccl2->st_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into sales_transaction_edits (`st_no`, `st_date`, `st_type`, `st_term`, `st_customer_id`, `st_due_date`, `st_status`, `st_action`, `st_email`, `st_send_later`, `st_bill_address`, `st_note`, `st_memo`, `st_i_attachment`, `st_balance`, `st_amount_paid`, `st_payment_for`, `remark`, `cancellation_date`, `cancellation_reason`, `created_at`, `updated_at`,`st_location`,`st_invoice_type`,`st_invoice_job_order`,`st_invoice_work_no`,`st_debit_account`,`st_credit_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_no,$ccl->st_date,$ccl->st_type,$ccl->st_term,$ccl->st_customer_id,$ccl->st_due_date,$ccl->st_status,$ccl->st_action,$ccl->st_email,$ccl->st_send_later,$ccl->st_bill_address,$ccl->st_note,$ccl->st_memo,$ccl->st_i_attachment,$ccl->st_balance,$ccl->st_amount_paid,$ccl->st_payment_for,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->st_location,$ccl->st_invoice_type,$ccl->st_invoice_job_order,$ccl->st_invoice_work_no,$ccl->st_debit_account,$ccl->st_credit_account)
                    );
                    echo $ccl->st_no." sales transactrion insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE sales_transaction_edits SET `st_no`=?, `st_date`=?, `st_type`=?, `st_term`=?, `st_customer_id`=?, `st_due_date`=?, `st_status`=?, `st_action`=?, `st_email`=?, `st_send_later`=?, `st_bill_address`=?, `st_note`=?, `st_memo`=?, `st_i_attachment`=?, `st_balance`=?, `st_amount_paid`=?, `st_payment_for`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `created_at`=?, `updated_at`=?,`st_location`=?,`st_invoice_type`=?,`st_invoice_job_order`=?,`st_invoice_work_no`=?,`st_debit_account`=?,`st_credit_account`=? WHERE st_no=? '),
                            array($ccl->st_no,$ccl->st_date,$ccl->st_type,$ccl->st_term,$ccl->st_customer_id,$ccl->st_due_date,$ccl->st_status,$ccl->st_action,$ccl->st_email,$ccl->st_send_later,$ccl->st_bill_address,$ccl->st_note,$ccl->st_memo,$ccl->st_i_attachment,$ccl->st_balance,$ccl->st_amount_paid,$ccl->st_payment_for,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->st_location,$ccl->st_invoice_type,$ccl->st_invoice_job_order,$ccl->st_invoice_work_no,$ccl->st_debit_account,$ccl->st_credit_account,$ccl->st_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }

            }
            $table= DB::connection('mysql3')->select("SELECT * FROM settings_advance");
            $table2= DB::connection('mysql')->select("SELECT * FROM settings_advance");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->id==$ccl->id){
                        $dup=1;
                        $uid=$ccl2->id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into settings_advance (`id`, `setting_id`, `advance_first_month_of_fiscal_year`, `advance_first_month_of_tax_year`, `advance_accounting_method`, `advance_close_book`, `advance_tax_form`, `advance_enable_acc_number`, `advance_track_classes`, `advance_track_location`, `advance_prefill_form`, `advance_apply_credit`, `advance_invoice_unbilled_activity`, `advance_apply_bill_payment`, `advance_add_service_field`, `advance_single_time_activity_billable`, `advance_language`, `advance_home_currency`, `advance_multi_currency`, `advance_date_format`, `advance_number_format`, `advance_dup_cheque_num`, `advance_dup_bill_num`, `advance_inactive_time`,`advance_end_month_of_fiscal_year`,`advance_beginning_balance`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->id,$ccl->setting_id,$ccl->advance_first_month_of_fiscal_year,$ccl->advance_first_month_of_tax_year,$ccl->advance_accounting_method,$ccl->advance_close_book,$ccl->advance_tax_form,$ccl->advance_enable_acc_number,$ccl->advance_track_classes,$ccl->advance_track_location,$ccl->advance_prefill_form,$ccl->advance_apply_credit,$ccl->advance_invoice_unbilled_activity,$ccl->advance_apply_bill_payment,$ccl->advance_add_service_field,$ccl->advance_single_time_activity_billable,$ccl->advance_language,$ccl->advance_home_currency,$ccl->advance_multi_currency,$ccl->advance_date_format,$ccl->advance_number_format,$ccl->advance_dup_cheque_num,$ccl->advance_dup_bill_num,$ccl->advance_inactive_time,$ccl->advance_end_month_of_fiscal_year,$ccl->advance_beginning_balance,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->id." settings_advance insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE settings_advance SET `id`=?, `setting_id`=?, `advance_first_month_of_fiscal_year`=?, `advance_first_month_of_tax_year`=?, `advance_accounting_method`=?, `advance_close_book`=?, `advance_tax_form`=?, `advance_enable_acc_number`=?, `advance_track_classes`=?, `advance_track_location`=?, `advance_prefill_form`=?, `advance_apply_credit`=?, `advance_invoice_unbilled_activity`=?, `advance_apply_bill_payment`=?, `advance_add_service_field`=?, `advance_single_time_activity_billable`=?, `advance_language`=?, `advance_home_currency`=?, `advance_multi_currency`=?, `advance_date_format`=?, `advance_number_format`=?, `advance_dup_cheque_num`=?, `advance_dup_bill_num`=?, `advance_inactive_time`=?,`advance_end_month_of_fiscal_year`=?,`advance_beginning_balance`=?, `created_at`=?, `updated_at`=? WHERE id=? '),
                            array($ccl->id,$ccl->setting_id,$ccl->advance_first_month_of_fiscal_year,$ccl->advance_first_month_of_tax_year,$ccl->advance_accounting_method,$ccl->advance_close_book,$ccl->advance_tax_form,$ccl->advance_enable_acc_number,$ccl->advance_track_classes,$ccl->advance_track_location,$ccl->advance_prefill_form,$ccl->advance_apply_credit,$ccl->advance_invoice_unbilled_activity,$ccl->advance_apply_bill_payment,$ccl->advance_add_service_field,$ccl->advance_single_time_activity_billable,$ccl->advance_language,$ccl->advance_home_currency,$ccl->advance_multi_currency,$ccl->advance_date_format,$ccl->advance_number_format,$ccl->advance_dup_cheque_num,$ccl->advance_dup_bill_num,$ccl->advance_inactive_time,$ccl->advance_end_month_of_fiscal_year,$ccl->advance_beginning_balance,$ccl->created_at,$ccl->updated_at,$ccl->id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }

            }
            $table= DB::connection('mysql3')->select("SELECT * FROM settings_company");
            $table2= DB::connection('mysql')->select("SELECT * FROM settings_company");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->id==$ccl->id){
                        $dup=1;
                        $uid=$ccl2->id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into settings_company (`id`, `setting_id`, `company_name`, `company_legal_name`, `company_business_id_no`, `company_tax_form`, `company_industry`, `company_email`, `company_customer_facing_email`, `company_phone`, `company_website`, `company_address`, `company_customer_facing_address`, `company_legal_address`, `company_address_postal`, `facing_postal`, `legal_postal`, `company_logo`, `company_tin_no`, `esig`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->id,$ccl->setting_id,$ccl->company_name,$ccl->company_legal_name,$ccl->company_business_id_no,$ccl->company_tax_form,$ccl->company_industry,$ccl->company_email,$ccl->company_customer_facing_email,$ccl->company_phone,$ccl->company_website,$ccl->company_address,$ccl->company_customer_facing_address,$ccl->company_legal_address,$ccl->company_address_postal,$ccl->facing_postal,$ccl->legal_postal,$ccl->company_logo,$ccl->company_tin_no,$ccl->esig,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->id." settings_company insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE settings_company SET `id`=?, `setting_id`=?, `company_name`=?, `company_legal_name`=?, `company_business_id_no`=?, `company_tax_form`=?, `company_industry`=?, `company_email`=?, `company_customer_facing_email`=?, `company_phone`=?, `company_website`=?, `company_address`=?, `company_customer_facing_address`=?, `company_legal_address`=?, `company_address_postal`=?, `facing_postal`=?, `legal_postal`=?, `company_logo`=?, `company_tin_no`=?, `esig`=?, `created_at`=?, `updated_at`=? WHERE id=? '),
                            array($ccl->id,$ccl->setting_id,$ccl->company_name,$ccl->company_legal_name,$ccl->company_business_id_no,$ccl->company_tax_form,$ccl->company_industry,$ccl->company_email,$ccl->company_customer_facing_email,$ccl->company_phone,$ccl->company_website,$ccl->company_address,$ccl->company_customer_facing_address,$ccl->company_legal_address,$ccl->company_address_postal,$ccl->facing_postal,$ccl->legal_postal,$ccl->company_logo,$ccl->company_tin_no,$ccl->esig,$ccl->created_at,$ccl->updated_at,$ccl->id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM settings_expenses");
            $table2= DB::connection('mysql')->select("SELECT * FROM settings_expenses");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->id==$ccl->id){
                        $dup=1;
                        $uid=$ccl2->id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into settings_expenses (`id`, `setting_id`, `expenses_show_items_table`, `expenses_track_expense_and_item_by_customer`, `expenses_billable`, `expenses_bill_payment_terms`, `expenses_use_purchase_order`, `expenses_purchase_order_email_message`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->id,$ccl->setting_id,$ccl->expenses_show_items_table,$ccl->expenses_track_expense_and_item_by_customer,$ccl->expenses_billable,$ccl->expenses_bill_payment_terms,$ccl->expenses_use_purchase_order,$ccl->expenses_purchase_order_email_message,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->id." settings_expenses insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE settings_expenses SET `id`=?, `setting_id`=?, `expenses_show_items_table`=?, `expenses_track_expense_and_item_by_customer`=?, `expenses_billable`=?, `expenses_bill_payment_terms`=?, `expenses_use_purchase_order`=?, `expenses_purchase_order_email_message`=?, `created_at`=?, `updated_at`=? WHERE id=? '),
                            array($ccl->id,$ccl->setting_id,$ccl->expenses_show_items_table,$ccl->expenses_track_expense_and_item_by_customer,$ccl->expenses_billable,$ccl->expenses_bill_payment_terms,$ccl->expenses_use_purchase_order,$ccl->expenses_purchase_order_email_message,$ccl->created_at,$ccl->updated_at,$ccl->id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM settings_sales");
            $table2= DB::connection('mysql')->select("SELECT * FROM settings_sales");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->id==$ccl->id){
                        $dup=1;
                        $uid=$ccl2->id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into settings_sales (`id`, `setting_id`, `sales_preferred_invoice_term`, `sales_preferred_delivery_method`, `sales_shipping`, `sales_custom_field`, `sales_custom_transaction_number`, `sales_service_date`, `sales_discount`, `sales_deposit`, `sales_show_product_column`, `sales_show_sku_column`, `sales_track_quantity_and_price`, `sales_track_quantity_on_hand`, `sales_form_email_message`, `sales_default_reminder_message`, `sales_email_option`, `sales_show_aging_table`, `created_at`, `updated_at`,`sales_sales_receipt_preferred_debit_cheque_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->id,$ccl->setting_id,$ccl->sales_preferred_invoice_term,$ccl->sales_preferred_delivery_method,$ccl->sales_shipping,$ccl->sales_custom_field,$ccl->sales_custom_transaction_number,$ccl->sales_service_date,$ccl->sales_discount,$ccl->sales_deposit,$ccl->sales_show_product_column,$ccl->sales_show_sku_column,$ccl->sales_track_quantity_and_price,$ccl->sales_track_quantity_on_hand,$ccl->sales_form_email_message,$ccl->sales_default_reminder_message,$ccl->sales_email_option,$ccl->sales_show_aging_table,$ccl->created_at,$ccl->updated_at,$ccl->sales_sales_receipt_preferred_debit_cheque_account)
                    );
                    echo $ccl->id." settings_sales insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE settings_sales SET `id`=?, `setting_id`=?, `sales_preferred_invoice_term`=?, `sales_preferred_delivery_method`=?, `sales_shipping`=?, `sales_custom_field`=?, `sales_custom_transaction_number`=?, `sales_service_date`=?, `sales_discount`=?, `sales_deposit`=?, `sales_show_product_column`=?, `sales_show_sku_column`=?, `sales_track_quantity_and_price`=?, `sales_track_quantity_on_hand`=?, `sales_form_email_message`=?, `sales_default_reminder_message`=?, `sales_email_option`=?, `sales_show_aging_table`=?, `created_at`=?, `updated_at`=? , `sales_sales_receipt_preferred_debit_cheque_account`=? WHERE id=? '),
                            array($ccl->id,$ccl->setting_id,$ccl->sales_preferred_invoice_term,$ccl->sales_preferred_delivery_method,$ccl->sales_shipping,$ccl->sales_custom_field,$ccl->sales_custom_transaction_number,$ccl->sales_service_date,$ccl->sales_discount,$ccl->sales_deposit,$ccl->sales_show_product_column,$ccl->sales_show_sku_column,$ccl->sales_track_quantity_and_price,$ccl->sales_track_quantity_on_hand,$ccl->sales_form_email_message,$ccl->sales_default_reminder_message,$ccl->sales_email_option,$ccl->sales_show_aging_table,$ccl->created_at,$ccl->sales_sales_receipt_preferred_debit_cheque_account,$ccl->updated_at,$ccl->id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_credit_notes");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_credit_notes");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_cn_id==$ccl->st_cn_id){
                        $dup=1;
                        $uid=$ccl2->st_cn_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_credit_notes (`st_cn_id`, `st_cn_no`, `st_cn_product`, `st_cn_desc`, `st_cn_qty`, `st_cn_rate`, `st_cn_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_cn_id,$ccl->st_cn_no,$ccl->st_cn_product,$ccl->st_cn_desc,$ccl->st_cn_qty,$ccl->st_cn_rate,$ccl->st_cn_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_cn_id." st_credit_notes insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_credit_notes SET `st_cn_id`=?, `st_cn_no`=?, `st_cn_product`=?, `st_cn_desc`=?, `st_cn_qty`=?, `st_cn_rate`=?, `st_cn_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_cn_id=? '),
                            array($ccl->st_cn_id,$ccl->st_cn_no,$ccl->st_cn_product,$ccl->st_cn_desc,$ccl->st_cn_qty,$ccl->st_cn_rate,$ccl->st_cn_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_cn_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_credit_notes_edits");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_credit_notes_edits");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_cn_id==$ccl->st_cn_id){
                        $dup=1;
                        $uid=$ccl2->st_cn_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_credit_notes_edits (`st_cn_id`, `st_cn_no`, `st_cn_product`, `st_cn_desc`, `st_cn_qty`, `st_cn_rate`, `st_cn_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`,`edit_status`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_cn_id,$ccl->st_cn_no,$ccl->st_cn_product,$ccl->st_cn_desc,$ccl->st_cn_qty,$ccl->st_cn_rate,$ccl->st_cn_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->edit_status)
                    );
                    echo $ccl->st_cn_id." st_credit_notes_edits insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_credit_notes_edits SET `st_cn_id`=?, `st_cn_no`=?, `st_cn_product`=?, `st_cn_desc`=?, `st_cn_qty`=?, `st_cn_rate`=?, `st_cn_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? ,`edit_status`=? WHERE st_cn_id=? '),
                            array($ccl->st_cn_id,$ccl->st_cn_no,$ccl->st_cn_product,$ccl->st_cn_desc,$ccl->st_cn_qty,$ccl->st_cn_rate,$ccl->st_cn_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->edit_status,$ccl->st_cn_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_delayed_charges");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_delayed_charges");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_dc_id==$ccl->st_dc_id){
                        $dup=1;
                        $uid=$ccl2->st_dc_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_delayed_charges (`st_dc_id`, `st_dc_no`, `st_dc_product`, `st_dc_desc`, `st_dc_qty`, `st_dc_rate`, `st_dc_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_dc_id,$ccl->st_dc_no,$ccl->st_dc_product,$ccl->st_dc_desc,$ccl->st_dc_qty,$ccl->st_dc_rate,$ccl->st_dc_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_dc_id." st_delayed_charges insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_delayed_charges SET `st_dc_id`=?, `st_dc_no`=?, `st_dc_product`=?, `st_dc_desc`=?, `st_dc_qty`=?, `st_dc_rate`=?, `st_dc_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_dc_id=? '),
                            array($ccl->st_dc_id,$ccl->st_dc_no,$ccl->st_dc_product,$ccl->st_dc_desc,$ccl->st_dc_qty,$ccl->st_dc_rate,$ccl->st_dc_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_dc_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_delayed_credits");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_delayed_credits");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_dcredit_id==$ccl->st_dcredit_id){
                        $dup=1;
                        $uid=$ccl2->st_dcredit_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_delayed_credits (`st_dcredit_id`, `st_dcredit_no`, `st_dcredit_product`, `st_dcredit_desc`, `st_dcredit_qty`, `st_dcredit_rate`, `st_dcredit_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_dcredit_id,$ccl->st_dcredit_no,$ccl->st_dcredit_product,$ccl->st_dcredit_desc,$ccl->st_dcredit_qty,$ccl->st_dcredit_rate,$ccl->st_dcredit_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_dcredit_id." st_delayed_credits insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_delayed_credits SET `st_dcredit_id`=?, `st_dcredit_no`=?, `st_dcredit_product`=?, `st_dcredit_desc`=?, `st_dcredit_qty`=?, `st_dcredit_rate`=?, `st_dcredit_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_dcredit_id=? '),
                            array($ccl->st_dcredit_id,$ccl->st_dcredit_no,$ccl->st_dcredit_product,$ccl->st_dcredit_desc,$ccl->st_dcredit_qty,$ccl->st_dcredit_rate,$ccl->st_dcredit_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_dcredit_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

            $table= DB::connection('mysql3')->select("SELECT * FROM st_estimates");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_estimates");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_e_id==$ccl->st_e_id){
                        $dup=1;
                        $uid=$ccl2->st_e_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_estimates (`st_e_id`, `st_e_no`, `st_e_product`, `st_e_desc`, `st_e_qty`, `st_e_rate`, `st_e_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_e_id,$ccl->st_e_no,$ccl->st_e_product,$ccl->st_e_desc,$ccl->st_e_qty,$ccl->st_e_rate,$ccl->st_e_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_e_id." st_estimates insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_estimates SET `st_e_id`=?, `st_e_no`=?, `st_e_product`=?, `st_e_desc`=?, `st_e_qty`=?, `st_e_rate`=?, `st_e_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_e_id=? '),
                            array($ccl->st_e_id,$ccl->st_e_no,$ccl->st_e_product,$ccl->st_e_desc,$ccl->st_e_qty,$ccl->st_e_rate,$ccl->st_e_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_e_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_invoice");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_invoice");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_i_item_no==$ccl->st_i_item_no && $ccl2->st_i_no==$ccl->st_i_no && $ccl2->st_p_location==$ccl->st_p_location && $ccl2->st_p_invoice_type==$ccl->st_p_invoice_type){
                        $dup=1;
                        $uid=$ccl2->st_i_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_invoice (`st_i_id`,`st_i_item_no`, `st_i_no`, `st_i_product`, `st_i_desc`, `st_i_qty`, `st_i_rate`, `st_i_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`,`st_p_location`,`st_p_invoice_type`,`st_p_cost_center`,`st_p_debit`,`st_p_credit`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_i_id,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_i_product,$ccl->st_i_desc,$ccl->st_i_qty,$ccl->st_i_rate,$ccl->st_i_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->st_p_cost_center,$ccl->st_p_debit,$ccl->st_p_credit)
                    );
                    echo $ccl->st_i_id." st_invoice insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_invoice SET `st_i_id`=?,`st_i_item_no`=?, `st_i_no`=?, `st_i_product`=?, `st_i_desc`=?, `st_i_qty`=?, `st_i_rate`=?, `st_i_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=?, `st_p_location`=?,`st_p_invoice_type`=?,`st_p_cost_center`=?,`st_p_debit`=?,`st_p_credit`=? WHERE st_i_item_no=? AND  st_i_no=? AND `st_p_location`=? AND `st_p_invoice_type`=?'),
                            array($ccl->st_i_id,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_i_product,$ccl->st_i_desc,$ccl->st_i_qty,$ccl->st_i_rate,$ccl->st_i_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->st_p_cost_center,$ccl->st_p_debit,$ccl->st_p_credit,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_p_location,$ccl->st_p_invoice_type)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." st_invoice";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_invoice_edit");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_invoice_edit");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_i_item_no==$ccl->st_i_item_no && $ccl2->st_i_no==$ccl->st_i_no && $ccl2->st_p_location==$ccl->st_p_location && $ccl2->st_p_invoice_type==$ccl->st_p_invoice_type && $ccl2->created_at==$ccl->created_at){
                        $dup=1;
                        $uid=$ccl2->st_i_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_invoice_edit (`st_i_id`, `st_i_no`, `st_i_product`, `st_i_desc`, `st_i_qty`, `st_i_rate`, `st_i_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`,`st_p_location`,`st_p_invoice_type`,`st_p_cost_center`,`edit_status`,`st_p_debit`,`st_p_credit`,`st_i_item_no`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_i_id,$ccl->st_i_no,$ccl->st_i_product,$ccl->st_i_desc,$ccl->st_i_qty,$ccl->st_i_rate,$ccl->st_i_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->st_p_cost_center,$ccl->edit_status,$ccl->st_p_debit,$ccl->st_p_credit,$ccl->st_i_item_no)
                    );
                    echo $ccl->st_i_id." st_invoice_edit insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<=strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_invoice_edit SET `st_i_id`=?,`st_i_item_no`=?, `st_i_no`=?, `st_i_product`=?, `st_i_desc`=?, `st_i_qty`=?, `st_i_rate`=?, `st_i_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=?, `st_p_location`=?,`st_p_invoice_type`=?,`st_p_cost_center`=?,`st_p_debit`=?,`st_p_credit`=?,`edit_status`=? WHERE st_i_item_no=? AND  st_i_no=? AND `st_p_location`=? AND `st_p_invoice_type`=? AND `created_at`=? '),
                            array($ccl->st_i_id,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_i_product,$ccl->st_i_desc,$ccl->st_i_qty,$ccl->st_i_rate,$ccl->st_i_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->st_p_cost_center,$ccl->st_p_debit,$ccl->st_p_credit,$ccl->edit_status,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->created_at)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." st_invoice edit";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_refund_receipts");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_refund_receipts");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_r_id==$ccl->st_r_id){
                        $dup=1;
                        $uid=$ccl2->st_r_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_refund_receipts (`st_r_id`, `st_r_no`, `st_r_product`, `st_r_desc`, `st_r_qty`, `st_r_rate`, `st_r_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_r_id,$ccl->st_r_no,$ccl->st_r_product,$ccl->st_r_desc,$ccl->st_r_qty,$ccl->st_r_rate,$ccl->st_r_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_r_id." st_refund_receipts insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_refund_receipts SET `st_r_id`=?, `st_r_no`=?, `st_r_product`=?, `st_r_desc`=?, `st_r_qty`=?, `st_r_rate`=?, `st_r_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_r_id=? '),
                            array($ccl->st_r_id,$ccl->st_r_no,$ccl->st_r_product,$ccl->st_r_desc,$ccl->st_r_qty,$ccl->st_r_rate,$ccl->st_r_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_r_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_sales_receipts");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_sales_receipts");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_s_id==$ccl->st_s_id){
                        $dup=1;
                        $uid=$ccl2->st_s_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_sales_receipts (`st_s_id`, `st_s_no`, `st_s_product`, `st_s_desc`, `st_s_qty`, `st_s_rate`, `st_s_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`,`invoice_no_link`, `created_at`, `updated_at`,`st_s_locaiton`,`st_s_invoice_type`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_s_id,$ccl->st_s_no,$ccl->st_s_product,$ccl->st_s_desc,$ccl->st_s_qty,$ccl->st_s_rate,$ccl->st_s_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->invoice_no_link,$ccl->created_at,$ccl->updated_at,$ccl->st_s_locaiton,$ccl->st_s_invoice_type)
                    );
                    echo $ccl->st_s_id." st_sales_receipts insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_sales_receipts SET `st_s_id`=?, `st_s_no`=?, `st_s_product`=?, `st_s_desc`=?, `st_s_qty`=?, `st_s_rate`=?, `st_s_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?,`invoice_no_link=?`, `created_at`=?, `updated_at`=? ,`st_s_locaiton`=?,`st_s_invoice_type`=? WHERE st_s_id=? '),
                            array($ccl->st_s_id,$ccl->st_s_no,$ccl->st_s_product,$ccl->st_s_desc,$ccl->st_s_qty,$ccl->st_s_rate,$ccl->st_s_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->invoice_no_link,$ccl->created_at,$ccl->updated_at,$ccl->st_s_locaiton,$ccl->st_s_invoice_type,$ccl->st_s_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

            $table= DB::connection('mysql3')->select("SELECT * FROM users");
            $table2= DB::connection('mysql')->select("SELECT * FROM users");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->email==$ccl->email){
                        $dup=1;
                        $uid=$ccl2->email;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into users (`name`, `email`, `position`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`,`approved_status`) values (?,?,?,?,?,?,?,?,?)'),
                        array($ccl->name,$ccl->email,$ccl->position,$ccl->email_verified_at,$ccl->password,$ccl->remember_token,$ccl->created_at,$ccl->updated_at,$ccl->approved_status)
                    );
                    echo $ccl->email." users insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE users SET `id`=?, `name`=?, `email`=?, `position`=?, `email_verified_at`=?, `password`=?, `remember_token`=?, `created_at`=?, `updated_at`=? ,`approved_status`=? WHERE email=? '),
                            array($ccl->id,$ccl->name,$ccl->email,$ccl->position,$ccl->email_verified_at,$ccl->password,$ccl->remember_token,$ccl->created_at,$ccl->updated_at,$ccl->approved_status,$ccl->email)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM users_access_restrictions");
            $table2= DB::connection('mysql')->select("SELECT * FROM users_access_restrictions");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->user_id==$ccl->user_id){
                        $dup=1;
                        $uid=$ccl2->user_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into users_access_restrictions (`user_id`, `approvals`, `journal_entry`, `sales`, `invoice`, `estimate`, `credit_note`, `sales_receipt`, `expense`, `bill`, `supplier_credit`, `pay_bills`, `reports`, `fund_feeds`, `chart_of_accounts`, `cost_center`, `settings`,`procurement_system`,`procurement_sub`,`approval_pending_bills`,`approval_bank`,`approval_coa`,`approval_cc`,`approval_customer`,`approval_supplier`,`approval_product_services`,`approval_sales`,`approval_expense`,`approval_boq`,`user_approval`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->user_id,$ccl->approvals,$ccl->journal_entry,$ccl->sales,$ccl->invoice,$ccl->estimate,$ccl->credit_note,$ccl->sales_receipt,$ccl->expense,$ccl->bill,$ccl->supplier_credit,$ccl->pay_bills,$ccl->reports,$ccl->fund_feeds,$ccl->chart_of_accounts,$ccl->cost_center,$ccl->settings,$ccl->procurement_system,$ccl->procurement_sub,$ccl->approval_pending_bills,$ccl->approval_bank,$ccl->approval_coa,$ccl->approval_cc,$ccl->approval_customer,$ccl->approval_supplier,$ccl->approval_product_services,$ccl->approval_sales,$ccl->approval_expense,$ccl->approval_boq,$ccl->user_approval,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->user_id." users_access_restrictions insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE users_access_restrictions SET `user_id`=?, `approvals`=?, `journal_entry`=?, `sales`=?, `invoice`=?, `estimate`=?, `credit_note`=?, `sales_receipt`=?, `expense`=?, `bill`=?, `supplier_credit`=?, `pay_bills`=?, `reports`=?, `fund_feeds`=?, `chart_of_accounts`=?, `cost_center`=?, `settings`=?, `created_at`=?, `updated_at`=?,`procurement_system`=?,`procurement_sub`=?,`approval_pending_bills`=?,`approval_bank`=?,`approval_coa`=?,`approval_cc`=?,`approval_customer`=?,`approval_supplier`=?,`approval_product_services`=?,`approval_sales`=?,`approval_expense`=?,`approval_boq`=?,`user_approval`=? WHERE `user_id`=? '),
                            array($ccl->user_id,$ccl->approvals,$ccl->journal_entry,$ccl->sales,$ccl->invoice,$ccl->estimate,$ccl->credit_note,$ccl->sales_receipt,$ccl->expense,$ccl->bill,$ccl->supplier_credit,$ccl->pay_bills,$ccl->reports,$ccl->fund_feeds,$ccl->chart_of_accounts,$ccl->cost_center,$ccl->settings,$ccl->procurement_system,$ccl->procurement_sub,$ccl->approval_pending_bills,$ccl->approval_bank,$ccl->approval_coa,$ccl->approval_cc,$ccl->approval_customer,$ccl->approval_supplier,$ccl->approval_product_services,$ccl->approval_sales,$ccl->approval_expense,$ccl->approval_boq,$ccl->user_approval,$ccl->created_at,$ccl->updated_at,$ccl->user_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM user_cost_center_access");
            $table2= DB::connection('mysql')->select("SELECT * FROM user_cost_center_access");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->use_id==$ccl->use_id && $ccl2->cost_center_id==$ccl->cost_center_id){
                        $dup=1;
                        $uid=$ccl2->use_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into user_cost_center_access (`use_id`, `cost_center_id`, `access_status`, `created_at`, `updated_at`) values (?,?,?,?,?)'),
                        array($ccl->use_id,$ccl->cost_center_id,$ccl->access_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->use_id." user_cost_center_access insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE user_cost_center_access SET `use_id`=?, `cost_center_id`=?, `access_status`=?, `created_at`=?, `updated_at`=? WHERE `use_id`=? AND cost_center_id=? '),
                            array($ccl->use_id,$ccl->cost_center_id,$ccl->access_status,$ccl->created_at,$ccl->updated_at,$ccl->use_id,$ccl->cost_center_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM voucher");
            $table2= DB::connection('mysql')->select("SELECT * FROM voucher");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->voucher_id==$ccl->voucher_id){
                        $dup=1;
                        $uid=$ccl2->voucher_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into voucher (`voucher_id`, `voucher_type`, `pay_to_order_of`, `voucher_no`, `voucher_date`, `received_from`, `received_from_bank`, `the_amount_of`, `bank`, `check_no`, `received_payment_by`, `prepared_by`, `certified_correct_by`, `approved_by`, `previous_voucher`, `remark`, `cancellation_date`, `cancellation_reason`, `created_at`, `updated_at`,`voucher_link_id`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->voucher_id,$ccl->voucher_type,$ccl->pay_to_order_of,$ccl->voucher_no,$ccl->voucher_date,$ccl->received_from,$ccl->received_from_bank,$ccl->the_amount_of,$ccl->bank,$ccl->check_no,$ccl->received_payment_by,$ccl->prepared_by,$ccl->certified_correct_by,$ccl->approved_by,$ccl->previous_voucher,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->voucher_link_id)
                    );
                    echo $ccl->voucher_id." voucher insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE voucher SET `voucher_id`=?, `voucher_type`=?, `pay_to_order_of`=?, `voucher_no`=?, `voucher_date`=?, `received_from`=?, `received_from_bank`=?, `the_amount_of`=?, `bank`=?, `check_no`=?, `received_payment_by`=?, `prepared_by`=?, `certified_correct_by`=?, `approved_by`=?, `previous_voucher`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `created_at`=?, `updated_at`=?,`voucher_link_id`=? WHERE voucher_id=? '),
                            array($ccl->voucher_id,$ccl->voucher_type,$ccl->pay_to_order_of,$ccl->voucher_no,$ccl->voucher_date,$ccl->received_from,$ccl->received_from_bank,$ccl->the_amount_of,$ccl->bank,$ccl->check_no,$ccl->received_payment_by,$ccl->prepared_by,$ccl->certified_correct_by,$ccl->approved_by,$ccl->previous_voucher,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->voucher_link_id,$ccl->voucher_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM voucher_journal_entry");
            $table2= DB::connection('mysql')->select("SELECT * FROM voucher_journal_entry");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->journal_no==$ccl->journal_no && $ccl2->voucher_ref_no==$ccl->voucher_ref_no){
                        $dup=1;
                        $uid=$ccl2->journal_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into voucher_journal_entry (`journal_no`, `voucher_ref_no`, `account_title`, `debit`, `credit`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?)'),
                        array($ccl->journal_no,$ccl->voucher_ref_no,$ccl->account_title,$ccl->debit,$ccl->credit,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->voucher_id." voucher_journal_entry insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE voucher_journal_entry SET `journal_no`=?, `voucher_ref_no`=?, `account_title`=?, `debit`=?, `credit`=?, `created_at`=?, `updated_at`=? WHERE journal_no=? AND voucher_ref_no=?'),
                            array($ccl->journal_no,$ccl->voucher_ref_no,$ccl->account_title,$ccl->debit,$ccl->credit,$ccl->created_at,$ccl->updated_at,$ccl->journal_no,$ccl->voucher_ref_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

            $table= DB::connection('mysql3')->select("SELECT * FROM voucher_transaction");
            $table2= DB::connection('mysql')->select("SELECT * FROM voucher_transaction");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->tran_no==$ccl->tran_no && $ccl2->voucher_ref_no==$ccl->voucher_ref_no){
                        $dup=1;
                        $uid=$ccl2->tran_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into voucher_transaction (`tran_no`, `voucher_ref_no`, `tran_qty`, `tran_unit`, `tran_explanation`, `tran_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?)'),
                        array($ccl->tran_no,$ccl->voucher_ref_no,$ccl->tran_qty,$ccl->tran_unit,$ccl->tran_explanation,$ccl->tran_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->tran_no." voucher_transaction insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE voucher_transaction SET `tran_no`=?, `voucher_ref_no`=?, `tran_qty`=?, `tran_unit`=?, `tran_explanation`=?, `tran_amount`=?, `created_at`=?, `updated_at`=? WHERE tran_no=? AND voucher_ref_no=?'),
                            array($ccl->tran_no,$ccl->voucher_ref_no,$ccl->tran_qty,$ccl->tran_unit,$ccl->tran_explanation,$ccl->tran_amount,$ccl->created_at,$ccl->updated_at,$ccl->tran_no,$ccl->voucher_ref_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }

    }

    public function sync_audit_log(Request $request){
        Budgets::where([
            ['budget_type','=','Monthly'],
            ['m1','=',NULL],
            ['m2','=',NULL],
            ['m3','=',NULL],
            ['m4','=',NULL],
            ['m5','=',NULL],
            ['m6','=',NULL],
            ['m7','=',NULL],
            ['m8','=',NULL],
            ['m9','=',NULL],
            ['m10','=',NULL],
            ['m11','=',NULL],
            ['m12','=',NULL]
        ])->delete();
        
        try{
            $auditlog= DB::connection('mysql')->select("SELECT * FROM audit_logs");
            $auditlog2= DB::connection('mysql3')->select("SELECT * FROM audit_logs");
            foreach($auditlog as $al){
                $dup=0;
                foreach($auditlog2 as $al2){
                    if($al->log_id==$al2->log_id){
                        $dup=1;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    $audi= DB::connection('mysql3')->select("SELECT * FROM audit_logs");
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into audit_logs (log_id,log_user_id,log_name,log_event,log_transaction_date,log_amount,created_at,updated_at) values (?,?,?,?,?,?,?,?)'),
                        array(count($audi)+1,$al->log_user_id,$al->log_name,$al->log_event,$al->log_transaction_date,$al->log_amount,$al->created_at,$al->updated_at)
                    );
                    // $AuditLog= new AuditLog;
                    // $AuditLogcount=$al->log_id;
                    // $userid = $al->log_user_id;
                    // $username = $al->log_name;
                    // $AuditLog->log_id=$AuditLogcount;
                    // $AuditLog->log_user_id=$userid;
                    // $AuditLog->log_event=$al->log_event;
                    // $AuditLog->log_name=$username;
                    // $AuditLog->log_transaction_date=$al->log_transaction_date;
                    // $AuditLog->log_amount=$al->log_amount;
                    // $AuditLog->created_at=$al->created_at;
                    // $AuditLog->updated_at=$al->updated_at;
                    // $AuditLog->save();
                    echo $al->log_id." ";
                } 
            }
        }catch(\Exception $e){

        }
        echo "logs sync 2";
        try{
            $auditlog= DB::connection('mysq3')->select("SELECT * FROM audit_logs");
            $auditlog2= DB::connection('mysql')->select("SELECT * FROM audit_logs");
            foreach($auditlog as $al){
                $dup=0;
                foreach($auditlog2 as $al2){
                    if($al->log_id==$al2->log_id){
                        $dup=1;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    $audi= DB::connection('mysql')->select("SELECT * FROM audit_logs");
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into audit_logs (log_id,log_user_id,log_name,log_event,log_transaction_date,log_amount,created_at,updated_at) values (?,?,?,?,?,?,?,?)'),
                        array(count($audi)+1,$al->log_user_id,$al->log_name,$al->log_event,$al->log_transaction_date,$al->log_amount,$al->created_at,$al->updated_at)
                    );
                    // $AuditLog= new AuditLog;
                    // $AuditLogcount=$al->log_id;
                    // $userid = $al->log_user_id;
                    // $username = $al->log_name;
                    // $AuditLog->log_id=$AuditLogcount;
                    // $AuditLog->log_user_id=$userid;
                    // $AuditLog->log_event=$al->log_event;
                    // $AuditLog->log_name=$username;
                    // $AuditLog->log_transaction_date=$al->log_transaction_date;
                    // $AuditLog->log_amount=$al->log_amount;
                    // $AuditLog->created_at=$al->created_at;
                    // $AuditLog->updated_at=$al->updated_at;
                    // $AuditLog->save();
                    echo $al->log_id." ";
                } 
            }
        }catch(\Exception $e){

        }
    }

    public function sync_banks(Request $request){
       
        try{
            $bank= DB::connection('mysql')->select("SELECT * FROM bank");
            $bank2= DB::connection('mysql3')->select("SELECT * FROM bank");
            foreach($bank as $b){
                $uid="";
                $updated_at="";
                $dup=0;
                foreach($bank2 as $b2){
                    if($b->bank_no==$b2->bank_no ){
                        $dup=1;
                        $uid=$b2->bank_no;
                        $updated_at=$b2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into bank (bank_no,bank_name,bank_branch,bank_code,bank_account_no,bank_remark,bank_status,created_at,updated_at) values (?,?,?,?,?,?,?,?,?)'),
                        array($b->bank_no,$b->bank_name,$b->bank_branch,$b->bank_code,$b->bank_account_no,$b->bank_remark,$b->bank_status,$b->created_at,$b->updated_at)
                    );
                    echo $b->bank_no." bank_id insert ";
                }
                else if($dup==1){
                    if(strtotime($updated_at)<strtotime($b->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE bank SET bank_no=?,bank_name=?,bank_branch=?,bank_code=?,bank_account_no=?,bank_remark=?,bank_status=?,created_at=?,updated_at=? WHERE bank_no=?'),
                            array($b->bank_no,$b->bank_name,$b->bank_branch,$b->bank_code,$b->bank_account_no,$b->bank_remark,$b->bank_status,$b->created_at,$b->updated_at,$uid)
                        );
                        echo  $updated_at." < ". $b->updated_at." ";
                    }
                    

                }
            }
            $bank= DB::connection('mysql')->select("SELECT * FROM bank_edit");
            $bank2= DB::connection('mysql3')->select("SELECT * FROM bank_edit");
            foreach($bank as $b){
                $uid="";
                $updated_at="";
                $dup=0;
                foreach($bank2 as $b2){
                    if($b->bank_no==$b2->bank_no){
                        $dup=1;
                        $uid=$b2->bank_no;
                        $updated_at=$b2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into bank_edit (bank_no,bank_name,bank_branch,bank_code,bank_account_no,bank_remark,bank_status,edit_status,created_at,updated_at) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($b->bank_no,$b->bank_name,$b->bank_branch,$b->bank_code,$b->bank_account_no,$b->bank_remark,$b->bank_status,$b->edit_status,$b->created_at,$b->updated_at)
                    );
                    echo $b->bank_no." bank_id insert ";
                }
                else if($dup==1){
                    if(strtotime($updated_at)<strtotime($b->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE bank_edit SET bank_no=?,bank_name=?,bank_branch=?,bank_code=?,bank_account_no=?,bank_remark=?,bank_status=?,edit_status=?,created_at=?,updated_at=? WHERE bank_no=?'),
                            array($b->bank_no,$b->bank_name,$b->bank_branch,$b->bank_code,$b->bank_account_no,$b->bank_remark,$b->bank_status,$b->edit_status,$b->created_at,$b->updated_at,$uid)
                        );
                        echo  $updated_at." < ". $b->updated_at." ";
                    }
                    

                }
            }
            $deposit_record= DB::connection('mysql')->select("SELECT * FROM deposit_record");
                $deposit_record2= DB::connection('mysql3')->select("SELECT * FROM deposit_record");
                foreach($deposit_record as $ccl){
                    $dup=0;
                    $uid="";
                    $updated_at="";
                    foreach($deposit_record2 as $ccl2){
                        if($ccl2->deposit_record_no==$ccl->deposit_record_no){
                            $dup=1;
                            $uid=$ccl2->deposit_record_no;
                            $updated_at=$ccl2->updated_at;
                            break;
                        }else{
                            $dup=0;
                        }
                    }
                    if($dup==0){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('insert into deposit_record (`deposit_record_no`, `deposit_to`, `bank_account`, `deposit_record_date`, `deposit_record_memo`, `deposit_record_transaction_no`, `deposit_record_group_no`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?)'),
                            array($ccl->deposit_record_no,$ccl->deposit_to,$ccl->bank_account,$ccl->deposit_record_date,$ccl->deposit_record_memo,$ccl->deposit_record_transaction_no,$ccl->deposit_record_group_no,$ccl->created_at,$ccl->updated_at)
                        );
                        echo $ccl->deposit_record_no." deposit_record insert ";
                    }else if($dup==1){
                        if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                            DB::connection('mysql3')
                            ->statement(
                                DB::raw('UPDATE deposit_record SET `deposit_record_no`=?, `deposit_to`=?, `bank_account`=?, `deposit_record_date`=?, `deposit_record_memo`=?, `deposit_record_transaction_no`=?, `deposit_record_group_no`=?, `created_at`=?, `updated_at`=? WHERE deposit_record_no=?'),
                                array($ccl->deposit_record_no,$ccl->deposit_to,$ccl->bank_account,$ccl->deposit_record_date,$ccl->deposit_record_memo,$ccl->deposit_record_transaction_no,$ccl->deposit_record_group_no,$ccl->created_at,$ccl->updated_at,$ccl->deposit_record_no)
                            );
                            echo  $updated_at." < ". $ccl->updated_at." ";
    
                        }
                    }
                }
        }catch(\Exception $e){

        }
        echo " bank sync 2";
        try{
            $bank= DB::connection('mysql3')->select("SELECT * FROM bank");
            $bank2= DB::connection('mysql')->select("SELECT * FROM bank");
            foreach($bank as $b){
                $uid="";
                $updated_at="";
                $dup=0;
                foreach($bank2 as $b2){
                    if($b->bank_no==$b2->bank_no ){
                        $dup=1;
                        $uid=$b2->bank_no;
                        $updated_at=$b2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into bank (bank_no,bank_name,bank_branch,bank_code,bank_account_no,bank_remark,bank_status,created_at,updated_at) values (?,?,?,?,?,?,?,?,?)'),
                        array($b->bank_no,$b->bank_name,$b->bank_branch,$b->bank_code,$b->bank_account_no,$b->bank_remark,$b->bank_status,$b->created_at,$b->updated_at)
                    );
                    echo $b->bank_no." bank_id insert ";
                }
                else if($dup==1){
                    if(strtotime($updated_at)<strtotime($b->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE bank SET bank_no=?,bank_name=?,bank_branch=?,bank_code=?,bank_account_no=?,bank_remark=?,bank_status=?,created_at=?,updated_at=? WHERE bank_no=?'),
                            array($b->bank_no,$b->bank_name,$b->bank_branch,$b->bank_code,$b->bank_account_no,$b->bank_remark,$b->bank_status,$b->created_at,$b->updated_at,$uid)
                        );
                        echo  $updated_at." < ". $b->updated_at." ";
                    }
                    

                }
            }
            
            $bank= DB::connection('mysql3')->select("SELECT * FROM bank_edit");
            $bank2= DB::connection('mysql')->select("SELECT * FROM bank_edit");
            foreach($bank as $b){
                $uid="";
                $updated_at="";
                $dup=0;
                foreach($bank2 as $b2){
                    if($b->bank_no==$b2->bank_no){
                        $dup=1;
                        $uid=$b2->bank_no;
                        $updated_at=$b2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into bank_edit (bank_no,bank_name,bank_branch,bank_code,bank_account_no,bank_remark,bank_status,edit_status,created_at,updated_at) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($b->bank_no,$b->bank_name,$b->bank_branch,$b->bank_code,$b->bank_account_no,$b->bank_remark,$b->bank_status,$b->edit_status,$b->created_at,$b->updated_at)
                    );
                    echo $b->bank_no." bank_id insert ";
                }
                else if($dup==1){
                    if(strtotime($updated_at)<strtotime($b->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE bank_edit SET bank_no=?,bank_name=?,bank_branch=?,bank_code=?,bank_account_no=?,bank_remark=?,bank_status=?,edit_status=?,created_at=?,updated_at=? WHERE bank_no=?'),
                            array($b->bank_no,$b->bank_name,$b->bank_branch,$b->bank_code,$b->bank_account_no,$b->bank_remark,$b->bank_status,$b->edit_status,$b->created_at,$b->updated_at,$uid)
                        );
                        echo  $updated_at." < ". $b->updated_at." ";
                    }
                    

                }
            }
            $deposit_record= DB::connection('mysql3')->select("SELECT * FROM deposit_record");
                $deposit_record2= DB::connection('mysql')->select("SELECT * FROM deposit_record");
                foreach($deposit_record as $ccl){
                    $dup=0;
                    $uid="";
                    $updated_at="";
                    foreach($deposit_record2 as $ccl2){
                        if($ccl2->deposit_record_no==$ccl->deposit_record_no){
                            $dup=1;
                            $uid=$ccl2->deposit_record_no;
                            $updated_at=$ccl2->updated_at;
                            break;
                        }else{
                            $dup=0;
                        }
                    }
                    if($dup==0){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('insert into deposit_record (`deposit_record_no`, `deposit_to`, `bank_account`, `deposit_record_date`, `deposit_record_memo`, `deposit_record_transaction_no`, `deposit_record_group_no`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?)'),
                            array($ccl->deposit_record_no,$ccl->deposit_to,$ccl->bank_account,$ccl->deposit_record_date,$ccl->deposit_record_memo,$ccl->deposit_record_transaction_no,$ccl->deposit_record_group_no,$ccl->created_at,$ccl->updated_at)
                        );
                        echo $ccl->deposit_record_no." deposit_record insert ";
                    }else if($dup==1){
                        if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                            DB::connection('mysql')
                            ->statement(
                                DB::raw('UPDATE deposit_record SET `deposit_record_no`=?, `deposit_to`=?, `bank_account`=?, `deposit_record_date`=?, `deposit_record_memo`=?, `deposit_record_transaction_no`=?, `deposit_record_group_no`=?, `created_at`=?, `updated_at`=? WHERE deposit_record_no=?'),
                                array($ccl->deposit_record_no,$ccl->deposit_to,$ccl->bank_account,$ccl->deposit_record_date,$ccl->deposit_record_memo,$ccl->deposit_record_transaction_no,$ccl->deposit_record_group_no,$ccl->created_at,$ccl->updated_at,$ccl->deposit_record_no)
                            );
                            echo  $updated_at." < ". $ccl->updated_at." ";
    
                        }
                    }
                }
        }catch(\Exception $e){

        }
    }

    public function sync_budget(Request $request){
        
        try{
            $budget= DB::connection('mysql')->select("SELECT * FROM budget");
            $budget2= DB::connection('mysql3')->select("SELECT * FROM budget");
            foreach($budget as $bud){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($budget2 as $bud2){
                    if($bud->budget_year==$bud2->budget_year && $bud->budget_cost_center==$bud2->budget_cost_center && $bud->budget_chart_of_accounts==$bud2->budget_chart_of_accounts && $bud->budget_type==$bud2->budget_type){
                        $dup=1;
                        $uid=$bud2->budget_no;
                        $updated_at=$bud2->updated_at;
                        break;

                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    $busssssd= DB::connection('mysql3')->select("SELECT * FROM budget");
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into budget (budget_no,budget_year,budget_cost_center,budget_chart_of_accounts,m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12,created_at,updated_at,budget_month,budget_type) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array(count($busssssd)+1,$bud->budget_year,$bud->budget_cost_center,$bud->budget_chart_of_accounts,$bud->m1,$bud->m2,$bud->m3,$bud->m4,$bud->m5,$bud->m6,$bud->m7,$bud->m8,$bud->m9,$bud->m10,$bud->m11,$bud->m12,$bud->created_at,$bud->updated_at,$bud->budget_month,$bud->budget_type)
                    );
                    echo $bud->budget_no." budget_id insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($bud->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE budget SET budget_no=?,budget_year=?,budget_cost_center=?,budget_chart_of_accounts=?,m1=?,m2=?,m3=?,m4=?,m5=?,m6=?,m7=?,m8=?,m9=?,m10=?,m11=?,m12=?,created_at=?,updated_at=?,budget_month=?,budget_type=? WHERE budget_no=?'),
                            array($bud->budget_no,$bud->budget_year,$bud->budget_cost_center,$bud->budget_chart_of_accounts,$bud->m1,$bud->m2,$bud->m3,$bud->m4,$bud->m5,$bud->m6,$bud->m7,$bud->m8,$bud->m9,$bud->m10,$bud->m11,$bud->m12,$bud->created_at,$bud->budget_month,$bud->budget_type,$bud->updated_at,$uid)
                        );
                        echo  $updated_at." < ". $bud->updated_at." ";
                    }
                }
            }
            $budget= DB::connection('mysql')->select("SELECT * FROM budget_edits");
            $budget2= DB::connection('mysql3')->select("SELECT * FROM budget_edits");
            foreach($budget as $bud){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($budget2 as $bud2){
                    if($bud->budget_year==$bud2->budget_year && $bud->budget_cost_center==$bud2->budget_cost_center && $bud->budget_chart_of_accounts==$bud2->budget_chart_of_accounts && $bud->budget_type==$bud2->budget_type){
                        $dup=1;
                        $uid=$bud2->budget_no;
                        $updated_at=$bud2->updated_at;
                        break;

                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    $busssssd= DB::connection('mysql3')->select("SELECT * FROM budget_edits");
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into budget_edits (budget_no,budget_year,budget_cost_center,budget_chart_of_accounts,m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12,created_at,updated_at,budget_month,budget_type,edit_status) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array(count($busssssd)+1,$bud->budget_year,$bud->budget_cost_center,$bud->budget_chart_of_accounts,$bud->m1,$bud->m2,$bud->m3,$bud->m4,$bud->m5,$bud->m6,$bud->m7,$bud->m8,$bud->m9,$bud->m10,$bud->m11,$bud->m12,$bud->created_at,$bud->updated_at,$bud->budget_month,$bud->budget_type,$bud->edit_status)
                    );
                    echo $bud->budget_no." budget_edits insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($bud->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE budget_edits SET budget_no=?,budget_year=?,budget_cost_center=?,budget_chart_of_accounts=?,m1=?,m2=?,m3=?,m4=?,m5=?,m6=?,m7=?,m8=?,m9=?,m10=?,m11=?,m12=?,created_at=?,updated_at=?,budget_month=?,budget_type=?,edit_status=? WHERE budget_no=?'),
                            array($bud->budget_no,$bud->budget_year,$bud->budget_cost_center,$bud->budget_chart_of_accounts,$bud->m1,$bud->m2,$bud->m3,$bud->m4,$bud->m5,$bud->m6,$bud->m7,$bud->m8,$bud->m9,$bud->m10,$bud->m11,$bud->m12,$bud->created_at,$bud->updated_at,$bud->budget_month,$bud->budget_type,$bud->edit_status,$uid)
                        );
                        echo  $updated_at." < ". $bud->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
        try{
            $budget= DB::connection('mysql3')->select("SELECT * FROM budget");
            $budget2= DB::connection('mysql')->select("SELECT * FROM budget");
            foreach($budget as $bud){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($budget2 as $bud2){
                    if($bud->budget_year==$bud2->budget_year && $bud->budget_cost_center==$bud2->budget_cost_center && $bud->budget_chart_of_accounts==$bud2->budget_chart_of_accounts && $bud->budget_type==$bud2->budget_type){
                        $dup=1;
                        $uid=$bud2->budget_no;
                        $updated_at=$bud2->updated_at;
                        break;

                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    $busssssd= DB::connection('mysql')->select("SELECT * FROM budget");
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into budget (budget_no,budget_year,budget_cost_center,budget_chart_of_accounts,m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12,created_at,updated_at,budget_month,budget_type) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array(count($busssssd)+1,$bud->budget_year,$bud->budget_cost_center,$bud->budget_chart_of_accounts,$bud->m1,$bud->m2,$bud->m3,$bud->m4,$bud->m5,$bud->m6,$bud->m7,$bud->m8,$bud->m9,$bud->m10,$bud->m11,$bud->m12,$bud->created_at,$bud->updated_at,$bud->budget_month,$bud->budget_type)
                    );
                    echo $bud->budget_no." budget_id insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($bud->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE budget SET budget_no=?,budget_year=?,budget_cost_center=?,budget_chart_of_accounts=?,m1=?,m2=?,m3=?,m4=?,m5=?,m6=?,m7=?,m8=?,m9=?,m10=?,m11=?,m12=?,created_at=?,updated_at=?,budget_month=?,budget_type=? WHERE budget_no=?'),
                            array($bud->budget_no,$bud->budget_year,$bud->budget_cost_center,$bud->budget_chart_of_accounts,$bud->m1,$bud->m2,$bud->m3,$bud->m4,$bud->m5,$bud->m6,$bud->m7,$bud->m8,$bud->m9,$bud->m10,$bud->m11,$bud->m12,$bud->created_at,$bud->budget_month,$bud->budget_type,$bud->updated_at,$uid)
                        );
                        echo  $updated_at." < ". $bud->updated_at." ";
                    }
                }
            }
            $budget= DB::connection('mysql3')->select("SELECT * FROM budget_edits");
            $budget2= DB::connection('mysql')->select("SELECT * FROM budget_edits");
            foreach($budget as $bud){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($budget2 as $bud2){
                    if($bud->budget_year==$bud2->budget_year && $bud->budget_cost_center==$bud2->budget_cost_center && $bud->budget_chart_of_accounts==$bud2->budget_chart_of_accounts && $bud->budget_type==$bud2->budget_type){
                        $dup=1;
                        $uid=$bud2->budget_no;
                        $updated_at=$bud2->updated_at;
                        break;

                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    $busssssd= DB::connection('mysql')->select("SELECT * FROM budget_edits");
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into budget_edits (budget_no,budget_year,budget_cost_center,budget_chart_of_accounts,m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12,created_at,updated_at,budget_month,budget_type,edit_status) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array(count($busssssd)+1,$bud->budget_year,$bud->budget_cost_center,$bud->budget_chart_of_accounts,$bud->m1,$bud->m2,$bud->m3,$bud->m4,$bud->m5,$bud->m6,$bud->m7,$bud->m8,$bud->m9,$bud->m10,$bud->m11,$bud->m12,$bud->created_at,$bud->updated_at,$bud->budget_month,$bud->budget_type,$bud->edit_status)
                    );
                    echo $bud->budget_no." budget_edits insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($bud->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE budget_edits SET budget_no=?,budget_year=?,budget_cost_center=?,budget_chart_of_accounts=?,m1=?,m2=?,m3=?,m4=?,m5=?,m6=?,m7=?,m8=?,m9=?,m10=?,m11=?,m12=?,created_at=?,updated_at=?,budget_month=?,budget_type=?,edit_status=? WHERE budget_no=?'),
                            array($bud->budget_no,$bud->budget_year,$bud->budget_cost_center,$bud->budget_chart_of_accounts,$bud->m1,$bud->m2,$bud->m3,$bud->m4,$bud->m5,$bud->m6,$bud->m7,$bud->m8,$bud->m9,$bud->m10,$bud->m11,$bud->m12,$bud->created_at,$bud->updated_at,$bud->budget_month,$bud->budget_type,$bud->edit_status,$uid)
                        );
                        echo  $updated_at." < ". $bud->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
    }
    public function sync_coa(Request $request){
        
        try{
            $chartofaccounts= DB::connection('mysql')->select("SELECT * FROM chart_of_accounts");
            $chartofaccounts2= DB::connection('mysql3')->select("SELECT * FROM chart_of_accounts");

            foreach($chartofaccounts as $coa){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($chartofaccounts2 as $coa2){
                    
                    if($coa->id==$coa2->id && $coa->coa_account_type==$coa2->coa_account_type && $coa->coa_detail_type==$coa2->coa_detail_type && $coa->coa_name==$coa2->coa_name ){
                        
                        $dup=1;
                        $uid=$coa2->id;
                        $updated_at=$coa2->updated_at;
                        break;
                    }else{
                        
                        $dup=0;
                    }
                }
                if($dup==0){
                   
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into chart_of_accounts (`id`, `coa_account_type`, `coa_detail_type`, `coa_name`, `coa_description`, `coa_is_sub_acc`, `coa_parent_account`, `coa_balance`, `coa_as_of_date`, `coa_active`, `coa_code`, `normal_balance`, `coa_title`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($coa->id,$coa->coa_account_type,$coa->coa_detail_type,$coa->coa_name,$coa->coa_description,$coa->coa_is_sub_acc,$coa->coa_parent_account,$coa->coa_balance,$coa->coa_as_of_date,$coa->coa_active,$coa->coa_code,$coa->normal_balance,$coa->coa_title,$coa->created_at,$coa->updated_at)
                    );
                    echo $coa->id." coa insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($coa->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE chart_of_accounts SET `id`=?, `coa_account_type`=?, `coa_detail_type`=?, `coa_name`=?, `coa_description`=?, `coa_is_sub_acc`=?, `coa_parent_account`=?, `coa_balance`=?, `coa_as_of_date`=?, `coa_active`=?, `coa_code`=?, `normal_balance`=?, `coa_title`=?, `created_at`=?, `updated_at`=? WHERE id=?'),
                            array($coa->id,$coa->coa_account_type,$coa->coa_detail_type,$coa->coa_name,$coa->coa_description,$coa->coa_is_sub_acc,$coa->coa_parent_account,$coa->coa_balance,$coa->coa_as_of_date,$coa->coa_active,$coa->coa_code,$coa->normal_balance,$coa->coa_title,$coa->created_at,$coa->updated_at,$coa->id)
                        );
                        echo  $updated_at." < ". $coa->updated_at." ";
                    }
                }
            }
            $chartofaccounts= DB::connection('mysql')->select("SELECT * FROM chart_of_accounts_edit");
            $chartofaccounts2= DB::connection('mysql3')->select("SELECT * FROM chart_of_accounts_edit");

            foreach($chartofaccounts as $coa){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($chartofaccounts2 as $coa2){
                    
                    if($coa->coa_code==$coa2->coa_code){
                        
                        $dup=1;
                        $uid=$coa2->id;
                        $updated_at=$coa2->updated_at;
                        break;
                    }else{
                        
                        $dup=0;
                    }
                }
                if($dup==0){
                   
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into chart_of_accounts_edit (`id`, `coa_account_type`, `coa_detail_type`, `coa_name`, `coa_description`, `coa_is_sub_acc`, `coa_parent_account`, `coa_balance`, `coa_as_of_date`, `coa_active`, `coa_code`, `normal_balance`, `coa_title`,`edit_status`, `created_at`, `updated_at`,`coa_sub_account`,`coa_beginning_balance`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($coa->id,$coa->coa_account_type,$coa->coa_detail_type,$coa->coa_name,$coa->coa_description,$coa->coa_is_sub_acc,$coa->coa_parent_account,$coa->coa_balance,$coa->coa_as_of_date,$coa->coa_active,$coa->coa_code,$coa->normal_balance,$coa->coa_title,$coa->edit_status,$coa->created_at,$coa->updated_at,$coa->coa_sub_account,$coa->coa_beginning_balance)
                    );
                    echo $coa->id." coa insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($coa->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE chart_of_accounts_edit SET `id`=?, `coa_account_type`=?, `coa_detail_type`=?, `coa_name`=?, `coa_description`=?, `coa_is_sub_acc`=?, `coa_parent_account`=?, `coa_balance`=?, `coa_as_of_date`=?, `coa_active`=?, `coa_code`=?, `normal_balance`=?, `coa_title`=?,`edit_status`=?, `created_at`=?, `updated_at`=?,`coa_sub_account`=?,`coa_beginning_balance`=? WHERE id=?'),
                            array($coa->id,$coa->coa_account_type,$coa->coa_detail_type,$coa->coa_name,$coa->coa_description,$coa->coa_is_sub_acc,$coa->coa_parent_account,$coa->coa_balance,$coa->coa_as_of_date,$coa->coa_active,$coa->coa_code,$coa->normal_balance,$coa->coa_title,$coa->edit_status,$coa->created_at,$coa->updated_at,$coa->coa_sub_account,$coa->coa_beginning_balance,$coa->id)
                        );
                        echo  $updated_at." < ". $coa->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
        try{
            $chartofaccounts= DB::connection('mysql3')->select("SELECT * FROM chart_of_accounts");
            $chartofaccounts2= DB::connection('mysql')->select("SELECT * FROM chart_of_accounts");

            foreach($chartofaccounts as $coa){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($chartofaccounts2 as $coa2){
                    
                    if($coa->id==$coa2->id && $coa->coa_account_type==$coa2->coa_account_type && $coa->coa_detail_type==$coa2->coa_detail_type && $coa->coa_name==$coa2->coa_name ){
                        
                        $dup=1;
                        $uid=$coa2->id;
                        $updated_at=$coa2->updated_at;
                        break;
                    }else{
                        
                        $dup=0;
                    }
                }
                if($dup==0){
                   
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into chart_of_accounts (`id`, `coa_account_type`, `coa_detail_type`, `coa_name`, `coa_description`, `coa_is_sub_acc`, `coa_parent_account`, `coa_balance`, `coa_as_of_date`, `coa_active`, `coa_code`, `normal_balance`, `coa_title`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($coa->id,$coa->coa_account_type,$coa->coa_detail_type,$coa->coa_name,$coa->coa_description,$coa->coa_is_sub_acc,$coa->coa_parent_account,$coa->coa_balance,$coa->coa_as_of_date,$coa->coa_active,$coa->coa_code,$coa->normal_balance,$coa->coa_title,$coa->created_at,$coa->updated_at)
                    );
                    echo $coa->id." coa insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($coa->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE chart_of_accounts SET `id`=?, `coa_account_type`=?, `coa_detail_type`=?, `coa_name`=?, `coa_description`=?, `coa_is_sub_acc`=?, `coa_parent_account`=?, `coa_balance`=?, `coa_as_of_date`=?, `coa_active`=?, `coa_code`=?, `normal_balance`=?, `coa_title`=?, `created_at`=?, `updated_at`=? WHERE id=?'),
                            array($coa->id,$coa->coa_account_type,$coa->coa_detail_type,$coa->coa_name,$coa->coa_description,$coa->coa_is_sub_acc,$coa->coa_parent_account,$coa->coa_balance,$coa->coa_as_of_date,$coa->coa_active,$coa->coa_code,$coa->normal_balance,$coa->coa_title,$coa->created_at,$coa->updated_at,$coa->id)
                        );
                        echo  $updated_at." < ". $coa->updated_at." ";
                    }
                }
            }
            $chartofaccounts= DB::connection('mysql3')->select("SELECT * FROM chart_of_accounts_edit");
            $chartofaccounts2= DB::connection('mysql')->select("SELECT * FROM chart_of_accounts_edit");

            foreach($chartofaccounts as $coa){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($chartofaccounts2 as $coa2){
                    
                    if($coa->coa_code==$coa2->coa_code){
                        
                        $dup=1;
                        $uid=$coa2->id;
                        $updated_at=$coa2->updated_at;
                        break;
                    }else{
                        
                        $dup=0;
                    }
                }
                if($dup==0){
                   
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into chart_of_accounts_edit (`id`, `coa_account_type`, `coa_detail_type`, `coa_name`, `coa_description`, `coa_is_sub_acc`, `coa_parent_account`, `coa_balance`, `coa_as_of_date`, `coa_active`, `coa_code`, `normal_balance`, `coa_title`,`edit_status`, `created_at`, `updated_at`,`coa_sub_account`,`coa_beginning_balance`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($coa->id,$coa->coa_account_type,$coa->coa_detail_type,$coa->coa_name,$coa->coa_description,$coa->coa_is_sub_acc,$coa->coa_parent_account,$coa->coa_balance,$coa->coa_as_of_date,$coa->coa_active,$coa->coa_code,$coa->normal_balance,$coa->coa_title,$coa->edit_status,$coa->created_at,$coa->updated_at,$coa->coa_sub_account,$coa->coa_beginning_balance)
                    );
                    echo $coa->id." coa insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($coa->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE chart_of_accounts_edit SET `id`=?, `coa_account_type`=?, `coa_detail_type`=?, `coa_name`=?, `coa_description`=?, `coa_is_sub_acc`=?, `coa_parent_account`=?, `coa_balance`=?, `coa_as_of_date`=?, `coa_active`=?, `coa_code`=?, `normal_balance`=?, `coa_title`=?,`edit_status`=?, `created_at`=?, `updated_at`=?,`coa_sub_account`=?,`coa_beginning_balance`=? WHERE id=?'),
                            array($coa->id,$coa->coa_account_type,$coa->coa_detail_type,$coa->coa_name,$coa->coa_description,$coa->coa_is_sub_acc,$coa->coa_parent_account,$coa->coa_balance,$coa->coa_as_of_date,$coa->coa_active,$coa->coa_code,$coa->normal_balance,$coa->coa_title,$coa->edit_status,$coa->created_at,$coa->updated_at,$coa->coa_sub_account,$coa->coa_beginning_balance,$coa->id)
                        );
                        echo  $updated_at." < ". $coa->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
    }
    public function sync_cc(Request $request){
        
        try{
            $cost_center= DB::connection('mysql')->select("SELECT * FROM cost_center");
            $cost_center2= DB::connection('mysql3')->select("SELECT * FROM cost_center");
            foreach($cost_center as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($cost_center2 as $ccl2){
                    if($ccl->cc_name_code==$ccl2->cc_name_code ){
                        $dup=1;
                        $uid=$ccl2->cc_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into cost_center (`cc_no`, `cc_type_code`, `cc_type`, `cc_name_code`, `cc_name`, `cc_status`,`cc_use_quotation`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?)'),
                        array($ccl->cc_no,$ccl->cc_type_code,$ccl->cc_type,$ccl->cc_name_code,$ccl->cc_name,$ccl->cc_status,$ccl->cc_use_quotation,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->cc_no." cost center insert ";
                }
                else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE cost_center SET `cc_no`=?, `cc_type_code`=?, `cc_type`=?, `cc_name_code`=?, `cc_name`=?, `cc_status`=?,`cc_use_quotation`=?, `created_at`=?, `updated_at`=? WHERE cc_no=?'),
                            array($ccl->cc_no,$ccl->cc_type_code,$ccl->cc_type,$ccl->cc_name_code,$ccl->cc_name,$ccl->cc_status,$ccl->cc_use_quotation,$ccl->created_at,$ccl->updated_at,$ccl->cc_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $cost_center= DB::connection('mysql')->select("SELECT * FROM cost_center_edits");
            $cost_center2= DB::connection('mysql3')->select("SELECT * FROM cost_center_edits");
            foreach($cost_center as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($cost_center2 as $ccl2){
                    if($ccl->cc_name_code==$ccl2->cc_name_code ){
                        $dup=1;
                        $uid=$ccl2->cc_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into cost_center_edits (`cc_no`, `cc_type_code`, `cc_type`, `cc_name_code`, `cc_name`, `cc_status`,`cc_use_quotation`,`edit_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->cc_no,$ccl->cc_type_code,$ccl->cc_type,$ccl->cc_name_code,$ccl->cc_name,$ccl->cc_status,$ccl->cc_use_quotation,$ccl->edit_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->cc_no." cost center insert ";
                }
                else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE cost_center_edits SET `cc_no`=?, `cc_type_code`=?, `cc_type`=?, `cc_name_code`=?, `cc_name`=?, `cc_status`=?,`cc_use_quotation`=?,`edit_status`=?, `created_at`=?, `updated_at`=? WHERE cc_no=?'),
                            array($ccl->cc_no,$ccl->cc_type_code,$ccl->cc_type,$ccl->cc_name_code,$ccl->cc_name,$ccl->cc_status,$ccl->cc_use_quotation,$ccl->created_at,$ccl->edit_status,$ccl->updated_at,$ccl->cc_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
        try{
            $cost_center= DB::connection('mysql3')->select("SELECT * FROM cost_center");
            $cost_center2= DB::connection('mysql')->select("SELECT * FROM cost_center");
            foreach($cost_center as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($cost_center2 as $ccl2){
                    if($ccl->cc_name_code==$ccl2->cc_name_code ){
                        $dup=1;
                        $uid=$ccl2->cc_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into cost_center (`cc_no`, `cc_type_code`, `cc_type`, `cc_name_code`, `cc_name`, `cc_status`,`cc_use_quotation`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?)'),
                        array($ccl->cc_no,$ccl->cc_type_code,$ccl->cc_type,$ccl->cc_name_code,$ccl->cc_name,$ccl->cc_status,$ccl->cc_use_quotation,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->cc_no." cost center insert ";
                }
                else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE cost_center SET `cc_no`=?, `cc_type_code`=?, `cc_type`=?, `cc_name_code`=?, `cc_name`=?, `cc_status`=?,`cc_use_quotation`=?, `created_at`=?, `updated_at`=? WHERE cc_no=?'),
                            array($ccl->cc_no,$ccl->cc_type_code,$ccl->cc_type,$ccl->cc_name_code,$ccl->cc_name,$ccl->cc_status,$ccl->cc_use_quotation,$ccl->created_at,$ccl->updated_at,$ccl->cc_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $cost_center= DB::connection('mysql3')->select("SELECT * FROM cost_center_edits");
            $cost_center2= DB::connection('mysql')->select("SELECT * FROM cost_center_edits");
            foreach($cost_center as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($cost_center2 as $ccl2){
                    if($ccl->cc_name_code==$ccl2->cc_name_code ){
                        $dup=1;
                        $uid=$ccl2->cc_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into cost_center_edits (`cc_no`, `cc_type_code`, `cc_type`, `cc_name_code`, `cc_name`, `cc_status`,`cc_use_quotation`,`edit_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->cc_no,$ccl->cc_type_code,$ccl->cc_type,$ccl->cc_name_code,$ccl->cc_name,$ccl->cc_status,$ccl->cc_use_quotation,$ccl->edit_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->cc_no." cost center insert ";
                }
                else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE cost_center_edits SET `cc_no`=?, `cc_type_code`=?, `cc_type`=?, `cc_name_code`=?, `cc_name`=?, `cc_status`=?,`cc_use_quotation`=?,`edit_status`=?, `created_at`=?, `updated_at`=? WHERE cc_no=?'),
                            array($ccl->cc_no,$ccl->cc_type_code,$ccl->cc_type,$ccl->cc_name_code,$ccl->cc_name,$ccl->cc_status,$ccl->cc_use_quotation,$ccl->created_at,$ccl->edit_status,$ccl->updated_at,$ccl->cc_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
    }
    public function sync_customer(Request $request){
        
        try{
            $customers= DB::connection('mysql')->select("SELECT * FROM customers");
            $customers2= DB::connection('mysql3')->select("SELECT * FROM customers");
            foreach($customers as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($customers2 as $ccl2){
                    if($ccl2->customer_id==$ccl->customer_id){
                        $dup=1;
                        $uid=$ccl2->customer_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into customers (`customer_id`, `f_name`, `l_name`, `email`, `company`, `phone`, `mobile`, `fax`, `display_name`, `other`, `website`, `street`, `city`, `state`, `postal_code`, `country`, `payment_method`, `terms`, `opening_balance`, `as_of_date`, `account_no`, `business_id_no`, `notes`, `tin_no`, `attachment`, `withhold_tax`, `business_style`, `tax_type`, `vat_value`, `account_type`, `supplier_active`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->customer_id,$ccl->f_name,$ccl->l_name,$ccl->email,$ccl->company,$ccl->phone,$ccl->mobile,$ccl->fax,$ccl->display_name,$ccl->other,$ccl->website,$ccl->street,$ccl->city,$ccl->state,$ccl->postal_code,$ccl->country,$ccl->payment_method,$ccl->terms,$ccl->opening_balance,$ccl->as_of_date,$ccl->account_no,$ccl->business_id_no,$ccl->notes,$ccl->tin_no,$ccl->attachment,$ccl->withhold_tax,$ccl->business_style,$ccl->tax_type,$ccl->vat_value,$ccl->account_type,$ccl->supplier_active,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->customer_id." customer insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE customers SET `customer_id`=?, `f_name`=?, `l_name`=?, `email`=?, `company`=?, `phone`=?, `mobile`=?, `fax`=?, `display_name`=?, `other`=?, `website`=?, `street`=?, `city`=?, `state`=?, `postal_code`=?, `country`=?, `payment_method`=?, `terms`=?, `opening_balance`=?, `as_of_date`=?, `account_no`=?, `business_id_no`=?, `notes`=?, `tin_no`=?, `attachment`=?, `withhold_tax`=?, `business_style`=?, `tax_type`=?, `vat_value`=?, `account_type`=?, `supplier_active`=?, `created_at`=?, `updated_at`=? WHERE customer_id=?'),
                            array($ccl->customer_id,$ccl->f_name,$ccl->l_name,$ccl->email,$ccl->company,$ccl->phone,$ccl->mobile,$ccl->fax,$ccl->display_name,$ccl->other,$ccl->website,$ccl->street,$ccl->city,$ccl->state,$ccl->postal_code,$ccl->country,$ccl->payment_method,$ccl->terms,$ccl->opening_balance,$ccl->as_of_date,$ccl->account_no,$ccl->business_id_no,$ccl->notes,$ccl->tin_no,$ccl->attachment,$ccl->withhold_tax,$ccl->business_style,$ccl->tax_type,$ccl->vat_value,$ccl->account_type,$ccl->supplier_active,$ccl->created_at,$ccl->updated_at,$ccl->customer_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $customers= DB::connection('mysql')->select("SELECT * FROM customers_edits");
            $customers2= DB::connection('mysql3')->select("SELECT * FROM customers_edits");
            foreach($customers as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($customers2 as $ccl2){
                    if($ccl2->customer_id==$ccl->customer_id){
                        $dup=1;
                        $uid=$ccl2->customer_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into customers_edits (`customer_id`, `f_name`, `l_name`, `email`, `company`, `phone`, `mobile`, `fax`, `display_name`, `other`, `website`, `street`, `city`, `state`, `postal_code`, `country`, `payment_method`, `terms`, `opening_balance`, `as_of_date`, `account_no`, `business_id_no`, `notes`, `tin_no`, `attachment`, `withhold_tax`, `business_style`, `tax_type`, `vat_value`, `account_type`, `supplier_active`, `edit_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->customer_id,$ccl->f_name,$ccl->l_name,$ccl->email,$ccl->company,$ccl->phone,$ccl->mobile,$ccl->fax,$ccl->display_name,$ccl->other,$ccl->website,$ccl->street,$ccl->city,$ccl->state,$ccl->postal_code,$ccl->country,$ccl->payment_method,$ccl->terms,$ccl->opening_balance,$ccl->as_of_date,$ccl->account_no,$ccl->business_id_no,$ccl->notes,$ccl->tin_no,$ccl->attachment,$ccl->withhold_tax,$ccl->business_style,$ccl->tax_type,$ccl->vat_value,$ccl->account_type,$ccl->supplier_active,$ccl->edit_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->customer_id." customer insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE customers_edits SET `customer_id`=?, `f_name`=?, `l_name`=?, `email`=?, `company`=?, `phone`=?, `mobile`=?, `fax`=?, `display_name`=?, `other`=?, `website`=?, `street`=?, `city`=?, `state`=?, `postal_code`=?, `country`=?, `payment_method`=?, `terms`=?, `opening_balance`=?, `as_of_date`=?, `account_no`=?, `business_id_no`=?, `notes`=?, `tin_no`=?, `attachment`=?, `withhold_tax`=?, `business_style`=?, `tax_type`=?, `vat_value`=?, `account_type`=?, `supplier_active`=?,`edit_status`=?, `created_at`=?, `updated_at`=? WHERE customer_id=?'),
                            array($ccl->customer_id,$ccl->f_name,$ccl->l_name,$ccl->email,$ccl->company,$ccl->phone,$ccl->mobile,$ccl->fax,$ccl->display_name,$ccl->other,$ccl->website,$ccl->street,$ccl->city,$ccl->state,$ccl->postal_code,$ccl->country,$ccl->payment_method,$ccl->terms,$ccl->opening_balance,$ccl->as_of_date,$ccl->account_no,$ccl->business_id_no,$ccl->notes,$ccl->tin_no,$ccl->attachment,$ccl->withhold_tax,$ccl->business_style,$ccl->tax_type,$ccl->vat_value,$ccl->account_type,$ccl->supplier_active,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->customer_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $custom_form_style= DB::connection('mysql')->select("SELECT * FROM custom_form_style");
            $custom_form_style2= DB::connection('mysql3')->select("SELECT * FROM custom_form_style");
            foreach($custom_form_style as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($custom_form_style2 as $ccl2){
                    if($ccl2->cfs_id==$ccl->cfs_id){
                        $dup=1;
                        $uid=$ccl2->cfs_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into custom_form_style (`cfs_id`, `cfs_name`, `cfs_design_template`, `cfs_logo_name`, `cfs_logo_show`, `cfs_logo_size`, `cfs_logo_alignment`, `cfs_theme_color`, `cfs_font_family`, `cfs_font_size`, `cfs_margin`, `cfs_company_name_check`, `cfs_company_name_value`, `cfs_phone_check`, `cfs_phone_value`, `cfs_email_check`, `cfs_email_value`, `cfs_crn_check`, `cfs_crn_value`, `cfs_business_address_check`, `cfs_website_check`, `cfs_website_value`, `cfs_form_name_check`, `cfs_form_name_value`, `cfs_form_number_check`, `cfs_shipping_check`, `cfs_terms_check`, `cfs_duedate_check`, `cfs_table_date_check`, `cfs_table_product_check`, `cfs_table_desc_check`, `cfs_table_qty_check`, `cfs_table_rate_check`, `cfs_table_amount_check`, `cfs_footer_message_value`, `cfs_footer_message_font_size`, `cfs_footer_text_value`, `cfs_footer_text_font_size`, `cfs_footer_text_position`, `cfs_email_subject`, `cfs_email_use_greeting`, `cfs_email_greeting_pronoun`, `cfs_email_greeting_word`, `cfs_email_message`, `cfs_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->cfs_id,
                            $ccl->cfs_name,
                            $ccl->cfs_design_template,
                            $ccl->cfs_logo_name,
                            $ccl->cfs_logo_show,
                            $ccl->cfs_logo_size,
                            $ccl->cfs_logo_alignment,
                            $ccl->cfs_theme_color,
                            $ccl->cfs_font_family,
                            $ccl->cfs_font_size,
                            $ccl->cfs_margin,
                            $ccl->cfs_company_name_check,
                            $ccl->cfs_company_name_value,
                            $ccl->cfs_phone_check,
                            $ccl->cfs_phone_value,
                            $ccl->cfs_email_check,
                            $ccl->cfs_email_value,
                            $ccl->cfs_crn_check,
                            $ccl->cfs_crn_value,
                            $ccl->cfs_business_address_check,
                            $ccl->cfs_website_check,
                            $ccl->cfs_website_value,
                            $ccl->cfs_form_name_check,
                            $ccl->cfs_form_name_value,
                            $ccl->cfs_form_number_check,
                            $ccl->cfs_shipping_check,
                            $ccl->cfs_terms_check,
                            $ccl->cfs_duedate_check,
                            $ccl->cfs_table_date_check,
                            $ccl->cfs_table_product_check,
                            $ccl->cfs_table_desc_check,
                            $ccl->cfs_table_qty_check,
                            $ccl->cfs_table_rate_check,
                            $ccl->cfs_table_amount_check,
                            $ccl->cfs_footer_message_value,
                            $ccl->cfs_footer_message_font_size,
                            $ccl->cfs_footer_text_value,
                            $ccl->cfs_footer_text_font_size,
                            $ccl->cfs_footer_text_position,
                            $ccl->cfs_email_subject,
                            $ccl->cfs_email_use_greeting,
                            $ccl->cfs_email_greeting_pronoun,
                            $ccl->cfs_email_greeting_word,
                            $ccl->cfs_email_message,
                            $ccl->cfs_status,
                            $ccl->created_at,
                            $ccl->updated_at)
                    );
                    echo $ccl->cfs_id." custom form style insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE custom_form_style SET `cfs_id`=?, `cfs_name`=?, `cfs_design_template`=?, `cfs_logo_name`=?, `cfs_logo_show`=?, `cfs_logo_size`=?, `cfs_logo_alignment`=?, `cfs_theme_color`=?, `cfs_font_family`=?, `cfs_font_size`=?, `cfs_margin`=?, `cfs_company_name_check`=?, `cfs_company_name_value`=?, `cfs_phone_check`=?, `cfs_phone_value`=?, `cfs_email_check`=?, `cfs_email_value`=?, `cfs_crn_check`=?, `cfs_crn_value`=?, `cfs_business_address_check`=?, `cfs_website_check`=?, `cfs_website_value`=?, `cfs_form_name_check`=?, `cfs_form_name_value`=?, `cfs_form_number_check`=?, `cfs_shipping_check`=?, `cfs_terms_check`=?, `cfs_duedate_check`=?, `cfs_table_date_check`=?, `cfs_table_product_check`=?, `cfs_table_desc_check`=?, `cfs_table_qty_check`=?, `cfs_table_rate_check`=?, `cfs_table_amount_check`=?, `cfs_footer_message_value`=?, `cfs_footer_message_font_size`=?, `cfs_footer_text_value`=?, `cfs_footer_text_font_size`=?, `cfs_footer_text_position`=?, `cfs_email_subject`=?, `cfs_email_use_greeting`=?, `cfs_email_greeting_pronoun`=?, `cfs_email_greeting_word`=?, `cfs_email_message`=?, `cfs_status`=?, `created_at`=?, `updated_at`=? WHERE cfs_id=?'),
                            array($ccl->cfs_id,
                                $ccl->cfs_name,
                                $ccl->cfs_design_template,
                                $ccl->cfs_logo_name,
                                $ccl->cfs_logo_show,
                                $ccl->cfs_logo_size,
                                $ccl->cfs_logo_alignment,
                                $ccl->cfs_theme_color,
                                $ccl->cfs_font_family,
                                $ccl->cfs_font_size,
                                $ccl->cfs_margin,
                                $ccl->cfs_company_name_check,
                                $ccl->cfs_company_name_value,
                                $ccl->cfs_phone_check,
                                $ccl->cfs_phone_value,
                                $ccl->cfs_email_check,
                                $ccl->cfs_email_value,
                                $ccl->cfs_crn_check,
                                $ccl->cfs_crn_value,
                                $ccl->cfs_business_address_check,
                                $ccl->cfs_website_check,
                                $ccl->cfs_website_value,
                                $ccl->cfs_form_name_check,
                                $ccl->cfs_form_name_value,
                                $ccl->cfs_form_number_check,
                                $ccl->cfs_shipping_check,
                                $ccl->cfs_terms_check,
                                $ccl->cfs_duedate_check,
                                $ccl->cfs_table_date_check,
                                $ccl->cfs_table_product_check,
                                $ccl->cfs_table_desc_check,
                                $ccl->cfs_table_qty_check,
                                $ccl->cfs_table_rate_check,
                                $ccl->cfs_table_amount_check,
                                $ccl->cfs_footer_message_value,
                                $ccl->cfs_footer_message_font_size,
                                $ccl->cfs_footer_text_value,
                                $ccl->cfs_footer_text_font_size,
                                $ccl->cfs_footer_text_position,
                                $ccl->cfs_email_subject,
                                $ccl->cfs_email_use_greeting,
                                $ccl->cfs_email_greeting_pronoun,
                                $ccl->cfs_email_greeting_word,
                                $ccl->cfs_email_message,
                                $ccl->cfs_status,
                                $ccl->created_at,
                                $ccl->updated_at,
                                $ccl->cfs_id)
                            );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

        }catch(\Exception $e){

        }
        try{
            $customers= DB::connection('mysql3')->select("SELECT * FROM customers");
            $customers2= DB::connection('mysql')->select("SELECT * FROM customers");
            foreach($customers as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($customers2 as $ccl2){
                    if($ccl2->customer_id==$ccl->customer_id){
                        $dup=1;
                        $uid=$ccl2->customer_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into customers (`customer_id`, `f_name`, `l_name`, `email`, `company`, `phone`, `mobile`, `fax`, `display_name`, `other`, `website`, `street`, `city`, `state`, `postal_code`, `country`, `payment_method`, `terms`, `opening_balance`, `as_of_date`, `account_no`, `business_id_no`, `notes`, `tin_no`, `attachment`, `withhold_tax`, `business_style`, `tax_type`, `vat_value`, `account_type`, `supplier_active`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->customer_id,$ccl->f_name,$ccl->l_name,$ccl->email,$ccl->company,$ccl->phone,$ccl->mobile,$ccl->fax,$ccl->display_name,$ccl->other,$ccl->website,$ccl->street,$ccl->city,$ccl->state,$ccl->postal_code,$ccl->country,$ccl->payment_method,$ccl->terms,$ccl->opening_balance,$ccl->as_of_date,$ccl->account_no,$ccl->business_id_no,$ccl->notes,$ccl->tin_no,$ccl->attachment,$ccl->withhold_tax,$ccl->business_style,$ccl->tax_type,$ccl->vat_value,$ccl->account_type,$ccl->supplier_active,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->customer_id." customer insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE customers SET `customer_id`=?, `f_name`=?, `l_name`=?, `email`=?, `company`=?, `phone`=?, `mobile`=?, `fax`=?, `display_name`=?, `other`=?, `website`=?, `street`=?, `city`=?, `state`=?, `postal_code`=?, `country`=?, `payment_method`=?, `terms`=?, `opening_balance`=?, `as_of_date`=?, `account_no`=?, `business_id_no`=?, `notes`=?, `tin_no`=?, `attachment`=?, `withhold_tax`=?, `business_style`=?, `tax_type`=?, `vat_value`=?, `account_type`=?, `supplier_active`=?, `created_at`=?, `updated_at`=? WHERE customer_id=?'),
                            array($ccl->customer_id,$ccl->f_name,$ccl->l_name,$ccl->email,$ccl->company,$ccl->phone,$ccl->mobile,$ccl->fax,$ccl->display_name,$ccl->other,$ccl->website,$ccl->street,$ccl->city,$ccl->state,$ccl->postal_code,$ccl->country,$ccl->payment_method,$ccl->terms,$ccl->opening_balance,$ccl->as_of_date,$ccl->account_no,$ccl->business_id_no,$ccl->notes,$ccl->tin_no,$ccl->attachment,$ccl->withhold_tax,$ccl->business_style,$ccl->tax_type,$ccl->vat_value,$ccl->account_type,$ccl->supplier_active,$ccl->created_at,$ccl->updated_at,$ccl->customer_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $customers= DB::connection('mysql3')->select("SELECT * FROM customers_edits");
            $customers2= DB::connection('mysql')->select("SELECT * FROM customers_edits");
            foreach($customers as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($customers2 as $ccl2){
                    if($ccl2->customer_id==$ccl->customer_id){
                        $dup=1;
                        $uid=$ccl2->customer_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into customers_edits (`customer_id`, `f_name`, `l_name`, `email`, `company`, `phone`, `mobile`, `fax`, `display_name`, `other`, `website`, `street`, `city`, `state`, `postal_code`, `country`, `payment_method`, `terms`, `opening_balance`, `as_of_date`, `account_no`, `business_id_no`, `notes`, `tin_no`, `attachment`, `withhold_tax`, `business_style`, `tax_type`, `vat_value`, `account_type`, `supplier_active`, `edit_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->customer_id,$ccl->f_name,$ccl->l_name,$ccl->email,$ccl->company,$ccl->phone,$ccl->mobile,$ccl->fax,$ccl->display_name,$ccl->other,$ccl->website,$ccl->street,$ccl->city,$ccl->state,$ccl->postal_code,$ccl->country,$ccl->payment_method,$ccl->terms,$ccl->opening_balance,$ccl->as_of_date,$ccl->account_no,$ccl->business_id_no,$ccl->notes,$ccl->tin_no,$ccl->attachment,$ccl->withhold_tax,$ccl->business_style,$ccl->tax_type,$ccl->vat_value,$ccl->account_type,$ccl->supplier_active,$ccl->edit_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->customer_id." customer insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE customers_edits SET `customer_id`=?, `f_name`=?, `l_name`=?, `email`=?, `company`=?, `phone`=?, `mobile`=?, `fax`=?, `display_name`=?, `other`=?, `website`=?, `street`=?, `city`=?, `state`=?, `postal_code`=?, `country`=?, `payment_method`=?, `terms`=?, `opening_balance`=?, `as_of_date`=?, `account_no`=?, `business_id_no`=?, `notes`=?, `tin_no`=?, `attachment`=?, `withhold_tax`=?, `business_style`=?, `tax_type`=?, `vat_value`=?, `account_type`=?, `supplier_active`=?,`edit_status`=?, `created_at`=?, `updated_at`=? WHERE customer_id=?'),
                            array($ccl->customer_id,$ccl->f_name,$ccl->l_name,$ccl->email,$ccl->company,$ccl->phone,$ccl->mobile,$ccl->fax,$ccl->display_name,$ccl->other,$ccl->website,$ccl->street,$ccl->city,$ccl->state,$ccl->postal_code,$ccl->country,$ccl->payment_method,$ccl->terms,$ccl->opening_balance,$ccl->as_of_date,$ccl->account_no,$ccl->business_id_no,$ccl->notes,$ccl->tin_no,$ccl->attachment,$ccl->withhold_tax,$ccl->business_style,$ccl->tax_type,$ccl->vat_value,$ccl->account_type,$ccl->supplier_active,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->customer_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $custom_form_style= DB::connection('mysql3')->select("SELECT * FROM custom_form_style");
            $custom_form_style2= DB::connection('mysql')->select("SELECT * FROM custom_form_style");
            foreach($custom_form_style as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($custom_form_style2 as $ccl2){
                    if($ccl2->cfs_id==$ccl->cfs_id){
                        $dup=1;
                        $uid=$ccl2->cfs_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into custom_form_style (`cfs_id`, `cfs_name`, `cfs_design_template`, `cfs_logo_name`, `cfs_logo_show`, `cfs_logo_size`, `cfs_logo_alignment`, `cfs_theme_color`, `cfs_font_family`, `cfs_font_size`, `cfs_margin`, `cfs_company_name_check`, `cfs_company_name_value`, `cfs_phone_check`, `cfs_phone_value`, `cfs_email_check`, `cfs_email_value`, `cfs_crn_check`, `cfs_crn_value`, `cfs_business_address_check`, `cfs_website_check`, `cfs_website_value`, `cfs_form_name_check`, `cfs_form_name_value`, `cfs_form_number_check`, `cfs_shipping_check`, `cfs_terms_check`, `cfs_duedate_check`, `cfs_table_date_check`, `cfs_table_product_check`, `cfs_table_desc_check`, `cfs_table_qty_check`, `cfs_table_rate_check`, `cfs_table_amount_check`, `cfs_footer_message_value`, `cfs_footer_message_font_size`, `cfs_footer_text_value`, `cfs_footer_text_font_size`, `cfs_footer_text_position`, `cfs_email_subject`, `cfs_email_use_greeting`, `cfs_email_greeting_pronoun`, `cfs_email_greeting_word`, `cfs_email_message`, `cfs_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->cfs_id,
                            $ccl->cfs_name,
                            $ccl->cfs_design_template,
                            $ccl->cfs_logo_name,
                            $ccl->cfs_logo_show,
                            $ccl->cfs_logo_size,
                            $ccl->cfs_logo_alignment,
                            $ccl->cfs_theme_color,
                            $ccl->cfs_font_family,
                            $ccl->cfs_font_size,
                            $ccl->cfs_margin,
                            $ccl->cfs_company_name_check,
                            $ccl->cfs_company_name_value,
                            $ccl->cfs_phone_check,
                            $ccl->cfs_phone_value,
                            $ccl->cfs_email_check,
                            $ccl->cfs_email_value,
                            $ccl->cfs_crn_check,
                            $ccl->cfs_crn_value,
                            $ccl->cfs_business_address_check,
                            $ccl->cfs_website_check,
                            $ccl->cfs_website_value,
                            $ccl->cfs_form_name_check,
                            $ccl->cfs_form_name_value,
                            $ccl->cfs_form_number_check,
                            $ccl->cfs_shipping_check,
                            $ccl->cfs_terms_check,
                            $ccl->cfs_duedate_check,
                            $ccl->cfs_table_date_check,
                            $ccl->cfs_table_product_check,
                            $ccl->cfs_table_desc_check,
                            $ccl->cfs_table_qty_check,
                            $ccl->cfs_table_rate_check,
                            $ccl->cfs_table_amount_check,
                            $ccl->cfs_footer_message_value,
                            $ccl->cfs_footer_message_font_size,
                            $ccl->cfs_footer_text_value,
                            $ccl->cfs_footer_text_font_size,
                            $ccl->cfs_footer_text_position,
                            $ccl->cfs_email_subject,
                            $ccl->cfs_email_use_greeting,
                            $ccl->cfs_email_greeting_pronoun,
                            $ccl->cfs_email_greeting_word,
                            $ccl->cfs_email_message,
                            $ccl->cfs_status,
                            $ccl->created_at,
                            $ccl->updated_at)
                    );
                    echo $ccl->cfs_id." custom form style insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE custom_form_style SET `cfs_id`=?, `cfs_name`=?, `cfs_design_template`=?, `cfs_logo_name`=?, `cfs_logo_show`=?, `cfs_logo_size`=?, `cfs_logo_alignment`=?, `cfs_theme_color`=?, `cfs_font_family`=?, `cfs_font_size`=?, `cfs_margin`=?, `cfs_company_name_check`=?, `cfs_company_name_value`=?, `cfs_phone_check`=?, `cfs_phone_value`=?, `cfs_email_check`=?, `cfs_email_value`=?, `cfs_crn_check`=?, `cfs_crn_value`=?, `cfs_business_address_check`=?, `cfs_website_check`=?, `cfs_website_value`=?, `cfs_form_name_check`=?, `cfs_form_name_value`=?, `cfs_form_number_check`=?, `cfs_shipping_check`=?, `cfs_terms_check`=?, `cfs_duedate_check`=?, `cfs_table_date_check`=?, `cfs_table_product_check`=?, `cfs_table_desc_check`=?, `cfs_table_qty_check`=?, `cfs_table_rate_check`=?, `cfs_table_amount_check`=?, `cfs_footer_message_value`=?, `cfs_footer_message_font_size`=?, `cfs_footer_text_value`=?, `cfs_footer_text_font_size`=?, `cfs_footer_text_position`=?, `cfs_email_subject`=?, `cfs_email_use_greeting`=?, `cfs_email_greeting_pronoun`=?, `cfs_email_greeting_word`=?, `cfs_email_message`=?, `cfs_status`=?, `created_at`=?, `updated_at`=? WHERE cfs_id=?'),
                            array($ccl->cfs_id,
                                $ccl->cfs_name,
                                $ccl->cfs_design_template,
                                $ccl->cfs_logo_name,
                                $ccl->cfs_logo_show,
                                $ccl->cfs_logo_size,
                                $ccl->cfs_logo_alignment,
                                $ccl->cfs_theme_color,
                                $ccl->cfs_font_family,
                                $ccl->cfs_font_size,
                                $ccl->cfs_margin,
                                $ccl->cfs_company_name_check,
                                $ccl->cfs_company_name_value,
                                $ccl->cfs_phone_check,
                                $ccl->cfs_phone_value,
                                $ccl->cfs_email_check,
                                $ccl->cfs_email_value,
                                $ccl->cfs_crn_check,
                                $ccl->cfs_crn_value,
                                $ccl->cfs_business_address_check,
                                $ccl->cfs_website_check,
                                $ccl->cfs_website_value,
                                $ccl->cfs_form_name_check,
                                $ccl->cfs_form_name_value,
                                $ccl->cfs_form_number_check,
                                $ccl->cfs_shipping_check,
                                $ccl->cfs_terms_check,
                                $ccl->cfs_duedate_check,
                                $ccl->cfs_table_date_check,
                                $ccl->cfs_table_product_check,
                                $ccl->cfs_table_desc_check,
                                $ccl->cfs_table_qty_check,
                                $ccl->cfs_table_rate_check,
                                $ccl->cfs_table_amount_check,
                                $ccl->cfs_footer_message_value,
                                $ccl->cfs_footer_message_font_size,
                                $ccl->cfs_footer_text_value,
                                $ccl->cfs_footer_text_font_size,
                                $ccl->cfs_footer_text_position,
                                $ccl->cfs_email_subject,
                                $ccl->cfs_email_use_greeting,
                                $ccl->cfs_email_greeting_pronoun,
                                $ccl->cfs_email_greeting_word,
                                $ccl->cfs_email_message,
                                $ccl->cfs_status,
                                $ccl->created_at,
                                $ccl->updated_at,
                                $ccl->cfs_id)
                            );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

        }catch(\Exception $e){

        }
    }


    public function sync_expense(Request $request){
        
        try{
            $expense_transactions= DB::connection('mysql')->select("SELECT * FROM expense_transactions");
            $expense_transactions2= DB::connection('mysql3')->select("SELECT * FROM expense_transactions");
            foreach($expense_transactions as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($expense_transactions2 as $ccl2){
                    if($ccl2->et_no==$ccl->et_no && $ccl->et_type==$ccl2->et_type){
                        $dup=1;
                        $uid=$ccl2->et_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into expense_transactions (`et_no`, `et_customer`, `et_email`, `et_billing_address`, `et_account`, `et_payment_method`, `et_terms`, `et_date`, `et_due_date`, `et_bill_no`, `et_message`, `et_memo`, `et_attachment`, `et_reference_no`, `et_shipping_address`, `et_shipping_to`, `et_shipping_via`, `et_type`, `remark`, `cancellation_date`, `cancellation_reason`, `et_bil_status`, `created_at`, `updated_at`,`et_credit_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->created_at,$ccl->updated_at,$ccl->et_credit_account)
                    );
                    echo $ccl->et_no." expense transaction insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE expense_transactions SET `et_no`=?, `et_customer`=?, `et_email`=?, `et_billing_address`=?, `et_account`=?, `et_payment_method`=?, `et_terms`=?, `et_date`=?, `et_due_date`=?, `et_bill_no`=?, `et_message`=?, `et_memo`=?, `et_attachment`=?, `et_reference_no`=?, `et_shipping_address`=?, `et_shipping_to`=?, `et_shipping_via`=?, `et_type`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `et_bil_status`=?, `created_at`=?, `updated_at`=?,`et_credit_account`=? WHERE et_no=?'),
                            array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->created_at,$ccl->updated_at,$ccl->et_credit_account,$ccl->et_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $expense_transactions= DB::connection('mysql')->select("SELECT * FROM expense_transactions_edits");
            $expense_transactions2= DB::connection('mysql3')->select("SELECT * FROM expense_transactions_edits");
            foreach($expense_transactions as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($expense_transactions2 as $ccl2){
                    if($ccl2->et_no==$ccl->et_no && $ccl->et_type==$ccl2->et_type){
                        $dup=1;
                        $uid=$ccl2->et_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into expense_transactions_edits (`et_no`, `et_customer`, `et_email`, `et_billing_address`, `et_account`, `et_payment_method`, `et_terms`, `et_date`, `et_due_date`, `et_bill_no`, `et_message`, `et_memo`, `et_attachment`, `et_reference_no`, `et_shipping_address`, `et_shipping_to`, `et_shipping_via`, `et_type`, `remark`, `cancellation_date`, `cancellation_reason`, `et_bil_status`,`edit_status`, `created_at`, `updated_at`,`et_credit_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->et_credit_account)
                    );
                    echo $ccl->et_no." expense transaction edits insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE expense_transactions_edits SET `et_no`=?, `et_customer`=?, `et_email`=?, `et_billing_address`=?, `et_account`=?, `et_payment_method`=?, `et_terms`=?, `et_date`=?, `et_due_date`=?, `et_bill_no`=?, `et_message`=?, `et_memo`=?, `et_attachment`=?, `et_reference_no`=?, `et_shipping_address`=?, `et_shipping_to`=?, `et_shipping_via`=?, `et_type`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `et_bil_status`=?,`edit_status`=?, `created_at`=?, `updated_at`=?, `et_credit_account`=? WHERE et_no=?'),
                            array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->et_credit_account,$ccl->et_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $expense_transactions= DB::connection('mysql')->select("SELECT * FROM expense_transactions_new");
            $expense_transactions2= DB::connection('mysql3')->select("SELECT * FROM expense_transactions_new");
            foreach($expense_transactions as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($expense_transactions2 as $ccl2){
                    if($ccl2->et_no==$ccl->et_no && $ccl->et_type==$ccl2->et_type){
                        $dup=1;
                        $uid=$ccl2->et_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into expense_transactions_new (`et_no`, `et_customer`, `et_email`, `et_billing_address`, `et_account`, `et_payment_method`, `et_terms`, `et_date`, `et_due_date`, `et_bill_no`, `et_message`, `et_memo`, `et_attachment`, `et_reference_no`, `et_shipping_address`, `et_shipping_to`, `et_shipping_via`, `et_type`, `remark`, `cancellation_date`, `cancellation_reason`, `et_bil_status`,`et_debit_account`,`et_credit_account`, `created_at`, `updated_at`,`bill_balance`,`et_status`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->et_debit_account,$ccl->et_credit_account,$ccl->created_at,$ccl->updated_at,$ccl->bill_balance,$ccl->et_status)
                    );
                    echo $ccl->et_no." expense transaction new insert from original to cloud"; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE expense_transactions_new SET `et_no`=?, `et_customer`=?, `et_email`=?, `et_billing_address`=?, `et_account`=?, `et_payment_method`=?, `et_terms`=?, `et_date`=?, `et_due_date`=?, `et_bill_no`=?, `et_message`=?, `et_memo`=?, `et_attachment`=?, `et_reference_no`=?, `et_shipping_address`=?, `et_shipping_to`=?, `et_shipping_via`=?, `et_type`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `et_bil_status`=?,`et_debit_account`=?,`et_credit_account`=?, `created_at`=?, `updated_at`=?,`bill_balance`=?, `et_status`=? WHERE et_no=?'),
                            array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->et_debit_account,$ccl->et_credit_account,$ccl->created_at,$ccl->updated_at,$ccl->bill_balance,$ccl->et_status,$ccl->et_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $et_account_details= DB::connection('mysql')->select("SELECT * FROM et_account_details");
            $et_account_details2= DB::connection('mysql3')->select("SELECT * FROM et_account_details");
            foreach($et_account_details as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($et_account_details2 as $ccl2){
                    if( $ccl2->et_ad_qty==$ccl->et_ad_qty && $ccl2->et_ad_rate==$ccl->et_ad_rate && $ccl2->et_ad_type==$ccl->et_ad_type && $ccl2->created_at==$ccl->created_at){
                        $dup=1;
                        $uid=$ccl2->et_ad_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into et_account_details ( `et_ad_no`, `et_ad_product`, `et_ad_desc`, `et_ad_qty`, `et_ad_rate`, `et_ad_total`,`et_ad_type`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->et_ad_id." et_account details insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<=strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE et_account_details SET `et_ad_id`=?, `et_ad_no`=?, `et_ad_product`=?, `et_ad_desc`=?, `et_ad_qty`=?, `et_ad_rate`=?, `et_ad_total`=?,`et_ad_type`=?, `created_at`=?, `updated_at`=? WHERE created_at=? AND et_ad_qty=? AND et_ad_rate=? AND et_ad_type=?'),
                            array($ccl->et_ad_id,$ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->created_at,$ccl->updated_at,$ccl->created_at,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_type)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." et account detail";
                    }
                }
            }
            $et_account_details= DB::connection('mysql')->select("SELECT * FROM et_account_details_edits");
            $et_account_details2= DB::connection('mysql3')->select("SELECT * FROM et_account_details_edits");
            foreach($et_account_details as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($et_account_details2 as $ccl2){
                    if($ccl2->et_ad_qty==$ccl->et_ad_qty && $ccl2->et_ad_rate==$ccl->et_ad_rate && $ccl2->created_at==$ccl->created_at && $ccl2->et_ad_type==$ccl->et_ad_type){
                        $dup=1;
                        $uid=$ccl2->et_ad_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into et_account_details_edits ( `et_ad_no`, `et_ad_product`, `et_ad_desc`, `et_ad_qty`, `et_ad_rate`, `et_ad_total`,`et_ad_type`,`edit_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->edit_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->et_ad_id." et_account details insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<=strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE et_account_details_edits SET `et_ad_id`=?, `et_ad_no`=?, `et_ad_product`=?, `et_ad_desc`=?, `et_ad_qty`=?, `et_ad_rate`=?, `et_ad_total`=?,`et_ad_type`=?,`edit_status`=?, `created_at`=?, `updated_at`=? WHERE created_at=? AND et_ad_qty=? AND et_ad_rate=? AND et_ad_type=?'),
                            array($ccl->et_ad_id,$ccl->et_ad_no,$ccl->et_ad_product,$ccl->created_at,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->created_at,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_type)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." et account detail edit";
                    }
                }
            }
            $et_account_details= DB::connection('mysql')->select("SELECT * FROM et_account_details_new");
            $et_account_details2= DB::connection('mysql3')->select("SELECT * FROM et_account_details_new");
            foreach($et_account_details as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($et_account_details2 as $ccl2){
                    if($ccl2->et_ad_qty==$ccl->et_ad_qty  && $ccl2->et_ad_no==$ccl->et_ad_no && $ccl2->et_ad_rate==$ccl->et_ad_rate && $ccl2->et_ad_type==$ccl->et_ad_type){
                        $dup=1;
                        $uid=$ccl2->et_ad_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into et_account_details_new (`et_ad_id`, `et_ad_no`, `et_ad_product`, `et_ad_desc`, `et_ad_qty`, `et_ad_rate`, `et_ad_total`,`et_ad_type`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_ad_id,$ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->et_ad_id." et_account details new insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE et_account_details_new SET `et_ad_id`=?, `et_ad_no`=?, `et_ad_product`=?, `et_ad_desc`=?, `et_ad_qty`=?, `et_ad_rate`=?, `et_ad_total`=?,`et_ad_type`=?, `created_at`=?, `updated_at`=? WHERE et_ad_id=?'),
                            array($ccl->et_ad_id,$ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->created_at,$ccl->updated_at,$ccl->et_ad_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
        try{
            $expense_transactions= DB::connection('mysql3')->select("SELECT * FROM expense_transactions");
            $expense_transactions2= DB::connection('mysql')->select("SELECT * FROM expense_transactions");
            foreach($expense_transactions as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($expense_transactions2 as $ccl2){
                    if($ccl2->et_no==$ccl->et_no && $ccl->et_type==$ccl2->et_type){
                        $dup=1;
                        $uid=$ccl2->et_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into expense_transactions (`et_no`, `et_customer`, `et_email`, `et_billing_address`, `et_account`, `et_payment_method`, `et_terms`, `et_date`, `et_due_date`, `et_bill_no`, `et_message`, `et_memo`, `et_attachment`, `et_reference_no`, `et_shipping_address`, `et_shipping_to`, `et_shipping_via`, `et_type`, `remark`, `cancellation_date`, `cancellation_reason`, `et_bil_status`, `created_at`, `updated_at`,`et_credit_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->created_at,$ccl->updated_at,$ccl->et_credit_account)
                    );
                    echo $ccl->et_no." expense transaction insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE expense_transactions SET `et_no`=?, `et_customer`=?, `et_email`=?, `et_billing_address`=?, `et_account`=?, `et_payment_method`=?, `et_terms`=?, `et_date`=?, `et_due_date`=?, `et_bill_no`=?, `et_message`=?, `et_memo`=?, `et_attachment`=?, `et_reference_no`=?, `et_shipping_address`=?, `et_shipping_to`=?, `et_shipping_via`=?, `et_type`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `et_bil_status`=?, `created_at`=?, `updated_at`=?,`et_credit_account`=? WHERE et_no=?'),
                            array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->created_at,$ccl->updated_at,$ccl->et_credit_account,$ccl->et_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $expense_transactions= DB::connection('mysql3')->select("SELECT * FROM expense_transactions_edits");
            $expense_transactions2= DB::connection('mysql')->select("SELECT * FROM expense_transactions_edits");
            foreach($expense_transactions as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($expense_transactions2 as $ccl2){
                    if($ccl2->et_no==$ccl->et_no && $ccl->et_type==$ccl2->et_type){
                        $dup=1;
                        $uid=$ccl2->et_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into expense_transactions_edits (`et_no`, `et_customer`, `et_email`, `et_billing_address`, `et_account`, `et_payment_method`, `et_terms`, `et_date`, `et_due_date`, `et_bill_no`, `et_message`, `et_memo`, `et_attachment`, `et_reference_no`, `et_shipping_address`, `et_shipping_to`, `et_shipping_via`, `et_type`, `remark`, `cancellation_date`, `cancellation_reason`, `et_bil_status`,`edit_status`, `created_at`, `updated_at`,`et_credit_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->et_credit_account)
                    );
                    echo $ccl->et_no." expense transaction edits insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE expense_transactions_edits SET `et_no`=?, `et_customer`=?, `et_email`=?, `et_billing_address`=?, `et_account`=?, `et_payment_method`=?, `et_terms`=?, `et_date`=?, `et_due_date`=?, `et_bill_no`=?, `et_message`=?, `et_memo`=?, `et_attachment`=?, `et_reference_no`=?, `et_shipping_address`=?, `et_shipping_to`=?, `et_shipping_via`=?, `et_type`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `et_bil_status`=?,`edit_status`=?, `created_at`=?, `updated_at`=?, `et_credit_account`=? WHERE et_no=?'),
                            array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->et_credit_account,$ccl->et_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $expense_transactions= DB::connection('mysql3')->select("SELECT * FROM expense_transactions_new");
            $expense_transactions2= DB::connection('mysql')->select("SELECT * FROM expense_transactions_new");
            foreach($expense_transactions as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($expense_transactions2 as $ccl2){
                    if($ccl2->et_no==$ccl->et_no && $ccl->et_type==$ccl2->et_type){
                        $dup=1;
                        $uid=$ccl2->et_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into expense_transactions_new (`et_no`, `et_customer`, `et_email`, `et_billing_address`, `et_account`, `et_payment_method`, `et_terms`, `et_date`, `et_due_date`, `et_bill_no`, `et_message`, `et_memo`, `et_attachment`, `et_reference_no`, `et_shipping_address`, `et_shipping_to`, `et_shipping_via`, `et_type`, `remark`, `cancellation_date`, `cancellation_reason`, `et_bil_status`,`et_debit_account`,`et_credit_account`, `created_at`, `updated_at`,`bill_balance`,`et_status`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->et_debit_account,$ccl->et_credit_account,$ccl->created_at,$ccl->updated_at,$ccl->bill_balance,$ccl->et_status)
                    );
                    echo $ccl->et_no." expense transaction new insert from original to cloud"; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE expense_transactions_new SET `et_no`=?, `et_customer`=?, `et_email`=?, `et_billing_address`=?, `et_account`=?, `et_payment_method`=?, `et_terms`=?, `et_date`=?, `et_due_date`=?, `et_bill_no`=?, `et_message`=?, `et_memo`=?, `et_attachment`=?, `et_reference_no`=?, `et_shipping_address`=?, `et_shipping_to`=?, `et_shipping_via`=?, `et_type`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `et_bil_status`=?,`et_debit_account`=?,`et_credit_account`=?, `created_at`=?, `updated_at`=?,`bill_balance`=?, `et_status`=? WHERE et_no=?'),
                            array($ccl->et_no,$ccl->et_customer,$ccl->et_email,$ccl->et_billing_address,$ccl->et_account,$ccl->et_payment_method,$ccl->et_terms,$ccl->et_date,$ccl->et_due_date,$ccl->et_bill_no,$ccl->et_message,$ccl->et_memo,$ccl->et_attachment,$ccl->et_reference_no,$ccl->et_shipping_address,$ccl->et_shipping_to,$ccl->et_shipping_via,$ccl->et_type,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->et_bil_status,$ccl->et_debit_account,$ccl->et_credit_account,$ccl->created_at,$ccl->updated_at,$ccl->bill_balance,$ccl->et_status,$ccl->et_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $et_account_details= DB::connection('mysql3')->select("SELECT * FROM et_account_details");
            $et_account_details2= DB::connection('mysql')->select("SELECT * FROM et_account_details");
            foreach($et_account_details as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($et_account_details2 as $ccl2){
                    if( $ccl2->et_ad_qty==$ccl->et_ad_qty && $ccl2->et_ad_rate==$ccl->et_ad_rate && $ccl2->et_ad_type==$ccl->et_ad_type && $ccl2->created_at==$ccl->created_at){
                        $dup=1;
                        $uid=$ccl2->et_ad_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into et_account_details ( `et_ad_no`, `et_ad_product`, `et_ad_desc`, `et_ad_qty`, `et_ad_rate`, `et_ad_total`,`et_ad_type`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->et_ad_id." et_account details insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<=strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE et_account_details SET `et_ad_id`=?, `et_ad_no`=?, `et_ad_product`=?, `et_ad_desc`=?, `et_ad_qty`=?, `et_ad_rate`=?, `et_ad_total`=?,`et_ad_type`=?, `created_at`=?, `updated_at`=? WHERE created_at=? AND et_ad_qty=? AND et_ad_rate=? AND et_ad_type=?'),
                            array($ccl->et_ad_id,$ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->created_at,$ccl->updated_at,$ccl->created_at,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_type)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." et account detail";
                    }
                }
            }
            $et_account_details= DB::connection('mysql3')->select("SELECT * FROM et_account_details_edits");
            $et_account_details2= DB::connection('mysql')->select("SELECT * FROM et_account_details_edits");
            foreach($et_account_details as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($et_account_details2 as $ccl2){
                    if($ccl2->et_ad_qty==$ccl->et_ad_qty && $ccl2->et_ad_rate==$ccl->et_ad_rate && $ccl2->created_at==$ccl->created_at && $ccl2->et_ad_type==$ccl->et_ad_type){
                        $dup=1;
                        $uid=$ccl2->et_ad_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into et_account_details_edits ( `et_ad_no`, `et_ad_product`, `et_ad_desc`, `et_ad_qty`, `et_ad_rate`, `et_ad_total`,`et_ad_type`,`edit_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->edit_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->et_ad_id." et_account details insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<=strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE et_account_details_edits SET `et_ad_id`=?, `et_ad_no`=?, `et_ad_product`=?, `et_ad_desc`=?, `et_ad_qty`=?, `et_ad_rate`=?, `et_ad_total`=?,`et_ad_type`=?,`edit_status`=?, `created_at`=?, `updated_at`=? WHERE created_at=? AND et_ad_qty=? AND et_ad_rate=? AND et_ad_type=?'),
                            array($ccl->et_ad_id,$ccl->et_ad_no,$ccl->et_ad_product,$ccl->created_at,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->created_at,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_type)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." et account detail edit";
                    }
                }
            }
            $et_account_details= DB::connection('mysql3')->select("SELECT * FROM et_account_details_new");
            $et_account_details2= DB::connection('mysql')->select("SELECT * FROM et_account_details_new");
            foreach($et_account_details as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($et_account_details2 as $ccl2){
                    if($ccl2->et_ad_qty==$ccl->et_ad_qty  && $ccl2->et_ad_no==$ccl->et_ad_no && $ccl2->et_ad_rate==$ccl->et_ad_rate && $ccl2->et_ad_type==$ccl->et_ad_type){
                        $dup=1;
                        $uid=$ccl2->et_ad_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into et_account_details_new (`et_ad_id`, `et_ad_no`, `et_ad_product`, `et_ad_desc`, `et_ad_qty`, `et_ad_rate`, `et_ad_total`,`et_ad_type`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->et_ad_id,$ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->et_ad_id." et_account details new insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE et_account_details_new SET `et_ad_id`=?, `et_ad_no`=?, `et_ad_product`=?, `et_ad_desc`=?, `et_ad_qty`=?, `et_ad_rate`=?, `et_ad_total`=?,`et_ad_type`=?, `created_at`=?, `updated_at`=? WHERE et_ad_id=?'),
                            array($ccl->et_ad_id,$ccl->et_ad_no,$ccl->et_ad_product,$ccl->et_ad_desc,$ccl->et_ad_qty,$ccl->et_ad_rate,$ccl->et_ad_total,$ccl->et_ad_type,$ccl->created_at,$ccl->updated_at,$ccl->et_ad_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
    }

    public function sync_journal_entries(Request $request){
        
        try{
            $favorite_report= DB::connection('mysql')->select("SELECT * FROM favorite_report");
            $favorite_report2= DB::connection('mysql3')->select("SELECT * FROM favorite_report");
            //as is
            $numbering_system= DB::connection('mysql')->select("SELECT * FROM numbering_system");
            $numbering_system2= DB::connection('mysql3')->select("SELECT * FROM numbering_system");
            foreach($numbering_system as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($numbering_system2 as $ccl2){
                    if($ccl2->numbering_no==$ccl->numbering_no){
                        $dup=1;
                        $uid=$ccl2->numbering_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into numbering_system (`numbering_no`, `cash_voucher_start_no`, `sales_exp_start_no`, `cheque_voucher_start_no`, `use_cost_center`, `created_at`, `updated_at`, `numbering_bill_invoice_main` ,`numbering_sales_invoice_branch` ,`numbering_bill_invoice_branch` ,`credit_note_start_no`,`sales_receipt_start_no`,`bill_start_no`,`suppliers_credit_start_no`,`estimate_start_no`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->numbering_no,$ccl->cash_voucher_start_no,$ccl->sales_exp_start_no,$ccl->cheque_voucher_start_no,$ccl->use_cost_center,$ccl->created_at,$ccl->updated_at,$ccl->numbering_bill_invoice_main,$ccl->numbering_sales_invoice_branch,$ccl->numbering_bill_invoice_branch,$ccl->credit_note_start_no,$ccl->sales_receipt_start_no,$ccl->bill_start_no,$ccl->suppliers_credit_start_no,$ccl->estimate_start_no)
                    );
                    echo $ccl->numbering_no." numbering_system insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE numbering_system SET `numbering_no`=?, `cash_voucher_start_no`=?, `sales_exp_start_no`=?, `cheque_voucher_start_no`=?, `use_cost_center`=?, `created_at`=?, `updated_at`=? , `numbering_bill_invoice_main`=? ,`numbering_sales_invoice_branch`=? ,`numbering_bill_invoice_branch`=? ,`credit_note_start_no`=?,`sales_receipt_start_no`=?,`bill_start_no`=?,`suppliers_credit_start_no`=?,`estimate_start_no`=? WHERE numbering_no=? '),
                            array($ccl->numbering_no,$ccl->cash_voucher_start_no,$ccl->sales_exp_start_no,$ccl->cheque_voucher_start_no,$ccl->use_cost_center,$ccl->created_at,$ccl->updated_at,$ccl->numbering_bill_invoice_main,$ccl->numbering_sales_invoice_branch,$ccl->numbering_bill_invoice_branch,$ccl->credit_note_start_no,$ccl->sales_receipt_start_no,$ccl->bill_start_no,$ccl->suppliers_credit_start_no,$ccl->estimate_start_no,$ccl->numbering_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

            DB::connection('mysql')->delete("DELETE FROM `journal_entries` WHERE created_at NOT LIKE '%00:00:00'");
            DB::connection('mysql')->delete("DELETE FROM `journal_entries` where je_desc='CV LIQ # 05-000180 CHECK # 6661932 R.F # 19676-83 PCS 100MM FLEXCON COUPLER @ 15,338.40/32 PCS 65MM FLEXCON COUPLER @ 2,186.24' AND je_no='576'");

            DB::connection('mysql')->delete("DELETE FROM `journal_entries` where je_desc='Liq#2019-0347' AND je_no='579'");
            DB::connection('mysql')->delete("DELETE FROM `journal_entries` where je_desc='RF#18975 Budget 7/24' AND je_no='581'");
            DB::connection('mysql')->delete("DELETE FROM `journal_entries` where je_desc='CV LIQ # 05-000188 CHECK # 6661969 R.F # 19837-12 QRTS NATL BRAKE FLUID' AND je_no='582'");
            DB::connection('mysql')->delete("DELETE FROM `journal_entries` where je_desc='CV LIQ # 05-000140 CHECK # 6661915 R.F # 17282/18853-2 PAIR SAFETY SHOES' AND je_no='600'");
            DB::connection('mysql')->delete("DELETE FROM `journal_entries` where je_desc='Liq#2019-0348' AND je_no='597'");
            DB::connection('mysql')->delete("DELETE FROM `journal_entries` where je_desc='Liquidation#016' AND je_no='609'");
            DB::connection('mysql')->delete("DELETE FROM `journal_entries` where je_desc='CV LIQ # 05-000196 CHECK # 6664215-PAYMENT FOR SOA JUNE 24-30, 2019' AND je_no='610'");
            
            $journal_entries= DB::connection('mysql')->select("SELECT * FROM journal_entries");
            $journal_entries2= DB::connection('mysql3')->select("SELECT * FROM journal_entries");
            foreach($journal_entries as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($journal_entries2 as $ccl2){
                    if($ccl2->je_no==$ccl->je_no && $ccl2->je_id==$ccl->je_id && $ccl2->other_no==$ccl->other_no && $ccl2->create_point==$ccl->create_point && $ccl2->je_invoice_location_and_type==$ccl->je_invoice_location_and_type){
                        $dup=1;
                        $uid=$ccl2->je_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into journal_entries (`je_id`, `je_no`, `je_account`, `je_debit`, `je_credit`, `je_desc`, `je_name`, `je_memo`, `je_attachment`, `je_transaction_type`, `other_no`, `remark`, `cancellation_date`, `cancellation_reason`, `je_cost_center`,`je_invoice_location_and_type`, `created_at`, `updated_at`,`create_point`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->je_id,$ccl->je_no,$ccl->je_account,$ccl->je_debit,$ccl->je_credit,$ccl->je_desc,$ccl->je_name,$ccl->je_memo,$ccl->je_attachment,$ccl->je_transaction_type,$ccl->other_no,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->je_cost_center,$ccl->je_invoice_location_and_type,$ccl->created_at,$ccl->updated_at,$ccl->create_point)
                    );
                    echo $ccl->je_no." Journal Entry insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE journal_entries SET `je_id`=?, `je_no`=?, `je_account`=?, `je_debit`=?, `je_credit`=?, `je_desc`=?, `je_name`=?, `je_memo`=?, `je_attachment`=?, `je_transaction_type`=?, `other_no`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `je_cost_center`=?,`je_invoice_location_and_type`=?, `created_at`=?, `updated_at`=?,`create_point`=? WHERE create_point=? AND je_id=? AND je_no=? AND other_no=? AND je_invoice_location_and_type=?'),
                            array($ccl->je_id,$ccl->je_no,$ccl->je_account,$ccl->je_debit,$ccl->je_credit,$ccl->je_desc,$ccl->je_name,$ccl->je_memo,$ccl->je_attachment,$ccl->je_transaction_type,$ccl->other_no,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->je_cost_center,$ccl->je_invoice_location_and_type,$ccl->created_at,$ccl->updated_at,$ccl->create_point,$ccl->create_point,$ccl->je_id,$ccl->je_no,$ccl->other_no,$ccl->je_invoice_location_and_type)
                        );
                        echo  "Journal Entry : ".$updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

            
        }catch(\Exception $e){

        }
        try{
            $favorite_report= DB::connection('mysql3')->select("SELECT * FROM favorite_report");
            $favorite_report2= DB::connection('mysql')->select("SELECT * FROM favorite_report");
            //as is
            $numbering_system= DB::connection('mysql3')->select("SELECT * FROM numbering_system");
            $numbering_system2= DB::connection('mysql')->select("SELECT * FROM numbering_system");
            foreach($numbering_system as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($numbering_system2 as $ccl2){
                    if($ccl2->numbering_no==$ccl->numbering_no){
                        $dup=1;
                        $uid=$ccl2->numbering_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into numbering_system (`numbering_no`, `cash_voucher_start_no`, `sales_exp_start_no`, `cheque_voucher_start_no`, `use_cost_center`, `created_at`, `updated_at`, `numbering_bill_invoice_main` ,`numbering_sales_invoice_branch` ,`numbering_bill_invoice_branch` ,`credit_note_start_no`,`sales_receipt_start_no`,`bill_start_no`,`suppliers_credit_start_no`,`estimate_start_no`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->numbering_no,$ccl->cash_voucher_start_no,$ccl->sales_exp_start_no,$ccl->cheque_voucher_start_no,$ccl->use_cost_center,$ccl->created_at,$ccl->updated_at,$ccl->numbering_bill_invoice_main,$ccl->numbering_sales_invoice_branch,$ccl->numbering_bill_invoice_branch,$ccl->credit_note_start_no,$ccl->sales_receipt_start_no,$ccl->bill_start_no,$ccl->suppliers_credit_start_no,$ccl->estimate_start_no)
                    );
                    echo $ccl->numbering_no." numbering_system insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE numbering_system SET `numbering_no`=?, `cash_voucher_start_no`=?, `sales_exp_start_no`=?, `cheque_voucher_start_no`=?, `use_cost_center`=?, `created_at`=?, `updated_at`=? , `numbering_bill_invoice_main`=? ,`numbering_sales_invoice_branch`=? ,`numbering_bill_invoice_branch`=? ,`credit_note_start_no`=?,`sales_receipt_start_no`=?,`bill_start_no`=?,`suppliers_credit_start_no`=?,`estimate_start_no`=? WHERE numbering_no=? '),
                            array($ccl->numbering_no,$ccl->cash_voucher_start_no,$ccl->sales_exp_start_no,$ccl->cheque_voucher_start_no,$ccl->use_cost_center,$ccl->created_at,$ccl->updated_at,$ccl->numbering_bill_invoice_main,$ccl->numbering_sales_invoice_branch,$ccl->numbering_bill_invoice_branch,$ccl->credit_note_start_no,$ccl->sales_receipt_start_no,$ccl->bill_start_no,$ccl->suppliers_credit_start_no,$ccl->estimate_start_no,$ccl->numbering_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $journal_entries= DB::connection('mysql3')->select("SELECT * FROM journal_entries");
            $journal_entries2= DB::connection('mysql')->select("SELECT * FROM journal_entries");
            foreach($journal_entries as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($journal_entries2 as $ccl2){
                    if($ccl2->je_no==$ccl->je_no && $ccl2->je_id==$ccl->je_id && $ccl2->other_no==$ccl->other_no && $ccl2->create_point==$ccl->create_point && $ccl2->je_invoice_location_and_type==$ccl->je_invoice_location_and_type){
                        $dup=1;
                        $uid=$ccl2->je_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into journal_entries (`je_id`, `je_no`, `je_account`, `je_debit`, `je_credit`, `je_desc`, `je_name`, `je_memo`, `je_attachment`, `je_transaction_type`, `other_no`, `remark`, `cancellation_date`, `cancellation_reason`, `je_cost_center`,`je_invoice_location_and_type`, `created_at`, `updated_at`,`create_point`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->je_id,$ccl->je_no,$ccl->je_account,$ccl->je_debit,$ccl->je_credit,$ccl->je_desc,$ccl->je_name,$ccl->je_memo,$ccl->je_attachment,$ccl->je_transaction_type,$ccl->other_no,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->je_cost_center,$ccl->je_invoice_location_and_type,$ccl->created_at,$ccl->updated_at,$ccl->create_point)
                    );
                    echo $ccl->je_no." Journal Entry insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE journal_entries SET `je_id`=?, `je_no`=?, `je_account`=?, `je_debit`=?, `je_credit`=?, `je_desc`=?, `je_name`=?, `je_memo`=?, `je_attachment`=?, `je_transaction_type`=?, `other_no`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `je_cost_center`=?,`je_invoice_location_and_type`=?, `created_at`=?, `updated_at`=?,`create_point`=? WHERE create_point=? AND je_id=? AND je_no=? AND other_no=? AND je_invoice_location_and_type=?'),
                            array($ccl->je_id,$ccl->je_no,$ccl->je_account,$ccl->je_debit,$ccl->je_credit,$ccl->je_desc,$ccl->je_name,$ccl->je_memo,$ccl->je_attachment,$ccl->je_transaction_type,$ccl->other_no,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->je_cost_center,$ccl->je_invoice_location_and_type,$ccl->created_at,$ccl->updated_at,$ccl->create_point,$ccl->create_point,$ccl->je_id,$ccl->je_no,$ccl->other_no,$ccl->je_invoice_location_and_type)
                        );
                        echo  "Journal Entry : ".$updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

            
        }catch(\Exception $e){

        }
    }

    public function sync_paybills(Request $request){
       
        try{
            $password_resets= DB::connection('mysql')->select("SELECT * FROM password_resets");
            $password_resets2= DB::connection('mysql3')->select("SELECT * FROM password_resets");
            foreach($password_resets as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($password_resets2 as $ccl2){
                    if($ccl2->email==$ccl->email){
                        $dup=1;
                        $uid=$ccl2->numbering_no;
                        $updated_at=$ccl2->created_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into password_resets (email,token,created_at) values (?,?,?)'),
                        array($ccl->email,$ccl->token,$ccl->created_at)
                    );
                    echo $ccl->email." numbering_system insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->created_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE numbering_system SET email=?,token=?,created_at=? WHERE email=? '),
                            array($ccl->email,$ccl->token,$ccl->created_at,$ccl->email)
                        );
                        echo  $updated_at." < ". $ccl->created_at." ";
                    }
                }
            }

            $pay_bill= DB::connection('mysql')->select("SELECT * FROM pay_bill");
            $pay_bill2= DB::connection('mysql3')->select("SELECT * FROM pay_bill");
            foreach($pay_bill as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($pay_bill2 as $ccl2){
                    if($ccl2->pay_bill_no==$ccl->pay_bill_no){
                        $dup=1;
                        $uid=$ccl2->pay_bill_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into pay_bill (`pay_bill_no`, `payment_account`, `payment_date`, `payment_bank_account`, `pay_bill_group_no`, `bill_no`,`bill_payment_amount`,`payment_remark`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->pay_bill_no,$ccl->payment_account,$ccl->payment_date,$ccl->payment_bank_account,$ccl->pay_bill_group_no,$ccl->bill_no,$ccl->bill_payment_amount,$ccl->payment_remark,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->pay_bill_no." pay_bill insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE pay_bill SET `pay_bill_no`=?, `payment_account`=?, `payment_date`=?, `payment_bank_account`=?, `pay_bill_group_no`=?, `bill_no`=?,`bill_payment_amount`=?,`payment_remark`=?, `created_at`=?, `updated_at`=? WHERE pay_bill_no=? '),
                            array($ccl->pay_bill_no,$ccl->payment_account,$ccl->payment_date,$ccl->payment_bank_account,$ccl->pay_bill_group_no,$ccl->bill_no,$ccl->bill_payment_amount,$ccl->payment_remark,$ccl->created_at,$ccl->updated_at,$ccl->pay_bill_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $products_and_services= DB::connection('mysql')->select("SELECT * FROM products_and_services");
            $products_and_services2= DB::connection('mysql3')->select("SELECT * FROM products_and_services");
            foreach($products_and_services as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($products_and_services2 as $ccl2){
                    if($ccl2->product_id==$ccl->product_id){
                        $dup=1;
                        $uid=$ccl2->product_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into products_and_services (`product_id`, `product_name`, `product_sku`, `product_type`, `product_sales_description`, `product_sales_price`, `product_cost`, `product_qty`, `product_reorder_point`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->product_id,$ccl->product_name,$ccl->product_sku,$ccl->product_type,$ccl->product_sales_description,$ccl->product_sales_price,$ccl->product_cost,$ccl->product_qty,$ccl->product_reorder_point,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->product_id." product and services insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE products_and_services SET `product_id`=?, `product_name`=?, `product_sku`=?, `product_type`=?, `product_sales_description`=?, `product_sales_price`=?, `product_cost`=?, `product_qty`=?, `product_reorder_point`=?, `created_at`=?, `updated_at`=? WHERE product_id=? '),
                            array($ccl->product_id,$ccl->product_name,$ccl->product_sku,$ccl->product_type,$ccl->product_sales_description,$ccl->product_sales_price,$ccl->product_cost,$ccl->product_qty,$ccl->product_reorder_point,$ccl->created_at,$ccl->updated_at,$ccl->product_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $products_and_services= DB::connection('mysql')->select("SELECT * FROM products_and_services_edit");
            $products_and_services2= DB::connection('mysql3')->select("SELECT * FROM products_and_services_edit");
            foreach($products_and_services as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($products_and_services2 as $ccl2){
                    if($ccl2->product_id==$ccl->product_id){
                        $dup=1;
                        $uid=$ccl2->product_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into products_and_services_edit (`product_id`, `product_name`, `product_sku`, `product_type`, `product_sales_description`, `product_sales_price`, `product_cost`, `product_qty`, `product_reorder_point`,`edit_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->product_id,$ccl->product_name,$ccl->product_sku,$ccl->product_type,$ccl->product_sales_description,$ccl->product_sales_price,$ccl->product_cost,$ccl->product_qty,$ccl->product_reorder_point,$ccl->edit_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->product_id." product and services insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE products_and_services_edit SET `product_id`=?, `product_name`=?, `product_sku`=?, `product_type`=?, `product_sales_description`=?, `product_sales_price`=?, `product_cost`=?, `product_qty`=?, `product_reorder_point`=?,`edit_status`=?, `created_at`=?, `updated_at`=? WHERE product_id=? '),
                            array($ccl->product_id,$ccl->product_name,$ccl->product_sku,$ccl->product_type,$ccl->product_sales_description,$ccl->product_sales_price,$ccl->product_cost,$ccl->product_qty,$ccl->product_reorder_point,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->product_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
        try{
            $password_resets= DB::connection('mysql3')->select("SELECT * FROM password_resets");
            $password_resets2= DB::connection('mysql')->select("SELECT * FROM password_resets");
            foreach($password_resets as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($password_resets2 as $ccl2){
                    if($ccl2->email==$ccl->email){
                        $dup=1;
                        $uid=$ccl2->numbering_no;
                        $updated_at=$ccl2->created_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into password_resets (email,token,created_at) values (?,?,?)'),
                        array($ccl->email,$ccl->token,$ccl->created_at)
                    );
                    echo $ccl->email." numbering_system insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->created_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE numbering_system SET email=?,token=?,created_at=? WHERE email=? '),
                            array($ccl->email,$ccl->token,$ccl->created_at,$ccl->email)
                        );
                        echo  $updated_at." < ". $ccl->created_at." ";
                    }
                }
            }

            $pay_bill= DB::connection('mysql3')->select("SELECT * FROM pay_bill");
            $pay_bill2= DB::connection('mysql')->select("SELECT * FROM pay_bill");
            foreach($pay_bill as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($pay_bill2 as $ccl2){
                    if($ccl2->pay_bill_no==$ccl->pay_bill_no){
                        $dup=1;
                        $uid=$ccl2->pay_bill_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into pay_bill (`pay_bill_no`, `payment_account`, `payment_date`, `payment_bank_account`, `pay_bill_group_no`, `bill_no`,`bill_payment_amount`,`payment_remark`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->pay_bill_no,$ccl->payment_account,$ccl->payment_date,$ccl->payment_bank_account,$ccl->pay_bill_group_no,$ccl->bill_no,$ccl->bill_payment_amount,$ccl->payment_remark,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->pay_bill_no." pay_bill insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE pay_bill SET `pay_bill_no`=?, `payment_account`=?, `payment_date`=?, `payment_bank_account`=?, `pay_bill_group_no`=?, `bill_no`=?,`bill_payment_amount`=?,`payment_remark`=?, `created_at`=?, `updated_at`=? WHERE pay_bill_no=? '),
                            array($ccl->pay_bill_no,$ccl->payment_account,$ccl->payment_date,$ccl->payment_bank_account,$ccl->pay_bill_group_no,$ccl->bill_no,$ccl->bill_payment_amount,$ccl->payment_remark,$ccl->created_at,$ccl->updated_at,$ccl->pay_bill_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $products_and_services= DB::connection('mysql3')->select("SELECT * FROM products_and_services");
            $products_and_services2= DB::connection('mysql')->select("SELECT * FROM products_and_services");
            foreach($products_and_services as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($products_and_services2 as $ccl2){
                    if($ccl2->product_id==$ccl->product_id){
                        $dup=1;
                        $uid=$ccl2->product_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into products_and_services (`product_id`, `product_name`, `product_sku`, `product_type`, `product_sales_description`, `product_sales_price`, `product_cost`, `product_qty`, `product_reorder_point`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->product_id,$ccl->product_name,$ccl->product_sku,$ccl->product_type,$ccl->product_sales_description,$ccl->product_sales_price,$ccl->product_cost,$ccl->product_qty,$ccl->product_reorder_point,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->product_id." product and services insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE products_and_services SET `product_id`=?, `product_name`=?, `product_sku`=?, `product_type`=?, `product_sales_description`=?, `product_sales_price`=?, `product_cost`=?, `product_qty`=?, `product_reorder_point`=?, `created_at`=?, `updated_at`=? WHERE product_id=? '),
                            array($ccl->product_id,$ccl->product_name,$ccl->product_sku,$ccl->product_type,$ccl->product_sales_description,$ccl->product_sales_price,$ccl->product_cost,$ccl->product_qty,$ccl->product_reorder_point,$ccl->created_at,$ccl->updated_at,$ccl->product_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $products_and_services= DB::connection('mysql3')->select("SELECT * FROM products_and_services_edit");
            $products_and_services2= DB::connection('mysql')->select("SELECT * FROM products_and_services_edit");
            foreach($products_and_services as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($products_and_services2 as $ccl2){
                    if($ccl2->product_id==$ccl->product_id){
                        $dup=1;
                        $uid=$ccl2->product_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into products_and_services_edit (`product_id`, `product_name`, `product_sku`, `product_type`, `product_sales_description`, `product_sales_price`, `product_cost`, `product_qty`, `product_reorder_point`,`edit_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->product_id,$ccl->product_name,$ccl->product_sku,$ccl->product_type,$ccl->product_sales_description,$ccl->product_sales_price,$ccl->product_cost,$ccl->product_qty,$ccl->product_reorder_point,$ccl->edit_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->product_id." product and services insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE products_and_services_edit SET `product_id`=?, `product_name`=?, `product_sku`=?, `product_type`=?, `product_sales_description`=?, `product_sales_price`=?, `product_cost`=?, `product_qty`=?, `product_reorder_point`=?,`edit_status`=?, `created_at`=?, `updated_at`=? WHERE product_id=? '),
                            array($ccl->product_id,$ccl->product_name,$ccl->product_sku,$ccl->product_type,$ccl->product_sales_description,$ccl->product_sales_price,$ccl->product_cost,$ccl->product_qty,$ccl->product_reorder_point,$ccl->edit_status,$ccl->created_at,$ccl->updated_at,$ccl->product_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
    }
    public function sync_po(Request $request){
        
        try{
            $table= DB::connection('mysql')->select("SELECT * FROM purchase_orders");
            $table2= DB::connection('mysql3')->select("SELECT * FROM purchase_orders");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->po_no==$ccl->po_no){
                        $dup=1;
                        $uid=$ccl2->po_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into purchase_orders (`po_no`, `po_customer`, `po_requestor`, `po_cost_center`, `po_date`, `po_status`, `po_delivery_date`, `po_note`, `po_total`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->po_no,$ccl->po_customer,$ccl->po_requestor,$ccl->po_cost_center,$ccl->po_date,$ccl->po_status,$ccl->po_delivery_date,$ccl->po_note,$ccl->po_total,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->po_no." purchase_orders insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE purchase_orders SET `po_no`=?, `po_customer`=?, `po_requestor`=?, `po_cost_center`=?, `po_date`=?, `po_status`=?, `po_delivery_date`=?, `po_note`=?, `po_total`=?, `created_at`=?, `updated_at`=? WHERE po_no=? '),
                            array($ccl->po_no,$ccl->po_customer,$ccl->po_requestor,$ccl->po_cost_center,$ccl->po_date,$ccl->po_status,$ccl->po_delivery_date,$ccl->po_note,$ccl->po_total,$ccl->created_at,$ccl->updated_at,$ccl->po_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM po_item_details");
            $table2= DB::connection('mysql3')->select("SELECT * FROM po_item_details");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->po_id_id==$ccl->po_id_id && $ccl2->po_id_no==$ccl->po_id_no){
                        $dup=1;
                        $uid=$ccl2->po_id_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into po_item_details (`po_id_id`, `po_id_no`, `po_product_id`, `po_product_desc`, `po_qty`, `po_product_rate`, `po_product_total`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?)'),
                        array($ccl->po_id_id,$ccl->po_id_no,$ccl->po_product_id,$ccl->po_product_desc,$ccl->po_qty,$ccl->po_product_rate,$ccl->po_product_total,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->po_id_id." po_item_details insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE po_item_details SET `po_id_id`=?, `po_id_no`=?, `po_product_id`=?, `po_product_desc`=?, `po_qty`=?, `po_product_rate`=?, `po_product_total`=?, `created_at`=?, `updated_at`=? WHERE po_id_id=? AND po_id_no=? '),
                            array($ccl->po_id_id,$ccl->po_id_no,$ccl->po_product_id,$ccl->po_product_desc,$ccl->po_qty,$ccl->po_product_rate,$ccl->po_product_total,$ccl->created_at,$ccl->updated_at,$ccl->po_id_id,$ccl->po_id_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM reports");
            $table2= DB::connection('mysql3')->select("SELECT * FROM reports");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->report_id==$ccl->report_id){
                        $dup=1;
                        $uid=$ccl2->report_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into reports (`report_id`, `report_name`, `report_header`, `report_title`, `report_type`, `report_show_note`, `report_note`, `report_sort_by`, `report_sort_order`, `report_table_column`, `report_content_from`, `report_content_to`, `report_content_filter`, `report_content_cost_center_filter`, `report_url`, `report_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->report_id,$ccl->report_name,$ccl->report_header,$ccl->report_title,$ccl->report_type,$ccl->report_show_note,$ccl->report_note,$ccl->report_sort_by,$ccl->report_sort_order,$ccl->report_table_column,$ccl->report_content_from,$ccl->report_content_to,$ccl->report_content_filter,$ccl->report_content_cost_center_filter,$ccl->report_url,$ccl->report_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->report_id." report insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE reports SET `report_id`=?, `report_name`=?, `report_header`=?, `report_title`=?, `report_type`=?, `report_show_note`=?, `report_note`=?, `report_sort_by`=?, `report_sort_order`=?, `report_table_column`=?, `report_content_from`=?, `report_content_to`=?, `report_content_filter`=?, `report_content_cost_center_filter`=?, `report_url`=?, `report_status`=?, `created_at`=?, `updated_at`=? WHERE report_id=? '),
                            array($ccl->report_id,$ccl->report_name,$ccl->report_header,$ccl->report_title,$ccl->report_type,$ccl->report_show_note,$ccl->report_note,$ccl->report_sort_by,$ccl->report_sort_order,$ccl->report_table_column,$ccl->report_content_from,$ccl->report_content_to,$ccl->report_content_filter,$ccl->report_content_cost_center_filter,$ccl->report_url,$ccl->report_status,$ccl->created_at,$ccl->updated_at,$ccl->report_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
        try{
            $table= DB::connection('mysql3')->select("SELECT * FROM purchase_orders");
            $table2= DB::connection('mysql')->select("SELECT * FROM purchase_orders");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->po_no==$ccl->po_no){
                        $dup=1;
                        $uid=$ccl2->po_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into purchase_orders (`po_no`, `po_customer`, `po_requestor`, `po_cost_center`, `po_date`, `po_status`, `po_delivery_date`, `po_note`, `po_total`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->po_no,$ccl->po_customer,$ccl->po_requestor,$ccl->po_cost_center,$ccl->po_date,$ccl->po_status,$ccl->po_delivery_date,$ccl->po_note,$ccl->po_total,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->po_no." purchase_orders insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE purchase_orders SET `po_no`=?, `po_customer`=?, `po_requestor`=?, `po_cost_center`=?, `po_date`=?, `po_status`=?, `po_delivery_date`=?, `po_note`=?, `po_total`=?, `created_at`=?, `updated_at`=? WHERE po_no=? '),
                            array($ccl->po_no,$ccl->po_customer,$ccl->po_requestor,$ccl->po_cost_center,$ccl->po_date,$ccl->po_status,$ccl->po_delivery_date,$ccl->po_note,$ccl->po_total,$ccl->created_at,$ccl->updated_at,$ccl->po_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM po_item_details");
            $table2= DB::connection('mysql')->select("SELECT * FROM po_item_details");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->po_id_id==$ccl->po_id_id && $ccl2->po_id_no==$ccl->po_id_no){
                        $dup=1;
                        $uid=$ccl2->po_id_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into po_item_details (`po_id_id`, `po_id_no`, `po_product_id`, `po_product_desc`, `po_qty`, `po_product_rate`, `po_product_total`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?)'),
                        array($ccl->po_id_id,$ccl->po_id_no,$ccl->po_product_id,$ccl->po_product_desc,$ccl->po_qty,$ccl->po_product_rate,$ccl->po_product_total,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->po_id_id." po_item_details insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE po_item_details SET `po_id_id`=?, `po_id_no`=?, `po_product_id`=?, `po_product_desc`=?, `po_qty`=?, `po_product_rate`=?, `po_product_total`=?, `created_at`=?, `updated_at`=? WHERE po_id_id=? AND po_id_no=? '),
                            array($ccl->po_id_id,$ccl->po_id_no,$ccl->po_product_id,$ccl->po_product_desc,$ccl->po_qty,$ccl->po_product_rate,$ccl->po_product_total,$ccl->created_at,$ccl->updated_at,$ccl->po_id_id,$ccl->po_id_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM reports");
            $table2= DB::connection('mysql')->select("SELECT * FROM reports");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->report_id==$ccl->report_id){
                        $dup=1;
                        $uid=$ccl2->report_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into reports (`report_id`, `report_name`, `report_header`, `report_title`, `report_type`, `report_show_note`, `report_note`, `report_sort_by`, `report_sort_order`, `report_table_column`, `report_content_from`, `report_content_to`, `report_content_filter`, `report_content_cost_center_filter`, `report_url`, `report_status`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->report_id,$ccl->report_name,$ccl->report_header,$ccl->report_title,$ccl->report_type,$ccl->report_show_note,$ccl->report_note,$ccl->report_sort_by,$ccl->report_sort_order,$ccl->report_table_column,$ccl->report_content_from,$ccl->report_content_to,$ccl->report_content_filter,$ccl->report_content_cost_center_filter,$ccl->report_url,$ccl->report_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->report_id." report insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE reports SET `report_id`=?, `report_name`=?, `report_header`=?, `report_title`=?, `report_type`=?, `report_show_note`=?, `report_note`=?, `report_sort_by`=?, `report_sort_order`=?, `report_table_column`=?, `report_content_from`=?, `report_content_to`=?, `report_content_filter`=?, `report_content_cost_center_filter`=?, `report_url`=?, `report_status`=?, `created_at`=?, `updated_at`=? WHERE report_id=? '),
                            array($ccl->report_id,$ccl->report_name,$ccl->report_header,$ccl->report_title,$ccl->report_type,$ccl->report_show_note,$ccl->report_note,$ccl->report_sort_by,$ccl->report_sort_order,$ccl->report_table_column,$ccl->report_content_from,$ccl->report_content_to,$ccl->report_content_filter,$ccl->report_content_cost_center_filter,$ccl->report_url,$ccl->report_status,$ccl->created_at,$ccl->updated_at,$ccl->report_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
    }
    public function sync_sales(Request $request){
        
        try{
            $table= DB::connection('mysql')->select("SELECT * FROM sales_transaction");
            $table2= DB::connection('mysql3')->select("SELECT * FROM sales_transaction");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_no==$ccl->st_no && $ccl2->st_type==$ccl->st_type  && $ccl2->st_location==$ccl->st_location && $ccl2->st_invoice_type==$ccl->st_invoice_type ){
                        $dup=1;
                        $uid=$ccl2->st_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into sales_transaction (`st_no`, `st_date`, `st_type`, `st_term`, `st_customer_id`, `st_due_date`, `st_status`, `st_action`, `st_email`, `st_send_later`, `st_bill_address`, `st_note`, `st_memo`, `st_i_attachment`, `st_balance`, `st_amount_paid`, `st_payment_for`, `remark`, `cancellation_date`, `cancellation_reason`, `created_at`, `updated_at`,`st_location`,`st_invoice_type`,`st_invoice_job_order`,`st_invoice_work_no`,`st_debit_account`,`st_credit_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_no,$ccl->st_date,$ccl->st_type,$ccl->st_term,$ccl->st_customer_id,$ccl->st_due_date,$ccl->st_status,$ccl->st_action,$ccl->st_email,$ccl->st_send_later,$ccl->st_bill_address,$ccl->st_note,$ccl->st_memo,$ccl->st_i_attachment,$ccl->st_balance,$ccl->st_amount_paid,$ccl->st_payment_for,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->st_location,$ccl->st_invoice_type,$ccl->st_invoice_job_order,$ccl->st_invoice_work_no,$ccl->st_debit_account,$ccl->st_credit_account)
                    );
                    echo $ccl->st_no." sales transactrion insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE sales_transaction SET `st_no`=?, `st_date`=?, `st_type`=?, `st_term`=?, `st_customer_id`=?, `st_due_date`=?, `st_status`=?, `st_action`=?, `st_email`=?, `st_send_later`=?, `st_bill_address`=?, `st_note`=?, `st_memo`=?, `st_i_attachment`=?, `st_balance`=?, `st_amount_paid`=?, `st_payment_for`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `created_at`=?, `updated_at`=?,`st_location`=?,`st_invoice_type`=?,`st_invoice_job_order`=?,`st_invoice_work_no`=?,`st_debit_account`=?,`st_credit_account`=? WHERE st_no=? AND st_type=? AND st_location=? AND st_invoice_type=?'),
                            array($ccl->st_no,$ccl->st_date,$ccl->st_type,$ccl->st_term,$ccl->st_customer_id,$ccl->st_due_date,$ccl->st_status,$ccl->st_action,$ccl->st_email,$ccl->st_send_later,$ccl->st_bill_address,$ccl->st_note,$ccl->st_memo,$ccl->st_i_attachment,$ccl->st_balance,$ccl->st_amount_paid,$ccl->st_payment_for,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->st_location,$ccl->st_invoice_type,$ccl->st_invoice_job_order,$ccl->st_invoice_work_no,$ccl->st_debit_account,$ccl->st_credit_account,$ccl->st_no,$ccl->st_type,$ccl->st_location,$ccl->st_invoice_type)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." sales receipt";
                    }
                }

            }
            $table= DB::connection('mysql')->select("SELECT * FROM sales_transaction_edits");
            $table2= DB::connection('mysql3')->select("SELECT * FROM sales_transaction_edits");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_no==$ccl->st_no  && $ccl2->st_type==$ccl->st_type  && $ccl2->st_location==$ccl->st_location && $ccl2->st_invoice_type==$ccl->st_invoice_type){
                        $dup=1;
                        $uid=$ccl2->st_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into sales_transaction_edits (`st_no`, `st_date`, `st_type`, `st_term`, `st_customer_id`, `st_due_date`, `st_status`, `st_action`, `st_email`, `st_send_later`, `st_bill_address`, `st_note`, `st_memo`, `st_i_attachment`, `st_balance`, `st_amount_paid`, `st_payment_for`, `remark`, `cancellation_date`, `cancellation_reason`, `created_at`, `updated_at`,`st_location`,`st_invoice_type`,`st_invoice_job_order`,`st_invoice_work_no`,`st_debit_account`,`st_credit_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_no,$ccl->st_date,$ccl->st_type,$ccl->st_term,$ccl->st_customer_id,$ccl->st_due_date,$ccl->st_status,$ccl->st_action,$ccl->st_email,$ccl->st_send_later,$ccl->st_bill_address,$ccl->st_note,$ccl->st_memo,$ccl->st_i_attachment,$ccl->st_balance,$ccl->st_amount_paid,$ccl->st_payment_for,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->st_location,$ccl->st_invoice_type,$ccl->st_invoice_job_order,$ccl->st_invoice_work_no,$ccl->st_debit_account,$ccl->st_credit_account)
                    );
                    echo $ccl->st_no." sales transactrion insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE sales_transaction_edits SET `st_no`=?, `st_date`=?, `st_type`=?, `st_term`=?, `st_customer_id`=?, `st_due_date`=?, `st_status`=?, `st_action`=?, `st_email`=?, `st_send_later`=?, `st_bill_address`=?, `st_note`=?, `st_memo`=?, `st_i_attachment`=?, `st_balance`=?, `st_amount_paid`=?, `st_payment_for`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `created_at`=?, `updated_at`=?,`st_location`=?,`st_invoice_type`=?,`st_invoice_job_order`=?,`st_invoice_work_no`=?,`st_debit_account`=?,`st_credit_account`=? WHERE st_no=? '),
                            array($ccl->st_no,$ccl->st_date,$ccl->st_type,$ccl->st_term,$ccl->st_customer_id,$ccl->st_due_date,$ccl->st_status,$ccl->st_action,$ccl->st_email,$ccl->st_send_later,$ccl->st_bill_address,$ccl->st_note,$ccl->st_memo,$ccl->st_i_attachment,$ccl->st_balance,$ccl->st_amount_paid,$ccl->st_payment_for,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->st_location,$ccl->st_invoice_type,$ccl->st_invoice_job_order,$ccl->st_invoice_work_no,$ccl->st_debit_account,$ccl->st_credit_account,$ccl->st_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }

            }
        }catch(\Exception $e){

        }
        try{
            $table= DB::connection('mysq3')->select("SELECT * FROM sales_transaction");
            $table2= DB::connection('mysql')->select("SELECT * FROM sales_transaction");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_no==$ccl->st_no && $ccl2->st_type==$ccl->st_type  && $ccl2->st_location==$ccl->st_location && $ccl2->st_invoice_type==$ccl->st_invoice_type ){
                        $dup=1;
                        $uid=$ccl2->st_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into sales_transaction (`st_no`, `st_date`, `st_type`, `st_term`, `st_customer_id`, `st_due_date`, `st_status`, `st_action`, `st_email`, `st_send_later`, `st_bill_address`, `st_note`, `st_memo`, `st_i_attachment`, `st_balance`, `st_amount_paid`, `st_payment_for`, `remark`, `cancellation_date`, `cancellation_reason`, `created_at`, `updated_at`,`st_location`,`st_invoice_type`,`st_invoice_job_order`,`st_invoice_work_no`,`st_debit_account`,`st_credit_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_no,$ccl->st_date,$ccl->st_type,$ccl->st_term,$ccl->st_customer_id,$ccl->st_due_date,$ccl->st_status,$ccl->st_action,$ccl->st_email,$ccl->st_send_later,$ccl->st_bill_address,$ccl->st_note,$ccl->st_memo,$ccl->st_i_attachment,$ccl->st_balance,$ccl->st_amount_paid,$ccl->st_payment_for,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->st_location,$ccl->st_invoice_type,$ccl->st_invoice_job_order,$ccl->st_invoice_work_no,$ccl->st_debit_account,$ccl->st_credit_account)
                    );
                    echo $ccl->st_no." sales transactrion insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE sales_transaction SET `st_no`=?, `st_date`=?, `st_type`=?, `st_term`=?, `st_customer_id`=?, `st_due_date`=?, `st_status`=?, `st_action`=?, `st_email`=?, `st_send_later`=?, `st_bill_address`=?, `st_note`=?, `st_memo`=?, `st_i_attachment`=?, `st_balance`=?, `st_amount_paid`=?, `st_payment_for`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `created_at`=?, `updated_at`=?,`st_location`=?,`st_invoice_type`=?,`st_invoice_job_order`=?,`st_invoice_work_no`=?,`st_debit_account`=?,`st_credit_account`=? WHERE st_no=? AND st_type=? AND st_location=? AND st_invoice_type=?'),
                            array($ccl->st_no,$ccl->st_date,$ccl->st_type,$ccl->st_term,$ccl->st_customer_id,$ccl->st_due_date,$ccl->st_status,$ccl->st_action,$ccl->st_email,$ccl->st_send_later,$ccl->st_bill_address,$ccl->st_note,$ccl->st_memo,$ccl->st_i_attachment,$ccl->st_balance,$ccl->st_amount_paid,$ccl->st_payment_for,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->st_location,$ccl->st_invoice_type,$ccl->st_invoice_job_order,$ccl->st_invoice_work_no,$ccl->st_debit_account,$ccl->st_credit_account,$ccl->st_no,$ccl->st_type,$ccl->st_location,$ccl->st_invoice_type)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." sales receipt";
                    }
                }

            }
            $table= DB::connection('mysql3')->select("SELECT * FROM sales_transaction_edits");
            $table2= DB::connection('mysql')->select("SELECT * FROM sales_transaction_edits");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_no==$ccl->st_no  && $ccl2->st_type==$ccl->st_type  && $ccl2->st_location==$ccl->st_location && $ccl2->st_invoice_type==$ccl->st_invoice_type){
                        $dup=1;
                        $uid=$ccl2->st_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into sales_transaction_edits (`st_no`, `st_date`, `st_type`, `st_term`, `st_customer_id`, `st_due_date`, `st_status`, `st_action`, `st_email`, `st_send_later`, `st_bill_address`, `st_note`, `st_memo`, `st_i_attachment`, `st_balance`, `st_amount_paid`, `st_payment_for`, `remark`, `cancellation_date`, `cancellation_reason`, `created_at`, `updated_at`,`st_location`,`st_invoice_type`,`st_invoice_job_order`,`st_invoice_work_no`,`st_debit_account`,`st_credit_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_no,$ccl->st_date,$ccl->st_type,$ccl->st_term,$ccl->st_customer_id,$ccl->st_due_date,$ccl->st_status,$ccl->st_action,$ccl->st_email,$ccl->st_send_later,$ccl->st_bill_address,$ccl->st_note,$ccl->st_memo,$ccl->st_i_attachment,$ccl->st_balance,$ccl->st_amount_paid,$ccl->st_payment_for,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->st_location,$ccl->st_invoice_type,$ccl->st_invoice_job_order,$ccl->st_invoice_work_no,$ccl->st_debit_account,$ccl->st_credit_account)
                    );
                    echo $ccl->st_no." sales transactrion insert "; 
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE sales_transaction_edits SET `st_no`=?, `st_date`=?, `st_type`=?, `st_term`=?, `st_customer_id`=?, `st_due_date`=?, `st_status`=?, `st_action`=?, `st_email`=?, `st_send_later`=?, `st_bill_address`=?, `st_note`=?, `st_memo`=?, `st_i_attachment`=?, `st_balance`=?, `st_amount_paid`=?, `st_payment_for`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `created_at`=?, `updated_at`=?,`st_location`=?,`st_invoice_type`=?,`st_invoice_job_order`=?,`st_invoice_work_no`=?,`st_debit_account`=?,`st_credit_account`=? WHERE st_no=? '),
                            array($ccl->st_no,$ccl->st_date,$ccl->st_type,$ccl->st_term,$ccl->st_customer_id,$ccl->st_due_date,$ccl->st_status,$ccl->st_action,$ccl->st_email,$ccl->st_send_later,$ccl->st_bill_address,$ccl->st_note,$ccl->st_memo,$ccl->st_i_attachment,$ccl->st_balance,$ccl->st_amount_paid,$ccl->st_payment_for,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->st_location,$ccl->st_invoice_type,$ccl->st_invoice_job_order,$ccl->st_invoice_work_no,$ccl->st_debit_account,$ccl->st_credit_account,$ccl->st_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }

            }
        }catch(\Exception $e){

        }
    }

    public function sync_setting(Request $request){
        
        try{
            $table= DB::connection('mysql')->select("SELECT * FROM settings_advance");
            $table2= DB::connection('mysql3')->select("SELECT * FROM settings_advance");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->id==$ccl->id){
                        $dup=1;
                        $uid=$ccl2->id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into settings_advance (`id`, `setting_id`, `advance_first_month_of_fiscal_year`, `advance_first_month_of_tax_year`, `advance_accounting_method`, `advance_close_book`, `advance_tax_form`, `advance_enable_acc_number`, `advance_track_classes`, `advance_track_location`, `advance_prefill_form`, `advance_apply_credit`, `advance_invoice_unbilled_activity`, `advance_apply_bill_payment`, `advance_add_service_field`, `advance_single_time_activity_billable`, `advance_language`, `advance_home_currency`, `advance_multi_currency`, `advance_date_format`, `advance_number_format`, `advance_dup_cheque_num`, `advance_dup_bill_num`, `advance_inactive_time`,`advance_end_month_of_fiscal_year`,`advance_beginning_balance`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->id,$ccl->setting_id,$ccl->advance_first_month_of_fiscal_year,$ccl->advance_first_month_of_tax_year,$ccl->advance_accounting_method,$ccl->advance_close_book,$ccl->advance_tax_form,$ccl->advance_enable_acc_number,$ccl->advance_track_classes,$ccl->advance_track_location,$ccl->advance_prefill_form,$ccl->advance_apply_credit,$ccl->advance_invoice_unbilled_activity,$ccl->advance_apply_bill_payment,$ccl->advance_add_service_field,$ccl->advance_single_time_activity_billable,$ccl->advance_language,$ccl->advance_home_currency,$ccl->advance_multi_currency,$ccl->advance_date_format,$ccl->advance_number_format,$ccl->advance_dup_cheque_num,$ccl->advance_dup_bill_num,$ccl->advance_inactive_time,$ccl->advance_end_month_of_fiscal_year,$ccl->advance_beginning_balance,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->id." settings_advance insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE settings_advance SET `id`=?, `setting_id`=?, `advance_first_month_of_fiscal_year`=?, `advance_first_month_of_tax_year`=?, `advance_accounting_method`=?, `advance_close_book`=?, `advance_tax_form`=?, `advance_enable_acc_number`=?, `advance_track_classes`=?, `advance_track_location`=?, `advance_prefill_form`=?, `advance_apply_credit`=?, `advance_invoice_unbilled_activity`=?, `advance_apply_bill_payment`=?, `advance_add_service_field`=?, `advance_single_time_activity_billable`=?, `advance_language`=?, `advance_home_currency`=?, `advance_multi_currency`=?, `advance_date_format`=?, `advance_number_format`=?, `advance_dup_cheque_num`=?, `advance_dup_bill_num`=?, `advance_inactive_time`=?,`advance_end_month_of_fiscal_year`=?,`advance_beginning_balance`=?, `created_at`=?, `updated_at`=? WHERE id=? '),
                            array($ccl->id,$ccl->setting_id,$ccl->advance_first_month_of_fiscal_year,$ccl->advance_first_month_of_tax_year,$ccl->advance_accounting_method,$ccl->advance_close_book,$ccl->advance_tax_form,$ccl->advance_enable_acc_number,$ccl->advance_track_classes,$ccl->advance_track_location,$ccl->advance_prefill_form,$ccl->advance_apply_credit,$ccl->advance_invoice_unbilled_activity,$ccl->advance_apply_bill_payment,$ccl->advance_add_service_field,$ccl->advance_single_time_activity_billable,$ccl->advance_language,$ccl->advance_home_currency,$ccl->advance_multi_currency,$ccl->advance_date_format,$ccl->advance_number_format,$ccl->advance_dup_cheque_num,$ccl->advance_dup_bill_num,$ccl->advance_inactive_time,$ccl->advance_end_month_of_fiscal_year,$ccl->advance_beginning_balance,$ccl->created_at,$ccl->updated_at,$ccl->id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }

            }
            $table= DB::connection('mysql')->select("SELECT * FROM settings_company");
            $table2= DB::connection('mysql3')->select("SELECT * FROM settings_company");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->id==$ccl->id){
                        $dup=1;
                        $uid=$ccl2->id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into settings_company (`id`, `setting_id`, `company_name`, `company_legal_name`, `company_business_id_no`, `company_tax_form`, `company_industry`, `company_email`, `company_customer_facing_email`, `company_phone`, `company_website`, `company_address`, `company_customer_facing_address`, `company_legal_address`, `company_address_postal`, `facing_postal`, `legal_postal`, `company_logo`, `company_tin_no`, `esig`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->id,$ccl->setting_id,$ccl->company_name,$ccl->company_legal_name,$ccl->company_business_id_no,$ccl->company_tax_form,$ccl->company_industry,$ccl->company_email,$ccl->company_customer_facing_email,$ccl->company_phone,$ccl->company_website,$ccl->company_address,$ccl->company_customer_facing_address,$ccl->company_legal_address,$ccl->company_address_postal,$ccl->facing_postal,$ccl->legal_postal,$ccl->company_logo,$ccl->company_tin_no,$ccl->esig,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->id." settings_company insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE settings_company SET `id`=?, `setting_id`=?, `company_name`=?, `company_legal_name`=?, `company_business_id_no`=?, `company_tax_form`=?, `company_industry`=?, `company_email`=?, `company_customer_facing_email`=?, `company_phone`=?, `company_website`=?, `company_address`=?, `company_customer_facing_address`=?, `company_legal_address`=?, `company_address_postal`=?, `facing_postal`=?, `legal_postal`=?, `company_logo`=?, `company_tin_no`=?, `esig`=?, `created_at`=?, `updated_at`=? WHERE id=? '),
                            array($ccl->id,$ccl->setting_id,$ccl->company_name,$ccl->company_legal_name,$ccl->company_business_id_no,$ccl->company_tax_form,$ccl->company_industry,$ccl->company_email,$ccl->company_customer_facing_email,$ccl->company_phone,$ccl->company_website,$ccl->company_address,$ccl->company_customer_facing_address,$ccl->company_legal_address,$ccl->company_address_postal,$ccl->facing_postal,$ccl->legal_postal,$ccl->company_logo,$ccl->company_tin_no,$ccl->esig,$ccl->created_at,$ccl->updated_at,$ccl->id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM settings_expenses");
            $table2= DB::connection('mysql3')->select("SELECT * FROM settings_expenses");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->id==$ccl->id){
                        $dup=1;
                        $uid=$ccl2->id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into settings_expenses (`id`, `setting_id`, `expenses_show_items_table`, `expenses_track_expense_and_item_by_customer`, `expenses_billable`, `expenses_bill_payment_terms`, `expenses_use_purchase_order`, `expenses_purchase_order_email_message`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->id,$ccl->setting_id,$ccl->expenses_show_items_table,$ccl->expenses_track_expense_and_item_by_customer,$ccl->expenses_billable,$ccl->expenses_bill_payment_terms,$ccl->expenses_use_purchase_order,$ccl->expenses_purchase_order_email_message,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->id." settings_expenses insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE settings_expenses SET `id`=?, `setting_id`=?, `expenses_show_items_table`=?, `expenses_track_expense_and_item_by_customer`=?, `expenses_billable`=?, `expenses_bill_payment_terms`=?, `expenses_use_purchase_order`=?, `expenses_purchase_order_email_message`=?, `created_at`=?, `updated_at`=? WHERE id=? '),
                            array($ccl->id,$ccl->setting_id,$ccl->expenses_show_items_table,$ccl->expenses_track_expense_and_item_by_customer,$ccl->expenses_billable,$ccl->expenses_bill_payment_terms,$ccl->expenses_use_purchase_order,$ccl->expenses_purchase_order_email_message,$ccl->created_at,$ccl->updated_at,$ccl->id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM settings_sales");
            $table2= DB::connection('mysql3')->select("SELECT * FROM settings_sales");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->id==$ccl->id){
                        $dup=1;
                        $uid=$ccl2->id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into settings_sales (`id`, `setting_id`, `sales_preferred_invoice_term`, `sales_preferred_delivery_method`, `sales_shipping`, `sales_custom_field`, `sales_custom_transaction_number`, `sales_service_date`, `sales_discount`, `sales_deposit`, `sales_show_product_column`, `sales_show_sku_column`, `sales_track_quantity_and_price`, `sales_track_quantity_on_hand`, `sales_form_email_message`, `sales_default_reminder_message`, `sales_email_option`, `sales_show_aging_table`, `created_at`, `updated_at`,`sales_sales_receipt_preferred_debit_cheque_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->id,$ccl->setting_id,$ccl->sales_preferred_invoice_term,$ccl->sales_preferred_delivery_method,$ccl->sales_shipping,$ccl->sales_custom_field,$ccl->sales_custom_transaction_number,$ccl->sales_service_date,$ccl->sales_discount,$ccl->sales_deposit,$ccl->sales_show_product_column,$ccl->sales_show_sku_column,$ccl->sales_track_quantity_and_price,$ccl->sales_track_quantity_on_hand,$ccl->sales_form_email_message,$ccl->sales_default_reminder_message,$ccl->sales_email_option,$ccl->sales_show_aging_table,$ccl->created_at,$ccl->updated_at,$ccl->sales_sales_receipt_preferred_debit_cheque_account)
                    );
                    echo $ccl->id." settings_sales insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE settings_sales SET `id`=?, `setting_id`=?, `sales_preferred_invoice_term`=?, `sales_preferred_delivery_method`=?, `sales_shipping`=?, `sales_custom_field`=?, `sales_custom_transaction_number`=?, `sales_service_date`=?, `sales_discount`=?, `sales_deposit`=?, `sales_show_product_column`=?, `sales_show_sku_column`=?, `sales_track_quantity_and_price`=?, `sales_track_quantity_on_hand`=?, `sales_form_email_message`=?, `sales_default_reminder_message`=?, `sales_email_option`=?, `sales_show_aging_table`=?, `created_at`=?, `updated_at`=? , `sales_sales_receipt_preferred_debit_cheque_account`=? WHERE id=? '),
                            array($ccl->id,$ccl->setting_id,$ccl->sales_preferred_invoice_term,$ccl->sales_preferred_delivery_method,$ccl->sales_shipping,$ccl->sales_custom_field,$ccl->sales_custom_transaction_number,$ccl->sales_service_date,$ccl->sales_discount,$ccl->sales_deposit,$ccl->sales_show_product_column,$ccl->sales_show_sku_column,$ccl->sales_track_quantity_and_price,$ccl->sales_track_quantity_on_hand,$ccl->sales_form_email_message,$ccl->sales_default_reminder_message,$ccl->sales_email_option,$ccl->sales_show_aging_table,$ccl->created_at,$ccl->sales_sales_receipt_preferred_debit_cheque_account,$ccl->updated_at,$ccl->id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
        try{
            $table= DB::connection('mysql3')->select("SELECT * FROM settings_advance");
            $table2= DB::connection('mysql')->select("SELECT * FROM settings_advance");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->id==$ccl->id){
                        $dup=1;
                        $uid=$ccl2->id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into settings_advance (`id`, `setting_id`, `advance_first_month_of_fiscal_year`, `advance_first_month_of_tax_year`, `advance_accounting_method`, `advance_close_book`, `advance_tax_form`, `advance_enable_acc_number`, `advance_track_classes`, `advance_track_location`, `advance_prefill_form`, `advance_apply_credit`, `advance_invoice_unbilled_activity`, `advance_apply_bill_payment`, `advance_add_service_field`, `advance_single_time_activity_billable`, `advance_language`, `advance_home_currency`, `advance_multi_currency`, `advance_date_format`, `advance_number_format`, `advance_dup_cheque_num`, `advance_dup_bill_num`, `advance_inactive_time`,`advance_end_month_of_fiscal_year`,`advance_beginning_balance`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->id,$ccl->setting_id,$ccl->advance_first_month_of_fiscal_year,$ccl->advance_first_month_of_tax_year,$ccl->advance_accounting_method,$ccl->advance_close_book,$ccl->advance_tax_form,$ccl->advance_enable_acc_number,$ccl->advance_track_classes,$ccl->advance_track_location,$ccl->advance_prefill_form,$ccl->advance_apply_credit,$ccl->advance_invoice_unbilled_activity,$ccl->advance_apply_bill_payment,$ccl->advance_add_service_field,$ccl->advance_single_time_activity_billable,$ccl->advance_language,$ccl->advance_home_currency,$ccl->advance_multi_currency,$ccl->advance_date_format,$ccl->advance_number_format,$ccl->advance_dup_cheque_num,$ccl->advance_dup_bill_num,$ccl->advance_inactive_time,$ccl->advance_end_month_of_fiscal_year,$ccl->advance_beginning_balance,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->id." settings_advance insert ";
                }else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE settings_advance SET `id`=?, `setting_id`=?, `advance_first_month_of_fiscal_year`=?, `advance_first_month_of_tax_year`=?, `advance_accounting_method`=?, `advance_close_book`=?, `advance_tax_form`=?, `advance_enable_acc_number`=?, `advance_track_classes`=?, `advance_track_location`=?, `advance_prefill_form`=?, `advance_apply_credit`=?, `advance_invoice_unbilled_activity`=?, `advance_apply_bill_payment`=?, `advance_add_service_field`=?, `advance_single_time_activity_billable`=?, `advance_language`=?, `advance_home_currency`=?, `advance_multi_currency`=?, `advance_date_format`=?, `advance_number_format`=?, `advance_dup_cheque_num`=?, `advance_dup_bill_num`=?, `advance_inactive_time`=?,`advance_end_month_of_fiscal_year`=?,`advance_beginning_balance`=?, `created_at`=?, `updated_at`=? WHERE id=? '),
                            array($ccl->id,$ccl->setting_id,$ccl->advance_first_month_of_fiscal_year,$ccl->advance_first_month_of_tax_year,$ccl->advance_accounting_method,$ccl->advance_close_book,$ccl->advance_tax_form,$ccl->advance_enable_acc_number,$ccl->advance_track_classes,$ccl->advance_track_location,$ccl->advance_prefill_form,$ccl->advance_apply_credit,$ccl->advance_invoice_unbilled_activity,$ccl->advance_apply_bill_payment,$ccl->advance_add_service_field,$ccl->advance_single_time_activity_billable,$ccl->advance_language,$ccl->advance_home_currency,$ccl->advance_multi_currency,$ccl->advance_date_format,$ccl->advance_number_format,$ccl->advance_dup_cheque_num,$ccl->advance_dup_bill_num,$ccl->advance_inactive_time,$ccl->advance_end_month_of_fiscal_year,$ccl->advance_beginning_balance,$ccl->created_at,$ccl->updated_at,$ccl->id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }

            }
            $table= DB::connection('mysql3')->select("SELECT * FROM settings_company");
            $table2= DB::connection('mysql')->select("SELECT * FROM settings_company");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->id==$ccl->id){
                        $dup=1;
                        $uid=$ccl2->id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into settings_company (`id`, `setting_id`, `company_name`, `company_legal_name`, `company_business_id_no`, `company_tax_form`, `company_industry`, `company_email`, `company_customer_facing_email`, `company_phone`, `company_website`, `company_address`, `company_customer_facing_address`, `company_legal_address`, `company_address_postal`, `facing_postal`, `legal_postal`, `company_logo`, `company_tin_no`, `esig`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->id,$ccl->setting_id,$ccl->company_name,$ccl->company_legal_name,$ccl->company_business_id_no,$ccl->company_tax_form,$ccl->company_industry,$ccl->company_email,$ccl->company_customer_facing_email,$ccl->company_phone,$ccl->company_website,$ccl->company_address,$ccl->company_customer_facing_address,$ccl->company_legal_address,$ccl->company_address_postal,$ccl->facing_postal,$ccl->legal_postal,$ccl->company_logo,$ccl->company_tin_no,$ccl->esig,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->id." settings_company insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE settings_company SET `id`=?, `setting_id`=?, `company_name`=?, `company_legal_name`=?, `company_business_id_no`=?, `company_tax_form`=?, `company_industry`=?, `company_email`=?, `company_customer_facing_email`=?, `company_phone`=?, `company_website`=?, `company_address`=?, `company_customer_facing_address`=?, `company_legal_address`=?, `company_address_postal`=?, `facing_postal`=?, `legal_postal`=?, `company_logo`=?, `company_tin_no`=?, `esig`=?, `created_at`=?, `updated_at`=? WHERE id=? '),
                            array($ccl->id,$ccl->setting_id,$ccl->company_name,$ccl->company_legal_name,$ccl->company_business_id_no,$ccl->company_tax_form,$ccl->company_industry,$ccl->company_email,$ccl->company_customer_facing_email,$ccl->company_phone,$ccl->company_website,$ccl->company_address,$ccl->company_customer_facing_address,$ccl->company_legal_address,$ccl->company_address_postal,$ccl->facing_postal,$ccl->legal_postal,$ccl->company_logo,$ccl->company_tin_no,$ccl->esig,$ccl->created_at,$ccl->updated_at,$ccl->id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM settings_expenses");
            $table2= DB::connection('mysql')->select("SELECT * FROM settings_expenses");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->id==$ccl->id){
                        $dup=1;
                        $uid=$ccl2->id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into settings_expenses (`id`, `setting_id`, `expenses_show_items_table`, `expenses_track_expense_and_item_by_customer`, `expenses_billable`, `expenses_bill_payment_terms`, `expenses_use_purchase_order`, `expenses_purchase_order_email_message`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->id,$ccl->setting_id,$ccl->expenses_show_items_table,$ccl->expenses_track_expense_and_item_by_customer,$ccl->expenses_billable,$ccl->expenses_bill_payment_terms,$ccl->expenses_use_purchase_order,$ccl->expenses_purchase_order_email_message,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->id." settings_expenses insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE settings_expenses SET `id`=?, `setting_id`=?, `expenses_show_items_table`=?, `expenses_track_expense_and_item_by_customer`=?, `expenses_billable`=?, `expenses_bill_payment_terms`=?, `expenses_use_purchase_order`=?, `expenses_purchase_order_email_message`=?, `created_at`=?, `updated_at`=? WHERE id=? '),
                            array($ccl->id,$ccl->setting_id,$ccl->expenses_show_items_table,$ccl->expenses_track_expense_and_item_by_customer,$ccl->expenses_billable,$ccl->expenses_bill_payment_terms,$ccl->expenses_use_purchase_order,$ccl->expenses_purchase_order_email_message,$ccl->created_at,$ccl->updated_at,$ccl->id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM settings_sales");
            $table2= DB::connection('mysql')->select("SELECT * FROM settings_sales");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->id==$ccl->id){
                        $dup=1;
                        $uid=$ccl2->id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into settings_sales (`id`, `setting_id`, `sales_preferred_invoice_term`, `sales_preferred_delivery_method`, `sales_shipping`, `sales_custom_field`, `sales_custom_transaction_number`, `sales_service_date`, `sales_discount`, `sales_deposit`, `sales_show_product_column`, `sales_show_sku_column`, `sales_track_quantity_and_price`, `sales_track_quantity_on_hand`, `sales_form_email_message`, `sales_default_reminder_message`, `sales_email_option`, `sales_show_aging_table`, `created_at`, `updated_at`,`sales_sales_receipt_preferred_debit_cheque_account`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->id,$ccl->setting_id,$ccl->sales_preferred_invoice_term,$ccl->sales_preferred_delivery_method,$ccl->sales_shipping,$ccl->sales_custom_field,$ccl->sales_custom_transaction_number,$ccl->sales_service_date,$ccl->sales_discount,$ccl->sales_deposit,$ccl->sales_show_product_column,$ccl->sales_show_sku_column,$ccl->sales_track_quantity_and_price,$ccl->sales_track_quantity_on_hand,$ccl->sales_form_email_message,$ccl->sales_default_reminder_message,$ccl->sales_email_option,$ccl->sales_show_aging_table,$ccl->created_at,$ccl->updated_at,$ccl->sales_sales_receipt_preferred_debit_cheque_account)
                    );
                    echo $ccl->id." settings_sales insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE settings_sales SET `id`=?, `setting_id`=?, `sales_preferred_invoice_term`=?, `sales_preferred_delivery_method`=?, `sales_shipping`=?, `sales_custom_field`=?, `sales_custom_transaction_number`=?, `sales_service_date`=?, `sales_discount`=?, `sales_deposit`=?, `sales_show_product_column`=?, `sales_show_sku_column`=?, `sales_track_quantity_and_price`=?, `sales_track_quantity_on_hand`=?, `sales_form_email_message`=?, `sales_default_reminder_message`=?, `sales_email_option`=?, `sales_show_aging_table`=?, `created_at`=?, `updated_at`=? , `sales_sales_receipt_preferred_debit_cheque_account`=? WHERE id=? '),
                            array($ccl->id,$ccl->setting_id,$ccl->sales_preferred_invoice_term,$ccl->sales_preferred_delivery_method,$ccl->sales_shipping,$ccl->sales_custom_field,$ccl->sales_custom_transaction_number,$ccl->sales_service_date,$ccl->sales_discount,$ccl->sales_deposit,$ccl->sales_show_product_column,$ccl->sales_show_sku_column,$ccl->sales_track_quantity_and_price,$ccl->sales_track_quantity_on_hand,$ccl->sales_form_email_message,$ccl->sales_default_reminder_message,$ccl->sales_email_option,$ccl->sales_show_aging_table,$ccl->created_at,$ccl->sales_sales_receipt_preferred_debit_cheque_account,$ccl->updated_at,$ccl->id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
    }


    public function sync_st(Request $request){
        
        try{
            $table= DB::connection('mysql')->select("SELECT * FROM st_credit_notes");
            $table2= DB::connection('mysql3')->select("SELECT * FROM st_credit_notes");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_cn_id==$ccl->st_cn_id){
                        $dup=1;
                        $uid=$ccl2->st_cn_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into st_credit_notes (`st_cn_id`, `st_cn_no`, `st_cn_product`, `st_cn_desc`, `st_cn_qty`, `st_cn_rate`, `st_cn_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_cn_id,$ccl->st_cn_no,$ccl->st_cn_product,$ccl->st_cn_desc,$ccl->st_cn_qty,$ccl->st_cn_rate,$ccl->st_cn_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_cn_id." st_credit_notes insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE st_credit_notes SET `st_cn_id`=?, `st_cn_no`=?, `st_cn_product`=?, `st_cn_desc`=?, `st_cn_qty`=?, `st_cn_rate`=?, `st_cn_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_cn_id=? '),
                            array($ccl->st_cn_id,$ccl->st_cn_no,$ccl->st_cn_product,$ccl->st_cn_desc,$ccl->st_cn_qty,$ccl->st_cn_rate,$ccl->st_cn_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_cn_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM st_credit_notes_edits");
            $table2= DB::connection('mysql3')->select("SELECT * FROM st_credit_notes_edits");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_cn_id==$ccl->st_cn_id){
                        $dup=1;
                        $uid=$ccl2->st_cn_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into st_credit_notes_edits (`st_cn_id`, `st_cn_no`, `st_cn_product`, `st_cn_desc`, `st_cn_qty`, `st_cn_rate`, `st_cn_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`,`edit_status`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_cn_id,$ccl->st_cn_no,$ccl->st_cn_product,$ccl->st_cn_desc,$ccl->st_cn_qty,$ccl->st_cn_rate,$ccl->st_cn_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->edit_status)
                    );
                    echo $ccl->st_cn_id." st_credit_notes_edits insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE st_credit_notes_edits SET `st_cn_id`=?, `st_cn_no`=?, `st_cn_product`=?, `st_cn_desc`=?, `st_cn_qty`=?, `st_cn_rate`=?, `st_cn_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? ,`edit_status`=? WHERE st_cn_id=? '),
                            array($ccl->st_cn_id,$ccl->st_cn_no,$ccl->st_cn_product,$ccl->st_cn_desc,$ccl->st_cn_qty,$ccl->st_cn_rate,$ccl->st_cn_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->edit_status,$ccl->st_cn_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM st_delayed_charges");
            $table2= DB::connection('mysql3')->select("SELECT * FROM st_delayed_charges");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_dc_id==$ccl->st_dc_id){
                        $dup=1;
                        $uid=$ccl2->st_dc_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into st_delayed_charges (`st_dc_id`, `st_dc_no`, `st_dc_product`, `st_dc_desc`, `st_dc_qty`, `st_dc_rate`, `st_dc_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_dc_id,$ccl->st_dc_no,$ccl->st_dc_product,$ccl->st_dc_desc,$ccl->st_dc_qty,$ccl->st_dc_rate,$ccl->st_dc_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_dc_id." st_delayed_charges insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE st_delayed_charges SET `st_dc_id`=?, `st_dc_no`=?, `st_dc_product`=?, `st_dc_desc`=?, `st_dc_qty`=?, `st_dc_rate`=?, `st_dc_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_dc_id=? '),
                            array($ccl->st_dc_id,$ccl->st_dc_no,$ccl->st_dc_product,$ccl->st_dc_desc,$ccl->st_dc_qty,$ccl->st_dc_rate,$ccl->st_dc_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_dc_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM st_delayed_credits");
            $table2= DB::connection('mysql3')->select("SELECT * FROM st_delayed_credits");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_dcredit_id==$ccl->st_dcredit_id){
                        $dup=1;
                        $uid=$ccl2->st_dcredit_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into st_delayed_credits (`st_dcredit_id`, `st_dcredit_no`, `st_dcredit_product`, `st_dcredit_desc`, `st_dcredit_qty`, `st_dcredit_rate`, `st_dcredit_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_dcredit_id,$ccl->st_dcredit_no,$ccl->st_dcredit_product,$ccl->st_dcredit_desc,$ccl->st_dcredit_qty,$ccl->st_dcredit_rate,$ccl->st_dcredit_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_dcredit_id." st_delayed_credits insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE st_delayed_credits SET `st_dcredit_id`=?, `st_dcredit_no`=?, `st_dcredit_product`=?, `st_dcredit_desc`=?, `st_dcredit_qty`=?, `st_dcredit_rate`=?, `st_dcredit_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_dcredit_id=? '),
                            array($ccl->st_dcredit_id,$ccl->st_dcredit_no,$ccl->st_dcredit_product,$ccl->st_dcredit_desc,$ccl->st_dcredit_qty,$ccl->st_dcredit_rate,$ccl->st_dcredit_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_dcredit_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

            $table= DB::connection('mysql')->select("SELECT * FROM st_estimates");
            $table2= DB::connection('mysql3')->select("SELECT * FROM st_estimates");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_e_id==$ccl->st_e_id){
                        $dup=1;
                        $uid=$ccl2->st_e_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into st_estimates (`st_e_id`, `st_e_no`, `st_e_product`, `st_e_desc`, `st_e_qty`, `st_e_rate`, `st_e_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_e_id,$ccl->st_e_no,$ccl->st_e_product,$ccl->st_e_desc,$ccl->st_e_qty,$ccl->st_e_rate,$ccl->st_e_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_e_id." st_estimates insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE st_estimates SET `st_e_id`=?, `st_e_no`=?, `st_e_product`=?, `st_e_desc`=?, `st_e_qty`=?, `st_e_rate`=?, `st_e_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_e_id=? '),
                            array($ccl->st_e_id,$ccl->st_e_no,$ccl->st_e_product,$ccl->st_e_desc,$ccl->st_e_qty,$ccl->st_e_rate,$ccl->st_e_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_e_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM st_invoice");
            $table2= DB::connection('mysql3')->select("SELECT * FROM st_invoice");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_i_item_no==$ccl->st_i_item_no && $ccl2->st_i_no==$ccl->st_i_no && $ccl2->st_p_location==$ccl->st_p_location && $ccl2->st_p_invoice_type==$ccl->st_p_invoice_type){
                        $dup=1;
                        $uid=$ccl2->st_i_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into st_invoice (`st_i_id`,`st_i_item_no`, `st_i_no`, `st_i_product`, `st_i_desc`, `st_i_qty`, `st_i_rate`, `st_i_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`,`st_p_location`,`st_p_invoice_type`,`st_p_cost_center`,`st_p_debit`,`st_p_credit`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_i_id,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_i_product,$ccl->st_i_desc,$ccl->st_i_qty,$ccl->st_i_rate,$ccl->st_i_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->st_p_cost_center,$ccl->st_p_debit,$ccl->st_p_credit)
                    );
                    echo $ccl->st_i_id." st_invoice insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE st_invoice SET `st_i_id`=?,`st_i_item_no`=?, `st_i_no`=?, `st_i_product`=?, `st_i_desc`=?, `st_i_qty`=?, `st_i_rate`=?, `st_i_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=?, `st_p_location`=?,`st_p_invoice_type`=?,`st_p_cost_center`=?,`st_p_debit`=?,`st_p_credit`=? WHERE st_i_item_no=? AND  st_i_no=? AND `st_p_location`=? AND `st_p_invoice_type`=?'),
                            array($ccl->st_i_id,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_i_product,$ccl->st_i_desc,$ccl->st_i_qty,$ccl->st_i_rate,$ccl->st_i_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->st_p_cost_center,$ccl->st_p_debit,$ccl->st_p_credit,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_p_location,$ccl->st_p_invoice_type)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." st_invoice";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM st_invoice_edit");
            $table2= DB::connection('mysql3')->select("SELECT * FROM st_invoice_edit");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_i_item_no==$ccl->st_i_item_no && $ccl2->st_i_no==$ccl->st_i_no && $ccl2->st_p_location==$ccl->st_p_location && $ccl2->st_p_invoice_type==$ccl->st_p_invoice_type && $ccl2->created_at==$ccl->created_at){
                        $dup=1;
                        $uid=$ccl2->st_i_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into st_invoice_edit (`st_i_id`, `st_i_no`, `st_i_product`, `st_i_desc`, `st_i_qty`, `st_i_rate`, `st_i_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`,`st_p_location`,`st_p_invoice_type`,`st_p_cost_center`,`edit_status`,`st_p_debit`,`st_p_credit`,`st_i_item_no`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_i_id,$ccl->st_i_no,$ccl->st_i_product,$ccl->st_i_desc,$ccl->st_i_qty,$ccl->st_i_rate,$ccl->st_i_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->st_p_cost_center,$ccl->edit_status,$ccl->st_p_debit,$ccl->st_p_credit,$ccl->st_i_item_no)
                    );
                    echo $ccl->st_i_id." st_invoice_edit insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<=strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE st_invoice_edit SET `st_i_id`=?,`st_i_item_no`=?, `st_i_no`=?, `st_i_product`=?, `st_i_desc`=?, `st_i_qty`=?, `st_i_rate`=?, `st_i_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=?, `st_p_location`=?,`st_p_invoice_type`=?,`st_p_cost_center`=?,`st_p_debit`=?,`st_p_credit`=?,`edit_status`=? WHERE st_i_item_no=? AND  st_i_no=? AND `st_p_location`=? AND `st_p_invoice_type`=? AND `created_at`=? '),
                            array($ccl->st_i_id,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_i_product,$ccl->st_i_desc,$ccl->st_i_qty,$ccl->st_i_rate,$ccl->st_i_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->st_p_cost_center,$ccl->st_p_debit,$ccl->st_p_credit,$ccl->edit_status,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->created_at)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." st_invoice edit";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM st_refund_receipts");
            $table2= DB::connection('mysql3')->select("SELECT * FROM st_refund_receipts");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_r_id==$ccl->st_r_id){
                        $dup=1;
                        $uid=$ccl2->st_r_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into st_refund_receipts (`st_r_id`, `st_r_no`, `st_r_product`, `st_r_desc`, `st_r_qty`, `st_r_rate`, `st_r_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_r_id,$ccl->st_r_no,$ccl->st_r_product,$ccl->st_r_desc,$ccl->st_r_qty,$ccl->st_r_rate,$ccl->st_r_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_r_id." st_refund_receipts insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE st_refund_receipts SET `st_r_id`=?, `st_r_no`=?, `st_r_product`=?, `st_r_desc`=?, `st_r_qty`=?, `st_r_rate`=?, `st_r_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_r_id=? '),
                            array($ccl->st_r_id,$ccl->st_r_no,$ccl->st_r_product,$ccl->st_r_desc,$ccl->st_r_qty,$ccl->st_r_rate,$ccl->st_r_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_r_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM st_sales_receipts");
            $table2= DB::connection('mysql3')->select("SELECT * FROM st_sales_receipts");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_s_id==$ccl->st_s_id){
                        $dup=1;
                        $uid=$ccl2->st_s_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into st_sales_receipts (`st_s_id`, `st_s_no`, `st_s_product`, `st_s_desc`, `st_s_qty`, `st_s_rate`, `st_s_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`,`invoice_no_link`, `created_at`, `updated_at`,`st_s_locaiton`,`st_s_invoice_type`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_s_id,$ccl->st_s_no,$ccl->st_s_product,$ccl->st_s_desc,$ccl->st_s_qty,$ccl->st_s_rate,$ccl->st_s_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->invoice_no_link,$ccl->created_at,$ccl->updated_at,$ccl->st_s_locaiton,$ccl->st_s_invoice_type)
                    );
                    echo $ccl->st_s_id." st_sales_receipts insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE st_sales_receipts SET `st_s_id`=?, `st_s_no`=?, `st_s_product`=?, `st_s_desc`=?, `st_s_qty`=?, `st_s_rate`=?, `st_s_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?,`invoice_no_link=?`, `created_at`=?, `updated_at`=? ,`st_s_locaiton`=?,`st_s_invoice_type`=? WHERE st_s_id=? '),
                            array($ccl->st_s_id,$ccl->st_s_no,$ccl->st_s_product,$ccl->st_s_desc,$ccl->st_s_qty,$ccl->st_s_rate,$ccl->st_s_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->invoice_no_link,$ccl->created_at,$ccl->updated_at,$ccl->st_s_locaiton,$ccl->st_s_invoice_type,$ccl->st_s_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
        try{
            $table= DB::connection('mysql3')->select("SELECT * FROM st_credit_notes");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_credit_notes");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_cn_id==$ccl->st_cn_id){
                        $dup=1;
                        $uid=$ccl2->st_cn_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_credit_notes (`st_cn_id`, `st_cn_no`, `st_cn_product`, `st_cn_desc`, `st_cn_qty`, `st_cn_rate`, `st_cn_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_cn_id,$ccl->st_cn_no,$ccl->st_cn_product,$ccl->st_cn_desc,$ccl->st_cn_qty,$ccl->st_cn_rate,$ccl->st_cn_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_cn_id." st_credit_notes insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_credit_notes SET `st_cn_id`=?, `st_cn_no`=?, `st_cn_product`=?, `st_cn_desc`=?, `st_cn_qty`=?, `st_cn_rate`=?, `st_cn_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_cn_id=? '),
                            array($ccl->st_cn_id,$ccl->st_cn_no,$ccl->st_cn_product,$ccl->st_cn_desc,$ccl->st_cn_qty,$ccl->st_cn_rate,$ccl->st_cn_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_cn_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_credit_notes_edits");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_credit_notes_edits");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_cn_id==$ccl->st_cn_id){
                        $dup=1;
                        $uid=$ccl2->st_cn_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_credit_notes_edits (`st_cn_id`, `st_cn_no`, `st_cn_product`, `st_cn_desc`, `st_cn_qty`, `st_cn_rate`, `st_cn_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`,`edit_status`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_cn_id,$ccl->st_cn_no,$ccl->st_cn_product,$ccl->st_cn_desc,$ccl->st_cn_qty,$ccl->st_cn_rate,$ccl->st_cn_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->edit_status)
                    );
                    echo $ccl->st_cn_id." st_credit_notes_edits insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_credit_notes_edits SET `st_cn_id`=?, `st_cn_no`=?, `st_cn_product`=?, `st_cn_desc`=?, `st_cn_qty`=?, `st_cn_rate`=?, `st_cn_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? ,`edit_status`=? WHERE st_cn_id=? '),
                            array($ccl->st_cn_id,$ccl->st_cn_no,$ccl->st_cn_product,$ccl->st_cn_desc,$ccl->st_cn_qty,$ccl->st_cn_rate,$ccl->st_cn_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->edit_status,$ccl->st_cn_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_delayed_charges");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_delayed_charges");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_dc_id==$ccl->st_dc_id){
                        $dup=1;
                        $uid=$ccl2->st_dc_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_delayed_charges (`st_dc_id`, `st_dc_no`, `st_dc_product`, `st_dc_desc`, `st_dc_qty`, `st_dc_rate`, `st_dc_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_dc_id,$ccl->st_dc_no,$ccl->st_dc_product,$ccl->st_dc_desc,$ccl->st_dc_qty,$ccl->st_dc_rate,$ccl->st_dc_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_dc_id." st_delayed_charges insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_delayed_charges SET `st_dc_id`=?, `st_dc_no`=?, `st_dc_product`=?, `st_dc_desc`=?, `st_dc_qty`=?, `st_dc_rate`=?, `st_dc_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_dc_id=? '),
                            array($ccl->st_dc_id,$ccl->st_dc_no,$ccl->st_dc_product,$ccl->st_dc_desc,$ccl->st_dc_qty,$ccl->st_dc_rate,$ccl->st_dc_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_dc_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_delayed_credits");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_delayed_credits");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_dcredit_id==$ccl->st_dcredit_id){
                        $dup=1;
                        $uid=$ccl2->st_dcredit_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_delayed_credits (`st_dcredit_id`, `st_dcredit_no`, `st_dcredit_product`, `st_dcredit_desc`, `st_dcredit_qty`, `st_dcredit_rate`, `st_dcredit_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_dcredit_id,$ccl->st_dcredit_no,$ccl->st_dcredit_product,$ccl->st_dcredit_desc,$ccl->st_dcredit_qty,$ccl->st_dcredit_rate,$ccl->st_dcredit_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_dcredit_id." st_delayed_credits insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_delayed_credits SET `st_dcredit_id`=?, `st_dcredit_no`=?, `st_dcredit_product`=?, `st_dcredit_desc`=?, `st_dcredit_qty`=?, `st_dcredit_rate`=?, `st_dcredit_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_dcredit_id=? '),
                            array($ccl->st_dcredit_id,$ccl->st_dcredit_no,$ccl->st_dcredit_product,$ccl->st_dcredit_desc,$ccl->st_dcredit_qty,$ccl->st_dcredit_rate,$ccl->st_dcredit_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_dcredit_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

            $table= DB::connection('mysql3')->select("SELECT * FROM st_estimates");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_estimates");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_e_id==$ccl->st_e_id){
                        $dup=1;
                        $uid=$ccl2->st_e_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_estimates (`st_e_id`, `st_e_no`, `st_e_product`, `st_e_desc`, `st_e_qty`, `st_e_rate`, `st_e_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_e_id,$ccl->st_e_no,$ccl->st_e_product,$ccl->st_e_desc,$ccl->st_e_qty,$ccl->st_e_rate,$ccl->st_e_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_e_id." st_estimates insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_estimates SET `st_e_id`=?, `st_e_no`=?, `st_e_product`=?, `st_e_desc`=?, `st_e_qty`=?, `st_e_rate`=?, `st_e_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_e_id=? '),
                            array($ccl->st_e_id,$ccl->st_e_no,$ccl->st_e_product,$ccl->st_e_desc,$ccl->st_e_qty,$ccl->st_e_rate,$ccl->st_e_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_e_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_invoice");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_invoice");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_i_item_no==$ccl->st_i_item_no && $ccl2->st_i_no==$ccl->st_i_no && $ccl2->st_p_location==$ccl->st_p_location && $ccl2->st_p_invoice_type==$ccl->st_p_invoice_type){
                        $dup=1;
                        $uid=$ccl2->st_i_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_invoice (`st_i_id`,`st_i_item_no`, `st_i_no`, `st_i_product`, `st_i_desc`, `st_i_qty`, `st_i_rate`, `st_i_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`,`st_p_location`,`st_p_invoice_type`,`st_p_cost_center`,`st_p_debit`,`st_p_credit`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_i_id,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_i_product,$ccl->st_i_desc,$ccl->st_i_qty,$ccl->st_i_rate,$ccl->st_i_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->st_p_cost_center,$ccl->st_p_debit,$ccl->st_p_credit)
                    );
                    echo $ccl->st_i_id." st_invoice insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_invoice SET `st_i_id`=?,`st_i_item_no`=?, `st_i_no`=?, `st_i_product`=?, `st_i_desc`=?, `st_i_qty`=?, `st_i_rate`=?, `st_i_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=?, `st_p_location`=?,`st_p_invoice_type`=?,`st_p_cost_center`=?,`st_p_debit`=?,`st_p_credit`=? WHERE st_i_item_no=? AND  st_i_no=? AND `st_p_location`=? AND `st_p_invoice_type`=?'),
                            array($ccl->st_i_id,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_i_product,$ccl->st_i_desc,$ccl->st_i_qty,$ccl->st_i_rate,$ccl->st_i_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->st_p_cost_center,$ccl->st_p_debit,$ccl->st_p_credit,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_p_location,$ccl->st_p_invoice_type)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." st_invoice";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_invoice_edit");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_invoice_edit");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_i_item_no==$ccl->st_i_item_no && $ccl2->st_i_no==$ccl->st_i_no && $ccl2->st_p_location==$ccl->st_p_location && $ccl2->st_p_invoice_type==$ccl->st_p_invoice_type && $ccl2->created_at==$ccl->created_at){
                        $dup=1;
                        $uid=$ccl2->st_i_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    }
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_invoice_edit (`st_i_id`, `st_i_no`, `st_i_product`, `st_i_desc`, `st_i_qty`, `st_i_rate`, `st_i_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`,`st_p_location`,`st_p_invoice_type`,`st_p_cost_center`,`edit_status`,`st_p_debit`,`st_p_credit`,`st_i_item_no`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_i_id,$ccl->st_i_no,$ccl->st_i_product,$ccl->st_i_desc,$ccl->st_i_qty,$ccl->st_i_rate,$ccl->st_i_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->st_p_cost_center,$ccl->edit_status,$ccl->st_p_debit,$ccl->st_p_credit,$ccl->st_i_item_no)
                    );
                    echo $ccl->st_i_id." st_invoice_edit insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<=strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_invoice_edit SET `st_i_id`=?,`st_i_item_no`=?, `st_i_no`=?, `st_i_product`=?, `st_i_desc`=?, `st_i_qty`=?, `st_i_rate`=?, `st_i_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=?, `st_p_location`=?,`st_p_invoice_type`=?,`st_p_cost_center`=?,`st_p_debit`=?,`st_p_credit`=?,`edit_status`=? WHERE st_i_item_no=? AND  st_i_no=? AND `st_p_location`=? AND `st_p_invoice_type`=? AND `created_at`=? '),
                            array($ccl->st_i_id,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_i_product,$ccl->st_i_desc,$ccl->st_i_qty,$ccl->st_i_rate,$ccl->st_i_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->st_p_cost_center,$ccl->st_p_debit,$ccl->st_p_credit,$ccl->edit_status,$ccl->st_i_item_no,$ccl->st_i_no,$ccl->st_p_location,$ccl->st_p_invoice_type,$ccl->created_at)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." st_invoice edit";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_refund_receipts");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_refund_receipts");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_r_id==$ccl->st_r_id){
                        $dup=1;
                        $uid=$ccl2->st_r_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_refund_receipts (`st_r_id`, `st_r_no`, `st_r_product`, `st_r_desc`, `st_r_qty`, `st_r_rate`, `st_r_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_r_id,$ccl->st_r_no,$ccl->st_r_product,$ccl->st_r_desc,$ccl->st_r_qty,$ccl->st_r_rate,$ccl->st_r_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->st_r_id." st_refund_receipts insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_refund_receipts SET `st_r_id`=?, `st_r_no`=?, `st_r_product`=?, `st_r_desc`=?, `st_r_qty`=?, `st_r_rate`=?, `st_r_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?, `created_at`=?, `updated_at`=? WHERE st_r_id=? '),
                            array($ccl->st_r_id,$ccl->st_r_no,$ccl->st_r_product,$ccl->st_r_desc,$ccl->st_r_qty,$ccl->st_r_rate,$ccl->st_r_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->created_at,$ccl->updated_at,$ccl->st_r_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM st_sales_receipts");
            $table2= DB::connection('mysql')->select("SELECT * FROM st_sales_receipts");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->st_s_id==$ccl->st_s_id){
                        $dup=1;
                        $uid=$ccl2->st_s_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into st_sales_receipts (`st_s_id`, `st_s_no`, `st_s_product`, `st_s_desc`, `st_s_qty`, `st_s_rate`, `st_s_total`, `st_p_method`, `st_p_reference_no`, `st_p_deposit_to`, `st_p_amount`,`invoice_no_link`, `created_at`, `updated_at`,`st_s_locaiton`,`st_s_invoice_type`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->st_s_id,$ccl->st_s_no,$ccl->st_s_product,$ccl->st_s_desc,$ccl->st_s_qty,$ccl->st_s_rate,$ccl->st_s_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->invoice_no_link,$ccl->created_at,$ccl->updated_at,$ccl->st_s_locaiton,$ccl->st_s_invoice_type)
                    );
                    echo $ccl->st_s_id." st_sales_receipts insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE st_sales_receipts SET `st_s_id`=?, `st_s_no`=?, `st_s_product`=?, `st_s_desc`=?, `st_s_qty`=?, `st_s_rate`=?, `st_s_total`=?, `st_p_method`=?, `st_p_reference_no`=?, `st_p_deposit_to`=?, `st_p_amount`=?,`invoice_no_link=?`, `created_at`=?, `updated_at`=? ,`st_s_locaiton`=?,`st_s_invoice_type`=? WHERE st_s_id=? '),
                            array($ccl->st_s_id,$ccl->st_s_no,$ccl->st_s_product,$ccl->st_s_desc,$ccl->st_s_qty,$ccl->st_s_rate,$ccl->st_s_total,$ccl->st_p_method,$ccl->st_p_reference_no,$ccl->st_p_deposit_to,$ccl->st_p_amount,$ccl->invoice_no_link,$ccl->created_at,$ccl->updated_at,$ccl->st_s_locaiton,$ccl->st_s_invoice_type,$ccl->st_s_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
    }

    public function sync_user(Request $request){
        
        try{
            $table= DB::connection('mysql')->select("SELECT * FROM users");
            $table2= DB::connection('mysql3')->select("SELECT * FROM users");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->email==$ccl->email){
                        $dup=1;
                        $uid=$ccl2->email;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into users (`name`, `email`, `position`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`,`approved_status`) values (?,?,?,?,?,?,?,?,?)'),
                        array($ccl->name,$ccl->email,$ccl->position,$ccl->email_verified_at,$ccl->password,$ccl->remember_token,$ccl->created_at,$ccl->updated_at,$ccl->approved_status)
                    );
                    echo $ccl->email." users insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE users SET `id`=?, `name`=?, `email`=?, `position`=?, `email_verified_at`=?, `password`=?, `remember_token`=?, `created_at`=?, `updated_at`=? ,`approved_status`=? WHERE email=? '),
                            array($ccl->id,$ccl->name,$ccl->email,$ccl->position,$ccl->email_verified_at,$ccl->password,$ccl->remember_token,$ccl->created_at,$ccl->updated_at,$ccl->approved_status,$ccl->email)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM users_access_restrictions");
            $table2= DB::connection('mysql3')->select("SELECT * FROM users_access_restrictions");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->user_id==$ccl->user_id){
                        $dup=1;
                        $uid=$ccl2->user_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into users_access_restrictions (`user_id`, `approvals`, `journal_entry`, `sales`, `invoice`, `estimate`, `credit_note`, `sales_receipt`, `expense`, `bill`, `supplier_credit`, `pay_bills`, `reports`, `fund_feeds`, `chart_of_accounts`, `cost_center`, `settings`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->user_id,$ccl->approvals,$ccl->journal_entry,$ccl->sales,$ccl->invoice,$ccl->estimate,$ccl->credit_note,$ccl->sales_receipt,$ccl->expense,$ccl->bill,$ccl->supplier_credit,$ccl->pay_bills,$ccl->reports,$ccl->fund_feeds,$ccl->chart_of_accounts,$ccl->cost_center,$ccl->settings,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->user_id." users_access_restrictions insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE users_access_restrictions SET `user_id`=?, `approvals`=?, `journal_entry`=?, `sales`=?, `invoice`=?, `estimate`=?, `credit_note`=?, `sales_receipt`=?, `expense`=?, `bill`=?, `supplier_credit`=?, `pay_bills`=?, `reports`=?, `fund_feeds`=?, `chart_of_accounts`=?, `cost_center`=?, `settings`=?, `created_at`=?, `updated_at`=? WHERE `user_id`=? '),
                            array($ccl->user_id,$ccl->approvals,$ccl->journal_entry,$ccl->sales,$ccl->invoice,$ccl->estimate,$ccl->credit_note,$ccl->sales_receipt,$ccl->expense,$ccl->bill,$ccl->supplier_credit,$ccl->pay_bills,$ccl->reports,$ccl->fund_feeds,$ccl->chart_of_accounts,$ccl->cost_center,$ccl->settings,$ccl->created_at,$ccl->updated_at,$ccl->user_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM user_cost_center_access");
            $table2= DB::connection('mysql3')->select("SELECT * FROM user_cost_center_access");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->use_id==$ccl->use_id && $ccl2->cost_center_id==$ccl->cost_center_id){
                        $dup=1;
                        $uid=$ccl2->use_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into user_cost_center_access (`use_id`, `cost_center_id`, `access_status`, `created_at`, `updated_at`) values (?,?,?,?,?)'),
                        array($ccl->use_id,$ccl->cost_center_id,$ccl->access_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->use_id." user_cost_center_access insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE user_cost_center_access SET `use_id`=?, `cost_center_id`=?, `access_status`=?, `created_at`=?, `updated_at`=? WHERE `use_id`=? AND cost_center_id=? '),
                            array($ccl->use_id,$ccl->cost_center_id,$ccl->access_status,$ccl->created_at,$ccl->updated_at,$ccl->use_id,$ccl->cost_center_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
        try{
            $table= DB::connection('mysql3')->select("SELECT * FROM users");
            $table2= DB::connection('mysql')->select("SELECT * FROM users");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->email==$ccl->email){
                        $dup=1;
                        $uid=$ccl2->email;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into users (`name`, `email`, `position`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`,`approved_status`) values (?,?,?,?,?,?,?,?,?)'),
                        array($ccl->name,$ccl->email,$ccl->position,$ccl->email_verified_at,$ccl->password,$ccl->remember_token,$ccl->created_at,$ccl->updated_at,$ccl->approved_status)
                    );
                    echo $ccl->email." users insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE users SET `id`=?, `name`=?, `email`=?, `position`=?, `email_verified_at`=?, `password`=?, `remember_token`=?, `created_at`=?, `updated_at`=? ,`approved_status`=? WHERE email=? '),
                            array($ccl->id,$ccl->name,$ccl->email,$ccl->position,$ccl->email_verified_at,$ccl->password,$ccl->remember_token,$ccl->created_at,$ccl->updated_at,$ccl->approved_status,$ccl->email)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM users_access_restrictions");
            $table2= DB::connection('mysql')->select("SELECT * FROM users_access_restrictions");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->user_id==$ccl->user_id){
                        $dup=1;
                        $uid=$ccl2->user_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into users_access_restrictions (`user_id`, `approvals`, `journal_entry`, `sales`, `invoice`, `estimate`, `credit_note`, `sales_receipt`, `expense`, `bill`, `supplier_credit`, `pay_bills`, `reports`, `fund_feeds`, `chart_of_accounts`, `cost_center`, `settings`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->user_id,$ccl->approvals,$ccl->journal_entry,$ccl->sales,$ccl->invoice,$ccl->estimate,$ccl->credit_note,$ccl->sales_receipt,$ccl->expense,$ccl->bill,$ccl->supplier_credit,$ccl->pay_bills,$ccl->reports,$ccl->fund_feeds,$ccl->chart_of_accounts,$ccl->cost_center,$ccl->settings,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->user_id." users_access_restrictions insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE users_access_restrictions SET `user_id`=?, `approvals`=?, `journal_entry`=?, `sales`=?, `invoice`=?, `estimate`=?, `credit_note`=?, `sales_receipt`=?, `expense`=?, `bill`=?, `supplier_credit`=?, `pay_bills`=?, `reports`=?, `fund_feeds`=?, `chart_of_accounts`=?, `cost_center`=?, `settings`=?, `created_at`=?, `updated_at`=? WHERE `user_id`=? '),
                            array($ccl->user_id,$ccl->approvals,$ccl->journal_entry,$ccl->sales,$ccl->invoice,$ccl->estimate,$ccl->credit_note,$ccl->sales_receipt,$ccl->expense,$ccl->bill,$ccl->supplier_credit,$ccl->pay_bills,$ccl->reports,$ccl->fund_feeds,$ccl->chart_of_accounts,$ccl->cost_center,$ccl->settings,$ccl->created_at,$ccl->updated_at,$ccl->user_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM user_cost_center_access");
            $table2= DB::connection('mysql')->select("SELECT * FROM user_cost_center_access");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->use_id==$ccl->use_id && $ccl2->cost_center_id==$ccl->cost_center_id){
                        $dup=1;
                        $uid=$ccl2->use_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into user_cost_center_access (`use_id`, `cost_center_id`, `access_status`, `created_at`, `updated_at`) values (?,?,?,?,?)'),
                        array($ccl->use_id,$ccl->cost_center_id,$ccl->access_status,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->use_id." user_cost_center_access insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE user_cost_center_access SET `use_id`=?, `cost_center_id`=?, `access_status`=?, `created_at`=?, `updated_at`=? WHERE `use_id`=? AND cost_center_id=? '),
                            array($ccl->use_id,$ccl->cost_center_id,$ccl->access_status,$ccl->created_at,$ccl->updated_at,$ccl->use_id,$ccl->cost_center_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
    }

    
    public function sync_voucher(Request $request){
        
        try{
            $table= DB::connection('mysql')->select("SELECT * FROM voucher");
            $table2= DB::connection('mysql3')->select("SELECT * FROM voucher");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->voucher_id==$ccl->voucher_id){
                        $dup=1;
                        $uid=$ccl2->voucher_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into voucher (`voucher_id`, `voucher_type`, `pay_to_order_of`, `voucher_no`, `voucher_date`, `received_from`, `received_from_bank`, `the_amount_of`, `bank`, `check_no`, `received_payment_by`, `prepared_by`, `certified_correct_by`, `approved_by`, `previous_voucher`, `remark`, `cancellation_date`, `cancellation_reason`, `created_at`, `updated_at`,`voucher_link_id`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->voucher_id,$ccl->voucher_type,$ccl->pay_to_order_of,$ccl->voucher_no,$ccl->voucher_date,$ccl->received_from,$ccl->received_from_bank,$ccl->the_amount_of,$ccl->bank,$ccl->check_no,$ccl->received_payment_by,$ccl->prepared_by,$ccl->certified_correct_by,$ccl->approved_by,$ccl->previous_voucher,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->voucher_link_id)
                    );
                    echo $ccl->voucher_id." voucher insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE voucher SET `voucher_id`=?, `voucher_type`=?, `pay_to_order_of`=?, `voucher_no`=?, `voucher_date`=?, `received_from`=?, `received_from_bank`=?, `the_amount_of`=?, `bank`=?, `check_no`=?, `received_payment_by`=?, `prepared_by`=?, `certified_correct_by`=?, `approved_by`=?, `previous_voucher`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `created_at`=?, `updated_at`=?,`voucher_link_id`=? WHERE voucher_id=? '),
                            array($ccl->voucher_id,$ccl->voucher_type,$ccl->pay_to_order_of,$ccl->voucher_no,$ccl->voucher_date,$ccl->received_from,$ccl->received_from_bank,$ccl->the_amount_of,$ccl->bank,$ccl->check_no,$ccl->received_payment_by,$ccl->prepared_by,$ccl->certified_correct_by,$ccl->approved_by,$ccl->previous_voucher,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->voucher_link_id,$ccl->voucher_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql')->select("SELECT * FROM voucher_journal_entry");
            $table2= DB::connection('mysql3')->select("SELECT * FROM voucher_journal_entry");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->journal_no==$ccl->journal_no && $ccl2->voucher_ref_no==$ccl->voucher_ref_no){
                        $dup=1;
                        $uid=$ccl2->journal_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into voucher_journal_entry (`journal_no`, `voucher_ref_no`, `account_title`, `debit`, `credit`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?)'),
                        array($ccl->journal_no,$ccl->voucher_ref_no,$ccl->account_title,$ccl->debit,$ccl->credit,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->voucher_id." voucher_journal_entry insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE voucher_journal_entry SET `journal_no`=?, `voucher_ref_no`=?, `account_title`=?, `debit`=?, `credit`=?, `created_at`=?, `updated_at`=? WHERE journal_no=? AND voucher_ref_no=?'),
                            array($ccl->journal_no,$ccl->voucher_ref_no,$ccl->account_title,$ccl->debit,$ccl->credit,$ccl->created_at,$ccl->updated_at,$ccl->journal_no,$ccl->voucher_ref_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

            $table= DB::connection('mysql')->select("SELECT * FROM voucher_transaction");
            $table2= DB::connection('mysql3')->select("SELECT * FROM voucher_transaction");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->tran_no==$ccl->tran_no && $ccl2->voucher_ref_no==$ccl->voucher_ref_no){
                        $dup=1;
                        $uid=$ccl2->tran_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql3')
                    ->statement(
                        DB::raw('insert into voucher_transaction (`tran_no`, `voucher_ref_no`, `tran_qty`, `tran_unit`, `tran_explanation`, `tran_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?)'),
                        array($ccl->tran_no,$ccl->voucher_ref_no,$ccl->tran_qty,$ccl->tran_unit,$ccl->tran_explanation,$ccl->tran_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->tran_no." voucher_transaction insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql3')
                        ->statement(
                            DB::raw('UPDATE voucher_transaction SET `tran_no`=?, `voucher_ref_no`=?, `tran_qty`=?, `tran_unit`=?, `tran_explanation`=?, `tran_amount`=?, `created_at`=?, `updated_at`=? WHERE tran_no=? AND voucher_ref_no=?'),
                            array($ccl->tran_no,$ccl->voucher_ref_no,$ccl->tran_qty,$ccl->tran_unit,$ccl->tran_explanation,$ccl->tran_amount,$ccl->created_at,$ccl->updated_at,$ccl->tran_no,$ccl->voucher_ref_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
        try{
            $table= DB::connection('mysql3')->select("SELECT * FROM voucher");
            $table2= DB::connection('mysql')->select("SELECT * FROM voucher");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->voucher_id==$ccl->voucher_id){
                        $dup=1;
                        $uid=$ccl2->voucher_id;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into voucher (`voucher_id`, `voucher_type`, `pay_to_order_of`, `voucher_no`, `voucher_date`, `received_from`, `received_from_bank`, `the_amount_of`, `bank`, `check_no`, `received_payment_by`, `prepared_by`, `certified_correct_by`, `approved_by`, `previous_voucher`, `remark`, `cancellation_date`, `cancellation_reason`, `created_at`, `updated_at`,`voucher_link_id`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'),
                        array($ccl->voucher_id,$ccl->voucher_type,$ccl->pay_to_order_of,$ccl->voucher_no,$ccl->voucher_date,$ccl->received_from,$ccl->received_from_bank,$ccl->the_amount_of,$ccl->bank,$ccl->check_no,$ccl->received_payment_by,$ccl->prepared_by,$ccl->certified_correct_by,$ccl->approved_by,$ccl->previous_voucher,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->voucher_link_id)
                    );
                    echo $ccl->voucher_id." voucher insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE voucher SET `voucher_id`=?, `voucher_type`=?, `pay_to_order_of`=?, `voucher_no`=?, `voucher_date`=?, `received_from`=?, `received_from_bank`=?, `the_amount_of`=?, `bank`=?, `check_no`=?, `received_payment_by`=?, `prepared_by`=?, `certified_correct_by`=?, `approved_by`=?, `previous_voucher`=?, `remark`=?, `cancellation_date`=?, `cancellation_reason`=?, `created_at`=?, `updated_at`=?,`voucher_link_id`=? WHERE voucher_id=? '),
                            array($ccl->voucher_id,$ccl->voucher_type,$ccl->pay_to_order_of,$ccl->voucher_no,$ccl->voucher_date,$ccl->received_from,$ccl->received_from_bank,$ccl->the_amount_of,$ccl->bank,$ccl->check_no,$ccl->received_payment_by,$ccl->prepared_by,$ccl->certified_correct_by,$ccl->approved_by,$ccl->previous_voucher,$ccl->remark,$ccl->cancellation_date,$ccl->cancellation_reason,$ccl->created_at,$ccl->updated_at,$ccl->voucher_link_id,$ccl->voucher_id)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
            $table= DB::connection('mysql3')->select("SELECT * FROM voucher_journal_entry");
            $table2= DB::connection('mysql')->select("SELECT * FROM voucher_journal_entry");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->journal_no==$ccl->journal_no && $ccl2->voucher_ref_no==$ccl->voucher_ref_no){
                        $dup=1;
                        $uid=$ccl2->journal_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into voucher_journal_entry (`journal_no`, `voucher_ref_no`, `account_title`, `debit`, `credit`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?)'),
                        array($ccl->journal_no,$ccl->voucher_ref_no,$ccl->account_title,$ccl->debit,$ccl->credit,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->voucher_id." voucher_journal_entry insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE voucher_journal_entry SET `journal_no`=?, `voucher_ref_no`=?, `account_title`=?, `debit`=?, `credit`=?, `created_at`=?, `updated_at`=? WHERE journal_no=? AND voucher_ref_no=?'),
                            array($ccl->journal_no,$ccl->voucher_ref_no,$ccl->account_title,$ccl->debit,$ccl->credit,$ccl->created_at,$ccl->updated_at,$ccl->journal_no,$ccl->voucher_ref_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }

            $table= DB::connection('mysql3')->select("SELECT * FROM voucher_transaction");
            $table2= DB::connection('mysql')->select("SELECT * FROM voucher_transaction");
            foreach($table as $ccl){
                $dup=0;
                $uid="";
                $updated_at="";
                foreach($table2 as $ccl2){
                    if($ccl2->tran_no==$ccl->tran_no && $ccl2->voucher_ref_no==$ccl->voucher_ref_no){
                        $dup=1;
                        $uid=$ccl2->tran_no;
                        $updated_at=$ccl2->updated_at;
                        break;
                    }else{
                        $dup=0;
                    } 
                }
                if($dup==0){
                    DB::connection('mysql')
                    ->statement(
                        DB::raw('insert into voucher_transaction (`tran_no`, `voucher_ref_no`, `tran_qty`, `tran_unit`, `tran_explanation`, `tran_amount`, `created_at`, `updated_at`) values (?,?,?,?,?,?,?,?)'),
                        array($ccl->tran_no,$ccl->voucher_ref_no,$ccl->tran_qty,$ccl->tran_unit,$ccl->tran_explanation,$ccl->tran_amount,$ccl->created_at,$ccl->updated_at)
                    );
                    echo $ccl->tran_no." voucher_transaction insert ";
                } else if($dup==1){
                    if(strtotime($updated_at)<strtotime($ccl->updated_at)){
                        DB::connection('mysql')
                        ->statement(
                            DB::raw('UPDATE voucher_transaction SET `tran_no`=?, `voucher_ref_no`=?, `tran_qty`=?, `tran_unit`=?, `tran_explanation`=?, `tran_amount`=?, `created_at`=?, `updated_at`=? WHERE tran_no=? AND voucher_ref_no=?'),
                            array($ccl->tran_no,$ccl->voucher_ref_no,$ccl->tran_qty,$ccl->tran_unit,$ccl->tran_explanation,$ccl->tran_amount,$ccl->created_at,$ccl->updated_at,$ccl->tran_no,$ccl->voucher_ref_no)
                        );
                        echo  $updated_at." < ". $ccl->updated_at." ";
                    }
                }
            }
        }catch(\Exception $e){

        }
    }
    
}
