<?php
require_once('header.php');
$lastSearch = "";
if(array_key_exists("searchValue",$_GET)) {
    $lastSearch = $_GET["searchValue"];
}
echo '<div class="md-form mt-2 mb-2 ml-2 mr-2">
<form method="get" action="Donated-2018.php">
    <label for="shelter_home_search">Organization</label>
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
    $sql = "SELECT * FROM `donation` INNER JOIN `organization` on donation.donate_to= organization.management_id  INNER JOIN `animal_management` on organization.management_id = animal_management.management_id where donation_date >= '2018-01-01'  AND donation_date <= '2018-12-31' 
    GROUP BY organization.management_id " ;
    $count = "SELECT COUNT(*) FROM `donation` INNER JOIN `organization` on donation.donate_to= organization.management_id  INNER JOIN `animal_management` on organization.management_id = animal_management.management_id 
        GROUP BY organization.management_id " ;
}
else {
    $sql = "SELECT * FROM donation INNER JOIN Organization on donation.donate_to= Organization.management_id  INNER JOIN animal_management on Organization.management_id= animal_management.management_id where name = '$_GET[searchValue]' AND donation_date >= '2018-01-01' 
         AND donation_date <= '2018-12-31' 
         GROUP BY management_id " ;
    $count = "SELECT COUNT(*) FROM donation INNER JOIN Organization on donation.donate_to= Organization.management_id  INNER JOIN animal_management on Organization.management_id= animal_management.management_id " ;
}

if($res = $connec->query($count)){  
    if ($res->fetchColumn() > 0) {
        echo "<div class='m-2'><table class='table'>";
            echo "<tr>";
                echo "<th>organization</th>";
                echo "<th>amount</th>";
            echo "</tr>";
        foreach ($connec->query($sql) as $row) {
            echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['amount'] . "</td>";
            echo "</tr>";
        }
        echo "</table></div>";
    } else{
        echo "<div class='m-2'>" . "No records matching your query for '$_GET[searchValue]'." . "</div>";
    }
} else{
    echo "<div class='m-2'>No rows matched query</div>";
}

?>