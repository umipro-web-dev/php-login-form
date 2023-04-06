<script setup lang="ts">
import { ref } from "vue";

async function getUser(): Promise<string> {
  const req_opt: RequestInit = {
    method: "POST",
    headers: {
      "Content-Type": "application/json; charset=utf-8"
    }
  }
  const res = await fetch("./api/getUser", req_opt);
  if (!res.ok) {
    return "ログインしていません";
  }
  const user_json = await res.json();
  
  return user_json.username;

}

getUser().then();
</script>

<template>

    <h class="center">current user is </h>
    

</template>

<style scoped lang="scss">
.center {
  text-align: center;
  margin: auto 0;
}



</style>
