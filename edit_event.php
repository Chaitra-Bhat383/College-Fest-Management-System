<?php
session_start();

include_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?back=edit_event.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'includes/db_connect.php';
    $event_name = $_POST['event_name'];
    $event_type = $_POST['event_type'];
    $event_fee = $_POST['event_fee'];
    $category_name = $_POST['category_name'];
    $organiser_id = $_POST['organiser_id'];
    $event_desc = $_POST['event_desc'];
    $event_date = $event_date;

    

    $result = $db->query("UPDATE events SET event_type = '$event_type', event_fee = '$event_fee', category_name = '$category_name',event_desc = '$event_desc',organiser_id = '$organiser_id' WHERE event_name = '$event_name'");

    if ($result) {
        header('Location: events.php');
    } else {
        $error_message = $db->error;
    }
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $result = $db->query("SELECT * FROM events WHERE event_id = '$event_id'");
    if ($result) {
        if ($row = $result->fetch_assoc()) {
            $event_date = $row['event_date'];
?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>Edit Event - Fest Management</title>
                <?php include 'includes/_links.php'; ?>
            </head>

            <body>
                <?php include 'includes/_navbar.php'; ?>

                <main>
                    <div class="bg-light py-5">
                        <div class="container" style="position: relative;">

                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" novalidate>
                                <div class="mb-4">
                                    <h2 class="h4">Edit event</h1>
                                </div>

                                <input type="hidden" name="event_id" value="<?php echo $row['event_id']; ?>">

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="event_name" class="form-label" >Event name</label>
                                            <input type="text" name="event_name" id="event_name" class="form-control" value="<?php echo $row['event_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="event_type" class="form-label">Event type</label>
                                            <select name="event_type" id="event_type" class="form-control custom-select">
                                                <option value="Individual">Individual</option>
                                                <option value="Group">Group</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="event_fee" class="form-label">Event fee</label>
                                            <?php
                                            $participants = $db->query("SELECT * FROM registrations WHERE event_id = '$event_id'");
                                            ?>
                                            <input type="number" name="event_fee" id="event_fee" class="form-control" min="1" value="<?php echo $row['event_fee']; ?>" <?php echo $participants->num_rows > 0 ? '' : ''; ?>>
                                        </div>
                                    </div>
                      
                

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_name" class="form-label" >Category</label>
                            <select name="category_name" id="category_name" class="form-control custom-select" >
                            <option value="<?php echo $row['category_name']; ?>" <?php echo $row['category_name'] == $row['category_name'] ? 'selected' : ''; ?>>
                            <?php echo $row['category_name']; ?>
                        </option>
                                        <option value="Technical" >Technical</option>
                                        <option value="Brain Storming">Brain Storming</option>
                                        <option value="Cultural" >Cultural</option>
                                        <option value="Fun">Fun</option>
                                        <option value="Sports">Sports</option>
                                        <option value="Gaming">Gaming</option>
                                    }
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="organiser_id" class="form-label">Organiser</label>
                            <select name="organiser_id" id="organiser_id" class="form-control custom-select">
                                <option value="" disabled>Select organiser</option>
                                <?php
                                $organisers = $db->query("SELECT * FROM organisers ORDER BY organiser_name");
                                if ($organisers) {
                                    while ($organiser_row = $organisers->fetch_assoc()) { ?>
                                        <option value="<?php echo $organiser_row['organiser_id']; ?>" <?php echo $organiser_row['organiser_id'] == $row['organiser_id'] ? 'selected' : ''; ?>>
                                            <?php echo $organiser_row['organiser_name']; ?>
                                        </option>
                                <?php }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="event_desc" class="form-label">Description</label>
                            <textarea name="event_desc" id="event_desc" rows="5" class="form-control">
                            <?php echo $row['event_desc']; ?>
                            </textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-sm-wide transition-3d-hover mr-1">Update</button>
                <a href="events.php" class="btn btn-secondary btn-sm-wide transition-3d-hover">Cancel</a>

                </form>

                <?php include 'includes/_error_toast.php'; ?>
                </div>
                </div>
                </main>

                <?php include 'includes/_scripts.php'; ?>
            </body>

            </html>

<?php
        } else {
            header('Location: events.php?err=' . urlencode('No such event found.'));
        }
    } else {
        header('Location: events.php?err=' . urlencode('Something went wrong.'));
    }
} else {
    header('Location: events.php');
}
