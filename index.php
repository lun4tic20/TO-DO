<?php 
    // initialize errors variable
	$errors = "";

	// connect to database
	$db = mysqli_connect("localhost", "root", "", "todo");

	// si no se ha rellenado el campo sale un error
	if (isset($_POST['submit'])) {
		if (empty($_POST['tarea'])) {
			$errors = "Tienes que añadir una tarea";
		} else {
			$tarea = $_POST['tarea'];
			$sql = "INSERT INTO tareas (tarea) VALUES ('$tarea')";
			mysqli_query($db, $sql);
			header('location: index.php');
		}
	}	
	if (isset($_GET['del_tarea'])) {
		$id = $_GET['del_tarea'];
	
		mysqli_query($db, "DELETE FROM tareas WHERE id=".$id);
		header('location: index.php');
	}		
?>
<!DOCTYPE html>
<html>
<head>
	<title>ToDo List</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container mt-5">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<div class="card">
					<div class="card-header">
						<h2 class="text-center">ToDo List</h2>
					</div>
					<div class="card-body">
						<form method="post" action="index.php" class="input_form">
							<div class="form-group">
								<input type="text" name="tarea" class="form-control" placeholder="Añade una tarea">
							</div>
							<div class="form-group">
								<button type="submit" name="submit" id="btn" class="btn btn-primary">Añadir Tarea</button>
								<?php if (isset($errors)) { ?>
									<p class="text-danger"><?php echo $errors; ?></p>
								<?php } ?>
							</div>
						</form>
						<table class="table table-striped">
								<tr>
									<th>Num</th>
									<th>Tarea</th>
									<th>Accion</th>
								</tr>
								<?php 
									// muestra las tareas
									$tareas = mysqli_query($db, "SELECT * FROM tareas");

									$i = 1; while ($row = mysqli_fetch_array($tareas)) { ?>
										<tr>
											<td> <?php echo $i; ?> </td>
											<td class="tarea"> <?php echo $row['tarea']; ?> </td>
											<td class="delete"> 
											<a href="index.php?del_tarea=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete();">Eliminar</a>
											</td>
										</tr>
								<?php $i++; }?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function confirmDelete() {
			return confirm("¿Estás seguro de que quieres eliminar esta tarea?");
		}
	</script>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


</body>
</html>
