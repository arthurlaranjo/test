@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastrar</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}" >
                        @csrf

                        <div  class="row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Nome:') }}</label>

                            <div class="form-group col-xs-10 offset-xs-1 col-md-4">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus >

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                           
                            <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('Email:') }}</label>

                            <div class="col-md-4">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                           
                        </div>
                        </div>
                        

                        <div class="form-group row">
                             <label for="cpf" class="col-md-2 col-form-label text-md-right">{{ __('  CPF:') }}</label>

                            <div class="col-md-4">
                                <input id="cpf" type="text" class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" value="{{ old('cpf') }}" required autofocus>

                                @if ($errors->has('cpf'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cpf') }}</strong>
                                    </span>
                                @endif
                            </div>
                             <label for="rg" class="col-md-2 col-form-label text-md-right">{{ __('RG:') }}</label>

                            <div class="col-md-4">
                                <input id="rg" type="text" class="form-control{{ $errors->has('rg') ? ' is-invalid' : '' }}" name="rg" value="{{ old('rg') }}" required autofocus>

                                @if ($errors->has('rg'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('rg') }}</strong>
                                    </span>
                                @endif
                            </div>

                            
                        </div>

                        

                        <div class="form-group row">

                            <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Senha:') }}</label>

<div class="col-md-4">
    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

    @if ($errors->has('password'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
    @endif
</div>
                            
                            <label for="password-confirm" class="col-md-2 col-form-label text-md-right">{{ __('Confirmar senha:') }}</label>

                            <div class="col-md-4">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            


                        </div>

                       
                        <div class="form-group row">
                        <label for="address" class="col-md-2 col-form-label text-md-right ">{{ __('Endereço:') }}</label>
                            <div class="col-md-4">
                            <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') }}" required autofocus>

                                @if ($errors->has('address'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('address') }}</strong>
                            </span>
                            @endif
</div>

                            <label for="number" class="col-md-2 col-form-label text-md-right">{{ __('Numero:') }}</label>

                            <div class="col-md-4">
                                <input id="number" type="text" class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" name="number" value="{{ old('number') }}" required autofocus>

                                @if ($errors->has('number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('number') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                        </div>
                        <div class="form-group row">
                           
                        
                        <label for="cep" class="col-md-2 col-form-label text-md-right">{{ __('CEP:') }}</label>

<div class="col-md-4">
    <input id="cep" type="text" class="form-control{{ $errors->has('cep') ? ' is-invalid' : '' }}" name="cep" value="{{ old('cep') }}" required autofocus>

    @if ($errors->has('cep'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('cep') }}</strong>
        </span>
    @endif
</div>
                        
                        
                        <label for="city" class="col-md-2 col-form-label text-md-right">{{ __('Cidade:') }}</label>

<div class="col-md-4">
    <input id="cidade" type="text" class="form-control{{ $errors->has('cidade') ? ' is-invalid' : '' }}" name="cidade" value="{{ old('cidade') }}" required autofocus>

    @if ($errors->has('cidade'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('cidade') }}</strong>
        </span>
    @endif
</div>
                           
                           
                           
                        </div>
                        <div class="form-group row">
                            <label for="mobile_phone" class="col-md-2 col-form-label text-md-right">{{ __('Celular:') }}</label>

                            <div class="col-md-4">
                                <input id="mobile_phone" type="text" class="form-control{{ $errors->has('mobile_phone') ? ' is-invalid' : '' }}" name="mobile_phone" value="{{ old('mobile_phone') }}" required autofocus>

                                @if ($errors->has('mobile_phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mobile_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <label for="phone" class="col-md-2 col-form-label text-md-right">{{ __('Telefone:') }}</label>

                            <div class="col-md-4">
                                <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus>

                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                           
                        <label for="district" class="col-md-2 col-form-label text-md-right">{{ __('Bairro:') }}</label>

<div class="col-md-4">
    <input id="district" type="text" class="form-control{{ $errors->has('district') ? ' is-invalid' : '' }}" name="district" value="{{ old('district') }}" required autofocus>

    @if ($errors->has('district'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('district') }}</strong>
        </span>
    @endif
</div>

                            <label for="observation" class="col-md-2 col-form-label text-md-right">{{ __('Complemento:') }}</label>

                            <div class="col-md-4">
                                <input id="observation" type="text" class="form-control{{ $errors->has('observation') ? ' is-invalid' : '' }}" name="observation" value="{{ old('observation') }}" required autofocus>

                                @if ($errors->has('observation'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('observation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-5">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Cadastrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
