<?php
    session_start();
    include("header.php");
    require_once("database.php");

    if(!isset($_SESSION["UserID"])){
        header("Location: Login.php");

        exit();
    }

    $userID = $_SESSION["UserID"];
    $sql = "SELECT * FROM RecipesTable WHERE AuthorID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tariflerim</title>
    <link rel="stylesheet" href="css/MyRecipesUI.css">
</head>
<body>
    <h2>Tariflerim</h2>

    <div class="recipe-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="recipe-link">
                    <!-- Left Side: Blurred Image with Overlay Text -->
                    <div class="recipe-left">
                        <img src="<?= htmlspecialchars($row["FoodImage"]) ?>" alt="<?= htmlspecialchars($row["FoodName"]) ?>" class="recipe-image">
                        <div class="recipe-text">
                            <?= htmlspecialchars($row["FoodName"]) ?>
                        </div>
                    </div>

                    <!-- Right Side: Recipe Description + Buttons -->
                    <div class="recipe-right">
                        <p>
                            <?= substr(htmlspecialchars($row["FoodDescription"]), 0, 100) ?>...
                            <a href='RecipePage.php?RecipeID=<?= $row["RecipeID"] ?>' class="read-more">Devamını oku</a>
                        </p>

                        <div class="recipe-buttons">
                            <a href='AddRecipe.php?RecipeID=<?= $row["RecipeID"] ?>' class="update-btn">Güncelle</a>
                            <a href='DeleteRecipe.php?RecipeID=<?= $row["RecipeID"] ?>' class="delete-btn"
                                onclick="return confirm('Bu tarifi silmek istediğinizden emin misiniz?');">
                                Sil
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Henüz bir tarif eklemediniz.</p>
        <?php endif; ?>
    </div>

</body>
</html>