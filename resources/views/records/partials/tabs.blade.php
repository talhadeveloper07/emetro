

<ul class="nav nav-tabs card-header-tabs nav-fill mb-4" data-bs-toggle="tabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('records.details', $record->slno) }}" class="nav-link {{ Route::currentRouteName() == 'records.details' ? 'active' : '' }}" role="tab">Details</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('records.customer_information', $record->slno) }}" class="nav-link {{ Route::currentRouteName() == 'records.customer_information' ? 'active' : '' }}" role="tab">Customer Information</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('records.sip_trunks', $record->slno) }}" class="nav-link {{ Route::currentRouteName() == 'records.sip_trunks' ? 'active' : '' }}" role="tab">Sip Trunks</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('records.inventory', $record->slno) }}" class="nav-link {{ Route::currentRouteName() == 'records.inventory' ? 'active' : '' }}" role="tab">Inventory</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('records.history', $record->slno) }}" class="nav-link {{ Route::currentRouteName() == 'records.history' ? 'active' : '' }}" role="tab">History</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('records.notes', $record->slno) }}" class="nav-link {{ Route::currentRouteName() == 'records.notes' ? 'active' : '' }}" role="tab">Notes</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('records.backup', $record->slno) }}" class="nav-link {{ Route::currentRouteName() == 'records.backup' ? 'active' : '' }}" role="tab">Backup</a>
    </li>
</ul>
