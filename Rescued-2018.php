<?php
require_once('header.php');
$startDate = "";
$endDate= "";
if(array_key_exists("searchFirstValue",$_GET) && array_key_exists("searchSecondValue",$_GET) ) {
    $startDate = $_GET["searchFirstValue"];
    $endDate = $_GET["searchSecondValue"];
}
echo '<div class="md-form mt-2 mb-2 ml-2 mr-2">
<form method="get" action="Rescued-2018.php">
    <label for ="shelter_home_search"> Find out how many animals were rescued by organizations between desired dates:</label><br>
    <label for="shelter_home_search">Start Date (YYYY/MM/DD)</label>
    <input type="text" id="shelter_home_search" class="form-control mb-2" id="txtSearch" name="searchFirstValue" class="searchInput" value="' . $startDate . '"/>
    <label for="shelter_home_search">End Date (YYYY/MM/DD)</label>
    <input type="text" id="shelter_home_search" class="form-control mb-2" id="txtSearch" name="searchSecondValue" class="searchInput" value="' . $endDate . '"/>
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


$endDate= date('Y-m-d', strtotime($endDate. ' + 1 days'));
$sql= "SELECT COUNT(animal_id) as Total_Rescued FROM `driver_trip` WHERE transport_date BETWEEN '$startDate' and '$endDate'";
$count = "SELECT COUNT(*) as Total_Rescued FROM `driver_trip` WHERE transport_date BETWEEN '$startDate' and '$endDate'";


if($res = $connec->query($count)){  
    if ($res->fetchColumn() > 0) {
        echo "<div class='m-2'><table class='table'>";
            echo "<tr>";
                echo "<th>Total_Rescued</th>";
            echo "</tr>";
        foreach ($connec->query($sql) as $row) {
            echo "<tr>";
                echo "<td>" . $row['Total_Rescued'] . "</td>";
            echo "</tr>";
        }
        echo "</table></div>";
    } else{
        echo "<div class='m-2'>" . "No animals rescued between entered dates" . "</div>";
    }
} else{
    echo "<div class='m-2'>No rows matched query</div>";
}

?>