@extends('layout.initial')

@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Expenses</h1>
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
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Banking</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Bank Rules</a>
        </li>
    </ul>
    <div class="tab-content pl-3 p-1" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <h3 class="float-left">Bank and Credit Cards</h3>

            <div class="col-md-12 mt-5">
                <div class="col-md-3"></div>   
                <div class="col-md-5 content-center">
                <!-- <div class="center-content"> -->
                    <h5 class="text-center">Connections you can count on</h5> <br>
                    <p class="text-center">Keep your books accurate with less work. Connect your bank or credit card and we’ll bring in your transactions for you.</p>

                    <div class="col-md-3"></div>
                    <button class="content-center btn btn-success rounded ml-5">Connect</button>

                    
                    <p class="text-center mt-4">At Intuit, the privacy and security of your information are top priorities.</p>
                </div>
            </div>
        </div>
<!-- ======================================================================================================== SECOND TAB--> 

        <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <h3 class="float-left">Rules</h3>

            <div class="btn-group float-right mr-2 mb-3">
                <button type="button" class="btn btn-success rounded-left" data-target="#ruleModal" data-toggle="modal">New Rule</button>
                <button type="button" class="btn btn-success rounded-right dropdown-toggle px-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Import Rules</a>
                    <a class="dropdown-item" href="#">Export Rules</a>
                </div>
            </div>

            <div class="modal fade" id="ruleModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticModalLabel">Add New Rule</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="col-md-12 d-inline-flex">
                                    <div class="col-md-6 w-100">
                                        <div class="padding0">
                                            <p class="float-left text-center">Rule Name</p>
                                            <input id="rulename" name="rulename" type="text" class="float-right w-100">
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

                                <div class="col-md-12 py-3">
                                    <div class="col-md-12">
                                        <div class="d-inline-flex">
                                            <p class="mr-2 m-0">When a transaction meets</p>
                                            <select class="mr-2">
                                                <option>all</option>
                                                <option>any</option>
                                            </select>
                                            <p class="m-0">of these conditions.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 d-inline py-3">
                                    <div class="col-md-3 w-100">
                                        <div class="padding0">
                                            <select id="rule1" class="w-100">
                                                <option>Bank Text</option>
                                                <option>Description</option>
                                                <option>Amount</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 w-100">
                                        <div class="padding0">
                                            <select id="rule2" class="w-100">
                                                <option>Contains</option>
                                                <option>Does not contain</option>
                                                <option>Is Exactly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 w-100">
                                        <div class="padding0">
                                            <input id="rule3" name="rulename" type="text" class="float-right w-100">
                                        </div>
                                    </div>

                                    <div class="col-md-12"><button class="btn btn-success rounded py-1">Add Line</button></div>
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
                                            <select id="setting1" class="w-100">
                                                <option>Money out</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 w-100">
                                        <div class="padding0">
                                            <p>Category</p>
                                            <select id="setting2" class="w-100">
                                                <option>All Bank Accounts</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 py-3">
                                    <div class="col-md-12">
                                        <button class="btn btn-success rounded py-1">Split</button>

                                        <p>Memo</p>
                                        <input name="rulename" type="text" class="w-50"> <br>
                                        <input type="checkbox">Automatically add to my books
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-success rounded" id="ruleadd" data-dismiss="modal">Save</button>
                            </div>
                            <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
                            <script>
                            $(document).ready(function(){
                         
                                $("#ruleadd").click(function(){
                         
                                    var rulename = $("#rulename").val();
                                    var rule1 = $("#rule1").val();
                                    var rule2 = $("#rule2").val();
                                    var rule3 = $("#rule3").val();
                                    var setting1 = $("#setting1").val();
                                    var setting2 = $("#setting2").val();

                                    // var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + name + "</td><td>" + subject + "</td></tr>";

                                    var markup = "<tr><td class='pt-3-half' contenteditable='true'>1</td><td class='pt-3-half' contenteditable='true'>"+rulename+"</td><td class='pt-3-half' contenteditable='true'>"+rule1+": "+rule2+" "+rule3+"</td><td class='pt-3-half' contenteditable='true'>"+setting1 + ": " + setting2+"</td><td class='pt-3-half text-center' contenteditable='true'><a href='' class='fa fa-plus text-success'></a></td><td><div class='btn-group'><button type='button' class='btn bg-transparent text-info p-0'>Edit</button><button type='button' class='btn bg-transparent dropdown-toggle px-0 py-0 mr-4' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span class='sr-only'>Toggle Dropdown</span></button><div class='dropdown-menu'><a class='dropdown-item' href='#'>Copy</a><a class='dropdown-item' href='#'>Delete</a></div></div></td></tr>";
                         
                                $("table tbody").append(markup);
                         
                                });         
                            });    
                        </script>

                        </div>
                    </div>
                </div>
            <div id="table" class="table-editable">
                <!-- Button trigger modal -->
                <!-- <span class="table-add float-right mb-3 mr-2"><button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#staticModal">New Rule</button></span> -->

                <table class="table table-bordered table-responsive-md table-striped text-v font14">
                    <tr>
                        <th class="text-left">NO.</th>
                        <th class="text-left">RULE NAME</th>
                        <th class="text-left">CONDITIONS</th>
                        <th class="text-left">SETTINGS</th>
                        <th class="text-left">AUTO-ADD</th>
                        <th class="text-left">ACTIONS</th>
                    </tr>
                    <tr>
                        <td class="pt-3-half" contenteditable="true">1</td>
                        <td class="pt-3-half" contenteditable="true">Sample Rule</td>
                        <td class="pt-3-half" contenteditable="true">condition</td>
                        <td class="pt-3-half" contenteditable="true">setting</td>
                        <td class="pt-3-half text-center" contenteditable="true"><a href="" class="fa fa-plus text-success"></a></td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn bg-transparent text-info p-0">Edit</button>
                                <button type="button" class="btn bg-transparent dropdown-toggle px-0 py-0 mr-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Copy</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
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

@endsection