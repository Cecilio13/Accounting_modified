@extends('layout.initial')


@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Taxes</h1>
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
    <div class="row py-4">
        <div class="col-sm-8">
            <div class="row">
                <div class="values col text-center">
                    <h3>PHP0.00</h3>
                    <p class="subcap">88/88/8888 - 88/88/8888</p>
                </div>
            </div>
            <div class="row">
                <div class="values col-sm-6 text-center">
                    <h3>PHP0.00</h3>
                    <p class="subcap ">COLLECTED ON SALES</p>
                </div>
                <div class="values col-sm-6 text-center">
                    <h3>PHP0.00</h3>
                    <p class="subcap">ADJUSTMENTS</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4 d-flex status-message">
            <img src="{{asset('images/check-green.png')}}" style="height:50px;" class="status-icon">
            <div>
                <h6>Great work</h6>
                <p class="w-75">You’re current on your returns and payments.</p>                        
            </div>
        </div>
    </div>
</div>

<div class="card-body">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Returns</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Payments</a>
      </li>
      <select class="form-control view-reports" style="width:30%;float:right;">
        <option>View Reports</option>
        <option>Taxable sales summary</option>
        <option>Transactions without sales tax</option>
        <option>Profit and loss</option>
      </select>
  </ul>
<div class="tab-content pl-3 p-1" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div id="table" class="table-editable">
            <!-- Button trigger modal -->
            <!-- <span class="table-add float-right mb-3 mr-2"><button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#staticModal">New Rule</button></span> -->
            <table class="table table-bordered table-responsive-md table-striped text-center font14">
                <tr>
                    <th class="text-center"><input type="checkbox" name=""></th>
                    <th class="text-center">START DATE</th>
                    <th class="text-center">END DATE</th>
                    <th class="text-center">FILE DATE</th>
                    <th class="text-center">AMOUNT DUE</th>
                    <th class="text-center">PAYMENTS</th>
                    <th class="text-center">BALANCE</th>
                    <th class="text-center">STATUS</th>
                    <th class="text-center">ACTION</th>
                </tr>
                <tr>
                    <td class="pt-3-half" contenteditable="true"><input type="checkbox" name=""></td>
                    <td class="pt-3-half" contenteditable="true">7/26/2018</td>
                    <td class="pt-3-half" contenteditable="true">7/26/2018</td>
                    <td class="pt-3-half" contenteditable="true"></td>
                    <td class="pt-3-half" contenteditable="true">PHP888.88</td>
                    <td class="pt-3-half" contenteditable="true">PHP888.88</td>
                    <td class="pt-3-half" contenteditable="true">PHP888.88</td>
                    <td class="pt-3-half" contenteditable="true">Open</td>
                    <td class="pt-3-half" contenteditable="true">
                      <select>
                        <option>View Summary</option>
                        <option>View details</option>
                        <option>View exception details</option>
                      </select>
                    </td>
                </tr>
                <!-- This is our clonable table line -->
            </table>
            <div class="pagination float-right">
                <a class="pl-2 active" href="#">&laquo;First</a>
                <a class="pl-2" href="#">Previous</a>
                <a class="pl-2">1-1 of 1</a>
                <a class="pl-2" href="#">Next</a>
                <a class="pl-2" href="#">Last&raquo;</a>
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
            <div class="float-left">
                <select>
                    <option value="" disabled selected>Batch Actions</option>
                    <option>Print Transactions</option>
                    <option>Print Packing Slip</option>
                    <option>Send Transactions</option>
                    <option>Send Reminders</option>
                </select>
            </div>
            <div class="d-inline-flex float-right">
                <button class="btn btn-success rounded"><a href="invoice.php" class="text-white" data-toggle="modal" data-target="#invoicemodal">Record Payment</a></button>
            </div>
            <table class="table table-bordered table-responsive-md table-striped text-center font14">
                <tr>
                    <th class="text-center"><input type="checkbox" name=""></th>
                    <th class="text-center">DATE</th>
                    <th class="text-center">TYPE</th>
                    <th class="text-center">TAX PERIOD</th>
                    <th class="text-center">AMOUNT</th>
                    <th class="text-center">MEMO</th>
                    <th class="text-center">ACTION</th>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <!-- This is our clonable table line -->
            </table>
            <div class="pagination float-right">
                <a class="pl-2 active" href="#">&laquo;First</a>
                <a class="pl-2" href="#">Previous</a>
                <a class="pl-2">1-1 of 1</a>
                <a class="pl-2" href="#">Next</a>
                <a class="pl-2" href="#">Last&raquo;</a>
            </div>
        </div>
        <div class="modal fade" id="staticModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticModalLabel">Add yeah Rule</h5>
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
</div>
</div>
@endsection