<?php
	include("config.php");
	session_start();
	
	$user = $_SESSION['login_user'];
	$pass = $_SESSION['pass_user'];
	$cargo = $_SESSION['title_user'];
	
	if ($cargo != 'Manager') {
		echo "<center><h1>Historial de tus categorias</h1></center>";
		
		$sql = "SELECT emp_no FROM employees WHERE substr(first_name, 1, 8) = '$user' AND substr(last_name, 1, 8) = '$pass'";
		$query = mysqli_query($db, $sql);
		$result = mysqli_fetch_assoc($query);
		$codigoEmp = $result['emp_no'];
		
		$sql2 = "SELECT title, from_date, to_date FROM titles WHERE emp_no = '$codigoEmp'";
		$query2 = mysqli_query($db, $sql2);
		
		echo "<table border='1' padding='10' style='margin: 0 auto;'>";
		echo "<tr><th>Categoria</th><th>Fecha inicial</th><th>Fecha final</th></tr>";
		while($row = mysqli_fetch_array($query2)) {
			echo "<tr><td>".$row['title']."</td><td>".$row['from_date']."</td><td>".$row['to_date']."</td></tr>";
		}
	}else {
	?>
<html>
	<head>
	</head>
	<body>
		<form name="miform" action="" method="post">
			Codigo del empleado: <input type="text" name="codigo">
			<br/><br/>
			<input type="submit" name='analizar' value="Enviar" >
		</form>
				
	</body>
</html>		

<?php
		if(isset($_REQUEST['analizar'])) {
			if (!empty($_REQUEST['codigo'])) {
				$codigo = $_REQUEST['codigo'];
				
				$sql2 = "SELECT emp_no FROM employees WHERE emp_no = '$codigo'";			
				$query2 = mysqli_query($db, $sql2);
				$resultado = mysqli_fetch_assoc($query2);
				$hola = $resultado['emp_no'];
				
				if(empty($hola)) {
					trigger_error("No existe el codigo del empleado.");
					die();
				}else {				
					$sql = "SELECT title, from_date, to_date FROM titles WHERE emp_no = '$codigo'";
					$query = mysqli_query($db, $sql);
					
					echo "<table border='1' padding='10' style='margin: 0 auto;'>";
					echo "<tr><th>Categoria</th><th>Fecha inicial</th><th>Fecha final</th></tr>";
					while($row = mysqli_fetch_array($query)) {
						echo "<tr><td>".$row['title']."</td><td>".$row['from_date']."</td><td>".$row['to_date']."</td></tr>";
					}
				}
			}else {
				trigger_error("No has introducido el codigo del empleado.");
				die();
			}
		} 
	}
	echo "<a href = 'welcome.php'> << Volver atras</a>";

	// Empleado
	// 499996
	// Zito
	// Baaz

	// Manager
	// 110085
	// Ebru
	// Alpin
?>