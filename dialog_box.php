<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Query - Fest Management</title>
    <?php include 'includes/_links.php'; ?>
</head>

<body>

<?php include 'includes/_navbar.php'; ?>
    <main>

    <div >
    <form id="checkoutForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" novalidate>
    <div style="margin-left: 590px;margin-top:150px"> 
    <input type="text" autocomplete="off" style="height:250px;width:500px;background-color:#007bff;color:white" name="query_name" id="query_name" class="form-control" >
    </div>
    <div style="margin-left: 790px;margin-top:40px">
    <button type="submit" autocomplete="off" style="background-color:#007bff;color:white">Results</button>
    <br>
    <br>    
    </div>
    </form>
    </div>

    <?php
        include 'includes/db_connect.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['query_name']!=""){
        $query_name = $_POST['query_name'];
        $query = $query_name;
        $result = $db->query($query);
        

        if ($result) {
            while ($row = $result->fetch_assoc()) {
            echo json_encode($row);
            echo "<br>";
            echo "<br>";
            }
        }}}

         ?>
    <?php include 'includes/_error_toast.php'; ?>
    </main>
    <?php include 'includes/_scripts.php'; ?>

</body>
