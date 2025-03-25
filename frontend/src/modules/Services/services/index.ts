import Http from "@/utils/Http";

export default {  
  getServices(query: any) {  
    return Http.get(`/api/services/?${query}`);
  },  

  getServicesToSelect() {  
    return Http.get(`/api/services/minium`);
  },  
  showService(id: any) {  
    return Http.get(`/api/services/show/${id}`);
  },  
  insertService(form: any) {
    return Http.post(`/api/services`, form);
  },
  updateService(id: string, form: any) {
    return Http.put(`/api/services/${id}`, form);
  },
  deleteService(id: string) {
    return Http.delete(`/api/services/${id}`);
  },
};
