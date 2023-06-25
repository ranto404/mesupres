<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import {
  mdiAccountKey,
  mdiArrowLeftBoldOutline,
} from "@mdi/js"
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionMain from '@/Components/SectionMain.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import CardBox from '@/Components/CardBox.vue'
import BaseButton from '@/Components/BaseButton.vue'

const props = defineProps({
  product: {
    type: Object,
    default: () => ({}),
  },
})
</script>
<template>
    <LayoutAuthenticated>
      <Head title="View Product" />
      <SectionMain>
        <SectionTitleLineWithButton
          :icon="mdiAccountKey"
          title="Product Details"
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

        <!-- Contenu des détails du produit -->
        <CardBox>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="font-bold">Designation:</p>
              <p>{{ product.designation }}</p>
            </div>
            <div>
              <p class="font-bold">Specification:</p>
              <p>{{ product.specification }}</p>
            </div>
            <div>
              <p class="font-bold">Unité:</p>
              <p>{{ product.unite }}</p>
            </div>
            <div>
              <p class="font-bold">Quantité:</p>
              <p>{{ product.quantite }}</p>
            </div>
            <div>
              <p class="font-bold">Prix unitaire:</p>
              <p>{{ product.prix_unitaire }}</p>
            </div>
            <div>
              <p class="font-bold">Montant:</p>
              <p>{{ product.quantite * product.prix_unitaire }}</p>
            </div>
          </div>
        </CardBox>
      </SectionMain>
    </LayoutAuthenticated>
  </template>
