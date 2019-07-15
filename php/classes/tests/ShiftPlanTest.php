<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 6/27/2018
 * Time: 3:00 PM
 */

namespace Unm\Scheduler;
use function PHPSTORM_META\type;
use Unm\Scheduler\Tests\SchedulerTest;
require_once(dirname(__DIR__) . "/autoload.php");
require_once("SchedulerTest.php");


class ShiftPlanTest extends SchedulerTest
{
    protected $VALID_POD;

    public final function setUp() {
    }
    /**
     * test inserting a valid Pod and verify that the actual mySQL data matches
     **/
    public function testInsertValid() {
        $this->VALID_POD  = new Pod(null,"LOBO");
        $this->VALID_POD->insert($this->getPDO());

        $startDate = new \DateTime('2018-01-01T00:00:00.000000Z');
        $endDate = new \DateTime('2019-01-01T00:00:00.000000Z');
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("shiftPlan");
        // create a new Pod and insert to into mySQL
        $validPodId = $this->VALID_POD->getPodId();
        $shiftPlan = new ShiftPlan(null,$validPodId, $startDate, $endDate, "SPRING 2019");
        $shiftPlan->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoShiftPlan = ShiftPlan::getShiftPlanById($this->getPDO(), $shiftPlan->getShiftPlanId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shiftPlan"));
        $this->assertEquals($pdoShiftPlan->getPodId(), $shiftPlan->getPodId());
        $this->assertEquals($pdoShiftPlan->getStartDate(),$shiftPlan->getStartDate());
        $this->assertEquals($pdoShiftPlan->getEndDate(),$shiftPlan->getEndDate());
        $this->assertEquals($pdoShiftPlan->getShiftPlanName(),$shiftPlan->getShiftPlanName());
    }

    /**
     * @expectedException \Exception
     */
    public function testInsertInvalid(){
        $this->VALID_POD  = new Pod(null,"LOBO");
        $this->VALID_POD->insert($this->getPDO());

        $startDate = new \DateTime('2018-01-01T00:00:00.000000Z');
        $endDate = new \DateTime('2019-01-01T00:00:00.000000Z');
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("shiftPlan");
        // create a new Pod and insert to into mySQL
        $shiftPlan = new ShiftPlan(68,$this->VALID_POD->getPodId(), $startDate, $endDate, "SPRING 2019");
        $shiftPlan->insert($this->getPDO());
    }

    public function testUpdateValid(){
        $startDate = new \DateTime('2018-01-01T00:00:00.000000Z');
        $endDate = new \DateTime('2019-01-01T00:00:00.000000Z');
        $this->VALID_POD  = new Pod(null,"LOBO");
        $this->VALID_POD->insert($this->getPDO());
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("shiftPlan");
        // create a new Pod and insert to into mySQL
        $shiftPlan = new ShiftPlan(null,$this->VALID_POD->getPodId(), $startDate, $endDate,"TestName");
        $shiftPlan->insert($this->getPDO());
        $shiftPlan->setShiftPlanName("TestName2");
        $shiftPlan->update($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoShiftPlan = ShiftPlan::getShiftPlanById($this->getPDO(), $shiftPlan->getShiftPlanId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shiftPlan"));
        $this->assertEquals($pdoShiftPlan->getPodId(), $shiftPlan->getPodId());
        $this->assertEquals($pdoShiftPlan->getStartDate(),$shiftPlan->getStartDate());
        $this->assertEquals($pdoShiftPlan->getEndDate(),$shiftPlan->getEndDate());
        $this->assertEquals($pdoShiftPlan->getShiftPlanName(),$shiftPlan->getShiftPlanName());
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateInvalid(){
        $startDate = new \DateTime('2018-01-01T00:00:00.000000Z');
        $endDate = new \DateTime('2019-01-01T00:00:00.000000Z');
        $this->VALID_POD  = new Pod(null,"LOBO");
        $this->VALID_POD->insert($this->getPDO());
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("shiftPlan");
        // create a new Pod and insert to into mySQL
        $shiftPlan = new ShiftPlan(null,$this->VALID_POD->getPodId(), $startDate, $endDate,"TestName");
        $shiftPlan->setShiftPlanName("TestName2");
        $shiftPlan->update($this->getPDO());
    }

    public function testDeleteValid(){
        $startDate = new \DateTime('2018-01-01T00:00:00.000000Z');
        $endDate = new \DateTime('2019-01-01T00:00:00.000000Z');
        $this->VALID_POD  = new Pod(null,"LOBO");
        $this->VALID_POD->insert($this->getPDO());
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("shiftPlan");
        // create a new Pods and insert to into mySQL
        $shiftPlan = new ShiftPlan(null,$this->VALID_POD->getPodId(), $startDate, $endDate,"TestName");
        $shiftPlan->insert($this->getPDO());
        // delete the Pod from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shiftPlan"));

        $shiftPlan->delete($this->getPDO());
        // grab the data from mySQL and enforce the Pod does not exist
        $pdoShiftPlan = ShiftPlan::getShiftPlanById($this->getPDO(), $shiftPlan->getShiftPlanId());
        $this->assertNull($pdoShiftPlan);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("shiftPlan"));
    }

    /**
     * @expectedException \Exception
     */
    public function testDeleteInValid(){
        $startDate = new \DateTime('2018-01-01T00:00:00.000000Z');
        $endDate = new \DateTime('2019-01-01T00:00:00.000000Z');
        $this->VALID_POD  = new Pod(null,"LOBO");
        $this->VALID_POD->insert($this->getPDO());
        $shiftPlan = new ShiftPlan(null,$this->VALID_POD->getPodId(), $startDate, $endDate,"TestName");
        $shiftPlan->delete($this->getPDO());
    }

    public function testGetShiftPlanByName(){
        $numRows = $this->getConnection()->getRowCount("shiftPlan");
        $startDate = new \DateTime('2018-01-01T00:00:00.000000Z');
        $endDate = new \DateTime('2019-01-01T00:00:00.000000Z');
        $this->VALID_POD  = new Pod(null,"LOBO");
        $this->VALID_POD->insert($this->getPDO());
        $shiftPlan = new ShiftPlan(null,$this->VALID_POD->getPodId(), $startDate, $endDate,"TestName");
        $shiftPlan->insert($this->getPDO());

        $pdoShiftPlan = ShiftPlan::getShiftPlanByName($this->getPDO(), $shiftPlan->getShiftPlanName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shiftPlan"));
        $this->assertEquals($pdoShiftPlan[0]->getPodId(), $shiftPlan->getPodId());
        $this->assertEquals($pdoShiftPlan[0]->getStartDate(),$shiftPlan->getStartDate());
        $this->assertEquals($pdoShiftPlan[0]->getEndDate(),$shiftPlan->getEndDate());
        $this->assertEquals($pdoShiftPlan[0]->getShiftPlanName(),$shiftPlan->getShiftPlanName());
    }

    public function testGetAllShiftPlans(){
        $numRows = $this->getConnection()->getRowCount("shiftPlan");
        $startDate = new \DateTime('2018-01-01T00:00:00.000000Z');
        $endDate = new \DateTime('2019-01-01T00:00:00.000000Z');
        $this->VALID_POD  = new Pod(null,"LOBO");
        $this->VALID_POD->insert($this->getPDO());
        $shiftPlan = new ShiftPlan(null,$this->VALID_POD->getPodId(), $startDate, $endDate,"TestName");
        $shiftPlan->insert($this->getPDO());

        $pdoShiftPlan = ShiftPlan::getAllShiftPlans($this->getPDO());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shiftPlan"));
        $this->assertEquals($pdoShiftPlan[0]->getPodId(), $shiftPlan->getPodId());
        $this->assertEquals($pdoShiftPlan[0]->getStartDate(),$shiftPlan->getStartDate());
        $this->assertEquals($pdoShiftPlan[0]->getEndDate(),$shiftPlan->getEndDate());
        $this->assertEquals($pdoShiftPlan[0]->getShiftPlanName(),$shiftPlan->getShiftPlanName());
    }
}