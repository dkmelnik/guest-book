<template>
    <section class="section login-container">
        <transition name="custom-classes-transition"
                    enter-active-class="animated zoomIn"
                    leave-active-class="animated zoomOut" mode="out-in" class="transition">
            <div class="container" key="login">
                <h1 class="title">Войти в личный кабинет</h1>
                <h2 class="subtitle">
                    Все поля обязательны для заполнения
                </h2>
                <div v-if="errors" style="margin: 10px 0">
                    <b-message v-for="(error, index) in errors"
                               title="Ошибка!"
                               type="is-danger"
                               :key="index"
                               aria-close-label="Закрыть сообщение">
                        {{error}}
                    </b-message>
                </div>
                <b-field label="Email" :type="user.email.state" :message="user.email.text">
                    <b-input type="email" v-model="user.email.value" :class="user.email.class"
                             maxlength="255"></b-input>
                </b-field>
                <b-field label="Пароль" :type="user.password.state" :message="user.password.text">
                    <b-input type="password"
                             v-model="user.password.value"
                             :class="user.password.class"
                             password-reveal>
                    </b-input>
                </b-field>
                <div class="buttons">
                    <b-button type="is-primary" @click="authAction">Войти</b-button>
                </div>
                <b-loading :active.sync="load"></b-loading>
            </div>
        </transition>
    </section>
</template>

<script>
    export default {
        props: {
            errors: Array,
            url: String
        },
        data() {
            return {
                user: {
                    email: {
                        value: '',
                        text: 'ivan@mail.ru',
                        state: '',
                        class: '',
                    },
                    password: {
                        value: '',
                        text: '',
                        state: '',
                        class: '',
                    }

                },
                load: false,
                register: false,
            }
        },
        methods: {
            registerSet: function () {
                this.reset();
                this.register = true;
                this.user.login.text = 'Ваш логин для входа';
            },
            reset: function () {
                this.user = {
                    password: {
                        value: '',
                        text: '',
                        state: '',
                        class: '',
                    },
                    email: {
                        value: '',
                        text: 'Например: ivan@mail.ru',
                        state: '',
                        class: '',
                    },
                    remember: {
                        value: true,
                        text: '',
                        state: '',
                        class: '',
                    },
                };
                this.register = false;
                this.load = false;
            },
            authAction: function () {
                this.load = true;
                axios.put('auth', {
                    email: this.user.email.value,
                    password: this.user.password.value
                }).then(response => {
                    this.responseSuccessAction(response);
                }).catch(response => {
                    this.responseErrorAction(response);
                })
            },
            responseErrorAction: function (response) {
                this.load = false;
                let error_fields = response.response.data.errors;
                for (let key in this.user) {
                    this.user[key].text = '';
                    this.user[key].state = 'is-success';
                    this.user[key].class = '';
                }
                for (let key1 in error_fields) {
                    this.user[key1].text = error_fields[key1][0];
                    this.user[key1].state = 'is-danger';
                    this.user[key1].class = 'animated shake';
                }
                this.$buefy.notification.open({
                    message: 'Проверьте правильность формы',
                    type: 'is-danger',
                    hasIcon: true
                });
            },
            responseSuccessAction: function (response) {
                this.load = false;
                for (let key in this.user) {
                    this.user[key].text = '';
                    this.user[key].state = 'is-success';
                    this.user[key].class = '';
                }
                if (response.data.error) {
                    this.$buefy.notification.open({
                        message: response.data.msg,
                        type: 'is-danger',
                        hasIcon: true
                    });
                    return false;
                }
                this.$buefy.notification.open({
                    message: response.data.msg,
                    type: 'is-success',
                    hasIcon: true
                });
                if (response.data.data.link) {
                    window.location.href = response.data.data.link;
                }
                this.reset();
            },
            nameHandler: function (val) {
                let arr = this.$root.maskName(val.split(' '));
                this.user.name.value = arr.join(' ');
            },
            phoneFocus: function (e) {
                let im = new Inputmask('+9 (999) 999-99-99');
                im.mask(this.$refs.phoneInput.$refs.input, {autoUnmask: true});
            },
        },
    }
</script>

<style lang="scss" scoped>
    .login-container {
        .container {
            max-width: 500px;
        }
    }
</style>
