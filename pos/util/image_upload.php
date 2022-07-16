<?php

class ImageUpload{
    private $target_dir;
    private $target_file;
    private $file_extention;
    private $file_name;
    
    public $max_width=1366;
    public $max_height=768;
    public $quality=100;
            
    private $errors=array();
    
    public $upload_errors=array(
        UPLOAD_ERR_OK=>"No errors.",
        UPLOAD_ERR_INI_SIZE=>"Larger than upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE=>"Larger than form MAX_FILE_SIZE.",
        UPLOAD_ERR_PARTIAL=>"Partial upload.",
        UPLOAD_ERR_NO_FILE=>"No file.",
        UPLOAD_ERR_NO_TMP_DIR=>"No temporary directory.",
        UPLOAD_ERR_CANT_WRITE=>"can't write to disk.",
        UPLOAD_ERR_EXTENSION=>"File upload stopped by extention."
    );

    private function get_extension($file){
//        $temp = explode(".", $file["name"]);
//        return end($temp);
        $this->file_extention=pathinfo(basename($file["name"]),PATHINFO_EXTENSION); 
        return $this->file_extention; 
    }
    
    private function generate_new_name($new_name,$file){
        $new_name=$new_name.".".$this->get_extension($file);
        $this->file_name=$new_name;
        return $this->file_name;
    }
    
    private function generate_target_file($target_dir,$file){
        $uniqe_file_name=uniqid();
        
        $temp_file_name=$uniqe_file_name;
        $new_file_name=$this->generate_new_name($temp_file_name,$file);
        $temp_target_file = $target_dir.$new_file_name;
        
        $count=0;
        while(true){
            $count++;
            if (file_exists($temp_target_file)) {
                $temp_file_name=$temp_file_name."(".$count.")";
                $new_file_name=$this->generate_new_name($temp_file_name,$file);
                $temp_target_file = $target_dir.$this->$new_file_name;
            }else{
                break;
            }
        }
        
        $this->file_name=$new_file_name;
        $this->target_file=$temp_target_file;
        return $this->target_file;
    }
    
    private function set_target_dir($dir){
        if (!file_exists($dir) && !is_dir($dir)) {
            if(mkdir($dir)){
                $this->target_dir=$dir;
            }         
        }else{
            $this->target_dir=$dir;
        } 
        
        return $this->target_dir;
    }
    
    private function get_errors($file){
        $errors=array();
        
        $check = getimagesize($file["tmp_name"]);
        if(!$check) {
            $errors[]="File is not an image";
        }
        
        if ($file["size"] > 5000000) {
            $errors[]="File is too large";    
        }
        
        if($file["type"] != "image/jpeg" && $file["type"] != "image/png" && $file["type"] != "image/gif" && $file["type"] != "image/pjpeg" ) {
            $errors[]="Sorry, only JPG, JPEG, PNG & GIF files are allowed";
        }
        
        return $errors;
    }
    
    private function initialize_image($file,$target_dir){
        $this->set_target_dir($target_dir);
        $this->generate_target_file($this->target_dir, $file);
        $errors= $this->get_errors($file);
        if(empty($errors)){
            return true;
        }else{
            throw new Exception(join(", ",$errors));
        }
    }
    
    public function upload_image($file,$target_dir="./uploads/"){
        if($file["error"]==0){
            try {
                $this->initialize_image($file,$target_dir);
                if ($this->resizeImage($file, $this->max_width, $this->max_height, $this->target_file, $this->quality)) {
                    return $this->file_name;
                } else {
                    throw new Exception("Could not upload image:".$file["name"]);
                }
            } catch (Exception $exc) {
                throw new Exception($exc);
            }
        }else{
            throw new Exception($this->upload_errors[$file["error"]]);
        }
        
    }
    
    private function resizeImage($fileToUpload, $max_width, $max_height, $target_file, $quality){
        switch(strtolower($fileToUpload['type'])){
            case 'image/jpeg':
                $image = imagecreatefromjpeg($fileToUpload['tmp_name']);
                break;
            case 'image/png':
                $image = imagecreatefrompng($fileToUpload['tmp_name']);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($fileToUpload['tmp_name']);
                break;
            default:
                exit('Unsupported type: '.$fileToUpload['type']);
        }

        // Get current dimensions
        $old_width = imagesx($image);
        $old_height = imagesy($image);

        // Calculate the scaling we need to do to fit the image inside our frame
        $scale = min($max_width/$old_width, $max_height/$old_height);

        // Get the new dimensions
        $new_width  = ceil($scale*$old_width);
        $new_height = ceil($scale*$old_height);
        
        // Create new empty image
        $new = imagecreatetruecolor($new_width, $new_height);

        // Resize old image into new
        imagecopyresampled($new, $image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);
        
        if($old_width>$max_width || $old_height>$max_height){
            return imagejpeg($new, $target_file, $quality);
        }else{
            return move_uploaded_file($fileToUpload["tmp_name"], $target_file);
        }        
        
        if($image){
            imagedestroy($image);
        }
        imagedestroy($new);
    }
    
}

?>