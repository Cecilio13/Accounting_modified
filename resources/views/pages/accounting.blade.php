@extends('layout.initial')


@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Accounting</h1>
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
    
    
    <div class="modal fade" id="ImpirtCOAModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Chart of Accounts</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="text-align:center;">
            <style>
            #excel-upload{
				display: none;
			}
            </style>
            <input id="excel-upload" type="file" onchange="UploadMassCOA()" accept=".xlsx" >
            <label for="excel-upload" style="opacity:1;cursor:pointer;border-radius:10px;" id="FIleImportExcelLabel" class="custom-excel-upload btn btn-primary">
            <span class="glyphicon glyphicon-user"></span> IMPORT FROM EXCEL</span>
            </label>
            <script>
                function UploadMassCOA(){
                    document.getElementById('import_overlay').style.display="block";
                    var file = $('#excel-upload')[0].files[0]
					var fd = new FormData();
					fd.append('theFile', file);
                    fd.append('_token','{{csrf_token()}}');
                    $.ajax({
                        url: 'UploadMassCOA',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: fd,
                        dataType:"json",
                        success: function (data, status, jqxhr) {
                        //alert(data.Success);
                        console.log(data.Error_Log);
                        var LOG="";
                        if(data.Error_Log!=""){
                        LOG=" \n\nSkip Log : \n"+data.Error_Log;
                        }
                        alert("Total number Of Data : "+data.Total+"\nData Saved : "+data.Success+" \nData Skipped : "+data.Skiped+LOG);
                        document.getElementById('import_overlay').style.display="none";
                        location.reload();
                        },
                        error: function (jqxhr, status, msg) {
                        //error code
                        alert(jqxhr.status +" message"+msg+" status:"+status);
                        alert(jqxhr.responseText);
                        }
					});
                    document.getElementById("excel-upload").value = "";
                    //location.reload();
                }
            </script>
        </div>
        <div class="modal-footer">
            <a class="btn btn-success" href="GetChartofAccountsExcelemplate">Download Excel Template</a>
            
        </div>
        </div>
    </div>
    </div>

<div class="card-body">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Chart of Accounts</a>
        </li>
        <li class="nav-item" style="display:none;">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Reconcile</a>
        </li>
        <li class="nav-item" style="{{!empty($numbering) && $numbering->use_cost_center=="Off"? 'display:none;' : 'display:none;'}}">
            <a class="nav-link" id="cost-center-tab" data-toggle="tab" href="#costcenter" role="tab" aria-controls="costcenter" aria-selected="true">Cost Center</a>
        </li>
    </ul>
    <div class="tab-content pl-3 p-1" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="col-md-12 mb-1 p-0">
                <h3 class="mt-2">Chart of Accounts</h3>
                
            </div>
            <div class="col-md-12 mb-5 mt-3 p-0">
                    <a class="btn btn-success" href="#" data-toggle="modal" data-target="#chartofaccountsmodal">New Chart of Accounts</a>
                    <a class="btn btn-success" href="#" data-toggle="modal" data-target="#ImpirtCOAModal">Import Chart of Accounts</a>
                </div>
           
                <div class="col-md-10">
                </div>
                <div class="col-md-2 pr-0">
                    <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter Keyword.." value="{{$keyword}}" id="SearchFilterChartofAccounts">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" onclick="currentcoa_go()" title="Search Chart Of Account." type="button"><span class="fa fa-search"></span></button>
                    </div>
                    </div>
                </div>
            
            <div class="table-editable">
                <!-- Button trigger modal -->
                <!-- <span class="table-add float-right mb-3 mr-2"><button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#staticModal">New Rule</button></span> -->
                
                <table id="coatable" class="table table-bordered table-responsive-md text-left font14">
                    <thead>
                    <tr class="bg-ltgrey">
                        <th class="text-left">CODE</th>
                        <th class="text-left">CLASSIFICATION</th>
                        <th class="text-left">LINE ITEM</th>
                        <th class="text-left">ACCOUNT TITLE</th>
                        <th class="text-left">BALANCE</th>
                        <th class="text-center" style="display:none">BANK BALANCE</th>
                        <th class="text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($COA_Type_GROUPPED as $caotype)
                      <tr>
                          <td style="text-align:left">
                            @if ($caotype=="Assets")
                            {{10000}}
                            @elseif($caotype=="Liabilities")
                            {{20000}}
                            @elseif($caotype=="Equity")
                            {{30000}}
                            @elseif($caotype=="Revenues")
                            {{40000}}
                            @elseif($caotype=="Expenses")
                            {{50000}}
                            @endif
                          </td>
                          <td style="text-align:left">{{$caotype}}</td>
                          <td style="text-align:left"></td>
                          <td style="text-align:left"></td>
                          <td style="text-align:left"></td>
                          <td style="text-align:left;display:none"></td>
                          <td style="text-align:left"></td>
                      </tr>
                      <?php
                        $placement=0;
                      ?>
                      @foreach ($COA as $cs)
                      @if($cs->coa_title==$caotype)
                        <tr>
                            <td class="pt-3-half" contenteditable="false" >{{$cs->coa_code}}</td>
                            <td class="pt-3-half" contenteditable="false"><span style="display:none;">{{$cs->coa_title}}</span></td>
                            
                            <td class="pt-3-half" contenteditable="false">{{$cs->coa_account_type}}</td>
                            <td class="pt-3-half" contenteditable="false">{{$cs->coa_name}}</td>
                            <td class="pt-3-half" contenteditable="false">
                                <?php
                                $coa_balance_total=$cs->coa_balance;
                                ?>
                                Php {{number_format($coa_balance_total,2)}}
                            </td>
                            <td class="pt-3-half" contenteditable="false" style="display:none">{{$cs->coa_account_type!="Bank"? '' : 'Php'.number_format($cs->coa_balance,2)}}</td>
                            <td class="text-center">
                                <span class="table-add mb-3 mr-2">
                                    <div class="btn-group">
                                        {{-- <button type="button" class="btn bg-transparent text-info">Accounts History</button> --}}
                                        <button type="button" class="btn bg-transparent  px-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" style="display:none;" href="">Connect Bank</a>
                                            <a class="dropdown-item" onclick="return confirm('Are you sure you want to change this?\nAny Changes here will be subject for Approval')" href="EditChartofAccounts/?id={{$cs->id}}">Edit</a>
                                            <form action="{{ action('ChartofAccountsController@destroy2', ['id' => $cs->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?\nThis will be subject for approval')">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="active" value="0">
                                                <input type="submit" class="dropdown-item btn-sm" value="Delete" style="font-size:11px;">
                                            </form>
                                            <a class="dropdown-item" style="display:none;" href="">Run Report</a>
                                        </div>
                                    </div>
                                </span>     
                            </td>
                        </tr>
                        <?php
                            $placement=1;
                        ?>
                      @endif
                          
                      @endforeach
                  @endforeach      
                        
                </tbody>
                </table>
                
            </div>
            <div class="row">
                <div class="col-md-12">
                        <div class="input-group" style="width: 15%;float: right;">
                        <div class="input-group-prepend">
                        <button type="button" onclick="back_coa_go()" class="btn btn-secondary" style="line-height:2"><span class="fa fa-angle-double-left"></span></button>
                        </div>
                        <input type="number" name="" id="currentjournal_no" onchange="currentcoa_go()" value="{{$COA_Index+1}}" min="0" step="20" class="form-control" style="text-align:center;">
                        
                        <div class="input-group-append">
                            <button type="button" onclick="forward_coa_go()" class="btn btn-secondary" style="line-height:2"><span class="fa fa-angle-double-right"></span></button>
                        </div>
                        </div>
                        <script>
                        function back_coa_go(){
                            //journalentry?no={{$COA_Index-20>-1? ($COA_Index-20)+1 : 1}}
                            var current_no="{{$COA_Index}}";
                            var keywordselected="{{$keyword}}";//Citi
                            var currentjournal_no="{{$COA_Index-20>-1? ($COA_Index-20)+1 : 1}}";
                            var SearchFilterChartof=document.getElementById('SearchFilterChartofAccounts').value;//Globe
                            if(keywordselected!=SearchFilterChartof){
                                //different keyword
                                window.location="accounting?no={{$COA_Index-20>-1? ($COA_Index-20)+1 : 1}}&keyword="+SearchFilterChartof;
                                
                            }else{
                                if(current_no!=currentjournal_no && currentjournal_no!=""){
                                window.location="accounting?no="+currentjournal_no+"&keyword="+SearchFilterChartof;
                                }
                            }
                        }
                        function forward_coa_go(){
                            //journalentry?no={{($COA_Index+20)+1}}
                            var current_no="{{$COA_Index}}";
                            var keywordselected="{{$keyword}}";//Citi
                            var currentjournal_no="{{($COA_Index+20)+1}}";
                            var SearchFilterChartof=document.getElementById('SearchFilterChartofAccounts').value;//Globe
                            if(keywordselected!=SearchFilterChartof){
                                //different keyword
                                window.location="accounting?no={{($COA_Index+20)+1}}&keyword="+SearchFilterChartof;
                                
                            }else{
                                if(current_no!=currentjournal_no && currentjournal_no!=""){
                                window.location="accounting?no="+currentjournal_no+"&keyword="+SearchFilterChartof;
                                }
                            }
                        }
                        function currentcoa_go(){
                            var current_no="{{$COA_Index}}";
                            var keywordselected="{{$keyword}}";//Citi
                            var currentjournal_no=document.getElementById('currentjournal_no').value;
                            var SearchFilterChartof=document.getElementById('SearchFilterChartofAccounts').value;//Globe
                            if(keywordselected!=SearchFilterChartof){
                                //different keyword
                                window.location="accounting?no=1&keyword="+SearchFilterChartof;
                                
                            }else{
                                if(current_no!=currentjournal_no && currentjournal_no!=""){
                                window.location="accounting?no="+currentjournal_no+"&keyword="+SearchFilterChartof;
                                }
                            }
                            
                        }
                        </script>
                </div>
            </div>
            <div class="modal fade" id="receiveModal" tabindex="-1" role="dialog" aria-labelledby="receiveModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="receiveModalLabel">Add yeah Rule</h5>
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
        <!-- ======================================================================================================================================== SECOND TAB--> 
        <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <!-- <h3>Sales Transactions</h3> -->
            <div id="table" class="table-editable">
                <!-- Button trigger modal -->
                <!-- <span class="table-add float-right mb-3 mr-2"><button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#staticModal">New Rule</button></span> -->
                <div class="col-md-12 p-0 mb-5">
                    <div class="col-md-6">
                        <div class="d-inline-block w-100 font12">
                            <p class="float-left">PHP {{number_format($invoicetotal,2)}} UNPAID</p>
                            <p class="float-right">LAST 365 DAYS</p>
                        </div>
                        <div class="d-inline-block w-100">
                            <div class="float-left padding0">
                                <p class="m-0 text-orange">PHP {{number_format($due,2)}}</p>
                                <p class="font12">OVERDUE</p>
                            </div>
                            <div class="float-right">
                                <p class="m-0 text-secondary">PHP {{number_format($notude,2)}}</p>
                                <p class="font12">NOT YET DUE</p>
                            </div>
                        </div>
                        <div class="progress mb-3 w-100">
                            @if($invoicetotal==0)
                            <div class="progress-bar bg-ltgreen" role="progressbar" style="width:0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            @else
                                <div class="progress-bar bg-ltgreen" role="progressbar" style="width:{{($due/$invoicetotal)*100}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            @endif
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-inline-block w-100 font12">
                            <p class="float-left">PHP 0.00 UNPAID</p>
                            <p class="float-right">LAST 365 DAYS</p>
                        </div>
                        <div class="d-inline-block w-100">
                            <div class="float-left padding0">
                                <p class="m-0 text-ltgreen">PHP 0.00</p>
                                <p class="font12">NOT DEPOSITED</p>
                            </div>
                            <div class="float-right">
                                <p class="m-0 text-success">PHP 2,000.00</p>
                                <p class="font12">DEPOSITED</p>
                            </div>
                        </div>
                        <div class="progress mb-3 w-100 bg-success">
                            <div class="progress-bar bg-ltgreen" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <div class="float-left">
                    <select>
                        <option value="" disabled selected>Batch Actions</option>
                        <option>Print Transactions</option>
                        <option>Print Packing Slip</option>
                        <option>Send Transactions</option>
                        <option>Send Reminders</option>
                    </select>
                </div>
                <div class="d-inline-flex float-right" style="margin-bottom:10px;">
                    <button class="btn btn-success rounded"><a href="invoice.php" class="text-white" data-toggle="modal" data-target="#invoicemodal"> New Invoice</a></button>
                </div>
                <table id="reconciletable"  class="table table-bordered table-responsive-md table-striped text-center font14">
                    <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" name=""></th>
                        <th class="text-center">DATE</th>
                        <th class="text-center">TYPE</th>
                        <th class="text-center">NO.</th>
                        <th class="text-center">CUSTOMER</th>
                        <th class="text-center">DUE-DATE</th>
                        <th class="text-center">BALANCE</th>
                        <th class="text-center">TOTAL</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">ACTION</th>
                    </tr>
                </thead>
                    
                    
                </table>
                <!-- <div class="pagination float-right">
                    <a class="pl-2 active" href="#">&laquo;First</a>
                    <a class="pl-2" href="#">Previous</a>
                    <a class="pl-2">1-1 of 1</a>
                    <a class="pl-2" href="#">Next</a>
                    <a class="pl-2" href="#">Last&raquo;</a>
                    </div> -->
            </div>
        </div>
        
    </div>
</div>
<Script>
    $(document).ready(function(){
$(document).on('click', '.receive_payment', function(){
        var id = $(this).attr('id');
        
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
                    }
                 @endforeach
            },
            error: function (data) {
                swal("Error!", "Transaction failed", "error");
            }
        });
    });
});
</script>
@endsection