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
                            <button type="button" class="btn btn-primary">login</button>
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
    </div>
</template>

<script>
    export default {
        computed: {
            isLogged: () => { return false; }
        },
        components: {
            Logo: require("home/general/Logo"),
            Avatar: require("home/general/Avatar")
        }
    }
</script>

<style lang="scss" scoped>
    .nav-bar {
        height: 60px;
        padding: 15px 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
    }
</style>