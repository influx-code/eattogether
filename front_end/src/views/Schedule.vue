<template>
    <v-ons-page>
        <v-ons-toolbar>
            <div class="left toolbar__left">
                <v-ons-toolbar-button icon="ion-navicon, material: md-menu"></v-ons-toolbar-button>
            </div>
            <div class="center">约饭进度</div>
            <div class="right toolbar__left">
            </div>
        </v-ons-toolbar>
        <ons-list-item class="list-item">
            <div class="center list-item__center">
                是否接受约饭
            </div>
            <div class="right list-item__right">
                <v-ons-button modifier="cta" style="margin: 3px 0" @click="receiver()">接受</v-ons-button>&nbsp;&nbsp;&nbsp;
                <v-ons-button modifier="cta" style="margin: 3px 0" @click="confuse()">拒绝</v-ons-button>
            </div>
        </ons-list-item>
        <ons-list-item>
            <div class="left">
                <img class="list-item__thumbnail" src="https://placekitten.com/g/40/40">
            </div>
            <div class="center">
                <span class="list-item__title">Mankong</span>
                <span class="list-item__subtitle">已就位</span>
            </div>
        </ons-list-item>
        <ons-list-item>
            <div class="left">
                <img class="list-item__thumbnail" src="https://placekitten.com/g/40/40">
            </div>
            <div class="center">
                <span class="list-item__title">Unique</span>
                <span class="list-item__subtitle">已就位</span>
            </div>

        </ons-list-item>
    </v-ons-page>
</template>
<script>
    export default {
        name: 'signin',
            data:{
                items:[]
            },
            methods: {
                receiver: function () {
                   alert(1)
                },
                confuse: function () {
                    alert(2)
                }
            }

    }
</script>
