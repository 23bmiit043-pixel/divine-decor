<?php
$tcpdf_dir = __DIR__ . '/TCPDF-main';

// Create directory if it doesn't exist
if (!file_exists($tcpdf_dir)) {
    mkdir($tcpdf_dir, 0777, true);
}

// Download TCPDF from main branch
$zip_url = 'https://github.com/tecnickcom/TCPDF/archive/refs/heads/main.zip';
$zip_file = __DIR__ . '/tcpdf.zip';

// Download and extract
if (file_put_contents($zip_file, file_get_contents($zip_url))) {
    $zip = new ZipArchive;
    if ($zip->open($zip_file) === TRUE) {
        $zip->extractTo(__DIR__);
        $zip->close();
        unlink($zip_file);
        echo "TCPDF has been successfully installed to: " . $tcpdf_dir;
    } else {
        echo "Failed to extract TCPDF files.";
    }
} else {
    echo "Failed to download TCPDF.";
}
?>
