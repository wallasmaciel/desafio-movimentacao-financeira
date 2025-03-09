<template>
    <div class="d-flex flex-column">
        <div class="d-flex justify-end">
            <input type="text" v-model="search" placeholder="Procurando" />
            <v-btn
                class="text-none"
                color="primary"
                prepend-icon="mdi-plus"
                variant="flat"
            >
                Adicionar
            </v-btn>
        </div>
        <v-data-table-virtual
            :headers="headers"
            :items="virtualBoats"
            item-value="name"
            fixed-header
            :loading="loading"
            loading-text="Carregando..."
        >    
            <template v-slot:item.actions="{ item }">
                <v-btn icon @click="editItem(item)">
                    <v-icon>mdi-pencil</v-icon>
                </v-btn>
                <v-btn icon @click="deleteItem(item)">
                    <v-icon>mdi-delete</v-icon>
                </v-btn>
            </template>    
        </v-data-table-virtual>
    </div>
</template>

<script setup>
    useHead({
        title: 'Categorias',
    })
    definePageMeta({
        layout: 'authenticated',
    })

    const search = ref('')
    const loading = ref(false)
    const headers = reactive([
        { title: 'Data de criação', align: 'start', key: 'created_at' },
        { title: 'Nome', align: 'start', key: 'name' },
        { title: 'Tipo', align: 'start', key: 'type' },
        { title: 'Descrição', align: 'start', key: 'description' },
        { title: 'Status', align: 'start', key: 'status' },
        { text: 'Ações', value: 'actions', sortable: false },
    ])
    const virtualBoats = reactive([])
</script>