<template>
  <div>
    <div v-if="publishableKey">
      <div v-if="checkoutUrl">
        <button @click="submit" :disabled="loading">Pay Now</button>
      </div>
      <p v-else>Cargando sesión...</p>
    </div>
    <div v-else>Cargando configuración de Stripe...</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      publishableKey: window.Laravel.clientStripe,
      checkoutUrl: '',
       lineItems: [
        {
          price: 'price_1QTO20EHJX14M8EEKW0SS0s7', // recurrente
          quantity: 1
        },
      ]
    };
  },
  methods: {
    submit() {
      if (this.checkoutUrl) {
        window.location.href = this.checkoutUrl;
      }
    }
  },
  async mounted() {
    try {
      const res = await this.$axios.get('/api/stripe/create-session/' + this.lineItems[0].price);
      console.log("Respuesta de Stripe:", res.data);

      // El objeto Session devuelto por Stripe (vía Laravel) contiene una propiedad 'url'.
      // Redirigir directamente a esta URL es el método actual recomendado.
      if (res.data && res.data.url) {
        this.checkoutUrl = res.data.url;
      } else {
        console.error("No se pudo obtener la URL de Checkout del servidor. Estructura recibida:", res.data);
      }
    } catch (error) {
      console.error("Error obteniendo sesión:", error);
    }
  }
}
</script>