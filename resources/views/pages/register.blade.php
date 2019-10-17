@extends('layout.initial')


@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Deposited Funds</h1>
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    <script>
        function FilterTableRowDate(index,element) {
        // Declare variables 
        var input, filter, table, tr, td, i;
        input = element;
        filter = input.value.toUpperCase();
        table = document.getElementById("check_register_table_body");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            console.log(td);
            td = tr[i].getElementsByTagName("td")[index];    
            if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1 ) {
                tr[i].style.display = "";
               
               
            } else{
                tr[i].style.display = "none";
               
            }
            }
            
        }
        }
        function submitdates(){
            
            var FROM= document.getElementById('Fromdate').value;
            var TO= document.getElementById('Todate').value;
            var CostCenterFilter = document.getElementById('CostCenterFilter').value;
            console.log(FROM+" "+TO);
            
            //window.location.replace("/Invoice_List?date_from="+FROM+"&date_to="+TO);
            $.ajax({
                type: 'POST',
                url: 'GetTotalDeposited',                
                data: {CostCenterFilter:CostCenterFilter,FROM:FROM,TO:TO,_token: '{{csrf_token()}}'},
                success: function(data) {
                    console.log(data);
                    document.getElementById('TotalDepositedFundH4').innerHTML="PHP "+number_format(data,2);
                } 											 
            });
            
        }
        
    </script>
<div class="row">
    <div class="col-md-6">
    </div>
    <div class="col-md-6">
        <div class="alert alert-secondary" role="alert">
        <h4 class="alert-heading"></h4>
        <div class="row">
        <div class="col-md-4">
            <p>From</p>
            <input type="date"  class="form-control form-control-sm" id="Fromdate" oninput="submitdates()" onkeyup="submitdates()" >
        </div>
        <div class="col-md-4">
            <p>To</p>
            <input type="date" class="form-control form-control-sm" id="Todate"  oninput="submitdates()" onkeyup="submitdates()">
        </div>
        <div class="col-md-4">
            <p>Cost Center</p>
            <select class="form-control form-control-sm" id="CostCenterFilter" onchange="submitdates()">
                <option>All</option>    
                @foreach($all_cost_center_list as $lists)
                <option value="{{$lists->cc_no}}">{{$lists->cc_name}}</option>
                @endforeach
            </select>
        </div>
        </div>
        <hr>
        <p>Total Deposited Fund</p>
        <?php
            $totaldepositedssasdsad=0;
            ?>
        @foreach ($SS as $st)
                @if($st->st_type=="Sales Receipt" && $st->st_action=="Deposited" && $st->remark=="")
                <?php
                $totaldepositedssasdsad+=$st->st_amount_paid;
                ?>
                @endif
        @endforeach
        <h4 class="mb-0" id="TotalDepositedFundH4">PHP {{number_format($totaldepositedssasdsad,2)}}</h4>
        </div>
    </div>
</div>
<table class="table table-bordered table-sm table-striped" style="background-color:white" id="check_register_table">
    <thead>
        <tr>
            <th width="10%" style="vertical-align:middle;text-align:center;">
                <input style="width:100%;" type="text" id="date_filter_input" onkeyup="FilterTableRowDate(0,this)" placeholder="Date"></th>
            <th width="10%" style="vertical-align:middle;">
                <input style="width:100%;" type="text" id="no_filter_input" placeholder="Cost Center" onkeyup="FilterTableRowDate(1,this)"></th>
            <th width="10%" style="vertical-align:middle;">
                <input style="width:100%;" type="text" id="no_filter_input" placeholder="Sales Receipt" onkeyup="FilterTableRowDate(2,this)"></th>
            <th width="10%" style="vertical-align:middle;text-align:center;" >
                <input style="width:100%;" type="text" id="payee_filter_input" onkeyup="FilterTableRowDate(3,this)" placeholder="Payee"></th>
            <th width="10%" style="vertical-align:middle;">
                <input style="width:100%;" type="text" id="no_filter_input" placeholder="Payment Method" onkeyup="FilterTableRowDate(4,this)"></th>
            
            
            
            <th width="10%" style="vertical-align:middle;text-align:center;">
                <input style="width:100%;" type="text" id="bankaccount_filter_input" onkeyup="FilterTableRowDate(5,this)" placeholder="Bank"></th>
            <th width="10%" style="vertical-align:middle;text-align:center;">
                <input style="width:100%;" type="text" id="balance_filter_input" onkeyup="FilterTableRowDate(6,this)" placeholder="Check No"></th>
            <th width="10%"  style="vertical-align:middle;text-align:center;">
                <input style="width:100%;" type="text" id="payment_filter_input" onkeyup="FilterTableRowDate(7,this)" placeholder="Amount"></th>
            <th width="20%" style="vertical-align:middle;">
                <input style="width:100%;" type="text" id="no_filter_input" placeholder="Deposited To" onkeyup="FilterTableRowDate(8,this)"></th>
        </tr>
        
    </thead>
    <tbody id="check_register_table_body">
            <?php
            $deposit_record_count=0;
            ?>
            @foreach ($SS as $st)
                @if($st->st_type=="Sales Receipt" && $st->st_action=="Deposited" && $st->remark=="")
                
                <tr>
                    <td class="pt-3-half" contenteditable="false">
                    @foreach ($deposit_records as $dr)
                        @if ($dr->deposit_record_transaction_no==$st->st_no)
                            {{date('m-d-Y',strtotime($dr->deposit_record_date))}}
                        @endif
                    @endforeach
                    </td>
                    
                    <td class="pt-3-half" contenteditable="false">
                        @foreach ($JournalEntry as $JE)
                            @if ($JE->other_no==$st->st_no && $JE->je_id=="1")
                            @foreach ($cost_center_list as $ccl)
                                @if ($ccl->cc_no==$JE->je_cost_center)
                                {{$ccl->cc_name}}
                                @endif
                            @endforeach
                                
                            @endif
                        @endforeach
                        
                    </td>
                    
                    <td class="pt-3-half" contenteditable="false">{{$st->st_no}}</td>
                    
                    <td class="pt-3-half" contenteditable="false">
                        @foreach ($customers as $cus)
                            @if($cus->customer_id==$st->st_customer_id)
                                @if($cus->display_name!="")
                                    {{$cus->display_name}}
                                @else

                                {{$cus->f_name." ".$cus->l_name}}
                                @endif
                            @endif
                        @endforeach
                    </td>
                    <td class="pt-3-half" contenteditable="false">
                        @foreach ($ST_SR as $invoice)
                            @if($invoice->st_s_no==$st->st_no)
                                {{$invoice->st_p_method}}
                                <?php
                                break;
                                ?>
                            @endif
                        @endforeach
                    </td>
                    <td class="pt-3-half" contenteditable="false">
                        
                        @foreach ($ST_SR as $invoice)
                            @if($invoice->st_p_method=="Cheque")
                            @if($invoice->st_s_no==$st->st_no)
                                
                                @foreach ($banks as $ba)
                                    @if ($ba->bank_no==$invoice->st_p_reference_no)
                                    {{$ba->bank_name}}
                                    @endif
                                @endforeach
                                <?php
                                break;
                                ?>
                            @endif
                            @endif
                        @endforeach
                    </td>
                    
                    <td class="pt-3-half" contenteditable="false">
                        @foreach ($ST_SR as $invoice)
                            @if($invoice->st_p_method=="Cheque")
                            @if($invoice->st_s_no==$st->st_no)
                                {{$invoice->st_p_deposit_to}}
                                <?php
                                break;
                                ?>
                            @endif
                            @endif
                        @endforeach
                    </td>
                    <td class="pt-3-half" style="text-align:right;vertical-align:middle;" contenteditable="false" title='{{$st->st_amount_paid}}'>PHP {{number_format($st->st_amount_paid,2)}}</td>
                    <td class="pt-3-half" contenteditable="false">
                        @foreach ($deposit_records as $dr)
                        @if ($dr->deposit_record_transaction_no==$st->st_no)
                            @foreach ($banks as $bank)
                                @if ($bank->bank_no==$dr->deposit_to)
                                    {{$bank->bank_name." - ".$bank->bank_account_no}}
                                    <?php
                                    break;
                                    ?>
                                @endif
                            @endforeach
                        @endif
                        @endforeach
                    </td>
                    
                </tr>
                @endif
            @endforeach
    </tbody>
</table>

</div>
@endsection