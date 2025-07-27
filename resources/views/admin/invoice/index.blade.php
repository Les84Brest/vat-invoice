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
            <div class="card-body">
                <div class=" mb-2 js-invoices-table"> </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Выставленные счета фактуры по НДС</h3>
            </div>
            <div class="card-body">
                <div class="mb-2 js-invoice-table-wrap">
                    <h4>Фильтры</h4>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label>Отправитель</label>
                                <div class="select2-purple">
                                    <select class="select2" multiple="multiple" data-placeholder="Выберите компанию"
                                        data-dropdown-css-class="select2-purple" style="width: 100%;">
                                        <option>Alabama</option>
                                        <option>Alaska</option>
                                        <option>California</option>
                                        <option>Delaware</option>
                                        <option>Tennessee</option>
                                        <option>Texas</option>
                                        <option>Washington</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mb-2">
                    <table class="table table-bordered table-hover js-invoices-table-dt">
                        <thead>
                            <tr>
                                <th>Номер счета</th>
                                <th>Отправитель</th>
                                <th>Получатель</th>
                                <th>Сумма без НДС</th>
                                <th>Сумма НДС</th>
                                <th>Сумма с НДС</th>

                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-scripts')
    <script src="{{ asset('assets/admin/plugins/jsgrid/jsgrid.min.js') }}"></script>
    @vite('resources/js/admin/invoice.ts')
@endsection
