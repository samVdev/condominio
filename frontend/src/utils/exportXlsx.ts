import * as XLSX from "xlsx";

const exporToXlsx = (title: string, cols: any[], rows: any, fileName: string) => {
const ws = XLSX.utils.aoa_to_sheet([
    [title],
    cols,
    ...rows
]);

ws["!merges"] = [
    { s: { r: 0, c: 0 }, e: { r: 0, c: cols.length - 1 } }
];

const wb = XLSX.utils.book_new();
XLSX.utils.book_append_sheet(wb, ws, "Datos");

XLSX.writeFile(wb, `${fileName}.xlsx`);
};

export default exporToXlsx;
