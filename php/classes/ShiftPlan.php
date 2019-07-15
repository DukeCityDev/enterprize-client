<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 6/26/2018
 * Time: 12:51 PM
 */

namespace Unm\Scheduler;
//require_once(dirname(__DIR__) . "/autoload.php");
require_once(dirname(__DIR__) . "/util/Util.php");


class ShiftPlan implements \JsonSerializable

{
    private $shiftPlanId;
    private $podId;
    private $startDate;
    private $endDate;
    private $shiftPlanName;

    public function __construct(?int $shiftPlanId,int $podId, \DateTime $startDate, \DateTime $endDate, string $shiftPlanName)
    {
        try{
            $this->setShiftPlanId($shiftPlanId);
            $this->setPodId($podId);
            $this->setStartDate($startDate);
            $this->setEndDate($endDate);
            $this->setShiftPlanName($shiftPlanName);
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

    public function setShiftPlanId(?int $shiftPlanId):void{
        if(!is_null($shiftPlanId)){

            if(!is_int($shiftPlanId)){
                throw new \InvalidArgumentException("ShiftPlan Id is Invalid: Not An Integer");
            } else if($shiftPlanId < 0){
                throw new \InvalidArgumentException("ShiftPlan Id is Invalid: Negative Integer");
            } else if($shiftPlanId >= 4294967296){
                throw new \OutOfBoundsException("ShiftPlan ID is Invalid: Maximum INT(10) Size, assign more bytes to Shift Plan Id");
            }
        }
        $this->shiftPlanId = $shiftPlanId;
    }

    /**
     * @return mixed
     */
    public function getShiftPlanId(): ?int
    {
        return $this->shiftPlanId;
    }

    public function setPodId(int $podId){

            if(!is_int($podId)){
                throw new \InvalidArgumentException("Pod Id is Invalid: Not An Integer");
            } else if($podId < 0){
                throw new \InvalidArgumentException("Scon Id is Invalid: Negative Integer");
            } else if($podId >= 4294967296){
                throw new \OutOfBoundsException("Pod ID is Invalid: Maximum INT(10) Size, assign more bytes to ShiftPlan  PodId");
            }

        $this->podId = $podId;
    }

    /**
     * @return int
     */
    public function getPodId():int
    {
        return $this->podId;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate)
    {
        if(is_null($startDate)){
            throw new \InvalidArgumentException("ShiftPlan Start Date is not Valid DateTime");
        }
        if(!Util::verifyDate($startDate)){
            throw new \InvalidArgumentException("ShiftPlan Start Date is not Valid DateTime");
        }
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate)
    {
        if(is_null($endDate)){
            throw new \InvalidArgumentException("ShiftPlan End Date is not Valid DateTime");
        }
        if(!Util::verifyDate($endDate)){
            throw new \InvalidArgumentException("ShiftPlan End Date is not Valid Datetime");
        }
        $this->endDate = $endDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate() :\DateTime
    {
        return $this->endDate;
    }

    public function setShiftPlanName(string $shiftPlanName){
        if(is_null($shiftPlanName)){
            $shiftPlanName = "";
        }
        if(!is_string($shiftPlanName)){
            throw new \TypeError("Shift Plan Name is Not a String");
        } else if(strlen($shiftPlanName) > 20){
            throw new \OutOfRangeException("Shift Plan Name is Too Long");
        }
        $this->shiftPlanName = $shiftPlanName;
    }

    public function getShiftPlanName():string{
        return $this->shiftPlanName;
    }

    public function insert(\PDO $pdo){
        if($this->shiftPlanId !== null){
            throw (new \PDOException("Not a new ShiftPlan, can't be inserted"));
        }

        $query = "INSERT INTO shiftPlan (shiftPlanId, podId, startDate, endDate, shiftPlanName) VALUES(:shiftPlanId, :podId, :startDate, :endDate, :shiftPlanName)";
        $statement = $pdo->prepare($query);
        $formattedStartDate = $this->startDate->format("Y-m-d");
        $formattedEndDate = $this->endDate->format("Y-m-d");
        $parameters = ["shiftPlanId" => $this->shiftPlanId, "podId"=> $this->podId, "startDate"=>$formattedStartDate, "endDate"=>$formattedEndDate, "shiftPlanName"=>$this->shiftPlanName];

        $statement->execute($parameters);

        $this->shiftPlanId = intval($pdo->lastInsertId());
    }

    public function update(\PDO $pdo){
        if(is_null($this->shiftPlanId)){
            throw new \PDOException("Can't update an un-inserted ShiftPlan");
        }

        $query = "UPDATE shiftPlan SET shiftPlanId = :shiftPlanId, podId = :podId, startDate = :startDate, endDate = :endDate, shiftPlanName = :shiftPlanName WHERE shiftPlanId = :shiftPlanId";
        $statement = $pdo->prepare($query);
        $formattedStartDate = $this->startDate->format("Y-m-d");
        $formattedEndDate = $this->endDate->format("Y-m-d");
        $parameters = ["shiftPlanId" => $this->shiftPlanId, "podId"=> $this->podId, "startDate"=>$formattedStartDate, "endDate"=>$formattedEndDate, "shiftPlanName"=>$this->shiftPlanName];
        $statement->execute($parameters);
    }

    public function delete(\PDO $pdo){
        if(is_null($this->shiftPlanId)){
            throw new \PDOException("Can't delete an un-inserted ShiftPlan");
        }
        $query = "DELETE FROM shiftPlan WHERE shiftPlanId = :shiftPlanId";
        $statement = $pdo->prepare($query);
        $parameters = ["shiftPlanId"=>$this->shiftPlanId];
        $statement->execute($parameters);
    }

    public static function getAllShiftPlans(\PDO $pdo){
        $query = "SELECT shiftPlanId, podId, startDate, endDate, shiftPlanName FROM shiftPlan";
        $statement = $pdo->prepare($query);
        $statement->execute();

        $allShiftPlans = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $newStartDate = new \DateTime($row["startDate"]);
                $newEndDate = new \DateTime($row["endDate"]);
                $shiftPlan = new ShiftPlan($row["shiftPlanId"],$row["podId"],$newStartDate,$newEndDate,$row["shiftPlanName"]);
                $allShiftPlans[$allShiftPlans->key()] = $shiftPlan;
                $allShiftPlans->next();
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($allShiftPlans);
    }

    public static function getShiftPlanByName(\PDO $pdo, string $shiftPlanName){
        $shiftPlanName = trim($shiftPlanName);
        $query = "SELECT shiftPlanId, podId, startDate, endDate, shiftPlanName FROM shiftPlan WHERE shiftPlanName = :shiftPlanName";
        $statement = $pdo->prepare($query);
        $parameter = ["shiftPlanName"=>$shiftPlanName];
        $statement->execute($parameter);

        $allShiftPlans = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $newStartDate = new \DateTime($row["startDate"]);
                $newEndDate = new \DateTime($row["endDate"]);
                $shiftPlan = new ShiftPlan($row["shiftPlanId"],$row["podId"],$newStartDate,$newEndDate,$row["shiftPlanName"]);
                $allShiftPlans[$allShiftPlans->key()] = $shiftPlan;
                $allShiftPlans->next();
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($allShiftPlans);
    }

    public static function getShiftPlanById(\PDO $pdo, int $shiftPlanId){
        $query = "SELECT shiftPlanId, podId, startDate, endDate, shiftPlanName FROM shiftPlan WHERE shiftPlanId = :shiftPlanId";
        $statement = $pdo->prepare($query);
        $parameter = ["shiftPlanId"=> $shiftPlanId];
        $statement->execute($parameter);

        try{
            $shiftPlan = null;
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
                $shiftPlan = new ShiftPlan($row["shiftPlanId"],$row["podId"],$newStartDate,$newEndDate,$row["shiftPlanName"]);
            }
        }catch(\Exception $e){
            throw(new \PDOException(new \PDOException($e->getMessage(),0,$e)));
        }

        return ($shiftPlan);
    }


    public function jsonSerialize(){
        $fields = ["shiftPlanId"=>$this->getShiftPlanId(), "podId"=> $this->getPodId(), "startDate"=>$this->getStartDate(),"endDate"=>$this->getEndDate(),"shiftPlanName"=>$this->getShiftPlanName()];
        return ($fields);
    }

}