<?php

// Create sample images for brands, categories, and products
// This script creates simple colored placeholder images

function createImage($width, $height, $color, $text, $filename) {
    $image = imagecreate($width, $height);
    
    // Define colors
    $bg = imagecolorallocate($image, hexdec(substr($color, 1, 2)), hexdec(substr($color, 3, 2)), hexdec(substr($color, 5, 2)));
    $text_color = imagecolorallocate($image, 255, 255, 255);
    
    // Add text
    $font = 5; // Built-in font
    $text_width = imagefontwidth($font) * strlen($text);
    $text_height = imagefontheight($font);
    $x = ($width - $text_width) / 2;
    $y = ($height - $text_height) / 2;
    
    imagestring($image, $font, $x, $y, $text, $text_color);
    
    // Save image
    imagepng($image, $filename);
    imagedestroy($image);
}

// Brand logos
$brands = [
    ['name' => 'Apple', 'color' => '#000000'],
    ['name' => 'Samsung', 'color' => '#1428A0'],
    ['name' => 'Sony', 'color' => '#000000'],
    ['name' => 'LG', 'color' => '#A50034'],
    ['name' => 'Dell', 'color' => '#007DB8'],
    ['name' => 'HP', 'color' => '#0096D6'],
    ['name' => 'Lenovo', 'color' => '#E2231A'],
    ['name' => 'Microsoft', 'color' => '#00BCF2'],
    ['name' => 'Google', 'color' => '#4285F4'],
    ['name' => 'Bose', 'color' => '#000000'],
];

foreach ($brands as $brand) {
    createImage(200, 200, $brand['color'], $brand['name'], "storage/app/public/brands/{$brand['name']}.png");
}

// Category images
$categories = [
    ['name' => 'Electronics', 'color' => '#FF6B6B'],
    ['name' => 'Smartphones', 'color' => '#4ECDC4'],
    ['name' => 'Laptops', 'color' => '#45B7D1'],
    ['name' => 'Tablets', 'color' => '#96CEB4'],
    ['name' => 'Audio', 'color' => '#FFEAA7'],
    ['name' => 'Gaming', 'color' => '#DDA0DD'],
];

foreach ($categories as $category) {
    createImage(300, 200, $category['color'], $category['name'], "storage/app/public/categories/{$category['name']}.png");
}

// Product images
$products = [
    ['name' => 'iPhone 15 Pro', 'color' => '#2C3E50'],
    ['name' => 'MacBook Pro M3', 'color' => '#34495E'],
    ['name' => 'Samsung Galaxy S24', 'color' => '#3498DB'],
    ['name' => 'Dell XPS 13', 'color' => '#E74C3C'],
    ['name' => 'iPad Air', 'color' => '#9B59B6'],
];

foreach ($products as $product) {
    createImage(400, 300, $product['color'], $product['name'], "storage/app/public/products/{$product['name']}.png");
}

echo "Sample images created successfully!\n";
