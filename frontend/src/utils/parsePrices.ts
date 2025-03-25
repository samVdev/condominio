export const parsePrices = (number: number) => {
    return {
        bs: number.toLocaleString('es-VE', { style: 'currency', currency: 'VES' }),
        dol: number.toLocaleString('es-VE', { style: 'currency', currency: 'USD' })
    }
}