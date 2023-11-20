@extends('layouts.default')
@section('title', 'User')

@section('content')
    <x-btn-create>
        <x-slot name="route">{{ route('users.create') }}</x-slot>
        <x-slot name="title">Cadastrar Usuário</x-slot>
    </x-btn-create>

    <h1 class="fs-2 mb-3">Lista Usuários</h1>

    <p>Total de usuários: {{ $totalUsers }}</p>

    @if (Session::get('sucesso'))
        <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
    @endif

    <x-busca>
        <x-slot name="rota">{{ route('users.index') }}</x-slot>
        <x-slot name="tipo">Usuário</x-slot>
    </x-busca>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Tipo</th>
                <th scope="col" width="110px">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $usuario)
            <tr class="aling-middle text-center">
                <th scope="row">{{ $usuario->id }}</th>
                <td>{{ $usuario->name}}</td>
                <td>{{ $usuario->email}}</td>
                <td>{{ $usuario->tipo}}</td>
                <td>
                    <a href="{{ route('users.edit', $usuario->id) }}" title="Editar" class="btn btn-primary"><i class="bi bi-pen"></i></a>
                    <a href="" title="Deletar" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $usuario->id }}"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <style>
        .pagination {
            justify-content: center;
        }
    </style>
    {{ $user->links() }}
@endsection
