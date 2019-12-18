@extends('layout.initial')


@section('content')
<script type="text/javascript">
// $(document).ready(function() {
//   var textbox = '#ThousandSeperator_commas';
//   var hidden = '#ThousandSeperator_num';
//   $(textbox).keyup(function () {
//   var num = $(textbox).val();
//     var comma = /,/g;
//     num = num.replace(comma,'');
//     $(hidden).val(num);
//     var numCommas = addCommas(num);
//     $(textbox).val(numCommas);
//   });
// });
 

</script>
<div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Expenses</h1>
                    {{-- <input type="text" id="ThousandSeperator_commas"> 
                    <input type="number" id="ThousandSeperator_num">  --}}
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
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Expenses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Suppliers</a>
                </li>
            </ul>
            <div class="tab-content pl-3 p-1" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="col-md-12 mb-1 p-0">
                        <h3 class="mt-2">Expense Transactions</h3>
                        
                    </div>
                    <div class="col-md-12 mb-5 mt-3 p-0">
                            @if ($UserAccessList[0]->bill=="1")
                            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#billmodal" onclick="ResetBills()">Bill</a>
                            @endif
                            @if ($UserAccessList[0]->supplier_credit=="1")
                            <a style="display:none;" class="btn btn-success" href="#" data-toggle="modal" data-target="#suppliercreditmodal">Supplier Credit</a>
                            <a style="display:none;" class="btn btn-success" href="#" data-toggle="modal" data-target="#creditcardcreditmodal">Credit Card Charge</a>
                            @endif
                            @if ($UserAccessList[0]->pay_bills=="1")
                            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#paybillsmodal">Pay Bill</a>
                            @endif
                            <a style="display:none;" class="btn btn-success" href="#" data-toggle="modal" data-target="#expensemodal">Expense</a>
                            <a style="display:none;" class="btn btn-success" href="#" data-toggle="modal" data-target="#chequemodal">Cheque</a>
                        {{-- <button class="btn btn-success rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">New Transaction</button>

                        <div class="dropdown-menu">
                            @if ($UserAccessList[0]->bill=="1")
                            <a class="dropdown-item" href="" data-toggle="modal" data-target="#billmodal">Bill</a>
                            @endif
                            @if ($UserAccessList[0]->supplier_credit=="1")
                            <a class="dropdown-item" href="" data-toggle="modal" data-target="#suppliercreditmodal">Supplier Credit</a>
                            <a style="display:none;" class="dropdown-item" href="" data-toggle="modal" data-target="#creditcardcreditmodal">Credit Card Charge</a>
                            @endif
                            @if ($UserAccessList[0]->pay_bills=="1")
                            <a class="dropdown-item" href="" data-toggle="modal" data-target="#paybillsmodal">Pay Bill</a>
                            @endif
                            <a style="display:none;" class="dropdown-item" href="" data-toggle="modal" data-target="#expensemodal">Expense</a>
                            <a style="display:none;" class="dropdown-item" href="" data-toggle="modal" data-target="#chequemodal">Cheque</a>
                            
                            
                            
                        </div> --}}
                    </div>
                    <div id="table" class="table-editable pt-5">
                        <!-- Button trigger modal -->
                        <!-- <span class="table-add float-right mb-3 mr-2"><button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#staticModal">New Rule</button></span> -->
                        
                        <script>
                            $(document).ready(function(){
                                $("#add_lines_expense_item2").click(function(event){
                                    event.preventDefault();
                                    var markup = '<tr class="expense_lines_item2" id="expense_line_item'+$('#expense_item_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_expense_item" contenteditable="false">'+$('#expense_item_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="expense_data product_select_expense" id="select_product_name_expense'+$('#expense_item_tableedit tr').length+'"><option value=""></option>@foreach($products_and_services as $product)<option value="{{$product->product_id}}">{{$product->product_name}}</option>@endforeach</select></td><td class="pt-3-half"><input class="expense_data product_description_expense" id="select_product_description_expense'+$('#expense_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="expense_data product_qty_expense" onclick="this.select();" id="product_qty_expense'+$('#expense_item_tableedit tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="expense_data product_rate_expense" id="select_product_rate_expense'+$('#expense_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_expense" id="total_amount_expense'+$('#expense_item_tableedit tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_expense'+$('#expense_item_tableedit tr').length+'" class="fa fa-trash delete_product_expense"></a></td></tr>';
                                    
                                    $("#expense_item_tableedit").append(markup);


                                }); 

                                $("#clear_lines_expense_item2").click(function(event){
                                    event.preventDefault();
                                    $('.expense_lines_item2').remove();

                                    update_total_expense();
                                }); 

                                $("#add_lines_expense_account2").click(function(event){
                                    event.preventDefault();
                                    var markup = '<tr class="expense_lines_account2" id="expense_line_account'+$('#expense_account_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_expense_account" contenteditable="false">'+$('#expense_account_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" list="account_expenses" class="expense_data account_select_expense" id="select_account_expense'+$('#expense_account_tableedit tr').length+'"><option></option>@foreach($COA as $coa)<option value="{{$coa->id}}">{{$coa->coa_name}}</option>@endforeach</select></td><td class="pt-3-half"><input class="expense_data description_select_expense" id="select_description_expense'+$('#expense_account_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="expense_data amount_select_expense" onclick="this.select();" id="select_expense_amount'+$('#expense_account_tableedit tr').length+'" style="border:0; text-align:center;"></td><td class="pt-3-half"><a href="#" id="delete_account_expense'+$('#expense_account_tableedit tr').length+'" class="fa fa-trash delete_account_expense"></a></td></tr>';
                                    
                                    $("#expense_account_tableedit").append(markup);
                                }); 

                                $("#clear_lines_expense_account2").click(function(event){
                                    event.preventDefault();
                                    $('.expense_lines_account2').remove();

                                    update_total_expense();
                                });

                                $("#clear_lines_cheque_item2").click(function(event){
                                    event.preventDefault();
                                    $('.cheque_lines_item2').remove();

                                    //update_total_cheque();
                                }); 

                                $("#add_lines_cheque_account2").click(function(event){
                                    event.preventDefault();
                                    var markup = '<tr class="cheque_lines_account2" id="cheque_line_account'+$('#cheque_account_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_cheque_account" contenteditable="false">'+$('#cheque_account_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" list="account_expenses" class="cheque_data account_select_cheque" id="select_account_cheque'+$('#cheque_account_tableedit tr').length+'"><option></option>@foreach($COA as $coa)<option value="{{$coa->id}}">{{$coa->coa_name}}</option>@endforeach</select></td><td class="pt-3-half"><input class="cheque_data description_select_cheque" id="select_description_cheque'+$('#cheque_account_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="cheque_data amount_select_cheque" onclick="this.select();" id="select_cheque_amount'+$('#cheque_account_tableedit tr').length+'" style="border:0; text-align:center;"></td><td class="pt-3-half"><a href="#" id="delete_account_cheque'+$('#cheque_account_tableedit tr').length+'" class="fa fa-trash delete_account_cheque"></a></td></tr>';
                                    
                                    $("#cheque_account_tableedit").append(markup);
                                }); 

                                $("#clear_lines_cheque_account2").click(function(event){
                                    event.preventDefault();
                                    $('.cheque_lines_account2').remove();

                                    update_total_cheque();
                                });

                                $("#add_lines_bill_item2").click(function(event){
                                    event.preventDefault();
                                    var markup = '<tr class="bill_lines_item2" id="bill_line_item'+$('#bill_item_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_bill_item" contenteditable="false">'+$('#bill_item_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="bill_data product_select_bill" id="select_product_name_bill'+$('#bill_item_tableedit tr').length+'"><option value=""></option>@foreach($products_and_services as $product)<option value="{{$product->product_id}}">{{$product->product_name}}</option>@endforeach</select></td><td class="pt-3-half"><input class="bill_data product_description_bill" id="select_product_description_bill'+$('#bill_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="bill_data product_qty_bill" onclick="this.select();" id="product_qty_bill'+$('#bill_item_tableedit tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="bill_data product_rate_bill" id="select_product_rate_bill'+$('#bill_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_bill" id="total_amount_bill'+$('#bill_item_tableedit tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_bill'+$('#bill_item_tableedit tr').length+'" class="fa fa-trash delete_product_bill"></a></td></tr>';
                                    
                                    $("#bill_item_tableedit").append(markup);


                                });
                                $("#clear_lines_bill_item2").click(function(event){
                                    event.preventDefault();
                                    $('.bill_lines_item2').remove();

                                    update_total_bill();
                                }); 

                                $("#add_lines_bill_account2").click(function(event){
                                    event.preventDefault();
                                    var markup = '<tr class="bill_lines_account2" id="bill_line_account'+$('#bill_account_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_bill_account" contenteditable="false">'+$('#bill_account_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" list="account_expenses" class="bill_data account_select_bill selectpicker" data-live-search="true" id="select_account_bill'+$('#bill_account_tableedit tr').length+'"><option></option>@foreach($COA as $coa)<option value="{{$coa->id}}">{{$coa->coa_name}}</option>@endforeach</select></td><td class="pt-3-half"><input class="form-control bill_data description_select_bill" id="select_description_bill'+$('#bill_account_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half">';
                                    markup=markup+'<input type="text" class="sssss form-control" id="unformated_select_bill_rate'+$('#bill_account_tableedit tr').length+'" style="border:0;text-align:right;">';

                                    markup=markup+'<input type="hidden" class="bill_data amount_select_bill" onclick="this.select();" id="select_bill_amount'+$('#bill_account_tableedit tr').length+'" style="border:0; text-align:center;"></td><td class="pt-3-half"><a href="#" id="delete_account_bill'+$('#bill_account_tableedit tr').length+'" class="fa fa-trash delete_account_bill"></a></td></tr>';
                                    var textbox = '#unformated_select_bill_rate'+$('#bill_account_tableedit tr').length;
						            var hidden = '#select_bill_amount'+$('#bill_account_tableedit tr').length;
                                    $("#bill_account_tableedit").append(markup);
                                    $(textbox).keyup(function () {
                                        $(textbox).val(this.value.match(/[0-9.,-]*/));
                                    var num = $(textbox).val();
                                        var comma = /,/g;
                                        num = num.replace(comma,'');
                                        $(hidden).val(num);
                                        $(hidden).attr('title',num);
                                        var numCommas = addCommas(num);
                                        $(textbox).val(numCommas);
                                    });
                                    refreshpicjer();
                                }); 

                                $("#clear_lines_bill_account2").click(function(event){
                                    event.preventDefault();
                                    $('.bill_lines_account2').remove();

                                    update_total_bill();
                                }); 
                                $("#add_lines_sc_item2").click(function(event){
                                    event.preventDefault();
                                    var markup = '<tr class="sc_lines_item2" id="sc_line_item'+$('#sc_item_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_sc_item" contenteditable="false">'+$('#sc_item_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="sc_data product_select_sc" id="select_product_name_sc'+$('#sc_item_tableedit tr').length+'"><option value=""></option>@foreach($products_and_services as $product)<option value="{{$product->product_id}}">{{$product->product_name}}</option>@endforeach</select></td><td class="pt-3-half"><input class="sc_data product_description_sc" id="select_product_description_sc'+$('#sc_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="sc_data product_qty_sc" onclick="this.select();" id="product_qty_sc'+$('#sc_item_tableedit tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="sc_data product_rate_sc" id="select_product_rate_sc'+$('#sc_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_sc" id="total_amount_sc'+$('#sc_item_tableedit tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_sc'+$('#sc_item_tableedit tr').length+'" class="fa fa-trash delete_product_sc"></a></td></tr>';
                                    
                                    $("#sc_item_tableedit").append(markup);


                                });
                                $("#clear_lines_sc_item2").click(function(event){
                                    event.preventDefault();
                                    $('.sc_lines_item2').remove();

                                    update_total_sc();
                                });
                                //sssds
                                $("#add_lines_sc_account2").click(function(event){
                                    
                                    event.preventDefault();
                                    var markup = '<tr class="sc_lines_account2" id="sc_line_account'+$('#sc_account_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_sc_account" contenteditable="false">'+$('#sc_account_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" list="account_expenses" class="sc_data account_select_sc" id="select_account_sc'+$('#sc_account_tableedit tr').length+'"><option></option>@foreach($COA as $coa)<option value="{{$coa->id}}">{{$coa->coa_name}}</option>@endforeach</select></td><td class="pt-3-half"><input class="sc_data description_select_sc" id="select_description_sc'+$('#sc_account_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="sc_data amount_select_sc" onclick="this.select();" id="select_sc_amount'+$('#sc_account_tableedit tr').length+'" style="border:0; text-align:center;"></td><td class="pt-3-half"><a href="#" id="delete_account_sc'+$('#sc_account_tableedit tr').length+'" class="fa fa-trash delete_account_sc"></a></td></tr>';
                                    
                                    $("#sc_account_tableedit").append(markup);
                                }); 
                                $("#clear_lines_sc_account2").click(function(event){
                                    event.preventDefault();
                                    $('.sc_lines_account2').remove();

                                    update_total_sc();
                                });
                                
                            });
                                
                        </script>
                        
                            <table style="margin-top:10px;" id="expensetable" class="table table-bordered table-responsive-md table-striped text-center font14">
                            <thead>
                            <tr>
                                
                                <th  style="vertical-align:middle;" class="text-center">DATE</th>
                                <th  style="vertical-align:middle;" class="text-center" >TYPE</th>
                                <th  style="vertical-align:middle;" class="text-center">NO.</th>
                                <th  style="vertical-align:middle;" class="text-center">RF</th>
                                <th  style="vertical-align:middle;" class="text-center">PO</th>
                                <th  style="vertical-align:middle;" class="text-center">CI</th>
                                <th  style="vertical-align:middle;" class="text-center">PAYEE</th>
                                <th  style="vertical-align:middle;" class="text-center" width="10%">DESCRIPTION</th>
                                <th  style="vertical-align:middle;" class="text-center">Due Date</th>
                                <th  style="vertical-align:middle;" class="text-center"  width="20%">CATEGORY</th>
                                <th  style="vertical-align:middle;" class="text-center" width="10%">MEMO</th>
                                <th  style="vertical-align:middle;" class="text-center">TOTAL</th>
                                <th  style="vertical-align:middle;" class="text-center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($expense_transactions as $et)
                                @if ($et->et_type==$et->et_ad_type)
                                    
                                
                                    <?php
                                    $overduetransaction=0;
                                    ?>
                                    @if($et->et_due_date!="")
                                        <?php
                                        $date1=date_create(date('Y-m-d'));
                                        $date2=date_create($et->et_due_date);
                                        $diff=date_diff($date1,$date2);
                                        ?>
                                        @if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && $et->et_bil_status!="Paid" )
                                        <?php
                                        $overduetransaction=1;
                                        ?>
                                        @else
                                        
                                        @endif
                                    @endif
                                <tr {{$overduetransaction==1? 'class=table-danger' : ''}}>
                                    
                                    <td class="pt-3-half" style="vertical-align:middle;">{{date('m-d-Y',strtotime($et->et_date))}}</td>
                                    <td class="pt-3-half"  style="vertical-align:middle;">{{$et->et_type}}</td>
                                    
                                    <td class="pt-3-half"  style="vertical-align:middle;">
                                        {{-- @if($et->remark!="" || $et->et_bil_status!="")
                                        {{$et->et_no}}
                                        
                                        
                                        @else
                                            @if($et->et_type=="Expense" )
                                            <a href="#" onclick="ViewExpenseTransaction('{{$et->et_no}}','{{$et->et_type}}','editexpensemodal')" class="text-info" >{{$et->et_no}}</a>
                                            @elseif($et->et_type=="Supplier credit" && $UserAccessList[0]->supplier_credit=="1")
                                            <a href="#" onclick="ViewExpenseTransaction('{{$et->et_no}}','{{$et->et_type}}','editsuppliercreditmodal')" class="text-info" >{{$et->et_no}}</a>
                                            @elseif($et->et_type=="Bill" && $UserAccessList[0]->bill=="1")
                                            <a href="#" onclick="ViewExpenseTransaction('{{$et->et_no}}','{{$et->et_type}}','editbillmodal')" class="text-info" >{{$et->et_no}}</a>
                                            @elseif($et->et_type=="Cheque")
                                            <a href="#" onclick="ViewExpenseTransaction('{{$et->et_no}}','{{$et->et_type}}','editchequemodal')" class="text-info" >{{$et->et_no}}</a>
                                            @elseif($et->et_type=="Credit card credit")
                                            <a href="#" onclick="ViewExpenseTransaction('{{$et->et_no}}','{{$et->et_type}}','creditcardcreditmodaledit')" class="text-info" >{{$et->et_no}}</a>

                                            @else
                                            {{$et->et_no}}
                                            @endif
                                        @endif --}}
                                        {{$et->et_no}}
                                    </td>
                                    <td class="pt-3-half"  style="vertical-align:middle;">
                                        {{$et->et_shipping_address}}
                                        
                                    </td>
                                    <td class="pt-3-half"  style="vertical-align:middle;">
                                        
                                        {{$et->et_shipping_to}}
                                       
                                    </td>
                                    <td class="pt-3-half"  style="vertical-align:middle;">
                                       
                                        {{$et->et_shipping_via}}
                                    </td>
                                    <td class="pt-3-half"  style="vertical-align:middle;">{{$et->display_name!=""? $et->display_name :$et->f_name." ".$et->l_name}}</td>
                                    <td class="pt-3-half"  style="vertical-align:middle;">{{$et->et_ad_desc}}</td>
                                    <td class="pt-3-half"  style="vertical-align:middle;">
                                        @if($et->et_due_date!="")
                                            <?php
                                            $date1=date_create(date('Y-m-d'));
                                            $date2=date_create($et->et_due_date);
                                            $diff=date_diff($date1,$date2);
                                            ?>
                                            @if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && $et->et_bil_status!="Paid" )
                                            <span title='overdue' style='color:red;'>{{$et->et_due_date!=""? date('m-d-Y',strtotime($et->et_due_date)) : ""}}</span>

                                            @else
                                            {{$et->et_due_date!=""? date('m-d-Y',strtotime($et->et_due_date)) : ""}}
                                            @endif
                                        @endif
                                        
                                    </td>
                                    <td class="pt-3-half"  style="vertical-align:middle;">
                                        @foreach ($COA as $coa)
                                        @if($et->et_ad_product==$coa->id )
                                        {{$coa->coa_name}}
                                        @endif
                                        @endforeach
                                        
                                    </td>
                                    <td class="pt-3-half"  style="vertical-align:middle;">{{$et->et_memo}}</td>
                                    <td class="pt-3-half" style="vertical-align:middle;" >PHP {{number_format($et->et_ad_total,2)}}</td>
                                    <td>
                                        @if ($et->et_type=="Bill" && $et->et_ad_rate=="1")
                                            @if ($et->et_bil_status=="Paid")
                                                Paid
                                            @else
                                            <button class="btn btn-link" title="Supplier Credit" onclick="supplier_credit_modal_open('{{$et->et_no}}')" data-toggle="modal" data-target="#suppliercreditmodal"><span class="fa fa-history"></span></button>
                                            @endif
                                        
                                        @else
                                            
                                        @endif
                                        
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            @foreach ($EXNew as $EXn)
                            <tr>
                                <td style="vertical-align:middle;">{{date('m-d-Y',strtotime($EXn->et_date))}}</td>
                                <td class="pt-3-half"  style="vertical-align:middle;">{{$EXn->et_type}}</td>
                                <td class="pt-3-half"  style="vertical-align:middle;">{{$EXn->et_no}}</td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                    {{$EXn->et_shipping_address}}
                                    
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                    
                                    {{$EXn->et_shipping_to}}
                                   
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                   
                                    {{$EXn->et_shipping_via}}
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                    @foreach ($customers as $cus)
                                        @if ($cus->customer_id==$EXn->et_customer)
                                        {{$cus->display_name!=""? $cus->display_name :$cus->f_name." ".$cus->l_name}}
                                        @endif 
                                    @endforeach
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                    
                                    @foreach ($ETANew as $ETAn)
                                        @if ($ETAn->et_ad_no==$EXn->et_no)
                                            {{$ETAn->et_ad_desc}}<br>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                    @if($EXn->et_due_date!="")
                                        <?php
                                        $date1=date_create(date('Y-m-d'));
                                        $date2=date_create($EXn->et_due_date);
                                        $diff=date_diff($date1,$date2);
                                        ?>
                                        @if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && $EXn->et_bil_status!="Paid" )
                                        <span title='overdue' style='color:red;'>{{$EXn->et_due_date!=""? date('m-d-Y',strtotime($EXn->et_due_date)) : ""}}</span>

                                        @else
                                        {{$EXn->et_due_date!=""? date('m-d-Y',strtotime($EXn->et_due_date)) : ""}}
                                        @endif
                                    @endif
                                    
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                    <?php
                                    $BillTotalAmount=0;
                                    ?>
                                    @foreach ($ETANew as $ETAn)
                                        @if ($ETAn->et_ad_no==$EXn->et_no)
                                            <?php
                                            $BillTotalAmount+=$ETAn->et_ad_total;
                                            ?>
                                            @foreach ($COA as $coa)
                                                @if ($coa->id==$ETAn->et_ad_product)
                                                {{$coa->coa_name}}  <br>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                   
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">{{$EXn->et_memo}}</td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                     {{number_format($BillTotalAmount,2)}}
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                    Pending
                                </td>
                            </tr>
                        @endforeach
                            
                            </tbody>
                            <!-- This is our clonable table line -->
                        </table>
                        <table id="expensetable" class="table table-bordered table-responsive-md table-striped text-center font14">
                            <tr>
                                <td class="pt-3-half" style="vertical-align:middle;" contenteditable="false"></td>
                                <td class="pt-3-half" style="vertical-align:middle;" contenteditable="false"></td>
                                <th class="pt-3-half" style="vertical-align:middle;" contenteditable="false">TOTAL: </th>
                                <td class="pt-3-half" style="vertical-align:middle;" contenteditable="false"></td>
                                <td class="pt-3-half" style="vertical-align:middle;" contenteditable="false"></td>
                                <td class="pt-3-half" style="vertical-align:middle;" contenteditable="false"></td>
                                <th class="pt-3-half" style="vertical-align:middle;" contenteditable="false">PHP {{number_format($totalexp,2)}}
                                </th>
                                <td></td>
                            </tr>
                        </table>
                        <div class="col-md-12 p-0">
                            <h3 class="float-left">Bill Payments</h3>
                        </div>
                        <table id="bill_payment_table" class="table table-bordered table-responsive-md table-striped text-center font14">
                            <thead >
                                <tr>
                                    <th style="vertical-align:middle;">#</th>
                                    <th style="vertical-align:middle;">Date</th>
                                    <th style="vertical-align:middle;">Bill #</th>
                                    <th style="vertical-align:middle;">RF</th>
                                    <th style="vertical-align:middle;">PO</th>
                                    <th style="vertical-align:middle;">CI</th>
                                    <th style="vertical-align:middle;">Payment Amount</th>
                                    <th style="vertical-align:middle;"></th>
                                    <th style="vertical-align:middle;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($PayBill as $pb)
                                    <tr>
                                        <td style="vertical-align:middle;">{{$pb->pay_bill_no}}</td>
                                        <td style="vertical-align:middle;">{{date('m-d-Y',strtotime($pb->payment_date))}}</td>
                                        <td style="vertical-align:middle;">{{$pb->bill_no}}</td>
                                        <td style="vertical-align:middle;">
                                            @foreach ($expense_transaction_logs as $etl)
                                                @if ($etl->et_no==$pb->bill_no && $etl->et_type=="Bill")
                                                {{$etl->et_shipping_address}}
                                                <?php
                                                break;
                                                ?>
                                                @endif  
                                            @endforeach
                                            
                                        </td>
                                        <td style="vertical-align:middle;">
                                            @foreach ($expense_transaction_logs as $etl)
                                                @if ($etl->et_no==$pb->bill_no && $etl->et_type=="Bill")
                                                {{$etl->et_shipping_to}}
                                                <?php
                                                break;
                                                ?>
                                                @endif  
                                            @endforeach
                                        </td>
                                        <td style="vertical-align:middle;">
                                            @foreach ($expense_transaction_logs as $etl)
                                                @if ($etl->et_no==$pb->bill_no && $etl->et_type=="Bill")
                                                {{$etl->et_shipping_via}}
                                                <?php
                                                break;
                                                ?>
                                                @endif  
                                            @endforeach
                                        </td>
                                        <td style="vertical-align:middle;text-align:right">{{number_format($pb->bill_payment_amount,2)}}</td>
                                        <td style="vertical-align:middle;">
                                            <textarea placeholder="add remarks" onblur="add_note_to_bill_payment(this,'{{$pb->pay_bill_no}}')" name="pay_bills_remarks_in_list" id="pay_bills_remarks_in_list" >{{$pb->payment_remark}}</textarea>
                                            
                                        </td>
                                        <td style="vertical-align:middle;">
                                            <?php
                                            $avaiablevoucher=0;
                                            ?>
                                            @foreach($Voucher as $VV)
                                            @if ($VV->voucher_link_id==$pb->pay_bill_no)
                                            <?php
                                            $avaiablevoucher=1;
                                            ?>
                                            @endif
                                            @endforeach
                                            
                                            @if ($avaiablevoucher=='1')
                                                <a href="#" onclick="setVoucherContent('{{$pb->pay_bill_no}}')" class="btn btn-link" data-toggle="modal" data-target="#vouchermodal">View Voucher</a>
                                              
                                            @else
 
                                            @endif
                                        </td>
                                        
                                    </tr> 
                                @endforeach
                                
                            </tbody>
                        </table>
                        <script>
                            function add_note_to_bill_payment(element,id){
                                $.ajax({
                                    type: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: '{{ route('update_pay_bill_note') }}',                
                                    data: {id:id,note:element.value,_token: '{{csrf_token()}}'},
                                success: function(data) {
                                    if(data==1){
                                        swal({title: "Done!", text: "Bill Payment Remark updated.", type: 
                                            "success"}).then(function(){
                                            
                                            }
                                            );
                                    }
                                    else if(data==0){
                                        swal({title: "Error!", text: "Failed to update Bill Payment Remark.", type: 
                                            "success"}).then(function(){ 
                                            
                                            }
                                            );
                                    }
                                                    
                                }
                                });
                            }
                        </script>
                    </div>
                    <div class="modal fade" id="staticModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticModalLabel">Add yeah Rule</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12 d-inline-flex">
                                        <div class="col-md-6 w-100">
                                            <div class="padding0">
                                                <p class="float-left text-center">Rule Name</p>
                                                <input name="rulename" type="text" class="float-right w-100">
                                            </div>
                                        </div>
                                        <div class="col-md-3 w-100">
                                            <div class="padding0">
                                                <p>For</p>
                                                <select class="w-100">
                                                    <option>Money out</option>
                                                    <option>Money in</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 w-100">
                                            <div class="padding0">
                                                <p>In</p>
                                                <select class="w-100">
                                                    <option>All Bank Accounts</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 pt-3">
                                        <div class="col-md-12">
                                            <div class="d-inline-flex">
                                                <p>When a transaction meets </p>
                                                <select>
                                                    <option>all</option>
                                                    <option>any</option>
                                                </select>
                                                <p>of these conditions.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-inline pt-1">
                                        <div class="col-md-3 w-100">
                                            <div class="padding0">
                                                <select class="w-100">
                                                    <option>Bank Text</option>
                                                    <option>Description</option>
                                                    <option>Amount</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 w-100">
                                            <div class="padding0">
                                                <select class="w-100">
                                                    <option>Contains</option>
                                                    <option>Does not contain</option>
                                                    <option>Is Exactly</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 w-100">
                                            <div class="padding0">
                                                <input name="rulename" type="text" class="float-right w-100">
                                            </div>
                                        </div>
                                        <div class="col-md-12"><button class="btn btn-success">Add Line</button></div>
                                    </div>
                                    <div class="col-md-12 d-inline-flex pt-3">
                                        <div class="col-md-4 w-100">
                                            <div class="padding0">
                                                <p>Transaction Type</p>
                                                <select class="w-100">
                                                    <option>Expense</option>
                                                    <option>Cheque</option>
                                                    <option>Transfer</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 w-100">
                                            <div class="padding0">
                                                <p>Payee</p>
                                                <select class="w-100">
                                                    <option>Money out</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 w-100">
                                            <div class="padding0">
                                                <p>Category</p>
                                                <select class="w-100">
                                                    <option>All Bank Accounts</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 pt-2">
                                        <div class="col-md-12">
                                            <button class="btn btn-success">Split</button>
                                            <p>Memo</p>
                                            <input name="rulename" type="text" class="w-50"> <br>
                                            <input type="checkbox">Automatically add to my books
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- ======================================================================================================== SECOND TAB--> 
                <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h3 class="mt-2">Suppliers</h3>
    <div class="modal fade" id="ImportSupplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Suppliers</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="text-align:center;">
            <style>
            #excel-upload-supplier{
				display: none;
			}
            </style>
            <input id="excel-upload-supplier" onchange="UploadMassSupplier()" type="file"  accept=".xlsx" >
            <label for="excel-upload-supplier" style="opacity:1;cursor:pointer;border-radius:10px;" id="FIleImportExcelLabel" class="custom-excel-upload btn btn-primary">
            <span class="glyphicon glyphicon-user"></span> IMPORT FROM EXCEL</span>
            </label>
            <script>
                    function UploadMassSupplier(){
                        document.getElementById('import_overlay').style.display="block";
                        var file = $('#excel-upload-supplier')[0].files[0]
                        var fd = new FormData();
                        fd.append('theFile', file);
                        fd.append('_token','{{csrf_token()}}');
                        $.ajax({
                            url: 'UploadMassSupplier',
                            type: 'POST',
                            processData: false,
                            contentType: false,
                            data: fd,
                            dataType:"json",
                            success: function (data, status, jqxhr) {
                            //alert(data.Success);
                            console.log(data.Extra);
                            var LOG="";
                            if(data.Error_Log!=""){
                            LOG=" \n\nSkip Log : \n"+data.Error_Log;
                            }
                            alert("Total number Of Data : "+data.Total+"\nData Saved : "+data.Success+" \nData Skipped : "+data.Skiped+LOG);
                            document.getElementById("excel-upload-supplier").value = "";
                            document.getElementById('import_overlay').style.display="none";
                            location.reload();
                            },
                            error: function (jqxhr, status, msg) {
                            //error code
                            alert(jqxhr.status +" message"+msg+" status:"+status);
                            alert(jqxhr.responseText);
                            document.getElementById('import_overlay').style.display="none";
                            }
                        });
                        document.getElementById("excel-upload-supplier").value = "";
                        //location.reload();
                    }
                </script>
        </div>
        <div class="modal-footer">
            <a class="btn btn-success" href="GetSupplierTemplateExcel">Download Excel Template</a>
        </div>
        </div>
    </div>
    </div>
                    <div class="col-md-12 mb-5 p-0 mt-3">
                        <a href="#" class="btn btn-success"data-target='#supplierModal' data-toggle="modal">New Supplier</a>
                        <a href="#" class="btn btn-success"data-target='#ImportSupplierModal' data-toggle="modal">Import Supplier</a>
                        
                    </div>
    
                    
    
                    <div class="col-md-12 text-white p-0 mb-5">
                        <div class="col-md-4 bg-blue pb-0">
                            <h3>PHP0</h3>
                            <p class="font14">0 PURCHASE ORDER</p>
                        </div>
                        <div class="col-md-2 bg-orange">
                            <h3>PHP0</h3>
                            <p class="font14">0 OVERDUE</p>
                        </div>
                        <div class="col-md-2 bg-secondary">
                            <h3>PHP0</h3>
                            <p class="font14">0 OPEN</p>
                        </div>
                        <div class="col-md-4 bg-ltgreen">
                            <h3>PHP0</h3>
                            <p class="font14">0 PAID LAST 30 DAYS</p>
                        </div>
                    </div>
    
                    <div id="table" class="table-editable">
                        <!-- Button trigger modal -->
                        
                        <table id="suppliertable" class="table table-bordered table-responsive-md table-striped text-center font14">
                            <thead>
                            <tr>
                                
                                <th class="text-center">SUPPLIER/COMPANY</th>
                                <th class="text-center">PHONE</th>
                                <th class="text-center">EMAIL</th>
                                <th class="text-center">OPEN BALANCE</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($supplierss)>0)
                                @foreach($supplierss as $customer)
                                
                                <tr>
                                        
                                    <td class="pt-3-half" style="vertical-align:middle;text-align:left;" contenteditable="false"><a class="text-info" href="get_supplier/?supplier_id={{$customer->customer_id}}">{{$customer->company!=""? $customer->company : ($customer->display_name!=""? $customer->display_name : $customer->f_name." ".$customer->l_name ) }}</a></td>
                                    <td class="pt-3-half" style="vertical-align:middle;" contenteditable="false">{{$customer->phone}}</td>
                                    <td class="pt-3-half" style="vertical-align:middle;" contenteditable="false">{{$customer->email}}</td>
                                    <td class="pt-3-half" style="vertical-align:middle;" contenteditable="false">PHP {{number_format($customer->opening_balance)}}</td>
                                    
                                </tr>
                                
                                @endforeach
                            @endif
                                </tbody>
                            <!-- This is our clonable table line -->
                        </table>
                        
                    </div>
                    
                </div>
            </div>
            <!-- end of card -->
        </div>
        </div>
        </div>
@endsection