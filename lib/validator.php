<?php
class Validator
{
	public static function validateForm($fields)
	{
		foreach ($fields as $index => $value) {
			$value = trim($value);
			$value = strip_tags($value);
			$fields[$index] = $value;
		}
		return $fields;
	}

	public static function validateImage($file)
	{
		$img_size = $file["size"];
     	if($img_size <= 1000000048576)
     	{
     		$img_type = $file["type"];
	     	if($file['type'] == "image/jpeg" || $file['type'] == "image/png" || $file['type'] == "image/x-icon" || $file['type'] == "image/gif" || ( $file['type']=="file/x-msfile" || $file['type'] == "file/mpeg" || $file['type'] == "file/quicktime" || $file['type'] == "application/vnd.rn-realmedia" || $file['type'] == "file/x-ms-wmv" || $file['type'] == "file/mp4" || $file['type'] == "application/x-shockwabe-flash"))
	    	{
	    		$img_temporal = $file["tmp_name"];
	    		$img_info = getimagesize($img_temporal);
		    	$img_width = $img_info[0]; 
				$img_height = $img_info[1];
				if ($img_width <= 5172)
				{
					$image = file_get_contents($img_temporal);
					return base64_encode($image);
				}
				else
				{
					return false;
				}
	    	}
	    	else
	    	{
	    		return false;
	    	}
     	}
     	else
     	{
     		return false;
     	}
	}
    public static function validateVideo($file)
	{
		
     		$img_type = $file["type"];
	     	if(($img_type=="file/x-msfile") || ($img_type == "video/mpeg") || ($img_type == "video/quicktime") || ($img_type == "video/webm") || ($img_type == "application/vnd.rn-realmedia") || ($img_type == "file/x-ms-wmv") || ($img_type == "video/mp4") || ($img_type == "application/x-shockwabe-flash"))
	    	{
	    		$img_temporal = $file["tmp_name"];
	    		$img_info = getimagesize($img_temporal);
		    	$img_width = $img_info[0]; 
				$img_height = $img_info[1];
					$image = file_get_contents($img_temporal);
					return base64_encode($image);
				
	    	}
	    	else
	    	{
	    		return false;
	    	}
     	
	}
}
?>