<?php 
    // initialize errors variable
	$errors = "";

	// connect to database
	$db = mysqli_connect("localhost", "root", "", "to_do");

	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {
		if (empty($_POST['to_do'])) {
			$errors = "You must fill in the todo";
		}else{
			$todo = $_POST['to_do'];
			$sql = "INSERT INTO to_do (todo) VALUES ('$todo')";
			mysqli_query($db, $sql);
			header('location: index.php');
		}
	}	
// delete todo
	if (isset($_GET['del_todo'])) {
		$id = $_GET['del_todo'];
		mysqli_query($db, "DELETE FROM to_do WHERE id=".$id);
		header('location: index.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>To-do List</title>
</head>
<body>
	<div class="heading">
		<h2>To-do List</h2>
	</div>
	<form method="post" action="index.php" class="input_form">
		<?php if (isset($errors)) { ?>
		<p><?php echo $errors; ?></p>
		<?php } ?>
		<input type="text" name="to_do" class="todo_input">
		<button type="submit" name="submit" id="add_btn" class="add_btn">Add To-do</button>
	</form>
	<table>
	<thead>
		<tr>
			<th>N</th>
			<th>todos</th>
			<th style="width: 60px;">Action</th>
		</tr>
	</thead>

	<tbody>
		<?php 
		// select all todos if page is visited or refreshed
		$todos = mysqli_query($db, "SELECT * FROM to_do");

		$i = 1; while ($row = mysqli_fetch_array($todos)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td class="todo"> <?php echo $row['todo']; ?> </td>
				<td class="delete"> 
					<a href="index.php?del_todo=<?php echo $row['id'] ?>">x</a> 
				</td>
			</tr>
		<?php $i++; } ?>
	</tbody>
</table>
</body>
</html>

