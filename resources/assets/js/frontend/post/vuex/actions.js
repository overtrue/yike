import * as services from "../services"

export default {
  createPost: ({ dispatch }, post) => {
    return services.createPost(post);
  },
  loadPost: function({ commit }, slug) {
    return services.getPost(slug.slug || slug)
            .then((post) => {
              commit('POST//SET_POST', post.data)
              return post.data;
            }).catch(function(err){
              console.log(err)
            });
  }
}
