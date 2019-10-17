@extends('layout.initial')


@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1 >Journal Entry</h1>
                

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
    <div class="modal fade" id="ImportJournalEntryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Journal Entries</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="text-align:center;">
            <style>
            #excel-upload-journal{
				display: none;
			}
            </style>
            <input id="excel-upload-journal" onchange="UploadMassJournalEntry()" type="file"  accept=".xlsx" >
            <label for="excel-upload-journal" style="opacity:1;cursor:pointer;border-radius:10px;" id="FIleImportExcelLabel" class="custom-excel-upload btn btn-primary">
            <span class="glyphicon glyphicon-user"></span> IMPORT FROM EXCEL</span>
            </label>
            <script>
                    function UploadMassJournalEntry(){
                        
                        document.getElementById('import_overlay').style.display="block";

                        var file = $('#excel-upload-journal')[0].files[0]
                        var fd = new FormData();
                        fd.append('theFile', file);
                        fd.append('_token','{{csrf_token()}}');
                        $.ajax({
                            url: 'UploadMassJournalEntry',
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
                            document.getElementById("excel-upload-journal").value = "";
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
                        document.getElementById("excel-upload-journal").value = "";
                        //location.reload();
                    }
                </script>
        </div>
        <div class="modal-footer">
            <a class="btn btn-success" href="GetJournalEntryTemplateExcel">Download Excel Template</a>
        </div>
        </div>
    </div>
    </div>
</div>
<div class="card-body">
    <div class="row" style="">
        <div class="col-md-12" >
            <div class=" mr-2 mb-5 mt-3">
                <a href="#" class="btn btn-success" data-target='#journalentrymodal' data-toggle="modal">New Journal Entry</a>
                <a href="#" class="btn btn-success" data-target='#ImportJournalEntryModal' data-toggle="modal">Import Journal Entry</a>
                
            </div>
            
        </div>
        <script>
            
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
    </div>
    <div class="row" style="">
        <div class="col-md-10">
        </div>
        <div class="col-md-2">
            <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Enter Keyword.." value="{{$keyword}}" id="SearchFilterJournalEnties">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" onclick="currentjournal_no_go()" title="Search Journal Entries" type="button"><span class="fa fa-search"></span></button>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                <div id="table" class="table-editable">
                    
                    <table id="jounalentrytable" class="table table-bordered table-responsive-md table-striped  font14" width="100%">
                        <thead>
                            <tr>
                                <th width="8%" class="text-center">JOURNAL DATE</th>
                                <th width="5%" class="text-center">ACCOUNT CODE</th>
                                <th width="5%" class="text-center">JOURNAL NO</th>
                                <th width="20%" class="text-center">ACCOUNT</th>
                                <th class="text-center">DEBIT</th>
                                <th class="text-center">CREDIT</th>
                                <th class="text-center">DESCRIPTION</th>
                                <th class="text-center">NAME</th>
                                <th class="text-center">MEMO</th>
                                <th class="text-center"></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($JournalEntry)>0)
                            @foreach($JournalEntry as $je)
                                @if ($je->remark!="NULLED")
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
                               
                                <tr>
                                <td style="vertical-align:middle;">{{date("m-d-Y", strtotime($je->je_attachment))}} </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    @foreach ($COA as $coa)
                                        @if($coa->id==$je->je_account)
                                        @if(!empty($numbering) && $numbering->use_cost_center=="Off")
                                        {{$coa->coa_code}}
                                        @else
                                        @if($je->je_cost_center!="")
                                        <?php
                                        $cost_center_code="";

                                        ?>
                                        @foreach ($cost_center_list as $list)
                                            @if($list->cc_no==$je->je_cost_center)
                                            <?php
                                            $cost_center_code=$list->cc_name_code;
                                            ?>
                                            @endif
                                        @endforeach
                                        {{$cost_center_code."-".$coa->coa_code}}
                                        @else 
                                        {{$coa->coa_code}}
                                        @endif
                                        @endif
                                        
                                        @endif
                                    @endforeach    
                                    
                                
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    
                                    {{$je->je_no}}
                                    
                                </td>
                                
                                <td style="vertical-align:middle;{{$je->je_debit!=""? "text-align:left;": "text-align:left;padding-left:20px;"}}">{{is_numeric($je->je_account)==true? $journalaccount : $je->je_account}}</td>
                                <td style="vertical-align:middle;">{{$je->je_debit!=""? number_format($je->je_debit,2): ""}}</td>
                                <td style="vertical-align:middle;">{{$je->je_credit!=""? number_format($je->je_credit,2) : ""}}</td>
                                <td style="vertical-align:middle;">{{$je->je_desc}}</td>
                                <td style="vertical-align:middle;">
                                    {{$je->je_name}}
                                    
                                </td>
                                <td style="vertical-align:middle;">{{$je->je_memo}}</td>
                                
                                    <td style="vertical-align:middle;text-align:center;">
                                    
                                    
                                    <div class="btn-group">
                                            {{-- <button type="button" class="btn bg-transparent text-info">Accounts History</button> --}}
                                            <button type="button" class="btn bg-transparent  px-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-custom">
                                                <a  class="dropdown-item" href="print_journal_entry?no={{$je->je_no}}" target="_blank">Print</a>
                                                @if ($je->je_transaction_type=="Journal Entry")
                                                <a href="#"  onclick="edit_journal_entries('{{$je->je_no}}')" class="dropdown-item">Edit</a>
                                                @endif
                                                <?php $invoice_validforcancel=0;?>
                                                @if ($je->je_transaction_type=="Invoice")
                                                    @foreach ($saleeeeeeee as $see)
                                                        @if ($see->st_type=="Sales Receipt" && $see->st_payment_for==$je->other_no && $see->st_location." ".$see->st_invoice_type==$je->je_invoice_location_and_type)
                                                        <?php $invoice_validforcancel=1;break;?>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if ($invoice_validforcancel==1)
                                                    
                                                @else
                                                    @if($je->remark=="")
                                                    <?php
                                                        $locationssss="";
                                                        $invoice_typesss="";
                                                        if($je->je_invoice_location_and_type!=""){
                                                            $splited=explode(" ",$je->je_invoice_location_and_type);
                                                            if(count($splited)>=3){
                                                                $locationssss=$splited[0];
                                                                $invoice_typesss=$splited[1]." ".$splited[2];
                                                            }
                                                            
                                                        }
                                                        

                                                    ?>
                                                    <a class="dropdown-item" href="#" onclick="cancelentry('{{$je->je_transaction_type}}','{{$je->other_no}}','{{$locationssss}}','{{$invoice_typesss}}')">Cancel Transaction</a>
                                                    @else
                                                    <a class="dropdown-item" href="#">Cancelled</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>  
                                @endif
                                
                            
                            @endforeach
                            @endif

                            
                        </tbody>
                            <!-- This is our clonable table line -->
                    </table>
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                <div class="input-group" style="width: 15%;float: right;">
                <div class="input-group-prepend">
                <button type="button" onclick="back_currentjournal_no_go()" class="btn btn-secondary" style="line-height:2"><span class="fa fa-angle-double-left"></span></button>
                </div>
                <input type="number" name="" id="currentjournal_no" onchange="currentjournal_no_go()" value="{{$JournalNoSelected+1}}" min="0" step="20" class="form-control" style="text-align:center;">
                
                <div class="input-group-append">
                    <button type="button" onclick="forward_currentjournal_no_go()" class="btn btn-secondary" style="line-height:2"><span class="fa fa-angle-double-right"></span></button>
                </div>
                </div>
                <script>
                    function forward_currentjournal_no_go(){
                        var current_no="{{$JournalNoSelected}}";
                        var keywordselected="{{$keyword}}";//Citi
                        var currentjournal_no="{{($JournalNoSelected+20)+1}}";
                        var SearchFilterJournalEnties=document.getElementById('SearchFilterJournalEnties').value;//Globe
                        if(keywordselected!=SearchFilterJournalEnties){
                            //different keyword
                            window.location="journalentry?no={{($JournalNoSelected+20)+1}}&keyword="+SearchFilterJournalEnties;
                            
                        }else{
                            if(current_no!=currentjournal_no && currentjournal_no!=""){
                            window.location="journalentry?no="+currentjournal_no+"&keyword="+SearchFilterJournalEnties;
                            }
                        }
                        
                    }
                    function back_currentjournal_no_go(){
                        var current_no="{{$JournalNoSelected}}";
                        var keywordselected="{{$keyword}}";//Citi
                        var currentjournal_no="{{$JournalNoSelected-20>-1? ($JournalNoSelected-20)+1 : 1}}";
                        var SearchFilterJournalEnties=document.getElementById('SearchFilterJournalEnties').value;//Globe
                        if(keywordselected!=SearchFilterJournalEnties){
                            //different keyword
                            window.location="journalentry?no={{$JournalNoSelected-20>-1? ($JournalNoSelected-20)+1 : 1}}&keyword="+SearchFilterJournalEnties;
                            
                        }else{
                            if(current_no!=currentjournal_no && currentjournal_no!=""){
                            window.location="journalentry?no="+currentjournal_no+"&keyword="+SearchFilterJournalEnties;
                            }
                        }
                        
                    }
                function currentjournal_no_go(){
                    var current_no="{{$JournalNoSelected}}";
                    var keywordselected="{{$keyword}}";//Citi
                    var currentjournal_no=document.getElementById('currentjournal_no').value;
                    var SearchFilterJournalEnties=document.getElementById('SearchFilterJournalEnties').value;//Globe
                    if(keywordselected!=SearchFilterJournalEnties){
                        //different keyword
                        window.location="journalentry?no=1&keyword="+SearchFilterJournalEnties;
                        
                    }else{
                        if(current_no!=currentjournal_no && currentjournal_no!=""){
                        window.location="journalentry?no="+currentjournal_no+"&keyword="+SearchFilterJournalEnties;
                        }
                    }
                    
                }
                </script>
        </div>
    </div>
</div>   
@endsection