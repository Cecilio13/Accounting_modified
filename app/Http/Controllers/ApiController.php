<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use File;
use Auth;
use Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Storage;
use PHPExcel; 
use PHPExcel_IOFactory;
use App\HR_Company_Basic_Info;
use App\HR_Company_Bank;
use App\HR_Company_Cost_Center;
use App\HR_Company_Department;
use App\HR_Company_Work_Policy;
use App\HR_Company_Tax_Computation;
use App\HR_Company_Govt_SSS;
use App\HR_Company_Govt_PhilHealth;
use App\HR_Company_payroll_computation;
use App\HR_Company_payroll_computation_thirteen;
use App\HR_Company_payroll_computation_rest_day;
use App\HR_Company_payroll_computation_ot_rate;
use App\HR_Company_payroll_computation_ot_comp_option;
use App\HR_Company_payroll_computation_new_hire;
use App\HR_Company_payroll_computation_late;
use App\HR_Company_payroll_computation_final_computation;
use App\HR_Company_payroll_computation_absent;
use App\HR_Company_reference_sss_table;
use App\HR_Company_reference_tax_table_deduction;
use App\HR_Company_reference_tax_tax_table;
use App\HR_Company_reference_hr_payroll_adjustment_template;
use App\HR_Company_reference_hr_payroll_company_adjustment;
use App\HR_Company_reference_hr_reference_govt_or_record;

use App\HR_Company_reference_hr_ot_table;
use App\HR_hr_employee_info;
use Illuminate\Support\Facades\Hash;
use App\HR_hr_employee_email;
use App\HR_hr_employee_alt_contact;
use App\HR_hr_employee_emergency_contact;
use App\HR_hr_employee_education;
use App\HR_hr_employee_seminar;
use App\HR_hr_employee_trainer;
use App\HR_hr_employee_salary_detail;
use App\HR_hr_employee_job_detail;
use App\HR_hr_employee_leavemanagement;
use App\HR_hr_employee_schedule_detail;
use App\HR_hr_memo;
use App\HR_hr_form_template;
use App\HR_hr_cash_advances;
use App\HR_cash_advance_loan_type;
use App\HR_payroll;
use App\HR_hr_employee_salary;
use App\HR_hr_a_asset_request; //not yet implemented
use App\HR_hr_employee_adjustment;
use DateTime;
use DatePeriod;
use DateInterval;
use App\HR_hr_cash_advances_payment;
use App\HR_hr_asset_transaction_log;
use App\HR_hr_Asset;
use App\User;
use App\HR_hr_Asset_setup;


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
use App\BankEdits;
use App\UserCostCenterAccess;
use App\StCreditNote;
use App\ExpenseTransaction;


use App\EtItemDetail;
use App\EtAccountDetail;
use App\PayBill;
use App\VoucherTransaction;
use App\VoucherJournalEntry;

use App\Budgets;
use App\CostCenterEdit;
use App\BudgetsEdit;
use App\COAEdits;
use App\ProductAndServicesEdit;
use App\CustomerEdit;
use App\ExpenseTransactionEdit;
use App\EtItemDetailEdit;
use App\ETAccountDetailEdit;
use App\StInvoiceEdit;
use App\SalesTransactionEdit;
use App\StCreditNoteEdit;
use App\ExpenseTransactionNew;
use App\EtItemDetailNew;
use App\ETAccountDetailNew;
use App\CC_Type;
use App\STInvoice;
use App\StEstimate;
class ApiController extends Controller
{
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/x-www-form-urlencoded');
        
    }
    public function add_sales_receipt(Request $request)
    {
       
        $numbering = Numbering::first();
        $sales_number = SalesTransaction::where('st_type','Sales Receipt')->count() + $numbering->sales_receipt_start_no;

        $sales_transaction = new SalesTransaction;
        $sales_transaction->st_no = $request->sales_receipt_no;
        $sales_transaction->st_date = $request->sr_date;
        $sales_transaction->st_type = $request->transaction_type_sales_receipt;
        $sales_transaction->st_term = null;
        $sales_transaction->st_customer_id = $request->sr_customer;
        $sales_transaction->st_due_date = null;
        $sales_transaction->st_status = 'Closed';
        $sales_transaction->st_action = '';
        $sales_transaction->st_email = $request->invoice_item_no;
        //$sales_transaction->st_send_later = $request->sr_send_later;
        $sales_transaction->st_bill_address = $request->sr_bill_address;
        $sales_transaction->st_note = $request->sr_message;
        $sales_transaction->st_memo = $request->sr_memo;
        //$sales_transaction->st_i_attachment = $request->sr_attachment;
        $sales_transaction->st_balance = 0;
        $sales_transaction->st_amount_paid = $request->hiddentotaldebitamountsalesreceipt;
        $sales_transaction->st_location = $request->sales_receipt_location_top;
        $sales_transaction->st_invoice_type = $request->sales_receipt_type_top;
        $sales_transaction->st_payment_for = $request->invoiceno_sr;
        
        $sales_transaction->save();

        $old_invoice_transaction = SalesTransaction::where([
            ['st_no','=',$request->invoiceno_sr],
            ['st_type','=',"Invoice"],
            ['st_location','=',$request->sales_receipt_location_top],
            ['st_invoice_type','=',$request->sales_receipt_type_top],
        ])->first();
        
            if($old_invoice_transaction->st_balance <= $request->hiddentotaldebitamountsalesreceipt){
                $old_invoice_transaction->st_balance = $old_invoice_transaction->st_balance - $request->hiddentotaldebitamountsalesreceipt;
                $old_invoice_transaction->st_status = 'Paid';
                $old_invoice_transaction->save();
            }else{
                $old_invoice_transaction->st_balance = $old_invoice_transaction->st_balance - $request->hiddentotaldebitamountsalesreceipt;
                $old_invoice_transaction->st_status = 'Partially paid';
                $old_invoice_transaction->save();
            }
        $st_invoice_item = StInvoice::where([
            ['st_i_no','=',$request->invoiceno_sr],
            ['st_i_item_no','=',$request->invoice_item_no],
            ['st_p_location','=',$request->sales_receipt_location_top],
            ['st_p_invoice_type','=',$request->sales_receipt_type_top],
        ])->first();
        $st_invoice_item->st_p_amount=$st_invoice_item->st_p_amount+$request->hiddentotaldebitamountsalesreceipt;
        $st_invoice_item->save();

        $customer = new Customers;
        $customer = Customers::find($request->sr_customer);
        $customer = Customers::find($request->sr_customer);
        $customer->opening_balance = $customer->opening_balance -$request->hiddentotaldebitamountsalesreceipt;
        $customer->save();
        // $AuditLog= new AuditLog;
        // $AuditLogcount=AuditLog::count()+1;
        // $userid = Auth::user()->id;
        // $username = Auth::user()->name;
        // $eventlog="Added Sales Receipt No.".$request->sales_receipt_no;
        // $AuditLog->log_id=$AuditLogcount;
        // $AuditLog->log_user_id=$username;
        // $AuditLog->log_event=$eventlog;
        // if($customer->display_name!=""){
        //     $AuditLog->log_name=$customer->display_name;
        // }else{
        //     if($customer->company_name!=""){
        //         $AuditLog->log_name=$customer->company_name;
        //     }else{
        //         $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
        //     }
        // }
        
        // $AuditLog->log_transaction_date=$request->sr_date;
        // $AuditLog->log_amount=$request->hiddentotaldebitamountsalesreceipt;
        // $AuditLog->save();
        if($request->reload_sr=='0'){
            $JDate=$request->sr_date;
            $JNo=$request->sales_receipt_no;
            $JMemo=$request->sr_memo;
            $account=$request->sales_receipt_account_debit_account;
            $debit= $request->sr_amount_paid!=0? $request->sr_amount_paid : '';
            $credit= $request->amountreceived_sr_c!=0? $request->amountreceived_sr_c : '';
            $description="";
            if($customer->display_name!=""){
                $name= $customer->display_name;
            }else{
                if($customer->company_name!=""){
                    $name= $customer->company_name;
                }else{
                    $name= $customer->f_name." ".$customer->l_name;
                }
            }
            
            $JournalVoucherCount=count(JournalEntry::where([
                ['journal_type','=','Journal Voucher']
            ])->groupBy('je_no')->get())+1;
            $current_year=date('y');
        
            $journalvoucher_no_series="";
            if($JournalVoucherCount<10){
                $journalvoucher_no_series="000".$JournalVoucherCount;
            }
            else if($JournalVoucherCount>9 && $JournalVoucherCount<100){
                $journalvoucher_no_series="00".$JournalVoucherCount;
            }else if($JournalVoucherCount>99 && $JournalVoucherCount<1000){
                $journalvoucher_no_series="0".$JournalVoucherCount;
            }
            
            $journalvoucher_no="JV".$current_year.$journalvoucher_no_series;
            $journal_series_no="";
            
            $journal_series_no=$journalvoucher_no;

            $journal_entries = new  JournalEntry;
            $jounal = DB::table('journal_entries')         ->select('je_no')         ->groupBy('je_no')         ->get();         $journal_entries_count=count($jounal)+1;
            $journal_entries->je_id = "1";
            $journal_entries->other_no=$JNo;
            $journal_entries->je_no=$journal_entries_count;
            $journal_entries->je_account=$account;
            $journal_entries->je_debit=$debit;
            $journal_entries->je_credit=$credit;
            $journal_entries->je_desc=$description;
            $journal_entries->je_name=$name;
            $journal_entries->je_memo=$JMemo;
            $journal_entries->created_at=$JDate;
            $journal_entries->je_attachment=$JDate;
            $journal_entries->je_transaction_type="Sales Receipt";
            $journal_entries->je_cost_center=$request->CostCenterSalesReceipt;
            $journal_entries->je_invoice_location_and_type=$request->sales_receipt_location_top." ".$request->sales_receipt_type_top;
            $journal_entries->journal_type="Journal Voucher";
		    $journal_entries->je_series_no=$journal_series_no;
            $journal_entries->save();

            for($c=1;$c<=$request->additional_count_cash_account;$c++){
                $account=$request->input('additionalcashDebitAccount'.$c);
                $debit=$request->input('additionalCashAmount'.$c)!=0? $request->input('additionalCashAmount'.$c) : '';
                $credit=$request->input('additionalCashAmount_c'.$c)!=0? $request->input('additionalCashAmount_c'.$c): '';
                if($customer->display_name!=""){
                    $name= $customer->display_name;
                }else{
                    if($customer->company_name!=""){
                        $name= $customer->company_name;
                    }else{
                        $name= $customer->f_name." ".$customer->l_name;
                    }
                }
                $data = new  JournalEntry;
                $data->je_id = $c+1;
                $data->other_no=$JNo;
                $data->je_no=$journal_entries_count;
                $data->je_account=$account;
                $data->je_debit=$debit;
                $data->je_credit=$credit;
                $data->je_desc=$description;
                $data->je_name=$name;
                $data->je_memo=$JMemo;
                $data->created_at=$JDate;
                $data->je_attachment=$JDate;
                $data->je_transaction_type="Sales Receipt";
                $data->je_cost_center=$request->CostCenterSalesReceipt;
                $data->je_invoice_location_and_type=$request->sales_receipt_location_top." ".$request->sales_receipt_type_top;
                $journal_entries->journal_type="Journal Voucher";
		    $journal_entries->je_series_no=$journal_series_no;
                $data->save();
            }
            
        }
        
        
        
        DB::connection('mysql')
        ->statement(
            DB::raw('UPDATE sales_transaction SET `st_balance`=?, `st_status`=? WHERE st_type=?'),
            array("0","Closed","Sales Receipt")
        );
        
    }
    public function check_sales_receipt_no(Request $request){
        $invoice_no_field=$request->invoice_no_field;
        $invoice_count=SalesTransaction::where([
            ['st_type','=','Sales Receipt'],
            ['st_no','=',$invoice_no_field]
        ])->count();

        return $invoice_count;
    }
    public function get_all_estimates(Request $request){
        $st_estimates = StEstimate::where('st_e_no', $request->id)->get();
        $products = ProductsAndServices::all();

        foreach($st_estimates as $estimate){
            foreach($products as $product){
                if($estimate->st_e_product == $product->product_id){
                    $estimate['st_e_product_name'] = $product->product_name;
                }
            }
         }

        return $st_estimates;
    }
    public function addcreditnote(Request $request){
        $sss=explode(" - ",$request->cn_customer);
        
        $sales_transaction = new SalesTransaction;
        $sales_transaction->st_no = $request->credit_note_no;
        $sales_transaction->st_date = $request->cn_date;
        $sales_transaction->st_type = $request->transaction_type_credit_note;
        $sales_transaction->st_term = null;
        $sales_transaction->st_customer_id = $sss[0];
        $sales_transaction->st_due_date = null;
        $sales_transaction->st_status = 'Closed';
        $sales_transaction->st_action = '';
        $sales_transaction->st_email = $request->cn_email;
        $sales_transaction->st_send_later = $request->cn_send_later;
        $sales_transaction->st_bill_address = $request->cn_bill_address;
        $sales_transaction->st_note = $request->cn_message;
        $sales_transaction->st_memo = $request->cn_memo;
        $sales_transaction->st_i_attachment = $request->cn_attachment;
        $sales_transaction->st_amount_paid = -$request->total_balance_credit_note;
        $sales_transaction->save();
        $customer = Customers::find($sss[0]);
        // $AuditLog= new AuditLog;
        // $AuditLogcount=AuditLog::count()+1;
        // $userid = Auth::user()->id;
        // $username = Auth::user()->name;
        // $eventlog="Added Credit Note No.".$request->credit_note_no;
        // $AuditLog->log_id=$AuditLogcount;
        // $AuditLog->log_user_id=$username;
        // $AuditLog->log_event=$eventlog;
        // $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
        // $AuditLog->log_transaction_date=$request->cn_date;
        // $AuditLog->log_amount="-".$request->total_balance_credit_note;
        // $AuditLog->save();
        $customer = new Customers;
        $customer = Customers::find($sss[0]);
        // $customer->opening_balance = $customer->opening_balance -$request->total_balance_credit_note;
        // $customer->save();
        $value;

        for($x=1;$x<=$request->product_count_credit_note;$x++){
            $st_credit_note = new StCreditNote;
            $st_credit_note->st_cn_no = $request->credit_note_no;
            $st_credit_note->st_cn_product = $request->input('select_product_name_credit_note'.$x);
            $st_credit_note->st_cn_desc = $request->input('select_product_description_credit_note'.$x);
            $st_credit_note->st_cn_qty = $request->input('product_qty_credit_note'.$x);
            
            $st_credit_note->st_cn_rate = preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_credit_note'.$x));
            $st_credit_note->st_cn_total = $request->input('product_qty_credit_note'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_credit_note'.$x));
            $st_credit_note->st_p_method = null;
            $st_credit_note->st_p_reference_no = null;
            $st_credit_note->st_p_deposit_to = null;
            $st_credit_note->st_p_amount = null;
            $st_credit_note->save();

            $JournalVoucherCount=count(JournalEntry::where([
                ['journal_type','=','Journal Voucher']
            ])->groupBy('je_no')->get())+1;
            $current_year=date('y');
        
            $journalvoucher_no_series="";
            if($JournalVoucherCount<10){
                $journalvoucher_no_series="000".$JournalVoucherCount;
            }
            else if($JournalVoucherCount>9 && $JournalVoucherCount<100){
                $journalvoucher_no_series="00".$JournalVoucherCount;
            }else if($JournalVoucherCount>99 && $JournalVoucherCount<1000){
                $journalvoucher_no_series="0".$JournalVoucherCount;
            }
            
            $journalvoucher_no="JV".$current_year.$journalvoucher_no_series;
            $journal_series_no="";
            
            $journal_series_no=$journalvoucher_no;


            $JDate=$request->cn_date;
            $JNo=$request->credit_note_no;
            $JMemo=$request->cn_memo;
            $account=$request->credit_note_account_debit_account;
            $debit= $request->input('product_qty_credit_note'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_credit_note'.$x));
            $credit= "";
            $description=$request->input('select_product_description_credit_note'.$x);
            $name= $customer->f_name." ".$customer->l_name;
            


            $journal_entries = new  JournalEntry;
            $jounal = DB::table('journal_entries')         ->select('je_no')         ->groupBy('je_no')         ->get();         $journal_entries_count=count($jounal)+1;
            $journal_entries->je_id = "1";
            $journal_entries->other_no=$JNo;
            $journal_entries->je_no=$journal_entries_count;
            $journal_entries->je_account=$account;
            $journal_entries->je_debit=$debit;
            $journal_entries->je_credit=$credit;
            $journal_entries->je_desc=$description;
            $journal_entries->je_name=$name;
            $journal_entries->je_memo=$JMemo;
            $journal_entries->created_at=$JDate;
            $journal_entries->je_attachment=$JDate;
            $journal_entries->je_transaction_type="Credit Note";
            
            $wwe=explode(" - ",$request->CostCenterCreditNote);
            $journal_entries->je_cost_center=$wwe[0];
            $journal_entries->journal_type="Journal Voucher";
		    $journal_entries->je_series_no=$journal_series_no;
            $journal_entries->save();

            $JDate=$request->cn_date;
            $JNo=$request->credit_note_no;
            $JMemo=$request->cn_memo;
            $account=$request->credit_note_account_credit_account;
            $debit= "";
            $credit= $request->input('product_qty_credit_note'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_credit_note'.$x));
            $description=$request->input('select_product_description_credit_note'.$x);
            $name= $customer->f_name." ".$customer->l_name;
            

            $journal_entries = new  JournalEntry;
            
            $journal_entries->je_id = "2";
            $journal_entries->other_no=$JNo;
            $journal_entries->je_no=$journal_entries_count;
            $journal_entries->je_account=$account;
            $journal_entries->je_debit=$debit;
            $journal_entries->je_credit=$credit;
            $journal_entries->je_desc=$description;
            $journal_entries->je_name=$name;
            $journal_entries->je_memo=$JMemo;
            $journal_entries->created_at=$JDate;
            $journal_entries->je_attachment=$JDate;
            $journal_entries->je_transaction_type="Credit Note";
            $wwe=explode(" - ",$request->CostCenterCreditNote);
            $journal_entries->je_cost_center=$wwe[0];
            $journal_entries->journal_type="Journal Voucher";
		    $journal_entries->je_series_no=$journal_series_no;
            $journal_entries->save();

        }
        
        
    }
    public function check_credit_note_no(Request $request){
        $invoice_no_field=$request->invoice_no_field;
        $invoice_count=SalesTransaction::where([
            ['st_type','=','Credit Note'],
            ['st_no','=',$invoice_no_field]
        ])->count();

        return $invoice_count;
    }
    public function addestimate(Request $request){
        $sss=explode(" - ",$request->e_customer);
        $numbering = Numbering::first();
        $sales_number = SalesTransaction::where('st_type','Estimate')->count() + $numbering->estimate_start_no;

        $sales_transaction = new SalesTransaction;
        $sales_transaction->st_no = $request->estimate_no;
        $sales_transaction->st_date = $request->e_date;
        $sales_transaction->st_type = $request->transaction_type_estimate;
        $sales_transaction->st_term = null;
        $sales_transaction->st_customer_id = $sss[0];
        $sales_transaction->st_due_date = $request->e_due_date;
        $sales_transaction->st_status = 'Pending';
        $sales_transaction->st_action = '';
        $sales_transaction->st_email = $request->e_email;
        $sales_transaction->st_send_later = $request->e_send_later;
        $sales_transaction->st_bill_address = $request->e_bill_address;
        $sales_transaction->st_note = $request->e_note;
        $sales_transaction->st_memo = $request->e_memo;
        $sales_transaction->st_i_attachment = $request->e_attachment;
        $sales_transaction->st_balance = $request->total_balance_estimate;
        $sales_transaction->save();

        $value;
       
        $customer = Customers::find($sss[0]);
        for($x=1;$x<=$request->product_count_estimate;$x++){
            $st_estimate = new StEstimate;
            $st_estimate->st_e_no = $request->estimate_no;
            $st_estimate->st_e_product = $request->input('select_product_name_estimate'.$x);
            $st_estimate->st_e_desc = $request->input('select_product_description_estimate'.$x)!=""? $request->input('select_product_description_estimate'.$x) : '';
            $st_estimate->st_e_qty = $request->input('product_qty_estimate'.$x);
            
            $st_estimate->st_e_rate = preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_estimate'.$x));
            $st_estimate->st_e_total = $request->input('product_qty_estimate'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_estimate'.$x));
            $st_estimate->st_p_method = null;
            $st_estimate->st_p_reference_no = null;
            $st_estimate->st_p_deposit_to = null;
            $st_estimate->save();
        }
        
            // $customer = Customers::find($sss[0]);
            // $AuditLog= new AuditLog;
            // $AuditLogcount=AuditLog::count()+1;
            // $userid = Auth::user()->id;
            // $username = Auth::user()->name;
            // $eventlog="Added Estimate";
            // $AuditLog->log_id=$AuditLogcount;
            // $AuditLog->log_user_id=$username;
            // $AuditLog->log_event=$eventlog;
            // $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
            // $AuditLog->log_transaction_date=$request->e_date;
            // $AuditLog->log_amount=$request->total_balance_estimate;
            // $AuditLog->save();
    }
    public function check_estimate_no(Request $request){
        $invoice_no_field=$request->invoice_no_field;
        $invoice_count=SalesTransaction::where([
            ['st_type','=','Estimate'],
            ['st_no','=',$invoice_no_field]
        ])->count();

        return $invoice_count;
    }
    public function AddInvoice(Request $request){	
        
		$sss=explode(" - ",$request->customer);
		
		
        $numbering = Numbering::first();
        $sales_number=0;
        
        $sales_transaction = new SalesTransaction;
        $sales_transaction->st_no = $request->invoice_invoiceno;
        $sales_transaction->st_date = $request->date;
        $sales_transaction->st_type = $request->transaction_type;
        $sales_transaction->st_term = $request->term;
        $sales_transaction->st_customer_id = $sss[0];
        $sales_transaction->st_due_date = $request->due_date;
        $sales_transaction->st_status = 'Open';
        $sales_transaction->st_action = '';
        $sales_transaction->st_email = $request->email;
        //$sales_transaction->st_send_later = $request->send_later;
        $sales_transaction->st_bill_address = $request->bill_address;
        $sales_transaction->st_note = $request->note;
        $sales_transaction->st_memo = $request->memo;
        //$sales_transaction->st_i_attachment = $request->attachment;
        $sales_transaction->st_balance = $request->total_balance;
        $sales_transaction->st_invoice_job_order = $request->job_order_invoice;
        $sales_transaction->st_invoice_work_no = $request->work_no_invoice;
        $sales_transaction->st_debit_account = "";
        $sales_transaction->st_credit_account = "";
        
        $sales_transaction->st_location = $request->invoice_location_top;
        $sales_transaction->st_invoice_type = $request->invoice_type_top;
        $sales_transaction->save();

        $customer = new Customers;
        $customer = Customers::find($sss[0]);
        $customer_name="";
            if ($customer->display_name!=""){
                $customer_name=$customer->display_name;
            }else{
                if ($customer->company_name!=""){
                    $customer_name=$customer->company_name;
                }else{
                    $customer_name=$customer->f_name." ".$customer->l_name;
                }
            }
        $value;
        for($x=1;$x<=$request->product_count;$x++){
            $x2=$x;
            $st_invoice = new StInvoice;
            $st_invoice->st_i_no = $request->invoice_invoiceno;
            $st_invoice->st_i_item_no = $x2;
            
            $st_invoice->st_i_product = $request->input('select_product_name'.$x);
            $st_invoice->st_i_desc = $request->input('select_product_description'.$x);
            $st_invoice->st_i_qty = $request->input('product_qty'.$x);
            $st_invoice->st_i_rate = preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate'.$x));
            $st_invoice->st_i_total = $request->input('product_qty'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate'.$x));
            $st_invoice->st_p_method = null;
            $st_invoice->st_p_reference_no = null;
            $st_invoice->st_p_deposit_to = null;
            $st_invoice->st_p_location = $request->invoice_location_top;
            $st_invoice->st_p_invoice_type = $request->invoice_type_top;
            $wwe=explode(" - ",$request->input('CostCenterInvoice'.$x2));
            $st_invoice->st_p_cost_center=$wwe[0];
            $st_invoice->st_p_debit = $request->input('invoice_account_debit_account'.$x2);
            $st_invoice->st_p_credit = $request->input('invoice_account_credit_account'.$x2);
            $st_invoice->save();

            $JDate=$request->date;
            $JNo=$request->invoice_invoiceno;
            $JMemo=$request->memo;
            $account=$request->input('invoice_account_debit_account'.$x2);
            $debit= $request->input('product_qty'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate'.$x));
            $credit= "";
            $description=$request->input('select_product_description'.$x);
            $name= $customer_name;

            $JournalVoucherCount=count(JournalEntry::where([
                ['journal_type','=','Journal Voucher']
            ])->groupBy('je_no')->get())+1;
            $current_year=date('y');
    
            $journalvoucher_no_series="";
            if($JournalVoucherCount<10){
                $journalvoucher_no_series="000".$JournalVoucherCount;
            }
            else if($JournalVoucherCount>9 && $JournalVoucherCount<100){
                $journalvoucher_no_series="00".$JournalVoucherCount;
            }else if($JournalVoucherCount>99 && $JournalVoucherCount<1000){
                $journalvoucher_no_series="0".$JournalVoucherCount;
            }
           
            $journalvoucher_no="JV".$current_year.$journalvoucher_no_series;
            $journal_series_no="";
            
            $journal_series_no=$journalvoucher_no;
            
            $journal_entries = new  JournalEntry;
            $jounal = DB::table('journal_entries')         ->select('je_no')         ->groupBy('je_no')         ->get();         $journal_entries_count=count($jounal)+1;
            $journal_entries->je_id = "1";
            $journal_entries->other_no=$JNo;
            $journal_entries->je_no=$journal_entries_count;
            $journal_entries->je_account=$account;
            $journal_entries->je_debit=$debit;
            $journal_entries->je_credit=$credit;
            $journal_entries->je_desc=$description;
            $journal_entries->je_name=$name;
            $journal_entries->je_memo=$JMemo;
            $journal_entries->created_at=$JDate;
            $journal_entries->je_attachment=$JDate;
            $journal_entries->je_transaction_type="Invoice";
            $journal_entries->je_invoice_location_and_type=$request->invoice_location_top." ".$request->invoice_type_top;
            $wwe=explode(" - ",$request->input('CostCenterInvoice'.$x2));
            $journal_entries->je_cost_center=$wwe[0];
            $journal_entries->journal_type="Journal Voucher";
		    $journal_entries->je_series_no=$journal_series_no;
            $journal_entries->save();

            $JDate=$request->date;
            $JNo=$request->invoice_invoiceno;
            $JMemo=$request->memo;
            $account=$request->input('invoice_account_credit_account'.$x2);
            $debit= "";
            $credit= $request->input('product_qty'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate'.$x));
            $description=$request->input('select_product_description'.$x);
            $name= $customer_name;
            

            $journal_entries = new  JournalEntry;
            
            $journal_entries->je_id = "2";
            $journal_entries->other_no=$JNo;
            $journal_entries->je_no=$journal_entries_count;
            $journal_entries->je_account=$account;
            $journal_entries->je_debit=$debit;
            $journal_entries->je_credit=$credit;
            $journal_entries->je_desc=$description;
            $journal_entries->je_name=$name;
            $journal_entries->je_memo=$JMemo;
            $journal_entries->created_at=$JDate;
            $journal_entries->je_attachment=$JDate;
            $journal_entries->je_transaction_type="Invoice";
            $journal_entries->je_invoice_location_and_type=$request->invoice_location_top." ".$request->invoice_type_top;
			$wwe=explode(" - ",$request->input('CostCenterInvoice'.$x2));
            $journal_entries->je_cost_center=$wwe[0];
            $journal_entries->journal_type="Journal Voucher";
		    $journal_entries->je_series_no=$journal_series_no;
            $journal_entries->save();


            $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate'.$x));
            $customer->save();


        }
        if($request->sales_transaction_number_estimate != ''){
            $sales_transaction_estimate = SalesTransaction::where('st_no', $request->sales_transaction_number_estimate)->first();
            $sales_transaction_estimate->st_status = "Closed";
            $sales_transaction_estimate->save();
        }
        // $AuditLog= new AuditLog;
        //     $AuditLogcount=AuditLog::count()+1;
        //     $userid = Auth::user()->id;
        //     $username = Auth::user()->name;
        //     $eventlog="Added Invoice No. ".$request->invoice_invoiceno;
        //     $AuditLog->log_id=$AuditLogcount;
        //     $AuditLog->log_user_id=$username;
        //     $AuditLog->log_event=$eventlog;
        //     $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
        //     $AuditLog->log_transaction_date=$request->date;
        //     $AuditLog->log_amount=$request->total_balance;
        //     $AuditLog->save(); 
        
        
    }
    public function fetch_customer_info(Request $request){
        $customer_id=$request->value;
        $customers = Customers::where([
            ['customer_id','=',$customer_id]
        ])->first();
        $data = array(
            'customers' => $customers,
        );
        return response($data, 200);
    }
    public function check_invoice_no(Request $request){
        $invoice_location_top=$request->invoice_location_top;
        $invoice_type_top=$request->invoice_type_top;
        $invoice_no_field=$request->invoice_no_field;
        $invoice_count=SalesTransaction::where([
            ['st_type','=','Invoice'],
            ['st_location', '=', $invoice_location_top],
            ['st_invoice_type','=',$invoice_type_top],
            ['st_no','=',$invoice_no_field]
        ])->count();

        return $invoice_count;
    }
    public function getInvoiceModalInfo(Request $request){
        $numbering = Numbering::first();
        $branch_Sales_invoice_count=SalesTransaction::where([
            ['st_type','=','Invoice'],
            ['st_location', '=', 'Branch'],
            ['st_invoice_type','=','Sales Invoice']
        ])->count();
        $branch_Bill_invoice_count=SalesTransaction::where([
            ['st_type','=','Invoice'],
            ['st_location', '=', 'Branch'],
            ['st_invoice_type','=','Bill Invoice']
        ])->count();
        $main_Bill_invoice_count=SalesTransaction::where([
            ['st_type','=','Invoice'],
            ['st_location', '=', 'Main'],
            ['st_invoice_type','=','Bill Invoice']
        ])->count();
        $invoice_count=SalesTransaction::where([
            ['st_type','=','Invoice'],
            ['st_location', '=', 'Main'],
            ['st_invoice_type','=','Sales Invoice']
        ])->count();
        $customers = Customers::where([
            ['supplier_active','=','1']
        ])->get();
        $products_and_services = ProductsAndServices::all();
        $COA= ChartofAccount::where('coa_active','1')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        $estimate_count=SalesTransaction::where('st_type','Estimate')->count();
        $credit_note_count=SalesTransaction::where('st_type','Credit Note')->count();
        $sales_receipt_count=SalesTransaction::where('st_type','Sales Receipt')->count();
        $data = array(
            'branch_Sales_invoice_count' => $branch_Sales_invoice_count,
            'branch_Bill_invoice_count' => $branch_Bill_invoice_count,
            'main_Bill_invoice_count' => $main_Bill_invoice_count,
            'invoice_count' => $invoice_count,
            'customers' => $customers,
            'products_and_services' => $products_and_services,
            'COA' => $COA,
            'cost_center_list' => $cost_center_list,
            'numbering'=> $numbering,
            'estimate_count' =>$estimate_count,
            'credit_note_count' =>$credit_note_count,
            'sales_receipt_count' => $sales_receipt_count,
        );
        return response($data, 200);
    }
    public function UploadMassInvoice(Request $request){
        $error_count=0;
        $saved_count=0;
        $countloop=0;
        $extra="";
        $Log="";
        $file = $request->file('theFile');
        $path = $file->getRealPath();
        $data = Excel::selectSheetsByIndex(0)->load($path, function($reader) {
        })->get();

        $JournalGroup = array();
        foreach($data as $row){
            array_push($JournalGroup, $row->invoice_group_no); 
        }
        $GRROUP=array_unique($JournalGroup);
        foreach($GRROUP as $unique){
            $credit=0;
            $countloop=0;
            $debit=0;
            $rowcount=1;
            $valid=0;
            $individualcount=0;
            foreach($data as $row){
                $rowcount++;
                $countloop++;
                $extra.=$row;
                if($row->invoice_group_no==$unique){
                    $individualcount++;
                    if($row->invoice_group_no!=""){
                        if($row->location!=""){
                            if($row->invoice_type!=""){
                                if($row->invoice_date!=""){
                                    
                                        
                                            if($row->client!=""){
                                                
                                                        if($row->total_amount!=""){
                                                            if($row->debit_account!=""){
                                                                if($row->credit_account!=""){
                                                                    $sss=explode(" -- ",$row->client);
		
		
                                                                    $numbering = Numbering::first();
                                                                    $sales_number=0;
                                                                    if($row->location=="Main"){
                                                                        if($row->invoice_type=="Sales Invoice"){
                                                                            $sales_number = SalesTransaction::where([
                                                                                ['st_type','=','Invoice'],
                                                                                ['st_location', '=', 'Main'],
                                                                                ['st_invoice_type','=','Sales Invoice']
                                                                            ])->count() + $numbering->sales_exp_start_no;
                                                                        }else if($row->invoice_type=="Bill Invoice"){
                                                                            $sales_number = SalesTransaction::where([
                                                                                ['st_type','=','Invoice'],
                                                                                ['st_location', '=', 'Main'],
                                                                                ['st_invoice_type','=','Bill Invoice']
                                                                            ])->count() + $numbering->numbering_bill_invoice_main;
                                                                        }
                                                                    }else if($row->location=="Branch"){
                                                                        if($row->invoice_type=="Sales Invoice"){
                                                                            $sales_number = SalesTransaction::where([
                                                                                ['st_type','=','Invoice'],
                                                                                ['st_location', '=', 'Branch'],
                                                                                ['st_invoice_type','=','Sales Invoice']
                                                                            ])->count() + $numbering->numbering_sales_invoice_branch;
                                                                        }else if($row->invoice_type=="Bill Invoice"){
                                                                            $sales_number = SalesTransaction::where([
                                                                                ['st_type','=','Invoice'],
                                                                                ['st_location', '=', 'Branch'],
                                                                                ['st_invoice_type','=','Bill Invoice']
                                                                            ])->count() + $numbering->numbering_bill_invoice_branch;
                                                                        }
                                                                    }
                                                                    $sales_transaction = new SalesTransaction;
                                                                    $sales_transaction->st_no = $sales_number;
                                                                    $sales_transaction->st_date = $row->invoice_date;
                                                                    $sales_transaction->st_type = "Invoice";
                                                                    $sales_transaction->st_term = "";
                                                                    $sales_transaction->st_customer_id = $sss[0];
                                                                    $sales_transaction->st_due_date = $row->due_date;
                                                                    $sales_transaction->st_invoice_job_order = $row->job_order;
                                                                    $sales_transaction->st_invoice_work_no = $row->work_no;
                                                                    $sales_transaction->st_status = 'Open';
                                                                    $sales_transaction->st_action = '';
                                                                    $sales_transaction->st_email = "";
                                                                    $sales_transaction->st_send_later = "";
                                                                    $sales_transaction->st_bill_address = "";
                                                                    $sales_transaction->st_note ="";
                                                                    $sales_transaction->st_memo = "";
                                                                    $sales_transaction->st_i_attachment = "";
                                                                    $cre=explode(" -- ",$row->debit_account);
                                                                    $account=$cre[0];
                                                                    $sales_transaction->st_debit_account = $account;
                                                                    $cre=explode(" -- ",$row->credit_account);
                                                                    $account=$cre[0];
                                                                    $sales_transaction->st_credit_account = $account;
                                                                    
                                                                    $total_balance=0;
                                                                    $customer = new Customers;
                                                                    $customer = Customers::find($sss[0]);
                                                                    foreach($data as $row2){
                                                                        if($row2->invoice_group_no==$unique){
                                                                            if($row2->invoice_group_no!=""){
                                                                                if($row2->location!=""){
                                                                                    if($row2->invoice_type!=""){
                                                                                        if($row2->invoice_date!=""){
                                                                                           
                                                                                               
                                                                                                    if($row2->client!=""){
                                                                                                        
                                                                                                            
                                                                                                                if($row2->total_amount!=""){
                                                                                                                    $st_invoice = new StInvoice;
                                                                                                                    $st_invoice->st_i_no = $sales_number;
                                                                                                                    $st_invoice->st_i_product = $row2->productservice;
                                                                                                                    $st_invoice->st_i_desc = $row2->description;
                                                                                                                    $st_invoice->st_i_qty = 1;
                                                                                                                    $st_invoice->st_i_rate = $row2->total_amount;
                                                                                                                    $st_invoice->st_i_total = $row2->total_amount;
                                                                                                                    $st_invoice->st_p_method = null;
                                                                                                                    $st_invoice->st_p_reference_no = null;
                                                                                                                    $st_invoice->st_p_deposit_to = null;
                                                                                                                    $st_invoice->st_p_location = $row2->location;
                                                                                                                    $st_invoice->st_p_invoice_type = $row2->invoice_type;
                                                                                                                    $st_invoice->st_p_debit = $row2->debit_account;
                                                                                                                    $st_invoice->st_p_credit = $row2->credit_account;
                                                                                                                    
                                                                                                                    $wwe=explode(" -- ",$row2->cost_center);
                                                                                                                    // $COA= CostCenter::where('cc_name_code',$wwe[0])->get();
                                                                                                                    $CostCenter=$wwe[0];
                                                                                                                    
                                                    
                                                                                                                    $st_invoice->st_p_cost_center=$CostCenter;
                                                                                                                    $st_invoice->save();
                                                                                                                    $total_balance+=$row2->total_amount;

                                                                                                                    $JournalVoucherCount=count(JournalEntry::where([
                                                                                                                        ['journal_type','=','Journal Voucher']
                                                                                                                    ])->groupBy('je_no')->get())+1;
                                                                                                                    $current_year=date('y');
                                                                                                                
                                                                                                                    $journalvoucher_no_series="";
                                                                                                                    if($JournalVoucherCount<10){
                                                                                                                        $journalvoucher_no_series="000".$JournalVoucherCount;
                                                                                                                    }
                                                                                                                    else if($JournalVoucherCount>9 && $JournalVoucherCount<100){
                                                                                                                        $journalvoucher_no_series="00".$JournalVoucherCount;
                                                                                                                    }else if($JournalVoucherCount>99 && $JournalVoucherCount<1000){
                                                                                                                        $journalvoucher_no_series="0".$JournalVoucherCount;
                                                                                                                    }
                                                                                                                    
                                                                                                                    $journalvoucher_no="JV".$current_year.$journalvoucher_no_series;
                                                                                                                    $journal_series_no="";
                                                                                                                    
                                                                                                                    $journal_series_no=$journalvoucher_no;

                                                                                                                    $JDate=$row->invoice_date;
                                                                                                                    $JNo=$sales_number;
                                                                                                                    $JMemo="";
                                                                                                                    $cre=explode(" -- ",$row2->credit_account);
                                                                                                                    $account=$cre[0];
                                                                                                                    $debit= "";
                                                                                                                    $credit= $row2->total_amount;
                                                                                                                    $description=$row2->description;
                                                                                                                    $name= $customer->display_name;
                                                                                                                    

                                                                                                                    $journal_entries = new  JournalEntry;
                                                                                                                    $jounal = DB::table('journal_entries')         ->select('je_no')         ->groupBy('je_no')         ->get();         
                                                                                                                    $journal_entries_count=count($jounal)+1;
                                                                                                                    $journal_entries->je_id = "1";
                                                                                                                    $journal_entries->other_no=$JNo;
                                                                                                                    $journal_entries->je_no=$journal_entries_count;
                                                                                                                    $journal_entries->je_account=$account;
                                                                                                                    $journal_entries->je_debit=$debit;
                                                                                                                    $journal_entries->je_credit=$credit;
                                                                                                                    $journal_entries->je_desc=$description;
                                                                                                                    $journal_entries->je_name=$name;
                                                                                                                    $journal_entries->je_memo=$JMemo;
                                                                                                                    $journal_entries->created_at=$JDate;
                                                                                                                    $journal_entries->je_attachment=$JDate;
                                                                                                                    $journal_entries->je_attachment=$JDate;
                                                                                                                    $journal_entries->je_transaction_type="Invoice";
                                                                                                                    $journal_entries->je_invoice_location_and_type=$row->location." ".$row->invoice_type;
                                                                                                                    
                                                                                                                    $journal_entries->je_cost_center=$CostCenter;
                                                                                                                    $journal_entries->journal_type="Journal Voucher";
		                                                                                                            $journal_entries->je_series_no=$journal_series_no;
                                                                                                                    $journal_entries->save();
                                                
                                                                                                                    $JDate=$row->invoice_date;
                                                                                                                    $JNo=$sales_number;
                                                                                                                    $JMemo="";
                                                                                                                    $cre=explode(" -- ",$row2->debit_account);
                                                                                                                    $account=$cre[0];
                                                                                                                    $debit= $row2->total_amount;
                                                                                                                    $credit= "";
                                                                                                                    $description=$row2->description;
                                                                                                                    $name= $customer->display_name;
                                                                                                                    
                                                
                                                                                                                    $journal_entries = new  JournalEntry;
                                                                                                                    
                                                                                                                    $journal_entries->je_id = "2";
                                                                                                                    $journal_entries->other_no=$JNo;
                                                                                                                    $journal_entries->je_no=$journal_entries_count;
                                                                                                                    $journal_entries->je_account=$account;
                                                                                                                    $journal_entries->je_debit=$debit;
                                                                                                                    $journal_entries->je_credit=$credit;
                                                                                                                    $journal_entries->je_desc=$description;
                                                                                                                    $journal_entries->je_name=$name;
                                                                                                                    $journal_entries->je_memo=$JMemo;
                                                                                                                    $journal_entries->created_at=$JDate;
                                                                                                                    $journal_entries->je_attachment=$JDate;
                                                                                                                    $journal_entries->je_attachment=$JDate;
                                                                                                                    $journal_entries->je_transaction_type="Invoice";
                                                                                                                    $journal_entries->je_invoice_location_and_type=$row->location." ".$row->invoice_type;
                                                                                                                    
                                                                                                                    $journal_entries->je_cost_center=$CostCenter;
                                                                                                                    $journal_entries->journal_type="Journal Voucher";
		                                                                                                            $journal_entries->je_series_no=$journal_series_no;
                                                                                                                    $journal_entries->save();
                                                                                                                }
                                                                                                            
                                                                                                        
                                                                                                    }
                                                                                            
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                        
                                                                    }

                                                                    
                                                                    $sales_transaction->st_balance = $total_balance;
        
                                                                    $sales_transaction->st_location = $row->location;
                                                                    $sales_transaction->st_invoice_type = $row->invoice_type;
                                                                    $sales_transaction->save();
        
                                                                    
                                                                    $customer->opening_balance = $customer->opening_balance+$total_balance;
                                                                    $customer->save();
                                                                    $saved_count++;
                                                                }else{
                                                                    $valid=1; 
                                                                    //empty first name
                                                                    //$error_count++;
                                                                    $Log.="Empty Credit Account on row ".$rowcount." from file.\n";  
                                                                }
                                                            }else{
                                                                $valid=1; 
                                                                //empty first name
                                                                //$error_count++;
                                                                $Log.="Empty Debit on row ".$rowcount." from file.\n";  
                                                            }
                                                            
                                                        }else{
                                                            $valid=1; 
                                                            //empty first name
                                                            //$error_count++;
                                                            $Log.="Empty Total Amount on row ".$rowcount." from file.\n";  
                                                        }
                                                    
                                            }else{
                                                $valid=1; 
                                                //empty first name
                                                //$error_count++;
                                                $Log.="Empty Client on row ".$rowcount." from file.\n";  
                                            }
                                        
                                    
                                }else{
                                    $valid=1; 
                                    //empty first name
                                    //$error_count++;
                                    $Log.="Empty Invoice Date on row ".$rowcount." from file.\n";  
                                }
                            }else{
                                $valid=1; 
                                //empty first name
                                //$error_count++;
                                $Log.="Empty Invoice Type on row ".$rowcount." from file.\n";  
                            }
                        }else{
                            $valid=1; 
                            //empty first name
                            //$error_count++;
                            $Log.="Empty Location on row ".$rowcount." from file.\n";  
                        }
                       
                    }else{
                        $valid=1; 
                        //empty first name
                        //$error_count++;
                        $Log.="Empty Invoice Group No on row ".$rowcount." from file.\n";  
                    }
                    break;
                }
            }

        }



        $data = array(
            'Success' => $saved_count,
            'Total' => $countloop,
            'Skiped'  => $error_count,
            'Error_Log' =>$Log,
            'Extra'=>$extra
        );
        return json_encode($data);

    }
    public function GetInvoiceExcelTemplate(Request $request){
        Excel::load('extra/edit_excel/invoice.xlsx', function($doc) {
        $customers = Customers::all();
        $cost_center_list= CostCenter::where('cc_status','1')->get();
        $COA= ChartofAccount::where('coa_active','1')->get();
        $sheet2 = $doc->setActiveSheetIndex(1);
        $sheet3 = $doc->setActiveSheetIndex(2);
        $sheet4 = $doc->setActiveSheetIndex(3);
        $sheet = $doc->setActiveSheetIndex(0);
        $sheet->getStyle("D")
                ->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
        $sheet->getStyle("E")
                ->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);        
        $cuss=0;
        $cccc=0;
        $oro=0;
        foreach($customers as $cus){
            $cuss++;
            $sheet2->setCellValue('A'.$cuss, $cus->customer_id." -- ".($cus->display_name==""? $cus->f_name." ".$cus->l_name : $cus->display_name));
            
            
        }
        foreach($COA as $coa){
            $oro++;
            $sheet4->setCellValue('A'.$oro, $coa->id." -- ".$coa->coa_name);
            // $sheet4->setCellValue('B'.$oro, $coa->coa_name);
            
        }
        foreach($cost_center_list as $ccl){
            $cccc++;
            $sheet3->setCellValue('A'.$cccc, $ccl->cc_no." -- ".$ccl->cc_name);
            //$sheet3->setCellValue('B'.$cccc, $ccl->cc_name);
        }
        for($c=1;$c<=$cccc+$cuss+$oro;$c++){
            // $sheet->$doc->addNamedRange(
            //     new \PHPExcel_NamedRange(
            //     'Accounts', $sheet, 'L1:L'.$oro
            //     )
            // );
            $cplus=$c+1;
            $objValidation = $sheet->getCell('F'.$cplus)->getDataValidation();
            $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
            
            $objValidation->setShowDropDown( true );
            $objValidation->setFormula1('CostCenter!$A:$A');

            $objValidation = $sheet->getCell('G'.$cplus)->getDataValidation();
            $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
            
            $objValidation->setShowDropDown( true );
            $objValidation->setFormula1('Clients!$A:$A');

            $objValidation = $sheet->getCell('M'.$cplus)->getDataValidation();
            $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
            
            $objValidation->setShowDropDown( true );
            $objValidation->setFormula1('ChartofAccounts!$A:$A');
            $objValidation = $sheet->getCell('N'.$cplus)->getDataValidation();
            $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
            
            $objValidation->setShowDropDown( true );
            $objValidation->setFormula1('ChartofAccounts!$A:$A');

            $objValidation = $sheet->getCell('B'.$cplus)->getDataValidation();
            $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
            
            $objValidation->setShowDropDown( true );
            $objValidation->setFormula1('Clients!$Y1:$Y2');
            $objValidation = $sheet->getCell('C'.$cplus)->getDataValidation();
            $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
            
            $objValidation->setShowDropDown( true );
            $objValidation->setFormula1('Clients!$Z1:$Z2');
            
            //$objValidation->setFormula1('Accounts'); //note this!
        }
        })->setFilename('Import Template for Invoice '.date('m-d-Y'))->download('xlsx');

    }
    public function add_supplier(Request $request){
        
        $customer = new Customers;
        $customer->customer_id = Customers::count() + 1;
        $customer->f_name = $request->fname;
        $customer->l_name = $request->lname;
        $customer->email = $request->email;
        $customer->company = $request->company;
        $customer->phone = $request->phone;
        $customer->mobile = $request->mobile;
        $customer->fax = $request->fax;
        $customer->display_name = $request->displayname;
        $customer->other = $request->other;
        $customer->website = $request->website;
        $customer->street = $request->street;
        $customer->city = $request->city;
        $customer->state = $request->state;
        $customer->postal_code = $request->postalcode;
        $customer->country = $request->country;
        $customer->payment_method = $request->billingrate;
        $customer->terms = $request->terms;
        $customer->opening_balance = $request->balance;
        $customer->as_of_date = $request->asof;
        $customer->account_no = $request->accountno;
        $customer->business_id_no = $request->businessno;
        $customer->notes = $request->notes;
        $customer->attachment = $request->fileattachment;
        $customer->tin_no=$request->tin_no;
        $customer->tax_type=$request->tax_type;
        $customer->vat_value=$request->vat_value;
        $customer->business_style=$request->business_style;
        $customer->supplier_active="1";
        $customer->account_type="Supplier";
        $customer->save();
		
        //return redirect('/expenses')->with('success','Successfully Added A New Supplier');
    }
    public function UploadMassSupplier(Request $request){
        $error_count=0;
        $saved_count=0;
        $countloop=0;
        $extra="";
        $Log="";
        $file = $request->file('theFile');
        $path = $file->getRealPath();
        $data = Excel::load($path, function($reader) {
        })->get();
        $supplier = Customers::all();
        $rowcount=0;
        $extra=$data;
        
        foreach($data as $row){
            $rowcount++;
            $countloop++;
            $extra.=$row;
            
                $duplicate=0;
                foreach($supplier as $cus){
                    if($cus->display_name==$row->display_name_as && $row->display_name_as!=""){
                        $duplicate=1;
                    }
                }

                if($duplicate==0){
                        $customer = new Customers;
                        $customer->customer_id = Customers::count() + 1;
                        $customer->f_name = $row->first_name;
                        $customer->l_name = $row->last_name;
                        $customer->email = $row->email;
                        $customer->company = $row->company_name;
                        $customer->phone = $row->phone;
                        $customer->mobile = $row->mobile;
                        $customer->fax = $row->fax;
                        $customer->display_name = $row->display_name_as;
                        $customer->other = $row->other;
                        $customer->website = $row->website;
                        $customer->street = $row->street;
                        $customer->city = $row->citytown;
                        $customer->state = $row->stateprovince;
                        $customer->postal_code = $row->postal_code;
                        $customer->country = $row->country;
                        $customer->payment_method = $row->billing_ratehr;
                        $customer->terms = $row->terms;
                        $customer->opening_balance = $row->opening_balance;
                        $customer->account_no = $row->account_no;
                        $customer->business_id_no = $row->business_id_no;
                        $customer->tin_no=$row->tin_no;
                        $customer->tax_type=$row->tax;
                        $customer->vat_value=$row->vat_value;
                        $customer->business_style=$row->business_style;
                        $customer->account_type="Supplier";
                        $customer->supplier_active="1";
                        $customer->save();
                        // $AuditLog= new AuditLog;
                        // $AuditLogcount=AuditLog::count()+1;
                        // $userid = Auth::user()->id;
                        // $username = Auth::user()->name;
                        // $eventlog="Added Supplier";
                        // $AuditLog->log_id=$AuditLogcount;
                        // $AuditLog->log_user_id=$username;
                        // $AuditLog->log_event=$eventlog;
                        // $AuditLog->log_name="";
                        // $AuditLog->log_transaction_date="";
                        // $AuditLog->log_amount="";
                        // $AuditLog->save();
                        $saved_count++;
                }else{
                    //empty last name
                     $error_count++;
                     $Log.="Duplicate Display Name on row ".$rowcount." from file.\n";  
                }
            
            
            
                    


        }

        
        $data = array(
            'Success' => $saved_count,
            'Total' => $countloop,
            'Skiped'  => $error_count,
            'Error_Log' =>$Log,
            'Extra'=>$extra
        );
        return json_encode($data);
    }
    public function GetSupplierTemplateExcel(Request $request){
        Excel::load('extra/edit_excel/Supplier_Import Data.xlsx', function($doc) {
        
        })->setFilename('Import Template for Supplier '.date('m-d-Y'))->download('xlsx');
    }
    public function getExpenseTransactionPage(Request $request){
        $supplierss = Customers::where([
            ['account_type','=','Supplier'],
            ['supplier_active','=','1']
        ])->get();
        $data = array(
            'supplierss' => $supplierss,
            
        );
        return response($data, 200);
    }
    public function add_customer(Request $request){
        $customer = new Customers;
        $customer->customer_id = Customers::count() + 1;
        $customer->f_name = $request->f_name;
        $customer->l_name = $request->l_name;
        $customer->email = $request->email;
        $customer->company = $request->company;
        $customer->phone = $request->phone;
        $customer->mobile = $request->mobile;
        $customer->fax = $request->fax;
        $customer->display_name = $request->display_name;
        $customer->other = $request->other;
        $customer->website = $request->website;
        $customer->street = $request->street;
        $customer->city = $request->city;
        $customer->state = $request->state;
        $customer->postal_code = $request->postal_code;
        $customer->country = $request->country;
        $customer->payment_method = $request->payment_method;
        $customer->terms = $request->terms;
        $customer->opening_balance = $request->opening_balance;
        $customer->as_of_date = $request->as_of_date;
        $customer->account_no = $request->account_no;
        $customer->business_id_no = $request->business_id_no;
        $customer->notes = $request->notes;
        $customer->attachment = $request->attachment;
        $customer->tin_no=$request->tin_no;
        $customer->withhold_tax=$request->withholdingtax;
        $customer->business_style=$request->business_style;
        $customer->save();

    }
    public function UploadMassCustomer(Request $request){
        $error_count=0;
        $saved_count=0;
        $countloop=0;
        $extra="";
        $Log="";
        $file = $request->file('theFile');
        $path = $file->getRealPath();
        $data = Excel::load($path, function($reader) {
        })->get();
        $customers = Customers::all();
        $rowcount=0;
        foreach($data as $row){
            $rowcount++;
            $countloop++;
            
                    $duplicate=0;
                    foreach($customers as $cus){
                        if($cus->display_name==$row->display_name_as && $row->display_name_as!=""){
                            $duplicate=1;
                        }
                    }

                    if($duplicate==0){
                        $extra.=$row->display_name_as."\n";
                        $customer = new Customers;
                        $customer->customer_id = Customers::count() + 1;
                        $customer->f_name = $row->first_name;
                        $customer->l_name = $row->last_name;
                        $customer->email = $row->email;
                        $customer->company = $row->company_name;
                        $customer->phone = $row->phone;
                        $customer->mobile = $row->mobile;
                        $customer->fax = $row->fax;
                        $customer->display_name = $row->display_name_as;
                        $customer->other = $row->other;
                        $customer->website = $row->website;
                        $customer->street = $row->street;
                        $customer->city = $row->citytown;
                        $customer->state = $row->stateprovince;
                        $customer->postal_code = $row->postal_code;
                        $customer->country = $row->country;
                        $customer->payment_method = $row->payment_method;
                        $customer->terms = $row->terms;
                        $customer->opening_balance = $row->opening_balance;
                        $customer->as_of_date = date('Y-m-d');
                        $customer->account_no = $row->account_no;
                        $customer->business_id_no = $row->business_id_no;
                        $customer->tin_no=$row->tin_no;
                        if($row->withholding_tax==""){
                            $customer->withhold_tax="12";
                        }else{
                            $customer->withhold_tax=$row->withholding_tax;
                        }
                        
                        $customer->business_style=$row->business_style;
                        $customer->account_type="Customer";
                        $customer->save();

                        // $AuditLog= new AuditLog;
                        //     $AuditLogcount=AuditLog::count()+1;
                        //     $userid = Auth::user()->id;
                        //     $username = Auth::user()->name;
                        //     $eventlog="Added Customer";
                        //     $AuditLog->log_id=$AuditLogcount;
                        //     $AuditLog->log_user_id=$username;
                        //     $AuditLog->log_event=$eventlog;
                        //     $AuditLog->log_name="";
                        //     $AuditLog->log_transaction_date="";
                        //     $AuditLog->log_amount="";
                        //     $AuditLog->save();
                            $saved_count++;
                    }else{
                        //empty last name
                         $error_count++;
                         $Log.="Duplicate Display Name on row ".$rowcount." from file.\n";  
                    }

            

        }

        
        $data = array(
            'Success' => $saved_count,
            'Total' => $countloop,
            'Skiped'  => $error_count,
            'Error_Log' =>$Log,
            'Extra'=>$extra
        );
        return json_encode($data);
    }
    public function GetCustomerTemplateExcel(Request $request){
        Excel::load('extra/edit_excel/Customer_Import Data.xlsx', function($doc) {
        
        })->setFilename('Import Template for Customer '.date('m-d-Y'))->download('xlsx');
    }
    public function update_product(Request $request){
        
        $user=ProductAndServicesEdit::find($request->prod_id);
        if(empty($user)){
            $user = new ProductAndServicesEdit;
        }
        $user->product_id=$request->prod_id;
        $user->product_name=$request->prod_name;
        $user->product_sku=$request->prod_sku;
        $user->product_type=$request->prod_category;
        $user->product_sales_description=$request->prod_desc;
        $user->product_sales_price=$request->prod_price;
        $user->product_cost=$request->prod_cost;
        $user->product_qty=$request->prod_qty;
        $user->product_reorder_point=$request->prod_reorder_point;
        $user->edit_status="0";
        $user->save();
       
    }
    public function save_product_services(Request $request){
        $user= new ProductsAndServices;
        $user->product_id=ProductsAndServices::count() + 1;
        $user->product_name=$request->prod_name;
        $user->product_sku=$request->prod_sku;
        $user->product_type=$request->prod_category;
        $user->product_sales_description=$request->prod_desc;
        $user->product_sales_price=$request->prod_price;
        $user->product_cost=$request->prod_cost;
        $user->product_qty=$request->prod_qty;
        $user->product_reorder_point=$request->prod_reorder_point;
        $user->save();
    }
    public function getSalesTransactionPageInfo(Request $request){
        $customers = Customers::where([
            ['account_type','=','Customer'],
            ['supplier_active','=','1']
        ])->get();
        $products_and_services = ProductsAndServices::all();
        $prod= ProductsAndServices::where('product_qty', '0')->count();
        $prod2= ProductsAndServices::whereRaw('product_qty<=product_reorder_point')->count();
        $sales_setting=Sales::first();
        $sales_transaction= DB::connection('mysql')->select("SELECT *, st_invoice.total_invoice_amount as invoice_total, st_invoice.total_invoice_p_amount as invoice_p_amount_total, st_credit_notes.total_credit_note_amount as credit_note_total, st_estimates.total_estimate_amount as estimate_total FROM sales_transaction
        JOIN customers ON sales_transaction.st_customer_id=customers.customer_id
        LEFT JOIN  (select *,sum(st_i_total) as total_invoice_amount,sum(st_p_amount) as total_invoice_p_amount from st_invoice group by st_i_no,st_p_location,st_p_invoice_type) st_invoice ON st_invoice.st_i_no=sales_transaction.st_no AND st_invoice.st_p_location=sales_transaction.st_location AND st_invoice.st_p_invoice_type=sales_transaction.st_invoice_type
        LEFT JOIN (select *,sum(st_cn_total) as total_credit_note_amount from st_credit_notes group by st_cn_no) st_credit_notes ON st_credit_notes.st_cn_no=sales_transaction.st_no
        LEFT JOIN (select *, sum(st_e_total) as total_estimate_amount from st_estimates group by st_e_no) st_estimates ON st_estimates.st_e_no=sales_transaction.st_no
        ORDER BY st_date DESC");
        $total_invoice_count = 0;
        $total_invoice_data = 0;
        $total_estimate_count = 0;
        $total_estimate_data = 0;
        $total_paid_count = 0;
        $total_paid_data = 0;
        foreach($sales_transaction as $transaction){
            if($transaction->st_type == "Invoice" && $transaction->st_status == "Open" && $transaction->remark!="Cancelled"){
                $total_invoice_count++;
                $total_invoice_data += $transaction->total_invoice_amount;
            }else if($transaction->st_type == "Invoice" && $transaction->st_status == "Paid" && $transaction->remark!="Cancelled"){
                $total_paid_count++;
                $total_paid_data += $transaction->invoice_p_amount_total;
            }else if($transaction->st_type == "Estimate" && $transaction->st_status == "Pending" && $transaction->remark!="Cancelled"){
                $total_estimate_count++;
                $total_estimate_data += $transaction->estimate_total;

            }
        }
        $STInvoice= DB::connection('mysql')->select("SELECT * from st_invoice LEFT JOIN cost_center ON cost_center.cc_no=st_invoice.st_p_cost_center LEFT JOIN products_and_services ON products_and_services.product_id=st_invoice.st_i_product");
        

        $data = array(
            'customers' => $customers,
            'products_and_services' => $products_and_services,
            'prod' => $prod,
            'prod2' => $prod2,
            'sales_setting' => $sales_setting,
            'sales_transaction' => $sales_transaction,
            'total_invoice_count' => $total_invoice_count,
            'total_invoice_data' => $total_invoice_data,
            'total_estimate_count' => $total_estimate_count,
            'total_estimate_data' => $total_estimate_data,
            'total_paid_count' => $total_paid_count,
            'total_paid_data' => $total_paid_data,
            'STInvoice' => $STInvoice
        );
        return response($data, 200);
    }
    public function SetCostCenterEdit(Request $request){
        $cc_type_code=$request->Type_Code;
        $cc_name_code=$request->Category_Code;
        $cc_type=$request->CostCenterTypeName;
        $cc_name=$request->CostCenterCategory;
        $cc_no=$request->no;

        $costcenter=CostCenterEdit::find($cc_no);
        if(empty($costcenter)){
            $costcenter = new CostCenterEdit;
        }
        $costcenter->cc_no=$cc_no; 
        $costcenter->cc_type_code=$cc_type_code; 
        $costcenter->cc_type=$cc_type; 
        $costcenter->cc_name_code=$cc_name_code; 
        $costcenter->cc_name=$cc_name;
        $costcenter->edit_status="0";
        $costcenter->save();


    }
    public function UploadMassBIDQuot(Request $request){
        $error_count=0;
        $saved_count=0;
        $countloop=0;
        $rowcount=0;
        $extra="";
        $Log="";
        $file = $request->file('theFile');
        $path = $file->getRealPath();
        $spreadsheet = Excel::load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        foreach ($worksheet->getRowIterator() as $row) {
            $rowcount++;
            $countloop++;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            if($rowcount>1){
                $cc_code="";
                $bid_amount="";
                $csasd=1;
                foreach ($cellIterator as $cell) {
                    if($csasd==1){
                        $cc_code=$cell->getCalculatedValue();
                        
                    }
                    if($csasd==3){
                        $bid_amount=$cell->getCalculatedValue();
                    }
                    $csasd++;
                }
                if($cc_code!=""){
                    if($bid_amount!=""){
                        $ccc= CostCenter::where('cc_name_code',$cc_code)->first();
                        if(!empty($ccc)){
                            
                            if(is_numeric($bid_amount) && $bid_amount > 0){
								$extra.=$cc_code." || ";
                                $cost_center=$ccc->cc_no;
                                $budget=$bid_amount;
                                $Budget= Budgets::where([
                                    ['budget_cost_center', '=', $cost_center],
                                    ['budget_type', '=', "Bid of Quotation"]
                                ])->first();
                                if(empty($Budget)){
                                    $Budget = new Budgets;
                                }
                                $Budget->budget_no=Budgets::count() + 1;
                                $Budget->budget_cost_center=$cost_center;
                                $Budget->budget_month=$budget;
                                $Budget->budget_type="Bid of Quotation";
                                if($Budget->save()){
                                    $Cost_Center=CostCenter::find($cost_center);
                                    $Cost_Center->cc_use_quotation='Yes';
                                    $Cost_Center->save();
                                    $saved_count++;
                                }else{
                                    $error_count++;
                                    $Log.="Error Saving Data on row ".$rowcount." from file.\n";   
                                } 
                            }else{
                                $error_count++;
                                $Log.="Amount not a proper number on row ".$rowcount." from file.\n"; 
                            } 
                        }else{
                            $error_count++;
                            $Log.="Cost Center Code Not Found on row ".$rowcount." from file.\n"; 
                        }
                    }else{
                        $error_count++;
                        $Log.="Empty Amount on row ".$rowcount." from file.\n";
                    }
                }else{
                    $error_count++;
                    $Log.="Empty Cost Center Code on row ".$rowcount." from file.\n";
                }
            }
            
            
        }
        


        $data = array(
            'Success' => $saved_count,
            'Total' => $countloop,
            'Skiped'  => $error_count,
            'Error_Log' =>$Log,
            'Extra'=>$extra
        );
        return json_encode($data);
    }
    public function GetBudgetTemplateExcel_Bid_of_Quotation(Request $request){
        $cc_no=$request->cc;
        $cost_center_list= CostCenter::orderBy('cc_type_code')->get();
        Excel::load('extra/edit_excel/bid_of_quotation.xlsx', function($doc) use($request) {
            $cc_no=$request->cc;
            $cost_center_list= CostCenter::orderBy('cc_type_code')->get();
            $COA= ChartofAccount::where('coa_active','1')->get();
            $sheet1 = $doc->setActiveSheetIndex(0);

            $oro=1;
            foreach($cost_center_list as $coa){
                if(substr($coa->cc_type_code, 0, 2) == '05' || substr($coa->cc_type_code, 0, 2) == '03' ){
                    $oro++;
                   
                    $sheet1->setCellValue('A'.$oro, $coa->cc_name_code);
                    $sheet1->setCellValue('B'.$oro, $coa->cc_name);
                    
                    $style = array(
                        'alignment' => array(
                            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                        )
                    );
                    $sheet1->getStyle('A'.$oro.'')->applyFromArray($style);
                }
                
                
               
            }
            
            
        })->setFilename('Import Template for Bid of Quotations '.date('m-d-Y'))->download('xlsx');
    }
    public function SetCostCenter(Request $request){
        $cc_type_code=$request->Type_Code;
        $cc_name_code=$request->Category_Code;
        $cc_type=$request->CostCenterTypeName;
        $cc_name=$request->CostCenterCategory;

        $costcenter= New CostCenter;
        $cc_no=CostCenter::count() + 1;
        $costcenter->cc_no=$cc_no;
        $costcenter->cc_type_code=$cc_type_code; 
        $costcenter->cc_type=$cc_type; 
        $costcenter->cc_name_code=$cc_name_code; 
        $costcenter->cc_name=$cc_name;
        
        $costcenter->save();
    }
    public function GetCodeCostCenter(Request $request){
        $type_code=$request->type_code;
        $CostCenter= CostCenter::where('cc_name_code',$type_code)->get();
        if(count($CostCenter)<1){
            return 0;
        }
        else if(count($CostCenter)>0){
            return 1;
        }

    }
    public function GetCodeCostCenterEdit(Request $request){
        $type_code=$request->type_code;
        $no=$request->no;
        $CostCenter= CostCenter::where([
            ['cc_name_code', '=', $type_code],
            ['cc_no', '!=', $no],
            
        ])->get();
        if(count($CostCenter)<1){
            return 0;
        }
        else if(count($CostCenter)>0){
            return 1;
        }

    }
    public function save_cc_type(Request $request){
        $data=new CC_Type;
        $data->cc_type=$request->typename;
        $data->cc_code=$request->typecode;
        $data->save();
    }
    public function check_cost_center_code(Request $request){
        $count=0;
        $count+=count(CostCenter::where([['cc_type_code','=',$request->name]])->get());
        $count+=count(CC_Type::where([['cc_code','=',$request->name]])->get());
        return $count;
    }
    public function check_cost_center_type(Request $request){
        $count=0;
        $count+=count(CostCenter::where([['cc_type','=',$request->name]])->get());
        $count+=count(CC_Type::where([['cc_type','=',$request->name]])->get());
        return $count;
    }
    public function delete_cost_center(Request $request){
        //$CostCenter=CostCenter::find($request->cost_id);

        $costcenterEdit=CostCenterEdit::find($request->cost_id);
        $costcenter=CostCenter::find($request->cost_id);
       
        if(empty($costcenterEdit)){
            $costcenterEdit =new CostCenterEdit;
        }
            $costcenterEdit->cc_no=$request->cost_id;
            $costcenterEdit->cc_type_code=$costcenter->cc_type_code; 
            $costcenterEdit->cc_type=$costcenter->cc_type; 
            $costcenterEdit->cc_name_code=$costcenter->cc_name_code; 
            $costcenterEdit->cc_name=$costcenter->cc_name;
            $costcenterEdit->cc_status='0';  
            $costcenterEdit->edit_status="0";
            if($costcenterEdit->save()){
               
            }
    }
    public function UploadMassBudget(Request $request){
        $file = $request->file('theFile');
        $ids = $request->input('ids');
        // $reader = Excel::createReader('Xlsx');
        // $reader->setReadDataOnly(TRUE);
        $path = $file->getRealPath();
        $spreadsheet = Excel::load($path);
        $saved_count=0;
        $countloop=0;
        $error_count=0;
        $Log="";
        // $data = Excel::selectSheetsByIndex(0)->load($path, function($reader) {
        // })->get();
        $worksheet = $spreadsheet->getActiveSheet();
        $extra="";
        //$extra.='<table class="table table-bordered">' . PHP_EOL;
        $rows=1;
        $valid="";
        $cc_no="";
        $year="";
        foreach ($worksheet->getRowIterator() as $row) {
            
            if($rows==1){
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE);
                $csasd=1;
               foreach ($cellIterator as $cell) {
                    if($csasd==1){
                        if($cell->getCalculatedValue()!=$ids){
                            $valid="0";
                        }
                    }else{
                        break;
                    }
                    $csasd++;
                } 
            }
            if($valid=="0"){
                $Log.="Incorrect Cost Center Template";
                break;
            }else {
                
            }
            
            if($rows==1){
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE);
                $csasd=1;
                foreach ($cellIterator as $cell) {
                    if($csasd==1){
                        $cc_no=$cell->getCalculatedValue();
                    }
                    else if($csasd==3){
                        $year=$cell->getCalculatedValue();   
                    }
                    $csasd++;
                }

            }
            //$extra.="CC_NO : ".$cc_no." YEAR : ".$year;
            if($rows>4){
                $countloop++;
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE);
                $chart_of_accounts="";
                $cccc=1;
                $cellssss=$cccc;
                $m1=0;
                $m2=0;
                $m3=0;
                $m4=0;
                $m5=0;
                $m6=0;
                $m7=0;
                $m8=0;
                $m9=0;
                $m10=0;
                $m11=0;
                $m12=0;
                foreach ($cellIterator as $cell) {
                    if($cccc==1){
                        $chart_of_accounts=$cell->getCalculatedValue();
                    }
                    if($cccc==3){
                        
                        $m1=$cell->getCalculatedValue();
                        
                    }
                    if($cccc==4){
                        
                        $m2=$cell->getCalculatedValue();
                        
                    }
                    if($cccc==5){
                        
                        $m3=$cell->getCalculatedValue();
                        
                    }
                    if($cccc==6){
                        
                        $m4=$cell->getCalculatedValue();
                        
                    }
                    if($cccc==7){
                        
                        $m5=$cell->getCalculatedValue();
                        
                    }
                    if($cccc==8){
                        
                        $m6=$cell->getCalculatedValue();
                        
                    }
                    if($cccc==9){
                        
                        $m7=$cell->getCalculatedValue();
                        
                    }
                    if($cccc==10){
                        
                        $m8=$cell->getCalculatedValue();
                        
                    }
                    if($cccc==11){
                        
                        $m9=$cell->getCalculatedValue();
                        
                    }
                    if($cccc==12){
                        
                        $m10=$cell->getCalculatedValue();
                        
                    }
                    if($cccc==13){
                        
                        $m11=$cell->getCalculatedValue();
                        
                    }
                    if($cccc==14){
                        
                        $m12=$cell->getCalculatedValue();
                        
                    }
                
                    $cccc++;
                //$cell->getCalculatedValue();
                }
                $Budget= Budgets::where([
                    ['budget_year', '=', $year],
                    ['budget_cost_center', '=', $cc_no],
                    ['budget_chart_of_accounts', '=', $chart_of_accounts],
                    
                ])->first();
                $budget_is="";
                if(!empty($Budget)){
                   
                        $budget_is=$Budget->budget_no;
                    
                }else{
                    $Budget= New Budgets;
                    $budget_is=Budgets::count() + 1; 
                }
                $Budget->budget_no=$budget_is;
                $Budget->budget_year=$year;
                $Budget->budget_cost_center=$cc_no;
                $Budget->budget_chart_of_accounts=$chart_of_accounts;
                $Budget->budget_type="Monthly";
                $Budget->m1=$m1;
                $Budget->m2=$m2;
                $Budget->m3=$m3;
                $Budget->m4=$m4;
                $Budget->m5=$m5;
                $Budget->m6=$m6;
                $Budget->m7=$m7;
                $Budget->m8=$m8;
                $Budget->m9=$m9;
                $Budget->m10=$m10;
                $Budget->m11=$m11;
                $Budget->m12=$m12;
                if($Budget->save()){
                    $costcenter=CostCenter::find($cc_no);
                    $costcenter->cc_use_quotation="";
                    $saved_count++;
                }else{
                    $error_count++;
                    $Log.="Failed to Save Data in Row ".$rows-4;
                }
                
            }
            $rows++;
        }

        $data = array(
            'Success' => $saved_count,
            'Total' => $countloop,
            'Skiped'  => $error_count,
            'Error_Log' =>$Log,
            'Extra'=>$extra
        );
        return json_encode($data);
        
    }
    public function GetBudgetTemplateExcel(Request $request){
        
        $cc_no=$request->cc;
        $cost_center_list= CostCenter::where('cc_no',$cc_no)->orderBy('cc_type_code')->get();
        Excel::load('extra/edit_excel/budget.xlsx', function($doc) use($request) {
            $cc_no=$request->cc;
            $cost_center_list= CostCenter::where('cc_no',$cc_no)->orderBy('cc_type_code')->get();
            $COA= ChartofAccount::where('coa_active','1')->get();
            $sheet1 = $doc->setActiveSheetIndex(0);

            $sheet1->setCellValue('A1', $cost_center_list[0]->cc_no);
            $sheet1->setCellValue('B1', $cost_center_list[0]->cc_name);
            $sheet1->setCellValue('C1', date('Y'));
            $oro=4;
            foreach($COA as $coa){
                $oro++;
                $sheet1->setCellValue('A'.$oro, $coa->coa_code);
                //$sheet1->mergeCells('A'.$oro.':B'.$oro.'');
                $sheet1->setCellValue('B'.$oro, $coa->coa_name);
                
                    $styleArray = array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    );
                $sheet1->getStyle('A'.$oro.':N'.$oro.'')->applyFromArray($styleArray);
                $style = array(
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    )
                );
                
                $sheet1->getStyle('A'.$oro)->applyFromArray($style);
                $style = array(
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    )
                );
            
                //$sheet1->getStyle('B'.$oro)->applyFromArray($style);

                $sheet1->getStyle('C'.$oro.':N'.$oro.'')->getFill()
                ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFDEEAF6');
                
            }
            $letter="C";
            do {
                $sheet1->setCellValue(
                    $letter.'4',
                    '=SUM('.$letter.'5:'.$letter.''.$oro.')'
                );
            $letter++;
            } while( $letter<"O");
            
            
        })->setFilename('Import Template for '.$cost_center_list[0]->cc_name.' Monthly Budget '.date('m-d-Y'))->download('xlsx');
    }
    public function getCCInfo(Request $request){
        $CC_Index=0;
        $keyword="";
        if($request->no){
            $CC_Index=($request->no);
        }else{
            $CC_Index=0;
        }
        if($request->keyword){
            $keyword=$request->keyword;
        }else{
            $keyword="";
        }
        $CostCenter = DB::table('cost_center')
                    ->skip($CC_Index-1)
                    ->take(20)
                    ->where('cc_status','=','1')
                    ->Where(function ($query) use ($keyword) {
                        $query->where('cc_no','LIKE','%'.$keyword.'%')
                            ->orwhere('cc_type_code','LIKE','%'.$keyword.'%')
                            ->orwhere('cc_name_code','LIKE','%'.$keyword.'%')
                            ->orwhere('cc_type','LIKE','%'.$keyword.'%')
                            ->orwhere('cc_name','LIKE','%'.$keyword.'%');
                    })
                    ->orderBy('cc_type_code', 'asc')->get();
        $CC_Type_GROUPPED = []; 
        $dup=0;
        foreach($CostCenter as $coaa){
            foreach($CC_Type_GROUPPED as $ddd){
                if($ddd->cc_type_code." -- ".$ddd->cc_type==$coaa->cc_type_code." -- ".$coaa->cc_type){
                    $dup=1;
                    break;
                }else{
                   
                }
                
            }
            
            if($dup==0){
                $CC_Type_GROUPPED[]=$coaa;
            }
            $dup=0;
            
        }
        $budgets=Budgets::all();
        $CC_Types_list=CC_Type::orderBy('cc_code', 'asc')->groupBy('cc_type')->get();
        $data = array(
            
            'CC_Type_GROUPPED' => $CC_Type_GROUPPED,
            'CostCenter' => $CostCenter,
            'CC_Index' => $CC_Index,
            'keyword' => $keyword,
            'budgets' => $budgets,
            'CC_Types_list' => $CC_Types_list
        );
        return response($data, 200);
    }
    public function GetChartofCostCenterExcelemplate(Request $request){
        
        Excel::load('extra/edit_excel/Cost_Center_Import_Data.xlsx', function($doc) {
        
        
        })->setFilename('Import Template for Cost Center '.date('m-d-Y'))->download('xlsx');
    }
    public function UploadMassCC(Request $request){
        $error_count=0;
        $saved_count=0;
        $countloop=0;
        $Log="";
        $file = $request->file('theFile');
        $path = $file->getRealPath();
        $data = Excel::selectSheetsByIndex(0)->load($path, function($reader) {
        })->get();
        $rowcount=0;
        foreach($data as $row){
            $rowcount++;
            $countloop++;
        //    $Log.=$row;
        //    break;
            //{"cost_center_type_code":1123,"cost_center_type":"Admin","cost_center_category":"Admin"}
            if($row->cost_center_type_code!=""){
                if($row->cost_center_type!=""){
                    if($row->cost_center_category_code!=""){
                        if($row->cost_center_category!=""){
                            $CostCenter=CostCenter::where('cc_name_code',$row->cost_center_category_code)->count();
                            if($CostCenter<1){
                                $costcenter= New CostCenter;
                                $costcenter_no=CostCenter::count() + 1;
                                $costcenter->cc_no=$costcenter_no ; 
                                $costcenter->cc_type_code=$row->cost_center_type_code; 
                                $costcenter->cc_type=$row->cost_center_type; 
                                $costcenter->cc_name_code=$row->cost_center_category_code; 
                                $costcenter->cc_name=$row->cost_center_category;
                                $costcenter->cc_use_quotation=$row->use_bid_of_quotation;
                                if($costcenter->save()){

                                    $saved_count++;
                                
                                }else{
                                    $error_count++;
                                    $Log.="Error Saving Data on row ".$rowcount." from file.\n";
                                }
                                
                            }else{
                                $error_count++;
                                $Log.="Duplicate Cost Center Category Code on row ".$rowcount." from file.\n";
                            }
                        }else{
                            $error_count++;
                            $Log.="Empty Cost Center Category on row ".$rowcount." from file.\n";
                        }
                    }else{
                        $error_count++;
                        $Log.="Empty Cost Center Category Code on row ".$rowcount." from file.\n";
                    }
                }else{
                    $error_count++;
                    $Log.="Empty Cost Center Type on row ".$rowcount." from file.\n";
                }
            }else{
                $error_count++;
                $Log.="Empty Cost Center Type Code on row ".$rowcount." from file.\n";  
            }
        }
        $data = array(
            'Success' => $saved_count,
            'Total' => $countloop,
            'Skiped'  => $error_count,
            'Error_Log' =>$Log
        );
        return json_encode($data);
    }
    public function update_coa(Request $request)
    {
      //return $request;
        $Chart=COAEdits::find($request->input('coa_id'));
        if(empty($Chart)){
            $Chart = new COAEdits;

        }
        if($request->input('ACCType')=="Custom"){
            $Chart->coa_account_type=$request->input('customaccounttype');
            $Chart->coa_detail_type=$request->input('customdetailtyep');
            $Chart->coa_name=$request->input('customdetailtyep');
        }else{
            $Chart->coa_account_type=$request->input('ACCType');
            $Chart->coa_detail_type=$request->input('DetType');
            $Chart->coa_name=preg_replace( "/\r|\n/", "", $request->input('DetType') );
        }
        
        $Chart->id=$request->input('coa_id');
        $Chart->coa_sub_account=$request->input('sub_accoinmt');
        $Chart->coa_description=$request->input('COADesc');
        $Chart->coa_code=$request->input('COACode');
        $Chart->normal_balance=$request->input('COANormalBalance');
        $Chart->coa_parent_account=$request->input('COAParentAcc');
        $Chart->coa_beginning_balance=$request->input('COABalance');
        $Chart->coa_as_of_date=$request->input('COAAsof');
        $Chart->coa_title=$request->input('coatitle');
        $Chart->coa_cc=$request->input('coa_cc');
        $Chart->edit_status="0";
        $Chart->save();
        
    }
    public function getCOA_info_edit(Request $request){
        $chart= ChartofAccount::find($request->id);
        return $chart;
    }
    public function destroy_coa(Request $request)
    {

        $ChartEdit=COAEdits::find($request->input('id'));
        $Chart=ChartofAccount::find($request->input('id'));
        if(empty($ChartEdit)){
            $ChartEdit=new COAEdits;
        }
        
        $ChartEdit->id=$request->input('id');
        $ChartEdit->coa_account_type=$Chart->coa_account_type;
        $ChartEdit->coa_detail_type=$Chart->coa_detail_type;
        $ChartEdit->coa_name=$Chart->coa_name;
        
        $ChartEdit->coa_description=$Chart->coa_description;
        $ChartEdit->coa_code=$Chart->coa_code;
        $ChartEdit->normal_balance=$Chart->normal_balance;
        $ChartEdit->coa_balance=$Chart->coa_balance;
        $ChartEdit->coa_as_of_date=$Chart->coa_as_of_date;
        $ChartEdit->coa_title=$Chart->coa_title;
        $ChartEdit->coa_active="0";
        $ChartEdit->edit_status="0";
        if($ChartEdit->save()){
            
        }

    }
    public function SaveCOA(Request $request){
        
        
        $Chart= New ChartofAccount;
        $Chart->id= ChartofAccount::count() + 1;
        $cccdcd=ChartofAccount::count() + 1;
        if($request->input('ACCType')=="Custom"){
            $Chart->coa_account_type=$request->input('customaccounttype');
            $Chart->coa_detail_type=$request->input('customdetailtyep');
            $Chart->coa_name=preg_replace( "/\r|\n/", "", $request->input('customdetailtyep') );
        }else{
            $Chart->coa_account_type=$request->input('ACCType');
            $Chart->coa_detail_type=$request->input('DetType');
            $Chart->coa_name=$request->input('DetType');
        }
        
        $Chart->coa_sub_account=$request->input('sub_accoinmt');
        $Chart->coa_description=$request->input('COADesc');
        $Chart->coa_code=$request->input('COACode');
        $Chart->normal_balance=$request->input('COANormalBalance');
        $Chart->coa_is_sub_acc="0";
        $Chart->coa_parent_account=$request->input('COAParentAcc');
        $Chart->coa_balance=$request->input('COABalance');
        $Chart->coa_beginning_balance=$request->input('COABalance');
        $Chart->coa_as_of_date=$request->input('COAAsof');
        $Chart->coa_active='1';
        $Chart->coa_title=$request->input('coatitle');
        $Chart->coa_cc=$request->input('coa_cc');
        $Chart->save();
    }
    public function UploadMassCOA(Request $request){
        $error_count=0;
        $saved_count=0;
        $countloop=0;
        $Log="";
        $file = $request->file('theFile');
        $path = $file->getRealPath();
        $data = Excel::load($path, function($reader) {
        })->get();
        $code_coa=0;
        $rowcount=0;
        $fforeaccount=0;
        foreach($data as $row){
            $rowcount++;
            $countloop++;
            if($row->account_code!=""){
                $Chart=ChartofAccount::where('coa_code',$row->account_code)->count();
                if($Chart<1){
                    if($row->line_item!=""){
                        if($row->account_title!=""){
                            if($row->normal_balance!=""){
                                if($row->account_classification!=""){
                                    // if($row->cost_center_code!=""){
                                        $cc_code_check=CostCenter::where([
                                            ['cc_name_code','=',$row->cost_center_code]
                                        ])->get();
                                        $cc_id="";
                                            
                                        if(count($cc_code_check)>0){
                                            foreach($cc_code_check as $ccs){
                                                $cc_id=$ccs->cc_no;
                                            }
                                        }else{
                                            //not existing Cost Center Code
                                            // $error_count++;
                                            // $Log.="Cost Center Code not Existing on row ".$rowcount." from file.\n";
                                        }
                                            
                                            $Chart= New ChartofAccount;
                                            $Chart->id= ChartofAccount::count() + 1;
                                            $cccdcd=ChartofAccount::count() + 1;
                                            $Chart->coa_account_type=$row->line_item;
                                            $Chart->coa_detail_type=$row->account_title;
                                            $Chart->coa_name=preg_replace( "/\r|\n/", "", $row->account_title );
                                            $Chart->coa_sub_account=$row->sub_account;
                                            $Chart->coa_description=$row->account_description;
                                            $Chart->coa_code=$row->account_code;
                                            $Chart->normal_balance=$row->normal_balance;
                                            $Chart->coa_cc=$cc_id;
                                            $Chart->coa_balance=0;
                                            $Chart->coa_beginning_balance=0;
                                            $Chart->coa_is_sub_acc="0";
                                            $Chart->coa_active="1";
                                            $Chart->coa_title=$row->account_classification;
                                            if($Chart->save()){
                                                // $AuditLog= new AuditLog;
                                                // $AuditLogcount=AuditLog::count()+1;
                                                // $userid = Auth::user()->id;
                                                // $username = Auth::user()->name;
                                                // $eventlog="Added Account No. ".$cccdcd;
                                                // $AuditLog->log_id=$AuditLogcount;
                                                // $AuditLog->log_user_id=$username;
                                                // $AuditLog->log_event=$eventlog;
                                                // $AuditLog->log_name="";
                                                // $AuditLog->log_transaction_date="";
                                                // $AuditLog->log_amount="";
                                                // $AuditLog->save();
                                                $saved_count++;
                                            }else{
                                                $error_count++;
                                                $Log.="Error Saving Data on row ".$rowcount." from file.\n";  
                                            }
                                        
                                    // }else{
                                    //     //empty Cost Center Code
                                    //     $error_count++;
                                    //     $Log.="Empty Cost Center Code on row ".$rowcount." from file.\n";
                                    // }
                                    
                                }else{
                                    //empty Account Title
                                    $error_count++;
                                    $Log.="Empty Account Classification on row ".$rowcount." from file.\n";
                                }
                            }else{
                                //empty Normal Balance
                                 $error_count++;
                                $Log.="Empty Normal Balance on row ".$rowcount." from file.\n";
                            }
                        }else{
                            //empty adetail type
                            $error_count++;
                            $Log.="Empty Account Title on row ".$rowcount." from file.\n";
                        }
                    }else{
                        //empty Line Item
                        $error_count++;
                        $Log.="Empty Line Item on row ".$rowcount." from file.\n";
                    }
                   
                }else{
                    //duplicate code
                    $error_count++;
				    $Log.="Duplicate Account Code on row ".$rowcount." from file.\n";
                }
            }else{
                //empty code
                $error_count++;
				$Log.="Empty Account Code on row ".$rowcount." from file.\n";
            }
            $fforeaccount++;
        }


        $data = array(
            'Success' => $saved_count,
            'Total' => $countloop,
            'Skiped'  => $error_count,
            'Error_Log' =>$Log
        );
        return json_encode($data);
    }
    public function GetChartofAccountsExcelemplate(Request $request){
        Excel::load('extra/edit_excel/coa.xlsx', function($doc) {
        
        })->setFilename('Import Template for Chart of Account '.date('m-d-Y'))->download('xlsx');
    }
    public function getCOAInfo(Request $request){
        $COA_Index=0;
        $keyword="";
        if($request->no){
            $COA_Index=($request->no);
        }else{
            $COA_Index=0;
        }
        if($request->keyword){
            $keyword=$request->keyword;
        }else{
            $keyword="";
        }
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        $chartofaccountbyaccounttype = DB::table('chart_of_accounts')
                ->skip($COA_Index-1)
                ->take(20)
                ->select('*')
                ->groupBy('coa_account_type')
                ->orderBy('id', 'asc')
                ->orderBy('coa_account_type', 'DESC')
                ->get();
        $COA= DB::table('chart_of_accounts')
                ->skip($COA_Index-1)
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
        $dup=0;
        foreach($COA as $coaa){
            foreach($COA_Type_GROUPPED as $ddd){
                if($ddd->coa_title==$coaa->coa_title){
                    $dup=1;
                    break;
                }else{
                   
                }
                
            }
            
            if($dup==0){
                $COA_Type_GROUPPED[]=$coaa;
            }
            $dup=0;
            
        }
        
        // $COA_Type_GROUPPED=array_unique($COA_Type_GROUPPED);
        $data = array(
            
            'COA_Type_GROUPPED' => $COA_Type_GROUPPED,
            'COA' => $COA,
            'COA_Index' => $COA_Index,
            'keyword' => $keyword,
            'cost_center_list' => $cost_center_list,
        );
        return response($data, 200);
    }
    public function cancel_entry(Request $request){
        $updateDetails=array(
            'remark' => 'Cancelled',
            'cancellation_date' => date('Y-m-d'),
            'cancellation_reason' => $request->Reason
        );
        if($request->type=="Journal Entry"){
            
        }
        else if($request->type=="Voucher"){
            DB::table('voucher')
            ->where([
                ['voucher_id', '=', $request->id]
                
            ])
            ->update($updateDetails);
        }
        else if($request->type=="Invoice" || $request->type=="Sales Receipt" || $request->type=="Credit Note"){
            DB::table('sales_transaction')
            ->where([
                ['st_no', '=', $request->id],
                ['st_type', '=', $request->type],
                ['st_location','=',$request->locationss],
                ['st_invoice_type','=',$request->invoice_type]
            ])
            ->update($updateDetails);
            if($request->type=="Sales Receipt"){
                $data=DB::table('sales_transaction')
                ->where([
                    ['st_no', '=', $request->id],
                    ['st_type', '=', $request->type],
                    ['st_location','=',$request->locationss],
                    ['st_invoice_type','=',$request->invoice_type]
                ])->get();
                foreach($data as $set){
                    
                    $amount=$set->st_amount_paid;
                    $invoice_sss=DB::table('sales_transaction')
                    ->where([
                        ['st_no', '=', $set->st_payment_for],
                        ['st_type', '=', 'Invoice'],
                        ['st_location','=',$request->locationss],
                        ['st_invoice_type','=',$request->invoice_type]
                    ])->first();
                    if(!empty($invoice_sss)){
                        $amount+=$invoice_sss->st_balance;
                    }
                   
                    $sales_receipt_insert=array(
                        'st_balance' => $amount,
                        'st_status' => 'Open'
                    );
                    $data=DB::table('sales_transaction')
                    ->where([
                        ['st_no', '=', $set->st_payment_for],
                        ['st_type', '=', 'Invoice'],
                        ['st_location','=',$request->locationss],
                        ['st_invoice_type','=',$request->invoice_type]
                    ])->update($sales_receipt_insert);
                    $data=DB::table('st_invoice')
                    ->where([
                        ['st_i_no', '=', $set->st_payment_for],
                        ['st_p_location','=',$request->locationss],
                        ['st_p_invoice_type','=',$request->invoice_type],
                        ['st_i_item_no','=',$set->st_email]
                    ])->first();
                    $balance_st=$data->st_p_amount-$amount;
                    $st_invoice_data=array(
                        'st_p_amount' => $balance_st
                    );
                    $data=DB::table('st_invoice')
                    ->where([
                        ['st_i_no', '=', $set->st_payment_for],
                        ['st_p_location','=',$request->locationss],
                        ['st_p_invoice_type','=',$request->invoice_type],
                        ['st_i_item_no','=',$set->st_email]
                    ])->update($st_invoice_data);

                }
            }
        }
        else if($request->type=="Bill" || $request->type=="Expense" || $request->type="Credit card credit" || $request->type=="Supplier Credit" || $request->type=="Cheque"){
            DB::table('expense_transactions')
            ->where([
                ['et_no', '=', $request->id],
                ['et_type', '=', $request->type]
            ])
            ->update($updateDetails);
        }
        $trrs=DB::table('journal_entries')
            ->where([
                ['other_no', '=', $request->id],
                ['je_transaction_type', '=', $request->type],
                ['je_invoice_location_and_type', '=', $request->locationss!=""?$request->locationss." ".$request->invoice_type : NULL]
            ])
            ->update($updateDetails);
    }
    public function SaveJournalEntry(Request $request){
        
        $ChequeVoucherCount=count(JournalEntry::where([
            ['journal_type','=','Cheque Voucher']
        ])->groupBy('je_no')->get())+1;
        $JournalVoucherCount=count(JournalEntry::where([
            ['journal_type','=','Journal Voucher']
        ])->groupBy('je_no')->get())+1;
        $current_year=date('y');

        $chequevoucher_no_series="";
        if($ChequeVoucherCount<10){
            $chequevoucher_no_series="000".$ChequeVoucherCount;
        }
        else if($ChequeVoucherCount>9 && $ChequeVoucherCount<100){
            $chequevoucher_no_series="00".$ChequeVoucherCount;
        }else if($ChequeVoucherCount>99 && $ChequeVoucherCount<1000){
            $chequevoucher_no_series="0".$ChequeVoucherCount;
        }
        $journalvoucher_no_series="";
        if($JournalVoucherCount<10){
            $journalvoucher_no_series="000".$JournalVoucherCount;
        }
        else if($JournalVoucherCount>9 && $JournalVoucherCount<100){
            $journalvoucher_no_series="00".$JournalVoucherCount;
        }else if($JournalVoucherCount>99 && $JournalVoucherCount<1000){
            $journalvoucher_no_series="0".$JournalVoucherCount;
        }
        $chequevoucher_no="CV".$current_year.$chequevoucher_no_series;
        $journalvoucher_no="JV".$current_year.$journalvoucher_no_series;
        $journal_series_no="";
        if($request->journal_entry_type=="ChequeVoucher"){
            $journal_series_no=$chequevoucher_no;
        }else{
            $journal_series_no=$journalvoucher_no;
        }

        for($c=1; $c<=$request->journal_table_count;$c++){
            $journal_entries = new  JournalEntry;
        
            $journal_entries->je_id = $c;
            $journal_entries->je_no=$request->input('JournalNo');
            $journal_entries->je_series_no=$journal_series_no;

            $journal_entries->je_account=$request->input('accjournbale'.$c);
            $journal_entries->je_debit=$request->input('journaldebit'.$c);
            $journal_entries->je_credit=$request->input('journalcredit'.$c);
            $journal_entries->je_desc=$request->input('journaldescription'.$c);
            $journal_entries->je_name=$request->input('journalnamename'.$c);
            $journal_entries->je_cost_center=$request->input('journalcost_center_td_input'.$c);
            if($request->journal_entry_type=="ChequeVoucher"){
                $journal_entries->cheque_no=$request->input('journalcheque_no_td'.$c);
            }
            $journal_entries->ref_no=$request->input('journalref_no_td'.$c);
            $journal_entries->date_deposited=$request->input('date_deposited'.$c);

            $journal_entries->je_memo=$request->input('JournalMemo');
            $journal_entries->created_at=$request->input('journalDate');
            $journal_entries->other_no=$request->input('OtherNo');
            $journal_entries->je_attachment=$request->input('journalDate');
            $journal_entries->je_transaction_type=$request->input('JournalEntryTransactionType');
            $journal_entries->journal_type=$request->input('journal_entry_type');
            
            $journal_entries->save();
        }
        

    }
    public function getCostCenterJournal(Request $request){
        $data=ChartofAccount::find($request->id);
        $cc=$data->coa_cc;
        $name="";
        if($cc==""){
            $name="";
        }else{
            $cc_list=CostCenter::find($cc);
            $name=$cc_list->cc_name;
        }
        $data = array(
            'name' => $name,
            'no' => $cc,
        );
        return json_encode($data);
    }
    public function getJournalModalInfo(Request $request){
        
        $ChequeVoucherCount=count(JournalEntry::where([
            ['journal_type','=','Cheque Voucher']
        ])->groupBy('je_no')->get())+1;
        $JournalVoucherCount=count(JournalEntry::where([
            ['journal_type','=','Journal Voucher']
        ])->groupBy('je_no')->get())+1;
        $current_year=date('y');

        $chequevoucher_no_series="";
        if($ChequeVoucherCount<10){
            $chequevoucher_no_series="000".$ChequeVoucherCount;
        }
        else if($ChequeVoucherCount>9 && $ChequeVoucherCount<100){
            $chequevoucher_no_series="00".$ChequeVoucherCount;
        }else if($ChequeVoucherCount>99 && $ChequeVoucherCount<1000){
            $chequevoucher_no_series="0".$ChequeVoucherCount;
        }
        $journalvoucher_no_series="";
        if($JournalVoucherCount<10){
            $journalvoucher_no_series="000".$JournalVoucherCount;
        }
        else if($JournalVoucherCount>9 && $JournalVoucherCount<100){
            $journalvoucher_no_series="00".$JournalVoucherCount;
        }else if($JournalVoucherCount>99 && $JournalVoucherCount<1000){
            $journalvoucher_no_series="0".$JournalVoucherCount;
        }
        $chequevoucher_no="CV".$current_year.$chequevoucher_no_series;
        $journalvoucher_no="JV".$current_year.$journalvoucher_no_series;
        $current_date=date('Y-m-d');
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $customers = Customers::all();
        $data = array(
            'current_date' => $current_date,
            'chequevoucher_no' =>$chequevoucher_no,
            'journalvoucher_no' =>$journalvoucher_no,
            'jounalcount' => $jounalcount,
            'customers' =>$customers,
            
        );
        return response($data, 200);
    }
    public function get_journal_entry_data(Request $request){
        $va=$request->no;
        $result=DB::connection('mysql')->select("SELECT * FROM journal_entries 
        LEFT JOIN chart_of_accounts 
        ON journal_entries.je_account=chart_of_accounts.id 
        LEFT JOIN cost_center 
        ON journal_entries.je_cost_center=cost_center.cc_no 
        WHERE je_no='$va'");
        $totaldebitpreview=0;
        $totalcreditpreview=0;
        $journal_entry_title_header_preview="";
        $JE_NO_Preview="";
        $JournalMemopreview="";
        $journalDatepreview="";
        foreach($result as $data){
            if($data->je_debit!=""){
                $totaldebitpreview=$data->je_debit;
            }
            if($data->je_credit!=""){
                $totalcreditpreview=$data->je_credit;
            }
            $journal_entry_title_header_preview=$data->journal_type;
            $JE_NO_Preview=$data->je_no;
            $JournalMemopreview=$data->je_memo;
            $journalDatepreview=$data->je_attachment;

        }
        $data = array(
            'result' => $result,
            'totaldebitpreview' =>$totaldebitpreview,
            'totalcreditpreview' =>$totalcreditpreview,
            'journal_entry_title_header_preview' =>$journal_entry_title_header_preview,
            'JE_NO_Preview' => $JE_NO_Preview,
            'JournalMemopreview' => $JournalMemopreview,
            'journalDatepreview' => $journalDatepreview,
        );
        return response($data, 200);
    }
    public function getJournalEntry(Request $request){
        $Journal_no_selected= $request->no;
        $journal_type_query=JournalEntry::where([
            ['je_no','=',$Journal_no_selected]
        ])->first();
        $JournalEntry = DB::connection('mysql')->select("SELECT *  FROM journal_entries
        LEFT JOIN chart_of_accounts ON chart_of_accounts.id=journal_entries.je_account 
        WHERE (remark!='NULLED' OR remark IS NULL ) AND je_no='$Journal_no_selected'");
        $company_name= Company::first();
        $saleeee=SalesTransaction::orderBy('st_date','ASC')->get();
        $data = array(
            'Journal_no_selected' => $Journal_no_selected,
            'JournalEntry' => $JournalEntry,
            'journal_type_query' => $journal_type_query,
            'company_name' => $company_name,
            'saleeee' => $saleeee
        );
        return response($data, 200);
    }
    public function getJournal_List(Request $request){
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
        
        if($keyword==""){
            $JournalEntry = JournalEntry::join('chart_of_accounts', 'chart_of_accounts.id', '=', 'journal_entries.je_account')
            ->where([['remark','!=','NULLED']])
            ->orWhereNull('remark')
            ->skip($JournalNoSelected)
            ->take(20)
            ->orderBy('je_no','DESC')
            ->orderBy('je_debit', 'DESC')->get();
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
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        $numbering = Numbering::first();
        $COA= ChartofAccount::where('coa_active','1')->get();
        $data = array(
            'JournalNoSelected' => $JournalNoSelected,
            'JournalEntry' => $JournalEntry,
            'cost_center_list' => $cost_center_list,
            'numbering' => $numbering,
            'COA' => $COA,
            'keyword' =>$keyword
        );
        return response($data, 200);
    }
    public function delete_pending_bid_request(Request $request){
        $budget_edit_no=$request->id;
        $BudgetEdits= BudgetsEdit::where([
            ['budget_no', '=', $budget_edit_no]
        ])->first();
        $cost_center=$BudgetEdits->budget_cost_center;
        $BudgetEdits->edit_status="1";
        if($BudgetEdits->save()){
            // $AuditLog= new AuditLog;
            // $AuditLogcount=AuditLog::count()+1;
            // $CostCenter= CostCenter::where([
            //     ['cc_no', '=', $cost_center]
            // ])->first();
            // $userid = Auth::user()->id;
            // $username = Auth::user()->name;
            // $eventlog="Denied Pending Bid of Quotation Edit Request of.".$CostCenter->cc_name."(".$CostCenter->cc_name_code.")";
            // $AuditLog->log_id=$AuditLogcount;
            // $AuditLog->log_user_id=$username;
            // $AuditLog->log_event=$eventlog;
            // $AuditLog->log_name="";
            // $AuditLog->log_transaction_date="";
            // $AuditLog->log_amount="";
            // $AuditLog->save();
        }
        
    }
    public function approve_pending_bid_request(Request $request){
        $budget_edit_no=$request->id;
        $BudgetEdits= BudgetsEdit::where([
            ['budget_no', '=', $budget_edit_no]
        ])->first();
        $cost_center=$BudgetEdits->budget_cost_center;
        $budget=$BudgetEdits->budget_month;
        $Budget= Budgets::where([
            ['budget_cost_center', '=', $cost_center],
            ['budget_type', '=', "Bid of Quotation"]
        ])->first();
        if(empty($Budget)){
            $Budget = new Budgets;
        }
        $Budget->budget_month=$budget;
        if($Budget->save()){
            $Cost_Center=CostCenter::find($cost_center);
            $Cost_Center->cc_use_quotation='Yes';
            $Cost_Center->save();
            $BudgetEdits->edit_status="1";
            $BudgetEdits->save();
            $CostCenter= CostCenter::where([
                ['cc_no', '=', $cost_center]
            ])->first();
            // $AuditLog= new AuditLog;
            // $AuditLogcount=AuditLog::count()+1;
            // $userid = Auth::user()->id;
            // $username = Auth::user()->name;
            // $eventlog="Approved Pending Bid of Quotation Edit Request of.".$CostCenter->cc_name."(".$CostCenter->cc_name_code.")";
            // $AuditLog->log_id=$AuditLogcount;
            // $AuditLog->log_user_id=$username;
            // $AuditLog->log_event=$eventlog;
            // $AuditLog->log_name="";
            // $AuditLog->log_transaction_date="";
            // $AuditLog->log_amount="";
            // $AuditLog->save();
            
        } 
    }
    public function update_expense_edit(Request $request){
        $expense_transactionedit =ExpenseTransactionEdit::where([
            ['et_no','=',$request->id],
            ['et_type','=',$request->type]
        ])->first();
        $expense_transaction =ExpenseTransaction::where([
            ['et_no','=',$request->id],
            ['et_type','=',$request->type]
        ])->first();
        if(!empty($expense_transaction)){
            
            $expense_transaction->et_customer = $expense_transactionedit->et_customer;
            $expense_transaction->et_terms = $expense_transactionedit->et_terms;
            $expense_transaction->et_bill_no = $expense_transactionedit->et_bill_no;
            $expense_transaction->et_billing_address = $expense_transactionedit->et_billing_address;
            $expense_transaction->et_date = $expense_transactionedit->et_date;
            $expense_transaction->et_due_date = $expense_transactionedit->et_due_date;
            $expense_transaction->et_reference_no = $expense_transactionedit->et_reference_no;
            $expense_transaction->et_memo = $expense_transactionedit->et_memo;
            $expense_transaction->et_type = $expense_transactionedit->et_type;

            $expense_transaction->et_shipping_address = $expense_transactionedit->et_shipping_address;
            $expense_transaction->et_shipping_to = $expense_transactionedit->et_shipping_to;
            $expense_transaction->et_shipping_via = $expense_transactionedit->et_shipping_via;
            $expense_transaction->et_credit_account = $expense_transactionedit->et_credit_account;
            
            $expense_transaction->save();

            DB::table('et_account_details')->where([
                ['et_ad_no','=', $request->id],
                ['et_ad_type','=', $request->type]
            ])->update([
                'et_ad_no'=>'OK'
            ]);
            DB::table('et_item_details')->where([
                ['et_id_no','=', $request->id]
            ])->update([
                'et_id_no'=>'OK'
            ]);
            //DB::table('st_credit_notes')->where('st_cn_no', $request->id)->delete();
            $journalforcostcenter=DB::table('journal_entries')->where([['other_no','=',$request->id]],[['remark','!=','NULLED']] )->get();
            $Costtttsasdasd="";
            $JJJJNNNNOOO="";
            foreach($journalforcostcenter as $sacxzxcasd){
                $JJJJNNNNOOO=$sacxzxcasd->je_no;
                $Costtttsasdasd=$sacxzxcasd->je_cost_center;
            }
            $totalamount=0;
            DB::table('journal_entries')->where('other_no', $request->id)->update([
                'remark'=>'NULLED'
            ]);
            $et_accounteditr=DB::table('et_account_details_edits')->where([
                ['et_ad_no','=', $request->id],
                ['edit_status','=', "0"]
            ])->get();
            $je_id_no=0;
            foreach($et_accounteditr as $ets){
                $et_account = new EtAccountDetail;
                $et_account->et_ad_no = $request->id;
                $et_account->et_ad_product = $ets->et_ad_product;
                $et_account->et_ad_desc = $ets->et_ad_desc;
                $et_account->et_ad_qty = $ets->et_ad_qty;
                $et_account->et_ad_total = $ets->et_ad_total;
                $et_account->et_ad_type =$expense_transactionedit->et_type;
                if($expense_transactionedit->et_type=="Supplier credit"){
                    $totalamount-=$ets->et_ad_total;
                    $JDate=$expense_transactionedit->et_date;
                    $JNo=$request->id;
                    $JMemo=$expense_transactionedit->et_memo;
                    $account=$expense_transactionedit->et_credit_account;
                    $debit= -$ets->et_ad_total;
                    $credit= "";
                    $description=$ets->et_ad_desc;
                    $name="";

                    $journal_entries = new  JournalEntry;
                    $jounal = DB::table('journal_entries')         ->select('je_no')         ->groupBy('je_no')         ->get();         $journal_entries_count=count($jounal)+1;
                    $je_id_no++;
                    $journal_entries->je_id = $je_id_no;
                    
                    $journal_entries->je_no=$JJJJNNNNOOO;
                    $journal_entries->other_no=$JNo;
                    $journal_entries->je_account=$account;
                    $journal_entries->je_debit=$debit;
                    $journal_entries->je_credit=$credit;
                    $journal_entries->je_desc=$description;
                    $journal_entries->je_name=$name;
                    $journal_entries->je_memo=$JMemo;
                    $journal_entries->created_at=$JDate;
                    $journal_entries->je_attachment=$JDate;
                    $journal_entries->je_transaction_type="Supplier Credit";
                    $journal_entries->je_cost_center=$Costtttsasdasd;
                    $journal_entries->save();

                    $JDate=$expense_transactionedit->et_date;
                    $JNo=$request->id;
                    $JMemo=$expense_transactionedit->et_memo;
                    $account=$ets->et_ad_product;
                    $debit= "";
                    $credit=-$ets->et_ad_total;
                    $description=$ets->et_ad_desc;
                    $name="";
                        

                    $journal_entries = new  JournalEntry;
                    $je_id_no++;
                    $journal_entries->je_id = $je_id_no;
                    $journal_entries->je_no=$JJJJNNNNOOO;
                    $journal_entries->other_no=$JNo;
                    $journal_entries->je_account=$account;
                    $journal_entries->je_debit=$debit;
                    $journal_entries->je_credit=$credit;
                    $journal_entries->je_desc=$description;
                    $journal_entries->je_name=$name;
                    $journal_entries->je_memo=$JMemo;
                    $journal_entries->created_at=$JDate;
                    $journal_entries->je_attachment=$JDate;
                    $journal_entries->je_transaction_type="Supplier Credit";
                    $journal_entries->je_cost_center=$Costtttsasdasd;
                    $journal_entries->save();
                }else{
                    $totalamount+=$ets->et_ad_total;
                    
                    $JDate=$expense_transactionedit->et_date;
                    $JNo=$request->id;
                    $JMemo=$expense_transactionedit->et_memo;
                    $account=$ets->et_ad_product;
                    $debit= $ets->et_ad_total;
                    $credit= "";
                    $description=$ets->et_ad_desc;
                    $name="";

                    $journal_entries = new  JournalEntry;
                    $jounal = DB::table('journal_entries')         ->select('je_no')         ->groupBy('je_no')         ->get();         $journal_entries_count=count($jounal)+1;
                    $je_id_no++;
                    $journal_entries->je_id = $je_id_no;
                    $journal_entries->je_no=$JJJJNNNNOOO;
                    $journal_entries->other_no=$JNo;
                    $journal_entries->je_account=$account;
                    $journal_entries->je_debit=$debit;
                    $journal_entries->je_credit=$credit;
                    $journal_entries->je_desc=$description;
                    $journal_entries->je_name=$name;
                    $journal_entries->je_memo=$JMemo;
                    $journal_entries->created_at=$JDate;
                    $journal_entries->je_attachment=$JDate;
                    $journal_entries->je_transaction_type="Bill";
                    $journal_entries->je_cost_center=$Costtttsasdasd;
                    $journal_entries->save();

                    $JDate=$expense_transactionedit->et_date;
                    $JNo=$request->id;
                    $JMemo=$expense_transactionedit->et_memo;
                    $account=$expense_transactionedit->et_credit_account;
                    $debit= "";
                    $credit= $ets->et_ad_total;
                    $description=$ets->et_ad_desc;
                    $name="";
                        

                    $journal_entries = new  JournalEntry;
                    $je_id_no++;
                    $journal_entries->je_id = $je_id_no;
                    $journal_entries->je_no=$JJJJNNNNOOO;
                    $journal_entries->other_no=$JNo;
                    $journal_entries->je_account=$account;
                    $journal_entries->je_debit=$debit;
                    $journal_entries->je_credit=$credit;
                    $journal_entries->je_desc=$description;
                    $journal_entries->je_name=$name;
                    $journal_entries->je_memo=$JMemo;
                    $journal_entries->created_at=$JDate;
                    $journal_entries->je_attachment=$JDate;
                    $journal_entries->je_transaction_type="Bill";
                    $journal_entries->je_cost_center=$Costtttsasdasd;
                    $journal_entries->save();

                }
                
                if($et_account->save()){
                    
                }
                
                
            }
            $totalamoun2t=0;
            foreach($et_accounteditr as $ets){
                if($expense_transactionedit->et_type="Bill"){
                    $totalamoun2t+=$ets->et_ad_total;

                }
            }
            $expense_transaction =ExpenseTransaction::find($request->id);
            $expense_transaction->bill_balance=$totalamoun2t;
            $expense_transaction->save();


            $customer = Customers::find($expense_transactionedit->et_customer);
            // $AuditLog= new AuditLog;
            // $AuditLogcount=AuditLog::count()+1;
            // $userid = Auth::user()->id;
            // $username = Auth::user()->name;
            // $eventlog="Updated ".$expense_transactionedit->et_type." No. ".$request->id;
            // $AuditLog->log_id=$AuditLogcount;
            // $AuditLog->log_user_id=$username;
            // $AuditLog->log_event=$eventlog;
            // $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
            // $AuditLog->log_transaction_date=$expense_transactionedit->et_date;
            // $AuditLog->log_amount=$totalamount;
            // $AuditLog->save();
            $exnew=ExpenseTransactionNew::where([
                ['et_no','=',$request->id],
                ['et_type','=','Bill']
            ])->first();
            $exnew->et_status="OK";
            $exnew->save();
            DB::table('et_account_details_edits')->where([
                ['et_ad_no','=', $request->id],
                ['et_ad_type','=', $request->type]
            ])->update([
                'edit_status'=>'OK'
            ]);
            DB::table('et_item_details_edits')->where([
                ['et_id_no','=', $request->id]
            ])->update([
                'edit_status'=>'OK'
            ]);
            $asdasd =ExpenseTransactionEdit::where([
                ['et_no','=',$request->id],
                ['et_type','=',$request->type]
            ])->first();
            $asdasd->edit_status = "OK";
            $asdasd->save();
        }
    }
    public function delete_expense_edit(Request $request){
            
            $asdasd =ExpenseTransactionEdit::where([
                ['et_no','=',$request->id],
                ['et_type','=',$request->type]
            ])->first();
            $asdasd->edit_status = "OK";
            $asdasd->save();

            DB::table('et_account_details_edits')->where([
                ['et_ad_no','=', $request->id],
                ['et_ad_type','=', $request->type]
            ])->update([
                'edit_status'=>'OK'
            ]);
            DB::table('et_item_details_edits')->where([
                ['et_id_no','=', $request->id]
            ])->update([
                'edit_status'=>'OK'
            ]);
    }
    public function update_credit_note_edit2(Request $request){
        $sales_transactionedit =SalesTransactionEdit::find($request->id);
        $sales_transaction =SalesTransaction::find($request->id);
        if(!empty($sales_transaction)){
            $sales_transaction->st_date = $sales_transactionedit->st_date;
            $sales_transaction->st_type = $sales_transactionedit->st_type;
            //$sales_transaction->st_term = $sales_transactionedit->st_term;
            $sales_transaction->st_customer_id = $sales_transactionedit->st_customer_id;
            //$sales_transaction->st_due_date = $sales_transactionedit->st_due_date;
            $sales_transaction->st_email = $sales_transactionedit->st_email;
            $sales_transaction->st_send_later = $sales_transactionedit->st_send_later;
            $sales_transaction->st_bill_address = $sales_transactionedit->st_bill_address;
            $sales_transaction->st_note = $sales_transactionedit->st_note;
            $sales_transaction->st_memo = $sales_transactionedit->st_memo;
            $sales_transaction->st_amount_paid = $sales_transactionedit->st_amount_paid;
            $sales_transaction->save();

            
            
            $csasd="";
            $value;
            $customer = Customers::find($sales_transactionedit->st_customer_id);
            DB::table('st_credit_notes')->where('st_cn_no', $request->id)->delete();
            $journalforcostcenter=DB::table('journal_entries')->where('other_no', $request->id)->get();
            $Costtttsasdasd="";
            $JJJJNNNNOOO="";
            foreach($journalforcostcenter as $sacxzxcasd){
                $JJJJNNNNOOO=$sacxzxcasd->je_no;
                $Costtttsasdasd=$sacxzxcasd->je_cost_center;
            }
            
            DB::table('journal_entries')->where('other_no', $request->id)->delete();
            //$st_invoiceedit =StInvoiceEdit::find($request->id);
            $st_invoiceedit=DB::table('st_credit_notes_edits')->where('st_cn_no', $request->id)->get();
            $c=0;

            

            foreach($st_invoiceedit as $st_iss){
                $st_credit_note = new StCreditNote;
                
                $st_credit_note->st_cn_no = $request->id;
                $st_credit_note->st_cn_product = $st_iss->st_cn_product;
                $st_credit_note->st_cn_desc = $st_iss->st_cn_desc;
                $st_credit_note->st_cn_qty = $st_iss->st_cn_qty;
                
                $st_credit_note->st_cn_rate = $st_iss->st_cn_rate;
                $st_credit_note->st_cn_total = $st_iss->st_cn_total;
                $st_credit_note->save();
                $product = ProductsAndServices::find($st_iss->st_cn_product);
                $email_array = explode(',', $sales_transactionedit->st_email);

                $value[$c-1] = [
                    'type' => 'Credit Note',
                    'name' => $customer->display_name,
                    'email' => $email_array,
                    'title' => 'CREDIT NOTE',
                    'note' => '',
                    'memo' => '',
                    'product_name' =>!empty($product)? $product->product_name : '',
                    'product_description' => $st_iss->st_cn_desc,
                    'product_quantity' => $st_iss->st_cn_qty,
                    'product_rate' => $st_iss->st_cn_rate,
                    'product_total' => $st_iss->st_cn_total,
                    'credit_total' => $st_iss->st_cn_total,
                ];
                
                $jounalcount=$JJJJNNNNOOO;
                $JDate=$sales_transactionedit->st_date;
                $JNo=$jounalcount;
                $JMemo=$sales_transactionedit->st_memo;
                $account="2";
                $debit= $st_iss->st_cn_total;
                $credit= "";
                $description=$st_iss->st_cn_desc;
                $name=$customer->display_name;
                
                
                $journal_entries = new  JournalEntry;
                $journal_entries_count=JournalEntry::count()+1;
                $journal_entries->je_id = "1";
                $journal_entries->je_no=$JNo;
                $journal_entries->je_account=$account;
                $journal_entries->je_debit=$debit;
                $journal_entries->je_credit=$credit;
                $journal_entries->je_desc=$description;
                $journal_entries->je_name=$name;
                $journal_entries->je_memo=$JMemo;
                $journal_entries->created_at=$JDate;
                $journal_entries->je_attachment=$JDate;
                $journal_entries->je_transaction_type="Credit Note";
                $journal_entries->je_cost_center=$Costtttsasdasd;
                $journal_entries->other_no=$request->id;
                $journal_entries->save();

                $JDate=$sales_transactionedit->st_date;
                $JNo=$jounalcount;
                $JMemo=$sales_transactionedit->st_memo;
                $account="4";
                $debit= "";
                $credit= $st_iss->st_cn_total;
                $description=$st_iss->st_cn_desc;
                $name=$customer->display_name;
                

                $journal_entries = new  JournalEntry;
                $journal_entries_count=JournalEntry::count()+1;
                $journal_entries->je_id = "2";
                $journal_entries->je_no=$JNo;
                $journal_entries->je_account=$account;
                $journal_entries->je_debit=$debit;
                $journal_entries->je_credit=$credit;
                $journal_entries->je_desc=$description;
                $journal_entries->je_name=$name;
                $journal_entries->je_memo=$JMemo;
                $journal_entries->created_at=$JDate;
                $journal_entries->je_attachment=$JDate;
                $journal_entries->je_transaction_type="Credit Note";
                $journal_entries->other_no=$request->id;
                $journal_entries->je_cost_center=$Costtttsasdasd;
                $journal_entries->save();
                $c++;
            }
            if($sales_transactionedit->st_send_later=="yes"){
                Mail::send(['text'=>'mail'], $value, function($message) use ($value)
                {
                    $company = Company::first();
                    $sales = Sales::first();
                    $expenses = Expenses::first();
                    $advance = Advance::first();
                    
                    $pdf = PDF::loadView('credit_note_pdf',compact('value', 'company', 'sales','expenses','advance'));
                    $attachment = $pdf->stream('credit_notice.pdf');
                    $message->attachData($attachment, 'credit_note.pdf');
        
                    $message->to($value[0]['email'],'Hello Mr/Mrs '.$value[0]['name'])->subject('This is a Invoice for '.$value[0]['name']);
                    $message->from('floydignified@gmail.com','Floyd Matabilas');
                });
            }
            
            DB::table('st_credit_notes_edits')->where('st_cn_no', $request->id)->delete();
            DB::table('sales_transaction_edits')->where('st_no', $request->id)->delete();
        }
    }
    public function delete_credit_note_edit(Request $request){
        DB::table('st_credit_notes_edits')->where('st_cn_no', $request->id)->delete();
        DB::table('sales_transaction_edits')->where('st_no', $request->id)->delete();
    }
    public function update_invoice_edit2(Request $request){
        

        $sales_transactionedit =SalesTransactionEdit::where([
            ['st_no','=',$request->id],
            ['st_type','=','Invoice'],
            ['st_location','=',$request->location],
            ['st_invoice_type','=',$request->type]
        ])->first();
        $sales_transaction =SalesTransaction::where([
            ['st_no','=',$request->id],
            ['st_type','=','Invoice'],
            ['st_location','=',$request->location],
            ['st_invoice_type','=',$request->type]
        ])->first();
        //return $sales_transaction;
        $debit_account="";
        $credit_account="";
        if(!empty($sales_transaction)){
            $sales_transaction->st_date = $sales_transactionedit->st_date;
            $sales_transaction->st_type = $sales_transactionedit->st_type;
            $sales_transaction->st_term = $sales_transactionedit->st_term;
            $sales_transaction->st_customer_id = $sales_transactionedit->st_customer_id;
            $sales_transaction->st_due_date = $sales_transactionedit->st_due_date;
            $sales_transaction->st_email = $sales_transactionedit->st_email;
            $sales_transaction->st_send_later = $sales_transactionedit->st_send_later;
            $sales_transaction->st_bill_address = $sales_transactionedit->st_bill_address;
            $sales_transaction->st_note = $sales_transactionedit->st_note;
            $sales_transaction->st_memo = $sales_transactionedit->st_memo;
            $sales_transaction->st_balance = $sales_transactionedit->st_balance;
            $sales_transaction->st_location = $sales_transactionedit->st_location;
            $sales_transaction->st_invoice_type = $sales_transactionedit->st_invoice_type;
            $sales_transaction->st_invoice_job_order = $sales_transactionedit->st_invoice_job_order;
            $sales_transaction->st_invoice_work_no = $sales_transactionedit->st_invoice_work_no;
            $sales_transaction->st_debit_account = $sales_transactionedit->st_debit_account;
            $sales_transaction->st_credit_account = $sales_transactionedit->st_credit_account;
            $sales_transaction->save();
            
            $csasd="";
            $value;
            $customer = Customers::find($sales_transactionedit->st_customer_id);
            $customer_name="";
            if ($customer->display_name!=""){
                $customer_name=$customer->display_name;
            }else{
                if ($customer->company_name!=""){
                    $customer_name=$customer->company_name;
                }else{
                    $customer_name=$customer->f_name." ".$customer->l_name;
                }
            }
            // StInvoice::where([
            //     ['st_i_no','=',$request->id],
            //     ['st_p_location','=',$request->location],
            //     ['st_p_invoice_type','=',$request->type]
            // ])->delete();
            $journalforcostcenter=DB::table('journal_entries')->where('other_no', $request->id)->get();
            
            //$st_invoiceedit =StInvoiceEdit::find($request->id);
            $st_invoiceedit=DB::table('st_invoice_edit')->where([
                ['st_i_no','=',$request->id],
                ['st_p_location','=',$request->location],
                ['st_p_invoice_type','=',$request->type],
                ['edit_status','=','0']
            ])->get();
            $c=0;
            DB::table('journal_entries')->where([
                ['other_no', $request->id],
                ['je_invoice_location_and_type','=',$request->location." ".$request->type]
            ])->update([
                'remark'=>'NULLED'
            ]);
            $je_id_no=0;
            foreach($st_invoiceedit as $st_iss){
                $Costtttsasdasd="";
                $JJJJNNNNOOO="";
                foreach($journalforcostcenter as $sacxzxcasd){
                    $JJJJNNNNOOO=$sacxzxcasd->je_no;
                    $Costtttsasdasd=$sacxzxcasd->je_cost_center;
                }
                $st_invoice =StInvoice::where([
                    ['st_i_no','=',$request->id],
                    ['st_p_location','=',$request->location],
                    ['st_p_invoice_type','=',$request->type],
                    ['st_i_item_no','=',$st_iss->st_i_item_no]
                ])->first();
                if(empty($st_invoice)){
                    $st_invoice = new StInvoice;
                }
                $st_invoice->st_i_no = $request->id;
                $st_invoice->st_i_item_no = $st_iss->st_i_item_no;
                $st_invoice->st_i_product = $st_iss->st_i_product;
                $st_invoice->st_i_desc = $st_iss->st_i_desc;
                $st_invoice->st_i_qty = $st_iss->st_i_qty;
                
                $st_invoice->st_i_rate = $st_iss->st_i_rate;
                $st_invoice->st_i_total = $st_iss->st_i_total;
                $st_invoice->st_p_location = $st_iss->st_p_location;
                $st_invoice->st_p_invoice_type = $st_iss->st_p_invoice_type;
                $st_invoice->st_p_cost_center = $st_iss->st_p_cost_center;
                $st_invoice->st_p_debit=$st_iss->st_p_debit;
                $st_invoice->st_p_credit=$st_iss->st_p_credit;
                $st_invoice->save();


                $product = ProductsAndServices::find($st_iss->st_i_product);
                $email_array = explode(',', $sales_transactionedit->st_email);

                $value[$c-1] = [
                    'type' => 'Invoice',
                    'name' => $customer_name,
                    'email' => $email_array,
                    'title' => 'INVOICE',
                    'note' => '',
                    'memo' => '',
                    'product_name' => !empty($product)? $product->product_name : '',
                    'product_description' => $st_iss->st_i_desc,
                    'product_quantity' => $st_iss->st_i_qty,
                    'product_rate' => $st_iss->st_i_rate,
                    'product_total' => $st_iss->st_i_total,
                    'credit_total' => $st_iss->st_i_total,
                ];
                $jounalcount=$JJJJNNNNOOO;
                $JDate=$sales_transactionedit->st_date;
                $JNo=$jounalcount;
                $JMemo=$sales_transactionedit->st_memo;
                $account=$st_iss->st_p_debit;
                $debit= $st_iss->st_i_total;
                $credit= "";
                $description=$st_iss->st_i_desc;
                $name=$customer_name;
                
                $je_id_no++;
                $journal_entries = new  JournalEntry;
                $journal_entries_count=JournalEntry::count()+1;
                $journal_entries->je_id =$je_id_no ;
                $journal_entries->je_no=$JNo;
                $journal_entries->je_account=$account;
                $journal_entries->je_debit=$debit;
                $journal_entries->je_credit=$credit;
                $journal_entries->je_desc=$description;
                $journal_entries->je_name=$name;
                $journal_entries->je_memo=$JMemo;
                $journal_entries->created_at=$JDate;
                $journal_entries->je_attachment=$JDate;
                $journal_entries->je_transaction_type="Invoice";
                $journal_entries->je_invoice_location_and_type=$request->location." ".$request->type;
                $journal_entries->je_cost_center=$st_iss->st_p_cost_center;
                $journal_entries->other_no=$request->id;
                $journal_entries->save();

                $JDate=$sales_transactionedit->st_date;
                $JNo=$jounalcount;
                $JMemo=$sales_transactionedit->st_memo;
                $account=$st_iss->st_p_credit;
                $debit= "";
                $credit= $st_iss->st_i_total;
                $description=$st_iss->st_i_desc;
                $name=$customer_name;
                
                $je_id_no++;
                $journal_entries = new  JournalEntry;
                $journal_entries_count=JournalEntry::count()+1;
                $journal_entries->je_id = $je_id_no;
                $journal_entries->je_no=$JNo;
                $journal_entries->je_account=$account;
                $journal_entries->je_debit=$debit;
                $journal_entries->je_credit=$credit;
                $journal_entries->je_desc=$description;
                $journal_entries->je_name=$name;
                $journal_entries->je_memo=$JMemo;
                $journal_entries->created_at=$JDate;
                $journal_entries->je_attachment=$JDate;
                $journal_entries->je_transaction_type="Invoice";
                $journal_entries->je_invoice_location_and_type=$request->location." ".$request->type;
                $journal_entries->other_no=$request->id;
                $journal_entries->je_cost_center=$st_iss->st_p_cost_center;
                $journal_entries->save();
                $c++;
            }
            
            $st_invoiceedit=SalesTransactionEdit::where([
                ['st_no','=',$request->id],
                ['st_location','=',$request->location],
                ['st_invoice_type','=',$request->type]
            ])->first();
            $st_invoiceedit->edit_status = "OK";
            $st_invoiceedit->save();
            DB::table('st_invoice_edit')->where([
                ['st_i_no','=',$request->id],
                ['st_p_location','=',$request->location],
                ['st_p_invoice_type','=',$request->type]
            ])->update([
                'edit_status'=>'OK'
            ]);
            //DB::table('st_invoice_edit')->where('st_i_no', $request->id)->delete();
            //DB::table('sales_transaction_edits')->where('st_no', $request->id)->delete();
        }
        

    
    }
    public function delete_invoice_edit(Request $request){
        DB::table('st_invoice_edit')->where([
            ['st_i_no','=',$request->id],
            ['st_p_location','=',$request->location],
            ['st_p_invoice_type','=',$request->type]
        ])->update([
            'edit_status'=>'OK'
        ]);
        $st_invoiceedit=SalesTransactionEdit::where([
            ['st_no','=',$request->id],
            ['st_location','=',$request->location],
            ['st_invoice_type','=',$request->type]
        ])->first();
        $st_invoiceedit->edit_status = "OK";
        $st_invoiceedit->save();
    }
    public function update_prod_edit(Request $request){
        $useredit=ProductAndServicesEdit::find($request->id);
        $user=ProductsAndServices::find($request->id);
        if(!empty($user)){
            $user->product_name=$useredit->product_name;
            $user->product_sku=$useredit->product_sku;
            $user->product_type=$useredit->product_type;
            $user->product_sales_description=$useredit->product_sales_description;
            $user->product_sales_price=$useredit->product_sales_price;
            $user->product_cost=$useredit->product_cost;
            $user->product_qty=$useredit->product_qty;
            $user->product_reorder_point=$useredit->product_reorder_point;
            if($user->save()){
                $useredit->edit_status="1";
                $useredit->save();
            }
        }
        

    }
    public function delete_prod_edit(Request $request){
        $useredit=ProductAndServicesEdit::find($request->id);
        $useredit->edit_status="1";
        $useredit->save();
    }
    public function update_Supplier_edit(Request $request){
        $customeredit =CustomerEdit::find($request->id);
        $customer =Customers::find($request->id);
        if(!empty($customer)){
            $customer->f_name = $customeredit->f_name;
            $customer->l_name = $customeredit->l_name;
            $customer->email = $customeredit->email;
            $customer->company = $customeredit->company;
            $customer->phone = $customeredit->phone;
            $customer->mobile = $customeredit->mobile;
            $customer->fax = $customeredit->fax;
            $customer->display_name = $customeredit->display_name;
            $customer->other = $customeredit->other;
            $customer->website = $customeredit->website;
            $customer->street = $customeredit->street;
            $customer->city = $customeredit->city;
            $customer->state = $customeredit->state;
            $customer->postal_code = $customeredit->postal_code;
            $customer->country = $customeredit->country;
            $customer->payment_method = $customeredit->payment_method;
            $customer->terms = $customeredit->terms;
            $customer->opening_balance = $customeredit->opening_balance;
            $customer->as_of_date = $customeredit->as_of_date;
            $customer->account_no = $customeredit->account_no;
            $customer->business_id_no = $customeredit->business_id_no;
            $customer->notes = $customeredit->notes;
            $customer->attachment = $customeredit->attachment;
            $customer->tin_no=$customeredit->tin_no;
            $customer->tax_type=$customeredit->tax_type;
            $customer->vat_value=$customeredit->vat_value;
            $customer->supplier_active="1";
            $customer->account_type="Supplier";
            $customer->business_style=$customeredit->business_style;
            if($customer->save()){
                $customeredit->edit_status="1";
                $customeredit->save();
            }

        }
        
        
    }
    public function delete_Supplier_edit(Request $request){
        $customeredit =CustomerEdit::find($request->id);
        $customeredit->edit_status="1";
        $customeredit->save();
    }
    public function update_Customer_edit(Request $request){
        $customeredit = CustomerEdit::find($request->id);
        $customer = Customers::find($request->id);
        if(!empty($customer)){
            $customer->f_name = $customeredit->f_name;
            $customer->l_name = $customeredit->l_name;
            $customer->email = $customeredit->email;
            $customer->company = $customeredit->company;
            $customer->phone = $customeredit->phone;
            $customer->mobile = $customeredit->mobile;
            $customer->fax = $customeredit->fax;
            $customer->display_name = $customeredit->display_name;
            $customer->other = $customeredit->other;
            $customer->website = $customeredit->website;
            $customer->street = $customeredit->street;
            $customer->city = $customeredit->city;
            $customer->state = $customeredit->state;
            $customer->postal_code = $customeredit->postal_code;
            $customer->country = $customeredit->country;
            $customer->payment_method = $customeredit->payment_method;
            $customer->terms = $customeredit->terms;
            $customer->opening_balance = $customeredit->opening_balance;
            $customer->as_of_date = $customeredit->as_of_date;
            $customer->account_no = $customeredit->account_no;
            $customer->business_id_no = $customeredit->business_id_no;
            $customer->notes = $customeredit->notes;
            $customer->tin_no=$customeredit->tin_no;
            $customer->withhold_tax=$customeredit->withhold_tax;
            $customer->business_style=$customeredit->business_style;
            if($customer->save()){
                $customeredit->edit_status="1";
                $customeredit->save();
            }
        }
        
    }
    public function delete_Customer_edit(Request $request){
        $customeredit = CustomerEdit::find($request->id);
        $customeredit->edit_status="1";
        $customeredit->save();
    }
    public function update_CC_edit(Request $request){
        $costcenterEdit=CostCenterEdit::find($request->id);
        $costcenter=CostCenter::find($request->id);
       
        if(!empty($costcenter)){
            $costcenter->cc_type_code=$costcenterEdit->cc_type_code; 
            $costcenter->cc_type=$costcenterEdit->cc_type; 
            $costcenter->cc_name_code=$costcenterEdit->cc_name_code; 
            $costcenter->cc_name=$costcenterEdit->cc_name;
            $costcenter->cc_status=$costcenterEdit->cc_status;  
            if($costcenter->save()){
                $costcenterEdit->edit_status="1";
                $costcenterEdit->save();
            }
        }
        
        
    }
    public function delete_CC_edit(Request $request){
        $costcenterEdit=CostCenterEdit::find($request->id);
        $costcenterEdit->edit_status="1";
        $costcenterEdit->save();
    }
    public function update_COA_edit(Request $request){
        $ChartEdit=COAEdits::find($request->id);
        $Chart=ChartofAccount::find($request->id);
        if(!empty($Chart)){
            $new_balance=0;
            $beg_balance_new=$Chart->coa_beginning_balance-$ChartEdit->coa_beginning_balance;
            $new_balance=$Chart->coa_balance-$beg_balance_new;
            $Chart->coa_account_type=$ChartEdit->coa_account_type;
            $Chart->coa_detail_type=$ChartEdit->coa_detail_type;
            $Chart->coa_name=$ChartEdit->coa_name;
            $Chart->coa_sub_account=$ChartEdit->coa_sub_account;
            $Chart->coa_description=$ChartEdit->coa_description;
            $Chart->coa_code=$ChartEdit->coa_code;
            $Chart->coa_balance=$new_balance;
            $Chart->normal_balance=$ChartEdit->normal_balance;
            $Chart->coa_beginning_balance=$ChartEdit->coa_beginning_balance;
            $Chart->coa_as_of_date=$ChartEdit->coa_as_of_date;
            $Chart->coa_title=$ChartEdit->coa_title;
            $Chart->coa_active=$ChartEdit->coa_active;
            $Chart->coa_cc=$ChartEdit->coa_cc;
            if($Chart->save()){
                $ChartEdit->edit_status="1";
                $ChartEdit->save();
            }
        }
        
        
    }
    public function delete_COA_edit(Request $request){
        $ChartEdit=COAEdits::find($request->id);
        $ChartEdit->edit_status="1";
        $ChartEdit->save();
    }
    public function update_bank_edit(Request $request){

        $BankEdit =BankEdits::find($request->id);
        $Bank =Bank::find($request->id);
        if(!empty($Bank)){

            $Bank->bank_name=$BankEdit->bank_name;
            $Bank->bank_code=$BankEdit->bank_code;
            $Bank->bank_branch=$BankEdit->bank_branch;
            $Bank->bank_account_no=$BankEdit->bank_account_no;
            $Bank->bank_remark=$BankEdit->bank_remark;
            $Bank->bank_status=$BankEdit->bank_status;
            if($Bank->save()){
                $BankEdit->edit_status="1";
                $BankEdit->save();
            }
        }
        
    }
    public function delete_bank_edit(Request $request){
        $BankEdit =BankEdits::find($request->id);
        $BankEdit->edit_status="1";
        $BankEdit->save();
    }
    public function deny_pending_bill(Request $request){
        $exnew=ExpenseTransactionNew::where([
            ['et_no','=',$request->id],
            ['et_type','=','Bill']
        ])->first();
        $exnew->et_status="OK";
        $exnew->save();
    }
    public function approve_pending_bill(Request $request){
        $et =ExpenseTransactionNew::where([
            ['et_no','=',$request->id],
            ['et_type','=','Bill']
        ])->get();
        if(!empty($et)){
            $expense_transaction = new ExpenseTransaction;
            $expense_transaction->et_no = $et[0]->et_no;
            $expense_transaction->et_customer =$et[0]->et_customer;
            $expense_transaction->et_terms = $et[0]->et_terms;
            $expense_transaction->et_billing_address = $et[0]->et_billing_address;
            $expense_transaction->et_bill_no =$et[0]->et_bill_no;
            $expense_transaction->et_date = $et[0]->et_date;
            $expense_transaction->et_due_date = $et[0]->et_due_date;
            $expense_transaction->et_memo = $et[0]->et_memo;
            $expense_transaction->et_attachment = $et[0]->et_attachment;
            $expense_transaction->et_shipping_address = $et[0]->et_shipping_address;
            $expense_transaction->et_shipping_to = $et[0]->et_shipping_to;
            $expense_transaction->et_shipping_via =$et[0]->et_shipping_via;
            $expense_transaction->et_credit_account=$et[0]->et_credit_account;
            $expense_transaction->et_type = $et[0]->et_type;
            $expense_transaction->save();

            
            $customer = Customers::find($et[0]->et_customer);
            $customer_name="";
            if ($customer->display_name!=""){
                $customer_name=$customer->display_name;
            }else{
                if ($customer->company_name!=""){
                    $customer_name=$customer->company_name;
                }else{
                    $customer_name=$customer->f_name." ".$customer->l_name;
                }
            }
            $totalamount=0;
            $et_a =EtAccountDetailNew::where([
                ['et_ad_no','=',$request->id],
                ['et_ad_type','=','Bill']
            ])->get();
            foreach($et_a as $ee){
                $et_account = new EtAccountDetail;
                $et_account->et_ad_no = $ee->et_ad_no ;
                $et_account->et_ad_product = $ee->et_ad_product ;
                $et_account->et_ad_desc = $ee->et_ad_desc;
                $et_account->et_ad_total = $ee->et_ad_total;
                $et_account->et_ad_rate = $ee->et_ad_rate;
                $et_account->et_ad_qty = $ee->et_ad_qty;
                $et_account->et_ad_type = $ee->et_ad_type;
                $totalamount+=$ee->et_ad_total;
                $et_account->save(); 


                $JDate=$et[0]->et_date;
                $JNo=$et[0]->et_no;
                $JMemo=$et[0]->et_memo;
                $account=$ee->et_ad_product;
                $debit= $ee->et_ad_total;
                $credit= "";
                $description=$ee->et_ad_desc;
                $name=$customer_name;

                $journal_entries = new  JournalEntry;
                $jounal = DB::table('journal_entries')         ->select('je_no')         ->groupBy('je_no')         ->get();         $journal_entries_count=count($jounal)+1;
                $journal_entries->je_id = "1";
                $journal_entries->je_no=$journal_entries_count;
                $journal_entries->other_no=$JNo;
                $journal_entries->je_account=$account;
                $journal_entries->je_debit=$debit;
                $journal_entries->je_credit=$credit;
                $journal_entries->je_desc=$description;
                $journal_entries->je_name=$name;
                $journal_entries->je_memo=$JMemo;
                $journal_entries->created_at=$JDate;
                $journal_entries->je_attachment=$JDate;
                $journal_entries->je_transaction_type="Bill";
                
                
                $journal_entries->je_cost_center=$et[0]->et_debit_account;
                $journal_entries->save();

                $JDate=$et[0]->et_date;
                $JNo=$et[0]->et_no;
                $JMemo=$et[0]->et_memo;
                $account=$et[0]->et_credit_account;
                $debit= "";
                $credit= $ee->et_ad_total;
                $description=$ee->et_ad_desc;
                $name=$customer_name;
                    

                $journal_entries = new  JournalEntry;
                
                $journal_entries->je_id = "2";
                $journal_entries->je_no=$journal_entries_count;
                $journal_entries->other_no=$JNo;
                $journal_entries->je_account=$account;
                $journal_entries->je_debit=$debit;
                $journal_entries->je_credit=$credit;
                $journal_entries->je_desc=$description;
                $journal_entries->je_name=$name;
                $journal_entries->je_memo=$JMemo;
                $journal_entries->created_at=$JDate;
                $journal_entries->je_attachment=$JDate;
                $journal_entries->je_transaction_type="Bill";
                
                $journal_entries->je_cost_center=$et[0]->et_debit_account;
                $journal_entries->save();
                // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * $request->input('select_product_rate'.$x);
                // $customer->save();
            }
            $expense_transaction =ExpenseTransaction::where([
                ['et_no','=',$request->id],
                ['et_type','=','Bill']
            ])->first();
            $expense_transaction->bill_balance=$totalamount;
            $customer->opening_balance = $customer->opening_balance + $totalamount;
            $customer->save();
            $expense_transaction->save();
            //check for error
            // $customer = Customers::find($et[0]->et_customer);
            // $AuditLog= new AuditLog;
            // $AuditLogcount=AuditLog::count()+1;
            // $userid = Auth::user()->id;
            // $username = Auth::user()->name;
            // $eventlog="Added Bill No. ".$request->id;
            // $AuditLog->log_id=$AuditLogcount;
            // $AuditLog->log_user_id=$username;
            // $AuditLog->log_event=$eventlog;
            // $AuditLog->log_name=$customer_name;
            // $AuditLog->log_transaction_date=$et[0]->et_date;
            // $AuditLog->log_amount=$totalamount;
            // $AuditLog->save();
            $exnew =ExpenseTransactionNew::where([
                ['et_no','=',$request->id],
                ['et_type','=','Bill']
            ])->first();
            $exnew->et_status="OK";
            $exnew->save();
            // ETAccountDetailNew::where([
            //     ['et_ad_no','=',$request->id],
            //     ['et_ad_type','=','Bill']
            // ])->delete();
        }
    }
    public function get_all_pending_transaction_request(Request $request){

        $bankedits=BankEdits::where([
            ['edit_status','=','0']
        ])->get();
        $bankeditscount=BankEdits::where([
            ['edit_status','=','0']
        ])->count();

        $costcenteredit=CostCenterEdit::where([
            ['edit_status','=','0']
        ])->get();
        $costcentereditcount=CostCenterEdit::where([
            ['edit_status','=','0']
        ])->count();

        $budgetedit=DB::connection('mysql')->select("SELECT *  FROM budget_edits
        LEFT JOIN chart_of_accounts ON chart_of_accounts.id=budget_edits.budget_chart_of_accounts WHERE edit_status!='1'");
        
        $budgeteditcount=BudgetsEdit::where([
            ['edit_status','!=','1']
        ])->count();

        $coaedits=COAEdits::where([
            ['edit_status','=','0']
        ])->get();
        $coaeditscount=COAEdits::where([
            ['edit_status','=','0']
        ])->count();

        $productservicesedit=ProductAndServicesEdit::where([
            ['edit_status','=','0']
        ])->get();
        $productserviceseditcount=ProductAndServicesEdit::where([
            ['edit_status','=','0']
        ])->count();

        $customeredit=CustomerEdit::where([
            ['edit_status','=','0'],
            ['account_type','=','Customer']
        ])->get();
        $supplieredit=CustomerEdit::where([
            ['edit_status','=','0'],
            ['account_type','=','Supplier']
        ])->get();
        $customereditcount=CustomerEdit::where([
            ['edit_status','=','0'],
            ['account_type','=','Customer']
        ])->count();
        $suppliereditcount=CustomerEdit::where([
            ['edit_status','=','0'],
            ['account_type','=','Supplier']
        ])->count();
        
        $etNew=DB::connection('mysql')->select("SELECT * FROM expense_transactions_new
        JOIN customers ON customers.customer_id=expense_transactions_new.et_customer
        WHERE et_status IS NULL");
        ExpenseTransactionNew::where([
            ['et_status','=',NULL]
        ])->get();
        $etNewcount=ExpenseTransactionNew::where([
            ['et_status','=',NULL]
        ])->count();
        $etaNew=ETAccountDetailNew::all();
        
        $etaNewcount=ETAccountDetailNew::count();
        $etaNewTotalAmount=DB::connection('mysql')->select("SELECT *,SUM(et_ad_total) as total_expense FROM et_account_details_new GROUP BY et_ad_no");

        

        $stinvoiceedit=StInvoiceEdit::all();
        $stinvoiceeditTotalAmount=DB::connection('mysql')->select("SELECT *,SUM(st_i_total) as total_sale FROM st_invoice_edit GROUP BY st_i_no,st_p_location,st_p_invoice_type");
        $salestransactioneditedit=DB::connection('mysql')->select("SELECT *  FROM sales_transaction_edits
        JOIN customers ON customers.customer_id=sales_transaction_edits.st_customer_id
        WHERE edit_status='0'");
        SalesTransactionEdit::where([
            ['edit_status','=','0']
        ])->get();
        $salestransactionediteditcount=SalesTransactionEdit::where([
            ['edit_status','=','0']
        ])->count();

        $expensetransactionedit=DB::connection('mysql')->select("SELECT *  FROM expense_transactions_edits
        LEFT JOIN customers ON customers.customer_id=expense_transactions_edits.et_customer
        WHERE edit_status='0'");
        $etitemdetailedit=EtItemDetailEdit::all();

        $etaccdetailedit=DB::connection('mysql')->select("SELECT *  FROM et_account_details_edits
        LEFT JOIN chart_of_accounts ON chart_of_accounts.id=et_account_details_edits.et_ad_product WHERE edit_status='0'");
        $etaccdetailedittotal_amount=DB::connection('mysql')->select("SELECT *,SUM(et_ad_total) as total_expense  FROM et_account_details_edits WHERE edit_status='0'
        GROUP BY et_ad_no");
        $expensetransactioneditcount=ExpenseTransactionEdit::where([
            ['edit_status','=','0']
        ])->count();
        
        $data = array(
            'bankedits' => $bankedits,
            'bankeditscount' => $bankeditscount,
            'costcenteredit' => $costcenteredit,
            'costcentereditcount' => $costcentereditcount,
            'budgetedit' => $budgetedit,
            'budgeteditcount' => $budgeteditcount,
            'coaedits' => $coaedits,
            'coaeditscount' => $coaeditscount,
            'productservicesedit' => $productservicesedit,
            'productserviceseditcount' => $productserviceseditcount,
            'customeredit' => $customeredit,
            'supplieredit' => $supplieredit,
            'customereditcount' => $customereditcount,
            'suppliereditcount' => $suppliereditcount,
            'etNew' => $etNew,
            'etNewcount' => $etNewcount,
            'etitemdetailedit' => $etitemdetailedit,
            'etaccdetailedit' => $etaccdetailedit,
            'stinvoiceedit' => $stinvoiceedit,
            'salestransactioneditedit' => $salestransactioneditedit,
            'salestransactionediteditcount' => $salestransactionediteditcount,
            'expensetransactionedit' => $expensetransactionedit,
            'expensetransactioneditcount' => $expensetransactioneditcount,
            'etaNew' =>$etaNew,
            'etaNewcount' =>$etaNewcount,
            'etaNewTotalAmount' => $etaNewTotalAmount,
            'stinvoiceeditTotalAmount' => $stinvoiceeditTotalAmount,
            'etaccdetailedittotal_amount' => $etaccdetailedittotal_amount

        );
        return response($data, 200);
    }
    public function get_user_current_access(Request $request){
        $all_system_users_access=DB::table('users_access_restrictions')->where([
            ['user_id','=',$request->id]
        ])->first();
        $all_system_users_cost_center_access=DB::table('user_cost_center_access')->where([
            ['use_id','=',$request->id]
        ])->get();
        $data = array(
            'all_system_users_access' => $all_system_users_access,
            'all_system_users_cost_center_access' => $all_system_users_cost_center_access

        );
        return response($data, 200);
    }
    public function get_users_count(Request $request){
        $pending_user_count= DB::table('users')->where([
            ['approved_status','=',0]
        ])->orWhere([
            ['approved_status','=',NULL]
        ])->count();
        $approved_user_count= DB::table('users')->where([
            ['approved_status','=',1]
        ])->count();
        $pending_user_list= DB::table('users')->where([
            ['approved_status','=',0]
        ])->orWhere([
            ['approved_status','=',NULL]
        ])->get();
        $approved_user_clist= DB::table('users')->where([
            ['approved_status','=',1]
        ])->get();
        $data = array(
            'approved_user_count' => $approved_user_count,
            'pending_user_count' => $pending_user_count,
            'pending_user_list' => $pending_user_list,
            'approved_user_clist' => $approved_user_clist

        );
        return response($data, 200);
    }
    public function getAllStudents() {
        
        $users = User::get()->toJson(JSON_PRETTY_PRINT);
        return response($users, 200);
    }
    public function getDashboardData(Request $request){
        $sales_transaction = DB::connection('mysql')->select("SELECT * FROM sales_transaction");
        
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
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
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
        $current_year=date('Y');
        $data = array(
            'current_year'=> $current_year,
            'month_selected_raw' => $month_selected_raw,
            'current_month_less_three' => $current_month_less_three,
            'current_month_less_three_due' => $current_month_less_three_due,
            'month_selected_less_three' => $month_selected_less_three,
            'year_less_three' => $year_less_three,
            'three_month' => $three_month,
            'one_month' => $one_month,
            'two_month' => $two_month,
            'current_month_less_two' => $current_month_less_two,
            'current_month_less_two_due' => $current_month_less_two_due,
            'month_selected_less_two' => $month_selected_raw,
            'year_less_two' => $year_less_two,
            'year_less_one' => $year_less_one,
            'current_month_less_one' => $current_month_less_one,
            'current_month_less_one_due' => $current_month_less_one_due,
            'current_month_due' => $current_month_due,
            'current_month' => $current_month,
            'overduetotal_amount' => $overduetotal_amount,
            'unuetotal_amount' => $unuetotal_amount,
            'total_invoice_receivable' => $total_invoice_receivable,
            'total_invoice_receivable_due' => $total_invoice_receivable_due
        );
        // $data = array(
        //     'month_selected_raw' => $month_selected_raw,
        //     'Total' => $countloop,
        //     'Skiped'  => $error_count,
        //     'Error_Log' =>$Log,
        //     'Extra'=>$extra
        // );
        return response($data, 200);
    }
    public function update_setting_company(Request $request){
        
        $company = Company::first();
        if(!empty($company)){
            $company->company_name = $request->company_name;
            $company->company_legal_name = $request->legal_name;
            $company->company_business_id_no = $request->business_id_no;
            $company->company_tax_form = $request->tax_form;
            $company->company_industry = $request->industry;
            $company->company_email = $request->company_email;
            $company->company_customer_facing_email = $request->customer_facing_email;
            $company->company_phone = $request->company_phone;
            $company->company_website = $request->website;
            $company->company_address = $request->company_address;
            $company->company_customer_facing_address = $request->customer_facing_address;
            $company->company_legal_address = $request->legal_address;
            $company->company_address_postal = $request->postal1;
            $company->facing_postal = $request->postal2;
            $company->legal_postal = $request->postal3;
            $company->company_tin_no = $request->com_tin_no;
            if ($request->hasFile('esignatory')) {
                $request->esignatory->storeAs('e_sig', $request->esignatory->getClientOriginalName());
                $company->esig = $request->esignatory->getClientOriginalName();
            }
            
            $company->save(); 
        }else{
            $company = new Company;
            $company->company_name = $request->company_name;
            $company->company_legal_name = $request->legal_name;
            $company->company_business_id_no = $request->business_id_no;
            $company->company_tax_form = $request->tax_form;
            $company->company_industry = $request->industry;
            $company->company_email = $request->company_email;
            $company->company_customer_facing_email = $request->customer_facing_email;
            $company->company_phone = $request->company_phone;
            $company->company_website = $request->website;
            $company->company_address = $request->company_address;
            $company->company_customer_facing_address = $request->customer_facing_address;
            $company->company_legal_address = $request->legal_address;
            $company->company_address_postal = $request->postal1;
            $company->facing_postal = $request->postal2;
            $company->legal_postal = $request->postal3;
            $company->company_tin_no = $request->com_tin_no;
            if ($request->hasFile('esignatory')) {
                $request->esignatory->storeAs('e_sig', $request->esignatory->getClientOriginalName());
                $company->esig = $request->esignatory->getClientOriginalName();
            }
            
            $company->save(); 
        }
    }
    public function update_user_access(Request $request){
       
        $userid_accounting=$request->userid_accounting;
		$access=$request->access;
        $ApprovalLevelProcurement=$request->ApprovalLevelProcurement;
        $Approvals=0;
		$Journal_Entry=0;
		$Sales=0;
		$Invoice=0;
		$Estimate=0;
		$Credit_Note=0;
		$Sales_Receipt=0;
		$Expense=0;
		$Bill=0;
		$Supplier_Credit=0;
		$Pay_Bills=0;
		$Reports=0;
		$Fund_Feeds=0;
		$Chart_of_Accounts=0;
		$Cost_Center=0;
		$Settings=0;
		$Procurement=0;
		$A_Pending_bill=0;
		$A_bank=0;
		$A_coa=0;
		$A_cc=0;
		$A_customer=0;
		$A_supplier=0;
		$A_product_services=0;
		$A_sales=0;
		$A_expense=0;
		$A_boq=0;
		$A_UAA=0;
        if($request->has('accesscostcenter')){
            $accesscostcenter=$request->accesscostcenter;
            UserCostCenterAccess::where([
                ['use_id','=',$userid_accounting]
            ])->delete();
            foreach($accesscostcenter as $acc){
                $CostCenter=new UserCostCenterAccess;
                $CostCenter->use_id=$userid_accounting;
                $CostCenter->cost_center_id=$acc;
                $CostCenter->access_status='1';
                $CostCenter->save();
            }
        }
        foreach($access as $re){
            if($re=="Approvals"){
                $Approvals=1;
            }
            if($re=="Procurement System"){
                $Procurement=1;
            }
            if($re=="Journal Entry"){
                $Journal_Entry=1;
            }
            if($re=="Sales"){
                $Sales=1;
            }
            if($re=="Invoice"){
                $Invoice=1;
            }
            if($re=="Estimate"){
                $Estimate=1;
            }
            if($re=="Credit Note"){
                $Credit_Note=1;
            }
            if($re=="Sales Receipt"){
                $Sales_Receipt=1;
            }
            if($re=="Expense"){
                $Expense=1;
            }
            if($re=="Bill"){
                $Bill=1;
            }
            if($re=="Supplier Credit"){
                $Supplier_Credit=1;
            }
            if($re=="Pay Bills"){
                $Pay_Bills=1;
            }
            if($re=="Reports"){
                $Reports=1;
            }
            if($re=="Fund Feeds"){
                $Fund_Feeds=1;
            }
            if($re=="Chart of Accounts"){
                $Chart_of_Accounts=1;
            }
            if($re=="Cost Center"){
                $Cost_Center=1;
            }
            if($re=="Settings"){
                $Settings=1;
            }
            if($re=="Pending Bills Approval"){
                $A_Pending_bill=1;
            }
            if($re=="Bank Approval"){
                $A_bank=1;
            }
            if($re=="Chart of Account Approval"){
                $A_coa=1;
            }
            if($re=="Cost Center Approval"){
                $A_cc=1;
            }
            if($re=="Customer Approval"){
                $A_customer=1;
            }
            if($re=="Supplier Approval"){
                $A_supplier=1;
            }
            if($re=="Product And Services Approval"){
                $A_product_services=1;
            }
            if($re=="Sales Transactions Approval"){
                $A_sales=1;
            }
            if($re=="Expense Transactions Approval"){
                $A_expense=1;
            }
            if($re=="Bid of Quotation Approval"){
                $A_boq=1;
            }
            if($re=="User Access Approval"){
                $A_UAA=1;
            }
        }
        $UserAccess=UserAccess::find($userid_accounting);
        if(empty($UserAccess)){
            $UserAccess=new UserAccess;
            $UserAccess->user_id=$userid_accounting;
        }
        $UserAccess->approvals=$Approvals;
        $UserAccess->journal_entry=$Journal_Entry;
        $UserAccess->sales=$Sales;
        $UserAccess->invoice=$Invoice;
        $UserAccess->estimate=$Estimate;
        $UserAccess->credit_note=$Credit_Note;
        $UserAccess->sales_receipt=$Sales_Receipt;
        $UserAccess->expense=$Expense;
        $UserAccess->bill=$Bill;
        $UserAccess->supplier_credit=$Supplier_Credit;
        $UserAccess->pay_bills=$Pay_Bills;
        $UserAccess->reports=$Reports;
        $UserAccess->fund_feeds=$Fund_Feeds;
        $UserAccess->chart_of_accounts=$Chart_of_Accounts;
        $UserAccess->cost_center=$Cost_Center;
        $UserAccess->settings=$Settings;
        $UserAccess->procurement_system=$Procurement;
        $UserAccess->procurement_sub=$ApprovalLevelProcurement;
        $UserAccess->approval_pending_bills=$A_Pending_bill;
        $UserAccess->approval_bank=$A_bank;
        $UserAccess->approval_coa=$A_coa;
        $UserAccess->approval_cc=$A_cc;
        $UserAccess->approval_customer=$A_customer;
        $UserAccess->approval_supplier=$A_supplier;
        $UserAccess->approval_product_services=$A_product_services;
        $UserAccess->approval_sales=$A_sales;
        $UserAccess->approval_expense=$A_expense;
        $UserAccess->approval_boq=$A_boq;
        $UserAccess->user_approval=$A_UAA;
        $UserAccess->save();
    }
    public function getAccount(Request $request){
        $users = ChartofAccount::where([
            ['coa_active','=','1']
        ])->get()->toJson(JSON_PRETTY_PRINT);
        return response($users, 200);
    }
    public function getSettingCompany(Request $request){
        $data = Company::first()->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }
    public function get_cost_center_list(Request $request){
        $cost_center_list_grouped= CostCenter::where('cc_status','1')->groupBy('cc_type')->orderBy('cc_type', 'asc')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type', 'asc')->get();
        $data = array(
            'cost_center_list_grouped' => $cost_center_list_grouped,
            'cost_center_list' => $cost_center_list
        );
        return response($data, 200);
    }
    public function getSettingSales(Request $request){
        $data = Sales::first()->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }
    public function getSettingExpense(Request $request){
        $data = Expenses::first()->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }
    public function getSettingAdvanceNumberring(Request $request){
        $data = Numbering::first()->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }
    public function getSettingAdvance(Request $request){
        $data = Advance::first()->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }
    public function getBanks(Request $request){
        $data = Bank::where([
            ['bank_status','=','1']
        ])->get()->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }
    public function getBankInfo(Request $request){
        $data = Bank::where([
            ['bank_no','=',$request->bank_id]
        ])->first()->toJson(JSON_PRETTY_PRINT);
        return response($data, 200);
    }
    
    public function update_setting_sales(Request $request){
        $sales = Sales::first();
        
        if(!empty($sales)){
        $sales->id ='0';
        $sales->sales_show_product_column = $request->show_product_column;
        $sales->sales_show_sku_column = $request->show_sku_column;
        $sales->sales_track_quantity_and_price = $request->track_quantity_and_price;
        $sales->sales_track_quantity_on_hand = $request->track_quantity_on_hand;
        
        $sales->sales_sales_receipt_preferred_debit_cheque_account = $request->preferred_bedit_cheque_account;
        
        $sales->save();
        }else{
            $sales = new Sales;
            $sales->id ='0';
            $sales->sales_show_product_column = $request->show_product_column;
            $sales->sales_show_sku_column = $request->show_sku_column;
            $sales->sales_track_quantity_and_price = $request->track_quantity_and_price;
            $sales->sales_track_quantity_on_hand = $request->track_quantity_on_hand;
            
            $sales->sales_sales_receipt_preferred_debit_cheque_account = $request->preferred_bedit_cheque_account;
            $sales->save();
        }
    }
    public function update_setting_expense(Request $request){
        $expenses = Expenses::first();
        if(!empty($expenses)){
            $expenses->id ='0';
            $expenses->expenses_show_items_table = $request->show_items_table;
            $expenses->expenses_track_expense_and_item_by_customer = $request->track_expense_and_item_by_customer;
            $expenses->expenses_billable = $request->billable;
            $expenses->expenses_bill_payment_terms = $request->bill_payment_terms;
            $expenses->expenses_use_purchase_order = $request->use_purchase_order;
            $expenses->expenses_purchase_order_email_message = $request->purchase_order_email_message;
            $expenses->save();
        }else{
            $expenses = new Expenses;
            $expenses->id ='0';
            $expenses->expenses_show_items_table = $request->show_items_table;
            $expenses->expenses_track_expense_and_item_by_customer = $request->track_expense_and_item_by_customer;
            $expenses->expenses_billable = $request->billable;
            $expenses->expenses_bill_payment_terms = $request->bill_payment_terms;
            $expenses->expenses_use_purchase_order = $request->use_purchase_order;
            $expenses->expenses_purchase_order_email_message = $request->purchase_order_email_message;
            $expenses->save();
        }
    }
    public function update_setting_advance(Request $request){
        //return $request;
        $numbering = Numbering::first();
        if(empty($numbering)){
            $numbering = new Numbering;
        }
        $numbering->numbering_no="0";
        $numbering->sales_exp_start_no=$request->numbering_sales_exp;
        $numbering->numbering_bill_invoice_main=$request->numbering_bill_invoice_main;
        $numbering->numbering_sales_invoice_branch=$request->numbering_sales_invoice_branch;
        $numbering->numbering_bill_invoice_branch=$request->numbering_bill_invoice_branch;

        $numbering->cash_voucher_start_no=$request->numbering_cash_voucher;
        $numbering->cheque_voucher_start_no=$request->numbering_cheque_voucher;
        $numbering->use_cost_center=$request->useCostCenter;

        $numbering->credit_note_start_no=$request->numbering_credit_note;
        $numbering->sales_receipt_start_no=$request->numbering_sales_receipt;
        $numbering->bill_start_no=$request->numbering_bill;
        $numbering->suppliers_credit_start_no=$request->numbering_suppliers_credit;
        $numbering->estimate_start_no=$request->numbering_estimate;
        
        $numbering->save();
        
        
        $advance = Advance::first();
        if(empty($advance)){
            $advance = new Advance;
        }
        $advance->id ='0';
        
        $advance->advance_first_month_of_fiscal_year = $request->first_month_of_fiscal_year;
        $advance->advance_first_month_of_tax_year = $request->first_month_of_tax_year;
        $advance->advance_accounting_method = $request->accounting_method;
        $advance->advance_close_book = $request->close_book;
        $advance->advance_end_month_of_fiscal_year = $request->end_month_of_fiscal_year;
        $advance->advance_beginning_balance = $request->ad_beg_bal;
        $advance->advance_enable_acc_number = $request->enable_acc_number;
        $advance->advance_date_format = $request->date_format;
        $advance->advance_number_format = $request->number_format;
        $advance->advance_inactive_time = $request->inactive_time;
        
        $advance->save();
    }
    public function add_bank(Request $request){
        
        $Bank = new Bank;
        $BankNo= Bank::count()+1;
        $Bank->bank_no=$BankNo;
        $Bank->bank_name=$request->BankNameInput;
        $Bank->bank_code=$request->BankCodeInput;
        $Bank->bank_branch=$request->BankBranchInput;
        
        $Bank->bank_account_no=$request->AccountNoInput;
        $Bank->bank_remark=$request->RemarkTextAreaBank;
        $Bank->save();

    }
    public function update_bank(Request $request){
        $Bank =BankEdits::find($request->BankNoHidden);
        if(empty($Bank)){
            $Bank = new BankEdits;
        }
        $Bank->bank_no=$request->BankNoHidden;
        $Bank->bank_name=$request->BankNameInputedit;
        $Bank->bank_code=$request->BankCodeInputedit;
        $Bank->bank_branch=$request->BankBranchInputEdit;
        $Bank->bank_account_no=$request->AccountNoInputedit;
        $Bank->bank_remark=$request->RemarkTextAreaBankedit;
        $Bank->edit_status="0";
        $Bank->save();
    }
    public function delete_bank(Request $request){
        $BankEdit =BankEdits::find($request->bank_id);
        $Bank =Bank::find($request->bank_id);
        if(empty($BankEdit)){
            $BankEdit = new BankEdits;
            
        }
        
        $BankEdit->bank_no=$request->bank_id;
        $BankEdit->bank_name=$Bank->bank_name;
        $BankEdit->bank_code=$Bank->bank_code;
        $BankEdit->bank_branch=$Bank->bank_branch;
        $BankEdit->bank_account_no=$Bank->bank_account_no;
        $BankEdit->bank_remark=$Bank->bank_remark;
        $BankEdit->bank_status="0";
        $BankEdit->edit_status="0";
        $BankEdit->save();
        
    }
    public function approve_user(Request $request){
        $id=$request->id;
        $user_position=$request->position;
        $Approvals=0;
		$Journal_Entry=0;
		$Sales=0;
		$Invoice=0;
		$Estimate=0;
		$Credit_Note=0;
		$Sales_Receipt=0;
		$Expense=0;
		$Bill=0;
		$Supplier_Credit=0;
		$Pay_Bills=0;
		$Reports=0;
		$Fund_Feeds=0;
		$Chart_of_Accounts=0;
		$Cost_Center=0;
        $Settings=0;
        if($user_position=="Sales"){
            $Sales=1;
            $Invoice=1;
            $Estimate=1;
            $Credit_Note=1;
            $Sales_Receipt=1;
            $Reports=1;
        }
        if($user_position=="Expenses"){
            $Expense=1;
            $Bill=1;
            $Supplier_Credit=1;
            $Pay_Bills=1;
            $Reports=1;
        }
        if($user_position=="A\P Local"){
            $Expense=1;
            $Bill=1;
            $Supplier_Credit=1;
            $Reports=1;
        }
        if($user_position=="A\P Others"){
            $Expense=1;
            $Pay_Bills=1;
            $Reports=1;
        }
        if($user_position=="A\R Sales Invoice"){
            $Sales=1;
            $Invoice=1;
            $Estimate=1;
            $Credit_Note=1;
            
            $Reports=1;
        }
        if($user_position=="A\R Collection"){
            $Sales_Receipt=1;
            $Reports=1;
        }
        if($user_position=="Intermediate"){
            $Reports=1;
            $Fund_Feeds=1;
            $Chart_of_Accounts=1;
            $Cost_Center=1;
        }
        if($user_position=="Executive"){
            $Approvals=1;
            $Journal_Entry=1;
            $Sales=1;
            $Invoice=1;
            $Estimate=1;
            $Credit_Note=1;
            $Sales_Receipt=1;
            $Expense=1;
            $Bill=1;
            $Supplier_Credit=1;
            $Pay_Bills=1;
            $Reports=1;
            $Fund_Feeds=1;
            $Chart_of_Accounts=1;
            $Cost_Center=1;
            $Settings=1;
        }
        $UserAccess=new UserAccess;
        $UserAccess->user_id=$id;
        $UserAccess->approvals=$Approvals;
        $UserAccess->journal_entry=$Journal_Entry;
        $UserAccess->sales=$Sales;
        $UserAccess->invoice=$Invoice;
        $UserAccess->estimate=$Estimate;
        $UserAccess->credit_note=$Credit_Note;
        $UserAccess->sales_receipt=$Sales_Receipt;
        $UserAccess->expense=$Expense;
        $UserAccess->bill=$Bill;
        $UserAccess->supplier_credit=$Supplier_Credit;
        $UserAccess->pay_bills=$Pay_Bills;
        $UserAccess->reports=$Reports;
        $UserAccess->fund_feeds=$Fund_Feeds;
        $UserAccess->chart_of_accounts=$Chart_of_Accounts;
        $UserAccess->cost_center=$Cost_Center;
        $UserAccess->settings=$Settings;
        $UserAccess->save();

        User::where([
            ['id','=',$id]
        ])->update([
            'approved_status'=>'1'
        ]);


    }
    public function deny_user(Request $request){
        $id=$request->id;
        User::where([
            ['id','=',$id]
        ])->update([
            'approved_status'=>'2'
        ]);
    }
    public function GetJournalEntryTemplateExcel(Request $request){
        
        //Excel::load('extra/edit_excel/Mass Adjustment Template.xlsx', function($file) {
            Excel::load('extra/edit_excel/Journal_Import Data.xlsx', function($doc) {
                $COA= ChartofAccount::where('coa_active','1')->get();
                $customers = Customers::all();
                $cost_center_list= CostCenter::where('cc_status','1')->get();
                $sheet = $doc->setActiveSheetIndex(1);
                $sheet2 = $doc->setActiveSheetIndex(2);
                $sheet3 = $doc->setActiveSheetIndex(3);
                $sheet1 = $doc->setActiveSheetIndex(0);
                $sheet1->getStyle("A")
                ->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
                $sheet1->getStyle("L")
                ->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
            $oro=0;
            $cuss=0;
            $cccc=0;
            foreach($COA as $coa){
                $oro++;
                $sheet->setCellValue('A'.$oro, $coa->coa_code);
                $sheet->setCellValue('B'.$oro, $coa->coa_name);
                
            }
            foreach($customers as $cus){
                $cuss++;
                $sheet2->setCellValue('A'.$cuss, $cus->display_name==""? $cus->f_name." ".$cus->l_name : $cus->display_name);
                
            }

            foreach($cost_center_list as $ccl){
                $cccc++;
                $sheet3->setCellValue('A'.$cccc, $ccl->cc_name_code);
                $sheet3->setCellValue('B'.$cccc, $ccl->cc_name);
            }
            
            for($c=1;$c<=$oro+$cuss;$c++){
                // $sheet->$doc->addNamedRange(
                //     new \PHPExcel_NamedRange(
                //     'Accounts', $sheet, 'L1:L'.$oro
                //     )
                // );
                $cplus=$c+1;
                $objValidation = $sheet1->getCell('C'.$cplus)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                
                $objValidation->setShowDropDown( true );
                $objValidation->setFormula1('ChartofAccounts!$A:$A');

                $objValidation = $sheet1->getCell('G'.$cplus)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                
                $objValidation->setShowDropDown( true );
                $objValidation->setFormula1('Names!$A:$A');

                // $objValidation = $sheet1->getCell('B'.$cplus)->getDataValidation();
                // $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                
                // $objValidation->setShowDropDown( true );
                // $objValidation->setFormula1('CostCenter!$A:$A');

                $objValidation = $sheet1->getCell('J'.$cplus)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                
                $objValidation->setShowDropDown( true );
                $objValidation->setFormula1('ChartofAccounts!$I2:$I3');
                
                //$objValidation->setFormula1('Accounts'); //note this!
            }
            })->setFilename('Import Template for Journal Entry '.date('m-d-Y'))->download('xlsx');
    }
    public function UploadMassJournalEntry(Request $request){
        $error_count=0;
        $saved_count=0;
        $countloop=0;
        $extra="";
        $Log="";
        $file = $request->file('theFile');
        $path = $file->getRealPath();
        $data = Excel::selectSheetsByIndex(0)->load($path, function($reader) {
        })->get();
       
        $JournalGroup = array();
        foreach($data as $row){
			$extra.=$row;
            array_push($JournalGroup, $row->journal_no); 
        }
        $GRROUP=array_unique($JournalGroup);
        
        foreach($GRROUP as $unique){
            $credit=0;
            $countloop=0;
            $debit=0;
            $rowcount=1;
            $valid=0;
            $individualjournalnocount=0;
            foreach($data as $row){
                $rowcount++;
                $countloop++;
                
                if($unique==$row->journal_no){
                    $individualjournalnocount++;
                    if($row->journal_type!=""){
                        if($row->journal_type=="Cheque Voucher" || $row->journal_type=="Journal Voucher"){
                            if($row->journal_date!=""){
                                
                                    if($row->journal_no!=""){
                                        if($row->account!=""){
                                            if($row->debit=="" && $row->credit==""){
                                                $valid=1; 
                                                //empty first name
                                                //$error_count++;
                                                $Log.="Empty Credit/Debit on row ".$rowcount." from file.\n"; 
                                            }else{
                                                if($row->debit!=""){
                                                    $debit+=$row->debit;
                                                }else{
                                                    $credit+=$row->credit;
                                                }
                                                
                                            }
                                        }else{
                                            $valid=1; 
                                            //empty first name
                                            //$error_count++;
                                            $Log.="Empty Account on row ".$rowcount." from file.\n"; 
                                        }
                                    }else{
                                        $valid=1; 
                                        //empty first name
                                        //$error_count++;
                                        $Log.="Empty Journal No on row ".$rowcount." from file.\n"; 
                                     }
                                
                            }else{
                                $valid=1; 
                                //empty first name
                                //$error_count++;
                                $Log.="Empty Journal Date on row ".$rowcount." from file.\n"; 
                            }
                        }else{
                            $valid=1; 
                            //empty first name
                            //$error_count++;
                            $Log.="Invalid Journal Type on row ".$rowcount." from file.\n"; 
                        }
                    }else{
                        $valid=1; 
                        //empty first name
                        //$error_count++;
                        $Log.="Empty Journal Type on row ".$rowcount." from file.\n"; 
                    }
                    
                }

            }
            if($valid==0){
                
                if(number_format($credit,2)==number_format($debit,2)){
                    $entrycount=0;
                    $jounal = DB::table('journal_entries')
                            ->select('je_no')
                            ->groupBy('je_no')
                            ->get();
                    $jounalcount=count($jounal)+1;
                    $jounal3 = count(JournalEntry::where([
                                ['journal_type','=','Cheque Voucher']
                            ])->groupBy('je_no')->get())+1;
                    $jounalcountchqeue=$jounal3;
                    $chequevoucher_no_series="";
                    if($jounalcountchqeue<10){
                        $chequevoucher_no_series="000".$jounalcountchqeue;
                    }
                    else if($jounalcountchqeue>9 && $jounalcountchqeue<100){
                        $chequevoucher_no_series="00".$jounalcountchqeue;
                    }else if($jounalcountchqeue>99 && $jounalcountchqeue<1000){
                        $chequevoucher_no_series="0".$jounalcountchqeue;
                    }
                    $jounal2 = count(JournalEntry::where([
                        ['journal_type','=','Journal Voucher']
                    ])->groupBy('je_no')->get())+1;
                    $jounalcountjournal=$jounal2;
                    $journalvoucher_no_series="";
                    if($jounalcountjournal<10){
                        $journalvoucher_no_series="000".$jounalcountjournal;
                    }
                    else if($jounalcountjournal>9 && $jounalcountjournal<100){
                        $journalvoucher_no_series="00".$jounalcountjournal;
                    }else if($jounalcountjournal>99 && $jounalcountjournal<1000){
                        $journalvoucher_no_series="0".$jounalcountjournal;
                    }
                    $Valid_je_no = []; 
                    $valid_coa=0;
                    $valid_cc=1;
                    foreach($data as $row){
                        if($unique==$row->journal_no){
                            $account=$row->account;
                            $COA= ChartofAccount::where('coa_code',$account)->first();
                            if(empty($COA)){
                                
                                $valid_coa=0;
                                break;
                            }else{
                                $valid_coa=1;
                            }
                            // $COA= CostCenter::where('cc_name_code',$row->cost_center)->first();
                            // if(empty($COA)){
                            //     $valid_cc=0; 
                            //     break;
                            // }else{
                            //     $valid_cc=1;     
                            // }
                            
                                

                        }
                    }
                    if($valid_cc==1 && $valid_coa==1){
                        foreach($data as $row){
                            if($unique==$row->journal_no){
                                $entrycount++;
                                $no=$entrycount;
                                $JDate=$row->journal_date;
                                
                                $JNo=$jounalcount;
                                $account=$row->account;
                                $COA= ChartofAccount::where('coa_code',$account)->first();
                                $account=$COA->id;
                                $debit= $row->debit;
                                $credit= $row->credit;
                                $description= $row->description;
                                $name=$row->name;
                                $journal_type=$row->journal_type;
                                $cheque_no=$row->cheque_no;
                                $reference=$row->reference;
                                $date_deposited=$row->date_deposited;
                                
                                $type="Journal Entry";
                                $CostCenter="";
                                
                                // $COA= CostCenter::where('cc_name_code',$row->cost_center)->first();
                                
                                // $CostCenter=$COA->cc_no;
                                
                                $journal_entries = new  JournalEntry;
                                $journal_entries->je_id = $no;//duplicate if multiple entry *for fix*
                                $journal_entries->je_no=$JNo;
                                $journal_entries->je_account=$account;
                                $journal_entries->je_debit=$debit;
                                $journal_entries->je_credit=$credit;
                                $journal_entries->je_desc=$description;
                                $journal_entries->je_name=$name;
                                $journal_entries->created_at=$JDate;
                                $journal_entries->je_attachment=$JDate;
                                $journal_entries->other_no="Journal-".$JNo;
                                $journal_entries->cheque_no=$cheque_no;
                                $journal_entries->ref_no=$reference;
                                $journal_entries->journal_type=$journal_type;
                                if($journal_type=="Cheque Voucher"){
                                    $journal_entries->je_series_no="CV".date('y').$chequevoucher_no_series;
                                }else{
                                    $journal_entries->je_series_no="JV".date('y').$journalvoucher_no_series;
                                }
                                $journal_entries->je_transaction_type=$type;
                                $journal_entries->je_cost_center=$CostCenter;
                                $journal_entries->date_deposited=$date_deposited;
                                        
                                $journal_entries->save();
                                // $AuditLog= new AuditLog;
                                // $AuditLogcount=AuditLog::count()+1;
                                // $userid = Auth::user()->id;
                                // $username = Auth::user()->name;
                                // $eventlog="Imported Journal Entry No. ".$JNo;
                                // $AuditLog->log_id=$AuditLogcount;
                                // $AuditLog->log_user_id=$username;
                                // $AuditLog->log_event=$eventlog;
                                // $AuditLog->log_name="";
                                // $AuditLog->log_transaction_date="";
                                // $AuditLog->log_amount="";
                                // $AuditLog->save();
                                $saved_count++;
                            }
                        }
                        
                    }else{
                        if($valid_cc==0){
                            $error_count+=$individualjournalnocount;
                            $Log.="Cost Center Code Not Found Not Found in Journal No ".$unique.".\n";
                        }
                        if($valid_coa==0){
                            $error_count+=$individualjournalnocount;
                            $Log.="Account Code Not Found in Journal No ".$unique.".\n"; 
                        }
                    }
                }else{
                    //empty first name
                    $error_count+=$individualjournalnocount;
                    $Log.="Debit and Credit not Equal in Journal No ".$unique." (".number_format($debit,2)."==".number_format($credit,2).")".".\n"; 
                }

            }else{
                $error_count+=$individualjournalnocount;
                $Log.="Skipped Journal No ".$unique.".\n"; 
            }


            
        }



        $data = array(
            'Success' => $saved_count,
            'Total' => $countloop,
            'Skiped'  => $error_count,
            'Error_Log' =>$Log,
            'Extra'=>$extra
        );
        return json_encode($data);
    }
}
