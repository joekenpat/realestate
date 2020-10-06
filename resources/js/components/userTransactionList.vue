<template>
  <div class="uk-container uk-padding-remove uk-margin">
    <div
      class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-small uk-border-rounded"
    >
      <h5 class="uk-padding-small">
        <b style="color: #87ceeb">All Transactions</b>
      </h5>
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
            v-model="transaction_status"
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
      </div>
      <hr class="uk-margin-remove" />
      <!---tab button end here---->
      <!-----table start here-------->

      <table
        class="uk-table uk-table-responsive uk-table-small uk-table-divider uk-margin-remove-bottom"
      >
        <thead>
          <tr>
            <th><b>Property</b></th>
            <th><b>Plan</b></th>
            <th><b>Amount</b></th>
            <th><b>Status</b></th>
            <th><b>Time</b></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="transaction in transactions"
            :id="`item_${transaction.id}`"
            :key="transaction.id"
          >
            <td>
              <li class="transaction_title">
                {{ transaction.property.title }}
              </li>
            </td>
            <td>
              <span
                :class="[
                  'uk-label',
                  { black: transaction.plan == 'free' },
                  { red: transaction.plan == 'vip' },
                  { orange: transaction.plan == 'featured' },
                  { purple: transaction.plan == 'premium' }
                ]"
                >{{ transaction.plan }}</span
              >
            </td>
            <td>&#8358;{{ number_format(transaction.amount) }}</td>
            <td>
              <span
                :class="[
                  'uk-label',
                  { 'orange lighten-1': transaction.status == 'pending' },
                  { 'green lighten-1': transaction.status == 'success' },
                  { red: transaction.status == 'failed' }
                ]"
                >{{ transaction.status }}</span
              >
            </td>
            <td>
              <time :datetime="transaction.created_at">{{
                moment(transaction.created_at).fromNow()
              }}</time>
            </td>
          </tr>
          <tr v-if="Object.keys(transactions).length == 0">
            <td colspan="6" class="uk-text-center">No Data Yet</td>
          </tr>
        </tbody>
      </table>
      <hr class="uk-margin-remove-top" />
      <div class="uk-flex-center" uk-margin>
        <paginate
          v-if="transaction_pagination_data.record_count > 0"
          v-model="transaction_pagination_data.current_page"
          :page-count="transaction_pagination_data.page_count"
          :page-range="3"
          :margin-pages="2"
          :prev-text="'<span uk-pagination-previous></span>'"
          :next-text="'<span uk-pagination-next></span>'"
          :container-class="'uk-pagination uk-flex-center'"
          :active-class="'uk-active'"
          :disable-class="'uk-disabled'"
          :click-handler="transaction_page_swap"
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
      transactions: [],
      base_url: window.location.origin,
      transaction_pagination_data: {
        record_count: 0,
        page_count: 0,
        current_page: 1
      },
      status_map: ["failed", "pending", "success"],
      transaction_status: "all"
    };
  },
  methods: {
    load_filter_data() {
      this.data_url = `${this.base_url}/api/user/transaction/list`;
      let filter_data = {
        status: this.transaction_status
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
          this.transactions = res.data.data;
          this.load_transaction_pagination_data(
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
    transaction_page_swap(
      page = this.transaction_pagination_data.current_page
    ) {
      if (page > this.transaction_pagination_data.page_count || page < 1) {
        let page = 1;
      }
      this.load_data(page);
      return;
    },
    load_transaction_pagination_data(last_page, current_page, total_records) {
      this.transaction_pagination_data = {
        page_count: last_page,
        current_page: current_page,
        record_count: total_records
      };
    }
  },
  created() {
    this.load_filter_data(1);
  }
};
</script>
