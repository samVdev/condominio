import Http from "@/utils/Http";

export default {  
  getTypeEarnings(query: any) {  
    return Http.get(`/api/types/?${query}`);
  },  

  getTypeEarningsToSelect() {  
    return Http.get(`/api/types/minium`);
  },  
  showTypeEarning(id: any) {  
    return Http.get(`/api/types/show/${id}`);
  },  
  insertTypeEarning(form: any) {
    return Http.post(`/api/types`, form);
  },
  updateTypeEarning(id: string, form: any) {
    return Http.put(`/api/types/${id}`, form);
  },
  deleteTypeEarning(id: string) {
    return Http.delete(`/api/types/${id}`);
  },
};
