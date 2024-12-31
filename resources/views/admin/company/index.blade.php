@extends('admin.layouts.admin')

@section('content')
    @include('admin.components.content-header', ['title' => 'Организации'])
    @csrf
    <section class="content">
        <div class="row">
            <div class="col-12 mb-2">
                <a href="{{ route('company.create') }}" class="btn btn-success js-btn-add-company">Добавить</a>
            </div>
        </div>
        <div class="row">
            <table class="table table-striped projects">
                <thead>
                    <tr>

                        <th style="width: 15%">
                            Название
                        </th>
                        <th style="width: 15%">
                            УНП
                        </th>
                        <th style="width: 25%">
                            Пользователи
                        </th>
                        <th style="width: 30%">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies as $company)
                        <td>
                            <a href="{{ route('company.show', ['company' => $company->id]) }}">
                                {{ $company->short_title }}
                            </a>
                        </td>
                        <td>
                            <span class="cell">{{ $company->tax_id }}</span>
                        </td>
                        <td>
                            @foreach ($company->users as $companyUser)
                                <span class="badge bg-success d-inline-block mr-2">{{ $companyUser->fullName }} </span>
                            @endforeach
                        </td>
                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm"
                                href="{{ route('company.show', ['company' => $company->id]) }}">
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
