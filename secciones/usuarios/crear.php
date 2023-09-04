<?php include("../../templates/header.php");?>
<?php
    include("../../db.php");

    if($_POST){
        
        $nombre=(isset($_POST["usuario"]) ? $_POST["usuario"] : "");
        $password=(isset($_POST["password"]) ? $_POST["password"] : "");
        $correo=(isset($_POST["correo"]) ? $_POST["correo"] : "");

        //preparamos la insercion en la bd
        $sentencia=$conexion -> prepare("INSERT INTO tbl_usuarios (id,usuario,password,correo) VALUES (null,:usuario,:password,:correo)");

        //asignando los valores q vienen del met post
        $sentencia->bindParam(":usuario",$nombre);
        $sentencia->bindParam(":password",$password);
        $sentencia->bindParam(":correo",$correo);
        $sentencia->execute();
        $mensaje="Registro agregado";
        $_SESSION['mensaje'] =$mensaje;
        header("Location:index.php");
        //header("Location:index.php?mensaje=".$mensaje);
    }

?>    


<br>

<div class="card">
    <div class="card-header">
        Datos del usuarios
    </div>
    <div class="card-body">
        
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre del usuario</label>
                <input type="text"
                    class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Nombre del usuario">                
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">correo</label>
                <input type="correo" class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Escriba su correo">
            </div>

            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>

    </div>
    <div class="card-footer text-muted">
    
    </div>
</div>
<?php include("../../templates/footer.php"); ?>  