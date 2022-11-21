<?php
session_start();

include_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?back=sponsors.php');
}

if (isset($_POST['type']) && $_POST['type'] == 'remove' && isset($_POST['sponsors_id'])) {
    $sponsors_id = $_POST['sponsors_id'];

    $result = $db->query("DELETE FROM sponsors WHERE sponsors_id = '$sponsors_id'");
    if (!$result) {
        $error_message = 'sponsors cannot be deleted.';
    }
}

if (isset($_POST['type']) && $_POST['type'] == 'add') {
    $sponsors_name = $_POST['sponsors_name'];
    $sponsors_phone = $_POST['sponsors_phone'];
    $sponsors_email = $_POST['sponsors_email'];
    $contribution = $_POST['contribution'];

    $result = $db->query("INSERT INTO sponsors (sponsors_name, sponsors_phone,sponsors_email, contribution) VALUES ('$sponsors_name', '$sponsors_phone','$sponsors_email','$contribution')");
    if ($result) {
        header('Location: sponsors.php');
    } else {
        $error_message = $db->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>sponsors - Fest Management</title>
    <?php include 'includes/_links.php'; ?>
</head>

<body>
    <?php include 'includes/_navbar.php'; ?>

    <main>
        <?php include 'includes/_dash_head.php'; ?>

        <div class="container py-5" style="position: relative;">
            <h1 class="h3 d-flex align-items-center justify-content-between font-weight-normal mb-4">
                <span>sponsors</span>
                <button type="button" class="btn btn-primary btn-sm transition-3d-hover" data-toggle="modal" data-target="#newOrganiserModal">
                    <i class="fas fa-plus"></i> Add
                </button>
            </h1>
            <div class="modal fade" id="newOrganiserModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="newsponsorsForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" novalidate>
                            <div class="modal-header">
                                <h5 class="modal-title">New sponsor</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="type" value="add">
                                <div class="form-group">
                                    <label for="sponsors_name" class="form-label">Name</label>
                                    <input autocomplete="off" type="text" name="sponsors_name" id="sponsors_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="sponsors_phone" class="form-label">Phone</label>
                                    <input autocomplete="off" type="text" name="sponsors_phone" id="sponsors_phone" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="sponsors_name" class="form-label">Email</label>
                                    <input autocomplete="off" type="text" name="sponsors_email" id="sponsors_email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="contribution" class="form-label">Contribution</label>
                                    <input autocomplete="off" type="text" name="contribution" id="contribution" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm-wide transition-3d-hover">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Contribution</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $db->query('SELECT * FROM sponsors');
                    if ($result) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['sponsors_name']; ?></td>
                                <td><?php echo $row['sponsors_phone']; ?></td>
                                <td><?php echo $row['sponsors_email']; ?></td>
                                <td><?php echo $row['contribution']; ?></td>
                                <td>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <input type="hidden" name="sponsors_id" value="<?php echo $row['sponsors_id']; ?>">
                                        <input type="hidden" name="type" value="remove">
                                        <button type="submit" class="bg-transparent border-0 text-danger p-0">
                                            <i class="far fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                    <?php }
                        $result->close();
                    }
                    ?>
                </tbody>
            </table>

            <?php include 'includes/_error_toast.php'; ?>
        </div>
    </main>

    <?php include 'includes/_scripts.php'; ?>
    <script>
        $(document).ready(function() {
            $('#newsponsorsForm').validate({
                rules: {
                    sponsors_name: {
                        required: true,
                    },
                    sponsors_phone: {
                        required: true,
                        phoneIN: true
                    }
                }
            });
        })
    </script>
</body>

</html>
