<script src="{{asset('js/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
<div class="se-pre-con"></div>
<style>
/* Paste this css to your style sheet file or under head tag */
/* This only works with JavaScript, 
if it's not present, don't show loader */
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
    text-align:center;
    
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url("{{asset('images/loader-128x/Preloader_1.gif')}}") center no-repeat #fff;
}
</style>

<script src="{{asset('js/jquery_loading_screen.js')}}"></script>
<script src="{{asset('js/modernize.js')}}"></script>
{{-- <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script> --}}
<script>
//paste this code under the head tag or in a separate js file.
// Wait for window load
$(window).load(function() {
    // Animate loader off screen
    var delayInMilliseconds = 2000; //1 second

    setTimeout(function() {
        $(".se-pre-con").fadeOut("slow");
        @if($None=="1")
            Swal.fire({
            type: 'success',
            title: 'Success',
            text: 'Successfully Activated Admin Account',
            }).then((result) => {
                location.href="login";
            })
        @elseif($None=="0")
            Swal.fire({
            type: 'error',
            title: 'Error',
            text: 'Failed to Activate Admin Account, Admin Account Already Exist',
            }).then((result) => {
                location.href="login";
            })
        @elseif($None=="2")
            Swal.fire({
            type: 'error',
            title: 'Error',
            text: 'Account Not Found',
            }).then((result) => {
                location.href="login";
            })
        @endif
        
    }, delayInMilliseconds);
    
});
</script>