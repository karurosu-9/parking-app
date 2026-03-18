<script setup>
    import { onMounted, reactive } from 'vue';
    import axios from 'axios';
    import PlaceListItem from './PlaceListItem.vue';


    const data = reactive({
        places: []
    });

    const fetchPlaces = async () => {
        try {
            const response = await axios.get('http://localhost/api/places');
            data.places = response.data.data;
        } catch (error) {
            console.log(error);
        }
    }

    onMounted(() => fetchPlaces());
</script>

<template>
    <div class="row my-4">
        <PlaceListItem
            v-for="place in data.places"
            :key="place.id"
            :place="place"
        />
    </div>
</template>

<style scoped>
</style>
