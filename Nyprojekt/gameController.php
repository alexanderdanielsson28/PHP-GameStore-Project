<?php

require_once("test.php");

require_once("gameModel.php");
require_once("gameView.php");
require_once("config.php");


require_once("upload.php");

class gameController {
    private $model;
    private $view;
    private $upload;
    private $limit_size= 0;
    private $photo;
    private $text;
    private $value;
    private $result_final;
    private $photos_uploaded;
    private $photo_caption;
    private $galleri;
    private $test;
    private $mm=false;
    private $valid=false;
    private $pageWasRefreshed=" ";
    public function __construct()
    {   
        $this->test= new test();
        $this->upload = new upload();
        $this->model = new gameModel();
        $this->view = new gameView($this->model);
    }
    
  
       
       
        
             
             
             
        
        
      
        
        
        
    public function doControll(){
    
    
     
     $_FILES['photo_filename']=$this->view->getPhoto();
      
        $_POST['photo_caption'] = $this->view->getText();
        $_POST['photo_price']=$this->view->getPrice();
        $_POST['password']=$this->view->getPassword();
        $_POST['password1']=$this->view->getRepPassword();
     
    
      
      
        $photos_uploaded = $_FILES['photo_filename'];
     	$photo_caption = $_POST['photo_caption'];
     	$photo_price=$_POST['photo_price'];
        $password=$_POST['password'];
        $password1=$_POST['password1'];
        
        
        
       
     	$this->model->doUpload($photos_uploaded,$photo_caption,$password,$password1);
     
        $mm=$this->model->returnErr();
        
        $count=$this->model->countPic();
       
       
       
        if($mm==true){
            
            $this->model->loadPics($photos_uploaded,$photo_caption,$photo_price,$password);
       
          $_SESSION['valid']=true;
        $this->pageWasRefreshed =isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';    
        }
        else{
            $sk=$_SESSION['errorMessage'];
            
            $this->view->viewMessage($sk);
        }
      
        
     
        
        
           
           
           
           
           
           
           
           
           
           
           
          
           
     
      
   
       
    }    
             
        
    
    public function mailControll(){
        
        $name=$this->view->Uname();
        $imageId=$this->view->imageID();
        $imagePassword=$this->view->imagePassword();
        $imageEmail=$this->view->imageEmail();
        
        
        $this->model->mailValid($name,$imageId,$imagePassword,$imageEmail);
        $sessionValid=$this->model->sessionValid();
       
    }
    
    
    
    
    
    
    
    
    
    
    
    public function doRegisterControll(){
   
    
 
     
        if($this->view->clickContact()){
                 
           return $this->view->contactView();
        }
        
         elseif($this->view->clickHome()){
          return $this->view->showLoginView();
        }
        
        elseif($this->view->clickSell()){
       
       
       
       
       
  
        
            
           
           
      
        
            
             return $this->view->showUserView();
             
             
        }
       elseif($this->view->clickBuy()){
          
            $buy=$this->view->didUserChoceCategory();
            
            $large_id=$this->view->didUserChoceBigPics();
          
            if($buy>0){
                
                if($large_id>0){
                    
                    $this->model->getbigpics($large_id);
                    return $this->view->catView();
             }
              $this->model->getminipic($buy);
                 
            return $this->view->catView();
            } 
         
     return $this->view->buyView();
            
    
	
        } 
        elseif($this->view->clickDelete()){
            return $this->view->deleteGame();
            
        }
     

 }
 }