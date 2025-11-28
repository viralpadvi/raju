<header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <button class="md:hidden inline-flex items-center justify-center rounded-md border px-3 py-2 text-sm" @click="sidebarOpen = true" aria-label="Open menu">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M3 6h18v2H3V6zm0 5h18v2H3v-2zm0 5h18v2H3v-2z"/></svg>
      </button>
      <a href="{{ route('admin.dashboard') }}" class="text-base sm:text-lg font-semibold tracking-tight">Admin</a>
    </div>
    <div class="flex items-center gap-3">
      <form method="GET" action="#" class="hidden sm:block">
        <label class="sr-only" for="branch-select">Branch</label>
        <select id="branch-select" class="border rounded-md px-2.5 py-1.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <option>Main Branch</option>
          <option>Branch 2</option>
        </select>
      </form>
      @auth
        <span class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
      @endauth
    </div>
  </div>
</header>


