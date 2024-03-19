<?php 

$title = 'Add product';
require_once '../include/configs.php';
require_once '../include/sanitize-input.php';
require_once '../include/connection.php';
require_once '../include/unique-code-generator.php';
require_once '../include/image-resizer.php';

$errors[];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Sanitize input values
    $name = sanitizeInput($_POST["name"]);
    $category = sanitizeInput($_POST["category"]);
    $description = sanitizeInput($_POST["description"]);
    $price = sanitizeInput($_POST["price"]);
    $quantity = sanitizeInput($_POST["quantity"]);
    $size = sanitizeInput($_POST["size"]);

    // Validation for product name
    if (empty($name)) 
    {
        $errors['name'] = "Product name is required.";
    }

    // Validation for description
    if (empty($description)) 
    {
        $errors['description'] = "Description is required.";
    }

    // Validation for price
    if (!is_numeric($price) || $price <= 0) 
    {
        $errors['price'] = "Price must be a positive number.";
    }

    // Validation for quantity
    if (!is_numeric($quantity) || $quantity <= 0) 
    {
        $errors['quantity'] = "Quantity must be a positive number.";
    }

    // Validation for size
    if (!is_numeric($size) || $size <= 0) 
    {
        $errors['size'] = "Size must be a positive number.";
    }

    // Validation for images
    $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
    $maxSize = 2 * 1024 * 1024; // 2MB
    foreach ($_FILES["images"]['name'] as $key => $value) 
    {
        $imageType = $_FILES["images"]['type'][$key];
        $imageSize = $_FILES["images"]['size'][$key];
        if (!in_array($imageType, $allowedTypes)) 
        {
            $errors['images'] = "Invalid file type.";
            break;
        }

        if ($imageSize > $maxSize) 
        {
            $errors['images'] = "Invalid image size, maximum file size is 2mb.";
            break;
        }
    }

    if (empty($errors)) 
    {

        // Insert other form data into database
        // You'll need to replace this with your database logic
        $query = "INSERT INTO products SET name =:name, description = :description, price = :price, quantity = :quantity, size = :size, skn = :skn";
        $stmt = $conn->prepare($query);
        $stmt->bindparam(':name', $name, PDO::PARAM_STR);
        $stmt->bindparam(':category', $category, PDO::PARAM_STR);
        $stmt->bindparam(':description', $description, PDO::PARAM_STR);
        $stmt->bindparam(':price', $price, PDO::PARAM_STR);
        $stmt->bindparam(':quantity', $quantity, PDO::PARAM_STR);
        $stmt->bindparam(':size', $size, PDO::PARAM_STR);
        $stmt->bindparam(':skn', $skn, PDO::PARAM_STR);

        //$stmt->bindparam(':price', $price, PDO::PARAM_STR);
        if ($stmt->execute()) 
        {
            $product_id = $stmt->$lastInsertId; // Initialize product ID

            // Resize and save images
            foreach ($_FILES["images"]['tmp_name'] as $key => $tmpName) 
            {
                // Resize image
                $fileName = $category. '-' .$product_id. '-' .$_FILES["images"]['name'][$key].'-'.uniqid();
                $destination_folder = 'uploads/';

                //check if the folder already exist
                if (is_dir($destination_folder) === false )
                {
                    mkdir($destination_folder, 0777, true);
                }

                $destination = $destination_folder . $fileName;

                // Insert image name and product ID into image table
                $query = "INSERT INTO products_image SET image_name =:image_name, product_id = :product_id";
                $stmt = $conn->prepare($query);
                $stmt->bindparam(':image_name', $image_name, PDO::PARAM_STR);
                $stmt->bindparam(':product_id', $product_id, PDO::PARAM_STR);
                $stmt->execute();
                resizeImage($tmpName, $destination, 200, 200);
            }

        }


        // Redirect or return success message
        $response = array('success' => true, 'message' => 'Product added successfully.');
        echo json_encode($response);
    } 
    else 
    {
        // Return errors
        $response = array('success' => false, 'errors' => $errors);
        echo json_encode($response);
    }
} 
else 
{
    // If not a POST request, redirect
    header("Location: index.php");
    exit();
}

?>

<?php require_once '../include/header.php'; ?>



<div class="main-content">

    <div class="form-container">
        <div class="form-logo">
            <img src="<?php echo BASE_URL ?>/image/logo.jpeg" alt="Z Lifestyle Logo">
            <h2>Add Product</h2>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" id='add-product-form'>

            <div id="uploadedImages" class="uploaded-images"></div>

            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name">
                <?php if (!empty($errors['name'])): ?>
                    <p class="error"><?php echo $errors['name']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category">
                    <option value="" >Select Category</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['category_id']; ?>">
                            <?php echo $category['category_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['category'])): ?>
                    <p class="error"><?php echo $errors['category']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price">
                <?php if (!empty($errors['price'])): ?>
                    <p class="error"><?php echo $errors['price']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity">
                <?php if (!empty($errors['quantity'])): ?>
                    <p class="error"><?php echo $errors['quantity']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="size">Size:</label>
                <input type="number" id="size" name="size">
                <?php if (!empty($errors['size'])): ?>
                    <p class="error"><?php echo $errors['size']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" cols="50"></textarea>
                <?php if (!empty($errors['description'])): ?>
                    <p class="error"><?php echo $errors['description']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="product_image">Product Image:</label>
                <input type="file" id="product_image" name="product_image" multiple>
                <?php if (!empty($errors['product_image'])): ?>
                    <p class="error"><?php echo $errors['product_image']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="submit" name="submit_add_product" value="Add Product" id="submit-add-product">
            </div>

        </form>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() 
    {
    var imagesInput = document.getElementById('images');
    var imagePreview = document.getElementById('image-preview');
    var uploadedImages = []; // Array to store uploaded image files
    var formSubmitted = false; // Flag to prevent multiple form submissions

        // Function to show uploaded images
        function showUploadedImages() 
        {
            imagePreview.innerHTML = ''; // Clear previous images
            uploadedImages.forEach(function(file, index) 
            {
                var imageContainer = document.createElement('div');
                imageContainer.classList.add('image-container');

                var imageElement = document.createElement('img');
                imageElement.src = URL.createObjectURL(file);
                imageElement.style.maxWidth = '200px';
                imageElement.style.maxHeight = '200px';
                imageContainer.appendChild(imageElement);

                var deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.addEventListener('click', function() 
                {
                    uploadedImages.splice(index, 1); // Remove image file from array
                    showUploadedImages(); // Update UI
                });
                imageContainer.appendChild(deleteButton);

                imagePreview.appendChild(imageContainer);
            });
        }


        // Update UI when input file is changed
        imagesInput.addEventListener('change', function() 
        {
            var files = this.files;
            for (var i = 0; i < files.length; i++) 
            {
                var file = files[i];
                if (validateFile(file)) 
                {
                    uploadedImages.push(file); // Add new files to the array
                } 
                else 
                {
                    var errorDisplay = document.getElementById('error-images');
                    if (errorDisplay) 
                    {
                        errorDisplay.textContent = 'Invalid file type or size for images.';
                    }
                }
            }
            showUploadedImages(); // Update UI
        });



        // Validate file type and size
        function validateFile(file) 
        {
            var allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
            var maxSize = 2 * 1024 * 1024; // 2MB
            return allowedTypes.includes(file.type) && file.size <= maxSize;
        }


        var addProductForm = document.getElementById('add-product-form');
        addProductForm.addEventListener('submit', function(event) 
        {
            if (formSubmitted) 
            {
              event.preventDefault();
              return;
            }
            formSubmitted = true;

            event.preventDefault();

            // Disable submit button to prevent multiple submissions
            var submitButton = addProductForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;

            // Validate form fields
            var errors = validateForm();
            if (Object.keys(errors).length > 0) 
            {
                // Display errors on form field divs
                Object.keys(errors).forEach(function(key) 
                {
                    var errorDiv = document.getElementById('error-' + key);
                    if (errorDiv) 
                    {
                        errorDiv.textContent = errors[key];
                    }
                });

                // Enable submit button
                submitButton.disabled = false;
                formSubmitted = false; // Reset flag
                return;
            }

            // Add form fields to FormData
            var formData = new FormData(addProductForm);

            // Append uploaded images to FormData
            uploadedImages.forEach(function(file, index) 
            {
                formData.append('images[]', file);
            });

            // Example AJAX request to send formData to server
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'process-add-product.php');
            xhr.onload = function() 
            {
                if (xhr.status === 200) 
                {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) 
                    {
                        alert(response.message);
                        // Reset form after successful submission
                        addProductForm.reset();
                        uploadedImages = []; // Reset array
                        showUploadedImages(); // Update UI
                    } 
                    else 
                    {
                        var errors = response.errors;
                        Object.keys(errors).forEach(function(key) 
                        {
                        var errorDiv = document.getElementById('error-' + key);
                            if (errorDiv) 
                            {
                                errorDiv.textContent = errors[key];
                            }
                        });
                    }
                } 
                else 
                {
                    alert('An error occurred. Please try again.');
                }
                // Enable submit button after request completes
                submitButton.disabled = false;
                formSubmitted = false; // Reset flag
            };

                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.send(formData);
        });

        // Validate form fields
        function validateForm() 
        {
            var errors = {};
            var name = addProductForm.elements['name'].value.trim();
            var description = addProductForm.elements['description'].value.trim();
            var price = addProductForm.elements['price'].value.trim();
            var quantity = addProductForm.elements['quantity'].value.trim();
            var size = addProductForm.elements['size'].value.trim();

            if (name === '') 
            {
              errors['name'] = 'Product name is required.';
            }

            if (description === '') 
            {
              errors['description'] = 'Description is required.';
            }

            if (price === '' || isNaN(price) || parseFloat(price) <= 0) 
            {
              errors['price'] = 'Price must be a positive number.';
            }

            if (quantity === '' || isNaN(quantity) || parseInt(quantity) <= 0) 
            {
              errors['quantity'] = 'Quantity must be a positive number.';
            }

            if (size === '' || isNaN(size) || parseFloat(size) <= 0) 
            {
              errors['size'] = 'Size must be a positive number.';
            }

            return errors;
        }

        // Clear error message on form field focus
        var formFields = addProductForm.querySelectorAll('input, textarea');
        formFields.forEach(function(field) 
        {
            field.addEventListener('focus', function() 
            {
                var errorDiv = document.getElementById('error-' + field.name);
                if (errorDiv) 
                {
                    errorDiv.textContent = '';
                }
            });
        });

        // Clear error message on input file change
        imagesInput.addEventListener('change', function() 
        {
            var errorDisplay = document.getElementById('error-images');
            if (errorDisplay) 
            {
                errorDisplay.textContent = '';
            }
        });

            // Initial call to show uploaded images (if any)
            showUploadedImages();
    });


</script>

<?php require_once '../include/footer.php'; ?>