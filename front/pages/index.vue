<template>
    <v-app>
        <v-container class="d-flex h-screen justify-center align-center">
            <v-form @submit.prevent="handleLogin" class=" d-flex flex-column w-50">
                <v-text-field v-model="username" type="text" label="Digite seu usuário" :error-messages="errors.username"></v-text-field>
                <v-text-field v-model="password" type="password" label="Digite sua senha" :error-messages="errors.password"></v-text-field>
                <v-btn :loading="loading" class="mt-2" text="Entrar" type="submit"></v-btn>
            </v-form>
        </v-container>
    </v-app>

</template>

<script setup lang="ts">
    import { ref } from 'vue'
    import { useField, useForm } from 'vee-validate'
    import * as yup from 'yup'

    useHead({
        title: 'Login'
    })

    interface LoginForm {
        username: string
        password: string
    }
    const validationSchema: yup.ObjectSchema<LoginForm> = yup.object({
        username: yup.string().required('O usuário é obrigatório'),
        password: yup.string().required('A senha é obrigatória').min(6, 'A senha deve ter pelo menos 6 caracteres'),
    })
    const { handleSubmit, errors } = useForm<LoginForm>({
        validationSchema,
        // homologacao
        initialValues: {
            username: 'wallas',
            password: 'wallas1234@',
        },
    })

    const loading = ref<boolean>(false)
    const { value: username } = useField<string>('username')
    const { value: password } = useField<string>('password')

    const handleLogin = handleSubmit(values => {
        loading.value = true
        setTimeout(() => {
            try {
                navigateTo('/movements')
            } finally {
                loading.value = false
            }
        }, 2000)
    })
</script>