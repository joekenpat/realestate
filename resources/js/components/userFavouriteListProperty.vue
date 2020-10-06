<template>
  <div class="uk-container uk-padding-remove uk-margin">
    <div
      class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-small uk-border-rounded"
    >
      <h3 class="uk-padding-small">
        <b style="color: #87ceeb">My Favourite Properties</b>
      </h3>
      <hr class="uk-margin-remove" />
      <!-----table start here-------->
      <table
        class="uk-table uk-table-responsive uk-table-small uk-table-divider uk-margin-remove-top"
      >
        <thead>
          <tr>
            <th><b>Image</b></th>
            <th><b>Item</b></th>
            <th><b>Category</b></th>
            <th><b>Price</b></th>
            <th><b>Action</b></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="favourite in favourites"
            :id="`item_${favourite.property.id}`"
            :key="favourite.property.id"
          >
            <td>
              <img
                :src="
                  `${base_url}/images/properties/${favourite.property.id}/${favourite.property.images[0]}`
                "
                style="height: 100px; width: 100px"
              />
            </td>
            <td class="uk-table-link">
              <a
                :href="`${base_url}/property/view/${favourite.property.id}`"
                class="uk-link-reset"
              >
                <ul class="uk-margin-remove-bottom uk-padding-remove-left">
                  <li class="property_title">
                    {{ favourite.property.title }}
                  </li>
                  <li>
                    <time :datetime="favourite.property.created_at">{{
                      favourite.property.created_at
                    }}</time>
                  </li>
                  <li>
                    <span class="uk-label uk-label-success">{{
                      favourite.property.list_as
                    }}</span>
                  </li>
                </ul>
              </a>
            </td>
            <td>
              <a href="#">{{ favourite.property.category.name }}</a> &gt;
              <a href="#">{{ favourite.property.subcategory.name }}</a>
            </td>
            <td>&#8358;{{ number_format(favourite.property.price) }}</td>
            <td>
              <button
                @click="remove_fav_property(favourite.property.id)"
                uk-tooltip="Remove Property"
                class="uk-icon-link red-text"
                uk-icon="icon:close; ratio:1"
              ></button>
            </td>
          </tr>
          <tr v-if="Object.keys(favourites).length == 0">
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
export default {
  data() {
    return {
      favourites: [],
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
      plan_map: ["free", "vip", "featured","premium"],
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
    load_data(page = 1) {
      this.loading = !this.loading;
      let url = `${this.base_url}/api/user/property/favourite?page=${page}`;
      axios
        .get(url)
        .then(res => {
          this.favourites = res.data.data;
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
    number_format(x) {
      return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    },
    remove_fav_property(property_id) {
      this.$swal
        .fire({
          icon: "warning",
          title: "Remove Property",
          showCancelButton: true,
          confirmButtonText: "Yes, Remove",
          showLoaderOnConfirm: true,
          preConfirm: upgrade_plan => {
            return axios
              .get(
                `${this.base_url}/api/user/property/favourite/remove/${property_id}`
              )
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
            this.load_data()
          }
        });
    }
  },
  created() {
    this.load_data(1);
  }
};
</script>
