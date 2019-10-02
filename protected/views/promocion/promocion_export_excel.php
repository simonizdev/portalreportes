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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Promoción');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Componente');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Cantidad');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Usuario que creo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Fecha de creación');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Usuario que actualizó');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Fecha de actualización');

  $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

  $Prom = "";
  $Fila= 3;

  /*Inicio contenido tabla*/

  foreach ($data as $reg) {

    $desc= Yii::app()->db->createCommand("
        SELECT CONCAT (TIP.I_ID_ITEM, ' - ', TIP.I_DESCRIPCION) AS PROMOCION, CONCAT (TIH.I_ID_ITEM, ' - ', TIH.I_DESCRIPCION) AS COMPONENTE, t.Cantidad AS CANTIDAD , t.Fecha_Creacion AS FEC_CRE, TUC.Usuario AS USUA_CRE, t.Fecha_Actualizacion AS FEC_ACT, TUC.Usuario AS USUA_ACT
        FROM TH_PROMOCIONES T 
        INNER JOIN TH_ITEMS TIP ON t.Id_Item_Padre = TIP.I_ID_ITEM
        INNER JOIN TH_ITEMS TIH ON t.Id_Item_Hijo = TIH.I_ID_ITEM
        INNER JOIN TH_USUARIOS TUC ON t.Id_Usuario_Creacion = TUC.Id_Usuario
        INNER JOIN TH_USUARIOS TUA ON t.Id_Usuario_Actualizacion = TUC.Id_Usuario
        WHERE t.Id_Promocion = ".$reg->Id_Promocion."
    ")->queryRow();

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila,$desc['PROMOCION']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila,$desc['COMPONENTE']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila,$desc['CANTIDAD']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila,$desc['USUA_CRE']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila,$desc['FEC_CRE']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila,$desc['USUA_ACT']);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila,$desc['FEC_ACT']);

    $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');

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

  $n = 'Promocion_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

?>

