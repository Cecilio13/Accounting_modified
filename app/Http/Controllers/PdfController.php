<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\SalesTransaction;
use App\StCreditNote;
use App\UserAccess;
use App\User;
use App\CostCenter;
use App\UserCostCenterAccess;
use App\Clients;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
class PdfController extends Controller
{
    public function __construct()
    {
        // $client=Clients::first();
        // $dbName='accounting_modified_'.$client->clnt_db_name;
            
        // DB::disconnect('mysql');//here connection name, I used mysql for example
        // Config::set('database.connections.mysql.database', $dbName);//new database name, you want to connect to.

    }
    public function generate()
    {

        $data = ['title' => 'CREDIT NOTE'];
        $sales_transaction = SalesTransaction::all();
        $credit_note = StCreditNote::all();

        $pdf = PDF::loadView('myPDF', compact('data', 'sales_transaction', 'credit_note'));
        
        return $pdf->stream('credit_notice.pdf');

    }
    public function approve_user(Request $request){
        $id=$request->id;
        $user_position=$request->position;
        $Approvals=0;
		$Journal_Entry=0;
		$Sales=0;
		$Invoice=0;
		$Estimate=0;
		$Credit_Note=0;
		$Sales_Receipt=0;
		$Expense=0;
		$Bill=0;
		$Supplier_Credit=0;
		$Pay_Bills=0;
		$Reports=0;
		$Fund_Feeds=0;
		$Chart_of_Accounts=0;
		$Cost_Center=0;
        $Settings=0;
        if($user_position=="Sales"){
            $Sales=1;
            $Invoice=1;
            $Estimate=1;
            $Credit_Note=1;
            $Sales_Receipt=1;
            $Reports=1;
        }
        if($user_position=="Expenses"){
            $Expense=1;
            $Bill=1;
            $Supplier_Credit=1;
            $Pay_Bills=1;
            $Reports=1;
        }
        if($user_position=="A\P Local"){
            $Expense=1;
            $Bill=1;
            $Supplier_Credit=1;
            $Reports=1;
        }
        if($user_position=="A\P Others"){
            $Expense=1;
            $Pay_Bills=1;
            $Reports=1;
        }
        if($user_position=="A\R Sales Invoice"){
            $Sales=1;
            $Invoice=1;
            $Estimate=1;
            $Credit_Note=1;
            
            $Reports=1;
        }
        if($user_position=="A\R Collection"){
            $Sales_Receipt=1;
            $Reports=1;
        }
        if($user_position=="Intermediate"){
            $Reports=1;
            $Fund_Feeds=1;
            $Chart_of_Accounts=1;
            $Cost_Center=1;
        }
        if($user_position=="Executive"){
            $Approvals=1;
            $Journal_Entry=1;
            $Sales=1;
            $Invoice=1;
            $Estimate=1;
            $Credit_Note=1;
            $Sales_Receipt=1;
            $Expense=1;
            $Bill=1;
            $Supplier_Credit=1;
            $Pay_Bills=1;
            $Reports=1;
            $Fund_Feeds=1;
            $Chart_of_Accounts=1;
            $Cost_Center=1;
            $Settings=1;
        }
        $UserAccess=new UserAccess;
        $UserAccess->user_id=$id;
        $UserAccess->approvals=$Approvals;
        $UserAccess->journal_entry=$Journal_Entry;
        $UserAccess->sales=$Sales;
        $UserAccess->invoice=$Invoice;
        $UserAccess->estimate=$Estimate;
        $UserAccess->credit_note=$Credit_Note;
        $UserAccess->sales_receipt=$Sales_Receipt;
        $UserAccess->expense=$Expense;
        $UserAccess->bill=$Bill;
        $UserAccess->supplier_credit=$Supplier_Credit;
        $UserAccess->pay_bills=$Pay_Bills;
        $UserAccess->reports=$Reports;
        $UserAccess->fund_feeds=$Fund_Feeds;
        $UserAccess->chart_of_accounts=$Chart_of_Accounts;
        $UserAccess->cost_center=$Cost_Center;
        $UserAccess->settings=$Settings;
        $UserAccess->save();

        User::where([
            ['id','=',$id]
        ])->update([
            'approved_status'=>'1'
        ]);


    }
    public function deny_user(Request $request){
        $id=$request->id;
        User::where([
            ['id','=',$id]
        ])->update([
            'approved_status'=>'2'
        ]);
    }
    public function get_cost_centers(Request $request){
        $id=$request->id;
        $CostCenter=CostCenter::where([
            ['cc_no','=',$id]
        ])->get();
        return $CostCenter;
    }
    public function update_user_access(Request $request){
        $userid_accounting=$request->userid_accounting;
		$access=$request->access;
        $ApprovalLevelProcurement=$request->ApprovalLevelProcurement;
        $Approvals=0;
		$Journal_Entry=0;
		$Sales=0;
		$Invoice=0;
		$Estimate=0;
		$Credit_Note=0;
		$Sales_Receipt=0;
		$Expense=0;
		$Bill=0;
		$Supplier_Credit=0;
		$Pay_Bills=0;
		$Reports=0;
		$Fund_Feeds=0;
		$Chart_of_Accounts=0;
		$Cost_Center=0;
		$Settings=0;
		$Procurement=0;
		$A_Pending_bill=0;
		$A_bank=0;
		$A_coa=0;
		$A_cc=0;
		$A_customer=0;
		$A_supplier=0;
		$A_product_services=0;
		$A_sales=0;
		$A_expense=0;
		$A_boq=0;
		$A_UAA=0;
        if($request->has('accesscostcenter')){
            $accesscostcenter=$request->accesscostcenter;
            UserCostCenterAccess::where([
                ['use_id','=',$userid_accounting]
            ])->delete();
            foreach($accesscostcenter as $acc){
                $CostCenter=new UserCostCenterAccess;
                $CostCenter->use_id=$userid_accounting;
                $CostCenter->cost_center_id=$acc;
                $CostCenter->access_status='1';
                $CostCenter->save();
            }
        }
        foreach($access as $re){
            if($re=="Approvals"){
                $Approvals=1;
            }
            if($re=="Procurement System"){
                $Procurement=1;
            }
            if($re=="Journal Entry"){
                $Journal_Entry=1;
            }
            if($re=="Sales"){
                $Sales=1;
            }
            if($re=="Invoice"){
                $Invoice=1;
            }
            if($re=="Estimate"){
                $Estimate=1;
            }
            if($re=="Credit Note"){
                $Credit_Note=1;
            }
            if($re=="Sales Receipt"){
                $Sales_Receipt=1;
            }
            if($re=="Expense"){
                $Expense=1;
            }
            if($re=="Bill"){
                $Bill=1;
            }
            if($re=="Supplier Credit"){
                $Supplier_Credit=1;
            }
            if($re=="Pay Bills"){
                $Pay_Bills=1;
            }
            if($re=="Reports"){
                $Reports=1;
            }
            if($re=="Fund Feeds"){
                $Fund_Feeds=1;
            }
            if($re=="Chart of Accounts"){
                $Chart_of_Accounts=1;
            }
            if($re=="Cost Center"){
                $Cost_Center=1;
            }
            if($re=="Settings"){
                $Settings=1;
            }
            if($re=="Pending Bills Approval"){
                $A_Pending_bill=1;
            }
            if($re=="Bank Approval"){
                $A_bank=1;
            }
            if($re=="Chart of Account Approval"){
                $A_coa=1;
            }
            if($re=="Cost Center Approval"){
                $A_cc=1;
            }
            if($re=="Customer Approval"){
                $A_customer=1;
            }
            if($re=="Supplier Approval"){
                $A_supplier=1;
            }
            if($re=="Product And Services Approval"){
                $A_product_services=1;
            }
            if($re=="Sales Transactions Approval"){
                $A_sales=1;
            }
            if($re=="Expense Transactions Approval"){
                $A_expense=1;
            }
            if($re=="Bid of Quotation Approval"){
                $A_boq=1;
            }
            if($re=="User Access Approval"){
                $A_UAA=1;
            }
        }
        $UserAccess=UserAccess::find($userid_accounting);
        if(empty($UserAccess)){
            $UserAccess=new UserAccess;
            $UserAccess->user_id=$userid_accounting;
        }
        $UserAccess->approvals=$Approvals;
        $UserAccess->journal_entry=$Journal_Entry;
        $UserAccess->sales=$Sales;
        $UserAccess->invoice=$Invoice;
        $UserAccess->estimate=$Estimate;
        $UserAccess->credit_note=$Credit_Note;
        $UserAccess->sales_receipt=$Sales_Receipt;
        $UserAccess->expense=$Expense;
        $UserAccess->bill=$Bill;
        $UserAccess->supplier_credit=$Supplier_Credit;
        $UserAccess->pay_bills=$Pay_Bills;
        $UserAccess->reports=$Reports;
        $UserAccess->fund_feeds=$Fund_Feeds;
        $UserAccess->chart_of_accounts=$Chart_of_Accounts;
        $UserAccess->cost_center=$Cost_Center;
        $UserAccess->settings=$Settings;
        $UserAccess->procurement_system=$Procurement;
        $UserAccess->procurement_sub=$ApprovalLevelProcurement;
        $UserAccess->approval_pending_bills=$A_Pending_bill;
        $UserAccess->approval_bank=$A_bank;
        $UserAccess->approval_coa=$A_coa;
        $UserAccess->approval_cc=$A_cc;
        $UserAccess->approval_customer=$A_customer;
        $UserAccess->approval_supplier=$A_supplier;
        $UserAccess->approval_product_services=$A_product_services;
        $UserAccess->approval_sales=$A_sales;
        $UserAccess->approval_expense=$A_expense;
        $UserAccess->approval_boq=$A_boq;
        $UserAccess->user_approval=$A_UAA;
        $UserAccess->save();
    } 
}
