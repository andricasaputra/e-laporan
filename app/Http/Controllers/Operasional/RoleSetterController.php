<?php

namespace App\Http\Controllers\Operasional;

<<<<<<< HEAD
=======
use Illuminate\Http\Request;
>>>>>>> 67c29aeccc0c7a28f91b3071026904c840692a41
use App\Http\Controllers\Controller;

class RoleSetterController extends Controller
{
    /**
     * Show the application dashboard based on role type.
     *
     * @return void
     */
    public function handle()
    {
        if (! auth()->user()) return redirect(route('login'));
            
        $cek1 = auth()->user()->role->first()->id;

        $cek2 = auth()->user()->pegawai->jenis_karantina;

        if($cek1 === 1 || $cek1 === 2 || $cek1 === 3):

            $this->middleware('admin');

        elseif($cek1 === 4 && $cek2 == 'kt'):
           
            $this->middleware('kt');

        elseif($cek1 === 4 && $cek2 == 'kh'):

            $this->middleware('kh');

        elseif($cek1 === 4 && $cek2 !== 'kh' && $cek2 !== 'kt'):

            $this->middleware('guest');

        else:

            return redirect(route('welcome'))
                    ->withWarning('Maaf anda tidak mempunyai hak akses ke halaman ini');

        endif; 

        return redirect('intern/operasional/home/');  
    }
}
