<?php
   include('session.php');
   
   //Sesion de inactividad
   $inactividad = 60;
    if(isset($_SESSION["timeout"])){
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: welcome.php");
        }
    }
	$_SESSION["timeout"] = time();
	
	$myusername = $_SESSION['login_user'];
	$mypassword = $_SESSION['pass_user'];
	
	//Sacamos el codigo del empleado
	$sql = "SELECT emp_no FROM employees WHERE substr(first_name, 1, 8) = '$myusername' AND substr(last_name, 1, 8) = '$mypassword'";
	$query = mysqli_query($db, $sql);
	$result = mysqli_fetch_assoc($query);
	$codigoEmp = $result['emp_no'];
		
	//Sacamos la categoria del empleado
	$sql = "SELECT title FROM titles WHERE emp_no = '$codigoEmp' and to_date = '9999-01-01'";
	$query = mysqli_query($db, $sql);
	$result = mysqli_fetch_assoc($query);
	$puesto = $result['title'];
	$_SESSION['title_user'] = $puesto;
?>
<html">
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Bienvenido <?php echo $login_session ;?></h1> 
	  
	  
	  <nav class="dropdownmenu">
	  <?php
	  if ($puesto == 'Manager') {
		echo "<ul>";
			echo "<li><a href='cambiodpto.php'>Cambio de departamento</a></li>";
			echo "<li><a href='cambiosal.php'>Cambio de salario</a></li>";
			echo "<li><a href='cambiocat.php'>Cambio de categoria</a></li>";
			echo "<br/>";
			echo "<li><a href='consultadpto.php'>Historial de departamentos</a></li>";
			echo "<li><a href='consultasal.php'>Historial de salarios</a></li>";
			echo "<li><a href='consultacat.php'>Historial de categorias</a></li>";
		echo "</ul>";
	  
	  }else {
		echo "<ul>";
			echo "<li><a href='consultadpto.php'>Historial de tus departamentos</a></li>";
			echo "<li><a href='consultasal.php'>Historial de tus salarios</a></li>";
			echo "<li><a href='consultacat.php'>Historial de tus categorias</a></li>";
		echo "</ul>";
	  }
	  ?>
	  </nav>
      <h2><a href = "logout.php">Cerrar Sesion</a></h2>
   </body>
   
</html>
