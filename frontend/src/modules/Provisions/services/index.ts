import Http from "@/utils/Http";

export default {
  getProvisions(query: any) {
    return Http.get(`/api/provisions/?${query}`);
  },
  getFunds () {
    return Http.get(`/api/provisions/allprov`);
  },
  getFundsDetails () {
    return Http.get(`/api/provisions/details`);
  },
  checkProvision(service_id: any, expense_id: string) {
    return Http.get(`/api/provisions/check/${service_id}/${expense_id}`);
  },
  showProvision(id: any) {
    return Http.get(`/api/provisions/show/${id}`);
  },
  insertProvision(form: any) {
    return Http.post(`/api/provisions`, form);
  },
  updateProvision(id: string, form: any) {
    return Http.post(`/api/provisions/${id}`, form);
  },
  updateFunds (form: any) {
    return Http.put(`/api/provisions/new/funds`, form);
  },
  deleteProvision(id: string) {
    return Http.delete(`/api/provisions/${id}`);
  },
};
