<?php
/* @var $this ReporteController */
/* @var $model Reporte */

//se reciben los parametros para el reporte

$des_ora_ini = $model['des_ora_ini'];
$des_ora_fin = $model['des_ora_fin'];

set_time_limit(0);

/*inicio configuración array de datos*/

//EXCEL

$query ="SET NOCOUNT ON 
        EXEC [dbo].[COM_CONS_ITEMS_COMER] 
        @ORACLE = N'".$des_ora_ini."',
        @ORACLE2 = N'".$des_ora_fin."'
        ";

$q1 = Yii::app()->db->createCommand($query)->queryAll();

$array_info = array();

foreach ($q1 as $reg1) {

    $UN                = $reg1 ['UN']; 
    $Item              = $reg1 ['Item']; 
    $Referencia        = $reg1 ['Referencia'];
    $Descripcion       = $reg1 ['Descripcion'];
    $Estado_Siesa      = $reg1 ['Estado_Siesa'];
    $Estado_Comercial  = $reg1 ['Estado_Comercial'];

    if($reg1 ['L001'] == NULL){
        $L001 = 0;
    }else{
        $L001 = $reg1 ['L001'];
    }

    if($reg1 ['L860'] == NULL){
        $L860 = 0;
    }else{
        $L860 = $reg1 ['L860'];
    }

    if($reg1 ['L111'] == NULL){
        $L111 = 0;
    }else{
        $L111 = $reg1 ['L111'];
    }

    $UND                = $reg1 ['UND'];
    $Factor             = $reg1 ['Factor'];
    $EAN                = $reg1 ['EAN'];
    $IVA                = $reg1 ['IVA'];
    $Producto_exento    = $reg1 ['Producto_exento'];
    $Cant_Disponible    = $reg1 ['Cant_Disponible'];
    $TOTAL              = $reg1 ['TOTAL'];
    $AUTOMOTRIZ         = $reg1 ['AUTOMOTRIZ'];
    $ELECTRICO          = $reg1 ['ELECTRICO'];
    $FERRETERO          = $reg1 ['FERRETERO'];
    $MIXTO              = $reg1 ['MIXTO'];
    $MIXTO_B_GA         = $reg1 ['MIXTO_B_GA'];

    if($reg1 ['H018_LARGO_PRODUCTO_CMS'] == NULL){
        $H018_LARGO_PRODUCTO_CMS = 0;
    }else{
        $H018_LARGO_PRODUCTO_CMS = $reg1 ['H018_LARGO_PRODUCTO_CMS'];
    }

    if($reg1 ['H018_ANCHO_PRODUCTO_CMS'] == NULL){
        $H018_ANCHO_PRODUCTO_CMS = 0;
    }else{
        $H018_ANCHO_PRODUCTO_CMS = $reg1 ['H018_ANCHO_PRODUCTO_CMS'];
    }

    if($reg1 ['H018_ALTO_PRODUCTO_CMS'] == NULL){
        $H018_ALTO_PRODUCTO_CMS = 0;
    }else{
        $H018_ALTO_PRODUCTO_CMS = $reg1 ['H018_ALTO_PRODUCTO_CMS'];
    }

    if($reg1 ['H018_PESO_PRODUCTO_KG'] == NULL){
        $H018_PESO_PRODUCTO_KG = 0;
    }else{
        $H018_PESO_PRODUCTO_KG = $reg1 ['H018_PESO_PRODUCTO_KG'];
    }

    if($reg1 ['H018_LARGO_UND_EMPAQUE_PPAL_CMS'] == NULL){
        $H018_LARGO_UND_EMPAQUE_PPAL_CMS = 0;
    }else{
        $H018_LARGO_UND_EMPAQUE_PPAL_CMS = $reg1 ['H018_LARGO_UND_EMPAQUE_PPAL_CMS'];
    }

    if($reg1 ['H018_ANCHO_UND_EMPAQUE_PPAL_CMS'] == NULL){
        $H018_ANCHO_UND_EMPAQUE_PPAL_CMS = 0;
    }else{
        $H018_ANCHO_UND_EMPAQUE_PPAL_CMS = $reg1 ['H018_ANCHO_UND_EMPAQUE_PPAL_CMS'];
    }

    if($reg1 ['H018_ALTO_UND_EMPAQUE_PPAL_CMS'] == NULL){
        $H018_ALTO_UND_EMPAQUE_PPAL_CMS = 0;
    }else{
        $H018_ALTO_UND_EMPAQUE_PPAL_CMS = $reg1 ['H018_ALTO_UND_EMPAQUE_PPAL_CMS'];
    }

    if($reg1 ['H018_PESO_UND_EMPAQUE_PPAL_KG'] == NULL){
        $H018_PESO_UND_EMPAQUE_PPAL_KG = 0;
    }else{
        $H018_PESO_UND_EMPAQUE_PPAL_KG = $reg1 ['H018_PESO_UND_EMPAQUE_PPAL_KG'];
    }

    if($reg1 ['H018_LARGO_UND_EMPAQUE_CADENAS_CMS'] == NULL){
        $H018_LARGO_UND_EMPAQUE_CADENAS_CMS = 0;
    }else{
        $H018_LARGO_UND_EMPAQUE_CADENAS_CMS = $reg1 ['H018_LARGO_UND_EMPAQUE_CADENAS_CMS'];
    }

    if($reg1 ['H018_ANCHO_UND_EMPAQUE_CADENAS_CMS'] == NULL){
        $H018_ANCHO_UND_EMPAQUE_CADENAS_CMS = 0;
    }else{
        $H018_ANCHO_UND_EMPAQUE_CADENAS_CMS = $reg1 ['H018_ANCHO_UND_EMPAQUE_CADENAS_CMS'];
    }

    if($reg1 ['H018_ALTO_UND_EMPAQUE_CADENAS_CMS'] == NULL){
        $H018_ALTO_UND_EMPAQUE_CADENAS_CMS = 0;
    }else{
        $H018_ALTO_UND_EMPAQUE_CADENAS_CMS = $reg1 ['H018_ALTO_UND_EMPAQUE_CADENAS_CMS'];
    }

    if($reg1 ['H018_PESO_UND_EMPAQUE_CADENAS_KG'] == NULL){
        $H018_PESO_UND_EMPAQUE_CADENAS_KG = 0;
    }else{
        $H018_PESO_UND_EMPAQUE_CADENAS_KG = $reg1 ['H018_PESO_UND_EMPAQUE_CADENAS_KG'];
    }

    if($reg1 ['H018_UND_VENTA_MINIMA'] == NULL){
        $H018_UND_VENTA_MINIMA = '';
    }else{
        $H018_UND_VENTA_MINIMA = $reg1 ['H018_UND_VENTA_MINIMA'];
    }

    $ORIGEN = $reg1 ['ORIGEN'];
    $TIPO = $reg1 ['TIPO'];
    $CLASIFICACION = $reg1 ['CLASIFICACION'];
    $CLASE = $reg1 ['CLASE'];
    $MARCA = $reg1 ['MARCA'];
    $SEGMENTO = $reg1 ['SEGMENTO'];
    $LINEA = $reg1 ['LINEA'];
    $SUB_LINEA = $reg1 ['SUB_LINEA'];
    $I_UNIDAD_NEGOCIO = $reg1 ['I_UNIDAD_NEGOCIO'];
    $CATEGORIA_ORACLE = $reg1 ['CATEGORIA_ORACLE'];
    $SUB_MARCA = $reg1 ['SUB_MARCA'];

    $array_info[$Item]['info'] = array('UN' => $UN, 'Item' => $Item, 'Referencia' => $Referencia, 'Descripcion' => $Descripcion, 'Estado_Siesa' => $Estado_Siesa, 'Estado_Comercial' => $Estado_Comercial, 'IVA' => $IVA, 'Producto_exento' => $Producto_exento, 'Cant_Disponible' => $Cant_Disponible, 'TOTAL' => $TOTAL,'AUTOMOTRIZ' => $AUTOMOTRIZ, 'ELECTRICO' => $ELECTRICO, 'FERRETERO' => $FERRETERO, 'MIXTO' => $MIXTO, 'MIXTO_B_GA' => $MIXTO_B_GA, 'H018_LARGO_PRODUCTO_CMS' => $H018_LARGO_PRODUCTO_CMS, 'H018_ANCHO_PRODUCTO_CMS' => $H018_ANCHO_PRODUCTO_CMS, 'H018_ALTO_PRODUCTO_CMS' => $H018_ALTO_PRODUCTO_CMS, 'H018_PESO_PRODUCTO_KG' => $H018_PESO_PRODUCTO_KG, 'H018_LARGO_UND_EMPAQUE_PPAL_CMS' => $H018_LARGO_UND_EMPAQUE_PPAL_CMS, 'H018_ANCHO_UND_EMPAQUE_PPAL_CMS' => $H018_ANCHO_UND_EMPAQUE_PPAL_CMS, 'H018_ALTO_UND_EMPAQUE_PPAL_CMS' => $H018_ALTO_UND_EMPAQUE_PPAL_CMS, 'H018_PESO_UND_EMPAQUE_PPAL_KG' => $H018_PESO_UND_EMPAQUE_PPAL_KG, 'H018_LARGO_UND_EMPAQUE_CADENAS_CMS' => $H018_LARGO_UND_EMPAQUE_CADENAS_CMS, 'H018_ANCHO_UND_EMPAQUE_CADENAS_CMS' => $H018_ANCHO_UND_EMPAQUE_CADENAS_CMS, 'H018_ALTO_UND_EMPAQUE_CADENAS_CMS' => $H018_ALTO_UND_EMPAQUE_CADENAS_CMS, 'H018_PESO_UND_EMPAQUE_CADENAS_KG' => $H018_PESO_UND_EMPAQUE_CADENAS_KG, 'H018_UND_VENTA_MINIMA' => $H018_UND_VENTA_MINIMA, 'ORIGEN' => $ORIGEN, 'TIPO' => $TIPO, 'CLASIFICACION' => $CLASIFICACION, 'CLASE' => $CLASE, 'MARCA' => $MARCA, 'SEGMENTO' => $SEGMENTO, 'LINEA' => $LINEA, 'SUB_LINEA' => $SUB_LINEA, 'I_UNIDAD_NEGOCIO' => $I_UNIDAD_NEGOCIO, 'CATEGORIA_ORACLE' => $CATEGORIA_ORACLE, 'SUB_MARCA' => $SUB_MARCA);
    $array_info[$Item]['unds'][] = array('L001' => $L001, 'L860' => $L860, 'L111' => $L111, 'UND' => $UND, 'Factor' => $Factor, 'EAN' => $EAN);

}

// Se inactiva el autoloader de yii
spl_autoload_unregister(array('YiiBase','autoload'));   

require_once Yii::app()->basePath . '/extensions/PHPExcel/Classes/PHPExcel.php';

//cuando se termina la accion relacionada con la libreria se activa el autoloader de yii
spl_autoload_register(array('YiiBase','autoload'));

$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
$objPHPExcel->setActiveSheetIndex();

/*Cabecera tabla*/

$objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'UN');
$objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Item');
$objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Referencia');
$objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Descripción');
$objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Estado siesa');
$objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Estado comercial');
$objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'L001 (1)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'L860 (1)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'L111 (1)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'UND. (1)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Factor (1)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'EAN (1)');

/*$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'L001 (2)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'L860 (2)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'L111 (2)');*/
$objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'UND. (2)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Factor (2)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'EAN (2)');

/*$objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'L001 (3)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'L860 (3)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'L111 (3)');*/
$objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'UND. (3)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Factor (3)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'EAN (3)');

/*$objPHPExcel->setActiveSheetIndex()->setCellValue('Y1', 'L001 (4)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Z1', 'L860 (4)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AA1', 'L111 (4)');*/
$objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'UND. (4)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'Factor (4)');
$objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'EAN (4)');

$objPHPExcel->setActiveSheetIndex()->setCellValue('V1', 'IVA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('W1', 'Producto exento ?');
$objPHPExcel->setActiveSheetIndex()->setCellValue('X1', 'Cant. disponible');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Y1', 'Total');
$objPHPExcel->setActiveSheetIndex()->setCellValue('Z1', 'Automotriz');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AA1', 'Electrico');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AB1', 'Ferretero');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AC1', 'Mixto');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AD1', 'Mixto B/GA');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AE1', 'Largo producto CMS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AF1', 'Ancho producto CMS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AG1', 'Alto producto CMS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AH1', 'Peso producto KG');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AI1', 'Largo und. emp. principal CMS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AJ1', 'Ancho und. emp. principal CMS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AK1', 'Alto und. emp. principal CMS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AL1', 'Peso und. emp. principal KG');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AM1', 'Largo und. emp. cadenas CMS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AN1', 'Ancho und. emp. cadenas CMS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AO1', 'Alto und. emp. cadenas CMS');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AP1', 'Peso und. emp. cadenas KG');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AQ1', 'Und. venta mínimo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AR1', 'Origen');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AS1', 'Tipo');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AT1', 'Clasificación');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AU1', 'Clase');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AV1', 'Marca');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AW1', 'Segmento');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AX1', 'Línea');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AY1', 'Sub-línea');
$objPHPExcel->setActiveSheetIndex()->setCellValue('AZ1', 'Unidad de negocio');
$objPHPExcel->setActiveSheetIndex()->setCellValue('BA1', 'Categoria oracle');
$objPHPExcel->setActiveSheetIndex()->setCellValue('BB1', 'Sub-marca');

$objPHPExcel->getActiveSheet()->getStyle('A1:BB1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:BB1')->getFont()->setBold(true);

/*Inicio contenido tabla*/
    
$Fila = 2;

foreach ($array_info as $item => $data) {

    $UN                = $data['info']['UN']; 
    $Item              = $data['info']['Item']; 
    $Referencia        = $data['info']['Referencia'];
    $Descripcion       = $data['info']['Descripcion'];
    $Estado_Siesa      = $data['info']['Estado_Siesa'];
    $Estado_Comercial  = $data['info']['Estado_Comercial'];

    $IVA                = $data['info']['IVA'];
    $Producto_exento    = $data['info']['Producto_exento'];
    $Cant_Disponible    = $data['info']['Cant_Disponible'];
    $TOTAL              = $data['info']['TOTAL'];
    $AUTOMOTRIZ         = $data['info']['AUTOMOTRIZ'];
    $ELECTRICO          = $data['info']['ELECTRICO'];
    $FERRETERO          = $data['info']['FERRETERO'];
    $MIXTO              = $data['info']['MIXTO'];
    $MIXTO_B_GA         = $data['info']['MIXTO_B_GA'];
    $H018_LARGO_PRODUCTO_CMS = $data['info']['H018_LARGO_PRODUCTO_CMS'];
    $H018_ANCHO_PRODUCTO_CMS = $data['info']['H018_ANCHO_PRODUCTO_CMS'];
    $H018_ALTO_PRODUCTO_CMS = $data['info']['H018_ALTO_PRODUCTO_CMS'];
    $H018_PESO_PRODUCTO_KG = $data['info']['H018_PESO_PRODUCTO_KG'];
    $H018_LARGO_UND_EMPAQUE_PPAL_CMS = $data['info']['H018_LARGO_UND_EMPAQUE_PPAL_CMS'];
    $H018_ANCHO_UND_EMPAQUE_PPAL_CMS = $data['info']['H018_ANCHO_UND_EMPAQUE_PPAL_CMS'];
    $H018_ALTO_UND_EMPAQUE_PPAL_CMS = $data['info']['H018_ALTO_UND_EMPAQUE_PPAL_CMS'];
    $H018_PESO_UND_EMPAQUE_PPAL_KG = $data['info']['H018_PESO_UND_EMPAQUE_PPAL_KG'];
    $H018_LARGO_UND_EMPAQUE_CADENAS_CMS = $data['info']['H018_LARGO_UND_EMPAQUE_CADENAS_CMS'];
    $H018_ANCHO_UND_EMPAQUE_CADENAS_CMS = $data['info']['H018_ANCHO_UND_EMPAQUE_CADENAS_CMS'];
    $H018_ALTO_UND_EMPAQUE_CADENAS_CMS = $data['info']['H018_ALTO_UND_EMPAQUE_CADENAS_CMS'];
    $H018_PESO_UND_EMPAQUE_CADENAS_KG = $data['info']['H018_PESO_UND_EMPAQUE_CADENAS_KG'];
    $H018_UND_VENTA_MINIMA = $data['info']['H018_UND_VENTA_MINIMA'];
    $ORIGEN = $data['info']['ORIGEN'];
    $TIPO = $data['info']['TIPO'];
    $CLASIFICACION = $data['info']['CLASIFICACION'];
    $CLASE = $data['info']['CLASE'];
    $MARCA = $data['info']['MARCA'];
    $SEGMENTO = $data['info']['SEGMENTO'];
    $LINEA = $data['info']['LINEA'];
    $SUB_LINEA = $data['info']['SUB_LINEA'];
    $I_UNIDAD_NEGOCIO = $data['info']['I_UNIDAD_NEGOCIO'];
    $CATEGORIA_ORACLE = $data['info']['CATEGORIA_ORACLE'];
    $SUB_MARCA = $data['info']['SUB_MARCA'];

    $unds = $data['unds'];
    $num_unds = count($unds);
    
    $objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$Fila, $UN);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$Fila, $Item);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('C'.$Fila, $Referencia);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('D'.$Fila, $Descripcion);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('E'.$Fila, $Estado_Siesa);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('F'.$Fila, $Estado_Comercial);

    $objPHPExcel->getActiveSheet()->getStyle('A'.$Fila.':F'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    if($num_unds == 1){

        $va = $unds[0]['L001']; 
        $vb = $unds[0]['L860'];
        $vc = $unds[0]['L111'];
        $vd = $unds[0]['UND'];
        $ve = $unds[0]['Factor'];
        $vf = $unds[0]['EAN'];
        
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $va);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $vb);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $vc);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $vd);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $ve);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('L'.$Fila, $vf,  PHPExcel_Cell_DataType::TYPE_STRING);

        $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('L'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        /*$objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, '');*/
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, '');

        /*$objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, '');*/
        $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila, '');

        /*$objPHPExcel->setActiveSheetIndex()->setCellValue('Y'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, '');*/
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, '');

    }

    if($num_unds == 2){

        $va = $unds[0]['L001']; 
        $vb = $unds[0]['L860'];
        $vc = $unds[0]['L111'];
        $vd = $unds[0]['UND'];
        $ve = $unds[0]['Factor'];
        $vf = $unds[0]['EAN'];
        
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $va);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $vb);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $vc);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $vd);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $ve);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('L'.$Fila, $vf,  PHPExcel_Cell_DataType::TYPE_STRING);

        $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('L'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        /*$vg = $unds[1]['L001']; 
        $vh = $unds[1]['L860'];
        $vi = $unds[1]['L111'];*/
        $vj = $unds[1]['UND'];
        $vk = $unds[1]['Factor'];
        $vl = $unds[1]['EAN'];

        /*$objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $vg);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $vh);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $vi);*/
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $vj);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $vk);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('O'.$Fila, $vl,  PHPExcel_Cell_DataType::TYPE_STRING);

        /*$objPHPExcel->getActiveSheet()->getStyle('M'.$Fila.':O'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('M'.$Fila.':O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
        $objPHPExcel->getActiveSheet()->getStyle('M'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('N'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('N'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        /*$objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, '');*/
        $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('R'.$Fila, '');

        /*$objPHPExcel->setActiveSheetIndex()->setCellValue('Y'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, '');*/
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, '');

    }

    if($num_unds == 3){
        
        $va = $unds[0]['L001']; 
        $vb = $unds[0]['L860'];
        $vc = $unds[0]['L111'];
        $vd = $unds[0]['UND'];
        $ve = $unds[0]['Factor'];
        $vf = $unds[0]['EAN'];
        
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $va);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $vb);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $vc);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $vd);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $ve);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('L'.$Fila, $vf,  PHPExcel_Cell_DataType::TYPE_STRING);

        $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('L'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        /*$vg = $unds[1]['L001']; 
        $vh = $unds[1]['L860'];
        $vi = $unds[1]['L111'];*/
        $vj = $unds[1]['UND'];
        $vk = $unds[1]['Factor'];
        $vl = $unds[1]['EAN'];

        /*$objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $vg);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $vh);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $vi);*/
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $vj);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $vk);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('O'.$Fila, $vl,  PHPExcel_Cell_DataType::TYPE_STRING);

        /*$objPHPExcel->getActiveSheet()->getStyle('M'.$Fila.':O'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('M'.$Fila.':O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
        $objPHPExcel->getActiveSheet()->getStyle('M'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('N'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('N'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        /*$vm = $unds[2]['L001']; 
        $vn = $unds[2]['L860'];
        $vo = $unds[2]['L111'];*/
        $vp = $unds[2]['UND'];
        $vq = $unds[2]['Factor'];
        $vr = $unds[2]['EAN'];

        /*$objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $vm);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $vn);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, $vo);*/
        $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $vp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $vq);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('R'.$Fila, $vr,  PHPExcel_Cell_DataType::TYPE_STRING);

        /*$objPHPExcel->getActiveSheet()->getStyle('S'.$Fila.':U'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('S'.$Fila.':U'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
        $objPHPExcel->getActiveSheet()->getStyle('P'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('Q'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('Q'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('R'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        /*$objPHPExcel->setActiveSheetIndex()->setCellValue('Y'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, '');*/
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, '');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, '');

    }

    if($num_unds == 4){

        $va = $unds[0]['L001']; 
        $vb = $unds[0]['L860'];
        $vc = $unds[0]['L111'];
        $vd = $unds[0]['UND'];
        $ve = $unds[0]['Factor'];
        $vf = $unds[0]['EAN'];
        
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G'.$Fila, $va);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H'.$Fila, $vb);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I'.$Fila, $vc);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J'.$Fila, $vd);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('K'.$Fila, $ve);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('L'.$Fila, $vf,  PHPExcel_Cell_DataType::TYPE_STRING);

        $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':I'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('G'.$Fila.':I'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('J'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('K'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('L'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        /*$vg = $unds[1]['L001']; 
        $vh = $unds[1]['L860'];
        $vi = $unds[1]['L111'];*/
        $vj = $unds[1]['UND'];
        $vk = $unds[1]['Factor'];
        $vl = $unds[1]['EAN'];

        /*$objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $vg);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $vh);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('O'.$Fila, $vi);*/
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M'.$Fila, $vj);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N'.$Fila, $vk);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('O'.$Fila, $vl,  PHPExcel_Cell_DataType::TYPE_STRING);

        /*$objPHPExcel->getActiveSheet()->getStyle('M'.$Fila.':O'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('M'.$Fila.':O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
        $objPHPExcel->getActiveSheet()->getStyle('M'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('N'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('N'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('O'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        /*$vm = $unds[2]['L001']; 
        $vn = $unds[2]['L860'];
        $vo = $unds[2]['L111'];*/
        $vp = $unds[2]['UND'];
        $vq = $unds[2]['Factor'];
        $vr = $unds[2]['EAN'];

        /*$objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $vm);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $vn);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('U'.$Fila, $vo);*/
        $objPHPExcel->setActiveSheetIndex()->setCellValue('P'.$Fila, $vp);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Q'.$Fila, $vq);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('R'.$Fila, $vr,  PHPExcel_Cell_DataType::TYPE_STRING);

        /*$objPHPExcel->getActiveSheet()->getStyle('S'.$Fila.':U'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('S'.$Fila.':U'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
        $objPHPExcel->getActiveSheet()->getStyle('P'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('Q'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('Q'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('R'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        /*$vs = $unds[3]['L001']; 
        $vt = $unds[3]['L860'];
        $vu = $unds[3]['L111'];*/
        $vv = $unds[3]['UND'];
        $vw = $unds[3]['Factor'];
        $vx = $unds[3]['EAN'];

        /*$objPHPExcel->setActiveSheetIndex()->setCellValue('Y'.$Fila, $vs);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $vt);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, $vu);*/
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S'.$Fila, $vv);
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T'.$Fila, $vw);
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('U'.$Fila, $vx,  PHPExcel_Cell_DataType::TYPE_STRING);

        /*$objPHPExcel->getActiveSheet()->getStyle('Y'.$Fila.':AA'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('Y'.$Fila.':AA'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
        $objPHPExcel->getActiveSheet()->getStyle('S'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('T'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('T'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('U'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    }

    $objPHPExcel->setActiveSheetIndex()->setCellValue('V'.$Fila, $IVA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('W'.$Fila, $Producto_exento);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('X'.$Fila, $Cant_Disponible);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Y'.$Fila, $TOTAL);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('Z'.$Fila, $AUTOMOTRIZ);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AA'.$Fila, $ELECTRICO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AB'.$Fila, $FERRETERO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AC'.$Fila, $MIXTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AD'.$Fila, $MIXTO_B_GA);
    
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AE'.$Fila, $H018_LARGO_PRODUCTO_CMS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AF'.$Fila, $H018_ANCHO_PRODUCTO_CMS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AG'.$Fila, $H018_ALTO_PRODUCTO_CMS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AH'.$Fila, $H018_PESO_PRODUCTO_KG);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AI'.$Fila, $H018_LARGO_UND_EMPAQUE_PPAL_CMS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AJ'.$Fila, $H018_ANCHO_UND_EMPAQUE_PPAL_CMS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AK'.$Fila, $H018_ALTO_UND_EMPAQUE_PPAL_CMS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AL'.$Fila, $H018_PESO_UND_EMPAQUE_PPAL_KG);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AM'.$Fila, $H018_LARGO_UND_EMPAQUE_CADENAS_CMS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AN'.$Fila, $H018_ANCHO_UND_EMPAQUE_CADENAS_CMS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AO'.$Fila, $H018_ALTO_UND_EMPAQUE_CADENAS_CMS);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AP'.$Fila, $H018_PESO_UND_EMPAQUE_CADENAS_KG);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AQ'.$Fila, $H018_UND_VENTA_MINIMA);

    $objPHPExcel->setActiveSheetIndex()->setCellValue('AR'.$Fila, $ORIGEN);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AS'.$Fila, $TIPO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AT'.$Fila, $CLASIFICACION);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AU'.$Fila, $CLASE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AV'.$Fila, $MARCA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AW'.$Fila, $SEGMENTO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AX'.$Fila, $LINEA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AY'.$Fila, $SUB_LINEA);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('AZ'.$Fila, $I_UNIDAD_NEGOCIO);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('BA'.$Fila, $CATEGORIA_ORACLE);
    $objPHPExcel->setActiveSheetIndex()->setCellValue('BB'.$Fila, $SUB_MARCA);

    $objPHPExcel->getActiveSheet()->getStyle('V'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('V'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('W'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('X'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');
    $objPHPExcel->getActiveSheet()->getStyle('X'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('Y'.$Fila.':AD'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('AE'.$Fila.':AP'.$Fila)->getNumberFormat()->setFormatCode('#,##0.00');

    if($H018_UND_VENTA_MINIMA != ''){
        $objPHPExcel->getActiveSheet()->getStyle('AQ'.$Fila)->getNumberFormat()->setFormatCode('0');
    }

    $objPHPExcel->getActiveSheet()->getStyle('AE'.$Fila.':AQ'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('AR'.$Fila.':BB'.$Fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    $Fila = $Fila + 1; 
      
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

$n = 'Logistica_comercial_x_cat_ora_'.date('Y-m-d H_i_s');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$n.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
ob_end_clean();
$objWriter->save('php://output');
exit;

?>











