<?php
  require("functions.php");
  //kui pole sisse loginud

  //$mydescription = "Siia tuleb tekst";
  //$mybgcolor = "#FFFFFF";
  //$mytxtcolor = "#000000";

  $stylestuff = userpageload($_SESSION["userId"]);
  $mydescription = $stylestuff[0];
  $mybgcolor = $stylestuff[1];
  $mytxtcolor = $stylestuff[2];

  //echo $stylestuff[1];

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

   //kinnitamine algab
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	  if (isset($_POST["submitUserData"])){
		  if (isset($_POST["description"])){
			  if (isset($_POST["bgcolor"])){
          if (isset($_POST["txtcolor"])){
            userpagesave($_SESSION["userId"], $_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
          }
			  } 
		  }
	  }
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
          $target_file_name = "pp_".$_SESSION["userFirstName"] ."_" .$_SESSION["userLastName"] ."_" .$timestamp ."." .$imageFileType;
          $target_file = $target_dir .$target_file_name;



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
                  $sizeRatioW = $imageWidth / 300;
                  $sizeRatioH = $imageHeight / 300;
                  

                  $newWidth = round($imageWidth / $sizeRatioW);
                  $newHeight = round($imageHeight / $sizeRatioH);
                  $myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);              


                  //muudetud suurusega pilt kirjutatakse pildifailiks
                  if($imageFileType == "jpg" or $imageFileType == "jpeg"){
                      if(imagejpeg($myImage, $target_file, 90)){
                          echo "Korras!";
                          addProfilePic($target_file);
                          //kui pilt salvestati, siis lisame andmebaasi
                          //addPhotoData($target_file_name, $_POST["alttekst"], $_POST["privacy"]);
                      }else{
                          echo "Pahasti!";
                      }
                  }

                  if($imageFileType == "png"){
                      if(imagepng($myImage, $target_file, 6)){
                          echo "Korras!";
                      }else{
                          echo "Pahasti!";
                      }
                  }
                      
                  if($imageFileType == "gif"){
                      if(imagegif($myImage, $target_file)){
                          echo "Korras!";
                      }else{
                          echo "Pahasti!";
                      }
                  }
                  

                  imagedestroy($myTempImage);
                  imagedestroy($myImage);

                 /*  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                      echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üleslaetud.";
                  } else {
                      echo "Faili üleslaadimisel tekkis viga.";
              } */
          }
      }
  }

  $pageTitle = "Kasutaja leht";
  require("header.php");

  //echo userpageDESC($_SESSION["userId"]);

  //load profilepic
  $profilePicAr = userpicload();
  $profilePic = $profilePicAr[0];
  echo $profilePic;
?>


    <h2>Kasutaja <?php echo $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"]; ?> leht</h2>
	  <hr>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
      <label>Valige profiilipilt:</label>
      <input type="file" name="fileToUpload" id="fileToUpload">
      <input type="submit" value="Lae pilt üles" name="submitPic">
    </form>
    <br>
    <label>Profiilipilt</label>
    <br>
    <img src="<?php echo $profilePic ?>" alt="profiilipilt">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea>
      <br>
      <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
      <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
      <input name="submitUserData" type="submit" value="Uuenda andmeid">
    </form>
    <p>Olete sisse loginud nimega : <?php echo $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"]; ?>. <b><a href="?logout=1">Logi välja! </a></b></p>
	
  </body>
</html>