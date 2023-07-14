<?php
function includesHolidays($startDate,$endDate)
{
    //Saving the holidays in an array
    $holidays=[
        '01-01',
        '05-01',
        '06-01',
        '10-10',
        '10-20',
        '12-12',
        '12-25',
        '12-26'
    ];
    $start=strtotime($startDate);
    $end=strtotime($endDate);
    global $holidayCount;

    for($date=$start; $date<=$end; $date=strtotime('+1 day', $date))
    {
        $formattedDate=date('m-d', $date);

        //Checking if formatted array is in the holidays array
        if(in_array($formattedDate, $holidays))
        {
            $holidayCount++;
        }
    }
    return $holidayCount;
}
?>