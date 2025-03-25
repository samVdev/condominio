import Http from "@/utils/Http";

export default {
  getUsersReceipts(query: string) {
    return Http.get(`/api/receipts/users/pending/?${query}`);
  },      
};
