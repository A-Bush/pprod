<?php 
// $dir = $_SERVER['DOCUMENT_ROOT'];
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
// $dir = dirname(__DIR__);

$imgDir = ROOT.'/popa/rada/images/fabrics/';
// $src = ;
$folders = array_diff(scandir($imgDir, 1), array('..', '.', '.DS_Store'));

$fabrics = array();
// var_dump($folders);

// foreach ($folders as $key => $folder) {
	$folder = 'disco';
	$src = $imgDir.$folder;
	// echo "<h3>$folder</h3>";
	$content = array_diff(scandir($src, 1), array('..', '.', '.DS_Store'));
	# code...
	$images = array_filter($content, function($item){
			$imgExtensions = array(
				'jpg',
				'jpeg',
				'gif',
				'png'
			);
			foreach ($imgExtensions as $img) {
				if(strpos(strtolower($item), $img) != false){
					return $item;
				}
			}
	});
	// var_dump($content);
	$fabrics[$folder] = $images;
// }
	// echo "<p>";
	// 	var_dump($fabrics);
	// echo "</p>";
// echo($src);

	function average($rgb) {
		$imgPath = pathinfo($img);
		$imgExt =  $imgPath['extension'];
		if ( $imgExt == 'jpg' || $imgExt == 'jpeg') {
			# code...
			$img = imagecreatefromjpeg($img);
		}
        $w = imagesx($img);
        $h = imagesy($img);
        $r = $g = $b = 0;
        for($y = 0; $y < $h; $y++) {
            for($x = 0; $x < $w; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                $r += $rgb >> 16;
                $g += $rgb >> 8 & 255;
                $b += $rgb & 255;
            }
        }
        $pxls = $w * $h;
        var_dump(round($r / $pxls), round($g / $pxls), round($b / $pxls));
        $r = dechex(round($r / $pxls));
        $g = dechex(round($g / $pxls));
        $b = dechex(round($b / $pxls));
        if(strlen($r) < 2) {
            $r = 0 . $r;
        }
        if(strlen($g) < 2) {
            $g = 0 . $g;
        }
        if(strlen($b) < 2) {
            $b = 0 . $b;
        }
        return "#" . $r . $g . $b;
    }

  function averageRgb($img, $rgb) {
	
      $w = imagesx($img);
      $h = imagesy($img);
      $r = $g = $b = 0;
      
      $pxls = $w * $h;
      $r = round($rgb[0] / $pxls);
      $g = round($rgb[1] / $pxls);
      $b = round($rgb[2] / $pxls);
      
      return [$r, $g, $b];
  }

  function getImg($file)
  {
		$imgPath = pathinfo($file);
		$imgExt =  $imgPath['extension'];
		$img;
		if ( $imgExt == 'jpg' || $imgExt == 'jpeg') {
			# code...
			$img = imagecreatefromjpeg($file);
		}

		return $img;
  }

  function rgb($img) {
      $w = imagesx($img);
      $h = imagesy($img);
      $r = $g = $b = 0;
      for($y = 0; $y < $h; $y++) {
          for($x = 0; $x < $w; $x++) {
              $rgb = imagecolorat($img, $x, $y);
              $r += $rgb >> 16;
              $g += $rgb >> 8 & 255;
              $b += $rgb & 255;
          }
      }
      return [$r, $g, $b];
  }

  function getHSL($rgbs)
  {
  	$clrR = round($rgbs[0] / 255, 2);
    $clrG = round($rgbs[1] / 255, 2);
    $clrB = round($rgbs[2] / 255, 2);
     
    $clrMin = min($clrR, $clrG, $clrB);
    $clrMax = max($clrR, $clrG, $clrB);
    $deltaMax = $clrMax - $clrMin;

  	if ( $deltaMax == 0 )                     //This is a gray, no chroma...
		{
		   $H = 0;                             //HSL results from 0 to 1
		}
		else                                    //Chromatic data...
		{
			// 				If Red is max, then Hue = (G-B)/(max-min)
			// If Green is max, then Hue = 2.0 + (B-R)/(max-min)
			// If Blue is max, then Hue = 4.0 + (R-G)/(max-min)
		   
		   if( $clrR == $clrMax ) {
		      $H = ($clrG - $clrB) / $deltaMax;

		   }
		   else if ( $clrG == $clrMax ) {

		   	$H = 2.0 + ($clrB - $clrR) / $deltaMax;
		   }
		   else if ( $clrB == $clrMax ) {
		   	$H = 4.0 + ($clrR - $clrG) / $deltaMax;
				}


			$H *= 60; 
		  if ( $H < 0 ) $H += 360;
		}
		$L = round((($clrMax + $clrMin) / 2), 2);
		//If Luminance is smaller then 0.5, then Saturation = (max-min)/(max+min)
		//If Luminance is bigger then 0.5. then Saturation = ( max-min)/(2.0-max-min)
		if($L<0.5){
			$S = round(($clrMax-$clrMin)/($clrMax+$clrMin), 2);
		}else{
			$S = round(($clrMax-$clrMin)/(2.0-$clrMax-$clrMin), 2);
		}
    return [round($H), $S*100, $L*100];
  }

  function markColor($hsl)
  {	
  	$hue = $hsl[0];
  	$s = $hsl[1];
  	$l = $hsl[2];
  	$color;
  	switch (true) {
		    case ($l > 90):
		        $color = 'white';
		        break;
  			case ($s < 10):
		        $color = 'grey';
		        break;
		    case ($l < 10):
		        $color = 'black';
		        break;
		    case ($hue < 20 || $hue >= 350):
		        $color = 'red';
		        break;
		    case ($hue < 350 && $hue >= 300):
		        $color = 'pink';
		        break;
		    case ($hue < 300 && $hue >= 280):
		        $color = 'violet';
		        break;
		    case ($hue < 280 && $hue >= 200):
		        $color = 'blue';
		        break;
		    case ($hue < 200 && $hue >= 180):
		        $color = 'light-blue';
		        break;
		    case ($hue < 180 && $hue >= 70):
		        $color = 'green';
		        break;
		    case ($hue < 70 && $hue >= 50):
		        $color = 'yellow';
		        break;
		    case ($hue < 50 && $hue >= 20):
		        $color = 'orange';
		        break;
		    default: $color = 'black'; 
		    		break;
		}
		return $color;
  }

  function createTag($prefix, $tagName)
  {
  	return "INSERT INTO ".$prefix."k2_tags (`name`, `published`) 
  			VALUES ('".$tagName."', '1');";
  }

  function tagItem($prefix, $itemAlias, $tagName)
  {
  	return "INSERT INTO ".$prefix."k2_tags_xref (`itemID`, `tagID`) 
			VALUES ((SELECT ".$prefix."k2_items.id 
				FROM ".$prefix."k2_items
				WHERE ".$prefix."k2_items.alias = '".$itemAlias."'),
				(SELECT ".$prefix."k2_tags.id 
					FROM ".$prefix."k2_tags
					WHERE ".$prefix."k2_tags.name = '".$tagName."'));";
  }
 ?>