const toggleFileInput=()=>
{
    let leaveType=document.getElementById('type');
    let fileLabel=document.getElementById("fileLabel");
    let attachemnt=document.getElementById("file-attachment");
    
    if (leaveType.value=="Paternity" || leaveType.value=="Sick") 
    {
        fileLabel.innerHTML=`
        <td id="fileLabel">
            Attach file<span>*</span>
        </td>`    
        attachemnt.required=true;
    }
    else
    {
        fileLabel.innerHTML=`
        <td id="fileLabel">
            Attach file
        </td>`    
        attachemnt.required=false;
    }
}