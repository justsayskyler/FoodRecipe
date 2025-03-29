<?php   
    include("header.php");
    require_once("database.php");

    $sql = "SELECT RecipeID FROM RecipesTable ORDER BY RAND() LIMIT 1";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $randomID = $row["RecipeID"];

        $sql = "SELECT * FROM RecipesTable WHERE RecipeID = $randomID";
        $result = $conn->query($sql);
        $recipe = $result->fetch_assoc();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Günün Tarifi</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($recipe["FoodName"]); ?> Tarifi</h1><br>

    <h3>Malzemeler</h3>
    <p style="white-space: pre-line;"><?php echo htmlspecialchars($recipe["Ingredients"]); ?></p><br>

    <h3>Yapılışı</h3>
    <p style="white-space: pre-line;"><?php echo htmlspecialchars($recipe["Instructions"]); ?></p><br>
    
</body>
</html>