<?php
    include "class/Person.php";
    $person = new Person();
    $personData = $person->getPersonDataById(1);
    /*INSERT INTO `person`( `name`, `age`, `title`, `House.name`, `picture`)
            VALUES ('Jamie', 44, 'first-born', 'Lannister', 'jamie.PNG')*/
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
                            " House name: " . $personData["House.name"];
                    ?>
                </p>
                <input type="submit" value="Back" name="back">
            </div>
        </div> 
 
    </div>
</body>
</html>