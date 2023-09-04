<?php include("../../templates/header.php");?>
<?php
    include("../../db.php");

    if (isset($_GET['txtId'])) {//preguntamos si existe algun id con isset
        $txtId= (isset($_GET['txtId']))?$_GET['txtId']:"";

        //preparamos la eliminacion en la bd
        $sentencia=$conexion -> prepare("SELECT * FROM tbl_puestos WHERE id=:id");

         //asignando los valores q vienen del met get
        $sentencia->bindParam(":id",$txtId);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_LAZY);//guarda los resultados en un array
        $nombrepuesto=$registro['nombrepuesto'];

    }

    if($_POST){

        $txtId= (isset($_POST['txtId']))?$_POST['txtId']:"";
        //isset($_POST["nombrepuesto"]) pregunt si existe un nombre de puesto...$_POST["nombrepuesto"] recolecta lo del met post
        $nombre_puesto=(isset($_POST["nombrepuesto"]) ? $_POST["nombrepuesto"] : "");

        //preparamos la insercion en la bd
        $sentencia=$conexion -> prepare("UPDATE tbl_puestos SET nombrepuesto=:nombrepuesto  WHERE id=:id");

        //asignando los valores q vienen del met post
        $sentencia->bindParam(":nombrepuesto",$nombre_puesto);
        $sentencia->bindParam(":id",$txtId);
        $sentencia->execute();
        $mensaje="Registro actualizado";
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
            <label for="txtId" class="form-label">Id</label>
            <input type="text" value="<?php echo $txtId;?>"
            class="form-control" readonly name="txtId" id="txtId" aria-describedby="helpId">
        </div>

            <div class="mb-3">
                <label for="nombrepuesto" class="form-label">Nombre del puesto</label>
                <input type="text" value="<?php echo $nombrepuesto;?>"
                    class="form-control" name="nombrepuesto" id="nombrepuesto" aria-describedby="helpId" >                
            </div>

            <button type="submit" class="btn btn-success" >Actualizar</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>

    </div>
    <div class="card-footer text-muted">
    
    </div>
</div>
<?php include("../../templates/footer.php"); ?>  