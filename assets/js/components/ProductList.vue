<template>
    <div class="product-list">
        <ProductCard
            v-for="produit in produits"
            :key="produit.id"
            :produit="produit"
        />
    </div>
</template>

<script>
import ProductCard from './ProductCard.vue'

export default {
  props: ['produits'],
  components: { ProductCard }
}
</script>

<style scoped>
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1.5rem;
}
</style>