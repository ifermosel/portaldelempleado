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
		Nuevo departamento
		<select name="dep">
			<option value ="null">Selecionne:</option>
				<?php
					$sql = "SELECT dept_name FROM departments;";
					$query = mysqli_query($db, $sql);
					while ($fila = mysqli_fetch_array($query, MYSQLI_ASSOC)) {					
						echo '<option>'.$fila['dept_name'].'</option>';
					}
					
					echo "<a href = 'welcome.php'> << Volver atras</a>";
				?>
		</select><br><br>
        <input type = "submit" value = "Cambiar departamento" name="cambiar"/><br><br>
		</form>
	</body>
</html>
<?php
	if (isset($_POST['cambiar'])) {
		$codigo = $_POST['codigo'];
		$dep = $_POST['dep'];
		
		$sql = "SELECT emp_no FROM employees WHERE emp_no = '$codigo'";
		$query = mysqli_query($db, $sql);
		$result = mysqli_fetch_assoc($query);
		$codigoEx = $result['emp_no'];
		
		$sql2 = "SELECT dept_no FROM departments WHERE dept_name = '$dep'";
		$query2 = mysqli_query($db, $sql2);
		$result2 = mysqli_fetch_assoc($query2);
		$codigoDep = $result2['dept_no'];

		if ($codigo == '' || $dep == 'null') {
			trigger_error("Faltan campos por rellenar.");
			die();
		}else if ($codigoEx == '') {
			trigger_error("El codigo no existe.");
			die();
		}else {
			$sqlUp = "UPDATE dept_emp SET to_date = CURDATE() WHERE emp_no = '$codigo' AND to_date = '9999-01-01'";
			$sqlIns = "INSERT INTO dept_emp (emp_no, dept_no, from_date, to_date) VALUES ('$codigo', '$codigoDep', CURDATE(), '9999-01-01')";
			
			if (mysqli_query($db, $sqlUp) && mysqli_query($db, $sqlIns)) {
				echo "<div style='color: green;'>";
				echo "El cambio de departamento se ha realizado con exito.<br><br>";
				echo "</div>";
			}else {
				echo "<div style='color: red;'>";
				echo "Ha habido un problema con el cambio de departamento.<br><br>";
				echo "<div>";
			}
			
			$sql2 = "SELECT dept_name, from_date, to_date FROM departments, dept_emp, employees WHERE dept_emp.dept_no = departments.dept_no AND dept_emp.emp_no = employees.emp_no AND employees.emp_no = '$codigo'";
			$query2 = mysqli_query($db, $sql2);

			echo "<table border='1' padding='10' style='margin: 0 auto;'>";
			echo "<tr><th>Nombre del departamento</th><th>Fecha inicial</th><th>Fecha final</th></tr>";
			while($row = mysqli_fetch_assoc($query2)) {
				echo "<tr><td>".$row['dept_name']."</td><td>".$row['from_date']."</td><td>".$row['to_date']."</td></tr>";
			}
		}
	}
	echo "<a href = 'welcome.php'> << Volver atras</a>";
?>