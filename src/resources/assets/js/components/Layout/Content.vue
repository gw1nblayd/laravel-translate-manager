<template>
  <div class="w-full lg:w-4/5 mt-6 lg:mt-0 relative">
    <div
      class="w-full p-8 text-gray-900 leading-normal bg-white border border-gray-400 rounded-[15px]"
    >
      <div class="w-full mx-auto py-4 lg:py-0">
        <div class="w-full relative">
          <input
            type="search"
            placeholder="Search"
            class="w-full focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-8 pr-3 sm:text-sm border-gray-300 rounded-md"
            @input="searchDebounce"
          >
          <div class="absolute" style="top: 0.7rem; left: 0.6rem;">
            <svg
              v-if="!searching"
              class="fill-current pointer-events-none text-gray-800 w-4 h-4" xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
            >
              <path
                d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"
              ></path>
            </svg>
            <svg v-if="searching" class="animate-spin pointer-events-none text-gray-800 h-4 w-4"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div v-for="(items, block) in searchableItems">
        <div v-if="block === selectedBlock || search">
          <!--Title-->
          <div class="font-sans" :id="`translate-${block}`">
            <h1 class="font-sans break-normal text-gray-900 pt-6 pb-2 text-xl">{{ block }}</h1>
            <hr class="border-b border-gray-400">
          </div>

          <div class="w-full text-gray-900">
            <table class="table-auto w-full">
              <thead>
              <tr class="text-left">
                <th class="w-1/3">Key</th>
                <th>Value</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>
              <tr
                v-for="(value, key) in items"
                class="h-10 border-b-2"
              >
                <td class="w-2/6">{{ key }}</td>
                <td class="w-3/6">
                  <div
                    v-if="editableItem.key === key && !loading"
                    class="mt-1 relative rounded-md shadow-sm"
                  >
                    <textarea
                      autofocus
                      class="focus:ring-indigo-500 focus:border-indigo-500 block w-full border-gray-300 rounded-md pr-16"
                      v-model="editableItem.value"
                      :rows="rows"
                      @keyup.shift.enter="onSave(block)"
                      @keyup.esc="onClearEditableItem"
                    />
                    <div class="absolute inset-y-0 right-0 flex items-center">
                      <button
                        type="submit"
                        class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 text-center border-transparent bg-transparent text-gray-500 rounded-md"
                        :disabled="loading"
                        @click="onSave(block)"
                      >
                        Save
                      </button>
                    </div>
                  </div>
                  <span
                    v-else
                    class="bg-transparent border-none w-full text-left"
                  >
                    <svg v-if="editableItem.key === key && loading"
                         class="animate-spin pointer-events-none text-gray-800 h-4 w-4 inline-block"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                              stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ value }}
                  </span>
                </td>
                <td>
                  <button
                    class="bg-blue-400 text-white font-bold px-2 disabled:cursor-no-drop disabled:bg-gray-400"
                    @click="setEditableItem(key, value)"
                    :disabled="loading || searching"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                         class="inline-block"
                         viewBox="0 0 16 16">
                      <path
                        d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                    </svg>
                  </button>
                  <button
                    class="bg-red-400 text-white font-bold px-2 disabled:cursor-no-drop disabled:bg-gray-400"
                    @click="onRemove(block, key)"
                    :disabled="loading || searching"
                  >
                    -
                  </button>
                  <button
                    class="bg-green-400 text-white font-bold px-2 disabled:cursor-no-drop disabled:bg-gray-400"
                    @click=""
                    :disabled="loading || searching"
                  >
                    +
                  </button>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import helper from '../../helpers/helper';

export default {
  data() {
    return {
      search: '',
      searching: false,

      editableItem: {
        key: null,
        value: null,
      },
    }
  },

  computed: {
    rows() {
      if (!this.editableItem.value) {
        return 1;
      }

      const value = Math.ceil(
        this.editableItem.value.split(' ').length / 7
        +
        (this.editableItem.value.split('\n').length - 1)
      )

      console.log(value);

      return value;
    },

    translates() {
      return this.$store.state.translates;
    },

    loading() {
      return this.$store.state.loading;
    },

    selectedBlock() {
      return this.$store.state.selectedBlock;
    },

    searchableItems() {
      if (!this.translates) {
        return {};
      }

      const keys = Object.keys(this.translates);
      let obj = null;

      keys.forEach(key => {
        Object.keys(this.translates[key]).forEach(k => {
          if (k.toLowerCase().includes(this.search.toLowerCase())
            || this.translates[key][k].toLowerCase().includes(this.search.toLowerCase())
          ) {
            if (!obj) {
              obj = {};
            }

            if (!obj[key]) {
              obj[key] = {}
            }

            if (!obj[key][k]) {
              obj[key][k] = '';
            }

            obj[key][k] = this.translates[key][k];
          }
        })
      });

      this.$store.commit('setSearchableItems', obj);

      return obj;
    }
  },

  methods: {
    updateIsSearch() {
      this.$store.commit('setIsSearch', this.search.length);
    },

    setEditableItem(key, value) {
      this.editableItem.key = key;
      this.editableItem.value = value;
    },

    onClearEditableItem() {
      this.editableItem = {
        key: null,
        value: null,
      };
    },

    searchDebounce(event) {
      this.searching = true;
      const timeoutId = window.setTimeout(() => {
      }, 0);
      for (let id = timeoutId; id >= 0; id -= 1) {
        window.clearTimeout(id);
      }

      setTimeout(() => {
        this.search = event.target.value;
        this.updateIsSearch();
        this.searching = false;
      }, 1000);
    },

    onSave(block) {
      this.$store.commit('loadingOn');
      axios.put(helper.url(`translates/${helper.lang()}`), {
        block,
        lang: helper.lang(),
        key: this.editableItem.key,
        value: this.editableItem.value,
      })
        .then(response => {
          this.editableItem = {
            key: null,
            value: null,
          };

          this.$emit('loadTranslates');
          this.$store.commit('loadingOff');
        })
        .catch((e) => {

        });
    },

    onRemove(block, key) {
      this.$store.commit('loadingOn');

      axios.delete(helper.url(`translates/${helper.lang()}/${block}/${key}`))
        .then(r => {
          this.$emit('loadTranslates');
          this.$store.commit('loadingOff');
        })
        .catch((e) => {

        });
    },
  }
}
</script>