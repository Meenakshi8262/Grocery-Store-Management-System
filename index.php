<?php
// Task 1: Load Grocery Items from JSON File
function loadInventory() {
    $file = 'inventory.json';
    if (file_exists($file)) {
        $jsonData = file_get_contents($file);
        return json_decode($jsonData, true);
    } else {
        // Default inventory 
        return [
            "Apple" => ["type" => "Fruit", "price" => 1.20, "expiry" => "2025-01-10"],
            "Banana" => ["type" => "Fruit", "price" => 0.50, "expiry" => "2025-01-28"],
            "Carrot" => ["type" => "Vegetable", "price" => 0.30, "expiry" => "2025-01-05"],
            "Milk" => ["type" => "Dairy", "price" => 1.50, "expiry" => "2025-01-17"],
            "Bread" => ["type" => "Bakery", "price" => 2.00, "expiry" => "2025-01-30"]
        ];
    }
}

// Task 2: Save Grocery Items to JSON File
function saveInventory($inventory) {
    $file = 'inventory.json';
    file_put_contents($file, json_encode($inventory, JSON_PRETTY_PRINT));
}

// Task 3: Displaying the Grocery Inventory
function displayInventory($groceryItemsDetails) {
    echo "<table border='1'>
            <tr>
                <th>Item Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Expiry Date</th>
                <th>Expiry Status</th>
                <th>Actions</th>
            </tr>";

    // Loop through each item and display its details
    foreach ($groceryItemsDetails as $name => $details) {
        // Check expiry status for each item
        $expiryStatus = checkExpiry($details['expiry']);
        echo "<tr>
                <td>$name</td>
                <td>" . $details['type'] . "</td>
                <td>" . $details['price'] . "</td>
                <td>" . $details['expiry'] . "</td>
                <td>$expiryStatus</td>
                <td>
                    <form method='POST' action='index.php' style='display:inline'>
                        <input type='hidden' name='edit' value='$name'>
                        <input type='submit' value='Edit'>
                    </form>
                    <form method='POST' action='index.php' style='display:inline'>
                        <input type='hidden' name='delete' value='$name'>
                        <input type='submit' value='Delete' onclick='return confirm(\"Are you sure?\")'>
                    </form>
                </td>
              </tr>";
    }

    echo "</table>";
}

// Adding New Items
function addItem($name, $type, $price, $expiry) {
    // Load the current inventory
    $groceryItemsDetails = loadInventory();
    
    // Add the new item to the inventory
    $groceryItemsDetails[$name] = [
        "type" => $type,
        "price" => $price,
        "expiry" => $expiry
    ];
    
    // Save the updated inventory back to the file
    saveInventory($groceryItemsDetails);
}

// Task 4: Expiry Date Check
function checkExpiry($expiryDate) {
    $currentDate = date("Y-m-d");
    // Compare expiry date with the current date to check if expired
    if (strtotime($expiryDate) < strtotime($currentDate)) {
        return "Expired";
    } else {
        return "Valid";
    }
}

//  Edit Item
function editItem($name, $type, $price, $expiry) {
    $groceryItemsDetails = loadInventory();
    if (isset($groceryItemsDetails[$name])) {
        $groceryItemsDetails[$name] = [
            "type" => $type,
            "price" => $price,
            "expiry" => $expiry
        ];
        saveInventory($groceryItemsDetails);
    }
}

// Delete Item
function deleteItem($name) {
    $groceryItemsDetails = loadInventory();
    if (isset($groceryItemsDetails[$name])) {
        unset($groceryItemsDetails[$name]);
        saveInventory($groceryItemsDetails);
    }
}

// Handle form submissions for adding, editing, or deleting items
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name'])) {  // Adding new item
        $name = $_POST['name'];
        $type = $_POST['type'];
        $price = $_POST['price'];
        $expiry = $_POST['expiry'];
        addItem($name, $type, $price, $expiry);
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['edit'])) {  // Editing item
        $editItem = $_POST['edit'];

        // Retrieve item details to pre-fill the form (this is optional)
        $groceryItemsDetails = loadInventory();
        $item = $groceryItemsDetails[$editItem];
        $name = $editItem;
        $type = $item['type'];
        $price = $item['price'];
        $expiry = $item['expiry'];
    } elseif (isset($_POST['delete'])) {  // Deleting item
        $deleteItem = $_POST['delete'];
        deleteItem($deleteItem);
        header("Location: index.php");
        exit();
    }
}

// Load the current inventory
$groceryItemsDetails = loadInventory();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Store Management</title>
    <link rel="stylesheet" href="\Grocery Store Management System with PHP\Styles.css">
</head>
<body>
    <h1>Grocery Store Inventory</h1>

    <!-- Task 3: Form Section for Adding a New Item -->
    <section class="add-item-form">
        <h2>Add New Item</h2>
        <form method="POST" action="index.php">
            <label for="name">Item Name:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required><br>

            <label for="type">Type:</label>
            <input type="text" id="type" name="type" value="<?php echo isset($type) ? $type : ''; ?>" required><br>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo isset($price) ? $price : ''; ?>" required><br>

            <label for="expiry">Expiry Date:</label>
            <input type="date" id="expiry" name="expiry" value="<?php echo isset($expiry) ? $expiry : ''; ?>" required><br>

            <input type="submit" value="<?php echo isset($name) ? 'Edit Item' : 'Add Item'; ?>">
        </form>
    </section>

    <!-- Task 2: Inventory Section -->
    <section class="inventory">
        <h2>Current Inventory</h2>
        <?php
            // Display the inventory of grocery items
            displayInventory($groceryItemsDetails);
        ?>
    </section>
</body>
</html>
