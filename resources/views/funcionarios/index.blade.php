@extends('layouts.default')

@section('title', 'Funcionários - SISRH ')

@section('content')
     <x-btn-create>
        <x-slot name="route">{{ route('funcionarios.create') }}</x-slot>
        <x-slot name="title">Cadastrar Funcionário</x-slot>
     </x-btn-create>

    <h1 class="f-2 mb-3">Funcionários</h1>

    <p>Total de Funcionários: {{ $totalFuncionarios }}</p>

    @if (Session::get('sucesso'))
     <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
    @endif

    <x-busca>
        <x-slot name="rota">{{ route('funcionarios.index') }}</x-slot>
        <x-slot name="tipo">Funcionário</x-slot>
    </x-busca>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th scope="col">ID</th>
                <th scope="col">Foto</th>
                <th scope="col">Nome</th>
                <th scope="col">Cargo</th>
                <th scope="col">Departamento</th>
                <th scope="col" width="110">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($funcionarios as $funcionario)
                <tr class="align-middle">
                    <th scope="row" class="text-center">{{ $funcionario->id }}</th>
                    <td class="text-center">
                        @if (empty($funcionario->foto))
                            <img src="/images/sombra_funcionario.jpg" alt="Foto" class="img-thumbnail" width="70">
                        @else
                            <img src="{{ url("storage/funcionarios/$funcionario->foto") }}" alt="Fotos" class="img-thumbnail" width="70">
                        @endif
                    </td>
                    <td>{{ $funcionario->nome }}</td>
                    <td class="text-center">{{ $funcionario->cargo->descricao }}</td>
                    <td class="text-center">{{ $funcionario->departamento->nome }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('funcionarios.edit', $funcionario->id) }}" title="Editar" class="btn btn-primary me-1 rounded">
                                <i class="bi bi-pen"></i> 
                            </a>
                            <a href="" title="Deletar" class="btn btn-danger me-1 rounded" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $funcionario->id }}">
                                <i class="bi bi-trash"></i> 
                            </a>
                            {{-- Inserir o componente modal na view --}}
                            <x-modal-delete>
                                <x-slot name="id">{{ $funcionario->id }}</x-slot>
                                <x-slot name="tipo">Funcionário</x-slot>
                                <x-slot name="nome">{{ $funcionario->nome }}</x-slot>
                                <x-slot name="rota">funcionarios.destroy</x-slot>
                            </x-modal-delete>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <style>
        .pagination{
            justify-content: center;
        }

    </style>
    {{ $funcionarios->links() }}
@endsection
