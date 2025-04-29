import Http from "@/utils/Http";

export default {
  getCountedDataService () {
    return Http.get(`/api/statics/admin/counted`);
  },

  getFundService () {
    return Http.get(`/api/statics/admin/fundreserve`);
  }
}