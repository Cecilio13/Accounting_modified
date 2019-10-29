@extends('layout.no_side_navs')


@section('content')
<style>

@media print {
    #thead_tr_print_withCSS{ 
    background-color:rgb(228, 236, 247);color:green;
    color-adjust: exact !important;
    -webkit-print-color-adjust: exact !important;
    
    }
    
}
#voucher_tables_print_area{
    border:double;
    margin:.5in auto;
    padding-left:.5in;
    padding-right:.5in;
    width: 6in;
}
.voucherprint_header td{
    border:0px solid #ccc !important;
}
.voucherprint_footer td{
    border:0px solid #ccc !important;
}
.voucherprint_footer input{
    border-bottom:1px solid #ccc !important;
    background-color: white !important;
}
</style>

<div style="border: double;background-color:white;" id="voucher_tables_print_area">
            <table class="table table-sm  font14" style="margin-top:10px;margin-bottom:0px;border:0;">
                <tbody class="voucherprint_header" >
                    <tr>    
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                    <td colspan="4" style="font-weight:bold;text-align:center;font-size:16px;text-decoration: underline;text-transform: uppercase;">{{$company_setting->company_legal_name!=''? $company_setting->company_legal_name : $company_setting->company_name}}</td>
                    </tr>
                    <tr>    
                        <td colspan="4" style="text-align:right;">No : {{$journal_type_query->je_series_no}}</td>
                    </tr>
                    <tr>    
                        <td colspan="4" style="text-align:right;">Date : {{date('m-d-Y',strtotime($journal_type_query->je_attachment))}}</td>
                    </tr>
                    <tr>    
                        <td colspan="4" style="text-align:left;">Pay To : {{$journal_type_query->je_name}}</td>
                    </tr>
                </tbody>
            </table>
            <table id="jounalentrytable" class="table table-bordered  table-sm  font14" style="margin-bottom:0px;border:1px solid black">
                
                <thead>
                    <tr id="thead_tr_print_withCSS" style="background-color:rgb(228, 236, 247);color:#green;">
                        <th class="text-center" width="10%">ACCOUNT CODE</th>
                        <th class="text-center" width="15%">PARTICULARS</th>
                        <th class="text-center" width="8%">DEBITS</th>
                        <th class="text-center" width="8%">CREDITS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_debit_journal=0;
                    $total_credit_journal=0;

                    ?>
                    @if(count($JournalEntry)>0)
                    @foreach($JournalEntry as $je)
                        @if ($Journal_no_selected==$je->je_no)
                            <tr>
                                <td style="vertical-align:middle;text-align:center;">
                                    @foreach ($COA as $coa)
                                        @if($coa->id==$je->je_account)
                                        {{$coa->coa_code}}
                                        <?php break; ?>
                                        @endif
                                    @endforeach
                                </td>
                                <?php
                                $journalaccount="";
                                ?>
                                @foreach ($COA as $coa)
                                    @if($coa->id==$je->je_account)
                                    <?php
                                    $journalaccount=$coa->coa_name;
                                    ?>
                                    @endif
                                @endforeach
                                <td style="vertical-align:middle;">{{$je->je_desc}}</td>
                                <td style="vertical-align:middle;text-align:right;">{{$je->je_debit!=""? number_format($je->je_debit,2): ""}}</td>
                                <td style="vertical-align:middle;text-align:right;">{{$je->je_credit!=""? number_format($je->je_credit,2) : ""}}</td>
                                <?php
                                if($je->je_debit!=""){
                                    $total_debit_journal+=$je->je_debit;
                                }
                                if($je->je_credit!=""){
                                    $total_credit_journal+=$je->je_credit;
                                }
                                
                                

                                ?>
                            </tr>  
                        @endif
                    @endforeach
                    @endif
                    <tr>
                        <td style="vertical-align:middle;text-align:center;">
                        </td>
                        <td style="vertical-align:middle;text-align:right;font-weight:bold;">TOTAL :</td>
                        <td style="vertical-align:middle;text-align:right;font-weight:bold;">{{number_format($total_debit_journal,2)}}</td>
                        <td style="vertical-align:middle;text-align:right;font-weight:bold;">{{number_format($total_credit_journal,2)}}</td>
                        
                    </tr>  
                </tbody>
            </table>
            <table class="table table-sm  font14" style="border:0;">
                <tbody class="voucherprint_footer" >
                    
                    <tr>
                        <td colspan="3" style="font-size:12px;text-align:left;"><!--Bank Account :--> </td>
                        <td colspan="3" style="font-size:12px;text-align:right;">Cheque No. : {{$journal_type_query->cheque_no!=""? $journal_type_query->cheque_no : '__________'}}</td>
                    </tr>
                    <tr>    
                        <td colspan="2" style="text-align:left;">Prepared by : <input type="text" readonly style="width:50%;"></td>
                        <td colspan="2" style="text-align:left;">Signature : <input type="text" readonly style="width:50%;"></td>
                        <td colspan="2" style="text-align:left;">Date : <input type="text" readonly style="width:50%;"></td>
                    </tr>
                    <tr>    
                        <td colspan="2" style="text-align:left;">Approved by : <input type="text" readonly style="width:50%;"></td>
                        <td colspan="2" style="text-align:left;">Signature : <input type="text" readonly style="width:50%;"></td>
                        <td colspan="2" style="text-align:left;">Date : <input type="text" readonly style="width:50%;"></td>
                    </tr>
                    <tr>    
                        <td colspan="2" style="text-align:left;">Recorded by : <input type="text" readonly style="width:50%;"></td>
                        <td colspan="2" style="text-align:left;">Signature : <input type="text" readonly style="width:50%;"></td>
                        <td colspan="2" style="text-align:left;">Date : <input type="text" readonly style="width:50%;"></td>
                    </tr>
                </tbody>
            </table>
    </div>

<script>
$(document).ready(function(){
    html2canvas(document.querySelector("#voucher_tables_print_area")).then(function(canvas) {
    var canvasImg = canvas.toDataURL("image/jpg");
    //$('#test').html('<img src="'+canvasImg+'" alt="">');
    var myImage = canvas.toDataURL("image/png");
    var tmp = document.body.innerHTML;
    document.body.innerHTML = '<img style="display: block;margin-top:10%;margin-left: auto;margin-right: auto;" src="'+myImage+'" alt="" >';
    setTimeout(function()
    {
        var printWindow = window.print();
        document.body.innerHTML = tmp;
        window.close();
    }, 2000);


    });
})
</script>
<div class="loading" id="import_overlay">
Loading&#8230;
</div>
@endsection