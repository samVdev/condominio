import Http from "@/utils/Http";

export default {
  
  getCounted() {
    return Http.get(`/api/guest/count`);
  },

  getAccount() {
    return Http.get(`/api/guest/account`);
  },
  getFacturesPending(query: any) {
    return Http.get(`/api/guest/factures/user/pending/?${query}`);
  },

  getFacturesCompleted(query: any) {
    return Http.get(`/api/guest/factures/user/completed/?${query}`);
  },

  getExpensesFacture(query: any) {
    return Http.get(`/api/guest/expenses/facture/?${query}`);
  },

  saveReceipt(id: string, payload: any) {
    return Http.post(`/api/guest/pay/facture/${id}`, payload);
  },
  
};
