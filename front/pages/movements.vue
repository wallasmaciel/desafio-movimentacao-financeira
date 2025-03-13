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
                <v-btn icon @click="handleEditTransaction(item)">
                    <v-icon>mdi-pencil</v-icon>
                </v-btn>
                <v-btn icon @click="handleDeleteTransaction(item.id)">
                    <v-icon>mdi-delete</v-icon>
                </v-btn>
            </template>    
        </v-data-table-virtual>
        <Dialog v-model="dialogAdd" 
            :title="!movement_id? 'Cadastrar movimento' : 'Alterar movimento'">
            <v-form @submit.prevent="handleCreateMoviment">
                <input type="hidden" v-model="movement_id">

                <v-text-field v-model="movement_description" type="text" label="Descrição" :error-messages="errors.description"></v-text-field>
                <v-row>
                    <v-col>
                        <v-text-field v-model="movement_ammount" type="text" label="Valor" :error-messages="errors.ammount"></v-text-field>
                    </v-col>
                    <v-col>
                        <v-select v-model="movement_category" label="Categoria" 
                            :items="listCategories" item-title="name" item-value="id" :error-messages="errors.category"></v-select>
                    </v-col>
                </v-row>
                <v-btn :loading="formLoading" text="Entrar" type="submit" color="primary"
                    class="w-100"></v-btn>
            </v-form>
        </Dialog>
    </div>
</template>

<script setup lang="ts">
    import { onMounted } from 'vue'
    import * as yup from 'yup'
    import Dialog from '~/components/Dialog.vue'

    useHead({
        title: 'Movimentações',
    })
    definePageMeta({
        layout: 'authenticated',
    })

    const { $axios } = useNuxtApp()

    interface Transaction {
        id: string
        user_id: string
        category_id: string
        description: string
        ammount: number
        created_at: string
    }

    interface MovimentForm {
        description: string
        ammount: number
        category: string
    }

    const validationSchema: yup.ObjectSchema<MovimentForm> = yup.object({
        description: yup.string().required('A descrição é obrigatório'),
        ammount: yup.number().required('O valor é obrigatório'),
        category: yup.string().required('A categoria é obrigatória'),
    })
    const { handleSubmit, errors, resetForm } = useForm<MovimentForm>({
        validationSchema,
    })

    const movement_id = ref<string | null>(null)
    const { value: movement_description } = useField<string>('description')
    const { value: movement_category } = useField<string>('category')
    const { value: movement_ammount } = useField<string>('ammount')

    const dialogAdd = ref(false)
    const formLoading = ref(false)
    const tableLoading = ref(false)
    const search = ref('')
    const headers = reactive([
        { title: 'Data de criação', value: 'created_at' },
        { title: 'Descrição', value: 'description' },
        { title: 'Tipo', value: 'category.type' },
        { title: 'Valor', value: 'ammount' },
        { title: 'Categoria', value: 'category.name' },
        { text: 'Ações', value: 'actions', sortable: false },
    ])
    const data = ref<Readonly<Transaction>[]>([])
    const listCategories = ref<Readonly<{
        id: string,
        name: string
    }>[]>([])

    const handleOpenDialog = () => {
        movement_id.value = null
        resetForm()
        // 
        dialogAdd.value = true
    }
    const handleCreateMoviment = handleSubmit(values => {
        const dataRequest = {
            category_id: values.category,
            description: values.description,
            ammount: values.ammount,
        }
        let request = movement_id.value
            ? $axios.put(`/transactions/${movement_id.value}`, dataRequest)
            : $axios.post('/transactions', dataRequest)
        // 
        request.then(response => {
            dialogAdd.value = false
            fetchTransactions()
        }).catch(err => {
            alert(err.response.data.message ?? err.message ?? err)
        })
    })

    const fetchTransactions = async() => {
        tableLoading.value = true
        try {
            const response = await $axios.get("/transactions")
            if (response.status != 200) throw new Error('Falha na consulta de transacoes: ', response.data)
            data.value = response.data
        } catch(err: any) {
            alert(err.response.data.message ?? err.message ?? err)
        } finally {
            tableLoading.value = false
        }
    }

    const fetchCategories = async() => {
        try {
            const response = await $axios.get("/categories")
            if (response.status != 200) throw new Error('Falha na consulta de categorias: ', response.data)
            listCategories.value = response.data
        } catch(err: any) {
            alert(err.response.data.message ?? err.message ?? err)
        }
    }

    const handleEditTransaction = (item: Transaction) => {
        movement_id.value = item.id
        movement_description.value = item.description
        movement_category.value = item.category_id
        movement_ammount.value = item.ammount.toString()
        // 
        dialogAdd.value = true
    }

    const handleDeleteTransaction = (id: string) => {
        $axios.delete(`/transactions/${id}`).then(response => {
            fetchTransactions()
        }).catch(err => {
            alert(err.response.data.message ?? err.message ?? err)
        })
    }

    onMounted(() => {
        fetchTransactions()
        fetchCategories()
    })
</script>