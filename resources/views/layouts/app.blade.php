<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Hoa Quả</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f6f6f6;
        }
        h1 {
            color: #2c3e50;
        }
        .fruit-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 220px;
            text-align: center;
        }
        .fruit-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 6px;
        }
        .badge {
            display: inline-block;
            background-color: #e74c3c;
            color: white;
            padding: 4px 8px;
            margin-bottom: 6px;
            border-radius: 4px;
            font-size: 12px;
        }
        .premium-border {
            border: 2px solid gold;
        }
        .organic-label {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>

@yield('content')

</body>
</html>
@vite(['resources/css/app.css', 'resources/js/app.js'])
