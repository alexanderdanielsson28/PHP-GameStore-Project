<?php

// Kastar ett undantag när ett regulärt uttryck inte stämmer.
class TooBigPhotoSizeException  extends \error{

} 

// Kastar ett undantag när längden på strängen är mindre än den angivna.
class TooSmallPhotoException  extends \error{

} 

// Kastar ett undantag när två strängar inte överensstämmer.
class NoMatchException  extends \error{
} 

// Kastar ett undantag när två strängar inte överensstämmer.
class AllTooShortException  extends \error{
} 

// Kastar ett undantag när strängen redan finns i databasen.
class AlreadyExistsException  extends \error{
} 
?>