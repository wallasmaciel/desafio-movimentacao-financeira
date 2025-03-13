<template>
    <div class="d-flex flex-column ps-2 pt-2 pe-2 pb-2">
        <div class="d-flex justify-end">
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
                <v-btn icon @click="handleDeleteCategory(item.id)">
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
                <v-select v-model="category_type" label="Tipo" :error-messages="errors.type"
                    :items="itemsTypes" item-title="text"></v-select>
                <v-btn :loading="formLoading" text="Entrar" type="submit" color="primary"
                    class="w-100"></v-btn>
            </v-form>
        </Dialog>
    </div>
</template>

<script setup lang="ts">
    import { onMounted } from 'vue'
    import * as yup from 'yup'
import { formattedDate } from '~/utils/dateUtil'

    useHead({
        title: 'Categorias',
    })
    definePageMeta({
        layout: 'authenticated',
    })

    const { $axios } = useNuxtApp()

    interface Category {
        id: string,
        name: string,
        description: string,
        type: string,
        created_at: string,
    }

    interface CategoryForm {
        name: string
        description: string
        type: string
    }

    const validationSchema: yup.ObjectSchema<CategoryForm> = yup.object({
        name: yup.string().required('O nome é obrigatório'),
        description: yup.string().required('A descrição é obrigatório'),
        type: yup.string().required('O tipo é obrigatório'),
    })
    const { handleSubmit, errors, resetForm } = useForm<CategoryForm>({
        validationSchema,
    })

    const category_id = ref<string | null>(null)
    const { value: category_name } = useField<string>('name')
    const { value: category_description } = useField<string>('description')
    const { value: category_type } = useField<string>('type')

    const search = ref('')
    const tableLoading = ref(false)
    const formLoading = ref(false)
    const dialogAdd = ref(false)
    const headers = reactive([
        { title: 'Data de criação', value: 'created_at' },
        { title: 'Nome', value: 'name' },
        { title: 'Tipo', value: 'type' },
        { title: 'Descrição', value: 'description' },
        { text: 'Ações', value: 'actions', sortable: false },
    ])
    const data = ref<Readonly<Category>[]>([])
    const itemsTypes = ref([
        'ENTRADA',
        'SAIDA',
    ])

    const handleOpenDialog = () => {
        category_id.value = null
        resetForm()
        // 
        dialogAdd.value = true
    }
    const handleCreateCategory = handleSubmit(values => {
        const dataRequest = {
            name: values.name,
            description: values.description,
            type: values.type,
        }
        let request = category_id.value
            ? $axios.put(`/categories/${category_id.value}`, dataRequest)
            : $axios.post('/categories', dataRequest)
        request.then(response => {
            dialogAdd.value = false
            fetchCategories()
        }).catch(err => {
            alert(err.response?.data?.message ?? err.message ?? err)
        })
    })

    const fetchCategories = async() => {
        tableLoading.value = true
        try {
            const response = await $axios.get<Category[]>("/categories")
            if (response.status != 200) throw new Error('Falha na consulta de categorias: ' + response.statusText)
            data.value = response.data.map(value => ({
                ...value,
                created_at: formattedDate(value.created_at),
            }))
        } catch(err: any) {
            alert(err.response?.data?.message ?? err.message ?? err)
        } finally {
            tableLoading.value = false
        }
    }

    const handleDeleteCategory = (id: string) => {
        $axios.delete(`/categories/${id}`).then(response => {
            fetchCategories()
        }).catch(err => {
            alert(err.response?.data?.message ?? err.message ?? err)
        })
    }

    const handleEditTransaction = (item: Category) => {
        category_id.value = item.id
        category_name.value = item.name
        category_description.value = item.description
        category_type.value = item.type
        // 
        dialogAdd.value = true
    }

    onMounted(fetchCategories)
</script>