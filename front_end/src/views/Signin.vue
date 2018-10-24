<template id="main">
    <v-ons-page>
        <v-ons-toolbar>
            <div class="center">登录</div>
        </v-ons-toolbar>

        <ons-page>
            <div style="text-align: center; margin-top: 100px;">
                <p>
                    <v-ons-input modifier="underbar" v-model="mobile" model-event="change"  placeholder="请输入手机号" float></v-ons-input>
                </p>
                <p style="margin-top: 30px;">
                    <ons-button style="width: 35%" @click="login()">登录</ons-button>
                </p>
            </div>
        </ons-page>
    </v-ons-page>
</template>
<script>
import axios from "axios";
export default {
  name: "signin",
  data() {
    return {
      mobile: ""
    };
  },
  mounted() {},
  methods: {
    login() {
        const mobile = this.mobile
        if (!mobile) {
            this.$ons.notification.toast('请填写手机号!', { timeout: 1000, animation: 'fall' })
        }
        axios.get(`user/login/${mobile}`).then(res => {
            const { uid ,msg, result} = res.data
            if (result != 1) {
                this.$ons.notification.toast(`${msg}`, { timeout: 1000, animation: 'fall' })
                return false
            }
            window.localStorage.setItem('uid', uid)
            this.$ons.notification.toast(`${msg}`, { timeout: 1000, animation: 'fall' })
            this.$router.push({name: 'home'})
        }).catch(err => {
            console.log(err)
            this.$ons.notification.toast(`请求失败`, { timeout: 1000, animation: 'fall' })
        })
    }
  }
};
</script>