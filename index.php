<?php 
    // initialize errors variable
	$errors = "";

	// connect to database
	$db = mysqli_connect("localhost", "root", "", "todo");

	// si no se ha rellenado el campo sale un error
	if (isset($_POST['submit'])) {
		if (empty($_POST['tarea'])) {
			$errors = "Tienes que añadir una tarea";
		}else{
			$tarea = $_POST['tarea'];
			$sql = "INSERT INTO tareas (tarea) VALUES ('$tarea')";
			mysqli_query($db, $sql);
			header('location: index.php');
		}
	}	

?>

<!DOCTYPE html>
<html>
<head>
	<title>ToDo List</title>
</head>
<body>
	<div class="heading">
		<h2 style="font-style: 'Hervetica';">ToDo List</h2>
	</div>
	<form method="post" action="index.php" class="input_form">
		
		<input type="text" name="tarea" class="tarea_input">
		<button type="submit" name="submit" id="btn" class="btn">Add Task</button>
		<?php if (isset($errors)) { ?>
			<p><?php echo $errors; ?></p>
		<?php } ?>
	</form>

	<table>
		<tr>
			<th>N</th>
			<th>Tasks</th>
			<th>Action</th>
		</tr>
		<?php 
		// muestra las tareas
		$tareas = mysqli_query($db, "SELECT * FROM tareas");

		$i = 1; while ($row = mysqli_fetch_array($tareas)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td class="tarea"> <?php echo $row['tarea']; ?> </td>
				<td class="delete"> 
					<a href="index.php?del_tarea=<?php echo $row['id'] ?>">Eliminar</a> 
				</td>
			</tr>
		<?php $i++; } ?>	

</table>
</body>
</html>