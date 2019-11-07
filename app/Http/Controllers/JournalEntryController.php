<?php

namespace App\Http\Controllers;
use App\JournalEntry;
use App\AuditLog;
use App\Voucher;
use App\VoucherTransaction;
use App\VoucherJournalEntry;
use Auth;
use Illuminate\Http\Request;
use App\Clients;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\CostCenter;

class JournalEntryController extends Controller
{
    public function __construct()
    {
        // $client=Clients::first();
        // $dbName='accounting_modified_'.$client->clnt_db_name;
            
        // DB::disconnect('mysql');//here connection name, I used mysql for example
        // Config::set('database.connections.mysql.database', $dbName);//new database name, you want to connect to.

    }
    public function getJournalEntryInfo(Request $request){
        $journal_entries =JournalEntry::where([
            ['je_no','=',$request->je_no],
            
        ])->get();
        return $journal_entries;
    }
    public function add_voucher(Request $request){
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
        $VoucherCount=Voucher::all();
        foreach($VoucherCount as $vc){
            if($request->vouchertype==$vc->voucher_type){
                $VoucherCount2++;
            }
        }
        $Voucher = new  Voucher;
        $Voucher->voucher_id=$VoucherID;
        $Voucher->voucher_type=$request->vouchertype;
        $Voucher->pay_to_order_of=$request->PaytoOrderof;
        $Voucher->voucher_no=$VoucherCount2;
        $Voucher->voucher_date=$request->voucherdate;
        $Voucher->received_from=$request->ReceivedFrom;
        $Voucher->received_from_bank=$request->ReceivedFromBank;
        $Voucher->the_amount_of=$request->amountofBank;
        $Voucher->bank=$request->BankBank;
        $Voucher->check_no=$request->ChequeNoBank;
        $Voucher->received_payment_by=$request->PaymentByBank;
        $Voucher->prepared_by=$request->prepared_by;
        $Voucher->certified_correct_by=$request->certified_correct_by;
        $Voucher->approved_by=$request->approved_by;
        $Voucher->previous_voucher=$request->PreviousVoucher;
        
        if($Voucher->save()){
            //journal entry
            foreach($request->journalentrycolumns as $ss){
                $VoucherJournalEntryCount=VoucherJournalEntry::count() + 1;
                $VoucherJournalEntry = new  VoucherJournalEntry;        
                $VoucherJournalEntry->journal_no = $VoucherJournalEntryCount;        
                $VoucherJournalEntry->voucher_ref_no = $VoucherCount2;        
                $VoucherJournalEntry->account_title =$ss['title'] ;        
                $VoucherJournalEntry->debit = $ss['debit'] ;        
                $VoucherJournalEntry->credit = $ss['credit'] ;        
                $VoucherJournalEntry->save();
                        
            }
            //transactions
            foreach($request->transactioncolumns as $ss){
                $VoucherTransactionCount=VoucherTransaction::count() + 1;
                $VoucherTransaction = new  VoucherTransaction;  
                $VoucherTransaction->tran_no =$VoucherTransactionCount;
                $VoucherTransaction->voucher_ref_no = $VoucherCount2;
                $VoucherTransaction->tran_qty =$ss['qty'] ;
                $VoucherTransaction->tran_unit =$ss['unit'] ;
                $VoucherTransaction->tran_explanation =$ss['desc'] ;
                $VoucherTransaction->tran_amount =$ss['amount'] ;
                $VoucherTransaction->save();
            }
            return $VoucherCount2;
        }
       
       
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
        
        return "Success";
    }
    public function delete_overwrite_journal_entry(Request $request){
        $updateDetails=array(
            'remark' => 'NULLED'
        );
        JournalEntry::where(
            [
                ['je_no','=',$request->je_no]
            ]
        )->update($updateDetails);
    }
    public function add_journal_entry(Request $request)
    {
        
        $cheque_no=$request->input('cheque_no');
        $ref_no=$request->input('ref_no');
        $journal_entry_type=$request->input('journal_entry_type');

        $JDate=$request->input('JDate');
        $JNo=$request->input('JNo');
        $JMemo=$request->input('JMemo');
        $no= $request->input('no');
        $account= $request->input('account');
        $debit= $request->input('debit');
        $credit= $request->input('credit');
        $description=str_replace('<span style="background-color: rgba(0, 0, 0, 0.05);">',"",$request->input('description'));
        $description=str_replace('</span>',"",$description);
        $name= $request->input('name');
        $type=$request->input('JournalEntryTransactionType');
        $sentence=$JDate." ".$JNo." ".$JMemo;
        $CostCenter=$request->input('CostCenter');
        $date_deposited=$request->input('date_deposited');
        $journal_series_no=$request->input('journal_series_no');
        //return $no;
        if($no=="" || $account==""){
            return 2;

        }else{
            $journal_entries = new  JournalEntry;
            
            $journal_entries->je_id = $no;//duplicate if multiple entry *for fix*
            $journal_entries->je_no=$JNo;
            $journal_entries->je_account=$account;
            $journal_entries->je_debit=$debit;
            $journal_entries->je_credit=$credit;
            $journal_entries->je_desc=$description;
            $journal_entries->je_name=$name;
            $journal_entries->je_memo=$JMemo;
            $journal_entries->created_at=$JDate;
            $journal_entries->other_no=$request->OtherNo;
            $journal_entries->je_attachment=$JDate;
            $journal_entries->je_transaction_type=$type;
            $journal_entries->je_cost_center=$CostCenter;
            $journal_entries->cheque_no=$cheque_no;
            $journal_entries->ref_no=$ref_no;
            $journal_entries->journal_type=$journal_entry_type;
            $journal_entries->date_deposited=$date_deposited;
            $journal_entries->je_series_no=$journal_series_no;
            $journal_entries->save();
            
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Added Journal Entry No. ".$JNo;
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name="";
            $AuditLog->log_transaction_date="";
            $AuditLog->log_amount="";
            $AuditLog->save();
            return 1;

        }    

        
    }
    public function get_latest_journal_no(Request $request){
        $jounal = DB::table('journal_entries')
                ->select('je_no')
                ->groupBy('je_no')
                ->get();
        $jounalcount=count($jounal)+1;
        return $jounalcount;
    }
    public function update_journal_entry(Request $request){
        $JDate=$request->input('JDate');
        $JNo=$request->input('JNo');
        $JMemo=$request->input('JMemo');
        $no= $request->input('no');
        $account= $request->input('account');
        $debit= $request->input('debit');
        $credit= $request->input('credit');
        $description= $request->input('description');
        $name= $request->input('name');
        $type=$request->input('JournalEntryTransactionType');
        $sentence=$JDate." ".$JNo." ".$JMemo;
        $CostCenter=$request->input('CostCenter');
        if($no=="" || $account==""){
            return 2;

        }else{
            
            $journal_entries = new  JournalEntry;
            
            $journal_entries->je_id = $no;//duplicate if multiple entry *for fix*
            $journal_entries->je_no=$JNo;
            $journal_entries->je_account=$account;
            $journal_entries->je_debit=$debit;
            $journal_entries->je_credit=$credit;
            $journal_entries->je_desc=$description;
            $journal_entries->je_name=$name;
            $journal_entries->je_memo=$JMemo;
            $journal_entries->created_at=$JDate;
            $journal_entries->other_no=$request->OtherNo;
            $journal_entries->je_attachment=$JDate;
            $journal_entries->je_transaction_type=$type;
            $journal_entries->je_cost_center=$CostCenter;
            
            $journal_entries->save();
            $AuditLog= new AuditLog;
            $AuditLogcount=AuditLog::count()+1;
            $userid = Auth::user()->id;
            $username = Auth::user()->name;
            $eventlog="Updated Journal Entry No. ".$JNo;
            $AuditLog->log_id=$AuditLogcount;
            $AuditLog->log_user_id=$username;
            $AuditLog->log_event=$eventlog;
            $AuditLog->log_name="";
            $AuditLog->log_transaction_date="";
            $AuditLog->log_amount="";
            $AuditLog->save();
            return 1;

        }
    }
}
