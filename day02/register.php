<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Thanks ";
if ($_POST['gender'] == 'male') {
    echo "Mr: ";
} else {
    echo "Mrs: ";
}
echo $_POST['fname'] . " " . $_POST['lname'] . "</h1>";
echo "<h3>Please Review Your Info</h3> <br/>";

echo "<h4>Name: " . $_POST['fname'] . " " . $_POST['lname'] . "</h4>";
echo "<h4>Address: " . $_POST['address'] . "</h4>";
echo "<h4>Your Skills: ";
foreach ($_POST['skills'] as $value) {
    echo $value . "<br>";
}
echo "</h4><h4>Department: ";
echo $_POST['dept'] . "</h4>";
