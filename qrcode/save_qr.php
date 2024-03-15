<?php
    if(isset($_POST['base64'])) {
        $base64_image = $_POST['base64'];

        // We need to remove the "data:image/png;base64,"
        $base_to_php = explode(',', $base64_image);
        // the 2nd item in the base_to_php array contains the content of the image
        $data = base64_decode($base_to_php[1]);
        // here you can detect if type is png or jpg if you want
        $filepath = "saved_qrcode/image.png"; // or image.jpg

        // Save the image in a defined path
        file_put_contents($filepath, $data);
    }

