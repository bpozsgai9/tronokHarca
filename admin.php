<?php

if (isset($_POST["details"])) {
    
    $userId = $_POST['detailsId'];
    $url = "person.php?userId=$userId";
    header("Location: $url");

}
if (isset($_POST["modify"])) {
    echo "aaaaa";
} else {
    echo "Hiba!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="title">
        <h1>Game Of Thrones</h1>
    </div>
    <div class="content">
        <?php
            $admin = new Admin();
            $admin->listPersonData();
        ?>
    </div>
</body>
</html>

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

    public function listPersonData() {
        
        $sql = "SELECT * FROM person";
        $result = $this->conn->query($sql);

        echo "<table>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
                echo "<tr><td>";
                    echo "<div class='person'>";
                        echo "<form method='POST' action='". $_SERVER['PHP_SELF'] ."'>";
                            echo "<img src='img/" . $row["picture"]. "'>";
                            echo "<input type='text' name='name' value='" . $row["name"] . "'>";
                            echo "<input type='number' name='age' value='" .  $row["age"] . "'>";
                            echo "<input type='text' name='title' value='" . $row["title"]. "'>";
                            echo "<input type='text' name='House_name' value='" . $row["House_name"]. "'>";
                            echo "<input type='hidden' name='modifyId' value='" . $row['id'] ."'>";
                            echo "<input type='submit' value='Modify' name='modify' id='modifyButton'>";
                        echo "</form>";
                        echo "<form method='POST' action='". $_SERVER['PHP_SELF'] ."'>";
                            echo "<input type='hidden' name='detailsId' value='" . $row['id'] ."'>";
                            echo "<input type='submit' value='Details' name='details' id='detailsButton'>";
                        echo "</form>";
                    echo "</div>";
                echo "</td></tr>";
            }
        } else {
            echo "0 results";
        }
        echo "</table>";        
    }
}



?>