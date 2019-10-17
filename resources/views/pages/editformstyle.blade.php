@extends('layout.initial')


@section('content')
<style>
        .screenfull-modal{
            padding:0px !important;
        }
        
</style>
<script>
$(document).ready(function(){
    document.getElementById('hiddenmodaltriggerer').click();
    setFormType('{{$Formstyle->cfs_form_name_value}}');  
})
   
                            function setFormType(type){
                            var d = new Date();
                            var month= d.getMonth() + 1;
                            var day=   d.getDate();
                            if(type=="INVOICE"){
                                document.getElementById('ModalHeader').innerHTML="Edit Invoice Form";
                                //document.getElementById('TemplateTitleInput').value="My INVOICE Template - "+month+"-"+day;
                                
                                formtitletemp="INVOICE";
                               // document.getElementById('Formnameinput').value="INVOICE";
                                
                                if(document.getElementById('INVOOICENUM')){
                                    document.getElementById('INVOOICENUM').innerHTML="INVOICE#";
                                }
                                if(document.getElementById('INVOOICENUM2')){
                                    document.getElementById('INVOOICENUM2').innerHTML="INVOICE#";
                                }
                                if(document.getElementById('formTitle-text')){
                                    document.getElementById('formTitle-text').innerHTML="INVOICE";
                                }
                                if(document.getElementById('formTitle-text2')){
                                    document.getElementById('formTitle-text2').innerHTML="INVOICE";
                                }
                                if(document.getElementById('formTitle-text3')){
                                    document.getElementById('formTitle-text3').innerHTML="INVOICE";
                                }
                                if(document.getElementById('messagekind')){
                                    document.getElementById('messagekind').value="Invoice";
                                }
                                if(document.getElementById('emailSubject')){
                                    document.getElementById('emailSubject').value="Invoice [Sales Receipt No.] from [Company Name]";
                                }
                            }
                            else if(type=="ESTIMATE"){
                                document.getElementById('ModalHeader').innerHTML="Edit Estimate Form";
                                //document.getElementById('TemplateTitleInput').value="My ESTIMATE Template - "+month+"-"+day;
                                
                                formtitletemp="ESTIMATE";
                                //document.getElementById('Formnameinput').value="ESTIMATE";
                                if(document.getElementById('INVOOICENUM')){
                                    document.getElementById('INVOOICENUM').innerHTML="ESTIMATE#";
                                }
                                if(document.getElementById('INVOOICENUM2')){
                                    document.getElementById('INVOOICENUM2').innerHTML="ESTIMATE#";
                                }
                                if(document.getElementById('formTitle-text')){
                                    document.getElementById('formTitle-text').innerHTML="ESTIMATE";
                                }
                                if(document.getElementById('formTitle-text2')){
                                    document.getElementById('formTitle-text2').innerHTML="ESTIMATE";
                                }
                                if(document.getElementById('formTitle-text3')){
                                    document.getElementById('formTitle-text3').innerHTML="ESTIMATE";
                                }
                                if(document.getElementById('messagekind')){
                                    document.getElementById('messagekind').value="Estimate";
                                }
                                if(document.getElementById('emailSubject')){
                                    document.getElementById('emailSubject').value="Estimate [Sales Receipt No.] from [Company Name]";
                                }
                            }
                            else if(type=="SALES RECEIPT"){
                                document.getElementById('ModalHeader').innerHTML="Edit Sales Receipt Form";
                                //document.getElementById('TemplateTitleInput').value="My SALES RECEIPT Template - "+month+"-"+day;
                                
                                formtitletemp="SALES RECEIPT";
                                //document.getElementById('Formnameinput').value="SALES RECEIPT";
                                if(document.getElementById('INVOOICENUM')){
                                    document.getElementById('INVOOICENUM').innerHTML="SALES RECEIPT#";
                                }
                                if(document.getElementById('INVOOICENUM2')){
                                    document.getElementById('INVOOICENUM2').innerHTML="SALES RECEIPT#";
                                }
                                if(document.getElementById('formTitle-text')){
                                    document.getElementById('formTitle-text').innerHTML="SALES RECEIPT";
                                }
                                if(document.getElementById('formTitle-text2')){
                                    document.getElementById('formTitle-text2').innerHTML="SALES RECEIPT";
                                }
                                if(document.getElementById('formTitle-text3')){
                                    document.getElementById('formTitle-text3').innerHTML="SALES RECEIPT";
                                }
                                if(document.getElementById('messagekind')){
                                    document.getElementById('messagekind').value="Sales Receipt";
                                }
                                if(document.getElementById('emailSubject')){
                                    document.getElementById('emailSubject').value="Sales Receipt [Sales Receipt No.] from [Company Name]";
                                }
                                
                                
                                
                               
                               
                                
                               
                            }
                        }
</script>
<button style="display:none;" data-target="#InvoiceFormModal" id="hiddenmodaltriggerer"  href="#" data-toggle="modal"></button>
<div id="InvoiceFormModal" class="modal fade screenfull-modal" role="dialog" style="padding:0px;">
    <div class="modal-dialog modal-full" >
<div class="modal-content" style="border-radius:0px;background-color:#f4f5f8">
        <div class="modal-header">
          
          <h4 class="modal-title" id="ModalHeader">Edit Invoice Form</h4>
          <a class="close" href="customformstyles">&times;</a>
        </div>
        <div class="modal-body">
          
            <div class="col-md-6" style="padding:30px;">
                    <div class="row">
                    <div class="col-md-12" >
                        <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" onclick="showemailtab('0')" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Design</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" onclick="showemailtab('0')" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Content</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab" onclick="showemailtab('1')" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Emails</a>
                            </li>
                            <script>
                                function showemailtab(e){
                                    if(e=="1"){
                                        document.getElementById('formtemplatepage').style.display="none";
                                        document.getElementById('formemailtemplatepage').style.display="block";
                                    }else{
                                        document.getElementById('formtemplatepage').style.display="block";
                                        document.getElementById('formemailtemplatepage').style.display="none";
                                    }
                                }
                            </script>
                        </ul>
                        <style>
                                .textSection{
                                    margin-top:30px;
                                    cursor: pointer;
                                    -webkit-user-select: none; /* Chrome/Safari */        
                                    -moz-user-select: none; /* Firefox */
                                    -ms-user-select: none; /* IE10+ */

                                    /* Rules below not implemented in browsers yet */
                                    -o-user-select: none;
                                    user-select: none;
                                }
                                .invoice-design-template-icon{
                                    padding:10px;
                                    background-image: url("{{asset('images/file.png')}}");
                                    background-size: contain;
                                    background-repeat: no-repeat;
                                    height:44px;
                                    width:44px;
                                    display: inline-block !important;
                                    float:left;
                                    border: 1px solid #ccc;
                                }
                                .print-design-template-icon{
                                    padding:10px;
                                    background-image: url("{{asset('images/increase.png')}}");
                                    background-size: contain;
                                    background-repeat: no-repeat;
                                    height:44px;
                                    width:44px;
                                    display: inline-block !important;
                                    float:left;
                                    border: 1px solid #ccc;
                                }
                                .font-design-template-icon{
                                    padding:10px;
                                    background-image: url("{{asset('images/text.png')}}");
                                    background-size: contain;
                                    background-repeat: no-repeat;
                                    height:44px;
                                    width:44px;
                                    display: inline-block !important;
                                    float:left;
                                    border: 1px solid #ccc;
                                }
                                .color-design-template-icon{
                                    padding:10px;
                                    background-image: url("{{asset('images/pantone.png')}}");
                                    background-size: contain;
                                    background-repeat: no-repeat;
                                    height:44px;
                                    width:44px;
                                    display: inline-block !important;
                                    float:left;
                                    border: 1px solid #ccc;
                                }
                                .logo-design-template-icon{
                                    padding:10px;
                                    background-image: url("{{asset('images/add.png')}}");
                                    background-size: contain;
                                    background-repeat: no-repeat;
                                    height:44px;
                                    width:44px;
                                    display: inline-block !important;
                                    float:left;
                                    border: 1px solid #ccc;
                                }
                                .iconText{
                                    height:44px;
                                    vertical-align: middle;
                                    
                                   
                                    padding: 10px;
                                    display: inline-block !important;
                                }
                            </style>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <input type="text" class="form-control" style="width:50%;" value="{{$Formstyle->cfs_name}}" placeholder="Please name your template" id="TemplateTitleInput">
                                <input type="hidden" class="form-control" id="TemplateID" value="{{$Formstyle->cfs_id}}">
                                <div class="textSection" onclick="showdesigntemplate()">
                                    <script>
                                        var designsetting=0;
                                        function showdesigntemplate(){
                                            if(designsetting==0){
                                                document.getElementById('designsettingdiv').style.display="inline-block";
                                                designsetting=1;
                                            }else{
                                                document.getElementById('designsettingdiv').style.display="none";
                                                designsetting=0;
                                            }
                                        }
                                    </script>
                                    <div class="invoice-design-template-icon"></div>
                                    <div class="iconText">Change up the template</div>
                                </div>
                                <div id="designsettingdiv" class="row" style="margin-top:10px;display:none;width:100%;">
                                    <div class="col-md-12">
                                            <script>
                                                var pickeddesign="{{$Formstyle->cfs_design_template}}";
                                                $(document).ready(function(){
                                                    var link;
                                                    if(pickeddesign=="1"){
                                                        document.getElementById('airy').click();
                                                    }
                                                    else if(pickeddesign=="2"){
                                                        document.getElementById('modern').click();
                                                    }
                                                    else if(pickeddesign=="3"){
                                                        document.getElementById('friendly').click();
                                                    }
                                                    
                                                });
                                                function replacedesigntemplate(element,kind,designnumber){
                                                    pickeddesign=designnumber;
                                                    $("img").removeClass("thumbnailPreviewImageSelected");
                                                    $(element).addClass("thumbnailPreviewImageSelected");
                                                    $('#formdesigntemplate1').removeClass("showndesigntemplate");
                                                    $('#formdesigntemplate2').removeClass("showndesigntemplate");
                                                    $('#formdesigntemplate3').removeClass("showndesigntemplate");
                                                    $('#formdesigntemplate1').addClass("hiddendesigntemplate");
                                                    $('#formdesigntemplate2').addClass("hiddendesigntemplate");
                                                    $('#formdesigntemplate3').addClass("hiddendesigntemplate");
                                                    $('#formdesigntemplate'+designnumber).removeClass("hiddendesigntemplate");
                                                    $('#formdesigntemplate'+designnumber).addClass("showndesigntemplate");
                                                }
                                            </script>
                                            <div id="phLayout" class="thumbnails-div div-margins">
                                                <div class="templateThumbnail airy">
                                                    <label>
                                                        <img onclick="replacedesigntemplate(this,'airy','1')" id="airy" class="thumbnailPreviewImage thumbnailPreviewImageSelected" src="data:image/png;base64,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">
                                                        <div class="thumbnailLabel normalText"><small>Airy classic</small></div>
                                                    </label>
                                                </div>
                                                <div class="templateThumbnail modern">
                                                    <label>
                                                        
                                                        <img onclick="replacedesigntemplate(this,'modern','2')" id="modern" class="thumbnailPreviewImage" src="data:image/png;base64,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">
                                                        <div class="thumbnailLabel normalText"><small>Modern</small></div>
                                                    </label>
                                                </div>
                                                <div class="templateThumbnail friendly">
                                                    <label>
                                                        
                                                        <img onclick="replacedesigntemplate(this,'friendly','3')" id="friendly" class="thumbnailPreviewImage" src="data:image/png;base64,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">
                                                        <div class="thumbnailLabel normalText"><small>Friendly</small></div>
                                                    </label>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="textSection" onclick="showlogo()">
                                    <script>
                                        var logosetting=0;
                                        function showlogo(){
                                            if(logosetting==0){
                                                document.getElementById('logosettingdiv').style.display="inline-block";
                                                logosetting=1;
                                            }else{
                                                document.getElementById('logosettingdiv').style.display="none";
                                                logosetting=0;
                                            }
                                        }
                                    </script>
                                        <div class="logo-design-template-icon"></div>
                                        <div class="iconText">Make logo edits</div>
                                </div>
                                <div id="logosettingdiv" class="row" style="margin-top:10px;display:none;width:100%;">
                                    <div class="col-md-2">
                                            <label for="customFile" style="opacity:1;padding:0px;" id="FIleImportExcelLabel" class="custom-excel-upload btn btn-link">
                                                <img src="{{asset('images/plus.png')}}" style="height:50px;" id="addlogoinput">
                                            </label>
                                            <Style>
                                            #customFile{
                                                display: none;
                                            }
                                            .custom-excel-upload {
                                                    
                                            }
                                            </style>
                                            <input type="file" class="form-control" id="customFile" accept="image/x-png,image/gif,image/jpeg" onchange="submitlogo()">
                                        <script>
                                            var imageheight="100";
                                            var showlogoimg=1;
                                            var logoshow="0";
                                            function showlogocontroller(){
                                                goRight();
                                                if(showlogoimg==1){
                                                    logoshow="0";
                                                    document.getElementById('Templatelogo').style.display="none";
                                                    document.getElementById('Templatelogo2').style.display="none";
                                                    document.getElementById('Templatelogo3').style.display="none";
                                                    document.getElementById('formTitle2').style.cssFloat="right";
                                                    document.getElementById('formTitle3').style.cssFloat="right";
                                                    document.getElementById('pos1').disabled=true;
                                                    document.getElementById('pos2').disabled=true;
                                                    document.getElementById('pos3').disabled=true;
                                                    document.getElementById('size1').disabled=true;
                                                    document.getElementById('size2').disabled=true;
                                                    document.getElementById('size3').disabled=true;
                                                    showlogoimg=0;
                                                }else{
                                                    logoshow="1";
                                                    document.getElementById('Templatelogo').style.display="inline";
                                                    document.getElementById('Templatelogo2').style.display="inline";
                                                    document.getElementById('Templatelogo3').style.display="inline";
                                                    document.getElementById('formTitle2').style.cssFloat="left";
                                                    document.getElementById('formTitle3').style.cssFloat="left";
                                                    document.getElementById('pos1').disabled=false;
                                                    document.getElementById('pos2').disabled=false;
                                                    document.getElementById('pos3').disabled=false;
                                                    document.getElementById('size1').disabled=false;
                                                    document.getElementById('size2').disabled=false;
                                                    document.getElementById('size3').disabled=false;
                                                    showlogoimg=1;
                                                }
                                               
                                                
                                            }
                                            $(document).ready(function(){
                                                var filename="{{$Formstyle->cfs_logo_name}}";
                                                if(filename!=""){
                                                    $("#Templatelogo").attr("src","images/logos/"+filename);
                                                    $("#Templatelogo2").attr("src","images/logos/"+filename);
                                                    $("#Templatelogo3").attr("src","images/logos/"+filename);
                                                    $("#addlogoinput").attr("src","images/logos/"+filename);
                                                    document.getElementById("customFile").value = "";
                                                    document.getElementById('logadjustmenttable').style.display="inline";
                                                    document.getElementById('formTitle2').style.cssFloat="left";
                                                    document.getElementById('formTitle3').style.cssFloat="left";
                                                    document.getElementById('lllll').style.display="inline";
                                                    document.getElementById('lllll2').style.display="inline";
                                                    document.getElementById('lllll3').style.display="inline";
                                                    imageheight="100";
                                                    logoname=filename;
                                                }
                                                
                                                
                                            })
                                            var logoname="";
                                            function submitlogo(){
                                            document.getElementById('customFile').disabled=true;
                                            var file = $('#customFile')[0].files[0]
                                            var fd = new FormData();
                                            fd.append('theFile', file);
                                            fd.append('_token', '{{csrf_token()}}');
                                            $.ajax({
                                                url: '{{route("uploadlogo")}}',
                                                type: 'POST',
                                                processData: false,
                                                contentType: false,
                                                data: fd,
                                                //dataType:"json",
                                                success: function (data, status, jqxhr) {
                                                    if(data=="OK"){
                                                        var fullPath = document.getElementById('customFile').value;
                                                        if (fullPath) {
                                                            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                                                            var filename = fullPath.substring(startIndex);
                                                            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                                                                filename = filename.substring(1);
                                                            }
                                                            //alert(filename);
                                                            logoname=filename;
                                                            logoshow="1";
                                                            $("#Templatelogo").attr("src","images/logos/"+filename);
                                                            $("#Templatelogo2").attr("src","images/logos/"+filename);
                                                            $("#Templatelogo3").attr("src","images/logos/"+filename);
                                                            $("#addlogoinput").attr("src","images/logos/"+filename);
                                                            document.getElementById("customFile").value = "";
                                                            document.getElementById('logadjustmenttable').style.display="inline";
                                                            document.getElementById('formTitle2').style.cssFloat="left";
                                                            document.getElementById('formTitle3').style.cssFloat="left";
                                                            document.getElementById('lllll').style.display="inline";
                                                            document.getElementById('lllll2').style.display="inline";
                                                            document.getElementById('lllll3').style.display="inline";
                                                            imageheight=document.getElementById('Templatelogo').offsetHeight;
                                                            if(imageheight==0){
                                                                imageheight=document.getElementById('Templatelogo2').offsetHeight;
                                                            }
                                                            if(imageheight==0){
                                                                imageheight=document.getElementById('Templatelogo3').offsetHeight;
                                                            }
                                                            //alert(imageheight);
                                                        }
                                                       //
                                                    }
                                                },
                                                error: function (jqxhr, status, msg) {
                                                    //error code
                                                    alert(jqxhr.responseText +" message"+msg+" status:"+status);
                                                }
                                            });
                                            
                                            document.getElementById('customFile').disabled=false;
                                        }
                                        </script>  
                                    </div>
                                    <div class="col-md-9">
                                        <table id="logadjustmenttable" style="display:none;">
                                            <tr>
                                                <td ><small>Size</small></td>
                                                <td><small>Placement</small></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-right:10px;">
                                                    <button id="size1" class="btn btn-outline-dark btn-logo-size" onclick="goS()">S</button>
                                                    <button id="size2" class="btn btn-outline-dark btn-logo-size" onclick="goM()">M</button>
                                                    <button id="size3" class="btn btn-outline-dark btn-logo-size" onclick="goL()">L</button>
                                                    <script>
                                                        var logo_size="{{$Formstyle->cfs_logo_size}}";
                                                       $(document).ready(function(){
                                                        var siz="{{$Formstyle->cfs_logo_size}}";
                                                        document.getElementById('Templatelogo').style.height=imageheight*siz+"px";
                                                        document.getElementById('Templatelogo2').style.height=imageheight*siz+"px";
                                                        document.getElementById('Templatelogo3').style.height=imageheight*siz+"px";
                                                       }) 
                                                        function goS(){
                                                            logo_size=".50";
                                                            
                                                            //alert(document.getElementById('Templatelogo').offsetHeight*.50);
                                                            document.getElementById('Templatelogo').style.height=imageheight*.50+"px";
                                                            document.getElementById('Templatelogo2').style.height=imageheight*.50+"px";
                                                            document.getElementById('Templatelogo3').style.height=imageheight*.50+"px";
                                                            //alert(imageheight);
                                                        }
                                                        function goM(){
                                                            logo_size=".75";
                                                            //alert(document.getElementById('Templatelogo').offsetHeight*.75);
                                                            document.getElementById('Templatelogo').style.height=imageheight*.75+"px";
                                                            document.getElementById('Templatelogo2').style.height=imageheight*.75+"px";
                                                            document.getElementById('Templatelogo3').style.height=imageheight*.75+"px";
                                                           // alert(imageheight);
                                                        }
                                                        function goL(){
                                                            logo_size="1";
                                                            //alert(document.getElementById('Templatelogo').offsetHeight*1);
                                                            document.getElementById('Templatelogo').style.height=imageheight*1+"px";
                                                            document.getElementById('Templatelogo2').style.height=imageheight*1+"px";
                                                            document.getElementById('Templatelogo3').style.height=imageheight*1+"px";
                                                            //alert(imageheight);
                                                        }
                                                    </script>
                                                </td>
                                                <td>
                                                    <button id="pos1" class="btn btn-outline-dark btn-logo-position" onclick="goLeft()"><img  src="{{asset('images/left-alignment.png')}}"></button>
                                                    <button id="pos2" class="btn btn-outline-dark btn-logo-position" onclick="gocenter()"><img   src="{{asset('images/center-alignment.png')}}"></button>
                                                    <button id="pos3" class="btn btn-outline-dark btn-logo-position" onclick="goRight()"><img   src="{{asset('images/right-alignment.png')}}"></button>
                                                    <script>
                                                        var logo_align="{{$Formstyle->cfs_logo_alignment}}";
                                                        $(document).ready(function(){
                                                            if("{{$Formstyle->cfs_logo_alignment}}"=="right"){
                                                                goRight();
                                                            }
                                                            else if("{{$Formstyle->cfs_logo_alignment}}"=="center"){
                                                                gocenter();
                                                            }
                                                            else if("{{$Formstyle->cfs_logo_alignment}}"=="left"){
                                                                goLeft();
                                                            }
                                                        }) 
                                                        function goRight(){
                                                            logo_align="right";
                                                            document.getElementById('logocontainer').style.cssFloat="right";
                                                            document.getElementById('logocontainer2').style.cssFloat="right";
                                                            document.getElementById('logocontainer3').style.cssFloat="right";
                                                            document.getElementById('comapnyinformationdiv').style.cssFloat="left";
                                                            document.getElementById('comapnyinformationdiv2').style.cssFloat="left";
                                                            document.getElementById('comapnyinformationdiv3').style.cssFloat="left";
                                                            document.getElementById('formTitle2').style.cssFloat="left";
                                                            document.getElementById('formTitle3').style.cssFloat="left";

                                                            
                                                        }
                                                        function gocenter(){
                                                            logo_align="center";
                                                            document.getElementById('logocontainer').style.cssFloat="left";
                                                            document.getElementById('logocontainer2').style.cssFloat="left";
                                                            document.getElementById('logocontainer3').style.cssFloat="left";
                                                            document.getElementById('comapnyinformationdiv').style.cssFloat="left";
                                                            document.getElementById('comapnyinformationdiv2').style.cssFloat="left";
                                                            document.getElementById('comapnyinformationdiv3').style.cssFloat="left";
                                                            document.getElementById('formTitle2').style.cssFloat="right";
                                                            document.getElementById('formTitle3').style.cssFloat="right";
                                                        }
                                                        function goLeft(){
                                                            logo_align="left";
                                                            document.getElementById('logocontainer').style.cssFloat="left";
                                                            document.getElementById('logocontainer2').style.cssFloat="left";
                                                            document.getElementById('logocontainer3').style.cssFloat="left";
                                                            document.getElementById('comapnyinformationdiv').style.cssFloat="none";
                                                            document.getElementById('comapnyinformationdiv2').style.cssFloat="none";
                                                            document.getElementById('comapnyinformationdiv3').style.cssFloat="none";
                                                            document.getElementById('formTitle2').style.cssFloat="right";
                                                            document.getElementById('formTitle3').style.cssFloat="right";
                                                            
                                                        }
                                                    </script>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" style="vertical-align:bottom"><a href="#" style="padding-left:0px;" onclick="showlogocontroller()" class="btn btn-link">Show/Hide logo</a></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="textSection" onclick="showcolorsetting()">
                                        <script>
                                            var colorsetting=0;
                                            function showcolorsetting(){
                                                if(colorsetting==0){
                                                    document.getElementById('colorsettingdiv').style.display="inline-block";
                                                    colorsetting=1;
                                                }else{
                                                    document.getElementById('colorsettingdiv').style.display="none";
                                                    colorsetting=0;
                                                }
                                            }
                                        </script>
                                        <div class="color-design-template-icon"></div>
                                        <div class="iconText">Try other colours</div>
                                </div>
                                <div id="colorsettingdiv" class="row" style="margin-top:10px;display:none;">
                                        <div class="col-md-2">
                                                
                                                <input type="color" id="color1" value="{{$Formstyle->cfs_theme_color}}"  onchange="pickcolor(this)"  onkeyup="pickcolor(this)">
                                                <script>
                                                    var pickedcolor="{{$Formstyle->cfs_theme_color}}";
                                                    function pickcolor(e){
                                                        //alert(e.value+" "+shade(e.value, 0.5));
                                                        pickedcolor=e.value;
                                                        document.getElementById('formTitle-text').style.color=e.value;
                                                        document.getElementById('formTitle-text2').style.color=e.value;
                                                        document.getElementById('formTitle-text3').style.color=e.value;
                                                        document.getElementById('SubTotalTitle').style.color=e.value;
                                                        document.getElementById('SubTotalTitle2').style.color=e.value;
                                                        document.getElementById('SubTotalTitle3').style.color=e.value;
                                                        document.getElementById('TotalTitle3').style.color=e.value;
                                                        document.getElementById('TotalTitle').style.color=e.value;
                                                        document.getElementById('TotalTitle2').style.color=e.value;
                                                        document.getElementById('billtocolored').style.color=e.value;
                                                        document.getElementById('billtocolored').style.backgroundColor=shade(e.value, 0.5);
                                                        document.getElementById('shiptocolored').style.backgroundColor=shade(e.value, 0.5);
                                                        document.getElementById('tabletrinvoicenumber').style.backgroundColor=shade(e.value, 0.5);
                                                        document.getElementById('shiptocolored').style.color=e.value;
                                                        document.getElementById('tabletrinvoicenumber').style.color=e.value;
                                                        
                                                        document.getElementById('borderline1').style.borderTop="1px solid "+e.value;
                                                        document.getElementById('shiptodiv3').style.borderTop="1px solid "+e.value;
                                                        document.getElementById('borderline3').style.borderTop="1px solid "+e.value;

                                                        document.getElementById('datetitle3').style.backgroundColor=shade(e.value, 0.5);
                                                        document.getElementById('datetitle3-2').style.backgroundColor=shade(e.value, 0.5);

                                                        document.getElementById('termtitle3').style.backgroundColor=shade(e.value, 0.5);
                                                        document.getElementById('termtitle3-2').style.backgroundColor=shade(e.value, 0.5);

                                                        document.getElementById('datetitle3').style.color=e.value;
                                                        document.getElementById('datetitle3-2').style.color=e.value;
                                                        document.getElementById('termtitle3').style.color=e.value;
                                                        document.getElementById('termtitle3-2').style.color=e.value;
                                                        document.getElementById('duedatetitle3').style.backgroundColor=e.value;
                                                        document.getElementById('duedatetitle3-2').style.backgroundColor=e.value;
                                                        
                                                        document.getElementById('EmailHeaderCompanyName').style.borderTop="1px solid "+e.value;
                                                        document.getElementById('EmailHeaderCompanyName').style.color=e.value;
                                                        document.getElementById('emailbelowMessage').style.backgroundColor=shade(e.value, 0.5);
                                                        $("#activityTableLhsTableHeader th").css({
                                                            "background-color": shade(e.value, 0.5),
                                                            "color" : e.value
                                                        });
                                                        
                                                    }
                                                    function getEventTarget(e) {
                                                        e = e || window.event;
                                                        return e.target || e.srcElement; 
                                                    }
                                                    
                                                    $(document).ready(function(){
                                                        pickcolor(document.getElementById('color1'));
                                                        var ul = document.getElementById('colorpickerpre');
                                                        ul.onclick = function(event) {
                                                            var target = getEventTarget(event);
                                                            document.getElementById('color1').value=target.id;
                                                            pickcolor(document.getElementById('color1'));
                                                        };
                                                    });
                                                    
                                                </script>
                                        </div>
                                        <div class="col-md-10">
                                            <ul class="color-ul animate" id="colorpickerpre">
                                                <li class="color-li">
                                                    <div class="circle2" id="#bdbdbd" style="background-color: rgb(189, 189, 189);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#636363" style="background-color: rgb(99, 99, 99);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#000000" style="background-color: rgb(0, 0, 0);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#a6bddb" style="background-color: rgb(166, 189, 219);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2 palleteHighlight" id="#7889a1" style="background-color: rgb(120, 137, 161);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#48565f" style="background-color: rgb(72, 86, 95);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#79BD58" style="background-color: rgb(121, 189, 88);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#0e909a" style="background-color: rgb(14, 144, 154);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#202e5a" style="background-color: rgb(32, 46, 90);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#96bc2d" style="background-color: rgb(150, 188, 45);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#2a651d" style="background-color: rgb(42, 101, 29);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#004254" style="background-color: rgb(0, 66, 84);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#ff8c00" style="background-color: rgb(255, 140, 0);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#82001d" style="background-color: rgb(130, 0, 29);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#6b1438" style="background-color: rgb(107, 20, 56);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#f4749b" style="background-color: rgb(244, 116, 155);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#950069" style="background-color: rgb(149, 0, 105);"> </div>
                                                </li>
                                                <li class="color-li">
                                                    <div class="circle2" id="#542852" style="background-color: rgb(84, 40, 82);"> </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                <div class="textSection" onclick='showfontsetting()'>
                                    <script>
                                        var showfont=0;
                                        function showfontsetting(){
                                            if(showfont==0){
                                                document.getElementById('fontsettingdiv').style.display="inline-block";
                                                showfont=1;
                                            }else{
                                                document.getElementById('fontsettingdiv').style.display="none";
                                                showfont=0;
                                            }
                                        }
                                    </script>
                                        <div class="font-design-template-icon"></div>
                                        <div class="iconText">Select a different font</div>
                                </div>
                                <div id="fontsettingdiv" class="row" style="margin-top:10px;display:none;">
                                    <div class="col-md-12">
                                        <div class="form-inline">
                                                <select class="form-control mb-2 mr-sm-2" id="fontfamily" onchange="setfont()">
                                                    <option>Arial Unicode MS</option>
                                                    <option >Courier</option>
                                                    <option>Times New Roman</option>
                                                    <option selected>Helvetica</option>
                                                </select>
                                                <select class="form-control mb-2 mr-sm-2" id="fontsize" onchange="setfont()">
                                                    <option value="8">8pt</option>
                                                    <option selected value="10">10pt</option>
                                                    <option value="12">12pt</option>
                                                </select>
                                                <script>
                                                    var template_font_family="{{$Formstyle->cfs_font_family}}";
                                                    var template_font_size="{{$Formstyle->cfs_font_size}}";
                                                    $(document).ready(function(){
                                                        document.getElementById('fontsize').value="{{$Formstyle->cfs_font_size}}";
                                                        document.getElementById('fontfamily').value="{{$Formstyle->cfs_font_family}}";
                                                        setfont();
                                                    })
                                                    function setfont(){
                                                        var fontsize=document.getElementById('fontsize').value;
                                                        var fontfamily=document.getElementById('fontfamily').value;
                                                        template_font_family=fontfamily;
                                                        template_font_size=fontsize;
                                                        var i,
                                                            tags = document.getElementById("formtemplatepage").getElementsByTagName("*"),
                                                            total = tags.length;
                                                        for ( i = 0; i < total; i++ ) {
                                                        tags[i].style.fontFamily=fontfamily;
                                                        tags[i].style.fontSize=fontsize+"px";
                                                        }
                                                        var fontsizeplus=(document.getElementById('fontsize').value*1)+4;
                                                        document.getElementById('formTitle-text').style.fontSize=fontsizeplus+"px";
                                                        document.getElementById('formTitle-text2').style.fontSize=fontsizeplus+"px";
                                                        document.getElementById('formTitle-text3').style.fontSize=fontsizeplus+"px";
                                                        document.getElementById('rhs-companyName').style.fontSize=fontsizeplus+"px";
                                                        document.getElementById('rhs-companyName2').style.fontSize=fontsizeplus+"px";
                                                        document.getElementById('rhs-companyName3').style.fontSize=fontsizeplus+"px";
                                                    }
                                                </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="textSection" onclick="showprintsetting()">
                                        <script>
                                                var showprint=0;
                                                function showprintsetting(){
                                                    if(showprint==0){
                                                        document.getElementById('printsettingdiv').style.display="inline-block";
                                                        showprint=1;
                                                    }else{
                                                        document.getElementById('printsettingdiv').style.display="none";
                                                        showprint=0;
                                                    }
                                                }
                                                function shadeRGBColor(color, percent) {
                                                    var f=color.split(","),t=percent<0?0:255,p=percent<0?percent*-1:percent,R=parseInt(f[0].slice(4)),G=parseInt(f[1]),B=parseInt(f[2]);
                                                    return "rgb("+(Math.round((t-R)*p)+R)+","+(Math.round((t-G)*p)+G)+","+(Math.round((t-B)*p)+B)+")";
                                                }
                                                function shadeColor2(color, percent) {   
                                                    var f=parseInt(color.slice(1),16),t=percent<0?0:255,p=percent<0?percent*-1:percent,R=f>>16,G=f>>8&0x00FF,B=f&0x0000FF;
                                                    return "#"+(0x1000000+(Math.round((t-R)*p)+R)*0x10000+(Math.round((t-G)*p)+G)*0x100+(Math.round((t-B)*p)+B)).toString(16).slice(1);
                                                }
                                                function shade(color, percent){
                                                    if (color.length > 7 ){
                                                        return shadeRGBColor(color,percent);
                                                    } 
                                                    else{
                                                        return shadeColor2(color,percent);
                                                    } 
                                                }
                                            </script>
                                        <div class="print-design-template-icon"></div>
                                        <div class="iconText">Edit print settings</div>
                                        
                                    
                                </div>
                                
                                <div id="printsettingdiv" class="row" style="margin-top:10px;display:none;">
                                        <div class="col-md-12">
                                            <p style="margin-bottom:0px;">Page Margins <button class="btn btn-link" onclick="resetmargin()">Reset</button></p>
                                            <script>
                                                $(document).ready(function(){
                                                    var str="{{$Formstyle->cfs_margin}}";
                                                    var res = str.split("in ");
                                                    var res2 =res[3].split("in");
                                                    document.getElementById('margintop').value=res[0];
                                                    document.getElementById('marginleft').value=res[1];
                                                    document.getElementById('marginbottom').value=res[2];
                                                    document.getElementById('marginright').value=res2[0];
                                                    setmargin();
                                                })
                                                var template_margin="{{$Formstyle->cfs_margin}}";
                                                function resetmargin(){
                                                    document.getElementById('margintop').value="0.5";
                                                    document.getElementById('marginleft').value="0";
                                                    document.getElementById('marginbottom').value="0.5";
                                                    document.getElementById('marginright').value="0"; 
                                                    setmargin();
                                                }
                                                function setmargin(){
                                                    var margintop=document.getElementById('margintop').value;
                                                    var marginleft=document.getElementById('marginleft').value;
                                                    var marginbottom=document.getElementById('marginbottom').value;
                                                    var marginright=document.getElementById('marginright').value;
                                                    if(margintop<0.5 || margintop>3.5){

                                                    }
                                                    else if(marginleft<0 || marginleft>2.75){
                                                        
                                                    }
                                                    else if(marginbottom<0.5 || marginbottom>3.5){

                                                    }
                                                    else if(marginright<0 || marginright>2.75){

                                                    }
                                                    else{
                                                        
                                                        document.getElementById('page-wrap').style.padding=margintop+"in "+marginleft+"in "+marginbottom+"in "+marginright+"in";
                                                        document.getElementById('page-wrap2').style.padding=margintop+"in "+marginleft+"in "+marginbottom+"in "+marginright+"in";
                                                        document.getElementById('page-wrap3').style.padding=margintop+"in "+marginleft+"in "+marginbottom+"in "+marginright+"in";
                                                        document.getElementById('footerText2').style.paddingBottom=marginbottom+"in";
                                                        document.getElementById('footerText3').style.paddingBottom=marginbottom+"in";
                                                        template_margin=margintop+"in "+marginleft+"in "+marginbottom+"in "+marginright+"in";
                                                    }
                                                    
                                                }
                                            </script>
                                            <div class="row">
                                                <div class="col-md-3">
                                                        <label class="form-check-label" for="defaultCheck1">
                                                                Top
                                                        </label>
                                                        <input type="number"  id="margintop" class="form-control"  min="0.5" max="3.5" step="0.25" value="0.5" onkeyup="setmargin()" oninput="setmargin()" >
                                                </div>
                                                <div class="col-md-3">
                                                        <label class="form-check-label" for="defaultCheck1">
                                                                Left
                                                        </label>
                                                        <input type="number" id="marginleft" class="form-control"  min="0" max="2.75" step="0.25" value="0" onkeyup="setmargin()" oninput="setmargin()">
                                                </div>
                                                <div class="col-md-3">
                                                        <label class="form-check-label" for="defaultCheck1">
                                                                Bottom
                                                        </label>
                                                        <input type="number" id="marginbottom" class="form-control"  min="0.5" max="3.5" step="0.25" value="0.5" onkeyup="setmargin()" oninput="setmargin()">
                                                </div>
                                                <div class="col-md-3">
                                                        <label class="form-check-label" for="defaultCheck1">
                                                                Right
                                                        </label>
                                                        <input type="number" id="marginright" class="form-control"  min="0" max="2.75" step="0.25" value="0" onkeyup="setmargin()" oninput="setmargin()">
                                                </div>
                                                
                                                        
                                                
                                            </div>
                                                
                                        </div>
                                    </div>  
                            </div>
                            
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <p>
                                        <a class="btn btn-primary" data-toggle="collapse" href="#contenheader" role="button" aria-expanded="true" aria-controls="collapseExample">
                                            Header
                                        </a>
                                        <a class="btn btn-primary" data-toggle="collapse" href="#contenttable" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            Table
                                        </a>
                                        <a class="btn btn-primary" data-toggle="collapse" href="#contentfooter" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            Footer
                                        </a>
                                    </p>
                                    <div class="collapse show" id="contenheader">
                                        <div class="card card-body">
                                            <h4>Header</h4>
                                            <br>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_company_name_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="checkcompanyname" onchange="disablecompanyname()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value="" id="checkcompanyname" onchange="disablecompanyname()">
                                                @endif
                                                
                                                <script>
                                                    var companyname_show="{{$Formstyle->cfs_company_name_check}}";
                                                    $(document).ready(function(){
                                                        disablecompanyname();
                                                    })
                                                    var compantname="{{$Formstyle->cfs_company_name_value}}";
                                                    function disablecompanyname(){
                                                        if(document.getElementById('checkcompanyname').checked){
                                                            companyname_show="1";
                                                            document.getElementById('rhs-companyName').style.display="inline";
                                                            document.getElementById('rhs-companyName2').style.display="inline";
                                                            document.getElementById('rhs-companyName3').style.display="inline";
                                                        }else{
                                                            companyname_show="0";
                                                            document.getElementById('rhs-companyName').style.display="none";
                                                            document.getElementById('rhs-companyName2').style.display="none";
                                                            document.getElementById('rhs-companyName3').style.display="none";
                                                        }
                                                    }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Company Name
                                                </label>
                                                <input type="text" class="form-control" style="width:50%;" value="{{$Formstyle->cfs_company_name_value}}" onkeyup="setcomapnynamecontent(this)">
                                                <script>
                                                    function setcomapnynamecontent(e){
                                                        compantname=e.value;
                                                        document.getElementById('rhs-companyName').innerHTML=e.value;
                                                        document.getElementById('rhs-companyName2').innerHTML=e.value;
                                                        document.getElementById('rhs-companyName3').innerHTML=e.value;
                                                    }
                                                </script>
                                            </div>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_phone_check=="1")
                                                <input class="form-check-input" type="checkbox" checked value="" id="checkcompanyphone" onchange="disablephone()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value="" id="checkcompanyphone" onchange="disablephone()">
                                                @endif
                                                
                                                <script>
                                                    var showphone="{{$Formstyle->cfs_phone_check}}";
                                                    $(document).ready(function(){
                                                        disablephone();
                                                    })
                                                        function disablephone(){
                                                            if(document.getElementById('checkcompanyphone').checked){
                                                                showphone="1";
                                                                document.getElementById('rhs-phoneNumber').style.display="block";
                                                                document.getElementById('rhs-phoneNumber2').style.display="block";
                                                                document.getElementById('rhs-phoneNumber3').style.display="block";
                                                            }else{
                                                                showphone="0";
                                                                document.getElementById('rhs-phoneNumber').style.display="none";
                                                                document.getElementById('rhs-phoneNumber2').style.display="none";
                                                                document.getElementById('rhs-phoneNumber3').style.display="none";
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Phone
                                                </label>
                                                <input type="text" class="form-control" value="{{$Formstyle->cfs_phone_value}}" style="width:50%;" onkeyup="setcompanyphone(this)">
                                                <script>
                                                    var phonevalue="{{$Formstyle->cfs_phone_value}}";
                                                        function setcompanyphone(e){
                                                            phonevalue=e.value;
                                                            document.getElementById('rhs-phoneNumber').innerHTML=e.value;
                                                            document.getElementById('rhs-phoneNumber2').innerHTML=e.value;
                                                            document.getElementById('rhs-phoneNumber3').innerHTML=e.value;
                                                        }
                                                </script>
                                            </div>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_email_check=="1")
                                                <input class="form-check-input" type="checkbox" checked id="checkcompanyemail" onchange="disableemail()">
                                                @else
                                                <input class="form-check-input" type="checkbox"  id="checkcompanyemail" onchange="disableemail()">
                                                @endif
                                                
                                                <script>
                                                        var showemail="{{$Formstyle->cfs_email_check}}";
                                                        $(document).ready(function(){
                                                            disableemail();
                                                        })
                                                        function disableemail(){
                                                            showemail="1";
                                                            if(document.getElementById('checkcompanyemail').checked){
                                                                document.getElementById('rhs-email').style.display="block";
                                                                document.getElementById('rhs-email2').style.display="block";
                                                                document.getElementById('rhs-email3').style.display="block";
                                                            }else{
                                                                showemail="0";
                                                                document.getElementById('rhs-email').style.display="none";
                                                                document.getElementById('rhs-email2').style.display="none";
                                                                document.getElementById('rhs-email3').style.display="none";
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Email
                                                </label>
                                                <input type="text" class="form-control" value="{{$Formstyle->cfs_email_value}}" style="width:50%;" onkeyup="setcompanyemail(this)">
                                                <script>
                                                        var comemail="{{$Formstyle->cfs_email_value}}";
                                                        function setcompanyemail(e){
                                                            comemail=e.value;
                                                            document.getElementById('rhs-email').innerHTML=e.value;
                                                            document.getElementById('rhs-email2').innerHTML=e.value;
                                                            document.getElementById('rhs-email3').innerHTML=e.value;
                                                        }
                                                </script>
                                            </div>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_crn_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="checkcompanyregistrationnumber" onchange="disableregistrationnumber()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value=""  id="checkcompanyregistrationnumber" onchange="disableregistrationnumber()">
                                                @endif
                                                
                                                <script>
                                                        var showrn="{{$Formstyle->cfs_crn_check}}";
                                                        $(document).ready(function(){
                                                            disableregistrationnumber();
                                                        })
                                                        function disableregistrationnumber(){
                                                            if(document.getElementById('checkcompanyregistrationnumber').checked){
                                                                showrn="1";
                                                                document.getElementById('rhs-crn').style.display="block";
                                                                document.getElementById('rhs-crn2').style.display="block";
                                                                document.getElementById('rhs-crn3').style.display="block";
                                                            }else{
                                                                showrn="0";
                                                                document.getElementById('rhs-crn').style.display="none";
                                                                document.getElementById('rhs-crn2').style.display="none";
                                                                document.getElementById('rhs-crn3').style.display="none";
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Company registration number
                                                </label>
                                                <input type="text" class="form-control" value="{{$Formstyle->cfs_crn_value}}" style="width:50%;" onkeyup="setcrn(this)">
                                                <script>
                                                        var crnvalue="{{$Formstyle->cfs_crn_value}}";
                                                        function setcrn(e){
                                                            crnvalue=e.value;
                                                            document.getElementById('rhs-crn').innerHTML=e.value;
                                                            document.getElementById('rhs-crn2').innerHTML=e.value;
                                                            document.getElementById('rhs-crn3').innerHTML=e.value;
                                                        }
                                                </script>
                                            </div>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_business_address_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="checkaddress" onchange="disableaddress()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value=""  id="checkaddress" onchange="disableaddress()">
                                                @endif
                                                
                                                <script>
                                                        var showaddress="{{$Formstyle->cfs_business_address_check}}";
                                                        $(document).ready(function(){
                                                            disableaddress();
                                                        })
                                                        function disableaddress(){
                                                            if(document.getElementById('checkaddress').checked){
                                                                showaddress="1";
                                                                document.getElementById('rhs-addrLine').style.display="block";
                                                                document.getElementById('rhs-addrLine2').style.display="block";
                                                                document.getElementById('rhs-addrLine3').style.display="block";
                                                                document.getElementById('rhs-state-zip').style.display="block";
                                                            }else{
                                                                showaddress="0";
                                                                document.getElementById('rhs-addrLine').style.display="none";
                                                                document.getElementById('rhs-addrLine2').style.display="none";
                                                                document.getElementById('rhs-addrLine3').style.display="none";
                                                                document.getElementById('rhs-state-zip').style.display="none";
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Business Address
                                                </label>
                                                <input type="text" class="form-control" value="{{$settings_company->company_address}}" style="width:50%;" readonly>
                                            </div>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_website_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="checkcompanywebsite" onchange="disablewebsite()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value="" checked id="checkcompanywebsite" onchange="disablewebsite()">
                                                @endif
                                                
                                                <script>
                                                        var showebsite="{{$Formstyle->cfs_website_check}}";
                                                        $(document).ready(function(){
                                                            disablewebsite();
                                                        })
                                                        function disablewebsite(){
                                                            if(document.getElementById('checkcompanywebsite').checked){
                                                                showebsite="1";
                                                                document.getElementById('rhs-website').style.display="block";
                                                                document.getElementById('rhs-website2').style.display="block";
                                                                document.getElementById('rhs-website3').style.display="block";
                                                            }else{
                                                                showebsite="0";
                                                                document.getElementById('rhs-website').style.display="none";
                                                                document.getElementById('rhs-website2').style.display="none";
                                                                document.getElementById('rhs-website3').style.display="none";
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Website
                                                </label>
                                                <input type="text" class="form-control" value="{{$Formstyle->cfs_website_value}}" style="width:50%;" onkeyup="setwebsite(this)">
                                                <script>
                                                        var webistecom="{{$Formstyle->cfs_website_value}}";
                                                        
                                                        function setwebsite(e){
                                                            webistecom=e.value;
                                                            document.getElementById('rhs-website').innerHTML=e.value;
                                                            document.getElementById('rhs-website2').innerHTML=e.value;
                                                            document.getElementById('rhs-website3').innerHTML=e.value;
                                                        }
                                                </script>
                                            </div>
                                            <br>
                                            <p>Form</p>
                                            
                                            <div class="form-check">
                                                @if($Formstyle->cfs_form_name_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="checkformname" onchange="disableformname()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value=""  id="checkformname" onchange="disableformname()">
                                                @endif
                                                
                                                <script>
                                                        var showformname="{{$Formstyle->cfs_form_name_check}}";
                                                        $(document).ready(function(){
                                                            disableformname();
                                                        })
                                                        function disableformname(){
                                                            if(document.getElementById('checkformname').checked){
                                                                showformname="1";
                                                                document.getElementById('formTitle-text').style.display="block";
                                                                document.getElementById('formTitle-text2').style.display="block";
                                                                document.getElementById('formTitle-text3').style.display="block";
                                                            }else{
                                                                showformname="0";
                                                                document.getElementById('formTitle-text').style.display="none";
                                                                document.getElementById('formTitle-text2').style.display="none";
                                                                document.getElementById('formTitle-text3').style.display="none";
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Form Name
                                                </label>
                                                <input type="text" class="form-control" style="width:50%;" value="{{$Formstyle->cfs_form_name_value}}" id="Formnameinput" onkeyup="setformtitle(this)">
                                                <script>
                                                        var formtitletemp="{{$Formstyle->cfs_form_name_value}}";
                                                        function setformtitle(e){
                                                            formtitletemp=e.value;
                                                            document.getElementById('formTitle-text').innerHTML=e.value;
                                                            document.getElementById('formTitle-text2').innerHTML=e.value;
                                                            document.getElementById('formTitle-text3').innerHTML=e.value;
                                                            document.getElementById('INVOOICENUM').innerHTML=e.value+"#";
                                                            document.getElementById('INVOOICENUM2').innerHTML=e.value+"#";
                                                        }
                                                </script>
                                            </div>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_form_number_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="checkformnumber" onchange="disableformnumber()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value=""  id="checkformnumber" onchange="disableformnumber()">
                                                @endif
                                                
                                                <script>
                                                        var showformnumber="{{$Formstyle->cfs_form_number_check}}";
                                                        $(document).ready(function(){
                                                            disableformnumber();
                                                        })
                                                        function disableformnumber(){
                                                            if(document.getElementById('checkformnumber').checked){
                                                                showformnumber="1";
                                                                document.getElementById('invoicenumberform').style.display="inline";
                                                                document.getElementById('invoicenumberform2').style.display="inline";
                                                            }else{
                                                                showformnumber="0";
                                                                document.getElementById('invoicenumberform').style.display="none";
                                                                document.getElementById('invoicenumberform2').style.display="none";
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Form numbers
                                                </label>
                                            </div>
                                            <div class="form-check" style="display:none;">
                                                <input class="form-check-input" type="checkbox" value="" checked id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Use custom transaction numbers
                                                </label>
                                            </div>
                                            <br>
                                            <p>Display</p>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_shipping_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="checkshipping" onchange="disableshipping()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value=""  id="checkshipping" onchange="disableshipping()">
                                                <script>
                                                    $(document).ready(function(){
                                                        showshipping="1";
                                                        document.getElementById('shiptodiv').style.display="none";
                                                        document.getElementById('shiptodiv2').style.display="none";
                                                        document.getElementById('shiptotable').style.display="none";
                                                        document.getElementById('shipdefailtdiv').style.display="none";
                                                        document.getElementById('shipdefailtdiv2').style.display="none";
                                                        document.getElementById('shipdefailtdiv3').style.display="none";
                                                    })
                                                
                                                </script>
                                                @endif
                                                <script>
                                                        var showshipping="{{$Formstyle->cfs_shipping_check}}";
                                                        
                                                        function disableshipping(){
                                                            if(document.getElementById('checkshipping').checked){
                                                                showshipping="1";
                                                                document.getElementById('shiptodiv').style.display="inline";
                                                                document.getElementById('shiptodiv2').style.display="inline-block";
                                                                document.getElementById('shiptotable').style.display="inline-block";
                                                                document.getElementById('shipdefailtdiv').style.display="inline";
                                                                document.getElementById('shipdefailtdiv2').style.display="inline";
                                                                document.getElementById('shipdefailtdiv3').style.display="inline";
                                                            }else{
                                                                showshipping="0";
                                                                document.getElementById('shiptodiv').style.display="none";
                                                                document.getElementById('shiptodiv2').style.display="none";
                                                                document.getElementById('shiptotable').style.display="none";
                                                                document.getElementById('shipdefailtdiv').style.display="none";
                                                                document.getElementById('shipdefailtdiv2').style.display="none";
                                                                document.getElementById('shipdefailtdiv3').style.display="none";
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Shipping
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_terms_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="checkterms" onchange="disableterm()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value=""  id="checkterms" onchange="disableterm()">
                                                <script>
                                                    $(document).ready(function(){
                                                        showterms="0";
                                                        document.getElementById('termtitle').style.display="none";
                                                        document.getElementById('termcontent').style.display="none";
                                                        $('td:nth-child(4),th:nth-child(4)','#tableinvoicedatedueterm ').hide();
                                                        $('td:nth-child(3),th:nth-child(3)','#tableinvoicedatedueterm2 ').hide();
                                                    })
                                                </script>
                                                @endif
                                                
                                                <script>
                                                        var showterms="{{$Formstyle->cfs_terms_check}}";
                                                        
                                                        function disableterm(){
                                                            //tableinvoicedatedueterm
                                                            if(document.getElementById('checkterms').checked){
                                                                showterms="1";
                                                                document.getElementById('termtitle').style.display="inline";
                                                                document.getElementById('termcontent').style.display="inline";
                                                                $('td:nth-child(4),th:nth-child(4)','#tableinvoicedatedueterm ').toggle();
                                                                $('td:nth-child(3),th:nth-child(3)','#tableinvoicedatedueterm2 ').toggle();
                                                               
                                                            }else{
                                                                showterms="0";
                                                                document.getElementById('termtitle').style.display="none";
                                                                document.getElementById('termcontent').style.display="none";
                                                                $('td:nth-child(4),th:nth-child(4)','#tableinvoicedatedueterm ').hide();
                                                                $('td:nth-child(3),th:nth-child(3)','#tableinvoicedatedueterm2 ').hide();
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Terms
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_duedate_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="checkduedate" onchange="disableduedate()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value=""  id="checkduedate" onchange="disableduedate()">
                                                <script>
                                                    $(document).ready(function(){
                                                        showduedate="0";
                                                        document.getElementById('duedatetitle').style.display="none";
                                                        document.getElementById('duedatecontent').style.display="none";
                                                        $('td:nth-child(3),th:nth-child(3)','#tableinvoicedatedueterm ').hide();
                                                        $('td:nth-child(2),th:nth-child(2)','#tableinvoicedatedueterm2 ').hide();
                                                    })
                                                </script>
                                                @endif
                                                
                                                <script>
                                                        var showduedate="{{$Formstyle->cfs_duedate_check}}";
                                                        function disableduedate(){
                                                            if(document.getElementById('checkduedate').checked){
                                                                showduedate="1";
                                                                document.getElementById('duedatetitle').style.display="inline";
                                                                document.getElementById('duedatecontent').style.display="inline";
                                                                $('td:nth-child(3),th:nth-child(3)','#tableinvoicedatedueterm ').toggle();
                                                                $('td:nth-child(2),th:nth-child(2)','#tableinvoicedatedueterm2 ').toggle();
                                                            }else{
                                                                showduedate="0";
                                                                document.getElementById('duedatetitle').style.display="none";
                                                                document.getElementById('duedatecontent').style.display="none";
                                                                $('td:nth-child(3),th:nth-child(3)','#tableinvoicedatedueterm ').hide();
                                                                $('td:nth-child(2),th:nth-child(2)','#tableinvoicedatedueterm2 ').hide();
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Due date
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse" id="contenttable">
                                        <div class="card card-body">
                                            <h4>Table</h4>
                                            
                                            <p style="display:none;">Account summary</p>
                                            <div class="form-check" style="display:none;">
                                                <input class="form-check-input" type="checkbox" value="" checked >
                                                
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Show on invoice
                                                </label>
                                            </div>
                                            <br>
                                            <p>Activity table</p>
                                            <small>COLUMNS</small>
                                            
                                            <div class="form-check">
                                                @if($Formstyle->cfs_table_date_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="checktabledate" onchange="hideabledate()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value=""  id="checktabledate" onchange="hideabledate()">
                                                <script>
                                                    $(document).ready(function(){
                                                        showtabledate="0";
                                                        $('td:nth-child(1),th:nth-child(1)','#activityTableLhsTableHeader ').hide();
                                                    })
                                                </script>
                                                @endif
                                                
                                                <script>
                                                    ///table columns
                                                        var showtabledate="{{$Formstyle->cfs_table_date_check}}";
                                                        
                                                        function hideabledate(){
                                                            if(document.getElementById('checktabledate').checked){
                                                                showtabledate="1";
                                                                $('td:nth-child(1),th:nth-child(1)','#activityTableLhsTableHeader ').toggle();
                                                                
                                                            }else{
                                                                showtabledate="0";
                                                                $('td:nth-child(1),th:nth-child(1)','#activityTableLhsTableHeader ').hide();
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Date
                                                </label>
                                            </div>
                                            <hr>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_table_product_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="checkprod" onchange="hidetableprod()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value=""  id="checkprod" onchange="hidetableprod()">
                                                <script>
                                                    $(document).ready(function(){
                                                        showtableprod="0";
                                                        $('td:nth-child(2),th:nth-child(2)','#activityTableLhsTableHeader ').hide();
                                                    })
                                                </script>
                                                @endif
                                                
                                                <script>
                                                        var showtableprod="{{$Formstyle->cfs_table_product_check}}";
                                                        
                                                        function hidetableprod(){
                                                            if(document.getElementById('checkprod').checked){
                                                                showtableprod="1";
                                                                $('td:nth-child(2),th:nth-child(2)','#activityTableLhsTableHeader ').toggle();
                                                                
                                                            }else{
                                                                showtableprod="0";
                                                                $('td:nth-child(2),th:nth-child(2)','#activityTableLhsTableHeader ').hide();
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Product/Services
                                                </label>
                                            </div>
                                            <hr>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_table_desc_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked  id="checkdesc" onchange="hidetabledesc()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value=""   id="checkdesc" onchange="hidetabledesc()">
                                                <script>
                                                    $(document).ready(function(){
                                                        showtabledesc="0";
                                                        $('td:nth-child(3),th:nth-child(3)','#activityTableLhsTableHeader ').hide();
                                                    })
                                                </script>
                                                @endif
                                               
                                                <script>
                                                        var showtabledesc="{{$Formstyle->cfs_table_desc_check}}";
                                                        
                                                        function hidetabledesc(){
                                                            if(document.getElementById('checkdesc').checked){
                                                                showtabledesc="1";
                                                                $('td:nth-child(3),th:nth-child(3)','#activityTableLhsTableHeader ').toggle();
                                                                
                                                            }else{
                                                                showtabledesc="0";
                                                                $('td:nth-child(3),th:nth-child(3)','#activityTableLhsTableHeader ').hide();
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Description
                                                </label>
                                            </div>
                                            <hr>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_table_qty_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked  id="checkqty" onchange="hidetableqty()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value=""   id="checkqty" onchange="hidetableqty()">
                                                <script>
                                                    $(document).ready(function(){
                                                        showtableqty="0";
                                                        $('td:nth-child(4),th:nth-child(4)','#activityTableLhsTableHeader ').hide();
                                                    })
                                                </script>
                                                @endif
                                                
                                                <script>
                                                        var showtableqty="{{$Formstyle->cfs_table_qty_check}}";
                                                        
                                                        function hidetableqty(){
                                                            if(document.getElementById('checkqty').checked){
                                                                showtableqty="1";
                                                                $('td:nth-child(4),th:nth-child(4)','#activityTableLhsTableHeader ').toggle();
                                                                
                                                            }else{
                                                                showtableqty="0";
                                                                $('td:nth-child(4),th:nth-child(4)','#activityTableLhsTableHeader ').hide();
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Quantity
                                                </label>
                                            </div>
                                            <hr>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_table_rate_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="checkrate" onchange="hidetablerate()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value=""  id="checkrate" onchange="hidetablerate()">
                                                <script>
                                                    $(document).ready(function(){
                                                        showtablerate="0";
                                                        $('td:nth-child(5),th:nth-child(5)','#activityTableLhsTableHeader ').hide();
                                                    })
                                                </script>
                                                @endif
                                                
                                                <script>
                                                        var showtablerate="{{$Formstyle->cfs_table_rate_check}}";
                                                        
                                                        function hidetablerate(){
                                                            if(document.getElementById('checkrate').checked){
                                                                showtablerate="1";
                                                                $('td:nth-child(5),th:nth-child(5)','#activityTableLhsTableHeader ').toggle();
                                                                
                                                            }else{
                                                                showtablerate="0";
                                                                $('td:nth-child(5),th:nth-child(5)','#activityTableLhsTableHeader ').hide();
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Rate
                                                </label>
                                            </div>
                                            <hr>
                                            <div class="form-check">
                                                @if($Formstyle->cfs_table_amount_check=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="checkamount" onchange="hidetableamount()">
                                                @else
                                                <input class="form-check-input" type="checkbox" value=""  id="checkamount" onchange="hidetableamount()">
                                                <script>
                                                    $(document).ready(function(){
                                                        showtableamount="0";
                                                        $('td:nth-child(6),th:nth-child(6)','#activityTableLhsTableHeader ').hide();
                                                    })
                                                </script>
                                                @endif
                                                
                                                <script>
                                                        var showtableamount="{{$Formstyle->cfs_table_amount_check}}";
                                                        
                                                        function hidetableamount(){
                                                            if(document.getElementById('checkamount').checked){
                                                                showtableamount="1";
                                                                $('td:nth-child(6),th:nth-child(6)','#activityTableLhsTableHeader ').toggle();
                                                                
                                                            }else{
                                                                showtableamount="0";
                                                                $('td:nth-child(6),th:nth-child(6)','#activityTableLhsTableHeader ').hide();
                                                            }
                                                        }
                                                </script>
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Amount
                                                </label>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="collapse" id="contentfooter">
                                        <div class="card card-body">
                                            <h3>Footer</h3>
                                            
                                            <p style="display:none">Display</p>
                                            <div class="form-check" style="display:none">
                                                <input class="form-check-input" type="checkbox" value="" checked id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Discount
                                                </label>
                                            </div>
                                            <div class="form-check" style="display:none">
                                                <input class="form-check-input" type="checkbox" value="" checked id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Deposit
                                                </label>
                                            </div>
                                            <br>
                                            <p>Message to customer on <span id="messagekind">Invoice</span></p>
                                            <div class="row">
                                            <div class="col-md-6">
                                            <textarea class="form-control" rows="3" id="messagetocustomer" onkeyup="footerMessage()">{{$Formstyle->cfs_footer_message_value}}</textarea>
                                            <script>
                                                var footmessage="{{$Formstyle->cfs_footer_message_value}}";
                                                var footmessagesize="{{$Formstyle->cfs_footer_message_font_size}}";
                                                $(document).ready(function(){
                                                    document.getElementById('footermessagefontsize').value="{{$Formstyle->cfs_footer_message_font_size}}";
                                                    footerMessage();
                                                })
                                                function footerMessage(){
                                                    footmessagesize=document.getElementById('footermessagefontsize').value;
                                                    footmessage=document.getElementById('messagetocustomer').value;
                                                    document.getElementById('footerMessage').innerHTML=document.getElementById('messagetocustomer').value;
                                                    document.getElementById('footerMessage').style.fontSize=document.getElementById('footermessagefontsize').value;
                                                    document.getElementById('footerMessage2').innerHTML=document.getElementById('messagetocustomer').value;
                                                    document.getElementById('footerMessage2').style.fontSize=document.getElementById('footermessagefontsize').value;
                                                    document.getElementById('footerMessage3').innerHTML=document.getElementById('messagetocustomer').value;
                                                    document.getElementById('footerMessage3').style.fontSize=document.getElementById('footermessagefontsize').value;
                                                }
                                            </script>
                                            </div>
                                            <div class="col-md-6">
                                            <select class="form-control" onchange="footerMessage()" id="footermessagefontsize" style="width:50%;">
                                                <option value="8px">8pt</option>
                                                <option value="10px">10pt</option>
                                                <option value="12px">12pt</option>
                                            </select>
                                            </div>
                                            </div>
                                            <br>
                                            <p>Add footer text</p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                <textarea class="form-control" rows="3" id="footertextadd" onkeyup="footerText()">{{$Formstyle->cfs_footer_message_value}}</textarea>
                                                <script>
                                                        var footertext="{{$Formstyle->cfs_footer_message_value}}";
                                                        var footertextsize="{{$Formstyle->cfs_footer_message_value}}";
                                                        var footertextalign="{{$Formstyle->cfs_footer_message_value}}";
                                                        $(document).ready(function(){
                                                            document.getElementById('footertextsize').value="{{$Formstyle->cfs_footer_text_font_size}}";
                                                            document.getElementById('footertextposition').value="{{$Formstyle->cfs_footer_text_position}}";
                                                            footerText();
                                                        })
                                                        function footerText(){
                                                            footertext=document.getElementById('footertextadd').value;
                                                            footertextsize=document.getElementById('footertextsize').value;
                                                            footertextalign=document.getElementById('footertextposition').value;
                                                            document.getElementById('footerText').innerHTML=document.getElementById('footertextadd').value;
                                                            document.getElementById('footerText').style.fontSize=document.getElementById('footertextsize').value;
                                                            document.getElementById('footerText').style.textAlign=document.getElementById('footertextposition').value;
                                                            document.getElementById('footerText2').innerHTML=document.getElementById('footertextadd').value;
                                                            document.getElementById('footerText2').style.fontSize=document.getElementById('footertextsize').value;
                                                            document.getElementById('footerText2').style.textAlign=document.getElementById('footertextposition').value;
                                                            document.getElementById('footerText3').innerHTML=document.getElementById('footertextadd').value;
                                                            document.getElementById('footerText3').style.fontSize=document.getElementById('footertextsize').value;
                                                            document.getElementById('footerText3').style.textAlign=document.getElementById('footertextposition').value;
                                                        }
                                                </script>
                                                </div>
                                                <div class="col-md-6">
                                                <select class="form-control" style="width:50%;margin-bottom:10px;" id="footertextsize" onchange="footerText()">
                                                    <option value="8px">8pt</option>
                                                    <option value="10px">10pt</option>
                                                    <option value="12px">12pt</option>
                                                </select>
                                                
                                                <select class="form-control" style="width:50%;" id="footertextposition" onchange="footerText()">
                                                        <option selected value="center">Centered</option>
                                                        <option value="left">Left</option>
                                                        <option value="right">Right</option>
                                                </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                <!--Email Tab-->
                                <div class="row">
                                        <div class="col-md-8">
                                        </div>
                                        <div class="col-md-4" >
                                        <select class="form-control" onchange="changetpye(this)">
                                            <option></option>
                                            <option>Standard Email</option>
                                            <option>Reminder Email</option>
                                        </select>
                                        <script>
                                            
                                            function changetpye(e){
                                                var ddd=document.getElementById('emailSubject').value;
                                                ddd=ddd.replace("Reminder: ", "");
                                               if(e.value=="Standard Email"){
                                                   document.getElementById('emailSubject').value=ddd;
                                                   document.getElementById('messagecustomertextarea').value="Here's your invoice! We appreciate your prompt payment.\nThanks for your business!\nECC";
                                               }else{
                                                   document.getElementById('emailSubject').value="Reminder: "+document.getElementById('emailSubject').value;
                                                   document.getElementById('messagecustomertextarea').value="Just a reminder that we have not received a payment for this invoice yet. Let us know if you have questions.\nThanks for your business!\nECC";
                                               }
                                               setgreeting();
                                               setEmailMessage();
                                            }
                                        </script>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="margin-top:10px;">
                                            <p>Edit the email your customers get with every invoice</p>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-check-label" style="font-weight:bold;">
                                                    Subject
                                            </label>
                                            <input type="text" id="emailSubject" class="form-control" value="{{$Formstyle->cfs_email_subject}}">
                                        </div>
                                        
                                        <div class="col-md-12" style="margin-top:20px;">
                                           <div class="form-check">
                                                @if($Formstyle->cfs_email_use_greeting=="1")
                                                <input class="form-check-input" type="checkbox" value="" checked id="sssd" onclick="usergreetingche()">
                                                <script>
                                                    var usegreetingcheck="1";
                                                </script>
                                                @else
                                                <input class="form-check-input" type="checkbox" value="" id="sssd" onclick="usergreetingche()">
                                                <script>
                                                    var usegreetingcheck="0";

                                                </script>
                                                @endif
                                                <label class="form-check-label" for="defaultCheck1">
                                                Use greeting
                                                </label>
                                            </div>
                                            <script>
                                                $(document).ready(function(){
                                                    document.getElementById('greetingpronouns').value="{{$Formstyle->cfs_email_greeting_pronoun}}";
                                                    //alert("{{$Formstyle->cfs_email_greeting_pronoun}}");
                                                    document.getElementById('greetingwor').value="{{$Formstyle->cfs_email_greeting_word}}";
                                                    //alert("{{$Formstyle->cfs_email_greeting_word}}");
                                                    
                                                    setgreeting();
                                                    setEmailMessage();
                                                    usergreetingche();
                                                })
                                                
                                                function usergreetingche(){
                                                    //alert(document.getElementById('sssd').checked);
                                                    if(document.getElementById('sssd').checked){
                                                        usegreetingcheck="1";
                                                        document.getElementById('greetingsection').style.display="block";
                                                    }else{
                                                        usegreetingcheck="0";
                                                        document.getElementById('greetingsection').style.display="none";
                                                    }
                                                }
                                            </script>
                                        </div>
                                        <div class="col-md-12" style="margin-top:10px;">
                                            <div class="form-inline">
                                            
                                            <div class="form-group mb-2 mx-sm-3">
                                                <select class="form-control" id="greetingwor" onchange="setgreeting()">
                                                    <option>&lt;Blank&gt;</option>
                                                    <option>To</option>
                                                    <option selected>Dear</option>
                                                </select>
                                            </div>
                                            <div class="form-group mx-sm-3 mb-2">
                                                <select class="form-control" id="greetingpronouns" onchange="setgreeting()">
                                                    <option>[FullName]</option>
                                                    <option>[First][Last]</option>
                                                    <option>[Title][Last]</option>
                                                    <option>[First]</option>
                                                    <option>[CompanyName]</option>
                                                    <option>[DisplayName]</option>
                                                </select>
                                            </div>
                                            <script>
                                                function setgreeting(){
                                                    var rtype=document.getElementById('greetingwor').value;
                                                    var promoun=document.getElementById('greetingpronouns').value;
                                                    if(rtype=="&lt;Blank&gt;"){
                                                        document.getElementById('greetingsection').innerHTML=promoun;
                                                    }else{
                                                        document.getElementById('greetingsection').innerHTML=rtype+" "+promoun;
                                                    }
                                                }
                                            </script>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-check-label" style="font-weight:bold;">
                                                Message to customer
                                            </label>
                                            <textarea class="form-control" style="white-space: pre-wrap;" onkeyup="setEmailMessage()" rows="5" id="messagecustomertextarea">{{$Formstyle->cfs_email_message}}
                                            </textarea>
                                            <script>
                                                function setEmailMessage(){
                                                    //alert(document.getElementById('messagecustomertextarea').value);
                                                    document.getElementById('messagetoCustomer').innerHTML=document.getElementById('messagecustomertextarea').value;
                                                }
                                            </script>
                                            
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    </div>
            </div>
            <div class="col-md-6">
                <div id="formtemplatepage" style="font-family: Helvetica; padding: 0px; font-size: 8px; min-height: 760px;">
                    <div id="formdesigntemplate1" class="showndesigntemplate" style="background-color:white;overflow:auto;border:1px solid #ccc;border-bottom:3px solid #ccc;">
                        <div id="page-wrap" style="padding: 0.5in 0in">
                            <div id="header" style="padding-left:20px;margin-bottom:20px;">
                                <div id="headerSec" class="row" style="margin-bottom:10px;margin-left:0px;margin-right:0px;">
                                    <div class="col-md-12" style="padding-left:0px;">
                                    <div class="companyAdd1" id="comapnyinformationdiv2" style="display:inline-block;float:left;width:40%;">
                                        <div>
                                            <div id="rhs-companyName" style="font-family: Helvetica; font-size: 14px;">{{$Formstyle->cfs_company_name_value}}</div>
                                            <div>
                                                <div id="rhs-addrLine" style="font-family: Helvetica; font-size: 10px;">{{$settings_company->company_address}}</div>
                                                <div><span id="rhs-state-zip" style="font-family: Helvetica; font-size: 10px;"></span></div>
                                            </div>
                                            <div style="font-family: Helvetica; font-size: 10px;">
                                                <div id="rhs-phoneNumber" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_phone_value}}</div>
                                                <div id="rhs-email" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_email_value}}</div>
                                                <div id="rhs-crn" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_crn_value}}</div>
                                                <div id="rhs-website" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_website_value}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="templateLogo" id="logocontainer2" style="display: inline-block; float: right;">
                                            <div class="logo" style="float: right; display:none;" id="lllll">
                                                <img id="Templatelogo" src="{{asset('images/lowstock.png')}}" style="max-height: 100px;">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div id="formTitle" style="font-family: Helvetica;">
                                    <label id="formTitle-text" class="formTitleText uppercase" style=" text-transform: uppercase;color: rgb(79, 144, 187); font-family: Helvetica; font-size: 14px;font-weight:bold;">INVOICE</label>
                                </div>
                                <div class="prefContainer" style="font-size: 10px;">
                                    <div class="billToSection" style="width:35%;display:inline-block">
                                        <div>
                                            <div class="header" style="font-size: 10px;">
                                            <div class="sectionHeader upperCase" style="font-family: Helvetica; color: black; font-size: 10px;">BILL TO</div>
                                            </div>
                                            <div class="addlines" style="font-family: Helvetica; font-size: 10px;">
                                            <div>Smith Co.</div>
                                            <div>123 Main Street</div>
                                            <span>City,&nbsp;</span>
                                            <span>CA 12345</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="titleSection" style="float:right;width:26%;">
                                        <table class="inlineBlock" style="padding: 0px; border-collapse: collapse;float:right;margin-right:20px;">
                                            <tbody>
                                            <tr style="font-family: Helvetica;">
                                                <td class="titleText" id="INVOOICENUM" style="font-size: 10px;  text-align:right;padding-right:10px;">INVOICE#</td>
                                                <td class="titleValue" style="font-size: 10px;" ><span id="invoicenumberform">12345</span></td>
                                            </tr>
                                            <tr style="font-family: Helvetica;">
                                                <td class="titleText" style="font-size: 10px; text-align:right;padding-right:10px;">DATE</td>
                                                <td class="titleValue" style="font-size: 10px;">01/07/2018</td>
                                            </tr>
                                            <tr style="font-family: Helvetica;">
                                                <td class="titleText" style="font-size: 10px; text-align:right;padding-right:10px;"><span id="duedatetitle">DUE DATE</span></td>
                                                <td class="titleValue" style="font-size: 10px;"><span id="duedatecontent">02/06/2018</span></td>
                                            </tr>
                                            <tr style="font-family: Helvetica;">
                                                <td class="titleText" style="font-size: 10px;  text-align:right;padding-right:10px;"><span id="termtitle">TERMS</span></td>
                                                <td class="titleValue" style="font-size: 10px;"><span id="termcontent">Net 30</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="" id="shiptodiv" style="float:right;width:35%;">
                                            <table class="inlineBlock" style="padding: 0px; border-collapse: collapse;">
                                                <tbody>
                                                <tr style="font-family: Helvetica;">
                                                    <td class="titleText" style="font-size: 10px; ">SHIP TO</td>
                                                    
                                                </tr>
                                                <tr style="font-family: Helvetica;">
                                                    <td class="titleText" style="font-size: 10px; ">John Smith</td>
                                                   
                                                </tr>
                                                <tr style="font-family: Helvetica;">
                                                    <td class="titleText" style="font-size: 10px; ">209812 Palm Drive</td>
                                                    
                                                </tr>
                                                <tr style="font-family: Helvetica;">
                                                    <td class="titleText" style="font-size: 10px;">City, CA 12345</td>
                                                   
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                                <br>
                                <div class="shippingAndCustom" id="shipdefailtdiv" style="font-size: 12px;">
                                    <div>
                                        <style>
                                            .shippingFields{
                                                width:33%;
                                                display: inline-block ;
                                            }
                                        </style>
                                        <div class="shippingFields">
                                            <div class="fieldTitle upperCase" >SHIP DATE</div>
                                            <div class="fieldValue">01/03/2018</div>
                                        </div>
                                        <div class="shippingFields">
                                            <div class="fieldTitle upperCase" >SHIP VIA</div>
                                            <div class="fieldValue">FedEx</div>
                                        </div>
                                        <div class="shippingFields">
                                            <div class="fieldTitle upperCase" >TRACKING NO.</div>
                                            <div class="fieldValue">12345678</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="content" class="" >
                                <div id="overlayId" class=""></div>
                                <div class="detailSection" style="min-height:150px;">
                                    <div class="dgrid dgrid-03 dgrid-grid ui-widget">
                                        <div>
                                            <style>
                                                .table-sm td, .table-sm th{
                                                    padding:3px 10px!important;
                                                }
                                            </style>
                                                <table id="activityTableLhsTableHeader" style="width:100%;" class="dgrid-row-table table table-sm" role="presentation">
                                                    <thead >
                                                        <tr >
                                                            <th class="dgrid-cell hcoll-date" role="columnheader" rowspan="2" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">DATE</th>
                                                            <th class="dgrid-cell hcoll-prod" role="columnheader" rowspan="2" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">ACTIVITY</th>
                                                            <th class="dgrid-cell hcoll-desc" role="columnheader" rowspan="2" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">DESCRIPTION</th>
                                                            <th class="dgrid-cell hcoll-qty" role="columnheader" rowspan="2" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">QTY</th>
                                                            <th class="dgrid-cell hcoll-rate" role="columnheader" rowspan="2" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">RATE</th>
                                                            <th class="dgrid-cell hcoll-amount" role="columnheader" rowspan="2" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">AMOUNT</th>
                                                            <th class="dgrid-cell hcoll-sku" role="columnheader" rowspan="2" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">SKU</th>
                                                        </tr>
                                                        
                                                    </thead>
                                                    <tbody>
                                                            <tr>
                                                                <td class="dgrid-cell coll-date" role="columnheader" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px;">01/07/2018</td>
                                                                <td class="dgrid-cell coll-prod" role="columnheader" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px;">Item name</td>
                                                                <td class="dgrid-cell coll-desc" role="columnheader" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px;">Description of the item</td>
                                                                <td class="dgrid-cell coll-qty" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">2</td>
                                                                <td class="dgrid-cell coll-rate" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                <td class="dgrid-cell coll-amount" role="columnheader" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px;">450.00</td>
                                                                <td class="dgrid-cell coll-sku" role="columnheader" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px;">PRD123</td>
                                                            </tr>
                                                            <tr>
                                                                    <td class="dgrid-cell coll-date" role="columnheader" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px;">01/07/2018</td>
                                                                    <td class="dgrid-cell coll-prod" role="columnheader" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px;">Item name</td>
                                                                    <td class="dgrid-cell coll-desc" role="columnheader" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px;">Description of the item</td>
                                                                    <td class="dgrid-cell coll-qty" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">1</td>
                                                                    <td class="dgrid-cell coll-rate" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                    <td class="dgrid-cell  coll-amount" role="columnheader" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                    <td class="dgrid-cell coll-sku" role="columnheader" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px;">PRD123</td>
                                                                </tr>
                                                    </tbody>
                                                </table>
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="totalValue" style="margin-top:10px;margin-bottom:10px;border-top:1px dotted #bdbbbb"></div>
                            <div id="footer" class="">
                                <div id="overlayId" class=""></div>
                                <div>
                                    <div class="subTotalSection">
                                        
                                        <div class="subTotalCenter"></div>
                                        <div class="subTotalRight" style="width:100%;">
                                            <style>
                                                #footerMessage{
                                                    display: inline-block !important;
                                                }
                                            </style>
                                            <div id="footerMessage" style="font-size: 8px; white-space: pre-line;margin-left:20px;"></div>
                                            
                                            <table style="width:30%;margin-right:20px;font-size:10px;float:right;">
                                                <tbody>
                                                    <tr>
                                                        <td id="SubTotalTitle" style="text-align:left;color: rgb(79, 144, 187);">SUBTOTAL</td>
                                                        <td style="text-align:right">675.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td id="TotalTitle" style="text-align:left;color: rgb(79, 144, 187);">TOTAL</td>
                                                        <td style="text-align:right">PHP675.00</td>
                                                    </tr>
                                                    <tr >
                                                        <td style="padding: 3px;"></td>
                                                        <td style="padding: 3px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:left">BALANCE DUE</td>
                                                        <td style="text-align:right;font-size:12px">PHP675.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                                <div style="clear: both;"></div>
                                <div style="padding-top: 0.5in;">
                                    <div id="footerText" class="left-footer-text" style="font-size: 8px; text-align: center; white-space: pre-line;margin-right:20px;margin-left:20px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="formdesigntemplate2" class="hiddendesigntemplate" style="background-color:white;overflow:auto;border:1px solid #ccc;border-bottom:3px solid #ccc;">
                        <div id="page-wrap2" style="padding: 0.5in 0in">
                            <div id="header" style="padding-left:20px;margin-bottom:20px;">
                                <div id="headerSec" class="row" style="margin-bottom:10px;margin-left:0px;margin-right:0px;">
                                    <div class="col-md-12" style="padding-left:0px;">
                                    <div class="companyAdd1" id="comapnyinformationdiv" style="display:inline-block;float:left;width:40%;">
                                        <div>
                                            <div id="rhs-companyName2" style="font-family: Helvetica; font-size: 14px;">{{$Formstyle->cfs_company_name_value}}</div>
                                            <div>
                                                <div id="rhs-addrLine2" style="font-family: Helvetica; font-size: 10px;">{{$settings_company->company_address}}</div>
                                                <div><span id="rhs-state-zip" style="font-family: Helvetica; font-size: 10px;"></span></div>
                                            </div>
                                            <div style="font-family: Helvetica; font-size: 10px;">
                                                <div id="rhs-phoneNumber2" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_phone_value}}</div>
                                                <div id="rhs-email2" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_email_value}}</div>
                                                <div id="rhs-crn2" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_crn_value}}</div>
                                                <div id="rhs-website2" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_website_value}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="templateLogo" id="logocontainer" style="display: inline-block; float: right;">
                                            <div class="logo" style="float: right; display:none;" id="lllll2">
                                                <img id="Templatelogo2" src="{{asset('images/lowstock.png')}}" style="max-height: 100px;">
                                            </div>
                                    </div>
                                    <div id="formTitle2" style="font-family: Helvetica;float:right;">
                                            <label id="formTitle-text2" class="formTitleText uppercase" style=" text-transform: uppercase;color: rgb(79, 144, 187); font-family: Helvetica; font-size: 14px;font-weight:bold;">INVOICE</label>
                                    </div>
                                    </div>
                                    
                                </div>
                                <!--head section end-->
                                <div class="prefContainer" style="font-size: 10px;">
                                        <div class="">
                                            <div class="col-md-6">
                                            <div class="billToSection" style="width:70%;float:right;">
                                                <div style="border: 1px solid #ccc">
                                                    <div class="header" style="font-size: 10px;">
                                                    <div class="sectionHeader upperCase" id="billtocolored" style="padding:3px;color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);font-family: Helvetica; font-size: 10px;">BILL TO</div>
                                                    </div>
                                                    <div class="addlines" style="font-family: Helvetica; font-size: 10px;">
                                                    <div style="padding-left:3px;">Smith Co.</div>
                                                    <div style="padding-left:3px;">123 Main Street</div>
                                                    <span style="padding-left:3px;">City,&nbsp;</span>
                                                    <span style="padding-left:3px;">CA 12345</span>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-6" style="padding-left:0px;">
                                            <div class="" id="shiptodiv2" style="width:70%;">
                                                <table class="" style="width:100%;padding: 0px; border-collapse: collapse;border: 1px solid #ccc">
                                                    <tbody >
                                                    <tr style="color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);font-family: Helvetica;">
                                                        <td class="titleText" id="shiptocolored" style="font-size: 10px; padding:3px;">SHIP TO</td>
                                                        
                                                    </tr>
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" style="font-size: 10px;padding-left:3px; ">John Smith</td>
                                                       
                                                    </tr>
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" style="font-size: 10px; padding-left:3px;">209812 Palm Drive</td>
                                                        
                                                    </tr>
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" style="font-size: 10px;padding-left:3px;">City, CA 12345</td>
                                                       
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="col-md-12" style="margin-top:5px;padding-left:0px;padding-right:10px;">
                                                <div class="titleSection" style="margin-top:3px;">
                                                    <table class="inlineBlock" id="tableinvoicedatedueterm" style="border: 1px solid #ccc; border-collapse: collapse;width:100%;">
                                                        <tbody >
                                                        <tr id="tabletrinvoicenumber" style="color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);font-family: Helvetica;">
                                                            <td class="titleText" id="INVOOICENUM2" style="padding:3px;font-size: 10px;padding-right:10px;">INVOICE#</td>
                                                            <td class="titleText" style="font-size: 10px; padding:3px;">DATE</td>
                                                            <td class="titleText" style="font-size: 10px;padding:3px;"><span id="duedatetitle">DUE DATE</span></td>
                                                            <td class="titleText" style="font-size: 10px; padding:3px;"><span id="termtitle">TERMS</span></td>
                                                            
                                                        </tr>
                                                        <tr style="font-family: Helvetica;">
                                                            <td class="titleValue" style="font-size: 10px;padding:3px;" ><span id="invoicenumberform2">12345</span></td>
                                                            <td class="titleValue" style="font-size: 10px;padding:3px;">01/07/2018</td>
                                                            <td class="titleValue" style="font-size: 10px;padding:3px;"><span id="duedatecontent">02/06/2018</span></td>
                                                            <td class="titleValue" style="font-size: 10px;padding:3px;"><span id="termcontent">Net 30</span></td>
                                                        </tr>
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-top:10px;">
                                                <div class="shippingAndCustom" id="shipdefailtdiv2" style="font-size: 10px;margin-top:10px;">
                                                    <div>
                                                        
                                                        <div class="shippingFields">
                                                            <div class="fieldTitle upperCase" >SHIP DATE</div>
                                                            <div class="fieldValue">01/03/2018</div>
                                                        </div>
                                                        <div class="shippingFields">
                                                            <div class="fieldTitle upperCase" >SHIP VIA</div>
                                                            <div class="fieldValue">FedEx</div>
                                                        </div>
                                                        <div class="shippingFields">
                                                            <div class="fieldTitle upperCase" >TRACKING NO.</div>
                                                            <div class="fieldValue">12345678</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        

                                        
                                    </div>

                            </div>
                            <!--header end-->
                            
                            <div id="content" class="" >
                                    <div id="overlayId" class="col-md-12" style="margin-top:20px;">
                                    <div class="detailSection" style="min-height:150px;">
                                        <div class="dgrid dgrid-03 dgrid-grid ui-widget" styl="padding:10px 10px;">
                                            <div>
                                                <style>
                                                    .table-sm td, .table-sm th{
                                                        padding:3px 10px!important;
                                                    }
                                                </style>
                                                    <table id="activityTableLhsTableHeader" style="width:100%;border:1px solid #ccc ;" class="dgrid-row-table table table-sm" role="presentation">
                                                        <thead >
                                                            <tr >
                                                                <th class="dgrid-cell hcoll-date" role="columnheader" rowspan="2" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">DATE</th>
                                                                <th class="dgrid-cell hcoll-prod" role="columnheader" rowspan="2" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">ACTIVITY</th>
                                                                <th class="dgrid-cell hcoll-desc" role="columnheader" rowspan="2" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">DESCRIPTION</th>
                                                                <th class="dgrid-cell hcoll-qty" role="columnheader" rowspan="2" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">QTY</th>
                                                                <th class="dgrid-cell hcoll-rate" role="columnheader" rowspan="2" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">RATE</th>
                                                                <th class="dgrid-cell hcoll-amount" role="columnheader" rowspan="2" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">AMOUNT</th>
                                                                <th class="dgrid-cell hcoll-sku" role="columnheader" rowspan="2" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">SKU</th>
                                                            </tr>
                                                            
                                                        </thead>
                                                        <tbody>
                                                                <tr>
                                                                    <td class="dgrid-cell coll-date" role="columnheader" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px;">01/07/2018</td>
                                                                    <td class="dgrid-cell coll-prod" role="columnheader" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px;">Item name</td>
                                                                    <td class="dgrid-cell coll-desc" role="columnheader" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px;">Description of the item</td>
                                                                    <td class="dgrid-cell coll-qty" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">2</td>
                                                                    <td class="dgrid-cell coll-rate" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                    <td class="dgrid-cell coll-amount" role="columnheader" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px;">450.00</td>
                                                                    <td class="dgrid-cell coll-sku" role="columnheader" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px;">PRD123</td>
                                                                </tr>
                                                                <tr>
                                                                        <td class="dgrid-cell coll-date" role="columnheader" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px;">01/07/2018</td>
                                                                        <td class="dgrid-cell coll-prod" role="columnheader" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px;">Item name</td>
                                                                        <td class="dgrid-cell coll-desc" role="columnheader" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px;">Description of the item</td>
                                                                        <td class="dgrid-cell coll-qty" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">1</td>
                                                                        <td class="dgrid-cell coll-rate" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                        <td class="dgrid-cell  coll-amount" role="columnheader" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                        <td class="dgrid-cell coll-sku" role="columnheader" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px;">PRD123</td>
                                                                    </tr>
                                                        </tbody>
                                                    </table>
                                                
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <!-- content end-->
                                <div>
                                    <div class="col-md-12">
                                            <div id="totalValue" style="margin-top:10px;margin-bottom:10px;border-top:1px dotted #bdbbbb"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="col-md-12">
                                            <div id="footer" class="">
                                                    <div id="overlayId" class=""></div>
                                                        <div>
                                                        <div class="subTotalSection">
                                                            <div class="subTotalCenter"></div>
                                                                        <div class="subTotalRight" style="width:100%;">
                                                                            <style>
                                                                                #footerMessage2{
                                                                                    display: inline-block !important;
                                                                                }
                                                                            </style>
                                                                            <div id="footerMessage2" style="font-size: 8px; white-space: pre-line;margin-left:20px;"></div>
                                                                            
                                                                            <table style="width:30%;margin-right:20px;font-size:10px;float:right;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td id="SubTotalTitle2" style="text-align:left;color: rgb(79, 144, 187);">SUBTOTAL</td>
                                                                                        <td style="text-align:right">675.00</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td id="TotalTitle2" style="text-align:left;color: rgb(79, 144, 187);">TOTAL</td>
                                                                                        <td style="text-align:right">PHP675.00</td>
                                                                                    </tr>
                                                                                    <tr >
                                                                                        <td style="padding: 3px;"></td>
                                                                                        <td style="padding: 3px;"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td style="text-align:left">BALANCE DUE</td>
                                                                                        <td style="text-align:right;font-size:12px">PHP675.00</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    
                                                </div>
                                            <div style="clear: both;"></div>
                                            <div style="padding-top: 0.5in;">
                                                <div id="footerText2" class="left-footer-text" style="font-size: 8px; text-align: center; white-space: pre-line;margin-right:20px;margin-left:20px;margin-bottom:0.5in"></div>
                                            </div>
                                            </div>
                                    </div>
                                </div>
                                    
                        </div>
                    </div>
                    <div id="formdesigntemplate3" class="hiddendesigntemplate" style="background-color:white;overflow:auto;border:1px solid #ccc;border-bottom:3px solid #ccc;">
                        <div id="page-wrap3" style="padding: 0.5in 0in">
                            <div id="header" style="padding-left:20px;margin-bottom:20px;">
                                <div id="headerSec" class="row" style="margin-bottom:10px;margin-left:0px;margin-right:0px;">
                                    <div class="col-md-12" style="padding-left:0px;">
                                    <div class="companyAdd1" id="comapnyinformationdiv3" style="display:inline-block;float:left;width:40%;">
                                        <div>
                                            <div id="rhs-companyName3" style="font-family: Helvetica; font-size: 14px;">{{$Formstyle->cfs_company_name_value}}</div>
                                            <div>
                                                <div id="rhs-addrLine3" style="font-family: Helvetica; font-size: 10px;">{{$settings_company->company_address}}</div>
                                                <div><span id="rhs-state-zip" style="font-family: Helvetica; font-size: 10px;"></span></div>
                                            </div>
                                            <div style="font-family: Helvetica; font-size: 10px;">
                                                <div id="rhs-phoneNumber3" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_phone_value}}</div>
                                                <div id="rhs-email3" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_email_value}}</div>
                                                <div id="rhs-crn3" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_crn_value}}</div>
                                                <div id="rhs-website3" style="font-family: Helvetica; font-size: 10px;">{{$Formstyle->cfs_website_value}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="templateLogo" id="logocontainer3" style="display: inline-block; float: right;">
                                            <div class="logo" style="float: right; display:none;" id="lllll3">
                                                <img id="Templatelogo3" src="{{asset('images/lowstock.png')}}" style="max-height: 100px;">
                                            </div>
                                    </div>
                                    <div id="formTitle3" style="font-family: Helvetica;float:right;">
                                            <label id="formTitle-text3" class="formTitleText uppercase" style=" text-transform: uppercase;color: rgb(79, 144, 187); font-family: Helvetica; font-size: 14px;font-weight:bold;">INVOICE</label>
                                    </div>
                                    </div>
                                    
                                </div>
                                <!--head section end-->
                                <div class="prefContainer" style="font-size: 10px;">
                                        <div class="" >
                                            <div class="col-md-3"  style="padding-right:0px;padding-left:0px;">
                                            <div class="billToSection" id="borderline1" style="width:100%;border-top:1px solid rgb(79, 144, 187);">
                                                <div >
                                                    <div class="header" style="font-size: 10px;">
                                                    <div class="sectionHeader upperCase" id="billtocolored" style="padding-left:3px;font-family: Helvetica; font-size: 10px;">BILL TO</div>
                                                    </div>
                                                    <div class="addlines" style="font-family: Helvetica; font-size: 10px;">
                                                    <div style="padding-left:3px;">Smith Co.</div>
                                                    <div style="padding-left:3px;">123 Main Street</div>
                                                    <span style="padding-left:3px;">City,&nbsp;</span>
                                                    <span style="padding-left:3px;">CA 12345</span>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-3"  style="padding-left:0px;padding-right:0px;">
                                            <div class="" id="shiptodiv3" style="width:100%;border-top:1px solid rgb(79, 144, 187);">
                                                <table class="" style="width:100%;padding: 0px; border-collapse: collapse;" id="shiptotable">
                                                    <tbody >
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" id="shiptocolored" style="font-size: 10px; padding:3px;">SHIP TO</td>
                                                        
                                                    </tr>
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" style="font-size: 10px;padding-left:3px; ">John Smith</td>
                                                       
                                                    </tr>
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" style="font-size: 10px; padding-left:3px;">209812 Palm Drive</td>
                                                        
                                                    </tr>
                                                    <tr style="font-family: Helvetica;">
                                                        <td class="titleText" style="font-size: 10px;padding-left:3px;">City, CA 12345</td>
                                                       
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            </div>
                                            <div class="col-md-6"  style="padding-left:0px;padding-right:10px;">
                                                <div class="titleSection" id="borderline3" style="width:100%;border-top:1px solid rgb(79, 144, 187);" >
                                                    <table class="inlineBlock" id="tableinvoicedatedueterm2" style="text-align:center;min-height:75px; border-collapse: collapse;width:100%;">
                                                        <tbody >
                                                        <tr id="tabletrinvoicenumber" >
                                                            <td class="titleText" id="datetitle3" style="vertical-align:bottom;color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);padding:3px;font-size: 10px;padding-right:10px;">DATE</td>
                                                            
                                                            <td class="titleText" id="duedatetitle3" style="vertical-align:bottom;font-size: 10px;padding:3px;color: rgb(220, 233, 241); background-color: rgb(79, 144, 187);"><span id="duedatetitle">DUE DATE</span></td>
                                                            <td class="titleText" id="termtitle3" style="vertical-align:bottom;color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);font-size: 10px; padding:3px;"><span id="termtitle">TERMS</span></td>
                                                            
                                                        </tr>
                                                        <tr style="font-family: Helvetica;">
                                                            <td class="titleValue" id="datetitle3-2" style="vertical-align:top;color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);font-size: 10px;padding:3px;" ><span id="invoicenumberform2">02/06/2018</span></td>
                                                            
                                                            <td class="titleValue" id="duedatetitle3-2" style="vertical-align:top;font-size: 10px;padding:3px;color: rgb(220, 233, 241); background-color: rgb(79, 144, 187);"><span id="duedatecontent">02/06/2018</span></td>
                                                            <td class="titleValue" id="termtitle3-2" style="vertical-align:top;color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);font-size: 10px;padding:3px;"><span id="termcontent">Net 30</span></td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="col-md-12" style="margin-top:5px;padding-left:0px;padding-right:10px;">
                                                
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="col-md-12" style="padding-left:0px;padding-right:0px;margin-top:10px;">
                                                <div class="shippingAndCustom" id="shipdefailtdiv3" style="font-size: 10px;display:none;">
                                                    <div>
                                                        
                                                        <div class="shippingFields">
                                                            <div class="fieldTitle upperCase" >SHIP DATE</div>
                                                            <div class="fieldValue">01/03/2018</div>
                                                        </div>
                                                        <div class="shippingFields">
                                                            <div class="fieldTitle upperCase" >SHIP VIA</div>
                                                            <div class="fieldValue">FedEx</div>
                                                        </div>
                                                        <div class="shippingFields">
                                                            <div class="fieldTitle upperCase" >TRACKING NO.</div>
                                                            <div class="fieldValue">12345678</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        

                                        
                                    </div>

                            </div>
                            <!--heaeder end-->
                            <div id="content" class="" >
                                    <div id="overlayId" class="col-md-12" style="margin-top:20px;">
                                    <div class="detailSection" style="min-height:150px;">
                                        <div class="dgrid dgrid-03 dgrid-grid ui-widget" styl="padding:10px 10px;">
                                            <div>
                                                <style>
                                                    .table-sm td, .table-sm th{
                                                        padding:3px 10px!important;
                                                    }
                                                </style>
                                                    <table id="activityTableLhsTableHeader" style="width:100%;border:1px solid #ccc ;" class="dgrid-row-table table table-sm" role="presentation">
                                                        <thead >
                                                            <tr >
                                                                <th class="dgrid-cell hcoll-date" role="columnheader" rowspan="2" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">DATE</th>
                                                                <th class="dgrid-cell hcoll-prod" role="columnheader" rowspan="2" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">ACTIVITY</th>
                                                                <th class="dgrid-cell hcoll-desc" role="columnheader" rowspan="2" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">DESCRIPTION</th>
                                                                <th class="dgrid-cell hcoll-qty" role="columnheader" rowspan="2" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">QTY</th>
                                                                <th class="dgrid-cell hcoll-rate" role="columnheader" rowspan="2" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">RATE</th>
                                                                <th class="dgrid-cell hcoll-amount" role="columnheader" rowspan="2" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">AMOUNT</th>
                                                                <th class="dgrid-cell hcoll-sku" role="columnheader" rowspan="2" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px; color: rgb(79, 144, 187); background-color: rgb(220, 233, 241);">SKU</th>
                                                            </tr>
                                                            
                                                        </thead>
                                                        <tbody>
                                                                <tr>
                                                                    <td class="dgrid-cell coll-date" role="columnheader" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px;">01/07/2018</td>
                                                                    <td class="dgrid-cell coll-prod" role="columnheader" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px;">Item name</td>
                                                                    <td class="dgrid-cell coll-desc" role="columnheader" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px;">Description of the item</td>
                                                                    <td class="dgrid-cell coll-qty" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">2</td>
                                                                    <td class="dgrid-cell coll-rate" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                    <td class="dgrid-cell coll-amount" role="columnheader" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px;">450.00</td>
                                                                    <td class="dgrid-cell coll-sku" role="columnheader" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px;">PRD123</td>
                                                                </tr>
                                                                <tr>
                                                                        <td class="dgrid-cell coll-date" role="columnheader" style="width: 15.1515%; text-align: left; font-family: Helvetica; font-size: 10px;">01/07/2018</td>
                                                                        <td class="dgrid-cell coll-prod" role="columnheader" style="width: 20.202%; text-align: left; font-family: Helvetica; font-size: 10px;">Item name</td>
                                                                        <td class="dgrid-cell coll-desc" role="columnheader" style="width: 28.2828%; text-align: left; font-family: Helvetica; font-size: 10px;">Description of the item</td>
                                                                        <td class="dgrid-cell coll-qty" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">1</td>
                                                                        <td class="dgrid-cell coll-rate" role="columnheader" style="width: 10.101%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                        <td class="dgrid-cell  coll-amount" role="columnheader" style="width: 16.1616%; text-align: right; font-family: Helvetica; font-size: 10px;">225.00</td>
                                                                        <td class="dgrid-cell coll-sku" role="columnheader" style="width: 0%; text-align: left; display: none; font-family: Helvetica; font-size: 10px;">PRD123</td>
                                                                    </tr>
                                                        </tbody>
                                                    </table>
                                                
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <!--content end-->
                                <div>
                                        <div class="col-md-12">
                                                <div id="totalValue" style="margin-top:10px;margin-bottom:10px;border-top:1px dotted #bdbbbb"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="col-md-12">
                                                <div id="footer" class="">
                                                        <div id="overlayId" class=""></div>
                                                            <div>
                                                            <div class="subTotalSection">
                                                                <div class="subTotalCenter"></div>
                                                                            <div class="subTotalRight" style="width:100%;">
                                                                                <style>
                                                                                    #footerMessage3{
                                                                                        display: inline-block !important;
                                                                                    }
                                                                                </style>
                                                                                <div id="footerMessage3" style="font-size: 8px; white-space: pre-line;margin-left:20px;"></div>
                                                                                
                                                                                <table style="width:30%;margin-right:20px;font-size:10px;float:right;">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td id="SubTotalTitle3" style="text-align:left;color: rgb(79, 144, 187);">SUBTOTAL</td>
                                                                                            <td style="text-align:right">675.00</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td id="TotalTitle3" style="text-align:left;color: rgb(79, 144, 187);">TOTAL</td>
                                                                                            <td style="text-align:right">PHP675.00</td>
                                                                                        </tr>
                                                                                        <tr >
                                                                                            <td style="padding: 3px;"></td>
                                                                                            <td style="padding: 3px;"></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="text-align:left">BALANCE DUE</td>
                                                                                            <td style="text-align:right;font-size:12px">PHP675.00</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        
                                                    </div>
                                                <div style="clear: both;"></div>
                                                <div style="padding-top: 0.5in;">
                                                    <div id="footerText3" class="left-footer-text" style="font-size: 8px; text-align: center; white-space: pre-line;margin-right:20px;margin-left:20px;margin-bottom:0.5in"></div>
                                                </div>
                                                </div>
                                        </div>
                                    </div>  
                        </div>
                    </div>
                </div>
                <div id="formemailtemplatepage" style="background-color:white;display:none;font-family: Helvetica; padding: 0px; font-size: 8px; min-height: 760px;min-width:628px;">
                        <table class="" style="border:1px solid #dadbdd;margin-bottom:0px;width:100%;">
                            <tbody>
                                <tr class="subject" >
                                    <td class="label" style="width:80px;padding-top:10px;padding-left:5px;"><p class="para" style="margin-bottom:0px;">Subject</p></td>
                                    <td class="value" style="padding-top:10px;"><p class="para" style="margin-bottom:0px;color:black;">Invoice 12345 from ECC</p></td>
                                </tr>
                                <tr class="from">
                                    <td class="label" style="padding-left:5px;"><p class="para" style="">From</p></td>
                                    <td class="value" style=""><p class="para" style="color:black;">quickbooks@notification.intuit.com</p></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="body-table-rfc">
                            <div id="mainContainer" class="rfc-container rfc-preview-flow" style="padding-top: 0.5in; padding-bottom: 0.25in;">
                                <div style="margin:10px 20px;">
                                    <div id="EmailHeaderCompanyName" style="background-color:#f4f5f8;color:#4F90BB;border-top:3px solid #4F90BB;padding:26px;text-align:center;">
                                        <h4>ECC</h4>
                                    </div>
                                    <div id="emailContainer" class="emailContainer" style="margin-top:20px;padding-left:20px;">
                                        <p id="greetingsection" style="color:black;">Dear [FullName]</p><pre style="color:black;font-size:16px;font-family:Helvetica;" id="messagetoCustomer">Here's your invoice! We appreciate your prompt payment.<br><br>Thanks for your business!<br>ECC</pre>
                                    </div>
                                    <div id="titleContainer" class="titleContainer" style="text-align:center;margin-bottom:10px;font-size:13px;color:#6b6c72;">INVOICE 12345</div>
                                    <div id="emailbelowMessage" style="background-color: rgb(220, 233, 241);padding:26px;text-align:center;">
                                        <h5 style="font-size:16px;font-weight:bold;">DUE 02/06/2018</h5>
                                        <h1 style="padding:10px 0px 35px 0px ;">PHP675.00</h1>
                                        <a class="btn btn-dark" href="#">Print or save</a>
                                    </div>
                                    <br><br>
                                    <div id="titleContainer" class="titleContainer" style="text-align:center;margin-bottom:10px;font-size:13px;color:#6b6c72;">ECC</div> 
                                    <div id="titleContainer" class="titleContainer" style="text-align:center;margin-bottom:10px;font-size:13px;color:#6b6c72;">Grande Catalunan Davao City, 8000</div> 
                                    <div id="titleContainer" class="titleContainer" style="text-align:center;margin-bottom:10px;font-size:13px;color:#6b6c72;">+63 9282150443 &nbsp; ceciliodeticio13@gmail.com</div> 
                                </div>
                            </div>
                        </div>
                        
                    </div>
            </div>
          
        </div>
        <div class="modal-footer">
          <a  class="btn btn-default" href="customformstyles">Cancel</a>
          <button type="button" class="btn btn-success" onclick="SaveFormTemplate()">Save</button>
        <script>
            function SaveFormTemplate(){
                var templatesettings = {};
                    templatesettings['TemplateTitleInput'] = TemplateTitleInput.value;
                    templatesettings['TemplateID'] = TemplateID.value;
                    templatesettings['pickeddesign'] = pickeddesign;
                    templatesettings['logoname'] = logoname;
                    templatesettings['logo_size'] = logo_size;
                    templatesettings['logo_align'] = logo_align;
                    templatesettings['logoshow'] = logoshow;
                    templatesettings['pickedcolor'] = pickedcolor;
                    templatesettings['template_font_family'] = template_font_family;
                    templatesettings['template_font_size'] = template_font_size;
                    templatesettings['template_margin'] = template_margin;
                    
                    templatesettings['companyname_show'] = companyname_show;
                    templatesettings['compantname'] = compantname;
                    templatesettings['showphone'] = showphone;
                    templatesettings['phonevalue'] = phonevalue;
                    templatesettings['showemail'] = showemail;
                    templatesettings['comemail'] = comemail;
                    templatesettings['showrn'] = showrn;
                    templatesettings['crnvalue'] = crnvalue;
                    templatesettings['showaddress'] = showaddress;
                    templatesettings['showebsite'] = showebsite;
                    templatesettings['webistecom'] = webistecom;
                    templatesettings['showformname'] = showformname;
                    templatesettings['formtitletemp'] = formtitletemp;
                    templatesettings['showformnumber'] = showformnumber;
                    templatesettings['showshipping'] = showshipping;
                    templatesettings['showterms'] = showterms;
                    templatesettings['showduedate'] = showduedate;

                    templatesettings['showtabledate'] = showtabledate;
                    templatesettings['showtableprod'] = showtableprod;
                    templatesettings['showtabledesc'] = showtabledesc;
                    templatesettings['showtableqty'] = showtableqty;
                    templatesettings['showtablerate'] = showtablerate;
                    templatesettings['showtableamount'] = showtableamount;

                    templatesettings['footmessage'] = footmessage;
                    templatesettings['footmessagesize'] = footmessagesize;
                    templatesettings['footertext'] = footertext;
                    templatesettings['footertextsize'] = footertextsize;
                    templatesettings['footertextalign'] = footertextalign;

                    templatesettings['emailsubject']=document.getElementById('emailSubject').value;
                    templatesettings['emailusegreeting']=usegreetingcheck;
                    templatesettings['emailgreetingword']=document.getElementById('greetingwor').value;
                    templatesettings['emailgreetingpronoun']=document.getElementById('greetingpronouns').value;
                    templatesettings['emailmessagecustomer']=document.getElementById('messagecustomertextarea').value;
                    $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('uploadformstyle') }}',                
                    data: {templatesettings:templatesettings,_token: '{{csrf_token()}}'},
                    success: function(data) {
                        swal({title: "Done!", text: data, type: 
                        "success"}).then(function(){ 
                        window.location.replace("/customformstyles");
                        });
                    } ,
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.responseText);
                        alert(thrownError);
                    }

                    })
            }
        </script>
        </div>
      </div>
    </div>
</div>


      @endsection