<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 10px;
    }

    .pdf-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 25px;
        page-break-inside: avoid;
    }

    .pdf-table th, .pdf-table td {
        border: 1px solid #000;
        padding: 4px;
        text-align: center;
    }

    .pdf-table th {
        background: #efefef;
        font-weight: bold;
    }

    .total-row {
        background: #ddd !important;
        font-weight: bold;
    }

    /* agar tabel tidak bertabrakan saat split */
    .split-title {
        margin: 10px 0 5px;
        font-weight: bold;
        font-size: 11px;
    }
     .page-break {
        page-break-before: always;
    }
</style>
