
<?php
    $customers_list_after_foreach='';
    $cc_list_after_foreach='';
?>
@foreach($customers as $customer)
<?php
//$customers_list_after_foreach.="<option title='".$customer->account_type."' value='".$customer->customer_id."'>".($customer->display_name!=''? $customer->display_name : $customer->f_name.' '.$customer->l_name)."</option>"
?>
<?php
$customers_list_after_foreach.="<option  value='".$customer->customer_id."'>".($customer->display_name!=''? $customer->display_name : $customer->f_name.' '.$customer->l_name)."</option>"
?>
@endforeach
@foreach ($cost_center_list as $list)
<?php
$cc_list_after_foreach.="<option  value='".$list->cc_no."'>".$list->cc_name."</option>";
?>
@endforeach
<script>
//preg_replace( "/\r|\n/", "", $coa->coa_name )

var product_list_js='@foreach($products_and_services as $product)<option value="{{$product->product_id}}">{{$product->product_name}}</option>@endforeach';
var coa_list_js='@foreach($COA as $coa)<option value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>@endforeach';
var coa_list2_js='@foreach($COA as $coa)<option title="{{$coa->coa_account_type}}" value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>@endforeach';
 function ResetBills(){
     document.getElementById('clear_lines_bill_account2').click();
 }
 </script>
<script>
    $(document).ready(function(){
        @if(!empty($company_setting))
        $('#report_employee_companynameheader').html('{{$company_setting->company_name}}');
        @else
        $('#report_employee_companynameheader').html('');
        @endif
    })
        function cancelentry(type,id,locationss,invoice_type){
            var Reason = prompt("Reason for Cancellation of Entry", "");

            if (Reason != null) {
                $.ajax({
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('cancel_entry') }}",
                dataType: "text",
                data: {locationss:locationss,invoice_type:invoice_type,Reason:Reason,id:id,type:type,_token: '{{csrf_token()}}'},
                success: function (data) {
                    alert(data);
                    location.reload();
                },
                error: function (data) {
                    alert(data.responseText);
                }
                });
            }else{
                alert('Action Cancelled');
            }
            
           
        }
    </script>
<style>
.modal {
  overflow-y:auto;
}
</style>
<div class="loading" id="import_overlay">
Loading&#8230;
</div>

<script type="text/javascript">
$(document).ready(function(){
	document.getElementById('import_overlay').style.display="none";
});
var idleTime = 0;
var Timout = 100;
$.ajax({
type: 'POST',
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
url: '{{ route('getSessionTimeout') }}',
data: {_token: '{{csrf_token()}}'},
success: function(data) {
    if(data==1){
        Timout = 1*60;
    }
    else if(data==2){
        Timout = 2*60;
    }
    else if(data==3){
        Timout = 3*60;
    }
    else if(data==15){
        Timout = 15;
    }
    else if(data==30){
        Timout = 30;
    }
    else if(data==45){
        Timout = 45;
    }
}
})

$(document).ready(function () {
    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});
function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("#tablemain tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}
function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}
function timerIncrement() {
    idleTime = idleTime + 1;
    console.log(Timout+" "+idleTime);
    if (idleTime > Timout) { // 20 minutes
        document.getElementById('logout-form').submit();
    }
}
function BudgetGet(){
    document.getElementById('import_overlay').style.display="block";
    $('.budget_tr').remove();
    var Year=document.getElementById('BudgetYear').value;
    if(Year!=""){
        document.getElementById('BudgetMainBody').style.display="block";
    }else{
        document.getElementById('BudgetMainBody').style.display="none";
    }
    $.ajax({
    type: 'POST',
    url: 'GetCostCenterBudget',                
    data: {Year:Year,_token: '{{csrf_token()}}'},
    success: function(data) {
        
        var length=data.length;
        
        var count=0;
        
         
    } 											 
    });
    document.getElementById('import_overlay').style.display="none";
}
$(document).ready(function(){
    //BudgetGet();
})
function formatvalue(index){
    var value=document.getElementById('cc_budget'+index).value;
    document.getElementById('formattedbudget'+index).innerHTML="Php "+number_format(value,2);
}
function SaveBudget(){
    document.getElementById('import_overlay').style.display="block";
    var budgetcolumncount=document.getElementById('budgetcolumncount').value;
    var BudgetYear=document.getElementById('BudgetYear').value;
    
    var cost_center_budget = [];
    for(var a=1;a<=budgetcolumncount;a++){
        cost_center_budget.push({'cc_no':document.getElementById('cc_no'+a).value,'budget_amount':document.getElementById('cc_budget'+a).value,'budget_no':document.getElementById('budget_no'+a).value});

    }
    $.ajax({
        type: 'POST',
        url: 'SaveBudget',   
        data: {cost_center_budget:cost_center_budget,BudgetYear:BudgetYear,_token: '{{csrf_token()}}'},
        success: function(data) {
            swal({title: "Done!", text:"Successfully Saved Budget", type: 
            "success"}).then(function(){
            document.getElementById('import_overlay').style.display="none";
            location.reload();                                    
            });
        } 											 
    });
}
function destroy_select_picker(clas){
    document.getElementById('destroyselectpickerbutton').setAttribute('data-class',clas);
    document.getElementById('destroyselectpickerbutton').click();
}
function open_modal_dyna(id){
    document.getElementById('openmodalbtndynamically').setAttribute('data-id',id);
    document.getElementById('openmodalbtndynamically').click();
}
function render_select_picker(){
    document.getElementById('renderselectpickerbutton').click();
}
var wb;
var wbout;
$(document).ready(function(){
    
    
})
    
        function s2ab(s) {
                        var buf = new ArrayBuffer(s.length);
                        var view = new Uint8Array(buf);
                        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                        return buf;
        }
        
function exporttoexcel(table_id){
    //document.getElementById('exporttoexcelbtn').setAttribute('data-table',table_id);
   // document.getElementById('exporttoexcelbtn').click();
   if(document.getElementById("tablemain")){
        wb = XLSX.utils.table_to_book(document.getElementById("tablemain"), {sheet:"Sheet JS"});
        wbout = XLSX.write(wb, {bookType:'xlsx', bookSST:true, type: 'binary'});
    }
   saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), document.getElementById('report_employee_title').innerHTML+' Report {{date("m-d-Y")}} .xlsx');
		// var table2excel = new Table2Excel();
        //     table2excel.export(document.getElementById(table_id),"Report {{date('m-d-Y')}}");
            
          
}
    function exporttoexcelprofitandloss(){
        console.log('export excel journal entries');
        var filtertemplate= document.getElementById('filtertemplate').value;
        var CostCenterFilter = document.getElementById('CostCenterFilter').value;
        var FROM= document.getElementById('Fromdate').value;
        var TO= document.getElementById('Todate').value;
        url="export_profitandloss?CostCenterFilter="+CostCenterFilter+"&filtertemplate="+filtertemplate+"&FROM="+FROM+"&TO="+TO;
        location.href=url;
        
    }
    function exporttoexcelprofitandlossaspercent(){
        console.log('export excel journal entries');
        var filtertemplate= document.getElementById('filtertemplate').value;
        var CostCenterFilter = document.getElementById('CostCenterFilter').value;
        var FROM= document.getElementById('Fromdate').value;
        var TO= document.getElementById('Todate').value;
        url="export_profitandlossaspercent?CostCenterFilter="+CostCenterFilter+"&filtertemplate="+filtertemplate+"&FROM="+FROM+"&TO="+TO;
        location.href=url;
        
    }
    function exporttoexcelprofitandlossquarterly(){
        console.log('export excel journal entries');
        var filtertemplate= document.getElementById('filtertemplate').value;
        var CostCenterFilter = document.getElementById('CostCenterFilter').value;
        var FROM= document.getElementById('Fromdate').value;
        var TO= document.getElementById('Todate').value;
        url="export_profitandlossquarterly?CostCenterFilter="+CostCenterFilter+"&filtertemplate="+filtertemplate+"&FROM="+FROM+"&TO="+TO;
        location.href=url;
    }
    function exporttoexcelprofitandlossbycustomer(){
        console.log('export excel journal entries');
        var filtertemplate= document.getElementById('filtertemplate').value;
        var CostCenterFilter = document.getElementById('CostCenterFilter').value;
        var FROM= document.getElementById('Fromdate').value;
        var TO= document.getElementById('Todate').value;
        url="exporttoexcelprofitandlossbycustomer?CostCenterFilter="+CostCenterFilter+"&filtertemplate="+filtertemplate+"&FROM="+FROM+"&TO="+TO;
        location.href=url;
    }
    function exporttoexcelprofitandlossbymonth(){
        console.log('export excel journal entries');
        var filtertemplate= document.getElementById('filtertemplate').value;
        var CostCenterFilter = document.getElementById('CostCenterFilter').value;
        var FROM= document.getElementById('Fromdate').value;
        var TO= document.getElementById('Todate').value;
        url="exporttoexcelprofitandlossbymonth?CostCenterFilter="+CostCenterFilter+"&filtertemplate="+filtertemplate+"&FROM="+FROM+"&TO="+TO;
        location.href=url;
    }
    
    function export_profitandlosscomparison(){
        console.log('export excel journal entries');
        var filtertemplate= document.getElementById('filtertemplate').value;
        var CostCenterFilter = document.getElementById('CostCenterFilter').value;
        var FROM= document.getElementById('Fromdate').value;
        var TO= document.getElementById('Todate').value;
        url="export_profitandlosscomparison?CostCenterFilter="+CostCenterFilter+"&filtertemplate="+filtertemplate+"&FROM="+FROM+"&TO="+TO;
        location.href=url;
    }
    
    function exporttoexceltrial_balance(){
        console.log('export excel journal entries');
        var filtertemplate= document.getElementById('filtertemplate').value;
        var CostCenterFilter = document.getElementById('CostCenterFilter').value;
        var FROM= document.getElementById('Fromdate').value;
        var TO= document.getElementById('Todate').value;
        url="export_trial_balance?CostCenterFilter="+CostCenterFilter+"&filtertemplate="+filtertemplate+"&FROM="+FROM+"&TO="+TO;
        location.href=url;
    }
    function exporttoexcelTaxRelief(){
        console.log('export excel journal entries');
        var filtertemplate= document.getElementById('filtertemplate').value;
        var CostCenterFilter = document.getElementById('CostCenterFilter').value;
        var FROM= document.getElementById('Fromdate').value;
        var TO= document.getElementById('Todate').value;
        url="exporttoexcelTaxRelief?CostCenterFilter="+CostCenterFilter+"&filtertemplate="+filtertemplate+"&FROM="+FROM+"&TO="+TO;
        location.href=url;
    }
    function exporttoexcelnew(){
        console.log('export excel journal entries');
        var filtertemplate= document.getElementById('filtertemplate').value;
        var CostCenterFilter = document.getElementById('CostCenterFilter').value;
        var FROM= document.getElementById('Fromdate').value;
        var TO= document.getElementById('Todate').value;
        url="export_test?CostCenterFilter="+CostCenterFilter+"&filtertemplate="+filtertemplate+"&FROM="+FROM+"&TO="+TO;
        location.href=url;
        // $.ajax({
        //     type: 'POST',
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     url: 'export_test',                
        //     data: {CostCenterFilter:CostCenterFilter,filtertemplate:filtertemplate,FROM:FROM,TO:TO,type:type,_token: '{{csrf_token()}}'},
        //     success: function(data) {
                
        //     } ,
        //     error: function (xhr, ajaxOptions, thrownError) {
        //         alert(xhr.responseText);
        //         alert(thrownError);
        //     }
        // })
    }
</script> 
<style>
        #AddBudgetModal{
            padding-right:0px !important;
        }
</style>
<!-- Modal -->

<button style="display:none" id="exporttoexcelbtn" data-table="tablemain">asd</button>
<button style="display:none" id="openmodalbtndynamically" data-id="">asd</button>
<button style="display:none" id="destroyselectpickerbutton" data-class="selectpicker">asd</button>
<button style="display:none;" id="renderselectpickerbutton">asd</button>
<div class="modal fade" id="AddBudgetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog" role="document" style="margin:0px;width:100%;max-width:100%;">
        <div class="modal-content" style="min-height: 100vh;">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Budget</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
           <div class="col-md-3">
            <input type="hidden" id="budgetcolumncount">
            <select class="form-control" onchange="BudgetGet()" id="BudgetYear">
            <option value="">--Select Year--</option>
            <?php
            for($i=date('Y');$i>2011;$i--){
            ?>
            <option>{{$i}}</option>   
            <?php
            }
            ?>
            </select>
           </div>
           <div class="col-md-9">

           </div>
           <div class="col-md-12" id="BudgetMainBody">
               <?php
                $cost_centercount=0;
               ?>
                <table class="table">
                <thead>
                    <tr>
                        <th style="vetical-align:middle;border-top:0px solid #ccc;"></th>
                        <th width="30%" style="vetical-align:middle;border-top:0px solid #ccc;"></th>
                        <th width="30%" style="vetical-align:middle;border-top:0px solid #ccc;"></th>
                        <th width="30%" style="vetical-align:middle;border-top:0px solid #ccc;"></th>
                    </tr>
                </thead>
                <tbody id="budgetcostcentertablelist">
                
                </tbody>
               </table>
           </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="SaveBudget()">Save</button>
        </div>
        </div>
</div>
</div>
<div class="modal fade p-0" id="vouchermodal" tabindex="-1" role="dialog" aria-labelledby="staticModalsLabel" aria-hidden="true" data-backdrop="static">
        <script>
        var columncount=1;
        var columncountjournaentry=1;
        function setVoucherContent(bill_id){
            var Parent = document.getElementById('tbodyvouchertransaction');
            while(Parent.hasChildNodes())
            {
            Parent.removeChild(Parent.firstChild);
            }
            var Parent = document.getElementById('tbodyjournlaentry');
            while(Parent.hasChildNodes())
            {
            Parent.removeChild(Parent.firstChild);
            }
            @foreach($Voucher as $VV)
            
                if('{{$VV->voucher_link_id}}'==bill_id){
                    
                    document.getElementById('vouchertype').value='{{$VV->voucher_type}}';
                    changevoucher('{{$VV->voucher_type}}');
                    document.getElementById('PaytoOrderof').value='{{$VV->pay_to_order_of}}';
                    document.getElementById('VoucherNo').value='{{$VV->voucher_no}}';
                    document.getElementById('voucherdate').value='{{$VV->voucher_date}}';
                    document.getElementById('prepared_by').value='{{$user_position->name}}';
                    document.getElementById('PaymentByBank').value='{{$user_position->name}}';
                    var trid='transactiontr'+columncount;
                    var markup = '<tr id="transactiontr'+columncount+'">';
                    @foreach($VoucherTransaction as $VT)
                        if('{{$VT->voucher_ref_no}}'=='{{$VV->voucher_no}}'){
                            markup=markup+'<td style="vertical-align:middle;text-align:center;"><input onkeyup="addqty_amount('+columncount+')" oninput="addqty_amount('+columncount+')" disabled  type="number" style="text-align:center;"  min="1" class="form-control" id="qty'+columncount+'" value="{{$VT->tran_qty}}"></td>';
                            markup=markup+'<td style="vertical-align:middle;text-align:center;"><input disabled style="text-align:right;" onkeyup="addqty_amount('+columncount+')" oninput="addqty_amount('+columncount+')"  type="number" step="0.01" min="0"  value="{{$VT->tran_unit}}" class="form-control" id="unit'+columncount+'"></td>';
                            markup=markup+'<td style="vertical-align:middle;text-align:center;"><input disabled class="form-control" id="desc'+columncount+'" type="text" value="{{$VT->tran_explanation}}"></td>';
                            markup=markup+'<td colspan="2" style="vertical-align:middle;text-align:left;"><input style="text-align:right;" disabled type="number" value="{{$VT->tran_amount}}" class="form-control" readonly id="amount'+columncount+'"></td>';
                            markup=markup+'</tr>';
                            columncount++;
                            $("#tbodyvouchertransaction").append(markup);
                            calc();

                        }
                    @endforeach                          
                    @foreach($VoucherJournalEntry as $VJE)
                        if('{{$VJE->voucher_ref_no}}'=='{{$VV->voucher_no}}'){
                            var trid='transactiontrj'+columncountjournaentry;
                            var markup = '<tr id="transactiontrj'+columncountjournaentry+'">';                 
                            markup=markup+'<td style="vertical-align:middle;"><select type="text"  disabled class="form-control" id="accounttittle'+columncountjournaentry+'" ><option></option>'+coa_list2_js+'</select></td>';
                            
                            markup=markup+'<td style="vertical-align:middle;"><input disabled type="number" class="form-control" onkeyup="swap(\'credit\','+columncountjournaentry+')" id="debit'+columncountjournaentry+'" style="text-align:right;" value="{{$VJE->debit}}"></td>';
                            markup=markup+'<td style="vertical-align:middle;"><input disabled style="text-align:right;" type="number" class="form-control" onkeyup="swap(\'debit\','+columncountjournaentry+')" id="credit'+columncountjournaentry+'" value="{{$VJE->credit}}"></td>';
                            markup=markup+'</tr>';
                            
                            $("#tbodyjournlaentry").append(markup);
                            document.getElementById("accounttittle"+columncountjournaentry).value="{{$VJE->account_title}}";
                            columncountjournaentry++;
                        }
                    @endforeach
                }

            @endforeach
        }
        </script>
        <div class="modal-dialog modal-full" style="min-width:100%;margin:0">
                <div class="modal-content" >
                    
                    <div class="modal-body" id="voucherprintBody">
                        <div class="">
                            <div class="row">
                                    <div class="col-md-10">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" disabled id="vouchertype" onchange="changevoucher(this.value)">
                                        <option>Cheque Voucher</option>
                                        <option>Cash Voucher</option>
                                        </select>
                                        <?php
                                        $v_count_cheque=0;
                                        $v_count_cash=0;
                                        $cheque_start=0;
                                        $cash_start=0;
                                        $sales_exp_start_no=0;
                                        $main_bill_invoice_start=0;
                                        $branch_sales_invoice_start=0;
                                        $branch_bill_invoice_start=0;

                                        $credit_note_start_no=0;
                                        $sales_receipt_start_no=0;
                                        $bill_start_no=0;
                                        $suppliers_credit_start_no=0;
                                        $estimate_start_no=0;
                                        ?>
                                         @if(!empty($numbering))
                                         <?php
                                         $cheque_start=$numbering->cheque_voucher_start_no;
                                         $cash_start=$numbering->cash_voucher_start_no;
                                         $sales_exp_start_no=$numbering->sales_exp_start_no;
                                         $main_bill_invoice_start=$numbering->numbering_bill_invoice_main;
                                         $branch_sales_invoice_start=$numbering->numbering_sales_invoice_branch;
                                         $branch_bill_invoice_start=$numbering->numbering_bill_invoice_branch;

                                         $credit_note_start_no=$numbering->credit_note_start_no;
                                         $sales_receipt_start_no=$numbering->sales_receipt_start_no;
                                         $bill_start_no=$numbering->bill_start_no;
                                         $suppliers_credit_start_no=$numbering->suppliers_credit_start_no;
                                         $estimate_start_no=$numbering->estimate_start_no;
                                         ?>
                                         @endif
                                         <?php
                                         $v_count_cheque=$VoucherCheckCount;
                                         ?>
                                         <?php
                                         $v_count_cash=$VoucherCashCount;
                                         ?>
                                       
                                        <script>
                                            function changevoucher(e){
                                                if(e=="Cheque Voucher"){
                                                    document.getElementById('VoucherHeader').innerHTML="Cheque Voucher";
                                                    document.getElementById('TF1').innerHTML="Pay to the order of : ";
                                                    document.getElementById('TF2').innerHTML="Recieved From: ";
                                                    document.getElementById('BankTR').style.display="table-row";
                                                    document.getElementById('CheckNoTR').style.display="table-row";
                                                    
                                                   
                                                    document.getElementById('VoucherNo').value="{{$v_count_cheque+$cheque_start}}";
                                                }
                                                else if(e=="Cash Voucher"){
                                                    document.getElementById('VoucherHeader').innerHTML="Cash Voucher";
                                                    document.getElementById('TF1').innerHTML="Pay to the order of : ";
                                                    document.getElementById('TF2').innerHTML="Recieved From: ";
                                                    document.getElementById('BankTR').style.display="none";
                                                    document.getElementById('CheckNoTR').style.display="none";
                                                    
                                                    
                                                    document.getElementById('VoucherNo').value="{{$v_count_cash+$cash_start}}";
                                                }
                                            }
                                        </script>
                                    </div>
                            </div>
                            <br>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-sm" style="background-color:white;margin-bottom:0px;">
                                        <thead style="color:white;background-color:#262626">
                                            <tr>
                                                <th colspan="4" id="VoucherHeader" style="vertical-align:middle;text-align:center;">Check Voucher</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="30%" style="vertical-align:middle" id="TF1">Pay to the order of : </td>
                                                <td width="40%" style="vertical-align:middle"><select disabled class="form-control" id="PaytoOrderof">
                                                <option value="">--Select Name--</option>
                                                
                                                {!! $customers_list_after_foreach !!}
                                                </select>
                                                </td>
                                                <?php
                                                $v_count=0;
                                                ?>
                                                <?php
                                                $v_count=$VoucherCheckCount;
                                                ?>
                                                <td width="10%" style="vertical-align:middle">No. </td>
                                                <td width="20%" style="vertical-align:middle"><input type="text" class="form-control" id="VoucherNo" value="{{$v_count+$cheque_start}}" readonly></td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="vertical-align:middle" id="TF2">Recieved from: </td>
                                                <td width="40%" style="vertical-align:middle"><input type="text" value="{{!empty($company_setting)?$company_setting->company_name : ''}}" id="ReceivedFrom" list="chartofaccounts" class="form-control"></td>
                                                <td width="10%" style="vertical-align:middle">Date : </td>
                                                <td width="20%" style="vertical-align:middle"><input type="date" id="voucherdate" readonly value="<?php echo date('Y-m-d'); ?>" class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered table-sm" style="background-color:white;margin-bottom:0px;">
                                        <thead>
                                        
                                        <tr>
                                            <th width="5%" style="display:none;vertical-align:middle;text-align:center;"><button style="display:none;" class="btn btn-primary btn-sm" onclick="addtransactioncolumn()"><span class="fa fa-plus-circle"></span></button>
                                            <script>
                                                
                                                function addqty_amount(num){
                                                    var total=0;
                                                
                                                    var qty=document.getElementById('qty'+num).value;
                                                    var unit=document.getElementById('unit'+num).value;
                                                    total=qty*unit;
                                                    document.getElementById('amount'+num).value=total;
                                                    calc();

                                                }
                                                function calc(){
                                                    var Alltotal=0;
                                                    for(var a=1;a<=columncount;a++){
                                                        if(document.getElementById('amount'+a)){
                                                            Alltotal=Alltotal+parseFloat(document.getElementById('amount'+a).value);
                                                        }
                                                    }
                                                    document.getElementById('AllTotal').value=Alltotal;
                                                }
                                                function addtransactioncolumn(){
                                                    var trid='transactiontr'+columncount;
                                                    var markup = '<tr id="transactiontr'+columncount+'">';
                                                        
                                                        markup=markup+'<td style="vertical-align:middle;text-align:center;"><input onkeyup="addqty_amount('+columncount+')" oninput="addqty_amount('+columncount+')"  type="number"  min="1" class="form-control" id="qty'+columncount+'" value="1"></td>';
                                                        markup=markup+'<td style="vertical-align:middle;text-align:center;"><input onkeyup="addqty_amount('+columncount+')" oninput="addqty_amount('+columncount+')"  type="number" step="0.01" min="0"  value="0.00" class="form-control" id="unit'+columncount+'"></td>';
                                                        markup=markup+'<td style="vertical-align:middle;text-align:center;"><input class="form-control" id="desc'+columncount+'" type="text"></td>';
                                                        markup=markup+'<td colspan="2" style="vertical-align:middle;text-align:left;"><input type="number" value="0.00" class="form-control" readonly id="amount'+columncount+'"></td>';
                                                        markup=markup+'</tr>';
                                                        columncount++;
                                                    $("#tbodyvouchertransaction").append(markup);
                                                    calc();
                                                }
                                                
                                                function deleteRow(rowid) {
                                                    
                                                    document.getElementById('tbodyvouchertransaction').deleteRow(rowid-1)
                                                    // var row = document.getElementById(rowid);
                                                    // document.getElementById('tbodyvouchertransaction').removeChild(row);
                                                    calc();
                                                }
                                            </script>
                                            </th>
                                            <th width="10%" style="vertical-align:middle;text-align:center;">QTY.</th>
                                            <th width="10%" style="vertical-align:middle;text-align:center;">UNIT</th>
                                            <th width="45%" style="vertical-align:middle;text-align:center;">TRANSACTION DESCRIPTION</th>
                                            <th colspan="2" style="vertical-align:middle;text-align:center;">AMOUNT</th>
                                        </tr>
                                        
                                        </thead>
                                        <tbody id="tbodyvouchertransaction">
                                            
                                        </tbody>
                                        <tbody>
                                            <tr>
                                                <td colspan="3" style="vertical-align:middle;text-align:right;font-weight:bold;">TOTAL</td>
                                                <td width="30%" style="vertical-align:middle;"><input style="text-align:right;" type="number" class="form-control" id="AllTotal"  readonly></td>
                                            </tr>
                                            
                                        </tbody>    
                                    </table>
                                </div>
                            
                            </div>
                            <div class="row" id="distributionofaccount">
                                <div class="col-md-12" style="margin:10px 0px 10px 0px;">
                                    <h5>Distribution of Account:</h5>
                                </div>
                                <div class="col-md-7">
                                    <table class="table table-bordered table-sm" style="background-color:white;margin-bottom:0px;">
                                        <thead>
                                        <tr>
                                            <th width="10%" style="display:none;vertical-align:middle;text-align:center;">
                                                <button style="display:none;" class="btn btn-primary btn-sm" onclick="addcolumnJournalEntry()"><span class="fa fa-plus-circle"></span></button>
                                            </th>
                                            <script>
                                                
                                                function addcolumnJournalEntry(){
                                                    var trid='transactiontrj'+columncountjournaentry;
                                                    var markup = '<tr id="transactiontrj'+columncountjournaentry+'">';
                                                        
                                                        markup=markup+'<td style="vertical-align:middle;"><select type="text"  class="form-control" id="accounttittle'+columncountjournaentry+'" ><option></option>'+coa_list2_js+'</select></td>';
                                                        markup=markup+'<td style="vertical-align:middle;"><input type="number" class="form-control" onkeyup="swap(\'credit\','+columncountjournaentry+')" id="debit'+columncountjournaentry+'"></td>';
                                                        markup=markup+'<td style="vertical-align:middle;"><input type="number" class="form-control" onkeyup="swap(\'debit\','+columncountjournaentry+')" id="credit'+columncountjournaentry+'"></td>';
                                                        markup=markup+'</tr>';
                                                        columncountjournaentry++;
                                                    $("#tbodyjournlaentry").append(markup);
                                                }
                                                function swap(id,type){
                                                    
                                                    document.getElementById(id+type).value="";
                                                }
                                                function deleteRowjournalentry(rowid) {
                                                    
                                                    document.getElementById('tbodyjournlaentry').deleteRow(rowid-1)
                                                    // var row = document.getElementById(rowid);
                                                    // document.getElementById('tbodyvouchertransaction').removeChild(row);
                                                }
                                            </script>
                                            <th width="50%" style="vertical-align:middle;text-align:center;">ACCOUNT TITLE</th>
                                            <th width="20%" style="vertical-align:middle;text-align:center;">DEBIT</th>
                                            <th width="20%" style="vertical-align:middle;text-align:center;">CREDIT</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyjournlaentry">
                                            
                                        </tbody>
                                        
                                    </table>
                                </div>
                                <div class="col-md-5" style="padding-left:0px;">
                                    <table class="table  table-sm" style="background-color:white;margin-bottom:0px;">
                                        <tbody>
                                            <tr style="display:none;">
                                                <td  style="vertical-align:middle;">Received From</td>
                                                <td colspan="3"  style="vertical-align:middle;"><input type="text" id="ReceivedFromBank" class="form-control" value="N/A"></td>
                                            </tr>
                                            <tr style="display:none;">
                                                <td  style="vertical-align:middle;">the amount of</td>
                                                <td colspan="3"  style="vertical-align:middle;"><input type="text" id="amountofBank" value="N/A" class="form-control"></td>
                                            </tr>
                                            <tr id="BankTR">
                                                <td style="vertical-align:middle;">Bank</td>
                                                <td style="vertical-align:middle;"><input type="text" id="BankBank" class="form-control"></td>
                                            </tr>
                                            <tr id="CheckNoTR">
                                                <td  style="vertical-align:middle;">Cheque No.</td>
                                                <td  style="vertical-align:middle;"><input type="text" id="ChequeNoBank" class="form-control"></td>
                                            </tr>
                                            <tr style="display:none;">
                                                <td  style="vertical-align:middle;">For Previous Voucher</td>
                                                <td colspan="3"  style="vertical-align:middle;">
                                                    <input id="PreviousVoucher" list="PreviousVoucherNoList" type="text" class="form-control"></td>
                                                <datalist id="PreviousVoucherNoList">
                                                    @foreach ($VoucherCount as $vc)
                                                        <option value="{{$vc->voucher_id}}">{{$vc->voucher_type}}</option>
                                                    @endforeach
                                                </datalist>
                                            </tr>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                            <br>
                            <div class="row" style="">
                                <div class="col-md-12" >
                                    <table class="table  table-sm" style="background-color:white;margin-bottom:0px;">
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align:middle;">Prepared By :</td>
                                                <td style="vertical-align:middle;">Certified Correct By :</td>
                                                <td style="vertical-align:middle;">Received Payment By :</td>
                                                <td style="vertical-align:middle;">Approved By :</td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:middle;border-color:white;"><input type="text" id="prepared_by" class="form-control"></td>
                                                <td style="vertical-align:middle;border-color:white;"><input type="text" id="certified_correct_by" class="form-control"></td>
                                                <td style="vertical-align:middle;border-color:white;"><input id="PaymentByBank" type="text" class="form-control"></td>
                                                <td style="vertical-align:middle;border-color:white;"><input type="text" id="approved_by" class="form-control"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <div class="row" style="">
                                <div class="col-md-12" style="text-align:right;" id="buttondeivisionprinthide">
                                    <button data-dismiss="modal" aria-label="Close" style="display:none;" id="closevouchermodal">asd</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" >Close</button>
                                <button class="btn btn-primary" onclick="printReport()">Print</button>
                                        
                                </div>
                                <script type="text/javascript">
                                    function printReport()
                                    {
                                        document.getElementById('vouchertype').style.display="none";
                                        document.getElementById('buttondeivisionprinthide').style.display="none";
                                        
                                        window.print();
                                        document.getElementById('vouchertype').style.display="inline";
                                        document.getElementById('buttondeivisionprinthide').style.display="inline";
                                    }
                                </script>
                                <script>
                                    function ProceedVoucher(){


                                    //     var journalentrycolumns = [];
                                    //     var transactioncolumns = [];
                                    //     var c=0;
                                    //     var d=0;
                                    //     for(var a=1;a<=columncountjournaentry;a++){
                                    //         if(document.getElementById('transactiontrj'+a)){
                                    //             console.log('transactiontrj'+a);
                                    //             journalentrycolumns.push({'title':document.getElementById('accounttittle'+a).value,'debit':document.getElementById('debit'+a).value,'credit':document.getElementById('credit'+a).value});
                                                
                                    //             if(document.getElementById('debit'+a).value!=""){
                                    //                 c=c+parseFloat(document.getElementById('debit'+a).value);
                                    //             }
                                    //             if(document.getElementById('credit'+a).value!=""){
                                    //                 d=d+parseFloat(document.getElementById('credit'+a).value);
                                    //             }
                                    //         }
                                            
                                    //     }
                                    //     var maxtotal=0;
                                    //         for(var a=1;a<=columncount;a++){
                                    //             if(document.getElementById('transactiontr'+a)){
                                    //                 console.log('transactiontr'+a);
                                    //                 transactioncolumns.push({'qty':document.getElementById('qty'+a).value,'unit':document.getElementById('unit'+a).value,'desc':document.getElementById('desc'+a).value,'amount':document.getElementById('amount'+a).value});
                                    //                 if(document.getElementById('amount'+a).value!=""){
                                    //                     maxtotal=maxtotal+parseFloat(document.getElementById('amount'+a).value);
                                    //                 }
                                    //             }
                                    //         }
                                    //     if(c==d){
                                            
                                    //     if(c==maxtotal){
                                    //         var vouchertype=document.getElementById('vouchertype').value;
                                    //         var PaytoOrderof=document.getElementById('PaytoOrderof').value;
                                    //         var VoucherNo=document.getElementById('VoucherNo').value;
                                    //         var ReceivedFrom=document.getElementById('ReceivedFrom').value;
                                    //         var voucherdate=document.getElementById('voucherdate').value;
                                    //         var ReceivedFromBank=document.getElementById('ReceivedFromBank').value;
                                    //         var amountofBank=document.getElementById('amountofBank').value;
                                    //         var BankBank=document.getElementById('BankBank').value;
                                    //         var ChequeNoBank=document.getElementById('ChequeNoBank').value;
                                    //         var PaymentByBank=document.getElementById('PaymentByBank').value;
                                    //         var prepared_by=document.getElementById('prepared_by').value;
                                    //         var certified_correct_by=document.getElementById('certified_correct_by').value;
                                    //         var approved_by=document.getElementById('approved_by').value;
                                    //         var PreviousVoucher=document.getElementById('PreviousVoucher').value;
                                            
                                    //         $.ajax({
                                    //         type: 'POST',
                                    //         headers: {
                                    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    //         },
                                    //         url: '{{ route('add_voucher') }}',
                                    //         data: {_token: '{{csrf_token()}}',PreviousVoucher:PreviousVoucher,journalentrycolumns:journalentrycolumns,transactioncolumns:transactioncolumns,vouchertype:vouchertype,PaytoOrderof:PaytoOrderof,VoucherNo:VoucherNo,ReceivedFrom:ReceivedFrom,voucherdate:voucherdate,ReceivedFromBank:ReceivedFromBank,amountofBank:amountofBank,BankBank:BankBank,ChequeNoBank:ChequeNoBank,PaymentByBank:PaymentByBank,prepared_by:prepared_by,certified_correct_by:certified_correct_by,approved_by:approved_by},
                                    //         success: function(data) {
                                    //         disablecanceljournalemodal();
                                    //         document.getElementById('closevouchermodal').click();
                                    //         setJournalEntryVoucher(data);
                                    //         swal({title: "Done!", text:"Successfully Added Voucher", type: 
                                    //             "success"}).then(function(){
                                                
                                    //             });
                                    //         }

                                    //         })
                                    //     }else{
                                    //         alert('Transaction does not match with the Distribution of Accounts');
                                    //     }
                                            
                                            
                                    //     }else{
                                    //         alert('Please check Distribution of Account. Credit is not Equal to Debit');
                                    //     }
                                        
                                        
                                    }
                                </script>
                                
                            </div>
                        </div>
                    </div>
                </div>
        </div>
</div>
<button id="Vouhcermooodall" style="display:none;" data-toggle="modal" data-target="#vouchermodal">Voucher</button>
<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticModalLabel">Add New Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <script>
        $(function(){
            $("#add_supplier_form").submit(function(e) {
                $.ajax({
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ action('SuppliersController@store') }}",
                    dataType: "text",
                    data: $('#add_supplier_form').serialize(),
                    success: function (data) {
						console.log(data);
                        swal("Done!", "Added Supplier", "success");
                        $('#add_supplier_form')[0].reset();
                        if(document.getElementById('hidden_add_customer_status').value=="ExpensePage"){
                            location.reload();
                        }else{
                            SaveInformation();
                        }
                        
                    },
                    error: function (data) {
                        alert(data.responseText);
                        swal("Error!", "Supplier data failed", "error");
                    }
                }); 
                e.preventDefault();    
            });
        });
        </script>
        <form  autocomplete="off" id="add_supplier_form" >
                {{ csrf_field() }}
                <input type="hidden" id="hidden_add_customer_status" name="hidden_add_customer_status" value="">
            <div class="modal-body">
                <div class="col-md-6">
                    <div class="col-md-6 p-0">
                        <p>First Name</p>
                        <input type="text" name="fname" class="w-100">
                    </div>
                    <div class="col-md-6 p-0 pl-1">
                        <p>Last Name</p>
                    <input type="text" name="lname" class="w-100">
                    </div>

                    <div class="col-md-12 p-0">
                        <p>Company</p>
                        <input type="text" name="company" class="w-100">
                    </div>
                    <div class="col-md-12 p-0">
                            <p>Business Style</p>
                            <input type="text" name="business_style" class="w-100">
                    </div>
                    <div class="col-md-12 p-0">
                        <p>Display name as</p>
                        <input id="suppliername" required type="text" name="displayname" class="w-100">
                    </div>
                    
                    <div class="col-md-12 p-0">
                        <p>Address</p>
                        <textarea rows="2" class="w-100" name="street" placeholder="Street"></textarea>
                    </div>

                    <div class="col-md-6 p-0 pb-1">
                        <input type="text" name="city" placeholder="City/Town" class="w-100">
                    </div>
                    <div class="col-md-6 p-0 pl-1 pb-1">
                        <input type="text" name="state" placeholder="State/Province" class="w-100">
                    </div>
                    <div class="col-md-6 p-0">
                        <input type="text" name="postalcode" placeholder="Postal Code" class="w-100">
                    </div>
                    <div class="col-md-6 p-0 pl-1" >
                        <input type="text" name="country" placeholder="Country" class="w-100">
                    </div>

                    <div class="col-md-12 p-0">
                        <p>Notes</p>
                        <textarea rows="2" name="notes" class="w-100"></textarea>
                    </div>

                    
                </div>



                <div class="col-md-6 ">
                    <div class="col-md-12 p-0">
                        <p>Email</p>
                        <input type="email" name="email" class="w-100" placeholder="separate multiple emails with commas">
                    </div>

                    <div class="col-md-12 p-0">
                        <div class="col-md-4 p-0 pr-1">
                            <p>Phone</p>
                            <input id="supplierphone" type="text" name="phone" class="w-100">
                        </div>
                        <div class="col-md-4 p-0 pr-1">
                            <p>Mobile</p>
                            <input type="text" name="mobile" class="w-100">
                        </div>
                        <div class="col-md-4 p-0">
                            <p>Fax</p>
                            <input type="text" name="fax" class="w-100">
                        </div>
                    </div>

                    <div class="col-md-12 p-0">
                        <div class="col-md-4 p-0 pr-1">
                            <p>Other</p>
                            <input type="text" name="other" class="w-100">
                        </div>
                        <div class="col-md-8 p-0">
                            <p>Website</p>
                            <input type="text" name="website" class="w-100">
                        </div>
                    </div>

                    <div class="col-md-12 p-0">
                        <div class="col-md-6 p-0 pr-1">
                            <p>Billing rate (/hr)</p>
                            <input type="number" name="billingrate" class="w-100">
                        </div>

                        <div class="col-md-6 p-0">
                            <p>Terms</p>
                            <input type="text" name="terms" class="w-100">
                        </div>
                    </div>

                    <div class="col-md-12 p-0">
                        <div class="col-md-6 p-0 pr-1">
                            <p>Opening balance</p>
                            <input type="number" name="balance" class="w-100" value='0'>
                        </div>

                        <div class="col-md-6 p-0">
                            <p>as of</p>
                            <input type="date" name="asof" class="w-100">
                        </div>
                    </div>

                    <div class="col-md-12 p-0">
                        <div class="col-md-6 p-0 pr-1">
                            <p>Account No. </p>
                            <input type="text" name="accountno" class="w-100">
                        </div>

                        <div class="col-md-6 p-0">
                            <p>Business ID No. </p>
                            <input type="text" name="businessno" class="w-100">
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                            <div class="col-md-12 p-0 pr-1">
                                <p>TIN No. </p>
                                <input type="text" name="tin_no" class="w-100" required>
                            </div>
                        </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-6 p-0 pr-1">
                        <p>Tax</p>
                        <select name="tax_type" class="w-100" required onchange="hidevatvalue(this.value)">
                        <option>VAT</option>
                        <option>NON-VAT</option>
                        </select>
                        <script>
                            function hidevatvalue(e){
                                if(e=="VAT"){
                                    document.getElementById('vatvaluediv').style.display="block";
                                }else{
                                    
                                    document.getElementById('vatvaluediv').style.display="none";
                                }

                            }
                        </script>
                        </div>
                        <div class="col-md-6 p-0 pr-1" id="vatvaluediv">
                        <p>VAT value</p>
                        <input type="text" name="vat_value" value="12" min="0" max="100" step="0.01" style="width:80%" required> %
                        </div>
                    </div>
                    <div class="col-md-12 p-0" style="display:none;">
                        <p>Attachments</p>
                        <div class="input-group mb-3 p-0">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="fileattachment" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button id="supplieradd" type="submit" class="btn btn-success rounded">Save</button>
            </div>
        </form>
        </div>
    </div>
</div>
<div class="modal fade" id="addcustomermodal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
    <form action="#" class="form-horizontal " id="add_customer_form" onsubmit="addCustomer()" autocomplete="off">
    {{ csrf_field() }}
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticModalLabel">Add New Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-6 pr-0">
                    <div class="col-md-6 p-0 pr-0">
                        <p>First Name</p>
                        <input type="text" name="f_name" class="w-100" >
                    </div>
                    <div class="col-md-6 p-0 pl-1">
                        <p>Last Name</p>
                        <input type="text" name="l_name" class="w-100">
                    </div>
                    <div class="col-md-12 p-0">
                        <p>Company</p>
                        <input type="text" name="company" class="w-100" required>
                    </div>
                    <div class="col-md-12 p-0">
                        <p>Business Style</p>
                        <input type="text" name="business_style" class="w-100">
                    </div>
                    <div class="col-md-12 p-0">
                        <p>Display name as</p>
                        <input id="customername" required type="text" name="display_name" class="w-100">
                    </div>
                    <div class="col-md-12 p-0">
                        <p>Address</p>
                        <textarea rows="2" class="w-100" name="street" placeholder="Street" ></textarea>
                    </div>
                    <div class="col-md-6 p-0 pr-1 pb-1">
                        <input type="text" name="city" placeholder="City/Town" class="w-100" >
                    </div>
                    <div class="col-md-6 p-0 pl-0 pb-1">
                        <input type="text" name="state" placeholder="State/Province" class="w-100" >
                    </div>
                    <div class="col-md-6 p-0 pr-1">
                        <input type="text" name="postal_code" placeholder="Postal Code" class="w-100" >
                    </div>
                    <div class="col-md-6 p-0 pl-0" >
                        <input type="text" name="country" placeholder="Country" class="w-100" >
                    </div>
                    <div class="col-md-12 p-0">
                        <p>Notes</p>
                        <textarea rows="2" name="notes" class="w-100"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12 p-0">
                        <p>Email</p>
                        <input type="email" name="email" class="w-100" placeholder="separate multiple emails with commas">
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-4 p-0 pr-1">
                            <p>Phone</p>
                            <input id="customerphone" type="tel" name="phone" class="w-100" >
                        </div>
                        <div class="col-md-4 p-0 pr-1">
                            <p>Mobile</p>
                            <input type="tel" name="mobile" class="w-100" >
                        </div>
                        <div class="col-md-4 p-0">
                            <p>Fax</p>
                            <input type="tel" name="fax" class="w-100" >
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-4 p-0 pr-1">
                            <p>Other</p>
                            <input type="text" name="other" class="w-100" >
                        </div>
                        <div class="col-md-8 p-0">
                            <p>Website</p>
                            <input type="text" name="website" class="w-100">
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-6 p-0 pr-1">
                            <p>Payment Method<p>
                            <input type="text" list="payment_method_list" name="payment_method" class="w-100" >
                        </div>
                        <div class="col-md-6 p-0">
                            <p>Terms</p>
                            <input type="text" list="terms_list" name="terms" id="terms" class="w-100">
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-6 p-0 pr-1">
                            <p>Opening balance</p>
                            <input id="customerbalance" type="number" name="opening_balance" class="w-100" value="0">
                        </div>
                        <div class="col-md-6 p-0">
                            <p>as of</p>
                            <input type="date" name="as_of_date" class="w-100">
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-6 p-0 pr-1">
                            <p>Account No. </p>
                            <input type="tel" name="account_no" class="w-100" >
                        </div>
                        <div class="col-md-6 p-0">
                            <p>Business ID No. </p>
                            <input type="tel" name="business_id_no" class="w-100">
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-6 p-0 pr-1">
                            <p>TIN No. </p>
                            <input type="text" name="tin_no" class="w-100">
                        </div>
                        <div class="col-md-6 p-0 pr-1">
                            <p>Withholding Tax</p>
                            <input type="number" name="withholdingtax" min="0" max="100" step="0.01" value="2" style="width:80%" required> %
                        </div>
                    </div>
                    <div class="col-md-12 p-0" style="display:none;">
                        <p>Attachments</p>
                        <div class="input-group mb-3 p-0">
                            <div class="custom-file">
                                <input type="file" name="attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button id="customeradd" type="submit" class="btn btn-success rounded">Save</button>
            </div>
        </div>
    </div>
    </form>
</div>
<div class="modal fade p-0" id="invoicemodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
<script>
    @if(!empty($numbering) && $numbering->use_cost_center=="Off")

    @else
    $(document).ready(function(){
        // $("#add_invoice_form :input").prop("disabled", true);
        // document.getElementById('CostCenterInvoice').disabled=false;
        // document.getElementById('invoicemodalclose').disabled=false;
        
    });

    @endif
    
</script>
<form action="#" class="form-horizontal " id="add_invoice_form" onsubmit="addInvoice()" autocomplete="off">
{{ csrf_field() }}
    <input id="transaction_type" name="transaction_type" value="Invoice" hidden>
    <input id="product_count" name="product_count" value="0" hidden>
    <input type="number" step="0.01" id="total_balance" name="total_balance" value="0" hidden>
    <input type="number" id="sales_transaction_number_estimate" name="sales_transaction_number_estimate" value="0" hidden>
    <input type="number" id="sales_transaction_number_delayed_charge" name="sales_transaction_number_delayed_charge" value="0" hidden>
    <input type="number" id="sales_transaction_number_delayed_credit" name="sales_transaction_number_delayed_credit" value="0" hidden>
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Invoice</h5>
                <button type="button" class="close" id="invoicemodalclose" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="col-md-12 p-0 mb-4">
                        <div class="col-md-2 p-0 pr-3">
                            <p>Location</p>
                            <select class="w-100 form-control" id="invoice_location_top" name="invoice_location_top" onchange="setInvoice_no_new()">
                                <option value="Main">Main</option>
                                <option value="Branch">Branch</option>
                            </select>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Type</p>
                            <select class="w-100 form-control" id="invoice_type_top" name="invoice_type_top" onchange="setInvoice_no_new()">
                                <option >Sales Invoice</option>
                                <option >Bill Invoice</option>
                            </select>
                        </div>
                    </div>
                    <script>
                        function setInvoice_no_new(){
                            var invoice_location_top=document.getElementById('invoice_location_top').value;
                            var invoice_type_top=document.getElementById('invoice_type_top').value;
                            var invoice_no_field=document.getElementById('invoice_invoiceno').value;
                            $.ajax({
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: "check_invoice_no",
                                data: {invoice_location_top:invoice_location_top,invoice_type_top:invoice_type_top,invoice_no_field:invoice_no_field,_token: '{{csrf_token()}}'},
                                success: function (data) {
                                    if(data>0){
                                        document.getElementById('invoice_invoiceno').style.border="1px solid red";
                                        document.getElementById('invoice_add_button').disabled=true;
                                    }else{
                                        document.getElementById('invoice_invoiceno').style.border="1px solid green";
                                        document.getElementById('invoice_add_button').disabled=false;
                                    }
                                }
                            });
                        }
                    </script>
                    <div class="col-md-12 p-0 mb-4">
                        <div class="col-md-2 p-0 pr-3">
                            <p>Invoice No</p>
                            <input id="invoice_invoiceno" type="text"  value="{{count($invoice_count)+$sales_exp_start_no}}" name="invoice_invoiceno" class="w-100 form-control" onkeyup="setInvoice_no_new()"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Invoice Date</p>
                            <input id="invoicedate" type="date" name="date" class="w-100 form-control" required onchange="changeduedatemin(this)">
							<script>
								function changeduedatemin(e){
									if(e.value!=""){
										document.getElementById('invoiceduedate').setAttribute("min", e.value);
									}
								}
								function settermsinvoice(e){
									if(e.value!=""){
										document.getElementById('term').value="";
									}
									
								}
							</script>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Due Date</p>
                            <input id="invoiceduedate" onchange="settermsinvoice(this)" type="date" name="due_date" class="w-100 form-control" >
                        </div>
                        
                    </div>
					<div class="col-md-12 p-0 mb-4" style="display:none;">
                        <div class="col-md-4 p-0 pr-3" style="{{!empty($numbering) && $numbering->use_cost_center=="Off"? 'display:none;' : ''}}">
                            <script>
                                function EnableInvoiceInput(e){
                                    // if(e.value==""){
                                    //     $("#add_invoice_form :input").prop("disabled", true);
                                    //     document.getElementById('CostCenterInvoice').disabled=false;
                                    //     document.getElementById('invoicemodalclose').disabled=false;
                                    // }else{
                                    //     var asd=e.value;
                                    //     $("#add_invoice_form :input").prop("disabled", false);
                                    //     document.getElementById('CostCenterInvoice').value=asd;
                                    // }
                                }
                            </script>
                            <p>Cost Center</p>
                            <input type="text" list="cost_center_list_invoice" name="CostCenterInvoice" class="w-100 form-control" onchange="EnableInvoiceInput(this)" id="CostCenterInvoice"  {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : 'required'}} value="OFF" style="display:none;">
                                <datalist id="cost_center_list_invoice">
								<option value="">--Select Cost Center--</option>
                                @foreach ($cost_center_list as $list)
                                <option>{{$list->cc_no." - ".$list->cc_name}}</option>
                                @endforeach
								</datalist>
                            
                        </div>
                    </div>
                    <div class="my-3 p-0 mb-4">
                        <div class="col-md-4 p-0 pr-3  mb-4">
                                <p>Customer</p>
                            <select id="invoicecustomer" type="text" name="customer" class="w-100 selectpicker" data-live-search="true" required>
                            <option value="">--Select Name--</option>
                            {!! $customers_list_after_foreach !!}
                            </select>
                        </div>
                        
                        
                        
                    </div>
                    
                    <div class="col-md-12 p-0 mb-4">
                        <div class="col-md-4 p-0 pr-3">
                            <p>Billing Address</p>
                            <input type="text" name="bill_address" id="bill_address" class="w-100 form-control">
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Terms</p>
                            <input class="w-100 form-control" list="terms_list" name="term" id="term">
                            <datalist id="terms_list">
                                <option>Due on receipt</option>
                                <option>Net 15</option>
                                <option>Net 30</option>
                                <option>Net 60</option>
                            </datalist>
                        </div>
                        
                        
                    </div>
                    <div class="col-md-12 p-0 mb-4">
                        <div class="col-md-2 p-0 pr-3">
                            <p>Job Order</p>
                            <input type="text" name="job_order_invoice" id="job_order_invoice" class="w-100 form-control">
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p style="display:none;">Work No</p>
                            <input type="text" name="work_no_invoice" id="work_no_invoice" class="w-100 form-control" style="display:none;">
                        </div>
                        
                        
                    </div>
					<div class="col-md-12 p-0 ">
					<div class="col-md-3 p-0 pr-3">
                                <p>Email</p>
                            <input type="text" id="email" name="email" placeholder="Email (Separate emails with a comma)" class="w-100 mb-2 form-control">
                            
                    </div>
					<div class="col-md-3 p-0 pr-3 pt-4">
							
                            <div class="float-left">
                                <input type="checkbox" name="send_later" value="yes"> Send Now
                            </div>
							<div class="float-left"style="padding-left:40px;">
                                <input type="checkbox" name="generate_file_invoice_journal"> Generate PDF
                            </div>
                            
                    </div>
                    
                    </div>
                    <div class="col-md-12 p-0"  style="margin-bottom:20px;">
                        <table class="table-borderless table-sm" style="margin-right:5%;float:right;"> <!--style="margin-right:5%;float:right;" -->
                            <tr>
                                
                                <td style="vertical-align:middle;text-align:right;">
                                    <div class="col-md-12 p-0 d-inline-flex justify-content-end" style="text-align:right;margin-right:5%;">
                                        <h4 class="mr-2">BALANCE DUE: </h4>
                                        <h4 id="big_invoicebalance">PHP 0.00</h4>
                                    </div>
                                </td>
                            </tr>
                            
                        </table>
                    </div>
                    <table id="main_invoice_table" class="table table-bordered table-responsive-md text-left font14 table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center" width="5%">#</th>
                                <th class="text-center" width="10%">PARTICULAR</th>
                                <th class="text-center" width="10%">ITEM</th>
                                <th class="text-center">DESCRIPTION</th>
                                <th class="text-center" width="5%">QTY</th>
                                <th class="text-center"  width="10%">RATE</th>
                                <th class="text-center"  width="10%">AMOUNT</th>
                                <th class="text-center" width="5%"></th>
                            </tr>
                        </thead>
                        <tbody id="invoice_table">
                            
                        </tbody>
                        <!-- This is our clonable table line -->
                    </table>
                    <div class="col-md-12 p-0 mt-4">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_invoice">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_invoice">Clear All Items</button>
                            </div>
                        </div>
                        
                    </div>
                    {{-- <div class="col-md-9 p-0">
                    </div> --}}
                    <div class="col-md-12 p-0">
                        <table class="table-borderless table-sm" style="margin-right:5%;float:right;"> <!--style="margin-right:5%;float:right;" -->
                            <tr>
                                {{-- <td width="60%"></td> --}}
                                <td style="vertical-align:middle;text-align:right;font-size:1em"><p style="font-size:1.3em !important" class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p></td>
                                <td style="vertical-align:middle;text-align:right;font-size:1em"><p style="font-size:1.3em !important" id="invoicetotal" class="mb-0 text-dark font-weight-bold">PHP 0.00</p></td>
                                {{-- <td class="text-center" width="5%"></td> --}}
                            </tr>
                            <tr>
                                {{-- <td width="60%"></td> --}}
                                <td style="vertical-align:middle;text-align:right;font-size:1em"><p style="font-size:1.3em !important" class="pr-4 text-dark font-weight-bold">BALANCE DUE</p></td>
                                <td style="vertical-align:middle;text-align:right;font-size:1em"><p style="font-size:1.3em !important" id="invoicebalance" class="text-dark font-weight-bold">PHP 0.00</p></td>
                                {{-- <td class="text-center" width="5%"></td> --}}
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-6 pl-0">
                            <p>Message Displayed on Invoice</p>
                            <textarea rows="3" class="w-100 form-control" name="note" id="note" ></textarea>
                        </div>
                        <div class="col-md-6 pr-0">
                            <p>Message Displayed on Statement</p>
                            <textarea rows="3" class="w-100 form-control" name="memo" id="memo" ></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-4">
                        <table class="table table-light table-sm bordered-top-table" style="margin-bottom:0px;">
                            <thead class="thead-light">
                                <tr>
                                    <th colspan="3" style="vertical-align:middle;text-align:center;">Accounts</th>
                                </tr>
                            </thead>
                        </table>
                        <table class="table table-light table-sm" id="main_invoice_table_journal_account">
                            <thead class="thead-light">
                                <tr>
                                    <th style="vertical-align:middle;text-align:center;border-right: 1px solid #ccc;" width="5%">#</th>
                                    <th style="vertical-align:middle;text-align:center;border-right: 1px solid #ccc;" width="12%">Code</th>
                                    <th style="vertical-align:middle;text-align:center;border-right: 1px solid #ccc;width: 40%;">Debit</th>
                                    <th style="vertical-align:middle;text-align:center;border-right: 1px solid #ccc;" width="12%">Code</th>
                                    <th style="vertical-align:middle;text-align:center;" width="40%">Credit</th>
                                </tr>
                            </thead>
                            <tbody id="InvoiceAccountTBody">
                                
                                
                            </tbody>
                        </table>
                        <script>
                            function setAccount_and_Code(row){
                                if( typeof( $(row).attr('id') ) != 'undefined' ){
                                var position = $(row).attr('id').replace(/[^0-9\.]/g, '');
                                var code=document.getElementById('invoice_account_debit_account_code'+position).value;
                                document.getElementById('invoice_account_debit_account'+position).value=code;
                                document.getElementById('setselectpickerinvoicedebitcode').setAttribute('data-value',position);
                                document.getElementById('setselectpickerinvoicedebitcode').click();
                                }
                                

                            }
                            function setAccount_and_Code_code(row){
                                if( typeof( $(row).attr('id') ) != 'undefined' ){
                                var position = $(row).attr('id').replace(/[^0-9\.]/g, '');
                                var code=document.getElementById('invoice_account_debit_account'+position).value;
                                document.getElementById('invoice_account_debit_account_code'+position).value=code;
                                document.getElementById('setselectpickerinvoicedebitcodecode').setAttribute('data-value',position);
                                document.getElementById('setselectpickerinvoicedebitcodecode').click();
                                }
                                

                            }
                            function setAccount_and_Code2(row){
                                if( typeof( $(row).attr('id') ) != 'undefined' ){
                                var position = $(row).attr('id').replace(/[^0-9\.]/g, '');
                                var code=document.getElementById('invoice_account_credit_account_code'+position).value;
                                document.getElementById('invoice_account_credit_account'+position).value=code;
                                document.getElementById('setselectpickerinvoicecreditcode').setAttribute('data-value',position);
                                document.getElementById('setselectpickerinvoicecreditcode').click();
                                }
                                

                            }
                            function setAccount_and_Code_code2(row){
                                if( typeof( $(row).attr('id') ) != 'undefined' ){
                                var position = $(row).attr('id').replace(/[^0-9\.]/g, '');
                                var code=document.getElementById('invoice_account_credit_account'+position).value;
                                document.getElementById('invoice_account_credit_account_code'+position).value=code;
                                document.getElementById('setselectpickerinvoicecreditcodecode').setAttribute('data-value',position);
                                document.getElementById('setselectpickerinvoicecreditcodecode').click();
                                }
                                

                            }
                        </script>
                    </div>  
                    <div class="col-md-6 m-0 p-0 mt-3" style="display:none;">
                        <div class="d-inline-flex">
                            <p class="fa fa-paperclip"></p>
                            <p class="p-0 ml-1">Maximum Size: 20MB</p>
                        </div>
                        <div class="input-group mb-3 p-0">
                            <div class="custom-file">
                                <input type="file" name="attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button id="invoiceadd" class="btn btn-success rounded" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>
</div>
<script>
   
function setJournalEntryVoucher(data){
    console.log("data is "+data);
    document.getElementById('OtherNo').value=data;
    document.getElementById('JournalEntryTransactionType').value="Voucher";
    
    $.ajax({
    type: 'POST',
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '{{ route('set_journal_entry_from_voucher') }}',                
    data: {id:data,_token: '{{csrf_token()}}'},
    success: function(data) {
        console.log(data);
        var rowcount=1;
        for(var c=0;c<data.length;c++){
            var cdsas=$('#accjournbale1 option:selected').text();
            var accjournbale1=document.getElementById('accjournbale1').value;
            if(rowcount==1){
                
                    document.getElementById('accjournbale1').value=accjournbale1;
                    document.getElementById('journaldebit1').innerHTML=data[c]['debit'];
                    document.getElementById('journalcredit1').innerHTML=data[c]['credit'];
                    document.getElementById('journaldescription1').innerHTML=accjournbale1;
                    document.getElementById('journalnamename1').innerHTML=accjournbale1;
                
                rowcount=2;

            }
            else if(rowcount==2){
                
                    document.getElementById('accjournbale2').value=data[c]['account_title'];
                    document.getElementById('journaldebit2').innerHTML=data[c]['debit'];
                    document.getElementById('journalcredit2').innerHTML=data[c]['credit'];
                    document.getElementById('journaldescription2').innerHTML=accjournbale1;
                    document.getElementById('journalnamename2').innerHTML=accjournbale1;
                
                rowcount=3;   
                
            }else{
                AddTableRow();
                
                    document.getElementById('accjournbale'+rowcount).value=data[c]['account_title'];
                    document.getElementById('journaldebit'+rowcount).innerHTML=data[c]['debit'];
                    document.getElementById('journalcredit'+rowcount).innerHTML=data[c]['credit'];
                    document.getElementById('journaldescription'+rowcount).innerHTML=data[c]['account_title'];
                    document.getElementById('journalnamename'+rowcount).innerHTML=data[c]['account_title'];
               
            rowcount++; 
            }
        }
        
    }
    })
}
function addInvoicejournal(){
    $('#total_balance_journal').val($('#invoicetotal_journal').text());
   
   $(".invoice_lines").each(function() {
       $("#product_count_journal").val(parseFloat($("#product_count_journal").val())+1);
   });
   
   var counter = 0;
   var checker = 0;
   
   $(".invoice_lines").find('.invoice_data').each(function() {
    if( typeof( $(this).attr('id') ) != 'undefined' ) {
        var id = $(this).attr("id");
        var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
        
        $(this).attr("name", name+counter);
        
        checker++;
        if(checker%4==0){
            counter++;
        }
    }
       
   });
   
   
   $.ajax({
       method: "POST",
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
       url: "{{ route('add_invoice_journal') }}",
       dataType: "text",
       data: $('#add_invoice_form_journal').serialize(),
       success: function (data) {
           
            setJournalAccount(data);
           swal("Done!", "Added invoice", "success");
           $("#product_count_journal").val('0');
           checker = 0;
           counter = 0;
           $('#add_invoice_form_journal')[0].reset();
           $('.invoice_lines').remove();
           $('#sales_transaction_number_estimate_journal').val('0');
           $('#sales_transaction_number_delayed_charge_journal').val('0');

           disablecanceljournalemodal();


       },
       error: function (data) {
           alert(data.responseText);
           swal("Error!", "Invoice failed", "error");
       }
   });
}
function setJournalAccount(id){
    document.getElementById('OtherNo').value=id;
    document.getElementById('JournalEntryTransactionType').value="Invoice";
    document.getElementById('goSalesReceipt').value="1";
    $.ajax({
    type: 'POST',
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '{{ route('set_journal_entry') }}',                
    data: {id:id,_token: '{{csrf_token()}}'},
    success: function(data) {
        var rowcount=1;
        console.log(data);
        for(var c=0;c<data.length;c++){
            var cdsas=$('#accjournbale1 option:selected').text();
            var accjournbale1=document.getElementById('accjournbale1').value;
            console.log('account : '+cdsas);
            console.log(data[c]);
            if(rowcount<3){
                //document.getElementById('accjournbale1').value=accjournbale1;
                document.getElementById('journaldebit1').innerHTML=data[c]['st_i_total'];
                document.getElementById('journalcredit1').innerHTML="";
                document.getElementById('journaldescription1').innerHTML=data[c]['st_i_desc'];
                document.getElementById('journalnamename1').innerHTML=data[c]['st_i_desc'];
                //document.getElementById('accjournbale2').value=accjournbale1;
                document.getElementById('journaldebit2').innerHTML="";
                document.getElementById('journalcredit2').innerHTML=data[c]['st_i_total'];
                document.getElementById('journaldescription2').innerHTML=data[c]['st_i_desc'];
                document.getElementById('journalnamename2').innerHTML=data[c]['st_i_desc'];
                rowcount=3;

            }else{
                AddTableRow();
                
                
                
                console.log('rowcouint='+rowcount);
                document.getElementById('accjournbale'+rowcount).value="";
                document.getElementById('journaldebit'+rowcount).innerHTML=data[c]['st_i_total'];
                document.getElementById('journalcredit'+rowcount).innerHTML="";
                document.getElementById('journaldescription'+rowcount).innerHTML=data[c]['st_i_desc'];
                document.getElementById('journalnamename'+rowcount).innerHTML=data[c]['st_i_desc'];
                rowcount++;
                
                AddTableRow();
                document.getElementById('accjournbale'+rowcount).value="";
                document.getElementById('journaldebit'+rowcount).innerHTML="";
                document.getElementById('journalcredit'+rowcount).innerHTML=data[c]['st_i_total'];
                document.getElementById('journaldescription'+rowcount).innerHTML=data[c]['st_i_desc'];
                document.getElementById('journalnamename'+rowcount).innerHTML=data[c]['st_i_desc']; 
                rowcount++;
            }
            
           
           
        }
    }
    })
}


</script>
<div class="modal fade p-0" id="invoicemodaljournal" tabindex="-1" role="dialog" aria-hidden="true" style="">
<form action="#" class="form-horizontal " id="add_invoice_form_journal" onsubmit="return false" autocomplete="off">
{{ csrf_field() }}
    <input id="transaction_type_journal" name="transaction_type" value="Invoice" hidden>
    <input id="product_count_journal" name="product_count_journal" value="0" hidden>
    <input type="number" id="total_balance_journal" step="0.01" name="total_balance_journal" value="0" hidden>
    <input type="number" id="sales_transaction_number_estimate_journal" name="sales_transaction_number_estimate" value="0" hidden>
    <input type="number" id="sales_transaction_number_delayed_charge_journal" name="sales_transaction_number_delayed_charge" value="0" hidden>
    <input type="number" id="sales_transaction_number_delayed_credit_journal" name="sales_transaction_number_delayed_credit" value="0" hidden>
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" onclick="openjournalEntryModal()">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="my-3 p-0">
                        <div class="col-md-3 p-0 pr-3">
                            <p>Customer</p>
                            <select id="invoicecustomer_journal" type="text" name="customer" class="w-100" required>
                            <option value="">--Select Name--</option>
                            {!! $customers_list_after_foreach !!}
                            </select>
                        </div>
                        <div class="col-md-3 p-0 pr-3" >
                            <p >Email</p>
                            <input type="text" id="email_journal" name="email" placeholder="Email (Separate emails with a comma)" class="w-100">
                            <br>
                            <div class="float-left">
                                <input type="checkbox" name="send_later" >Send Now
                            </div>
                            <div class="float-right">
                                <input type="checkbox" name="generate_file_invoice">Generate PDF
                            </div>
                        </div>
                        <div class="col-md-2 p-0 ">
                            <p>Invoice No</p>
                            <input id="invoice_invoicenojournal" type="text" value="{{count($SS)+count($ETran)+$sales_exp_start_no}}" name="invoice_invoicenojournal" class="w-100" readonly>
                        </div>
                        <div class="col-md-4 p-0 d-inline-flex center-content " style="text-align:center;">
                            <h4 class="mr-2">BALANCE DUE: </h4>
                            <h3 id="big_invoicebalance_journal">PHP 0.00</h3>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 " style="margin-bottom:20px;">
                        <div class="col-md-4 p-0 pr-3">
                            <p>Billing Address</p>
                            <input type="text" name="bill_address" id="bill_address_journal" class="w-100" required>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Terms</p>
                            <input class="w-100" list="terms_list" name="term" id="term_journal" required>
                            <datalist id="terms_list">
                                <option>Due on receipt</option>
                                <option>Net 15</option>
                                <option>Net 30</option>
                                <option>Net 60</option>
                            </datalist>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Invoice Date</p>
                            <input id="invoicedate_journal" type="date" name="date" class="w-100" required>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Due Date</p>
                            <input id="invoiceduedate_journal" type="date" name="due_date" class="w-100" required>
                        </div>
                        
                    </div>

                    <table id="invoice_table_journal" class="table table-bordered table-responsive-md table-striped text-left font14">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">PRODUCT/SERVICE</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-center">QTY</th>
                            <th class="text-left">RATE</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                        <!-- This is our clonable table line -->
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_invoice_journal">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_invoice_journal">Clear All Items</button>
                                
                            </div>
                        </div>
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                <p id="invoicetotal_journal" class="mb-0 text-dark font-weight-bold">PHP 0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="pr-4 text-dark font-weight-bold">BALANCE DUE</p>
                                <p id="invoicebalance_journal" class="text-dark font-weight-bold">PHP 0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-6 pl-0">
                            <p>Message Displayed on Invoice</p>
                            <textarea rows="3" class="w-100" name="note" id="note_journal" ></textarea>
                        </div>
                        <div class="col-md-6 pr-0">
                            <p>Message Displayed on Statement</p>
                            <textarea rows="3" class="w-100" name="memo" id="memo_journal" ></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 m-0 p-0 mt-3" style="display:none;">
                        <div class="d-inline-flex">
                            <p class="fa fa-paperclip"></p>
                            <p class="p-0 ml-1">Maximum Size: 20MB</p>
                        </div>
                        <div class="input-group mb-3 p-0">
                            <div class="custom-file">
                                <input type="file" name="attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeinvoicejournalmodal" style="display:none;" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button id="invoiceadd" class="btn btn-success rounded" type="submit" onclick="addInvoicejournal()">Save</button>
            </div>
        </div>
    </div>
</form>
</div>
<div class="modal fade p-0" id="editsuppliercreditmodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
        <script>
            function update_expenses_sc(){
                var customer=document.getElementById('sc_customeredit').value;
                var address=document.getElementById('sc_mail_addressedit').value;
                var paydate=document.getElementById('scdateedit').value;
                var refno=document.getElementById('screfnoedit').value;
                var memo=document.getElementById('sc_memoedit').value;
                var update_sc_id=document.getElementById('update_sc_id').value;
                var supplier_credit_account_debit_account_edit=document.getElementById('supplier_credit_account_debit_account_edit').value;
                var accounts1=[];
                var desc1=[];
                var amount1=[];
                

                var produt=[];
                var produt_desc=[];
                var produt_qty=[];
                var produt_rate=[];
                
                $(".sc_lines_account2").find('.sc_data').each(function() {
                    var id = $(this).attr("id");
                    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
                    //accounts.push(document.getElementById(id).value);
                    var acc="select_account_sc";
                    var des="select_description_sc";
                    var amo="select_sc_amount";
                    if(id.indexOf(acc) >= 0){
                        accounts1.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(des) >= 0){
                        desc1.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(amo) >= 0){
                        amount1.push(document.getElementById(id).value);
                    }   
                    //$(this).attr("name", name+counter12);
                    
                    // checker1++;
                    // if(checker1%3==0){
                    //     counter1++;
                    // }
                });
                $(".sc_lines_item2").find('.sc_data').each(function() {
                    var id = $(this).attr("id");
                    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
                    var pro="select_product_name_sc";
                    var pr_desc="select_product_description_sc";
                    var pr_qty="product_qty_sc";
                    var pr_rate="select_product_rate_sc";
                    if(id.indexOf(pro) >= 0){
                        produt.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(pr_desc) >= 0){
                        produt_desc.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(pr_qty) >= 0){
                        produt_qty.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(pr_rate) >= 0){
                        produt_rate.push(document.getElementById(id).value);
                    }
                });
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('update_expenses_sc') }}',                
                    data: {supplier_credit_account_debit_account_edit:supplier_credit_account_debit_account_edit,update_sc_id:update_sc_id,customer:customer,address:address,paydate:paydate,refno:refno,memo:memo,accounts1:accounts1,desc1:desc1,amount1:amount1,produt:produt,produt_desc:produt_desc,produt_qty:produt_qty,produt_rate:produt_rate,_token: '{{csrf_token()}}'},
                    success: function(data) {
                        swal({title: "Done!", text: "Updated Supplier Credit.", type: 
                            "success"}).then(function(){ 
                            location.reload();
                        });
                    }  

                    })
                
            }
        </script>
        <form action="#" class="form-horizontal " id="edit_supplier_credit_form" onsubmit="update_expenses_sc()" autocomplete="off">
        {{ csrf_field() }}
        <input id="update_sc_id" name="item_count_scs" value="" hidden>
        <input id="account_count_scsedit" name="account_count_scs" value="0" hidden>
            <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
                <div class="modal-content" style="min-height: 100vh;">
                    <div class="modal-header">
                        <h5 class="modal-title">Supplier Credit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body p-4" id="result">
                        <div class="col-md-12 p-0 mb-4">
                            <div class="my-3 p-0">
                                <div class="col-md-3 p-0 pr-3">
                                    <p>Name</p>
                                    <select type="text" name="sc_customer"  id="sc_customeredit" class="w-100 selectpicker">
                                    <option value="">--Select Name--</option>
                                    {!! $customers_list_after_foreach !!}
                                    </select>
                                </div>
                                <div class="col-md-2 p-0 pr-3" style="{{!empty($numbering) && $numbering->use_cost_center=="Off"? 'display:none;' : ''}}">
                                    <p>Cost Center</p>
                                    <select name="CostCenterSupplierCreditEdit" class="selectpicker" id="CostCenterSupplierCreditEdit" style="width:90%;" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : 'required'}}>
                                        <option value="">--Select Cost Center--</option>
                                        {!! $cc_list_after_foreach !!}
                                    </select>
                                </div>
                                <div class="col-md-3 p-0">
                                </div>
                                <div class="col-md-4 p-0 " style="text-align:center;">
                                    <h4 class="mr-2">CREDIT AMOUNT: </h4>
                                    <h3>PHP 0.00</h3>
                                </div>
                            </div>
                            <div class="col-md-12 p-0 mt-4 d-inline-flex">
                                <div class="col-md-3 p-0 pr-3">
                                    <p>Mailing Address</p>
                                    <input type="text" name="sc_mail_address" id="sc_mail_addressedit" class="w-100 form-control">
                                </div>
                                <div class="col-md-2 p-0 pr-3">
                                    <p>Payment Date</p>
                                    <input type="date"  {{$user_position->position!="CEO"? 'readonly' : ''}} id="scdateedit" name="sc_date" class="w-100 form-control">
                                </div>
                                <div class="col-md-2 p-0 pr-3">
                                    <p>Reference No. </p>
                                    <input type="text" id="screfnoedit" name="sc_reference_no" class="w-100 form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mb-1 mt-3">
                                <h4>Account Details</h4>
                            </div>
                            <table class="table table-bordered table-responsive-md table-sm text-left font14" id="sc_account_tableedit">
                                <thead>
                                    <tr>
                                        <th class="text-left">#</th>
                                        <th class="text-left">ACCOUNT</th>
                                        <th class="text-left">DESCRIPTION</th>
                                        <th class="text-left">AMOUNT</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="sc_account_tableedit_tbody">

                                </tbody>
                            </table>
                            <div class="col-md-12 p-0">
                                <div class="float-left">
                                    <div class="d-inline-flex">
                                        <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="add_lines_sc_account2">Add Items</button>
                                        <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="clear_lines_sc_account2">Clear All Items</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-1 mt-4" style="display:none;">
                                <h4>Item Details</h4>
                            </div>
                            <table style="display:none;" class="table table-bordered table-responsive-md table-striped text-left font14" id="sc_item_tableedit">
                                <tr>
                                    <th class="text-left">#</th>
                                    <th class="text-left">PRODUCT/SERVICE</th>
                                    <th class="text-left">DESCRIPTION</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-left">RATE</th>
                                    <th class="text-left">AMOUNT</th>
                                    <th class="text-center"></th>
                                </tr>
                            </table>
                            <div class="col-md-12 p-0" style="display:none;">
                                <div class="float-left">
                                    <div class="d-inline-flex">
                                        <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="add_lines_sc_item2">Add Items</button>
                                        <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="clear_lines_sc_item2">Clear All Items</button>
                                    </div>
                                </div>
                                <div class="float-right mr-5">
                                    <div class="d-inline-flex mr-4">
                                        <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                        <p class="mb-0 text-dark font-weight-bold">PHP 0.00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 p-0 mt-4">
                                <div class="col-md-6 pl-0">
                                    <p>Memo</p>
                                    <textarea rows="3" id="sc_memoedit" name="sc_memo" class="w-100"></textarea>
                                </div>
                                <div class="col-md-6 m-0 pr-0" style="display:none;">
                                    <div class="d-inline-flex">
                                        <p class="fa fa-paperclip"></p>
                                        <p class="p-0 ml-1">Maximum Size: 20MB</p>
                                    </div>
                                    <div class="input-group mb-3 p-0">
                                        <div class="custom-file">
                                            <input type="file" name="sc_attachment" class="custom-file-input" id="inputGroupFile01edit" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label bg-transparent" for="inputGroupFile01edit">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 p-0 mt-4">
                                <div class="col-md-4 p-0 mt-4">
                                    <table class="table table-light table-sm" style="margin-bottom:0px;">
                                        <thead class="thead-light">
                                            <tr>
                                                <th colspan="2" style="vertical-align:middle;text-align:center;">Debit</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <table class="table table-light table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="30%" style="vertical-align:middle;text-align:center;">Code</th>
                                                <th width="70%" style="vertical-align:middle;text-align:center;">Accounts</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="vertical-align:middle;" class="pr-0">
                                                    <select class="form-control selectpicker" data-live-search="true" name="supplier_credit_account_debit_account_edit_code"  id="supplier_credit_account_debit_account_edit_code" onchange="setsraccountdebitcode('supplier_credit_account_debit_account_edit_code','supplier_credit_account_debit_account_edit')" required>
                                                    <option value="">--Select Account--</option>
                                                    @foreach($c_o_a_sorted as $coa)
                                                    @if ($coa->id=="3")
                                                    <option value="{{$coa->id}}" selected>{{$coa->coa_code}}</option> 
                                                    @else
                                                    <option value="{{$coa->id}}">{{$coa->coa_code}}</option>  
                                                    @endif
                                                    
                                                    @endforeach
                                                    </select>
                                                    <script>
                                                    $(document).ready(function(){
                                                        document.getElementById('supplier_credit_account_debit_account_edit_code').value="3";
                                                    })
                                                    </script>
                                                </td>
                                                <td style="vertical-align:middle;" class="pr-0">
                                                    <select class="form-control selectpicker" data-live-search="true" name="supplier_credit_account_debit_account_edit"  id="supplier_credit_account_debit_account_edit" onchange="setsraccountdebitcode('supplier_credit_account_debit_account_edit','supplier_credit_account_debit_account_edit_code')" required>
                                                    <option value="">--Select Account--</option>
                                                    @foreach($c_o_a_sorted as $coa)
                                                    @if ($coa->id=="3")
                                                    <option value="{{$coa->id}}" selected>{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option> 
                                                    @else
                                                    <option value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>  
                                                    @endif
                                                    
                                                    @endforeach
                                                    </select>
                                                    <script>
                                                    $(document).ready(function(){
                                                        document.getElementById('supplier_credit_account_debit_account').value="3";
                                                    })
                                                    </script>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-success rounded" type="submit">Save</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    <div class="modal fade p-0" id="editchequemodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
        <script>
            function update_expense_cheque(){
                var customer=document.getElementById('chequepayeeedit').value;
                var chequeaccedit=document.getElementById('chequeaccedit').value;
                var address=document.getElementById('cheque_billing_addressedit').value;
                var paydate=document.getElementById('chequedateedit').value;
                var chequeno=document.getElementById('chequenoedit').value;
                var memo=document.getElementById('chequememoedit').value;
                var update_cheque_id=document.getElementById('update_cheque_id').value;

                var accounts1=[];
                var desc1=[];
                var amount1=[];

                var produt=[];
                var produt_desc=[];
                var produt_qty=[];
                var produt_rate=[];
                
                $(".cheque_lines_account2").find('.cheque_data').each(function() {
                    var id = $(this).attr("id");
                    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
                    //accounts.push(document.getElementById(id).value);
                    
                    var acc="select_account_cheque";
                    var des="select_description_cheque";
                    var amo="select_cheque_amount";
                    if(id.indexOf(acc) >= 0){
                        accounts1.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(des) >= 0){
                        desc1.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(amo) >= 0){
                        amount1.push(document.getElementById(id).value);
                    }   
                    
                });
                $(".cheque_lines_item2").find('.cheque_data').each(function() {
                    var id = $(this).attr("id");
                    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();
                    
                    var pro="select_product_name_cheque";
                    var pr_desc="select_product_description_cheque";
                    var pr_qty="product_qty_cheque";
                    var pr_rate="select_product_rate_cheque";
                    if(id.indexOf(pro) >= 0){
                        produt.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(pr_desc) >= 0){
                        produt_desc.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(pr_qty) >= 0){
                        produt_qty.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(pr_rate) >= 0){
                        produt_rate.push(document.getElementById(id).value);
                    }
                });
                console.log(produt_rate);
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('update_expenses_cheque') }}',                
                    data: {chequeaccedit:chequeaccedit,update_cheque_id:update_cheque_id,customer:customer,address:address,paydate:paydate,chequeno:chequeno,memo:memo,accounts1:accounts1,desc1:desc1,amount1:amount1,produt:produt,produt_desc:produt_desc,produt_qty:produt_qty,produt_rate:produt_rate,_token: '{{csrf_token()}}'},
                    success: function(data) {
                       
                        swal({title: "Done!", text: "Updated Cheque.", type: 
                            "success"}).then(function(){ 
                            location.reload();
                        });
                    }  

                    })

            }
            $("#edit_cheque_form").submit(function(e) {
                    e.preventDefault();
                    
                });
        </script>
        <form action="#" class="form-horizontal " id="edit_cheque_form" onsubmit="update_expense_cheque()" autocomplete="off">
        {{ csrf_field() }}
        <input id="update_cheque_id" name="item_count_cheques" value="0" hidden>
        <input id="account_count_chequesedit" name="account_count_cheques" value="0" hidden>
            <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
                <div class="modal-content" style="min-height: 100vh;">
                    <div class="modal-header">
                        <h5 class="modal-title">Cheque</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body p-4" id="result">
                        <div class="col-md-12 p-0 mb-4">
                            <div class="my-3 p-0">
                                <div class="col-md-3 p-0 pr-3">
                                    <p>Name</p>
                                    <select id="chequepayeeedit" type="text" name="cheque_customer" class="w-100" required>
                                        <option value="">--Select Name--</option>
                                        {!! $customers_list_after_foreach !!}
                                    </select>
                                </div>
                                
                                <div class="col-md-3 p-0">
                                    <p>Bank Account</p>
                                    <input type="text" id="chequeaccedit" list="payment_deposit" name="cheque_account" placeholder="Cash and Cash Equivalents" class="w-100" required>
                                </div>
                                
                                <div class="col-md-4 p-0  ml-5  d-inline-flex ">
                                    <h4 class="mr-2">AMOUNT: </h4>
                                    <h3>PHP 0.00</h3>
                                </div>
                            </div>
                            <div class="col-md-12 p-0 mt-3 d-inline-flex">
                                <div class="col-md-3 p-0 pr-3">
                                    <p>Mailing Address</p>
                                    <input type="text" name="cheque_billing_address" id="cheque_billing_addressedit" class="w-100" required>
                                </div>
                                <div class="col-md-2 p-0 pr-3">
                                    <p>Payment Date</p>
                                    <input type="date" id="chequedateedit"  {{$user_position->position!="CEO"? 'readonly' : ''}} name="cheque_date" class="w-100" required>
                                </div>
                                <div class="col-md-2 p-0 pr-3">
                                    <p>Cheque No.</p>
                                    <input type="text" id="chequenoedit" name="cheque_no" class="w-100" required>
                                </div>
                                <div class="col-md-2 p-0 pr-3" style="{{!empty($numbering) && $numbering->use_cost_center=="Off"? 'display:none;' : ''}}">
                                    <p>Cost Center</p>
                                    <select name="CostCenterChequeEdit" id="CostCenterChequeEdit" style="width:90%;" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : 'required'}}>
                                        <option value="">--Select Cost Center--</option>
                                        {!! $cc_list_after_foreach !!}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-1">
                                <h4>Account Details</h4>
                            </div>
                            <table class="table table-bordered table-responsive-md table-striped text-left font14" id="cheque_account_tableedit">
                                <tr>
                                    <th class="text-left">#</th>
                                    <th class="text-left">ACCOUNT</th>
                                    <th class="text-left">DESCRIPTION</th>
                                    <th class="text-left">AMOUNT</th>
                                    <th class="text-center"></th>
                                </tr>
                            </table>
                            <div class="col-md-12 p-0">
                                <div class="float-left">
                                    <div class="d-inline-flex">
                                        <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="add_lines_cheque_account2">Add Items</button>
                                        <button class="btn btn-outline-dark rounded mr-1 font14"  type="button" id="clear_lines_cheque_account2">Clear All Items</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-1 mt-4" >
                                <h4>Item Details</h4>
                            </div>
                            <table  class="table table-bordered table-responsive-md table-striped text-left font14" id="cheque_item_tableedit">
                                <tr>
                                    <th class="text-left">#</th>
                                    <th class="text-left">PRODUCT/SERVICE</th>
                                    <th class="text-left">DESCRIPTION</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-left">RATE</th>
                                    <th class="text-left">AMOUNT</th>
                                    <th class="text-center"></th>
                                </tr>
                            </table>
                            <div class="col-md-12 p-0">
                                <div class="float-left">
                                    <div class="d-inline-flex">
                                        <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="add_lines_cheque_item2">Add Items</button>
                                        <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="clear_lines_cheque_item2">Clear All Items</button>
                                    </div>
                                </div>
                                <div class="float-right mr-5">
                                    <div class="d-inline-flex mr-4">
                                        <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                        <p class="mb-0 text-dark font-weight-bold" id="cheque_edit_item_total">PHP 0.00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 p-0 mt-4">
                                <div class="col-md-6 pl-0">
                                    <p>Memo</p>
                                    <textarea rows="3" class="w-100" name="cheque_memo" id="chequememoedit" ></textarea>
                                </div>
                                <div class="col-md-6 m-0 pr-0" style="display:none;">
                                    <div class="d-inline-flex">
                                        <p class="fa fa-paperclip"></p>
                                        <p class="p-0 ml-1">Maximum Size: 20MB</p>
                                    </div>
                                    <div class="input-group mb-3 p-0">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="cheque_attachment" id="inputGroupFile01edit" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label bg-transparent" for="inputGroupFile01edit">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                        <button id="chequeadd" class="btn btn-success rounded" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    <div class="modal fade p-0" id="editexpensemodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
        <script>
            function update_expenses_expense(){
                var customer=document.getElementById('expensepayeeedit').value;
                var expenseaccountedit=document.getElementById('expenseaccountedit').value;
                
                var paymethod=document.getElementById('expense_payment_methodedit').value;
                var paydate=document.getElementById('expensedateedit').value;
                var refno=document.getElementById('refnoedit').value;
                var memo=document.getElementById('exmemoedit').value;
                var update_expense_id=document.getElementById('update_expense_id').value;

                var accounts1=[];
                var desc1=[];
                var amount1=[];

                var produt=[];
                var produt_desc=[];
                var produt_qty=[];
                var produt_rate=[];

                $(".expense_lines_account2").find('.expense_data').each(function() {
                    var id = $(this).attr("id");
                    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
                    //accounts.push(document.getElementById(id).value);
                    
                    var acc="select_account_expense";
                    var des="select_description_expense";
                    var amo="select_expense_amount";
                    if(id.indexOf(acc) >= 0){
                        accounts1.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(des) >= 0){
                        desc1.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(amo) >= 0){
                        amount1.push(document.getElementById(id).value);
                    }   
                    
                });

                $(".expense_lines_item2").find('.expense_data').each(function() {
                    var id = $(this).attr("id");
                    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();
                    
                    var pro="select_product_name_expense";
                    var pr_desc="select_product_description_expense";
                    var pr_qty="product_qty_expense";
                    var pr_rate="select_product_rate_expense";
                    if(id.indexOf(pro) >= 0){
                        produt.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(pr_desc) >= 0){
                        produt_desc.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(pr_qty) >= 0){
                        produt_qty.push(document.getElementById(id).value);
                    }
                    else if(id.indexOf(pr_rate) >= 0){
                        produt_rate.push(document.getElementById(id).value);
                    }
                });


                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('update_expenses_expense') }}',                
                    data: {expenseaccountedit:expenseaccountedit,update_expense_id:update_expense_id,customer:customer,paymethod:paymethod,paydate:paydate,refno:refno,memo:memo,accounts1:accounts1,desc1:desc1,amount1:amount1,produt:produt,produt_desc:produt_desc,produt_qty:produt_qty,produt_rate:produt_rate,_token: '{{csrf_token()}}'},
                    success: function(data) {
                       
                        swal({title: "Done!", text: "Updated Expense.", type: 
                            "success"}).then(function(){ 
                            location.reload();
                        });
                    },
                    error: function(jqXHR, exception) {
                        alert(jqXHR.responseText);
                    }

                    })
            }
        </script>  
        <form action="#" class="form-horizontal " id="edit_expense_form" onsubmit="update_expenses_expense()" autocomplete="off">
        {{ csrf_field() }}
        <input id="update_expense_id" name="item_count_expenses" value="0" hidden>
        <input id="account_count_expenses" name="account_count_expenses" value="0" hidden>
            <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
                <div class="modal-content" style="min-height: 100vh;">
                    <div class="modal-header">
                        <h5 class="modal-title">Expense</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body p-4" id="result">
                        <div class="col-md-12 p-0 mb-4">
                            <div class="my-3 p-0">
                                <div class="col-md-3 p-0 pr-3">
                                    <p>Name</p>
                                    <select id="expensepayeeedit" type="text" name="expense_customer" class="w-100" required>
                                        <option value="">--Select Name--</option>
                                        {!! $customers_list_after_foreach !!}
                                    </select>
                                </div>
                                
                                <div class="col-md-3 p-0">
                                    <p>Bank/Credit Account</p>
                                    <input type="text" list="payment_deposit" id="expenseaccountedit" name="expense_account" class="w-100" required>
                                </div>
                                
                                <div class="col-md-4 p-0  ml-5  d-inline-flex">
                                    <h4 class="mr-2">AMOUNT: </h4>
                                    <h3>PHP 0.00</h3>
                                </div>
                            </div>
                            <div class="col-md-12 p-0 mt-3 d-inline-flex">
                                <div class="col-md-2 p-0 pr-3">
                                    <p>Payment Date</p>
                                    <input type="date" id="expensedateedit"  {{$user_position->position!="CEO"? 'readonly' : ''}} name="expense_date" class="w-100" required>
                                </div>
                                <div class="col-md-2 p-0 pr-3">
                                    <p>Payment Method</p>
                                    <input type="text" list="payment_method_list" name="expense_payment_method" id="expense_payment_methodedit" placeholder="Enter text" class="w-100" required>
                                </div>
                                <div class="col-md-2 p-0 pr-3">
                                    <p>Reference No.</p>
                                    <input type="text" id="refnoedit" name="expense_reference_no" class="w-100" required>
                                </div>
                                <div class="col-md-2 p-0 pr-3" style="{{!empty($numbering) && $numbering->use_cost_center=="Off"? 'display:none;' : ''}}">
                                    <p>Cost Center</p>
                                    <select name="CostCenterExpenseEdit" id="CostCenterExpenseEdit" style="width:90%;" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : 'required'}}>
                                        <option value="">--Select Cost Center--</option>
                                        {!! $cc_list_after_foreach !!}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-1">
                                <h4>Account Details</h4>
                            </div>
                            <table class="table table-bordered table-responsive-md table-striped text-left font14" id="expense_account_tableedit">
                                <tr>
                                    <th class="text-left">#</th>
                                    <th class="text-left">ACCOUNT</th>
                                    <th class="text-left">DESCRIPTION</th>
                                    <th class="text-left">AMOUNT</th>
                                    <th class="text-center"></th>
                                </tr>
                                <!-- This is our clonable table line -->
                            </table>
                            <datalist id="account_expenses">
                            <option value="Amortisation expense">Expenses</option>
                            <option value="Bad debts">Expenses</option>
                            <option value="Bank charges">Expenses</option>
                            <option value="Commissions and fees">Expenses</option>
                            <option value="Dues and subscriptions">Expenses</option>
                            <option value="Equipment rental">Expenses</option>
                            <option value="Income tax expense">Expenses</option>
                            <option value="Insurance - Disablity">Expenses</option>
                            <option value="Insurance - General">Expenses</option>
                            </datalist>
                            <div class="col-md-12 p-0">
                                <div class="float-left">
                                    <div class="d-inline-flex">
                                        <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="add_lines_expense_account2">Add Items</button>
                                        <button class="btn btn-outline-dark rounded mr-1 font14"  type="button" id="clear_lines_expense_account2">Clear All Items</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-1 mt-4" style="display:none;">
                                <h4>Item Details</h4>
                            </div>
                            <table style="display:none;" class="table table-bordered table-responsive-md table-striped text-left font14" id="expense_item_tableedit">
                                <tr>
                                    <th class="text-left">#</th>
                                    <th class="text-left">PRODUCT/SERVICE</th>
                                    <th class="text-left">DESCRIPTION</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-left">RATE</th>
                                    <th class="text-left">AMOUNT</th>
                                    <th class="text-center"></th>
                                </tr>
                            </table>
                            <div class="col-md-12 p-0" style="display:none;">
                                <div class="float-left">
                                    <div class="d-inline-flex">
                                        <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="add_lines_expense_item2">Add Items</button>
                                        <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="clear_lines_expense_item2">Clear All Items</button>
                                    </div>
                                </div>
                                <div class="float-right mr-5">
                                    <div class="d-inline-flex mr-4">
                                        <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                        <p class="mb-0 text-dark font-weight-bold">PHP 1400.00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 p-0 mt-4">
                                <div class="col-md-6 pl-0">
                                    <p>Memo</p>
                                    <textarea rows="3" name="expense_memo" id="exmemoedit" class="w-100" ></textarea>
                                </div>
                                <div class="col-md-6 m-0 pr-0" style="display:none;">
                                    <div class="d-inline-flex">
                                        <p class="fa fa-paperclip"></p>
                                        <p class="p-0 ml-1">Maximum Size: 20MB</p>
                                    </div>
                                    <div class="input-group mb-3 p-0">
                                        <div class="custom-file">
                                            <input type="file" name="expense_attachment" class="custom-file-input" id="inputGroupFile01edit" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label bg-transparent" for="inputGroupFile01edit">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                        <button id="expenseadd" class="btn btn-success rounded" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    <div class="modal fade p-0" id="editbillmodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
            <script>
                function update_expenses_bill(){
                    var customer=document.getElementById('billpayeeedit').value;
                    var address=document.getElementById('bill_billing_addressedit').value;
                    
                    var term=document.getElementById('bill_termsedit').value;
                    var billdate=document.getElementById('billdateedit').value;
                    var duedate=document.getElementById('billduedateedit').value;
                    var billno=document.getElementById('billbillnoedit').value;
                    var memo=document.getElementById('bill_memoedit').value;
                    var update_bill_id=document.getElementById('update_bill_id').value;
                    var CI_bill_edit=document.getElementById('CI_bill_edit').value;
                    var PO_bill_edit=document.getElementById('PO_bill_edit').value;
                    var RF_bill_edit=document.getElementById('RF_bill_edit').value;
                    var bill_account_credit_account_edit=document.getElementById('bill_account_credit_account_edit').value;
                    var accounts1=[];
                    var desc1=[];
                    var amount1=[];

                    var produt=[];
                    var produt_desc=[];
                    var produt_qty=[];
                    var produt_rate=[];

                    $(".bill_lines_account2").find('.bill_data').each(function() {
                        if( typeof( $(this).attr('id') ) != 'undefined' ) {
                            var id = $(this).attr("id");
                            //asdasdasd
                            var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
                            //accounts.push(document.getElementById(id).value);
                            
                            var acc="select_account_bill";
                            var des="select_description_bill";
                            var amo="select_bill_amount";
                            if(id.indexOf(acc) >= 0){
                                accounts1.push(document.getElementById(id).value);
                            }
                            else if(id.indexOf(des) >= 0){
                                desc1.push(document.getElementById(id).value);
                            }
                            else if(id.indexOf(amo) >= 0){
                                amount1.push(document.getElementById(id).value);
                            }   
                        } 
                    });
                    $(".bill_lines_item2").find('.bill_data').each(function() {
                        if( typeof( $(this).attr('id') ) != 'undefined' ) {
                            var id = $(this).attr("id");
                            var name = id.replace(id.match(/(\d+)/g)[0], '').trim();
                            
                            var pro="select_product_name_bill";
                            var pr_desc="select_product_description_bill";
                            var pr_qty="product_qty_bill";
                            var pr_rate="select_product_rate_bill";
                            if(id.indexOf(pro) >= 0){
                                produt.push(document.getElementById(id).value);
                            }
                            else if(id.indexOf(pr_desc) >= 0){
                                produt_desc.push(document.getElementById(id).value);
                            }
                            else if(id.indexOf(pr_qty) >= 0){
                                produt_qty.push(document.getElementById(id).value);
                            }
                            else if(id.indexOf(pr_rate) >= 0){
                                produt_rate.push(document.getElementById(id).value);
                            }
                        }
                    });

                    $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('update_expenses_bill') }}',                
                    data: {bill_account_credit_account_edit:bill_account_credit_account_edit,CI_bill_edit:CI_bill_edit,PO_bill_edit:PO_bill_edit,RF_bill_edit:RF_bill_edit,customer:customer,address:address,term:term,billdate:billdate,duedate:duedate,billno:billno,memo:memo,update_bill_id:update_bill_id,accounts1:accounts1,desc1:desc1,amount1:amount1,produt:produt,produt_desc:produt_desc,produt_qty:produt_qty,produt_rate:produt_rate,_token: '{{csrf_token()}}'},
                    success: function(data) {
                       
                        swal({title: "Done!", text: "Updated Bill.", type: 
                            "success"}).then(function(){ 
                            location.reload();
                        });
                    }  

                    })

                }
            </script>
            <form action="#" class="form-horizontal " id="edit_bill_form" onsubmit="update_expenses_bill()" autocomplete="off">
            {{ csrf_field() }}
            <input id="update_bill_id" name="item_count_bills" value="0" hidden>
            <input id="account_count_billsedit" name="account_count_bills" value="0" hidden>
                <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
                    <div class="modal-content" style="min-height: 100vh;">
                        <div class="modal-header">
                            <h5 class="modal-title">Bill</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body p-4" id="result">
                            <div class="col-md-12 p-0 mb-4">
                                <div class="col-md-12 p-0">
                                    <div class="col-md-2 p-0 pr-3">
                                        <p>Bill No.</p>
                                        <input type="text" name="bill_bill_no"  id="billbillnoedit" class="w-100 form-control" readonly>
                                    </div>
                                    <div class="col-md-2 p-0 pr-3">
                                        <p>Bill Date</p>
                                        <input type="date" {{$user_position->position!="CEO"? 'readonly' : ''}} name="bill_date" id="billdateedit" class="w-100 form-control" required>
                                    </div>
                                    <div class="col-md-2 p-0 pr-3">
                                        <p>Due Date</p>
                                        <input type="date" id="billduedateedit" name="bill_due_date" class="w-100 form-control" required>
                                    </div>
                                    <div class="col-md-4 p-0 d-inline-flex center-content" style="text-align:center;">
                                        <h4 class="mr-2">BALANCE DUE: </h4>
                                        <h3>PHP 0.00</h3>
                                    </div>
                                </div>
                                <div class="col-md-12 p-0">
                                    
                                    <div class="col-md-4 p-0 pr-3" style="{{!empty($numbering) && $numbering->use_cost_center=="Off"? 'display:none;' : ''}}">
                                        <p>Cost Center</p>
                                        <select name="CostCenterBillEdit" id="CostCenterBillEdit" class="w-100 selectpicker" data-live-search="true" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : 'required'}}>
                                            <option value="">--Select Cost Center--</option>
                                            {!! $cc_list_after_foreach !!}
                                        </select>
                                    </div>
                                    <div class="col-md-3 p-0">
                                    </div>
                                    
                                </div>
                                <div class="col-md-12 p-0">
                                <div class="col-md-4 p-0 pr-3">
                                    <p>Name</p>
                                    <select id="billpayeeedit" type="text" name="bill_customer" class="w-100 selectpicker" data-live-search="true" required>
                                    <option value="">--Select Name--</option>
                                    {!! $customers_list_after_foreach !!}
                                    </select>
                                </div>
                                </div>
                                <div class="col-md-12 p-0 d-inline-flex">
                                    <div class="col-md-4 p-0 pr-3">
                                        <p>Billing Address</p>
                                        <input type="text" name="bill_billing_address" id="bill_billing_addressedit" class="w-100 form-control">
                                    </div>
                                    <div class="col-md-2 p-0 pr-3">
                                        <p>Terms</p>
                                        <input type="text" list="terms_list" name="bill_terms" id="bill_termsedit" class="w-100 form-control">
                                    </div>
                                    
                                </div>
                                <div class="col-md-12 p-0 d-inline-flex">
                                        <div class="col-md-2 p-0 pr-3">
                                            <p>RF</p>
                                            <input type="text" name="RF_bill_edit" id="RF_bill_edit" placeholder="Request Form" class="w-100 form-control" required>
                                        </div>
                                        <div class="col-md-2 p-0 pr-3">
                                            <p>PO</p>
                                            <input type="text" name="PO_bill_edit" id="PO_bill_edit" placeholder="Purchase Order" class="w-100 form-control" required >
                                        </div>
                                        <div class="col-md-2 p-0 pr-3">
                                            <p>CI</p>
                                            <input type="text" name="CI_bill_edit" id="CI_bill_edit" placeholder="Charge Invoice" class="w-100 form-control"  required>
                                        </div>
                                    </div>
                                <div class="col-md-12 mb-1 mt-3">
                                    <h4>Account Details</h4>
                                </div>
                                <table class="table table-bordered table-responsive-md table-sm text-left font14" id="bill_account_tableedit">
                                    <thead>
                                        <tr>
                                            <th class="text-left">#</th>
                                            <th class="text-left" width="30%">ACCOUNT</th>
                                            <th class="text-left">DESCRIPTION</th>
                                            <th class="text-left">AMOUNT</th>
                                            <th class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="bill_account_tableedit_tbody">

                                    </tbody>
                                </table>
                                <div class="col-md-12 p-0">
                                    <div class="float-left">
                                        <div class="d-inline-flex">
                                            <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="add_lines_bill_account2">Add Items</button>
                                            <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="clear_lines_bill_account2">Clear All Items</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-1 mt-4" style="display:none;">
                                    <h4>Item Details</h4>
                                </div>
                                <table style="display:none;" class="table table-bordered table-responsive-md table-striped text-left font14" id="bill_item_tableedit">
                                    <tr>
                                        <th class="text-left">#</th>
                                        <th class="text-left">PRODUCT/SERVICE</th>
                                        <th class="text-left">DESCRIPTION</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-left">RATE</th>
                                        <th class="text-left">AMOUNT</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </table>
                                <div class="col-md-12 p-0" style="display:none;">
                                    <div class="float-left">
                                        <div class="d-inline-flex">
                                            <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="add_lines_bill_item2">Add Items</button>
                                            <button class="btn btn-outline-dark rounded mr-1 font14" type="button" id="clear_lines_bill_item2">Clear All Items</button>
                                        </div>
                                    </div>
                                    <div class="float-right mr-5">
                                        <div class="d-inline-flex mr-4">
                                            <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                            <p class="mb-0 text-dark font-weight-bold">PHP 1400.00</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 p-0 mt-4">
                                    <div class="col-md-6 pl-0">
                                        <p>Memo</p>
                                        <textarea rows="3" class="w-100 form-control" id="bill_memoedit" name="bill_memo" ></textarea>
                                    </div>
                                    <div class="col-md-6 m-0 pr-0" style="display:none;">
                                        <div class="d-inline-flex" >
                                            <p class="fa fa-paperclip"></p>
                                            <p class="p-0 ml-1">Maximum Size: 20MB</p>
                                        </div>
                                        <div class="input-group mb-3 p-0">
                                            <div class="custom-file" style="display:none;">
                                                <input type="file" name="bill_attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-12 p-0 mt-4">
                                    <div class="col-md-4 p-0 mt-4">
                                        <table class="table table-light table-sm" style="margin-bottom:0px;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th colspan="2" style="vertical-align:middle;text-align:center;">Credit</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table class="table table-light table-sm" id="bill_edit_credit_account_code">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th width="30%" style="vertical-align:middle;text-align:center;">Code</th>
                                                    <th width="70%" style="vertical-align:middle;text-align:center;">Account</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bill_edit_credit_account_code_tbody">
                                                <tr>
                                                    <td style="vertical-align:middle;" class="pr-0">
                                                        <select class="form-control selectpicker" data-live-search="true" name="bill_account_credit_account_edit_code"  id="bill_account_credit_account_edit_code" onchange="setsraccountdebitcode('bill_account_credit_account_edit_code','bill_account_credit_account_edit')" required>
                                                        <option value="">--Select Account--</option>
                                                        @foreach($c_o_a_sorted as $coa)
                                                        @if ($coa->id=="90")
                                                        <option  value="{{$coa->id}}" selected>{{$coa->coa_code}}</option>  
                                                        @else
                                                        <option  value="{{$coa->id}}">{{$coa->coa_code}}</option>   
                                                        @endif
                                                        
                                                        @endforeach
                                                        </select>
                                                        
                                                    </td>
                                                    <td style="vertical-align:middle;" class="pr-0">
                                                        <select class="form-control selectpicker" onchange="setsraccountdebitcode('bill_account_credit_account_edit','bill_account_credit_account_edit_code')" data-live-search="true" name="bill_account_credit_account_edit"  id="bill_account_credit_account_edit" required>
                                                        <option value="">--Select Account--</option>
                                                        @foreach($c_o_a_sorted as $coa)
                                                        @if ($coa->id=="90")
                                                        <option  value="{{$coa->id}}" selected>{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>  
                                                        @else
                                                        <option  value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>   
                                                        @endif
                                                        
                                                        @endforeach
                                                        </select>
                                                        
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                            <button id="billadd" class="btn btn-success rounded" type="submit">Save</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
            <button style="display:none;" data-toggle="modal" data-target="#editexpensemodal" id="editexpensebuttonmodal"></button>
            <button style="display:none;" data-toggle="modal" data-target="#editsuppliercreditmodal" id="editsuppliercreditbuttonmodal"></button>
            <button style="display:none;" data-toggle="modal" data-target="#editbillmodal" id="editbillbuttonmodal"></button>
            <button style="display:none;" data-toggle="modal" data-target="#editchequemodal" id="editchequebuttonmodal"></button>
<!--Invoice Modal Edit-->
<script>
    function DeleteRowCreditCard(index){
        $('#cc_line_accountedit'+index).remove();
    }
function ViewExpenseTransaction(id,type,modal_id){
    var question;
    var r = confirm("Are You Sure you want to Change this?\nAny Changes here will be subject for Approval");
    if (r == true) {                        
        //alert(type+" "+id);   
                               @foreach($expense_transactions as $et)
                                  if(id=='{{$et->et_no}}' && type=='{{$et->et_type}}'){
                                    // alert('{{$et->et_no}}'+" "+type+" {{$et->et_type}}");
                                       if('{{$et->et_type}}'=="Expense"){
                                           
                                           var tblCustomers= document.getElementById('expense_account_tableedit');
                                           var rowCount = tblCustomers.rows.length;
                                           for (var i = rowCount - 1; i > 0; i--) {
                                               tblCustomers.deleteRow(i);
                                           }
                                           var tblCustomers= document.getElementById('expense_item_tableedit');
                                           var rowCount = tblCustomers.rows.length;
                                           for (var i = rowCount - 1; i > 0; i--) {
                                               tblCustomers.deleteRow(i);
                                           }
                                           document.getElementById('expensepayeeedit').value="{{$et->et_customer}}";
                                           document.getElementById('update_expense_id').value="{{$et->et_no}}";
                                           document.getElementById('expenseaccountedit').value="{{$et->et_account}}";
                                           document.getElementById('expensepayeeedit').disabled=true;
                                           document.getElementById('expensedateedit').value="{{$et->et_date}}";
                                           document.getElementById('expense_payment_methodedit').value="{{$et->et_payment_method}}";
                                           document.getElementById('refnoedit').value="{{$et->et_reference_no}}";
                                           document.getElementById('exmemoedit').value="{{$et->et_memo}}";

                                           @foreach($et_acc as $ac)
                                               if("{{$et->et_no}}"=="{{$ac->et_ad_no}}"){
                                                   
                                                   var markup = '<tr class="expense_lines_account2" id="expense_line_account'+$('#expense_account_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_expense_account" contenteditable="false">'+$('#expense_account_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" list="account_expenses" class="expense_data account_select_expense" id="select_account_expense'+$('#expense_account_tableedit tr').length+'"><option></option>'+coa_list_js+'</select></td><td class="pt-3-half"><input value="{{$ac->et_ad_desc}}" class="expense_data description_select_expense" id="select_description_expense'+$('#expense_account_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" value="{{$ac->et_ad_total}}" class="expense_data amount_select_expense" onclick="this.select();" id="select_expense_amount'+$('#expense_account_tableedit tr').length+'" style="border:0; text-align:center;"></td><td class="pt-3-half"><a href="#" id="delete_account_expense'+$('#expense_account_tableedit tr').length+'" class="fa fa-trash delete_account_expense"></a></td></tr>';
                                                   
                                                   $("#expense_account_tableedit").append(markup);
                                                   
                                                   document.getElementById('select_account_expense'+($('#expense_account_tableedit tr').length-1)).value="{{$ac->et_ad_product}}";
                                               }
                                           @endforeach
                                           
                                           @foreach($et_it as $it)
                                           if("{{$et->et_no}}"=="{{$it->et_id_no}}"){
                                              
                                               var markup = '<tr class="expense_lines_item2" id="expense_line_item'+$('#expense_item_table tr').length+'"><td class="pt-3-half" id="number_tag_expense_item" contenteditable="false">'+$('#expense_item_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="expense_data product_select_expense" id="select_product_name_expense'+$('#expense_item_tableedit tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input value="{{$it->et_id_desc}}" class="expense_data product_description_expense" id="select_product_description_expense'+$('#expense_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" value="{{$it->et_id_qty}}" class="expense_data product_qty_expense" onclick="this.select();" id="product_qty_expense'+$('#expense_item_tableedit tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input value="{{$it->et_id_rate}}" class="expense_data product_rate_expense" id="select_product_rate_expense'+$('#expense_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_expense" id="total_amount_expense'+$('#expense_item_tableedit tr').length+'">{{$it->et_id_total}}</td><td class="pt-3-half"><a href="#" id="delete_product_expense'+$('#expense_item_tableedit tr').length+'" class="fa fa-trash delete_product_expense"></a></td></tr>';
                                               $("#expense_item_tableedit").append(markup);
                                               document.getElementById('select_product_name_expense'+($('#expense_item_tableedit tr').length-1)).value="{{$it->et_id_product}}";
                                               
                                           }
                                           @endforeach
                                           @foreach($JournalEntry as $JE)
                                               if("{{$JE->other_no}}"==id){
                                                document.getElementById('CostCenterExpenseEdit').value="{{$JE->je_cost_center}}";  
                                               }
                                           @endforeach

                                       }
                                       if('{{$et->et_type}}'=="Credit card credit"){
                                        var tblCustomers= document.getElementById('cc_account_tableedit');
                                        var rowCount = tblCustomers.rows.length;
                                        for (var i = rowCount - 1; i > 0; i--) {
                                        tblCustomers.deleteRow(i);
                                        }
                                        var tblCustomers= document.getElementById('cc_account_tableedit');
                                        var rowCount = tblCustomers.rows.length;
                                        for (var i = rowCount - 1; i > 0; i--) {
                                        tblCustomers.deleteRow(i);
                                        }
                                        document.getElementById('cc_customeredit').value="{{$et->et_customer}}";
                                        document.getElementById('cc_edit_transaction_id').value="{{$et->et_no}}";
                                        
                                        document.getElementById('cc_customeredit').disabled=true;
                                        document.getElementById('cc_dateedit').value="{{$et->et_date}}";
                                        document.getElementById('cc_accountedit').value="{{$et->et_account}}";
                                        document.getElementById('cc_reference_noedit').value="{{$et->et_reference_no}}";
                                        //ccbalanceedit
                                        @foreach($et_acc as $ac)
                                               if("{{$et->et_no}}"=="{{$ac->et_ad_no}}"){
                                                var markup = '<tr class="cc_line_accountedit" id="cc_line_accountedit'+$('#cc_account_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_cc_accountedit" contenteditable="false">'+$('#cc_account_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="cc_data account_select_cc" id="select_account_ccedit'+$('#cc_account_tableedit tr').length+'"><option></option>'+coa_list_js+'</select></td><td class="pt-3-half"><input class="cc_data description_select_cc" value="{{$ac->et_ad_desc}}" id="select_description_ccedit'+$('#cc_account_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="cc_data amount_select_cc" value="{{$ac->et_ad_total}}" onclick="this.select();" id="select_cc_amountedit'+$('#cc_account_tableedit tr').length+'" style="border:0; text-align:center;"></td><td class="pt-3-half"><a href="#" id="delete_account_ccedit'+$('#cc_account_tableedit tr').length+'" class="fa fa-trash delete_account_ccedit" onclick="DeleteRowCreditCard('+$('#cc_account_tableedit tr').length+')"></a></td></tr>';
                                                $("#cc_account_tableedit").append(markup);

                                                document.getElementById('select_account_ccedit'+($('#cc_account_tableedit tr').length-1)).value="{{$ac->et_ad_product}}";
                                               }
                                        @endforeach
                                        
                                       }
                                       if('{{$et->et_type}}'=="Bill"){
                                           var tblCustomers= document.getElementById('bill_account_tableedit');
                                           var rowCount = tblCustomers.rows.length;
                                           console.log(rowCount+" asd");
                                           for (var i = rowCount-1; i > 0; i--) {
                                               tblCustomers.deleteRow(i);
                                               console.log(rowCount+" deleted");
                                           }
                                           var tblCustomers= document.getElementById('bill_item_tableedit');
                                           var rowCount = tblCustomers.rows.length;
                                           for (var i = rowCount - 1; i > 0; i--) {
                                               tblCustomers.deleteRow(i);
                                           }

                                           document.getElementById('billpayeeedit').value="{{$et->et_customer}}";
                                           document.getElementById('update_bill_id').value="{{$et->et_no}}";
                                           //document.getElementById('billpayeeedit').disabled=true;
                                           document.getElementById('bill_billing_addressedit').value="{{$et->et_billing_address}}";
                                           document.getElementById('bill_termsedit').value="{{$et->et_terms}}";
                                           document.getElementById('billdateedit').value="{{$et->et_date}}";
                                           document.getElementById('billduedateedit').value="{{$et->et_due_date}}";
                                           document.getElementById('billbillnoedit').value="{{$et->et_bill_no}}";
                                           document.getElementById('bill_memoedit').value="{{$et->et_memo}}";
                                           
                                           document.getElementById('RF_bill_edit').value="{{$et->et_shipping_address}}";
                                           document.getElementById('PO_bill_edit').value="{{$et->et_shipping_to}}";
                                           document.getElementById('CI_bill_edit').value="{{$et->et_shipping_via}}";
                                           
                                           @foreach($et_acc as $ac)
                                            console.log('{{$ac->et_ad_type}}');
                                               if("{{$et->et_no}}"=="{{$ac->et_ad_no}}" && type=='{{$ac->et_ad_type}}'){
                                                    var count=$('#bill_account_tableedit_tbody tr').length+parseFloat(1);
                                                    var markup = '<tr class="bill_lines_account2" id="bill_line_account'+count+'"><td style="padding-left:5px;" class="pt-3-half" id="number_tag_bill_account" contenteditable="false">'+count+'</td><td class="pt-3-half" ><select style="border:0; width:100%;" list="account_expenses" class="bill_data account_select_bill selectpicker form-control" data-live-search="true" id="select_account_bill'+count+'"><option></option>'+coa_list_js+'</select></td><td class="pt-3-half"><input value="{{$ac->et_ad_desc}}" class="form-control bill_data description_select_bill" id="select_description_bill'+count+'" style="border:0;"></td><td class="pt-3-half">';
                                                    markup=markup+'<input type="text" class="sssss form-control" value="{{number_format($ac->et_ad_total,2)}}" id="unformated_select_bill_rate'+count+'" style="border:0;text-align:right;">';
                                                    markup=markup+'<input step="0.01" type="hidden" value="{{$ac->et_ad_total}}" class="bill_data amount_select_bill" onclick="this.select();" id="select_bill_amount'+count+'" style="border:0; text-align:center;"></td><td class="pt-3-half" style="padding-left:5px;"><a href="#" id="delete_account_bill'+count+'" class="fa fa-trash delete_account_bill"></a></td></tr>';
                                                    var textbox{{$ac->et_ad_id}} = '#unformated_select_bill_rate'+count;
						                            var hidden{{$ac->et_ad_id}} = '#select_bill_amount'+count;
                                                    $("#bill_account_tableedit_tbody").append(markup);
                                                    $(textbox{{$ac->et_ad_id}}).keyup(function () {
                                                        $(textbox{{$ac->et_ad_id}}).val(this.value.match(/[0-9.,-]*/));
                                                    var num = $(textbox{{$ac->et_ad_id}}).val();
                                                        var comma = /,/g;
                                                        num = num.replace(comma,'');
                                                        $(hidden{{$ac->et_ad_id}}).val(num);
                                                        $(hidden{{$ac->et_ad_id}}).attr('title',num);
                                                        var numCommas = addCommas(num);
                                                        $(textbox{{$ac->et_ad_id}}).val(numCommas);
                                                    });
                                                    console.log(count+" count->"+'{{$ac->et_ad_type}}');
                                                   document.getElementById('select_account_bill'+(count)).value="{{$ac->et_ad_product}}";
                                               }
                                           @endforeach

                                           @foreach($et_it as $it)
                                           if("{{$et->et_no}}"=="{{$it->et_id_no}}" && type=='{{$it->et_type}}'){
                                               var markup = '<tr class="bill_lines_item2" id="bill_line_item'+$('#bill_item_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_bill_item" contenteditable="false">'+$('#bill_item_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="bill_data product_select_bill" id="select_product_name_bill'+$('#bill_item_tableedit tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="bill_data product_description_bill" value="{{$it->et_id_desc}}" id="select_product_description_bill'+$('#bill_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" value="{{$it->et_id_qty}}" class="bill_data product_qty_bill" onclick="this.select();" id="product_qty_bill'+$('#bill_item_tableedit tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input value="{{$it->et_id_rate}}" class="bill_data product_rate_bill" id="select_product_rate_bill'+$('#bill_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_bill" id="total_amount_bill'+$('#bill_item_tableedit tr').length+'">{{$it->et_id_total}}</td><td class="pt-3-half"><a href="#" id="delete_product_bill'+$('#bill_item_tableedit tr').length+'" class="fa fa-trash delete_product_bill"></a></td></tr>';
                                               $("#bill_item_tableedit").append(markup);
                                               document.getElementById('select_product_name_bill'+($('#bill_item_tableedit tr').length-1)).value="{{$it->et_id_product}}";
                                               console.log('select_product_name_bill'+($('#bill_item_tableedit tr').length-1)+" "+"{{$it->et_id_product}}");
                                           }
                                           @endforeach
                                           @foreach($JournalEntry as $JE)
                                               if("{{$JE->other_no}}"==id && "{{$JE->je_transaction_type}}"=="Bill"){
                                                document.getElementById('CostCenterBillEdit').value="{{$JE->je_cost_center}}";  
                                                if("{{$JE->je_credit}}"!=""){
                                                    document.getElementById('bill_account_credit_account_edit_code').value="{{$JE->je_account}}";
                                                    document.getElementById('bill_account_credit_account_edit').value="{{$JE->je_account}}";
                                                }
                                                
                                               }
                                           @endforeach
                                           refreshpicjer();
                                       }
                                       if('{{$et->et_type}}'=="Cheque"){
                                           var tblCustomers= document.getElementById('cheque_account_tableedit');
                                           var rowCount = tblCustomers.rows.length;
                                           for (var i = rowCount - 1; i > 0; i--) {
                                               tblCustomers.deleteRow(i);
                                           }
                                           var tblCustomers= document.getElementById('cheque_item_tableedit');
                                           var rowCount = tblCustomers.rows.length;
                                           for (var i = rowCount - 1; i > 0; i--) {
                                               tblCustomers.deleteRow(i);
                                           }

                                           document.getElementById('chequepayeeedit').value="{{$et->et_customer}}";
                                           document.getElementById('chequepayeeedit').disabled=true;
                                           document.getElementById('chequeaccedit').value="{{$et->et_account}}";
                                           document.getElementById('cheque_billing_addressedit').value="{{$et->et_billing_address}}";
                                           document.getElementById('chequedateedit').value="{{$et->et_date}}";
                                           document.getElementById('chequenoedit').value="{{$et->et_reference_no}}";
                                           document.getElementById('chequememoedit').value="{{$et->et_memo}}";
                                           document.getElementById('update_cheque_id').value="{{$et->et_no}}";
                                           @foreach($et_acc as $ac)
                                               if("{{$et->et_no}}"=="{{$ac->et_ad_no}}"){
                                                   
                                                   var markup = '<tr class="cheque_lines_account2" id="cheque_line_account'+$('#cheque_account_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_cheque_account" contenteditable="false">'+$('#cheque_account_tableedit tr').length+'</td><td class="pt-3-half"><select value="{{$ac->et_ad_product}}" style="border:0; width:100%;" list="account_expenses" class="cheque_data account_select_cheque" id="select_account_cheque'+$('#cheque_account_tableedit tr').length+'"><option></option>'+coa_list_js+'</select></td><td class="pt-3-half"><input value="{{$ac->et_ad_desc}}" class="cheque_data description_select_cheque" id="select_description_cheque'+$('#cheque_account_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" value="{{$ac->et_ad_total}}" class="cheque_data amount_select_cheque" onclick="this.select();" id="select_cheque_amount'+$('#cheque_account_tableedit tr').length+'" style="border:0; text-align:center;"></td><td class="pt-3-half"><a href="#" id="delete_account_cheque'+$('#cheque_account_tableedit tr').length+'" class="fa fa-trash delete_account_cheque"></a></td></tr>';
           
           
                                                   $("#cheque_account_tableedit").append(markup);
                                                   document.getElementById('select_account_cheque'+($('#cheque_account_tableedit tr').length-1)).value="{{$ac->et_ad_product}}";
                                               }
                                           @endforeach
                                        var total_initial_amount=0;
                                           @foreach($et_it as $it)
                                           if("{{$et->et_no}}"=="{{$it->et_id_no}}"){
                                               
                                               var markup = '<tr class="cheque_lines_item2" id="cheque_line_item_edit'+$('#cheque_item_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_cheque_item" contenteditable="false">'+$('#cheque_item_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="cheque_data product_select_cheque" id="select_product_name_cheque'+$('#cheque_item_tableedit tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="cheque_data product_description_cheque" value="{{$it->et_id_desc}}" id="select_product_description_cheque'+$('#cheque_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="cheque_data product_qty_cheque" value="{{$it->et_id_qty}}" onclick="this.select();" id="product_qty_cheque'+$('#cheque_item_tableedit tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input value="{{number_format($it->et_id_rate,2)}}" title="{{$it->et_id_rate}}" class="cheque_data product_rate_cheque" readonly id="select_product_rate_cheque'+$('#cheque_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_cheque" id="total_amount_cheque'+$('#cheque_item_tableedit tr').length+'" title="{{$it->et_id_total}}">{{number_format($it->et_id_total,2)}}</td><td class="pt-3-half"><a href="#" id="delete_product_cheque_edit'+$('#cheque_item_tableedit tr').length+'" class="fa fa-trash delete_product_cheque_edit"></a></td></tr>';
                                               total_initial_amount=total_initial_amount+parseFloat('{{$it->et_id_total}}');
                                               $("#cheque_item_tableedit").append(markup);
                                               
                                               document.getElementById('select_product_name_cheque'+($('#cheque_item_tableedit tr').length-1)).value="{{$it->et_id_product}}";
                                               
                                               
                                           }
                                           @endforeach
                                           document.getElementById('cheque_edit_item_total').innerHTML="PHP "+number_format(total_initial_amount,2);
                                           @foreach($JournalEntry as $JE)
                                               if("{{$JE->other_no}}"==id){
                                                document.getElementById('CostCenterChequeEdit').value="{{$JE->je_cost_center}}";

                                               }
                                           @endforeach
                                           

                                       }
                                       if('{{$et->et_type}}'=="Supplier credit"){
                                           var tblCustomers= document.getElementById('sc_account_tableedit');
                                           var rowCount = tblCustomers.rows.length;
                                           for (var i = rowCount - 1; i > 0; i--) {
                                               tblCustomers.deleteRow(i);
                                           }
                                           var tblCustomers= document.getElementById('sc_item_tableedit');
                                           var rowCount = tblCustomers.rows.length;
                                           for (var i = rowCount - 1; i > 0; i--) {
                                               tblCustomers.deleteRow(i);
                                           }

                                           document.getElementById('sc_customeredit').value="{{$et->et_customer}}";
                                           document.getElementById('update_sc_id').value="{{$et->et_no}}";
                                           document.getElementById('sc_customeredit').disabled=true;
                                           document.getElementById('sc_mail_addressedit').value="{{$et->et_billing_address}}";

                                           document.getElementById('scdateedit').value="{{$et->et_date}}";
                                           
                                           document.getElementById('screfnoedit').value="{{$et->et_reference_no}}";
                                           document.getElementById('sc_memoedit').value="{{$et->et_memo}}";

                                           @foreach($et_acc as $ac)
                                               if("{{$et->et_no}}"=="{{$ac->et_ad_no}}" && type=='{{$ac->et_ad_type}}'){
                                                   var count=$('#sc_account_tableedit_tbody tr').length+parseFloat(1);
                                                   var markup = '<tr class="sc_lines_account2" id="sc_line_account'+count+'"><td class="pt-3-half" style="padding-left:5px;" id="number_tag_sc_account" contenteditable="false">'+count+'</td><td class="pt-3-half"><select style="border:0; width:100%;" list="account_expenses" class="sc_data account_select_sc selectpicker form-control" value="{{$ac->et_ad_product}}" id="select_account_sc'+count+'"><option></option>'+coa_list_js+'</select></td><td class="pt-3-half"><input class="sc_data form-control description_select_sc"  value="{{$ac->et_ad_desc}}" id="select_description_sc'+count+'" style="border:0;"></td><td class="pt-3-half"><input step="0.01" type="number" value="{{-$ac->et_ad_total}}" class="form-control sc_data amount_select_sc" onclick="this.select();" id="select_sc_amount'+count+'" style="border:0; text-align:right;"></td><td class="pt-3-half" style="padding-left:5px;"><a href="#" id="delete_account_sc'+count+'" class="fa fa-trash delete_account_sc"></a></td></tr>';
           
           
                                                   $("#sc_account_tableedit").append(markup);
                                                   
                                                   document.getElementById('select_account_sc'+(count)).value="{{$ac->et_ad_product}}";
                                               }
                                           @endforeach

                                           @foreach($et_it as $it)
                                           if("{{$et->et_no}}"=="{{$it->et_id_no}}" & type=='{{$it->et_type}}'){
                                              
                                               var markup = '<tr class="sc_lines_item2" id="sc_line_item'+$('#sc_item_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_sc_item" contenteditable="false">'+$('#sc_item_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="sc_data product_select_sc" id="select_product_name_sc'+$('#sc_item_tableedit tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="sc_data product_description_sc" value="{{$it->et_id_desc}}" id="select_product_description_sc'+$('#sc_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" value="{{$it->et_id_qty}}" class="sc_data product_qty_sc" onclick="this.select();" id="product_qty_sc'+$('#sc_item_tableedit tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input value="{{$it->et_id_rate}}" class="sc_data product_rate_sc" id="select_product_rate_sc'+$('#sc_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_sc" id="total_amount_sc'+$('#sc_item_tableedit tr').length+'">{{$it->et_id_total}}</td><td class="pt-3-half"><a href="#" id="delete_product_sc'+$('#sc_item_tableedit tr').length+'" class="fa fa-trash delete_product_sc"></a></td></tr>';
           
                                               $("#sc_item_tableedit").append(markup);
                                               document.getElementById('select_product_name_sc'+($('#sc_item_tableedit tr').length-1)).value="{{$it->et_id_product}}";
                                               
                                           }
                                           @endforeach
                                           @foreach($JournalEntry as $JE)
                                               if("{{$JE->other_no}}"==id && "{{$JE->je_transaction_type}}"=="Supplier Credit"){
                                                
                                                document.getElementById('CostCenterSupplierCreditEdit').value="{{$JE->je_cost_center}}";
                                                if("{{$JE->je_debit}}"!=""){
                                                    
                                                    document.getElementById('supplier_credit_account_debit_account_edit_code').value="{{$JE->je_account}}";
                                                    document.getElementById('supplier_credit_account_debit_account_edit').value="{{$JE->je_account}}";
                                                }
                                                
                                               }
                                           @endforeach
                                           refreshpicjer();
                                       }
                                       
                                  }
                               @endforeach
                               open_modal_dyna(modal_id);
    }
}

function getModal(Location,TTTTT,e,type,sales){
    if(type=='Expense'){
        ViewExpenseTransaction(e,type);
        
    }else if(type=='Bill'){
        ViewExpenseTransaction(e,type);
        
    }
    else if(type=='Supplier Credit' || type=='Supplier credit'){
        ViewExpenseTransaction(e,type);
        
    }
    else if(type=='Cheque'){
        ViewExpenseTransaction(e,type);
        
    }
    else if(type=='Invoice'){
        var r = confirm("Are You Sure you want to Change this?\nAny Changes here will be subject for Approval");
        if (r == true) {
        $.ajax({
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            url: '{{ route('replaceeditinvoicemodal') }}',
            data: {Location:Location,TTTTT:TTTTT,id:e,type:type,_token: '{{csrf_token()}}'},
            success: function(data) {
                //alert(data);
                if(data=="Invalid"){

                }else{
                    $('#edit_invoice_form').replaceWith(data);
                    update_total_edit(); 
                    refreshpicjer();
                    document.getElementById("invoicejournalentrybuttonmodal").click();
                }
                
            } ,
            error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            alert(thrownError);
            }
        })
        }
        //$("#invoicemodalEdit").modal('toggle');
        
    }
    else if(type=="Payment"){
        var id = sales;

        $.ajax({
            method: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('get_all_transactions') }}",
            dataType: "text",
            data: {id:id},
            success: function (value) {
                var data = JSON.parse(value);
                $('#sales_transaction_number').val(data.st_no);
                var customer_transaction = data.st_customer_id;
                @foreach($customers as $customer)
                    if({{$customer->customer_id}} == customer_transaction){
                        $('#paymentcustomer').val('{{$customer->display_name}}');
                        $('#paymentbalance').text('PHP ' + number_format(data.st_balance,2));
                        $('#payment_customer_id').val('{{$customer->customer_id}}');
                        $('#p_payment_method').val('{{$customer->payment_method}}');
                        if('{{$customer->payment_method}}'=="Cheque"){
                            var x=document.getElementsByClassName("ChequeColumns");
                                    var i;
                                    for (i = 0; i < x.length; i++) {
                                    x[i].style.display = "block";
                                    }
                        }else{
                            var x=document.getElementsByClassName("ChequeColumns");
                                    var i;
                                    for (i = 0; i < x.length; i++) {
                                    x[i].style.display = "none";
                                    } 
                        }
                    }
                 @endforeach
            },
            error: function (data) {
                swal("Error!", "Transaction failed", "error");
            }
        });
        document.getElementById("paymentjournalentrybttonmodal").click();
    }
    else if(type=='Credit Note'){
        var r = confirm("Are You Sure you want to Change this?\nAny Changes here will be subject for Approval");
        if (r == true) {
        $.ajax({
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            url: '{{ route('replaceeditinvoicemodal') }}',
            data: {id:e,type:type,_token: '{{csrf_token()}}'},
            success: function(data) {
                //alert(data);
                $('#edit_invoice_form').replaceWith(data);
                update_total_edit();  
            } ,
            error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            alert(thrownError);
            }
        })

        //$("#invoicemodalEdit").modal('toggle');
        document.getElementById("invoicejournalentrybuttonmodal").click();
        }
    }
    else if(type=='Journal Entry'){
        var JE_no="";
        @foreach($JournalEntryLists as $JEL)
            if('{{$JEL->other_no}}'==e){
                JE_no='{{$JEL->je_no}}';
            }

        @endforeach
        edit_journal_entries(JE_no);
    }
    
    
}
</script>
<button id="invoicejournalentrybuttonmodal" style="display:none;" data-toggle="modal" data-target="#invoicemodalEdit"></button>
<button id="paymentjournalentrybttonmodal" style="display:none;" data-toggle="modal" data-target="#receivepaymentmodal"></button>
<button id="salesreceiptjournalentrybttonmodal" style="display:none;" data-toggle="modal" data-target="#salesreceiptmodal"></button>

<div class="modal fade p-0" id="invoicemodalEdit" tabindex="-1" role="dialog" aria-hidden="true" style="">
    <form action="#" class="form-horizontal " id="edit_invoice_form" onsubmit="editInvoice()" autocomplete="off">
        {{ csrf_field() }}
            <input id="transaction_type_edit" name="transaction_type_edit" value="Invoice" hidden>
            <input id="product_count_edit" name="product_count_edit" value="0" hidden>
            <input type="number" id="total_balance_edit" step="0.01" name="total_balance_edit" value="0" hidden>
            <input type="number" id="sales_transaction_number_estimate_edit" name="sales_transaction_number_estimate_edit" value="0" hidden>
            <input type="number" id="sales_transaction_number_delayed_charge_edit" name="sales_transaction_number_delayed_charge_edit" value="0" hidden>
            <input type="number" id="sales_transaction_number_delayed_credit_edit" name="sales_transaction_number_delayed_credit_edit" value="0" hidden>
            <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
                <div class="modal-content" style="min-height: 100vh;">
                    <div class="modal-header">
                        <h5 class="modal-title">Invoice</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body p-4" id="result_edit">
                        <div class="col-md-12 p-0 mb-4">
                            <div class="my-3 p-0">
                                <div class="col-md-4 p-0 pr-3">
                                    <select id="invoicecustomer_edit" type="text" name="customer_edit" class="w-100" required>
                                            <option value="">--Select Name--</option>
                                            {!! $customers_list_after_foreach !!}
                                    </select>
                                </div>
                                <div class="col-md-4 p-0">
                                    <input type="text" id="email_edit" name="email_edit" placeholder="Email (Separate emails with a comma)" class="w-100">
                                    <br>
                                    <div class="float-left">
                                        <input type="checkbox" name="send_later_edit" value="yes"> Send Now
                                    </div>
                                    <div class="float-right">
                                        <p class="text-info"></p>
                                    </div>
                                </div>
                                <div class="col-md-4 p-0 d-inline-flex center-content" style="text-align:center;">
                                    <h4 class="mr-2">BALANCE DUE: </h4>
                                    <h3 id="big_invoicebalance">PHP 0.00</h3>
                                </div>
                            </div>
                            <div class="col-md-12 p-0 mt-3">
                                <div class="col-md-4 p-0 pr-3">
                                    <p>Billing Address</p>
                                    <input type="text" name="bill_address_edit" id="bill_address_edit" class="w-100" required>
                                </div>
                                <div class="col-md-2 p-0 pr-3">
                                    <p>Terms</p>
                                    <input class="w-100" list="terms_list" name="term_edit" id="term_edit" required>
                                    <datalist id="terms_list">
                                        <option>Due on receipt</option>
                                        <option>Net 15</option>
                                        <option>Net 30</option>
                                        <option>Net 60</option>
                                    </datalist>
                                </div>
                                <div class="col-md-2 p-0 pr-3">
                                    <p>Invoice Date</p>
                                    <input id="invoicedate_edit" type="date" name="date_edit" class="w-100" required>
                                </div>
                                <div class="col-md-2 p-0">
                                    <p>Due Date</p>
                                    <input id="invoiceduedate_edit" type="date" name="due_date_edit" class="w-100" required>
                                </div>
                            </div>
        
                            <table id="invoice_table_edit" class="table table-bordered table-responsive-md table-striped text-left font14">
                                <tr>
                                    <th class="text-left">#</th>
                                    <th class="text-left">PRODUCT/SERVICE</th>
                                    <th class="text-left">DESCRIPTION</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-left">RATE</th>
                                    <th class="text-left">AMOUNT</th>
                                    <th class="text-center"></th>
                                </tr>
                                <!-- This is our clonable table line -->
                            </table>
                            <div class="col-md-12 p-0">
                                <div class="float-left">
                                    <div class="d-inline-flex">
                                        <button type="button" class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_invoic_edite">Add Items</button>
                                        <button type="button" class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_invoice_edit">Clear All Items</button>
                                        
                                    </div>
                                </div>
                                <div class="float-right mr-5">
                                    <div class="d-inline-flex mr-4">
                                        <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                        <p id="invoicetotal" class="mb-0 text-dark font-weight-bold">PHP 0.00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="float-right mr-5">
                                    <div class="d-inline-flex mr-4">
                                        <p class="pr-4 text-dark font-weight-bold">BALANCE DUE</p>
                                        <p id="invoicebalance" class="text-dark font-weight-bold">PHP 0.00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="col-md-6 pl-0">
                                    <p>Message Displayed on Invoice</p>
                                    <textarea rows="3" class="w-100" name="note_edit" id="note_edit" ></textarea>
                                </div>
                                <div class="col-md-6 pr-0">
                                    <p>Message Displayed on Statement</p>
                                    <textarea rows="3" class="w-100" name="memo_edit" id="memo_edit" ></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 m-0 p-0 mt-3" style="display:none;">
                                <div class="d-inline-flex">
                                    <p class="fa fa-paperclip"></p>
                                    <p class="p-0 ml-1">Maximum Size: 20MB</p>
                                </div>
                                <div class="input-group mb-3 p-0">
                                    <div class="custom-file">
                                        <input type="file" name="attachment_edit" class="custom-file-input" id="inputGroupFile01_edit" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                        <button id="invoiceadd_edit" class="btn btn-success rounded" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>   
</div>
<div class="modal fade p-0" id="receivepaymentmodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
<form action="#" class="form-horizontal " id="add_payment_form" onsubmit="addPayment()" autocomplete="off">
{{ csrf_field() }}
    
    <input id="payment_customer_id" name="payment_customer_id" value="" hidden>
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Receive Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="my-3 p-0">
                        <div class="col-md-4 p-0 pr-3">
                            <p>Name</p>
                            <input id="paymentcustomer" type="text" name="p_customer" id="p_customer" placeholder="Choose a customer" class="w-100" readonly required>
                        </div>
                        <div class="col-md-2 p-0 pr-3" style="display:none;">
                            <input type="text" name="p_email" id="p_email" placeholder="Email (Separate emails with a comma)" class="w-100">
                            <br>
                            <div class="float-left">
                                <input type="checkbox" name="p_send_later" value="yes"> Send Now
                            </div>
                            <div class="float-right">
                                <p class="text-info"></p>
                            </div>
                        </div>
                        <div class="col-md-2 p-0">
                            <p>Sales Receipt No</p>
                            <input id="" type="text" value="{{count($SS)+count($ETran)+$sales_exp_start_no}}" name="" class="w-100" readonly>
                        </div>
                        <div class="col-md-4 p-0 d-inline-flex center-content" style="text-align:center;">
                            <h4 class="mr-2">BALANCE DUE: </h4>
                            <h3 id="paymentbalance">PHP 0.00</h3>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-3 p-0 pr-3">
                            <p>Payment Date</p>
                            <input type="date" name="p_date" id="p_date" class="w-100" required>
                        </div>
                        <div class="col-md-3 p-0 pr-3">
                            <p>Payment For</p>
                            <input id="sales_transaction_number" name="sales_transaction_number" value="" readonly>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-3 d-inline-flex">
                        <div class="col-md-3 p-0 pr-3">
                            <p>Payment Method</p>
                            <input onkeyup="checkpayment_method(this)" onchange="checkpayment_method(this)" type="text" list="payment_method_list" name="p_payment_method" id="p_payment_method" placeholder="Choose payment method" class="w-100" required>
                            <datalist id="payment_method_list">
                                <option>Cash</option>
                                <option>Cheque</option>
                                <option>Cash & Cheque</option>
                            </datalist>
                        </div>
                        <script>
                            function checkpayment_method(input){
                                console.log(input.value);
                                if(input.value=="Cheque" || input.value=="Cash & Cheque"  ){
                                    var x=document.getElementsByClassName("ChequeColumns");
                                    var i;
                                    for (i = 0; i < x.length; i++) {
                                    x[i].style.display = "block";
                                    }
                                }else{
                                    var x=document.getElementsByClassName("ChequeColumns");
                                    var i;
                                    for (i = 0; i < x.length; i++) {
                                    x[i].style.display = "none";
                                    }
                                }
                            }
                        </script>
                        <div class="col-md-3 p-0 pr-3 ChequeColumns">
                            <p>Bank Account</p>
                            <select name="p_reference_no" id="p_reference_no" class="w-100">
                                <option value="">--Select Bank--</option>
                                @foreach ($banks as $bank)
                                @if($bank->bank_status=="1")
                                <option title="{{$bank->bank_account_no}}" value="{{$bank->bank_no}}">{{$bank->bank_name}}</option>
                                @endif
                                @endforeach
                            </select>
                            
                        </div>
                        <div class="col-md-3 p-0 pr-3 ChequeColumns" >
                            <p>Cheque No</p>
                            <input type="text" name="p_deposit_to" class="w-100">
                            
                        </div>
                        <div class="col-md-3 p-0">
                            <p>Amount Received</p>
                            <input type="number" id="payment_amount_receive_payment" min="0" step="0.01" name="p_amount"  class="w-100" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-3">
                        <div class="col-md-6 pl-0">
                            <p>Memo</p>
                            <textarea rows="3" class="w-100" name="p_memo"></textarea>
                        </div>
                        <div class="col-md-6 m-0 p-0" style="display:none;">
                            <div class="d-inline-flex">
                                <p class="fa fa-paperclip"></p>
                                <p class="p-0 ml-1">Maximum Size: 20MB</p>
                            </div>
                            <div class="input-group mb-3 p-0">
                                <div class="custom-file">
                                    <input type="file" name="p_attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button id="paymentadd" class="btn btn-success rounded" type="submit">Save</button>
            </div>
        </div>
    </div>
    </form>
</div>
<div class="modal fade p-0" id="estimatemodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
<form action="#" class="form-horizontal " id="add_estimate_form" onsubmit="addEstimate()" autocomplete="off">
{{ csrf_field() }}
    <input id="transaction_type_estimate" name="transaction_type_estimate" value="Estimate" hidden>
    <input id="product_count_estimate" name="product_count_estimate" value="0" hidden>
    <input type="number" id="total_balance_estimate" step="0.01" name="total_balance_estimate" value="0" hidden>
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Estimate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="col-md-12 p-0 " style="margin-bottom:20px;">
                        <div class="col-md-2 p-0 pr-3">
                            <p>Estimate No</p>
                            <input id="estimate_no" type="text" value="{{count($estimate_count)+$estimate_start_no}}" name="estimate_no" class="w-100 form-control" onkeyup="setestimate_no_new()"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                            <script>
                                function setestimate_no_new(){
                                    var invoice_no_field=document.getElementById('estimate_no').value;
                                    $.ajax({
                                        method: "POST",
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: "check_estimate_no",
                                        data: {invoice_no_field:invoice_no_field,_token: '{{csrf_token()}}'},
                                        success: function (data) {
                                            if(data>0){
                                                document.getElementById('estimate_no').style.border="1px solid red";
                                                document.getElementById('estimateadd').disabled=true;
                                            }else{
                                                document.getElementById('estimate_no').style.border="1px solid green";
                                                document.getElementById('estimateadd').disabled=false;
                                            }
                                        }
                                    });
                                }
                            </script>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Estimate Date</p>
                            <input type="date" name="e_date" id="e_date" class="w-100 form-control" required>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Expiration Date</p>
                            <input type="date" name="e_due_date" id="e_due_date" class="w-100 form-control" required>
                        </div>
                        
                        <div class="col-md-4 p-0 d-inline-flex center-content" style="text-align:center;">
                            <h4 class="mr-2">BALANCE DUE: </h4>
                            <h3 id="big_estimatebalance">PHP 0.00</h3>
                        </div>
                    </div>
                    <div class="my-3 p-0">
                        <div class="col-md-3 p-0 pr-3">
                            <p>Customer</p>
                            <select id="estimatecustomer" type="text" name="e_customer" class="w-100 selectpicker " data-live-search="true" required>
                            <option value="">--Select Name--</option>
                            {!! $customers_list_after_foreach !!}
                            </select>
                            
                        </div>
                        <div class="col-md-3 p-0 pr-3" style="display:none;">
                            <p>Email</p>
                            <input type="text" name="e_email" id="e_email" placeholder="Email (Separate emails with a comma)" class="w-100">
                            <br>
                            <div class="float-left">
                                <input type="checkbox" name="e_send_later" id="e_send_later"> Send Now
                            </div>
                            <div class="float-right">
                                <p class="text-info" style="margin-bottom:0px;"></p>
                            </div>
                        </div>
                        <div class="col-md-4 p-0 pr-3" style="margin-bottom:20px;">
                            <p>Billing Address</p>
                            <input type="text" name="e_bill_address" id="e_bill_address" class="w-100 form-control" required>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-responsive-md table-striped text-left font14" id="estimate_table">
                        <thead>
                            <tr>
                                <th class="text-left">#</th>
                                <th class="text-left">PRODUCT/SERVICE</th>
                                <th class="text-left" width="40%">DESCRIPTION</th>
                                <th class="text-center" width="10%">QTY</th>
                                <th class="text-left" width="15%">RATE</th>
                                <th class="text-left" width="15%">AMOUNT</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody  id="estimate_table_tbody">

                        </tbody>
                        
                        <!-- This is our clonable table line -->
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_estimate">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_estimate">Clear All Items</button>
                                
                            </div>
                        </div>
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                <p class="mb-0 text-dark font-weight-bold" id="estimatetotal">PHP 0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="pr-4 text-dark font-weight-bold">BALANCE DUE</p>
                                <p class="text-dark font-weight-bold" id="estimatebalance">PHP 0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-6 pl-0">
                            <p>Message Displayed on Estimate</p>
                            <textarea rows="3" class="w-100 form-control" name="e_note" id="e_note"></textarea>
                        </div>
                        <div class="col-md-6 pr-0">
                            <p>Memo</p>
                            <textarea rows="3" class="w-100 form-control" name="e_memo" id="e_memo"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 m-0 p-0 mt-3" style="display:none;">
                        <div class="d-inline-flex">
                            <p class="fa fa-paperclip"></p>
                            <p class="p-0 ml-1">Maximum Size: 20MB</p>
                        </div>
                        <div class="input-group mb-3 p-0">
                            <div class="custom-file">
                                <input type="file" name="e_attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button id="estimateadd" class="btn btn-success rounded" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>
</div>

<div class="modal fade p-0" id="salesreceiptmodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
    <script>
        $(document).ready(function(){
            $('#add_sales_receipt_form').submit(function(e){
                e.preventDefault();
            })
        })
    </script>
<form action="#" class="form-horizontal " id="add_sales_receipt_form" onsubmit="addSalesReceipt()" autocomplete="off">
    {{ csrf_field() }}
        <input type="hidden" id="reload_sr" name="reload_sr" value="0">
        <input id="transaction_type_sales_receipt" name="transaction_type_sales_receipt" value="Sales Receipt" hidden>
        <input type="number" id="total_balance_sales_receipt" step="0.01" name="total_balance_sales_receipt" value="0" hidden>
        <input id="product_count_sales_receipt" name="product_count_sales_receipt" value="0" hidden>
        <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
            <div class="modal-content" style="min-height: 100vh;">
                <div class="modal-header">
                    <h5 class="modal-title">Sales Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" id="sales_receipt_modalclose" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-4" id="result">
                    <div class="col-md-12 p-0 mb-4">
                            <div class="col-md-2 p-0 pr-3">
                                <p>Location</p>
                                <select class="w-100 form-control" id="sales_receipt_location_top" name="sales_receipt_location_top" disabled>
                                    <option value="Main">Main</option>
                                    <option value="Branch">Branch</option>
                                </select>
                            </div>
                            <div class="col-md-2 p-0 pr-3">
                                <p>Type</p>
                                <select class="w-100 form-control" id="sales_receipt_type_top" name="sales_receipt_type_top" disabled>
                                    <option >Sales Invoice</option>
                                    <option >Bill Invoice</option>
                                </select>
                            </div>
                        </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-4 p-0 pr-3">
                            <p>Sales Receipt No</p>
                            <input type="text" name="sales_receipt_no" id="sales_receipt_no" onkeyup="setsales_receipt_no_new()"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="w-100 form-control" value="{{count($sales_receipt_count)+$sales_receipt_start_no}}" required>
                            <script>
                                function setsales_receipt_no_new(){
                                    var invoice_no_field=document.getElementById('sales_receipt_no').value;
                                    $.ajax({
                                        method: "POST",
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: "check_sales_receipt_no",
                                        data: {invoice_no_field:invoice_no_field,_token: '{{csrf_token()}}'},
                                        success: function (data) {
                                            if(data>0){
                                                document.getElementById('sales_receipt_no').style.border="1px solid red";
                                                document.getElementById('salesradd').disabled=true;
                                            }else{
                                                document.getElementById('sales_receipt_no').style.border="1px solid green";
                                                document.getElementById('salesradd').disabled=false;
                                            }
                                        }
                                    });
                                }
                            </script>
                        </div>
                        <div class="col-md-2 p-0 pr-3 ">
                            <p>Sales Receipt Date</p>
                            <input type="date" name="sr_date" id="sr_date" class="w-100 form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="my-3 p-0 ">
                            <div class="col-md-4 p-0 pr-3  mb-4">
                                <p>Customer</p>
                                <select id="salesrcustomer" type="text" name="sr_customer" class="w-100 form-control" required disabled>
                                        <option value="">--Select Name--</option>
                                        {!! $customers_list_after_foreach !!}
                                </select>
                            </div>
                            <div class="col-md-2 p-0" style="display:none;">
                                <p>Email</p>
                                <input type="text" name="sr_email" id="sr_email" placeholder="Email (Separate emails with a comma)" class="w-100">
                                <br>
                                <div class="float-left">
                                    <input type="checkbox" name="sr_send_later"> Send Now
                                </div>
                                <div class="float-right">
                                    <p class="text-info" style="margin-bottom:0px;"></p>
                                </div>
                            </div>
                            <div class="col-md-2 p-0 pr-3" style="display:none;" >
                                <p>Cost Center</p>
                                <select name="CostCenterSalesReceipt" class="form-control"  id="CostCenterSalesReceipt" style="width:90%;" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : 'required'}} disabled>
                                    <option value="">--Select Cost Center--</option>
                                    {!! $cc_list_after_foreach !!}
                                </select>
                            </div>
                            <div class="col-md-2 p-0">
                                <p>Find Invoice</p>
                                <input type="text" class="form-control" id="invoiceno_sr" onchange="findInvoiceNo()" readonly onkeyup="findInvoiceNo()" name="invoiceno_sr" placeholder="Find by Invoice No">
                                <input type="hidden" name="invoice_location" id="invoice_location">
                                <input type="hidden" name="invoice_type" id="invoice_type">
                                <input type="hidden" name="invoice_item_no" id="invoice_item_no">
                                <script>
                                    function findInvoiceNo(){
                                        document.getElementById('clear_lines_sales_receipt').click();
                                        document.getElementById('salesrcustomer').value='';
                                        document.getElementById('CostCenterSalesReceipt').value='';
                                        
                                        document.getElementById('salesradd').disabled=true;
                                        document.getElementById('amountreceived_sr').value="0";
                                        document.getElementById('last_payment').innerHTML='0.00';
                                        
                                        //EnableSalesReceiptInput(document.getElementById('CostCenterSalesReceipt'));
                                        $('#salesrcustomer').change();
                                        $('#sales_receiptbalance').html('PHP 0.00');
                                        $('#big_sales_receiptbalance').html('PHP 0.00');
    
                                        var value=document.getElementById('invoiceno_sr').value;
                                        var location_invoice=document.getElementById('invoice_location').value;
                                        var type_invoice=document.getElementById('invoice_type').value;
                                        var invoice_item_no=document.getElementById('invoice_item_no').value;
                                        var typematched=0;
                                        
                                        document.getElementById('sales_receipt_location_top').value=location_invoice;
                                        document.getElementById('sales_receipt_type_top').value=type_invoice;
                                        @foreach($SS as $st)
                                            if('{{$st->st_no}}'==value && '{{$st->st_type}}'=='Invoice' && '{{$st->st_status}}'!='Paid' && '{{$st->remark}}'!='Cancelled' && '{{$st->st_location}}'==location_invoice && '{{$st->st_invoice_type}}'==type_invoice){
                                                typematched=1;
                                            }
                                        @endforeach
                                        if(typematched==1){
                                            console.log(value+" "+location_invoice+" "+type_invoice);
                                            document.getElementById('salesradd').disabled=false;
                                            $.ajax({
                                            type: 'POST',
                                            url: 'findInvoiceNoCu',                
                                            data: {_token: '{{csrf_token()}}',value:value,location_invoice:location_invoice,type_invoice:type_invoice},
                                            success: function(data) {
                                                document.getElementById('salesrcustomer').value=data[0]['st_customer_id'];
                                                $('#salesrcustomer').change();
                                                // $('#sales_receiptbalance').html('PHP '+number_format(data[0]['st_balance'],2));
                                                // $('#sales_receiptbalance').attr('title',data[0]['st_balance']);
                                                
                                                document.getElementById('job_order_sales_receipt').value=data[0]['st_invoice_job_order'];
                                                document.getElementById('work_no_sales_receipt').value=data[0]['st_invoice_work_no'];
                                                
                                                
                                                
                                                @foreach($saleeeeeeee as $sa)
                                                    if('{{$sa->st_customer_id}}'==data[0]['st_customer_id'] && '{{$sa->st_type}}'=="Sales Receipt" && document.getElementById('invoiceno_sr').value=="{{$sa->st_payment_for}}"){
                                                        document.getElementById('last_payment').innerHTML=number_format('{{$sa->st_amount_paid}}',2);
                                                    }
                                                @endforeach
                                                
                                            } 											 
                                            });
                                            
                                            
                                            $.ajax({
                                                type: 'POST',
                                                url: 'findInvoiceNo',                
                                                data: {_token: '{{csrf_token()}}',value:value,location_invoice:location_invoice,type_invoice:type_invoice,invoice_item_no:invoice_item_no},
                                                success: function(data) {
                                                    if(data.length>0){
                                                        document.getElementById('clear_lines_sales_receipt').click();
                                                    }
                                                    var totalamount=0;
                                                for(var c=1;c<=data.length;c++){
                                                        console.log('c='+c+' data.length='+data.length);
                                                        document.getElementById('add_lines_sales_receipt').click();
    
                                                        
                                                        @foreach($cost_center_list as $ccl)
                                                       
                                                            if('{{$ccl->cc_no}}'==data[c-1]['st_p_cost_center']){
                                                                var name_cc="{{trim(preg_replace('/\s\s+/', ' ',$ccl->cc_name))}}";
                                                                document.getElementById('cost_center_sales_creciept'+c).value=data[c-1]['st_p_cost_center']+" - "+name_cc;
                                                            }
                                                        @endforeach
                                                        
                                                        document.getElementById('select_product_name_sales_receipt'+c).value=data[c-1]['st_i_product'];
                                                        if(document.getElementById('select_product_name_sales_receipt'+c).value==""){
                                                            document.getElementById('ParticularSalesReceipt'+c).value="Cost Center";
                                                        }else{
                                                            document.getElementById('ParticularSalesReceipt'+c).value="Product/Services";
                                                        }
                                                        $('#ParticularSalesReceipt'+c).trigger('change');
                                                        //console.log('ParticularSalesReceipt'+c);
                                                        
                                                        //alert(data[c-1]['st_p_debit']);
                                                        // if(data[c-1]['st_p_debit']!=""){
                                                            
                                                        //     document.getElementById('sales_receipt_account_credit_account').value=data[c-1]['st_p_debit'];
                                                        //     document.getElementById('sales_receipt_account_credit_account_account').value=data[c-1]['st_p_debit'];
                                                            
                                                            
                                                        // }
                                                        
                                                        // document.getElementById('sales_receipt_account_credit_account').disabled="true";
                                                        // document.getElementById('sales_receipt_account_credit_account_account').disabled="true";
                                                        
                                                        document.getElementById('select_product_description_sales_receipt'+c).value=data[c-1]['st_i_desc'];
                                                        document.getElementById('product_qty_sales_receipt'+c).value=data[c-1]['st_i_qty'];
                                                        document.getElementById('select_product_rate_sales_receipt'+c).value=number_format(data[c-1]['st_i_rate'],2);
                                                        document.getElementById('select_product_rate_sales_receipt'+c).title=data[c-1]['st_i_rate'];
                                                        document.getElementById('total_amount_sales_receipt'+c).innerHTML=number_format(data[c-1]['st_i_total'],2);
                                                        document.getElementById('total_amount_sales_receipt'+c).title=data[c-1]['st_i_total'];
                                                        totalamount=(parseFloat(totalamount)+(parseFloat(data[c-1]['st_i_total'])-parseFloat(data[c-1]['st_p_amount'])));
                                                        
                                                }
                                                $('#big_sales_receiptbalance').attr('title',totalamount);
                                                $('#big_sales_receiptbalance').html('PHP '+number_format(totalamount,2));
                                                document.getElementById('amountreceived_sr').value=totalamount;
                                                document.getElementById('amountreceived_sr_mask').value=number_format(totalamount,2);
                                                document.getElementById('TotalDebitSalesReceiptTD').innerHTML="Total : "+number_format(totalamount,2);
                                                document.getElementById('hiddentotaldebitamountsalesreceipt').value=totalamount;
                                                $('#sales_receiptbalance').html('PHP '+number_format(totalamount,2));
                                                document.getElementById('amountreceived_sr').max=totalamount;
                                                document.getElementById('amountreceived_sr_mask').max=totalamount;
    
                                                document.getElementById('sales_receipttotal').innerHTML=number_format(totalamount,2);
                                                
                                                $('#sales_receipttotal').attr('title',totalamount);
                                                
                                                }										 
                                            });
                                        }
                                        document.getElementById('setselectpickerbutton').click();
                                    }
                                </script>
                            </div>
                            
                        </div>
                        <div class="col-md-12 p-0 " >
                            <div class="col-md-4 p-0 pr-3">
                                <p>Billing Address</p>
                                <input type="text" name="sr_bill_address" id="sr_bill_address" class="w-100 form-control" readonly >
                            </div>
                            <div class="col-md-2 p-0 pr-3">
                                <p>TIN No.</p>
                                <input type="text" name="tin_no_sr" id="tin_no_sr" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-2 p-0 pr-3">
                                <p>Business Style</p>
                                <input type="text" name="business_style_sr" id="business_style_sr" class="w-100 form-control" readonly>
                            </div>
                            
                            
                        </div>
                        <div class="col-md-12 p-0 mt-3">
                            <div class="col-md-2 p-0 pr-3">
                                <p>Job Order</p>
                                <input type="text" name="job_order_sales_receipt" id="job_order_sales_receipt" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-2 p-0 pr-3">
                                <p>Work No</p>
                                <input type="text" name="work_no_sales_receipt" id="work_no_sales_receipt" class="w-100 form-control" readonly>
                            </div>
                            
                            
                        </div>
                        <div class="col-md-12 p-0 mt-3 d-inline-flex" style="margin-bottom:20px;">
                            <div class="col-md-2 p-0 pr-3">
                                <p>Payment Method</p>
                                <select  name="sr_payment_method" id="sr_payment_method" class="w-100 form-control" required>
                                <option selected>Cash</option>
                                <option>Cheque</option>
                                <option>Cash & Cheque</option>
                                </select>
                                <input type="hidden" name="additional_count" value="0" id="additional_count">
                                <input type="hidden" name="additional_count_cash_account" value="0" id="additional_count_cash_account">
                                <script>
                                   
                                    var additionalchequecount=0;
                                    function GenerateFieldSalesReceipt(){
                                        additionalchequecount++;
                                        document.getElementById('additional_count').value=additionalchequecount;
                                        var markup='<p>Bank '+additionalchequecount+'</p>';
                                            markup=markup+'<select name="sr_reference_no'+additionalchequecount+'" id="sr_reference_no'+additionalchequecount+'" class="w-100 mb-1 form-control">';
                                            markup=markup+'<option value="">--Select Bank--</option>';
                                            @foreach ($banks as $bank)
                                            @if($bank->bank_status=="1")
                                            markup=markup+'<option title="{{$bank->bank_account_no}}" value="{{$bank->bank_no}}">{{$bank->bank_name." - ".$bank->bank_account_no}}</option>';
                                            @endif
                                            @endforeach
                                            markup=markup+'</select>';
                                        $("#BankAdditionalDiv").append(markup);
    
                                        var markup='<p>Cheque No '+additionalchequecount+'</p>';
                                            markup=markup+'<input type="text"  name="sr_deposit_to'+additionalchequecount+'" id="sr_deposit_to'+additionalchequecount+'" class="w-100 form-control mb-1">';
                                        $("#BankChequeNoAdditionalDiv").append(markup);
                                        var markup='<tr id="AdditionalChequeTRSalesReceipt'+additionalchequecount+'">';
                                            markup=markup+'<td style="text-align:right;vertical-align:middle;">';
                                                markup=markup+'<p class="text-dark font-weight-bold">Cheque Amount '+additionalchequecount+'</p>';
                                            markup=markup+'</td>';
                                            markup=markup+'<td style="vertical-align:middle;">';
                                                markup=markup+'<input class="form-control" style="text-align:right;" type="text" onchange="computeoutstanding()" onkeyup="computeoutstanding()" id="amountreceived_sr_from_cheque_mask'+additionalchequecount+'" name="amountreceived_sr_from_cheque_mask'+additionalchequecount+'" placeholder="0.00"  required>';
                                                markup=markup+'<input type="hidden" onchange="computeoutstanding()" onkeyup="computeoutstanding()" id="amountreceived_sr_from_cheque'+additionalchequecount+'" name="sr_amount_paid_from_cheque'+additionalchequecount+'" placeholder="0.00"  required>';
                                                
                                            markup=markup+'</td>';
                                            markup=markup+'</tr>';
                                           
                                            
                                        
                                        $("#AmountFromChequeAdditional").append(markup);
                                        var textbox = '#amountreceived_sr_from_cheque_mask'+additionalchequecount;
                                        var hidden = '#amountreceived_sr_from_cheque'+additionalchequecount;
                                        
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
                                                                       
                                    }
                                    var AdditionalCashAccountCount=0;
                                    function GenerateAdditionalCashAccountsSalesReceipt(){
                                        AdditionalCashAccountCount++;
                                        document.getElementById('additional_count_cash_account').value=AdditionalCashAccountCount;
                                        var markup='<tr id="AdditionalCashTD'+AdditionalCashAccountCount+'">';
                                            
                                            markup=markup+'<td style="vertical-align:middle;" class="pl-0">';
    
                                            markup=markup+'<select required class="form-control selectpicker" data-live-search="true" name="additionalcashDebitAccount'+AdditionalCashAccountCount+'" id="additionalcashDebitAccount'+AdditionalCashAccountCount+'"><option value="">--Select--</option>';
                                            @foreach($COA as $coo)
                                                if('{{$coo->id}}'=="1"){
                                                    markup=markup+'<option selected value="'+'{{$coo->id}}'+'">'+'{{$coo->coa_name}}'+'</option>'; 
                                                }else{
                                                    markup=markup+'<option value="'+'{{$coo->id}}'+'">'+'{{$coo->coa_name}}'+'</option>'; 
                                                }
                                                
                                            @endforeach
                                            
                                            markup=markup+'</select>'; 
                                                
                                            markup=markup+'</td>';
                                            
                                            markup=markup+'<td style="text-align:right;vertical-align:middle;" class="pr-0">';
                                                    markup=markup+'<input style="text-align:right;" class="form-control" type="text" onchange="computeoutstanding()" onkeyup="SetCommaValue(\'additionalCashAmount_mask'+AdditionalCashAccountCount+'\',\'additionalCashAmount'+AdditionalCashAccountCount+'\'),swap_amounts(\'additionalCashAmount_mask_c'+AdditionalCashAccountCount+'\',\'additionalCashAmount_c'+AdditionalCashAccountCount+'\'),computeoutstanding()" id="additionalCashAmount_mask'+AdditionalCashAccountCount+'" name="additionalCashAmount_mask'+AdditionalCashAccountCount+'" placeholder="0.00" value="0" required>';
                                                    markup=markup+'<input type="hidden" onchange="computeoutstanding()" onkeyup="computeoutstanding()" id="additionalCashAmount'+AdditionalCashAccountCount+'" name="additionalCashAmount'+AdditionalCashAccountCount+'" placeholder="0.00" value="0"  required>';
                                            markup=markup+'</td>';
                                            markup=markup+'<td style="vertical-align:middle;" class="pr-0">';
                                                    markup=markup+'<input type="text" style="text-align: right;" id="additionalCashAmount_mask_c'+AdditionalCashAccountCount+'" class="form-control" name="additionalCashAmount_mask_c'+AdditionalCashAccountCount+'" onchange="computeoutstanding_c()" onkeyup="SetCommaValue(\'additionalCashAmount_mask_c'+AdditionalCashAccountCount+'\',\'additionalCashAmount_c'+AdditionalCashAccountCount+'\'),swap_amounts(\'additionalCashAmount_mask'+AdditionalCashAccountCount+'\',\'additionalCashAmount'+AdditionalCashAccountCount+'\'),computeoutstanding_c()" placeholder="0.00" value="0" required>';
                                                    markup=markup+'<input type="hidden"  id="additionalCashAmount_c'+AdditionalCashAccountCount+'"  onchange="computeoutstanding_c()" onkeyup="computeoutstanding_c()" name="additionalCashAmount_c'+AdditionalCashAccountCount+'" placeholder="0.00" value="0" required>';
                                            markup=markup+'</td>';
                                            markup=markup+'</tr>';
                                            $("#additionalCashSalesReceiptTbody").append(markup); 
                                            //document.getElementById('additionalcashCreditAccount'+AdditionalCashAccountCount).value=document.getElementById('sales_receipt_account_credit_account').value;
                                            
                                            refreshpicjer();
                                    }
                                    function SetCommaValue(textbox,hidden){
                                        $('#'+textbox).val(document.getElementById(textbox).value.match(/[0-9.,-]*/));
                                        var num = $('#'+textbox).val();
                                        var comma = /,/g;
                                        num = num.replace(comma,'');
                                        $('#'+hidden).val(num);
                                        $('#'+hidden).attr('title',num);
                                        var numCommas = addCommas(num);
                                        $('#'+textbox).val(numCommas);
                                    }
                                </script>
                                <div id="NoOfChequeDivb" style="display:none;"><button type="button" onclick="GenerateFieldSalesReceipt()" class="btn btn-secondary btn-sm mt-1">Additional cheque</button></div>
                            </div>
                            <script>
                                
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
                            </script>
                            <div class="col-md-2 p-0 pr-3 " >
                                <div class="ChequeColumnssc" style="display:none;">
                                    <p>Bank</p>
                                    <select name="sr_reference_no" id="sr_reference_no" class="w-100 mb-1 form-control">
                                        <option value="">--Select Bank--</option>
                                        @foreach ($banks as $bank)
                                        @if($bank->bank_status=="1")
                                        <option title="{{$bank->bank_account_no}}" value="{{$bank->bank_no}}">{{$bank->bank_name." - ".$bank->bank_account_no}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <div id="BankAdditionalDiv">
                                        
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-2 p-0 pr-3 " >
                                <div class="ChequeColumnssc" style="display:none;">
                                    <p>Cheque No</p>
                                    <input type="text"  name="sr_deposit_to" id="sr_deposit_to" class="w-100 mb-1 form-control">
                                    <div id="BankChequeNoAdditionalDiv">
                                        
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-6 p-0 d-inline-flex justify-content-end pr-5" style="text-align:right;">
                                <h4 class="mr-2">BALANCE DUE: </h4>
                                <h4 id="big_sales_receiptbalance">PHP 0.00</h4>
                            </div>
                        </div>
                        <table class="table table-bordered table-responsive-md table-striped text-left font14" id="sales_receipt_table">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">#</th>
                                    <th class="text-center"   width="10%">PARTICULARS</th>
                                    <th class="text-center"   width="10%">ITEMS</th>
                                    <th class="text-center">DESCRIPTION</th>
                                    <th class="text-center"  width="5%">QTY</th>
                                    <th class="text-center"   width="10%">RATE</th>
                                    <th class="text-center"   width="10%">AMOUNT</th>
                                    <th class="text-center" style="display:none;"></th>
                                </tr>
                            </thead>
                            <tbody id="sales_receipt_table_tbody">

                            </tbody>
                            <!-- This is our clonable table line -->
                        </table>
                        
                        <div class="col-md-10 p-0" style="text-align:right;">
                            
                        </div>
                        <div class="col-md-2 p-0">
                            <div class="float-left" style="display:none;">
                                <div class="d-inline-flex">
                                    <button type="button" class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_sales_receipt">Add Items</button>
                                    <button type="button" class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_sales_receipt">Clear All Items</button>
                                </div>
                            </div>
                            <div class="float-right mr-5">
                                <div class="d-inline-flex mr-4">
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 p-0" style="text-align:right;">
                        </div>
                        <div class="col-md-4" style="text-align:right;">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td style="vertical-align:middle;" width="80%"><p class="mb-0 pr-4 text-dark font-weight-bold">Amount Due</p></td>
                                    <td style="vertical-align:middle;" width="20%"><p class="mb-0 text-dark font-weight-bold" id="sales_receipttotal">PHP 0.00</p></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:middle;"><p class="mb-0 pr-4 text-dark font-weight-bold">Last Payment</p></td>
                                    <td style="vertical-align:middle;"><p class="mb-0 text-dark font-weight-bold" id="last_payment">PHP 0.00</p></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:middle;"><p class="pr-4 text-dark font-weight-bold">Total</p></td>
                                    <td style="vertical-align:middle;"><p class="text-dark font-weight-bold" id="sales_receiptbalance">PHP 0.00</p></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:middle;"><p class="pr-4 text-dark font-weight-bold">Outstanding Balance</p></td>
                                    <td style="vertical-align:middle;"><p class="text-dark font-weight-bold" id="sales_receiptoutstandingbalance">PHP 0.00</p></td>
                                </tr>
                            </table>
                        </div>
                       
                        <div class="col-md-12 p-0 mt-4"  id="CashAccountDivSalesReceipt">
                            <table class="table table-light">
                                <thead class="thead-light">
                                    <tr>
                                        <th colspan="3" style="vertical-align:middle;text-align:center;">Accounts</th>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align:middle;text-align:center;width: 40%;">Account</th>
                                        <th style="vertical-align:middle;text-align:center;width: 30%;border-right:1px solid #ccc;">Debit</th>
                                        <th style="vertical-align:middle;text-align:center;width: 30%;border-right:1px solid #ccc;">Credit</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        
                                        <td style="vertical-align:middle;" class="pl-0">
                                            <select class="form-control selectpicker" data-live-search="true" name="sales_receipt_account_debit_account"  id="sales_receipt_account_debit_account" required>
                                            <option value="">--Select--</option>
                                            @foreach($c_o_a_sorted as $coa)
                                            <option value="{{$coa->id}}">{{$coa->coa_name}}</option>
                                            @endforeach
                                            </select>
                                            
                                        </td>
                                        
                                        <td style="vertical-align:middle;" id="CashAccountFirstTD" class="pr-0">
                                            <script>
                                                function computeoutstanding(){
                                                    var totalpayment=0;
                                                    var amountreceived_sr=document.getElementById('amountreceived_sr').value;
                                                    //var amountreceived_sr_from_cheque=document.getElementById('amountreceived_sr_from_cheque').value;
                                                    // for(var c=1;c<=additionalchequecount;c++){
                                                    //     totalpayment=parseFloat(totalpayment)+parseFloat(document.getElementById('amountreceived_sr_from_cheque'+c).value);
                                                    // }
                                                    for(var c=1;c<=AdditionalCashAccountCount;c++){
                                                        totalpayment=parseFloat(totalpayment)+parseFloat(document.getElementById('additionalCashAmount'+c).value);
                                                    }
                                                    
                                                    totalpayment=parseFloat(totalpayment)+parseFloat(amountreceived_sr);
                                                    //totalpayment=parseFloat(totalpayment)+parseFloat(amountreceived_sr_from_cheque);
                                                    document.getElementById('sales_receiptbalance').innerHTML=number_format(totalpayment,2);
                                                    var sales_receiptbalance=$('#big_sales_receiptbalance').attr('title');
                                                    var totaloutstanding=parseFloat(sales_receiptbalance)-parseFloat(totalpayment);
                                                    document.getElementById('sales_receiptoutstandingbalance').innerHTML=number_format(totaloutstanding,2);
                                                    document.getElementById('TotalDebitSalesReceiptTD').innerHTML='Total : '+number_format(totalpayment,2);
                                                    document.getElementById('hiddentotaldebitamountsalesreceipt').value=totalpayment;
                                                    var totalpayment=0;
                                                    var amountreceived_sr_c=document.getElementById('amountreceived_sr_c').value;
                                                    //var amountreceived_sr_from_cheque=document.getElementById('amountreceived_sr_from_cheque').value;
                                                    // for(var c=1;c<=additionalchequecount;c++){
                                                    //     totalpayment=parseFloat(totalpayment)+parseFloat(document.getElementById('amountreceived_sr_from_cheque'+c).value);
                                                    // }
                                                    for(var c=1;c<=AdditionalCashAccountCount;c++){
                                                        totalpayment=parseFloat(totalpayment)+parseFloat(document.getElementById('additionalCashAmount_c'+c).value);
                                                    }
                                                    totalpayment=parseFloat(totalpayment)+parseFloat(amountreceived_sr_c);
                                                    var sales_receiptbalance=$('#big_sales_receiptbalance').attr('title');
                                                    var totaloutstanding2=parseFloat(sales_receiptbalance)-parseFloat(totalpayment);
                                                    document.getElementById('TotalCreditSalesReceiptTD').innerHTML='Total : '+number_format(totalpayment,2);
                                                    document.getElementById('hiddentotalcredtiamountsalesreceipt').value=totalpayment;
                                                    if(totaloutstanding<0 || totaloutstanding2<0){
                                                        document.getElementById('salesradd').disabled=true;
                                                        
                                                    }else{
                                                        if(document.getElementById('hiddentotaldebitamountsalesreceipt').value==document.getElementById('hiddentotalcredtiamountsalesreceipt').value){
                                                            document.getElementById('salesradd').disabled=false;
                                                        }else{
                                                            document.getElementById('salesradd').disabled=true;
                                                        }
                                                        
                                                        
                                                    }
    
                                                }
                                                
                                                function computeoutstanding_c(){
                                                    var totalpayment=0;
                                                    var amountreceived_sr_c=document.getElementById('amountreceived_sr_c').value;
                                                    //var amountreceived_sr_from_cheque=document.getElementById('amountreceived_sr_from_cheque').value;
                                                    // for(var c=1;c<=additionalchequecount;c++){
                                                    //     totalpayment=parseFloat(totalpayment)+parseFloat(document.getElementById('amountreceived_sr_from_cheque'+c).value);
                                                    // }
                                                    for(var c=1;c<=AdditionalCashAccountCount;c++){
                                                        totalpayment=parseFloat(totalpayment)+parseFloat(document.getElementById('additionalCashAmount_c'+c).value);
                                                    }
                                                    totalpayment=parseFloat(totalpayment)+parseFloat(amountreceived_sr_c);
                                                    var sales_receiptbalance=$('#big_sales_receiptbalance').attr('title');
                                                    var totaloutstanding=parseFloat(sales_receiptbalance)-parseFloat(totalpayment);
                                                    document.getElementById('TotalCreditSalesReceiptTD').innerHTML='Total : '+number_format(totalpayment,2);
                                                    document.getElementById('hiddentotalcredtiamountsalesreceipt').value=totalpayment;
                                                    var totalpayment=0;
                                                    var amountreceived_sr=document.getElementById('amountreceived_sr').value;
                                                    //var amountreceived_sr_from_cheque=document.getElementById('amountreceived_sr_from_cheque').value;
                                                    // for(var c=1;c<=additionalchequecount;c++){
                                                    //     totalpayment=parseFloat(totalpayment)+parseFloat(document.getElementById('amountreceived_sr_from_cheque'+c).value);
                                                    // }
                                                    for(var c=1;c<=AdditionalCashAccountCount;c++){
                                                        totalpayment=parseFloat(totalpayment)+parseFloat(document.getElementById('additionalCashAmount'+c).value);
                                                    }
                                                    
                                                    totalpayment=parseFloat(totalpayment)+parseFloat(amountreceived_sr);
                                                    //totalpayment=parseFloat(totalpayment)+parseFloat(amountreceived_sr_from_cheque);
                                                    document.getElementById('sales_receiptbalance').innerHTML=number_format(totalpayment,2);
                                                    var sales_receiptbalance=$('#big_sales_receiptbalance').attr('title');
                                                    var totaloutstanding2=parseFloat(sales_receiptbalance)-parseFloat(totalpayment);
                                                    document.getElementById('sales_receiptoutstandingbalance').innerHTML=number_format(totaloutstanding,2);
                                                    document.getElementById('TotalDebitSalesReceiptTD').innerHTML='Total : '+number_format(totalpayment,2);
                                                    document.getElementById('hiddentotaldebitamountsalesreceipt').value=totalpayment;
                                                    if(totaloutstanding<0 || totaloutstanding2<0){
                                                        document.getElementById('salesradd').disabled=true;
                                                        
                                                    }else{
                                                        document.getElementById('salesradd').disabled=false;
                                                        
                                                    }
                                                }
                                                $(document).ready(function(){
                                                    var textbox = '#amountreceived_sr_mask';
                                                    var hidden = '#amountreceived_sr';
                                                    
                                                    $('#amountreceived_sr_mask').keyup(function () {
                                                        $('#amountreceived_sr_mask').val(this.value.match(/[0-9.,-]*/));
                                                    var num = $('#amountreceived_sr_mask').val();
                                                        var comma = /,/g;
                                                        num = num.replace(comma,'');
                                                        $('#amountreceived_sr').val(num);
                                                        $('#amountreceived_sr').attr('title',num);
                                                        var numCommas = addCommas(num);
                                                        $('#amountreceived_sr_mask').val(numCommas);
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
                                                    var textbox2 = '#amountreceived_sr_mask_c';
                                                    var hidden2 = '#amountreceived_sr_c';
                                                    
                                                    $('#amountreceived_sr_mask_c').keyup(function () {
                                                        $('#amountreceived_sr_mask_c').val(this.value.match(/[0-9.,-]*/));
                                                    var num = $('#amountreceived_sr_mask_c').val();
                                                        var comma = /,/g;
                                                        num = num.replace(comma,'');
                                                        $('#amountreceived_sr_c').val(num);
                                                        $('#amountreceived_sr_c').attr('title',num);
                                                        var numCommas = addCommas(num);
                                                        $('#amountreceived_sr_mask_c').val(numCommas);
                                                    });
                                                })
                                                function swap_amounts(mask,type){
                                                    console.log(mask+" "+type);
                                                    document.getElementById(mask).value="0";
                                                    document.getElementById(type).value="0";
                                                    $('#'+type).attr('title','0');
                                                   
                                                }
                                            </script>
                                            <input type="text" style="text-align: right;" id="amountreceived_sr_mask" class="form-control" name="amountreceived_sr_mask" onchange="computeoutstanding()" onkeyup="swap_amounts('amountreceived_sr_mask_c','amountreceived_sr_c'),computeoutstanding()" placeholder="0.00" value='0' required>
                                            <input type="hidden"  id="amountreceived_sr"  onchange="computeoutstanding()" onkeyup="computeoutstanding()" value='0' name="sr_amount_paid" placeholder="0.00" required>
                                        </td>
                                        <td style="vertical-align:middle;" class="pr-0">
                                            <input type="text" style="text-align: right;" id="amountreceived_sr_mask_c" class="form-control" name="amountreceived_sr_mask_c" onchange="computeoutstanding_c()" onkeyup="swap_amounts('amountreceived_sr_mask','amountreceived_sr'),computeoutstanding_c()" placeholder="0.00" value='0' required>
                                            <input type="hidden"  id="amountreceived_sr_c"  onchange="computeoutstanding_c()" onkeyup="computeoutstanding_c()" value='0' name="amountreceived_sr_c" placeholder="0.00" required>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                                <tbody id="additionalCashSalesReceiptTbody">
    
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td  style="vertical-align:middle;">
                                            <input type="hidden" id="hiddentotaldebitamountsalesreceipt" name="hiddentotaldebitamountsalesreceipt">
                                            <input type="hidden" id="hiddentotalcredtiamountsalesreceipt" name="hiddentotalcredtiamountsalesreceipt">
                                            <button type="button" onclick="GenerateAdditionalCashAccountsSalesReceipt()" class="btn btn-primary">Add Account</button>
                                        </td>
                                        <td  style="vertical-align:middle;text-align:right;font-size:large;font-weight:bold;" id="TotalDebitSalesReceiptTD">
                                            Total : 0.00
                                        </td>
                                        <td  style="vertical-align:middle;text-align:right;font-size:large;font-weight:bold;" id="TotalCreditSalesReceiptTD">
                                            Total : 0.00
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
    
                        </div> 
                        
                        <div class="col-md-12 p-0">
                            <div class="col-md-6 pl-0">
                                <p>Message Displayed on Sales Receipt</p>
                                <textarea rows="3" class="w-100 form-control" name="sr_message"></textarea>
                            </div>
                            <div class="col-md-6 pr-0">
                                <p>Memo</p>
                                <textarea rows="3" class="w-100 form-control" name="sr_memo"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 m-0 p-0 mt-3" style="display:none;">
                            <div class="d-inline-flex">
                                <p class="fa fa-paperclip"></p>
                                <p class="p-0 ml-1">Maximum Size: 20MB</p>
                            </div>
                            <div class="input-group mb-3 p-0">
                                <div class="custom-file">
                                    <input type="file" name="sr_attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                    <button id="salesradd" class="btn btn-success rounded" type="submit">Save</button>
                </div>
            </div>
        </div>
    </form>
    </div>

    <div class="modal fade p-0" id="creditnotemodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
        <form action="#" class="form-horizontal " id="add_credit_note_form" onsubmit="addCreditNote()" autocomplete="off">
        {{ csrf_field() }}
            <input id="transaction_type_credit_note" name="transaction_type_credit_note" value="Credit Note" hidden>
            <input type="number" id="total_balance_credit_note" step="0.01" name="total_balance_credit_note" value="0" hidden>
            <input id="product_count_credit_note" name="product_count_credit_note" value="0" hidden>
            <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
                <div class="modal-content" style="min-height: 100vh;">
                    <div class="modal-header">
                        <h5 class="modal-title">Credit Note</h5>
                        <button type="button" class="close" data-dismiss="modal" id="creditnotemodalclose" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body p-4" id="result">
                        <div class="col-md-12 p-0 mb-4">
                            <div class="col-md-12 p-0 " style="margin-bottom:20px;">
                                <div class="col-md-2 p-0 pr-3">
                                    <p>Credit Note No</p>
                                    <input type="text" onkeyup="setcredit_note_no_new()"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="credit_note_no" id="credit_note_no" class="w-100 form-control" value="{{count($credit_note_count)+$credit_note_start_no}}" required>
                                    <script>
                                        function setcredit_note_no_new(){
                                            var invoice_no_field=document.getElementById('credit_note_no').value;
                                            $.ajax({
                                                method: "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                url: "check_credit_note_no",
                                                data: {invoice_no_field:invoice_no_field,_token: '{{csrf_token()}}'},
                                                success: function (data) {
                                                    if(data>0){
                                                        document.getElementById('credit_note_no').style.border="1px solid red";
                                                        document.getElementById('creditnadd').disabled=true;
                                                    }else{
                                                        document.getElementById('credit_note_no').style.border="1px solid green";
                                                        document.getElementById('creditnadd').disabled=false;
                                                    }
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                                <div class="col-md-2 p-0 pr-3">
                                    <p>Credit Note Date</p>
                                    <input type="date" name="cn_date" id="cn_date" class="w-100 form-control" required>
                                </div>
                                <div class="col-md-4 p-0 d-inline-flex center-content" style="text-align:center;">
                                    <h4 class="mr-2">BALANCE DUE: </h4>
                                    <h4 id="big_credit_notebalance">PHP 0.00</h4>
                                </div>
                            </div>
                            <div class="my-3 p-0">
                                <div class="col-md-3 p-0 pr-3">
                                    <p>Customer</p>
                                    <select id="creditncustomer" type="text" name="cn_customer" class="w-100 selectpicker " data-live-search="true" required>
                                            <option value="">--Select Name--</option>
                                            {!! $customers_list_after_foreach !!}
                                            </select>
                                </div>
                                <div class="col-md-3 p-0 pr-3" style="display:none;">
                                    <p>Email</p>
                                    <input type="text" name="cn_email" id="cn_email" placeholder="Email (Separate emails with a comma)" class="w-100">
                                    <br>
                                    <div class="float-left">
                                        <input type="checkbox" name="cn_send_later"> Send Now
                                    </div>
                                    <div class="float-right">
                                        <p class="text-info" style="margin-bottom:0px;"></p>
                                    </div>
                                </div>
                                <div class="col-md-2 p-0 pr-3" style="{{!empty($numbering) && $numbering->use_cost_center=="Off"? 'display:none;' : ''}}">
                                    <p>Cost Center</p>
                                    <select name="CostCenterCreditNote" onchange="EnableCreditNoteInput(this)" id="CostCenterCreditNote" class="w-100 form-control" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : 'required'}}>
                                        <option value="">--Select Cost Center--</option>
                                        {!! $cc_list_after_foreach !!}
                                    </select>
                                </div>
                                
                                
                            </div>
                            
                            <div class="col-md-12 p-0 " style="margin-bottom:20px;">
                                <div class="col-md-4 p-0 pr-3">
                                    <p>Billing Address</p>
                                    <input type="text" name="cn_bill_address" id="cn_bill_address" class="w-100 form-control" required>
                                </div>
                                
                                
                                
                            </div>
                            <table class="table table-bordered table-responsive-md table-striped text-left font14" id="credit_note_table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">PRODUCT/SERVICE</th>
                                        <th class="text-center" width="30%">DESCRIPTION</th>
                                        <th class="text-center" width="10%">QTY</th>
                                        <th class="text-center" width="15%">RATE</th>
                                        <th class="text-center" width="15%">AMOUNT</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="credit_note_table_tbody">

                                </tbody>
                                
                                <!-- This is our clonable table line -->
                            </table>
                            <div class="col-md-12 p-0">
                                <div class="float-left">
                                    <div class="d-inline-flex">
                                        <button type="button" class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_credit_note">Add Items</button>
                                        <button type="button" class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_credit_note">Clear All Items</button>
                                    </div>
                                </div>
                                <div class="float-right mr-5">
                                    <div class="d-inline-flex mr-4">
                                        <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                        <p class="mb-0 text-dark font-weight-bold" id="credit_notetotal">PHP 0.00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="float-right mr-5">
                                    <div class="d-inline-flex mr-4">
                                        <p class="pr-4 text-dark font-weight-bold">BALANCE DUE</p>
                                        <p class="text-dark font-weight-bold" id="credit_notebalance">PHP 0.00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="col-md-6 pl-0">
                                    <p>Message Displayed on Credit Note</p>
                                    <textarea rows="3" class="w-100 form-control" name="cn_message"></textarea>
                                </div>
                                <div class="col-md-6 pr-0">
                                    <p>Memo</p>
                                    <textarea rows="3" class="w-100 form-control" name="cn_memo"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 p-0 mt-4">
                                <table class="table table-light">
                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="2" style="vertical-align:middle;text-align:center;">Accounts</th>
                                        </tr>
                                        <tr>
                                            <th style="vertical-align:middle;text-align:center;border-right:1px solid #ccc;">Debit</th>
                                            <th style="vertical-align:middle;text-align:center;">Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align:middle;" class="pl-0">
                                                <select class="form-control" name="credit_note_account_debit_account"  id="credit_note_account_debit_account" required>
                                                <option></option>
                                                @foreach($c_o_a_sorted as $coa)
                                                <option title="{{$coa->coa_title}}" value="{{$coa->id}}">{{$coa->coa_name}}</option>
                                                @endforeach
                                                </select>
                                                <script>
                                                $(document).ready(function(){
                                                    document.getElementById('credit_note_account_debit_account').value="4";
                                                })
                                                </script>
                                            </td>
                                            <td style="vertical-align:middle;" class="pr-0">
                                                <select class="form-control" name="credit_note_account_credit_account"  id="credit_note_account_credit_account" required>
                                                <option></option>
                                                @foreach($c_o_a_sorted as $coa)
                                                <option title="{{$coa->coa_title}}" value="{{$coa->id}}">{{$coa->coa_name}}</option>
                                                @endforeach
                                                </select>
                                                <script>
                                                $(document).ready(function(){
                                                    document.getElementById('credit_note_account_credit_account').value="2";
                                                })
                                                </script>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div> 
                            <div class="col-md-6 m-0 p-0 mt-3" style="display:none;">
                                <div class="d-inline-flex">
                                    <p class="fa fa-paperclip"></p>
                                    <p class="p-0 ml-1">Maximum Size: 20MB</p>
                                </div>
                                <div class="input-group mb-3 p-0">
                                    <div class="custom-file">
                                        <input type="file" name="cn_attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                        <button id="creditnadd" class="btn btn-success rounded" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
<div class="modal fade p-0" id="refundreceiptmodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
<form action="#" class="form-horizontal " id="add_refund_receipt_form" onsubmit="addRefundReceipt()" autocomplete="off">
{{ csrf_field() }}
    <input id="transaction_type_refund_receipt" name="transaction_type_refund_receipt" value="Refund Receipt" hidden>
    <input type="number" id="total_balance_refund_receipt" step="0.01" name="total_balance_refund_receipt" value="0" hidden>
    <input id="product_count_refund_receipt" name="product_count_refund_receipt" value="0" hidden>
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Refund Receipt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="my-3 p-0">
                        <div class="col-md-4 p-0 pr-3">
                            <select id="refundrcustomer" type="text" name="rr_customer" class="w-100" required>
                                    <option value="">--Select Name--</option>
                                    {!! $customers_list_after_foreach !!}
                            </select>
                        </div>
                        <div class="col-md-4 p-0">
                            <input type="text" name="rr_email" id="rr_email" placeholder="Email (Separate emails with a comma)" class="w-100">
                            <br>
                            <div class="float-left">
                                <input type="checkbox" name="rr_send_later"> Send Now
                            </div>
                            <div class="float-right">
                                <p class="text-info"></p>
                            </div>
                        </div>
                        <div class="col-md-4 p-0 d-inline-flex center-content" style="text-align:center;">
                            <h4 class="mr-2">BALANCE DUE: </h4>
                            <h3 id="big_refund_receiptbalance">PHP 0.00</h3>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-3">
                        <div class="col-md-4 p-0 pr-3">
                            <p>Billing Address</p>
                            <input type="text" name="rr_bill_address" id="rr_bill_address" class="w-100" required>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Refund Receipt Date</p>
                            <input type="date" name="rr_date" id="rr_date" class="w-100" required>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-3 d-inline-flex">
                        <div class="col-md-3 p-0 pr-3">
                            <p>Payment Method</p>
                            <input type="text" list="payment_method_list" name="rr_payment_method" id="rr_payment_method" placeholder="Choose payment method" class="w-100" required>
                        </div>
                        <div class="col-md-3 p-0 pr-3">
                            <p>Refund from</p>
                            <input type="text" list="payment_deposit" name="rr_deposit_to" id="rr_deposit_to" class="w-100" required>
                        </div>
                    </div>
                    <table class="table table-bordered table-responsive-md table-striped text-left font14" id="refund_receipt_table">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">PRODUCT/SERVICE</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-center">QTY</th>
                            <th class="text-left">RATE</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                        <!-- This is our clonable table line -->
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button type="button" class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_refund_receipt">Add Items</button>
                                <button type="button" class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_refund_receipt">Clear All Items</button>
                            </div>
                        </div>
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                <p class="mb-0 text-dark font-weight-bold" id="refund_receipttotal">PHP 0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="pr-4 text-dark font-weight-bold">BALANCE DUE</p>
                                <p class="text-dark font-weight-bold" id="refund_receiptbalance">PHP 0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="pr-4 text-dark font-weight-bold">Total Amount Refunded</p>
                                <p class="mb-0 text-dark font-weight-bold" id="refund_receipttotal1">PHP 0.00</p>
                                <input type="number" id="rr_amount_refunded" name="rr_amount_refunded" placeholder="0.00" hidden>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-6 pl-0">
                            <p>Message Displayed on Refund Receipt</p>
                            <textarea rows="3" class="w-100" name="rr_message"></textarea>
                        </div>
                        <div class="col-md-6 pr-0">
                            <p>Memo</p>
                            <textarea rows="3" class="w-100" name="rr_memo"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 m-0 p-0 mt-3" style="display:none;">
                        <div class="d-inline-flex">
                            <p class="fa fa-paperclip"></p>
                            <p class="p-0 ml-1">Maximum Size: 20MB</p>
                        </div>
                        <div class="input-group mb-3 p-0">
                            <div class="custom-file">
                                <input type="file" name="rr_attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button id="refundradd" class="btn btn-success rounded" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>
</div>
<div class="modal fade p-0" id="delayedcreditmodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
<form action="#" class="form-horizontal " id="add_delayed_credit_form" onsubmit="addDelayedCredit()" autocomplete="off">
{{ csrf_field() }}
<input id="transaction_type_delayed_credit" name="transaction_type_delayed_credit" value="Credit" hidden>
<input id="product_count_delayed_credit" name="product_count_delayed_credit" value="0" hidden>
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Delayed Credit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="my-3 p-0">
                        <div class="col-md-4 p-0 pr-3">
                            <select id="delayedcreditcustomer" type="text" name="dcredit_customer" class="w-100" required>
                                    <option value="">--Select Name--</option>
                                    {!! $customers_list_after_foreach !!}
                            </select>
                        </div>
                        <div class="col-md-4 p-0">
                        </div>
                        <div class="col-md-4 p-0 d-inline-flex center-content" style="text-align:left;">
                            <h4 class="mr-2">BALANCE DUE: </h4>
                            <h3 id="delayed_creditbalance">PHP 0.00</h3>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-3">
                        <div class="col-md-2 p-0 pr-3">
                            <p>Delayed Credit Date</p>
                            <input type="date" name="dcredit_date" class="w-100">
                        </div>
                    </div>
                    <table class="table table-bordered table-responsive-md table-striped text-left font14" id="delayed_credit_table">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">PRODUCT/SERVICE</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-center">QTY</th>
                            <th class="text-left">RATE</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                        <!-- This is our clonable table line -->
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_delayed_credit">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_delayed_credit">Clear All Items</button>
                            </div>
                        </div>
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                <p class="mb-0 text-dark font-weight-bold" id="delayed_credittotal">PHP 0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-4">
                        <div class="col-md-6 pl-0">
                            <p>Memo</p>
                            <textarea rows="3" class="w-100" name="dcredit_memo"></textarea>
                        </div>
                        <div class="col-md-6 m-0 pr-0" style="display:none;">
                            <div class="d-inline-flex">
                                <p class="fa fa-paperclip"></p>
                                <p class="p-0 ml-1">Maximum Size: 20MB</p>
                            </div>
                            <div class="input-group mb-3 p-0">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="dcredit_attachment" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button id="delayedcreditadd" class="btn btn-success rounded" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>
</div>
<div class="modal fade p-0" id="delayedchargemodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
<form action="#" class="form-horizontal " id="add_delayed_charge_form" onsubmit="addDelayedCharge()" autocomplete="off">
{{ csrf_field() }}
<input id="transaction_type_delayed_charge" name="transaction_type_delayed_charge" value="Charge" hidden>
<input id="product_count_delayed_charge" name="product_count_delayed_charge" value="0" hidden>
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Delayed Charge</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="my-3 p-0">
                        <div class="col-md-4 p-0 pr-3">
                            <select id="delayedccustomer" type="text" name="dc_customer" class="w-100" required>
                                    <option value="">--Select Name--</option>
                                    {!! $customers_list_after_foreach !!}
                            </select>
                        </div>
                        <div class="col-md-4 p-0">
                        </div>
                        <div class="col-md-4 p-0 d-inline-flex center-content" style="text-align:left;">
                            <h4 class="mr-2">BALANCE DUE: </h4>
                            <h3 id="delayed_chargebalance">PHP 0.00</h3>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-3">
                        <div class="col-md-2 p-0 pr-3">
                            <p>Delayed Charge Date</p>
                            <input type="date" name="dc_date" class="w-100">
                        </div>
                    </div>
                    <table class="table table-bordered table-responsive-md table-striped text-left font14" id="delayed_charge_table">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">PRODUCT/SERVICE</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-center">QTY</th>
                            <th class="text-left">RATE</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                        <!-- This is our clonable table line -->
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_delayed_charge">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_delayed_charge">Clear All Items</button>
                            </div>
                        </div>
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                <p class="mb-0 text-dark font-weight-bold" id="delayed_chargetotal">PHP 0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-4">
                        <div class="col-md-6 pl-0">
                            <p>Memo</p>
                            <textarea rows="3" class="w-100" name="dc_memo"></textarea>
                        </div>
                        <div class="col-md-6 m-0 pr-0" style="display:none;">
                            <div class="d-inline-flex">
                                <p class="fa fa-paperclip"></p>
                                <p class="p-0 ml-1">Maximum Size: 20MB</p>
                            </div>
                            <div class="input-group mb-3 p-0">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="dc_attachment" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button id="delayedcadd" class="btn btn-success rounded" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>
</div>
<script>
    @if(!empty($numbering) && $numbering->use_cost_center=="Off")

    @else
    $(document).ready(function(){
        $("#add_expense_form :input").prop("disabled", true);
        document.getElementById('CostCenterExpense').disabled=false;
        document.getElementById('expenseclosemodalbuttopn').disabled=false;
        
    });

    @endif
    function EnableExpenseInput(e){
        if(e.value==""){
            $("#add_expense_form :input").prop("disabled", true);
            document.getElementById('CostCenterExpense').disabled=false;
            document.getElementById('expenseclosemodalbuttopn').disabled=false;
        }else{
            var asd=e.value;
            $("#add_expense_form :input").prop("disabled", false);
            document.getElementById('CostCenterExpense').value=asd;
        }
    }
</script>
<div class="modal fade p-0" id="expensemodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
<form action="#" class="form-horizontal " id="add_expense_form" onsubmit="addExpense()" autocomplete="off">
{{ csrf_field() }}
<input id="item_count_expenses" name="item_count_expenses" value="0" hidden>
<input id="account_count_expenses_add" name="account_count_expenses_add" value="0" hidden>
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Expense</h5>
                <button type="button" class="close" id="expenseclosemodalbuttopn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="my-3 p-0">
                        <div class="col-md-3 p-0 pr-3">
                            <p>Name</p>
                            <select id="expensepayee" type="text" name="expense_customer" class="w-100" required>
                                    <option value="">--Select Name--</option>
                                    {!! $customers_list_after_foreach !!}
                            </select>
                        </div>
                        
                        <div class="col-md-3 p-0">
                                <p>Bank/Credit Account</p>
                            <input type="text" list="payment_deposit" name="expense_account" class="w-100" required>
                        </div>
                    
                        <div class="col-md-3 p-0 ml-5  d-inline-flex">
                            <h4 class="mr-2">AMOUNT: </h4>
                            <h3 id="expense_total_balance">PHP 0.00</h3>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-3 d-inline-flex">
                        <div class="col-md-2 p-0 pr-3">
                            <p>Payment Date</p>
                            <input type="date" name="expense_date" class="w-100" required>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Payment Method</p>
                            <input type="text" list="payment_method_list" name="expense_payment_method" id="expense_payment_method" placeholder="Enter text" class="w-100" required>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Reference No.</p>
                            <input type="text" name="expense_reference_no" class="w-100" required>
                        </div>
                        <div class="col-md-2 p-0 pr-3" style="{{!empty($numbering) && $numbering->use_cost_center=="Off"? 'display:none;' : ''}}">
                            <p>Cost Center</p>
                            <select name="CostCenterExpense" onchange="EnableExpenseInput(this)" id="CostCenterExpense" style="width:90%;" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : 'required'}}>
                                <option value="">--Select Cost Center--</option>
                                {!! $cc_list_after_foreach !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-1">
                        <h4>Account Details</h4>
                    </div>
                    <table class="table table-bordered table-responsive-md table-striped text-left font14" id="expense_account_table">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">ACCOUNT</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                        <!-- This is our clonable table line -->
                    </table>
                    <datalist id="account_expenses">
                    <option value="Amortisation expense">Expenses</option>
                    <option value="Bad debts">Expenses</option>
                    <option value="Bank charges">Expenses</option>
                    <option value="Commissions and fees">Expenses</option>
                    <option value="Dues and subscriptions">Expenses</option>
                    <option value="Equipment rental">Expenses</option>
                    <option value="Income tax expense">Expenses</option>
                    <option value="Insurance - Disablity">Expenses</option>
                    <option value="Insurance - General">Expenses</option>
                    <option value="Insurance - Liability">Expenses</option>
                    <option value="Interest expense">Expenses</option>
                    <option value="Legal and professional fees">Expenses</option>
                    <option value="Loss on discontinued operations, net of tax">Expenses</option>
                    <option value="Management compensation">Expenses</option>
                    <option value="Meals and entertainment">Expenses</option>
                    <option value="Office expenses">Expenses</option>
                    <option value="Other general and administrative expenses">Expenses</option>
                    <option value="Other selling expenses">Expenses</option>
                    <option value="Other Types of Expenses-Advertising Expenses">Expenses</option>
                    <option value="Payroll Expenses">Expenses</option>
                    <option value="Rent or lease payments">Expenses</option>
                    <option value="Repairs and Maintenance">Expenses</option>
                    <option value="Shipping and delivery expense">Expenses</option>
                    <option value="Stationery and printing">Expenses</option>
                    <option value="Supplies">Expenses</option>
                    <option value="Travel expenses - general and admin expenses">Expenses</option>
                    <option value="Travel expenses - selling expenses">Expenses</option>
                    <option value="Uncategorised Expense">Expenses</option>
                    <option value="Utilities">Expenses</option>
                    <option value="Wage expenses">Expenses</option>
                    <option value="Cash and cash equivalents">Cash and cash equivalents</option>
                    <option value="Accounts Receivable (A/R)">Accounts Receivable (A/R)</option>

                    <option value="Allowance for bad debt">Current Asset</option>
                    <option value="Available for sale assets (short-term)">Current Asset</option>
                    <option value="Inventory">Current Asset</option>
                    <option value="Inventory Asset">Current Asset</option>
                    <option value="Prepaid expenses">Current Asset</option>
                    <option value="Uncategorised Asset">Current Asset</option>

                    <option value="Accumulated depreciation on property, plant and equipment">Fixed Asset</option>
                    <option value="Property, plant and equipment">Fixed Asset</option>
                    <option value="Assets held for sale">Non Current Asset</option>
                    <option value="Deferred tax assets">Non Current Asset</option>
                    <option value="Goodwill">Non Current Asset</option>
                    <option value="Intangibles">Non Current Asset</option>
                    <option value="Long-Term Investments">Non Current Asset</option>
                    <option value="Accrued liabilities">Current liabilities</option>
                    <option value="Dividends payable">Current liabilities</option>
                    <option value="Income tax payable">Current liabilities</option>
                    <option value="Payroll Clearing">Current liabilities</option>
                    <option value="Payroll liabilities">Current liabilities</option>
                    <option value="Short-term debit">Current liabilities</option>
                    <option value="Accrued holiday payable">Non Current liabilities</option>
                    <option value="Accrued non-current liabilities">Non Current liabilities</option>
                    <option value="Liabilities related to assets held for sale">Non Current liabilities</option>
                    <option value="Long-term debt">Non Current liabilities</option>
                    <option value="Dividend disbursed">Owner's Equity</option>
                    <option value="Equity in earnings of subsidiaries">Owner's Equity</option>
                    <option value="Other comprehensive income">Owner's Equity</option>
                    <option value="Retained Earnings">Owner's Equity</option>
                    <option value="Share capital">Owner's Equity</option>
                    <option value="Billable Expense Income">Income</option>
                    <option value="Revenue - General">Income</option>
                    <option value="Sales">Income</option>
                    <option value="Sales - retail">Income</option>
                    <option value="Sales - wholesale">Income</option>
                    <option value="Sales of Product Income">Income</option>
                    <option value="Unapplied Cash Payment Income">Income</option>
                    <option value="Uncategorised Income">Income</option>
                    <option value="Change in inventory - COS">Cost of Sales</option>
                    <option value="Cost of sales">Cost of Sales</option>
                    <option value="Direct labour - COS">Cost of Sales</option>
                    <option value="Discounts given - COS">Cost of Sales</option>
                    <option value="Freight and delivery - COS">Cost of Sales</option>
                    <option value="Materials - COS">Cost of Sales</option>
                    <option value="Other - COS">Cost of Sales</option>
                    <option value="Overhead - COS">Cost of Sales</option>
                    <option value="Subcontractors - COS">Cost of Sales</option>
                    <option value="Dividend income">Other Income</option>
                    <option value="Interest income">Other Income</option>
                    <option value="Loss on disposal of assets">Other Income</option>
                    <option value="Other operating income (expenses)">Other Income</option>
                    <option value="Unrealised loss on securities, net of tax">Other Income</option>
                    <option value="Other Expense">Other Expenses</option>
                    <option value="Reconciliation Discrepancies">Other Expenses</option>
                    
                    </datalist>
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_expense_account">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_expense_account">Clear All Items</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-1 mt-4">
                        <h4>Item Details</h4>
                    </div>
                    <table style="display:none;" class="table table-bordered table-responsive-md table-striped text-left font14" id="expense_item_table">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">PRODUCT/SERVICE</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-center">QTY</th>
                            <th class="text-left">RATE</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                    </table>
                    <div class="col-md-12 p-0" style="display:none;">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_expense_item">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_expense_item">Clear All Items</button>
                            </div>
                        </div>
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                <p class="mb-0 text-dark font-weight-bold">PHP 1400.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-4">
                        <div class="col-md-6 pl-0">
                            <p>Memo</p>
                            <textarea rows="3" name="expense_memo" class="w-100"></textarea>
                        </div>
                        <div class="col-md-6 m-0 pr-0" style="display:none;">
                            <div class="d-inline-flex">
                                <p class="fa fa-paperclip"></p>
                                <p class="p-0 ml-1">Maximum Size: 20MB</p>
                            </div>
                            <div class="input-group mb-3 p-0">
                                <div class="custom-file">
                                    <input type="file" name="expense_attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button id="expenseadd" class="btn btn-success rounded" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>
</div>
<script>
    @if(!empty($numbering) && $numbering->use_cost_center=="Off")

    @else
    $(document).ready(function(){
        $("#add_cheque_form :input").prop("disabled", true);
        document.getElementById('CostCenterCheque').disabled=false;
        document.getElementById('chequeclosemodalbutton').disabled=false;
        
    });

    @endif
    function EnableChequeInput(e){
        if(e.value==""){
            $("#add_cheque_form :input").prop("disabled", true);
            document.getElementById('CostCenterCheque').disabled=false;
            document.getElementById('chequeclosemodalbutton').disabled=false;
        }else{
            var asd=e.value;
            $("#add_cheque_form :input").prop("disabled", false);
            document.getElementById('CostCenterCheque').value=asd;
        }
    }
</script>
<div class="modal fade p-0" id="chequemodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
<form action="#" class="form-horizontal " id="add_cheque_form" onsubmit="addCheque()" autocomplete="off">
{{ csrf_field() }}
<input id="item_count_cheques" name="item_count_cheques" value="0" hidden>
<input id="account_count_cheques" name="account_count_cheques" value="0" hidden>
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Cheque</h5>
                <button type="button" class="close" id="chequeclosemodalbutton" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="my-3 p-0">
                        <div class="col-md-3 p-0 pr-3">
                            <p>Name</p>
                            <select id="chequepayee" type="text" name="cheque_customer" class="w-100" required>
                                    <option value="">--Select Name--</option>
                                    {!! $customers_list_after_foreach !!}
                            </select>
                        </div>
                        
                        <div class="col-md-3 p-0">
                            <p>Bank Account</p>
                            <input type="text" list="payment_deposit" name="cheque_account" placeholder="Cash and Cash Equivalents" class="w-100" required>
                        </div>
                        
                        <div class="col-md-3 p-0 ml-5  d-inline-flex">
                            <h4 class="mr-2">AMOUNT: </h4>
                            <h3 id="cheque_total_balance">PHP 0.00</h3>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-3 d-inline-flex">
                        <div class="col-md-3 p-0 pr-3">
                            <p>Mailing Address</p>
                            <input type="text" name="cheque_billing_address" id="cheque_billing_address" class="w-100" required>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Payment Date</p>
                            <input type="date" name="cheque_date" class="w-100" required>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Cheque No.</p>
                            <input type="text" name="cheque_no" class="w-100" required>
                        </div>
                        <div class="col-md-2 p-0 pr-3" style="{{!empty($numbering) && $numbering->use_cost_center=="Off"? 'display:none;' : ''}}">
                            <p>Cost Center</p>
                            <select name="CostCenterCheque" onchange="EnableChequeInput(this)" id="CostCenterCheque" style="width:90%;" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : 'required'}}>
                                <option value="">--Select Cost Center--</option>
                                {!! $cc_list_after_foreach !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-1">
                        <h4>Account Details</h4>
                    </div>
                    <table class="table table-bordered table-responsive-md table-striped text-left font14" id="cheque_account_table">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">ACCOUNT</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14"  id="add_lines_cheque_account">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14"  id="clear_lines_cheque_account">Clear All Items</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-1 mt-4" >
                        <h4>Item Details</h4>
                    </div>
                    <table  class="table table-bordered table-responsive-md table-striped text-left font14" id="cheque_item_table">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">PRODUCT/SERVICE</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-center">QTY</th>
                            <th class="text-left">RATE</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                    </table>
                    <div class="col-md-12 p-0" >
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_cheque_item">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_cheque_item">Clear All Items</button>
                            </div>
                        </div>
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                <p class="mb-0 text-dark font-weight-bold" id="chequeitem_total">PHP 1400.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-4">
                        <div class="col-md-6 pl-0">
                            <p>Memo</p>
                            <textarea rows="3" class="w-100" name="cheque_memo"></textarea>
                        </div>
                        <div class="col-md-6 m-0 pr-0" style="display:none;">
                            <div class="d-inline-flex">
                                <p class="fa fa-paperclip"></p>
                                <p class="p-0 ml-1">Maximum Size: 20MB</p>
                            </div>
                            <div class="input-group mb-3 p-0">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="cheque_attachment" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button id="chequeadd" class="btn btn-success rounded" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>
</div>
<script>
    @if(!empty($numbering) && $numbering->use_cost_center=="Off")

    @else
    $(document).ready(function(){
        //$("#add_bill_form :input").prop("disabled", true);
        
        //destroy_select_picker('CostCenterBill');
        document.getElementById('CostCenterBill').disabled=false;
        document.getElementById('billmodalclosebutton').disabled=false;
        document.getElementById('billpayee').disabled=false;
        //refreshpicjer();
    });

    @endif
    function EnableBillInput(e){
        if(e.value==""){
            $("#add_bill_form :input").prop("disabled", true);
            document.getElementById('CostCenterBill').disabled=false;
            document.getElementById('billmodalclosebutton').disabled=false;
        }else{
            var asd=e.value;
            $("#add_bill_form :input").prop("disabled", false);
            document.getElementById('CostCenterBill').value=asd;
        }
        document.getElementById('billpayee').disabled=false;
    }
</script>
<div class="modal fade p-0" id="billmodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
<form action="#" class="form-horizontal " id="add_bill_form" onsubmit="addBill()" autocomplete="off">
{{ csrf_field() }}
<input id="item_count_bills" name="item_count_bills" value="0" hidden>
<input id="account_count_bills" name="account_count_bills" value="0" hidden>
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Bill</h5>
                <button type="button" class="close" id="billmodalclosebutton" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="col-md-12 p-0" >
                        <div class="col-md-2 p-0 pr-3">
                            <p>Bill No.</p>
                            <input type="text" value="{{count($bill_transaction_count_new)+count($bill_transaction_count)+$bill_start_no}}" onkeyup="setbill_no_new()"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="bill_bill_no2" name="bill_bill_no" class="w-100 form-control" required>
                            <script>
                                function setbill_no_new(){
                                    
                                    var invoice_no_field=document.getElementById('bill_bill_no2').value;
                                    $.ajax({
                                        method: "POST",
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: "check_bill_no",
                                        data: {invoice_no_field:invoice_no_field,_token: '{{csrf_token()}}'},
                                        success: function (data) {
                                            if(data>0){
                                                document.getElementById('bill_bill_no2').style.border="1px solid red";
                                                document.getElementById('billadd2').disabled=true;
                                            }else{
                                                document.getElementById('bill_bill_no2').style.border="1px solid green";
                                                document.getElementById('billadd2').disabled=false;
                                            }
                                        }
                                    });
                                }
                            </script>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Bill Date</p>
                            <input type="date" name="bill_date" onchange="changebilldatebillduedate(this)" id="bill_date_bill" class="w-100 form-control" required>
                            <script>
								function changebilldatebillduedate(e){
									if(e.value!=""){
										document.getElementById('bill_due_date_bill').setAttribute("min", e.value);
									}
								}
								function setbill_terms(e){
									if(e.value!=""){
										document.getElementById('bill_terms').value="";
									}
									
								}
							</script>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Due Date</p>
                            <input type="date" onchange="setbill_terms(this)" id="bill_due_date_bill" name="bill_due_date" class="w-100 form-control" required>
                        </div>
                        
                    </div>
                    <div class="col-md-12 p-0">
                        
                            
                            <div class="col-md-4 p-0 pr-3" style="{{!empty($numbering) && $numbering->use_cost_center=="Off"? 'display:none;' : ''}}">
                                <p>Cost Center</p>
                                <select name="CostCenterBill" id="CostCenterBill" onchange="EnableBillInput(this)" class="w-100 selectpicker CostCenterBill" data-live-search="true" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : 'required'}}>
                                    <option value="">--Select Cost Center--</option>
                                    {!! $cc_list_after_foreach !!}
                                    </select>
                            </div>
                            
                        
                    </div>
                    <div class="col-md-12 p-0">
                        
                            <div class="col-md-4 p-0 pr-3">
                                <p>Name</p>
                                <select id="billpayee" type="text" name="bill_customer" class="w-100 selectpicker" data-live-search="true" required>
                                        <option value="">--Select Name--</option>
                                        {!! $customers_list_after_foreach !!}
                                
                                        </select>
                            </div>
                            
                        
                    </div>
                    
                    
                    
                    
                    <div class="col-md-12 p-0 d-inline-flex">
                        <div class="col-md-4 p-0 pr-3">
                            <p>Billing Address</p>
                            <input type="text" name="bill_billing_address" id="bill_billing_address" class="w-100 form-control" >
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Terms</p>
                            <input type="text" list="terms_list" value="{{!empty($expense_setting) ? $expense_setting->expenses_bill_payment_terms : ''}}" name="bill_terms" id="bill_terms" class="w-100 form-control" >
                            
                        </div>
                        
                    </div>
                    <div class="col-md-12 p-0 d-inline-flex">
                        <div class="col-md-2 p-0 pr-3">
                            <p>RF</p>
                            <input type="text" name="RF_bill" id="RF_bill" placeholder="Request Form" class="w-100 form-control" required>
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>PO</p>
                            <input type="text" name="PO_bill" id="PO_bill" placeholder="Purchase Order" class="w-100 form-control" required >
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>CI</p>
                            <input type="text" name="CI_bill" id="CI_bill" placeholder="Charge Invoice" class="w-100 form-control"  required>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 d-inline-flex justify-content-end" style="float:right;margin-right:5%;">
                        <h4 class="mr-2">BALANCE DUE: </h4>
                        <h4 class="mr-1">PHP 0.00</h4>
                    </div>
                    <div class="col-md-12 mb-1 mt-3" style="padding-left:0px;">
                        <h4>Account Details</h4>
                    </div>
                    <table class="table table-bordered table-responsive-md table-sm text-left font14" id="bill_account_table">
                        <thead>
                            <tr>
                                <th class="text-left" width="5%">#</th>
                                <th class="text-left" width="20%">ACCOUNT</th>
                                <th class="text-left" width="">DESCRIPTION</th>
                                <th class="text-left" width="20%">AMOUNT</th>
                                <th class="text-center" width="5%"></th>
                            </tr>
                        </thead>
                        <tbody id="bill_account_table_tbody">

                        </tbody>
                    </table>
                    <div class="col-md-12 p-0 mt-4">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_bill_account">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_bill_account">Clear All Items</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-1 mt-4" style="display:none;">
                        <h4>Item Details</h4>
                    </div>
                    <table style="display:none;" class="table table-bordered table-responsive-md table-striped text-left font14" id="bill_item_table">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">PRODUCT/SERVICE</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-center">QTY</th>
                            <th class="text-left">RATE</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                    </table>
                    <div class="col-md-12 p-0" style="display:none;">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_bill_item">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_bill_item">Clear All Items</button>
                            </div>
                        </div>
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                <p class="mb-0 text-dark font-weight-bold">PHP 1400.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-4">
                        <div class="col-md-6 pl-0">
                            <p>Memo</p>
                            <textarea rows="3" class="w-100 form-control" name="bill_memo"></textarea>
                        </div>
                        <div class="col-md-6 m-0 pr-0" style="display:none;">
                            <div class="d-inline-flex">
                                <p class="fa fa-paperclip"></p>
                                <p class="p-0 ml-1">Maximum Size: 20MB</p>
                            </div>
                            <div class="input-group mb-3 p-0">
                                <div class="custom-file">
                                    <input type="file" name="bill_attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 p-0 mt-4">
                        <table class="table table-light  mb-0">
                            <thead class="thead-light  table-sm">
                                <tr>
                                    <th colspan="2" style="vertical-align:middle;text-align:center;">Credit</th>
                                </tr>
                            </thead>
                        </table>
                        <button type="button" style="display:none;" id="bill_credit_account_code_button"></button>
                        <button type="button" style="display:none;" id="bill_credit_account_account_button"></button>
                        <script>
                        function set_bill_account_code_account(origin,destination){
                            var code=document.getElementById(origin).value;
                            document.getElementById(destination).value=code;
                            if(destination=="bill_account_credit_account"){
                                document.getElementById('bill_credit_account_account_button').click();
                            }else{
                                document.getElementById('bill_credit_account_code_button').click();
                            }
                            
                        }
                        </script>
                        <table class="table table-light table-sm" id="tableexpensebill_credit_account_table">
                            <thead class="thead-light">
                                <tr>
                                    <th style="vertical-align:middle;text-align:center;"width="30%">Code</th>
                                    <th style="vertical-align:middle;text-align:center;"width="70%">Account</th>
                                </tr>
                            </thead>
                            <tbody id="tableexpensebill_credit_account_table_body">
                                <tr>
                                    <td style="vertical-align:middle;text-align:center;">
                                        <select class="form-control selectpicker" onchange="set_bill_account_code_account('bill_account_credit_account_code','bill_account_credit_account')" data-live-search="true" name="bill_account_credit_account_code"  id="bill_account_credit_account_code" required>
                                        <option value="">--Select Account--</option>
                                        @foreach($c_o_a_sorted as $coa)
                                        @if ($coa->id=="3")
                                        <option  value="{{$coa->id}}" selected>{{$coa->coa_code}}</option>  
                                        @else
                                        <option  value="{{$coa->id}}">{{$coa->coa_code}}</option>   
                                        @endif
                                        @endforeach
                                        </select>
                                    </td>
                                    <td style="vertical-align:middle;" class="pr-0">
                                        <select class="form-control selectpicker" onchange="set_bill_account_code_account('bill_account_credit_account','bill_account_credit_account_code')" data-live-search="true" name="bill_account_credit_account"  id="bill_account_credit_account" required>
                                        <option value="">--Select Account--</option>
                                        @foreach($c_o_a_sorted as $coa)
                                        @if ($coa->id=="3")
                                        <option  value="{{$coa->id}}" selected>{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>  
                                        @else
                                        <option  value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>   
                                        @endif
                                        
                                        @endforeach
                                        </select>
                                        
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button id="billadd" class="btn btn-success rounded" type="submit">Save</button>
            </div>
        </div>
    </div>
</form>
</div>
<div class="modal fade p-0" id="purchaseordermodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
<form action="#" class="form-horizontal " id="add_purchase_order_form" onsubmit="addPurchaseOrder()" autocomplete="off">
{{ csrf_field() }}
<input id="item_count_pos" name="item_count_pos" value="0" hidden>
<input id="account_count_pos" name="account_count_pos" value="0" hidden>
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Purchase Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="my-3 p-0">
                        <div class="col-md-3 p-0 pr-3">
                            <select type="text" name="po_customer"  id="po_customer" class="w-100">
                                    <option value="">--Select Name--</option>
                                    {!! $customers_list_after_foreach !!}
                            </select>
                        </div>
                        <div class="col-md-3 p-0">
                            <input type="text" name="po_email" id="po_email" placeholder="Email (Separate emails with a comma)" class="w-100">
                            <br>
                            <div class="float-right">
                                <p class="text-info"></p>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4 p-0 " style="text-align:center;">
                            <h4 class="mr-2">AMOUNT: </h4>
                            <h3>PHP 0.00</h3>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-3">
                        <div class="col-md-3 p-0 pr-3">
                            <p>Mailing Address</p>
                            <input type="text" name="po_mail_address" id="po_mail_address" class="w-100">
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Ship To</p>
                            <input type="text" name="po_ship_to" class="w-100">
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Purchase Order Date</p>
                            <input type="date" name="po_date" class="w-100">
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-3 d-inline-flex">
                        <div class="col-md-3 p-0 pr-3">
                            <p>Shipping Address</p>
                            <input type="text" name="po_ship_address" class="w-100">
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Ship Via</p>
                            <input type="text" name="po_ship_via" class="w-100">
                        </div>
                    </div>
                    <div class="col-md-12 mb-1 mt-4">
                        <h4>Account Details</h4>
                    </div>
                    <table class="table table-bordered table-responsive-md table-striped text-left font14"  id="po_account_table">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">ACCOUNT</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_po_account">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_po_account">Clear All Items</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-1 mt-4">
                        <h4>Item Details</h4>
                    </div>
                    <table class="table table-bordered table-responsive-md table-striped text-left font14"  id="po_item_table">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">PRODUCT/SERVICE</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-center">QTY</th>
                            <th class="text-left">RATE</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_po_item">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_po_item">Clear All Items</button>
                            </div>
                        </div>
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="mb-0 pr-4 text-dark font-weight-bold">SUBTOTAL</p>
                                <p class="mb-0 text-dark font-weight-bold">PHP 0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="pr-4 text-dark font-weight-bold">TOTAL</p>
                                <p class="text-dark font-weight-bold">PHP 0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0">
                        <div class="col-md-6 pl-0">
                            <p>Your Message to Supplier</p>
                            <textarea rows="3" name="po_message" class="w-100"></textarea>
                        </div>
                        <div class="col-md-6 pr-0">
                            <p>Memo</p>
                            <textarea rows="3" name="po_memo" class="w-100"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 m-0 p-0 mt-3" style="display:none;">
                        <div class="d-inline-flex">
                            <p class="fa fa-paperclip"></p>
                            <p class="p-0 ml-1">Maximum Size: 20MB</p>
                        </div>
                        <div class="input-group mb-3 p-0">
                            <div class="custom-file">
                                <input type="file" name="po_attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success rounded" type="submit">Save</button>
            </div>
        </div>
    </div>
    </form>
</div>
<script>
    @if(!empty($numbering) && $numbering->use_cost_center=="Off")

    @else
    $(document).ready(function(){
        //$("#add_supplier_credit_form :input").prop("disabled", true);
        //document.getElementById('CostCenterSupplierCredit').disabled=false;
        document.getElementById('suppliercreditclosemodalbutton').disabled=false;
        
    });

    @endif
    function EnableSupplierCreditInput(e){
        if(e.value==""){
            //$("#add_supplier_credit_form :input").prop("disabled", true);
            document.getElementById('CostCenterSupplierCredit').disabled=false;
            document.getElementById('suppliercreditclosemodalbutton').disabled=false;
        }else{
            var asd=e.value;
            //$("#add_supplier_credit_form :input").prop("disabled", false);
            document.getElementById('CostCenterSupplierCredit').value=asd;
        }
    }
</script>
<div class="modal fade p-0" id="suppliercreditmodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
    <form action="#" class="form-horizontal " id="add_supplier_credit_form" onsubmit="addSupplierCredit()" autocomplete="off">
    {{ csrf_field() }}
    <input id="item_count_scs" name="item_count_scs" value="0" hidden>
    <input id="account_count_scs" name="account_count_scs" value="0" hidden>
        <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
            <div class="modal-content" style="min-height: 100vh;">
                <div class="modal-header">
                    <h5 class="modal-title">Supplier Credit</h5>
                    <button type="button" class="close" id="suppliercreditclosemodalbutton" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-4" id="result">
                    <div class="col-md-12 p-0 mb-4">
                        <div class="my-3 p-0">
                            <div class="col-md-3 p-0  pr-3">
                                <p>Supplier Credit No.</p>
                                <input type="hidden" name="supplier_credit_bill_no" id="supplier_credit_bill_no" oninput="fetch_bill_info()">
                                <input type="text" name="suppliers_credit_no" id="suppliers_credit_no" required class="form-control" onkeyup="setsupplier_credit_no_new()"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                <script>
                                    function supplier_credit_modal_open(id){
                                        document.getElementById('supplier_credit_bill_no').value=id;
                                        fetch_bill_info();
                                    }
                                    function fetch_bill_info(){
                                        var supplier_credit_bill_no=document.getElementById('supplier_credit_bill_no').value;
                                        if(supplier_credit_bill_no!=''){
                                            document.getElementById('clear_lines_sc_account').disabled=false;
                                            document.getElementById('clear_lines_sc_account').click();
                                            $.ajax({
                                                method: "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                url: "check_bill_no",
                                                data: {invoice_no_field:supplier_credit_bill_no,_token: '{{csrf_token()}}'},
                                                success: function (data) {
                                                    if(data>0){
                                                        $.ajax({
                                                            method: "POST",
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            },
                                                            url: "get_bill_info_for_supplier_credit",
                                                            data: {supplier_credit_bill_no:supplier_credit_bill_no,_token: '{{csrf_token()}}'},
                                                            success: function (data) {
                                                                console.log(data);
                                                                document.getElementById('sc_customer').value=data['et_customer'];
                                                                @foreach($JournalEntry as $JE)
                                                                    if("{{$JE->other_no}}"==supplier_credit_bill_no && "{{$JE->je_transaction_type}}"=="Bill"){
                                                                        document.getElementById('CostCenterSupplierCredit').value="{{$JE->je_cost_center}}";
                                                                    }
                                                                @endforeach
                                                                
                                                                document.getElementById('sc_reference_no').value=data['et_shipping_address'];
                                                                document.getElementById('sc_reference_no_po').value=data['et_shipping_to'];
                                                                document.getElementById('sc_reference_no_ci').value=data['et_shipping_via'];
                                                                document.getElementById('sc_memo').value=data['et_memo'];
                                                                document.getElementById('supplier_credit_account_debit_account').value=data['et_credit_account'];
                                                                $.ajax({
                                                                    method: "POST",
                                                                    headers: {
                                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                    },
                                                                    url: "get_bill_account_detail",
                                                                    data: {supplier_credit_bill_no:supplier_credit_bill_no,_token: '{{csrf_token()}}'},
                                                                    success: function (data) {
                                                                        console.log(data);
                                                                        for(var c=0;c<data.length;c++){
                                                                            if(data[c]['et_ad_rate']=='1'){
                                                                                var markup = '<tr class="sc_lines_account " id="sc_line_account'+$('#sc_account_table tr').length+'"><td class="pt-3-half" style="vertical-align:middle;text-align:center;"><input type="checkbox"  id="return_item_sc'+$('#sc_account_table tr').length+'"  name="return_item_sc[]" value="'+data[c]['et_ad_id']+'"><input type="hidden" name=hiddenet_ad_id'+$('#sc_account_table tr').length+' id=hiddenet_ad_id'+$('#sc_account_table tr').length+' value="'+data[c]['et_ad_id']+'"></td><td class="pt-3-half" id="number_tag_sc_account" contenteditable="false">'+$('#sc_account_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" list="account_expenses" class="sc_data account_select_sc selectpicker form-control" disabled data-live-search="true" id="select_account_sc'+$('#sc_account_table tr').length+'"><option value="">--Select Account--</option>'+coa_list_js+'</select></td><td class="pt-3-half"><input class="sc_data description_select_sc form-control" disabled id="select_description_sc'+$('#sc_account_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" step="0.01" disabled class="sc_data amount_select_sc form-control" onclick="this.select();" id="select_sc_amount'+$('#sc_account_table tr').length+'" style="border:0; text-align:right;"></td></tr>';
                                                                                var rowcount=$('#sc_account_table tr').length;
                                                                                $("#sc_account_table").append(markup);
                                                                            }else{
                                                                                var markup = '<tr class="sc_lines_account table-success" id="sc_line_account'+$('#sc_account_table tr').length+'"><td class="pt-3-half" style="vertical-align:middle;text-align:center;"><input style="display:none;" checked type="checkbox" id="return_item_sc'+$('#sc_account_table tr').length+'"  name="return_item_sc[]" value="'+data[c]['et_ad_id']+'"><input type="hidden" name=hiddenet_ad_id'+$('#sc_account_table tr').length+' id=hiddenet_ad_id'+$('#sc_account_table tr').length+'></td><td class="pt-3-half" id="number_tag_sc_account" contenteditable="false">'+$('#sc_account_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" list="account_expenses" class="sc_data account_select_sc selectpicker form-control" disabled data-live-search="true" id="select_account_sc'+$('#sc_account_table tr').length+'"><option value="">--Select Account--</option>'+coa_list_js+'</select></td><td class="pt-3-half"><input class="sc_data description_select_sc form-control" disabled id="select_description_sc'+$('#sc_account_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" step="0.01" disabled class="sc_data amount_select_sc form-control" onclick="this.select();" id="select_sc_amount'+$('#sc_account_table tr').length+'" style="border:0; text-align:right;"></td></tr>';
                                                                                var rowcount=$('#sc_account_table tr').length;
                                                                                $("#sc_account_table").append(markup);
                                                                            }
                                                                            
                                                                            document.getElementById('select_account_sc'+rowcount).value=data[c]['et_ad_product'];
                                                                            document.getElementById('select_description_sc'+rowcount).value=data[c]['et_ad_desc'];
                                                                            document.getElementById('select_sc_amount'+rowcount).value=data[c]['et_ad_total'];
                                                                            
                                                                        }
                                                                        $('#sc_customer').change();
                                                                        refreshpicjer();
                                                                    }
                                                                });
                                                            }
                                                        });
                                                    }
                                                }
                                            });  
                                        }
                                    }
                                    function setsupplier_credit_no_new(){
                                        var invoice_no_field=document.getElementById('suppliers_credit_no').value;
                                        $.ajax({
                                            method: "POST",
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            url: "check_supplier_credit_no",
                                            data: {invoice_no_field:invoice_no_field,_token: '{{csrf_token()}}'},
                                            success: function (data) {
                                                if(data>0){
                                                    document.getElementById('suppliers_credit_no').style.border="1px solid red";
                                                    document.getElementById('supplier_credit_button').disabled=true;
                                                }else{
                                                    document.getElementById('suppliers_credit_no').style.border="1px solid green";
                                                    document.getElementById('supplier_credit_button').disabled=false;
                                                }
                                            }
                                        });
                                    }
                                </script>
                            </div>
                            <div class="col-md-3 p-0 pr-3">
                                <p>Name</p>
                                <select  name="sc_customer"  id="sc_customer" class="w-100 selectpicker" data-live-search="true" disabled>
                                <option value="">--Select Customer--</option>
                                {!! $customers_list_after_foreach !!}
                                </select>
                            </div>
                            <div class="col-md-2 p-0 pr-3" style="{{!empty($numbering) && $numbering->use_cost_center=="Off"? 'display:none;' : ''}}">
                                <p>Cost Center</p>
                                <select class="selectpicker" data-live-search="true" name="CostCenterSupplierCredit" onchange="EnableSupplierCreditInput(this)" id="CostCenterSupplierCredit" style="width:90%;" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : 'required'}} disabled>
                                    <option value="">--Select Cost Center--</option>
                                    {!! $cc_list_after_foreach !!}
                                    </select>
                            </div>
                            
                            <div class="col-md-4 p-0 d-inline-flex center-content" style="text-align:center;">
                                <h4 class="mr-2">CREDIT AMOUNT: </h4>
                                <h4>PHP 0.00</h4>
                            </div>
                        </div>
                        <div class="col-md-12 p-0 mt-4 d-inline-flex">
                            <div class="col-md-3 p-0 pr-3">
                                <p>Mailing Address</p>
                                <input type="text" name="sc_mail_address" id="sc_mail_address" class="w-100 form-control" disabled>
                            </div>
                            <div class="col-md-2 p-0 pr-3">
                                <p>Payment Date</p>
                                <input type="date" name="sc_date" class="w-100 form-control">
                            </div>
                            <div class="col-md-2 p-0 pr-3">
                                <p>Request Form</p>
                                <input type="text" id="sc_reference_no" name="sc_reference_no" class="w-100 form-control" disabled>
                            </div>
                            <div class="col-md-2 p-0 pr-3">
                                <p>Purchase Order</p>
                                <input type="text" name="sc_reference_no_po" id="sc_reference_no_po" class="w-100 form-control" disabled>
                            </div>
                            <div class="col-md-2 p-0 pr-3">
                                <p>Charge Invoice</p>
                                <input type="text" name="sc_reference_no_ci" id="sc_reference_no_ci" class="w-100 form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-12 mb-1 mt-3">
                            <h4>Account Details</h4>
                        </div>
                        <table class="table table-bordered table-responsive-md table-striped text-left font14" id="sc_account_table">
                            <tr>
                                <th class="text-center"></th>
                                <th class="text-left">#</th>
                                <th class="text-left">ACCOUNT</th>
                                <th class="text-left">DESCRIPTION</th>
                                <th class="text-left">AMOUNT</th>
                                
                            </tr>
                        </table>
                        <div class="col-md-12 p-0" style="display:none;">
                            <div class="float-left">
                                <div class="d-inline-flex">
                                    {{-- <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_sc_account">Add Items</button> --}}
                                    <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_sc_account">Clear All Items</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-1 mt-4" style="display:none;">
                            <h4>Item Details</h4>
                        </div>
                        <table style="display:none;" class="table table-bordered table-responsive-md table-striped text-left font14" id="sc_item_table">
                            <tr>
                                <th class="text-left">#</th>
                                <th class="text-left">PRODUCT/SERVICE</th>
                                <th class="text-left">DESCRIPTION</th>
                                <th class="text-center">QTY</th>
                                <th class="text-left">RATE</th>
                                <th class="text-left">AMOUNT</th>
                                <th class="text-center"></th>
                            </tr>
                        </table>
                        <div class="col-md-12 p-0" style="display:none;">
                            <div class="float-left" >
                                <div class="d-inline-flex">
                                    <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_sc_item">Add Items</button>
                                    <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_sc_item">Clear All Items</button>
                                </div>
                            </div>
                            <div class="float-right mr-5">
                                <div class="d-inline-flex mr-4">
                                    <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                    <p class="mb-0 text-dark font-weight-bold">PHP 0.00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 p-0 mt-4">
                            <div class="col-md-6 pl-0">
                                <p>Memo</p>
                                <textarea rows="3" name="sc_memo" id="sc_memo" class="w-100 form-control" required></textarea>
                            </div>
                            <div class="col-md-6 m-0 pr-0" style="display:none;">
                                <div class="d-inline-flex">
                                    <p class="fa fa-paperclip"></p>
                                    <p class="p-0 ml-1">Maximum Size: 20MB</p>
                                </div>
                                <div class="input-group mb-3 p-0">
                                    <div class="custom-file">
                                        <input type="file" name="sc_attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 p-0 mt-4">
                            <table class="table table-light">
                                <thead class="thead-light">
                                    <tr>
                                        <th colspan="2" style="vertical-align:middle;text-align:center;">Accounts</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="vertical-align:middle;text-align:center;">Debit</td>
                                        <td style="vertical-align:middle;" class="pr-0">
                                            <select class="form-control selectpicker" data-live-search="true" name="supplier_credit_account_debit_account"  id="supplier_credit_account_debit_account" required disabled>
                                            <option value="" selected>--Select Account--</option>
                                            @foreach($c_o_a_sorted as $coa)
                                            @if ($coa->id=="3")
                                            <option value="{{$coa->id}}" selected>{{$coa->coa_name}}</option> 
                                            @else
                                            <option value="{{$coa->id}}">{{$coa->coa_name}}</option>  
                                            @endif
                                            
                                            @endforeach
                                            </select>
                                            
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success rounded" id="supplier_credit_button" type="submit">Save</button>
                </div>
            </div>
        </div>
        </form>
    </div>
<div class="modal fade p-0" id="creditcardcreditmodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
<form action="#" class="form-horizontal " id="add_card_credit_form" onsubmit="addCardCredit()" autocomplete="off">
{{ csrf_field() }}
<input id="item_count_ccs" name="item_count_ccs" value="0" hidden>
<input id="account_count_ccs" name="account_count_ccs" value="0" hidden>
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Credit Card Charges</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="my-3 p-0">
                        <div class="col-md-3 p-0 pr-3">
                            <select type="text" name="cc_customer" id="cc_customer" class="w-100">
                                <option value="">--Select Name--</option>
                                {!! $customers_list_after_foreach !!}
                            </select>
                        </div>
                        <div class="col-auto p-0 pr-2">
                            <p class="font12 font-weight-bold float-right">Credit Card Account</p>
                        </div>
                        <div class="col-md-3 p-0">
                            <!-- <p class="font12 font-weight-bold">Bank/Credit Account</p> -->
                            <input type="text" list="account_expenses" name="cc_account" placeholder="Credit Card" class="w-100">
                        </div>
                        <div class="col-md-4 p-0 ml-5  d-inline-flex">
                            <h4 class="mr-2">AMOUNT: </h4>
                            <h3 id="ccbalance">PHP 0.00</h3>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-3 d-inline-flex">
                        <div class="col-md-2 p-0 pr-3">
                            <p>Payment Date</p>
                            <input type="date" name="cc_date" class="w-100">
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Reference No.</p>
                            <input type="text" name="cc_reference_no" class="w-100">
                        </div>
                    </div>
                    <div class="col-md-12 mb-1">
                        <h4>Account Details</h4>
                    </div>
                    <table class="table table-bordered table-responsive-md table-striped text-left font14" id="cc_account_table">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">ACCOUNT</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_cc_account">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_cc_account">Clear All Items</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-1 mt-4" style="display:none;">
                        <h4>Item Details</h4>
                    </div>
                    <table style="display:none;" class="table table-bordered table-responsive-md table-striped text-left font14" id="cc_item_table">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">PRODUCT/SERVICE</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-center">QTY</th>
                            <th class="text-left">RATE</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-left" style="display:none;">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_cc_item">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_cc_item">Clear All Items</button>
                            </div>
                        </div>
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                <p class="mb-0 text-dark font-weight-bold">PHP 0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-4">
                        <div class="col-md-6 pl-0">
                            <p>Memo</p>
                            <textarea rows="3" name="cc_memo" class="w-100"></textarea>
                        </div>
                        <div class="col-md-6 m-0 pr-0" style="display:none;">
                            <div class="d-inline-flex">
                                <p class="fa fa-paperclip"></p>
                                <p class="p-0 ml-1">Maximum Size: 20MB</p>
                            </div>
                            <div class="input-group mb-3 p-0">
                                <div class="custom-file">
                                    <input type="file" name="cc_attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success rounded" type="submit">Save</button>
            </div>
        </div>
    </div>
    </form>
</div>
<!--Edit Credit Card Charge Modal-->
<script>
function addCardCreditedit(){
    var customer=document.getElementById('cc_customeredit').value;
    var account=document.getElementById('cc_accountedit').value;
    var date=document.getElementById('cc_dateedit').value;
    var ref_no=document.getElementById('cc_reference_noedit').value;
    var memo=document.getElementById('cc_memoedit').value;
    var id=document.getElementById('cc_edit_transaction_id').value;
    var accounts1=[];
    var desc1=[];
    var amount1=[];
    $(".cc_line_accountedit").find('.cc_data').each(function() {
        var id = $(this).attr("id");
        var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
        
        var acc="select_account_ccedit";
        var des="select_description_ccedit";
        var amo="select_cc_amountedit";
        if(id.indexOf(acc) >= 0){
            accounts1.push(document.getElementById(id).value);
        }
        else if(id.indexOf(des) >= 0){
            desc1.push(document.getElementById(id).value);
        }
        else if(id.indexOf(amo) >= 0){
            amount1.push(document.getElementById(id).value);
        }   
        
    });
    $.ajax({
    type: 'POST',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '{{ route('update_expenses_credit_card_charges') }}',                
    data: {id:id,customer:customer,account:account,date:date,ref_no:ref_no,memo:memo,accounts1:accounts1,desc1:desc1,amount1:amount1,_token: '{{csrf_token()}}'},
    success: function(data) {
       
        swal({title: "Done!", text: "Updated Credit Card Charge.", type: 
            "success"}).then(function(){ 
            location.reload();
        });
    }  

    })
}
</script>
<div class="modal fade p-0" id="creditcardcreditmodaledit" tabindex="-1" role="dialog" aria-hidden="true" style="">
<form action="#" class="form-horizontal " id="add_card_credit_formedit" onsubmit="return false,addCardCreditedit()" autocomplete="off">
{{ csrf_field() }}
<input id="item_count_ccsedit" name="item_count_ccsedit" value="0" hidden>
<input id="account_count_ccsedit" name="account_count_ccsedit" value="0" hidden>
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Credit Card Charges</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="my-3 p-0">
                        <div class="col-md-3 p-0 pr-3">
                            <input type="hidden" id="cc_edit_transaction_id">
                            <select type="text" name="cc_customeredit" id="cc_customeredit" class="w-100">
                                <option value="">--Select Name--</option>
                                {!! $customers_list_after_foreach !!}
                            </select>
                        </div>
                        <div class="col-auto p-0 pr-2">
                            <p class="font12 font-weight-bold float-right">Credit Card Account</p>
                        </div>
                        <div class="col-md-3 p-0">
                            <!-- <p class="font12 font-weight-bold">Bank/Credit Account</p> -->
                            <input type="text" list="account_expenses" id="cc_accountedit" name="cc_accountedit" placeholder="Credit Card" class="w-100">
                        </div>
                        <div class="col-md-4 p-0 ml-5  d-inline-flex">
                            <h4 class="mr-2">AMOUNT: </h4>
                            <h3 id="ccbalanceedit">PHP 0.00</h3>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-3 d-inline-flex">
                        <div class="col-md-2 p-0 pr-3">
                            <p>Payment Date</p>
                            <input type="date" name="cc_dateedit"  {{$user_position->position!="CEO"? 'readonly' : ''}} id="cc_dateedit" class="w-100">
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Reference No.</p>
                            <input type="text" name="cc_reference_noedit" id="cc_reference_noedit" class="w-100">
                        </div>
                    </div>
                    <div class="col-md-12 mb-1">
                        <h4>Account Details</h4>
                    </div>
                    <table class="table table-bordered table-responsive-md table-striped text-left font14" id="cc_account_tableedit">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">ACCOUNT</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_cc_accountedit">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_cc_accountedit">Clear All Items</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-1 mt-4" style="display:none;">
                        <h4>Item Details</h4>
                    </div>
                    <table style="display:none;" class="table table-bordered table-responsive-md table-striped text-left font14" id="cc_item_tableedit">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">PRODUCT/SERVICE</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-center">QTY</th>
                            <th class="text-left">RATE</th>
                            <th class="text-left">AMOUNT</th>
                            <th class="text-center"></th>
                        </tr>
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-left" style="display:none;">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="add_lines_cc_itemedit">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14" id="clear_lines_cc_itemedit">Clear All Items</button>
                            </div>
                        </div>
                        <div class="float-right mr-5">
                            <div class="d-inline-flex mr-4">
                                <p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p>
                                <p class="mb-0 text-dark font-weight-bold">PHP 0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-4">
                        <div class="col-md-6 pl-0">
                            <p>Memo</p>
                            <textarea rows="3" name="cc_memoedit" id="cc_memoedit" class="w-100"></textarea>
                        </div>
                        <div class="col-md-6 m-0 pr-0" style="display:none;">
                            <div class="d-inline-flex">
                                <p class="fa fa-paperclip"></p>
                                <p class="p-0 ml-1">Maximum Size: 20MB</p>
                            </div>
                            <div class="input-group mb-3 p-0">
                                <div class="custom-file">
                                    <input type="file" name="cc_attachmentedit" class="custom-file-input" id="inputGroupFile01edit" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label bg-transparent" for="inputGroupFile01edit">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success rounded" type="submit">Save</button>
            </div>
        </div>
    </div>
    </form>
</div>


<!--Credit Card Charge Modal End-->
<div class="modal fade p-0" id="bankdepositmodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <form action="#" id="deposit_record_form">
        <div class="modal-content" style="min-height: 100vh;">
            <script>
                function SaveDepositRecord(){
                    var deposit_record_date="{{date('Y-m-d')}}";
                    var deposit_record_memo="";
                    
                    var checked=[];
                    var checkeddeposit_to=[];
                    var count=document.getElementById('rowcountrecorddeposit').value;
                    for(c=1;c<=count;c++){      
                        if($('#invalidCheck'+c).prop("checked")==true){
                        //totaldeposit=totaldeposit+$('#amountdeposti'+c).attr('title');
                         checked.push(document.getElementById('invalidCheck'+c).value);  
                         checkeddeposit_to.push(document.getElementById('deposit_record_bank_account'+c).value); 
                        }
                    }
                    console.log(checked);
                    console.log(checkeddeposit_to);
                    $.ajax({
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('add_deposit_record') }}",
                        dataType: "text",
                        data: {deposit_deposit_to:checkeddeposit_to,checked:checked,deposit_record_date:deposit_record_date,deposit_record_memo:deposit_record_memo,_token: '{{csrf_token()}}'},
                        success: function (data) {
                            console.log(data);
                            //swal("Done!", "Added Deposit Record", "success");
                            swal({title: "Done!", text: "Added Deposit Record", type: 
                            "success"}).then(function(){
                                setTimeout(function(){
                                    location.reload();
                                }, 1000);
                                
                            });
                        },
                        error: function (data) {
                            
                            swal("Error!", "Deposit Record failed", "error");
                        }
                    });

                }
                $("#deposit_record_form").submit(function(e) {
                    e.preventDefault();
                    SaveDepositRecord();
                });
            </script>
            
            <div class="modal-header">
                <h5 class="modal-title">Undeposited Funds</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    
                    
                    <script>
                        function getTotalDeposit(){
                            var count=document.getElementById('rowcountrecorddeposit').value;
                            var totaldeposit=0;
                            for(c=1;c<=count;c++){
                                
                                if($('#invalidCheck'+c).prop("checked")==true){
                                    
                                    totaldeposit=parseFloat(totaldeposit)+parseFloat($('#amountdeposti'+c).attr('title'));

                                }
                            }
                            document.getElementById('Total_Deposit').innerHTML=number_format(totaldeposit,2);
                        }
                    </script>
                    <table class="table table-bordered table-responsive-md table-striped text-left font14">
                        <tr>
                            <th class="text-left"><input type="hidden" id="rowcountrecorddeposit"></th>
                            <th class="text-left">RECEIVED FROM</th>
                            <th class="text-left" width="15%">COST CENTER</th>
                            <th class="text-left">MEMO</th>
                            <th class="text-left">DEPOSIT TO</th>
                            <th class="text-left">PAYMENT METHOD</th>
                            <th class="text-left">BANK</th>
                            <th class="text-left">CHEQUE NO</th>
                            <th class="text-left">AMOUNT</th>
                            
                        </tr>
                        <?php
                        $deposit_record_count=0;
                        ?>
                        @foreach ($SS as $st)
                            @if($st->st_type=="Sales Receipt" && $st->st_action=="" && $st->remark=="")
                            <?php
                            $deposit_record_count++;
                            ?>
                            <script>
                            document.getElementById('rowcountrecorddeposit').value="{{$deposit_record_count}}";
                            </script>
                            <tr>
                                <td class="pt-3-half" contenteditable="false" style="vertical-align:middle;text-align:center;">
                                <input  type="checkbox" onclick="getTotalDeposit()" value="{{$st->st_no}}" id="invalidCheck{{$deposit_record_count}}">
                                </td>
                                <td class="pt-3-half" contenteditable="false" id="sales_customersa{{$deposit_record_count}}">
                                   
                                </td>
                                <script>
                                        $(document).ready(function(){
                                            $.ajax({
                                                type: "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                url: "get_customer_info",
                                                data: {id:'{{$st->st_customer_id}}',_token:'{{csrf_token()}}'},
                                                success: function (customer) {
                                                    console.log(customer);
                                                    console.log(customer['customer_id']);
                                                    if(customer['display_name']==''){
                                                        document.getElementById('sales_customersa{{$deposit_record_count}}').innerHTML=customer['f_name']+" "+customer['l_name'];
                                                    }else{
                                                        document.getElementById('sales_customersa{{$deposit_record_count}}').innerHTML=customer['display_name']; 
                                                    }
    
                                                    
                                                }
                                            });
                                        })
                                        
                                    </script>
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
                                <td class="pt-3-half" contenteditable="false">{{$st->st_memo}}</td>
                                <td class="pt-3-half" contenteditable="false">
                                <select  id="deposit_record_bank_account{{$deposit_record_count}}" class="w-100" >
                                    <option value="">--Select Bank--</option>
                                    @foreach ($banks as $bank)
                                    @if($bank->bank_status=="1")
                                    <option title="{{$bank->bank_account_no}}" value="{{$bank->bank_no}}">{{$bank->bank_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
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
                                <td class="pt-3-half" style="text-align:right;vertical-align:middle;" contenteditable="false" id="amountdeposti{{$deposit_record_count}}" title='{{$st->st_amount_paid}}'>PHP {{number_format($st->st_amount_paid,2)}}</td>
                            </tr>
                            @endif
                        @endforeach
                        
                    </table>
                    
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            
                        </div>
                        <div class="float-right mr-4">
                            <div class="d-inline-flex">
                                <p class="pr-4 text-dark font-weight-bold">DEPOSIT TOTAL</p>
                                <p class="text-dark font-weight-bold" id="Total_Deposit">PHP 0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-2" style="display:none;">
                        <div class="col-md-2 p-0 pr-3">
                            <p>Cashback goes to</p>
                            <input type="text" name="" placeholder="Cash and Cash Equivalents" class="w-100">
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Cashback Memo</p>
                            <input type="text" name="" class="w-100">
                        </div>
                        <div class="col-md-2 p-0 pr-3">
                            <p>Cashback Amount</p>
                            <input type="text" name="" class="w-100">
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                @if($deposit_record_count==0)
                @else
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success rounded">Save</button>

                @endif
                
            </div>
        
        </div>
    </form>
    </div>
</div>
<div class="modal fade p-0" id="transfermodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Transfer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="col-md-6 p-0">
                        <p>Transfer Funds from</p>
                        <input type="text" name="">
                    </div>
                    <div class="col-md-6 p-0">
                        <p>Balance</p>
                        <h3>PHP 1000.00</h3>
                    </div>
                    <div class="col-md-12 mt-3"></div>
                    <div class="col-md-6 p-0">
                        <p>Transfer Funds To</p>
                        <input type="text" name="">
                    </div>
                    <div class="col-md-6 p-0">
                        <p>Balance</p>
                        <h3>PHP 1000.00</h3>
                    </div>
                    <div class="col-md-12 mt-3"></div>
                    <div class="col-md-6 p-0">
                        <p>Transfer Amount</p>
                        <input type="text" name="">
                    </div>
                    <div class="col-md-6 p-0">
                        <p>Date</p>
                        <input type="date" name="">
                    </div>
                    <div class="col-md-12 p-0 mt-4">
                        <div class="col-md-6 pl-0">
                            <p>Memo</p>
                            <textarea rows="3" class="w-100"></textarea>
                        </div>
                        <div class="col-md-6 m-0 pr-0">
                            <div class="d-inline-flex">
                                <p class="fa fa-paperclip"></p>
                                <p class="p-0 ml-1">Maximum Size: 20MB</p>
                            </div>
                            <div class="input-group mb-3 p-0">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success rounded" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>
<?php 
    $chequevoucher_no_series="";
    if($ChequeVoucherCount<10){
        $chequevoucher_no_series="000".$ChequeVoucherCount;
    }
    else if($ChequeVoucherCount>9 && $ChequeVoucherCount<100){
        $chequevoucher_no_series="00".$ChequeVoucherCount;
    }else if($ChequeVoucherCount>99 && $ChequeVoucherCount<1000){
        $chequevoucher_no_series="0".$ChequeVoucherCount;
    }
    $journalvoucher_no_series="";
    if($JournalVoucherCount<10){
        $journalvoucher_no_series="000".$JournalVoucherCount;
    }
    else if($JournalVoucherCount>9 && $JournalVoucherCount<100){
        $journalvoucher_no_series="00".$JournalVoucherCount;
    }else if($JournalVoucherCount>99 && $JournalVoucherCount<1000){
        $journalvoucher_no_series="0".$JournalVoucherCount;
    }
?>
<script>
    function changejournalentrytype(value){
        document.getElementById('journal_entry_type').value=value;
        document.getElementById('journal_entry_title_header').innerHTML=value;
        
        var column = journalentrytable.column( 8 );
        
        if(value=="Cheque Voucher"){
            // Toggle the visibility
            column.visible( true );
            document.getElementById('JVCVVOUCHERNO').value="{{'CV'.date('y').$chequevoucher_no_series}}";
           
                   
        }else{
            column.visible( false );
            document.getElementById('JVCVVOUCHERNO').value="{{'JV'.date('y').$journalvoucher_no_series}}";
        }
        
    }
    function DownloadTemplateJournalEntry(){
		$.ajax({
		type: 'POST',
		url: 'GetJournalEntryTemplateExcel',                
		data: {INPUT:""},
		success: function(data) {
		//location.href='download2.php?file=extra/edit_excel/Adjustment Template.xlsx';	
		} 											 
		})
							
	}
</script>
<div class="modal fade p-0" id="journalentrymodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title" id="journal_entry_title_header">Journal Entry</h5>
                <input type="hidden" name="journal_entry_type" id="journal_entry_type" value="ChequeVoucher">
                <button type="button" class="close" data-dismiss="modal" id="Closeeee" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="col-md-12 p-0 mb-4">
                        <div class="col-md-2 p-0">
                            <p>Journal Date</p>
                            <input type="date" name="" id="journalDate"   value="{{date('Y-m-d')}}">
                        </div>
                        <div class="col-md-2 p-0">
                        <p>Journal No.</p>    
                        <input type="number" name="" style="display:none;" readonly id="JournalNo" placeholder="1" value="{{$jounalcount}}">
                        <input type="text" name="" readonly id="JVCVVOUCHERNO" value="{{$ChequeVoucherCount}}">
                        <input type="text" style="display:none;" name="OtherNo" readonly id="OtherNo" placeholder="1" value="{{'Journal-'.$jounalcount}}">
                        <input type="text" style="display:none;" name="goSalesReceipt" readonly id="goSalesReceipt" placeholder="1" value="0">
                        <input type="text" style="display:none;" name="JournalEntryTransactionType" readonly id="JournalEntryTransactionType" value="Journal Entry">

                        </div>
                        <div class="col-md-2 p-0" style="display:none">
                            <p>Cost Center</p>
                            <select name="" class="selectpicker form-control" data-live-search="true" id="CostCenterJournalEntrty" onchange="enableFiledsJournalEntry(this.value)">
                                <option value="">--Select Cost Center--</option>
                                {!! $cc_list_after_foreach !!}
                            </select>
                        </div>
                    </div>
                    <script>
                        function enableFiledsJournalEntry(e){
                            if(e==0){
                                document.getElementById('journalDate').disabled=true;
                                document.getElementById('accjournbale1').disabled=true;
                                document.getElementById('accjournbale2').disabled=true;
                                document.getElementById('journalentryaddrow').disabled=true;
                                document.getElementById('journalentrydeleteallrow').disabled=true;
                                document.getElementById('JournalMemo').disabled=true;
                                document.getElementById('JournalEntrySaveButton').disabled=true;
                                document.getElementById('journalnamename1').disabled=true;
                                document.getElementById('journalnamename2').disabled=true;
                                
                            }else{
                                document.getElementById('journalDate').disabled=false;
                                document.getElementById('accjournbale1').disabled=false;
                                document.getElementById('accjournbale2').disabled=false;
                                document.getElementById('journalentryaddrow').disabled=false;
                                document.getElementById('journalentrydeleteallrow').disabled=false;
                                document.getElementById('JournalMemo').disabled=false;
                                document.getElementById('JournalEntrySaveButton').disabled=false;
                                document.getElementById('journalnamename1').disabled=false;
                                document.getElementById('journalnamename2').disabled=false;
                            }
                        }
                        function disablecanceljournalemodal(){
                            document.getElementById('closeinvoicejournalmodal').click();
                            document.getElementById('closevouchermodal').click();
                            document.getElementById('Closeeee').style.display="none";
                            document.getElementById('canceljournalentry').style.display="none";
                            openjournalEntryModal();
                            
                        }
                        function openjournalEntryModal(){
                            document.getElementById('enterjournalentry').click();
                        }
                        function changeaccount(e){
                            var value=$('#'+e+' option:selected').attr('title');
                            //var value=document.getElementById(e).value;
                            var res = value.toLowerCase();
                            var n = res.includes("sale");
                            var income_word = res.includes("income");
                            var ex = res.includes("expense");
                            //alert(res+"="+n+" "+ex);
                            if(n || income_word){
                                var r = confirm("Does it have an existing invoice?");
                                if (r == true) {
                                    document.getElementById('Closeeee').click();
                                    document.getElementById('SalesReceiptModalHiddenButton').click();
                                } else {
                                    document.getElementById('Closeeee').click();
                                    document.getElementById('invoicemodalSelect').click();
                                }
                                
                                
                            }
                            else if(ex){
                                document.getElementById('Closeeee').click();
                                //$('#Vouhcermooodall').click();
                            }
                        }
                        function setSalesReceiptinJournalEntry(e,id,type,cost_center){
                            var totalamount=0;
                           for(var c=1;c<=e;c++){
                                console.log("product name :"+document.getElementById('select_product_name_sales_receipt'+c).value);
                                console.log("product desc :"+document.getElementById('select_product_description_sales_receipt'+c).value);
                                console.log("product qty :"+document.getElementById('product_qty_sales_receipt'+c).value);
                                console.log("product rate :"+document.getElementById('select_product_rate_sales_receipt'+c).value);
                                totalamount=totalamount+(document.getElementById('product_qty_sales_receipt'+c).value*document.getElementById('select_product_rate_sales_receipt'+c).title);
                           }
                           document.getElementById('OtherNo').value=id;
                            document.getElementById('JournalEntryTransactionType').value=type;
                           document.getElementById('journaldebit1').innerHTML=totalamount;
                           document.getElementById('journalcredit2').innerHTML=totalamount;
                           document.getElementById('CostCenterJournalEntrty').value=cost_center;
                           
                            // journaldebit1
                            // journalcredit1
                            // journaldescription1
                            // journalnamename1
                           disablecanceljournalemodal();

                        }
                        function no_reload_sr(){
                            document.getElementById('reload_sr').value="1";
                        }
                        function addnewCustomerDatalist(element){
                            
                            if(element.value=="--Add Customer/Supplier--"){
                                document.getElementById('canceljournalentry').click();
                                element.value="";
                                showcustomizationsectioncustomer();
                            }
                        }
                    </script>
                    <script>
                            function showcustomizationsectioncustomer(){
                                //document.getElementById('coverdiv').style.display="inline";
                                $("#modallike2").toggle("slide",function(){
                                    $(".customizationsection2").toggle("slide");
                                });
                                
                            }
                            function hidecustomizationsectioncustomer(){
                                $(".customizationsection2").toggle("slide",function(){
                                    $("#modallike2").toggle("slide");
                                });
                            }
                            function setAccountJournalEntry(row){
                                
                                var code=document.getElementById('accjournalcode'+row).value;
                                document.getElementById('accjournbale'+row).value=code;
                                document.getElementById('setselectpickerbuttonjournal_entry').setAttribute('data-value',row);
                                document.getElementById('setselectpickerbuttonjournal_entry').click();
                                $.ajax({
                                    type: "POST",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "getcoa_cc_name",
                                    dataType:"json",
                                    data: {id:code,_token:'{{csrf_token()}}'},
                                    success: function (data) {
                                        console.log(data.name);
                                        document.getElementById('journalcost_center_td'+row).innerHTML=data.name;
                                        document.getElementById('journalcost_center_td'+row).setAttribute('data-costcenter_no',data.no);
                                    }
                                });
                                
                            }
                            function setAccountCodeJournalEntry(row){
                                var code=document.getElementById('accjournbale'+row).value;
                                document.getElementById('accjournalcode'+row).value=code;
                                document.getElementById('setselectpickerbuttonjournal_entry_code').setAttribute('data-value',row);
                                document.getElementById('setselectpickerbuttonjournal_entry_code').click();
                                $.ajax({
                                    type: "POST",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "getcoa_cc_name",
                                    dataType:"json",
                                    data: {id:code,_token:'{{csrf_token()}}'},
                                    success: function (data) {
                                        console.log(data.name);
                                        document.getElementById('journalcost_center_td'+row).innerHTML=data.name;
                                        document.getElementById('journalcost_center_td'+row).setAttribute('data-costcenter_no',data.no);
                                    }
                                });
                            }
                        </script>
                    
                    <a class="dropdown-item" href="#" style="display:none;" id="SalesReceiptModalHiddenButton" onclick="no_reload_sr()" data-toggle="modal" data-target="#salesreceiptmodal">Sales Receipt</a>
                    <a class="dropdown-item"  href="#" id="invoicemodalSelect" style="display:none;" data-toggle="modal" data-target="#invoicemodaljournal">Invoice</a>
                    <div class="table-responsive-md">

                        <script>
                            var initialheight=0;
                            var initialheight2=0;
                            var hiiiiqweqwe=40;
                            function dragging(e,element){
                                console.log($(element).attr('id'));
                                var dragX = e.pageX, dragY = e.pageY;
                                console.log(initialheight+" X: "+dragX+" Y: "+dragY+" 22222:"+initialheight2);
                                initialheight=dragY;
                                
                                if(initialheight>initialheight2){
                                    initialheight2=dragY+parseFloat(1);
                                }else{
                                    initialheight2=dragY-1;
                                }

                                if(initialheight>initialheight2){
                                    hiiiiqweqwe=hiiiiqweqwe-5;
                                }else{
                                    hiiiiqweqwe=hiiiiqweqwe+parseFloat(5); 
                                }
                                console.log(hiiiiqweqwe);
                                element.style.height=hiiiiqweqwe+"px";
                                //console.log(initialheight+" X: "+dragX+" Y: "+dragY+" height: "+element.style.height);
                                

                                

                            }
                            function setDefaultDraggfging(event){
                                if(hiiiiqweqwe<40){
                                    hiiiiqweqwe=40;
                                }
                                console.log("setted to :"+hiiiiqweqwe);
                            }
                        </script>
                        <style>
                        .draggablepencilbutton {
                            position: absolute;
                            right: 0;
                            bottom: 0;
                            cursor:s-resize;
                            color:white;
                            background-color: transparent;
                            width:50%;
                        }
                        .input-block-level {
                        /* display: inline !important;
                        width: 50% !important;
                        min-height: 28px;        
                        box-sizing: border-box; */
                        width: 100px !important;
                        }
                        tr.noBorder td {
                        border: 0;
                        }
                        </style>
                    <table class="table table-bordered text-left font14  table-sm" style="border:0;" id="journalentrytable">
                        <thead>
                        <tr style="background-color:rgb(228, 236, 247);color:#666;">
                            <th class="text-left" width="3%">#</th>
                            <th class="text-left" width="10%">CODE</th>
                            <th class="text-left" width="15%">ACCOUNT</th>
                            <th class="text-left" width="10%">COST CENTER</th>
                            <th class="text-left" width="8%">DEBIT</th>
                            <th class="text-left" width="8%">CREDIT</th>
                            <th class="text-left" width="10%">DESCRIPTION</th>
                            <th class="text-left" width="15%">PAYEE</th>
                            <th class="text-left" width="8%">CHEQUE NO</th>
                            <th class="text-left" width="5%">REFERENCE</th>
                            <th class="text-left" width="3%">DATE DEPOSITED</th>
                            <th class="text-center" width="2%"></th>
                        </tr>
                        </thead>
                        <tbody id="journalentrytablebody">
                        <tr id="journalrow1" ondrag="dragging(event,this)" ondragover="setDefaultDraggfging(event)">
                            
                            <td class="pt-3-half" contenteditable="false" style="padding:0px 0px 0px 2px;">1</td>
                            <td class="pt-3-half" contenteditable="false">
                                <select class="selectpicker form-control input-block-level" onchange="setAccountJournalEntry('1')" required data-live-search="true"  id="accjournalcode1" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : ''}} >
                                    <option value="">--Select--</option>
                                    @foreach($COA as $coa)
                                    <option value="{{$coa->id}}">{{$coa->coa_code}}</option>
                                    @endforeach
                                </select>
                                
                            </td>
                            <td class="pt-3-half" contenteditable="false">
                                <select class="selectpicker form-control"onchange="setAccountCodeJournalEntry('1')" required data-live-search="true"  id="accjournbale1" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : ''}} >
                                    <option value="">--Select--</option>
                                    @foreach($COA as $coa)
                                    <option value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>
                                    @endforeach
                                </select>
                                
                            </td>
                            <td class="pt-3-half" contenteditable="false" id="journalcost_center_td1">

                            </td>
                            <td class="pt-3-half" contenteditable="false" >
                                <input type="number" step="0.01" onkeyup="swap2('journalcredit','1')" oninput="swap2('journalcredit','1')" id="journaldebit1" >
                            </td>
                            <td class="pt-3-half" contenteditable="false" >
                                <input type="number" step="0.01" onkeyup="swap2('journaldebit','1')" oninput="swap2('journaldebit','1')" id="journalcredit1" >
                            </td>
                            <td class="pt-3-half" contenteditable="false" >
                                <textarea id="journaldescription1" style="width: 100%;border: 0px solid white;text-transform: capitalize;"></textarea>
                            </td>
                            <td class="pt-3-half" contenteditable="false" >
                                <input type="text" class="w-100" list="customer_list_all" placeholder="Supplier/Customer" onkeyup="addnewCustomerDatalist(this)" onchange="addnewCustomerDatalist(this)" id="journalnamename1" >
                            </td>
                            <td class="pt-3-half" contenteditable="false" >
                                <textarea id="journalcheque_no_td1" style="width: 100%;border: 0px solid white;"></textarea>
                            </td>
                            <td class="pt-3-half" contenteditable="false">
                                <textarea id="journalref_no_td1" style="width: 100%;border: 0px solid white;"></textarea>
                            </td>
                            <td class="pt-3-half" contenteditable="false" >
                                <input type="date" id="date_deposited1" style="height:unset">
                            </td>
                            <td class="pt-3-half text-center" contenteditable="false" style="position:relative"><div class="draggablepencilbutton" draggable="true">_________</div></td>
                        </tr>
                        <!-- This is our clonable table line -->
                        <tr id="journalrow2" ondrag="dragging(event,this)" ondragover="setDefaultDraggfging(event)">
                            <td class="pt-3-half" contenteditable="false" style="padding:0px 0px 0px 2px;">2</td>
                            <td class="pt-3-half" contenteditable="false">
                                
                                <select class="selectpicker form-control input-block-level" onchange="setAccountJournalEntry('2')" required data-live-search="true" id="accjournalcode2" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : ''}}>
                                    <option value="">--Select--</option>
                                    @foreach($COA as $coa)
                                    <option value="{{$coa->id}}" data-costcenter="{{$coa->coa_cc}}">{{$coa->coa_code}}</option>
                                    @endforeach
                                </select>    
                            </td>
                            <td class="pt-3-half" contenteditable="false">
                                
                                <select class="selectpicker form-control" onchange="setAccountCodeJournalEntry('2')" required data-live-search="true" id="accjournbale2" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : ''}}>
                                    <option value="">--Select--</option>
                                    @foreach($COA as $coa)
                                    <option value="{{$coa->id}}" data-costcenter="{{$coa->coa_cc}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>
                                    @endforeach
                                </select>    
                            </td>
                            <td class="pt-3-half" contenteditable="false" id="journalcost_center_td2">

                            </td>
                            <td class="pt-3-half" contenteditable="false" ><input type="number" step="0.01" onkeyup="swap2('journalcredit','2')" oninput="swap2('journalcredit','2')" id="journaldebit2" ></td>
                            <td class="pt-3-half" contenteditable="false" ><input type="number" step="0.01" onkeyup="swap2('journaldebit','2')" oninput="swap2('journaldebit','2')" id="journalcredit2"></td>
                            <td class="pt-3-half" contenteditable="false">
                                <textarea id="journaldescription2" style="width: 100%;border: 0px solid white;text-transform: capitalize;"></textarea>
                            </td>
                            <td class="pt-3-half" contenteditable="false" >
                                <input type="text" class="w-100" list="customer_list_all" placeholder="Supplier/Customer" onkeyup="addnewCustomerDatalist(this)" onchange="addnewCustomerDatalist(this)" id="journalnamename2" >
                                    <datalist id="customer_list_all">
                                    <option value="">--Select Name--</option>
                                    @foreach ($customers as $ccc)
                                        <option value="{{$ccc->display_name!=""? $ccc->display_name : $ccc->f_name." ".$ccc->l_name}}">{{$ccc->account_type}}</option>
                                    @endforeach
                                    <option value="--Add Customer/Supplier--">
                                    </datalist>
                            </td>
                            <td class="pt-3-half" contenteditable="false" id="">
                                <textarea id="journalcheque_no_td2" style="width: 100%;border: 0px solid white;"></textarea>
                            </td>
                            <td class="pt-3-half" contenteditable="false" >
                                <textarea id="journalref_no_td2" style="width: 100%;border: 0px solid white;"></textarea>
                            </td>
                            <td class="pt-3-half" contenteditable="true"  >
                                <input type="date" id="date_deposited2" style="height:unset;">
                            </td>
                            <td class="pt-3-half text-center" contenteditable="false" style="position:relative"><div class="draggablepencilbutton" draggable="true">_________</div></td>
                        </tr>
                        <!-- This is our clonable table line -->
                        </tbody>
                        <tfoot>
                            <tr class="noBorder">
                                <td style="vertical-align:middle;"></td>
                                <td style="vertical-align:middle;"></td>
                                <td style="vertical-align:middle;"></td>
                                <td style="vertical-align:middle;"></td>
                                <td style="vertical-align:middle;font-weight:bold;font-size:13px;" id="debit_total_hitn">0.00</td>
                                <td style="vertical-align:middle;font-weight:bold;font-size:13px;" id="credit_total_hitn">0.00</td>
                                <td style="vertical-align:middle;"></td>
                                <td style="vertical-align:middle;"></td>
                                <td style="vertical-align:middle;"></td>
                                <td style="vertical-align:middle;"></td>
                                <td style="vertical-align:middle;"></td>
                                <td style="vertical-align:middle;"></td>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                    <div class="col-md-12 p-0 mt-1" >
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button  id="journalentryaddrow" class="btn btn-outline-dark rounded mr-1 font14" onclick="AddTableRow()">Add Items</button>
                                <button  id="journalentrydeleteallrow" class="btn btn-outline-dark rounded mr-1 font14" onclick="DeleteAllRows()">Clear All Items</button>
                            </div>
                        </div>
                        
                        <script>
                            function swap2(id,type){
                                
                                document.getElementById(id+type).value="";
                                var debitJhint=0;
                                var creditJhint=0;
                                for(var c=1;c<=journalrow;c++){
                                    var td3 = document.getElementById("journaldebit"+c);
                                    var td4 = document.getElementById("journalcredit"+c);
                                    if(td3.value!=""){
                                           
                                        debitJhint=debitJhint+parseFloat(td3.value);
                                        
                                    }
                                    if(td4.value!=""){
                                           
                                        creditJhint=creditJhint+parseFloat(td4.value);
                                        
                                    }
                                }
                                document.getElementById('debit_total_hitn').innerHTML=number_format(debitJhint,2);
                                document.getElementById('credit_total_hitn').innerHTML=number_format(creditJhint,2);
                                
                            }
                            var journalrow=2;
                            function saveJournalEntry(){
                                var journalDate=document.getElementById('journalDate').value;
                                var JournalNo=document.getElementById('JournalNo').value;
                                var OtherNo=document.getElementById('OtherNo').value;
                                var JournalMemo=document.getElementById('JournalMemo').value;
                                var JournalEntryTransactionType=document.getElementById('JournalEntryTransactionType').value;
                                var CostCenter=document.getElementById('CostCenterJournalEntrty').value;
                                var journal_entry_type=document.getElementById('journal_entry_type').value;
                                if(journalDate==""){
                                    swal("Error!", "No Journal Date.", "error");
                                }
                                if(JournalNo==""){
                                    swal("Error!", "No Journal No.", "error");
                                }else{
                                    var table, tr;
                                    table = document.getElementById("journalentrytablebody");
                                    tr = table.getElementsByTagName("tr");
                                    var debitJ=0;
                                    var creditJ=0;
                                    var PayeeCheck=1;

                                    for(var c=tr.length;c>0;c--){
                                        console.log(c);
                                        var td3 = document.getElementById("journaldebit"+c);
                                        var td4 = document.getElementById("journalcredit"+c);
                                        var payee_input = document.getElementById("journalnamename"+c);
                                        if(td3.value!=""){
                                           
                                            debitJ=debitJ+parseFloat(td3.value);
                                            console.log("debit "+debitJ+"  "+td3.value);
                                        }
                                        if(td4.value!=""){
                                            
                                            creditJ=creditJ+parseFloat(td4.value);
                                            console.log("credit "+creditJ+"  "+td4.value);
                                        }
                                        if(payee_input.value==""){
                                            PayeeCheck=0;
                                        }

                                    }
									debitJ=number_format(debitJ,2);
									creditJ=number_format(creditJ,2);
                                    console.log(debitJ+"  "+creditJ);
                                    if(PayeeCheck==1){
                                        if(debitJ==creditJ){
                                            var valid_account="1";
                                            for(var c=tr.length-1;c>=0;c--){
                                                var sscsc=c+1;
                                                var accjournbale2222=document.getElementById('accjournbale'+sscsc).value;
                                                if(accjournbale2222==""){
                                                    valid_account="0";
                                                    break;
                                                }
                                            }
                                            if(valid_account=="0"){
                                                swal("Error!", "No Account Selected", "error");
                                            }else{
                                                $.ajax({
                                                    type: 'POST',
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    url: '{{ route('get_latest_journal_no') }}',                
                                                    data: {reportsettings:"",_token: '{{csrf_token()}}'},
                                                    success: function(data) {
                                                        document.getElementById('JournalNo').value=data;
                                                        JournalNo=data;
                                                        //alert(data);
                                                        //JVCVVOUCHERNO
                                                        $.ajax({
                                                            type: 'POST',
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            },
                                                            url: 'get_latest_journal_series',                
                                                            data: {journal_entry_type:journal_entry_type,_token: '{{csrf_token()}}'},
                                                            success: function(data) {
                                                                document.getElementById('JVCVVOUCHERNO').value=data;
                                                                var journal_series_no=data;
                                                                var savequestion=1;
                                                                for(var c=tr.length-1;c>=0;c--){
                                                                    var no=c;
                                                                    no++;
                                                                    td1 = tr[c].getElementsByTagName("td")[0];
                                                                    td2 = tr[c].getElementsByTagName("td")[1];
                                                                    
                                                                    td5 = document.getElementById("journaldescription"+sscsc);
                                                                    td6 = tr[c].getElementsByTagName("td")[7];
                                                                    
                                                                    var sscsc=c+1;
                                                                    td3 = document.getElementById("journaldebit"+sscsc);
                                                                    td4 = document.getElementById("journalcredit"+sscsc);
                                                                    var accjournbale=document.getElementById('accjournbale'+sscsc).value;
                                                                    var journalnamename=document.getElementById('journalnamename'+sscsc).value;
                                                                    var cheque_no="";
                                                                    if(document.getElementById("journalcheque_no_td"+sscsc)){
                                                                        var cheque_no=document.getElementById("journalcheque_no_td"+sscsc).value;
                                                                    }
                                                                    
                                                                    var ref_no=document.getElementById("journalref_no_td"+sscsc);
                                                                    var jouenaldesc=document.getElementById("journaldescription"+sscsc);
                                                                    var date_deposited=document.getElementById("date_deposited"+sscsc).value;
                                                                        $.ajax({
                                                                    type: 'POST',
                                                                    headers: {
                                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                    },
                                                                    url: '{{ route('add_journal_entry') }}',
                                                                    data: {journal_series_no:journal_series_no,date_deposited:date_deposited,cheque_no:cheque_no,ref_no:ref_no.value,journal_entry_type:journal_entry_type,CostCenter:tr[c].getElementsByTagName("td")[3].getAttribute('data-costcenter_no'),JournalEntryTransactionType:JournalEntryTransactionType,OtherNo:OtherNo,JDate:journalDate,JNo:JournalNo,JMemo:JournalMemo,no:no,account:accjournbale,debit:td3.value,credit:td4.value,description:jouenaldesc.value,name:journalnamename,_token: '{{csrf_token()}}'},
                                                                    success: function(data) {
                                                                        console.log("fata is "+data);
                                                                        if(data==1){
                                                                            //swal("Done!", "Added Journal Entry", "success");
                                                                        }
                                                                        if(data==0){
                                                                            //swal("Error!", "Duplicate Journal No.", "error");
                                                                            swal({title: "Error!", text: "Duplicate Journal No.", type: 
                                                                            "error"}).then(function(){ 
                                                                            }
                                                                            );
                                                                            savequestion=0;
                                                                            
                                                                        }
                                                                        if(data==2){
                                                                            //swal("Error!", "Fill all Field in the Journal Entry Table.", "error");
                                                                            swal({title: "Error!", text: "Fill all Field in the Journal Entry Table.", type: 
                                                                            "error"}).then(function(){ 
                                                                            }
                                                                            );
                                                                            savequestion=0;
                                                                        }
                                                                        
                                                                            
                                                                    }  

                                                                    })    
                                                                    
                                                                    
                                                                }
                                                                
                                                                if(savequestion==1){
                                                                    journal_aftermath_option(JournalNo);
                                                                }

                                                            } ,
                                                            error: function (xhr, ajaxOptions, thrownError) {
                                                                
                                                            }
                                                        })
                                                        

                                                    } ,
                                                    error: function (xhr, ajaxOptions, thrownError) {
                                                        
                                                    }
                                                })
                                            }
                                            
                                        }else{
                                            
                                            swal("Error!", "Credit and Debit not Equal", "error");
                                        }
                                    }else{
                                        
                                        swal("Error!", "Payee Field is required", "error");
                                    }
                                    
                                    

                                }
                                

                                
                            }
                            function journal_aftermath_option(journal_no){
                                var debitJhint=0;
                                var creditJhint=0;
                                for(var c=1;c<=journalrow;c++){
                                    var td3 = document.getElementById("journaldebit"+c);
                                    var td4 = document.getElementById("journalcredit"+c);
                                    if(td3.value!=""){
                                           
                                        debitJhint=debitJhint+parseFloat(td3.value);
                                        
                                    }
                                    if(td4.value!=""){
                                           
                                        creditJhint=creditJhint+parseFloat(td4.value);
                                        
                                    }
                                }
                                document.getElementById('debit_total_hitn').innerHTML=number_format(debitJhint,2);
                                document.getElementById('credit_total_hitn').innerHTML=number_format(creditJhint,2);
                                
                                console.log("swal value : "+journal_no);
                                swal("Added Journal Entry! What do you want to do next?", {
                                buttons: {
                                    print : "Print Entry",
                                    defeat: "Print Cheque",
                                    cancel: "Exit"
                                },
                                })
                                .then((value) => {
                                    switch (value) {
                                        
                                        case "defeat":
                                            {
                                                console.log('print entry');
                                                document.getElementById('addedJournalPrintChequeActionBtn').setAttribute('href','print_cheque_journal_entry?no='+journal_no);
                                                document.getElementById('addedJournalPrintChequeActionBtn').click();
                                                journal_aftermath_option(journal_no);
                                                break;
                                            }
                                        
                                    
                                        case "print":
                                            {
                                                console.log('print entry');
                                                document.getElementById('addedJournalPrintActionBtn').setAttribute('href','print_journal_entry?no='+journal_no);
                                                document.getElementById('addedJournalPrintActionBtn').click();
                                                journal_aftermath_option(journal_no);
                                                break;
                                            }
                                        
                                    
                                        default:
                                            {
                                                $('#Closeeee').click();
                                                location.reload();
                                            }
                                        
                                    } 
                                });
                                
                            }
                            function AddTableRow(){
                                
                                $("#journalentrytable").dataTable().fnDestroy();
                                var debitJhint=0;
                                var creditJhint=0;
                                for(var c=1;c<=journalrow;c++){
                                    var td3 = document.getElementById("journaldebit"+c);
                                    var td4 = document.getElementById("journalcredit"+c);
                                    if(td3.value!=""){
                                           
                                        debitJhint=debitJhint+parseFloat(td3.value);
                                        
                                    }
                                    if(td4.value!=""){
                                           
                                        creditJhint=creditJhint+parseFloat(td4.value);
                                        
                                    }
                                }
                                document.getElementById('debit_total_hitn').innerHTML=number_format(debitJhint,2);
                                document.getElementById('credit_total_hitn').innerHTML=number_format(creditJhint,2);
                                
                                    
                                journalrow++;
                                var t = document.getElementById('journalentrytablebody');
								var tr = document.createElement("tr");
                                tr.setAttribute("id", "journalrow"+journalrow);
                                tr.setAttribute("ondrag", "dragging(event,this)");
                                tr.setAttribute("ondragover", "setDefaultDraggfging(event)");
                                
                                var td1 = document.createElement("td"); 
								var td2 = document.createElement("td"); 
								var td3 = document.createElement("td"); 
								var td4 = document.createElement("td");
                                var td5 = document.createElement("td"); 
								var td6 = document.createElement("td"); 
                                var td7 = document.createElement("td");
                                var td8 = document.createElement("td");
                                var td9 = document.createElement("td");
                                var td10 = document.createElement("td");
                                var td11 = document.createElement("td");
                                var td12 = document.createElement("td");

                                var x1=document.createTextNode(journalrow);
                                td1.appendChild(x1);
                                td1.setAttribute("style", "padding:0px 0px 0px 2px");
                                td2.setAttribute("contenteditable", "false");
                                td2.setAttribute("class", "pt-3-half");
                                td3.setAttribute("contenteditable", "false");
                                td3.setAttribute("class", "pt-3-half");
                                var x3 = document.createElement("input");
                                x3.setAttribute("type", "number");
                                x3.setAttribute("id", "journaldebit"+journalrow);
                                x3.setAttribute("step", "0.01");
                                x3.setAttribute("onkeyup", "swap2('journalcredit',"+journalrow+")");
                                x3.setAttribute("oninput", "swap2('journalcredit',"+journalrow+")");
                                td3.appendChild(x3);
                                
                                td4.setAttribute("contenteditable", "false");
                                td4.setAttribute("class", "pt-3-half");
                                var x4 = document.createElement("input");
                                x4.setAttribute("type", "number");
                                x4.setAttribute("id", "journalcredit"+journalrow);
                                x4.setAttribute("step", "0.01");
                                x4.setAttribute("onkeyup", "swap2('journaldebit',"+journalrow+")");
                                x4.setAttribute("oninput", "swap2('journaldebit',"+journalrow+")");
                                td4.appendChild(x4);
                                td5.setAttribute("contenteditable", "false");
                                td5.setAttribute("class", "pt-3-half");
                                td5.setAttribute("style", "text-transform: capitalize;");
                                
                                //td5.setAttribute("id", "journaldescription"+journalrow);
                                var textdescription = document.createElement("textarea");
                                textdescription.setAttribute("style", "width: 100%;border: 0px solid white;text-transform: capitalize;");
                                textdescription.setAttribute("id","journaldescription"+journalrow);
                                td5.appendChild(textdescription);
                                td6.setAttribute("contenteditable", "false");
                                td6.setAttribute("class", "pt-3-half");
                                
                                td7.setAttribute("class", "pt-3-half text-center");
                                td7.setAttribute("style", "position:relative");

                                td8.setAttribute("contenteditable", "false");
                                td8.setAttribute("class", "pt-3-half");

                                td9.setAttribute("contenteditable", "false");
                                td9.setAttribute("class", "pt-3-half");
                                td9.setAttribute("id", "journalcost_center_td"+journalrow);
                                
                                td10.setAttribute("contenteditable", "false");
                                td10.setAttribute("class", "pt-3-half");
                                td10.setAttribute("id", "journalcheque_no_td"+journalrow);

                                var textdescription = document.createElement("textarea");
                                textdescription.setAttribute("style", "width: 100%;border: 0px solid white;");
                                textdescription.setAttribute("id","journalcheque_no_td"+journalrow);
                                td10.appendChild(textdescription);

                                td11.setAttribute("contenteditable", "false");
                                td11.setAttribute("class", "pt-3-half");
                                td11.setAttribute("id", "journalref_no_td"+journalrow);

                                var textdescription = document.createElement("textarea");
                                textdescription.setAttribute("style", "width: 100%;border: 0px solid white;");
                                textdescription.setAttribute("id","journalref_no_td"+journalrow);
                                td11.appendChild(textdescription);

                                td12.setAttribute("contenteditable", "false");
                                td12.setAttribute("class", "pt-3-half");

                                var deposited_input = document.createElement("input");

                                deposited_input.setAttribute('type','date');
                                deposited_input.setAttribute('style','height:unset');
                                deposited_input.setAttribute('id','date_deposited'+journalrow);

                                td12.appendChild(deposited_input);


                                var x7 = document.createElement("a");

                                x7.setAttribute("class", "fa fa-trash");
                                x7.setAttribute("href", "#");
								x7.setAttribute("id", "DeleteJournalRow"+journalrow);
								x7.setAttribute("onclick", "DeleteJournalRow("+journalrow+")");
								
                                td7.appendChild(x7);

                                var x72 = document.createElement("div");

                                x72.setAttribute("class", "draggablepencilbutton");
                                x72.setAttribute("draggable", "true");
                                var x71=document.createTextNode("_________");
								x72.appendChild(x71);
                                td7.appendChild(x72);
                                
                                var input = document.createElement("select");
                                input.setAttribute("class", "selectpicker form-control");
                                input.setAttribute("data-live-search", "true");
                                input.setAttribute("required", "true");
                                
                                input.setAttribute("id", "accjournbale"+journalrow);
                                input.setAttribute("onchange", "setAccountCodeJournalEntry("+journalrow+")");
                               
                                var option = document.createElement("option");
                                option.value = "";
                                option.text = "--Select--";
                                input.appendChild(option);
                                @foreach($COA as $coa)
                                var option = document.createElement("option");
                                option.value = "{{$coa->id}}";
                                option.text = "{!! preg_replace( "/\r|\n/", "", $coa->coa_name ) !!}";
                                option.setAttribute('data-costcenter','{{$coa->coa_cc}}')
                                input.appendChild(option);
                                
                                @endforeach

                                var input2 = document.createElement("select");
                                input2.setAttribute("class", "selectpicker input-block-level form-control");
                                input2.setAttribute("data-live-search", "true");
                                input2.setAttribute("required", "true");
                                input2.setAttribute("id", "accjournalcode"+journalrow);
                                input2.setAttribute("onchange", "setAccountJournalEntry("+journalrow+")");
                                var option = document.createElement("option");
                                option.value = "";
                                option.text = "--Select--";
                                input2.appendChild(option);
                                @foreach($COA as $coa)
                                var option = document.createElement("option");
                                option.value = "{{$coa->id}}";
                                option.text = "{!! $coa->coa_code !!}";
                                
                                option.setAttribute('data-costcenter','{{$coa->coa_cc}}')
                                input2.appendChild(option);
                                @endforeach
                                //onchange="setAccountJournalEntry('1')"
                                var input12 = document.createElement("input");
                                input12.setAttribute("id", "journalnamename"+journalrow);
                                input12.setAttribute("list", "customer_list_all");
                                //input12.setAttribute("required", "true");
                                input12.setAttribute("class", "w-100");
                                input12.setAttribute("type", "text");
                                input12.setAttribute("placeholder", "Supplier/Customer");
                                input12.setAttribute("onkeyup", "addnewCustomerDatalist(this)");
                                input12.setAttribute("onchange", "addnewCustomerDatalist(this)");
                                td6.appendChild(input12);
                                td2.appendChild(input);
                                td8.appendChild(input2);
                                var table = document.getElementById("journalentrytable");
                                var txt = "";
                                var i;
                                for (i = 0; i < table.rows[0].cells.length; i++) {
                                    txt = txt + table.rows[0].cells[i].innerHTML + "<br>";
                                    if(table.rows[0].cells[i].innerHTML=="#"){
                                        tr.appendChild(td1);
                                    }
                                    if(table.rows[0].cells[i].innerHTML=="CODE"){
                                        tr.appendChild(td8);
                                    }
                                    if(table.rows[0].cells[i].innerHTML=="ACCOUNT"){
                                        tr.appendChild(td2);
                                    }
                                    if(table.rows[0].cells[i].innerHTML=="COST CENTER"){
                                        tr.appendChild(td9);
                                    }
                                    if(table.rows[0].cells[i].innerHTML=="DEBIT"){
                                        tr.appendChild(td3);
                                    }
                                    if(table.rows[0].cells[i].innerHTML=="CREDIT"){
                                        tr.appendChild(td4);
                                    }
                                    if(table.rows[0].cells[i].innerHTML=="DESCRIPTION"){
                                        tr.appendChild(td5);
                                    }
                                    if(table.rows[0].cells[i].innerHTML=="PAYEE"){
                                        tr.appendChild(td6);
                                    }
                                    if(table.rows[0].cells[i].innerHTML=="CHEQUE NO"){
                                        tr.appendChild(td10);
                                    }
                                    if(table.rows[0].cells[i].innerHTML=="REFERENCE"){
                                        tr.appendChild(td11);
                                    }
                                    if(table.rows[0].cells[i].innerHTML=="DATE DEPOSITED"){
                                        tr.appendChild(td12);
                                    }
                                    if(table.rows[0].cells[i].innerHTML==""){
                                        tr.appendChild(td7);
                                    }
                                }
                                t.appendChild(tr);
                                if(debitJhint!=creditJhint){
                                    if(debitJhint!=0){
                                        if(debitJhint>creditJhint){
                                            var difference_credit=debitJhint-creditJhint;
                                            document.getElementById("journalcredit"+journalrow).value=difference_credit;
                                            
                                        }
                                    }
                                }
                                if(creditJhint!=debitJhint){
                                    if(creditJhint!=0){
                                        if(creditJhint>debitJhint){
                                            var difference_credit=creditJhint-debitJhint;
                                            document.getElementById("journaldebit"+journalrow).value=difference_credit;
                                            
                                        }
                                    }
                                }

                                var debitJhint=0;
                                var creditJhint=0;
                                for(var c=1;c<=journalrow;c++){
                                    var td3 = document.getElementById("journaldebit"+c);
                                    var td4 = document.getElementById("journalcredit"+c);
                                    if(td3.value!=""){
                                        
                                        debitJhint=debitJhint+parseFloat(td3.value);
                                        
                                    }
                                    if(td4.value!=""){
                                        
                                        creditJhint=creditJhint+parseFloat(td4.value);
                                        
                                    }
                                }
                                document.getElementById('debit_total_hitn').innerHTML=number_format(debitJhint,2);
                                document.getElementById('credit_total_hitn').innerHTML=number_format(creditJhint,2);
                                //jQuery('.selectpicker ').selectpicker();
                                //$("#accjournbale"+journalrow).chosen();
                                var deduc=journalrow-1;
								if(document.getElementById('DeleteJournalRow'+deduc)){
                                    document.getElementById('DeleteJournalRow'+deduc).style.display="none";
                                }
								document.getElementById('setselectpickerbutton').click();
                                var journal_entry_type=document.getElementById('journal_entry_type').value;
                                var journalentrytable=$("#journalentrytable").DataTable({
                                    paging: false,
                                    "ordering": true,
                                    'dom': 'Rlfrtip',
                                    "autoWidth": false,
                                    rowReorder: true
                                });
                                
                                
                                
                                if(document.getElementById('journalentrytable_info')){
                                    document.getElementById('journalentrytable_info').style.display="none";
                                    document.getElementById('journalentrytable_filter').style.display="none";
                                    // Get the column API object
                                    var column = journalentrytable.column( 8 );
                            
                                    if(journal_entry_type=="Cheque Voucher"){
                                        // Toggle the visibility
                                        column.visible( true );
                                    }else{
                                        column.visible( false );
                                    }
                                    journalentrytable.on( 'row-reorder', function ( e, diff, edit ) {
                                    //console.log("asdasdasd->>>> "+edit.triggerRow.data());
                                    var result = 'Reorder started on row: '+(edit.triggerRow.data())+'<br>';
                                    
                                    for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                                        var rowData = journalentrytable.row( diff[i].node ).data();
                                        result += rowData;
                                        console.log(rowData[113]);
                                        //result += rowData[1]+' updated to be in position '+
                                        //    diff[i].newData+' (was '+diff[i].oldData+')<br>';
                                    }
                                    });
                                }
                            }
                            function DeleteJournalRow(rownum){
                                $("#journalentrytable").dataTable().fnDestroy();
                                var t = document.getElementById('journalentrytablebody');
								var tr = document.getElementById("journalrow"+rownum);
								    t.removeChild(tr);
                                    journalrow--;
                                    document.getElementById('DeleteJournalRow'+journalrow).style.display="inline";
                                    var debitJhint=0;
                                    var creditJhint=0;
                                    for(var c=1;c<=journalrow;c++){
                                        var td3 = document.getElementById("journaldebit"+c);
                                        var td4 = document.getElementById("journalcredit"+c);
                                        if(td3.value!=""){
                                            
                                            debitJhint=debitJhint+parseFloat(td3.value);
                                            
                                        }
                                        if(td4.value!=""){
                                            
                                            creditJhint=creditJhint+parseFloat(td4.value);
                                            
                                        }
                                    }
                                    document.getElementById('debit_total_hitn').innerHTML=number_format(debitJhint,2);
                                    document.getElementById('credit_total_hitn').innerHTML=number_format(creditJhint,2);
                                    var journal_entry_type=document.getElementById('journal_entry_type').value;
                                    journalentrytable=$("#journalentrytable").DataTable({
                                        paging: false,
                                        "ordering": true,
                                        'dom': 'Rlfrtip',
                                        "autoWidth": false,
                                        rowReorder: true
                                    });
                                    // Get the column API object
                                    var column = journalentrytable.column( 8 );
                            
                                    if(journal_entry_type=="Cheque Voucher"){
                                        // Toggle the visibility
                                        column.visible( true );
                                    }else{
                                        column.visible( false );
                                    }
                                    if(document.getElementById('journalentrytable_info')){
                                        document.getElementById('journalentrytable_info').style.display="none";
                                        document.getElementById('journalentrytable_filter').style.display="none";
                                        journalentrytable.on( 'row-reorder', function ( e, diff, edit ) {
                                        //console.log("asdasdasd->>>> "+edit.triggerRow.data());
                                        var result = 'Reorder started on row: '+(edit.triggerRow.data())+'<br>';
                                        
                                        for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                                            var rowData = journalentrytable.row( diff[i].node ).data();
                                            result += rowData;
                                            console.log(rowData[113]);
                                            //result += rowData[1]+' updated to be in position '+
                                            //    diff[i].newData+' (was '+diff[i].oldData+')<br>';
                                        }
                                        });
                                    }
                            }
                            function DeleteAllRows(){
                                $("#journalentrytable").dataTable().fnDestroy();
                                var t = document.getElementById('journalentrytablebody');
                                if(journalrow>2){
                                    for(var c=journalrow;c>2;c--){
                                        var tr = document.getElementById("journalrow"+c);
                                        t.removeChild(tr);
                                    }
                                    journalrow=2;
                                }
                                var journal_entry_type=document.getElementById('journal_entry_type').value;
                                journalentrytable=$("#journalentrytable").DataTable({
                                    paging: false,
                                    "ordering": true,
                                    'dom': 'Rlfrtip',
                                    "autoWidth": false,
                                    rowReorder: true
                                });
                                // Get the column API object
                                var column = journalentrytable.column( 8 );
                        
                                if(journal_entry_type=="Cheque Voucher"){
                                    // Toggle the visibility
                                    column.visible( true );
                                }else{
                                    column.visible( false );
                                }
                                if(document.getElementById('journalentrytable_info')){
                                    document.getElementById('journalentrytable_info').style.display="none";
                                    document.getElementById('journalentrytable_filter').style.display="none"
                                    journalentrytable.on( 'row-reorder', function ( e, diff, edit ) {
                                    //console.log("asdasdasd->>>> "+edit.triggerRow.data());
                                    var result = 'Reorder started on row: '+(edit.triggerRow.data())+'<br>';
                                    
                                    for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                                        var rowData = journalentrytable.row( diff[i].node ).data();
                                        result += rowData;
                                        console.log(rowData[113]);
                                        //result += rowData[1]+' updated to be in position '+
                                        //    diff[i].newData+' (was '+diff[i].oldData+')<br>';
                                    }
                                    });
                                }
                            }
                        </script>
                    </div>
                    <div class="col-md-12 p-0 mt-4">
                        {{-- <div id="grid_array2" ></div> --}}
                        
                        <div class="col-md-6 pl-0">
                            <p>Memo</p>
                            <textarea rows="3" class="w-100" id="JournalMemo" ></textarea>
                        </div>
                        <div class="col-md-6 m-0 pr-0" style="display:none">
                            <div class="d-inline-flex">
                                <p class="fa fa-paperclip"></p>
                                <p class="p-0 ml-1">Maximum Size: 20MB</p>
                            </div>
                            <div class="input-group mb-3 p-0" >
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" style="display:none;" id="setselectpickerbutton">
                <button type="button" style="display:none;" id="setselectpickerbuttonjournal_entry">
                <button type="button" style="display:none;" id="setselectpickerbuttonjournal_entry_code">
                <button type="button" style="display:none;" id="setselectpickerinvoicedebitcode">
                <button type="button" style="display:none;" id="setselectpickerinvoicedebitcodecode">
                <button type="button" style="display:none;" id="setselectpickerinvoicecredtitcode">
                <button type="button" style="display:none;" id="setselectpickerinvoicecredtitcodecode">
                <button type="button" id="canceljournalentry" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success rounded"  id="JournalEntrySaveButton" onclick="saveJournalEntry()">Save</button>
            </div>
        </div>
    </div>
</div>

<!--Edit Journal Modal-->
<script>
function edit_journal_entries(je_no){
    var txt;
    var r = confirm("Are you sure you want to change this?\nAny Changes here will be subject for Approval");
    if (r == true) {
        document.getElementById('import_overlay').style.display="block";
        document.getElementById('JournalNoEdit').value=je_no;
        $.ajax({
            type: 'POST',
            url: 'getJournalEntryInfo',                
            data: {_token: '{{csrf_token()}}',je_no:je_no},
            success: function(data) {
                if (data === undefined || data.length == 0) {
                    // array empty or does not exist
                    document.getElementById('import_overlay').style.display="none";
                }else{
                    
                    for(var c=0;c<data.length;c++){
                        console.log(c);
                        document.getElementById('OtherNoEdit').value=data[c]['other_no'];
                        document.getElementById('CostCenterJournalEntrtyEdit').value=data[c]['je_cost_center'];
                        document.getElementById('JournalMemoedit').value=data[c]['je_memo'];
                        document.getElementById('journalDateEdit').value=data[c]['je_attachment'];
                        if(c==0){
                            document.getElementById('editaccjournbale1').value=data[c]['je_account'];
                            document.getElementById('editjournaldebit1').value=data[c]['je_debit'];
                            document.getElementById('editjournalcredit1').value=data[c]['je_credit'];
                            document.getElementById('editjournaldescription1').innerHTML=data[c]['je_desc'];
                            document.getElementById('editjournalnamename1').value=data[c]['je_name'];
                        }
                        if(c==1){
                            document.getElementById('editaccjournbale2').value=data[c]['je_account'];
                            document.getElementById('editjournaldebit2').value=data[c]['je_debit'];
                            document.getElementById('editjournalcredit2').value=data[c]['je_credit'];
                            document.getElementById('editjournaldescription2').innerHTML=data[c]['je_desc'];
                            document.getElementById('editjournalnamename2').value=data[c]['je_name'];
                        }
                        if(c>1){
                            editAddTableRow();
                            var added=c+1;
                            console.log('editaccjournbale'+added);
                            document.getElementById('editaccjournbale'+added).value=data[c]['je_account'];
                            document.getElementById('editjournaldebit'+added).value=data[c]['je_debit'];
                            document.getElementById('editjournalcredit'+added).value=data[c]['je_credit'];
                            document.getElementById('editjournaldescription'+added).innerHTML=data[c]['je_desc'];
                            document.getElementById('editjournalnamename'+added).value=data[c]['je_name']; 
                        }
                    }
                    document.getElementById('setselectpickerbutton').click();
                    document.getElementById('import_overlay').style.display="none";
                }
                
            } 											 
        });
        
        open_modal_dyna('journalentrymodaledit');
    }
    
}
</script>
<div class="modal fade p-0" id="journalentrymodaledit" tabindex="-1" role="dialog" aria-hidden="true" style="">
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Journal Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="col-md-12 p-0 mb-4">
                        <div class="col-md-2 p-0">
                            <p>Journal Date</p>
                        <input type="date" name="" id="journalDateEdit">
                        </div>
                        <div class="col-md-2 p-0">
                            <p>Journal No.</p>
                            
                        <input type="number" name="" readonly id="JournalNoEdit" placeholder="1" value="">
                        <input type="text" style="display:none;" name="OtherNo" readonly id="OtherNoEdit" placeholder="1" value="">
                        <input type="text" style="display:none;" name="goSalesReceipt" readonly id="goSalesReceiptEdit" placeholder="1" value="0">
                        <input type="text" style="display:none;" name="JournalEntryTransactionTypeEdit" readonly id="JournalEntryTransactionTypeEdit" value="Journal Entry">

                        </div>
                        <div class="col-md-2 p-0" style="{{!empty($numbering) && $numbering->use_cost_center=="Off"? 'display:none;' : ''}}">
                            <p>Cost Center</p>
                            <select name="" class="form-control selectpicker" data-live-search="true" id="CostCenterJournalEntrtyEdit">
                                <option value="">--Select Cost Center--</option>
                                {!! $cc_list_after_foreach !!}
                            </select>
                        </div>
                    </div>
                    
                    
                    
                    <table class="table table-bordered table-responsive-md table-striped text-left font14" id="journalentrytable">
                        <tr style="background-color:white;">
                            <th class="text-left">#</th>
                            <th class="text-left" style="max-width:20%">ACCOUNT</th>
                            <th class="text-left" width="15%">DEBITS</th>
                            <th class="text-left" width="15%">CREDITS</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-left">NAME</th>
                            <th class="text-center"></th>
                        </tr>
                        <tbody id="editjournalentrytablebody">
                        <tr id="editjournalrow1">
                            <td class="pt-3-half" contenteditable="false">1</td>
                            <td class="pt-3-half" contenteditable="false">
                                <select class="form-control selectpicker" data-live-search="true"  id="editaccjournbale1" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : ''}} >
                                    <option value="">--Select Account--</option>
                                    @foreach($COA as $coa)
                                    <option value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="pt-3-half" contenteditable="false" ><input type="number" step="0.01" onkeyup="swap2('editjournalcredit','1')" oninput="swap2('editjournalcredit','1')" id="editjournaldebit1" ></td>
                            <td class="pt-3-half" contenteditable="false" ><input type="number" step="0.01" onkeyup="swap2('editjournaldebit','1')" oninput="swap2('editjournaldebit','1')" id="editjournalcredit1" ></td>
                            <td class="pt-3-half" contenteditable="true" id="editjournaldescription1" style="text-transform: capitalize;"></td>
                            <td class="pt-3-half" contenteditable="false" >
                                <input type="text" list="customer_list_all" placeholder="Supplier/Customer" onkeyup="addnewCustomerDatalist(this)" onchange="addnewCustomerDatalist(this)" id="editjournalnamename1" >
                                
                            </td>
                            <td class="pt-3-half text-center" contenteditable="false"></td>
                        </tr>
                        <!-- This is our clonable table line -->
                        <tr id="editjournalrow2">
                            <td class="pt-3-half" contenteditable="false">2</td>
                            <td class="pt-3-half" contenteditable="false">
                                
                                <select class="form-control selectpicker" data-live-search="true" id="editaccjournbale2" {{!empty($numbering) && $numbering->use_cost_center=="Off"? '' : ''}}>
                                    <option value="">--Select Account--</option>
                                    @foreach($COA as $coa)
                                    <option value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>
                                    @endforeach
                                </select>    
                            </td>
                            <td class="pt-3-half" contenteditable="false" ><input type="number" step="0.01" onkeyup="swap2('editjournalcredit','2')" oninput="swap2('editjournalcredit','2')" id="editjournaldebit2" ></td>
                            <td class="pt-3-half" contenteditable="false" ><input type="number" step="0.01" onkeyup="swap2('editjournaldebit','2')" oninput="swap2('editjournaldebit','2')" id="editjournalcredit2"></td>
                            <td class="pt-3-half" contenteditable="true" id="editjournaldescription2" style="text-transform: capitalize;"></td>
                            <td class="pt-3-half" contenteditable="false" >
                                    <input type="text" list="customer_list_all" placeholder="Supplier/Customer" onkeyup="addnewCustomerDatalist(this)" onchange="addnewCustomerDatalist(this)" id="editjournalnamename2" >
                                        
                                </td>
                            <td class="pt-3-half text-center" contenteditable="false"></td>
                        </tr>
                        <!-- This is our clonable table line -->
                        </tbody>
                    </table>
                    
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button id="journalentryaddrowedit" class="btn btn-outline-dark rounded mr-1 font14" onclick="editAddTableRow()">Add Items</button>
                                <button  id="journalentrydeleteallrowedit" class="btn btn-outline-dark rounded mr-1 font14" onclick="editDeleteAllRows()">Clear All Items</button>
                            </div>
                        </div>
                        <div class="float-right">
                            <div class="d-inline-flex">
                                <table class="table" style="font-size:13px;">
                                    <tr>
                                        <th style="vertical-align:middle;">Total Debit</th>
                                        <td style="vertical-align:middle;" id="editdebit_total_hitn">0.00</td>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align:middle;">Total Credit</th>
                                        <td style="vertical-align:middle;" id="editcredit_total_hitn">0.00</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <script>
                            
                            var editjournalrow=2;
                            function saveJournalEntryedit(){
                                var journalDate=document.getElementById('journalDateEdit').value;
                                var JournalNo=document.getElementById('JournalNoEdit').value;
                                var OtherNo=document.getElementById('OtherNoEdit').value;
                                var JournalMemo=document.getElementById('JournalMemoedit').value;
                                var JournalEntryTransactionType=document.getElementById('JournalEntryTransactionTypeEdit').value;
                                var CostCenter=document.getElementById('CostCenterJournalEntrtyEdit').value;
                                
                                if(journalDate==""){
                                    swal("Error!", "No Journal Date.", "error");
                                }
                                if(JournalNo==""){
                                    swal("Error!", "No Journal No.", "error");
                                }else{
                                    var table, tr;
                                    table = document.getElementById("editjournalentrytablebody");
                                    tr = table.getElementsByTagName("tr");
                                    var debitJ=0;
                                    var creditJ=0;

                                    for(var c=tr.length;c>0;c--){
                                        //console.log(c);
                                        td3 = document.getElementById("editjournaldebit"+c);
                                        td4 = document.getElementById("editjournalcredit"+c);
                                        if(td3.value!=""){
                                           
                                            debitJ=debitJ+parseFloat(td3.value);
                                            //console.log("debit "+debitJ+"  "+td3.value);
                                        }
                                        if(td4.value!=""){
                                            
                                            creditJ=creditJ+parseFloat(td4.value);
                                            //console.log("credit "+creditJ+"  "+td4.value);
                                        }

                                    }
                                    //console.log(debitJ+"  "+creditJ);

                                    if(debitJ==creditJ){
                                        $.ajax({
                                        type: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        url: '{{ route('delete_overwrite_journal_entry') }}',                
                                        data: {je_no:JournalNo,_token: '{{csrf_token()}}'},
                                        success: function(data) {
                                            for(var c=tr.length-1;c>=0;c--){
                                                td1 = tr[c].getElementsByTagName("td")[0];
                                                td2 = tr[c].getElementsByTagName("td")[1];
                                                
                                                td5 = tr[c].getElementsByTagName("td")[4];
                                                td6 = tr[c].getElementsByTagName("td")[5];
                                                console.log("C= "+c);
                                                var sscsc=c+1;
                                                td3 = document.getElementById("editjournaldebit"+sscsc);
                                                td4 = document.getElementById("editjournalcredit"+sscsc);
                                                var accjournbale=document.getElementById('editaccjournbale'+sscsc).value;
                                                var journalnamename=document.getElementById('editjournalnamename'+sscsc).value;
                                                
                                                console.log(td3.value+" "+td4.value);
                                                
                                                    $.ajax({
                                                    type: 'POST',
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    url: '{{ route('update_journal_entry') }}',                
                                                    data: {CostCenter:CostCenter,JournalEntryTransactionType:JournalEntryTransactionType,OtherNo:OtherNo,JDate:journalDate,JNo:JournalNo,JMemo:JournalMemo,no:td1.innerHTML,account:accjournbale,debit:td3.value,credit:td4.value,description:td5.innerHTML,name:journalnamename,_token: '{{csrf_token()}}'},
                                                    success: function(data) {
                                                        console.log("fata is "+data);
                                                        if(data==1){
                                                            //swal("Done!", "Added Journal Entry", "success");

                                                                swal({title: "Done!", text: "Updated Journal Entry", type: 
                                                                    "success"}).then(function(){
                                                                        location.reload();
                                                                        
                                                                    }
                                                                    );
                                                        }
                                                        if(data==0){
                                                            //swal("Error!", "Duplicate Journal No.", "error");
                                                            swal({title: "Error!", text: "Duplicate Journal No.", type: 
                                                                    "error"}).then(function(){ 
                                                                
                                                                    }
                                                                    );
                                                            
                                                        }
                                                        if(data==2){
                                                            //swal("Error!", "Fill all Field in the Journal Entry Table.", "error");
                                                            swal({title: "Error!", text: "Fill all Field in the Journal Entry Table.", type: 
                                                                    "error"}).then(function(){ 
                                                                    
                                                                    }
                                                                    );
                                                        }
                                                        
                                                            
                                                    }  

                                                    })    
                                                    
                                                    
                                                }
                                        }  

                                        })
                                        
                                    }else{
                                        alert("Credit and Debit not Equal");
                                    }
                                    

                                }
                                

                                
                            }
                            
                            function editAddTableRow(){
                                var debitJhint=0;
                                var creditJhint=0;
                                for(var c=1;c<=editjournalrow;c++){
                                    var td3 = document.getElementById("editjournaldebit"+c);
                                    var td4 = document.getElementById("editjournalcredit"+c);
                                    if(td3.value!=""){
                                           
                                        debitJhint=debitJhint+parseFloat(td3.value);
                                        
                                    }
                                    if(td4.value!=""){
                                           
                                        creditJhint=creditJhint+parseFloat(td4.value);
                                        
                                    }
                                }
                                document.getElementById('editdebit_total_hitn').innerHTML=number_format(debitJhint,2);
                                document.getElementById('editcredit_total_hitn').innerHTML=number_format(creditJhint,2);
                                
                                    
                                editjournalrow++;
                                var t = document.getElementById('editjournalentrytablebody');
								var tr = document.createElement("tr");
                                tr.setAttribute("id", "editjournalrow"+editjournalrow);
                                var td1 = document.createElement("td"); 
								var td2 = document.createElement("td"); 
								var td3 = document.createElement("td"); 
								var td4 = document.createElement("td");
                                var td5 = document.createElement("td"); 
								var td6 = document.createElement("td"); 
                                var td7 = document.createElement("td");

                                var x1=document.createTextNode(editjournalrow);
                                td1.appendChild(x1);
                                td2.setAttribute("contenteditable", "false");
                                td2.setAttribute("class", "pt-3-half");
                                td3.setAttribute("contenteditable", "false");
                                td3.setAttribute("class", "pt-3-half");
                                var x3 = document.createElement("input");
                                x3.setAttribute("type", "number");
                                x3.setAttribute("id", "editjournaldebit"+editjournalrow);
                                x3.setAttribute("step", "0.01");
                                x3.setAttribute("onkeyup", "swap2('editjournalcredit',"+editjournalrow+")");
                                x3.setAttribute("oninput", "swap2('editjournalcredit',"+editjournalrow+")");
                                td3.appendChild(x3);
                                
                                td4.setAttribute("contenteditable", "false");
                                td4.setAttribute("class", "pt-3-half");
                                var x4 = document.createElement("input");
                                x4.setAttribute("type", "number");
                                x4.setAttribute("id", "editjournalcredit"+editjournalrow);
                                x4.setAttribute("step", "0.01");
                                x4.setAttribute("onkeyup", "swap2('editjournaldebit',"+editjournalrow+")");
                                x4.setAttribute("oninput", "swap2('editjournaldebit',"+editjournalrow+")");
                                td4.appendChild(x4);
                                td5.setAttribute("contenteditable", "true");
                                td5.setAttribute("class", "pt-3-half");
                                td5.setAttribute("style", "text-transform: capitalize;");
                                
                                td5.setAttribute("id", "editjournaldescription"+editjournalrow);
                                td6.setAttribute("contenteditable", "true");
                                td6.setAttribute("class", "pt-3-half");
                                
                                
                                td7.setAttribute("class", "pt-3-half text-center");
                                var x7 = document.createElement("a");

                                x7.setAttribute("class", "fa fa-trash");
                                x7.setAttribute("href", "#");
								x7.setAttribute("id", "editDeleteJournalRow"+editjournalrow);
								x7.setAttribute("onclick", "editDeleteJournalRow("+editjournalrow+")");
								
                                td7.appendChild(x7);
                                
                                var input = document.createElement("select");
                                input.setAttribute("class", "form-control selectpicker");
                                input.setAttribute("data-live-search", "true");
                                
                                input.setAttribute("id", "editaccjournbale"+editjournalrow);
                                
                                var option = document.createElement("option");
                                option.value = "";
                                option.text = "--Select Account--";
                                input.appendChild(option);
                                @foreach($COA as $coa)
                                var option = document.createElement("option");
                                option.value = "{{$coa->id}}";
                                option.text = "{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}";
                                input.appendChild(option);
                                
                                @endforeach


                                var input12 = document.createElement("input");
                                input12.setAttribute("id", "editjournalnamename"+editjournalrow);
                                input12.setAttribute("list", "customer_list_all");
                                input12.setAttribute("type", "text");
                                input12.setAttribute("placeholder", "Supplier/Customer");
                                input12.setAttribute("onkeyup", "addnewCustomerDatalist(this)");
                                input12.setAttribute("onchange", "addnewCustomerDatalist(this)");
                                td6.appendChild(input12);
                                td2.appendChild(input);
                                tr.appendChild(td1);
                                tr.appendChild(td2);
                                tr.appendChild(td3);
                                tr.appendChild(td4);
                                tr.appendChild(td5);
                                tr.appendChild(td6);
                                tr.appendChild(td7);
                                t.appendChild(tr);
                                if(debitJhint!=creditJhint){
                                    if(debitJhint!=0){
                                        if(debitJhint>creditJhint){
                                            var difference_credit=debitJhint-creditJhint;
                                            document.getElementById("editjournalcredit"+editjournalrow).value=difference_credit;
                                        }
                                    }
                                }
                                //jQuery('.selectpicker ').selectpicker();
                                //$("#accjournbale"+journalrow).chosen();
                                var deduc=editjournalrow-1;
								if(document.getElementById('editDeleteJournalRow'+deduc)){
                                    document.getElementById('editDeleteJournalRow'+deduc).style.display="none";
                                }					
								
                                document.getElementById('setselectpickerbutton').click();
                            }
                            function editDeleteJournalRow(rownum){
                                var t = document.getElementById('editjournalentrytablebody');
								var tr = document.getElementById("editjournalrow"+rownum);
								    t.removeChild(tr);
                                    editjournalrow--;
                                    console.log('editDeleteJournalRow'+editjournalrow);
                                    if(document.getElementById('editDeleteJournalRow'+editjournalrow)){
                                        document.getElementById('editDeleteJournalRow'+editjournalrow).style.display="inline";
                                    }
                                   
                                    var debitJhint=0;
                                    var creditJhint=0;
                                    for(var c=1;c<=editjournalrow;c++){
                                        var td3 = document.getElementById("editjournaldebit"+c);
                                        var td4 = document.getElementById("editjournalcredit"+c);
                                        if(td3.value!=""){
                                            
                                            debitJhint=debitJhint+parseFloat(td3.value);
                                            
                                        }
                                        if(td4.value!=""){
                                            
                                            creditJhint=creditJhint+parseFloat(td4.value);
                                            
                                        }
                                    }
                                    document.getElementById('editdebit_total_hitn').innerHTML=number_format(debitJhint,2);
                                    document.getElementById('editcredit_total_hitn').innerHTML=number_format(creditJhint,2);
                            }
                            function editDeleteAllRows(){
                                var t = document.getElementById('editjournalentrytablebody');
                                if(editjournalrow>2){
                                    for(var c=editjournalrow;c>2;c--){
                                        var tr = document.getElementById("editjournalrow"+c);
                                        t.removeChild(tr);
                                    }
                                    editjournalrow=2;
                                }
                            }
                        </script>
                    </div>
                    <div class="col-md-12 p-0 mt-4">
                        <div class="col-md-6 pl-0">
                            <p>Memo</p>
                            <textarea rows="3" class="w-100" id="JournalMemoedit" ></textarea>
                        </div>
                        <div class="col-md-6 m-0 pr-0" style="display:none">
                            <div class="d-inline-flex">
                                <p class="fa fa-paperclip"></p>
                                <p class="p-0 ml-1">Maximum Size: 20MB</p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="canceljournalentryedit" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success rounded" id="JournalEntrySaveButtonedit" onclick="saveJournalEntryedit()">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Journal Modal End-->
<div id="">
        <div id="modallike2" onclick="hidecustomizationsectioncustomer()">
            
        </div>
        <div class="customizationsection2">
            <div class="row" style="margin-top:10px;">
                <div class="col-md-10">
                    <h4 style="font-weight:400;">Add Customer/Supplier</h4>
                </div>
                <div class="col-md-2" style="text-align:right;">
                    <button class="btn btn-link" style="text-decoration: none;color:#ccc" onclick="hidecustomizationsectioncustomer()"><span class="oi oi-x"></span></button>
                </div>
            </div>
            <div class="row" style="margin-top:10px;margin-right:10px;">
                <div class="col-md-12" style="margin-right:10px;">
                <script>
                    function SaveInformation(){
                        var DisplayNameCustomerSupplier=document.getElementById('DisplayNameCustomerSupplier').value;
                        var CustomerSupplierType=document.getElementById('CustomerSupplierType').value;
                        
                        $.ajax({
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "{{ route('add_customer_supplier') }}",
                            data: {DisplayNameCustomerSupplier:DisplayNameCustomerSupplier,CustomerSupplierType:CustomerSupplierType,_token: '{{csrf_token()}}'},
                            success: function (data) {
                                
                                var options = '';
                                for(var c=0;c<data.length;c++){
                                    console.log(data[c]['display_name']);
                                    if(data[c]['display_name']!=""){
                                        options += '<option value="'+data[c]['display_name']+'" >'+data[c]['account_type']+'</option>';
                                    }else{
                                        options += '<option value="'+data[c]['f_name']+' '+data[c]['l_name']+'" >'+data[c]['account_type']+'</option>'; 
                                    }
                                }
                                options += '<option value="--Add Customer/Supplier--">';
                                document.getElementById('customer_list_all').innerHTML = options;
                                if(document.getElementById('DisplayNameCustomerSupplier').value=="From Journal"){
                                    hidecustomizationsectioncustomer();
                                    document.getElementById('enterjournalentry').click();
                                }
                                document.getElementById('DisplayNameCustomerSupplier').value="";
                                document.getElementById('CustomerSupplierType').value="";
                                
                                
                            },
                            
                        });
                    }
                    $("#AddCustomerSupplierForm").submit(function(e) {
                        e.preventDefault();
                        
                    });
                    function ShowModalType(id){
                        if(document.getElementById(id).value!=""){
                            document.getElementById('DisplayNameCustomerSupplier').value="From Journal";
                            if(document.getElementById(id).value=="Customer"){
                                document.getElementById('customerssasdmodaladd').click();
                            }else if(document.getElementById(id).value=="Supplier"){
                                document.getElementById('suppliiermodaladd').click();
                            }
                            
                        }else{

                        }
                        document.getElementById(id).value="";
                    }
                </script>
                
                <button style="display:none;" data-toggle="modal" id="enterjournalentry" data-target="#journalentrymodal"></button>
                <button style="display:none;" data-toggle="modal" id="suppliiermodaladd" data-target="#supplierModal"></button>
                <button style="display:none;" data-toggle="modal" id="customerssasdmodaladd" data-target="#addcustomermodal"></button>
                <form action="#" id="AddCustomerSupplierForm" onsubmit="return false,SaveInformation()">
                <div class="form-group" style="display:none;">
                    <label for="DisplayNameCustomerSupplier">Display Name</label>
                    <input required type="text" class="form-control" id="DisplayNameCustomerSupplier" placeholder="Enter Display Name">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Type</label>
                    <select id="CustomerSupplierType" class="form-control" required onchange="ShowModalType('CustomerSupplierType')">
                        <option value="">--Select Type--</option>
                        <option>Customer</option>
                        <option>Supplier</option>
                    </select>
                </div>
                
                <button type="submit" style="display:none;" disabled class="btn btn-primary" >Add</button>
                </form>
                </div>
            </div>
            
        </div>
    </div>
<div class="modal fade p-0" id="investqtyadjmodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Inventory Quantity Adjustment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="col-md-12 p-0 mb-4">
                        <div class="col-md-2 p-0">
                            <p>Adjustment Date</p>
                            <input type="date" name="">
                        </div>
                        <div class="col-md-2 p-0">
                            <p>Reference No.</p>
                            <input type="text" name="" placeholder="1">
                        </div>
                        <div class="col-md-3 p-0">
                            <p>Inventory Adjustment Account</p>
                            <input type="text" name="">
                        </div>
                    </div>
                    <table class="table table-bordered table-responsive-md table-striped text-left font14">
                        <tr>
                            <th class="text-left">#</th>
                            <th class="text-left">PRODUCT</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-left">QTY ON HAND</th>
                            <th class="text-left">NEW QTY</th>
                            <th class="text-left">CHANGE IN QTY</th>
                            <th class="text-center"></th>
                        </tr>
                        <tr>
                            <td class="pt-3-half" contenteditable="false">1</td>
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td class="pt-3-half text-center" contenteditable="false"><a href="" class="fa fa-trash"></a></td>
                        </tr>
                        <!-- This is our clonable table line -->
                        <tr>
                            <td class="pt-3-half" contenteditable="false">2</td>
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td class="pt-3-half" contenteditable="true"></td>
                            <td class="pt-3-half text-center" contenteditable="false"><a href="" class="fa fa-trash"></a></td>
                        </tr>
                        <!-- This is our clonable table line -->
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-left">
                            <div class="d-inline-flex">
                                <button class="btn btn-outline-dark rounded mr-1 font14">Add Items</button>
                                <button class="btn btn-outline-dark rounded mr-1 font14">Clear All Items</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 mt-4">
                        <div class="col-md-6 pl-0">
                            <p>Memo</p>
                            <textarea rows="3" class="w-100"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success rounded" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade p-0" id="paybillsmodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <script>
            function save_pay_bill(){
                var paybill_paymentaccount=document.getElementById('paybill_paymentaccount').value;
                var paybillrowcount=document.getElementById('paybillrowcount').value;
                var checked=[];
                var bank=[];
                var paymentdate=[];
                var paymentamount=[];
                var paybilltotalbalance=[];
                var usevoucher_question=[];
                for(c=1;c<=paybillrowcount;c++){      
                    if($('#paybillcheckbox'+c).prop("checked")==true){
                    checked.push(document.getElementById('paybillcheckbox'+c).value);   
                    bank.push(document.getElementById('paybill_bank_account'+c).value);   
                    paymentdate.push(document.getElementById('paybill_paymentdate'+c).value);   
                    paymentamount.push(document.getElementById('paybillactualpaymentamount'+c).value); 
                    paybilltotalbalance.push($('#paybilltotalbalance'+c).attr('title')); 
                    usevoucher_question.push(document.getElementById('usevoucher_question'+c).value); 
                    }
                }
                    $.ajax({
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('add_pay_bill') }}",
                        dataType: "text",
                        data: {usevoucher_question:usevoucher_question,paybilltotalbalance:paybilltotalbalance,paymentamount:paymentamount,paybill_bank_account:bank,paybill_paymentaccount:paybill_paymentaccount,checked:checked,paybill_paymentdate:paymentdate,_token: '{{csrf_token()}}'},
                        success: function (data) {
                            console.log(data);
                            //swal("Done!", "Added Deposit Record", "success");
                            swal({title: "Done!", text: "Added Bill Payment", type: 
                            "success"}).then(function(){
                                setTimeout(function(){
                                    location.reload();
                                }, 1000);
                                
                            });
                        },
                        error: function (data) {
                            
                            swal("Error!", "Bill Payment failed", "error");
                        }
                    });
                
            }
        $("#pay_bill_form").submit(function(e) {
            e.preventDefault();
            
        });
        </script>
    <form action="#" id="pay_bill_form" onsubmit="save_pay_bill()">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Pay Bills</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12 p-0 mb-4">
                    <div class="my-3 p-0">
                        <div class="col-md-2 p-0 pr-3">
                            <p>Source of Fund</p>
                            <script>
                                function ChangeBankRowValue(){
                                    var paymentvaliue=document.getElementById('paybill_paymentaccount').value;
                                    var count=document.getElementById('paybillrowcount').value;
                                    for(c=1;c<=count;c++){
                                        document.getElementById('paybill_bank_inputtext'+c).value=$("#paybill_paymentaccount option:selected").text();;
                                    }
                                }
                            </script>
                            <select class="w-100 selectpicker" data-live-search="true" id="paybill_paymentaccount" required onchange="ChangeBankRowValue()">
                                <option value="">--Select Account--</option>
                                @foreach ($c_o_a as $co)
                                
                                @if($co->coa_sub_account=='Cash on Hand' || $co->coa_sub_account=='Cash on Hands')
                                <option value="{{$co->id}}">&nbsp; {{preg_replace( "/\r|\n/", "", $co->coa_name )}}</option>
                                
                                @endif
                                
                                
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-2"></div>
                    <table class="table table-bordered table-responsive-md  text-left font14 table-sm" id="table_pay_bills_modal_tabel"> 
                        <thead>
                        <tr>
                            <th class="text-center"><input type="hidden" id="paybillrowcount"></th>
                            <th class="text-left">Bill No</th>
                            <th class="text-left">Bank</th>
                            <th class="text-left">Payment Date</th>
                            <th class="text-left">Payee</th>
                            <th class="text-left">RF</th>
                            <th class="text-left">PO</th>
                            <th class="text-left">CI</th>
                            <th class="text-left">Voucher</th>
                            <th class="text-left">Due Date</th>
                            <th class="text-left">Open Balance</th>
                            <th class="text-left" width="12%">Actual Payment Amount</th>
                            <th class="text-left">Total Amount</th>
                        </tr>
                        </thead>
                        <tbody id="pay_bills_table_tbody">
                            <script>
                                function Setpaybilltotalamount(){
                                    var count=document.getElementById('paybillrowcount').value;
                                    var paybilltotalpayment=0;
                                    for(c=1;c<=count;c++){
                                        if($('#paybillcheckbox'+c).prop("checked")==true){
                                            document.getElementById("paybill_paymentdate"+c).required = true;
                                            document.getElementById("paybill_bank_account"+c).required = false;
                                            paybilltotalpayment=(parseFloat(paybilltotalpayment)+ parseFloat($('#paybilltotalbalance'+c).attr('title')) );
                                            document.getElementById('paybilltotalamount'+c).innerHTML=number_format($('#paybilltotalbalance'+c).attr('title'),2);
                                            
                                            document.getElementById('paybillactualpaymentamount'+c).value=$('#paybilltotalbalance'+c).attr('title');
                                        }else{
                                            document.getElementById('paybilltotalamount'+c).innerHTML="0.00";
                                            document.getElementById('paybillactualpaymentamount'+c).value="0";
                                            document.getElementById("paybill_paymentdate"+c).required = false;
                                            document.getElementById("paybill_bank_account"+c).required = false;
                                        }
                                    }
                                    
                                    document.getElementById('paybilltotalpayment').innerHTML="PHP "+number_format(paybilltotalpayment,2);
                                    document.getElementById('paybilltotalpaymenttotal').innerHTML="PHP "+number_format(paybilltotalpayment,2);
                                    
                                }
                                function Setactualamountpaymentbill(){
                                    var count=document.getElementById('paybillrowcount').value;
                                    var paybilltotalpayment=0;
                                    for(c=1;c<=count;c++){
                                        if($('#paybillcheckbox'+c).prop("checked")==true){
                                            //document.getElementById('paybillactualpaymentamount'+c).value;
                                            document.getElementById('paybilltotalamount'+c).innerHTML=number_format(document.getElementById('paybillactualpaymentamount'+c).value,2);
                                            paybilltotalpayment=(parseFloat(paybilltotalpayment)+ parseFloat(document.getElementById('paybillactualpaymentamount'+c).value) );
                                        }else{

                                        }
                                    }
                                    document.getElementById('paybilltotalpayment').innerHTML="PHP "+number_format(paybilltotalpayment,2);
                                    document.getElementById('paybilltotalpaymenttotal').innerHTML="PHP "+number_format(paybilltotalpayment,2);
                                }
                            </script>
                            <?php $totalopenbalance=0; ?>
                            <?php $paybillrowcount=0; ?>
                            @foreach ($ETran as $et)
                                
                                @if($et->et_type=="Bill" && $et->remark!="Cancelled" && $et->et_bil_status!="Paid")
                                <?php $paybillrowcount++; ?>
                                <script>
                                    document.getElementById('paybillrowcount').value="{{$paybillrowcount}}";
                                </script>
                                <tr >
                                    <td class="pt-3-half" contenteditable="false" style="text-align:center;padding-top:5px;"><input onchange="Setpaybilltotalamount()" type="checkbox" value="{{$et->et_no}}" id="paybillcheckbox{{$paybillrowcount}}"></td>
                                    <td class="pt-3-half" contenteditable="false" style="padding-left:5px;">
                                        {{$et->et_no}}
                                    </td>
                                    <td class="pt-3-half" contenteditable="false" id="paybill_banktd{{$paybillrowcount}}">
                                        <input type="text" style="background-color:white !important;" readonly  id="paybill_bank_inputtext{{$paybillrowcount}}" class="w-100">
                                        <select style="display:none;"  id="paybill_bank_account{{$paybillrowcount}}" class="w-100" >
                                            <option value="">--Select Bank--</option>
                                            @foreach ($banks as $bank)
                                            @if($bank->bank_status=="1")
                                            <option title="{{$bank->bank_account_no}}" value="{{$bank->bank_no}}">{{$bank->bank_name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="pt-3-half" contenteditable="false">
                                       <input type="date" name="" id="paybill_paymentdate{{$paybillrowcount}}" class="w-100">
                                    </td>
                                        <td class="pt-3-half" style="padding-left:5px;" contenteditable="false" id="payee_{{$paybillrowcount}}">
                                        
                                    </td>
                                    <script>
                                        $(document).ready(function(){
                                            $.ajax({
                                                type: "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                url: "get_customer_info",
                                                data: {id:'{{$et->et_customer}}',_token:'{{csrf_token()}}'},
                                                success: function (customer) {
                                                    console.log(customer);
                                                    console.log(customer['customer_id']);
                                                    if(customer['display_name']==''){
                                                        document.getElementById('payee_{{$paybillrowcount}}').innerHTML=customer['f_name']+" "+customer['l_name'];
                                                    }else{
                                                        document.getElementById('payee_{{$paybillrowcount}}').innerHTML=customer['display_name']; 
                                                    }

                                                    
                                                }
                                            });
                                        })
                                        
                                    </script>
                                    <td style="padding-left:5px;" class="pt-3-half" contenteditable="false">
                                       {{$et->et_shipping_address}}
                                    </td>
                                    <td style="padding-left:5px;" class="pt-3-half" contenteditable="false">
                                        {{$et->et_shipping_to}}
                                    </td>
                                    <td style="padding-left:5px;" class="pt-3-half" contenteditable="false">
                                        {{$et->et_shipping_via}}
                                    </td>
                                    <td class="pt-3-half" style="vertical-align:middle;" contenteditable="false">
                                       <select name="usevoucher_question{{$paybillrowcount}}" class="w-100" style="border:0!important" id="usevoucher_question{{$paybillrowcount}}">
                                           <option value="">No</option>
                                           <option value="Cash">Generate Cash Voucher</option>
                                           <option value="Cheque">Generate Cheque Voucher</option>
                                       </select>
                                    </td>
                                    <td class="pt-3-half"  contenteditable="false">{{date('m-d-Y',strtotime($et->et_due_date))}}</td>
                                    <?php $totalopenbalancepertransaction=$et->bill_balance; ?>
                                        
                                    <td class="pt-3-half" contenteditable="false" style="text-align:right;padding-right:5px;" id="paybilltotalbalance{{$paybillrowcount}}" title="{{$totalopenbalancepertransaction}}">
                                        
                                        
                                        {{number_format($totalopenbalancepertransaction,2)}}
                                        <?php $totalopenbalance+=$totalopenbalancepertransaction; ?>  
                                    </td>
                                    <td class="pt-3-half" contenteditable="false" >
                                        <input type="number" class="w-100" onkeyup="Setactualamountpaymentbill()" onchange="Setactualamountpaymentbill()" id="paybillactualpaymentamount{{$paybillrowcount}}" value="0" min="0" max="{{$totalopenbalancepertransaction}}">
                                    </td>
                                    <td class="pt-3-half" contenteditable="false" style="text-align:right;padding-right:5px;" id="paybilltotalamount{{$paybillrowcount}}">0.00</td>
                                </tr>
                                @endif
                            @endforeach
                        
                        
                        
                        
                        </tbody>
                    </table>
                    <table class="table table-light" style="display:none;">
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="pt-3-half" contenteditable="false"></td>
                                
                                <td class="pt-3-half" contenteditable="false"></td>
                                <td class="pt-3-half" contenteditable="false"></td>
                                <td class="pt-3-half" contenteditable="false"></td>
                                <td class="pt-3-half" contenteditable="false"></td>
                                <td class="pt-3-half" contenteditable="false"></td>
                                <td class="pt-3-half" contenteditable="false"></td>
                                <td class="pt-3-half" contenteditable="false"></td>
                                <td class="pt-3-half" contenteditable="false"></td>
                                <td class="pt-3-half" contenteditable="false"></td>
                                <td class="pt-3-half font-weight-bold" contenteditable="false" style="text-align:right;">PHP {{number_format($totalopenbalance,2)}}</td>
                                <td class="pt-3-half font-weight-bold" contenteditable="false" style="text-align:right;"></td>
                                <td class="pt-3-half font-weight-bold" contenteditable="false" style="text-align:right;" id="paybilltotalpayment">PHP 0.00</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="col-md-12 p-0">
                        <div class="float-right">
                            <div class="d-inline-flex mr-2">
                                <p class="pr-4 text-dark font-weight-bold">TOTAL PAYMENT</p>
                                <p class="text-dark font-weight-bold" id="paybilltotalpaymenttotal">PHP 0.00</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success rounded"type="submit">Save</button>
            </div>
        </div>
    </form>
    </div>
</div>
<div class="modal fade" id="uploadmodal" tabindex="-1" role="dialog" aria-labelledby="salesModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salesModalLabel">Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 m-0 pr-0">
                    <div class="d-inline-flex">
                        <p class="fa fa-paperclip"></p>
                        <p class="p-0 ml-1">Maximum Size: 20MB</p>
                    </div>
                    <div class="input-group mb-3 p-0">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success rounded">Upload</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade p-0" id="budgetingmodal" tabindex="-1" role="dialog" aria-hidden="true" style="">
    <div class="modal-dialog modal-full" role="document" style="min-width: 100%; margin: 0;">
        <div class="modal-content" style="min-height: 100vh;">
            <div class="modal-header">
                <h5 class="modal-title">Budget</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4" id="result">
                <div class="col-md-12">
                    <div class="col-auto mr-3">
                        <p>Name</p>
                        <input type="text" name="">
                    </div>
                    <div class="col-auto mr-3">
                        <p>Financial Year</p>
                        <select>
                            <option>FY 2017 (Jan 2017 - Dec 2017)</option>
                            <option>FY 2018 (Jan 2018 - Dec 2018)</option>
                            <option>FY 2019 (Jan 2019 - Dec 2019)</option>
                            <option>FY 2020 (Jan 2020 - Dec 2020)</option>
                            <option>FY 2021 (Jan 2021 - Dec 2021)</option>
                        </select>
                    </div>
                    <div class="col-auto mr-3">
                        <p>Interval</p>
                        <select>
                            <option>Monthly</option>
                            <option>Quarterly</option>
                            <option>Yearly</option>
                        </select>
                    </div>
                    <div class="col-auto mr-3">
                        <p>Pre-fill Data?</p>
                        <select>
                            <option>No</option>
                            <option>Actual Data - 2017</option>
                            <option>Actual Data - 2018</option>
                        </select>
                    </div>
                    <div class="col-auto mr-3">
                        <p>Subdivided by</p>
                        <select>
                            <option>Dont Subdivide</option>
                            <option>Customer</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 mt-4"></div>
                <table class="table table-bordered table-responsive-md table-striped text-center font14">
                    <tr>
                        <th class="text-center">ACCOUNTS</th>
                        <th class="text-center">JAN</th>
                        <th class="text-center">FEB</th>
                        <th class="text-center">MAR</th>
                        <th class="text-center">APR</th>
                        <th class="text-center">MAY</th>
                        <th class="text-center">JUN</th>
                        <th class="text-center">JUL</th>
                        <th class="text-center">AUG</th>
                        <th class="text-center">SEP</th>
                        <th class="text-center">OCT</th>
                        <th class="text-center">NOV</th>
                        <th class="text-center">DEC</th>
                        <th class="text-center">TOTAL</th>
                    </tr>
                    <tr>
                        <td class="pt-3-half" contenteditable="true"></td>
                        <td class="pt-3-half" contenteditable="true"></td>
                        <td class="pt-3-half" contenteditable="true"></td>
                        <td class="pt-3-half" contenteditable="true"></td>
                        <td class="pt-3-half" contenteditable="true"></td>
                        <td class="pt-3-half" contenteditable="true"></td>
                        <td class="pt-3-half" contenteditable="true"></td>
                        <td class="pt-3-half" contenteditable="true"></td>
                        <td class="pt-3-half" contenteditable="true"></td>
                        <td class="pt-3-half" contenteditable="true"></td>
                        <td class="pt-3-half" contenteditable="true"></td>
                        <td class="pt-3-half" contenteditable="true"></td>
                        <td class="pt-3-half" contenteditable="true"></td>
                        <td class="pt-3-half" contenteditable="true"></td>
                    </tr>
                    <!-- This is our clonable table line -->
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success rounded" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="chartofaccountsmodal" tabindex="-1" role="dialog" aria-labelledby="salesModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salesModalLabel">Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ action('ChartofAccountsController@store') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="active" value="1">
                <div class="col-md-6 p-1">
                    <div class="mb-3" style="display:none;">
                        <select class="w-100 pt-1" id="accounttypeType" onchange="changeaccounttype()">
                        <option value="default">Default</option>
                        <option value="defined">Company Defined Account Type</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <p>Account Classification</p>
                        <select id="coatitle" list="account_title_datalist" type="text" name="coatitle"  class="w-100" onchange="changelistlineitem(this)">
                            <option>Assets</option>
                            <option>Liabilities</option>
                            <option>Equity</option>
                            <option>Revenues</option>
                            <option>Expenses</option>
                        </select>
                        <datalist id="account_title_datalist">
                            <option>Assets</option>
                            <option>Liabilities</option>
                            <option>Equity</option>
                            <option>Revenues</option>
                            <option>Expenses</option>
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <p>Line Item</p>
                        <select id="coaAccountType" name="ACCType" class="w-100 pt-1" onchange="ChangeDetailType()" style="display:none;">
                            <option>Bank</option>
                            <option>Accounts receivable (A/R)</option>
                            <option>Other Current Assets</option>
                            <option>Fixed Assets</option>
                            <option>Other Assets</option>
                            <option>Accounts Payable (A/P)</option>
                            <option>Credit Card</option>
                            <option>Other Current Liabilities</option>
                            <option>Long Term Liabilities</option>
                            <option>Equity</option>
                            <option>Income</option>
                            <option>Cost of Goods Sales</option>
                            <option>Expenses</option>
                            <option>Other Income</option>
                            <option>Other Expenses</option>
                            <option selected>Custom</option>
                        </select>
                        <script>
                            $(document).ready(function(){
                                ChangeDetailType();
                            })
                        </script>
                        <input type="text" name="customaccounttype" style="display:none;" id="customaccount"  class="w-100" list="line_item_choices_list_asset">
                        <datalist id="line_item_choices_list_asset">
                            <option>Current Asset</option>
                            <option>Non-Current Asset</option>
                            <option>Other Current Assets</option>
                            <option>Fixed Assets</option>
                            <option>Other Assets</option>
                        </datalist>
                        <datalist id="line_item_choices_list_liability">
                            <option>Current Liabilities</option>
                            <option>Other Current Liabilities</option>
                            <option>Long Term Liabilities</option>
                        </datalist>
                        <datalist id="line_item_choices_list_equity">
                            <option>Equity</option>
                        </datalist>
                        <datalist id="line_item_choices_list_revenue">
                            <option>Revenue</option>
                        </datalist>
                        <datalist id="line_item_choices_list_expense">
                            <option>Expense</option>
                            <option>Other Expenses</option>
                        </datalist>
                    </div>
                    <script>
                        function changelistlineitem(e){
                            var input_item_line=document.getElementById('customaccount');
                            if(e.value=="Assets"){
                                input_item_line.setAttribute('list','line_item_choices_list_asset');
                            }
                            if(e.value=="Liabilities"){
                                input_item_line.setAttribute('list','line_item_choices_list_liability');
                            }
                            if(e.value=="Equity"){
                                input_item_line.setAttribute('list','line_item_choices_list_equity');
                            }
                            if(e.value=="Revenues"){
                                input_item_line.setAttribute('list','line_item_choices_list_revenue');
                            }
                            if(e.value=="Expenses"){
                                input_item_line.setAttribute('list','line_item_choices_list_expense');
                            }
                        }
                        function changeclassifications(e){
                            document.getElementById('coatitle').value=e.value;
                        }
                        function changeaccounttype(){
                            var Type = document.getElementById("accounttypeType").value;
                            var x = document.getElementById("coaAccountType");
                            var length = x.options.length;
                            
                            for (i = length-1; i>=0; i--) {
                                
                                x.options[i] = null;
                            }
                            if(Type=="defined"){
                                var a = document.createElement("option");
                                a.text = "Cash";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Receivable Accounts";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Inventories";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Prepayment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Land, Building and Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Equipment and Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Asset Contra Accounts";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Website Development Cost ( Planning and design )";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Payable Accounts";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Payables";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Equity";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Revenues";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Purchases, Freight In, and Subcontractor Expense";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Salaries and Wages";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Compensations";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Personnel Benefit Contribution";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Personnel Benefit";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Supplies Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Tranportation and Training Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Utility Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Corporate Security";
                                x.options.add(a);
                                a.text = "Communication and Printing Expenses";
                                x.options.add(a);
                                a.text = "Taxes, Duties and Premiums";
                                x.options.add(a);
                                a.text = "Representation and Commision Expenses";
                                x.options.add(a);
                                a.text = "Awards and Rewards";
                                x.options.add(a);
                                a.text = "Rent/Lease Expenses";
                                x.options.add(a);
                                a.text = "Food, Notary and Extraordinary and Miscellaneous Expenses, Other Expenses";
                                x.options.add(a);
                                a.text = "Repair and Maintenance";
                                x.options.add(a);
                                a.text = "Professional Services";
                                x.options.add(a);
                                a.text = "Doubtful Accounts and Depreciation";
                                x.options.add(a);
                                a.text = "Gain and Losses";
                                x.options.add(a);
                                a.text = "Financial Expenses";
                                x.options.add(a);
                                a.text = "Other Company Expenses";
                                x.options.add(a);
                                a.text = "Intermidiate Accounts";
                                x.options.add(a);
                            }else{
                                var a = document.createElement("option");
                                a.text = "Bank";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accounts receivable (A/R)";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Current Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Fixed Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accounts Payable (A/P)";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Credit Card";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Current Liabilities";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Long Term Liabilities";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Equities";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Income";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Cost of Goods Sales";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Income";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Custom";
                                x.options.add(a);
                            }
                            ChangeDetailType();
                        }
                        function ChangeDetailType(){
                           var coaAccountType=document.getElementById('coaAccountType').value;
                           var x = document.getElementById("coaDetailType");
                           var length = x.options.length;
                           
                            for (i = length-1; i>=0; i--) {
                                
                                x.options[i] = null;
                            }
                            x.style.display="inline-block";
                            document.getElementById('customaccount').style.display="none";
                            document.getElementById('customdetail').style.display="none";
                            document.getElementById('TypeDescriptionTextArea').value=""; 
                           switch(coaAccountType) {
                            case 'Cash':
                                var a = document.createElement("option");
                                a.text = "Cash in Bank – Local Currency";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Cash in Bank – Foreign Currency";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Petty Cash Fund";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Petty Cash Fund-Special Fund";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Revolving Fund";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Mid-year Fund";
                                x.options.add(a);
                                
                                break;
                            case 'Receivable Accounts':
                                var a = document.createElement("option");
                                a.text = "Accounts Receivable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Rent/Lease Receivable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Due from Officers and Employees ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Receivable – Disallowances/Charges";
                                x.options.add(a);
                                
                                break;
                            case 'Inventories':
                                var a = document.createElement("option");
                                a.text = "PPE Supplies";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Unused Supplies and Materials ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Spare Parts Inventory";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Inventories";
                                x.options.add(a);
                                
                                break;
                            case 'Prepayment':
                                var a = document.createElement("option");
                                a.text = "Prepaid Rent";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Prepaid Fuel, Oil and Lubricant";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Prepaid Insurance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Prepaid Bond- Performance Bond";
                                x.options.add(a);
                                
                                break;
                            case 'Land, Building and Improvements':
                                var a = document.createElement("option");
                                a.text = "Land";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Land Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Building";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Building Improvements";
                                x.options.add(a);
                                
                                break;
                            case 'Equipment and Improvements':
                                var a = document.createElement("option");
                                a.text = "Office Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "IT Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Communication Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Trucks, Vehicle & Heavy Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Construction Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Tools and  Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Engineering Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Furniture and Fixture";
                                x.options.add(a);
                                break;
                            case 'Improvements':
                                var a = document.createElement("option");
                                a.text = "Capital Improvements- Trucks, Vehicle & Heavy Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Capital Improvements- Construction Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Capital Improvements- Engineering Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Capital Improvements- Furniture and Fixture";
                                x.options.add(a);
                                
                                break;
                            case 'Asset Contra Accounts':
                                var a = document.createElement("option");
                                a.text = "Allowance for Doubtful Accounts";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Land Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Buildings";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Office Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – IT Equipment ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Communication Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Trucks, Vehicle and Heavy Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Construction Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Tools and Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Engineering Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Furnitures and Fixtures";
                                x.options.add(a);
                                break;
                            case 'Website Development Cost ( Planning and design )':
                                var a = document.createElement("option");
                                a.text = "Website Development Cost";
                                x.options.add(a);
                                break;
                            case 'Payable Accounts':
                                var a = document.createElement("option");
                                a.text = "Accounts Payable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Notes Payable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Interest Payable";
                                x.options.add(a);
                                break;
                            case 'Other Payables':
                                var a = document.createElement("option");
                                a.text = "Deferred Income";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Bonds Payable- Employee's Cash Bond";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accrued Rent Expense";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accrued Salaries and Wages Expense";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accrued Utility Expense";
                                x.options.add(a);
                                break;
                            case 'Equities':
                                var a = document.createElement("option");
                                a.text = "Arkcons, Capital ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Arkcons, Drawing";
                                x.options.add(a);
                                break;
                            case 'Revenues':
                                var a = document.createElement("option");
                                a.text = "Service Revenue";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Rent/Lease Income ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accrued Income";
                                x.options.add(a);
                                break;
                            case 'Purchases, Freight In, and Subcontractor Expense':
                                var a = document.createElement("option");
                                a.text = "Purchases- Direct Materials";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Purchases- Supplies";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Freight In";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Subcontractor Expense";
                                x.options.add(a);
                                break;
                            case 'Salaries and Wages':
                                var a = document.createElement("option");
                                a.text = "Salaries and Wages – Regular";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Salaries and Wages – Local";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Salaries and Wages – Agency";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Salaries and Wages- Agency share and benefits";
                                x.options.add(a);
                                break;
                            case 'Other Compensations':
                                var a = document.createElement("option");
                                a.text = "Cost of Living Allowance (COLA)";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Meal Allowance ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Interruption Allowance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Night Patroll Allowance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Emergency Call Allowance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Travel Allowance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Clothing and Uniform Allowance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Motorcycle Allowance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Honoraria";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Mid-year Bonus / Year-end Bonus";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Hazard Allowance";
                                x.options.add(a);
                                break;
                            case 'Personnel Benefit Contribution':
                                var a = document.createElement("option");
                                a.text = "SSS Contributions";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "PAG-IBIG Contributions";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "PHILHEALTH Contributions";
                                x.options.add(a);
                                break;
                            case 'Other Personnel Benefit':
                                var a = document.createElement("option");
                                a.text = "Vacation and Sick Leave Benefits";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Overtime and Holiday Pay";
                                x.options.add(a);
                                break;
                            case 'Supplies Expenses':
                                var a = document.createElement("option");
                                a.text = "Office Supplies Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Fuel, Oil and Lubricants Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repair and Maintenance Supplies Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "PPE Supplies Expense";
                                x.options.add(a);
                                break;
                            case 'Tranportation and Training Expenses':
                                var a = document.createElement("option");
                                a.text = "Transportation Expenses ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Training Expense";
                                x.options.add(a);
                                break;
                            case 'Utility Expenses':
                                var a = document.createElement("option");
                                a.text = "Water";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Electricity";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Fuel";
                                x.options.add(a);
                                break;
                            case 'Corporate Security':
                                var a = document.createElement("option");
                                a.text = "Corporate Security";
                                x.options.add(a);
                                break;
                            case 'Communication and Printing Expenses':
                                var a = document.createElement("option");
                                a.text = "Freight and Handling";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Telephone Expenses – Landline";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Telephone Expenses – Mobile";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Internet Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Printing  Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Advertisement Expense";
                                x.options.add(a);
                                break;
                            case 'Taxes, Duties and Premiums':
                                var a = document.createElement("option");
                                a.text = "Taxes, Duties and Licenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Income Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Documentary Stamp Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Travel Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Motor Vehicles Users Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Real Property  Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Percentage Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Fines and Penalties – Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "License Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Registration Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Inspection Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Processing Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Clearance and Certification Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Permit Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Fines and Penalties – Fees, Permits and License Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Parking/Terminal Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Toll Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Fines and Penalties – Business Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Insurance Premiums ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Bond-Performance Bond Expense";
                                x.options.add(a);

                                break; 
                            case 'Representation and Commision Expenses':
                                var a = document.createElement("option");
                                a.text = "Representation Expenses ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Commission Expenses";
                                x.options.add(a);
                                break; 
                            case 'Awards and Rewards':
                                var a = document.createElement("option");
                                a.text = "Awards and Rewards";
                                x.options.add(a);
                                break; 
                            case 'Rent/Lease Expenses':
                                var a = document.createElement("option");
                                a.text = "Rent/Lease Expenses";
                                x.options.add(a);
                                break; 
                            case 'Food, Notary and Extraordinary and Miscellaneous Expenses, Other Expenses':
                                var a = document.createElement("option");
                                a.text = "Food Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Extraordinary and Miscellaneous Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Notary Fee";
                                x.options.add(a);
                                break; 
                            case 'Repair and Maintenance':
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Land Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Buildings";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Office Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – IT Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Communication Equipment ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Trucks, Vehicle and Heavy Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Construction Equipment ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Tools and Equipment ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Engineering Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Furniture and Fixtures";
                                x.options.add(a);
                                break;
                            case 'Professional Services':
                                var a = document.createElement("option");
                                a.text = "Legal Services";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Bookkeeping Services";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Engineering Services";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Professional Services ";
                                x.options.add(a);
                                break; 
                            case 'Doubtful Accounts and Depreciation':
                                var a = document.createElement("option");
                                a.text = "Doubtful Accounts Expenses ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Land Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Buildings";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Office Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – IT Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Communication Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Trucks, Vehicle and Heavy Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Construction Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Tools and Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Engineeringl Machinery";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Furniture and Fixtures";
                                x.options.add(a);
                                break; 
                            case 'Gain and Losses':
                                var a = document.createElement("option");
                                a.text = "Loss on Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Losses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Gain on Asset";
                                x.options.add(a);
                                break; 
                            case 'Financial Expenses':
                                var a = document.createElement("option");
                                a.text = "Bank Charges  ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Service Charge";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Interest Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Mortgage Fee";
                                x.options.add(a);
                                break; 
                            case 'Other Company Expenses':
                                var a = document.createElement("option");
                                a.text = "Bidding Cost";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Importation Expense";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Company Expense";
                                x.options.add(a);
                                
                                break; 
                            case 'Intermidiate Accounts':
                                var a = document.createElement("option");
                                a.text = "Provision for Income Tax";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Income and Expense Summary";
                                x.options.add(a);
                                break; 
                            case 'Custom':
                                x.style.display="none";
                                document.getElementById('customaccount').style.display="inline-block";
                                document.getElementById('customdetail').style.display="inline-block";
                                
                                break;
                            case 'Bank':
                                var a = document.createElement("option");
                                a.text = "Cash on hand";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Checking";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Money Market";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Rents Held in Trust";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Savings";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Trust account";
                                x.options.add(a);
                                break;
                            case 'Accounts receivable (A/R)':
                            var a = document.createElement("option");
                                a.text = "Account recievable (A/R)";
                                x.options.add(a);
                            
                                break;
                            case 'Other Current Assets':
                                var a = document.createElement("option");
                                a.text = "Allowance for Bad Debts";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Development Costs";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Employee Cash Advances";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Inventory";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Investment-Mortgage/Real Estate Loans";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Investment-Tax-Exempt Securities";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Investment-U.S. Government Obligation";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Investment-Other";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Loans To Officers";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Loan To Others";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Loans To Stockholders";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Current Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Prepaid Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Retainage";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Undeposited Funds";
                                x.options.add(a);

                                break;
                            case 'Fixed Assets':
                            var a = document.createElement("option");
                                a.text = "Accumulated Amortization";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depletion";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Buildings";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depletable Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Furniture & Fixtures";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Intangible Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Land";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Leasehold Improvement";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Loan Machinery & Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Fixed Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Vehicles";
                                x.options.add(a);
                               
                                break;
                            case 'Other Assets':
                                var a = document.createElement("option");
                                a.text = "Accumulated Amortization of Other Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Goodwill";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Lease Buyout";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Licenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Organizational Costs";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Long-term Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Security Deposit";
                                x.options.add(a);
                                break;
                            case 'Accounts Payable (A/P)':
                                var a = document.createElement("option");
                                a.text = "Accounts Payable (A/P)";
                                x.options.add(a);
                                break;
                            case 'Credit Card':
                                var a = document.createElement("option");
                                a.text = "Credit Card";
                                x.options.add(a);
                                break;
                            case 'Other Current Liabilities':
                                var a = document.createElement("option");
                                a.text = "Federal Income Tax Payable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Insurance Payable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Current Liabilities";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Payroll Clearing";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Payroll Tax Payable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Prepaid Expenses Payable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Rents in Trust-Liability";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Sales Tax Payable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "State/Local Income Tax Payable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Trust Account-Liability";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Line Of Credit";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Loan Payable";
                                x.options.add(a);
                                break;
                            case 'Long Term Liabilities':
                                var a = document.createElement("option");
                                a.text = "Notes Payable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Long Term Liabilities";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Shareholder Notes Payable";
                                x.options.add(a);
                                break;
                            case 'Equity':
                                var a = document.createElement("option");
                                a.text = "Accumulated Adjustment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Common Stock";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Opening Balance Equity";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Owner's Equity";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Paid-in Capital or Surplus";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Partner Contribution";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Partner Distribution";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Partner's Equity";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Preffered Stock";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Retained Earnings";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Treasury Stock";
                                x.options.add(a);
                                break;
                            case 'Income':
                                var a = document.createElement("option");
                                a.text = "Discounts/Refunds Given";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Non-Profit Income";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Primary Income";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Sales of Product Income";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Service/Fee Income";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Unapplied Cash Payment Income";
                                x.options.add(a);
                                break;
                            case 'Cost of Goods Sales':
                                var a = document.createElement("option");
                                a.text = "Cost of labor - COS";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Equipment Rental - COS";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Costs of Services - COS";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Shipping, Freight & Delivery - COS";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Supplies & Materials - COGS";
                                x.options.add(a);
                                break;
                            case 'Expenses':
                                var a = document.createElement("option");
                                a.text = "Advertising/Promotional";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Auto";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Bad Debts";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Bank Charges";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Charitable Contributions";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Cost of Labor";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Dues and subscriptions";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Entertainment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Entertainment Meals";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Equipment Rental";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Finance costs";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Insurance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Interest Paid";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Legal & Professional Fees";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Office/General Administrative Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Miscellaneous Service Cost";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Payroll Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Promotional Meals";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Rent or Lease of Buildings";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repair & Maintenance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Shipping, Freight & Delivery";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Supplies & Materials";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Taxes Paid";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Travel";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Travel Meals";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Unapplied Cash Bill Payment Expense";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Utilities";
                                x.options.add(a);
                                
                                break;
                            case 'Other Income':
                                var a = document.createElement("option");
                                a.text = "Dividend Income";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Interest Earned";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Investment Income";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Miscellaneous Income";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Tax-Exempt Interest";
                                x.options.add(a);
                                break;
                            case 'Other Expenses':
                                var a = document.createElement("option");
                                a.text = "Amortization";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Exchange Gain or Loss ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Miscellaneous Expense ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Penalties & Settlements";
                                x.options.add(a);
                                break;
                            default:
                                break;
                           }
                          ChangeTypeDesc();
                        }
                        function ChangeTypeDesc(){
                            document.getElementById('TypeDescriptionTextArea').value=""; 
                            var DType=document.getElementById('coaDetailType').value;
                            if(DType=="Account recievable (A/R)"){
                                document.getElementById('TypeDescriptionTextArea').value="Accounts receivable (also called A/R, Debtors, or Trade and other receivables) tracks money that customers owe you for products or services, and payments customers make.\nQuickBooks Online Plus automatically creates one Accounts receivable account for you.\n\nMost businesses need only one.Each customer has a register, which functions like an Accounts receivable account for each customer.";
                            }
                            if(DType=="Cash on hand"){
                                document.getElementById('TypeDescriptionTextArea').value="Use a Cash on hand account to track cash your company keeps for occasional expenses, also called petty cash.\nTo track cash from sales that have not been deposited yet, use a pre-created account called Undeposited funds, instead.";
                            }
                            if(DType=="Checking"){
                                document.getElementById('TypeDescriptionTextArea').value="";
                            }
                            if(DType=="Money Market"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Money market to track amounts in money market accounts.\nFor investments, see Current Assets, instead.";
                            }
                            if(DType=="Rents Held in Trust"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Rents held in trust to track deposits and rent held on behalf of the property owners.\nTypically only property managers use this type of account.";
                            }
                            if(DType=="Savings"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Savings accounts to track your savings and CD activity.\nEach savings account your company has at a bank or other financial institution should have its own Savings type account.";
                            }
                            if(DType=="Trust Account"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Client trust accounts for money held by you for the benefit of someone else.\nFor example, trust accounts are often used by attorneys to keep track of expense money their customers have given them.";
                            }
                            if(DType=="Allowance for Bad Debts"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Allowance for bad debts to estimate the part of Accounts Receivable that you think you might not collect.\nUse this only if you are keeping your books on the accrual basis.";
                            }
                             if(DType=="Development Costs"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Development costs to track amounts you deposit or set aside to arrange for financing, such as an SBA loan, or for deposits in anticipation of the purchase of property or other assets.\nWhen the deposit is refunded, or the purchase takes place, remove the amount from this account.";
                            }
                            if(DType=="Employee Cash Advances"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Employee cash advances to track employee wages and salary you issue to an employee early, or other non-salary money given to employees.\nIf you make a loan to an employee, use the Current asset account type called Loans to others, instead.";
                            }
                            if(DType=="Inventory"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Inventory to track the cost of goods your business purchases for resale.\nWhen the goods are sold, assign the sale to a Cost of sales account.";
                            }
                            if(DType=="Investment-Mortgage/Real Estate Loans"){
                                document.getElementById('TypeDescriptionTextArea').value="";
                            }
                            if(DType=="Investment-Tax-Exempt Securities"){
                                document.getElementById('TypeDescriptionTextArea').value="";
                            }
                            if(DType=="Investment-U.S. Government Obligation"){
                                document.getElementById('TypeDescriptionTextArea').value="";
                            }
                            if(DType=="Investment-Other"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Investments - Other to track the value of investments not covered by other investment account types. Examples include publicly-traded shares, coins, or gold.";
                            }
                            if(DType=="Loans To Officers"){
                                document.getElementById('TypeDescriptionTextArea').value="If you operate your business as a Corporation, use Loans to officers to track money loaned to officers of your business.";
                            }
                            if(DType=="Loan To Others"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Loans to others to track money your business loans to other people or businesses.\nThis type of account is also referred to as Notes Receivable.";
                            }
                            if(DType=="Loans To Stockholders"){
                                document.getElementById('TypeDescriptionTextArea').value="If you operate your business as a Corporation, use Loans to Shareholders to track money your business loans to its shareholders.";
                            }
                            if(DType=="Other Current Assets"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Other current assets for current assets not covered by the other types. Current assets are likely to be converted to cash or used up in a year.";
                            }
                            if(DType=="Prepaid Expenses"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Prepaid expenses to track payments for expenses that you won’t recognise until your next accounting period.\nWhen you recognise the expense, make a journal entry to transfer money from this account to the expense account.";
                            }
                            if(DType=="Retainage"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Retainage if your customers regularly hold back a portion of a contract amount until you have completed a project.\nThis type of account is often used in the construction industry, and only if you record income on an accrual basis.";
                            }
                            if(DType=="Undeposited Funds"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Undeposited funds for cash or cheques from sales that haven’t been deposited yet.\nFor petty cash, use Cash on hand, instead.";
                            }
                           if(DType=="Accumulated Amortization"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Accumulated amortisation of non-current assets to track how much you’ve amortised an asset whose type is Non-Current Asset.";
                            }
                            if(DType=="Accumulated Depletion"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Accumulated depletion to track how much you deplete a natural resource.";
                            }
                            if(DType=="Accumulated Depreciation"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Accumulated depreciation on property, plant and equipment to track how much you depreciate a fixed asset (a physical asset you do not expect to convert to cash during one year of normal operations).";
                            }
                            if(DType=="Buildings"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Buildings to track the cost of structures you own and use for your business. If you have a business in your home, consult your accountant.\nUse a Land account for the land portion of any real property you own, splitting the cost of the property between land and building in a logical method. A common method is to mimic the land-to-building ratio on the property tax statement.";
                            }
                            if(DType=="Depletable Assets"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Depletable assets to track natural resources, such as timberlands, oil wells, and mineral deposits.";
                            }
                            if(DType=="Furniture & Fixtures"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Furniture and fixtures to track any furniture and fixtures your business owns and uses, like a dental chair or sales booth.";
                            }
                            if(DType=="Intangible Assets"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Intangible assets to track intangible assets that you plan to amortise. Examples include franchises, customer lists, copyrights, and patents.";
                            }
                            if(DType=="Land"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Land to track assets that are not easily convertible to cash or not expected to become cash within the next year. For example, leasehold improvements.";
                            }
                            if(DType=="Leasehold Improvement"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Leasehold improvements to track improvements to a leased asset that increases the asset’s value. For example, if you carpet a leased office space and are not reimbursed, that’s a leasehold improvement.";
                            }
                            if(DType=="Loan Machinery & Equipment"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Machinery and equipment to track computer hardware, as well as any other non-furniture fixtures or devices owned and used for your business.\nThis includes equipment that you ride, like tractors and lawn mowers. Cars and trucks, however, should be tracked with Vehicle accounts, instead.";
                            }
                            if(DType=="Other Fixed Assets"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Other fixed asset for fixed assets that are not covered by other asset types.\nFixed assets are physical property that you use in your business and that you do not expect to convert to cash or be used up during one year of normal operations.";
                            }
                            if(DType=="Vehicles"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Vehicles to track the value of vehicles your business owns and uses for business. This includes off-road vehicles, air planes, helicopters, and boats.\nIf you use a vehicle for both business and personal use, consult your accountant to see how you should track its value.";
                            }
                            if(DType=="Accumulated Amortization of Other Assets"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Accumulated amortisation of non-current assets to track how much you’ve amortised an asset whose type is Non-Current Asset.";
                            }
                            if(DType=="Goodwill"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Goodwill only if you have acquired another company. It represents the intangible assets of the acquired company which gave it an advantage, such as favourable government relations, business name, outstanding credit ratings, location, superior management, customer lists, product quality, or good labour relations.";
                            }
                            if(DType=="Lease Buyout"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Lease buyout to track lease payments to be applied toward the purchase of a leased asset.\n\nYou don’t track the leased asset itself until you purchase it.";
                            }
                            if(DType=="Licenses"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Licences to track non-professional licences for permission to engage in an activity, like selling alcohol or radio broadcasting.\n\nFor fees associated with professional licences granted to individuals, use a Legal and professional fees expense account, instead.";
                            }
                            if(DType=="Organizational Costs"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Organisational costs to track costs incurred when forming a partnership or corporation.\n\nThe costs include the legal and accounting costs necessary to organise the company, facilitate the filings of the legal documents, and other paperwork.";
                            }
                            if(DType=="Other Long-term Assets"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Other non-current assets to track assets not covered by other types.\n\nNon-current assets are long-term assets that are expected to provide value for more than one year.";
                            }
                            if(DType=="Security Deposit"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Security deposits to track funds you’ve paid to cover any potential costs incurred by damage, loss, or theft.\n\nThe funds should be returned to you at the end of the contract.\n\nIf you collect deposits, use an Other current liabilities account (a Current liability account).";
                            }
                            if(DType=="Accounts Payable (A/P)"){
                                document.getElementById('TypeDescriptionTextArea').value="Accounts payable (also called A/P, Trade and other payables, or Creditors) tracks amounts you owe to your suppliers.\n\nQuickBooks Online Plus automatically creates one Accounts Payable account for you. Most businesses need only one.";
                            }
                            if(DType=="Credit Card"){
                                document.getElementById('TypeDescriptionTextArea').value="Credit card accounts track the balance due on your business credit cards.\n\nCreate one Credit card account for each credit card account your business uses.";
                            }
                            if(DType=="Federal Income Tax Payable"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Federal income tax payable if your business keeps records on an accrual basis.\n\nThis account tracks income tax liabilities in the year the income is earned.";
                            }
                            if(DType=="Insurance Payable"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Insurance payable to keep track of insurance amounts due.\n\nThis account is most useful for businesses with monthly recurring insurance expenses.";
                            }
                            if(DType=="Other Current Liabilities"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Other current liabilities to track monies owed by the company and due within one year.";
                            }
                            if(DType=="Payroll Clearing"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Payroll clearing to keep track of any non-tax amounts that you have deducted from employee payroll payments or that you owe as a result of doing payroll. When you forward money to the appropriate suppliers, deduct the amount from the balance of this account.\n\nDo not use this account for tax amounts you have withheld or owe from paying employee wages. For those amounts, use the Payroll tax payable account instead.";
                            }
                            if(DType=="Payroll Tax Payable"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Payroll clearing to keep track of any non-tax amounts that you have deducted from employee payroll payments or that you owe as a result of doing payroll. When you forward money to the appropriate suppliers, deduct the amount from the balance of this account.\n\nDo not use this account for tax amounts you have withheld or owe from paying employee wages. For those amounts, use the Payroll tax payable account instead.";
                            }
                            if(DType=="Prepaid Expenses Payable"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Prepaid expenses payable to track items such as property taxes that are due, but not yet deductible as an expense because the period they cover has not yet passed.";
                            }
                            if(DType=="Rents in Trust-Liability"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Rents in trust - liability to offset the Rents in trust amount in assets.\n\nAmounts in these accounts are held by your business on behalf of others. They do not belong to your business, so should not appear to be yours on your balance sheet. This 'contra' account takes care of that, as long as the two balances match.";
                            }
                            if(DType=="Sales Tax Payable"){
                                document.getElementById('TypeDescriptionTextArea').value="";
                            }
                            if(DType=="State/Local Income Tax Payable"){
                                document.getElementById('TypeDescriptionTextArea').value="";
                            }
                            if(DType=="Trust Account-Liability"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Client Trust accounts - liabilities to offset Client Trust accounts in assets.\n\nAmounts in these accounts are held by your business on behalf of others. They do not belong to your business, so should not appear to be yours on your balance sheet. This 'contra' account takes care of that, as long as the two balances match.";
                            }
                            if(DType=="Line Of Credit"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Line of credit to track the balance due on any lines of credit your business has. Each line of credit your business has should have its own Line of credit account.";
                            }
                            if(DType=="Loan Payable"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Loan payable to track loans your business owes which are payable within the next twelve months.\n\nFor longer-term loans, use the Long-term liability called Notes payable, instead.";
                            }
                            if(DType=="Notes Payable"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Notes payable to track the amounts your business owes in long-term (over twelve months) loans.\n\nFor shorter loans, use the Current liability account type called Loan payable, instead.";
                            }
                            if(DType=="Other Long Term Liabilities"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Other non-current liabilities to track liabilities due in more than twelve months that don’t fit the other Non-Current liability account types.";
                            }
                            if(DType=="Shareholder Notes Payable"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Shareholder notes payable to track long-term loan balances your business owes its shareholders.";
                            }
                            if(DType=="Accumulated Adjustment"){
                                document.getElementById('TypeDescriptionTextArea').value="Some corporations use this account to track adjustments to owner’s equity that are not attributable to net income.";
                            }
                            if(DType=="Common Stock"){
                                document.getElementById('TypeDescriptionTextArea').value="";
                            }
                            if(DType=="Opening Balance Equity"){
                                document.getElementById('TypeDescriptionTextArea').value="";
                            }
                            if(DType=="Owner's Equity"){
                                document.getElementById('TypeDescriptionTextArea').value="Corporations use Owner’s equity to show the cumulative net income or loss of their business as of the beginning of the financial year.";
                            }
                            if(DType=="Paid-in Capital or Surplus"){
                                document.getElementById('TypeDescriptionTextArea').value="Corporations use Paid-in capital to track amounts received from shareholders in exchange for shares that are over and above the shares’ stated (or par) value.";
                            }
                            if(DType=="Partner Contribution"){
                                document.getElementById('TypeDescriptionTextArea').value="Partnerships use Partner contributions to track amounts partners contribute to the partnership during the year.";
                            }
                            if(DType=="Partner Distribution"){
                                document.getElementById('TypeDescriptionTextArea').value="Partnerships use Partner distributions to track amounts distributed by the partnership to its partners during the year.\n\nDon’t use this for regular payments to partners for interest or service. For regular payments, use a Guaranteed payments account (a Expense account in Payroll expenses), instead.";
                            }
                            if(DType=="Partner's Equity"){
                                document.getElementById('TypeDescriptionTextArea').value="Partnerships use Partner’s equity to show the income remaining in the partnership for each partner as of the end of the prior year.";
                            }
                            if(DType=="Preffered Stock"){
                                document.getElementById('TypeDescriptionTextArea').value="Corporations use this account to track its preferred shares in the hands of shareholders. The amount in this account should be the stated (or par) value of the shares.";
                            }
                            if(DType=="Retained Earnings"){
                                document.getElementById('TypeDescriptionTextArea').value="Retained earnings tracks net income from previous financial years.";
                            }
                            if(DType=="Treasury Stock"){
                                document.getElementById('TypeDescriptionTextArea').value="Corporations use Treasury shares to track amounts paid by the corporation to buy its own shares back from shareholders.";
                            }
                            if(DType=="Discounts/Refunds Given"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Discounts/refunds given to track discounts you give to customers.\n\nThis account typically has a negative balance so it offsets other income.\n\nFor discounts from suppliers, use an expense account, instead.";
                            }
                            if(DType=="Non-Profit Income"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Non-profit income to track money coming in if you are a non-profit organisation";
                            }
                            if(DType=="Other Primary Income"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Other primary income to track income from normal business operations that doesn’t fall into another Income type.";
                            }
                            if(DType=="Sales of Product Income"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Sales of product income to track income from selling products.\n\nThis can include all kinds of products, like crops and livestock, rental fees, performances, and food served.";
                            }
                            if(DType=="Service/Fee Income"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Service/fee income to track income from services you perform or ordinary usage fees you charge.\n\nFor fees customers pay you for late payments or other uncommon situations, use an Other Income account type called Other miscellaneous income, instead.";
                            }
                            if(DType=="Unapplied Cash Payment Income"){
                                document.getElementById('TypeDescriptionTextArea').value="Unapplied Cash Payment Income reports the Cash Basis income from customers payments you’ve received but not applied to invoices or charges. In general, you would never use this directly on a purchase or sale transaction.";
                            }
                            if(DType=="Cost of labor - COS"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Cost of labour - COS to track the cost of paying employees to produce products or supply services.\n\nIt includes all employment costs, including food and transportation, if applicable.";
                            }
                            if(DType=="Equipment Rental - COS"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Equipment rental - COS to track the cost of renting equipment to produce products or services.\n\nIf you purchase equipment, use a Fixed Asset account type called Machinery and equipment.";
                            }
                            if(DType=="Other Costs of Services - COS"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Other costs of sales - COS to track costs related to services or sales that you provide that don’t fall into another Cost of Sales type.";
                            }
                            if(DType=="Shipping, Freight & Delivery - COS"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Shipping, freight and delivery - COS to track the cost of shipping products to customers or distributors.";
                            }
                            if(DType=="Supplies & Materials - COGS"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Supplies and materials - COS to track the cost of raw goods and parts used or consumed when producing a product or providing a service.";
                            }
                            if(DType=="Advertising/Promotional"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Advertising/promotional to track money spent promoting your company.\n\nYou may want different accounts of this type to track different promotional efforts (Yellow Pages, newspaper, radio, flyers, events, and so on).\n\nIf the promotion effort is a meal, use Promotional meals instead.";
                            } 
                            if(DType=="Auto"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Auto to track costs associated with vehicles.\n\nYou may want different accounts of this type to track petrol, repairs, and maintenance.\n\nIf your business owns a car or lorry, you may want to track its value as a Fixed Asset, in addition to tracking its expenses.";
                            }
                            if(DType=="Bad Debts"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Bad debt to track debt you have written off.";
                            }
                            if(DType=="Bank Charges"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Bank charges for any fees you pay to financial institutions.";
                            }
                            if(DType=="Charitable Contributions"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Charitable contributions to track gifts to charity.";
                            }
                            if(DType=="Cost of Labor"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Cost of labour to track the cost of paying employees to produce products or supply services.\n\nIt includes all employment costs, including food and transportation, if applicable.\n\nThis account is also available as a Cost of Sales (COS) account.";
                            }
                            if(DType=="Dues and subscriptions"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Dues and subscriptions to track dues and subscriptions related to running your business.\n\nYou may want different accounts of this type for professional dues, fees for licences that can’t be transferred, magazines, newspapers, industry publications, or service subscriptions.";
                            }
                            if(DType=="Entertainment"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Entertainment to track events to entertain employees.\n\nIf the event is a meal, use Entertainment meals, instead.";
                            }
                            if(DType=="Entertainment Meals"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Entertainment to track events to entertain employees.\n\nIf the event is a meal, use Entertainment meals, instead.";
                            }
                            if(DType=="Entertainment Meals"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Equipment rental to track the cost of renting equipment to produce products or services.\n\nThis account is also available as a Cost of Sales account.\n\nIf you purchase equipment, use a Fixed asset account type called Machinery and equipment.";
                            }
                            if(DType=="Finance costs"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Finance costs to track the costs of obtaining loans or credit.\n\nExamples of finance costs would be credit card fees, interest and mortgage costs.";
                            }
                            if(DType=="Insurance"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Insurance to track insurance payments.\n\nYou may want different accounts of this type for different types of insurance (auto, general liability, and so on).";
                            }
                            if(DType=="Interest Paid"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Interest paid for all types of interest you pay, including mortgage interest, finance charges on credit cards, or interest on loans.";
                            }
                            if(DType=="Legal & Professional Fees"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Legal and professional fees to track money to pay to professionals to help you run your business.\n\nYou may want different accounts of this type for payments to your accountant, attorney, or other consultants.";
                            }
                            if(DType=="Office/General Administrative Expenses"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Office/general administrative expenses to track all types of general or office-related expenses.";
                            }
                            if(DType=="Other Miscellaneous Service Cost"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Other miscellaneous service cost to track costs related to providing services that don’t fall into another Expense type.\n\nThis account is also available as a Cost of Sales (COS) account.";
                            }
                            if(DType=="Payroll Expenses"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Payroll expenses to track payroll expenses. You may want different accounts of this type for things like:\n\nCompensation of officers\nGuaranteed payments\nWorkers\ncompensation\nSalaries and wages\nPayroll taxes";
                            }
                            if(DType=="Promotional Meals"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Promotional meals to track how much you spend dining with a customer to promote your business.\nBe sure to include who you ate with and the purpose of the meal when you enter the transaction.";
                            }
                            if(DType=="Rent or Lease of Buildings"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Rent or lease of buildings to track rent payments you make.";
                            }
                            if(DType=="Repair & Maintenance"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Repair and maintenance to track any repairs and periodic maintenance fees.\n\nYou may want different accounts of this type to track different types repair & maintenance expenses (auto, equipment, landscape, and so on).";
                            }
                            if(DType=="Shipping, Freight & Delivery"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Shipping, Freight and Delivery to track the cost of shipping products to customers or distributors.\n\nYou might use this type of account for incidental shipping expenses, and the COS type of Shipping, freight & delivery account for direct costs.\n\nThis account is also available as a Cost of Sales (COS) account.";
                            }
                            if(DType=="Supplies & Materials"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Supplies & materials to track the cost of raw goods and parts used or consumed when producing a product or providing a service.\n\nThis account is also available as a Cost of Sales account.";
                            }
                            if(DType=="Taxes Paid"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Taxes paid to track taxes you pay.\n\nYou may want different accounts of this type for payments to different tax agencies.";
                            }
                            if(DType=="Travel"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Travel to track travel costs.\n\nFor food you eat while travelling, use Travel meals, instead.";
                            }
                            if(DType=="Travel Meals"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Travel meals to track how much you spend on food while travelling.\n\nIf you dine with a customer to promote your business, use a Promotional meals account, instead.\n\nIf you dine with your employees to promote morale, use Entertainment meals, instead.";
                            }
                            if(DType=="Unapplied Cash Bill Payment Expense"){
                                document.getElementById('TypeDescriptionTextArea').value="Unapplied Cash Bill Payment Expense reports the Cash Basis expense from supplier payment cheques you’ve sent but not yet applied to supplier bills. In general, you would never use this directly on a purchase or sale transaction.";
                            }
                            if(DType=="Utilities"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Utilities to track utility payments.\n\nYou may want different accounts of this type to track different types of utility payments (gas and electric, telephone, water, and so on).";
                            }
                            if(DType=="Dividend Income"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Dividend income to track taxable dividends from investments.";
                            }
                            if(DType=="Interest Earned"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Interest earned to track interest from bank or savings accounts, investments, or interest payments to you on loans your business made.";
                            }
                            if(DType=="Other Investment Income"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Other investment income to track other types of investment income that isn’t from dividends or interest.";
                            }
                            if(DType=="Other Miscellaneous Income"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Other miscellaneous income to track income that isn’t from normal business operations, and doesn’t fall into another Other Income type.";
                            }
                            if(DType=="Tax-Exempt Interest"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Tax-exempt interest to record interest that isn’t taxable, such as interest on money in tax-exempt retirement accounts, or interest from tax-exempt bonds.";
                            }
                            if(DType=="Amortization"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Amortisation to track amortisation of intangible assets.\n\nAmortisation is spreading the cost of an intangible asset over its useful life, like depreciation of fixed assets.\n\nYou may want an amortisation account for each intangible asset you have.";
                            }
                            if(DType=="Depreciation"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Depreciation to track how much you depreciate fixed assets.You may want a depreciation account for each fixed asset you have.";
                            }
                            if(DType=="Exchange Gain or Loss"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Exchange Gain or Loss to track gains or losses that occur as a result of exchange rate fluctuations.";
                            }
                            if(DType=="Other Miscellaneous Expense"){
                                document.getElementById('TypeDescriptionTextArea').value="";
                            }
                            if(DType=="Penalties & Settlements"){
                                document.getElementById('TypeDescriptionTextArea').value="Use Penalties and settlements to track money you pay for violating laws or regulations, settling lawsuits, or other penalties.";
                            }
                            if(DType==""){
                                document.getElementById('TypeDescriptionTextArea').value=""; 
                            }
                            // company defined not included


                        }
                        
                    </script>
                    <div class="mb-3">
                        <p>Account Title</p>
                        <select id="coaDetailType" name="DetType" class="w-100 pt-1" onchange="ChangeTypeDesc()">
                            <option>Cash on hand</option>
                            <option>Checking</option>
                            <option>Money Market</option>
                            <option>Rents Held in Trust</option>
                            <option>Savings</option>
                            <option>Trust Account</option>
                        </select>
                        <input type="text" style="display:none;" class="w-100" name="customdetailtyep" id="customdetail"> 
                    </div>
                    <div class="mb-3">
                        <p>Description</p>
                        <textarea id="coaDesc" type="text" name="COADesc" class="w-100"></textarea>
                    </div>
                    <textarea style="display:none;" rows="7" id="TypeDescriptionTextArea" class="w-100 mt-3" readonly>Use a Cash on hand account to track cash your company keeps for occasional expenses, also called petty cash.\nTo track cash from sales that have not been deposited yet, use a pre-created account called Undeposited funds, instead.</textarea>
                </div>
                <div class="col-md-6 p-1">
                    <div class="mb-3" style="display:none;">
                        <p>Name</p>
                        <input id="coaName" name="COAName" type="text" value="Name" class="w-100">
                    </div>
                    
                    <div class="mb-3">
                            <p>Code</p>
                            <input id="coaCode" type="text" name="COACode" value="" class="w-100">
                        </div>
                        <div class="mb-3">
                            <p>Normal Balance</p>
                            <select id="coaNormalBalance" name="COANormalBalance" value="" class="w-100">
                                <option>Credit</option>
                                <option>Debit</option>
                            </select>
                            
            
                        </div>
                        
                    <div class="pt-2 mb-3" style="display:none;">
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="COASubAcc" class="custom-control-input" onclick="parentACC()" id="defaultUnchecked">
                            <script>
                                function parentACC(){
                                    var val=document.getElementById('defaultUnchecked').checked;
                                    
                                    if(val==true){
                                        document.getElementById('parentAcc').readOnly=false;
                                    }else{
                                        document.getElementById('parentAcc').value="";
                                        document.getElementById('parentAcc').readOnly=true;
                                    }
                                }
                            </script>
                            <label class="custom-control-label" for="defaultUnchecked">Is sub-account</label>
                        </div>
                        <input type="text" id="parentAcc" readonly name="COAParentAcc" placeholder="Enter parent account" class="w-100">
                    </div>
                    <div class="col-md-12 p-1" style="display:none;">
                        <p>Sub Account</p>
                        <select id="sub_accoinmt"name="sub_accoinmt"class="w-100">
                            <option></option>
                            <option>Bank</option>
                            <option>Cash on Hand</option>
                            <option>Receivable Accounts</option>
                            <option>Inventories</option>
                            <option >Prepayments</option>
                        </select>
                    </div>
                    <div class="col-md-6 p-1" style="display:none;">
                        <p>Balance</p>
                        <input id="coaBalance" type="number" name="COABalance" value="0" min="0" step="0.01" class="w-100">
                        
                    </div>
                    <div class="col-md-6 p-1" style="display:none;">
                        <p>as of</p>
                        <input type="date" name="COAAsof" class="w-100">
                    </div>
                    <div class="col-md-12 p-1" >
                        <p>Cost Center</p>
                        <select id="coa_cc"name="coa_cc"class="w-100 selectpicker" data-live-search="true" >
                            {!! $cc_list_after_foreach !!}
                        </select>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn rounded btn-secondary" data-dismiss="modal" value="Cancel">
                <input type="submit" class="btn rounded btn-success" id="coaadd" value="Save">
            </div>
            </form> 
        </div>
    </div>
</div>
<style>
.dt-body-center{
    vertical-align:middle !important;
}
</style>
<script>
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        function convertDate(date_str) {
        temp_date = date_str.split("-");
        return  months[Number(temp_date[1]) - 1] + " " + temp_date[2] + " " + temp_date[0];
        }
    var sales_table;
    var sales_table_invoice;
    var customers_table;
    var jounalentrytable;
    var productandservicestale;
    var expensetable;
    var suppliertable;
    var coatable;
    var reconciletable;
    var customertransactiontable;
    var suppliertransactiontable;
    var suppliertransactiontablecustomer;
    var customformstyletable;
    var check_register_table;
    var costcenterlisttable;
    var bill_payment_table;
    var table_pay_bills_modal_tabel;
    var table_pending_bill;
    var journalentrytable;
    var credit_note_accounts_table_main;
    var tableexpensebill_credit_account_table_body;
    var supplier_credit_debit_account_table;
    var chequeaccounts_receivepayment_table;
    var cash_account_receive_payment_table;
    $(document).ready(function(){
        if(document.getElementById('customertransactiontable')){
            customertransactiontable = $('#customertransactiontable').DataTable({
            order: [[ 1, "desc" ]], 
            
            });
        }
        if(document.getElementById('table_pending_bill')){
            table_pending_bill = $('#table_pending_bill').DataTable({
            order: [[ 1, "desc" ]],
            
            });
        }
        
        if(document.getElementById('table_pay_bills_modal_tabel')){
            table_pay_bills_modal_tabel = $('#table_pay_bills_modal_tabel').DataTable({
            order: [[ 9, "desc" ]],
            paging: false,
            "ordering": true,
            'dom': 'Rlfrtip',
            "autoWidth": false,
            rowReorder: true
            });
            table_pay_bills_modal_tabel.on( 'row-reorder', function ( e, diff, edit ) {
                //console.log("asdasdasd->>>> "+edit.triggerRow.data());
                var result = 'Reorder started on row: '+(edit.triggerRow.data())+'<br>';
                
                for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                    var rowData = table_pay_bills_modal_tabel.row( diff[i].node ).data();
                    result += rowData;
                    console.log(rowData[0]);
                    //result += rowData[1]+' updated to be in position '+
                    //    diff[i].newData+' (was '+diff[i].oldData+')<br>';
                }
            });
        }
        
        if(document.getElementById('bill_payment_table')){
            bill_payment_table = $('#bill_payment_table').DataTable({
            order: [[ 0, "desc" ]],
            
            });
        }
        
        // if(document.getElementById('check_register_table')){
        //     check_register_table = $('#check_register_table').DataTable({
        //     order: [[ 1, "desc" ]],
            
        //     });
        // }
        
        if(document.getElementById('customformstyletable')){
            customformstyletable = $('#customformstyletable').DataTable({
            order: [[ 0, "desc" ]],
            
            });
        }
        
        if(document.getElementById('suppliertransactiontable')){
            suppliertransactiontable = $('#suppliertransactiontable').DataTable({
            order: [[ 1, "desc" ]],
            
            });
        }
        if(document.getElementById('suppliertransactiontablecustomer')){
            suppliertransactiontablecustomer = $('#suppliertransactiontablecustomer').DataTable({
            
            });
        }
        
        if(document.getElementById('reconciletable')){
            reconciletable = $('#reconciletable').DataTable({
            
            order: [[ 3, "desc" ]],
            paging: true,
            ajax: "{{ route('refresh_sales_table_invoice2') }}",
            columnDefs: [{
                'targets': 0,
                'searchable':false,
                'orderable':false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){
                    return '<input type="checkbox" name="id[]" value="">';
                }
            }],
            columns: [{
                data: 'checkbox',
                orderable: false,
                searchable: false
            },
            {
                data: 'st_date'
            },
            {
                data: 'st_type'
            },
            {
                data: 'st_no'
            },
            {
                data: 'customer_name'
            },
            {
                data: 'st_due_date'
            },
            {
                data: 'customer_balance'
            },
            {
                data: 'transaction_total'
            },
            {
                data: 'st_status'
            },
            {
                data: "action",
                orderable: false,
                searchable: false
            }]
        });
        document.getElementById('reconciletable_info').style.display="none";
		document.getElementById('reconciletable_length').style.display="none";
        document.getElementById('reconciletable_filter').style.display="none";
        }
        
        coatable = $('#coatable').DataTable({
            "ordering": false,
            paging: false,
        });
        if(document.getElementById('coatable_info')){
            document.getElementById('coatable_info').style.display="none";
            document.getElementById('coatable_filter').style.display="none";
        }
        costcenterlisttable= $('#costcenterlisttable').DataTable({
            "ordering": false,
            paging: false,
            "columnDefs": [
                {
                    "targets": [ 5 ],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [ 6 ],
                    "visible": false
                },
                {
                    "targets": [ 7 ],
                    "visible": false
                },
                {
                    "targets": [ 8 ],
                    "visible": false
                },
                {
                    "targets": [ 9 ],
                    "visible": false
                },
                {
                    "targets": [ 10 ],
                    "visible": false
                },
                {
                    "targets": [ 11 ],
                    "visible": false
                },
                {
                    "targets": [ 12 ],
                    "visible": false
                },
                {
                    "targets": [ 13 ],
                    "visible": false
                },
                {
                    "targets": [ 14 ],
                    "visible": false
                },
                {
                    "targets": [ 15 ],
                    "visible": false
                },
                {
                    "targets": [ 16 ],
                    "visible": false
                }
            ]
        });
        if(document.getElementById('costcenterlisttable_info')){
            document.getElementById('costcenterlisttable_info').style.display="none";
            document.getElementById('costcenterlisttable_filter').style.display="none";
        }
        suppliertable = $('#suppliertable').DataTable({
            order: [[ 1, "desc" ]],
            
        });
        expensetable = $('#expensetable').DataTable({
            order: [[ 1, "desc" ]],
            
        });
        jounalentrytable = $('#jounalentrytable').DataTable({
            order: [[ 0, "desc" ]],
                paging: false,
                'dom': 'Rlfrtip',
                "columnDefs": [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                    }
                ]
            
        });
        journalentrytable = $('#journalentrytable').DataTable({
                paging: false,
                "ordering": true,
                'dom': 'Rlfrtip',
                "autoWidth": false,
                rowReorder: true,
                "columnDefs": [
                    { "width": "5%", "targets": 1 }
                ]
                
        });

        if(document.getElementById('journalentrytable_info')){
            document.getElementById('journalentrytable_info').style.display="none";
            document.getElementById('journalentrytable_filter').style.display="none";
        }
        credit_note_accounts_table_main = $('#credit_note_accounts_table_main').DataTable({
                paging: false,
                "ordering": false,
                'dom': 'Rlfrtip',
                "autoWidth": false
                
        });

        if(document.getElementById('credit_note_accounts_table_main_info')){
            document.getElementById('credit_note_accounts_table_main_info').style.display="none";
            document.getElementById('credit_note_accounts_table_main_filter').style.display="none";
        }
        tableexpensebill_credit_account_table_body = $('#tableexpensebill_credit_account_table').DataTable({
                paging: false,
                "ordering": false,
                'dom': 'Rlfrtip',
                "autoWidth": false
                
        });
        
        if(document.getElementById('tableexpensebill_credit_account_table_info')){
            document.getElementById('tableexpensebill_credit_account_table_info').style.display="none";
            document.getElementById('tableexpensebill_credit_account_table_filter').style.display="none";
        }
        supplier_credit_debit_account_table = $('#supplier_credit_debit_account_table').DataTable({
                paging: false,
                "ordering": false,
                'dom': 'Rlfrtip',
                "autoWidth": false
                
        });
        
        if(document.getElementById('supplier_credit_debit_account_table_info')){
            document.getElementById('supplier_credit_debit_account_table_info').style.display="none";
            document.getElementById('supplier_credit_debit_account_table_filter').style.display="none";
        }
        chequeaccounts_receivepayment_table = $('#chequeaccounts_receivepayment_table').DataTable({
                paging: false,
                "ordering": false,
                'dom': 'Rlfrtip',
                "autoWidth": false
                
        });
        
        if(document.getElementById('chequeaccounts_receivepayment_table_info')){
            document.getElementById('chequeaccounts_receivepayment_table_info').style.display="none";
            document.getElementById('chequeaccounts_receivepayment_table_filter').style.display="none";
        }
        cash_account_receive_payment_table = $('#cash_account_receive_payment_table').DataTable({
                paging: false,
                "ordering": false,
                'dom': 'Rlfrtip',
                "autoWidth": false
                
        });
        
        if(document.getElementById('cash_account_receive_payment_table_info')){
            document.getElementById('cash_account_receive_payment_table_info').style.display="none";
            document.getElementById('cash_account_receive_payment_table_filter').style.display="none";
        }
        
        if(document.getElementById('jounalentrytable_info')){
            document.getElementById('jounalentrytable_info').style.display="none";
            document.getElementById('jounalentrytable_filter').style.display="none";
        }
        //document.getElementById('jounalentrytable_info').style.display="none";
        productandservicestale = $('#productandservicestale').DataTable({
            order: [[ 1, "asc" ]],
            
        });
        customers_table = $('#customertable').DataTable({
            order: [[ 1, "desc" ]],
            paging: true,
            ajax: "{{ route('refresh_customers_table') }}",
            columnDefs: [{
                'targets': 0,
                'searchable':false,
                'orderable':false,
                'className': 'dt-body-left',
                'render': function (data, type, full, meta){
                    //console.log(full);
                    //return data;
                    if(full['display_name']!=""){
                        return "<a class='btn btn-link btn-sm' href='customerinfo/?customer_id="+full['customer_id']+"'>"+full['display_name']+"</a>";
                    }else{
                        return "<a class='btn btn-link btn-sm' href='customerinfo/?customer_id="+full['customer_id']+"'>"+full['f_name']+" "+full['l_name']+"</a>";
                    }
        
                }
            }],
            columns: [{
                data: 'display_name'
            },
            {
                data: 'phone'
            },
            {
                data: 'email'
            },
            {
                data: 'opening_balance'
            }
            ]
        });
        if(document.getElementById('customertable_info')){
            document.getElementById('customertable_info').style.display="none";
            document.getElementById('customertable_length').style.display="none";
            document.getElementById('customertable_filter').style.display="none";
            
        }
        
        sales_table = $('#salestable').DataTable({
            order: [[ 0, "desc" ]],
            paging: true,
            ajax: "{{ route('refresh_sales_table') }}",
            columnDefs: [{
                'targets': 9,
                'searchable':false,
                'orderable':false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){
                    if(data=="Cancelled" || data==""){
                        return data;
                    }else{
                        if(full['st_type']=="Invoice"){
                            @if(count($UserAccessList)>0)
                                @if( $UserAccessList[0]->invoice=="1")
                                
                                return '<button class="btn btn-xs btn-link" onclick="cancelentry('+data+')"><span class="fa fa-ban"></span></button>';
                                @else
                                return "";
                                @endif
                            @endif
                            
                        }
                        else if(full['st_type']=="Sales Receipt"){
                            @if(count($UserAccessList)>0)
                                @if($UserAccessList[0]->sales_receipt=="1")
                                
                                return '<button class="btn btn-xs btn-link" onclick="cancelentry('+data+')"><span class="fa fa-ban"></span></button>';
                                @else
                                return "";
                                @endif
                            @endif
                            
                        }
                        else if(full['st_type']=="Credit Note"){
                            @if(count($UserAccessList)>0)
                                @if($UserAccessList[0]->credit_note=="1")
                                
                                return '<button class="btn btn-xs btn-link" onclick="cancelentry('+data+')"><span class="fa fa-ban"></span></button>';
                                @else
                                return "";
                                @endif
                            @endif
                            
                            
                        }
                        else if(full['st_type']=="Estimate"){
                            @if(count($UserAccessList)>0)
                                @if($UserAccessList[0]->estimate=="1")
                                
                                return '<button class="btn btn-xs btn-link" onclick="cancelentry('+data+')"><span class="fa fa-ban"></span></button>';
                                @else
                                return "";
                                @endif
                            @endif
                            
                        }else{
                            return '<button class="btn btn-xs btn-link" onclick="cancelentry('+data+')"><span class="fa fa-ban"></span></button>';

                        }
                        
                        
                    }
                    
                }
            },
            {
                'targets': 4,
                'searchable':false,
                'orderable':false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){
                    
                    if(data=="N/A"){
                        return data;
                    }else{
                        //return data;
                        var d1 = new Date();
                        var d2 = new Date(data);
                        if(d1>=d2 && (full['st_status']=="Open" || full['st_status']=="Partially paid" ) && full['remark']!='Cancelled'){
                            
                            $(document).ready(function(){
                                var ro=meta.row+1;
                                    console.log("row "+ro);
                                // $(meta).addClass("table-danger");
                                if(ro>10){
                                    
                                    ro=ro-10;
                                }
                                var x = document.getElementById("salescolumn"+full['st_no']).parentElement;
                                    x.parentElement.className = "table-danger";
                               
                            });
                            return "<span title='overdue' id='salescolumn"+full['st_no']+"' style='color:red;'>"+data+"</span>";
                            
                        }else{
                            return data;
                        }
                        
                    }
                    
                }
            }],
            
            columns: [{
                            data: 'st_date'
                        },
                        {
                            data: 'st_type'
                        },
                        {
                            data: 'st_no'
                        },
                        {
                            data: 'customer_name'
                        },
                        {
                            data: 'st_due_date'
                        },
                        {
                            data: 'customer_balance'
                        },
                        {
                            data: 'transaction_total'
                        },
                        {
                            data: 'st_status'
                        },
                        {
                            data: "action",
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: "checkbox",
                            orderable: false,
                            searchable: false
                        }
                    ]
        });
        document.getElementById('salestable_info').style.display="none";
		
        sales_table_invoice = $('#salestableinvoice').DataTable({
            order: [[ 3, "desc" ]],
            paging: true,
            ajax: "{{ route('refresh_sales_table_invoice') }}",
            columnDefs: [{
                'targets': 0,
                'searchable':false,
                'orderable':false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){
                    return '<input type="checkbox" name="id[]" value="">';
                }
            }],
            columns: [{
                            data: 'checkbox',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'st_date'
                        },
                        {
                            data: 'st_type'
                        },
                        {
                            data: 'st_no'
                        },
                        {
                            data: 'customer_name'
                        },
                        {
                            data: 'st_due_date'
                        },
                        {
                            data: 'customer_balance'
                        },
                        {
                            data: 'transaction_total'
                        },
                        {
                            data: 'st_status'
                        },
                        {
                            data: "action",
                            orderable: false,
                            searchable: false
                    }]
        });
        if(document.getElementById('salestableinvoice_info')){
            document.getElementById('salestableinvoice_info').style.display="none";
            document.getElementById('salestableinvoice_length').style.display="none";
            document.getElementById('salestableinvoice_filter').style.display="none";
        }
        
        
    });  
    
    function number_format(number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
    
    function addCustomer(){

        $.ajax({
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('add_customer') }}",
            dataType: "text",
            data: $('#add_customer_form').serialize(),
            success: function (data) {
                swal("Done!", "Added customer", "success");
                $('#add_customer_form')[0].reset();
                customers_table.ajax.reload();
                SaveInformation();
            },
            error: function (data) {
                swal("Error!", "Customer data failed", "error");
            }
        });
    }
    function addSupplier(){
        $.ajax({
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ action('SuppliersController@store') }}",
            dataType: "text",
            data: $('#add_supplier_form').serialize(),
            success: function (data) {
                swal("Done!", "Added Supplier", "success");
                $('#add_supplier_form')[0].reset();
                
            },
            error: function (data) {
                alert(data.responseText);
                swal("Error!", "Supplier data failed", "error");
            }
        }); 
    }
    function editInvoice(){
        $('#total_balance_edit').val($('#invoicetotal_edit').text());
        $(".invoice_lines_edit").each(function() {
            $("#product_count_edit").val(parseFloat($("#product_count_edit").val())+1);
        });
        var counter = 0;
        var checker = 0;
        $(".invoice_lines_edit").find('.invoice_data_edit').each(function() {
            var id = $(this).attr("id");
            var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
            
            $(this).attr("name", name+counter);
            
            checker++;
            if(checker%4==0){
                counter++;
            }
        });
        $.ajax({
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('update_invoice_edit') }}",
            dataType: "text",
            data: $('#edit_invoice_form').serialize(),
            success: function (data) {
                swal("Done!", "Updated invoice", "success");
                $("#product_count").val('0');
                checker = 0;
                counter = 0;
                $('#edit_invoice_form')[0].reset();
                $('.invoice_lines_edit').remove();
                $('#sales_transaction_number_estimate_edit').val('0');
                $('#sales_transaction_number_delayed_charge_edit').val('0');
                sales_table.ajax.reload();
                sales_table_invoice.ajax.reload();
            },
            error: function (data) {
                alert(data.responseText);
                swal("Error!", "Invoice failed", "error");
            }
        });
    }
    
    function addInvoice(){

        $('#total_balance').val($('#invoicetotal').attr('title'));
           
        $(".invoice_lines").each(function() {
            $("#product_count").val(parseFloat($("#product_count").val())+1);
        });
        
        var counter = 0;
        var checker = 0;

        $(".invoice_lines").find('.invoice_data').each(function() {
            console.log("invoice data id : "+$(this).attr("id"));
            if( typeof( $(this).attr('id') ) != 'undefined' ) {
                var id = $(this).attr("id");
                var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
                console.log("name : "+name+counter);
                $(this).attr("name", name+counter);
                
                checker++;
                if(checker%4==0){
                    counter++;
                }
            }
            
        });

       
        $.ajax({
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('add_invoice') }}",
            dataType: "text",
            data: $('#add_invoice_form').serialize(),
            success: function (data) {
                console.log(data);
                //swal("Done!", "", "success");
                swal({title: "Done!", text:"Added invoice", type: 
                    "success"}).then(function(){
                   
                    location.reload();                                    
                    });
                $("#product_count").val('0');
                checker = 0;
                counter = 0;
                $('#add_invoice_form')[0].reset();
                $('.invoice_lines').remove();
                $('#sales_transaction_number_estimate').val('0');
                $('#sales_transaction_number_delayed_charge').val('0');
                sales_table.ajax.reload();
                sales_table_invoice.ajax.reload();
            },
            error: function (data) {
                alert(data.responseText);
                swal("Error!", "Invoice failed", "error");
            }
        });
        
    }

    function addPayment(){
                
        $.ajax({
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('add_payment') }}",
            dataType: "text",
            data: $('#add_payment_form').serialize(),
            success: function (data) {
                swal("Done!", "Added payment", "success");
                $('#add_payment_form')[0].reset();
                sales_table.ajax.reload();
                sales_table_invoice.ajax.reload();
                
            },
            error: function (data) {
                alert(data.responseText);
                swal("Error!", "Payment failed", "error");
            }
        });
                
    }

    function addEstimate(){

        $('#total_balance_estimate').val($('#estimatetotal').attr('title'));
        
        $(".estimate_lines").each(function() {
            $("#product_count_estimate").val(parseFloat($("#product_count_estimate").val())+1);
        });

        var counter = 0;
        var checker = 0;

        $(".estimate_lines").find('.estimate_data').each(function() {
            if( typeof( $(this).attr('id') ) != 'undefined' ){
                var id = $(this).attr("id");
                var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
                
                $(this).attr("name", name+counter);
                
                checker++;
                if(checker%4==0){
                    counter++;
                }
            }
        });


        $.ajax({
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('add_estimate') }}",
            dataType: "text",
            data: $('#add_estimate_form').serialize(),
            success: function (data) {
                console.log(data);
                swal("Done!", "Added estimate", "success");
                $("#product_count_estimate").val('0');
                checker = 0;
                counter = 0;
                $('#add_estimate_form')[0].reset();
                $('.estimate_lines').remove();
                
                sales_table.ajax.reload();
                sales_table_invoice.ajax.reload();
            },
            error: function (data) {
                swal("Error!", "Estimate failed", "error");
            }
        });

    }

    function addSalesReceipt(){
        $("#add_sales_receipt_form :input").prop("disabled", false);
        document.getElementById('salesrcustomer').disabled=false;
        document.getElementById('CostCenterSalesReceipt').disabled=false;
        $('#total_balance_sales_receipt').val($('#sales_receipttotal').attr('title'));
        
        var amountreceived_sr=document.getElementById('amountreceived_sr').value;
        var totalpayments=parseFloat(amountreceived_sr);
        
        
        console.log(totalpayments+" "+$('#big_sales_receiptbalance').attr('title'));
        if(totalpayments<=parseFloat($('#big_sales_receiptbalance').attr('title'))){
            var sales_receipt_debit=document.getElementById('hiddentotaldebitamountsalesreceipt').value;
            var sales_receipt_credit=document.getElementById('hiddentotalcredtiamountsalesreceipt').value;
            if(sales_receipt_debit==sales_receipt_credit){
                console.log(totalpayments+" totalpayments");
                $(".sales_receipt_lines").each(function() {
                    $("#product_count_sales_receipt").val(parseFloat($("#product_count_sales_receipt").val())+1);
                });

                
                var counter = 0;
                var checker = 0;

                $(".sales_receipt_lines").find('.sales_receipt_data').each(function() {
                    if( typeof( $(this).attr('id') ) != 'undefined' ) {
                    var id = $(this).attr("id");
                    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
                    
                    $(this).attr("name", name+counter);
                    
                    checker++;
                    if(checker%4==0){
                        counter++;
                    }
                    }
                });
                
                
                $.ajax({
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('add_sales_receipt') }}",
                    dataType: "text",
                    data: $('#add_sales_receipt_form').serialize(),
                    success: function (data) {
                        console.log(data);
                        document.getElementById('salesrcustomer').disabled=false;
                        document.getElementById('CostCenterSalesReceipt').disabled=false;
                        //swal("Done!", "Added sales receipt", "success");
                        swal({title: "Done!", text:"Added sales receipt", type: 
                        "success"}).then(function(){
                    
                        location.reload();                                    
                        });
                        if(document.getElementById('reload_sr').value=="1"){
                            setSalesReceiptinJournalEntry($("#product_count_sales_receipt").val(),data,"Sales Receipt",$("#CostCenterSalesReceipt").val());
                        }else{
                            $("#product_count_sales_receipt").val('0');
                            checker = 0;
                            counter = 0;
                            $('#add_sales_receipt_form')[0].reset();
                            $('.sales_receipt_lines').remove();
                            
                            sales_table.ajax.reload();
                            sales_table_invoice.ajax.reload();
                        }
                        
                        
                    },
                    error: function (data) {
                        document.getElementById('salesrcustomer').disabled=false;
                        document.getElementById('CostCenterSalesReceipt').disabled=false;
                        swal("Error!", "Sales receipt failed", "error");
                    }
                });
            }else{
                swal("Error!", "Account Debit and Credit not Balanced", "error");
            }
            
        
        }else{
            swal("Error!", "Amount Exceed Total Balance", "error");
            
        }
        

    }

    function addRefundReceipt(){

        $('#total_balance_refund_receipt').val($('#refund_receipttotal').text());

        $(".refund_receipt_lines").each(function() {
            $("#product_count_refund_receipt").val(parseFloat($("#product_count_refund_receipt").val())+1);
        });

        var counter = 0;
        var checker = 0;

        $(".refund_receipt_lines").find('.refund_receipt_data').each(function() {
            var id = $(this).attr("id");
            var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
            
            $(this).attr("name", name+counter);
            
            checker++;
            if(checker%4==0){
                counter++;
            }
        });


        $.ajax({
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('add_refund_receipt') }}",
            dataType: "text",
            data: $('#add_refund_receipt_form').serialize(),
            success: function (data) {
                swal("Done!", "Added refund receipt", "success");
                $("#product_count_refund_receipt").val('0');
                checker = 0;
                counter = 0;
                $('#add_refund_receipt_form')[0].reset();
                $('.refund_receipt_lines').remove();
                
                sales_table.ajax.reload();
                sales_table_invoice.ajax.reload();
            },
            error: function (data) {
                swal("Error!", "Refund receipt failed", "error");
            }
        });

    }

    function addDelayedCharge(){

        $('#total_balance_delayed_charge').val($('#delayed_chargetotal').text());

        $(".delayed_charge_lines").each(function() {
            $("#product_count_delayed_charge").val(parseFloat($("#product_count_delayed_charge").val())+1);
        });

        var counter = 0;
        var checker = 0;

        $(".delayed_charge_lines").find('.delayed_charge_data').each(function() {
            var id = $(this).attr("id");
            var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
            
            $(this).attr("name", name+counter);
            
            checker++;
            if(checker%4==0){
                counter++;
            }
        });


        $.ajax({
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('add_delayed_charge') }}",
            dataType: "text",
            data: $('#add_delayed_charge_form').serialize(),
            success: function (data) {
                swal("Done!", "Added delayed charge", "success");
                $("#product_count_delayed_charge").val('0');
                checker = 0;
                counter = 0;
                $('#add_delayed_charge_form')[0].reset();
                $('.delayed_charge_lines').remove();
                
                sales_table.ajax.reload();
                sales_table_invoice.ajax.reload();
            },
            error: function (data) {
                swal("Error!", "Delayed charge failed", "error");
            }
        });

    }

    function addDelayedCredit(){

    $('#total_balance_delayed_credit').val($('#delayed_credittotal').text());

    $(".delayed_credit_lines").each(function() {
        $("#product_count_delayed_credit").val(parseFloat($("#product_count_delayed_credit").val())+1);
    });

    var counter = 0;
    var checker = 0;

    $(".delayed_credit_lines").find('.delayed_credit_data').each(function() {
        var id = $(this).attr("id");
        var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
        
        $(this).attr("name", name+counter);
        
        checker++;
        if(checker%4==0){
            counter++;
        }
    });


    $.ajax({
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('add_delayed_credit') }}",
        dataType: "text",
        data: $('#add_delayed_credit_form').serialize(),
        success: function (data) {
            swal("Done!", "Added delayed credit", "success");
            $("#product_count_delayed_credit").val('0');
            checker = 0;
            counter = 0;
            $('#add_delayed_credit_form')[0].reset();
            $('.delayed_credit_lines').remove();
            
            sales_table.ajax.reload();
            sales_table_invoice.ajax.reload();
        },
        error: function (data) {
            swal("Error!", "Delayed credit failed", "error");
        }
    });

    }

    function addCreditNote(){

        $('#total_balance_credit_note').val($('#credit_notetotal').attr('title'));

        $(".credit_note_lines").each(function() {
            $("#product_count_credit_note").val(parseFloat($("#product_count_credit_note").val())+1);
        });

        var counter = 0;
        var checker = 0;

        $(".credit_note_lines").find('.credit_note_data').each(function() {
            var id = $(this).attr("id");
            var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
            
            $(this).attr("name", name+counter);
            
            checker++;
            if(checker%4==0){
                counter++;
            }
        });


        $.ajax({
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('add_credit_note') }}",
            dataType: "text",
            data: $('#add_credit_note_form').serialize(),
            success: function (data) {
                console.log('Credit Note Value is : '+data);
                swal({title: "Done!", text:"Added credit note", type: 
                    "success"}).then(function(){
                   
                    location.reload();                                    
                    });
                //swal("Done!", "Added credit note", "success");
                $("#product_count_credit_note").val('0');
                checker = 0;
                counter = 0;
                $('#add_credit_note_form')[0].reset();
                $('.credit_note_lines').remove();
                
                sales_table.ajax.reload();
                sales_table_invoice.ajax.reload();
            },
            error: function (data) {
                swal("Error!", "Credit note failed", "error");
            }
        });

    }

function addExpense(){

    //$('#total_balance').val($('#invoicetotal').text());
    
    $(".expense_lines_item").each(function() {
        $("#item_count_expenses").val(parseFloat($("#item_count_expenses").val())+1);
    });

    $(".expense_lines_account").each(function() {
        $("#account_count_expenses_add").val(parseFloat($("#account_count_expenses_add").val())+1);
    });

    var counter = 0;
    var checker = 0;

    var counter1 = 0;
    var checker1 = 0;

    $(".expense_lines_item").find('.expense_data').each(function() {
        var id = $(this).attr("id");
        var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
        
        $(this).attr("name", name+counter);
        
        checker++;
        if(checker%4==0){
            counter++;
        }
    });

    $(".expense_lines_account").find('.expense_data').each(function() {
        var id = $(this).attr("id");
        var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
        
        $(this).attr("name", name+counter1);
        
        checker1++;
        if(checker1%3==0){
            counter1++;
        }
    });


    $.ajax({
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('add_expense') }}",
        dataType: "text",
        data: $('#add_expense_form').serialize(),
        success: function (data) {
            console.log(data);
            swal("Done!", "Added expense", "success");
            //$('#Vouhcermooodall').click();
            $("#item_count_expenses").val('0');
            $("#account_count_expenses").val('0');
            checker = 0;
            counter = 0;
            $('#add_expense_form')[0].reset();
            $('.expense_lines_item').remove();
            $('.expense_lines_account').remove();
            sales_table.ajax.reload();
            sales_table_invoice.ajax.reload();
            
        },
        error: function (data) {
            alert(data.responseText);
            swal("Error!", "Expense failed", "error");
        }
    });

}

function addCheque(){

    //$('#total_balance').val($('#invoicetotal').text());

    $(".cheque_lines_item").each(function() {
        $("#item_count_cheques").val(parseFloat($("#item_count_cheques").val())+1);
    });

    $(".cheque_lines_account").each(function() {
        $("#account_count_cheques").val(parseFloat($("#account_count_cheques").val())+1);
    });

    var counter = 0;
    var checker = 0;

    var counter1 = 0;
    var checker1 = 0;

    $(".cheque_lines_item").find('.cheque_data').each(function() {
        var id = $(this).attr("id");
        var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
        
        $(this).attr("name", name+counter);
        
        checker++;
        if(checker%4==0){
            counter++;
        }
    });

    $(".cheque_lines_account").find('.cheque_data').each(function() {
        var id = $(this).attr("id");
        var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
        
        $(this).attr("name", name+counter1);
        
        checker1++;
        if(checker1%3==0){
            counter1++;
        }
    });


    $.ajax({
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('add_cheque') }}",
        dataType: "text",
        data: $('#add_cheque_form').serialize(),
        success: function (data) {
            swal("Done!", "Added cheque", "success");
            //$('#Vouhcermooodall').click();
            $("#item_count_cheques").val('0');
            $("#account_count_cheques").val('0');
            checker = 0;
            counter = 0;
            $('#add_cheque_form')[0].reset();
            $('.cheque_lines_item').remove();
            $('.cheque_lines_account').remove();
            sales_table.ajax.reload();
            sales_table_invoice.ajax.reload();
            
        },
        error: function (data) {
            alert(data.responseText);
            swal("Error!", "Cheque failed", "error");
        }
    });

}

function addBill(){

//$('#total_balance').val($('#invoicetotal').text());

$(".bill_lines_item").each(function() {
    $("#item_count_bills").val(parseFloat($("#item_count_bills").val())+1);
});

$(".bill_lines_account").each(function() {
    $("#account_count_bills").val(parseFloat($("#account_count_bills").val())+1);
});

var counter = 0;
var checker = 0;

var counter1 = 0;
var checker1 = 0;

$(".bill_lines_item").find('.bill_data').each(function() {
    if( typeof( $(this).attr('id') ) != 'undefined' ) {
    var id = $(this).attr("id");
    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
    
    $(this).attr("name", name+counter);
    
    checker++;
    if(checker%4==0){
        counter++;
    }
}
});

$(".bill_lines_account").find('.bill_data').each(function() {
    if( typeof( $(this).attr('id') ) != 'undefined' ) {
    var id = $(this).attr("id");
    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
    console.log(name);
    $(this).attr("name", name+counter1);
    
    checker1++;
    if(checker1%3==0){
        counter1++;
    }
}
});


$.ajax({
    method: "POST",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{ route('add_bill') }}",
    dataType: "text",
    data: $('#add_bill_form').serialize(),
    success: function (data) {
        swal({title: "Done!", text:"Added bill", type: 
                    "success"}).then(function(){
                   
                    location.reload();                                    
                    });
        // swal("Done!", "Added bill", "success");
        // //$('#Vouhcermooodall').click();
        // location.reload(); 
        $("#item_count_bills").val('0');
        $("#account_count_bills").val('0');
        checker = 0;
        counter = 0;
        $('#add_bill_form')[0].reset();
        $('.bill_lines_item').remove();
        $('.bill_lines_account').remove();
        sales_table.ajax.reload();
        sales_table_invoice.ajax.reload();
        
    },
    error: function (data) {
        alert(data.responseText);
        swal("Error!", "Bill failed", "error");
    }
});

}

function addPurchaseOrder(){

//$('#total_balance').val($('#invoicetotal').text());

$(".po_lines_item").each(function() {
    $("#item_count_pos").val(parseFloat($("#item_count_pos").val())+1);
});

$(".po_lines_account").each(function() {
    $("#account_count_pos").val(parseFloat($("#account_count_pos").val())+1);
});

var counter = 0;
var checker = 0;

var counter1 = 0;
var checker1 = 0;

$(".po_lines_item").find('.po_data').each(function() {
    var id = $(this).attr("id");
    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
    
    $(this).attr("name", name+counter);
    
    checker++;
    if(checker%4==0){
        counter++;
    }
});

$(".po_lines_account").find('.po_data').each(function() {
    var id = $(this).attr("id");
    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
    
    $(this).attr("name", name+counter1);
    
    checker1++;
    if(checker1%3==0){
        counter1++;
    }
});


$.ajax({
    method: "POST",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{ route('add_purchase_order') }}",
    dataType: "text",
    data: $('#add_purchase_order_form').serialize(),
    success: function (data) {
        swal("Done!", "Added purchase order", "success");
        $("#item_count_pos").val('0');
        $("#account_count_pos").val('0');
        checker = 0;
        counter = 0;
        $('#add_purchase_order_form')[0].reset();
        $('.po_lines_item').remove();
        $('.po_lines_account').remove();
        sales_table.ajax.reload();
        sales_table_invoice.ajax.reload();
    },
    error: function (data) {
        swal("Error!", "Purchase order failed", "error");
    }
});

}

function addSupplierCredit(){
    $("#add_supplier_credit_form :input").prop("disabled", false);

//$('#total_balance').val($('#invoicetotal').text());

$(".sc_lines_item").each(function() {
    $("#item_count_scs").val(parseFloat($("#item_count_scs").val())+1);
});

$(".sc_lines_account").each(function() {
    $("#account_count_scs").val(parseFloat($("#account_count_scs").val())+1);
});

var counter = 0;
var checker = 0;

var counter1 = 1;
var checker1 = 0;

$(".sc_lines_item").find('.sc_data').each(function() {
    if( typeof( $(this).attr('id') ) != 'undefined' ) {
    var id = $(this).attr("id");
    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
    
    $(this).attr("name", name+counter);
    
    checker++;
    if(checker%4==0){
        counter++;
    }
}
});

$(".sc_lines_account").find('.sc_data').each(function() {
    if( typeof( $(this).attr('id') ) != 'undefined' ) {
    var id = $(this).attr("id");
    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
    
    $(this).attr("name", name+counter1);
    
    checker1++;
    if(checker1%3==0){
        counter1++;
    }
    }
});


$.ajax({
    method: "POST",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{ route('add_supplier_credit') }}",
    dataType: "text",
    data: $('#add_supplier_credit_form').serialize(),
    success: function (data) {
        console.log(data);
        swal("Done!", "Added supplier credit", "success");
        //$('#Vouhcermooodall').click();
        // $("#item_count_scs").val('0');
        // $("#account_count_scs").val('0');
        // checker = 0;
        // counter = 0;
        // $('#add_supplier_credit_form')[0].reset();
        // $('.sc_lines_item').remove();
        // $('.sc_lines_account').remove();
        // sales_table.ajax.reload();
        // sales_table_invoice.ajax.reload();
        location.reload();
        $("#add_supplier_credit_form :input").prop("disabled", true);
        document.getElementById('sc_memo').disabled=false;
        location.reload();
    },
    error: function (data) {
        alert(data.responseText);
        swal("Error!", "Supplier credit failed", "error");
    }
});

}

function addCardCredit(){

//$('#total_balance').val($('#invoicetotal').text());

$(".cc_lines_item").each(function() {
    $("#item_count_ccs").val(parseFloat($("#item_count_ccs").val())+1);
});

$(".cc_lines_account").each(function() {
    $("#account_count_ccs").val(parseFloat($("#account_count_ccs").val())+1);
});

var counter = 0;
var checker = 0;

var counter1 = 0;
var checker1 = 0;

$(".cc_lines_item").find('.cc_data').each(function() {
    var id = $(this).attr("id");
    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
    
    $(this).attr("name", name+counter);
    
    checker++;
    if(checker%4==0){
        counter++;
    }
});

$(".cc_lines_account").find('.cc_data').each(function() {
    var id = $(this).attr("id");
    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
    
    $(this).attr("name", name+counter1);
    
    checker1++;
    if(checker1%3==0){
        counter1++;
    }
});


$.ajax({
    method: "POST",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{ route('add_card_credit') }}",
    dataType: "text",
    data: $('#add_card_credit_form').serialize(),
    success: function (data) {
        swal("Done!", "Added credit card Charge", "success");
        $("#item_count_ccs").val('0');
        $("#account_count_ccs").val('0');
        checker = 0;
        counter = 0;
        $('#add_card_credit_form')[0].reset();
        $('.cc_lines_item').remove();
        $('.cc_lines_account').remove();
        sales_table.ajax.reload();
        sales_table_invoice.ajax.reload();
    },
    error: function (data) {
        
        swal("Error!", "Credit card Charge failed", "error");
    }
});

}
   function addCardCredit(){

//$('#total_balance').val($('#invoicetotal').text());

$(".cc_lines_item").each(function() {
    $("#item_count_ccs").val(parseFloat($("#item_count_ccs").val())+1);
});

$(".cc_lines_account").each(function() {
    $("#account_count_ccs").val(parseFloat($("#account_count_ccs").val())+1);
});

var counter = 0;
var checker = 0;

var counter1 = 0;
var checker1 = 0;

$(".cc_lines_item").find('.cc_data').each(function() {
    var id = $(this).attr("id");
    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
    
    $(this).attr("name", name+counter);
    
    checker++;
    if(checker%4==0){
        counter++;
    }
});

$(".cc_lines_account").find('.cc_data').each(function() {
    var id = $(this).attr("id");
    var name = id.replace(id.match(/(\d+)/g)[0], '').trim();  
    
    $(this).attr("name", name+counter1);
    
    checker1++;
    if(checker1%3==0){
        counter1++;
    }
});


$.ajax({
    method: "POST",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "{{ route('add_card_credit') }}",
    dataType: "text",
    data: $('#add_card_credit_form').serialize(),
    success: function (data) {
        swal("Done!", "Added credit card Charge", "success");
        $("#item_count_ccs").val('0');
        $("#account_count_ccs").val('0');
        checker = 0;
        counter = 0;
        $('#add_card_credit_form')[0].reset();
        $('.cc_lines_item').remove();
        $('.cc_lines_account').remove();
        sales_table.ajax.reload();
        sales_table_invoice.ajax.reload();
    },
    error: function (data) {
        
        swal("Error!", "Credit card Charge failed", "error");
    }
});

}

</script>


<script>
function removeComma(str){
    return str.replace(/,/g, '').trim();
}
    $(document).ready(function(){
    
        $("#suppliercadd").click(function(){
            
            var suppliercpayee = $("#suppliercpayee").val();
            
    
            // var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + name + "</td><td>" + subject + "</td></tr>";
    
            var markup = "<tr><td class='pt-3-half' contenteditable='true'><input type='checkbox' name=''></td><td class='pt-3-half' contenteditable='true'>7/26/2018</td><td class='pt-3-half' contenteditable='true'>Cheque</td><td class='pt-3-half' contenteditable='true'>1001</td><td class='pt-3-half' contenteditable='true'>"+suppliercpayee+"</td><td class='pt-3-half' contenteditable='true'><select><option>Bad Debts</option></select></td><td class='pt-3-half' contenteditable='true'>PHP 2,000.00</td><td><span class='table-add mb-3 mr-2'><a href='#!' class='text-info'><i aria-hidden='true'>Receive Payment</i></a></span></td></tr>";
    
        $("#expensetable").append(markup);
    
     });         
    });    
</script>



<script>
    function addlinesales_receipt_edit(){
            //alert('add line');
            var markup = '<tr class="sales_receipt_lines_edit" id="sales_receipt_line_edit'+$('#sales_receipt_table_edit tr').length+'"><td class="pt-3-half" id="number_tag_edit" contenteditable="false">'+$('#sales_receipt_table_edit tr').length+'</td><td class="pt-3-half"><select name="sales_receipt_EditProductName'+$('#sales_receipt_table_edit tr').length+'" onchange="GetProductAll('+$('#sales_receipt_table_edit tr').length+'),GetProductRate('+$('#sales_receipt_table_edit tr').length+')" style="border:0; width:100%;" class="sales_receipt_data product_select" id="select_product_name_edit'+$('#sales_receipt_table_edit tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input name="sales_receipt_EditProductDesc'+$('#sales_receipt_table_edit tr').length+'" class="sales_receipt_data product_description" id="select_product_description_edit'+$('#sales_receipt_table_edit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="hidden" name="sales_receipt_EditST_I_id'+$('#sales_receipt_table_edit tr').length+'" class="sales_receipt_data_edit product_description" id="sales_receipt_EditST_I_id'+$('#sales_receipt_table_edit tr').length+'" value="" style="border:0;"><input name="sales_receipt_EditProductQty'+$('#sales_receipt_table_edit tr').length+'" type="number" onchange="GetProductAll('+$('#sales_receipt_table_edit tr').length+')" class="sales_receipt_data product_qty" onclick="this.select();" id="product_qty_edit'+$('#sales_receipt_table_edit tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input name="sales_receipt_EditProductRate'+$('#sales_receipt_table_edit tr').length+'" class="sales_receipt_data product_rate" onchange="GetProductAll('+$('#sales_receipt_table_edit tr').length+')" readonly id="select_product_rate_edit'+$('#sales_receipt_table_edit tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_edit" id="total_amount_edit'+$('#sales_receipt_table_edit tr').length+'"></td><td class="pt-3-half"></td></tr>';
            
            $("#sales_receipt_table_edit").append(markup); 
            var count=document.getElementById('columncounteditsales_receipt_').value;
            count++;
            document.getElementById('columncounteditsales_receipt_').value=count;
        }
    function addlineinvoiceedit(){
            //alert('add line');
            var markup = '<tr class="invoice_lines_edit" id="invoice_line_edit'+$('#invoice_table_edit tr').length+'"><td class="pt-3-half" id="number_tag_edit" contenteditable="false">'+$('#invoice_table_edit tr').length+'</td>';
            markup=markup+'<td class="pt-3-half">';
            markup=markup+'<select onchange="ChangeParticularInvoiceEdit(this)" id="ParticularInvoiceEdit'+$('#invoice_table_edit tr').length+'" data-columncount="'+$('#invoice_table_edit tr').length+'" class="w-100 form-control invoice_particularEdit"><option>Cost Center</option><option>Product/Service</option></select>';   

            markup=markup+'</td>';
            markup=markup+'<td class="pt-3-half">';
            markup=markup+'<div class="ProductServicesInvoiceItemDivClassEdit" id="ProductServicesInvoiceItemDivEdit'+$('#invoice_table_edit tr').length+'" style="display:none;">';
            markup=markup+'<select name="InvoiceEditProductName'+$('#invoice_table_edit tr').length+'" onchange="GetProductAll('+$('#invoice_table_edit tr').length+'),GetProductRate('+$('#invoice_table_edit tr').length+')" style="border:0; width:100%;" class="invoice_data product_select selectpicker" data-live-search="true" id="select_product_name_edit'+$('#invoice_table_edit tr').length+'"><option value="">--Select Product/Services--</option>'+product_list_js+'</select>';
            markup=markup+'</div>';
            markup=markup+'<div class="CostCenterInvoiceItemDivClassEdit" id="CostCenterInvoiceItemDivClassEdit'+$('#invoice_table_edit tr').length+'">';

            markup=markup+'<select class="selectpicker" data-live-search="true" name="CostCenterInvoiceEdit'+$('#invoice_table_edit tr').length+'" id="CostCenterInvoiceEdit'+$('#invoice_table_edit tr').length+'"><option value="">--Select Cost Center--</option>@foreach($cost_center_list as $product)<option value="{{$product->cc_no}}">{{trim(preg_replace("/\s\s+/", " ", $product->cc_name))}}</option>@endforeach';
            
            markup=markup+'</select>';
            markup=markup+'</div>';
            markup=markup+'</td><td class="pt-3-half"><textarea name="InvoiceEditProductDesc'+$('#invoice_table_edit tr').length+'" class="invoice_data product_description w-100 form-control" id="select_product_description_edit'+$('#invoice_table_edit tr').length+'" style="border:0;"></textarea></td><td class="pt-3-half"><input type="hidden" name="InvoiceEditST_I_id'+$('#invoice_table_edit tr').length+'" class="invoice_data_edit product_description form-control" id="InvoiceEditST_I_id'+$('#invoice_table_edit tr').length+'" value="" style="border:0;"><input name="InvoiceEditProductQty'+$('#invoice_table_edit tr').length+'" type="number" onchange="GetProductAll('+$('#invoice_table_edit tr').length+')" class="invoice_data product_qty form-control" onclick="this.select();" id="product_qty_edit'+$('#invoice_table_edit tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half">';
            markup=markup+'<input type="text" name="InvoiceEditProductRateMask'+$('#invoice_table_edit tr').length+'" class="product_rate_change_edit form-control"  id="select_product_rate_edit_mask'+$('#invoice_table_edit tr').length+'"  style="border:0;text-align:right;">';
            markup=markup+'<input type="hidden" name="InvoiceEditProductRate'+$('#invoice_table_edit tr').length+'" class="invoice_data product_rate" onchange="GetProductAll('+$('#invoice_table_edit tr').length+')" id="select_product_rate_edit'+$('#invoice_table_edit tr').length+'"  style="border:0;">';
            markup=markup+'</td><td class="pt-3-half product_total_edit" id="total_amount_edit'+$('#invoice_table_edit tr').length+'"></td><td class="pt-3-half"></td></tr>';
            var textbox = '#select_product_rate_edit_mask'+$('#invoice_table_edit tr').length;
            var hidden = '#select_product_rate_edit'+$('#invoice_table_edit tr').length;
            $("#invoice_table_edit").append(markup); 
            
           
            $(textbox).keyup(function () {
                $(textbox).val(this.value.match(/[0-9.,-]*/));
            var num = $(textbox).val();
                var comma = /,/g;
                num = num.replace(comma,'');
                //console.log(hidden+" ==== "+textbox+" 0000000======"+num);
                $(hidden).val(num);
                $(hidden).attr('title',num);
                var numCommas = addCommas(num);
                $(textbox).val(numCommas);
                $(hidden).change();
            });
            var count=document.getElementById('columncounteditinvoice').value;
            count++;
            document.getElementById('columncounteditinvoice').value=count;
            
            var accounttablelength=$('#InvoiceAccountTBodyEdit tr').length+1;
            var markup = '<tr id="invoice_acc_line_edit'+accounttablelength+'" class="invoice_acc_lines_edit">';
            markup=markup+'<td class="pt-3-half" style="text-align:center;" id="number_tag_invoice_acc_edit">';
            markup=markup+accounttablelength;
            markup=markup+'</td>';
            markup=markup+'<td class="pt-3-half">';
            markup=markup+'<select id="invoice_account_debit_accountedit'+accounttablelength+'" name="invoice_account_debit_accountedit'+accounttablelength+'" class="w-100 selectpicker invoice_debit_acc_edit" data-live-search="true" required>';
            @foreach($c_o_a_sorted as $coa)
                if('{{$coa->coa_sub_account}}'=="Receivable Accounts" || '{{$coa->coa_code}}'=="136" || '{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}'=="Cash Clearing Account"){
                    if ('{{$coa->id}}'=="2"){
                        markup=markup+'<option value="{{$coa->id}}" selected>{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>';
                    }else{
                        markup=markup+'<option  value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>';
                    }  
                }                
            @endforeach
            markup=markup+'</select>';
            markup=markup+'</td>';
            markup=markup+'<td class="pt-3-half">';
            markup=markup+'<select id="invoice_account_credit_accountedit'+accounttablelength+'" name="invoice_account_credit_accountedit'+accounttablelength+'" class="w-100 selectpicker invoice_credit_acc_edit" data-live-search="true" required>';
            @foreach($c_o_a_sorted as $coa)
                if('{{$coa->coa_account_type}}'=="Revenue" || '{{$coa->coa_code}}'=="136" || '{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}'=="Cash Clearing Account"){
                    if('{{$coa->id}}'=="4"){
                        markup=markup+'<option value="{{$coa->id}}" selected>{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>';
                    }else{
                        markup=markup+'<option  value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>';
                    }  
                }                
            @endforeach
            markup=markup+'</select>';
            markup=markup+'</td>';
            markup=markup+'</tr>';
            $("#InvoiceAccountTBodyEdit").append(markup);

            refreshpicjer();
        }
        function addlinecredit_note_edit(){
            //alert('add line');
            var markup = '<tr class="credit_note_lines_edit" id="credit_note_line_edit'+$('#credit_note_table_edit tr').length+'"><td class="pt-3-half" id="number_tag_edit" contenteditable="false">'+$('#credit_note_table_edit tr').length+'</td>';
            
            markup=markup+'<td class="pt-3-half"><select name="credit_note_EditProductName'+$('#credit_note_table_edit tr').length+'" onchange="GetProductAll('+$('#credit_note_table_edit tr').length+'),GetProductRate('+$('#credit_note_table_edit tr').length+')" style="border:0; width:100%;" class="credit_note_data product_select" id="select_product_name_edit'+$('#credit_note_table_edit tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input name="credit_note_EditProductDesc'+$('#credit_note_table_edit tr').length+'" class="credit_note_data product_description" id="select_product_description_edit'+$('#credit_note_table_edit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="hidden" name="credit_note_EditST_I_id'+$('#credit_note_table_edit tr').length+'" class="credit_note_data_edit product_description" id="credit_note_EditST_I_id'+$('#credit_note_table_edit tr').length+'" value="" style="border:0;"><input name="credit_note_EditProductQty'+$('#credit_note_table_edit tr').length+'" type="number" onchange="GetProductAll('+$('#credit_note_table_edit tr').length+')" class="credit_note_data product_qty" onclick="this.select();" id="product_qty_edit'+$('#credit_note_table_edit tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input name="credit_note_EditProductRate'+$('#credit_note_table_edit tr').length+'" class="credit_note_data product_rate" readonly onchange="GetProductAll('+$('#credit_note_table_edit tr').length+')" id="select_product_rate_edit'+$('#credit_note_table_edit tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_edit" id="total_amount_edit'+$('#credit_note_table_edit tr').length+'"></td><td class="pt-3-half"></td></tr>';
            
            $("#credit_note_table_edit").append(markup); 
            var count=document.getElementById('columncounteditcredit_note_').value;
            count++;
            document.getElementById('columncounteditcredit_note_').value=count;
        }
    function GetProductAll(e){
        var id = document.getElementById('select_product_name_edit'+e).value;
        // console.log('id???? ='+id);
        // if(id == ""){
        //     $('#select_product_description_edit' + e).val('');
        //     $('#select_product_rate_edit' + e).val('');
        //     $('#total_amount_edit' + e).html('');
        // }else{
            
        // }
            //Save Edit Invoice Next
            $('#total_amount_edit'  + e).html(number_format($('#select_product_rate_edit'  + e).attr('title') * $('#product_qty_edit' + e).val(),2));
            $('#total_amount_edit'  + e).attr('title',$('#select_product_rate_edit'  + e).attr('title') * $('#product_qty_edit' + e).val());
            update_total_edit();
    }
    function GetProductRate(e){
        var id = document.getElementById('select_product_name_edit'+e).value;
        if(id != ""){
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "get_product_info",
                data: {id:id,_token:'{{csrf_token()}}'},
                success: function (product) {
                    var price = product['product_sales_price'];
                    $('#select_product_description_edit' + position).val(product['product_sales_description']);
                    $('#select_product_rate_edit' + e).val(price);
                    $('#select_product_rate_edit' + e).attr('title',price);
                    $('#select_product_rate_edit_mask' + e).val(number_format(price,2));
                    $('#select_product_rate_edit_mask' + e).attr('title',price);
                    $('#total_amount_edit' + e).html(number_format(price * $('#product_qty_edit' + e).val(),2));
                    $('#total_amount_edit' + e).attr('title',price * $('#product_qty_edit' + e).val());
                }
            });
        }
        update_total_edit();
    }
        function update_total_edit(){
            var total_invoice = 0;
            $('.product_total_edit').each(function() {
                var add_total = $(this).attr('title');
                if(add_total==""){
                    add_total=0;
                }
                total_invoice += parseFloat(add_total);
                $('#invoicetotal_edit').html(number_format(total_invoice,2));
                $('#credit_note_total_edit').html(number_format(total_invoice,2));
                $('#sales_receipt_total_edit').html(number_format(total_invoice,2));
                $('#sales_receipt_amount_received_edit').val(total_invoice);
                document.getElementById('total_balance_edit').value=total_invoice;
            });
        }
        function ChangeParticularInvoice(obj){
            //alert(obj.getAttribute("data-columncount"));
            if(obj.value=="Cost Center"){
                document.getElementById('CostCenterInvoiceItemDiv'+obj.getAttribute("data-columncount")).style.display="inline";
                document.getElementById('ProductServicesInvoiceItemDiv'+obj.getAttribute("data-columncount")).style.display="none";
                document.getElementById("CostCenterInvoice"+obj.getAttribute("data-columncount")).required = true;
                document.getElementById("select_product_name"+obj.getAttribute("data-columncount")).required = false;
                
            }else{
                document.getElementById('ProductServicesInvoiceItemDiv'+obj.getAttribute("data-columncount")).style.display="inline";
                document.getElementById('CostCenterInvoiceItemDiv'+obj.getAttribute("data-columncount")).style.display="none";
                document.getElementById("CostCenterInvoice"+obj.getAttribute("data-columncount")).required = false;
                document.getElementById("select_product_name"+obj.getAttribute("data-columncount")).required = true;
            }

            document.getElementById('select_product_name'+obj.getAttribute("data-columncount")).value="";
            document.getElementById('CostCenterInvoice'+obj.getAttribute("data-columncount")).value="";
            refreshpicjer();

        }
        function ChangeParticularInvoiceEdit(obj){
            if(obj.value=="Cost Center"){
                document.getElementById('CostCenterInvoiceItemDivClassEdit'+obj.getAttribute("data-columncount")).style.display="inline";
                document.getElementById('ProductServicesInvoiceItemDivEdit'+obj.getAttribute("data-columncount")).style.display="none";
                document.getElementById("CostCenterInvoiceEdit"+obj.getAttribute("data-columncount")).required = true;
                document.getElementById("select_product_name_edit"+obj.getAttribute("data-columncount")).required = false;
            }else{
                document.getElementById('ProductServicesInvoiceItemDivEdit'+obj.getAttribute("data-columncount")).style.display="inline";
                document.getElementById('CostCenterInvoiceItemDivClassEdit'+obj.getAttribute("data-columncount")).style.display="none";
                document.getElementById("CostCenterInvoiceEdit"+obj.getAttribute("data-columncount")).required = false;
                document.getElementById("select_product_name_edit"+obj.getAttribute("data-columncount")).required = true;
            }

            document.getElementById('select_product_name_edit'+obj.getAttribute("data-columncount")).value="";
            document.getElementById('CostCenterInvoiceEdit'+obj.getAttribute("data-columncount")).value="";
            refreshpicjer();
        }
        function ChangeParticularSalesReceipt(obj){
            //alert(obj);
            if(obj.value=="Cost Center"){
                document.getElementById('CostCenterSalesReceiptDiv'+obj.getAttribute("data-columncount")).style.display="inline";
                document.getElementById('ProductServicesSalesReceiptDiv'+obj.getAttribute("data-columncount")).style.display="none";
                
            }else{
                document.getElementById('ProductServicesSalesReceiptDiv'+obj.getAttribute("data-columncount")).style.display="inline";
                document.getElementById('CostCenterSalesReceiptDiv'+obj.getAttribute("data-columncount")).style.display="none";
            }

            // document.getElementById('select_product_name'+obj.getAttribute("data-columncount")).value="";
            // document.getElementById('CostCenterInvoice'+obj.getAttribute("data-columncount")).value="";
            // refreshpicjer();
        }
        
        function refreshpicjer(){
            document.getElementById('setselectpickerbutton').click();
        }
    $(document).ready(function(){

        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
            return local.toJSON().slice(0,10);
        });

        Date.prototype.addDays = function(days) {
            this.setDate(this.getDate() + parseFloat(days));
            return this;
        };

        // ------------------------------------------------------------- INVOICE STARTS HERE --------------------------
        $(document).on('change', '#term', function(event){
            event.preventDefault();

            var term = $('#term').val();

            if(term=="Due on receipt" && $('#invoicedate').val()==""){
                $('#invoicedate').val(new Date().toDateInputValue());
                $('#invoiceduedate').val(new Date().toDateInputValue());
            }else if(term=="Due on receipt"){
                $('#invoiceduedate').val($('#invoicedate').val());
            }else if(term=="Net 15"  && $('#invoicedate').val()==""){
                $('#invoicedate').val(new Date().toDateInputValue());
                $('#invoiceduedate').val(new Date(new Date().getTime()+(15*24*60*60*1000)).toDateInputValue());
            }else if(term=="Net 15"){
                var date= $('#invoicedate')[0].valueAsDate;
                date.setDate(date.getDate() + 15);
                $('#invoiceduedate')[0].valueAsDate = date;
            }else if(term=="Net 30"  && $('#invoicedate').val()==""){
                $('#invoicedate').val(new Date().toDateInputValue());
                $('#invoiceduedate').val(new Date(new Date().getTime()+(30*24*60*60*1000)).toDateInputValue());
            }else if(term=="Net 30"){
                var date= $('#invoicedate')[0].valueAsDate;
                date.setDate(date.getDate() + 30);
                $('#invoiceduedate')[0].valueAsDate = date;
            }else if(term=="Net 60"  && $('#invoicedate').val()==""){
                $('#invoicedate').val(new Date().toDateInputValue());
                $('#invoiceduedate').val(new Date(new Date().getTime()+(60*24*60*60*1000)).toDateInputValue());
            }else if(term=="Net 60"){
                var date= $('#invoicedate')[0].valueAsDate;
                date.setDate(date.getDate() + 60);
                $('#invoiceduedate')[0].valueAsDate = date;
            }else{
                
            }
        });

        $(document).on('change', '#invoicedate', function(event){
            event.preventDefault();

            var term = $('#term').val();

            if(term=="Due on receipt"){
                $('#invoiceduedate').val($('#invoicedate').val());
            }else if(term=="Net 15"){
                var date= $('#invoicedate')[0].valueAsDate;
                date.setDate(date.getDate() + 15);
                $('#invoiceduedate')[0].valueAsDate = date;
            }else if(term=="Net 30"){
                var date= $('#invoicedate')[0].valueAsDate;
                date.setDate(date.getDate() + 30);
                $('#invoiceduedate')[0].valueAsDate = date;
            }else if(term=="Net 60"){
                var date= $('#invoicedate')[0].valueAsDate;
                date.setDate(date.getDate() + 60);
                $('#invoiceduedate')[0].valueAsDate = date;
            }else{
                $('#invoiceduedate').val($('#invoicedate').val());
            }
        });


        $(document).on('change', '.product_select', function(event){
            event.preventDefault();
            var id = $(this).val();
            console.log($(this).attr('id')+" id");
            
            if( typeof( $(this).attr('id') ) != 'undefined' ){
                var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
                if(id == ""){
                    $('#select_product_description' + position).val('');
                    $('#select_product_description_journal' + position).val('');
                    $('#select_product_rate' + position).val('');
                    $('#unformated_select_sales_rate' + position).val('');
                    
                    $('#select_product_rate_journal' + position).val('');
                    $('#total_amount' + position).html('');
                    $('#total_amount_journal' + position).html('');
                }else{
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "get_product_info",
                        data: {id:id,_token:'{{csrf_token()}}'},
                        success: function (product) {
                            var price = product['product_sales_price'];
                            $('#select_product_description' + position).val(product['product_sales_description']);
                            $('#select_product_description_journal' + position).val(product['product_sales_description']);
                            $('#unformated_select_sales_rate' + position).val(number_format(price,2));
                            $('#select_product_rate'+ position).val(price);
                            $('#select_product_rate'+ position).attr('title', price);
                            $('#select_product_rate_journal' + position).val(number_format(price,2));
                            $('#select_product_rate_journal'+ position).attr('title', price);
                            $('#total_amount' + position).html(number_format(price * $('#product_qty' + position).val(),2));
                            $('#total_amount' + position).attr('title',price * $('#product_qty' + position).val());
                            $('#total_amount_journal' + position).html(number_format(price * $('#product_qty_journal' + position).val(),2));
                            $('#total_amount_journal' + position).attr('title',price * $('#product_qty_journal' + position).val());
                        }
                    });
                
                }
            }
            

            update_total();
        });

        $(document).on('change', '#invoicecustomer', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                $('#invoicebalance').html('PHP 0.00');
                $('#big_invoicebalance').html('PHP 0.00');
            }else{
            var res = id.split(" - ");
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_customer_info",
                    data: {id:res[0],_token:'{{csrf_token()}}'},
                    success: function (customer) {
                        $('#invoicebalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#big_invoicebalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#bill_address').val(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                        $('#bill_address').val($('#bill_address').val().replace(' null',''));
                        $('#bill_address').val($('#bill_address').val().replace(' null',''));
                        $('#bill_address').val($('#bill_address').val().replace(' null',''));
                        $('#bill_address').val($('#bill_address').val().replace(' null',''));
                        $('#bill_address').val($('#bill_address').val().replace(' null',''));
                        // $('#rr_payment_method').val(customer['payment_method']);
                        $('#email').val(customer['email']);
                        $('#term').val(customer['terms']);
                    }
                });  
            
            }
        });
        $(document).on('change', '#invoicecustomer_journal', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                $('#invoicebalance_journal').html('PHP 0.00');
                $('#big_invoicebalance_journal').html('PHP 0.00');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_customer_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (customer) {
                        $('#invoicebalance_journal').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#big_invoicebalance_journal').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#bill_address_journal').val(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                        $('#bill_address_journal').val($('#bill_address_journal').val().replace(' null',''));
                        $('#bill_address_journal').val($('#bill_address_journal').val().replace(' null',''));
                        $('#bill_address_journal').val($('#bill_address_journal').val().replace(' null',''));
                        $('#bill_address_journal').val($('#bill_address_journal').val().replace(' null',''));
                        $('#bill_address_journal').val($('#bill_address_journal').val().replace(' null',''));
                        // $('#rr_payment_method').val(customer['payment_method']);
                        $('#email_journal').val(customer['email']);
                        $('#term_journal').val(customer['terms']);
                    }
                });  
            
            }
        });
        $(document).on('change', '.product_qty', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount'  + position).html(number_format($('#select_product_rate'  + position).attr('title') * $('#product_qty' + position).val(),2));
            $('#total_amount'  + position).attr('title',$('#select_product_rate'  + position).attr('title') * $('#product_qty' + position).val());
            $('#total_amount_journal'  + position).html(number_format($('#select_product_rate_journal'  + position).attr('title') * $('#product_qty_journal' + position).val(),2));
            $('#total_amount_journal'  + position).attr('title',$('#select_product_rate_journal'  + position).attr('title') * $('#product_qty_journal' + position).val());
           
            update_total();
        });
        $(document).on('change', '.product_rate_change', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount'  + position).html(number_format($('#select_product_rate'  + position).attr('title') * $('#product_qty' + position).val(),2));
            $('#total_amount'  + position).attr('title',$('#select_product_rate'  + position).attr('title') * $('#product_qty' + position).val());
            $('#total_amount_journal'  + position).html(number_format($('#select_product_rate_journal'  + position).attr('title') * $('#product_qty_journal' + position).val(),2));
            $('#total_amount_journal'  + position).attr('title',$('#select_product_rate_journal'  + position).attr('title') * $('#product_qty_journal' + position).val());
           
            update_total();
        });

        $(document).on('change', '.invoice_data', function(){
            if( typeof( $(this).attr('id') ) != 'undefined' ){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount'  + position).html(number_format($('#select_product_rate'  + position).attr('title') * $('#product_qty' + position).val(),2));
            $('#total_amount'  + position).attr('title',$('#select_product_rate'  + position).attr('title') * $('#product_qty' + position).val());

            $('#total_amount_journal'  + position).html(number_format($('#select_product_rate_journal'  + position).attr('title') * $('#product_qty_journal' + position).val(),2));
            $('#total_amount_journal'  + position).attr('title',$('#select_product_rate_journal'  + position).attr('title') * $('#product_qty_journal' + position).val());
            }
            update_total();
        });
        
        $("#add_lines_invoice").click(function(event){
            event.preventDefault();
            $("#main_invoice_table").dataTable().fnDestroy();
            $("#main_invoice_table_journal_account").dataTable().fnDestroy();
            //add_item_invoice
            var markup = '<tr class="invoice_lines" id="invoice_line'+($('#invoice_table tr').length+parseFloat(1))+'">';
            var table = document.getElementById("main_invoice_table");
            var txt = "";
            var i;
            for (i = 0; i < table.rows[0].cells.length; i++) {
                txt = txt + table.rows[0].cells[i].innerHTML + "<br>";
                //console.log(txt);
                if(table.rows[0].cells[i].innerHTML=="#"){
                    markup=markup+'<td class="pt-3-half text-center" id="number_tag" contenteditable="false">'+($('#invoice_table tr').length+parseFloat(1))+'</td>';
                }
                if(table.rows[0].cells[i].innerHTML=="PARTICULAR"){
                    markup=markup+'<td class="pt-3-half"><select style="height:40px;" onchange="ChangeParticularInvoice(this)" id="ParticularInvoice'+($('#invoice_table tr').length+parseFloat(1))+'" data-columncount="'+($('#invoice_table tr').length+parseFloat(1))+'" class="w-100  invoice_particular"><option>Cost Center</option><option>Product/Service</option></select></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="ITEM"){
                    markup=markup+'<td class="pt-3-half">';
                    markup=markup+'<div class="ProductServicesInvoiceItemDivClass" id="ProductServicesInvoiceItemDiv'+($('#invoice_table tr').length+parseFloat(1))+'" style="display:none;"><select style="border:0; width:100%;" class="invoice_data product_select selectpicker" data-live-search="true" id="select_product_name'+($('#invoice_table tr').length+parseFloat(1))+'"><option value=""></option>'+product_list_js+'</select></div><div id="CostCenterInvoiceItemDiv'+($('#invoice_table tr').length+parseFloat(1))+'" class="CostCenterInvoiceItemDivClass"><select required name="CostCenterInvoice'+($('#invoice_table tr').length+parseFloat(1))+'" class="w-100 invoice_cost_center selectpicker" data-live-search="true" id="CostCenterInvoice'+($('#invoice_table tr').length+parseFloat(1))+'" ><option value="">--Select Cost Center--</option>@foreach($cost_center_list as $ccl)<option value="{{$ccl->cc_no}}">{{trim(preg_replace("/\s\s+/", " ", $ccl->cc_name))}}</option> @endforeach</select></div></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="DESCRIPTION"){
                    markup=markup+'<td class="pt-3-half"><textarea class=" invoice_data product_description w-100" id="select_product_description'+($('#invoice_table tr').length+parseFloat(1))+'" style="border:0;"></textarea></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="QTY"){
                    markup=markup+'<td class="pt-3-half"><input required type="number" class=" invoice_data product_qty" onclick="this.select();" id="product_qty'+($('#invoice_table tr').length+parseFloat(1))+'" style="border:0; text-align:center;" min="1" value="1"></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="RATE"){
                    markup=markup+'<td class="pt-3-half">';
                    markup=markup+'<input type="text" class="product_rate_change " value="0" id="unformated_select_sales_rate'+($('#invoice_table tr').length+parseFloat(1))+'" style="border:0;text-align:right;width:100%;padding-right:10px;" required>';
                    markup=markup+'<input type="hidden" class="invoice_data product_rate value="0" id="select_product_rate'+($('#invoice_table tr').length+parseFloat(1))+'" style="border:0;">';
                    markup=markup+'</td>';
                }
                if(table.rows[0].cells[i].innerHTML=="AMOUNT"){
                    markup=markup+'<td class="pt-3-half pr-3 product_total" style="text-align:right;" id="total_amount'+($('#invoice_table tr').length+parseFloat(1))+'" title="0.00">0.00</td>';
                }
                if(table.rows[0].cells[i].innerHTML==""){
                    markup=markup+'<td class="pt-3-half text-center"><a href="#" id="delete_product'+($('#invoice_table tr').length+parseFloat(1))+'" class="fa fa-trash delete_product"></a></td>';
                }
            }
            markup=markup+'</tr>';
            var textbox = '#unformated_select_sales_rate'+($('#invoice_table tr').length+parseFloat(1));
            var hidden = '#select_product_rate'+($('#invoice_table tr').length+parseFloat(1));
            
            if($("#invoice_table").append(markup)){
                console.log('asdasdasqeqw');
            }
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
            var accounttablelength=$('#InvoiceAccountTBody tr').length+1;
            var markup = '<tr id="invoice_acc_line'+accounttablelength+'" class="invoice_acc_lines">';
            markup=markup+'<td class="pt-3-half" style="text-align:center;" id="number_tag_invoice_acc">';
            markup=markup+accounttablelength;
            markup=markup+'</td>';

            markup=markup+'<td class="pt-3-half">';
            markup=markup+'<select id="invoice_account_debit_account_code'+accounttablelength+'" onchange="setAccount_and_Code(this)" name="invoice_account_debit_account_code'+accounttablelength+'" class="w-100 selectpicker invoice_debit_acc_code" data-live-search="true" required>';
            @foreach($c_o_a_sorted as $coa)
                // if('{{$coa->coa_sub_account}}'=="Receivable Accounts" || '{{$coa->coa_code}}'=="136" || '{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}'=="Cash Clearing Account"){
                //     if ('{{$coa->id}}'=="2"){
                //         markup=markup+'<option value="{{$coa->id}}" selected>{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>';
                //     }else{
                //         markup=markup+'<option  value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>';
                //     }  
                // }
                if(""==""){
                    if ('{{$coa->id}}'=="2"){
                        markup=markup+'<option value="{{$coa->id}}" selected>{{$coa->coa_code}}</option>';
                    }else{
                        markup=markup+'<option  value="{{$coa->id}}">{{$coa->coa_code}}</option>';
                    }  
                }                 
            @endforeach
            markup=markup+'</select>';
            markup=markup+'</td>';
            markup=markup+'<td class="pt-3-half">';
            markup=markup+'<select id="invoice_account_debit_account'+accounttablelength+'" onchange="setAccount_and_Code_code(this)" name="invoice_account_debit_account'+accounttablelength+'" class="w-100 selectpicker invoice_debit_acc" data-live-search="true" required>';
            @foreach($c_o_a_sorted as $coa)
                // if('{{$coa->coa_sub_account}}'=="Receivable Accounts" || '{{$coa->coa_code}}'=="136" || '{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}'=="Cash Clearing Account"){
                //     if ('{{$coa->id}}'=="2"){
                //         markup=markup+'<option value="{{$coa->id}}" selected>{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>';
                //     }else{
                //         markup=markup+'<option  value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>';
                //     }  
                // }
                if(""==""){
                    if ('{{$coa->id}}'=="2"){
                        markup=markup+'<option value="{{$coa->id}}" selected>{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>';
                    }else{
                        markup=markup+'<option  value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>';
                    }  
                }                 
            @endforeach
            markup=markup+'</select>';
            markup=markup+'</td>';

            markup=markup+'<td class="pt-3-half">';
            markup=markup+'<select id="invoice_account_credit_account_code'+accounttablelength+'" onchange="setAccount_and_Code2(this)" name="invoice_account_credit_account_code'+accounttablelength+'" class="w-100 selectpicker invoice_credit_acc_code" data-live-search="true" required>';
            @foreach($c_o_a_sorted as $coa)
                if(""==""){
                    if('{{$coa->id}}'=="4"){
                        markup=markup+'<option value="{{$coa->id}}" selected>{{$coa->coa_code}}</option>';
                    }else{
                        markup=markup+'<option  value="{{$coa->id}}">{{$coa->coa_code}}</option>';
                    }  
                }                
            @endforeach
            markup=markup+'</select>';
            markup=markup+'</td>';

            markup=markup+'<td class="pt-3-half">';
            markup=markup+'<select id="invoice_account_credit_account'+accounttablelength+'" onchange="setAccount_and_Code_code2(this)" name="invoice_account_credit_account'+accounttablelength+'" class="w-100 selectpicker invoice_credit_acc" data-live-search="true" required>';
            @foreach($c_o_a_sorted as $coa)
                if(""==""){
                    if('{{$coa->id}}'=="4"){
                        markup=markup+'<option value="{{$coa->id}}" selected>{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>';
                    }else{
                        markup=markup+'<option  value="{{$coa->id}}">{{preg_replace( "/\r|\n/", "", $coa->coa_name )}}</option>';
                    }  
                }                
            @endforeach
            markup=markup+'</select>';
            markup=markup+'</td>';
            markup=markup+'</tr>';
            if($("#InvoiceAccountTBody").append(markup)){
                
                var invoice_table=$("#main_invoice_table").DataTable({
                    paging: false,
                    "ordering": true,
                    'dom': 'Rlfrtip',
                    "autoWidth": false,
                    rowReorder: true
                });
                
                
                
                if(document.getElementById('main_invoice_table_info')){
                    document.getElementById('main_invoice_table_info').style.display="none";
                    document.getElementById('main_invoice_table_filter').style.display="none";
                    // var column = invoice_table.column(0);
 
                    // // Toggle the visibility
                    // column.visible( false );
                    invoice_table.on( 'row-reorder', function ( e, diff, edit ) {
                    //console.log("asdasdasd->>>> "+edit.triggerRow.data());
                    var result = 'Reorder started on row: '+(edit.triggerRow.data())+'<br>';
                    
                    for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                        var rowData = invoice_table.row( diff[i].node ).data();
                        result += rowData;
                        console.log(rowData[0]);
                        //result += rowData[1]+' updated to be in position '+
                        //    diff[i].newData+' (was '+diff[i].oldData+')<br>';
                    }
            
                   // console.log( 'Event result:<br>'+result );
                } );
                }
                var main_invoice_table_journal_account=$("#main_invoice_table_journal_account").DataTable({
                    paging: false,
                    "ordering": true,
                    'dom': 'Rlfrtip',
                    "autoWidth": false,
                    rowReorder: true
                });
                if(document.getElementById('main_invoice_table_journal_account_info')){
                    document.getElementById('main_invoice_table_journal_account_info').style.display="none";
                    document.getElementById('main_invoice_table_journal_account_filter').style.display="none";
                    // var column = invoice_table.column(0);
 
                    // // Toggle the visibility
                    // column.visible( false );
                    main_invoice_table_journal_account.on( 'row-reorder', function ( e, diff, edit ) {
                    //console.log("asdasdasd->>>> "+edit.triggerRow.data());
                    var result = 'Reorder started on row: '+(edit.triggerRow.data())+'<br>';
                    
                    for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                        var rowData = main_invoice_table_journal_account.row( diff[i].node ).data();
                        result += rowData;
                        console.log(rowData[0]);
                        //result += rowData[1]+' updated to be in position '+
                        //    diff[i].newData+' (was '+diff[i].oldData+')<br>';
                    }
            
                   // console.log( 'Event result:<br>'+result );
                } );
                }
            }
            
            
            document.getElementById('setselectpickerbutton').click();
            //datatable invoice
            
        });
        $("#add_lines_invoice_journal").click(function(event){
            event.preventDefault();
            var markup = '<tr class="invoice_lines" id="invoice_line_journal'+$('#invoice_table_journal tr').length+'"><td class="pt-3-half" id="number_tag_journal" contenteditable="false">'+$('#invoice_table_journal tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="invoice_data product_select" id="select_product_name_journal'+$('#invoice_table_journal tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="invoice_data product_description" id="select_product_description_journal'+$('#invoice_table_journal tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="invoice_data product_qty" onclick="this.select();" id="product_qty_journal'+$('#invoice_table_journal tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="invoice_data product_rate" readonly id="select_product_rate_journal'+$('#invoice_table_journal tr').length+'" style="border:0;"></td><td class="pt-3-half product_total" id="total_amount_journal'+$('#invoice_table_journal tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_journal'+$('#invoice_table_journal tr').length+'" class="fa fa-trash delete_product"></a></td></tr>';
            
            $("#invoice_table_journal").append(markup);

        
        }); 
        
        
        $("#clear_lines_invoice").click(function(event){
            event.preventDefault();
            $("#main_invoice_table").dataTable().fnDestroy();
            $('.invoice_lines').remove();
            $('.invoice_acc_lines').remove();
            
            $('#invoicetotal').html('0.00');
            
            
        }); 
        $("#clear_lines_invoice_journal").click(function(event){
            event.preventDefault();
            $('.invoice_lines').remove();

            $('#invoicetotal_journal').html('0.00');
        }); 
        
        
        $(document).on('click', '.delete_product', function(event){
            event.preventDefault();
            $("#main_invoice_table").dataTable().fnDestroy();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#invoice_line'+position).remove();
            $('#invoice_acc_line'+position).remove();
            $('#invoice_line_journal'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var product_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;
            var invoice_particular_counter = 1;
            var invoice_cost_center_counter = 1;
            var invoice_credit_acc_counter = 1;
            var invoice_debit_acc_counter = 1;
            var CostCenterInvoiceItemDivClass_counter = 1;
            var ProductServicesInvoiceItemDivClass_counter = 1;

            var invoice_acc_count=1;
            var invoice_acc_line_count=1;
            $(".invoice_acc_lines").each(function() {
                $(this).attr("id","invoice_acc_line"+invoice_acc_line_count);
                //$(this).attr("id","invoice_line_journal"+line_counter);
                
                invoice_acc_line_count++;
            });
            $(".invoice_lines").each(function() {
                $(this).attr("id","invoice_line"+line_counter);
                //$(this).attr("id","invoice_line_journal"+line_counter);
                
                line_counter++;
            });
            
            $(".delete_product").each(function() {
                $(this).attr("id","delete_product"+delete_counter);
                //$(this).attr("id","delete_product_journal"+delete_counter);
                delete_counter++;
            });
            $(".CostCenterInvoiceItemDivClass").each(function() {
                
                $(this).attr("id","CostCenterInvoiceItemDiv"+CostCenterInvoiceItemDivClass_counter);
                //$(this).attr("id","delete_product_journal"+delete_counter);
                CostCenterInvoiceItemDivClass_counter++;
            });
            $(".ProductServicesInvoiceItemDivClass").each(function() {
                $(this).attr("id","ProductServicesInvoiceItemDiv"+ProductServicesInvoiceItemDivClass_counter);
                //$(this).attr("id","delete_product_journal"+delete_counter);
                ProductServicesInvoiceItemDivClass_counter++;
            });
            
            $(".invoice_particular").each(function() {

                $(this).attr("id","ParticularInvoice"+invoice_particular_counter);
                $(this).attr("data-columncount",invoice_particular_counter);
                //$(this).attr("id","delete_product_journal"+delete_counter);
                invoice_particular_counter++;
            });
            destroy_select_picker('invoice_cost_center');
            $(".invoice_cost_center").each(function() {
                $(this).addClass( "selectpicker" );
                //$(this).attr("class","w-100 invoice_cost_center selectpicker");
                $(this).attr("id","CostCenterInvoice"+invoice_cost_center_counter);
                $(this).attr("name","CostCenterInvoice"+invoice_cost_center_counter);
                //$(this).attr("id","delete_product_journal"+delete_counter);
                invoice_cost_center_counter++;
            });
            destroy_select_picker('invoice_debit_acc');
            $(".invoice_debit_acc").each(function() {
                $(this).addClass( "selectpicker" );
                 
                $(this).attr("id","invoice_account_debit_account"+invoice_debit_acc_counter);
                $(this).attr("name","invoice_account_debit_account"+invoice_debit_acc_counter);
                
                invoice_debit_acc_counter++;
            });
            destroy_select_picker('invoice_credit_acc');
            $(".invoice_credit_acc").each(function() {
                $(this).addClass( "selectpicker" );
                 
                $(this).attr("id","invoice_account_credit_account"+invoice_credit_acc_counter);
                $(this).attr("name","invoice_account_credit_account"+invoice_credit_acc_counter);
                
                invoice_credit_acc_counter++;
            });
            $(".invoice_acc_lines").find('#number_tag_invoice_acc').each(function() {
                $(this).html(invoice_acc_count);
                invoice_acc_count++;
            });
            $(".invoice_lines").find('#number_tag').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });
            $(".invoice_lines").find('#number_tag_journal').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });
            destroy_select_picker('product_select');
            $('.product_select').each(function() {
                $(this).addClass( "selectpicker" );
                //$(this).attr("class","invoice_data product_select selectpicker");
                $(this).attr("id","select_product_name"+product_id_counter);
                //$(this).attr("id","select_product_name_journal"+product_id_counter);
                product_id_counter++;
            });

            $('.product_description').each(function() {
                $(this).attr("id","select_product_description"+description_id_counter);
                //$(this).attr("id","select_product_description_journal"+description_id_counter);
                description_id_counter++;
            });

            $('.product_qty').each(function() {
                $(this).attr("id","product_qty"+qty_id_counter);
                //$(this).attr("id","product_qty_journal"+qty_id_counter);
                qty_id_counter++;
            });

            $('.product_rate').each(function() {
                $(this).attr("id","select_product_rate"+rate_id_counter);
                //$(this).attr("id","select_product_rate_journal"+rate_id_counter);
                rate_id_counter++;
            });

            $(".product_total").each(function() {
                $(this).attr("id","total_amount"+total_id_counter);
                //$(this).attr("id","total_amount_journal"+total_id_counter);
                total_id_counter++;
            });

            update_total();
            refreshpicjer();
            var main_invoice_table=$("#main_invoice_table").DataTable({
                paging: false,
                "ordering": true,
                'dom': 'Rlfrtip',
                "autoWidth": false,
                rowReorder: true
            });
            
            
            
            if(document.getElementById('main_invoice_table_info')){
                document.getElementById('main_invoice_table_info').style.display="none";
                document.getElementById('main_invoice_table_filter').style.display="none";
                
            }
        }); 

        function update_total(){
            var total_invoice = 0;
            $('.product_total').each(function() {
                var add_total = $(this).attr('title');
                if(add_total==""){
                    add_total=0;
                }
                console.log(add_total+" total individual");
                total_invoice += parseFloat(add_total);
                $('#invoicetotal').html(number_format(total_invoice,2));
                $('#invoicetotal').attr('title',total_invoice);
                $('#invoicetotal_journal').html(number_format(total_invoice,2));
                $('#invoicetotal_journal').attr('title',total_invoice);
            });
        }

        // ------------------------------------------------------------- ESTIMATE STARTS HERE --------------------------
        
        $(document).on('change', '.product_select_estimate', function(event){
            event.preventDefault();
            var id = $(this).val();
            if( typeof( $(this).attr('id') ) != 'undefined' ){
                var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
                if(id == ""){
                    $('#select_product_description_estimate' + position).val('');
                    $('#select_product_rate_estimate' + position).val('');
                    $('#total_amount_estimate' + position).html('');
                }else{
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "get_product_info",
                        data: {id:id,_token:'{{csrf_token()}}'},
                        success: function (product) {
                            var price = product['product_sales_price'];
                            $('#select_product_description_estimate' + position).val(product['product_sales_description']);
                            $('#select_product_rate_estimate' + position).val(number_format(price,2));
                            $('#select_product_rate_estimate' + position).attr('title',price);
                            $('#total_amount_estimate' + position).html(number_format(price * $('#product_qty_estimate' + position).val(),2));
                            $('#total_amount_estimate' + position).attr('title',price * $('#product_qty_estimate' + position).val());
                        }
                    });
                
                }
            }
            

            update_total_estimate();
        });

        $(document).on('change', '#estimatecustomer', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                $('#estimatebalance').html('PHP 0.00');
                $('#big_estimatebalance').html('PHP 0.00');
            }else{
            var res = id.split(" - ");  
            $.ajax({
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "get_customer_info",
                data: {id:res[0],_token:'{{csrf_token()}}'},
                success: function (customer) {
                    $('#estimatebalance').html('PHP '+number_format(customer['opening_balance'],2));
                    $('#big_estimatebalance').html('PHP '+number_format(customer['opening_balance'],2));
                    $('#e_bill_address').val(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                    $('#e_bill_address').val($('#e_bill_address').val().replace(' null',''));
                    $('#e_bill_address').val($('#e_bill_address').val().replace(' null',''));
                    $('#e_bill_address').val($('#e_bill_address').val().replace(' null',''));
                    $('#e_bill_address').val($('#e_bill_address').val().replace(' null',''));
                    $('#e_bill_address').val($('#e_bill_address').val().replace(' null',''));
                    // $('#rr_payment_method').val(customer['payment_method']);
                    $('#e_email').val(customer['email']);
                    // $('#cheque_email').val(customer['terms']);
                }
            });  
            
            }
        });

        $(document).on('change', '.product_qty_estimate', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_estimate'  + position).html(number_format($('#select_product_rate_estimate'  + position).attr('title') * $('#product_qty_estimate' + position).val(),2));
            $('#total_amount_estimate'  + position).attr('title',$('#select_product_rate_estimate'  + position).attr('title') * $('#product_qty_estimate' + position).val());
           
            update_total_estimate();
        });

        $(document).on('change', '.estimate_data', function(){
            if( typeof( $(this).attr('id') ) != 'undefined' ){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_estimate'  + position).html(number_format($('#select_product_rate_estimate'  + position).attr('title') * $('#product_qty_estimate' + position).val(),2));
            $('#total_amount_estimate'  + position).attr('title',$('#select_product_rate_estimate'  + position).attr('title') * $('#product_qty_estimate' + position).val());
            }
            update_total_estimate();
        });


        $("#add_lines_estimate").click(function(event){
            event.preventDefault();
            $("#estimate_table").dataTable().fnDestroy();
            var count=$('#estimate_table_tbody tr').length+parseFloat(1);
            var markup = '<tr class="estimate_lines" id="estimate_line'+count+'">';
            var table = document.getElementById("estimate_table");
            var txt = "";
            var i;
            for (i = 0; i < table.rows[0].cells.length; i++) {
                txt = txt + table.rows[0].cells[i].innerHTML + "<br>";
                if(table.rows[0].cells[i].innerHTML=="#"){
                    markup=markup+'<td class="pt-3-half" id="number_tag_estimate" contenteditable="false">'+count+'</td>';
                }
                if(table.rows[0].cells[i].innerHTML=="PRODUCT/SERVICE"){
                    markup=markup+'<td class="pt-3-half"><select style="border:0; width:100%;" class="estimate_data product_select_estimate selectpicker" data-live-search="true" id="select_product_name_estimate'+count+'"><option value=""></option>'+product_list_js+'</select></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="DESCRIPTION"){
                    markup=markup+'<td class="pt-3-half"><input class="estimate_data product_description_estimate form-control" id="select_product_description_estimate'+count+'" style="border:0;"></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="QTY"){
                    markup=markup+'<td class="pt-3-half"><input type="number" class="estimate_data product_qty_estimate form-control" onclick="this.select();" id="product_qty_estimate'+count+'" style="border:0; text-align:center;" value="1"></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="RATE"){
                    markup=markup+'<td class="pt-3-half"><input class="form-control estimate_data product_rate_estimate" value="0" readonly id="select_product_rate_estimate'+count+'" style="border:0;text-align:right;background-color:white !important;"></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="AMOUNT"){
                    markup=markup+'<td class="text-right pt-3-half pr-3 product_total_estimate" id="total_amount_estimate'+count+'" title="0.00">0.00</td>';
                }
                if(table.rows[0].cells[i].innerHTML==""){
                    
                    markup=markup+'<td class="pt-3-half text-center"><a href="#" id="delete_product_estimate'+count+'" class="fa fa-trash delete_product_estimate"></a></td>';
                }
            }
            markup=markup+'</tr>';
            
            $("#estimate_table_tbody").append(markup);

            document.getElementById('setselectpickerbutton').click();
            //
            var estimate_table=$("#estimate_table").DataTable({
                paging: false,
                "ordering": true,
                'dom': 'Rlfrtip',
                "autoWidth": false,
                rowReorder: true
            });
            
            
            
            if(document.getElementById('estimate_table_info')){
                document.getElementById('estimate_table_info').style.display="none";
                document.getElementById('estimate_table_filter').style.display="none";
                estimate_table.on( 'row-reorder', function ( e, diff, edit ) {
                //console.log("asdasdasd->>>> "+edit.triggerRow.data());
                var result = 'Reorder started on row: '+(edit.triggerRow.data())+'<br>';
                
                for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                    var rowData = estimate_table.row( diff[i].node ).data();
                    result += rowData;
                    console.log(rowData[113]);
                    //result += rowData[1]+' updated to be in position '+
                    //    diff[i].newData+' (was '+diff[i].oldData+')<br>';
                }
                });
            }
        }); 

        $("#clear_lines_estimate").click(function(event){
            event.preventDefault();
            $("#estimate_table").dataTable().fnDestroy();
            $('.estimate_lines').remove();

            $('#estimatetotal').html('0.00');
        }); 

        $(document).on('click', '.delete_product_estimate', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $("#estimate_table").dataTable().fnDestroy();
            $('#estimate_line'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var product_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".estimate_lines").each(function() {
                $(this).attr("id","estimate_line"+line_counter);
                line_counter++;
            });

            $(".delete_product_estimate").each(function() {
                $(this).attr("id","delete_product_estimate"+delete_counter);
                delete_counter++;
            });

            $(".estimate_lines").find('#number_tag_estimate').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.product_select_estimate').each(function() {
                $(this).attr("id","select_product_name_estimate"+product_id_counter);
                product_id_counter++;
            });

            $('.product_description_estimate').each(function() {
                $(this).attr("id","select_product_description_estimate"+description_id_counter);
                description_id_counter++;
            });

            $('.product_qty_estimate').each(function() {
                $(this).attr("id","product_qty_estimate"+qty_id_counter);
                qty_id_counter++;
            });

            $('.product_rate_estimate').each(function() {
                $(this).attr("id","select_product_rate_estimate"+rate_id_counter);
                rate_id_counter++;
            });

            $(".product_total_estimate").each(function() {
                $(this).attr("id","total_amount_estimate"+total_id_counter);
                total_id_counter++;
            });

            update_total_estimate();
            var estimate_table=$("#estimate_table").DataTable({
                paging: false,
                "ordering": true,
                'dom': 'Rlfrtip',
                "autoWidth": false,
                rowReorder: true
            });
            
            
            
            if(document.getElementById('estimate_table_info')){
                document.getElementById('estimate_table_info').style.display="none";
                document.getElementById('estimate_table_filter').style.display="none";
                estimate_table.on( 'row-reorder', function ( e, diff, edit ) {
                //console.log("asdasdasd->>>> "+edit.triggerRow.data());
                var result = 'Reorder started on row: '+(edit.triggerRow.data())+'<br>';
                
                for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                    var rowData = estimate_table.row( diff[i].node ).data();
                    result += rowData;
                    console.log(rowData[113]);
                    //result += rowData[1]+' updated to be in position '+
                    //    diff[i].newData+' (was '+diff[i].oldData+')<br>';
                }
                });
            }
        }); 

        function update_total_estimate(){
            var total_estimate = 0;
            $('.product_total_estimate').each(function() {
                var add_total = $(this).attr('title');
                if(add_total==""){
                    add_total=0;
                }
                total_estimate += parseFloat(add_total);
                $('#estimatetotal').html(number_format(total_estimate,2));
                $('#estimatetotal').attr('title',total_estimate);
            });
        }   

    
        // ------------------------------------------------------------- SALES RECEIPT STARTS HERE --------------------------
        
        $(document).on('change', '.product_select_sales_receipt', function(event){
            event.preventDefault();
            var id = $(this).val();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            if(id == ""){
                $('#select_product_description_sales_receipt' + position).val('');
                $('#select_product_rate_sales_receipt' + position).val('');
                $('#total_amount_sales_receipt' + position).html('');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_product_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (product) {
                        var price = product['product_sales_price'];
                        $('#select_product_description_sales_receipt' + position).val(product['product_sales_description']);
                        $('#select_product_rate_sales_receipt' + position).val(number_format(price,2));
                        $('#select_product_rate_sales_receipt' + position).attr('title',price);
                        $('#total_amount_sales_receipt' + position).html(number_format(price * $('#product_qty_sales_receipt' + position).val(),2));
                        $('#total_amount_sales_receipt' + position).attr('title',price * $('#product_qty_sales_receipt' + position).val());
                    }
                });
                
            }

            update_total_sales_receipt();
        });

        $(document).on('change', '#salesrcustomer', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                //$('#sales_receiptbalance').html('PHP 0.00');
                //$('#big_sales_receiptbalance').html('PHP 0.00');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_customer_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (customer) {
                        $('#sr_bill_address').val(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                        $('#sr_bill_address').val($('#sr_bill_address').val().replace(' null',''));
                        $('#sr_bill_address').val($('#sr_bill_address').val().replace(' null',''));
                        $('#sr_bill_address').val($('#sr_bill_address').val().replace(' null',''));
                        $('#sr_bill_address').val($('#sr_bill_address').val().replace(' null',''));
                        $('#sr_bill_address').val($('#sr_bill_address').val().replace(' null',''));
                        $('#sr_email').val(customer['email']);
                        // $('#cheque_email').val(customer['terms']);
                        
                        if(customer['payment_method']!=""){
                            $('#sr_payment_method').val(customer['payment_method']);
                            
                        }
                        $('#tin_no_sr').val(customer['tin_no']);
                        $('#business_style_sr').val(customer['business_style']);
                        if(customer['payment_method']=='Cheque'){
                            var x=document.getElementsByClassName("ChequeColumnssc");
                                var i;
                                for (i = 0; i < x.length; i++) {
                                x[i].style.display = "block";
                                }
                        }else{
                            var x=document.getElementsByClassName("ChequeColumnssc");
                                var i;
                                for (i = 0; i < x.length; i++) {
                                x[i].style.display = "none";
                                }  
                        }
                    }
                });
            
            }
        });

        $(document).on('change', '.product_qty_sales_receipt', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_sales_receipt'  + position).html(number_format($('#select_product_rate_sales_receipt'  + position).attr('title') * $('#product_qty_sales_receipt' + position).val(),2));
            $('#total_amount_sales_receipt'  + position).attr('title',$('#select_product_rate_sales_receipt'  + position).attr('title') * $('#product_qty_sales_receipt' + position).val());
           
            update_total_sales_receipt();
        });

        $(document).on('change', '.sales_receipt_data', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_sales_receipt'  + position).html(number_format($('#select_product_rate_sales_receipt'  + position).attr('title') * $('#product_qty_sales_receipt' + position).val(),2));
            $('#total_amount_sales_receipt'  + position).attr('title',$('#select_product_rate_sales_receipt'  + position).attr('title') * $('#product_qty_sales_receipt' + position).val());
           
            update_total_sales_receipt();
        });


        $("#add_lines_sales_receipt").click(function(event){
            event.preventDefault();
            $("#sales_receipt_table").dataTable().fnDestroy();
            var count=$('#sales_receipt_table_tbody tr').length+parseFloat(1);
            var markup = '<tr class="sales_receipt_lines" id="sales_receipt_line'+count+'">';
            markup=markup+'<td class="pt-3-half" id="number_tag_sales_receipt" contenteditable="false">'+count+'</td>';
            markup=markup+'<td class="pt-3-half"><select style="background-color:white !important;" class="form-control" disabled onchange="ChangeParticularSalesReceipt(this)" data-columncount="'+count+'" id="ParticularSalesReceipt'+count+'"><option >Cost Center</option><option>Product/Services</option></select></td>';
            markup=markup+'<td class="pt-3-half"><div id="CostCenterSalesReceiptDiv'+count+'"><input style="background-color:white !important;" readonly type="text" id="cost_center_sales_creciept'+count+'" class="form-control" name="cost_center_sales_creciept'+count+'" list="cost_center_list_invoice"></div><div id="ProductServicesSalesReceiptDiv'+count+'"><select disabled style="border:0; width:100%;background-color:white !important;" class="sales_receipt_data product_select_sales_receipt form-control" id="select_product_name_sales_receipt'+count+'"><option value=""></option>'+product_list_js+'</select></div></td><td class="pt-3-half"><input type="text" class="w-100 form-control sales_receipt_data product_description_sales_receipt" readonly id="select_product_description_sales_receipt'+count+'" style="border:0;background-color:white !important;"></td><td class="pt-3-half"><input  type="number" class="sales_receipt_data product_qty_sales_receipt form-control" onclick="this.select();" readonly id="product_qty_sales_receipt'+count+'" style="background-color:white !important;border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="form-control sales_receipt_data product_rate_sales_receipt" readonly id="select_product_rate_sales_receipt'+count+'" style="border:0;text-align:right;background-color:white !important;"></td><td class="pt-3-half product_total_sales_receipt" style="text-align:right;padding-right:10px;" id="total_amount_sales_receipt'+count+'"></td><td class="pt-3-half" style="display:none;"><a href="#" style="display:none;" id="delete_product_sales_receipt'+count+'" class="fa fa-trash delete_product_sales_receipt"></a></td></tr>';
            
            $("#sales_receipt_table").append(markup);
            //sales_receipt_table_tbody
            //$("#sales_receipt_table").dataTable().fnDestroy();
            var sales_receipt_table=$("#sales_receipt_table").DataTable({
                paging: false,
                "ordering": true,
                'dom': 'Rlfrtip',
                "autoWidth": false,
                rowReorder: true
            });
            
            
            
            if(document.getElementById('sales_receipt_table_info')){
                document.getElementById('sales_receipt_table_info').style.display="none";
                document.getElementById('sales_receipt_table_filter').style.display="none";
                
            }
        }); 

        $("#clear_lines_sales_receipt").click(function(event){
            event.preventDefault();
            $('.sales_receipt_lines').remove();

            $('#sales_receipttotal').html('0.00');
        }); 

        $(document).on('click', '.delete_product_sales_receipt', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#sales_receipt_line'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var product_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".sales_receipt_lines").each(function() {
                $(this).attr("id","sales_receipt_line"+line_counter);
                line_counter++;
            });

            $(".delete_product_sales_receipt").each(function() {
                $(this).attr("id","delete_product_sales_receipt"+delete_counter);
                delete_counter++;
            });

            $(".sales_receipt_lines").find('#number_tag_sales_receipt').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.product_select_sales_receipt').each(function() {
                $(this).attr("id","select_product_name_sales_receipt"+product_id_counter);
                product_id_counter++;
            });

            $('.product_description_sales_receipt').each(function() {
                $(this).attr("id","select_product_description_sales_receipt"+description_id_counter);
                description_id_counter++;
            });

            $('.product_qty_sales_receipt').each(function() {
                $(this).attr("id","product_qty_sales_receipt"+qty_id_counter);
                qty_id_counter++;
            });

            $('.product_rate_sales_receipt').each(function() {
                $(this).attr("id","select_product_rate_sales_receipt"+rate_id_counter);
                rate_id_counter++;
            });

            $(".product_total_sales_receipt").each(function() {
                $(this).attr("id","total_amount_sales_receipt"+total_id_counter);
                total_id_counter++;
            });

            update_total_sales_receipt();
        }); 
        
        function update_total_sales_receipt(){
            var total_sales_receipt = 0;
            $('.product_total_sales_receipt').each(function() {
                var add_total = $(this).attr('title');
                if(add_total==""){
                    add_total=0;
                }
                total_sales_receipt += parseFloat(add_total);
                $('#sales_receipttotal').html(number_format(total_sales_receipt,2));
                $('#sales_receipttotal').attr('title',total_sales_receipt);
                $('#amountreceived_sr').val(total_sales_receipt);
                
            });
        }

        // ------------------------------------------------------------- REFUND RECEIPT STARTS HERE --------------------------
        
        $(document).on('change', '.product_select_refund_receipt', function(event){
            event.preventDefault();
            var id = $(this).val();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            if(id == ""){
                $('#select_product_description_refund_receipt' + position).val('');
                $('#select_product_rate_refund_receipt' + position).val('');
                $('#total_amount_refund_receipt' + position).html('');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_product_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (product) {
                        var price = product['product_sales_price'];
                        $('#select_product_description_refund_receipt' + position).val(product['product_sales_description']);
                        $('#select_product_rate_refund_receipt' + position).val(number_format(price,2));
                        // $('#select_product_rate_credit_note' + position).attr('title',price);
                        $('#total_amount_refund_receipt' + position).html(number_format(price * $('#product_qty_refund_receipt' + position).val(),2));
                        // $('#total_amount_credit_note' + position).attr('title',price * $('#product_qty_credit_note' + position).val());
                    }
                });
            
            }

            update_total_refund_receipt();
        });

        $(document).on('change', '#refundrcustomer', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                $('#refund_receiptbalance').html('PHP 0.00');
                $('#big_refund_receiptbalance').html('PHP 0.00');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_customer_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (customer) {
                        $('#refund_receiptbalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#big_refund_receiptbalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#rr_bill_address').val(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                        $('#rr_bill_address').val($('#rr_bill_address').val().replace(' null',''));
                        $('#rr_bill_address').val($('#rr_bill_address').val().replace(' null',''));
                        $('#rr_bill_address').val($('#rr_bill_address').val().replace(' null',''));
                        $('#rr_bill_address').val($('#rr_bill_address').val().replace(' null',''));
                        $('#rr_bill_address').val($('#rr_bill_address').val().replace(' null',''));
                        $('#rr_payment_method').val(customer['payment_method']);
                        $('#rr_email').val(customer['email']);
                        // $('#cheque_email').val(customer['terms']);
                    }
                });
            
            }
        });

        $(document).on('change', '.product_qty_refund_receipt', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_refund_receipt'  + position).html($('#select_product_rate_refund_receipt'  + position).val() * $('#product_qty_refund_receipt' + position).val());
           
            update_total_refund_receipt();
        });

        $(document).on('change', '.refund_receipt_data', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_refund_receipt'  + position).html($('#select_product_rate_refund_receipt'  + position).val() * $('#product_qty_refund_receipt' + position).val());
           
            update_total_refund_receipt();
        });


        $("#add_lines_refund_receipt").click(function(event){
            event.preventDefault();
            var markup = '<tr class="refund_receipt_lines" id="refund_receipt_line'+$('#refund_receipt_table tr').length+'"><td class="pt-3-half" id="number_tag_refund_receipt" contenteditable="false">'+$('#refund_receipt_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="refund_receipt_data product_select_refund_receipt" id="select_product_name_refund_receipt'+$('#refund_receipt_table tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="refund_receipt_data product_description_refund_receipt" id="select_product_description_refund_receipt'+$('#refund_receipt_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="refund_receipt_data product_qty_refund_receipt" onclick="this.select();" id="product_qty_refund_receipt'+$('#refund_receipt_table tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="refund_receipt_data product_rate_refund_receipt" id="select_product_rate_refund_receipt'+$('#refund_receipt_table tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_refund_receipt" id="total_amount_refund_receipt'+$('#refund_receipt_table tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_refund_receipt'+$('#refund_receipt_table tr').length+'" class="fa fa-trash delete_product_refund_receipt"></a></td></tr>';
            
            $("#refund_receipt_table").append(markup);


        }); 

        $("#clear_lines_refund_receipt").click(function(event){
            event.preventDefault();
            $('.refund_receipt_lines').remove();

            $('#refund_receipttotal').html('0.00');
            $('#refund_receipttotal1').html('0.00');
            $('#rr_amount_refunded').val('0.00');
        }); 

        $(document).on('click', '.delete_product_refund_receipt', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#refund_receipt_line'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var product_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".refund_receipt_lines").each(function() {
                $(this).attr("id","refund_receipt_line"+line_counter);
                line_counter++;
            });

            $(".delete_product_refund_receipt").each(function() {
                $(this).attr("id","delete_product_refund_receipt"+delete_counter);
                delete_counter++;
            });

            $(".refund_receipt_lines").find('#number_tag_refund_receipt').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.product_select_refund_receipt').each(function() {
                $(this).attr("id","select_product_name_refund_receipt"+product_id_counter);
                product_id_counter++;
            });

            $('.product_description_refund_receipt').each(function() {
                $(this).attr("id","select_product_description_refund_receipt"+description_id_counter);
                description_id_counter++;
            });

            $('.product_qty_refund_receipt').each(function() {
                $(this).attr("id","product_qty_refund_receipt"+qty_id_counter);
                qty_id_counter++;
            });

            $('.product_rate_refund_receipt').each(function() {
                $(this).attr("id","select_product_rate_refund_receipt"+rate_id_counter);
                rate_id_counter++;
            });

            $(".product_total_refund_receipt").each(function() {
                $(this).attr("id","total_amount_refund_receipt"+total_id_counter);
                total_id_counter++;
            });

            update_total_refund_receipt();
        }); 

        function update_total_refund_receipt(){
            var total_refund_receipt = 0;
            $('.product_total_refund_receipt').each(function() {
                var add_total = $(this).html();
                if(add_total==""){
                    add_total=0;
                }
                total_refund_receipt += parseFloat(add_total);
                $('#refund_receipttotal').html(total_refund_receipt);
                $('#refund_receipttotal1').html(total_refund_receipt);
                $('#rr_amount_refunded').val('0.00');
            });
        }

        // ------------------------------------------------------------- DELAYED CHARGE STARTS HERE --------------------------
        
        $(document).on('change', '.product_select_delayed_charge', function(event){
            event.preventDefault();
            var id = $(this).val();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            if(id == ""){
                $('#select_product_description_delayed_charge' + position).val('');
                $('#select_product_rate_delayed_charge' + position).val('');
                $('#total_amount_delayed_charge' + position).html('');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_product_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (product) {
                        var price = product['product_sales_price'];
                        $('#select_product_description_delayed_charge' + position).val(product['product_sales_description']);
                        $('#select_product_rate_delayed_charge' + position).val(number_format(price,2));
                        // $('#select_product_rate_credit_note' + position).attr('title',price);
                        $('#total_amount_delayed_charge' + position).html(number_format(price * $('#product_qty_delayed_charge' + position).val(),2));
                        // $('#total_amount_credit_note' + position).attr('title',price * $('#product_qty_credit_note' + position).val());
                    }
                });
            
            }

            update_total_delayed_charge();
        });

        $(document).on('change', '#delayedccustomer', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                $('#delayed_chargebalance').html('PHP 0.00');
                $('#big_delayed_chargebalance').html('PHP 0.00');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_customer_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (customer) {
                        $('#delayed_chargebalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#big_delayed_chargebalance').html('PHP '+number_format(customer['opening_balance'],2));
                        // $('#cn_bill_address').val(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                        // $('#cn_payment_method').val(customer['payment_method']);
                        // $('#cn_email').val(customer['email']);
                        // $('#cheque_email').val(customer['terms']);
                    }
                });
            
            }
        });

        $(document).on('change', '.product_qty_delayed_charge', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_delayed_charge'  + position).html($('#select_product_rate_delayed_charge'  + position).val() * $('#product_qty_delayed_charge' + position).val());
           
            update_total_delayed_charge();
        });

        $(document).on('change', '.delayed_charge_data', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_delayed_charge'  + position).html($('#select_product_rate_delayed_charge'  + position).val() * $('#product_qty_delayed_charge' + position).val());
           
            update_total_delayed_charge();
        });


        $("#add_lines_delayed_charge").click(function(event){
            event.preventDefault();
            var markup = '<tr class="delayed_charge_lines" id="delayed_charge_line'+$('#delayed_charge_table tr').length+'"><td class="pt-3-half" id="number_tag_delayed_charge" contenteditable="false">'+$('#delayed_charge_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="delayed_charge_data product_select_delayed_charge" id="select_product_name_delayed_charge'+$('#delayed_charge_table tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="delayed_charge_data product_description_delayed_charge" id="select_product_description_delayed_charge'+$('#delayed_charge_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="delayed_charge_data product_qty_delayed_charge" onclick="this.select();" id="product_qty_delayed_charge'+$('#delayed_charge_table tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="delayed_charge_data product_rate_delayed_charge" id="select_product_rate_delayed_charge'+$('#delayed_charge_table tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_delayed_charge" id="total_amount_delayed_charge'+$('#delayed_charge_table tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_delayed_charge'+$('#delayed_charge_table tr').length+'" class="fa fa-trash delete_product_delayed_charge"></a></td></tr>';
            
            $("#delayed_charge_table").append(markup);


        }); 

        $("#clear_lines_delayed_charge").click(function(event){
            event.preventDefault();
            $('.delayed_charge_lines').remove();

            $('#delayed_chargetotal').html('0.00');
        }); 

        $(document).on('click', '.delete_product_delayed_charge', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#delayed_charge_line'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var product_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".delayed_charge_lines").each(function() {
                $(this).attr("id","delayed_charge_line"+line_counter);
                line_counter++;
            });

            $(".delete_product_delayed_charge").each(function() {
                $(this).attr("id","delete_product_delayed_charge"+delete_counter);
                delete_counter++;
            });

            $(".delayed_charge_lines").find('#number_tag_delayed_charge').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.product_select_delayed_charge').each(function() {
                $(this).attr("id","select_product_name_delayed_charge"+product_id_counter);
                product_id_counter++;
            });

            $('.product_description_delayed_charge').each(function() {
                $(this).attr("id","select_product_description_delayed_charge"+description_id_counter);
                description_id_counter++;
            });

            $('.product_qty_delayed_charge').each(function() {
                $(this).attr("id","product_qty_delayed_charge"+qty_id_counter);
                qty_id_counter++;
            });

            $('.product_rate_delayed_charge').each(function() {
                $(this).attr("id","select_product_rate_delayed_charge"+rate_id_counter);
                rate_id_counter++;
            });

            $(".product_total_delayed_charge").each(function() {
                $(this).attr("id","total_amount_delayed_charge"+total_id_counter);
                total_id_counter++;
            });

            update_total_delayed_charge();
        }); 

        function update_total_delayed_charge(){
            var total_delayed_charge = 0;
            $('.product_total_delayed_charge').each(function() {
                var add_total = $(this).html();
                if(add_total==""){
                    add_total=0;
                }
                total_delayed_charge += parseFloat(add_total);
                $('#delayed_chargetotal').html(total_delayed_charge);
            });
        }

        // ------------------------------------------------------------- DELAYED CREDIT STARTS HERE --------------------------
        
        $(document).on('change', '.product_select_delayed_credit', function(event){
            event.preventDefault();
            var id = $(this).val();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            if(id == ""){
                $('#select_product_description_delayed_credit' + position).val('');
                $('#select_product_rate_delayed_credit' + position).val('');
                $('#total_amount_delayed_credit' + position).html('');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_product_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (product) {
                        var price = product['product_sales_price'];
                        $('#select_product_description_delayed_credit' + position).val(product['product_sales_description']);
                        $('#select_product_rate_delayed_credit' + position).val(number_format(price,2));
                        // $('#select_product_rate_credit_note' + position).attr('title',price);
                        $('#total_amount_delayed_credit' + position).html(number_format(price * $('#product_qty_delayed_credit' + position).val(),2));
                        // $('#total_amount_credit_note' + position).attr('title',price * $('#product_qty_credit_note' + position).val());
                    }
                });
            
            }

            update_total_delayed_credit();
        });

        $(document).on('change', '#delayedcreditcustomer', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                $('#delayed_creditbalance').html('PHP 0.00');
                $('#big_delayed_creditbalance').html('PHP 0.00');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_customer_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (customer) {
                        $('#delayed_creditbalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#big_delayed_creditbalance').html('PHP '+number_format(customer['opening_balance'],2));
                        // $('#cn_bill_address').val(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                        // $('#cn_payment_method').val(customer['payment_method']);
                        // $('#cn_email').val(customer['email']);
                        // $('#cheque_email').val(customer['terms']);
                    }
                });
           
            }
        });

        $(document).on('change', '.product_qty_delayed_credit', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_delayed_credit'  + position).html($('#select_product_rate_delayed_credit'  + position).val() * $('#product_qty_delayed_credit' + position).val());
           
            update_total_delayed_credit();
        });

        $(document).on('change', '.delayed_credit_data', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_delayed_credit'  + position).html($('#select_product_rate_delayed_credit'  + position).val() * $('#product_qty_delayed_credit' + position).val());
           
            update_total_delayed_credit();
        });


        $("#add_lines_delayed_credit").click(function(event){
            event.preventDefault();
            var markup = '<tr class="delayed_credit_lines" id="delayed_credit_line'+$('#delayed_credit_table tr').length+'"><td class="pt-3-half" id="number_tag_delayed_credit" contenteditable="false">'+$('#delayed_credit_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="delayed_credit_data product_select_delayed_credit" id="select_product_name_delayed_credit'+$('#delayed_credit_table tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="delayed_credit_data product_description_delayed_credit" id="select_product_description_delayed_credit'+$('#delayed_credit_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="delayed_credit_data product_qty_delayed_credit" onclick="this.select();" id="product_qty_delayed_credit'+$('#delayed_credit_table tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="delayed_credit_data product_rate_delayed_credit" id="select_product_rate_delayed_credit'+$('#delayed_credit_table tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_delayed_credit" id="total_amount_delayed_credit'+$('#delayed_credit_table tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_delayed_credit'+$('#delayed_credit_table tr').length+'" class="fa fa-trash delete_product_delayed_credit"></a></td></tr>';
            
            $("#delayed_credit_table").append(markup);


        }); 

        $("#clear_lines_delayed_credit").click(function(event){
            event.preventDefault();
            $('.delayed_credit_lines').remove();

            $('#delayed_credittotal').html('0.00');
        }); 

        $(document).on('click', '.delete_product_delayed_credit', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#delayed_credit_line'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var product_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".delayed_credit_lines").each(function() {
                $(this).attr("id","delayed_credit_line"+line_counter);
                line_counter++;
            });

            $(".delete_product_delayed_credit").each(function() {
                $(this).attr("id","delete_product_delayed_credit"+delete_counter);
                delete_counter++;
            });

            $(".delayed_credit_lines").find('#number_tag_delayed_credit').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.product_select_delayed_credit').each(function() {
                $(this).attr("id","select_product_name_delayed_credit"+product_id_counter);
                product_id_counter++;
            });

            $('.product_description_delayed_credit').each(function() {
                $(this).attr("id","select_product_description_delayed_credit"+description_id_counter);
                description_id_counter++;
            });

            $('.product_qty_delayed_credit').each(function() {
                $(this).attr("id","product_qty_delayed_credit"+qty_id_counter);
                qty_id_counter++;
            });

            $('.product_rate_delayed_credit').each(function() {
                $(this).attr("id","select_product_rate_delayed_credit"+rate_id_counter);
                rate_id_counter++;
            });

            $(".product_total_delayed_credit").each(function() {
                $(this).attr("id","total_amount_delayed_credit"+total_id_counter);
                total_id_counter++;
            });

            update_total_delayed_credit();
        }); 

        function update_total_delayed_credit(){
            var total_delayed_credit = 0;
            $('.product_total_delayed_credit').each(function() {
                var add_total = $(this).html();
                if(add_total==""){
                    add_total=0;
                }
                total_delayed_credit += parseFloat(add_total);
                $('#delayed_credittotal').html(total_delayed_credit);
            });
        }

        // ------------------------------------------------------------- CREDIT NOTICE STARTS HERE --------------------------
        
        $(document).on('change', '.product_select_credit_note', function(event){
            event.preventDefault();
            var id = $(this).val();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            if(id == ""){
                $('#select_product_description_credit_note' + position).val('');
                $('#select_product_rate_credit_note' + position).val('');
                $('#total_amount_credit_note' + position).html('');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_product_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (product) {
                        var price = product['product_sales_price'];
                        $('#select_product_description_credit_note' + position).val(product['product_sales_description']);
                        $('#select_product_rate_credit_note' + position).val(number_format(price,2));
                        $('#select_product_rate_credit_note' + position).attr('title',price);
                        $('#total_amount_credit_note' + position).html(number_format(price * $('#product_qty_credit_note' + position).val(),2));
                        $('#total_amount_credit_note' + position).attr('title',price * $('#product_qty_credit_note' + position).val());
                    }
                });
            
            }

            update_total_credit_note();
        });

        $(document).on('change', '#creditncustomer', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                $('#credit_notebalance').html('PHP 0.00');
                $('#big_credit_notebalance').html('PHP 0.00');
            }else{
                var res = id.split(" - ");
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_customer_info",
                    data: {id:res[0],_token:'{{csrf_token()}}'},
                    success: function (customer) {
                        $('#credit_notebalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#big_credit_notebalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#cn_bill_address').val(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                        $('#cn_bill_address').val($('#cn_bill_address').val().replace(' null',''));
                        $('#cn_bill_address').val($('#cn_bill_address').val().replace(' null',''));
                        $('#cn_bill_address').val($('#cn_bill_address').val().replace(' null',''));
                        $('#cn_bill_address').val($('#cn_bill_address').val().replace(' null',''));
                        $('#cn_bill_address').val($('#cn_bill_address').val().replace(' null',''));
                        $('#cn_payment_method').val(customer['payment_method']);
                        $('#cn_email').val(customer['email']);
                        // $('#cheque_email').val(customer['terms']);
                    }
                });
            
            }
        });

        $(document).on('change', '.product_qty_credit_note', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_credit_note'  + position).html(number_format($('#select_product_rate_credit_note'  + position).attr('title') * $('#product_qty_credit_note' + position).val(),2));
            $('#total_amount_credit_note'  + position).attr('title',$('#select_product_rate_credit_note'  + position).attr('title') * $('#product_qty_credit_note' + position).val());
           
            update_total_credit_note();
        });

        $(document).on('change', '.credit_note_data', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_credit_note'  + position).html(number_format($('#select_product_rate_credit_note'  + position).attr('title') * $('#product_qty_credit_note' + position).val(),2));
            $('#total_amount_credit_note'  + position).attr('title',$('#select_product_rate_credit_note'  + position).attr('title') * $('#product_qty_credit_note' + position).val());
           
            update_total_credit_note();
        });


        $("#add_lines_credit_note").click(function(event){
            event.preventDefault();
            $("#credit_note_table").dataTable().fnDestroy();
            var count=$('#credit_note_table_tbody tr').length+parseFloat(1);
            var markup = '<tr class="credit_note_lines" id="credit_note_line'+count+'">';
                    var table = document.getElementById("credit_note_table");
            var txt = "";
            var i;
            for (i = 0; i < table.rows[0].cells.length; i++) {
                txt = txt + table.rows[0].cells[i].innerHTML + "<br>";
                //console.log(txt);
                if(table.rows[0].cells[i].innerHTML=="#"){
                    markup=markup+'<td class="pt-3-half text-center" id="number_tag_credit_note" contenteditable="false">'+count+'</td>';
                }
                if(table.rows[0].cells[i].innerHTML=="PRODUCT/SERVICE"){
                    markup=markup+'<td class="pt-3-half"><select style="border:0; width:100%;" class="form-control credit_note_data product_select_credit_note" id="select_product_name_credit_note'+count+'"><option value=""></option>'+product_list_js+'</select></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="DESCRIPTION"){
                    markup=markup+'<td class="pt-3-half"><input class="form-control credit_note_data product_description_credit_note" id="select_product_description_credit_note'+count+'" style="border:0;"></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="QTY"){
                    markup=markup+'<td class="pt-3-half"><input type="number" class="form-control credit_note_data product_qty_credit_note" onclick="this.select();" id="product_qty_credit_note'+count+'" style="border:0; text-align:center;" value="1"></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="RATE"){
                    markup=markup+'<td class="pt-3-half"><input class="form-control credit_note_data product_rate_credit_note" readonly id="select_product_rate_credit_note'+count+'" style="border:0;text-align:right;background-color:white !important;"></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="AMOUNT"){
                    markup=markup+'<td class="pt-3-half product_total_credit_note" style="text-align:right;padding-right:10px;" id="total_amount_credit_note'+count+'"></td>';
                }
                if(table.rows[0].cells[i].innerHTML==""){
                    markup=markup+'<td class="pt-3-half text-center"><a href="#" id="delete_product_credit_note'+count+'" class="fa fa-trash delete_product_credit_note"></a></td>';
                }
            }
            markup=markup+'</tr>';
            
            $("#credit_note_table").append(markup);
            //credit_note_table_tbody
            //$("#invoice_table").dataTable().fnDestroy();
            var credit_note_table=$("#credit_note_table").DataTable({
                paging: false,
                "ordering": true,
                'dom': 'Rlfrtip',
                "autoWidth": false,
                rowReorder: true
            });
            
            
            
            if(document.getElementById('credit_note_table_info')){
                document.getElementById('credit_note_table_info').style.display="none";
                document.getElementById('credit_note_table_filter').style.display="none";
                credit_note_table.on( 'row-reorder', function ( e, diff, edit ) {
                var result = 'Reorder started on row: '+(edit.triggerRow.data())+'<br>';
                
                for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                    var rowData = credit_note_table.row( diff[i].node ).data();
                    result += rowData;
                    console.log(rowData[113]);
                    //result += rowData[1]+' updated to be in position '+
                    //    diff[i].newData+' (was '+diff[i].oldData+')<br>';
                }
                });
            }

        }); 

        $("#clear_lines_credit_note").click(function(event){
            event.preventDefault();
            $("#credit_note_table").dataTable().fnDestroy();
            $('.credit_note_lines').remove();

            $('#credit_notetotal').html('0.00');
        }); 

        $(document).on('click', '.delete_product_credit_note', function(event){
            event.preventDefault();
            $("#credit_note_table").dataTable().fnDestroy();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#credit_note_line'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var product_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".credit_note_lines").each(function() {
                $(this).attr("id","credit_note_line"+line_counter);
                line_counter++;
            });

            $(".delete_product_credit_note").each(function() {
                $(this).attr("id","delete_product_credit_note"+delete_counter);
                delete_counter++;
            });

            $(".credit_note_lines").find('#number_tag_credit_note').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.product_select_credit_note').each(function() {
                $(this).attr("id","select_product_name_credit_note"+product_id_counter);
                product_id_counter++;
            });

            $('.product_description_credit_note').each(function() {
                $(this).attr("id","select_product_description_credit_note"+description_id_counter);
                description_id_counter++;
            });

            $('.product_qty_credit_note').each(function() {
                $(this).attr("id","product_qty_credit_note"+qty_id_counter);
                qty_id_counter++;
            });

            $('.product_rate_credit_note').each(function() {
                $(this).attr("id","select_product_rate_credit_note"+rate_id_counter);
                rate_id_counter++;
            });

            $(".product_total_credit_note").each(function() {
                $(this).attr("id","total_amount_credit_note"+total_id_counter);
                total_id_counter++;
            });

            update_total_credit_note();
            var credit_note_table=$("#credit_note_table").DataTable({
                paging: false,
                "ordering": true,
                'dom': 'Rlfrtip',
                "autoWidth": false,
                rowReorder: true
            });
            
            
            
            if(document.getElementById('credit_note_table_info')){
                document.getElementById('credit_note_table_info').style.display="none";
                document.getElementById('credit_note_table_filter').style.display="none";
            }
        }); 

        function update_total_credit_note(){
            var total_credit_note = 0;
            $('.product_total_credit_note').each(function() {
                var add_total = $(this).attr('title');
                if(add_total==""){
                    add_total=0;
                }
                total_credit_note += parseFloat(add_total);
                $('#credit_notetotal').html(number_format(total_credit_note,2));
                $('#credit_notetotal').attr('title',total_credit_note);
            });
        }

        // ------------------------------------------------------------- EXPENSE TRANSACTION STARTS HERE --------------------------
        
        $(document).on('change', '.product_select_expense', function(event){
            event.preventDefault();
            var id = $(this).val();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            if(id == ""){
                $('#select_product_description_expense' + position).val('');
                $('#select_product_rate_expense' + position).val('');
                $('#total_amount_expense' + position).html('');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_product_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (product) {
                        var price = product['product_sales_price'];
                        $('#select_product_description_expense' + position).val(product['product_sales_description']);
                        $('#select_product_rate_expense' + position).val(number_format(price,2));
                        // $('#select_product_rate_expense' + position).attr('title',price);
                        $('#total_amount_expense' + position).html(number_format(price * $('#product_qty_expense' + position).val(),2));
                        $('#total_amount_expense' + position).attr('title',price * $('#product_qty_expense' + position).val());
                    }
                });
            
            }

            update_total_expense();
        });

        $(document).on('change', '#expensepayee', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                $('#expense_total_balance').html('PHP 0.00');
                $('#big_expensebalance').html('PHP 0.00');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_customer_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (customer) {
                        $('#expense_total_balance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#big_expensebalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#expense_bill_address').val((customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']).replace(" null", ""));
                        $('#expense_payment_method').val(customer['payment_method']);
                        $('#expense_email').val(customer['email']);
                        // $('#cheque_email').val(customer['terms']);
                    }
                });
            
            }
        });

        $(document).on('change', '.product_qty_expense', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_expense'  + position).html(number_format($('#select_product_rate_expense'  + position).val() * $('#product_qty_expense' + position).val(),2));
            $('#total_amount_expense'  + position).attr('title',$('#select_product_rate_expense'  + position).val() * $('#product_qty_expense' + position).val());
           
            update_total_expense();
        });

        $(document).on('change', '.expense_data', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_expense'  + position).html(number_format($('#select_product_rate_expense'  + position).val() * $('#product_qty_expense' + position).val(),2));
            $('#total_amount_expense'  + position).attr('title',$('#select_product_rate_expense'  + position).val() * $('#product_qty_expense' + position).val());
           
            update_total_expense();
        });


        $("#add_lines_expense_item").click(function(event){
            event.preventDefault();
            var markup = '<tr class="expense_lines_item" id="expense_line_item'+$('#expense_item_table tr').length+'"><td class="pt-3-half" id="number_tag_expense_item" contenteditable="false">'+$('#expense_item_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="expense_data product_select_expense" id="select_product_name_expense'+$('#expense_item_table tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="expense_data product_description_expense" id="select_product_description_expense'+$('#expense_item_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="expense_data product_qty_expense" onclick="this.select();" id="product_qty_expense'+$('#expense_item_table tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="expense_data product_rate_expense" id="select_product_rate_expense'+$('#expense_item_table tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_expense" id="total_amount_expense'+$('#expense_item_table tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_expense'+$('#expense_item_table tr').length+'" class="fa fa-trash delete_product_expense"></a></td></tr>';
            
            $("#expense_item_table").append(markup);


        }); 

        $("#clear_lines_expense_item").click(function(event){
            event.preventDefault();
            $('.expense_lines_item').remove();

            update_total_expense();
        }); 

        $("#add_lines_expense_account").click(function(event){
            event.preventDefault();
            var markup = '<tr class="expense_lines_account" id="expense_line_account'+$('#expense_account_table tr').length+'"><td class="pt-3-half" id="number_tag_expense_account" contenteditable="false">'+$('#expense_account_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" list="account_expenses" class="expense_data account_select_expense" id="select_account_expense'+$('#expense_account_table tr').length+'"><option></option>'+coa_list_js+'</select></td><td class="pt-3-half"><input class="expense_data description_select_expense" id="select_description_expense'+$('#expense_account_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="expense_data amount_select_expense" onclick="this.select();" id="select_expense_amount'+$('#expense_account_table tr').length+'" style="border:0; text-align:center;"></td><td class="pt-3-half"><a href="#" id="delete_account_expense'+$('#expense_account_table tr').length+'" class="fa fa-trash delete_account_expense"></a></td></tr>';
            
            $("#expense_account_table").append(markup);
        }); 

        $("#clear_lines_expense_account").click(function(event){
            event.preventDefault();
            $('.expense_lines_account').remove();

            update_total_expense();
        }); 

        $(document).on('click', '.delete_product_expense', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#expense_line_item'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var product_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".expense_lines_item").each(function() {
                $(this).attr("id","expense_line"+line_counter);
                line_counter++;
            });

            $(".delete_product_expense").each(function() {
                $(this).attr("id","delete_product_expense"+delete_counter);
                delete_counter++;
            });

            $(".expense_lines_item").find('#number_tag_expense_item').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.product_select_expense').each(function() {
                $(this).attr("id","select_product_name_expense"+product_id_counter);
                product_id_counter++;
            });

            $('.product_description_expense').each(function() {
                $(this).attr("id","select_product_description_expense"+description_id_counter);
                description_id_counter++;
            });

            $('.product_qty_expense').each(function() {
                $(this).attr("id","product_qty_expense"+qty_id_counter);
                qty_id_counter++;
            });

            $('.product_rate_expense').each(function() {
                $(this).attr("id","select_product_rate_expense"+rate_id_counter);
                rate_id_counter++;
            });

            $(".product_total_expense").each(function() {
                $(this).attr("id","total_amount_expense"+total_id_counter);
                total_id_counter++;
            });

            update_total_expense();
        }); 

        $(document).on('click', '.delete_account_expense', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#expense_line_account'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var account_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".expense_lines_account").each(function() {
                $(this).attr("id","expense_line_account"+line_counter);
                line_counter++;
            });

            $(".account_select_expense").each(function() {
                $(this).attr("id","select_account_expense"+account_id_counter);
                account_id_counter++;
            });

            $(".delete_account_expense").each(function() {
                $(this).attr("id","delete_account_expense"+delete_counter);
                delete_counter++;
            });

            $(".expense_lines_account").find('#number_tag_expense_account').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.description_select_expense').each(function() {
                $(this).attr("id","select_description_expense"+description_id_counter);
                description_id_counter++;
            });

            $('.amount_select_expense').each(function() {
                $(this).attr("id","select_expense_amount"+total_id_counter);
                total_id_counter++;
            });

            update_total_expense();
        }); 

        function update_total_expense(){
            var total_expense = 0;
            $('.product_total_expense').each(function() {
                var add_total = $(this).attr('title');
                if(add_total==""){
                    add_total=0;
                }
                total_expense += parseFloat(add_total);
                $('#expensetotal').html(number_format(total_expense,2));
            });
        }


        // ------------------------------------------------------------- CHEQUE TRANSACTION STARTS HERE --------------------------
        
        $(document).on('change', '.product_select_cheque', function(event){
            event.preventDefault();
            var id = $(this).val();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            if(id == ""){
                $('#select_product_description_cheque' + position).val('');
                $('#select_product_rate_cheque' + position).val('');
                $('#total_amount_cheque' + position).html('');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_product_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (product) {
                        var price = product['product_sales_price'];
                        $('#select_product_description_cheque' + position).val(product['product_sales_description']);
                        $('#select_product_rate_cheque' + position).val(number_format(price,2));
                        $('#select_product_rate_cheque' + position).attr('title',price);
                        $('#total_amount_cheque' + position).html(number_format(price * $('#product_qty_cheque' + position).val(),2));
                        $('#total_amount_cheque' + position).attr('title',price * $('#product_qty_cheque' + position).val());
                    }
                });
            
            }

            update_total_cheque();
        });

        $(document).on('change', '#chequepayee', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                $('#cheque_total_balance').html('PHP 0.00');
                $('#big_chequebalance').html('PHP 0.00');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_customer_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (customer) {
                        $('#cheque_total_balance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#big_chequebalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#cheque_billing_address').val(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                        $('#cheque_billing_address').val($('#cheque_billing_address').val().replace(' null',''));
                        $('#cheque_billing_address').val($('#cheque_billing_address').val().replace(' null',''));
                        $('#cheque_billing_address').val($('#cheque_billing_address').val().replace(' null',''));
                        $('#cheque_billing_address').val($('#cheque_billing_address').val().replace(' null',''));
                        $('#cheque_billing_address').val($('#cheque_billing_address').val().replace(' null',''));
                        $('#cheque_payment_method').val(customer['payment_method']);
                        $('#bill_email').val(customer['email']);
                        // $('#cheque_email').val(customer['terms']);
                    }
                });
           
            }
        });

        $(document).on('change', '.product_qty_cheque', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_cheque'  + position).html(number_format($('#select_product_rate_cheque'  + position).attr('title') * $('#product_qty_cheque' + position).val(),2));
            $('#total_amount_cheque'  + position).attr('title',$('#select_product_rate_cheque'  + position).attr('title') * $('#product_qty_cheque' + position).val());
           
            update_total_cheque();
        });

        $(document).on('change', '.cheque_data', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_cheque'  + position).html(number_format($('#select_product_rate_cheque'  + position).attr('title') * $('#product_qty_cheque' + position).val(),2));
            $('#total_amount_cheque'  + position).attr('title',$('#select_product_rate_cheque'  + position).attr('title') * $('#product_qty_cheque' + position).val());
            update_total_cheque();
        });


        $("#add_lines_cheque_item").click(function(event){
            event.preventDefault();
            var markup = '<tr class="cheque_lines_item" id="cheque_line_item'+$('#cheque_item_table tr').length+'"><td class="pt-3-half" id="number_tag_cheque_item" contenteditable="false">'+$('#cheque_item_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="cheque_data product_select_cheque" id="select_product_name_cheque'+$('#cheque_item_table tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="cheque_data product_description_cheque" id="select_product_description_cheque'+$('#cheque_item_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="cheque_data product_qty_cheque" onclick="this.select();" id="product_qty_cheque'+$('#cheque_item_table tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="cheque_data product_rate_cheque" id="select_product_rate_cheque'+$('#cheque_item_table tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_cheque" id="total_amount_cheque'+$('#cheque_item_table tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_cheque'+$('#cheque_item_table tr').length+'" class="fa fa-trash delete_product_cheque"></a></td></tr>';
            
            $("#cheque_item_table").append(markup);


        }); 
        $("#add_lines_cheque_item2").click(function(event){
            event.preventDefault();
            var markup = '<tr class="cheque_lines_item2" id="cheque_line_item_edit'+$('#cheque_item_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_cheque_item" contenteditable="false">'+$('#cheque_item_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="cheque_data product_select_cheque" id="select_product_name_cheque'+$('#cheque_item_tableedit tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="cheque_data product_description_cheque" id="select_product_description_cheque'+$('#cheque_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="cheque_data product_qty_cheque" onclick="this.select();" id="product_qty_cheque'+$('#cheque_item_tableedit tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="cheque_data product_rate_cheque" readonly id="select_product_rate_cheque'+$('#cheque_item_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_cheque" id="total_amount_cheque'+$('#cheque_item_tableedit tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_cheque_edit'+$('#cheque_item_tableedit tr').length+'" class="fa fa-trash delete_product_cheque_edit"></a></td></tr>';
            
            $("#cheque_item_tableedit").append(markup);


        }); 
        $("#clear_lines_cheque_item").click(function(event){
            event.preventDefault();
            $('.cheque_lines_item').remove();

            update_total_cheque();
        }); 

        $("#add_lines_cheque_account").click(function(event){
            event.preventDefault();
            var markup = '<tr class="cheque_lines_account" id="cheque_line_account'+$('#cheque_account_table tr').length+'"><td class="pt-3-half" id="number_tag_cheque_account" contenteditable="false">'+$('#cheque_account_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" list="account_expenses" class="cheque_data account_select_cheque" id="select_account_cheque'+$('#cheque_account_table tr').length+'"><option></option>'+coa_list_js+'</select></td><td class="pt-3-half"><input class="cheque_data description_select_cheque" id="select_description_cheque'+$('#cheque_account_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="cheque_data amount_select_cheque" onclick="this.select();" id="select_cheque_amount'+$('#cheque_account_table tr').length+'" style="border:0; text-align:center;"></td><td class="pt-3-half"><a href="#" id="delete_account_cheque'+$('#cheque_account_table tr').length+'" class="fa fa-trash delete_account_cheque"></a></td></tr>';
            
            $("#cheque_account_table").append(markup);
        }); 

        $("#clear_lines_cheque_account").click(function(event){
            event.preventDefault();
            $('.cheque_lines_account').remove();

            update_total_cheque();
        }); 
        $(document).on('click','.delete_product_cheque_edit',function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#cheque_line_item_edit'+position).remove();
        })
        $(document).on('click', '.delete_product_cheque', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#cheque_line_item'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var product_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".cheque_lines_item").each(function() {
                $(this).attr("id","cheque_line"+line_counter);
                line_counter++;
            });

            $(".delete_product_cheque").each(function() {
                $(this).attr("id","delete_product_cheque"+delete_counter);
                delete_counter++;
            });

            $(".cheque_lines_item").find('#number_tag_cheque_item').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.product_select_cheque').each(function() {
                $(this).attr("id","select_product_name_cheque"+product_id_counter);
                product_id_counter++;
            });

            $('.product_description_cheque').each(function() {
                $(this).attr("id","select_product_description_cheque"+description_id_counter);
                description_id_counter++;
            });

            $('.product_qty_cheque').each(function() {
                $(this).attr("id","product_qty_cheque"+qty_id_counter);
                qty_id_counter++;
            });

            $('.product_rate_cheque').each(function() {
                $(this).attr("id","select_product_rate_cheque"+rate_id_counter);
                rate_id_counter++;
            });

            $(".product_total_cheque").each(function() {
                $(this).attr("id","total_amount_cheque"+total_id_counter);
                total_id_counter++;
            });

            update_total_cheque();
        }); 

        $(document).on('click', '.delete_account_cheque', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#cheque_line_account'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var account_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".cheque_lines_account").each(function() {
                $(this).attr("id","cheque_line_account"+line_counter);
                line_counter++;
            });

            $(".account_select_cheque").each(function() {
                $(this).attr("id","select_account_cheque"+account_id_counter);
                account_id_counter++;
            });

            $(".delete_account_cheque").each(function() {
                $(this).attr("id","delete_account_cheque"+delete_counter);
                delete_counter++;
            });

            $(".cheque_lines_account").find('#number_tag_cheque_account').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.description_select_cheque').each(function() {
                $(this).attr("id","select_description_cheque"+description_id_counter);
                description_id_counter++;
            });

            $('.amount_select_cheque').each(function() {
                $(this).attr("id","select_cheque_amount"+total_id_counter);
                total_id_counter++;
            });

            update_total_cheque();
        }); 

        function update_total_cheque(){
            var total_cheque = 0;
            $('.product_total_cheque').each(function() {
                var add_total = $(this).attr('title');
                if(add_total==""){
                    add_total=0;
                }
                total_cheque += parseFloat(add_total);
                $('#chequeitem_total').html(number_format(total_cheque,2));
                $('#cheque_edit_item_total').html(number_format(total_cheque,2));
            });
        }


        // ------------------------------------------------------------- BILL TRANSACTION STARTS HERE --------------------------
        $(document).on('change', '#bill_terms', function(event){
                event.preventDefault();

                var term = $('#bill_terms').val();

                if(term=="Due on receipt" && $('#bill_date_bill').val()==""){
                    $('#bill_date_bill').val(new Date().toDateInputValue());
                    $('#bill_due_date_bill').val(new Date().toDateInputValue());
                }else if(term=="Due on receipt"){
                    $('#bill_due_date_bill').val($('#bill_date_bill').val());
                }else if(term=="Net 15"  && $('#bill_date_bill').val()==""){
                    $('#bill_date_bill').val(new Date().toDateInputValue());
                    $('#bill_due_date_bill').val(new Date(new Date().getTime()+(15*24*60*60*1000)).toDateInputValue());
                }else if(term=="Net 15"){
                    var date= $('#bill_date_bill')[0].valueAsDate;
                    date.setDate(date.getDate() + 15);
                    $('#bill_due_date_bill')[0].valueAsDate = date;
                }else if(term=="Net 30"  && $('#bill_date_bill').val()==""){
                    $('#bill_date_bill').val(new Date().toDateInputValue());
                    $('#bill_due_date_bill').val(new Date(new Date().getTime()+(30*24*60*60*1000)).toDateInputValue());
                }else if(term=="Net 30"){
                    var date= $('#bill_date_bill')[0].valueAsDate;
                    date.setDate(date.getDate() + 30);
                    $('#bill_due_date_bill')[0].valueAsDate = date;
                }else if(term=="Net 60"  && $('#bill_date_bill').val()==""){
                    $('#bill_date_bill').val(new Date().toDateInputValue());
                    $('#bill_due_date_bill').val(new Date(new Date().getTime()+(60*24*60*60*1000)).toDateInputValue());
                }else if(term=="Net 60"){
                    var date= $('#bill_date_bill')[0].valueAsDate;
                    date.setDate(date.getDate() + 60);
                    $('#bill_due_date_bill')[0].valueAsDate = date;
                }else{
                    
                }
            });
           
            $(document).ready(function(){
                $('#bill_terms').trigger('change');
                //document.getElementById('bill_terms').change();
            });
            
            $(document).on('change', '#bill_date_bill', function(event){
                event.preventDefault();

                var term = $('#bill_terms').val();

                if(term=="Due on receipt"){
                    $('#bill_due_date_bill').val($('#bill_date_bill').val());
                }else if(term=="Net 15"){
                    var date= $('#bill_date_bill')[0].valueAsDate;
                    date.setDate(date.getDate() + 15);
                    $('#bill_due_date_bill')[0].valueAsDate = date;
                }else if(term=="Net 30"){
                    var date= $('#bill_date_bill')[0].valueAsDate;
                    date.setDate(date.getDate() + 30);
                    $('#bill_due_date_bill')[0].valueAsDate = date;
                }else if(term=="Net 60"){
                    var date= $('#bill_date_bill')[0].valueAsDate;
                    date.setDate(date.getDate() + 60);
                    $('#bill_due_date_bill')[0].valueAsDate = date;
                }else{
                    $('#bill_due_date_bill').val($('#bill_date_bill').val());
                }
            });
        $(document).on('change', '.product_select_bill', function(event){
            event.preventDefault();
            var id = $(this).val();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            if(id == ""){
                $('#select_product_description_bill' + position).val('');
                $('#select_product_rate_bill' + position).val('');
                $('#total_amount_bill' + position).html('');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_product_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (product) {
                        var price = product['product_sales_price'];
                        $('#select_product_description_bill' + position).val(product['product_sales_description']);
                        $('#select_product_rate_bill' + position).val(price);
                        $('#total_amount_bill' + position).html(price * $('#product_qty_bill' + position).val());
                    }
                });
            
            }

            update_total_bill();
        });

        $(document).on('change', '#billpayee', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                $('#billbalance').html('PHP 0.00');
                $('#big_billbalance').html('PHP 0.00');
            }else{
                var res = id.split(" - ");
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_customer_info",
                    data: {id:res[0],_token:'{{csrf_token()}}'},
                    success: function (customer) {
                        console.log(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                        $('#billbalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#big_billbalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#bill_billing_address').val(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                        $('#bill_billing_address').val($('#bill_billing_address').val().replace(' null',''));
                        $('#bill_billing_address').val($('#bill_billing_address').val().replace(' null',''));
                        $('#bill_billing_address').val($('#bill_billing_address').val().replace(' null',''));
                        $('#bill_billing_address').val($('#bill_billing_address').val().replace(' null',''));
                        $('#bill_billing_address').val($('#bill_billing_address').val().replace(' null',''));
                        $('#bill_billing_address').val($('#bill_billing_address').val().replace('null',''));
                        $('#bill_payment_method').val(customer['payment_method']);
                        $('#bill_email').val(customer['email']);
                        $('#bill_terms').val(customer['terms']);
                    }
                });
            }
        });

        $(document).on('change', '.product_qty_bill', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_bill'  + position).html($('#select_product_rate_bill'  + position).val() * $('#product_qty_bill' + position).val());
           
            update_total_bill();
        });

        $(document).on('change', '.bill_data', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_bill'  + position).html($('#select_product_rate_bill'  + position).val() * $('#product_qty_bill' + position).val());
           
            update_total_bill();
        });


        $("#add_lines_bill_item").click(function(event){
            event.preventDefault();
            var markup = '<tr class="bill_lines_item" id="bill_line_item'+$('#bill_item_table tr').length+'"><td class="pt-3-half" id="number_tag_bill_item" contenteditable="false">'+$('#bill_item_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="bill_data product_select_bill" id="select_product_name_bill'+$('#bill_item_table tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="form-control bill_data product_description_bill" id="select_product_description_bill'+$('#bill_item_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="bill_data product_qty_bill form-control" onclick="this.select();" id="product_qty_bill'+$('#bill_item_table tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="bill_data product_rate_bill form-control" id="select_product_rate_bill'+$('#bill_item_table tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_bill" id="total_amount_bill'+$('#bill_item_table tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_bill'+$('#bill_item_table tr').length+'" class="fa fa-trash delete_product_bill"></a></td></tr>';
            
            $("#bill_item_table").append(markup);


        }); 

        $("#clear_lines_bill_item").click(function(event){
            event.preventDefault();
            $('.bill_lines_item').remove();

            update_total_bill();
        }); 

        $("#add_lines_bill_account").click(function(event){
            event.preventDefault();
            $("#bill_account_table").dataTable().fnDestroy();
            var count=$('#bill_account_table_tbody tr').length+parseFloat(1);
            var markup = '<tr class="bill_lines_account" id="bill_line_account'+count+'">';
            var table = document.getElementById("bill_account_table");
            var txt = "";
            var i;
            for (i = 0; i < table.rows[0].cells.length; i++) {
                txt = txt + table.rows[0].cells[i].innerHTML + "<br>";
                //console.log(txt);
                if(table.rows[0].cells[i].innerHTML=="#"){
                    markup=markup+'<td class="pt-3-half text-center" id="number_tag_bill_account" contenteditable="false">'+count+'</td>';
                }
                if(table.rows[0].cells[i].innerHTML=="ACCOUNT"){
                    markup=markup+'<td class="pt-3-half"><select style="border:0; width:100%;" list="account_expenses" class="form-control bill_data account_select_bill selectpicker" data-live-search="true" id="select_account_bill'+count+'"><option value="">--Select Account--</option>'+coa_list_js+'</select></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="DESCRIPTION"){
                    markup=markup+'<td class="pt-3-half"><input class="bill_data description_select_bill form-control" id="select_description_bill'+count+'" style="border:0;"></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="AMOUNT"){
                    markup=markup+'<td class="pt-3-half"><input type="text" class="form-control" id="unformated_select_bill_amount'+count+'" style="border:0;text-align:right;" value="0.00"><input type="hidden" class="bill_data amount_select_bill" onclick="this.select();" id="select_bill_amount'+count+'" style="border:0; text-align:center;"></td>';
                }
                if(table.rows[0].cells[i].innerHTML==""){
                    markup=markup+'<td class="pt-3-half text-center"><a href="#" id="delete_account_bill'+count+'" class="fa fa-trash delete_account_bill"></a></td>'; 
                }
            }
            markup=markup+'</tr>';
            var textbox = '#unformated_select_bill_amount'+count;
            var hidden = '#select_bill_amount'+count;
            $("#bill_account_table_tbody").append(markup);
            
            $(textbox).keyup(function () {
                $(textbox).val(this.value.match(/[0-9.,=]*/));
            var num = $(textbox).val();
                var comma = /,/g;
                num = num.replace(comma,'');
                $(hidden).val(num);
                var numCommas = addCommas(num);
                $(textbox).val(numCommas);
            });
            document.getElementById('setselectpickerbutton').click();
            //bill_account_table_tbody
            //$("#invoice_table").dataTable().fnDestroy();
            var bill_account_table=$("#bill_account_table").DataTable({
                paging: false,
                "ordering": true,
                'dom': 'Rlfrtip',
                "autoWidth": false,
                rowReorder: true
            });
            if(document.getElementById('bill_account_table_info')){
                document.getElementById('bill_account_table_info').style.display="none";
                document.getElementById('bill_account_table_filter').style.display="none";
                bill_account_table.on( 'row-reorder', function ( e, diff, edit ) {
                //console.log("asdasdasd->>>> "+edit.triggerRow.data());
                var result = 'Reorder started on row: '+(edit.triggerRow.data())+'<br>';
                
                for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                    var rowData = bill_account_table.row( diff[i].node ).data();
                    result += rowData;
                    console.log(rowData[0]);
                    //result += rowData[1]+' updated to be in position '+
                    //    diff[i].newData+' (was '+diff[i].oldData+')<br>';
                }
                });
            }
        }); 
        
            
        $("#clear_lines_bill_account").click(function(event){
            event.preventDefault();
            $("#bill_account_table").dataTable().fnDestroy();
            $('.bill_lines_account').remove();

            update_total_bill();
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
        $(document).on('click', '.delete_product_bill', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#bill_line_item'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var product_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".bill_lines_item").each(function() {
                $(this).attr("id","bill_line"+line_counter);
                line_counter++;
            });

            $(".delete_product_bill").each(function() {
                $(this).attr("id","delete_product_bill"+delete_counter);
                delete_counter++;
            });

            $(".bill_lines_item").find('#number_tag_bill_item').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.product_select_bill').each(function() {
                $(this).attr("id","select_product_name_bill"+product_id_counter);
                product_id_counter++;
            });

            $('.product_description_bill').each(function() {
                $(this).attr("id","select_product_description_bill"+description_id_counter);
                description_id_counter++;
            });

            $('.product_qty_bill').each(function() {
                $(this).attr("id","product_qty_bill"+qty_id_counter);
                qty_id_counter++;
            });

            $('.product_rate_bill').each(function() {
                $(this).attr("id","select_product_rate_bill"+rate_id_counter);
                rate_id_counter++;
            });

            $(".product_total_bill").each(function() {
                $(this).attr("id","total_amount_bill"+total_id_counter);
                total_id_counter++;
            });

            update_total_bill();
            
        }); 

        $(document).on('click', '.delete_account_bill', function(event){
            event.preventDefault();

            $("#bill_account_table").dataTable().fnDestroy();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#bill_line_account'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var account_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".bill_lines_account").each(function() {
                $(this).attr("id","bill_line_account"+line_counter);
                line_counter++;
            });
            destroy_select_picker('account_select_bill');
            $(".account_select_bill").each(function() {
                $(this).addClass( "selectpicker" );
                $(this).attr("id","select_account_bill"+account_id_counter);
                account_id_counter++;
            });
            
            $(".delete_account_bill").each(function() {
                $(this).addClass( "selectpicker" );
                $(this).attr("id","delete_account_bill"+delete_counter);
                delete_counter++;
            });

            $(".bill_lines_account").find('#number_tag_bill_account').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.description_select_bill').each(function() {
                $(this).attr("id","select_description_bill"+description_id_counter);
                description_id_counter++;
            });

            $('.amount_select_bill').each(function() {
                $(this).attr("id","select_bill_amount"+total_id_counter);
                total_id_counter++;
            });

            update_total_bill();
            var bill_account_table=$("#bill_account_table").DataTable({
                paging: false,
                "ordering": true,
                'dom': 'Rlfrtip',
                "autoWidth": false,
                rowReorder: true
            });
            if(document.getElementById('bill_account_table_info')){
                document.getElementById('bill_account_table_info').style.display="none";
                document.getElementById('bill_account_table_filter').style.display="none";
                bill_account_table.on( 'row-reorder', function ( e, diff, edit ) {
                //console.log("asdasdasd->>>> "+edit.triggerRow.data());
                var result = 'Reorder started on row: '+(edit.triggerRow.data())+'<br>';
                
                for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                    var rowData = bill_account_table.row( diff[i].node ).data();
                    result += rowData;
                    console.log(rowData[0]);
                    //result += rowData[1]+' updated to be in position '+
                    //    diff[i].newData+' (was '+diff[i].oldData+')<br>';
                }
                });
            }
            refreshpicjer();
            
        }); 

        function update_total_bill(){
            var total_bill = 0;
            $('.product_total_bill').each(function() {
                var add_total = $(this).html();
                if(add_total==""){
                    add_total=0;
                }
                total_bill += parseFloat(add_total);
                $('#billtotal').html(total_bill);
            });
        }

        // ------------------------------------------------------------- PURCHASE ORDER TRANSACTION STARTS HERE --------------------------
        
        $(document).on('change', '.product_select_po', function(event){
            event.preventDefault();
            var id = $(this).val();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            if(id == ""){
                $('#select_product_description_po' + position).val('');
                $('#select_product_rate_po' + position).val('');
                $('#total_amount_po' + position).html('');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_product_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (product) {
                        var price = product['product_sales_price'];
                        $('#select_product_description_po' + position).val(product['product_sales_description']);
                        $('#select_product_rate_po' + position).val(price);
                        $('#total_amount_po' + position).html(price * $('#product_qty_po' + position).val());
                    }
                });
            
            }

            update_total_po();
        });

        $(document).on('change', '#po_customer', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                $('#pobalance').html('PHP 0.00');
                $('#big_pobalance').html('PHP 0.00');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_customer_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (customer) {
                        $('#pobalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#big_pobalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#po_mail_address').val(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                        $('#po_mail_address').val($('#po_mail_address').val().replace(' null',''));
                        $('#po_mail_address').val($('#po_mail_address').val().replace(' null',''));
                        $('#po_mail_address').val($('#po_mail_address').val().replace(' null',''));
                        $('#po_mail_address').val($('#po_mail_address').val().replace(' null',''));
                        $('#po_mail_address').val($('#po_mail_address').val().replace(' null',''));
                        $('#po_payment_method').val(customer['payment_method']);
                        $('#po_email').val(customer['email']);
                        $('#po_terms').val(customer['terms']);
                    }
                });
            
            }
        });

        $(document).on('change', '.product_qty_po', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_po'  + position).html($('#select_product_rate_po'  + position).val() * $('#product_qty_po' + position).val());
           
            update_total_po();
        });

        $(document).on('change', '.po_data', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_po'  + position).html($('#select_product_rate_po'  + position).val() * $('#product_qty_po' + position).val());
           
            update_total_po();
        });


        $("#add_lines_po_item").click(function(event){
            event.preventDefault();
            var markup = '<tr class="po_lines_item" id="po_line_item'+$('#po_item_table tr').length+'"><td class="pt-3-half" id="number_tag_po_item" contenteditable="false">'+$('#po_item_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="po_data product_select_po" id="select_product_name_po'+$('#po_item_table tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="po_data product_description_po" id="select_product_description_po'+$('#po_item_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="po_data product_qty_po" onclick="this.select();" id="product_qty_po'+$('#po_item_table tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="po_data product_rate_po" id="select_product_rate_po'+$('#po_item_table tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_po" id="total_amount_po'+$('#po_item_table tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_po'+$('#po_item_table tr').length+'" class="fa fa-trash delete_product_po"></a></td></tr>';
            
            $("#po_item_table").append(markup);


        }); 

        $("#clear_lines_po_item").click(function(event){
            event.preventDefault();
            $('.po_lines_item').remove();

            update_total_po();
        }); 

        $("#add_lines_po_account").click(function(event){
            event.preventDefault();
            var markup = '<tr class="po_lines_account" id="po_line_account'+$('#po_account_table tr').length+'"><td class="pt-3-half" id="number_tag_po_account" contenteditable="false">'+$('#po_account_table tr').length+'</td><td class="pt-3-half"><input style="border:0; width:100%;" list="account_expenses" class="po_data account_select_po" id="select_account_po'+$('#po_account_table tr').length+'"></td><td class="pt-3-half"><input class="po_data description_select_po" id="select_description_po'+$('#po_account_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="po_data amount_select_po" onclick="this.select();" id="select_po_amount'+$('#po_account_table tr').length+'" style="border:0; text-align:center;"></td><td class="pt-3-half"><a href="#" id="delete_account_po'+$('#po_account_table tr').length+'" class="fa fa-trash delete_account_po"></a></td></tr>';
            
            $("#po_account_table").append(markup);
        }); 

        $("#clear_lines_po_account").click(function(event){
            event.preventDefault();
            $('.po_lines_account').remove();

            update_total_po();
        }); 

        $(document).on('click', '.delete_product_po', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#po_line_item'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var product_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".po_lines_item").each(function() {
                $(this).attr("id","po_line"+line_counter);
                line_counter++;
            });

            $(".delete_product_po").each(function() {
                $(this).attr("id","delete_product_po"+delete_counter);
                delete_counter++;
            });

            $(".po_lines_item").find('#number_tag_po_item').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.product_select_po').each(function() {
                $(this).attr("id","select_product_name_po"+product_id_counter);
                product_id_counter++;
            });

            $('.product_description_po').each(function() {
                $(this).attr("id","select_product_description_po"+description_id_counter);
                description_id_counter++;
            });

            $('.product_qty_po').each(function() {
                $(this).attr("id","product_qty_po"+qty_id_counter);
                qty_id_counter++;
            });

            $('.product_rate_po').each(function() {
                $(this).attr("id","select_product_rate_po"+rate_id_counter);
                rate_id_counter++;
            });

            $(".product_total_po").each(function() {
                $(this).attr("id","total_amount_po"+total_id_counter);
                total_id_counter++;
            });

            update_total_po();
        }); 

        $(document).on('click', '.delete_account_po', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#po_line_account'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var account_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".po_lines_account").each(function() {
                $(this).attr("id","po_line_account"+line_counter);
                line_counter++;
            });

            $(".account_select_po").each(function() {
                $(this).attr("id","select_account_po"+account_id_counter);
                account_id_counter++;
            });

            $(".delete_account_po").each(function() {
                $(this).attr("id","delete_account_po"+delete_counter);
                delete_counter++;
            });

            $(".po_lines_account").find('#number_tag_po_account').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.description_select_po').each(function() {
                $(this).attr("id","select_description_po"+description_id_counter);
                description_id_counter++;
            });

            $('.amount_select_po').each(function() {
                $(this).attr("id","select_po_amount"+total_id_counter);
                total_id_counter++;
            });

            update_total_po();
        }); 

        function update_total_po(){
            var total_po = 0;
            $('.product_total_po').each(function() {
                var add_total = $(this).html();
                if(add_total==""){
                    add_total=0;
                }
                total_po += parseFloat(add_total);
                $('#pototal').html(total_po);
            });
        }

        // ------------------------------------------------------------- SUPPLIER CREDIT TRANSACTION STARTS HERE --------------------------
        
        $(document).on('change', '.product_select_sc', function(event){
            event.preventDefault();
            var id = $(this).val();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            if(id == ""){
                $('#select_product_description_sc' + position).val('');
                $('#select_product_rate_sc' + position).val('');
                $('#total_amount_sc' + position).html('');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_product_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (product) {
                        var price = product['product_sales_price'];
                        $('#select_product_description_sc' + position).val(product['product_sales_description']);
                        $('#select_product_rate_sc' + position).val(price);
                        $('#total_amount_sc' + position).html(price * $('#product_qty_sc' + position).val());
                    }
                }); 
           
            }

            update_total_sc();
        });

        $(document).on('change', '#sc_customer', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                $('#scbalance').html('PHP 0.00');
                $('#big_scbalance').html('PHP 0.00');
            }else{
                var res = id.split(" - ");
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_customer_info",
                    data: {id:res[0],_token:'{{csrf_token()}}'},
                    success: function (customer) {
                        $('#scbalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#big_scbalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#sc_mail_address').val(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                        $('#sc_mail_address').val($('#sc_mail_address').val().replace(' null',''));
                        $('#sc_mail_address').val($('#sc_mail_address').val().replace(' null',''));
                        $('#sc_mail_address').val($('#sc_mail_address').val().replace(' null',''));
                        $('#sc_mail_address').val($('#sc_mail_address').val().replace(' null',''));
                        $('#sc_mail_address').val($('#sc_mail_address').val().replace(' null',''));
                        $('#sc_payment_method').val(customer['payment_method']);
                        $('#sc_email').val(customer['email']);
                        $('#sc_terms').val(customer['terms']);
                    }
                });
            
            }
        });

        $(document).on('change', '.product_qty_sc', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_sc'  + position).html($('#select_product_rate_sc'  + position).val() * $('#product_qty_sc' + position).val());
           
            update_total_sc();
        });

        $(document).on('change', '.sc_data', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_sc'  + position).html($('#select_product_rate_sc'  + position).val() * $('#product_qty_sc' + position).val());
           
            update_total_sc();
        });
        

        $("#add_lines_sc_item").click(function(event){
            event.preventDefault();
            var markup = '<tr class="sc_lines_item" id="sc_line_item'+$('#sc_item_table tr').length+'"><td class="pt-3-half" id="number_tag_sc_item" contenteditable="false">'+$('#sc_item_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="sc_data product_select_sc" id="select_product_name_sc'+$('#sc_item_table tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="sc_data product_description_sc" id="select_product_description_sc'+$('#sc_item_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="sc_data product_qty_sc" onclick="this.select();" id="product_qty_sc'+$('#sc_item_table tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="sc_data product_rate_sc" id="select_product_rate_sc'+$('#sc_item_table tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_sc" id="total_amount_sc'+$('#sc_item_table tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_sc'+$('#sc_item_table tr').length+'" class="fa fa-trash delete_product_sc"></a></td></tr>';
            
            $("#sc_item_table").append(markup);


        }); 
        
        $("#clear_lines_sc_item").click(function(event){
            event.preventDefault();
            $('.sc_lines_item').remove();

            update_total_sc();
        });

        
        $("#add_lines_sc_account").click(function(event){
            event.preventDefault();
            $("#sc_account_table").dataTable().fnDestroy();
            var count=$('#sc_account_table_tbody tr').length+parseFloat(1);
            var markup = '<tr class="sc_lines_account" id="sc_line_account'+count+'">';
            var table = document.getElementById("sc_account_table");
            var txt = "";
            var i;
            for (i = 0; i < table.rows[0].cells.length; i++) {
                txt = txt + table.rows[0].cells[i].innerHTML + "<br>";
                //console.log(txt);
                if(table.rows[0].cells[i].innerHTML=="#"){
                    markup=markup+'<td class="pt-3-half text-center" id="number_tag_sc_account" contenteditable="false">'+count+'</td>';
                }
                if(table.rows[0].cells[i].innerHTML=="ACCOUNT"){
                    markup=markup+'<td class="pt-3-half"><select style="border:0; width:100%;" list="account_expenses" class="sc_data account_select_sc selectpicker form-control" data-live-search="true" id="select_account_sc'+count+'"><option value="">--Select Account--</option>'+coa_list_js+'</select></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="DESCRIPTION"){
                    markup=markup+'<td class="pt-3-half"><input class="sc_data description_select_sc form-control" id="select_description_sc'+count+'" style="border:0;"></td>';
                }
                if(table.rows[0].cells[i].innerHTML=="AMOUNT"){
                    markup=markup+'<td class="pt-3-half"><input type="number" class="sc_data amount_select_sc form-control" onclick="this.select();" id="select_sc_amount'+count+'" style="border:0; text-align:right;"></td>';
                }
                if(table.rows[0].cells[i].innerHTML==""){
                    markup=markup+'<td class="pt-3-half text-center"><a href="#" id="delete_account_sc'+count+'" class="fa fa-trash delete_account_sc"></a></td>';
                }
            }
            markup=markup+'</tr>';
            
            $("#sc_account_table_tbody").append(markup);
            document.getElementById('setselectpickerbutton').click();
            var invoice_table=$("#sc_account_table").DataTable({
                paging: false,
                "ordering": true,
                'dom': 'Rlfrtip',
                "autoWidth": false,
                rowReorder: true
            });
            if(document.getElementById('sc_account_table_info')){
                document.getElementById('sc_account_table_info').style.display="none";
                document.getElementById('sc_account_table_filter').style.display="none";
                invoice_table.on( 'row-reorder', function ( e, diff, edit ) {
                    //console.log("asdasdasd->>>> "+edit.triggerRow.data());
                    var result = 'Reorder started on row: '+(edit.triggerRow.data())+'<br>';
                    
                    for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                        var rowData = invoice_table.row( diff[i].node ).data();
                        result += rowData;
                        console.log(rowData[0]);
                        //result += rowData[1]+' updated to be in position '+
                        //    diff[i].newData+' (was '+diff[i].oldData+')<br>';
                    }
                });
            }
        }); 

        $("#clear_lines_sc_account").click(function(event){
            event.preventDefault();
            $("#sc_account_table").dataTable().fnDestroy();
            $('.sc_lines_account').remove();

            update_total_sc();
        }); 

        $(document).on('click', '.delete_product_sc', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#sc_line_item'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var product_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".sc_lines_item").each(function() {
                $(this).attr("id","sc_line"+line_counter);
                line_counter++;
            });

            $(".delete_product_sc").each(function() {
                $(this).attr("id","delete_product_sc"+delete_counter);
                delete_counter++;
            });

            $(".sc_lines_item").find('#number_tag_sc_item').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.product_select_sc').each(function() {
                $(this).attr("id","select_product_name_sc"+product_id_counter);
                product_id_counter++;
            });

            $('.product_description_sc').each(function() {
                $(this).attr("id","select_product_description_sc"+description_id_counter);
                description_id_counter++;
            });

            $('.product_qty_sc').each(function() {
                $(this).attr("id","product_qty_sc"+qty_id_counter);
                qty_id_counter++;
            });

            $('.product_rate_sc').each(function() {
                $(this).attr("id","select_product_rate_sc"+rate_id_counter);
                rate_id_counter++;
            });

            $(".product_total_sc").each(function() {
                $(this).attr("id","total_amount_sc"+total_id_counter);
                total_id_counter++;
            });

            update_total_sc();
        }); 

        $(document).on('click', '.delete_account_sc', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#sc_line_account'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var account_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".sc_lines_account").each(function() {
                $(this).attr("id","sc_line_account"+line_counter);
                line_counter++;
            });

            $(".account_select_sc").each(function() {
                $(this).attr("id","select_account_sc"+account_id_counter);
                account_id_counter++;
            });

            $(".delete_account_sc").each(function() {
                $(this).attr("id","delete_account_sc"+delete_counter);
                delete_counter++;
            });

            $(".sc_lines_account").find('#number_tag_sc_account').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.description_select_sc').each(function() {
                $(this).attr("id","select_description_sc"+description_id_counter);
                description_id_counter++;
            });

            $('.amount_select_sc').each(function() {
                $(this).attr("id","select_sc_amount"+total_id_counter);
                total_id_counter++;
            });

            update_total_sc();
        }); 

        function update_total_sc(){
            var total_sc = 0;
            $('.product_total_sc').each(function() {
                var add_total = $(this).html();
                if(add_total==""){
                    add_total=0;
                }
                total_sc += parseFloat(add_total);
                $('#sctotal').html(total_sc);
            });
        }
        
        // ------------------------------------------------------------- CREDIT CARD CHARGE TRANSACTION STARTS HERE --------------------------
        
        $(document).on('change', '.product_select_cc', function(event){
            event.preventDefault();
            var id = $(this).val();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            if(id == ""){
                $('#select_product_description_cc' + position).val('');
                $('#select_product_rate_cc' + position).val('');
                $('#total_amount_cc' + position).html('');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_product_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (product) {
                        var price = product['product_sales_price'];
                        $('#select_product_description_cc' + position).val(product['product_sales_description']);
                        $('#select_product_rate_cc' + position).val(price);
                        $('#total_amount_cc' + position).html(price * $('#product_qty_cc' + position).val());
                    }
                });   

            }

            update_total_cc();
        });

        $(document).on('change', '#cc_customer', function(event){
            event.preventDefault();
            var id = $(this).val();
            if(id == ""){
                $('#ccbalance').html('PHP 0.00');
                $('#big_ccbalance').html('PHP 0.00');
            }else{
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "get_customer_info",
                    data: {id:id,_token:'{{csrf_token()}}'},
                    success: function (customer) {
                        $('#ccbalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#big_ccbalance').html('PHP '+number_format(customer['opening_balance'],2));
                        $('#cc_mail_address').val(customer['street']+" "+customer['city']+" "+customer['state']+" "+customer['postal_code']+" "+customer['country']);
                        $('#cc_mail_address').val($('#cc_mail_address').val().replace(' null',''));
                        $('#cc_mail_address').val($('#cc_mail_address').val().replace(' null',''));
                        $('#cc_mail_address').val($('#cc_mail_address').val().replace(' null',''));
                        $('#cc_mail_address').val($('#cc_mail_address').val().replace(' null',''));
                        $('#cc_mail_address').val($('#cc_mail_address').val().replace(' null',''));
                        $('#cc_payment_method').val(customer['payment_method']);
                        $('#cc_email').val(customer['email']);
                        $('#cc_terms').val(customer['terms']);
                    }
                });
            }
        });

        $(document).on('change', '.product_qty_cc', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_cc'  + position).html($('#select_product_rate_cc'  + position).val() * $('#product_qty_cc' + position).val());
           
            update_total_cc();
        });

        $(document).on('change', '.cc_data', function(){
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#total_amount_cc'  + position).html($('#select_product_rate_cc'  + position).val() * $('#product_qty_cc' + position).val());
           
            update_total_cc();
        });


        $("#add_lines_cc_item").click(function(event){
            event.preventDefault();
            var markup = '<tr class="cc_lines_item" id="cc_line_item'+$('#cc_item_table tr').length+'"><td class="pt-3-half" id="number_tag_cc_item" contenteditable="false">'+$('#cc_item_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="cc_data product_select_cc" id="select_product_name_cc'+$('#cc_item_table tr').length+'"><option value=""></option>'+product_list_js+'</select></td><td class="pt-3-half"><input class="cc_data product_description_cc" id="select_product_description_cc'+$('#cc_item_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="cc_data product_qty_cc" onclick="this.select();" id="product_qty_cc'+$('#cc_item_table tr').length+'" style="border:0; text-align:center;" value="1"></td><td class="pt-3-half"><input class="cc_data product_rate_cc" id="select_product_rate_cc'+$('#cc_item_table tr').length+'" style="border:0;"></td><td class="pt-3-half product_total_cc" id="total_amount_cc'+$('#cc_item_table tr').length+'"></td><td class="pt-3-half"><a href="#" id="delete_product_cc'+$('#cc_item_table tr').length+'" class="fa fa-trash delete_product_cc"></a></td></tr>';
            
            $("#cc_item_table").append(markup);


        }); 

        $("#clear_lines_cc_item").click(function(event){
            event.preventDefault();
            $('.cc_lines_item').remove();

            update_total_cc();
        }); 

        $("#add_lines_cc_account").click(function(event){
            event.preventDefault();
            var markup = '<tr class="cc_lines_account" id="cc_line_account'+$('#cc_account_table tr').length+'"><td class="pt-3-half" id="number_tag_cc_account" contenteditable="false">'+$('#cc_account_table tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="cc_data account_select_cc" id="select_account_cc'+$('#cc_account_table tr').length+'"><option></option>'+coa_list_js+'</select></td><td class="pt-3-half"><input class="cc_data description_select_cc" id="select_description_cc'+$('#cc_account_table tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="cc_data amount_select_cc" onclick="this.select();" id="select_cc_amount'+$('#cc_account_table tr').length+'" style="border:0; text-align:center;"></td><td class="pt-3-half"><a href="#" id="delete_account_cc'+$('#cc_account_table tr').length+'" class="fa fa-trash delete_account_cc"></a></td></tr>';
            
            $("#cc_account_table").append(markup);
        });
        $("#add_lines_cc_accountedit").click(function(event){
            event.preventDefault();
            var markup = '<tr class="cc_line_accountedit" id="cc_line_accountedit'+$('#cc_account_tableedit tr').length+'"><td class="pt-3-half" id="number_tag_cc_accountedit" contenteditable="false">'+$('#cc_account_tableedit tr').length+'</td><td class="pt-3-half"><select style="border:0; width:100%;" class="cc_data account_select_cc" id="select_account_ccedit'+$('#cc_account_tableedit tr').length+'"><option></option>'+coa_list_js+'</select></td><td class="pt-3-half"><input class="cc_data description_select_cc" id="select_description_ccedit'+$('#cc_account_tableedit tr').length+'" style="border:0;"></td><td class="pt-3-half"><input type="number" class="cc_data amount_select_cc" onclick="this.select();" id="select_cc_amountedit'+$('#cc_account_tableedit tr').length+'" style="border:0; text-align:center;"></td><td class="pt-3-half"><a href="#" id="delete_account_ccedit'+$('#cc_account_tableedit tr').length+'" onclick="DeleteRowCreditCard('+$('#cc_account_tableedit tr').length+')" class="fa fa-trash delete_account_ccedit"></a></td></tr>';
            
            $("#cc_account_tableedit").append(markup);
        });
        

        $("#clear_lines_cc_account").click(function(event){
            event.preventDefault();
            $('.cc_lines_account').remove();

            update_total_cc();
        }); 
        $("#clear_lines_cc_accountedit").click(function(event){
            event.preventDefault();
            $('.cc_line_accountedit').remove();

            update_total_cc();
        }); 
        

        $(document).on('click', '.delete_product_cc', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#cc_line_item'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var product_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".cc_lines_item").each(function() {
                $(this).attr("id","cc_line"+line_counter);
                line_counter++;
            });

            $(".delete_product_cc").each(function() {
                $(this).attr("id","delete_product_cc"+delete_counter);
                delete_counter++;
            });

            $(".cc_lines_item").find('#number_tag_cc_item').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.product_select_cc').each(function() {
                $(this).attr("id","select_product_name_cc"+product_id_counter);
                product_id_counter++;
            });

            $('.product_description_cc').each(function() {
                $(this).attr("id","select_product_description_cc"+description_id_counter);
                description_id_counter++;
            });

            $('.product_qty_cc').each(function() {
                $(this).attr("id","product_qty_cc"+qty_id_counter);
                qty_id_counter++;
            });

            $('.product_rate_cc').each(function() {
                $(this).attr("id","select_product_rate_cc"+rate_id_counter);
                rate_id_counter++;
            });

            $(".product_total_cc").each(function() {
                $(this).attr("id","total_amount_cc"+total_id_counter);
                total_id_counter++;
            });

            update_total_cc();
        }); 

        $(document).on('click', '.delete_account_cc', function(event){
            event.preventDefault();
            var position = $(this).attr('id').replace(/[^0-9\.]/g, '');
            $('#cc_line_account'+position).remove();
            
            var line_counter = 1;
            var delete_counter = 1;
            var tag_counter = 1;
            var account_id_counter = 1;
            var description_id_counter = 1;
            var qty_id_counter = 1;
            var rate_id_counter = 1;
            var total_id_counter = 1;

            $(".cc_lines_account").each(function() {
                $(this).attr("id","cc_line_account"+line_counter);
                line_counter++;
            });

            $(".account_select_cc").each(function() {
                $(this).attr("id","select_account_cc"+account_id_counter);
                account_id_counter++;
            });

            $(".delete_account_cc").each(function() {
                $(this).attr("id","delete_account_cc"+delete_counter);
                delete_counter++;
            });

            $(".cc_lines_account").find('#number_tag_cc_account').each(function() {
                $(this).html(tag_counter);
                tag_counter++;
            });

            $('.description_select_cc').each(function() {
                $(this).attr("id","select_description_cc"+description_id_counter);
                description_id_counter++;
            });

            $('.amount_select_cc').each(function() {
                $(this).attr("id","select_cc_amount"+total_id_counter);
                total_id_counter++;
            });

            update_total_cc();
        }); 

        function update_total_cc(){
            var total_cc = 0;
            $('.product_total_cc').each(function() {
                var add_total = $(this).html();
                if(add_total==""){
                    add_total=0;
                }
                total_cc += parseFloat(add_total);
                $('#cctotal').html(total_cc);
            });
        }

    });    

 
</script>