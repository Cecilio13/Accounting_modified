@extends('layout.initial')

@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Pending Approval</h1>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#myTabApprovals a:eq(0)").click();
        })
    </script>
</div>
    <?php
    $pendingapprovals=0;
    ?>
    @foreach ($BankEdits as $item)
        @if ($item->edit_status=="0")
        <?php
        $pendingapprovals++;
        ?>
        @endif
    @endforeach
    <?php
    $pendingapprovals1=0;
    ?>
    @foreach ($CostCenterEdit as $item)
        @if ($item->edit_status=="0")
        <?php
        $pendingapprovals1++;
        ?>
        @endif
    @endforeach
    <?php
    $pendingapprovals12=0;
    ?>
    @foreach ($COAEdits as $item)
        @if ($item->edit_status=="0")
        <?php
        $pendingapprovals12++;
        ?>
        @endif
    @endforeach
    <?php
    $pendingapprovals123=0;
    ?>
    @foreach ($ProductAndServicesEdit as $item)
        @if ($item->edit_status=="0")
        <?php
        $pendingapprovals123++;
        ?>
        @endif
    @endforeach
    <?php
    $pendingapprovals1234=0;
    ?>
    @foreach ($CustomerEdit as $item)
        @if ($item->edit_status=="0" && $item->account_type=="Customer")
        <?php
        $pendingapprovals1234++;
        ?>
        @endif
    @endforeach
    <?php
    $pendingapprovals1234123123=0;
    ?>
    @foreach ($CustomerEdit as $item)
        @if ($item->edit_status=="0" && $item->account_type=="Supplier")
        <?php
        $pendingapprovals1234123123++;
        ?>
        @endif
    @endforeach
    <?php
    $pendingapprovals12345=0;
    ?>
    @foreach ($SalesTransactionEdit as $item)
        @if ($item->edit_status=="0")
        <?php
        $pendingapprovals12345++;
        ?>
        @endif
    @endforeach
    <?php
    $pendingapprovals123456=0;
    ?>
    @foreach ($ExpenseTransactionEdit as $item)
        @if ($item->edit_status=="0")
        <?php
        $pendingapprovals123456++;
        ?>
        @endif
    @endforeach
    <?php
    $pednignbillcount=0;
    ?>
    @foreach ($EXNew as $EXn)
    <?php
    $pednignbillcount++;
    ?>
    @endforeach
    <?php
    $pending_budget_count=0;
    ?>
    @foreach ($BudgetsEdit as $budgggettt)
    @if ($budgggettt->edit_status!="1")
    <?php
    $pending_budget_count++;
    ?>   
    @endif
    
    @endforeach
<div class="card-body">
    <ul class="nav nav-tabs" id="myTabApprovals" role="tablist">
        @if ($UserAccessList[0]->approval_pending_bills=="1")
        <li class="nav-item">
            <a class="nav-link" id="pending_bill_tab-tab" data-toggle="tab" href="#pending_bill_tab" role="tab" aria-controls="profile" aria-selected="false">Pending Bill <span style="border-radius:10rem;{{$pednignbillcount>0? ''  : 'display:none;'}}" class="badge badge-pill badge-danger">{{$pednignbillcount}}</span></a>
        </li>
        @endif
        @if ($UserAccessList[0]->approval_bank=="1")
        <li class="nav-item">
            <a class="nav-link " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Bank <span style="border-radius:10rem;{{$pendingapprovals>0? ''  : 'display:none;'}}" class="badge badge-pill badge-danger">{{$pendingapprovals}}</span></a>
        </li>
        @endif
        @if ($UserAccessList[0]->approval_coa=="1")
        <li class="nav-item">
            <a class="nav-link" id="coa_tab-tab" data-toggle="tab" href="#coa_tab" role="tab" aria-controls="profile" aria-selected="false">Chart of Accounts <span style="border-radius:10rem;{{$pendingapprovals12>0? ''  : 'display:none;'}}" class="badge badge-pill badge-danger">{{$pendingapprovals12}}</span></a>
        </li>
        @endif
        @if ($UserAccessList[0]->approval_cc=="1")
        <li class="nav-item">
            <a class="nav-link" id="cc_tab-tab" data-toggle="tab" href="#cc_tab" role="tab" aria-controls="profile" aria-selected="false">Cost Center <span style="border-radius:10rem;{{$pendingapprovals1>0? ''  : 'display:none;'}}" class="badge badge-pill badge-danger">{{$pendingapprovals1}}</span></a>
        </li>
        @endif
        @if ($UserAccessList[0]->approval_customer=="1")
        <li class="nav-item">
            <a class="nav-link" id="customer_tab-tab" data-toggle="tab" href="#customer_tab" role="tab" aria-controls="profile" aria-selected="false">Customer <span style="border-radius:10rem;{{$pendingapprovals1234>0? ''  : 'display:none;'}}" class="badge badge-pill badge-danger">{{$pendingapprovals1234}}</span></a>
        </li>
        @endif
        @if ($UserAccessList[0]->approval_supplier=="1")
        <li class="nav-item">
            <a class="nav-link" id="supplier_tab-tab" data-toggle="tab" href="#supplier_tab" role="tab" aria-controls="profile" aria-selected="false">Supplier <span style="border-radius:10rem;{{$pendingapprovals1234123123>0? ''  : 'display:none;'}}" class="badge badge-pill badge-danger">{{$pendingapprovals1234123123}}</span></a>
        </li>
        @endif
        @if ($UserAccessList[0]->approval_product_services=="1")
        <li class="nav-item">
            <a class="nav-link" id="product_tab-tab" data-toggle="tab" href="#product_tab" role="tab" aria-controls="profile" aria-selected="false">Products and Services <span style="border-radius:10rem;{{$pendingapprovals123>0? ''  : 'display:none;'}}" class="badge badge-pill badge-danger">{{$pendingapprovals123}}</span></a>
        </li>
        @endif
        @if ($UserAccessList[0]->approval_sales=="1")
        <li class="nav-item">
            <a class="nav-link" id="sales_tab-tab" data-toggle="tab" href="#sales_tab" role="tab" aria-controls="profile" aria-selected="false">Sales Transaction <span style="border-radius:10rem;{{$pendingapprovals12345>0? ''  : 'display:none;'}}" class="badge badge-pill badge-danger">{{$pendingapprovals12345}}</span></a>
        </li>
        @endif
        @if ($UserAccessList[0]->approval_expense=="1")
        <li class="nav-item">
            <a class="nav-link" id="expense_transaction_tab-tab" data-toggle="tab" href="#expense_transaction_tab" role="tab" aria-controls="profile" aria-selected="false">Expense Transaction <span style="border-radius:10rem;{{$pendingapprovals123456>0? ''  : 'display:none;'}}" class="badge badge-pill badge-danger">{{$pendingapprovals123456}}</span></a>
        </li>
        @endif
        @if ($UserAccessList[0]->approval_boq=="1")
        <li class="nav-item">
            <a class="nav-link" id="bid_of_quotation_tab-tab" data-toggle="tab" href="#bid_of_quotation_tab" role="tab" aria-controls="profile" aria-selected="false">Bid of Quotation <span style="border-radius:10rem;{{$pending_budget_count>0? ''  : 'display:none;'}}" class="badge badge-pill badge-danger">{{$pending_budget_count}}</span></a>
        </li>
        @endif  
    </ul>
    <div class="tab-content pl-3 p-1" id="myTabContent">
        @if ($UserAccessList[0]->approval_bank=="1")
        <div class="tab-pane fade show " id="home" role="tabpanel" aria-labelledby="home-tab">
            <h3 class="float-left">Bank</h3>

            <div class="col-md-12 pl-0 pr-0 mt-3">
                <table class="table table-bordered" style="background-color:white;" id="table_bank_approval">
                    <thead class="thead-dark">
                        <tr>
                            <th style="vertical-align:middle;">Bank No</th>
                            <th style="vertical-align:middle;">Bank Name</th>
                            <th style="vertical-align:middle;">Bank Branch</th>
                            <th style="vertical-align:middle;">Bank Code</th>
                            <th style="vertical-align:middle;">Bank Account No</th>
                            <th style="vertical-align:middle;">Bank Remark</th>
                            <th style="vertical-align:middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($BankEdits as $b)
                           @if ($b->edit_status=="0")
                                <tr>
                                    <td style="vertical-align:middle;">{{$b->bank_no}}</td>
                                    <td style="vertical-align:middle;">{{$b->bank_name}}</td>
                                    <td style="vertical-align:middle;">{{$b->bank_branch}}</td>
                                    <td style="vertical-align:middle;">{{$b->bank_code}}</td>
                                    <td style="vertical-align:middle;">{{$b->bank_account_no}}</td>
                                    <td style="vertical-align:middle;">{{$b->bank_remark}}</td>
                                    <td style="vertical-align:middle;text-align:center;">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="">
                                        <button title="Approve" onclick="approveBankRequest('{{$b->bank_no}}')" type="button" class="btn btn-success"><span class="fa fa-check"></span></button>
                                        <button type="button" onclick="denyBankRequest('{{$b->bank_no}}')" title="Deny" class="btn btn-danger"><span class="fa fa-times"></span></button>
                                        </div>
                                    </td>
                                </tr>
                           @endif 
                        @endforeach
                        <script>
                            var table_bank_approval;
                            $(document).ready(function(){
                                if(document.getElementById('table_bank_approval')){
                                    table_bank_approval = $('#table_bank_approval').DataTable({
                                    order: [[ 0, "desc" ]],
                                    
                                    });
                                }
                            });
                            function approveBankRequest(id){
                                $.ajax({
                                        type: 'POST',
                                        url: 'update_bank_edit',                
                                        data: {_token: '{{csrf_token()}}',id:id},
                                        success: function(data) {
                                            swal({title: "Done!", text: "Bank Changes Approved", type: 
                                                "success"}).then(function(){ 
                                                location.reload();
                                            });
                                        } 											 
                                        });
                            }
                            function denyBankRequest(id){
                                $.ajax({
                                        type: 'POST',
                                        url: 'delete_bank_edit',                
                                        data: {_token: '{{csrf_token()}}',id:id},
                                        success: function(data) {
                                            swal({title: "Done!", text: "Pending Bank Changes Denied", type: 
                                                "success"}).then(function(){ 
                                                location.reload();
                                            });
                                        } 											 
                                        });
                            }
                        </script>
                    </tbody>
                    
                </table>
            </div>
        </div>
        @endif
<!-- ======================================================================================================== SECOND TAB--> 
        @if ($UserAccessList[0]->approval_coa=="1")
        <div class="tab-pane fade show" id="coa_tab" role="tabpanel" aria-labelledby="coa_tab-tab">
            <h3 class="mt-2">Chart of Accounts</h3>

            <div class="col-md-12 pl-0 pr-0 mt-3">
                <table class="table table-bordered" style="background-color:white;" id="table_coa_approval">
                    <thead class="thead-dark">
                        <tr>
                            <th style="vertical-align:middle;">ID</th>
                            <th style="vertical-align:middle;">Account Classification</th>
                            <th style="vertical-align:middle;">Account Type</th>
                            <th style="vertical-align:middle;">Account Title</th>
                            <th style="vertical-align:middle;">Account Code</th>
                            <th width="40%" style="vertical-align:middle;">Description</th>
                            <th style="vertical-align:middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($COAEdits as $accountsss)
                        @if ($accountsss->edit_status=="0")
                        <tr>
                            <td style="vertical-align:middle;">{{$accountsss->id}}</td>
                            <td style="vertical-align:middle;">{{$accountsss->coa_title}}</td>
                            <td style="vertical-align:middle;">{{$accountsss->coa_account_type}}</td>
                            <td style="vertical-align:middle;">{{$accountsss->coa_detail_type}}</td>
                            <td style="vertical-align:middle;text-align:center;">{{$accountsss->coa_code}}</td>
                            <td style="vertical-align:middle;">{{$accountsss->coa_description}}</td>
                            <td style="vertical-align:middle;text-align:center;">
                                <div class="btn-group btn-group-sm" role="group" aria-label="">
                                    <button title="Approve" onclick="approveCOARequest('{{$accountsss->id}}')" type="button" class="btn btn-success"><span class="fa fa-check"></span></button>
                                    <button type="button" onclick="denyCOARequest('{{$accountsss->id}}')"  title="Deny" class="btn btn-danger"><span class="fa fa-times"></span></button>
                                </div>
                            </td>
                        </tr>   
                        @endif
                        @endforeach
                        <script>
                            var table_coa_approval;
                            $(document).ready(function(){
                                if(document.getElementById('table_coa_approval')){
                                    table_coa_approval = $('#table_coa_approval').DataTable({
                                    order: [[ 0, "desc" ]],
                                    
                                    });
                                }
                            });
                            function approveCOARequest(id){
                                $.ajax({
                                        type: 'POST',
                                        url: 'update_COA_edit',                
                                        data: {_token: '{{csrf_token()}}',id:id},
                                        success: function(data) {
                                            swal({title: "Done!", text: "Chart of Account Changes Approved", type: 
                                                "success"}).then(function(){ 
                                                location.reload();
                                            });
                                        } 											 
                                        });
                            }
                            function denyCOARequest(id){
                                $.ajax({
                                        type: 'POST',
                                        url: 'delete_COA_edit',                
                                        data: {_token: '{{csrf_token()}}',id:id},
                                        success: function(data) {
                                            swal({title: "Done!", text: "Pending Chart of Account Changes Denied", type: 
                                                "success"}).then(function(){ 
                                                location.reload();
                                            });
                                        } 											 
                                        });
                            }
                        </script>
                    </tbody>
                    
                </table>
            </div>
        </div>
        @endif
        @if ($UserAccessList[0]->approval_cc=="1")
        <div class="tab-pane fade show" id="cc_tab" role="tabpanel" aria-labelledby="cc_tab-tab">
            <h3 class="mt-2">Cost Center</h3>

            <div class="col-md-12 pl-0 pr-0 mt-3">
                <table class="table table-bordered" style="background-color:white;" id="table_cc_approval">
                    <thead class="thead-dark">
                        <tr>
                            <th style="vertical-align:middle;">#</th>
                            <th style="vertical-align:middle;">Code</th>
                            <th style="vertical-align:middle;">Type</th>
                            <th style="vertical-align:middle;">Category</th>
                            <th style="vertical-align:middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($CostCenterEdit as $css)
                        @if ($css->edit_status=="0")
                            <tr>
                                <td style="vertical-align:middle;">{{$css->cc_no}}</td>
                                <td style="vertical-align:middle;">{{$css->cc_name_code}}</td>
                                <td style="vertical-align:middle;">{{$css->cc_type." (".$css->cc_type_code.")"}}</td>
                                <td style="vertical-align:middle;">{{$css->cc_name}}</td>
                                <td style="vertical-align:middle;text-align:center;">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="">
                                        <button title="Approve" onclick="approveCCRequest('{{$css->cc_no}}')" type="button" class="btn btn-success"><span class="fa fa-check"></span></button>
                                        <button type="button" onclick="denyCCRequest('{{$css->cc_no}}')"  title="Deny" class="btn btn-danger"><span class="fa fa-times"></span></button>
                                    </div>
                                </td>
                            </tr> 
                        @endif 
                        @endforeach
                        <script>
                                var table_cc_approval;
                                $(document).ready(function(){
                                    if(document.getElementById('table_cc_approval')){
                                        table_cc_approval = $('#table_cc_approval').DataTable({
                                        order: [[ 0, "desc" ]],
                                        
                                        });
                                    }
                                });
                                function approveCCRequest(id){
                                    $.ajax({
                                            type: 'POST',
                                            url: 'update_CC_edit',                
                                            data: {_token: '{{csrf_token()}}',id:id},
                                            success: function(data) {
                                                //console.log(data);
                                                swal({title: "Done!", text: "Cost Center Changes Approved", type: 
                                                    "success"}).then(function(){ 
                                                    location.reload();
                                                });
                                            } 											 
                                            });
                                }
                                function denyCCRequest(id){
                                    $.ajax({
                                            type: 'POST',
                                            url: 'delete_CC_edit',                
                                            data: {_token: '{{csrf_token()}}',id:id},
                                            success: function(data) {
                                                swal({title: "Done!", text: "Pending Cost Center Changes Denied", type: 
                                                    "success"}).then(function(){ 
                                                    location.reload();
                                                });
                                            } 											 
                                            });
                                }
                            </script>
                    </tbody>
                    
                </table>
            </div>
        </div>
        @endif
        @if ($UserAccessList[0]->approval_customer=="1")
        <div class="tab-pane fade show" id="customer_tab" role="tabpanel" aria-labelledby="customer_tab-tab">
            <h3 class="mt-2">Customer</h3>

            <div class="col-md-12 pl-0 pr-0 mt-3">
                <table class="table table-bordered" style="background-color:white;" id="table_customer_approval">
                    <thead class="thead-dark">
                        <tr>
                            <th style="vertical-align:middle;">Customer ID</th>
                            <th style="vertical-align:middle;">Name</th>
                            <th style="vertical-align:middle;">Company</th>
                            <th style="vertical-align:middle;">Display Name</th>
                            <th style="vertical-align:middle;">Email</th>
                            <th style="vertical-align:middle;">Phone</th>
                            <th style="vertical-align:middle;">Address</th>
                            <th style="vertical-align:middle;">TIN No.</th>
                            <th style="vertical-align:middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($CustomerEdit as $cut)
                            @if ($cut->edit_status=="0" && $cut->account_type=="Customer")
                                <tr>
                                    <td style="vertical-align:middle;">{{$cut->customer_id}}</td>
                                    <td style="vertical-align:middle;">{{$cut->f_name." ".$cut->l_name}}</td>
                                    <td style="vertical-align:middle;">{{$cut->company}}</td>
                                    <td style="vertical-align:middle;">{{$cut->display_name}}</td>
                                    <td style="vertical-align:middle;">{{$cut->email}}</td>
                                    <td style="vertical-align:middle;">{{$cut->phone}}</td>
                                    <td style="vertical-align:middle;">{{$cut->street}}</td>
                                    <td style="vertical-align:middle;">{{$cut->tin_no}}</td>
                                    <td style="vertical-align:middle;text-align:center;">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="">
                                            <button title="Approve" onclick="approveCustomerRequest('{{$cut->customer_id}}')" type="button" class="btn btn-success"><span class="fa fa-check"></span></button>
                                            <button type="button" onclick="denyCustomerRequest('{{$cut->customer_id}}')"  title="Deny" class="btn btn-danger"><span class="fa fa-times"></span></button>
                                        </div>
                                    </td>
                                </tr> 
                            @endif
                        @endforeach
                        <script>
                                var table_customer_approval;
                                $(document).ready(function(){
                                    if(document.getElementById('table_customer_approval')){
                                        table_customer_approval = $('#table_customer_approval').DataTable({
                                        order: [[ 0, "desc" ]],
                                        
                                        });
                                    }
                                });
                                function approveCustomerRequest(id){
                                    $.ajax({
                                            type: 'POST',
                                            url: 'update_Customer_edit',                
                                            data: {_token: '{{csrf_token()}}',id:id},
                                            success: function(data) {
                                                //console.log(data);
                                                swal({title: "Done!", text: "Customer Changes Approved", type: 
                                                    "success"}).then(function(){ 
                                                    location.reload();
                                                });
                                            } 											 
                                            });
                                }
                                function denyCustomerRequest(id){
                                    $.ajax({
                                            type: 'POST',
                                            url: 'delete_Customer_edit',                
                                            data: {_token: '{{csrf_token()}}',id:id},
                                            success: function(data) {
                                                swal({title: "Done!", text: "Pending Customer Changes Denied", type: 
                                                    "success"}).then(function(){ 
                                                    location.reload();
                                                });
                                            } 											 
                                            });
                                }
                            </script>
                    </tbody>
                    
                </table>
            </div>
        </div>
        @endif
        @if ($UserAccessList[0]->approval_supplier=="1")
        <div class="tab-pane fade show" id="supplier_tab" role="tabpanel" aria-labelledby="supplier_tab-tab">
            <h3 class="mt-2">Supplier</h3>

            <div class="col-md-12 pl-0 pr-0 mt-3">
                <table class="table table-bordered" style="background-color:white;" id="table_supplier_approval">
                    <<thead class="thead-dark">
                        <tr>
                            <th style="vertical-align:middle;">Supplier ID</th>
                            <th style="vertical-align:middle;">Name</th>
                            <th style="vertical-align:middle;">Company</th>
                            <th style="vertical-align:middle;">Display Name</th>
                            <th style="vertical-align:middle;">Email</th>
                            <th style="vertical-align:middle;">Phone</th>
                            <th style="vertical-align:middle;">Address</th>
                            <th style="vertical-align:middle;">TIN No.</th>
                            <th style="vertical-align:middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($CustomerEdit as $cut)
                            @if ($cut->edit_status=="0" && $cut->account_type=="Supplier")
                                <tr>
                                    <td style="vertical-align:middle;">{{$cut->customer_id}}</td>
                                    <td style="vertical-align:middle;">{{$cut->f_name." ".$cut->l_name}}</td>
                                    <td style="vertical-align:middle;">{{$cut->company}}</td>
                                    <td style="vertical-align:middle;">{{$cut->display_name}}</td>
                                    <td style="vertical-align:middle;">{{$cut->email}}</td>
                                    <td style="vertical-align:middle;">{{$cut->phone}}</td>
                                    <td style="vertical-align:middle;">{{$cut->street}}</td>
                                    <td style="vertical-align:middle;">{{$cut->tin_no}}</td>
                                    <td style="vertical-align:middle;text-align:center;">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="">
                                            <button title="Approve" onclick="approveSupplierRequest('{{$cut->customer_id}}')" type="button" class="btn btn-success"><span class="fa fa-check"></span></button>
                                            <button type="button" onclick="denySupplierRequest('{{$cut->customer_id}}')"  title="Deny" class="btn btn-danger"><span class="fa fa-times"></span></button>
                                        </div>
                                    </td>
                                </tr> 
                            @endif
                        @endforeach
                        <script>
                                var table_supplier_approval;
                                $(document).ready(function(){
                                    if(document.getElementById('table_supplier_approval')){
                                        table_supplier_approval = $('#table_supplier_approval').DataTable({
                                        order: [[ 0, "desc" ]],
                                        
                                        });
                                    }
                                });
                                function approveSupplierRequest(id){
                                    $.ajax({
                                            type: 'POST',
                                            url: 'update_Supplier_edit',                
                                            data: {_token: '{{csrf_token()}}',id:id},
                                            success: function(data) {
                                                //console.log(data);
                                                swal({title: "Done!", text: "Supplier Changes Approved", type: 
                                                    "success"}).then(function(){ 
                                                    location.reload();
                                                });
                                            } 											 
                                            });
                                }
                                function denySupplierRequest(id){
                                    $.ajax({
                                            type: 'POST',
                                            url: 'delete_Supplier_edit',                
                                            data: {_token: '{{csrf_token()}}',id:id},
                                            success: function(data) {
                                                swal({title: "Done!", text: "Pending Supplier Changes Denied", type: 
                                                    "success"}).then(function(){ 
                                                    location.reload();
                                                });
                                            } 											 
                                            });
                                }
                            </script>
                    </tbody>
                    
                </table>
            </div>
        </div>
        @endif
        @if ($UserAccessList[0]->approval_product_services=="1")
        <div class="tab-pane fade show" id="product_tab" role="tabpanel" aria-labelledby="product_tab-tab">
            <h3 class="mt-2">Product and Services</h3>

            <div class="col-md-12 pl-0 pr-0 mt-3">
                <table class="table table-bordered" style="background-color:white;" id="table_product_approval">
                    <thead class="thead-dark">
                        <tr>
                            <th style="vertical-align:middle;">ID</th>
                            <th style="vertical-align:middle;">Name</th>
                            <th style="vertical-align:middle;">Sku</th>
                            <th style="vertical-align:middle;">Type</th>
                            <th style="vertical-align:middle;">Description</th>
                            <th style="vertical-align:middle;">Sale Price</th>
                            <th style="vertical-align:middle;">Cost</th>
                            <th style="vertical-align:middle;">Quantity</th>
                            <th style="vertical-align:middle;">Reorder Point</th>
                            <th style="vertical-align:middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ProductAndServicesEdit as $PaS)
                          @if ($PaS->edit_status=="0")
                            <tr>
                                <td style="vertical-align:middle;">{{$PaS->product_id}}</td>
                                <td style="vertical-align:middle;">{{$PaS->product_name}}</td>
                                <td style="vertical-align:middle;">{{$PaS->product_sku}}</td>
                                <td style="vertical-align:middle;">{{$PaS->product_type}}</td>
                                <td style="vertical-align:middle;">{{$PaS->product_sales_description}}</td>
                                <td style="vertical-align:middle;">{{$PaS->product_sales_price}}</td>
                                <td style="vertical-align:middle;">{{$PaS->product_cost}}</td>
                                <td style="vertical-align:middle;">{{$PaS->product_qty}}</td>
                                <td style="vertical-align:middle;">{{$PaS->product_reorder_point}}</td>
                                <td style="vertical-align:middle;text-align:center;">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="">
                                        <button title="Approve" onclick="approveprodRequest('{{$PaS->product_id}}')" type="button" class="btn btn-success"><span class="fa fa-check"></span></button>
                                        <button type="button" onclick="denyprodRequest('{{$PaS->product_id}}')"  title="Deny" class="btn btn-danger"><span class="fa fa-times"></span></button>
                                    </div>
                                </td>
                            </tr>
                          @endif  
                        @endforeach
                        <script>
                                var table_product_approval;
                                $(document).ready(function(){
                                    if(document.getElementById('table_product_approval')){
                                        table_product_approval = $('#table_product_approval').DataTable({
                                        order: [[ 0, "desc" ]],
                                        
                                        });
                                    }
                                });
                                function approveprodRequest(id){
                                    $.ajax({
                                            type: 'POST',
                                            url: 'update_prod_edit',                
                                            data: {_token: '{{csrf_token()}}',id:id},
                                            success: function(data) {
                                                //console.log(data);
                                                swal({title: "Done!", text: "Product/Service Changes Approved", type: 
                                                    "success"}).then(function(){ 
                                                    location.reload();
                                                });
                                            } 											 
                                            });
                                }
                                function denyprodRequest(id){
                                    $.ajax({
                                            type: 'POST',
                                            url: 'delete_prod_edit',                
                                            data: {_token: '{{csrf_token()}}',id:id},
                                            success: function(data) {
                                                swal({title: "Done!", text: "Pending Product/Service Changes Denied", type: 
                                                    "success"}).then(function(){ 
                                                    location.reload();
                                                });
                                            } 											 
                                            });
                                }
                            </script>
                    </tbody>
                    
                </table>
            </div>
        </div>
        @endif
        @if ($UserAccessList[0]->approval_sales=="1")
        <div class="tab-pane fade show" id="sales_tab" role="tabpanel" aria-labelledby="sales_tab-tab">
            <h3 class="mt-2">Sales Transaction</h3>

            <div class="col-md-12 pl-0 pr-0 mt-3">
                <table class="table table-bordered" style="background-color:white;" id="table_sales_exp_approval">
                    <thead class="thead-dark">
                        <tr>
                            <th class="vertical-align:middle;">Date</th>
                            <th class="vertical-align:middle;">Type</th>
                            <th class="vertical-align:middle;">No.</th>
                            <th class="vertical-align:middle;">Customer</th>
                            <th class="vertical-align:middle;">Due Date</th>
                            
                            <th class="vertical-align:middle;text-align:right;">Total</th>
                            <th class="vertical-align:middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($SalesTransactionEdit as $ste)
                            <tr>
                                <td style="vertical-align:middle;">{{date('m-d-Y',strtotime($ste->st_date))}}</td>
                                <td style="vertical-align:middle;">{{$ste->st_type}}</td>
                                <td style="vertical-align:middle;">{{$ste->st_no}}</td>
                                <td style="vertical-align:middle;">
                                    @foreach ($customers as $zxc)
                                        @if ($zxc->customer_id==$ste->st_customer_id)
                                            @if ($zxc->display_name=="")
                                                @if ($zxc->company=="")
                                                    {{$zxc->f_name." ".$zxc->l_name}}
                                                @else
                                                    {{$zxc->company}}
                                                @endif
                                            @else
                                                {{$zxc->display_name}}
                                            @endif
                                        @endif
                                    @endforeach
                                    </td>
                                <td style="vertical-align:middle;">{{$ste->st_due_date!=""? date('m-d-Y',strtotime($ste->st_due_date)) : ''}}</td>
                                
                                <td style="vertical-align:middle;text-align:right;">
                                    @if ($ste->st_type=="Invoice")
                                        <?php
                                        $totalInvoiceTotal=0;
                                        ?>
                                        @foreach ($StInvoiceEdit as $stiE)
                                            @if ($ste->st_no==$stiE->st_i_no)
                                            
                                            <?php
                                            $totalInvoiceTotal+=$stiE->st_i_total;
                                            ?>  
                                            @endif
                                        @endforeach
                                        {{number_format($totalInvoiceTotal,2)}}
                                    @else
                                        {{number_format($ste->st_amount_paid,2)}}
                                    @endif
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    @if ($ste->st_type=="Invoice")
                                    <div class="btn-group btn-group-sm" role="group" aria-label="">
                                    <button title="Approve" onclick="approveInvoiceRequest('{{$ste->st_no}}','{{$ste->st_location}}','{{$ste->st_invoice_type}}')" type="button" class="btn btn-success"><span class="fa fa-check"></span></button>
                                        <button type="button" onclick="denyInvoiceRequest('{{$ste->st_no}}','{{$ste->st_location}}','{{$ste->st_invoice_type}}')"  title="Deny" class="btn btn-danger"><span class="fa fa-times"></span></button>
                                    </div>
                                    @else
                                        <div class="btn-group btn-group-sm" role="group" aria-label="">
                                            <button title="Approve" onclick="approveCreditNoteRequest('{{$ste->st_no}}')" type="button" class="btn btn-success"><span class="fa fa-check"></span></button>
                                            <button type="button" onclick="denyCreditNoteRequest('{{$ste->st_no}}')"  title="Deny" class="btn btn-danger"><span class="fa fa-times"></span></button>
                                        </div>
                                    @endif
                                </td>
                            </tr>   
                        @endforeach
                        <script>
                                var table_sales_exp_approval;
                                $(document).ready(function(){
                                    if(document.getElementById('table_sales_exp_approval')){
                                        table_sales_exp_approval = $('#table_sales_exp_approval').DataTable({
                                        order: [[ 0, "desc" ]],
                                        
                                        });
                                    }
                                });
                                function approveInvoiceRequest(id,location,type){
                                    $.ajax({
                                            type: 'POST',
                                            url: 'update_invoice_edit2',                
                                            data: {_token: '{{csrf_token()}}',id:id,location:location,type:type},
                                            success: function(data) {
                                                //console.log(data);
                                                swal({title: "Done!", text: "Invoice Changes Approved", type: 
                                                    "success"}).then(function(){ 
                                                    location.reload();
                                                });
                                                
                                            } 											 
                                    });
                                }
                                function denyInvoiceRequest(id){
                                    $.ajax({
                                            type: 'POST',
                                            url: 'delete_invoice_edit',                
                                            data: {_token: '{{csrf_token()}}',id:id,location:location,type:type},
                                            success: function(data) {
                                                swal({title: "Done!", text: "Pending Invoice Changes Denied", type: 
                                                    "success"}).then(function(){ 
                                                    location.reload();
                                                });
                                            } 											 
                                            });
                                }
                                function approveCreditNoteRequest(id){
                                    $.ajax({
                                            type: 'POST',
                                            url: 'update_credit_note_edit2',                
                                            data: {_token: '{{csrf_token()}}',id:id},
                                            success: function(data) {
                                                //console.log(data);
                                                swal({title: "Done!", text: "Credit Note Changes Approved", type: 
                                                    "success"}).then(function(){ 
                                                    location.reload();
                                                });
                                            } 											 
                                            });
                                }
                                function denyCreditNoteRequest(id){
                                    $.ajax({
                                            type: 'POST',
                                            url: 'delete_credit_note_edit',                
                                            data: {_token: '{{csrf_token()}}',id:id},
                                            success: function(data) {
                                                swal({title: "Done!", text: "Pending Credit Note Changes Denied", type: 
                                                    "success"}).then(function(){ 
                                                    location.reload();
                                                });
                                            } 											 
                                            });
                                }
                            </script>
                    </tbody>
                    
                </table>
            </div>
        </div>
        @endif
        @if ($UserAccessList[0]->approval_expense=="1")
        <div class="tab-pane fade show" id="expense_transaction_tab" role="tabpanel" aria-labelledby="expense_transaction_tab-tab">
            <h3 class="mt-2">Expense Transaction</h3>

            <div class="col-md-12 pl-0 pr-0 mt-3">
                <table class="table table-bordered" style="background-color:white;" id="table_expense_exp_approval">
                    <thead class="thead-dark">
                        <tr>
                            <th class="vertical-align:middle;">Date</th>
                            <th class="vertical-align:middle;">Type</th>
                            <th class="vertical-align:middle;">No.</th>
                            <th class="vertical-align:middle;">Payee</th>
                            <th class="vertical-align:middle;">Due Date</th>
                            <th class="vertical-align:middle;"  width="30%">Category</th>
                            <th class="vertical-align:middle;">Total</th>
                            <th class="vertical-align:middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($ExpenseTransactionEdit as $et)
                            
                        <tr>
                            
                            <td class="pt-3-half" >{{date('m-d-Y',strtotime($et->et_date))}}</td>
                            <td class="pt-3-half" >{{$et->et_type}}</td>
                            <td class="pt-3-half" >
                                {{$et->et_no}}
                            </td>
                            <td class="pt-3-half" >
                                @foreach ($customers as $sssdasdasdasdqwqe)
                                    @if ($sssdasdasdasdqwqe->customer_id==$et->et_customer)
                                    {{$sssdasdasdasdqwqe->display_name!=""? $sssdasdasdasdqwqe->display_name :$sssdasdasdasdqwqe->f_name." ".$sssdasdasdasdqwqe->l_name}}
                                    @endif
                                @endforeach
                                </td>
                            <td class="pt-3-half" >
                                {{$et->et_due_date!=""? date('m-d-Y',strtotime($et->et_due_date)) : ""}}
                                
                            </td>
                            <td class="pt-3-half" >
                                @foreach ($COA as $coa)
                                @foreach ($ETAccountDetailEdit as $etade)
                                    @if ($et->et_no==$etade->et_ad_no && $etade->edit_status=="0")
                                        @if($etade->et_ad_product==$coa->id)
                                        {{$coa->coa_name}}
                                        @endif
                                    @endif
                                @endforeach
                                
                                @endforeach
                                
                            </td>
                            <td class="pt-3-half" >
                                <?php
                                $et_totgaltaotal=0;
                                ?>
                                @foreach ($ETAccountDetailEdit as $etade)
                                    @if ($etade->edit_status=="0")
                                        @if ($et->et_no==$etade->et_ad_no)
                                        <?php
                                        $et_totgaltaotal+=$etade->et_ad_total;
                                        ?> 
                                        
                                        @endif
                                    @endif
                                    
                                @endforeach
                                PHP {{number_format($et_totgaltaotal,2)}}
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="">
                                    <button title="Approve" onclick="approveexpenseRequest('{{$et->et_no}}','{{$et->et_type}}')" type="button" class="btn btn-success"><span class="fa fa-check"></span></button>
                                    <button type="button"  onclick="denyexpenseRequest('{{$et->et_no}}','{{$et->et_type}}')" title="Deny" class="btn btn-danger"><span class="fa fa-times"></span></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <script>
                            var table_expense_exp_approval;
                            $(document).ready(function(){
                                if(document.getElementById('table_expense_exp_approval')){
                                    table_expense_exp_approval = $('#table_expense_exp_approval').DataTable({
                                    order: [[ 0, "desc" ]],
                                    
                                    });
                                }
                            });
                            function approveexpenseRequest(id,type){
                                $.ajax({
                                        type: 'POST',
                                        url: 'update_expense_edit',                
                                        data: {_token: '{{csrf_token()}}',id:id,type:type},
                                        success: function(data) {
                                            //console.log(data);
                                            swal({title: "Done!", text: "Expense Transaction Changes Approved", type: 
                                                "success"}).then(function(){ 
                                                location.reload();
                                            });
                                        } 											 
                                        });
                            }
                            function denyexpenseRequest(id,type){
                                $.ajax({
                                        type: 'POST',
                                        url: 'delete_expense_edit',                
                                        data: {_token: '{{csrf_token()}}',id:id,type:type},
                                        success: function(data) {
                                            swal({title: "Done!", text: "Pending Expense Transaction Changes Denied", type: 
                                                "success"}).then(function(){ 
                                                location.reload();
                                            });
                                        } 											 
                                        });
                            }
                    </script>
                    </tbody>
                    
                </table>
            </div>
        </div>
        @endif
        @if ($UserAccessList[0]->approval_pending_bills=="1")
        <div class="tab-pane fade show" id="pending_bill_tab" role="tabpanel" aria-labelledby="pending_bill_tab-tab">
            <h3 class="mt-2">Pending Bill</h3>

            <div class="col-md-12 pl-0 pr-0 mt-3">
                <table class="table table-bordered" style="background-color:white;" id="table_pending_bill">
                    <thead class="thead-dark">
                        <tr>
                            <th class="vertical-align:middle;">Date</th>
                            
                            <th class="vertical-align:middle;">No.</th>
                            <th class="vertical-align:middle;">RF</th>
                            <th class="vertical-align:middle;">PO</th>
                            <th class="vertical-align:middle;">CI</th>
                            <th class="vertical-align:middle;">Payee</th>
                            <th class="vertical-align:middle;">Due Date</th>
                            
                            <th class="vertical-align:middle;">Total Amount</th>
                            <th class="vertical-align:middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($EXNew as $EXn)
                            <tr>
                                <td style="vertical-align:middle;">{{date('m-d-Y',strtotime($EXn->et_date))}}</td>
                                <td class="pt-3-half"  style="vertical-align:middle;">{{$EXn->et_no}}</td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                    {{$EXn->et_shipping_address}}
                                    
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                    
                                    {{$EXn->et_shipping_to}}
                                   
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                   
                                    {{$EXn->et_shipping_via}}
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                    @foreach ($customers as $cus)
                                        @if ($cus->customer_id==$EXn->et_customer)
                                        {{$cus->display_name!=""? $cus->display_name :$cus->f_name." ".$cus->l_name}}
                                        @endif 
                                    @endforeach
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                    @if($EXn->et_due_date!="")
                                        <?php
                                        $date1=date_create(date('Y-m-d'));
                                        $date2=date_create($EXn->et_due_date);
                                        $diff=date_diff($date1,$date2);
                                        ?>
                                        @if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && $EXn->et_bil_status!="Paid" )
                                        <span title='overdue' style='color:red;'>{{$EXn->et_due_date!=""? date('m-d-Y',strtotime($EXn->et_due_date)) : ""}}</span>

                                        @else
                                        {{$EXn->et_due_date!=""? date('m-d-Y',strtotime($EXn->et_due_date)) : ""}}
                                        @endif
                                    @endif
                                    
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                    <?php
                                    $BillTotalAmount=0;
                                    ?>
                                    @foreach ($ETANew as $ETAn)
                                        
                                        @if ($ETAn->et_ad_no==$EXn->et_no)
                                            <?php
                                            $BillTotalAmount+=$ETAn->et_ad_total;
                                            ?>
                                            
                                        @endif
                                    @endforeach
                                    {{number_format($BillTotalAmount,2)}}
                                </td>
                                <td class="pt-3-half"  style="vertical-align:middle;">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="">
                                        <button title="Approve" onclick="approveBillRequest('{{$EXn->et_no}}')" type="button" class="btn btn-success"><span class="fa fa-check"></span></button>
                                        <button type="button"  onclick="denyBillRequest('{{$EXn->et_no}}')" title="Deny" class="btn btn-danger"><span class="fa fa-times"></span></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <script>
                            function approveBillRequest(id){
                                $.ajax({
                                        type: 'POST',
                                        url: 'approve_pending_bill_request',                
                                        data: {_token: '{{csrf_token()}}',id:id},
                                        success: function(data) {
                                            console.log(data);
                                            swal({title: "Done!", text: "Pending Bill Request Approved", type: 
                                                "success"}).then(function(){ 
                                                location.reload();
                                            });
                                        } 											 
                                        }); 
                            }
                            function denyBillRequest(id){
                                $.ajax({
                                        type: 'POST',
                                        url: 'delete_pending_bill_request',                
                                        data: {_token: '{{csrf_token()}}',id:id},
                                        success: function(data) {
                                            //console.log(data);
                                            swal({title: "Done!", text: "Pending Bill Request Denied", type: 
                                                "success"}).then(function(){ 
                                                location.reload();
                                            });
                                        } 											 
                                        }); 
                            }
                        </script>
                    </tbody>
                    
                </table>
            </div>
        </div>
        @endif
        @if ($UserAccessList[0]->approval_boq=="1")
        <div class="tab-pane fade show" id="bid_of_quotation_tab" role="tabpanel"   aria-labelledby="bid_of_quotation_tab-tab">
                <h3 class="mt-2">Bid of Quotation</h3>
    
                <div class="col-md-12 pl-0 pr-0 mt-3">
                    <table class="table table-bordered" style="background-color:white;" id="table_pending_bill">
                        <thead class="thead-dark">
                            <tr>
                                <th class="vertical-align:middle;">Date</th>
                                
                                <th class="vertical-align:middle;">Cost Center Code</th>
                                <th class="vertical-align:middle;">Cost Center</th>
                                <th class="vertical-align:middle;">Amount</th>
                                
                                <th class="vertical-align:middle;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($BudgetsEdit as $Budgedit)
                            @if ($Budgedit->edit_status!="1")
                                <?php
                                    $cc_code="";
                                    $cc_name="";
                                ?>
                                @foreach ($cost_center_list as $ccl)
                                    @if ($ccl->cc_no==$Budgedit->budget_cost_center)
                                    <?php
                                        $cc_code=$ccl->cc_name_code;
                                        $cc_name=$ccl->cc_name;
                                    ?>  
                                    @endif
                                @endforeach
                                <tr>
                                    <td style="vertical-align:middle;">{{date('m-d-Y',strtotime($Budgedit->updated_at))}}</td>
                                    <td class="pt-3-half"  style="vertical-align:middle;">
                                        {{$cc_code}}
                                    </td>
                                    <td class="pt-3-half"  style="vertical-align:middle;">
                                        {{$cc_name}}
                                    </td>
                                    <td class="pt-3-half"  style="vertical-align:middle;">
                                        {{number_format($Budgedit->budget_month,2)}}
                                    </td>
                                    <td class="pt-3-half"  style="vertical-align:middle;">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="">
                                        <button title="Approve" onclick="update_budget('{{$Budgedit->budget_no}}')" type="button" class="btn btn-success"><span class="fa fa-check"></span></button>
                                            <button type="button"  onclick="delete_budget_request('{{$Budgedit->budget_no}}')" title="Deny" class="btn btn-danger"><span class="fa fa-times"></span></button>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                                
                            @endforeach
                            
                        </tbody>
                        <script>
                            function update_budget(id){
                                $.ajax({
                                        type: 'POST',
                                        url: 'approve_pending_bid_request',                
                                        data: {_token: '{{csrf_token()}}',id:id},
                                        success: function(data) {
                                            console.log(data);
                                            swal({title: "Done!", text: "Pending Bid of Quotation Request Approved", type: 
                                                "success"}).then(function(){ 
                                                location.reload();
                                            });
                                        } 											 
                                        }); 
                            }
                            function delete_budget_request(id){
                                $.ajax({
                                        type: 'POST',
                                        url: 'delete_pending_bid_request',                
                                        data: {_token: '{{csrf_token()}}',id:id},
                                        success: function(data) {
                                            //console.log(data);
                                            swal({title: "Done!", text: "Pending Bid of Quotation Request Denied", type: 
                                                "success"}).then(function(){ 
                                                location.reload();
                                            });
                                        } 											 
                                        }); 
                            }
                        </script>                        
                    </table>
                </div>
            </div>
            @endif
    
    
        
        
    </div>
    <button type="button" style="display:none;" id="approval_tab_activator">asdasd</button>
@endsection