<?php 
if(isset($_SESSION['nombre_apellido_usuario']))
{
    $session=true;
    if( $session ){
?>	     
    <div class="menu-emerald-container">
			<ul id="slide-out" class="side-nav emerald-side-nav main-theme-color">
				<li class='clearfix menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-9 current_page_item'>
					<a href="index.php" class='waves-effect waves-light' title="" rel="" >INICIO</a>
				</li>
				<li class='no-padding clearfix menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children'>
					<ul class="collapsible collapsible-accordion">
						<li>
							<a href="jugos.php" class='side-header waves-effect left waves-light' title="" rel="">JUGOS</a>	<div class="collapsible-header right"><i class=""></i></div>
						</li>
					</ul>
				</li>
				<li class='no-padding clearfix menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children'>
					<ul class="collapsible collapsible-accordion">
					<li><a href="ingredientes.php" class='side-header waves-effect left waves-light' title="" rel="">INGREDIENTES</a>
                        <!--div class="collapsible-header right"><i class="mdi-navigation-expand-more"></i></div>
						<div class="collapsible-body clearfix">
                            <ul><li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="#" class='waves-effect waves-light' title="" rel="">FOOD</a></li>
                                <li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="#" class='waves-effect waves-light' title="" rel="">DRINK</a></li>
                                <li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="#" class='waves-effect waves-light' title="" rel="">WEDDING</a></li>
                                <li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="#" class='waves-effect waves-light' title="" rel="">OUTDOOR</a></li>
                            </ul>
						</div-->
					</li>
					</ul>
				</li>
				<li class='no-padding clearfix menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children'>
					<ul class="collapsible collapsible-accordion">
						<li><a href="#" class='side-header waves-effect left waves-light' title="" rel="">SALUD</a>
                            <div class="collapsible-header right"><i class="material-icons">toc</i></div>
							<div class="collapsible-body clearfix">
								<ul>
									<li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="beneficios_jugos.php" class='waves-effect waves-light' title="" rel="">BENEFICIO DE LOS JUGOS</a></li>
									<li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="tips_jugos.php" class='waves-effect waves-light' title="" rel="">CONSEJOS Y TIPS</a>
									</li>
									<!--li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="#" class='waves-effect waves-light' title="" rel="">PEACEFUL PLACES</a></li-->
								</ul>
							</div>
						</li>
					</ul>
				</li>
				<li class='clearfix menu-item menu-item-type-taxonomy menu-item-object-category'><a href="#" class='waves-effect waves-light' id="lnkFaq1">PREGUNTAS FRECUENTES</a></li>
                <li class='clearfix menu-item menu-item-type-post_type menu-item-object-page'>
					<a href="#" class='waves-effect waves-light' title="" rel="" id="lnkAcerca1">ACERCA DE MOUYO</a>
				</li>
                
                <ul class="collapsible collapsible-accordion">
						<li class='clearfix buy menu-item menu-item-type-custom menu-item-object-custom'><a href="#" class='side-header waves-effect left waves-light' title="" rel=""><img class="circle" width="50" height="50" src="data:image/*;base64,<?php print $_SESSION['img'] ?>"/><?php echo $_SESSION['nombre_apellido_usuario'] ?></a>
                            <div class="collapsible-header right"><i class="material-icons">toc</i></div>
							<div class="collapsible-body clearfix">
								<ul>
									<li><a href='usuarios.php?id=<?php echo 
					$_SESSION['id_usuario'] ?>'><i class='material-icons'>mode_edit</i>Editar perfil</a></li>
								<li><a href='cotizacion.php'><i class='material-icons'>assignment</i>Cotizacion</a></li>
								<li><a href='main/logout.php'><i class='material-icons'>close</i>Salir</a></li>
								</ul>
							</div>
						</li>
					</ul>
                
				<!--li class='clearfix buy menu-item menu-item-type-custom menu-item-object-custom'>
				</li-->
                
			</ul>
		</div>    

<?php	}     
}
else
{ ?>

    <div class="menu-emerald-container">
			<ul id="slide-out" class="side-nav emerald-side-nav main-theme-color">
				<li class='clearfix menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-9 current_page_item'>
					<a href="index.php" class='waves-effect waves-light' title="" rel="" >INICIO</a>
				</li>
				<li class='no-padding clearfix menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children'>
					<ul class="collapsible collapsible-accordion">
						<li>
							<a href="jugos.php" class='side-header waves-effect left waves-light' title="" rel="">JUGOS</a>	<div class="collapsible-header right"><i class=""></i></div>
						</li>
					</ul>
				</li>
				<li class='no-padding clearfix menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children'>
					<ul class="collapsible collapsible-accordion">
					<li><a href="ingredientes.php" class='side-header waves-effect left waves-light' title="" rel="">INGREDIENTES</a>
                        <!--div class="collapsible-header right"><i class="mdi-navigation-expand-more"></i></div>
						<div class="collapsible-body clearfix">
                            <ul><li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="#" class='waves-effect waves-light' title="" rel="">FOOD</a></li>
                                <li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="#" class='waves-effect waves-light' title="" rel="">DRINK</a></li>
                                <li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="#" class='waves-effect waves-light' title="" rel="">WEDDING</a></li>
                                <li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="#" class='waves-effect waves-light' title="" rel="">OUTDOOR</a></li>
                            </ul>
						</div-->
					</li>
					</ul>
				</li>
				<li class='no-padding clearfix menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children'>
					<ul class="collapsible collapsible-accordion">
						<li><a href="#" class='side-header waves-effect left waves-light' title="" rel="">SALUD</a><div class="collapsible-header right"><i class="material-icons">toc</i></div>
							<div class="collapsible-body clearfix">
								<ul>
									<li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="beneficios_jugos.php" class='waves-effect waves-light' title="" rel="">BENEFICIO DE LOS JUGOS</a></li>
									<li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="tips_jugos.php" class='waves-effect waves-light' title="" rel="">CONSEJOS Y TIPS</a>
									</li>
									<!--li class='clearfix menu-item menu-item-type-custom menu-item-object-custom'><a href="#" class='waves-effect waves-light' title="" rel="">PEACEFUL PLACES</a></li-->
								</ul>
							</div>
						</li>
					</ul>
				</li>
				<li class='clearfix menu-item menu-item-type-taxonomy menu-item-object-category'><a href="#" class='waves-effect waves-light' id="lnkFaq1">PREGUNTAS FRECUENTES</a></li>
                <li class='clearfix menu-item menu-item-type-post_type menu-item-object-page'>
					<a href="#" class='waves-effect waves-light' title="" rel="" id="lnkAcerca1">ACERCA DE MOUYO</a>
				</li>
				<li class='clearfix buy menu-item menu-item-type-custom menu-item-object-custom'>
					<a href="login.php" class='waves-effect waves-light' title="" rel=""><i class="material-icons">perm_identity</i> INICIA SESION </a>
				</li>
			</ul>
		</div>

                
<?php } 
?>