<?php
	include("conexion.php");
	
?>
<!DOCTYPE html>
<html lang="es">
<head>
<!--
Project      : Datos de empleados con PHP, MySQLi y Bootstrap CRUD  (Create, read, Update, Delete) 
Author		 : Obed Alvarado
Website		 : http://www.obedalvarado.pw
Blog         : https://obedalvarado.pw/blog/
Email	 	 : info@obedalvarado.pw
-->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de Usuario</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-datepicker.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">
	<style>
		.content {
			margin-top: 80px;
		}
	</style>
	
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include("navUsuario.php");?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Datos del Usuario &raquo; Editar datos</h2>
			<hr />
			
			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
            //Buscar en el campo id el dato que coindica con la variable $nik para editar el registro
            $miConsulta = "SELECT * FROM usuarios WHERE id = '$nik'"; 
			$sql = mysqli_query($con, $miConsulta);
			if(mysqli_num_rows($sql) == 0){
				header("Location: index.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			if(isset($_POST['save'])){
				$id		     = mysqli_real_escape_string($con,(strip_tags($_POST["id"],ENT_QUOTES)));//Escanpando caracteres 
				$nombreUsuario		     = mysqli_real_escape_string($con,(strip_tags($_POST["nombreUsuario"],ENT_QUOTES)));//Escanpando caracteres 
				$contrasenia	 = mysqli_real_escape_string($con,(strip_tags($_POST["contrasenia"],ENT_QUOTES)));//Escanpando caracteres 
				$email	 = mysqli_real_escape_string($con,(strip_tags($_POST["email"],ENT_QUOTES)));//Escanpando caracteres 
				$nombre	     = mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));//Escanpando caracteres 
				$apellido		 = mysqli_real_escape_string($con,(strip_tags($_POST["apellido"],ENT_QUOTES)));//Escanpando caracteres 
				$rol			 = mysqli_real_escape_string($con,(strip_tags($_POST["rol"],ENT_QUOTES)));//Escanpando caracteres  

                $transac = "START TRANSACTION";
				$trans = mysqli_query($con, $transac) or die(mysqli_error());
                $miConsulta = "UPDATE usuarios SET nombreUsuario = '$nombreUsuario', contrasenia = '$contrasenia' ,email = '$email', nombre = '$nombre', apellidos = '$apellido' , rol = '$rol' WHERE id = '$nik'"; //Crear el UPDATE para el campo id igual a variable 
                $update = mysqli_query($con, $miConsulta) or die(mysqli_error());
				$commit = "COMMIT";
				$com = mysqli_query($con, $commit) or die(mysqli_error());
				if($update){
					header("Location: editUsuario.php?nik=".$nik."&pesan=sukses");
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}
			
			if(isset($_GET['pesan']) == 'sukses'){
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
			}
			?>
			<form class="form-horizontal" action="" method="post">
				<div class="form-group">
					<label class="col-sm-3 control-label">Código</label>
					<div class="col-sm-2">
						<input type="text" name="id" value="<?php echo $row ['id']; ?>" class="form-control" placeholder="Id Usuario" readonly="readonly" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Nombre de Usuario</label>
					<div class="col-sm-4">
						<input type="text" name="nombreUsuario" value="<?php echo $row ['nombreUsuario']; ?>" class="form-control" placeholder="Nombre de Usuario" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Contraseña</label>
					<div class="col-sm-4">
						<input type="text" name="contrasenia" value="<?php echo $row ['contrasenia']; ?>" class="form-control" placeholder="Contrasenia" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Email</label>
					<div class="col-sm-4">
						<input type="text" name="email" value="<?php echo $row ['email']; ?>" class="input-group date form-control" placeholder="Email" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Nombre</label>
					<div class="col-sm-3">
						<input type="text" name="nombre" class="form-control" placeholder="Nombre" value = "<?php echo $row ['nombre']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Apellido</label>
					<div class="col-sm-3">
						<input type="text" name="apellido" value="<?php echo $row ['apellidos']; ?>" class="form-control" placeholder="Apellido" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Rol</label>
					<div class="col-sm-3">
						<select name="rol" class="form-control">
							<option value="">- Selecciona un rol -</option>
                            <option value="1" <?php if ($row ['rol']==1){echo "selected";} ?>>Administrador</option>
							<option value="2" <?php if ($row ['rol']==2){echo "selected";} ?>>Programador</option>
							<option value="3" <?php if ($row ['rol']==3){echo "selected";} ?>>Patron</option>
						</select> 
					</div>
                   
                </div>
			
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="usuarios.php" class="btn btn-sm btn-danger">Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
	$('.date').datepicker({
		format: 'dd-mm-yyyy',
	})
	</script>
</body>
</html>