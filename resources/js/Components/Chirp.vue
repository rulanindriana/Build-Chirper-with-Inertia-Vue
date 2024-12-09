<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

dayjs.extend(relativeTime);

const props = defineProps(['chirp']);

const form = useForm({
    message: props.chirp.message,
    image: null,
});

const editing = ref(false);
</script>

<template>
    <div class="p-6 flex space-x-2">
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-gray-800">{{ chirp.user.name }}</span>
                    <small class="ml-2 text-sm text-gray-600">{{ dayjs(chirp.created_at).fromNow() }}</small>
                </div>
            </div>
            <p class="mt-4 text-lg text-gray-900">{{ chirp.message }}</p>
            <img
                v-if="chirp.image"
                :src="`/storage/${chirp.image}`"
                alt="Chirp Image"
                class="mt-4 rounded-lg shadow-md"
            />
        </div>
    </div>
</template>
