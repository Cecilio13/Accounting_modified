<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" media="screen" href="">
  </head>
  <body style="padding:auto 0;">
    <div>
    
    </div> 
    <style>
        .screenfull-modal{
            padding:0px !important;
        }
        body{
            -webkit-print-color-adjust: exact;
        }
        @media print {
        body {-webkit-print-color-adjust: exact ;}
        }
        
</style>
            <div class="row" style="margin-right:0px;">
            <div class="col-md-3" style="padding-top:10px;">
                <a class="btn btn-default" id="gobackbutton" href="sales">Go Back</a>
                
            </div>
            <div class="col-md-6" id="printarea">
                <div id="formtemplatepage" style="font-family: Helvetica; padding: 0px; font-size: 8px;margin-top:10px;">
                    @if($Formstyle->cfs_design_template="1")
                    <div id="formdesigntemplate1" class="showndesigntemplate" style="background-color:white;overflow:auto;border:1px solid #ccc;border-bottom:3px solid #ccc;">
                            <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
                            <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
                            <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
                            <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
                            <link rel="stylesheet" href="{{asset('css/themify-icons.css')}}">
                            <link rel="stylesheet" href="{{asset('css/flag-icon.min.css')}}">
                            <link rel="stylesheet" href="{{asset('css/cs-skin-elastic.css')}}">
                            <script src="{{asset('js/html2canvas.js')}}"></script>
                            <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
                            <link rel="stylesheet" href="{{asset('css/style.css')}}">
                            <link rel="stylesheet" href="{{asset('css/styley.css')}}">
                            <link rel="stylesheet" href="{{asset('css/table.css')}}">
                            <link rel="stylesheet" href="{{asset('css/personal.css')}}">
                            <link rel="stylesheet" href="{{asset('css/donut.css')}}">
                            <link href="{{asset('open-iconic/font/css/open-iconic-bootstrap.css')}}" rel="stylesheet">
                            <link href="{{asset('css/lib/vector-map/jqvmap.min.css')}}" rel="stylesheet">
                    
                            <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
                            <link rel="stylesheet" href="{{asset('css/modal.css')}}">
                            <!-- Styles -->
                           
                           <!-- DataTables -->
                           <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
                        <div id="page-wrap" style="padding: 0.5in 0in">
                            <div id="header" style="padding-left:20px;margin-bottom:20px;">
                                <div id="headerSec" class="row" style="margin-bottom:10px;margin-left:0px;margin-right:0px;">
                                    <div class="col-md-12" style="padding-left:0px;">
                                    <div class="companyAdd1" id="comapnyinformationdiv2" style="display:inline-block;float:left;width:40%;">
                                        <div>
                                            <div id="rhs-companyName" style="font-family: Helvetica; font-size: 14px;">{{$Formstyle->cfs_company_name_value}}</div>
                                            <div>
                                                <div id="rhs-addrLine" style="font-family: Helvetica; font-size: 10px;">{{$settings_company->company_address}}</div>
                                                <div><span id="rhs-state-zip" style="font-family: Helvetica; font-size: 10px;"></span></div>
                                            </div>
                                            <div style="font-family: Helvetica; font-size: 10px;">
                                                <div id="rhs-phoneNumber" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_phone_value}}</div>
                                                <div id="rhs-email" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_email_value}}</div>
                                                <div id="rhs-crn" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_crn_value}}</div>
                                                <div id="rhs-website" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_website_value}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="templateLogo" id="logocontainer2" style="display: inline-block; float: right;">
                                            <div class="logo" style="float: right; display:none;" id="lllll">
                                                <img id="Templatelogo" src="{{asset('images/lowstock.png')}}" style="max-height: 100px;">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div id="formTitle" style="font-family: Helvetica;">
                                    <label id="formTitle-text" class="formTitleText uppercase" style=" text-transform: uppercase;color: rgb(79, 144, 187); font-family: Helvetica; font-size: 14px;font-weight:bold;">INVOICE</label>
                                </div>
                                <div class="prefContainer" style="font-size: 10px;">
                                    <div class="billToSection" style="width:35%;display:inline-block">
                                        <?php
                                        $Street="";
                                        $City="";
                                        $State="";
                                        $Postal="";

                                        ?>
                                        @foreach ($customers as $customer)
                                        @if($customer->customer_id==$sal->st_customer_id)
                                        <?php
                                        $Street=$customer->street;
                                        $City=$customer->city;
                                        $State=$customer->state;
                                        $Postal=$customer->postal_code;

                                        ?>
                                        @endif
                                        @endforeach
                                        <div>
                                            <div class="header" style="font-size: 10px;">
                                            <div class="sectionHeader upperCase" style="font-family: Helvetica; color: black; font-size: 10px;">BILL TO</div>
                                            </div>
                                            <div class="addlines" style="font-family: Helvetica; font-size: 10px;">
                                            <div>{{$Street}}</div>
                                            <div>{{$City}}</div>
                                            <span>{{$State}}</span>
                                            <span>{{$Postal}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                            $refno="";
                                            $depositto="";
                                            $paymentmethoid="";
                                            ?>
                                            
                                            @foreach ($salST as $st)
                                            @if($st->st_s_no==$receiptNo)
                                            <?php
                                            
                                            $refno=$st->st_p_reference_no;
                                            $depositto=$st->st_p_deposit_to;
                                            $paymentmethoid=$st->st_p_method;
                                            ?>  
                                            @endif
                                            @endforeach
                                    <div class="titleSection" style="float:right;width:35%;">
                                        <table class="inlineBlock" style="padding: 0px; border-collapse: collapse;float:right;margin-right:20px;">
                                            <tbody>
                                            <tr style="font-family: Helvetica;">
                                                <td class="titleText" id="INVOOICENUM" style="font-size: 10px;  text-align:right;padding-right:10px;">INVOICE#</td>
                                                <td class="titleValue" style="font-size: 10px;" ><span id="invoicenumberform">{{$receiptNo}}</span></td>
                                            </tr>
                                            <tr style="font-family: Helvetica;">
                                                <td class="titleText" style="font-size: 10px; text-align:right;padding-right:10px;">DATE</td>
                                                <td class="titleValue" style="font-size: 10px;">{{date('m-d-Y',strtotime($sal->st_date))}}</td>
                                            </tr>
                                            
                                            <tr style="font-family: Helvetica;">
                                                <td class="titleText" style="font-size: 10px; text-align:right;padding-right:10px;"><span id="duedatetitle">REF NO</span></td>
                                                <td class="titleValue" style="font-size: 10px;"><span id="duedatecontent">{{$refno}}</span></td>
                                            </tr>
                                            <tr style="font-family: Helvetica;">
                                                <td class="titleText" style="font-size: 10px;  text-align:right;padding-right:10px;"><span id="termtitle">PAYMENT METHOD</span></td>
                                                <td class="titleValue" style="font-size: 10px;"><span id="termcontent">{{$paymentmethoid}}</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="" id="shiptodiv" style="float:right;width:35%;">
                                            <table class="inlineBlock" style="padding: 0px; border-collapse: collapse;display:none;">
                                                <tbody>
                                                <tr style="font-family: Helvetica;">
                                                    <td class="titleText" style="font-size: 10px; ">SHIP TO</td>
                                                    
                                                </tr>
                                                <tr style="font-family: Helvetica;">
                                                    <td class="titleText" style="font-size: 10px; ">John Smith</td>
                                                   
                                                </tr>
                                                <tr style="font-family: Helvetica;">
                                                    <td class="titleText" style="font-size: 10px; ">209812 Palm Drive</td>
                                                    
                                                </tr>
                                                <tr style="font-family: Helvetica;">
                                                    <td class="titleText" style="font-size: 10px;">City, CA 12345</td>
                                                   
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                                <br>
                                <div class="shippingAndCustom" id="shipdefailtdiv" style="font-size: 12px;display:none;">
                                    <div>
                                        <style>
                                            .shippingFields{
                                                width:30%;
                                                display: inline-block ;
                                            }
                                        </style>
                                        <div class="shippingFields">
                                            <div class="fieldTitle upperCase" >SHIP DATE</div>
                                            <div class="fieldValue">01/03/2018</div>
                                        </div>
                                        <div class="shippingFields">
                                            <div class="fieldTitle upperCase" >SHIP VIA</div>
                                            <div class="fieldValue">FedEx</div>
                                        </div>
                                        <div class="shippingFields">
                                            <div class="fieldTitle upperCase" >TRACKING NO.</div>
                                            <div class="fieldValue">12345678</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="content" class="" >
                                <div id="overlayId" class=""></div>
                                <div class="detailSection" style="min-height:150px;">
                                    <div class="dgrid dgrid-03 dgrid-grid ui-widget">
                                        <div>
                                            <style>
                                                .table-sm td, .table-sm th{
                                                    padding:3px 10px!important;
                                                }
                                            </style>
                                                <table id="activityTableLhsTableHeader" style="width:100%;" class="dgrid-row-table table table-sm" role="presentation">
                                                    <thead >
                                                        <?php
                                                                $withhold=0;
                                                                ?>
                                                            @foreach ($customers as $cus)
                                                                @foreach ($sales_transaction as $ss)
                                                                @if($cus->customer_id==$ss->st_customer_id)
                                                                <?php
                                                                $withhold=$cus->withhold_tax;
                                                                ?>
                                                                @endif   
                                                                @endforeach
                                                                
                                                            @endforeach
                                                        <tr >
                                                            <th class="dgrid-cell hcoll-date" role="columnheader" rowspan="2" style="width: 10%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">#</th>
                                                            <th class="dgrid-cell hcoll-date" role="columnheader" rowspan="2" style="width: 10%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">DATE</th>
                                                            <th class="dgrid-cell hcoll-prod" role="columnheader" rowspan="2" style="width: 10%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">ACTIVITY</th>
                                                            <th class="dgrid-cell hcoll-desc" role="columnheader" rowspan="2" style="width: 10%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">DESCRIPTION</th>
                                                            <th class="dgrid-cell hcoll-qty" role="columnheader" rowspan="2" style="width: 10%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">QTY</th>
                                                            <th class="dgrid-cell hcoll-rate" role="columnheader" rowspan="2" style="width: 10%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">RATE</th>
                                                            <th class="dgrid-cell hcoll-amount" role="columnheader" rowspan="2" style="width: 10%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">AMOUNT</th>
                                                            <th class="dgrid-cell hcoll-amount" role="columnheader" rowspan="2" style="width: 10%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">LESS:VAT(12%)</th>
                                                            <th class="dgrid-cell hcoll-amount" role="columnheader" rowspan="2" style="width: 10%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">WITHHOLD TAX({{$withhold."%"}})</th>
                                                            <th class="dgrid-cell hcoll-amount" role="columnheader" rowspan="2" style="width: 10%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">NET AMOUNT</th>
                                                            <th class="dgrid-cell hcoll-sku" role="columnheader" rowspan="2" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">SKU</th>
                                                        </tr>
                                                        
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $st_total=0;
                                                        $nettotal=0;
                                                        $taxtotal=0;
                                                        $grosstotal=0;
                                                        $withholdtotal=0;
                                                        $PaymentFor="";
                                                        ?>
                                                        @foreach ($salST as $st)
                                                        @if($st->st_s_no==$receiptNo)
                                                        <tr>
                                                            <td class="dgrid-cell coll-date" role="columnheader" style=" text-align: left; font-family: Helvetica; font-size: 10px;">{{$st->invoice_no_link}}</td>
                                                            <td class="dgrid-cell coll-date" role="columnheader" style=" text-align: left; font-family: Helvetica; font-size: 10px;">{{date('m-d-Y',strtotime($st->updated_at))}}</td>
                                                            @foreach ($products_and_services as $prod)
                                                                @if($st->st_s_product==$prod->product_id)
                                                                <?php
                                                                $product_name=$prod->product_name;
                                                                ?>
                                                                @endif
                                                            @endforeach
                                                            <td class="dgrid-cell coll-prod" role="columnheader" style="text-align: left; font-family: Helvetica; font-size: 10px;">{{$product_name}}</td>
                                                            <td class="dgrid-cell coll-desc" role="columnheader" style="text-align: left; font-family: Helvetica; font-size: 10px;">{{$st->st_s_desc}}</td>
                                                            <td class="dgrid-cell coll-qty" role="columnheader" style="text-align: right; font-family: Helvetica; font-size: 10px;">{{$st->st_s_qty}}</td>
                                                            <td class="dgrid-cell coll-rate" role="columnheader" style="text-align: right; font-family: Helvetica; font-size: 10px;">{{number_format($st->st_s_rate,2)}}</td>
                                                            <td class="dgrid-cell coll-amount" role="columnheader" style="text-align: right; font-family: Helvetica; font-size: 10px;">{{number_format($st->st_s_total,2)}}</td>
                                                                <?php
                                                                if($PaymentFor==""){
                                                                    $PaymentFor.=$st->st_s_desc;
                                                                }else{
                                                                    $PaymentFor.=", ".$st->st_s_desc;
                                                                }
                                                                
                                                                $withhold=0;
                                                                ?>
                                                            @foreach ($customers as $cus)
                                                                @foreach ($sales_transaction as $ss)
                                                                @if($cus->customer_id==$ss->st_customer_id)
                                                                <?php
                                                                $withhold=$cus->withhold_tax;
                                                                ?>
                                                                @endif   
                                                                @endforeach
                                                                
                                                            @endforeach
                                                            <?php
                                                            $taxxxx=$st->st_s_total*0.12;  
                                                            $taxtotal+=$taxxxx;
                                                            ?>
                                                            
                                                            <td class="dgrid-cell coll-amount" role="columnheader" style="text-align: right; font-family: Helvetica; font-size: 10px;">{{number_format($taxxxx,2)}}</td>
                                                            <?php
                                                            $Gross=$st->st_s_total-$taxxxx;
                                                            $grosstotal+=$Gross;
                                                            $withoud=$st->st_s_total*($withhold/100);
                                                            $withholdtotal+=$withoud;
                                                            ?>
                                                            <td class="dgrid-cell coll-amount" role="columnheader" style=" text-align: right; font-family: Helvetica; font-size: 10px;">{{number_format($withoud,2)}}</td>
                                                            <td class="dgrid-cell coll-amount" role="columnheader" style=" text-align: right; font-family: Helvetica; font-size: 10px;">{{number_format($Gross-$withoud,2)}}</td>
                                                            <td class="dgrid-cell coll-sku" role="columnheader" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px;"></td>
                                                        </tr>
                                                        <?php
                                                                $st_total=$st_total+$st->st_s_total;
                                                                $nettotal=$nettotal+($Gross-$withoud);
                                                        ?>
                                                        @endif
                                                        @endforeach
                                                        
                                                    </tbody>
                                                </table>
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="totalValue" style="margin-top:10px;margin-bottom:10px;border-top:1px dotted #bdbbbb"></div>
                            <div id="footer" class="">
                                <div id="overlayId" class=""></div>
                                <div>
                                    <div class="subTotalSection">
                                        
                                        <div class="subTotalCenter"></div>
                                        <div class="subTotalRight" style="width:100%;">
                                            <style>
                                                #footerMessage{
                                                    display: inline-block !important;
                                                }
                                            </style>
                                            <div id="footerMessage" style="font-size: 8px; white-space: pre-line;margin-left:20px;"></div>
                                            
                                            <table style="width:30%;margin-right:20px;font-size:10px;float:right;">
                                                <tbody>
                                                    <tr>
                                                        <td id="SubTotalTitle" style="text-align:left;color: rgb(79, 144, 187);">SUBTOTAL</td>
                                                        <td style="text-align:right">PHP {{number_format($st_total,2)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td id="TotalTitle" style="text-align:left;color: rgb(79, 144, 187);">NET TOTAL</td>
                                                        <td style="text-align:right">PHP {{number_format($nettotal,2)}}</td>
                                                    </tr>
                                                    <tr >
                                                        <td style="padding: 3px;"></td>
                                                        <td style="padding: 3px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:left">BALANCE DUE</td>
                                                        <td style="text-align:right;font-size:12px">PHP0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                                <div style="clear: both;"></div>
                                <div style="padding-top: 0.5in;">
                                    <div id="footerText" class="left-footer-text" style="font-size: 8px; text-align: center; white-space: pre-line;margin-right:20px;margin-left:20px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($Formstyle->cfs_design_template="2")
                    <div id="formdesigntemplate2" class="hiddendesigntemplate" style="background-color:white;overflow:auto;border:1px solid #ccc;border-bottom:3px solid #ccc;">
                        <div id="page-wrap2" style="padding: 0.5in 0in">
                            <div id="header" style="padding-left:20px;margin-bottom:20px;">
                                <div id="headerSec" class="row" style="margin-bottom:10px;margin-left:0px;margin-right:0px;">
                                    <div class="col-md-12" style="padding-left:0px;">
                                    <div class="companyAdd1" id="comapnyinformationdiv" style="display:inline-block;float:left;width:40%;">
                                        <div>
                                            <div id="rhs-companyName2" style="font-family: Helvetica; font-size: 14px;">{{$Formstyle->cfs_company_name_value}}</div>
                                            <div>
                                                <div id="rhs-addrLine2" style="font-family: Helvetica; font-size: 10px;">{{$settings_company->company_address}}</div>
                                                <div><span id="rhs-state-zip" style="font-family: Helvetica; font-size: 10px;"></span></div>
                                            </div>
                                            <div style="font-family: Helvetica; font-size: 10px;">
                                                <div id="rhs-phoneNumber2" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_phone_value}}</div>
                                                <div id="rhs-email2" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_email_value}}</div>
                                                <div id="rhs-crn2" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_crn_value}}</div>
                                                <div id="rhs-website2" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_website_value}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="templateLogo" id="logocontainer" style="display: inline-block; float: right;">
                                            <div class="logo" style="float: right; display:none;" id="lllll2">
                                                <img id="Templatelogo2" src="{{asset('images/lowstock.png')}}" style="max-height: 100px;">
                                            </div>
                                    </div>
                                    <div id="formTitle2" style="font-family: Helvetica;float:right;">
                                            <label id="formTitle-text2" class="formTitleText uppercase" style=" text-transform: uppercase;color: rgb(79, 144, 187); font-family: Helvetica; font-size: 14px;font-weight:bold;">INVOICE</label>
                                    </div>
                                    </div>
                                    
                                </div>
                                <!--head section end-->
                                <div class="prefContainer" style="font-size: 10px;">
                                        <div class="">
                                            <div class="col-md-6">
                                            <div class="billToSection" style="width:70%;float:right;">
                                                <div style="border: 1px solid #ccc">
                                                    <div class="header" style="font-size: 10px;">
                                                    <div class="sectionHeader upperCase" id="billtocolored" style="padding:3px;color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);font-family: Helvetica; font-size: 10px;">BILL TO</div>
                                                    </div>
                                                    <div class="addlines" style="font-family: Helvetica; font-size: 10px;">
                                                    <div style="padding-left:3px;">Smith Co.</div>
                                                    <div style="padding-left:3px;">123 Main Street</div>
                                                    <span style="padding-left:3px;">City,&nbsp;</span>
                                                    <span style="padding-left:3px;">CA 12345</span>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-6" style="padding-left:0px;">
                                            <div class="" id="shiptodiv2" style="width:70%;">
                                                <table class="" style="width:100%;padding: 0px; border-collapse: collapse;border: 1px solid #ccc">
                                                    <tbody >
                                                    <tr style="color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);font-family: Helvetica;">
                                                        <td class="titleText" id="shiptocolored" style="font-size: 10px; padding:3px;">SHIP TO</td>
                                                        
                                                    </tr>
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" style="font-size: 10px;padding-left:3px; ">John Smith</td>
                                                       
                                                    </tr>
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" style="font-size: 10px; padding-left:3px;">209812 Palm Drive</td>
                                                        
                                                    </tr>
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" style="font-size: 10px;padding-left:3px;">City, CA 12345</td>
                                                       
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="col-md-12" style="margin-top:5px;padding-left:0px;padding-right:10px;">
                                                <div class="titleSection" style="margin-top:3px;">
                                                    <table class="inlineBlock" id="tableinvoicedatedueterm" style="border: 1px solid #ccc; border-collapse: collapse;width:100%;">
                                                        <tbody >
                                                        <tr id="tabletrinvoicenumber" style="color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);font-family: Helvetica;">
                                                            <td class="titleText" id="INVOOICENUM2" style="padding:3px;font-size: 10px;padding-right:10px;">INVOICE#</td>
                                                            <td class="titleText" style="font-size: 10px; padding:3px;">DATE</td>
                                                            <td class="titleText" style="font-size: 10px;padding:3px;"><span id="duedatetitle">DUE DATE</span></td>
                                                            <td class="titleText" style="font-size: 10px; padding:3px;"><span id="termtitle">TERMS</span></td>
                                                            
                                                        </tr>
                                                        <tr style="font-family: Helvetica;">
                                                            <td class="titleValue" style="font-size: 10px;padding:3px;" ><span id="invoicenumberform2">12345</span></td>
                                                            <td class="titleValue" style="font-size: 10px;padding:3px;">01/07/2018</td>
                                                            <td class="titleValue" style="font-size: 10px;padding:3px;"><span id="duedatecontent">02/06/2018</span></td>
                                                            <td class="titleValue" style="font-size: 10px;padding:3px;"><span id="termcontent">Net 30</span></td>
                                                        </tr>
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-top:10px;">
                                                <div class="shippingAndCustom" id="shipdefailtdiv2" style="font-size: 10px;margin-top:10px;">
                                                    <div>
                                                        
                                                        <div class="shippingFields">
                                                            <div class="fieldTitle upperCase" >SHIP DATE</div>
                                                            <div class="fieldValue">01/03/2018</div>
                                                        </div>
                                                        <div class="shippingFields">
                                                            <div class="fieldTitle upperCase" >SHIP VIA</div>
                                                            <div class="fieldValue">FedEx</div>
                                                        </div>
                                                        <div class="shippingFields">
                                                            <div class="fieldTitle upperCase" >TRACKING NO.</div>
                                                            <div class="fieldValue">12345678</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        

                                        
                                    </div>

                            </div>
                            <!--header end-->
                            
                            <div id="content" class="" >
                                    <div id="overlayId" class="col-md-12" style="margin-top:20px;">
                                    <div class="detailSection" style="min-height:150px;">
                                        <div class="dgrid dgrid-03 dgrid-grid ui-widget" styl="padding:10px 10px;">
                                            <div>
                                                <style>
                                                    .table-sm td, .table-sm th{
                                                        padding:3px 10px!important;
                                                    }
                                                </style>
                                                    <table id="activityTableLhsTableHeader" style="width:100%;border:1px solid #ccc ;" class="dgrid-row-table table table-sm" role="presentation">
                                                        <thead >
                                                            <tr >
                                                                <th class="dgrid-cell hcoll-date" role="columnheader" rowspan="2" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">DATE</th>
                                                                <th class="dgrid-cell hcoll-prod" role="columnheader" rowspan="2" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">ACTIVITY</th>
                                                                <th class="dgrid-cell hcoll-desc" role="columnheader" rowspan="2" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">DESCRIPTION</th>
                                                                <th class="dgrid-cell hcoll-qty" role="columnheader" rowspan="2" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">QTY</th>
                                                                <th class="dgrid-cell hcoll-rate" role="columnheader" rowspan="2" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">RATE</th>
                                                                <th class="dgrid-cell hcoll-amount" role="columnheader" rowspan="2" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">AMOUNT</th>
                                                                <th class="dgrid-cell hcoll-sku" role="columnheader" rowspan="2" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">SKU</th>
                                                            </tr>
                                                            
                                                        </thead>
                                                        <tbody>
                                                                <tr>
                                                                    <td class="dgrid-cell coll-date" role="columnheader" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px;">01/07/2018</td>
                                                                    <td class="dgrid-cell coll-prod" role="columnheader" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px;">Item name</td>
                                                                    <td class="dgrid-cell coll-desc" role="columnheader" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px;">Description of the item</td>
                                                                    <td class="dgrid-cell coll-qty" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">2</td>
                                                                    <td class="dgrid-cell coll-rate" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                    <td class="dgrid-cell coll-amount" role="columnheader" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px;">450.00</td>
                                                                    <td class="dgrid-cell coll-sku" role="columnheader" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px;">PRD123</td>
                                                                </tr>
                                                                <tr>
                                                                        <td class="dgrid-cell coll-date" role="columnheader" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px;">01/07/2018</td>
                                                                        <td class="dgrid-cell coll-prod" role="columnheader" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px;">Item name</td>
                                                                        <td class="dgrid-cell coll-desc" role="columnheader" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px;">Description of the item</td>
                                                                        <td class="dgrid-cell coll-qty" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">1</td>
                                                                        <td class="dgrid-cell coll-rate" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                        <td class="dgrid-cell  coll-amount" role="columnheader" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                        <td class="dgrid-cell coll-sku" role="columnheader" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px;">PRD123</td>
                                                                    </tr>
                                                        </tbody>
                                                    </table>
                                                
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <!-- content end-->
                                <div>
                                    <div class="col-md-12">
                                            <div id="totalValue" style="margin-top:10px;margin-bottom:10px;border-top:1px dotted #bdbbbb"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="col-md-12">
                                            <div id="footer" class="">
                                                    <div id="overlayId" class=""></div>
                                                        <div>
                                                        <div class="subTotalSection">
                                                            <div class="subTotalCenter"></div>
                                                                        <div class="subTotalRight" style="width:100%;">
                                                                            <style>
                                                                                #footerMessage2{
                                                                                    display: inline-block !important;
                                                                                }
                                                                            </style>
                                                                            <div id="footerMessage2" style="font-size: 8px; white-space: pre-line;margin-left:20px;"></div>
                                                                            
                                                                            <table style="width:30%;margin-right:20px;font-size:10px;float:right;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td id="SubTotalTitle2" style="text-align:left;color: rgb(79, 144, 187);">SUBTOTAL</td>
                                                                                        <td style="text-align:right">675.00</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td id="TotalTitle2" style="text-align:left;color: rgb(79, 144, 187);">TOTAL</td>
                                                                                        <td style="text-align:right">PHP675.00</td>
                                                                                    </tr>
                                                                                    <tr >
                                                                                        <td style="padding: 3px;"></td>
                                                                                        <td style="padding: 3px;"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="text-align:left">BALANCE DUE</td>
                                                                                        <td style="text-align:right;font-size:12px">PHP675.00</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    
                                                </div>
                                            <div style="clear: both;"></div>
                                            <div style="padding-top: 0.5in;">
                                                <div id="footerText2" class="left-footer-text" style="font-size: 8px; text-align: center; white-space: pre-line;margin-right:20px;margin-left:20px;margin-bottom:0.5in"></div>
                                            </div>
                                            </div>
                                    </div>
                                </div>
                                    
                        </div>
                    </div>
                    @elseif($Formstyle->cfs_design_template="3")
                    <div id="formdesigntemplate3" class="hiddendesigntemplate" style="background-color:white;overflow:auto;border:1px solid #ccc;border-bottom:3px solid #ccc;">
                        <div id="page-wrap3" style="padding: 0.5in 0in">
                            <div id="header" style="padding-left:20px;margin-bottom:20px;">
                                <div id="headerSec" class="row" style="margin-bottom:10px;margin-left:0px;margin-right:0px;">
                                    <div class="col-md-12" style="padding-left:0px;">
                                    <div class="companyAdd1" id="comapnyinformationdiv3" style="display:inline-block;float:left;width:40%;">
                                        <div>
                                            <div id="rhs-companyName3" style="font-family: Helvetica; font-size: 14px;">{{$Formstyle->cfs_company_name_value}}</div>
                                            <div>
                                                <div id="rhs-addrLine3" style="font-family: Helvetica; font-size: 10px;">{{$settings_company->company_address}}</div>
                                                <div><span id="rhs-state-zip" style="font-family: Helvetica; font-size: 10px;"></span></div>
                                            </div>
                                            <div style="font-family: Helvetica; font-size: 10px;">
                                                <div id="rhs-phoneNumber3" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_phone_value}}</div>
                                                <div id="rhs-email3" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_email_value}}</div>
                                                <div id="rhs-crn3" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_crn_value}}</div>
                                                <div id="rhs-website3" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_website_value}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="templateLogo" id="logocontainer3" style="display: inline-block; float: right;">
                                            <div class="logo" style="float: right; display:none;" id="lllll3">
                                                <img id="Templatelogo3" src="{{asset('images/lowstock.png')}}" style="max-height: 100px;">
                                            </div>
                                    </div>
                                    <div id="formTitle3" style="font-family: Helvetica;float:right;">
                                            <label id="formTitle-text3" class="formTitleText uppercase" style=" text-transform: uppercase;color: rgb(79, 144, 187); font-family: Helvetica; font-size: 14px;font-weight:bold;">INVOICE</label>
                                    </div>
                                    </div>
                                    
                                </div>
                                <!--head section end-->
                                <div class="prefContainer" style="font-size: 10px;">
                                        <div class="" >
                                            <div class="col-md-3"  style="padding-right:0px;padding-left:0px;">
                                            <div class="billToSection" id="borderline1" style="width:100%;border-top:1px solid rgb(79, 144, 187);">
                                                <div >
                                                    <div class="header" style="font-size: 10px;">
                                                    <div class="sectionHeader upperCase" id="billtocolored" style="padding-left:3px;font-family: Helvetica; font-size: 10px;">BILL TO</div>
                                                    </div>
                                                    <div class="addlines" style="font-family: Helvetica; font-size: 10px;">
                                                    <div style="padding-left:3px;">Smith Co.</div>
                                                    <div style="padding-left:3px;">123 Main Street</div>
                                                    <span style="padding-left:3px;">City,&nbsp;</span>
                                                    <span style="padding-left:3px;">CA 12345</span>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-3"  style="padding-left:0px;padding-right:0px;">
                                            <div class="" id="shiptodiv3" style="width:100%;border-top:1px solid rgb(79, 144, 187);">
                                                <table class="" style="width:100%;padding: 0px; border-collapse: collapse;" id="shiptotable">
                                                    <tbody >
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" id="shiptocolored" style="font-size: 10px; padding:3px;">SHIP TO</td>
                                                        
                                                    </tr>
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" style="font-size: 10px;padding-left:3px; ">John Smith</td>
                                                       
                                                    </tr>
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" style="font-size: 10px; padding-left:3px;">209812 Palm Drive</td>
                                                        
                                                    </tr>
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" style="font-size: 10px;padding-left:3px;">City, CA 12345</td>
                                                       
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            </div>
                                            <div class="col-md-6"  style="padding-left:0px;padding-right:10px;">
                                                <div class="titleSection" id="borderline3" style="width:100%;border-top:1px solid rgb(79, 144, 187);" >
                                                    <table class="inlineBlock" id="tableinvoicedatedueterm2" style="text-align:center;min-height:75px; border-collapse: collapse;width:100%;">
                                                        <tbody >
                                                        <tr id="tabletrinvoicenumber" >
                                                            <td class="titleText" id="datetitle3" style="vertical-align:bottom;color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);padding:3px;font-size: 10px;padding-right:10px;">DATE</td>
                                                            
                                                            <td class="titleText" id="duedatetitle3" style="vertical-align:bottom;font-size: 10px;padding:3px;color: rgb(220, 233, 241); background-color: rgb(79, 144, 187);"><span id="duedatetitle">DUE DATE</span></td>
                                                            <td class="titleText" id="termtitle3" style="vertical-align:bottom;color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);font-size: 10px; padding:3px;"><span id="termtitle">TERMS</span></td>
                                                            
                                                        </tr>
                                                        <tr style="font-family: Helvetica;">
                                                            <td class="titleValue" id="datetitle3-2" style="vertical-align:top;color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);font-size: 10px;padding:3px;" ><span id="invoicenumberform2">02/06/2018</span></td>
                                                            
                                                            <td class="titleValue" id="duedatetitle3-2" style="vertical-align:top;font-size: 10px;padding:3px;color: rgb(220, 233, 241); background-color: rgb(79, 144, 187);"><span id="duedatecontent">02/06/2018</span></td>
                                                            <td class="titleValue" id="termtitle3-2" style="vertical-align:top;color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);font-size: 10px;padding:3px;"><span id="termcontent">Net 30</span></td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="col-md-12" style="margin-top:5px;padding-left:0px;padding-right:10px;">
                                                
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-top:10px;">
                                                <div class="shippingAndCustom" id="shipdefailtdiv3" style="font-size: 10px;display:none;">
                                                    <div>
                                                        
                                                        <div class="shippingFields">
                                                            <div class="fieldTitle upperCase" >SHIP DATE</div>
                                                            <div class="fieldValue">01/03/2018</div>
                                                        </div>
                                                        <div class="shippingFields">
                                                            <div class="fieldTitle upperCase" >SHIP VIA</div>
                                                            <div class="fieldValue">FedEx</div>
                                                        </div>
                                                        <div class="shippingFields">
                                                            <div class="fieldTitle upperCase" >TRACKING NO.</div>
                                                            <div class="fieldValue">12345678</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        

                                        
                                    </div>

                            </div>
                            <!--heaeder end-->
                            <div id="content" class="" >
                                    <div id="overlayId" class="col-md-12" style="margin-top:20px;">
                                    <div class="detailSection" style="min-height:150px;">
                                        <div class="dgrid dgrid-03 dgrid-grid ui-widget" styl="padding:10px 10px;">
                                            <div>
                                                <style>
                                                    .table-sm td, .table-sm th{
                                                        padding:3px 10px!important;
                                                    }
                                                </style>
                                                    <table id="activityTableLhsTableHeader" style="width:100%;border:1px solid #ccc ;" class="dgrid-row-table table table-sm" role="presentation">
                                                        <thead >
                                                            <tr >
                                                                <th class="dgrid-cell hcoll-date" role="columnheader" rowspan="2" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">DATE</th>
                                                                <th class="dgrid-cell hcoll-prod" role="columnheader" rowspan="2" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">ACTIVITY</th>
                                                                <th class="dgrid-cell hcoll-desc" role="columnheader" rowspan="2" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">DESCRIPTION</th>
                                                                <th class="dgrid-cell hcoll-qty" role="columnheader" rowspan="2" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">QTY</th>
                                                                <th class="dgrid-cell hcoll-rate" role="columnheader" rowspan="2" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">RATE</th>
                                                                <th class="dgrid-cell hcoll-amount" role="columnheader" rowspan="2" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">AMOUNT</th>
                                                                <th class="dgrid-cell hcoll-sku" role="columnheader" rowspan="2" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">SKU</th>
                                                            </tr>
                                                            
                                                        </thead>
                                                        <tbody>
                                                                <tr>
                                                                    <td class="dgrid-cell coll-date" role="columnheader" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px;">01/07/2018</td>
                                                                    <td class="dgrid-cell coll-prod" role="columnheader" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px;">Item name</td>
                                                                    <td class="dgrid-cell coll-desc" role="columnheader" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px;">Description of the item</td>
                                                                    <td class="dgrid-cell coll-qty" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">2</td>
                                                                    <td class="dgrid-cell coll-rate" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                    <td class="dgrid-cell coll-amount" role="columnheader" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px;">450.00</td>
                                                                    <td class="dgrid-cell coll-sku" role="columnheader" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px;">PRD123</td>
                                                                </tr>
                                                                <tr>
                                                                        <td class="dgrid-cell coll-date" role="columnheader" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px;">01/07/2018</td>
                                                                        <td class="dgrid-cell coll-prod" role="columnheader" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px;">Item name</td>
                                                                        <td class="dgrid-cell coll-desc" role="columnheader" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px;">Description of the item</td>
                                                                        <td class="dgrid-cell coll-qty" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">1</td>
                                                                        <td class="dgrid-cell coll-rate" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                        <td class="dgrid-cell  coll-amount" role="columnheader" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                        <td class="dgrid-cell coll-sku" role="columnheader" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px;">PRD123</td>
                                                                    </tr>
                                                        </tbody>
                                                    </table>
                                                
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <!--content end-->
                                <div>
                                        <div class="col-md-12">
                                                <div id="totalValue" style="margin-top:10px;margin-bottom:10px;border-top:1px dotted #bdbbbb"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="col-md-12">
                                                <div id="footer" class="">
                                                        <div id="overlayId" class=""></div>
                                                            <div>
                                                            <div class="subTotalSection">
                                                                <div class="subTotalCenter"></div>
                                                                            <div class="subTotalRight" style="width:100%;">
                                                                                <style>
                                                                                    #footerMessage3{
                                                                                        display: inline-block !important;
                                                                                    }
                                                                                </style>
                                                                                <div id="footerMessage3" style="font-size: 8px; white-space: pre-line;margin-left:20px;"></div>
                                                                                
                                                                                <table style="width:30%;margin-right:20px;font-size:10px;float:right;">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td id="SubTotalTitle3" style="text-align:left;color: rgb(79, 144, 187);">SUBTOTAL</td>
                                                                                            <td style="text-align:right">675.00</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td id="TotalTitle3" style="text-align:left;color: rgb(79, 144, 187);">TOTAL</td>
                                                                                            <td style="text-align:right">PHP675.00</td>
                                                                                        </tr>
                                                                                        <tr >
                                                                                            <td style="padding: 3px;"></td>
                                                                                            <td style="padding: 3px;"></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="text-align:left">BALANCE DUE</td>
                                                                                            <td style="text-align:right;font-size:12px">PHP675.00</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        
                                                    </div>
                                                <div style="clear: both;"></div>
                                                <div style="padding-top: 0.5in;">
                                                    <div id="footerText3" class="left-footer-text" style="font-size: 8px; text-align: center; white-space: pre-line;margin-right:20px;margin-left:20px;margin-bottom:0.5in"></div>
                                                </div>
                                                </div>
                                        </div>
                                    </div>  
                        </div>
                    </div>
                @endif
                </div>
                
            </div>
            <div class="col-md-3" style="padding-top:10px;text-align:right;">
                    <a class="btn btn-primary" style="color:white;" id="printbutton" onclick="printDiv('page-wrap')">Print</a>
            <div id="test"></div>
            </div>
            </div>
            <div class="row" style="margin-right:0px;">
            <div class="col-md-2">
                
            </div>
            <div class="col-md-8">
                    <div style="font-family: Helvetica; padding: 0px; font-size: 8px;margin-top:10px;margin-bottom:10px;">
                    <div id="ORTemplaate" style="background-color:white;overflow:auto;border:1px solid #ccc;border-bottom:3px solid #ccc;padding-top:15px;padding-bottom:15px;">
                    <div class="col-md-3">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th colspan="2" style="text-align:center;">In settlement of the following:</th>
                                </tr>
                                <tr>
                                    <th width="40%">Invoice No.</th>
                                    <th width="60%" >Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Total Sales(VAT Inclusive)</td>
                                    <td>{{number_format($st_total,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Less:VAT(12%)</td>
                                    <td>{{number_format($taxtotal,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>{{number_format($st_total-$taxtotal,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Less:SCPWD Discount</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Total Due</td>
                                    <td>{{number_format($grosstotal,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Less:Withholding Tax({{$withhold."%"}})</td>
                                    <td>{{number_format($withholdtotal,2)}}</td>
                                </tr>
                                <tr>
                                    <td>Amount Due</td>
                                    <td>{{number_format($nettotal,2)}}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                
                                <tr>
                                    <td>Vatable Sales</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>VAT Exempt Sales</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Zero Rated Sales</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>VAT AMOUNT</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Total Sales</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th >Form of Payment</th>
                                    <td><span>Cash [   ]</span> <span >Check [   ]</span></td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-8" style="text-align:center;">
                                <img id="ORLogo" src="" style="max-height: 100px;display:none;">
                            </div>
                            <div class="col-md-4" style="text-align:center;font-size:20px;">

                                <table class="table table-borderless" style="max-height:100px;height:100px;">
                                    <tr>
                                        <th style="vertical-align:bottom;border-top:0px solid #ccc;">No.</th>
                                        <th style="vertical-align:bottom;border-top:0px solid #ccc;">{{$receiptNo}}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="vertical-align:middle;font-weight:bold;border-top:0px solid #ccc;"><h5>OFFICIAL RECEIPT</h5></th>
                                        <th style="vertical-align:middle;text-align:right;border-top:0px solid #ccc;"><h6>DATE:<u>{{date('m-d-Y',strtotime($sal->st_date))}}</u></h6></th>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="vertical-align:middle;border-top:0px solid #ccc;padding:0px;">
                                                <?php
                                                $Street="";
                                                $City="";
                                                $State="";
                                                $Postal="";
                                                $name="";
                                                $TinNo="";
                                                $business_style="";
                                                $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                                ?>
                                                @foreach ($customers as $customer)
                                                @if($customer->customer_id==$sal->st_customer_id)
                                                <?php
                                                $Street=$customer->street;
                                                $City=$customer->city;
                                                $State=$customer->state;
                                                $Postal=$customer->postal_code;
                                                $name=$customer->f_name." ".$customer->l_name;
                                                $TinNo=$customer->tin_no;
                                                $tin=$customer->tin_no;
                                                $business_style=$customer->business_style;
                                                $lengthtin=strlen($tin);
                                                if($lengthtin<9){
                                                    for($c=$lengthtin;$c<=9;$c++){
                                                        $tin.="x";  
                                                    }
                                                }
                                                $output = str_split($tin, 3);

                                                ?>
                                                @endif
                                                @endforeach
                                            <p style="text-indent: 50px;text-align: justify;">Received from <b><u>{{$name}}</u></b> with TIN <b><u>{{$output[0].'-'.$output[1].'-'.$output[2]}}</u></b> 
                                                and address at <b><u>{{$Street." ".$City." ".$State." ".$Postal}}</u></b> engaged in the business style of <b><u>{{$business_style}}</b></u>, 
                                                the sum of <b><u>{{ucwords($f->format($st_total))}}</u></b> pesos (P <b><u>{{number_format($st_total,2)}}</u></b>)
                                                 In partial/full payment for <b><u>{{$PaymentFor}}</b></u></p>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td colspan="2" style="vertical-align:top;border-top:0px solid #ccc;padding:0px;">
                                        <div class="col-md-6" style="padding-left:0px;">
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <th  style="vertical-align:top;padding:.50em" colspan="2">Sr. Citizen TIN<br><br></th>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align:top;padding:.50em" width="50%" colspan="1">OSCA/PWD ID No.<br><br></th>
                                                    <th style="vertical-align:top;padding:.50em" width="50%" colspan="1">Signiture<br><br></th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                           <table class="table table-borderless table-sm">
                                               <tr> 
                                                   <td style="vertical-align:middle;border-top:0px solid #ccc;text-align:center;"> </td>
                                               </tr>
                                               <tr> 
                                                   <td style="vertical-align:middle;border-top:0px solid #ccc;text-align:center;"> </td>
                                               </tr>
                                               <tr> 
                                                   <td style="vertical-align:middle;border-top:0px solid #ccc;text-align:center;"> </td>
                                               </tr>
                                               <tr> 
                                                   <td style="vertical-align:middle;border-top:0px solid #ccc;text-align:center;"> </td>
                                               </tr>
                                               <tr>
                                                   
                                                   <td style="vertical-align:middle;border-top:0px solid #ccc;text-align:center;">_____________________________________</td>
                                               </tr>
                                               <tr>
                                                    
                                                    <td style="vertical-align:middle;border-top:0px solid #ccc;text-align:center;">Cashier/Authorized Representative</td>
                                                </tr>
                                           </table>
                                        </div>
                                       </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                
            </div>
            </div>
            <script>
                function printDiv(divName) {
                    document.getElementById('printbutton').style.display="none";
                    document.getElementById('gobackbutton').style.display="none";
                    if(document.getElementById('page-wrap')){
                        html2canvas(document.querySelector("#page-wrap")).then(function(canvas) {
                        var canvasImg = canvas.toDataURL("image/jpg");
                        //$('#test').html('<img src="'+canvasImg+'" alt="">');
                        var myImage = canvas.toDataURL("image/png");
                        var tmp = document.body.innerHTML;

                        document.body.innerHTML = '<img style="margin-left:30px;" src="'+myImage+'" alt="">';
                        setTimeout(function()
                        {
                            var printWindow = window.print();
                            document.body.innerHTML = tmp;
                            if(document.getElementById('ORTemplaate')){
                                html2canvas(document.querySelector("#ORTemplaate")).then(function(canvas) {
                                var canvasImg = canvas.toDataURL("image/jpg");
                                //$('#test').html('<img src="'+canvasImg+'" alt="">');
                                var myImage = canvas.toDataURL("image/png");
                                var tmp = document.body.innerHTML;

                                document.body.innerHTML = '<img  src="'+myImage+'" alt="">';
                                setTimeout(function()
                                {
                                    var printWindow = window.print();
                                    document.body.innerHTML = tmp;
                                }, 2000);
                                
                                
                                });
                                
                            }
                        }, 2000);
                        
                        
                        });
                    }
                    if(document.getElementById('page-wrap2')){
                        html2canvas(document.querySelector("#page-wrap2")).then(function(canvas) {
                        var canvasImg = canvas.toDataURL("image/jpg");
                        //$('#test').html('<img src="'+canvasImg+'" alt="">');
                        var myImage = canvas.toDataURL("image/png");
                        var tmp = document.body.innerHTML;

                        document.body.innerHTML = '<img style="margin-left:30px;" src="'+myImage+'" alt="">';
                        setTimeout(function()
                        {
                            var printWindow = window.print();
                            document.body.innerHTML = tmp;
                            if(document.getElementById('ORTemplaate')){
                                html2canvas(document.querySelector("#ORTemplaate")).then(function(canvas) {
                                var canvasImg = canvas.toDataURL("image/jpg");
                                //$('#test').html('<img src="'+canvasImg+'" alt="">');
                                var myImage = canvas.toDataURL("image/png");
                                var tmp = document.body.innerHTML;

                                document.body.innerHTML = '<img  src="'+myImage+'" alt="">';
                                setTimeout(function()
                                {
                                    var printWindow = window.print();
                                    document.body.innerHTML = tmp;
                                }, 2000);
                                
                                
                                });
                                
                            }
                        }, 2000);
                        
                        
                        });
                    }
                    if(document.getElementById('page-wrap3')){
                        html2canvas(document.querySelector("#page-wrap3")).then(function(canvas) {
                        var canvasImg = canvas.toDataURL("image/jpg");
                        //$('#test').html('<img src="'+canvasImg+'" alt="">');
                        var myImage = canvas.toDataURL("image/png");
                        var tmp = document.body.innerHTML;

                        document.body.innerHTML = '<img src="'+myImage+'" alt="">';
                        setTimeout(function()
                        {
                            var printWindow = window.print();
                            document.body.innerHTML = tmp;
                            if(document.getElementById('ORTemplaate')){
                                html2canvas(document.querySelector("#ORTemplaate")).then(function(canvas) {
                                var canvasImg = canvas.toDataURL("image/jpg");
                                //$('#test').html('<img src="'+canvasImg+'" alt="">');
                                var myImage = canvas.toDataURL("image/png");
                                var tmp = document.body.innerHTML;

                                document.body.innerHTML = '<img style="margin-left:15px;" src="'+myImage+'" alt="">';
                                setTimeout(function()
                                {
                                    var printWindow = window.print();
                                    document.body.innerHTML = tmp;
                                }, 2000);
                                
                                
                                });
                                
                            }
                        }, 2000);
                        
                        
                        });
                    }
                    
                    
                    
                // var printContents = document.getElementById(divName).innerHTML;
                // var originalContents = document.body.innerHTML;
                 
                // document.body.innerHTML = printContents;
                
                document.getElementById('printbutton').style.display="none";
                document.getElementById('gobackbutton').style.display="none";
                //window.print();
                document.getElementById('printbutton').style.display="inline";
                document.getElementById('gobackbutton').style.display="inline";
                //document.body.innerHTML = originalContents;
                }
                var imageheight="100";
                $(document).ready(function(){
                var filename="{{$Formstyle->cfs_logo_name}}";
                if(filename!=""){
                document.getElementById('ORLogo').style.display="inline";
                $("#ORLogo").attr("src","images/logos/"+filename);
                $("#Templatelogo").attr("src","images/logos/"+filename);
                $("#Templatelogo2").attr("src","images/logos/"+filename);
                $("#Templatelogo3").attr("src","images/logos/"+filename);
                $("#addlogoinput").attr("src","images/logos/"+filename);
                //document.getElementById("customFile").value = "";
                //document.getElementById('logadjustmenttable').style.display="inline";
                if(document.getElementById('formTitle2')){
                    document.getElementById('formTitle2').style.cssFloat="left";
                }
                if(document.getElementById('formTitle3')){
                    document.getElementById('formTitle3').style.cssFloat="left";
                }
                if(document.getElementById('lllll')){
                    document.getElementById('lllll').style.display="inline";
                }
                if(document.getElementById('lllll2')){
                    document.getElementById('lllll2').style.display="inline";
                }
                if(document.getElementById('lllll3')){
                    document.getElementById('lllll3').style.display="inline";
                }
                imageheight="100";
                //logoname=filename;
                }
                                                
                                                
                })
                var logo_size="{{$Formstyle->cfs_logo_size}}";
                $(document).ready(function(){
                var siz="{{$Formstyle->cfs_logo_size}}";
                console.log(siz+" px logo size");
                if(document.getElementById('Templatelogo')){
                    document.getElementById('Templatelogo').style.height=imageheight*siz+"px";
                }
                if(document.getElementById('Templatelogo2')){
                    document.getElementById('Templatelogo2').style.height=imageheight*siz+"px";
                }
                if(document.getElementById('Templatelogo3')){
                    document.getElementById('Templatelogo3').style.height=imageheight*siz+"px";
                }
                })
                var logo_align="{{$Formstyle->cfs_logo_alignment}}";
                $(document).ready(function(){
                if("{{$Formstyle->cfs_logo_alignment}}"=="right"){
                goRight();
                }
                else if("{{$Formstyle->cfs_logo_alignment}}"=="center"){
                gocenter();
                }
                else if("{{$Formstyle->cfs_logo_alignment}}"=="left"){
                goLeft();
                }
                }) 
                function goRight(){
                logo_align="right";
                if(document.getElementById('logocontainer')){
                    document.getElementById('logocontainer').style.cssFloat="right";
                }
                if(document.getElementById('logocontainer2')){
                    document.getElementById('logocontainer2').style.cssFloat="right";
                }
                if(document.getElementById('logocontainer3')){
                    document.getElementById('logocontainer3').style.cssFloat="right";
                }
                if(document.getElementById('comapnyinformationdiv')){
                    document.getElementById('comapnyinformationdiv').style.cssFloat="left";
                }
                if(document.getElementById('comapnyinformationdiv2')){
                    document.getElementById('comapnyinformationdiv2').style.cssFloat="left";
                }
                if(document.getElementById('comapnyinformationdiv3')){
                    document.getElementById('comapnyinformationdiv3').style.cssFloat="left";
                }
                if(document.getElementById('formTitle2')){
                    document.getElementById('formTitle2').style.cssFloat="left";
                }
                if(document.getElementById('formTitle3')){
                    document.getElementById('formTitle3').style.cssFloat="left";
                }
                }
                function gocenter(){
                logo_align="center";
                if(document.getElementById('logocontainer')){
                    document.getElementById('logocontainer').style.cssFloat="left";
                }
                if(document.getElementById('logocontainer2')){
                    document.getElementById('logocontainer2').style.cssFloat="left";
                }
                if(document.getElementById('logocontainer3')){
                    document.getElementById('logocontainer3').style.cssFloat="left";
                }
                if(document.getElementById('comapnyinformationdiv')){
                    document.getElementById('comapnyinformationdiv').style.cssFloat="left";
                }
                if(document.getElementById('comapnyinformationdiv2')){
                    document.getElementById('comapnyinformationdiv2').style.cssFloat="left";
                }
                if(document.getElementById('comapnyinformationdiv3')){
                    document.getElementById('comapnyinformationdiv3').style.cssFloat="left";
                }
                if(document.getElementById('formTitle2')){
                    document.getElementById('formTitle2').style.cssFloat="right";
                }
                if(document.getElementById('formTitle3')){
                    document.getElementById('formTitle3').style.cssFloat="right";
                }

                }
                function goLeft(){
                logo_align="left";
                if(document.getElementById('logocontainer')){
                    document.getElementById('logocontainer').style.cssFloat="left";
                }
                if(document.getElementById('logocontainer2')){
                    document.getElementById('logocontainer2').style.cssFloat="left";
                }
                if(document.getElementById('logocontainer3')){
                    document.getElementById('logocontainer3').style.cssFloat="left";
                }
                if(document.getElementById('comapnyinformationdiv')){
                    document.getElementById('comapnyinformationdiv').style.cssFloat="none";
                }
                if(document.getElementById('comapnyinformationdiv2')){
                    document.getElementById('comapnyinformationdiv2').style.cssFloat="none";
                }
                if(document.getElementById('comapnyinformationdiv3')){
                    document.getElementById('comapnyinformationdiv3').style.cssFloat="none";
                }
                if(document.getElementById('formTitle2')){
                    document.getElementById('formTitle2').style.cssFloat="right";
                }
                if(document.getElementById('formTitle3')){
                    document.getElementById('formTitle3').style.cssFloat="right";
                }
                }
                       setFormType('SALES RECEIPT');     
                            function setFormType(type){
                            var d = new Date();
                            var month= d.getMonth() + 1;
                            var day=   d.getDate();
                            if(type=="INVOICE"){
                                //document.getElementById('ModalHeader').innerHTML="Create Invoice Form";
                                //document.getElementById('TemplateTitleInput').value="My INVOICE Template - "+month+"-"+day;
                                
                                formtitletemp="INVOICE";
                               // document.getElementById('Formnameinput').value="INVOICE";
                                
                                if(document.getElementById('INVOOICENUM')){
                                    document.getElementById('INVOOICENUM').innerHTML="INVOICE#";
                                }
                                if(document.getElementById('INVOOICENUM2')){
                                    document.getElementById('INVOOICENUM2').innerHTML="INVOICE#";
                                }
                                if(document.getElementById('formTitle-text')){
                                    document.getElementById('formTitle-text').innerHTML="INVOICE";
                                }
                                if(document.getElementById('formTitle-text2')){
                                    document.getElementById('formTitle-text2').innerHTML="INVOICE";
                                }
                                if(document.getElementById('formTitle-text3')){
                                    document.getElementById('formTitle-text3').innerHTML="INVOICE";
                                }
                                if(document.getElementById('messagekind')){
                                    document.getElementById('messagekind').value="Invoice";
                                }
                                if(document.getElementById('emailSubject')){
                                    document.getElementById('emailSubject').value="Invoice [Sales Receipt No.] from [Company Name]";
                                }
                            }
                            else if(type=="ESTIMATE"){
                                //document.getElementById('ModalHeader').innerHTML="Create Estimate Form";
                                //document.getElementById('TemplateTitleInput').value="My ESTIMATE Template - "+month+"-"+day;
                                
                                formtitletemp="ESTIMATE";
                                //document.getElementById('Formnameinput').value="ESTIMATE";
                                if(document.getElementById('INVOOICENUM')){
                                    document.getElementById('INVOOICENUM').innerHTML="ESTIMATE#";
                                }
                                if(document.getElementById('INVOOICENUM2')){
                                    document.getElementById('INVOOICENUM2').innerHTML="ESTIMATE#";
                                }
                                if(document.getElementById('formTitle-text')){
                                    document.getElementById('formTitle-text').innerHTML="ESTIMATE";
                                }
                                if(document.getElementById('formTitle-text2')){
                                    document.getElementById('formTitle-text2').innerHTML="ESTIMATE";
                                }
                                if(document.getElementById('formTitle-text3')){
                                    document.getElementById('formTitle-text3').innerHTML="ESTIMATE";
                                }
                                if(document.getElementById('messagekind')){
                                    document.getElementById('messagekind').value="Estimate";
                                }
                                if(document.getElementById('emailSubject')){
                                    document.getElementById('emailSubject').value="Estimate [Sales Receipt No.] from [Company Name]";
                                }
                            }
                            else if(type=="SALES RECEIPT"){
                                //document.getElementById('ModalHeader').innerHTML="Create Sales Receipt Form";
                                //document.getElementById('TemplateTitleInput').value="My SALES RECEIPT Template - "+month+"-"+day;
                                
                                formtitletemp="SALES RECEIPT";
                                //document.getElementById('Formnameinput').value="SALES RECEIPT";
                                if(document.getElementById('INVOOICENUM')){
                                    document.getElementById('INVOOICENUM').innerHTML="SALES RECEIPT#";
                                }
                                if(document.getElementById('INVOOICENUM2')){
                                    document.getElementById('INVOOICENUM2').innerHTML="SALES RECEIPT#";
                                }
                                if(document.getElementById('formTitle-text')){
                                    document.getElementById('formTitle-text').innerHTML="SALES RECEIPT";
                                }
                                if(document.getElementById('formTitle-text2')){
                                    document.getElementById('formTitle-text2').innerHTML="SALES RECEIPT";
                                }
                                if(document.getElementById('formTitle-text3')){
                                    document.getElementById('formTitle-text3').innerHTML="SALES RECEIPT";
                                }
                                if(document.getElementById('messagekind')){
                                    document.getElementById('messagekind').value="Sales Receipt";
                                }
                                if(document.getElementById('emailSubject')){
                                    document.getElementById('emailSubject').value="Sales Receipt [Sales Receipt No.] from [Company Name]";
                                }
                                
                                
                                
                               
                               
                                
                               
                            }
                        }
                    var e="{{$Formstyle->cfs_theme_color}}";
                    if(document.getElementById('formTitle-text')){
                        document.getElementById('formTitle-text').style.color=e;
                    
                    }
                    if(document.getElementById('formTitle-text2')){
                        document.getElementById('formTitle-text2').style.color=e;
                    
                    }
                    if(document.getElementById('formTitle-text3')){
                        document.getElementById('formTitle-text3').style.color=e;
                    }
                    if(document.getElementById('SubTotalTitle')){
                        document.getElementById('SubTotalTitle').style.color=e;
                    
                    }
                    if(document.getElementById('SubTotalTitle2')){
                        document.getElementById('SubTotalTitle2').style.color=e;
                    
                    }
                    if(document.getElementById('SubTotalTitle3')){
                        document.getElementById('SubTotalTitle3').style.color=e;
                    }
                    if(document.getElementById('TotalTitle')){
                        
                        document.getElementById('TotalTitle').style.color=e;
                    
                    }
                    if(document.getElementById('TotalTitle2')){
                        document.getElementById('TotalTitle2').style.color=e;
                    }
                    if(document.getElementById('TotalTitle3')){
                        document.getElementById('TotalTitle3').style.color=e;
                    }
                    if(document.getElementById('billtocolored')){
                        document.getElementById('billtocolored').style.color=e;
                        document.getElementById('billtocolored').style.backgroundColor=shade(e, 0.5);
                    }
                    if(document.getElementById('shiptocolored')){
                        document.getElementById('shiptocolored').style.backgroundColor=shade(e, 0.5);
                        document.getElementById('shiptocolored').style.color=e;
                    }
                    if(document.getElementById('tabletrinvoicenumber')){
                        document.getElementById('tabletrinvoicenumber').style.backgroundColor=shade(e, 0.5);
                    
                        document.getElementById('tabletrinvoicenumber').style.color=e;
                    }
                    if(document.getElementById('borderline1')){
                        document.getElementById('borderline1').style.borderTop="1px solid "+e;
                    }
                    if(document.getElementById('borderline3')){
                        document.getElementById('borderline3').style.borderTop="1px solid "+e;
                    }
                    if(document.getElementById('shiptodiv3')){
                        document.getElementById('shiptodiv3').style.borderTop="1px solid "+e;
                    }
                    if(document.getElementById('datetitle3')){
                        document.getElementById('datetitle3').style.backgroundColor=shade(e, 0.5);
                        document.getElementById('datetitle3').style.color=e;

                    }
                    if(document.getElementById('datetitle3-2')){
                        document.getElementById('datetitle3-2').style.backgroundColor=shade(e, 0.5);
                        document.getElementById('datetitle3-2').style.color=e;

                    }
                    if(document.getElementById('termtitle3')){
                        document.getElementById('termtitle3').style.backgroundColor=shade(e, 0.5);
                        document.getElementById('termtitle3').style.color=e;
                    }
                    if(document.getElementById('termtitle3-2')){
                        document.getElementById('termtitle3-2').style.backgroundColor=shade(e, 0.5);
                        document.getElementById('termtitle3-2').style.color=e;
                    }
                    if(document.getElementById('EmailHeaderCompanyName')){
                        document.getElementById('EmailHeaderCompanyName').style.borderTop="1px solid "+e;
                        document.getElementById('EmailHeaderCompanyName').style.color=e;
                    }
                    if(document.getElementById('duedatetitle3-2')){
                        document.getElementById('duedatetitle3-2').style.backgroundColor=e;
                    }
                    if(document.getElementById('duedatetitle3')){
                        document.getElementById('duedatetitle3').style.backgroundColor=e;
                    }
                    if(document.getElementById('emailbelowMessage')){
                        document.getElementById('emailbelowMessage').style.backgroundColor=shade(e, 0.5);
                    }
                    if(document.getElementById('activityTableLhsTableHeader')){
                        $("#activityTableLhsTableHeader th").css({
                        "background-color": shade(e, 0.5),
                        "color" : e
                        });
                    }
                    function shade(color, percent){
                    if (color.length > 7 ){
                    return shadeRGBColor(color,percent);
                    } 
                    else{
                    return shadeColor2(color,percent);
                    } 
                    }
                    function shadeRGBColor(color, percent) {
                    var f=color.split(","),t=percent<0?0:255,p=percent<0?percent*-1:percent,R=parseInt(f[0].slice(4)),G=parseInt(f[1]),B=parseInt(f[2]);
                    return "rgb("+(Math.round((t-R)*p)+R)+","+(Math.round((t-G)*p)+G)+","+(Math.round((t-B)*p)+B)+")";
                    }
                    function shadeColor2(color, percent) {   
                    var f=parseInt(color.slice(1),16),t=percent<0?0:255,p=percent<0?percent*-1:percent,R=f>>16,G=f>>8&0x00FF,B=f&0x0000FF;
                    return "#"+(0x1000000+(Math.round((t-R)*p)+R)*0x10000+(Math.round((t-G)*p)+G)*0x100+(Math.round((t-B)*p)+B)).toString(16).slice(1);
                    }
                    
                    
                    </script>
  </body>
</html>