<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesTransaction extends Model
{
    protected $primaryKey = 'st_no';
    protected $table = 'sales_transaction';
    protected $fillable = array(
        'st_no',
        'st_date',
        'st_type',
        'st_term',
        'st_customer_id',
        'st_due_date',
        'st_status',
        'st_action',
        'st_email',
        'st_send_later',
        'st_bill_address',
        'st_note',
        'st_memo',
        'st_balance',
        'st_amount_paid',
        'st_payment_for',
        'st_i_attachment'
    );

    public $timestamps = true;

    public function customer_info(){
	    return $this->hasOne('App\Customers','customer_id','st_customer_id');
    }

    public function invoice_info(){
	    return $this->hasMany('App\StInvoice','st_i_no','st_no');
    }

    public function estimate_info(){
	    return $this->hasMany('App\StEstimate','st_e_no','st_no');
    }

    public function sales_receipt_info(){
	    return $this->hasMany('App\StSalesReceipt','st_s_no','st_no');
    }

    public function refund_receipt_info(){
	    return $this->hasMany('App\StRefundReceipt','st_r_no','st_no');
    }

    public function delayed_charge_info(){
	    return $this->hasMany('App\StDelayedCharge','st_dc_no','st_no');
    }

    public function delayed_credit_info(){
	    return $this->hasMany('App\StDelayedCredit','st_dcredit_no','st_no');
    }

    public function credit_note_info(){
	    return $this->hasMany('App\StCreditNote','st_cn_no','st_no');
    }
    
}
