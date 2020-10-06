<template>
  <div class="uk-grid-collapse" uk-grid>
    <!-----nav links for desktop start here----->
    <div class="uk-visible@m uk-width-1-4 uk-padding-small">
      <div
        class="uk-card uk-border-rounded uk-card-default uk-card-body uk-padding-remove"
      >
        <form id="filter_form" method="get" class="">
          <div class="uk-padding-small">
            <h5 class="uk-margin-remove uk-text-bold" style="color: #87ceeb;">
              Plan
            </h5>
          </div>
          <div
            class="uk-grid-small uk-child-width-1-1 uk-padding-small uk-padding-remove-top"
            uk-grid
          >
            <div>
              <select
                class="uk-select uk-border-rounded"
                v-model="property_plan"
              >
                <option selected value="all">All</option>
                <option value="free">Free</option>
                <option value="vip">Vip</option>
                <option value="featured">Featured</option>
                <option value="premium">Premium</option>
              </select>
            </div>
          </div>
          <hr class="uk-margin-remove" />
          <div class="uk-padding-small">
            <h5 class="uk-margin-remove uk-text-bold" style="color: #87ceeb;">
              Category
            </h5>
          </div>

          <div
            class="uk-grid-small uk-child-width-1-1 uk-padding-small uk-padding-remove-top"
            uk-grid
          >
            <div class="">
              <select
                class="uk-select uk-border-rounded"
                id="category"
                name="category"
                v-model="category"
              >
                <option selected value="all">All</option>
                <option
                  v-for="(cat, index) in category_data"
                  :key="index"
                  :value="cat.id"
                  >{{ cat.name }}</option
                >
              </select>
            </div>
          </div>
          <hr class="uk-margin-remove" />
          <div class="uk-padding-small">
            <h5 class="uk-margin-remove uk-text-bold" style="color: #87ceeb;">
              Price Range
            </h5>
          </div>
          <div
            class="uk-grid-small uk-padding-small uk-padding-remove-top"
            uk-grid
          >
            <div class="uk-width-1-2">
              <label class="uk-form-label" for="form-stacked-text"
                ><b>min</b></label
              >
              <input
                class="uk-input uk-border-rounded"
                :min="ad_min_val"
                :max="ad_max_val"
                v-model="min_price"
                type="number"
                placeholder="100"
              />
            </div>
            <div class="uk-width-1-2">
              <label class="uk-form-label" for="form-stacked-text"
                ><b>max</b></label
              >
              <input
                class="uk-input uk-border-rounded"
                :min="ad_min_val"
                :max="ad_max_val"
                v-model="max_price"
                type="number"
                placeholder="100"
              />
            </div>
          </div>
          <hr class="uk-margin-remove" />
          <div class="uk-padding-small">
            <h5 class="uk-margin-remove uk-text-bold" style="color: #87ceeb;">
              Ad type
            </h5>
          </div>
          <div
            class="uk-grid-small uk-child-width-1-1 uk-padding-small uk-padding-remove-top"
            uk-grid
          >
            <div>
              <select v-model="list_as" class="uk-select uk-border-rounded">
                <option selected value="all">All</option>
                <option value="rent">For Rent</option>
                <option value="sale">For Sale</option>
              </select>
            </div>
            <div>
              <button
                :disabled="loading"
                class="uk-button uk-width-1-1 uk-border-rounded"
                style="color:white; background-color: #87ceeb;"
                @click="load_filter_data()"
              >
                Apply Filter
                <span v-show="loading" uk-spinner="ratio:.5;"></span>
              </button>
            </div>
          </div>
        </form>
      </div>
      <!-----nav links for desktop end here----->
    </div>
    <!-----search start here----->
    <div class="uk-width-1-1 uk-width-3-4@m uk-padding-small">
      <div
        class=" uk-visible@m uk-card uk-card-default uk-card-body uk-padding-remove uk-border-rounded uk-margin-bottom"
      >
        <form id="search_form" class="uk-padding-small uk-text-center">
          <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-4@s">
              <div class="uk-form-controls">
                <select
                  class="uk-select uk-border-rounded"
                  id="state"
                  name="state"
                  v-model="state"
                >
                  <option selected value="all">All</option>
                  <option
                    v-for="(st, index) in state_data"
                    :key="index"
                    :value="st.id"
                    >{{ st.name }}</option
                  >
                </select>
              </div>
            </div>
            <div class="uk-width-1-4@s">
              <div class="uk-form-controls">
                <select
                  class="uk-select uk-border-rounded"
                  id="category"
                  name="category"
                  v-model="category"
                >
                  <option selected value="all">All</option>
                  <option
                    v-for="(cat, index) in category_data"
                    :key="index"
                    :value="cat.id"
                    >{{ cat.name }}</option
                  >
                </select>
              </div>
            </div>
            <div class="uk-width-1-4@s">
              <input
                class="uk-input uk-border-rounded"
                type="text"
                name="search_text"
                id="search_text"
                placeholder="Enter Search Term"
                v-model="search_text"
              />
            </div>
            <div class="uk-width-1-4@s">
              <button
                type="buttom"
                :disabled="loading || search_text == ''"
                @click="load_search_data"
                class="uk-button uk-width-1-1 uk-border-rounded"
                style=" background: #87ceeb; color: white"
              >
                <span v-show="!loading" uk-icon="icon:search;ratio:1;"></span>
                <span v-show="loading" uk-spinner="ratio:.5;"></span>
              </button>
            </div>
          </div>
        </form>
      </div>

      <div
        class=" uk-hidden@m uk-card uk-card-default uk-card-body uk-padding-small uk-border-rounded uk-margin-bottom"
      >
        <div class="uk-width-1-1 uk-flex" uk-switcher="toggle: > *">
          <button
            type="button"
            class="uk-button uk-width-1-2"
            style="color:white; background-color: #87ceeb;"
          >
            Filter
            <span uk-icon="icon:settings;ratio:1;"></span>
          </button>
          <button
            type="button"
            class="uk-button uk-width-1-2"
            style=" background: #87ceeb; color: white"
          >
            Search
            <span uk-icon="icon:search;ratio:1;"></span>
          </button>
        </div>
        <ul class="uk-switcher">
          <li>
            <form id="filter_form" method="get" class="">
              <div
                class="uk-grid-small uk-child-width-1-2 uk-padding-remove-top"
                uk-grid
              >
                <div>
                  <label class="uk-form-label">Property Plan</label>
                  <select
                    class="uk-select uk-border-rounded"
                    v-model="property_plan"
                  >
                    <option selected value="all">All Plan</option>
                    <option value="free">Free</option>
                    <option value="vip">Vip</option>
                    <option value="featured">Featured</option>
                    <option value="premium">Premium</option>
                  </select>
                </div>
                <div>
                  <label class="uk-form-label">Property Category</label>
                  <select
                    class="uk-select uk-border-rounded"
                    id="category"
                    name="category"
                    v-model="category"
                  >
                    <option selected value="all">All Category</option>
                    <option
                      v-for="(cat, index) in category_data"
                      :key="index"
                      :value="cat.id"
                      >{{ cat.name }}</option
                    >
                  </select>
                </div>
                <div>
                  <div class="uk-grid-small uk-padding-remove-top" uk-grid>
                    <div class="uk-width-1-2">
                      <label class="uk-form-label">Min Price</label>
                      <input
                        class="uk-input uk-border-rounded"
                        :min="ad_min_val"
                        :max="ad_max_val"
                        v-model="min_price"
                        type="number"
                        placeholder="100"
                      />
                    </div>
                    <div class="uk-width-1-2">
                      <label class="uk-form-label">Max Price</label>
                      <input
                        class="uk-input uk-border-rounded"
                        :min="ad_min_val"
                        :max="ad_max_val"
                        v-model="max_price"
                        type="number"
                        placeholder="100"
                      />
                    </div>
                  </div>
                </div>
                <div>
                  <label class="uk-form-label">Listing</label>
                  <select v-model="list_as" class="uk-select uk-border-rounded">
                    <option selected value="all">All Listing</option>
                    <option value="rent">For Rent</option>
                    <option value="sale">For Sale</option>
                  </select>
                </div>
                <div class="uk-width-1-1 uk-flex-center">
                  <button
                    :disabled="loading"
                    class="uk-button uk-width-1-1 uk-border-rounded"
                    style="color:white; background-color: #87ceeb;"
                    @click="load_filter_data()"
                  >
                    Apply Filter
                    <span v-show="loading" uk-spinner="ratio:.5;"></span>
                  </button>
                </div>
              </div>
            </form>
          </li>
          <li>
            <form id="search_form">
              <div class="uk-grid-small" uk-grid>
                <div class="uk-width-1-2 uk-width-1-2@s">
                  <div class="uk-form-controls">
                    <label class="uk-form-label">Property State</label>
                    <select
                      class="uk-select uk-border-rounded"
                      id="state"
                      name="state"
                      v-model="state"
                    >
                      <option value="all">All</option>
                      <option
                        v-for="(st, index) in state_data"
                        :key="index"
                        :value="st.id"
                        >{{ st.name }}</option
                      >
                    </select>
                  </div>
                </div>
                <div class="uk-width-1-2 uk-width-1-2@s">
                  <div class="uk-form-controls">
                    <label class="uk-form-label">Property Category</label>
                    <select
                      class="uk-select uk-border-rounded"
                      id="category"
                      name="category"
                      v-model="category"
                    >
                      <option value="all">All</option>
                      <option
                        v-for="(cat, index) in category_data"
                        :key="index"
                        :value="cat.id"
                        >{{ cat.name }}</option
                      >
                    </select>
                  </div>
                </div>
                <div class="uk-width-1-1 uk-width-1-2@s">
                  <input
                    class="uk-input uk-border-rounded"
                    type="text"
                    name="search_text"
                    id="search_text"
                    placeholder="Enter Search Term"
                    v-model="search_text"
                  />
                </div>
                <div class="uk-width-1-1 uk-width-1-2@s">
                  <button
                    type="buttom"
                    :disabled="loading || search_text == ''"
                    @click="load_search_data"
                    class="uk-button uk-width-1-1 uk-border-rounded"
                    style=" background: #87ceeb; color: white"
                  >
                    <span
                      v-show="!loading"
                      uk-icon="icon:search;ratio:1;"
                    ></span>
                    <span v-show="loading" uk-spinner="ratio:.5;"></span>
                  </button>
                </div>
              </div>
            </form>
          </li>
        </ul>
      </div>

      <!-----search end here----->
      <div>
        <div class="uk-grid-small" uk-grid>
          <div
            class="uk-child-width-1-3@m uk-child-width-1-2@s uk-child-width-1-1 uk-grid-small"
            uk-grid
          >
            <!------ads listing start here---->
            <div
              class="ads-listing my-margin"
              v-for="property in properties"
              :id="`item_${property.id}`"
              :key="property.id"
            >
              <div class="uk-container uk-padding-remove uk-margin ">
                <div
                  class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-small my-card uk-link-text"
                >
                  <div class="uk-card-media-top ">
                    <a :href="`${base_url}/property/view/${property.slug}`">
                      <img
                        class="home_ad_list_thumb"
                        :src="
                          Object.keys(property.images).length > 0
                            ? `${base_url}/images/properties/${property.id}/${property.images[0]}`
                            : `${base_url}/images/misc/no-image.jpg`
                        "
                        alt=""
                      />
                    </a>

                    <!--featured start here-->
                    <div
                      v-if="property.plan == 'featured'"
                      class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                      style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color: #FFD700; color: white "
                    >
                      <p class="uk-text-small" style="padding:0px 6px">
                        <i
                          uk-icon="icon:star; ratio:1"
                          style="color:white;"
                        ></i>
                        For {{ property.list_as }}
                      </p>
                    </div>
                    <!--featured end here-->

                    <!--distress start here-->
                    <div
                      v-else-if="property.plan == 'vip'"
                      class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                      style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color: red; color: white "
                    >
                      <p class="uk-text-small" style="padding:0px 6px">
                        <i uk-icon="icon:rss; ratio:1" style="color:white;"></i>
                        For {{ property.list_as }}
                      </p>
                    </div>
                    <!--distress end here-->

                    <!--premium start here-->
                    <div
                      v-else-if="property.plan == 'premium'"
                      class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                      style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color: purple; color: white "
                    >
                      <p class="uk-text-small" style="padding:0px 6px">
                        <i
                          uk-icon="icon:star; ratio:1"
                          style="color:white;"
                        ></i>
                        For {{ property.list_as }}
                      </p>
                    </div>
                    <!--premium end here-->

                    <!--free start here-->
                    <div
                      v-else
                      class="uk-overlay uk-card-default  uk-position-top-left uk-position-small uk-padding-left-remove"
                      style="border-radius:50px; height: 25px; padding:5px;  margin: 20px; background-color:black; color: white "
                    >
                      <P class="uk-text-small" style="padding:0px 6px">
                        <i uk-icon="icon:bell; ratio:1" style="color:white;"></i
                        >For {{ property.list_as }}</P
                      >
                    </div>
                    <!--free end here-->

                    <!--like ad start here-->
                    <button
                      class="uk-position-top-right uk-button uk-position-small uk-border-pill"
                      style="color: #FFD700; background:#fff; padding:0px 6px"
                    >
                      <i uk-icon="icon:heart;ratio:1"></i>
                      {{ property.favourites_count }}
                    </button>
                    <!--like ad end here-->
                  </div>
                  <div class="uk-card-body uk-text-center uk-padding-small">
                    <a
                      :href="`${base_url}/property/view/${property.slug}`"
                      class="uk-link-reset"
                    >
                      <h5
                        class="red-text uk-text-small uk-display-block uk-text-truncate"
                      >
                        {{ property.title }}
                      </h5>
                      <h4 class="my-card-title red-text">
                        &#8358;{{ number_format(property.price) }}
                      </h4>
                    </a>

                    <p class="uk-text-small">
                      <i
                        style="color: #87ceeb;"
                        uk-icon="icon:location; ratio:.8"
                      ></i>
                      {{ property.city.name }}, {{ property.state.name }}
                    </p>
                    <div class="uk-text-small" uk-grid>
                      <div class="uk-width-1-2">
                        <a
                          :href="
                            `${base_url}/property_list?category=${property.category.id}`
                          "
                          class="uk-button uk-button-default uk-padding-remove-horizontal uk-border-pill grey darken-3 uk-text-bold white-text uk-text-truncate uk-margin-remove uk-width-1-1 uk-align-center"
                        >
                          {{ property.category.name }}</a
                        >
                      </div>
                      <div class="uk-width-1-2">
                        <img
                          :src="
                            property.user.avatar != null
                              ? `${base_url}/images/users/profile/${property.user.id}/${property.user.avatar}`
                              : `${base_url}/images/misc/default_avatar.png`
                          "
                          class="uk-border-circle agent_logo uk-align-right"
                          alt="property agent image"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div
            v-show="property_pagination_data.record_count > 9"
            class="uk-width-1-1 uk-align-center"
          >
            <div class="uk-card uk-card-default uk-border-rounded" uk-margin>
              <div class="uk-card-body uk-padding-small">
                <paginate
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import jsonToFormData from "json-form-data";
export default {
  data() {
    return {
      loading: false,
      properties: [],
      min_price: 0,
      max_price: 999999999,
      list_as: "all",
      plan: "all",
      payload: null,
      base_url: window.location.origin,
      property_pagination_data: {
        record_count: 0,
        page_count: 0,
        current_page: 1
      },
      property_plan: "all",
      category_data: [],
      search_text: "",
      state: "",
      state_data: [],
      category: "all",
      data_url: ""
    };
  },
  methods: {
    load_state() {
      axios
        .get(`${this.base_url}/api/state/list/`)
        .then(res => {
          this.state_data = res.data;
        })
        .catch(err => {
          // console.log(err);
        });
    },
    load_filter_data() {
      let filter_data = {
        category: this.category,
        plan: this.property_plan,
        list_as: this.list_as,
        min_price: this.min_price,
        max_price: this.max_price
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

      this.payload = new URLSearchParams(
        jsonToFormData(filter_data, filter_form_config)
      ).toString();
      this.data_url = `${this.base_url}/api/property/list?${this.payload}`;
      this.load_data(1);
    },
    load_search_data() {
      let search_data = {
        findable: this.search_text,
        state: this.state,
        category: this.category
      };
      let search_form_config = {
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
      this.payload = new URLSearchParams(
        jsonToFormData(search_data, search_form_config)
      ).toString();
      this.data_url = `${this.base_url}/api/property/list?${this.payload}`;
      this.load_data(1);
    },
    load_data(page = 1) {
      this.loading = !this.loading;
      let url = `${this.data_url}&page=${page}`;
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
      this.load_data(1);
    },
    set_property_status(status) {
      this.property_status = status;
      this.load_data(1);
    },
    number_format(x) {
      return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    },
    load_category_data() {
      let url = `${this.base_url}/api/category/list`;
      axios
        .get(url)
        .then(res => {
          res.data.forEach(cat => {
            this.category_data.push({ id: cat.id, name: cat.name });
          });
        })
        .catch(err => {
          // console.log(err.response);
        });
    },
    load_price_range() {
      (this.min_price = this.ad_min_val), (this.max_price = this.ad_max_val);
    },
    load_init_data() {
      this.data_url = `${this.base_url}/api/property/list?${this.init_query}`;
      this.load_data(1);
    }
  },
  created() {
    this.load_price_range();
    this.load_category_data();
    this.load_state();
    if (this.init_query == null) {
      this.load_filter_data();
    } else {
      this.load_init_data();
    }
  },
  props: {
    ad_min_val: {
      required: false,
      type: Number,
      default: 0
    },
    ad_max_val: {
      required: false,
      type: Number,
      default: 999999999
    },
    init_query: {
      required: false,
      type: String,
      default: null
    }
  }
};
</script>
