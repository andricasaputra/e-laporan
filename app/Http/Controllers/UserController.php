<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\User;
use App\Wilker;

class UserController extends Controller
{

    public function index()
    {
        return view('auth.showusers');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'wilker_id' => $data['wilker'],
            'username'  => $data['username'],
            'bagian'    => $data['bagian'],
            'role_id'   => $data['role'],
            'name'      => $data['name'],
            'password'  => Hash::make($data['password']),
        ]);
    }

    public function edit($id)
    {
        $wilkers    = Wilker::all();
        $user       = User::find($id);
        $wilker     = $user->wilker;
        $role       = $user->role;
        return view('auth.edit')->with('user', $user)
        ->with('wilker', $wilker)
        ->with('role', $role)
        ->with('wilkers', $wilkers);
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'wilker'    => 'required|string|max:255',
            'bagian'    => 'required|string|max:255',
            'role'      => 'required|string|max:255',
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:255',
            'password'  => 'required|string|min:6|confirmed',

        ]); 

        $user = User::find($id);

        $user->wilker_id    = $request->wilker;
        $username           = $request->username;
        $user->bagian       = $request->bagian;
        $user->role_id      = $request->role;
        $user->name         = $request->name;
        $user->password     = Hash::make($request->password);

        if($user->save()){

            return redirect(route('users.show'))->with('success', 'Data User Berhasil Diubah');

        }

        return redirect()->back()->with('warning', 'Terjadi Kesalahan, Gagal Ubah Data');

    }

    public function api(Request $request)
    {
        
        $columns = [ 
            0   => 'id', 
            1   => 'name',
            2   => 'username',
            3   => 'bagian',
            4   => 'options',
        ];
  
        $totalData = User::count();
            
        $totalFiltered = $totalData; 

        $limit  = $request->input('length');
        $start  = $request->input('start');
        $order  = $columns[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
            
        if(empty($request->input('search.value'))){  

            $users = User::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

        } else {

            $search = $request->input('search.value'); 

            $users =  User::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('username', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = User::where('id','LIKE',"%{$search}%")
                             ->orWhere('name', 'LIKE',"%{$search}%")
                             ->orWhere('username', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data = [];

        if(!empty($users)){

            foreach ($users as $user){

                $subdata['id']      = $user->id;
                $subdata['name']    = $user->name;
                $subdata['username']= $user->username;
                $subdata['bagian']  = $user->bagian;
                $subdata['options'] = "<a href='".route('users.edit', $user->id)."' class='btn btn-primary btn-xs'><i class='fa fa-edit fa-fw'></i> Edit</a>";

                $data[] = $subdata;

            }
        }
          
        $json_data = [
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        ];
            
        return json_encode($json_data);   
    }
    
}
