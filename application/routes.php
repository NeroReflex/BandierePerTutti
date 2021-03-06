<?php
/*
	BandierePerTutti set and reset flags!
    Copyright (C) 2016 Benato Denis

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/*******************************************************************************
 *                                                                             *
 *        BandierePerTutti router for the Gishiki framework                    *
 *                                                                             *
 *******************************************************************************/

//import the router (Route class)
use Gishiki\Core\Route;
use Gishiki\Core\Environment;
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
	"status" 	=> true
    ]);
	
    $env_config = new SerializableCollection(Environment::getApplicationSettings());
    $requestBody = $request->getDeserializedBody();
    if (($requestBody->has("tokenID")) 
        && ($requestBody->get("tokenID")
            == $env_config->get("tokenID"))) {
        $pipeline = Gishiki\Pipeline\PipelineCollector::getPipelineByName('changeFlagStatus');
        $typeChanger = new Gishiki\Pipeline\PipelineRuntime($pipeline,
            Gishiki\Pipeline\RuntimeType::SYNCHRONOUS,
            Gishiki\Pipeline\RuntimePriority::URGENT, [
                'flag'      => $arguments['flag'],
                'status'    => true
        ]);
        $typeChanger();
        
        $result["action"] = "changed";
    } else {
        $result["action"] = "untouched";
        $result["error"] =  "bad TokenID";
    }
	
    //send the response to the client
    $response->setSerializedBody($result);
});

Route::post("/clear/{flag}", function (Request &$request, Response &$response, GenericCollection &$arguments) {
    $data = $request->getDeserializedBody();
	
    //generate the response
    $result = new SerializableCollection([
        "name" 		=> $arguments['flag'],
        "status" 	=> false
    ]);
		
    $env_config = new SerializableCollection(Environment::getApplicationSettings());
    $requestBody = $request->getDeserializedBody();
    if (($requestBody->has("tokenID")) 
	&& ($requestBody->get("tokenID")
            == $env_config->get("tokenID"))) {
        $pipeline = Gishiki\Pipeline\PipelineCollector::getPipelineByName('changeFlagStatus');
        $typeChanger = new Gishiki\Pipeline\PipelineRuntime($pipeline,
                Gishiki\Pipeline\RuntimeType::SYNCHRONOUS,
                Gishiki\Pipeline\RuntimePriority::URGENT, [
            'flag'      => $arguments['flag'],
            'status'    => false
        ]);
        $typeChanger();
           
        $result["action"] = "changed";
    } else {
        $result["action"] = "untouched";
        $result["error"] =  "bad TokenID";
    }
	
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
    if (array_key_exists($arguments['flag'], $flags))
        $result["status"] = $flags[$arguments['flag']];
	
    //send the response to the client
    $response->setSerializedBody($result);
});

Route::get(Route::NOT_FOUND, function (Request &$request, Response &$response, GenericCollection &$arguments) {
    //empty response body
    $response->write("404 Not Found");
});
