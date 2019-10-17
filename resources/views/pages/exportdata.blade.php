@extends('layout.initial')


@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Export Data</h1>
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
<div class="col-md-1"></div>
    <div class="col-md-10 ">
        <h5>What do you want to export?</h5>
        <p>Add or remove items, pick your file type. and set your date range to get just what you need.</p>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Lists</a>
            </li>
        </ul>
        <div class="tab-content p-0 col-md-10" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <select class="my-2">
                    <option>All Dates</option>
                    <option>Custom</option>
                    <option>Last Calendar Quarter</option>
                    <option>This Tear-to-Date</option>
                    <option>Last Year</option>
                </select>
                <div class="col-md-12 card d-inline p-3 my-1">
                    <div class="col-md-6">
                        <h6>General Ledger</h6>
                    </div>
                    <div class="col-md-6"><label class="switch switch-3d switch-success mr-3 float-right"><input type="checkbox" class="switch-input" checked="true"> <span class="switch-label"></span> <span class="switch-handle"></span></label></div>
                </div>
                <div class="col-md-12 card d-inline p-3 my-1">
                    <div class="col-md-6">
                        <h6>Profit and Loss</h6>
                    </div>
                    <div class="col-md-6"><label class="switch switch-3d switch-success mr-3 float-right"><input type="checkbox" class="switch-input" checked="true"> <span class="switch-label"></span> <span class="switch-handle"></span></label></div>
                </div>
                <div class="col-md-12 card d-inline p-3 my-1">
                    <div class="col-md-6">
                        <h6>Balance Sheet</h6>
                    </div>
                    <div class="col-md-6"><label class="switch switch-3d switch-success mr-3 float-right"><input type="checkbox" class="switch-input" checked="true"> <span class="switch-label"></span> <span class="switch-handle"></span></label></div>
                </div>
                <div class="col-md-12 card d-inline p-3 my-1">
                    <div class="col-md-6">
                        <h6>Trial Balance</h6>
                    </div>
                    <div class="col-md-6"><label class="switch switch-3d switch-success mr-3 float-right"><input type="checkbox" class="switch-input" checked="true"> <span class="switch-label"></span> <span class="switch-handle"></span></label></div>
                </div>
                <div class="col-md-12 card d-inline p-3 my-1">
                    <div class="col-md-6">
                        <h6>Journal</h6>
                    </div>
                    <div class="col-md-6"><label class="switch switch-3d switch-success mr-3 float-right"><input type="checkbox" class="switch-input" checked="true"> <span class="switch-label"></span> <span class="switch-handle"></span></label></div>
                </div>
            </div>
            <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="col-md-12 card d-inline p-3 my-1">
                    <div class="col-md-6">
                        <h6>Customers</h6>
                    </div>
                    <div class="col-md-6"><label class="switch switch-3d switch-success mr-3 float-right"><input type="checkbox" class="switch-input" checked="true"> <span class="switch-label"></span> <span class="switch-handle"></span></label></div>
                </div>
                <div class="col-md-12 card d-inline p-3 my-1">
                    <div class="col-md-6">
                        <h6>Employees</h6>
                    </div>
                    <div class="col-md-6"><label class="switch switch-3d switch-success mr-3 float-right"><input type="checkbox" class="switch-input" checked="true"> <span class="switch-label"></span> <span class="switch-handle"></span></label></div>
                </div>
                <div class="col-md-12 card d-inline p-3 my-1">
                    <div class="col-md-6">
                        <h6>Suppliers</h6>
                    </div>
                    <div class="col-md-6"><label class="switch switch-3d switch-success mr-3 float-right"><input type="checkbox" class="switch-input" checked="true"> <span class="switch-label"></span> <span class="switch-handle"></span></label></div>
                </div>
            </div>
        </div>
    </div>
@endsection