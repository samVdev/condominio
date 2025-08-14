import { API_KEY_SECRET, IDENTIFICATOR } from "../config.js";

export function apiKeyAuth(req, res, next) {
  try {
    const apiKey = req.header('x-api-key');
    const userAgent = req.header('user-agent') || '';
    const originIp = req.headers['x-forwarded-for'] || req.connection.remoteAddress || '';
    const host = req.header('host') || '';

    if (!apiKey || apiKey !== API_KEY_SECRET) {
      return res.status(401).json({ success: false, message: 'Unauthorized: API Key inválida o inexistente' });
    }

    if (!originIp.includes(IDENTIFICATOR)) {
      return res.status(401).json({ success: false, message: 'Unauthorized: IP origen no autorizada' });
    }

    if (!userAgent.includes('GuzzleHttp')) {
      return res.status(401).json({ success: false, message: 'Unauthorized: User-Agent inválido' });
    }

    if (!host.includes('condominio-node')) {
      return res.status(401).json({ success: false, message: 'Unauthorized: Host inválido' });
    }

    next();
  } catch (error) {
    console.error('Error en apiKeyAuth:', error);
    return res.status(500).json({ success: false, message: 'Error interno del servidor' });
  }
}
