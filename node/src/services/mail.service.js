import nodemailer from 'nodemailer';
import { Buffer } from 'buffer';

const createTransporter = (user, password) => {
    return nodemailer.createTransport({
        service: 'gmail',
        auth: { user, pass: password },
        pool: true,
        maxConnections: 5,
        rateLimit: 10
    });
};


const sendMail = async (req, res) => {
    const { user, password, postId, html, asunto, recipients } = req.body;

    const requiredFields = { user, password, html, asunto, recipients };
    const missingFields = Object.entries(requiredFields)
        .filter(([_, value]) => !value)
        .map(([key]) => key);

    if (missingFields.length > 0 || !Array.isArray(recipients)) {
        return res.status(400).json({
            success: false,
            message: 'Campos requeridos faltantes o inválidos',
            missingFields: !Array.isArray(recipients) ? [...missingFields, 'recipients (debe ser array)'] : missingFields
        });
    }

    try {
        const transporter = createTransporter(user, password);
        const batchSize = 10;
        let successfulEmails = 0;
        const failedBatches = [];

        const attachments = [];
        const processedHtml = html.replace(
            /src="data:image\/(\w+);base64,([^"]+)"/g, 
            (match, type, data) => {
                const cid = `img-${attachments.length}`;
                attachments.push({
                    cid,
                    content: Buffer.from(data, 'base64'),
                    contentType: `image/${type}`,
                    encoding: 'base64'
                });
                return `src="cid:${cid}"`;
            }
        );

        for (let i = 0; i < recipients.length; i += batchSize) {
            const batch = recipients.slice(i, i + batchSize);
            
            try {
                await transporter.sendMail({
                    from: `"Notificaciones" <${user}>`,
                    to: batch.join(', '),
                    subject: asunto,
                    html: processedHtml,
                    attachments,
                    priority: 'high'
                });
                successfulEmails += batch.length;
                console.log(`Lote ${i}-${Math.min(i + batchSize, recipients.length) - 1} enviado`);
                
                if (i + batchSize < recipients.length) {
                    await new Promise(resolve => setTimeout(resolve, 500));
                }
            } catch (error) {
                console.error(`Error en lote ${i}-${i + batchSize - 1}:`, error.message);
                failedBatches.push({
                    range: `${i}-${i + batchSize - 1}`,
                    error: error.message
                });
            }
        }

        transporter.close();

        res.json({
            success: true,
            sentCount: successfulEmails,
            totalCount: recipients.length,
            failedBatches,
            message: successfulEmails === recipients.length 
                ? 'Todos los correos enviados exitosamente' 
                : `${successfulEmails}/${recipients.length} correos enviados`
        });

    } catch (error) {
        console.error('Error general al enviar correos:', error);
        res.status(500).json({
            success: false,
            message: 'Error en el servidor al procesar los correos',
            error: error.message
        });
    }
}

export default sendMail