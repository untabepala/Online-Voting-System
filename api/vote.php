<?php
session_start();
include('connect.php'); // Add a semicolon at the end of this line

// Check if 'gvotes' and 'gid' are set in $_POST
if (isset($_POST['gvotes'], $_POST['gid'])) {
    $votes = $_POST['gvotes'];
    $total_votes = $votes + 1;
    $gid = $_POST['gid'];
    $uid = $_SESSION['userdata']['id'];

    // Assuming $connect is the mysqli connection
    $update_votes = mysqli_query($connect, "UPDATE user SET votes='$total_votes' WHERE id='$gid'");
    $update_user_status = mysqli_query($connect, "UPDATE user SET status=1 WHERE id='$uid'");

    if ($update_votes && $update_user_status) {
        $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2");
        $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

        $_SESSION['userdata']['status'] = 1;
        $_SESSION['groupsdata'] = $groupsdata;
        echo '
        <script>
            alert("Voting Successful!");
            window.location = "../routes/dashboard.php";
        </script>
        ';
    } else {
        echo '
        <script>
            alert("Some error occurred!");
            window.location = "../routes/dashboard.php";
        </script>
        ';
    }
} else {
    echo "Error: 'gvotes' or 'gid' not set in the POST data.";
}
?>
