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
		<title>Gráfico de Tamaños</title>

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
${demo.css}
		</style>
        	</head>            
	<body>
        <hr>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Tamaños de Bebida con su precio'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'red'
                    }
                }
            }
        },
        series: [{
            name: 'Precio del Tamaño',
            colorByPoint: true,
            data: [    
            <?php $sql='select * from tamanio';
            $data2=Database::getRows($sql,null);
            foreach($data2 as $row){ ?>    
            {  
                name: '<?php echo $row['tamanio']; ?>',
                y: <?php echo $row['precio']; ?>
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

<script src="https://code.highcharts.com/highcharts.js"></script>   
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

	</body>
</html>
    