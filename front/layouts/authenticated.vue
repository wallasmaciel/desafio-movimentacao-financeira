<template>
    <v-card color="grey-lighten-4" style="min-height: 100vh;" rounded="0" flat>
        <v-toolbar density="compact" height="80">
            <v-toolbar-title>Movimentos</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn @click="handleToMoviments">
                <span>Movimentações</span>
            </v-btn>

            <v-btn @click="handleToCategories">
                <span>Categorias</span>
            </v-btn>

            <v-btn @click="handleLogout">
                <v-icon size="24" color="red">mdi-logout</v-icon>
            </v-btn>
        </v-toolbar>
        <main class="overflow-auto" style="max-height: calc(100vh - 80);">
            <slot></slot>
        </main>
    </v-card>
</template>

<script setup>
    const handleToMoviments = () => navigateTo('/movements')
    const handleToCategories = () => navigateTo('/categories')
    const handleLogout = () => {
        localStorage.removeItem('auth_token')
        navigateTo('/')
    }
</script>