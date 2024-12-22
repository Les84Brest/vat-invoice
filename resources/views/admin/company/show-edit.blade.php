@extends('admin.layouts.admin')

@section('page-styles')
    <!-- jsGrid -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/jsgrid/jsgrid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/jsgrid/jsgrid-theme.min.css') }}">
@endsection

@section('content')
    @include('admin.components.content-header', ['title' => 'Информация об организации'])
    @csrf
    <section class="content">
        <div class="row">

            <div class="col-12">
                <div class="card card-widget widget-user ">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username">{{ $company->title }}</h3>
                        <h5 class="widget-user-desc"><b>УНП: </b>{{ $company->tax_id }}</h5>
                    </div>
                    <div class="widget-user-image">
                        {{-- <img class="img-circle elevation-2" src="../dist/img/user1-128x128.jpg" alt="User Avatar"> --}}
                        <div class="text-center img-circle" style="background: white">
                            <div class="company-page__icon">
                                <i class="fas fa-landmark "></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ $company->tax_id }}</h5>
                                    <span class="description-text">УНП</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ $company->address }}</h5>
                                    <span class="description-text">АДРЕС</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">35</h5>
                                    <span class="description-text">PRODUCTS</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                    href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                    aria-selected="true">Данные</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                    href="#custom-tabs-four-settings" role="tab"
                                    aria-controls="custom-tabs-four-profile" aria-selected="false">Настройки</a>
                            </li>

                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel"
                                aria-labelledby="custom-tabs-four-home-tab">
                                <h3>Пользователи</h3>
                                <div class="row">
                                    @if (!count($company->users))
                                        <div class="row">

                                            <div class="alert alert-info alert-dismissible m-3">
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-hidden="true">×</button>
                                                <h5><i class="icon fas fa-info"></i> Нет пользователей</h5>
                                                В организации нет зарегистрированных пользователей
                                            </div>
                                        </div>
                                    @else
                                        @foreach ($company->users as $user)
                                            <div class="col-lg-4 col-6">
                                                <!-- small card -->
                                                <div class="small-box bg-warning">
                                                    <div class="inner">
                                                        <h4>{{ $user->last_name }} {{ $user->name }}</h4>
                                                        <br>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <a href="{{ route('user.show', ['user' => $user->id]) }}"
                                                        class="small-box-footer">
                                                        Подробнее <i class="fas fa-arrow-circle-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <h3>ЭСЧФ</h3>
                                <h3>Выставленные</h3>
                                <div class="jsgrid js-table-outbox">
                                </div>
                                <h3>Полученные</h3>
                                <div class="jsgrid js-table-inbox">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel"
                                aria-labelledby="custom-tabs-four-settings-tab">
                                <div
                                    class="company-page__actions d-flex flex-row justify-content-end align-items-center mb-2 ">
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#modal-company-delete">Удалить</button>
                                </div>
                                <form action="#" class="js-updatecompany-form">
                                    @method('PATCH')
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Название</label>
                                        <input type="text" name="title" class="form-control" id="exampleInputEmail1"
                                            placeholder="Введите название" value="{{ $company->title }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="shortnameid">Сокращенное название</label>
                                        <input type="text" name="short_title" class="form-control" id="shortnameid"
                                            placeholder="Введите сокращенное название"
                                            value="{{ $company->short_title }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="taxidid">УНП</label>
                                        <input type="number" name="tax_id" class="form-control" id="taxidid"
                                            placeholder="Введите УНП" value="{{ $company->tax_id }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="addressid">Адрес</label>
                                        <input type="text" name="address" class="form-control" id="addressid"
                                            placeholder="Введите УНП" value="{{ $company->address }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Пользователи</label>
                                        <select class="select2" multiple="multiple" name="users[]"
                                            data-placeholder="Пользователи" style="width: 100%;">
                                            @foreach ($users as $user)
                                                @php
                                                    $found = array_filter($company->users->toArray(), function (
                                                        $person,
                                                    ) use ($user) {
                                                        return $user['id'] == $person['id'];
                                                    });
                                                @endphp
                                                <option value="{{ $user->id }}" @selected(!empty($found))>
                                                    {{ $user->last_name }} {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.card-body -->
                                    <button type="submit" class="btn btn-primary">Обновить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal-company-delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Удаление организации</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Вы действительно хотите удалить организацию {{ $company->title }}?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-outline-light js-btn-delete-company">Удалить</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('page-scripts')
    <script src="{{ asset('assets/admin/plugins/jsgrid/jsgrid.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            //submit update form
            $('.js-updatecompany-form').on('submit', async function(event) {
                event.preventDefault(); // Prevent the default form submission

                const formData = new FormData($(this)[0]);
                const csrfTokenInput = $('input[name="_token"]');
                const csrfToken = csrfTokenInput.val();

                try {
                    const response = await fetch('/admin/company/{{ $company->id }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        }
                    })
                    console.log('%chere', 'padding: 5px; background: DarkKhaki; color: Yellow;',
                        response);
                    if (response.ok) {
                        toastr["success"]("Данные организации обновлены");
                        setTimeout(() => {
                            window.location.href =
                                "{{ route('company.show', ['company' => $company->id]) }}"
                        }, 2000);
                    }
                } catch (error) {
                    console.log('%cerror', 'padding: 5px; background: hotpink; color: black;', error);
                    toastr["danger"]("Произошла ошибка");
                }

            });

            //delete company
            $('.js-btn-delete-company').click(function() {
                const csrfTokenInput = $('input[name="_token"]');
                const csrfToken = csrfTokenInput.val();

                const modal = this.closest(".modal.fade");

                $.ajax({
                    url: '/admin/company/{{ $company->id }}',
                    type: 'DELETE',
                    contentType: 'multipart/form-data',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-type': 'application/json',
                    },
                    error: function(xhr, status, error) {
                        toastr["danger"]("Произошла ошибка");
                        modal.classList.remove('show');
                        modal.style.display = 'none';
                    },
                    success: function(response) {
                        modal.classList.remove('show');
                        modal.style.display = 'none';

                        toastr["success"]("Организация удалена");
                        setTimeout(() => {
                            window.location.href = "{{ route('company.index') }}";
                        }, 2000);
                    },
                });
            });
        });
        
        // invoice tables
        const commonConfig = {
            height: "100%",
            width: "100%",
            sorting: true,
            paging: true,

            fields: [{
                    name: "№ счета",
                    type: "text",
                    width: 150
                },

                {
                    name: "Дата совершения",
                    type: "number",
                    width: 100
                },
                {
                    name: "Дата выставления",
                    type: "number",
                    width: 100
                },
                {
                    name: "Получатель",
                    type: "number",
                },
                {
                    name: "Сумма без НДС",
                    type: "text",
                    width: 100
                },
                {
                    name: "Сумма НДС",
                    type: "text",
                    width: 100
                },
                {
                    name: "Сумма с НДС",
                    type: "text",
                    width: 100
                },
                {
                    name: "Статус",
                    type: "text",
                },
            ]
        }

        const outcomeData = [{
                "№ счета": '291555555-03092024-0000001',
                "Получатель": "ОДО Техимпорт",
                "Дата совершения": "08.06.2024",
                "Дата выставления": "10.07.2024",
                "Сумма с НДС": 1440.00,
                "Сумма НДС": 240.00,
                "Сумма без НДС": 1200.00,
                "Статус": "Выставлен"
            },
            {
                "№ счета": '291555555-03092024-0000015',
                "Получатель": "ОДО Санта-Рест",
                "Дата выставления": "05.07.2024",
                "Дата совершения": "15.06.2024",
                "Сумма с НДС": 1176.00,
                "Сумма НДС": 196.00,
                "Сумма без НДС": 980.00,
                "Статус": "Подписан получателем"

            },
            {
                "№ счета": '291555555-03092024-0000015',
                "Получатель": "ОДО Санта-Рест",
                "Дата выставления": "05.07.2024",
                "Дата совершения": "15.06.2024",
                "Сумма с НДС": 1176.00,
                "Сумма НДС": 196.00,
                "Сумма без НДС": 980.00,
                "Статус": "Подписан получателем"

            },
            {
                "№ счета": '291555555-03092024-0000015',
                "Получатель": "ОДО Санта-Рест",
                "Дата выставления": "05.07.2024",
                "Дата совершения": "15.06.2024",
                "Сумма с НДС": 1176.00,
                "Сумма НДС": 196.00,
                "Сумма без НДС": 980.00,
                "Статус": "Подписан получателем"

            },
            {
                "№ счета": '291555555-03092024-0000015',
                "Получатель": "ОДО Санта-Рест",
                "Дата выставления": "05.07.2024",
                "Дата совершения": "15.06.2024",
                "Сумма с НДС": 1176.00,
                "Сумма НДС": 196.00,
                "Сумма без НДС": 980.00,
                "Статус": "Подписан получателем"

            },
            {
                "№ счета": '291555555-03092024-0000015',
                "Получатель": "ОДО Санта-Рест",
                "Дата выставления": "05.07.2024",
                "Дата совершения": "15.06.2024",
                "Сумма с НДС": 1176.00,
                "Сумма НДС": 196.00,
                "Сумма без НДС": 980.00,
                "Статус": "Подписан получателем"

            },
            {
                "№ счета": '291555555-03092024-0000015',
                "Получатель": "ОДО Санта-Рест",
                "Дата выставления": "05.07.2024",
                "Дата совершения": "15.06.2024",
                "Сумма с НДС": 1176.00,
                "Сумма НДС": 196.00,
                "Сумма без НДС": 980.00,
                "Статус": "Подписан отправителем"
            }
        ];

        $(".js-table-outbox").jsGrid({
            ...commonConfig,
            data: outcomeData
        });
        $(".js-table-inbox").jsGrid({
            ...commonConfig,
            data: outcomeData
        });
    </script>
@endsection
