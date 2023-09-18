<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart Off-Canvas</title>
    <!-- Include Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Include Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="container">
        <h1>My Online Store</h1>
        <div class="row">
            <div class="col-md-6">
                <!-- Your product content goes here -->
                <h2>Product 1</h2>
                <p>Product Description</p>
                <p>$19.99</p>
                <button class="btn btn-primary" onclick="addToCart('Product 1')">Add to Cart</button>
            </div>
            <div class="col-md-6">
                <!-- Shopping cart icon to open the off-canvas cart -->
                <button class="btn btn-success" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas">
                    <i class="fa fa-shopping-cart"></i> View Cart <span id="cartItemCount" class="badge bg-primary">0</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 off-canvas for the shopping cart -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartCanvas" aria-labelledby="cartCanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="cartCanvasLabel">Shopping Cart</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul id="cartItems" class="list-group">
                <!-- Cart items will be displayed here -->
            </ul>
        </div>
        <div class="offcanvas-footer">
            <button id="removeSelected" type="button" class="btn btn-danger" onclick="removeSelectedItems()">Remove Selected</button>
            <button id="lendItems" type="button" class="btn btn-primary" onclick="lendSelectedItems()">Lend Items</button>
        </div>
    </div>

    <script>
        let cartItemCount = 0; // Initialize cart item count

        // JavaScript to handle adding items to the cart
        function addToCart(productName) {
            const cartItems = document.getElementById('cartItems');
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.innerHTML = `
                <div class="row">
                    <div class="col-1">
                        <input type="checkbox" class="form-check-input selectcheck" value="${productName}">
                    </div>
                    <div class="col-2">
                        <img src="your_image_url.jpg" alt="Book Image" class="img-fluid">
                    </div>
                    <div class="col-9">
                        <h6>${productName}</h6>
                        <p>Author: Author Name</p>
                        <p>Price: $19.99</p>
                    </div>
                </div>
            `;
            cartItems.appendChild(listItem);

            // Update cart item count
            cartItemCount++;
            document.getElementById('cartItemCount').textContent = cartItemCount;
        }

        // JavaScript to handle removing selected items from the cart
        function removeSelectedItems() {
            const checkboxes = document.querySelectorAll('.selectcheck:checked');
            checkboxes.forEach(function(checkbox) {
                checkbox.closest('li').remove();
                cartItemCount--; // Decrease cart item count
            });
            document.getElementById('cartItemCount').textContent = cartItemCount; // Update cart item count
        }

        // JavaScript to lend selected items
        function lendSelectedItems() {
            const checkboxes = document.querySelectorAll('.selectcheck:checked');
            const lendList = [];

            checkboxes.forEach(function(checkbox) {
                lendList.push(checkbox.value);
            });

            alert('Lending the following items: ' + lendList.join(', '));
        }
    </script>
</body>

</html>