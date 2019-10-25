@extends('layout.initial')


@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Cost Centers</h1>
                <div id="importlogsss"></div>
            
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
    
    
    

<div class="card-body">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link " style="display:none;" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Chart of Accounts</a>
        </li>
        <li class="nav-item" style="display:none;">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Reconcile</a>
        </li>
        <li class="nav-item" style="{{!empty($numbering) && $numbering->use_cost_center=="Off"? 'display:none;' : ''}}">
            <a class="nav-link active" id="cost-center-tab" data-toggle="tab" href="#costcenter" role="tab" aria-controls="costcenter" aria-selected="true">Cost Center</a>
        </li>
    </ul>
    <div class="tab-content pl-3 p-1" id="myTabContent">
        
        <div class="tab-pane fade show active" id="costcenter" role="tabpanel" aria-labelledby="cost-center-tab">
            <div class="col-md-12 mb-1 p-0">
               <h3 class="mt-2">Cost Center</h3>
                
<!-- Cost Center Import -->
<div class="modal fade" id="ImportCCModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Cost Center</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="text-align:center;">
            <style>
            #excel-upload-cc{
				display: none;
			}
            </style>
            <input id="excel-upload-cc" type="file" onchange="UploadMassCC()"  accept=".xlsx" >
            <label for="excel-upload-cc" style="opacity:1;cursor:pointer;border-radius:10px;" id="FIleImportExcelLabel" class="custom-excel-upload btn btn-primary">
            <span class="glyphicon glyphicon-user"></span> IMPORT FROM EXCEL</span>
            </label>
            <script>
                // $(document).ready(function(){
                    
                //     tempuploadbudget();
                // });
                function tempuploadbudget(){
                    
                    $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'UploadMassBudget',                
                    data: {_token: '{{csrf_token()}}'},
                    success: function(data) {
                        document.getElementById('importlogsss').innerHTML=data;
                    }  

                    })
                }
                function UploadMassCC(){
                    document.getElementById('import_overlay').style.display="block";
                    var file = $('#excel-upload-cc')[0].files[0]
					var fd = new FormData();
					fd.append('theFile', file);
                    fd.append('_token','{{csrf_token()}}');
                    $.ajax({
                        url: 'UploadMassCC',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: fd,
                        dataType:"json",
                        success: function (data, status, jqxhr) {
                            console.log(data.Error_Log);
                        //alert(data.Success);
                        //alert(data);
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
                        document.getElementById('import_overlay').style.display="none";
                        alert(jqxhr.responseText);
                        }
					});
                    document.getElementById("excel-upload-cc").value = "";
                    //location.reload();
                }
            </script>
        </div>
        <div class="modal-footer">
            <a class="btn btn-success" href="GetChartofCostCenterExcelemplate">Download Excel Template</a>
            
        </div>
        </div>
    </div>
    </div>
    <!-- Cost Center Import Bid of Quotation-->
<div class="modal fade" id="ImportBIDOFQUOTATIONModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-sm" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Bid of Quotation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="text-align:center;">
            <style>
            #excel-upload-bid{
				display: none;
			}
            </style>
            <input id="excel-upload-bid" type="file" onchange="UploadMassBIDQuot()"  accept=".xlsx" >
            <label for="excel-upload-bid" style="opacity:1;cursor:pointer;border-radius:10px;" id="FIleImportExcelLabelBid" class="custom-excel-upload btn btn-primary">
            <span class="glyphicon glyphicon-user"></span> IMPORT FROM EXCEL</span>
            </label>
            <script>
               
                function UploadMassBIDQuot(){
                    document.getElementById('import_overlay').style.display="block";
                    var file = $('#excel-upload-bid')[0].files[0]
					var fd = new FormData();
					fd.append('theFile', file);
                    fd.append('_token','{{csrf_token()}}');
                    $.ajax({
                        url: 'UploadMassBIDQuot',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: fd,
                        dataType:"json",
                        success: function (data, status, jqxhr) {
                        console.log(data.Extra);
                        //alert(data.Success);
                        //alert(data);
                        var LOG="";
                        if(data.Error_Log!=""){
                        LOG=" \n\nSkip Log : \n"+data.Error_Log;
                        }
                        
                        alert("Total number Of Data : "+data.Total+"\nData Saved : "+data.Success+" \nData Skipped : "+data.Skiped+LOG);
                        // var mywindow = window.open('', 'Import Log', 'height=400,width=600');
                        // mywindow.document.write("Total number Of Data : "+data.Total+"<br>\nData Saved : "+data.Success+" <br>\nData Skipped : "+data.Skiped+LOG.replace("\n", "<br>"));
                        document.getElementById('import_overlay').style.display="none";
                        location.reload();
                        },
                        error: function (jqxhr, status, msg) {
                        //error code
                        alert(jqxhr.status +" message"+msg+" status:"+status);
                        document.getElementById('import_overlay').style.display="none";
                        alert(jqxhr.responseText);
                        }
					});
                    document.getElementById("excel-upload-bid").value = "";
                    //location.reload();
                }
            </script>
        </div>
        <div class="modal-footer">
            
            <a class="btn btn-success" href="GetBudgetTemplateExcel_Bid_of_Quotation" >Download Bid of Account Excel Template</a>
                                                 
        </div>
        </div>
    </div>
    </div>
    <script>
        function openswal_cost_centertype(close,open){
            var typename="";
            var typecode="";
            document.getElementById(close).click();
            swal({
            text: 'New Cost Center Type',
            content: "input",
            button: {
                text: "proceed",
                closeModal: false,
            },
            })
            .then(name => {
            
                if (!name) throw null;

                $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: 'check_cost_center_name',                
                data: {name:name,_token: '{{csrf_token()}}'},
                success: function(data) {
                    swal.stopLoading();
                    swal.close();
                    if(data<1){
                        typename=name;
                        
                        swal({
                        text: 'New Cost Center Type Code',
                        content: "input",
                        button: {
                            text: "proceed",
                            closeModal: false,
                        },
                        })
                        .then(name => {
                            if (!name) throw null;
                            $.ajax({
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: 'check_cost_center_code',                
                            data: {name:name,_token: '{{csrf_token()}}'},
                            success: function(data) {
                                swal.stopLoading();
                                swal.close();
                                if(data<1){
                                    typecode=name;
                                        swal({
                                        title: typename+"("+typecode+")",
                                        text: "Are you sure to add this cost center type?",
                                        icon: "warning",
                                        buttons: true,
                                        dangerMode: true,
                                        })
                                        .then((willDelete) => {
                                        if (willDelete) {
                                            //ajax to save data
                                            $.ajax({
                                                type: "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                url: "save_cc_type",
                                                data: {typename:typename,typecode:typecode,_token:'{{csrf_token()}}'},
                                                success: function (data) {
                                                    
                                                    swal({title: "Done!", text:"Successfully Added Cost Center Type", type: 
                                                    "success"}).then(function(){
                                                    location.reload();                                    
                                                    });
                                                }
                                            });
                                            
                                        } else {
                                            
                                        }
                                        });
                                }else{
                                    document.getElementById(open).click();
                                }
                            }
                            })
                        })
                        .catch(err => {
                        if (err) {
                            swal("Error", "The AJAX request failed!", "error");
                        } else {
                            swal.stopLoading();
                            swal.close();
                        }
                        }); 
                    }else{
                        document.getElementById(open).click();
                    }
                    
                }
                })
                
                
            
            })
            .catch(err => {
            if (err) {
                swal("Error", "The AJAX request failed!", "error");
            } else {
                swal.stopLoading();
                swal.close();
            }
            });
        }
    </script>
<!--Cost Center Modal--->
<div class="modal fade" id="CostCenterModal" tabindex="-1" role="dialog" aria-labelledby="CostCenterModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="CostCenterModalLabel">Cost Center</h5>
        <button type="button" class="btn btn-primary" onclick="openswal_cost_centertype('closemodalcostcenter','costcenter_modal_open')">Add Cost Center Type</button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
        <p>Cost Center Type : </p> 
        </div>
        
        <div class="col-md-8">
        <script>
            
            function SetCode(e){
                document.getElementById('CostCenterCodePreview').value=e.value;
                document.getElementById('CostCenterCategoryCode').value=e.value+"-";
                document.getElementById('CostCenterTypeName').value=e.options[e.selectedIndex].innerHTML
                
            }
            function SaveCostCenter(){
                var Type_Code=document.getElementById('CostCenterCodePreview').value;
                var Category_Code=document.getElementById('CostCenterCategoryCode').value;
                var CostCenterType=document.getElementById('CostCenterType').value;
                var CostCenterCategory=document.getElementById('CostCenterCategory').value;
                var CostCenterTypeName=document.getElementById('CostCenterTypeName').value;
                var CostCenterBudget=document.getElementById('CostCenterBudget').value;
                var CostCenterBudgetpv=document.getElementById('CostCenterBudgetpv').value;

                var CostCenterBudgetpvMarch=document.getElementById('CostCenterBudgetpvMarch').value;
                var CostCenterBudgetpvApril=document.getElementById('CostCenterBudgetpvApril').value;
                var CostCenterBudgetpvMay=document.getElementById('CostCenterBudgetpvMay').value;
                var CostCenterBudgetpvJune=document.getElementById('CostCenterBudgetpvJune').value;
                var CostCenterBudgetpvJuly=document.getElementById('CostCenterBudgetpvJuly').value;
                var CostCenterBudgetpvAugust=document.getElementById('CostCenterBudgetpvAugust').value;
                var CostCenterBudgetpvSeptember=document.getElementById('CostCenterBudgetpvSeptember').value;
                var CostCenterBudgetpvOctober=document.getElementById('CostCenterBudgetpvOctober').value;
                var CostCenterBudgetpvNovember=document.getElementById('CostCenterBudgetpvNovember').value;
                var CostCenterBudgetpvDecember=document.getElementById('CostCenterBudgetpvDecember').value;
                var CostCenterBudgetQQ=document.getElementById('CostCenterBudgetQQ').value;
                
                var UseBid="No";
                if($('#UseBid').is(":checked")){
                    UseBid="Yes";
                }
                if(Type_Code==Category_Code+"-"){
                    alert('Enter Category Code');
                }else{
                    if(CostCenterCategory!=""){
                        $.ajax({
                        type: 'POST',
                        url: 'SetCostCenter',                
                        data: {CostCenterBudgetQQ:CostCenterBudgetQQ,UseBid:UseBid,CostCenterBudgetpvDecember:CostCenterBudgetpvDecember,CostCenterBudgetpvNovember:CostCenterBudgetpvNovember,CostCenterBudgetpvOctober:CostCenterBudgetpvOctober,CostCenterBudgetpvSeptember:CostCenterBudgetpvSeptember,CostCenterBudgetpvAugust:CostCenterBudgetpvAugust,CostCenterBudgetpvJuly:CostCenterBudgetpvJuly,CostCenterBudgetpvJune:CostCenterBudgetpvJune,CostCenterBudgetpvMay:CostCenterBudgetpvMay,CostCenterBudgetpvApril:CostCenterBudgetpvApril,CostCenterBudgetpvMarch:CostCenterBudgetpvMarch,CostCenterBudget:CostCenterBudget,CostCenterBudgetpv:CostCenterBudgetpv,CostCenterTypeName:CostCenterTypeName,Type_Code:Type_Code,Category_Code:Category_Code,CostCenterType:CostCenterType,CostCenterCategory:CostCenterCategory,_token: '{{csrf_token()}}'},
                        success: function(data) {
                           location.reload();
                        },
                        error: function(jqXHR, exception){
                        alert(jqXHR.responseText);
                        }											 
                        });
                    }else{
                        alert('Enter Category');
                    }
                }
                
            }
            function CheckCatCode(){
                var e=document.getElementById('CostCenterCategoryCode').value;
                $.ajax({
                type: 'POST',
                url: 'GetCodeCostCenter',                
                data: {type_code:e,_token: '{{csrf_token()}}'},
                success: function(data) {
                    if(data==0){
                        document.getElementById('SaveCostCenterButton').disabled=false;
                        document.getElementById('SaveCostCenterButton').title='';
                        document.getElementById('CostCenterCategoryCode').style.borderColor="Green";
                    }
                    else if(data==1){
                        document.getElementById('SaveCostCenterButton').disabled=true;
                        document.getElementById('SaveCostCenterButton').title='Duplicate Category';
                        document.getElementById('CostCenterCategoryCode').style.borderColor="Red";

                    }
                },
                error: function(jqXHR, exception){
                alert(jqXHR.responseText);
                }											 
                });
            }
        </script>
        <select class="form-control selectpicker" data-live-search="true" id="CostCenterType"  onchange="SetCode(this)" required>
        <option value="">--Select Type--</option>
        @foreach ($CC_Types_list as $cost_centers)
            <option value="{{$cost_centers->cc_code}}">{{$cost_centers->cc_type}}</option>
        @endforeach
        </select>
        </div>
        <div class="col-md-4">
            <input type="hidden" id="CostCenterTypeName">
            <input type="text" id="CostCenterCodePreview" readonly class="form-control form-control-sm">
        </div>

        <div class="col-md-8" style="margin-top:10px;">
            <p>Cost Center Category</p>
        </div>
        <div class="col-md-4" style="margin-top:10px;">
            <p>Code</p>
        </div>
        <div class="col-md-8">
            <input type="text" id="CostCenterCategory" class="form-control form-control-sm">
        </div>
        <div class="col-md-4">
            <input type="text" onkeyup="CheckCatCode()" id="CostCenterCategoryCode" class="form-control form-control-sm" >
        </div>
        <div class="col-md-12" style="margin-top:10px;display:none;" > 
            <div class="form-check form-check-inline" style="display:none;">
            <input onclick="checkcheckboxbid()" class="form-check-input" type="checkbox" id="UseBid" value="Yes" checked>
            <label class="form-check-label" for="UseBid">Use Bid of Quotation</label>
            </div>
            <script>
                $(document).ready(function(){
                    checkcheckboxbid();
                })
                function checkcheckboxbid(){
                    if($('#UseBid').is(":checked")){
                        document.getElementById('MonthsDivBVudget').style.display="none";
                        //document.getElementById('QuotationBudgetDiv').style.display="inline";
                    }else{
                        document.getElementById('MonthsDivBVudget').style.display="inline";
                        document.getElementById('QuotationBudgetDiv').style.display="none";
                    }
                   
                }
            </script>
        </div>
        <div id="QuotationBudgetDiv" style="display:none;">
            <div class="col-md-12" style="margin-top:10px;">
            <p>Bid of Quotation</p>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetQQ()" onchange="setLabelBudgetQQ()" id="CostCenterBudgetQQ" class="form-control form-control-sm" >
            </div>
            <div class="col-md-6"  style="text-align:right;">
                <script>
                    function setLabelBudgetQQ(){
                        console.log("PHP "+number_format(document.getElementById('CostCenterBudgetQQ').value,2));
                        document.getElementById('labelbudgetQQ').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetQQ').value,2);
                    }
                </script>
                <p id="labelbudgetQQ">PHP 0.00</p>
            </div>
        </div>
        <div id="MonthsDivBVudget">
         
        <div class="col-md-12" style="margin-top:10px;">
            <p>Cost Center Budget</p>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
            <p>January</p>
        </div>
        <div class="col-md-6">
            <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudget()" onchange="setLabelBudget()" id="CostCenterBudget" class="form-control form-control-sm" >
        </div>
        <div class="col-md-6"  style="text-align:right;">
            <script>
                function setLabelBudget(){
                    console.log("PHP "+number_format(document.getElementById('CostCenterBudget').value,2));
                    document.getElementById('labelbudget').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudget').value,2);
                }
            </script>
            <p id="labelbudget">PHP 0.00</p>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
            <p>February</p>
        </div>
        <div class="col-md-6">
            <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetpv()" onchange="setLabelBudgetpv()" id="CostCenterBudgetpv" class="form-control form-control-sm" >
        </div>
        <div class="col-md-6" style="text-align:right;">
            <script>
                function setLabelBudgetpv(){
                    document.getElementById('labelbudgetpv').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpv').value,2);
                }
            </script>
            <p id="labelbudgetpv">PHP 0.00</p>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
            <p>March</p>
        </div>
        <div class="col-md-6">
            <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetpvmarch()" onchange="setLabelBudgetpvmarch()" id="CostCenterBudgetpvMarch" class="form-control form-control-sm" >
        </div>
        <div class="col-md-6" style="text-align:right;">
            <script>
                function setLabelBudgetpvmarch(){
                    document.getElementById('labelbudgetpvmarch').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpvMarch').value,2);
                }
            </script>
            <p id="labelbudgetpvmarch">PHP 0.00</p>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
            <p>April</p>
        </div>
        <div class="col-md-6">
            <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetpvApril()" onchange="setLabelBudgetpvApril()" id="CostCenterBudgetpvApril" class="form-control form-control-sm" >
        </div>
        <div class="col-md-6" style="text-align:right;">
            <script>
                function setLabelBudgetpvApril(){
                    document.getElementById('labelbudgetpvApril').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpvApril').value,2);
                }
            </script>
            <p id="labelbudgetpvApril">PHP 0.00</p>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
            <p>May</p>
        </div>
        <div class="col-md-6">
            <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetpvMay()" onchange="setLabelBudgetpvMay()" id="CostCenterBudgetpvMay" class="form-control form-control-sm" >
        </div>
        <div class="col-md-6" style="text-align:right;">
            <script>
                function setLabelBudgetpvMay(){
                    document.getElementById('labelbudgetpvMay').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpvMay').value,2);
                }
            </script>
            <p id="labelbudgetpvMay">PHP 0.00</p>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
            <p>June</p>
        </div>
        <div class="col-md-6">
            <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetpvJune()" onchange="setLabelBudgetpvJune()" id="CostCenterBudgetpvJune" class="form-control form-control-sm" >
        </div>
        <div class="col-md-6" style="text-align:right;">
            <script>
                function setLabelBudgetpvJune(){
                    document.getElementById('labelbudgetpvJune').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpvJune').value,2);
                }
            </script>
            <p id="labelbudgetpvJune">PHP 0.00</p>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
            <p>July</p>
        </div>
        <div class="col-md-6">
            <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetpvJuly()" onchange="setLabelBudgetpvJuly()" id="CostCenterBudgetpvJuly" class="form-control form-control-sm" >
        </div>
        <div class="col-md-6" style="text-align:right;">
            <script>
                function setLabelBudgetpvJuly(){
                    document.getElementById('labelbudgetpvJuly').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpvJuly').value,2);
                }
            </script>
            <p id="labelbudgetpvJuly">PHP 0.00</p>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
            <p>August</p>
        </div>
        <div class="col-md-6">
            <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetpvAugust()" onchange="setLabelBudgetpvAugust()" id="CostCenterBudgetpvAugust" class="form-control form-control-sm" >
        </div>
        <div class="col-md-6" style="text-align:right;">
            <script>
                function setLabelBudgetpvAugust(){
                    document.getElementById('labelbudgetpvAugust').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpvAugust').value,2);
                }
            </script>
            <p id="labelbudgetpvAugust">PHP 0.00</p>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
            <p>September</p>
        </div>
        <div class="col-md-6">
            <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetpvSeptember()" onchange="setLabelBudgetpvSeptember()" id="CostCenterBudgetpvSeptember" class="form-control form-control-sm" >
        </div>
        <div class="col-md-6" style="text-align:right;">
            <script>
                function setLabelBudgetpvSeptember(){
                    document.getElementById('labelbudgetpvSeptember').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpvSeptember').value,2);
                }
            </script>
            <p id="labelbudgetpvSeptember">PHP 0.00</p>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
            <p>October</p>
        </div>
        <div class="col-md-6">
            <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetpvOctober()" onchange="setLabelBudgetpvOctober()" id="CostCenterBudgetpvOctober" class="form-control form-control-sm" >
        </div>
        <div class="col-md-6" style="text-align:right;">
            <script>
                function setLabelBudgetpvOctober(){
                    document.getElementById('labelbudgetpvOctober').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpvOctober').value,2);
                }
            </script>
            <p id="labelbudgetpvOctober">PHP 0.00</p>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
            <p>November</p>
        </div>
        <div class="col-md-6">
            <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetpvNovember()" onchange="setLabelBudgetpvNovember()" id="CostCenterBudgetpvNovember" class="form-control form-control-sm" >
        </div>
        <div class="col-md-6" style="text-align:right;">
            <script>
                function setLabelBudgetpvNovember(){
                    document.getElementById('labelbudgetpvNovember').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpvNovember').value,2);
                }
            </script>
            <p id="labelbudgetpvNovember">PHP 0.00</p>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
            <p>December</p>
        </div>
        <div class="col-md-6">
            <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetpvDecember()" onchange="setLabelBudgetpvDecember()" id="CostCenterBudgetpvDecember" class="form-control form-control-sm" >
        </div>
        <div class="col-md-6" style="text-align:right;">
            <script>
                function setLabelBudgetpvDecember(){
                    document.getElementById('labelbudgetpvDecember').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpvDecember').value,2);
                }
            </script>
            <p id="labelbudgetpvDecember">PHP 0.00</p>
        </div>
        </div>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary" id="closemodalcostcenter" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="SaveCostCenterButton" onclick="SaveCostCenter()">Save</button>
      </div>
    </div>
  </div>
</div> 
<!--Cost Center Modal End--->
<!-- Cost Center Edit Modal -->
<div class="modal fade" id="CostCenterModalEdit" tabindex="-1" role="dialog" aria-labelledby="CostCenterModalLabelEdit" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="CostCenterModalLabelEdit">Edit Cost Center</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
        <p>Cost Center Type : </p>    
        </div>
        
        <div class="col-md-8">
        <script>
            function SetCodeEdit(e){
                document.getElementById('CostCenterCodePreviewEdit').value=e.value;
                document.getElementById('CostCenterCategoryCodeEdit').value=e.value+"-";
                document.getElementById('CostCenterTypeNameEdit').value=e.options[e.selectedIndex].innerHTML
                
            }
            function SaveCostCenterEdit(){
                var Type_Code=document.getElementById('CostCenterCodePreviewEdit').value;
                var Category_Code=document.getElementById('CostCenterCategoryCodeEdit').value;
                var CostCenterType=document.getElementById('CostCenterTypeEdit').value;
                var CostCenterCategory=document.getElementById('CostCenterCategoryEdit').value;
                var CostCenterTypeName=document.getElementById('CostCenterTypeNameEdit').value;
                var no=document.getElementById('CostCenterHiddenNoEdit').value;

                var hiddenthisyearbudgetedit=document.getElementById('hiddenthisyearbudgetedit').value;
                var CostCenterBudgetedit=document.getElementById('CostCenterBudgetedit').value;

                var hiddenthisyearbudgeteditpv=document.getElementById('hiddenthisyearbudgeteditpv').value;
                var CostCenterBudgetpvedit=document.getElementById('CostCenterBudgetpvedit').value;

                var hiddenthisyearbudgeteditpvMarch=document.getElementById('hiddenthisyearbudgeteditpvMarch').value;
                var CostCenterBudgetpveditMarch=document.getElementById('CostCenterBudgetpveditMarch').value;
                
                var hiddenthisyearbudgeteditpvApril=document.getElementById('hiddenthisyearbudgeteditpvApril').value;
                var CostCenterBudgetpveditApril=document.getElementById('CostCenterBudgetpveditApril').value;
                
                var hiddenthisyearbudgeteditpvMay=document.getElementById('hiddenthisyearbudgeteditpvMay').value;
                var CostCenterBudgetpveditMay=document.getElementById('CostCenterBudgetpveditMay').value;
                
                var hiddenthisyearbudgeteditpvJune=document.getElementById('hiddenthisyearbudgeteditpvJune').value;
                var CostCenterBudgetpveditJune=document.getElementById('CostCenterBudgetpveditJune').value;
                
                var hiddenthisyearbudgeteditpvJuly=document.getElementById('hiddenthisyearbudgeteditpvJuly').value;
                var CostCenterBudgetpveditJuly=document.getElementById('CostCenterBudgetpveditJuly').value;
                
                var hiddenthisyearbudgeteditpvAugust=document.getElementById('hiddenthisyearbudgeteditpvAugust').value;
                var CostCenterBudgetpveditAugust=document.getElementById('CostCenterBudgetpveditAugust').value;
                
                var hiddenthisyearbudgeteditpvSeptember=document.getElementById('hiddenthisyearbudgeteditpvSeptember').value;
                var CostCenterBudgetpveditSeptember=document.getElementById('CostCenterBudgetpveditSeptember').value;
                
                var hiddenthisyearbudgeteditpvOctober=document.getElementById('hiddenthisyearbudgeteditpvOctober').value;
                var CostCenterBudgetpveditOctober=document.getElementById('CostCenterBudgetpveditOctober').value;
                
                var hiddenthisyearbudgeteditpvNovember=document.getElementById('hiddenthisyearbudgeteditpvNovember').value;
                var CostCenterBudgetpveditNovember=document.getElementById('CostCenterBudgetpveditNovember').value;
                
                var hiddenthisyearbudgeteditpvDecember=document.getElementById('hiddenthisyearbudgeteditpvDecember').value;
                var CostCenterBudgetQQedit=document.getElementById('CostCenterBudgetQQedit').value;
                var hiddenthisyearbudgeteditQQ=document.getElementById('hiddenthisyearbudgeteditQQ').value;
                
                var CostCenterBudgetpveditDecember=document.getElementById('CostCenterBudgetpveditDecember').value;
                var hiddenthisyearbudgeteditpvarray = new Array("", "", "",hiddenthisyearbudgeteditpvMarch,hiddenthisyearbudgeteditpvApril,hiddenthisyearbudgeteditpvMay,hiddenthisyearbudgeteditpvJune,hiddenthisyearbudgeteditpvJuly,hiddenthisyearbudgeteditpvAugust,hiddenthisyearbudgeteditpvSeptember,hiddenthisyearbudgeteditpvOctober,hiddenthisyearbudgeteditpvNovember,hiddenthisyearbudgeteditpvDecember);
                var CostCenterBudgetpveditarray = new Array("", "", "",CostCenterBudgetpveditMarch,CostCenterBudgetpveditApril,CostCenterBudgetpveditMay,CostCenterBudgetpveditJune,CostCenterBudgetpveditJuly,CostCenterBudgetpveditAugust,CostCenterBudgetpveditSeptember,CostCenterBudgetpveditOctober,CostCenterBudgetpveditNovember,CostCenterBudgetpveditDecember);
                var UseBidEdit="No";
                if($('#UseBidedit').is(":checked")){
                    UseBidEdit="Yes";
                }
                if(Type_Code==Category_Code+"-"){
                    alert('Enter Category Code');
                }else{
                    if(CostCenterCategory!=""){
                        $.ajax({
                        type: 'POST',
                        url: 'SetCostCenterEdit',                
                        data: {hiddenthisyearbudgeteditQQ:hiddenthisyearbudgeteditQQ,CostCenterBudgetQQedit:CostCenterBudgetQQedit,UseBidEdit:UseBidEdit,CostCenterBudgetpveditarray:CostCenterBudgetpveditarray,hiddenthisyearbudgeteditpvarray:hiddenthisyearbudgeteditpvarray,hiddenthisyearbudgetedit:hiddenthisyearbudgetedit,hiddenthisyearbudgeteditpv:hiddenthisyearbudgeteditpv,CostCenterBudgetedit:CostCenterBudgetedit,CostCenterBudgetpvedit:CostCenterBudgetpvedit,no:no,CostCenterTypeName:CostCenterTypeName,Type_Code:Type_Code,Category_Code:Category_Code,CostCenterType:CostCenterType,CostCenterCategory:CostCenterCategory,_token: '{{csrf_token()}}'},
                        success: function(data) {
                           location.reload();
                        },
                        error: function(jqXHR, exception){
                        alert(jqXHR.responseText);
                        }											 
                        });
                    }else{
                        alert('Enter Category');
                    }
                }
                
            }
            function CheckCatCodeEdit(){
                var e=document.getElementById('CostCenterCategoryCodeEdit').value;
                var no=document.getElementById('CostCenterHiddenNoEdit').value;
                
                $.ajax({
                type: 'POST',
                url: 'GetCodeCostCenterEdit',                
                data: {no:no,type_code:e,_token: '{{csrf_token()}}'},
                success: function(data) {
                    if(data==0){
                        document.getElementById('SaveCostCenterButtonEdit').disabled=false;
                        document.getElementById('SaveCostCenterButtonEdit').title='';
                        document.getElementById('CostCenterCategoryCodeEdit').style.borderColor="Green";
                    }
                    else if(data==1){
                        document.getElementById('SaveCostCenterButtonEdit').disabled=true;
                        document.getElementById('SaveCostCenterButtonEdit').title='Duplicate Category';
                        document.getElementById('CostCenterCategoryCodeEdit').style.borderColor="Red";

                    }
                },
                error: function(jqXHR, exception){
                alert(jqXHR.responseText);
                }											 
                });
            }
        </script>
        <select class="form-control form-control-sm chosen-select" id="CostCenterTypeEdit" onchange="SetCodeEdit(this)">
        <option value="">--Select Cost Center--</option>
        
        @foreach ($CC_Types_list as $cost_centers)
            <option value="{{$cost_centers->cc_code}}">{{$cost_centers->cc_type}}</option>
        @endforeach
        </select>
        </div>
        <div class="col-md-4">
            <input type="hidden" id="CostCenterTypeNameEdit">
            <input type="hidden" id="CostCenterHiddenNoEdit">
            <input type="text" id="CostCenterCodePreviewEdit" readonly class="form-control form-control-sm">
        </div>

        <div class="col-md-8" style="margin-top:10px;">
            <p>Cost Center Category</p>
        </div>
        <div class="col-md-4" style="margin-top:10px;">
            <p>Code</p>
        </div>
        <div class="col-md-8">
            <input type="text" id="CostCenterCategoryEdit" class="form-control form-control-sm">
        </div>
        <div class="col-md-4">
            <input type="text" onkeyup="CheckCatCodeEdit()" id="CostCenterCategoryCodeEdit" class="form-control form-control-sm" >
        </div>
        <div class="col-md-12" style="margin-top:10px;display:none;" > 
            <div class="form-check form-check-inline" style="display:none;">
            <input onclick="checkcheckboxbidedit()" class="form-check-input" type="checkbox" id="UseBidedit" value="Yes" checked>
            <label class="form-check-label" for="UseBidedit">Use Bid of Quotation</label>
            </div>
            <script>
                $(document).ready(function(){
                    checkcheckboxbidedit();
                })
                function checkcheckboxbidedit(){
                    if($('#UseBidedit').is(":checked")){
                        document.getElementById('MonthsDivBVudgetedit').style.display="none";
                        //document.getElementById('QuotationBudgetDivedit').style.display="inline";
                    }else{
                        //document.getElementById('MonthsDivBVudgetedit').style.display="inline";
                        document.getElementById('QuotationBudgetDivedit').style.display="none";
                    }
                   
                }
            </script>
        </div>
        <div id="QuotationBudgetDivedit" style="display:none;">
            <div class="col-md-12" style="margin-top:10px;">
            <p>Bid of Quotation</p>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetQQedit()" onchange="setLabelBudgetQQedit()" {{$user_position->position!="CEO"? 'readonly' : ''}} id="CostCenterBudgetQQedit" class="form-control form-control-sm" >
            </div>
            <div class="col-md-6"  style="text-align:right;">
                <script>
                    function setLabelBudgetQQedit(){
                        console.log("PHP "+number_format(document.getElementById('CostCenterBudgetQQedit').value,2));
                        document.getElementById('labelbudgetQQedit').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetQQedit').value,2);
                    }
                </script>
                <input type="hidden" id="hiddenthisyearbudgeteditQQ">
                <p id="labelbudgetQQedit">PHP 0.00</p>
            </div>
        </div>
        <div id="MonthsDivBVudgetedit" style="display:none;">
            <div class="col-md-12" style="margin-top:10px;">
                <p>Cost Center Budget</p>
            </div>
            <div class="col-md-12" style="margin-top:10px;">
                <p>January</p>
            </div>
            <div class="col-md-6">
                <input type="number" {{$user_position->position!="CEO"? 'readonly ' : ''}} step="0.01" placeholder="0.00" onkeyup="setLabelBudgetedit()" onchange="setLabelBudgetedit()" id="CostCenterBudgetedit" class="form-control form-control-sm" >
            </div>
            <div class="col-md-6"  style="text-align:right;">
                <input type="hidden" id="hiddenthisyearbudgetedit">
                <script>
                    function setLabelBudgetedit(){
                        document.getElementById('labelbudgetedit').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetedit').value,2);
                    }
                </script>
                <p id="labelbudgetedit">PHP 0.00</p>
            </div>
            
            <div class="col-md-12" style="margin-top:10px;">
                <p>February</p>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" {{$user_position->position!="CEO"? 'readonly' : ''}} placeholder="0.00" onkeyup="setLabelBudgetpvedit()" onchange="setLabelBudgetpvedit()" id="CostCenterBudgetpvedit" class="form-control form-control-sm" >
            </div>
            <div class="col-md-6" style="text-align:right;">
                    <input type="hidden" id="hiddenthisyearbudgeteditpv">
                <script>
                    function setLabelBudgetpvedit(){
                        document.getElementById('labelbudgetpvedit').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpvedit').value,2);
                    }
                </script>
                <p id="labelbudgetpvedit">PHP 0.00</p>
            </div>

            <div class="col-md-12" style="margin-top:10px;">
                <p>March</p>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" {{$user_position->position!="CEO"? 'readonly' : ''}} placeholder="0.00" onkeyup="setLabelBudgetpveditMarch()" onchange="setLabelBudgetpveditMarch()" id="CostCenterBudgetpveditMarch" class="form-control form-control-sm" >
            </div>
            <div class="col-md-6" style="text-align:right;">
                    <input type="hidden" id="hiddenthisyearbudgeteditpvMarch">
                <script>
                    function setLabelBudgetpveditMarch(){
                        document.getElementById('labelbudgetpveditMarch').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpveditMarch').value,2);
                    }
                </script>
                <p id="labelbudgetpveditMarch">PHP 0.00</p>
            </div>

            <div class="col-md-12" style="margin-top:10px;">
                <p>April</p>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" {{$user_position->position!="CEO"? 'readonly' : ''}} placeholder="0.00" onkeyup="setLabelBudgetpveditApril()" onchange="setLabelBudgetpveditApril()" id="CostCenterBudgetpveditApril" class="form-control form-control-sm" >
            </div>
            <div class="col-md-6" style="text-align:right;">
                    <input type="hidden" id="hiddenthisyearbudgeteditpvApril">
                <script>
                    function setLabelBudgetpveditApril(){
                        document.getElementById('labelbudgetpveditApril').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpveditApril').value,2);
                    }
                </script>
                <p id="labelbudgetpveditApril">PHP 0.00</p>
            </div>

            <div class="col-md-12" style="margin-top:10px;">
                <p>May</p>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" {{$user_position->position!="CEO"? 'readonly' : ''}} placeholder="0.00" onkeyup="setLabelBudgetpveditMay()" onchange="setLabelBudgetpveditMay()" id="CostCenterBudgetpveditMay" class="form-control form-control-sm" >
            </div>
            <div class="col-md-6" style="text-align:right;">
                    <input type="hidden" id="hiddenthisyearbudgeteditpvMay">
                <script>
                    function setLabelBudgetpveditMay(){
                        document.getElementById('labelbudgetpveditMay').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpveditMay').value,2);
                    }
                </script>
                <p id="labelbudgetpveditMay">PHP 0.00</p>
            </div>

            <div class="col-md-12" style="margin-top:10px;">
                <p>June</p>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" {{$user_position->position!="CEO"? 'readonly' : ''}} placeholder="0.00" onkeyup="setLabelBudgetpveditJune()" onchange="setLabelBudgetpveditJune()" id="CostCenterBudgetpveditJune" class="form-control form-control-sm" >
            </div>
            <div class="col-md-6" style="text-align:right;">
                    <input type="hidden" id="hiddenthisyearbudgeteditpvJune">
                <script>
                    function setLabelBudgetpveditJune(){
                        document.getElementById('labelbudgetpveditJune').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpveditJune').value,2);
                    }
                </script>
                <p id="labelbudgetpveditJune">PHP 0.00</p>
            </div>

            <div class="col-md-12" style="margin-top:10px;">
                <p>July</p>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" {{$user_position->position!="CEO"? 'readonly' : ''}} placeholder="0.00" onkeyup="setLabelBudgetpveditJuly()" onchange="setLabelBudgetpveditJuly()" id="CostCenterBudgetpveditJuly" class="form-control form-control-sm" >
            </div>
            <div class="col-md-6" style="text-align:right;">
                    <input type="hidden" id="hiddenthisyearbudgeteditpvJuly">
                <script>
                    function setLabelBudgetpveditJuly(){
                        document.getElementById('labelbudgetpveditJuly').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpveditJuly').value,2);
                    }
                </script>
                <p id="labelbudgetpveditJuly">PHP 0.00</p>
            </div>

            <div class="col-md-12" style="margin-top:10px;">
                <p>August</p>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" {{$user_position->position!="CEO"? 'readonly' : ''}} placeholder="0.00" onkeyup="setLabelBudgetpveditAugust()" onchange="setLabelBudgetpveditAugust()" id="CostCenterBudgetpveditAugust" class="form-control form-control-sm" >
            </div>
            <div class="col-md-6" style="text-align:right;">
                    <input type="hidden" id="hiddenthisyearbudgeteditpvAugust">
                <script>
                    function setLabelBudgetpveditAugust(){
                        document.getElementById('labelbudgetpveditAugust').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpveditAugust').value,2);
                    }
                </script>
                <p id="labelbudgetpveditAugust">PHP 0.00</p>
            </div>

            <div class="col-md-12" style="margin-top:10px;">
                <p>September</p>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" {{$user_position->position!="CEO"? 'readonly' : ''}} placeholder="0.00" onkeyup="setLabelBudgetpveditSeptember()" onchange="setLabelBudgetpveditSeptember()" id="CostCenterBudgetpveditSeptember" class="form-control form-control-sm" >
            </div>
            <div class="col-md-6" style="text-align:right;">
                    <input type="hidden" id="hiddenthisyearbudgeteditpvSeptember">
                <script>
                    function setLabelBudgetpveditSeptember(){
                        document.getElementById('labelbudgetpveditSeptember').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpveditSeptember').value,2);
                    }
                </script>
                <p id="labelbudgetpveditSeptember">PHP 0.00</p>
            </div>

            <div class="col-md-12" style="margin-top:10px;">
                <p>October</p>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" {{$user_position->position!="CEO"? 'readonly' : ''}} placeholder="0.00" onkeyup="setLabelBudgetpveditOctober()" onchange="setLabelBudgetpveditOctober()" id="CostCenterBudgetpveditOctober" class="form-control form-control-sm" >
            </div>
            <div class="col-md-6" style="text-align:right;">
                    <input type="hidden" id="hiddenthisyearbudgeteditpvOctober">
                <script>
                    function setLabelBudgetpveditOctober(){
                        document.getElementById('labelbudgetpveditOctober').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpveditOctober').value,2);
                    }
                </script>
                <p id="labelbudgetpveditOctober">PHP 0.00</p>
            </div>

            <div class="col-md-12" style="margin-top:10px;">
                <p>November</p>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" {{$user_position->position!="CEO"? 'readonly' : ''}} placeholder="0.00" onkeyup="setLabelBudgetpveditNovember()" onchange="setLabelBudgetpveditNovember()" id="CostCenterBudgetpveditNovember" class="form-control form-control-sm" >
            </div>
            <div class="col-md-6" style="text-align:right;">
                    <input type="hidden" id="hiddenthisyearbudgeteditpvNovember">
                <script>
                    function setLabelBudgetpveditNovember(){
                        document.getElementById('labelbudgetpveditNovember').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpveditNovember').value,2);
                    }
                </script>
                <p id="labelbudgetpveditNovember">PHP 0.00</p>
            </div>

            <div class="col-md-12" style="margin-top:10px;">
                <p>December</p>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" {{$user_position->position!="CEO"? 'readonly' : ''}} placeholder="0.00" onkeyup="setLabelBudgetpveditDecember()" onchange="setLabelBudgetpveditDecember()" id="CostCenterBudgetpveditDecember" class="form-control form-control-sm" >
            </div>
            
            <div class="col-md-6" style="text-align:right;">
                    <input type="hidden" id="hiddenthisyearbudgeteditpvDecember">
                <script>
                    function setLabelBudgetpveditDecember(){
                        document.getElementById('labelbudgetpveditDecember').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetpveditDecember').value,2);
                    }
                </script>
                <p id="labelbudgetpveditDecember">PHP 0.00</p>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="edit_modal_cost_center" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="SaveCostCenterButtonEdit" onclick="SaveCostCenterEdit()">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Cost Center Modal Edit End --> 
            </div>
            <div class="col-md-12 mb-5 mt-3 p-0">
                    <a class="btn btn-success" href="#" data-toggle="modal" id="costcenter_modal_open" data-target="#CostCenterModal">New Cost Center</a>
                    <a class="btn btn-success" href="#" data-toggle="modal" data-target="#ImportCCModal">Import Cost Center</a>
                    <a class="btn btn-success" href="#" data-toggle="modal" data-target="#ImportBIDOFQUOTATIONModal">Import Bid of Quotation</a>
                    
                </div>
            <script>
                function setEditValues(no,type_code,type,name_code,name,use_bid){
                    var txt;
                    var r = confirm("Are you sure you want to change this?\nAny Changes here will be subject for Approval");
                    if (r == true) {
                        document.getElementById('CostCenterModalLabelEdit').innerHTML="Edit "+name;
                        document.getElementById('CostCenterTypeEdit').value=type_code;
                        // $("#CostCenterTypeEdit").trigger("chosen:updated");
                        // $("#CostCenterTypeEdit").chosen({width: "95%"});
                    
                        document.getElementById('CostCenterTypeNameEdit').value=type;
                        document.getElementById('CostCenterCodePreviewEdit').value=type_code;
                        document.getElementById('CostCenterCategoryCodeEdit').value=name_code;
                        document.getElementById('CostCenterCategoryEdit').value=name;
                        document.getElementById('CostCenterHiddenNoEdit').value=no;

                        document.getElementById('hiddenthisyearbudgetedit').value='';
                        document.getElementById('CostCenterBudgetedit').value='0';
                        document.getElementById('labelbudgetedit').innerHTML="PHP "+"0.00";
                        document.getElementById('hiddenthisyearbudgeteditpv').value='';
                        document.getElementById('CostCenterBudgetpvedit').value='0';
                        document.getElementById('labelbudgetpvedit').innerHTML="PHP "+"0.00";
                        document.getElementById('hiddenthisyearbudgeteditpvMarch').value='';
                        document.getElementById('CostCenterBudgetpveditMarch').value='0';
                        document.getElementById('labelbudgetpveditMarch').innerHTML="PHP "+"0.00";
                        document.getElementById('hiddenthisyearbudgeteditpvApril').value='';
                        document.getElementById('CostCenterBudgetpveditApril').value='0';
                        document.getElementById('labelbudgetpveditApril').innerHTML="PHP "+"0.00";
                        document.getElementById('hiddenthisyearbudgeteditpvMay').value='';
                        document.getElementById('CostCenterBudgetpveditMay').value='0';
                        document.getElementById('labelbudgetpveditMay').innerHTML="PHP "+"0.00";
                        document.getElementById('hiddenthisyearbudgeteditpvJune').value='';
                        document.getElementById('CostCenterBudgetpveditJune').value='0';
                        document.getElementById('labelbudgetpveditJune').innerHTML="PHP "+"0.00";
                        document.getElementById('hiddenthisyearbudgeteditpvJuly').value='';
                        document.getElementById('CostCenterBudgetpveditJuly').value='0';
                        document.getElementById('labelbudgetpveditJuly').innerHTML="PHP "+"0.00";
                        document.getElementById('hiddenthisyearbudgeteditpvAugust').value='';
                        document.getElementById('CostCenterBudgetpveditAugust').value='0';
                        document.getElementById('labelbudgetpveditAugust').innerHTML="PHP "+"0.00";
                        document.getElementById('hiddenthisyearbudgeteditpvSeptember').value='';
                        document.getElementById('CostCenterBudgetpveditSeptember').value='0';
                        document.getElementById('labelbudgetpveditSeptember').innerHTML="PHP "+"0.00";
                        document.getElementById('hiddenthisyearbudgeteditpvOctober').value='';
                        document.getElementById('CostCenterBudgetpveditOctober').value='0';
                        document.getElementById('labelbudgetpveditOctober').innerHTML="PHP "+"0.00";
                        document.getElementById('hiddenthisyearbudgeteditpvNovember').value='';
                        document.getElementById('CostCenterBudgetpveditNovember').value='0';
                        document.getElementById('labelbudgetpveditNovember').innerHTML="PHP "+"0.00";
                        document.getElementById('hiddenthisyearbudgeteditpvDecember').value='';
                        document.getElementById('CostCenterBudgetpveditDecember').value='0';
                        document.getElementById('labelbudgetpveditDecember').innerHTML="PHP "+"0.00";
                        if(use_bid=="Yes"){
                            document.getElementById('UseBidedit').click();
                        }
                        @foreach($budgets as $b)
                        if('{{$b->budget_cost_center}}'==no && '{{$b->budget_bid_of_quotation}}'!=''){
                            
                            document.getElementById('hiddenthisyearbudgeteditQQ').value='{{$b->budget_no}}';
                            document.getElementById('CostCenterBudgetQQedit').value='{{$b->budget_bid_of_quotation}}';
                            document.getElementById('labelbudgetQQedit').innerHTML="PHP "+"{{number_format($b->budget_bid_of_quotation!=""? $b->budget_bid_of_quotation : '0.00',2)}}";
                        }
                        if('{{$b->budget_cost_center}}'==no && '{{$b->budget_year}}'=='{{date("Y")}}' && '{{$b->budget_month}}'=='1'){
                            
                            document.getElementById('hiddenthisyearbudgetedit').value='{{$b->budget_no}}';
                            document.getElementById('CostCenterBudgetedit').value='{{$b->budget_amount}}';
                            document.getElementById('labelbudgetedit').innerHTML="PHP "+"{{number_format($b->budget_amount!=""? $b->budget_amount : '0.00',2)}}";
                        }
                        if('{{$b->budget_cost_center}}'==no && '{{$b->budget_year}}'=='{{date("Y")}}' && '{{$b->budget_month}}'=='2'){
                            document.getElementById('hiddenthisyearbudgeteditpv').value='{{$b->budget_no}}';
                            document.getElementById('CostCenterBudgetpvedit').value='{{$b->budget_amount}}';
                            document.getElementById('labelbudgetpvedit').innerHTML="PHP "+"{{number_format($b->budget_amount!=""? $b->budget_amount : '0.00',2)}}";
                        }
                        if('{{$b->budget_cost_center}}'==no && '{{$b->budget_year}}'=='{{date("Y")}}' && '{{$b->budget_month}}'=='3'){
                            document.getElementById('hiddenthisyearbudgeteditpvMarch').value='{{$b->budget_no}}';
                            document.getElementById('CostCenterBudgetpveditMarch').value='{{$b->budget_amount}}';
                            document.getElementById('labelbudgetpveditMarch').innerHTML="PHP "+"{{number_format($b->budget_amount!=""? $b->budget_amount : '0.00',2)}}";
                        }
                        if('{{$b->budget_cost_center}}'==no && '{{$b->budget_year}}'=='{{date("Y")}}' && '{{$b->budget_month}}'=='4'){
                            document.getElementById('hiddenthisyearbudgeteditpvApril').value='{{$b->budget_no}}';
                            document.getElementById('CostCenterBudgetpveditApril').value='{{$b->budget_amount}}';
                            document.getElementById('labelbudgetpveditApril').innerHTML="PHP "+"{{number_format($b->budget_amount!=""? $b->budget_amount : '0.00',2)}}";
                        }
                        if('{{$b->budget_cost_center}}'==no && '{{$b->budget_year}}'=='{{date("Y")}}' && '{{$b->budget_month}}'=='5'){
                            document.getElementById('hiddenthisyearbudgeteditpvMay').value='{{$b->budget_no}}';
                            document.getElementById('CostCenterBudgetpveditMay').value='{{$b->budget_amount}}';
                            document.getElementById('labelbudgetpveditMay').innerHTML="PHP "+"{{number_format($b->budget_amount!=""? $b->budget_amount : '0.00',2)}}";
                        }
                        if('{{$b->budget_cost_center}}'==no && '{{$b->budget_year}}'=='{{date("Y")}}' && '{{$b->budget_month}}'=='6'){
                            document.getElementById('hiddenthisyearbudgeteditpvJune').value='{{$b->budget_no}}';
                            document.getElementById('CostCenterBudgetpveditJune').value='{{$b->budget_amount}}';
                            document.getElementById('labelbudgetpveditJune').innerHTML="PHP "+"{{number_format($b->budget_amount!=""? $b->budget_amount : '0.00',2)}}";
                        }
                        if('{{$b->budget_cost_center}}'==no && '{{$b->budget_year}}'=='{{date("Y")}}' && '{{$b->budget_month}}'=='7'){
                            document.getElementById('hiddenthisyearbudgeteditpvJuly').value='{{$b->budget_no}}';
                            document.getElementById('CostCenterBudgetpveditJuly').value='{{$b->budget_amount}}';
                            document.getElementById('labelbudgetpveditJuly').innerHTML="PHP "+"{{number_format($b->budget_amount!=""? $b->budget_amount : '0.00',2)}}";
                        }
                        if('{{$b->budget_cost_center}}'==no && '{{$b->budget_year}}'=='{{date("Y")}}' && '{{$b->budget_month}}'=='8'){
                            document.getElementById('hiddenthisyearbudgeteditpvAugust').value='{{$b->budget_no}}';
                            document.getElementById('CostCenterBudgetpveditAugust').value='{{$b->budget_amount}}';
                            document.getElementById('labelbudgetpveditAugust').innerHTML="PHP "+"{{number_format($b->budget_amount!=""? $b->budget_amount : '0.00',2)}}";
                        }
                        if('{{$b->budget_cost_center}}'==no && '{{$b->budget_year}}'=='{{date("Y")}}' && '{{$b->budget_month}}'=='9'){
                            document.getElementById('hiddenthisyearbudgeteditpvSeptember').value='{{$b->budget_no}}';
                            document.getElementById('CostCenterBudgetpveditSeptember').value='{{$b->budget_amount}}';
                            document.getElementById('labelbudgetpveditSeptember').innerHTML="PHP "+"{{number_format($b->budget_amount!=""? $b->budget_amount : '0.00',2)}}";
                        }
                        if('{{$b->budget_cost_center}}'==no && '{{$b->budget_year}}'=='{{date("Y")}}' && '{{$b->budget_month}}'=='10'){
                            document.getElementById('hiddenthisyearbudgeteditpvOctober').value='{{$b->budget_no}}';
                            document.getElementById('CostCenterBudgetpveditOctober').value='{{$b->budget_amount}}';
                            document.getElementById('labelbudgetpveditOctober').innerHTML="PHP "+"{{number_format($b->budget_amount!=""? $b->budget_amount : '0.00',2)}}";
                        }
                        if('{{$b->budget_cost_center}}'==no && '{{$b->budget_year}}'=='{{date("Y")}}' && '{{$b->budget_month}}'=='11'){
                            document.getElementById('hiddenthisyearbudgeteditpvNovember').value='{{$b->budget_no}}';
                            document.getElementById('CostCenterBudgetpveditNovember').value='{{$b->budget_amount}}';
                            document.getElementById('labelbudgetpveditNovember').innerHTML="PHP "+"{{number_format($b->budget_amount!=""? $b->budget_amount : '0.00',2)}}";
                        }
                        if('{{$b->budget_cost_center}}'==no && '{{$b->budget_year}}'=='{{date("Y")}}' && '{{$b->budget_month}}'=='12'){
                            document.getElementById('hiddenthisyearbudgeteditpvDecember').value='{{$b->budget_no}}';
                            document.getElementById('CostCenterBudgetpveditDecember').value='{{$b->budget_amount}}';
                            document.getElementById('labelbudgetpveditDecember').innerHTML="PHP "+"{{number_format($b->budget_amount!=""? $b->budget_amount : '0.00',2)}}";
                        }

                        @endforeach
                        document.getElementById('costcentereditmodal').click();
                    }
                    
                }
            </script>
            <button style="display:none;" id="costcentereditmodal" data-toggle="modal" data-target="#CostCenterModalEdit"></button>
            <div class="col-md-10">
                <div class="dropdown" style="margin-bottom:10px;">
                        <a class="btn btn-info dropdown-toggle btn-sm" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hide/Show Month Column
                        </a>
                        
                        <div class="dropdown-menu">
                        <form style="padding:1px 10px;">
                            <div class="form-group" >
                            <script>
                                function showhidemonthcolumn(e){
                                    
                                    if(e=="Hide All"){
                                        
                                        for(var c=5;c<=16;c++){
                                            console.log("value is "+e);
                                            var column = costcenterlisttable.column( c );
                                            column.visible( false );
                                        }
                                        
                                    }else if(e=="Show All"){
                                        for(var c=5;c<=16;c++){
                                            var column = costcenterlisttable.column( c );
                                            column.visible( true );
                                        }
                                    }
                                    else{
                                        var column = costcenterlisttable.column(e);
                                        column.visible( ! column.visible() ); 
                                    }
                                }
                            </script>
                            <select class="form-control chosen-select" onchange="showhidemonthcolumn(this.value)">
                                <option value="Hide All">Hide All</option>
                                <option value="Show All">Show All</option>
                                <option value="5">January</option>
                                <option value="6">February</option>
                                <option value="7">March</option>
                                <option value="8">April</option>
                                <option value="9">May</option>
                                <option value="10">June</option>                               
                                <option value="11">July</option>                               
                                <option value="12">August</option> 
                                <option value="13">September</option>
                                <option value="14">October</option>
                                <option value="15">November</option>
                                <option value="16">December</option>
                            </select>
                            
                            </div>
                            
                        </form>
                        </div>
                    </div>
            </div>
            <div class="col-md-2 pr-0">
                <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter Keyword.." value="{{$keyword}}" id="SearchFilterJournalEnties">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" onclick="currentcc_no_go()" title="Search Journal Entries" type="button"><span class="fa fa-search"></span></button>
                </div>
                </div>
            </div>
            <div class="col-md-12 mb-1 p-0">
                <div class=" table-responsive">

                    
                    <table id="costcenterlisttable" style="width:100%" class="table table-bordered table-responsive-md text-left font14" >
                        <thead>
                        <tr class="bg-ltgrey">
                            <th class="text-left" width="5%">#</th>
                            <th class="text-left" width="5%">Code</th>
                            <th class="text-left" width="10%">Type</th>
                            <th class="text-left" width="30%">Category</th>
                            <th class="text-left" width="10%">Budget (YTD)</th>
                            <th class="text-left" width="10%">January</th>
                            <th class="text-left" width="10%">February</th>
                            <th class="text-left" width="10%">March</th>
                            <th class="text-left" width="10%">April</th>
                            <th class="text-left" width="10%">May</th>
                            <th class="text-left" width="10%">June</th>
                            <th class="text-left" width="10%">July</th>
                            <th class="text-left" width="10%">August</th>
                            <th class="text-left" width="10%">September</th>
                            <th class="text-left" width="10%">October</th>
                            <th class="text-left" width="10%">November</th>
                            <th class="text-left" width="10%">December</th>

                            <th class="text-left" width="10%"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($CC_Type_GROUPPED as $center)
                            <?php
                            $cc_result=explode(" -- ",$center);
                            if(count($cc_result)<2){
                                $cc_type_code="";
                                $cc_type="";
                            }else{
                                $cc_type_code=$cc_result[0];
                                $cc_type=$cc_result[1];
                            }
                            
                            ?>
                            <tr>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;">{{$cc_type_code}}</td>
                                <td class="text-left" style="vertical-align:middle;">{{$cc_type}}</td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                                <td class="text-left" style="vertical-align:middle;"></td>
                            </tr>
                            @foreach ($CostCenter as $Cost)
                                @if($Cost->cc_type==$cc_type)
                                @if($Cost->cc_status=="1")
                                    <tr>
                                        <td class="text-right" style="vertical-align:middle;">{{$Cost->cc_no}}</td>
                                        <td class="text-right" style="vertical-align:middle;">{{$Cost->cc_name_code}}</td>
                                        <td class="text-left" style="vertical-align:middle;"><span style="display:none;">{{$Cost->cc_type}}</span></td>
                                        <td class="text-left" style="vertical-align:middle;">{{$Cost->cc_name}}</td>
                                        <td class="text-right" style="vertical-align:middle;{{$Cost->cc_use_quotation=="Yes"? 'color:#a2aedb;' : ''}}">
                                        <?php
                                            $totalYTDBudget=0;
                                        ?>
                                        <?php
                                        $Bid_OFQUOTATION=0;
                                        ?>
                                        @if ($Cost->cc_use_quotation=="Yes")
                                        @foreach ($budgets as $bud)
                                            @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_type=="Bid of Quotation")
                                            <?php
                                            $totalYTDBudget=$bud->budget_month;
                                            ?>
                                            
                                            @endif
                                        @endforeach 
                                        <?php
                                        $Bid_OFQUOTATION=$totalYTDBudget;
                                        ?>
                                        @else
                                        @foreach ($budgets as $bud)
                                            @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_year==date('Y'))
                                            <?php
                                            $totalYTDBudget+=$bud->m1;
                                            $totalYTDBudget+=$bud->m2;
                                            $totalYTDBudget+=$bud->m3;
                                            $totalYTDBudget+=$bud->m4;
                                            $totalYTDBudget+=$bud->m5;
                                            $totalYTDBudget+=$bud->m6;
                                            $totalYTDBudget+=$bud->m7;
                                            $totalYTDBudget+=$bud->m8;
                                            $totalYTDBudget+=$bud->m9;
                                            $totalYTDBudget+=$bud->m10;
                                            $totalYTDBudget+=$bud->m11;
                                            $totalYTDBudget+=$bud->m12;

                                            ?>
                                                
                                            @endif
                                        @endforeach
                                        @endif
                                        
                                        {{number_format($totalYTDBudget,2)}}
                                        </td>
                                        <td class="text-right" style="vertical-align:middle;">
                                            @if ($Cost->cc_use_quotation=="Yes")
                                        
                                            @else
                                            <?php
                                            $monthlybudget=0;
                                            ?>
                                            @foreach ($budgets as $bud)
                                                @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_year==date('Y'))
                                                <?php
                                                $monthlybudget+=$bud->m1;
                                                ?>
                                                @endif
                                            @endforeach
                                            {{number_format($monthlybudget,2)}}
                                            @endif
                                        </td>
                                        <td class="text-right" style="vertical-align:middle;">
                                            @if ($Cost->cc_use_quotation=="Yes")
                                        
                                            @else
                                            <?php
                                            $monthlybudget=0;
                                            ?>
                                            @foreach ($budgets as $bud)
                                                @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_year==date('Y'))
                                                <?php
                                                $monthlybudget+=$bud->m2;
                                                ?>
                                                @endif
                                            @endforeach
                                            {{number_format($monthlybudget,2)}}
                                            @endif
                                        </td>
                                        <td class="text-right" style="vertical-align:middle;">
                                                @if ($Cost->cc_use_quotation=="Yes")
                                        
                                                @else
                                                <?php
                                                $monthlybudget=0;
                                                ?>
                                                @foreach ($budgets as $bud)
                                                    @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_year==date('Y'))
                                                    <?php
                                                    $monthlybudget+=$bud->m3;
                                                    ?>
                                                    @endif
                                                @endforeach
                                                {{number_format($monthlybudget,2)}}
                                                @endif
                                        </td>
                                        <td class="text-right" style="vertical-align:middle;">
                                                @if ($Cost->cc_use_quotation=="Yes")
                                        
                                                @else
                                                <?php
                                                $monthlybudget=0;
                                                ?>
                                                @foreach ($budgets as $bud)
                                                    @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_year==date('Y'))
                                                    <?php
                                                    $monthlybudget+=$bud->m4;
                                                    ?>
                                                    @endif
                                                @endforeach
                                                {{number_format($monthlybudget,2)}}
                                                @endif
                                        </td>
                                        <td class="text-right" style="vertical-align:middle;">
                                                @if ($Cost->cc_use_quotation=="Yes")
                                        
                                                @else
                                                <?php
                                                $monthlybudget=0;
                                                ?>
                                                @foreach ($budgets as $bud)
                                                    @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_year==date('Y'))
                                                    <?php
                                                    $monthlybudget+=$bud->m5;
                                                    ?>
                                                    @endif
                                                @endforeach
                                                {{number_format($monthlybudget,2)}}
                                                @endif
                                        </td>
                                        <td class="text-right" style="vertical-align:middle;">
                                                @if ($Cost->cc_use_quotation=="Yes")
                                        
                                                @else
                                                <?php
                                                $monthlybudget=0;
                                                ?>
                                                @foreach ($budgets as $bud)
                                                    @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_year==date('Y'))
                                                    <?php
                                                    $monthlybudget+=$bud->m6;
                                                    ?>
                                                    @endif
                                                @endforeach
                                                {{number_format($monthlybudget,2)}}
                                                @endif
                                        </td>
                                        <td class="text-right" style="vertical-align:middle;">
                                                @if ($Cost->cc_use_quotation=="Yes")
                                        
                                                @else
                                                <?php
                                                $monthlybudget=0;
                                                ?>
                                                @foreach ($budgets as $bud)
                                                    @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_year==date('Y'))
                                                    <?php
                                                    $monthlybudget+=$bud->m7;
                                                    ?>
                                                    @endif
                                                @endforeach
                                                {{number_format($monthlybudget,2)}}
                                                @endif
                                        </td>
                                        <td class="text-right" style="vertical-align:middle;">
                                                @if ($Cost->cc_use_quotation=="Yes")
                                        
                                                @else
                                                <?php
                                                $monthlybudget=0;
                                                ?>
                                                @foreach ($budgets as $bud)
                                                    @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_year==date('Y'))
                                                    <?php
                                                    $monthlybudget+=$bud->m8;
                                                    ?>
                                                    @endif
                                                @endforeach
                                                {{number_format($monthlybudget,2)}}
                                                @endif
                                        </td>
                                        <td class="text-right" style="vertical-align:middle;">
                                                @if ($Cost->cc_use_quotation=="Yes")
                                        
                                                @else
                                                <?php
                                                $monthlybudget=0;
                                                ?>
                                                @foreach ($budgets as $bud)
                                                    @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_year==date('Y'))
                                                    <?php
                                                    $monthlybudget+=$bud->m9;
                                                    ?>
                                                    @endif
                                                @endforeach
                                                {{number_format($monthlybudget,2)}}
                                                @endif
                                        </td>
                                        <td class="text-right" style="vertical-align:middle;">
                                                @if ($Cost->cc_use_quotation=="Yes")
                                        
                                                @else
                                                <?php
                                                $monthlybudget=0;
                                                ?>
                                                @foreach ($budgets as $bud)
                                                    @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_year==date('Y'))
                                                    <?php
                                                    $monthlybudget+=$bud->m10;
                                                    ?>
                                                    @endif
                                                @endforeach
                                                {{number_format($monthlybudget,2)}}
                                                @endif
                                        </td>
                                        <td class="text-right" style="vertical-align:middle;">
                                            
                                                @if ($Cost->cc_use_quotation=="Yes")
                                        
                                                @else
                                                <?php
                                                $monthlybudget=0;
                                                ?>
                                                @foreach ($budgets as $bud)
                                                    @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_year==date('Y'))
                                                    <?php
                                                    $monthlybudget+=$bud->m11;
                                                    ?>
                                                    @endif
                                                @endforeach
                                                {{number_format($monthlybudget,2)}}
                                                @endif
                                        </td>
                                        <td class="text-right" style="vertical-align:middle;">
                                                @if ($Cost->cc_use_quotation=="Yes")
                                        
                                                @else
                                                <?php
                                                $monthlybudget=0;
                                                ?>
                                                @foreach ($budgets as $bud)
                                                    @if($bud->budget_cost_center==$Cost->cc_no && $bud->budget_year==date('Y'))
                                                    <?php
                                                    $monthlybudget+=$bud->m12;
                                                    ?>
                                                    @endif
                                                @endforeach
                                                {{number_format($monthlybudget,2)}}
                                                @endif
                                            
                                        </td>
                                        <td class="text-center" style="vertical-align:middle;text-align:center;">
                                            
                                                <div class="btn-group">
                                                    {{-- <button type="button" class="btn bg-transparent text-info">Accounts History</button> --}}
                                                    <button type="button" class="btn bg-transparent  px-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-custom">
                                                        
                                                        <a class="dropdown-item" href="GetBudgetTemplateExcel/?cc={{$Cost->cc_no}}">Download Monthly Budget Excel Template</a>
                                                        
                                                    
                                                        <a class="dropdown-item" href="#"  onclick="setBudgetID(this)" data-id="{{$Cost->cc_no}}" data-bid_amount="{{$Bid_OFQUOTATION}}" data-cc_type_code="{{$Cost->cc_type_code}}" data-cost_center="{{$Cost->cc_name}}" >Set/Update Budget</a>
                                                        <a class="dropdown-item" href="#" onclick="setEditValues('{{$Cost->cc_no}}','{{$Cost->cc_type_code}}','{{$Cost->cc_type}}','{{$Cost->cc_name_code}}','{{$Cost->cc_name}}','{{$Cost->cc_use_quotation}}')">Edit</a>
                                                        <form action="delete_cost_center" method="POST" onsubmit="return confirm('Are you sure you want to delete this?\nThis will be subject for approval')">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="hidden" name="cost_id" value="{{$Cost->cc_no}}">
                                                            <input type="hidden" name="active" value="0">
                                                            <input style="font-size:11px;" type="submit" class="dropdown-item btn-sm" value="Delete">
                                                        </form>
                                                        
                                                    </div>
                                                </div>
                                            
                                        </td>
                                    </tr>
                                
                                @endif
                                @endif
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
                <div class="col-md-12 pr-0 mb-4">
                        <div class="input-group" style="width: 15%;float: right;">
                        <div class="input-group-prepend">
                        <button type="button" onclick="back_currentcc_no_go()" class="btn btn-secondary" style="line-height:2"><span class="fa fa-angle-double-left"></span></button>
                        </div>
                        <input type="number" name="" id="currentjournal_no" onchange="currentcc_no_go()" value="{{$CC_Index+1}}" min="0" step="20" class="form-control" style="text-align:center;">
                        
                        <div class="input-group-append">
                            <button type="button" onclick="forward_currentcc_no_go()" class="btn btn-secondary" style="line-height:2"><span class="fa fa-angle-double-right"></span></button>
                        </div>
                        </div>
                        <script>
                            function forward_currentcc_no_go(){
                                var current_no="{{$CC_Index}}";
                                var keywordselected="{{$keyword}}";//Citi
                                var currentjournal_no="{{($CC_Index+20)+1}}";
                                var SearchFilterJournalEnties=document.getElementById('SearchFilterJournalEnties').value;//Globe
                                if(keywordselected!=SearchFilterJournalEnties){
                                    //different keyword
                                    window.location="cost_center?no={{($CC_Index+20)+1}}&keyword="+SearchFilterJournalEnties;
                                    
                                }else{
                                    if(current_no!=currentjournal_no && currentjournal_no!=""){
                                    window.location="cost_center?no="+currentjournal_no+"&keyword="+SearchFilterJournalEnties;
                                    }
                                }
                                
                            }
                            function back_currentcc_no_go(){
                                var current_no="{{$CC_Index}}";
                                var keywordselected="{{$keyword}}";//Citi
                                var currentjournal_no="{{$CC_Index-20>-1? ($CC_Index-20)+1 : 1}}";
                                var SearchFilterJournalEnties=document.getElementById('SearchFilterJournalEnties').value;//Globe
                                if(keywordselected!=SearchFilterJournalEnties){
                                    //different keyword
                                    window.location="cost_center?no={{$CC_Index-20>-1? ($CC_Index-20)+1 : 1}}&keyword="+SearchFilterJournalEnties;
                                    
                                }else{
                                    if(current_no!=currentjournal_no && currentjournal_no!=""){
                                    window.location="cost_center?no="+currentjournal_no+"&keyword="+SearchFilterJournalEnties;
                                    }
                                }
                                
                            }
                        function currentcc_no_go(){
                            var current_no="{{$CC_Index}}";
                            var keywordselected="{{$keyword}}";//Citi
                            var currentjournal_no=document.getElementById('currentjournal_no').value;
                            var SearchFilterJournalEnties=document.getElementById('SearchFilterJournalEnties').value;//Globe
                            if(keywordselected!=SearchFilterJournalEnties){
                                //different keyword
                                window.location="cost_center?no=1&keyword="+SearchFilterJournalEnties;
                                
                            }else{
                                if(current_no!=currentjournal_no && currentjournal_no!=""){
                                window.location="cost_center?no="+currentjournal_no+"&keyword="+SearchFilterJournalEnties;
                                }
                            }
                            
                        }
                        </script>
                </div>
            
        </div>
    </div>
</div>

<!--modals-->
<div class="modal fade" id="EditBudget" tabindex="-1" role="dialog" aria-labelledby="BudgetHeaderModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="BudgetHeaderModal">Set/Update Cost Center Budget</h5>
          <button type="button" class="close" id="budgermodalBTN" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="hidden" name="hiddenbudgetcc_no" id="hiddenbudgetcc_no">
                        <select id="my-select-budget" class="form-control" name="" onchange="changeUIbudgetModal()" style="display:none;">
                            <option>Monthly</option>
                            <option>Bid of Quotation</option>
                        </select>
                    </div>
                </div>
                <script>
                        function setBudgetID(e){
                            var question;
                            var r = confirm("Are You Sure you want to Change this?\nAny Changes here will be subject for Approval");
                            if (r == true) {
                                var id = e.getAttribute("data-id");
                                var cost_center=e.getAttribute('data-cost_center');
                                var bid_amount=e.getAttribute('data-bid_amount');
                                var cc_type_code=e.getAttribute('data-cc_type_code');
                                
                                var res = cc_type_code.substring(0, 2);
                                if(cc_type_code.substring(0, 2) == '05' || cc_type_code.substring(0, 2) == '03'){
                                    document.getElementById('my-select-budget').value="Bid of Quotation";
                                }else{
                                    document.getElementById('my-select-budget').value="Monthly";
                                }
                                changeUIbudgetModal();
                                document.getElementById('BudgetHeaderModal').innerHTML="Set/Update "+cost_center+" Budget";
                                document.getElementById('hiddenbudgetcc_no').value=id;
                                document.getElementById('CostCenterBudgetQQ2').value=bid_amount;
                                setLabelBudgetQQ2();
                                open_modal_dyna('EditBudget');
                            } else {
                                alert('Action Cancelled');
                               
                            }
                            
                        }
                    </script>
                <script>
                    function changeUIbudgetModal(){
                        
                        if(document.getElementById('my-select-budget').value=="Monthly"){
                            document.getElementById('montlyimportbudgetmodal').style.display="inline";
                            document.getElementById('BidOfQuotationDivBudgetModal').style.display="none";
                        }
                        else if(document.getElementById('my-select-budget').value=="Bid of Quotation"){
                            document.getElementById('montlyimportbudgetmodal').style.display="none";
                            document.getElementById('BidOfQuotationDivBudgetModal').style.display="inline";
                        }
                    }
                    function UploadMassBudget(){
                        document.getElementById('import_overlay').style.display="block";
                        var ids=document.getElementById('hiddenbudgetcc_no').value;
                        var file = $('#excel-upload-budget')[0].files[0]
                        var fd = new FormData();
                        fd.append('theFile', file);
                        fd.append('ids', ids);
                        fd.append('_token','{{csrf_token()}}');
                        $.ajax({
                            url: 'UploadMassBudget',
                            type: 'POST',
                            processData: false,
                            contentType: false,
                            data: fd,
                            dataType:"json",
                            success: function (data, status, jqxhr) {
                            //document.getElementById('importlogsss').innerHTML=data.Extra;
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
                            document.getElementById('import_overlay').style.display="none";
                            alert(jqxhr.responseText);
                            }
                        });
                        document.getElementById("excel-upload-budget").value = "";
                        //location.reload();
                    }
                </script>
                <div class="col-md-12" style="text-align:center;" id="montlyimportbudgetmodal">
                    <style>
                    #excel-upload-budget{
                        display: none;
                    }
                    </style>
                    <input id="excel-upload-budget" type="file" onchange="UploadMassBudget()"   accept=".xlsx" >
                    <label for="excel-upload-budget" style="opacity:1;cursor:pointer;border-radius:10px;" id="FileImportforBudget" class="custom-excel-upload btn btn-primary">
                    <span class="glyphicon glyphicon-user"></span> IMPORT BUDGET FROM EXCEL</span>
                    </label>
                </div>
                <div class="col-md-12" id="BidOfQuotationDivBudgetModal" style="display:none;">
                    <div class="col-md-12" style="margin-top:10px;">
                    <p>Bid of Quotation</p>
                    </div>
                    <div class="col-md-6">
                        <input type="number" step="0.01" placeholder="0.00" onkeyup="setLabelBudgetQQ2()" onchange="setLabelBudgetQQ2()" id="CostCenterBudgetQQ2" class="form-control form-control-sm" >
                    </div>
                    <div class="col-md-6"  style="text-align:right;">
                        <script>
                            function setLabelBudgetQQ2(){
                                console.log("PHP "+number_format(document.getElementById('CostCenterBudgetQQ2').value,2));
                                document.getElementById('labelbudgetQQ2').innerHTML="PHP "+number_format(document.getElementById('CostCenterBudgetQQ2').value,2);
                            }
                        </script>
                        <p id="labelbudgetQQ2">PHP 0.00</p>
                    </div>
                    <div class="col-md-12" style="text-align:right;margin-top:10px;">
                        <button onclick="saveQuotationBudget()" class="btn btn-primary">Save</button>
                        
                    </div>
                    <script>
                        function saveQuotationBudget(){
                            var budget=document.getElementById('CostCenterBudgetQQ2').value;
                            var cost_center=document.getElementById('hiddenbudgetcc_no').value;
                            $.ajax({
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ route('update_bid_of_quotation') }}',                
                            data: {cost_center:cost_center,budget:budget,_token: '{{csrf_token()}}'},
                            success: function(data) {
                            
                                swal({title: "Done!", text: "Added Budget.", type: 
                                    "success"}).then(function(){ 
                                    location.reload();
                                });
                            },
                            error: function (data) {
                                alert(data.responseText);
                                swal("Error!", "Invoice failed", "error");
                            }  

                            })
                        }
                    </script>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          
        </div>
      </div>
    </div>
  </div>
@endsection