<script setup>
import { ref } from 'vue';
import {Link, usePage, router, Head} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const { props } = usePage();
const accounts = ref(props.accounts);

const disconnectAccount = (accountId) => {
    if (confirm('Are you sure you want to disconnect this account?')) {
        router.delete(`/social-accounts/${accountId}`);
    }
};
</script>


<template>

    <Head title="Social Media Accounts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Social Media Accounts</h2>
        </template>

        <div class="mt-6 max-w-3xl mx-auto border border-gray-400 p-4">
            <PrimaryButton>
                <Link href="/social-accounts/create" class="btn btn-primary">Connect New Account</Link>
            </PrimaryButton>
            <div class="mt-4">
                <table class="table-auto w-full">
                    <thead>
                    <tr>
                        <th>Platform</th>
                        <th>Account ID</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="account in accounts" :key="account.id">
                        <td>{{ account.platform }}</td>
                        <td>{{ account.account_id }}</td>
                        <td>
                            <button @click="disconnectAccount(account.id)" class="btn btn-danger">Disconnect</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
