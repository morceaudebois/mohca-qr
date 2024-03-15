<?php
    if(isset($_POST['base64']) && isset($_POST['filename'])) {
        $base64_image = $_POST['base64'];
        $filename = $_POST['filename'];

        $base_to_php = explode(',', $base64_image);
        $data = base64_decode($base_to_php[1]);
        $folderpath = "saved_qrcode/";

        if (!is_dir($folderpath)) {
            mkdir($folderpath, 0777, true);
        }

        $filepath = $folderpath . $filename . '.png'; 

        file_put_contents($filepath, $data);
    }
?>
