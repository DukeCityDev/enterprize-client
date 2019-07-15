<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 6/25/2018
 * Time: 12:42 PM
 */

namespace Unm\Scheduler;
use function PHPSTORM_META\type;
use Unm\Scheduler\Tests\SchedulerTest;
require_once(dirname(__DIR__) . "/autoload.php");
require_once("SchedulerTest.php");


class PodTest extends SchedulerTest
{
    protected $VALID_POD_NAME = "LOBO";

    public final function setUp() {
    }
    /**
     * test inserting a valid Pod and verify that the actual mySQL data matches
     **/
    public function testInsertValid() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("pod");
        // create a new Pod and insert to into mySQL
        $pod = new Pod(null,$this->VALID_POD_NAME);
        $pod->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoPod = Pod::getPodByPodName($this->getPDO(), $pod->getPodName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("pod"));
        $this->assertEquals($pdoPod->getPodId(), $pod->getPodId());
        $this->assertEquals($pdoPod->getPodName(), $this->VALID_POD_NAME);
    }

    /**
     * @expectedException \Exception
     */
    public function testInsertInvalid(){
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("pod");
        // create a new Pod and insert to into mySQL
        $pod = new Pod(67,$this->VALID_POD_NAME);
        $pod->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoPod = Pod::getPodByPodName($this->getPDO(), $pod->getPodName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("pod"));
        $this->assertEquals($pdoPod->getPodId(), $pod->getPodId());
        $this->assertEquals($pdoPod->getPodName(), $this->VALID_POD_NAME);
    }

    public function testUpdateValid(){
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("pod");
        // create a new Pod and insert to into mySQL
        $pod = new Pod(null,$this->VALID_POD_NAME);
        $pod->insert($this->getPDO());
        $pod->setPodName("ATHLETICS");
        $pod->update($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoPod = Pod::getPodByPodName($this->getPDO(), $pod->getPodName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("pod"));
        $this->assertEquals($pdoPod->getPodId(), $pod->getPodId());
        $this->assertEquals($pdoPod->getPodName(), "ATHLETICS");
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateInvalid(){
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("pod");
        // create a new Pod and insert to into mySQL
        $pod = new Pod(null,$this->VALID_POD_NAME);
        $pod->setPodName("ATHLETICS");
        $pod->update($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoPod = Pod::getPodByPodName($this->getPDO(), $pod->getPodName());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("pod"));
        $this->assertEquals($pdoPod->getPodId(), $pod->getPodId());
        $this->assertEquals($pdoPod->getPodName(), $this->VALID_POD_NAME);
    }

    public function testDeleteValid(){
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("pod");
        // create a new Pods and insert to into mySQL
        $pod = new Pod(null,$this->VALID_POD_NAME);
        $pod->insert($this->getPDO());
        // delete the Pod from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("pod"));
        $pod->delete($this->getPDO());
        // grab the data from mySQL and enforce the Pod does not exist
        $pdoPod = Pod::getPodByPodName($this->getPDO(), $pod->getPodName());
        $this->assertNull($pdoPod);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("pod"));
    }

    /**
     * @expectedException \Exception
     */
    public function testDeleteInValid(){
        $pod = new Pod(null, $this->VALID_POD_NAME);
        $pod->delete($this->getPDO());
    }

    public function testGetAllValidPods() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("pod");
        // create a new User and insert to into mySQL
        $pod = new Pod(null,$this->VALID_POD_NAME);
        $pod->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $results = Pod::getAllPods($this->getPDO());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("pod"));
        $this->assertCount(1, $results);
        $this->assertContainsOnlyInstancesOf("Unm\\Scheduler\\Pod", $results);
        // grab the result from the array and validate it
        $pdoPod = $results[0];
        $this->assertEquals($pdoPod->getPodId(), $pod->getPodId());
        $this->assertEquals($pdoPod->getPodName(), $this->VALID_POD_NAME);
        }
}