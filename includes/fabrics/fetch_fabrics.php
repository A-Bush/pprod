<?php

  // connect to the database
  include_once("../../configuration.php");
  $cg = new JConfig;
  $con = mysqli_connect($cg->host, $cg->user, $cg->password, $cg->db);
  if (mysqli_connect_errno())
    die('n/a');

  mysqli_set_charset($con, "utf8");
  $query = "SELECT c.name, c.description, i.id, i.title, i.alias, i.hits, i.extra_fields
            FROM ".$cg->dbprefix."k2_categories as c
            INNER JOIN  ".$cg->dbprefix."k2_items as i ON c.id = i.catid
            WHERE c.parent = 13 AND i.published=1 AND i.trash=0";
  $result = mysqli_query($con, $query);
  $fabric = array();
  $assoc = array();
  $objects = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $extra_fields = json_decode($row['extra_fields'], true);
    $type = array_search('11', array_column($extra_fields, 'id'));
    if($type !== false){
      $type = $extra_fields[$type]['value'];
    }
    $color = array_search('12', array_column($extra_fields, 'id'));
    if($color !== false){
      $color = $extra_fields[$color]['value'];
    }
    $image = array_search('4', array_column($extra_fields, 'id'));
    if($image !== false){
      $image = $extra_fields[$image]['value'];
    }
	  $colorOrigin = array_search('9', array_column($extra_fields, 'id'));
	  if($colorOrigin !== false){
		  $colorOrigin = $extra_fields[$colorOrigin]['value'];
    }
			  
    $values = array( 'id' => $row['id'],
                     'alias' => $row['alias'],
                     'title' => $row['title'],
                     'hits' => $row['hits'],
                     // 'extra_fields' => json_decode($row['extra_fields']),
                     // 'fabric' => $row['fabric'],
                     'color' => $color,
					 'colorOrigin' => $colorOrigin,
                     'image' => $image);
    $fname = mb_strtolower($row['name'], 'UTF-8');
    if(isset($assoc[$fname])){
      $fabric[] = $values;
      $hits += $row['hits'];
        $assoc[$fname]['hits'] = $hits;
        $assoc[$fname]['items'] = $fabric;

    }else{

        $fabric = array();
        $description = strip_tags($row['description'], '<br><br/>');
        $hits = $row['hits'];
        $fabric[] = $values;
        $assoc[$fname] = array(
        'name' => $row['name'],
        'hits' => $hits,
        'items' => $fabric,
        'description' => $description,
        'fabric' => $type);
    };
  }


  // foreach ($assoc as $key => $value) {
  //   $objects[] = $value;

  // }
//   var_dump($assoc);
  $json = json_encode($assoc);
  echo($json);

  // $new_hits = mysqli_fetch_all($result);
  // close the connection to the database
  mysqli_close($con);

?>