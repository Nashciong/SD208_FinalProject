<?php
include 'livesearch_config.php';

if (isset($_POST['today'])) {

    $today = $_POST['today'];

    $myQuery = "SELECT title, dueDate, statuss FROM task WHERE dueDate LIKE '$today'";

    $result = mysqli_query($con, $myQuery);

    if (mysqli_num_rows($result) > 0) { ?>
        <table style="padding-top:20px">
            <!-- <thead> -->
                <!-- <tr>
                    <th style="font-size:5mm;color: #6C8054"><?php echo "<input type='checkbox'/>"; ?></th>
                    <th style="font-size:5mm;color: #6C8054">Title</th>
                    <th style="font-size:5mm;color: #6C8054">Due Date</th>
                    <th style="font-size:5mm;color: #6C8054">Status</th>
                </tr> -->
            <!-- </thead> -->
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = $row['title'];
                    $dueDate = $row['dueDate'];
                    $statuss = $row['statuss'];

                ?>
                    <tr style="line-height:5%;">
                        <td style="color:black ;font-family:Quicksand"><?php echo "<input type='checkbox'/>"; ?></td>
                        <td style="color:black ;font-family:Quicksand"><?php echo $title; ?></td>
                        <td style="color:black ;font-family:Quicksand"><?php echo $dueDate; ?></td>
                        <td style="color:black ;font-family:Quicksand"><?php echo $statuss; ?></td>
                        <td style="color:black ;font-family:Quicksand"><?php echo "<a href='' style=margin-left:50px;position:absolute>View</a>"; ?></td>
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