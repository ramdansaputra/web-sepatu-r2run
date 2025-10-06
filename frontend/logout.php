<?php
session_start();
session_unset(); // Menghapus semua session
session_destroy(); // Mengakhiri session

// Redirect ke halaman login (di dalam folder frontend)
header("Location: ../frontend/login.php");
exit();
