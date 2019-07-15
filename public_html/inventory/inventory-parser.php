<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 11/27/2018
 * Time: 3:19 PM
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




function csvParse()
{

    $parentfile = file_get_contents('maininventory.csv');
    $childfile = file_get_contents('subinventory.csv');
    $mediacollabfile = file_get_contents('MediaCollabInventory.csv');
    $avfile = file_get_contents('AVInventory.csv');

    $parentcsv = str_getcsv($parentfile);
    $childcsv = str_getcsv($childfile);
    $avcsv = str_getcsv($avfile);
    $mediacollabcsv = str_getcsv($mediacollabfile);

    $foundParentData = array();
    $childData = array();
    $parentData = array();
    $avData = array();
    $collabData = array();
    $arrayNotFound = array();


    $DANE_SMITH_HALL = 48;
    $ESCP = 2;
    $CJ = 115;
    $JOHNSON = 59;
    $SUB = 60;

    //PARSE AND POPULATE CHILD DATA FROM CSV
    for ($i = 17; $i < count($childcsv) - 1; $i += 17) {
//        echo ($childcsv[$i-17]." "); //CJPR
//        echo ($childcsv[$i-16]." "); //Asset Tag
//        echo ($childcsv[$i-15]." "); //Service Tag
//        echo ($childcsv[$i-14]." "); //Model
//        echo ($childcsv[$i-13]." "); //Type
//        echo ($childcsv[$i-12]." "); //Environment
//        echo ($childcsv[$i-11]." "); // Building
//        echo ($childcsv[$i-10]." "); // room
//        echo ($childcsv[$i-9]." "); //purchase date
//        echo ($childcsv[$i-8]." "); //off warranty
//        echo ($childcsv[$i-7]." "); //replacement date
//        echo ($childcsv[$i-6]." "); //Updated Date
//        echo ($childcsv[$i-5]." ");// Original Cost
//        echo ($childcsv[$i-4]." ");//Notes
//        echo ("<br />");

        $childArrayItem = array();

        array_push($childArrayItem, $childcsv[$i - 17], $childcsv[$i - 16], $childcsv[$i - 15], $childcsv[$i - 14], $childcsv[$i - 13], $childcsv[$i - 12], $childcsv[$i - 11], $childcsv[$i - 10], $childcsv[$i - 9], $childcsv[$i - 8], $childcsv[$i - 7], $childcsv[$i - 6], $childcsv[$i - 5], $childcsv[$i - 4]);
        array_push($childData, $childArrayItem);
    }

    //PARSE AND POPULATE PARENT DATA FROM CSV

    for ($i = 24; $i < count($parentcsv) - 1; $i += 24) {
        $parentArrayItem = array();

        array_push($parentArrayItem, $parentcsv[$i - 24], $parentcsv[$i - 23], $parentcsv[$i - 22], $parentcsv[$i - 21], $parentcsv[$i - 20], $parentcsv[$i - 19], $parentcsv[$i - 18], $parentcsv[$i - 17], $parentcsv[$i - 16], $parentcsv[$i - 15], $parentcsv[$i - 14], $parentcsv[$i - 13], $parentcsv[$i - 12], $parentcsv[$i - 11], $parentcsv[$i - 10], $parentcsv[$i - 9], $parentcsv[$i - 8], $parentcsv[$i - 7], $parentcsv[$i - 6], $parentcsv[$i - 5], $parentcsv[$i - 4], $parentcsv[$i - 3], $parentcsv[$i - 2], $parentcsv[$i - 1], $parentcsv[$i]);
        array_push($parentData, $parentArrayItem);

    }

    //PARSE AND POPULATE AV DATA FROM CSV
    for ($i = 0; $i < count($avcsv) - 1; $i++) {
        array_push($avData, $avcsv[$i]);

    }
//    while ((count($avData) - 1) < count($childData) - 1) {
//        array_push($avData, ' ');
//    }

    //PARSE AND POPULATE MEDIA/COLLAB DATA FROM CSV
    for ($i = 0; $i < count($mediacollabcsv) - 1; $i++) {
        array_push($collabData, $mediacollabcsv[$i]);

    }
//    while ((count($collabData) - 1) < count($childData) - 1) {
//        array_push($collabData, ' ');
//    }
//    for ($i = 0; $i < count($collabData) - 1; $i++) {
//        echo $collabData[$i];
//        echo "<br />";
//
//    }


    $match = false;
    $matchcount = 0;

    //
    for ($i = 0; $i < count($parentData) - 1; $i++) {
        $parentAsset = trim($parentData[$i][2]);
        $matchtrigger = false;

        for ($a = 0; $a < count($childData) - 1; $a++) {
            $childAsset = trim($childData[$a][1]);
            $match = strcmp($childAsset, $parentAsset);
            if ($match == 0) {


                $alreadyExists = false;
                for ($x = 0; $x < count($foundParentData) - 1; $x++) {
                    if (strcmp($childAsset, trim($foundParentData[$x][2]))== 0) {
                        $alreadyExists = true;
                    }
                }
                if (!$alreadyExists) {

                    $matchcount++;
                    array_push($foundParentData, $parentData[$i]);

                }
            }
        }
    }

    for ($i = 0; $i < count($parentData) - 1; $i++) {
        $parentAsset = trim($parentData[$i][2]);
        $matchtrigger = false;
        for ($a = 0; $a < count($collabData) - 1; $a++) {
            $collabAsset = trim($collabData[$a]);
            $match = strcmp($collabAsset,$parentAsset);

            if($match == 0){

                $alreadyExists = false;
                for($x = 0; $x < count($foundParentData)-1; $x++){
                    if(strcmp($collabAsset,trim($foundParentData[$x][2]))== 0){
                        $alreadyExists = true;
                    }
                }
                if(!$alreadyExists){

                    $matchcount++;
                    array_push($foundParentData, $parentData[$i]);

                }
            }
        }

    }

    for ($i = 0; $i < count($parentData) - 1; $i++) {
        $parentAsset = trim($parentData[$i][2]);
        $matchtrigger = false;
        for ($a = 0; $a < count($avData) - 1; $a++) {
            $avAsset = trim($avData[$a]);
            $match = strcmp($avAsset,$parentAsset);
            if($match == 0){

                $alreadyExists = false;
                for($x = 0; $x < count($foundParentData)-1; $x++){
                    if(strcmp($avAsset,trim($foundParentData[$x][2]))== 0){
                        $alreadyExists = true;
                    }
                }
                if(!$alreadyExists){

                    $matchcount++;
                    array_push($foundParentData, $parentData[$i]);

                }
            }
        }

    }


    //wrapUp -- print found data
//    for ($i = 0; $i < count($foundParentData) - 1; $i++) {
//
//        if((int)$foundParentData[$i][13] == $SUB){
//            $foundParentData[$i][13] = "Student Union Building";
//        } elseif ((int)$foundParentData[$i][13] == $DANE_SMITH_HALL){
//            $foundParentData[$i][13] = "Dane Smith Hall";
//        }elseif ((int)$foundParentData[$i][13] == $JOHNSON){
//            $foundParentData[$i][13] = "Johnson Center";
//        }elseif ((int)$foundParentData[$i][13] == $CJ){
//            $foundParentData[$i][13] = "Comm and Journalism";
//        }elseif ((int)$foundParentData[$i][13] == $ESCP){
//            $foundParentData[$i][13] = "ESCP";
//        }
//
//
//        echo "<tr>";
//        echo "<td>".$foundParentData[$i][0]."</td>"."<td>".$foundParentData[$i][1]."</td>"."<td>".$foundParentData[$i][2]."</td>"."<td>". $foundParentData[$i][3]."</td>"."<td>".$foundParentData[$i][4]."</td>"."<td>".$foundParentData[$i][5]."</td>"."<td>".$foundParentData[$i][6]."</td>"."<td>".$foundParentData[$i][7]."</td>"."<td>".$foundParentData[$i][8]."</td>"."<td>".$foundParentData[$i][9]."</td>"."<td>".$foundParentData[$i][10]."</td>"."<td>".$foundParentData[$i][11]."</td>"."<td>".$foundParentData[$i][12]."</td>"."<td>".$foundParentData[$i][13]."</td>"."<td>".$foundParentData[$i][14]."</td>";
//            echo "</tr>";
//
//    }


    //find unfound data
    for ($i = 0; $i < count($parentData) - 1; $i++) {
        $parentNmlAsset = trim($parentData[$i][2]);
        $found = false;


        for($x = 0; $x < count($foundParentData)-1; $x++){
            $foundAsset = trim($foundParentData[$x][2]);

            $match = strcmp($parentNmlAsset,$foundAsset);

            if($match == 0){
                $found = true;
            }
        }

        if(!$found){
            array_push($arrayNotFound,$parentData[$i]);
        }
    }




    for ($i = 0; $i < count($arrayNotFound) - 1; $i++) {
        if((int)$arrayNotFound[$i][13] == $SUB){
            $arrayNotFound[$i][13] = "Student Union Building";
        } elseif ((int)$arrayNotFound[$i][13] == $DANE_SMITH_HALL){
            $arrayNotFound[$i][13] = "Dane Smith Hall";
        }elseif ((int)$arrayNotFound[$i][13] == $JOHNSON){
            $arrayNotFound[$i][13] = "Johnson Center";
        }elseif ((int)$arrayNotFound[$i][13] == $CJ){
            $arrayNotFound[$i][13] = "Comm and Journalism";
        }elseif ((int)$foundParentData[$i][13] == $ESCP){
            $arrayNotFound[$i][13] = "ESCP";
        }
        echo "<tr>";
        echo "<td>".$arrayNotFound[$i][0]."</td>"."<td>".$arrayNotFound[$i][1]."</td>"."<td>".$arrayNotFound[$i][2]."</td>"."<td>". $arrayNotFound[$i][3]."</td>"."<td>".$arrayNotFound[$i][4]."</td>"."<td>".$arrayNotFound[$i][5]."</td>"."<td>".$arrayNotFound[$i][6]."</td>"."<td>".$arrayNotFound[$i][7]."</td>"."<td>".$arrayNotFound[$i][8]."</td>"."<td>".$arrayNotFound[$i][9]."</td>"."<td>".$arrayNotFound[$i][10]."</td>"."<td>".$arrayNotFound[$i][11]."</td>"."<td>".$arrayNotFound[$i][12]."</td>"."<td>".$arrayNotFound[$i][13]."</td>"."<td>".$arrayNotFound[$i][14]."</td>";
            echo "</tr>";

    }



        echo "<br/> "."MATCH COUNT: ".$matchcount."</br>";
}
echo "<table>";
csvParse();
echo "</table>";
