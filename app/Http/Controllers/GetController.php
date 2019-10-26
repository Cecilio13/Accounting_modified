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
}
