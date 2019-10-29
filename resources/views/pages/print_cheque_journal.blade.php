@extends('layout.no_side_navs')


@section('content')
<style>

@media print {
    #thead_tr_print_withCSS{ 
    color-adjust: exact !important;
    -webkit-print-color-adjust: exact !important;
    
    }
    
}

body{
    background-color: #F5F5F5;
}
#jounalentrytable td{
    border:0px solid #ccc !important;
}
.voucherprint_header td{
    border:0px solid #ccc !important;
}
#voucher_tables_print_area{
    
    margin:.5in auto;
    padding-left:10px;
    padding-right:10px;
    width:8in;
    height:3in;
    
    background-color:#ffffff;
}
</style>
<?php 
$total_debit_journal=0;
$total_credit_journal=0;

?>
@if(count($JournalEntry)>0)
@foreach($JournalEntry as $je)
    @if ($Journal_no_selected==$je->je_no)
        <?php 
        if($je->je_debit!=""){
            $total_debit_journal+=$je->je_debit;
        }
        if($je->je_credit!=""){
            $total_credit_journal+=$je->je_credit;
        }
        ?>
    @endif
@endforeach
@endif
<div id="voucher_tables_print_area" style="">
    <table class="table table-sm  font14" style="margin-bottom:30px;" >
        <tbody class="voucherprint_header" >
            <tr style="font-size:8px;">
                <td style="vertical-align:top !important;padding-top:2px;">
                    ACCOUNT No. <b></b>
                </td>
                <td style="vertical-align:top !important;padding-top:2px;">
                    ACCOUNT NAME <b></b>
                </td>
                <td style="vertical-align:top !important;padding-top:2px;">
                    CHECK No. <b>{{$journal_type_query->cheque_no}}</b>
                </td>
                <td style="vertical-align:top !important;padding-top:2px;">
                    R/T No. <b></b>
                </td>
                
            </tr>
        </tbody>
    </table>
    <table class="table table-sm  font14"  style="margin-bottom:0px;">
        <tbody class="voucherprint_header" >
            <tr>
                
                <td  width="80%" style="text-align:right;vertical-align:bottom !important;">
                    DATE 
                </td>
                <td style="text-align:center;font-size:13px;vertical-align:bottom !important;border-bottom:1px solid black !important;"> <b>{{date('m/d/Y',strtotime($journal_type_query->je_attachment))}}</b></td>
            </tr>
        </tbody>
    </table>
    <table class="table table-sm  font14"  >
        <tbody class="voucherprint_header" >
            <tr>
                
                <td style="text-align:justified;vertical-align:bottom !important;">
                    PAY TO THE ORDER OF
                </td>
                <td width="75%" style="font-weight:bold;font-size:13px;border-bottom:1px solid black !important;vertical-align:bottom !important;text-transform: uppercase;">
                    {{$journal_type_query->je_name}}
                </td>
                <td style="text-align:right;vertical-align:bottom !important;">
                    &#8369;
                </td>
            <td style="font-weight:bold;font-size:13px;vertical-align:bottom !important;border-bottom:1px solid black !important;" title="{{$total_debit_journal}}" id="number_formatted_value">{{number_format($total_debit_journal,2)}}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-sm  font14"  >
        <tbody class="voucherprint_header" >
            <tr>
                
                <td style="text-align:justified;vertical-align:bottom !important;">
                    PESOS
                </td>
                <td width="90%" style="font-weight:bold;font-size:13px;border-bottom:1px solid black !important;vertical-align:bottom !important;text-transform: capitalize;" id="words">
                   
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table table-sm  font14"  >
        <tbody class="voucherprint_header" >
            <tr>
                <td style="text-align:justified;vertical-align:top !important;font-size:15px;font-weight:bold;">
                    BANK LOGO PLACEHOLDER
                </td>
                <td width="20%" style="font-weight:bold;font-size:13px;border-bottom:1px solid black !important;vertical-align:bottom !important;padding-top:40px;" >
                   
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

const arr = x => Array.from(x);
const num = x => Number(x) || 0;
const str = x => String(x);
const isEmpty = xs => xs.length === 0;
const take = n => xs => xs.slice(0,n);
const drop = n => xs => xs.slice(n);
const reverse = xs => xs.slice(0).reverse();
const comp = f => g => x => f (g (x));
const not = x => !x;
const chunk = n => xs =>
  isEmpty(xs) ? [] : [take(n)(xs), ...chunk (n) (drop (n) (xs))];

// numToWords :: (Number a, String a) => a -> String
let numToWords = n => {
  
  let a = [
    '', 'one', 'two', 'three', 'four',
    'five', 'six', 'seven', 'eight', 'nine',
    'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
    'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
  ];
  
  let b = [
    '', '', 'twenty', 'thirty', 'forty',
    'fifty', 'sixty', 'seventy', 'eighty', 'ninety'
  ];
  
  let g = [
    '', 'thousand', 'million', 'billion', 'trillion', 'quadrillion',
    'quintillion', 'sextillion', 'septillion', 'octillion', 'nonillion'
  ];
  
  // this part is really nasty still
  // it might edit this again later to show how Monoids could fix this up
  let makeGroup = ([ones,tens,huns]) => {
    return [
      num(huns) === 0 ? '' : a[huns] + ' hundred ',
      num(ones) === 0 ? b[tens] : b[tens] && b[tens] + ' ' || '',
      a[tens+ones] || a[ones]
    ].join('');
  };
  
  let thousand = (group,i) => group === '' ? group : `${group} ${g[i]}`;
  
  if (typeof n === 'number')
    return numToWords(String(n));
  else if (n === '0')
    return 'zero';
  else
    return comp (chunk(3)) (reverse) (arr(n))
      .map(makeGroup)
      .map(thousand)
      .filter(comp(not)(isEmpty))
      .reverse()
      .join(' ');
};

$(document).ready(function(){
    
    document.getElementById('words').innerHTML = numToWords(document.getElementById('number_formatted_value').getAttribute('title'))+" Only";

    html2canvas(document.querySelector("#voucher_tables_print_area")).then(function(canvas) {
    var canvasImg = canvas.toDataURL("image/jpg");
    //$('#test').html('<img src="'+canvasImg+'" alt="">');
    var myImage = canvas.toDataURL("image/png");
    var tmp = document.body.innerHTML;
    document.body.innerHTML = '<img style="display: block;margin-top:10%;margin-left: auto;margin-right: auto;border:1px dotted #ccc" src="'+myImage+'" alt="" >';
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