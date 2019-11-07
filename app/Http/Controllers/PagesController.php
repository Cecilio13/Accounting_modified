<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\User;
use App\Company;
use App\Sales;
use App\Expenses;
use App\Advance;
use App\Customers;
use App\ProductsAndServices;
USE App\SalesTransaction;
use App\Supplier;
use App\JournalEntry;
use App\Formstyle;
use App\Report;
use App\AuditLog;
use App\Voucher;
use App\ChartofAccount;
use App\Numbering;
use App\CostCenter;
use App\DepositRecord;
use App\Bank;
use App\UserAccess;
use App\Clients;
use Illuminate\Support\Facades\Config;

class PagesController extends Controller
{
    public function __construct()
    {
        // $client=Clients::first();
        // $dbName='accounting_modified_'.$client->clnt_db_name;
            
        // DB::disconnect('mysql');//here connection name, I used mysql for example
        // Config::set('database.connections.mysql.database', $dbName);//new database name, you want to connect to.

    }
    
    public function index(\Illuminate\Http\Request $request){
        
        // $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
        // $db = DB::select($query, ['consmanagementsys']);
        // if(empty($db)){

        // }
        // else{
        //     $users2 = DB::table('users')->get();
        //     $users1= DB::connection('mysql2')->select("SELECT * FROM employee_info JOIN employee_email_address ON 
        //     employee_info.employee_id=employee_email_address.emp_id JOIN employee_job_detail ON employee_job_detail.emp_id=employee_info.employee_id WHERE position='Fixed Asset Officer'");
        //     //return $users2[0]->id;
        //     $a = array();
        //     if(count($users1) > 0){
        //         foreach($users1 as $useri){
        //             if($useri->email!=""){

        //                 //array_push($a,$useri->email);
        //                 $dup=0;
        //                 if(count($users2) > 0){
        //                     foreach($users2 as $userso){
        //                         if(strtolower($userso->email)==strtolower($useri->email)){
        //                             $dup=1;
                                    
        //                             break;
        //                         }
        //                     }
        //                 }
                        
        //                 if($dup==0){
        //                     $user= new User;
        //                     $user->name=$useri->fname;
        //                     $user->email=$useri->email;
        //                     $user->position=$useri->position;
        //                     $user->password=Hash::make($useri->password);
        //                     $user->save();
        //                 }
        //             }
                
        
        //         }

        //     }
        // }
        
            
        //temporary login using GET
        //http://accounting.me/?param1={email}&param2={password}
        $emailll=$request->input('param1');
        $passww=$request->input('param2');
        $sss=$passww;
        $arr2 = str_split($passww);
        $length=1;
        $dencrypted="";
        
        
        $userdata = array(
            'email' => $emailll ,
            'password' => $passww
        );

        // attempt to do the login

        if (Auth::attempt($userdata))
            {
            $user = Auth::user();
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="User Login";
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name="";
            $AuditLog->log_transaction_date="";
            $AuditLog->log_amount="";
            $AuditLog->save();
            // Get the currently authenticated user's ID...
            $id = Auth::id();
            
            //Auth::logout();
            return redirect()->intended('/dashboard');
            // validation successful
            // do whatever you want on success

            }
          else
            {
            return redirect()->intended('/login');
            //echo $emailll." ".$passww;
            // validation not successful, send back to form

            //return Redirect::to('checklogin');
            }  
        
        
    }
    public function import_employee(Request $request){
        // try {
			
        //     DB::connection('mysql_ms')->getPdo();
        //     $employees_from_monitoring_system= DB::connection('mysql_ms')->select("SELECT * FROM ark_employee ");
        //     foreach($employees_from_monitoring_system as $efms){
        //         $customers_from_accounting = Customers::where([
        //             ['display_name','=',$efms->First_Name." ".$efms->Middle_Name." ".$efms->Last_Name]
        //         ])->first();
        //         if(empty($customers_from_accounting)){
        //         $customer = new Customers;
        //         $customer->customer_id = Customers::count() + 1;
        //         $customer->f_name = $efms->First_Name;
                
        //         $customer->l_name = $efms->Last_Name;
        //         $customer->email = $efms->EmailAddress;
        //         $customer->company = "";
        //         $customer->phone = "";
        //         $customer->mobile = $efms->ContactNumber;
        //         $customer->fax = "";
        //         $customer->display_name = $efms->First_Name." ".$efms->Middle_Name." ".$efms->Last_Name;
        //         $customer->other = "";
        //         $customer->website = "";
        //         $customer->street = $efms->Address;
        //         $customer->city = "";
        //         $customer->state = "";
        //         $customer->postal_code = "";
        //         $customer->country = "";
        //         $customer->payment_method = "";
        //         $customer->terms = "";
        //         $customer->opening_balance = 0;
        //         $customer->as_of_date = date('Y-m-d');
        //         $customer->account_no = "";
        //         $customer->business_id_no = "";
        //         $customer->notes = "";
        //         $customer->attachment = "";
        //         $customer->tin_no=$efms->TINNo;
        //         $customer->withhold_tax=12;
        //         $customer->business_style="";
        //         $customer->account_type="Employee";
                
        //         $customer->save();

        //         $AuditLog= new AuditLog;
        //         $AuditLogcount=AuditLog::count()+1;
        //         $userid = Auth::user()->id;
        //         $username = Auth::user()->name;
        //         $eventlog="Imported Employee";
        //         $AuditLog->log_id=$AuditLogcount;
        //         $AuditLog->log_user_id=$username;
        //         $AuditLog->log_event=$eventlog;
        //         $AuditLog->log_name="";
        //         $AuditLog->log_transaction_date="";
        //         $AuditLog->log_amount="";
        //         $AuditLog->save();
        //         }else{
                   
        //         }
                
        //     }
        //     //return "";
        // } catch (\Exception $e) {
        //     //connection not established
        //     //return $e;
        // }
    }
    public function dashboard(Request $request){
        
        $useracess=UserAccess::find("q");
        if(empty($useracess)){
            $useracess= new UserAccess;
            $useracess->user_id="q";
            $useracess->save();
        }
        
        
        //return Auth::user()->position;
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        if(empty($numbering)){
            $numbering = new Numbering;
            $numbering->numbering_no="0";
            $numbering->sales_exp_start_no="1001";
            $numbering->numbering_bill_invoice_main="1001";
            $numbering->numbering_sales_invoice_branch="1001";
            $numbering->numbering_bill_invoice_branch="1001";
            $numbering->credit_note_start_no="1001";
            $numbering->sales_receipt_start_no="1001";
            $numbering->bill_start_no="1001";
            $numbering->suppliers_credit_start_no="1001";
            $numbering->cash_voucher_start_no="1";
            $numbering->cheque_voucher_start_no="1";
            $numbering->estimate_start_no="1001";
            $numbering->save();
        }
        
        $company = Company::first();
        $sales = Sales::first();
        $expenses = Expenses::first();
        $advance = Advance::first();
        $numbering = Numbering::first();
        $bank = Bank::all();
        if(empty($company) ||  empty($sales) || empty($expenses) ||  empty($advance) || empty($numbering) || empty($bank)){
            return redirect()->intended('/accountsandsettings');
        }
            
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $users2 = DB::table('users')->get();
        
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();
        $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        $sales_transaction = SalesTransaction::all();
        $total_invoice_receivable=0;
        $total_invoice_receivable_due=0;
        foreach($sales_transaction as $transaction){
            if($transaction->st_type == "Invoice" && $transaction->remark!="Cancelled"){
                $total_invoice_receivable += $transaction->st_balance;
                if(strtotime($transaction->st_due_date) < time()){
                    $total_invoice_receivable_due += $transaction->st_balance;
                }
            }
            
        }
        
        
        $overduetotal_amount=0;
        $unuetotal_amount=0;
        $current_month=0;
        $current_month_due=0;
        $current_month_less_one=0;
        $current_month_less_one_due=0;
        $current_month_less_two=0;
        $current_month_less_two_due=0;
        $current_month_less_three=0;
        $current_month_less_three_due=0;
        $rest=$request->expense_month;
        if($rest==""){
            $rest=date('n');
        }
        $month_selected_raw=$rest;
        $month_selected=$rest;
        if($month_selected<10){
            $month_selected="0".$month_selected;
        }

        $year_less_one=date('Y');
        $month_selected_less_one=$rest-1;
        $one_month=$rest-1;
        if($month_selected_less_one<=0){
            $month_selected_less_one+=12;
            $one_month+=12;
            $year_less_one=date('Y')-1;
        }
        if($month_selected_less_one<10){
            $month_selected_less_one="0".$month_selected_less_one;
        }

        $year_less_two=date('Y');
        $month_selected_less_two=$rest-2;
        $two_month=$month_selected_less_two;
        if($month_selected_less_two<=0){
            $month_selected_less_two+=12;
            $two_month+=12;
            $year_less_two=date('Y')-1;
        }
        if($month_selected_less_two<10){
            $month_selected_less_two="0".$month_selected_less_two;
        }

        $year_less_three=date('Y');
        $month_selected_less_three=$rest-3;
        $three_month=$month_selected_less_two;
        if($month_selected_less_three<=0){
            $month_selected_less_three+=12;
            $three_month+=12;
            $year_less_three=date('Y')-1;
        }
        if($month_selected_less_three<10){
            $month_selected_less_three="0".$month_selected_less_three;
        }

        //return $month_selected_less_two." - ".$year_less_two;
        foreach($expense_transactions as $et){
            
            if ($et->et_type==$et->et_ad_type){
                if($et->et_due_date!=""){
                    
                    if($et->et_date>=date('Y-'.$month_selected.'-01') && $et->et_date<=date('Y-'.$month_selected.'-t') ){
                        $date1=date_create(date('Y-m-d'));
                        $date2=date_create($et->et_due_date);
                        $diff=date_diff($date1,$date2);
                        if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && $et->et_bil_status!="Paid" && $et->remark=="" ){
                            $current_month_due+=$et->bill_balance;
                        }else{
                            if($et->et_bil_status!="Paid" && $et->remark==""){
                                $current_month+=$et->bill_balance;
                            }   
                        }
                    }
                    if($et->et_date>=date($year_less_one.'-'.$month_selected_less_one.'-01') && $et->et_date<=date($year_less_one.'-'.$month_selected_less_one.'-t') ){
                        $date1=date_create(date('Y-m-d'));
                        $date2=date_create($et->et_due_date);
                        $diff=date_diff($date1,$date2);
                        if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && $et->et_bil_status!="Paid" && $et->remark=="" ){
                            $current_month_less_one_due+=$et->bill_balance;
                        }else{
                            if($et->et_bil_status!="Paid" && $et->remark==""){
                                $current_month_less_one+=$et->bill_balance;
                            }   
                        }
                    }

                    if($et->et_date>=date($year_less_two.'-'.$month_selected_less_two.'-01') && $et->et_date<=date($year_less_two.'-'.$month_selected_less_two.'-t') ){
                        $date1=date_create(date('Y-m-d'));
                        $date2=date_create($et->et_due_date);
                        $diff=date_diff($date1,$date2);
                        if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && $et->et_bil_status!="Paid" && $et->remark=="" ){
                            $current_month_less_two_due+=$et->bill_balance;
                        }else{
                            if($et->et_bil_status!="Paid" && $et->remark==""){
                                $current_month_less_two+=$et->bill_balance;
                            }   
                        }
                    }
                    if($et->et_date>=date($year_less_three.'-'.$month_selected_less_three.'-01') && $et->et_date<=date($year_less_three.'-'.$month_selected_less_three.'-t') ){
                        $date1=date_create(date('Y-m-d'));
                        $date2=date_create($et->et_due_date);
                        $diff=date_diff($date1,$date2);
                        if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && $et->et_bil_status!="Paid" && $et->remark=="" ){
                            $current_month_less_three_due+=$et->bill_balance;
                        }else{
                            if($et->et_bil_status!="Paid" && $et->remark==""){
                                $current_month_less_three+=$et->bill_balance;
                            }   
                        }
                    }

                }
            }
        }
        
        //return 0;
        return view('pages.index', compact(['current_month_less_three','current_month_less_three_due','month_selected_less_three','year_less_three','three_month','one_month','two_month','current_month_less_two','current_month_less_two_due','month_selected_less_two','year_less_two','year_less_one','current_month_less_one','current_month_less_one_due','month_selected_raw','current_month_due','current_month','overduetotal_amount','unuetotal_amount','total_invoice_receivable','total_invoice_receivable_due','numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount', 'users2','customers', 'products_and_services','JournalEntry','VoucherCount']));

    }

    
    private function adddefaultcostcenter($cc_type_code,$cc_type,$cc_name_code,$cc_name){
        $cc= DB::connection('mysql')->select("SELECT * FROM cost_center WHERE cc_name_code='$cc_name_code' AND cc_name='$cc_name' AND cc_type='$cc_type' AND cc_type_code='$cc_type_code'");
        $cc_count = count($cc);
        if($cc_count<1){
            $costcenter= New CostCenter;
            $costcenter->cc_no= CostCenter::count() + 1; 
            $costcenter->cc_type_code=$cc_type_code; 
            $costcenter->cc_type=$cc_type; 
            $costcenter->cc_name_code=$cc_name_code; 
            $costcenter->cc_name=$cc_name;
            $costcenter->save();
        }
        
    }
    private function adddefaultcoa($coa_account_type,$coa_detail_type,$coa_code,$coa_normal_balance,$coa_title,$coa_description,$coa_sub_acc){
           $coa= DB::connection('mysql')->select("SELECT * FROM chart_of_accounts WHERE coa_account_type='$coa_account_type' AND coa_detail_type='$coa_detail_type' AND coa_name='$coa_detail_type'");
           $coa_count = count($coa);
           if($coa_count<1){
               $Chart= New ChartofAccount;
               $Chart->id= ChartofAccount::count() + 1; 
   
               $Chart->coa_account_type=$coa_account_type;
               $Chart->coa_detail_type=$coa_detail_type;
               $Chart->coa_name=$coa_detail_type;
               $Chart->coa_description=$coa_description;
               $Chart->coa_is_sub_acc="0";
               $Chart->coa_code=$coa_code;
               $Chart->normal_balance=$coa_normal_balance;
               $Chart->coa_title=$coa_title;
               $Chart->coa_parent_account="";
               $Chart->coa_balance="0";
               $Chart->coa_sub_account=$coa_sub_acc;
               $Chart->coa_as_of_date=date('Y-m-d');
               $Chart->coa_active="1";
               $Chart->save();
           } 
    }
    public function print_journal_entry(Request $request){
        $Journal_no_selected= $request->no;
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_debit','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $Report = Report::all();
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $favorite_report = DB::table('favorite_report')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        $cost_center_list_all= CostCenter::orderBy('cc_type_code', 'asc')->get();
        $journal_type_query=JournalEntry::where([
            ['je_no','=',$Journal_no_selected]
        ])->first();
        return view('pages.print_journal', compact('journal_type_query','cost_center_list_all','Journal_no_selected','numbering','st_invoice','cost_center_list','favorite_report','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','Report','customers', 'products_and_services','JournalEntry','jounalcount','VoucherCount'));
    }
    public function print_cheque_journal_entry(Request $request){
        $Journal_no_selected= $request->no;
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $Report = Report::all();
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $favorite_report = DB::table('favorite_report')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        $cost_center_list_all= CostCenter::orderBy('cc_type_code', 'asc')->get();
        $journal_type_query=JournalEntry::where([
            ['je_no','=',$Journal_no_selected]
        ])->first();
        return view('pages.print_cheque_journal', compact('journal_type_query','cost_center_list_all','Journal_no_selected','numbering','st_invoice','cost_center_list','favorite_report','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','Report','customers', 'products_and_services','JournalEntry','jounalcount','VoucherCount'));
    }
    public function reports(){
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $Report = Report::all();
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $favorite_report = DB::table('favorite_report')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.reports', compact('numbering','st_invoice','cost_center_list','favorite_report','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','Report','customers', 'products_and_services','JournalEntry','jounalcount','VoucherCount'));
    }
    public function userprofile(){
        
        
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $Report = Report::all();
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $favorite_report = DB::table('favorite_report')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.userprofile', compact('numbering','st_invoice','cost_center_list','favorite_report','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','Report','customers', 'products_and_services','JournalEntry','jounalcount','VoucherCount'));
    }
    public function voucher(){
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.voucher', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','customers','JournalEntry','products_and_services','VoucherCount'));

    }
    public function banking(){
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.banking', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','customers','JournalEntry','products_and_services','VoucherCount'));
    }
    public function pending_user(){
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $Report = Report::all();
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $favorite_report = DB::table('favorite_report')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        $all_system_users=DB::table('users')->get();
        $all_system_users_access=DB::table('users_access_restrictions')->get();
        $all_system_users_cost_center_access=DB::table('user_cost_center_access')->get();
        $cost_center_list_grouped= CostCenter::where('cc_status','1')->groupBy('cc_type')->orderBy('cc_type', 'asc')->get();
        return view('pages.pending_users', compact('cost_center_list_grouped','all_system_users_cost_center_access','all_system_users_access','all_system_users','numbering','st_invoice','cost_center_list','favorite_report','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','Report','customers', 'products_and_services','JournalEntry','jounalcount','VoucherCount'));
       
    }
    public function sync(){
        return view('pages.sync');
    }
    public function approvals(){
        $customers = Customers::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $products_and_services = ProductsAndServices::all();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $Report = Report::all();
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $favorite_report = DB::table('favorite_report')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.approvals', compact('numbering','st_invoice','cost_center_list','favorite_report','ETran','SS','COA','expense_transactions','et_acc','et_it','Report','customers', 'products_and_services','JournalEntry','jounalcount','VoucherCount'));
      
    }
    public function expenses(){
        $customers = Customers::all();
        $supplierss = Customers::where([
            ['account_type','=','Supplier']
        ])->get();
        
        $products_and_services = ProductsAndServices::all();
        $Supplier= Supplier::where('supplier_active', '1')->get();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark=="" && $et->et_type==$et->et_ad_type){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        
        return view('pages.expenses', compact('supplierss','numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','et_it','et_acc','totalexp','expense_transactions','jounalcount','customers','Supplier', 'products_and_services','JournalEntry','VoucherCount'));
    }
   
    public function taxes(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.taxes', compact('numbering','st_invoice','cost_center_list','ETran','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','customers', 'products_and_services','JournalEntry','VoucherCount'));
    }
    public function accounting(Request $request){

        $chart_of_accounts = DB::table('chart_of_accounts')
                ->where('coa_active', '1')
                 ->get();
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $orThose = ['st_type' => 'Invoice','st_status' => 'Open'];
        $orThose2 = ['st_type' => 'Invoice','st_status' => 'Partially paid'];
        $sales_transaction = DB::table('sales_transaction')
            ->join('customers', 'customers.customer_id', '=', 'sales_transaction.st_customer_id')
            ->where([
                ['st_type', '=', 'Invoice'],
                ['st_status', '=', 'Open'],
            ])
            ->orWhere('st_status', '=', 'Partially paid')
            ->get();
        $orThose = ['st_type' => 'Invoice','st_status' => 'Open'];
        $sales_tran = DB::table('sales_transaction')
            ->join('customers', 'customers.customer_id', '=', 'sales_transaction.st_customer_id')
            ->where([
                ['st_type', '=', 'Invoice'],
                ['st_status', '=', 'Open'],
            ])
            ->orWhere('st_status', '=', 'Partially paid')
            ->get();
        $notude=0;
        $due=0;
        $invoicetotal=0;
        foreach($sales_tran as $st){
            $datetime1 = date_create(date('Y-m-d'));
            $datetime2 = date_create($st->st_due_date);
            $interval = date_diff($datetime1, $datetime2);
            $invoicetotal=$invoicetotal+$st->st_balance;
            if($interval->format('%R')=="-"){
                $due=$due+$st->st_balance;
            }else{
                $notude=$notude+$st->st_balance;
            }
            //echo $notude." ".$due."<br>";
        }
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA_Index=0;
        $keyword="";
        if($request->no){
            $COA_Index=($request->no)-1;
        }else{
            $COA_Index=0;
        }
        if($request->keyword){
            $keyword=$request->keyword;
        }else{
            $keyword="";
        }
        $chartofaccountbyaccounttype = DB::table('chart_of_accounts')
                ->skip($COA_Index)
                ->take(20)
                ->select('*')
                ->groupBy('coa_account_type')
                ->orderBy('id', 'asc')
                ->orderBy('coa_account_type', 'DESC')
                ->get();
        $COA= DB::table('chart_of_accounts')
                ->skip($COA_Index)
                ->take(20)
                ->where('coa_active','1')
                ->Where(function ($query) use ($keyword) {
                    $query->where('coa_account_type','LIKE','%'.$keyword.'%')
                          ->orwhere('coa_title','LIKE','%'.$keyword.'%')
                          ->orwhere('coa_name','LIKE','%'.$keyword.'%')
                          ->orwhere('coa_code','LIKE','%'.$keyword.'%');
                })
                ->orderBy('id', 'asc')
                ->get();
        //return $COA;
        $COA_Type_GROUPPED = []; 
        foreach($COA as $coaa){
            $COA_Type_GROUPPED[]=$coaa->coa_title;
        }
        $COA_Type_GROUPPED=array_unique($COA_Type_GROUPPED);
        //return $COA_Type_GROUPPED;
        $SS=SalesTransaction::all();
        $ETran = DB::table('expense_transactions')->get();
        $CostCenter = DB::table('cost_center')->orderBy('cc_name_code', 'asc')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center = DB::table('cost_center')
                ->select('*')
                ->groupBy('cc_type')
                ->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();        
        return view('pages.accounting', compact('keyword','COA_Index','COA_Type_GROUPPED','cost_center','CostCenter','numbering','st_invoice','cost_center_list','ETran','SS','chartofaccountbyaccounttype','COA','expense_transactions','totalexp','et_acc','et_it','sales_transaction','invoicetotal','due','notude','jounalcount','customers', 'chart_of_accounts', 'products_and_services','JournalEntry','VoucherCount'));
    }
    public function cost_center(Request $request){
        $chart_of_accounts = DB::table('chart_of_accounts')
                ->where('coa_active', '1')
                 ->get();
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $orThose = ['st_type' => 'Invoice','st_status' => 'Open'];
        $orThose2 = ['st_type' => 'Invoice','st_status' => 'Partially paid'];
        $sales_transaction = DB::table('sales_transaction')
            ->join('customers', 'customers.customer_id', '=', 'sales_transaction.st_customer_id')
            ->where([
                ['st_type', '=', 'Invoice'],
                ['st_status', '=', 'Open'],
            ])
            ->orWhere('st_status', '=', 'Partially paid')
            ->get();
        $orThose = ['st_type' => 'Invoice','st_status' => 'Open'];
        $sales_tran = DB::table('sales_transaction')
            ->join('customers', 'customers.customer_id', '=', 'sales_transaction.st_customer_id')
            ->where([
                ['st_type', '=', 'Invoice'],
                ['st_status', '=', 'Open'],
            ])
            ->orWhere('st_status', '=', 'Partially paid')
            ->get();
        $notude=0;
        $due=0;
        $invoicetotal=0;
        foreach($sales_tran as $st){
            $datetime1 = date_create(date('Y-m-d'));
            $datetime2 = date_create($st->st_due_date);
            $interval = date_diff($datetime1, $datetime2);
            $invoicetotal=$invoicetotal+$st->st_balance;
            if($interval->format('%R')=="-"){
                $due=$due+$st->st_balance;
            }else{
                $notude=$notude+$st->st_balance;
            }
            //echo $notude." ".$due."<br>";
        }
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $chartofaccountbyaccounttype = DB::table('chart_of_accounts')
                ->select('*')
                ->groupBy('coa_account_type')
                ->orderBy('coa_code', 'desc')
                ->get();
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();
        $ETran = DB::table('expense_transactions')->get();
        $CC_Index=0;
        $keyword="";
        if($request->no){
            $CC_Index=($request->no)-1;
        }else{
            $CC_Index=0;
        }
        if($request->keyword){
            $keyword=$request->keyword;
        }else{
            $keyword="";
        }
        $CostCenter = DB::table('cost_center')
                    ->skip($CC_Index)
                    ->take(20)
                    ->Where(function ($query) use ($keyword) {
                        $query->where('cc_no','LIKE','%'.$keyword.'%')
                            ->orwhere('cc_type_code','LIKE','%'.$keyword.'%')
                            ->orwhere('cc_name_code','LIKE','%'.$keyword.'%')
                            ->orwhere('cc_type','LIKE','%'.$keyword.'%')
                            ->orwhere('cc_name','LIKE','%'.$keyword.'%');
                    })
                    ->orderBy('cc_type_code', 'asc')->get();
        $CC_Type_GROUPPED = []; 
        foreach($CostCenter as $coaa){
            $CC_Type_GROUPPED[]=$coaa->cc_type_code." -- ".$coaa->cc_type;
        }
        $CC_Type_GROUPPED=array_unique($CC_Type_GROUPPED);
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center = DB::table('cost_center')
                ->select('*')
                ->groupBy('cc_type')
                ->orderBy('cc_type_code', 'asc')
                ->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();        
        return view('pages.cost_center', compact('CC_Type_GROUPPED','keyword','CC_Index','cost_center','CostCenter','numbering','st_invoice','cost_center_list','ETran','SS','chartofaccountbyaccounttype','COA','expense_transactions','totalexp','et_acc','et_it','sales_transaction','invoicetotal','due','notude','jounalcount','customers', 'chart_of_accounts', 'products_and_services','JournalEntry','VoucherCount'));
    }

    public function invoice(){
        return view('pages.invoice');
    }
    public function receivepayment(){
        return view('pages.receivepayment');
    }
    public function estimate(){
        return view('pages.estimate');
    }
    public function creditnotice(){
        return view('pages.creditnotice');
    }
    public function salesreceipt(){
        return view('pages.salesreceipt');
    }
    public function sales(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $prod= ProductsAndServices::where('product_qty', '0')->get();
        $prod2= ProductsAndServices::whereRaw('product_qty<=product_reorder_point')->get();
        $orThose = ['st_type' => 'Invoice','st_status' => 'Open'];
        $sales_tran = DB::table('sales_transaction')
            ->where([
                ['st_type', '=', 'Invoice'],
                ['st_status', '=', 'Open'],
            ])
            ->orWhere('st_status', '=', 'Partially paid')
            ->get();
        $notude=0;
        $due=0;
        $invoicetotal=0;
        foreach($sales_tran as $st){
            $datetime1 = date_create(date('Y-m-d'));
            $datetime2 = date_create($st->st_due_date);
            $interval = date_diff($datetime1, $datetime2);
            $invoicetotal=$invoicetotal+$st->st_balance;
            if($interval->format('%R')=="-"){
                $due=$due+$st->st_balance;
            }else{
                $notude=$notude+$st->st_balance;
            }
            //echo $notude." ".$due."<br>";
        }
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.sales', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','invoicetotal','due','notude','jounalcount','customers', 'products_and_services', 'sales_transaction','JournalEntry','prod','prod2','VoucherCount'));
    }
    public function refundreceipt(){
        return view('pages.refundreceipt');
    }
    public function delayedcredit(){
        return view('pages.delayedcredit');
    }
    public function delayedcharge(){
        return view('pages.delayedcharge');
    }
    //
    public function expense(){
        return view('pages.expense');
    }
    public function cheque(){
        return view('pages.cheque');
    }
    public function bill(){
        return view('pages.bill');
    }
    public function paybills(){
        return view('pages.paybills');
    }
    public function purchaseorder(){
        return view('pages.purchaseorder');
    }
    public function suppliercredit(){
        return view('pages.suppliercredit');
    }
    public function creditcardcredit(){
        return view('pages.creditcardcredit');
    }
    //
    public function bankdeposit(){
        return view('pages.bankdeposit');
    }
    public function transfer(){
        return view('pages.transfer');
    }
    public function journalentry(Request $request){
        // $JournalEntry = JournalEntry::where([['remark','!=','Cancelled']])->get();
        //     return $JournalEntry;
        
        $JournalNoSelected=0;
        $keyword="";
        if($request->no){
            $JournalNoSelected=($request->no)-1;
        }else{
            $JournalNoSelected=0;
        }
        if($request->keyword){
            $keyword=$request->keyword;
        }else{
            $keyword="";
        }
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        if($keyword==""){
            $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->skip($JournalNoSelected)->take(20)->orderBy('je_no','DESC')->orderBy('je_debit', 'DESC')->get();
        }else{
            $JournalEntry = DB::table('journal_entries')->skip($JournalNoSelected)
            ->join('chart_of_accounts', 'chart_of_accounts.id', '=', 'journal_entries.je_account')
            
            ->Where(function ($query) use ($keyword) {
                $query->where('je_debit','LIKE','%'.$keyword.'%')
                        ->where('remark','!=','NULLED')
                      ->orwhere('je_no','LIKE','%'.$keyword.'%')
                      ->orwhere('je_credit','LIKE','%'.$keyword.'%')
                      ->orwhere('je_memo','LIKE','%'.$keyword.'%')
                      ->orwhere('chart_of_accounts.coa_name','LIKE','%'.$keyword.'%')
                      ->orwhere('chart_of_accounts.coa_code','LIKE','%'.$keyword.'%')
                      ->orwhere('je_desc','LIKE','%'.$keyword.'%')
                      ->orwhere('je_name','LIKE','%'.$keyword.'%');
            })
            ->take(20)
            ->orderBy('je_no','DESC')
            ->orderBy('je_debit', 'DESC')
            ->get();
           // return $JournalEntry;
        }
        //return $JournalEntry;
        
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.journalentry', compact('keyword','JournalNoSelected','numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    
    }
    public function checkregister(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();
        $deposit_records=DepositRecord::all();
        $ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        $all_cost_center_list=CostCenter::all();
        return view('pages.register', compact('all_cost_center_list','deposit_records','numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    public function statements(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.statements', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    public function investqtyadj(){
        return view('pages.investqtyadj');
    }
    //  
    public function accountsandsettings(){
        $company = Company::first();
        $sales = Sales::first();
        $expenses = Expenses::first();
        $advance = Advance::first();
        $numbering = Numbering::first();         
        $st_invoice = DB::table('st_invoice')->get();
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.accountsandsettings', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','company', 'sales', 'expenses', 'advance', 'customers', 'products_and_services','VoucherCount'));
    }
    public function customformstyles(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $settings_company = DB::table('settings_company')->first();
        $Formstyle= Formstyle::where('cfs_status', '1')->get();
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.customformstyles', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','Formstyle','settings_company','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    


    public function alllists(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.alllists', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    
    }
    
    public function recurringtransactions(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.recurringtransactions', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    public function attachments(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
                    ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
                    ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
                    ->get();
                    $et_acc = DB::table('et_account_details')->get();
                    $et_it = DB::table('et_item_details')->get();
                $totalexp=0;
                foreach($expense_transactions as $et){
                    if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
                }
                $COA= ChartofAccount::where('coa_active','1')->get();
                $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
                $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
                $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.attachments', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    //
    public function importdata(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
                    ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
                    ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
                    ->get();
                    $et_acc = DB::table('et_account_details')->get();
                    $et_it = DB::table('et_item_details')->get();
                $totalexp=0;
                foreach($expense_transactions as $et){
                    if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
                }
                $COA= ChartofAccount::where('coa_active','1')->get();
                $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
                $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
                $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.importdata', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    public function exportdata(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.exportdata', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    public function auditlog(){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $sales_transaction = SalesTransaction::all();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $VoucherCount=Voucher::count() + 1;
        if($VoucherCount<10){
            $VoucherCount="000".$VoucherCount;
        }
        else if($VoucherCount<100 && $VoucherCount>9 ){
            $VoucherCount="00".$VoucherCount;
        }
        else if($VoucherCount<1000 && $VoucherCount>99 ){
            $VoucherCount="0".$VoucherCount;
        }
        $VoucherCount=Voucher::all();
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();         $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.auditlog', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction','VoucherCount'));
    }
    

}
