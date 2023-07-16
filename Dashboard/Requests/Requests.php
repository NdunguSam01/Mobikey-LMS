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
            echo "<td>". $requestRow['filePath']. "</td>";
            echo "<td><a href='#'>View</a></td>";
        }
    }
    else
    {
        echo "<tr>
        <td colspan=8 style='text-align: center'>No Records Found</td>
        </tr>";
    }
?>