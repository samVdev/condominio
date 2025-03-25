import Http from "@/utils/Http";

export default {
  getExpenses(query: any) {
    return Http.get(`/api/expenses/?${query}`);
  },
  showExpense(id: any) {
    return Http.get(`/api/expenses/show/${id}`);
  },
  insertExpense(form: any) {
    return Http.post(`/api/expenses`, form);
  },
  updateExpense(id: string, form: any) {
    return Http.post(`/api/expenses/${id}`, form);
  },
  deleteExpense(id: string) {
    return Http.delete(`/api/expenses/${id}`);
  },
};
