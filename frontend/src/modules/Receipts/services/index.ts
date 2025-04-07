import Http from "@/utils/Http";

export default {
  getUsersReceipts(query: string) {
    return Http.get(`/api/receipts/users/pending/?${query}`);
  },      

  getReceipts(query: string) {
    return Http.get(`/api/receipts/?${query}`);
  },    

  actionReceipt(payload: any) {
    return Http.post(`/api/receipts/`, payload);
  },    
};
