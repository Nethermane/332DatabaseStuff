<?php
require_once('header.php');
echo '<div class="md-form mt-2 mb-2 ml-2 mr-2">
<form method="get" action="Adopt.php">
    <label for="animal_id">Animal ID</label>
    <input type="text" id="animal_id" class="form-control mb-2" name="animal_id" class="searchInput" value=""/>
    <label for="lastName">Last name</label>
    <input type="text" id="lastName" class="form-control mb-2" name="last_name" class="searchInput" value="Donaldson"/>
    <label for="phoneNum">Phone number</label>
    <input type="text" id="phoneNum" class="form-control mb-2" name="phone_number" class="searchInput" value="5196197713"/>
    <label for="paid">Paid($)</label>
    <input type="text" id="paid" class="form-control mb-2" name="paid" class="searchInput" value="100"/>
    <input type="submit" id="btnSubmit" name="btnSubmit" value="Adopt" />
</form>
</div>';
?>
<?php
if(isset($_GET['btnSubmit'])) {
    try {
        $dbhost = 'localhost';
        $dbname='animal_rescue_application';
        $dbuser = 'root';
        $dbpass = '';
        $connec = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    } catch (PDOException $e) {
        echo "Error : " . $e->getMessage() . "<br/>";
        die();
    }
    if(isset($_GET['animal_id']) && isset($_GET['last_name']) && isset($_GET['phone_number']) && isset($_GET['paid'])) {
        $sql = "INSERT INTO adoption(animal_id,amount,last_name,phone_number) VALUES('" . $_GET['animal_id'] . "','" . $_GET['paid'] . "','" . $_GET['last_name'] . "','" . $_GET['phone_number'] . "');";
        try {
            $connec->prepare($sql)->execute();
        } catch (PDOException $e) {
            echo"<p>Invalid parameter " . $e . "</p>";
        }
    } else {
        echo"<p>Missing parameter</p>";
    }
    
    $connec = null;
}
try {
    $dbhost = 'localhost';
    $dbname='animal_rescue_application';
    $dbuser = 'root';
    $dbpass = '';
    $connec = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
} catch (PDOException $e) {
    echo "Error : " . $e->getMessage() . "<br/>";
    die();
}
$sql = "SELECT animal_id, animal_type FROM animal where not exists (select animal_id from adoption where adoption.animal_id = animal.animal_id)";
$count = "SELECT * FROM animal where not exists (select animal_id from adoption where adoption.animal_id = animal.animal_id)";

if($res = $connec->query($count)){	
    if ($res->fetchColumn() > 0) {
        echo "<div class='m-2'><table class='table'>";
        echo "<tr>";
            echo "<th>Animal ID</th>";
            echo "<th>Animal Type</th>";
        echo "</tr>";
        foreach ($connec->query($sql) as $row) {
            echo "<tr>";
                echo "<td>" . $row['animal_id'] . "</td>";
                echo "<td>" . $row['animal_type'] . "</td>";
            echo "</tr>";
        }
        echo "</table></div>";
    } else{
        echo "<div class='m-2'>" . "All animals are adopted :)" . "</div>";
    }
} else{
    echo "<div class='m-2'>All animals are adopted :)</div>";
}
$res = null;
$connec = null;
?>