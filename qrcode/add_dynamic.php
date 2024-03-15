<?php
/**
* PHP Dynamic Qr code
*
* @author    Giandonato Inverso <info@giandonatoinverso.it>
* @copyright Copyright (c) 2020-2021
* @license   https://opensource.org/licenses/MIT MIT License
* @link      https://github.com/giandonatoinverso/PHP-Dynamic-Qr-code
* @version   1.0
*/

session_start();
require_once 'config/config.php';
require_once BASE_PATH.'/includes/auth_validate.php';

// Dynamic qrcode class
require_once BASE_PATH . '/lib/Dynamic_Qrcode/Dynamic_Qrcode.php';
$dynamic_qrcode = new Dynamic_Qrcode();

// Serve POST method, After successful insert, redirect to dynamic_qrcodes.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST')
    $dynamic_qrcode->add();
?>

<script src="./lib/qrcode-with-logos.min.js"></script>

<!DOCTYPE html>
<html lang="en">
    <title>Add dynamic - Qrcode Generator</title>
    <head>
    <?php include './includes/head.php'; ?>
    </head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <?php include './includes/navbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include './includes/sidebar.php'; ?>
  <!-- /.Main Sidebar Container -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add qr code</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Flash message-->
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>
    <!-- /.Flash message-->
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Enter the requested data</h3>
            </div>
            <form class="form" method="post" enctype="multipart/form-data">
                <div class="card-body">
                <?php include BASE_PATH.'/forms/add_dynamic_form.php'; ?>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" onclick="qrlogoscript()">Submit</button>
                </div>
            </form>
        </div>
       </div><!--/. container-fluid -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

<!-- Footer and scripts -->
<?php include './includes/footer.php'; ?>

<!-- Page script -->
<script type="text/javascript">
// $(document).ready(function(){
//    $('#dynamic_form').validate({
//        rules: {
//             filename: {
//                 required: true,
//             },
//             link: {
//                 required: true,
//                 minlength: 3
//             },   
//         }
//     });
// });

function qrlogoscript() {
    var backgroundValue = document.getElementById('background').value;
    var foregroundValue = document.getElementById('foreground').value;
    var sizeValue = document.querySelector('select[name="size"]').value;
    var levelValue = document.querySelector('select[name="level"]').value;
    var logoFile = document.querySelector('input[name="logo"]').files[0];
    var linkValue = document.querySelector('input[name="link"]').value;
    var filenameValue = document.querySelector('input[name="filename"]').value;
    // var formatValue = document.querySelector('select[name="format"]').value;

    // console.log('Background color:', backgroundValue);
    // console.log('Foreground color:', foregroundValue);
    // console.log('Level:', levelValue);
    // console.log('Size:', sizeValue);
    // console.log('Logo file:', logoFile);
    // console.log('Link:', linkValue);
    // console.log('Filename:', filenameValue);

    if (logoFile) {
        var reader = new FileReader();
        reader.onload = function(event) {
            var logoUrl = event.target.result;

            let qrcode = new QrCodeWithLogo({
                content: linkValue,
                width: sizeValue,
                // download: true,
                logo: {
                    src: logoUrl
                },
                nodeQrCodeOptions: {
                    color: {
                        light: backgroundValue,
                        dark: foregroundValue
                    },
                    errorCorrectionLevel: levelValue
                },
                downloadName: filenameValue
            });
        };

        reader.readAsDataURL(logoFile);
    } else {
        let qrcode = new QrCodeWithLogo({
            content: linkValue,
            width: sizeValue,
            // download: true,
            nodeQrCodeOptions: {
                color: {
                    light: backgroundValue,
                    dark: foregroundValue
                },
                errorCorrectionLevel: levelValue
            },
            downloadName: filenameValue
        });
    }
}



</script>
<script>
  $(function () {

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

  })

</script>
</body>
</html>
