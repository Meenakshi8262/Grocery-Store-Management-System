<?php
// Start the session
session_start();

// Initialize grocery items in the session if not already set
if (!isset($_SESSION['groceryItemsDetails'])) {
    $_SESSION['groceryItemsDetails'] = [
        "Apple" => ["type" => "Fruit", "price" => 1.20, "expiry" => "2025-01-10"],
        "Banana" => ["type" => "Fruit", "price" => 0.50, "expiry" => "2025-01-28"],
        "Carrot" => ["type" => "Vegetable", "price" => 0.30, "expiry" => "2025-01-05"],
        "Milk" => ["type" => "Dairy", "price" => 1.50, "expiry" => "2025-01-17"],
        "Bread" => ["type" => "Bakery", "price" => 2.00, "expiry" => "2025-01-30"]
    ];
}

// Display the inventory table
function displayInventory() {
    $data = $_SESSION['groceryItemsDetails']; // Load data from session

    echo "<table border='1'>
            <tr>
                <th>Item Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Expiry Date</th>
                <th>Expiry Status</th>
            </tr>";

    foreach ($data as $name => $details) {
        $expiryStatus = checkExpiry($details['expiry']);
        echo "<tr>
                <td>$name</td>
                <td>{$details['type']}</td>
                <td>{$details['price']}</td>
                <td>{$details['expiry']}</td>
                <td>$expiryStatus</td>
              </tr>";
    }

    echo "</table>";
}

// Add a new item to the session inventory
function addItem($name, $type, $price, $expiry) {
    $_SESSION['groceryItemsDetails'][$name] = [
        "type" => $type,
        "price" => $price,
        "expiry" => $expiry
    ];
}

// Check if an item is expired
function checkExpiry($expiryDate) {
    $currentDate = date("Y-m-d");
    return (strtotime($expiryDate) < strtotime($currentDate)) ? "Expired" : "Valid";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $expiry = $_POST['expiry'];

    // Add the new item to the session
    addItem($name, $type, $price, $expiry);

    // Redirect to avoid resubmission
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Store Management</title>
    <link rel="stylesheet" href="./Styles.css">
</head>
<body>
    <h1>Grocery Store Inventory</h1>

    <!-- Add Item Form -->
    <section class="add-item-form">
        <h2>Add New Item</h2>
        <form method="POST" action="index.php">
            <label for="name">Item Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="type">Type:</label>
            <input type="text" id="type" name="type" required><br>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required><br>

            <label for="expiry">Expiry Date:</label>
            <input type="date" id="expiry" name="expiry" required><br>

            <input type="submit" value="Add Item">
        </form>
    </section>

    <!-- Display Inventory -->
    <section class="inventory">
        <h2>Current Inventory</h2>
        <?php
        // Display the inventory
        displayInventory();
        ?>
    </section>
</body>
</html>
