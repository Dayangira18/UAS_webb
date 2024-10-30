<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Navigation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Global Styles */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 600px;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background: linear-gradient(145deg, #ffffff, #e6e6e6);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-weight: bold;
            color: #343a40;
            font-size: 1.8rem;
        }

        /* Form Styling */
        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .input-group-text {
            border: none;
            font-size: 1.2rem;
            background-color: #007bff;
            color: #fff;
        }

        .form-select {
            border: 1px solid #ced4da;
            border-radius: 0 0.375rem 0.375rem 0;
            padding: 10px;
        }

        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
        }

        /* Button Styling */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Card Hover Effect */
        .card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body">
            <h2 class="card-title mb-4 text-center">Admin Dashboard</h2>
            <form class="p-3">
                <div class="mb-3">
                    <label for="navigation" class="form-label"><strong>Navigate to:</strong></label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white"><i class="fas fa-compass"></i></span>
                        <select class="form-select" id="navigation" onchange="navigateToPage()">
                            <option value="" selected>Select a page</option>
                            <option value="article_crud.php">Article Management</option>
                            <option value="kategori.php">Category Management</option>
                        </select>
                        <button type="button" class="btn btn-primary" onclick="navigateToPage()">Go</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<script>
    function navigateToPage() {
        var select = document.getElementById('navigation');
        var selectedValue = select.value;
        if (selectedValue) {
            window.location.href = selectedValue;
        }
    }
</script>

</body>
</html>
