<?php
require_once 'mongodb_config.php';
$userId = json_decode($_COOKIE['session'], true)['user_id'];
try {

    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $mongoDatabase = $mongoClient->selectDatabase('guvi');
    $userProfilesCollection = $mongoDatabase->selectCollection('login');

    $userProfile = $userProfilesCollection->findOne(['user_id' => new MongoDB\BSON\ObjectId($userId)]);

  
    echo '<p><strong>User :</strong> ' . $userProfile['user'] . '</p>';
    echo '<p><strong>Email:</strong> ' . $userProfile['profile_data']['email'] . '</p>';
  
} catch (MongoDB\Driver\Exception\Exception $e) {
   
    echo 'Error fetching profile details.';
    exit();
}
?>
