import Http from "@/utils/Http";

export default {
  getEarnings(query: any) {
    return Http.get(`/api/earnings/?${query}`);
  },
  showEarning(id: any) {
    return Http.get(`/api/earnings/show/${id}`);
  },
  insertEarning(form: any) {
    return Http.post(`/api/earnings`, form);
  },
  updateEarning(id: string, form: any) {
    return Http.post(`/api/earnings/${id}`, form);
  },
  deleteEarning(id: string) {
    return Http.delete(`/api/earnings/${id}`);
  },
};
