<?php
/* @var $this InventarioController */
/* @var $model Inventario */

Yii::app()->clientScript->registerScript('search', "
$('#export-excel').on('click',function() {
    $.fn.export();
});
$.fn.export = function() {
    window.location = '". $this->createUrl('exportexcel')  . "';
    $(\".ajax-loader\").fadeIn('fast');
    setTimeout(function(){ $(\".ajax-loader\").fadeOut('fast'); }, 5000);
}
");

?>

<h3>Salida de papeleria por departamento</h3>

<div class="btn-group" style="padding-bottom: 2%">
    <button type="button" class="btn btn-success" id="export-excel"><i class="fa fa-file-excel-o"></i> Exportar a excel</button>
</div>

<div class="table-responsive">

<?php

$fecha_act = date("Y-m");

$nuevafecha = strtotime ('-4 month', strtotime($fecha_act));
$a = date ('Y', $nuevafecha);
$m = date ('m', $nuevafecha);

$fecha = date('Y-m-d', mktime(0,0,0, $m, 1, $a));

$cadena = '<table class="table table-striped table-hover">';

$cadena .= '<thead><tr><th rowspan = "2">Departamento</th>';

for ($i = 1; $i <= 5 ; $i++) { 
    
    $anio = date("Y", strtotime($fecha));  

    $mes = date("m", strtotime($fecha)); 

    $cadena .= '<th colspan = "2">'.$anio.'-'.$mes.'</th>'; 

    $fecha = strtotime ('+1 month', strtotime($fecha));
    $fecha = date('Y-m-d', $fecha);
}

$cadena .= '</tr>
            <tr>
            <th>PPAP-C</th><th>PPAP-P</th>
            <th>PPAP-C</th><th>PPAP-P</th>
            <th>PPAP-C</th><th>PPAP-P</th>
            <th>PPAP-C</th><th>PPAP-P</th>
            <th>PPAP-C</th><th>PPAP-P</th>
            </tr>
            </thead><tbody>'; 

$departamentos = Departamento::model()->FindAllByAttributes(array('Estado' => 1), array('order'=>'Descripcion'));

$k = 1;

foreach ($departamentos as $deptos) {
   
    if ($k % 2 == 0){
      $clase = 'odd'; 
    }else{
      $clase = 'even'; 
    }

    $cadena .= '<tr class = "'.$clase.'"><td>'.$deptos->Descripcion.'</td>';

    $fecha_act = date("Y-m");

    $nuevafecha = strtotime ('-4 month', strtotime($fecha_act));

    $a = date ('Y', $nuevafecha);
    $m = date ('m', $nuevafecha);

    $fecha = date('Y-m-d', mktime(0,0,0, $m, 1, $a));

    for ($i = 1; $i <= 5 ; $i++) {

        $anio = date("Y", strtotime($fecha));  

        $mes = date("m", strtotime($fecha)); 

        $day_f = date("d", mktime(0,0,0, $mes + 1, 0, $anio));
          
        $fecha_inicial = date('Y-m-d', mktime(0,0,0, $mes, 1, $anio));

        $fecha_final = date('Y-m-d', mktime(0,0,0, $mes, $day_f, $anio));

        $query_PPAP_C ="
        SELECT 
        SUM(i.Cantidad) AS TOTAL_CANT
        FROM TH_INVENTARIO i
        WHERE i.Tipo = 2 AND i.Id_Suministro = ".Yii::app()->params->sum_res_car." AND i.Id_Departamento = ".$deptos->Id_Departamento." AND i.Fecha BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'
        ";
        
        $resp_PPAP_C = Yii::app()->db->createCommand($query_PPAP_C)->queryRow();

        $query_PPAP_P ="
        SELECT 
        SUM(i.Cantidad) AS TOTAL_CANT
        FROM TH_INVENTARIO i
        WHERE i.Tipo = 2 AND i.Id_Suministro = ".Yii::app()->params->sum_res_ofi." AND i.Id_Departamento = ".$deptos->Id_Departamento." AND i.Fecha BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'
        ";

        $resp_PPAP_P = Yii::app()->db->createCommand($query_PPAP_P)->queryRow();


        if($resp_PPAP_C['TOTAL_CANT'] == ''){
            $cc = 0;
        }else{
            $cc = $resp_PPAP_C['TOTAL_CANT'];
        }

        if($resp_PPAP_P['TOTAL_CANT'] == ''){
            $co = 0;
        }else{
            $co = $resp_PPAP_P['TOTAL_CANT'];
        }


        $cadena .= '<td>'.$cc.'</td><td>'.$co.'</td>'; 

        $fecha = strtotime ('+1 month', strtotime($fecha));
        $fecha = date('Y-m-d', $fecha);

    }

    $k++;

}

//totales

$cadena .= '<tr><th>TOTAL</th>';

$fecha_act = date("Y-m");

$nuevafecha = strtotime ('-4 month', strtotime($fecha_act));

$a = date ('Y', $nuevafecha);
$m = date ('m', $nuevafecha);

$fecha = date('Y-m-d', mktime(0,0,0, $m, 1, $a));

for ($i = 1; $i <= 5 ; $i++) {

    $anio = date("Y", strtotime($fecha));  

    $mes = date("m", strtotime($fecha)); 

    $day_f = date("d", mktime(0,0,0, $mes + 1, 0, $anio));
      
    $fecha_inicial = date('Y-m-d', mktime(0,0,0, $mes, 1, $anio));

    $fecha_final = date('Y-m-d', mktime(0,0,0, $mes, $day_f, $anio));

    $query_PPAP_C ="
    SELECT 
    SUM(i.Cantidad) AS TOTAL_CANT
    FROM TH_INVENTARIO i
    WHERE i.Tipo = 2 AND i.Id_Suministro = ".Yii::app()->params->sum_res_car."  AND i.Fecha BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'
    ";
    
    $resp_PPAP_C = Yii::app()->db->createCommand($query_PPAP_C)->queryRow();

    $query_PPAP_P ="
    SELECT 
    SUM(i.Cantidad) AS TOTAL_CANT
    FROM TH_INVENTARIO i
    WHERE i.Tipo = 2 AND i.Id_Suministro = ".Yii::app()->params->sum_res_ofi." AND i.Fecha BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'
    ";

    $resp_PPAP_P = Yii::app()->db->createCommand($query_PPAP_P)->queryRow();


    if($resp_PPAP_C['TOTAL_CANT'] == ''){
        $cc = 0;
    }else{
        $cc = $resp_PPAP_C['TOTAL_CANT'];
    }

    if($resp_PPAP_P['TOTAL_CANT'] == ''){
        $co = 0;
    }else{
        $co = $resp_PPAP_P['TOTAL_CANT'];
    }


    $cadena .= '<th>'.$cc.'</th><th>'.$co.'</th>'; 

    $fecha = strtotime ('+1 month', strtotime($fecha));
    $fecha = date('Y-m-d', $fecha);

}

$cadena .= '</tbody></table>';

echo $cadena;

?>

</div>
