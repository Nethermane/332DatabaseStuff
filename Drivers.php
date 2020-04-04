<!DOCTYPE html> 
<html> 
    <link href="someStyling.css" type="text/css" rel="stylesheet" >
    <?php
        require_once('header.php');
    ?>
    <head> 
        <h1> 
            Rescue Organizations 
        </h1> 
    </head> 
    <body> 
        <h6> 
            Select "drivers" to see more information about that associations drivers.
        </h6>
        <br>
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
            $rows = $dbh->query("SELECT name, phone_number, street_name, street_number, 
                                        city, province, country, postal_code
                                FROM organization natural join  animal_management
                                ORDER BY name;");
            if ($rows->rowCount() == 0) {
                    echo '<p>No Rescue Orginizations in the system.</p>';
            }
            else {
                echo "<div class='m-2'><table class='table'>";
                echo "<thead><tr><td> Organization </td><td>Phone Number</td><td> Address</td><td></td></tr></thead>";
                echo "<tbody>";
                foreach ($rows as $row) {
                    $address = intval($row[3])." ".$row[2]."<br>".$row[4].", ".$row[5]."<br>".$row[6]."<br>".$row[7];
                    echo "<tr>";
                    echo "<td>".$row[0]."</td>";
                    echo "<td>".$row[1]."</td>";
                    echo "<td>".$address."</td>";
                    echo "<td> <form method='POST' action='driverTable.php'> 
                            <input type = 'hidden' value = '$row[0]' name = 'rescue'/> 
                            <input type = 'submit' value = 'drivers' /> </form></td>";
                
                    echo "</tr>";
                    
                }
                echo "</tbody></table></div>";
            }
        ?>
    </body>
</html>
