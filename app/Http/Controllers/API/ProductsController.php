<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Supplier;
use App\Order;
use App\ProductSupplier;
use Auth;

class ProductsController extends Controller
{
    public function index() {
        return response()->json(Product::withTrashed()->where('id', '>', 0)->get());
    }

    public function store(Request $request) {
        $input = $request->all();
        $resp['success'] = false;
        $resp['message'] = 'Erro ao cadastrar produto.';
        $product = Product::create($input);

        if($product) {
            $resp['success'] = true;
            $resp['message'] = 'Produto cadastrado com sucesso.';
        }

        return response()->json($resp);
    }

    public function update(Request $request) {
        $input = $request->all();

        $user = Product::updateOrCreate(
            ['id' => $input['id']],
            $input
        );

        $resp['success'] = true;
        $resp['message'] = 'Dados atualizados.';
        
        return response()->json($resp);
    }

    public function show($id) {
        $supplier = Product::find($id);

        return response()->json($supplier);
    }

    public function deactivate($id) {
        $resp['success'] = false;
        $resp['message'] = 'Ocorreu um erro ao desativar o produto.';
        if(Product::destroy($id)) {
            $resp['success'] = true;
            $resp['message'] = 'Produto desativado com sucesso.';
        }

        return response()->json($resp);
    }

    public function reactivate($id) {
        $resp['success'] = false;
        $resp['message'] = 'Ocorreu um erro ao reativar o produto.';
        if(Product::withTrashed()->where('id', $id)->restore()) {
            $resp['success'] = true;
            $resp['message'] = 'Produto reativado com sucesso.';
        }

        return response()->json($resp);
    }

    public function checkout(Request $request) {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $order = Order::create($input);

        foreach($input['items'] as $i) {
            $i['order_id'] = $order['id'];
            $i['product_id'] = $i['product']['id'];
            $op = \App\OrderProduct::create($i);
            if($op) {
                $p = Product::find($i['product']['id']);
                $p->quantity -= $i['quantity'];
                $p->save();
            }
        }

        $resp['success'] = true;
        $resp['message'] = 'Compra realizada com sucesso.';

        return response()->json($resp);
    }
}
