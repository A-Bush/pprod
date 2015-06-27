<?php
require_once 'gapi/autoload.php';
define('ROOT', '/popa/rada/includes/fabrics');

// var_dump($_SERVER['HTTP_HOST'].ROOT);
session_start();

$client = new Google_Client();
$client->setAuthConfigFile('client_secrets.json');
$client->addScope(Google_Service_Drive::DRIVE.' '.Google_Service_Drive::SS);

// $client->addScope(Google_Service_Drive::DRIVE.' https://docs.google.com/feeds/ '.Google_Service_Drive::SS.' https://docs.google.com/feeds');
// $client->addScope(Google_Service_Drive::SS);
// $client->addScope('https://spreadsheets.google.com/feeds/');

// var_dump($client->getScopes());

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  
  if ($client->isAccessTokenExpired()) {
  	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . ROOT .'/oauth2callback.php';
  	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  }

  $drive_service = new Google_Service_Drive($client);

  $fileId = "1BzOJEYqXYqKV9t9ZNWzwbGsHAX-zn9oeXF_o9zj1t9I";
  try {
    // Retrieve metadata for the file specified by $fileId.
    $file = $drive_service->files->get($fileId);
    print "Title: " . $file->getTitle();
    echo "<hr>";
    // print "MIME type: " . $file->getMimeType();
    // Get the contents of the file.
    // $downloadUrl = $file->getDownloadUrl();
    // $downloadUrl = "https://www.googleapis.com/drive/v2/files/".$fileId;
    // $downloadUrl = "https://spreadsheets.google.com/feeds/spreadsheets/private/full";
    // $downloadUrl = "https://spreadsheets.google.com/feeds/worksheets/1SIPGtSxYsYkhqvVQH16bodvOUOEBo_lOb2SzWiQtmlk/private/full";
    $downloadUrl = "https://spreadsheets.google.com/feeds/list/1SIPGtSxYsYkhqvVQH16bodvOUOEBo_lOb2SzWiQtmlk/ohvz28m/private/full";
    /*Test sheet*/
    // $downloadUrl = "https://spreadsheets.google.com/feeds/worksheets/10HtRyp_u2EO5X6yF5l3VR9EVA9IztrlCJY0oQ5YQBJ8/private/full";
    // $downloadUrl = "https://spreadsheets.google.com/feeds/worksheets/10HtRyp_u2EO5X6yF5l3VR9EVA9IztrlCJY0oQ5YQBJ8/private/full/od6";
    // $downloadUrl = "https://spreadsheets.google.com/feeds/list/10HtRyp_u2EO5X6yF5l3VR9EVA9IztrlCJY0oQ5YQBJ8/od6/private/full";

    print "downloadUrl: " . $downloadUrl;
	  if ($downloadUrl) {
	    $request = new Google_Http_Request($downloadUrl, 'GET', null, null);
	    // $httpRequest = Google_Client::$io->authenticatedRequest($request);
	    // var_dump($client->getAuth());
      echo "<hr>";
      $SignhttpRequest = $client->getAuth()->sign($request);
      // var_dump($SignhttpRequest);
      $httpRequest = $client->getIo()->makeRequest($SignhttpRequest);

      if ($httpRequest->getResponseHttpCode() == 200) {
	     // var_dump($httpRequest);
        echo "<h1>URA</h1>";
        $feed = new SimpleXMLElement($httpRequest->getResponseBody());
        // var_dump($httpRequest->getResponseBody());
        foreach ($feed->entry as $entry){    
				    // foreach ($item->children() as $child) {
				    //   echo $child['name'] ."\n";
				    // }
        	echo '<p>'.$entry->title.'</p>';
        	echo '<p>'.$entry->content[0].'</p>';

	        // var_dump($entry->content);
				}
	    } else {
        echo "<hr>";
        echo "<h1>An error occurred.</h1>";
        echo "<hr>";
        var_dump($httpRequest->getRequestHeaders());
	      echo "<hr>";
        var_dump($httpRequest->getResponseBody());
	    }
	  } else {
	    echo "The file doesn't have any content stored on Drive.";
	    var_dump( null);
	  }
  } catch (Exception $ex) {
    var_dump($ex);
  }
  // $files_list = $drive_service->files->listFiles(array())->getItems();
  // echo json_encode($files_list);
} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . ROOT .'/oauth2callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}