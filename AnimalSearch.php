<?php
require_once('header.php');
$lastSearch = "";
if(array_key_exists("searchValue",$_GET)) {
    $lastSearch = $_GET["searchValue"];
}
echo '<div class="md-form mt-2 mb-2 ml-2 mr-2">
<form method="get" action="index.php">
    <label for="shelter_home_search">Shelter</label>
    <input type="text" id="shelter_home_search" class="form-control mb-2" id="txtSearch" name="searchValue" class="searchInput" value="' . $lastSearch . '"/>
    <input type="submit" id="btnSubmit" name="btnSubmit" value="Search" />
</form>
</div>';
?>
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "animal_rescue_application");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$sql = "";
if(!array_key_exists("searchValue",$_GET) || $_GET["searchValue"] == "") {
    $sql = "SELECT * FROM animal";
}
else {
    $sql = "SELECT * FROM animal where shelter_home = '$_GET[searchValue]'" ;
}


if($result = mysqli_query($link, $sql)){	
    if(mysqli_num_rows($result) > 0){
        echo "<div class='m-2'><table class='table'>";
            echo "<tr>";
                echo "<th>animal_id</th>";
                echo "<th>animal_type</th>";
                echo "<th>shelter_home</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['animal_id'] . "</td>";
                echo "<td>" . $row['animal_type'] . "</td>";
                echo "<td>" . $row['shelter_home'] . "</td>";
            echo "</tr>";
        }
        echo "</table></div>";
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "<div class='m-2'>" . "No records matching your query for '$_GET[searchValue]'." . "</div>";
    }
} else{
    echo "<div class='m-2'>" .  "ERROR: Could not able to execute $sql. " . mysqli_error($link) . "</div>";
}
 
// Close connection
mysqli_close($link);
?>