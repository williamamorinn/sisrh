<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;


class UserController extends Controller
{
    public function index()
    {
        $user = User::all()->sortBy('name');

        $totalUsers = User::all()->count();

        if (Gate::allows('tipo-user')) {
            // Receber os dados do banco através do model
            return view('users.index', compact('user', 'totalUsers'));
        } else {
            return back();
        }
    }

    public function create()
    {
        if (Gate::allows('tipo-user')) {
            $user = new User();
            return view('users.create', compact('user'));
        } else {
            return back();
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('tipo-user')) {
            $input = $request->toArray();
            //dd($input);

            $input['user_id'] = 1;

            User::create($input);
            $input['password'] = bcrypt($input['password']);
            return redirect()->route('users.index')->with('sucesso', 'Usuário cadastrado com sucesso!');
        } else {
            return back();
        }
    }


    public function edit(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return back();
        }

        if (auth()->user()->id == $user['id'] || auth()->user()->tipo == 'admin') {
            return view('users.edit', compact('user'));
        } else {
            return back();
        }
    }

    public function update(Request $request, string $id)

    {
        $input = $request->toArray();
        $user = User::find($id);
        if ($input['password'] != null) {
            $input['password'] = bcrypt($input['password']);
        } else {
            $input['password'] = $user['password'];
        }

        $user->fill($input);
        $user->save();

        if ($user->tipo == "admin") {
            return redirect()->route('users.index')->with(
                'sucesso',
                'Usuário alterado com sucesso!'
            );
        } else {
            return redirect()->route('users.edit', $user->id)->with(
                'sucesso',
                'Usuário alterado com sucesso!'
            );
        }
    }



    public function destroy(User $user)
    {
        // Lógica para excluir um usuário
    }
}
