<?php
session_start();
    if(!isset($_SESSION["name"])){
       header("location:index.php"); 
    }else{
        if($_SESSION["name"]=="ok"){
            $nombreUsuario=$_SESSION["nombreUsuario"];
        }
    }
	include("../config/bd.php");
?>
<?php
//error_reporting(0);
$accion=(isset($_POST["accion"]))?$_POST["accion"]:"";
$nombre=(isset($_POST["nombre"]))?$_POST["nombre"]:"";
$imagen=(isset($_FILES["imagen"]["name"]))?$_FILES["imagen"]["name"]:"";
$duracion=(isset($_POST["duracion"]))?$_POST["duracion"]:"";
$descripcion=(isset($_POST["descripcion"]))?$_POST["descripcion"]:"";
$embed=(isset($_POST["embed"]))?$_POST["embed"]:"";
$anchor=(isset($_POST["anchor"]))?$_POST["anchor"]:"";
$spotify=(isset($_POST["spotify"]))?$_POST["spotify"]:"";
$youtube=(isset($_POST["youtube"]))?$_POST["youtube"]:"";
$podid=(isset($_POST["podid"]))?$_POST["podid"]:"";
$coid=(isset($_POST["id"]))?$_POST["id"]:"";
$nombreco=(isset($_POST["nombreco"]))?$_POST["nombreco"]:"";
$comentarioco=(isset($_POST["comentarioco"]))?$_POST["comentarioco"]:"";
$txtImagen=(isset($_FILES["txtImagen"]["name"]))?$_FILES["txtImagen"]["name"]:"";
switch($accion){
    
	case "Agregar";

		$sentenciaSQL= $conexion->prepare("INSERT INTO podcasts (nombre,duracion,descripcion,embed,linkanchor,linkspotify,linkyoutube ) VALUES (:nombre,:duracion,:descripcion,:embed,:anchor,:spotify,:youtube);");
		$sentenciaSQL->bindParam(":nombre",$nombre);
		$sentenciaSQL->bindParam(":duracion",$duracion);
		$sentenciaSQL->bindParam(":descripcion",$descripcion);
		$sentenciaSQL->bindParam(":embed",$embed);
		$sentenciaSQL->bindParam(":anchor",$anchor);
		$sentenciaSQL->bindParam(":spotify",$spotify);
		$sentenciaSQL->bindParam(":youtube",$youtube);
		$sentenciaSQL->execute();

		

		$sentenciaSQL= $conexion->prepare("SELECT * FROM podcasts WHERE nombre=:nombre");
		$sentenciaSQL->bindParam(":nombre",$nombre);
        $sentenciaSQL->execute();
        $idspod=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
		$id=$idspod["id"];
		$sentenciaSQL= $conexion->prepare("INSERT INTO likes (id,like_count ) VALUES (:id,0);");
		$sentenciaSQL->bindParam(":id",$id);
		$sentenciaSQL->execute();


            $fecha= new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen,"../images/podlogos/".$nombreArchivo);

            $sentenciaSQL= $conexion->prepare("SELECT imagen FROM podcasts WHERE id=:id");
            $sentenciaSQL->bindParam(":id",$id);
            $sentenciaSQL->execute();
            $juego=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if( isset($juego["imagen"]) &&($juego["imagen"]!="imagen.jpg") ){

                if(file_exists("../images/podlogos/".$juego["imagen"])){

                    unlink("../images/podlogos/".$juego["imagen"]);
                }

            }
            
            
            
            $sentenciaSQL= $conexion->prepare("UPDATE podcasts SET imagen=:imagen  WHERE id=:id");
            $sentenciaSQL->bindParam(":imagen",$nombreArchivo);
            $sentenciaSQL->bindParam(":id",$id);
            $sentenciaSQL->execute();
            
		header("Location:admin.php");
		break;


		case "Seleccionar";
		echo "Presionado boton Seleccionar";
		$sentenciaSQL= $conexion->prepare("SELECT * FROM podcasts WHERE id=:id");
		$sentenciaSQL->bindParam(":id",$podid);
		$sentenciaSQL->execute();
		$podcast3=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
		$sentenciaSQL= $conexion->prepare("SELECT * FROM comentarios WHERE id=:id");
		$sentenciaSQL->bindParam(":id",$podid);
		$sentenciaSQL->execute();
		$Listacomentarios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
		$sentenciaSQL= $conexion->prepare("SELECT * FROM likes WHERE id=:id");
		$sentenciaSQL->bindParam(":id",$podid);
		$sentenciaSQL->execute();
		$podcastlike=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

		$txtId=$podcast3["id"];
		$txtNombre=$podcast3["nombre"];
		$txtImagen=$podcast3["imagen"];
		$txtDuracion=$podcast3["duracion"];
		$txtDescripcion=$podcast3["descripcion"];
		$txtEmbed=$podcast3["embed"];
		$txtAnchor=$podcast3["linkanchor"];
		$txtSpotify=$podcast3["linkspotify"];
		$txtYoutube=$podcast3["linkyoutube"];
		$playlikes=$podcastlike["like_count"];
		break;

		case "BorrarComentario";
		//echo "Presionado boton Borrar";
		$sentenciaSQL= $conexion->prepare("DELETE FROM comentarios WHERE id=:id and nombre=:nombre and comentario=:comentario");
		$sentenciaSQL->bindParam(":id",$coid);
		$sentenciaSQL->bindParam(":nombre",$nombreco);
		$sentenciaSQL->bindParam(":comentario",$comentarioco);
		$sentenciaSQL->execute();
		header("Location:admin.php");
		break;

		case "Borrar";
            //echo "Presionado boton Borrar";
            $sentenciaSQL= $conexion->prepare("SELECT imagen FROM podcasts WHERE id=:id");
            $sentenciaSQL->bindParam(":id",$podid);
            $sentenciaSQL->execute();
            $podcast=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if( isset($podcast["imagen"]) &&($podcast["imagen"]!="imagen.jpg") ){

                if(file_exists("../../img/".$podcast["imagen"])){

                    unlink("../../img/".$podcast["imagen"]);
                }

            }


            $sentenciaSQL= $conexion->prepare("DELETE FROM podcasts WHERE id=:id");
            $sentenciaSQL->bindParam(":id",$podid);
            $sentenciaSQL->execute();
			$sentenciaSQL= $conexion->prepare("DELETE FROM likes WHERE id=:id");
            $sentenciaSQL->bindParam(":id",$podid);
            $sentenciaSQL->execute();
			$sentenciaSQL= $conexion->prepare("DELETE FROM comentarios WHERE id=:id");
            $sentenciaSQL->bindParam(":id",$podid);
            $sentenciaSQL->execute();
            break;

		case "Modificar";
		//echo "Presionado boton modificar";
		$sentenciaSQL= $conexion->prepare("UPDATE podcasts SET nombre=:nombre , duracion=:duracion , descripcion=:descripcion , embed=:embed , linkanchor=:anchor , linkspotify=:spotify , linkyoutube=:youtube WHERE id=:id");
		$sentenciaSQL->bindParam(":id",$podid);
		$sentenciaSQL->bindParam(":nombre",$nombre);
		$sentenciaSQL->bindParam(":duracion",$duracion);
		$sentenciaSQL->bindParam(":descripcion",$descripcion);
		$sentenciaSQL->bindParam(":embed",$embed);
		$sentenciaSQL->bindParam(":anchor",$anchor);
		$sentenciaSQL->bindParam(":spotify",$spotify);
		$sentenciaSQL->bindParam(":youtube",$youtube);
		$sentenciaSQL->execute();

		$archivo = $_FILES['archivo']['name'];
		//Si el archivo contiene algo y es diferente de vacio
		if($txtImagen!=""){

            $fecha= new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen,"../images/podlogos/".$nombreArchivo);

            $sentenciaSQL= $conexion->prepare("SELECT imagen FROM podcasts WHERE id=:id");
            $sentenciaSQL->bindParam(":id",$podID);
            $sentenciaSQL->execute();
            $juego=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if( isset($juego["imagen"]) &&($juego["imagen"]!="imagen.jpg") ){

                if(file_exists("../images/podlogos/".$juego["imagen"])){

                    unlink("../images/podlogos/".$juego["imagen"]);
                }

            }
            
            
            
            $sentenciaSQL= $conexion->prepare("UPDATE podcasts SET imagen=:imagen  WHERE id=:id");
            $sentenciaSQL->bindParam(":imagen",$nombreArchivo);
            $sentenciaSQL->bindParam(":id",$podid);
            $sentenciaSQL->execute();
            }
		header("Location:admin.php");
		break;

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
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
	<link rel="icon" type="image/png" href="../images/logo.png">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Allerta+Stencil&family=Stardos+Stencil&display=swap" rel="stylesheet">
	<title>JustAdmins</title>
</head>
<body>
<header>
	<nav id="header-nav" class="navbar navbar-default toppage">
		<div class="container toppage">
			<div class="navbar-header">
				<div>
					<a href="admin.php" class="pull-left ">
						<img src="../images/logo.png" class="logo">
					</a>
					<div class="navbar-brand">
						<a href="admin.php"><h1 class="titletext1">JUST ADMINS</h1></a>
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
							<a href="admin.php" class="nav-item nav-link active">
							<br class="hidden-xs">Inicio</a>
						</li>
						<li>
							<a href="admin.php?modpod" class="nav-item nav-link active">
							<br class="hidden-xs">Administrar Podcasts</a>
						</li>
						<li>
							<a href="admin.php?newpod" class="nav-item nav-link active">
							<br class="hidden-xs">Subir Podcast</a>
						</li>
						<li>
							<a href="close.php" class="nav-item nav-link active">
							<br class="hidden-xs">Cerrar Sesion</a>
						</li>
					</ul>
			</div>
		</div>
	</nav>
</header>
<?php
$enlace_actual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if ($enlace_actual == "http://localhost/JustCoffee/justadmin/admin.php") {
	# code...?>


<div id="main content" class="container">
	<div class="counterbox5">
			<h2>DASHBOARD</h2>
		</div>
		<div class="counterbox65 podp">
			ELIGE UNA OPCION
		</div>
		<div class="col-md-4 col-sm-6">
				<a href="admin.php?newpod" class="">
				<div class="counterbox65">
					<span class="pull-right podp">Subir nuevo Podcast!</span>
					<img src="../images/new.png" alt="logo" style="width:100px; height:100px;"><br>
					
				</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6">
				<a href="admin.php?modpod" class="">
				<div class="counterbox65">
					<span class="pull-right podp">Administrar podcast<br>existente</span>
					<img src="../images/modify.png" alt="logo" style="width:100px; height:100px;"><br>
					
				</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6">
				<a href="close.php" class="">
				<div class="counterbox65">
					<span class="pull-right podp">Cerrar Sesion</span>
					<img src="../images/exit.png" alt="logo" style="width:100px; height:100px;"><br>
					
				</div>
				</a>
			</div>

<?php
}
if ($enlace_actual == "http://localhost/JustCoffee/justadmin/admin.php?newpod") {
?>
<div id="main content" class="container">
<div class="counterbox5">
			<h2>SUBIR NUEVO PODCAST</h2>
		</div>
		<div class="counterbox65 podp">
			<br>
			<span>Subir Nuevo Podcast <br> Los campos marcados con un * son obligatorios</span>
			<form method="POST" encType="multipart/form-data">
			<div class="form-group col-md-4 col-sm-12">
				<br>
			  <label for="name">Nombre*</label>
			  <input type="text" required name="nombre" id="nombre" class="form-control" placeholder="Nombre del Podcast*" aria-describedby="helpId">
			</div>
			<div class="form-group col-md-4 col-sm-12">
				<br>
			  <label for="name">Icono*</label>
			  <input type="file" required name="txtImagen" id="txtImagen" class="form-control">
			  <small id="helpId" class="text-muted podp">Icono del Podcast</small>
			</div>
			<div class="form-group col-md-4 col-sm-12">
				<br>
			  <label for="name">Duracion*</label>
			  <input type="text" required name="duracion" id="duracion" class="form-control" placeholder="Duracion del Podcast* HH:MM:SS" aria-describedby="helpId">
			</div>
			<div class="form-group col-md-6 col-sm-12">
				<br>
			  <label for="name">Descripcion</label>
			  <textarea type="text" name="descripcion" id="descripcion" rows="3" class="form-control" placeholder="Descripcion del Podcast" aria-describedby="helpId"></textarea>
			</div>
			<div class="form-group col-md-6 col-sm-12">
				<br>
			  <label for="name">Embed*</label>
			  <textarea type="text" required  name="embed" id="embed" rows="3" class="form-control" placeholder="ATENCION: este es el link que anclara el podcast a anchor para que podamos 
				escuchar el podcast, el formato debe ser del link sin iframe" aria-describedby="helpId"></textarea>
			</div>
			<div class="form-group col-md-4 col-sm-12">
				<br>
			  <label for="name">Link de Anchor</label>
			  <input type="text" name="anchor" id="anchor" class="form-control" placeholder="Link para ir a anchor desde la pagina" aria-describedby="helpId">
			</div>
			<div class="form-group col-md-4 col-sm-12">
				<br>
			  <label for="name">Link de Spotify</label>
			  <input type="text" name="spotify" id="spotify" class="form-control" placeholder="Link para ir a spotify desde la pagina" aria-describedby="helpId">
			</div>
			<div class="form-group col-md-4 col-sm-12">
				<br>
			  <label for="name">Link de Youtube</label>
			  <input type="text" name="youtube" id="spotify" class="form-control" placeholder="Link para ir a youtube desde la pagina" aria-describedby="helpId">
			  <br>
			</div>
			<button type="summit" class="btn btn-primary" name="accion" value="Agregar">Subir Podcast</button>
			<a href="admin.php"><button type="button" class="btn btn-warning">Cancelar</button></a>
			</form>
		</div>


</div>


<?php

}
if ($enlace_actual == "http://localhost/JustCoffee/justadmin/admin.php?modpod") {


	$sentenciaSQL= $conexion->prepare("SELECT * FROM podcasts");
    $sentenciaSQL->execute();
    $Listapodcast=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
	$sentenciaSQL= $conexion->prepare("SELECT * FROM likes");
    $sentenciaSQL->execute();
    $Listalikes=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="main content" class="">
<div class="counterbox5">
			<h2>PODCASTS EXISTENTES</h2>
		</div>
		<div class="podp col-md-7 ">
			<form method="POST" class="counterbox65" encType="multipart/form-data">
			<br>
			<span>Modificar Podcast | Likes= <?php echo $playlikes;?><br> Los campos marcados con un * son obligatorios</span>
			<br>
			<div>
			  <input type="hidden" required name="podid" id="podid" class="form-control" placeholder="id del Podcast*" value="<?php echo $txtId; ?>" aria-describedby="helpId">
			</div>
			<div class="form-group col-md-4 col-sm-12">
				<br>
			  <label for="name">Nombre*</label>
			  <input type="text" required name="nombre" id="nombre" class="form-control" placeholder="Nombre del Podcast*" value="<?php echo $txtNombre; ?>" aria-describedby="helpId">
			</div>
			<div class="form-group col-md-4 col-sm-12">
				<br>
			  <label for="name">Icono*</label>
			  <?php if($txtImagen!=""){  ?>

				<img class="" src="../images/podlogos/<?php echo $txtImagen; ?>" width="30px" height="30px" alt="" srcset="">


				<?php }?>
			  <input type="file" name="txtImagen" id="txtImagen" class="form-control">
			  <small id="helpId" class="text-muted podp">Icono del Podcast</small>
			</div>
			<div class="form-group col-md-4 col-sm-12">
				<br>
			  <label for="name">Duracion*</label>
			  <input type="text" required name="duracion" id="duracion" class="form-control" placeholder="Duracion del Podcast* HH:MM:SS" aria-describedby="helpId" value="<?php echo $txtDuracion; ?>">
			</div>
			<div class="form-group col-md-6 col-sm-12">
				<br>
			  <label for="name">Descripcion</label>
			  <textarea type="text" name="descripcion" id="descripcion" rows="3" class="form-control" placeholder="Descripcion del Podcast" aria-describedby="helpId"><?php echo $txtDescripcion; ?></textarea>
			</div>
			<div class="form-group col-md-6 col-sm-12">
				<br>
			  <label for="name">Embed*</label>
			  <textarea type="text" required  name="embed" id="embed" rows="3" class="form-control" placeholder="ATENCION: este es el link que anclara el podcast a anchor para que podamos 
				escuchar el podcast, el formato debe ser del link sin iframe" aria-describedby="helpId"><?php echo $txtEmbed; ?></textarea>
			</div>
			<div class="form-group col-md-4 col-sm-12">
				<br>
			  <label for="name">Link de Anchor</label>
			  <input type="text" name="anchor" id="anchor" class="form-control" placeholder="Link para ir a anchor desde la pagina" aria-describedby="helpId"  value="<?php echo $txtAnchor; ?>">
			</div>
			<div class="form-group col-md-4 col-sm-12">
				<br>
			  <label for="name">Link de Spotify</label>
			  <input type="text" name="spotify" id="spotify" class="form-control" placeholder="Link para ir a spotify desde la pagina" aria-describedby="helpId"  value="<?php echo $txtSpotify; ?>">
			</div>
			<div class="form-group col-md-4 col-sm-12">
				<br>
			  <label for="name">Link de Youtube</label>
			  <input type="text" name="youtube" id="spotify" class="form-control" placeholder="Link para ir a youtube desde la pagina" aria-describedby="helpId"  value="<?php echo $txtYoutube; ?>">
			  <br>
			</div>
			<div class="form-group col-md-12 col-sm-12">
			<button type="summit" class="btn btn-success" name="accion" value="Modificar">Modificar Podcast</button>
			<button type="summit" class="btn btn-danger" name="accion" value="Borrar">Borrar Podcast</button>
			<a href="admin.php?modpod"><button type="button" class="btn btn-warning">Cancelar</button></a>
			  </div>
			</form>
				<br><br><br>
			<div class="counterbox65">
			<h2 class="podp">Administrar Comentarios del Podcast</h2>
			<?php foreach($Listacomentarios as $comentario) { ?>
			<form class="form-group" method="post">
				<input type="hidden" name="id" id="id" class="form-control" placeholder="name"  value="<?php echo $comentario["id"]; ?>">
			  	<label for="nombre">Nombre del Autor</label>
			  	<input type="text" readonly name="nombreco" id="nombreco" class="form-control" placeholder=""  value="<?php echo $comentario["nombre"]; ?>">
				<label for="nombre">Comentario</label>
				<input type="text" readonly name="comentarioco" id="comentarioco" class="form-control" placeholder=""  value="<?php echo $comentario["comentario"]; ?>">
				<button type="summit" class="btn btn-danger" name="accion" value="BorrarComentario">Borrar Comentario</button>
			</form>
			<?php } ?>
			</div>
		</div>
		<div class="podp col-md-4 col-sm-12 col-xs-12">
		<table class="table counterbox65">
			<thead>
				<tr>
					<th>Logo</th>
					<th>Nombre</th>
					<th>Duracion</th>
					<th>Botones</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($Listapodcast as $podcast) { ?>
				<tr>
					<td><img src="../images/podlogos/<?php echo $podcast["imagen"]; ?>" width="80px" height="80px" alt="" srcset=""></td>
					<td><?php echo $podcast["nombre"]; ?></td>
					<td><?php echo $podcast["duracion"]; ?></td>
					<td>
					<form method="post">
                    <input type="hidden" name="podid" id="podid" value="<?php echo $podcast["id"]; ?>">
                    <button type="summit" name="accion" value="Seleccionar" class="btn btn-primary">Seleccionar</button>
                	</form>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
</div>
</div>


<?php
}
?>
		
	<img src="../images/audio.gif" class="hr">
	<div><script async="async" data-cfasync="false" src="//pl17845569.profitablegatetocontent.com/ee85fa437eba26079fdb44092d58a9b5/invoke.js"></script>
	<div id="container-ee85fa437eba26079fdb44092d58a9b5"></div></div>
</div>


<!-- jQuery (Bootstrap JS plugins depend on it) -->
  <script src="../js/jquery-2.1.4.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/script.js"></script>
</body>
</html>
