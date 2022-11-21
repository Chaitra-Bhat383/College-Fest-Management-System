<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?back=select_events1.php');
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $err = urlencode('Select at least one event');
    header('Location: select_events1.php?err=' . $err);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];

    include 'includes/db_connect.php';

    $audience_name = $_POST['audience_name'];
    $audience_email = $_POST['audience_email'];
    $audience_phone = $_POST['audience_phone'];

    $result = $db->query("INSERT INTO audience (audience_name, audience_email,audience_phone) VALUES ('$audience_name', '$audience_email', '$audience_phone')");
    if ($result) {
        $audience_id = $db->insert_id;

        foreach ($cart as $event_id => $event) {
            $result = $db->query("INSERT INTO audience_registrations (audience_id, event_id) VALUES ('$audience_id', '$event_id')");
            if (!$result) {
                $error_message = 'Failed to register for ' . $event->event_name;
            }
        }

        unset($_SESSION['cart']);
        header('Location: registrations.php');
    } else {
        $error_message = $db->error;
    }
}

$total_amount = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout - Fest Management</title>
    <?php include 'includes/_links.php'; ?>
</head>

<body>
    <?php include 'includes/_navbar.php'; ?>

    <main>
        <div class="container py-5" style="position: relative;">
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <div class="shadow rounded p-4">
                        <div class="border-bottom pb-4 mb-3">
                            <h2 class="h5 mb-0">Selected events</h2>
                        </div>
                        <?php foreach ($_SESSION['cart'] as $event_id => $event) {
                            $total_amount = $total_amount + 100; ?>
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex align-items-start justify-content-between">
                                    <span>
                                        <h6 class="mb-0"><?php echo $event['event_name']; ?>
                                        </h6>
                                        <small class="text-muted"><?php echo $event['event_type']; ?></small>
                                    </span>
                                    <span class="text-muted">&#8377;<?php echo 100; ?></span>
                                </div>
                            </div>
                        <?php
                        } ?>
                        <div class="media align-items-center">
                            <span class="text-secondary">Total</span>
                            <div class="media-body text-right">
                                <span class="font-weight-semi-bold">&#8377;<?php echo $total_amount; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 order-md-1">
                    <form id="checkoutForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" novalidate>
                        <div class="mb-4">
                            <h2 class="h4">Audience details</h2>
                        </div>
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                        <div class="form-group">
                            <label for="audience_name" class="form-label">Name</label>
                            <input type="text" autocomplete="off" name="audience_name" id="audience_name" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="audience_email" class="form-label">Email</label>
                            <input type="email" autocomplete="off" name="audience_email" id="audience_email" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="participant_phone" class="form-label">Phone</label>
                            <input type="text" autocomplete="off" name="audience_phone" id="audience_phone" class="form-control" >
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="select_events1.php"><small class="fas fa-arrow-left mr-2"></small>
                                Return to
                                select events</a>
                            <button type="submit" class="btn btn-primary btn-pill transition-3d-hover">Continue</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php include 'includes/_error_toast.php'; ?>
        </div>
    </main>

    <?php include 'includes/_scripts.php'; ?>
    <script>
        $(document).ready(function() {
            $('#checkoutForm').validate({
                rules: {
                    audience_name: {
                        required: true
                    },
                    audience_email: {
                        required: true,
                        email: true
                    },
                    audience_phone: {
                        required: true,
                        phoneIN: true
                    }
                }
            });
        })
    </script>
</body>

</html>
