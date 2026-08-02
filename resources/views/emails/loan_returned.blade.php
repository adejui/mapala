<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Telah Dikembalikan</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">

        <tr>
            <td style="padding: 30px 40px; text-align: center; background-color: #1c1c1c;">
                <h1 style="color: #ffffff; margin: 0; font-size: 24px; letter-spacing: 1px;">
                    <span style="color: #7C3AED;">Tarantula</span> Adventure
                </h1>
            </td>
        </tr>

        <tr>
            <td style="padding: 40px;">

                <h2 style="color: #1f2937; margin-top: 0; font-size: 20px;">
                    Halo, {{ $data['name'] }} 👋
                </h2>

                <p style="color: #4b5563; font-size: 16px; line-height: 24px;">
                    Terima kasih! Kami konfirmasi bahwa peminjaman alat Anda dengan ID
                    <strong>#{{ $data['id'] }}</strong>
                    telah kami terima kembali dengan status:
                </p>

                <div style="margin: 20px 0; text-align: center;">
                    <span
                        style="background-color: #dbeafe; color: #1e40af; padding: 12px 25px; border-radius: 50px; font-weight: bold; font-size: 16px; display: inline-block; border: 1px solid #3b82f6;">
                        📦 DIKEMBALIKAN / RETURNED
                    </span>
                </div>

                <table width="100%" cellpadding="0" cellspacing="0"
                    style="background-color: #f9fafb; border-radius: 12px; border: 1px solid #e5e7eb; margin-bottom: 25px;">
                    <tr>
                        <td style="padding: 20px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-bottom: 10px; color: #6b7280; font-size: 14px;">Tanggal Pinjam:
                                    </td>
                                    <td
                                        style="padding-bottom: 10px; color: #111827; font-weight: bold; text-align: right;">
                                        {{ $data['borrow_date'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 10px; color: #6b7280; font-size: 14px;">Tanggal Kembali:
                                    </td>
                                    <td
                                        style="padding-bottom: 10px; color: #111827; font-weight: bold; text-align: right;">
                                        {{ $data['return_date'] }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #6b7280; font-size: 14px;">Jumlah Barang:</td>
                                    <td style="color: #111827; font-weight: bold; text-align: right;">
                                        {{ $data['quantity'] }} Unit</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <p style="color: #4b5563; font-size: 16px; line-height: 24px;">
                    Seluruh alat yang Anda pinjam telah kami periksa dan diterima dengan baik oleh Tim Logistik kami.
                    Terima kasih atas kepercayaan dan kerja sama Anda selama masa peminjaman.
                </p>

                <p style="color: #4b5563; font-size: 14px; margin-top: 30px;">
                    Jika ada pertanyaan terkait kondisi alat atau jaminan Anda, silakan hubungi Tim Logistik kami:
                </p>
                <p style="margin-top: 5px;">
                    <a href="https://wa.me/6281234567890"
                        style="color: #7C3AED; font-weight: bold; text-decoration: none; font-size: 16px;">
                        📞 +62 812-3456-7890 (Logistik)
                    </a>
                </p>

            </td>
        </tr>

        <tr>
            <td style="padding: 30px; background-color: #f3f4f6; text-align: center; border-top: 1px solid #e5e7eb;">
                <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                    &copy; {{ date('Y') }} Tarantula Adventure UBSI Yogyakarta.
                </p>
                <p style="margin: 10px 0 0 0; color: #9ca3af; font-size: 12px;">
                    Email ini dibuat secara otomatis, mohon tidak membalas email ini.
                </p>
            </td>
        </tr>

    </table>

</body>

</html>
