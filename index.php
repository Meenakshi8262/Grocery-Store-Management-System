<?php
// Task 1: Setting Up Grocery Item Arrays
// Index array to store grocery item names
$groceryItemNames = ["Apple", "Banana", "Carrot", "Milk", "Bread"];

// Associative array to store additional details for each item
// Details include type, price, and expiry date
$groceryItemsDetails = [
    "Apple" => ["type" => "Fruit", "price" => 1.20, "expiry" => "2025-01-10"],
    "Banana" => ["type" => "Fruit", "price" => 0.50, "expiry" => "2025-01-28"],
    "Carrot" => ["type" => "Vegetable", "price" => 0.30, "expiry" => "2025-01-05"],
    "Milk" => ["type" => "Dairy", "price" => 1.50, "expiry" => "2025-01-17"],
    "Bread" => ["type" => "Bakery", "price" => 2.00, "expiry" => "2025-01-30"]
];

// Task 2: Displaying the Grocery Inventory
// Function to display the entire inventory of grocery items
function displayInventory($groceryItemsDetails) {
    echo "<table border='1'>
            <tr>
                <th>Item Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Expiry Date</th>
                <th>Expiry Status</th>
            </tr>";

    // Loop through each item and display its details
    foreach ($groceryItemsDetails as $name => $details) {
        // Check expiry status for each item
        $expiryStatus = checkExpiry($details['expiry']); // Expiry check function
        echo "<tr>
                <td>$name</td>
                <td>" . $details['type'] . "</td>
                <td>" . $details['price'] . "</td>
                <td>" . $details['expiry'] . "</td>
                <td>$expiryStatus</td>
              </tr>";
    }

    echo "</table>";
}


// Task 3: Adding New Items
// Function to add a new item to the inventory
function addItem($name, $type, $price, $expiry) {
// Access the global inventory array
    global $groceryItemsDetails; 
    $groceryItemsDetails[$name] = [
        "type" => $type,
        "price" => $price,
        "expiry" => $expiry
    ];
}

// Task 4: Expiry Date Check
// Function to check the expiry status of each item
function checkExpiry($expiryDate) {
    $currentDate = date("Y-m-d"); // Get the current date
    // Compare expiry date with the current date to check if expired
    if (strtotime($expiryDate) < strtotime($currentDate)) {
        return "Expired"; // If the expiry date is before today
    } else {
        return "Valid"; // Otherwise, it is valid
    }
}

// Handle form submission to add new items to the inventory
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $expiry = $_POST['expiry'];

    // Add the new item to the inventory
    addItem($name, $type, $price, $expiry);
    header("Location: index.php"); // Redirect to refresh the page and show the updated list
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Grocery Store Management</title>
    <link rel="stylesheet" href="\Grocery Store Management System with PHP\Styles.css">
</head> 
    <h1>Grocery Store Inventory</h1>
    
    <!-- Task 3: Form Section for Adding a New Item -->
    <!-- This allows the user to input item details (name, type, price, expiry date) -->
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

    <!-- Task 2: Inventory Section -->
    <!-- This section displays the current grocery inventory -->
    <section class="inventory">
        <h2>Current Inventory</h2>
        <?php
            // Display the inventory of grocery items
            displayInventory($groceryItemsDetails);
        ?>
    </section>

</body>
</html>
