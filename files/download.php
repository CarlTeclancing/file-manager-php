<?php
if (isset($_GET['file'])) {
    $file = 'uploads/' . $_GET['file'];

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        readfile($file);
        exit;
    }
}
