<?php
require_once('header.php');
$lastSearch = "";
if(array_key_exists("searchValue",$_GET)) {
    $lastSearch = $_GET["searchValue"];
}
echo '<div class="md-form mt-2 mb-2 ml-2 mr-2">
<form method="get" action="AnimalSearch.php">
    <label for="shelter_home_search">Shelter</label>
    <input type="text" id="shelter_home_search" class="form-control mb-2" id="txtSearch" name="searchValue" class="searchInput" value="' . $lastSearch . '"/>
    <input type="submit" id="btnSubmit" name="btnSubmit" value="Search" />
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
$sql = "";
$count = "";
if(!array_key_exists("searchValue",$_GET) || $_GET["searchValue"] == "") {
    $sql = "SELECT * FROM animal left join animal_management on shelter_home = management_id";
    $count = "SELECT COUNT(*) FROM animal left join animal_management on shelter_home = management_id";
}
else {
    $sql = "SELECT * FROM animal left join animal_management on shelter_home = management_id where name like '%$_GET[searchValue]%';";
    $count = "SELECT COUNT(*) FROM animal left join animal_management on shelter_home = management_id where name like '%$_GET[searchValue]%';";
}
if($res = $connec->query($count)){
    if ($res->fetchColumn() > 0) {
        echo "<div class='m-2'><table class='table'>";
            echo "<tr>";
                echo "<th>animal_id</th>";
                echo "<th>animal_type</th>";
                echo "<th>Shelter</th>";
            echo "</tr>";
        foreach ($connec->query($sql) as $row) {
            echo "<tr>";
                echo "<td>" . $row['animal_id'] . "</td>";
                echo "<td>" . $row['animal_type'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
            echo "</tr>";
        }
        echo "</table></div>";
    } else{
        echo "<div class='m-2'>" . "No records matching your query for '$_GET[searchValue]'." . "</div>";
    }
} else{
    echo "<div class='m-2'>No rows matched query</div>";
}
$res = null;
$connec = null;
?>