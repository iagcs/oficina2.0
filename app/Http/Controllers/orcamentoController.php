<?php

namespace App\Http\Controllers;

use App\Models\ModelOrcamento;
use App\Http\Requests\OrcamentoRequest;
use Illuminate\Http\Request;

class orcamentoController extends Controller
{
    private $objOrcamento;

    function __construct(){
        $this->objOrcamento = new ModelOrcamento();
    }

    /** 
     * FUNCAO QUE RETORNA PARA A VIEW DE PAGINA INICIAL COM TODOS OS ORCAMENTOS
     */
    function index(){
        $orcamentos = $this->objOrcamento->orderBy('data', 'desc')->simplePaginate(10);
        return view('orcamentos.index',compact('orcamentos'));
    }

    /** 
     * FUNCAO QUE RETORNA A VIEW QUE CONTEM O FORMULARIO DE CADASTRO
     */
    function create(){
        return view('orcamentos.create');
    }

    /** 
     * SALVA TODOS OS DADOS NO BANCO DE DADOS
     */
    function store(OrcamentoRequest $request){
        $this->objOrcamento->create([
            'cliente'=> $request->cliente,
            'vendedor'=> $request->vendedor,
            'data'=> $request->data,
            'hora'=> $request->hora,
            'descricao'=> $request->descricao,
            'valor_orcado'=> $request->valor_orcado,
        ]);

        return redirect('orcamentos');
    }

    /** 
     * FUNÇÃO EDIT RECEBE O ID DO ORCAMENTO QUE SERA EDITADO E RETORNA PARA A VIEW CREATE COMPACTANDO O ORCAMENTO QUE TEM O MESMO ID PASSADO POR PARAMETRO PARA A FUNCAO
     */
    function edit($id){
        $orcamento = $this->objOrcamento->where('id','=',$id)->first();
        return view('orcamentos.create',compact('orcamento'));
    }

    /** 
     * ATUALIZA OS DADOS DO ORCAMENTO EDITADO
     */
    function update(OrcamentoRequest $request, $id){
        $this->objOrcamento->where(['id'=>$id])->update([
            'cliente'=> $request->cliente,
            'vendedor'=> $request->vendedor,
            'data'=> $request->data,
            'hora'=> $request->hora,
            'descricao'=> $request->descricao,
            'valor_orcado'=> $request->valor_orcado,
        ]);

        return redirect('orcamentos');
    }

    /** 
     * ESSA FUNÇÃO FUNCIONA COMO UM FUNIL QUE DE ACORDO COM O RESULTADO DO FORMULARIO DO FUNIL, BUSCA NO BANCO SOMENTE OS ORCAMENTOS QUE SE ENCAIXAM COM O QUE FOI SELECIONADO NO FILTRO 
     */
    function search(Request $request){
        $cliente = $request->input('cliente');
        $vendedor = $request->input('vendedor');
        $dataInicio = $request->input('dataInicio');
        $dataFim = $request->input('dataFim');

        /** 
         * 1 CONDIÇÃO: SELECIONA TODOS OS ORCAMENTOS EM QUE TEM TODOS OS CLIENTES E SOMENTE OS VENDEDORES SELECIONADOS E O INTERVALO DE DATAS
         * 2 CONDIÇÃO: SELECIONA TODOS OS ORCAMENTOS EM QUE TEM TODOS OS VENDEDORES E SOMENTE OS CLIENTES SELECIONADOS E O INTERVALO DE DATAS
         * 3 CONDIÇÃO: SELECIONA TODOS OS ORCAMENTOS EM QUE TEM TODOS OS CLIENTES E VENDEDORES E O INTERVALO DE DATAS
         * 4 CONDIÇÃO: SELECIONA TODOS OS ORCAMENTOS EM QUE TEM OS CLIENTES E VENDEDORES SELECIONADOS E O INTERVALO DE DATAS
         */
        if($cliente == "TODOS" && $vendedor !== "TODOS"){
            $orcamentos = $this->objOrcamento->where('vendedor','=',$vendedor)->where('data','>=', $dataInicio)->where('data','<=', $dataFim)->orderBy('data', 'desc')->simplePaginate(10);
        }
        if($vendedor == "TODOS" && $cliente !== "TODOS"){
            $orcamentos = $this->objOrcamento->where('cliente','=',$cliente)->where('data','>=', $dataInicio)->where('data','<=', $dataFim)->orderBy('data', 'desc')->simplePaginate(10);
        }

        if($cliente == "TODOS" && $vendedor == "TODOS"){
            $orcamentos = $this->objOrcamento->where('data','>=', $dataInicio)->where('data','<=', $dataFim)->orderBy('data', 'desc')->simplePaginate(10);
        }
        if($cliente !== "TODOS" && $vendedor !== "TODOS"){
            $orcamentos = $this->objOrcamento->where('cliente','=',$cliente)->where('vendedor','=',$vendedor)->where('data','>=', $dataInicio)->where('data','<=', $dataFim)->orderBy('data', 'desc')->simplePaginate(10);
        }
        $orc = $this->objOrcamento->all();

        /**
         * PARA FAZER A PAGINAÇÃO COM OS FILTROS SELECIONADOS FOI PRECISO "CUSTOMIZAR" A URL PARA QUE A PAGINAÇÃO FUNCIONASSE NORMALMENTE,
         * JÁ QUE A URL COM OS FILTROS SELECIONADOS TEM ALGUNS ATRIBUTOS
         */
        $orcamentos->withPath('?cliente='.$cliente.'&vendedor='.$vendedor.'&dataInicio='.$dataInicio.'&dataFim='.$dataFim);


        return view('orcamentos.filtro',compact('orcamentos','orc','cliente','vendedor','dataInicio','dataFim'));
    }

    /** 
     * DELETA UM ORÇAMENTO
     */
    public function destroy($id)
    {
        $del=$this->objOrcamento->destroy($id);
        return($del)?"sim":"nao";
    }


}
