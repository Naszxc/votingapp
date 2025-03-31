import { defineStore } from 'pinia';
import { toRaw } from 'vue';

// interface Main {
//     votedAlbum: string;
// }

export const useMain = defineStore('main', {
  state: () => ({
    votedAlbum: [],
    albumDetails: [] as Record<string, any>,
    albumList: [],
    searchResult: []
  }),

  getters:{
    getVotedAlbum(state){
        return state.votedAlbum;
    },

    getAlbumDetails(state){
        return state.albumDetails;
    },

    getAlbumList(state){
        return state.albumList;
    },

    getSearchResult(state){
        return state.searchResult;
    }
  },

  actions: {
    setVotedAlbum(votedAlbum) {
        this.votedAlbum = votedAlbum;
    },

    setAlbumDetails(albumDetails) {
        this.albumDetails = albumDetails;
    },

    setAppendUserVote(vote){
        this.albumDetails.user_votes.push(vote);
    },

    removeVote(){
        this.albumDetails.user_votes.length = 0;
    },

    setAlbumList(albumList){
        this.albumList = albumList
    },

    setSearchResult(searchResult){
        this.searchResult = searchResult;
    },

    appendVoteOnAlbumList(id){
        let album = this.albumList.find(album => album.id === id);
        if (album) {
            album.votes_count++;
        }
        console.log(id, "asdfef")
    },

    removeVoteOnAlbumList(id) {
        let album = this.albumList.find(album => album.id === id);
        if (album) {
            album.votes_count--;
        }
        console.log(album, "asdfef")
    }
  }
});
