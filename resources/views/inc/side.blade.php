<nav class="navbar navbar-expand-sm navbar-default">

    <div class="navbar-header">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>
    </div>
    <?php
        $overduetransaction=0;
        ?>
    @foreach($expense_transactions as $et)
        @if ($et->et_type==$et->et_ad_type)
            @if($et->et_due_date!="")
            <?php
            $date1=date_create(date('Y-m-d'));
            $date2=date_create($et->et_due_date);
            $diff=date_diff($date1,$date2);
            ?>
            @if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && $et->et_bil_status!="Paid" && $et->remark=="" )
            <?php
            $overduetransaction++;
            ?>
            @else
            @endif
            @endif
        @endif
    @endforeach
    <?php
    $overduesalestransaction=0;
    ?>
    @foreach ($SS as $ST)
    
    @if($ST->st_due_date!="")
        <?php
        $date1=date_create(date('Y-m-d'));
        $date2=date_create($ST->st_due_date);
        $diff=date_diff($date1,$date2);
        ?>
        
        @if(($diff->format("%R")=="-" || ($diff->format("%R")=="+" && $diff->format("%a")=="0")) && ($ST->st_status=="Open" || $ST->st_status=="Partially paid" ) && $ST->remark=="")
        <?php
        $overduesalestransaction++;
        ?>
        @else
        
        @endif
    @endif
    @endforeach
    <?php
    $pendingapprovals=0;
    ?>
    @if(count($UserAccessList)>0)
    @if ($UserAccessList[0]->approval_bank=="1")
    @foreach ($BankEdits as $item)
        @if ($item->edit_status=="0")
        <?php
        $pendingapprovals++;
        ?>
        @endif
    @endforeach
    @endif 
    @if ($UserAccessList[0]->approval_cc=="1")
    @foreach ($CostCenterEdit as $item)
        @if ($item->edit_status=="0")
        <?php
        $pendingapprovals++;
        ?>
        @endif
    @endforeach
    @endif
    @if ($UserAccessList[0]->approval_coa=="1")
    @foreach ($COAEdits as $item)
        @if ($item->edit_status=="0")
        <?php
        $pendingapprovals++;
        ?>
        @endif
    @endforeach
    @endif
    @if ($UserAccessList[0]->approval_product_services=="1")
    @foreach ($ProductAndServicesEdit as $item)
        @if ($item->edit_status=="0")
        <?php
        $pendingapprovals++;
        ?>
        @endif
    @endforeach
    @endif
    @if ($UserAccessList[0]->approval_customer=="1" || $UserAccessList[0]->approval_supplier=="1")
    @foreach ($CustomerEdit as $item)
        @if ($item->edit_status=="0")
        <?php
        $pendingapprovals++;
        ?>
        @endif
    @endforeach
    @endif
    @if ($UserAccessList[0]->approval_sales=="1")
    @foreach ($SalesTransactionEdit as $item)
        @if ($item->edit_status=="0")
        <?php
        $pendingapprovals++;
        ?>
        @endif
    @endforeach
    @endif
    @if ($UserAccessList[0]->approval_expense=="1")
    @foreach ($ExpenseTransactionEdit as $item)
        @if ($item->edit_status=="0")
        <?php
        $pendingapprovals++;
        ?>
        @endif
    @endforeach
    @endif
    @if ($UserAccessList[0]->approval_pending_bills=="1")
    @foreach ($EXNew as $EXn)
    <?php
    $pendingapprovals++;
    ?>
    @endforeach
    @endif
    @if ($UserAccessList[0]->approval_boq=="1")
    @foreach ($BudgetsEdit as $budgggettt)
    @if ($budgggettt->edit_status!="1")
    <?php
    $pendingapprovals++;
    ?>  
    @endif
    
    @endforeach
    @endif
    @endif
    <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="active"><a href="dashboard" > <i class="menu-icon fas fa-tachometer-alt"></i>Dashboard </a></li>
                <h3 class="menu-title" style="margin-bottom:10px;">Menu</h3><!-- /.menu-title -->
                <li><a href="banking" style="display:none;"> <i class="menu-icon fas fa-wallet width30"></i>Banking</a></li>
                @if(count($UserAccessList)>0)
                @if ($UserAccessList[0]->user_approval=="1")
                <li><a href="pending_user"  style="padding:5px 0;"> <i class="menu-icon fas fa-address-book width30"></i>User Access Approvals</a></li>
                @endif
                @endif
                @if(count($UserAccessList)>0)
                @if ($UserAccessList[0]->approvals=="1")
                <li><a href="approvals" style="padding:5px 0;"> <i class="menu-icon fas fa-check-square width30"></i>Approvals <span style="border-radius:10rem;{{$pendingapprovals>0? ''  : 'display:none;'}}" class="badge badge-pill badge-danger">{{$pendingapprovals}}</span></a></li>
                @endif
                @endif
                @if(count($UserAccessList)>0)
                @if ($UserAccessList[0]->journal_entry=="1")
                <li><a href="journalentry" style="padding:5px 0;"> <i class="menu-icon fas fa-columns width30"></i>Journal Entry</a></li>
                @endif
                @endif
                
                {{-- <li><a href="voucher" ><i class="menu-icon fa ti-agenda width30"></i>Voucher</a></li> --}}
                @if(count($UserAccessList)>0)
                @if ($UserAccessList[0]->sales=="1")
                <li><a href="sales" style="padding:5px 0;"> <i class="menu-icon fas fa-chart-area width30"></i>Sales <span style="border-radius:10rem;{{$overduesalestransaction>0? ''  : 'display:none;'}}" class="badge badge-pill badge-danger">{{$overduesalestransaction}}</span></a></li>
                @endif
                @endif
                @if(count($UserAccessList)>0)
                @if ($UserAccessList[0]->expense=="1")
                <li><a href="expenses" style="padding:5px 0;"> <i class="menu-icon fas fa-money-bill width30"></i>Expenses <span style="border-radius:10rem; {{$overduetransaction>0? ''  : 'display:none;'}}" class="badge badge-pill badge-danger">{{$overduetransaction}}</span></a></li>
                @endif
                @endif
                @if(count($UserAccessList)>0)
                @if ($UserAccessList[0]->reports=="1")
                <li><a href="reports" style="padding:5px 0;"> <i class="menu-icon far fa-file width30"></i>Reports</a></li>
                @endif
                @endif
                <li><a style="display:none;" href="taxes"> <i class="menu-icon fas fa-chart-line width30"></i>Taxes</a></li>
                @if(count($UserAccessList)>0)
                @if ($UserAccessList[0]->chart_of_accounts=="1")
                <li><a href="accounting" style="padding:5px 0;"> <i class="menu-icon fas fa-receipt width30"></i>Accounting</a></li>
                @endif
                @endif
                @if(count($UserAccessList)>0)
                @if ($UserAccessList[0]->cost_center=="1")
                <li><a href="cost_center" style="padding:5px 0;"> <i class="menu-icon fas fa-receipt width30"></i>Cost Center</a></li>
                @endif
                @endif
            <h3 class="menu-title" style="margin-bottom:10px;">Create</h3><!-- /.menu-title -->
            @if(count($UserAccessList)>0)
            @if ($UserAccessList[0]->sales=="1")
            <li class="menu-item-has-children dropdown">
                <a href="#" style="padding:5px 0;" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-user-tie width30"></i>Customers</a>
                <ul class="sub-menu children dropdown-menu" style="right:-190px;">
                        @if(count($UserAccessList)>0)
                    @if ($UserAccessList[0]->invoice=="1")
                    <li><a style="padding:2px 0px 2px 0px;" href="invoice" data-toggle="modal" data-target="#invoicemodal"><i class="menu-icon fas fa-chart-area"></i> Invoice</a></li>
                    @endif
                    @endif
                    @if(count($UserAccessList)>0)
                    @if ($UserAccessList[0]->estimate=="1")
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="receivepayment" data-toggle="modal" data-target="#receivepaymentmodal"><i class="menu-icon fas fa-chart-area"></i> Receive Payment</a></li>
                    <li><a style="padding:2px 0px 2px 0px;" href="estimate" data-toggle="modal" data-target="#estimatemodal"><i class="menu-icon fas fa-chart-area"></i> Estimate</a></li>
                    @endif
                    @endif
                    @if(count($UserAccessList)>0)
                    @if ($UserAccessList[0]->credit_note=="1")
                    <li><a style="padding:2px 0px 2px 0px;" href="creditnotice" data-toggle="modal" data-target="#creditnotemodal"><i class="menu-icon fas fa-chart-area"></i> Credit Notice</a></li>
                    @endif
                    @endif
                    @if(count($UserAccessList)>0)
                    @if ($UserAccessList[0]->sales_recipt=="1")
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="salesreceipt" data-toggle="modal" data-target="#salesreceiptmodal"><i class="menu-icon fas fa-chart-area"></i> Sales Receipt</a></li>
                    @endif
                    @endif
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="refundreceipt" data-toggle="modal" data-target="#refundreceiptmodal"><i class="menu-icon fas fa-chart-area"></i> Refund Receipt</a></li>
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="delayedcredit" data-toggle="modal" data-target="#delayedcreditmodal"><i class="menu-icon fas fa-chart-area"></i> Delayed Credit</a></li>
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="delayedcharge" data-toggle="modal" data-target="#delayedchargemodal"><i class="menu-icon fas fa-chart-area"></i> Delayed Charge</a></li>
                </ul>
            </li>
            @endif
            @endif
            @if(count($UserAccessList)>0)
            @if ($UserAccessList[0]->expense=="1")
            <li class="menu-item-has-children dropdown">
                <a href="#" style="padding:5px 0;" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list width30"></i>Suppliers</a>
                <ul class="sub-menu children dropdown-menu" style="right:-190px;">
                    <li><a style="padding:2px 0px 2px 0px;display:none" href="expense" data-toggle="modal" data-target="#expensemodal"><i class="menu-icon fa fa-list-alt "></i> Expense</a></li>
                    <li><a style="padding:2px 0px 2px 0px;display:none" href="cheque" data-toggle="modal" data-target="#chequemodal"><i class="menu-icon fa fa-th-large "></i> Cheque</a></li>
                    @if(count($UserAccessList)>0)
                    @if ($UserAccessList[0]->bill=="1")
                    <li><a style="padding:2px 0px 2px 0px;" href="bill" data-toggle="modal" data-target="#billmodal"><i class="menu-icon fas fa-money-bill"></i> Bill</a></li>
                    @endif
                    @endif
                    @if(count($UserAccessList)>0)
                    @if ($UserAccessList[0]->pay_bills=="1")
                    <li><a style="padding:2px 0px 2px 0px;" href="paybills" data-toggle="modal" data-target="#paybillsmodal"><i class="menu-icon fa fa-paperclip "></i> Pay Bills</a></li>
                    @endif
                    @endif
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="purchaseorder" data-toggle="modal" data-target="#purchaseordermodal"> <i class="menu-icon fa fa-th-large "></i> Purchase Order</a></li>
                    @if(count($UserAccessList)>0)
                    @if ($UserAccessList[0]->supplier_credit=="1")
                    <li><a style="padding:2px 0px 2px 0px;" href="suppliercredit" data-toggle="modal" data-target="#suppliercreditmodal"> <i class="menu-icon fas fa-money-bill"></i>Supplier Credit</a></li>
                    @endif
                    @endif
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="creditcardcredit" data-toggle="modal" data-target="#creditcardcreditmodal"><i class="menu-icon fa fa-paperclip "></i> Credit Card Credit</a></li>
                </ul>
            </li>
            @endif
            @endif
            @if(count($UserAccessList)>0)
            @if ($UserAccessList[0]->fund_feeds=="1")
            <li class="menu-item-has-children dropdown">
                <a href="#" style="padding:5px 0;" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-wrench width30"></i>Fund Feeds</a>
                <ul class="sub-menu children dropdown-menu" style="right:-190px;">
                    <li><a style="padding:2px 0px 2px 0px;" href="#" data-toggle="modal" data-target="#bankdepositmodal"><i class="menu-icon fa fa-download"></i>Undeposited Funds</a></li>
                    <li><a style="padding:2px 0px 2px 0px;" href="checkregister" ><i class="menu-icon fa fa-money-bill"></i>Deposited Funds</a></li>
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="budgeting"  data-toggle="modal" data-target="#AddBudgetModal"><i class="menu-icon fas fa-money-bill"></i> Budgeting</a></li>
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="transfer" data-toggle="modal" data-target="#transfermodal"><i class="menu-icon fa fa-upload"></i> Transfer</a></li>
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="statements"><i class="menu-icon fas fa-book"></i> Statements</a></li>
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="investqtyadj" data-toggle="modal" data-target="#investqtyadjmodal"><i class="menu-icon fas fa-book"></i> Invest Qty Adjustment</a></li>
                </ul>
            </li>
            @endif
            @endif
            @if(count($UserAccessList)>0)
            @if ($UserAccessList[0]->settings=="1")
            <h3 class="menu-title" style="margin-bottom:10px;">Settings</h3><!-- /.menu-title -->

            <li class="menu-item-has-children dropdown">
                <a href="#" style="padding:5px 0;" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-home width30"></i>Your Company</a>
                <ul class="sub-menu children dropdown-menu" style="right:-190px;">
                    <li><a style="padding:2px 0px 2px 0px;" href="accountsandsettings"><i class="menu-icon fas fa-cog width30"></i> System Settings</a></li>
                    <li><a style="padding:2px 0px 2px 0px;" href="customformstyles"><i class="menu-icon fas fa-list-alt"></i> Custom Form Styles</a></li>
                    
                </ul>
            </li>
            @endif
            @endif
            <li class="menu-item-has-children dropdown" style="display:none;">
                <a href="#" style="padding:5px 0;" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list width30"></i>Lists</a>
                <ul class="sub-menu children dropdown-menu" style="right:-190px;">
                    <li><a style="padding:2px 0px 2px 0px;" href="alllists"><i class="menu-icon fa fa-list-alt padding0"></i> All Lists</a></li>
                    <li><a style="padding:2px 0px 2px 0px;" href="sales"><i class="menu-icon fa fa-th-large padding0"></i> Products and Services</a></li>
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="recurringtransactions"><i class="menu-icon fas fa-file"></i> Recurring Transactions</a></li>
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="attachments"><i class="menu-icon fa fa-paperclip "></i> Attachments</a></li>
                </ul>
            </li>

            <li class="menu-item-has-children dropdown" style="display:none;">
                <a href="#" style="padding:5px 0;" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-wrench width30"></i>Tools</a>
                <ul class="sub-menu children dropdown-menu" style="right:-190px;">
                    <li><a style="padding:2px 0px 2px 0px;" href="importdata"><i class="menu-icon fa fa-download"></i> Import Data</a></li>
                    <li><a style="padding:2px 0px 2px 0px;" href="exportdata"><i class="menu-icon fa fa-upload"></i> Export Data</a></li>
                    
                    
                    <li><a style="padding:2px 0px 2px 0px;display:none;" href="auditlog"><i class="menu-icon fas fa-file-alt"></i> Audit Log</a></li>
                </ul>
            </li>
        </ul>
    </div>

</nav>
