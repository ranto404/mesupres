<script setup>
import { Head } from '@inertiajs/vue3'
import { computed, ref, onMounted } from 'vue'
import { useMainStore } from '@/stores/main'
import {
  mdiAccountMultiple,
  mdiCartOutline,
  mdiChartTimelineVariant,
} from '@mdi/js'
import * as chartConfig from '@/Components/Charts/chart.config.js'
import SectionMain from '@/Components/SectionMain.vue'
import CardBoxWidget from '@/Components/CardBoxWidget.vue'
import CardBoxClient from "@/Components/CardBoxClient.vue"
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import axios from 'axios'

const chartData = ref(null)

const fillChartData = () => {
  chartData.value = chartConfig.sampleChartData()
}

const userCount = ref(0);

const fetchUserCount = () => {
  axios.get('/admin/users-count')
    .then(response => {
      userCount.value = response.data;
    })
    .catch(error => {
      console.error(error);
    });
};

onMounted(fetchUserCount);

const productCount = ref(0);

const fetchProductCount = () => {
  axios.get('/admin/products-count')
    .then(response => {
      productCount.value = response.data;
    })
    .catch(error => {
      console.error(error);
    });
};

onMounted(fetchProductCount);

const mainStore = useMainStore()

const clientBarItems = computed(() => mainStore.clients.slice(0, 4))
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Dashboard" />
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiChartTimelineVariant"
        title="Dashboard"
        main
      >
      </SectionTitleLineWithButton>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
        <CardBoxWidget
          :icon="mdiAccountMultiple"
          :number="userCount"
          label="Users"
        />
        <CardBoxWidget
          :icon="mdiCartOutline"
          :number="productCount"
          label="Nombre de Produits"
        />
      </div>
      <CardBoxClient
            v-for="user in users"
            :key="user.id"
            :name="user.name"
            :login="user.login"
            :date="user.created"
            :progress="user.progress"
          />
    </SectionMain>
  </LayoutAuthenticated>
</template>
