<x-filament-panels::page>
    @php $stats = $this->getStats(); @endphp

    <style>
        .rpt-wrap { font-family: inherit; direction: rtl; }
        .rpt-period { display:flex; align-items:center; gap:10px; margin-bottom:24px; flex-wrap:wrap; }
        .rpt-period span { font-size:13px; color:#6b7280; }
        .rpt-period button { padding:6px 16px; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer; border:1px solid #e5e7eb; background:#fff; color:#4b5563; transition:all .15s; }
        .rpt-kpi-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:14px; margin-bottom:24px; }
        .rpt-kpi-card { background:#fff; border-radius:12px; padding:18px; box-shadow:0 1px 3px rgba(0,0,0,.08); display:flex; align-items:flex-start; gap:14px; }
        .rpt-kpi-icon { width:44px; height:44px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .rpt-kpi-label { font-size:11px; color:#9ca3af; margin-bottom:2px; }
        .rpt-kpi-val { font-size:22px; font-weight:700; color:#111827; line-height:1.2; }
        .rpt-kpi-unit { font-size:11px; color:#9ca3af; }
        .rpt-two-col { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
        @media(max-width:900px){ .rpt-two-col { grid-template-columns:1fr; } }
        .rpt-card { background:#fff; border-radius:14px; padding:22px; box-shadow:0 1px 3px rgba(0,0,0,.08); }
        .rpt-card-title { font-size:13px; font-weight:600; color:#374151; margin-bottom:16px; }
        .rpt-chart { display:flex; align-items:flex-end; gap:2px; height:100px; margin-bottom:8px; }
        .rpt-chart-bar { flex:1; border-radius:3px 3px 0 0; background:rgba(99,102,241,.55); min-height:2px; transition:background .15s; }
        .rpt-chart-bar:hover { background:rgba(99,102,241,.9); }
        .rpt-chart-labels { display:flex; justify-content:space-between; font-size:11px; color:#9ca3af; }
        .rpt-artist-row { display:flex; align-items:center; gap:10px; margin-bottom:12px; }
        .rpt-artist-rank { width:24px; height:24px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex-shrink:0; }
        .rpt-artist-bar-wrap { flex:1; background:#f3f4f6; border-radius:4px; height:5px; margin-top:3px; }
        .rpt-artist-bar { height:5px; border-radius:4px; background:#6366f1; }
        .rpt-tx-table { width:100%; border-collapse:collapse; font-size:13px; }
        .rpt-tx-table th { padding:0 8px 10px; text-align:right; font-weight:500; color:#9ca3af; font-size:11px; border-bottom:1px solid #f3f4f6; }
        .rpt-tx-table td { padding:10px 8px; border-bottom:1px solid #f9fafb; color:#374151; }
        .rpt-badge { display:inline-flex; padding:2px 8px; border-radius:99px; font-size:11px; font-weight:500; }
        .rpt-full { grid-column:1/-1; }
        .rpt-header-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
        .rpt-link { font-size:12px; color:#818cf8; text-decoration:none; }
        .rpt-link:hover { text-decoration:underline; }
        .rpt-empty { text-align:center; padding:32px 0; color:#9ca3af; font-size:13px; }
        .rpt-artist-name { font-size:13px; font-weight:500; color:#1f2937; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .rpt-artist-num { font-size:12px; font-weight:700; color:#1f2937; }
        .rpt-artist-sub { font-size:11px; color:#9ca3af; }

        /* ── Dark mode ── */
        .dark .rpt-period button { background:#1f2937; color:#d1d5db; border-color:#374151; }
        .dark .rpt-kpi-card { background:#1f2937; box-shadow:0 1px 3px rgba(0,0,0,.4); }
        .dark .rpt-kpi-val { color:#f9fafb; }
        .dark .rpt-card { background:#1f2937; box-shadow:0 1px 3px rgba(0,0,0,.4); }
        .dark .rpt-card-title { color:#e5e7eb; }
        .dark .rpt-tx-table th { color:#6b7280; border-bottom-color:#374151; }
        .dark .rpt-tx-table td { color:#d1d5db; border-bottom-color:#111827; }
        .dark .rpt-artist-name { color:#f3f4f6; }
        .dark .rpt-artist-num { color:#f3f4f6; }
        .dark .rpt-artist-bar-wrap { background:#374151; }
        .dark .rpt-period span { color:#9ca3af; }
    </style>

    <div class="rpt-wrap">

        {{-- Period Selector --}}
        <div class="rpt-period">
            <span>بازه زمانی:</span>
            @foreach(['7' => '۷ روز', '30' => '۳۰ روز', '90' => '۳ ماه', '365' => '۱ سال'] as $val => $label)
            <button wire:click="$set('period', '{{ $val }}')"
                    style="{{ $period == $val ? 'background:#6366f1;color:#fff;border-color:#6366f1' : '' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>

        {{-- KPI Cards --}}
        @php
        $kpis = [
            ['label'=>'کل شارژها',        'value'=>number_format($stats['totalDeposits']),        'unit'=>'تومان', 'bg'=>'#d1fae5', 'ic'=>'#059669', 'path'=>'M12 4.5v15m7.5-7.5h-15'],
            ['label'=>'کل برداشت‌ها',     'value'=>number_format($stats['totalWithdrawals']),     'unit'=>'تومان', 'bg'=>'#fee2e2', 'ic'=>'#dc2626', 'path'=>'M19.5 12h-15'],
            ['label'=>'کمیسیون پلتفرم',   'value'=>number_format($stats['totalCommission']),     'unit'=>'تومان', 'bg'=>'#dbeafe', 'ic'=>'#2563eb', 'path'=>'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9'],
            ['label'=>'درآمد هنرمندان',   'value'=>number_format($stats['artistEarnings']),      'unit'=>'تومان', 'bg'=>'#ede9fe', 'ic'=>'#7c3aed', 'path'=>'M9 9l10.5-3m0 6.553v3.75a2.25 2.25 0 01-1.632 2.163l-1.32.377a1.803 1.803 0 11-.99-3.467l2.31-.66a2.25 2.25 0 001.632-2.163zm0 0V2.25L9 5.25v10.303'],
            ['label'=>'تعداد فروش',       'value'=>number_format($stats['salesCount']),          'unit'=>'عدد',   'bg'=>'#fef3c7', 'ic'=>'#d97706', 'path'=>'M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75'],
            ['label'=>'کاربران جدید',     'value'=>number_format($stats['newUsers']),            'unit'=>'نفر',   'bg'=>'#cffafe', 'ic'=>'#0891b2', 'path'=>'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07'],
            ['label'=>'تراکنش در انتظار','value'=>number_format($stats['pendingTransactions']),  'unit'=>'عدد',   'bg'=>'#ffedd5', 'ic'=>'#ea580c', 'path'=>'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];
        @endphp
        <div class="rpt-kpi-grid">
            @foreach($kpis as $kpi)
            <div class="rpt-kpi-card">
                <div class="rpt-kpi-icon" style="background:{{ $kpi['bg'] }}">
                    <svg width="20" height="20" style="color:{{ $kpi['ic'] }}" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $kpi['path'] }}"/>
                    </svg>
                </div>
                <div>
                    <div class="rpt-kpi-label">{{ $kpi['label'] }}</div>
                    <div class="rpt-kpi-val">{{ $kpi['value'] }}</div>
                    <div class="rpt-kpi-unit">{{ $kpi['unit'] }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="rpt-two-col">

            {{-- Daily Revenue Chart --}}
            <div class="rpt-card">
                <div class="rpt-card-title">نمودار شارژ روزانه (۳۰ روز)</div>
                @php
                    $chartData = [];
                    for ($i = 29; $i >= 0; $i--) {
                        $date = now()->subDays($i)->format('Y-m-d');
                        $chartData[] = ['date' => now()->subDays($i)->format('m/d'), 'val' => $stats['dailyRevenue'][$date] ?? 0];
                    }
                    $maxVal = max(array_column($chartData, 'val') ?: [1]);
                @endphp
                <div class="rpt-chart">
                    @foreach($chartData as $item)
                    @php $h = $maxVal > 0 ? max(2, round(($item['val']/$maxVal)*100)) : 2; @endphp
                    <div class="rpt-chart-bar" style="height:{{ $h }}%"
                         title="{{ $item['date'] }}: {{ number_format($item['val']) }} تومان"></div>
                    @endforeach
                </div>
                <div class="rpt-chart-labels">
                    <span>۳۰ روز پیش</span>
                    <span>امروز</span>
                </div>
            </div>

            {{-- Top Artists --}}
            <div class="rpt-card">
                <div class="rpt-card-title">برترین هنرمندان (فروش)</div>
                @if($stats['topArtists']->isEmpty())
                <div class="rpt-empty">هنوز فروشی ثبت نشده</div>
                @else
                @php $maxS = $stats['topArtists']->first()?->total_sales ?? 1; @endphp
                @foreach($stats['topArtists'] as $i => $artist)
                <div class="rpt-artist-row">
                    <div class="rpt-artist-rank"
                         style="{{ $i===0 ? 'background:#fbbf24;color:#fff' : ($i===1 ? 'background:#d1d5db;color:#374151' : ($i===2 ? 'background:#fb923c;color:#fff' : 'background:#f3f4f6;color:#6b7280')) }}">
                        {{ $i+1 }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div class="rpt-artist-name">{{ $artist->seller?->name ?? 'کاربر #'.$artist->seller_id }}</div>
                        <div class="rpt-artist-bar-wrap">
                            <div class="rpt-artist-bar" style="width:{{ $maxS>0 ? round($artist->total_sales/$maxS*100) : 0 }}%"></div>
                        </div>
                    </div>
                    <div style="text-align:left;flex-shrink:0;padding-right:4px;">
                        <div class="rpt-artist-num">{{ number_format($artist->total_sales) }}</div>
                        <div class="rpt-artist-sub">{{ $artist->sales_count }} فروش</div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>

            {{-- Recent Transactions --}}
            <div class="rpt-card rpt-full">
                <div class="rpt-header-row">
                    <div class="rpt-card-title" style="margin-bottom:0">آخرین تراکنش‌های کیف پول</div>
                    <a href="{{ route('filament.admin.resources.wallet-transactions.index') }}" class="rpt-link">مشاهده همه</a>
                </div>
                @php
                $recentTx = \App\Models\WalletTransaction::with('wallet.user')->latest()->limit(8)->get();
                @endphp
                <div style="overflow-x:auto;margin-top:12px;">
                    <table class="rpt-tx-table">
                        <thead>
                            <tr>
                                <th>کاربر</th>
                                <th>نوع</th>
                                <th>مبلغ</th>
                                <th>وضعیت</th>
                                <th>تاریخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTx as $tx)
                            <tr>
                                <td>{{ $tx->wallet?->user?->name ?? '—' }}</td>
                                <td>
                                    <span class="rpt-badge" style="{{ $tx->type==='deposit' ? 'background:#d1fae5;color:#065f46' : ($tx->type==='purchase' ? 'background:#ede9fe;color:#5b21b6' : 'background:#fee2e2;color:#991b1b') }}">
                                        {{ $tx->type==='deposit' ? 'شارژ' : ($tx->type==='withdrawal' ? 'برداشت' : ($tx->type==='purchase' ? 'خرید' : 'درآمد')) }}
                                    </span>
                                </td>
                                <td style="font-weight:600;">{{ number_format($tx->amount) }}</td>
                                <td>
                                    <span class="rpt-badge" style="{{ $tx->status==='approved' ? 'background:#d1fae5;color:#065f46' : ($tx->status==='pending' ? 'background:#fef3c7;color:#92400e' : 'background:#fee2e2;color:#991b1b') }}">
                                        {{ $tx->status==='approved' ? 'تایید' : ($tx->status==='pending' ? 'انتظار' : 'رد') }}
                                    </span>
                                </td>
                                <td style="font-size:12px;color:#9ca3af;">{{ $tx->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-filament-panels::page>
