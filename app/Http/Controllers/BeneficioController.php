<?php

namespace App\Http\Controllers;

use App\Models\Beneficio;
use Illuminate\Http\Request;

class BeneficioController extends Controller
{
    /* Verificar se o usuário estar logado no sistema */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $beneficios = Beneficio::where('descricao', 'like', '%'.$request->busca.'%')
        ->orderby('descricao', 'asc')->paginate(3);

        $totalBeneficios = Beneficio::all()->count();

        // Receber os dados do banco através do model
        return view('beneficios.index', compact('beneficios', 'totalBeneficios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('beneficios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->toArray();
        //dd($input);

        $input['user_id'] = auth()->user()->id;
        Beneficio::create($input);

        return redirect()->route('beneficios.index')->with('sucesso', 'Benefício cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $beneficio = Beneficio::find($id);

        if(!$beneficio){
            return back();
        }

        return view('beneficios.edit', compact('beneficio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $beneficio = Beneficio::find($id);

        $beneficio->descricao = $request->input('descricao');
        $beneficio->save();

        return redirect()->route('beneficios.index')->with('sucesso', 'Benefício alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $beneficio = Beneficio::with('funcionarios')->find($id);

        if ($beneficio) {
            $funcionariosRelacionados = $beneficio->funcionarios;

            if ($funcionariosRelacionados->isEmpty()) {
                $beneficio->delete();
                return redirect()->route('beneficios.index')->with('sucesso', 'Benefício excluído');
            } else {
                return redirect()->route('beneficios.index')->with('erro', 'Benefício vinculado a funcionários. Exclusão cancelada!');
            }
        }

        return redirect()->route('beneficios.index')->with('erro', 'Benefício não encontrado.');
    }
}
