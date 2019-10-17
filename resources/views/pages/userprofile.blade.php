@extends('layout.initial')

@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>User Profile</h1>
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
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Security</a>
        </li>
    </ul>
    <div class="tab-content pl-3 p-1" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="accordion" id="accordionExample">
                <div class="card mb-2"> <!-- ONE -->
                    <div class="card-header p-0 bg-white" id="headingTwo">
                        <!-- <h5 class="mb-0"> -->
                        <div class="col-md-12 py-3">
                            <div class="col-md-4">
                                <p class="font-weight-bold text-left m-0">Name</p>
                            </div>
                            <div class="col-md-4 text-left">
                                <p class="m-0">John Doe</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <p class="text-info collapsed m-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseTwo">Edit</p>
                            </div>
                        </div>
                        <!-- </h5> -->
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="col-md-12 d-inline-flex p-0">
                                <div class="col-md-5 d-inline-flex mb-3">
                                    <p class="m-0">First Name</p>
                                    <input class="ml-3 p-0 m-0" type="text" name="" value="John">
                                </div>
                                <div class="col-md-5 d-inline-flex mb-3">
                                    <p class="m-0">Last Name</p>
                                    <input class="ml-3 p-0 m-0" type="text" name="" value="Doe">
                                </div>
                                <div class="col-md-2 d-inline-flex p-0">
                                    <button class="btn btn-success rounded py-1 py-0 mb-3">Save</button>
                                    <p class="text-info collapsed ml-3" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Cancel</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-2"> <!-- TWO -->
                    <div class="card-header p-0 bg-white" id="headingTwo">
                        <!-- <h5 class="mb-0"> -->
                        <div class="col-md-12 py-3">
                            <div class="col-md-4">
                                <p class="font-weight-bold text-left m-0">User ID</p>
                            </div>
                            <div class="col-md-4 text-left">
                                <p class="m-0">john.doe</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <p class="text-info collapsed m-0" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Edit</p>
                            </div>
                        </div>
                        <!-- </h5> -->
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="col-md-12 d-inline-flex p-0">
                                <div class="col-md-5 d-inline-flex mb-3">
                                    <p class="m-0">User ID</p>
                                    <input class="ml-3 p-0 m-0" type="text" name="" value="john.doe">
                                </div>
                                <div class="col-md-5 d-inline-flex mb-3">
                                    <p class="m-0">Password</p>
                                    <input class="ml-3 p-0 m-0" type="password" name="" value="">
                                </div>
                                <div class="col-md-2 d-inline-flex p-0">
                                    <button class="btn btn-success rounded py-1 py-0 mb-3">Save</button>
                                    <p class="text-info collapsed ml-3" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Cancel</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-2"> <!-- THREE -->
                    <div class="card-header p-0 bg-white" id="headingThree">
                        <!-- <h5 class="mb-0"> -->
                        <div class="col-md-12 py-3">
                            <div class="col-md-4">
                                <p class="font-weight-bold text-left m-0">Email Address</p>
                            </div>
                            <div class="col-md-4 text-left">
                                <p class="m-0">john.doe@mail.com</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <p class="text-info collapsed m-0" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Edit</p>
                            </div>
                        </div>
                        <!-- </h5> -->
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="col-md-12 d-inline-flex p-0">
                                <div class="col-md-4 d-inline-flex mb-3 mr-3 p-0">
                                    <p class="m-0">Email Address</p>
                                    <input class="ml-3 p-0 m-0" type="email" name="" value="john.doe@gmail.com">
                                </div>
                                <div class="col-md-4 d-inline-flex mb-3 mr-3 p-0">
                                    <p class="m-0">Confirm Email</p>
                                    <input class="ml-3 p-0 m-0" type="email" name="" value="">
                                </div>
                                <div class="col-md-4 d-inline-flex mb-3 mr-3 p-0">
                                    <p class="m-0">Password</p>
                                    <input class="ml-3 p-0 m-0" type="password" name="" value="">
                                </div>
                            </div>

                            <div class="col-md-2 d-inline-flex p-0 float-right">
                                <button class="btn btn-success rounded py-1 py-0 mb-3">Save</button>
                                <p class="text-info collapsed ml-3" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Cancel</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-2"> <!-- FOUR -->
                    <div class="card-header p-0 bg-white" id="headingFour">
                        <!-- <h5 class="mb-0"> -->
                        <div class="col-md-12 py-3">
                            <div class="col-md-4">
                                <p class="font-weight-bold text-left m-0">Address</p>
                            </div>
                            <div class="col-md-4 text-left">
                                <p class="m-0">Street, Street Address, City, State Zip Code, Country, Main</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <p class="text-info collapsed m-0" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Edit</p>
                            </div>
                        </div>
                        <!-- </h5> -->
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="col-md-12 d-inline-flex p-0 w-100">
                                <div class="col-md-3 mb-3 p-0"><p class="m-0">Street</p></div>
                                <div class="col-md-3"><input class="mr-3 p-0 m-0 w-100" type="text" name="" value="Street"></div>
                                <div class="col-md-3 mb-3"><p class="m-0">Zip Code</p></div>
                                <div class="col-md-3 mb-3"><input class="mr-3 p-0 m-0 w-100" type="text" name="" value="90210"></div>
                            </div>
                            <div class="col-md-12 d-inline-flex p-0 w-100">
                                <div class="col-md-3 mb-3 p-0"><p class="m-0">Street Address (Optional)</p></div>
                                <div class="col-md-3"><input class="mr-3 p-0 m-0 w-100" type="text" name="" value="Street Address"></div>
                                <div class="col-md-3 mb-3"><p class="m-0">Country</p></div>
                                <div class="col-md-3 mb-3"><input class="mr-3 p-0 m-0 w-100" type="text" name="" value="United States"></div>
                            </div>
                            <div class="col-md-12 d-inline-flex p-0 w-100">
                                <div class="col-md-3 mb-3 p-0"><p class="m-0">City</p></div>
                                <div class="col-md-3"><input class="mr-3 p-0 m-0 w-100" type="text" name="" value="City"></div>
                                <div class="col-md-3 mb-3"><p class="m-0">Address Type</p></div>
                                <div class="col-md-3 mb-3">
                                    <select class="mr-3 p-0 m-0 w-100">
                                        <option>Main</option>
                                        <option>Work</option>
                                        <option>Home</option>
                                        <option>Billing</option>
                                        <option>Shipping</option>
                                        <option>Purchase Order</option>
                                        <option>E-Check</option>
                                        <option>Other</option>
                                        <option>No Address Type</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 d-inline-flex p-0 w-100">
                                <div class="col-md-3 mb-3 p-0"><p class="m-0">State</p></div>
                                <div class="col-md-3"><input class="mr-3 p-0 m-0  w-100" type="text" name="" value="California"></div>
                                <div class="col-md-3 mb-3 p-0"><p class="m-0"></p></div>
                                <div class="col-md-3 d-inline-flex mb-3">
                                    <button class="btn btn-success rounded py-1 py-0 mb-3">Save</button>
                                    <p class="text-info collapsed ml-3" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Cancel</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================================================== SECOND TAB--> 
        <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="accordion" id="accordionExample">
                <div class="card mb-2"> <!-- FIVE -->
                    <div class="card-header p-0 bg-white" id="headingFive">
                        <!-- <h5 class="mb-0"> -->
                        <div class="col-md-12 py-3">
                            <div class="col-md-4">
                                <p class="font-weight-bold text-left m-0">Password</p>
                            </div>
                            <div class="col-md-4 text-left">
                                <p class="m-0">**********</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <p class="text-info collapsed m-0" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Edit</p>
                            </div>
                        </div>
                        <!-- </h5> -->
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="col-md-12 p-0">

                                <div class="col-md-12">
                                    <div class=" center-content my-3">
                                        <p class="m-0">Current Password</p>
                                        <input class="ml-3 p-0 m-0 float-right" type="password" name="" value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class=" center-content my-3">
                                        <p class="m-0">New Password</p>
                                        <input class="ml-3 p-0 m-0 float-right" type="password" name="" value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class=" center-content my-3">
                                        <p class="m-0">Confrim New Password</p>
                                        <input class="ml-3 p-0 m-0 float-right" type="password" name="" value="">
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-2 d-inline-flex p-0 float-right">
                                <button class="btn btn-success rounded py-1 py-0 mb-3">Save</button>
                                <p class="text-info collapsed ml-3" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Cancel</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-2"> <!-- SIX -->
                    <div class="card-header p-0 bg-white" id="headingSix">
                        <!-- <h5 class="mb-0"> -->
                        <div class="col-md-12 py-3">
                            <div class="col-md-4">
                                <p class="font-weight-bold text-left m-0">Two-step verification</p>
                            </div>
                            <div class="col-md-4 text-left">
                                <p class="m-0 text-info">Turn On</p>
                            </div>
                            <!-- <div class="col-md-4 text-right">
                                <p class="text-info collapsed m-0" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">Edit</p>
                            </div> -->
                        </div>
                        <!-- </h5> -->
                    </div>
                    <!-- <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="col-md-12 d-inline-flex p-0">
                                <div class="col-md-5 d-inline-flex mb-3"></div>
                                <div class="col-md-5 d-inline-flex mb-3">
                                    <p class="m-0">User ID</p>
                                    <input class="ml-3 p-0 m-0" type="text" name="" value="john.doe">
                                </div>
                                
                                <div class="col-md-2 d-inline-flex p-0">
                                    <button class="btn btn-success rounded py-1 py-0 mb-3">Save</button>
                                    <p class="text-info collapsed ml-3" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSoix">Cancel</p>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>

                <div class="card mb-2"> <!-- SEVEN -->
                    <div class="card-header p-0 bg-white" id="headingSeven">
                        <!-- <h5 class="mb-0"> -->
                        <div class="col-md-12 py-3">
                            <div class="col-md-4">
                                <p class="font-weight-bold text-left m-0">Phone</p>
                            </div>
                            <div class="col-md-4 text-left">
                                <p class="m-0">+63 912345678</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <p class="text-info collapsed m-0" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">Edit</p>
                            </div>
                        </div>
                        <!-- </h5> -->
                    </div>
                    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="col-md-12 d-inline-flex p-0">
                                <div class="col-md-4 d-inline-flex mb-3 mr-3 p-0">
                                </div>
                                <div class="col-md-4 mb-3 mr-3 p-0">
                                    <p class="m-0">+63 912345678</p> <br>

                                    <p>Verify your phone number. This will help keep your account safe and secure. We will use your preferred method to help you login if you lose your password.</p>


                                    <button class="btn btn-primary rounded py-1 py-0 mb-3">Continue</button>

                                </div>
                            </div>

                            <div class="col-md-2 p-0 float-right">
                                
                                <p class="text-info collapsed float-right mr-2" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">Cancel</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-2"> <!-- EIGHT -->
                    <div class="card-header p-0 bg-white" id="headingEight">
                        <!-- <h5 class="mb-0"> -->
                        <div class="col-md-12 py-3">
                            <div class="col-md-4">
                                <p class="font-weight-bold text-left m-0">Linked Identities</p>
                            </div>
                            <div class="col-md-4 text-left">
                                <p class="m-0">You do not have any linked identities.</p>
                            </div>
                        </div>
                        <!-- </h5> -->
                    </div>
                    <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="col-md-12 d-inline-flex p-0 w-100">
                                <div class="col-md-3 mb-3 p-0"><p class="m-0">Street</p></div>
                                <div class="col-md-3"><input class="mr-3 p-0 m-0 w-100" type="text" name="" value="Street"></div>
                                <div class="col-md-3 mb-3"><p class="m-0">Zip Code</p></div>
                                <div class="col-md-3 mb-3"><input class="mr-3 p-0 m-0 w-100" type="text" name="" value="90210"></div>
                            </div>
                            <div class="col-md-12 d-inline-flex p-0 w-100">
                                <div class="col-md-3 mb-3 p-0"><p class="m-0">Street Address (Optional)</p></div>
                                <div class="col-md-3"><input class="mr-3 p-0 m-0 w-100" type="text" name="" value="Street Address"></div>
                                <div class="col-md-3 mb-3"><p class="m-0">Country</p></div>
                                <div class="col-md-3 mb-3"><input class="mr-3 p-0 m-0 w-100" type="text" name="" value="United States"></div>
                            </div>
                            <div class="col-md-12 d-inline-flex p-0 w-100">
                                <div class="col-md-3 mb-3 p-0"><p class="m-0">City</p></div>
                                <div class="col-md-3"><input class="mr-3 p-0 m-0 w-100" type="text" name="" value="City"></div>
                                <div class="col-md-3 mb-3"><p class="m-0">Address Type</p></div>
                                <div class="col-md-3 mb-3">
                                    <select class="mr-3 p-0 m-0 w-100">
                                        <option>Main</option>
                                        <option>Work</option>
                                        <option>Home</option>
                                        <option>Billing</option>
                                        <option>Shipping</option>
                                        <option>Purchase Order</option>
                                        <option>E-Check</option>
                                        <option>Other</option>
                                        <option>No Address Type</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 d-inline-flex p-0 w-100">
                                <div class="col-md-3 mb-3 p-0"><p class="m-0">State</p></div>
                                <div class="col-md-3"><input class="mr-3 p-0 m-0  w-100" type="text" name="" value="California"></div>
                                <div class="col-md-3 mb-3 p-0"><p class="m-0"></p></div>
                                <div class="col-md-3 d-inline-flex mb-3">
                                    <button class="btn btn-success rounded py-1 py-0 mb-3">Save</button>
                                    <p class="text-info collapsed ml-3" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">Cancel</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-2"> <!-- NINE -->
                    <div class="card-header p-0 bg-white" id="headingNine">
                        <!-- <h5 class="mb-0"> -->
                        <div class="col-md-12 py-3">
                            <div class="col-md-4">
                                <p class="font-weight-bold text-left m-0">Account Activity</p>
                            </div>
                            <div class="col-md-4 text-left">
                                <p class="m-0">QuickBooks, Near: National Capital Region, Philippines</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <p class="text-info collapsed m-0" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">View</p>
                            </div>
                        </div>
                        <!-- </h5> -->
                    </div>
                    <!-- <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="col-md-12 d-inline-flex p-0">
                                <div class="col-md-4 d-inline-flex mb-3 mr-3 p-0">
                                </div>
                                <div class="col-md-4 mb-3 mr-3 p-0">
                                    <p class="m-0">+63 912345678</p> <br>

                                    <p>Verify your phone number. This will help keep your account safe and secure. We will use your preferred method to help you login if you lose your password.</p>


                                    <button class="btn btn-primary rounded py-1 py-0 mb-3">Continue</button>

                                </div>
                            </div>

                            <div class="col-md-2 p-0 float-right">
                                
                                <p class="text-info collapsed float-right mr-2" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">Close</p>
                            </div>
                        </div>
                    </div> -->
                </div>

            </div>
        </div>
    </div>
</div>
@endsection