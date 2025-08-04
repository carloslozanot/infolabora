<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedulas = $_POST['cedulas'] ?? [];

    if (empty($cedulas)) {
        http_response_code(400);
        echo "No se recibieron cédulas.";
        exit;
    }

    $zip = new ZipArchive();
    $zipFile = tempnam(sys_get_temp_dir(), 'certificados_') . '.zip';

    if ($zip->open($zipFile, ZipArchive::CREATE) !== TRUE) {
        http_response_code(500);
        echo "No se pudo crear el archivo ZIP.";
        exit;
    }

    foreach ($cedulas as $ced) {
        $cedula = intval($ced);
        $pdfTemp = "temp/certificado_$cedula.pdf";

        include("fpdf/referencia_generar.php"); // genera el PDF

        if (file_exists($pdfTemp)) {
            $zip->addFile($pdfTemp, basename($pdfTemp));
        }
    }

    $zip->close();

    // Forzar descarga del ZIP
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="certificados.zip"');
    header('Content-Length: ' . filesize($zipFile));
    readfile($zipFile);

    // Limpieza
    unlink($zipFile);
    foreach (glob("temp/certificado_*.pdf") as $tempPDF) {
        unlink($tempPDF);
    }

    exit;
}
?>
