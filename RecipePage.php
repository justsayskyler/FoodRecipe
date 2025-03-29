<?php
    include("header.php");
    require_once("database.php");

    if(isset($_GET["RecipeID"]) && is_numeric($_GET["RecipeID"])){
        $id = intval($_GET["RecipeID"]);

        $sql = "SELECT r.*, u.Username AS AuthorName 
        FROM RecipesTable r
        JOIN UsersTable u ON r.AuthorID = u.UserID
        WHERE r.RecipeID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            die("Tarif bulunamadı.");
        }
    }else{
        die("Geçersiz Tarif");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row["FoodName"]);?> Tarifi</title>
    <link rel="stylesheet" href="css/RecipePageUI.css">
</head>
<body>
    <h1><?php echo nl2br(htmlspecialchars($row["FoodName"])); ?> <br></h1>

    <p style="white-space: pre-line;"><?php echo htmlspecialchars($row["FoodDescription"]) ?></p><br>

    <h2>Malzemeler</h2><br>
    <p style="white-space: pre-line;"><?php echo htmlspecialchars($row["Ingredients"]) ?></p><br>

    <h2>Yapılışı</h2>
    <p style="white-space: pre-line;"><?php echo htmlspecialchars($row["Instructions"]) ?></p><br>
    
    <br>
    
    <p style="white-space: pre-line;">Yazar: <?php echo htmlspecialchars($row["AuthorName"]) ?></p>
</body>
</html>