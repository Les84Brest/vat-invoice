@extends('admin.layouts.admin')
@section('page-styles')
    {{-- <link rel="stylesheet" href="{{ asset('assets/admin/plugins/jsgrid/jsgrid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/jsgrid/jsgrid-theme.min.css') }}"> --}}

    {{-- dataTables styling --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    @include('admin.components.content-header', ['title' => 'ЭСЧФ'])
    @csrf
    <section class="content">
        <style>
            .js-invoices-table {
                min-height: 100%;
            }
        </style>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Выставленные счета фактуры по НДС</h3>
            </div>
            <div class="card-body">
                <div class="mb-2 js-invoice-table-wrap">
                    <h4>Фильтры</h4>
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <div class="form-group">
                                <label for="sender_company_id">Отправитель</label>
                                <div class="select2-purple">
                                    <select class="js-select-multiple" multiple="multiple"
                                        data-placeholder="Выберите компанию" data-dropdown-css-class="select2-purple"
                                        style="width: 100%;" data-filter-name="sender_company_id" id="sender_company_id">
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->short_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="form-group">
                                <label>Получатель</label>
                                <div class="select2-purple">
                                    <select class="js-select-multiple" multiple="multiple"
                                        data-placeholder="Выберите компанию" data-dropdown-css-class="select2-purple"
                                        style="width: 100%;" data-filter-name="resc_company_id">
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->short_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="form-group">
                                <label>Автор счета</label>
                                <div class="select2-purple">
                                    <select class="js-select-multiple" multiple="multiple"
                                        data-placeholder="Выберите автора" data-dropdown-css-class="select2-purple"
                                        style="width: 100%;" data-filter-name="author_id">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="form-group">
                                <label>Подписант счета</label>
                                <div class="select2-purple">
                                    <select class="js-select-multiple" multiple="multiple"
                                        data-placeholder="Выберите" data-dropdown-css-class="select2-purple"
                                        style="width: 100%;" data-filter-name="signatory_id">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <table class="table table-bordered table-hover js-data-table">

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('page-scripts')
    <script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    @vite('resources/js/admin/invoice.ts')
@endsection
