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
    <script>
        $(document).ready(function(){
           document.getElementById('filtertemplate').value="This Year";
           changedates(document.getElementById('filtertemplate'))
           
        });
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
                <div class="card" style="border:0px solid #ccc;display:none;">
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
                            
                            for(var i=9;i<13;i++){
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
                    
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="1" id="customCheck6">
                        <label class="custom-control-label" for="customCheck6">Date</label>
                        
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="2" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">Transaction Type</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="3" id="customCheck2">
                        <label class="custom-control-label" for="customCheck2">No.</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="4" id="customCheck3">
                        <label class="custom-control-label" for="customCheck3">Name</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="5" id="customCheck4">
                        <label class="custom-control-label" for="customCheck4">Memo</label>
                        </div>
                        
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="6" id="customCheck7">
                        <label class="custom-control-label" for="customCheck7">Account</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="7" id="customCheck8">
                        <label class="custom-control-label" for="customCheck8">Amount</label>
                        </div>
                        
                    </div>
                    </div>
                </div>
                <div class="card" style="border:0px solid #ccc;">
                    <div class="card-header" id="headingTwo" style="padding:0px;border-bottom:0px solid black;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" style="text-decoration: none;color:#262626;" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <span class="oi oi-caret-bottom"></span> Report Period
                        </button>
                    </h5>
                    </div>

                    <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        
                        <script>
                            function submitdates(){
                                var filtertemplate= document.getElementById('filtertemplate').value;
                                var FROM= document.getElementById('Fromdate').value;
                                var TO= document.getElementById('Todate').value;
                                var CostCenterFilter = document.getElementById('CostCenterFilter').value;
                                if((FROM=="" || TO=="") && filtertemplate!="All"){
                                    
                                }
                                else{
                                    if(filtertemplate!="All"){
                                        document.getElementById('report_employee_title').innerHTML="PROFIT AND LOSS % OF TOTAL INCOME ("+convertDate(FROM)+" - "+convertDate(TO)+")";
                                    }else{
                                        document.getElementById('report_employee_title').innerHTML="PROFIT AND LOSS % OF TOTAL INCOME";
                                    }
                                    //window.location.replace("/Invoice_List?date_from="+FROM+"&date_to="+TO);
                                    $.ajax({
                                        type: 'POST',
                                        url: 'ProfitandlossaspercetagetotalByDate',                
                                        data: {CostCenterFilter:CostCenterFilter,filtertemplate:filtertemplate,FROM:FROM,TO:TO,_token: '{{csrf_token()}}'},
                                        success: function(data) {
                                        $( "#tablemain" ).replaceWith( data);
                                        $("input[name='columnnames[]']").each( function () {
                                            if(this.checked==false){
                                                hideshowcolumntable(this);
                                                
                                                //alert($(this).val());
                                            }
                                                        
                                            });
                                           
                                        } 											 
                                    });
                                }
                            }
                            function changedates(e){
                                var value= e.value;
                                var FROM= document.getElementById('Fromdate');
                                var TO= document.getElementById('Todate');
                                var d = new Date();
                                if(value=="All"){
                                    document.getElementById('datedivs').style.display="none";
                                }else{
                                    if(value=="Custom"){
                                       
                                    }
                                    else if(value=="This Week"){
                                        var curr = new Date; // get current date
                                        var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
                                        var last = first + 6;

                                        var firstday = new Date(curr.setDate(first));
                                        var lastday = new Date(curr.setDate(last));
                                        var last=lastday.getDate();
                                        if(first==0){
                                            first=1;
                                        }
                                        if(first<10){
                                            first="0"+first;
                                        }
                                        if(last<10){
                                            last="0"+last;
                                        }
                                        
                                        FROM.value=d.getFullYear()+"-"+("0" + (firstday.getMonth() + 1)).slice(-2)+"-"+first;
                                        TO.value=d.getFullYear()+"-"+("0" + (lastday.getMonth() + 1)).slice(-2)+"-"+last;
                                        
                                    }
                                    else if(value=="This Month"){
                                        var lastday = new Date(d.getFullYear(), d.getMonth()+1, 0);
                                        
                                        FROM.value=d.getFullYear()+"-"+("0" + (d.getMonth() + 1)).slice(-2)+"-01";
                                        TO.value=d.getFullYear()+"-"+("0" + (d.getMonth() + 1)).slice(-2)+"-"+lastday.getDate();
                                    }
                                    else if(value=="This Quarter"){
                                        if(getQuarter(d)=="1"){
                                            FROM.value=d.getFullYear()+"-10-01";
                                            TO.value=d.getFullYear()+"-12-31";
                                        }
                                        else if(getQuarter(d)=="4"){
                                            FROM.value=d.getFullYear()+"-06-01";
                                            TO.value=d.getFullYear()+"-09-30";
                                        }
                                        else if(getQuarter(d)=="3"){
                                            FROM.value=d.getFullYear()+"-04-01";
                                            TO.value=d.getFullYear()+"-06-30";
                                        }
                                        else if(getQuarter(d)=="2"){
                                            FROM.value=d.getFullYear()+"-01-01";
                                            TO.value=d.getFullYear()+"-03-31";
                                        }
                                    }
                                    else if(value=="This Year"){
                                        FROM.value=d.getFullYear()+"-01-01";
                                        TO.value=d.getFullYear()+"-12-31";
                                    }
                                    else if(value=="Last Week"){
                                        var curr = new Date; // get current date
                                        var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
                                        var last = first + 6;
                                        first-=7;
                                        last=first+6;
                                        var firstday = new Date(curr.setDate(first));
                                        var lastday = new Date(curr.setDate(last));
                                        var last=lastday.getDate();
                                        if(first<10){
                                            first="0"+first;
                                        }
                                        if(last<10){
                                            last="0"+last;
                                        }
                                        FROM.value=d.getFullYear()+"-"+("0" + (firstday.getMonth() + 1)).slice(-2)+"-"+first;
                                        TO.value=d.getFullYear()+"-"+("0" + (lastday.getMonth() + 1)).slice(-2)+"-"+last;
                                        
                                    }
                                    else if(value=="Last Month"){
                                        var lastmonth=d.getMonth();
                                        var year=d.getFullYear();
                                        if(lastmonth==0){
                                            lastmonth=12;
                                            year--;
                                        }
                                        if(lastmonth<10){
                                            lastmonth="0"+lastmonth;
                                        }
                                        var lastday = new Date(year,lastmonth , 0);
                                        
                                        FROM.value=year+"-"+lastmonth+"-01";
                                        TO.value=year+"-"+lastmonth+"-"+lastday.getDate();
                                    }
                                    else if(value=="Last Quarter"){
                                        if(getQuarter(d)=="1"){
                                            FROM.value=d.getFullYear()+"-06-01";
                                            TO.value=d.getFullYear()+"-09-30";
                                            
                                        }
                                        else if(getQuarter(d)=="4"){
                                            FROM.value=d.getFullYear()+"-04-01";
                                            TO.value=d.getFullYear()+"-06-30";
                                        }
                                        else if(getQuarter(d)=="3"){
                                            
                                            FROM.value=d.getFullYear()+"-01-01";
                                            TO.value=d.getFullYear()+"-03-31";
                                        }
                                        else if(getQuarter(d)=="2"){
                                            
                                            FROM.value=(d.getFullYear()-1)+"-10-01";
                                            TO.value=(d.getFullYear()-1)+"-12-31";
                                        }
                                    }
                                    else if(value=="Last Year"){
                                        FROM.value=(d.getFullYear()-1)+"-01-01";    
                                        TO.value=(d.getFullYear()-1)+"-12-31";
                                    }
                                    document.getElementById('datedivs').style.display="block";
                                    
                                }
                                submitdates();
                            }
                            //quarter getter
                            function getQuarter(d) {
                            // Oct-Dec = 1
                            // Jan-Mar = 2
                            // Apr-Jun = 3
                            // Jul-Sep = 4   
                            d = d || new Date();
                            var m = Math.floor(d.getMonth()/3) + 2;
                            return m > 4? m - 4 : m;
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
        <h4>Profit and Loss % of Total Income  Report</h4>
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
                    
                    <div class="col-md-6 ">
                            
                            <p>Date</p>
                            <select class="form-control" id="filtertemplate" onchange="changedates(this)">
                                    <option>All</option>
                                    <option>Custom</option>
                                    <option>This Week</option>
                                    <option>This Month</option>
                                    <option>This Quarter</option>
                                    <option>This Year</option>
                                    <option>Last Week</option>
                                    <option>Last Month</option>
                                    <option>Last Quarter</option>
                                    <option>Last Year</option>
                                </select>
                                
                                <div id="datedivs" style="display:none;margin-top:10px;border-top:1px solid #ccc ;">
                                <div class="form-group">
                                    <label for="Fromdate">From</label>
                                    <input type="date" class="form-control" oninput="submitdates()" onkeyup="submitdates()" id="Fromdate" >
                                    
                                </div>
                                <div class="form-group">
                                    <label for="Todate">To</label>
                                    <input type="date" class="form-control" oninput="submitdates()" onkeyup="submitdates()" id="Todate" >
                                    
                                </div>
                                </div>    
                    </div>
                    <div class="col-md-6 ">
                            <p>Cost Center</p>
                            <select class="form-control selectpicker" data-live-search="true" id="CostCenterFilter" onchange="submitdates()">
                                @foreach ($UserAccessCostCenterList as $uaccl)
                                @if ("All"==$uaccl->cost_center_id)
                                    <option>All</option>
                                <?php
                                break;
                                ?>
                                @endif
                                @endforeach
                            @foreach($all_cost_center_list as $lists)
                            @foreach ($UserAccessCostCenterList as $uaccl)
                                @if ($lists->cc_no==$uaccl->cost_center_id)
                                    <option value="{{$lists->cc_no}}">{{$lists->cc_name}}</option>
                                @endif
                            @endforeach
                            
                            @endforeach
                            </select>
                            <script>
                                $(document).ready(function(){
                                    submitdates();
                                })
                            </script>
                    </div>
                </div>
            </div>  
        
    </div>
    <div class="col-md-2" style="text-align:right;">
        <button style="display:none;" class="btn btn-outline-dark" onclick="showcustomizationsection()">Customize</button>
        <button class="btn btn-success"  data-toggle="modal" data-target="#exampleModal">Save customization</button>
        <div class="dropdown">
        <button class="btn btn-primary mt-2 dropdown-toggle" style="width:100%;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Report Category
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="ProfitAndLost">Profit And Loss</a>
            <a class="dropdown-item" href="ProfitAndLossByMonth">Profit And Loss By Month</a>
            <a class="dropdown-item" href="ProfitAndLossByCustomer">Profit And Loss By Customer</a>
            <a class="dropdown-item" href="ProfitAndLostComparison">Profit And Loss Comparison</a>
            <a class="dropdown-item" href="ProfitandLossasPercentageTotal">Profit And Loss as % of total income</a>
            <a class="dropdown-item" href="QuaarterlyProfitAndLoss">Quarterly Profit and Loss Summary</a>
            
        </div>
        </div>
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
            reportsettings['ReportType']="Profit and Loss % of Total Income ";
            reportsettings['noteShow']=noteshow;
            reportsettings['noteContent']=document.getElementById('employeecontactnote').value;
            reportsettings['ReportSortBy']=document.getElementById('Sortbyselect').value;
            reportsettings['ReportSortOrder']=$('input[name=exampleRadios]:checked').val();
            reportsettings['ReportTableColumns']=tablecolumns;
            
            reportsettings['report_content_filter']=document.getElementById('filtertemplate').value;
            reportsettings['report_content_from']=document.getElementById('Fromdate').value;
            reportsettings['report_content_to']=document.getElementById('Todate').value;
            reportsettings['report_url']="{{str_replace( url('/').'/','',url()->current())}}";
            if(document.getElementById('CostCenterFilter')){
            reportsettings['report_cost_center_filter']=document.getElementById('CostCenterFilter').value;
            }else{
            reportsettings['report_cost_center_filter']="";
            }
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
                        <a class="btn-link dropdown-toggle btn-sm" style="display:none;" href="#" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                <option value="1">Transaction Type</option>
                                <option value="2">No.</option>
                                <option value="3">Name</option>
                                <option value="4">Memo</option>
                                <option value="5">Due Date</option>
                                <option value="6">Amount</option>
                                <option value="7">Open Balance</option>                               
                                <option value="8">Billing Address</option>                               
                                <option value="9">Shipping Address</option> 
                                <option value="10">Terms</option> 
                                
                                
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
                        <a href="#" class="btn-link btn-upper-report" title="Export to Excel" onclick="exporttoexcelprofitandlossaspercent()"><span class="fa fa-table"></a>
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
                        <td colspan="2" id="report_employee_title" style="vertical-align:middle;text-align:center;font-size:14px;font-weight:bold;text-transform: uppercase;" contenteditable="true" >Profit and Loss % of Total Income </td>
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
                <style>
                    #tablemain tr td{
                        border-bottom: 1px dotted #e8e8e8;
                    }
                    .noborderpls{
                                    border-bottom: 0px dotted #e8e8e8 !important; 
                                }
                </style>           
                <table id="tablemain" class="table table-sm" style="text-align:left;font-size:12px;">
                <thead>
                    <tr>
                        <th colspan="3" width="60%"></th>
                        <th style="text-align:right;">Total</th>
                        <th style="text-align:right;">% OF INCOME</th>
                    </tr>
                </thead>                
                <tbody>
                    <?php
                    $totalincomeforpercent=0;
                    ?>
                    @foreach ($COA as $Coa)
                    @if ($Coa->coa_account_type=="Revenues" || $Coa->coa_account_type=="Revenue" || $Coa->coa_account_type=="Cost of Sales")
                    
                        @foreach ($JournalEntry as $JE)
                        @if ($JE->je_account==$Coa->id && $JE->remark!='Cancelled')
                        @if ($JE->je_credit!="" && $JE->remark!='Cancelled')
                        <?php
                        $totalincomeforpercent+=$JE->je_credit;
                        ?>  
                        @else
                        <?php
                        $totalincomeforpercent-=$JE->je_debit;
                        ?>
                        @endif
                         
                        @endif
                          
                        @endforeach
                        
                        
                        
                    @endif
                    @endforeach
                    <?php
                    $totalincomeforpercent2=0;
                    ?>
                    @foreach ($COA as $Coa)
                    @if ($Coa->coa_title=="Expenses" && $Coa->coa_account_type!="Cost of Sales")
                    
                        @foreach ($JournalEntry as $JE)
                        @if ($JE->je_account==$Coa->id && $JE->remark!='Cancelled')
                        @if ($JE->je_credit!="" && $JE->remark!='Cancelled')
                        <?php
                        $totalincomeforpercent2-=$JE->je_credit;
                        ?>  
                        @else
                        <?php
                        $totalincomeforpercent2+=$JE->je_debit;
                        ?>
                        @endif
                         
                        @endif
                          
                        @endforeach
                        
                        
                        
                    @endif
                    @endforeach
                    <?php
                    $totalincomeexpense=$totalincomeforpercent-$totalincomeforpercent2;
                    ?>
                    {{-- {{number_format($totalincomeexpense,2)}} --}}
                             
                    <tr>
                        <td colspan="5" style="vertical-align:middle;font-weight:bold;font-size:14px;">Income</td>
                        
                   </tr>
                    <?php
                    $IncomeTotal=0;
                    $GrossProfit=0;
                    ?>
                    @foreach ($coa_account_type as $coa)
                    @if ($coa->coa_account_type=="Revenues" || $coa->coa_account_type=="Revenue")
                    <tr>
                        <td class="noborderpls" style="vertical-align:middle;width:10px;"></td>                         
                        <td colspan="3"  style="vertical-align:middle;font-weight:bold;font-size:14px;;">{{$coa->coa_account_type}}</td>
                        
                    </tr>
                    
                    @foreach ($COA as $Coa)
                    @if ($Coa->coa_account_type==$coa->coa_account_type)
                    <tr>
                        <td class="noborderpls" style="vertical-align:middle;width:10px;"></td>
                        <td class="noborderpls" style="vertical-align:middle;width:10px;"></td>                         
                        <td style="vertical-align:middle;font-size:11px;;">{{$Coa->coa_name}}</td>
                        <td style="vertical-align:middle;text-align:right;">
                        <?php
                        $coa_name_total=0;
                        ?>
                        @foreach ($JournalEntry as $JE)
                        @if ($JE->je_account==$Coa->id && $JE->remark!='Cancelled')
                        @if ($JE->je_credit!="" && $JE->remark!='Cancelled')
                        <?php
                        $coa_name_total+=$JE->je_credit;
                        ?>  
                        @else
                        <?php
                        $coa_name_total-=$JE->je_debit;
                        ?>
                        @endif
                         
                        @endif
                          
                        @endforeach
                        <?php
                        $IncomeTotal+=$coa_name_total;
                        ?> 
                        {{number_format($coa_name_total,2)}}
                        </td>
                        <td style="vertical-align:middle;text-align:right;">
                            {{$totalincomeexpense!=0? number_format(($coa_name_total*100)/$totalincomeexpense,2)." %" : "0"." %"}}
                        </td>
                    </tr>  
                    @endif
                    @endforeach
                    <tr>
                        <td class="noborderpls" style="vertical-align:middle;width:10px;"></td>
                        <td colspan="2" style="vertical-align:middle;font-weight:bold;font-size:11px;;">Total Revenue</td>
                        <td style="vertical-align:middle;text-align:right;">{{number_format($IncomeTotal,2)}}</td>
                        <td style="vertical-align:middle;text-align:right;">
                            {{$totalincomeexpense!=0? number_format(($IncomeTotal*100)/$totalincomeexpense,2)." %" : "0"." %"}}
                        </td>
                    </tr>
                    @endif
                    
                    @endforeach
                    <tr>
                        <td colspan="3" style="vertical-align:middle;font-weight:bold;font-size:11px;">Total Income</td>
                        <td style="vertical-align:middle;text-align:right;font-weight:bold">{{number_format($IncomeTotal,2)}}</td>
                        <td style="vertical-align:middle;text-align:right;">
                            {{$totalincomeexpense!=0? number_format(($IncomeTotal*100)/$totalincomeexpense,2)." %" : "0"." %"}}
                        </td>
                    </tr>
                    <?php
                    $GrossProfit+=$IncomeTotal;
                    ?>
                    <tr>
                        <td colspan="5" style="vertical-align:middle;text-align:right;border-top:1px dotted #ccc"></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="vertical-align:middle;font-weight:bold;font-size:14px;">Less Cost of Sales</td>
                        
                        </td>
                    </tr>
                    <?php
                    $IncomeTotal=0;
                    ?>
                    @foreach ($coa_account_type as $coa)
                    @if ($coa->coa_account_type=="Cost of Sales")
                    <tr>
                        <td class="noborderpls" style="vertical-align:middle;width:10px;"></td>
                        <td colspan="3"  style="vertical-align:middle;font-weight:bold;font-size:14px;;">{{$coa->coa_account_type}}</td>
                        
                        </td>
                    </tr>
                    @foreach ($COA as $Coa)
                    @if ($Coa->coa_account_type=="Cost of Sales")
                    <tr>
                        <td class="noborderpls" style="vertical-align:middle;width:10px;"></td>                         
                        <td class="noborderpls" style="vertical-align:middle;width:10px;"></td>                         
                        <td style="vertical-align:middle;font-size:11px;;">{{$Coa->coa_name}}</td>
                        <td style="vertical-align:middle;text-align:right;">
                        <?php
                        $coa_name_total=0;
                        ?>
                        @foreach ($JournalEntry as $JE)
                        @if ($JE->je_account==$Coa->id && $JE->remark!='Cancelled')
                        @if ($JE->je_credit!="" && $JE->remark!='Cancelled')
                        <?php
                        $coa_name_total+=$JE->je_credit;
                        ?>  
                        @else
                        <?php
                        $coa_name_total-=$JE->je_debit;
                        ?>
                        @endif
                         
                        @endif
                          
                        @endforeach
                        <?php
                        $IncomeTotal+=$coa_name_total;
                        
                        ?> 
                        {{number_format($coa_name_total,2)}}
                        </td>
                        <td style="vertical-align:middle;text-align:right;">
                            {{$totalincomeexpense!=0? number_format(($coa_name_total*100)/$totalincomeexpense,2)." %" : "0"." %"}}
                        </td>
                    </tr>  
                    @endif
                    @endforeach
                    <tr>
                        <td class="noborderpls" style="vertical-align:middle;width:10px;"></td>
                        <td colspan="2" style="vertical-align:middle;font-weight:bold;font-size:11px;;">Total Cost of Sales</td>
                        <td style="vertical-align:middle;text-align:right;">{{number_format($IncomeTotal,2)}}</td>
                        <td style="vertical-align:middle;text-align:right;">
                            {{$totalincomeexpense!=0? number_format(($IncomeTotal*100)/$totalincomeexpense,2)." %" : "0"." %"}}
                        </td>
                    </tr>
                    @endif
                    
                    @endforeach
                    <tr>
                        <td colspan="3" style="vertical-align:middle;font-weight:bold;font-size:11px;">Total Cost of Sales</td>
                        <td style="vertical-align:middle;text-align:right;font-weight:bold;">{{number_format($IncomeTotal,2)}}</td>
                        <td style="vertical-align:middle;text-align:right;">
                            {{$totalincomeexpense!=0? number_format(($IncomeTotal*100)/$totalincomeexpense,2)." %" : "0"." %"}}
                        </td>
                    </tr>
                    <?php
                    $GrossProfit+=$IncomeTotal;
                    ?>
                    <tr>
                        <td colspan="5" style="vertical-align:middle;text-align:right;border-top:1px dotted #ccc"></td>
                    </tr>
                    <tr style="background-color: #eaf0f7;border-top:2px solid #ccc;">
                        <td colspan="3" style="vertical-align:middle;font-weight:bold;font-size:14px;">Gross Profit</td>
                        <td style="vertical-align:middle;text-align:right;font-weight:bold;">{{number_format($GrossProfit,2)}}</td>
                        <td style="vertical-align:middle;text-align:right;">
                            {{$totalincomeexpense!=0? number_format(($GrossProfit*100)/$totalincomeexpense,2)." %" : "0"." %"}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="vertical-align:middle;text-align:right;border-top:2px solid #ccc"></td>
                    </tr>
                    <!--expense-->
                    <tr>
                        <td colspan="5" style="vertical-align:middle;font-weight:bold;font-size:14px;">Less Operating Expenses</td>
                        
                    </tr>
                    <?php
                    
                    $TotalOperatingExpense=0;
                    ?>
                    @foreach ($coa_account_type as $coa)
                    <?php
                    $IncomeTotal=0;
                    ?>
                    @if ($coa->coa_title=="Expenses" && $coa->coa_account_type!="Cost of Sales")
                    <tr>
                        <td class="noborderpls" style="vertical-align:middle;width:10px;"></td>                         
                        <td colspan="3"  style="vertical-align:middle;font-weight:bold;font-size:14px;;">{{$coa->coa_account_type}}</td>
                        
                    </tr>
                    @foreach ($COA as $Coa)
                    @if ($Coa->coa_account_type==$coa->coa_account_type)
                    <tr>
                        <td class="noborderpls" style="vertical-align:middle;width:10px;"></td>                         
                        <td class="noborderpls" style="vertical-align:middle;width:10px;"></td>                         
                        <td style="vertical-align:middle;font-size:11px;;">{{$Coa->coa_name}}</td>
                        <td style="vertical-align:middle;text-align:right;">
                        <?php
                        $coa_name_total=0;
                        ?>
                        @foreach ($JournalEntry as $JE)
                        @if ($JE->je_account==$Coa->id && $JE->remark!='Cancelled')
                        @if ($JE->je_credit!="" && $JE->remark!='Cancelled')
                        <?php
                        $coa_name_total-=$JE->je_credit;
                        ?>  
                        @else
                        <?php
                        $coa_name_total+=$JE->je_debit;
                        ?>
                        @endif
                         
                        @endif
                          
                        @endforeach
                        <?php
                        $IncomeTotal+=$coa_name_total;
                        
                        ?> 
                        {{number_format($coa_name_total,2)}}
                        </td>
                        <td style="vertical-align:middle;text-align:right;">
                            {{$totalincomeexpense!=0? number_format(($coa_name_total*100)/$totalincomeexpense,2)." %" : "0"." %"}}
                        </td>
                    </tr>  
                    @endif
                    @endforeach
                    <tr>
                        <td class="noborderpls" style="vertical-align:middle;width:10px;"></td>
                        <td colspan="2" style="vertical-align:middle;font-weight:bold;font-size:11px;;">Total {{$coa->coa_account_type}}</td>
                        <td style="vertical-align:middle;text-align:right;font-weight:bold;">{{number_format($IncomeTotal,2)}}</td>
                        <td style="vertical-align:middle;text-align:right;">
                            {{$totalincomeexpense!=0? number_format(($IncomeTotal*100)/$totalincomeexpense,2)." %" : "0"." %"}}
                        </td>
                    </tr>
                    @endif
                    <?php
                    $TotalOperatingExpense+=$IncomeTotal;
                    ?>
                    @endforeach
                    
                    <tr>
                        <td colspan="5" style="vertical-align:middle;text-align:right;border-top:1px dotted #ccc"></td>
                    </tr>
                    
                    <tr>
                        <td colspan="3" style="vertical-align:middle;font-weight:bold;font-size:11px;">Total Operating Expenses</td>
                        <td style="vertical-align:middle;text-align:right;font-weight:bold;">{{number_format($TotalOperatingExpense,2)}}</td>
                        <td style="vertical-align:middle;text-align:right;">
                            {{$totalincomeexpense!=0? number_format(($TotalOperatingExpense*100)/$totalincomeexpense,2)." %" : "0"." %"}}
                        </td>
                    </tr>
                    <tr style="display:none;">
                        <td colspan="5" style="vertical-align:middle;text-align:right;border-top:2px solid #ccc"></td>
                    </tr>


                    <tr style="background-color: #eaf0f7;border-top:2px solid #ccc;">
                        <td colspan="3" style="vertical-align:middle;font-weight:bold;font-size:14px;border-top:2px solid solid #ccc;">Net Income</td>
                        <td style="vertical-align:middle;text-align:right;font-weight:bold;border-top:2px solid solid #ccc;">{{number_format($GrossProfit-$TotalOperatingExpense,2)}}</td>
                        <td style="vertical-align:middle;text-align:right;border-top:2px solid solid #ccc;">
                            {{$totalincomeexpense!=0? number_format((($GrossProfit-$TotalOperatingExpense)*100)/$totalincomeexpense,2)." %" : "0"." %"}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="vertical-align:middle;text-align:right;border-top:2px solid #ccc"></td>
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