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
        <div class='container'>
    <hr>
    <div class='row'>
            <div class='col-lg-12'>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Página Principal</a>
                    </li>
                    <li class='active'>Gráfico Tamaño</li>
                    <li><a type='button' href='../tamanio/index.php' class='btn btn-danger'>Volver</a></li>
                </ol>
            </div>
        </div>
        <div class='row'>
        <div class='col-md-8'>
        <style type="text/css">
${demo.css}
        </style>
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
        
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'red'
                    }
                }
            }
        },
        series: [{
            name: 'Precio del Tamaño (USD)',
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
    </head>            
    <body>

<script src="https://code.highcharts.com/highcharts.js"></script>   
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

    </body>
</html>
    