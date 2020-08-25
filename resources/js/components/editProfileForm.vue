<template>
  <div class="uk-card uk-card-default uk-margin-small uk-border-rounded">
    <h5 class="uk-padding-small"><b style="color: #87ceeb">Edit Profile</b></h5>
    <hr />
    <form
      :action="form_action"
      method="POST"
      enctype="multipart/form-data"
      @submit.prevent="update_profile"
      class="uk-card-body uk-padding-remove-vertical"
    >
      <div class="uk-grid-small uk-margin-bottom" uk-grid>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label">First Name</label>
          <input
            class="uk-input uk-border-rounded"
            type="text"
            placeholder="First Name"
            id="first_name"
            name="first_name"
            v-model="first_name"
            :class="{ 'uk-form-danger': error.first_name != null }"
            autofocus
          />
          <span v-show="error.first_name != null" class="uk-text-danger">{{
            error.first_name
          }}</span>
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label">Last Name</label>
          <input
            class="uk-input uk-border-rounded"
            type="text"
            placeholder="Last name"
            id="last name"
            name="last name"
            :class="{ 'uk-form-danger': error.last_name != null }"
            v-model="last_name"
          />
          <span v-show="error.last_name != null" class="uk-text-danger">{{
            error.last_name
          }}</span>
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label">Phone Number</label>
          <input
            class="uk-input uk-border-rounded"
            type="number"
            placeholder="Number"
            id="phone"
            name="phone"
            :class="{ 'uk-form-danger': error.phone != null }"
            v-model="phone"
          />
          <span v-show="error.phone != null" class="uk-text-danger">{{
            error.phone
          }}</span>
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label">Username</label>
          <input
            class="uk-input uk-border-rounded"
            type="text"
            placeholder="Username"
            id="username"
            name="username"
            :class="{ 'uk-form-danger': error.username != null }"
            v-model="username"
          />
          <span v-show="error.username != null" class="uk-text-danger">{{
            error.username
          }}</span>
        </div>
        <div class="uk-width-1-2@s">
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
        <div class="uk-width-1-2@s">
          <div class="uk-margin">
            <label class="uk-form-label"><b>City</b></label>
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
        <div class="uk-width-1-2@s">
          <label class="uk-form-label"><b>Address</b></label>
          <textarea
            class="uk-textarea uk-border-rounded"
            rows="5"
            placeholder="Address"
            id="address"
            name="address"
            :class="{ 'uk-form-danger': error.address != null }"
            v-model="address"
          ></textarea>
          <span v-show="error.address != null" class="uk-text-danger">{{
            error.address
          }}</span>
        </div>
        <div class="uk-width-1-2@s">
          <label class="uk-form-label"><b>About Me</b></label>
          <textarea
            class="uk-textarea uk-border-rounded"
            rows="5"
            placeholder="Tell about your self"
            id="bio"
            name="bio"
            v-model="bio"
            :class="{ 'uk-form-danger': error.bio != null }"
          ></textarea>
          <span v-show="error.bio != null" class="uk-text-danger">{{
            error.bio
          }}</span>
        </div>
        <div class="uk-width-1-2">
          <div class="uk-width-1-1" uk-form-custom="target: true">
            <input
              type="file"
              accept=".jpeg,.gif,.jpg,.png"
              id="avatar"
              name="avatar"
              @change="update_avatar_value($event)"
            />
            <input
              onkeydown="return event.key != 'Enter';"
              class="uk-input uk-width-1-1 uk-border-rounded"
              type="text"
              placeholder="Select Media image"
              accept=".jpeg,.gif,.jpg,.png"
              disabled
              :class="{ 'uk-form-danger': error.avatar != null }"
            />
          </div>
          <span v-show="error.avatar != null" class="uk-text-danger">{{
            error.avatar
          }}</span>
        </div>
        <div class="uk-width-1-2@s">
          <button
            :disabled="loading"
            type="submit"
            class="uk-button uk-button-default uk-width-1-1 uk-border-rounded"
            style="background-color: #87ceeb; color:white;  text-transform: capitalize;"
          >
            Update profile <span v-show="loading" uk-spinner="ratio:.5;"></span>
          </button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import { ModelListSelect } from "vue-search-select";
import jsonToFormData from "json-form-data";
export default {
  data() {
    return {
      first_name: "",
      last_name: "",
      email: "",
      phone: "",
      address: "",
      username: "",
      bio: 0,
      phone: "",
      searchText: "",
      avatar: null,
      loading: false,
      city: { id: null, name: "" },
      state: { id: null, name: "", code: "" },
      state_data: [],
      city_data: [],
      error: {
        first_name: null,
        last_name: null,
        email: null,
        phone: null,
        address: null,
        bio: null,
        list_as: null,
        plan: null,
        state_id: null,
        city_id: null,
        avatar: null
      }
    };
  },
  methods: {
    load_init_data() {
      if (this.init_data !== null) {
        (this.first_name = this.init_data.first_name),
          (this.last_name = this.init_data.last_name),
          (this.phone = this.init_data.phone),
          (this.bio = this.init_data.bio),
          (this.address = this.init_data.address),
          (this.username = this.init_data.username),
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
    update_avatar_value(event) {
      this.avatar = event.target.files[0];
    },
    update_profile() {
      this.loading = !this.loading;
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
      let ad_form_data = {
        first_name: this.first_name,
        last_name: this.last_name,
        email: this.email,
        phone: this.phone,
        address: this.address,
        bio: this.bio,
        state_id: this.state.id,
        city_id: this.city.id,
        avatar: this.avatar,
        username: this.username
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
          Toast.fire({
            icon: "success",
            title: res.data
          });
          this.loading = !this.loading;
          window.location.reload();
        })
        .catch(err => {
          const { status } = err.response;
          if (status === 401) {
            Toast.fire({
              icon: "error",
              title: "Unauthorized!"
            });
          } else if (status === 422) {
            Toast;
            this.error.last_name = err.response.data.errors.last_name
              ? err.response.data.errors.last_name[0]
              : null;
            this.error.first_name = err.response.data.errors.first_name
              ? err.response.data.errors.first_name[0]
              : null;
            this.error.state_id = err.response.data.errors.state_id
              ? err.response.data.errors.state_id[0]
              : null;
            this.error.city_id = err.response.data.errors.city_id
              ? err.response.data.errors.city_id[0]
              : null;
            this.error.phone = err.response.data.errors.phone
              ? err.response.data.errors.phone[0]
              : null;
            this.error.address = err.response.data.errors.address
              ? err.response.data.errors.address[0]
              : null;
            this.error.bio = err.response.data.errors.bio
              ? err.response.data.errors.bio[0]
              : null;
            this.error.username = err.response.data.errors.username
              ? err.response.data.errors.username[0]
              : null;
            this.error.avatar = err.response.data.errors.avatar
              ? err.response.data.errors.avatar[0]
              : null;
            Toast.fire({
              icon: "error",
              title: "Check in some of those fields"
            });
          }
          this.loading = !this.loading;
        });
    }
  },
  props: {
    form_action: {
      required: true,
      type: String
    },
    init_data: {
      required: true,
      type: Object
    }
  },
  created() {
    this.load_init_data();
    this.load_state();
  },
  components: {
    ModelListSelect
  }
};
</script>
