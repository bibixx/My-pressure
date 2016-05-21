<?php
session_start();
$auth = false;
if( array_key_exists("auth", $_SESSION) ){
  $auth = $_SESSION['auth'];
}

if( ($auth == true) ){

  $width  = 1000;
  $height = 600;
  $im = imagecreatetruecolor($width, $height);
  imageantialias( $im, true );
  // imagealphablending($im, true);

  // Allocate color
  $blue       = imagecolorallocate($im, 0, 0, 255);
  $bluelight  = imagecolorallocatealpha($im, 0, 120, 255, (1-0.4)*127);
  $red        = imagecolorallocate($im, 255, 0, 0);
  $redlight   = imagecolorallocatealpha($im, 255, 0, 0, (1-0.4)*127);
  $black      = imagecolorallocate($im, 0, 0, 0);
  $white      = imagecolorallocate($im, 255, 255, 255);
  $aqua       = imagecolorallocate($im, 169, 230, 220);

  $font = "Roboto-Regular.ttf";

  imagefill($im, 0, 0, $white);
  // imagecolortransparent($im, $black);

  $dates = array("01.05.2016", "02.05.2016", "03.05.2016", "04.05.2016", "05.05.2016", "06.05.2016", "07.05.2016", "08.05.2016");
  $arrays =
  array(
    array(
      array( 134, 124, 130, 120, 133, 140, 118, 100 ),
      $red
    ),
    array(
      array( 83, 73, 90, 84, 79, 90, 83, 80 ),
      $blue,
      array( 85, 89, $bluelight )
    )
  );

  $primary = $arrays[0][0];
  $size = imagettfbbox(15, 0, $font, max($primary) );
  $lineLeft = $size[2]-$size[0];
  $linesNumber = 9;
  $linesSpacing = $height / $linesNumber;
  $padding = 30;
  $unitSpacing = ($width-$padding*2-25-$lineLeft-5)/(count($primary)-1);
  $unit = ceil( max( $primary )/(($linesNumber-2)*10) )*10;
  $u = $linesSpacing/$unit;
  $bottomLine = $linesSpacing/2 + $linesSpacing*($linesNumber-1);

  for($x=0; $x<$linesNumber; $x++){
    imageline($im, $lineLeft+5, $linesSpacing/2 + $linesSpacing*$x, $width-25, $linesSpacing/2 + $linesSpacing*$x, $black);
    $size = imagettfbbox(12, 0, $font, $unit*($linesNumber-1) - $x*$unit);
    imagettftext($im, 12, 0, 2+$lineLeft/2-($size[2]-$size[0])/2, $linesSpacing/2 + $linesSpacing*$x + ($size[1]-$size[7])/2, $black, $font, $unit*($linesNumber-1) - $x*$unit);
  }

  imagefilledrectangle($im, $lineLeft+5, $bottomLine - 130*$u, $width-25, $bottomLine - 139*$u, $redlight);

  imagesetthickness($im, 2);

  for($i=0; $i<count($arrays); $i++){
    if( array_key_exists(2, $arrays[$i]) ){
      $range = $arrays[$i][2];
      imagefilledrectangle($im, $lineLeft+5, $bottomLine - $range[0]*$u, $width-25, $bottomLine - $range[1]*$u, $range[2]);
    }

    $plotLine = $arrays[$i][0];
    for($x=0; $x<count($plotLine)-1; $x++){
      $color = $arrays[$i][1];
      $var = $plotLine[$x]*$u;
      $cX1 = $lineLeft+5 + $padding + $unitSpacing*$x;
      $cY1 = $bottomLine - $plotLine[$x]*$u;
      $cX2 = $lineLeft+5 + $padding + $unitSpacing*($x+1);
      $cY2 = $bottomLine - $plotLine[$x+1]*$u;
      imageline($im, $cX1, $cY1-1, $cX2, $cY2-1, $color);
      imageline($im, $cX1, $cY1, $cX2, $cY2, $color);
      imageline($im, $cX1, $cY1+1, $cX2, $cY2+1, $color);
      imageline($im, $cX1, $bottomLine-5, $cX1, $bottomLine+4, $black);
      imageline($im, $cX2, $bottomLine-5, $cX2, $bottomLine+4, $black);
      $size = imagettfbbox(8, 0, $font, to2dig($x+1)."01.2016");
      imagettftext($im, 8, 0, $cX1-($size[2]-$size[0])/2, $bottomLine+20, $black, $font, to2dig($x+1).".01.2016");
      $size = imagettfbbox(8, 0, $font, to2dig($x+2)."01.2016");
      imagettftext($im, 8, 0, $cX2-($size[2]-$size[0])/2, $bottomLine+20, $black, $font, to2dig($x+2).".01.2016");
    }
  }

  header('Content-Type: image/png');
  imagepng($im);
  imagedestroy($im);

} else {
  header("Location: http://localhost/Pressure-calendar/login.php");
  die();
}

function to2dig($a){
  if($a<10){
    return "0".$a;
  } else {
    return $a;
  }
}
?>
