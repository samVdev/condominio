import express from 'express';
import cors from 'cors';
import { apiKeyAuth } from './src/midlewares/apiKeyAuth.js';
import routes from './src/routes/routes.service.js';

const app = express();
const PORT = process.env.PORT || 3000;

app.use(cors({
  origin: false,
}));


app.use(cors());
app.use(express.json({ limit: '50mb' }));
app.use(express.urlencoded({ extended: true, limit: '50mb' }));
app.use(apiKeyAuth)

app.use('/api', routes)

app.listen(PORT, () => {
    console.log(`Servidor optimizado`);
});