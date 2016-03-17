<?php



require_once("gameController.php");
require_once("test.php");

require_once("upload.php");
//require_once("galleri.php");


class gameView{
	
	private $model;
	private $message;
	private $messages;
	private $upload;
	private $result_final;
    private $final;
    private $test;
    private $saveBuy;
    private $mini;
    private $error;
    private $errorInfo;    
  //  private $galleri;
    
	public function __construct(gameModel $model){
		$this->test=new test();
		$this->model = $model;
	
       $this->upload = new	upload();	

	}
	
	
	
	
		//sparar kakor
	
	

		//visar meddelande beroende på vad input är.
		    //    viewMessage
	public function viewMessage($message){
			if (isset($message)) {
				$this->message = $message;
			}
			else{
				$this->message="<p>".$message."</p>";
			}

		}
	
	
	


	public function getMessage(){
		return "<p>" . $this->message . "</p>";
	}
		public function getErrorInfo(){
		 $errortwo=$this->model->errorInfo();
	return $errortwo;
	}
	
	
	
	public function clickSell(){
	    return isset($_GET["preupload"]); 
	    
	}
	public function clickBuy(){
	    return isset($_GET["buy"]); 
	    
	}
	public function clickContact(){
	    return isset($_GET["contact"]); 
	    
	}
	public function clickHome(){
	    return isset($_GET["home"]); 
	    
	}
	public function catViewe(){
	    return isset($_GET["catView"]);
	    
	}
	public function clickDelete(){
	    return isset($_GET['deleteGame']);
	}
	public function getPhoto(){
	    return $_FILES['photo_filename'];
	    
	}
	public function getText(){
	    return $_POST['photo_caption'];
	}
	public function getPrice(){
	    return $_POST['photo_price'];
	}
	public function getPassword(){
	    return $_POST['password'];
	}
	public function getRepPassword(){
	    return $_POST['password1'];
	}
	
	public function didUsersUpload(){
	    return isset($_POST["submit"]);
	    
	}
	
	public function buyResult($result_final){
	    $this->result_final = $result_final;
	}
	public function getResult(){
	    return "<p>". $this->$result_final ."</p>";
	}
	public function didUserChoceCategory()
    {
   
      return $_GET['buy'];
    /*    if (isset($_GET['buy'])){
         $this->saveBuy= $_GET['buy'];
        }
        return $saveBuy;*/
    }
    public function didUserChoceBigPics(){
        return $_GET['large_id'];
      //  var_dump($_GET['pid']);
    }
    public function getsession(){
     return $this->mini=$this->model->Thumbnails();
    
     
    }
      public function getError(){
     return $this->error=$this->model->errorMessage();
   
     
    }
    public function getNewPic(){
      return  $newPic=$this->model->newPic();
        
    }
    public function retNewPic(){
        
        return $picCount=$this->model->countPic();
 
        
        }
    public function submitMail(){
        return isset($_POST["submitMail"]);
        var_dump($_POST['submitMail']);
    }
    public function Uname(){
        return $_POST['Uname'];
    }
    
    public function imageID(){
        return $_POST['Uid'];
    }
    public function imagePassword(){
        return $_POST['Upassword'];
    }
    public function imageEmail(){
        return $_POST['Uemail'];
    }
    
 
//home sidan
	public function showLoginView(){
	
			
			
			
$ret='
        <div id="textblock">     
                               
            <h1 class="rubriktextblock">Välkommen till PlayAgain</h1> <h2>Vi tillhandhåller begagnade spel till rätt pris.</h2>
            <p>Om du är trött på att lägga 600kr på ett dåligt spel, eller kanske du är gamen som spelar genom ett spel på några timmar,</br></br>Det spelar ingen roll vem du är, hos oss behöver du inte lägga ut massa pengar för ett spel du bara spelar en gång.</br></br> Antingen säljer du ett spel på vårt säljforum, </br>eller köper du ett begagnat spel, för en annan men nytt för dig.</br></br> Så tänker vi</p>
    
     
            </div>

';
			return $ret;						

	
	}
	// ladda up bild sidan preupload
			public function showUserView(){
		
			$picCounts=$this->retNewPic();
			$picsup=" ";
			   
		    $err="";
		   if($picCounts==true){
		       $picsup=$this->getNewPic(); 
		        
		        
		    
		        $bild="<div>
                    	        <ul  >
                    	            $picsup
                    	        <ul>
                    	    </div>";
		    }
		  
		    if(isset($this->message)){
		        $error=$this->getMessage();
		        
		        
		    
		        $err="<div>
                    	        <ul  style='list-style-type:disc'>
                    	            <li class='c2' >$error</li>
                    	        <ul>
                    	    </div>";
		    }
		    
		    
	
				  
				 
                    	    
                    	    
			     $category_list=$this->model->category();
			     
        
		$photo_upload_fields="	   
			   
			        <tr>
                    	<td>
                    	    <h2>Ladda upp din bild:</h2></br></br></br>
                    	    <input  required name='photo_filename' type='file' />
                    	 	$bild
                    	 	$err
                    	 
                    	</td>
                    </tr>
                    
                    <tr>
                    	<td>
                    		
                            </br></br></br>	
                    	     <h3>Ange beskrivning:</h3></br>
                    	    <textarea  required maxlength='125'  placeholder='Namn och Telefonnummer'  name='photo_caption' cols='30' rows='1'  ></textarea></br></br>
                    	     
                    	    
                    	   
                    	                           </br>	
                    	     <h3>Ange pris (kr):</h3></br>
                    	    <textarea  required maxlength='3' placeholder='ex.198kr'   name='photo_price' cols='20' rows='1'  ></textarea></br></br> </br>                    
                    	    
                    	    <h3>Välj ett lösenord för att kunna radera annonsen</h3><p>(kom ihog att spara lösenordet tills du kontaktar admin för att radera annonsen </p></br>
                    	   <h3>Lösenord:</br> <input type='password' required name='password'></br>
                    	   Ange lösenordet igen: <input type='password' required name='password1'>
                    	    
                    	</td>
                    </tr>
            
            
				";
				 
		$ret="	
		
			
			     
		
		
		
		<div id='textblockupload'> 
		
		
	 <div class='form'>                                                                             
    <form class='angepris' enctype='multipart/form-data' action='?preupload' method='post' name='upload_form'>
    <table width='90%' border='0' align='center' style='width: 90%;'>
        <tr>
        	<td><h2>Välj Kategori:</h2>
        		
        		<select name='category'>
        		   
        			$category_list
                    		
        		</select>
        	</td>
        </tr>
        <tr>
        	<td>
              
        	
        		<p>&nbsp;</p>
        	</td>
        </tr>

        $photo_upload_fields
        
        <tr>
        	<td>
        	        <input Required  type='submit' name='submit' value='Ladda upp' />
        	</td>
        </tr>
    </table>
</form>
</div>
			
		</div>
		
			";
			
			return $ret;
	
		    
			}
			
			
			//contactsidan
		public function contactView(){
		   
	
     $ret=' 
    
        <div id="textblockcontact">     
                               
        	
	      
	   <h2 class="rubrikköpa">Besök gärna vårt Företag </h2>
            <div id="saljtextdel">
            <p>PlayAgain.se i Kalmar</p>
            <p>Norra Vägen 45</p>
            <p>392 34 Stockholm</p>
            <p>Öppettider: Må-Fr 10.00-16.00</p>
            <p>Telefon: 08-456789</p>
            <p>Epost: PlayAgain@kalmar.se</p>
            <p>Hitta till oss:</p>
	        <img id="hus" src="pics/hus.jpg" alt="bild på butik/ utlämningsställe">
	      </div>
	   
             

    
    
    </div>
                     
  ';
	        
	        return $ret;
	   
	
		}
		public function buyView(){
	
		        
		    
		        
		    
		    $test=$this->model->getcategory();
             
        $ret="
           <div id='textblockCategory'>
                
                <table>
                $test
               </table>
                   </div>
            
                    ";
 
 

   
		   return $ret;

		}
		
		public function catView(){

        $min=$this->getsession();
        
        $ret="
         
            <div id='textblockCategory'>
                    <table class='minitable'>
                        $min
                    </table>
            </div>        ";
 
              
		   return $ret;
    
		}
		
		public function deleteGame(){
	       $bbbb=$this->getErrorInfo();
	        
	       $ret=" <div id='textblock'>     
                    <h2>Fyll i fomruläret för att radera din annons:</h2>
                    
                    <ul>
                    	<li class='c3'>$bbbb</li>
                    <ul>
                    
                
                <form class='deleteform' action='?deleteGame' method='post'>
                <div class='deleteBox'>    
                    <div class='deleteText'>Ditt namn: <input type='text' name='Uname'></div>
                    
                    <div class='deleteText'>Din annons ID: <input type='text' name='Uid'></div>
                    <div class='deleteText'>Ditt valda lösenord: <input type='text' name='Upassword'></div>
                    <div class='deleteText'>Din mailadress: <input type='text' name='Uemail'></div>
                    
                   
                </div>
                <input type='submit' name='submitMail'>
                </form>
                
                
                <div class='deleteBox1'><p>Din annons kommer att tas bort från PlayAgain inom 24h. Om något inte stämmer kommer                                         vi återkomma med inforamtion om varför det inte gick att ta bort annonsen. Var noga med                                         att ange en mailadress som bara du har tillgång till, samt förnamn och efternamn.
                </div>
         
                    </div>";
                    
            return $ret;
           
		}
		
	}

		