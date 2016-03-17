 <?php

require_once("config.php");
require_once("gameView.php");


class gameModel{
	private $message = "";
	private $view;
    private $result_array;
    private $counter;   
    private $cid;
    private $large_id;
    private $result;
    private $result_final;
    private $Thumbnails;    
    private $errorArray=array();
    private $err=false;
    private $approvedPhoto;
    private $countnewpics=" ";
    private $countOne; 
    private $errorinfo;
    public function __construct(){
		     
	   }
	   
	     public function category(){
    
    $result = mysql_query("SELECT category_id,category_name FROM gallery_category");
	    while($row = mysql_fetch_array($result) )        //hämtar olika kategoriena
	    {
            $category_list.="
    	    <option value='$row[0]'>$row[1]</option>\n
            ";
        }
    return $category_list;
}

    

    public function mailValid($name,$imageId,$imagePassword,$imageEmail){
        
        
        
        if(empty($name)){
            $_SESSION['mailValid']=false;
            $this->errorinfo="Fyll i ditt namn";    
            
        
        }
        elseif(!preg_match("/^[a-öA-Ö ]*$/",$name)) {
            
            $this->errorinfo="Endast bokstäver är gilltliga";    
            $_SESSION['mailValid']=false;
        
            
        }elseif(!filter_var($imageEmail,FILTER_VALIDATE_EMAIL)) {

            $_SESSION['mailValid']=false;
            $this->errorinfo= "Felaktig mailadress"; 
        
        }elseif($imagePassword=""){
            
            $_SESSION['mailValid']=false;
            $this->errorinfo= "Fältet för lösenor är tomt"; 
        
        }
      
        elseif(empty($imageId)){
            $_SESSION['mailValid']=false;
            $this->errorinfo= "Du måste ange annonsens ID"; 
        
        }elseif(!is_numeric($imageId)){
            
            $_SESSION['mailValid']=false;
            $this->errorinfo= "Endas siffror kan anges som ID";
        }
        else{
        
            $_SESSION['mailValid']=true;
            
        }
        
            
    }
    public function errorInfo(){
        return $_SESSION['errorinfo']=$this->errorinfo;
    }
    
    public function sessionValid(){
    return $_SESSION['mailValid'];
    }
    
      
	   
	   
	   public function doUpload($photos_uploaded,$photo_caption,$password,$password1){
	  $errorArray=array();
	  $images_dir="photos";
      $this->countOne=0;
      $_SESSION['add']=0;
      	
     
     
     
     
     	$this->approvedPhoto = array( 
						
					    
						'image/pjpeg' => 'jpg','image/jpeg' => 'jpg','image/gif' => 'gif','image/bmp' => 'bmp',
						'image/x-png' => 'png','image/png' => 'png' 
          	); 
					
					
				
      
             
          
            
       
        if(!array_key_exists($photos_uploaded['type'], $this->approvedPhoto)) {
         
            $errorArray='Är inget foto';
            $this->err=false;
            
        }

      
      
         elseif($photos_uploaded['size']>200000){
                
                $this->err=false;
                $errorArray='Filen är för stor';
               
                
             
         }elseif($password!==$password1){
          
            $errorArray='lösenorden stämmer inte';
            $this->err=false;
           
         }
         
         else{
                
             $this->err=true;
             $_SESSION['countPic']=true;
             $this->countnewpics=1;
             $this->countOne=1;
             $_SESSION['add']=1;
         }           
     
            $_SESSION['errorMessage']=$errorArray;
            
       return $this->err;
       
        $this->countOne=0;
     
	   }
	   
	   public function returnErr(){
	       return $this->err;
	   }

	   public function countnewpiccontroll(){
	       return $this->countnewpics;
	   }
	     
	   
	   
	   
	   
	   
        public function loadPics($photos_uploaded,$photo_caption,$photo_price,$password){
      
            
            $count=0;
            $images_dir="photos";
          
            $suffix = array( 
						
						'image/jpeg' => 'JPEG','image/pjpeg' => 'JPEG','image/bmp' => 'WBMP','image/gif' => 'GIF',
						'image/x-png' => 'PNG','image/x-png' => 'png' 
					);    
           
			
			mysql_query( "INSERT INTO gallery_photos(`photo_filename`, `photo_caption`, `photo_category`,`price`,`password`) VALUES('0', '".addslashes($photo_caption)."', '".addslashes($_POST['category'])."', '".addslashes($photo_price)."','".addslashes($_POST['password'])."')" );
				
				$new_id = mysql_insert_id();                     // nytt id skapas
				$filetype = $photos_uploaded['type'];  // ta reda pa filtyp
				$extention = $this->approvedPhoto[$filetype];
				$filename = $new_id.".".$extention;             //Generera ett nytt namn 

				//uppdaterar filnamnet
				
				mysql_query( "UPDATE gallery_photos SET photo_filename='".addslashes($filename)."' WHERE photo_id='".addslashes($new_id)."'" );
                
                
                copy($photos_uploaded['tmp_name'],$images_dir . '/' . $filename);     
           
       	
			$_SESSION['newPic']= "\t<tr>
			<td id='nybild'><a href='?buy=1&large_id=$filename'>Till din annons!</a></td></tr>\n";
			
				 
                
				// hamtar storlek pa bild.
				$size = getimagesize( $images_dir."/".$filename );
				if($size[0] > $size[1])                                 //om bild bred > stor
				{
					$thumb_width = 100;
					$thumb_height = (int)(100 * $size[1] / $size[0]);
				}
				else                                                    //om bild bred < stor
				{
					$thumb_width = (int)(100 * $size[0] / $size[1]);
					$thumb_height = 100;
				}
				$f_suffix = $suffix[$filetype];
				$read_func = "ImageCreateFrom".$f_suffix;
				$write_func = "Image".$f_suffix;

				
				$source_handle = $read_func($images_dir."/".$filename); 
				
				if($source_handle)
				{
					// skapar en tom bild
				     	$destination_handle = imagecreatetruecolor( $thumb_width, $thumb_height );
				
					
			      	ImageCopyResized( $destination_handle, $source_handle, 0, 0, 0, 0, $thumb_width, $thumb_height,                            $size[0], $size[1] );
				}

				// sparar ner bild till mapp
				$write_func( $destination_handle, $images_dir."/tb_".$filename );
				ImageDestroy($destination_handle );

                

                
                
             
              $_SESSION['$count']=$count;
       
		
         }
         public function newPic(){
     
             return ($_SESSION['newPic']);
       
             $_SESSION['countPic']=false;
            
         }
         public function deleteNewPic(){
            $_SESSION['add']=0;
            unset($_SESSION['newPic']);
            $_SESSION['countPic']=false;
           
        }
        
           public function countPic(){
         
          
          return $_SESSION['countPic'];
        }
      
       
         
	   
	   
	   
	   
	


	                             // hämtar kategori
            
            
           public function getcategory(){

	$result_array = array();
	$counter = 0;

	if( empty($mini_id) && empty($large_id) )
	{
		$number_of_categories_in_row = 3;
                                                                    //hämtar ut ala kategorier ur databasen.
		$result = mysql_query( "SELECT c.category_id,c.category_name,COUNT(photo_id)
						FROM gallery_category as c
						LEFT JOIN gallery_photos as p ON p.photo_category = c.category_id
						GROUP BY c.category_id" );
		while( $row = mysql_fetch_array( $result ) )
		{
			$result_array[] = "<a  href='?buy=".$row[0]."'>".$row[1]."</a> "."(".$row[2].")";
		}
		mysql_free_result( $result );	

		$result_final = "<tr>\n";

		foreach($result_array as $category_link)
		{
			if($counter == $number_of_categories_in_row)
			{	
				$counter = 1;
				$result_final .= "\n</tr>\n<tr>\n";
			}
			else
			$counter++;

			$result_final .= "\t<td class='hej'>".$category_link."</td>\n";
		}

		if($counter)
		{
			if($number_of_categories_in_row-$counter)
			$result_final .= "\t<td  colspan='".($number_of_categories_in_row-$counter)."'>&nbsp;</td>\n";

			$result_final .= "</tr>";
		}
	}
	return $result_final;
}

	// hämtar minibilder

public function getminipic($buy){
    $counter='0';    
    $images_dir="photos";
    
	if( $buy && empty( $large_id ) )
{
		$number_of_thumbs_in_row = 4;

		$result = mysql_query( "SELECT photo_id,photo_caption,photo_filename,price FROM gallery_photos WHERE photo_category='".addslashes($buy)."'" );
		$nr = mysql_num_rows( $result );

		if( empty( $nr ) )
		{
			$result_final = "\t<tr><td id='emptyC'>Den här kategorin är tom</td>
			</tr>\n";
		   	
		   	$result_final .= "\t<tr>
			<td id='tillbaksC'><a href='?buy'>Tillbaks till kategori</a></td></tr>\n";
		    
		}
		else
		{
			while( $row = mysql_fetch_array( $result ) )
			{
				$result_array[] = "<a href='?buy=$buy&large_id=".$row[0]."'><img src='".$images_dir."/tb_".$row[2]."' border='0' alt='".$row[1]."'/></a>";
			}
			mysql_free_result( $result );	

			$result_final = "<tr>\n";
	
			foreach($result_array as $thumbnail_link)
			{
				if($counter == $number_of_thumbs_in_row)
				{	
					$counter = 1;
					$result_final .= "\n</tr>\n<tr>\n";
				}
				else{
				    
				
				$counter++;

				$result_final .= "\t<td> ".$thumbnail_link."</td>\n";
			
				}
			}
	
			if($counter)
			{
				if($number_of_photos_in_row-$counter)
			$result_final .= "\t<td  colspan='".($number_of_photos_in_row-$counter)."'>&nbsp;</td>\n";

				$result_final .= "</tr>";
			}
		}
	
	    
	}


	
	
	
 	
	$_SESSION['result']=$result_final;
  
   return $_SESSION['result'];


}
        
    public function getbigpics($large_id){
        
    $images_dir='photos';

	//hämtar orginalbild;
	if($large_id)
	{
		$result = mysql_query( "SELECT photo_caption,photo_filename,price,photo_id FROM gallery_photos WHERE photo_id='".addslashes($large_id)."'" );
		list($photo_caption, $photo_filename,$photo_price,$photo_id) = mysql_fetch_array( $result );
		$nr = mysql_num_rows( $result );
		mysql_free_result( $result );	

		if( empty( $nr ) )
		{
			$result_final = "\t<tr><td>No Photo found</td></tr>\n";
		}
		else
		{
			$result = mysql_query( "SELECT category_name FROM gallery_category WHERE category_id='".addslashes($buy)."'" );
			list($category_name) = mysql_fetch_array( $result );
			mysql_free_result( $result );	

			$result_final .= "<tr>\n\t<td>
						<a href='?buy'>Tillbaks till Kategori </a> 
						<a href='?buy?buy=$buy'>$category_name</a></td>\n</tr>\n";

			$result_final .= "<tr>\n\t<td class='bigpics' align='center'>
					<br />
					<p>Annons id:$photo_id</p>
					<img src='".$images_dir."/".$photo_filename."' border='0' alt='".$photo_caption."' />
					<br />
					Kontakta:$photo_caption
					</br>
					Pris:$photo_price
					</td>
					</tr>";
		}
	}
		$_SESSION['result']=$result_final;
  
   return $_SESSION['result'];
}

public function Thumbnails(){
   
    return ($_SESSION['result']);    
   
    
  
    
}
public function errorMessage(){
   
    return ($_SESSION['error']);    
   
    
  
    
}





	}
	




            
 
	   
	   

	
        
    