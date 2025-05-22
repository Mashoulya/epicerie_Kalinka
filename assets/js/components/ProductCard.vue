<template>
  <div class="card">
    <svg
      class="svg-cadre"
      width="408"
      height="401"
      viewBox="0 0 408 401"
      xmlns="http://www.w3.org/2000/svg"
    >
      <defs>
        <clipPath id="cadreForme">
          <path d="M17.131 0H0V22.6832C0 30.7484 4.63779 37.8054 6.95669 40.3257C4.82845 41.7159 3.07183 45.033 1.82198 48.2654C0.335485 52.1097 0 56.2675 0 60.3892V400.69H408C408 266.691 407.989 65.1933 407.989 57.1281C407.989 49.063 403.624 42.566 401.442 40.3257C407.007 35.285 408.126 27.1685 407.989 23.7404V0H384.664C378.116 0 372.387 4.76068 370.341 7.14101C368.05 2.77239 359.838 0.56008 356.019 0H52.3798C45.5049 0 39.6941 5.04072 37.648 7.56107C37.0204 5.19885 33.1285 3.16827 29.2615 1.75435C25.3949 0.34056 21.248 0 17.131 0Z" />
        </clipPath>
      </defs>

      <image
        :xlink:href="imagePath(product.image)"
        width="408"
        height="401"
        clip-path="url(#cadreForme)"
        preserveAspectRatio="xMidYMid slice"
      />
    </svg>

    <div class="info-produit">
      <h2 class="nom">{{ product.name }}</h2>
      <div class="prix">
        <span class="euro">{{ product.price }} €</span>
        <span class="kilo">4,50 €/kg</span>
      </div>
      <div class="details">
        <span class="poids">250g</span>
        <span class="localisation">📍 Kab. Bekasi</span>
        <span class="note">⭐ 4.5 / 5</span>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  name: 'ProductCard',
  props: {
    product: Object
  },
  methods: {
    imagePath(filename) {
      return `/uploads/images/products/${filename}`;
    }
  }
};
</script>


<style scoped lang="scss">
.card {
  width: 408px;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  background-color: rgb(226, 118, 118);
  font-family: sans-serif;

  .svg-cadre {
    display: block;
    width: 100%;
    height: auto;
  }

  .info-produit {
    padding: 12px;

    .nom {
      font-size: 16px;
      font-weight: bold;
      margin: 0 0 8px;
    }

    .prix {
      display: flex;
      justify-content: space-between;
      font-weight: bold;
      color: #333;

      .kilo {
        font-size: 12px;
        color: #888;
      }
    }

    .details {
      margin-top: 10px;
      font-size: 13px;
      color: #666;
      display: flex;
      justify-content: space-between;

      .note {
        color: #f5a623;
      }
    }
  }
}
</style>

