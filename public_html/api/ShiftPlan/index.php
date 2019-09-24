<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 7/12/2018
 * Time: 9:58 AM
 */

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/db/PdoGetter.php";
use Unm\Scheduler\{Scon,Pod,ShiftPlan};

if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}

$reply = new \stdClass();
$reply->status = 200;


try{
    $pdo = PdoGetter::getPdo();
    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


    if($method === "GET"){

        if($_GET["shiftPlanName"]){
           $reply->data = ShiftPlan::getShiftPlanByName($pdo,$_GET["shiftPlanName"]);
        } else{
            $reply->data = ShiftPlan::getAllShiftPlans($pdo);
        }


    }else if($method === "POST"){

        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);
        //Check to make sure the sender is an Administrator
        $netId = $_SERVER['REDIRECT_REMOTE_USER'];
        $sendingScon = Scon::getSconByNetId($pdo, $netId);
        if(empty($sendingScon)=== false){
            if(!$sendingScon->getAdminStatus()){
                throw new InvalidArgumentException("Scon is not authorized ",401);
            }
        } else{
            throw new InvalidArgumentException("Scon is not authorized",401);
        }

        if(empty($requestObject->podId)){
            throw new InvalidArgumentException("Invalid Request: Need Pod Id test".$requestObject->podId,401);
        }
        if(empty($requestObject->shiftPlanName)){
            throw new InvalidArgumentException("Invalid Request: Need Shift Plan Name".$requestObject->shiftPlanName,401);
        }


        $podId = $requestObject->podId;
        $startDate = new DateTime($requestObject->startDate);
        $endDate = new DateTime($requestObject->endDate);
        $shiftPlanName = $requestObject->shiftPlanName;
        if(empty($podId)){
            throw new InvalidArgumentException("Need Pod Id",401);
        }

        $shiftPlan = new ShiftPlan(null,$podId, $startDate, $endDate, $shiftPlanName);
        $shiftPlan->insert($pdo);
        $reply->data =$shiftPlan->getShiftPlanId();

    }else if($method === "PUT"){

        //Check to make sure the sender is an Administrator
        $netId = $_SERVER['REDIRECT_REMOTE_USER'];
        $sendingScon = Scon::getSconByNetId($pdo, $netId);

        if(empty($sendingScon)=== false){
            if(!$sendingScon->getAdminStatus()){
                throw new InvalidArgumentException("Scon is not authorized");
            }
        }else{
            throw new InvalidArgumentException("Scon is not authorized");
        }

        //proceed with update procedures
        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);
        // check userId and sanitize

        if(empty($requestObject->sconId) === true) {
            $reply->status = 405;
            $reply->message = "shiftPlanId is empty";
        }

        $shiftPlan = ShiftPlan::getShiftPlanById($pdo,$requestObject->shiftPlanId);

        if($shiftPlan === null){
            throw new InvalidArgumentException("The ShiftPlan you are trying to update does not exist");
        }

        $shiftPlan->setShiftPlanName($requestObject->shiftPlanName);
        $shiftPlan->setPodId($requestObject->podId);
        $shiftPlan->setStartDate(new DateTime($requestObject->startDate));
        $shiftPlan->setEndDate(new DateTime($requestObject->endDate));
        $shiftPlan->update($pdo);
        //return all scheduleItems associated with the userId in the request
        $reply->data = $shiftPlan->jsonSerialize();
        $reply->message = "OK";

    } else if($method === "DELETE"){
        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);

        //Check to make sure the sender is an Administrator
        $netId = $_SERVER['REDIRECT_REMOTE_USER'];
        $sendingScon = Scon::getSconByNetId($pdo, $netId);
        if(empty($sendingScon)=== false){
            if(!$sendingScon->getAdminStatus()){
                throw new InvalidArgumentException("Scon is not authorized to Delete Shift Plans",401);
            }
        } else{
            throw new InvalidArgumentException("Scon is not authorized to delete Delete Shift Plans",401);
        }

        if(empty($_GET["shiftPlanId"])){
            throw new InvalidArgumentException("Invalid Request: Need Shift Plan Id",401);
        }


        $shiftPlanId = $_GET["shiftPlanId"];
        $shiftPlan = ShiftPlan::getShiftPlanById($pdo,$shiftPlanId);

        if(empty($shiftPlan)){
            throw new InvalidArgumentException("ShiftPlan Does Not Exist",401);
        }

        $shiftPlan->delete($pdo);
        $reply->data = "ShiftPlan ".$requestObject->shiftPlanId."Deleted";
    }
}catch(Exception $e){
    $reply->status = $e->getCode();
    $reply->message = $e->getMessage();
}

echo json_encode($reply);
