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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'ID');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Empresa');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', '# de factura');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Fecha de factura ');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Proveedor');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Valor');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Moneda');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Fecha de radicado');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Entregada a');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Observaciones');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Usuario que creo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Fecha de creación');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Usuario que actualizó');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Fecha de actualización');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Estado');

  $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);

  $Prom = "";
  $Fila= 2;

  /*Inicio contenido tabla*/

  foreach ($data as $reg) {

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila,$reg->Id_Fact);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila,$reg->DescEmpresa($reg->Empresa));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila,$reg->Num_Factura);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila,UtilidadesVarias::textofecha($reg->Fecha_Factura));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila,$reg->DescProveedor($reg->Proveedor));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila,number_format($reg->Valor, 2));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila,$reg->DescMoneda($reg->Moneda));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila,UtilidadesVarias::textofecha($reg->Fecha_Radicado));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila,$reg->Entregada_A);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila,($reg->Observaciones == "") ? "N/A" : $reg->Observaciones);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila,$reg->idusuariocre->Usuario);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila,UtilidadesVarias::textofechahora($reg->Fecha_Creacion));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila,$reg->idusuarioact->Usuario);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila,UtilidadesVarias::textofechahora($reg->Fecha_Actualizacion));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila,$reg->DescEstado($reg->Estado));

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

  $n = 'Fact_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

?>

