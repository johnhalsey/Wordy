<template>
    <div class="container mx-auto flex mt-10 justify-around items-center flex-wrap">

        <div v-for="(letter, index) in letters"
             :key="'letter-' + index"
             class="min-w-16 min-h-16 bg-yellow-500 border border-black flex items-center justify-center"
        >
            <div class="text-xl">{{ letter.toUpperCase() }}</div>
        </div>

        <div class="w-full mt-10 flex">
            <input type="text" class="w-full p-3 border rounded" autofocus v-model="submission">
            <button class="rounded bg-green-500 p-3 hover:bg-green-400 ml-5"
                    @click="submitWord"

            >Submit</button>
        </div>

    </div>
</template>

<script setup lang="js">
import { ref } from 'vue';
import axios from "axios"

const props = defineProps({
    letters: String,
    gameId: String,
});

const submission = ref(null)

function submitWord () {

}
</script>

<style lang="scss" scoped></style>
