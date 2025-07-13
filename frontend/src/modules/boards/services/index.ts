import Http from "@/utils/Http";

export default {
  get(query: any) {
    return Http.get(`/api/boards/?${query}`);
  },
  show(uuid: any) {
    return Http.get(`/api/boards/live/${uuid}`);
  },

  getApts(uuid: any) {
    return Http.get(`/api/boards/live-apts/${uuid}`);
  },

  insert(form: any) {
    return Http.post(`/api/boards`, form);
  },
  update(id: string, form: any) {
    return Http.post(`/api/boards/${id}`, form);
  },

  statusChange(uuid: string) {
    return Http.post(`/api/boards/status/${uuid}`);
  },

  changeLink(uuid: string, payload: any) {
    return Http.put(`/api/boards/link/${uuid}`, payload);
  },

  boardEnd(uuid: string, descripcion: string) {
    return Http.put(`/api/boards/end/${uuid}`, { descripcion });
  },

  delete(uuid: string) {
    return Http.delete(`/api/boards/${uuid}`);
  },


  /* Survey */

  getSurveys(uuid: string) {
    return Http.get(`/api/boards/surveys/${uuid}`);
  },

  storeSurvey(uuid: string, payload: any) {
    return Http.post(`/api/boards/surveys/${uuid}`, payload);
  },

  statusSurvey(id: string) {
    return Http.put(`/api/boards/survey/${id}`, {});
  },

  deleteSurvey(id: string) {
    return Http.delete(`/api/boards/survey/${id}`);
  },
};
