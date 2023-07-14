let startDate=document.getElementsByName("start")[0];
let endDate=document.getElementsByName("end")[0];
var currentYear=new Date().getFullYear();
var maxDateRange=currentYear + "-12-31";
var minDateRange=currentYear + "-01-01";

var today = new Date().toISOString().split('T')[0];
startDate.setAttribute('min', today);

startDate.setAttribute('max', maxDateRange);
endDate.setAttribute('max',maxDateRange);
endDate.setAttribute("min",minDateRange);

startDate.addEventListener("change",()=>
{
    endDate.setAttribute("min",startDate.value);
})