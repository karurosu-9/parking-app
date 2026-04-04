<script setup>
import axios from 'axios';
import { useToast } from 'vue-toastification';

    const props = defineProps({
        place: {
            type: Object,
            required: true
        }
    })

    // 成功・失敗メッセージの表示
    const toast = useToast();

    const emit = defineEmits(['updated-place']);

    // 駐車場の予約
    const reservePlace = async (placeId) => {
        try {
            const response = await axios.post('http://localhost/api/book/reservation',
                {
                    place_id: placeId
                }
            );
            if (response.data.message) {
                toast.success(response.data.message, {
                    timeout: 4000
                })

                emit('updated-place', response.data.place);
            }
        } catch (error) {
            console.log(error);

            if (error.response.data.error) {
                toast.error(error.response.data.error, {
                    timeout: 4000
                });
            }
        }
    };

    // 予約のキャンセル
    const cancelReservation = async (place) => {
        const reservation = findReservationByUser(place, 'reserved');
        try {
            const response = await axios.put(`http://localhost/api/cancel/${reservation.id}/reservation`,
                {
                }
            );
            if (response.data.message) {
                toast.success(response.data.message, {
                    timeout: 4000
                })

                emit('updated-place', response.data.place);
            }
        } catch (error) {
            console.log(error);

            if (error.response.data.error) {
                toast.error(error.response.data.error, {
                    timeout: 4000
                });
            }
        }
    };

    // 駐車開始
    const startParking = async (place) => {
        const reservation = findReservationByUser(place, 'reserved');
        try {
            const response = await axios.put(`http://localhost/api/start/${reservation.id}/parking`,
                {
                }
            );
            if (response.data.message) {
                toast.success(response.data.message, {
                    timeout: 4000
                })

                emit('updated-place', response.data.place);
            }
        } catch (error) {
            console.log(error);

            if (error.response.data.error) {
                toast.error(error.response.data.error, {
                    timeout: 4000
                });
            }
        }
    };


    const findReservationByUser = (place, status) => {
        return place.reservations.find(r => r.user_id ===  1 && r.status === status)
    }

</script>

<template>
    <div class="col-md-4">
        <div class="card custom-card mb-4">
            <div class="card-body">
                <h5 class="card-title">
                    {{ place.place_number }}
                    <span :class="`badge
                        ${place.status === 'available' ? 'bg-success' : 'bg-danger'} float-end`">
                        {{ place.status }}
                    </span>
                </h5>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="card-text mb-1">
                            <strong>Sector:</strong> {{ place.sector.name }}
                            {{ place.sector.description }}
                        </p>
                        <p class="card-text mb-1">
                            <strong>Price:</strong> ${{ place.sector.price }} / hour
                        </p>
                    </div>
                    <div>
                        <i class="bi bi-p-circle h1"
                            v-if="place.status === 'available'"></i>
                        <i class="bi bi-sign-no-parking h1"
                            v-else></i>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-sm btn-dark"
                        v-if="place.status === 'available'"
                        @click = reservePlace(place.id)>Reserve</button>
                    <template v-else-if="place.status === 'reserved'">
                        <button class="btn btn-sm btn-primary" @click="startParking(place)">Park here</button>
                        <button class="btn btn-sm btn-warning"
                            @click="cancelReservation(place)">Cancel</button>
                    </template>

                    <button class="btn btn-sm btn-danger"
                        v-else-if="place.status === 'occupied'">End parking</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
