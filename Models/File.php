<?php

namespace Model;

use Exception;

abstract class File {

    /**
     * Obtiene la estructura de un archivo, incluyendo la estructura del encabezado, las filas y el pie de página.
     *
     * @return array
     */
    abstract public function getStructureFile(): array;

    /**
     * Procesa los datos recibidos para su posterior tratamiento.
     *
     * @param array $data
     * @return array
     */
    abstract public function processData(array $data): array;

    /**
     * Procesa un archivo ubicado en el directorio de pagos y devuelve los datos procesados.
     *
     * @param string $path
     * @return array
     * @throws Exception
     */
    public function processFile(string $path): array {

        try {
            $file = fopen($path, 'r');
            $data = [];

            if ($file) {

                $fileData = [
                    'indexes' => $this->getStructureFile(),
                    'headerFile' => fgets($file)
                ];

                while ($row = fgets($file)) {

                    if (!$this->isEmptyField($row)) {
                        $fileData['row'] = $row;
                        $data[] = $this->processData($fileData);
                    }
                }

                array_pop($data);
                fclose($file);

            } else
                throw new Exception('Error al intentar abrir archivo', 404);

        } catch (Exception $e) {
            throw new Exception('Error al procesar archivo', 404);
        }

        return $data;
    }

    /**
     * Calcula los índices para la estructura de datos basados en la longitud de cada campo.
     *
     * @param array $structure
     * @return mixed
     */
    protected function calculateIndexStructure(array $structure): array {

        foreach ($structure as $keyStructure => $rowStructure) {
            $newIndex = 0;
            foreach ($rowStructure as $keyRow => $row) {
                $structure[$keyStructure][$keyRow]['index'] += $newIndex;
                $newIndex += $row['lenght'];
            }
        }

        return $structure;
    }

    /**
     * Verifica si un campo de fila está vacío.
     *
     * @param string $row
     * @return bool
     */
    private function isEmptyField(string &$row): bool {

        $row = trim($row, "\x1A");
        return empty($row);
    }
}