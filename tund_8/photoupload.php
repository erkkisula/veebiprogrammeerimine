<?php
    require("functions.php");
    //kui pole sisse loginud

    if(!isset($_SESSION["userId"])){
        header("Location: index_new.php");
        exit();
    }

    //väljalogimine
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: index_new.php");
        exit();
    }

  //pildi upload
    $target_dir = "../picuploads/";
    $target_file = "";
    $imageFileType = "";
    $uploadOk = 1;
    if(isset($_POST["submitPic"])) {
        //kas faili nimi on olemas
        if(!empty($_FILES["fileToUpload"]["name"])){
            //määrab faili nime
            //$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            //$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
            //timestamp
            $timestamp = microtime(1) * 10000;
            //$target_file = $target_dir .basename($_FILES["fileToUpload"]["name"]) ."_" .$timestamp ."." .$imageFileType;
            $target_file = $target_dir ."vp_" .$timestamp ."." .$imageFileType;


            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "Fail on pilt - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File ei ole pilt";
                $uploadOk = 0;
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Pilt on juba olemas!";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 2500000) {
            echo "Fail on liiga suur (kuni 2,5mb)";
            $uploadOk = 0;
            }  

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Lubatud failitüübid on JPG, JPEG, PNG & GIF.";
            $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Fail ei laetud üles";
                // if everything is ok, try to upload file
                } else {
                    //sõltuvalt failitüübist loome pildiobjekti
                    if($imageFileType == "jpg" or $imageFileType == "jpeg"){
                        $myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
                    }
                    if($imageFileType == "png"){
                        $myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
                    }
                    if($imageFileType == "gif"){
                        $myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
                    }

                    //vaatame pildi og suuruse
                    $imageWidth = imagesx($myTempImage);
                    $imageHeight = imagesy($myTempImage);
                    //leian vajaliku suurendusfaktori
                    if($imageWidth > $imageHeight){
                        $sizeRatio = $imageWidth / 600;
                    }else{
                        $sizeRatio = $imageHeight / 400;
                    }

                    $newWidth = round($imageWidth / $sizeRatio);
                    $newHeight = round($imageHeight / $sizeRatio);
                    $myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);
                    //muudetud suurusega pilt kirjutatakse pildifailiks
                    if($imageFileType == "jpg" or $imageFileType == "jpeg"){
                        if(imagejpeg($myImage, $target_file, 90)){
                            echo "Korras!";
                        }else{
                            echo "Pahasti!";
                        }

                        if(imagepng($myImage, $target_file, 6)){
                            echo "Korras!";
                        }else{
                            echo "Pahasti!";
                        }
                        
                        if(imagegif($myImage, $target_file)){
                            echo "Korras!";
                        }else{
                            echo "Pahasti!";
                        }

                        imagedestroy($myTempImage);
                        imagedestroy($myImage);
                    }

                   /*  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üleslaetud.";
                    } else {
                        echo "Faili üleslaadimisel tekkis viga.";
                } */
            }
        }
    }





    //lehe style
    $stylestuff = userpageload($_SESSION["userId"]);
    $mydescription = $stylestuff[0];
    $mybgcolor = $stylestuff[1];
    $mytxtcolor = $stylestuff[2];
    $pageTitle = "Fotode üleslaadimine";

    require("header.php");
?>


	  <p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	  <hr>
      <p><a href="?logout=1">Logi välja! </a></b></p>
      <h2>Foto üleslaadimine</h2>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
        <label>Valige üleslaetav pilt:</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Lae pilt üles" name="submitPic">
      </form>
	
  </body>
</html>