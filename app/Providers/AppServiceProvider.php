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
        // view()->share('signedIn', \Auth::check());
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
        view()->share('CC_Types_list', CC_Type::orderBy('cc_code', 'asc')->get());
        // //View::share('user', \Auth::user());
        view()->share('EXNew', ExpenseTransactionNew::where([
            ['et_status','=',NULL]
        ])->get());
        view()->share('ETANew', ETAccountDetailNew::all());
        view()->share('Voucher', Voucher::all());
        view()->share('VoucherCheckCount', count(Voucher::where('voucher_type','=','Cheque Voucher')->get()));
        view()->share('VoucherCashCount', count(Voucher::where('voucher_type','=','Cash Voucher')->get()));
        view()->share('VoucherTransaction', VoucherTransaction::all());
        view()->share('VoucherJournalEntry', VoucherJournalEntry::all());
        
        view()->share('BankEdits', BankEdits::all());
        view()->share('CostCenterEdit', CostCenterEdit::all());
        view()->share('BudgetsEdit', BudgetsEdit::all());
        view()->share('COAEdits', COAEdits::all());
        view()->share('ProductAndServicesEdit', ProductAndServicesEdit::all());
        view()->share('CustomerEdit', CustomerEdit::all());
        view()->share('StCreditNote', StCreditNote::all());
        view()->share('EtItemDetailEdit', EtItemDetailEdit::all());
        view()->share('ETAccountDetailEdit', ETAccountDetailEdit::all());
        view()->share('StInvoiceEdit', StInvoiceEdit::all());
        view()->share('SalesTransactionEdit', SalesTransactionEdit::where([
            ['edit_status','=','0']
        ])->get());
        view()->share('StCreditNoteEdit', StCreditNoteEdit::all());
        view()->share('ExpenseTransactionEdit', ExpenseTransactionEdit::where([
            ['edit_status','=','0']
        ])->get());
        view()->share('PayBill', PayBill::all());
        view()->share('JournalEntryLists',JournalEntry::all());
        //view()->share('UserAccessList', UserAccess::all());
        
        view()->share('invoice_count',SalesTransaction::where([
                ['st_type','=','Invoice'],
                ['st_location', '=', 'Main'],
                ['st_invoice_type','=','Sales Invoice']
            ])->get());
        view()->share('main_Bill_invoice_count',SalesTransaction::where([
                ['st_type','=','Invoice'],
                ['st_location', '=', 'Main'],
                ['st_invoice_type','=','Bill Invoice']
            ])->get());
        view()->share('branch_Bill_invoice_count',SalesTransaction::where([
                ['st_type','=','Invoice'],
                ['st_location', '=', 'Branch'],
                ['st_invoice_type','=','Bill Invoice']
            ])->get());
        view()->share('branch_Sales_invoice_count',SalesTransaction::where([
                ['st_type','=','Invoice'],
                ['st_location', '=', 'Branch'],
                ['st_invoice_type','=','Sales Invoice']
            ])->get());
        view()->share('estimate_count',SalesTransaction::where('st_type','Estimate')->get());
        view()->share('credit_note_count',SalesTransaction::where('st_type','Credit Note')->get());
        view()->share('sales_receipt_count',SalesTransaction::where('st_type','Sales Receipt')->get());

        view()->share('expense_transaction_logs',ExpenseTransaction::all());
        view()->share('bill_transaction_count',ExpenseTransaction::where('et_type','Bill')->get());
        view()->share('bill_transaction_count_new',ExpenseTransactionNew::where('et_type','Bill')->get());
        view()->share('supplier_credit_transaction_count',ExpenseTransaction::where('et_type','Supplier credit')->get());


        view()->share('banks', Bank::all());
        view()->share('budgets', Budgets::all());
        view()->share('ST_SR', StSalesReceipt::all());
        view()->share('saleeeeeeee', SalesTransaction::orderBy('st_date','ASC')->get());
        view()->share('company_setting', Company::first());
        view()->share('sales_setting', Sales::first());
        view()->share('expense_setting', Expenses::first());
        view()->share('advance_setting', Advance::first());
        
        view()->share('saved_reports', Report::all());
        view()->share('c_o_a',ChartofAccount::where('coa_active','1')->orderBy('coa_detail_type','ASC')->get());
        view()->share('c_o_a_sorted',ChartofAccount::where('coa_active','1')->orderBy('id','ASC')->get());
        view()->share('coa_account_type',ChartofAccount::groupBy('coa_account_type')->orderBy('coa_detail_type','ASC')->get());
        
        view()->composer('*', function($view)
        {
            if (Auth::check()) {
                $view->with('user_position', Auth::user());
                $view->with('UserAccessList', UserAccess::where('user_id',Auth::user()->id)->get());
                $view->with('UserAccessCostCenterList', UserCostCenterAccess::where('use_id',Auth::user()->id)->get());
                
            }else {
                $view->with('user_position', null);
            }
        });
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
