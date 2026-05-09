@extends('admin.layouts.admin')

@section('page-styles')
@endsection

@section('content')
    @include('admin.components.content-header', ['title' => 'Пользователь'])
    @csrf
    <section class="content">
        <div class="row">
            <div class="col-12">
                <!-- Custom Tabs -->
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <div class="user__card-header p-3">
                            <h3>{{ $user->last_name }} {{ $user->name }}</h3>
                            @if (!$user->company)
                                <span>Организация не назначена</span>
                            @else
                                <span>{{ $user->company->title }}</span>
                            @endif
                            <button type="button" class="btn btn-danger ml-2" data-toggle="modal"
                                data-target="#modal-user-delete">Удалить</button>
                        </div>
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab_invoices" data-toggle="tab">
                                    Счета
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab_settings" data-toggle="tab">
                                    Настройки
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_invoices">
                                @if ($user->company)
                                    <h3>Выставленные счета</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>№ счета</th>
                                                    <th>Дата совершения</th>
                                                    <th>Дата выставления</th>
                                                    <th>Получатель</th>
                                                    <th>Статус</th>
                                                    <th>Сумма без НДС</th>
                                                    <th>Сумма НДС</th>
                                                    <th>Сумма с НДС</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($sentInvoices as $invoice)
                                                    <tr>
                                                        <td>{{ $invoice->number }}</td>
                                                        <td>{{ $invoice->action_date ? \Carbon\Carbon::parse($invoice->action_date)->format('d.m.Y') : '' }}</td>
                                                        <td>{{ $invoice->creation_date ? \Carbon\Carbon::parse($invoice->creation_date)->format('d.m.Y') : '' }}</td>
                                                        <td>{{ $invoice->recipient_company?->title }}</td>
                                                        <td>
                                                            <span class="badge {{ \App\Types\InvoiceStatus::getBadgeClass($invoice->status) }}">
                                                                {{ \App\Types\InvoiceStatus::getLabel($invoice->status) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ number_format($invoice->total_wo_vat, 2, '.', ' ') }}</td>
                                                        <td>{{ number_format($invoice->total_vat, 2, '.', ' ') }}</td>
                                                        <td>{{ number_format($invoice->total, 2, '.', ' ') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center">Нет выставленных счетов</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <h3>Полученные счета</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>№ счета</th>
                                                    <th>Дата совершения</th>
                                                    <th>Дата выставления</th>
                                                    <th>Отправитель</th>
                                                    <th>Статус</th>
                                                    <th>Сумма без НДС</th>
                                                    <th>Сумма НДС</th>
                                                    <th>Сумма с НДС</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($receivedInvoices as $invoice)
                                                    <tr>
                                                        <td>{{ $invoice->number }}</td>
                                                        <td>{{ $invoice->action_date ? \Carbon\Carbon::parse($invoice->action_date)->format('d.m.Y') : '' }}</td>
                                                        <td>{{ $invoice->creation_date ? \Carbon\Carbon::parse($invoice->creation_date)->format('d.m.Y') : '' }}</td>
                                                        <td>{{ $invoice->sender_company?->title }}</td>
                                                        <td>
                                                            <span class="badge {{ \App\Types\InvoiceStatus::getBadgeClass($invoice->status) }}">
                                                                {{ \App\Types\InvoiceStatus::getLabel($invoice->status) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ number_format($invoice->total_wo_vat, 2, '.', ' ') }}</td>
                                                        <td>{{ number_format($invoice->total_vat, 2, '.', ' ') }}</td>
                                                        <td>{{ number_format($invoice->total, 2, '.', ' ') }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center">Нет полученных счетов</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <span class="h2">Нет счетов для показа</span>
                                @endif
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_settings">

                                <form class="js-user-edit-form" action="#">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input type="email" value="{{ $user->email }}" name="email"
                                                class="form-control" id="exampleInputEmail1" placeholder="Введите email">
                                        </div>
                                        <div class="form-group">
                                            <label for="userlastnameid">Фамилия</label>
                                            <input type="text" value="{{ $user->last_name }}" name="last_name"
                                                class="form-control" id="userlastnameid" placeholder="Введите фамилию">
                                        </div>
                                        <div class="form-group">
                                            <label for="usernameid">Имя</label>
                                            <input type="text" value="{{ $user->name }}" name="name"
                                                class="form-control" id="usernameid" placeholder="Введите имя">
                                        </div>
                                        <div class="form-group">
                                            <label for="usercomp">Организация</label>
                                            <select class="form-control select2 js-company-select" name="company_id"
                                                id="usercomp" style="width: 100%;">
                                                <option value="placeholder" checked>Выберите организацию</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        @if ($user->company) @selected($user->company->id == $company->id) @endif>
                                                        {{ $company->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword1"
                                                placeholder="Password">
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Обновить</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- ./card -->
            </div>
    </section>

    <div class="modal fade" id="modal-user-delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Удаление пользователя</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Вы действительно хотите удалить пользователя {{ $user->last_name }} {{ $user->name }}?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-outline-light js-btn-delete-user">Удалить</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('page-scripts')
    <script>
        $(document).ready(function() {
            // update user
            $('.js-user-edit-form').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const form = $(this)[0];
                const formData = new FormData(form);

                const jsonData = {};

                formData.forEach((val, key) => {
                    jsonData[key] = val;
                })

                const csrfTokenInput = $('input[name="_token"]');
                const csrfToken = csrfTokenInput.val();

                $.ajax({
                    url: '/admin/user/{{ $user->id }}',
                    type: 'PATCH',
                    contentType: 'multipart/form-data',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-type': 'application/json',
                    },
                    data: JSON.stringify(jsonData),
                    success: function(response) {
                        toastr["success"]("Данные пользователя обновлены");
                    },
                    error: function(xhr, status, error) {
                        toastr["danger"]("Произошла ошибка");
                    }
                });

            });

            //delete user
            $('.js-btn-delete-user').click(function() {
                const csrfTokenInput = $('input[name="_token"]');
                const csrfToken = csrfTokenInput.val();

                const modal = this.closest(".modal.fade");

                $.ajax({
                    url: '/admin/user/{{ $user->id }}',
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

                        toastr["success"]("Пользователь удален");
                        setTimeout(() => {
                            window.location.href = '/admin/user/';
                        }, 2000);
                    },
                });
            });
        });
    </script>
@endsection
