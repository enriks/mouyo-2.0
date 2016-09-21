function init(){
	
	
	$('#divAcerca').hide();
	$('#divFaq').hide();
	$('#divSlider').show();
	
	
	$('#lnkHome').on('click', function()
		{
			$('#divFaq').hide();
			$('#divAcerca').hide();
			$('#divSlider').show('slow');
		
		});

	$('#lnkAcerca').on('click', function()
		{
			$('#divFaq').hide();
			$('#divSlider').hide();
			$('#divAcerca').toggle('slow', function(){});
		});
	
	$('#lnkFaq').on('click', function()
		{
			$('#divAcerca').hide();
			$('#divSlider').hide();
			$('#divFaq').toggle('slow', function(){});
		});
}


$( init );
