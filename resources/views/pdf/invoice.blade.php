@php
    $fontFamily = "'DejaVu Sans', 'Helvetica', sans-serif";
    $promoDiscount = $transaction->details->sum('discount_total');
    $discount = $transaction->discount ?? 0;
    $voucherDiscount = $transaction->customer_voucher_discount ?? 0;
    $loyaltyDiscount = $transaction->loyalty_discount_total ?? 0;
    $shipping = $transaction->shipping_cost ?? 0;
    $grandTotal = $transaction->grand_total ?? 0;
    $subtotal = $grandTotal + $discount - $shipping + $promoDiscount + $voucherDiscount + $loyaltyDiscount;
    $storeName = $store['name'] ?? 'NAVA Hardware';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
@page { margin: 22mm 18mm 20mm; }
* { box-sizing: border-box; }
body { font-family: {{ $fontFamily }}; margin: 0; color: #25292B; font-size: 10px; line-height: 1.5; }
.topline { height: 5px; background: #A68C68; margin-bottom: 22px; }
.header { width: 100%; border-collapse: collapse; margin-bottom: 22px; }
.brand { font-size: 22px; font-weight: 800; letter-spacing: 3px; color: #25292B; }
.brand-sub { color: #A68C68; font-size: 8px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; margin-top: 3px; }
.store-meta { color: #68736D; font-size: 9px; margin-top: 8px; }
.doc-label { font-size: 9px; letter-spacing: 2px; font-weight: 700; color: #A68C68; text-transform: uppercase; }
.invoice-no { font-size: 17px; font-weight: 800; color: #25292B; margin-top: 5px; }
.rule { border-bottom: 1px solid #D8D1C6; }
.details { width: 100%; border-collapse: collapse; margin: 15px 0 20px; }
.details td { vertical-align: top; padding: 5px 0; }
.label { font-size: 8px; color: #68736D; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; }
.value { font-size: 10px; font-weight: 700; margin-top: 3px; }
.muted { color: #68736D; font-size: 9px; }
.items { width: 100%; border-collapse: collapse; margin-top: 10px; }
.items thead th { background: #25292B; color: #F4F1EB; padding: 10px 9px; text-align: left; font-size: 8px; letter-spacing: .8px; text-transform: uppercase; }
.items thead th.right, .items td.right { text-align: right; }
.items thead th.center, .items td.center { text-align: center; }
.items tbody td { padding: 10px 9px; border-bottom: 1px solid #E4DED4; vertical-align: top; font-size: 9px; }
.items tbody tr:nth-child(even) td { background: #FAF9F6; }
.product-name { font-weight: 700; font-size: 10px; }
.product-meta { color: #68736D; font-size: 8px; margin-top: 3px; }
.totals { width: 48%; margin-left: 52%; border-collapse: collapse; margin-top: 15px; }
.totals td { padding: 5px 0; font-size: 9px; }
.totals .grand td { border-top: 1px solid #A68C68; padding-top: 10px; font-size: 12px; font-weight: 800; color: #25292B; }
.payment-box { margin-top: 22px; padding: 12px 14px; background: #F4F1EB; border-left: 3px solid #A68C68; }
.footer { margin-top: 32px; border-top: 1px solid #D8D1C6; padding-top: 12px; color: #68736D; font-size: 8px; }
.footer-title { color: #25292B; font-weight: 800; letter-spacing: 1.5px; }
.barcode { text-align: center; margin-top: 18px; }
.barcode img { height: 26px; }
.right { text-align: right; }
</style>
</head>
<body>
<div class="topline"></div>
<table class="header"><tr>
<td style="width:58%; vertical-align:top;">
@if (!empty($store['logo_data']))
<img src="{{ $store['logo_data'] }}" alt="{{ $storeName }}" style="max-width:58px;max-height:48px;object-fit:contain;margin-bottom:7px;">
@elseif (!empty($store['logo']))
<img src="{{ $store['logo'] }}" alt="{{ $storeName }}" style="max-width:58px;max-height:48px;object-fit:contain;margin-bottom:7px;">
@endif
<div class="brand">{{ strtoupper($storeName) }}</div>
<div class="brand-sub">Architectural Hardware &amp; Smart Home</div>
<div class="store-meta">{{ $store['address'] ?? '' }}<br>{{ !empty($store['phone']) ? 'Telp. '.$store['phone'].' · ' : '' }}{{ $store['email'] ?? '' }}</div>
</td>
<td style="width:42%;text-align:right;vertical-align:top;">
<div class="doc-label">Invoice Penjualan</div>
<div class="invoice-no">{{ $transaction->invoice }}</div>
<div class="muted" style="margin-top:5px;">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d F Y · H:i') }}</div>
<div style="margin-top:9px;display:inline-block;padding:4px 8px;background:#F0EDE7;color:#735F48;font-weight:700;font-size:8px;text-transform:uppercase;">{{ $transaction->payment_status }}</div>
</td>
</tr></table>
<div class="rule"></div>
<table class="details"><tr>
<td style="width:50%;">
<div class="label">Ditagihkan kepada</div>
<div class="value">{{ $transaction->customer->name ?? 'Pelanggan Umum' }}</div>
@if ($transaction->customer?->no_telp)<div class="muted">{{ $transaction->customer->no_telp }}</div>@endif
@if ($transaction->customer)
<div class="muted">{{ $transaction->customer->village_name ?? '' }}{{ $transaction->customer->regency_name ? ', '.$transaction->customer->regency_name : '' }}{{ $transaction->customer->province_name ? ', '.$transaction->customer->province_name : '' }}</div>
@endif
</td>
<td style="width:25%;"><div class="label">Petugas</div><div class="value">{{ $transaction->cashier->name ?? '-' }}</div></td>
<td style="width:25%;"><div class="label">Pembayaran</div><div class="value">{{ $transaction->payment_method ?? '-' }}</div>
@if ($transaction->receivable && $transaction->receivable->due_date)<div class="muted">Jatuh tempo: {{ $transaction->receivable->due_date }}</div>@endif
</td>
</tr></table>
<div class="label" style="margin-bottom:5px;">Rincian pesanan</div>
<table class="items">
<thead><tr><th style="width:48%;">Produk / Deskripsi</th><th class="center" style="width:10%;">Qty</th><th class="right" style="width:20%;">Harga satuan</th><th class="right" style="width:22%;">Jumlah</th></tr></thead>
<tbody>
@foreach ($transaction->details as $detail)
<tr>
<td><div class="product-name">{{ $detail->product->title ?? 'Produk' }}</div>
@if (!empty($detail->product?->sku))<div class="product-meta">SKU: {{ $detail->product->sku }}</div>@endif
@if (!empty($detail->product?->description))<div class="product-meta">{{ $detail->product->description }}</div>@endif
@if ($detail->discount_total > 0 && ($detail->pricing_group_label || $detail->pricing_rule_name))<div class="product-meta">Promosi: {{ $detail->pricing_group_label ?: $detail->pricing_rule_name }}</div>@endif
</td>
<td class="center">{{ $detail->qty }}</td>
<td class="right">
@if ($detail->discount_total > 0 && $detail->base_unit_price > $detail->unit_price)<div class="product-meta" style="text-decoration:line-through;">Rp {{ number_format($detail->base_unit_price,0,',','.') }}</div>@endif
Rp {{ number_format($detail->unit_price ?: ($detail->price / max(1,$detail->qty)),0,',','.') }}
</td>
<td class="right" style="font-weight:700;">Rp {{ number_format($detail->price,0,',','.') }}</td>
</tr>
@endforeach
</tbody></table>
<table class="totals">
<tr><td class="muted">Subtotal</td><td class="right">Rp {{ number_format($subtotal,0,',','.') }}</td></tr>
@if ($promoDiscount > 0)<tr><td class="muted">Diskon promosi</td><td class="right">− Rp {{ number_format($promoDiscount,0,',','.') }}</td></tr>@endif
@if ($discount > 0)<tr><td class="muted">Diskon transaksi</td><td class="right">− Rp {{ number_format($discount,0,',','.') }}</td></tr>@endif
@if ($voucherDiscount > 0)<tr><td class="muted">Voucher</td><td class="right">− Rp {{ number_format($voucherDiscount,0,',','.') }}</td></tr>@endif
@if ($loyaltyDiscount > 0)<tr><td class="muted">Diskon loyalty</td><td class="right">− Rp {{ number_format($loyaltyDiscount,0,',','.') }}</td></tr>@endif
@if ($shipping > 0)<tr><td class="muted">Ongkos kirim</td><td class="right">+ Rp {{ number_format($shipping,0,',','.') }}</td></tr>@endif
@if (($transaction->tax_total ?? 0) > 0)<tr><td class="muted">PPN</td><td class="right">+ Rp {{ number_format($transaction->tax_total,0,',','.') }}</td></tr>@endif
<tr class="grand"><td>TOTAL TAGIHAN</td><td class="right">Rp {{ number_format($grandTotal,0,',','.') }}</td></tr>
</table>
<div class="payment-box"><strong>Informasi pembayaran</strong><br>Status: {{ $transaction->payment_status }} · Metode: {{ $transaction->payment_method ?? '-' }}</div>
<div class="barcode"><img src="{{ $barcode }}" alt="Barcode invoice"><div class="muted">{{ $transaction->invoice }}</div></div>
<div class="footer"><div class="footer-title">NAVA HARDWARE</div>
Terima kasih telah mempercayakan kebutuhan architectural hardware dan smart home Anda kepada NAVA.<br>
Simpan invoice ini sebagai bukti transaksi dan referensi layanan garansi. Ketentuan garansi mengikuti kebijakan merek/produk yang tercantum pada kemasan atau kartu garansi.
</div>
</body></html>
