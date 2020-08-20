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
          <h3>All Reports</h3>
        </div>
        <div class="uk-card-body uk-padding-small">
          <ul uk-accordion="active: 0">
            <li v-for="(report, index) in reports" :key="index">
              <a class="uk-accordion-title" href="#"
                >#{{ (index + 1) * report_pagination_data.current_page }}.
                {{ report.title }}</a
              >
              <div class="uk-accordion-content">
                <p>{{ report.message }}</p>
                <div class="uk-padding-small uk-width-1-1">
                  <div class="uk-grid uk-grid-small">
                    <div class="uk-margin-small-bottom">
                      <button
                        type="button"
                        class="uk-border-rounded uk-button uk-button-small blue white-text"
                        @click="show_reporter(index)"
                        style="color:blue"
                        uk-tooltip="View Reporter"
                      >
                        <span
                          class="uk-icon-link uk-margin-small-right white-text"
                          uk-icon="icon:user; ratio:1"
                        ></span
                        >View Reporter
                      </button>
                    </div>
                    <div class="uk-margin-small-bottom">
                      <button
                        type="button"
                        class="uk-border-rounded uk-button uk-button-small  yellow white-text"
                        uk-tooltip="Block Reporter"
                      >
                        <span
                          class="uk-icon-link uk-margin-small-right white-text"
                          uk-icon="icon:user; ratio:1"
                        ></span
                        >Block Reporter
                      </button>
                    </div>
                    <div class="uk-margin-small-bottom">
                      <button
                        type="button"
                        @click="show_property(index)"
                        class="uk-border-rounded uk-button uk-button-small  blue white-text"
                        uk-tooltip="View Property"
                      >
                        <span
                          class="uk-icon-link uk-margin-small-right white-text"
                          uk-icon="icon:home; ratio:1"
                        ></span
                        >View Property
                      </button>
                    </div>
                    <div class="uk-margin-small-bottom">
                      <button
                        type="button"
                        class="uk-border-rounded uk-button uk-button-small  red white-text"
                        style="color:home"
                        uk-tooltip="Disable Property"
                      >
                        <span
                          class="uk-icon-link uk-margin-small-right white-text"
                          uk-icon="icon:ban; ratio:1"
                        ></span
                        >Disable Property
                      </button>
                    </div>
                    <div class="uk-margin-small-bottom">
                      <button
                        type="button"
                        class="uk-border-rounded uk-button uk-button-small  red white-text"
                        uk-tooltip="Delete Property"
                      >
                        <span
                          class="uk-icon-link uk-margin-small-right white-text"
                          uk-icon="icon:trash; ratio:1"
                        ></span
                        >Delete Property
                      </button>
                    </div>
                    <div class="uk-margin-small-bottom">
                      <button
                        type="button"
                        class="uk-border-rounded uk-button uk-button-small  blue white-text"
                        @click="show_property_owner(index)"
                        uk-tooltip="View Property Owner"
                      >
                        <span
                          class="uk-icon-link uk-margin-small-right white-text"
                          uk-icon="icon:user; ratio:1"
                        ></span
                        >View Property Owner
                      </button>
                    </div>
                    <div class="uk-margin-small-bottom">
                      <button
                        type="button"
                        class="uk-border-rounded uk-button uk-button-small red white-text"
                        uk-tooltip="Block Property Owner"
                      >
                        <span
                          class="uk-icon-link uk-margin-small-right white-text"
                          uk-icon="icon:user; ratio:1"
                        ></span
                        >Block Property Owner
                      </button>
                    </div>
                    <div class="uk-margin-small-bottom">
                      <button
                        type="button"
                        class="uk-border-rounded uk-button uk-button-small  green white-text"
                        uk-tooltip="Resolve Report"
                      >
                        <span
                          class="uk-icon-link uk-margin-small-right white-text"
                          uk-icon="icon:check; ratio:1"
                        ></span
                        >Resolve Report
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
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
      reports: [],
      user: null,
      base_url: window.location.origin,
      report_pagination_data: {
        record_count: 0,
        page_count: 0,
        current_page: 1
      },
      data_url: ""
    };
  },
  methods: {
    load_data(page = 1) {
      this.data_url = `${this.base_url}/api/report/list?status=${this.status}`;
      let url = `${this.data_url}?page=${page}`;
      this.loading = !this.loading;
      axios
        .get(url)
        .then(res => {
          this.reports = res.data.data;
          this.load_report_pagination_data(
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
    init_property_data(property) {
      this.$refs.property_side_bar.load_data(property);
      UIkit.offcanvas(this.$refs.property_data_panel).show();
    },
    show_property(x) {
      this.init_property_data(this.reports[x].property);
    },
    show_property_owner(x) {
      this.init_user_data(this.reports[x].property.user);
    },
    show_reporter(x) {
      this.init_user_data(this.reports[x].reporter);
    },

    report_page_swap(page = this.report_pagination_data.current_page) {
      if (page > this.report_pagination_data.page_count || page < 1) {
        let page = 1;
      }
      this.load_data(page);
      return;
    },
    load_report_pagination_data(last_page, current_page, total_records) {
      this.report_pagination_data = {
        page_count: last_page,
        current_page: current_page,
        record_count: total_records
      };
    }
  },
  created() {
    this.load_data();
  },
  props: {
    status: {
      required: false,
      type: String,
      default: "all"
    }
  }
};
</script>
