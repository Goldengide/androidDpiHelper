<?php 
 Class AndroidDpiHlepr{
    /*In the future this code should be able to support only image file 
    I mean to clean the bug that might occur due to the fact it doesnot support every image file now
    This code create different size of image given its location

    For the code to support avery image it must first recognize each image extension then use a condition 
    */
    public $destination_base_url = "";
    public $filepath;
    public $destinationDirectory;
    public $folderCode;
    /*
        @params file
    */
    public function __construct($destinationDirectory, $folderCode){
        /*
            folderCode   
                        0: drawable only
                        1: mipmap only
                        2: drawable and mipmap
        */
        $this->folderCode = $folderCode;
        $this->destinationDirectory = $destinationDirectory;
    }
    public function resizeImage($filepath) {
        // File and new size
        if (is_file($filepath)) {
           
            $dir_name = $this->destinationDirectory;

            $drawable_dpi = array();
            $drawable_dpi['drawable-ldpi'] = 0.1875;
            $drawable_dpi['drawable-mdpi'] = 0.25;
            $drawable_dpi['drawable-hdpi'] = 0.375;
            $drawable_dpi['drawable-xhdpi'] = 0.5;
            $drawable_dpi['drawable-xxhdpi'] = 0.75;
            $drawable_dpi['drawable-xxxhdpi'] = 1.0;

            $mipmap_dpi = array();
            $mipmap_dpi['mipmap-ldpi'] = 0.1875;
            $mipmap_dpi['mipmap-mdpi'] = 0.25;
            $mipmap_dpi['mipmap-hdpi'] = 0.375;
            $mipmap_dpi['mipmap-xhdpi'] = 0.5;
            $mipmap_dpi['mipmap-xxhdpi'] = 0.75;
            $mipmap_dpi['mipmap-xxxhdpi'] = 1.0;

            $selected_dpi = array();
            if($this->folderCode == 0) {
                $selected_dpi = $drawable_dpi; 
            }
            if($this->folderCode == 1) {
                $selected_dpi = $mipmap_dpi; 
            }
            if($this->folderCode == 2) {
                $selected_dpi = array_merge($drawable_dpi, $mipmap_dpi); 
            }


            // Content type
            $image_ext = "png";
            header('"Content-Type: image/"'.$image_ext);

            // Get new sizes
            $dir_path = $this->dirHelper($dir_name);
            $imageFileName = $this->extract_file_name($filepath);
            $final_dir_path = $dir_path."res/"; 
            if (!is_dir($final_dir_path)) {
                mkdir($final_dir_path);
            }
            foreach ($selected_dpi as $key => $value) {
                if (!is_dir($final_dir_path.$key)) {
                    mkdir($final_dir_path.$key);
                }
                list($width, $height) = getimagesize($filepath);
                $newwidth = $width * $value;
                $newheight = $height * $value;

                // Load
                $thumb = imagecreatetruecolor($newwidth, $newheight);
                $source = imagecreatefrompng($filepath);

                // Resize
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                imagepng($thumb, $final_dir_path.$key."/".$imageFileName);
            }
            echo "<h1>$filepath has been resized into different sizes</h1>";
        }
        elseif(!file_exists($filepath)) {
            echo "<h1>Invalid File path</h1>";
        }
         else {
            echo "<h1>This is not a file</h1>";
        }

    }

    public function dirHelper($dir_name) {
        $split = explode("/", $dir_name);
       
        $dir_path = "";
        foreach ($split as $key => $value) { 
            $dir_path .= $value."/";
            if (!is_dir($dir_path)) {
                mkdir($dir_path);
            }
        }
        return $dir_path;

    }

    public function extract_file_name($path) {
        $split = explode("/", $path);
        $last =   $split[count($split)-1];
        // var_dump($split);
        return $last;
    }

}


?>