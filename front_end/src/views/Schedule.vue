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
        <v-ons-content>
        <v-ons-card v-if="accept">
            <div class="center list-item__center">
                是否接受约饭
            </div>
            <div class="right list-item__right">
                <v-ons-button modifier="cta" style="margin: 3px 0" @click="receiver()">接受</v-ons-button>&nbsp;&nbsp;&nbsp;
                <v-ons-button modifier="cta" style="margin: 3px 0" @click="confuse()">拒绝</v-ons-button>
            </div>
        </v-ons-card>

        <v-ons-card  v-for="(item, index) of dining_table" :key="index">
            <h1 style="text-align:center" v-text="item.name"></h1>
            <p style="text-align:center" v-text="item.status_invite">
            
            </p>
        </v-ons-card>
        </v-ons-content>
       
    </v-ons-page>
</template>
<script>
import axios from "axios";
export default {
  name: "schedule",
  data() {
    return {
      dining_table_id: "",
      uid: window.localStorage.getItem("uid"),
      dining_table: [],
      accept: true
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    receiver: function() {
      const uid = this.uid;
      const dining_table_id = this.dining_table_id;
      const status = 0;
      axios
        .get(`/dining/deal/${uid}/${dining_table_id}/${status}`)
        .then(res => {
          console.log(res.data);
        })
        .catch(err => {});
    },
    confuse: function() {
      const uid = this.uid;
      const dining_table_id = this.dining_table_id;
      const status = 0;
      axios
        .get(`/dining/deal/${uid}/${dining_table_id}/${status}`)
        .then(res => {
          console.log(res.data);
        })
        .catch(err => {});
    },
    getData() {
      const uid = window.localStorage.getItem("uid");
      if (!uid) {
        this.$router.push({name: 'signin'})
        return false
      }
      axios
        .get(`/dining/info/${uid}`)
        .then(res => {
          console.log(res.data);
          if (res.data) {
            if (res.data.result == -1) {
              this.$ons.notification.alert("错误请求");
              return false;
            }
            const { dining_table_id, dining_table } = res.data;
            this.dining_table_id = dining_table_id;
            this.dining_table = dining_table;
            
            for (const item of dining_table) {
                if (item.uid = this.uid) {
                    if (item.status) {
                        this.accept = false
                    }
                }
            }
          }
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>
