let start=document.getElementById("start");
let end=document.getElementById("end");
let leaveType=document.getElementById("type");

let totalNum=document.getElementById("numDays")

//Function to check if date range includes a Saturday
const checkSaturdays=(startDate, endDate)=>
{
    const start=new Date(startDate);
    const end=new Date(endDate);

    let saturdayCount=0;

    //Iterating through the dates
    let currentDate=new Date(start);
    while (currentDate<=end) 
    {
        if(currentDate.getDay()===6)
        {
            saturdayCount++;
        }   
        currentDate.setDate(currentDate.getDate() +1) 
    }
    return saturdayCount;
}

//Function to check if date range includes a Saturday
const checkSundays=(startDate, endDate)=>
{
    const start=new Date(startDate);
    const end=new Date(endDate);

    let sundayCount=0;

    //Iterating through the dates
    let currentDate=new Date(start);
    while (currentDate<=end) 
    {
        if(currentDate.getDay()===0)
        {
            sundayCount++;
        }   
        currentDate.setDate(currentDate.getDate() +1) 
    }
    return sundayCount;
}

//Function to check if date range includes a holiday
const checkHolidays=(startDate,endDate)=>
{
    let start=new Date(startDate);
    const end=new Date(endDate);
    let holidayCount=0;

    let currentDate=new Date(start);

    while(currentDate<=end)
    {
        const formattedDate = currentDate.toISOString().split('T')[0];

        if(holidays.includes(formattedDate))
        {
            holidayCount++;
        }

        //Move on to the next date
        currentDate.setDate(currentDate.getDate() +1);
    }
    return holidayCount;
}

//Initializing the holidays
let year=new Date().getFullYear();
const holidays=[
    year+ '01-01',
    year+ '05-01',
    year+ '06-01',
    year+ '10-10',
    year+ '10-20',
    year+ '12-12',
    year+ '12-25',
    year+ '12-26'
];


//Function to subtract the days
const subtractDays=(start,end)=>
{
    const startDate=new Date(start)
    const endDate=new Date(end);

    //Calculating the time difference in milliseconds
    const timeDiffInMiliiseconds=endDate-startDate;

    //Converting the difference back to days
    let timeDiffInDays=timeDiffInMiliiseconds/(1000*60*60*24)
    return timeDiffInDays+1;
}

const getTotalDays=()=>
{

    if(leaveType.value=="Normal")
    {
        end.onchange=()=>
        {

            const originalLeaveDays=subtractDays(start.value,end.value);
            const holidays=checkHolidays(start.value,end.value);
            const saturdays=checkSaturdays(start.value,end.value);
            const sundays=checkSundays(start.value,end.value);

            const totalLeaveDays=originalLeaveDays-(holidays*1)-(saturdays*0.5)-(sundays*1);
            totalNum.value=totalLeaveDays;
            console.log(totalNum.value);
        }
    }
    else if(leaveType.value=="Paternity")
    {
        end.onchange=()=>
        {
            const originalLeaveDays=subtractDays(start.value,end.value);
            totalNum.value=originalLeaveDays;
            console.log(totalNum.value);
        }
    }
    else if(leaveType.value=="Maternity")
    {
        end.onchange=()=>
        {
            const originalLeaveDays=subtractDays(start.value,end.value);
            totalNum.value=originalLeaveDays;
            console.log(totalNum.value);
        }
    }
    else if(leaveType.value=="Sick")
    {
        end.onchange=()=>
        {
            const originalLeaveDays=subtractDays(start.value,end.value);
            const holidays=checkHolidays(start.value,end.value);
            const saturdays=checkSaturdays(start.value,end.value);
            const sundays=checkSundays(start.value,end.value);

            const totalLeaveDays=originalLeaveDays-(holidays*1)-(saturdays*0.5)-(sundays*1);
            totalNum.value=totalLeaveDays;
            console.log(totalNum.value);
        }
    }
}

leaveType.addEventListener('change',getTotalDays);

