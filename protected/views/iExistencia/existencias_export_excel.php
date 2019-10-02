<?php
/* @var $this PromocionController */
/* @var $model Promocion */

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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Línea');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Item');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Bodega');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Cantidad');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Fecha ult. entrada');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Fecha ult. salida');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Usuario que actualizó');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Fecha de actualización');

  $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);

  $Prom = "";
  $Fila = 3;

  /*Inicio contenido tabla*/

  foreach ($data as $reg) {

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila,$reg->iditem->idlinea->Descripcion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila,$reg->DescItem($reg->Id_Item));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila,($reg->Id_Bodega == "") ? "N/A" : $reg->idbodega->Descripcion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila,$reg->Cantidad);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila,($reg->Fecha_Ult_Ent == "") ? "N/A" : UtilidadesVarias::textofecha($reg->Fecha_Ult_Ent));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila,($reg->Fecha_Ult_Sal == "") ? "N/A" : UtilidadesVarias::textofecha($reg->Fecha_Ult_Sal));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila,$reg->idusuarioact->Usuario);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila,UtilidadesVarias::textofechahora($reg->Fecha_Actualizacion));

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

  $n = 'Consulta_existencias_x_bogeda_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

?>

