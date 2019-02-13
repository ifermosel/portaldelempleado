<?php
	include("config.php");
	session_start();
?>
<html>
	<head>
	</head>
	<body>
		<form action = " " method = "post">
		Codigo del empleado
		<input type = "text" name="codigo"><br><br>
		Nuevo salario
		<input type = "number" name="salario"><br><br>
        <input type = "submit" value = "Cambiar salario" name="cambiar"/><br><br>
		</form>
	</body>
</html>
<?php
	if (isset($_POST['cambiar'])) {
		$codigo = $_POST['codigo'];
		$sal = (Integer)($_POST['salario']);
		
		$sql = "SELECT emp_no FROM employees WHERE emp_no = '$codigo'";
		$query = mysqli_query($db, $sql);
		$result = mysqli_fetch_assoc($query);
		$codigoEx = $result['emp_no'];

		if ($codigo == '' || $sal == '') {
			trigger_error("Faltan campos por rellenar.");
			die();
		}else if ($codigoEx == '') {
			trigger_error("El codigo no existe.");
			die();
		}else {
			$sqlUp = "UPDATE salaries SET to_date = CURDATE() WHERE emp_no = '$codigo' AND to_date = '9999-01-01'";
			$sqlIns = "INSERT INTO salaries (emp_no, salary, from_date, to_date) VALUES ('$codigo', '$sal', CURDATE(),'9999-01-01')";
			
			if (mysqli_query($db, $sqlUp) && mysqli_query($db, $sqlIns)) {
				echo "<div style='color: green;'>";
				echo "El cambio de salario se ha realizado con exito.<br><br>";
				echo "</div>";
			}else {
				echo "<div style='color: red;'>";
				echo "Ha habido un problema con el cambio de salario.<br><br>";
				echo "<div>";
			}
			
			$sql2 = "SELECT salary, from_date, to_date FROM salaries WHERE emp_no = '$codigo'";
			$query2 = mysqli_query($db, $sql2);

			echo "<table border='1' padding='10' style='margin: 0 auto;'>";
			echo "<tr><th>Salario</th><th>Fecha inicial</th><th>Fecha final</th></tr>";
			while($row = mysqli_fetch_assoc($query2)) {
				echo "<tr><td>".$row['salary']."</td><td>".$row['from_date']."</td><td>".$row['to_date']."</td></tr>";
			}
		}
	}
	echo "<a href = 'welcome.php'> << Volver atras</a>";
?>