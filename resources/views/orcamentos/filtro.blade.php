@extends('templates.template')

@section('content')
<div class="mb-4">
    <h1 class="display-1 text-dark text-center font-weight-bold">
        Oficina 2.0
    </h1>
</div>

<div class="text-center  container mt-8 mb-2 " style="width: 400px;">
    <a href="{{ url('orcamentos/create') }}">
        <button class="btn btn-info btn-lg btn-block">Cadastrar</button>
    </a>
</div>

<div class="row ">

    <!-- FILTRO DE PESQUISA -->
    <div class="col-11 mt-4 container">
        <div class="card border-0 shadow-sm bg-dark">
            <div class="card-body">
                <form action="/orcamentos/filtro" method="GET" enctype="application/x-www-form-urlencoded">
                    <div class="row">
                        <div class="col-2">
                            <select class="form-select  rounded" id="cliente" name="cliente">
                                <option selected>TODOS</option>
                                @foreach ($orc as $item)
                                @if ($item->cliente == $cliente)
                                <option value={{ $item->cliente }} selected>{{ $item->cliente }}</option>
                                @else
                                <option value={{ $item->cliente }}>{{ $item->cliente }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <select class="form-select  rounded" id="vendedor" name="vendedor">
                                <option selected>TODOS</option>
                                @foreach ($orc as $item)
                                @if ($item->vendedor == $vendedor)
                                <option value={{ $item->vendedor }} selected>{{ $item->vendedor }}</option>
                                @else
                                <option value={{ $item->vendedor }}>{{ $item->vendedor }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <input type="date" class="form-control" value={{ $dataInicio }} id="dataInicio" name="dataInicio">
                        </div>
                        <div class="col">
                            <input type="date" class="form-control" value={{ $dataFim }} id="dataFim" name="dataFim">
                        </div>
                        <div class="col-1">
                            <div class="d-grid gap-2">
                                <button class="btn btn-success" type="submit">Filtrar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TABELA COM OS ORÇAMENTOS -->
    <div class="col-11 container">
        @csrf
        <table class="table table-striped table-dark text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Vendedor</th>
                    <th scope="col">Data</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Valor Orçado</th>
                </tr>
            </thead>
            <tbody>
                <!-- LOOP PARA MOSTRAR TODOS OS ORÇAMENTOS QUE SE ENCAIXAM NAS CONDIÇÕES ESPECIFICADAS PELO FILTRO DE PESQUISA -->
                @foreach ($orcamentos as $item)
                <tr>
                    <th scope="row">{{ $item->id }}</th>
                    <td>{{ $item->cliente }}</td>
                    <td>{{ $item->vendedor }}</td>
                    <td>{{ $item->data }}</td>
                    <td>{{ $item->hora }}</td>
                    <td>{{ $item->descricao }}</td>
                    <td>{{ $item->valor_orcado }}</td>
                    <td>
                        <!-- BOTÃO QUE REDIRECIONA PARA A PÁGINA EDITAR -->
                        <a href="{{ url("orcamentos/edit/$item->id") }}">
                            <button class="btn btn-primary">Editar</button>
                        </a>
                        <!-- BOTÃO QUE REDIRECIONA PARA DELETAR O ORCAMENTO ESPECIFICO -->
                        <a class="js-del" href="{{ url('') }}">
                            <button class="btn btn-danger">Deletar</button>
                        </a>
                    </td>
                </tr>
                @endforeach


            </tbody>
        </table>
        {{ $orcamentos->links() }}
    </div>
</div>
@endsection