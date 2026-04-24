<div class="row">
    <div class="col-md-4">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="ri-window-line ri-2x me-3"></i>
                <div>
                    <h5 class="card-title mb-0">{{ $stats['sites_count'] }}</h5>
                    <p class="card-text">Total Sites</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="ri-user-line ri-2x me-3"></i>
                <div>
                    <h5 class="card-title mb-0">{{ $stats['users_count'] }}</h5>
                    <p class="card-text">Total Users</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4 {{ $stats['api_status'] == 'Online' ? 'bg-info text-white' : 'bg-danger text-white' }}">
            <div class="card-body d-flex align-items-center">
                <i class="ri-signal-tower-line ri-2x me-3"></i>
                <div>
                    <h5 class="card-title mb-0">{{ $stats['api_status'] }}</h5>
                    <p class="card-text">API Connectivity</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Webpanel Configuration</h5>
        <span class="badge bg-soft-primary text-primary">v1.1.0</span>
    </div>
    <div class="card-body">
        <p>This extension is correctly connected to the KantumHost API. You can manage sites and users directly from
            Pelarena.</p>
        <div class="alert alert-info">
            <i class="ri-information-line me-2"></i>
            The API now supports advanced filtering for better performance.
        </div>
    </div>
</div>