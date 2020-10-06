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
        <div class="uk-form-controls uk-width-1-2">
          <select
            class="uk-select uk-border-rounded"
            id="status"
            name="status"
            v-model="property_status"
            @change="load_filter_data()"
          >
            <option selected value="all">All Status</option>
            <option
              v-for="(status, index) in status_map"
              :key="index"
              :value="status"
              >{{ status }}</option
            >
          </select>
        </div>
        <div class="uk-form-controls uk-width-1-2">
          <select
            class="uk-select uk-border-rounded"
            id="plan"
            name="plan"
            v-model="property_plan"
            @change="load_filter_data()"
          >
            <option selected value="all">All Plan</option>
            <option
              v-for="(plan, index) in plan_map"
              :key="index"
              :value="plan"
              >{{ plan }}</option
            >
          </select>
        </div>
      </div>
      <hr class="uk-margin-remove" />
      <!---tab button end here---->
      <!-----table start here-------->

      <table
        class="uk-table uk-table-responsive uk-table-small uk-table-divider uk-margin-remove-bottom"
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
            v-for="property in properties"
            :id="`item_${property.id}`"
            :key="property.id"
          >
            <td>
              <img
                :src="
                  Object.keys(property.images).length > 0
                    ? `${base_url}/images/properties/${property.id}/${property.images[0]}`
                    : `${base_url}/images/misc/no-image.jpg`
                "
                style="height: 100px; width: 100px"
              />
            </td>
            <td class="uk-table-link">
              <a
                :href="`${base_url}/property/view/${property.slug}`"
                class="uk-link-reset"
              >
                <ul class="uk-margin-remove-bottom uk-padding-remove-left">
                  <li class="property_title">
                    {{ property.title }}
                  </li>
                  <li>
                    <time :datetime="property.created_at">{{
                      property.created_at
                    }}</time>
                  </li>
                  <li>
                    <span class="uk-label uk-label-success">{{
                      property.list_as
                    }}</span>
                  </li>
                </ul>
              </a>
            </td>
            <td>
              <a href="#">{{ property.category.name }}</a> &gt;
              <a href="#">{{ property.subcategory.name }}</a>
            </td>
            <td>&#8358;{{ number_format(property.price) }}</td>
            <td>
              <span
                :class="[
                  'uk-label',
                  { 'orange lighten-1': property.status == 'pending' },
                  { 'green lighten-1': property.status == 'active' },
                  { red: property.status == 'disabled' },
                  { 'red lighten-2': property.status == 'expired' },
                  { 'red accent-2': property.status == 'declined' }
                ]"
                >{{ property.status }}</span
              >
            </td>
            <td>
              <button
                @click="upgrade_property(property.slug)"
                uk-tooltip="Upgrade Property"
                class="uk-icon-link orange-text"
                uk-icon="icon:push; ratio:1"
              ></button>
              <button
                @click="edit_property(property.slug)"
                uk-tooltip="Edit Property"
                class="uk-icon-link blue-text"
                uk-icon="icon:file-edit; ratio:1"
              ></button>
              <button
                @click="close_property(property.slug)"
                uk-tooltip="Close Property"
                class="uk-icon-link red-text"
                uk-icon="icon:close; ratio:1"
              ></button>
              <button
                @click="delete_property(property.slug)"
                uk-tooltip="Delete Property"
                class="uk-icon-link red-text"
                uk-icon="icon:trash; ratio:1"
              ></button>
            </td>
          </tr>
          <tr v-if="Object.keys(properties).length == 0">
            <td colspan="6" class="uk-text-center">No Data Yet</td>
          </tr>
        </tbody>
      </table>
      <hr class="uk-margin-remove-top" />
      <div class="uk-flex-center" uk-margin>
        <paginate
          v-if="property_pagination_data.record_count > 0"
          v-model="property_pagination_data.current_page"
          :page-count="property_pagination_data.page_count"
          :page-range="3"
          :margin-pages="2"
          :prev-text="'<span uk-pagination-previous></span>'"
          :next-text="'<span uk-pagination-next></span>'"
          :container-class="'uk-pagination uk-flex-center'"
          :active-class="'uk-active'"
          :disable-class="'uk-disabled'"
          :click-handler="property_page_swap"
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
      properties: [],
      base_url: window.location.origin,
      property_pagination_data: {
        record_count: 0,
        page_count: 0,
        current_page: 1
      },
      Toast: this.$swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: toast => {
          toast.addEventListener("mouseenter", this.$swal.stopTimer);
          toast.addEventListener("mouseleave", this.$swal.resumeTimer);
        }
      }),
      plan_map: ["free", "vip", "featured", "premium"],
      status_map: [
        "active",
        "pending",
        "declined",
        "reported",
        "disabled",
        "expired",
        "closed"
      ],
      property_status: "all",
      property_plan: "all"
    };
  },
  methods: {
    delete_property(property_slug) {
      let pslug = property_slug;
      this.$swal.fire({
        title: "Delete Property",
        text: "You won't be able to revert this!",
        icon: "warning",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        showCancelButton: true,
        confirmButtonText: "Delete",
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return axios
            .get(`${this.base_url}/api/user/property/delete/${pslug}`)
            .then(response => {
              this.load_data(this.property_pagination_data.current_page);
              return this.$swal.fire({
                title: `${response.data}`,
                icon: "success"
              });
            })
            .catch(error => {
              this.$swal.showValidationMessage(`Request failed: ${error}`);
            });
        },
        allowOutsideClick: () => !this.$swal.isLoading()
      });
    },
    edit_property(property_slug) {
      this.$swal
        .fire({
          title: "Are you sure?",
          text: "You want be edit this property!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, Edit!"
        })
        .then(result => {
          if (result.value) {
            window.location = `${this.base_url}/user/property/edit/${property_slug}`;
          }
        });
    },
    load_filter_data() {
      this.data_url = `${this.base_url}/api/user/property/list?plan=${this.property_plan}&status=${this.property_status}`;
      this.load_data(1);
    },
    load_data(page = 1) {
      this.loading = !this.loading;
      let url = `${this.data_url}&page=${page}`;
      let config = {
        header: {
          "Content-Type": "multipart/form-data"
        }
      };
      axios
        .post(url, this.payload, config)
        .then(res => {
          this.properties = res.data.data;
          this.load_property_pagination_data(
            res.data.last_page,
            res.data.current_page,
            res.data.total
          );
          this.loading = !this.loading;
        })
        .catch(err => {
          // console.log(err.response);
          this.loading = !this.loading;
        });
    },
    number_format(x) {
      return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    },
    property_page_swap(page = this.property_pagination_data.current_page) {
      if (page > this.property_pagination_data.page_count || page < 1) {
        let page = 1;
      }
      this.load_data(page);
      return;
    },
    load_property_pagination_data(last_page, current_page, total_records) {
      this.property_pagination_data = {
        page_count: last_page,
        current_page: current_page,
        record_count: total_records
      };
    },
    close_property(property_slug) {
      this.$swal
        .fire({
          icon: "warning",
          title: "Close this Property",
          showCancelButton: true,
          confirmButtonText: "Yes, CLose",
          showLoaderOnConfirm: true,
          preConfirm: upgrade_plan => {
            return axios
              .get(`${this.base_url}/api/user/property/close/${property_slug}`)
              .then(res => {
                return res;
              })
              .catch(error => {
                this.$swal.showValidationMessage(`Request failed: ${error}`);
              });
          },
          allowOutsideClick: () => !this.$swal.isLoading()
        })
        .then(result => {
          if (result.value) {
            this.Toast.fire({
              icon: "success",
              title: result.value.data
            });
          }
        });
    },
    upgrade_property(property_slug) {
      this.$swal
        .fire({
          title: "Select Plan For Upgrade",
          input: "select",
          inputOptions: {
            vip: "vip",
            featured: "Featured",
            premium: "Premium"
          },
          inputAttributes: {
            autocapitalize: "off"
          },
          showCancelButton: true,
          confirmButtonText: "Proceed",
          showLoaderOnConfirm: true,
          preConfirm: upgrade_plan => {
            let payload = new FormData();
            payload.append("property_slug", property_slug);
            payload.append("plan", upgrade_plan);

            return axios
              .post(`${this.base_url}/api/user/property/upgrade`, payload)
              .then(res => {
                return res;
              })
              .catch(error => {
                this.$swal.showValidationMessage(`Request failed: ${error}`);
              });
          },
          allowOutsideClick: () => !this.$swal.isLoading()
        })
        .then(result => {
          if (result.value) {
            if (result.value.data.url) {
              this.Toast.fire({
                icon: "success",
                title: "Redirecting you to make payment"
              });
              window.location = result.value.data.url;
            } else {
              this.Toast.fire({
                icon: "info",
                title: result.value.data
              });
            }
          }
        });
    }
  },
  created() {
    this.load_filter_data(1);
  }
};
</script>
