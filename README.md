# Grocery Store Management System

## Overview
This lab is a simple web-based Grocery Store Management System developed using PHP and HTML. It allows users to:
1. View the grocery items in an inventory.
2. Add new items to the inventory, including item name, type, price, and expiry date.
3. Check whether an item is expired or still valid based on the expiry date.

## Features
- **Display Inventory**: Shows a table of grocery items with details such as name, type, price, expiry date, and expiry status.
- **Add New Item**: A form allows users to add new items with their respective details.
- **Expiry Check**: Each item’s expiry date is checked, and a notification (Expired/Valid) is shown in the inventory.

## Task Breakdown
### Task 1: Setting Up Grocery Item Arrays
- Created an indexed array to store grocery item names.
- Developed an associative array to store the details for each item, including type, price, and expiry date.

### Task 2: Displaying the Grocery Inventory
- Implemented a function (`displayInventory()`) to display the grocery inventory in an HTML table.
- Showed item details such as name, type, price, expiry date, and expiry status.

### Task 3: Adding New Items
- Created a form where users can input new item details (name, type, price, and expiry date).
- Developed a function (`addItem()`) to add new items to the inventory array.

### Task 4: Expiry Date Check
- Created a function (`checkExpiry()`) to check whether an item has expired or is still valid.
- Displayed a notification (Expired/Valid) in the inventory table for each item.

## Assumptions
- The inventory is initially predefined with a set of grocery items.
- The current date is used for expiry checks.

## Challenges Faced
1. **Form Handling**: Ensuring that the added item is correctly displayed in the inventory after form submission required redirecting the page.
2. **Expiry Date Logic**: Correctly comparing dates in PHP using `strtotime()` and ensuring it works across different date formats was a bit tricky.

## How to Run
1. Download the project files.
2. Place them on your local server (e.g., XAMPP, WAMP).
3. Open `index.php` in your browser.
4. You can add, view, and check expiry status for grocery items.
