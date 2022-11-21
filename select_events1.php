<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?back=select_events1.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Select Events - Fest Management</title>
    <?php include 'includes/_links.php'; ?>
</head>

<body>
    <?php include 'includes/_navbar.php'; ?>

    <main>
        <div class="container py-5" >
            <h1 >
                <span>Select Events</span>
                <a href="checkout1.php" class="btn btn-success float-right">
                    Proceed <i class="fas fa-arrow-right"></i>
                </a>
            </h1>
            <div> </div>
            <div >
                <?php
                include 'includes/db_connect.php';
            
                $result = $db->query('SELECT * FROM events ORDER BY event_name');
                if ($result) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <div >
                            <div >
                                <div >
                                    <h5 class="card-title">
                                        <a href="view_event.php?id=<?php echo $row['event_id']; ?>" class="text-decoration-none text-dark">
                                            <?php echo $row['event_name']; ?>
                                        </a>
                                    </h5>   
                                    <form action="update_cart1.php" method="post">
                                        <input type="hidden" name="event_id" value="<?php echo $row['event_id']; ?>">
                                        <?php if (isset($_SESSION['cart'][$row['event_id']])) { ?>
                                            <input type="hidden" name="type" value="remove">
                                            <button type="submit" class="btn btn-danger btn-sm float-right">
                                                <i class="fas fa-times"></i> Remove
                                            </button>
                                        <?php } else { ?>
                                            <input type="hidden" name="type" value="add">
                                            <button type="submit" class="btn btn-primary btn-sm float-right">
                                                <i class="fas fa-check"></i> Select
                                            </button>
                                        <?php } ?>
                                    </form>
                                    <h6 class="card-subtitle mb-2 text-muted">&#8377; <?php echo 100; ?></h6>
                                    <p class="card-text text-truncate"><?php echo $row['event_desc']; ?></p>
                                <div> </div>
                                <div> </div>
                                <div> </div>
                                </div>
                        <?php
                    }
                }
                        ?>
                            </div>

                            
                        </div>
    </main>

    
</body>

</html>
