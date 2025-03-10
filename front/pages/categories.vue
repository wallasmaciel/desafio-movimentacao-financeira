<template>
    <div class="d-flex flex-column ps-2 pt-2 pe-2 pb-2">
        <div class="d-flex justify-end">
            <input type="text" v-model="search" placeholder="Procurando" />
            <v-btn
                class="text-none"
                color="primary"
                prepend-icon="mdi-plus"
                variant="flat"
                @click="handleOpenDialog"
            >
                Adicionar
            </v-btn>
        </div>
        <v-data-table-virtual
            :headers="headers"
            :items="data"
            item-value="name"
            fixed-header
            :loading="tableLoading"
            loading-text="Carregando..."
        > 
            <template v-slot:item.actions="{ item }">
                <v-btn icon>
                    <v-icon>mdi-pencil</v-icon>
                </v-btn>
                <v-btn icon>
                    <v-icon>mdi-delete</v-icon>
                </v-btn>
            </template>    
        </v-data-table-virtual>
        <Dialog v-model="dialogAdd"
            :title="!category_id? 'Cadastrar categoria' : 'Alterar categoria'">
            <v-form @submit.prevent="handleCreateCategory">
                <input type="hidden" v-model="category_id">

                <v-text-field v-model="category_name" type="text" label="Nome" :error-messages="errors.name"></v-text-field>
                <v-text-field v-model="category_description" type="text" label="Descrição" :error-messages="errors.description"></v-text-field>
                <v-row>
                    <v-col>
                        <v-select v-model="category_type" label="Tipo" :error-messages="errors.type"
                            :items="itemsTypes" item-title="text"></v-select>
                    </v-col>
                    <v-col>
                        <v-select v-model="category_status" label="Status" :error-messages="errors.status"
                            :items="itemsStatus" item-value="value" item-title="text"></v-select>
                    </v-col>
                </v-row>
                <v-btn :loading="formLoading" text="Entrar" type="submit" color="primary"
                    class="w-100"></v-btn>
            </v-form>
        </Dialog>
    </div>
</template>

<script setup lang="ts">
    import * as yup from 'yup'

    useHead({
        title: 'Categorias',
    })
    definePageMeta({
        layout: 'authenticated',
    })

    interface CategoryForm {
        name: string
        description: string
        type: string
        status: number
    }

    const validationSchema: yup.ObjectSchema<CategoryForm> = yup.object({
        name: yup.string().required('O nome é obrigatório'),
        description: yup.string().required('A descrição é obrigatório'),
        type: yup.string().required('O tipo é obrigatório'),
        status: yup.number().required('O status é obrigatório'),
    })
    const { handleSubmit, errors } = useForm<CategoryForm>({
        validationSchema,
    })

    const category_id = ref<string | null>(null)
    const { value: category_name } = useField<string>('name')
    const { value: category_description } = useField<string>('description')
    const { value: category_type } = useField<string>('type')
    const { value: category_status } = useField<number>('status')

    const search = ref('')
    const tableLoading = ref(false)
    const formLoading = ref(false)
    const dialogAdd = ref(false)
    const headers = reactive([
        { title: 'Data de criação', value: 'created_at' },
        { title: 'Nome', value: 'name' },
        { title: 'Tipo', value: 'type' },
        { title: 'Descrição', value: 'description' },
        { title: 'Status', value: 'status' },
        { text: 'Ações', value: 'actions', sortable: false },
    ])
    const data = reactive([])
    const itemsStatus = ref([
        { value: 1, text: 'ATIVO' },
        { value: 0, text: 'INATIVO' },
    ])
    const itemsTypes = ref([
        'ENTRADA',
        'SAIDA',
    ])

    const handleOpenDialog = () => {
        category_id.value = null
        dialogAdd.value = true
    }
    const handleCreateCategory = handleSubmit(values => {
        alert(category_id.value)
    })
</script>