<?php

namespace Model;

class FileFactory {

    /**
     * Crea un objeto hijo de la clase abstracta File según la nomenclatura de valores fijos en el nombre de archivo.
     *
     * @param string $file
     * @return object
     */
    public function createObject(string $file): object {

        switch (true) {
            default:
            case (preg_match('/^REND\./', $file)):
                return new GaliciaFile();
            case (preg_match('/^888ENTES/', $file)):
                return new PlusPagosFile();
        }
    }
}