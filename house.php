<?php

if (isset($_POST['back'])) {
    $url = "index.php";
    header("Location: $url");
}

$house = new House();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/house.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
    <div class="content">
        <form method="POST">
            <input type="submit" value="Back" name="back" id="backButton">
        </form>
        <div class="tableBorder">
            <?php $house->listHouseData(); ?>
        </div>
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
        $chanceAtWinAWar = self::chanceAtWinAWar();
        $avrageAgeGroupByHouse = self::getAverageAgeGroupByHouse();
        $avrageAgeUnder18GroupByHouse = self::getAverageAgeUnder18GroupByHouse();

        echo "<table>";
        echo "<tr>";
        echo "<td>Name:</td>";
        echo "<td></td>";
        echo "<td>Symbol:</td>";
        echo "<td>Number Of Soldiers:</td>";
        echo "<td>Average Age In House:</td>";
        echo "<td>Persent Of Underage Persons:</td>";
        echo "<td style='vertical-align: top; border-top: 3px solid black;'>Chance To Win War:</td>";
        echo "</tr>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
                echo "<tr>";
                    echo "<td class='title'>" . $row['name'] . "</td>";
                    echo "<td><img src='img/" . $row['picture'] . "' alt='house_pic' title='house_pic'></td>";
                    echo "<td>" . $row['symbol'] . "</td>";
                    echo "<td>" . $row['number_of_soldiers'] . "</td>";
                    echo "<td>" . round($avrageAgeGroupByHouse[$row['name']]) . "</td>";
                    echo "<td>" . round($avrageAgeUnder18GroupByHouse[$row['name']]) . "%</td>";
                    echo "<td style='
                        border-top: 3px solid black; 
                        vertical-align: top;'>";
                    echo "<div style=
                        'height:". round($chanceAtWinAWar[$row['name']]) * 10 ."px; 
                        background-color: #D9C541;
                        color: black'>" . $chanceAtWinAWar[$row['name']] . "%</div>";
                    echo "</td>";
                echo "</tr>";
                
            }
        } else {
            echo "0 results";
        }
        echo "</table>";
    }

    public static function listEnemiesById($id) {

        $sql = "SELECT `name` AS enemy_house_name
                    FROM house
                    WHERE `id`IN (SELECT `with_who_ House_id` 
                        FROM `fights_with` 
                        WHERE who_House_id = $id)";
        
        $result = $this->conn->query($sql);
            
        $array = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($array, $row['enemy_house_name']);
            }
        } else {
            array_push($array, "Unknown");
            return $array;
        }
        return $array;
    }

    public function chanceAtWinAWar() {

        $sql = "SELECT 
            `name`, 
            (number_of_soldiers / (SELECT SUM(number_of_soldiers) FROM house) * 100) AS percent 
            FROM house 
            GROUP BY id";

            $result = $this->conn->query($sql);

            $array = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {

                    $array += array($row["name"] => $row["percent"]);
                }
            } else {
                echo "0 results";
            }
            return $array;
        
    }

    public function FunctionName(Type $var = null)
    {
        # code...
    }

    function getAverageAgeGroupByHouse() {
        
        $sql = "SELECT house.name AS house_name,
                    SUM(person.age) / COUNT(person.age) AS average_age_in_house
                FROM person, house, member_of_house
                WHERE 
                    person.id = member_of_house.Person_id AND
                    member_of_house.House_id = house.id
                GROUP BY house.name";

        $result = $this->conn->query($sql);

        $array = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {

                $array += array($row["house_name"] => $row["average_age_in_house"]);
            }
        } else {
            echo "0 results";
        }
        return $array;
    }

    function getAverageAgeUnder18GroupByHouse() {

        $sql = "SELECT house.name AS house_name,
                    SUM(person.age) / COUNT(person.age < 18) AS rate_of_underage_persons_in_family
                FROM person, house, member_of_house
                WHERE 
                    person.id = member_of_house.Person_id AND
                    member_of_house.House_id = house.id
                GROUP BY house.name";

        $result = $this->conn->query($sql);

        $array = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {

                $array += array($row["house_name"] => $row["rate_of_underage_persons_in_family"]);
            }
        } else {
            echo "0 results";
        }
        return $array;
    }
}
?>

