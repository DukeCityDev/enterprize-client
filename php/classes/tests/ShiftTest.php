<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 7/3/2018
 * Time: 9:30 AM
 */

namespace Unm\Scheduler;
use function PHPSTORM_META\type;
use Unm\Scheduler\Tests\SchedulerTest;
require_once(dirname(__DIR__) . "/autoload.php");
require_once("SchedulerTest.php");


class ShiftTest extends SchedulerTest
{
    protected $VALID_START_DATE;
    protected $VALID_END_DATE;
    protected $VALID_SCON;
    protected $VALID_SHIFTPLAN;
    protected $VALID_POD;

    public final function setUp() {
        $this->VALID_SCON = new Scon(null,"Daniel","Eaton","G","deaton747","deaton747@unm.edu","505-301-4618",$this->VALID_START_DATE,false);
        $this->VALID_SCON->insert($this->getPDO());
        $this->VALID_POD  = new Pod(null,"LOBO");
        $this->VALID_POD->insert($this->getPDO());
        $this->VALID_START_DATE = new \DateTime('2018-01-01T00:00:00.000000Z');
        $this->VALID_END_DATE = new \DateTime('2019-01-01T00:00:00.000000Z');
        $this->VALID_SHIFTPLAN = new ShiftPlan(null,$this->VALID_POD->getPodId(),$this->VALID_START_DATE,$this->VALID_END_DATE,"Summer 2018");
        $this->VALID_SHIFTPLAN->insert($this->getPDO());
    }

    /**
     * test inserting a valid Pod and verify that the actual mySQL data matches
     **/
    public function testInsertValid() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("shift");
        // create a new Pod and insert to into mySQL
        $shift = new Shift(null,$this->VALID_SCON->getNetId(), $this->VALID_POD->getPodId(),$this->VALID_SHIFTPLAN->getShiftPlanId(),$this->VALID_START_DATE,$this->VALID_END_DATE, true);
        $shift->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoShift = Shift::getShiftById($this->getPDO(), $shift->getShiftId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shift"));
        $this->assertEquals($pdoShift->getSconNetId(), $shift->getSconNetId());
        $this->assertEquals($pdoShift->getShiftPlanId(), $shift->getShiftPlanId());
        $this->assertEquals($pdoShift->getPodId(), $shift->getPodId());
        $this->assertEquals($pdoShift->getStartDate(),$shift->getStartDate());
        $this->assertEquals($pdoShift->getEndDate(),$shift->getEndDate());
        $this->assertEquals($pdoShift->getAvailable(),$shift->getAvailable());
    }

    /**
     * @expectedException \Exception
     */
    public function testInsertInvalid(){
        $numRows = $this->getConnection()->getRowCount("shift");
        // create a new Pod and insert to into mySQL
        $shift = new Shift(68,$this->VALID_SCON->getNetId(), $this->VALID_POD->getPodId(),$this->VALID_SHIFTPLAN->getShiftPlanId(),$this->VALID_START_DATE,$this->VALID_END_DATE, true);
        $shift->insert($this->getPDO());
    }

    public function testUpdateValid(){
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("shift");
        // create a new Pod and insert to into mySQL
        $shift = new Shift(null,$this->VALID_SCON->getNetId(), $this->VALID_POD->getPodId(),$this->VALID_SHIFTPLAN->getShiftPlanId(),$this->VALID_START_DATE,$this->VALID_END_DATE, true);
        $shift->insert($this->getPDO());
        $shift->setAvailable(false);
        $shift->update($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoShift = Shift::getShiftById($this->getPDO(), $shift->getShiftId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shift"));
        $this->assertEquals($pdoShift->getSconNetId(), $shift->getSconNetId());
        $this->assertEquals($pdoShift->getShiftPlanId(), $shift->getShiftPlanId());
        $this->assertEquals($pdoShift->getPodId(), $shift->getPodId());
        $this->assertEquals($pdoShift->getStartDate(),$shift->getStartDate());
        $this->assertEquals($pdoShift->getEndDate(),$shift->getEndDate());
        $this->assertEquals($pdoShift->getAvailable(), false);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateInvalid(){
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("shift");
        // create a new Pod and insert to into mySQL
        $shift = new Shift(null,$this->VALID_SCON->getNetId(), $this->VALID_POD->getPodId(),$this->VALID_SHIFTPLAN->getShiftPlanId(),$this->VALID_START_DATE,$this->VALID_END_DATE, true);
        $shift->setAvailable(false);
        $shift->update($this->getPDO());
    }

    public function testDeleteValid(){
        $numRows = $this->getConnection()->getRowCount("shift");
        // create a new Pods and insert to into mySQL
        $shift = new Shift(null,$this->VALID_SCON->getNetId(), $this->VALID_POD->getPodId(),$this->VALID_SHIFTPLAN->getShiftPlanId(),$this->VALID_START_DATE,$this->VALID_END_DATE, true);
        $shift->insert($this->getPDO());
        // delete the Pod from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shiftPlan"));

        $shift->delete($this->getPDO());
        // grab the data from mySQL and enforce the Pod does not exist
        $pdoShift = Shift::getShiftById($this->getPDO(), $shift->getShiftId());
        $this->assertNull($pdoShift);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("shift"));
    }

    /**
     * @expectedException \Exception
     */
    public function testDeleteInValid(){
        $numRows = $this->getConnection()->getRowCount("shift");
        // create a new Pods and insert to into mySQL
        $shift = new Shift(null,$this->VALID_SCON->getNetId(), $this->VALID_POD->getPodId(),$this->VALID_SHIFTPLAN->getShiftPlanId(),$this->VALID_START_DATE,$this->VALID_END_DATE, true);
        $shift->delete($this->getPDO());
    }

    public function testGetShiftsBySconNetId(){
        $numRows = $this->getConnection()->getRowCount("shift");
        $shift = new Shift(null,$this->VALID_SCON->getNetId(), $this->VALID_POD->getPodId(),$this->VALID_SHIFTPLAN->getShiftPlanId(),$this->VALID_START_DATE,$this->VALID_END_DATE, true);
        $shift->insert($this->getPDO());

        $pdoShift = Shift::getShiftsBySconNetId($this->getPDO(), $this->VALID_SCON->getNetId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shift"));
        $this->assertEquals($pdoShift[0]->getSconNetId(), $shift->getSconNetId());
        $this->assertEquals($pdoShift[0]->getShiftPlanId(), $shift->getShiftPlanId());
        $this->assertEquals($pdoShift[0]->getPodId(), $shift->getPodId());
        $this->assertEquals($pdoShift[0]->getStartDate(),$shift->getStartDate());
        $this->assertEquals($pdoShift[0]->getEndDate(),$shift->getEndDate());
        $this->assertEquals($pdoShift[0]->getAvailable(), $shift->getAvailable());
    }

    public function testGetShiftsByShiftPlanId(){
        $numRows = $this->getConnection()->getRowCount("shift");
        $shift = new Shift(null,$this->VALID_SCON->getNetId(), $this->VALID_POD->getPodId(),$this->VALID_SHIFTPLAN->getShiftPlanId(),$this->VALID_START_DATE,$this->VALID_END_DATE, true);
        $shift->insert($this->getPDO());

        $pdoShift = Shift::getShiftsByShiftPlanId($this->getPDO(), $this->VALID_SHIFTPLAN->getShiftPlanId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shift"));
        $this->assertEquals($pdoShift[0]->getSconNetId(), $shift->getSconNetId());
        $this->assertEquals($pdoShift[0]->getShiftPlanId(), $shift->getShiftPlanId());
        $this->assertEquals($pdoShift[0]->getPodId(), $shift->getPodId());
        $this->assertEquals($pdoShift[0]->getStartDate(),$shift->getStartDate());
        $this->assertEquals($pdoShift[0]->getEndDate(),$shift->getEndDate());
        $this->assertEquals($pdoShift[0]->getAvailable(), $shift->getAvailable());
    }

    public function testGetShiftByShiftPlanIdAndPodId(){
        $numRows = $this->getConnection()->getRowCount("shift");
        $shift = new Shift(null,$this->VALID_SCON->getNetId(), $this->VALID_POD->getPodId(),$this->VALID_SHIFTPLAN->getShiftPlanId(),$this->VALID_START_DATE,$this->VALID_END_DATE, true);
        $shift->insert($this->getPDO());
        $pdoShift = Shift::getShiftsByShiftPlanIdAndPodId($this->getPDO(), $this->VALID_SHIFTPLAN->getShiftPlanId(),$this->VALID_POD->getPodId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("shift"));
        $this->assertEquals($pdoShift[0]->getSconNetId(), $shift->getSconNetId());
        $this->assertEquals($pdoShift[0]->getShiftPlanId(), $shift->getShiftPlanId());
        $this->assertEquals($pdoShift[0]->getPodId(), $shift->getPodId());
        $this->assertEquals($pdoShift[0]->getStartDate(),$shift->getStartDate());
        $this->assertEquals($pdoShift[0]->getEndDate(),$shift->getEndDate());
        $this->assertEquals($pdoShift[0]->getAvailable(), $shift->getAvailable());

    }

}