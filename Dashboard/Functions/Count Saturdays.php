<?php

//Saturday checker and counter function
function countSaturdays($startDate,$endDate)
{
    $startDate=new DateTime($_POST["start"]);
    $endDate=new DateTime($_POST["end"]);
    global $saturdayCount;

    for($i=$startDate; $i<=$endDate; $i->modify('+1 day'))
    {
        if($startDate->format('N')==6)
        {
            $saturdayCount++;//Counting how many Saturdays there are
        }
    }
    return $saturdayCount;
}

?>