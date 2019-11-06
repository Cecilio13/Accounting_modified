@extends('layout.initial')


@section('content')


<script>
$(document).ready(function(){
    $.ajax({
    method: "POST",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: "import_employee",
    dataType: "text",
    data: {_token: '{{csrf_token()}}'},
    success: function (data) {
        
    },
    
    });
})
// Load the Visualization API and the corechart package.

google.charts.load('current', {'packages':['corechart', 'bar']});
// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawChart);
google.charts.setOnLoadCallback(drawChart_due);
google.charts.setOnLoadCallback(drawChart_receivable);
google.charts.setOnLoadCallback(drawChart_expenses);

var months = [ "January", "February", "March", "April", "May", "June", 
           "July", "August", "September", "October", "November", "December" ];
function drawChart_expenses() {
    var data = google.visualization.arrayToDataTable([
          ['Month/Year', 'Expense', 'Overdue Expenses'],
          [months['{{($three_month)}}'-1]+' '+'{{$year_less_three}}', {{$current_month_less_three}}, {{$current_month_less_three_due}}],
          [months['{{($two_month)}}'-1]+' '+'{{$year_less_two}}', {{$current_month_less_two}}, {{$current_month_less_two_due}}],
          [months['{{($one_month)}}'-1]+' '+'{{$year_less_one}}', {{$current_month_less_one}}, {{$current_month_less_one_due}}],
          [months['{{$month_selected_raw}}'-1]+' '+'{{date("Y")}}', {{$current_month}}, {{$current_month_due}}]
        ]);

        var options = {
          chart: {
            title: 'Expense',
          },
          bars: 'vertical' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('piechart_expense'));

        chart.draw(data, google.charts.Bar.convertOptions(options));

}


function drawChart() {

var data = google.visualization.arrayToDataTable([
  ['Invoice Status', 'Amount'],
  ['Receivables',{{$total_invoice_receivable!=0? $total_invoice_receivable-$total_invoice_receivable_due : 0}}],
  ['Over Due Receivables',{{$total_invoice_receivable_due}}]
]);

var options = {
    pieSliceText: 'value-and-percentage'
};

var chart = new google.visualization.PieChart(document.getElementById('piechart'));

chart.draw(data, options);
}

function drawChart_due() {

var data = google.visualization.arrayToDataTable([
  ['Invoice Status', 'Amount'],
  ['Over Due Receivables',{{$total_invoice_receivable_due}}]
]);

var options = {
    pieSliceText: 'value-and-percentage'
};

var chart = new google.visualization.PieChart(document.getElementById('piechart_due'));

chart.draw(data, options);
document.getElementById('piechart_due').style.display="none";
}
function drawChart_receivable() {

var data = google.visualization.arrayToDataTable([
  ['Invoice Status', 'Amount'],
  ['Receivables',{{$total_invoice_receivable!=0? $total_invoice_receivable-$total_invoice_receivable_due : 0}}]
]);

var options = {
    pieSliceText: 'value-and-percentage'
};

var chart = new google.visualization.PieChart(document.getElementById('piechart_receivable'));

chart.draw(data, options);
document.getElementById('piechart_receivable').style.display="none";
}

</script>
<div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div>
        @if (count($UserAccessList)>0)
            @if ($UserAccessList[0]->user_approval=="1")
            <script>
                    function add_client_button(){
                        swal({
                        text: 'Enter Client Name',
                        content: "input",
                        button: {
                            text: "Add Client",
                            closeModal: false,
                        },
                        })
                        .then(name => {
                            if (!name) throw null;
                            
                            $.ajax({
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: "create_database",
                                data: {name:name,_token: '{{csrf_token()}}'},
                                success: function (data) {
                                    //alert(data);
                                    if(data=="Duplicate"){
                                        swal({title: "Error!", text:"Duplicate Client Name", type: 
                                        "error"}).then(function(){
                                        location.reload();                                    
                                        });
                                    }else if(data=="1"){
                                        swal({title: "Done!", text:"Successfully Added Client", type: 
                                        "success"}).then(function(){
                                        location.reload();                                    
                                        });
                                    }else{
                                        swal({title: "Error!", text:"Failed to Add Client", type: 
                                        "error"}).then(function(){
                                        location.reload();                                    
                                        });  
                                    }
                                    
                                    
                                },
                                error: function (data) {
                                    alert(data.responseText);
                                }
                            });
                        })
                        .catch(err => {
                            if (err) {
                                swal("Error!", "Please Try Again Later", "error");
                            } else {
                                swal.stopLoading();
                                swal.close();
                            }
                        });
                    }
                </script>
                <div class="col-sm-8">
                    <div class="float-right">
                        <button type="button" onclick="add_client_button()">Add New Client</button>
                    </div>
                </div> 
            @endif
        @endif
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
@if (count($UserAccessList)>0)
@if ($UserAccessList[0]->user_approval=="1")
<div class="content mt-3">
        
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title" id="LABEL_RECEIVABLE">RECEIVABLES</strong>
                            <select class="float-right" onchange="showreceivable()" id="selectedinvoice">
                                <option value="Both">Both</option>
                                <option value="Over Due">Over Due</option>
                                <option value="Receivable">Receivable</option>
                            </select>
                            <script>
                                function showreceivable(){
                                    var e=document.getElementById('selectedinvoice');
                                    console.log(e.value);
                                    if(e.value=="Both"){
                                        document.getElementById('piechart').style.display="block";
                                        document.getElementById('piechart_due').style.display="none";
                                        document.getElementById('piechart_receivable').style.display="none";
                                        document.getElementById('INVOICE_RECIEVABLE_LABEL').innerHTML="PHP {{number_format($total_invoice_receivable,2)}}";
                                        document.getElementById('LABEL_RECEIVABLE').innerHTML="RECEIVABLES";
                                        
                                    }
                                    else if(e.value=="Over Due"){
                                        document.getElementById('piechart').style.display="none";
                                        document.getElementById('piechart_due').style.display="block";
                                        document.getElementById('piechart_receivable').style.display="none";
                                        document.getElementById('INVOICE_RECIEVABLE_LABEL').innerHTML="PHP {{number_format($total_invoice_receivable_due,2)}}";
                                         document.getElementById('LABEL_RECEIVABLE').innerHTML="OVER DUE RECEIVABLES";
                                    }
                                    else if(e.value=="Receivable"){
                                        document.getElementById('piechart').style.display="none";
                                        document.getElementById('piechart_due').style.display="none";
                                        document.getElementById('piechart_receivable').style.display="block";
                                        document.getElementById('INVOICE_RECIEVABLE_LABEL').innerHTML="PHP {{number_format($total_invoice_receivable!=0? $total_invoice_receivable-$total_invoice_receivable_due : $total_invoice_receivable_due,2)}}";
                                        document.getElementById('LABEL_RECEIVABLE').innerHTML="RECEIVABLE";
                                    }
                                    

                                }
                            </script>
                        </div>
                        <div class="card-body">
                            <div style="position:absolute;z-index:100">
                                <h3 id="INVOICE_RECIEVABLE_LABEL">PHP {{number_format($total_invoice_receivable,2)}}</h3>
                            </div>
                            <div id="piechart"></div>
                            <div id="piechart_due" ></div>
                            <div id="piechart_receivable" ></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title" id="LABEL_EXPENSES">EXPENSES</strong>
                            <select class="float-right" onchange="showexpenses()" id="selectedexpense">
                                    <option value="" {{$month_selected_raw==""? 'Selected' : ''}}>Current Month</option>
                                    <option value="1" {{$month_selected_raw=="1"? 'Selected' : ''}}>January</option>
                                    <option value="2" {{$month_selected_raw=="2"? 'Selected' : ''}}>February</option>
                                    <option value="3" {{$month_selected_raw=="3"? 'Selected' : ''}}>March</option>
                                    <option value="4" {{$month_selected_raw=="4"? 'Selected' : ''}}>April</option>
                                    <option value="5" {{$month_selected_raw=="5"? 'Selected' : ''}}>May</option>
                                    <option value="6" {{$month_selected_raw=="6"? 'Selected' : ''}}>June</option>
                                    <option value="7" {{$month_selected_raw=="7"? 'Selected' : ''}}>July</option>
                                    <option value="8" {{$month_selected_raw=="8"? 'Selected' : ''}}>August</option>
                                    <option value="9" {{$month_selected_raw=="9"? 'Selected' : ''}}>September</option>
                                    <option value="10" {{$month_selected_raw=="10"? 'Selected' : ''}}>October</option>
                                    <option value="11" {{$month_selected_raw=="11"? 'Selected' : ''}}>November</option>
                                    <option value="12" {{$month_selected_raw=="12"? 'Selected' : ''}}>December</option>
                                    
                                </select>

                                <script>
                                    function showexpenses(){
                                        var e=document.getElementById('selectedexpense');
                                        console.log(e.value);
                                        location.href = "dashboard?expense_month="+e.value;
                                    }
                                </script>   
                        </div>
                        <div class="card-body">
                            
                            <div id="piechart_expense"></div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="display:none;">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Bank Accounts</strong>
                            <p>Cash and cash equivalents in Quickbooks</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" style="display:none;">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Profit and Loss</strong>
                            <select class="float-right">
                                Last Month
                                <option>Last 30 days</option>
                                <option>This Month</option>
                                <option>This Quarter</option>
                                <option>This Year</option>
                                <option>Last Month</option>
                                <option>Last Quarter</option>
                                <option>Last Year</option>
                            </select>
                        </div>
                        <div class="card-body">
                            <h3>PHP 0</h3>
                            <p>LAST MONTH</p>
                            <div class="d-inline">
                                <div class="float-left padding0 w-25">
                                    <p class="m-0">PHP 0</p>
                                    <p class="font12 pt-0">INCOME</p>
                                </div>
                                <div class="">
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="d-inline">
                                <div class="float-left padding0 w-25">
                                    <p class="m-0">PHP 0</p>
                                    <p class="font12 pt-0">EXPENSES</p>
                                </div>
                                <div class="">
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
    @endif
@endif

@endsection