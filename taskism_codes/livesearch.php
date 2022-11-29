<?php
include 'livesearch_config.php';

if (isset($_POST['input'])) {

    $input = $_POST['input'];

    $myQuery = "SELECT * FROM users WHERE fName LIKE '{$input}%' OR lName LIKE '{$input}%' OR Gender LIKE '{$input}%' LIMIT 3";

    $result = mysqli_query($con, $myQuery);

    if (mysqli_num_rows($result) > 0) {?>
        <table style="padding:20px;">
            <!-- <thead>
                <tr>
                <th>UserID</th>
                <th>fName</th>
                <th>lName</th>
                <th>Gender</th>
                </tr>
            </thead> -->

            <tbody>
                <?php
while ($row = mysqli_fetch_assoc($result)) {
        $fname = $row['fName'];
        $lname = $row['lName'];
        $gender = $row['Gender'];

        ?>
                    <tr>
                        <td><?php echo $fname; ?></td>
                        <td><?php echo $lname; ?></td>
                        <td><?php echo $gender; ?></td>
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