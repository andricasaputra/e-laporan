<?php

namespace App\Http\Controllers;

class RupiahController extends Controller
{
   public static function rp($rupiah)
   {
   		$rupiah = "Rp " . number_format($rupiah , 2 , "," , "."); 

   		return str_replace(",00", ",-", $rupiah);
   }
}
