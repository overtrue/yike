<template>
    <div class="nav-bar">
        <div class="container">
            <div class="row">
                <div class="logo col-md-8">
                    <logo></logo>
                </div>
                <div class="nav-right col-md-8">
                    <slot name="page-actions"></slot>
                    <div class="user-btn float-right">
                        <div v-if="!isLogged">
                            <a href="#" data-toggle="modal" data-target="#login-modal" @click="isSignin=true">登录</a> / <a href="#" data-toggle="modal" data-target="#login-modal" @click="isSignin=false">注册</a>
                        </div>
                        <div class="dropdown open" v-else>
                            <div class="dropdown-toggle" id="nav-right-action-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <avatar size="small"></avatar>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nav-right-action-dropdown">
                                <a class="dropdown-item" href="#">个人主页</a>
                                <a class="dropdown-item" href="#">账号设置</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">注销</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="login-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div v-if="isSignin">
                            <signin></signin>
                        </div>
                        <div v-else>
                            <signup></signup>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {Signin, Signup} from "../../auth/routes/components";

    export default {
        data() {
            return {
                isSignin: true
            }
        },
        computed: {
            isLogged: () => { return false; }
        },
        components: {
            Signin,
            Signup,
            Logo: require("home/general/Logo"),
            Avatar: require("home/general/Avatar"),
        }
    }
</script>

<style lang="scss" scoped>
    .nav-bar {
        height: 60px;
        padding: 15px 0;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
    }

    #login-modal {
        .modal-dialog {
            max-width: 400px;
        }
        .modal-body {
            padding: 30px 60px;
        }
    }
</style>