<?php
/**
 * Created by PhpStorm.
 * User: deaton747
 * Date: 6/15/2018
 * Time: 3:38 PM
 */

namespace Unm\Scheduler;


class Util
{
    public static function verifyDate(\DateTime $date){
        $dateString = $date->format('m/d/Y');
        return (\DateTime::createFromFormat('m/d/Y',$dateString) !==false);
    }
}