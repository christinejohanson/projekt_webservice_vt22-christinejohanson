<?php
//Christine Johanson chjo2104  Miun Webbutveckling III - Projektuppgift 2022

class Menu
{
    //properties
    private $db;
    private $id;
    private $name;
    private $description;
    private $price;
    private $category;

    //1. construct med db-connection
    function __construct()
    {
        //anslutning till db. sluta köra resten av kod om fel.
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error connecting: " . $this->db->connect_error);
        }
    }

    //2. hämta menu
    public function getMenu()
    {
        //sql frågan
        $sql = "SELECT * FROM menu;";
        //lagras i var result.skickar med db anslutning. o sql fråga 
        $result = mysqli_query($this->db, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //3. setmetod menu
    public function setMenu($name, $description, $price, $category): bool
    {
        if ($name != "" && $description != "" && $price != "" && $category != "") {

            //html strip tags för att ta bort html kod
            $name = strip_tags($name);
            $description = strip_tags($description);
            $price = strip_tags($price);
            $category = strip_tags($category);

            $this->name = $name;
            $this->description = $description;
            $this->price = $price;
            $this->category = $category;

            return true;
        } else {
            return false;
        }
    }

    //4. lägga till menu
    public function createMenu($name, $description, $price, $category): bool
    {
        //kontrollera med setmenu
        if (!$this->setMenu($name, $description, $price, $category)) return false;

        //sanitera inmatningen innan sql-frågan
        $name = $this->db->real_escape_string($name);
        $description = $this->db->real_escape_string($description);
        $price = $this->db->real_escape_string($price);
        $category = $this->db->real_escape_string($category);

        //sql-frågan
        $sql = "INSERT INTO menu(name, description, price, category)VALUES
            ('" . $this->name . "', '" . $this->description . "', '" . $this->price . "', '" . $this->category . "');";
        return mysqli_query($this->db, $sql);
    }

    //5. setmenu med id 
    public function setMenuById(int $id, string $name, string $description, string $price, string $category): bool
    {
        if ($id != "" && $name != "" && $description != "" && $price != "" && $category != "") {
            $this->id = $id;
            $this->name = $name;
            $this->description = $description;
            $this->price = $price;
            $this->category = $category;
            return true;
        } else {
            return false;
        }
    }

    //6. uppdatera menu 
    public function updateMenu(): bool
    {
        //SQL query. SET vilka fält som ska uppdateras. WHERE vilken som ska uppdateras. 
        $sql = "UPDATE menu SET name='" . $this->name . "', description= '" . $this->description . "', price= '" .
            $this->price . "', category='" . $this->category . "' WHERE id=$this->id;";
        //send query
        return mysqli_query($this->db, $sql);
    }

    //7. radera menu
    public function deleteMenu($id): bool
    {
        //läser in id och konverterar till intvärde(heltal) om det inte redan blivit gjort
        $id = intval($id);
        //sql query
        $sql = "DELETE FROM menu WHERE id=$id;";
        //skicka query
        return mysqli_query($this->db, $sql);
    }

    //8. hämta menu med specifikt id 
    public function getMenuById($id): array
    {
        //lägger i id för att få en intval
        $id = intval($id);
        //läsa ut en post
        $sql = "SELECT * FROM menu WHERE id=$id;";
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
