<template>
    <v-app>
        <v-container class="d-flex h-screen justify-center align-center">
            <v-form @submit.prevent="handleLogin" class="d-flex flex-column w-50">
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

    const { $axios } = useNuxtApp()

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
            password: '123456',
        },
    })

    const loading = ref<boolean>(false)
    const { value: username } = useField<string>('username')
    const { value: password } = useField<string>('password')

    const handleLogin = handleSubmit(async values => {
        loading.value = true
        // 
        try {
            const response = await $axios.post('/users/login', {
                username: values.username, 
                password: values.password,
            })
            if (response.status != 200) throw new Error("Problema ao realizar login." + response.data)
            // 
            localStorage.setItem("auth_token", response.data.token)
            navigateTo('/movements')
        } catch(err: any) {
            alert(err.response?.data?.message ?? err.message ?? err)
        } finally {
            loading.value = false
        }
    })
</script>