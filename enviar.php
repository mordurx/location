<?php
require ('ConectarBaseDatos.php');
if($_POST){
   //echo "recibo algo POST";
   
   //recibo los datos y los decodifico con PHP
   $misDatosJSON = json_decode($_POST["datos"]);
   
   //con esto podría mostrar todos los datos del JSON recibido
   //print_r($misDatosJSON);
   
   //ahora muestro algún dato de este array bidimiesional
   //$salida = "";
   //$salida .= "Capital de Francia: " . $misDatosJSON[0][0]." ".$misDatosJSON[0][1]." ".$misDatosJSON[0][2];
   $NombreOjb1=$misDatosJSON[0][0];
   $Obj1_X=$misDatosJSON[0][1];
   $Obj1_Y=$misDatosJSON[0][2];
   // objeto2
   $NombreOjb2=$misDatosJSON[1][0];
   $Obj2_X=$misDatosJSON[1][1];
   $Obj2_Y=$misDatosJSON[1][2];
   // pendiente
   $angulo=GetAngulo($Obj2_X,$Obj1_X,$Obj2_Y,$Obj1_Y);
   $distancia=GetDistancia($Obj2_X,$Obj1_X,$Obj2_Y,$Obj1_Y);
   $NombreOjb1_array = explode("-", $NombreOjb1);
   $NombreOjb2_array = explode("-", $NombreOjb2);
   $NombreOjb1=$NombreOjb1_array[1];
   $NombreOjb2=$NombreOjb2_array[1];
   $con=ConectarDB();
   echo $NombreOjb1;
   echo $NombreOjb2;
   $respuesta=InsertarMuestra($Obj2_X,$Obj1_X,$Obj2_Y,$Obj1_Y,$NombreOjb1, $NombreOjb2,$angulo,$con,$distancia);

}
else{
   echo "No recibí datos por POST";
}

function GetDistancia($X2,$X1,$Y2,$Y1)
{   
   $a=$X2-$X1;
   $b=$Y2-$Y1;
   $a=pow($a, 2);
   $b=pow($b, 2);
   $distancia=sqrt($a+$b);
   return $distancia;
}

function GetAngulo($X2,$X1,$Y2,$Y1)
{ 
   
   $pendiente=($Y2-$Y1)/($X2-$X1);
   $angulo_rad=atan($pendiente);
   $angulo=abs(rad2deg($angulo_rad)); 
   return $angulo;
}
function InsertarMuestra($X2,$X1,$Y2,$Y1,$NombreOjb1,$NombreOjb2,$angulo,$con,$distancia)
{   
  echo $X1,$Y1;
   
   
   
   $sql1="select id_simbol from simbologia where signo=$NombreOjb1";

    if (!$resultado = $con->query($sql1)) {
        // ¡Oh, no! La consulta falló. 
        $error=mysqli_error($con);
        echo $error;
        exit();
    }
    $arr_simbol1=$resultado->fetch_assoc();
    $id_simbol_1=$arr_simbol1['id_simbol'];
    echo $id_simbol_1;

    $sql1="select id_simbol from simbologia where signo=$NombreOjb2";

    if (!$resultado = $con->query($sql1)) {
        // ¡Oh, no! La consulta falló. 
        $error=mysqli_error($con);
        echo $error;
        exit();
    }
    $arr_simbol2=$resultado->fetch_assoc();
    $id_simbol_2=$arr_simbol2['id_simbol'];
    echo $id_simbol_2;

    $sql = "INSERT INTO encuestas (obj1_simbol,obj1_Xpos ,obj1_Ypos ,obj2_simbol,obj2_Xpos,obj2_Ypos ,angulo,distancia)values($id_simbol_1,$X1,$Y1,$id_simbol_2,$X2,$Y2,$angulo,$distancia)";
    if (!$resultado = $con->query($sql)) 
    {
            $error=mysqli_error($con);
            echo $error;
            exit();
    }
}
?>

