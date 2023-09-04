<?php
    include("../../db.php");

    if (isset($_GET['txtId'])) {//preguntamos si existe algun id con isset
        $txtId= (isset($_GET['txtId']))? $_GET['txtId'] :"";

        //preparamos la eliminacion en la bd
        $sentencia=$conexion -> prepare("DELETE FROM tbl_puestos WHERE id=:id");

         //asignando los valores q vienen del met get
        $sentencia->bindParam(":id",$txtId);
        $sentencia->execute();
        $mensaje="Registro eliminado";
        header("Location:index.php?mensaje=".$mensaje);
        
    }

    $sentencia=$conexion -> prepare("SELECT * FROM `tbl_puestos`");//prepara la coneccion para q seleccione lo q hay en puestos
    $sentencia->execute();//ejecuta la sentencia
    $lista_tabla_puestos=$sentencia->fetchAll(PDO::FETCH_ASSOC);//guarda los resultados en un array
    //print_r($lista_tabla_puestos);
    
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
                        <th scope="col">ID</th>
                        <th scope="col">Nombre del puesto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <!-- segun la cant de elementos q haya en el foreach se repetiran las filas -->
                <?php foreach ($lista_tabla_puestos as $registro) { ?>
                    <tr class="">
                        <td scope="row"><?php echo $registro['id'];?></td>
                        <td><?php echo $registro['nombrepuesto'];?></td>
                        <td>
                            <a name="" id="" class="btn btn-info" href="editar.php?txtId=<?php echo $registro['id'];?>" role="button">Editar</a>
                            <a name="" id="" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id'];?>)" role="button">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
                
                </tbody>
            </table>
        </div>

    </div>
    
</div>
<?php include("../../templates/footer.php"); ?>  