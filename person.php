<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/index.css">
    <title>Game Of Thrones</title>
</head>
<body>
    <?php
        $person = new Person();
        $personData = $person->getPersonDataById($_GET["userId"]);
    ?>
    <div class="content">
        <div class="container">
            <div class="fixed">
                <img src="<?php echo "img/" . $personData["picture"] ?>" alt="Avatar">
            </div>
            <div class="flex-item">
                <h2><?php echo $personData["name"] ?></h2>
                <p>
                    <?php 
                        echo " age: " . $personData["age"] .  "<br />" .
                            " title: " . $personData["title"] .  "<br />" .
                            " House name: " . $personData["House_name"];
                    ?>
                </p>
                <input type="submit" value="Back" name="back">
            </div>
        </div> 
    </div>
</body>
</html>

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