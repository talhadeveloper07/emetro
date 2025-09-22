<style>
    .nav-fill .nav-item, .nav-fill>.nav-link {
        height: 60px;
    }
    .nav-fill .nav-item .nav-link, .nav-justified .nav-item .nav-link {
        width: 100%;
        height: 100%;
    }
    .select2-container{
        width: 100%;
    }
</style>
<ul class="nav nav-tabs card-header-tabs nav-fill mb-4" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('org.summary', $org->id) }}" class="nav-link {{ Route::is('org.summary') ? 'active' : '' }}" role="tab">Summary</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('org.details', $org->id) }}" class="nav-link {{ Route::is('org.details') ? 'active' : '' }}" role="tab">Details</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('org.contacts', $org->id) }}" class="nav-link {{ Route::is('org.contacts') ? 'active' : '' }}" role="tab">Contacts</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('org.document', $org->id) }}" class="nav-link {{ Route::is('org.document') ? 'active' : '' }}" role="tab">Document</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('org.notes', $org->id) }}" class="nav-link {{ Route::is('org.notes') ? 'active' : '' }}" role="tab">Notes</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('org.notifications', $org->id) }}" class="nav-link {{ Route::is('org.notifications') ? 'active' : '' }}" role="tab">Notifications</a>
    </li>
</ul>
