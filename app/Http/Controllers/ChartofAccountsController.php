<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\ChartofAccount;
use App\COAEdits;
use App\Customers;
use App\JournalEntry;
use App\ProductsAndServices;
use App\AuditLog;
use App\Voucher;
use Excel;
use App\SalesTransaction;
use App\Numbering;
use App\CostCenter;
use App\CostCenterEdit;
use App\Supplier;
use App\Budgets;
use App\BudgetsEdit;
use App\StInvoice;
use Illuminate\Support\Facades\Storage;
use PHPExcel; 
use PHPExcel_IOFactory;
class ChartofAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $on='0';
        if($request->input('COASubAcc')=="on"){
            $on='1';
        }else{
            $on='0';

        }
        //Create New Chart Of Account
        $Chart= New ChartofAccount;
        $Chart->id= ChartofAccount::count() + 1;
        $cccdcd=ChartofAccount::count() + 1;
        if($request->input('ACCType')=="Custom"){
            $Chart->coa_account_type=$request->input('customaccounttype');
            $Chart->coa_detail_type=$request->input('customdetailtyep');
            $Chart->coa_name=$request->input('customdetailtyep');
        }else{
            $Chart->coa_account_type=$request->input('ACCType');
            $Chart->coa_detail_type=$request->input('DetType');
            $Chart->coa_name=$request->input('DetType');
        }
        
        $Chart->coa_sub_account=$request->input('sub_accoinmt');
        $Chart->coa_description=$request->input('COADesc');
        $Chart->coa_code=$request->input('COACode');
        $Chart->normal_balance=$request->input('COANormalBalance');
        $Chart->coa_is_sub_acc=$on;
        $Chart->coa_parent_account=$request->input('COAParentAcc');
        $Chart->coa_balance=$request->input('COABalance');
        $Chart->coa_beginning_balance=$request->input('COABalance');
        $Chart->coa_as_of_date=$request->input('COAAsof');
        $Chart->coa_active=$request->input('active');
        $Chart->coa_title=$request->input('coatitle');
        $Chart->coa_cc=$request->input('coa_cc');
        $Chart->save();

        $AuditLog= new AuditLog;
        $AuditLogcount=AuditLog::count()+1;
        $userid = Auth::user()->id;
        $username = Auth::user()->name;
        $eventlog="Added Account No. ".$cccdcd;
        $AuditLog->log_id=$AuditLogcount;
        $AuditLog->log_user_id=$username;
        $AuditLog->log_event=$eventlog;
        $AuditLog->log_name="";
        $AuditLog->log_transaction_date="";
        $AuditLog->log_amount="";
        $AuditLog->save();
        return redirect('/accounting')->with('success','Successfully Added A New Chart of Account');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customers = Customers::all();
        $chart= ChartofAccount::find($id);
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
            $totalexp=$totalexp+$et->et_ad_total;
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();
        $cost_center_list= CostCenter::where('cc_status','1')->get();
        $st_invoice = DB::table('st_invoice')->get();
        return view('pages.edit_chart',compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','VoucherCount','customers','chart','JournalEntry','jounalcount','products_and_services'));
    }
    public function editchartofAccounts(Request $request)
    {
        $customers = Customers::all();
        $chart= ChartofAccount::find($request->id);
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
            $totalexp=$totalexp+$et->et_ad_total;
        }
        $COA= ChartofAccount::where('coa_active','1')->get();
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();
        $cost_center_list= CostCenter::where('cc_status','1')->get();
        $st_invoice = DB::table('st_invoice')->get();
        return view('pages.edit_chart',compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','VoucherCount','customers','chart','JournalEntry','jounalcount','products_and_services'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
    public function update(Request $request, $id)
    {
        
        $on='0';
        if($request->input('COASubAcc2')=="on"){
            $on='1';
        }else{
            $on='0';

        }
        $Chart=COAEdits::find($id);
        if(empty($Chart)){
            $Chart = new COAEdits;

        }
        if($request->input('ACCType2')=="Custom"){
            $Chart->coa_account_type=$request->input('customaccounttype2');
            $Chart->coa_detail_type=$request->input('customdetailtyep2');
            $Chart->coa_name=$request->input('customdetailtyep2');
        }else{
            $Chart->coa_account_type=$request->input('ACCType2');
            $Chart->coa_detail_type=$request->input('DetType2');
            $Chart->coa_name=$request->input('DetType2');
        }
        
        $Chart->id=$id;
        $Chart->coa_sub_account=$request->input('sub_accoinmt2');
        $Chart->coa_description=$request->input('COADesc2');
        $Chart->coa_code=$request->input('COACode2');
        $Chart->normal_balance=$request->input('COANormalBalance2');
        $Chart->coa_is_sub_acc=$on;
        $Chart->coa_parent_account=$request->input('COAParentAcc2');
        $Chart->coa_beginning_balance=$request->input('COABalance2');
        $Chart->coa_as_of_date=$request->input('COAAsof2');
        $Chart->coa_title=$request->input('coatitl2e');
        $Chart->coa_cc=$request->input('coa_cc2');
        $Chart->edit_status="0";
        $Chart->save();
        // $AuditLog= new AuditLog;
        // $AuditLogcount=AuditLog::count()+1;
        // $userid = Auth::user()->id;
        // $username = Auth::user()->name;
        // $eventlog="Updated Account No. ".$id;
        // $AuditLog->log_id=$AuditLogcount;
        // $AuditLog->log_user_id=$username;
        // $AuditLog->log_event=$eventlog;
        // $AuditLog->log_name="";
        // $AuditLog->log_transaction_date="";
        // $AuditLog->log_amount="";
        // $AuditLog->save();
        return redirect('/accounting')->with('success','Chart of Account Updated');
    }

  
    public function destroy2(Request $request)
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

        // $AuditLog= new AuditLog;
        // $AuditLogcount=AuditLog::count()+1;
        // $userid = Auth::user()->id;
        // $username = Auth::user()->name;
        // $eventlog="Deleted Account No. ".$request->input('id');
        // $AuditLog->log_id=$AuditLogcount;
        // $AuditLog->log_user_id=$username;
        // $AuditLog->log_event=$eventlog;
        // $AuditLog->log_name="";
        // $AuditLog->log_transaction_date="";
        // $AuditLog->log_amount="";
        // $AuditLog->save();
        return redirect('/accounting')->with('success','Chart of Account Deleted');
    }
    public function export_test(Request $request){
        Excel::load('extra/export_report/export_report_template_journal.xlsx', function($doc) use($request){
        $FROM=$request->FROM;
        $TO=$request->TO;
        $CostCenterFilter=$request->CostCenterFilter;
        $filtertemplate=$request->filtertemplate;
        $sortsetting="WHERE st_date BETWEEN '".$FROM."' AND '".$TO."'";
        $sortsettingjournal="WHERE created_at BETWEEN '".$FROM."' AND '".$TO."' AND";
        if($filtertemplate=="All"){
            $sortsetting="";
            $sortsettingjournal="";
        }
        if($sortsettingjournal==""){
            $sortjournal="WHERE je_cost_center='".$CostCenterFilter."' AND (remark!='NULLED' OR remark IS NULL)";
        }else{
            $sortjournal=" WHERE je_cost_center='".$CostCenterFilter."'  AND (remark!='NULLED' OR remark IS NULL)";
        }
        
        if($CostCenterFilter=="All" || $CostCenterFilter=="By Cost Center"){
            $sortjournal="WHERE (remark!='NULLED' OR remark IS NULL)";
            $sortsettingjournal="WHERE created_at BETWEEN '".$FROM."' AND '".$TO."'";
            if($filtertemplate=="All"){
                $sortsetting="";
                $sortsettingjournal="";
            }
        }
        $je_grouped= DB::table('journal_entries')
                ->whereBetween('journal_entries.created_at', [$FROM, $TO])
                ->join('cost_center', 'journal_entries.je_cost_center', '=', 'cost_center.cc_no')
                ->select('*')
                ->groupBy('je_cost_center')
                ->get();
        if($filtertemplate=="All"){
            $je_grouped= DB::table('journal_entries')
            ->join('cost_center', 'journal_entries.je_cost_center', '=', 'cost_center.cc_no')
            ->select('*')
            ->groupBy('je_cost_center')
            ->get();
        }
        $JournalEntry= DB::connection('mysql')->select("SELECT * FROM journal_entries
                            ".$sortjournal." 
                            ORDER BY je_no DESC");
        
        
        $columncount=5;
        $sheet = $doc->setActiveSheetIndex(0);
        if($CostCenterFilter=="By Cost Center"){

        }else{
            foreach($JournalEntry as $je){
                $sheet->setCellValue('B'.$columncount, date('d/m/Y',strtotime($je->je_attachment)));
                $sheet->setCellValue('C'.$columncount, date('F Y',strtotime($je->je_attachment)));
                if($je->journal_type=="Cheque Voucher"){
                    $sheet->setCellValue('D'.$columncount,$je->je_no);
                }else{
                    $sheet->setCellValue('E'.$columncount,$je->je_no);
                }
                $COA= ChartofAccount::find($je->je_account);
                $sheet->setCellValue('F'.$columncount,$COA->coa_code);
                $sheet->setCellValue('G'.$columncount,$COA->coa_name);
                $sheet->setCellValue('H'.$columncount,$COA->coa_title);
                if($je->je_debit!=""){
                    if($je->remark==""){   
                        $sheet->setCellValue('J'.$columncount,number_format($je->je_debit,2));
                    }else{
                       
                    }
                }
                if($je->je_credit!=""){
                    if($je->remark==""){   
                        $sheet->setCellValue('K'.$columncount,number_format($je->je_credit,2));
                    }else{
                       
                    }
                }
                if($je->je_cost_center!="null"){
                    $cost_center_list= CostCenter::find($je->je_cost_center);
                    $sheet->setCellValue('L'.$columncount,$cost_center_list->cc_name);
                }
                
                $sheet->setCellValue('M'.$columncount,$je->je_name);
                $sheet->setCellValue('N'.$columncount,$je->cheque_no);
                $sheet->setCellValue('O'.$columncount,$je->ref_no);
                if($je->date_deposited!=NULL){
                    $sheet->setCellValue('P'.$columncount,date('d/m/Y',strtotime($je->date_deposited)));
                }
                $sheet->setCellValue('Q'.$columncount,$je->je_memo);
                
    
                $style = array(
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    )
                );
                $sheet->getStyle('D'.$columncount.'')->applyFromArray($style);
                $sheet->getStyle('E'.$columncount.'')->applyFromArray($style);
                $sheet->getStyle('F'.$columncount.'')->applyFromArray($style);
    
                $style = array(
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    )
                );
                $sheet->getStyle('J'.$columncount.'')->applyFromArray($style);
                $sheet->getStyle('K'.$columncount.'')->applyFromArray($style);
                $columncount++;
            }
        }
        
        
        

        })->setFilename('Journal Entry Report '.date('m-d-Y'))->download('xlsx');
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
                $objValidation = $sheet1->getCell('D'.$cplus)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                
                $objValidation->setShowDropDown( true );
                $objValidation->setFormula1('ChartofAccounts!$A:$A');

                $objValidation = $sheet1->getCell('H'.$cplus)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                
                $objValidation->setShowDropDown( true );
                $objValidation->setFormula1('Names!$A:$A');

                $objValidation = $sheet1->getCell('B'.$cplus)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                
                $objValidation->setShowDropDown( true );
                $objValidation->setFormula1('CostCenter!$A:$A');

                $objValidation = $sheet1->getCell('K'.$cplus)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                
                $objValidation->setShowDropDown( true );
                $objValidation->setFormula1('ChartofAccounts!$I2:$I3');
                
                //$objValidation->setFormula1('Accounts'); //note this!
            }
            })->setFilename('Import Template for Journal Entry '.date('m-d-Y'))->download('xlsx');
    }
    public function GetCustomerTemplateExcel(Request $request){
        Excel::load('extra/edit_excel/Customer_Import Data.xlsx', function($doc) {
        
        })->setFilename('Import Template for Customer '.date('m-d-Y'))->download('xlsx');
    }
    public function GetChartofAccountsExcelemplate(Request $request){
        Excel::load('extra/edit_excel/coa.xlsx', function($doc) {
        
        })->setFilename('Import Template for Chart of Account '.date('m-d-Y'))->download('xlsx');
    }
    
    public function GetSupplierTemplateExcel(Request $request){
        Excel::load('extra/edit_excel/Supplier_Import Data.xlsx', function($doc) {
        
        })->setFilename('Import Template for Supplier '.date('m-d-Y'))->download('xlsx');
    }
    public function GetChartofCostCenterExcelemplate(Request $request){
        
        Excel::load('extra/edit_excel/Cost_Center_Import_Data.xlsx', function($doc) {
        
        
        })->setFilename('Import Template for Cost Center '.date('m-d-Y'))->download('xlsx');
    }
    public function export_ledger_to_excel(Request $request){
        Excel::load('extra/edit_excel/Export_Sub_Ledger.xlsx', function($doc) use($request) {
            $sheet = $doc->setActiveSheetIndex(0);    
            $customer_id=$request->customer;
            $coa_id=$request->coa_id;
            $date=$request->date;
            $no=$request->no;
            $Description=$request->Description;
            $Debit=$request->Debit;
            $Credit=$request->Credit;
            $TotalRow=$request->TotalRow;
            if($customer_id!=""){
                $customer= Customers::where('customer_id',$customer_id)->first();
                $sheet->setCellValue('A2', $customer->display_name!=""? $customer->display_name : ($customer->company_name!=""? $customer->company_name : $customer->f_name." ".$customer->l_name ));
            }else{
                $sheet->setCellValue('A2', "");
            }
            $COA= ChartofAccount::where('id',$coa_id)->first();
            $sheet->setCellValue('A4', $COA->coa_name);
            $countloop=0;
            $position=5;
            foreach($date as $da){
                $sheet->setCellValue('A'.$position, $da);
                $sheet->setCellValue('B'.$position, $no[$countloop]);
                $sheet->setCellValue('C'.$position, $Description[$countloop]);
                $sheet->setCellValue('D'.$position, $Debit[$countloop]);
                $sheet->setCellValue('E'.$position, $Credit[$countloop]);

                $style = array(
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    )
                );
                
                $sheet->getStyle('B'.$position)->applyFromArray($style);
                $style = array(
                    'alignment' => array(
                        'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                    )
                );
            
                $sheet->getStyle('D'.$position)->applyFromArray($style);
                $sheet->getStyle('E'.$position)->applyFromArray($style);
                $position++;
                $countloop++;
            }
            $sheet->setCellValue('A'.$position, $TotalRow[0]);
            $sheet->setCellValue('D'.$position, $TotalRow[1]);
            $sheet->setCellValue('E'.$position, $TotalRow[2]);
            $style = array(
                'alignment' => array(
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                )
            );
        
            $sheet->getStyle('D'.$position)->applyFromArray($style);
            $sheet->getStyle('E'.$position)->applyFromArray($style);
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $sheet->getStyle('A'.$position.':E'.$position.'')->applyFromArray($styleArray);
            $sheet->mergeCells('A'.$position.':C'.$position.'');
        })->setFilename('Export_Sub_Ledger')->store('xlsx', storage_path('app/exports'));
        return 'Export_Sub_Ledger';

    }
    public function getfile(Request $request){
        return Storage::download('exports/Export_Sub_Ledger.xlsx');
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
                    foreach($Budget as $bid){
                        $budget_is=$bid->budget_no;
                    }
                    

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
                                    if($row->cost_center_code!=""){
                                        $cc_code_check=CostCenter::where([
                                            ['cc_name_code','=',$row->cost_center_code]
                                        ])->get();
                                        if(count($cc_code_check)>0){
                                            $cc_id="";
                                            foreach($cc_code_check as $ccs){
                                                $cc_id=$ccs->cc_no;
                                            }
                                            $Chart= New ChartofAccount;
                                            $Chart->id= ChartofAccount::count() + 1;
                                            $cccdcd=ChartofAccount::count() + 1;
                                            $Chart->coa_account_type=$row->line_item;
                                            $Chart->coa_detail_type=$row->account_title;
                                            $Chart->coa_name=$row->account_title;
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
                                                $AuditLog= new AuditLog;
                                                $AuditLogcount=AuditLog::count()+1;
                                                $userid = Auth::user()->id;
                                                $username = Auth::user()->name;
                                                $eventlog="Added Account No. ".$cccdcd;
                                                $AuditLog->log_id=$AuditLogcount;
                                                $AuditLog->log_user_id=$username;
                                                $AuditLog->log_event=$eventlog;
                                                $AuditLog->log_name="";
                                                $AuditLog->log_transaction_date="";
                                                $AuditLog->log_amount="";
                                                $AuditLog->save();
                                                $saved_count++;
                                            }else{
                                                $error_count++;
                                                $Log.="Error Saving Data on row ".$rowcount." from file.\n";  
                                            }
                                        }else{
                                            //not existing Cost Center Code
                                            $error_count++;
                                            $Log.="Cost Center Code not Existing on row ".$rowcount." from file.\n";
                                        }
                                    }else{
                                        //empty Cost Center Code
                                        $error_count++;
                                        $Log.="Empty Cost Center Code on row ".$rowcount." from file.\n";
                                    }
                                    
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

                        $AuditLog= new AuditLog;
                            $AuditLogcount=AuditLog::count()+1;
                            $userid = Auth::user()->id;
                            $username = Auth::user()->name;
                            $eventlog="Added Customer";
                            $AuditLog->log_id=$AuditLogcount;
                            $AuditLog->log_user_id=$username;
                            $AuditLog->log_event=$eventlog;
                            $AuditLog->log_name="";
                            $AuditLog->log_transaction_date="";
                            $AuditLog->log_amount="";
                            $AuditLog->save();
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
                                if($row->cost_center!=""){
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
                                    $Log.="Empty Cost Center on row ".$rowcount." from file.\n"; 
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
                    $Valid_je_no = []; 
                    $valid_coa=0;
                    $valid_cc=0;
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
                            $COA= CostCenter::where('cc_name_code',$row->cost_center)->first();
                            if(empty($COA)){
                                $valid_cc=0; 
                                break;
                            }else{
                                $valid_cc=1;     
                            }
                            
                                

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
                                $CostCenter=$row->cost_center;
                                $COA= CostCenter::where('cc_name_code',$row->cost_center)->first();
        
                                $CostCenter=$COA->cc_no;
                                
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
                                $journal_entries->je_transaction_type=$type;
                                $journal_entries->je_cost_center=$CostCenter;
                                $journal_entries->date_deposited=$date_deposited;
                                        
                                $journal_entries->save();
                                $AuditLog= new AuditLog;
                                $AuditLogcount=AuditLog::count()+1;
                                $userid = Auth::user()->id;
                                $username = Auth::user()->name;
                                $eventlog="Imported Journal Entry No. ".$JNo;
                                $AuditLog->log_id=$AuditLogcount;
                                $AuditLog->log_user_id=$username;
                                $AuditLog->log_event=$eventlog;
                                $AuditLog->log_name="";
                                $AuditLog->log_transaction_date="";
                                $AuditLog->log_amount="";
                                $AuditLog->save();
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
                    $Log.="Debit and Credit not Equal in Journal No ".$unique.".\n"; 
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
        
        
        return redirect('/accounting')->with('success','Cost Center Deleted');
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
    public function update_bid_of_quotation(Request $request){
        $cost_center=$request->cost_center;
        $budget=$request->budget;
        $Budget= BudgetsEdit::where([
            ['budget_cost_center', '=', $cost_center],
            ['budget_type', '=', "Bid of Quotation"]
        ])->first();
        if(empty($Budget)){
            $Budget = new BudgetsEdit;
        }
        $Budget->budget_no=BudgetsEdit::count() + 1;
        $Budget->budget_cost_center=$cost_center;
        $Budget->budget_month=$budget;
        $Budget->budget_type="Bid of Quotation";
        $Budget->edit_status="0";
        if($Budget->save()){
            $CostCenter= CostCenter::where([
                ['cc_no', '=', $cost_center]
            ])->first();
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Edited Bid of Quotation of.".$CostCenter->cc_name."(".$CostCenter->cc_name_code.")";
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name="";
            $AuditLog->log_transaction_date="";
            $AuditLog->log_amount="";
            $AuditLog->save();
            // $Cost_Center=CostCenter::find($cost_center);
            // $Cost_Center->cc_use_quotation='Yes';
            // $Cost_Center->save();
        }
        //$costcenter->cc_use_quotation=$request->UseBidEdit;

    }
    public function delete_pending_bid_request(Request $request){
        $budget_edit_no=$request->id;
        $BudgetEdits= BudgetsEdit::where([
            ['budget_no', '=', $budget_edit_no]
        ])->first();
        $cost_center=$BudgetEdits->budget_cost_center;
        $BudgetEdits->edit_status="1";
        if($BudgetEdits->save()){
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $CostCenter= CostCenter::where([
                ['cc_no', '=', $cost_center]
            ])->first();
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Denied Pending Bid of Quotation Edit Request of.".$CostCenter->cc_name."(".$CostCenter->cc_name_code.")";
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name="";
            $AuditLog->log_transaction_date="";
            $AuditLog->log_amount="";
            $AuditLog->save();
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
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Approved Pending Bid of Quotation Edit Request of.".$CostCenter->cc_name."(".$CostCenter->cc_name_code.")";
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name="";
            $AuditLog->log_transaction_date="";
            $AuditLog->log_amount="";
            $AuditLog->save();
            
        } 
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
    
}
