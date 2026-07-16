<template>
  <div class="animate-fade-in min-h-screen pb-10">
    <!-- Hero Section -->
    <!-- Hero Section (Carousel Style) -->
    <header class="relative py-32 px-6 text-center overflow-hidden min-h-[600px] flex items-center justify-center border-b border-slate-800/50">
      
      <!-- Carousel Backgrounds (Crossfade) -->
      <div v-for="(slide, index) in heroSlides" :key="index"
           :class="['absolute inset-0 transition-opacity duration-1000 ease-in-out', currentSlide === index ? 'opacity-100' : 'opacity-0']">
        <!-- Overlay gelap & efek jaring biar teks tetap terbaca -->
        <div class="absolute inset-0 bg-slate-900/75 z-10"></div>
        <div class="absolute inset-0 bg-[linear-gradient(rgba(16,185,129,0.05)_1px,transparent_1px),linear-gradient(90deg,rgba(16,185,129,0.05)_1px,transparent_1px)] bg-[size:40px_40px] z-10 pointer-events-none"></div>
        <!-- Gambar Asli (Bisa pakai link dari internet atau aset lokal) -->
        <img :src="slide.image" alt="Hero Background" class="w-full h-full object-cover" />
      </div>

      <!-- Glow Element (Tetap ada) -->
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] bg-emerald-500/20 blur-[120px] rounded-full pointer-events-none animate-pulse z-10"></div>

      <!-- Content Utama (Teks berubah otomatis mengikuti slide) -->
      <div class="relative max-w-3xl mx-auto z-20">
        <div :class="['inline-block mb-6 px-4 py-1.5 rounded-full border border-emerald-500/30 bg-emerald-500/10 text-emerald-300 text-sm font-semibold tracking-wide transition-all duration-700 ease-out', isLoaded ? 'opacity-100 scale-100' : 'opacity-0 scale-50']">
          {{ heroSlides[currentSlide].badge }}
        </div>
        
        <h1 :class="['text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight transition-all duration-700 ease-out', isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10']">
          {{ heroSlides[currentSlide].titleTop }} <br>
          <span class="bg-gradient-to-r from-emerald-400 to-teal-200 bg-clip-text text-transparent">
            {{ heroSlides[currentSlide].titleBottom }}
          </span>
        </h1>
        
        <p :class="['text-lg text-slate-300 mb-10 leading-relaxed max-w-2xl mx-auto transition-all duration-700 ease-out', isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10']">
          {{ heroSlides[currentSlide].desc }}
        </p>
        
        <div :class="['transition-all duration-700 ease-out', isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10']">
          <button class="bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold py-4 px-10 rounded-full shadow-[0_0_20px_rgba(16,185,129,0.3)] hover:shadow-[0_0_30px_rgba(16,185,129,0.5)] hover:-translate-y-1 transition-all duration-300 transform">
            {{ heroSlides[currentSlide].btnText }}
          </button>
        </div>

        <!-- Carousel Indicators (Titik-titik Navigasi Manual) -->
        <div class="flex items-center justify-center gap-3 mt-12">
          <button v-for="(slide, index) in heroSlides" :key="'dot-'+index"
                  @click="setSlide(index)"
                  :class="['h-2 rounded-full transition-all duration-500', currentSlide === index ? 'w-8 bg-emerald-400' : 'w-2 bg-slate-600 hover:bg-slate-400']">
          </button>
        </div>
      </div>
    </header>

    <section class="py-10 px-6 max-w-4xl mx-auto relative">
      <p class="text-center text-slate-500 text-xs font-mono tracking-widest uppercase mb-12">Collaborating For Wanajaya</p>
      
      <!-- Container Logo -->
      <div class="flex items-center justify-center gap-12 relative">
        <!-- Logo Desa -->
        <button @click="togglePartner('desa')" class="hover:scale-110 transition-transform">
          <img src="/Images/LogoDesa.png" alt="Logo Desa" class="h-24 w-auto object-contain" />
        </button>
        
        <!-- Icon X -->
        <span class="text-slate-700 font-black text-2xl">×</span>
        
        <!-- Logo KKN -->
        <button @click="togglePartner('kkn')" class="hover:scale-110 transition-transform">
          <img src="/Images/LogoKKN.png" alt="Logo KKN UBP" class="h-24 w-auto object-contain" />
        </button>
      </div>

      <!-- Penjelasan Muncul (Slide Effect) -->
      <!-- Full-screen Overlay Penjelasan -->
    <transition enter-active-class="transition-all duration-700 ease-out" 
                enter-from-class="opacity-0" 
                enter-to-class="opacity-100" 
                leave-active-class="transition-all duration-500 ease-in" 
                leave-from-class="opacity-100" 
                leave-to-class="opacity-0">
      
      <div v-if="activePartner" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-slate-950/90 backdrop-blur-md" @click="activePartner = null">
        
        <!-- Konten Penjelasan (Muncul sesuai partner) -->
        <div class="max-w-xl w-full text-center p-8 border border-emerald-500/30 bg-slate-900 rounded-3xl relative" @click.stop>
          
          <!-- Tombol Close -->
          <button @click="activePartner = null" class="absolute top-4 right-4 text-slate-500 hover:text-white">✕</button>

          <!-- Isi Konten Desa -->
          <div v-if="activePartner === 'desa'" class="animate-in fade-in slide-in-from-left duration-700">
             <img src="/Images/LogoDesa.png" class="h-24 mx-auto mb-6" />
             <h3 class="text-3xl font-bold text-white mb-4">Pemerintah Desa Wanajaya</h3>
             <p class="text-slate-400 leading-relaxed">Lembaga pemerintahan yang menaungi seluruh administrasi dan pelayanan masyarakat di wilayah Desa Wanajaya.</p>
          </div>

          <!-- Isi Konten KKN -->
          <div v-if="activePartner === 'kkn'" class="animate-in fade-in slide-in-from-right duration-700">
             <img src="/Images/LogoKKN.png" class="h-24 mx-auto mb-6" />
             <h3 class="text-3xl font-bold text-white mb-4">KKN Mahasiswa UBP Karawang</h3>
             <p class="text-slate-400 leading-relaxed">Program pengabdian masyarakat oleh mahasiswa Informatika UBP untuk mewujudkan transformasi digital Desa Wanajaya.</p>
          </div>
        </div>
      </div>
    </transition>
    </section>

    <!-- Fitur Section -->
    <section class="py-20 px-6 max-w-6xl mx-auto border-t border-slate-800">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div v-for="(feature, index) in features" :key="index" class="group relative">
          
          <!-- Cek apakah ini fitur 'Edukasi Pintar' -->
          <a v-if="feature.title === 'Edukasi Pintar'" href="/edukasi-sampah" class="block">
            <div class="bg-slate-800/40 backdrop-blur-sm p-8 rounded-2xl border border-slate-700/50 hover:border-emerald-500/50 hover:bg-slate-800 transition-all duration-500 hover:-translate-y-3 cursor-pointer">
              <div class="w-16 h-16 bg-gradient-to-br from-emerald-500/20 to-teal-500/10 rounded-2xl flex items-center justify-center text-4xl mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 border border-emerald-500/10">
                {{ feature.icon }}
              </div>
              <h3 class="text-xl font-bold text-white mb-3 group-hover:text-emerald-400 transition-colors">{{ feature.title }}</h3>
              <p class="text-slate-400 leading-relaxed text-sm">{{ feature.desc }}</p>
            </div>
          </a>

          <!-- Selain itu, tampilkan div biasa -->
          <div v-else class="bg-slate-800/40 backdrop-blur-sm p-8 rounded-2xl border border-slate-700/50 hover:border-emerald-500/50 hover:bg-slate-800 transition-all duration-500 hover:-translate-y-3">
            <div class="w-16 h-16 bg-gradient-to-br from-emerald-500/20 to-teal-500/10 rounded-2xl flex items-center justify-center text-4xl mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 border border-emerald-500/10">
              {{ feature.icon }}
            </div>
            <h3 class="text-xl font-bold text-white mb-3 group-hover:text-emerald-400 transition-colors">{{ feature.title }}</h3>
            <p class="text-slate-400 leading-relaxed text-sm">{{ feature.desc }}</p>
          </div>
          
        </div>
      </div>
    </section>

    <!-- Hot News / Berita Terkini Section -->
    <section class="py-20 px-6 max-w-6xl mx-auto border-t border-slate-800">
      <!-- Header Berita -->
      <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
        <div>
          <span class="inline-block py-1 px-3 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 font-bold tracking-widest uppercase text-xs mb-4">
            Hot News
          </span>
          <h2 class="text-3xl md:text-4xl font-bold text-white">Kabar Desa Terbaru</h2>
        </div>
        <a href="#" class="text-emerald-400 hover:text-emerald-300 font-medium text-sm flex items-center gap-2 transition-colors group/link">
          <span>Lihat Semua Berita</span>
          <span class="group-hover/link:translate-x-1 transition-transform">→</span>
        </a>
      </div>

      <!-- Grid Berita (3 Kolom) -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div v-for="news in newsList" :key="news.id" class="bg-slate-800/30 rounded-3xl border border-slate-700/50 overflow-hidden hover:border-emerald-500/30 hover:shadow-[0_10px_30px_rgba(16,185,129,0.1)] transition-all duration-500 group flex flex-col">
          
          <!-- Image Placeholder (Nanti ganti pakai tag img kalau dari DB) -->
          <div :class="['h-48 w-full bg-gradient-to-br relative overflow-hidden', news.imageColor]">
            <div class="absolute inset-0 bg-slate-900/20 group-hover:bg-transparent transition-colors duration-500"></div>
            <div class="absolute inset-0 flex items-center justify-center text-slate-500/30 text-6xl group-hover:scale-110 transition-transform duration-700">
              📰
            </div>
            <!-- Kategori Badge -->
            <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md border border-slate-700 py-1.5 px-4 rounded-full text-xs font-bold text-white tracking-wider">
              {{ news.category }}
            </div>
          </div>
          
          <!-- Content Berita -->
          <div class="p-6 flex flex-col flex-grow">
            <div class="text-xs text-slate-400 mb-3 flex items-center gap-2">
              <span>🗓️</span> {{ news.date }}
            </div>
            <h3 class="text-xl font-bold text-white mb-3 group-hover:text-emerald-400 transition-colors line-clamp-2 leading-snug">
              {{ news.title }}
            </h3>
            <p class="text-slate-400 text-sm leading-relaxed mb-6 line-clamp-3 flex-grow">
              {{ news.excerpt }}
            </p>
            <a href="#" class="inline-flex items-center gap-2 text-sm text-emerald-400 hover:text-emerald-300 font-medium group/btn mt-auto w-fit">
              <span>Baca Selengkapnya</span>
              <span class="group-hover/btn:translate-x-1 transition-transform">→</span>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Layanan Darurat & Kontak Section -->
    <section class="py-20 px-6 max-w-6xl mx-auto border-t border-slate-800">
      <div class="text-center mb-16">
        <span class="inline-block py-1 px-3 rounded-full bg-red-500/10 border border-red-500/20 text-red-400 font-bold tracking-widest uppercase text-xs mb-4">
          Hotline & Bantuan
        </span>
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Kontak Otoritas Terkait</h2>
        <p class="text-slate-400 max-w-2xl mx-auto text-sm md:text-base leading-relaxed">
          Akses cepat bagi warga lokal, WNA, maupun instansi luar untuk menghubungi layanan darurat dan pemerintah Desa Wanajaya.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Balai Desa -->
        <div class="bg-slate-800/30 p-6 rounded-2xl border border-slate-700/50 hover:border-emerald-500/50 hover:bg-slate-800/80 hover:shadow-[0_0_20px_rgba(16,185,129,0.1)] transition-all duration-300 group">
          <div class="w-12 h-12 bg-emerald-500/10 text-emerald-400 rounded-xl flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform">🏛️</div>
          <h3 class="text-lg font-bold text-white mb-1">Balai Desa</h3>
          <p class="text-xs text-slate-400 mb-5 line-clamp-2">Pusat informasi dan administrasi tata kelola desa.</p>
          <a href="#" class="inline-flex items-center gap-2 text-sm text-emerald-400 hover:text-emerald-300 font-medium group/link">
            <span>Hubungi via WA</span>
            <span class="group-hover/link:translate-x-1 transition-transform">→</span>
          </a>
        </div>

        <!-- PDAM -->
        <div class="bg-slate-800/30 p-6 rounded-2xl border border-slate-700/50 hover:border-blue-500/50 hover:bg-slate-800/80 hover:shadow-[0_0_20px_rgba(59,130,246,0.1)] transition-all duration-300 group">
          <div class="w-12 h-12 bg-blue-500/10 text-blue-400 rounded-xl flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform">💧</div>
          <h3 class="text-lg font-bold text-white mb-1">PDAM</h3>
          <p class="text-xs text-slate-400 mb-5 line-clamp-2">Layanan keluhan dan gangguan air bersih.</p>
          <a href="#" class="inline-flex items-center gap-2 text-sm text-blue-400 hover:text-blue-300 font-medium group/link">
            <span>Call Center PDAM</span>
            <span class="group-hover/link:translate-x-1 transition-transform">→</span>
          </a>
        </div>

        <!-- PLN -->
        <div class="bg-slate-800/30 p-6 rounded-2xl border border-slate-700/50 hover:border-yellow-500/50 hover:bg-slate-800/80 hover:shadow-[0_0_20px_rgba(234,179,8,0.1)] transition-all duration-300 group">
          <div class="w-12 h-12 bg-yellow-500/10 text-yellow-400 rounded-xl flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform">⚡</div>
          <h3 class="text-lg font-bold text-white mb-1">PLN</h3>
          <p class="text-xs text-slate-400 mb-5 line-clamp-2">Laporan gangguan instalasi dan pemadaman listrik.</p>
          <a href="tel:123" class="inline-flex items-center gap-2 text-sm text-yellow-400 hover:text-yellow-300 font-medium group/link">
            <span>Call Center 123</span>
            <span class="group-hover/link:translate-x-1 transition-transform">→</span>
          </a>
        </div>

        <!-- Keamanan / Polsek -->
        <div class="bg-slate-800/30 p-6 rounded-2xl border border-slate-700/50 hover:border-red-500/50 hover:bg-slate-800/80 hover:shadow-[0_0_20px_rgba(239,68,68,0.1)] transition-all duration-300 group">
          <div class="w-12 h-12 bg-red-500/10 text-red-400 rounded-xl flex items-center justify-center text-2xl mb-5 group-hover:scale-110 transition-transform">🚓</div>
          <h3 class="text-lg font-bold text-white mb-1">Keamanan</h3>
          <p class="text-xs text-slate-400 mb-5 line-clamp-2">Darurat, Bhabinkamtibmas, dan Polsek setempat.</p>
          <a href="tel:110" class="inline-flex items-center gap-2 text-sm text-red-400 hover:text-red-300 font-medium group/link">
            <span>Darurat 110</span>
            <span class="group-hover/link:translate-x-1 transition-transform">→</span>
          </a>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const activePartner = ref(null); // 'desa', 'kkn', atau null

const togglePartner = (partner) => {
  // Kalau yang diklik sama, tutup penjelasannya (toggle off)
  activePartner.value = activePartner.value === partner ? null : partner;
};

// State untuk load animasi dan urutan slide
const isLoaded = ref(false);
const currentSlide = ref(0);
let slideInterval = null;

// Data Konten Carousel (Gambar & Teks bisa lu custom)
const heroSlides = [
  {
    image: 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=2070', // Placeholder gambar lingkungan
    badge: '✨ Inovasi Proker Digital',
    titleTop: 'Pilah Sampah,',
    titleBottom: 'Rawat Wanajaya.',
    desc: 'Platform edukasi dan pendataan sampah terpadu. Ubah kebiasaan kecil menjadi dampak besar untuk lingkungan yang lebih bersih dan bernilai.',
    btnText: 'Mulai Kontribusi'
  },
  {
    image: 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2013', // Placeholder gambar alam hijau
    badge: '🚀 Pemberdayaan Desa',
    titleTop: 'Ekonomi Mandiri,',
    titleBottom: 'Warga Sejahtera.',
    desc: 'Wujudkan sirkulasi ekonomi desa lewat bank sampah dan program UMKM hijau yang terintegrasi secara digital.',
    btnText: 'Lihat Program'
  },
  {
    image: 'https://images.unsplash.com/photo-1473172088513-89689df9c4d3?q=80&w=2072', // Placeholder gambar kolaborasi
    badge: '🤝 Kolaborasi KKN',
    titleTop: 'Sinergi Cerdas,',
    titleBottom: 'Desa Maju.',
    desc: 'Membangun ekosistem teknologi desa yang berkelanjutan bersama para mahasiswa dan aparatur pemerintah desa Wanajaya.',
    btnText: 'Kenali Kami'
  }
];

const features = [
  { icon: '🌱', title: 'Edukasi Pintar', desc: 'Panduan interaktif cara memilah sampah.' },
  { icon: '📊', title: 'Data Transparan', desc: 'Pantau statistik jumlah sampah desa.' },
  { icon: '💰', title: 'Sirkulasi Ekonomi', desc: 'Tukar sampah menjadi kas desa.' }
];

// TAMBAHKAN KODE INI KEMBALI:
const newsList = [
  {
    id: 1,
    title: 'Peluncuran Program Bank Sampah Digital Desa Wanajaya',
    excerpt: 'Pemerintah desa resmi meluncurkan sistem pengelolaan sampah berbasis digital hasil kolaborasi dengan mahasiswa KKN untuk meningkatkan ekonomi warga.',
    date: '15 Jul 2026',
    category: 'Inovasi',
    imageColor: 'from-emerald-500/40 to-teal-500/10'
  },
  {
    id: 2,
    title: 'Gotong Royong Bersihkan Aliran Sungai Cibeet',
    excerpt: 'Warga desa Wanajaya kompak melakukan kerja bakti massal membersihkan bantaran sungai Cibeet menjelang datangnya musim penghujan.',
    date: '12 Jul 2026',
    category: 'Lingkungan',
    imageColor: 'from-blue-500/40 to-cyan-500/10'
  },
  {
    id: 3,
    title: 'Penyuluhan Pertanian Organik Bersama Mahasiswa UBP',
    excerpt: 'Mahasiswa Universitas Buana Perjuangan (UBP) mengadakan penyuluhan pembuatan pupuk kompos dari limbah rumah tangga untuk para petani lokal.',
    date: '10 Jul 2026',
    category: 'Edukasi',
    imageColor: 'from-orange-500/40 to-yellow-500/10'
  }
];

// Fungsi untuk mengganti slide secara manual jika titik di-klik
const setSlide = (index) => {
  currentSlide.value = index;
  resetInterval(); // Reset waktu supaya gak langsung keganti pas baru di-klik
};

// Fungsi auto-play carousel (Ganti slide tiap 5 detik)
const startInterval = () => {
  slideInterval = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % heroSlides.length;
  }, 5000);
};

const resetInterval = () => {
  clearInterval(slideInterval);
  startInterval();
};

onMounted(() => {
  setTimeout(() => {
    isLoaded.value = true;
  }, 100);
  
  // Jalankan carousel saat halaman diload
  startInterval();
});

// Hapus interval jika berpindah halaman biar memori gak bocor
onUnmounted(() => {
  if (slideInterval) clearInterval(slideInterval);
});
</script>
