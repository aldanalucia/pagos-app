<?php
require_once '../Controllers/FileController.php';
require_once '../Models/File.php';
require_once '../Models/FileFactory.php';
require_once '../Models/GaliciaFile.php';
require_once '../Models/PlusPagosFile.php';
require_once '../Helpers/Utilities.php';

header('Content-Type: application/json');

$FileController = new \Controller\FileController();

try {
    $data = $FileController->processData();
    $info = $FileController->getInfoFromDataProcessed($data);

    echo json_encode(['data' => $data, 'info' => [$info]]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
