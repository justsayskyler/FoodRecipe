<?php
    session_start();

    include("header.php");
    require_once("database.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM UsersTable WHERE Username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user["UserPassword"])) {
                $_SESSION["UserID"] = $user["UserID"];
                $_SESSION["Username"] = $user["Username"];
                session_regenerate_id(true);
                header("Location: index.php");
                exit();
            } else {
                echo "Hatalı şifre!";
            }
        } else {
            echo "Kullanıcı bulunamadı!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="css/LoginPageUI.css">
</head>
<body>
    <div class="container">
        <div class="fluid-container">
            <form action="Login.php" method="post" class="form-group" style="width: 70%;">
                <label for="username">Kullanıcı Adı:</label>
                <input type="text" name="username" class="form-control"><br>

                <label for="password">Şifre:</label>
                <input type="password" name="password" class="form-control"><br>

                <button type="submit" class="btn btn-outline-success">Giriş Yap</button>
            </form>
        </div>
    </div>
</body>
</html>