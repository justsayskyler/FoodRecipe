<?php
    include("header.php");
    require_once("database.php");

    $sql = "SELECT * FROM RecipesTable";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa</title>
    <link rel="stylesheet" href="css/IndexUI.css">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
</head>
<body>
    <div class="container">
        <div class="recipe-container">
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<a href="RecipePage.php?RecipeID=' . $row["RecipeID"] . '" target="_blank" class="recipe-link">
                                <div class="recipe-left">
                                    <img src="' . htmlspecialchars($row["FoodImage"]) . '" alt="' . htmlspecialchars($row["FoodName"]) . '" class="recipe-image">
                                    <div class="recipe-text">' . htmlspecialchars($row["FoodName"]) . '</div>
                                </div>
                                <div class="recipe-right">
                                    <p>' . substr(htmlspecialchars($row["FoodDescription"]), 0, 100) . '... <span class="read-more">Devamını oku</span></p>
                                </div>
                            </a>';
                    }
                } else {
                    echo "<p>Hiç tarif bulunamadı.</p>";
                }
            ?>
        </div>
    </div>
</body>
</html>