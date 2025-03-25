<script setup>
import { Head, Link } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="container mx-auto flex min-h-screen items-center">
        <div class="mx-auto text-center">
            <h1 class="text-5xl">WORDY</h1>
            <p class="mt-5">How many words can you find?</p>
            <div class="mt-5">
                <Link href="/game" class="mx-auto rounded bg-green-500 p-3 hover:bg-green-400" @click="startGame">Start Game</Link>
            </div>
        </div>
    </div>
</template>
