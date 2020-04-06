<?php
require_once('header.php');
?>
<?php
$refill_fields = False;
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

    if(isset($_GET['animal_id']) && isset($_GET['last_name']) && isset($_GET['phone_number'])) {
        $id = $_GET['animal_id'];
        $last_name = $_GET['last_name'];
        $phone_number = $_GET['phone_number'];
        if(empty($id) || empty($last_name) || empty($phone_number)) {
            echo"<p style='color: red'>Missing parameter</p>";
        } else {
            $sql = "";
            if(isset($_GET['paid']) && !empty($_GET['paid'])) {
                $sql = "INSERT INTO adoption(animal_id,amount,last_name,phone_number) VALUES('" . $_GET['animal_id'] . "','" . $_GET['paid'] . "','" . $_GET['last_name'] . "','" . $_GET['phone_number'] . "');";
            } else {
                $sql = "INSERT INTO adoption(animal_id,amount,last_name,phone_number) VALUES('" . $_GET['animal_id'] . "','0','" . $_GET['last_name'] . "','" . $_GET['phone_number'] . "');";
            }
            if(!is_numeric($_GET['paid'])) {
                echo "<p style='color: red'>Paid must be a number (No other characters except .)</p>";
            } else if ($_GET['paid'] < 0) {
                echo "<p style='color: red'>Paid must be a positive</p>";
            } else {
                try {
                    if(!$connec->prepare($sql)->execute()) {
                        echo"<p style='color: red'>Invalid Animal ID or family not in system</p>";
                        $refill_fields = True;
                    } else {
                        echo"<p style='color: green'>Sucessfully adopted animal no." . $id . "</p>";
                    }
                } catch (PDOException $e) {
                    echo"<p style='color: red'>Invalid parameter " . $e . "</p>";
                }
                }
        }
    } else {
        echo"<p style='color: red'>Missing parameter</p>";
    }
    
    $connec = null;
}
?>
<?php
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
    $sql = "SELECT animal_id FROM animal where not exists (select animal_id from adoption where adoption.animal_id = animal.animal_id)";
    $family = "SELECT last_name, phone_number FROM family";
    echo '<div class="md-form mt-2 mb-2 ml-2 mr-2">
    <form method="get" action="Adopt.php">
        <label for="animal_id">Animal ID</label>
        <select type="text" id="animal_id" class="form-control mb-2" name="animal_id" class="searchInput">
        ';
        foreach ($connec->query($sql) as $row) {
            echo "<option value='". $row['animal_id'] . "'>" . $row['animal_id'] . "</option>";
        }
        echo '</select>
        <label for="lastName">Last name</label>
        <select type="text" id="lastName" class="form-control mb-2" name="last_name" class="searchInput" onchange="setIndex()">
        ';
        foreach ($connec->query($family) as $row) {
            echo "<option value='". $row['last_name'] . "'>" . $row['last_name'] . "</option>";
        }
        echo '</select>
        <label for="phoneNum">Phone number</label>
        <select readonly type="text" id="phoneNum" class="form-control mb-2" name="phone_number" class="searchInput"/>
        ';
        foreach ($connec->query($family) as $row) {
            echo "<option value='". $row['phone_number'] . "'>" . $row['phone_number'] . "</option>";
        }
        echo '</select>
        <label for="paid">Paid($)</label>
        <input type="text" id="paid" class="form-control mb-2" name="paid" class="searchInput" placeholder="100" value=""/>
        <input type="submit" id="btnSubmit" name="btnSubmit" value="Adopt" />
        </form>
        </div>';
?>
<?php
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
<script> 
function setIndex() {
    var index = document.getElementById("lastName").selectedIndex;
    document.getElementById("phoneNum").selectedIndex = index;
}
</script> 