<?php
/**
 * Created by PhpStorm.
 * User: deaton
 * Date: 7/2/18
 * Time: 6:30 PM
 */

namespace Unm\Scheduler;
require_once dirname(__DIR__, 2) . "/php/classes/autoload.php";
require_once(dirname(__DIR__, 2) . "/php/util/Util.php");
require_once(dirname(__DIR__, 2) . "/php/classes/ShiftPlan.php");


// TODO: REMEMBER I TOOKOUT SHIFT PLAN NAME IN CONSTRUCTOR!!!

/**
 * Class Shift
 * @package Unm\Scheduler
 * $row["shiftId"], $row["sconNetId"],$row["podId"], $newStartDate, $newEndDate, $row["available"],$row["shiftPlanId"])
 */
class Shift implements \JsonSerializable
{
    private $shiftId;
    private $sconNetId;
    private $podId;
    private $startDate;
    private $endDate;
    private $available;
    private $shiftPlanId;

    public function __construct(?int $shiftId, ?string $sconNetId, int $podId, \DateTime $startDate, \DateTime $endDate, bool $available, ?int $shiftPlanId){
        try{
            $this->setShiftId($shiftId);
            $this->setSconNetId($sconNetId);
            $this->setPodId($podId);
            $this->setStartDate($startDate);
            $this->setEndDate($endDate);
            $this->setAvailable($available);
            if(!is_null($shiftPlanId)){
                $this->shiftPlanId = $shiftPlanId;
            }
        } catch(\InvalidArgumentException $invalidArgument) {
            throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
        } catch(\RangeException $range) {
            throw(new \RangeException($range->getMessage(), 0, $range));
        } catch(\TypeError $typeError) {
            throw(new \TypeError($typeError->getMessage(), 0, $typeError));
        } catch(\Exception $exception) {
            throw(new \Exception($exception->getMessage(), 0, $exception));
        }
    }

    public function setShiftId(?int $shiftId):void{

        if(!is_null($shiftId)){

            if(!is_int($shiftId)){
                throw new \InvalidArgumentException("Shift Id is Invalid: Not An Integer");
            } else if($shiftId < 0){
                throw new \InvalidArgumentException("Shift ID is Invalid: Negative Integer");
            } else if($shiftId >= 4294967296){
                throw new \OutOfBoundsException("Shift ID is Invalid: Maximum INT(10) Size, assign more bytes to Shift Id");
            }
        }

        $this->shiftId = $shiftId;
    }

    public function getShiftId():?int{
        return $this->shiftId;
    }

    public function setSconNetId( ?string $sconNetId):void{
        if(!is_null($sconNetId)){
            if(!is_string($sconNetId)){
                throw new \TypeError("Scon Net Id is Not a String");
            } else if(strlen($sconNetId) > 20){
                throw new \OutOfRangeException("Scon Net Id is Too Long (More than 20 characters)");
            } else if(strlen($sconNetId) < 3 ){
                throw new \OutOfRangeException("Scon Net Id is Too Short (Less than 3 characters");
            }
        }

        $this->sconNetId = $sconNetId;
    }

    public function getSconNetId():?string{
        return $this->sconNetId;
    }

    public function setPodId(int $podId){
        if(!is_int($podId)){
            throw new \InvalidArgumentException("Pod Id is Invalid: Not An Integer");
        } else if($podId < 0){
            throw new \InvalidArgumentException("Pod ID is Invalid: Negative Integer");
        } else if($podId >= 4294967296){
            throw new \OutOfBoundsException("Pod ID is Invalid: Maximum INT(10) Size, assign more bytes to Pod Id");
        }

        $this->podId = $podId;
    }

    public function getPodId():int{
        return $this->podId;
    }

    public function setStartDate( ?\DateTime $date): void
    {
        if(is_null($date)){
            $date = new \DateTime("now");
        }
        if(!Util::verifyDate($date)){
            throw new \InvalidArgumentException("Date Time is not Valid");
        }
        $this->startDate = $date;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function setEndDate( ?\DateTime $date): void
    {
        if(is_null($date)){
            $date = new \DateTime("now");
        }
        if(!Util::verifyDate($date)){
            throw new \InvalidArgumentException("Date Time is not Valid");
        }
        $this->endDate = $date;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param mixed $available
     */
    public function setAvailable(bool $available)
    {
        if(is_null($this->sconNetId) && !$available){
            throw new \InvalidArgumentException("Shift cannot be unavailable if it has no assigned Scon");
        }

        if(!$available){
            $available = 0;
        }

        $this->available = $available;
    }

    /**
     * @return mixed
     */
    public function getAvailable():bool
    {
        return $this->available;
    }

    public function insert(\PDO $pdo){
        if($this->shiftId !== null){
            throw (new \PDOException("Not a New Shift"));
        }

        $query = "INSERT INTO shift (shiftId, sconNetId, podId, shiftPlanName, startDate, endDate, available) VALUES(:shiftId, :sconNetId, :podId, :shiftPlanName, :startDate, :endDate, :available)";
        $statement = $pdo->prepare($query);
        $formattedStartDate = $this->startDate->format("Y-m-d");
        $formattedEndDate = $this->endDate->format("Y-m-d");

        $parameters = ["shiftId" => $this->shiftId, "sconNetId"=> $this->sconNetId, "podId"=>$this->podId, "shiftPlanName"=>$this->shiftPlanName, "startDate"=>$formattedStartDate, "endDate"=> $formattedEndDate, "available"=>$this->available];

        $statement->execute($parameters);

        $this->shiftId = intval($pdo->lastInsertId());
    }

    public function update (\PDO $pdo){

        if(is_null($this->shiftId)){
            throw new \PDOException("Can't update an un-inserted Shift");
        }

        $query = "UPDATE shift SET shiftId = :shiftId, sconNetId = :sconNetId, podId = :podId, shiftPlanName= :shiftPlanName, startDate = :startDate, endDate = :endDate, available = :available WHERE shiftId = :shiftId";
        $statement = $pdo->prepare($query);
        $formattedStartDate = $this->startDate->format("Y-m-d");
        $formattedEndDate = $this->endDate->format("Y-m-d");
        $parameters = ["shiftId" => $this->shiftId, "sconNetId"=> $this->sconNetId, "podId"=>$this->podId, "shiftPlanName"=>$this->shiftPlanName, "startDate"=>$formattedStartDate, "endDate"=> $formattedEndDate, "available"=>$this->available];
        $statement->execute($parameters);
    }

    public function delete(\PDO $pdo){
        if(is_null($this->shiftId)){
            throw new \PDOException("Can't delete an un-inserted Shift");
        }
        $query = "DELETE FROM shift WHERE shiftId = :shiftId";
        $statement = $pdo->prepare($query);
        $parameters = ["shiftId"=>$this->shiftId];
        $statement->execute($parameters);
    }

    public static function getShiftById(\PDO $pdo, $shiftId){
        $query = "SELECT shiftId, sconNetId, podId, shiftPlanName, startDate, endDate, available FROM shift WHERE shiftId = :shiftId";
        $statement = $pdo->prepare($query);
        $parameter = ["shiftId"=> $shiftId];
        $statement->execute($parameter);

        try{
            $shift = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false){
                $newStartDate = new \DateTime($row["startDate"]);
                $newEndDate = new \DateTime($row["endDate"]);
                if(!$newStartDate){
                    $newStartDate = new \DateTime();
                }
                if(!$newEndDate){
                    $newEndDate = new \DateTime();
                }
                $shift = new Shift($row["shiftId"],$row["sconNetId"],$row["podId"],$row["shiftPlanName"],$newStartDate,$newEndDate,$row["available"]);

            }
        }catch(\Exception $e){
            throw(new \PDOException(new \PDOException($e->getMessage(),0,$e)));
        }

        return ($shift);
    }



    public static function getShiftsByShiftPlanName(\PDO $pdo, string $shiftPlanName){

        $shiftPlanName = trim($shiftPlanName);
        $query = "SELECT shiftPlanId, podId, startDate, endDate FROM shiftPlan WHERE shiftPlanName = :shiftPlanName";
        $statement = $pdo->prepare($query);
        $parameter = ["shiftPlanName"=>$shiftPlanName];
        $statement->execute($parameter);
        $shiftPlanId = 1;
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $shiftPlanId = $row["shiftPlanId"];
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }

        $query = "SELECT shiftId, sconNetId, podId, startDate, endDate, available, shiftPlanId FROM shift WHERE shiftPlanId = :shiftPlanName";
        $statement = $pdo->prepare($query);
        $parameter = ["shiftPlanName"=>$shiftPlanId];
        $statement->execute($parameter);

        $allShifts = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $newStartDate = new \DateTime($row["startDate"]);
                $newEndDate = new \DateTime($row["endDate"]);

                $shift = new Shift($row["shiftId"], $row["sconNetId"],$row["podId"], $newStartDate, $newEndDate, $row["available"], $row["shiftPlanId"]);
                $allShifts[$allShifts->key()] = $shift;
                $allShifts->next();
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($allShifts);
    }

    public static function getShiftsBySconNetId(\PDO $pdo, string $sconNetId){
        $sconNetId = trim($sconNetId);
        $query = "SELECT shiftId, sconNetId, podId, startDate, endDate, available FROM shift WHERE sconNetId = :sconNetId";

        $statement = $pdo->prepare($query);
        $parameter = ["sconNetId"=>$sconNetId];
        $statement->execute($parameter);

        $allShifts = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $newStartDate = new \DateTime($row["startDate"]);
                $newEndDate = new \DateTime($row["endDate"]);
                $shift = new Shift($row["shiftId"], $row["sconNetId"], $row["podId"], $newStartDate, $newEndDate, $row["available"]);
                $allShifts[$allShifts->key()] = $shift;
                $allShifts->next();
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($allShifts);
    }

    public static function getShiftsByShiftPlanNameAndPodId(\PDO $pdo, string $shiftPlanName,int $podId){
        $query = "SELECT shiftId, sconNetId, podId, shiftPlanName, startDate, endDate, available FROM shift WHERE shiftPlanName = :shiftPlanName AND podId = :podId";
        $statement = $pdo->prepare($query);
        $parameter = ["shiftPlanName"=>$shiftPlanName, "podId"=>$podId];
        $statement->execute($parameter);

        $allShifts = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $newStartDate = new \DateTime($row["startDate"]);
                $newEndDate = new \DateTime($row["endDate"]);
                $shift = new Shift($row["shiftId"], $row["sconNetId"],$row["podId"],$row["shiftPlanName"], $newStartDate, $newEndDate, $row["available"]);
                $allShifts[$allShifts->key()] = $shift;
                $allShifts->next();
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($allShifts);
    }

    public static function getShiftsByShiftPlanNameAndSconNetId(\PDO $pdo, string $shiftPlanName,string $sconNetId){
        $query = "SELECT shiftId, sconNetId, podId, shiftPlanName, startDate, endDate, available FROM shift WHERE shiftPlanName = :shiftPlanName AND sconNetId = :sconNetId";
        $statement = $pdo->prepare($query);
        $parameter = ["shiftPlanName"=>$shiftPlanName, "sconNetId"=>$sconNetId];
        $statement->execute($parameter);

        $allShifts = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $newStartDate = new \DateTime($row["startDate"]);
                $newEndDate = new \DateTime($row["endDate"]);
                $shift = new Shift($row["shiftId"], $row["sconNetId"],$row["podId"],$row["shiftPlanName"], $newStartDate, $newEndDate, $row["available"]);
                $allShifts[$allShifts->key()] = $shift;
                $allShifts->next();
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($allShifts);
    }

    public function jsonSerialize() {
        $fields = ["shiftId"=>$this->shiftId, "sconNetId"=> $this->sconNetId, "podId"=>$this->podId, "startDate"=>$this->startDate,"endDate"=>$this->endDate,"available"=>$this->available];
        return ($fields);
    }

}
