<template>
  <!-- Background modern dengan efek glow ambient -->
  <div class="min-h-screen bg-slate-950 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-emerald-900/20 via-slate-950 to-slate-950 text-slate-300 font-sans flex overflow-hidden">
    
    <!-- FLOATING SIDEBAR (Kiri) -->
    <aside class="w-20 lg:w-72 m-4 md:m-6 bg-slate-900/40 backdrop-blur-xl border border-slate-700/50 rounded-3xl flex flex-col transition-all duration-300 z-20 shadow-2xl overflow-hidden relative">
      <!-- Efek garis neon di pinggir sidebar -->
      <div class="absolute left-0 top-0 bottom-0 w-[1px] bg-gradient-to-b from-transparent via-emerald-500/50 to-transparent"></div>

      <!-- Logo -->
      <div class="h-24 flex items-center justify-center lg:justify-start lg:px-8 border-b border-slate-800/50">
        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center text-slate-950 text-xl shadow-[0_0_15px_rgba(16,185,129,0.4)]">
          ♻️
        </div>
        <div class="hidden lg:block ml-4">
          <h2 class="text-xl font-bold text-white tracking-wide">E-Waste</h2>
          <p class="text-[10px] text-emerald-400 tracking-widest uppercase font-mono">Wanajaya Control</p>
        </div>
      </div>

      <!-- Navigasi -->
      <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto hide-scrollbar">
        <a href="#" class="group relative flex items-center gap-4 px-3 lg:px-5 py-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 transition-all">
          <div class="absolute inset-0 bg-emerald-400/5 rounded-2xl blur-md group-hover:opacity-100 transition-opacity"></div>
          <span class="text-2xl relative z-10">🌍</span>
          <span class="font-bold hidden lg:block relative z-10">Overview</span>
        </a>
        <a href="/admin/news/create" class="group flex items-center gap-4 px-3 lg:px-5 py-4 rounded-2xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
          <span class="text-2xl opacity-70 group-hover:opacity-100 group-hover:scale-110 transition-all">📰</span>
          <span class="font-medium hidden lg:block">Kelola Berita</span>
        </a>
        <a href="/admin/pemdes/create" class="group flex items-center gap-4 px-3 lg:px-5 py-4 rounded-2xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
          <span class="text-2xl opacity-70 group-hover:opacity-100 group-hover:scale-110 transition-all">👔</span>
          <span class="font-medium hidden lg:block">Kelola Pemdes</span>
        </a>
        <a href="/admin/fasilitas/create" class="group flex items-center gap-4 px-3 lg:px-5 py-4 rounded-2xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
          <span class="text-2xl opacity-70 group-hover:opacity-100 group-hover:scale-110 transition-all">🏢</span>
          <span class="font-medium hidden lg:block">Kelola Fasilitas</span>
        </a>
        <a href="#" class="group flex items-center gap-4 px-3 lg:px-5 py-4 rounded-2xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
          <span class="text-2xl opacity-70 group-hover:opacity-100 group-hover:scale-110 transition-all">👥</span>
          <span class="font-medium hidden lg:block">Warga & Nasabah</span>
        </a>
        <a href="#" class="group flex items-center gap-4 px-3 lg:px-5 py-4 rounded-2xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
          <span class="text-2xl opacity-70 group-hover:opacity-100 group-hover:scale-110 transition-all">⚖️</span>
          <span class="font-medium hidden lg:block">Timbang Sampah</span>
        </a>
        <a href="#" class="group flex items-center gap-4 px-3 lg:px-5 py-4 rounded-2xl hover:bg-slate-800/50 text-slate-400 hover:text-white transition-all">
          <span class="text-2xl opacity-70 group-hover:opacity-100 group-hover:scale-110 transition-all">💸</span>
          <span class="font-medium hidden lg:block">Pencairan Kas</span>
        </a>
      </nav>

      <!-- Profil & Logout -->
      <div class="p-4 border-t border-slate-800/50">
        <div class="flex items-center justify-center lg:justify-between p-2 rounded-2xl bg-slate-950/50 border border-slate-800">
          <div class="hidden lg:flex items-center gap-3 pl-2">
            <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-xs font-bold text-emerald-400 border border-emerald-500/30">
              A
            </div>
            <div>
              <p class="text-xs font-bold text-white leading-none">Admin KKN</p>
              <p class="text-[10px] text-slate-500 mt-1">Online</p>
            </div>
          </div>
          <button @click="simulasiLogout" class="w-10 h-10 rounded-xl bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white flex items-center justify-center transition-all group" title="Logout">
            <span class="group-hover:translate-x-1 transition-transform">🚪</span>
          </button>
        </div>
      </div>
    </aside>

    <!-- MAIN CONTENT SPACE -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto hide-scrollbar scroll-smooth relative">
      
      <!-- Top Actions (Search & Notification) -->
      <header class="h-24 px-6 md:px-10 flex items-center justify-between sticky top-0 z-10 bg-gradient-to-b from-slate-950 to-transparent">
        <div>
          <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight">Overview</h1>
          <p class="text-sm text-slate-400 flex items-center gap-2 mt-1">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Live Data Wanajaya
          </p>
        </div>
        
        <div class="flex items-center gap-4">
          <a href="/admin/news/create" class="px-5 py-2.5 rounded-full bg-slate-800/50 border border-slate-700 text-white font-bold hover:bg-slate-700 hover:border-slate-500 transition-all flex items-center gap-2">
            <span>📝</span> <span class="hidden md:inline">Tulis Berita</span>
          </a>
          <button class="px-5 py-2.5 rounded-full bg-emerald-500 text-slate-950 font-bold hover:bg-emerald-400 hover:shadow-[0_0_20px_rgba(16,185,129,0.3)] transition-all flex items-center gap-2">
            <span>+</span> <span class="hidden md:inline">Transaksi Baru</span>
          </button>
        </div>
      </header>

      <!-- BENTO GRID DASHBOARD -->
      <div class="p-6 md:p-10 pt-0 grid grid-cols-1 md:grid-cols-12 gap-6 auto-rows-min pb-24">
        
        <!-- CARD 1: Saldo Utama (Lebar & Menonjol) -->
        <div class="col-span-1 md:col-span-8 bg-gradient-to-br from-emerald-900/40 to-slate-900/60 backdrop-blur-md border border-emerald-500/20 rounded-3xl p-8 relative overflow-hidden group">
          <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 group-hover:scale-110 transition-all duration-700">
            <span class="text-9xl font-black italic">Rp</span>
          </div>
          <p class="text-emerald-400 font-mono text-sm tracking-widest uppercase mb-2">Total Kas Sampah Desa</p>
          <h3 class="text-5xl md:text-6xl font-black text-white mb-6">2.450<span class="text-3xl text-slate-500">.000</span></h3>
          
          <div class="flex gap-4">
            <div class="bg-slate-950/50 border border-slate-700/50 rounded-2xl p-4 flex-1">
              <p class="text-xs text-slate-400 mb-1">Masuk Bulan Ini</p>
              <p class="text-lg font-bold text-emerald-400">+ Rp 450.000</p>
            </div>
            <div class="bg-slate-950/50 border border-slate-700/50 rounded-2xl p-4 flex-1">
              <p class="text-xs text-slate-400 mb-1">Pencairan Tertunda</p>
              <p class="text-lg font-bold text-orange-400">- Rp 120.000</p>
            </div>
          </div>
        </div>

        <!-- CARD 2: Mini Stat Nasabah -->
        <div class="col-span-1 md:col-span-4 bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8 flex flex-col justify-between hover:border-slate-600 transition-colors">
          <div class="flex justify-between items-start">
            <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-400 flex items-center justify-center text-2xl border border-blue-500/20">👥</div>
            <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 text-xs font-bold">+12 Mgg ini</span>
          </div>
          <div>
            <h3 class="text-4xl font-black text-white mt-6">124</h3>
            <p class="text-slate-400 mt-1">Total Nasabah Aktif</p>
          </div>
        </div>

        <!-- CARD 3: Volume Sampah -->
        <div class="col-span-1 md:col-span-4 bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8 hover:border-slate-600 transition-colors">
           <div class="flex justify-between items-start mb-6">
            <div class="w-12 h-12 rounded-2xl bg-orange-500/10 text-orange-400 flex items-center justify-center text-2xl border border-orange-500/20">⚖️</div>
            <span class="text-slate-500 text-sm">Bulan Juli 2026</span>
          </div>
          <h3 class="text-4xl font-black text-white flex items-baseline gap-2">458.5 <span class="text-lg text-slate-500 font-medium">Kg</span></h3>
          
          <!-- Progress bar dummy -->
          <div class="mt-6 w-full bg-slate-800 rounded-full h-2 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-yellow-400 h-2 rounded-full w-[70%]"></div>
          </div>
          <p class="text-xs text-slate-500 mt-3 text-right">Target: 600 Kg</p>
        </div>

        <!-- CARD 4: Aktivitas Terkini (Timeline) -->
        <div class="col-span-1 md:col-span-8 bg-slate-900/40 backdrop-blur-md border border-slate-700/50 rounded-3xl p-8">
          <div class="flex justify-between items-center mb-8">
            <h3 class="text-lg font-bold text-white">Log Aktivitas Terkini</h3>
            <button class="text-sm text-emerald-400 hover:text-emerald-300">Lihat Semua →</button>
          </div>
          
          <!-- Timeline Items -->
          <div class="space-y-6 relative before:absolute before:inset-0 before:ml-[1.1rem] before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-700 before:to-transparent">
            
            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
              <!-- Icon -->
              <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-slate-950 bg-emerald-500 text-slate-950 shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow-[0_0_10px_rgba(16,185,129,0.5)] z-10">
                <span class="text-sm font-black">+</span>
              </div>
              <!-- Content -->
              <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-slate-950/50 border border-slate-800 p-4 rounded-2xl hover:border-emerald-500/30 transition-colors">
                <div class="flex items-center justify-between mb-1">
                  <h4 class="font-bold text-white text-sm">Pak Budi (RT 02)</h4>
                  <span class="text-xs text-emerald-400 font-mono">10 mnt lalu</span>
                </div>
                <p class="text-xs text-slate-400">Setor 5.2 Kg Plastik & 2 Kg Logam.</p>
              </div>
            </div>

            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
              <!-- Icon -->
              <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-slate-950 bg-slate-800 text-slate-400 shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                <span class="text-sm">💸</span>
              </div>
              <!-- Content -->
              <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-slate-950/50 border border-slate-800 p-4 rounded-2xl">
                <div class="flex items-center justify-between mb-1">
                  <h4 class="font-bold text-white text-sm">Ibu Siti (RT 01)</h4>
                  <span class="text-xs text-slate-500 font-mono">2 jam lalu</span>
                </div>
                <p class="text-xs text-slate-400">Pencairan saldo sebesar Rp 50.000.</p>
              </div>
            </div>

          </div>
        </div>

      </div>
    </main>
  </div>
</template>

<script setup>
const simulasiLogout = () => {
  alert("Keluar dari Portal Wanajaya...");
  window.location.href = '/';
};
</script>

<style scoped>
/* Biar scrollbar ilang tapi tetep bisa di-scroll (keliatan lebih clean) */
.hide-scrollbar::-webkit-scrollbar {
  display: none;
}
.hide-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
