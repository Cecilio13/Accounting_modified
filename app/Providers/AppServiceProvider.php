<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;
use App\Bank;
use App\Customers;
use App\StSalesReceipt;
use App\Company;
use App\Budgets;
use App\Report;
use App\ChartofAccount;
use App\SalesTransaction;
use App\ExpenseTransaction;
use App\Sales;
use App\Expenses;
use App\Advance;
use App\JournalEntry;
use App\UserCostCenterAccess;
use App\UserAccess;
use App\BankEdits;
use App\CostCenterEdit;
use App\BudgetsEdit;
use App\COAEdits;
use App\ProductAndServicesEdit;
use App\CustomerEdit;
use App\StCreditNote;
use App\ExpenseTransactionEdit;
use App\EtItemDetailEdit;
use App\ETAccountDetailEdit;
use App\StInvoiceEdit;
use App\SalesTransactionEdit;
use App\StCreditNoteEdit;

use App\PayBill;
use App\ExpenseTransactionNew;
use App\EtItemDetailNew;
use App\ETAccountDetailNew;
use App\Voucher;
use App\VoucherTransaction;
use App\VoucherJournalEntry;
use App\CC_Type;
use App\CostCenter;
use App\Clients;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $cost_center_list= CostCenter::groupBy('cc_type')->get();
        foreach($cost_center_list as $ccl){
            $dd=0;
            $dd=count(CC_Type::where([['cc_type','=',$ccl->cc_type]])->get());
            if($dd<1){
                $data=new CC_Type;
                $data->cc_type=$ccl->cc_type;
                $data->cc_code=$ccl->cc_type_code;
                $data->save();
            }
        }
        $cost_center_list= CostCenter::groupBy('cc_name')->get();
        foreach($cost_center_list as $ccl){
            $dd=0;
            $dd=count(CC_Type::where([['cc_type','=',$ccl->cc_name]])->get());
            if($dd<1){
                $data=new CC_Type;
                $data->cc_type=$ccl->cc_name;
                $data->cc_code=$ccl->cc_name_code;
                $data->save();
            }
        }
        $client=Clients::first();
        view()->composer('*', function($view) use ($client)
        {
            $dbName='accounting_modified_'.$client->clnt_db_name;
            
            DB::disconnect('mysql');//here connection name, I used mysql for example
            Config::set('database.connections.mysql.database', $dbName);//new database name, you want to connect to.
            if (Auth::check()) {
                
                
                $view->with('user_position', Auth::user());
                $view->with('UserAccessList', UserAccess::where('user_id',Auth::user()->id)->get());
                $view->with('UserAccessCostCenterList', UserCostCenterAccess::where('use_id',Auth::user()->id)->get());
                $view->with('CC_Types_list', CC_Type::orderBy('cc_code', 'asc')->get());
                // //View::share('user', \Auth::user());
                $view->with('EXNew', ExpenseTransactionNew::where([
                    ['et_status','=',NULL]
                ])->get());
                $view->with('ETANew', ETAccountDetailNew::all());
                $view->with('Voucher', Voucher::all());
                $view->with('VoucherCheckCount', count(Voucher::where('voucher_type','=','Cheque Voucher')->get()));
                $view->with('VoucherCashCount', count(Voucher::where('voucher_type','=','Cash Voucher')->get()));
                $view->with('VoucherTransaction', VoucherTransaction::all());
                $view->with('VoucherJournalEntry', VoucherJournalEntry::all());
                $view->with('ChequeVoucherCount', count(JournalEntry::where([
                    ['journal_type','=','Cheque Voucher']
                ])->groupBy('je_no')->get())+1);
                $view->with('JournalVoucherCount', count(JournalEntry::where([
                    ['journal_type','=','Journal Voucher']
                ])->groupBy('je_no')->get())+1);
                $view->with('BankEdits', BankEdits::all());
                $view->with('CostCenterEdit', CostCenterEdit::all());
                $view->with('BudgetsEdit', BudgetsEdit::all());
                $view->with('COAEdits', COAEdits::all());
                $view->with('ProductAndServicesEdit', ProductAndServicesEdit::all());
                $view->with('CustomerEdit', CustomerEdit::all());
                $view->with('StCreditNote', StCreditNote::all());
                $view->with('EtItemDetailEdit', EtItemDetailEdit::all());
                $view->with('ETAccountDetailEdit', ETAccountDetailEdit::all());
                $view->with('StInvoiceEdit', StInvoiceEdit::all());
                $view->with('SalesTransactionEdit', SalesTransactionEdit::where([
                    ['edit_status','=','0']
                ])->get());
                $view->with('StCreditNoteEdit', StCreditNoteEdit::all());
                $view->with('ExpenseTransactionEdit', ExpenseTransactionEdit::where([
                    ['edit_status','=','0']
                ])->get());
                $view->with('PayBill', PayBill::all());
                $view->with('JournalEntryLists',JournalEntry::all());
                //$view->with('UserAccessList', UserAccess::all());
                
                $view->with('invoice_count',SalesTransaction::where([
                        ['st_type','=','Invoice'],
                        ['st_location', '=', 'Main'],
                        ['st_invoice_type','=','Sales Invoice']
                    ])->get());
                $view->with('main_Bill_invoice_count',SalesTransaction::where([
                        ['st_type','=','Invoice'],
                        ['st_location', '=', 'Main'],
                        ['st_invoice_type','=','Bill Invoice']
                    ])->get());
                $view->with('branch_Bill_invoice_count',SalesTransaction::where([
                        ['st_type','=','Invoice'],
                        ['st_location', '=', 'Branch'],
                        ['st_invoice_type','=','Bill Invoice']
                    ])->get());
                $view->with('branch_Sales_invoice_count',SalesTransaction::where([
                        ['st_type','=','Invoice'],
                        ['st_location', '=', 'Branch'],
                        ['st_invoice_type','=','Sales Invoice']
                    ])->get());
                $view->with('estimate_count',SalesTransaction::where('st_type','Estimate')->get());
                $view->with('credit_note_count',SalesTransaction::where('st_type','Credit Note')->get());
                $view->with('sales_receipt_count',SalesTransaction::where('st_type','Sales Receipt')->get());

                $view->with('expense_transaction_logs',ExpenseTransaction::all());
                $view->with('bill_transaction_count',ExpenseTransaction::where('et_type','Bill')->get());
                $view->with('bill_transaction_count_new',ExpenseTransactionNew::where('et_type','Bill')->get());
                $view->with('supplier_credit_transaction_count',ExpenseTransaction::where('et_type','Supplier credit')->get());


                $view->with('banks', Bank::all());
                $view->with('budgets', Budgets::all());
                $view->with('ST_SR', StSalesReceipt::all());
                $view->with('saleeeeeeee', SalesTransaction::orderBy('st_date','ASC')->get());
                $view->with('company_setting', Company::first());
                $view->with('sales_setting', Sales::first());
                $view->with('expense_setting', Expenses::first());
                $view->with('advance_setting', Advance::first());
                
                $view->with('saved_reports', Report::all());
                $view->with('c_o_a',ChartofAccount::where('coa_active','1')->orderBy('coa_detail_type','ASC')->get());
                $view->with('c_o_a_sorted',ChartofAccount::where('coa_active','1')->orderBy('id','ASC')->get());
                $view->with('coa_account_type',ChartofAccount::groupBy('coa_account_type')->orderBy('coa_detail_type','ASC')->get());
                
            }else {
                $view->with('user_position', null);
            }
            
        });
        
        
        // $view->with('signedIn', \Auth::check());
        
        
        
    }
    private function change_database(){
        
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
