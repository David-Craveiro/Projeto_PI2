<?php
require_once __DIR__ . '/../includes/auth.php';
logout();
header('Location: /src/pages/client/index.php');
exit;
