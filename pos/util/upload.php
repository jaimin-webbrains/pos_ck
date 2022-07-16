<?php
require_once __DIR__.'/database.php';

class Upload {
    public $filename;
    public $type;
    public $size;
    public $caption;
    public $status;
    
    private $temp_path;
    protected $upload_dir;
    public $errors=array();
    
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
    
    function __construct($file) {
        initialise_file($file);
    }
    
    public function initialise_file($file){
        if(!$file || empty($file) || !is_array($file)){
            $this->errors[]="No file was uploaded.";
            return FALSE;
        }elseif($file["error"]!=0){
            $this->errors[]= $this->upload_errors[$file["error"]];
            return FALSE;
        }else{
            $this->temp_path=$file["tmp_name"];
            $this->filename= basename($file["name"]);
            $this->type=$file["type"];
            $this->size=$file["size"];
            return TRUE;
        }
    }
    
    public function save(){
        if(isst){
            
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    




//    private function get_upload_status($upload_error_no){
//        switch($upload_error_no){
//            case 0 : return 'The file is ok';
//            case 1 : return 'The file exceeds the upload_max_filesize directive in php.ini.';
//            case 2 : return 'The file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
//            case 3 : return 'The file was only partially uploaded.';
//            case 4 : return 'No file was uploaded.';
//            case 5 : return 'Missing a temporary folder.';
//            case 6 : return 'Failed to write file to disk.';
//        }
//    }

    
    
//    $target_dir = "images/main_images/";
//    $files_to_upload=$_FILES["fileToUpload"];
//    $target_file = $target_dir . basename($files_to_upload["name"]);
    
    public function upolad_file($target_dir,$files_to_upload){
        if($file["error"]==0){
//            original file name
//            $target_file = $target_dir . basename($file["name"]);
            
            $target_file = $this->generate_target_file($target_dir,$files_to_upload);
            if(move_uploaded_file($files_to_upload["tmp_name"], $target_file)){
                return $file["error"];
            }else{
                return false;
            }
        }else{
            return $file["error"];
        }
    }
    
    private function get_extension($file){
        $temp = explode(".", $file["name"]);
        return end($temp);
    }
    
    private function generate_new_name($file){
        $new_name=uniqid().$this->get_extension($file);
    }
    
    private function generate_target_file($target_dir,$file){
        $target_file = $target_dir.$this->generate_new_name($file);
        return $target_file;
    }
    
    
    private function get_upload_files_errors($file_array){
        $errors=array();
        foreach ($file_array as $index=>$file){
            if($file["error"]!=0){
                $error=array();
                $error["index"]=$index;
                $error["error"]=get_upload_status($file["error"]);
                $errors[]=$error;
            }
        }
        return $errors;
    }

    public function upolad_files($target_dir,$files_to_upload){
        $file_array=reArrayFiles($files_to_upload);
        $file_count=count($file_array);
        
        $upload_errors=array();
        $upload_errors["files_errors"]=get_upload_files_errors($file_array);
        $upload_errors["files_move_errors"]="";
        
        if(empty($upload_errors["files_errors"])){
            $uploaded=array();
            foreach ($file_array as $index=>$file){
                $target_file=generate_target_file($target_dir,$file);
                if(move_uploaded_file($file["tmp_name"], $target_file)){
                    $uploaded[]=$index;
                }else{
                    $error=array();
                    $error["index"]=$index;
                    $upload_errors["files_move_errors"][]=$error;
                }
            }
            
            if(count($uploaded)!=$file_count){
                foreach ($uploaded as $value){
                    $target_file=generate_target_file($target_dir,$file_array[$value]);
                    if (file_exists($target_file)) {
                        unlink($target_file);
                    }
                }
            }
            
        }
        
        return $upload_errors;
    }
    
    public function reArrayFiles($files_to_upload) {
        $file_array = array();
        $file_count = count($files_to_upload['name']);
        $file_keys = array_keys($files_to_upload);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_array[$i][$key] = $files_to_upload[$key][$i];
            }
        }

        return $file_array;
    }
    
    
    
    
    
    
}
?>
