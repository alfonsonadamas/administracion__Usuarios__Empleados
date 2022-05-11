<?php
	include("conexion.php");
	
?>
<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/style.css">
	<title>Datos de usuarios</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">

	<style>
		.content {
			margin-top: 80px;
		}
	</style>

</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include('navUsuario.php');?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Lista de usuarios</h2>
			<hr />

			<?php
            // VALOR aksi es para borrar
			if(isset($_GET['aksi']) == 'delete'){
				// escaping, additionally removing everything that could be (html/javascript-) code
				$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
                $miConsulta = "SELECT * FROM usuarios WHERE idUser = '$nik'"; //buscar el empleado que tenga en el campo codigo lo que hay en la variable $nik para ser eliminado
				$cek = mysqli_query($con,$miConsulta);
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontraron datos.</div>';
				}else{
					$delete = mysqli_query($con, "DELETE FROM usuarios WHERE idUser='$nik'");
					if($delete){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
					}
				}
			}
			?>

			<form class="form-inline" method="get">
				<div class="form-group">
					<select name="filter" class="form-control" onchange="form.submit()">
						<option value="0">Filtros de datos de usuarios</option>
						<?php $filter = (isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>
						<option value="1" <?php if($filter == 'Tetap'){ echo 'selected'; } ?>>Administrador</option>
						<option value="2" <?php if($filter == 'Kontrak'){ echo 'selected'; } ?>>Programador</option>
                        <option value="3" <?php if($filter == 'Outsourcing'){ echo 'selected'; } ?>>Patron</option>
					</select>
				</div>
			</form>
			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
                    <th>No</th>
					<th>Código</th>
					<th>Nombre de Usuario</th>
                    <th>Contraseña</th>
                    <th>Nobre</th>
					<th>Apellido</th>
					<th>Correo</th>
					<th>Rol</th>
                    <th>Acciones</th>
				</tr>
				<?php
				if($filter){
                    $miConsulta = "SELECT *  FROM usuarios '";   //crear una consulta que muestre a todos los usuarios de la tabla empleados 
                                        //que coincidan con el contenido del campo estado y de la variable $filter
					$sql = mysqli_query($con, $miConsulta);
				}else{
                    $miConsulta = "SELECT * FROM usuarios ORDER BY idUser ASC"; //crear una consulta que muestre a todos los usuarios de la tabla usuarios ordenadas por el campo código
					$sql = mysqli_query($con, $miConsulta);
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							<td>'.$no.'</td>
							<td>'.$row['idUser'].'</td>
							<td><a href="profile.php?nik='.$row['idUser'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['userName'].'</a></td>
                            <td>'.$row['password'].'</td>
                            <td>'.$row['nombre'].'</td>
							<td>'.$row['apellidos'].'</td>
                            <td>'.$row['email'].'</td>
							<td>';

							if($row['rol'] == '1'){
								echo '<span class="label label-success">Administrador</span>';
							}
                            else if ($row['rol'] == '2' ){
								echo '<span class="label label-info">Programador</span>';
							}
                            else if ($row['rol'] == '3' ){
								echo '<span class="label label-warning">Patron</span>';
							}
						echo '
							</td>
							<td>

								<a href="editUsuario.php?nik='.$row['idUser'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								<a href="usuarios.php?aksi=delete&nik='.$row['idUser'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombre'].'?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
							
						
						$no++;
					}
				}
				?>
			</table>
			</div>
		</div>
	</div><center>
	<a class = "boton" href="principal.php">Empleados</a>
	<br><br>

    <p>&copy; Sistemas Web <?php echo date("Y");?></p>
		</center>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>