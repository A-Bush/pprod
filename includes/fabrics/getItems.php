<?php 
require_once 'FabricItemsFactory.php';
require_once("../../configuration.php");
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
/*connection*/
$cg = new JConfig;



$imgDir = 'images/fabrics/';
$imgFldr = 'oxford';
$fabricCategoryName = "оксфорд";
$fullImagesPath = ROOT.'/popa/rada/'.$imgDir;
$query = 'update fabric';

$itemsFacroty = new FabricItemsFactory($imgDir, $imgFldr, $fullImagesPath);

$itemsFacroty->setFabricCategoryName($fabricCategoryName);

$con = $itemsFacroty->connectToDB($cg);

echo "DB prefix = {$itemsFacroty->getPrefix()}";

$itemsFacroty->insertItemsToDB($query);

// /*Items*/
// 	foreach ($imagesFolders as $imageFolder => $imageFiles) {
// 		$path = $itemsFacroty->getPath().$imageFolder.'/';

// 		$query = $itemsFacroty->queryCategory($imageFolder);
// 		$category = mysqli_fetch_assoc(mysqli_query($con, $query));
//     $catid = $category["id"];

//    /*new tag*/
//   //   $queryTag = $itemsFacroty->queryCreateTag($fabricCategoryName);
// 		// echo "<p>queryTag = {$queryTag}</p>";
// 		// // var_dump(mysqli_query($con, $queryTag));

// 		var_dump($category);
// 		echo "<hr>";
// 		foreach ($imageFiles as $key => $image) {
//       $itemAlias = $imageFolder."-".$key;
    
//     /*new item with tag*/
// 			$color = $itemsFacroty->markImageColor($path.$image);
//       $itemTitle = $category["name"]."-".$key;
//       $date = date("Y-m-d H:i");
//       $queryItem = $itemsFacroty->queryNewItem($itemTitle, $itemAlias, $catid, $date);
//       $queryFabricItem =$itemsFacroty->queryCreateFabricCategory($fabricCategoryName, $color, $image, $itemAlias);
			
// 			// $queryExistingItems = $itemsFacroty->queryExistingItems('catid', $catid);

// 		/*echo*/
// 				// // var_dump(mysqli_query($con, $queryItem));
// 				// echo "<p>queryItem = {$queryItem}</p>";
// 				// echo "<hr>";
// 				// // var_dump(mysqli_query($con, $queryFabricItem));
// 				// echo "<p>queryItem = {$queryFabricItem}</p>";
// 				// echo "<hr>";
// 			// // var_dump(mysqli_query($con, $queryExistingItems));
// 				echo "<p>queryItem = {$queryExistingItems}</p>";
// 				echo "<hr>";
// 		}
// 	}

mysqli_close($con);
?>
