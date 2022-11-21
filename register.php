<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'includes/db_connect.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM login WHERE email = '$email'";
    $result = $db->query($query);

    if ($result) {
        if ($result->num_rows) {
            $error_message = 'User already exists with the given email';
        } else {
            $query = "INSERT INTO login (email, pass) VALUES ('$email', '" . $password . "')";
            $result = $db->query($query);

            if ($result) {
                $_SESSION['user_id'] = $email;

                header('Location: dashboard.php');
            } else {
                $error_message = $db->error;
            }
        }
    } else {
        $error_message = 'Something went wrong';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - Fest Management</title>
    <?php include 'includes/_links.php'; ?>
</head>

<body>
    <?php include 'includes/_navbar.php'; ?>

    <main>
        <div class="container py-5" style="position: relative;">
            <form id="registerForm" class="w-lg-50 w-md-75 mx-md-auto" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" novalidate>
                <div class="mb-5">
                    <h2 class="h3 text-primary font-weight-normal">
                        Welcome to <span class="font-weight-semi-bold">Fest
                            Management</span>
                    </h2>
                    <p class="text-muted">Fill out the form to get started.</p>
                </div>

                

                <div class="form-group">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email address">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="********">
                </div>

                
                <div class="mb-4">
                    <div class="custom-control custom-checkbox d-flex align-items-center text-muted">
                        <input type="checkbox" class="custom-control-input" id="terms_checkbox" name="terms_checkbox">
                        <label class="custom-control-label" for="terms_checkbox">
                            <small>I confirm that the information given in this
                                form is true, complete and
                                accurate.</small>
                        </label>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-6">
                        <span class="small text-muted">Already have an
                            account?</span>
                        <a class="small" href="login.php">Log in</a>
                    </div>

                    <div class="col-6 text-right">
                        <button type="submit" class="btn btn-primary py-2">Get
                            started</button>
                    </div>
                </div>
            </form>

            <?php include 'includes/_error_toast.php'; ?>
        </div>
    </main>

    <?php include 'includes/_scripts.php'; ?>
    <script>
        $(document).ready(function() {
            $('#registerForm').validate({
                rules: {
                    first_name: {
                        required: true,
                        nowhitespace: true,
                        lettersonly: true
                    },
                    last_name: {
                        required: true,
                        nowhitespace: true,
                        lettersonly: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                    },
                    phone: {
                        required: true,
                        phoneIN: true
                    },
                    terms_checkbox: {
                        required: true
                    }
                },
                messages: {
                    email: {
                        email: 'Please specify a valid email address.'
                    }
                }
            })

        })
    </script>
</body>

</html>
