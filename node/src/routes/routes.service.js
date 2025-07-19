import { Router } from "express";
import getDolar from "../services/dolar.service.js";
import sendMail from "../services/mail.service.js";

const routes = Router()

routes.get('/dolar', getDolar)
routes.post('/send-email', sendMail)

export default routes