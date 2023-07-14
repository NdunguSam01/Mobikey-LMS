<?php

//Function to subtract the days
function subtractDays($startDate, $endDate)
{
    //Subtracting the days
    $startDate=strtotime($_POST["start"]);
    $endDate=strtotime($_POST["end"]);
    $diff=($endDate-$startDate);
    $numDays=floor(($diff/(60*60*24))+1)."\n";
    return $numDays;
}
?>