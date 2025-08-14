import Http from "@/utils/Http";

export default {  
  getElevators(query: any) {  
    return Http.get(`/api/elevators/?${query}`);
  },  
  getMin() {  
    return Http.get(`/api/elevators/min`);
  },  
  getResume() {  
    return Http.get(`/api/elevators/resume`);
  },  
  getHistory(query: any) {  
    return Http.get(`/api/elevators/history/?${query}`);
  }, 
  showElevator(id: string) {  
    return Http.get(`/api/elevators/show/${id}`);
  },  
  insertElevator(form: any) {
    return Http.post(`/api/elevators`, form);
  },
  updateElevator(id: string, form: any) {
    return Http.put(`/api/elevators/${id}`, form);
  },
  reportElevator(id: string, form: any) {
    return Http.post(`/api/elevators/report/${id}`, form);
  },
  deleteElevator(id: string) {
    return Http.delete(`/api/elevators/${id}`);
  },
};
