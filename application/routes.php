<?php
/*******************************************************************************
 *                                                                             *
 *              Example router for the Gishiki framework                       *
 *                                                                             *
 *******************************************************************************/

//import the router (Route class)
use Gishiki\Core\Route;
use Gishiki\HttpKernel\Request;
use Gishiki\HttpKernel\Response;
use Gishiki\Algorithms\Collections\GenericCollection;
use Gishiki\Algorithms\Collections\SerializableCollection;

Route::post("/set/{flag}", function (Request &$request, Response &$response, GenericCollection &$arguments) {
    //get the request data
    $data = $request->getDeserializedBody();
	
	//generate the response
	$result = new SerializableCollection([
		"name" 		=> $arguments['flag'],
		"status" 	=> "set"
		]);
		
	$flags = json_decode(file_get_contents("flags.json"), true);
	$flags[$arguments['flag']] = "set";
	$flags = file_put_contents("flags.json", json_encode($flags, JSON_PARTIAL_OUTPUT_ON_ERROR));
	
	//send the response to the client
    $response->setSerializedBody($result);
});

Route::post("/clear/{flag}", function (Request &$request, Response &$response, GenericCollection &$arguments) {
    $data = $request->getDeserializedBody();
	
	//generate the response
	$result = new SerializableCollection([
		"name" 		=> $arguments['flag'],
		"status" 	=> "clear"
		]);
		
	$flags = json_decode(file_get_contents("flags.json"), true);
	$flags[$arguments['flag']] = "clear";
	$flags = file_put_contents("flags.json", json_encode($flags, JSON_PARTIAL_OUTPUT_ON_ERROR));
	
	
	//send the response to the client
    $response->setSerializedBody($result);
});

Route::get("/look/{flag}", function (Request &$request, Response &$response, GenericCollection &$arguments) {
    //generate the response
	$result = new SerializableCollection([
		"name" 		=> $arguments['flag'],
		"status" 	=> "unknown"
		]);
	
	$flags = json_decode(file_get_contents("flags.json"), true);
	$result["status"] = (array_key_exists($arguments['flag'], $flags))? 
		"".$flags[$arguments['flag']] : "unknown";
	
	//send the response to the client
    $response->setSerializedBody($result);
});

Route::get(Route::NOT_FOUND, function (Request &$request, Response &$response, GenericCollection &$arguments) {
    //empty response body
    $response->write("404 Not Found");
});
