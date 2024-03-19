<?php

namespace Model;

class GaliciaFile extends File {

    public function processData(array $data): array {

        $this->validateData($data, $dataProcessed);
        $this->setDataFormat($dataProcessed);

        return $dataProcessed;
    }

    private function validateData($data, &$dataProcessed): void {

        $dataProcessed['nro_transaccion'] = trim(substr($data['row'], $data['indexes']['rows']['ref_univoca']['index'], $data['indexes']['rows']['ref_univoca']['lenght']));
        $dataProcessed['nro_transaccion'] = !empty($dataProcessed['nro_transaccion']) ? $dataProcessed['nro_transaccion'] : NULL;

        # TODO: importe_cobrado o importe_primer_vto ? FOOTER maneja 1er vto.
        $dataProcessed['monto'] = trim(substr($data['row'], $data['indexes']['rows']['importe_primer_vto']['index'], $data['indexes']['rows']['importe_primer_vto']['lenght']));
        $dataProcessed['monto'] = !empty($dataProcessed['monto']) ? $dataProcessed['monto'] : 0;

        $dataProcessed['identificador'] = trim(substr($data['row'], $data['indexes']['rows']['id_cliente']['index'], $data['indexes']['rows']['id_cliente']['lenght']));
        $dataProcessed['identificador'] = !empty($dataProcessed['identificador']) ? $dataProcessed['identificador'] : NULL;

        $dataProcessed['fecha_pago'] = trim(substr($data['row'], $data['indexes']['rows']['fecha_cobro']['index'], $data['indexes']['rows']['fecha_cobro']['lenght']));
        $dataProcessed['fecha_pago'] = !empty($dataProcessed['fecha_pago']) ? $dataProcessed['fecha_pago'] : NULL;

        $dataProcessed['medio_de_pago'] = trim(substr($data['headerFile'], $data['indexes']['header']['servicio']['index'], $data['indexes']['header']['servicio']['lenght']));
        $dataProcessed['medio_de_pago'] = !empty($dataProcessed['medio_de_pago']) ? $dataProcessed['medio_de_pago'] : NULL;
    }

    private function setDataFormat(&$dataProcessed): void {

        $dataProcessed['nro_transaccion'] = $dataProcessed['nro_transaccion'] ?? 'N/A';
        $dataProcessed['monto'] = parseNumberToString($dataProcessed['monto']);
        $dataProcessed['identificador'] = $dataProcessed['identificador'] ?? 'N/A';
        $dataProcessed['fecha_pago'] = !is_null($dataProcessed['fecha_pago']) ? convertDateFromString($dataProcessed['fecha_pago']) : 'N/A';

        switch ($dataProcessed['medio_de_pago']) {
            case 'D':
                $dataProcessed['medio_de_pago'] = 'Débito Automático';
                break;
            case 'P':
                $dataProcessed['medio_de_pago'] = 'Pago Automático';
                break;
            case 'C':
                $dataProcessed['medio_de_pago'] = 'Sistema Nac. de Pagos';
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
                    'lenght' => 4 ,
                    'index' => NULL
                ],
                'tipo_prestacion' => [
                    'lenght' => 4 ,
                    'index' => NULL
                ],
                'servicio' => [
                    'lenght' => 1 ,
                    'index' => NULL
                ],
                'fecha_generacion' => [
                    'lenght' => 8 ,
                    'index' => NULL
                ],
                'identificacion_archivo' => [
                    'lenght' => 1 ,
                    'index' => NULL
                ],
                'origen' => [
                    'lenght' => 7 ,
                    'index' => NULL
                ],
                'importe_total' => [
                    'lenght' => 14 ,
                    'index' => NULL
                ],
                'cantidad_registros' => [
                    'lenght' => 7 ,
                    'index' => NULL
                ],
                'libre' => [
                    'lenght' => 304 ,
                    'index' => NULL
                ],
            ],
            'rows' => [
                'tipo_registro' => [
                    'lenght' => 4,
                    'index' => NULL
                ],
                'id_cliente' => [
                    'lenght' => 22,
                    'index' => NULL
                ],
                'cbu' => [
                    'lenght' => 26,
                    'index' => NULL
                ],
                'ref_univoca' => [
                    'lenght' => 15,
                    'index' => NULL
                ],
                'fecha_primer_vto.' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'importe_primer_vto' => [
                    'lenght' => 14,
                    'index' => NULL
                ],
                'fecha_segundo_vto' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'importe_segundo_vto' => [
                    'lenght' => 14,
                    'index' => NULL
                ],
                'fecha_tercer_vto' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'importe_tercer_vto' => [
                    'lenght' => 14,
                    'index' => NULL
                ],
                'moneda' => [
                    'lenght' => 1,
                    'index' => NULL
                ],
                'motivo_rechazo' => [
                    'lenght' => 3,
                    'index' => NULL
                ],
                'tipo_documento' => [
                    'lenght' => 4,
                    'index' => NULL
                ],
                'nro_documento' => [
                    'lenght' => 11,
                    'index' => NULL
                ],
                'nuevo_id_cliente' => [
                    'lenght' => 22,
                    'index' => NULL
                ],
                'nuevo_cbu' => [
                    'lenght' => 26,
                    'index' => NULL
                ],
                'importe_min' => [
                    'lenght' => 14,
                    'index' => NULL
                ],
                'fecha_prox_vto' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'id_cliente_anterior' => [
                    'lenght' => 22,
                    'index' => NULL
                ],
                'mensaje_atm' => [
                    'lenght' => 40,
                    'index' => NULL
                ],
                'concepto_factura' => [
                    'lenght' => 10,
                    'index' => NULL
                ],
                'fecha_cobro' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'importe_cobrado' => [
                    'lenght' => 14,
                    'index' => NULL
                ],
                'fecha_acreditamiento' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'libre' => [
                    'lenght' => 26,
                    'index' => NULL
                ],
            ],
            'footer' => [
                'tipo_registro' => [
                    'lenght' => 4,
                    'index' => NULL
                ],
                'tipo_prestacion' => [
                    'lenght' => 4,
                    'index' => NULL
                ],
                'servicio' => [
                    'lenght' => 1,
                    'index' => NULL
                ],
                'fecha_generacion' => [
                    'lenght' => 8,
                    'index' => NULL
                ],
                'identificacion_archivo' => [
                    'lenght' => 1,
                    'index' => NULL
                ],
                'origen' => [
                    'lenght' => 7,
                    'index' => NULL
                ],
                'importe_total' => [
                    'lenght' => 14,
                    'index' => NULL
                ],
                'cantidad_registros' => [
                    'lenght' => 7,
                    'index' => NULL
                ],
                'libre' => [
                    'lenght' => 304,
                    'index' => NULL
                ],
            ],
        ];

        return self::calculateIndexStructure($structure);
    }
}