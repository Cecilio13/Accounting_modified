<?php
use \setasign\Fpdi\Fpdi;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>['auth']], function() {
    
    
    Route::post('/create_database', 'GetController@create_database');
    Route::get('/export_dat_file', 'GetController@export_dat_file');
    Route::get('/export_profitandloss', 'ChartofAccountsController@export_profitandloss');
    Route::get('/export_profitandlossaspercent', 'ChartofAccountsController@export_profitandlossaspercent');
    Route::get('/export_profitandlossquarterly', 'ChartofAccountsController@export_profitandlossquarterly');
    Route::get('/export_profitandlosscomparison', 'ChartofAccountsController@export_profitandlosscomparison');
    Route::get('/exporttoexcelprofitandlossbycustomer', 'ChartofAccountsController@exporttoexcelprofitandlossbycustomer');
    Route::get('/exporttoexcelprofitandlossbymonth', 'ChartofAccountsController@exporttoexcelprofitandlossbymonth');
    Route::get('/exporttoexcelTaxRelief', 'ChartofAccountsController@exporttoexcelTaxRelief');
    
    Route::get('/export_trial_balance', 'ChartofAccountsController@export_trial_balance');
    Route::get('/export_test', 'ChartofAccountsController@export_test');
    Route::post('/getcoa_cc_name', 'GetController@getcoa_cc_name');
    Route::post('/get_latest_journal_series', 'GetController@get_latest_journal_series');
    Route::post('/get_journal_entry_data', 'GetController@get_journal_entry_data');
    
    Route::post('/save_cc_type', 'GetController@save_cc_type');
    Route::post('/check_cost_center_code', 'GetController@check_cost_center_code');
    Route::post('/check_cost_center_name', 'GetController@check_cost_center_name');
    Route::post('/get_customer_info', 'GetController@get_customer_info');
    Route::post('/get_product_info', 'GetController@get_product_info');
    
    Route::post('/destroy2', 'ChartofAccountsController@destroy2');
    Route::post('/supplierdestroy', 'SuppliersController@destroy2');
    Route::get('/dashboard', 'PagesController@dashboard');
    Route::get('/banking', 'PagesController@banking');
    Route::get('/voucher', 'PagesController@voucher');
    Route::get('/sales', 'PagesController@sales');
    Route::get('/expenses', 'PagesController@expenses');
    Route::get('/reports', 'PagesController@reports');
    Route::get('/taxes', 'PagesController@taxes');
    Route::get('/accounting', 'PagesController@accounting');
    Route::get('/cost_center', 'PagesController@cost_center');
    Route::get('/approvals', 'PagesController@approvals');
    
    Route::get('/checkregister', 'PagesController@checkregister');
    Route::post('/import_employee', 'PagesController@import_employee');
    
    Route::post('/update_journal_entry', 'JournalEntryController@update_journal_entry')->name('update_journal_entry');
    Route::post('/delete_overwrite_journal_entry', 'JournalEntryController@delete_overwrite_journal_entry')->name('delete_overwrite_journal_entry');
    Route::post('/getJournalEntryInfo', 'JournalEntryController@getJournalEntryInfo')->name('getJournalEntryInfo');
    Route::post('/cancel_entry', 'JournalEntryController@cancel_entry')->name('cancel_entry');
    Route::post('/add_journal_entry', 'JournalEntryController@add_journal_entry')->name('add_journal_entry');
    Route::post('/get_latest_journal_no', 'JournalEntryController@get_latest_journal_no')->name('get_latest_journal_no');
    
    Route::post('/update_customer_note', 'CustomersController@update_customer_note')->name('update_customer_note');
    Route::post('/update_supplier_note', 'SuppliersController@update_supplier_note')->name('update_supplier_note');
    Route::post('/update_expenses_credit_card_charges', 'SuppliersController@update_expenses_credit_card_charges')->name('update_expenses_credit_card_charges');
    Route::post('/add_deposit_record', 'SuppliersController@add_deposit_record')->name('add_deposit_record');
    Route::post('/add_pay_bill', 'SuppliersController@add_pay_bill')->name('add_pay_bill');
    Route::post('/update_pay_bill_note', 'SuppliersController@update_pay_bill_note')->name('update_pay_bill_note');
    
    Route::post('/delete_pending_bid_request', 'ChartofAccountsController@delete_pending_bid_request')->name('delete_pending_bid_request');
    Route::post('/approve_pending_bid_request', 'ChartofAccountsController@approve_pending_bid_request')->name('approve_pending_bid_request');
    Route::post('/approve_pending_bill_request', 'SuppliersController@approve_pending_bill_request')->name('approve_pending_bill_request');
    Route::post('/delete_pending_bill_request', 'SuppliersController@delete_pending_bill_request')->name('delete_pending_bill_request');
    Route::post('/update_expenses_sc', 'SuppliersController@update_expenses_sc')->name('update_expenses_sc');
    Route::post('/add_voucher', 'JournalEntryController@add_voucher')->name('add_voucher');
    Route::post('/update_expenses_cheque', 'SuppliersController@update_expenses_cheque')->name('update_expenses_cheque');
    Route::post('/update_expenses_expense', 'SuppliersController@update_expenses_expense')->name('update_expenses_expense');
    Route::post('/update_expenses_bill', 'SuppliersController@update_expenses_bill')->name('update_expenses_bill');
    Route::post('/uploadlogo', 'CompanyController@uploadlogo')->name('uploadlogo');
    Route::post('/add_bank', 'CompanyController@add_bank')->name('add_bank');
    Route::post('/delete_bank', 'CompanyController@delete_bank')->name('delete_bank');
    Route::post('/delete_bank_edit', 'CompanyController@delete_bank_edit')->name('delete_bank_edit');
    Route::post('/update_bank', 'CompanyController@update_bank')->name('update_bank');
    Route::post('/update_bank_edit', 'CompanyController@update_bank_edit')->name('update_bank_edit');
    
    
    
    Route::get('/generate_pdf_bir', 'FormstyleController@generate_pdf_bir')->name('generate_pdf_bir');
    Route::post('/uploadformstyle', 'FormstyleController@add_form_style')->name('uploadformstyle');
    Route::post('/editformstyle', 'FormstyleController@editformstyle')->name('editformstyle');
    Route::post('/deleteformstyle', 'FormstyleController@deleteformstyle')->name('deleteformstyle');
    Route::get('/previewformstyle', 'FormstyleController@previewformstyle')->name('previewformstyle');
    Route::post('/update_supplier', 'SuppliersController@update_supplier')->name('update_supplier');
    Route::post('/update_Supplier_edit', 'SuppliersController@update_Supplier_edit')->name('update_Supplier_edit');
    Route::post('/update_expense_edit', 'SuppliersController@update_expense_edit')->name('update_expense_edit');
    Route::post('/delete_expense_edit', 'SuppliersController@delete_expense_edit')->name('delete_expense_edit');
    
    Route::post('/update_company', 'CompanyController@update_company')->name('update_company');
    Route::post('/update_sales', 'CompanyController@update_sales')->name('update_sales');
    Route::post('/update_expenses', 'CompanyController@update_expenses')->name('update_expenses');
    Route::post('/update_advance', 'CompanyController@update_advance')->name('update_advance');
    Route::post('/update_customer', 'CustomersController@update_customer')->name('update_customer');
    Route::post('/update_Customer_edit', 'CustomersController@update_Customer_edit')->name('update_Customer_edit');
    Route::post('/delete_Customer_edit', 'CustomersController@delete_Customer_edit')->name('delete_Customer_edit');
    
    Route::get('/get_supplier', 'SuppliersController@get_supplier')->name('get_supplier');
    Route::get('/getExpenses', 'SuppliersController@getExpenses')->name('getExpenses');
    Route::post('/add_customer', 'CustomersController@add_customer')->name('add_customer');
    Route::post('/add_customer_supplier', 'CustomersController@add_customer_supplier')->name('add_customer_supplier');
    
    Route::post('/add_invoice', 'CustomersController@add_invoice')->name('add_invoice');
    Route::post('/GetTotalDeposited', 'CustomersController@GetTotalDeposited')->name('GetTotalDeposited');
    
    Route::post('/add_payment', 'CustomersController@add_payment')->name('add_payment');
    Route::post('/add_estimate', 'CustomersController@add_estimate')->name('add_estimate');
    Route::post('/add_sales_receipt', 'CustomersController@add_sales_receipt')->name('add_sales_receipt');
    Route::post('/add_refund_receipt', 'CustomersController@add_refund_receipt')->name('add_refund_receipt');
    Route::post('/add_delayed_charge', 'CustomersController@add_delayed_charge')->name('add_delayed_charge');
    Route::post('/add_delayed_credit', 'CustomersController@add_delayed_credit')->name('add_delayed_credit');
    Route::post('/add_credit_note', 'CustomersController@add_credit_note')->name('add_credit_note');
    
    Route::post('/add_invoice_journal', 'CustomersController@add_invoice_journal')->name('add_invoice_journal');
    Route::post('/set_journal_entry', 'CustomersController@set_journal_entry')->name('set_journal_entry');
    Route::post('/set_journal_entry_from_voucher', 'CustomersController@set_journal_entry_from_voucher')->name('set_journal_entry_from_voucher');
    
    Route::get('/refresh_sales_table', 'CustomersController@refresh_sales_table')->name('refresh_sales_table');
    Route::get('/refresh_sales_table_invoice', 'CustomersController@refresh_sales_table_invoice')->name('refresh_sales_table_invoice');
    Route::get('/refresh_sales_table_invoice2', 'CustomersController@refresh_sales_table_invoice2')->name('refresh_sales_table_invoice2');
    Route::get('/refresh_customers_table', 'CustomersController@refresh_customers_table')->name('refresh_customers_table');

    Route::get('/get_all_transactions', 'CustomersController@get_all_transactions')->name('get_all_transactions');
    Route::get('/get_all_estimates', 'CustomersController@get_all_estimates')->name('get_all_estimates');
    Route::get('/get_all_delayed_charge', 'CustomersController@get_all_delayed_charge')->name('get_all_delayed_charge');
    Route::get('/get_all_delayed_credit', 'CustomersController@get_all_delayed_credit')->name('get_all_delayed_credit');

    Route::post('/add_expense', 'SuppliersController@add_expense')->name('add_expense');
    Route::post('/add_cheque', 'SuppliersController@add_cheque')->name('add_cheque');
    Route::post('/add_bill', 'SuppliersController@add_bill')->name('add_bill');
    Route::post('/add_purchase_order', 'SuppliersController@add_purchase_order')->name('add_purchase_order');
    Route::post('/add_supplier_credit', 'SuppliersController@add_supplier_credit')->name('add_supplier_credit');
    Route::post('/add_card_credit', 'SuppliersController@add_card_credit')->name('add_card_credit');
   
    Route::post('/approve_user', 'PdfController@approve_user')->name('approve_user');
    Route::post('/deny_user', 'PdfController@deny_user')->name('deny_user');
    Route::post('/get_cost_centers', 'PdfController@get_cost_centers')->name('get_cost_centers');
    Route::post('/update_user_access', 'PdfController@update_user_access')->name('update_user_access');
    
    Route::get('generate_pdf','PdfController@generate');

    Route::get('/reports', 'PagesController@reports');
    Route::get('/userprofile', 'PagesController@userprofile');
    
    Route::get('/invoice', 'PagesController@invoice');
    Route::get('/receivepayment', 'PagesController@receivepayment');
    Route::get('/estimate', 'PagesController@estimate');
    Route::get('/creditnotice', 'PagesController@creditnotice');
    Route::get('/salesreceipt', 'PagesController@salesreceipt');
    Route::get('/sales', 'PagesController@sales');
    Route::get('/refundreceipt', 'PagesController@refundreceipt');
    Route::get('/delayedcredit', 'PagesController@delayedcredit');
    Route::get('/delayedcharge', 'PagesController@delayedcharge');
    Route::get('/pending_user', 'PagesController@pending_user');
    
    Route::get('/print_journal_entry', 'PagesController@print_journal_entry');
    Route::get('/print_cheque_journal_entry', 'PagesController@print_cheque_journal_entry');
    
    Route::get('/expense', 'PagesController@expense');
    Route::get('/cheque', 'PagesController@cheque');
    Route::get('/bill', 'PagesController@bill');
    Route::get('/paybills', 'PagesController@paybills');
    Route::get('/purchaseorder', 'PagesController@purchaseorder');
    Route::get('/suppliercredit', 'PagesController@suppliercredit');
    Route::get('/creditcardcredit', 'PagesController@creditcardcredit');

    Route::get('/bankdeposit', 'PagesController@bankdeposit');
    Route::get('/transfer', 'PagesController@transfer');
    Route::get('/journalentry', 'PagesController@journalentry');
    Route::get('/statements', 'PagesController@statements');
    Route::get('/investqtyadj', 'PagesController@investqtyadj');

    Route::get('/accountsandsettings', 'PagesController@accountsandsettings');
    Route::get('/customformstyles', 'PagesController@customformstyles');


    Route::get('/alllists', 'PagesController@alllists');

    Route::get('/recurringtransactions', 'PagesController@recurringtransactions');
    Route::get('/attachments', 'PagesController@attachments');

    Route::get('/importdata', 'PagesController@importdata');
    Route::get('/exportdata', 'PagesController@exportdata');

    Route::get('/budgeting', 'PagesController@budgeting');
    Route::get('/auditlog', 'PagesController@auditlog');
    
    Route::get('/customerinfo', 'CustomersController@getcustomerinfo')->name('customerinfo');
    Route::get('/Employee_Contact_List', 'ReportController@Employee_Contact_List')->name('Employee_Contact_List');
    Route::get('/Customer_Contact_List', 'ReportController@Customer_Contact_List')->name('Customer_Contact_List');
    Route::get('/ProductandServices_List', 'ReportController@ProductandServices_List')->name('ProductandServices_List');
    Route::get('/Supplier_Contact_List', 'ReportController@Supplier_Contact_List')->name('Supplier_Contact_List');
    Route::get('/Open_Invoice_List', 'ReportController@Open_Invoice_List')->name('Open_Invoice_List');
    
    
    Route::get('/Movements_in_Equity', 'ReportController@Movements_in_Equity')->name('Movements_in_Equity');
    Route::get('/VAT_List', 'ReportController@VAT_List')->name('VAT_List');
    Route::get('/sales_transaction_list', 'ReportController@sales_transaction_list')->name('sales_transaction_list');
    Route::get('/expense_transaction_list', 'ReportController@expense_transaction_list')->name('expense_transaction_list');
    Route::get('/Customer_Balance_Summary', 'ReportController@Customer_Balance_Summary')->name('Customer_Balance_Summary');
    Route::get('/Invoice_List', 'ReportController@Invoice_List')->name('Invoice_List');
    Route::get('/AR_Receivable_Ageing', 'ReportController@AR_Receivable_Ageing')->name('AR_Receivable_Ageing');
    Route::get('/Estimate_by_Customer', 'ReportController@Estimate_by_Customer')->name('Estimate_by_Customer');
    Route::get('/Collection_Report', 'ReportController@Collection_Report')->name('Collection_Report');
    Route::get('/SalesbyCustomer', 'ReportController@SalesbyCustomer')->name('SalesbyCustomer');
    Route::get('/SalesbyProduct', 'ReportController@SalesbyProduct')->name('SalesbyProduct');
    Route::get('/DepositDetail', 'ReportController@DipositDetail')->name('DepositDetail');
    Route::get('/Journal_Summary', 'ReportController@Journal_Summary')->name('Journal_Summary');
    Route::get('/Trial_Balance', 'ReportController@Trial_Balance')->name('Trial_Balance');
    Route::get('/General_Ledger', 'ReportController@General_Ledger')->name('General_Ledger');
    Route::get('/Check_Details', 'ReportController@Check_Details')->name('Check_Details');
    Route::get('/Transaction_List_By_Supplier', 'ReportController@Transaction_List_By_Supplier')->name('Transaction_List_By_Supplier');
    Route::get('/Transaction_List_By_Date', 'ReportController@Transaction_List_By_Date')->name('Transaction_List_By_Date');
    Route::get('/RecentTransactions', 'ReportController@RecentTransactions')->name('RecentTransactions');
    Route::get('/AuditLogs', 'ReportController@AuditLogs')->name('AuditLogs');
    Route::get('/AccountList', 'ReportController@AccountList')->name('AccountList');
    Route::get('/ProfitAndLost', 'ReportController@ProfitAndLost')->name('ProfitAndLost');
    Route::get('/ProfitAndLostComparison', 'ReportController@ProfitAndLostComparison')->name('ProfitAndLostComparison');
    Route::get('/ProfitandLossasPercentageTotal', 'ReportController@ProfitandLossasPercentageTotal')->name('ProfitandLossasPercentageTotal');
    Route::get('/ProfitAndLossByCustomer', 'ReportController@ProfitAndLossByCustomer')->name('ProfitAndLossByCustomer');
    Route::get('/ProfitAndLossByMonth', 'ReportController@ProfitAndLossByMonth')->name('ProfitAndLossByMonth');
    Route::get('/QuaarterlyProfitAndLoss', 'ReportController@QuaarterlyProfitAndLoss')->name('QuaarterlyProfitAndLoss');
    Route::get('/StatementofCashFlows', 'ReportController@StatementofCashFlows')->name('StatementofCashFlows');
    Route::get('/StatementofChangesinEquity', 'ReportController@StatementofChangesinEquity')->name('StatementofChangesinEquity');
    Route::get('/BalanceSheet', 'ReportController@BalanceSheet')->name('BalanceSheet');
    Route::get('/BalanceSheetDetail', 'ReportController@BalanceSheetDetail')->name('BalanceSheetDetail');
    Route::get('/BalanceSheetComparison', 'ReportController@BalanceSheetComparison')->name('BalanceSheetComparison');
    Route::get('/AccountsPayableDetail', 'ReportController@AccountsPayableDetail')->name('AccountsPayableDetail');
    Route::get('/AccountsPayableAgeingSummary', 'ReportController@AccountsPayableAgeingSummary')->name('AccountsPayableAgeingSummary');
    Route::get('/Ledger_for_COA_Desc', 'ReportController@Ledger_for_COA_Desc')->name('Ledger_for_COA_Desc');
    Route::get('/ledgerforcoadesc_sub', 'ReportController@ledgerforcoadesc_sub')->name('ledgerforcoadesc_sub');
    Route::get('/sub_ledger', 'ReportController@sub_ledger')->name('sub_ledger');
    Route::get('/sub_ledger_by_customer', 'ReportController@sub_ledger_by_customer')->name('sub_ledger_by_customer');
    Route::get('/sub_ledger_by_supplier', 'ReportController@sub_ledger_by_supplier')->name('sub_ledger_by_supplier');
    Route::get('/sub_ledger_by_employee', 'ReportController@sub_ledger_by_employee')->name('sub_ledger_by_employee');
    
    Route::get('/BudgetSummaryReport', 'ReportController@BudgetSummaryReport')->name('BudgetSummaryReport');
    
    
    Route::post('/MovementinEquityByDate', 'ReportController@MovementinEquityByDate')->name('MovementinEquityByDate');
    Route::post('/favorite_report', 'ReportController@favorite_report')->name('favorite_report');
    Route::post('/VAT_List_By_Date', 'ReportController@VAT_List_By_Date')->name('VAT_List_By_Date');
    Route::post('/sales_transaction_list_by_date', 'ReportController@sales_transaction_list_by_date')->name('sales_transaction_list_by_date');
    Route::post('/expense_transaction_list_by_date', 'ReportController@expense_transaction_list_by_date')->name('expense_transaction_list_by_date');
    Route::post('/update_sales_receipt_edit', 'ReportController@update_sales_receipt_edit')->name('update_sales_receipt_edit');
    Route::post('/update_credit_note_edit', 'ReportController@update_credit_note_edit')->name('update_credit_note_edit');
    Route::post('/update_invoice_edit', 'ReportController@update_invoice_edit')->name('update_invoice_edit');
    Route::post('/update_invoice_edit2', 'ReportController@update_invoice_edit2')->name('update_invoice_edit2');
    Route::post('/delete_invoice_edit', 'ReportController@delete_invoice_edit')->name('delete_invoice_edit');
    Route::post('/update_credit_note_edit2', 'ReportController@update_credit_note_edit2')->name('update_credit_note_edit2');
    Route::post('/delete_credit_note_edit', 'ReportController@delete_credit_note_edit')->name('delete_credit_note_edit');
    
    Route::post('/replaceeditinvoicemodal', 'ReportController@replaceeditinvoicemodal')->name('replaceeditinvoicemodal');
    Route::post('/deactivate_report', 'ReportController@deactivate_report')->name('deactivate_report');
    Route::post('/save_product','CustomersController@save_product')->name('save_product');
    Route::post('/update_product','CustomersController@update_product')->name('update_product');
    Route::post('/update_prod_edit','CustomersController@update_prod_edit')->name('update_prod_edit');
    Route::post('/delete_prod_edit','CustomersController@delete_prod_edit')->name('delete_prod_edit');
    
    Route::post('/AccountsPayableByDate', 'ReportController@AccountsPayableByDate')->name('AccountsPayableByDate');
    Route::post('/BalanceSheetComparisonByDate', 'ReportController@BalanceSheetComparisonByDate')->name('BalanceSheetComparisonByDate');
    Route::post('/BalanceSheetDetailByDate', 'ReportController@BalanceSheetDetailByDate')->name('BalanceSheetDetailByDate');
    Route::post('/BalanceSheetByDate', 'ReportController@BalanceSheetByDate')->name('BalanceSheetByDate');
    Route::post('/StatementofchangeinequityByDate', 'ReportController@StatementofchangeinequityByDate')->name('StatementofchangeinequityByDate');
    Route::post('/StatementofCashFlowByDate', 'ReportController@StatementofCashFlowByDate')->name('StatementofCashFlowByDate');
    Route::post('/QuarterlyProfitandlossByDate', 'ReportController@QuarterlyProfitandlossByDate')->name('QuarterlyProfitandlossByDate');
    Route::post('/ProfitandlossByMonthByDate', 'ReportController@ProfitandlossByMonthByDate')->name('ProfitandlossByMonthByDate');
    Route::post('/ProfitandlossByCustomerByDate', 'ReportController@ProfitandlossByCustomerByDate')->name('ProfitandlossByCustomerByDate');
    Route::post('/ProfitandlossaspercetagetotalByDate', 'ReportController@ProfitandlossaspercetagetotalByDate')->name('ProfitandlossaspercetagetotalByDate');
    Route::post('/ProfitandlossComparisonByDate', 'ReportController@ProfitandlossComparisonByDate')->name('ProfitandlossComparisonByDate');
    Route::post('/ProfitandlossByDate', 'ReportController@ProfitandlossByDate')->name('ProfitandlossByDate');
    Route::post('/AuditLogByDate', 'ReportController@AuditLogByDate')->name('AuditLogByDate');
    Route::post('/TransactionListByDateDate', 'ReportController@TransactionListByDateDate')->name('TransactionListByDateDate');
    Route::post('/TransactionListByDate_Date', 'ReportController@TransactionListByDate_Date')->name('TransactionListByDate_Date');
    Route::post('/AccountsPayableAgeingSummaryByDate', 'ReportController@AccountsPayableAgeingSummaryByDate')->name('AccountsPayableAgeingSummaryByDate');
    
    Route::post('/TransactionListBySupplier', 'ReportController@TransactionListBySupplier')->name('TransactionListBySupplier');
    Route::post('/ChequeDetail_bydate', 'ReportController@ChequeDetail_bydate')->name('ChequeDetail_bydate');
    Route::post('/General_Ledger_by_date', 'ReportController@General_Ledger_by_date')->name('General_Ledger_by_date');
    Route::post('/Trial_balance_by_date', 'ReportController@Trial_balance_by_date')->name('Trial_balance_by_date');
    Route::post('/Journal_by_date', 'ReportController@Journal_by_date')->name('Journal_by_date');
    Route::post('/deposit_detail_by_date', 'ReportController@deposit_detail_by_date')->name('deposit_detail_by_date');
    Route::post('/salesbyProduct_Summary_by_date', 'ReportController@salesbyProduct_Summary_by_date')->name('salesbyProduct_Summary_by_date');
    Route::post('/salesbyCustomer_Summary_by_date', 'ReportController@salesbyCustomer_Summary_by_date')->name('salesbyCustomer_Summary_by_date');
    Route::post('/AR_REceivable_ageing_by_date', 'ReportController@AR_REceivable_ageing_by_date')->name('AR_REceivable_ageing_by_date');
    Route::post('/Open_Invoice_List_by_date', 'ReportController@Open_Invoice_List_by_date')->name('Open_Invoice_List_by_date');
    Route::post('/estimatebycustomer_by_date', 'ReportController@estimatebycustomer_by_date')->name('estimatebycustomer_by_date');
    Route::post('/collectionreport_bydate', 'ReportController@collectionreport_bydate')->name('collectionreport_bydate');
    Route::post('/Invoice_List_by_date', 'ReportController@Invoice_List_by_date')->name('Invoice_List_by_date');
    Route::post('/GetCostCenterBudget', 'ReportController@GetCostCenterBudget')->name('GetCostCenterBudget');
    Route::post('/SaveBudget', 'ReportController@SaveBudget')->name('SaveBudget');
    Route::post('/Budget_Summary_By_Date', 'ReportController@Budget_Summary_By_Date')->name('Budget_Summary_By_Date');
    
    Route::post('/Customer_Balance_Summary_by_date', 'ReportController@Customer_Balance_Summary_by_date')->name('Customer_Balance_Summary_by_date');
    Route::post('/ledger_for_desc_by_date', 'ReportController@ledger_for_desc_by_date')->name('ledger_for_desc_by_date');
    Route::post('/ledger_desc_sub_by_date', 'ReportController@ledger_desc_sub_by_date')->name('ledger_desc_sub_by_date');
    Route::post('/employee_contact_add', 'ReportController@employee_contact_add')->name('employee_contact_add');
    Route::post('/getSessionTimeout', 'CompanyController@getSessionTimeout')->name('getSessionTimeout');
    Route::post('/findInvoiceNo', 'CustomersController@findInvoiceNo')->name('findInvoiceNo');
    Route::post('/findInvoiceNoCu', 'CustomersController@findInvoiceNoCu')->name('findInvoiceNoCu');
    
    
    Route::post('/update_bid_of_quotation', 'ChartofAccountsController@update_bid_of_quotation')->name('update_bid_of_quotation');
    Route::post('/UploadMassBudget', 'ChartofAccountsController@UploadMassBudget')->name('UploadMassBudget');
    Route::post('/UploadMassCC', 'ChartofAccountsController@UploadMassCC')->name('UploadMassCC');
    Route::post('/UploadMassCOA', 'ChartofAccountsController@UploadMassCOA')->name('UploadMassCOA');
    Route::post('/UploadMassCustomer', 'ChartofAccountsController@UploadMassCustomer')->name('UploadMassCustomer');
    Route::post('/UploadMassSupplier', 'ChartofAccountsController@UploadMassSupplier')->name('UploadMassSupplier');
    Route::post('/update_COA_edit', 'ChartofAccountsController@update_COA_edit')->name('update_COA_edit');
    Route::post('/delete_COA_edit', 'ChartofAccountsController@delete_COA_edit')->name('delete_COA_edit');
    Route::post('/update_CC_edit', 'ChartofAccountsController@update_CC_edit')->name('update_CC_edit');
    Route::post('/delete_CC_edit', 'ChartofAccountsController@delete_CC_edit')->name('delete_CC_edit');
    Route::post('/UploadMassJournalEntry', 'ChartofAccountsController@UploadMassJournalEntry')->name('UploadMassJournalEntry');
    Route::post('/UploadMassInvoice', 'ChartofAccountsController@UploadMassInvoice')->name('UploadMassInvoice');
    Route::post('/UploadMassBIDQuot', 'ChartofAccountsController@UploadMassBIDQuot')->name('UploadMassBIDQuot');
    
    
    Route::post('/export_ledger_to_excel', 'ChartofAccountsController@export_ledger_to_excel')->name('export_ledger_to_excel');
    Route::get('/GetInvoiceExcelTemplate', 'ChartofAccountsController@GetInvoiceExcelTemplate')->name('GetInvoiceExcelTemplate');
    Route::get('/GetBudgetTemplateExcel', 'ChartofAccountsController@GetBudgetTemplateExcel')->name('GetBudgetTemplateExcel');
    Route::get('/GetBudgetTemplateExcel_Bid_of_Quotation', 'ChartofAccountsController@GetBudgetTemplateExcel_Bid_of_Quotation')->name('GetBudgetTemplateExcel_Bid_of_Quotation');
    Route::get('/GetJournalEntryTemplateExcel', 'ChartofAccountsController@GetJournalEntryTemplateExcel')->name('GetJournalEntryTemplateExcel');
    Route::get('/GetSupplierTemplateExcel', 'ChartofAccountsController@GetSupplierTemplateExcel')->name('GetSupplierTemplateExcel');
    Route::get('/GetCustomerTemplateExcel', 'ChartofAccountsController@GetCustomerTemplateExcel')->name('GetCustomerTemplateExcel');
    Route::get('/GetChartofAccountsExcelemplate', 'ChartofAccountsController@GetChartofAccountsExcelemplate')->name('GetChartofAccountsExcelemplate');
    Route::get('/GetChartofCostCenterExcelemplate', 'ChartofAccountsController@GetChartofCostCenterExcelemplate')->name('GetChartofCostCenterExcelemplate');
    Route::get('/EditChartofAccounts', 'ChartofAccountsController@editchartofAccounts')->name('editchartofAccounts');
    Route::get('/getfile', 'ChartofAccountsController@getfile')->name('getfile');
    

    Route::post('/delete_cost_center', 'ChartofAccountsController@delete_cost_center')->name('delete_cost_center');
    Route::post('/GetCodeCostCenter', 'ChartofAccountsController@GetCodeCostCenter')->name('GetCodeCostCenter');
    Route::post('/SetCostCenterEdit', 'ChartofAccountsController@SetCostCenterEdit')->name('SetCostCenterEdit');
    Route::post('/SetCostCenter', 'ChartofAccountsController@SetCostCenter')->name('SetCostCenter');
    Route::post('/GetCodeCostCenterEdit', 'ChartofAccountsController@GetCodeCostCenterEdit')->name('GetCodeCostCenterEdit');
    Route::post('/syncdata', 'CompanyController@syncdata')->name('syncdata');
    
});
Route::get('/confirm_account', 'GetController@confirm_first_admin_account');


// Route::get('/', 'PagesController@reports');


Route::post('/sync_data_v_two', 'CompanyController@syncdata')->name('sync_data_v_two');
Route::post('/sync_audit_log', 'SyncController@sync_audit_log')->name('sync_audit_log');
Route::post('/sync_banks', 'SyncController@sync_banks')->name('sync_banks');
Route::post('/sync_budget', 'SyncController@sync_budget')->name('sync_budget');
Route::post('/sync_coa', 'SyncController@sync_coa')->name('sync_coa');
Route::post('/sync_cc', 'SyncController@sync_cc')->name('sync_cc');
Route::post('/sync_customer', 'SyncController@sync_customer')->name('sync_customer');
Route::post('/sync_expense', 'SyncController@sync_expense')->name('sync_expense');
Route::post('/sync_journal_entries', 'SyncController@sync_journal_entries')->name('sync_journal_entries');
Route::post('/sync_paybills', 'SyncController@sync_paybills')->name('sync_paybills');
Route::post('/sync_po', 'SyncController@sync_po')->name('sync_po');
Route::post('/sync_sales', 'SyncController@sync_sales')->name('sync_sales');
Route::post('/sync_setting', 'SyncController@sync_setting')->name('sync_setting');
Route::post('/sync_st', 'SyncController@sync_st')->name('sync_st');
Route::post('/sync_user', 'SyncController@sync_user')->name('sync_user');
Route::post('/sync_voucher', 'SyncController@sync_voucher')->name('sync_voucher');
Route::get('/sample_sync', 'SyncController@sample_sync')->name('sample_sync');

Route::get('/sync', 'PagesController@sync')->name('sync');
Route::get('/clear-cache', function() {
    session()->flush();
    Artisan::call('cache:clear');
    return redirect('/');
});
Auth::routes();
Route::get('/', 'PagesController@index');
Route::get('/home', 'HomeController@index')->name('home');


//controller routes
Route::resource('ChartsofAccounts','ChartofAccountsController');
Route::resource('Suppliers','SuppliersController');

Route::get('/BIR', function () {
    include "../vendor/autoload.php";
    require_once('../vendor/setasign/fpdf/fpdf.php');
    require_once('../vendor/setasign/fpdi/src/autoload.php');
    
    $pdf = new FPDI('l');
    $pagecount = $pdf->setSourceFile( 'ex/forms.pdf' );
    $tpl = $pdf->importPage(1);
    $size = $pdf->getTemplateSize($tpl);
    $pdf->AddPage('P', array($size['0'], $size['1']));

    // Use the imported page as the template
    $pdf->useTemplate($tpl);

    // Set the default font to use
    $pdf->SetFont('Helvetica');

    // adding a Cell using:
    // $pdf->Cell( $width, $height, $text, $border, $fill, $align);

    /* // First box - the user's Name
    $pdf->SetFontSize('30'); // set font size
    $pdf->SetXY(0, 0); // set the position of the box
    $pdf->Cell(0, 10, 'Niraj Shah', 0, 0, 'C'); // add the text, align to Center of cell

    // add the reason for certificate
    // note the reduction in font and different box position
    $pdf->SetFontSize('20');
    $pdf->SetXY(80, 105);
    $pdf->Cell(150, 10, 'creating an awesome tutorial', 0, 0, 'C');
    */
    //***FOR THE PERIOD FROM***
    // the month
    $pdf->SetXY(34,33);
    $pdf->Cell(30, 10, date('m'), 0, 0, 'L');

    // the day
    $pdf->SetFontSize('12');
    $pdf->SetXY(44,33);
    $pdf->Cell(20, 10, date('d'), 0, 0, 'L');


    // the year, aligned to Left
    $pdf->SetXY(54,33);
    $pdf->Cell(20, 10, date('y'), 0, 0, 'L');

    //***FOR THE PERIOD TO***
    // the month
    $pdf->SetXY(115,33);
    $pdf->Cell(30, 10, date('m'), 0, 0, 'L');

    // the day
    $pdf->SetFontSize('12');
    $pdf->SetXY(125,33);
    $pdf->Cell(20, 10, date('d'), 0, 0, 'L');


    // the year, aligned to Left
    $pdf->SetXY(135,33);
    $pdf->Cell(20, 10, date('y'), 0, 0, 'L');

    //***TIN***
    $pdf->SetFontSize('14');
    // first 3
    $pdf->SetXY(39,45);
    $pdf->Cell(30, 10, "7 2 1", 0, 0, 'L');
    // second 3
    $pdf->SetXY(56,45);
    $pdf->Cell(30, 10, "2 4 1", 0, 0, 'L');
    // third 3
    $pdf->SetXY(74,45);
    $pdf->Cell(30, 10, "3 1 1", 0, 0, 'L');
    // forth 3
    $pdf->SetXY(92,45);
    $pdf->Cell(30, 10, "5 5 5", 0, 0, 'L');

    //***Registered Name***
    $pdf->SetFontSize('12');

    $pdf->SetXY(39,52);
    $pdf->Cell(30, 10, "Registered Name", 0, 0, 'L');
    //***Registered Address***
    $pdf->SetFontSize('10');

    $pdf->SetXY(39,61);
    $pdf->Cell(30, 10, "Registered Address", 0, 0, 'L');

    $pdf->SetFontSize('17');

    $pdf->SetXY(187,61);
    $pdf->Cell(30, 10, "8 0 0 0", 0, 0, 'L');

    //***Foreign Address***
    $pdf->SetFontSize('10');

    $pdf->SetXY(39,67);
    $pdf->Cell(30, 10, "Foreign Address", 0, 0, 'L');
    $pdf->SetFontSize('17');

    $pdf->SetXY(187,67);
    $pdf->Cell(30, 10, "8 0 0 0", 0, 0, 'L');

    //***TIN Payor***
    $pdf->SetFontSize('14');
    // first 3
    $pdf->SetXY(39,78);
    $pdf->Cell(30, 10, "7 2 1", 0, 0, 'L');
    // second 3
    $pdf->SetXY(56,78);
    $pdf->Cell(30, 10, "2 4 1", 0, 0, 'L');
    // third 3
    $pdf->SetXY(74,78);
    $pdf->Cell(30, 10, "3 1 1", 0, 0, 'L');
    // forth 3
    $pdf->SetXY(92,78);
    $pdf->Cell(30, 10, "5 5 5", 0, 0, 'L');

    //***Registered Name Payor***
    $pdf->SetFontSize('12');

    $pdf->SetXY(39,85);
    $pdf->Cell(30, 10, "Registered Name", 0, 0, 'L');
    //***Registered Address Payor***
    $pdf->SetFontSize('10');

    $pdf->SetXY(39,94);
    $pdf->Cell(30, 10, "Registered Address", 0, 0, 'L');

    $pdf->SetFontSize('17');

    $pdf->SetXY(187,94);
    $pdf->Cell(30, 10, "8 0 0 0", 0, 0, 'L');
    //***Part II***
    $pdf->SetFontSize('8');
    $Y=117.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=122;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=126.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=130.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=135;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=139.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=144;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=148.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=152.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=157;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=161;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=165;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=169;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=173.5;
    // $pdf->SetXY(6.5,$Y);
    // $pdf->Cell(30, 10, "Income Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    //Part II.5
    $Y=186;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=190;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=194;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=198;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=202.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=206;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=210;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=214;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=218;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=222;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=226;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=230;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=234;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=238;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=242;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=246;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');
    $Y=250;
    /* $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "Money Payments", 0, 0, 'L'); */
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "ATC", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "1ST Quarter", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "2ND Quarter", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "3RD Quarter", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "Total Amount", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "Tax Withheld", 0, 0, 'L');

    //***Part III***
    $pdf->SetFontSize('8');
    $Y=271;
    $pdf->SetXY(10,$Y);
    $pdf->Cell(30, 10, "Roll No.", 0, 0, 'L');
    $pdf->SetXY(114,$Y);
    $pdf->Cell(30, 10, "MM-DD-YY", 0, 0, 'L');
    $pdf->SetXY(171,$Y);
    $pdf->Cell(30, 10, "MM-DD-YY", 0, 0, 'L');
    $Y=292.5;
    $pdf->SetXY(10,$Y);
    $pdf->Cell(30, 10, "Roll No.", 0, 0, 'L');
    $pdf->SetXY(114,$Y);
    $pdf->Cell(30, 10, "MM-DD-YY", 0, 0, 'L');
    $pdf->SetXY(171,$Y);
    $pdf->Cell(30, 10, "MM-DD-YY", 0, 0, 'L');



    //**SECOND PAGE**
    $tpl = $pdf->importPage(2);
    $size = $pdf->getTemplateSize($tpl);
    $pdf->AddPage('P', array($size['0'], $size['1']));

    // Use the imported page as the template
    $pdf->useTemplate($tpl);

    // render PDF to browser
    $pdf->Output();
});