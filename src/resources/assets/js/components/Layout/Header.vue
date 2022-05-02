<template>
  <nav id="header" class="fixed w-full z-50 top-0 bg-white border-b border-gray-400">
    <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-4">
      <div class="pl-4 flex items-center">
        <a
          class="text-gray-900 text-base no-underline hover:no-underline font-extrabold text-xl"
          :href="siteUrl"
          v-text="appName"
        ></a>

        <select
          v-if="languages.length"
          class="focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md ml-10"
          :disabled="loading"
          v-model="chosenLang"
        >
          <option
            v-for="lang in languages"
            :selected="lang === chosenLang"
            :value="lang"
          >
            {{ lang }}
          </option>
        </select>
      </div>
      <div class="block lg:hidden pr-4">
        <button
          id="nav-toggle"
          class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-900 hover:border-purple-500 appearance-none focus:outline-none"
          @click="isHidden = !isHidden"
        >
          <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <title>Menu</title>
            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
          </svg>
        </button>
      </div>
      <div
        id="nav-content"
        class="w-full flex-grow justify-end lg:flex lg:content-center lg:items-center lg:w-auto lg:block mt-2 lg:mt-0 z-20"
        :class="{'hidden': isHidden}"
      >
        <ul class="list-reset lg:flex justify-end items-center">
          <li class="mr-3 py-2 lg:py-0">
            <a
              class="inline-block text-gray-600 no-underline hover:text-gray-900 hover:underline py-2 px-4"
              :href="siteUrl"
            >
              Back to site
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import helper from '../../helpers/helper';

export default {
  props: {
    languages: Array,
  },

  computed: {
    loading() {
      return this.$store.state.loading;
    },

    appName() {
      return document.querySelector('#app').dataset.appName;
    },

    appLocale() {
      return document.querySelector('#app').dataset.appLocale;
    },

    siteUrl() {
      return document.querySelector('#app').dataset.siteUrl;
    },
  },

  data() {
    return {
      chosenLang: '',
      isHidden: true,
    }
  },

  created() {
    this.chosenLang = helper.lang() ?? this.appLocale;
  },

  watch: {
    chosenLang() {
      helper.updateLang(this.chosenLang)
      this.$emit('loadTranslates');
    },
  },
}
</script>