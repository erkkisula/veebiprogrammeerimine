<?php
    class Photoupload{
        private $tempName;
        private $imageFileType;
        private $myTempImage;

        function __construct($tmpPic, $type){
            $this->tempName = $tmpPic;
            $this->imageFileType = $type;
            $this->createImageFromFile();
        }

        function __destruct(){
            imagedestroy($this->myTempImage);
            imagedestroy($this->myImage);
        }

        private function createImageFromFile(){
            if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
                $this->myTempImage = imagecreatefromjpeg($this->tempName);
            }
            if($this->imageFileType == "png"){
                $this->myTempImage = imagecreatefrompng($this->tempName);
            }
            if($this->imageFileType == "gif"){
                $this->myTempImage = imagecreatefromgif($this->tempName);
            }
        }

        public function resizeImage($width, $height){
            $imageWidth = imagesx($this->myTempImage);
            $imageHeight = imagesy($this->myTempImage);
            //leian vajaliku suurendusfaktori
            if($imageWidth > $imageHeight){
                $sizeRatio = $imageWidth / $width;
            }else{
                $sizeRatio = $imageHeight / $height;
            }

            $newWidth = round($imageWidth / $sizeRatio);
            $newHeight = round($imageHeight / $sizeRatio);
            $this->myImage = $this->changePicSize($this->myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);
        }

        private function changePicSize($image, $ow, $oh, $w, $h){
            $newImage = imagecreatetruecolor($w, $h);
            imagecopyresampled($newImage, $image, 0, 0, 0, 0,$w, $h, $ow, $oh);
            return $newImage;
        }

        public function addWaterMark(){
            $waterMark = imagecreatefrompng("../vp_picfiles/vp_logo_w100_overlay.png");
            $waterMarkWidth = imagesx($waterMark);
            $waterMarkHeight = imagesy($waterMark);
            $waterMarkPosX = imagesx($this->myImage) - $waterMarkWidth - 10;
            $waterMarkPosY = imagesy($this->myImage) - $waterMarkHeight -10;
            //kopeerine vesimärgi pildile
            imagecopy($this->myImage, $waterMark, $waterMarkPosX, $waterMarkPosY, 0, 0, $waterMarkWidth, $waterMarkHeight);
        }

        public function addText(){
            $textToImage = "Veebiprogrammeerimine";
            $textColor = imagecolorallocatealpha($this->myImage, 255, 255, 255, 60);
            //alpha on 0-127
            imagettftext($this->myImage, 20, -45, 10, 25, $textColor, "../vp_picfiles/ARIALBD.TTF", $textToImage);
        }

        public function savePhoto($targetFile){
            $notice = "";

            if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
                if(imagejpeg($this->myImage, $targetFile, 90)){
                    $notice = 1;
                    //kui pilt salvestati, siis lisame andmebaasi
                    //addPhotoData($target_file_name, $_POST["alttekst"], $_POST["privacy"]);
                }else{
                    $notice = 0;
                }
            }

            if($this->imageFileType == "png"){
                if(imagepng($this->myImage, $targetFile, 6)){
                    $notice = 1;
                    //kui pilt salvestati, siis lisame andmebaasi
                    //addPhotoData($target_file_name, $_POST["alttekst"], $_POST["privacy"]);
                }else{
                    $notice = 0;
                }
            }

            if($this->imageFileType == "gif"){
                if(imagegif($this->myImage, $targetFile)){
                    $notice = 1;
                    //kui pilt salvestati, siis lisame andmebaasi
                    //addPhotoData($target_file_name, $_POST["alttekst"], $_POST["privacy"]);
                }else{
                    $notice = 0;
                }
            }

            return $notice;
        }
    }

?>