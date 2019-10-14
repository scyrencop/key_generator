<template>
  <div id="app">
    <div class="heading">
      <h1>Cruds</h1>
    </div>
    <tag-component
      v-for="tag in tags"
      v-bind="tag"
      :key="tag.id"
      @update="update"
      @delete="del"
    ></tag-component>
    <div>
      <button @click="create()">Add</button>
    </div>
  </div>
</template>

<script>
  function Tag({ id, color, name}) {
    this.id = id;
    this.color = color;
    this.name = name;
  }

  import TagComponent from './TagComponent.vue';

  export default {
    data() {
      return {
        tags: [],
        mute: false
      }
    },
    methods: {
      create() {
        this.read();
      },
      read() {
        window.axios.get('tags').then(({ data }) => {
          console.log(data)
        })
      },
      update(id, color) {
        this.mute = true;
        window.axios.put(`tags/${id}`, { color }).then(() => {
          this.tags.find(tag => tag.id === id).color = color;
          this.mute = false;
        });
      },
      del(id) {
        // To do
      },
      watch: {
        mute(val) {
          document.getElementById('mute').className = val ? "on" : "";
        }
      }
          
    },
    components: {
      TagComponent
    }
  }
</script>