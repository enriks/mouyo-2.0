<?php
require_once("../../lib/database.php");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Gráfico del Tipo de Jugos </title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
#container {
	height: 400px; 
	min-width: 310px; 
	max-width: 800px;
	margin: 0 auto;
}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column',
            margin: 95,
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'Grafico'
        },
        subtitle: {
            text: 'del Tipo de Jugos'
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        xAxis: {
            categories: [
			<?php
$sql=mysql_query("select * from tipo_jugo order by id_tipojugo");
while($res=mysql_fetch_array($sql)){			
?>					
			
			['<?php echo $res['nombre']; ?>'],
<?php
}
?>
			]
        },
        yAxis: {
            title: {
                text: null
            }
        },
        series: [{
            name: 'Tipos',
            data: [
			
			<?php
$sql=mysql_query("select * from tipo_jugo order by id_tipojugo");
while($res=mysql_fetch_array($sql)){			
?>			
			
			[<?php echo $res['nombre'] ?>],
			
<?php
}
?>
			]
        }]
    });
});
</script>
	</head>
	<body>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

	</body>
</html>