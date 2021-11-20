<?php
define("NUMBER_OF_CHARACTERS_IN_GOT", 38);

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
        var_dump($_POST["detailsId"]);
        if ($_POST["detailsId"] < NUMBER_OF_CHARACTERS_IN_GOT) {

            $personData = $person->getPersonDataById($_POST["detailsId"]);
            $parentArray = $person->getParentDataById($_POST["detailsId"]);

        } else {

            $personData = array(
                "person_name" => $_POST["detailsName"],
                "person_age" => $_POST["detailsAge"],
                "person_title" => $_POST["detailsTitle"],
                "person_picture" => $_POST["detailsPic"],
                "house_name" => "Unknown",
                "house_symbol" => "Unknown",
                "house_picture" => "unknown.PNG"
            );
            $parentArray= array("Unknown");

        }

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
                        echo "<dl>";
                            echo "<dt>Age:</dt>";
                            echo "<dd>" . $personData["person_age"] .  "</dd>";
                            echo "<dt>Title:</dt>";
                            echo "<dd>" . $personData["person_title"] .  "</dd>";
                            echo "<dt>House name:</dt>";
                            echo "<dd>" . $personData["house_name"] .  "</dd>";
                            echo "<dt>House symbol:</dt>";
                            echo "<dd>" . $personData["house_symbol"] .  "</dd>";
                            echo "<dt>Parent:</dt>";
                            echo "<dd>";
                            for ($i = 0; $i < count($parentArray); $i++) {
                                if ($i == count($parentArray) - 1) {
                                    echo $parentArray[$i];
                                } else {
                                    echo $parentArray[$i] . " & ";
                                }
                                
                            }
                            echo "</dd>";
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

    public function getParentDataById($id) {
        $sql = "SELECT name AS parent_name
                FROM person
                WHERE id IN (SELECT parent_Person_id
                    FROM parent
                    WHERE child_Person_id = $id)";

            $result = $this->conn->query($sql);
            
            $array = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    array_push($array, $row['parent_name']);
                }
            } else {
                array_push($array, "Unknown");
                return $array;
            }
            return $array;
    }
}
?>