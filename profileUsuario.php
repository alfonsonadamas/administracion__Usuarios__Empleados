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
	<title>Datos de empleados</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
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
		<?php include("nav.php");?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Datos del empleados &raquo; Perfil</h2>
			<hr />
			
			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
			
            $miConsulta = "SELECT * FROM usuarios WHERE id = '$nik'"; // Buscar el registro donde codigo sea igual a variable $nik
            
			$sql = mysqli_query($con, $miConsulta);
			if(mysqli_num_rows($sql) == 0){
				header("Location: index.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			
			if(isset($_GET['aksi']) == 'delete'){
                
                $miConsulta = "DELETE FROM usuarios WHERE id = '$nik'"; //crear la consulta para borrar el registro de codigo igual a variable $nik
				$delete = mysqli_query($con, $miConsulta);
				if($delete){
					echo '<div class="alert alert-danger alert-dismissable">><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Data berhasil dihapus.</div>';
				}else{
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Data gagal dihapus.</div>';
				}
			}
			?>
			
			<table class="table table-striped table-condensed">
				<tr>
					<th width="20%">C??digo</th>
					<td><?php echo $row['id']; ?></td>
				</tr>
				<tr>
					<th>Nombre de Usuario</th>
					<td><?php echo $row['nombreUsuario']; ?></td>
				</tr>
				<tr>
					<th>Contrase??a</th>
					<td><?php echo $row['contrasenia']; ?></td>
				</tr>
				<tr>
					<th>Correo</th>
					<td><?php echo $row['email']; ?></td>
				</tr>
				<tr>
					<th>Nombre</th>
					<td><?php echo $row['nombre']; ?></td>
				</tr>
				<tr>
					<th>Apellido</th>
					<td><?php echo $row['apellidos']; ?></td>
				</tr>
				<tr>
					<th>Rol</th>
					<td>
						<?php 
							if ($row['rol']==1) {
								echo "Administrador";
							} else if ($row['rol']==2){
								echo "Programador";
							} else if ($row['rol']==3){
								echo "Patron";
							}
						?>
					</td>
				</tr>
				
			</table>
			
			<a href="usuarios.php" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Regresar</a>
			<a href="editUsuario.php?nik=<?php echo $nik; ?>" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar datos</a>
			<a href="profileUsuario.php?aksi=delete&nik=<?php echo $nik; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Esta seguro de borrar los datos <?php echo $row['nombreUsuario']; ?>')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminar</a>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>