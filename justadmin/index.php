<?php
session_start();
if($_POST){
  if(($_POST["user"]=="justcoffee")&&($_POST["password"]=="#ven1008")){
    $_SESSION["name"]="ok";
    $_SESSION["nombreUsuario"]="justcoffee";
    header("Location:admin.php");
  }else{
    $mensaje="Error: Usuario o Contraseña son Incorrectos";
  }
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
	<title>JustCoffeeAdmins</title>
</head>
<body>
<header>
	<nav id="header-nav" class="navbar navbar-default toppage">
		<div class="container toppage">
			<div class="navbar-header">
				<div>
					<a href="index.html" class="pull-left ">
						<img src="../images/logo.png" class="logo">
					</a>
					<div class="navbar-brand">
						<a href="index.php"><h1 class="titletext1">JUST COFFEE - ADMINS</h1></a>
					</div>
				</div>
			</div>
		</div>
	</nav>
</header>

<div id="main content" class="container">
	<div class="counterbox5 podp">
			<h2>INICIA SESION PARA ENTRAR</h2>
		</div>
		<p class="subtitle">Esta zona es solo para Administradores</p>
		<hr>
		<div class="counterbox65">
		<div class="col-md-4"></div>
            <div class="col-md-4">
            <div class="card">
			<h2 class="podh2 text-center">INICIA SESION</h2>
                <div class="card-body">
                  <?php if(isset($mensaje)) { ?>
                    <div class="alert alert-danger" role="alert">
                      <?php echo $mensaje?>
                    </div>
                  <?php } ?>

                    <form method="POST">

                    <div class = "form-group podp">
                    <label>Usuario</label>
                    <input type="text" class="form-control" name="user" placeholder="usuario">
                    </div>
                    <div class="form-group podp">
                    <label>Contraseña</label>
                    <input type="password" class="form-control" name="password" placeholder="contraseña">
                    </div>
                    <button type="submit" class="btn btn-primary">Loguearse</button>

                    </form>
                    
                    

                </div>
                
            
        </div>
    </div>

		</div>
		<hr>
		<a href=".."><div class="buttonpod2"><span>volver<br>a la pagina</span></div></a> 
	<img src="../images/audio.gif" class="hr">
	<div><script async="async" data-cfasync="false" src="//pl17845569.profitablegatetocontent.com/ee85fa437eba26079fdb44092d58a9b5/invoke.js"></script>
	<div id="container-ee85fa437eba26079fdb44092d58a9b5"></div></div>
</div>


<!-- jQuery (Bootstrap JS plugins depend on it) -->
  <script src="js/jquery-2.1.4.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
