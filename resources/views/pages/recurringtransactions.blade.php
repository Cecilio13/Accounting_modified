@extends('layout.initial')


@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Recurring Transactions</h1>
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
    <div class="tab-content pl-3 p-1" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div id="table" class="table-editable">
                <!-- Button trigger modal -->
                <!-- <span class="table-add float-right mb-3 mr-2"><button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#staticModal">New Rule</button></span> -->
                <div class="float-left d-inline-flex mb-2">
                    <p class="mr-1">Template Type</p>
                    <select class="mr-3">
                        <option value="" disabled selected>All</option>
                        <option>Scheduled</option>
                        <option>Reminder</option>
                        <option>Unscheduled</option>
                    </select>
                    <p class="mr-1">Transaction Type</p>
                    <select>
                        <option value="" disabled selected>All</option>
                        <option>Bill</option>
                        <option>Non-Posting Charge</option>
                        <option>Cheque</option>
                        <option>Non-Posting Credit</option>
                        <option>Credit Card Credits</option>
                        <option>Credit Note</option>
                        <option>Estimate</option>
                        <option>Deposit</option>
                        <option>Journal Entry</option>
                        <option>Invoice</option>
                        <option>Refund</option>
                        <option>Sales Receipt</option>
                        <option>Transfer</option>
                        <option>Supplier Credit</option>
                        <option>Expense</option>
                    </select>
                </div>

                <div class="float-right">
                    <select class="mb-3 p-1 mt-2 normalselect" >
                        <option value="" disabled selected>Reminder List</option>
                        <option>Run Report</option>
                    </select>
                    <button class="btn btn-success rounded text-white px-3">New</button>
                </div>

                <div class="col-md-12 p-0 mb-3">
                    <input type="text" name="" placeholder="Filter by Name" class="normalinput">
                    <div class="d-inline-flex float-right">
                        <li class="fa fa-print pl-2"><a href=""></a></li>
                        <li class="fa fa-cog pl-2"><a href=""></a></li>
                    </div>
                </div>
                <table class="table table-bordered table-responsive-md table-striped text-center font14">
                    <tr>
                        <th class="text-center"><input type="checkbox" name=""></th>
                        <th class="text-center">Template Name</th>
                        <th class="text-center">TYPE</th>
                        <th class="text-center">TXN TYPE</th>
                        <th class="text-center">INTERVAL</th>
                        <th class="text-center">PREVIOUS-DATE</th>
                        <th class="text-center">NEXT-DATE</th>
                        <th class="text-center">CUSTOMERS</th>
                        <th class="text-center">AMOUNT</th>
                        <th class="text-center">ACTION</th>
                    </tr>
                    <tr>
                        <td class="pt-3-half" contenteditable="true"><input type="checkbox" name=""></td>
                        <td class="pt-3-half" contenteditable="true">sample Template</td>
                        <td class="pt-3-half" contenteditable="true">Invoice</td>
                        <td class="pt-3-half" contenteditable="true">TEST</td>
                        <td class="pt-3-half" contenteditable="true">3 days</td>
                        <td class="pt-3-half" contenteditable="true">8/1/2018</td>
                        <td class="pt-3-half" contenteditable="true">8/4/2018</td>
                        <td class="pt-3-half" contenteditable="true">Sample </td>
                        <td class="pt-3-half" contenteditable="true">1000.00</td>
                        <td>
                            <span class="table-add mb-3 mr-2"><a href="#!" class="text-info"><i aria-hidden="true">Receive Payment</i></a></span>
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