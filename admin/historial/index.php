<?php
ob_start();
require("../../lib/database.php");
require("../lib/verificador.php");
require("../lib/page.php");
Page::header();


    $sql = "SELECT admin.alias nombre_admin, admin.foto foto, historial.accion,historial.fecha FROM historial,admin WHERE historial.id_admin=admin.id_admin order by historial.fecha";
	$params = null;

$data = Database::getRows($sql, $params);
if($data != null)
{
    $tabla="<div class='container'>
    <div class='row'>
            <div class='col-md-12'>
                <h1 class='page-header'>Historial
                    <small>Mouyo</small>
                </h1>
                <ol class='breadcrumb'>
                    <li><a href='../main/index.php'>Home</a>
                    </li>
                    <li class='active'>Historial</li>
                </ol>
                <ul class='timeline'>";
    
    foreach($data as $row)
		{
			$tabla.=
                
                            "<li class='timeline-item'>
							<div class='timeline-badge'> <img class='img-responsive img-rounded' src='data:image/*;base64,$row[foto]' alt=''></div>
							<div class='timeline-panel'>
								<div class='timeline-heading'>
									<h4 class='timeline-title'>$row[accion]</h4>
									<p><small class='text-muted'><i class='glyphicon glyphicon-time'>$row[fecha]</i></small></p>
								</div>
								<div class='timeline-body'>
									<p>Por $row[nombre_admin]</p>
								</div>
							</div>
						</li>
                
    <hr>";
		}
    $tabla.="</ul>
				</div>
			</div>";
		
		print $tabla;
}
page::footer();
?>
<!DOCTYPE html>
<html lang="en">

<head>
<link href="../../css/estilo_timeline.css" rel="stylesheet">
       <link rel="stylesheet" href="http://bootsnipp.com/dist/bootsnipp.min.css?ver=7d23ff901039aef6293954d33d23c066">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
</head>
    <body>
    <script src="../../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../js/bootstrap.min.js"></script>
    </body>
</html>