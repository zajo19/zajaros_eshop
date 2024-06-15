<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "zajaros";
$password = "andrej";
$dbname = "zajaros";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_by = "t_produkty.nazov ASC"; // Defaultne zoradenie

if (isset($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'price_asc':
            $order_by = "t_produkty.cena ASC";
            break;
        case 'price_desc':
            $order_by = "t_produkty.cena DESC";
            break;
        case 'name_asc':
            $order_by = "t_produkty.nazov ASC";
            break;
        case 'name_desc':
            $order_by = "t_produkty.nazov DESC";
            break;
    }
}

$selected_category = $_GET['category'] ?? '';

$sql = "SELECT t_produkty.*, t_kategorie.nazov AS kategoria_nazov
        FROM t_produkty
        LEFT JOIN t_kategorie ON t_produkty.kategoria_id = t_kategorie.id
        " . (!empty($selected_category) ? "WHERE t_kategorie.nazov = '$selected_category'" : "") . "
        ORDER BY $order_by";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produkty</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #e0f7fa;
            color: #000000;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #002f6c;
            overflow: hidden;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .navbar a {
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .navbar img {
            height: 50px;
            margin-right: 20px;
        }
        .page-main {
            display: flex;
            margin-top: 60px; /* Adjusted to avoid overlap with the navbar */
        }
        .sidebar {
            width: 20%;
            padding: 10px;
            background-color: #f1f1f1;
            text-align: left;
            height: 100vh; /* Full height sidebar */
            order: 2;
        }
        .sidebar h3 {
            margin-top: 0;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin: 5px 0;
        }
        .page-container {
            width: 80%;
            padding: 20px;
            order: 1;
        }
        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .product {
            border: 1px solid #ddd;
            margin: 10px;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
            width: 200px;
            box-sizing: border-box;
        }
        .product img {
            width: 100%;
            height: auto;
        }
        .product h3 {
            margin: 0;
            font-size: 18px;
        }
        .product p {
            margin: 5px 0;
            font-size: 14px;
        }
        .product .price {
            font-size: 16px;
            font-weight: bold;
            color: #ff8f00;
        }
        .filters {
            margin: 20px;
        }
        .filters select {
            padding: 10px;
            font-size: 16px;
        }
        .statistics {
            margin-top: 20px;
        }
        .statistics table {
            width: 100%;
            border-collapse: collapse;
        }
        .statistics table, .statistics th, .statistics td {
            border: 1px solid #ddd;
        }
        .statistics th, .statistics td {
            padding: 8px;
            text-align: left;
        }
        .statistics th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="navbar">
    <img src="https://www.hcslovan.sk/Upload/Gallery/Image/0,40904/custom/Screen_Shot_2021-05-25_at_16.09.34.png" alt="HC Slovan Logo">
    <a href="index.php">Home</a>
    <a href="welcome.php">Shop</a>
    <?php if(isset($_SESSION['username'])): ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="register.php">Register</a>
        <a href="index.php">Login</a>
    <?php endif; ?>
</div>

<div class="page-main">
    <div class="sidebar">
        <h3>Kategórie</h3>
        <ul>
            <?php
            $sql_category = "SELECT id, nazov FROM t_kategorie";
            $result_category = $conn->query($sql_category);

            if ($result_category->num_rows > 0) {
                while ($row_category = $result_category->fetch_assoc()) {
                    $category_link = htmlspecialchars($row_category["nazov"]);
                    echo '<li><a href="?category=' . urlencode($category_link) . '">' . $category_link . '</a></li>';
                }
            } else {
                echo '<li>Žiadne kategórie</li>';
            }
            ?>
        </ul>
        <div class="statistics">
            <h3>Štatistika cien</h3>
            <?php
            $category = $_GET['category'] ?? '';

            if ($category !== '') {
                $stmt = $conn->prepare("
                    SELECT MIN(t_produkty.cena) AS najnizsia_cena, MAX(t_produkty.cena) AS najvyssia_cena, SUM(t_produkty.cena) AS suma_cien, AVG(t_produkty.cena) AS priemerna_cena
                    FROM t_produkty
                    JOIN t_kategorie ON t_produkty.kategoria_id = t_kategorie.id
                    WHERE t_kategorie.nazov = ?
                ");
                $stmt->bind_param("s", $category);
                $stmt->execute();
                $result_stats = $stmt->get_result();
            } else {
                $result_stats = $conn->query("
                    SELECT MIN(cena) AS najnizsia_cena, MAX(cena) AS najvyssia_cena, SUM(cena) AS suma_cien, AVG(cena) AS priemerna_cena
                    FROM t_produkty
                ");
            }

            if ($result_stats->num_rows > 0) {
                $row_stats = $result_stats->fetch_assoc();
                echo "<table>";
                echo "<tr><td>Najnižšia cena:</td><td>" . $row_stats['najnizsia_cena'] . " €</td></tr>";
                echo "<tr><td>Najvyššia cena:</td><td>" . $row_stats['najvyssia_cena'] . " €</td></tr>";
                echo "<tr><td>Suma všetkých cien:</td><td>" . number_format($row_stats['suma_cien'], 2). " €</td></tr>";
                echo "<tr><td>Priemerná cena:</td><td>" . number_format($row_stats['priemerna_cena'], 2) . " €</td></tr>";
                echo "</table>";
            } else {
                echo "Žiadne údaje pre štatistiky.";
            }

            if (isset($stmt)) {
                $stmt->close();
            }
            ?>
        </div>
    </div>

    <div class="page-container">
        <form method="GET" class="nav-bar">
            <input type="text" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" placeholder="Hľadať podľa názvu">
            <select name="sort">
                <option value="price_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : ''; ?>>Cena: od najnižšej</option>
                <option value="price_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : ''; ?>>Cena: od najvyššej</option>
                <option value="name_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name_asc') ? 'selected' : ''; ?>>Názov: od A po Z</option>
                <option value="name_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name_desc') ? 'selected' : ''; ?>>Názov: od Z po A</option>
            </select>
            <button type="submit">Filtrovať</button>
            <?php
            if (!empty($_GET['category'])) {
                echo '<input type="hidden" name="category" value="' . htmlspecialchars($_GET['category']) . '">';
            }
            ?>
        </form>

        <div class="products">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<h3>" . htmlspecialchars($row["nazov"]) . "</h3>";
                    echo "<p>" . htmlspecialchars($row["popis"]) . "</p>";
                    echo "<img src='" . htmlspecialchars($row["obrazok"]) . "' alt='" . htmlspecialchars($row["nazov"]) . "'>";
                    echo "<p class='price'>" . htmlspecialchars($row["cena"]) . " €</p>";
                    echo "<p>Značka: " . htmlspecialchars($row["znacka"]) . "</p>";
                    echo "<p>Množstvo: " . htmlspecialchars($row["mnozstvo"]) . "</p>";
                    echo "<p>Kategória: " . htmlspecialchars($row["kategoria_nazov"]) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "Žiadne produkty k dispozícii.";
            }
            $conn->close();
            ?>
        </div>
    </div>
</div>

</body>
</html>