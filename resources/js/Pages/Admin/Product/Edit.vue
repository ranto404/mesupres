<script setup>
import { Head, useForm, usePage } from "@inertiajs/vue3"
import {
    mdiArrowLeftBoldOutline,
    mdiSquareEditOutline
} from '@mdi/js'
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionMain from '@/Components/SectionMain.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from "@/Components/BaseButtons.vue"
import CardBox from '@/Components/CardBox.vue'

const props = defineProps({
  product: {
    type: Object,
    default: () => ({}),
  },
})

const form = useForm({
  _method: 'put',
  designation: props.product.designation,
  specification: props.product.specification,
  unite: props.product.unite,
  quantite: props.product.quantite,
  prix_unitaire: props.product.prix_unitaire,
})
</script>
<template>
    <LayoutAuthenticated>
      <Head title="Edit Product" />
      <SectionMain>
        <SectionTitleLineWithButton :icon="mdiSquareEditOutline" title="Edit Product" main >
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
          <form @submit.prevent="updateProduct">
            <!-- Champs de saisie pour les informations du produit -->
            <div class="mb-4">
              <label for="designation" class="block text-sm font-medium text-gray-700">Designation:</label>
              <input v-model="form.designation" type="text" id="designation" name="designation" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
              <label for="specification" class="block text-sm font-medium text-gray-700">Specification:</label>
              <textarea v-model="form.specification" id="specification" name="specification" rows="4" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>

            <div class="mb-4">
              <label for="unite" class="block text-sm font-medium text-gray-700">Unité:</label>
              <input v-model="form.unite" type="text" id="unite" name="unite" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
              <label for="quantite" class="block text-sm font-medium text-gray-700">Quantité:</label>
              <input v-model="form.quantite" type="number" id="quantite" name="quantite" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
              <label for="prix_unitaire" class="block text-sm font-medium text-gray-700">Prix unitaire:</label>
              <input v-model="form.prix_unitaire" type="number" id="prix_unitaire" name="prix_unitaire" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
              <label for="montant" class="block text-sm font-medium text-gray-700">Montant:</label>
              <input v-model="form.montant" type="number" id="montant" name="montant" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

                <BaseButtons>
                    <BaseButton
                    type="submit"
                    color="info"
                    label="Submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    />
                </BaseButtons>
          </form>
        </CardBox>
      </SectionMain>
    </LayoutAuthenticated>
  </template>
