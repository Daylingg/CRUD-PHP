<?php include("../../templates/header.php");?>
<?php   include("../../db.php");

    if($_POST){
        //print_r($_POST); //$_POST recolecta los datos del met post
        //isset($_POST["nombrepuesto"]) pregunt si existe un nombre de puesto
        $nombre_puesto=(isset($_POST["nombrepuesto"]) ? $_POST["nombrepuesto"] : "");

        //preparamos la insercion en la bd
        $sentencia=$conexion -> prepare("INSERT INTO tbl_puestos(id,nombrepuesto) VALUES (null, :nombrepuesto)");

        //asignando los valores q vienen del met post
        $sentencia->bindParam(":nombrepuesto",$nombre_puesto);
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
        Puestos
    </div>
    <div class="card-body">
        
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="nombrepuesto" class="form-label">Nombre del puesto</label>
                <input type="text"
                    class="form-control" name="nombrepuesto" id="nombrepuesto" aria-describedby="helpId" placeholder="Nombre del puesto">                
            </div>

            <button type="submit" class="btn btn-success" >Agregar</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>

    </div>
    <div class="card-footer text-muted">
    
    </div>
</div>
<?php include("../../templates/footer.php"); ?>  