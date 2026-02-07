<?php
$article = 'monture';
$prix = 15;
$devise = '$'; 


/*$fruits = ["pomme", "orange", "mangue", "banane", "raisin"]; 

$cotes = [7,8,5,10,9,4];

$moyenne = [
    30=>5, 
    "Eric" => 4.5, 
    "John" => 7.2, 
    "Mike" => 8.4, 
    "Ruth" => 9.0, 
    "Julie" => 5.5, 
    3 => 56, 
    56
    
]; 

echo '<pre>';
var_dump($moyenne);
echo '</pre>';*/

$articles_names = [
    "bracelet", 
    "montre", 
    "cable usb",
    "Ecouteurs", 
    "Carnets"
]; 
$articles_prix = [
"bracelet" =>5000, 
"montre" => 13000, 
"cable usb" =>7500,
"Ecouteurs" =>25000, 
"Carnets" =>2500
]; 

$total = 0; 
foreach ($articles_prix as $price)
{
    $total = $total + $price;
}