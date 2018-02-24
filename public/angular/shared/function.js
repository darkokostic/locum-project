$(document).ready(function() {
    $('.collapse').on('shown.bs.collapse', function () {
	  	$(".locum-nav-2").css("margin-top", "-120px");
	})
    $('.collapse').on('hidden.bs.collapse', function () {
        $(".locum-nav-2").css("margin-top", "0px");
    })
});


