<html>
  <head>
    <body>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart); 
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Jugos tamaño', 'Grafico Pastel'],
                    <?php $sql='select * from tamanio';
                    $data2=Database::getRows($sql,null);
                    foreach($data2 as $row)
                    { ?>    
                    ['<?php echo $row['tamanio']; ?> $ <?php echo $row['precio']; ?>',   <?php echo $row['precio'];  ?>],
                    <?php 
                    } ?>
                    /*['Eat',      2],
                    ['Commute',  2],
                    ['Watch TV', 2],
                    ['Sleep',    7]*/
                    ]);
          
                    var options = {
                    title: 'JUGOS TAMAÑIO',
                    is3D: true,
                    };

                var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));  
                chart.draw(data, options);
            }
        </script>
      </body>
</html>