<?php

//Creating a random password
function generateRandomPassword($length = 10) 
{
    // Define a list of characters to use in the password
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=';
    $characterCount = strlen($characters);

    // Generate a random password
    $password = '';
    for ($i = 0; $i < $length; $i++) 
    {
        $index = rand(0, $characterCount - 1);
        $password .= $characters[$index];
    }
    return $password;
}

?>