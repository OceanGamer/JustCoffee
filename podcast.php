<?php 
	//configuracion de mysql
  include("config/bd.php");
  error_reporting(0);

    $sentenciaSQL= $conexion->prepare("SELECT * FROM podcasts");
    $sentenciaSQL->execute();
    $Listapodcast=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
	function getRealIP() {

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2994921062849849"
     crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="icon" type="image/png" href="images/logo.png">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Allerta+Stencil&family=Stardos+Stencil&display=swap" rel="stylesheet">
	<title>JustCoffee-Podcasts</title>
</head>
<body>
<header>
	<nav id="header-nav" class="navbar navbar-default toppage">
		<div class="container toppage">
			<div class="navbar-header">
				<div>
					<a href="index.html" class="pull-left ">
						<img src="images/logo.png" class="logo">
					</a>
					<div class="navbar-brand">
						<a href="index.html"><h1 class="titletext1">JUST COFFEE</h1></a>
					</div>
				</div>
			</div>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsable-nav" arial expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
			</button>
			<div id="collapsable-nav" class="collapse navbar-collapse">
					<ul id="nav-list" class="nav navbar-nav navbar-right">
						<li>
							<a href="index.html" class="nav-item nav-link active">
							<br class="hidden-xs">Inicio</a>
						</li>
						<li>
							<a href="podcast.php" class="nav-item nav-link active">
							<br class="hidden-xs">Podcasts</a>
						</li>
						<li>
							<a href="about.html" class="nav-item nav-link active">
							<br class="hidden-xs">Acerca de Nosotros</a>
						</li>
						<li>
							<a href="contact.html" class="nav-item nav-link active">
							<br class="hidden-xs">Contactanos</a>
						</li>
					</ul>
			</div>
		</div>
	</nav>
</header>
<?php 
$enlace_actual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if ($enlace_actual == "http://localhost/JustCoffee/podcast.php") {?>
<div id="main content" class="container">
	<div class="">
		<div class="counterbox5">
			<h2><span>PODCASTS</span>| ULTIMAS PUBLICACIONES</h2>
		</div>
		<hr>
		<div>
		<?php foreach($Listapodcast as $podcast) {?>
			<div class="col-md-3 col-sm-6">
				<form method="">
                    <button type="summit" value="" class="buttonbox1">
					<input type="hidden" name="watch?" value="-<?php echo $podcast["id"];?>">
					<div class="">
						<img class="podicon3" src="images/podlogos/<?php echo $podcast["imagen"];?>" alt="podlogo">
					</div>
					<div class="">
						<span><?php echo $podcast["nombre"];?></span><br>
						<span>Duracion: <?php echo $podcast["duracion"];?></span><br>
						<a href="<?php echo $podcast["linkanchor"];?>"><img src="images/social/anchor.png" width="30px" height="30px"></a>
						<a href="<?php echo $podcast["linkspotify"];?>"><img src="images/social/spotify.webp" width="30px" height="30px"></a>
						<a href="<?php echo $podcast["linkyoutube"];?>"><img src="images/social/youtube.webp" width="30px" height="30px"></a>
					</div>
					</button>
                </form>
			</div>
			<?php } ?>
		</div>
	</div>
	<img src="images/audio.gif" class="hr">
	<div><script async="async" data-cfasync="false" src="//pl17845569.profitablegatetocontent.com/ee85fa437eba26079fdb44092d58a9b5/invoke.js"></script>
	<div id="container-ee85fa437eba26079fdb44092d58a9b5"></div></div>
</div>
<?php } 
else{ ?>
<?php
$subid = explode("-", $enlace_actual);
$subidid = $subid[1];
$sentenciaSQL= $conexion->prepare("SELECT * FROM podcasts WHERE id=:id");
$sentenciaSQL->bindParam(":id",$subidid);
$sentenciaSQL->execute();
$podcastverify=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
$verifyid=$podcastverify["id"];

if($verifyid > 0){




$ip= $_SERVER['REMOTE_ADDR'];
$subid = explode("-", $enlace_actual);
$subidid = $subid[1];
$sentenciaSQL= $conexion->prepare("SELECT * FROM podcasts WHERE id=:id");
$sentenciaSQL->bindParam(":id",$subidid);
$sentenciaSQL->execute();
$podcast2=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
$sentenciaSQL= $conexion->prepare("SELECT * FROM likes WHERE id=:id");
$sentenciaSQL->bindParam(":id",$subidid);
$sentenciaSQL->execute();
$podcastlike=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
$sentenciaSQL= $conexion->prepare("SELECT * FROM ips where ip=:ip and id=:id");
$sentenciaSQL->bindParam(":ip",$ip);
$sentenciaSQL->bindParam(":id",$subidid);
$sentenciaSQL->execute();
$podcastip=$sentenciaSQL->fetch(PDO::FETCH_LAZY);


$playid=$podcast2["id"];
$playnombre=$podcast2["nombre"];
$playdescripcion=$podcast2["descripcion"];
$playduracion=$podcast2["duracion"];
$playanchor=$podcast2["linkanchor"];
$playspotify=$podcast2["linkspotify"];
$playyoutube=$podcast2["linkyoutube"];
$playembed=$podcast2["embed"];
$playlikes=$podcastlike["like_count"];
$playip=$podcastip["ip"];
?>
<?php
$sentenciaSQL= $conexion->prepare("SELECT * FROM comentarios WHERE id=:id");
$sentenciaSQL->bindParam(":id",$subidid);
$sentenciaSQL->execute();
$Listacomentarios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<div id="main content">
	<div class="">
		<div class="col-md-9"> 
			<div class="counterbox4">
				<iframe class="podicon" src="<?php echo $playembed?>" height="180px" width="100%" frameborder="0" scrolling="no"></iframe>
				<span class="podp2"><?php echo $playnombre?></span>
				<div class="pull-right">
				<?php 
				$ip= $_SERVER['REMOTE_ADDR'];
				if ($playip == $ip) {?>
				<form method="POST" encType="multipart/form-data">
				<button type="summit" class="buttonpod2" name="accion" value="unlike"><img src="images/heartred.png" width="20px" height="20px">
				<input type="hidden" name="aclikes" id="aclikes" value="<?php echo $playlikes;?>">
				<input type="hidden" name="acip" id="acip" value="<?php echo "{$_SERVER['REMOTE_ADDR']}";?>">
				<br><span>Likes: <?php echo $playlikes;?></span></button>
				</form>	
				<?php } 
				else { ?>
				<form method="POST" encType="multipart/form-data">
				<button type="summit" class="buttonpod2" name="accion" value="like"><img src="images/heart.png" width="20px" height="20px">
				<input type="hidden" name="aclikes" id="aclikes" value="<?php echo $playlikes;?>">
				<input type="hidden" name="acip" id="acip" value="<?php echo "{$_SERVER['REMOTE_ADDR']}";?>">
				<br><span>Likes: <?php echo $playlikes;?></span></button>
				</form>
				<?php } ?>
				<a href="<?php echo $playanchor?>"><div class="buttonpod2"><img src="images/social/anchor.png" width="20px" height="20px"><br><span> Ir a Anchor</span></div></a>
				<a href="<?php echo $playspotify?>"><div class="buttonpod2"><img src="images/social/spotify.webp" width="20px" height="20px"><br><span> Ir a Spotify</span></div></a>
				<a href="<?php echo $playyoutube?>"><div class="buttonpod2"><img src="images/social/youtube.webp" width="20px" height="20px"><br><span> Ir a Youtube</span></div></a>
				</div>
				<br>
				<div>
					<p class="podp">Duracion: <?php echo $playduracion?></p>
					<p class="podp">Descripcion: <br> <?php echo $playdescripcion?></p>
				</div>
				<hr>
				

				<?php



				$ccID=(isset($_POST["ccID"]))?$_POST["ccID"]:"";
				$ccname=(isset($_POST["ccname"]))?$_POST["ccname"]:"";
				$cccomentario=(isset($_POST["cccomentario"]))?$_POST["cccomentario"]:"";
				$tuip=(isset($_POST["acip"]))?$_POST["acip"]:"";
				$accion=(isset($_POST["accion"]))?$_POST["accion"]:"";

				switch($accion){
					
						case "Agregar";
						$sentenciaSQL= $conexion->prepare("INSERT INTO comentarios (id,nombre,comentario ) VALUES (:id,:nombre,:comentario);");
						$sentenciaSQL->bindParam(":id",$ccID);
						$sentenciaSQL->bindParam(":nombre",$ccname);
						$sentenciaSQL->bindParam(":comentario",$cccomentario);
						$sentenciaSQL->execute();
						header("Location:$enlace_actual");
						break;
						
						case "like";
						$playlikes = $playlikes + 1;
						$sentenciaSQL= $conexion->prepare("UPDATE likes SET like_count=:likes  WHERE id=:id");
						$sentenciaSQL->bindParam(":likes",$playlikes);
						$sentenciaSQL->bindParam(":id",$playid);
						$sentenciaSQL->execute();
						$sentenciaSQL= $conexion->prepare("INSERT INTO ips (id,ip) VALUES (:id,:ip)");
						$sentenciaSQL->bindParam(":id",$playid);
						$sentenciaSQL->bindParam(":ip",$tuip);
						$sentenciaSQL->execute();
						header("Location:$enlace_actual");
						break;

						case "unlike";
						$playlikes = $playlikes - 1;
						$sentenciaSQL= $conexion->prepare("UPDATE likes SET like_count=:likes  WHERE id=:id");
						$sentenciaSQL->bindParam(":likes",$playlikes);
						$sentenciaSQL->bindParam(":id",$playid);
						$sentenciaSQL->execute();
						$sentenciaSQL= $conexion->prepare("DELETE FROM ips WHERE id=:id and ip=:ip");
						$sentenciaSQL->bindParam(":id",$playid);
						$sentenciaSQL->bindParam(":ip",$tuip);
						$sentenciaSQL->execute();
						header("Location:$enlace_actual");
						break;

						}

				?>

				<div class="">
					<div>
						<div>
						<span class="podp">Envia un Comentario</span>
						</div>

						<form method="POST" encType="multipart/form-data">
					
						<div class = "form-group">
						<input type="hidden" required readonly class="form-control" value="<?php echo $playid;?>" name="ccID" id="ccID">
						</div>

						<div class = "form-group">
						<label for="ccname" class="podp">Nombre</label>
						<input type="text" class="form-control" name="ccname" id="ccname" placeholder="Nombre*">
						</div>
						<div class = "form-group">
						<label for="cccomentario" class="podp">Comentario</label>
						<textarea type="text" class="form-control" name="cccomentario" id="cccomentario" placeholder="Comentario*"></textarea>
						</div>

						<div class="btn-group" role="group" aria-label="">
							<button type="summit" name="accion" value="Agregar" class="btn btn-success">Publicar</button>
							</div>
					</form>

				</div>

				<br>
				<span class="podp">Comentarios publicados:</span>
				<br>
				<div class="container">
				<br>
				<?php foreach($Listacomentarios as $comentario) {?>
					<div>
						<span class="podp"><img src="images/userdefault.png" width="30px" height="30px"> <?php echo $comentario["nombre"];?></span><br>
						<div class="container">
						<span class="podp"><?php echo $comentario["comentario"];?></span>
						</div>
					</div>
					<br>
					<?php } ?>
					<br>
				</div>
			</div>
		</div>
		</div>
		<div class="col-md-3">
			<h2 class="podp text-center">Mas Podcasts</h2>
			<hr>
			<?php 
			foreach($Listapodcast as $podcast) {
				?>
				<form  method="">
                    <button type="summit" value="" class="buttonbox1">
					<input type="hidden" name="watch?" value="-<?php echo $podcast["id"];?>">
					<div class="pull-left">
						<img class="podicon3" src="images/podlogos/<?php echo $podcast["imagen"];?>" alt="podlogo">
					</div>
					<div class="pull-right">
						<span><?php echo $podcast["nombre"];?></span><br>
						<span>Duracion: <?php echo $podcast["duracion"];?></span><br>
						<a href="<?php echo $podcast["linkanchor"];?>"><img src="images/social/anchor.png" width="30px" height="30px"></a>
						<a href="<?php echo $podcast["linkspotify"];?>"><img src="images/social/spotify.webp" width="30px" height="30px"></a>
						<a href="<?php echo $podcast["linkyoutube"];?>"><img src="images/social/youtube.webp" width="30px" height="30px"></a>
					</div>
					</button>
                </form>
			<?php } ?>
		</div>
	</div>
	<img src="images/audio.gif" class="hr">
	<div><script async="async" data-cfasync="false" src="//pl17845569.profitablegatetocontent.com/ee85fa437eba26079fdb44092d58a9b5/invoke.js"></script>
	<div id="container-ee85fa437eba26079fdb44092d58a9b5"></div></div>
</div>
<?php }else{ ?>
	<div id="main content" class="container">
	<div class="text-center podp">
		<div class="counterbox5">
			<h2>ERROR 404 PODCAST NO ENCONTRADO</h2>
			<br>
		</div>
			<p>El podcast que usted ha buscado ya no se encuentra disponible <br>
			intente verificar e intentar lo siguiente:</p><br>

				<p>1. Revise si la URL colocada este correcta y vuelvala a colocar en la pagina</p>

				<p>2. Revise si su internet esta funcionando correctamente</p>

				<p>3. Revise si el podcast no ha sido eliminado</p>

				<p>4. Revise si el podcast existe o no es un fake link</p>

				<p>5. Intente recargar la pagina</p>

			<br>
			<p>En caso de no funcionarle nada de lo anterior puede comunicar el fallo por nuestras cuentas
				oficiales de instagram y facebook o a <a href="https://www.instagram.com/oceangamer_dev/">@oceangamer_dev</a> en instagram.
			</p><br>
	</div>
	</div>

<?php } ?>
<?php } ?>
<footer class="panel-footer">
	<div class="container">
		<div class="row">
			<section class="col-xs-6 col-sm-6 col-md-4 col-lgs-4">
				<a href="index.html"><h1 class="titletext1">JUST COFFEE</h1></a>
				<span class="smallspan3">UN CAFE ES MEJOR CON AMIGOS</span>
			</section>
			<section class="col-xs-6 col-sm-6 col-md-4 col-lgs-4 content09">
				<a href="index.html"><span class="smallspan3">Inicio</span></a><br>
				<a href="podcast.php"><span class="smallspan3">Podcasts</span></a><br>
				<a href="about.html"><span class="smallspan3">Acerca de Nosotros</span></a><br>
				<a href="contact.html"><span class="smallspan3">Contactanos</span></a>
			</section>
			<section class="col-xs-12 col-sm-12 col-md-4 col-lgs-4">
				<span class="smallspan3">SIGUENOS EN NUESTRAS REDES SOCIALES:</span>
				<div>
					<a href="https://anchor.fm/justcoffee" target="_blank"> <img src="images/social/anchor.png" class="socialbutton"></a>
					<a href="https://open.spotify.com/show/3pkJyqYSKTNjSW7UGjuyb4?si=SgwvgQk-R62L4d6GQd1XFA&utm_source=copy-link" target="_blank"> <img src="images/social/spotify.webp" class="socialbutton"></a>
					<a href="https://youtube.com/channel/UCM3cgAFrsPDcYurMIiT40KQ" target="_blank"> <img src="images/social/youtube.webp" class="socialbutton"></a>
					<a href="https://www.instagram.com/justcoffee.pod/" target="_blank"> <img src="images/social/instagram.webp" class="socialbutton"></a>
					<a href="https://m.facebook.com/profile.php?id=100086733101453&eav=AfbcoHXaRk4rOJS-sBBTKmdDIu0-h88rJ9ppIRU7beeuWwqSjLxU9eQYY3xt8D4vN6s&paipv=0" target="_blank"> <img src="images/social/facebook.png" class="socialbutton"></a>
				</div>
			</section>
			<div class="content09 col-xs-12 col-sm-12 col-md-12 col-lgs-12"><span class="smallspan4">© Just Coffee Podcast 2022</span></div>
			
		</div>
		
	</div>
	
</footer>



<!-- jQuery (Bootstrap JS plugins depend on it) -->
  <script src="js/jquery-2.1.4.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/script.js"></script>
  <script src="js/like.js"></script>
</body>
</html>
