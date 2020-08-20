<template>
  <div>
    <div class="uk-text-center">
      <img
        v-if="user != null"
        :src="
          user.avatar != null
            ? `${base_url}/images/users/profile/${user.id}/${user.avatar}`
            : `${base_url}/images/misc/default_avatar.png`
        "
        class="uk-border-circle uk-margin-top profile_image"
        alt="Your Profile
      image"
      />
    </div>
    <table class="uk-table uk-table-divider uk-table-small">
      <tbody>
        <tr>
          <td class=" uk-text-bold">Name:</td>
          <td>
            {{ user != null ? user.last_name : null }}
            {{ user != null ? user.first_name : null }}
          </td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Email:</td>
          <td>{{ user != null ? user.email : null }}</td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Phone:</td>
          <td>{{ user != null ? user.phone : null }}</td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Role:</td>
          <td><span class="uk-label">{{ user != null ? user.role : null }}</span></td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Location:</td>
          <td>
            {{ user.state != null ? user.state.name : null }},
            {{ user.city != null ? user.city.name : null }}
          </td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Address:</td>
          <td>{{ user != null ? user.address : null }}</td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Bio:</td>
          <td>{{ user != null ? user.bio : null }}</td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Joined:</td>
          <td>{{ moment(user != null ? user.created_at : null).fromNow() }}</td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Last Login:</td>
          <td>{{ moment(user != null ? user.last_login : null).fromNow() }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      user: null,
      base_url: window.location.origin,
      data_url: ""
    };
  },
  methods: {
    load_data(user_data) {
      this.user = user_data;
    }
  },
  props: {
    user_data: {
      required: false,
      type: Object,
      default: null
    }
  }
};
</script>
<style>
.profile_image {
  width: 200px;
  height: 200px;
  object-fit: cover;
}
</style>
