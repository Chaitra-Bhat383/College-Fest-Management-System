<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?back=registrations.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrations - Fest Management</title>
    <?php include 'includes/_links.php'; ?>
</head>

<body>
    <?php include 'includes/_navbar.php'; ?>

    <main>
        <?php include 'includes/_dash_head.php'; ?>

        <div class="container py-5" style="position: relative;">
            <h1 class="h3 font-weight-normal mb-4">
                Registrations
            </h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Event</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'includes/db_connect.php';

                    $query = 'SELECT * FROM  registrations NATURAL JOIN participants NATURAL JOIN events ';
                    $result = $db->query($query);
                    
                    if ($result) {
                        while ($row = $result->fetch_assoc()) { ?>
                                <td><?php echo $row['participant_name']; ?></td>
                                <td><?php echo $row['event_name']; ?></td>
                                <td><?php echo 'Participant'; ?></td>
                                <td>
                                    <a href="tel:<?php echo $row['participant_phone']; ?>" class="ml-2">
                                        <i class="fas fa-phone-alt"></i> Call
                                    </a>
                                </td>
                            </tr>
                    <?php }
                    }

                    $query = 'SELECT * FROM  audience_registrations NATURAL JOIN audience NATURAL JOIN events ';
                    $result = $db->query($query);
                    
                    if ($result) {
                        while ($row = $result->fetch_assoc()) { ?>
                                <td><?php echo $row['audience_name']; ?></td>
                                <td><?php echo $row['event_name']; ?></td>
                                <td><?php echo 'Audience'; ?></td>
                                <td>
                                    <a href="tel:<?php echo $row['audience_phone']; ?>" class="ml-2">
                                        <i class="fas fa-phone-alt"></i> Call
                                    </a>
                                </td>
                            </tr>
                    <?php }
                    }

                    ?>
                </tbody>
            </table>

            <?php include 'includes/_error_toast.php'; ?>
        </div>
    </main>

    <?php include 'includes/_scripts.php'; ?>
</body>

</html>
