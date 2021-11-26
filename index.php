<?php
$admin = new Admin();

if (isset($_POST["details"])) {
    header("Location: person.php");
}

if (isset($_POST["houseButton"])) {
    
    $url = "house.php";
    header("Location: $url");
}

if (isset($_POST["modify"])) {
    
    $admin->modifyPerson(
        $_POST['modifyId'], 
        $_POST['modifyName'], 
        $_POST['modifyAge'], 
        $_POST['modifyTitle']
    );
}

if (isset($_POST["delete"])) {

    $admin->deletePerson($_POST['deleteId']);
}

if (isset($_POST["create"]) && !empty($_FILES["fileToUpload"]["name"])) {
    
    $admin->insertPerson(
        $_POST['name'], 
        $_POST['age'], 
        $_POST['title'], 
        $_FILES["fileToUpload"]["name"]
    );
    $admin->uploadFile();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="title">
        Game Of Thrones
        <form method="post">
            <img src="img/tree.png" id="tree">
            <input type="submit" name="houseButton" value="Houses" id="houseButton">
        </form>
    </div>
    <div class="content">
        <table>
            <div class="newPerson">New Person:</div>
            <tr>
                <form method='POST' action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                <td>
                    <input type="file" name="fileToUpload" id="fileToUpload" required>
                </td>
                <td>
                    <input type='text' name='name' value='' placeholder='Name' required>
                    <input type='number' name='age' value='' placeholder='Age' required>
                    <input type='text' name='title' value='' placeholder='Title' required>
                </td>
                <td>
                    <input type='submit' value='Create' name='create' id='createButton'>
                </td>
                </form>
            </tr>
        </table>
        <br />
        <?php
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
                
                echo "<tr>";
                    echo "<td>";
                        echo "<img src='img/" . $row["picture"] . "'>";
                    echo "</td>";
                    echo "<td>";
                        echo "<form method='POST' action='". $_SERVER['PHP_SELF'] ."'>";
                            echo "<input type='text' name='modifyName' value='" . $row["name"] . "'>";
                            echo "<input type='number' name='modifyAge' value='" .  $row["age"] . "'>";
                            echo "<input type='text' name='modifyTitle' value='" . $row["title"]. "'>";
                            echo "<input type='hidden' name='modifyId' value='" . $row['id'] ."'>";
                            echo "<input type='submit' value='Modify' name='modify' id='modifyButton'>";
                        echo "</form>";
                    echo "</td>";
                    echo "<td>";
                        echo "<form method='POST' action='person.php'>";
                            echo "<input type='hidden' name='detailsId' value='" . $row['id'] ."'>";
                            echo "<input type='hidden' name='detailsName' value='" . $row['name'] ."'>";
                            echo "<input type='hidden' name='detailsAge' value='" . $row['age'] ."'>";
                            echo "<input type='hidden' name='detailsTitle' value='" . $row['title'] ."'>";
                            echo "<input type='hidden' name='detailsPic' value='" . $row["picture"] ."'>";
                            echo "<input type='submit' value='Details' name='details' id='detailsButton'>";
                        echo "</form>";
                    echo "</td>";
                    echo "<td>";
                        echo "<form method='POST' action='". $_SERVER['PHP_SELF'] ."'>";
                            echo "<input type='hidden' name='deleteId' value='" . $row['id'] ."'>";
                            echo "<input type='submit' value='Delete' name='delete' id='deleteButton'>";
                        echo "</form>";
                    echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }
        echo "</table>";        
    }

    public function uploadFile() {

        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

        if ($check !== false) {
                
            $uploadOk = 1;

        } else {
                
            echo "Hiba: A fájl nem kép! ";
            $uploadOk = 0;
        }
    
        if ($uploadOk == 0) {
        
            echo "Hiba: A fájl nem lett feltöltve!";
    
        } else {
        
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

                echo "<div style='z-index: -1'>" . basename( $_FILES["fileToUpload"]["name"]) . " fel lett töltve! Köszönjük a képet!</div>";

            } else {
                
                echo "Hiba: Feltöltés közben hiba lépett fel!";
            }
        }
    }

    public function insertPerson($name, $age, $title, $picture="unknown.PNG") {
        
        $sql = "INSERT INTO person (`name`, `age`, `title`, `picture`)
        VALUES 
            ('" . $name . "', " . 
                $age. ", '" . 
                $title . "', '" . 
                $picture . "')";

        if ($this->conn->query($sql) === TRUE) {

            
            echo "New record created successfully";
        } else {

            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function deletePerson($id) {
        
        $sql = "DELETE FROM person WHERE id = $id";

        if ($this->conn->query($sql) === TRUE) {

            echo "Record deleted successfully";

        } else {

            echo "Error deleting record: " . $this->conn->error;
        }
    }

    public function modifyPerson($id, $name, $age, $title) {

        $sql = "UPDATE person SET 
            `name` = '". $name ."', 
            `age` = '". $age ."', 
            `title` = '". $title ."'
            WHERE id = " . $id;

        if ($this->conn->query($sql) === TRUE) {

            echo "Record updated successfully";

        } else {

            echo "Error updating record: " . $this->conn->error;
        }
    }
}
?>