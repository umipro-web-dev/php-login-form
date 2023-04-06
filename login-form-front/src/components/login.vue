<template>
    <div class="w-100">
        <h2 class="text-center mb-5 pt-3">ログインフォーム</h2>
        <div class="description text-center">
            <p>下記の三つの項目を入力し、送信してください。</p>
        </div>

        <div class="form w-50 d-block mx-auto">
            <label class="form-label mt-4" for="user">ユーザー名</label>
            <input type="text" class="form-control" id="user" v-model="username"/>
            <span class="form-text">20文字以内の記号を含まない文字で入力してください。</span>
            <label for="pass" class="form-label mt-4">パスワード</label>
            <input type="password" class="form-control" id="pass" />
            <span class="form-text">5〜20文字の英数字で入力してください。</span>
            <br>
            <br>
            <button class="btn btn-primary">ログイン</button>
        </div>

    </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";

const username = ref("");
const pass = ref("");


</script>

<style scoped lang="scss"></style>