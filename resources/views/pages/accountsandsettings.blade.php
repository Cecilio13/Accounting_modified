@extends('layout.initial')


@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>System Settings</h1>
            </div>
        </div>
    </div>
    <!-- <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Table</a></li>
                    <li class="active">Basic table</li>
                </ol>
            </div>
        </div>
        </div> -->
</div>
<div class="card-body">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Company</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Sales</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="extra-tab" data-toggle="tab" href="#extra" role="tab" aria-controls="extra" aria-selected="false">Expenses</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="advance-tab" data-toggle="tab" href="#advance" role="tab" aria-controls="advance" aria-selected="false">Advance</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="advance-tab" data-toggle="tab" href="#bank" role="tab" aria-controls="advance" aria-selected="false">Bank</a>
        </li>
    </ul>
    <div class="tab-content pl-3 p-1" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <form action="{{ route('update_company') }}" class="form-horizontal " id="company_form" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Company Name</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Company Name</p>
                    <p class="text-dark">Legal Name</p>
                    <p class="text-dark">Business ID No.</p>
                    <p class="text-dark">TIN No.</p>
                    <p class="text-dark">E Signatory</p>
                </div>
                <div class="col-md-4">
                    @if(!empty($company))
                    <input class="text-dark input-custom" id="company_name" name="company_name" type="text" value="{{$company->company_name}}" >
                    <input class="text-dark input-custom" id="legal_name" name="legal_name" type="text" value="{{$company->company_legal_name}}" >
                    <input class="text-dark input-custom" id="business_id_no" name="business_id_no" type="text" value="{{$company->company_business_id_no}}" >
                    <input class="text-dark input-custom" id="com_tin_no" name="com_tin_no" type="text" value="{{$company->company_tin_no}}" maxlength="9" >
                    <input class="text-dark input-custom" id="esignatory" name="esignatory" type="file" >
                    @else
                    <input class="text-dark input-custom" id="company_name" name="company_name" type="text" value="" >
                    <input class="text-dark input-custom" id="legal_name" name="legal_name" type="text" value="" >
                    <input class="text-dark input-custom" id="business_id_no" name="business_id_no" type="text" value="" >
                    <input class="text-dark input-custom" id="com_tin_no" name="com_tin_no" type="text" value="" maxlength="9">
                    <input class="text-dark input-custom" id="esignatory" name="esignatory" type="file">
                    @endif
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_company_name" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light"></div>
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Company Type</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Tax Form</p>
                    <p class="text-dark">Industry</p>
                </div>
                <div class="col-md-4">
                    @if(!empty($company))
                    <input list="tax_forms_list" class="text-dark input-custom" id="tax_form" name="tax_form" type="text" value="{{$company->company_tax_form}}" >
                    @else
                    <input list="tax_forms_list" class="text-dark input-custom" id="tax_form" name="tax_form" type="text" value="" >
                    @endif
                    <datalist id="tax_forms_list">
                        <option>Sole proprietor (Form 1040)</option>
                        <option>Partnership or limited liability company (Form 1065)</option>
                        <option>Small business corporation, two or more owners (Form 11205)</option>
                        <option>Corporation, one or more shareholders (Form 1120)</option>
                        <option>Nonprofit organization (Form 990)</option>
                        <option>Limited liability</option>
                        <option>Not sure/Other/None</option>
                    </datalist> 
                    @if(!empty($company))
                    <input class="text-dark input-custom" id="industry" name="industry" type="text" value="{{$company->company_industry}}" >
                    @else
                    <input class="text-dark input-custom" id="industry" name="industry" type="text" value="" >
                    @endif
                    
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_company_type" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light"></div>
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Contact Info</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Company Email</p>
                    <p class="text-dark" style="display:none;">Customer-facing Email</p>
                    <p class="text-dark">Company Phone</p>
                    <p class="text-dark">Website</p>
                </div>
                <div class="col-md-4">
                    @if(!empty($company))
                    <input class="text-dark input-custom" id="company_email" name="company_email" type="email" value="{{$company->company_email}}" >
                    <input class="text-dark input-custom" style="display:none;" id="customer_facing_email" name="customer_facing_email" type="hidden" value="{{$company->company_customer_facing_email}}" >
                    <input class="text-dark input-custom" id="company_phone" name="company_phone" type="tel" value="{{$company->company_phone}}" >
                    <input class="text-dark input-custom" id="website" name="website" type="url" value="{{$company->company_website}}" >
                    @else
                    <input class="text-dark input-custom" id="company_email" name="company_email" type="email" value="" >
                    <input class="text-dark input-custom" style="display:none;" id="customer_facing_email" name="customer_facing_email" type="hidden" value="" >
                    <input class="text-dark input-custom" id="company_phone" name="company_phone" type="tel" value="" >
                    <input class="text-dark input-custom" id="website" name="website" type="url" value="" >
                    
                    @endif
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_contact_info" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light"></div>
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Address</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Company Address</p>
                    <p class="text-dark" style="display:none;">Customer-facing Address</p>
                    <p class="text-dark">Legal Address</p>
                </div>
                <div class="col-md-4">
                    <style>
                        p {
                            margin-bottom:20px;
                        }
                    .half{
                        width:45% !important;
                        display: inline !important;
                        margin-left:10px;
                    }
                    </style>
                    @if(!empty($company))
                    <input class="text-dark input-custom half" placeholder="Address" id="company_address" name="company_address" type="text" value="{{$company->company_address}}" >
                    <input placeholder="Postal Code" id="postal1" name="postal1" class="text-dark input-custom half" type="text" value="{{$company->company_address_postal}}">  
                    <input class="text-dark input-custom half" style="display:none;" id="customer_facing_address" name="customer_facing_address" type="hidden" value="{{$company->company_customer_facing_address}}" ><input style="display:none;" name="postal2" id="postal2" class="text-dark input-custom half" type="hidden" value="{{$company->facing_postal}}"> 
                    <input class="text-dark input-custom half" placeholder="Address" id="legal_address" name="legal_address" type="text" value="{{$company->company_legal_address}}" >
                    <input placeholder="Postal" id="postal3" class="text-dark input-custom half" name="postal3" type="text" value="{{$company->legal_postal}}"> 
                    @else
                    <input class="text-dark input-custom half" placeholder="Address" id="company_address" name="company_address" type="text" value="" ><input placeholder="Postal" id="postal1" class="text-dark input-custom half" type="text" value="">  
                    <input class="text-dark input-custom half" style="display:none;" id="customer_facing_address" name="customer_facing_address" type="hidden" value="" ><input style="display:none;" id="postal2" class="text-dark input-custom half" type="hidden" value="">  
                    <input class="text-dark input-custom half" placeholder="Address" id="legal_address" name="legal_address" type="text" value="" ><input id="postal3" placeholder="Postal Code" class="text-dark input-custom half" type="text" value="">  
                    
                    @endif
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_address" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light"></div>
            <div class="col-md-12 mt-3" style="display:none;">
                <div class="col-md-3">
                    <p class="text-dark">Communications with Intuit</p>
                </div>
                <div class="col-md-4">
                    <p class="text-info"><a href="https://c17.qbo.intuit.com/qbo17/redir/privacy" class="text-info">View Privacy Statement</a></p>
                </div>
            </div>
            <div class="float-right mb-5">
                <button type="submit" id="update_company" class="btn btn-success rounded">Save</button>
            </div>
        </form>
        </div>
        <!-- =========================================================================================== SECOND TAB--> 
       
        <!-- ==============================================================================================THIRD TAB -->
        <div class="tab-pane fade show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <form action="#" class="form-horizontal " id="sales_form">
        {{ csrf_field() }}
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Customise</p>
                </div>
                <div class="col-md-5">
                    <p class="text-dark">Customise the way forms look to your customers</p>
                </div>
                <div class="col-md-4">
                <a href="customformstyles" class="btn btn-success px-3 font-weight-bold rounded">Customise look and feel</a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light"></div>
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Sales Receipt</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Preferred Debit Cheque Account</p>
                    
                </div>
                <div class="col-md-4 font-weight-bold">
                    <select class="text-dark font-weight-bold select-custom selectpicker w-100" data-live-search="true" id="preferred_bedit_cheque_account" name="preferred_bedit_cheque_account" >
                        @if (!empty($sales))
                            @foreach ($COA as $coa)
                                
                                    @if ($coa->id==$sales->sales_sales_receipt_preferred_debit_cheque_account)
                                    <option value="{{$coa->id}}" selected>{{$coa->coa_name}}</option>    
                                    @else
                                    <option value="{{$coa->id}}">{{$coa->coa_name}}</option>  
                                    @endif
                            @endforeach
                        @else
                        
                        @foreach ($COA as $coa)
                        @if ($coa->id=='1')
                        <option value="{{$coa->id}}" selected>{{$coa->coa_name}}</option>  
                        @else
                        <option value="{{$coa->id}}">{{$coa->coa_name}}</option>
                        @endif
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_sales_receiptsetting" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3" style="display:none;">
                <div class="col-md-3">
                    <p class="text-dark">Sales form content</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Preferred invoice terms</p>
                    <p class="text-dark">Preferred delivery method</p>
                    <p class="text-dark">Shipping</p>
                    <p class="text-dark">Custom fields</p>
                    <p class="text-dark">Custom transaction numbers</p>
                    <p class="text-dark">Service Date</p>
                    <p class="text-dark">Discount</p>
                    <p class="text-dark">Deposit</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    
                    @if(!empty($sales))
                    <input class="text-dark font-weight-bold input-custom" list="invoice" id="preferred_invoice_term" name="preferred_invoice_term" type="text" value="{{$sales->sales_preferred_invoice_term}}" >
                    @else
                    <input class="text-dark font-weight-bold input-custom" list="invoice" id="preferred_invoice_term" name="preferred_invoice_term" type="text" value="" >
                    @endif
                    
                    <datalist id="invoice">
                        <option>Due on receipt</option>
                        <option>Net 15</option>
                        <option>Net 30</option>
                        <option>Net 60</option>
                    </datalist>
                    
                    @if(!empty($sales))
                    <input style="margin-top:10px;" class="text-dark font-weight-bold input-custom" list ="delivery" id="preferred_delivery_method" name="preferred_delivery_method" type="text" value="{{$sales->sales_preferred_delivery_method}}" >
                    @else
                    <input style="margin-top:10px;" class="text-dark font-weight-bold input-custom" list ="delivery" id="preferred_delivery_method" name="preferred_delivery_method" type="text" value="" >
                    @endif
                    <datalist id="delivery">
                        <option>Print later</option>
                        <option>Send later</option>
                        <option>None</option>
                    </datalist>
                    
                    <select  class="text-dark font-weight-bold select-custom" id="shipping" name="shipping" >
                        <option value="On" {{!empty($sales) && $sales->sales_shipping == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($sales) && $sales->sales_shipping == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                   
                    <select  class="text-dark font-weight-bold select-custom" id="custom_field" name="custom_field" >
                        <option value="On" {{!empty($sales) && $sales->sales_custom_field == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($sales) && $sales->sales_custom_field == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    
                    <select class="text-dark font-weight-bold select-custom" id="custom_transaction_number" name="custom_transaction_number" >
                        <option value="On" {{!empty($sales) && $sales->sales_custom_transaction_number == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($sales) && $sales->sales_custom_transaction_number == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    
                    <select  class="text-dark font-weight-bold select-custom" id="service_date" name="service_date" >
                        <option value="On" {{!empty($sales) && $sales->sales_service_date == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($sales) && $sales->sales_service_date == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    
                    <select class="text-dark font-weight-bold select-custom" id="discount" name="discount" >
                        <option value="On" {{!empty($sales) && $sales->sales_discount == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($sales) && $sales->sales_discount == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                   
                    <select  class="text-dark font-weight-bold select-custom" id="deposit" name="deposit" >
                        <option value="On" {{!empty($sales) && $sales->sales_deposit == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($sales) && $sales->sales_deposit == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_sales_form" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light"></div>
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Product and Services</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Show Product/Service tab on sales</p>
                    <p class="text-dark ml-3">Show SKU column</p>
                    <p class="text-dark">Track price/rate</p>
                    <p class="text-dark">Track inventory quantity on hand</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    <select class="text-dark font-weight-bold select-custom" id="show_product_column" name="show_product_column" >
                        <option value="On" {{!empty($sales) && $sales->sales_show_product_column == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($sales) && $sales->sales_show_product_column == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    <select  class="text-dark font-weight-bold select-custom" id="show_sku_column" name="show_sku_column" >
                        <option value="On" {{!empty($sales) && $sales->sales_show_sku_column == "On" ? 'selected' : ''}}>On</option>
                        
                    </select>
                    
                    <select  class="text-dark font-weight-bold select-custom" id="track_quantity_and_price" name="track_quantity_and_price" >
                        <option value="On" {{!empty($sales) && $sales->sales_track_quantity_and_price == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($sales) && $sales->sales_track_quantity_and_price == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    <select  class="text-dark font-weight-bold select-custom" id="track_quantity_on_hand" name="track_quantity_on_hand" >
                        <option value="On" {{!empty($sales) && $sales->sales_track_quantity_on_hand == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($sales) && $sales->sales_track_quantity_on_hand == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_products_and_services" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light" style="display:none;"></div>
            <div class="col-md-12 mt-3" style="display:none;">
                <div class="col-md-3">
                    <p class="text-dark">Messages</p>
                </div>
                <div class="col-md-4">
                    @if(!empty($sales))
                    <input class="text-dark input-custom" id="form_email_message" name="form_email_message" type="text" value="{{$sales->sales_form_email_message}}" >
                    @else
                    <input class="text-dark input-custom" id="form_email_message" name="form_email_message" type="text" value="" >
                    @endif
                </div>
                <div class="col-md-4 font-weight-bold">
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_sales_messages" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light" style="display:none;"></div>
            <div class="col-md-12 mt-3" style="display:none;">
                <div class="col-md-3">
                    <p class="text-dark">Reminders</p>
                </div>
                <div class="col-md-4">
                    @if(!empty($sales))
                    <input class="text-dark input-custom" id="default_reminder_message" name="default_reminder_message" type="text" value="{{$sales->sales_default_reminder_message}}" >
                    @else
                    <input class="text-dark input-custom" id="default_reminder_message" name="default_reminder_message" type="text" value="" >
                    @endif
                </div>
                <div class="col-md-4 font-weight-bold">
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_reminders" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light"></div>
            <div class="col-md-12 mt-3" style="display:none;">
                <div class="col-md-3">
                    <p class="text-dark">Online Delivery</p>
                </div>
                <div class="col-md-4">
                    @if(!empty($sales))
                    <input class="text-dark input-custom" id="email_option" name="email_option" type="text" value="{{$sales->sales_email_option}}" >
                    @else
                    <input class="text-dark input-custom" id="email_option" name="email_option" type="text" value="" >
                    @endif
                </div>
                <div class="col-md-4 font-weight-bold">
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_online_delivery" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light" style="display:none;"></div>
            <div class="col-md-12 mt-3" style="display:none;">
                <div class="col-md-3">
                    <p class="text-dark">Statements</p>
                </div>
                <div class="col-md-4">
                <p class="text-dark">Show aging table at bottom of statement</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    <select class="text-dark font-weight-bold select-custom" id="show_aging_table" name="show_aging_table" >
                        <option value="On" {{!empty($sales) && $sales->sales_show_aging_table == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($sales) && $sales->sales_show_aging_table == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_statements" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3 mb-4"></div>
            <div class="float-right mb-5">
                <button type="button" id="update_sales" class="btn btn-success rounded">Save</button>
            </div>
        </form>
        </div>
        <!-- =============================================================================================FOURTH TAB-->
        <div class="tab-pane fade show" id="extra" role="tabpanel" aria-labelledby="extra-tab">
        <form action="#" class="form-horizontal " id="expenses_form">
        {{ csrf_field() }}
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Bills and Expenses</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Show Items table on the expense and purchase forms</p>
                    <p class="text-dark">Track expense and items by customer</p>
                    <p class="text-dark">Make expense and items billable</p>
                    <p class="text-dark">Default bill payment terms</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    <select class="text-dark font-weight-bold select-custom" id="show_items_table" name="show_items_table" >
                        <option value="On" {{!empty($expenses) && $expenses->expenses_show_items_table == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($expenses) && $expenses->expenses_show_items_table == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    <select  class="text-dark font-weight-bold select-custom" id="track_expense_and_item_by_customer" name="track_expense_and_item_by_customer" >
                        <option value="On" {{!empty($expenses) && $expenses->expenses_track_expense_and_item_by_customer == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($expenses) && $expenses->expenses_track_expense_and_item_by_customer == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    <select  class="text-dark font-weight-bold select-custom" id="billable" name="billable" >
                        <option value="On" {{!empty($expenses) && $expenses->expenses_billable == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($expenses) && $expenses->expenses_billable == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    @if(!empty($expenses))
                    <input  class="text-dark input-custom" id="bill_payment_terms" list="terms_list" name="bill_payment_terms" type="text" value="{{$expenses->expenses_bill_payment_terms}}" >
                    @else
                    <input  class="text-dark input-custom" id="bill_payment_terms" list="terms_list" name="bill_payment_terms" type="text" value="" >
                    
                    @endif
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_bills_and_expenses" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light"></div>
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Purchase orders</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Use purchase orders</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    <select class="text-dark font-weight-bold  select-custom" id="use_purchase_order" name="use_purchase_order" >
                        <option value="On" {{!empty($expenses) && $expenses->expenses_use_purchase_order == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($expenses) && $expenses->expenses_use_purchase_order == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_purchase_orders" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light"></div>
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Messages</p>
                </div>
                <div class="col-md-4">
                    @if(!empty($expenses))
                    <input class="text-dark input-custom" id="purchase_order_email_message" name="purchase_order_email_message" type="text" value="{{$expenses->expenses_purchase_order_email_message}}" >
                    @else
                    <input class="text-dark input-custom" id="purchase_order_email_message" name="purchase_order_email_message" type="text" value="" >
                   
                    @endif
                </div>
                <div class="col-md-4 font-weight-bold">
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_expense_messages" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3 mb-4"></div>
            <div class="float-right mb-5">
                <button id="update_expenses" class="btn btn-success rounded">Save</button>
            </div>
        </form>
        </div>
        <!--=============================================================================================FIFTH TAB-->
        <div class="tab-pane fade show" id="advance" role="tabpanel" aria-labelledby="advance-tab">
        <form action="#" class="form-horizontal " id="advance_form">
        {{ csrf_field() }}
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Numbering</p>
                </div>
                <div class="col-md-4">
                    
                    <p class="text-dark">Main : Sales Invoice</p>
                    <p class="text-dark">Main : Bill Invoice</p>
                    
                    <p class="text-dark">Branch : Sales Invoice</p>
                    <p class="text-dark">Branch : Bill Invoice</p>
                    
                    <p class="text-dark">Estimate</p>
                    <p class="text-dark">Credit Note</p>
                    <p class="text-dark">Sales Receipt</p>
                    <p class="text-dark">Bill</p>
                    <p class="text-dark">Suppliers Credit</p>
                    <p class="text-dark">Cash Voucher</p>
                    <p class="text-dark">Cheque Voucher</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    @if(!empty($numbering))
                    
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_sales_exp" name="numbering_sales_exp" value="{{$numbering->sales_exp_start_no}}"> 
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_bill_invoice_main" name="numbering_bill_invoice_main" value="{{$numbering->numbering_bill_invoice_main}}"> 
                    
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_sales_invoice_branch" name="numbering_sales_invoice_branch" value="{{$numbering->numbering_sales_invoice_branch}}"> 
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_bill_invoice_branch" name="numbering_bill_invoice_branch" value="{{$numbering->numbering_bill_invoice_branch}}"> 
                    
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_estimate" name="numbering_estimate" value="{{$numbering->estimate_start_no}}"> 
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_credit_note" name="numbering_credit_note" value="{{$numbering->credit_note_start_no}}"> 
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_sales_receipt" name="numbering_sales_receipt" value="{{$numbering->sales_receipt_start_no}}"> 
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_bill" name="numbering_bill" value="{{$numbering->bill_start_no}}"> 
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_suppliers_credit" name="numbering_suppliers_credit" value="{{$numbering->suppliers_credit_start_no}}"> 
                    
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_cash_voucher" name="numbering_cash_voucher" value="{{$numbering->cash_voucher_start_no}}"> 
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_cheque_voucher" name="numbering_cheque_voucher" value="{{$numbering->cheque_voucher_start_no}}"> 
                    @else
                    
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_sales_exp" name="numbering_sales_exp" value="1001"> 
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_bill_invoice_main" name="numbering_bill_invoice_main" value="1001"> 
                    
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_sales_invoice_branch" name="numbering_sales_invoice_branch" value="1001"> 
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_bill_invoice_branch" name="numbering_bill_invoice_branch" value="1001">    
                    
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_estimate" name="numbering_estimate" value="1001">
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_credit_note" name="numbering_credit_note" value="1001"> 
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_sales_receipt" name="numbering_sales_receipt" value="1001"> 
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_bill" name="numbering_bill" value="1001"> 
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_suppliers_credit" name="numbering_suppliers_credit" value="1001"> 

                    <input type="number" step="1" class="text-dark input-custom" id="numbering_cash_voucher" name="numbering_cash_voucher" value="1"> 
                    <input type="number" step="1" class="text-dark input-custom" id="numbering_cheque_voucher" name="numbering_cheque_voucher" value="1"> 
                    @endif
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_numbering" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Cost Center</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Use Cost Center</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    @if(!empty($numbering))

                    @endif
                    <select class="text-dark font-weight-bold select-custom" id="useCostCenter" name="useCostCenter" >
                            <option value="On" {{!empty($numbering) && $numbering->use_cost_center == "On" ? 'selected' : ''}}>On</option>
                            <option value="Off" {{!empty($numbering) && $numbering->use_cost_center == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_cost_center" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light"></div>
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Accounting</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">First month of Fiscal year</p>
                    <p class="text-dark">First month of tax year</p>
                    <p class="text-dark">Accounting method</p>
                    <p class="text-dark">Close the books</p>
                    <p class="text-dark">End Month of Fiscal Year</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    <select class="text-dark font-weight-bold select-custom" id="first_month_of_fiscal_year" name="first_month_of_fiscal_year" >
                        <option value="January" {{!empty($advance) && $advance->advance_first_month_of_fiscal_year == "January" ? 'selected' : ''}}>January</option>
                        <option value="February" {{!empty($advance) && $advance->advance_first_month_of_fiscal_year == "February" ? 'selected' : ''}}>February</option>
                        <option value="March" {{!empty($advance) && $advance->advance_first_month_of_fiscal_year == "March" ? 'selected' : ''}}>March</option>
                        <option value="April" {{!empty($advance) && $advance->advance_first_month_of_fiscal_year == "April" ? 'selected' : ''}}>April</option>
                        <option value="May" {{!empty($advance) && $advance->advance_first_month_of_fiscal_year == "May" ? 'selected' : ''}}>May</option>
                        <option value="June" {{!empty($advance) && $advance->advance_first_month_of_fiscal_year == "June" ? 'selected' : ''}}>June</option>
                        <option value="July" {{!empty($advance) && $advance->advance_first_month_of_fiscal_year == "July" ? 'selected' : ''}}>July</option>
                        <option value="August" {{!empty($advance) && $advance->advance_first_month_of_fiscal_year == "August" ? 'selected' : ''}}>August</option>
                        <option value="September" {{!empty($advance) && $advance->advance_first_month_of_fiscal_year == "September" ? 'selected' : ''}}>September</option>
                        <option value="October" {{!empty($advance) && $advance->advance_first_month_of_fiscal_year == "October" ? 'selected' : ''}}>October</option>
                        <option value="November" {{!empty($advance) && $advance->advance_first_month_of_fiscal_year == "November" ? 'selected' : ''}}>November</option>
                        <option value="December" {{!empty($advance) && $advance->advance_first_month_of_fiscal_year == "December" ? 'selected' : ''}}>December</option>
                    </select>
                    
                    <select  class="text-dark font-weight-bold select-custom" id="first_month_of_tax_year" name="first_month_of_tax_year" >
                        <option value="January" {{!empty($advance) && $advance->advance_first_month_of_tax_year == "January" ? 'selected' : ''}}>January</option>
                        <option value="February" {{!empty($advance) && $advance->advance_first_month_of_tax_year == "February" ? 'selected' : ''}}>February</option>
                        <option value="March" {{!empty($advance) && $advance->advance_first_month_of_tax_year == "March" ? 'selected' : ''}}>March</option>
                        <option value="April" {{!empty($advance) && $advance->advance_first_month_of_tax_year == "April" ? 'selected' : ''}}>April</option>
                        <option value="May" {{!empty($advance) && $advance->advance_first_month_of_tax_year == "May" ? 'selected' : ''}}>May</option>
                        <option value="June" {{!empty($advance) && $advance->advance_first_month_of_tax_year == "June" ? 'selected' : ''}}>June</option>
                        <option value="July" {{!empty($advance) && $advance->advance_first_month_of_tax_year == "July" ? 'selected' : ''}}>July</option>
                        <option value="August" {{!empty($advance) && $advance->advance_first_month_of_tax_year == "August" ? 'selected' : ''}}>August</option>
                        <option value="September" {{!empty($advance) && $advance->advance_first_month_of_tax_year == "September" ? 'selected' : ''}}>September</option>
                        <option value="October" {{!empty($advance) && $advance->advance_first_month_of_tax_year == "October" ? 'selected' : ''}}>October</option>
                        <option value="November" {{!empty($advance) && $advance->advance_first_month_of_tax_year == "November" ? 'selected' : ''}}>November</option>
                        <option value="December" {{!empty($advance) && $advance->advance_first_month_of_tax_year == "December" ? 'selected' : ''}}>December</option>
                    </select>
                    
                    <select style="margin-top:15px;" class="text-dark font-weight-bold select-custom" id="accounting_method" name="accounting_method" >
                        <option value="Accrual" {{!empty($advance) && $advance->advance_accounting_method == "Accrual" ? 'selected' : ''}}>Accrual</option>
                        <option value="Cash" {{!empty($advance) && $advance->advance_accounting_method == "Cash" ? 'selected' : ''}}>Cash</option>
                    </select>
                    
                    <select style="margin-top:15px;" class="text-dark font-weight-bold select-custom" id="close_book" name="close_book" >
                        <option value="On" {{!empty($advance) && $advance->advance_close_book == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($advance) && $advance->advance_close_book == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    <select class="text-dark font-weight-bold select-custom" id="end_month_of_fiscal_year" name="end_month_of_fiscal_year" >
                        <option value="December" {{!empty($advance) && $advance->advance_end_month_of_fiscal_year == "December" ? 'selected' : ''}}>December</option>
                        <option value="January" {{!empty($advance) && $advance->advance_end_month_of_fiscal_year == "January" ? 'selected' : ''}}>January</option>
                        <option value="February" {{!empty($advance) && $advance->advance_end_month_of_fiscal_year == "February" ? 'selected' : ''}}>February</option>
                        <option value="March" {{!empty($advance) && $advance->advance_end_month_of_fiscal_year == "March" ? 'selected' : ''}}>March</option>
                        <option value="April" {{!empty($advance) && $advance->advance_end_month_of_fiscal_year == "April" ? 'selected' : ''}}>April</option>
                        <option value="May" {{!empty($advance) && $advance->advance_end_month_of_fiscal_year == "May" ? 'selected' : ''}}>May</option>
                        <option value="June" {{!empty($advance) && $advance->advance_end_month_of_fiscal_year == "June" ? 'selected' : ''}}>June</option>
                        <option value="July" {{!empty($advance) && $advance->advance_end_month_of_fiscal_year == "July" ? 'selected' : ''}}>July</option>
                        <option value="August" {{!empty($advance) && $advance->advance_end_month_of_fiscal_year == "August" ? 'selected' : ''}}>August</option>
                        <option value="September" {{!empty($advance) && $advance->advance_end_month_of_fiscal_year == "September" ? 'selected' : ''}}>September</option>
                        <option value="October" {{!empty($advance) && $advance->advance_end_month_of_fiscal_year == "October" ? 'selected' : ''}}>October</option>
                        <option value="November" {{!empty($advance) && $advance->advance_end_month_of_fiscal_year == "November" ? 'selected' : ''}}>November</option>
                        
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_accounting" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light" style="display:none;"></div>
            <div class="col-md-12 mt-3" style="display:none;">
                <div class="col-md-3">
                    <p class="text-dark">Company Type</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Tax form</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    @if(!empty($advance))
                    <input list="tax_forms_list" class="text-dark input-custom" id="advance_tax_form" name="advance_tax_form" type="text" value="{{$advance->advance_tax_form}}" >
                    @else
                    <input list="tax_forms_list" class="text-dark input-custom" id="advance_tax_form" name="advance_tax_form" type="text" value="Not sure/Other/None" >
                    
                    @endif
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_advance_company_type" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light"></div>
            <div class="col-md-12 mt-3" >
                <div class="col-md-3">
                    <p class="text-dark">Retained Earnings</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Beginning Balance</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    @if (!empty($advance) && $advance->advance_beginning_balance)
                        <input type="text" class="text-dark input-custom" value="{{number_format($advance->advance_beginning_balance,2)}}" id="ad_beg_bal_shown" name="ad_beg_bal_shown">
                        <input type="hidden" class="text-dark input-custom" value="{{$advance->advance_beginning_balance}}" id="ad_beg_bal" name="ad_beg_bal">
                    @else
                        <input type="text" class="text-dark input-custom" value="0.00" id="ad_beg_bal_shown" name="ad_beg_bal_shown">
                        <input type="hidden" class="text-dark input-custom" value="0.00" id="ad_beg_bal" name="ad_beg_bal">
                    @endif
                        <script>
                            $(document).ready(function(){
                                var textbox = '#ad_beg_bal_shown';
                                var hidden = '#ad_beg_bal';
                                $(textbox).keyup(function () {
                                    $(textbox).val(this.value.match(/[0-9.,=]*/));
                                var num = $(textbox).val();
                                    var comma = /,/g;
                                    num = num.replace(comma,'');
                                    $(hidden).val(num);
                                    var numCommas = addCommas(num);
                                    $(textbox).val(numCommas);
                                });
                                function addCommas(nStr) {
                                nStr += '';
                                var comma = /,/g;
                                nStr = nStr.replace(comma,'');
                                x = nStr.split('.');
                                x1 = x[0];
                                x2 = x.length > 1 ? '.' + x[1] : '';
                                var rgx = /(\d+)(\d{3})/;
                                while (rgx.test(x1)) {
                                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                                }
                                return x1 + x2;
                                }
                            })
                            
                        </script>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_beginning_balance" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3  border border-bottom border-light"></div>
            <div class="col-md-12 mt-3">
                <div class="col-md-3">
                    <p class="text-dark">Chart of Accounts</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Enable account numbers</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    <select class="text-dark font-weight-bold select-custom" id="enable_acc_number" name="enable_acc_number" >
                        <option value="On" {{!empty($advance) && $advance->advance_enable_acc_number == "On" ? 'selected' : ''}}>On</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_chart_of_accounts" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12  "></div>
            <div class="col-md-12 " style="display:none;">
                <div class="col-md-3">
                    <p class="text-dark">Categories</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Track Classes</p>
                    <p class="text-dark">Track Locations</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    <select class="text-dark font-weight-bold select-custom" id="track_classes" name="track_classes" >
                        <option value="On" {{!empty($advance) && $advance->advance_track_classes == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($advance) && $advance->advance_track_classes == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    <select style="margin-top:15px;" class="text-dark font-weight-bold select-custom" id="track_location" name="track_location" >
                        <option value="On" {{!empty($advance) && $advance->advance_track_location == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($advance) && $advance->advance_track_location == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_categories" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 "></div>
            <div class="col-md-12" style="display:none;">
                <div class="col-md-3">
                    <p class="text-dark">Automation</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Pre-fill forms with previously entered content</p>
                    <p class="text-dark">Automatically apply credits</p>
                    <p class="text-dark">Automatically invoice unbilled activity</p>
                    <p class="text-dark">Automatically apply bill payments</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    <select class="text-dark font-weight-bold select-custom" id="prefill_form" name="prefill_form" >
                        <option value="On" {{!empty($advance) && $advance->advance_prefill_form == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($advance) && $advance->advance_prefill_form == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    <select style="margin-top:15px;" class="text-dark font-weight-bold select-custom" id="apply_credit" name="apply_credit" >
                        <option value="On" {{!empty($advance) && $advance->advance_apply_credit == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($advance) && $advance->advance_apply_credit == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    <select style="margin-top:15px;" class="text-dark font-weight-bold select-custom" id="invoice_unbilled_activity" name="invoice_unbilled_activity" >
                        <option value="On" {{!empty($advance) && $advance->advance_invoice_unbilled_activity == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($advance) && $advance->advance_invoice_unbilled_activity == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    <select style="margin-top:15px;" class="text-dark font-weight-bold select-custom" id="apply_bill_payment" name="apply_bill_payment" >
                        <option value="On" {{!empty($advance) && $advance->advance_apply_bill_payment == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($advance) && $advance->advance_apply_bill_payment == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_automation" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3 mb-4"></div>
            <div class="col-md-12 mt-3" style="display:none;">
                <div class="col-md-3">
                    <p class="text-dark">Time tracking</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Add Service field to timesheets</p>
                    <p class="text-dark">Make Single-Time Activity Billable to Customer</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    <select class="text-dark font-weight-bold select-custom" id="add_service_field" name="add_service_field" >
                        <option value="On" {{!empty($advance) && $advance->advance_add_service_field == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($advance) && $advance->advance_add_service_field == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    <br>
                    <select style="margin-top:15px;" class="text-dark font-weight-bold select-custom" id="single_time_activity_billable" name="single_time_activity_billable" >
                        <option value="On" {{!empty($advance) && $advance->advance_single_time_activity_billable == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($advance) && $advance->advance_single_time_activity_billable == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_time_tracking" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 "></div>
            <div class="col-md-12 " style="display:none;">
                <div class="col-md-3">
                    <p class="text-dark">Language</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Language</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    <select class="text-dark font-weight-bold select-custom" id="language" name="language" >
                        <option value="English" {{!empty($advance) && $advance->advance_language == "English" ? 'selected' : ''}}>English</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_language" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 "></div>
            <div class="col-md-12 " style="display:none;">
                <div class="col-md-3">
                    <p class="text-dark">Currency</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Home Currency</p>
                    <p class="text-dark">Multicurrency</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    <select class="text-dark font-weight-bold select-custom" id="home_currency" name="home_currency" >
                        <option value="Philippine Peso" {{!empty($advance) && $advance->advance_home_currency == "Philippine Peso" ? 'selected' : ''}}>Philippine Peso</option>
                    </select>
                   
                    <select style="margin-top:15px;" class="text-dark font-weight-bold select-custom" id="multi_currency" name="multi_currency" >
                        <option value="On" {{!empty($advance) && $advance->advance_multi_currency == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($advance) && $advance->advance_multi_currency == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_currency" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 "></div>
            <div class="col-md-12 mt-3">    
                <div class="col-md-3">
                    <p class="text-dark">Other preferences</p>
                </div>
                <div class="col-md-4">
                    <p class="text-dark">Date format</p>
                    <p class="text-dark">Number format</p>
                    <p class="text-dark" style="display:none;">Warn if duplicate cheque number is used</p>
                    <p class="text-dark" style="display:none;">Warn if duplicate bill number is used</p>
                    <p class="text-dark">Sign me out if inactive for</p>
                </div>
                <div class="col-md-4 font-weight-bold">
                    <select class="text-dark font-weight-bold select-custom" id="date_format" name="date_format" >
                        <option value="mm-dd-yyyy" {{!empty($advance) && $advance->advance_date_format == "mm-dd-yyyy" ? 'selected' : ''}}>mm-dd-yyyy</option>
                    </select>
                    
                    <select style="margin-top:15px;" class="text-dark font-weight-bold select-custom" id="number_format" name="number_format" >
                        <option value="123,456.00" {{!empty($advance) && $advance->advance_number_format == "123,456.00" ? 'selected' : ''}}>123,456.00</option>
                    </select>
                    
                    <select style="margin-top:15px;display:none!important;" class="text-dark font-weight-bold select-custom" id="dup_cheque_num" name="dup_cheque_num" >
                        <option value="On" {{!empty($advance) && $advance->advance_dup_cheque_num == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($advance) && $advance->advance_dup_cheque_num == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    <select style="margin-top:15px;display:none!important;" class="text-dark font-weight-bold select-custom" id="dup_bill_num" name="dup_bill_num" >
                        <option value="On" {{!empty($advance) && $advance->advance_dup_bill_num == "On" ? 'selected' : ''}}>On</option>
                        <option value="Off" {{!empty($advance) && $advance->advance_dup_bill_num == "Off" ? 'selected' : ''}}>Off</option>
                    </select>
                    
                    <select style="margin-top:15px;" class="text-dark font-weight-bold select-custom" id="inactive_time" name="inactive_time" >
                        <option value="15" {{!empty($advance) && $advance->advance_inactive_time == "15" ? 'selected' : ''}}>15 minutes</option>
                        <option value="30" {{!empty($advance) && $advance->advance_inactive_time == "30" ? 'selected' : ''}}>30 minutes</option>
                        <option value="45" {{!empty($advance) && $advance->advance_inactive_time == "45" ? 'selected' : ''}}>45 minutes</option>
                        <option value="1" {{!empty($advance) && $advance->advance_inactive_time == "1" ? 'selected' : ''}}>1 Hour</option>
                        <option value="2" {{!empty($advance) && $advance->advance_inactive_time == "2" ? 'selected' : ''}}>2 Hours</option>
                        <option value="3" {{!empty($advance) && $advance->advance_inactive_time == "3" ? 'selected' : ''}}>3 Hours</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="#" id="toggle_edit_other_preferences" class="far fa-edit"></a>
                </div>
            </div>
            <div class="col-md-12 mt-3 mb-4"></div>
            <div class="float-right mb-5">
                <button id="update_advance" class="btn btn-success rounded">Save</button>
            </div>
        </form>
        </div>
        

        <div class="tab-pane fade show" id="bank" role="tabpanel" aria-labelledby="bank-tab">
            <div class="modal fade" id="AddBankModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <script>
                    function save_new_bank(){
                        var BankNameInput=document.getElementById('BankNameInput').value;
                        var BankCodeInput=document.getElementById('BankCodeInput').value;
                        var AccountNoInput=document.getElementById('AccountNoInput').value;
                        var RemarkTextAreaBank=document.getElementById('RemarkTextAreaBank').value;
                        var BankBranchInput=document.getElementById('BankBranchInput').value;
                        
                        $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('add_bank') }}',                
                        data: {BankBranchInput:BankBranchInput,BankNameInput:BankNameInput,BankCodeInput:BankCodeInput,AccountNoInput:AccountNoInput,RemarkTextAreaBank:RemarkTextAreaBank,_token: '{{csrf_token()}}'},
                        success: function(data) {
                        
                            swal({title: "Done!", text: "Added Bank.", type: 
                                "success"}).then(function(){ 
                                location.reload();
                            });
                        },
                        error: function (data) {
                            alert(data.responseText);
                            swal("Error!", "Invoice failed", "error");
                        }  

                        })
                        
                        
                    }
                   $("#add_bank_form").submit(function(e) {
                    e.preventDefault();
                    
                    }); 
                </script>
                <form id="add_bank_form" action="#" onsubmit="save_new_bank()">
                <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new Bank</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="BankNameInput">Bank Name</label>
                        <input type="text" class="form-control" id="BankNameInput" aria-describedby="emailHelp" required placeholder="Enter Bank Name">
                    </div>
                    <div class="form-group">
                        <label for="BankNameInput">Bank Branch</label>
                        <input type="text" class="form-control" id="BankBranchInput" aria-describedby="emailHelp" required placeholder="Enter Bank Branch">
                    </div>
                    <div class="form-group">
                        <label for="BankCodeInput">Bank Code</label>
                        <input type="text" class="form-control" id="BankCodeInput" aria-describedby="emailHelp" required placeholder="Enter Bank Code">
                    </div>
                    <div class="form-group">
                        <label for="AccountNoInput">Account No</label>
                        <input type="text" class="form-control" id="AccountNoInput" aria-describedby="emailHelp" required placeholder="Enter Account No">
                    </div>
                    <div class="form-group">
                        <label for="RemarkTextAreaBank">Remark</label>
                        <textarea type="text" class="form-control" id="RemarkTextAreaBank"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                
                </div>
                </form>
            </div>
            </div>
            <div class="modal fade" id="EditBankModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <script>
                    function SetEditBankModal(id){
                            var question;
                            var r = confirm("Are You Sure you want to Change this?\nAny Changes here will be subject for Approval");
                            if (r == true) {
                                @foreach($banks as $bank)
                                if(id=="{{$bank->bank_no}}"){
                                    document.getElementById('BankNameInputedit').value='{{$bank->bank_name}}';
                                    document.getElementById('BankCodeInputedit').value='{{$bank->bank_code}}';
                                    document.getElementById('AccountNoInputedit').value='{{$bank->bank_account_no}}';
                                    document.getElementById('RemarkTextAreaBankedit').value='{{$bank->bank_remark}}';
                                    document.getElementById('BankNoHidden').value='{{$bank->bank_no}}';
                                    document.getElementById('BankBranchInputEdit').value='{{$bank->bank_branch}}';
                                    
                                }

                                @endforeach
                                open_modal_dyna('EditBankModal');
                            }
                    }
                    function edit_edit_bank(){
                        var BankNoHidden=document.getElementById('BankNoHidden').value;
                        var BankNameInput=document.getElementById('BankNameInputedit').value;
                        var BankCodeInput=document.getElementById('BankCodeInputedit').value;
                        var AccountNoInput=document.getElementById('AccountNoInputedit').value;
                        var RemarkTextAreaBank=document.getElementById('RemarkTextAreaBankedit').value;
                        var BankBranchInput=document.getElementById('BankBranchInputEdit').value;
                        $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('update_bank') }}',                
                        data: {BankBranchInput:BankBranchInput,BankNoHidden:BankNoHidden,BankNameInput:BankNameInput,BankCodeInput:BankCodeInput,AccountNoInput:AccountNoInput,RemarkTextAreaBank:RemarkTextAreaBank,_token: '{{csrf_token()}}'},
                        success: function(data) {
                        
                            swal({title: "Done!", text: "Bank Updated.", type: 
                                "success"}).then(function(){ 
                                location.reload();
                            });
                        }  

                        })
                        
                        
                    }
                   $("#edit_bank_form").submit(function(e) {
                    e.preventDefault();
                    
                    }); 
                </script>
                <form id="edit_bank_form" action="#" onsubmit="edit_edit_bank()">
                <div class="modal-content" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Bank</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="BankNoHidden" >
                        <label for="BankNameInputedit">Bank Name</label>
                        <input type="text" class="form-control" id="BankNameInputedit" aria-describedby="emailHelp" required placeholder="Enter Bank Name">
                    </div>
                    <div class="form-group">
                        <label for="BankBranchInputEdit">Bank Branch</label>
                        <input type="text" class="form-control" id="BankBranchInputEdit" aria-describedby="emailHelp" required placeholder="Enter Bank Branch">
                    </div>
                    <div class="form-group">
                        <label for="BankCodeInputedit">Bank Code</label>
                        <input type="text" class="form-control" id="BankCodeInputedit" aria-describedby="emailHelp" required placeholder="Enter Bank Code">
                    </div>
                    <div class="form-group">
                        <label for="AccountNoInputedit">Account No</label>
                        <input type="text" class="form-control" id="AccountNoInputedit" aria-describedby="emailHelp" required placeholder="Enter Account No">
                    </div>
                    <div class="form-group">
                        <label for="RemarkTextAreaBankedit">Remark</label>
                        <textarea type="text" class="form-control" id="RemarkTextAreaBankedit"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                
                </div>
                </form>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12" style="text-align:right;margin-top:10px;margin-bottom:10px;">
                <button class="btn btn-primary" data-toggle="modal" data-target="#AddBankModal">Add New Bank</button>
            </div>
            </div>
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th style="vertical-align:middle;">Bank Name</th>
                        <th style="vertical-align:middle;">Branch</th>
                        <th style="vertical-align:middle;">Bank Code</th>
                        <th style="vertical-align:middle;">Account No</th>
                        <th style="vertical-align:middle;">Remark</th>
                        <th style="vertical-align:middle;"></th>
                    </tr>
                </thead>
                <tbody class="table-light">
                    @foreach ($banks as $bank)
                    @if($bank->bank_status=="1")
                    <tr>
                        <td style="vertical-align:middle;">{{$bank->bank_name}}</td>
                        <td style="vertical-align:middle;">{{$bank->bank_branch}}</td>
                        <td style="vertical-align:middle;">{{$bank->bank_code}}</td>
                        <td style="vertical-align:middle;">{{$bank->bank_account_no}}</td>
                        <td style="vertical-align:middle;">{{$bank->bank_remark}}</td>
                        <td style="vertical-align:middle;text-align:center;">
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-link " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                
                                <a class="dropdown-item" onclick="SetEditBankModal('{{$bank->bank_no}}')" href="#" >Edit</a>
                                
                                <form action="delete_bank" method="POST" onsubmit="return confirm('Are you sure you want to delete this?\nThis will be subject for approval')">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="bank_id" value="{{$bank->bank_no}}">
                                    <input type="hidden" name="active" value="0">
                                    <input type="submit" class="dropdown-item btn-sm" value="Delete" style="font-size:11px;">
                                </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif 
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>

<script>
$(document).ready(function () {
    
    $('#right-panel select').prop('disabled', true);
    $('#right-panel input').prop('readonly', true);
    console.log('input enabling');
    $("#add_bank_form :input").prop("readonly", false);
    $("#add_bank_form :input").prop("disabled", false);
    $("#edit_bank_form :input").prop("readonly", false);
    $("#edit_bank_form :input").prop("disabled", false);
    // $("#update_company").click(function (event) {
    //     event.preventDefault();
        
    //     $('select:disabled').prop('disabled', false);
    //     var formData = new FormData($('#company_form')[0]);
    //     console.log(formData);
	// 	$.ajax({
	// 		method: "POST",
	// 		headers: {
	// 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 		},
	// 		url: "{{ route('update_company') }}",
    //     	dataType: "text",
    //      contentType: false,
	// 		data: formData,
	// 		success: function (data) {
                
    //             swal("Done!", "Updated company", "success");
                
    //             $('select').prop('disabled', true);
    //             $('input').prop('readonly', true);
	// 		},
	// 		error: function (data) {
                
	// 			swal("Error!", "Update failed", "error");
	// 		}
	// 	});
    // });

    $("#update_sales").click(function (event) {
        event.preventDefault();
        
        $('select:disabled').prop('disabled', false);

		$.ajax({
			method: "POST",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "{{ route('update_sales') }}",
			dataType: "text",
			data: $('#sales_form').serialize(),
			success: function (data) {
                 
                swal("Done!", "Updated sales", "success");

                $('select').prop('disabled', true);
                $('input').prop('readonly', true);
			},
			error: function (data) {
                //alert(data.responseText); 
				swal("Error!", "Update failed", "error");
			}
		});
    });

    $("#update_expenses").click(function (event) {
        event.preventDefault();
        
        $('select:disabled').prop('disabled', false);

		$.ajax({
			method: "POST",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "{{ route('update_expenses') }}",
			dataType: "text",
			data: $('#expenses_form').serialize(),
			success: function (data) {
                swal("Done!", "Updated expenses", "success");

                $('select').prop('disabled', true);
                $('input').prop('readonly', true);
			},
			error: function (data) {
				swal("Error!", "Update failed", "error");
			}
		});
    });

    $("#update_advance").click(function (event) {
        event.preventDefault();
        
        $('select:disabled').prop('disabled', false);

		$.ajax({
			method: "POST",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: "{{ route('update_advance') }}",
			dataType: "text",
			data: $('#advance_form').serialize(),
			success: function (data) {
                swal("Done!", "Updated advance", "success");

                $('select').prop('disabled', true);
                $('input').prop('readonly', true);
			},
			error: function (data) {
				swal("Error!", "Update failed", "error");
			}
		});
    });

});
</script>
@endsection