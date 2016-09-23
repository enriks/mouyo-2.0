<?php require("../../lib/database.php");
require("../lib/page.php");
page::header();
?>
    
<div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Sesion activa
                    <small>Active sesion</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="login.php">Iniciar sesion</a>
                    </li>
                    <li class="active">Sesion activa</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">

            <div class="col-lg-12">
                <div class="jumbotron">
                    <h1><span class="error-404">Tienes una sesion activa.</span>
                    </h1>
                    <p>Hemos descubierto que tienes una sesion activa</p>
                </div>
            </div>

        </div>
        <?php page::footer();?>