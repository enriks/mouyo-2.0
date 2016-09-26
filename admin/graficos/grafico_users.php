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
		<title>Bebidas Exoticas Mouyo</title>

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<div class='container'>
    <hr>
    <div class='row'>
            <div class='col-lg-12'>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Página Principal</a>
                    </li>
                    <li class='active'>Gráfico Usuarios</li>
                    <li><a type='button' href='../users/index.php' class='btn btn-danger'>Volver</a></li>
                </ol>
            </div>
        </div>
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    // Create the chart
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Gráfico de Usuarios y su Sesión.'
        },
        subtitle: {
            text: 'Sesion Activa = 1, Sesion Cerrada =0.</a>.'
        },
        xAxis: {
            title: {
            	text: 'Usuarios'
            }
        },
        yAxis: {
            title: {
                text: 'Sesion Activa = 1, Sesion Cerrada =0.'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b><br/>'

        },

        series: [{
            name: 'Sesion del Usuario',
            colorByPoint: true,
            data: [    
            <?php $sql='select * from usuario';
            $data2=Database::getRows($sql,null);
            foreach($data2 as $row){ ?>    
            {  
                name: '<?php echo $row['alias']; ?>',
                y: <?php echo $row['sesion']; ?>
            },
            <?php 
            } ?>
                   
                   ]
        }]
    });
});
		</script>
	</head>
	<body>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	</body>
</html>
