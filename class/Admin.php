<?php
class Admin {

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

    public function getPersonData() {
        
        $sql = "SELECT * FROM person";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
                echo "<form type='post' action=''>";
                echo "<div class='person'>";
                echo "<img src='img/" . $row["picture"]. "'>";
                echo "<input type='text' name='name' value='" . $row["name"] . "'>";
                echo "<input type='number' name='name' value='" .  $row["age"] . "'>";
                echo "<input type='text' name='name' value='" . $row["title"]. "'>";
                echo "<input type='text' name='name' value='" . $row["House.name"]. "'>";
                echo "<input type='submit' value='Details' name='details' id='detailsButton'>";
                echo "<input type='submit' value='Modify' name='modify' id='modifyButton'>";
                echo "</div>";
                echo "</form>";
            }
          } else {
            echo "0 results";
          }
    }
}
?>