@extends('admin.layouts.admin')

@section('content')
    @include('admin.components.content-header', ['title' => 'Пользователи'])
    @csrf
    <section class="content">
        <div class="row">
            <table class="table table-striped projects">
                <thead>
                    <tr>

                        <th style="width: 15%">
                            Фамилия
                        </th>
                        <th style="width: 15%">
                            Имя
                        </th>
                        <th style="width: 30%">
                            Организация
                        </th>

                        <th style="width: 10%" class="text-center">
                            Статус
                        </th>
                        <th style="width: 30%">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <td>
                            <a href="{{ route('user.show', ['user' => $user->id]) }}">
                                {{ $user->last_name }}
                            </a>

                        </td>
                        <td>
                            <span class="cell">{{ $user->name }}</span>
                        </td>
                        <td>
                            <span>
                                @if ($user->company_id)
                                    {{ $user->company->title }}
                                @else
                                    <div class="select-company">
                                        <div class="select-company__select-wrap">
                                            <select class="form-control select2 js-company-select" style="width: 100%;">
                                                <option value="placeholder" checked>Выберите организацию</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}">{{ $company->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-outline-info btn-flat js-save-company"
                                            data-user-id={{ $user->id }}><i class="fa fa-save"></i> </button>
                                    </div>
                                @endif
                            </span>
                        </td>
                        <td class="project-state">
                            <span class="badge badge-success">Активен</span>
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('user.show', ['user' => $user->id]) }}">
                                <i class="fas fa-folder">
                                </i>
                                Подробнее
                            </a>

                        </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </section>
@endsection

@section('page-scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            //настройка toastr
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "2500",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            // сохранение компании для пользователя

            $('.js-save-company').click(function() {
                const self = this;
                const $selectWrap = $(this).prev('.select-company__select-wrap');
                const companyId = $selectWrap.find('select').val();
                const userId = $(this).data('user-id');
                const csrfToken = $('input[name="_token"]').val();

                const url = '/admin/user/' + userId;

                $.ajax({
                    url, // Замените на ваш реальный URL бэкенда
                    method: 'POST', // Метод запроса на ваш выбор (POST, GET и т. д.)
                    data: {
                        company_id: companyId,
                        _method: 'PUT'
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken, // Добавление заголовка
                    },
                    success: function(response) {
                        const companyName = response.data.companyName;
                        const msg =
                            `Для пользователя назначена организация ${response.data.companyName}`;

                        toastr["success"](msg);


                        const selectWrap = self.closest('.select-company');
                        // selectWrap.empty();
                        selectWrap.innerText = companyName;


                    },
                    error: function(xhr, status, error) {

                        toastr["error"](
                            "Ошибка на сервере"
                        );
                    }
                });
            });




        });
    </script>
@endsection
