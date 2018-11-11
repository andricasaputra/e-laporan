<?php

namespace App\Http\Controllers;

class Rupiah extends Controller
{
   public static function rp($rupiah)
   {
   		$rupiah = "Rp ".number_format($rupiah, 2, "," ,".");  
   		$rupiah = str_replace(",00", ",-", $rupiah);
     	return $rupiah;  
   }
}
