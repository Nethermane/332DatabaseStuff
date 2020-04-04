<!DOCTYPE html>
<html>
<link href="someStyling.css" type="text/css" rel="stylesheet" >
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<head>
    <?php
            require_once('header.php');
            $org = $_POST["rescue"]; 
            echo "<h2> <i class='fa fa-car'></i> $org Drivers </h2>";
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
        $rows = $dbh->query("SELECT first_name, last_name, emergency_phone, license_plate, license_number
                             FROM driver WHERE works_for in (SELECT management_id 
                                                            FROM animal_management 
                                                            WHERE name = '$org')
                            ORDER BY last_name, first_name;");
         if ($rows->rowCount() == 0) {
            echo '<p>No animals were moved from the SPCA directly to a shelter</p>';
         }
        else {
        echo "<div class='m-2'><table class='table'>";
        echo "<thead><tr><td>First Name</td><td>Last Name</td><td>Emergency Number</td>
                <td>License Plate</td><td>License Number</td><td></td></tr></thead>";

        echo "<tbody>";
        foreach ($rows as $row) {
                    echo "<tr> <td>".$row['first_name']."</td>";
                    echo "<td>".$row['last_name']."</td>";
                    echo "<td>".$row['emergency_phone']."</td>";
                    echo "<td>".$row['license_plate']."</td>";
                    echo "<td>".$row['license_number']."</td>";
                    echo "<td> <form method='POST' action='driverTrips.php'>
                    <input type = 'hidden' value = '$row[1]' name = 'lname'/>
                    <input type = 'hidden' value = '$row[0]' name = 'fname'/> 
                    <input type = 'submit' value = 'trips' /> </form></td></tr>";
            }
        echo "</tbody></table></div>"; 
        $numRows = $dbh->query("select count(*) 
                                from driver
                                where works_for in (select management_id 
                                                    from animal_management 
                                                    where name = '$org');");
        $count = $numRows -> fetch(); 
        echo "<p><b>Total Drivers Employed: </b>".$count[0]."</p>";
        }
        ?>
        <p>
            <a href="Drivers.php">Return to list of rescue organizations</a>
        </p>

    </body>