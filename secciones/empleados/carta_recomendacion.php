<?php
    
    include("../../db.php");

    if (isset($_GET['txtId'])) {
        $txtId= (isset($_GET['txtId']))?$_GET['txtId']:"";

        $sentencia=$conexion -> prepare("SELECT *, (SELECT nombrepuesto FROM tbl_puestos WHERE tbl_puestos.id=tbl_empleados.idPUESTO limit 1) as puesto  FROM tbl_empleados WHERE id=:id");

        $sentencia->bindParam(":id",$txtId);
        $sentencia->execute();
        $registro=$sentencia->fetch(PDO::FETCH_LAZY);//guarda los resultados en un array

        $primernombre=$registro['primernombre'];
        $segundonombre=$registro['segundonombre'];
        $primerapellido=$registro['primerapellido'];
        $segundoapellido=$registro['segundoapellido'];

        $nombre_completo=$primernombre ." ".$segundonombre ." ".$primerapellido ." ".$segundoapellido;

        $foto=$registro['foto'];
        $cv=$registro['cv'];
        $puesto=$registro['puesto'];
        $fechaingreso=$registro['fechaingreso'];

        $fecha_inicio= new DateTime($fechaingreso);
        $fecha_fin= new DateTime(date('Y-m-d'));
        $diferencia=date_diff($fecha_inicio,$fecha_fin);

    }

    ob_start(); //quiere decir q todo lo q esta despues de esta instruccion se va a recolectar y se puede almacenar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Recomendacion</title>
</head>
<body>
    <h1>Carta de Recomendacion Laboral</h1>
    <br><br>
    Matanzas, Cuba a <strong><?php echo date('d M Y')?></strong>
    <br><br>
    A quien pueda interesar:
    <br><br>
    Reciba un cordial y respetuoso saludo
    <br><br>
    A traves de estas lineas quiero hacer de su conocimiento que el Sr(a) <strong><?php echo $nombre_completo?></strong> quien trabajo en mi organizacion <strong><?php echo $diferencia->y?> año(s)</strong> es un ciudadano intachable. Ha demostrado ser un gran trabajador comprometido y responsablecon sus tareas.
    Siempre ha mostrado interes por superarse y actualizar sus conocimientos.
    <br><br>
    Durante estos años se ha desempeñado como <strong><?php echo $puesto?></strong>.
    Es por ellos le sugiero considere q va a estar siempre a la altura de sus responsabilidades
    <br><br>
    Sin mas nad a que referirme y esperando que esta carta sea tomada en cuenta dejo mi numero de contacto para cualquier informacion de interes
    <br><br><br><br><br><br><br>
    ____________________________________<br>
    Atentamente
    <br>
    Igr Ibrain Garcia Chente
</body>
</html>
<?php
$HTML=ob_get_clean(); //para recolectar todo el html...pero antes debe iniciarse con el start
require_once('../../libs/autoload.inc.php'); //se incluye la libreria para poder usarla y convertir a pdf

use Dompdf\Dompdf; //para usar esta clase

$dompdf= new Dompdf(); //creamos el obj

$opciones=$dompdf->getOptions(); //para incluir las opciones
$opciones->set(array("isRemoteEnabled"=>true)); //asignacion de consulta remota

$dompdf->setOptions($opciones); //se le pasan las opciones 

//se le pasa un doc html usando varios parametros
$dompdf->loadHTML($HTML);

$dompdf->setPaper("letter");
$dompdf->render();
$dompdf->stream("archivo.pdf",array("Attachment"=>false)); //para adjuntar el archivo
?>