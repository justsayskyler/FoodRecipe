<?php
    session_start();
    include("header.php");
    require_once("database.php");

    if (!isset($_SESSION["UserID"])) {
        header("Location: Login.php");
        exit();
    }

    $userID = $_SESSION["UserID"];
    $recipeID = isset($_GET["RecipeID"]) ? intval($_GET["RecipeID"]) : 0;
    $isEditing = $recipeID > 0;

    // Variables for pre-filling form fields
    $foodName = $ingredients = $instructions = $description = $imageURL = "";

    // If editing, fetch existing recipe data
    if ($isEditing) {
        $sql = "SELECT * FROM RecipesTable WHERE RecipeID = ? AND AuthorID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $recipeID, $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $foodName = $row["FoodName"];
            $ingredients = $row["Ingredients"];
            $instructions = $row["Instructions"];
            $description = $row["FoodDescription"];
            $imageURL = $row["FoodImage"];
        } else {
            die("Bu tarif bulunamadı veya düzenleme izniniz yok.");
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $foodName = $_POST["food-name"];
        $ingredients = $_POST["ingredients"];
        $instructions = $_POST["instructions"];
        $description = $_POST["description"];
        $imageURL = $_POST["food-image"];

        if (empty($foodName) || empty($ingredients) || empty($instructions)) {
            echo "<script>alert('Lütfen tüm zorunlu alanları doldurun!');</script>";
        } else {
            // Fetch Author Name from UsersTable
            $query = "SELECT Username FROM UsersTable WHERE UserID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $userID);
            $stmt->execute();
            $result = $stmt->get_result();
            $authorName = ($result->num_rows > 0) ? $result->fetch_assoc()["Username"] : "Bilinmeyen kullanıcı";

            // Prevent SQL Injection
            $foodName = mysqli_real_escape_string($conn, $foodName);
            $ingredients = mysqli_real_escape_string($conn, $ingredients);
            $instructions = mysqli_real_escape_string($conn, $instructions);
            $description = mysqli_real_escape_string($conn, $description);
            $imageURL = mysqli_real_escape_string($conn, $imageURL);

            if ($isEditing) {
                // Update Existing Recipe
                $sql = "UPDATE RecipesTable SET FoodName=?, Ingredients=?, Instructions=?, FoodDescription=?, FoodImage=? WHERE RecipeID=? AND AuthorID=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssi", $foodName, $ingredients, $instructions, $description, $imageURL, $recipeID, $userID);
            } else {
                // Insert New Recipe
                $sql = "INSERT INTO RecipesTable (FoodName, Ingredients, Instructions, AuthorID, AuthorName, FoodDescription, FoodImage, RegDate) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssss", $foodName, $ingredients, $instructions, $userID, $authorName, $description, $imageURL);
            }

            if ($stmt->execute()) {
                echo "<script>alert('Tarif başarıyla " . ($isEditing ? "güncellendi" : "eklendi") . "!'); window.location.href='myrecipes.php';</script>";
            } else {
                echo "<script>alert('Hata oluştu.');</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEditing ? "Tarifi Güncelle" : "Yeni Tarif Ekle" ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/AddRecipeUI.css">
</head>
<body>
    <center>
        <div style="max-width: 70%;" class="fluid-container">
            <form name="recipeForm" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . ($isEditing ? "?RecipeID=$recipeID" : "") ?>" 
                style="width: 70%;" class="form-group" method="post" onsubmit="return validateForm()">
                
                <label for="food-name">(*)Yemek Adı</label>
                <input type="text" name="food-name" class="form-control" value="<?= htmlspecialchars($foodName) ?>">

                <label for="description">Açıklama</label>
                <textarea name="description" class="form-control"><?= htmlspecialchars($description) ?></textarea>

                <label for="ingredients">(*)Malzemeler</label>
                <textarea class="form-control" name="ingredients"><?= htmlspecialchars($ingredients) ?></textarea>

                <label for="instructions">(*)Yapılışı</label>
                <textarea class="form-control" name="instructions"><?= htmlspecialchars($instructions) ?></textarea>

                <label for="food-image">Resim Bağlantısı</label>
                <input type="url" name="food-image" class="form-control" placeholder="https://example.com/image.jpg" value="<?= htmlspecialchars($imageURL) ?>">

                <button type="submit" style="background-color: #ffc9b9;" class="form-control"><?= $isEditing ? "Güncelle" : "Ekle" ?></button>
            </form>
        </div>
    </center>

    <script>
        function validateForm() {
            var foodName = document.forms["recipeForm"]["food-name"].value;
            var ingredients = document.forms["recipeForm"]["ingredients"].value;
            var instructions = document.forms["recipeForm"]["instructions"].value;

            if (foodName == "" || ingredients == "" || instructions == "") {
                alert("Lütfen zorunlu alanları doldurunuz.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
