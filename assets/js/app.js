// assets/js/app.js
import '../styles/app.scss';

import { createApp } from 'vue';
import ProductCard from './components/ProductCard.vue'; // Chemin corrigé si le fichier est bien là

const el = document.getElementById('product-data');

if (el) {
  const product = JSON.parse(el.dataset.product);
    console.log('Données product reçues:', product);  // Ajoute ça


  createApp({
    components: { ProductCard },
    data() {
      return { product };
    },
    template: `<ProductCard :product="product" />`
  }).mount('#product-data');
}

// Supprimer le code Vue 2 (inutile et incompatible)
