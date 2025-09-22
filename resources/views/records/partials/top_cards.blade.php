<style>
    .details-container {
        padding: 0.75rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.75rem;
    }
    .details-container .card {
        border: none;
        border-radius: 8px;
        height: 100%;
        width: 100%;
        box-sizing: border-box;
    }
    .details-container .card:hover {
    }
    .details-container .card-body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        height: 100%;
        box-sizing: border-box;
    }
    .details-container .icon {
        width: 32px;
        height: 32px;
        margin-bottom: 0.75rem;
        color: var(--primary-color);
    }
    .details-container .card-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.4rem;
    }
    .details-container .card-text {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 0;
        word-break: break-word;
    }
    @media (max-width: 768px) {
        .details-container {
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            padding: 0.5rem;
        }
        .details-container .card-body {
            padding: 0.75rem;
        }
        .details-container .icon {
            width: 28px;
            height: 28px;
            margin-bottom: 0.5rem;
        }
        .details-container .card-title {
            font-size: 0.8rem;
        }
        .details-container .card-text {
            font-size: 0.75rem;
        }
    }
    @media (max-width: 576px) {
        .details-container {
            grid-template-columns: 1fr;
        }
    }
    .nav-fill .nav-item, .nav-fill>.nav-link {
        height: 60px;
    }
    .nav-fill .nav-item .nav-link, .nav-justified .nav-item .nav-link {
        width: 100%;
        height: 100%;
    }
</style>
<div class="details-container mb-3 mt-1">
    <div class="card">
        <div class="card-body">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-hash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 9l14 0" /><path d="M5 15l14 0" /><path d="M11 4l-4 16" /><path d="M17 4l-4 16" /></svg>
            <h5 class="card-title">Serial Number</h5>
            <p class="card-text">{{ $record->slno }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-category"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h6v6h-6z" /><path d="M14 4h6v6h-6z" /><path d="M4 14h6v6h-6z" /><path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /></svg>
            <h5 class="card-title">Product Code</h5>
            <p class="card-text">{{ $record->productSerial?->product_code }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-packages"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" /><path d="M2 13.5v5.5l5 3" /><path d="M7 16.545l5 -3.03" /><path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" /><path d="M12 19l5 3" /><path d="M17 16.5l5 -3" /><path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5" /><path d="M7 5.03v5.455" /><path d="M12 8l5 -3" /></svg>
            <h5 class="card-title">Description</h5>
            <p class="card-text">{{ $record->productSerial?->description }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-building"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0" /><path d="M9 8l1 0" /><path d="M9 12l1 0" /><path d="M9 16l1 0" /><path d="M14 8l1 0" /><path d="M14 12l1 0" /><path d="M14 16l1 0" /><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" /></svg>
            <h5 class="card-title">Primary Organization</h5>
            <p class="card-text">{{ $record->productSerial?->org?->name }}</p>
        </div>
    </div>
    @if($record->productSerial?->secondaryOrg?->name)
    <div class="card">
        <div class="card-body">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-building"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0" /><path d="M9 8l1 0" /><path d="M9 12l1 0" /><path d="M9 16l1 0" /><path d="M14 8l1 0" /><path d="M14 12l1 0" /><path d="M14 16l1 0" /><path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16" /></svg>
            <h5 class="card-title">Secondary Organization</h5>
            <p class="card-text">{{$record->productSerial?->secondaryOrg?->name}}</p>
        </div>
    </div>
    @endif
</div>
