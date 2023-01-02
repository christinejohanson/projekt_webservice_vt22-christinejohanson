<?php
//Christine Johanson chjo2104  Miun Webbutveckling III - Projektuppgift 2022

//inkluderar configfilen
include_once("config.php");
/*Headers med inställningar för REST webbtjänst*/

//Gör att webbtjänsten går att komma åt från alla domäner (asterisk * betyder alla)
//ÄNDRA till studenter.miun.se när det är uppladdat. annars kan det bli spam på gång!
header('Access-Control-Allow-Origin: *');

//Talar om att webbtjänsten skickar data i JSON-format
header('Content-Type: application/json');

//Vilka metoder som webbtjänsten accepterar, som standard tillåts bara GET.
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

//Vilka headers som är tillåtna vid anrop från klient-sidan, kan bli problem med CORS (Cross-Origin Resource Sharing) utan denna.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//Läser in vilken metod som skickats och lagrar i en variabel
$method = $_SERVER['REQUEST_METHOD'];

//Om en parameter av id finns i urlen lagras det i en variabel
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$booking = new Booking();

//kollat vilken metod som blivit skickad.(get post put eller delete)
switch ($method) {
    //hämta info
    case 'GET':
        //kolla om något id är medskickat o hämta bara in kursen med det id´t
        if(isset($id)) {
            $response = $booking->getBookingById($id);
        } else { 
            //variabel för svar. om id inte skickat med så anropas getBooking
            $response = $booking->getBooking();}
       
        //se om det finns nåt i restwebbtjänsten
        if (count($response) === 0) {
            //om det är lika med 0
            $response = array("message" => "Det finns ju inget att visa däri");
            http_response_code(404); //not found
        } else {
            //Skickar en "HTTP response status code"
            http_response_code(200); //Ok - The request has succeeded
        }
        break;
    
     //lägga till i db   
    case 'POST':
        //Läser in JSON-data skickad med anropet och omvandlar till ett objekt.görs om från json
        //till php som en associativ array
        $data = json_decode(file_get_contents("php://input"), true);
        if ($booking->setBooking($data["name"], $data["email"], $data["date"], $data["time"], $data["persons"])) {

            //skapa ny bokning          
            if ($booking->createBooking($data["name"], $data["email"], $data["date"], $data["time"], $data["persons"])) {

                $response = array("message" => "En bokning har blivit tillagd");
                http_response_code(201); //Created
            } else {
                $response = array("message" => "Fel vid lagring av bokning");
                http_response_code(500); //internal server error
            }
        } else {
            //inmatning ej korrekt
            $response = array("message" => "Du måste fylla i alla uppgifter");
            http_response_code(400); // bad request
        }
        break;

    //uppdatera
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true); 
        if ($booking->setBookingById($data["id"], $data["name"], $data["email"], $data["date"], $data["time"], $data["persons"])) {

            //uppdatera en meny med id menu          
            if ($booking->updateBooking()) {

                $response = array("message" => "Bokning har blivit uppdaterad");
                http_response_code(200); //Ok
            } else {
                $response = array("message" => "Fel vid uppdatering av menu");
                http_response_code(500); //internal server error
            }
        } else {
            //inmatning ej korrekt
            $response = array("message" => "Du måste fylla i alla uppgifter");
            http_response_code(400); // bad request
        }
        break;

    //radera poster    
    case 'DELETE':
        if (!isset($id)) {
            //om det inte är nå id
            http_response_code(400);
            $response = array("message" => "Skicka med ett id för radera bokning");
        } else {
           if($booking->deleteBooking($id)) {
            http_response_code(200); //Ok
            $response = array("message" => "Bokningen är nu raderad");
           }
        }
        break;
}

//Skickar svar tillbaka till avsändaren i jsonformat
echo json_encode($response);
?>