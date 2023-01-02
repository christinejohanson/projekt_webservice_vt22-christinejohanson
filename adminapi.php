<?php
//Christine Johanson chjo2104  Miun Webbutveckling III - Projektuppgift 2022
?>

<?php
//konfig
include_once("config.php");

//Gör att webbtjänsten går att komma åt från alla domäner (asterisk * betyder alla)
//ÄNDRA till studenter.miun.se när det är uppladdat. annars kan det bli spam på gång!
header('Access-Control-Allow-Origin: *');

//Talar om att webbtjänsten skickar data i JSON-format
header('Content-Type: application/json');

//Vilka metoder som webbtjänsten accepterar, som standard tillåts bara GET.
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

//Vilka headers som är tillåtna vid anrop från klient-sidan, kan bli problem med CORS (Cross-Origin Resource Sharing) utan denna.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


//lagrar metod i variabel
$method = $_SERVER['REQUEST_METHOD'];

//kontrollera så att det är post som blivit skickad
if($method != "POST") {
    http_response_code(405); //Method not allowed
    $response = array("message" => "Endast POST får skickas");
    echo json_encode($response);
    exit;
}

//Omvandlar body från JSON
$data = json_decode(file_get_contents("php://input"), true);

//Kolla så usernam och password skickats med
if(isset($data["usernam"]) && isset($data["password"])) {
    //de läggs i nya variabler
    $usernam = $data["usernam"];
    $password = $data["password"];
} else {
    http_response_code(400); //Bad request
    $response = array("message" => "Skicka med användarnamn och lösenord");
    echo json_encode($response);
    exit;
}

//Kontrollerar att användarnamn och lösenord är giltiga. Hårdkodat.
if($usernam === "usernam" && $password === "password") {
    $response = array("message" => "Inloggad", "user" => true);
    http_response_code(200); //Ok
} else {
    $response = array("message" => "Felaktigt användarnamn eller lösenord");
    http_response_code(401); //Unauthorized
}

//Skickar svar tillbaka till avsändaren
echo json_encode($response);