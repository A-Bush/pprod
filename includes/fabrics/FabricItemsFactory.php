<?php 
/**
* FabricItemsFactory
*/
class FabricItemsFactory
{
	private $path;
	private $imgPath;
	private $folders = array();
	private $fabrics = array();
	private $categories = array();
	private $prefix;
	private $connection;
	private $fabricCategoryName;

	
	function __construct($imgPath, $path, $root='')
	{
		if(strpos($path, '/') !== false){
			$this->path = $path;
			$this->folders = $this->twoLevelsFolders();
		}else{
			$this->path = $root;
			$this->folders[] = $path;
		}
		$this->imgPath = $imgPath;
	}

	private function twoLevelsFolders()
	{
		if(file_exists($this->path) && is_dir($this->path)){

			return array_diff(scandir($this->path, 1), array('..', '.', '.DS_Store'));
		}
		return false;
	}

	public function connectToDB($cg)
	{
		$con = mysqli_connect($cg->host, $cg->user, $cg->password, $cg->db);
		if (mysqli_connect_errno())
		die('n/a');
		mysqli_set_charset($con, "utf8");

		$this->connection = $con;
		$this->prefix = $cg->dbprefix;
		return $this->connection;
	}

	public function insertItemsToDB($value='')
	{
		$this->getImagesFromFolders();/*$this->fabrics*/
		var_dump($this->fabrics);
		echo "<hr>";
		var_dump($this->queryCategories());
		$this->loopFoldersAndCall('', $value);

	}

	private function getImagesFromFolder($folder)
	{
		$src = $this->path.$folder;

		if(file_exists($src) && is_dir($src)){
			$content = array_diff(scandir($src, 1), array('..', '.', '.DS_Store'));
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
			$this->fabrics[$folder] = $images;
			return $this->fabrics[$folder];
		}
	}

	private function loopFoldersAndCall($cb1='', $cb2='')
	{
		foreach ($this->fabrics as $fabric => $images) {
			$path = $this->path.$fabric.'/';
			
			if(isset($this->categories)){
				$category = $this->categories[$fabric];
				$catid = $category["id"];
				$catname = $category["name"];
			}
			
			echo "<p>this->path = {$this->path}</p>";
			echo "<p>this->imgPath = {$this->imgPath}</p>";
			echo "<p>cat id = {$catid}</p>";
			echo "<p>fabric = {$fabric}</p>";
			/*Images*/
			// echo "<p>Images in Folders</p>";
			// echo "<p>folder = {$fabric}</p>";
			foreach ($images as $key => $image) {
				/*category name required*/
				$itemAlias = $fabric."-".$key;
				if(isset($catname)){
	    		$itemTitle = $catname."-".$key;
				
					if ($cb2 =='new item') {
						var_dump($this->queryNewItem($itemAlias, $itemTitle, $catid, $catname));
						echo "<hr>";
					}
					if ($cb2 =='new item' || $cb2 =='new fabric'){
						$result = $this->queryCreateFabricCategory($path, $image, $itemAlias);
						if (!$result) {
							echo mysqli_error($this->connection);
							echo mysqli_errno($this->connection);
						}
						echo "<hr>";
					}
				}
				if ($cb2 =='update fabric') {
					var_dump($this->queryUpdateFabricCategory($itemAlias, '', '', $this->imgPath.$fabric.'/'.$image));
					echo "<hr>";
				}
				// echo "<p>itemAlias = {$itemAlias}</p>";
			}
				echo "<hr>";
		}
	}



	public function getImagesFromFolders()
	{	
		if(empty($this->folders)){
			$this->fabrics[$this->path] = $this->getImagesFromFolder($this->path);
		}else{
			foreach ($this->folders as $key => $folder) {

				$this->fabrics[$folder] = $this->getImagesFromFolder($folder);
			}
		}
		return $this->fabrics;
	}

	public function markImageColor($img)
	{
		$image = $this->getImg($img);
    $rgbs = $this->rgb($image);
    $avgRgbs = $this->averageRgb($image, $rgbs);
    $hue = $this->getHSL($avgRgbs);
    return $this->markColor($hue);
	}


	private function queryCategories($parent='13')
	{
		if(isset($this->prefix)){
			$query = "SELECT id, name, alias FROM " . $this->prefix . "k2_categories WHERE parent='".$parent."'";
    	$result = mysqli_query($this->connection, $query);
    	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		    $this->categories[$row['alias']] = array(	'id' => $row['id'], 
		    																					'name' => $row['name']);
		  }
    	return $this->categories;
		}
	}

	public function queryExistingItems($field, $value)
	{
		return "SELECT id 
						FROM ".$this->prefix."k2_items
						WHERE ".$field." = '".$value."';";
	}

	public function addToItems($value='')
	{
		# code...
	}

	public function queryNewItem($itemAlias, $itemTitle, $catid, $catname)
	{	
    $date = date("Y-m-d H:i");
		if(isset($this->prefix)){
      return  "INSERT INTO " . $this->prefix . "k2_items (`title`, `alias`, `catid`, `published`, `created`, `access`, `publish_up`)
            VALUES ('".$itemTitle."', '".$itemAlias."', '".$catid."', '1', '".$date."', '1', '".$date."');";
		}
	}

	public function queryCreateFabricCategory($path, $image, $itemAlias)
  {
		$color = $this->markImageColor($path.$image);
  	$query = "INSERT INTO ".$this->prefix."fabrics (`fabric`, `color`, `image`, `itemID`) 
  			VALUES ('".$this->fabricCategoryName."', '".$color
  				."', '".$this->imgPath.$image."',
  				(SELECT ".$this->prefix."k2_items.id 
							FROM ".$this->prefix."k2_items
							WHERE ".$this->prefix."k2_items.alias = '".$itemAlias."'));";
  	echo $query;
  	return mysqli_query($this->connection, $query);
  }

  public function queryUpdateFabricCategory($itemAlias, $fabric='', $color='', $image='')
  {
		// $color = $this->markImageColor($path.$image);
		$set = "";
		
		if(!empty($fabric)){
			$set .= "`fabric`='".$fabric."',";
		}
		if(!empty($color)){
			$set .= "`color`='".$color."',";
		}
		if(!empty($image)){
			$set .= "`image`='".$image."',";
		}
		$set = rtrim($set,',');

  	$query = "UPDATE `".$this->prefix."fabrics` 
  	SET ".$set."
  	WHERE `itemId`=(SELECT ".$this->prefix."k2_items.id 
							FROM ".$this->prefix."k2_items
							WHERE ".$this->prefix."k2_items.alias = '".$itemAlias."');";
  	
  	echo $query;
  	return mysqli_query($this->connection, $query);
  }


  public function tagItem($itemAlias, $tagName)
  {
  	return "INSERT INTO ".$this->prefix."k2_tags_xref (`itemID`, `tagID`) 
			VALUES ((SELECT ".$this->prefix."k2_items.id 
				FROM ".$this->prefix."k2_items
				WHERE ".$this->prefix."k2_items.alias = '".$itemAlias."'),
				(SELECT ".$this->prefix."k2_tags.id 
					FROM ".$this->prefix."k2_tags
					WHERE ".$this->prefix."k2_tags.name = '".$tagName."'));";
  }

	private function markColor($hsl)
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

	private function averageRgb($img, $rgb) {
	
      $w = imagesx($img);
      $h = imagesy($img);
      $r = $g = $b = 0;
      
      $pxls = $w * $h;
      $r = round($rgb[0] / $pxls);
      $g = round($rgb[1] / $pxls);
      $b = round($rgb[2] / $pxls);
      
      return [$r, $g, $b];
  }

  private function getImg($file)
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

  private function rgb($img) {
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

  private function getHSL($rgbs)
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

    /**
     * Gets the value of path.
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Gets the value of folders.
     *
     * @return mixed
     */
    public function getFolders()
    {
        return $this->folders;
    }

    /**
     * Sets the value of folders.
     *
     * @param mixed $folders the folders
     *
     * @return self
     */
    public function setFolders($folders)
    {
        $this->folders = $folders;

        return $this;
    }

    /**
     * Gets the value of fabrics.
     *
     * @return mixed
     */
    public function getFabrics()
    {
        return $this->fabrics;
    }

    /**
     * Sets the value of fabrics.
     *
     * @param mixed $fabrics the fabrics
     *
     * @return self
     */
    public function setFabrics($fabrics)
    {
        $this->fabrics = $fabrics;

        return $this;
    }

    /**
     * Sets the value of path.
     *
     * @param mixed $path the path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }


    /**
     * Gets the value of prefix.
     *
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    public function setFabricCategoryName($fabricCategoryName)
    {
        $this->fabricCategoryName = $fabricCategoryName;
    }
}
 ?>