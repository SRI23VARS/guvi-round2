<?php
require_once 'db_config.php';
require 'vendor/autoload.php';

use Predis\Client;
$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    echo 'error';
    exit();
}
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
 if ($user) {
        $sessionId = uniqid('session_', true);
        $redis = new Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);
        $redis->setex($sessionId, 3600, json_encode($user));

        echo $sessionId;
    } else {
   
        echo 'error';
    }
} catch (PDOException $e) {
   
    echo 'error';
    exit();
}
?>
