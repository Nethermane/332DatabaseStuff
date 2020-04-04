<!DOCTYPE html>
<html>
<link href="someStyling.css" type="text/css" rel="stylesheet" >
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<head>
    <?php
            require_once('header.php');
            $lname = $_POST["lname"]; 
            $fname = $_POST["fname"]; 
            echo "<h2> <i class='fa fa-car'></i> $fname $lname Trips </h2>";
    ?>
</head>
<body>
    <?php
        try {
            $dbhost = 'localhost';
            $dbname='animal_rescue_application';
            $dbuser = 'root';
            $dbpass = '';
            $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        } catch (PDOException $e) {
            echo "Error : " . $e->getMessage() . "<br/>";
        die();
        }
        $rows = $dbh->query("SELECT animal_id, A.name, B.name, transport_date  
                             FROM (driver_trip join animal_management A on branch = A.management_id) 
                             join animal_management B on shelter = B.management_id
                             WHERE first_name = '$fname' and last_name = '$lname'
                             ORDER BY transport_date ;");
         if ($rows->rowCount() == 0) {
            echo '<p>No trips were taken by this driver</p>';
         }
        else {
        echo "<div class='m-2'><table class='table'>";
        echo "<thead><tr><td>Animal ID</td><td>Picked Up From</td><td>Destination</td><td>Date</td><td></tr></thead>";

        echo "<tbody>";
        foreach ($rows as $row) {
                    echo "<tr> <td>".$row[0]."</td>";
                    echo "<td>".$row[1]."</td>";
                    echo "<td>".$row[2]."</td>";
                    echo "<td>".$row[3]."</td>";
            }
        echo "</tbody></table></div>"; 
        $numRows = $dbh->query("SELECT count(*) 
                                FROM driver_trip 
                                WHERE first_name = '$fname' and last_name = '$lname';");
        $count = $numRows -> fetch(); 
        echo "<p><b>Total Trips Taken: </b>".$count[0]."</p>";
        }
        ?>
        <p>
            <a href="Drivers.php">Return to list of rescue organizations</a>
        </p>

    </body>