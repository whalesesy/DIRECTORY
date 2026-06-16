@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8 animate-slide-up">
    <div>
        <h2 class="text-3xl font-black text-kisii-blue tracking-tight">System Overview</h2>
        <p class="text-sm text-kisii-text-muted mt-1">Manage Kisii County directory records, staff members, and hotlines.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white rounded-3xl border border-kisii-border p-6 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-kisii-text-muted uppercase tracking-wider">Departments</p>
                <p id="departments-count" class="text-4xl font-black text-kisii-blue mt-1 transition-all duration-300 transform">{{ $stats['departments_count'] }}</p>
            </div>
            <span class="text-3xl p-4 bg-kisii-blue/10 rounded-2xl text-kisii-blue">🏢</span>
        </div>

        <div class="bg-white rounded-3xl border border-kisii-border p-6 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-kisii-text-muted uppercase tracking-wider">Staff Contacts</p>
                <p id="staff-count" class="text-4xl font-black text-kisii-green mt-1 transition-all duration-300 transform">{{ $stats['staff_count'] }}</p>
            </div>
            <span class="text-3xl p-4 bg-kisii-green/10 rounded-2xl text-kisii-green">👥</span>
        </div>

        <div class="bg-white rounded-3xl border border-kisii-border p-6 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-kisii-text-muted uppercase tracking-wider">County Lines</p>
                <p id="county-lines-count" class="text-4xl font-black text-kisii-gold mt-1 transition-all duration-300 transform">{{ $stats['county_lines_count'] }}</p>
            </div>
            <span class="text-3xl p-4 bg-kisii-gold/10 rounded-2xl text-kisii-gold">📞</span>
        </div>
    </div>

    <!-- Quick Actions & Recent Additions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Quick Actions -->
        <div class="bg-white rounded-3xl border border-kisii-border p-6 shadow-sm space-y-4">
            <h3 class="text-lg font-bold text-kisii-blue">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.departments.create') }}" class="p-4 bg-kisii-blue/5 hover:bg-kisii-blue/10 rounded-2xl border border-kisii-blue/10 text-center font-bold text-sm text-kisii-blue transition-all">
                    + New Department
                </a>
                <a href="{{ route('admin.staff.create') }}" class="p-4 bg-kisii-green/5 hover:bg-kisii-green/10 rounded-2xl border border-kisii-green/10 text-center font-bold text-sm text-kisii-green transition-all">
                    + New Staff Member
                </a>
                <a href="{{ route('admin.county-lines.create') }}" class="p-4 bg-kisii-gold/5 hover:bg-kisii-gold/10 rounded-2xl border border-kisii-gold/10 text-center font-bold text-sm text-kisii-gold transition-all">
                    + New Hotline
                </a>
                <a href="{{ route('admin.staff.index') }}" class="p-4 bg-slate-50 hover:bg-slate-100 rounded-2xl border border-slate-200 text-center font-bold text-sm text-slate-700 transition-all">
                    View All Staff
                </a>
            </div>
        </div>

        <!-- Recent Additions -->
        <div class="bg-white rounded-3xl border border-kisii-border p-6 shadow-sm space-y-4">
            <h3 class="text-lg font-bold text-kisii-blue">Recently Added Staff</h3>
            <div id="recent-staff-list">
                @if($recentStaff->count() > 0)
                    <div class="divide-y divide-kisii-border">
                        @foreach($recentStaff as $staff)
                            <div class="py-3 flex items-center justify-between first:pt-0 last:pb-0">
                                <div>
                                    <p class="font-bold text-sm">{{ $staff->name }}</p>
                                    <p class="text-xs text-kisii-text-muted">{{ $staff->role }} &bull; {{ $staff->department->name }}</p>
                                </div>
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                                    Ext: {{ $staff->ext ?? 'None' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-kisii-text-muted">No staff members found.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        function fetchUpdates() {
            fetch("{{ route('admin.dashboard.updates') }}")
                .then(response => response.json())
                .then(data => {
                    updateCount('departments-count', data.stats.departments_count);
                    updateCount('staff-count', data.stats.staff_count);
                    updateCount('county-lines-count', data.stats.county_lines_count);
                    updateRecentStaff(data.recentStaff);
                })
                .catch(err => console.error("Error fetching dashboard updates:", err));
        }

        // Poll every 5 seconds
        setInterval(fetchUpdates, 5000);

        function updateCount(id, newValue) {
            const el = document.getElementById(id);
            if (el && el.innerText != newValue) {
                el.innerText = newValue;
                el.classList.add('scale-110', 'text-kisii-gold');
                setTimeout(() => {
                    el.classList.remove('scale-110', 'text-kisii-gold');
                }, 300);
            }
        }

        function updateRecentStaff(staffList) {
            const container = document.getElementById('recent-staff-list');
            if (!container) return;

            if (staffList.length === 0) {
                container.innerHTML = '<p class="text-sm text-kisii-text-muted">No staff members found.</p>';
                return;
            }

            let html = '<div class="divide-y divide-kisii-border">';
            staffList.forEach(staff => {
                html += `
                    <div class="py-3 flex items-center justify-between first:pt-0 last:pb-0">
                        <div>
                            <p class="font-bold text-sm">${staff.name}</p>
                            <p class="text-xs text-kisii-text-muted">${staff.role} &bull; ${staff.department}</p>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                            Ext: ${staff.ext}
                        </span>
                    </div>
                `;
            });
            html += '</div>';
            container.innerHTML = html;
        }
    });
</script>
@endsection
