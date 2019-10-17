@extends('layout.initial')


@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Attachments</h1>
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
            <div class="d-inline-flex">
                <p class="fa fa-paperclip"></p>
                <p class="p-0 ml-1">Maximum Size: 20MB</p>
            </div>
            <div class="col-md-12 m-0 p-0">
                <div class="input-group mb-3 p-0">
                    <!-- <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                        </div> -->
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label bg-transparent" for="inputGroupFile01">Choose file</label>
                    </div>
                </div>
            </div>
            <div id="table" class="table-editable">
                <div class="col-md-12 p-0 mb-2">
                    <select class="bg-transparent">
                        <option value="" disabled selected>Batch Actions</option>
                        <option>Export</option>
                        <option>Create Invoice</option>
                        <option>Create Expense</option>
                    </select>
                </div>
                <table class="table table-bordered table-responsive-md table-striped text-center font14">
                    <tr>
                        <th class="text-center"><input type="checkbox" name=""></th>
                        <th class="text-center">THUMBNAIL</th>
                        <th class="text-center">TYPE</th>
                        <th class="text-center">NAME</th>
                        <th class="text-center">SIZE</th>
                        <th class="text-center">UPLOADED</th>
                        <th class="text-center">LINKS</th>
                        <th class="text-center">NOTE</th>
                        <th class="text-center">ACTION</th>
                    </tr>
                    <tr>
                        <td class="pt-3-half" contenteditable="true"><input type="checkbox" name=""></td>
                        <td class="pt-3-half" contenteditable="false"></td>
                        <td class="pt-3-half" contenteditable="false">Image</td>
                        <td class="pt-3-half" contenteditable="false">15.20KB</td>
                        <td class="pt-3-half" contenteditable="false"></td>
                        <td class="pt-3-half" contenteditable="false"></td>
                        <td class="pt-3-half" contenteditable="false"></td>
                        <td class="pt-3-half" contenteditable="false"></td>
                        <td>
                            <!-- <span class="table-add mb-3 mr-2"><a href="#!" class="text-info"><i aria-hidden="true" data-target="#receiveModal">Download</i></a></span>
                                <select>
                                <option></option>
                                <option>Edit</option>
                                <option>Delete</option>
                                <option>Create Invoice</option>
                                <option>Create Expense</option>
                                </select> -->
                            <!-- Split button -->
                            <div class="btn-group">
                                <button type="button" class="btn bg-transparent text-info p-0">Download</button>
                                <button type="button" class="btn bg-transparent dropdown-toggle px-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Edit</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                    <a class="dropdown-item" href="#">Create Invoice</a>
                                    <a class="dropdown-item" href="#">Create Expense</a>
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
        </div>
    </div>
</div>
@endsection