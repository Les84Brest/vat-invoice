@extends('admin.layouts.admin')



@section('content')
    <section class="content">
        <form action="#" class="js-create-company-form">
            @method('POST')
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Название</label>
                <input type="text" name="title" class="form-control" id="exampleInputEmail1" placeholder="Введите название">
            </div>
            <div class="form-group">
                <label for="shortnameid">Сокращенное название</label>
                <input type="text" name="short_title" class="form-control" id="shortnameid"
                    placeholder="Введите сокращенное название">
            </div>
            <div class="form-group">
                <label for="taxidid">УНП</label>
                <input type="number" name="tax_id" class="form-control" id="taxidid" placeholder="Введите УНП"">
            </div>
            <div class="form-group">
                <label for="addressid">Адрес</label>
                <input type="text" name="address" class="form-control" id="addressid" placeholder="Введите адрес">
            </div>
            <div class="form-group">
                <label>Пользователи</label>
                <select class="select2" multiple="multiple" name="users[]" data-placeholder="Пользователи"
                    style="width: 100%;">
                    <option value="21">Hello world</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"> {{ $user->last_name }} {{ $user->name }} </option>
                    @endforeach
                </select>
            </div>
            <!-- /.card-body -->
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </section>
@endsection

@section('page-scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            //submit table

            $('.js-create-company-form').on('submit', async function(event) {
                event.preventDefault(); // Prevent the default form submission

                const formData = new FormData($(this)[0]);
                const csrfTokenInput = $('input[name="_token"]');
                const csrfToken = csrfTokenInput.val();

                try {
                    const response = await fetch('/admin/company', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        }
                    })

                    if (response.ok) {
                        toastr["success"]("Организация создана");
                        setTimeout(() => {
                            window.location.href = "{{ route('company.index') }}"

                        }, 2000);
                    }
                } catch (error) {
                    console.log('%cerror', 'padding: 5px; background: hotpink; color: black;', error);
                    toastr["danger"]("Произошла ошибка");
                }

            });
        });
    </script>
@endsection
