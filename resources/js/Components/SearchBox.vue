<script>
import { ref, onMounted } from 'vue'
import debounce from 'lodash/debounce'
import axios from 'axios'

export default {
    setup() {
        const searchQuery = ref('')
        const results = ref([])
        const isLoading = ref(false)

        const performSearch = debounce(async () => {
            if (searchQuery.value.length < 2) {
                results.value = []
                return
            }

            try {
                isLoading.value = true
                const response = await axios.get('/game/search', {
                    params: {
                        query: searchQuery.value
                    }
                })

                results.value = response.data || []
            } catch (error) {
                console.error('Search failed:', error)
                results.value = []
            } finally {
                isLoading.value = false
            }
        }, 300)

        return {
            searchQuery,
            results,
            isLoading,
            performSearch
        }
    }
}
</script>
<template>
    <form class="max-w-3xl mx-auto">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="search" id="default-search" v-model="searchQuery" @input="performSearch" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Games..." required />
        </div>
    </form>
    <!-- Loading indicator -->
    <div v-if="isLoading" class="text-center py-4">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto"></div>
    </div>

    <!-- Results -->
    <div v-else-if="results.length > 0" class="w-11/12 sm:w-11/12 md:w-8/12 lg:w-6/12 backdrop-blur-sm bg-white/40 p-6 rounded-lg shadow-sm border-violet-200 border max-w-3xl mx-auto mt-5 max-h-96 overflow-y-scroll">
        <div v-for="result in results" :key="result.id" class="grid mb-5">
            <div class="relative flex flex-col md:flex-row w-full my-6 bg-white shadow-sm border border-slate-200 rounded-lg">
                <div class="relative p-2.5 md:w-2/5 shrink-0 overflow-hidden">
                    <img
                    :src="result.cover?.image_id ? `https://images.igdb.com/igdb/image/upload/t_cover_big/${result.cover.image_id}.jpg` : 'https://i0.wp.com/game.courses/wp-content/uploads/2020/08/placeholder.png?quality=80&ssl=1'"
                    alt="card-image"
                    class="h-full w-full rounded-md md:rounded-lg object-cover"
                    />
                </div>
                <div class="p-6">
                    <div v-if="result.genres && result.genres.length > 0" class="mb-4 rounded-full bg-teal-600 py-0.5 px-2.5 border border-transparent text-xs text-white transition-all shadow-sm w-20 text-center">{{ result.genres[0].name }}</div>
                    <div class="flex justify-between items-center w-full group">
                        <h4 class="mb-2 text-slate-800 text-xl font-semibold">{{ result.name }}</h4>
                        <div class="cursor-pointer transition">
                                <!-- Default Plus Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 group-hover:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <!-- Hovered Tick Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 hidden group-hover:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                        </div>
                    </div>
                    <p v-if="result.storyline" class="mb-8 text-slate-600 leading-normal font-light">
                        {{ result.storyline.split(' ').slice(0, 40).join(' ') + (result.storyline.split(' ').length > 40 ? '...' : '') }}
                    </p>
                    <div>
                        <a href="#" class="text-slate-800 font-semibold text-sm hover:underline flex items-center">
                            Learn More
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- No results -->
    <div v-else-if="searchQuery && !isLoading" class="text-center py-4 text-gray-500">
        No results found
    </div>
</template>
