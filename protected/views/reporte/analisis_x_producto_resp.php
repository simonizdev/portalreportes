<?php
/* @var $this ReporteController */
/* @var $model Reporte */

set_time_limit(0);

// *********** traducciones y modificaciones de fechas a letras y a español ***********
$ding=array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
$ming=array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$mesp=array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$desp=array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
$mesn=array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');


//array con titulos de meses

$mes_act=date('F');

$clave = array_search($mes_act, $ming);

$cont = $clave - 1;

$array_titulo_meses = array();

for ($i=1; $i <= 12; $i++) { 

  $m = str_replace($ming, $mesp, $ming[$clave]);
  $mes = strtoupper($m);
  $mes_abrev = substr($mes, 0, 3);

  $array_titulo_meses[] = $mes_abrev;
  if($clave == 11){

    $clave = 0;
  
  }else{
  
    $clave++;
  
  }
}

/*inicio configuración array de datos*/

$query ="EXEC [dbo].[COM_CONS_ANALISIS_ITEM]";

//echo $query;die;

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

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'ITEM');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'REFERENCIA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'DESCRIPCIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'ESTADO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'INVENTARIO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'PRECIO LISTA 001');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'PRECIO LISTA 560');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'TIPO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'LOTE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'STOCK');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'CÓDIGO DE BARRAS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'UNIDAD DE NEGOCIO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'MARCA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'ORIGEN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'TIPO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'CLASIFICACIÓN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'CLASE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'SEGMENTO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'LÍNEA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'SUB-LÍNEA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'UNIDAD DE NEGOCIO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('V1', 'ORACLE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('W1', $array_titulo_meses[0]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('X1', $array_titulo_meses[1]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('Y1', $array_titulo_meses[2]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('Z1', $array_titulo_meses[3]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('AA1', $array_titulo_meses[4]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('AB1', $array_titulo_meses[5]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('AC1', $array_titulo_meses[6]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('AD1', $array_titulo_meses[7]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('AE1', $array_titulo_meses[8]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('AF1', $array_titulo_meses[9]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('AG1', $array_titulo_meses[10]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('AH1', $array_titulo_meses[11]);
$objPHPExcel->setActiveSheetIndex()->setCellValue('AI1', 'PROM. VENTAS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AJ1', 'BASE');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AK1', 'EXIST. A LA FECHA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AL1', 'O.C PEND.');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AM1', 'ROTACIÓN');


$objPHPExcel->getActiveSheet()->getStyle('A1:AM1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:AM1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $I_ID_ITEM = $reg1 ['I_ID_ITEM']; 
    $I_REFERENCIA = $reg1 ['I_REFERENCIA']; 
    $I_DESCRIPCION = $reg1 ['I_DESCRIPCION'];
    $I_ESTADO = $reg1 ['I_ESTADO'];
    $I_INVENTARIO = $reg1 ['I_INVENTARIO'];
    $Pre_L001 = $reg1 ['Pre_L001'];    
    $Pre_L560 = $reg1 ['Pre_L560']; 
    $I_TIPO = $reg1 ['I_TIPO'];
    $I_LOTE = $reg1 ['I_LOTE'];
    $I_STOCK = $reg1 ['I_STOCK'];
    $I_CODIGO_BARRAS = $reg1 ['I_CODIGO_BARRAS'];
    $I_UNIDAD_NEGOCIO = $reg1 ['I_UNIDAD_NEGOCIO'];    
    $I_CRI_MARCA = $reg1 ['I_CRI_MARCA']; 
    $I_CRI_ORIGEN = $reg1 ['I_CRI_ORIGEN'];
    $I_CRI_TIPO = $reg1 ['I_CRI_TIPO'];
    $I_CRI_CLASIFICACION = $reg1 ['I_CRI_CLASIFICACION'];
    $I_CRI_CLASE = $reg1 ['I_CRI_CLASE'];
    $I_CRI_SEGMENTO = $reg1 ['I_CRI_SEGMENTO'];    
    $I_CRI_LINEA = $reg1 ['I_CRI_LINEA']; 
    $I_CRI_SUBLINEA = $reg1 ['I_CRI_SUBLINEA'];
    $I_CRI_UNIDAD_NEGOCIO = $reg1 ['I_CRI_UNIDAD_NEGOCIO'];
    $I_CRI_ORACLE = $reg1 ['I_CRI_ORACLE'];
    $CI_MES1 = $reg1 ['CI_MES1'];
    $CI_MES2 = $reg1 ['CI_MES2'];    
    $CI_MES3 = $reg1 ['CI_MES3']; 
    $CI_MES4 = $reg1 ['CI_MES4'];
    $CI_MES5 = $reg1 ['CI_MES5'];
    $CI_MES6 = $reg1 ['CI_MES6'];
    $CI_MES7 = $reg1 ['CI_MES7'];
    $CI_MES8 = $reg1 ['CI_MES8'];    
    $CI_MES9 = $reg1 ['CI_MES9']; 
    $CI_MES10 = $reg1 ['CI_MES10'];
    $CI_MES11 = $reg1 ['CI_MES11'];
    $CI_MES12 = $reg1 ['CI_MES12'];
    $PROMEDIO_VTAS = $reg1 ['PROMEDIO_VTAS'];
    $BASE = $reg1 ['BASE'];
    $EXISTENCIA = $reg1 ['EXISTENCIA'];
    $OC_PEND = $reg1 ['OC_PEND'];
    $ROTACION = $reg1 ['ROTACION'];
    
    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $I_ID_ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $I_REFERENCIA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $I_DESCRIPCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $I_ESTADO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $I_INVENTARIO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $Pre_L001);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $Pre_L560);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $I_TIPO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $I_LOTE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $I_STOCK);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$Fila, $I_CODIGO_BARRAS,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila, $I_UNIDAD_NEGOCIO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $I_CRI_MARCA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $I_CRI_ORIGEN);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $I_CRI_TIPO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $I_CRI_CLASIFICACION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $I_CRI_CLASE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila, $I_CRI_SEGMENTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $I_CRI_LINEA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $I_CRI_SUBLINEA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, $I_CRI_UNIDAD_NEGOCIO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $I_CRI_ORACLE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $CI_MES12);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $CI_MES11);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Y'.$Fila, $CI_MES10);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $CI_MES9);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, $CI_MES8);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila, $CI_MES7);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AC'.$Fila, $CI_MES6);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila, $CI_MES5);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AE'.$Fila, $CI_MES4);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila, $CI_MES3);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AG'.$Fila, $CI_MES2);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AH'.$Fila, $CI_MES1);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AI'.$Fila, $PROMEDIO_VTAS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ'.$Fila, $BASE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AK'.$Fila, $EXISTENCIA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AL'.$Fila, $OC_PEND);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AM'.$Fila, $ROTACION);

    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila.':G'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila.':G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila.':J'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('I'.$Fila.':J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('W'.$Fila.':AJ'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('W'.$Fila.':AJ'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('AK'.$Fila.':AL'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('AK'.$Fila.':AL'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('W'.$Fila.':AJ'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('W'.$Fila.':AJ'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


    /*$objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':D'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila.':K'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);*/

    $Fila = $Fila + 1; 
      
  }
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

$n = 'Analisis_x_producto_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>
