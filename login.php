<?php
session_start();// al usar esto se pueden usar las variables de sesion

if($_POST){ //si hay un envio post vamos a validar q lo q se envia este en la bd
    include('./db.php');

    $sentencia=$conexion -> prepare("SELECT *, count(*) as n_usuarios FROM `tbl_usuarios`
    WHERE usuario=:usuario AND password=:password");

    $usuario=$_POST["usuario"];
    $password=$_POST["password"];

    $sentencia->bindParam(":usuario",$usuario);
    $sentencia->bindParam(":password",$password);

    $sentencia->execute();
    $registro=$sentencia->fetch(PDO::FETCH_LAZY);//guarda la consulta select

    if($registro['n_usuarios']>0){//si en registro el atributo n_usuarios es mayor q cero quiere q decir q existe un usuario para oguearse y abrir sesion
        $_SESSION['usuario']=$registro['usuario'];//guardamos el usuario
        $_SESSION['logueado']=true; //pasamos el logueado a true
        
        header("Location:index.php");
    }else{
        $mensaje="Error, el usuario o contraseña es incorrecto";
    }
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

</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main class="container">

        <div class="row">
            <div class="col-md-4"></div>
            
            <div class="col-md-4">
            <br><br>
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">

                        <?php if(isset($mensaje)){?>  <!--si el msj tiene algo q lo imprima -->
                            <div class="alert alert-danger" role="alert">
                                <strong><?php echo $mensaje;?></strong> 
                            </div>
                        <?php }?>

                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario:</label>
                                <input type="text"
                                class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Escriba su usuario" autocomplete="off" >
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Escriba su contraseña" autocomplete="off" >
                            </div>

                            <button type="submit" class="btn btn-primary">Entrar al Sistema</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
        

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>