<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use \App\User;
class UsersController extends Controller
{
    public function endereco($cep) {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://viacep.com.br/ws/'.$cep.'/json/');
        $endereco = $response->getBody();

        return $endereco;
    }

    public function current() {
        $resp['user'] = Auth::user();
        $resp['success'] = true;

        return response()->json($resp);
    }

    public function logout() {
        Auth::logout();

        return redirect('index');
    }

    public function update(Request $request) {
        $input = $request->all();
        if (isset($input['password'])) $input['password'] = bcrypt($input['password']);
        $user = User::updateOrCreate(
            ['id' => $input['id']],
            $input
        );

        $resp['success'] = true;
        $resp['message'] = 'Dados atualizados.';
        
        return response()->json($resp);
    }

    public function changePassword(Request $request) {
        $input = $request->all();
        $user = Auth::user();

        $user->password = bcrypt($input['password']);

        if($user->save()) {
            $resp['success'] = true;
            $resp['message'] = 'Senha alterada com sucesso.';
        } else {
            $resp['success'] = false;
            $resp['message'] = 'Erro ao alterar a senha.';
        }

        return response()->json($resp);
    }

    public function index() {
        $users = User::withTrashed()->where('id', '<>', Auth::user()->id)->get();
        $resp['data'] = $users;
        $resp['success'] = true;

        return response()->json($resp);
    }

    public function store(Request $request) {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['store_id'] = Auth::user()->store_id;
        $u = User::create($input);
        $resp['success'] = true;
        $resp['message'] = 'Usuário salvo com sucesso';

        return response()->json($resp);
    }

    public function deactivate($id) {
        $resp['success'] = false;
        $resp['message'] = 'Ocorreu um erro ao desativar o usuário.';
        if(User::destroy($id)) {
            $resp['success'] = true;
            $resp['message'] = 'Usuário desativado com sucesso.';
        }

        return response()->json($resp);
    }

    public function reactivate($id) {
        $resp['success'] = false;
        $resp['message'] = 'Ocorreu um erro ao desativar o usuário.';
        if(User::withTrashed()->where('id', $id)->restore()) {
            $resp['success'] = true;
            $resp['message'] = 'Usuário reativado com sucesso.';
        }

        return response()->json($resp);
    }

    public function show($id) {
        $user = User::find($id);

        return response()->json($user);
    }
}
