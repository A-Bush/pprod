<?php
  require_once 'getpics.php';
  // connect to the database
  include_once("../../configuration.php");
  $cg = new JConfig;
  $con = mysqli_connect($cg->host, $cg->user, $cg->password, $cg->db);
  if (mysqli_connect_errno())
    die('n/a');
  mysqli_set_charset($con, "utf8");
  // // increase hits
  foreach ($fabrics as $folder => $images){
    
    echo "<h3>Category $folder</h3>";
    $prefix = $cg->dbprefix;
    $query = "SELECT * FROM " . $cg->dbprefix . "k2_categories WHERE alias='".$folder."'";
  //   var_dump($query);
    $category = mysqli_fetch_assoc(mysqli_query($con, $query));
    $id = $category["id"];
    $name = $category["name"];
    var_dump($id);
    $date = date("Y-m-d H:i");
    
    $createTagQuery = createTag($prefix, $folder);

    var_dump(mysqli_query($con, $createTagQuery));
    
    $src = $imgDir.$folder;
    foreach ($images as $key => $value) {
      $img = $src.'/'.$value;
      echo "$img";
      echo "<p>";
      $image = getImg($img);
      $rgbs = rgb($image);
      $avgRgbs = averageRgb($image, $rgbs);
      $hue = getHSL($avgRgbs);
      var_dump($hue);
      $color = markColor($hue);
      echo "$color";
      echo '<div style="width:300px; height:300px; background-color: '.$color.';"></div>';
      echo '<img src="../../images/fabrics/'.$folder.'/'.$value.'">';
      var_dump($value);
      echo "</p>";
      # code...
      $itemTitle = $name."-".$key;
      $itemAlias = $folder."-".$key;
      $extraField = '[{"id":"4","value":"\/images\/fabrics\/'.$folder.'\/'.$value.'"}, {"id":"9","value":"'.$color.'"}]';
      
      $query = "  INSERT INTO " . $cg->dbprefix . "k2_items (`title`, `alias`, `catid`, `published`, `created`, `extra_fields`, `access`, `publish_up`)
                  VALUES ('".$itemTitle."', '".$itemAlias."', '".$id."', '1', '".$date."', '".$extraField."', '1', '".$date."')";
      
      echo "<p>Make Item</p><p>";
      echo($query);
      var_dump(mysqli_query($con, $query));
      $tagItemQuery = tagItem($prefix, $itemAlias, $folder);
      echo "</p>";
      echo "<p>Make Tag</p><p>";
      echo($tagItemQuery);
      var_dump(mysqli_query($con, $tagItemQuery));
      echo "</p>";
    }

  // // $new_hits = mysqli_fetch_assoc(mysqli_query($con, $query));
  // // close the connection to the database
  //   /*/images/fabrics/oxford/_oxford_1741999672.jpg*/
  }

  mysqli_close($con);

?>