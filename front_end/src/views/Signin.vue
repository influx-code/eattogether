<template id="main">
    <v-ons-page>
        <v-ons-toolbar>
            <div class="center">登录</div>
        </v-ons-toolbar>

        <ons-page>
            <div style="text-align: center; margin-top: 100px;">
                <p>
                    <ons-input id="mobile" modifier="underbar" placeholder="请输入手机号" float></ons-input>
                </p>
                <p style="margin-top: 30px;">
                    <ons-button style="width: 35%" @click="login()">登录</ons-button>
                </p>
            </div>
        </ons-page>
    </v-ons-page>
</template>
<script>
    export default {
        name: 'signin',
        mounted() {
            this.getData()
        },
        methods: {
            login() {
                var mobile = document.getElementById('mobile').value;
                alert(mobile);
            },
            getData() {

            }
        }
    }
</script>