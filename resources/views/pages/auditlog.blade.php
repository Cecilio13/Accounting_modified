@extends('layout.initial')


@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Dashboard</h1>
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
                <div class="col-md-12 p-0 my-2">
                    <button type="button" class="btn btn-secondary bg-white text-dark rounded mb-1 p-1 px-4" data-toggle="modal" data-target="#filterModal">Filter</button>
                    <div class="d-inline-flex float-right">
                        <li class="fa fa-print pl-2"><a href=""></a></li>
                        <li class="fa fa-cog pl-2"><a href=""></a></li>
                    </div>
                </div>
                <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-lg" role="document">
                        .
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="filterModalLabel">Filter</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12 d-inline-flex p-0">
                                    <p class="float-left my-1 mr-2">Users</p>
                                    <select class="float-right w-200px p-0">
                                        <option>All Users</option>
                                        <option>Support Representative</option>
                                        <option>John Doe</option>
                                        <!-- Current User -->
                                        <option>System Admin</option>
                                    </select>
                                </div>
                                <div class="col-md-4 d-inline-flex p-0 mt-2">
                                    <p class="float-left my-1 mr-2">Type</p>
                                    <select class="float-right w-200px p-0">
                                        <option>All Dates</option>
                                        <option>Custom</option>
                                        <option>Today</option>
                                        <option>Yesterday</option>
                                        <option>This Week</option>
                                        <option>This Month</option>
                                        <option>This Quarter</option>
                                        <option>This Year</option>
                                        <option>Last Week</option>
                                        <option>Last Month</option>
                                        <option>Last Quarter</option>
                                        <option>Last Year</option>
                                    </select>
                                </div>
                                <div class="col-md-4 d-inline-flex p-0">
                                    <p class="float-left my-1 mr-2">From</p>
                                    <input type="date" name="">
                                </div>
                                <div class="col-md-4 d-inline-flex p-0">
                                    <p class="float-left my-1 mr-2">To</p>
                                    <input type="date" name="">
                                </div>
                                <div class="col-md-12 p-0 mt-1">
                                    <p class="float-left my-1 mr-2">Events</p>
                                    <div class="ml-5 mt-1">
                                        <!-- Default checked -->
                                        <div class="custom-control custom-radio ml-2">
                                            <input type="radio" class="custom-control-input" id="showall" name="defaultExampleRadios" checked>
                                            <label class="custom-control-label" for="showall">Show All Events</label>
                                        </div>
                                        <!-- Default unchecked -->
                                        <div class="custom-control custom-radio ml-2">
                                            <input type="radio" class="custom-control-input" id="showfew" name="defaultExampleRadios">
                                            <label class="custom-control-label" for="showfew">Show only these Events</label>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-md-12 d-inline-flex">
                                    <div class="col-md-4 ml-5 mt-1">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check1">
                                            <label class="custom-control-label" for="check1">Sign in/Sign out</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check2">
                                            <label class="custom-control-label" for="check2">Budgets</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check3">
                                            <label class="custom-control-label" for="check3">Recurring Templates</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check4">
                                            <label class="custom-control-label" for="check4">Settings</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check5">
                                            <label class="custom-control-label" for="check5">Reconcilications</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check6">
                                            <label class="custom-control-label" for="check6">Transactions</label>
                                        </div>
                                    </div>
                                    <!-- Second Column -->
                                    <div class="col-md-4 ml-5 mt-1">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check7">
                                            <label class="custom-control-label" for="check7">lists</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check8">
                                            <label class="custom-control-label" for="check8">Time Events</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check9">
                                            <label class="custom-control-label" for="check9">Statements</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check10">
                                            <label class="custom-control-label" for="check10">Sales Customisations</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check11">
                                            <label class="custom-control-label" for="check11">Data Exchange</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 d-inline-flex p-0 ml-5">
                                    <div class="ml-5 mt-1">
                                        <p class="float-left my-1 mr-2">Show: </p>
                                        <select class="float-right w-200px p-0">
                                            <option>All Transactions</option>
                                            <option>Deleted/Voided Transactions</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 d-inline-flex p-0 ml-5">
                                    <div class="ml-5 mt-1">
                                        <p class="float-left my-1 mr-2">Using: </p>
                                        <select class="float-right w-200px p-0">
                                            <option> Select Account</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Reset</button>
                                <button type="button" class="btn btn-success rounded">Apply</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-responsive-md table-striped text-center font14">
                    <tr>
                        <th class="text-center">DATE CHANGED</th>
                        <th class="text-center">USER</th>
                        <th class="text-center">EVENT</th>
                        <th class="text-center">NAME</th>
                        <th class="text-center">DATE</th>
                        <th class="text-center">AMOUNT</th>
                        <th class="text-center">HISTORY</th>
                    </tr>
                    <tr>
                        <td class="pt-3-half" contenteditable="false">Aug 14, 9:51 am</td>
                        <td class="pt-3-half" contenteditable="false">Admin</td>
                        <td class="pt-3-half" contenteditable="false">Added Statement No. 1005</td>
                        <td class="pt-3-half" contenteditable="false">test customer</td>
                        <td class="pt-3-half" contenteditable="false">08/14/2018</td>
                        <td class="pt-3-half" contenteditable="false">1000.00</td>
                        <td class="pt-3-half text-info" contenteditable="false">VIEW</td>
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
        </div>
    </div>
</div>
@endsection