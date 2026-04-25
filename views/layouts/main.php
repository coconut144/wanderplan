<?php
/** @var string $content */
/** @var string $title */
/** @var array|null $trip */
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($title ?? 'WanderPlan') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&family=Sarabun:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<?php require BASE_PATH . '/views/partials/nav.php'; ?>

<?php require BASE_PATH . '/views/' . $content . '.php'; ?>

<script src="public/js/app.js"></script>
</body>
</html>