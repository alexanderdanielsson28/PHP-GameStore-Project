<?php
require_once("config.php");
require_once("gameView.php");
require_once("gameController.php");




class upload {
    

	// initialization
//	private $result_final = "";
	private $counter = 0;
    private $limit_size= 5;
    private $url='preupload.php';
    private $result;
    private $pics;
    private $text;
    private $svar=0;
   
   
   public function __construct(){
    
    }
    public function category(){
    
    $result = mysql_query("SELECT category_id,category_name FROM gallery_category");
	    while($row = mysql_fetch_array($result) )        //press olika kategoriena
	    {
            $category_list.="
    	    <option value='$row[0]'>$row[1]</option>\n
            ";
        }
    return $category_list;
}

     public function checkupload($photo){
        $this->photo=photo;
        
    
        if($this->photo > $this->limit_size){
           return  $this->svar=1;
        }    
  
     }
  

public function gallery(){

	$result_array = array();
	$counter = 0;

	$cid = (int)($_GET['cid']);
	$pid = (int)($_GET['pid']);
	if( empty($cid) && empty($pid) )
	{
		$number_of_categories_in_row = 4;

		$result = mysql_query( "SELECT c.category_id,c.category_name,COUNT(photo_id)
						FROM gallery_category as c
						LEFT JOIN gallery_photos as p ON p.photo_category = c.category_id
						GROUP BY c.category_id" );
		while( $row = mysql_fetch_array( $result ) )
		{
			$result_array[] = "<a href='galleri.php?cid=".$row[0]."'>".$row[1]."</a> "."(".$row[2].")";
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

			$result_final .= "\t<td>".$category_link."</td>\n";
		}

		if($counter)
		{
			if($number_of_categories_in_row-$counter)
			$result_final .= "\t<td colspan='".($number_of_categories_in_row-$counter)."'>&nbsp;</td>\n";

			$result_final .= "</tr>";
		}
	}


	// Thumbnail Listing

	elseif( $cid && empty( $pid ) )
	{
		$number_of_thumbs_in_row = 5;

		$result = mysql_query( "SELECT photo_id,photo_caption,photo_filename FROM gallery_photos WHERE photo_category='".addslashes($cid)."'" );
		$nr = mysql_num_rows( $result );

		if( empty( $nr ) )
		{
			$result_final = "\t<tr><td>No Category found</td></tr>\n";
		}
		else
		{
			while( $row = mysql_fetch_array( $result ) )
			{
				$result_array[] = "<a href='galleri.php?cid=$cid&pid=".$row[0]."'><img src='".$images_dir."/tb_".$row[2]."' border='0' alt='".$row[1]."' /></a>";
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
				else
				$counter++;

				$result_final .= "\t<td>".$thumbnail_link."</td>\n";
			}
	
			if($counter)
			{
				if($number_of_photos_in_row-$counter)
			$result_final .= "\t<td colspan='".($number_of_photos_in_row-$counter)."'>&nbsp;</td>\n";

				$result_final .= "</tr>";
			}
		}
	}

	// Full Size View of Photo
	else if( $pid )
	{
		$result = mysql_query( "SELECT photo_caption,photo_filename FROM gallery_photos WHERE photo_id='".addslashes($pid)."'" );
		list($photo_caption, $photo_filename) = mysql_fetch_array( $result );
		$nr = mysql_num_rows( $result );
		mysql_free_result( $result );	

		if( empty( $nr ) )
		{
			$result_final = "\t<tr><td>No Photo found</td></tr>\n";
		}
		else
		{
			$result = mysql_query( "SELECT category_name FROM gallery_category WHERE category_id='".addslashes($cid)."'" );
			list($category_name) = mysql_fetch_array( $result );
			mysql_free_result( $result );	

			$result_final .= "<tr>\n\t<td>
						<a href='test.php'>Categories</a> &gt; 
						<a href='test.php?cid=$cid'>$category_name</a></td>\n</tr>\n";

			$result_final .= "<tr>\n\t<td align='center'>
					<br />
					<img src='".$images_dir."/".$photo_filename."' border='0' alt='".$photo_caption."' />
					<br />
					$photo_caption
					</td>
					</tr>";
		}
	}


return $result_final;


	}





}