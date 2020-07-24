<template>
  <form
    method="POST"
    @submit.prevent="submit_form"
    id="login_form"
    :action="form_action"
    class="uk-form-stacked"
  >
    <div class="uk-margin">
      <label for="email" class="uk-form-label">
        E-Mail Address
      </label>
      <div class="uk-form-control">
        <input
          class="uk-input"
          :class="{ 'uk-form-danger': error.email != null }"
          name="email"
          id="email"
          type="email"
          required
          autocomplete="email"
          autofocus
        />
        <span v-show="error.email != null" class="uk-text-danger">{{
          error.email
        }}</span>
      </div>
    </div>
    <div class="uk-margin">
      <label for="password" class="uk-form-label">
        Password
      </label>
      <div class="uk-form-control">
        <input
          id="password"
          type="password"
          :class="'uk-input'"
          name="password"
          required
          autocomplete="current-password"
        />
        <span v-show="error.password != null" class="uk-text-danger">{{
          error.password
        }}</span>
      </div>
    </div>
    <div class="uk-margin">
      <div class="uk-form-control">
        <input
          class="uk-checkbox"
          type="checkbox"
          name="remember"
          id="remember"
        />
        <label for="remember">
          Remember Me"
        </label>
      </div>
    </div>
    <div class="uk-margin">
      <div class="uk-form-control">
        <button
          :disabled="loading"
          type="submit"
          class="uk-button uk-button-primary"
        >
          Log In
          <span v-show="loading" uk-spinner="ratio:.5;"></span>
        </button>

        <a
          v-if="password_request_route != null"
          class="uk-button uk-button-link uk-margin-left"
          :href="password_request_route"
        >
          Forgot Your Password?
        </a>
      </div>
    </div>
  </form>
</template>
<script>
export default {
  data() {
    return {
      error: {
        email: null,
        password: null
      },
      loading: false
    };
  },
  methods: {
    submit_form() {
      this.loading = true;
      var login_form = document.getElementById("login_form");
      var login_form_data = new FormData(login_form);
      axios
        .post(this.form_action, login_form_data)
        .then(res => {
          console.log(res);
          this.loading = false
        })
        .catch(err => {
          const { status } = err.response;
          if (status === 401) {
            this.error.email = err.response.data.error;
            console.log(err.response.data);
            this.loading = false;
          }else if (status === 422) {
            this.error.email = err.response.data.errors.email[0];
            console.log(err.response.data);
            this.loading = false;
          }
        });
    }
  },
  props: {
    form_action: {
      required: true,
      type: String
    },
    password_request_route: {
      required: true,
      type: String
    }
  }
};
</script>
