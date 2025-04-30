
<script setup lang="ts">

</script>

<template>
    <div class=" auth__container">
        <div class="auth__content">
            <div class="auth__image">
                <div class="auth__logo">
                    <img src="@assets/images/vat-invoice-logo-light.svg" alt="ЭСЧФ лого">
                </div>
                <h2 class="auth__slogan">Электронные счета-фактуры <br>
                    по НДС</h2>
            </div>

            <div class="auth__body">
                <div class="auth__form">
                    <slot></slot>
                </div>
                <div class="auth__navigation">
                    <a href="/" class="auth__link">
                        Главная
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
