<?php

	function clean_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  //$data = mysqli_real_escape_string($con,$data);
	  return $data;
	}
	
	function validateLength($val,$min,$max)
	{
		if(strlen($val)>=$min && strlen($val)<=$max)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
     * Matches Email Address
     * @param   string
     * @return  boolean
     */
	function is_email($val)
	{
		return (bool)(preg_match("/^([a-z0-9+_-]+)(.[a-z0-9+_-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix",$val));
	 
	}
	
	
	/**
     * Matches only alpha letters
     * @param   string
     * @return  boolean
     */
	function is_alpha($val)
    {
        return (bool)preg_match("/^([a-zA-Z])+$/i", $val);
    }
	
	
	/**
     * Matches alpha and numbers only
     * @param   string
     * @return  boolean
     */
    function is_alphanumeric($val)
    {
        return (bool)preg_match("/^([a-zA-Z0-9])+$/i", $val);
    }
	
	
	/**
	* Check if given string matches any format date
	* @param   string
	* @return  boolean
	*/
  	function is_date($val)
  	{
  		return (strtotime($val) !== false);
 	}
	
	
	/**
  	* Valid Credit Card
  	* @param   string
  	* @return  boolean
  	*/
  	function is_creditcard($val)
  	{
  		return (bool)preg_match("/^((4d{3})|(5[1-5]d{2})|(6011)|(7d{3}))-?d{4}-?d{4}-?d{4}|3[4,7]d{13}$/",$val);
  	}
	
	/**
  	* Valid IP address
  	* @param   string
  	* @return  boolean
  	*/
  	function is_ipaddress($val)
  	{
  		return (bool)preg_match("/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/",$val);
  	}
	
	
	
	function copy_r($path,$dest)
	{
		define('DS', DIRECTORY_SEPARATOR);
			if(is_dir($path))
			{
				mkdir( $dest );
				$objects = scandir($path);
				if( sizeof($objects) > 0 )
				{
					foreach( $objects as $file )
					{
						if( $file == "." || $file == ".." )
							continue;
						// go on
						if( is_dir( $path.DS.$file ) )
						{
							copy_r( $path.DS.$file, $dest.DS.$file );
						}
						else
						{
							copy( $path.DS.$file, $dest.DS.$file );
						}
					}
					
				}
			}
			else if( is_file($path) )
			{
				return copy($path, $dest);
				//echo("Only File & Copied that file");
			}
			else
			{
				return false;
			}
	
	}

	function uploadImage($fileReceived,$target_dir)
    {
        if(!is_dir($target_dir) && !mkdir($target_dir))
        {
            //echo("Can Not Create Directory");
            return false;
        }
        //max file size 8 mb
        $MaxFileSize = 5000000000000; 
        //$target_dir = "uploads/";
        //$fileReceived = $_FILES["fileToUpload"];
        $target_file = $target_dir . basename($fileReceived["name"]);

        $uploadOk = 1;

        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $baseName = pathinfo($target_file, PATHINFO_FILENAME);
        $nameToUpload = $target_dir . $baseName . "_" .date("Y-m-d_H_i_s.").$imageFileType;
        // Check if image file is a actual image or fake image

        $check = getimagesize($fileReceived["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
           // echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
           // echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($fileReceived["size"] > $MaxFileSize) {
            //echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
        // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        //echo "Sorry, your file was not uploaded.";
        return false;
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($fileReceived["tmp_name"], $nameToUpload)) {
            $nameToUpload = str_replace('./','',$nameToUpload);
            //echo "The file ". basename( $fileReceived["name"]). " has been uploaded.";
            return $nameToUpload;
        } else {
            //echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }
  }
	
	
	function uploadAnyFile($fileReceived,$target_dir)
	{
		if(!is_dir($target_dir) && !mkdir($target_dir))
		{
			echo("Can Not Create Directory");
			return false;
		}
		$MaxFileSize = 500000;
		//$target_dir = "uploads/";
		//$fileReceived = $_FILES["fileToUpload"];
		$target_file = $target_dir . basename($fileReceived["name"]);
		
		$uploadOk = 1;

		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$baseName = pathinfo($target_file, PATHINFO_FILENAME);
		$nameToUpload = $target_dir . $baseName . "_" .date("Y-m-d_H_i_s.").$imageFileType;
		
		
		// Check if file already exists
		if (file_exists($nameToUpload)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($fileReceived["size"] > $MaxFileSize) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
			return false;
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($fileReceived["tmp_name"], $nameToUpload)) {
				echo "The file ". basename( $fileReceived["name"]). " has been uploaded.";
				return $nameToUpload;
			} else {
				echo "Sorry, there was an error uploading your file.";
				return false;
			}
		}
	}
	
	
	
	function mailWithAttachment($from,$mailto,$subject,$message,$attachment)
	{
		move_uploaded_file($attachment["tmp_name"],"temp/".basename($attachment['name']));
		$path = "temp/";
		$filename = basename($attachment['name']) ;
		$file = $path.$filename;
		$file_size = filesize($file);
		$handle = fopen($file, "r");
		$content = fread($handle, $file_size);
		fclose($handle);
		$content = chunk_split(base64_encode($content));
		$uid = md5(uniqid(time()));
		$header = "From: ".$from." <".$from.">\r\n";
		$header .= "Reply-To: ".$from."\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
		$header .= "This is a multi-part message in MIME format.\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$header .= $message."\r\n\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
		$header .= "Content-Transfer-Encoding: base64\r\n";
		$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
		$header .= $content."\r\n\r\n";
		$header .= "--".$uid."--";
		if(mail($mailto, $subject, "", $header))
		{
			echo "mail send ... OK"; // or use booleans here
		}
		else
		{
			echo "mail send ... ERROR!";
		}
    }

?>