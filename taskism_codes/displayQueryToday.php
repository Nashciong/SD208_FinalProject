<?php
include 'livesearch_config.php';

if (isset($_POST['today'])) {

    $today = $_POST['today'];
    
    $myQuery = "SELECT fName, lName, Gender, statuss FROM users WHERE statuss LIKE '{$today}%'";

    $result = mysqli_query($con, $myQuery);

    if (mysqli_num_rows($result) > 0) { ?>
        <table style="padding-top:20px">
            <!-- <thead>
                <tr>
                    <th style="font-size:5mm;color: #6C8054">First Name</th>
                    <th style="font-size:5mm;color: #6C8054">Last Name</th>
                    <th style="font-size:5mm;color: #6C8054">Gender</th>
                    <th style="font-size:5mm;color: #6C8054">Status</th>
                </tr>
            </thead> -->
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $fname = $row['fName'];
                    $lname = $row['lName'];
                    $gender = $row['Gender'];
                    $status = $row['statuss'];

                ?>
                    <tr style="line-height:5%;">
                        <td style="color:black ;font-family:Quicksand"><?php echo "<input type='checkbox'/>"; ?></td>
                        <td style="color:black ;font-family:Quicksand"><?php echo $fname; ?></td>
                        <td style="color:black ;font-family:Quicksand"><?php echo $lname; ?></td>
                        <td style="color:black ;font-family:Quicksand"><?php echo $gender; ?></td>
                        <td style="color:black ;font-family:Quicksand"><?php echo $status; ?></td>
                        <td style="color:black ;font-family:Quicksand"><?php echo "<a href='' style=margin-left:220%>View</a>"; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
<?php
    } else {
        echo "No data is found!";
    }
}
?>