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

  $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'WIP');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', '#');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'CADENA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'REFERENCIA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'DESCRIPCIÓN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'ESTADO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'INVENTARIO TOTAL');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'DE 0 A_30 DÍAS');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'DE 31 A 60_DÍAS');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'DE 61 A 90 DÍAS');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'MÁS DE 90 DÍAS');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'FECHA DE SOLICITUD');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'FECHA ENTREGA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'CANT. A ARMAR');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'CANT. ORDEN PROD.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'CANT. SIN ENTREGAR');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'RESPONSABLE');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'DÍAS DE VENCIMIENTO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'ESTADO COMERCIAL');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'UN');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'SUB-MARCA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('V1', 'FAMILIA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('W1', 'SUB-FAMILIA');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('X1', 'GRUPO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Y1', 'ORACLE');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('Z1', 'CADENA A PRESTAR');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AA1', 'CANTIDAD DE PRESTAMO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AB1', 'CANT. VEND.');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AC1', 'FECHA CUMPLIDO');
  $objPHPExcel->setActiveSheetIndex()->setCellValue('AD1', 'OBSERVACIONES');

  $objPHPExcel->getActiveSheet()->getStyle('A1:AD1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
  $objPHPExcel->getActiveSheet()->getStyle('A1:AD1')->getFont()->setBold(true);

  $Fila= 2;

  /*Inicio contenido tabla*/


  $wip_ant = "";
  $wip_act = "";

  $cons = 0;

  foreach ($data as $reg) {

    if($wip_ant == ""){
      $wip_ant = $reg->WIP;
      $wip_act = $reg->WIP;
      $cons = 1;
    }else{

      $wip_act = $reg->WIP;

      if($wip_act == $wip_ant){
        $wip_ant = $reg->WIP;
        $cons ++;
      }else{
        $wip_ant = $reg->WIP;
        $cons = 1;
      }

    }

    $cadena = $reg->desccadena($reg->ID);

    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila,$reg->WIP);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila,$cons);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila,$cadena);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila,$reg->ID_ITEM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila,$reg->DESCRIPCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila,$reg->ESTADO_COMERCIAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila,$reg->INVENTARIO_TOTAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila,$reg->DE_0_A_30_DIAS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila,$reg->DE_31_A_60_DIAS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila,$reg->DE_61_A_90_DIAS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila,$reg->MAS_DE_90_DIAS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('L'.$Fila,$reg->FECHA_SOLICITUD_WIP);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila,$reg->FECHA_ENTREGA_WIP);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila,$reg->CANT_A_ARMAR);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila,$reg->CANT_OC_AL_DIA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila,$reg->CANT_PENDIENTE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila,$reg->RESPONSABLE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila,$reg->DIAS_VENCIMIENTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila,$reg->ESTADO_COMERCIAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila,$reg->UN);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila,$reg->SUB_MARCA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila,$reg->FAMILIA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila,$reg->SUB_FAMILIA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila,$reg->GRUPO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Y'.$Fila,$reg->ORACLE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila,$reg->REDISTRIBUCION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila,$reg->PTM);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila,$reg->CANT_VEND);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AC'.$Fila,$reg->FECHA_CUMPLIDO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila,$reg->OBSERVACIONES);

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

  $n = 'Wip_'.date('Y-m-d H_i_s');

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
  header('Cache-Control: max-age=0');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
  ob_end_clean();
  $objWriter->save('php://output');
  exit;

?>

