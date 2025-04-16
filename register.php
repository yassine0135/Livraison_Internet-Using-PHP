<?php 
session_start();
include('./db_connect.php');
ob_start();

if (isset($_SESSION['login_id'])) {
    header("location:index.php?page=home");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into the database
        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, type, livreur_id) VALUES (?, ?, ?, ?, ?, ?)");
        $type = 2; // Assuming 2 is the default type for a client
        $livreur_id = NULL; // Change as needed
        $stmt->bind_param("ssssis", $firstname, $lastname, $email, $hashed_password, $type, $livreur_id);

        if ($stmt->execute()) {
            $success = "Registration successful! You can now log in.";
        } else {
            $error = "Registration failed. Please try again.";
        }
        $stmt->close();
    }
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card">
        <div class="login-logo">
            <a href="#"><b><?php echo $_SESSION['system']['name']; ?> - Register</b></a>
        </div>
        <div class="card-body login-card-body">
            <form action="" method="POST">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="firstname" value="<?php echo isset($firstname) ? $firstname : '' ?>" required placeholder="First Name">
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="lastname" value="<?php echo isset($lastname) ? $lastname : '' ?>" required placeholder="Last Name">
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" value="<?php echo isset($email) ? $email : '' ?>" required placeholder="Email">
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" required placeholder="Password">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success btn-block">Register</button>
                </div>
            </form>
            <p class="mt-2">
                <a href="login.php">Already have an account? Login here</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->
<?php include 'footer.php'; ?>
</body>
</html>
