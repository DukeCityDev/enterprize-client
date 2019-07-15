<?php

/**
 * Created by PhpStorm.
 * User: Daniel Eaton
 * Date: 4/11/2018
 * Time: 1:33 PM
 * @version: v0.1.0
 */
namespace Unm\Scheduler\Tests;

require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use PHPUnit;
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Operation\{Composite, Factory, Operation};
use PHPUnit\Extensions\Database\DB\IDatabaseConnection;
// grab the encrypted properties file
/**
 * Abstract class containing universal and project specific mySQL parameters
 *
 * This class is designed to lay the foundation of the unit tests per project. It loads the all the database
 * parameters about the project so that table specific tests can share the parameters in on place. To use it:
 *
 * 1. Rename the class from DataDesignTest to a project specific name (e.g., ProjectNameTest)
 * 2. Put the class in the correct namespace (e.g., Edu\Cnm\ProjectName\Test)
 * 3. Modify DataDesignTest::getDataSet() to include all the tables in your project.
 * 4. Modify DataDesignTest::getConnection() to include the correct mySQL properties file.
 * 5. Have all table specific tests include this class.
 *
 * *NOTE*: Tables must be added in the order they were created in step (2).
 *
 **/
abstract class SchedulerTest extends TestCase {
    use TestCaseTrait;
    /**
     * invalid id to use for an INT UNSIGNED field (maximum allowed INT UNSIGNED in mySQL) + 1
     * @see https://dev.mysql.com/doc/refman/5.6/en/integer-types.html mySQL Integer Types
     * @var int INVALID_KEY
     **/
    const INVALID_KEY = 4294967296;
    /**
     * PHPUnit database connection interface
     * @var \PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection
     **/
    protected $connection = null;
    /**
     * assembles the table from the schema and provides it to PHPUnit
     *
     * @return \PHPUnit_Extensions_Database_DataSet_QueryDataSet assembled schema for PHPUnit
     **/
    public final function getDataSet() {
        $dataset = new QueryDataSet($this->getConnection());
        // add all the tables for the project here
        // THESE TABLES *MUST* BE LISTED IN THE SAME ORDER THEY WERE CREATED!!!!
        $dataset->addTable("scon");
        $dataset->addTable("pod");
        $dataset->addTable("shiftPlan");
        $dataset->addTable("shift");

        return($dataset);
    }
    /**
     * templates the setUp method that runs before each test; this method expunges the database before each run
     *
     * @see https://phpunit.de/manual/current/en/fixtures.html#fixtures.more-setup-than-teardown PHPUnit Fixtures: setUp and tearDown
     * @see https://github.com/sebastianbergmann/dbunit/issues/37 TRUNCATE fails on tables which have foreign key constraints
     * @return \PHPUnit_Extensions_Database_Operation_Composite array containing delete and insert commands
     **/
    public final function getSetUpOperation() {
        return new Composite(array(
            Factory::DELETE_ALL(),
            Factory::INSERT()
        ));
    }
    /**
     * templates the tearDown method that runs after each test; this method expunges the database after each run
     *
     * @return \PHPUnit_Extensions_Database_Operation_IDatabaseOperation delete command for the database
     **/
    public final function getTearDownOperation() {
        return(Factory::DELETE_ALL());
    }

    public function setUp(){

    }
    /**
     * sets up the database connection and provides it to PHPUnit
     *
     * @see <https://phpunit.de/manual/current/en/database.html#database.configuration-of-a-phpunit-database-testcase>
     * @return \PHPUnit_Extensions_Database_DB_IDatabaseConnection PHPUnit database connection interface
     **/
    public final function getConnection() {
        // if the connection hasn't been established, create it
        if($this->connection === null) {
            // connect to mySQL and provide the interface to PHPUnit
            //$ini_array = parse_ini_file("/etc/sample.ini");
            $host = 'localhost';
            $user = 'root';
            $pass = 'Crufsp747';
            $db   = 'scheduler2Test';
            $charset = 'utf8';
            $options = array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $pdo = new \PDO($dsn,$user,$pass,$options);
            $this->connection = $this->createDefaultDBConnection($pdo, $db);
        }
        return($this->connection);
    }
    /**
     * returns the actual PDO object; this is a convenience method
     *
     * @return \PDO active PDO object
     **/
    public final function getPDO() {
        return($this->getConnection()->getConnection());
    }
}