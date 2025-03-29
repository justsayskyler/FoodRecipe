<?php
include("header.php");
require_once("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);

    try {
        // Check if username already exists
        $checkSql = "SELECT UserID FROM UsersTable WHERE Username = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            throw new Exception("Bu kullanıcı adı zaten kullanılıyor. Lütfen başka bir ad seçin.");
        }

        // Insert new user
        $sql = "INSERT INTO UsersTable (Username, UserPassword) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Kayıt başarılı! Giriş yapabilirsiniz.'); window.location.href='login.php';</script>";
        } else {
            throw new Exception("Kayıt sırasında hata oluştu. Lütfen tekrar deneyin.");
        }

    } catch (Exception $e) {
        echo "<script>alert('" . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üye Ol</title>
    <link rel="stylesheet" href="css/RegisterPageUI.css">
</head>
<body>
    <div class="container">
        <div class="fluid-container">
            <form action="Register.php" method="post" class="form-group" style="width: 70%;">
                <label for="username">Kullanıcı Adı:</label>
                <input type="text" required name="username" class="form-control"><br>

                <label for="password">Şifre:</label>
                <input type="password" required name="password" class="form-control">

                <button type="submit" class="btn btn-outline-primary">Üye Ol</button>
            </form>
        </div>
    </div>
</body>
</html>
