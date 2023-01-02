<?php
//Christine Johanson chjo2104  Miun Webbutveckling III - Projektuppgift 2022

class Booking
{
    //properties
    private $db;
    private $id;
    private $name;
    private $email;
    private $date;
    private $time;
    private $persons;

    //1. construct med db-connection
    function __construct()
    {
        //anslutning till db. sluta köra resten av kod om fel.
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connecting: " . $this->db->connect_error);
        }
    }

    //2. hämta bokning
    public function getBooking()
    {
        //sql frågan
        $sql = "SELECT * FROM booking ORDER BY date;";
        //lagras i var result.skickar med db anslutning. o sql fråga 
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //3. setmetod bokning
    public function setBooking($name, $email, $date, $time, $persons): bool
    {
        if ($name != "" && $email != "" && $date != "" && $time != "" && $persons != "") {
            
             //html strip tags för att ta bort html kod
             $name = strip_tags($name);
             $email = strip_tags($email);
             $date = strip_tags($date);
             $time = strip_tags($time);
             $persons = strip_tags($persons);
            
            $this->name = $name;
            $this->email = $email;
            $this->date = $date;
            $this->time = $time;
            $this->persons = $persons;
            return true;
        } else {
            return false;
        }
    }

    //4. lägga till bokning
    public function createBooking($name, $email, $date, $time, $persons): bool
    {
        //kontrollera med setbokning
        if (!$this->setBooking($name, $email, $date, $time, $persons)) return false;

        //sanitera inmatningen innan sql-frågan
        $name = $this->db->real_escape_string($name);
        $email = $this->db->real_escape_string($email);
        $date = $this->db->real_escape_string($date);
        $time = $this->db->real_escape_string($time);
        $persons = $this->db->real_escape_string($persons);

        //sql-frågan
        $sql = "INSERT INTO booking(name, email, date, time, persons)VALUES
            ('" . $this->name . "', '" . $this->email . "', '" . $this->date . "', '" . $this->time . "', '" . $this->persons . "');";
        return mysqli_query($this->db, $sql);
    }

    //5. setbokning med id 
    public function setBookingById(int $id, string $name, string $email, string $date, string $time, string $persons): bool
    {
        if ($id != "" && $name != "" && $email != "" && $date != "" && $time != "" && $persons != "") {
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->date = $date;
            $this->time = $time;
            $this->persons = $persons;
            return true;
        } else {
            return false;
        }
    }

    //6. uppdatera bokning.
    public function updateBooking(): bool
    {
        //SQL query. SET vilka fält som ska uppdateras. WHERE vilken som ska uppdateras. 
        $sql = "UPDATE booking SET name='" . $this->name . "', email= '" . $this->email . "', date= '" .
            $this->date . "', time='" . $this->time . "', persons='" . $this->persons . "' WHERE id=$this->id;";
        //send query
        return mysqli_query($this->db, $sql);
    }

    //7. radera bokning
    public function deleteBooking($id): bool
    {
        //läser in id och konverterar till intvärde(heltal) om det inte redan blivit gjort
        $id = intval($id);
        //sql query
        $sql = "DELETE FROM booking WHERE id=$id;";
        //skicka query
        return mysqli_query($this->db, $sql);
    }

    //8. hämta bokning med specifikt id 
    public function getBookingById($id): array
    {
        //lägger i id för att få en intval
        $id = intval($id);
        //läsa ut en post
        $sql = "SELECT * FROM booking WHERE id=$id;";
        //frågan sparas i variablen result
        $result = mysqli_query($this->db, $sql);
        //läsa ut som en specifik rad
        return $result->fetch_assoc();
    }

    //destruktor som stänger anslutningen
    function __destruct()
    {
        mysqli_close($this->db);
    }
}
