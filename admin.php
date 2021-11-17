<?php
$admin = new Admin();

if (isset($_POST["details"])) {
    
    $userId = $_POST['detailsId'];
    $url = "person.php?userId=$userId";
    header("Location: $url");

}
if (isset($_POST["modify"])) {
    echo "aaaaa";
}

if (isset($_POST["create"])) {
    $admin->insertPerson(
        $_POST['name'], 
        $_POST['age'], 
        $_POST['title'], 
        $_POST['House_name']
    );
}

if (isset($_POST["familyTree"])) {
    $url = "familyTree.php";
    header("Location: $url");
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
        <form method="post">
            <input type="submit" name="familyTree" value="Family Tree" id="treeButton">
        </form>
    </div>
    <div class="content">
        <div class='person'>
            <!---<form method="POST"  action="<?php echo $_SERVER['PHP_SELF']; ?>"enctype="multipart/form-data">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" value="Feltölt" name="submit"><br>
                </form>-->
                <?php/*
                    

                    //bef
                    if (!empty($_POST["submit"]) && isset($_POST["submit"])) {
    
                        $admin->uploadFile();
                    }*/
                ?>
            <form method='POST' action=<?php $_SERVER['PHP_SELF'] ?>>
                New Person:
                <img src=''>
                <input type='text' name='name' value='' placeholder='Name'>
                <input type='number' name='age' value='' placeholder='Age'>
                <input type='text' name='title' value='' placeholder='Title'>
                <input type='text' name='House_name' value='' placeholder='House Name'>
                <input type='submit' value='Create' name='create' id='createButton'>
            </form>
        </div>
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

    public function uploadFile() {

        $target_dir = "img/upload/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);    
        if($check !== false) {
                
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

    public function insertPerson($name, $age, $title, $House_name, $picture="unknown.PNG") {
        
        $sql = "INSERT INTO person (name, age, title, House_name, picture) 
        VALUES ($name, $age, $title, $House_name, $picture)";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}



?>