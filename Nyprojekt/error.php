
<?php



require_once("CustomExceptions.php");


class error{

	/*
	Errocodes:
		202 - AllTooShortException
		203 - UsernameTooShortException
		204 - InvalidCharException
		205 - NoMatchException
		206 - PasswordTooShortException
	*/

	private $pics;
	private $text;

	const regEx = '/[^a-z0-9\-_\.]/i';
	private $limit_size= 5;
	const text = 6;


$known_photo = array( 
						
					    
						'image/pjpeg' => 'jpg',
						'image/jpeg' => 'jpg',
						'image/gif' => 'gif',
						'image/bmp' => 'bmp',
						'image/x-png' => 'png'


                    	);

public function __construct($pics,$text){
        
        $this->pics=$pics;
        $this->text=$text;
		
		
		// Om både användarnamn och båda lösenorden är för korta.
        if($this->pics > $this->limit_size){
            throw new \TooBigPhotoSizeException("Errorcode: ", 202);
        }
		// Om användarnamnet är för kort.
		if($this->pics < 0){
			throw new \TooSmallPhotoException("Errorcode: ", 203);		
		}
		// Om användarnamnet innehåller ogiltiga tecken.
		/*if(preg_match(self::regEx, $username)){
			$username = preg_replace(self::regEx, "", $username);
			throw new \InvalidCharException($username, 204);	
		}
		// Om lösenordet är för kort.
		if(mb_strlen($password) < self::minPassword || mb_strlen($rpassword) < self::minPassword){
			throw new \TooShortException("Errorcode: ", 206);		
		}
		// Om lösenorden är olika.
        if($password !== $rpassword){
            throw new \NoMatchException("Errorcode: ", 205);
        */
            
        }
        
        public function getPhoto(){
		return $this->pics;
	}

	public function getText(){
		return $this->text;
	}
