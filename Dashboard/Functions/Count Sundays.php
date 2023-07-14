<?php

//Sunday checker and counter function
function countSundays($startDate,$endDate)
{
    $startDate=new DateTime($_POST["start"]);
    $endDate=new DateTime($_POST["end"]);
    global $sundayCount;

    for($i=$startDate; $i<=$endDate; $i->modify('+1 day'))
    {
        if($startDate->format('N')==7)
        {
            $sundayCount++;//Counting how many Sundays there are
        }
    }
    return $sundayCount;
}

?>