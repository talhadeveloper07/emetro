@extends('layouts.admin')

@section('content')
  <style>
    body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; padding: 24px; background:#f7fafc; color:#111827; }
    .container { max-width:1100px; margin:0 auto; background:#fff; border-radius:8px; padding:20px; box-shadow:0 6px 18px rgba(0,0,0,0.06); }
    h1 { font-size:20px; margin:0 0 8px; }
    p.note { margin:0 0 16px; color:#6b7280; font-size:13px; }
    .buttons { margin-bottom: 14px; }
    .btn { display:inline-block; padding:8px 12px; border-radius:6px; font-weight:600; text-decoration:none; border:1px solid #e5e7eb; background:#fff; cursor:pointer; margin-right:8px; }
    .btn-primary { background:#111827; color:#fff; border-color:#111827; }
    .btn-ghost { background:transparent; color:#374151; }
    pre.xml-box { white-space:pre; overflow:auto; max-height:520px; padding:16px; border-radius:6px; background:#0f172a; color:#e6eef8; font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, "Roboto Mono", monospace; font-size:13px; line-height:1.45; }
    .meta { font-size:13px; color:#6b7280; margin-bottom: 12px; }
    .small { font-size:12px; color:#6b7280; }
  </style>

  <div class="container">
    <h1>Softphone XML Feed</h1>
    <p class="note">This page shows a pretty formatted XML of <strong>soft_phone_provisioning</strong>. You can download the XML or copy it to clipboard.</p>

    <div class="buttons">
      <!-- Download button uses the same route with ?download=1 -->
      <a class="btn btn-primary" href="{{ route('provisioning.softphones.xml', [], false) }}?download=1">⬇️ Download XML</a>

      <!-- Open raw XML in new tab (content-type application/xml) -->
      <a class="btn btn-ghost" href="{{ route('provisioning.softphones.xml', [], false) }}?raw=1" target="_blank">Open Raw XML</a>

      <button class="btn" id="copyBtn">📋 Copy to Clipboard</button>
    </div>

    <div class="meta">
      <span class="small">Records: {{ \App\Models\ProvisioningInfinity3065::count() }}</span>
      &nbsp; • &nbsp;
      <span class="small">Generated: {{ \Carbon\Carbon::now()->toDateTimeString() }}</span>
    </div>

    <!-- Preformatted pretty XML -->
    <pre class="xml-box" id="xmlBox">{{ $xml }}</pre>
  </div>

  <script>
    document.getElementById('copyBtn').addEventListener('click', async function () {
      const xml = document.getElementById('xmlBox').innerText;
      try {
        await navigator.clipboard.writeText(xml);
        this.textContent = '✓ Copied';
        setTimeout(() => this.textContent = '📋 Copy to Clipboard', 2000);
      } catch (e) {
        alert('Copy failed — select and copy manually');
      }
    });

    // If ?raw=1 present, return raw XML content-type instead of view.
    // (Note: handled in controller by download param; raw=1 link above opens same URL and browser may show view - you can remove raw link if not needed)
  </script>

  @endsection