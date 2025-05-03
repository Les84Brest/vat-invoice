<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Учебный портал ЭСЧФ</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])

</head>

<body class="font-sans antialiased bg-light-gray">
    <main class="bg-welcome-bg w-full h-screen bg-no-repeat bg-cover flex justify-center items-center">
        <header class="welcome__header fixed gap-3 flex-wrap top-0 left-0 flex justify-between py-4 px-4 w-full h-16 ">
            <div class="flex gap-6 items-center">
                <div class="welcome__logo logo-welcome flex gap-3 items-center">
                    <div class="logo-welcome__image w-8">
                        <img class="w-full object-cover" src="{{ asset('/assets/images/vat-invoice-logo-light.svg') }}"
                            alt="ЭСЧФ лого">
                    </div>
                    <div class="logo-welcome__text text-light-gray font-bold">ЭСЧФ</div>
                </div>
                <div class="welcome__stat  text-light-gray">
                    <ul class="stat-welcome flex gap-3">
                        <li class="stat-welcome__item">
                            <span class="stat-welcome__title mr-2 uppercase">
                                Пользователи:
                            </span>
                            <span class="font-bold">
                                {{ $usersCount }}
                            </span>
                        </li>
                        <li class="stat-welcome__item">
                            <span class="stat-welcome__title mr-2 uppercase">
                                ЭСЧФ:
                            </span>
                            <span class="font-bold">
                                {{ $invoicesCount }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="welcome__nav">
                <nav>
                    <ul class="flex gap-3">
                        <li class="nav-welcome__item">
                            <a class="inline-flex justify-center items-center cursor-pointer text-white text-center text-sm font-normal select-none bg-primary-color rounded py-2 px-3.5 hover:text-prymary-color hover:bg-button-hover-bg transition"
                                href="{{ url('/login') }}">Вход</a>
                        </li>
                        <li class="nav-welcome__item"><a
                                class="inline-flex justify-center items-center cursor-pointer text-primary-color text-center font-normal select-none align-middle bg-transparent py-2  px-3.5  text-sm rounded border border-primary-color transition hover:text-white hover:bg-button-hover-bg hover:border-button-hover-bg"
                                href="{{ url('/register') }}">
                                Регистрация</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="flex flex-col gap-8  text-white text-center ">
            <h1 class="text-2xl md:text-4xl lg:text-5xl uppercase font-bold ">
                Учебный портал <br>
                Электронные счета-фактуры <br>
                по НДС</h1>
            <div class="md:text-2xl">Обучение
                работе <br> с электронными счетами фактурами</div>
            <div class="welcome__action">
                <a href="{{ url('/vat') }}"
                    class="inline-flex justify-center items-center cursor-pointer text-white text-center text-2xl font-normal select-none bg-primary-color rounded py-3 px-5 hover:text-prymary-color hover:bg-button-hover-bg transition">
                    Начать работу
                </a>
            </div>

        </div>
    </main>

</body>

</html>
