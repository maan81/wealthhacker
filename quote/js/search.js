$('#search_btn').click(function(e){

	e.preventDefault();

	var v = $('#search_input').val();

	if(!v.length) return false;

	window.location = baseurl+'/search/'+v;
})

$('#search_input').keypress(function(e) {
    if(e.which == 13) {
    	$('#search_btn').trigger('click');
    }
});


$('.search_err').click(function(){
	$(this).fadeOut(250,function(){
		$(this).remove()
	});
})