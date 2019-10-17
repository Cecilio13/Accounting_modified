<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <link rel="apple-touch-icon" href="{{asset('images/icon.png')}}">
    <link rel="shortcut icon" href="{{asset('images/icon.png')}}">
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name','None')}}</title>
<?php
    //auto refresh
    //echo "<meta http-equiv='refresh' content='1' >";
?>
<!--<meta http-equiv="refresh" content="10" >-->
    <head>
        
    </head>
    <body>
            <script src="{{asset('js/jquery.js')}}"></script>
            <script>
            $(document).ready(function(){
                sync_audit_log();
                sync_banks();
                sync_budget();
                sync_coa();
                sync_cc();
                sync_customer();
                sync_expense();
                sync_journal_entries();
                sync_paybills();
                sync_po();
                sync_sales();
                sync_setting();
                sync_st();
                sync_user();
                sync_voucher();
            
            });
            function sync_audit_log(){
                       console.log('Checking Database audit log...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_audit_log') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_audit_log();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_audit_log();
                        }
                        })
                       
            }
            function sync_banks(){
                       console.log('Checking Database bank...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_banks') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_banks();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_banks();
                        }
                        })
                       
            }
            function sync_budget(){
                       console.log('Checking Database budget...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_budget') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_budget();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_budget();
                        }
                        })
                       
            }
            function sync_coa(){
                       console.log('Checking Database coa...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_coa') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_coa();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_coa();
                        }
                        })
                       
            }
            function sync_cc(){
                       console.log('Checking Database cc...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_cc') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_cc();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_cc();
                        }
                        })
                       
            }
            function sync_customer(){
                       console.log('Checking Database customers...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_customer') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_customer();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_customer();
                        }
                        })
                       
            }
            function sync_expense(){
                       console.log('Checking Database expense...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_expense') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_expense();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_expense();
                        }
                        })
                       
            }
            function sync_journal_entries(){
                       console.log('Checking Database journal entry...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_journal_entries') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_journal_entries();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_journal_entries();
                        }
                        })
                       
            }
            function sync_paybills(){
                       console.log('Checking Database pay bills...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_paybills') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_paybills();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_paybills();
                        }
                        })
                       
            }
            function sync_po(){
                       console.log('Checking Database purchase order...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_po') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_po();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_po();
                        }
                        })
                       
            }
            function sync_sales(){
                       console.log('Checking Database sales...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_sales') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_sales();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_sales();
                        }
                        })
                       
            }
            function sync_setting(){
                       console.log('Checking Database settings...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_setting') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_setting();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_setting();
                        }
                        })
                       
            }
            function sync_st(){
                       console.log('Checking Database st...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_st') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_st();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_st();
                        }
                        })
                       
            }
            function sync_user(){
                       console.log('Checking Database users...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_user') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_user();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_user();
                        }
                        })
                       
            }
            function sync_voucher(){
                       console.log('Checking Database voucher...');
                     document.getElementById('lll').innerHTML="Checking Database....";
                     $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('sync_voucher') }}',                
                        data: {reportsettings:"",_token: '{{csrf_token()}}'},
                        success: function(data) {
                            console.log(data);
                            sync_voucher();
                        } ,
                        error: function (xhr, ajaxOptions, thrownError) {
                            sync_voucher();
                        }
                        })
                       
            }
            </script>
            <div id="lll">
            
            </div>
    </body>
</html>

