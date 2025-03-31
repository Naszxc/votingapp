import { defineStore } from 'pinia';
import { reactive } from 'vue';

// interface Album {
//   id: number;
//   title: string;
//   artist: string;
//   cover_image: string;
// }

export const useAlbum = defineStore('album', {
  state: () => ({
    album: []
  }),

  getters:{
    getAlbum(state){
      return state.album;
    }
  },

  actions: {
    setTitle(title) {
      this.title = title;
    },

    setAlbum(album){
      this.album = album
    },

    appendAlbum(album){
      this.album.unshift(album);
    },

    removeAlbum(id) {
      this.album = this.album.filter((item) => item.id !== id);
    }
  }
});
