<script setup>
import { defineProps } from "vue"
import { computed, ref, onMounted } from 'vue'
import { Head, Link, useForm } from "@inertiajs/vue3"
import {
    mdiChat,
    mdiCartOutline,
  mdiAccountKey,
  mdiArrowLeftBoldOutline,
} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import BaseButton from "@/Components/BaseButton.vue"
import axios from "axios"

const props = defineProps({
  user: {
    type: Object,
    default: () => ({}),
  },
  products: {
    type: Array,
    default: () => [],
  },
  roles: {
    type: Object,
    default: () => ({}),
  },
  userHasRoles: {
    type: Object,
    default: () => ({}),
  }
})

const productCount = ref(0);

const fetchProductCount = (userId) => {
  axios.get(`/admin/products-count?${userId}`)
    .then(response => {
        console.log(response.data)
      productCount.value = response.data;
    })
    .catch(error => {
      console.error(error);
    });
};

onMounted(() => {
  fetchProductCount(user.id);
});

</script>

<template>
  <LayoutAuthenticated>
    <Head title="View user" />
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiAccountKey"
        title="View user"
        main
      >
        <BaseButton
          :route-name="route('user.index')"
          :icon="mdiArrowLeftBoldOutline"
          label="Back"
          color="white"
          rounded-full
          small
        />
      </SectionTitleLineWithButton>
      <CardBox class="mb-6">
        <table>
          <tbody>
            <tr>
              <td
                class="
                  p-4
                  pl-8
                  text-slate-500
                  dark:text-slate-400
                  hidden
                  lg:block
                "
              >
                DIRECTION
              </td>
              <td data-label="DIRECTION">
                {{ user.direction }}
              </td>
            </tr>
            <tr>
              <td
                class="
                  p-4
                  pl-8
                  text-slate-500
                  dark:text-slate-400
                  hidden
                  lg:block
                "
              >
                Name
              </td>
              <td data-label="Name">
                {{ user.name }}
              </td>
            </tr>
            <tr>
              <td
                class="
                  p-4
                  pl-8
                  text-slate-500
                  dark:text-slate-400
                  hidden
                  lg:block
                "
              >
                Email
              </td>
              <td data-label="Email">
                {{ user.email }}
              </td>
            </tr>
            <tr>
              <td
                class="
                  p-4
                  pl-8
                  text-slate-500
                  dark:text-slate-400
                  hidden
                  lg:block
                "
              >
                SOA
              </td>
              <td data-label="SOA">
                {{ user.soa }}
              </td>
            </tr>
            <tr>
              <td
                class="
                  p-4
                  pl-8
                  text-slate-500
                  dark:text-slate-400
                  hidden
                  lg:block
                "
              >
                Nombre de produits
              </td>
              <td data-label="Nombre de produits">
                {{ productCount }}
              </td>
            </tr>
            <tr>
              <td
                class="
                  p-4
                  pl-8
                  text-slate-500
                  dark:text-slate-400
                  hidden
                  lg:block
                "
              >
                Montant
              </td>
              <td data-label="Montant">
                {{ user.soa }}
              </td>
            </tr>
          </tbody>
        </table>
      </CardBox>
      <SectionTitleLineWithButton
        :icon="mdiCartOutline"
        title="Product"
        main
      >
      </SectionTitleLineWithButton>
      <CardBox class="mb-6">
        <table>
          <thead>
            <tr>
              <th>Designation</th>
              <th>Specification</th>
              <th>Unité</th>
              <th>Quantité</th>
              <th>Prix unitaire</th>
              <th>Montant</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products" :key="product.id">
              <td data-label="Designation">{{ product.designation }}</td>
              <td data-label="Specification">{{ product.specification }}</td>
              <td data-label="Unité">{{ product.unite }}</td>
              <td data-label="Quantité">{{ product.quantite }}</td>
              <td data-label="Prix unitaire">{{ product.prix_unitaire }}</td>
              <td data-label="Montant">{{ product.quantite * product.prix_unitaire }}</td>
            </tr>
          </tbody>
        </table>
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
