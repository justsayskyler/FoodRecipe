<?php
    session_start();
    require_once("database.php");

    if (!isset($_SESSION["UserID"]) || !isset($_GET["RecipeID"])) {
        header("Location: MyRecipes.php");
        exit();
    }

    $userID = $_SESSION["UserID"];
    $recipeID = intval($_GET["RecipeID"]); // Ensure it's an integer

    $sql = "DELETE FROM RecipesTable WHERE RecipeID = ? AND AuthorID = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL hazırlama hatası: " . $conn->error);
    }

    $stmt->bind_param("ii", $recipeID, $userID);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("Location: MyRecipes.php?success=deleted");
            exit();
        } else {
            echo "Silinecek tarif bulunamadı. Tarif size ait olmayabilir.";
        }
    } else {
        echo "Sorgu çalıştırılırken hata oluştu: " . $stmt->error;
    }
?>
