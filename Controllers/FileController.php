<?php

namespace Controller;

use Exception;
use Model\FileFactory;

class FileController {

    const DIRECTORY_PAYMENTS = '../Payments';

    /**
     * Procesa los archivos en el directorio Payments y devuelve los datos procesados.
     *
     * @return array
     * @throws Exception
     */
    public function processData(): array {

        $rowsData = [];
        $handle = opendir(self::DIRECTORY_PAYMENTS);
        if ($handle) {

            $Factory = new FileFactory();

            while (($entry = readdir($handle)) !== FALSE) {

                $path = self::DIRECTORY_PAYMENTS.'/'.$entry;

                if (is_file($path)) {
                    $file = basename($path);
                    $FileModel = $Factory->createObject($file);
                    $fileProcessed = $FileModel->processFile($path);
                    $rowsData = array_merge($rowsData, $fileProcessed);
                }
            }
        }
        closedir($handle);

        if (empty($rowsData))
            throw new Exception('No hay datos procesados disponibles.', 404);

        return $rowsData;
    }

    /**
     * Obtiene información resumida a partir de los datos procesados.
     *
     * @param $dataProcessed
     * @return array
     * @throws Exception
     */
    public function getInfoFromDataProcessed($dataProcessed): array {

        if (empty($dataProcessed))
            throw new Exception('No hay datos procesados disponibles.', 404);

        return [
            'total_records' => $this->getTotalRecords($dataProcessed),
            'total_amount' => $this->getTotalAmount($dataProcessed),
            'average_payment_method' => $this->getAverageByPaymentMethod($dataProcessed),
        ];
    }

    /**
     * Obtiene el total de registros procesados.
     *
     * @param array $data
     * @return int
     */
    public function getTotalRecords(array $data): int {

        return count($data);
    }

    /**
     * Obtiene el importe total de transacciones procesadas.
     *
     * @param array $data
     * @return string
     */
    public function getTotalAmount(array $data): string {

        # TODO: revisar cálculo
        $totalAmount = 0;

        foreach ($data as $resultData) {
            $totalAmount += parseStringToFloat($resultData['monto']);
        }

        return parseFloatToString($totalAmount);
    }

    /**
     * Obtiene el valor promedio de transacciones por medio de pago procesado.
     *
     * @param array $data
     * @return array
     */
    public function getAverageByPaymentMethod(array $data): array {

        $totalTax = [];
        $averageByPaymenthMethod = [];

        foreach ($data as $resultData) {

            if (!isset($totalTax[$resultData['medio_de_pago']])) {
                $totalTax[$resultData['medio_de_pago']]['amount'] = 0;
                $totalTax[$resultData['medio_de_pago']]['count']  = 0;
            }

            $totalTax[$resultData['medio_de_pago']]['amount'] += parseStringToFloat($resultData['monto']);
            $totalTax[$resultData['medio_de_pago']]['count']++;
        }

        foreach ($totalTax as $keyPaymentMethod => $result) {
            $averageByPaymenthMethod[$keyPaymentMethod] = parseFloatToString($result['amount'] / $result['count']);
        }

        return $averageByPaymenthMethod;
    }
}