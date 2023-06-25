<script setup>
import { defineProps } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import {
    mdiChat,
  mdiCartOutline,
  mdiPlus,
  mdiSquareEditOutline,
  mdiTrashCan,
  mdiAlertBoxOutline,
} from '@mdi/js'
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionMain from '@/Components/SectionMain.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import BaseButton from '@/Components/BaseButton.vue'
import CardBox from '@/Components/CardBox.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import NotificationBar from '@/Components/NotificationBar.vue'
import axios from 'axios'

axios.get('/admin/product', {
    params: { with: 'user' }
}).then(response => {
    this.products = response.data;
}).catch(error => {
    console.log(error);
});

const props = defineProps({
  products: {
    type: Object,
    default: () => ({}),
  },
  filters: {
    type: Object,
    default: () => ({}),
  },
  can: {
    type: Object,
    default: () => ({}),
  },
})

const form = useForm({
  search: props.filters.search,
})

const formDelete = useForm({})

function destroy(id) {
  if (confirm("Are you sure you want to delete?")) {
    formDelete.delete(route("product.destroy", id))
  }
}

</script>

<template>
  <LayoutAuthenticated>
    <Head title="Products" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiCartOutline" title="Products" main>
        <BaseButton
          v-if="can.create"
          :href="route('product.create')"
          :icon="mdiPlus"
          label="Add"
          color="info"
          rounded-full
          small
        />
      </SectionTitleLineWithButton>
      <NotificationBar v-if="$page.props.flash.message" color="success" :icon="mdiAlertBoxOutline">
        {{ $page.props.flash.message }}
      </NotificationBar>
      <CardBox class="mb-6" has-table>
        <form @submit.prevent="post(route('product.index'))">
          <div class="py-2 flex">
            <div class="flex pl-4">
              <input
                type="search"
                v-model="form.search"
                class="
                  rounded-md
                  shadow-sm
                  border-gray-300
                  focus:border-indigo-300
                  focus:ring
                  focus:ring-indigo-200
                  focus:ring-opacity-50
                "
                placeholder="Search"
              />
              <BaseButton
                label="Search"
                type="submit"
                color="info"
                class="ml-4 inline-flex items-center px-4 py-2"
              />
            </div>
          </div>
        </form>
      </CardBox>
      <CardBox class="mb-6" has-table>
        <table>
          <thead>
            <tr>
              <th>Designation</th>
              <th>Specification</th>
              <th>Unité</th>
              <th>Quantité</th>
              <th>Prix unitaire</th>
              <th>Montant</th>
              <th>User</th>
              <th v-if="can.edit || can.delete">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products.data" :key="product.id">
              <td data-label="Designation">
                <Link
                  :href="route('product.show', product.id)"
                  class="
                    no-underline
                    hover:underline
                    text-cyan-600
                    dark:text-cyan-400
                  "
                >
                {{ product.designation }}
            </Link>
            </td>
              <td data-label="Specification">{{ product.specification }}</td>
              <td data-label="Unité">{{ product.unite }}</td>
              <td data-label="Quantité">{{ product.quantite }}</td>
              <td data-label="Prix unitaire">{{ product.prix_unitaire }}</td>
              <td data-label="Montant">{{ product.quantite * product.prix_unitaire }}</td>
              <td data-label="User">
                <Link
                  :href="route('user.show', product.user_id)"
                  class="
                    no-underline
                    hover:underline
                    text-cyan-600
                    dark:text-cyan-400
                  "
                >
                 {{ product.user.name }}
            </Link>
            </td>
              <td v-if="can.edit || can.delete">
                <BaseButtons type="justify-start lg:justify-end" no-wrap>
                  <BaseButton
                    v-if="can.edit"
                    :href="route('product.edit', product.id)"
                    color="info"
                    :icon="mdiSquareEditOutline"
                    small
                  />
                  <BaseButton
                    v-if="can.delete"
                    color="danger"
                    :icon="mdiTrashCan"
                    small
                    @click="destroy(product.id)"
                  />
                  <BaseButton
                        :href="route('chatify.user.id', { user_id: product.user_id })"
                        color="success"
                        :icon="mdiChat"
                        small
                    />
                </BaseButtons>
              </td>
            </tr>
          </tbody>
        </table>
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
