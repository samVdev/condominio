import Http from "@/utils/Http";

export default {
  getFactures(query: any) {
    return Http.get(`/api/factures/?${query}`);
  },
  insertFacture(form: any) {
    return Http.post(`/api/factures`, form);
  },
  deleteFactures(id: string) {
    return Http.delete(`/api/factures/${id}`);
  },
};
