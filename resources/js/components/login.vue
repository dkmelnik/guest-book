<template>
    <section class="login-container">
        <div class="container">
            <h1 class="title">Оставьте ваш комментарий</h1>

            <div v-if="errors" style="margin: 10px 0">
                <b-message v-for="(error, index) in errors"
                           title="Ошибка!"
                           type="is-danger"
                           :key="index"
                           aria-close-label="Закрыть сообщение">
                    {{error}}
                </b-message>
            </div>

            <b-field label="Логин" :type="user.name.state" :message="user.name.text">
                <b-input v-model="user.name.value" :class="user.name.class" maxlength="30"></b-input>
            </b-field>

            <b-field label="Email" :type="user.email.state" :message="user.email.text">
                <b-input type="email" v-model="user.email.value" :class="user.email.class"
                         maxlength="255"></b-input>
            </b-field>

            <b-field label="Message" :type="user.message.state" :message="user.message.text">
                <b-input maxlength="200" type="textarea" v-model="user.message.value"
                         :class="user.message.class"></b-input>
            </b-field>
            <div class="button_send">
                <b-button type="is-link" @click="sendAction">Войти</b-button>
            </div>
            <b-loading :active.sync="load"></b-loading>
        </div>
    </section>
</template>

<script>
    export default {
        props: {
            errors: Array,
        },
        data() {
            return {
                user: {
                    name: {
                        value: '',
                        text: 'Иванов Иван Иванович',
                        state: '',
                        class: '',
                    },
                    email: {
                        value: '',
                        text: 'ivan@mail.ru',
                        state: '',
                        class: '',
                    },
                    message: {
                        value: '',
                        text: 'Ваш комментарий',
                        state: '',
                        class: '',
                    },
                },
                load: false,
                register: false,
            }
        },
        methods: {
            sendAction: function () {
                this.load = true;
                axios.put('api/send', {
                    login: this.user.name.value,
                    password: this.user.email.value,
                    name: this.user.message.value
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
            }
        }
    }
</script>

<style lang="scss" scoped>
    .login-container {
        height: 100vh;
        padding: 3rem 1.5rem;

        .container {
            max-width: 500px;
        }
    }
</style>
