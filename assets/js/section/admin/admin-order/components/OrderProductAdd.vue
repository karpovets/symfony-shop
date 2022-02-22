<template>
  <div class="row mb-2">
    <div class="col-md-2">
      <select
          v-model="form.categoryId"
          name="add_product_category_select"
          class="form-control"
          @change="getProducts()"
        >
        <option value="" disabled>- choose option -</option>
        <option
          v-for="category in categories"
          :key="category.id"
          :value="category.id">
          {{category.title}}
        </option>
      </select>
    </div>

    <div v-if="form.categoryId" class="col-md-3">
      <select
          v-model="form.productId"
          name="add_product_product_select"
          class="form-control"
      >
        <option value="" disabled>- choose option -</option>
        <option
            v-for="categoryProduct in freeCategoryProducts"
            :key="categoryProduct.id"
            :value="categoryProduct.uuid">
          {{ productTitle(categoryProduct) }}
        </option>
      </select>
    </div>

    <div v-if="form.productId" class="col-md-2">
      <input
          v-model="form.quantity"
          type="number"
          class="form-control"
          placeholder="quantity"
          min="1"
          :max="productQuantityMax"
      >
    </div>

    <div v-if="form.productId" class="col-md-2">
      <input
          v-model="form.pricePerOne"
          type="number"
          class="form-control"
          placeholder="price per one"
          step="0.01"
          min="1"
          :max="productPriceMax"
      >
    </div>

    <div v-if="form.productId" class="col-md-3">
      <button
        class="btn btn-outline-info"
        @click="viewDetails"
      >
        Details
      </button>

      <button
        class="btn btn-outline-success"
        @click="submit"
      >
        Add
      </button>
    </div>
  </div>
</template>

<script>
import {mapState, mapMutations, mapActions, mapGetters} from 'vuex'
import {getProductInformativeTitle} from "../../../../utils/title-formatter";
import {getUrlViewproduct} from "../../../../utils/url-generator";
export default {
  name: "OrderProductAdd",
  data() {
    return {
      form: {
        categoryId: "",
        productId: "",
        quantity: "",
        pricePerOne: ""
      }
    };
  },
  computed: {
    ...mapState("products", ["categories", "staticStore", "categoryProducts"]),
    ...mapGetters("products", ["freeCategoryProducts"]),

    productQuantityMax() {
      const productData = this.freeCategoryProducts.find(
          product => product.uuid == this.form.productId
      );
      return parseInt(productData.quantity);
    },

    productPriceMax() {
      const productData = this.freeCategoryProducts.find(
          product => product.uuid == this.form.productId
      );
      return parseFloat(productData.price);
    }
  },
  methods: {
    ...mapMutations("products", ["setNewProductInfo"]),
    ...mapActions("products", ["addNewOrderProduct", "getProductsByCategory"]),

    getProducts() {
      console.log(this.form);
      this.setNewProductInfo(this.form);
      this.getProductsByCategory()
    },

    productTitle(product) {
      return getProductInformativeTitle(product);
    },

    viewDetails(event) {
      event.preventDefault();
      const url = getUrlViewproduct(this.staticStore.url.viewProduct, this.form.productId);

      window.open(url, '_blank').focus();
    },

    submit(event) {
      event.preventDefault();
      this.setNewProductInfo(this.form);
      this.addNewOrderProduct();
      this.resetFormData();
    },

    resetFormData() {
      Object.assign(this.$data, this.$options.data.apply(this))
    }
  }
}

</script>
