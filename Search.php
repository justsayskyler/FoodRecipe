<?php
    include("header.php");
    require_once("database.php");

    if(isset($_GET["search"]) || empty($_GET["search"])){
        header("Loaction: index.php");
    }

    $search = "%" . $_GET["search"] . "%";

    $sql = "SELECT * FROM RecipesTable WHERE FoodName LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arama Sonuçları</title>
</head>
<body>
    <h2>Arama Sonuçları</h2>

    <?php
        while($row = $result->fetch_assoc()){
            echo '<a href="RecipePage.php?RecipeID=' . $row["RecipeID"] . '" class="recipe-link">' . 
             htmlspecialchars($row["FoodName"]) . ' Tarifi</a><br>';
        }
    ?>
</body>
</html>