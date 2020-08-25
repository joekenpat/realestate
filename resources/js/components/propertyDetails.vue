<template>
  <div>
    <div class="uk-text-center">
      <div
        class="uk-position-relative uk-visible-toggle uk-light"
        tabindex="-1"
        uk-slideshow
        v-if="property != null && Object.keys(property.images).length > 0"
      >
        <ul class="uk-slideshow-items">
          <li v-for="(image_url, index) in property.images" :key="index">
            <img
              :src="`${base_url}/images/properties/${property.id}/${image_url}`"
              alt=""
              uk-cover
            />
          </li>
        </ul>

        <a
          class="uk-position-center-left uk-position-small uk-hidden-hover"
          href="#"
          uk-slidenav-previous
          uk-slideshow-item="previous"
        ></a>
        <a
          class="uk-position-center-right uk-position-small uk-hidden-hover"
          href="#"
          uk-slidenav-next
          uk-slideshow-item="next"
        ></a>
      </div>
    </div>
    <table class="uk-table uk-table-divider uk-table-small">
      <tbody>
        <tr>
          <td class=" uk-text-bold">Title:</td>
          <td>
            {{ property != null ? property.title : null }}
          </td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Category</td>
          <td>
            {{ property != null ? property.category.name : null }}>
            {{ property != null ? property.subcategory.name : null }}
          </td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Phone:</td>
          <td>{{ property != null ? property.phone : null }}</td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Location:</td>
          <td>
            {{ property != null ? property.state.name : null }},
            {{ property != null ? property.city.name : null }}
          </td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Address:</td>
          <td v-html="property != null ? property.address : null"></td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Description:</td>
          <td v-html="property != null ? property.description : null"></td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Plan:</td>
          <td>
            <span class=" uk-label ">{{
              property != null ? property.plan : null
            }}</span>
          </td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Price:</td>
          <td>
            &#8358;{{ property != null ? number_format(property.price) : null }}
          </td>
        </tr>
        <tr>
          <td class=" uk-text-bold">Created:</td>
          <td>
            {{
              moment(property != null ? property.created_at : null).fromNow()
            }}
          </td>
        </tr>
        <tr
          v-if="
            property != null && Object.keys(property.specifications).length > 0
          "
        >
          <td class=" uk-text-bold">Specifications:</td>
          <td>
            <span
              class=" uk-label "
              v-for="(spec, index) in property.specifications"
              :key="index"
              >#{{ spec.name }}</span
            >
          </td>
        </tr>
        <tr
          v-if="property != null && Object.keys(property.amenities).length > 0"
        >
          <td class=" uk-text-bold">Amenities:</td>
          <td>
            <span
              class=" uk-label "
              v-for="(amen, index) in property.amenities"
              :key="index"
              >#{{ amen.name }}</span
            >
          </td>
        </tr>
        <tr v-if="property != null && Object.keys(property.tags).length > 0">
          <td class=" uk-text-bold">Tags:</td>
          <td>
            <span
              class=" uk-label "
              v-for="(tag, index) in property.tags"
              :key="index"
              >#{{ tag.name }}</span
            >
          </td>
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
      property: null,
      base_url: window.location.origin,
      data_url: ""
    };
  },
  methods: {
    load_data(property_data) {
      this.property = property_data;
    },
    number_format(x) {
      return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }
  },
  props: {
    property_data: {
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
