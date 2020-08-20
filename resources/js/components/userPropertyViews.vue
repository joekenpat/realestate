<template>
  <div class="uk-container uk-padding-remove uk-margin">
    <div
      class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-small uk-border-rounded"
    >
      <h3 class="uk-padding-small">
        <b style="color: #87ceeb">They Viewed Your Properties</b>
      </h3>
      <hr class="uk-margin-remove" />
      <!-----table start here-------->
      <table
        class="uk-table uk-table-responsive uk-table-small uk-table-divider uk-margin-remove-top"
      >
        <thead>
          <tr>
            <th><b>Image</b></th>
            <th><b>Property</b></th>
            <th><b>View Name</b></th>
            <th><b>Viewer Email</b></th>
            <th><b>Viewer Phone</b></th>
            <th><b>Time</b></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(view, index) in views"
            :id="`view${index}_${view.property.id}`"
            :key="`view${index}_${view.property.id}`"
          >
            <td>
              <img
                :src="view.user.avatar != null?
                  `${base_url}/images/users/profile/${view.user.id}/${view.user.avatar}`: `${base_url}/images/misc/default_avatar.png`
                "
                class="uk-border-circle"
                    style="height:40px;width:40px;object-fit:cover;"
              />
            </td>
            <td >
              {{ view.property.title }}
            </td>
            <td>{{ view.user.last_name }} {{ view.user.first_name }}</td>
            <td>{{ view.user.email }}</td>
            <td>{{ view.user.phone }}</td>
            <td>
              <time :datetime="view.created_at">{{ moment(view.created_at).fromNow() }}</time>
            </td>
          </tr>
          <tr v-if="Object.keys(views).length == 0">
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
      views: [],
      base_url: window.location.origin,
      property_pagination_data: {
        record_count: 0,
        page_count: 0,
        current_page: 1
      }
    };
  },
  methods: {
    load_data(page = 1) {
      this.loading = !this.loading;
      let url = `${this.base_url}/api/user/property/user_view?page=${page}`;
      axios
        .get(url)
        .then(res => {
          this.views = res.data.data;
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
    }
  },
  created() {
    this.load_data(1);
  }
};
</script>
