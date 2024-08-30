<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const form = ref({
    platform: '',
    account_id: '',
    access_token: '',
});

const submitForm = () => {
    router.post('/social-accounts', form.value);
};
</script>

<template>
    <div>
        <h1 class="text-2xl font-bold">Connect a New Social Media Account</h1>
        <form @submit.prevent="submitForm">
            <div class="mt-4">
                <label for="platform">Platform</label>
                <select v-model="form.platform" id="platform" class="form-control">
                    <option value="facebook">Facebook</option>
                    <option value="instagram">Instagram</option>
                </select>
            </div>
            <div class="mt-4">
                <label for="account_id">Account ID</label>
                <input type="text" v-model="form.account_id" id="account_id" class="form-control">
            </div>
            <div class="mt-4">
                <label for="access_token">Access Token</label>
                <input type="text" v-model="form.access_token" id="access_token" class="form-control">
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Connect Account</button>
            </div>
        </form>
    </div>
</template>

