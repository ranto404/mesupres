<script setup>
import { defineProps, reactive, watch } from "@vue/runtime-core"
import { Head, Link, router, useForm } from "@inertiajs/vue3"
import {
    mdiArrowLeftBoldOutline,
    mdiAccountKey,
} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import BaseButton from "@/Components/BaseButton.vue"

const form = useForm({
  designation: '',
  specification: '',
  unite: '',
  quantite: '',
  prix_unitaire: '',
  montant: '',
  user_id: null, // Initialize with null value
})

const submitForm = () => {
    form.post('/admin/product')
}

// Assuming you have a prop named `authUserId` passed to this Vue component
// which contains the ID of the authenticated user
const { authUserId } = defineProps(['authUserId'])

// Watch the `authUserId` prop for changes and update the `user_id` field
// in the form with the authenticated user ID
watch(() => authUserId, (newValue) => {
  form.user_id = newValue
})
</script>
<template>
<LayoutAuthenticated>
    <Head title="Create Product" />
    <SectionMain>
    <SectionTitleLineWithButton
        :icon="mdiAccountKey"
        title="Create Product"
        main
    >
    <BaseButton
          :route-name="route('product.index')"
          :icon="mdiArrowLeftBoldOutline"
          label="Back"
          color="white"
          rounded-full
          small
        />
</SectionTitleLineWithButton>
    <CardBox>
        <form @submit.prevent="submitForm">
        <div class="mb-6">
            <label for="designation" class="block text-sm font-medium text-gray-700">
            Designation
            </label>
            <input
            type="text"
            v-model="form.designation"
            id="designation"
            name="designation"
            autocomplete="off"
            class="
                mt-1
                focus:ring-indigo-500 focus:border-indigo-500
                block
                w-full
                shadow-sm
                sm:text-sm
                border-gray-300
                rounded-md
            "
            />
        </div>
        <div class="mb-6">
            <label for="specification" class="block text-sm font-medium text-gray-700">
            Specification
            </label>
            <textarea
            v-model="form.specification"
            id="specification"
            name="specification"
            rows="3"
            class="
                mt-1
                focus:ring-indigo-500 focus:border-indigo-500
                block
                w-full
                shadow-sm
                sm:text-sm
                border-gray-300
                rounded-md
            "
            ></textarea>
        </div>
        <div class="mb-6">
            <label for="unite" class="block text-sm font-medium text-gray-700">
            Unite
            </label>
            <input
            type="text"
            v-model="form.unite"
            id="unite"
            name="unite"
            autocomplete="off"
            class="
                mt-1
                focus:ring-indigo-500 focus:border-indigo-500
                block
                w-full
                shadow-sm
                sm:text-sm
                border-gray-300
                rounded-md
            "
            />
        </div>
        <div class="mb-6">
            <label for="quantite" class="block text-sm font-medium text-gray-700">
            Quantite
            </label>
            <input
            type="number"
            v-model="form.quantite"
            id="quantite"
            name="quantite"
            autocomplete="off"
            class="
                mt-1
                focus:ring-indigo-500 focus:border-indigo-500
                block
                w-full
                shadow-sm
                sm:text-sm
                border-gray-300
                rounded-md
            "
            />
        </div>
        <div class="mb-6">
            <label for="prix_unitaire" class="block text-sm font-medium text-gray-700">
            Prix unitaire
            </label>
            <input
            type="number"
            v-model="form.prix_unitaire"
            id="prix_unitaire"
            name="prix_unitaire"
            autocomplete="off"
            class="
                mt-1
                focus:ring-indigo-500 focus:border-indigo-500
                block
                w-full
                shadow-sm
                sm:text-sm
                border-gray-300
                rounded-md
            "
            />
        </div>
        <div class="mb-6">
            <label for="montant" class="block text-sm font-medium text-gray-700">
            Montant
            </label>
            <input
            type="text"
            v-model="form.montant"
            id="montant"
            name="montant"
            class="
                mt-1
                focus:ring-indigo-500 focus:border-indigo-500
                block
                w-full
                shadow-sm
                sm:text-sm
                border-gray-300
                rounded-md
            "
            />
        </div>
        <div class="flex items-center justify-end mt-6">
            <BaseButton
            type="submit"
            label="Create"
            color="primary"
            :disabled="form.processing"
            @click="submitForm"
            />
        </div>
        </form>
    </CardBox>
    </SectionMain>
</LayoutAuthenticated>
</template>
