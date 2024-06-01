<?php

class ImageHandler {
    private $imageArray = [];
    
    public function __construct() {
        // Initialize the image array with image file paths
        $this->initializeImages();
    }

    private function initializeImages() {
        // Assuming images are named image_1.jpg, image_2.jpg, etc.
        $directory = "path/to/your/images/directory/";
        $images = glob($directory . "image_*.jpg");

        // Sort the images based on filename
        sort($images);

        // Store the image file paths in the image array
        $this->imageArray = $images;
    }

    public function getNextImage() {
        // Check if there are images left in the array
        if (!empty($this->imageArray)) {
            // Get the first image from the array
            $nextImage = array_shift($this->imageArray);
            return $nextImage;
        } else {
            // Return a message indicating that all images are unlocked
            return "Yay! All images unlocked";
        }
    }
}

// Create an instance of the ImageHandler class
$imageHandler = new ImageHandler();

// Call getNextImage() function to get the next image file path
$imagePath = $imageHandler->getNextImage();

// Output the image path (or message) to be sent to the frontend
echo $imagePath;

?>
