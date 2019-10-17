@extends('layout.initial')

@section('content')

<div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Voucher</h1>
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
    <div class="container">
        <div class="row">
                <div class="col-md-10">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#vouchermodal">Voucher</a>
                </div>
                <div class="col-md-2">
                    <select class="form-control" id="vouchertype" onchange="changevoucher(this.value)">
                    <option>Cheque Voucher</option>
                    <option>Cash Voucher</option>
                    </select>
                    <script>
                        function changevoucher(e){
                            if(e=="Cheque Voucher"){
                                document.getElementById('VoucherHeader').innerHTML="Cheque Voucher";
                                document.getElementById('TF1').innerHTML="Pay to the Order of : ";
                                document.getElementById('TF2').innerHTML="Recieve From: ";
                                document.getElementById('BankTR').style.display="table-row";
                                document.getElementById('CheckNoTR').style.display="table-row";
                            }
                            else if(e=="Cash Voucher"){
                                document.getElementById('VoucherHeader').innerHTML="Cash Voucher";
                                document.getElementById('TF1').innerHTML="Paid To";
                                document.getElementById('TF2').innerHTML="Department";
                                document.getElementById('BankTR').style.display="none";
                                document.getElementById('CheckNoTR').style.display="none";
                            }
                        }
                    </script>
                </div>
        </div>
        <br>
        <style>
            td> .form-control{
                border: 0px solid white;
                border-bottom: 1px solid #262626;

            }
        </style>
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
                            <td width="30%" style="vertical-align:middle" id="TF1">Pay to the Order of : </td>
                            <td width="40%" style="vertical-align:middle"><input type="text" class="form-control" id="PaytoOrderof"></td>
                            <td width="10%" style="vertical-align:middle">No. </td>
                            <td width="20%" style="vertical-align:middle"><input type="text" class="form-control" id="VoucherNo" value="{{$VoucherCount}}" readonly></td>
                        </tr>
                        <tr>
                            <td width="30%" style="vertical-align:middle" id="TF2">Recieve From: </td>
                            <td width="40%" style="vertical-align:middle"><input type="text" id="ReceivedFrom" class="form-control"></td>
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
                        <th width="5%" style="vertical-align:middle;text-align:center;"><button class="btn btn-primary btn-sm" onclick="addtransactioncolumn()"><span class="fa fa-plus-circle"></span></button>
                        
                        </th>
                        <th width="10%" style="vertical-align:middle;text-align:center;">QTY.</th>
                        <th width="10%" style="vertical-align:middle;text-align:center;">UNIT</th>
                        <th width="45%" style="vertical-align:middle;text-align:center;">EXPLANATION OF TRANSACTION</th>
                        <th colspan="2" style="vertical-align:middle;text-align:center;">AMOUNT</th>
                    </tr>
                    
                    </thead>
                    <tbody id="tbodyvouchertransaction">
                        
                    </tbody>
                    <tbody>
                        <tr>
                            <td colspan="4" style="vertical-align:middle;text-align:right;font-weight:bold;">TOTAL</td>
                            <td width="30%" style="vertical-align:middle;"><input type="number" class="form-control" id="AllTotal"  readonly></td>
                        </tr>
                        
                    </tbody>    
                </table>
            </div>
           
        </div>
        <div class="row" id="distributionofaccount">
            <div class="col-md-12" style="margin:10px 0px 10px 0px;">
                <h5>Distribution of Account:</h5>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered table-sm" style="background-color:white;margin-bottom:0px;">
                    <thead>
                    <tr>
                        <th width="10%" style="vertical-align:middle;text-align:center;">
                            <button class="btn btn-primary btn-sm" onclick="addcolumnJournalEntry()"><span class="fa fa-plus-circle"></span></button>
                        </th>
                        
                        <th width="50%" style="vertical-align:middle;text-align:center;">ACCOUNT TITLE</th>
                        <th width="20%" style="vertical-align:middle;text-align:center;">DEBIT</th>
                        <th width="20%" style="vertical-align:middle;text-align:center;">CREDIT</th>
                    </tr>
                    </thead>
                    <tbody id="tbodyjournlaentry">
                        
                    </tbody>
                       
                </table>
            </div>
            <div class="col-md-6" style="padding-left:0px;">
                <table class="table  table-sm" style="background-color:white;margin-bottom:0px;">
                    <tbody>
                        <tr>
                            <td  style="vertical-align:middle;">Received From</td>
                            <td colspan="3"  style="vertical-align:middle;"><input type="text" id="ReceivedFromBank" class="form-control"></td>
                        </tr>
                        <tr>
                            <td  style="vertical-align:middle;">the amount of</td>
                            <td colspan="3"  style="vertical-align:middle;"><input type="text" id="amountofBank" class="form-control"></td>
                        </tr>
                        <tr id="BankTR">
                            <td style="vertical-align:middle;">Bank</td>
                            <td style="vertical-align:middle;"><input type="text" id="BankBank" class="form-control"></td>
                        </tr>
                        <tr id="CheckNoTR">
                            <td  style="vertical-align:middle;">Check No.</td>
                            <td  style="vertical-align:middle;"><input type="text" id="ChequeNoBank" class="form-control"></td>
                        </tr>
                        <tr>
                            <td  style="vertical-align:middle;">Received Payment By</td>
                            <td colspan="3"  style="vertical-align:middle;"><input id="PaymentByBank" type="text" class="form-control"></td>
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
                            <td style="vertical-align:middle;">Approved By :</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:middle;border-color:white;"><input type="text" id="prepared_by" class="form-control"></td>
                            <td style="vertical-align:middle;border-color:white;"><input type="text" id="certified_correct_by" class="form-control"></td>
                            <td style="vertical-align:middle;border-color:white;"><input type="text" id="approved_by" class="form-control"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row" style="">
            <div class="col-md-12" style="text-align:right;">
            <button class="btn btn-primary" onclick="ProceedVoucher()">Proceed</button>
            </div>
            <script>
                function ProceedVoucher(){
                    var journalentrycolumns = [];
                    var transactioncolumns = [];
                    var c=0;
                    var d=0;
                    for(var a=1;a<=columncountjournaentry;a++){
                        if(document.getElementById('transactiontrj'+a)){
                            console.log('transactiontrj'+a);
                            journalentrycolumns.push({'title':document.getElementById('accounttittle'+a).value,'debit':document.getElementById('debit'+a).value,'credit':document.getElementById('credit'+a).value});
                            
                            if(document.getElementById('debit'+a).value!=""){
                                c=c+parseFloat(document.getElementById('debit'+a).value);
                            }
                            if(document.getElementById('credit'+a).value!=""){
                                d=d+parseFloat(document.getElementById('credit'+a).value);
                            }
                        }
                        
                    }
                    var maxtotal=0;
                        for(var a=1;a<=columncount;a++){
                            if(document.getElementById('transactiontr'+a)){
                                console.log('transactiontr'+a);
                                transactioncolumns.push({'qty':document.getElementById('qty'+a).value,'unit':document.getElementById('unit'+a).value,'desc':document.getElementById('desc'+a).value,'amount':document.getElementById('amount'+a).value});
                                if(document.getElementById('amount'+a).value!=""){
                                    maxtotal=maxtotal+parseFloat(document.getElementById('amount'+a).value);
                                }
                            }
                        }
                    if(c==d){
                        
                       if(c==maxtotal){
                        var vouchertype=document.getElementById('vouchertype').value;
                        var PaytoOrderof=document.getElementById('PaytoOrderof').value;
                        var VoucherNo=document.getElementById('VoucherNo').value;
                        var ReceivedFrom=document.getElementById('ReceivedFrom').value;
                        var voucherdate=document.getElementById('voucherdate').value;
                        var ReceivedFromBank=document.getElementById('ReceivedFromBank').value;
                        var amountofBank=document.getElementById('amountofBank').value;
                        var BankBank=document.getElementById('BankBank').value;
                        var ChequeNoBank=document.getElementById('ChequeNoBank').value;
                        var PaymentByBank=document.getElementById('PaymentByBank').value;
                        var prepared_by=document.getElementById('prepared_by').value;
                        var certified_correct_by=document.getElementById('certified_correct_by').value;
                        var approved_by=document.getElementById('approved_by').value;
                        $.ajax({
                        type: 'POST',
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('add_voucher') }}',
                        data: {_token: '{{csrf_token()}}',journalentrycolumns:journalentrycolumns,transactioncolumns:transactioncolumns,vouchertype:vouchertype,PaytoOrderof:PaytoOrderof,VoucherNo:VoucherNo,ReceivedFrom:ReceivedFrom,voucherdate:voucherdate,ReceivedFromBank:ReceivedFromBank,amountofBank:amountofBank,BankBank:BankBank,ChequeNoBank:ChequeNoBank,PaymentByBank:PaymentByBank,prepared_by:prepared_by,certified_correct_by:certified_correct_by,approved_by:approved_by},
                        success: function(data) {
                        swal({title: "Done!", text: data, type: 
                            "success"}).then(function(){
                            location.reload();
                            });
                        }

                        })
                       }else{
                           alert('Transaction does not match with the Distribution of Accounts');
                       }
                        
                        
                    }else{
                        alert('Please check Distribution of Account. Credit is not Equal to Debit');
                    }
                    
                    
                }
            </script>
        </div>
    </div>
@endsection