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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Usuario');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Perfil');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Usuario que creo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Fecha de creación');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Usuario que actualizó');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Fecha de actualización');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Estado');

  $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

  $Prom = "";
  $Fila= 3;

  /*Inicio contenido tabla*/

  foreach ($data as $reg) {

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila,$reg->idusuario->Usuario);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila,$reg->idperfil->Descripcion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila,$reg->idusuariocre->Usuario);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila,$reg->Fecha_Creacion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila,$reg->idusuarioact->Usuario);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila,$reg->Fecha_Actualizacion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila,($reg->Estado == "1") ? "Activo" : "Inactivo");

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':G'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

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

  $n = 'Perfil_usuario_'.date('Y-m-d H_i_s');

  ob_end_clean();
  header( "Content-type: application/vnd.ms-excel" );
  header('Content-Disposition: attachment; filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

?>

