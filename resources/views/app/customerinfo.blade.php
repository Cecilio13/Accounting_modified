@extends('layout.initial')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <h3>
                @if($picked->display_name!="")
                {{$picked->display_name}}
                @else
                {{$picked->f_name." ".$picked->l_name}}
                @endif
                <br>
                <small>
                {{$picked->street.","}}
                {{$picked->city.",".$picked->state}}
                {{$picked->postal_code}}
                </small>
            </h3>
            
        </div>
        <div class="col-md-2">
            <a class="btn btn-primary" href="generate_pdf_bir?id={{$picked->customer_id}}">Generate Form 2307</a>
        </div>
        <div class="col-md-1">
            <button class="btn btn-dark" onclick="edit_customer_openModal('editcustomermodal')">Edit</button>
            
        </div>
        {{-- <div class="col-md-2">
                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    New Transaction
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#invoicemodal" id="{{$picked->customer_id}}">Invoice</a>
                    <a class="dropdown-item" href="#">Payment</a>
                    <a class="dropdown-item" href="#">Estimate</a>
                    <a class="dropdown-item" href="#">Sale Receipt</a>
                    <a class="dropdown-item" href="#">Credit Note</a>
                    <a class="dropdown-item" href="#">Statement</a>
                </div>
        </div> --}}
    </div>
    <br>
    <script>
        function edit_customer_openModal(id){
            var question;
            var r = confirm("Are You Sure you want to Change this?\nAny Changes here will be subject for Approval");
            if (r == true) {  
            open_modal_dyna(id);
            }
        }
        function UpdateCustomer(){
            $.ajax({
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('update_customer') }}",
                dataType: "text",
                data: $('#update_customer_form').serialize(),
                success: function (data) {
                    //swal("Done!", "Updated customer", "success");
                    if(data==1){
                        swal({title: "Done!", text: "Customer Information updated.", type: 
                                "success"}).then(function(){ 
                                    window.location.href = "/customerinfo/?customer_id="+document.getElementById('hiddencusid').value;
                                }
                                );
                    }
                }
                
            });
            window.location.href = "/customerinfo/?customer_id="+document.getElementById('hiddencusid').value;
        }
    </script>
    <div class="modal fade" id="editcustomermodal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
            <form method="POST" action="{{ route('update_customer') }}"  class="form-horizontal "  id="update_customer_form"  autocomplete="off">
            {{ csrf_field() }}
            <input type="hidden" name="customer_id" id="hiddencusid" value="{{$picked->customer_id}}">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticModalLabel">Edit 
                                @if($picked->display_name!="")
                                {{$picked->display_name}}
                                @else
                                {{$picked->f_name." ".$picked->l_name}}
                                @endif
                                Information

                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-6 p-0">
                            <div class="col-md-6 p-0 pr-1">
                                <p>First Name</p>
                                <input type="text" name="f_name" value="{{$picked->f_name}}" class="w-100" >
                            </div>
                            <div class="col-md-6 p-0 ">
                                <p>Last Name</p>
                                <input type="text" name="l_name" value="{{$picked->l_name}}" class="w-100" >
                            </div>
                            <div class="col-md-12 p-0">
                                <p>Company</p>
                                <input type="text" name="company" value="{{$picked->company}}" class="w-100" >
                            </div>
                            <div class="col-md-12 p-0">
                                <p>Business Style</p>
                                <input type="text" name="business_style" value="{{$picked->business_style}}" class="w-100">
                            </div>
                            <div class="col-md-12 p-0">
                                <p>Display name as</p>
                                <input id="customername" type="text" value="{{$picked->display_name}}" name="display_name" class="w-100" >
                            </div>
                            <div class="col-md-12 p-0">
                                <p>Address</p>
                                <textarea rows="2" class="w-100"  name="street" placeholder="Street" >{{$picked->street}}</textarea>
                            </div>
                            <div class="col-md-6 p-0 pb-1">
                                <input type="text" name="city" value="{{$picked->city}}" placeholder="City/Town" class="w-100" >
                            </div>
                            <div class="col-md-6 p-0 pl-1 pb-1">
                                <input type="text" name="state" value="{{$picked->state}}" placeholder="State/Province" class="w-100" >
                            </div>
                            <div class="col-md-6 p-0">
                                <input type="text" name="postal_code" value="{{$picked->postal_code}}" placeholder="Postal Code" class="w-100" >
                            </div>
                            <div class="col-md-6 p-0 pl-1" >
                                <input type="text" name="country" value="{{$picked->country}}" placeholder="Country" class="w-100">
                            </div>
                            <div class="col-md-12 p-0">
                                <p>Notes</p>
                                <textarea rows="2" name="notes" class="w-100" >{{$picked->notes}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="col-md-12 p-0">
                                <p>Email</p>
                                <input type="email" name="email" value="{{$picked->email}}" class="w-100" placeholder="separate multiple emails with commas" >
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="col-md-4 p-0 pr-1">
                                    <p>Phone</p>
                                    <input id="customerphone" type="tel" value="{{$picked->phone}}" name="phone" class="w-100" >
                                </div>
                                <div class="col-md-4 p-0 pr-1">
                                    <p>Mobile</p>
                                    <input type="tel" name="mobile" class="w-100" value="{{$picked->mobile}}" >
                                </div>
                                <div class="col-md-4 p-0">
                                    <p>Fax</p>
                                    <input type="tel" name="fax" class="w-100" value="{{$picked->fax}}" >
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="col-md-4 p-0 pr-1">
                                    <p>Other</p>
                                    <input type="text" name="other" class="w-100" value="{{$picked->other}}" >
                                </div>
                                <div class="col-md-8 p-0">
                                    <p>Website</p>
                                    <input type="text" name="website" value="{{$picked->website}}" class="w-100" >
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="col-md-6 p-0 pr-1">
                                    <p>Payment Method<p>
                                    <input type="text" list="payment_method_list" value="{{$picked->payment_method}}" name="payment_method" class="w-100" >
                                </div>
                                <div class="col-md-6 p-0">
                                    <p>Terms</p>
                                    <input type="text" list="terms_list" value="{{$picked->terms}}" name="terms" id="terms" class="w-100" >
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="col-md-6 p-0 pr-1">
                                    <p>Opening balance</p>
                                    <input id="customerbalance" type="number" value="{{$picked->opening_balance}}" name="opening_balance" class="w-100" >
                                </div>
                                <div class="col-md-6 p-0">
                                    <p>as of</p>
                                    <input type="date" name="as_of_date" class="w-100" value="{{$picked->as_of_date}}" >
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="col-md-6 p-0 pr-1">
                                    <p>Account No. </p>
                                    <input type="tel" name="account_no" class="w-100" value="{{$picked->account_no}}" >
                                </div>
                                <div class="col-md-6 p-0">
                                    <p>Business ID No. </p>
                                    <input type="tel" name="business_id_no" class="w-100" value="{{$picked->business_id_no}}" >
                                </div>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="col-md-6 p-0 pr-1">
                                    <p>TIN No. </p>
                                    <input type="text" name="tin_no" class="w-100" value="{{$picked->tin_no}}" >
                                </div>
                                <div class="col-md-6 p-0 pr-1">
                                    <p>Withholding Tax</p>
                                    <input type="number" name="withholdingtax" min="0" max="100" step="0.01" value="{{$picked->withhold_tax}}" style="width:80%" required> %
                                </div>
                            </div>
                            <div class="col-md-12 p-0" style="display:none;">
                                <p>Attachments</p>
                                <div class="input-group mb-3 p-0">
                                    <div class="custom-file">
                                        <input type="file" name="attachment" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                        <button id="customeradd" type="submit" class="btn btn-success rounded">Save</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    <div class="row">
        <div class="col-md-10">
            <form action="" method="POST">
            <input type="hidden" value="{{$picked->customer_id}}" id="customer_idhidden">
            <textarea placeholder="Add Note" id="NoteCustomer" rows="5" style="width:50%;"  onblur="addreadonly()">{{$picked->notes}}</textarea>
            </form>
            <script>
                
                function addreadonly(){
                   
                    var id=document.getElementById('customer_idhidden').value;
                    var note=document.getElementById('NoteCustomer').value;
                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('update_customer_note') }}',                
                        data: {id:id,note:note,_token: '{{csrf_token()}}'},
                    success: function(data) {
                        if(data==1){
                            swal({title: "Done!", text: "Customer Note updated.", type: 
                                "success"}).then(function(){ 
                                location.reload();
                                }
                                );
                        }
                        else if(data==0){
                            swal({title: "Error!", text: "Failed to update Customer Note.", type: 
                                "success"}).then(function(){ 
                                location.reload();
                                }
                                );
                        }
                                        
                    }
                    });
                }
            </script>
        </div>
        <div class="col-md-2">
                <div style="padding-bottom:20px">
                    <div class="stage__insight--open padding-left-10px" style="border-left:5px solid #f2b835;padding-left:10px;">
                        <div class="amount" data-qbo-bind="text: openBalanceText">PHP0.00</div>
                        <div ><small>OPEN</small></div>
                    </div>
                </div>
                <div style="padding-bottom:20px">
                    <div class="stage__insight--open padding-left-10px" style="border-left:5px solid #ce5133;padding-left:10px;">
                        <div class="amount" data-qbo-bind="text: openBalanceText">PHP0.00</div>
                        <div ><small>OVERDUE</small></div>
                    </div>
                </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Transaction List</a>
                          <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Customer Details</a>
                          
                    </div>
                </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <br><br>
                                <h5>Sales Transactions</h5>
                                <table id="customertransactiontable" class="table table-bordered table-responsive-md table-striped text-center font14" width="100%">
                                    <thead>
                                        
                                        <th class="text-center">DATE</th>
                                        <th class="text-center">TYPE</th>
                                        <th class="text-center">NO.</th>
                                        
                                        <th class="text-center">DUE-DATE</th>
                                        <th class="text-center">BALANCE</th>
                                        <th class="text-center">TOTAL</th>
                                        <th class="text-center">STATUS</th>
                                        
                                    </thead>
                                    <tbody>
                                        @foreach($sales_transaction as $et)
                                            <tr>
                                            
                                                <td class="vertical-align:middle">{{date('m-d-Y',strtotime($et->st_date))}}</td>
                                                <td class="vertical-align:middle">{{$et->st_type}}</td>
                                               
                                                <td class="vertical-align:middle">{{$et->st_no}}</td>
                                                <td class="vertical-align:middle">{{$et->st_due_date!=""? date('m-d-Y',strtotime($et->st_due_date)) : '' }}</td>
                                                <td class="vertical-align:middle">PHP {{number_format($et->st_balance,2)}}</td>
                                                <td class="vertical-align:middle">PHP {{number_format($et->st_balance+$et->st_amount_paid,2)}}</td>
                                                <td class="vertical-align:middle">{{$et->st_status}}</td>
                                                
                                            </tr>
                                        @endforeach
                                        
                                    </tbody>    
                                       
                                </table>
                                <br><br>
                                <h5>Expense Transactions</h5>
                                <table id="suppliertransactiontablecustomer" class="table table-bordered table-responsive-md table-striped text-center font14" width="100%">
                                    <thead>
                                        
                                        <th style="vertical-align:middle;"  class="text-center">DATE</th>
                                        <th style="vertical-align:middle;"  class="text-center">TYPE</th>
                                        <th style="vertical-align:middle;"  class="text-center">NO.</th>
                                        <th  style="vertical-align:middle;" class="text-center">RF</th>
                                        <th  style="vertical-align:middle;" class="text-center">PO</th>
                                        <th  style="vertical-align:middle;" class="text-center">CI</th>
                                        <th style="vertical-align:middle;"  class="text-center">PAYEE</th>
                                        <th style="vertical-align:middle;"  class="text-center">CATEGORY</th>
                                        <th style="vertical-align:middle;"  class="text-center">DEBIT</th>
                                        <th style="vertical-align:middle;"  class="text-center">CREDIT</th>
                                        
                                    </thead>
                                    <tbody>
                                        @foreach($expense_transactions as $et)
                                        @if ($et->et_type==$et->et_ad_type)
                                            
                                        
                                        <tr>
                                            
                                            <td style="vertical-align:middle;"  class="pt-3-half">{{date('m-d-Y',strtotime($et->et_date))}}</td>
                                            <td style="vertical-align:middle;"  class="pt-3-half">{{$et->et_type}}</td>
                                            <td style="vertical-align:middle;"  class="pt-3-half">{{$et->et_no}}</td>
                                            <td class="pt-3-half"  style="vertical-align:middle;">
                                                {{$et->et_shipping_address}}
                                                
                                            </td>
                                            <td class="pt-3-half"  style="vertical-align:middle;">
                                                
                                                {{$et->et_shipping_to}}
                                            
                                            </td>
                                            <td class="pt-3-half"  style="vertical-align:middle;">
                                            
                                                {{$et->et_shipping_via}}
                                            </td>
                                            <td style="vertical-align:middle;"  class="pt-3-half">{{$et->f_name." ".$et->l_name}}</td>
                                            <td style="vertical-align:middle;"  class="pt-3-half">
                                                @foreach ($COA as $coa)
                                                @if($et->et_ad_product==$coa->id)
                                                {{$coa->coa_name}}
                                                @endif
                                                @endforeach
                                                
                                            </td>
                                            <td style="vertical-align:middle;"  class="pt-3-half">PHP {{number_format($et->et_ad_total,2)}}</td>
                                            <td style="vertical-align:middle;"  class="pt-3-half"></td>
                                            
                                        </tr>
                                        @foreach ($PayBill as $PB)
                                        
                                        @if ($PB->bill_no==$et->et_no)
                                            <tr>
                                                
                                                <td style="vertical-align:middle;"  class="pt-3-half">{{date('m-d-Y',strtotime($et->et_date))}}</td>
                                                <td style="vertical-align:middle;"  class="pt-3-half">{{"Bill Payment"}}</td>
                                                <td style="vertical-align:middle;"  class="pt-3-half">{{$et->et_no}}</td>
                                                <td class="pt-3-half"  style="vertical-align:middle;">
                                                    {{$et->et_shipping_address}}
                                                    
                                                </td>
                                                <td class="pt-3-half"  style="vertical-align:middle;">
                                                    
                                                    {{$et->et_shipping_to}}
                                                
                                                </td>
                                                <td class="pt-3-half"  style="vertical-align:middle;">
                                                
                                                    {{$et->et_shipping_via}}
                                                </td>
                                                <td style="vertical-align:middle;"  class="pt-3-half">{{$et->f_name." ".$et->l_name}}</td>
                                                <td style="vertical-align:middle;"  class="pt-3-half">
                                                    @foreach ($COA as $coa)
                                                    @if($et->et_ad_product==$coa->id)
                                                    {{$coa->coa_name}}
                                                    @endif
                                                    @endforeach
                                                    
                                                </td>
                                                <td style="vertical-align:middle;"  class="pt-3-half"></td>
                                                <td style="vertical-align:middle;"  class="pt-3-half">PHP {{number_format($PB->bill_payment_amount,2)}}</td>
                                                
                                            </tr>
                                        @endif
                                        @endforeach
                                        @endif
                                    @endforeach
                                        
                                    </tbody>     
                                       
                                </table>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <br>
                            <div class="row">
                                <div class="col-md-12" style="text-align:right;">
                                    <button class="btn btn-dark" onclick="edit_customer_openModal('editcustomermodal')">Edit</button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table" style="font-size:.8em">
                                        <tr>
                                            <td width="30%" style="font-weight:bold;">Customer</td>
                                            <td>
                                                    @if($picked->display_name!="")
                                                    {{$picked->display_name}}
                                                    @else
                                                    {{$picked->f_name." ".$picked->l_name}}
                                                    @endif    
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="30%" style="font-weight:bold;">Email</td>
                                            <td>
                                                    <a href="#" class="text-info">{{$picked->email}}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="30%" style="font-weight:bold;">Phone</td>
                                            <td>{{$picked->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td width="30%" style="font-weight:bold;">Mobile</td>
                                            <td>{{$picked->mobile}}</td>
                                        </tr>
                                        <tr>
                                            <td width="30%" style="font-weight:bold;">Fax</td>
                                            <td>{{$picked->fax}}</td>
                                        </tr>
                                        <tr>
                                            <td width="30%" style="font-weight:bold;">Website</td>
                                            <td>{{$picked->website}}</td>
                                        </tr>
                                        <tr>
                                            <td width="30%" style="font-weight:bold;">Note</td>
                                            <td>{{$picked->notes}}</td>
                                        </tr>   
                                    </table>
                                </div>
                                <div class="col-md-6">
                                        <table class="table" style="font-size:.8em">
                                            <tr>
                                                <td width="30%" style="font-weight:bold;">TIN No.</td>
                                                <td>{{$picked->tin_no}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="font-weight:bold;">Withhold Tax</td>
                                                <td>{{$picked->withhold_tax."%"}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="font-weight:bold;">Billing Address</td>
                                                <td>{{$picked->street}}
                                                    <br>{{$picked->city.",".$picked->state}}
                                                    <br>{{$picked->postal_code}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="font-weight:bold;">Shipping Address</td>
                                                <td>{{$picked->street}}
                                                    <br>{{$picked->city.",".$picked->state}}
                                                    <br>{{$picked->postal_code}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="font-weight:bold;">Term</td>
                                                <td>{{$picked->terms}}</td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="font-weight:bold;">Payment Method</td>
                                                <td>{{$picked->payment_method}}</td>
                                            </tr>

                                        </table>
                                    </div>
                            </div>
                        </div>
                        
                    </div>
        </div>
    </div>
</div>
<style>

.amount{
    font-family: "Geogrotesque", "Arial", -apple-system, "Helvetica Neue Bold", sans-serif;
    font-weight: 500;
    padding:0px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-size: 1.1rem;
    color: black;
    line-height: 0.85;
}

</style>
@endsection
