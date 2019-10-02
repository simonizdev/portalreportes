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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Item');
  
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Unidad 1');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Cantidad');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Largo (mm)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Ancho (mm)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Alto (mm)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Volumen total');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Peso total (kg)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Código de barras');

  $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Unidad 2');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Cantidad');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Largo (mm)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Ancho (mm)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Alto (mm)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Volumen total');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Peso total (kg)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Código de barras');

  $objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'Unidad 3');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'Cantidad');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'Largo (mm)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'Ancho (mm)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('V1', 'Alto (mm)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('W1', 'Volumen total');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('X1', 'Peso total (kg)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Y1', 'Código de barras');

  $objPHPExcel->setActiveSheetIndex()->setCellValue('Z1', 'Unidad 4');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AA1', 'Cantidad');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AB1', 'Largo (mm)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AC1', 'Ancho (mm)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AD1', 'Alto (mm)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AE1', 'Volumen total');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AF1', 'Peso total (kg)');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AG1', 'Código de barras');

  $objPHPExcel->setActiveSheetIndex()->setCellValue('AH1', 'Unidad de Venta');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AI1', 'Unidad de Cadena');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ1', 'Lead time');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AK1', 'Usuario que creo');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AL1', 'Fecha de creación');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AM1', 'Usuario que actualizó');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AN1', 'Fecha de actualización');

  $objPHPExcel->getActiveSheet()->getStyle('A1:AN1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A1:AN1')->getFont()->setBold(true);

  $Prom = "";
  $Fila= 3;

  /*Inicio contenido tabla*/

  foreach ($data as $reg) {

    $item = $reg->Desc_Item($reg['Id_Item']);

    $un_venta = $reg['UN_Venta'];
    $un_cadena = $reg['UN_Cadena'];
    $lead_time = $reg['Lead_Time'];

    //$und_1  = $reg->Desc_Unidad($reg['Unidad_1']);
    ($reg['Unidad_1'] == "") ? $und_1 = "" : $und_1 = $reg->Desc_Unidad($reg['Unidad_1']);
    $cant_1 = $reg['Cantidad1'];
    $larg_1 = $reg['Largo1'];
    $anch_1 = $reg['Ancho1'];
    $alto_1 = $reg['Alto1'];
    $volu_1 = $reg['Volumen_Total1'];
    $peso_1 = $reg['Peso_Total1'];
    $codb_1 = $reg['Cod_Barras1'];

    ($reg['Unidad_2'] == "") ? $und_2 = "" : $und_2 = $reg->Desc_Unidad($reg['Unidad_2']);
    $cant_2 = $reg['Cantidad2'];
    $larg_2 = $reg['Largo2'];
    $anch_2 = $reg['Ancho2'];
    $alto_2 = $reg['Alto2'];
    $volu_2 = $reg['Volumen_Total2'];
    $peso_2 = $reg['Peso_Total2'];
    $codb_2 = $reg['Cod_Barras2'];

    ($reg['Unidad_3'] == "") ? $und_3 = "" : $und_3 = $reg->Desc_Unidad($reg['Unidad_3']);
    $cant_3 = $reg['Cantidad3'];
    $larg_3 = $reg['Largo3'];
    $anch_3 = $reg['Ancho3'];
    $alto_3 = $reg['Alto3'];
    $volu_3 = $reg['Volumen_Total3'];
    $peso_3 = $reg['Peso_Total3'];
    $codb_3 = $reg['Cod_Barras3'];

    ($reg['Unidad_4'] == "") ? $und_4 = "" : $und_4 = $reg->Desc_Unidad($reg['Unidad_4']);
    $cant_4 = $reg['Cantidad4'];
    $larg_4 = $reg['Largo4'];
    $anch_4 = $reg['Ancho4'];
    $alto_4 = $reg['Alto4'];
    $volu_4 = $reg['Volumen_Total4'];
    $peso_4 = $reg['Peso_Total4'];
    $codb_4 = $reg['Cod_Barras4'];

    $usu_cre = $reg->idusuariocre->Usuario;
    $fec_cre = UtilidadesVarias::textofechahora($reg['Fecha_Creacion']);
    $usu_act = $reg->idusuarioact->Usuario;
    $fec_act = UtilidadesVarias::textofechahora($reg['Fecha_Actualizacion']);

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila,$item);

    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila,$und_1);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila,$cant_1);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila,$larg_1);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila,$anch_1);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila,$alto_1);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila,$volu_1);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila,$peso_1);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$Fila, $codb_1,  PHPExcel_Cell_DataType::TYPE_STRING);

    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila,$und_2);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila,$cant_2);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila,$larg_2);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila,$anch_2);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila,$alto_2);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila,$volu_2);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila,$peso_2);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('Q'.$Fila, $codb_2,  PHPExcel_Cell_DataType::TYPE_STRING);

    $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila,$und_3);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila,$cant_3);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila,$larg_3);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila,$anch_3);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila,$alto_3);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila,$volu_3);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila,$peso_3);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('Y'.$Fila, $codb_3,  PHPExcel_Cell_DataType::TYPE_STRING);

    $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila,$und_4);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila,$cant_4);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila,$larg_4);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AC'.$Fila,$anch_4);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila,$alto_4);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AE'.$Fila,$volu_4);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila,$peso_4);
    $objPHPExcel->getActiveSheet()->setCellValueExplicit('AG'.$Fila, $codb_4,  PHPExcel_Cell_DataType::TYPE_STRING);

    $objPHPExcel->setActiveSheetIndex()->setCellValue('AH'.$Fila,$un_venta);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AI'.$Fila,$un_cadena);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ'.$Fila,$lead_time);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AK'.$Fila,$usu_cre);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AL'.$Fila,$fec_cre);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AM'.$Fila,$usu_act);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AN'.$Fila,$fec_act);


    $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('D'.$Fila.':H'.$Fila)->getNumberFormat()->setFormatCode('#,######0.000000');
    $objPHPExcel->getActiveSheet()->getStyle('C'.$Fila.':H'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('L'.$Fila.':P'.$Fila)->getNumberFormat()->setFormatCode('#,######0.000000');
    $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila.':P'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $objPHPExcel->getActiveSheet()->getStyle('S'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('T'.$Fila.':X'.$Fila)->getNumberFormat()->setFormatCode('#,######0.000000');
    $objPHPExcel->getActiveSheet()->getStyle('S'.$Fila.':X'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $objPHPExcel->getActiveSheet()->getStyle('AA'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('AB'.$Fila.':AF'.$Fila)->getNumberFormat()->setFormatCode('#,######0.000000');
    $objPHPExcel->getActiveSheet()->getStyle('AA'.$Fila.':AF'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $objPHPExcel->getActiveSheet()->getStyle('AH'.$Fila.':AJ'.$Fila)->getNumberFormat()->setFormatCode('0');
    $objPHPExcel->getActiveSheet()->getStyle('AH'.$Fila.':AJ'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

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

  $n = 'Unidad_item_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

?>

