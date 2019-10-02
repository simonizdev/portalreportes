<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte

set_time_limit(0);

/*inicio configuración array de datos*/

$query ="
  SELECT DISTINCT
  t1.[Compania] as CIA
  ,t1.[Cent_Operacion] as CENTRO_OP
  ,t1.[Docto] as DOCUMENTO
  ,t1.[Num_Docto] as NUM_PEDIDO
  ,CASE WHEN t1.[Integrado] = 0 THEN 'NO' ELSE 'SI' END AS LEIDO_WMS
  ,CONVERT(nvarchar,t1.[FechaRegistro],103) as ENTREGADO_A_WMS
  ,ISNULL(CONVERT(nvarchar,t2.[FechaRegistro],103),'NO') AS LIBERADO_WMS
  FROM [Repositorio_Datos].[dbo].[Ped_Ven_Comp_Simoniz] as t1
  LEFT JOIN [Repositorio_Datos].[dbo].FacturaSIMONIZ_Detalles as t2 on CentroOperacion=[Cent_Operacion] and Tipo_Docto=[Docto] and DocumentoPedido=[Num_Docto]
  WHERE t2.[FechaRegistro] >= dateadd(DAY,-1,getdate())
  ORDER BY 7 DESC
";

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Cia');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'CO');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Tipo Docto');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Consecutivo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Leido por WMS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Entregado a WMS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Liberado por WMS');

$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

$q1 = Yii::app()->db->createCommand($query)->queryAll();

if(!empty($q1)){
  foreach ($q1 as $reg1) {

    $CIA              = $reg1 ['CIA']; 
    $CENTRO_OP        = $reg1 ['CENTRO_OP']; 
    $DOCUMENTO        = $reg1 ['DOCUMENTO'];
    $NUM_PEDIDO       = $reg1 ['NUM_PEDIDO'];
    $LEIDO_WMS        = $reg1 ['LEIDO_WMS'];
    $ENTREGADO_A_WMS  = $reg1 ['ENTREGADO_A_WMS'];
    $LIBERADO_WMS     = $reg1 ['LIBERADO_WMS'];

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $CIA);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$Fila, $CENTRO_OP,  PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $DOCUMENTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $NUM_PEDIDO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $LEIDO_WMS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $ENTREGADO_A_WMS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $LIBERADO_WMS);
        
    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

$n = 'Auditoria_pedidos_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>