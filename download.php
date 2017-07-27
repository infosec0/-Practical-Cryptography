file_put_contents($tmp, $result); 
    $filepath='upload/'.$filepath;
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($tmp));
            readfile($tmp);
            unlink($tmp);
}
