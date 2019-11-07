<?php

namespace App\Http\Controllers;
use App\Clients;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Formstyle;
use App\Customers;
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
use Auth;
use PDF;
use App\ChartofAccount;
use \setasign\Fpdi\Fpdi;
use App\Numbering;
use App\CostCenter;

class FormstyleController extends Controller
{
    public function __construct()
    {
        // $client=Clients::first();
        // $dbName='accounting_modified_'.$client->clnt_db_name;
            
        // DB::disconnect('mysql');//here connection name, I used mysql for example
        // Config::set('database.connections.mysql.database', $dbName);//new database name, you want to connect to.

    }
    public function add_form_style(Request $request)
    {
        $message="Successfully added new form style template";
        if($request->templatesettings['TemplateID']==""){
            $formstylecount = Formstyle::count()+1;
            $Formstyle = new  Formstyle;
            $Formstyle->cfs_id = $formstylecount;
            $message="Successfully added new form style template";
            $eventlog="Added Custom Form Style";
        }else{
            $Formstyle = Formstyle::find($request->templatesettings['TemplateID']);
            $message="Successfully updated form style template";
            $eventlog="Updated Custom Form Style";
        }
        $Formstyle->cfs_name = $request->templatesettings['TemplateTitleInput'];
        $Formstyle->cfs_design_template = $request->templatesettings['pickeddesign'];
        $Formstyle->cfs_logo_name = $request->templatesettings['logoname'];
        $Formstyle->cfs_logo_show = $request->templatesettings['logoshow'];
        $Formstyle->cfs_logo_size = $request->templatesettings['logo_size'];
        $Formstyle->cfs_logo_alignment = $request->templatesettings['logo_align'];
        $Formstyle->cfs_theme_color = $request->templatesettings['pickedcolor'];
        $Formstyle->cfs_font_family = $request->templatesettings['template_font_family'];
        $Formstyle->cfs_font_size = $request->templatesettings['template_font_size'];
        $Formstyle->cfs_margin = $request->templatesettings['template_margin'];

        $Formstyle->cfs_company_name_check = $request->templatesettings['companyname_show'];
        $Formstyle->cfs_company_name_value = $request->templatesettings['compantname'];
        $Formstyle->cfs_phone_check = $request->templatesettings['showphone'];
        $Formstyle->cfs_phone_value = $request->templatesettings['phonevalue'];
        $Formstyle->cfs_email_check = $request->templatesettings['showemail'];
        $Formstyle->cfs_email_value = $request->templatesettings['comemail'];
        $Formstyle->cfs_crn_check = $request->templatesettings['showrn'];
        $Formstyle->cfs_crn_value = $request->templatesettings['crnvalue'];
        $Formstyle->cfs_business_address_check = $request->templatesettings['showaddress'];
        $Formstyle->cfs_website_check = $request->templatesettings['showebsite'];
        $Formstyle->cfs_website_value = $request->templatesettings['webistecom'];
        $Formstyle->cfs_form_name_check = $request->templatesettings['showformname'];
        $Formstyle->cfs_form_name_value = $request->templatesettings['formtitletemp'];
        $Formstyle->cfs_form_number_check = $request->templatesettings['showformnumber'];
        $Formstyle->cfs_shipping_check = $request->templatesettings['showshipping'];
        $Formstyle->cfs_terms_check = $request->templatesettings['showterms'];
        $Formstyle->cfs_duedate_check = $request->templatesettings['showduedate'];

        $Formstyle->cfs_table_date_check = $request->templatesettings['showtabledate'];
        $Formstyle->cfs_table_product_check = $request->templatesettings['showtableprod'];
        $Formstyle->cfs_table_desc_check = $request->templatesettings['showtabledesc'];
        $Formstyle->cfs_table_qty_check = $request->templatesettings['showtableqty'];
        $Formstyle->cfs_table_rate_check = $request->templatesettings['showtablerate'];
        $Formstyle->cfs_table_amount_check = $request->templatesettings['showtableamount'];

        $Formstyle->cfs_footer_message_value = $request->templatesettings['footmessage'];
        $Formstyle->cfs_footer_message_font_size = $request->templatesettings['footmessagesize'];
        $Formstyle->cfs_footer_text_value = $request->templatesettings['footertext'];
        $Formstyle->cfs_footer_text_font_size = $request->templatesettings['footertextsize'];
        $Formstyle->cfs_footer_text_position = $request->templatesettings['footertextalign'];

        $Formstyle->cfs_email_subject = $request->templatesettings['emailsubject'];
        $Formstyle->cfs_email_use_greeting = $request->templatesettings['emailusegreeting'];
        $Formstyle->cfs_email_greeting_pronoun = $request->templatesettings['emailgreetingpronoun'];
        $Formstyle->cfs_email_greeting_word = $request->templatesettings['emailgreetingword'];
        $Formstyle->cfs_email_message = $request->templatesettings['emailmessagecustomer'];
        
        $Formstyle->cfs_status="1";
        if($Formstyle->save()){
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name="";
            $AuditLog->log_transaction_date="";
            $AuditLog->log_amount="";
            $AuditLog->save();
            return $message;
        }else{
            return "Error! please try again later";
        }
    }

    public function editformstyle(Request $request){
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
        $Formstyle= Formstyle::find($request->customformid);
        //echo $Formstyle->cfs_id;
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
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        $st_invoice = DB::table('st_invoice')->get();
        return view('pages.editformstyle', compact('numbering','st_invoice','cost_center_list','ETran','SS','COA','expense_transactions','totalexp','et_acc','et_it','VoucherCount','Formstyle','settings_company','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction'));
    }
    public function deleteformstyle(Request $request){
        $Formstyle = Formstyle::find($request->customformid);
        $Formstyle->cfs_status="0";
        $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Deleted Custom Form Style";
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name="";
            $AuditLog->log_transaction_date="";
            $AuditLog->log_amount="";
            $AuditLog->save();
        $Formstyle->save();
        return redirect('/customformstyles');
    }
    public function previewformstyle(Request $request){
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
        $sal= SalesTransaction::find($request->receipt);
        $salST= StSalesReceipt::all();
        $receiptNo=$request->receipt;
        $Formstyle= Formstyle::find($request->form);
        //return $request->form;
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
        $SS=SalesTransaction::all();$ETran = DB::table('expense_transactions')->get();
        $numbering = Numbering::first();
        $cost_center_list= CostCenter::where('cc_status','1')->orderBy('cc_type_code', 'asc')->get();
        $st_invoice = DB::table('st_invoice')->get();
        //$pdf = PDF::loadView('app.formstylepdf', compact('sal','VoucherCount','Formstyle','settings_company','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction'));
        return view('app.formstylepdf', compact('numbering','st_invoice','cost_center_list','ETran','SS','receiptNo','salST','sal','VoucherCount','Formstyle','settings_company','jounalcount','JournalEntry','customers', 'products_and_services', 'sales_transaction'));
        //$pdf->getDomPDF()->get_option('enable_html5_parser');
        //return $pdf->download('invoice.pdf');
    }
    public function generate_pdf_bir(Request $request){
    include "../vendor/autoload.php";
    require_once('../vendor/setasign/fpdf/fpdf.php');
    require_once('../vendor/setasign/fpdi/src/autoload.php');
    $id=$request->id;
    $customers = Customers::find($id);

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
    $pdf->Cell(30, 10, "      ", 0, 0, 'L');
    // second 3
    $pdf->SetXY(56,45);
    $pdf->Cell(30, 10, "      ", 0, 0, 'L');
    // third 3
    $pdf->SetXY(74,45);
    $pdf->Cell(30, 10, "      ", 0, 0, 'L');
    // forth 3
    $pdf->SetXY(92,45);
    $pdf->Cell(30, 10, "0 0 0", 0, 0, 'L');

    //***Registered Name***
    $pdf->SetFontSize('12');
    $settings_company = DB::table('settings_company')->first();
    $pdf->SetXY(39,52);
    $pdf->Cell(30, 10, $settings_company->company_legal_name, 0, 0, 'L');
    //***Registered Address***
    $pdf->SetFontSize('10');

    $pdf->SetXY(39,61);
    $pdf->Cell(30, 10, $settings_company->company_address, 0, 0, 'L');

    $pdf->SetFontSize('17');

    $pdf->SetXY(187,61);
    $pdf->Cell(30, 10, implode(' ',str_split($settings_company->company_address_postal)), 0, 0, 'L');

    //***Foreign Address***
    $pdf->SetFontSize('10');

    $pdf->SetXY(39,67);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetFontSize('17');

    $pdf->SetXY(187,67);
    $pdf->Cell(30, 10,"", 0, 0, 'L');

    //***TIN Payor***
    $pdf->SetFontSize('14');
    // first 3
    $tin=$customers->tin_no;
    $lengthtin=strlen($tin);
    if($lengthtin<9){
        for($c=$lengthtin;$c<=9;$c++){
            $tin.=" ";  
        }
    }
    $output = str_split($tin, 3);
    $pdf->SetXY(39,78);
    $pdf->Cell(30, 10,implode(' ',str_split($output[0])), 0, 0, 'L');
    // second 3
    $pdf->SetXY(56,78);
    $pdf->Cell(30, 10,implode(' ',str_split($output[1])), 0, 0, 'L');
    // third 3
    $pdf->SetXY(74,78);
    $pdf->Cell(30, 10,implode(' ',str_split($output[2])), 0, 0, 'L');
    // forth 3
    $pdf->SetXY(92,78);
    $pdf->Cell(30, 10, "0 0 0", 0, 0, 'L');

    //***Registered Name Payor***
    $pdf->SetFontSize('12');
    
    $name=$customers->f_name." ".$customers->l_name;
    
    $pdf->SetXY(39,85);
    $pdf->Cell(30, 10, $name, 0, 0, 'L');
    //***Registered Address Payor***
    $pdf->SetFontSize('10');
    $address=$customers->street." ".$customers->city." ".$customers->state;
    $pdf->SetXY(39,94);
    $pdf->Cell(30, 10, $address, 0, 0, 'L');

    $pdf->SetFontSize('17');

    $pdf->SetXY(187,94);
    $pdf->Cell(30, 10,implode(' ',str_split($customers->postal_code)), 0, 0, 'L');
    //***Part II***
    $expense_transactions = DB::table('expense_transactions')
            ->join('et_account_details', 'expense_transactions.et_no', '=', 'et_account_details.et_ad_no')
            ->join('customers', 'customers.customer_id', '=', 'expense_transactions.et_customer')
            ->get();
    $et_acc = DB::table('et_account_details')->get();
    $TotalAll=0;
    $quarter1_total_1=0;
    $quarter2_total_2=0;
    $quarter3_total_3=0;
    $count_ex=0;
    $ex_total_1=0;
    $ex_total_2=0;
    $ex_total_3=0;
    $log="";
    
    foreach($expense_transactions as $acc){
        if($acc->et_customer==$id){
            $ex_id=$acc->et_no;
            foreach($et_acc as $s){
                if($s->et_ad_no==$ex_id){
                    if($acc->et_type=="Expense"){
                        $count_ex++;
                        $start_date = date('Y-01-01');
                        $end_date = date('Y-04-30');
                        $date_from_user =$acc->et_date;
                        // Convert to timestamp
                        $start_ts = strtotime($start_date);
                        $end_ts = strtotime($end_date);
                        $user_ts = strtotime($date_from_user);

                        // Check that user date is between start & end
                        if((($user_ts >= $start_ts) && ($user_ts <= $end_ts))=="1"){
                        $ex_total_1=$ex_total_1+$s->et_ad_total;
                        $quarter1_total_1+=$s->et_ad_total;
                        
                        }
                        $start_date = date('Y-05-01');
                        $end_date = date('Y-08-31');
                        $date_from_user =$acc->et_date;
                        // Convert to timestamp
                        $start_ts = strtotime($start_date);
                        $end_ts = strtotime($end_date);
                        $user_ts = strtotime($date_from_user);

                        // Check that user date is between start & end
                        if((($user_ts >= $start_ts) && ($user_ts <= $end_ts))=="1"){
                        $ex_total_2=$ex_total_2+$s->et_ad_total;
                        $quarter2_total_2+=$s->et_ad_total;
                        }
                        $start_date = date('Y-09-01');
                        $end_date = date('Y-12-31');
                        $date_from_user =$acc->et_date;
                        // Convert to timestamp
                        $start_ts = strtotime($start_date);
                        $end_ts = strtotime($end_date);
                        $user_ts = strtotime($date_from_user);

                        // Check that user date is between start & end
                        if((($user_ts >= $start_ts) && ($user_ts <= $end_ts))=="1"){
                        $ex_total_2=$ex_total_2+$s->et_ad_total;
                        $quarter3_total_3+=$s->et_ad_total;
                        }
                    }
                    
                }
            }
        }
    }
    $totaltotal=$ex_total_1+$ex_total_2+$ex_total_3;
    
    $ATC="";
    $ATCCOde="";
    $ATCpercentage="";
    if($totaltotal<3000000){
        $ATC="Gross Commisions";
        $ATCCOde="WC139";
        $ATCpercentage=0.10;
    }else{
        $ATC="Gross Commisions";
        $ATCCOde="WC140";
        $ATCpercentage=0.15;
    }
    $sales_transaction = SalesTransaction::all();
    $StInvoice= StInvoice::all();
    $count_st=0;
    $st_total_1=0;
    $st_total_2=0;
    $st_total_3=0;
    $quarter_total_1=0;
    $quarter_total_2=0;
    $quarter_total_3=0;
    $TotalAllInvoice=0;
    foreach($sales_transaction as $st){
        if($st->st_customer_id==$id){
            $st_id=$st->st_no;
            foreach($StInvoice as $sti){
                if($sti->st_i_no==$st_id){
                    if($st->st_type=="Invoice"){
                        $count_st++;
                        $start_date = date('Y-01-01');
                        $end_date = date('Y-04-30');
                        $date_from_user =$acc->et_date;
                        // Convert to timestamp
                        $start_ts = strtotime($start_date);
                        $end_ts = strtotime($end_date);
                        $user_ts = strtotime($date_from_user);
                        if((($user_ts >= $start_ts) && ($user_ts <= $end_ts))=="1"){
                        $st_total_1=$st_total_1+$sti->st_i_total;
                        $quarter_total_1+=$sti->st_i_total;
                        }
                        $start_date = date('Y-05-01');
                        $end_date = date('Y-08-31');
                        $date_from_user =$acc->et_date;
                        // Convert to timestamp
                        $start_ts = strtotime($start_date);
                        $end_ts = strtotime($end_date);
                        $user_ts = strtotime($date_from_user);
                        if((($user_ts >= $start_ts) && ($user_ts <= $end_ts))=="1"){
                        $st_total_2=$st_total_2+$sti->st_i_total;
                        $quarter_total_2+=$sti->st_i_total;
                        }
                        $start_date = date('Y-09-01');
                        $end_date = date('Y-12-31');
                        $date_from_user =$acc->et_date;
                        // Convert to timestamp
                        $start_ts = strtotime($start_date);
                        $end_ts = strtotime($end_date);
                        $user_ts = strtotime($date_from_user);
                        if((($user_ts >= $start_ts) && ($user_ts <= $end_ts))=="1"){
                        $st_total_3=$st_total_3+$sti->st_i_total;
                        $quarter_total_3+=$sti->st_i_total;
                        }
                    }
                }
            }
        }
    }
    $pdf->SetFontSize('8');
    $Y=117.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10,"Income Payments to certain contractors", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "WI120", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, number_format($st_total_1,2), 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10,number_format($st_total_2,2), 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, number_format($st_total_3,2), 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, number_format($st_total_1+$st_total_2+$st_total_3,2), 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, number_format(($st_total_1+$st_total_2+$st_total_3)*0.02,2), 0, 0, 'L');
    $TotalAllInvoice+=($st_total_1+$st_total_2+$st_total_3)*0.02;
    $Y=122;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=126.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=130.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=135;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=139.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=144;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=148.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=152.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=157;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=161;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=165;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=169;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=173.5;
    // $pdf->SetXY(6.5,$Y);
    // $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10,number_format($quarter_total_1,2), 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10,number_format($quarter_total_2,2), 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10,number_format($quarter_total_3,2), 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, number_format($quarter_total_1+$quarter_total_2+$quarter_total_3,2), 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10,number_format($TotalAllInvoice,2), 0, 0, 'L');
    //Part II.5
    $Y=186;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, $ATC, 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, $ATCCOde, 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, number_format($ex_total_1,2), 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10,number_format($ex_total_2,2), 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10,number_format($ex_total_3,2), 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10,  number_format($totaltotal,2), 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, number_format($totaltotal*$ATCpercentage,2), 0, 0, 'L');
    $TotalAll+=$totaltotal*$ATCpercentage;
    $Y=190;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=194;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=198;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=202.5;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=206;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=210;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=214;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=218;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=222;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=226;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=230;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=234;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=238;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=242;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=246;
    $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=250;
    /* $pdf->SetXY(6.5,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L'); */
    $pdf->SetXY(61,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(75,$Y);
    $pdf->Cell(30, 10,number_format($quarter1_total_1,2), 0, 0, 'L');
    $pdf->SetXY(99.5,$Y);
    $pdf->Cell(30, 10, number_format($quarter2_total_2,2), 0, 0, 'L');
    $pdf->SetXY(123.5,$Y);
    $pdf->Cell(30, 10,number_format($quarter3_total_3,2), 0, 0, 'L');
    $pdf->SetXY(147.5,$Y);
    $pdf->Cell(30, 10, number_format($quarter1_total_1+$quarter2_total_2+$quarter3_total_3,2), 0, 0, 'L');
    $pdf->SetXY(172,$Y);
    $pdf->Cell(30, 10, number_format($TotalAll,2), 0, 0, 'L');

    //***Part III***
    // 
    $pdf->SetFontSize('8');
    $Y=271;
    $pdf->SetXY(10,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $pdf->SetXY(114,$Y);
    $pdf->Cell(30, 10,  date('m-d-Y'), 0, 0, 'L');
    $pdf->SetXY(171,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');
    $Y=283;
    $pdf->SetXY(10,$Y);
    $pdf->Cell(80, 10,$settings_company->company_legal_name, 0, 0, 'C');
    $Y=292.5;
    $pdf->SetXY(10,$Y);
    $pdf->Cell(30, 10,"" , 0, 0, 'L');
    $pdf->SetXY(114,$Y);
    $pdf->Cell(30, 10,date('m-d-Y'), 0, 0, 'L');
    $pdf->SetXY(171,$Y);
    $pdf->Cell(30, 10, "", 0, 0, 'L');



    //**SECOND PAGE**
    $tpl = $pdf->importPage(2);
    $size = $pdf->getTemplateSize($tpl);
    $pdf->AddPage('P', array($size['0'], $size['1']));

    // Use the imported page as the template
    $pdf->useTemplate($tpl);

    // render PDF to browser
    $pdf->Output();
    }
}
