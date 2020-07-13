<template>
    <section class="posts-container">
        <section class="container posts" ref="refPosts">
            <h1 class="title">Комментарии ({{posts.length}})</h1>
            <div v-for="post in posts" class="post">
                <div class="date">
                    {{post.created_at}}
                </div>
                <div class="name">
                    {{post.user_id ? post.user.name : 'Анонимус'}}
                </div>
                <div class="message">
                    {{post.message}}
                </div>
                <div v-if="auth.id === post.user_id" class="delete_post" @click="deletePost(post.id)">

                    Удалить

                </div>
            </div>
        </section>
        <div class="fixed">
            <div class="container make_comment">
                <div v-if="errors" style="margin: 10px 0">
                    <b-message v-for="(error, index) in errors"
                               title="Ошибка!"
                               type="is-danger"
                               :key="index"
                               aria-close-label="Закрыть сообщение">
                        {{error}}
                    </b-message>
                </div>
                <b-field label="Оставьте Ваш комментарий" :type="post.message.state" :message="post.message.text">
                    <b-input maxlength="200" type="textarea" v-model="post.message.value"
                             :class="post.message.class"></b-input>
                </b-field>
                <div class="buttons">
                    <b-button type="is-link" @click="sendAction">Отправить</b-button>
                    <div v-if="!auth">
                        <a href="/auth">Вход</a>
                        <a href="/register">Регистрация</a>
                    </div>
                    <div v-if="auth">
                        <a @click="logout">Выйти</a>
                    </div>
                </div>
                <b-loading :active.sync="load"></b-loading>
            </div>
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
                auth: false,
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
            },
            checkAuth: function () {
                axios.post('auth', {}
                ).then(response => {
                        this.auth = response.data;
                        console.log(this.auth);
                    }
                )
            },
            logout: function () {
                axios.get('auth/logout', {}
                ).then(response => {
                        console.log(response.data);
                        location.reload();
                    }
                )
            },
            deletePost: function ($id) {
                console.log($id);
                axios.put('posts/delete', {
                        id: $id
                    }
                ).then(response => {
                    console.log(response);
                })
            }
        },
        mounted() {
            this.$refs.refPosts.scrollTop = this.$refs.refPosts.scrollHeight;
            this.updatePosts();
            this.checkAuth();
            setInterval(() => {
                this.updatePosts()
            }, 1000)
        }
    }
</script>

<style lang="scss" scoped>
    .posts-container {
        height: 100vh;
        padding: 3rem 1.5rem;

        .container {
            max-width: 800px;
            padding-left: 50px;
            padding-right: 50px;
        }
    }

    .make_comment {

    }

    .post {
        padding: 26px 51px 36px;
        box-sizing: border-box;
        border: 1px solid #ececec;
        margin-bottom: 32px;
        position: relative;
    }

    .name {
        font-size: 1.3333em;
        line-height: 1.4em;
        color: #333;
        font-weight: 500;
    }

    .date {
        font-size: .667em;
        line-height: 1.3em;
        text-transform: uppercase;
        letter-spacing: .8px;
        color: #999;
        margin-bottom: 10px;
    }

    .message {
        line-height: 1.8em;
        opacity: .75;
        margin-bottom: 25px;
        margin-block-start: 1em;
        margin-block-end: 1em;
        background: white;
    }

    .fixed {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background: white;
    }

    .container.posts {
        padding-bottom: 280px;
    }

    .make_comment {
        padding-top: 30px;
        padding-bottom: 30px;
        -webkit-box-shadow: -1px -23px 28px 2px rgba(255, 255, 255, 1);
        -moz-box-shadow: -1px -23px 28px 2px rgba(255, 255, 255, 1);
        box-shadow: -1px -23px 28px 2px rgba(255, 255, 255, 1);
    }

    .buttons {
        display: flex;
        align-items: center;

        a {
            padding: 5px;
        }
    }

    .buttons .button {
        margin-bottom: 0;
    }

    .delete_post {
        position: absolute;
        padding: 20px;
        right: 0;
        top: 0;
        cursor: pointer;
    }
</style>

