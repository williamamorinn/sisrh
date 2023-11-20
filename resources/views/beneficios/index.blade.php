@extends('layouts.default')
@section('title', 'Benefício')

@section('content')
    <x-btn-create>
        <x-slot name="route">{{ @route('beneficios.create') }}</x-slot>
        <x-slot name="title">Cadastrar Benefício</x-slot>
    </x-btn-create>

    <h1 class="fs-2 mb-3">Lista de Benefícios</h1>

    @if (Session::get('sucesso'))
        <div class="alert alert-success text-center">{{ Session::get('sucesso') }}</div>
    @endif

    @if (Session::get('erro'))
        <div class="alert alert-danger text-center">{{ Session::get('erro') }}</div>
    @endif

    <x-busca>
        <x-slot name="rota">{{ route('beneficios.index') }}</x-slot>
        <x-slot name="tipo">Benefício</x-slot>
    </x-busca>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col" style="width:110px">Ações</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($beneficios as $beneficio)
                <tr class="align-middle">
                    <th class="text-center" scope="row">{{ $beneficio->id }}</th>
                    <td class="text-center">{{ $beneficio->descricao }}</td>
                    <td>
                        <a href="{{ route('beneficios.edit', $beneficio->id) }}" title="Editar" class="btn btn-primary"><i class="bi bi-pen"></i></a>
                        <a href="" title="Deletar" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $beneficio->id }}"><i class="bi bi-trash"></i></a>
                        {{-- Inserir o componente modal na view --}}
                        <x-modal-delete>
                            <x-slot name="id">{{ $beneficio->id }}</x-slot>
                            <x-slot name="tipo">Benefício</x-slot>
                            <x-slot name="nome">{{ $beneficio->descricao }}</x-slot>
                            <x-slot name="rota">beneficios.destroy</x-slot>
                        </x-modal-delete>
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
    {{ $beneficios->links() }}
@endsection
