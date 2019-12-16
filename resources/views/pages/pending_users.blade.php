@extends('layout.initial')

@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>User Access Approval</h1>
            </div>
        </div>
    </div>
    
</div>
    
<div class="card-body">
    <ul class="nav nav-tabs">
		<li class="nav-item"><a class="nav-link  show active" data-toggle="tab" href="#all_users">All Users</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pending_users">Pending Users
        <?php
        $pending_count=0;
        $approved_count=0;
        ?>
        @foreach ($all_system_users as $asu)
            @if ($asu->approved_status=="0" || $asu->approved_status==NULL)
            <?php
            $pending_count++;
            ?>  
            @endif
            @if ($asu->approved_status=="1")
            <?php
            $approved_count++;
            ?>  
            @endif
        @endforeach
        @if ($pending_count==0)
        
        @else
        <span class="badge" style="background-color:#d9534f;color:white;"><?php echo $pending_count; ?></span>
        @endif
        
		</a></li>
	  
    </ul>
    <div class="tab-content p-1" >
        <div class="tab-pane fade show active" id="all_users" role="tabpanel" aria-labelledby="home-tab">
            <table class="table table-bordered" style="background-color:white;">
			<thead>
				<tr class="success">
					<th colspan="10" style="text-align:center;vertical-align:middle;font-weight:bold;">Accounting System Users</th>
				</tr>
				<tr>
					<th style="vertical-align:middle;">User ID</th>
					<th style="vertical-align:middle;">Name</th>
					<th style="vertical-align:middle;">Position</th>
					<th style="vertical-align:middle;">Email</th>
					<th style="vertical-align:middle;">Date Created</th>
					<th style="vertical-align:middle;text-align:center;">Action</th>
				</tr>
			</thead>
			<tbody>
                @if ($approved_count==0)
                <tr>
                    <td colspan="6" style="vertical-align:middle;text-align:center;">no User Account found</td>
                </tr>
                @else
                @foreach ($all_system_users as $asuu)
                    @if ($asuu->approved_status=="1")
                    <tr>
						<td style="vertical-align:middle;"><?php echo $asuu->id; ?></td>
						<td style="vertical-align:middle;"><?php echo $asuu->name; ?></td>
						<td style="vertical-align:middle;"><?php echo $asuu->position; ?></td>
						<td style="vertical-align:middle;"><?php echo $asuu->email; ?></td>
						<td style="vertical-align:middle;"><?php echo date('m-d-Y',strtotime($asuu->created_at)); ?></td>
						<td style="vertical-align:middle;text-align:center;">
							<button data-toggle="modal" data-target="#UserAccessModal" class="btn btn-link btn-sm" onclick="setDataUserAccess('<?php echo $asuu->id; ?>','<?php echo $asuu->name; ?>')"><span class="fa fa-user-friends"></span> User Access</button>
						</td>
					</tr>
                    @endif
                @endforeach
                @endif
                <script>
                    function setDataUserAccess(id,name){
                        $('#UserAccessModal').find('input[type=checkbox]:checked').removeAttr('checked');
						document.getElementById('ModalTitle').innerHTML=name;
						document.getElementById('userid_accounting').value=id;
						console.log(id);
						
						
                        @foreach($all_system_users_access as $acc)
                        if(id=="<?php echo $acc->user_id; ?>"){
                            if("<?php echo $acc->approvals ?>"=="1"){
								$("input[value='Approvals']").prop('checked', true);
							}
							if("<?php echo $acc->approval_pending_bills ?>"=="1"){
								$("input[value='Pending Bills Approval']").prop('checked', true);
							}
							if("<?php echo $acc->approval_bank ?>"=="1"){
								$("input[value='Bank Approval']").prop('checked', true);
							}
							if("<?php echo $acc->approval_coa ?>"=="1"){
								$("input[value='Chart of Account Approval']").prop('checked', true);
							}
							if("<?php echo $acc->approval_cc ?>"=="1"){
								$("input[value='Cost Center Approval']").prop('checked', true);
							}
							if("<?php echo $acc->approval_customer ?>"=="1"){
								$("input[value='Customer Approval']").prop('checked', true);
							}
							if("<?php echo $acc->approval_supplier ?>"=="1"){
								$("input[value='Supplier Approval']").prop('checked', true);
							}
							if("<?php echo $acc->approval_product_services ?>"=="1"){
								$("input[value='Product And Services Approval']").prop('checked', true);
							}
							if("<?php echo $acc->approval_sales ?>"=="1"){
								$("input[value='Sales Transactions Approval']").prop('checked', true);
							}
							if("<?php echo $acc->approval_expense ?>"=="1"){
								$("input[value='Expense Transactions Approval']").prop('checked', true);
							}
							if("<?php echo $acc->approval_boq ?>"=="1"){
								$("input[value='Bid of Quotation Approval']").prop('checked', true);
							}
							
							
							if("<?php echo $acc->journal_entry ?>"=="1"){
								$("input[value='Journal Entry']").prop('checked', true);
							}
							if("<?php echo $acc->sales ?>"=="1"){
								$("input[value='Sales']").prop('checked', true);
							}
							if("<?php echo $acc->invoice ?>"=="1"){
								$("input[value='Invoice']").prop('checked', true);
							}
							if("<?php echo $acc->estimate ?>"=="1"){
								$("input[value='Estimate']").prop('checked', true);
							}
							if("<?php echo $acc->credit_note ?>"=="1"){
								$("input[value='Credit Note']").prop('checked', true);
							}
							if("<?php echo $acc->sales_receipt ?>"=="1"){
								$("input[value='Sales Receipt']").prop('checked', true);
							}
							if("<?php echo $acc->expense ?>"=="1"){
								$("input[value='Expense']").prop('checked', true);
							}
							if("<?php echo $acc->bill ?>"=="1"){
								$("input[value='Bill']").prop('checked', true);
							}
							
							if("<?php echo $acc->supplier_credit?>"=="1"){
								$("input[value='Supplier Credit']").prop('checked', true);
							}
							if("<?php echo $acc->pay_bills ?>"=="1"){
								$("input[value='Pay Bills']").prop('checked', true);
							}
							if("<?php echo $acc->reports ?>"=="1"){
								$("input[value='Reports']").prop('checked', true);
							}
							
							if("<?php echo $acc->fund_feeds ?>"=="1"){
								$("input[value='Fund Feeds']").prop('checked', true);
							}
							if("<?php echo $acc->chart_of_accounts ?>"=="1"){
								$("input[value='Chart of Accounts']").prop('checked', true);
							}
							if("<?php echo $acc->cost_center ?>"=="1"){
								$("input[value='Cost Center']").prop('checked', true);
							}
							if("<?php echo $acc->settings ?>"=="1"){
								$("input[value='Settings']").prop('checked', true);
							}
							if("<?php echo $acc->procurement_system ?>"=="1"){
								$("input[value='Procurement System']").prop('checked', true);
							}
							if("<?php echo $acc->user_approval ?>"=="1"){
								$("input[value='User Access Approval']").prop('checked', true);
							}
							
							document.getElementById('ApprovalLevelProcurement').value="<?php echo $acc->procurement_sub; ?>";
                            
                            @foreach($all_system_users_cost_center_access as $cca)
                                if(id=="<?php echo  $cca->use_id; ?>"){
                                    if("<?php echo $cca->access_status; ?>"=="1"){
                                        $("input[value='<?php echo $cca->cost_center_id; ?>']").prop('checked', true);
                                        $.ajax({
                                        type: 'POST',
                                        url: 'get_cost_centers',                
                                        data: {_token: '{{csrf_token()}}',id:'<?php echo $cca->cost_center_id; ?>'},
                                        success: function(data) {
                                            if(data.length!=0){
                                                var str = data[0]['cc_type'];
                                                var res = str.replace("'", "\'");
                                                console.log(res);
                                                if($('input[value="'+res+'"]').prop('checked')==false){
                                                    document.getElementById($('input[value="'+res+'"]').attr('id')).click();
                                                }
                                            }
                                            
                                        } 											 
                                        });

                                        
                                    }
                                }

                            @endforeach
                        }

                        @endforeach
                        checksales();
						checkexpense();
						checkreport();
						checkprocurement();
						checkapproval();
                    }
				</script>
				

            </tbody>
            </table>

		</div>
		
		
							
                <div id="UserAccessModal" class="modal fade" role="dialog">
				  <div class="modal-dialog modal-lg">

					<!-- Modal content-->
					
					<div class="modal-content">
					  <div class="modal-header">
						
                        <h5 class="modal-title" id="ModalTitle">User Name</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <script>
                          $(document).ready(function(){
                                $("#update_user_access_form").submit(function(e) {
								console.log('form sen');
                                e.preventDefault();
                                update_user_access();
                                });
                                
                            });
                            function update_user_access(){
                                $.ajax({
                                    method: "POST",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "{{ route('update_user_access') }}",
                                    dataType: "text",
                                    data: $('#update_user_access_form').serialize(),
                                    success: function (data) {
                                        console.log(data);
                                        
                                        swal({title: "Done!", text: "User Access Updated", type: 
                                        "success"}).then(function(){
                                            setTimeout(function(){
                                                location.reload();
                                            }, 1000);
                                            
                                        });
                                    },
                                    error: function (data) {
                                        
                                        swal("Error!", "User Access Update Failed", "error");
                                    }
                                });
                            }
                      </script>
					  <form id="update_user_access_form" >
					  <div class="modal-body">
					  <div class="row">
						<div class="col-md-2">
							{{ csrf_field() }}	  
							<p>User Access</p>
							<input type="hidden" name="userid_accounting" id="userid_accounting" value="">
						</div>
						<div class="col-md-10">
							<div class="checkbox">
							  <label><input type="checkbox" name="access[]" value="Approvals" onclick="checkapproval()" id="ApprovalCheckbox">Approvals</label><br>
							  
							</div>
							<div class="checkbox" style="padding-left:20px;display:none;" id="sub_approval_checkboxes" >
								<div class="checkbox">
								<label ><input type="checkbox" name="access[]" class="approval_sub" value="Pending Bills Approval">Pending Bills</label>
								</div>
								<div class="checkbox">
								<label ><input type="checkbox" name="access[]" class="approval_sub" value="Bank Approval">Bank</label>
								</div>
								<div class="checkbox">
								<label ><input type="checkbox" name="access[]" class="approval_sub" value="Chart of Account Approval">Chart of Accounts</label>
								</div>
								<div class="checkbox">
								<label ><input type="checkbox" name="access[]" class="approval_sub" value="Cost Center Approval">Cost Center</label>
								</div>
								<div class="checkbox">
								<label ><input type="checkbox" name="access[]" class="approval_sub" value="Customer Approval">Customer</label>
								</div>
								<div class="checkbox">
								<label ><input type="checkbox" name="access[]" class="approval_sub" value="Supplier Approval">Supplier</label>
								</div>
								<div class="checkbox">
								<label ><input type="checkbox" name="access[]" class="approval_sub" value="Product And Services Approval">Product And Services</label>
								</div>
								<div class="checkbox">
								<label ><input type="checkbox" name="access[]" class="approval_sub" value="Sales Transactions Approval">Sales Transactions</label>
								</div>
								<div class="checkbox">
								<label ><input type="checkbox" name="access[]" class="approval_sub" value="Expense Transactions Approval">Expense Transactions</label>
								</div>
								
								<div class="checkbox">
								<label ><input type="checkbox" name="access[]" class="approval_sub" value="Bid of Quotation Approval">Bid of Quotation</label>
								</div>
								<div class="checkbox">
								<label><input type="checkbox" name="access[]" class="approval_sub" value="User Access Approval">User Access Approval</label>
								</div>
							</div>
							<div class="checkbox">
							  <label><input type="checkbox" name="access[]" value="Settings" >Settings</label>
							</div>
							<div class="checkbox">
							  <label><input type="checkbox" name="access[]" value="Chart of Accounts">Chart of Accounts</label>
							</div>
							<div class="checkbox">
							  <label><input type="checkbox" name="access[]" value="Cost Center">Cost Center</label>
							</div>
							<div class="checkbox">
							  <label><input type="checkbox" name="access[]" value="Journal Entry">Journal Entry</label>
							</div>
							
							<div class="checkbox">
							  <label><input type="checkbox" name="access[]" value="Fund Feeds">Fund Feeds</label>
							</div>
							<div class="checkbox">
							  <label><input type="checkbox" name="access[]" onclick="checksales()" value="Sales" id="SalesCheckbox">Sales</label>
							</div>
							<div class="checkbox" style="padding-left:20px;display:none;" id="sub_sales_checkboxes">
								<div class="checkbox">
							  <label ><input type="checkbox" name="access[]" value="Invoice">Invoice</label>
							  </div>
							  <div class="checkbox">
							  <label ><input type="checkbox" name="access[]" value="Estimate">Estimate</label>
							  </div>
							  <div class="checkbox">
							  <label><input type="checkbox" name="access[]" value="Credit Note">Credit Note</label>
							  </div>
							  <div class="checkbox">
							  <label ><input type="checkbox" name="access[]" value="Sales Receipt">Sales Receipt</label>
							  </div>
							</div>
							<div class="checkbox">
							  <label><input type="checkbox" value="Expense" name="access[]" onclick="checkexpense()" id="ExpenseCheckbox">Expense</label>
							  <script>
								function checkapproval(){
									if(document.getElementById("ApprovalCheckbox").checked){
										document.getElementById('sub_approval_checkboxes').style.display="block";
										
									}else{
										document.getElementById('sub_approval_checkboxes').style.display="none";
										//$('#sub_sales_checkboxes').find('input[type=checkbox]:checked').removeAttr('checked');
									}
								}
								function checksales(){
									if(document.getElementById("SalesCheckbox").checked){
										document.getElementById('sub_sales_checkboxes').style.display="block";
										
									}else{
										document.getElementById('sub_sales_checkboxes').style.display="none";
										$('#sub_sales_checkboxes').find('input[type=checkbox]:checked').removeAttr('checked');
									}
								}
								function checkexpense(){
									if(document.getElementById("ExpenseCheckbox").checked){
										document.getElementById('sub_expense_checkboxes').style.display="block";
										
									}else{
										document.getElementById('sub_expense_checkboxes').style.display="none";
										$('#sub_expense_checkboxes').find('input[type=checkbox]:checked').removeAttr('checked');
									}
								}
								function checkprocurement(){
									if(document.getElementById("ProcurementSystemCheckbox").checked){
										document.getElementById('sub_procurement_checkboxes').style.display="block";
										
									}else{
										document.getElementById('sub_procurement_checkboxes').style.display="none";
										
									}
								}
							  </script>
							</div>
							<div class="checkbox" style="padding-left:20px;display:none;" id="sub_expense_checkboxes" >
								<div class="checkbox">
								<label ><input type="checkbox" name="access[]" class="expense_sub" value="Bill">Bill</label>
								</div>
								<div class="checkbox">
								<label ><input type="checkbox" name="access[]" class="expense_sub" value="Supplier Credit">Supplier Credit</label>
								</div>
								<div class="checkbox">
								<label ><input type="checkbox" name="access[]" class="expense_sub" value="Pay Bills">Pay Bills</label>
								</div>
							  
							</div>
							<div class="checkbox">
							  <label><input type="checkbox" name="access[]" onclick="checkprocurement()" value="Procurement System" id="ProcurementSystemCheckbox">Procurement System</label>
							</div>
							<div class="checkbox" style="padding-left:20px;display:none;" id="sub_procurement_checkboxes" >
								<select class="form-control w-50" name="ApprovalLevelProcurement" id="ApprovalLevelProcurement" style="width:auto;">
									<option value="">--Select Approval Level--</option>
									<option value="A1">Recommending Approval</option>
									<option value="A2">Final Approval</option>
									<option value="A4">Processing Purchase Order</option>
									<option value="A3">Transaction Closing</option>
									
								</select>
							</div>
							<div class="checkbox">
							  <label><input type="checkbox" name="access[]" onclick="checkreport()" id="ReportCheckbox" value="Reports">Reports</label>
							  <script>
								function checkreport(){
									if(document.getElementById("ReportCheckbox").checked){
										document.getElementById('sub_report_checkboxes').style.display="block";
										
									}else{
										document.getElementById('sub_report_checkboxes').style.display="none";
										$('#sub_report_checkboxes').find('input[type=checkbox]:checked').removeAttr('checked');
									}
								}
								function validatecheckboxAll() {
									if (document.getElementById('AllCheckOption').checked) {
										checkAll();
									}
								}
								function checkAll() {
									$('#sub_report_checkboxes :checkbox:enabled').prop('checked', true);
								}
							  </script>
							</div>
							
							<div class="checkbox" style="padding-left:20px;display:none;" id="sub_report_checkboxes" >
								<div class="checkbox">
								<label ><input type="checkbox" id="AllCheckOption" name="accesscostcenter[]" onclick="validatecheckboxAll()" class="report_sub"  value="All">All</label>
                                </div>
                                <?php
                                $cc_id_count=0;
                                ?>
                                @foreach ($cost_center_list_grouped as $asucca)
                                <?php
                                $cc_id_count++;
                                ?>
                                <div class="checkbox">
								
								<label ><input type="checkbox" onclick="checkreport<?php echo 's'.$cc_id_count.'_checkbox'; ?>()" class="report_sub" id="<?php echo "s".$cc_id_count."_checkbox"; ?>" value="<?php echo $asucca->cc_type; ?>"><?php echo $asucca->cc_type; ?></label>
								<script>
									function checkreport<?php echo "s".$cc_id_count."_checkbox"; ?>(){
										
											
										if(document.getElementById('<?php echo "s".$cc_id_count."_checkbox"; ?>').checked){
											document.getElementById('<?php echo "s".$cc_id_count; ?>_sub_report').style.display="block";
											$('#<?php echo "s".$cc_id_count; ?>_sub_report').find('input[type=checkbox]').attr('checked',true);
											console.log($('#<?php echo "s".$cc_id_count; ?>_sub_report').find('input[type=checkbox]'));
										}else{
											document.getElementById('<?php echo "s".$cc_id_count; ?>_sub_report').style.display="none";
											$('#<?php echo "s".$cc_id_count; ?>_sub_report').find('input[type=checkbox]').attr('checked',false);
											//$('#<?php echo "s".$cc_id_count; ?>_sub_report').find('input[type=checkbox]:checked').removeAttr('checked');
											console.log('<?php echo "s".$cc_id_count; ?>_sub_report unchecked');
										}
									}
									
								</script>
                                </div>
                                    <div class="checkbox" style="padding-left:20px;display:none;" id="<?php echo "s".$cc_id_count; ?>_sub_report" >
                                    <?php
                                    $type=str_replace("'","''",$asucca->cc_type);
                                    
                                    ?>
                                    @foreach ($cost_center_list as $ccl)
                                        
                                        @if ($asucca->cc_type==$ccl->cc_type)
                                            <div class="checkbox">
                                            <label ><input type="checkbox" name="accesscostcenter[]"  class="report_sub"  value="<?php echo $ccl->cc_no; ?>"><?php echo str_replace("'","&#039;",$ccl->cc_name); ?></label>
                                            </div> 
                                        @endif
                                    @endforeach
                                    
                                    </div>
                                @endforeach
								
							</div>
							
						</div>
					  </div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit"   name="UserAccessSubmit" class="btn btn-primary">Save</button>
					  </div>
					</form>
					</div>
					
				  </div>
				</div>
				

        <div class="tab-pane fade " id="pending_users" role="tabpanel" aria-labelledby="home-tab">
            <table class="table table-bordered" style="background-color:white;">
			<thead>
				<tr class="success">
					<th colspan="10" style="text-align:center;vertical-align:middle;font-weight:bold;">Pending Accounting System Users</th>
				</tr>
				<tr>
					<th style="vertical-align:middle;">User ID</th>
					<th style="vertical-align:middle;">Name</th>
					<th style="vertical-align:middle;">Position</th>
					<th style="vertical-align:middle;">Email</th>
					<th style="vertical-align:middle;">Date Created</th>
					<th style="vertical-align:middle;text-align:center;">Action</th>
				</tr>
			</thead>
			<tbody>
            @if ($pending_count==0)
                <tr>
					<td colspan="6" style="vertical-align:middle;text-align:center;">no pending User Account Request</td>
				</tr>
            @else
               @foreach ($all_system_users as $asuu)
               @if ($asuu->approved_status=="0" || $asuu->approved_status==NULL)
               <tr>
                    <td style="vertical-align:middle;"><?php echo $asuu->id; ?></td>
                    <td style="vertical-align:middle;"><?php echo $asuu->name ?></td>
                    <td style="vertical-align:middle;"><?php echo $asuu->position ?></td>
                    <td style="vertical-align:middle;"><?php echo $asuu->email ?></td>
                    <td style="vertical-align:middle;"><?php echo date('m-d-Y',strtotime($asuu->created_at)); ?></td>
                    <td style="vertical-align:middle;text-align:center;">
                        <script>
                            $(document).ready(function(){
                                $("#approve_user_{{$asuu->id}}").submit(function(e) {
                                e.preventDefault();
                                
                                });
                                $("#deny_user_{{$asuu->id}}").submit(function(e) {
                                e.preventDefault();
                                
                                });
                            });
                        </script>
                        <form style="display:inline" id="approve_user_{{$asuu->id}}" onsubmit="approve_user_account('{{$asuu->id}}','{{$asuu->position}}')">
                        <input type="hidden" value="<?php echo $asuu->id ?>" name="user_id_approve">
                        <input type="hidden" value="<?php echo $asuu->position ?>" name="user_position">
                        <button type="submit" class="btn btn-sm btn-success"><span class="fa fa-check"></span></button>
                        </form>
                        <form style="display:inline" id="deny_user_{{$asuu->id}}"  onsubmit="deny_user_account('{{$asuu->id}}')">
                        <input type="hidden" value="<?php echo $asuu->id ?>" name="user_id_deny">
                        <button type="submit" class="btn btn-sm btn-danger"><span class="fa fa-times"></span></button>
                        </form>
                    </td>
                </tr>
                @endif  
               @endforeach
            @endif   
            </tbody>
            </table>
            <script>
                function approve_user_account(e,position){
                    var r=confirm('Approve User Account Request with id # '+e+'?');
                    if(r==true){
                        $.ajax({
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "{{ route('approve_user') }}",
                            dataType: "text",
                            data: {id:e,position:position,_token: '{{csrf_token()}}'},
                            success: function (data) {
                                console.log(data);
                                
                                swal({title: "Done!", text: "User Account Approved", type: 
                                "success"}).then(function(){
                                    setTimeout(function(){
                                        location.reload();
                                    }, 1000);
                                    
                                });
                            },
                            error: function (data) {
                                
                                swal("Error!", "User Account Approval Failed", "error");
                            }
                        });
                    }
                    
                }
                function deny_user_account(e){
                    var r=confirm('Deny User Account Request with id # '+e+'?');
                    if(r==true){
                        $.ajax({
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "{{ route('deny_user') }}",
                            dataType: "text",
                            data: {id:e,_token: '{{csrf_token()}}'},
                            success: function (data) {
                                console.log(data);
                                
                                swal({title: "Done!", text: "User Account Denied", type: 
                                "success"}).then(function(){
                                    setTimeout(function(){
                                        location.reload();
                                    }, 1000);
                                    
                                });
                            },
                            error: function (data) {
                                
                                swal("Error!", "User Account Denying Failed", "error");
                            }
                        });
                    }
                }
            </script>
        </div>
    </div>
</div>
@endsection