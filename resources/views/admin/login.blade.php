@extends('admin.layouts.auth')
@section('body-class')
    login-page
@endsection
@section('auth-title')
    Вход в админ панель
@endsection

@section('auth-content')
    <div class="login-box">
        <div class="login-logo">
            <b>ЭСЧФ Admin</b>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Введите email и пароль для входа</p>

                <div class="alert alert-danger alert-dismissible visually-hidden js-wrong-pass-alert">
                    <div><i class="icon fas fa-ban"></i> Неправильный пароль</div>
                </div>

                <form id='admin-login-form'>
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Пароль" name="password" id="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Войти</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-0">
                    <a href="{{ route('admin.register') }}" class="text-center">Зарегистрировать нового пользователя</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
@endsection

@section('auth-scripts')
    @vite('resources/js/admin/login.ts')
@endsection
