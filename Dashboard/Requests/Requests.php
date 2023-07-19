<?php 
    if(mysqli_num_rows($requestResult)>0)
    {
        while($requestRow=mysqli_fetch_assoc($requestResult))
        {
            echo "<tr>";
            echo "<td>". $requestRow['fname']. "</td>";   
            echo "<td>". $requestRow['lname']. "</td>";   
            echo "<td>". $requestRow['leaveType']. "</td>";   
            echo "<td>". $requestRow['startDate']. "</td>";   
            echo "<td>". $requestRow['endDate']. "</td>";   
            echo "<td>". $requestRow['numDays']. "</td>";
            if($requestRow['filePath']=="NULL")
            {
                echo "<td>No file attachment</td>";
            }
            elseif($requestRow['leaveType']=="Paternity")
            {
                $file=$requestRow["filePath"];
                echo "<td><a href='./Sick Leave/<?php echo $file;?>'></a></td>";
            }
            elseif($requestRow['leaveType']=="Sick")
            {
                $file=$requestRow["filePath"];
                echo "<td><a href='./Sick Leave/<?php echo $file;?>'></a></td>";
            }
            echo "<td><button type='submit' name='approve' id='approve' title='Approve request'>Approve request</button></td>";
            echo "<td><button type='submit' name='reject' id='reject' title='Reject request'>Reject request</button></td>";
            ;
        }
    }
    else
    {
        echo "<tr>
        <td colspan=8 style='text-align: center'>No Records Found</td>
        </tr>";
    }
?>