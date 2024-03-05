<?php
function validateName($name){
    return preg_match('/^[a-zA-Z\s]{4,35}$/', $name) && strlen($name) >= 4 && strlen($name) <= 35;
}

function validatePassword($pass){
    return preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*()-_+=])(?=.*\d).{8,16}$/',$pass);
}
function validatePhoneNumber($phoneNumber) {
    // Regular expression pattern for validating phone number
    $pattern = '/^01[0-9]{9}$/';

    // Perform the match
    return preg_match($pattern, $phoneNumber);
}
?>
