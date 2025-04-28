import Http from "@/utils/Http";

export default {  
  get(query: any) {  
    return Http.get(`/api/posts/?${query}`);
  },  
  show(id: any) {  
    return Http.get(`/api/posts/${id}`);
  },  
  insert(form: any) {
    return Http.post(`/api/posts`, form);
  },
  update(id: string, form: any) {
    return Http.post(`/api/posts/${id}`, form);
  },

  email(id: string) {
    return Http.post(`/api/posts/email/${id}`, {});
  },

  delete(id: string) {
    return Http.delete(`/api/posts/${id}`);
  },
};
