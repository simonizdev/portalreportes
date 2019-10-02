<?php
/* @var $this IExistenciaController */
/* @var $model IExistencia */

set_time_limit(0);

//EXCEL

//se reciben los parametros para el reporte
if (isset($model['linea'])) { 
  
  $linea = implode(",", $model['linea']);

  $cond = "AND t1.Id_Linea IN (".$linea.")";

} else { 
  
  $cond = "";

}

$query= "
  SELECT t2.Descripcion AS Linea, t1.Id_Item, t1.Referencia, t1.Descripcion, t1.UND_Medida 
  FROM TH_I_ITEM t1 
  LEFT JOIN TH_I_LINEA t2 ON t1.Id_Linea = t2.Id
  WHERE t1.Estado = 1 ".$cond."
  ORDER BY 1, 4
";

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$q1 = Yii::app()->db->createCommand($query)->queryAll();

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Línea');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Código');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Referencia');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Descripción');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Und. medida');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Cant. verificada');

$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

$Prom = "";
$Fila = 3;

  /*Inicio contenido tabla*/

  foreach ($q1 as $reg1) {

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila,$reg1 ['Linea']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila,$reg1 ['Id_Item']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila,$reg1 ['Referencia']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila,$reg1 ['Descripcion']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila,$reg1 ['UND_Medida']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila,'_______');

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $Fila ++;
         
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

  $n = 'Listado_inv_fisico_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

?>

