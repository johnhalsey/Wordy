<template>
    <div>
        <div class="container mx-auto mt-10 flex flex-wrap items-center justify-around">
            <div
                v-for="(letter, index) in letters"
                :key="'letter-' + index"
                class="flex min-h-16 min-w-16 items-center justify-center border border-black"
                :class="letterIsRemaining(index) ? 'bg-yellow-500' : 'bg-gray-500'"
            >
                <div class="text-xl">{{ letter.toUpperCase() }}</div>
            </div>

            <div class="mt-10 flex w-full">
                <input type="text" class="w-full rounded border p-3" autofocus v-model="submission" />
                <button class="ml-5 rounded bg-green-500 p-3 hover:bg-green-400" @click="submitWord" :disabled="loading">Submit</button>
            </div>

            <div v-if="errorBagHas('word')" class="mt-2 text-red-500">
                {{ errorBagValue('word') }}
            </div>
        </div>
        <div v-for="(sub, index) in submissions"
             :key="'submission-' + index"
             class="container mx-auto mt-10 text-xl text-green-500">
            {{ sub.word }} - {{ sub.score }} points.
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    letters: String,
    gameId: String,
});

const submission = ref(null);
const loading = ref(false);
const errorBag = ref([]);
const remainingLetters = ref(props.letters);
const submissions = ref(null);

function errorBagHas(key) {
    const error = errorBag.value.find((error) => error.key == key);
    return error != undefined && error != null;
}

function errorBagValue(key) {
    return errorBag.value.find((error) => error.key == key).value;
}

function letterIsRemaining(index) {
    return index in remainingLetters.value;
}

function submitWord() {
    loading.value = true;
    errorBag.value = [];

    axios
        .post(route('api.game.submission.store', { game: props.gameId }), {
            word: submission.value,
        })
        .then((response) => {
            remainingLetters.value = response.data.remainingLetters;
            submission.value = null;
            submissions.value = response.data.submissions;
            loading.value = false;
        })
        .catch((error) => {
            if (error.response.status == 422) {
                for (const key in error.response.data.errors) {
                    errorBag.value.push({
                        key: key,
                        value: error.response.data.errors[key][0],
                    });
                }
            }

            loading.value = false;
        });
}
</script>

<style lang="scss" scoped></style>
