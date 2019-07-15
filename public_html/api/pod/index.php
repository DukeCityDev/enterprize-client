<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 7/12/2018
 * Time: 9:58 AM
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/db/PdoGetter.php";
use Unm\Scheduler\{Pod,Scon};

if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}

$reply = new \stdClass();
$reply->status = 200;


try{
    $pdo = PdoGetter::getPdo();
    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


    if($method === "GET"){

        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);

        //get back all pod data
        $pods = Pod::getAllPods($pdo);
        $reply->data = $pods;
    } else if($method === "POST"){

        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);
        //Check to make sure the sender is an Administrator
        $netId = $_SERVER['REDIRECT_REMOTE_USER'];
        $sendingScon = Scon::getSconByNetId($pdo, $netId);
        if(empty($sendingScon)=== false){
            if(!$sendingScon->getAdminStatus()){
                throw new InvalidArgumentException("Scon is not authorized",401);
            }
        } else{
            throw new InvalidArgumentException("Scon is not authorized",401);
        }

        if(empty($requestObject->podName)){
            throw new InvalidArgumentException("Invalid Request: Need Pod Name",401);
        }
        $podName = $requestObject->podName;
        $pod = new Pod(null,$podName);
        $pod->insert($pdo);
        $reply->message ="Pod Inserted";
    } else if($method === "DELETE"){
        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);

        //Check to make sure the sender is an Administrator
        $netId = $_SERVER['REDIRECT_REMOTE_USER'];
        $sendingScon = Scon::getSconByNetId($pdo, $netId);
        if(empty($sendingScon)=== false){
            if(!$sendingScon->getAdminStatus()){
                throw new InvalidArgumentException("Scon is not authorized to Delete pods",401);
            }
        } else{
            throw new InvalidArgumentException("Scon is not authorized to delete pods",401);
        }

        if(empty($requestObject->podName)){
            throw new InvalidArgumentException("Invalid Request: Need Pod Name",401);
        }
        $podName = $requestObject->podName;
        $pod = Pod::getPodByPodName($pdo, $podName);
        if(empty($pod)){
            throw new InvalidArgumentException("Pod Does Not Exist",401);
        }
        $pod->delete($pdo);
        $reply->message = "Pod ".$requestObject->podName." Deleted";
    }
}catch(Exception $e){
    $reply->status = $e->getCode();
    $reply->message = $e->getMessage();
}

echo json_encode($reply);
