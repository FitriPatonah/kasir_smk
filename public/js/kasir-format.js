(function (global) {
    function formatRupiah(angka) {
        const nilai = Number(angka || 0);
        return 'Rp ' + nilai.toLocaleString('id-ID');
    }

    function formatInputUang(value) {
        const digits = String(value ?? '').replace(/[^\d]/g, '');

        if (!digits) return '';
        return Number(digits).toLocaleString('id-ID');
    }

    function parseInputUang(value) {
        return Number(String(value ?? '').replace(/[^\d]/g, '')) || 0;
    }

    const api = { formatRupiah, formatInputUang, parseInputUang };

    if (typeof module !== 'undefined' && module.exports) {
        module.exports = api;
    }

    global.KASIR_FORMAT = api;
})(typeof globalThis !== 'undefined' ? globalThis : this);
