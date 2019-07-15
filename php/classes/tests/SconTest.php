<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 6/19/2018
 * Time: 2:43 PM
 */
namespace Unm\Scheduler;
use function PHPSTORM_META\type;
use Unm\Scheduler\Tests\SchedulerTest;
require_once(dirname(__DIR__) . "/autoload.php");
require_once("SchedulerTest.php");
/**
 * UserTest Class
 *
 * This User Test will test the search for users by Id, Username,
 *
 *
 **/


class SconTest extends SchedulerTest{

    protected $VALID_NET_ID = "testperson";
    protected $VALID_FIRST_NAME = "Daniel";
    protected $VALID_LAST_NAME = "Eaton";
    protected $VALID_EMAIL = "deaton747@unm.edu";
    protected $VALID_MIDDLE_INITIAL = "G";
    protected $VALID_PHONE_NUMBER = "(505)-301-4619";
    protected $VALID_START_DATE;
    protected $VALID_ADMIN_STATUS = true;
    protected $VALID_HASH;
    protected $VALID_SALT;

    protected $user = null;
    public final function setUp() {
    }
    /**
     * test inserting a valid Scon and verify that the actual mySQL data matches
     **/
    public function testInsertValid() {
        $this->VALID_START_DATE = new \DateTime("2018-01-01T00:00:00.000000Z");

        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("scon");
        // create a new User and insert to into mySQL
        $scon = new Scon(null,$this->VALID_FIRST_NAME, $this->VALID_LAST_NAME,$this->VALID_MIDDLE_INITIAL, $this->VALID_NET_ID, $this->VALID_EMAIL, $this->VALID_PHONE_NUMBER, $this->VALID_START_DATE, $this->VALID_ADMIN_STATUS);
        $scon->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoScon = Scon::getSconBySconId($this->getPDO(), $scon->getSconId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("scon"));
        $this->assertEquals($pdoScon->getFirstName(), $this->VALID_FIRST_NAME);
        $this->assertEquals($pdoScon->getLastName(), $this->VALID_LAST_NAME);
        $this->assertEquals($pdoScon->getMiddleInitial(), $this->VALID_MIDDLE_INITIAL);
        $this->assertEquals($pdoScon->getNetId(), $this->VALID_NET_ID);
        $this->assertEquals($pdoScon->getEmail(), $this->VALID_EMAIL);
        $this->assertEquals($pdoScon->getPhoneNumber(), $this->VALID_PHONE_NUMBER);
        $this->assertEquals($pdoScon->getStartDate(), $this->VALID_START_DATE);
        $this->assertEquals($pdoScon->getAdminStatus(), $this->VALID_ADMIN_STATUS);
    }
    /**
     * test inserting a User that already exists
     * @expectedException \Exception
     **/
    public function testInsertInvalidUser() {
        $this->VALID_START_DATE = new \DateTime("2018-01-01T00:00:00.000000Z");

        // create a User with a non null user id and watch it fail
        $scon = new Scon(SchedulerTest::INVALID_KEY,$this->VALID_FIRST_NAME, $this->VALID_LAST_NAME,$this->VALID_MIDDLE_INITIAL, $this->VALID_NET_ID, $this->VALID_EMAIL, $this->VALID_PHONE_NUMBER, $this->VALID_START_DATE, $this->VALID_ADMIN_STATUS);
        $scon->insert($this->getPDO());
    }
    /**
     * test inserting a User, editing it, and then updating it
     **/
    public function testUpdateValidUser() {
        $this->VALID_START_DATE = new \DateTime("2018-01-01T00:00:00.000000Z");

        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("scon");
        // create a new User and insert to into mySQL
        $scon = new Scon(null,$this->VALID_FIRST_NAME, $this->VALID_LAST_NAME,$this->VALID_MIDDLE_INITIAL, $this->VALID_NET_ID, $this->VALID_EMAIL, $this->VALID_PHONE_NUMBER, $this->VALID_START_DATE, $this->VALID_ADMIN_STATUS);
        $scon->insert($this->getPDO());
        // edit the User and update it in mySQL
        $scon->setNetId("newDeaton");
        $scon->update($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoScon = Scon::getSconBySconId($this->getPDO(), $scon->getSconId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("scon"));
        $this->assertEquals($pdoScon->getFirstName(), $this->VALID_FIRST_NAME);
        $this->assertEquals($pdoScon->getLastName(), $this->VALID_LAST_NAME);
        $this->assertEquals($pdoScon->getMiddleInitial(), $this->VALID_MIDDLE_INITIAL);
        $this->assertEquals($pdoScon->getNetId(), "newDeaton");
        $this->assertEquals($pdoScon->getEmail(), $this->VALID_EMAIL);
        $this->assertEquals($pdoScon->getPhoneNumber(), $this->VALID_PHONE_NUMBER);
        $this->assertEquals($pdoScon->getStartDate(), $this->VALID_START_DATE);
        $this->assertEquals($pdoScon->getAdminStatus(), $this->VALID_ADMIN_STATUS);
    }
    /**
     * test updating a User that does not exist
     * @expectedException \PDOException
     **/
    public function testUpdateInvalidUser() {
        $this->VALID_START_DATE = new \DateTime("2018-01-01T00:00:00.000000Z");
        // create a User, try to update it without actually inserting it and watch it fail
        $scon = new Scon(null,$this->VALID_FIRST_NAME, $this->VALID_LAST_NAME,$this->VALID_MIDDLE_INITIAL, $this->VALID_NET_ID, $this->VALID_EMAIL, $this->VALID_PHONE_NUMBER, $this->VALID_START_DATE, $this->VALID_ADMIN_STATUS);
        $scon->update($this->getPDO());
    }
    /**
     * test creating a User and then deleting it
     **/
    public function testDeleteValidUser() {
        $this->VALID_START_DATE = new \DateTime("2018-01-01T00:00:00.000000Z");

        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("scon");
        // create a new User and insert to into mySQL
        $scon = new Scon(null,$this->VALID_FIRST_NAME, $this->VALID_LAST_NAME,$this->VALID_MIDDLE_INITIAL, $this->VALID_NET_ID, $this->VALID_EMAIL, $this->VALID_PHONE_NUMBER, $this->VALID_START_DATE, $this->VALID_ADMIN_STATUS);
        $scon->insert($this->getPDO());
        // delete the User from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("scon"));
        $scon->delete($this->getPDO());
        // grab the data from mySQL and enforce the User does not exist
        $pdoScon = Scon::getSconBySconId($this->getPDO(), $scon->getSconId());
        $this->assertNull($pdoScon);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("scon"));
    }
    /**
     * test deleting a User that does not exist
     * @expectedException \Exception
     **/
    public function testDeleteInvalidUser() {
        $this->VALID_START_DATE = new \DateTime("2018-01-01T00:00:00.000000Z");

        // create a User and try to delete it without actually inserting it
        $scon = new Scon(null,$this->VALID_FIRST_NAME, $this->VALID_LAST_NAME,$this->VALID_MIDDLE_INITIAL, $this->VALID_NET_ID, $this->VALID_EMAIL, $this->VALID_PHONE_NUMBER, $this->VALID_START_DATE, $this->VALID_ADMIN_STATUS);
        $scon->delete($this->getPDO());
    }
    /**
     * test grabbing a User by user name
     **/
    public function testGetValidSconByNetId() {
        $this->VALID_START_DATE = new \DateTime("2018-01-01T00:00:00.000000Z");

        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("scon");
        // create a new User and insert to into mySQL
        $scon = new Scon(null,$this->VALID_FIRST_NAME, $this->VALID_LAST_NAME,$this->VALID_MIDDLE_INITIAL, $this->VALID_NET_ID, $this->VALID_EMAIL, $this->VALID_PHONE_NUMBER, $this->VALID_START_DATE, $this->VALID_ADMIN_STATUS);
        $scon->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $results = Scon::getSconByNetId($this->getPDO(), $scon->getNetId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("scon"));
        // grab the result from the array and validate it
        $pdoScon = $results;
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("scon"));
        $this->assertEquals($pdoScon->getFirstName(), $this->VALID_FIRST_NAME);
        $this->assertEquals($pdoScon->getLastName(), $this->VALID_LAST_NAME);
        $this->assertEquals($pdoScon->getMiddleInitial(), $this->VALID_MIDDLE_INITIAL);
        $this->assertEquals($pdoScon->getNetId(), $this->VALID_NET_ID);
        $this->assertEquals($pdoScon->getEmail(), $this->VALID_EMAIL);
        $this->assertEquals($pdoScon->getPhoneNumber(), $this->VALID_PHONE_NUMBER);
        $this->assertEquals($pdoScon->getStartDate(), $this->VALID_START_DATE);
        $this->assertEquals($pdoScon->getAdminStatus(), $this->VALID_ADMIN_STATUS);
    }

    public function testGetAllValidScons() {
        $this->VALID_START_DATE = new \DateTime("2018-01-01T00:00:00.000000Z");

        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("scon");
        // create a new User and insert to into mySQL
        $scon = new Scon(null,$this->VALID_FIRST_NAME, $this->VALID_LAST_NAME,$this->VALID_MIDDLE_INITIAL, $this->VALID_NET_ID, $this->VALID_EMAIL, $this->VALID_PHONE_NUMBER, $this->VALID_START_DATE, $this->VALID_ADMIN_STATUS);
        $scon->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $results = Scon::getAllScons($this->getPDO());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("scon"));
        $this->assertCount(1, $results);
        $this->assertContainsOnlyInstancesOf("Unm\\Scheduler\\Scon", $results);
        // grab the result from the array and validate it
        $pdoScon = $results[0];
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("scon"));
        $this->assertEquals($pdoScon->getFirstName(), $this->VALID_FIRST_NAME);
        $this->assertEquals($pdoScon->getLastName(), $this->VALID_LAST_NAME);
        $this->assertEquals($pdoScon->getMiddleInitial(), $this->VALID_MIDDLE_INITIAL);
        $this->assertEquals($pdoScon->getNetId(), $this->VALID_NET_ID);
        $this->assertEquals($pdoScon->getEmail(), $this->VALID_EMAIL);
        $this->assertEquals($pdoScon->getPhoneNumber(), $this->VALID_PHONE_NUMBER);
        $this->assertEquals($pdoScon->getStartDate(), $this->VALID_START_DATE);
        $this->assertEquals($pdoScon->getAdminStatus(), $this->VALID_ADMIN_STATUS);    }

}
