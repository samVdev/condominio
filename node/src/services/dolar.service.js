let dolarCache = null;
let lastFetch = 0;
const CACHE_TIME = 300000; // 5 minutos en ms

const getDolar = async (req, res) => {
    try {
        const now = Date.now();
        
        if (dolarCache && (now - lastFetch) < CACHE_TIME) {
            return res.json(dolarCache);
        }

        const response = await fetch('https://pydolarve.org/api/v1/dollar');
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

        dolarCache = await response.json();
        lastFetch = now;
        res.json(dolarCache);
    } catch (error) {
        console.error('Error al obtener datos del dólar:', error);

        if (dolarCache) {
            return res.json(dolarCache);
        }

        res.status(500).json({
            success: false,
            message: 'Error al obtener datos del dólar',
            error: error.message
        });
    }
}

export default getDolar