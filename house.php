<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/house.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="content">
    <?php
        $house = new House();
        $house->listHouseData();
    ?>
    </div>
    <script>
        function transposeTable() {
            $("table").each(function() {
                var $this = $(this);
                var newrows = [];
                $this.find("tr").each(function(){
                    var i = 0;
                    $(this).find("td").each(function(){
                        i++;
                        if(newrows[i] === undefined) { newrows[i] = $("<tr></tr>"); }
                        newrows[i].append($(this));
                    });
                });
                $this.find("tr").remove();
                $.each(newrows, function(){
                    $this.append(this);
                });
            });
        }
        transposeTable();
    </script>
</body>
</html>

<?php
class House {

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

    public function listHouseData() {

        $sql = "SELECT * FROM house";

        $result = $this->conn->query($sql);

        echo "<table>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                    echo "<td class='title'>" . $row['name'] . "</td>";
                    echo "<td><img src='img/" . $row['picture'] . "' alt='house_pic' title='house_pic'></td>";
                    echo "<td>" . $row['symbol'] . "</td>";
                    echo "<td>" . $row['number_of_soldiers'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "0 results";
        }
        echo "</table>";
    }

}
?>

