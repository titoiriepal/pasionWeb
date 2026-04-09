<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Página web de la pasión Viviente de Iriepal" />
    <meta name="keywords" content="pasion viviente, pasión viviente de Iriépal, <?php echo $keywords ?? '' ?>" />
    <meta name="author" content="Jesús Ramos Sánchez" />
    <title><?php echo $title ?? 'Pasión Viviente de Iriépal'; ?></title>
    <!-- <script src="https://kit.fontawesome.com/7d96e566c4.js" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Rancho&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="/build/css/app.css">
    <link rel="icon" href="/build/iconos/img/favicon.ico" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="32x32" href="/build/img/iconos/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/build/img/iconos/favicon-16x16.png">
</head>

<body id="body">
    <?php include_once __DIR__ . '/templates/header.php'; ?>
    <main>
        <h1 class="visually-hidden"><?php echo $h1 ?? 'Pasión Viviente de Iriépal'; ?></h1>
        <?php echo $contenido; ?>
    </main>
    <?php include_once __DIR__ . '/templates/footer.php'; ?>
    <?php echo $script ?? ''; ?>

</body>

</html>