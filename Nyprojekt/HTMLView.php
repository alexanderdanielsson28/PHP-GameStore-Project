<?php




class HTMLView{


    public function echoHTML($htmlBody)
    {
      
      
               $_SESSION['newPic']=" ";
               $_SESSION['add']=0;
              
                
       
        echo "
            <!DOCTYPE html>
            <html>
         <head>
                <meta charset='utf-8'/>
                <meta name='viewport' content='width:device-width, initial-scale=1.0'>
                <link rel='stylesheet' href='stylesheet.css' media='screen'>
                <link rel='stylesheet'  href='menu.css' media='screen'>  
                <script src='menu.js'></script>
            </head>
            <div id='content'>
         
            <div id='meny'>
            <div id='meny2'>
                    <nav>
                        <ul>
                            <li><a href='?home'>Hem</a></li>
                            <li><a href='?preupload'>Sälj ditt begagnade spel</a></li>
                            <li><a href='?buy'>Köp spel</a></li>
                            <li><a href='?contact'>Om PlayAgain</a></li>
                            <li><a href='?deleteGame'>Ta bort din annons</a></li>
                        </ul>
                    </nav>
            </div> 
            </div> 
                $htmlBody
            </div> 
                
            </html>
            ";
    }
}