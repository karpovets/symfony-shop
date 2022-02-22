<template>
  <div class="table-additional-selection">
    <OrderProductAdd/>
    <hr/>
      <OrderProductsItem
      v-for="(orderProduct, index) in orderProducts"
      :key="orderProduct.id"
      :order-product="orderProduct"
      :index="index"
      />
    <hr/>
    <TotalPriceBlock/>
  </div>
</template>
<script>
import { mapState, mapActions } from "vuex";
import OrderProductsItem from "./components/OrderProductItem";
import OrderProductAdd from "./components/OrderProductAdd";
import TotalPriceBlock from "./components/TotalPriceBlock";

export default {
  components: {OrderProductAdd, OrderProductsItem, TotalPriceBlock},
  created() {
    this.getCategories();
    this.getOrderProducts();
  },
  computed: {
    ...mapState("products", ["orderProducts"]),
  },
  methods: {
    ...mapActions("products", ["getCategories", "getOrderProducts"])
  }
}
</script>
