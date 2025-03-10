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
            :title="!movement_id? 'Cadastrar movimento' : 'Alterar movimento'">
            <v-form @submit.prevent="handleCreateMoviment">
                <input type="hidden" v-model="movement_id">

                <v-text-field v-model="movement_description" type="text" label="Descrição" :error-messages="errors.description"></v-text-field>
                <v-row>
                    <v-col>
                        <v-text-field v-model="movement_ammount" type="text" label="Valor" :error-messages="errors.ammount"></v-text-field>
                    </v-col>
                    <v-col>
                        <v-select v-model="movement_category" label="Categoria" :items="listCategories" :error-messages="errors.category"></v-select>
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
    import Dialog from '~/components/Dialog.vue'

    useHead({
        title: 'Movimentações',
    })
    definePageMeta({
        layout: 'authenticated',
    })

    interface MovimentForm {
        description: string
        type: string
        ammount: number
        category: string
    }

    const validationSchema: yup.ObjectSchema<MovimentForm> = yup.object({
        description: yup.string().required('A descrição é obrigatório'),
        type: yup.string().required('O tipo é obrigatório'),
        ammount: yup.number().required('O valor é obrigatório'),
        category: yup.string().required('A categoria é obrigatória'),
    })
    const { handleSubmit, errors } = useForm<MovimentForm>({
        validationSchema,
    })

    const movement_id = ref<string | null>(null)
    const { value: movement_description } = useField<string>('description')
    const { value: movement_category } = useField<string>('category')
    const { value: movement_ammount } = useField<string>('ammount')
    const { value: movement_type } = useField<string>('type')

    const dialogAdd = ref(false)
    const formLoading = ref(false)
    const tableLoading = ref(false)
    const search = ref('')
    const headers = reactive([
        { title: 'Data de criação', value: 'created_at' },
        { title: 'Descrição', value: 'description' },
        { title: 'Tipo', value: 'type' },
        { title: 'Valor', value: 'ammount' },
        { title: 'Categoria', value: 'category' },
        { text: 'Ações', value: 'actions', sortable: false },
    ])
    const data = reactive([])
    const listCategories = reactive<string[]>([])

    const handleOpenDialog = () => {
        movement_id.value = null
        dialogAdd.value = true
    }
    const handleCreateMoviment = handleSubmit(values => {

    })
</script>