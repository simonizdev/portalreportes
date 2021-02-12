<?php
/* @var $this LogController */
/* @var $model Log */

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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Tipo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Usuario');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Opción');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Acción');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Fecha y hora');

  $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);

  $Prom = "";
  $Fila= 3;

  /*Inicio contenido tabla*/

  foreach ($data as $reg) {

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila,$reg->DescTipo($reg->Tipo));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila,$reg->idusuario->Nombres);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila,($reg->Id_Menu == "") ? "-" : $reg->DescOpcPadre($reg->Id_Menu));
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila,($reg->Accion == "") ? "-" : $reg->Accion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila,UtilidadesVarias::textofechahora($reg->Fecha_Hora));

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':E'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

  $n = 'Log_'.date('Y_m_d_H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;
  
?>
