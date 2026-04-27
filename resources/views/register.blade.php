@extends('layouts.app')
@section('title', 'Book Appointment - DENTAL EASE')

@section('content')
<nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-cyan-500 rounded-xl flex items-center justify-center shadow-lg shadow-cyan-200 group-hover:rotate-6 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <span class="font-display text-xl sm:text-2xl font-black tracking-tight text-gray-900 uppercase">
                    Dental <span class="text-cyan-500">Ease</span>
                </span>
            </a>
            <div class="hidden md:flex items-center gap-12">
                <a href="{{ route('get-started') }}" class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 hover:text-cyan-500 transition-colors font-display">← Back</a>
                <a href="{{ route('login') }}" class="bg-slate-900 text-white text-xs font-black uppercase tracking-[0.2em] px-8 py-3 rounded-xl hover:bg-cyan-500 transition-all shadow-lg shadow-slate-200 font-display">Log In</a>
            </div>
        </div>
    </div>
</nav>

<div class="min-h-[calc(100vh-80px)] bg-gradient-to-b from-cyan-50 via-white to-slate-50 flex items-center justify-center px-4 py-12 relative overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-from)_0%,_transparent_70%)] from-cyan-100/40 to-transparent -z-10"></div>

    <div class="bg-white/70 backdrop-blur-xl border border-white shadow-2xl shadow-cyan-200/50 rounded-[2.5rem] w-full max-w-lg p-8 md:p-10 relative">
        <div class="text-center mb-8">
            <span class="text-cyan-600 text-[10px] uppercase tracking-[0.3em] font-black">Instant Scheduling</span>
            <h1 class="font-display text-3xl font-black text-slate-900 mt-2 uppercase tracking-tight">Secure Your <span class="text-cyan-500">Slot</span></h1>
            <p class="text-slate-400 text-sm mt-2 font-medium">Please provide your details to proceed with booking.</p>
        </div>

        <form action="/go-calendar" method="POST" id="booking-form" class="space-y-4">
            @csrf

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Patient Full Name</label>
                <input type="text" name="name" placeholder="John Doe" required
                    class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Contact Email</label>
                    <input type="email" name="email" placeholder="hello@example.com" required
                        class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Phone Number</label>
                    <input type="tel" name="phone" placeholder="0912 345 6789" required
                        class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Select Clinic</label>
                    <div class="relative">
                        <select name="clinic" required class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium appearance-none">
                            <option value="" disabled selected>Choose Clinic</option>
                            <option value="smile-central">Smile Central</option>
                            <option value="elite-care">Elite Care</option>
                            <option value="white-pearly">White Pearly</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Service Type</label>
                    <div class="relative">
                        <select name="service" required class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium appearance-none">
                            <option value="checkup">Checkup</option>
                            <option value="cleaning">Cleaning</option>
                            <option value="consultation">Consultation</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative pt-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Appointment Date</label>
                <div class="relative group">
                    <input type="text" id="date-display" readonly placeholder="Pick a date" 
                        class="w-full bg-white border border-slate-100 rounded-xl px-4 py-3 pr-16 text-sm focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none font-medium cursor-pointer">
                    
                    <input type="hidden" name="date" id="selected-date" required>
                    
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center gap-2">
                        <button type="button" id="btn-clear-date" class="hidden hover:bg-red-50 p-1 rounded-md text-red-400 transition-all active:scale-90" title="Clear Date">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <div class="text-cyan-500 pointer-events-none border-l border-slate-100 pl-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                </div>

                <div id="calendar-popover" class="absolute bottom-full left-0 sm:left-auto sm:right-0 mb-4 bg-white border border-slate-100 rounded-2xl p-3 shadow-[0_-15px_40px_rgba(0,0,0,0.12)] z-50 hidden animate-in fade-in slide-in-from-bottom-2 duration-200 w-full sm:w-64">
                    
                    <div class="flex items-center justify-between mb-2 gap-1 px-1">
                        <select id="month-select" class="bg-slate-50 border-none text-[9px] font-black text-slate-800 uppercase tracking-tight rounded-lg px-1 py-1 outline-none focus:ring-1 focus:ring-cyan-500 cursor-pointer flex-grow"></select>
                        <select id="year-select" class="bg-slate-50 border-none text-[9px] font-black text-slate-800 uppercase tracking-tight rounded-lg px-1 py-1 outline-none focus:ring-1 focus:ring-cyan-500 cursor-pointer w-16"></select>
                    </div>

                    <div class="grid grid-cols-7 mb-1 text-center border-b border-slate-50 pb-1">
                        @foreach(['S','M','T','W','T','F','S'] as $day)
                        <div class="text-[7px] font-black text-slate-300 uppercase py-1">{{ $day }}</div>
                        @endforeach
                    </div>

                    <div id="calendar-days" class="grid grid-cols-7 gap-0.5"></div>
                    
                    <button type="button" onclick="document.getElementById('calendar-popover').classList.add('hidden')" class="w-full mt-2 text-[8px] font-black uppercase text-slate-300 hover:text-cyan-500 transition-colors tracking-tighter">
                        Close
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-black py-4 rounded-2xl text-sm shadow-xl shadow-cyan-200/50 transition-all hover:-translate-y-1 active:scale-95 font-display tracking-widest uppercase">
                Submit Booking
            </button>
        </form>

        <p class="text-center text-[10px] font-bold uppercase tracking-[0.2em] text-slate-300 mt-8">
            Step 1 of 2: Information Entry
        </p>
    </div>
</div>

<script>
(function () {
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    let current = new Date(today.getFullYear(), today.getMonth(), 1);
    let selectedDateStr = null;

    const popover = document.getElementById('calendar-popover');
    const dateInput = document.getElementById('date-display');
    const clearBtn = document.getElementById('btn-clear-date');
    const hiddenDate = document.getElementById('selected-date');
    const monthSelect = document.getElementById('month-select');
    const yearSelect = document.getElementById('year-select');

    const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];

    // Initialize Select Options
    monthNames.forEach((m, i) => {
        let opt = new Option(m.toUpperCase(), i);
        monthSelect.add(opt);
    });

    const startYear = today.getFullYear();
    for(let i=startYear; i<=startYear+5; i++) {
        let opt = new Option(i, i);
        yearSelect.add(opt);
    }

    // Toggle Popover
    dateInput.onclick = (e) => { 
        e.stopPropagation(); 
        popover.classList.toggle('hidden'); 
        renderCalendar(); 
    };

    // Functional Clear Logic
    clearBtn.onclick = (e) => {
        e.stopPropagation(); // Prevents calendar from opening when clearing
        selectedDateStr = null;
        hiddenDate.value = "";
        dateInput.value = "";
        clearBtn.classList.add('hidden');
        renderCalendar();
    };

    // Close on Outside Click
    document.onclick = (e) => { 
        if (!popover.contains(e.target) && e.target !== dateInput) {
            popover.classList.add('hidden'); 
        }
    };

    // Handle Dropdown Changes
    monthSelect.onchange = () => { 
        current.setMonth(parseInt(monthSelect.value)); 
        renderCalendar(); 
    };
    yearSelect.onchange = () => { 
        current.setFullYear(parseInt(yearSelect.value)); 
        renderCalendar(); 
    };

    function pad(n) { return String(n).padStart(2, '0'); }

    function renderCalendar() {
        const grid  = document.getElementById('calendar-days');
        
        // Sync selects
        monthSelect.value = current.getMonth();
        yearSelect.value = current.getFullYear();

        grid.innerHTML = '';
        const firstDay = new Date(current.getFullYear(), current.getMonth(), 1).getDay();
        const daysInMonth = new Date(current.getFullYear(), current.getMonth() + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) grid.appendChild(document.createElement('div'));

        for (let d = 1; d <= daysInMonth; d++) {
            const cellDate = new Date(current.getFullYear(), current.getMonth(), d);
            const isPast = cellDate < today;
            const dateStr = current.getFullYear() + '-' + pad(current.getMonth() + 1) + '-' + pad(d);
            
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = d;
            
            const isSelected = selectedDateStr === dateStr;
            btn.className = `w-full aspect-square flex items-center justify-center rounded-lg text-[10px] font-bold transition-all ${isPast ? 'text-slate-200 cursor-not-allowed' : isSelected ? 'bg-cyan-500 text-white shadow-md' : 'text-slate-600 hover:bg-cyan-50 hover:text-cyan-600'}`;

            if (!isPast) {
                btn.onclick = () => {
                    selectedDateStr = dateStr;
                    hiddenDate.value = dateStr;
                    dateInput.value = cellDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    clearBtn.classList.remove('hidden'); // Show clear button when selected
                    popover.classList.add('hidden');
                    renderCalendar();
                };
            } else {
                btn.disabled = true;
            }
            grid.appendChild(btn);
        }
    }
})();
</script>
@endsection