<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm,usePage  } from '@inertiajs/vue3';
import Logo from '../../../images/user.png';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    login: '',
    password: '',
    remember: false,
});

const submit = () => {

    form.post(route('login'), {
        preserveScroll: true,
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-base text-green-600">
            {{ status }}
        </div>

        <div class="flex flex-1 flex-col justify-center px-0 py-5">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <img class="mx-auto h-20 w-auto" :src="Logo"
                    alt="Inventario" />
                <h2 class="mt-2 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 dark:text-white">INVENTARIO</h2>
            </div>

            <div v-if="usePage().props.flash.error" class="bg-red-600 text-white text-sm p-2">
                {{usePage().props.flash.error}}
            </div>
            <div class="mt-0 sm:mx-auto sm:w-full sm:max-w-sm">
                <form @submit.prevent="submit" class="space-y-3">
                    <div>

                        <InputLabel for="login" value="Usuario" class="block text-base font-bold leading-6 text-gray-900" />
                        <div class="mt-1">
                            <TextInput id="login" type="text" v-model="form.login" required
                                autocomplete="login" />
                            <InputError class="mt-2 text-xs"  :message="form.errors.login" />

                        </div>

                    </div>

                    <div>
                        <InputLabel for="password" value="Contraseña"  class="block text-base font-bold leading-6 text-gray-900" />
                        <div class="mt-1">
                            <TextInput id="password" type="password"
                            current-password
                                v-model="form.password" required  />
                            <InputError class="mt-2 text-xs"  :message="form.errors.password" />
                        </div>
                    </div>

                    <PrimaryButton
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-base font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        :class="{ 'opacity-50': form.processing }" :disabled="form.processing">
                        INGRESAR
                    </PrimaryButton>
                </form>
            </div>
        </div>

    </GuestLayout>
</template>
