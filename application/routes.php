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

Route::get("/set/{flag}", function (Request &$request, Response &$response, GenericCollection &$arguments) {
    //generate the response
	$result = new SerializableCollection([
		"name" 		=> $arguments['flag'],
		"status" 	=> "set"
		]);
	
	//send the response to the client
    $this->Response->setSerializedBody($result);
});

Route::get("/clear/{flag}", function (Request &$request, Response &$response, GenericCollection &$arguments) {
    //generate the response
	$result = new SerializableCollection([
		"name" 		=> $arguments['flag'],
		"status" 	=> "clear"
		]);
	
	//send the response to the client
    $this->Response->setSerializedBody($result);
});

Route::get("/get/{flag}", function (Request &$request, Response &$response, GenericCollection &$arguments) {
    //generate the response
	$result = new SerializableCollection([
		"name" 		=> $arguments['flag'],
		"status" 	=> "set"
		]);
	
	//send the response to the client
    $this->Response->setSerializedBody($result);
});

Route::get(Route::NOT_FOUND, function (Request &$request, Response &$response, GenericCollection &$arguments) {
    //empty response body
    $response->write("404 Not Found");
});
