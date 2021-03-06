<?php

namespace App\Http\Controllers;
use App\Clients;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;
use App\UserAccess;
use App\Customers;
use App\CustomerEdit;
use App\SalesTransaction;
use App\StInvoice;
use App\StEstimate;
use App\StSalesReceipt;
use App\StRefundReceipt;
use App\StDelayedCharge;
use App\StDelayedCredit;
use App\StCreditNote;
use App\JournalEntry;
use App\ProductsAndServices;
use App\AuditLog;
use App\Voucher;
use Redirect;
use App\Formstyle;
use PDF;
use App\ChartofAccount;
use App\ExpenseTransaction;
use App\Company;
use App\Sales;
use App\Expenses;
use App\Advance;
use App\Numbering;
use App\CostCenter;
use App\ProductAndServicesEdit;
class CustomersController extends Controller
{
    public function __construct()
    {
        // $client=Clients::first();
        // $dbName='accounting_modified_'.$client->clnt_db_name;
            
        // DB::disconnect('mysql');//here connection name, I used mysql for example
        // Config::set('database.connections.mysql.database', $dbName);//new database name, you want to connect to.

    }
    public function GetTotalDeposited(Request $request){
        $FROM=$request->FROM;
        $TO=$request->TO;
        $CostCenterFilter=$request->CostCenterFilter;
        $SS=SalesTransaction::all();
        $sortsetting="WHERE st_date BETWEEN '".$FROM."' AND '".$TO."'";
        if($FROM=="" || $TO==""){
            $sortsetting="";
        }
        $SalesTransaction= DB::connection('mysql')->select("SELECT * FROM sales_transaction
                            ".$sortsetting." 
                            ORDER BY st_no ASC");
        $JournalEntry= DB::connection('mysql')->select("SELECT * FROM journal_entries
                    WHERE remark!='NULLED' ORDER BY created_at ASC");
        $totaldeposited=0;
        foreach($SalesTransaction as $ST){
            if($ST->st_type=="Sales Receipt" && $ST->st_action=="Deposited" && $ST->remark==""){

                if($CostCenterFilter=="All"){
                    $totaldeposited+=$ST->st_amount_paid;
                }else{
                    foreach ($JournalEntry as $JE){
                        if ($JE->other_no==$ST->st_no && $JE->je_id=="1" && $CostCenterFilter==$JE->je_cost_center){
                            $totaldeposited+=$ST->st_amount_paid; 
                            //echo  $ST->st_amount_paid." ";
                        }
                    }
                }
                

            }
            
        }
        return $totaldeposited;
    }
    public function add_customer_supplier(Request $request){
        // $DisplayNameCustomerSupplier=$request->DisplayNameCustomerSupplier;
        // $CustomerSupplierType=$request->CustomerSupplierType;
        // $customer = new Customers;
        // $customer->customer_id = Customers::count() + 1;
        // $customer->display_name = $DisplayNameCustomerSupplier;
        // $customer->account_type = $CustomerSupplierType;
        // $customer->save();

        //     $AuditLog= new AuditLog;
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
        $customers= Customers::where([
            ['supplier_active','=','1']
        ])->get();
        return $customers;
    }
    public function add_customer(Request $request)
    {
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
        $customer->account_type=$request->account_type;
        $customer->save();

        $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Added ".$request->account_type;
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name="";
            $AuditLog->log_transaction_date="";
            $AuditLog->log_amount="";
            $AuditLog->save(); 
    }
    public function add_invoice_journal(Request $request){
        $numbering = Numbering::first();
        $sales_number = SalesTransaction::count()+ExpenseTransaction::count() + $numbering->sales_exp_start_no;

        $sales_transaction = new SalesTransaction;
        $sales_transaction->st_no = $sales_number;
        $sales_transaction->st_date = $request->date;
        $sales_transaction->st_type = $request->transaction_type;
        $sales_transaction->st_term = $request->term;
        $sales_transaction->st_customer_id = $request->customer;
        $sales_transaction->st_due_date = $request->due_date;
        $sales_transaction->st_status = 'Open';
        $sales_transaction->st_action = '';
        $sales_transaction->st_email = $request->email;
        $sales_transaction->st_send_later = $request->send_later;
        $sales_transaction->st_bill_address = $request->bill_address;
        $sales_transaction->st_note = $request->note;
        $sales_transaction->st_memo = $request->memo;
        $sales_transaction->st_i_attachment = $request->attachment;
        $sales_transaction->st_balance = $request->total_balance;
        $sales_transaction->save();

        $customer = new Customers;
        $customer = Customers::find($request->customer);
        $value;
        for($x=0;$x<$request->product_count_journal;$x++){
            $st_invoice = new StInvoice;
            $st_invoice->st_i_no = $sales_number;
            $st_invoice->st_i_product = $request->input('select_product_name_journal'.$x);
            $st_invoice->st_i_desc = $request->input('select_product_description_journal'.$x);
            $st_invoice->st_i_qty = $request->input('product_qty_journal'.$x);
           
            $st_invoice->st_i_rate =  preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_journal'.$x));
            $st_invoice->st_i_total = $request->input('product_qty_journal'.$x) *  preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_journal'.$x));
            $st_invoice->st_p_method = null;
            $st_invoice->st_p_reference_no = null;
            $st_invoice->st_p_deposit_to = null;
            $st_invoice->save();

            $product = ProductsAndServices::find($request->input('select_product_name_journal'.$x));
            $email_array = explode(',', $request->email);

            $value[$x] = [
                'type' => 'Invoice',
                'name' => $customer->display_name,
                'email' => $email_array,
                'title' => 'INVOICE',
                'note' => $request->note,
                'memo' => $request->memo,
                'product_name' => !empty($product)? $product->product_name : '',
                'product_description' => $request->input('select_product_description_journal'.$x),
                'product_quantity' =>  preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_journal'.$x)),
                'product_rate' => $request->input('select_product_rate'.$x),
                'product_total' =>  preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_journal'.$x)) * $request->input('select_product_rate'.$x),
                'credit_total' => $request->total_balance,
            ];


            // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * $request->input('select_product_rate'.$x);
            // $customer->save();
        }
        if($request->send_later=="on"){
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
        if($request->generate_file_invoice_journal=="on"){
            set_time_limit(0);
            $company = Company::first();
            $sales = Sales::first();
            $expenses = Expenses::first();
            $advance = Advance::first();
            $pdf = PDF::loadView('credit_note_pdf',compact('value', 'company', 'sales','expenses','advance'));
            return $pdf->download('Invoice.pdf');
        }

        if($request->sales_transaction_number_estimate != '0'){
            $sales_transaction_estimate = SalesTransaction::where('st_no', $request->sales_transaction_number_estimate)->first();
            $sales_transaction_estimate->st_status = "Closed";
            $sales_transaction_estimate->save();
        }

        if($request->sales_transaction_number_delayed_charge != '0'){
            $sales_transaction_delayed_charge = SalesTransaction::where('st_no', $request->sales_transaction_number_delayed_charge)->first();
            $sales_transaction_delayed_charge->st_status = "Closed";
            $sales_transaction_delayed_charge->save();
        }

        if($request->sales_transaction_number_delayed_credit != '0'){
            $sales_transaction_delayed_credit = SalesTransaction::where('st_no', $request->sales_transaction_number_delayed_credit)->first();
            $sales_transaction_delayed_credit->st_status = "Closed";
            $sales_transaction_delayed_credit->save();
        }



        $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Added Invoice No. ".$sales_number;
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
            $AuditLog->log_transaction_date=$request->date;
            $AuditLog->log_amount=$request->total_balance;
            $AuditLog->save();
        return $sales_number;

    }
    public function set_journal_entry(Request $request){
        $ID=$request->id;
        $st_invoice = StInvoice::where('st_i_no',$ID)->get();
        return $st_invoice;
    }
    public function set_journal_entry_from_voucher(Request $request){
        $ID=$request->id;
        //$Voucher = Voucher::where('st_i_no',$ID)->get();
        $Voucherjournal_entry = DB::table('voucher_journal_entry')
           
            ->where('voucher_ref_no',$request->id)
            ->get();
        
        return $Voucherjournal_entry; 
    }
    public function findInvoiceNo(Request $request){
        
        $st_invoice = SalesTransaction::where([
            ['st_no','=',$request->value],
            ['st_type','=',"Invoice"],
            ['st_location', '=', $request->location_invoice],
            ['st_invoice_type','=',$request->type_invoice],
            ['remark','=',NULL]
        ])->first();
        $attachment=$st_invoice->st_i_attachment;
        $st_invoice = StInvoice::where([
            ['st_i_no','=',$request->value],
            ['st_p_location', '=', $request->location_invoice],
            ['st_p_invoice_type','=',$request->type_invoice],
            ['st_i_item_no','=',$request->invoice_item_no],
            ['st_p_reference_no','=',$attachment]
        ])->get();
        return $st_invoice;
    }
    public function findInvoiceNoCu(Request $request){
        $st_invoice = SalesTransaction::where([
            ['st_no','=',$request->value],
            ['st_type','=',"Invoice"],
            ['st_location', '=', $request->location_invoice],
            ['st_invoice_type','=',$request->type_invoice],
            ['remark','=',NULL]
        ])->get();
        return $st_invoice;
    }
    public function add_invoice(Request $request)
    {	
        
		$sss=explode(" - ",$request->customer);
		
		
        $numbering = Numbering::first();
        $sales_number=0;
        if($request->invoice_location_top=="Main"){
            if($request->invoice_type_top=="Sales Invoice"){
                $sales_number = SalesTransaction::where([
                    ['st_type','=','Invoice'],
                    ['st_location', '=', 'Main'],
                    ['st_invoice_type','=','Sales Invoice']
                ])->count() + $numbering->sales_exp_start_no;
            }else if($request->invoice_type_top=="Bill Invoice"){
                $sales_number = SalesTransaction::where([
                    ['st_type','=','Invoice'],
                    ['st_location', '=', 'Main'],
                    ['st_invoice_type','=','Bill Invoice']
                ])->count() + $numbering->numbering_bill_invoice_main;
            }
        }else if($request->invoice_location_top=="Branch"){
            if($request->invoice_type_top=="Sales Invoice"){
                $sales_number = SalesTransaction::where([
                    ['st_type','=','Invoice'],
                    ['st_location', '=', 'Branch'],
                    ['st_invoice_type','=','Sales Invoice']
                ])->count() + $numbering->numbering_sales_invoice_branch;
            }else if($request->invoice_type_top=="Bill Invoice"){
                $sales_number = SalesTransaction::where([
                    ['st_type','=','Invoice'],
                    ['st_location', '=', 'Branch'],
                    ['st_invoice_type','=','Bill Invoice']
                ])->count() + $numbering->numbering_bill_invoice_branch;
            }
        }
        

        
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
        $sales_transaction->st_send_later = $request->send_later;
        $sales_transaction->st_bill_address = $request->bill_address;
        $sales_transaction->st_note = $request->note;
        $sales_transaction->st_memo = $request->memo;
        $sales_transaction->st_i_attachment = $request->attachment;
        $sales_transaction->st_balance = $request->total_balance;
        $sales_transaction->st_invoice_job_order = $request->job_order_invoice;
        $sales_transaction->st_invoice_work_no = $request->work_no_invoice;
        $sales_transaction->st_debit_account = "";
        $sales_transaction->st_credit_account = "";
        $sales_transaction->st_i_attachment=$request->invoice_invoiceno."-".date("ljS\ofFYh:i:sA");
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
        for($x=0;$x<$request->product_count;$x++){
            $x2=$x+1;
            $st_invoice = new StInvoice;
            $st_invoice->st_i_no = $request->invoice_invoiceno;
            $st_invoice->st_i_item_no = $x2;
            
            $st_invoice->st_i_product = $request->input('select_product_name'.$x);
            $st_invoice->st_i_desc = $request->input('select_product_description'.$x);
            $st_invoice->st_i_qty = $request->input('product_qty'.$x);
            $st_invoice->st_i_rate = preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate'.$x));
            $st_invoice->st_i_total = $request->input('product_qty'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate'.$x));
            $st_invoice->st_p_method = null;
            $st_invoice->st_p_reference_no = $sales_transaction->st_i_attachment;
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

            $product = ProductsAndServices::find($request->input('select_product_name'.$x));
            $email_array = explode(',', $request->email);

            $value[$x] = [
                'type' => 'Invoice',
                'name' => $customer_name,
                'email' => $email_array,
                'title' => 'INVOICE',
                'note' => $request->note,
                'memo' => $request->memo,
                'product_name' => !empty($product)? $product->product_name : '',
                'product_description' => $request->input('select_product_description'.$x),
                'product_quantity' => $request->input('product_qty'.$x),
                'product_rate' => preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate'.$x)),
                'product_total' => $request->input('product_qty'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate'.$x)),
                'credit_total' => $request->total_balance,
            ];
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


            // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate'.$x));
            // $customer->save();


        }

        if($request->sales_transaction_number_estimate != '0'){
            $sales_transaction_estimate = SalesTransaction::where('st_no', $request->sales_transaction_number_estimate)->first();
            $sales_transaction_estimate->st_status = "Closed";
            $sales_transaction_estimate->save();
        }

        if($request->sales_transaction_number_delayed_charge != '0'){
            $sales_transaction_delayed_charge = SalesTransaction::where('st_no', $request->sales_transaction_number_delayed_charge)->first();
            $sales_transaction_delayed_charge->st_status = "Closed";
            $sales_transaction_delayed_charge->save();
        }

        if($request->sales_transaction_number_delayed_credit != '0'){
            $sales_transaction_delayed_credit = SalesTransaction::where('st_no', $request->sales_transaction_number_delayed_credit)->first();
            $sales_transaction_delayed_credit->st_status = "Closed";
            $sales_transaction_delayed_credit->save();
        }



        $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Added Invoice No. ".$request->invoice_invoiceno;
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
            $AuditLog->log_transaction_date=$request->date;
            $AuditLog->log_amount=$request->total_balance;
            $AuditLog->save(); 
            
        if($request->send_later=="yes"){
            Mail::send(['text'=>'mail'], $value, function($message) use ($value)
            {
                $company = Company::first();
                $sales = Sales::first();
                $expenses = Expenses::first();
                $advance = Advance::first();
                
                $pdf = PDF::loadView('credit_note_pdf',compact('value', 'company', 'sales','expenses','advance'));
                $attachment = $pdf->stream('credit_notice.pdf');
                $message->attachData($attachment, 'Invoice.pdf');
    
                $message->to($value[0]['email'],'Hello Mr/Mrs '.$value[0]['name'])->subject('This is a Invoice for '.$value[0]['name']);
                $message->from('floydignified@gmail.com','Floyd Matabilas');
            });
            
        }
        if($request->generate_file_invoice=="on"){
            set_time_limit(0);
            $company = Company::first();
            $sales = Sales::first();
            $expenses = Expenses::first();
            $advance = Advance::first();
            $pdf = PDF::loadView('credit_note_pdf',compact('value', 'company', 'sales','expenses','advance'));
            return $pdf->download('Invoice.pdf');
        }
        
    }

    public function add_payment(Request $request){

        $customer = Customers::find($request->payment_customer_id);
        // $customer->opening_balance = $customer->opening_balance - $request->p_amount;
        // $customer->save();
        $numbering = Numbering::first();
        $sales_number = SalesTransaction::count()+ExpenseTransaction::count() + $numbering->sales_exp_start_no;

        $sales_transaction = new SalesTransaction;
        $sales_transaction->st_no = $sales_number;
        $sales_transaction->st_date = $request->p_date;
        $sales_transaction->st_type = 'Payment';
        $sales_transaction->st_term = null;
        $sales_transaction->st_customer_id = $request->payment_customer_id;
        $sales_transaction->st_due_date = null;
        $sales_transaction->st_status = 'Closed';
        $sales_transaction->st_action = '';
        $sales_transaction->st_email = $request->p_email;
        $sales_transaction->st_send_later = $request->p_send_later;
        $sales_transaction->st_bill_address = null;
        $sales_transaction->st_note = null;
        $sales_transaction->st_memo = $request->p_memo;
        $sales_transaction->st_i_attachment = $request->p_attachment;
        $sales_transaction->st_amount_paid = $request->p_amount;
        $sales_transaction->st_payment_for = $request->sales_transaction_number;
        $sales_transaction->save();

        $st_invoice = new StInvoice;
        $st_invoice = StInvoice::where('st_i_no', $request->sales_transaction_number)->first();
        $st_invoice->st_p_method = $request->p_payment_method;
        $st_invoice->st_p_reference_no = $request->p_reference_no;
        $st_invoice->st_p_deposit_to = $request->p_deposit_to;
        $st_invoice->st_p_amount = $request->p_amount;
        $st_invoice->save();

        $JDate=$request->p_date;
        $JNo=$sales_number;
        $JMemo=$request->p_memo;
        $account="1";
        $debit= $request->p_amount;
        $credit= "";
        $description="";
        $name="";

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
        $journal_entries->je_transaction_type="Payment";
        $journal_entries->save();
        
        $JDate=$request->p_date;
        $JNo=$sales_number;
        $JMemo=$request->p_memo;
        $account="2";
        $debit= "";
        $credit= $request->p_amount;
        $description="";
        $name="";
            

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
        $journal_entries->je_transaction_type="Payment";
        $journal_entries->save();

        $old_invoice_transaction = SalesTransaction::find($request->sales_transaction_number);
        if($old_invoice_transaction->st_balance <= $request->p_amount){
            $old_invoice_transaction->st_balance = $old_invoice_transaction->st_balance - $request->p_amount;
            $old_invoice_transaction->st_status = 'Paid';
            $old_invoice_transaction->save();
        }else{
            $old_invoice_transaction->st_balance = $old_invoice_transaction->st_balance - $request->p_amount;
            $old_invoice_transaction->st_status = 'Partially paid';
            $old_invoice_transaction->save();
        }
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Added Payment";
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
            $AuditLog->log_transaction_date=$request->p_date;
            $AuditLog->log_amount=$request->p_amount;
            $AuditLog->save();

    }

    public function add_estimate(Request $request)
    {
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
        for($x=0;$x<$request->product_count_estimate;$x++){
            $st_estimate = new StEstimate;
            $st_estimate->st_e_no = $request->estimate_no;
            $st_estimate->st_e_product = $request->input('select_product_name_estimate'.$x);
            $st_estimate->st_e_desc = $request->input('select_product_description_estimate'.$x);
            $st_estimate->st_e_qty = $request->input('product_qty_estimate'.$x);
            
            $st_estimate->st_e_rate = preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_estimate'.$x));
            $st_estimate->st_e_total = $request->input('product_qty_estimate'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_estimate'.$x));
            $st_estimate->st_p_method = null;
            $st_estimate->st_p_reference_no = null;
            $st_estimate->st_p_deposit_to = null;
            $st_estimate->save();

            $product = ProductsAndServices::find($request->input('select_product_name_estimate'.$x));
            $email_array = explode(',', $request->e_email);
            $value[$x] = [
                'type' => 'Estimate',
                'name' => $customer->display_name,
                'email' => $email_array,
                'title' => 'ESTIMATE',
                'note' => $request->e_note,
                'memo' => $request->e_memo,
                'product_name' => !empty($product)? $product->product_name : '',
                'product_description' => $request->input('select_product_description_estimate'.$x),
                'product_quantity' => $request->input('product_qty_estimate'.$x),
                'product_rate' => preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_estimate'.$x)),
                'product_total' => $request->input('product_qty_estimate'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_estimate'.$x)),
                'credit_total' => $request->total_balance_estimate,
            ];
            
        }
        if($request->e_send_later=="on"){
            Mail::send(['text'=>'mail'], $value, function($message) use ($value)
            {
                $company = Company::first();
                $sales = Sales::first();
                $expenses = Expenses::first();
                $advance = Advance::first();
                
                $pdf = PDF::loadView('credit_note_pdf',compact('value', 'company', 'sales','expenses','advance'));
                $attachment = $pdf->stream('credit_notice.pdf');
                $message->attachData($attachment, 'credit_note.pdf');
    
                $message->to($value[0]['email'],'Hello Mr/Mrs '.$value[0]['name'])->subject('This is a Estimate for '.$value[0]['name']);
                $message->from('floydignified@gmail.com','Floyd Matabilas');
            });
        } 
            $customer = Customers::find($sss[0]);
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Added Estimate";
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
            $AuditLog->log_transaction_date=$request->e_date;
            $AuditLog->log_amount=$request->total_balance_estimate;
            $AuditLog->save();
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
        $sales_transaction->st_send_later = $request->sr_send_later;
        $sales_transaction->st_bill_address = $request->sr_bill_address;
        $sales_transaction->st_note = $request->sr_message;
        $sales_transaction->st_memo = $request->sr_memo;
        $sales_transaction->st_i_attachment = $request->sr_attachment;
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
            ['cancellation_reason','=',NULL],
        ])->first();
        $attachment=$old_invoice_transaction->st_i_attachment;
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
            ['st_p_reference_no','=',$attachment]
        ])->first();
        $st_invoice_item->st_p_amount=$st_invoice_item->st_p_amount+$request->hiddentotaldebitamountsalesreceipt;
        $st_invoice_item->save();

        $customer = new Customers;
        $customer = Customers::find($request->sr_customer);
        $customer = Customers::find($request->sr_customer);
        // $customer->opening_balance = $customer->opening_balance -$request->hiddentotaldebitamountsalesreceipt;
        // $customer->save();
        $AuditLog= new AuditLog;
        $AuditLogcount=AuditLog::count()+1;
        $userid = Auth::user()->id;
        $username = Auth::user()->name;
        $eventlog="Added Sales Receipt No.".$request->sales_receipt_no;
        $AuditLog->log_id=$AuditLogcount;
        $AuditLog->log_user_id=$username;
        $AuditLog->log_event=$eventlog;
        if($customer->display_name!=""){
            $AuditLog->log_name=$customer->display_name;
        }else{
            if($customer->company_name!=""){
                $AuditLog->log_name=$customer->company_name;
            }else{
                $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
            }
        }
        
        $AuditLog->log_transaction_date=$request->sr_date;
        $AuditLog->log_amount=$request->hiddentotaldebitamountsalesreceipt;
        $AuditLog->save();
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
        
        $value;
        for($x=0;$x<$request->product_count_sales_receipt;$x++){
            $st_sales_receipt = new StSalesReceipt;
            $st_sales_receipt->st_s_no = $request->sales_receipt_no;
            $st_sales_receipt->st_s_product = $request->input('select_product_name_sales_receipt'.$x);
            $st_sales_receipt->st_s_desc = $request->input('select_product_description_sales_receipt'.$x);
            $st_sales_receipt->st_s_qty = $request->input('product_qty_sales_receipt'.$x);
            
            $st_sales_receipt->st_s_rate = preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_sales_receipt'.$x));
            $st_sales_receipt->st_s_total = $request->input('product_qty_sales_receipt'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_sales_receipt'.$x));
            if($request->sr_payment_method=="Cash & Cheque"){
                $st_sales_receipt->st_p_method = "Cash";
            }else{
                $st_sales_receipt->st_p_method = $request->sr_payment_method;
            }
            $st_sales_receipt->st_p_reference_no = $request->sr_reference_no;
            $st_sales_receipt->st_p_deposit_to = $request->sr_deposit_to;
            $st_sales_receipt->st_p_amount = $request->sr_amount_paid;
            $st_sales_receipt->invoice_no_link = $request->invoiceno_sr;
            $st_sales_receipt->save();

            $product = ProductsAndServices::find($request->input('select_product_name_sales_receipt'.$x));
            $email_array = explode(',', $request->sr_email);

            $value[$x] = [
                'type' => 'Sales Receipt',
                'name' => $customer->display_name,
                'email' => $email_array,
                'title' => 'SALES RECEIPT',
                'note' => $request->note,
                'memo' => $request->memo,
                'product_name' => !empty($product)? $product->product_name : '',
                'product_description' => $request->input('select_product_description_sales_receipt'.$x),
                'product_quantity' => $request->input('product_qty_sales_receipt'.$x),
                'product_rate' => preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_sales_receipt'.$x)),
                'product_total' => $request->input('product_qty_sales_receipt'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_sales_receipt'.$x)),
                'credit_total' => $request->sr_amount_paid,
            ];
            
            
        }
        if($request->send_later=="on"){
            Mail::send(['text'=>'mail'], $value, function($message) use ($value)
            {
                $company = Company::first();
                $sales = Sales::first();
                $expenses = Expenses::first();
                $advance = Advance::first();
                
                $pdf = PDF::loadView('credit_note_pdf',compact('value', 'company', 'sales','expenses','advance'));
                $attachment = $pdf->stream('credit_notice.pdf');
                $message->attachData($attachment, 'credit_note.pdf');
    
                $message->to($value[0]['email'],'Hello Mr/Mrs '.$value[0]['name'])->subject('This is a Sales Receipt for '.$value[0]['name']);
                $message->from('floydignified@gmail.com','Floyd Matabilas');
            });
        }
        
        DB::connection('mysql')
        ->statement(
            DB::raw('UPDATE sales_transaction SET `st_balance`=?, `st_status`=? WHERE st_type=? AND cancellation_reason=?'),
            array("0","Closed","Sales Receipt",NULL)
        );
        $asdassssssssssasd="";
            
        return $asdassssssssssasd;
           
    }

    public function add_refund_receipt(Request $request)
    {
        $numbering = Numbering::first();
        $sales_number = SalesTransaction::count()+ExpenseTransaction::count() + $numbering->sales_exp_start_no;

        $sales_transaction = new SalesTransaction;
        $sales_transaction->st_no = $sales_number;
        $sales_transaction->st_date = $request->rr_date;
        $sales_transaction->st_type = $request->transaction_type_refund_receipt;
        $sales_transaction->st_term = null;
        $sales_transaction->st_customer_id = $request->rr_customer;
        $sales_transaction->st_due_date = null;
        $sales_transaction->st_status = 'Closed';
        $sales_transaction->st_action = '';
        $sales_transaction->st_email = $request->rr_email;
        $sales_transaction->st_send_later = $request->rr_send_later;
        $sales_transaction->st_bill_address = $request->rr_bill_address;
        $sales_transaction->st_note = $request->rr_message;
        $sales_transaction->st_memo = $request->rr_memo;
        $sales_transaction->st_i_attachment = $request->rr_attachment;
        $sales_transaction->st_balance = 0;
        $sales_transaction->save();

        $customer = new Customers;
        $customer = Customers::find($request->rr_customer);

        for($x=0;$x<$request->product_count_refund_receipt;$x++){
            $st_refund_receipt = new StRefundReceipt;
            $st_refund_receipt->st_r_no = $sales_number;
            $st_refund_receipt->st_r_product = $request->input('select_product_name_refund_receipt'.$x);
            $st_refund_receipt->st_r_desc = $request->input('select_product_description_refund_receipt'.$x);
            $st_refund_receipt->st_r_qty = $request->input('product_qty_refund_receipt'.$x);
            $st_refund_receipt->st_r_rate = $request->input('select_product_rate_refund_receipt'.$x);
            $st_refund_receipt->st_r_total = -$request->input('product_qty_refund_receipt'.$x) * $request->input('select_product_rate_refund_receipt'.$x);
            $st_refund_receipt->st_p_method = $request->rr_payment_method;
            $st_refund_receipt->st_p_reference_no = null;
            $st_refund_receipt->st_p_deposit_to = $request->rr_refund_from;
            $st_refund_receipt->st_p_amount = $request->rr_amount_refunded;
            $st_refund_receipt->save();

        }
            $customer = Customers::find($request->rr_customer);
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Added Refund Receipt No.".$sales_number;
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
            $AuditLog->log_transaction_date=$request->rr_date;
            $AuditLog->log_amount=$request->rr_amount_refunded;
            $AuditLog->save();
    }


    public function add_delayed_charge(Request $request)
    {
        $numbering = Numbering::first();
        $sales_number = SalesTransaction::count()+ExpenseTransaction::count() + $numbering->sales_exp_start_no;

        $sales_transaction = new SalesTransaction;
        $sales_transaction->st_no = $sales_number;
        $sales_transaction->st_date = $request->dc_date;
        $sales_transaction->st_type = $request->transaction_type_delayed_charge;
        $sales_transaction->st_term = null;
        $sales_transaction->st_customer_id = $request->dc_customer;
        $sales_transaction->st_due_date = $request->dc_date;
        $sales_transaction->st_status = 'Open';
        $sales_transaction->st_action = '';
        $sales_transaction->st_email = null;
        $sales_transaction->st_send_later = null;
        $sales_transaction->st_bill_address = null;
        $sales_transaction->st_note = null;
        $sales_transaction->st_memo = $request->dc_memo;
        $sales_transaction->st_i_attachment = $request->dc_attachment;
        $sales_transaction->st_balance = 0;
        $sales_transaction->save();

        $customer = new Customers;
        $customer = Customers::find($request->dc_customer);

        for($x=0;$x<$request->product_count_delayed_charge;$x++){
            $st_delayed_charge = new StDelayedCharge;
            $st_delayed_charge->st_dc_no = $sales_number;
            $st_delayed_charge->st_dc_product = $request->input('select_product_name_delayed_charge'.$x);
            $st_delayed_charge->st_dc_desc = $request->input('select_product_description_delayed_charge'.$x);
            $st_delayed_charge->st_dc_qty = $request->input('product_qty_delayed_charge'.$x);
            $st_delayed_charge->st_dc_rate = $request->input('select_product_rate_delayed_charge'.$x);
            $st_delayed_charge->st_dc_total = $request->input('product_qty_delayed_charge'.$x) * $request->input('select_product_rate_delayed_charge'.$x);
            $st_delayed_charge->st_p_method = null;
            $st_delayed_charge->st_p_reference_no = null;
            $st_delayed_charge->st_p_deposit_to = null;
            $st_delayed_charge->st_p_amount = null;
            $st_delayed_charge->save();

        }
            $customer = Customers::find($request->dc_customer);
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Added Delayed Charge No.".$sales_number;
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
            $AuditLog->log_transaction_date=$request->dc_date;
            $AuditLog->log_amount="";
            $AuditLog->save();
    }

    public function add_delayed_credit(Request $request)
    {
        $numbering = Numbering::first();
        $sales_number = SalesTransaction::count()+ExpenseTransaction::count() + $numbering->sales_exp_start_no;

        $sales_transaction = new SalesTransaction;
        $sales_transaction->st_no = $sales_number;
        $sales_transaction->st_date = $request->dcredit_date;
        $sales_transaction->st_type = $request->transaction_type_delayed_credit;
        $sales_transaction->st_term = null;
        $sales_transaction->st_customer_id = $request->dcredit_customer;
        $sales_transaction->st_due_date = $request->dcredit_date;
        $sales_transaction->st_status = 'Open';
        $sales_transaction->st_action = '';
        $sales_transaction->st_email = null;
        $sales_transaction->st_send_later = null;
        $sales_transaction->st_bill_address = null;
        $sales_transaction->st_note = null;
        $sales_transaction->st_memo = $request->dcredit_memo;
        $sales_transaction->st_i_attachment = $request->dcredit_attachment;
        $sales_transaction->st_balance = 0;
        $sales_transaction->save();

        $customer = new Customers;
        $customer = Customers::find($request->dc_customer);

        for($x=0;$x<$request->product_count_delayed_credit;$x++){
            $st_delayed_credit = new StDelayedCredit;
            $st_delayed_credit->st_dcredit_no = $sales_number;
            $st_delayed_credit->st_dcredit_product = $request->input('select_product_name_delayed_credit'.$x);
            $st_delayed_credit->st_dcredit_desc = $request->input('select_product_description_delayed_credit'.$x);
            $st_delayed_credit->st_dcredit_qty = $request->input('product_qty_delayed_credit'.$x);
            $st_delayed_credit->st_dcredit_rate = $request->input('select_product_rate_delayed_credit'.$x);
            $st_delayed_credit->st_dcredit_total = -$request->input('product_qty_delayed_credit'.$x) * $request->input('select_product_rate_delayed_credit'.$x);
            $st_delayed_credit->st_p_method = null;
            $st_delayed_credit->st_p_reference_no = null;
            $st_delayed_credit->st_p_deposit_to = null;
            $st_delayed_credit->st_p_amount = null;
            $st_delayed_credit->save();

        }
        $customer = Customers::find($request->dc_customer);
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Added Delayed Credit No.".$sales_number;
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
            $AuditLog->log_transaction_date=$request->dcredit_date;
            $AuditLog->log_amount="";
            $AuditLog->save();
    }

    public function add_credit_note(Request $request)
    {
        $sss=explode(" - ",$request->cn_customer);
        $numbering = Numbering::first();
        $sales_number = SalesTransaction::where('st_type','Credit Note')->count() + $numbering->credit_note_start_no;
        
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
        $AuditLog= new AuditLog;
        $AuditLogcount=AuditLog::count()+1;
        $userid = Auth::user()->id;
        $username = Auth::user()->name;
        $eventlog="Added Credit Note No.".$request->credit_note_no;
        $AuditLog->log_id=$AuditLogcount;
        $AuditLog->log_user_id=$username;
        $AuditLog->log_event=$eventlog;
        $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
        $AuditLog->log_transaction_date=$request->cn_date;
        $AuditLog->log_amount="-".$request->total_balance_credit_note;
        $AuditLog->save();
        $customer = new Customers;
        $customer = Customers::find($sss[0]);
        // $customer->opening_balance = $customer->opening_balance -$request->total_balance_credit_note;
        // $customer->save();
        $value;

        for($x=0;$x<$request->product_count_credit_note;$x++){
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

            $product = ProductsAndServices::find($request->input('select_product_name_credit_note'.$x));

            $email_array = explode(',', $request->cn_email);

            $value[$x] = [
                'type' => 'Credit Note',
                'name' => $customer->display_name,
                'email' => $email_array,
                'title' => 'CREDIT NOTE',
                'note' => $request->cn_message,
                'memo' => $request->cn_memo,
                'product_name' => $product->product_name,
                'product_description' => $request->input('select_product_description_credit_note'.$x),
                'product_quantity' => $request->input('product_qty_credit_note'.$x),
                'product_rate' => preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_credit_note'.$x)),
                'product_total' => $request->input('product_qty_credit_note'.$x) * preg_replace("/[^0-9\.]/", "", $request->input('select_product_rate_credit_note'.$x)),
                'credit_total' => $request->total_balance_credit_note,
            ];
        }
        
        if($request->cn_send_later=="on"){
            Mail::send(['text'=>'mail'], $value, function($message) use ($value)
            {
                $company = Company::first();
                $sales = Sales::first();
                $expenses = Expenses::first();
                $advance = Advance::first();
                
                $pdf = PDF::loadView('credit_note_pdf',compact('value', 'company', 'sales','expenses','advance'));
                $attachment = $pdf->stream('credit_notice.pdf');
                $message->attachData($attachment, 'credit_note.pdf');
    
                $message->to($value[0]['email'],'Hello Mr/Mrs '.$value[0]['name'])->subject('This is a credit note for '.$value[0]['name']);
                $message->from('floydignified@gmail.com','Floyd Matabilas');
            });
        }
        //return $value;
        
        
    }

    public function getcustomerinfo(Request $request){
        $customer_id=$request->input('customer_id');
        $sales_transaction = DB::table('sales_transaction')
            ->where([
                ['st_customer_id', '=', $customer_id],
            ])
            ->get();
            $customers= Customers::where([
                ['supplier_active','=','1']
            ])->get();
        $picked= Customers::find($customer_id);
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
            ->where([
                ['et_customer', '=', $customer_id],
            ])
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
        return view('app.customerinfo', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','VoucherCount','sales_transaction','customers', 'products_and_services','JournalEntry','jounalcount','picked'));
    }
    public function update_customer_note(Request $request){
        $id=$request->id;
        $note=$request->note;
        $customer=Customers::find($id);
        $customer->notes = $note;
        if($customer->save()){
            return 1;
        }else{
            return 0;
        }

    }
    public function submit_delete_request_customer(Request $request){
        $customeredit = Customers::find($request->id);
        $customer = CustomerEdit::find($request->id);
        if(empty($customer)){
            $customer = new CustomerEdit;
        }
        $customer->customer_id = $customeredit->customer_id;
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
        $customer->supplier_active="0";
        $customer->edit_status="0";
        if($customer->save()){
           
        }
        
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
            $customer->supplier_active=$customeredit->supplier_active;
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
    public function update_customer(Request $request){

        $customer = CustomerEdit::find($request->customer_id);
        if(empty($customer)){
            $customer = new CustomerEdit;
        }
        $customer->customer_id=$request->customer_id;
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
        $customer->tin_no=$request->tin_no;
        $customer->withhold_tax=$request->withholdingtax;
        $customer->business_style=$request->business_style;
        $customer->edit_status="0";
        $customer->save();

        // $AuditLog= new AuditLog;
        // $AuditLogcount=AuditLog::count()+1;
        // $userid = Auth::user()->id;
        // $username = Auth::user()->name;
        // $eventlog="Updated Customer";
        // $AuditLog->log_id=$AuditLogcount;
        // $AuditLog->log_user_id=$username;
        // $AuditLog->log_event=$eventlog;
        // $AuditLog->log_name="";
        // $AuditLog->log_transaction_date="";
        // $AuditLog->log_amount="";
        // $AuditLog->save();

        return Redirect::to('customerinfo/?customer_id='.$request->customer_id);
    }
    public function refresh_customers_table(){
        $customers = Customers::where([
            ['account_type','=','Customer'],
            ['supplier_active','=','1']
        ])->get();
        return \DataTables::of($customers)
        ->addColumn('opening_balance', function($customers){
            $name=$customers->display_name!=""? $customers->display_name: $customers->f_name." ".$customers->l_name;
            $journal = DB::connection('mysql')->select("SELECT * FROM `journal_entries` WHERE je_name=\"$name\" AND (je_name!='' AND je_name IS NOT NULL ) AND (je_debit!='' AND je_debit IS NOT NULL) AND (remark='' AND remark IS NULL)");
            //SELECT * FROM `journal_entries` WHERE je_name='ACTIVE COMPONETS IT PRODUCTS & SERVICES' AND (je_name!='' AND je_name IS NOT NULL ) AND (je_debit!='' AND je_debit IS NOT NULL)
            $total_balance=$customers->opening_balance;
            foreach($journal as $je){
                $total_balance+=$je->je_debit;
            }
            return number_format($total_balance,2);
        })
        ->addColumn('display_name', function($customers){
            if($customers->display_name!=""){
                return $customers->display_name;
            }else{
                return $customers->f_name." ".$customers->l_name;
            }
        })
        ->addColumn('action', function($customers){
            return "<button class='btn btn-danger btn-sm' onclick='delete_customer(".$customers->customer_id.")'><span class='fa fa-times'></span></button>";
        })
        
        ->make(true);
    }

    public function refresh_sales_table(Request $request){
        $begdate=$request->beginning;
        $enddate=$request->end;
        $sales_transaction = DB::connection('mysql')->select("SELECT * FROM sales_transaction LEFT JOIN customers ON customers.customer_id=sales_transaction.st_customer_id WHERE st_date BETWEEN '$begdate' AND '$enddate' AND st_type!='Sales Receipt' ");
        
        return \DataTables::of($sales_transaction)
        
        ->addColumn('action', function($sales_transaction){
            $usersrestriction=UserAccess::where('user_id',Auth::user()->id)->get();
            
            if($sales_transaction->st_status == "Open" && $sales_transaction->st_type == "Invoice" || $sales_transaction->st_status == "Partially paid" && $sales_transaction->st_type == "Invoice"){
                if($sales_transaction->remark==""){
                    $withpayment=0;
                    
                    if($withpayment==1){

                    }else{
                        if($usersrestriction[0]->invoice=="1"){
                            $STInvoice= STInvoice::where([
                                ['st_i_no','=',$sales_transaction->st_no],
                                ['st_p_invoice_type','=',$sales_transaction->st_invoice_type],
                                ['st_p_location','=',$sales_transaction->st_location],
                                ['st_p_reference_no','=',$sales_transaction->st_i_attachment]
                            ])->get();
                            $options="";

                            foreach($STInvoice as $sti){
                                if($sti->st_i_total>$sti->st_p_amount){
                                    $label="";
                                    if($sti->st_i_desc!=""){
                                        $label=$sti->st_i_desc;
                                    }else if($sti->st_p_cost_center!=""){
                                        $cost_centers= CostCenter::where([
                                            ['cc_no','=',$sti->st_p_cost_center]
                                        ])->first();
                                        $label=$cost_centers->cc_name;
                                    }else if($sti->st_i_product!=""){
                                        $procustss= ProductsAndServices::where([
                                            ['product_id','=',$sti->st_i_product]
                                        ])->first();
                                        $label=$procustss->product_name;
                                    }
                                    $options.='<a class="dropdown-item receive_payment" data-invoice_item_no="'.$sti->st_i_item_no.'" id="'.$sales_transaction->st_no.'" href="#" data-invoice_location="'.$sales_transaction->st_location.'" data-invoice_type="'.$sales_transaction->st_invoice_type.'" data-toggle="modal" data-target="#salesreceiptmodal">'.$label.'</a>';
                                }else{
                                    $label="";
                                    if($sti->st_i_desc!=""){
                                        $label=$sti->st_i_desc;
                                    }else if($sti->st_p_cost_center!=""){
                                        $cost_centers= CostCenter::where([
                                            ['cc_no','=',$sti->st_p_cost_center]
                                        ])->first();
                                        $label=$cost_centers->cc_name;
                                    }else if($sti->st_i_product!=""){
                                        $procustss= ProductsAndServices::where([
                                            ['product_id','=',$sti->st_i_product]
                                        ])->first();
                                        $label=$procustss->product_name;
                                    }
                                    $options.='<a class="dropdown-item disabled" href="#" >'.$label.'(Paid)</a>'; 
                                }
                                
                            }
                            
                            return '<div class="dropdown"><button class="btn btn-link btn-sm" style="font-size:11px;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Receive Payment
                            </button>
                            <div class="dropdown-menu">'.$options.'</div></div>';
                            
    
                        }else{
                            return "";
                        }
                    }
                    
                    
                }
                
            }else if($sales_transaction->st_status == "Pending" && $sales_transaction->st_type == "Estimate"){
                if($sales_transaction->remark==""){
                    if($usersrestriction[0]->estimate=="1"){
                        return '<span class="table-add mb-3 mr-2"><a class="btn btn-link text-info create_invoice_estimate" id="'.$sales_transaction->st_no.'" href="#" data-toggle="modal" data-target="#invoicemodal"><i aria-hidden="true">Create Invoice</i></a></span>';
                    }
                }
            }else if($sales_transaction->st_status == "Open" && $sales_transaction->st_type == "Charge"){
                if($sales_transaction->remark==""){
                return '<span class="table-add mb-3 mr-2"><a class="btn btn-link text-info create_invoice_delayed_charge" id="'.$sales_transaction->st_no.'" href="#" data-toggle="modal" data-target="#invoicemodal"><i aria-hidden="true">Create Invoice</i></a></span>';
                }
            }else if($sales_transaction->st_status == "Open" && $sales_transaction->st_type == "Credit"){
                if($sales_transaction->remark==""){
                return '<span class="table-add mb-3 mr-2"><a class="btn btn-link text-info create_invoice_delayed_credit" id="'.$sales_transaction->st_no.'" href="#" data-toggle="modal" data-target="#invoicemodal"><i aria-hidden="true">Create Invoice</i></a></span>';
                }
            }else{
                if($sales_transaction->st_type== "Sales Receipt"){
                    if($usersrestriction[0]->sales_receipt=="1"){
                        $formst="";
                        $Formstyle= Formstyle::all();
                        foreach($Formstyle as $f){
                            if($f->cfs_form_name_value=="SALES RECEIPT"){
                                $formst=$f->cfs_id;
                            }
                        }
                        if($formst!=""){
                            $s="";
                            $s.='<form action="previewformstyle" method="GET">';
                            $s.='<input type="hidden" name="receipt" value="'.$sales_transaction->st_no.'">';
                            $s.='<input type="hidden" name="form" value="'.$formst.'">';
                            $s.='<input type="submit" class="btn btn-link text-info" name="print_receipt" value="Print Receipt">';
                            $s.='</form>';
                            return $s;
                            //return '<span class="table-add mb-3 mr-2"><a class="text-info print_receipt" href="/previewformstyle?receipt='.$sales_transaction->st_no.'"&form='.$formst.' ><i aria-hidden="true">Print Receipt</i></a></span>'; 
                        }else{
                            return '<span class="table-add mb-3 mr-2">No Template</span>';
                        }

                    }
                    
                    
                }else{
                    if($sales_transaction->st_type== "Payment"){
                        return '<span class="table-add mb-3 mr-2"><a class="btn btn-link text-info create_invoice_delayed_credit" href="generate_pdf_bir?id='.$sales_transaction->st_customer_id.'" ><i aria-hidden="true">Generate Form</i></a></span>';  
                    }else{
                        return '<span class="table-add mb-3 mr-2">N/A</span>';
                    }
                    
                }
               
            }                
        })
        ->addColumn('cost_center_name', function($sales_transaction){
            if($sales_transaction->st_type== "Sales Receipt"){

                $STInvoice= STInvoice::where([
                    ['st_i_no','=',$sales_transaction->st_payment_for],
                    ['st_p_invoice_type','=',$sales_transaction->st_invoice_type],
                    ['st_p_location','=',$sales_transaction->st_location],
                    ['st_p_reference_no','=',$sales_transaction->st_i_attachment], 
                ])->get();
                $options="";

                foreach($STInvoice as $sti){
                    if($sti->st_i_total>$sti->st_p_amount){
                        $label="";
                        if($sti->st_p_cost_center!=""){
                            $cost_centers= CostCenter::where([
                                ['cc_no','=',$sti->st_p_cost_center]
                            ])->first();
                            $label=$cost_centers->cc_name;
                        }
                        $options.=$label."\n";
                    }else{
                        $label="";
                        if($sti->st_p_cost_center!=""){
                            $cost_centers= CostCenter::where([
                                ['cc_no','=',$sti->st_p_cost_center]
                            ])->first();
                            $label=$cost_centers->cc_name;
                        }
                        $options.=$label."\n";
                    }
                    
                }
                $cost_centers=$options;
                
                return $cost_centers;  
            }else if($sales_transaction->st_type=="Invoice"){
                $STInvoice= STInvoice::where([
                    ['st_i_no','=',$sales_transaction->st_no],
                    ['st_p_invoice_type','=',$sales_transaction->st_invoice_type],
                    ['st_p_location','=',$sales_transaction->st_location],
                    ['st_p_reference_no','=',$sales_transaction->st_i_attachment], 
                ])->get();
                $options="";

                foreach($STInvoice as $sti){
                    if($sti->st_i_total>$sti->st_p_amount){
                        $label="";
                        if($sti->st_p_cost_center!=""){
                            $cost_centers= CostCenter::where([
                                ['cc_no','=',$sti->st_p_cost_center]
                            ])->first();
                            $label=$cost_centers->cc_name;
                        }
                        $options.=$label."\n";
                    }else{
                        $label="";
                        if($sti->st_p_cost_center!=""){
                            $cost_centers= CostCenter::where([
                                ['cc_no','=',$sti->st_p_cost_center]
                            ])->first();
                            $label=$cost_centers->cc_name;
                        }
                        $options.=$label."\n";
                    }
                    
                }
                $cost_centers=$options;
                
                return $cost_centers;
            }
                       
        })
        ->addColumn('description', function($sales_transaction){
            if($sales_transaction->st_type== "Sales Receipt"){
                $STInvoice= STInvoice::where([
                    ['st_i_no','=',$sales_transaction->st_payment_for],
                    ['st_p_invoice_type','=',$sales_transaction->st_invoice_type],
                    ['st_p_location','=',$sales_transaction->st_location],
                    ['st_p_reference_no','=',$sales_transaction->st_i_attachment], 
                ])->get();
                $options="";
    
                foreach($STInvoice as $sti){
                    if($sti->st_i_total>$sti->st_p_amount){
                        $label="";
                        if($sti->st_i_desc!=""){
                            $label=$sti->st_i_desc;
                        }
                        $options.=$label."\n";
                    }else{
                        $label="";
                        if($sti->st_i_desc!=""){
                            $label=$sti->st_i_desc;
                        }
                        $options.=$label."\n";
                    }
                    
                }
                $cost_centers=$options;
                
                return $cost_centers;  
            }else if($sales_transaction->st_type=="Invoice"){
                $STInvoice= STInvoice::where([
                    ['st_i_no','=',$sales_transaction->st_no],
                    ['st_p_invoice_type','=',$sales_transaction->st_invoice_type],
                    ['st_p_location','=',$sales_transaction->st_location],
                    ['st_p_reference_no','=',$sales_transaction->st_i_attachment], 
                ])->get();
                $options="";
    
                foreach($STInvoice as $sti){
                    if($sti->st_i_total>$sti->st_p_amount){
                        $label="";
                        if($sti->st_i_desc!=""){
                            $label=$sti->st_i_desc;
                        }
                        $options.=$label."\n";
                    }else{
                        $label="";
                        if($sti->st_i_desc!=""){
                            $label=$sti->st_i_desc;
                        }
                        $options.=$label."\n";
                    }
                    
                }
                $cost_centers=$options;
                
                return $cost_centers;  
            }
                         
        })
        ->addColumn('customer_name', function($sales_transaction){
            return $sales_transaction->display_name;       
        })
        ->addColumn('customer_balance', function($sales_transaction){
            return 'PHP '.number_format($sales_transaction->st_balance, 2);             
        })
        ->addColumn('or_no', function($sales_transaction){
            if($sales_transaction->st_type=="Invoice" && $sales_transaction->cancellation_reason==NULL){
                
                $payment_for_id=$sales_transaction->st_no;
                $st_location=$sales_transaction->st_location;
                $st_invoice_type=$sales_transaction->st_invoice_type;
                $sales_receipts = DB::connection('mysql')->select("SELECT * FROM sales_transaction  WHERE st_type='Sales Receipt' AND st_payment_for='$payment_for_id' AND st_location='$st_location' AND st_invoice_type='$st_invoice_type'");
                $sr_nos="";
                foreach($sales_receipts as $sal){
                    if($sr_nos!=''){
                        $sr_nos.=", ".$sal->st_no;
                    }else{
                        $sr_nos.=$sal->st_no;
                    }
                    
                }
                return $sr_nos;
            }
            return '';             
        })
        ->addColumn('or_date', function($sales_transaction){
            if($sales_transaction->st_type=="Invoice"  && $sales_transaction->cancellation_reason==NULL){
                $payment_for_id=$sales_transaction->st_no;
                $st_location=$sales_transaction->st_location;
                $st_invoice_type=$sales_transaction->st_invoice_type;
                $sales_receipts = DB::connection('mysql')->select("SELECT * FROM sales_transaction  WHERE st_type='Sales Receipt' AND st_payment_for='$payment_for_id' AND st_location='$st_location' AND st_invoice_type='$st_invoice_type'");
                $sr_nos="";
                foreach($sales_receipts as $sal){
                    if($sr_nos!=''){
                        $sr_nos.=", ".($sal->st_date!=""? date('m-d-Y',strtotime($sal->st_date)) : '');
                    }else{
                        $sr_nos.=($sal->st_date!=""? date('m-d-Y',strtotime($sal->st_date)) : '');
                    }
                    
                }
                return $sr_nos;
            }
            return '';       
        })
        ->addColumn('transaction_total', function($sales_transaction){
            if($sales_transaction->st_type == "Invoice"){
                $STInvoice= STInvoice::all();
                $invoiuce_totral=0;
                foreach($STInvoice as $sstt){
                    if($sales_transaction->st_no==$sstt->st_i_no ){
                        if($sales_transaction->st_location==$sstt->st_p_location && $sales_transaction->st_invoice_type==$sstt->st_p_invoice_type && $sales_transaction->st_i_attachment==$sstt->st_p_reference_no){
                            //return 'PHP '.number_format($sales_transaction->invoice_info->sum('st_i_total'), 2); 
                            $invoiuce_totral+=$sstt->st_i_total;
                        }
                        
                    }
                }
                
                return 'PHP '.number_format($invoiuce_totral, 2); 

            }else if($sales_transaction->st_type == "Estimate"){
                return 'PHP '.number_format($sales_transaction->st_amount_paid, 2);  
            }else if($sales_transaction->st_type == "Sales Receipt"){
                return 'PHP '.number_format($sales_transaction->st_amount_paid, 2);  
            }else if($sales_transaction->st_type == "Refund Receipt"){
                return 'PHP '.number_format($sales_transaction->refund_receipt_info->sum('st_r_total'), 2);  
            }else if($sales_transaction->st_type == "Charge"){
                return 'PHP '.number_format($sales_transaction->delayed_charge_info->sum('st_dc_total'), 2);  
            }else if($sales_transaction->st_type == "Credit"){
                return 'PHP '.number_format($sales_transaction->delayed_credit_info->sum('st_dcredit_total'), 2);  
            }else{
                return 'PHP '.number_format($sales_transaction->st_amount_paid, 2);
            }           
        })
        ->addColumn('checkbox', function($sales_transaction){
            $sales_transaction2222 = SalesTransaction::all();
            $withpayment=0;
            foreach($sales_transaction2222 as $ssss){
                if($sales_transaction->st_no==$ssss->st_payment_for && $sales_transaction->st_type=="Invoice" && $sales_transaction->st_location==$ssss->st_location && $sales_transaction->st_invoice_type==$ssss->st_invoice_type ){
                    $withpayment=1;
                }
            }
            if($withpayment==0){
                if($sales_transaction->remark==""){
                    return "'".$sales_transaction->st_type."','".$sales_transaction->st_no."','".$sales_transaction->st_location."','".$sales_transaction->st_invoice_type."'";
                    
                }else{
                    return $sales_transaction->remark;
                }
            }else{
                return "";
            }
            
            
        })
        ->editColumn('st_due_date', function ($data) {
            if($data->st_due_date == NULL){
                return "N/A";
            }else{
                return date('m-d-Y',strtotime($data->st_due_date));
            }
        })
        ->editColumn('st_type', function ($data) {
            if($data->st_type =="Invoice"){
                return $data->st_location." ".$data->st_invoice_type;
            }else{
                return $data->st_type;
            }
        })
        
        ->make(true);
    }

    public function refresh_sales_table_invoice(){
        $sales_transaction = SalesTransaction::where('st_type', 'Invoice');

        return \DataTables::of($sales_transaction)
        ->addColumn('checkbox', function($sales_transaction){
            return '<span> try </span>';
        })
        ->addColumn('action', function($sales_transaction){
            if($sales_transaction->st_status == "Open" || $sales_transaction->st_status == "Partially paid"){
                return '<span class="table-add mb-3 mr-2"><a class="btn btn-link text-info receive_payment" id="'.$sales_transaction->st_no.'" href="#" data-toggle="modal" data-target="#salesreceiptmodal"><i aria-hidden="true">Receive Payment</i></a></span>';
            }else{
                return '<span class="table-add mb-3 mr-2">Received</span>';
            }                
        })
        ->addColumn('customer_name', function($sales_transaction){
            return $sales_transaction->customer_info->display_name;             
        })
        ->addColumn('customer_balance', function($sales_transaction){
            return 'PHP '.number_format($sales_transaction->st_balance, 2);             
        })
        ->addColumn('transaction_total', function($sales_transaction){
            return 'PHP '.number_format($sales_transaction->invoice_info->sum('st_i_total'), 2);             
        })
        ->editColumn('st_due_date', function ($data) {
            if($data->st_due_date == NULL){
                return "N/A";
            }else{
                return $data->st_due_date;
            }
        })
        ->make(true);
    }
    public function refresh_sales_table_invoice2(){
        $sales_transaction = SalesTransaction::where('st_type', 'Invoice');

        return \DataTables::of($sales_transaction)
        ->addColumn('checkbox', function($sales_transaction){
            return '<span> try </span>';
        })
        ->addColumn('action', function($sales_transaction){
            if($sales_transaction->st_status == "Open" || $sales_transaction->st_status == "Partially paid"){
                return '<span class="table-add mb-3 mr-2"><a class="text-info receive_payment" id="'.$sales_transaction->st_no.'" href="#" data-toggle="modal" data-target="#receivepaymentmodal"><i aria-hidden="true">Receive Payment</i></a>
                <br>
                <select>
                <option></option>
                <option>Print</option>
                <option>Send</option>
                <option>View/Edit</option>
                <option>Send Reminder</option>
                <option>Print packing slip</option>
                <option>Copy</option>
                <option>Delete</option>
                <option>Void</option>
                </select></span>';
            }else{
                return '<span class="table-add mb-3 mr-2">Received<br>
                <select>
                <option></option>
                <option>Print</option>
                <option>Send</option>
                <option>View/Edit</option>
                <option>Send Reminder</option>
                <option>Print packing slip</option>
                <option>Copy</option>
                <option>Delete</option>
                <option>Void</option>
                </select></span>';
            }                
        })
        ->addColumn('customer_name', function($sales_transaction){
            return $sales_transaction->customer_info->display_name;             
        })
        ->addColumn('customer_balance', function($sales_transaction){
            return 'PHP '.number_format($sales_transaction->st_balance, 2);             
        })
        ->addColumn('transaction_total', function($sales_transaction){
            return 'PHP '.number_format($sales_transaction->invoice_info->sum('st_i_total'), 2);             
        })
        ->editColumn('st_due_date', function ($data) {
            if($data->st_due_date == NULL){
                return "N/A";
            }else{
                return $data->st_due_date;
            }
        })
        ->make(true);
    }
    public function get_all_transactions(Request $request){
        $sales_transaction = SalesTransaction::where([
            ['st_no', $request->id],
            ['st_type', 'Estimate']
            ])->first();
        return $sales_transaction;
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

    public function get_all_delayed_charge(Request $request){
        $st_delayed_charge = StDelayedCharge::where('st_dc_no', $request->id)->get();
        $products = ProductsAndServices::all();

        foreach($st_delayed_charge as $delayed_charge){
            foreach($products as $product){
                if($delayed_charge->st_dc_product == $product->product_id){
                    $delayed_charge['st_dc_product_name'] = $product->product_name;
                }
            }
         }

        return $st_delayed_charge;
    }

    public function get_all_delayed_credit(Request $request){
        $st_delayed_credit = StDelayedCredit::where('st_dcredit_no', $request->id)->get();
        $products = ProductsAndServices::all();

        foreach($st_delayed_credit as $delayed_credit){
            foreach($products as $product){
                if($delayed_credit->st_dcredit_product == $product->product_id){
                    $delayed_credit['st_dcredit_product_name'] = $product->product_name;
                }
            }
         }

        return $st_delayed_credit;
    }
    public function save_product(Request $request){
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
        return redirect()->back();
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
        return redirect()->back();
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
}