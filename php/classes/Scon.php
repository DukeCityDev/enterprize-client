<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 6/14/2018
 * Time: 3:45 PM
 */


// NOTE: NETID CAN ONLY BE FROM 3-20 CHARACTERS



namespace Unm\Scheduler;
require_once dirname(__DIR__, 2) . "/php/classes/autoload.php";
require_once(dirname(__DIR__, 2) . "/php/util/Util.php");

class Scon implements \JsonSerializable
{
    private $sconId;
    private $firstName;
    private $lastName;
    private $middleInitial;
    private $netId;
    private $email;
    private $phoneNumber;
    private $startDate;
    private $adminStatus;


 public function __construct($sconId, $firstName, $lastName, $middleInitial,$netId, $email,$phoneNumber, $startDate, $adminStatus)
 {
     try{
         $this->setSconId($sconId);
         $this->setFirstName($firstName);
         $this->setLastName($lastName);
         $this->setMiddleInitial($middleInitial);
         $this->setNetId($netId);
         $this->setEmail($email);
         $this->setPhoneNumber($phoneNumber);
         $this->setStartDate($startDate);
         $this->setAdminStatus($adminStatus);
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

 public function setSconId(?int $sconId):void{
     if(!is_null($sconId)){

         if(!is_int($sconId)){
             throw new \InvalidArgumentException("Scon Id is Invalid: Not An Integer");
         } else if($sconId < 0){
             throw new \InvalidArgumentException("Scon ID is Invalid: Negative Integer");
         } else if($sconId >= 4294967296){
             throw new \OutOfBoundsException("Scon ID is Invalid: Maximum INT(10) Size, assign more bytes to Scon Id");
         }
     }

     $this->sconId = $sconId;
 }

    /**
     * @return mixed
     */
    public function getSconId(): ?int
    {
        return $this->sconId;
    }


    public function setFirstName(string $firstName) : void
    {
        if(!is_string($firstName)){
            throw new \TypeError("First Name is Not a String");
        } else if(strlen($firstName) > 45){
            throw new \OutOfRangeException("First Name is Too Lomg");
        } else if(strlen($firstName) === 0 ){
            throw new \OutOfRangeException("First Name is Too Short");
        }

        $this->firstName = $firstName;
    }

    public function getFirstName() : string
    {
        return $this->firstName;
    }

    public function setLastName(string $lastName) : void
    {
        if(!is_string($lastName)){
            throw new \TypeError("Last Name is Not a String");
        } else if(strlen($lastName) > 45){
            throw new \OutOfRangeException("Last Name is Too Lomg");
        } else if(strlen($lastName) === 0 ){
            throw new \OutOfRangeException("Last Name is Too Short");
        }

        $this->lastName = $lastName;
    }

    public function getLastName():string{
        return $this->lastName;
    }

    public function setMiddleInitial(?string $middleInitial) : void
    {
        if(!is_null($middleInitial)){
            if(strlen($middleInitial) !== 1){
                throw new \OutOfRangeException("Middle Initial must only be one character.");
            }
        } else{
            $middleInitial =" ";
        }
        $this->middleInitial = $middleInitial;
    }

    public function getMiddleInitial():string
    {
        return $this->middleInitial;
    }

    public function setNetId(string $netId): void
    {
        if(!is_string($netId)){
            throw new \TypeError("NetId is Not a String");
        } else if(strlen($netId) > 20){
            throw new \OutOfRangeException("NetId is Too Long");
        } else if(strlen($netId) < 3 ){
            throw new \OutOfRangeException("NetId is Too Short");
        }
        $this->netId = $netId;
    }

    public function getNetId() : string
    {
        return $this->netId;
    }

    public function setEmail(string $email): void
    {
        if(!is_string($email)){
            throw new \TypeError("Email is Not a String");
        } else if(strlen($email) > 75){
            throw new \OutOfRangeException("Email is Too Long");
        } else if(strlen($email) < 5 ){
            throw new \OutOfRangeException("Email is Too Short");
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new \InvalidArgumentException("Email is not a valid email address.");
        }
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        if(is_null($phoneNumber)){
            $phoneNumber = "";
        }
        if(!is_string($phoneNumber)){
            throw new \TypeError("Phone Number is Not a String");
        } else if(strlen($phoneNumber) > 17){
            throw new \OutOfRangeException("Phone Number is Too Long");
        }
        $this->phoneNumber = $phoneNumber;
    }

    public function getPhoneNumber() : string
    {
        return $this->phoneNumber;
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

    public function setAdminStatus($adminStatus): void
    {
        if(!$adminStatus){
            $adminStatus = 0;
        }
        $this->adminStatus = $adminStatus;
    }

    public function getAdminStatus() :bool
    {
        return $this->adminStatus;
    }

    public function insert(\PDO $pdo) :void
    {
        if($this->sconId !== null){
            throw (new \PDOException("Not a new SCON"));
        }

        $query = "INSERT INTO scon (sconId, firstName, lastName, middleInitial,netId, email,phoneNumber, startDate, adminStatus) VALUES(:sconId, :firstName, :lastName, :middleInitial, :netId, :email, :phoneNumber, :startDate, :adminStatus)";
        $statement = $pdo->prepare($query);
        $formattedDate = $this->startDate->format("Y-m-d");
        $parameters = ["sconId" => $this->getSconId(), "firstName"=> $this->firstName, "lastName"=>$this->lastName, "middleInitial"=>$this->middleInitial, "netId"=>$this->netId, "email"=> $this->email, "phoneNumber"=> $this->phoneNumber, "startDate"=>$formattedDate, "adminStatus"=> $this->adminStatus];

        $statement->execute($parameters);

        $this->sconId = intval($pdo->lastInsertId());
    }

    public function delete(\PDO $pdo){
        if(is_null($this->sconId)){
            throw new \PDOException("Can't delete an un-inserted Scon");
        }
        $query = "DELETE FROM scon WHERE sconId = :sconId";
        $statement = $pdo->prepare($query);
        $parameters = ["sconId"=>$this->sconId];
        $statement->execute($parameters);
    }

    public function update (\PDO $pdo){

        if(is_null($this->sconId)){
            throw new \PDOException("Can't update an un-inserted Scon");
        }

        $query = "UPDATE scon SET sconId = :sconId, firstName = :firstName, lastName = :lastName, middleInitial = :middleInitial, netId = :netId, email = :email, phoneNumber = :phoneNumber, startDate = :startDate, adminStatus = :adminStatus WHERE sconId = :sconId";
        $statement = $pdo->prepare($query);
        $formattedDate = $this->startDate->format("Y-m-d");
        $parameters = ["sconId" => $this->getSconId(), "firstName"=> $this->firstName, "lastName"=>$this->lastName, "middleInitial"=>$this->middleInitial, "netId"=>$this->netId, "email"=> $this->email, "phoneNumber"=> $this->phoneNumber, "startDate"=>$formattedDate, "adminStatus"=> $this->adminStatus];
        $statement->execute($parameters);
    }

    public static function getSconByNetId(\PDO $pdo, string $netId){

        $netId = trim($netId);
        $netId = filter_var($netId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);;
        $query = "SELECT sconId,  firstName, lastName, middleInitial,netId, email,phoneNumber, startDate, adminStatus FROM scon WHERE netId = :netId";
        $statement = $pdo->prepare($query);
        $parameters = ["netId"=> $netId];
        $statement->execute($parameters);

        try{
            $scon = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false){
                if($row !== false){
                    $newDate = new \DateTime($row["startDate"]);
                    if(!$newDate){
                        $newDate = new \DateTime();
                    }
                    $scon = new Scon($row["sconId"],$row["firstName"],$row["lastName"],$row["middleInitial"],$row["netId"],$row["email"],$row["phoneNumber"],$newDate,$row["adminStatus"]);
                }
            }
        }catch(\Exception $e){
            throw(new \PDOException(new \PDOException($e->getMessage(),0,$e)));
        }

        return ($scon);
    }

    public static function getSconBySconId(\PDO $pdo, int $sconId){

        $query = "SELECT sconId,  firstName, lastName, middleInitial,netId, email,phoneNumber, startDate, adminStatus FROM scon WHERE sconId = :sconId";
        $statement = $pdo->prepare($query);
        $parameters = ["sconId"=> $sconId];
        $statement->execute($parameters);

        try{
            $scon = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false){
                $newDate = new \DateTime($row["startDate"]);
                if(!$newDate){
                    $newDate = new \DateTime();
                }
                $scon = new Scon($row["sconId"],$row["firstName"],$row["lastName"],$row["middleInitial"],$row["netId"],$row["email"],$row["phoneNumber"],$newDate,$row["adminStatus"]);
            }
        }catch(\Exception $e){
            throw(new \PDOException(new \PDOException($e->getMessage(),0,$e)));
        }

        return ($scon);
    }

    public static function getAllScons(\PDO $pdo){
        $query = "SELECT sconId,  firstName, lastName, middleInitial,netId, email,phoneNumber, startDate, adminStatus FROM scon";
        $statement = $pdo->prepare($query);
        $statement->execute();

        $allScons = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !== false) {
            try {
                $newDate = new \DateTime($row["startDate"]);
                $scon = new Scon($row["sconId"],$row["firstName"],$row["lastName"],$row["middleInitial"],$row["netId"],$row["email"],$row["phoneNumber"],$newDate,$row["adminStatus"]);
                $allScons[$allScons->key()] = $scon;
                $allScons->next();
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($allScons);

    }

    public function jsonSerialize() {
        $fields = ["sconId"=>$this->getSconId(), "firstName"=> $this->getFirstName(), "lastName"=>$this->getLastName(),"middleInitial"=>$this->getMiddleInitial(),"email"=>$this->getEmail(),"netId"=>$this->getSconId(),"phoneNumber"=>$this->getPhoneNumber(), "startDate"=>$this->getStartDate(),"adminStatus"=>$this->getAdminStatus()];
        return ($fields);
    }

}