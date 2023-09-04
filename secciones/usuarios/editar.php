<?php 
    include("../../db.php");

    if (isset($_GET['txtId'])) {//preguntamos si existe algun id con isset
        $txtId= (isset($_GET['txtId']))?$_GET['txtId']:"";

        //preparamos la eliminacion en la bd
        $sentencia=$conexion -> prepare("SELECT * FROM tbl_usuarios WHERE id=:id");

         //asignando los valores q vienen del met get
        $sentencia->bindParam(":id",$txtId);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_LAZY);//guarda los resultados en un array
        $usuario=$registro['usuario'];
        $password=$registro['password'];
        $correo=$registro['correo'];

    }

    if($_POST){

        $txtId= (isset($_POST['txtId']))?$_POST['txtId']:"";
        $usuario=(isset($_POST["usuario"]) ? $_POST["usuario"] : "");
        $password=(isset($_POST["password"]) ? $_POST["password"] : "");
        $correo=(isset($_POST["correo"]) ? $_POST["correo"] : "");

        //preparamos la insercion en la bd
        $sentencia=$conexion -> prepare("UPDATE tbl_usuarios SET usuario=:usuario, password=:password, correo=:correo  WHERE id=:id");

        //asignando los valores q vienen del met post
        $sentencia->bindParam(":usuario",$usuario);
        $sentencia->bindParam(":password",$password);
        $sentencia->bindParam(":correo",$correo);
        $sentencia->bindParam(":id",$txtId);
        $sentencia->execute();
        
        header("Location:index.php");
        session_start();
        $mensaje="Registro actualizado";
        $_SESSION['mensaje'] =$mensaje;
        exit();
        //$mensaje="Registro actualizado";
        //header("Location:index.php?mensaje=".$mensaje);
    }
    
?>
<?php include("../../templates/header.php");?>

<br>

<div class="card">
    <div class="card-header">
        Datos del usuarios
    </div>
    <div class="card-body">
        
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="txtId" class="form-label">Id</label>
                <input type="text" value="<?php echo $txtId;?>"
                class="form-control" readonly name="txtId" id="txtId" aria-describedby="helpId">
            </div>

            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre del usuario</label>
                <input type="text" value=<?php echo $usuario;?>
                    class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Nombre del usuario">                
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password"  value=<?php echo $password;?>
                class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Password">
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">correo</label>
                <input type="correo" value=<?php echo $correo;?>
                class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Escriba su correo">
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>

    </div>
    <div class="card-footer text-muted">
    
    </div>
</div>
<?php include("../../templates/footer.php"); ?>  