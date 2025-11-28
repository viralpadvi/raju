export function mountAdSlots() {
  const el = document.getElementById('ad-slot-home');
  if (!el) return;
  el.innerHTML = `
    <a href="#" class="block group">
      <div class="h-40 bg-gradient-to-r from-indigo-500 to-purple-500 rounded flex items-center justify-center text-white">
        <span class="font-semibold">Your Ad Here</span>
      </div>
    </a>
  `;
}


