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
                <div class="card" style="border:0px solid #ccc;display:none;">
                    <div class="card-header" id="headingOne" style="padding:0px;border-bottom:0px solid black;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" style="text-decoration: none;color:#262626;" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <span class="oi oi-caret-bottom"></span> Table Columns
                        </button>
                    </h5>
                    </div>

                    <div  id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
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
                        <label class="custom-control-label" for="customCheck7">Due Date</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="7" id="customCheck8">
                        <label class="custom-control-label" for="customCheck8">Amount</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" checked class="custom-control-input" value="8" id="customCheck5">
                        <label class="custom-control-label" for="customCheck5">Open Balance</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" class="custom-control-input" value="9" id="customCheck9">
                        <label class="custom-control-label" for="customCheck9">Billing Address</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" class="custom-control-input" value="10" id="customCheck10">
                        <label class="custom-control-label" for="customCheck10">Shipping Address</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                        <input type="checkbox" onclick="hideshowcolumntable(this)" name="columnnames[]" class="custom-control-input" value="11" id="customCheck11">
                        <label class="custom-control-label" for="customCheck11">Terms</label>
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
                            function export_monthly_invoice(){
                                var filtertemplate= document.getElementById('filtertemplate').value;
                                var FROM= document.getElementById('Fromdate').value;
                                var TO= document.getElementById('Todate').value;
                                var CostCenterFilter = document.getElementById('CostCenterFilter').value;
                                window.open(
                                'export_monthly_invoice?filtertemplate='+filtertemplate+'&FROM='+FROM+'&TO='+TO+'&CostCenterFilter='+CostCenterFilter,
                                '_blank' 
                                );
                            }
                            function submitdates(){
                                var filtertemplate= document.getElementById('filtertemplate').value;
                                var FROM= document.getElementById('Fromdate').value;
                                var TO= document.getElementById('Todate').value;
                                var CostCenterFilter = document.getElementById('CostCenterFilter').value;
                                if((FROM=="" || TO=="") && filtertemplate!="All"){
                                    console.log('empty');
                                }
                                else{
                                    
                                    //window.location.replace("/Invoice_List?date_from="+FROM+"&date_to="+TO);
                                    $.ajax({
                                        type: 'POST',
                                        url: 'monthly_sales_transaction_list_by_date',                
                                        data: {CostCenterFilter:CostCenterFilter,filtertemplate:filtertemplate,FROM:FROM,TO:TO,_token: '{{csrf_token()}}'},
                                        success: function(data) {
                                        $( "#tablemain" ).replaceWith( data);
                                        $("input[name='columnnames[]']").each( function () {
                                            if(this.checked==false){
                                                hideshowcolumntable(this);
                                                
                                                //alert($(this).val());
                                            }
                                                        
                                            });
                                            //ss();
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
                                    //document.getElementById('datedivs').style.display="block";
                                    
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
                <div class="card" style="border:0px solid #ccc;display:none;">
                        <div class="card-header" id="headingTwo" style="padding:0px;border-bottom:0px solid black;">
                        <h5 class="mb-0">
                            <button class="btn btn-link" style="text-decoration: none;color:#262626;" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            <span class="oi oi-caret-bottom"></span> Table Columns
                            </button>
                        </h5>
                        </div>
    
                        <div  id="collapseThree" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            
                            <select class="form-control" id="filtertemplatetype">
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
        <h4>Monthly Invoice Collection Report</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a href="reports" class="btn btn-link btn-sm" style="padding-left:0px;text-decoration: none;"><span class="oi oi-chevron-left"></span> Back to report list</a>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <input type="text" class="form-control" onkeyup="FilterTableRow()" style="width:50%" id="filterinputtable" placeholder="Filter List..">
        <script>
        function FilterTableRow() {
        // Declare variables 
        var input, filter, table, tr, td, i;
        input = document.getElementById("filterinputtable");
        filter = input.value.toUpperCase();
        table = document.getElementById("tablemain");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            td2= tr[i].getElementsByTagName("td")[1];
            td3= tr[i].getElementsByTagName("td")[2];
            td4= tr[i].getElementsByTagName("td")[3];
            td5= tr[i].getElementsByTagName("td")[4];
            td6= tr[i].getElementsByTagName("td")[5];
            td7= tr[i].getElementsByTagName("td")[6];
            td8= tr[i].getElementsByTagName("td")[7];
            
            
            if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1 || td2.innerHTML.toUpperCase().indexOf(filter) > -1 
                    || td3.innerHTML.toUpperCase().indexOf(filter) > -1 || td4.innerHTML.toUpperCase().indexOf(filter) > -1 || td5.innerHTML.toUpperCase().indexOf(filter) > -1
                    || td6.innerHTML.toUpperCase().indexOf(filter) > -1 || td7.innerHTML.toUpperCase().indexOf(filter) > -1 || td8.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
            } 
        }

        }
        </script>
    </div>
    <div class="col-md-6" style="text-align:right;">
        <button class="btn btn-outline-dark" onclick="showcustomizationsection()">Customize</button>
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
<div class="row">
    <div class="col-md-12" style="margin-top:10px;">
        <div class="col-md-12" style="background-color: white;padding-top:15px;padding-bottom:15px;padding-left:0px;padding-right:0px;">
                    <div >
                    
                    <div class="col-md-6 ">
                            
                            <p>Date</p>
                            <div class="form-row">
                                <div class="col">
                                    <select class="form-control" id="month_selected" onchange="setfrommonthyear()">
                                        <option {{date('m')=="01"? 'selected' : ''}} value="0">January</option>
                                        <option {{date('m')=="02"? 'selected' : ''}} value="1">February</option>
                                        <option {{date('m')=="03"? 'selected' : ''}} value="2">March</option>
                                        <option {{date('m')=="04"? 'selected' : ''}} value="3">April</option>
                                        <option {{date('m')=="05"? 'selected' : ''}} value="4">May</option>
                                        <option {{date('m')=="06"? 'selected' : ''}} value="5">June</option>
                                        <option {{date('m')=="07"? 'selected' : ''}} value="6">July</option>
                                        <option {{date('m')=="08"? 'selected' : ''}} value="7">August</option>
                                        <option {{date('m')=="09"? 'selected' : ''}} value="8">September</option>
                                        <option {{date('m')=="10"? 'selected' : ''}} value="9">October</option>
                                        <option {{date('m')=="11"? 'selected' : ''}} value="10">November</option>
                                        <option {{date('m')=="12"? 'selected' : ''}} value="11">December</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control" id="year_selected" onchange="setfrommonthyear()">
                                        @for ($i =date('Y') ; $i >= 2019; $i--)
                                            <option>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <script>
                                    function setfrommonthyear(){
                                        var month_selected=document.getElementById('month_selected').value;
                                        
                                        var year_selected=document.getElementById('year_selected').value;
                                        var month = month_selected;
                                        var d = new Date(year_selected, parseFloat(month) + parseFloat(1), 0);
                                       
                                        var month_formated=parseFloat(month) + parseFloat(1);
                                        if(month_formated<10){
                                            month_formated="0"+month_formated;
                                        }
                                        document.getElementById('Fromdate').value=year_selected+"-"+month_formated+"-01";
                                        document.getElementById('Todate').value=year_selected+"-"+month_formated+"-"+d.getDate();
                                        submitdates();
                                    }
                                </script>
                            </div>
                            <select class="form-control" id="filtertemplate" onchange="changedates(this)" style="display:none;">
                                <option>All</option>
                                <option selected>Custom</option>
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
                                    setfrommonthyear();
                                })
                            </script>
                    </div>
                </div>
            </div>
    </div>
</div>
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
            reportsettings['ReportType']="Monthly Invoice Collection";
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
                        <div class="dropdown" >
                        <a style="display:none;" class="btn-link dropdown-toggle btn-sm" href="#" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort
                        </a>
                        <a href="#!" class="btn-link btn-sm" id="showhidebtn" onclick="showhode()">Add note</a>
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
                        <div class="dropdown-menu" >
                        <form style="padding:1px 10px;">
                            <div class="form-group" style="display:none;">
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
                        <a href="#" class="btn-link btn-sm" title="Export to Excel" onclick="export_monthly_invoice()"><span class="fa fa-table"></a>
                        <a href="#" style="display:none;" class="btn-link btn-sm"><span class="ti-email"></span></a>
                        <a href="#" class="btn-link btn-sm" onclick="PrintElem('printablereport_employee_contact_list')"><span class="ti-printer"></span></a>
                        <a href="#" style="display:none;" class="btn-link btn-sm"><span class="ti-export"></span></a>
                        <button style="display:none;" class="btn btn-link btn-sm" onclick="showcustomizationsection()"><span class="ti-settings"></span></button>

                    </td>
                    </tr>
                    <tr>
                        <td id="report_employee_companynameheader" colspan="2" style="vertical-align:middle;font-size:22px;text-align:center;padding-top:30px;" contenteditable="true" >ECC</td>
                    </tr>
                    <tr>
                        <td colspan="2" id="report_employee_title" style="vertical-align:middle;text-align:center;font-size:14px;font-weight:bold;text-transform: uppercase;" contenteditable="true" >Monthly Invoice Collection</td>
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
                                    
                                    <th>Date</th>
                                    <th>Transaction Type</th>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Due Date</th>
                                    <th>Balance</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                   
                                </tr>
                                
                                </thead>
                                <tbody>
                                    
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