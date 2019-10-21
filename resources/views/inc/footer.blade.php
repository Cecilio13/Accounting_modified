<footer>
        <script>if (typeof module === 'object') {window.module = module; module = undefined;}</script>  
        {{-- <script src="{{asset('chosen/docsupport/jquery-3.2.1.min.js')}}" type="text/javascript"></script> --}}
        {{-- <script src="{{asset('chosen/chosen.jquery.js')}}" type="text/javascript"></script>
        <script src="{{asset('chosen/docsupport/prism.js')}}" type="text/javascript" charset="utf-8"></script>
        <script src="{{asset('chosen/docsupport/init.js')}}" type="text/javascript" charset="utf-8"></script> --}}

        <script src="{{asset('js/xlsx.core.min.js')}}"></script>
        <script src="{{asset('js/FileSaver.js')}}"></script>
        <script src="{{asset('js/tableexport.js')}}"></script>
        <script src="{{asset('js/popper.js')}}"></script>
        <script src="{{asset('js/plugins.js')}}"></script>
        <script src="{{asset('js/main.js')}}"></script>
        <script src="{{asset('js/donut.js')}}"></script>
        <script src="{{asset('js/redirect.js')}}"></script>

        <script src="{{asset('js/lib/chart-js/Chart.bundle.js')}}"></script>
        <script src="{{asset('js/dashboard.js')}}"></script>
        <script src="{{asset('js/widgets.js')}}"></script>
        <script src="{{asset('js/html2canvas.js')}}"></script>
        
        <script src="{{asset('js/jquery.js')}}"></script>
        

        <script src="{{asset('js/lib/vector-map/jquery.vmap.js')}}"></script>
        <script src="{{asset('js/lib/vector-map/jquery.vmap.min.js')}}"></script>
        <script src="{{asset('js/lib/vector-map/jquery.vmap.sampledata.js')}}"></script>
        <script src="{{asset('js/lib/vector-map/country/jquery.vmap.world.js')}}"></script>
        <script src="{{asset('js/lib/chart-js/Chart.bundle.js')}}"></script>
        <script src="{{asset('js/lib/chart-js/chartjs-init.js')}}"></script>

        <!-- Alert -->
        <script src="{{asset('js/sweetalert.js')}}"></script>

        <!-- DataTables -->
        <script src="{{asset('js/datatable.js')}}"></script>
        <script src="{{asset('js/colreorder.js')}}"></script>
        <script src="{{asset('js/rowreorder.js')}}"></script>

        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
        <!--  flot-chart js -->
        <script  src="{{asset('fontawesome/js/all.js')}}"></script>
        <script src="{{asset('js/lib/flot-chart/excanvas.min.js')}}"></script>
        <script src="{{asset('js/lib/flot-chart/jquery.flot.js')}}"></script>
        <script src="{{asset('js/lib/flot-chart/jquery.flot.pie.js')}}"></script>
        <script src="{{asset('js/lib/flot-chart/jquery.flot.time.js')}}"></script>
        <script src="{{asset('js/lib/flot-chart/jquery.flot.stack.js')}}"></script>
        <script src="{{asset('js/lib/flot-chart/jquery.flot.resize.js')}}"></script>
        <script src="{{asset('js/lib/flot-chart/jquery.flot.crosshair.js')}}"></script>
        <script src="{{asset('js/lib/flot-chart/curvedLines.js')}}"></script>
        <script src="{{asset('js/lib/flot-chart/flot-tooltip/jquery.flot.tooltip.min.js')}}"></script>
        <script src="{{asset('js/lib/flot-chart/flot-chart-init.js')}}"></script>
        <script>if (window.module) module = window.module;</script>
        <script>
                
                ( function ( $ ) {
                "use strict";

                jQuery( '#vmap' ).vectorMap( {
                        map: 'world_en',
                        backgroundColor: null,
                        color: '#ffffff',
                        hoverOpacity: 0.7,
                        selectedColor: '#1de9b6',
                        enableZoom: true,
                        showTooltip: true,
                        values: sample_data,
                        scaleColors: [ '#1de9b6', '#03a9f5' ],
                        normalizeFunction: 'polynomial'
                } );
                } )( jQuery );
        </script>
        <script>
        function PrintElem(elem)
        {
        var mywindow = window.open('', 'PRINT', 'height=400,width=600');
        if(elem=="printablereport_employee_contact_list"){
           document.getElementById('report_main_above_button').style.display="none";
        }
        mywindow.document.write('<html><head><title>' + document.title  + '</title>');
        mywindow.document.write('</head><body style="width:100%;">');
        //mywindow.document.write('<h1>' + document.title  + '</h1>');
        mywindow.document.write(document.getElementById(elem).innerHTML);
        mywindow.document.write('<style>');
        mywindow.document.write('.report-main{width:100%;}#tablemain{width:100%;border-spacing:0px;}#report_employee_companynameheader{border:0px solid black;}');
        mywindow.document.write('#tablemain th{border-top:1px solid #ccc;border-bottom:2px solid #ccc;}');
        mywindow.document.write('#tablemain tr td{border-bottom:1px solid #ccc;padding-left:0px;padding-right:0px;}');
        mywindow.document.write('</style>');
        mywindow.document.write('</body></html>');
        if(elem=="printablereport_employee_contact_list"){
           document.getElementById('report_main_above_button').style.display="table-row";
        }
        

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;
        }
        </script>
</footer>