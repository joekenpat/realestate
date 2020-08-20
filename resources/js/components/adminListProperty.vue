<template>
  <div class="" uk-grid>
    <div
      id="user_details"
      ref="user_data_panel"
      uk-offcanvas="flip: true; overlay: true;bg-close:false;"
    >
      <div class="uk-offcanvas-bar white" style="width:45vw;">
        <button
          class="uk-offcanvas-close black-text"
          type="button"
          uk-close
        ></button>
        <div id="right_bar_content">
          <user-details ref="user_side_bar"></user-details>
        </div>
      </div>
    </div>
    <div
      id="property_details"
      ref="property_data_panel"
      uk-offcanvas="flip: true; overlay: true;bg-close:false;"
    >
      <div class="uk-offcanvas-bar white" style="width:45vw;">
        <button
          class="uk-offcanvas-close black-text"
          type="button"
          uk-close
        ></button>
        <div id="right_bar_content">
          <property-details ref="property_side_bar"></property-details>
        </div>
      </div>
    </div>
    <div class="uk-width-1-1">
      <div class="uk-card uk-card-default uk-border-rounded">
        <div class="uk-card-header uk-padding-small">
          <h3 class="uk-text-capitalize">{{property_status}} Properties</h3>
        </div>
        <div class="uk-card-body uk-padding-remove">
          <table
            class="uk-table uk-table-small uk-table-divider uk-table-middle"
          >
            <thead>
              <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Plan</th>
                <th v-if="property_status == 'all'">Status</th>
                <th>Location</th>
                <th>Author</th>
                <th>Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(property, index) in properties" :key="index">
                <td>
                  <img
                    :src="
                      properties.images != []
                        ? `${base_url}/images/properties/${property.id}/${property.images[0]}`
                        : `${base_url}/images/misc/default_avatar.png`
                    "
                    class="uk-border-circle"
                    style="height:40px;width:40px;object-fit:cover;"
                    :alt="`${property.title} first image`"
                  />
                </td>
                <td>{{ property.title }}</td>
                <td>
                  <span
                    :class="[
                      'uk-label',
                      { black: property.plan == 'free' },
                      { red: property.plan == 'distress' },
                      { orange: property.plan == 'featured' }
                    ]"
                    >{{ property.plan }}</span
                  >
                </td>
                <td v-if="property_status == 'all'">
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
                  <a
                    :href="
                      `${base_url}/property/list?state=${property.state.id}`
                    "
                    >{{ property.state.name }}</a
                  >,
                  <a
                    :href="`${base_url}/property/list?city=${property.city.id}`"
                    >{{ property.city.name }}</a
                  >
                </td>
                <td>
                  {{ property.user.last_name }} {{ property.user.first_name }}
                </td>
                <td>N{{ number_format(property.price) }}</td>
                <td>
                  <div>
                    <button
                      @click="show_property_owner(index)"
                      href="#"
                      style="color:blue"
                      uk-tooltip="View Owner"
                      class="uk-icon-link uk-margin-small-right"
                      uk-icon="icon:user; ratio:1"
                    ></button>
                    <button
                      @click="show_property(index)"
                      style="color:blue"
                      uk-tooltip="View Property"
                      class="uk-icon-link uk-margin-small-right"
                      uk-icon="icon:home; ratio:1"
                    ></button>
                    <!-- <button
                      href="#"
                      style="color:yellow"
                      uk-tooltip="Edit Property"
                      class="uk-icon-link uk-margin-small-right"
                      uk-icon="icon:file-edit; ratio:1"
                    ></button> -->
                    <button
                      v-if="property.status != 'active'"
                      @click="switch_property_status(property.id,'active')"
                      style="color:green"
                      uk-tooltip="Activate Property"
                      class="uk-icon-link uk-margin-small-right"
                      uk-icon="icon:check; ratio:1"
                    ></button>
                    <button
                      v-if="property.status == 'pending'"
                      @click="switch_property_status(property.id,'declined')"
                      style="color:red"
                      uk-tooltip="Decline Property"
                      class="uk-icon-link uk-margin-small-right"
                      uk-icon="icon:ban; ratio:1"
                    ></button>
                    <button
                      @click="switch_property_status(property.id,'disabled')"
                      style="color:red"
                      uk-tooltip="Disable Property"
                      class="uk-icon-link uk-margin-small-right"
                      uk-icon="icon:close; ratio:1"
                    ></button>
                    <button
                      style="color:red"
                      uk-tooltip="Delete Property"
                      class="uk-icon-link uk-margin-small-right"
                      uk-icon="icon:trash; ratio:1"
                    ></button>
                  </div>
                </td>
              </tr>
              <tr v-if="properties == []">
                <td class="uk-text-center" colspan="8">No data to display</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      loading: false,
      properties: [],
      user: null,
      base_url: window.location.origin,
      property_pagination_data: {
        record_count: 0,
        page_count: 0,
        current_page: 1
      },
      data_url: ""
    };
  },
  methods: {
    load_data(page = 1) {
      this.data_url = `${this.base_url}/api/property/list?status=${this.property_status}`;
      let url = `${this.data_url}&page=${page}`;
      this.loading = !this.loading;
      axios
        .get(url)
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
    init_user_data(user) {
      this.$refs.user_side_bar.load_data(user);
      UIkit.offcanvas(this.$refs.user_data_panel).show();
    },
    show_property_owner(x) {
      this.init_user_data(this.properties[x].user);
    },
    init_property_data(property) {
      this.$refs.property_side_bar.load_data(property);
      UIkit.offcanvas(this.$refs.property_data_panel).show();
    },
    show_property(x) {
      this.init_property_data(this.properties[x]);
    },
    property_page_swap(page = this.property_pagination_data.current_page) {
      if (page > this.property_pagination_data.page_count || page < 1) {
        let page = 1;
      }
      this.load_data(page);
      return;
    },
    switch_property_status(property_id, status) {
      const Toast = this.$swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: toast => {
          toast.addEventListener("mouseenter", this.$swal.stopTimer);
          toast.addEventListener("mouseleave", this.$swal.resumeTimer);
        }
      });
      let url = `${this.base_url}/api/property/${property_id}/set_status/${status}`;
      this.loading = !this.loading;
      axios
        .get(url)
        .then(res => {
          // console.log(res.data.data);
          Toast.fire({
            icon: "success",
            title: res.data
          });
          this.load_data(this.property_pagination_data.current_page);
        })
        .catch(err => {
          // console.log(err.response);
          Toast.fire({
            icon: "error",
            title: err.response.statusText
          });
          this.load_data(this.property_pagination_data.current_page);
        });
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
    }
  },
  created() {
    this.load_data();
  },
  props: {
    property_status: {
      required: false,
      type: String,
      default: "all"
    }
  }
};
</script>
