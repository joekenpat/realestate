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
            @click="set_property_status('all')"
            class="uk-button uk-button-small uk-button-default"
          >
            All
          </button>
          <button
            @click="set_property_status('pending')"
            class="uk-button uk-button-small uk-button-default"
          >
            Pending
          </button>
          <button
            @click="set_property_status('active')"
            class="uk-button uk-button-small uk-button-default"
          >
            Active
          </button>
          <button
            @click="set_property_status('expired')"
            class="uk-button uk-button-small uk-button-default"
          >
            Expired
          </button>
        </div>
        <div class="uk-button-group uk-flex-center">
          <button
            @click="set_property_plan('all')"
            class="uk-button uk-button-small uk-button-default"
          >
            All
          </button>
          <button
            @click="set_property_plan('free')"
            class="uk-button uk-button-small uk-button-default"
          >
            Free
          </button>
          <button
            @click="set_property_plan('featured')"
            class="uk-button uk-button-small uk-button-default"
          >
            Featured
          </button>
          <button
            @click="set_property_plan('distress')"
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
            v-for="property in properties"
            :id="`item_${property.id}`"
            :key="property.id"
          >
            <td>
              <img
                :src="
                  `${base_url}/images/properties/${property.id}/${property.images[0]}`
                "
                style="height: 100px; width: 100px"
              />
            </td>
            <td class="uk-table-link">
              <a
                :href="`${base_url}/property/view/${property.id}`"
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
            <td>N{{ property.price }}</td>
            <td>
              <span class="uk-label uk-label-warning">{{
                property.status
              }}</span>
            </td>
            <td>
              <!-- <a
                :href="`${base_url}/user/property/upgrade/${property.id}`"
                style="color:orange"
                uk-tooltip="Upgrade Property"
                class="uk-icon-link"
                uk-icon="icon:push; ratio:1"
              ></a> -->
              <button
                @click="edit_property(property.id)"
                style="color:blue"
                uk-tooltip="Edit Property"
                class="uk-icon-link"
                uk-icon="icon:file-edit; ratio:1"
              ></button>
              <button
                @click="delete_property(property.id)"
                style="color:red"
                uk-tooltip="Delete Property"
                class="uk-icon-link"
                uk-icon="icon:trash; ratio:1"
              ></button>
            </td>
          </tr>
          <tr v-if="Object.keys(properties).length == 0">
            <td colspan="6" class="uk-text-center">No Data Yet</td>
          </tr>
        </tbody>
      </table>
      <hr />
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
      property_status: "all",
      property_plan: "all"
    };
  },
  methods: {
    delete_property(property_id) {
      let pid = property_id;
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
            .get(`${this.base_url}/api/user/property/delete/${pid}`)
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
        allowOutsideClick: () => !Swal.isLoading()
      });
    },
    edit_property(property_id) {
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
            window.open(`${this.base_url}/user/property/edit/${property_id}`);
          }
        });
    },
    load_filter_data() {
      this.data_url = `${this.base_url}/api/user/property/list`;
      let filter_data = {
        plan: this.property_plan,
        status: this.property_status
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
          this.properties = res.data.data;
          this.load_property_pagination_data(
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
    set_property_plan(plan) {
      this.property_plan = plan;
      this.load_filter_data();
    },
    set_property_status(status) {
      this.property_status = status;
      this.load_filter_data(1);
    }
  },
  created() {
    this.load_filter_data(1);
  }
};
</script>
