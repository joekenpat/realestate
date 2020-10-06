<template>
  <div class="uk-container uk-padding-remove uk-margin">
    <div
      class="uk-card uk-card-default uk-card-body uk-padding-remove uk-margin-small uk-border-rounded"
    >
      <h3 class="uk-padding-small">
        <b style="color: #87ceeb">{{ property_action }} Property</b>
      </h3>
      <hr class="uk-margin-remove" />
      <form
        class="uk-grid-small uk-padding-small"
        method="POST"
        :action="form_action"
        enctype="multipart/form-data"
        @submit.prevent="post_ad"
        autocomplete="off"
        uk-grid
      >
        <div class="uk-width-1-1@s">
          <label class="uk-form-label"><b>Property Title</b></label>
          <input
            class="uk-input"
            :class="{ 'uk-form-danger': error.title != null }"
            type="text"
            id="title"
            name="title"
            v-model="title"
          />
          <span v-show="error.title != null" class="uk-text-danger">{{
            error.title
          }}</span>
        </div>
        <div class="uk-width-1-3@s">
          <div class="uk-margin">
            <label class="uk-form-label"><b>Category</b></label>
            <select
              @change="load_subcategories($event.target.value)"
              class="uk-select"
              :class="{ 'uk-form-danger': error.category != null }"
              id="category_id"
              name="category_id"
              v-model="category_id"
            >
              <option value="">-- Select Category --</option>
              <option
                v-for="cat in categories"
                :key="cat.id"
                :value="cat.value"
              >
                {{ cat.text }}
              </option>
            </select>
            <span v-show="error.category_id != null" class="uk-text-danger">{{
              error.category_id
            }}</span>
          </div>
        </div>
        <div class="uk-width-1-3@s">
          <div class="uk-margin">
            <label class="uk-form-label"><b>Subcategory</b></label>
            <select
              class="uk-select"
              :class="{ 'uk-form-danger': error.subcategory != null }"
              name="subcategory_id"
              id="subcategory_id"
              v-model="subcategory_id"
              :disabled="Object.keys(subcategories).length === 0"
            >
              <option value="" v-if="Object.keys(subcategories).length === 0"
                >-- Select Category First--</option
              >
              <option value="" v-else>-- Select Subcategory --</option>
              <option
                v-for="subcat in subcategories"
                :key="subcat.id"
                :value="subcat.value"
                >{{ subcat.text }}</option
              >
            </select>
            <span
              v-show="error.subcategory_id != null"
              class="uk-text-danger"
              >{{ error.subcategory_id }}</span
            >
          </div>
        </div>
        <div class="uk-width-1-3@s">
          <label class="uk-form-label"><b>Phone Number</b></label>
          <input
            class="uk-input"
            type="number"
            placeholder="Number"
            id="phone"
            name="phone"
            v-model="phone"
            :class="{ 'uk-form-danger': error.phone != null }"
          />
          <span v-show="error.phone != null" class="uk-text-danger">{{
            error.phone
          }}</span>
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label"><b>Description</b></label>
          <quill-editor
            v-model="description"
            rows="3"
            placeholder="Property Description"
            id="description"
            ref="description"
            name="description"
            :class="{ 'uk-form-danger': error.description != null }"
            :options="editorOption"
          >
          </quill-editor>
          <span v-show="error.description != null" class="uk-text-danger">{{
            error.description
          }}</span>
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label"><b>Address</b></label>
          <quill-editor
            v-model="address"
            rows="3"
            placeholder="Property Address"
            id="address"
            ref="address"
            name="address"
            :class="{ 'uk-form-danger': error.address != null }"
            :options="editorOption"
          >
          </quill-editor>
          <span v-show="error.address != null" class="uk-text-danger">{{
            error.address
          }}</span>
        </div>
        <div class="uk-width-1-3@s">
          <div class="uk-margin">
            <label class="uk-form-label"><b>State</b></label>
            <select
              class="uk-select uk-border-rounded"
              id="state"
              name="state"
              v-model="state"
              @change="load_city(state.code)"
            >
              <option value="">-- Select State --</option>
              <option
                v-for="(st, index) in state_data"
                :key="index"
                :value="st"
                >{{ st.name }}</option
              >
            </select>
            <span v-show="error.state_id != null" class="uk-text-danger">{{
              error.state_id
            }}</span>
          </div>
        </div>
        <div class="uk-width-1-3@s">
          <div class="uk-margin">
            <label class="uk-form-label"><b>LGA</b></label>
            <select
              class="uk-select uk-border-rounded"
              id="city"
              name="city"
              v-model="city"
              :disabled="state.code ==''"
            >
              <option value="">-- Select City --</option>
              <option
                v-for="(ct, index) in city_data"
                :key="index"
                :value="ct"
                >{{ ct.name }}</option
              >
            </select>
            <span v-show="error.city_id != null" class="uk-text-danger">{{
              error.city_id
            }}</span>
          </div>
        </div>
        <div class="uk-width-1-3@s">
          <label class="uk-form-label"><b>Property Price</b></label>
          <input
            class="uk-input"
            :class="{ 'uk-form-danger': error.price != null }"
            type="number"
            id="price"
            name="price"
            v-model="price"
          />
          <span v-show="error.price != null" class="uk-text-danger">{{
            error.price
          }}</span>
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label"><b>Property Plan</b></label>
          <div class="uk-form-controls">
            <label
              ><input
                class="uk-radio"
                type="radio"
                name="plan"
                value="free"
                v-model="plan"
                checked
              />
              Free &#8358;0</label
            ><br />

            <label
              ><input
                class="uk-radio"
                type="radio"
                name="plan"
                v-model="plan"
                value="vip"
              />
              VIP &#8358;{{ plan_fee.vip }}</label
            ><br />
            <label
              ><input
                class="uk-radio"
                type="radio"
                name="plan"
                value="featured"
                v-model="plan"
              />
              Featured &#8358;{{ plan_fee.featured }}</label
            ><br />
            <label
              ><input
                class="uk-radio"
                type="radio"
                name="plan"
                v-model="plan"
                value="premium"
              />
              Premium &#8358;{{ plan_fee.premium }}</label
            ><br />
            <span v-show="error.plan != null" class="uk-text-danger">{{
              error.plan
            }}</span>
          </div>
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label"><b>Type Of Ad</b></label>
          <div class="uk-form-controls">
            <label
              ><input
                class="uk-radio"
                type="radio"
                name="list_as"
                value="sale"
                v-model="list_as"
                id="sell"
                checked
              />
              For Sale</label
            ><br />
            <label
              ><input
                class="uk-radio"
                type="radio"
                name="list_as"
                value="rent"
                v-model="list_as"
                id="rent"
              />
              For Rent</label
            ><br />
            <span v-show="error.list_as != null" class="uk-text-danger">{{
              error.list_as
            }}</span>
          </div>
        </div>
        <div class="uk-width-1-2@s">
          <div class="row" uk-grid>
            <div class="uk-width-1-1">
              <div
                class="uk-child-width-expand uk-grid-column-small uk-grid-row-small uk-flex uk-flex-bottom"
                uk-grid
                v-show="Object.keys(specifications).length > 0"
              >
                <div class="uk-width-1-2">
                  <label class="uk-form-label"><b>Specification Name</b></label>
                </div>
                <div class="uk-width-1-2">
                  <label class="uk-form-label"
                    ><b>Specification value</b></label
                  >
                </div>
              </div>
              <div
                class="uk-child-width-expand uk-grid-column-collapse uk-grid-row-collapse uk-flex uk-flex-bottom"
                uk-grid
                v-for="(specification, k) in specifications"
                :key="k"
              >
                <div class="">
                  <input
                    class="uk-input"
                    type="text"
                    placeholder="Spec Name"
                    v-model="specifications[k].name"
                  />
                </div>
                <div class="">
                  <input
                    class="uk-input"
                    type="text"
                    placeholder="Spec Value"
                    v-model="specifications[k].value"
                  />
                </div>
                <div class="uk-width-1-6">
                  <button
                    type="button"
                    @click="remove_specification(k)"
                    class="uk-button-small"
                    style="height:40px;"
                  >
                    x
                  </button>
                </div>
              </div>
            </div>
            <div class="uk-margin-small-top uk-align-center">
              <button
                type="button"
                :disabled="Object.keys(this.specifications).length >= 10"
                @click="add_specification()"
                class="uk-button uk-button-default uk-width-1-1 uk-margin-small-top"
              >
                + Specification
              </button>
            </div>
            <span
              v-show="error.specifications != null"
              class="uk-text-danger"
              >{{ error.specifications }}</span
            >
          </div>
        </div>
        <div class="uk-width-1-2@s">
          <div class="row" uk-grid>
            <div class="uk-width-1-1">
              <div
                class="uk-child-width-expand uk-grid-column-small uk-grid-row-small uk-flex uk-flex-bottom"
                uk-grid
                v-show="Object.keys(amenities).length > 0"
              >
                <div class="uk-width-1-2">
                  <label class="uk-form-label"><b>Amenity Name</b></label>
                </div>
                <div class="uk-width-1-2">
                  <label class="uk-form-label"><b>Amenity value</b></label>
                </div>
              </div>
              <div
                class="uk-child-width-expand uk-grid-column-collapse uk-grid-row-collapse uk-flex uk-flex-bottom"
                uk-grid
                v-for="(amenity, k) in amenities"
                :key="k"
              >
                <div class="">
                  <input
                    class="uk-input"
                    type="text"
                    placeholder="Amenity Name"
                    v-model="amenities[k].name"
                  />
                </div>
                <div class="">
                  <input
                    class="uk-input"
                    type="text"
                    placeholder="Amenity Value"
                    v-model="amenities[k].value"
                  />
                </div>
                <div class="uk-width-1-6">
                  <button
                    type="button"
                    @click="remove_amenity(k)"
                    class="uk-button-small"
                    style="height:40px;"
                  >
                    x
                  </button>
                </div>
              </div>
            </div>
            <div class="uk-align-center uk-margin-small-top">
              <button
                type="button"
                :disabled="Object.keys(this.amenities).length >= 10"
                @click="add_amenity()"
                class="uk-button uk-button-default uk-width-1-1 uk-margin-small-top"
              >
                + Amenity
              </button>
            </div>
            <span v-show="error.amenities != null" class="uk-text-danger">{{
              error.amenities
            }}</span>
          </div>
        </div>
        <div class="uk-width-1-1@s">
          <div class="row" uk-grid>
            <div class="uk-width-1-1">
              <div
                class="uk-child-width-expand uk-grid-column-small uk-grid-row-small uk-flex uk-flex-bottom"
                uk-grid
                v-show="Object.keys(tags).length > 0"
              >
                <div class="uk-width-1-1">
                  <label class="uk-form-label"><b>Tags</b></label>
                </div>
              </div>
              <div
                class="uk-child-width-1-6 uk-grid-column-collapse uk-grid-row-collapse"
                uk-grid
              >
                <div class="uk-inline" v-for="(tag, k) in tags" :key="k">
                  <button
                    type="button"
                    class="uk-form-icon uk-form-icon-flip"
                    @click="remove_tag(k)"
                    uk-icon="icon: close"
                  ></button
                  ><input
                    class="uk-input"
                    type="text"
                    placeholder="Tag"
                    v-model="tags[k]"
                  />
                </div>
              </div>
            </div>
            <div class="uk-margin-small-top uk-align-center">
              <button
                type="button"
                :disabled="Object.keys(this.tags).length >= 6"
                @click="add_tag()"
                class="uk-button uk-button-default uk-width-1-1 uk-margin-small-top"
              >
                + Tag
              </button>
            </div>
          </div>
          <span v-show="error.tags != null" class="uk-text-danger">{{
            error.tags
          }}</span>
        </div>
        <div v-if="Object.keys(old_images).length > 0" class="uk-width-1-1@s">
          <label class="uk-form-label"><b>Old Images</b></label>
          <ul class="uk-thumbnav" uk-margin>
            <li class="uk-active" v-for="(image, k) in old_images" :key="k">
              <img
                :src="`${base_url}/images/properties/${init_data.id}/${image}`"
                width="150"
                class=" uk-display-block"
                style="object-fit:cover;"
                :alt="'old_property_image_' + parseInt(k)"
              /><button
                :disabled="loading"
                @click="delete_old_image(image)"
                class="uk-button uk-button-small uk-button-danger uk-width-1-1"
              >
                Remove <span v-show="loading" uk-spinner="ratio:.5;"></span>
              </button>
            </li>
          </ul>
        </div>
        <div class="uk-width-1-1@s">
          <label class="uk-form-label"><b>Upload Image</b></label>
          <input
            name="sel_images"
            ref="sel_images"
            id="sel_images"
            accept=".jpg, .png, .jpeg"
            type="file"
            multiple
            hidden
            @change="handleImagesUpload"
          />
          <div
            class="uk-grid-small uk-child-width-1-3 uk-child-width-1-5@s uk-text-center"
            uk-grid
          >
            <div v-for="(image, k) in images" :key="k">
              <div class="uk-inline uk-card uk-card-default">
                <img
                  :ref="'image' + parseInt(k)"
                  style="max-height:120px;object-fit:cover;"
                  :alt="'property_image_' + parseInt(k)"
                  class="uk-width-1-1"
                />
                <div
                  class="uk-overlay uk-overlay-primary uk-position-top-right uk-border-circle"
                  style="padding:.1em .5em;background:#f00;margin-top:-10px;margin-right:-10px;color:#fff;cursor:pointer"
                  @click="remove_image(k)"
                >
                  x
                </div>
              </div>
            </div>
            <div>
              <div
                class="uk-background-secondary uk-padding uk-light"
                @click="addImages"
                uk-icon="icon: plus; ratio: 2;"
              ></div>
            </div>
          </div>
          <span v-show="error.images != null" class="uk-text-danger">{{
            error.images
          }}</span>
        </div>
        <div class="uk-width-2-3@s uk-align-center">
          <div class="uk-margin-small-top">
            <button
              :disabled="loading"
              type="submit"
              class="uk-button uk-button-default uk-width-1-1 uk-margin-small-top"
            >
              {{ property_action }}
              <span v-show="loading" uk-spinner="ratio:.5;"></span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import jsonToFormData from "json-form-data";
import Quill from "quill";
import { quillEditor } from "vue-quill-editor";
// Quill.register('modules/toolbar', toolbar)
export default {
  data() {
    return {
      tags: [],
      title: "",
      images: [],
      old_images: [],
      list_as: "sale",
      phone: "",
      price: 0,
      toolbarConfig: [
        ["bold", "italic", "strike"],
        [{ header: [2, 3, false] }],
        [{ list: "ordered" }, { list: "bullet" }]
      ],
      description: "",
      address: "",
      editorOption: {
        modules: {
          toolbar: this.toolbarConfig
        },
        theme: "snow"
      },
      plan: "free",
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
      base_url: window.location.origin,
      categories: [],
      subcategories: [],
      specifications: [],
      amenities: [],
      category_id: null,
      subcategory_id: null,
      searchText: "",
      state_id: "",
      city_id: "",
      loading: false,
      city: { id: null, name: "" },
      state: { id: null, name: "", code: "" },
      state_data: [],
      city_data: [],
      error: {
        title: null,
        category_id: null,
        subcategory_id: null,
        phone: null,
        address: null,
        description: null,
        list_as: null,
        plan: null,
        state_id: null,
        city_id: null
      }
    };
  },
  methods: {
    reset_fields() {
      (this.tags = []),
        (this.title = ""),
        (this.images = []),
        (this.old_images = []),
        (this.list_as = ""),
        (this.phone = ""),
        (this.description = ""),
        (this.address = ""),
        (this.plan = ""),
        (this.price = 0),
        (this.categories = []),
        (this.subcategories = []),
        (this.specifications = []),
        (this.amenities = []),
        (this.category_id = null),
        (this.subcategory_id = null),
        (this.searchText = ""),
        (this.state_id = ""),
        (this.city_id = ""),
        (this.loading = false),
        (this.city = { id: null, name: "" }),
        (this.state = { id: null, name: "", code: "" }),
        (this.state_data = []),
        (this.city_data = []),
        (this.error = {
          title: null,
          category_id: null,
          subcategory_id: null,
          phone: null,
          address: null,
          description: null,
          list_as: null,
          plan: null,
          state_id: null,
          city_id: null,
          price: null
        });
    },
    delete_old_image(x) {
      this.loading = true;
      axios
        .get(
          `${this.base_url}/user/property/${this.init_data.id}/delete/image/${x}`
        )
        .then(res => {
          this.Toast.fire({
            icon: "success",
            title: res.data
          });
          this.loading = false;
        })
        .catch(err => {
          const { status } = err.response;
          if (status === 401) {
            console.log(err.response.data);
            this.Toast.fire({
              icon: "error",
              title: "Unauthorized!"
            });
          } else if (status === 422) {
            this.Toast.fire({
              icon: "error",
              title: err.response.data.statusText
            });
            console.log(err.response.data);
          } else {
            console.log(err.response);
          }
          this.loading = false;
        });
    },
    load_init_data() {
      if (this.init_data !== null) {
        this.init_data.tags.forEach(tag => {
          this.tags.push(tag.name);
        });
        (this.title = this.init_data.title),
          (this.old_images = this.init_data.images),
          (this.list_as = this.init_data.list_as),
          (this.phone = this.init_data.phone),
          (this.description = this.init_data.description),
          (this.address = this.init_data.address),
          (this.plan = this.init_data.plan),
          (this.specifications = this.init_data.specifications),
          (this.amenities = this.init_data.amenities),
          (this.category_id = this.init_data.category_id),
          (this.subcategory_id = this.init_data.subcategory_id),
          (this.price = this.init_data.price),
          (this.city = {
            id: this.init_data.city ? this.init_data.city.id : null,
            name: this.init_data.city ? this.init_data.city.name : ""
          }),
          (this.state = {
            id: this.init_data.state ? this.init_data.state.id : null,
            name: this.init_data.state ? this.init_data.state.name : null,
            code: this.init_data.state ? this.init_data.state.code : ""
          });
      }
    },
    getImagePreviews() {
      for (let i = 0; i < this.images.length; i++) {
        if (/\.(jpeg|png|gif|jpg)$/i.test(this.images[i].name)) {
          let reader = new FileReader();
          reader.addEventListener(
            "load",
            function() {
              this.$refs["image" + parseInt(i)][0].src = reader.result;
            }.bind(this),
            false
          );
          reader.readAsDataURL(this.images[i]);
        }
      }
    },
    handleImagesUpload() {
      let selectedImages = this.$refs.sel_images.files;
      for (var i = 0; i < selectedImages.length; i++) {
        this.images.push(selectedImages[i]);
      }
      selectedImages.value = "";
      this.getImagePreviews();
    },
    remove_image(im_pos) {
      this.images.splice(im_pos, 1);
    },
     load_state() {
      axios
        .get(`${window.location.origin}/api/state/list`)
        .then(res => {
          this.state_data = res.data;
        })
        .catch(err => {
          // console.log(err);
        });
    },
    load_city(state_code) {
      if (state_code !== (null || "")) {
        axios
          .get(`${window.location.origin}/api/city/list_for/${state_code}`)
          .then(res => {
            this.city_data = res.data;
          })
          .catch(err => {
            console.log(err);
          });
      }
    },
    addImages() {
      this.$refs.sel_images.click();
    },
    load_categories() {
      this.categories = [];
      this.categories_data.forEach(category_data => {
        this.categories.push({
          text: category_data.name,
          value: category_data.id
        });
      });
    },
    load_subcategories(cat_id) {
      console.log("sel_cat: " + cat_id);
      this.subcategories = [];
      this.categories_data.forEach(category_data => {
        if (category_data.id == cat_id) {
          category_data.subcategories.forEach(subcategory_data => {
            this.subcategories.push({
              text: subcategory_data.name,
              value: subcategory_data.id
            });
          });
        }
      });
    },
    add_amenity() {
      if (Object.keys(this.amenities).length < 10) {
        this.amenities.push({
          name: "",
          value: ""
        });
      }
    },
    remove_amenity(am_pos) {
      if (Object.keys(this.amenities).length >= 1) {
        this.amenities.splice(am_pos, 1);
      }
    },
    add_specification() {
      if (Object.keys(this.specifications).length < 10) {
        this.specifications.push({
          name: "",
          value: ""
        });
      }
    },
    remove_specification(sp_pos) {
      if (Object.keys(this.specifications).length >= 1) {
        this.specifications.splice(sp_pos, 1);
      }
    },
    add_tag() {
      if (Object.keys(this.tags).length < 6) {
        this.tags.push("");
      }
    },
    remove_tag(tg_pos) {
      if (Object.keys(this.tags).length >= 1) {
        this.tags.splice(tg_pos, 1);
      }
    },
    post_ad() {
      this.loading = true;
      let ad_form_data = {
        title: this.title,
        category_id: this.category_id,
        subcategory_id: this.subcategory_id,
        phone: this.phone,
        address: this.address,
        description: this.description,
        list_as: this.list_as,
        plan: this.plan,
        state_id: this.state.id,
        city_id: this.city.id,
        specifications: this.specifications,
        amenities: this.amenities,
        tags: this.tags,
        images: this.images,
        price: this.price
      };
      let form_config = {
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
      let main_form_data = jsonToFormData(ad_form_data, form_config);

      let config = {
        header: {
          "Content-Type": "multipart/form-data"
        }
      };
      axios
        .post(this.form_action, main_form_data, config)
        .then(res => {
          this.reset_fields();
          if (res.data.url) {
            this.Toast.fire({
              icon: "success",
              title: "Property Uploaded, Redirecting to Payment Gateway"
            });
            this.loading = false;
            window.location = res.data.url;
          } else {
            this.Toast.fire({
              icon: "success",
              title: res.data
            });
            this.loading = false;
            window.location = `${this.base_url}/user/property`
          }
        })
        .catch(err => {
          console.log(err);
          const { status } = err.response;
          if (status === 401) {
            // console.log(err.response.data);
            this.Toast.fire({
              icon: "error",
              title: "Unauthorized! Reload Page"
            });
          } else if (status === 422) {
            this.error.title = err.response.data.errors.title
              ? err.response.data.errors.title[0]
              : null;
            this.error.category_id = err.response.data.errors.category_id
              ? err.response.data.errors.category_id[0]
              : null;
            this.error.subcategory_id = err.response.data.errors.subcategory_id
              ? err.response.data.errors.subcategory_id[0]
              : null;
            this.error.state_id = err.response.data.errors.state_id
              ? err.response.data.errors.state_id[0]
              : null;
            this.error.city_id = err.response.data.errors.city_id
              ? err.response.data.errors.city_id[0]
              : null;
            this.error.city_id = err.response.data.errors.list
              ? err.response.data.errors.list_as[0]
              : null;
            this.error.phone = err.response.data.errors.phone
              ? err.response.data.errors.phone[0]
              : null;
            this.error.price = err.response.data.errors.price
              ? err.response.data.errors.price[0]
              : null;
            this.error.plan = err.response.data.errors.plan
              ? err.response.data.errors.plan[0]
              : null;
            this.error.description = err.response.data.errors.description
              ? err.response.data.errors.description[0]
              : null;
            this.error.address = err.response.data.errors.address
              ? err.response.data.errors.address[0]
              : null;
            this.error.amenities = err.response.data.errors.amenities
              ? err.response.data.errors.amenities[0]
              : null;
            this.error.specifications = err.response.data.errors.specifications
              ? err.response.data.errors.specifications[0]
              : null;
            this.error.images = err.response.data.errors.images
              ? err.response.data.errors.images[0]
              : null;
            this.error.tags = err.response.data.errors.tags
              ? err.response.data.errors.tags[0]
              : null;

            this.Toast.fire({
              icon: "error",
              title: "Check in some of those fields"
            });
            // console.log(err.response.data);
          } else {
            // console.log(err.response);
          }
          this.loading = false;
        });
    }
  },
  props: {
    categories_data: {
      required: true,
      type: Array
    },
    form_action: {
      required: true,
      type: String
    },
    init_data: {
      required: false,
      type: Object,
      default: null
    },
    plan_fee: {
      required: true,
      type: Object
    },
    property_action: {
      required: true,
      type: String,
      default: "Post"
    }
  },
  created() {
    this.load_categories();
    this.load_init_data();
    this.load_state();
  },
  components: {
    quillEditor
  },
  mounted() {}
};
</script>
