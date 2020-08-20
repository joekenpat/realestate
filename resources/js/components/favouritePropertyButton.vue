<template>
  <button
    @click="init_action"
    class="uk-button uk-button-small uk-border-rounded"
    type="button"
  >
    <span v-show="loading" uk-spinner="ratio:.5;"></span
    ><span
      class=" uk-margin-small-right"
      v-show="!loading"
      :uk-icon="`icon:${fav_icon}`"
    ></span
    >{{ btn_text }}
  </button>
</template>
<script>
export default {
  data() {
    return {
      loading: false,
      favourite_status: false,
      fav_icon: "plus-circle",
      btn_text: "",
      base_url: window.location.origin
    };
  },
  methods: {
    add_favourite_property() {
      this.loading = true;
      if (this.user_id == null) {
        window.location.href(`${this.base_url}/login`);
      }
      let pid = this.property_id;
      axios
        .get(`${this.base_url}/api/user/property/favourite/add/${pid}`)
        .then(response => {
          this.favourite_status = true;
          this.set_fav_icon();
          this.set_btn_text();
          this.loading = false;
        })
        .catch(error => {
          // console.log(error.response);
          this.loading = false;
        });
    },
    remove_favourite_property(property_id) {
      this.loading = true;
      if (this.user_id == null) {
        window.location.href(`${this.base_url}/login`);
      }
      let pid = this.property_id;
      axios
        .get(`${this.base_url}/api/user/property/favourite/remove/${pid}`)
        .then(response => {
          this.favourite_status = false;
          this.set_fav_icon();
          this.set_btn_text();
          this.loading = false;
        })
        .catch(error => {
          // console.log(error.response);
          this.loading = false;
        });
    },
    set_fav_icon() {
      if (this.favourite_status == true) {
        this.fav_icon = "minus-circle";
      } else {
        this.fav_icon = "plus-circle";
      }
    },
    set_btn_text() {
      if (this.favourite_status == true) {
        this.btn_text = "Unlike";
      } else {
        this.btn_text = "Like";
      }
    },
    init_action() {
      if (this.favourite_status == true) {
        this.remove_favourite_property();
      } else {
        this.add_favourite_property();
      }
    }
  },
  props: {
    property_id: {
      required: true,
      type: String
    },
    user_id: {
      required: true,
      type: String
    },
    fav_status: {
      required: true,
      type: Number
    }
  },
  created() {
    this.set_btn_text();
    this.favourite_status = this.fav_status==1?true:false;
  }
};
</script>
