<template>
<v-ons-page>
  <v-ons-toolbar>
    <div class="center">eattogether</div>
  </v-ons-toolbar>
  <v-ons-content>
    <v-ons-card>
      <h1 style="text-align:center">RICH</h1>
      <p style="text-align:center">
        <v-ons-button style="width: 80%"  @click="go('treat')">
          我要请客
        </v-ons-button>
      </p>
    </v-ons-card>
    <v-ons-card>
      <h1 style="text-align:center">AA</h1>
      <p style="text-align:center">
        <v-ons-button style="width: 80%" @click="go('dutch')">
          AA聚餐
        </v-ons-button>
      </p>
    </v-ons-card>
  </v-ons-content>
</v-ons-page>
</template>

<style>

</style>

<script>
export default {
  name: 'home',
  mounted() {
    this.getData()
  },
  methods: {
    go(routerName) {
      this.$router.push({name: routerName})
    },
    getData() {

    }
  }
}
</script>
