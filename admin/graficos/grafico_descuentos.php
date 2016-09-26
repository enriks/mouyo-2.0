<?php
ob_start();
require("../../lib/database.php");
require("../lib/verificador.php");
require("../lib/page.php");
Page::header();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<div class='container'>
    <hr>
    <div class='row'>
            <div class='col-lg-12'>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Página Principal</a>
                    </li>
                    <li class='active'>Gráfico Descuentos</li>
                    <li><a type='button' href='../descuentos/index.php' class='btn btn-danger'>Volver</a></li>
                </ol>
            </div>
        </div>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Descuentos en la variedad de Jugos Mouyo'
        },
       
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
         series: [{
            name: 'Cantidad de Descuento',
            colorByPoint: true,
            data: [    
            <?php $sql='select * from descuentos';
            $data2=Database::getRows($sql,null);
            foreach($data2 as $row){ ?>    
            {  
                name: '<?php echo $row['nombre']; ?>',
                y: <?php echo $row['descuento']; ?>
            },
            <?php 
            } ?>
                   /*, {
                name: 'Chrome',
                y: 24.03,
                sliced: true,
                selected: true
            }, {
                name: 'Firefox',
                y: 10.38
            }, {
                name: 'Safari',
                y: 4.77
            }, {
                name: 'Pero',
                y: 50   
            }, {
                name: 'Proprietary or Undetectable',
                y: 0.2
            }*/]
        }]
    });
});
		</script>
	</head>
	<body>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="height: 400px"></div>
	</body>
</html>
