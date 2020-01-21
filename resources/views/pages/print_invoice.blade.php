@extends('layout.no_side_navs')


@section('content')
<div class="container">
    <style>
        p{
            display: inline;
        }
    </style>
    <div class="col-md-12 col-sm-12 p-0 "  id="page-wrapper-print_invoice">
        <div class="col-md-12 col-sm-12 p-0 ">
            <div class="col-md-6 col-sm-6 p-0 pr-3">
                <p>Customer : </p>
                <p style="font-weight:bold;">{{$customer!=""? $customer : '______________________________'}}</p>
            </div>
            <div class="col-md-3 col-sm-3 p-0 pr-3">
                <p>Location : </p>
                <p style="font-weight:bold;">{{$location!=""? $location : '____________________'}}</p>
              
            </div>
            <div class="col-md-3 col-sm-3 p-0 pr-3">
                <p>Type : </p>
                <p style="font-weight:bold;">{{$type!=""? $type : '____________________'}}</p>
            
            </div>
        </div>
        <div class="col-md-12 col-sm-12 p-0 ">
            <div class="col-md-6 col-sm-6 p-0 pr-3">
                <p>Billing Address : </p>
                <p style="font-weight:bold;">{{$address!=""? $address : '______________________________________'}}</p>
            </div>
            <div class="col-md-3 col-sm-3 p-0 pr-3">
                <p>Invoice No : </p>
                <p style="font-weight:bold;">{{$no!=""? $no : '____________________'}}</p>
            
            </div>
            <div class="col-md-3 col-sm-3 p-0 pr-3">
                <p>Terms : </p>
                <p style="font-weight:bold;">{{$terms!=""? $terms : '____________________'}}</p>
            
            </div>
        </div>
        <div class="col-md-12 col-sm-12 p-0 ">
            <div class="col-md-6 col-sm-6 p-0 pr-3">
                <p>Email : </p>
                <p style="font-weight:bold;text-decoration:underline;">{{$email!=""? $email : '____________________________________'}}</p>
            
            </div>
            <div class="col-md-3 col-sm-3 p-0 pr-3">
                <p>Invoice Date : </p>
                <p style="font-weight:bold;">{{$invoice_date!=""? date('m-d-Y',strtotime($invoice_date)) : '____________________'}}</p>
            
            </div>
            <div class="col-md-3 col-sm-3 p-0 pr-3">
                <p>Due Date : </p>
                <p style="font-weight:bold;">{{$invoice_due_date!=""? date('m-d-Y',strtotime($invoice_due_date)) : '____________________'}}</p>
            
            </div>
        </div>
        
        <div class="col-md-12 col-sm-12 p-0 mb-4">
            <div class="col-md-3 col-sm-3 p-0 pr-3">
                <p>Job Order :</p>
                <p style="font-weight:bold;text-decoration:underline;">{{$job_order!=""? $job_order : '____________________'}}</p>
            
            </div>
            <div class="col-md-3 col-sm-3 p-0 pr-3">
                <p>Work No :</p>
                <p style="font-weight:bold;text-decoration:underline;">{{$work_no!=""? $work_no : '____________________'}}</p>
            
            </div>
            <div class="col-md-6 col-sm-6 p-0 pr-3">
                
            </div>
            
        </div>
        <table id="invoice_table" class="table table-bordered  table-sm text-left font14 table-light" >
            <tr class="thead-light">
                <th class="text-center" width="5%">#</th>
                <th class="text-center" width="10%">PARTICULAR</th>
                <th class="text-center" width="20%">ITEM</th>
                <th class="text-center">DESCRIPTION</th>
                <th class="text-center" width="5%">QTY</th>
                <th class="text-center"  width="12%">RATE</th>
                <th class="text-center"  width="12%">AMOUNT</th>
            </tr>
            <?php
            $foreach_no=1;
            $totalbalance=0;
            ?>
            @foreach ($st_invoice as $item)
                <tr>
                    <td style="vertical-aign:middle;">{{$foreach_no}}</td>
                    <td style="vertical-aign:middle;">{{$item->st_i_product!=""? 'Products/Services' : 'Cost Center' }}</td>
                    <td style="vertical-aign:middle;">{{$item->st_i_product!=""? $item->product_name : $item->cc_name }}</td>
                    <td style="vertical-aign:middle;">{{$item->st_i_desc}}</td>
                    <td style="vertical-aign:middle;text-align:center;">{{$item->st_i_qty}}</td>
                    <td style="vertical-aign:middle;text-align:right;">{{number_format($item->st_i_rate,2)}}</td>
                    <td style="vertical-aign:middle;text-align:right;">{{number_format($item->st_i_total,2)}}</td>
                </tr>
            <?php
            $totalbalance+=$item->st_i_total;
            $foreach_no++;
            ?>
            @endforeach
            <!-- This is our clonable table line -->
        </table>
        <div class="col-md-12 col-sm-12 p-0">
            <div class="float-left">
                <style>
                input:read-only,select:read-only,textarea:read-only{
                    border: 0px solid #ccc;
                    background-color: white !important;
                }
                </style>
            </div>
            
        </div>
        <div class="col-md-10 col-sm-10 p-0">
        </div>
        <div class="col-md-2 col-sm-2 p-0">
            <table class="table table-borderless table-sm">
                <tr>
                    <td style="vertical-align:middle;text-align:right;"><p class="mb-0 pr-4 text-dark font-weight-bold">TOTAL</p></td>
                <td style="vertical-align:middle;text-align:right;"><p id="invoicetotal" class="mb-0 text-dark font-weight-bold">PHP {{number_format($totalbalance,2)}}</p></td>
                </tr>
                
            </table>
            
        </div>
        <div class="col-md-12 col-sm-12 p-0" style="display:none;">
            <div class="col-md-6 col-sm-6 pl-0">
                <p>Message Displayed on Invoice</p>
                <p style="font-weight:bold;text-decoration:underline;">{{$note!=""? $note : '____________________'}}</p>
            
            </div>
            <div class="col-md-6 col-sm-6 pr-0">
                <p>Message Displayed on Statement</p>
                <p style="font-weight:bold;text-decoration:underline;">{{$memo!=""? $memo : '____________________'}}</p>
                
            </div>
        </div>
        <div class="col-md-12 col-sm-12 p-0 mt-2">
            <table class="table table-light table-sm table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th colspan="3" style="vertical-align:middle;text-align:center;">Accounts</th>
                    </tr>
                    <tr>
                        <th style="vertical-align:middle;text-align:center;border-right: 1px solid #ccc;" width="5%">#</th>
                        <th style="vertical-align:middle;text-align:center;border-right: 1px solid #ccc;width: 45%;">Debit</th>
                        <th style="vertical-align:middle;text-align:center;">Credit</th>
                    </tr>
                </thead>
                <tbody id="InvoiceAccountTBody">
                    <?php
                    $foreach_no=1;
                    ?>
                    @foreach ($st_invoice as $item)
                        <tr>
                            <td style="vertical-aign:middle;">{{$foreach_no}}</td>
                            <td style="vertical-aign:middle;">
                                @foreach ($COA as $coa)
                                    
                                    @if ($coa->id==$item->st_p_debit)
                                        {{$coa->coa_name}}
                                    @endif        
                                @endforeach
                            </td>
                            <td style="vertical-aign:middle;">
                                @foreach ($COA as $coa)
                                    @if ($coa->id==$item->st_p_credit)
                                        {{$coa->coa_name}}
                                    @endif        
                                @endforeach
                            </td>
                        </tr>
                    <?php
                    $foreach_no++;
                    ?>
                    @endforeach
                    
                </tbody>
            </table>
        </div>  
        
    </div>
</div>

<script>
$(document).ready(function(){
    //window.print();
    setTimeout(function()
    {
        if(document.getElementById('page-wrapper-print_invoice')){
            html2canvas(document.querySelector("#page-wrapper-print_invoice"),{scale : 3}).then(function(canvas) {
            var canvasImg = canvas.toDataURL("image/jpg");
            //$('#test').html('<img src="'+canvasImg+'" alt="">');
            var myImage = canvas.toDataURL("image/png");
            var tmp = document.body.innerHTML;

            document.body.innerHTML = '<style type="text/css">@page { size : portrait}</style><table><tr><td style="vertical-align:middle;text-align:center;"><img style="width:90%" src="'+myImage+'" alt=""></td></tr></table>';
            setTimeout(function()
            {
                var printWindow = window.print();
                document.body.innerHTML = tmp;
                
            }, 2000);
            
            
            });
        }
    }, 2000);
    
    //window.close();
})
</script>
<style type="text/css" media="print">
    @page { size: portrait; }
  </style>
@endsection