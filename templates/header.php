<?php
session_start();
$base_url="http://localhost/app/";
if(!isset($_SESSION['usuario'])){//si no existe un usuario se redirecciona a login
    header("Location:". $base_url ."./login.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>CRUD</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- para trabjar con jquery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <!-- para dar estilo y funcionabilidad a la tabla -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>   
    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../functions.js"></script>
    </head>
    
    <body onload="nobackbutton();">
    <header>
        <!-- place navbar here -->
    </header>

        <nav class="navbar navbar-expand navbar-light bg-light">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#" aria-current="page">Sistema <span class="visually-hidden">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>secciones/empleados/">Empleados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>secciones/puestos/">Puestos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>secciones/usuarios/">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $base_url;?>cerrar.php">Cerrar Sesion</a>
                </li>
            </ul>
        </nav>

    <main class="container">

    <!-- verifico si se mando algun msj -->
<?php  if(isset($_SESSION['mensaje'])) {?>
    <script>
            Swal.fire({icon:'success', title:'<?php echo $_SESSION['mensaje'];?>'});
    </script>
<?php unset($_SESSION['mensaje']);}?>