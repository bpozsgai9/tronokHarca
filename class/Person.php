<?php
class Person {

	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $dbname = "thrones";
	private $conn = NULL;

    public function __construct(){
		
		$this->conn = new mysqli(
            $this->servername, 
            $this->username, 
            $this->password, 
            $this->dbname);

		if ($this->conn->connect_error) {
    		die("Kapcsolati hiba: " . $conn->connect_error);
		} 
	}

    public function __destruct(){
		$this->conn->close();
	}

    public function getPersonDataById($id) {
        
        $sql = "SELECT * FROM person WHERE id =" . $id;
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            
            $row = $result->fetch_assoc();
            return $row;
            
        } else {
            echo "Nincs eredmény";
        }
    }
}
?>