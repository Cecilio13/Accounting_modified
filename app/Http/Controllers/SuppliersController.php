<?php

namespace App\Http\Controllers;
use App\Clients;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\ExpenseTransaction;
use App\EtItemDetail;
use App\EtAccountDetail;
use App\Customers;
use App\Supplier;
use App\JournalEntry;
use App\ProductsAndServices;
use App\AuditLog;

use Redirect;
use App\ChartofAccount;
use App\SalesTransaction;
use App\Numbering;
use App\CostCenter;
use App\DepositRecord;
use App\PayBill;
use App\CustomerEdit;
use App\ExpenseTransactionEdit;
use App\EtItemDetailEdit;
use App\ETAccountDetailEdit;
use App\ExpenseTransactionNew;
use App\EtItemDetailNew;
use App\ETAccountDetailNew;
use App\Voucher;
use App\VoucherTransaction;
use App\VoucherJournalEntry;
class SuppliersController extends Controller
{
    public function __construct()
    {
        // $client=Clients::first();
        // $dbName='accounting_modified_'.$client->clnt_db_name;
            
        // DB::disconnect('mysql');//here connection name, I used mysql for example
        // Config::set('database.connections.mysql.database', $dbName);//new database name, you want to connect to.

    }
    public function approve_pending_bill_request(Request $request){
        
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
            //$expense_transaction->et_credit_account=$et[0]->et_credit_account;
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
            $customer = Customers::find($et[0]->et_customer);
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Added Bill No. ".$request->id;
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name=$customer_name;
            $AuditLog->log_transaction_date=$et[0]->et_date;
            $AuditLog->log_amount=$totalamount;
            $AuditLog->save();
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
    public function delete_pending_bill_request(Request $request){
        $exnew=ExpenseTransactionNew::where([
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
    public function getExpenses(Request $request){
        $customers = Customers::all();
        $products_and_services = ProductsAndServices::all();
        $Supplier= Supplier::where('supplier_active', '1')->get();
        $JournalEntry = JournalEntry::where([['remark','!=','NULLED']])->orWhereNull('remark')->orderBy('je_no','DESC')->get();
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
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
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();
        $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('app.expensesview', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','VoucherCount','totalexp','expense_transactions','jounalcount','customers','Supplier', 'products_and_services','JournalEntry'));
    }
    public function edit($id)
    {
        $customers = Customers::all();
        $supplier= Supplier::find($id);
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
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();
        $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('pages.edit_supplier',compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','VoucherCount','customers','supplier','JournalEntry','jounalcount','products_and_services'));
    }
    public function get_supplier(Request $request){
        $supplier_id=$request->supplier_id;
        $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->where([
                ['et_customer', '=', $supplier_id],
            ])
            ->get();
            $customers = Customers::all();
        $picked = Customers::find($supplier_id);
        //$picked= Supplier::find($supplier_id);
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
            $et_acc = DB::table('et_account_details')->get();
            $et_it = DB::table('et_item_details')->get();
        $totalexp=0;
        foreach($expense_transactions as $et){
            if($et->remark==""){$totalexp=$totalexp+$et->et_ad_total;}
        }
        $sales_transaction = DB::table('sales_transaction')
            ->where([
                ['st_customer_id', '=', $supplier_id],
            ])
            ->get();
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();
        
        $st_invoice = DB::table('st_invoice')->get();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        return view('app.supplierinfo', compact('sales_transaction','numbering','st_invoice','cost_center_list','ETran','SS','COA','totalexp','et_acc','et_it','VoucherCount','expense_transactions','customers', 'products_and_services','JournalEntry','jounalcount','picked'));
    }
    public function update_supplier_note(Request $request){
        $id=$request->id;
        $note=$request->note;
        $customer=Customers::find($id);
        $customer->notes = $note;
        if($customer->save()){
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Updated Supplier Note";
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name="";
            $AuditLog->log_transaction_date="";
            $AuditLog->log_amount="";
            $AuditLog->save();
            return 1;
        }else{
            return 0;
        }
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
    public function update_supplier(Request $request){
        $customer =CustomerEdit::find($request->supplier_id);
        if(empty($customer)){
            $customer = new CustomerEdit;
        }
        $customer->customer_id=$request->supplier_id;
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
        $customer->payment_method = $request->billingrate;
        $customer->terms = $request->terms;
        $customer->opening_balance = $request->opening_balance;
        $customer->as_of_date = $request->as_of_date;
        $customer->account_no = $request->account_no;
        $customer->business_id_no = $request->business_id_no;
        $customer->notes = $request->notes;
        $customer->attachment = $request->fileattachment;
        $customer->tin_no=$request->tin_no;
        $customer->tax_type=$request->tax_type;
        $customer->vat_value=$request->vat_value;
        $customer->supplier_active="1";
        $customer->account_type="Supplier";
        $customer->business_style=$request->business_style;
        $customer->edit_status="0";
        $customer->save();

        // $AuditLog= new AuditLog;
        // $AuditLogcount=AuditLog::count()+1;
        // $userid = Auth::user()->id;
        // $username = Auth::user()->name;
        // $eventlog="Updated Supplier";
        // $AuditLog->log_id=$AuditLogcount;
        // $AuditLog->log_user_id=$username;
        // $AuditLog->log_event=$eventlog;
        // $AuditLog->log_name="";
        // $AuditLog->log_transaction_date="";
        // $AuditLog->log_amount="";
        // $AuditLog->save();

        return Redirect::to('get_supplier/?supplier_id='.$request->supplier_id);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'fname'=>'required',
            'lname'=>'required',
            'company'=>'required'
        ]);
        $customer =Supplier::find($id);
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
        $customer->billing_rate = $request->billingrate;
        $customer->terms = $request->terms;
        $customer->opening_balance = $request->balance;
        $customer->as_of_date = $request->asof;
        $customer->account_no = $request->accountno;
        $customer->business_id_no = $request->businessno;
        $customer->notes = $request->notes;
        $customer->attachment = $request->fileattachment;
        $customer->supplier_active="1";
        $customer->save();
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Updated Supplier";
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name="";
            $AuditLog->log_transaction_date="";
            $AuditLog->log_amount="";
            $AuditLog->save();
        return redirect('/expenses')->with('success','Successfully Updated Supplier Information');
    }
    public function destroy2(Request $request)
    {
        
        $Supplier=Supplier::where('supplier_id',$request->input('iiiddd'))->first();
        $Supplier->supplier_active=$request->input('active');
        $Supplier->save();
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Deleted Supplier";
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name="";
            $AuditLog->log_transaction_date="";
            $AuditLog->log_amount="";
            $AuditLog->save();
        return redirect('/expenses')->with('success','Supplier Deleted');
    }
    public function store(Request $request)
    {
        
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
		echo "Supplier Saved";
        $AuditLog= new AuditLog;
        $AuditLogcount=AuditLog::count()+1;
        $userid = Auth::user()->id;
        $username = Auth::user()->name;
        $eventlog="Added Supplier";
        $AuditLog->log_id=$AuditLogcount;
        $AuditLog->log_user_id=$username;
        $AuditLog->log_event=$eventlog;
        $AuditLog->log_name="";
        $AuditLog->log_transaction_date="";
        $AuditLog->log_amount="";
        $AuditLog->save();
		
        //return redirect('/expenses')->with('success','Successfully Added A New Supplier');
    }
    public function add_expense(Request $request)
    {
        $numbering = Numbering::first();
        $expense_number = SalesTransaction::where('et_type','Supplier credit')->count() + $numbering->suppliers_credit_start_no;
        
        
        $expense_transaction = new ExpenseTransaction;
        $expense_transaction->et_no = $expense_number;
        $expense_transaction->et_customer = $request->expense_customer;
        $expense_transaction->et_account = $request->expense_account;
        $expense_transaction->et_date = $request->expense_date;
        $expense_transaction->et_payment_method = $request->expense_payment_method;
        $expense_transaction->et_reference_no = $request->expense_reference_no;
        $expense_transaction->et_memo = $request->expense_memo;
        $expense_transaction->et_attachment = $request->expense_attachment;
        $expense_transaction->et_type = 'Expense';
        $expense_transaction->save();

        $customer = new Customers;
        $customer = Customers::find($request->expense_customer);

        for($x=0;$x<$request->item_count_expenses;$x++){
            $et_item = new EtItemDetail;
            $et_item->et_id_no = $expense_number;
            $et_item->et_id_product = $request->input('select_product_name_expense'.$x);
            $et_item->et_id_desc = $request->input('select_product_description_expense'.$x);
            $et_item->et_id_qty = $request->input('product_qty_expense'.$x);
            $et_item->et_id_rate = $request->input('select_product_rate_expense'.$x);
            $et_item->et_id_total = $request->input('select_product_rate_expense'.$x) * $request->input('product_qty_expense'.$x);;
            $et_item->save();

            // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * $request->input('select_product_rate'.$x);
            // $customer->save();
            
        }
        $totalamount=0;
        for($x=0;$x<$request->account_count_expenses_add;$x++){
            $et_account = new EtAccountDetail;
            $et_account->et_ad_no = $expense_number;
            $et_account->et_ad_product = $request->input('select_account_expense'.$x);
            $et_account->et_ad_desc = $request->input('select_description_expense'.$x);
            $et_account->et_ad_total = $request->input('select_expense_amount'.$x);
            $totalamount+=$request->input('select_expense_amount'.$x);
            $et_account->save();

            $JDate=$request->expense_date;
            $JNo=$expense_number;
            $JMemo=$request->expense_memo;
            $account=$request->input('select_account_expense'.$x);
            $debit= $request->input('select_expense_amount'.$x);
            $credit= "";
            $description=$request->input('select_description_expense'.$x);
            $name="";

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
            $journal_entries->je_transaction_type="Expense";
            $journal_entries->je_cost_center=$request->CostCenterExpense;
            $journal_entries->save();

            $JDate=$request->expense_date;
            $JNo=$expense_number;
            $JMemo=$request->expense_memo;
            $account="1";
            $debit= "";
            $credit= $request->input('select_expense_amount'.$x);
            $description=$request->input('select_description_expense'.$x);
            $name="";
                

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
            $journal_entries->je_transaction_type="Expense";
            $journal_entries->je_cost_center=$request->CostCenterExpense;
            $journal_entries->save();
            // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * $request->input('select_product_rate'.$x);
            // $customer->save();
        }
            $customer = Customers::find($request->expense_customer);
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Added Expense No. ".$expense_number;
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
            $AuditLog->log_transaction_date=$request->expense_date;
            $AuditLog->log_amount=$totalamount;
            $AuditLog->save();
        return $request->account_count_expenses_add;
    }

    public function add_cheque(Request $request)
    {
        $numbering = Numbering::first();
        $expense_number = SalesTransaction::where('et_type','Supplier credit')->count() + $numbering->suppliers_credit_start_no;

        $expense_transaction = new ExpenseTransaction;
        $expense_transaction->et_no = $expense_number;
        $expense_transaction->et_customer = $request->cheque_customer;
        $expense_transaction->et_account = $request->cheque_account;
        $expense_transaction->et_billing_address = $request->cheque_billing_address;
        $expense_transaction->et_date = $request->cheque_date;
        $expense_transaction->et_reference_no = $request->cheque_no;
        $expense_transaction->et_memo = $request->cheque_memo;
        $expense_transaction->et_attachment = $request->cheque_attachment;
        $expense_transaction->et_type = 'Cheque';
        $expense_transaction->save();

        $customer = new Customers;
        $customer = Customers::find($request->customer);

        for($x=0;$x<$request->item_count_cheques;$x++){
            $et_item = new EtItemDetail;
            $et_item->et_id_no = $expense_number;
            $et_item->et_id_product = $request->input('select_product_name_cheque'.$x);
            $et_item->et_id_desc = $request->input('select_product_description_cheque'.$x);
            $et_item->et_id_qty = $request->input('product_qty_cheque'.$x);
            $et_item->et_id_rate = $request->input('select_product_rate_cheque'.$x);
            $et_item->et_id_total = $request->input('select_product_rate_cheque'.$x) * $request->input('product_qty_cheque'.$x);;
            $et_item->save();

            
            // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * $request->input('select_product_rate'.$x);
            // $customer->save();
        }
        $totalamount=0;
        for($x=0;$x<$request->account_count_cheques;$x++){
            $et_account = new EtAccountDetail;
            $et_account->et_ad_no = $expense_number;
            $et_account->et_ad_product = $request->input('select_account_cheque'.$x);
            $et_account->et_ad_desc = $request->input('select_description_cheque'.$x);
            $et_account->et_ad_total = $request->input('select_cheque_amount'.$x);
            $totalamount+=$request->input('select_cheque_amount'.$x);
            $et_account->save();

            $JDate=$request->cheque_date;
            $JNo=$expense_number;
            $JMemo=$request->cheque_memo;
            $account=$request->input('select_account_cheque'.$x);
            $debit= $request->input('select_cheque_amount'.$x);
            $credit= "";
            $description=$request->input('select_description_cheque'.$x);
            $name="";

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
            $journal_entries->je_transaction_type="Cheque";
            $journal_entries->je_cost_center=$request->CostCenterCheque;
            $journal_entries->save();

            $JDate=$request->cheque_date;
            $JNo=$expense_number;
            $JMemo=$request->cheque_memo;
            $account="1";
            $debit= "";
            $credit=$request->input('select_cheque_amount'.$x);
            $description=$request->input('select_description_cheque'.$x);
            $name="";
                

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
            $journal_entries->je_transaction_type="Cheque";
            $journal_entries->je_cost_center=$request->CostCenterCheque;
            $journal_entries->save();
            // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * $request->input('select_product_rate'.$x);
            // $customer->save();
        }
            $customer = Customers::find($request->cheque_customer);
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Added Cheque No. ".$expense_number;
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
            $AuditLog->log_transaction_date=$request->cheque_date;
            $AuditLog->log_amount=$totalamount;
            $AuditLog->save();

    }

    public function add_bill(Request $request)
    {
        $sss=explode(" - ",$request->bill_customer);
        $numbering = Numbering::first();
        
        $expense_number = ExpenseTransactionNew::where('et_type','Bill')->count()+ExpenseTransaction::where('et_type','Bill')->count() + $numbering->bill_start_no;
        $expense_transaction = new ExpenseTransactionNew;
        $expense_transaction->et_no = $expense_number;
        $expense_transaction->et_customer = $sss[0];
        $expense_transaction->et_terms = $request->bill_terms;
        $expense_transaction->et_billing_address = $request->bill_billing_address;
        $expense_transaction->et_bill_no =$expense_number;
        $expense_transaction->et_date = $request->bill_date;
        $expense_transaction->et_due_date = $request->bill_due_date;
        $expense_transaction->et_memo = $request->bill_memo;
        $expense_transaction->et_attachment = $request->bill_attachment;

        $expense_transaction->et_shipping_address = $request->RF_bill;
        $expense_transaction->et_shipping_to = $request->PO_bill;
        $expense_transaction->et_shipping_via = $request->CI_bill;
        $wwe=explode(" - ",$request->CostCenterBill);
        $expense_transaction->et_debit_account=$wwe[0];
        $expense_transaction->et_credit_account=$request->bill_account_credit_account;

        $expense_transaction->et_type = 'Bill';
        $expense_transaction->save();

        

        $customer = new Customers;
        $customer = Customers::find($sss[0]);
       
        
        for($x=0;$x<$request->item_count_bills;$x++){
            $et_item = new EtItemDetailNew;
            $et_item->et_id_no = $expense_number;
            $et_item->et_ad_type = "Bill";
            $et_item->et_id_product = $request->input('select_product_name_bill'.$x);
            $et_item->et_id_desc = $request->input('select_product_description_bill'.$x);
            $et_item->et_id_qty = $request->input('product_qty_bill'.$x);
            $et_item->et_id_rate = $request->input('select_product_rate_bill'.$x);
            $et_item->et_id_total = $request->input('select_product_rate_bill'.$x) * $request->input('product_qty_bill'.$x);;
            $et_item->save();

            // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * $request->input('select_product_rate'.$x);
            // $customer->save();
        }
        $totalamount=0;
        for($x=0;$x<$request->account_count_bills;$x++){
            $et_account = new EtAccountDetailNew;
            $et_account->et_ad_no = $expense_number;
            $et_account->et_ad_product = $request->input('select_account_bill'.$x);
            $et_account->et_ad_desc = $request->input('select_description_bill'.$x);
            $et_account->et_ad_total = $request->input('select_bill_amount'.$x);
            $et_account->et_ad_rate = $x+1;
            $et_account->et_ad_qty = $expense_number;
            $et_account->et_ad_type = "Bill";
            $totalamount+=$request->input('select_bill_amount'.$x);
            $et_account->save();

        }
            $expense_transaction =ExpenseTransactionNew::find($expense_number);
            $expense_transaction->bill_balance=$totalamount;
            $expense_transaction->save();
    }

    public function add_purchase_order(Request $request)
    {
        $numbering = Numbering::first();
        $expense_number = ExpenseTransaction::where('et_type','Supplier credit')->count() + $numbering->suppliers_credit_start_no;

        $expense_transaction = new ExpenseTransaction;
        $expense_transaction->et_no = $expense_number;
        $expense_transaction->et_customer = $request->po_customer;
        $expense_transaction->et_email = $request->po_email;
        $expense_transaction->et_billing_address = $request->po_mail_address;
        $expense_transaction->et_date = $request->po_date;
        $expense_transaction->et_message = $request->po_message;
        $expense_transaction->et_memo = $request->po_memo;
        // $expense_transaction->et_shipping_address = $request->po_ship_address;
        // $expense_transaction->et_shipping_to = $request->po_ship_to;
        // $expense_transaction->et_shipping_via = $request->po_ship_via;
        $expense_transaction->et_attachment = $request->po_attachment;
        $expense_transaction->et_type = 'Purchase order';
        $expense_transaction->save();

        $customer = new Customers;
        $customer = Customers::find($request->po_customer);

        for($x=0;$x<$request->item_count_pos;$x++){
            $et_item = new EtItemDetail;
            $et_item->et_id_no = $expense_number;
            $et_item->et_id_product = $request->input('select_product_name_po'.$x);
            $et_item->et_id_desc = $request->input('select_product_description_po'.$x);
            $et_item->et_id_qty = $request->input('product_qty_po'.$x);
            $et_item->et_id_rate = $request->input('select_product_rate_po'.$x);
            $et_item->et_id_total = $request->input('select_product_rate_po'.$x) * $request->input('product_qty_po'.$x);;
            $et_item->save();

            // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * $request->input('select_product_rate'.$x);
            // $customer->save();
        }
        $totalamount=0;
        for($x=0;$x<$request->account_count_pos;$x++){
            $et_account = new EtAccountDetail;
            $et_account->et_ad_no = $expense_number;
            $et_account->et_ad_product = $request->input('select_account_po'.$x);
            $et_account->et_ad_desc = $request->input('select_description_po'.$x);
            $et_account->et_ad_total = $request->input('select_po_amount'.$x);
            $totalamount+=$request->input('select_po_amount'.$x);
            $et_account->save();

            // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * $request->input('select_product_rate'.$x);
            // $customer->save();
        }
        $customer = Customers::find($request->po_customer);
        $AuditLog= new AuditLog;
        $AuditLogcount=AuditLog::count()+1;
        $userid = Auth::user()->id;
        $username = Auth::user()->name;
        $eventlog="Added Purchase Order No. ".$expense_number;
        $AuditLog->log_id=$AuditLogcount;
        $AuditLog->log_user_id=$username;
        $AuditLog->log_event=$eventlog;
        $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
        $AuditLog->log_transaction_date=$request->po_date;
        $AuditLog->log_amount=$totalamount;
        $AuditLog->save();
    }

    public function add_supplier_credit(Request $request)
    {
        $sss=explode(" - ",$request->sc_customer);
        $numbering = Numbering::first();
        $expense_number = ExpenseTransaction::where('et_type','Supplier credit')->count() + $numbering->suppliers_credit_start_no;

        $expense_transaction = new ExpenseTransaction;
        $expense_transaction->et_no = $expense_number;
        $expense_transaction->et_customer = $sss[0];
        $expense_transaction->et_billing_address = $request->sc_mail_address;
        $expense_transaction->et_date = $request->sc_date;
        $expense_transaction->et_reference_no = $request->sc_reference_no;
        $expense_transaction->et_memo = $request->sc_memo;
        $expense_transaction->et_attachment = $request->sc_attachment;
        $expense_transaction->et_type = 'Supplier credit';
        $expense_transaction->save();

        $customer = new Customers;
        $customer = Customers::find($sss[0]);

        for($x=0;$x<$request->item_count_scs;$x++){
            $et_item = new EtItemDetail;
            $et_item->et_id_no = $expense_number;
            $et_item->et_ad_type = "Supplier credit";
            $et_item->et_id_product = $request->input('select_product_name_sc'.$x);
            $et_item->et_id_desc = $request->input('select_product_description_sc'.$x);
            $et_item->et_id_qty = $request->input('product_qty_sc'.$x);
            $et_item->et_id_rate = $request->input('select_product_rate_sc'.$x);
            $et_item->et_id_total = -$request->input('select_product_rate_sc'.$x) * $request->input('product_qty_sc'.$x);
            $et_item->save();

            // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * $request->input('select_product_rate'.$x);
            // $customer->save();
        }
        $totalamount=0;
        for($x=0;$x<$request->account_count_scs;$x++){
            $et_account = new EtAccountDetail;
            $et_account->et_ad_no = $expense_number;
            $et_account->et_ad_type = "Supplier credit";
            $et_account->et_ad_product = $request->input('select_account_sc'.$x);
            $et_account->et_ad_desc = $request->input('select_description_sc'.$x);
            $et_account->et_ad_total = -$request->input('select_sc_amount'.$x);
            $totalamount-=$request->input('select_sc_amount'.$x);
            $et_account->save();


            $JDate=$request->sc_date;
            $JNo=$expense_number;
            $JMemo=$request->sc_memo;
            $account=$request->supplier_credit_account_debit_account;
            $debit= -$request->input('select_sc_amount'.$x);
            $credit= "";
            $description=$request->input('select_description_sc'.$x);
            $name="";

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
            $journal_entries->je_transaction_type="Supplier Credit";
            $wwe=explode(" - ",$request->CostCenterSupplierCredit);
            $journal_entries->je_cost_center=$wwe[0];
            $journal_entries->save();

            $JDate=$request->sc_date;
            $JNo=$expense_number;
            $JMemo=$request->sc_memo;
            $account=$request->input('select_account_sc'.$x);
            $debit= "";
            $credit=-$request->input('select_sc_amount'.$x);
            $description=$request->input('select_description_sc'.$x);
            $name="";
                

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
            $journal_entries->je_transaction_type="Supplier Credit";
            $wwe=explode(" - ",$request->CostCenterSupplierCredit);
            $journal_entries->je_cost_center=$wwe[0];
            $journal_entries->save();
            // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * $request->input('select_product_rate'.$x);
            // $customer->save();
        }
        $customer = Customers::find($sss[0]);
        $AuditLog= new AuditLog;
        $AuditLogcount=AuditLog::count()+1;
        $userid = Auth::user()->id;
        $username = Auth::user()->name;
        $eventlog="Added Supplier Credit No. ".$expense_number;
        $AuditLog->log_id=$AuditLogcount;
        $AuditLog->log_user_id=$username;
        $AuditLog->log_event=$eventlog;
        $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
        $AuditLog->log_transaction_date=$request->sc_date;
        $AuditLog->log_amount=$totalamount;
        $AuditLog->save();
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
            DB::table('journal_entries')->where([
                ['other_no','=', $request->id],
                ['je_transaction_type','=', $request->type]
            ])->update([
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
                $et_account->et_ad_rate = $ets->et_ad_rate;
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
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Updated ".$expense_transactionedit->et_type." No. ".$request->id;
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
            $AuditLog->log_transaction_date=$expense_transactionedit->et_date;
            $AuditLog->log_amount=$totalamount;
            $AuditLog->save();
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
    //update supplier credit
    public function update_expenses_sc(Request $request){
        $expense_transaction =ExpenseTransactionEdit::find($request->update_sc_id);
        if(empty($expense_transaction)){
            $expense_transaction = new ExpenseTransactionEdit;
        }
        $expense_transaction->et_no=$request->update_sc_id;
        $expense_transaction->et_customer = $request->customer;
        $expense_transaction->et_billing_address = $request->address;
        $expense_transaction->et_date = $request->paydate;
        $expense_transaction->et_reference_no = $request->refno;
        $expense_transaction->et_memo = $request->memo;
        $expense_transaction->et_type = 'Supplier credit';
        $expense_transaction->et_credit_account = $request->supplier_credit_account_debit_account_edit;
        
        $expense_transaction->save();
        DB::table('et_account_details_edits')->where('et_ad_no', $request->update_sc_id)->delete();
        DB::table('et_item_details_edits')->where('et_id_no', $request->update_sc_id)->delete();
        $totalamount=0;
        for($i=0;$i<count($request->accounts1);$i++){
            $et_account = new EtAccountDetailEdit;
            $et_account->et_ad_no = $request->update_sc_id;
            $et_account->et_ad_product = $request->accounts1[$i];
            $et_account->et_ad_desc = $request->desc1[$i];
            $et_account->et_ad_total = $request->amount1[$i];
            $totalamount-=$request->amount1[$i];
            $et_account->save();
        }
        if($request->produt){
            for($i=0;$i<count($request->produt);$i++){
                $et_item = new EtItemDetailEdit;
                $et_item->et_id_no = $request->update_expense_id;
                $et_item->et_id_product = $request->produt[$i];
                $et_item->et_id_desc = $request->produt_desc[$i];
                $et_item->et_id_qty = $request->produt_qty[$i];
                $et_item->et_id_rate = $request->produt_rate[$i];
                $et_item->et_id_total = $request->produt_qty[$i] * $request->produt_rate[$i];
                $et_item->save();
            }
        }
        // $customer = Customers::find($request->customer);
        // $AuditLog= new AuditLog;
        // $AuditLogcount=AuditLog::count()+1;
        // $userid = Auth::user()->id;
        // $username = Auth::user()->name;
        // $eventlog="Updated Supplier Credit No. ".$request->update_sc_id;
        // $AuditLog->log_id=$AuditLogcount;
        // $AuditLog->log_user_id=$username;
        // $AuditLog->log_event=$eventlog;
        // $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
        // $AuditLog->log_transaction_date=$request->paydate;
        // $AuditLog->log_amount=$totalamount;
        // $AuditLog->save();
    }
    public function update_expenses_cheque(Request $request){
        $expense_transaction =ExpenseTransaction::find($request->update_cheque_id);
        $expense_transaction->et_customer = $request->customer;
        $expense_transaction->et_account = $request->chequeaccedit;
        $expense_transaction->et_billing_address = $request->address;
        $expense_transaction->et_date = $request->paydate;
        $expense_transaction->et_reference_no = $request->chequeno;
        $expense_transaction->et_memo = $request->memo;
        $expense_transaction->et_type = 'Cheque';
        $expense_transaction->save();
        DB::table('et_account_details')->where('et_ad_no', $request->update_cheque_id)->delete();
        DB::table('et_item_details')->where('et_id_no', $request->update_cheque_id)->delete();
        $totalamount=0;
        for($i=0;$i<count($request->accounts1);$i++){
            $et_account = new EtAccountDetail;
            $et_account->et_ad_no = $request->update_cheque_id;
            $et_account->et_ad_product = $request->accounts1[$i];
            $et_account->et_ad_desc = $request->desc1[$i];
            $et_account->et_ad_total = $request->amount1[$i];
            $totalamount+=$request->amount1[$i];
            $et_account->save();
        }
        if($request->produt){
        for($i=0;$i<count($request->produt);$i++){
            $et_item = new EtItemDetail;
            $et_item->et_id_no = $request->update_cheque_id;
            $et_item->et_id_product = $request->produt[$i];
            $et_item->et_id_desc = $request->produt_desc[$i];
            $et_item->et_id_qty = $request->produt_qty[$i];
            
            $et_item->et_id_rate =preg_replace("/[^0-9\.]/", "",$request->produt_rate[$i]) ;
            $et_item->et_id_total = $request->produt_qty[$i] * preg_replace("/[^0-9\.]/", "",$request->produt_rate[$i]);
            $et_item->save();
        }
        }
        $customer = Customers::find($request->customer);
        $AuditLog= new AuditLog;
        $AuditLogcount=AuditLog::count()+1;
        $userid = Auth::user()->id;
        $username = Auth::user()->name;
        $eventlog="Updated Cheque No. ".$request->update_cheque_id;
        $AuditLog->log_id=$AuditLogcount;
        $AuditLog->log_user_id=$username;
        $AuditLog->log_event=$eventlog;
        $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
        $AuditLog->log_transaction_date=$request->paydate;
        $AuditLog->log_amount=$totalamount;
        $AuditLog->save();
    }
    public function update_expenses_expense(Request $request){
        $expense_transaction = ExpenseTransaction::find($request->update_expense_id);
        $expense_transaction->et_customer = $request->customer;
        $expense_transaction->et_account = $request->expenseaccountedit;
        $expense_transaction->et_date = $request->paydate;
        $expense_transaction->et_payment_method = $request->paymethod;
        $expense_transaction->et_reference_no = $request->refno;
        $expense_transaction->et_memo = $request->memo;
        $expense_transaction->et_type = 'Expense';
        $expense_transaction->save();

        DB::table('et_account_details')->where('et_ad_no', $request->update_expense_id)->delete();
        DB::table('et_item_details')->where('et_id_no', $request->update_expense_id)->delete();
        $totalamount=0;
        for($i=0;$i<count($request->accounts1);$i++){
            $et_account = new EtAccountDetail;
            $et_account->et_ad_no = $request->update_expense_id;
            $et_account->et_ad_product = $request->accounts1[$i];
            $et_account->et_ad_desc = $request->desc1[$i];
            $et_account->et_ad_total = $request->amount1[$i];
            $totalamount+=$request->amount1[$i];
            $et_account->save();
        }
        if($request->produt){
        for($i=0;$i<count($request->produt);$i++){
            $et_item = new EtItemDetail;
            $et_item->et_id_no = $request->update_expense_id;
            $et_item->et_id_product = $request->produt[$i];
            $et_item->et_id_desc = $request->produt_desc[$i];
            $et_item->et_id_qty = $request->produt_qty[$i];
            $et_item->et_id_rate = $request->produt_rate[$i];
            $et_item->et_id_total = $request->produt_qty[$i] * $request->produt_rate[$i];
            $et_item->save();
        }
        }
        $customer = Customers::find($request->customer);
        $AuditLog= new AuditLog;
        $AuditLogcount=AuditLog::count()+1;
        $userid = Auth::user()->id;
        $username = Auth::user()->name;
        $eventlog="Updated Expense No. ".$request->update_expense_id;
        $AuditLog->log_id=$AuditLogcount;
        $AuditLog->log_user_id=$username;
        $AuditLog->log_event=$eventlog;
        $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
        $AuditLog->log_transaction_date=$request->paydate;
        $AuditLog->log_amount=$totalamount;
        $AuditLog->save();
    }
    public function update_expenses_bill(Request $request){
        $expense_transaction = ExpenseTransactionEdit::find($request->update_bill_id);
        if(empty($expense_transaction)){
            $expense_transaction = new ExpenseTransactionEdit;
        }
        $expense_transaction->et_no=$request->update_bill_id;
        $expense_transaction->et_customer = $request->customer;
        $expense_transaction->et_terms = $request->term;
        $expense_transaction->et_billing_address = $request->address;
        $expense_transaction->et_bill_no = $request->billno;
        $expense_transaction->et_date = $request->billdate;
        $expense_transaction->et_due_date = $request->duedate;
        $expense_transaction->et_memo = $request->memo;
        $expense_transaction->et_type = 'Bill';

        $expense_transaction->et_shipping_address = $request->RF_bill_edit;
        $expense_transaction->et_shipping_to = $request->PO_bill_edit;
        $expense_transaction->et_shipping_via = $request->CI_bill_edit;
        $expense_transaction->et_credit_account = $request->bill_account_credit_account_edit;
        $expense_transaction->edit_status="0";
        $expense_transaction->save();

        DB::table('et_account_details_edits')->where([
            ['et_ad_no','=', $request->update_bill_id],
            ['et_ad_type','=', 'Bill']
        ])->update([
            'edit_status'=>'OK'
        ]);
        DB::table('et_item_details_edits')->where([
            ['et_id_no','=', $request->update_bill_id]
        ])->update([
            'edit_status'=>'OK'
        ]);
        $totalamount=0;
        for($i=0;$i<count($request->accounts1);$i++){
            $et_account = new EtAccountDetailEdit;
            $et_account->et_ad_no = $request->update_bill_id;
            $et_account->et_ad_qty = $request->update_bill_id;
            $et_account->et_ad_product = $request->accounts1[$i];
            $et_account->et_ad_desc = $request->desc1[$i];
            $et_account->et_ad_rate = $i+1;
            $et_account->et_ad_total = $request->amount1[$i];
            $et_account->et_ad_type = "Bill";
            $totalamount+=$request->amount1[$i];
            $et_account->save();
        }
        if($request->produt){
            for($i=0;$i<count($request->produt);$i++){
                $et_item = new EtItemDetailEdit;
                $et_item->et_id_no = $request->update_expense_id;
                $et_item->et_id_product = $request->produt[$i];
                $et_item->et_id_desc = $request->produt_desc[$i];
                $et_item->et_id_qty = $request->produt_qty[$i];
                $et_item->et_id_rate = $request->produt_rate[$i];
                $et_item->et_id_total = $request->produt_qty[$i] * $request->produt_rate[$i];
                $et_item->save();
            }
        }
        
    }
    public function update_expenses_credit_card_charges(Request $request){
        $expense_transaction =ExpenseTransaction::find($request->id);
        $expense_transaction->et_customer = $request->customer;
        $expense_transaction->et_account = $request->account;
        $expense_transaction->et_date = $request->date;
        $expense_transaction->et_reference_no = $request->ref_no;
        $expense_transaction->et_memo = $request->memo;
        $expense_transaction->et_type = 'Credit card credit';
        $expense_transaction->save();
        DB::table('et_account_details')->where('et_ad_no', $request->id)->delete();
        DB::table('et_item_details')->where('et_id_no', $request->id)->delete();
        $totalamount=0;
        for($i=0;$i<count($request->accounts1);$i++){
            $et_account = new EtAccountDetail;
            $et_account->et_ad_no = $request->id;
            $et_account->et_ad_product = $request->accounts1[$i];
            $et_account->et_ad_desc = $request->desc1[$i];
            $et_account->et_ad_total = $request->amount1[$i];
            $totalamount+=$request->amount1[$i];
            $et_account->save();
        }
        $customer = Customers::find($request->customer);
        $AuditLog= new AuditLog;
        $AuditLogcount=AuditLog::count()+1;
        $userid = Auth::user()->id;
        $username = Auth::user()->name;
        $eventlog="Updated Credit card charge No. ".$request->id;
        $AuditLog->log_id=$AuditLogcount;
        $AuditLog->log_user_id=$username;
        $AuditLog->log_event=$eventlog;
        $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
        $AuditLog->log_transaction_date=$request->date;
        $AuditLog->log_amount=$totalamount;
        $AuditLog->save();


    }
    public function add_card_credit(Request $request)
    {
        $numbering = Numbering::first();
        $expense_number = ExpenseTransaction::where('et_type','Supplier credit')->count() + $numbering->suppliers_credit_start_no;

        $expense_transaction = new ExpenseTransaction;
        $expense_transaction->et_no = $expense_number;
        $expense_transaction->et_customer = $request->cc_customer;
        $expense_transaction->et_account = $request->cc_account;
        $expense_transaction->et_date = $request->cc_date;
        $expense_transaction->et_reference_no = $request->cc_reference_no;
        $expense_transaction->et_memo = $request->cc_memo;
        $expense_transaction->et_attachment = $request->cc_attachment;
        $expense_transaction->et_type = 'Credit card credit';
        $expense_transaction->save();

        $customer = new Customers;
        $customer = Customers::find($request->customer);

        for($x=0;$x<$request->item_count_ccs;$x++){
            $et_item = new EtItemDetail;
            $et_item->et_id_no = $expense_number;
            $et_item->et_id_product = $request->input('select_product_name_cc'.$x);
            $et_item->et_id_desc = $request->input('select_product_description_cc'.$x);
            $et_item->et_id_qty = $request->input('product_qty_cc'.$x);
            $et_item->et_id_rate = $request->input('select_product_rate_cc'.$x);
            $et_item->et_id_total = $request->input('select_product_rate_cc'.$x) * $request->input('product_qty_cc'.$x);;
            $et_item->save();

            // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * $request->input('select_product_rate'.$x);
            // $customer->save();
        }
        $totalamount=0;
        for($x=0;$x<$request->account_count_ccs;$x++){
            $et_account = new EtAccountDetail;
            $et_account->et_ad_no = $expense_number;
            $et_account->et_ad_product = $request->input('select_account_cc'.$x);
            $et_account->et_ad_desc = $request->input('select_description_cc'.$x);
            $et_account->et_ad_total = $request->input('select_cc_amount'.$x);
            $totalamount+=$request->input('select_cc_amount'.$x);
            $et_account->save();

            // $customer->opening_balance = $customer->opening_balance + $request->input('product_qty'.$x) * $request->input('select_product_rate'.$x);
            // $customer->save();
        }
        $customer = Customers::find($request->cc_customer);
        $AuditLog= new AuditLog;
        $AuditLogcount=AuditLog::count()+1;
        $userid = Auth::user()->id;
        $username = Auth::user()->name;
        $eventlog="Added Credit Card No. ".$expense_number;
        $AuditLog->log_id=$AuditLogcount;
        $AuditLog->log_user_id=$username;
        $AuditLog->log_event=$eventlog;
        $AuditLog->log_name=$customer->f_name." ".$customer->l_name;
        $AuditLog->log_transaction_date=$request->cc_date;
        $AuditLog->log_amount=$totalamount;
        $AuditLog->save();

    }
    public function add_deposit_record(Request $request){
            $deposit_group_no=DepositRecord::count()+1;
            $count=0;
        foreach($request->checked as $items){
            $DepositRecord = New DepositRecord;
            $deposit_record_count=DepositRecord::count()+1;
            $DepositRecord->deposit_record_no=$deposit_record_count;
            $DepositRecord->deposit_to=$request->deposit_deposit_to[$count];
            $DepositRecord->deposit_record_date=$request->deposit_record_date;
            $DepositRecord->deposit_record_memo=$request->deposit_record_memo;
            $DepositRecord->deposit_record_transaction_no=$items;
            $DepositRecord->deposit_record_group_no=$deposit_group_no;
            //$DepositRecord->bank_account=$request->deposit_record_bank;
            
            $DepositRecord->save();

            $stew = SalesTransaction::find($items);
            $stew->st_action="Deposited";
            $stew->save();
            $count++;
        }
    }
    public function update_pay_bill_note(Request $request){
        $id=$request->id;
        $note=$request->note;
        $paybill_group=PayBill::find($id);
        $paybill_group->payment_remark = $note;
        if($paybill_group->save()){
            return 1;
        }else{
            return 0;
        }
    }
    public function add_pay_bill(Request $request){
        $paybill_group=PayBill::count()+1;
        $count=0;
        foreach($request->checked as $items){
            $PayBill = New PayBill;
            $pay_bill_count=PayBill::count()+1;
            $PayBill->pay_bill_no=$pay_bill_count;
            $PayBill->payment_account=$request->paybill_paymentaccount;
            $PayBill->payment_date=$request->paybill_paymentdate[$count];
            $PayBill->payment_bank_account=$request->paybill_bank_account[$count];
            $PayBill->pay_bill_group_no=$paybill_group;
            $PayBill->bill_no=$items;
            $PayBill->bill_payment_amount=$request->paymentamount[$count];
            $PayBill->save();
            $totalbalanceafter=$request->paybilltotalbalance[$count]-$request->paymentamount[$count];
            if($totalbalanceafter<1){
                $stew = ExpenseTransaction::find($items);
                $stew->et_bil_status="Paid";
                $stew->save();
            }else{
                $stew = ExpenseTransaction::find($items);
                $stew->bill_balance=$totalbalanceafter;
                $stew->save();
            }
            //$stew = ExpenseTransaction::find($items);
            $stew= JournalEntry::where([
                ['other_no','=',$items],
                ['je_transaction_type', '=', 'Bill'],
                ['je_credit', '!=', ''],
                ['remark','!=','NULLED']
            ])->first();

            $JDate=$request->paybill_paymentdate[$count];
            $JNo=$pay_bill_count;
            $JMemo="";
            $account=$stew->je_account;
            $debit= $request->paymentamount[$count];
            $credit= "";
            $description="";    
            $name="";

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
            $journal_entries->je_transaction_type="Bill Payment";
            
            $journal_entries->je_cost_center=$stew->je_cost_center;
            $journal_entries->save();

            $JDate=$request->paybill_paymentdate[$count];
            $JNo=$pay_bill_count;
            $JMemo="";
            $account=$request->paybill_paymentaccount;
            $debit= "";
            $credit=$request->paymentamount[$count];
            $description="";
            $name="";
                

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
            $journal_entries->je_transaction_type="Bill Payment";
            $journal_entries->je_cost_center=$stew->je_cost_center;
            $journal_entries->save();
            


            $expense_transactions = DB::table('expense_transactions')->where([
                ['et_type', '=', 'Bill'],
                ['et_no', '=', $items],
            ])->get();
            $et_acc = DB::table('et_account_details')->where([
                ['et_ad_type', '=', 'Bill'],
                ['et_ad_no', '=', $items],
            ])->get();
            $cusset="";
            foreach($expense_transactions as $etx){
                $cusset=$etx->et_customer; 
            }
            if($request->usevoucher_question[$count]!=""){
                $VoucherCount=Voucher::count() + 1;
                $VoucherID=$VoucherCount;
                if($VoucherCount<10){
                    $VoucherCount="000".$VoucherCount;
                }
                else if($VoucherCount<100 && $VoucherCount>9 ){
                    $VoucherCount="00".$VoucherCount;
                }
                else if($VoucherCount<1000 && $VoucherCount>99 ){
                    $VoucherCount="0".$VoucherCount;
                }
                $VoucherCount2=1;
                
                $Voucher = new  Voucher;
                $Voucher->voucher_id=$VoucherID;
                if($request->usevoucher_question[$count]=="Cash"){
                    $Voucher->voucher_type="Cash Voucher";
                    $VoucherCount=Voucher::all();
                    foreach($VoucherCount as $vc){
                        if("Cash Voucher"==$vc->voucher_type){
                            $VoucherCount2++;
                        }
                    }
                }
                if($request->usevoucher_question[$count]=="Cheque"){
                    $Voucher->voucher_type="Cheque Voucher";
                    $VoucherCount=Voucher::all();
                    foreach($VoucherCount as $vc){
                        if("Cheque Voucher"==$vc->voucher_type){
                            $VoucherCount2++;
                        }
                    }
                }
                
                $Voucher->pay_to_order_of=$cusset;
                $Voucher->voucher_no=$VoucherCount2;
                $Voucher->voucher_date=$request->paybill_paymentdate[$count];
                $Voucher->received_from=$cusset;
                $Voucher->received_from_bank="";
                $Voucher->the_amount_of=$request->paymentamount[$count];
                $Voucher->bank="";
                $Voucher->check_no="";
                $Voucher->received_payment_by="";
                $Voucher->prepared_by=$request->prepared_by;
                $Voucher->certified_correct_by="";
                $Voucher->approved_by="";
                $Voucher->previous_voucher="";
                $Voucher->voucher_link_id=$pay_bill_count;
                if($Voucher->save()){
                    //journal entry
                    
                        $VoucherJournalEntryCount=VoucherJournalEntry::count() + 1;
                        $VoucherJournalEntry = new  VoucherJournalEntry;        
                        $VoucherJournalEntry->journal_no = $VoucherJournalEntryCount;        
                        $VoucherJournalEntry->voucher_ref_no = $VoucherCount2;        
                        $VoucherJournalEntry->account_title =$request->paybill_paymentaccount;        
                        $VoucherJournalEntry->debit = $request->paymentamount[$count];        
                        $VoucherJournalEntry->credit = "";        
                        $VoucherJournalEntry->save();
                        
                        $VoucherJournalEntryCount=VoucherJournalEntry::count() + 1;
                        $VoucherJournalEntry = new  VoucherJournalEntry;        
                        $VoucherJournalEntry->journal_no = $VoucherJournalEntryCount;        
                        $VoucherJournalEntry->voucher_ref_no = $VoucherCount2;        
                        $VoucherJournalEntry->account_title =$stew->je_account;        
                        $VoucherJournalEntry->debit = "";        
                        $VoucherJournalEntry->credit = $request->paymentamount[$count];        
                        $VoucherJournalEntry->save();
                    
                    //transactions
                    
                        $VoucherTransactionCount=VoucherTransaction::count() + 1;
                        $VoucherTransaction = new  VoucherTransaction;  
                        $VoucherTransaction->tran_no =$VoucherTransactionCount;
                        $VoucherTransaction->voucher_ref_no = $VoucherCount2;
                        $VoucherTransaction->tran_qty ="1";
                        $VoucherTransaction->tran_unit =$request->paymentamount[$count];
                        $VoucherTransaction->tran_explanation ="";
                        $VoucherTransaction->tran_amount =$request->paymentamount[$count];
                        $VoucherTransaction->save();
                    
                   
                }
            }
            
        }
        
    }
}
