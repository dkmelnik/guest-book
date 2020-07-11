<template>
    <section class="login-container">
        <section class="container">
            <div v-for="post in posts">
                <div>
                    {{post.user_id ? post.user.name : 'Анонимус'}}
                </div>
                {{post.message}}
            </div>
        </section>
        <div class="container make_comment">
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

            <b-field label="Комментарий" :type="post.message.state" :message="post.message.text">
                <b-input maxlength="200" type="textarea" v-model="post.message.value"
                         :class="post.message.class"></b-input>
            </b-field>
            <div class="button_send">
                <b-button type="is-link" @click="sendAction">Отправить</b-button>
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
                post: {
                    message: {
                        value: '',
                        text: 'Ваш комментарий',
                        state: '',
                        class: '',
                    },
                },
                posts: [],
                load: false,
                register: false,
            }
        },
        methods: {
            sendAction: function () {
                this.load = true;
                axios.put('posts', {
                    message: this.post.message.value
                }).then(response => {
                    this.responseSuccessAction(response);
                }).catch(response => {
                    this.responseErrorAction(response);
                })
            },
            responseErrorAction: function (response) {
                this.load = false;
                let error_fields = response.response.data.errors;
                for (let key in this.post) {
                    this.post[key].text = '';
                    this.post[key].state = 'is-success';
                    this.post[key].class = '';
                }
                for (let key1 in error_fields) {
                    this.post[key1].text = error_fields[key1][0];
                    this.post[key1].state = 'is-danger';
                    this.post[key1].class = 'animated shake';
                }
                this.$buefy.notification.open({
                    message: 'Проверьте правильность формы',
                    type: 'is-danger',
                    hasIcon: true
                });
            },
            responseSuccessAction: function (response) {
                this.load = false;
                for (let key in this.post) {
                    this.post[key].text = '';
                    this.post[key].state = 'is-success';
                    this.post[key].class = '';
                }
                this.post.message.value = '';
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
                this.updatePosts();
                this.reset();
            },
            updatePosts: function () {
                axios.get('posts', {}
                ).then(response => {
                        this.posts = response.data;
                    }
                )
            }

        },
        mounted() {
            this.updatePosts();
            setInterval( () => {
                this.updatePosts()
            }, 1000)
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
    .make_comment{

    }
</style>
