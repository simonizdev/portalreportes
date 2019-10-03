<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

//se reciben los parametros para el reporte

$marca_inicial = $model['marca_inicial'];
$marca_final = $model['marca_final'];

/*inicio configuración array de datos*/

$query ="SET NOCOUNT ON EXEC [dbo].[COM_CONS_ANALISIS_EXT_ITEM] 
@MARCA1 = N'".$marca_inicial."',
@MARCA2 = N'".$marca_final."'
";

$q1 = Yii::app()->db->createCommand($query)->queryAll();

$array_info = array();

foreach ($q1 as $reg) {

  //INFO  DE ITEM
  $Item = $reg ['Item'];
  $I_CRI_UNIDAD_NEGOCIO = $reg ['I_CRI_UNIDAD_NEGOCIO'];
  $Referencia = $reg ['Referencia'];
  $Estado = $reg ['Estado'];
  $FECHA = $reg ['FECHA'];
  $Descripcion = $reg ['Descripcion'];
  $Precio_Actual = $reg ['Precio_Actual'];
  $Cant_Disp = $reg ['Cant_Disp'];
  $Forecast = $reg ['Forecast'];
  $Origen = $reg ['Origen'];
  $Tipo = $reg ['Tipo'];
  $Clase = $reg ['Clase'];
  $Marca = $reg ['Marca'];
  $Segmento = $reg ['Segmento'];
  $Linea = $reg ['Linea'];
  $SubLinea = $reg ['SubLinea'];
  $Categoria = $reg ['Categoria'];
  $Tipo_Item = $reg ['Tipo_Item'];

  //INFO  DE UND
  $Id_UND = $reg ['Id_UND'];
  $Desc_UMD = $reg ['Desc_UMD'];
  $EAN = $reg ['EAN_13'];
  $Cant_UND = $reg ['Cant_UND'];
  
  $array_info[$Item]['info'] = array('I_CRI_UNIDAD_NEGOCIO' => $I_CRI_UNIDAD_NEGOCIO, 'Referencia' => $Referencia, 'Estado' => $Estado, 'FECHA' => $FECHA, 'Descripcion' => $Descripcion, 'Precio_Actual' => $Precio_Actual, 'Cant_Disp' => $Cant_Disp, 'Forecast' => $Forecast, 'Origen' => $Origen, 'Tipo' => $Tipo,'Clase' => $Clase, 'Marca' => $Marca, 'Segmento' => $Segmento,'Linea' => $Linea, 'SubLinea' => $SubLinea, 'Categoria' => $Categoria,'Tipo_Item' => $Tipo_Item);
  
  if(!in_array($EAN, $array_info[$Item])){
    $array_info[$Item]['unds'][] = array('Id_UND' => $Id_UND, 'Desc_UMD' => $Desc_UMD, 'EAN' => $EAN, 'Cant_UND' => $Cant_UND);
  }

}

//EXCEL

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Item');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'UN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Referencia');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Estado');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Fecha');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Descripción');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Precio actual');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Cant. disp.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Forecast');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Origen');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Tipo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Clase');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Marca');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Segmento');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Línea');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Sublínea');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Categoria');
$objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'Tipo item');
$objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'Und. 1');
$objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'Desc. Und. 1');
$objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'EAN 1');
$objPHPExcel->setActiveSheetIndex()->setCellValue('V1', 'Cant. x Und. 1');
$objPHPExcel->setActiveSheetIndex()->setCellValue('W1', 'Und. 2');
$objPHPExcel->setActiveSheetIndex()->setCellValue('X1', 'Desc. Und. 2');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Y1', 'EAN 2');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Z1', 'Cant. x Und. 2');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AA1', 'Und. 3');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AB1', 'Desc. Und. 3');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AC1', 'EAN 3');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AD1', 'Cant. x Und. 3');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AE1', 'Und. 4');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AF1', 'Desc. Und. 4');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AG1', 'EAN 4');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AH1', 'Cant. x Und. 4');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AI1', 'Und. 5');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AJ1', 'Desc. Und. 5');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AK1', 'EAN 5');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AL1', 'Cant. x Und. 5');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AM1', 'Und. 6');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AN1', 'Desc. Und. 6');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AO1', 'EAN 6');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AP1', 'Cant. x Und. 6');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AQ1', 'Und. 7');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AR1', 'Desc. Und. 7');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AS1', 'EAN 7');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AT1', 'Cant. x Und. 7');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AU1', 'Und. 8');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AV1', 'Desc. Und. 8');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AW1', 'EAN 8');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AX1', 'Cant. x Und. 8');


$objPHPExcel->getActiveSheet()->getStyle('A1:AX1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:AX1')->getFont()->setBold(true);

/*Inicio contenido tabla*/

$Fila = 2;

foreach ($array_info as $item => $data) {
    
    //$info = $data['info'];
    $I_CRI_UNIDAD_NEGOCIO = $data['info']['I_CRI_UNIDAD_NEGOCIO']; 
    $Referencia = $data['info']['Referencia']; 
    $Estado = $data['info']['Estado'];
    $FECHA = $data['info']['FECHA'];
    $Descripcion = $data['info']['Descripcion']; 
    $Precio_Actual = $data['info']['Precio_Actual']; 
    $Cant_Disp = $data['info']['Cant_Disp'];
    $Forecast = $data['info']['Forecast']; 
    $Origen = $data['info']['Origen'];
    $Tipo = $data['info']['Tipo'];
    $Clase = $data['info']['Clase']; 
    $Marca = $data['info']['Marca']; 
    $Segmento = $data['info']['Segmento'];
    $Linea = $data['info']['Linea'];
    $SubLinea = $data['info']['SubLinea'];
    $Categoria = $data['info']['Categoria'];
    $Tipo_Item = $data['info']['Tipo_Item'];

    $a_unds = $data['unds'];

    $unds = array();
    $eans = array();
     
    foreach ($a_unds as $reg) {

        if(!in_array($reg['EAN'], $eans)){
            $unds[] = array('Id_UND' => $reg['Id_UND'], 'Desc_UMD' => $reg['Desc_UMD'], 'EAN' => $reg['EAN'], 'Cant_UND' => $reg['Cant_UND']);
            array_push($eans, $reg['EAN']);      
        }
    }

    $num_unds = count($unds);
    
    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $item);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $I_CRI_UNIDAD_NEGOCIO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $Referencia);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $Estado);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $FECHA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $Descripcion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $Precio_Actual);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $Cant_Disp);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $Forecast);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $Origen);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $Tipo);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $Clase);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $Marca);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $Segmento);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $Linea);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $SubLinea);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $Categoria);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila, $Tipo_Item);
    

    if($num_unds == 1){

        $va = $unds[0]['Id_UND']; 
        $vb = $unds[0]['Desc_UMD'];
        $vc = $unds[0]['EAN'];
        $vd = $unds[0]['Cant_UND'];
        
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $va);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $vb);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('U'.$Fila, $vc,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $vd);

        $objPHPExcel->getActiveSheet()->getStyle('U'.$Fila.':V'.$Fila)->getNumberFormat()->setFormatCode('0');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Y'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AC'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AE'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AG'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AH'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AI'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AK'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AL'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AM'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AN'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AO'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AP'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AR'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AS'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AT'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AU'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AV'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AW'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AX'.$Fila, '');

    }

    if($num_unds == 2){

        $va = $unds[0]['Id_UND']; 
        $vb = $unds[0]['Desc_UMD'];
        $vc = $unds[0]['EAN'];
        $vd = $unds[0]['Cant_UND'];
        
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $va);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $vb);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('U'.$Fila, $vc,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $vd);

        $objPHPExcel->getActiveSheet()->getStyle('U'.$Fila.':V'.$Fila)->getNumberFormat()->setFormatCode('0');

        $ve = $unds[1]['Id_UND']; 
        $vf = $unds[1]['Desc_UMD'];
        $vg = $unds[1]['EAN'];
        $vh = $unds[1]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $ve);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $vf);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('Y'.$Fila, $vg,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $vh);

        $objPHPExcel->getActiveSheet()->getStyle('Y'.$Fila.':Z'.$Fila)->getNumberFormat()->setFormatCode('0');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AC'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AE'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AG'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AH'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AI'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AK'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AL'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AM'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AN'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AO'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AP'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AR'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AS'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AT'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AU'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AV'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AW'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AX'.$Fila, '');

    }

    if($num_unds == 3){
        
        $va = $unds[0]['Id_UND']; 
        $vb = $unds[0]['Desc_UMD'];
        $vc = $unds[0]['EAN'];
        $vd = $unds[0]['Cant_UND'];
        
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $va);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $vb);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('U'.$Fila, $vc,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $vd);

        $objPHPExcel->getActiveSheet()->getStyle('U'.$Fila.':V'.$Fila)->getNumberFormat()->setFormatCode('0');

        $ve = $unds[1]['Id_UND']; 
        $vf = $unds[1]['Desc_UMD'];
        $vg = $unds[1]['EAN'];
        $vh = $unds[1]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $ve);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $vf);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('Y'.$Fila, $vg,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $vh);

        $objPHPExcel->getActiveSheet()->getStyle('Y'.$Fila.':Z'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vi = $unds[2]['Id_UND']; 
        $vj = $unds[2]['Desc_UMD'];
        $vk = $unds[2]['EAN'];
        $vl = $unds[2]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, $vi);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila, $vj);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AC'.$Fila, $vk,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila, $vl);

        $objPHPExcel->getActiveSheet()->getStyle('AC'.$Fila.':AD'.$Fila)->getNumberFormat()->setFormatCode('0');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AE'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AG'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AH'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AI'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AK'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AL'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AM'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AN'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AO'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AP'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AR'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AS'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AT'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AU'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AV'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AW'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AX'.$Fila, '');

    }

    if($num_unds == 4){

        $va = $unds[0]['Id_UND']; 
        $vb = $unds[0]['Desc_UMD'];
        $vc = $unds[0]['EAN'];
        $vd = $unds[0]['Cant_UND'];
        
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $va);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $vb);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('U'.$Fila, $vc,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $vd);

        $objPHPExcel->getActiveSheet()->getStyle('U'.$Fila.':V'.$Fila)->getNumberFormat()->setFormatCode('0');

        $ve = $unds[1]['Id_UND']; 
        $vf = $unds[1]['Desc_UMD'];
        $vg = $unds[1]['EAN'];
        $vh = $unds[1]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $ve);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $vf);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('Y'.$Fila, $vg,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $vh);

        $objPHPExcel->getActiveSheet()->getStyle('Y'.$Fila.':Z'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vi = $unds[2]['Id_UND']; 
        $vj = $unds[2]['Desc_UMD'];
        $vk = $unds[2]['EAN'];
        $vl = $unds[2]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, $vi);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila, $vj);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AC'.$Fila, $vk,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila, $vl);

        $objPHPExcel->getActiveSheet()->getStyle('AC'.$Fila.':AD'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vm = $unds[3]['Id_UND']; 
        $vn = $unds[3]['Desc_UMD'];
        $vo = $unds[3]['EAN'];
        $vp = $unds[3]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AE'.$Fila, $vm);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila, $vn);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AG'.$Fila, $vo,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AH'.$Fila, $vp);

        $objPHPExcel->getActiveSheet()->getStyle('AG'.$Fila.':AH'.$Fila)->getNumberFormat()->setFormatCode('0');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AI'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AK'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AL'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AM'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AN'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AO'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AP'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AR'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AS'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AT'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AU'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AV'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AW'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AX'.$Fila, '');

    }

    if($num_unds == 5){

        $va = $unds[0]['Id_UND']; 
        $vb = $unds[0]['Desc_UMD'];
        $vc = $unds[0]['EAN'];
        $vd = $unds[0]['Cant_UND'];
        
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $va);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $vb);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('U'.$Fila, $vc,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $vd);

        $objPHPExcel->getActiveSheet()->getStyle('U'.$Fila.':V'.$Fila)->getNumberFormat()->setFormatCode('0');

        $ve = $unds[1]['Id_UND']; 
        $vf = $unds[1]['Desc_UMD'];
        $vg = $unds[1]['EAN'];
        $vh = $unds[1]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $ve);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $vf);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('Y'.$Fila, $vg,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $vh);

        $objPHPExcel->getActiveSheet()->getStyle('Y'.$Fila.':Z'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vi = $unds[2]['Id_UND']; 
        $vj = $unds[2]['Desc_UMD'];
        $vk = $unds[2]['EAN'];
        $vl = $unds[2]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, $vi);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila, $vj);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AC'.$Fila, $vk,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila, $vl);

        $objPHPExcel->getActiveSheet()->getStyle('AC'.$Fila.':AD'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vm = $unds[3]['Id_UND']; 
        $vn = $unds[3]['Desc_UMD'];
        $vo = $unds[3]['EAN'];
        $vp = $unds[3]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AE'.$Fila, $vm);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila, $vn);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AG'.$Fila, $vo,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AH'.$Fila, $vp);

        $objPHPExcel->getActiveSheet()->getStyle('AG'.$Fila.':AH'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vq = $unds[4]['Id_UND']; 
        $vr = $unds[4]['Desc_UMD'];
        $vs = $unds[4]['EAN'];
        $vt = $unds[4]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AI'.$Fila, $vq);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ'.$Fila, $vr);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AK'.$Fila, $vs,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AL'.$Fila, $vt);

        $objPHPExcel->getActiveSheet()->getStyle('AK'.$Fila.':AL'.$Fila)->getNumberFormat()->setFormatCode('0');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AM'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AN'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AO'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AP'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AR'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AS'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AT'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AU'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AV'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AW'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AX'.$Fila, '');

    }

    if($num_unds == 6){

        $va = $unds[0]['Id_UND']; 
        $vb = $unds[0]['Desc_UMD'];
        $vc = $unds[0]['EAN'];
        $vd = $unds[0]['Cant_UND'];
        
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $va);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $vb);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('U'.$Fila, $vc,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $vd);

        $objPHPExcel->getActiveSheet()->getStyle('U'.$Fila.':V'.$Fila)->getNumberFormat()->setFormatCode('0');

        $ve = $unds[1]['Id_UND']; 
        $vf = $unds[1]['Desc_UMD'];
        $vg = $unds[1]['EAN'];
        $vh = $unds[1]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $ve);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $vf);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('Y'.$Fila, $vg,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $vh);

        $objPHPExcel->getActiveSheet()->getStyle('Y'.$Fila.':Z'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vi = $unds[2]['Id_UND']; 
        $vj = $unds[2]['Desc_UMD'];
        $vk = $unds[2]['EAN'];
        $vl = $unds[2]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, $vi);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila, $vj);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AC'.$Fila, $vk,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila, $vl);

        $objPHPExcel->getActiveSheet()->getStyle('AC'.$Fila.':AD'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vm = $unds[3]['Id_UND']; 
        $vn = $unds[3]['Desc_UMD'];
        $vo = $unds[3]['EAN'];
        $vp = $unds[3]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AE'.$Fila, $vm);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila, $vn);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AG'.$Fila, $vo,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AH'.$Fila, $vp);

        $objPHPExcel->getActiveSheet()->getStyle('AG'.$Fila.':AH'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vq = $unds[4]['Id_UND']; 
        $vr = $unds[4]['Desc_UMD'];
        $vs = $unds[4]['EAN'];
        $vt = $unds[4]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AI'.$Fila, $vq);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ'.$Fila, $vr);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AK'.$Fila, $vs,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AL'.$Fila, $vt);

        $objPHPExcel->getActiveSheet()->getStyle('AK'.$Fila.':AL'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vu = $unds[5]['Id_UND']; 
        $vv = $unds[5]['Desc_UMD'];
        $vw = $unds[5]['EAN'];
        $vx = $unds[5]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AM'.$Fila, $vu);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AN'.$Fila, $vv);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AO'.$Fila, $vw,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AP'.$Fila, $vx);

        $objPHPExcel->getActiveSheet()->getStyle('AO'.$Fila.':AP'.$Fila)->getNumberFormat()->setFormatCode('0');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AR'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AS'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AT'.$Fila, '');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AU'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AV'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AW'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AX'.$Fila, '');

    }

    if($num_unds == 7){

        $va = $unds[0]['Id_UND']; 
        $vb = $unds[0]['Desc_UMD'];
        $vc = $unds[0]['EAN'];
        $vd = $unds[0]['Cant_UND'];
        
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $va);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $vb);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('U'.$Fila, $vc,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $vd);

        $objPHPExcel->getActiveSheet()->getStyle('U'.$Fila.':V'.$Fila)->getNumberFormat()->setFormatCode('0');

        $ve = $unds[1]['Id_UND']; 
        $vf = $unds[1]['Desc_UMD'];
        $vg = $unds[1]['EAN'];
        $vh = $unds[1]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $ve);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $vf);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('Y'.$Fila, $vg,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $vh);

        $objPHPExcel->getActiveSheet()->getStyle('Y'.$Fila.':Z'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vi = $unds[2]['Id_UND']; 
        $vj = $unds[2]['Desc_UMD'];
        $vk = $unds[2]['EAN'];
        $vl = $unds[2]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, $vi);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila, $vj);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AC'.$Fila, $vk,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila, $vl);

        $objPHPExcel->getActiveSheet()->getStyle('AC'.$Fila.':AD'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vm = $unds[3]['Id_UND']; 
        $vn = $unds[3]['Desc_UMD'];
        $vo = $unds[3]['EAN'];
        $vp = $unds[3]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AE'.$Fila, $vm);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila, $vn);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AG'.$Fila, $vo,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AH'.$Fila, $vp);

        $objPHPExcel->getActiveSheet()->getStyle('AG'.$Fila.':AH'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vq = $unds[4]['Id_UND']; 
        $vr = $unds[4]['Desc_UMD'];
        $vs = $unds[4]['EAN'];
        $vt = $unds[4]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AI'.$Fila, $vq);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ'.$Fila, $vr);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AK'.$Fila, $vs,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AL'.$Fila, $vt);

        $objPHPExcel->getActiveSheet()->getStyle('AK'.$Fila.':AL'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vu = $unds[5]['Id_UND']; 
        $vv = $unds[5]['Desc_UMD'];
        $vw = $unds[5]['EAN'];
        $vx = $unds[5]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AM'.$Fila, $vu);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AN'.$Fila, $vv);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AO'.$Fila, $vw,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AP'.$Fila, $vx);

        $objPHPExcel->getActiveSheet()->getStyle('AO'.$Fila.':AP'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vy = $unds[6]['Id_UND']; 
        $vz = $unds[6]['Desc_UMD'];
        $vaa = $unds[6]['EAN'];
        $vab = $unds[6]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ'.$Fila, $vy);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AR'.$Fila, $vz);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AS'.$Fila, $vaa,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AT'.$Fila, $vab);

        $objPHPExcel->getActiveSheet()->getStyle('AS'.$Fila.':AT'.$Fila)->getNumberFormat()->setFormatCode('0');

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AU'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AV'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AW'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AX'.$Fila, '');

    }

    if($num_unds == 8){

        $va = $unds[0]['Id_UND']; 
        $vb = $unds[0]['Desc_UMD'];
        $vc = $unds[0]['EAN'];
        $vd = $unds[0]['Cant_UND'];
        
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $va);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $vb);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('U'.$Fila, $vc,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $vd);

        $objPHPExcel->getActiveSheet()->getStyle('U'.$Fila.':V'.$Fila)->getNumberFormat()->setFormatCode('0');

        $ve = $unds[1]['Id_UND']; 
        $vf = $unds[1]['Desc_UMD'];
        $vg = $unds[1]['EAN'];
        $vh = $unds[1]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $ve);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $vf);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('Y'.$Fila, $vg,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $vh);

        $objPHPExcel->getActiveSheet()->getStyle('Y'.$Fila.':Z'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vi = $unds[2]['Id_UND']; 
        $vj = $unds[2]['Desc_UMD'];
        $vk = $unds[2]['EAN'];
        $vl = $unds[2]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, $vi);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila, $vj);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AC'.$Fila, $vk,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila, $vl);

        $objPHPExcel->getActiveSheet()->getStyle('AC'.$Fila.':AD'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vm = $unds[3]['Id_UND']; 
        $vn = $unds[3]['Desc_UMD'];
        $vo = $unds[3]['EAN'];
        $vp = $unds[3]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AE'.$Fila, $vm);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila, $vn);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AG'.$Fila, $vo,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AH'.$Fila, $vp);

        $objPHPExcel->getActiveSheet()->getStyle('AG'.$Fila.':AH'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vq = $unds[4]['Id_UND']; 
        $vr = $unds[4]['Desc_UMD'];
        $vs = $unds[4]['EAN'];
        $vt = $unds[4]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AI'.$Fila, $vq);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ'.$Fila, $vr);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AK'.$Fila, $vs,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AL'.$Fila, $vt);

        $objPHPExcel->getActiveSheet()->getStyle('AK'.$Fila.':AL'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vu = $unds[5]['Id_UND']; 
        $vv = $unds[5]['Desc_UMD'];
        $vw = $unds[5]['EAN'];
        $vx = $unds[5]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AM'.$Fila, $vu);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AN'.$Fila, $vv);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AO'.$Fila, $vw,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AP'.$Fila, $vx);

        $objPHPExcel->getActiveSheet()->getStyle('AO'.$Fila.':AP'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vy = $unds[6]['Id_UND']; 
        $vz = $unds[6]['Desc_UMD'];
        $vaa = $unds[6]['EAN'];
        $vab = $unds[6]['Cant_UND'];

        $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ'.$Fila, $vy);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AR'.$Fila, $vz);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AS'.$Fila, $vaa,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AT'.$Fila, $vab);

        $objPHPExcel->getActiveSheet()->getStyle('AS'.$Fila.':AT'.$Fila)->getNumberFormat()->setFormatCode('0');

        $vac = $unds[7]['Id_UND']; 
        $vad = $unds[7]['Desc_UMD'];
        $vae = $unds[7]['EAN'];
        $vaf = $unds[7]['Cant_UND'];


        $objPHPExcel->setActiveSheetIndex()->setCellValue('AU'.$Fila, $vac);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AV'.$Fila, $vad);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('AW'.$Fila, $vae,  PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AX'.$Fila, $vaf);

        $objPHPExcel->getActiveSheet()->getStyle('AW'.$Fila.':AX'.$Fila)->getNumberFormat()->setFormatCode('0');

    }


    $Fila = $Fila + 1; 

}

/*fin contenido tabla*/

//se configura el ancho de cada columna en automatico solo funciona en el rango A-Z
foreach($objPHPExcel->getWorksheetIterator() as $worksheet) {

    $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));

    $sheet = $objPHPExcel->getActiveSheet();
    $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(true);
    foreach ($cellIterator as $cell) {
        $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
    }
}

$n = 'Logistica_exterior_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>
