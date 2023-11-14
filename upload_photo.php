<?php

$photo = $_FILES['photo'];

$photo_name = basename($photo['name']);

$photo_path = 'member_photos/' . $photo_name;

$allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

$extension = pathinfo($photo_name, PATHINFO_EXTENSION);

if(in_array($extension, $allowed_extensions) && $photo['size'] < 2000000) {
    move_uploaded_file($photo['tmp_name'], $photo_path);

    echo json_encode(['success' => true, 'photo_path' => $photo_path]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid file']);
}