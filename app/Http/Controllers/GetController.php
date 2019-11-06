<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\User;
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
use App\CC_Type;
class GetController extends Controller
{
    public function get_customer_info(Request $request){
        $customers=Customers::find($request->id);
        return $customers;
    }
    public function get_product_info(Request $request){
        return ProductsAndServices::find($request->id);
    }
    public function check_cost_center_name(Request $request){
        $count=0;
        $count+=count(CostCenter::where([['cc_type','=',$request->name]])->get());
        $count+=count(CC_Type::where([['cc_type','=',$request->name]])->get());
        return $count;
    }
    public function check_cost_center_code(Request $request){
        $count=0;
        $count+=count(CostCenter::where([['cc_type_code','=',$request->name]])->get());
        $count+=count(CC_Type::where([['cc_code','=',$request->name]])->get());
        return $count;
    }
    public function save_cc_type(Request $request){
        $data=new CC_Type;
        $data->cc_type=$request->typename;
        $data->cc_code=$request->typecode;
        $data->save();
    }
    public function get_latest_journal_series(Request $request){
            $count=count(JournalEntry::where([
                ['journal_type','=',$request->journal_entry_type]
            ])->groupBy('je_no')->get())+1;

            $journalvoucher_no_series="";
            if($count<10){
                $journalvoucher_no_series="000".$count;
            }
            else if($count>9 && $count<100){
                $journalvoucher_no_series="00".$count;
            }else if($count>99 && $count<1000){
                $journalvoucher_no_series="0".$count;
            }
            $formated_journal_series="";
            if($request->journal_entry_type=="Cheque Voucher"){
                $formated_journal_series="CV".date('y').$journalvoucher_no_series;
            }else{
                $formated_journal_series="JV".date('y').$journalvoucher_no_series;
            }
            return $formated_journal_series;

    }
    public function get_journal_entry_data(Request $request){
        $va=$request->no;
        $result=DB::connection('mysql')->select("SELECT * FROM journal_entries 
        LEFT JOIN chart_of_accounts 
        ON journal_entries.je_account=chart_of_accounts.id 
        LEFT JOIN cost_center 
        ON journal_entries.je_cost_center=cost_center.cc_no 
        WHERE je_no='$va'");
        return $result;
        //SELECT *,FORMAT (`je_attachment`, 'yyyy-MM-dd') FROM `journal_entries` WHERE je_no='$request->no'
    }
    public function getcoa_cc_name(Request $request){
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
    public function export_dat_file(){
        $myfile = fopen("extra/export_report/dat_file.dat", "w") or die("Unable to open file!");
        $JournalEntry= DB::connection('mysql')->select("SELECT * FROM journal_entries 
                    JOIN chart_of_accounts ON chart_of_accounts.id=journal_entries.je_account
                    WHERE je_credit!='' ORDER BY journal_entries.created_at ASC");
        foreach($JournalEntry as $je){
            $txt = $je->coa_name." , ".number_format($je->je_credit,2)."\n";
            fwrite($myfile, $txt);
        }
        
        fclose($myfile);
        return response()->download('extra/export_report/dat_file.dat','report.dat');
    }
    public function create_database(Request $request){
        //$this->create_database();
        //create database
        //CREATE DATABASE database_name
        
        //show database table lists
        //show tables from accounting;

        //copy tables
        //CREATE TABLE new_database.new_table LIKE old_database.old_table
    }
    public function confirm_first_admin_account(Request $request){
        $None="55";
        $email=$request->email;
        $users=User::where([
            ['approved_status','=','1']
        ])->get();
        if(count($users)>0){
            $None="0";//will not activate anymore account
        }else{
            $users=User::where([
                ['email','=',$email]
            ])->first();
            
            if(!empty($users)){
                $id=$users->id;
                $data=User::find($id);
                $data->approved_status="1";
                if($data->save()){
                    $data=UserAccess::find($id);
                    if(empty($data)){
                        $data= new UserAccess;
                    }
                    $data->user_approval="1";
                    if($data->save()){
                        $None="1";//will activate the setted email
                    }

                }
            }else{
                $None="2";//account not found
            }
            
            
        }
        
        return view('account_confimation_page', compact('None'));
    }
}
