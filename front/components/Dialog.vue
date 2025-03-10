<template>
    <v-dialog v-model="$props.modelValue" max-width="500"
        @keydown.esc="closeDialog">
        <v-card>
            <v-card-title class="d-flex justify-space-between align-center">
                <div class="text-h5 text-medium-emphasis ps-2">
                    {{ props.title }}
                </div>

                <v-btn icon="mdi-close" variant="text" @click="closeDialog"></v-btn>
            </v-card-title>

            <v-card-text>
                <slot></slot>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script setup>
    const props = defineProps({
        modelValue: Boolean,
        title: {
            type: String,
            required: true,
        }
    })
    const emit = defineEmits(['update:modelValue']);
    const closeDialog = () => emit('update:modelValue', false)
</script>