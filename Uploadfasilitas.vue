<template>
  <div class="min-h-screen bg-[#0F1410] p-6 font-sans text-[#E7E4D6] relative [font-family:'Plus_Jakarta_Sans',sans-serif]">

    <!-- Contour background -->
    <div class="fixed inset-0 pointer-events-none opacity-[0.07]" style="background-image: radial-gradient(circle at 20% 30%, transparent 0 60px, #9CB84E 61px, transparent 62px), radial-gradient(circle at 20% 30%, transparent 0 110px, #9CB84E 111px, transparent 112px), radial-gradient(circle at 80% 75%, transparent 0 90px, #9CB84E 91px, transparent 92px), radial-gradient(circle at 80% 75%, transparent 0 150px, #9CB84E 151px, transparent 152px); background-size: 100% 100%;"></div>

    <div class="max-w-5xl mx-auto space-y-8 relative">

      <!-- Header -->
      <div class="flex items-center justify-between border-b border-[#2A3324] pb-5">
        <div>
          <div class="flex items-center gap-2 text-[10px] font-bold tracking-[0.2em] text-[#9CB84E] uppercase [font-family:'IBM_Plex_Mono',monospace] mb-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-[#9CB84E]"></span>
            Register Fasilitas &middot; Desa
          </div>
          <h1 class="text-2xl font-bold text-[#F3F1E7] [font-family:'Space_Grotesk',sans-serif] tracking-tight">
            Kelola &amp; Tambah Fasilitas
          </h1>
          <p class="text-[#8B9382] text-xs mt-1">Catat titik fasilitas baru dan pantau daftar lokasi aktif di database.</p>
        </div>
        <a
          href="/admin/dashboard"
          class="px-4 py-2.5 rounded-lg bg-[#171D14] border border-[#2A3324] hover:border-[#9CB84E]/50 text-[#C7C9BB] text-[11px] font-semibold [font-family:'IBM_Plex_Mono',monospace] tracking-wide uppercase transition-colors flex items-center gap-2"
        >
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
          Kembali
        </a>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- FORM -->
        <div class="lg:col-span-6 bg-[#141910] border border-[#2A3324] rounded-2xl p-6 shadow-2xl relative h-fit">
          <span class="absolute top-3 left-3 w-2.5 h-2.5 border-t border-l border-[#9CB84E]/40"></span>
          <span class="absolute top-3 right-3 w-2.5 h-2.5 border-t border-r border-[#9CB84E]/40"></span>
          <span class="absolute bottom-3 left-3 w-2.5 h-2.5 border-b border-l border-[#9CB84E]/40"></span>
          <span class="absolute bottom-3 right-3 w-2.5 h-2.5 border-b border-r border-[#9CB84E]/40"></span>

          <h2 class="text-xs font-bold text-[#F3F1E7] uppercase tracking-[0.15em] mb-5 pb-3 border-b border-[#2A3324] flex items-center gap-2 [font-family:'IBM_Plex_Mono',monospace]">
            <svg class="w-3.5 h-3.5 text-[#9CB84E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Titik Lokasi Baru
          </h2>

          <form @submit.prevent="submitForm" class="space-y-4">

            <div>
              <label class="block text-[10px] font-bold [font-family:'IBM_Plex_Mono',monospace] text-[#9CAA92] uppercase tracking-[0.12em] mb-1.5">
                Nama Lokasi <span class="text-[#C98A4B]">&middot; wajib</span>
              </label>
              <input
                type="text"
                v-model="form.namalokasi"
                required
                placeholder="Contoh: Kantor Desa Wanajaya"
                class="w-full bg-[#0F1410] border border-[#2A3324] rounded-lg px-4 py-2.5 text-xs text-[#F3F1E7] placeholder-[#5A6152] focus:outline-none focus:border-[#9CB84E] focus:ring-1 focus:ring-[#9CB84E]/30 transition-colors"
              >
            </div>

            <div>
              <label class="block text-[10px] font-bold [font-family:'IBM_Plex_Mono',monospace] text-[#9CAA92] uppercase tracking-[0.12em] mb-1.5">
                Kategori <span class="text-[#C98A4B]">&middot; wajib</span>
              </label>
              <select
                v-model="form.kategori"
                required
                class="w-full bg-[#0F1410] border border-[#2A3324] rounded-lg px-4 py-2.5 text-xs text-[#F3F1E7] focus:outline-none focus:border-[#9CB84E] focus:ring-1 focus:ring-[#9CB84E]/30 transition-colors appearance-none bg-[url('data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20fill%3D%22none%22%20stroke%3D%22%238B9382%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20stroke-width%3D%222%22%20d%3D%22M19%209l-7%207-7-7%22/%3E%3C/svg%3E')] bg-no-repeat bg-[right_0.9rem_center] bg-[length:14px]"
              >
                <option disabled value="">Pilih Kategori</option>
                <option value="Pemerintahan">Pemerintahan</option>
                <option value="Kesehatan">Kesehatan</option>
                <option value="Aparat">Aparat (Polisi &amp; Tentara)</option>
              </select>
            </div>

            <div>
              <label class="block text-[10px] font-bold [font-family:'IBM_Plex_Mono',monospace] text-[#9CAA92] uppercase tracking-[0.12em] mb-1.5">
                Titik Koordinat (Lat, Long) <span class="text-[#C98A4B]">&middot; wajib</span>
              </label>
              <div class="relative">
                <svg class="w-3.5 h-3.5 absolute left-3.5 top-1/2 -translate-y-1/2 text-[#9CB84E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <input
                  type="text"
                  v-model="form.coordinate"
                  required
                  placeholder="-6.394075, 107.222941"
                  class="w-full bg-[#0F1410] border border-[#2A3324] rounded-lg pl-10 pr-4 py-2.5 text-xs text-[#9CB84E] placeholder-[#5A6152] focus:outline-none focus:border-[#9CB84E] focus:ring-1 focus:ring-[#9CB84E]/30 [font-family:'IBM_Plex_Mono',monospace] tracking-wide transition-colors"
                >
              </div>
            </div>

            <div>
              <label class="block text-[10px] font-bold [font-family:'IBM_Plex_Mono',monospace] text-[#9CAA92] uppercase tracking-[0.12em] mb-1.5">
                Nomor HP / Kontak <span class="text-[#6B7263] font-normal normal-case">opsional</span>
              </label>
              <input
                type="text"
                v-model="form.nomerhp"
                placeholder="081234567890"
                class="w-full bg-[#0F1410] border border-[#2A3324] rounded-lg px-4 py-2.5 text-xs text-[#F3F1E7] placeholder-[#5A6152] focus:outline-none focus:border-[#9CB84E] focus:ring-1 focus:ring-[#9CB84E]/30 [font-family:'IBM_Plex_Mono',monospace] transition-colors"
              >
            </div>

            <div>
              <label class="block text-[10px] font-bold [font-family:'IBM_Plex_Mono',monospace] text-[#9CAA92] uppercase tracking-[0.12em] mb-1.5">
                Deskripsi Singkat <span class="text-[#6B7263] font-normal normal-case">opsional</span>
              </label>
              <textarea
                v-model="form.deskripsi"
                rows="2"
                placeholder="Jelaskan fungsi atau detail fasilitas..."
                class="w-full bg-[#0F1410] border border-[#2A3324] rounded-lg px-4 py-2.5 text-xs text-[#F3F1E7] placeholder-[#5A6152] focus:outline-none focus:border-[#9CB84E] focus:ring-1 focus:ring-[#9CB84E]/30 transition-colors resize-none"
              ></textarea>
            </div>

            <div>
              <label class="block text-[10px] font-bold [font-family:'IBM_Plex_Mono',monospace] text-[#9CAA92] uppercase tracking-[0.12em] mb-1.5">
                Foto Lokasi <span class="text-[#6B7263] font-normal normal-case">opsional</span>
              </label>
              <input
                type="file"
                @change="handleFileUpload"
                accept="image/*"
                class="w-full bg-[#0F1410] border border-[#2A3324] rounded-lg px-3 py-2 text-[11px] text-[#9CAA92] file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-[#9CB84E]/15 file:text-[#9CB84E] hover:file:bg-[#9CB84E]/25 transition-all cursor-pointer"
              >
            </div>

            <div class="pt-3 border-t border-[#2A3324] flex justify-end">
              <button
                type="submit"
                class="w-full py-3 rounded-lg bg-[#9CB84E] hover:bg-[#AFC963] text-[#0F1410] font-bold text-xs uppercase tracking-[0.1em] transition-colors flex items-center justify-center gap-2"
              >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Fasilitas
              </button>
            </div>

          </form>
        </div>

        <!-- LIST -->
        <div class="lg:col-span-6 bg-[#141910] border border-[#2A3324] rounded-2xl p-6 shadow-2xl flex flex-col h-[650px] relative">
          <span class="absolute top-3 left-3 w-2.5 h-2.5 border-t border-l border-[#9CB84E]/40"></span>
          <span class="absolute top-3 right-3 w-2.5 h-2.5 border-t border-r border-[#9CB84E]/40"></span>
          <span class="absolute bottom-3 left-3 w-2.5 h-2.5 border-b border-l border-[#9CB84E]/40"></span>
          <span class="absolute bottom-3 right-3 w-2.5 h-2.5 border-b border-r border-[#9CB84E]/40"></span>

          <div class="flex items-center justify-between mb-4 pb-3 border-b border-[#2A3324]">
            <h2 class="text-xs font-bold text-[#F3F1E7] uppercase tracking-[0.15em] flex items-center gap-2 [font-family:'IBM_Plex_Mono',monospace]">
              <svg class="w-3.5 h-3.5 text-[#9CB84E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              Lokasi Aktif ({{ daftarFasilitas.length }})
            </h2>
            <span class="text-[9px] [font-family:'IBM_Plex_Mono',monospace] text-[#6B7263] flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 rounded-full bg-[#9CB84E] animate-pulse"></span>
              real-time
            </span>
          </div>

          <div class="flex-1 overflow-y-auto pr-1 space-y-2.5 custom-scrollbar">

            <div
              v-for="(item, index) in daftarFasilitas"
              :key="index"
              class="bg-[#0F1410] border border-[#2A3324] hover:border-[#9CB84E]/40 rounded-xl p-3.5 flex items-start gap-3 transition-colors relative group"
            >
              <img :src="item.gambar" class="w-12 h-12 rounded-lg object-cover border border-[#2A3324] shrink-0" />

              <div class="flex-1 min-w-0 pr-11">
                <div class="flex items-center justify-between gap-2 mb-1">
                  <h3 class="font-bold text-xs text-[#F3F1E7] truncate">{{ item.nama }}</h3>
                  <span :class="['text-[8px] [font-family:\'IBM_Plex_Mono\',monospace] px-2 py-0.5 rounded-full border uppercase shrink-0 flex items-center gap-1', item.kategori === 'Kesehatan' ? 'bg-[#4FAE8C]/10 text-[#4FAE8C] border-[#4FAE8C]/30' : item.kategori === 'Aparat' ? 'bg-[#C98A4B]/10 text-[#C98A4B] border-[#C98A4B]/30' : 'bg-[#5B8FBF]/10 text-[#5B8FBF] border-[#5B8FBF]/30']">
                    <span class="w-1 h-1 rounded-full bg-current"></span>
                    {{ item.kategori }}
                  </span>
                </div>
                <p class="text-[10px] text-[#8B9382] line-clamp-1 mb-1.5">{{ item.deskripsi || 'Tanpa deskripsi' }}</p>
                <div class="flex items-center justify-between text-[9px] text-[#6B7263] [font-family:'IBM_Plex_Mono',monospace]">
                  <span class="flex items-center gap-1">
                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ item.kordinat[0] }}, {{ item.kordinat[1] }}
                  </span>
                  <span v-if="item.nomerhp" class="text-[#9CB84E] flex items-center gap-1">
                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ item.nomerhp }}
                  </span>
                </div>
              </div>

              <div class="absolute right-3 bottom-3">
                <button
                  @click="hapusFasilitas(item.id)"
                  title="Hapus Lokasi"
                  class="p-1.5 rounded-md bg-[#C9584B]/10 text-[#C9584B] border border-[#C9584B]/30 hover:bg-[#C9584B] hover:text-[#0F1410] transition-colors text-xs flex items-center justify-center"
                >
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </div>

            </div>

            <div v-if="daftarFasilitas.length === 0" class="text-center py-20 text-[#5A6152] [font-family:'IBM_Plex_Mono',monospace] text-xs flex flex-col items-center gap-3">
              <svg class="w-8 h-8 text-[#2A3324]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              Belum ada data fasilitas tersimpan di database.
            </div>

          </div>
        </div>

      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';

const form = reactive({
  namalokasi: '',
  kategori: '',
  coordinate: '',
  nomerhp: '',
  deskripsi: '',
  image: null
});

const daftarFasilitas = ref([]);

const fetchFasilitas = async () => {
  try {
    const res = await axios.get('/api/fasilitas/all');
    daftarFasilitas.value = res.data;
  } catch (err) {
    console.error("Gagal mengambil data fasilitas:", err);
  }
};

onMounted(() => {
  fetchFasilitas();
});

const handleFileUpload = (event) => {
  form.image = event.target.files[0];
};

const submitForm = () => {
  const formData = new FormData();
  formData.append('namalokasi', form.namalokasi);
  formData.append('kategori', form.kategori);
  formData.append('coordinate', form.coordinate);
  if (form.nomerhp) formData.append('nomerhp', form.nomerhp);
  if (form.deskripsi) formData.append('deskripsi', form.deskripsi);
  if (form.image) formData.append('image', form.image);

  axios.post('/admin/fasilitas/store', formData, {
    headers: { 'Content-Type': 'multipart/form-data' }
  })
  .then(response => {
    alert("Mantap! Data fasilitas berhasil disimpan ke database dawg! 🚀");
    form.namalokasi = '';
    form.kategori = '';
    form.coordinate = '';
    form.nomerhp = '';
    form.deskripsi = '';
    form.image = null;
    fetchFasilitas();
  })
  .catch(error => {
    console.error("Gagal simpan:", error.response?.data || error);
    alert("Gagal nyimpen data, Cek console browser (F12) dawg!");
  });
};

const hapusFasilitas = (id) => {
  if (confirm("Yakin nih mau ngapus fasilitas ini dari database, dawg?")) {
    axios.delete(`/admin/fasilitas/${id}`)
      .then(response => {
        alert("Data fasilitas berhasil dihapus!");
        fetchFasilitas();
      })
      .catch(error => {
        console.error("Gagal menghapus:", error.response?.data || error);
        alert("Gagal menghapus data, cek console browser!");
      });
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap');

.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #0F1410; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #2A3324; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9CB84E; }
</style>
