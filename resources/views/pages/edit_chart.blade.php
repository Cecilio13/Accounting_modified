@extends('layout.initial')


@section('content')
<div class="container" >
        <h1>Edit Chart of Account</h1>

        <form action="{{ action('ChartofAccountsController@update', ['id' => $chart->id]) }}" method="POST" >
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">
        
        <div class="col-md-6 p-1">
            <div class="mb-3" style="display:none;">
            <select class="w-100 pt-1" id="accounttypeType2" onchange="changeaccounttype2()" >
                <option value="default">Default</option>
                <option value="defined">Company Defined Account Type</option>
            </select>
            </div>
            <div class="mb-3">
                <p>Account Classification</p>
                <select id="coatitl2e"   type="text" name="coatitl2e"  class="w-100" onchange="changelistlineitem2(this)">
                    <option>{{$chart->coa_title}}</option>
                    <option>Assets</option>
                    <option>Liabilities</option>
                    <option>Equity</option>
                    <option>Revenues</option>
                    <option>Expenses</option>
                    
                </select>
                    <datalist id="account_title_datalist">
                    <option>Assets</option>
                    <option>Liabilities and Equity</option>
                    <option>Income</option>
                    <option>Expense</option>
                    
                </datalist>
            
            </div>
            <div class="mb-3">
                <p>Line Item</p>
                <select id="coaAccountType2" name="ACCType2" class="w-100 pt-1" onchange="ChangeDetailType2()" style="display:none;">
                    <option>Bank</option>
                    <option>Accounts receivable (A/R)</option>
                    <option>Other Current Assets</option>
                    <option>Fixed Assets</option>
                    <option>Other Assets</option>
                    <option>Accounts Payable (A/P)</option>
                    <option>Credit Card</option>
                    <option>Other Current Liabilities</option>
                    <option>Long Term Liabilities</option>
                    <option>Equity</option>
                    <option>Income</option>
                    <option>Cost of Goods Sales</option>
                    <option>Expenses</option>
                    <option>Other Income</option>
                    <option>Other Expenses</option>
                    <option selected>Custom</option>
                </select>
                
                <input type="text" class="w-100" style="display:none;" name="customaccounttype2"  id="customaccount2" list="line_item_choices_list_asset2"> 
                <datalist id="line_item_choices_list_asset2">
                    <option>Current Asset</option>
                    <option>Non-Current Asset</option>
                    <option>Other Current Assets</option>
                    <option>Fixed Assets</option>
                    <option>Other Assets</option>
                </datalist>
                <datalist id="line_item_choices_list_liability2">
                    <option>Current Liabilities</option>
                    <option>Other Current Liabilities</option>
                    <option>Long Term Liabilities</option>
                </datalist>
                <datalist id="line_item_choices_list_equity2">
                    <option>Equity</option>
                </datalist>
                <datalist id="line_item_choices_list_revenue2">
                    <option>Revenue</option>
                </datalist>
                <datalist id="line_item_choices_list_expense2">
                    <option>Expense</option>
                    <option>Other Expenses</option>
                </datalist>
                
            </div>
            <script>
                function changelistlineitem2(e){
                   var input_item_line=document.getElementById('customaccount2');
                   if(e.value=="Assets"){
                       input_item_line.setAttribute('list','line_item_choices_list_asset2');
                   }
                   if(e.value=="Liabilities"){
                       input_item_line.setAttribute('list','line_item_choices_list_liability2');
                   }
                   if(e.value=="Equity"){
                       input_item_line.setAttribute('list','line_item_choices_list_equity2');
                   }
                   if(e.value=="Revenues"){
                       input_item_line.setAttribute('list','line_item_choices_list_revenue2');
                   }
                   if(e.value=="Expenses"){
                       input_item_line.setAttribute('list','line_item_choices_list_expense2');
                   }
               }
                $(document).ready(function(){

                    
                    if('{{$chart->coa_account_type}}'=="Bank" || '{{$chart->coa_account_type}}'=="Accounts receivable (A/R)" ||'{{$chart->coa_account_type}}'=="Other Current Assets" ||'{{$chart->coa_account_type}}'=="Fixed Assets" ||'{{$chart->coa_account_type}}'=="Other Assets" ||'{{$chart->coa_account_type}}'=="Accounts Payable (A/P)" ||'{{$chart->coa_account_type}}'=="Credit Card" ||'{{$chart->coa_account_type}}'=="Other Current Liabilities" ||'{{$chart->coa_account_type}}'=="Equity" ||'{{$chart->coa_account_type}}'=="Income" ||'{{$chart->coa_account_type}}'=="Cost of Goods Sales" ||'{{$chart->coa_account_type}}'=="Expenses" ||'{{$chart->coa_account_type}}'=="Other Income" ||'{{$chart->coa_account_type}}'=="Other Expenses" ||'{{$chart->coa_account_type}}'=="Custom" ){
                        
                    }else{
                        document.getElementById("accounttypeType2").value="default";
                        changeaccounttype2();

                    }
                    document.getElementById('coaAccountType2').value='';
                        if(document.getElementById('coaAccountType2').value==""){
                            document.getElementById('coaAccountType2').value='Custom';
                            document.getElementById('customaccount2').value="{!!$chart->coa_account_type!!}";
                            document.getElementById('customdetail2').value="{!!$chart->coa_detail_type!!}";
                        }
                    ChangeDetailType2();
                    document.getElementById('coaDetailType2').value="{!!$chart->coa_detail_type!!}";
                    
                    ChangeTypeDesc2(); 
                })
                function changeaccounttype2(){
                            var Type = document.getElementById("accounttypeType2").value;
                            var x = document.getElementById("coaAccountType2");
                            var length = x.options.length;
                            
                            for (i = length-1; i>=0; i--) {
                                
                                x.options[i] = null;
                            }
                            if(Type=="defined"){
                                var a = document.createElement("option");
                                a.text = "Cash";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Receivable Account";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Inventories";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Prepayment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Land, Building and Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Equipment and Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Asset Contra Accounts";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Website Development Cost ( Planning and design )";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Payable Accounts";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Payables";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Equity";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Revenues";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Purchases, Freight In, and Subcontractor Expense";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Salaries and Wages";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Compensations";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Personnel Benefit Contribution";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Personnel Benefit";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Supplies Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Tranportation and Training Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Utility Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Corporate Security";
                                x.options.add(a);
                                a.text = "Communication and Printing Expenses";
                                x.options.add(a);
                                a.text = "Taxes, Duties and Premiums";
                                x.options.add(a);
                                a.text = "Representation and Commision Expenses";
                                x.options.add(a);
                                a.text = "Awards and Rewards";
                                x.options.add(a);
                                a.text = "Rent/Lease Expenses";
                                x.options.add(a);
                                a.text = "Food, Notary and Extraordinary and Miscellaneous Expenses, Other Expenses";
                                x.options.add(a);
                                a.text = "Repair and Maintenance";
                                x.options.add(a);
                                a.text = "Professional Services";
                                x.options.add(a);
                                a.text = "Doubtful Accounts and Depreciation";
                                x.options.add(a);
                                a.text = "Gain and Losses";
                                x.options.add(a);
                                a.text = "Financial Expenses";
                                x.options.add(a);
                                a.text = "Other Company Expenses";
                                x.options.add(a);
                                a.text = "Intermidiate Accounts";
                                x.options.add(a);
                            }else{
                                var a = document.createElement("option");
                                a.text = "Bank";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accounts receivable (A/R)";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Current Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Fixed Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accounts Payable (A/P)";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Credit Card";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Current Liabilities";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Long Term Liabilities";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Equities";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Income";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Cost of Goods Sales";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Income";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Custom";
                                x.options.add(a);
                            }
                            ChangeDetailType2();
                        }
                function ChangeDetailType2(){
                   var coaAccountType=document.getElementById('coaAccountType2').value;
                   var x = document.getElementById("coaDetailType2");
                   var length = x.options.length;
                   
                    for (i = length-1; i>=0; i--) {
                        
                        x.options[i] = null;
                    }
                    x.style.display="inline-block";
                    document.getElementById('customaccount2').style.display="none";
                    document.getElementById('customdetail2').style.display="none";
                    document.getElementById('TypeDescriptionTextArea2').value=""; 
                   switch(coaAccountType) {
                    case 'Cash':
                                var a = document.createElement("option");
                                a.text = "Cash in Bank – Local Currency";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Cash in Bank – Foreign Currency";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Petty Cash Fund";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Petty Cash Fund-Special Fund";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Revolving Fund";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Mid-year Fund";
                                x.options.add(a);
                                
                                break;
                            case 'Receivable Accounts':
                                var a = document.createElement("option");
                                a.text = "Accounts Receivable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Rent/Lease Receivable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Due from Officers and Employees ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Receivable – Disallowances/Charges";
                                x.options.add(a);
                                
                                break;
                            case 'Inventories':
                                var a = document.createElement("option");
                                a.text = "PPE Supplies";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Unused Supplies and Materials ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Spare Parts Inventory";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Inventories";
                                x.options.add(a);
                                
                                break;
                            case 'Prepayment':
                                var a = document.createElement("option");
                                a.text = "Prepaid Rent";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Prepaid Fuel, Oil and Lubricant";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Prepaid Insurance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Prepaid Bond- Performance Bond";
                                x.options.add(a);
                                
                                break;
                            case 'Land, Building and Improvements':
                                var a = document.createElement("option");
                                a.text = "Land";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Land Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Building";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Building Improvements";
                                x.options.add(a);
                                
                                break;
                            case 'Equipment and Improvements':
                                var a = document.createElement("option");
                                a.text = "Office Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "IT Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Communication Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Trucks, Vehicle & Heavy Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Construction Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Tools and  Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Engineering Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Furniture and Fixture";
                                x.options.add(a);
                                break;
                            case 'Improvements':
                                var a = document.createElement("option");
                                a.text = "Capital Improvements- Trucks, Vehicle & Heavy Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Capital Improvements- Construction Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Capital Improvements- Engineering Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Capital Improvements- Furniture and Fixture";
                                x.options.add(a);
                                
                                break;
                            case 'Asset Contra Accounts':
                                var a = document.createElement("option");
                                a.text = "Allowance for Doubtful Accounts";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Land Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Buildings";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Office Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – IT Equipment ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Communication Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Trucks, Vehicle and Heavy Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Construction Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Tools and Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Engineering Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accumulated Depreciation – Furnitures and Fixtures";
                                x.options.add(a);
                                break;
                            case 'Website Development Cost ( Planning and design )':
                                var a = document.createElement("option");
                                a.text = "Website Development Cost";
                                x.options.add(a);
                                break;
                            case 'Payable Accounts':
                                var a = document.createElement("option");
                                a.text = "Accounts Payable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Notes Payable";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Interest Payable";
                                x.options.add(a);
                                break;
                            case 'Other Payables':
                                var a = document.createElement("option");
                                a.text = "Deferred Income";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Bonds Payable- Employee's Cash Bond";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accrued Rent Expense";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accrued Salaries and Wages Expense";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accrued Utility Expense";
                                x.options.add(a);
                                break;
                            case 'Equities':
                                var a = document.createElement("option");
                                a.text = "Arkcons, Capital ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Arkcons, Drawing";
                                x.options.add(a);
                                break;
                            case 'Revenues':
                                var a = document.createElement("option");
                                a.text = "Service Revenue";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Rent/Lease Income ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Accrued Income";
                                x.options.add(a);
                                break;
                            case 'Purchases, Freight In, and Subcontractor Expense':
                                var a = document.createElement("option");
                                a.text = "Purchases- Direct Materials";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Purchases- Supplies";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Freight In";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Subcontractor Expense";
                                x.options.add(a);
                                break;
                            case 'Salaries and Wages':
                                var a = document.createElement("option");
                                a.text = "Salaries and Wages – Regular";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Salaries and Wages – Local";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Salaries and Wages – Agency";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Salaries and Wages- Agency share and benefits";
                                x.options.add(a);
                                break;
                            case 'Other Compensations':
                                var a = document.createElement("option");
                                a.text = "Cost of Living Allowance (COLA)";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Meal Allowance ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Interruption Allowance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Night Patroll Allowance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Emergency Call Allowance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Travel Allowance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Clothing and Uniform Allowance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Motorcycle Allowance";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Honoraria";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Mid-year Bonus / Year-end Bonus";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Hazard Allowance";
                                x.options.add(a);
                                break;
                            case 'Personnel Benefit Contribution':
                                var a = document.createElement("option");
                                a.text = "SSS Contributions";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "PAG-IBIG Contributions";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "PHILHEALTH Contributions";
                                x.options.add(a);
                                break;
                            case 'Other Personnel Benefit':
                                var a = document.createElement("option");
                                a.text = "Vacation and Sick Leave Benefits";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Overtime and Holiday Pay";
                                x.options.add(a);
                                break;
                            case 'Supplies Expenses':
                                var a = document.createElement("option");
                                a.text = "Office Supplies Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Fuel, Oil and Lubricants Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repair and Maintenance Supplies Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "PPE Supplies Expense";
                                x.options.add(a);
                                break;
                            case 'Tranportation and Training Expenses':
                                var a = document.createElement("option");
                                a.text = "Transportation Expenses ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Training Expense";
                                x.options.add(a);
                                break;
                            case 'Utility Expenses':
                                var a = document.createElement("option");
                                a.text = "Water";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Electricity";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Fuel";
                                x.options.add(a);
                                break;
                            case 'Corporate Security':
                                var a = document.createElement("option");
                                a.text = "Corporate Security";
                                x.options.add(a);
                                break;
                            case 'Communication and Printing Expenses':
                                var a = document.createElement("option");
                                a.text = "Freight and Handling";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Telephone Expenses – Landline";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Telephone Expenses – Mobile";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Internet Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Printing  Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Advertisement Expense";
                                x.options.add(a);
                                break;
                            case 'Taxes, Duties and Premiums':
                                var a = document.createElement("option");
                                a.text = "Taxes, Duties and Licenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Income Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Documentary Stamp Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Travel Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Motor Vehicles Users Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Real Property  Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Percentage Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Fines and Penalties – Tax Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "License Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Registration Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Inspection Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Processing Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Clearance and Certification Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Permit Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Fines and Penalties – Fees, Permits and License Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Parking/Terminal Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Toll Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Fines and Penalties – Business Fees Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Insurance Premiums ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Bond-Performance Bond Expense";
                                x.options.add(a);

                                break; 
                            case 'Representation and Commision Expenses':
                                var a = document.createElement("option");
                                a.text = "Representation Expenses ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Commission Expenses";
                                x.options.add(a);
                                break; 
                            case 'Awards and Rewards':
                                var a = document.createElement("option");
                                a.text = "Awards and Rewards";
                                x.options.add(a);
                                break; 
                            case 'Rent/Lease Expenses':
                                var a = document.createElement("option");
                                a.text = "Rent/Lease Expenses";
                                x.options.add(a);
                                break; 
                            case 'Food, Notary and Extraordinary and Miscellaneous Expenses, Other Expenses':
                                var a = document.createElement("option");
                                a.text = "Food Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Extraordinary and Miscellaneous Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Notary Fee";
                                x.options.add(a);
                                break; 
                            case 'Repair and Maintenance':
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Land Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Buildings";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Office Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – IT Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Communication Equipment ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Trucks, Vehicle and Heavy Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Construction Equipment ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Tools and Equipment ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Engineering Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Repairs and Maintenance – Furniture and Fixtures";
                                x.options.add(a);
                                break;
                            case 'Professional Services':
                                var a = document.createElement("option");
                                a.text = "Legal Services";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Bookkeeping Services";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Engineering Services";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Professional Services ";
                                x.options.add(a);
                                break; 
                            case 'Doubtful Accounts and Depreciation':
                                var a = document.createElement("option");
                                a.text = "Doubtful Accounts Expenses ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Land Improvements";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Buildings";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Office Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – IT Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Communication Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Trucks, Vehicle and Heavy Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Construction Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Tools and Equipment";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Engineeringl Machinery";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Depreciation – Furniture and Fixtures";
                                x.options.add(a);
                                break; 
                            case 'Gain and Losses':
                                var a = document.createElement("option");
                                a.text = "Loss on Assets";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Losses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Gain on Asset";
                                x.options.add(a);
                                break; 
                            case 'Financial Expenses':
                                var a = document.createElement("option");
                                a.text = "Bank Charges  ";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Service Charge";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Interest Expenses";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Mortgage Fee";
                                x.options.add(a);
                                break; 
                            case 'Other Company Expenses':
                                var a = document.createElement("option");
                                a.text = "Bidding Cost";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Importation Expense";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Other Company Expense";
                                x.options.add(a);
                                
                                break; 
                            case 'Intermidiate Accounts':
                                var a = document.createElement("option");
                                a.text = "Provision for Income Tax";
                                x.options.add(a);
                                var a = document.createElement("option");
                                a.text = "Income and Expense Summary";
                                x.options.add(a);
                                break;   
                    case 'Custom':
                        x.style.display="none";
                        document.getElementById('customaccount2').style.display="inline-block";
                        document.getElementById('customdetail2').style.display="inline-block";
                        
                        break;
                    case 'Bank':
                        var a = document.createElement("option");
                        a.text = "Cash on hand";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Checking";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Money Market";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Rents Held in Trust";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Savings";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Trust account";
                        x.options.add(a);
                        break;
                    case 'Accounts receivable (A/R)':
                    var a = document.createElement("option");
                        a.text = "Account recievable (A/R)";
                        x.options.add(a);
                    
                        break;
                    case 'Other Current Assets':
                        var a = document.createElement("option");
                        a.text = "Allowance for Bad Debts";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Development Costs";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Employee Cash Advances";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Inventory";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Investment-Mortgage/Real Estate Loans";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Investment-Tax-Exempt Securities";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Investment-U.S. Government Obligation";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Investment-Other";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Loans To Officers";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Loan To Others";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Loans To Stockholders";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Other Current Assets";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Prepaid Expenses";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Retainage";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Undeposited Funds";
                        x.options.add(a);

                        break;
                    case 'Fixed Assets':
                    var a = document.createElement("option");
                        a.text = "Accumulated Amortization";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Accumulated Depletion";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Accumulated Depreciation";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Buildings";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Depletable Assets";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Furniture & Fixtures";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Intangible Assets";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Land";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Leasehold Improvement";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Loan Machinery & Equipment";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Other Fixed Assets";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Vehicles";
                        x.options.add(a);
                       
                        break;
                    case 'Other Assets':
                        var a = document.createElement("option");
                        a.text = "Accumulated Amortization of Other Assets";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Goodwill";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Lease Buyout";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Licenses";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Organizational Costs";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Other Long-term Assets";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Security Deposit";
                        x.options.add(a);
                        break;
                    case 'Accounts Payable (A/P)':
                        var a = document.createElement("option");
                        a.text = "Accounts Payable (A/P)";
                        x.options.add(a);
                        break;
                    case 'Credit Card':
                        var a = document.createElement("option");
                        a.text = "Credit Card";
                        x.options.add(a);
                        break;
                    case 'Other Current Liabilities':
                        var a = document.createElement("option");
                        a.text = "Federal Income Tax Payable";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Insurance Payable";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Other Current Liabilities";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Payroll Clearing";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Payroll Tax Payable";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Prepaid Expenses Payable";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Rents in Trust-Liability";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Sales Tax Payable";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "State/Local Income Tax Payable";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Trust Account-Liability";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Line Of Credit";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Loan Payable";
                        x.options.add(a);
                        break;
                    case 'Long Term Liabilities':
                        var a = document.createElement("option");
                        a.text = "Notes Payable";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Other Long Term Liabilities";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Shareholder Notes Payable";
                        x.options.add(a);
                        break;
                    case 'Equity':
                        var a = document.createElement("option");
                        a.text = "Accumulated Adjustment";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Common Stock";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Opening Balance Equity";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Owner's Equity";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Paid-in Capital or Surplus";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Partner Contribution";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Partner Distribution";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Partner's Equity";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Preffered Stock";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Retained Earnings";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Treasury Stock";
                        x.options.add(a);
                        break;
                    case 'Income':
                        var a = document.createElement("option");
                        a.text = "Discounts/Refunds Given";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Non-Profit Income";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Other Primary Income";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Sales of Product Income";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Service/Fee Income";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Unapplied Cash Payment Income";
                        x.options.add(a);
                        break;
                    case 'Cost of Goods Sales':
                        var a = document.createElement("option");
                        a.text = "Cost of labor - COS";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Equipment Rental - COS";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Other Costs of Services - COS";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Shipping, Freight & Delivery - COS";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Supplies & Materials - COGS";
                        x.options.add(a);
                        break;
                    case 'Expenses':
                        var a = document.createElement("option");
                        a.text = "Advertising/Promotional";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Auto";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Bad Debts";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Bank Charges";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Charitable Contributions";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Cost of Labor";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Dues and subscriptions";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Entertainment";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Entertainment Meals";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Equipment Rental";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Finance costs";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Insurance";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Interest Paid";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Legal & Professional Fees";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Office/General Administrative Expenses";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Other Miscellaneous Service Cost";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Payroll Expenses";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Promotional Meals";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Rent or Lease of Buildings";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Repair & Maintenance";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Shipping, Freight & Delivery";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Supplies & Materials";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Taxes Paid";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Travel";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Travel Meals";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Unapplied Cash Bill Payment Expense";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Utilities";
                        x.options.add(a);
                        
                        break;
                    case 'Other Income':
                        var a = document.createElement("option");
                        a.text = "Dividend Income";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Interest Earned";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Other Investment Income";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Other Miscellaneous Income";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Tax-Exempt Interest";
                        x.options.add(a);
                        break;
                    case 'Other Expenses':
                        var a = document.createElement("option");
                        a.text = "Amortization";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Depreciation";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Exchange Gain or Loss ";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Other Miscellaneous Expense ";
                        x.options.add(a);
                        var a = document.createElement("option");
                        a.text = "Penalties & Settlements";
                        x.options.add(a);
                        break;
                    default:
                        break;
                   }
                  ChangeTypeDesc2();
                }
                function ChangeTypeDesc2(){
                    var DType=document.getElementById('coaDetailType2').value;
                    if(DType=="Account recievable (A/R)"){
                        document.getElementById('TypeDescriptionTextArea2').value="Accounts receivable (also called A/R, Debtors, or Trade and other receivables) tracks money that customers owe you for products or services, and payments customers make.\nQuickBooks Online Plus automatically creates one Accounts receivable account for you.\n\nMost businesses need only one.Each customer has a register, which functions like an Accounts receivable account for each customer.";
                    }
                    if(DType=="Cash on hand"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use a Cash on hand account to track cash your company keeps for occasional expenses, also called petty cash.\nTo track cash from sales that have not been deposited yet, use a pre-created account called Undeposited funds, instead.";
                    }
                    if(DType=="Checking"){
                        document.getElementById('TypeDescriptionTextArea2').value="";
                    }
                    if(DType=="Money Market"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Money market to track amounts in money market accounts.\nFor investments, see Current Assets, instead.";
                    }
                    if(DType=="Rents Held in Trust"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Rents held in trust to track deposits and rent held on behalf of the property owners.\nTypically only property managers use this type of account.";
                    }
                    if(DType=="Savings"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Savings accounts to track your savings and CD activity.\nEach savings account your company has at a bank or other financial institution should have its own Savings type account.";
                    }
                    if(DType=="Trust Account"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Client trust accounts for money held by you for the benefit of someone else.\nFor example, trust accounts are often used by attorneys to keep track of expense money their customers have given them.";
                    }
                    if(DType=="Allowance for Bad Debts"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Allowance for bad debts to estimate the part of Accounts Receivable that you think you might not collect.\nUse this only if you are keeping your books on the accrual basis.";
                    }
                     if(DType=="Development Costs"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Development costs to track amounts you deposit or set aside to arrange for financing, such as an SBA loan, or for deposits in anticipation of the purchase of property or other assets.\nWhen the deposit is refunded, or the purchase takes place, remove the amount from this account.";
                    }
                    if(DType=="Employee Cash Advances"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Employee cash advances to track employee wages and salary you issue to an employee early, or other non-salary money given to employees.\nIf you make a loan to an employee, use the Current asset account type called Loans to others, instead.";
                    }
                    if(DType=="Inventory"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Inventory to track the cost of goods your business purchases for resale.\nWhen the goods are sold, assign the sale to a Cost of sales account.";
                    }
                    if(DType=="Investment-Mortgage/Real Estate Loans"){
                        document.getElementById('TypeDescriptionTextArea2').value="";
                    }
                    if(DType=="Investment-Tax-Exempt Securities"){
                        document.getElementById('TypeDescriptionTextArea2').value="";
                    }
                    if(DType=="Investment-U.S. Government Obligation"){
                        document.getElementById('TypeDescriptionTextArea2').value="";
                    }
                    if(DType=="Investment-Other"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Investments - Other to track the value of investments not covered by other investment account types. Examples include publicly-traded shares, coins, or gold.";
                    }
                    if(DType=="Loans To Officers"){
                        document.getElementById('TypeDescriptionTextArea2').value="If you operate your business as a Corporation, use Loans to officers to track money loaned to officers of your business.";
                    }
                    if(DType=="Loan To Others"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Loans to others to track money your business loans to other people or businesses.\nThis type of account is also referred to as Notes Receivable.";
                    }
                    if(DType=="Loans To Stockholders"){
                        document.getElementById('TypeDescriptionTextArea2').value="If you operate your business as a Corporation, use Loans to Shareholders to track money your business loans to its shareholders.";
                    }
                    if(DType=="Other Current Assets"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Other current assets for current assets not covered by the other types. Current assets are likely to be converted to cash or used up in a year.";
                    }
                    if(DType=="Prepaid Expenses"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Prepaid expenses to track payments for expenses that you won’t recognise until your next accounting period.\nWhen you recognise the expense, make a journal entry to transfer money from this account to the expense account.";
                    }
                    if(DType=="Retainage"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Retainage if your customers regularly hold back a portion of a contract amount until you have completed a project.\nThis type of account is often used in the construction industry, and only if you record income on an accrual basis.";
                    }
                    if(DType=="Undeposited Funds"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Undeposited funds for cash or cheques from sales that haven’t been deposited yet.\nFor petty cash, use Cash on hand, instead.";
                    }
                   if(DType=="Accumulated Amortization"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Accumulated amortisation of non-current assets to track how much you’ve amortised an asset whose type is Non-Current Asset.";
                    }
                    if(DType=="Accumulated Depletion"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Accumulated depletion to track how much you deplete a natural resource.";
                    }
                    if(DType=="Accumulated Depreciation"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Accumulated depreciation on property, plant and equipment to track how much you depreciate a fixed asset (a physical asset you do not expect to convert to cash during one year of normal operations).";
                    }
                    if(DType=="Buildings"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Buildings to track the cost of structures you own and use for your business. If you have a business in your home, consult your accountant.\nUse a Land account for the land portion of any real property you own, splitting the cost of the property between land and building in a logical method. A common method is to mimic the land-to-building ratio on the property tax statement.";
                    }
                    if(DType=="Depletable Assets"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Depletable assets to track natural resources, such as timberlands, oil wells, and mineral deposits.";
                    }
                    if(DType=="Furniture & Fixtures"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Furniture and fixtures to track any furniture and fixtures your business owns and uses, like a dental chair or sales booth.";
                    }
                    if(DType=="Intangible Assets"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Intangible assets to track intangible assets that you plan to amortise. Examples include franchises, customer lists, copyrights, and patents.";
                    }
                    if(DType=="Land"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Land to track assets that are not easily convertible to cash or not expected to become cash within the next year. For example, leasehold improvements.";
                    }
                    if(DType=="Leasehold Improvement"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Leasehold improvements to track improvements to a leased asset that increases the asset’s value. For example, if you carpet a leased office space and are not reimbursed, that’s a leasehold improvement.";
                    }
                    if(DType=="Loan Machinery & Equipment"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Machinery and equipment to track computer hardware, as well as any other non-furniture fixtures or devices owned and used for your business.\nThis includes equipment that you ride, like tractors and lawn mowers. Cars and trucks, however, should be tracked with Vehicle accounts, instead.";
                    }
                    if(DType=="Other Fixed Assets"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Other fixed asset for fixed assets that are not covered by other asset types.\nFixed assets are physical property that you use in your business and that you do not expect to convert to cash or be used up during one year of normal operations.";
                    }
                    if(DType=="Vehicles"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Vehicles to track the value of vehicles your business owns and uses for business. This includes off-road vehicles, air planes, helicopters, and boats.\nIf you use a vehicle for both business and personal use, consult your accountant to see how you should track its value.";
                    }
                    if(DType=="Accumulated Amortization of Other Assets"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Accumulated amortisation of non-current assets to track how much you’ve amortised an asset whose type is Non-Current Asset.";
                    }
                    if(DType=="Goodwill"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Goodwill only if you have acquired another company. It represents the intangible assets of the acquired company which gave it an advantage, such as favourable government relations, business name, outstanding credit ratings, location, superior management, customer lists, product quality, or good labour relations.";
                    }
                    if(DType=="Lease Buyout"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Lease buyout to track lease payments to be applied toward the purchase of a leased asset.\n\nYou don’t track the leased asset itself until you purchase it.";
                    }
                    if(DType=="Licenses"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Licences to track non-professional licences for permission to engage in an activity, like selling alcohol or radio broadcasting.\n\nFor fees associated with professional licences granted to individuals, use a Legal and professional fees expense account, instead.";
                    }
                    if(DType=="Organizational Costs"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Organisational costs to track costs incurred when forming a partnership or corporation.\n\nThe costs include the legal and accounting costs necessary to organise the company, facilitate the filings of the legal documents, and other paperwork.";
                    }
                    if(DType=="Other Long-term Assets"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Other non-current assets to track assets not covered by other types.\n\nNon-current assets are long-term assets that are expected to provide value for more than one year.";
                    }
                    if(DType=="Security Deposit"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Security deposits to track funds you’ve paid to cover any potential costs incurred by damage, loss, or theft.\n\nThe funds should be returned to you at the end of the contract.\n\nIf you collect deposits, use an Other current liabilities account (a Current liability account).";
                    }
                    if(DType=="Accounts Payable (A/P)"){
                        document.getElementById('TypeDescriptionTextArea2').value="Accounts payable (also called A/P, Trade and other payables, or Creditors) tracks amounts you owe to your suppliers.\n\nQuickBooks Online Plus automatically creates one Accounts Payable account for you. Most businesses need only one.";
                    }
                    if(DType=="Credit Card"){
                        document.getElementById('TypeDescriptionTextArea2').value="Credit card accounts track the balance due on your business credit cards.\n\nCreate one Credit card account for each credit card account your business uses.";
                    }
                    if(DType=="Federal Income Tax Payable"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Federal income tax payable if your business keeps records on an accrual basis.\n\nThis account tracks income tax liabilities in the year the income is earned.";
                    }
                    if(DType=="Insurance Payable"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Insurance payable to keep track of insurance amounts due.\n\nThis account is most useful for businesses with monthly recurring insurance expenses.";
                    }
                    if(DType=="Other Current Liabilities"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Other current liabilities to track monies owed by the company and due within one year.";
                    }
                    if(DType=="Payroll Clearing"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Payroll clearing to keep track of any non-tax amounts that you have deducted from employee payroll payments or that you owe as a result of doing payroll. When you forward money to the appropriate suppliers, deduct the amount from the balance of this account.\n\nDo not use this account for tax amounts you have withheld or owe from paying employee wages. For those amounts, use the Payroll tax payable account instead.";
                    }
                    if(DType=="Payroll Tax Payable"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Payroll clearing to keep track of any non-tax amounts that you have deducted from employee payroll payments or that you owe as a result of doing payroll. When you forward money to the appropriate suppliers, deduct the amount from the balance of this account.\n\nDo not use this account for tax amounts you have withheld or owe from paying employee wages. For those amounts, use the Payroll tax payable account instead.";
                    }
                    if(DType=="Prepaid Expenses Payable"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Prepaid expenses payable to track items such as property taxes that are due, but not yet deductible as an expense because the period they cover has not yet passed.";
                    }
                    if(DType=="Rents in Trust-Liability"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Rents in trust - liability to offset the Rents in trust amount in assets.\n\nAmounts in these accounts are held by your business on behalf of others. They do not belong to your business, so should not appear to be yours on your balance sheet. This 'contra' account takes care of that, as long as the two balances match.";
                    }
                    if(DType=="Sales Tax Payable"){
                        document.getElementById('TypeDescriptionTextArea2').value="";
                    }
                    if(DType=="State/Local Income Tax Payable"){
                        document.getElementById('TypeDescriptionTextArea2').value="";
                    }
                    if(DType=="Trust Account-Liability"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Client Trust accounts - liabilities to offset Client Trust accounts in assets.\n\nAmounts in these accounts are held by your business on behalf of others. They do not belong to your business, so should not appear to be yours on your balance sheet. This 'contra' account takes care of that, as long as the two balances match.";
                    }
                    if(DType=="Line Of Credit"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Line of credit to track the balance due on any lines of credit your business has. Each line of credit your business has should have its own Line of credit account.";
                    }
                    if(DType=="Loan Payable"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Loan payable to track loans your business owes which are payable within the next twelve months.\n\nFor longer-term loans, use the Long-term liability called Notes payable, instead.";
                    }
                    if(DType=="Notes Payable"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Notes payable to track the amounts your business owes in long-term (over twelve months) loans.\n\nFor shorter loans, use the Current liability account type called Loan payable, instead.";
                    }
                    if(DType=="Other Long Term Liabilities"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Other non-current liabilities to track liabilities due in more than twelve months that don’t fit the other Non-Current liability account types.";
                    }
                    if(DType=="Shareholder Notes Payable"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Shareholder notes payable to track long-term loan balances your business owes its shareholders.";
                    }
                    if(DType=="Accumulated Adjustment"){
                        document.getElementById('TypeDescriptionTextArea2').value="Some corporations use this account to track adjustments to owner’s equity that are not attributable to net income.";
                    }
                    if(DType=="Common Stock"){
                        document.getElementById('TypeDescriptionTextArea2').value="";
                    }
                    if(DType=="Opening Balance Equity"){
                        document.getElementById('TypeDescriptionTextArea2').value="";
                    }
                    if(DType=="Owner's Equity"){
                        document.getElementById('TypeDescriptionTextArea2').value="Corporations use Owner’s equity to show the cumulative net income or loss of their business as of the beginning of the financial year.";
                    }
                    if(DType=="Paid-in Capital or Surplus"){
                        document.getElementById('TypeDescriptionTextArea2').value="Corporations use Paid-in capital to track amounts received from shareholders in exchange for shares that are over and above the shares’ stated (or par) value.";
                    }
                    if(DType=="Partner Contribution"){
                        document.getElementById('TypeDescriptionTextArea2').value="Partnerships use Partner contributions to track amounts partners contribute to the partnership during the year.";
                    }
                    if(DType=="Partner Distribution"){
                        document.getElementById('TypeDescriptionTextArea2').value="Partnerships use Partner distributions to track amounts distributed by the partnership to its partners during the year.\n\nDon’t use this for regular payments to partners for interest or service. For regular payments, use a Guaranteed payments account (a Expense account in Payroll expenses), instead.";
                    }
                    if(DType=="Partner's Equity"){
                        document.getElementById('TypeDescriptionTextArea2').value="Partnerships use Partner’s equity to show the income remaining in the partnership for each partner as of the end of the prior year.";
                    }
                    if(DType=="Preffered Stock"){
                        document.getElementById('TypeDescriptionTextArea2').value="Corporations use this account to track its preferred shares in the hands of shareholders. The amount in this account should be the stated (or par) value of the shares.";
                    }
                    if(DType=="Retained Earnings"){
                        document.getElementById('TypeDescriptionTextArea2').value="Retained earnings tracks net income from previous financial years.";
                    }
                    if(DType=="Treasury Stock"){
                        document.getElementById('TypeDescriptionTextArea2').value="Corporations use Treasury shares to track amounts paid by the corporation to buy its own shares back from shareholders.";
                    }
                    if(DType=="Discounts/Refunds Given"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Discounts/refunds given to track discounts you give to customers.\n\nThis account typically has a negative balance so it offsets other income.\n\nFor discounts from suppliers, use an expense account, instead.";
                    }
                    if(DType=="Non-Profit Income"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Non-profit income to track money coming in if you are a non-profit organisation";
                    }
                    if(DType=="Other Primary Income"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Other primary income to track income from normal business operations that doesn’t fall into another Income type.";
                    }
                    if(DType=="Sales of Product Income"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Sales of product income to track income from selling products.\n\nThis can include all kinds of products, like crops and livestock, rental fees, performances, and food served.";
                    }
                    if(DType=="Service/Fee Income"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Service/fee income to track income from services you perform or ordinary usage fees you charge.\n\nFor fees customers pay you for late payments or other uncommon situations, use an Other Income account type called Other miscellaneous income, instead.";
                    }
                    if(DType=="Unapplied Cash Payment Income"){
                        document.getElementById('TypeDescriptionTextArea2').value="Unapplied Cash Payment Income reports the Cash Basis income from customers payments you’ve received but not applied to invoices or charges. In general, you would never use this directly on a purchase or sale transaction.";
                    }
                    if(DType=="Cost of labor - COS"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Cost of labour - COS to track the cost of paying employees to produce products or supply services.\n\nIt includes all employment costs, including food and transportation, if applicable.";
                    }
                    if(DType=="Equipment Rental - COS"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Equipment rental - COS to track the cost of renting equipment to produce products or services.\n\nIf you purchase equipment, use a Fixed Asset account type called Machinery and equipment.";
                    }
                    if(DType=="Other Costs of Services - COS"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Other costs of sales - COS to track costs related to services or sales that you provide that don’t fall into another Cost of Sales type.";
                    }
                    if(DType=="Shipping, Freight & Delivery - COS"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Shipping, freight and delivery - COS to track the cost of shipping products to customers or distributors.";
                    }
                    if(DType=="Supplies & Materials - COGS"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Supplies and materials - COS to track the cost of raw goods and parts used or consumed when producing a product or providing a service.";
                    }
                    if(DType=="Advertising/Promotional"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Advertising/promotional to track money spent promoting your company.\n\nYou may want different accounts of this type to track different promotional efforts (Yellow Pages, newspaper, radio, flyers, events, and so on).\n\nIf the promotion effort is a meal, use Promotional meals instead.";
                    } 
                    if(DType=="Auto"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Auto to track costs associated with vehicles.\n\nYou may want different accounts of this type to track petrol, repairs, and maintenance.\n\nIf your business owns a car or lorry, you may want to track its value as a Fixed Asset, in addition to tracking its expenses.";
                    }
                    if(DType=="Bad Debts"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Bad debt to track debt you have written off.";
                    }
                    if(DType=="Bank Charges"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Bank charges for any fees you pay to financial institutions.";
                    }
                    if(DType=="Charitable Contributions"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Charitable contributions to track gifts to charity.";
                    }
                    if(DType=="Cost of Labor"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Cost of labour to track the cost of paying employees to produce products or supply services.\n\nIt includes all employment costs, including food and transportation, if applicable.\n\nThis account is also available as a Cost of Sales (COS) account.";
                    }
                    if(DType=="Dues and subscriptions"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Dues and subscriptions to track dues and subscriptions related to running your business.\n\nYou may want different accounts of this type for professional dues, fees for licences that can’t be transferred, magazines, newspapers, industry publications, or service subscriptions.";
                    }
                    if(DType=="Entertainment"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Entertainment to track events to entertain employees.\n\nIf the event is a meal, use Entertainment meals, instead.";
                    }
                    if(DType=="Entertainment Meals"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Entertainment to track events to entertain employees.\n\nIf the event is a meal, use Entertainment meals, instead.";
                    }
                    if(DType=="Entertainment Meals"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Equipment rental to track the cost of renting equipment to produce products or services.\n\nThis account is also available as a Cost of Sales account.\n\nIf you purchase equipment, use a Fixed asset account type called Machinery and equipment.";
                    }
                    if(DType=="Finance costs"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Finance costs to track the costs of obtaining loans or credit.\n\nExamples of finance costs would be credit card fees, interest and mortgage costs.";
                    }
                    if(DType=="Insurance"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Insurance to track insurance payments.\n\nYou may want different accounts of this type for different types of insurance (auto, general liability, and so on).";
                    }
                    if(DType=="Interest Paid"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Interest paid for all types of interest you pay, including mortgage interest, finance charges on credit cards, or interest on loans.";
                    }
                    if(DType=="Legal & Professional Fees"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Legal and professional fees to track money to pay to professionals to help you run your business.\n\nYou may want different accounts of this type for payments to your accountant, attorney, or other consultants.";
                    }
                    if(DType=="Office/General Administrative Expenses"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Office/general administrative expenses to track all types of general or office-related expenses.";
                    }
                    if(DType=="Other Miscellaneous Service Cost"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Other miscellaneous service cost to track costs related to providing services that don’t fall into another Expense type.\n\nThis account is also available as a Cost of Sales (COS) account.";
                    }
                    if(DType=="Payroll Expenses"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Payroll expenses to track payroll expenses. You may want different accounts of this type for things like:\n\nCompensation of officers\nGuaranteed payments\nWorkers\ncompensation\nSalaries and wages\nPayroll taxes";
                    }
                    if(DType=="Promotional Meals"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Promotional meals to track how much you spend dining with a customer to promote your business.\nBe sure to include who you ate with and the purpose of the meal when you enter the transaction.";
                    }
                    if(DType=="Rent or Lease of Buildings"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Rent or lease of buildings to track rent payments you make.";
                    }
                    if(DType=="Repair & Maintenance"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Repair and maintenance to track any repairs and periodic maintenance fees.\n\nYou may want different accounts of this type to track different types repair & maintenance expenses (auto, equipment, landscape, and so on).";
                    }
                    if(DType=="Shipping, Freight & Delivery"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Shipping, Freight and Delivery to track the cost of shipping products to customers or distributors.\n\nYou might use this type of account for incidental shipping expenses, and the COS type of Shipping, freight & delivery account for direct costs.\n\nThis account is also available as a Cost of Sales (COS) account.";
                    }
                    if(DType=="Supplies & Materials"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Supplies & materials to track the cost of raw goods and parts used or consumed when producing a product or providing a service.\n\nThis account is also available as a Cost of Sales account.";
                    }
                    if(DType=="Taxes Paid"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Taxes paid to track taxes you pay.\n\nYou may want different accounts of this type for payments to different tax agencies.";
                    }
                    if(DType=="Travel"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Travel to track travel costs.\n\nFor food you eat while travelling, use Travel meals, instead.";
                    }
                    if(DType=="Travel Meals"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Travel meals to track how much you spend on food while travelling.\n\nIf you dine with a customer to promote your business, use a Promotional meals account, instead.\n\nIf you dine with your employees to promote morale, use Entertainment meals, instead.";
                    }
                    if(DType=="Unapplied Cash Bill Payment Expense"){
                        document.getElementById('TypeDescriptionTextArea2').value="Unapplied Cash Bill Payment Expense reports the Cash Basis expense from supplier payment cheques you’ve sent but not yet applied to supplier bills. In general, you would never use this directly on a purchase or sale transaction.";
                    }
                    if(DType=="Utilities"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Utilities to track utility payments.\n\nYou may want different accounts of this type to track different types of utility payments (gas and electric, telephone, water, and so on).";
                    }
                    if(DType=="Dividend Income"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Dividend income to track taxable dividends from investments.";
                    }
                    if(DType=="Interest Earned"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Interest earned to track interest from bank or savings accounts, investments, or interest payments to you on loans your business made.";
                    }
                    if(DType=="Other Investment Income"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Other investment income to track other types of investment income that isn’t from dividends or interest.";
                    }
                    if(DType=="Other Miscellaneous Income"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Other miscellaneous income to track income that isn’t from normal business operations, and doesn’t fall into another Other Income type.";
                    }
                    if(DType=="Tax-Exempt Interest"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Tax-exempt interest to record interest that isn’t taxable, such as interest on money in tax-exempt retirement accounts, or interest from tax-exempt bonds.";
                    }
                    if(DType=="Amortization"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Amortisation to track amortisation of intangible assets.\n\nAmortisation is spreading the cost of an intangible asset over its useful life, like depreciation of fixed assets.\n\nYou may want an amortisation account for each intangible asset you have.";
                    }
                    if(DType=="Depreciation"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Depreciation to track how much you depreciate fixed assets.You may want a depreciation account for each fixed asset you have.";
                    }
                    if(DType=="Exchange Gain or Loss"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Exchange Gain or Loss to track gains or losses that occur as a result of exchange rate fluctuations.";
                    }
                    if(DType=="Other Miscellaneous Expense"){
                        document.getElementById('TypeDescriptionTextArea2').value="";
                    }
                    if(DType=="Penalties & Settlements"){
                        document.getElementById('TypeDescriptionTextArea2').value="Use Penalties and settlements to track money you pay for violating laws or regulations, settling lawsuits, or other penalties.";
                    }
                    if(DType==""){
                        document.getElementById('TypeDescriptionTextArea2').value="";

                    }


                }
            </script>
            <div class="mb-3">
                <p>Account Title</p>
                <select id="coaDetailType2" name="DetType2" class="w-100 pt-1" onchange="ChangeTypeDesc2()">
                    <option>Cash on hand</option>
                    <option>Checking</option>
                    <option>Money Market</option>
                    <option>Rents Held in Trust</option>
                    <option>Savings</option>
                    <option>Trust Account</option>
                </select>
                <input type="text"  class="w-100" style="display:none;" name="customdetailtyep2" id="customdetail2"> 
            </div>
            <div class="mb-3">
                <p>Description</p>
                <textarea id="coaDesc2" type="text" name="COADesc2" class="w-100">{{$chart->coa_description}}</textarea>
            </div>
            <textarea style="display:none;" rows="7" id="TypeDescriptionTextArea2" class="w-100 mt-3" readonly>Use a Cash on hand account to track cash your company keeps for occasional expenses, also called petty cash.\nTo track cash from sales that have not been deposited yet, use a pre-created account called Undeposited funds, instead.</textarea>
        </div>
        <div class="col-md-6 p-1">
            <div class="mb-3" style="display:none;">
                <p>Name</p>
            <input id="coaName2" name="COAName2" type="text" value="{{$chart->coa_name}}" class="w-100">
            </div>
            
            <div class="mb-3">
                <p>Code</p>
                <input id="coaCode2" type="text" name="COACode2" value="{{$chart->coa_code}}" class="w-100">
            </div>
            
            <div class="mb-3">
                <p>Normal Balance</p>
                <select id="coaNormalBalance2" name="COANormalBalance2" value="" class="w-100">
                    <option>Credit</option>
                    <option>Debit</option>
                </select>
                <script>
                document.getElementById('coaNormalBalance2').value="{{$chart->normal_balance}}";
                </script>

            </div>
            
            <div class="pt-2 mb-3" style="display:none;">
                <div class="custom-control custom-checkbox mb-2" style="padding-left:0px;">
                    <input type="checkbox" name="COASubAcc2"  id="defaultUnchecked2" onclick="parentACC2()">
                    <label >Is sub-account</label>
                </div>
                <script>
                        function parentACC2(){
                            var val=document.getElementById('defaultUnchecked2').checked;
                            
                            if(val==true){
                                document.getElementById('parentAcc2').readOnly=false;
                            }else{
                                document.getElementById('parentAcc2').value="";
                                document.getElementById('parentAcc2').readOnly=true;
                            }
                        }
                    </script>
                <input type="text" id="parentAcc2" name="COAParentAcc2" readonly placeholder="Enter parent account" class="w-100">
            </div>
            <div class="col-md-12 p-1" style="display:none;">
                <p>Sub Account</p>
                <select id="sub_accoinmt2"name="sub_accoinmt2"class="w-100">
                    <option></option>
                    <option>Bank</option>
                    <option>Cash on Hand</option>
                    <option>Receivable Accounts</option>
                    <option>Inventories</option>
                    <option >Prepayments</option>
                </select>
            </div>
            <script>document.getElementById('sub_accoinmt2').value="{{$chart->coa_sub_account}}";</script>
            <div class="col-md-6 p-1" style="display:none;">
                <p>Balance</p>
                <input id="coaBalance2" type="number" value="{{$chart->coa_beginning_balance}}" name="COABalance2" min="0" step="0.01" class="w-100">
                
            </div>
            <div class="col-md-6 p-1" style="display:none;">
                <p>as of</p>
                <input type="date" name="COAAsof2" value="{{$chart->coa_as_of_date}}" class="w-100">
            </div>
            <div class="col-md-12 p-1" >
                <p>Cost Center</p>
                <select id="coa_cc2"name="coa_cc2" class="w-100 selectpicker" data-live-search="true" >
                    <option value=""></option>
                    @foreach ($cost_center_list as $list)
                    <option value='{{$list->cc_no}}' {{$chart->coa_cc==$list->cc_no? 'selected' : ''}} >{{$list->cc_name}}</option>
                    @endforeach
                </select>
                <script>
                    $(document).ready(function(){
                        document.getElementById("coa_cc2").value="{{$chart->coa_cc}}";
                    });
                </script>
            </div>
        </div>
        
        <div class="col-sm-12 text-right">
            <input type="reset" class="btn rounded btn-secondary"  value="Clear">
            <input type="submit" class="btn rounded btn-success" id="coaadd2" value="Update">
        </div>
        </form> 
    </div>
@endsection