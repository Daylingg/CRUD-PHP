<?php include("../../templates/header.php");?>
<?php
    include("../../db.php");

    if($_POST){
        // print_r($_POST);
        // print_r($_FILES); //para ver la direccion de los ficheros 
        
        $primernombre=(isset($_POST["primernombre"]) ? $_POST["primernombre"] : "");
        $segundonombre=(isset($_POST["segundonombre"]) ? $_POST["segundonombre"] : "");
        $primerapellido=(isset($_POST["primerapellido"]) ? $_POST["primerapellido"] : "");
        $segundoapellido=(isset($_POST["segundoapellido"]) ? $_POST["segundoapellido"] : "");
        $idpuesto=(isset($_POST["idpuesto"]) ? $_POST["idpuesto"] : "");
        $fechaingreso=(isset($_POST["fechaingreso"]) ? $_POST["fechaingreso"] : "");
        $foto=(isset($_FILES["foto"] ['name'] ) ? $_FILES["foto"] ['name'] : "");
        $cv=(isset($_FILES["cv"] ['name']) ? $_FILES["cv"] ['name'] : "");

        //preparamos la insercion en la bd
        $sentencia=$conexion -> prepare("INSERT INTO `tbl_empleados`(`id`, `primernombre`, `segundonombre`, `primerapellido`, `segundoapellido`, `foto`, `cv`, `idpuesto`, `fechaingreso`) VALUES (null,:primernombre,:segundonombre,:primerapellido,:segundoapellido,:foto,:cv,:idpuesto,:fechaingreso)");

        //asignando los valores q vienen del met post
        $sentencia->bindParam(":primernombre",$primernombre);
        $sentencia->bindParam(":segundonombre",$segundonombre);
        $sentencia->bindParam(":primerapellido",$primerapellido);
        $sentencia->bindParam(":segundoapellido",$segundoapellido);

        //codigo para adjuntar la foto y el cv
        $fecha=new DateTime();
        $nombre_archivo_foto=($foto!='')?$fecha->getTimestamp()."_". $_FILES["foto"] ['name'] :"";
        $temp_foto= $_FILES["foto"]['tmp_name'] ;
        
        if($temp_foto!=''){
            move_uploaded_file($temp_foto,"./".$nombre_archivo_foto);
        }

        $nombre_archivo_cv=($cv!='')?$fecha->getTimestamp()."_". $_FILES["cv"] ['name'] :"";
        $temp_cv= $_FILES["cv"]['tmp_name'] ;
        
        if($temp_cv!=''){
            move_uploaded_file($temp_cv,"./".$nombre_archivo_cv);
        }

        $sentencia->bindParam(":foto",$nombre_archivo_foto);
        $sentencia->bindParam(":cv",$nombre_archivo_cv);

        $sentencia->bindParam(":idpuesto",$idpuesto);
        $sentencia->bindParam(":fechaingreso",$fechaingreso);
        
        $sentencia->execute();
        $mensaje="Registro agregado";
        $_SESSION['mensaje'] =$mensaje;
        header("Location:index.php");
        //header("Location:index.php?mensaje=".$mensaje);
    }

    $sentencia=$conexion -> prepare("SELECT * FROM `tbl_puestos`");
    $sentencia->execute();
    $lista_tabla_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    //print_r($lista_tabla_puestos);
?>   


<br>
<div class="card">
    <div class="card-header">
        Datos del empleado
    </div>
    <div class="card-body">
        
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="primernombre" class="form-label">Primer nombre</label>
                <input type="text"
                    class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer nombre ">
                
            </div>

            <div class="mb-3">
                <label for="segundonombre" class="form-label">Segundo nombre</label>
                <input type="text"
                    class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo nombre">
                
            </div>

            <div class="mb-3">
                <label for="primerapellido" class="form-label">Primer apellido</label>
                <input type="text"
                    class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer apellido">
                
            </div>

            <div class="mb-3">
                <label for="segundoapellido" class="form-label">Segundo apellido</label>
                <input type="text"
                    class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo apellido">
                
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Foto</label>
                <input type="file"
                    class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
                
            </div>

            <div class="mb-3">
                <label for="cv" class="form-label">CV(PDF)</label>
                <input type="file" class="form-control" name="cv" id="cv" placeholder="CV" aria-describedby="fileHelpId">
            
            </div>

            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puestos</label>
                <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                    <?php foreach ($lista_tabla_puestos as $registro) { ?>  
                    <option value="<?php echo $registro['id'];?>"><?php echo $registro['nombrepuesto'];?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fechaingreso" class="form-label">Fecha de ingreso</label>
                <input type="date" class="form-control" name="fechaingreso" id="fechaingreso" aria-describedby="emailHelpId" placeholder="">
                
            </div>

            <button type="submit" class="btn btn-success">Agregar registro</button>     
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

        </form>

    </div>
    <div class="card-footer text-muted">
    
    </div>
</div>
<?php include("../../templates/footer.php"); ?>  