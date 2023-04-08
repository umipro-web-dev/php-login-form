<template>
    <div class="w-100">
        <h2 class="text-center mb-5 pt-3">ログインフォーム</h2>
        <div class="description text-center">
            <p>下記の二つの項目を入力し、送信してください。</p>
        </div>

        <div class="form w-50 d-block mx-auto">
            <label class="form-label mt-4" for="user">ユーザー名</label>
            <input type="text" class="form-control" id="user" v-model="username"/>
            <span class="form-text">20文字以内の記号を含まない文字で入力してください。</span>
            <br>
            <label for="pass" class="form-label mt-4">パスワード</label>
            <input type="password" class="form-control" id="pass" v-model="pass"/>
            <span class="form-text">5〜20文字の英数字で入力してください。</span>
            <br>
            <br>
            <button class="btn btn-primary" @click="submit" data-bs-toggle="modal" data-bs-target="#loading">ログイン</button>
        </div>

        <!-- modal -->
        <div class="modal fade h-100" aria-labelledby="title" id="loading" data-bs-backdrop="static" data-bs-keyboard="true">
            <div class="modal-dialog h-100 mt-5 pt-5"  role="document">
                <div class="modal-content h-50" style="margin: auto 0;">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="title">{{ submit_status_text }}</h5>
                    </div>
                    <div class="loader mb-0 pb-3 " v-if="submit_status_text === '登録中...'" style="margin-bottom: 5.75em!important;">Loading...</div>
                    <div class="err mx-auto my-auto h-100 pt-5" v-if="submit_status_text === 'エラー'">
                        <img src="/batsu.png" alt="エラー" width="120" class="pt-3"/>
                        <br>
                    </div>
                    <div class="fin" v-if="submit_status_text === '完了！'">
                        <label >
                        <input type="checkbox" :checked="delay_check" disabled>
                        <span><i></i></span>
                        </label>
                    </div>
                    <div class="modal-footer" style="display: block!important;" v-if="submit_status_text !== '登録中...'">
                        <h style="float: left;" class="footer-text">{{ description }}</h>
                        <button class="btn btn-primary ml-3" data-bs-dismiss="modal" v-if="submit_status_text === 'エラー'" style="float: right;">閉じる</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script lang="ts" setup>
import { ref, watch } from "vue";
import { useRouter } from "vue-router";
import { sleep } from "sleep-ts";

const username = ref("");
const pass = ref("");
const submit_status_text = ref("登録中...");
const description = ref("");
const delay_check = ref(false);

watch(submit_status_text, async (newval: string) => {
    if (newval === "完了！") {
        await sleep(500);
        delay_check.value = true;
    } else {
        delay_check.value = false;
    }
})

const router = useRouter();

const submit = async () => {

    const req_body_json = {
        username: username.value,
        pass: pass.value
    }

    const req_opt: RequestInit = {
        method: "POST",
        headers: {
            "Content-Type": "application/json charset=utf-8"
        },
        body: JSON.stringify(req_body_json)
    }

    const res = await fetch("/api/login.php", req_opt);
    if (res.status >= 400 == res.status < 500) {
        submit_status_text.value = "エラー";
        description.value = await res.text();
        return;
    }
    if (res.status >= 500) {
        submit_status_text.value = "エラー";
        description.value = "時間をおいてもう一度お試しください。";
        return;
    }

    submit_status_text.value = "完了！";
    description.value = "ログインに成功しました。自動的にホーム画面に遷移します。";

    await sleep(2000);
    document.querySelector(".modal-backdrop")!.remove();
    router.push("/");

}
</script>

<style scoped lang="scss">
.spinner-style {
    height: 7em;
    width: 7em;
    border-width: 0.5em;
}

.loader {
    color: rgb(91, 200, 243);
    font-size: 20px;
    margin: 100px auto;
    width: 1em;
    height: 1em;
    border-radius: 50%;
    position: relative;
    text-indent: -9999em;
    -webkit-animation: load4 1.3s infinite linear;
    animation: load4 1.3s infinite linear;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
}

@-webkit-keyframes load4 {

    0%,
    100% {
        box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;
    }

    12.5% {
        box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
    }

    25% {
        box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
    }

    37.5% {
        box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;
    }

    50% {
        box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;
    }

    62.5% {
        box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;
    }

    75% {
        box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;
    }

    87.5% {
        box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;
    }
}

@keyframes load4 {

    0%,
    100% {
        box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;
    }

    12.5% {
        box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
    }

    25% {
        box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
    }

    37.5% {
        box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;
    }

    50% {
        box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;
    }

    62.5% {
        box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;
    }

    75% {
        box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;
    }

    87.5% {
        box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;
    }
}

.fin {

    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;


    label {
        cursor: pointer;
        display: inline-block;
        height: 44px;
        position: relative;
        transform: scale(4);
        margin-left: 3em;
        margin-bottom: 3em;
    }

    input {
        display: none;
    }



    label span {
        display: inline-block;
        height: 44px;
        line-height: 44px;
        position: relative;
    }

    label span:before,
    label span:after {
        border-bottom: 2px solid #77c101;
        content: "";
        left: 7px;
        position: absolute;
        top: 25px;
        width: 14.5px;
        z-index: 1;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    label span:after {
        left: 15px;
        top: 21px;
        width: 24px;
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        -o-transform: rotate(-45deg);
        transform: rotate(-45deg);
    }

    label i {
        background: #fff;
        display: inline-block;
        height: 44px;
        margin-right: 16px;
        position: relative;
        vertical-align: top;
        width: 44px;
    }

    label span i:after {
        background: #fff;
        bottom: 0;
        content: "";
        position: absolute;
        right: 0;
        top: 0;
        width: 36px;
        z-index: 2;
    }

    input:checked+span i:after {
        transition: width 0.2s ease-in 0s;
        width: 0;
    }
}

.w-17 {
    width: 17%;
}

.footer-text {
    font-size: 0.88em;
}

</style>