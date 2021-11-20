<?php
if (isset($_POST['back'])) {
    $url = "admin.php";
    header("Location: $url");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/person.css">
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
                <img src="<?php echo "img/" . $personData["person_picture"] ?>" alt="Avatar">
            </div>
            <div class="flex-item">
                <div class="inline">
                    <div><?php echo $personData["person_name"] ?></div>
                    <img src="<?php echo "img/" . $personData["house_picture"] ?>" id="house_picture">
                </div>
                    <?php 

                    /*
                    person.name AS person_name, 
                        person.age AS person_age, 
                        person.title AS person_title, 
                        person.picture AS person_picture, 
                        house.name AS house_name, 
                        house.symbol AS house_symbol, 
                        house.picture AS house_picture
                    
                    */

                        echo "<dl>";
                            echo "<dt>Age:</dt>";
                            echo "<dd>" . $personData["person_age"] .  "</dd>";
                            echo "<dt>Title:</dt>";
                            echo "<dd>" . $personData["person_title"] .  "</dd>";
                            echo "<dt>House name:</dt>";
                            echo "<dd>" . $personData["house_name"] .  "</dd>";
                        echo "</dl>";
                    ?>
                <form method="POST">
                    <input type="submit" value="Back" name="back">
                </form>
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
        
        $sql = "SELECT 
            person.name AS person_name, 
            person.age AS person_age, 
            person.title AS person_title, 
            person.picture AS person_picture, 
            house.name AS house_name, 
            house.symbol AS house_symbol, 
            house.picture AS house_picture
                FROM person, house , member_of_house
                WHERE 
                    person.id = member_of_house.Person_id AND
                    member_of_house.House_id = house.id AND
                    person.id =" . $id;
        
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