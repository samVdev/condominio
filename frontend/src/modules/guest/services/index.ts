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

  getFileExpenses(query: any) {
    return Http.getFile(`/api/guest/export/expenses/?${query}`);
  },

  getProvisionsFacture(query: any) {
    return Http.get(`/api/guest/provisions/facture/?${query}`);
  },

  getEarningsFacture(query: any) {
    return Http.get(`/api/guest/earnings/facture/?${query}`);
  },

  saveReceipt(id: string, payload: any) {
    return Http.post(`/api/guest/pay/facture/${id}`, payload);
  },


  /* Boards */

  getBoardsAct() {
    return Http.get(`/api/guest/boards/act`);
  },

  getBoard(uuid: string) {
    return Http.get(`/api/guest/board/live/${uuid}`);
  },

  disconnect(uuid: string) {
    return Http.get(`/api/guest/board/live-disconnect/${uuid}`);
  },


  /* Propuestas */

  getSurveys(uuid: string) {
    return Http.get(`/api/boards/surveys/${uuid}`);
  },
};
