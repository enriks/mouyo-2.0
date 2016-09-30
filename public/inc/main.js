function init(){
	
    
    function home(){
        
        //$('#divIngrediente').hide();
        //$('#divJugos').hide();
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
        
        //$('#divSlider').hide();
        //$('#divIngrediente').hide();
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
    
   
 function tips(){
        
        //$('#divSlider').hide();
        //$('#divIngrediente').hide();
        $('#divFaq').hide();
        $('#divAcerca').hide();

		$.ajax({
		   url: 'inc/tips_jugos.php',
		   success: function(data)
		   {
		   		$('#divTips').show('slow').html(data); 
		   		
		   }
		});
 }
    
function beneficios(){
        
        //$('#divSlider').hide();
        //$('#divIngrediente').hide();
        $('#divFaq').hide();
        $('#divAcerca').hide();

		$.ajax({
		   url: 'inc/beneficios.php',
		   success: function(data)
		   {
		   		$('#divBeneficio').show('slow').html(data); 
		   		
		   }
		});
 }
    
/*function cotizaciones(){
    
    $('#divCotizacion').show();
    
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
    
    tips();
    
    beneficios();
    
    //cotizaciones();
    
    
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
            $('#divBeneficio').hide();
            $('#divTips').hide();
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
            $('#divBeneficio').hide();
            $('#divTips').hide();
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
            $('#divBeneficio').hide();
            $('#divTips').hide();
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
            $('#divBeneficio').hide();
            $('#divTips').hide();
			$('#divFaq').show('slow', function(){});
		});
    
    
}


$( init );


