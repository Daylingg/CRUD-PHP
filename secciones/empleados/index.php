<?php
    include("../../db.php");

    if (isset($_GET['txtId'])) {
        $txtId= (isset($_GET['txtId']))?$_GET['txtId']:"";

        $sentencia=$conexion -> prepare("SELECT foto, cv FROM tbl_empleados WHERE id=:id");
        $sentencia->bindParam(":id",$txtId);
        $sentencia->execute();

        $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY);
        //es para eliminar la foto y el cv
        if(isset($registro_recuperado['foto']) && $registro_recuperado['foto']!=""){
            if(file_exists('./'.$registro_recuperado['foto'])){
                unlink('./'.$registro_recuperado['foto']);
            }
        }
        if(isset($registro_recuperado['cv']) && $registro_recuperado['cv']!=""){
            if(file_exists('./'.$registro_recuperado['cv'])){
                unlink('./'.$registro_recuperado['cv']);
            }
        }
        //preparamos la eliminacion en la bd
        $sentencia=$conexion -> prepare("DELETE FROM tbl_empleados WHERE id=:id");

        $sentencia->bindParam(":id",$txtId);
        $sentencia->execute();
        $mensaje="Registro eliminado";
        header("Location:index.php?mensaje=".$mensaje);
    }

    $sentencia=$conexion -> prepare("SELECT *, (SELECT nombrepuesto FROM tbl_puestos WHERE tbl_puestos.id=tbl_empleados.idPUESTO limit 1) as puesto  FROM `tbl_empleados`");
    $sentencia->execute();
    $lista_tabla_empleados=$sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include("../../templates/header.php");?>

<br>
<div class="card">
    <div class="card-header">
    
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar registro</a>
    </div>
    <div class="card-body">
        
        <div class="table-responsive-sm">
            <table class="table " id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Foto</th>
                        <th scope="col">CV</th>
                        <th scope="col">Puesto</th>
                        <th scope="col">Fecha ingreso</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_tabla_empleados as $registro) { ?>
                    <tr class="">
                        <td><?php echo $registro['id'];?></td>
                        <td scope="row"><?php echo $registro['primernombre'] ." ". $registro['segundonombre'] ." ". $registro['primerapellido'] ." ". $registro['segundoapellido'];?></td>
                        <td>
                            <img src="<?php echo $registro['foto'];?>" width="50" class="img-fluid rounded" alt="">
                        </td>
                        <td><a href="<?php echo $registro['cv'];?>"><?php echo $registro['cv'];?></a></td>
                        <td><?php echo $registro['puesto'];?></td>
                        <td><?php echo $registro['fechaingreso'];?></td>
                        <td>
                        <a name="" id="" class="btn btn-primary" href="carta_recomendacion.php?txtId=<?php echo $registro['id'];?>" role="button">Carta</a>
                            |<a name="" id="" class="btn btn-info" href="editar.php?txtId=<?php echo $registro['id'];?>" role="button">Editar</a>
                            |<a name="" id="" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id'];?>)" role="button">Eliminar</a>
                        </td>
                    </tr>
                    <?php };?>
                </tbody>
            </table>
        </div>
        

    </div>
    
</div>
<?php include("../../templates/footer.php"); ?>  