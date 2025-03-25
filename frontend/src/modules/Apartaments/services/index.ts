import Http from "@/utils/Http";

export default {  
  getApts(query: any) {  
    return Http.get(`/api/apt/?${query}`);
  },  

  getTowers() {  
    return Http.get(`/api/apt/towers/`);
  },  

  showApt(id: any) {  
    return Http.get(`/api/apt/show/${id}`);
  },  
  insertApt(form: any) {
    return Http.post(`/api/apt`, form);
  },
  updateApt(id: string, form: any) {
    return Http.put(`/api/apt/${id}`, form);
  },
  deleteApt(id: string) {
    return Http.delete(`/api/apt/${id}`);
  },
};
