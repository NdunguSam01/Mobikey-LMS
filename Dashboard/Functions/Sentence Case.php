<?php
function convertToSentenceCase($str) 
{
    // Convert the entire string to lowercase
    $lowercaseStr = strtolower($str);
    
    // Capitalize the first character of each sentence
    $sentenceCaseStr = ucfirst($lowercaseStr);
    
    return $sentenceCaseStr;
}

?>