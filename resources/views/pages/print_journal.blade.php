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
</style>

<table id="jounalentrytable" class="table table-bordered table-responsive-md table-sm  font14" width="100%">
        <thead>
            <tr>
                <th colspan="20" class="text-center"><b>{{$journal_type_query->journal_type}}</b></th>
            </tr>
            <tr id="thead_tr_print_withCSS" style="background-color:rgb(228, 236, 247);color:#green;">
                
                <th width="5%" class="text-center">JOURNAL DATE</th>
                <th width="5%" class="text-center">JOURNAL NO</th>
                <th class="text-center" width="5%">CODE</th>
                <th class="text-center" width="10%">ACCOUNT</th>
                <th class="text-center" width="10%">COST CENTER</th> 
                <th class="text-center" width="10%">DEBITS</th>
                <th class="text-center" width="10%">CREDITS</th>
                <th class="text-center" width="10%">DESCRIPTION</th>
                
                <th class="text-center" width="10%">PAYEE</th>
                @if ($journal_type_query->journal_type=="Cheque Voucher")
                <th class="text-center" width="5%">CHEQUE NO</th>
                @endif
                <th class="text-center" width="8%">REFERENCE</th> 
                <th class="text-center" width="5%">DATE DEPOSITED</th>
            </tr>
        </thead>
        <tbody>
            @if(count($JournalEntry)>0)
            @foreach($JournalEntry as $je)
                @if ($Journal_no_selected==$je->je_no)
                    <tr>
                        <td style="vertical-align:middle;text-align:center;">{{date("m-d-Y", strtotime($je->created_at))}} </td>
                        <td style="vertical-align:middle;text-align:center;">{{$je->je_no}}</td>
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
                        <td style="vertical-align:middle;">{{is_numeric($je->je_account)==true? $journalaccount : $je->je_account}}</td>
                        <td style="vertical-align:middle;">
                            @foreach ($cost_center_list_all as $ccla)
                                @if ($ccla->cc_no==$je->je_cost_center)
                                    {{$ccla->cc_name}}
                                @endif
                            @endforeach
                        </td>
                        <td style="vertical-align:middle;">{{$je->je_debit!=""? number_format($je->je_debit,2): ""}}</td>
                        <td style="vertical-align:middle;">{{$je->je_credit!=""? number_format($je->je_credit,2) : ""}}</td>
                        <td style="vertical-align:middle;">{{$je->je_desc}}</td>
                        <td style="vertical-align:middle;">
                            {{$je->je_name}}
                            
                        </td>
                        @if ($journal_type_query->journal_type=="Cheque Voucher")
                        <td style="vertical-align:middle;">
                            {{$je->cheque_no}}
                            
                        </td>
                        @endif
                        
                        <td style="vertical-align:middle;">
                            {{$je->ref_no}}
                            
                        </td>
                        <td style="vertical-align:middle;">
                            @if (DateTime::createFromFormat('Y-m-d H:i:s', $je->date_deposited) !== FALSE)
                                {{date('m-d-Y',strtotime($je->date_deposited))}}
                            @endif
                            
                            
                        </td>
                        </tr>  
                @endif
                
            @endforeach
            @endif

            
        </tbody>
            <!-- This is our clonable table line -->
    </table>
<script>
$(document).ready(function(){
    html2canvas(document.querySelector("#jounalentrytable")).then(function(canvas) {
    var canvasImg = canvas.toDataURL("image/jpg");
    //$('#test').html('<img src="'+canvasImg+'" alt="">');
    var myImage = canvas.toDataURL("image/png");
    var tmp = document.body.innerHTML;
    document.body.innerHTML = '<img style="width:100%;" src="'+myImage+'" alt="" >';
    setTimeout(function()
    {
        var printWindow = window.print();
        document.body.innerHTML = tmp;
        window.close();
    }, 2000);


    });
})
</script>
@endsection