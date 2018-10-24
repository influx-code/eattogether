<template>
<v-ons-page>
  <v-ons-toolbar>
    <div class="left">
      <v-ons-toolbar-button @click="goback()">back</v-ons-toolbar-button>
    </div>
    <div class="center">eattogether</div>
  </v-ons-toolbar>
  <v-ons-content>
    <h1 style="text-align:center">我来请客</h1>
    <v-ons-card>
      <div class="center">
        <div v-for="(select, index) in selected" :key="'select'+index">
          <v-ons-select style="width: 85%" v-model="selected[index]['value']">
              <option v-for="(item, o_index) in users" :value="item.value" :key="'select'+index+ o_index">
              {{ item.text }}
              </option>
          </v-ons-select>
          <button class="del-btn" @click="delUser(index)">—</button>
        </div>
      </div>
      <div class="add-user" @click="addUser">
          加一位
      </div>
      <button class="submit-btn" @click="submit">确定</button>
    </v-ons-card>
  </v-ons-content>
</v-ons-page>
</template>
<style scoped>
.add-user {
  height: 50px;
  margin: 10px 0;
  border: 2px dashed skyblue;
  text-align: center;
  line-height: 50px;
  font-size: 14px;
  border-radius: 5px;
}
.submit-btn {
  height: 40px;
  text-align: center;
  width: 100%;
  background-color: #3a7cf6;
  color: white;
  border: none;
  border-radius: 20px;
  outline: none;
  font-size: 14px;
}
.del-btn{
  height: 24px;
  width: 24px;
  margin: 4px 10px;
  border: none;
  background-color: blueviolet;
  color: white;
  border-radius: 12px;
  font-size: 14px;
  outline: none;
  text-align: center;
}
</style>

<script>
export default {
  name: "treat",
  data() {
    return {
      users: [],
      selected: []
    };
  },
  mounted() {
    this.getUserList();
  },
  methods: {
    getUserList() {
      this.users = [{ text: "Mankong", value: "Mankong" }, { text: "Uique", value: "Uique" }];
    },
    addUser() {
      this.selected.push(
        {text: "Mankong", value: "Mankong"}
      )
    },
    delUser(index) {
      this.selected.splice(index, 1)
    },
    submit() {
      const postData = {users: this.selected} 
      alert(JSON.stringify(postData))
    },
    goback() {
      this.$router.push({name: 'home'})
    }
  }
};
</script>
