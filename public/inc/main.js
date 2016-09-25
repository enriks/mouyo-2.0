function init(){
	
    
    function home(){
        
        $('#divIngrediente').hide();
        $('#divJugos').hide();
        $('#divFaq').hide();
        $('#divAcerca').hide();

		$.ajax({
		   url: 'inc/slider.php',
		   success: function(data)
		   {
		   		$('#divSlider').show('slow').html(data); 
		   		
		   }
		});
        
        
    }
    
 function jugos(){
        
        $('#divSlider').hide();
        $('#divIngrediente').hide();
        $('#divFaq').hide();
        $('#divAcerca').hide();

		$.ajax({
		   url: 'inc/jugos.php',
		   success: function(data)
		   {
		   		$('#divJugos').show('slow').html(data); 
		   		
		   }
		});
 }
    

    
	
/*	$('#lnkHome').on('click', function()
		{
            $('#divIngrediente').hide();
            $('#divJugo').hide();
			$('#divFaq').hide();
			$('#divAcerca').hide();
			$('#divSlider').show('slow');
		
		}); */
    
        $('#divFaq').hide();
        $('#divAcerca').hide();
        //$('#divSlider').show();
    
    jugos();
    
    home();
    
    
	$('#lnkAcerca').on('click', function()
		{
			$('#divFaq').hide();
            $('#divIngrediente').hide();
			$('#divSlider').hide();
            $('#divJugos').hide();
            $('#divRegister').hide();
            $('#divLogin').hide();
            $('#divUsuario').hide();
            $('#divCotizacion').hide();
            $('#divJugo').hide();
			$('#divAcerca').show('slow', function(){});
		});
	
	$('#lnkFaq').on('click', function()
		{
            $('#divIngrediente').hide();
			$('#divAcerca').hide();
            $('#divJugos').hide();
			$('#divSlider').hide();
            $('#divRegister').hide();
            $('#divLogin').hide();
            $('#divUsuario').hide();
            $('#divCotizacion').hide();
            $('#divJugo').hide();
			$('#divFaq').show('slow', function(){});
		});
    
    $('#lnkAcerca1').on('click', function()
		{
			$('#divFaq').hide();
            $('#divIngrediente').hide();
			$('#divSlider').hide();
            $('#divJugos').hide();
            $('#divRegister').hide();
            $('#divLogin').hide();
            $('#divUsuario').hide();
            $('#divCotizacion').hide();
            $('#divJugo').hide();
			$('#divAcerca').show('slow', function(){});
		});
	
	$('#lnkFaq1').on('click', function()
		{
            $('#divIngrediente').hide();
			$('#divAcerca').hide();
            $('#divJugos').hide();
			$('#divSlider').hide();
            $('#divRegister').hide();
            $('#divLogin').hide();
            $('#divUsuario').hide();
            $('#divCotizacion').hide();
            $('#divJugo').hide();
			$('#divFaq').show('slow', function(){});
		});
    
    
}


$( init );


