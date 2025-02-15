<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SearchBox from '@/Components/SearchBox.vue';
import { Head } from '@inertiajs/vue3';
import FavGames from '@/Components/FavGames.vue';

defineProps({
    search_games: {
        type: Array,
    },
    fav_games: {
        type: Array,
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <SearchBox :search_games="search_games"></SearchBox>
            <FavGames :fav_games="fav_games"></FavGames>
        </div>
    </AuthenticatedLayout>
</template>
