<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use File;
use Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
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
use Illuminate\Support\Facades\Storage;
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
class ApiController extends Controller
{
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/x-www-form-urlencoded');
        
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
}
