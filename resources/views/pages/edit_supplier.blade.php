@extends('layout.initial')


@section('content')
<form action="{{ action('SuppliersController@update',['id'=>$supplier->supplier_id]) }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
        <div class="container">
            <h1>Edit Supplier Information</h1>
            <div class="col-md-6 p-0">
                <div class="col-md-6 p-0 pr-1">
                    <p>First Name</p>
                    <input type="text" name="fname" value="{{$supplier->f_name}}" class="w-100">
                </div>
                <div class="col-md-6 p-0 pl-1">
                    <p>Last Name</p>
                <input type="text" name="lname" value="{{$supplier->l_name}}" class="w-100">
                </div>

                <div class="col-md-12 p-0">
                    <p>Company</p>
                    <input type="text" name="company" value="{{$supplier->company}}" class="w-100">
                </div>

                <div class="col-md-12 p-0">
                    <p>Display name as</p>
                    <input id="suppliername" type="text" value="{{$supplier->display_name}}" name="displayname" class="w-100">
                </div>

                <div class="col-md-12 p-0">
                    <p>Address</p>
                    <textarea rows="2" class="w-100" name="street"  placeholder="Street">{{$supplier->street}}</textarea>
                </div>

                <div class="col-md-6 p-0 pr-1 pb-1">
                    <input type="text" name="city" value="{{$supplier->city}}" placeholder="City/Town" class="w-100">
                </div>
                <div class="col-md-6 p-0 pl-1 pb-1">
                    <input type="text" name="state" value="{{$supplier->state}}" placeholder="State/Province" class="w-100">
                </div>
                <div class="col-md-6 p-0 pr-1">
                    <input type="text" name="postalcode" value="{{$supplier->postal_code}}" placeholder="Postal Code" class="w-100">
                </div>
                <div class="col-md-6 p-0 pl-1" >
                    <input type="text" name="country" value="{{$supplier->country}}" placeholder="Country" class="w-100">
                </div>

                <div class="col-md-12 p-0">
                    <p>Notes</p>
                    <textarea rows="2" name="notes" class="w-100">{{$supplier->notes}}</textarea>
                </div>

                
            </div>



            <div class="col-md-6 p-0 pl-1">
                <div class="col-md-12 p-0">
                    <p>Email</p>
                    <input type="email" name="email" class="w-100" value="{{$supplier->email}}" placeholder="separate multiple emails with commas">
                </div>

                <div class="col-md-12 p-0">
                    <div class="col-md-4 p-0 pr-1">
                        <p>Phone</p>
                        <input id="supplierphone" type="text" value="{{$supplier->phone}}" name="phone" class="w-100">
                    </div>
                    <div class="col-md-4 p-0 pr-1">
                        <p>Mobile</p>
                        <input type="text" name="mobile" value="{{$supplier->mobile}}" class="w-100">
                    </div>
                    <div class="col-md-4 p-0">
                        <p>Fax</p>
                        <input type="text" name="fax" value="{{$supplier->fax}}" class="w-100">
                    </div>
                </div>

                <div class="col-md-12 p-0">
                    <div class="col-md-4 p-0 pr-1">
                        <p>Other</p>
                        <input type="text" name="other" value="{{$supplier->other}}" class="w-100">
                    </div>
                    <div class="col-md-8 p-0">
                        <p>Website</p>
                        <input type="text" value="{{$supplier->website}}" name="website" class="w-100">
                    </div>
                </div>

                <div class="col-md-12 p-0">
                    <div class="col-md-6 p-0 pr-1">
                        <p>Billing rate (/hr)</p>
                        <input type="number" name="billingrate" value="{{$supplier->billing_rate}}"  class="w-100">
                    </div>

                    <div class="col-md-6 p-0">
                        <p>Terms</p>
                        <input type="text" name="terms" value="{{$supplier->terms}}" class="w-100">
                    </div>
                </div>

                <div class="col-md-12 p-0">
                    <div class="col-md-6 p-0 pr-1">
                        <p>Opening balance</p>
                        <input type="number" name="balance" value="{{$supplier->opening_balance}}" class="w-100">
                    </div>

                    <div class="col-md-6 p-0">
                        <p>as of</p>
                        <input type="date" name="asof" value="{{$supplier->as_of_date}}" class="w-100">
                    </div>
                </div>

                <div class="col-md-12 p-0">
                    <div class="col-md-6 p-0 pr-1">
                        <p>Account No. </p>
                        <input type="text" name="accountno" value="{{$supplier->account_no}}" class="w-100">
                    </div>

                    <div class="col-md-6 p-0">
                        <p>Business ID No. </p>
                        <input type="text" name="businessno" value="{{$supplier->business_id_no}}" class="w-100">
                    </div>
                </div>

                <div class="col-md-12 p-0" style="display:none;">
                    <p>Attachments</p>
                    <div class="input-group mb-3 p-0">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="fileattachment" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="container row" style="padding-right:0px;">
            <div class="col-md-12" style="text-align:right;padding-right:0px;">
            <button type="reset" class="btn btn-secondary rounded" >Cancel</button>
            <input id="supplieradd" type="submit" class="btn btn-success rounded"  value="Save">
            </div>
        </div>
    </form>


@endsection