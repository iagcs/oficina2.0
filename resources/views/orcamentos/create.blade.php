@extends('templates.template')

<!-- A PÁGINA CREATE SERVE TANTO PARA A ABA EDITAR QUANTO PARA A ABA CADASTRAR. FOI NECESSARIO APENAS FAZER As VERIFICAÇÕES SE A VARIAVEL 
  $orcamento FOI PASSADA PALO COMPACT, QUE NO CASO SOMENTE A FUNCAO EDIT PASSA O ORCAMENTO QUE SERÁ EDITADO-->

@section('content')
    <h1 class="display-1 text-dark text-center font-weight-bold">
        @if (isset($orcamento))Editar @else Cadastrar @endif
    </h1>

    <div class="col-8 m-auto ">

        <!-- FAZ AS VERIFICAÇÕES DO FORM REQUEST, QUE RETORNA ERROS SE ESTIVEREM FORA DAS REGRAS DITADAS NO ARQUIVO App\Http\Requests\OrcamentoRequest E 
        DESSA FORMA O USÚARIO NÃO CONSEGUE REALIZAR O CADASTRO -->
        @if (isset($errors) && count($errors) > 0)
            <div class="text-center mt-4 mb-4 p-2 alert-danger">
                @foreach ($errors->all() as $erro)
                    {{ $erro }}<br>
                @endforeach
            </div>
        @endif
            
        <div class="col-11 container mt-4">
            <div class="text-center mt-6 mb-4 rounded">
                @if (isset($orcamento))
                    <form name="formEdit" id="formEdit" method="post"
                        action="{{ url("orcamentos/edit/$orcamento->id") }}">
                    @else
                        <form name="formCad" id="formCad" method="post" action="{{ url('orcamentos/store') }}">
                @endif
                <!-- SE O USUARIO CLICAR EM EDITAR, AS INFORMAÇÕES SERAO MOSTRADAS EM CADA INPUT. PORTANTO A ABA EDIT TAMBÉM SERVE COMO UMA FORMA DE VISUALIZAR O ORCAMENTO -->      
                @csrf
                <input class="form-control mt-4 mb-4 p-2" type="text" name="cliente" id="cliente" placeholder="Cliente"
                    value="{{ $orcamento->cliente ?? '' }}" required>
                <input class="form-control mt-4 p-2" type="text" name="vendedor" id="vendedor" placeholder="Vendedor"
                    value="{{ $orcamento->vendedor ?? '' }}" required>
                <input class="form-control mt-4 p-2" type="text" name="valor_orcado" id="valor_orcado"
                    placeholder="Valor Orçado" value="{{ $orcamento->valor_orcado ?? '' }}" required>
                <input class="form-control mt-4 p-2" type="date" name="data" id="data" placeholder="Data Criacao"
                    value="{{ $orcamento->data ?? '' }}" required>
                <input class="form-control mt-4 p-2" type="time" name="hora" id="hora" placeholder="Horário Criação"
                    value="{{ $orcamento->hora ?? '' }}" required>
                <textarea rows="7" class="form-control mt-4 p-2 input-lg" type="text" name="descricao" id="descricao"
                    placeholder="Descricao">{{ $orcamento->descricao ?? '' }}</textarea>
                <input class="btn btn-primary mt-4  p-2 " type="submit" value="@if (isset($orcamento)) Editar @else Cadastrar @endif">
                </form>
                <a href="{{ url('orcamentos') }}">
                    <button class="btn btn-dark mt-3" style="text-align: right;">Voltar</button>
                </a>

            </div>
        </div>

    </div>
@endsection
