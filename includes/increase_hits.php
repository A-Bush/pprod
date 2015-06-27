<?php

/**
 *  Use this script to update article hits when caching is enabled
 *  Setup guide can be found here: http://www.inmotionhosting.com/support/edu/joomla-3/increase-hits-cache
 */
// define('_JEXEC', 1);
// define('JPATH_BASE', dirname(__DIR__));
 
// define( 'DS', DIRECTORY_SEPARATOR );
// /* Required Files */
// require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
// require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
// /* To use Joomla's Database Class */
// require_once ( JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'factory.php' );
 
if (  $_POST['option'] == "com_k2store"
      && $_POST['view'] == "mycart"
      && is_numeric($_POST['id'])){

  // connect to the database
  include_once("../configuration.php");
  $cg = new JConfig;
  $con = mysqli_connect($cg->host, $cg->user, $cg->password, $cg->db);
  if (mysqli_connect_errno())
    die('n/a');

  // increase hits
  $query = "  UPDATE  `" . $cg->dbprefix . "k2_items`
              SET     `hits` = `hits` + 1
              WHERE   `id` = " . $_POST['id'] . "
              LIMIT 1;
  ";
  mysqli_query($con, $query);

  // grab the new hit count
  $query = "  SELECT `hits` 
              FROM `" . $cg->dbprefix . "k2_items` 
              WHERE `id` = " . $_POST['id'] . "
              LIMIT 1";
  $new_hits = mysqli_fetch_assoc(mysqli_query($con, $query));
  // close the connection to the database
  echo $new_hits['hits'];
  mysqli_close($con);
}

?>