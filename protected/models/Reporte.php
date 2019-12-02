<?php

class Reporte extends CFormModel 
{

    public $fecha_inicial;
    public $fecha_final;
    public $marca_inicial;
    public $marca_final;
    public $cliente_inicial;
    public $cliente_final;
    public $opcion_exp;
    public $origen;
    public $clase;
    public $canal;
    public $ev;
    public $des_ora_ini;
    public $des_ora_fin;
    public $reg;
    public $ruta_inicial;
    public $ruta_final;
    public $vendedor_inicial;
    public $vendedor_final;
    public $co;
    public $des_ora;
    public $archivo;
    public $cliente;
    public $ruta;
    public $estado;
    public $asesor;
    public $firma;
    public $asesor_ant;
    public $asesor_nue;
    public $fecha_ret;
    public $consecutivo;
    public $linea;
    public $marca;
    public $segmento;
    public $tipo;
    public $lista;
    public $linea_inicial;
    public $linea_final;
    public $valor;
    public $dias;
    public $clasificacion;
    public $recibos;
    public $opc_ver;
    public $fec_ver;
    public $fec_che;
    public $fecha_cheque;
    public $opc;
    public $fecha;
    public $item;
    public $plan;
    public $criterio;
    public $cons_inicial;
    public $cons_final;
    public $c_o;
    public $opcion;
    public $proveedor;
    public $periodo_inicial;
    public $periodo_final;
    
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fecha_inicial, fecha_final', 'safe'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'rent_marca'),
            array('fecha_inicial, fecha_final, marca_inicial, marca_final, opcion_exp', 'required','on'=>'rent_marca_item'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'rent_oracle'),
            array('fecha_inicial, fecha_final, des_ora_ini, des_ora_fin, opcion_exp', 'required','on'=>'rent_oracle_item'),
            array('fecha_inicial, fecha_final, cliente_inicial, cliente_final, opcion_exp', 'required','on'=>'rent_cliente'),
            array('fecha_inicial, fecha_final, marca_inicial, marca_final, opcion_exp', 'required','on'=>'nivel_servicio_marca'),
            array('fecha_inicial, fecha_final, marca_inicial, marca_final, opcion_exp', 'required','on'=>'nivel_servicio_pedido'),
            array('fecha_inicial, fecha_final, marca_inicial, marca_final, opcion_exp', 'required','on'=>'ventas_periodo_prom'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'rent_criterios'),
            array('ruta_inicial, ruta_final', 'required','on'=>'saldo_cartera_ruta'),
            array('vendedor_inicial, vendedor_final', 'required','on'=>'saldo_cartera_vendedor'),
            array('cliente_inicial, cliente_final', 'required','on'=>'saldo_cartera_cliente'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'log_mobile'),
            array('co', 'required','on'=>'saldo_cartera_co'),
            array('fecha_inicial, fecha_final', 'required','on'=>'cliente_x_fecha'),
            array('opcion_exp', 'required','on'=>'vendedores'),
            array('opcion_exp', 'required','on'=>'diferencias_rutas'),
            array('opcion_exp', 'required','on'=>'diferencias_un'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'notas_credito'),
            array('fecha_inicial, fecha_final, des_ora, opcion_exp', 'required','on'=>'rent_item'),
            array('fecha_inicial, fecha_final, des_ora, opcion_exp', 'required','on'=>'rent_item_l560'),
            array('fecha_inicial, fecha_final, cliente', 'required','on'=>'hist_cliente'),
            array('ruta, firma', 'required','on'=>'saldo_cliente'),
            array('ruta, fecha_ret, asesor_ant, firma', 'required','on'=>'cambio_asesor'),
            array('consecutivo', 'required','on'=>'factura_comstar'),
            array('consecutivo', 'required','on'=>'factura_pansell'),
            array('linea, opcion_exp', 'required','on'=>'control_pedidos_linea'),
            array('marca, opcion_exp', 'required','on'=>'control_pedidos_marca'),
            array('des_ora, opcion_exp', 'required','on'=>'control_pedidos_oracle'),
            array('segmento, opcion_exp', 'required','on'=>'control_pedidos_segmento'),
            array('origen, opcion_exp', 'required','on'=>'control_pedidos_origen'),
            array('linea, opcion_exp', 'required','on'=>'pedidos_acum_linea'),
            array('marca, opcion_exp', 'required','on'=>'pedidos_acum_marca'),
            array('des_ora, opcion_exp', 'required','on'=>'pedidos_acum_oracle'),
            array('marca, lista, estado', 'required','on'=>'listas_vs_560'),
            array('consecutivo', 'required','on'=>'venta_empleado'),
            array('fecha_inicial, fecha_final, linea_inicial, linea_final, opcion_exp', 'required','on'=>'nivel_servicio_linea'),
            array('fecha_inicial, fecha_final, vendedor_inicial, vendedor_final, opcion_exp', 'required','on'=>'recaudos_vendedor'),
            array('ruta_inicial, ruta_final, estado, valor, dias, firma', 'required','on'=>'cobro_prejuridico'),
            array('ruta, estado', 'required','on'=>'actualizacion_datos'),
            array('linea, opcion_exp', 'required','on'=>'control_pedidos_linea_lista'),
            array('marca, opcion_exp', 'required','on'=>'control_pedidos_marca_lista'),
            array('fecha_inicial, fecha_final, marca_inicial, marca_final, opcion_exp', 'required','on'=>'rent_inv_marca'),
            array('fecha_inicial, fecha_final, linea_inicial, linea_final, opcion_exp', 'required','on'=>'rent_inv_linea'),
            array('fecha_inicial, fecha_final, des_ora_ini, des_ora_fin, opcion_exp', 'required','on'=>'rent_inv_oracle'),
            //array('recibos', 'required','on'=>'carga_recibos'),
            //array('recibos', 'required','on'=>'verif_recibos'),
            //array('recibos', 'required','on'=>'aplic_recibos'),
            //array('recibos', 'required','on'=>'ent_fis_recibos'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'notas_devolucion'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'notas_anulacion'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'cruce_ant_cli'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'cruce_not_con'),
            array('opcion_exp', 'required','on'=>'error_ept'),
            array('opcion_exp', 'required','on'=>'error_tal'),
            array('fecha, opcion_exp', 'required','on'=>'error_conectores'),
            array('opcion_exp', 'required','on'=>'verificacion_recibos'),
            array('fecha_inicial, fecha_final, marca_inicial, marca_final, opcion_exp', 'required','on'=>'pedidos_pend_des_req_marca'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'docs_asesor'),
            array('fecha_inicial, fecha_final, linea_inicial, linea_final, opcion_exp', 'required','on'=>'pedidos_pend_des_req_linea'),
            array('fecha_inicial, fecha_final, cliente, opcion_exp', 'required','on'=>'rent_x_cliente'),
            array('fecha_inicial, fecha_final, cliente, opcion_exp', 'required','on'=>'rent_x_cliente_560'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'rent_marca_p'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'rent_marca_e'),
            array('opcion_exp', 'required','on'=>'inv_peru'),
            array('opcion_exp', 'required','on'=>'inv_ecuador'),
            array('opcion_exp', 'required','on'=>'inv_cos_peru'),
            array('opcion_exp', 'required','on'=>'inv_cos_ecuador'),
            array('fecha_inicial, fecha_final, marca_inicial, marca_final, opcion_exp', 'required','on'=>'rent_inv_marca_p'),
            array('fecha_inicial, fecha_final, marca_inicial, marca_final, opcion_exp', 'required','on'=>'rent_inv_marca_e'),
            array('fecha_inicial, fecha_final, marca_inicial, marca_final, opcion_exp', 'required','on'=>'pedidos_pend_des_marca_p'),
            array('fecha_inicial, fecha_final, marca_inicial, marca_final, opcion_exp', 'required','on'=>'pedidos_pend_des_marca_e'),
            array('marca, estado, opcion_exp', 'required','on'=>'pedidos_acum_marca_p'),
            array('marca, estado, opcion_exp', 'required','on'=>'pedidos_acum_marca_e'),
            array('fecha_inicial, fecha_final, marca_inicial, marca_final, opcion_exp', 'required','on'=>'rent_marca_item_l560'),
            array('item', 'required','on'=>'lista_materiales'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'cruce_not_car'),
            array('ruta, estado', 'required','on'=>'actualizacion_datos_saldo'),
            array('marca, fecha_inicial, fecha_final', 'required','on'=>'revision_comercial'),
            array('fecha_inicial, fecha_final, ev, opcion_exp', 'required','on'=>'rent_x_estructura_560'),
            array('dias', 'required','on'=>'clientes_pot'),
            array('marca_inicial, marca_final', 'required','on'=>'logistica_exterior'),
            array('cons_inicial, cons_final', 'required','on'=>'naf'),
            array('ev', 'required','on'=>'saldo_cartera_ev'),
            array('opcion_exp', 'required','on'=>'consulta_pagos'),
            array('linea, opcion_exp', 'required','on'=>'pedidos_acum_linea_tot'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'ven_pos_falt'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'ven_pos_entr'),
            array('c_o, tipo, consecutivo', 'required','on'=>'factura_proforma'),
            array('consecutivo', 'required','on'=>'factura_titan'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'rent_criterios_560'),
            array('fecha_inicial, fecha_final', 'required','on'=>'fee_terpel_det'),
            array('fecha_inicial, fecha_final', 'required','on'=>'fee_terpel_cons'),
            array('opcion', 'required','on'=>'cuadro_compras'),
            array('fecha_inicial, fecha_final', 'required','on'=>'hist_lib_ped'),
            array('fecha_inicial, fecha_final', 'required','on'=>'items_exentos_iva'),
            array('cons_inicial, cons_final', 'required','on'=>'desc_b2b'),
            array('des_ora_ini, des_ora_fin', 'required','on'=>'logistica_comercial'),
            array('periodo_inicial, periodo_final, opcion', 'required','on'=>'analisis_ventas'),
            array('fecha_inicial, fecha_final, opcion_exp', 'required','on'=>'pedidos_pend_des_req_top'),
            array('tipo, cons_inicial, cons_final, opcion_exp', 'required','on'=>'consulta_fact_elect'),
        );  
    }

    public function searchByItem($filtro) {
        
        $resp = Yii::app()->db->createCommand("
            SELECT DISTINCT TOP 10  
            f120_id AS ID,
            CONCAT(f120_id,' - ',f120_descripcion) AS DESCR
            FROM UnoEE1..t120_mc_items
            INNER JOIN UnoEE1..t121_mc_items_extensiones ON f120_rowid = f121_rowid_item
            WHERE f120_id_cia = 2 AND (f120_id LIKE '%".$filtro."%' OR f120_descripcion  LIKE '%".$filtro."%') ORDER BY DESCR 
        ")->queryAll();
        return $resp;
        
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'fecha_inicial'=>'Fecha inicial',
            'fecha_final'=>'Fecha final',
            'marca_inicial'=>'Marca inicial',
            'marca_final'=>'Marca final',
            'cliente_inicial'=>'Cliente inicial',
            'cliente_final'=>'Cliente final',
            'opcion_exp'=>'Exportar a',
            'origen' => 'Origen',
            'clase' => 'Clase',
            'canal' => 'Canal',
            'ev' => 'Estructura de ventas',
            'des_ora_ini'=>'Desc. oracle inicial',
            'des_ora_fin'=>'Desc. oracle final',
            'reg'=>'Regional',
            'ruta_inicial'=>'Ruta inicial',
            'ruta_final'=>'Ruta final',
            'vendedor_inicial'=>'Vendedor inicial',
            'vendedor_final'=>'Vendedor final',
            'co'=>'Centro de operación',
            'des_ora'=>'Desc. oracle',
            'archivo' => 'Archivo',
            'firma' => 'Firma',
            'asesor_ant' => 'Asesor antiguo',
            'asesor_nue' => 'Asesor nuevo',
            'fecha_ret' => 'Fecha de retiro',
            'consecutivo' => 'Consecutivo',
            'linea' => 'Línea',
            'marca' => 'Marca',
            'segmento' => 'Segmento',
            'tipo' => 'Tipo',
            'linea_inicial' => 'Línea inicial',
            'linea_final' => 'Línea final',
            'valor' => 'Valor',
            'dias' => 'Días',
            'clasificacion' => 'Clasificación',
            'recibos' => 'Recibos',
            'fecha_cheque' => 'Fecha canje',
            'fecha' => 'Fecha',
            'item' => 'Item',
            'plan' => 'Plan', 
            'criterio' => 'Criterio',
            'cons_inicial' => 'Consecutivo inicial',
            'cons_final' => 'Consecutivo final',
            'c_o'=>'CO',
            'opcion' => 'Opción',
            'periodo_inicial' => 'Periodo inicial',
            'periodo_final' => 'Periodo final',
        );
    }

}