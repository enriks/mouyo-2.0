function init(){
	
	var selected_jugo_id = null;
	function load_jugos()
	{
		$('#divFaq').hide();
		$('#divAcerca').hide();
		$('#divIngredientes').hide();
		$('#divSlider').hide();
		$.ajax({
		   url: 'ws/select_jugos.php',
		   success: function(data)
		   {
		   		$('#divJugos').show('slow').html(data);
				$('#divJugos').on('click', '.primary.hollow', function(evt) {
				  select_details($(this).data("id"));
				  evt.preventDefault();
				});
		   }
		});
	}
	
	function load_ingredientes()
	{
		$('#divFaq').hide();
		$('#divAcerca').hide();
		$('#divJugos').hide();
		$('#divSlider').hide();
		$.ajax({
		   url: 'ws/select_ingredientes.php',
		   success: function(data)
		   {
		   		$('#divIngredientes').show('slow').html(data);
			   	$('#divIngredientes').on('click', '.primary.hollow', function(evt) {
				  select_details($(this).data("id"));
				  evt.preventDefault();
				});
		   }
		});
	}
	
	$('#divAcerca').hide();
	$('#divFaq').hide();
	$('#divJugos').hide();
	$('#divIngredientes').hide();
	$('#divSlider').show();
	
	
	$('#lnkHome').on('click', function()
		{
			$('#divFaq').hide();
			$('#divJugos').hide();
			$('#divIngredientes').hide();
			$('#divAcerca').hide();
			$('#divSlider').show('slow');
		
		});

	$('#lnkAcerca').on('click', function()
		{
			$('#divFaq').hide();
			$('#divJugos').hide();
			$('#divIngredientes').hide();
			$('#divSlider').hide();
			$('#divAcerca').toggle('slow', function(){});
		});
	
	$('#lnkFaq').on('click', function()
		{
			$('#divAcerca').hide();
			$('#divJugos').hide();
			$('#divIngredientes').hide();
			$('#divSlider').hide();
			$('#divFaq').toggle('slow', function(){});
		});
	
	
	$('#lnkJugos').on('click', function(){load_jugos();});
	
	$('#lnkIngredientes').on('click', function(){load_ingredientes();});
	
}


$( init );