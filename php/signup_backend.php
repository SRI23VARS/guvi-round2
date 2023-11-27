<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'db_config.php';
require_once 'mongodb_config.php';
require_once 'redis_config.php';
$username = $_POST['username'];
$password = $_POST['password'];
if (empty($username) || empty($password)) {
    echo 'error';
    exit();
}
use MongoDB\Driver\Exception\Exception as MongoDBException;
use RedisException;
use MongoDB\Client as MongoDBClient;
use MongoDB\BSON\ObjectId;
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);
    $userId = $pdo->lastInsertId();
    $mongoClient = new MongoDBClient("mongodb://localhost:27017");
    $mongoDatabase = $mongoClient->selectDatabase('your_mongodb_database');
    $userProfilesCollection = $mongoDatabase->selectCollection('user_profiles');

    // Insert user profile data into MongoDB
    $userProfileData = [
        'user_id' => new ObjectId($userId),
        'profile_data' => [
            'Email' => null,  
        ],
    ];
    $userProfilesCollection->insertOne($userProfileData);
    $sessionId = uniqid('session_', true);
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->setex($sessionId, 3600, json_encode(['user_id' => $userId, 'username' => $username]));
echo $sessionId;
} catch (PDOException $e) {
    echo 'error';
    exit();
} catch (MongoDBException $e) {
    echo 'error';
    exit();
} catch (RedisException $e) {
    echo 'error';
    exit();
}
?>
