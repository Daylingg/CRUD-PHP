<?php include("../../templates/header.php");?>
<?php
    include("../../db.php");

    if (isset($_GET['txtId'])) {
        $txtId= (isset($_GET['txtId']))?$_GET['txtId']:"";

        $sentencia=$conexion -> prepare("SELECT * FROM tbl_empleados WHERE id=:id");

        $sentencia->bindParam(":id",$txtId);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_LAZY);//guarda los resultados en un array
        $primernombre=$registro['primernombre'];
        $segundonombre=$registro['segundonombre'];
        $primerapellido=$registro['primerapellido'];
        $segundoapellido=$registro['segundoapellido'];
        $foto=$registro['foto'];
        $cv=$registro['cv'];
        $idpuesto=$registro['idpuesto'];
        $fechaingreso=$registro['fechaingreso'];

        $sentencia=$conexion -> prepare("SELECT * FROM `tbl_puestos`");
        $sentencia->execute();
        $lista_tabla_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    }

    if($_POST){

        $txtId= (isset($_POST['txtId']))?$_POST['txtId']:"";
        $primernombre=(isset($_POST["primernombre"]) ? $_POST["primernombre"] : "");
        $segundonombre=(isset($_POST["segundonombre"]) ? $_POST["segundonombre"] : "");
        $primerapellido=(isset($_POST["primerapellido"]) ? $_POST["primerapellido"] : "");
        $segundoapellido=(isset($_POST["segundoapellido"]) ? $_POST["segundoapellido"] : "");
        $idpuesto=(isset($_POST["idpuesto"]) ? $_POST["idpuesto"] : "");
        $fechaingreso=(isset($_POST["fechaingreso"]) ? $_POST["fechaingreso"] : "");
    
        $sentencia=$conexion -> prepare("UPDATE `tbl_empleados` SET `primernombre`=:primernombre, `segundonombre`=:segundonombre, `primerapellido`=:primerapellido, `segundoapellido`=:segundoapellido, `idpuesto`=:idpuesto, `fechaingreso`=:fechaingreso WHERE id=:id");

        //asignando los valores q vienen del met post
        $sentencia->bindParam(":primernombre",$primernombre);
        $sentencia->bindParam(":segundonombre",$segundonombre);
        $sentencia->bindParam(":primerapellido",$primerapellido);
        $sentencia->bindParam(":segundoapellido",$segundoapellido);
        // 
        // $sentencia->bindParam(":cv",$nombre_archivo_cv);
        $sentencia->bindParam(":idpuesto",$idpuesto);
        $sentencia->bindParam(":fechaingreso",$fechaingreso);
        $sentencia->bindParam(":id",$txtId);
        $sentencia->execute();
        
        //como el cv y la foto son archivos se actualizan aparte
        $fecha=new DateTime();
        $foto=(isset($_FILES["foto"] ['name'] ) ? $_FILES["foto"] ['name'] : "");
        
        $nombre_archivo_foto=($foto!='')?$fecha->getTimestamp()."_". $_FILES["foto"] ['name'] :"";
        $temp_foto= $_FILES["foto"]['tmp_name'] ;
        //si existe algo en temp_foto se elimina la vieja y actualiza con la nueva
        if($temp_foto!=''){
            move_uploaded_file($temp_foto,"./".$nombre_archivo_foto);

            $sentencia=$conexion -> prepare("SELECT foto FROM tbl_empleados WHERE id=:id");
            $sentencia->bindParam(":id",$txtId);
            $sentencia->execute();

            $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY);
            //es para eliminar la foto 
            if(isset($registro_recuperado['foto']) && $registro_recuperado['foto']!=""){
                if(file_exists('./'.$registro_recuperado['foto'])){
                    unlink('./'.$registro_recuperado['foto']);
                }
            }

            $sentencia=$conexion -> prepare("UPDATE `tbl_empleados` SET foto=:foto WHERE id=:id");
            $sentencia->bindParam(":foto",$nombre_archivo_foto);
            $sentencia->bindParam(":id",$txtId);
            $sentencia->execute();
        }

        $cv=(isset($_FILES["cv"] ['name']) ? $_FILES["cv"] ['name'] : "");
        $nombre_archivo_cv=($cv!='')?$fecha->getTimestamp()."_". $_FILES["cv"] ['name'] :"";
        $temp_cv= $_FILES["cv"]['tmp_name'] ;
        //si existe algo en temp_foto se elimina la vieja y actualiza con la nueva
        if($temp_cv!=''){
            move_uploaded_file($temp_cv,"./".$nombre_archivo_cv);

            $sentencia=$conexion -> prepare("SELECT cv FROM tbl_empleados WHERE id=:id");
            $sentencia->bindParam(":id",$txtId);
            $sentencia->execute();

            $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY);
            //es para eliminar el pdf 
            if(isset($registro_recuperado['cv']) && $registro_recuperado['cv']!=""){
                if(file_exists('./'.$registro_recuperado['cv'])){
                    unlink('./'.$registro_recuperado['cv']);
                }
            }

            $sentencia=$conexion -> prepare("UPDATE `tbl_empleados` SET cv=:cv WHERE id=:id");
            $sentencia->bindParam(":cv",$nombre_archivo_cv);
            $sentencia->bindParam(":id",$txtId);
            $sentencia->execute();
        }

        
        $mensaje="Registro actualizado";
        $_SESSION['mensaje'] =$mensaje;
        header("Location:index.php");
        //header("Location:index.php?mensaje=".$mensaje);
    }
    
?>


<br>
<div class="card">
    <div class="card-header">
        Datos del empleado
    </div>
    <div class="card-body">
        
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="txtId" class="form-label">Id</label>
                <input type="text" value="<?php echo $txtId;?>"
                class="form-control" readonly name="txtId" id="txtId" aria-describedby="helpId">
            </div>

            <div class="mb-3">
                <label for="primernombre" class="form-label">Primer nombre</label>
                <input type="text" value="<?php echo $primernombre;?>"
                    class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer nombre ">
                
            </div>

            <div class="mb-3">
                <label for="segundonombre" class="form-label">Segundo nombre</label>
                <input type="text" value="<?php echo $segundonombre;?>"
                    class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo nombre">
                
            </div>

            <div class="mb-3">
                <label for="primerapellido" class="form-label">Primer apellido</label>
                <input type="text" value="<?php echo $primerapellido;?>"
                    class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer apellido">
                
            </div>

            <div class="mb-3">
                <label for="segundoapellido" class="form-label">Segundo apellido</label>
                <input type="text" value="<?php echo $segundoapellido;?>"
                    class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo apellido">
                
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Foto:</label>
                <img src="<?php echo $foto;?>" width="50" class="img-fluid rounded" alt="">
                <input type="file" value=""
                    class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
                
            </div>

            <div class="mb-3">
                <label for="cv" class="form-label">CV(PDF):</label>
                <a href="<?php echo $cv;?>"><?php echo $cv;?></a> 
                <input type="file"  value=""
                class="form-control" name="cv" id="cv" placeholder="CV" aria-describedby="fileHelpId">
            
            </div>

            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puestos:</label>
                <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                    <?php foreach ($lista_tabla_puestos as $registro) { ?>  
                    <option <?php echo ($idpuesto==$registro['id'])?"selected":"";  ?> value="<?php echo $registro['id'];?>"><?php echo $registro['nombrepuesto'];?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fechaingreso" class="form-label">Fecha de ingreso</label>
                <input type="date"  value="<?php echo $fechaingreso;?>"
                class="form-control" name="fechaingreso" id="fechaingreso" aria-describedby="emailHelpId" placeholder="">
                
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>     
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>

    </div>
    <div class="card-footer text-muted">
    
    </div>
</div>
<?php include("../../templates/footer.php"); ?>  