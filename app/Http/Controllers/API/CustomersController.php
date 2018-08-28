<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;

class CustomersController extends Controller
{
    
    public function deactivate($id) {
        $resp['success'] = false;
        $resp['message'] = 'Ocorreu um erro ao desativar o cliente.';
        if(Customer::destroy($id)) {
            $resp['success'] = true;
            $resp['message'] = 'Cliente desativado com sucesso.';
        }

        return response()->json($resp);
    }

    public function index() {
        $customers = Customer::withTrashed()->where('id', '>', 0)->get();
        $resp['data'] = $customers;
        $resp['success'] = true;

        return response()->json($resp);
    }

    public function store(Request $request) {
        $input = $request->all();
        $u = Customer::create($input);
        $resp['success'] = true;
        $resp['message'] = 'Cliente salvo com sucesso';

        return response()->json($resp);
    }

    public function update(Request $request) {
        $input = $request->all();
        $customer = Customer::updateOrCreate(
            ['id' => $input['id']],
            $input
        );

        $resp['success'] = true;
        $resp['message'] = 'Dados atualizados.';
        
        return response()->json($resp);
    }

    public function reactivate($id) {
        $resp['success'] = false;
        $resp['message'] = 'Ocorreu um erro ao desativar o cliente.';
        if(Customer::withTrashed()->where('id', $id)->restore()) {
            $resp['success'] = true;
            $resp['message'] = 'Cliente reativado com sucesso.';
        }

        return response()->json($resp);
    }

    public function show($id) {
        $customer = Customer::find($id);

        return response()->json($customer);
    }

    public function monthBirthdays(){
        $resp['success'] = false;
        $resp['message'] = 'Ocorreu um erro ao buscar os aniversariantes do mês.';
        $customers = Customer::whereMonth('birthday', '=', date('m'))->get();
        $resp['message'] = 'Aniversariantes do mês buscados com sucesso.';
        $resp['success'] = true;
        $resp['data'] = $customers;

        return response()->json($resp);
    }
}
