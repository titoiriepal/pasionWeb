<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Pasión Viviente de Iriépal'; ?></title>
    <script src="https://kit.fontawesome.com/7d96e566c4.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Rancho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body id="body">
    <?php  include_once __DIR__ . '/templates/header.php'; ?>
    <?php echo $contenido; ?>
    <?php  include_once __DIR__ . '/templates/footer.php'; ?>
    <?php echo $script ?? ''; ?>
            
</body>
</html>