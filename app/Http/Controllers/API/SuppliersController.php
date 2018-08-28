<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Supplier;

class SuppliersController extends Controller
{
    public function index() {
        $suppliers = Supplier::withTrashed()->where('id', '>', '0')->get();

        return response()->json($suppliers);
    }

    public function store(Request $request) {
        $input = $request->all();
        $resp['success'] = false;
        $resp['message'] = 'Erro ao cadastrar fornecedor.';
        $supplier = Supplier::create($input);

        if($supplier) {
            $resp['success'] = true;
            $resp['message'] = 'Fornecedor cadastrado com sucesso.';
        }

        return response()->json($resp);
    }

    public function update(Request $request) {
        $input = $request->all();

        $user = Supplier::updateOrCreate(
            ['id' => $input['id']],
            $input
        );

        $resp['success'] = true;
        $resp['message'] = 'Dados atualizados.';
        
        return response()->json($resp);
    }

    public function show($id) {
        $supplier = Supplier::find($id);

        return response()->json($supplier);
    }

    public function deactivate($id) {
        $resp['success'] = false;
        $resp['message'] = 'Ocorreu um erro ao desativar o fornecedor.';
        if(Supplier::destroy($id)) {
            $resp['success'] = true;
            $resp['message'] = 'Fornecedor desativado com sucesso.';
        }

        return response()->json($resp);
    }

    public function reactivate($id) {
        $resp['success'] = false;
        $resp['message'] = 'Ocorreu um erro ao reativar o fornecedor.';
        if(Supplier::withTrashed()->where('id', $id)->restore()) {
            $resp['success'] = true;
            $resp['message'] = 'Fornecedor reativado com sucesso.';
        }

        return response()->json($resp);
    }
}
