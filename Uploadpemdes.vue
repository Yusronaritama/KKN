<template>
  <div class="min-h-screen bg-slate-950 p-6 md:p-10 font-sans text-slate-200">
    <div class="max-w-7xl mx-auto space-y-8">
      
      <!-- Header -->
      <div class="bg-slate-900/40 backdrop-blur-xl border border-slate-700/50 rounded-3xl p-6 md:p-8 flex items-center justify-between">
        <div>
          <a href="/admin/dashboard" class="text-emerald-400 text-xs hover:text-emerald-300 mb-2 inline-flex items-center gap-2 font-mono">
            <span>←</span> Kembali ke Dasbor
          </a>
          <h1 class="text-2xl md:text-3xl font-black text-white flex items-center gap-3">
            <span class="text-emerald-500">👔</span> Kelola Aparatur Desa Wanajaya
          </h1>
          <p class="text-slate-400 text-xs md:text-sm mt-1">Tambah, edit, atau hapus data pengurus desa, kepala dusun, dan RT/RW secara real-time.</p>
        </div>
      </div>

      <!-- GRID UTAMA: Kiri Form (Tambah/Edit), Kanan List Aktif -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- KOLOM KIRI: FORM DINAMIS (Span 5) -->
        <div class="lg:col-span-5 bg-slate-900/40 backdrop-blur-xl border border-slate-700/50 rounded-3xl p-6 md:p-8 relative overflow-hidden shadow-2xl h-fit">
          <div class="absolute top-0 right-0 w-48 h-48 bg-emerald-500/10 blur-[80px] pointer-events-none"></div>

          <div class="flex items-center justify-between mb-6 border-b border-slate-800 pb-3">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
              <span>{{ isEditMode ? '✏️ Edit Aparatur' : '➕ Tambah Aparatur Baru' }}</span>
            </h2>
            <button v-if="isEditMode" @click="resetForm" class="text-xs text-amber-400 hover:underline font-mono">
              Batal Edit
            </button>
          </div>

          <form @submit.prevent="submitPemdes" class="space-y-5">
            
            <!-- Input Nama -->
            <div>
              <label class="block text-xs font-bold font-mono text-slate-300 uppercase tracking-wider mb-2">Nama Lengkap</label>
              <input v-model="form.nama" type="text" required placeholder="Contoh: Budi Santoso"
                     class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all" />
            </div>

            <!-- Input Wilayah -->
            <div>
              <label class="block text-xs font-bold font-mono text-slate-300 uppercase tracking-wider mb-2">Wilayah Penugasan</label>
              <select v-model="form.wilayah" required
                      class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all cursor-pointer">
                <option value="" disabled>-- Pilih Wilayah --</option>
                <option value="Utama">Pemerintah Utama (Pusat Desa / Kades / Kasi / Kaur)</option>
                <option value="Dusun I">Wilayah Dusun I</option>
                <option value="Dusun II">Wilayah Dusun II</option>
              </select>
            </div>

            <!-- Input Jabatan -->
            <div>
              <label class="block text-xs font-bold font-mono text-slate-300 uppercase tracking-wider mb-2">Jabatan</label>
              <select v-model="form.jabatan" required
                      class="w-full bg-slate-950/50 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all cursor-pointer">
                <option value="" disabled>-- Pilih Jabatan --</option>
                <optgroup label="Pimpinan & Kemitraan" class="bg-slate-900 text-emerald-400">
                  <option value="Kepala Desa" class="text-white">Kepala Desa</option>
                  <option value="BPD Desa" class="text-white">BPD Desa</option>
                </optgroup>
                <optgroup label="Sekretariat" class="bg-slate-900 text-emerald-400">
                  <option value="Sekretaris Desa" class="text-white">Sekretaris Desa</option>
                </optgroup>
                <optgroup label="Perangkat Inti (Kasi & Kaur)" class="bg-slate-900 text-emerald-400">
                  <option value="Kasie Pelayanan" class="text-white">Kasie Pelayanan</option>
                  <option value="Kasie Kesejahteraan" class="text-white">Kasie Kesejahteraan</option>
                  <option value="Kasie Pemerintahan" class="text-white">Kasie Pemerintahan</option>
                  <option value="Kaur Keuangan" class="text-white">Kaur Keuangan</option>
                  <option value="Kaur Umum dan Perencanaan" class="text-white">Kaur Umum dan Perencanaan</option>
                </optgroup>
                <optgroup label="Kewilayahan" class="bg-slate-900 text-emerald-400">
                  <option value="Kepala Dusun" class="text-white">Kepala Dusun</option>
                  <option value="Ketua RW" class="text-white">Ketua RW</option>
                  <option value="Ketua RT" class="text-white">Ketua RT</option>
                </optgroup>
              </select>
            </div>

            <!-- Input Foto -->
            <div>
              <label class="block text-xs font-bold font-mono text-slate-300 uppercase tracking-wider mb-2">
                Foto Profil <span class="text-slate-500 font-normal">(Opsional)</span>
              </label>
              <div class="mt-1 flex justify-center px-4 pt-4 pb-4 border-2 border-slate-700 border-dashed rounded-xl hover:border-emerald-500 transition-colors bg-slate-950/50 relative overflow-hidden group">
                <div v-if="!imagePreview" class="space-y-1 text-center relative z-10">
                  <div class="text-3xl mb-1">📸</div>
                  <label class="relative cursor-pointer text-emerald-400 hover:text-emerald-300 font-medium text-xs">
                    <span>Upload foto</span>
                    <input type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg" @change="handleImageUpload">
                  </label>
                  <p class="text-[10px] text-slate-500">Max 10MB</p>
                </div>
                <div v-else class="relative w-24 h-24 rounded-full overflow-hidden border-2 border-emerald-500">
                  <img :src="imagePreview" class="w-full h-full object-cover object-top" />
                  <button type="button" @click="removeImage" class="absolute inset-0 bg-slate-900/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-white text-[10px] font-bold">
                    Ganti
                  </button>
                </div>
                <input v-if="imagePreview" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" accept="image/jpeg,image/png,image/jpg" @change="handleImageUpload">
              </div>
            </div>

            <!-- Submit & Cancel Button -->
            <div class="pt-2 flex gap-3">
              <button type="submit" :disabled="isSubmitting" 
                      class="flex-1 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs py-3 px-4 rounded-xl transition-all disabled:opacity-50 uppercase tracking-wider font-mono shadow-[0_0_15px_rgba(16,185,129,0.3)]">
                <span v-if="!isSubmitting">{{ isEditMode ? 'Simpan Perubahan 💾' : 'Simpan Data 🚀' }}</span>
                <span v-else>Memproses... ⏳</span>
              </button>
              <button v-if="isEditMode" type="button" @click="resetForm" 
                      class="px-4 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-mono">
                Batal
              </button>
            </div>

          </form>
        </div>

        
        <!-- KOLOM KANAN: LIST PEMDES BERDASARKAN WILAYAH (Span 7) -->
        <div class="lg:col-span-7 bg-slate-900/40 backdrop-blur-xl border border-slate-700/50 rounded-3xl p-6 md:p-8 flex flex-col h-[750px] shadow-2xl">
          <div class="flex items-center justify-between mb-6 border-b border-slate-800 pb-3">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
              <span>👥</span> Daftar Aparatur Berdasarkan Wilayah
            </h2>
            <span class="text-xs font-mono text-emerald-400">Total: {{ daftarPemdes.length }} Orang</span>
          </div>

          <!-- Container List Dikelompokkan Per Wilayah dengan Scroll -->
          <div class="flex-1 overflow-y-auto pr-2 space-y-6 custom-scrollbar">
            
            <!-- Looping Berdasarkan Grup Wilayah -->
            <div v-for="(grup, namaWilayah) in pemdesTergrup" :key="namaWilayah" class="space-y-3">
              
              <!-- Header Wilayah -->
              <div class="flex items-center justify-between bg-slate-950/80 border border-slate-800 px-4 py-2 rounded-xl sticky top-0 z-10 backdrop-blur-md">
                <h3 class="text-xs font-bold font-mono text-emerald-400 uppercase tracking-wider flex items-center gap-2">
                  <span>📍</span> {{ namaWilayah }}
                </h3>
                <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-slate-800 text-slate-300">
                  {{ grup.length }} Pengurus
                </span>
              </div>

              <!-- Item Pengurus dalam Wilayah Tersebut -->
              <div class="space-y-2.5 pl-2">
                <div 
                  v-for="(item, index) in grup" 
                  :key="index"
                  class="bg-slate-950/40 border border-slate-800/60 hover:border-slate-700 rounded-2xl p-3.5 flex items-center justify-between gap-4 transition-all group"
                >
                  <div class="flex items-center gap-3.5 min-w-0">
                    <!-- Foto Profil -->
                    <img :src="item.image ? '/' + item.image : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200&auto=format&fit=crop'" 
                        class="w-11 h-11 rounded-full object-cover object-top border-2 border-slate-800 shrink-0" />
                    
                    <!-- Info Teks -->
                    <div class="min-w-0">
                      <h4 class="font-bold text-xs md:text-sm text-white truncate">{{ item.nama }}</h4>
                      <div class="flex items-center gap-2 mt-1">
                        <span class="text-[9px] font-mono px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 uppercase">
                          {{ item.jabatan }}
                        </span>
                      </div>
                    </div>
                  </div>

                  <!-- Tombol Edit & Hapus -->
                  <div class="flex items-center gap-2 shrink-0">
                    <button 
                      @click="editPemdes(item)"
                      title="Edit Data"
                      class="p-2 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/30 hover:bg-amber-500 hover:text-slate-950 transition-all text-xs flex items-center justify-center shadow-md"
                    >
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                      </svg>
                    </button>
                    <button 
                      @click="hapusPemdes(item.id)"
                      title="Hapus Data"
                      class="p-2 rounded-xl bg-red-500/10 text-red-400 border border-red-500/30 hover:bg-red-500 hover:text-slate-950 transition-all text-xs flex items-center justify-center shadow-md"
                    >
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </div>

                </div>
              </div>

            </div>

            <!-- Kalau Kosong -->
            <div v-if="daftarPemdes.length === 0" class="text-center py-32 text-slate-600 font-mono text-xs">
              Belum ada data aparatur desa tersimpan.
            </div>

          </div>
        </div>

      </div>

    </div>
  </div>

  <!-- Toast Notif -->
  <Transition name="toast">
    <div v-if="toastNotif.show" 
         :class="['fixed top-10 right-10 z-[9999] px-6 py-4 rounded-2xl border backdrop-blur-xl shadow-2xl flex items-center gap-4 transition-all min-w-[300px]', 
                  toastNotif.type === 'success' ? 'bg-emerald-950/80 border-emerald-500/50' : 'bg-red-950/80 border-red-500/50']">
      <div :class="['w-10 h-10 rounded-full flex items-center justify-center text-xl shrink-0', 
                    toastNotif.type === 'success' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-red-500/20 text-red-400']">
        {{ toastNotif.type === 'success' ? '✨' : '⚠️' }}
      </div>
      <div>
        <h4 class="font-bold text-white text-sm">{{ toastNotif.title }}</h4>
        <p :class="['text-xs mt-0.5', toastNotif.type === 'success' ? 'text-emerald-400/80' : 'text-red-400/80']">
          {{ toastNotif.message }}
        </p>
      </div>
    </div>
  </Transition>
</template>

<style scoped>

.toast-enter-active, .toast-leave-active { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
.toast-enter-from, .toast-leave-to { opacity: 0; transform: translateY(-20px) scale(0.95); }

.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #020617; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
</style>

<script setup>

import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const form = ref({ nama: '', jabatan: '', wilayah: '' });
const imageFile = ref(null);
const imagePreview = ref(null);
const isSubmitting = ref(false);
const isEditMode = ref(false);
const editId = ref(null);
const daftarPemdes = ref([]);

const toastNotif = ref({ show: false, type: 'success', title: '', message: '' });

const showToast = (type, title, message) => {
  toastNotif.value = { show: true, type, title, message };
  setTimeout(() => { toastNotif.value.show = false; }, 3000);
};

// Ambil list pemdes dari database
const fetchPemdes = async () => {
  try {
    const res = await axios.get('/api/pemdes/all');
    daftarPemdes.value = res.data;
  } catch (err) {
    console.error("Gagal mengambil data pemdes:", err);
  }
};

onMounted(() => {
  fetchPemdes();
});

const pemdesTergrup = computed(() => {
  return daftarPemdes.value.reduce((grup, item) => {
    // Ambil nilai wilayah, jika kosong masukin ke kategori 'Lainnya'
    const wilayah = item.wilayah || 'Wilayah Lainnya';
    if (!grup[wilayah]) {
      grup[wilayah] = [];
    }
    grup[wilayah].push(item);
    return grup;
  }, {});
});

const handleImageUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    if (file.size > 10 * 1024 * 1024) {
      showToast('error', 'Ukuran Terlalu Besar!', 'Maksimal ukuran file foto adalah 10MB.');
      event.target.value = '';
      return;
    }
    imageFile.value = file;
    imagePreview.value = URL.createObjectURL(file);
  }
};

const removeImage = () => {
  imageFile.value = null;
  imagePreview.value = null;
};

const resetForm = () => {
  form.value.nama = '';
  form.value.jabatan = '';
  form.value.wilayah = '';
  removeImage();
  isEditMode.value = false;
  editId.value = null;
};

// Mode Edit: Masukin data ke form
const editPemdes = (item) => {
  isEditMode.value = true;
  editId.value = item.id;
  form.value.nama = item.nama;
  form.value.jabatan = item.jabatan;
  form.value.wilayah = item.wilayah;
  imagePreview.value = item.image ? '/' + item.image : null;
  imageFile.value = null;
  window.scrollTo({ top: 0, behavior: 'smooth' });
};

// Submit (Bisa untuk Tambah atau Update)
const submitPemdes = async () => {
  isSubmitting.value = true;
  let formData = new FormData();
  formData.append('nama', form.value.nama);
  formData.append('jabatan', form.value.jabatan);
  formData.append('wilayah', form.value.wilayah);

  if (imageFile.value) {
    formData.append('image', imageFile.value);
  }

  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
      axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
    }
    
    let url = '/admin/pemdes/store';
    if (isEditMode.value) {
      url = `/admin/pemdes/update/${editId.value}`;
    }

    const response = await axios.post(url, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    
    showToast('success', isEditMode.value ? 'Berhasil Diperbarui!' : 'Berhasil Disimpan!', response.data?.message || 'Data berhasil diproses.');
    resetForm();
    fetchPemdes(); // Refresh list secara real-time
    
  } catch (error) {
    console.error(error);
    let pesanError = "Terjadi kesalahan pada server.";
    if (error.response?.data?.message) {
        pesanError = error.response.data.message;
    }
    showToast('error', 'Gagal Memproses!', pesanError);
  } finally {
    isSubmitting.value = false;
  }
};

// Hapus Aparatur
const hapusPemdes = (id) => {
  if (confirm("Yakin nih mau menghapus data aparatur desa ini?")) {
    axios.delete(`/admin/pemdes/${id}`)
      .then(response => {
        showToast('success', 'Berhasil Dihapus!', 'Data aparatur desa telah dihapus.');
        fetchPemdes();
      })
      .catch(error => {
        console.error("Gagal menghapus:", error);
        showToast('error', 'Gagal Hapus!', 'Terjadi kesalahan saat menghapus data.');
      });
  }
};
</script>
