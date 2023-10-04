<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all()->sortBy('name');
        return view('users.index', compact('user'));
    }

    public function create()
    {
        $user = new User();
        return view('users.create', compact('user'));
    }

    public function store(Request $request)
    {
        $input = $request->toArray();
        //dd($input);

        $input['user_id'] = 1;

        User::create($input);
        $input['password'] = bcrypt($input['password']);
        return redirect()->route('users.index')->with('sucesso', 'Usuário cadastrado com sucesso!');
    }

    public function edit(string $id)
    {
        $user = User::find($id);

        if(!$user){
            return back();
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, string $id)

    {  
        $input = $request->toArray();
        $user = User::find($id);
        if($input['password'] != null){
            $input['password'] = bcrypt($input['password']);
           }else{
            $input['password'] = $user['password'];
           }
           

        $user->name = $request->input('name');

        $user->tipo = $request->input('tipo'); // Certifique-se de atualizar o campo 'tipo' corretamente
           $user->fill($input);
        $user->save();

        return redirect()->route('users.index')->with('sucesso', 'Usuário alterado com sucesso!');
    }



    public function destroy(User $user)
    {
        // Lógica para excluir um usuário
    }
}
