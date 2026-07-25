<template>
  <div class="min-h-screen bg-slate-950 p-6 md:p-12 font-sans text-slate-300">
    
    <div class="w-full max-w-7xl mx-auto space-y-8">
      
      <!-- Header & Tombol Kembali -->
      <div class="flex items-center justify-between bg-slate-900/40 backdrop-blur-xl border border-slate-700/50 rounded-3xl p-6 md:p-8">
        <div>
          <a href="/admin/dashboard" class="text-emerald-400 text-xs hover:text-emerald-300 mb-2 inline-flex items-center gap-2 font-mono">
            <span>←</span> Kembali ke Dasbor
          </a>
          <h2 class="text-2xl md:text-3xl font-black text-white">Kelola & Upload Berita Desa</h2>
          <p class="text-slate-400 text-xs md:text-sm mt-1">Berita yang di-upload akan langsung tampil di halaman depan website Wanajaya.</p>
        </div>
      </div>

      <!-- GRID UTAMA: Kiri Form, Kanan List Berita Aktif -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- KOLOM KIRI: FORM UPLOAD (Span 6) -->
        <div class="lg:col-span-6 bg-slate-900/40 backdrop-blur-xl border border-slate-700/50 rounded-3xl p-6 md:p-8 relative overflow-hidden shadow-2xl h-fit">
          <div class="absolute top-0 right-0 w-48 h-48 bg-emerald-500/10 blur-[80px] pointer-events-none"></div>

          <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2 border-b border-slate-800 pb-3">
            <span>✍️</span> Form Publikasi Berita
          </h3>

          <form @submit.prevent="submitNews" class="space-y-5">
            
            <!-- Judul Berita -->
            <div>
              <label class="block text-xs font-bold font-mono text-slate-300 uppercase tracking-wider mb-2">Judul Berita</label>
              <input v-model="form.title" type="text" required placeholder="Contoh: Panen Raya Petani Wanajaya" 
                     class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all">
            </div>

            <!-- Kategori -->
            <div>
              <label class="block text-xs font-bold font-mono text-slate-300 uppercase tracking-wider mb-2">Kategori</label>
              <select v-model="form.kategori" class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all">
                <option value="Inovasi">Inovasi</option>
                <option value="Lingkungan">Lingkungan</option>
                <option value="Edukasi">Edukasi</option>
                <option value="Infrastruktur">Infrastruktur</option>
                <option value="Kesehatan">Kesehatan</option>
                <option value="Ekonomi">Ekonomi</option>
              </select>
            </div>

            <!-- Caption / Isi Berita -->
            <div>
              <div class="flex justify-between mb-2">
                <label class="block text-xs font-bold font-mono text-slate-300 uppercase tracking-wider">Isi Berita / Caption</label>
                <span :class="{'text-red-400': form.caption.length > 1000, 'text-slate-500': form.caption.length <= 1000}" class="text-xs font-mono">
                  {{ form.caption.length }}/1000
                </span>
              </div>
              <textarea v-model="form.caption" rows="4" required maxlength="1000" placeholder="Tulis rincian berita di sini..."
                        class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all resize-none"></textarea>
            </div>

            <!-- Upload Cover -->
            <div>
              <label class="block text-xs font-bold font-mono text-slate-300 uppercase tracking-wider mb-2">Foto / Cover Berita</label>
              <div class="w-full h-40 rounded-xl border-2 border-dashed border-slate-700 bg-slate-950/50 flex flex-col items-center justify-center relative overflow-hidden group hover:border-emerald-500/50 transition-colors">
                <img v-if="imagePreview" :src="imagePreview" class="absolute inset-0 w-full h-full object-cover z-0" />
                <div v-else class="text-center p-4 z-10 pointer-events-none">
                  <span class="text-2xl">📸</span>
                  <p class="text-xs text-slate-400 mt-1 font-medium group-hover:text-emerald-400 transition-colors">Klik atau Drag & Drop foto</p>
                  <p class="text-[10px] text-slate-500 mt-0.5">PNG, JPG max 2MB</p>
                </div>
                <input type="file" @change="handleFileUpload" accept="image/png, image/jpeg, image/jpg" required
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
              </div>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" :disabled="isSubmitting" 
                    class="w-full bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm py-3.5 px-6 rounded-xl transition-all hover:shadow-[0_0_20px_rgba(16,185,129,0.3)] disabled:opacity-50 flex items-center justify-center gap-2 uppercase tracking-wider font-mono">
              <span v-if="!isSubmitting">Publikasikan Berita 🚀</span>
              <span v-else>Mengunggah... ⏳</span>
            </button>

          </form>
        </div>

        <!-- KOLOM KANAN: LIST BERITA AKTIF (Span 6) -->
        <div class="lg:col-span-6 bg-slate-900/40 backdrop-blur-xl border border-slate-700/50 rounded-3xl p-6 md:p-8 flex flex-col h-[700px] shadow-2xl">
          <div class="flex items-center justify-between mb-6 border-b border-slate-800 pb-3">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
              <span>📰</span> Berita Aktif ({{ daftarBerita.length }})
            </h3>
            <span class="text-xs font-mono text-emerald-400">Real-time DB</span>
          </div>

          <!-- Container List Scrollable -->
          <div class="flex-1 overflow-y-auto pr-2 space-y-3 custom-scrollbar">
            
            <div 
              v-for="(item, index) in daftarBerita" 
              :key="index"
              class="bg-slate-950/60 border border-slate-800/80 hover:border-slate-700 rounded-2xl p-4 flex items-start gap-4 transition-all relative group"
            >
              <!-- Gambar Thumbnail -->
              <img :src="item.image ? '/' + item.image : item.gambar" class="w-16 h-16 rounded-xl object-cover border border-slate-800 shrink-0" />
              
              <!-- Konten Teks -->
              <div class="flex-1 min-w-0 pr-10">
                <div class="flex items-center justify-between gap-2 mb-1">
                  <h4 class="font-bold text-sm text-white truncate">{{ item.title }}</h4>
                  <span class="text-[9px] font-mono px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 uppercase shrink-0">
                    {{ item.kategori }}
                  </span>
                </div>
                <p class="text-xs text-slate-400 line-clamp-2 mb-2 font-mono">{{ item.caption }}</p>
                <div class="text-[10px] text-slate-500 font-mono">
                  📅 Dipublikasikan
                </div>
              </div>

              <!-- Tombol Hapus Berita -->
              <div class="absolute right-4 bottom-4">
                <button 
                  @click="hapusBerita(item.id)"
                  title="Hapus Berita"
                  class="p-2 rounded-xl bg-red-500/10 text-red-400 border border-red-500/30 hover:bg-red-500 hover:text-slate-950 transition-all text-xs flex items-center justify-center shadow-lg"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </div>

            </div>

            <!-- Kalau Kosong -->
            <div v-if="daftarBerita.length === 0" class="text-center py-32 text-slate-600 font-mono text-xs">
              Belum ada berita yang dipublikasikan.
            </div>

          </div>
        </div>

      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const form = ref({
  title: '',
  kategori: 'Inovasi',
  caption: ''
});

const imageFile = ref(null);
const imagePreview = ref(null);
const isSubmitting = ref(false);
const daftarBerita = ref([]);

// Ambil list berita dari database
const fetchBerita = async () => {
  try {
    const res = await axios.get('/api/news/all');
    daftarBerita.value = res.data;
  } catch (err) {
    console.error("Gagal mengambil data berita:", err);
  }
};

onMounted(() => {
  fetchBerita();
});

const handleFileUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    if (file.size > 2 * 1024 * 1024) {
      window.dispatchEvent(new CustomEvent('show-toast', { 
        detail: { type: 'error', title: 'File Kebesaran!', message: 'Maksimal ukuran foto berita cuma 2MB dawg.' } 
      }));
      event.target.value = '';
      return;
    }
    imageFile.value = file;
    imagePreview.value = URL.createObjectURL(file);
  }
};

const submitNews = async () => {
  if (form.value.caption.length > 1000) {
    window.dispatchEvent(new CustomEvent('show-toast', { 
      detail: { type: 'error', title: 'Teks Kepanjangan!', message: 'Caption berita maksimal 1000 karakter aja.' } 
    }));
    return;
  }

  isSubmitting.value = true;

  let formData = new FormData();
  formData.append('title', form.value.title);
  formData.append('kategori', form.value.kategori);
  formData.append('caption', form.value.caption);
  formData.append('image', imageFile.value);

  try {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    const response = await axios.post('/admin/news/store', formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    
    window.dispatchEvent(new CustomEvent('show-toast', { 
      detail: { type: 'success', title: 'Berita Mengudara!', message: response.data.message || 'Berita berhasil dipublikasikan.' } 
    }));
    
    // Reset form & refresh list otomatis
    form.value.title = '';
    form.value.caption = '';
    imageFile.value = null;
    imagePreview.value = null;
    fetchBerita();
    
  } catch (error) {
    console.error(error);
    let pesanError = "Gagal upload berita ke server.";
    if (error.response && error.response.data && error.response.data.message) {
        pesanError = error.response.data.message;
    }
    window.dispatchEvent(new CustomEvent('show-toast', { 
      detail: { type: 'error', title: 'Gagal Upload!', message: pesanError } 
    }));
  } finally {
    isSubmitting.value = false;
  }
};

// Fungsi Hapus Berita
const hapusBerita = (id) => {
  if (confirm("Yakin nih mau ngapus berita ini dari website, dawg?")) {
    axios.delete(`/admin/news/${id}`)
      .then(response => {
        window.dispatchEvent(new CustomEvent('show-toast', { 
          detail: { type: 'success', title: 'Berita Dihapus!', message: 'Berita berhasil dihapus dari sistem.' } 
        }));
        fetchBerita();
      })
      .catch(error => {
        console.error("Gagal menghapus berita:", error);
        window.dispatchEvent(new CustomEvent('show-toast', { 
          detail: { type: 'error', title: 'Gagal Hapus!', message: 'Terjadi kesalahan saat menghapus berita.' } 
        }));
      });
  }
};
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #020617; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
</style>
