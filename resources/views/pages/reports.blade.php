@extends('layout.initial')


@section('content')
<div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Reports</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Standard</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">My Custom Reports</a>
                </li>
                <li class="nav-item" style="display:none;">
                    <a class="nav-link" id="extra-tab" data-toggle="tab" href="#extra" role="tab" aria-controls="extra" aria-selected="false">Management Reports</a>
                </li>
                
            </ul>
            <div class="tab-content pl-3 p-1" style="" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="accordion" id="accordionExample">
                        <div class="card" style="margin-top:10px;">
                            <div class="card-header" id="headingNine">
                              <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                   <span class="oi oi-caret-bottom"></span> Favorites
                                </button>
                              </h5>
                            </div>
                            <div id="collapseNine" class="collapse show" aria-labelledby="headingFive" data-parent="#accordionExample">
                              <div class="card-body">
                               <div class="row">
                                    <div class="col-md-10">
                                        <table class="table table-hover table-sm table-report" >
                                            <tbody>
                                                    <?php
                                                    $entry_count=0;
                                                    ?>
                                                    @foreach ($favorite_report as $fav)
                                                    @if($fav->report_name=="Transaction List by Supplier")
                                                        @if ((!empty($expense_setting) && $expense_setting->expenses_track_expense_and_item_by_customer=="on") || empty($expense_setting))
                                                            @if($fav->report_status=='1')
                                                            <?php
                                                            $entry_count++;
                                                            ?>
                                                            @if($entry_count % 2 != 0)
                                                            <tr>
                                                                <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="{{$fav->report_link}}">{{$fav->report_name}}</a></td>
                                                                <td style="vertical-align:middle;">
                                                                
                                                                    <button class="btn btn-link btn-sm" data-report-name="{{$fav->report_name}}" onclick="favorite(this,1,'{{$fav->report_link}}')"><i class="fas fa-star"></i></button>
                                                                
                                                                </td>
                                                            @else
                                                                <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="{{$fav->report_link}}">{{$fav->report_name}}</a></td>
                                                                <td style="vertical-align:middle;">
                                                                
                                                                    <button class="btn btn-link btn-sm" data-report-name="{{$fav->report_name}}" onclick="favorite(this,1,'{{$fav->report_link}}')"><i class="fas fa-star"></i></button>
                                                                
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if($fav->report_status=='1')
                                                        <?php
                                                        $entry_count++;
                                                        ?>
                                                        @if($entry_count % 2 != 0)
                                                        <tr>
                                                            <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="{{$fav->report_link}}">{{$fav->report_name}}</a></td>
                                                            <td style="vertical-align:middle;">
                                                            
                                                                <button class="btn btn-link btn-sm" data-report-name="{{$fav->report_name}}" onclick="favorite(this,1,'{{$fav->report_link}}')"><i class="fas fa-star"></i></button>
                                                            
                                                            </td>
                                                        @else
                                                            <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="{{$fav->report_link}}">{{$fav->report_name}}</a></td>
                                                            <td style="vertical-align:middle;">
                                                            
                                                                <button class="btn btn-link btn-sm" data-report-name="{{$fav->report_name}}" onclick="favorite(this,1,'{{$fav->report_link}}')"><i class="fas fa-star"></i></button>
                                                            
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endif
                                                    @endif
                                                    
                                                    @endforeach
                                                    
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                              </div>
                            </div>
                          </div>
                        <div class="card" >
                          <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                              <button class="btn btn-link"  type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span class="oi oi-caret-bottom"></span> Business Overview
                              </button>
                            </h5>
                          </div>
                          <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
                          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <table class="table table-hover table-sm table-report" >
                                            <tbody >
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="2"><a class="btn btn-link" href="AuditLogs">Audit Log</a></td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="BalanceSheetComparison">Balance Sheet Comparison</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Balance Sheet Comparison" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Balance Sheet Comparison" onclick="favorite(this,1,'BalanceSheetComparison')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Balance Sheet Comparison" onclick="favorite(this,0,'BalanceSheetComparison')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="BalanceSheetDetail">Balance Sheet Detail</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Balance Sheet Detail" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Balance Sheet Detail" onclick="favorite(this,1,'BalanceSheetDetail')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Balance Sheet Detail" onclick="favorite(this,0,'BalanceSheetDetail')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="BalanceSheet">Balance Sheet</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Balance Sheet" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Balance Sheet" onclick="favorite(this,1,'BalanceSheet')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Balance Sheet" onclick="favorite(this,0,'BalanceSheet')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="sales_transaction_list">Sales Transaction List</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Sales Transaction List" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Sales Transaction List" onclick="favorite(this,1,'sales_transaction_list')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Sales Transaction List" onclick="favorite(this,0,'sales_transaction_list')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="expense_transaction_list">Expenses Transaction List</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Expenses Transaction List" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Expenses Transaction List" onclick="favorite(this,1,'expense_transaction_list')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Expenses Transaction List" onclick="favorite(this,0,'expense_transaction_list')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="monthly_invoice_collection">Monthly Invoice Report</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Monthly Invoice Report" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Monthly Invoice Report" onclick="favorite(this,1,'monthly_invoice_collection')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Monthly Invoice Report" onclick="favorite(this,0,'monthly_invoice_collection')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="monthly_expense_collection">Monthly Expense Report</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Monthly Expense Report" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Monthly Expense Report" onclick="favorite(this,1,'monthly_expense_collection')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Monthly Expense Report" onclick="favorite(this,0,'monthly_expense_collection')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr style="display:none;">
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="#">Profit and Loss year-to-date comparison</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Profit and Loss year-to-date comparison" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Profit and Loss year-to-date comparison" onclick="favorite(this,1,'#')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Profit and Loss year-to-date comparison" onclick="favorite(this,0,'#')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-5">
                                        <table class="table table-hover table-sm table-report" >
                                            <tbody >
                                                
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="BudgetSummaryReport">Budget Summary Report</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Budget Summary Report" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Budget Summary Report" onclick="favorite(this,1,'BudgetSummaryReport')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Budget Summary Report" onclick="favorite(this,0,'BudgetSummaryReport')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="ProfitAndLossByCustomer">Profit and Loss by Customer</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Profit and Loss by Customer" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Profit and Loss by Customer" onclick="favorite(this,1,'ProfitAndLossByCustomer')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Profit and Loss by Customer" onclick="favorite(this,0,'ProfitAndLossByCustomer')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="ProfitAndLossByMonth">Profit and Loss by Month</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Profit and Loss by Month" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Profit and Loss by Month" onclick="favorite(this,1,'ProfitAndLossByMonth')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Profit and Loss by Month" onclick="favorite(this,0,'ProfitAndLossByMonth')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="ProfitAndLost">Profit and Loss</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Profit and Loss" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Profit and Loss" onclick="favorite(this,1,'ProfitAndLost')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Profit and Loss" onclick="favorite(this,0,'ProfitAndLost')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="QuaarterlyProfitAndLoss">Quarterly Profit and Loss Summary</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Quarterly Profit and Loss Summary" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Quarterly Profit and Loss Summary" onclick="favorite(this,1,'QuaarterlyProfitAndLoss')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Quarterly Profit and Loss Summary" onclick="favorite(this,0,'QuaarterlyProfitAndLoss')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr style="display:none;">
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="StatementofCashFlows">Statement of Cash Flows</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Statement of Cash Flows" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Statement of Cash Flows" onclick="favorite(this,1,'StatementofCashFlows')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Statement of Cash Flows" onclick="favorite(this,0,'StatementofCashFlows')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr style="display:none;">
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="StatementofChangesinEquity">Statement of Changes in Equity</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Statement of Changes in Equity" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Statement of Changes in Equity" onclick="favorite(this,1,'StatementofChangesinEquity')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Statement of Changes in Equity" onclick="favorite(this,0,'StatementofChangesinEquity')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="ProfitandLossasPercentageTotal">Profit and Loss as % of total income</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Profit and Loss as % of total income" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Profit and Loss as % of total income" onclick="favorite(this,1,'ProfitandLossasPercentageTotal')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Profit and Loss as % of total income" onclick="favorite(this,0,'ProfitandLossasPercentageTotal')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="ProfitAndLostComparison">Profit and Loss Comparison</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Profit and Loss Comparison" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Profit and Loss Comparison" onclick="favorite(this,1,'ProfitAndLostComparison')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Profit and Loss Comparison" onclick="favorite(this,0,'ProfitAndLostComparison')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="SalesandBillingInvoiceReport">Sales and Billing Invoice Report</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Sales and Billing Invoice Report" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Sales and Billing Invoice Report" onclick="favorite(this,1,'SalesandBillingInvoiceReport')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Sales and Billing Invoice Report" onclick="favorite(this,0,'SalesandBillingInvoiceReport')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <span class="oi oi-caret-bottom"></span> Who Owe You
                              </button>
                            </h5>
                          </div>
                          <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <table class="table table-hover table-sm table-report" >
                                            <tbody >
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="AR_Receivable_Ageing">Account Recievable Ageing Summary</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Account Recievable Ageing Summary" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Account Recievable Ageing Summary" onclick="favorite(this,1,'AR_Receivable_Ageing')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Account Recievable Ageing Summary" onclick="favorite(this,0,'AR_Receivable_Ageing')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Collection_Report">Collections Report</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Collections Report" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Collections Report" onclick="favorite(this,1,'Collection_Report')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Collections Report" onclick="favorite(this,0,'Collection_Report')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Customer_Balance_Summary">Customer Balance Summary</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Customer Balance Summary" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Customer Balance Summary" onclick="favorite(this,1,'Customer_Balance_Summary')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Customer Balance Summary" onclick="favorite(this,0,'Customer_Balance_Summary')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-5">
                                        <table class="table table-hover table-sm table-report" >
                                            <tbody >
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Invoice_List">Invoice List</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Invoice List" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Invoice List" onclick="favorite(this,1,'Invoice_List')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Invoice List" onclick="favorite(this,0,'Invoice_List')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Open_Invoice_List">Open Invoice</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Open Invoice" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Open Invoice" onclick="favorite(this,1,'Open_Invoice_List')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Open Invoice" onclick="favorite(this,0,'Open_Invoice_List')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr style="display:none;">
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="#">Statement List</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Statement List" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Statement List" onclick="favorite(this,1,'#')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Statement List" onclick="favorite(this,0,'#')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <span class="oi oi-caret-bottom"></span> Sales and Customer
                              </button>
                            </h5>
                          </div>
                          <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <table class="table table-hover table-sm table-report" >
                                            <tbody >
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Customer_Contact_List">Customer Contact List</a></td>
                                                    <td style="vertical-align:middle;">
                                                            <?php
                                                            $report_status=0;
                                                            ?>
                                                            @foreach ($favorite_report as $fv)
                                                                @if($fv->report_name=="Customer Contact List" && $fv->report_status=='1')
                                                                <?php
                                                                $report_status=1;
                                                                ?>
                                                                @endif
                                                            @endforeach
                                                            @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Customer Contact List" onclick="favorite(this,1,'Customer_Contact_List')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Customer Contact List" onclick="favorite(this,0,'Customer_Contact_List')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="DepositDetail">Deposit Detail</a></td>
                                                    <td style="vertical-align:middle;">
                                                            <?php
                                                            $report_status=0;
                                                            ?>
                                                            @foreach ($favorite_report as $fv)
                                                                @if($fv->report_name=="Deposit Detail" && $fv->report_status=='1')
                                                                <?php
                                                                $report_status=1;
                                                                ?>
                                                                @endif
                                                            @endforeach
                                                            @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Deposit Detail" onclick="favorite(this,1,'DepositDetail')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Deposit Detail" onclick="favorite(this,0,'DepositDetail')"><i class="far fa-star"></i></button>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Estimate_by_Customer">Estimates by Customer</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Estimates by Customer" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Estimates by Customer" onclick="favorite(this,1,'Estimate_by_Customer')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Estimates by Customer" onclick="favorite(this,0,'Estimate_by_Customer')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="VAT_List">TAX</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="TAX" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="TAX" onclick="favorite(this,1,'VAT_List')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="TAX" onclick="favorite(this,0,'VAT_List')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-5">
                                        <table class="table table-hover table-sm table-report" >
                                            <tbody >
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="ProductandServices_List">Product/Service List</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Product/Service List" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Product/Service List" onclick="favorite(this,1,'ProductandServices_List')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Product/Service List" onclick="favorite(this,0,'ProductandServices_List')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="SalesbyCustomer">Sales by Customer Summary</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Sales by Customer Summary" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Sales by Customer Summary" onclick="favorite(this,1,'SalesbyCustomer')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Sales by Customer Summary" onclick="favorite(this,0,'SalesbyCustomer')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="SalesbyProduct">Sales by Product/Service Summary</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Sales by Product/Service Summary" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Sales by Product/Service Summary" onclick="favorite(this,1,'SalesbyProduct')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Sales by Product/Service Summary" onclick="favorite(this,0,'SalesbyProduct')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingFour">
                              <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <span class="oi oi-caret-bottom"></span> Expenses and Suppliers
                                </button>
                              </h5>
                            </div>
                            <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordionExample">
                              <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <table class="table table-hover table-sm table-report" >
                                            <tbody >
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Check_Details">Check Detail</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Check Detail" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Check Detail" onclick="favorite(this,1,'Check_Details')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Check Detail" onclick="favorite(this,0,'Check_Details')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Supplier_Contact_List">Supplier Contact List</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Supplier Contact List" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Supplier Contact List" onclick="favorite(this,1,'Supplier_Contact_List')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Supplier Contact List" onclick="favorite(this,0,'Supplier_Contact_List')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                
                                                @if ((!empty($expense_setting) && $expense_setting->expenses_track_expense_and_item_by_customer=="on") || empty($expense_setting))
                                                    <tr>
                                                        <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Transaction_List_By_Supplier">Transaction List by Supplier</a></td>
                                                        <td style="vertical-align:middle;">
                                                            <?php
                                                            $report_status=0;
                                                            ?>
                                                            @foreach ($favorite_report as $fv)
                                                                @if($fv->report_name=="Transaction List by Supplier" && $fv->report_status=='1')
                                                                <?php
                                                                $report_status=1;
                                                                ?>
                                                                @endif
                                                            @endforeach
                                                            @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Transaction List by Supplier" onclick="favorite(this,1,'Transaction_List_By_Supplier')"><i class="fas fa-star"></i></button>
                                                            @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Transaction List by Supplier" onclick="favorite(this,0,'Transaction_List_By_Supplier')"><i class="far fa-star"></i></button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card">
                            <div class="card-header" id="headingFive">
                              <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                   <span class="oi oi-caret-bottom"></span> What You Owe
                                </button>
                              </h5>
                            </div>
                            <div id="collapseFive" class="collapse show" aria-labelledby="headingFive" data-parent="#accordionExample">
                              <div class="card-body">
                               <div class="row">
                                    <div class="col-md-5">
                                        <table class="table table-hover table-sm table-report" >
                                            <tbody >
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="AccountsPayableDetail">Accounts Payable Detail</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Accounts Payable Detail" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Accounts Payable Detail" onclick="favorite(this,1,'AccountsPayableDetail')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Accounts Payable Detail" onclick="favorite(this,0,'AccountsPayableDetail')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="AccountsPayableAgeingSummary">A/P Ageing Summary</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="A/P Ageing Summary" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="A/P Ageing Summary" onclick="favorite(this,1,'AccountsPayableAgeingSummary')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="A/P Ageing Summary" onclick="favorite(this,0,'AccountsPayableAgeingSummary')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                              </div>
                            </div>
                          </div>
                        <div class="card" style="display:none;">
                            <div class="card-header" id="headingSeven" >
                              <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                   <span class="oi oi-caret-bottom"></span> Employee
                                </button>
                              </h5>
                            </div>
                            <div id="collapseSeven" class="collapse show" aria-labelledby="headingFive" data-parent="#accordionExample">
                              <div class="card-body">
                               <div class="row">
                                    <div class="col-md-5">
                                        <table class="table table-hover table-sm table-report" >
                                            <tbody >
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Employee_Contact_List">Employee Contact List</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Employee Contact List" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Employee Contact List" onclick="favorite(this,1,'Employee_Contact_List')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Employee Contact List" onclick="favorite(this,0,'Employee_Contact_List')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                              </div>
                            </div>
                          </div>
                        <div class="card">
                            <div class="card-header" id="headingSix">
                              <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                   <span class="oi oi-caret-bottom"></span> For My Accountant
                                </button>
                              </h5>
                            </div>
                            <div id="collapseSix" class="collapse show" aria-labelledby="headingSix" data-parent="#accordionExample">
                              <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <script>
                                            function favorite(element,status,link){
                                                if(status==0){
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'favorite_report',                
                                                        data: {link:link,status:'1',report_name:element.getAttribute('data-report-name'),_token: '{{csrf_token()}}'},
                                                        success: function(data) {
                                                        
                                                        
                                                        } 											 
                                                    });
                                                    element.innerHTML='<i class="fas fa-star"></i>';
                                                }else{
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'favorite_report',                
                                                        data: {link:link,status:'0',report_name:element.getAttribute('data-report-name'),_token: '{{csrf_token()}}'},
                                                        success: function(data) {
                                                        
                                                        
                                                        } 											 
                                                    });
                                                    element.innerHTML='<i class="far fa-star"></i>'; 
                                                }
                                            }
                                        </script>
                                        <table class="table table-hover table-sm table-report" >
                                            <tbody >
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="AccountList">Account List</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Account List" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Account List" onclick="favorite(this,1,'AccountList')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Account List" onclick="favorite(this,0,'AccountList')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="BalanceSheetComparison">Balance Sheet Comparison</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Balance Sheet Comparison" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Balance Sheet Comparison" onclick="favorite(this,1,'BalanceSheetComparison')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Balance Sheet Comparison" onclick="favorite(this,0,'BalanceSheetComparison')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="BalanceSheet">Balance Sheet</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Balance Sheet" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Balance Sheet" onclick="favorite(this,1,'BalanceSheet')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Balance Sheet" onclick="favorite(this,0,'BalanceSheet')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="General_Ledger">General Ledger</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="General Ledger" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="General Ledger" onclick="favorite(this,1,'General_Ledger')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="General Ledger" onclick="favorite(this,0,'General_Ledger')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="sub_ledger_by_supplier">Ledger By Supplier</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Ledger By Supplier" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Ledger By Supplier" onclick="favorite(this,1,'sub_ledger_by_supplier')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Ledger By Supplier" onclick="favorite(this,0,'sub_ledger_by_supplier')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="sub_ledger_by_customer">Ledger By Customer</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Ledger By Customer" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Ledger By Customer" onclick="favorite(this,1,'sub_ledger_by_customer')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Ledger By Customer" onclick="favorite(this,0,'sub_ledger_by_customer')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="sub_ledger_by_employee">Ledger By Employee</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Ledger By Employee" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Ledger By Employee" onclick="favorite(this,1,'sub_ledger_by_employee')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Ledger By Employee" onclick="favorite(this,0,'sub_ledger_by_employee')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Journal_Summary">Journal</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Journal" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Journal" onclick="favorite(this,1,'Journal_Summary')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Journal" onclick="favorite(this,0,'Journal_Summary')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="ProfitAndLostComparison">Profit and Loss Comparison</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Profit and Loss Comparison" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Profit and Loss Comparison" onclick="favorite(this,1,'ProfitAndLostComparison')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Profit and Loss Comparison" onclick="favorite(this,0,'ProfitAndLostComparison')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-5">
                                        <table class="table table-hover table-sm table-report" >
                                            <tbody >
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="ProfitAndLost">Profit and Loss</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Profit and Loss" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Profit and Loss" onclick="favorite(this,1,'ProfitAndLost')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Profit and Loss" onclick="favorite(this,0,'ProfitAndLost')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="RecentTransactions">Recent Transaction</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Recent Transaction" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Recent Transaction" onclick="favorite(this,1,'RecentTransactions')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Recent Transaction" onclick="favorite(this,0,'RecentTransactions')"><i class="far fa-star"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr style="display:none;">
                                                    <td style="vertical-align:middle;" colspan="2"><a class="btn btn-link" href="#">Reconciliation Report</a></td>
                                                    
                                                </tr>
                                                <tr style="display:none;">
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="StatementofCashFlows">Statement of Cash Flow</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Statement of Cash Flow" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Statement of Cash Flow" onclick="favorite(this,1,'StatementofCashFlows')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Statement of Cash Flow" onclick="favorite(this,0,'StatementofCashFlows')"><i class="far fa-star"></i></button>
                                                        @endif
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Transaction_List_By_Date">Transaction List by Date</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Transaction List by Date" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Transaction List by Date" onclick="favorite(this,1,'Transaction_List_By_Date')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Transaction List by Date" onclick="favorite(this,0,'Transaction_List_By_Date')"><i class="far fa-star"></i></button>
                                                        @endif
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Trial_Balance">Trial Balance</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Trial Balance" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                        <button class="btn btn-link btn-sm" data-report-name="Trial Balance" onclick="favorite(this,1,'Trial_Balance')"><i class="fas fa-star"></i></button>
                                                        @else
                                                        <button class="btn btn-link btn-sm" data-report-name="Trial Balance" onclick="favorite(this,0,'Trial_Balance')"><i class="far fa-star"></i></button>
                                                        @endif
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Ledger_for_COA_Desc">Summary of Chart of Accounts Description</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Summary of Chart of Accounts Description" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Summary of Chart of Accounts Description" onclick="favorite(this,1,'Ledger_for_COA_Desc')"><i class="fas fa-star"></i></button>
                                                        @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Summary of Chart of Accounts Description" onclick="favorite(this,0,'Ledger_for_COA_Desc')"><i class="far fa-star"></i></button>
                                                        @endif
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;" colspan="1"><a class="btn btn-link" href="Movements_in_Equity">Movements in Equity</a></td>
                                                    <td style="vertical-align:middle;">
                                                        <?php
                                                        $report_status=0;
                                                        ?>
                                                        @foreach ($favorite_report as $fv)
                                                            @if($fv->report_name=="Movements in Equity" && $fv->report_status=='1')
                                                            <?php
                                                            $report_status=1;
                                                            ?>
                                                            @endif
                                                        @endforeach
                                                        @if($report_status==1)
                                                            <button class="btn btn-link btn-sm" data-report-name="Movements in Equity" onclick="favorite(this,1,'Movements_in_Equity')"><i class="fas fa-star"></i></button>
                                                        @else
                                                            <button class="btn btn-link btn-sm" data-report-name="Movements in Equity" onclick="favorite(this,0,'Movements_in_Equity')"><i class="far fa-star"></i></button>
                                                        @endif
                                                        
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                </div>
                
                <!-- =============================================================================================================================THIRD TAB -->
                <div class="tab-pane fade show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <h3>My Custom Reports</h3>
                    <div id="table" class="table-editable mt-2">
                        <!-- Button trigger modal -->
                        <!-- <span class="table-add float-right mb-3 mr-2"><button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#staticModal">New Rule</button></span> -->
                        <table class="table table-bordered table-responsive-md table-striped font14">
                            <thead>
                            <tr>
                                <th class="text-center">NAME</th>
                                <th class="text-center">TYPE</th>
                                <th class="text-center">DATE RANGE</th>
                                
                                <th class="text-center">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($Report as $re)
                                @if($re->report_status=="1")
                                <tr>
                                <td  style="vertical-align:middle;">{{$re->report_name}}</td>
                                <td  style="vertical-align:middle;text-align:center;">{{$re->report_type}}</td>
                                <td  style="vertical-align:middle;"></td>
                                <td width="20%" style="vertical-align:middle;">
                                    <select class="form-control " onchange="CUstomReportAction(this,'{{$re->report_id}}')">
                                        <option value="">--Select Action--</option>
                                        <option value="{{$re->report_url}}">Edit</option>
                                        <option>Delete</option>
                                    </select>
                                </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                            <!-- This is our clonable table line -->
                        </table>
                        <script>
                            function CUstomReportAction(selected,id){
                                if(selected.value=="Delete"){
                                    $.ajax({
                                        type: 'POST',
                                        url: 'deactivate_report',                
                                        data: {id:id,_token: '{{csrf_token()}}'},
                                        success: function(data) {
                                            if(data=="Successfully deleted custom report"){
                                                swal({title: "Done!", text: data, type: 
                                                "success"}).then(function(){ 
                                                window.location.replace("/reports");
                                                
                                                });
                                            }else{
                                                alert(data);
                                            }
                                        } 											 
                                    });
                                }
                                else if(selected.value==""){
                                    
                                }else{
                                    
                                    window.location.replace(selected.value+"/?report="+id);
                                }
                                selected.value="";
                            }
                        </script>
                    </div>
                </div>
                <!-- =============================================================================================================================Fourth TAB -->
                <div class="tab-pane fade show" id="extra" role="tabpanel" aria-labelledby="extra-tab">
                    <h3>Management Reports</h3>
                    <div id="table" class="table-editable">
                        <!-- Button trigger modal -->
                        <!-- <span class="table-add float-right mb-3 mr-2"><button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#staticModal">New Rule</button></span> -->
                        <table class="table table-bordered table-responsive-md table-striped text-center font14">
                            <tr>
                                <th class="text-center">NAME</th>
                                <th class="text-center">CREATED BY</th>
                                <th class="text-center">LAST MODIFIED</th>
                                <th class="text-center">REPORT PERIOD</th>
                                <th class="text-center">ACTION</th>
                            </tr>
                            <tr>
                                <td class="pt-3-half" contenteditable="true">Sales Performance</td>
                                <td class="pt-3-half" contenteditable="true">Quickbooks</td>
                                <td class="pt-3-half" contenteditable="true"></td>
                                <td class="pt-3-half" contenteditable="true">
                                    <select>
                                        <option>All Dates</option>
                                        <option>Custom</option>
                                        <option>Today</option>
                                        <option>This Week</option>
                                        <option>This Week-to-Date</option>
                                        <option>This Month</option>
                                        <option>This Month-to-Date</option>
                                        <option>This Quarter</option>
                                        <option>This Quarter-to-Date</option>
                                        <option>This Year</option>
                                        <option>This Year-to-Date</option>
                                        <option>This Yeat-to-last-month</option>
                                        <option>Yesterday</option>
                                        <option>Recent</option>
                                        <option>Last Week</option>
                                        <option>Last Week-to-Date</option>
                                        <option>Last Month</option>
                                        <option>Last Quarter</option>
                                        <option>Last Quarter-to-Date</option>
                                        <option>Last Year</option>
                                        <option>Last Year-to-Date</option>
                                        <option>Since 30 Days Ago</option>
                                        <option>Since 60 Days Ago</option>
                                        <option>Since 90 Days Ago</option>
                                        <option>Since 365 Days Ago</option>
                                        <option>Next Week</option>
                                        <option>Next 4 Weeks</option>
                                        <option>Next Month</option>
                                        <option>Next Quarter</option>
                                        <option>Next Year</option>
                                    </select>
                                </td>
                                <td>
                                    <span class="table-add mb-3 mr-2"><a href="#!" class="text-info"><i aria-hidden="true">View</i></a></span>
                                    <select>
                                        <option></option>
                                        <option>Edit</option>
                                        <option>Send</option>
                                        <option>Export as PDF</option>
                                        <option>Export as DOCX</option>
                                        <option>Copy</option>
                                    </select>
                                </td>
                            </tr>
                            <!-- This is our clonable table line -->
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
@endsection