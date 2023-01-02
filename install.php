<?php 
//Christine Johanson chjo2104  Miun Webbutveckling III - Projektuppgift 2022
include("config.php");

//anslut till databasen
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
//KOLLA om det blir fel vid anslutning, skriver ut felmess.
if($db->connect_errno > 0) {
    die("Fel vid anslutning: " . $db->connect_error);
}

//SQL QUERIES
//kasta bort tabell om den redan finns, skapa ny. separera med ,
$sql = "DROP TABLE IF EXISTS menu, booking;";

//skriv sql frågorna här
//första skapar tabell för menuer
$sql .= "
CREATE TABLE menu(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(128),
    description VARCHAR(256),
    price VARCHAR(11),
    category VARCHAR(128)    
);
    ";

//andra skapar tabell för bokning
$sql .= "
CREATE TABLE booking(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(128),
    email VARCHAR(128),
    date DATE,
    time TIME,
    persons INT(1)  
);
    ";   

//för att skriva ut sql-fråga på sidan
echo "<pre>$sql</pre>";


 //skicka sql-frågorna till server.multi betyder flera frågor.
 if($db->multi_query($sql)) {
    //om den returnerar true
    echo "Tabell(erna) är installerad!";
} else {
    //returnerar false
    echo "Fel vid installation av tabell.";
} 
?>