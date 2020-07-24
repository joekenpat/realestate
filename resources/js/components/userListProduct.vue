<template>
  <div class="uk-container uk-padding-remove uk-margin">
    <div
      class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-small uk-border-rounded"
    >
      <h5 class="uk-padding-small"><b style="color: #87ceeb">My Ads</b></h5>
      <hr class="uk-margin-remove" />
      <!---tab button start here---->
      <div
        uk-grid
        class="uk-text-center uk-child-width-1-1 uk-child-width-1-2@s uk-padding-small uk-grid-small uk-flex uk-flex-center"
      >
        <div class="uk-flex-center">
          <button
            @click="set_product_status('all')"
            class="uk-button uk-button-small uk-button-default"
          >
            All
          </button>
          <button
            @click="set_product_status('pending')"
            class="uk-button uk-button-small uk-button-default"
          >
            Pending
          </button>
          <button
            @click="set_product_status('active')"
            class="uk-button uk-button-small uk-button-default"
          >
            Active
          </button>
          <button
            @click="set_product_status('expired')"
            class="uk-button uk-button-small uk-button-default"
          >
            Expired
          </button>
        </div>
        <div class="uk-button-group uk-flex-center">
          <button
            @click="set_product_plan('all')"
            class="uk-button uk-button-small uk-button-default"
          >
            All
          </button>
          <button
            @click="set_product_plan('free')"
            class="uk-button uk-button-small uk-button-default"
          >
            Free
          </button>
          <button
            @click="set_product_plan('featured')"
            class="uk-button uk-button-small uk-button-default"
          >
            Featured
          </button>
          <button
            @click="set_product_plan('distress')"
            class="uk-button uk-button-small uk-button-default"
          >
            Distress
          </button>
        </div>
      </div>
      <hr class="uk-margin-remove" />
      <!---tab button end here---->
      <!-----table start here-------->

      <table
        class="uk-table uk-table-responsive uk-table-divider uk-margin-remove-top"
      >
        <thead>
          <tr>
            <th><b>Image</b></th>
            <th><b>Item</b></th>
            <th><b>Category</b></th>
            <th><b>Price</b></th>
            <th><b>Status</b></th>
            <th><b>Action</b></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="product in products"
            :id="`item_${product.id}`"
            :key="product.id"
          >
            <td>
              <img
                :src="
                  `${base_url}/images/products/${product.id}/${product.images[0]}`
                "
                style="height: 100px; width: 100px"
              />
            </td>
            <td class="uk-table-link">
              <a
                :href="`${base_url}/product/view/${product.id}`"
                class="uk-link-reset"
              >
                <ul class="uk-margin-remove-bottom uk-padding-remove-left">
                  <li class="product_title">
                    {{ product.title }}
                  </li>
                  <li>
                    <time :datetime="product.created_at">{{
                      product.created_at
                    }}</time>
                  </li>
                  <li>
                    <span class="uk-label uk-label-success">{{
                      product.list_as
                    }}</span>
                  </li>
                </ul>
              </a>
            </td>
            <td>
              <a href="#">{{ product.category.name }}</a> &gt;
              <a href="#">{{ product.subcategory.name }}</a>
            </td>
            <td>N{{ product.price }}</td>
            <td>
              <span class="uk-label uk-label-warning">{{
                product.status
              }}</span>
            </td>
            <td>
              <!-- <a
                :href="`${base_url}/user/product/upgrade/${product.id}`"
                style="color:orange"
                uk-tooltip="Upgrade Product"
                class="uk-icon-link"
                uk-icon="icon:push; ratio:1.3"
              ></a> -->
              <button
                @click="edit_product(product.id)"
                style="color:blue"
                uk-tooltip="Edit Product"
                class="uk-icon-link"
                uk-icon="icon:file-edit; ratio:1.3"
              ></button>
              <button
                @click="delete_product(product.id)"
                style="color:red"
                uk-tooltip="Delete Product"
                class="uk-icon-link"
                uk-icon="icon:trash; ratio:1.3"
              ></button>
            </td>
          </tr>
          <tr v-if="Object.keys(products).length == 0">
            <td colspan="6" class="uk-text-center">No Data Yet</td>
          </tr>
        </tbody>
      </table>
      <hr />
      <div class="uk-flex-center" uk-margin>
        <paginate
          v-if="product_pagination_data.record_count > 0"
          v-model="product_pagination_data.current_page"
          :page-count="product_pagination_data.page_count"
          :page-range="3"
          :margin-pages="2"
          :prev-text="'<span uk-pagination-previous></span>'"
          :next-text="'<span uk-pagination-next></span>'"
          :container-class="'uk-pagination uk-flex-center'"
          :active-class="'uk-active'"
          :disable-class="'uk-disabled'"
          :click-handler="product_page_swap"
        >
        </paginate>
      </div>
      <!----table end here----------->
    </div>
  </div>
</template>
<script>
import jsonToFormData from "json-form-data";
export default {
  data() {
    return {
      products: [],
      base_url: window.location.origin,
      product_pagination_data: {
        record_count: 0,
        page_count: 0,
        current_page: 1
      },
      product_status: "all",
      product_plan: "all"
    };
  },
  methods: {
    delete_product(product_id) {
      let pid = product_id;
      this.$swal.fire({
        title: "Delete Product",
        text: "You won't be able to revert this!",
        icon: "warning",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        showCancelButton: true,
        confirmButtonText: "Delete",
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return axios
            .get(`${this.base_url}/api/user/product/delete/${pid}`)
            .then(response => {
              this.load_data(this.product_pagination_data.current_page);
              return this.$swal.fire({
                title: `${response.data}`,
                icon: "success"
              });
            })
            .catch(error => {
              this.$swal.showValidationMessage(`Request failed: ${error}`);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
      });
    },
    edit_product(product_id) {
      this.$swal
        .fire({
          title: "Are you sure?",
          text: "You want be edit this product!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, Edit!"
        })
        .then(result => {
          if (result.value) {
            window.open(`${this.base_url}/user/product/edit/${product_id}`);
          }
        });
    },
    load_filter_data() {
      this.data_url = `${this.base_url}/api/user/product/list`;
      let filter_data = {
        plan: this.product_plan,
        status: this.product_status
      };
      let filter_form_config = {
        initialFormData: new FormData(),
        showLeafArrayIndexes: true,
        includeNullValues: false,
        mapping: function(value) {
          if (typeof value === "boolean") {
            return +value ? "1" : "0";
          }
          return value;
        }
      };
      this.payload = jsonToFormData(filter_data, filter_form_config);
      this.load_data(1);
    },
    load_data(page = 1) {
      this.loading = !this.loading;
      let url = `${this.data_url}?page=${page}`;
      let config = {
        header: {
          "Content-Type": "multipart/form-data"
        }
      };
      axios
        .post(url, this.payload, config)
        .then(res => {
          this.products = res.data.data;
          this.load_product_pagination_data(
            res.data.last_page,
            res.data.current_page,
            res.data.total
          );
          this.loading = !this.loading;
        })
        .catch(err => {
          console.log(err.response);
          this.loading = !this.loading;
        });
    },
    product_page_swap(page = this.product_pagination_data.current_page) {
      if (page > this.product_pagination_data.page_count || page < 1) {
        let page = 1;
      }
      this.load_data(page);
      return;
    },
    load_product_pagination_data(last_page, current_page, total_records) {
      this.product_pagination_data = {
        page_count: last_page,
        current_page: current_page,
        record_count: total_records
      };
    },
    set_product_plan(plan) {
      this.product_plan = plan;
      this.load_filter_data();
    },
    set_product_status(status) {
      this.product_status = status;
      this.load_filter_data(1);
    }
  },
  created() {
    this.load_filter_data(1);
  }
};
</script>
