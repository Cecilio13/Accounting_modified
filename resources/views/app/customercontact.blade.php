@extends('layout.initial')

@section('content')
<div class="container">
    <script>
        function showcustomizationsection(){
            //document.getElementById('coverdiv').style.display="inline";
            $("#modallike").toggle("slide",function(){
                $(".customizationsection").toggle("slide");
            });
            
        }
        function hidecustomizationsection(){
            $(".customizationsection").toggle("slide",function(){
                $("#modallike").toggle("slide");
            });
        }
    </script>
    <div id="">
    <div id="modallike" onclick="hidecustomizationsection()">
        
    </div>
    <div class="customizationsection">
        <div class="row" style="margin-top:10px;">
            <div class="col-md-10">
                <h4 style="font-weight:400;">Customise report</h4>
            </div>
            <div class="col-md-2" style="text-align:right;">
                <button class="btn btn-link" style="text-decoration: none;color:#ccc" onclick="hidecustomizationsection()"><span class="oi oi-x"></span></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
            <div class="accordion" id="accordionExample">
                <div class="card" style="border:0px solid #ccc;">
                    <div class="card-header" id="headingOne" style="padding:0px;border-bottom:0px solid black;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" style="text-decoration: none;color:#262626;" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <span class="oi oi-caret-bottom"></span> Table Columns
                        </button>
                    </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                    <script>
                        $(document).ready(function(){
                            //tablemain
                            
                            for(var i=6;i<9;i++){
                                $('td:nth-child('+i+'),th:nth-child('+i+')','#tablemain ').hide();
                            }
                            
                        });
                        function hideshowcolumntable(element){
                                var el=element.value;
                                if(element.checked){
                                    $('td:nth-child('+el+'),th:nth-child('+el+')','#tablemain ').toggle();
                                }else{
                                    $('td:nth-child('+el+'),th:nth-child('+el+')','#tablemain ').hide(); 
                                }
                            }
                    </script>
                        
                        
                        
                    </div>
                    </div>
                </div>
                
                </div>
            </div>
        </div>
    </div>
    </div>
<div class="row">
    <div class="col-md-12">
        <h4>Customer Contact List Report</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="reports" class="btn btn-link btn-upper-back" style="padding-left:0px;text-decoration: none;"><span class="oi oi-chevron-left"></span> Back to report list</a>
    </div>
</div>
<!--changes filtersection-->
<div class="row">
    <div class="col-md-10 ">
            <div class="col-md-12" style="background-color: white;padding-top:15px;padding-bottom:15px;padding-left:0px;padding-right:0px;">
                    <div >
                    <div class="col-md-12">
                        <p>Table Columns</p>
                    </div>
                    <div class="col-md-6 ">
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="1" id="customCheck6">
                        <label class="custom-control-label" for="customCheck6">Customer</label>
                        
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="2" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">Phone Number</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="3" id="customCheck2">
                        <label class="custom-control-label" for="customCheck2">Email</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="4" id="customCheck3">
                        <label class="custom-control-label" for="customCheck3">Full Name</label>
                        </div>       
                    </div>
                    <div class="col-md-6 ">
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="5" id="customCheck4">
                        <label class="custom-control-label" for="customCheck4">Billing Address</label>
                        </div>
                        
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" class="custom-control-input" value="6" id="customCheck7">
                        <label class="custom-control-label" for="customCheck7">Shipping Address</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" class="custom-control-input" value="7" id="customCheck8">
                        <label class="custom-control-label" for="customCheck8">Website</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" class="custom-control-input" value="8" id="customCheck5">
                        <label class="custom-control-label" for="customCheck5">Company Name</label>
                        </div>    
                    </div>
                </div>
            </div>  
        
    </div>
    <div class="col-md-2" style="text-align:right;">
        <button style="display:none;" class="btn btn-outline-dark" onclick="showcustomizationsection()">Customize</button>
        <button class="btn btn-success"  data-toggle="modal" data-target="#exampleModal">Save customization</button>
        
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Custom Report</h5>
              <button type="button" onclick=" document.getElementById('InputReportname').value=''" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            
            <div class="modal-body">
                
                <div class="form-group">
                    <label for="InputReportname">Custom Report Name</label>
                    <input type="text" class="form-control" id="InputReportname" placeholder="Enter Custom Report Name">
                    <input type="hidden" id="InputReportID" value="">
                   
                </div>
                
                
            </div>
            <div class="modal-footer">
              <button type="button" id="cancelsavecustom" onclick=" document.getElementById('InputReportname').value=''" class="btn btn-secondary" data-dismiss="modal" >Cancel</button>
              <button type="button" class="btn btn-primary" onclick="SaveCustomReport()">Save</button>
            </div>
         
          </div>
        </div>
      </div>
</div>
<!--changes filtersection-->
<script>
    function SaveCustomReport(){
        var tablecolumns="";
            $("input[name='columnnames[]']").each( function () {
                if(this.checked){
                    tablecolumns=tablecolumns+$(this).val()+",";
                }
                
            });
        var reportsettings = {};
            reportsettings['ReportName']=document.getElementById('InputReportname').value;
            reportsettings['ReportID']=document.getElementById('InputReportID').value;
            reportsettings['ReportHeader']=document.getElementById('report_employee_companynameheader').innerHTML;
            reportsettings['ReportTitle']=document.getElementById('report_employee_companynameheader').innerHTML;
            reportsettings['ReportType']="Customer Contact List";
            reportsettings['noteShow']=noteshow;
            reportsettings['noteContent']=document.getElementById('employeecontactnote').value;
            reportsettings['ReportSortBy']=document.getElementById('Sortbyselect').value;
            reportsettings['ReportSortOrder']=$('input[name=exampleRadios]:checked').val();
            reportsettings['ReportTableColumns']=tablecolumns;
            reportsettings['report_content_filter']="";
            reportsettings['report_content_from']="";
            reportsettings['report_content_to']="";
            $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('employee_contact_add') }}',                
            data: {reportsettings:reportsettings,_token: '{{csrf_token()}}'},
            success: function(data) {
                if(data=="Successfully updated Custom Report template"){
                    swal({title: "Done!", text: data, type: 
                    "success"}).then(function(){ 
                    //window.location.replace("/customformstyles");
                    document.getElementById('cancelsavecustom').click();
                    });
                }else{

                    document.getElementById('InputReportID').value=data;
                    //alert(document.getElementById('InputReportID').value);
                    swal({title: "Done!", text: "Successfully added Custom Report template", type: 
                    "success"}).then(function(){ 
                    //window.location.replace("/customformstyles");
                    document.getElementById('cancelsavecustom').click();
                    }); 
                }
                
            } ,
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.responseText);
                alert(thrownError);
            }
            })
    }
</script>
<div class="row">
    <div class="col-md-12" >
        <div class="reportbody">
            <div id="printablereport_employee_contact_list">
                <table class="report-main table table-sm" >
                <tbody>
                    <tr id="report_main_above_button">
                    <td style="vertical-align:middle;text-align:left;">
                        <div class="dropdown">
                        <a class="btn-link dropdown-toggle btn-sm" href="#" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort
                        </a>
                        <a href="#!" class="btn-link btn-upper-report" id="showhidebtn" onclick="showhode()">Add note</a>
                        <script>
                            var noteshow="0";
                            function showhode(){
                                if(noteshow==0){
                                    //document.getElementById('employeecontactnote').style.display="inline";
                                    $("#employeecontactnote").toggle("slide");
                                    document.getElementById('showhidebtn').innerHTML="Hide note";
                                    noteshow="1";
                                }else{
                                    //document.getElementById('employeecontactnote').style.display="none";
                                    $("#employeecontactnote").toggle("slide");
                                    document.getElementById('showhidebtn').innerHTML="Add note";
                                    noteshow="0";
                                }
                            }
                        </script>
                        <div class="dropdown-menu">
                        <form style="padding:1px 10px;">
                            <div class="form-group">
                            <label for="Sortbyselect">Sort by</label>
                            <br>
                            <select id="Sortbyselect" class="form-control" onchange="ss()">
                                <option value="0">Default</option>
                                <option value="1">Phone Number</option>
                                <option value="2">Email</option>
                                <option value="3">Full Name</option>
                                <option value="4">Billing Address</option>
                                <option value="5">Shipping Address</option>
                                <option value="6">Website</option>
                                <option value="7">Company Name</option>                               
                            </select>
                            <script>
                                function ss(){
                                    var e=document.getElementById('Sortbyselect').value;
                                    var order=$('input[name=exampleRadios]:checked').val();
                                    sortTable(e,order);
                                    
                                }
                            </script>
                            </div>
                            <label for="exampleRadios1">Sort in</label>
                            <div class="form-check">
                            <input class="form-check-input" onchange="ss()" type="radio" name="exampleRadios" id="exampleRadios1" value="asc" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Ascending order
                            </label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" onchange="ss()" type="radio" name="exampleRadios" id="exampleRadios2" value="desc" >
                            <label class="form-check-label" for="exampleRadios2">
                                Descending order
                            </label>
                            </div>
                        </form>
                        </div>
                        </div>
                        
                    </td>
                    <td style="vertical-align:middle;text-align:right;">
                        <a href="#" class="btn-link btn-upper-report" title="Export to Excel" onclick="exporttoexcel('tablemain')"><span class="fa fa-table"></a>
                        <a href="#" style="display:none;" class="btn-link btn-upper-report"><span class="ti-email"></span></a>
                        <a href="#" class="btn-link btn-upper-report" onclick="PrintElem('printablereport_employee_contact_list')"><span class="ti-printer"></span></a>
                        <a href="#" style="display:none;" class="btn-link btn-upper-report"><span class="ti-export"></span></a>
                        <button style="display:none;" class="btn btn-link btn-upper-report" onclick="showcustomizationsection()"><span class="ti-settings"></span></button>

                    </td>
                    </tr>
                    <tr>
                        <td id="report_employee_companynameheader" colspan="2" style="vertical-align:middle;font-size:22px;text-align:center;padding-top:30px;" contenteditable="true" >ECC</td>
                    </tr>
                    <tr>
                        <td colspan="2" id="report_employee_title" style="vertical-align:middle;text-align:center;font-size:14px;font-weight:bold;text-transform: uppercase;" contenteditable="true" >Customer Contact List</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:middle;" >
                        <script>
                        function sortTable(n,order) {
                        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                        table = document.getElementById("tablemain");
                        switching = true;
                        // Set the sorting direction to ascending:
                        dir = "asc";
                        if(order!=""){
                            dir=order;
                        }
                        /* Make a loop that will continue until
                        no switching has been done: */
                        while (switching) {
                            // Start by saying: no switching is done:
                            switching = false;
                            rows = table.rows;
                            /* Loop through all table rows (except the
                            first, which contains table headers): */
                            for (i = 1; i < (rows.length - 1); i++) {
                            // Start by saying there should be no switching:
                            shouldSwitch = false;
                            /* Get the two elements you want to compare,
                            one from current row and one from the next: */
                            x = rows[i].getElementsByTagName("TD")[n];
                            y = rows[i + 1].getElementsByTagName("TD")[n];
                            /* Check if the two rows should switch place,
                            based on the direction, asc or desc: */
                            if (dir == "asc") {
                                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                // If so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                                }
                            } else if (dir == "desc") {
                                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                // If so, mark as a switch and break the loop:
                                shouldSwitch = true;
                                break;
                                }
                            }
                            }
                            if (shouldSwitch) {
                            /* If a switch has been marked, make the switch
                            and mark that a switch has been done: */
                            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                            switching = true;
                            // Each time a switch is done, increase this count by 1:
                            switchcount ++; 
                            } else {
                            /* If no switching has been done AND the direction is "asc",
                            set the direction to "desc" and run the while loop again. */
                            if (switchcount == 0 && dir == "asc") {
                                dir = "desc";
                                switching = true;
                            }
                            }
                        }
                        }
                        </script>
                            
                            <table id="tablemain" class="table table-sm" style="text-align:left;font-size:12px;">
                                <thead>
                                <tr>
                                    
                                    <th>Customer</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    
                                    <th>Full Name</th>
                                    <th>Billing Address</th>
                                    <th>Shipping Address</th>
                                    <th>Website</th>
                                    <th>Company Name</th>
                                </tr>
                                
                                </thead>
                                <tbody>
                                @foreach($customers as $emp)
                                @if($emp->supplier_active=="1" && $emp->account_type=='Customer')
                                <tr style="border-bottom:1px solid #ccc;">
                                <td style="vertical-align:middle;">
                                    @if($emp->display_name!="")
                                    {{$emp->display_name}}
                                    @else
                                    {{$emp->f_name." ".$emp->l_name}}
                                    @endif
                                    
                                </td>
                                    <td style="vertical-align:middle;">
                                        {{$emp->phone}}<br>
                                        {{$emp->mobile}}
                                    </td>
                                    <td style="vertical-align:middle;">
                                        {{$emp->email}}
                                    </td>
                                <td style="vertical-align:middle;">{{$emp->f_name." ".$emp->l_name}}</td>
                                <td style="vertical-align:middle;">
                                        {{$emp->street}}
                                        <br>{{$emp->city.",".$emp->state}}
                                        <br>{{$emp->postal_code}}
                                </td>
                                <td style="vertical-align:middle;">
                                        {{$emp->street}}
                                        <br>{{$emp->city.",".$emp->state}}
                                        <br>{{$emp->postal_code}}    
                                </td>
                                <td style="vertical-align:middle;">{{$emp->website}}</td>
                                
                                <td style="vertical-align:middle;">{{$emp->company_name}}</td>
                                </tr>
                                @endif
                                @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:middle;text-align:center;font-size:11px;" >
                            <textarea class="form-control" placeholder="Add note here" rows="5" style="border:0px;display:none;" id="employeecontactnote"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="vertical-align:middle;text-align:center;font-size:11px;padding-bottom:10px;" id="timedatetd">
                           
                        </td>
                    </tr>
                </tbody>
                </table>
                <script>
                    $(document).ready(function(){
                        
                        document.getElementById('timedatetd').innerHTML="{{$date}}";
                    })
                </script>
            </div>
        </div>
    </div>
</div>
</div>
@foreach ($saved_reports as $reports)
        
        @if (app('request')->input('report')==$reports->report_id)
            <script>
                $(document).ready(function(){
                    
                    document.getElementById('InputReportname').value="{{$reports->report_name}}";
                    document.getElementById('InputReportID').value="{{$reports->report_id}}";
                    document.getElementById('report_employee_companynameheader').innerHTML="{{$reports->report_header}}";
                    document.getElementById('report_employee_title').innerHTML="{{$reports->report_title}}";
                    if("{{$reports->report_show_note}}"==0){
                        
                    }else{
                        showhode();
                    }
                    document.getElementById('employeecontactnote').value="{{$reports->report_note}}";
                    document.getElementById('filtertemplate').value="{{$reports->report_content_filter}}";
                    document.getElementById('Fromdate').value="{{$reports->report_content_from}}";
                    document.getElementById('Todate').value="{{$reports->report_content_to}}";
                    if(document.getElementById('CostCenterFilter')){
                    document.getElementById('CostCenterFilter').value="{{$reports->report_content_cost_center_filter}}";
                    }
                    submitdates();
                });
            </script>
        @endif
@endforeach
@endsection