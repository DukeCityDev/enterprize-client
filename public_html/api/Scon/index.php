<?php
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);

    require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
    require_once dirname(__DIR__, 3) . "/db/PdoGetter.php";
    use Unm\Scheduler\{Scon};

    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }

    $reply = new \stdClass();
    $reply->status = 200;
    $reply->data = null;

try {
    //grab the mySQL connection
    $pdo = PdoGetter::getPdo();
    //determine which HTTP method was used
    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
    // sanitize input
    // make sure the id is valid for methods that require it
    if($method === "GET") {
	$netId = $_SERVER['REDIRECT_REMOTE_USER'];
	$netId = "deaton747";
	    switch ($_GET['findMethod']){
	        case "all":
	            $scons = Scon::getAllScons($pdo);
	            $reply->data = $scons;
                break;
            default:
                if(!empty($netId)){
                    $scons = Scon::getSconByNetId($pdo,"deaton747");
                    if(!is_null($scons)) {
                        $reply->data = $scons;
                    }else{
                        $reply->data= $scons;
                        //handle if scon is logged on but is no account is found.
                        //throw new InvalidArgumentException("Scon is not authorized",401);
                    }
                }else{
                    //handle if user is not logged in and redirect them
                    echo "reached here";
                }
                break;
        }

    }
    elseif($method === "POST"){
        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);
        //$reply->data = $requestObject;
        //Check to make sure the sender is an Administrator
        $netId = $_SERVER['REDIRECT_REMOTE_USER'];
        $sendingScon = Scon::getSconByNetId($pdo, $netId);
        if(empty($sendingScon)=== false){
            if(!$sendingScon->getAdminStatus()){
                throw new InvalidArgumentException("Scon is not authorized");
            }
        } else{
            throw new InvalidArgumentException("Scon is not authorized");
        }

        $scon = new Scon(null, $requestObject->firstName, $requestObject->lastName,$requestObject->middleInitial,$requestObject->netId,$requestObject->email,$requestObject->phoneNumber,$requestObject->startDate,$requestObject->adminStatus);

        $scon->insert($pdo);
        $reply->data = "New Scon ". $scon->getNetId()." has been added";

    }
    elseif($method === "PUT") {

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
            $reply->message = "sconId is empty";
        }

        $scon = Scon::getSconBySconId($pdo,$requestObject->sconId);

        if($scon === null){
            throw new InvalidArgumentException("The Scon you are trying to update does not exist");
        }

        $scon->setSconId($requestObject->sconId);
        $scon->setFirstName($requestObject->firstName);
        $scon->setLastName($requestObject->lastName);
        $scon->setMiddleInitial($requestObject->middleInitial);
        $scon->setNetId($requestObject->netId);
        $scon->setEmail($requestObject->email);
        $scon->setPhoneNumber($requestObject->phoneNumber);
        $scon->setStartDate($requestObject->startDate);
        $scon->setAdminStatus($requestObject->adminStatus);
        $scon->update($pdo);
        //return all scheduleItems associated with the userId in the request
        $reply->data = $scon;
        $reply->message = "Scon Updated OK";


    } elseif($method === "DELETE") {

        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);

        //Check to make sure the sender is an Administrator
        $netId = $_SERVER['REDIRECT_REMOTE_USER'];
        $sendingScon = Scon::getSconByNetId($pdo, $netId);

        $deletedSconId = $_GET["sconId"];

        if(empty($sendingScon)=== false){
            if(!$sendingScon->getAdminStatus()){
                throw new InvalidArgumentException("Scon is not authorized",401);
            }
        }else{
            throw new InvalidArgumentException("Not Logged In",401);
        }

        $deletedScon = Scon::getSconBySconId($pdo, $deletedSconId);
        if($deletedScon === null){
            throw new InvalidArgumentException("Scon does not exist");
        }
        $deletedSconNetId = $deletedScon->getNetId();
        $deletedScon->delete($pdo);
        $reply->message = "Scon ".$deletedSconNetId." has been deleted";

        //$reply->message = $deletedSconId;



    } else {
        throw (new InvalidArgumentException("Invalid HTTP request", 400));
    }
    // catch any exceptions that were thrown and update the status and message state variable fields
} catch(\Exception | \TypeError $exception) {
    $reply->status = $exception->getCode();
    $reply->message = $exception->getMessage();
}

echo json_encode($reply);
