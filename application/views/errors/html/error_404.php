<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$ci = new CI_Controller();
$ci =& get_instance();

$now = date('YmdHis');
?>

<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>404 Page Not Found</title>
  
  	    <!-- Favicon -->
	    <?php
	    if (file_exists('uploads/favicon')) {
	      $favicon = 'uploads/favicon';
	    } else {
	      $favicon = 'assets/favicon.png';
	    }
	    ?>
  	 	<link rel="shortcut icon" href="<?php echo base_url($favicon) . '?time=' . $now; ?>"/>

      <link rel="stylesheet" href="<?php echo base_url('assets/404/css/bootstrap.min.css'); ?>">

      <link rel="stylesheet" href="<?php echo base_url('assets/404/css/style.css'); ?>">

  
</head>

<body>

  <link href='https://fonts.googleapis.com/css?family=Anton|Passion+One|PT+Sans+Caption' rel='stylesheet' type='text/css'>
<body>

        <!-- Error Page -->
            <div class="error">
                <div class="container-floud">
                    <div class="col-xs-12 ground-color text-center">
                        <div class="container-error-404">
                            <div class="clip"><div class="shadow"><span class="digit thirdDigit"></span></div></div>
                            <div class="clip"><div class="shadow"><span class="digit secondDigit"></span></div></div>
                            <div class="clip"><div class="shadow"><span class="digit firstDigit"></span></div></div>
                            <div class="msg">OH!<span class="triangle"></span></div>
                        </div>
                        <h2 class="h1">Sorry! Page not found</h2>
                    </div>
                </div>
            </div>
        <!-- Error Page -->
</body>
  
  

    <script  src="<?php echo base_url('assets/404/js/index.js'); ?>"></script>




</body>

</html>
