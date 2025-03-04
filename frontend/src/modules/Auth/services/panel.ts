import Http from "@/utils/Http";

export const getCountedDataService = async () => {
  return Http.get(`/api/statics/admin/counted`);
}
