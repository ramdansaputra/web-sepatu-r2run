<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

// Ambil data user dari session
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>

<head>
  <title>My Profile</title>
  <link rel="stylesheet" href="css/profile.css">
</head>

<body>

  <div class="profile-card">
    <h2>My Profile</h2>
    <div class="profile-info">
      <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
      <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    </div>
    <a href="index.php" class="button">Back to Home</a>
  </div>

</body>

</html>