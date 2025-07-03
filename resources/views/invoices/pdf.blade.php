<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 12px; 
            color: #333;
        }
        .container { 
            width: 100%; 
            margin: 0 auto; 
        }
        /* -- Style untuk Header dengan Dua Logo -- */
        .header-container {
            width: 100%;
            margin-bottom: 25px;
            overflow: auto; /* Trik agar container mengenali float */
        }
        .logo-left {
            float: left;
            width: 15%; /* Lebar kolom logo kiri */
        }
        .header-center {
            float: left;
            width: 70%; /* Lebar kolom teks di tengah */
            text-align: center;
        }
        .logo-right {
            float: right;
            width: 15%; /* Lebar kolom logo kanan */
            text-align: right;
        }
        .logo {
            max-width: 80px; /* Atur ukuran logo agar tidak terlalu besar */
            max-height: 80px;
        }
        .header-center h1 {
            font-size: 20px;
            margin: 0;
            font-weight: bold;
        }
        .header-center p {
            margin: 2px 0;
            font-size: 11px;
        }
        /* -- Akhir Style Header -- */

        .details-container { width: 100%; margin-bottom: 20px; margin-top: 20px;}
        table.items { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.items th, table.items td { border: 1px solid #777; padding: 8px; text-align: left; }
        table.items th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 40px; width: 100%; }
        .footer .signature-left { float: left; width: 50%; text-align: center; }
        .footer .signature-right { float: right; width: 50%; text-align: center; }
        .footer p { margin-top: 60px; }
    </style>
</head>
<body>
    @php
        // Ambil logo kiri
        $logoKiriPath = public_path('images/logo_dharma_wanita.png');
        $logoKiriData = base64_encode(file_get_contents($logoKiriPath));
        $logoKiriSrc = 'data:image/png;base64,' . $logoKiriData;

        // Ambil logo kanan
        $logoKananPath = public_path('images/logo_ulm.png');
        $logoKananData = base64_encode(file_get_contents($logoKananPath));
        $logoKananSrc = 'data:image/png;base64,' . $logoKananData;
    @endphp

    <div class="container">
        
        <div class="header-container">
            <div class="logo-left">
                <img src="{{ $logoKiriSrc }}" alt="Logo Kiri" class="logo">
            </div>
            <div class="header-center">
                <h1>Unit Usaha DWP FKIK ULM</h1>
                <p>Alamat: Jl. A. Yani Km. 36, Banjarbaru, Kalimantan Selatan</p>
                <p>No Tlp: 081349506500</p>
            </div>
            <div class="logo-right">
                <img src="{{ $logoKananSrc }}" alt="Logo Kanan" class="logo">
            </div>
        </div>

        <div style="clear: both;"></div> <div class="details-container">
            <table style="width: 50%; border-collapse: collapse;">
                <tr>
                    <td style="width: 20%; padding: 2px 0;">No</td>
                    <td style="padding: 2px 0;">: {{ $invoice->invoice_number }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px 0;">Tanggal</td>
                    <td style="padding: 2px 0;">: {{ $invoice->invoice_date->format('d F Y') }}</td>
                </tr>
                 <tr>
                    <td style="padding: 2px 0;">Nama</td>
                    <td style="padding: 2px 0;">: {{ $invoice->customer_name }}</td>
                </tr>
            </table>
        </div>
        
        <table class="items">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama Barang</th>
                    <th class="text-center">Kuantitas</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right" style="border:none; font-weight:bold; padding: 8px;">Total Keseluruhan</td>
                    <td class="text-right" style="font-weight:bold; border: 1px solid #777; padding: 8px;">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">

            <div class="signature-right">
                Hormat Kami, Ana Farlina
                <p>(.........................)</p>
            </div>
        </div>
    </div>
</body>
</html>