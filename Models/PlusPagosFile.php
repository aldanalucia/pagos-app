<?php

namespace Model;

class PlusPagosFile extends File {

    public function processData(array $data): array {

        $this->validateData($data, $dataProcessed);
        $this->setDataFormat($dataProcessed);

        return $dataProcessed;
    }

    private function validateData($data, &$dataProcessed): void {

        $dataProcessed['nro_transaccion'] = trim(substr($data['row'], $data['indexes']['rows']['transaccion']['index'], $data['indexes']['rows']['transaccion']['lenght']));
        $dataProcessed['nro_transaccion'] = !empty($dataProcessed['nro_transaccion']) ? $dataProcessed['nro_transaccion'] : NULL;

        $dataProcessed['monto'] = trim(substr($data['row'], $data['indexes']['rows']['importe']['index'], $data['indexes']['rows']['importe']['lenght']));
        $dataProcessed['monto'] = !empty($dataProcessed['monto']) ? $dataProcessed['monto'] : 0;

        $dataProcessed['identificador'] = trim(substr($data['row'], $data['indexes']['rows']['cod_servicio_id']['index'], $data['indexes']['rows']['cod_servicio_id']['lenght']));
        $dataProcessed['identificador'] = !empty($dataProcessed['identificador']) ? $dataProcessed['identificador'] : NULL;

        $dataProcessed['fecha_pago'] = trim(substr($data['row'], $data['indexes']['rows']['fecha_pago']['index'], $data['indexes']['rows']['fecha_pago']['lenght']));
        $dataProcessed['fecha_pago'] = !empty($dataProcessed['fecha_pago']) ? $dataProcessed['fecha_pago'] : NULL;

        $dataProcessed['medio_de_pago'] = trim(substr($data['row'], $data['indexes']['rows']['forma_pago']['index'], $data['indexes']['rows']['forma_pago']['lenght']));
        $dataProcessed['medio_de_pago'] = !empty($dataProcessed['medio_de_pago']) ? $dataProcessed['medio_de_pago'] : NULL;
    }

    private function setDataFormat(&$dataProcessed): void {

        $dataProcessed['nro_transaccion'] = !is_null($dataProcessed['nro_transaccion']) ? str_pad($dataProcessed['nro_transaccion'], 15, 0, STR_PAD_LEFT) : 'N/A';
        $dataProcessed['monto'] = parseFloatToString($dataProcessed['monto'] / 100);
        $dataProcessed['identificador'] = !is_null($dataProcessed['identificador']) ? str_pad($dataProcessed['identificador'], 19, 0, STR_PAD_LEFT) : 'N/A';
        $dataProcessed['fecha_pago'] = !is_null($dataProcessed['fecha_pago']) ? convertDateFromString($dataProcessed['fecha_pago']) : 'N/A';

        switch ($dataProcessed['medio_de_pago']) {
            case '00':
                $dataProcessed['medio_de_pago'] = 'Efectivo';
                break;
            case '90':
                $dataProcessed['medio_de_pago'] = 'Tarjeta de Débito';
                break;
            case '99':
                $dataProcessed['medio_de_pago'] = 'Tarjeta de Crédito';
                break;
            case NULL:
                $dataProcessed['medio_de_pago'] = 'N/A';
                break;
        }
    }

    public function getStructureFile(): array {

        $structure = [
            'header' => [
                'tipo_registro' => [
                    'lenght' => 6 ,
                    'index' => NULL
                ],
                'cod_ante_bcra' => [
                    'lenght' => 3 ,
                    'index' => NULL
                ],
                'fecha_proceso' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'fecha_aplanado' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'nro_lote' => [
                    'lenght' => 5,
                    'index' => NULL
                ],
            ],
            'rows' => [
                'datos_constante' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'cod_ante_bcra' => [
                    'lenght' => 4,
                    'index' => NULL
                ],
                'r_constante' => [
                    'lenght' => 1,
                    'index' => NULL
                ],
                'cod_terminal' => [
                    'lenght' => 5,
                    'index' => NULL
                ],
                'cod_parsub' => [
                    'lenght' => 10,
                    'index' => NULL
                ],
                'cod_boca' => [
                    'lenght' => 4,
                    'index' => NULL
                ],
                'nro_secuencia' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'transaccion' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'cod_operacion' => [
                    'lenght' => 2,
                    'index' => NULL
                ],
                'relleno_1' => [
                    'lenght' => 2,
                    'index' => NULL
                ],
                'relleno_2' => [
                    'lenght' => 2,
                    'index' => NULL
                ],
                'cod_ente' => [
                    'lenght' => 4,
                    'index' => NULL
                ],
                'cod_servicio_id' => [
                    'lenght' => 19,
                    'index' => NULL
                ],
                'importe' => [
                    'lenght' => 11,
                    'index' => NULL
                ],
                'relleno_3' => [
                    'lenght' => 11,
                    'index' => NULL
                ],
                'relleno_4' => [
                    'lenght' => 11,
                    'index' => NULL
                ],
                'moneda' => [
                    'lenght' => 1,
                    'index' => NULL
                ],
                'cod_cajero' => [
                    'lenght' => 4,
                    'index' => NULL
                ],
                'relleno_5' => [
                    'lenght' => 3,
                    'index' => NULL
                ],
                'relleno_6' => [
                    'lenght' => 2,
                    'index' => NULL
                ],
                'cod_seguridad' => [
                    'lenght' => 3,
                    'index' => NULL
                ],
                'relleno_fecha_primer_vto' => [
                    'lenght' => 6,
                    'index' => NULL
                ],
                'relleno_7' => [
                    'lenght' => 6,
                    'index' => NULL
                ],
                'bco_cheque' => [
                    'lenght' => 3,
                    'index' => NULL
                ],
                'sucursal' => [
                    'lenght' => 3,
                    'index' => NULL
                ],
                'cod_postal' => [
                    'lenght' => 4,
                    'index' => NULL
                ],
                'nro_cheque' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'nro_cuenta' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'plazo' => [
                    'lenght' => 3,
                    'index' => NULL
                ],
                'cod_barra' => [
                    'lenght' => 60,
                    'index' => NULL
                ],
                'fecha_pago' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'modo_pago' => [
                    'lenght' => 1,
                    'index' => NULL
                ],
                'relleno_8' => [
                    'lenght' => 7,
                    'index' => NULL
                ],
                'relleno_9' => [
                    'lenght' => 9,
                    'index' => NULL
                ],
                'forma_pago' => [
                    'lenght' => 2,
                    'index' => NULL
                ],
                'relleno_10' => [
                    'lenght' => 4,
                    'index' => NULL
                ],
                'relleno_11' => [
                    'lenght' => 3,
                    'index' => NULL
                ],
                'relleno_autorizacion' => [
                    'lenght' => 15,
                    'index' => NULL
                ],
                'relleno_12' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
            ],
            'footer' => [
                'tipo_registro' => [
                    'lenght' => 7,
                    'index' => NULL
                ],
                'tipo_prestacion' => [
                    'lenght' => 7,
                    'index' => NULL
                ],
                'importe' => [
                    'lenght' => 13,
                    'index' => NULL
                ],
                'cantidad_trx' => [
                    'lenght' => 7,
                    'index' => NULL
                ],
            ],
        ];

        return self::calculateIndexStructure($structure);
    }
}